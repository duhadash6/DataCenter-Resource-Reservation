<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class PublicResourceController extends Controller
{
    /**
     * Display public resources (accessible to guests and authenticated users)
     */
    public function index(Request $request)
    {
        $query = Resource::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Search by name or location
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Only show available resources (guests can see all available ones)
        // For authenticated users, they'll see status to know if they can reserve
        $resources = $query->paginate(12);

        return view('resources.public', [
            'resources' => $resources,
        ]);
    }

    /**
     * Show single resource details (public)
     */
    public function show(Resource $resource)
    {
        return view('resources.show-public', [
            'resource' => $resource,
        ]);
    }
}
