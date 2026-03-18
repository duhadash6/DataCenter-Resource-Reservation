@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb and Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="text-sm text-gray-600 mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-900 hover:underline">Admin Dashboard</a>
                    <span class="mx-2">/</span>
                    <span>Manage Resources</span>
                </div>
                <h1 class="text-3xl font-semibold text-blue-900 mb-1">Manage Resources</h1>
                <h2 class="text-base font-medium text-gray-600">Create and maintain the Data Center resource catalog</h2>
            </div>
            <button 
                onclick="toggleAddResourceForm()"
                style="padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s; white-space: nowrap;">
                + Add Resource
            </button>
        </div>

        <!-- Add/Edit Resource Form (Initially Hidden) -->
        <div id="resourceFormContainer" class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-8 hidden">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Resource</h3>
            <form method="POST" action="{{ route('admin.resources.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Name <span class="text-red-600">*</span>
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            placeholder="e.g., Server-01"
                            value="{{ old('name') }}"
                            required
                            class="block w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" 
                        />
                        @error('name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Type <span class="text-red-600">*</span>
                        </label>
                        <select 
                            id="type" 
                            name="type" 
                            required
                            class="block w-full px-4 py-2 border @error('type') border-red-500 @else border-gray-300 @enderror rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">Select a type</option>
                            <option value="server" {{ old('type') == 'server' ? 'selected' : '' }}>Physical Server</option>
                            <option value="vm" {{ old('type') == 'vm' ? 'selected' : '' }}>Virtual Machine</option>
                            <option value="storage" {{ old('type') == 'storage' ? 'selected' : '' }}>Storage System</option>
                            <option value="network" {{ old('type') == 'network' ? 'selected' : '' }}>Network Equipment</option>
                        </select>
                        @error('type')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-600">*</span>
                        </label>
                        <select 
                            id="status" 
                            name="status"
                            required
                            class="block w-full px-4 py-2 border @error('status') border-red-500 @else border-gray-300 @enderror rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">Select status</option>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="down" {{ old('status') == 'down' ? 'selected' : '' }}>Down</option>
                        </select>
                        @error('status')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Location <span class="text-red-600">*</span>
                        </label>
                        <input 
                            id="location" 
                            name="location" 
                            type="text" 
                            placeholder="e.g., Rack 1 / DC A"
                            value="{{ old('location') }}"
                            required
                            class="block w-full px-4 py-2 border @error('location') border-red-500 @else border-gray-300 @enderror rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" 
                        />
                        @error('location')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Specifications -->
                <div>
                    <label for="specs" class="block text-sm font-medium text-gray-700 mb-2">
                        Technical Specifications (JSON format, optional)
                    </label>
                    <textarea 
                        id="specs" 
                        name="specs" 
                        rows="4"
                        placeholder='{"cpu": "Intel Xeon", "ram": "128GB", "storage": "2TB"}'
                        class="block w-full px-4 py-2 border @error('specs') border-red-500 @else border-gray-300 @enderror rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition resize-vertical">{{ old('specs') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Optional: Enter technical specs as JSON</p>
                    @error('specs')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 border-t border-gray-200 pt-6">
                    <button 
                        type="submit"
                        style="padding: 8px 24px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                        Save Resource
                    </button>
                    <button 
                        type="button"
                        onclick="toggleAddResourceForm()"
                        style="padding: 8px 24px; border: 1px solid #d1d5db; color: #374151; font-weight: 500; border-radius: 6px; background-color: white; cursor: pointer; transition: all 0.3s;">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Filters Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('admin.resources.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Type Filter -->
                    <div>
                        <label for="type_filter" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select id="type_filter" name="type_filter"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Types</option>
                            <option value="server" {{ request('type_filter') == 'server' ? 'selected' : '' }}>Physical Server</option>
                            <option value="vm" {{ request('type_filter') == 'vm' ? 'selected' : '' }}>Virtual Machine</option>
                            <option value="storage" {{ request('type_filter') == 'storage' ? 'selected' : '' }}>Storage System</option>
                            <option value="network" {{ request('type_filter') == 'network' ? 'selected' : '' }}>Network Equipment</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status_filter" name="status_filter"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Status</option>
                            <option value="available" {{ request('status_filter') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved" {{ request('status_filter') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="maintenance" {{ request('status_filter') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="down" {{ request('status_filter') == 'down' ? 'selected' : '' }}>Down</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by name</label>
                        <input id="search" name="search" type="text" placeholder="Resource name..."
                            value="{{ request('search') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- Apply Button -->
                    <div class="flex items-end">
                        <button type="submit"
                            style="width: 100%; padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                            Apply
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Type</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Location</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($resources as $resource)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $resource->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @switch($resource->type)
                                    @case('server')
                                        Physical Server
                                        @break
                                    @case('vm')
                                        Virtual Machine
                                        @break
                                    @case('storage')
                                        Storage System
                                        @break
                                    @case('network')
                                        Network Equipment
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
                                <div class="flex gap-2 flex-wrap">
                                    <a href="{{ route('resources.show', $resource->id) }}" class="text-blue-900 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">View</a>
                                    
                                    @if($resource->status !== 'maintenance')
                                    <form method="POST" action="{{ route('admin.resources.maintenance', $resource->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="text-orange-600 hover:underline focus:outline-none focus:ring-2 focus:ring-orange-800 rounded" onclick="return confirm('Set to maintenance mode?')">Maintenance</button>
                                    </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('admin.resources.toggle-status', $resource->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="text-gray-600 hover:underline focus:outline-none focus:ring-2 focus:ring-gray-800 rounded" onclick="return confirm('Toggle resource status?')">
                                            {{ $resource->status === 'down' ? 'Enable' : 'Disable' }}
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('admin.resources.destroy', $resource->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline focus:outline-none focus:ring-2 focus:ring-red-800 rounded" onclick="return confirm('Delete this resource?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-600">
                                <p class="text-sm">No resources found.</p>
                                <button onclick="toggleAddResourceForm()" class="text-blue-900 hover:underline text-sm mt-2">Add a resource</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($resources->hasPages())
        <div class="mt-6 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Showing {{ $resources->firstItem() }} to {{ $resources->lastItem() }} of {{ $resources->total() }} resources
            </div>
            <div>
                {{ $resources->links() }}
            </div>
        </div>
        @endif

        <!-- Back to Dashboard -->
        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-900 hover:underline text-sm">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- JavaScript Functions -->
<script>
function toggleAddResourceForm() {
    const formContainer = document.getElementById('resourceFormContainer');
    formContainer.classList.toggle('hidden');
    if (!formContainer.classList.contains('hidden')) {
        document.getElementById('name').focus();
        formContainer.scrollIntoView({ behavior: 'smooth' });
    }
}
</script>

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" id="successMessage">
    {{ session('success') }}
</div>
<script>
setTimeout(() => {
    const msg = document.getElementById('successMessage');
    if(msg) msg.style.display = 'none';
}, 5000);
</script>
@endif

@if($errors->any())
<div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" id="errorMessage">
    Please fix the errors in the form
</div>
<script>
setTimeout(() => {
    const msg = document.getElementById('errorMessage');
    if(msg) msg.style.display = 'none';
}, 5000);
</script>
@endif
@endsection
