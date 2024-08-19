<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\ReviewModel;
use App\Models\SupportModel;
use App\Models\Ticket;
use BaconQrCode\Encoder\QrCode;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class UserController extends Controller
{
    // View bus schedule
    public function viewBusSchedule(Request $request): JsonResponse
    {
        $date = $request->input('date');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $startLocation = $request->input('start_location');
        $endLocation = $request->input('end_location');

        // Initialize the query
        $query = DB::table('trip')
            ->join('busdriverconductor', 'trip.bus_with_driver_conductor_id', '=', 'busdriverconductor.bus_with_driver_conductor')
            ->join('schedule', 'trip.schedule_id', '=', 'schedule.schedule_id')
            ->join('route', 'schedule.route_id', '=', 'route.route_id')
            ->select(
                'trip.trip_id',
                'busdriverconductor.bus_license_plate_no',
                'route.start_location',
                'route.end_location',
                'schedule.date',
                'trip.departure_time',
                'trip.arrival_time'
            );

        // Filter by date, start time, and end time if provided
        if ($date && $startTime && $endTime) {
            $query->whereBetween('trip.departure_time', ["$date $startTime", "$date $endTime"]);
        } elseif ($date) {
            $query->whereDate('trip.departure_time', $date);
        } elseif ($startTime && $endTime) {
            $query->whereBetween(DB::raw('DATE_FORMAT(trip.departure_time, "%H:%i:%s")'), [$startTime, $endTime]);
        }

        // Filter by start location and end location if provided
        if ($startLocation && $endLocation) {
            $query->where('route.start_location', $startLocation)
                ->where('route.end_location', $endLocation);
        }

        $trips = $query->get();

        return response()->json($trips);
    }

    public function liveLocationTracking(Request $request): JsonResponse
    {
        $request->validate([
            'bus_license' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $busLicensePlate = $request->bus_license;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        // Attempt to update directly without retrieving first
        $affectedRows = DB::table('bus')
            ->where('bus_license_plate_no', $busLicensePlate)
            ->update([
                'latitude' => $latitude,
                'longitude' => $longitude,
                'lastUpdateLocation' => now()
            ]);

        if ($affectedRows > 0) {
            return response()->json(['status' => 'Location updated successfully']);
        } else {
            return response()->json(['error' => 'Bus not found.'], 404);
        }
    }

    public function locationget(Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $status = $request->status;

        // Retrieve all buses with the specified status using the DB facade
        $buses = DB::table('bus')
            ->select('bus_license_plate_no', 'latitude', 'longitude', 'lastUpdateLocation')
            ->where('status', $status)
            ->get();

        if ($buses->isEmpty()) {
            return response()->json(['error' => 'No buses found.'], 404);
        }

        // Return the bus locations as JSON
        return response()->json($buses);
    }

    public function reviewStore(Request $request): JsonResponse
    {
        // Validate the request data
        $request->validate([
            'user_id' => 'required|string',
            'bus_license' => 'required|string',
            'review' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        // Extract the validated data
        $user_id = $request->user_id;
        $busLicensePlate = $request->bus_license;
        $review = $request->review;
        $rating = $request->rating;

        // Check if the bus exists
        $busExists = DB::table('bus')
            ->where('bus_license_plate_no', $busLicensePlate)
            ->exists();

        // If the bus does not exist, return an error response
        if (!$busExists) {
            return response()->json(['error' => 'Bus not found.'], 404);
        }

        // Create the review if the bus exists
        ReviewModel::create([
            'user_id' => $user_id,
            'bus_license_plate_no' => $busLicensePlate,
            'review' => $review,
            'rating' => $rating,
        ]);

        // Return a success response
        return response()->json(['status' => 'Review updated successfully']);
    }

    public function supportRequest(Request $request): JsonResponse
    {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'issue' => 'required|string',
            ]
        );

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $issue = $request->issue;

        SupportModel::create(
            [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'issue' => $issue,
                'status' => 'pending',
            ]
        );
        return response()->json(['status' => 'Support request submitted successfully']);
    }


    //search bus and date and time
    public function searchBus(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_location' => 'required|string',
            'end_location' => 'required|string',
        ]);

        $date = $request->date;
        $startLocation = $request->start_location;
        $endLocation = $request->end_location;

        try {
            // Determine the status based on start and end locations
            $status = '';
            if ($startLocation == 'Colombo Fort' && $endLocation == 'Kottawa') {
                $status = 'Up';
            } elseif ($startLocation == 'Kottawa' && $endLocation == 'Colombo Fort') {
                $status = 'Down';
            } else {
                return response()->json(['error' => 'Invalid start or end location.'], 400);
            }

            // Query to get all trips with the given status and date
            $query = DB::table('trip')
                ->join('busdriverconductor', 'trip.bus_with_driver_conductor_id', '=', 'busdriverconductor.bus_with_driver_conductor')
                ->join('schedule', 'trip.schedule_id', '=', 'schedule.schedule_id')
                ->join('route', 'schedule.route_id', '=', 'route.route_id')
                ->select(
                    'trip.trip_id',
                    'busdriverconductor.bus_license_plate_no',
                    'route.start_location',
                    'route.end_location',
                    'schedule.date',
                    'trip.departure_time',
                    'trip.arrival_time',
                    'trip.no_of_tickets',
                    'trip.status'
                )
                ->where('trip.no_of_tickets', '<', 60)
                ->whereDate('schedule.date', $date)
                ->where('trip.status', $status);

            $trips = $query->get();

            // Transform the result set to adjust the start and end locations based on the status
            $trips->transform(function ($trip) use ($startLocation, $endLocation) {
                // Swap the start and end locations based on the trip status
                if ($trip->status === 'Down') {
                    $trip->start_location = $startLocation;
                    $trip->end_location = $endLocation;
                } else {
                    // Ensure that the locations are as expected for 'Up' status
                    $trip->start_location = $startLocation;
                    $trip->end_location = $endLocation;
                }
                return $trip;
            });

            if ($trips->isNotEmpty()) {
                return response()->json($trips)->setStatusCode(200);
            } else {
                return response()->json(['error' => 'No buses found.'], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while searching for buses.'], 500);
        }
    }


    //book ticket
    public function bookTicket(Request $request)
    {
        // Validate input
        $request->validate([
            'bus_license_plate_no' => 'required|exists:bus,bus_license_plate_no',
            'passenger_id' => 'required|string',
            'trip_id' => 'required|string',
            'start_location' => 'required|string',
            'end_location' => 'required|string',
            'date' => 'required|date',
            'departure_time' => 'required|date_format:H:i:s',
            'no_of_adults' => 'required|integer',
            'no_of_children' => 'required|integer',
            'total_fare' => 'required|integer',
        ]);

        // Check if the total number of tickets is more than 10
        $total_amount_of_tickets = $request->no_of_adults + $request->no_of_children;
        if ($total_amount_of_tickets > 10){
            return response()->json(['error' => 'You can\'t purchase more than 10 tickets at a time.'], 400);
        }

        //check if the same passenger has already booked a ticket for the same trip and limit the times a person can book a ticket to 3
        $ticket_count = DB::table('tickets')
            ->where('passenger_id', $request->passenger_id)
            ->where('trip_id', $request->trip_id)
            ->count();

        if ($ticket_count >= 3){
            return response()->json(['error' => 'You can\'t book more than 3 tickets for the same trip.'], 400);
        }

        // Get the current number of tickets available for the trip
        $no_of_tickets_database = DB::table('trip')
            ->where('trip_id', $request->trip_id)
            ->value('no_of_tickets'); // Retrieve the value directly

        if ($no_of_tickets_database === null) {
            return response()->json(['error' => 'Trip not found.'], 404);
        }

        // Check if the total number of tickets to be booked is more than the available tickets
        $no_of_tickets_after = $no_of_tickets_database + $total_amount_of_tickets;

        if ($no_of_tickets_after > 60) {
            return response()->json(['error' => 'No more tickets available for this trip.'], 400);
        }

        // Calculate the amount to be paid adult = 100 children = 50
        $adultAmount = $request->no_of_adults * 100;
        $childrenAmount = $request->no_of_children * 50;
        $totalAmount = $adultAmount + $childrenAmount;

        // Create a new ticket with a unique ID
        $ticket = Ticket::create([
            'bus_license_plate_no' => $request->bus_license_plate_no,
            'passenger_id' => $request->passenger_id,
            'trip_id' => $request->trip_id,
            'start_location' => $request->start_location,
            'end_location' => $request->end_location,
            'date' => $request->date,
            'departure_time' => $request->departure_time,
            'no_of_adults' => $request->no_of_adults,
            'no_of_children' => $request->no_of_children,
            'amount' => $totalAmount,
            'status' => 'Booked',
            'ticket_id' => Str::uuid(), // Generate a unique ticket ID
        ]);

        // Update the number of tickets available for the trip
        DB::table('trip')
            ->where('trip_id', $request->trip_id)
            ->increment('no_of_tickets', $total_amount_of_tickets); // Use decrement instead of increment

        // Return ticket details including ticket ID
        return response()->json([
            'ticket' => $ticket,
            'message' => 'Ticket booked successfully',
        ]);
    }



//    //safety button
//    public  function safetyButton(Request $request)
//    {
//        $request->validate([
//            'id_number' => 'required|string',
//            'passenger_id' => 'required|string',
//            'first_name' => 'required|string',
//            'last_name' => 'required|string',
//            'latitude' => 'required|numeric',
//            'longitude' => 'required|numeric',
//        ]);
//
//        try {
//            $id_number = $request->id_number;
//            $first_name = $request->first_name;
//            $last_name = $request->last_name;
//            $latitude = $request->latitude;
//            $longitude = $request->longitude;
//
//            // add these details to ane table called safety_button
//            DB::table('safety_button')->insert([
//                'id_number' => $id_number,
//                'first_name' => $first_name,
//                'last_name' => $last_name,
//                'latitude' => $latitude,
//                'longitude' => $longitude,
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ]);
//
//
////            // Send SMS alert using Twilio
////            $sid = env('TWILIO_SID');
////            $token = env('TWILIO_AUTH_TOKEN');
////            $twilioNumber = env('TWILIO_PHONE_NUMBER');
////            $client = new Client($sid, $token);
////
////            $client->messages->create(
////                '+18777804236', // Emergency contact number
////                [
////                    'from' => $twilioNumber,
////                    'body' => "Emergency Alert: User $first_name $last_name with ID number $id_number has pressed the safety button. Location: Latitude $latitude, Longitude $longitude."
////                ]
////            );
//
//
//            return response()->json(['status' => 'Safety button pressed successfully']);
//        }catch (\Exception $e){
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }

    //safety button test
    public function safetyButton(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string',
            'passenger_id' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            $id_number = $request->id_number;
            $passenger_id = $request->passenger_id;
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            //Get the current date
            //$currentDate = Carbon::now()->format('Y-m-d');
            $currentDate = '2024-07-18';
            $currentDate = Carbon::parse($currentDate);


            // Get the current time
            //$currentTime = Carbon::now();
            $currentTime = '11:18:00';
            $currentTime = Carbon::parse($currentTime);

            // Fetch the ticket for the given passenger_id
            $ticket = DB::table('tickets')
                ->where('passenger_id', $passenger_id)
                ->whereDate('date', $currentDate)
                ->where('status', 'Active')
                ->first();

            if ($ticket) {
                $departureTime = Carbon::parse($ticket->departure_time);
                $arrivalTime = $departureTime->copy()->addHours(2);

                // Check if current time is between departure and arrival time
                if ($currentTime->between($departureTime, $arrivalTime)) {
                    // Insert the safety button data into the safety_button table
                    DB::table('safety_button')->insert([
                        'id_number' => $id_number,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    // Send SMS alert using Twilio
                    $sid = env('TWILIO_SID');
                    $token = env('TWILIO_AUTH_TOKEN');
                    $twilioNumber = env('TWILIO_PHONE_NUMBER');
                    $client = new Client($sid, $token);

                    $client->messages->create(
                        '+18777804236', // Emergency contact number
                        [
                            'from' => $twilioNumber,
                            'body' => "Emergency Alert: User $first_name $last_name with ID number $id_number has pressed the safety button. Location: Latitude $latitude, Longitude $longitude."
                        ]
                    );

                    return response()->json(['status' => 'Safety button pressed successfully']);
                } else {
                    return response()->json(['error' => 'Safety button cannot be pressed outside of the valid time window'], 403);
                }
            } else {
                return response()->json(['error' => 'No valid ticket found for the user'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
