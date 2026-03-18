<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display resources list with filters and search
     * GET /resources
     */
    public function index(Request $request)
    {
        $query = Resource::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Search by name or location
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $resources = $query->paginate(15);

        return view('resources.index', [
            'resources' => $resources,
            'types' => Resource::TYPES,
            'statuses' => Resource::STATUSES,
        ]);
    }

    /**
     * Display resource details with upcoming reservations
     * GET /resources/{resource}
     */
    public function show(Resource $resource)
    {
        $upcomingReservations = $resource->upcomingReservations();

        return view('resources.show', [
            'resource' => $resource,
            'upcomingReservations' => $upcomingReservations,
        ]);
    }
}
