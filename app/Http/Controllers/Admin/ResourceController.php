<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display resources list with filters
     * GET /admin/resources
     */
    public function index(Request $request)
    {
        $query = Resource::query();

        // Filter by type
        if ($request->filled('type_filter')) {
            $query->byType($request->type_filter);
        }

        // Filter by status
        if ($request->filled('status_filter')) {
            $query->byStatus($request->status_filter);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $resources = $query->paginate(15);

        return view('admin.resources.index', [
            'resources' => $resources,
            'types' => Resource::TYPES,
            'statuses' => Resource::STATUSES,
        ]);
    }

    /**
     * Store a new resource
     * POST /admin/resources
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:resources,name'],
            'type' => ['required', 'in:server,vm,storage,network'],
            'status' => ['required', 'in:available,reserved,maintenance,down'],
            'location' => ['required', 'string', 'max:255'],
            'specs' => ['nullable', 'json'],
        ]);

        // Parse JSON specs if provided
        if ($validated['specs']) {
            $validated['specs'] = json_decode($validated['specs'], true);
        }

        Resource::create($validated);

        return redirect()
            ->route('admin.resources.index')
            ->with('success', 'Resource created successfully!');
    }

    /**
     * Update resource status to maintenance
     * POST /admin/resources/{resource}/maintenance
     */
    public function setMaintenance(Resource $resource)
    {
        $resource->update(['status' => 'maintenance']);

        return back()->with('success', 'Resource set to maintenance mode.');
    }

    /**
     * Toggle resource availability
     * POST /admin/resources/{resource}/toggle-status
     */
    public function toggleStatus(Resource $resource)
    {
        $newStatus = $resource->status === 'down' ? 'available' : 'down';
        $resource->update(['status' => $newStatus]);

        $message = $newStatus === 'available' ? 'Resource enabled.' : 'Resource disabled.';
        return back()->with('success', $message);
    }

    /**
     * Delete a resource
     * DELETE /admin/resources/{resource}
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()
            ->route('admin.resources.index')
            ->with('success', 'Resource deleted successfully!');
    }
}
