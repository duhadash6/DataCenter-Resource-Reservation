<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\Reservation;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Resource Statistics
        $totalResources = Resource::count();
        $availableResources = Resource::where('status', 'available')->count();
        $maintenanceResources = Resource::where('status', 'maintenance')->count();
        $reservedResources = Resource::where('status', 'reserved')->count();

        // Reservation Statistics
        $totalReservations = Reservation::count();
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $activeReservations = Reservation::where('status', 'active')->count();
        $approvedReservations = Reservation::where('status', 'approved')->count();

        // User Statistics
        $totalUsers = User::count();
        $adminUsers = User::whereIn('role', ['admin', 'manager'])->count();

        // Pending Reservations with Details
        $pendingReservationsData = Reservation::with(['user', 'resource'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent Activities
        $recentActivities = ActivityLog::with('actor')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Resources by Type
        $resourcesByType = Resource::groupBy('type')
            ->select('type', DB::raw('count(*) as count'))
            ->get();

        // Reservations by Status
        $reservationsByStatus = Reservation::groupBy('status')
            ->select('status', DB::raw('count(*) as count'))
            ->get();

        return view('admin.dashboard', [
            'totalResources' => $totalResources,
            'availableResources' => $availableResources,
            'maintenanceResources' => $maintenanceResources,
            'reservedResources' => $reservedResources,
            'totalReservations' => $totalReservations,
            'pendingReservations' => $pendingReservations,
            'activeReservations' => $activeReservations,
            'approvedReservations' => $approvedReservations,
            'totalUsers' => $totalUsers,
            'adminUsers' => $adminUsers,
            'pendingReservationsData' => $pendingReservationsData,
            'recentActivities' => $recentActivities,
            'resourcesByType' => $resourcesByType,
            'reservationsByStatus' => $reservationsByStatus,
        ]);
    }
}
