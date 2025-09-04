<?php

namespace App\Http\Controllers;

use App\Models\BusDriverConductor;
use App\Models\ConductorSupportModel;
use App\Models\Ticket;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Thread;

/**
 * Handles conductor-specific operations.
 *
 * This controller manages functionalities available to conductors, such as
 * registering rides, managing trips, validating tickets, and submitting
 * support requests.
 */
class ConductorController extends Controller
{
    /**
     * Display the form for adding a new ride.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
     */
    public function showAddRideForm(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('addride');
    }

    /**
     * Register a new bus, driver, and conductor assignment for the day.
     *
     * Validates the input and creates a new `BusDriverConductor` record.
     * It also assigns a series of trips for the day.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function busDriveConductorRegistration(Request $request)
    {
        $input = $request->all();

        // Validate input fields
        Validator::make($input, [
            'bus_license_plate_no' => ['required', 'string', 'max:255'],
            'driver_id' => ['required', 'string', 'max:255'],
            'conductor_id' => ['required', 'string', 'max:255'],
        ])->validate();

        try {
            // Check if bus license plate number exists for today
            $existingEntry = BusDriverConductor::where('bus_license_plate_no', $input['bus_license_plate_no'])
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($existingEntry) {
                return redirect()->route('addride')->with('error', 'Bus with this license plate number already registered for today.');
            }

            // If no existing entry, proceed with creating new BusDriverConductor entry
            $busdriverconductor = BusDriverConductor::create([
                'bus_with_driver_conductor' => Str::random(10),
                'date_time' => Carbon::now(),
                'bus_license_plate_no' => $input['bus_license_plate_no'],
                'driver_id' => $input['driver_id'],
                'conductor_id' => $input['conductor_id'],
            ]);

            // Assign trips
            $this->assignTrips($busdriverconductor);

            return redirect()->route('addride')->with('success', 'Bus with driver and conductor registered successfully');
        } catch (\Exception $e) {
            return redirect()->route('addride')->with('error', 'An error occurred while registering bus with driver and conductor');
        }
    }


    /**
     * Assign a series of trips to a bus-driver-conductor assignment.
     *
     * This private method dynamically creates a set number of trips for a given
     * `BusDriverConductor` record, scheduling them at regular intervals.
     *
     * @param  \App\Models\BusDriverConductor  $busDriverConductor
     * @return void
     */
    private function assignTrips(BusDriverConductor $busDriverConductor)
    {
        // Example logic to assign 6 trips for the day
        $tripsPerDay = 10;

        // Retrieve the created_at timestamp of the BusDriverConductor
        $createdAt = $busDriverConductor->created_at;

        // Use Carbon to handle time calculations
        $startTime = Carbon::parse($createdAt);
        $intervalMinutes = 120;

        for ($i = 0; $i < $tripsPerDay; $i++) {
            $trip = new Trip();
            $tripInt = $i + 1;
            $trip->trip_id = $busDriverConductor->bus_with_driver_conductor . '-' . $tripInt; // Concatenate bus_with_driver_conductor_id with trip number
            $trip->bus_with_driver_conductor_id = $busDriverConductor->bus_with_driver_conductor;

            // Determine status based on whether trip number is even or odd
            if ($tripInt % 2 == 0) {
                $trip->status = 'Up'; // Even number
            } else {
                $trip->status = 'Down'; // Odd number
            }

            $trip->departure_time = $startTime->format('Y-m-d H:i:s');
            $trip->arrival_time = $startTime->addMinutes($intervalMinutes)->format('Y-m-d H:i:s');
            $trip->process = 'Pending';
            $trip->save();
        }
    }

    /**
     * Display a list of trips.
     *
     * Retrieves and displays a list of trips, which can be filtered by bus license plate number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function viewTrips(Request $request)
    {
        $busLicensePlateNo = $request->input('bus_license_plate_no');

        // Join the tables and select the desired columns
        $query = DB::table('trip')
            ->join('busdriverconductor', 'trip.bus_with_driver_conductor_id', '=', 'busdriverconductor.bus_with_driver_conductor')
            ->join('schedule', 'trip.schedule_id', '=', 'schedule.schedule_id')
            ->select('trip.*', 'busdriverconductor.bus_license_plate_no', 'schedule.date');

        if ($busLicensePlateNo) {
            $query->where('busdriverconductor.bus_license_plate_no', $busLicensePlateNo);
        }

        $trips = $query->get();

        return view('viewtrips', compact('trips', 'busLicensePlateNo'));
    }

    /**
     * Start a trip.
     *
     * Updates the status of a trip to 'In Progress'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $trip_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function startTrip(Request $request, $trip_id): \Illuminate\Http\RedirectResponse
    {
        try {
            // Update the trip status to 'In Progress'
            DB::table('trip')
                ->where('trip_id', $trip_id)
                ->update(['process' => 'In Progress']);

            return redirect()->route('viewtrips')->with('success', 'Trip started! Remember to End the trip once you reach the destination.');
        } catch (\Exception $e) {
            Log::error('Error starting trip: ' . $e->getMessage());
            return redirect()->route('viewtrips')->with('error', 'Failed to start the trip.');
        }
    }

    /**
     * End a trip.
     *
     * Updates the status of a trip to 'Done'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $trip_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function endTrip(Request $request, $trip_id): \Illuminate\Http\RedirectResponse
    {
        try {
            // Update the trip status to 'Done'
            DB::table('trip')
                ->where('trip_id', $trip_id)
                ->update(['process' => 'Done']);

            return redirect()->route('viewtrips')->with('success', 'Trip Ended Successfully.');
        } catch (\Exception $e) {
            Log::error('Error ending trip: ' . $e->getMessage());
            return redirect()->route('viewtrips')->with('error', 'Failed to end the trip.');
        }
    }


    /**
     * Display the form for deleting a ride.
     *
     * Fetches and displays a list of today's trips for selection.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
     */
    public function showDeleteRideForm(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        // Get today's date
        $today = Carbon::today()->format('Y-m-d');

        // Fetch departure times and bus license plate numbers for trips scheduled today
        $departureTimes = DB::table('trip')
            ->join('busdriverconductor', 'trip.bus_with_driver_conductor_id', '=', 'busdriverconductor.bus_with_driver_conductor')
            ->whereDate('trip.departure_time', $today)
            ->select('trip.trip_id', 'trip.departure_time', 'busdriverconductor.bus_license_plate_no')
            ->get()
            ->mapWithKeys(function ($trip) {
                return [$trip->trip_id => $trip->bus_license_plate_no . ' - ' . $trip->departure_time];
            });

        return view('deleteride', compact('departureTimes'));
    }

    /**
     * Delete a ride.
     *
     * Deletes a trip if it is not within one hour of its departure time.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $trip_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRide(Request $request, $trip_id): \Illuminate\Http\RedirectResponse
    {
        try {
            // Validate the trip_id and retrieve the trip details
            $trip = DB::table('trip')->where('trip_id', $trip_id)->first();
            if (!$trip) {
                return redirect()->route('viewtrips')->with('error', 'Ride not found.');
            }

            // Check if the current time is within one hour of the departure time
//            $currentTime = '21:18:00';
//            $currentTime = Carbon::parse($currentTime);
            $currentTime = Carbon::now();
            $departureTime = Carbon::parse($trip->departure_time);

            if ($departureTime->diffInMinutes($currentTime, false) <= 60) {
                return redirect()->route('viewtrips')->with('error', 'Cannot delete the ride within one hour of departure.');
            }

            // Delete the trip
            DB::table('trip')->where('trip_id', $trip_id)->delete();

            return redirect()->route('viewtrips')->with('success', 'Ride deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting ride: ' . $e->getMessage());
            return redirect()->route('viewtrips')->with('error', 'Failed to delete the ride.');
        }
    }

    /**
     * Display the support form for conductors.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
     */
    public function showSupportForm(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application{
        return view('supportforconductors');
    }

    /**
     * Handle the submission of a conductor support request.
     *
     * Validates the input and creates a new conductor support request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function conductorSupportController(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $input = $request->all();

            // Validate input fields
            Validator::make($input, [
                'conductor_name' => ['required', 'string', 'max:255'],
                'conductor_id' => ['required', 'string', 'max:255'],
                'request' => ['required', 'string', 'max:255'],
            ])->validate();

            // Create a new support ticket
            ConductorSupportModel::create([
                'conductor_name' => $input['conductor_name'],
                'conductor_id' => $input['conductor_id'],
                'request' => $input['request'],
                'status' => 'Pending',
            ]);

            return redirect()->route('support')->with('success', 'Support Request Submitted Successfully');
        } catch (\Exception $e) {
            Log::error('Error creating support ticket: ' . $e->getMessage());
            return redirect()->route('support')->with('error', 'Failed to Submit the Support Request');
        }
    }

    /**
     * Display the ticket validation page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
     */
    public function showValidateTicketPage(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('tickets');
    }

    /**
     * Validate a ticket.
     *
     * Checks if a ticket is valid and marks it as 'Active'.
     * It also increments the count of validated tickets for the corresponding trip.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validateTicket(Request $request)
    {
        // Validate input
        $request->validate([
            'id' => 'required|integer',
        ]);

        DB::beginTransaction(); // Start a transaction

        try {
            // Retrieve the ticket based on the provided ID
            $ticket = DB::table('tickets')->where('id', $request->id)->first();

            if (!$ticket) {
                // Roll back the transaction if the ticket is not found
                DB::rollBack();
                return redirect()->route('validateticket')->with('error', 'Ticket not found');
            }

            // Check if the ticket is already active or booked
            if ($ticket->status === 'Active') {
                // If ticket is already active, return an error message
                DB::rollBack();
                return redirect()->route('validateticket')->with('error', 'This ticket has already been used.');
            } else {
                // Update the ticket status to active
                DB::table('tickets')->where('id', $request->id)->update(['status' => 'Active']);

                // Update the number of validated tickets in the trip table
                $tripUpdated = DB::table('trip')
                    ->where('trip_id', $ticket->trip_id)
                    ->increment('validated_tickets');

                if (!$tripUpdated) {
                    // If the trip update fails, roll back the transaction
                    DB::rollBack();
                    return redirect()->route('validateticket')->with('error', 'Failed to update trip information.');
                }

                // Commit the transaction
                DB::commit();

                // Flash the ticket details and success message
                session()->flash('ticket', $ticket);
                return redirect()->route('validateticket')->with('success', 'Ticket validated successfully');
            }
        } catch (\Exception $e) {
            // Roll back the transaction in case of error
            DB::rollBack();
            Log::error('Error validating ticket: ' . $e->getMessage());
            return redirect()->route('validateticket')->with('error', 'Failed to validate ticket');
        }
    }
}
