<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard() {
        return view('dashboard.admin-dashboard');
    }

    public function profesorDashboard() {
        return view('dashboard.profesor-dashboard');
    }
}
