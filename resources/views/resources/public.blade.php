@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <div class="bg-white border-b-2 border-primary-lighter sticky top-16 z-10">
        <div class="container py-6">
            <div class="flex-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-primary mb-1">Available Resources</h1>
                    <h2 class="text-base font-medium text-gray-600">Browse our data center resources</h2>
                </div>
                @guest
                <div class="flex gap-3">
                    <a href="{{ route('login') }}" class="btn btn-secondary">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
                </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-8">
        <!-- Filters -->
        <div class="card mb-8">
            <div class="card-body">
                <form action="{{ route('resources.public') }}" method="GET" class="grid grid-cols-1 grid-md-cols-3 gap-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-control">
                            <option value="">All Types</option>
                            <option value="server" @selected(request('type') == 'server')>Server</option>
                            <option value="vm" @selected(request('type') == 'vm')>Virtual Machine</option>
                            <option value="storage" @selected(request('type') == 'storage')>Storage</option>
                            <option value="network" @selected(request('type') == 'network')>Network</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-full">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resources Grid -->
        <div class="grid grid-cols-1 grid-md-cols-2 grid-lg-cols-3 gap-6 mb-8">
            @forelse($resources as $resource)
            <div class="card">
                <div class="card-body">
                    <div class="flex-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $resource->name }}</h3>
                        <span class="badge @switch($resource->status)
                            @case('available')
                                badge-success
                                @break
                            @case('reserved')
                                badge-warning
                                @break
                            @case('maintenance')
                                badge-danger
                                @break
                            @default
                                badge-secondary
                        @endswitch">
                            {{ ucfirst($resource->status) }}
                        </span>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Type</p>
                            <p class="text-sm text-gray-900">{{ ucfirst($resource->type) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Location</p>
                            <p class="text-sm text-gray-900">{{ $resource->location ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Capacity</p>
                            <p class="text-sm text-gray-900">{{ $resource->capacity ?? 'N/A' }}</p>
                        </div>
                        @if($resource->specs)
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Specifications</p>
                            <p class="text-sm text-gray-700">
                                @forelse((array) (is_string($resource->specs) ? json_decode($resource->specs, true) : $resource->specs) as $spec)
                                    <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs mr-1 mb-1">{{ $spec }}</span>
                                @empty
                                    <span class="text-gray-500">No specifications</span>
                                @endforelse
                            </p>
                        </div>
                        @endif
                    </div>

                    @auth
                        @if($resource->status === 'available')
                        <a href="{{ route('reservations.create', $resource) }}" class="btn btn-primary w-full">Request Reservation</a>
                        @else
                        <button disabled class="btn btn-secondary w-full opacity-50 cursor-not-allowed">Not Available</button>
                        @endif
                    @else
                    <a href="{{ route('login') }}" class="btn btn-secondary w-full">Sign In to Reserve</a>
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-span-3">
                <div class="card">
                    <div class="card-body text-center py-12">
                        <p class="text-lg text-gray-500 mb-4">No resources found</p>
                        <a href="{{ route('resources.public') }}" class="btn btn-primary">Clear Filters</a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($resources->hasPages())
        <div class="flex justify-center">
            {{ $resources->links() }}
        </div>
        @endif

        <!-- Info Section -->
        <div class="grid grid-cols-1 grid-md-cols-2 gap-6 mt-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">About Our Resources</h3>
                    <p class="text-sm text-gray-700 mb-3">
                        Our data center provides state-of-the-art resources for your computing needs. Whether you need servers, virtual machines, storage, or network infrastructure, we have solutions tailored to your requirements.
                    </p>
                    <p class="text-sm text-gray-700">
                        All resources are regularly maintained and monitored to ensure maximum uptime and performance.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">How to Reserve</h3>
                    <ol class="text-sm text-gray-700 space-y-2">
                        <li><strong>1. Browse:</strong> Explore available resources</li>
                        <li><strong>2. Select:</strong> Click "Request Reservation"</li>
                        <li><strong>3. Schedule:</strong> Choose your dates and time</li>
                        <li><strong>4. Submit:</strong> Complete your reservation request</li>
                        <li><strong>5. Confirm:</strong> Wait for admin approval</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .grid-lg-cols-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    @media (max-width: 1024px) {
        .grid-lg-cols-3 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .grid-lg-cols-3 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
