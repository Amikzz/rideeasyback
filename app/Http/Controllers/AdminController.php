<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Person;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Handles administrative tasks and operations.
 *
 * This controller is responsible for managing administrative functionalities
 * such as adding buses, conductors, drivers, and managing schedules. It provides
 * methods for viewing and manipulating various aspects of the system.
 */
class AdminController extends Controller
{
    /**
     * Display the admin dashboard or redirect based on user type.
     *
     * Checks the authenticated user's type and displays the appropriate
     * dashboard.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function adminDashboard()
    {
        //check the user type
        if (Auth::user()->usertype == 'conductor') {
            return view('dashboard');
        }
        elseif (Auth::user()->usertype == 'admin') {
            return view('adminDashboard');
        }
    }

    /**
     * Display the form for adding a new bus.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function addBusView()
    {
        return view('admin.addBus');
    }

    /**
     * Store a newly created bus in storage.
     *
     * Validates the request data and creates a new bus record in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addBus(Request $request)
    {
        Validator::validate($request->all(), [
            'bus_license_plate_no' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer'],
            'route_id' => ['required', 'string', 'exists:route,route_id'],
            'bus_parked_venue' => ['required', 'string'],
            'bus_type' => ['required', 'string']
        ]);

        try {
            $bus = Bus::create([
                'bus_license_plate_no' => $request->bus_license_plate_no,
                'capacity' => $request->capacity,
                'status' => 'Active',
                'lastUpdateLocation' => now(),
                'route_id' => $request->route_id,
                'bus_parked_venue' => $request->bus_parked_venue,
                'bus_type' => $request->bus_type
            ]);

            return redirect()->route('addbus')->with('success', 'Bus added successfully');
        } catch (\Exception $e) {
            return redirect()->route('addbus')->with('error', 'An error occurred while adding bus');
        }
    }

    /**
     * Display the form for adding a new conductor.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function addConductorView()
    {
        return view('admin.addConductor');
    }

    /**
     * Store a newly created conductor in storage.
     *
     * Validates the request data and creates a new conductor user record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addConductor(Request $request)
    {
        Validator::validate($request->all(), [
            'conductor_id' => ['required', 'string'],
            'conductor_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string']
        ]);

        try {
            $conductor = User::create([
                'conductor_admin_id' => $request->conductor_id,
                'name' => $request->conductor_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => 'conductor'
            ]);

            return redirect()->route('addconductor')->with('success', 'Conductor added successfully');
        } catch (\Exception $e) {
            return redirect()->route('addconductor')->with('error', 'An error occurred while adding conductor');
        }
    }

    /**
     * Display the form for adding a new driver.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function addDriverView()
    {
        return view('admin.addDriver');
    }

    /**
     * Store a newly created driver in storage.
     *
     * Validates the request data and creates a new person and driver record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addDriver(Request $request)
    {
        Validator::validate($request->all(), [
            'driver_id' => ['required', 'string'],
            'id_number' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'password' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'phone_no' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);

        try {
            $driver = Person::create([
                'id_number' => $request->id_number,
                'driver_id' => $request->driver_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => bcrypt($request->password),
                'dob' => $request->dob,
                'gender' => $request->gender,
                'phone_no' => $request->phone_no,
                'address' => $request->address,
            ]);

            if($driver){
                Driver::create([
                    'id_number' => $request->id_number,
                    'driver_id' => $request->driver_id,
                ]);
            }

            return redirect()->route('adddriver')->with('success', 'Driver added successfully');
        } catch (\Exception $e) {
            return redirect()->route('adddriver')->with('error', 'An error occurred while adding driver');
        }
    }

    /**
     * Create a new daily schedule for all routes.
     *
     * Iterates through all existing routes and creates a new schedule
     * for the current day.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSchedule()
    {
        try {
            $routes = Route::all();

            foreach ($routes as $route) {
                $date = now()->format('Y-m-d');

                Schedule::create([
                    'schedule_id' => $date,
                    'route_id' => $route->route_id,
                    'date' => now(),
                ]);
            }
            return redirect()->route('dashboard')->with('success', 'Schedule created successfully');
        }catch (\Exception $e){
            return redirect()->route('dashboard')->with('error', 'An error occurred while adding a new schedule');
        }
    }

    /**
     * Display a list of all buses.
     *
     * Retrieves and displays a list of all buses. Can be filtered by license plate number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function viewBuses(Request $request)
    {
        try{
            $busLicensePlateNo = $request->input('bus_license_plate_no');

            $query = DB::table('bus')
                ->select('bus.*');

            if ($busLicensePlateNo) {
                $query->where('bus.bus_license_plate_no', $busLicensePlateNo);
            }

            $buses = $query->get();

            return view('admin.viewBuses', compact('buses', 'busLicensePlateNo'));
        }catch (\Exception $e){
            return redirect()->route('admin.viewBuses')->with('error', 'An error occurred while viewing buses');
        }
    }

    /**
     * Inactivate a bus for maintenance.
     *
     * Marks a bus as 'Inactive' and adds a record to the maintenance table.
     *
     * @param  string  $bus_license_plate_no
     * @return \Illuminate\Http\RedirectResponse
     */
    public function inactivateBus($bus_license_plate_no)
    {
        try {
            DB::table('bus')
                ->where('bus_license_plate_no', $bus_license_plate_no)
                ->update([
                    'lastMaintain' => now(),
                    'status' => 'Inactive'
                ]);

            //add the bus to the busmaintain table
            DB::table('busmaintain')
                ->insert([
                    'bus_license_plate_no' => $bus_license_plate_no,
                    'status' => 'Under maintenance',
                    'date_in' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            return redirect()->route('viewbuses')->with('success', 'Bus inactivated successfully');
        } catch (\Exception $e) {
            return redirect()->route('viewbuses')->with('error', 'An error occurred while inactivating bus');
        }
    }

    /**
     * Activate a bus after maintenance.
     *
     * Marks a bus as 'Active' and removes its record from the maintenance table.
     *
     * @param  string  $bus_license_plate_no
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateBus($bus_license_plate_no)
    {
        try {
            DB::table('bus')
                ->where('bus_license_plate_no', $bus_license_plate_no)
                ->update(['status' => 'Active']);

            //remove the bus from the busmaintain table
            DB::table('busmaintain')
                ->where('bus_license_plate_no', $bus_license_plate_no)
                ->delete();

            return redirect()->route('viewbuses')->with('success', 'Bus activated successfully');
        } catch (\Exception $e) {
            return redirect()->route('viewbuses')->with('error', 'An error occurred while activating bus');
        }
    }

    /**
     * Display a list of all conductors.
     *
     * Retrieves and displays a list of all conductors. Can be filtered by conductor ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function viewConductors(Request $request)
    {
        try {
            $conductorID = $request->input('conductor_id');

            $query = DB::table('users')
                ->select('users.*')
                ->where('users.usertype', 'conductor');

            if ($conductorID) {
                $query = $query->where('users.conductor_admin_id', $conductorID);
            }

            $conductors = $query->get();

            return view('admin.viewconductors', compact('conductors', 'conductorID'))->with('success', 'Conductors viewed successfully');
        } catch (\Exception $e) {
            // Initialize $conductors to an empty collection to avoid undefined variable
            $conductors = collect();
            return view('admin.viewconductors', compact('conductors'))->with('error', 'An error occurred while viewing conductors');
        }
    }

    /**
     * Delete a conductor.
     *
     * @param  string  $conductor_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteConductor($conductor_id)
    {
        try {
            DB::table('users')
                ->where('conductor_admin_id', $conductor_id)
                ->delete();

            return redirect()->route('viewconductors')->with('success', 'Conductor deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('viewconductors')->with('error', 'An error occurred while deleting conductor');
        }
    }

    /**
     * Display a list of all drivers.
     *
     * Retrieves and displays a list of all drivers. Can be filtered by driver ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function viewDrivers(Request $request)
    {
        try {
            $driverID = $request->input('driver_id');

            $query = DB::table('person')
                ->select('person.*', 'driver.driver_id')
                ->join('driver', 'person.id_number', '=', 'driver.id_number');

            if ($driverID) {
                $query = $query->where('driver.driver_id', $driverID);
            }

            $drivers = $query->get();

            return view('admin.viewdrivers', compact('drivers', 'driverID'))->with('success', 'Drivers viewed successfully');
        } catch (\Exception $e) {
            // Initialize $drivers to an empty collection to avoid undefined variable
            $drivers = collect();
            return view('admin.viewdrivers', compact('drivers'))->with('error', 'An error occurred while viewing drivers');
        }
    }

    /**
     * Delete a driver.
     *
     * @param  string  $driver_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDriver($driver_id)
    {
        try {
            DB::table('driver')
                ->where('driver_id', $driver_id)
                ->delete();

            return redirect()->route('viewdrivers')->with('success', 'Driver deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('viewdrivers')->with('error', 'An error occurred while deleting driver');
        }
    }

    /**
     * Display a list of all schedules.
     *
     * Retrieves and displays a list of all schedules. Can be filtered by date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function viewSchedules(Request $request)
    {
        try {
            $scheduleDate = $request->input('schedule_date');

            $querry = DB::table('schedule')
                ->join('route', 'schedule.route_id', '=', 'route.route_id')
                ->select('schedule.*', 'route.route_number', 'route.start_location', 'route.end_location');

            if ($scheduleDate) {
                $querry = $querry->where('schedule.schedule_id', $scheduleDate);
            }

            $schedules = $querry->get();

            return view('admin.viewschedule', compact('schedules'))->with('success', 'Schedules viewed successfully');
        } catch (\Exception $e) {
            // Initialize $schedules to an empty collection to avoid undefined variable
            $schedules = collect();
            return view('admin.viewschedule', compact('schedules'))->with('error', 'An error occurred while viewing schedules');
        }
    }

    /**
     * Display a list of all user support requests.
     *
     * Retrieves and displays a list of all user support requests, ordered by status.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function viewSupportRequests()
    {
        try {
            // Modify the query to sort support requests by status
            $supportRequests = DB::table('support')
                ->select('support.*')
                ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END") // Sorting: 'pending' first, 'done' last
                ->get();

            return view('admin.supportrequests', compact('supportRequests'))->with('success', 'Support requests viewed successfully');
        } catch (\Exception $e) {
            // Initialize $supportRequests to an empty collection to avoid undefined variable
            $supportRequests = collect();
            return view('admin.supportrequests', compact('supportRequests'))->with('error', 'An error occurred while viewing support requests');
        }
    }

    /**
     * Mark a user support request as 'done'.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editSupportRequests($id)
    {
        try {
            DB::table('support')
                ->where('id', $id)
                ->update(['status' => 'done']);

            return redirect()->route('viewsupportrequests')->with('success', 'Support request status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('viewsupportrequests')->with('error', 'An error occurred while updating support request status');
        }
    }

    /**
     * Display a list of all conductor support requests.
     *
     * Retrieves and displays a list of all conductor support requests, ordered by status.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function viewConductorSupportRequests()
    {
        try {
            // Modify the query to sort support requests by status
            $supportRequestsConductor = DB::table('_conductor_support')
                ->select('_conductor_support.*')
                ->orderByRaw("CASE WHEN status = 'Pending' THEN 1 ELSE 2 END") // Sorting: 'pending' first, 'done' last
                ->get();

            return view('admin.supportrequestsconductor', compact('supportRequestsConductor'))->with('success', 'Support requests viewed successfully');
        } catch (\Exception $e) {
            // Initialize $supportRequests to an empty collection to avoid undefined variable
            $supportRequestsConductor = collect();
            return view('admin.supportrequestsconductor', compact('supportRequestsConductor'))->with('error', 'An error occurred while viewing support requests');
        }
    }

    /**
     * Mark a conductor support request as 'Done'.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editConductorSupportRequests($id)
    {
        try {
            DB::table('_conductor_support')
                ->where('id', $id)
                ->update(['status' => 'Done']);

            return redirect()->route('viewsupportrequestsconductor')->with('success', 'Support request status updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('viewsupportrequestsconductor')->with('error', 'An error occurred while updating support request status');
        }
    }

    /**
     * Display a list of all safety button records.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function viewSafetyButtonRecords()
    {
        try {
            $safetyButtonRecords = DB::table('safety_button')
                ->select('safety_button.*')
                ->get();

            return view('admin.safetybuttonrecords', compact('safetyButtonRecords'))->with('success', 'Safety button records viewed successfully');
        } catch (\Exception $e) {
            // Initialize $safetyButtonRecords to an empty collection to avoid undefined variable
            $safetyButtonRecords = collect();
            return view('admin.safetybuttonrecords', compact('safetyButtonRecords'))->with('error', 'An error occurred while viewing safety button records');
        }
    }

    /**
     * Display a list of all user reviews.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function viewUserReviews()
    {
        try {
            $userReviews = DB::table('review')
                ->select('review.*')
                ->get();

            return view('admin.viewreviews', compact('userReviews'))->with('success', 'User reviews viewed successfully');
        } catch (\Exception $e) {
            // Initialize $userReviews to an empty collection to avoid undefined variable
            $userReviews = collect();
            return view('admin.viewreviews', compact('userReviews'))->with('error', 'An error occurred while viewing user reviews');
        }
    }
}
