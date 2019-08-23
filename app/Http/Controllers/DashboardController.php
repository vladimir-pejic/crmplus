<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function landing()
    {
        return Inertia::render('Landing');
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard/Index');
    }
}
