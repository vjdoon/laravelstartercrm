<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total users card dashboard
        $totalUsers = User::count();

        
        $weeklyUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        return view('dashboard', compact('totalUsers', 'weeklyUsers'));
    }
}
