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
        ]);

        // Extract the validated data
        $user_id = $request->user_id;
        $busLicensePlate = $request->bus_license;
        $review = $request->review;

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

        try{
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
                )
                ->where('route.start_location', $startLocation)
                ->where('route.end_location', $endLocation)
                ->whereDate('schedule.date', $date);

            $trips = $query->get();
            return response()->json($trips)->setStatusCode(200);
        }catch(\Exception $e){
            return response()->json(['error' => 'No buses found.'], 404);
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
        ]);

        // Create a new ticket with a unique ID
        $ticket = Ticket::create([
            'bus_license_plate_no' => $request->bus_license_plate_no,
            'passenger_id' => $request->passenger_id,
            'trip_id' => $request->trip_id,
            'start_location' => $request->start_location,
            'end_location' => $request->end_location,
            'date' => $request->date,
            'departure_time' => $request->departure_time,
            'status' => 'Booked',
            'ticket_id' => Str::uuid(), // Generate a unique ticket ID
        ]);

        // Return ticket details including ticket ID
        return response()->json([
            'ticket' => $ticket,
            'message' => 'Ticket booked successfully',]);
    }
}
