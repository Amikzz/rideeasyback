<?php

namespace App\Http\Controllers;


class AdminController extends Controller
{
    public function adminDashboard()
    {
        return view('dashboard');
    }


}
