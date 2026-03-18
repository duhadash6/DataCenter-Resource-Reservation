@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button and Breadcrumb -->
        <div class="mb-6">
            <button onclick="history.back()" style="display: inline-flex; align-items: center; gap: 8px; color: #2563eb; font-weight: 500; margin-bottom: 16px; transition: all 0.3s; cursor: pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Previous Page
            </button>
            <div class="flex items-center text-sm text-gray-600">
                <a href="{{ route('resources.index') }}" class="text-blue-900 hover:underline">Resources</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">Resource Details</span>
            </div>
        </div>

        <!-- Page Title -->
        <h1 class="text-3xl font-semibold text-blue-900 mb-8">Resource Details</h1>

        <!-- Resource Summary Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">{{ $resource->name }}</h2>
                    <p class="text-gray-600 text-sm">
                        Type: 
                        <span class="font-medium text-gray-900">
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
                        </span>
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    @switch($resource->status)
                        @case('available')
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-green-100 text-green-800">Available</span>
                            @break
                        @case('reserved')
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-orange-100 text-orange-800">Reserved</span>
                            @break
                        @case('maintenance')
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-800">Maintenance</span>
                            @break
                        @case('down')
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-red-100 text-red-800">Down</span>
                            @break
                    @endswitch
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <p class="text-sm text-gray-600 mb-2">
                    <span class="font-medium text-gray-900">Location:</span> {{ $resource->location }}
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-medium text-gray-900">Last Updated:</span> {{ $resource->updated_at->format('M d, Y') }}
                </p>
            </div>
        </div>

        <!-- Technical Specs Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Technical Specifications</h3>
            
            @if($resource->specs)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach(json_decode($resource->specs, true) ?? [] as $key => $value)
                <div>
                    <label class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                    <p class="text-sm text-gray-900 mt-1">{{ $value }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-600">No specifications available for this resource.</p>
            @endif
        </div>

        <!-- Info Alert (if needed) -->
        <!-- 
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-yellow-800">
                <span class="font-medium">Notice:</span> This resource is currently under maintenance and will be available on January 20, 2026.
            </p>
        </div>
        -->

        <!-- Upcoming Reservations Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Reservations</h3>
            
            @if($upcomingReservations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-0 py-3 text-left font-semibold text-gray-900">Start Date/Time</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">End Date/Time</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Status</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Requested by</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($upcomingReservations as $reservation)
                        <tr>
                            <td class="px-0 py-3 text-gray-900">{{ $reservation->start_at->format('M d, Y h:i A') }}</td>
                            <td class="px-4 py-3 text-gray-900">{{ $reservation->end_at->format('M d, Y h:i A') }}</td>
                            <td class="px-4 py-3">
                                @switch($reservation->status)
                                    @case('approved')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Approved</span>
                                        @break
                                    @case('pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @break
                                    @case('active')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Active</span>
                                        @break
                                    @case('rejected')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $reservation->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8">
                <p class="text-gray-600 text-sm">No upcoming reservations for this resource.</p>
            </div>
            @endif
        </div>

        <!-- Action Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-center md:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Ready to use this resource?</h3>
                    <p class="text-sm text-gray-600">Submit a reservation request for this resource.</p>
                </div>
                @auth
                <button 
                    onclick="window.location.href='{{ route('reservations.create', $resource->id) }}';"
                    style="padding: 8px 24px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s; white-space: nowrap;">
                    Reserve this resource
                </button>
                @else
                <a href="{{ route('login') }}" style="display: inline-block; padding: 8px 24px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; text-decoration: none; transition: all 0.3s; white-space: nowrap; text-align: center;">
                    Login to Reserve
                </a>
                @endauth
            </div>

            <!-- Unavailability Notice -->
            @if($resource->status !== 'available')
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded">
                <p class="text-sm text-red-800">
                    <span class="font-medium">Not available:</span> This resource is currently {{ $resource->status }}. Please check back later.
                </p>
            </div>
            @endif
        </div>

        <!-- Back to Resources Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('resources.index') }}" class="text-blue-900 hover:underline text-sm focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">
                ← Back to Resources
            </a>
        </div>
    </div>
</div>
@endsection
