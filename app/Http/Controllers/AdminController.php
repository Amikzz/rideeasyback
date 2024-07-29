<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
}
