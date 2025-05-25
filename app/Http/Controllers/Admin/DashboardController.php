<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\Event;
use \App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $upcomingEvents = Event::where('scheduled_time', '>', now())->count();
        $pastEvents = Event::where('scheduled_time', '<', now())->count();
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();
        $totalAttendance = Event::withCount('participants')->get()->sum('participants_count');

        return view('admin.dashboard', compact(
            'totalEvents',
            'upcomingEvents',
            'pastEvents',
            'totalUsers',
            'adminCount',
            'userCount',
            'totalAttendance'
        ));
    }
}
