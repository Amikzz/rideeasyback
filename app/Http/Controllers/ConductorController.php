<?php

namespace App\Http\Controllers;

use App\Models\BusDriverConductor;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Thread;

class ConductorController extends Controller
{
    //Bus_driver_conductor registration
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


    // Method to assign trips dynamically
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

    public function viewTrips(Request $request)
    {
        $busLicensePlateNo = $request->input('bus_license_plate_no');

        // Join the tables and select the desired columns
        $query = DB::table('trip')
            ->join('busdriverconductor', 'trip.bus_with_driver_conductor_id', '=', 'busdriverconductor.bus_with_driver_conductor')
            ->select('trip.*', 'busdriverconductor.bus_license_plate_no');

        if ($busLicensePlateNo) {
            $query->where('busdriverconductor.bus_license_plate_no', $busLicensePlateNo);
        }

        $trips = $query->get();

        return view('viewtrips', compact('trips', 'busLicensePlateNo'));
    }

    public function startTrip(Request $request, $trip_id): \Illuminate\Http\RedirectResponse
    {
        try {
            // Update the trip status to 'In Progress'
            DB::table('trip')
                ->where('trip_id', $trip_id)
                ->update(['process' => 'In Progress']);

            return redirect()->route('viewtrips')->with('success', 'Trip started and will be marked as done in 2 hours.');
        } catch (\Exception $e) {
            Log::error('Error starting trip: ' . $e->getMessage());
            return redirect()->route('viewtrips')->with('error', 'Failed to start the trip.');
        }
    }

    public function endTrip(Request $request, $trip_id): \Illuminate\Http\RedirectResponse
    {
        try {
            // Update the trip status to 'Done'
            DB::table('trip')
                ->where('trip_id', $trip_id)
                ->update(['process' => 'Done']);

            return redirect()->route('viewtrips')->with('success', 'Trip marked as done successfully.');
        } catch (\Exception $e) {
            Log::error('Error ending trip: ' . $e->getMessage());
            return redirect()->route('viewtrips')->with('error', 'Failed to end the trip.');
        }
    }


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

    public function deleteRide(Request $request, $trip_id): \Illuminate\Http\RedirectResponse
    {
        // Delete the selected trip
        DB::table('trip')->where('trip_id', $trip_id)->delete();

        return redirect()->route('deleteride')->with('success', 'Ride deleted successfully');
    }

}
