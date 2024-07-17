<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
