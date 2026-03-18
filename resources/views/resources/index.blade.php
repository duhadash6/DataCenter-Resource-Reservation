@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-blue-900 mb-2">Available Resources</h1>
            <h2 class="text-base font-medium text-gray-600">Academic Data Center Infrastructure</h2>
        </div>

        <!-- Filters Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('resources.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Resource Type Filter -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Resource Type</label>
                        <select id="type" name="type"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Types</option>
                            <option value="server" {{ request('type') == 'server' ? 'selected' : '' }}>Server</option>
                            <option value="vm" {{ request('type') == 'vm' ? 'selected' : '' }}>VM</option>
                            <option value="storage" {{ request('type') == 'storage' ? 'selected' : '' }}>Storage</option>
                            <option value="network" {{ request('type') == 'network' ? 'selected' : '' }}>Network</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Status</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="down" {{ request('status') == 'down' ? 'selected' : '' }}>Down</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by name</label>
                        <input id="search" name="search" type="text" placeholder="Resource name..."
                            value="{{ request('search') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- Filter Button -->
                    <div class="flex items-end">
                        <button type="submit"
                            style="width: 100%; padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s; margin-top: 32px;">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Resources Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Resource Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Location</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($resources as $resource)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $resource->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @switch($resource->type)
                                    @case('server')
                                        Server
                                        @break
                                    @case('vm')
                                        VM
                                        @break
                                    @case('storage')
                                        Storage
                                        @break
                                    @case('network')
                                        Network
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @switch($resource->status)
                                    @case('available')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">Available</span>
                                        @break
                                    @case('reserved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-orange-100 text-orange-800">Reserved</span>
                                        @break
                                    @case('maintenance')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">Maintenance</span>
                                        @break
                                    @case('down')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-red-100 text-red-800">Down</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $resource->location }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('resources.show', $resource->id) }}" class="text-blue-900 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">View details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-600">
                                <p class="text-sm">No resources found. Try adjusting your filters.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Empty State (optional - uncomment if no resources) -->
            @if($resources->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-600 text-sm">No resources found. Try adjusting your filters.</p>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($resources->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $resources->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
