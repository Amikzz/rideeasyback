<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
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

    //adding a new bus
    public function addBusView()
    {
        return view('admin.addBus');
    }

    public function addBus(Request $request)
    {
        Validator::validate($request->all(), [
            'bus_license_plate_no' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer'],
        ]);

        try {
            $bus = Bus::create([
                'bus_license_plate_no' => $request->bus_license_plate_no,
                'capacity' => $request->capacity,
                'status' => 'active',
                'lastUpdateLocation' => now(),
            ]);

            return redirect()->route('addbus')->with('success', 'Bus added successfully');
        } catch (\Exception $e) {
            return redirect()->route('addbus')->with('error', 'An error occurred while adding bus');
        }
    }

    //adding a conductor
    public function addConductorView()
    {
        return view('admin.addConductor');
    }

    public function addConductor(Request $request)
    {
        Validator::validate($request->all(), [
            'conductor_id' => ['required', 'string'],
            'conductor_name' => ['required', 'string'],
            'email' => ['required', 'string'],
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

    //adding a new driver
    public function addDriverView()
    {
        return view('admin.addDriver');
    }

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
}
