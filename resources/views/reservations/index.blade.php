@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-blue-900 mb-2">My Reservations</h1>
            <h2 class="text-base font-medium text-gray-600">Track your reservation requests and statuses</h2>
        </div>

        <!-- Filters Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('reservations.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- From Date -->
                    <div>
                        <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From</label>
                        <input id="from_date" name="from_date" type="date"
                            value="{{ request('from_date') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- To Date -->
                    <div>
                        <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To</label>
                        <input id="to_date" name="to_date" type="date"
                            value="{{ request('to_date') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- Search by Resource -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Resource</label>
                        <input id="search" name="search" type="text" placeholder="Resource name..."
                            value="{{ request('search') }}"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- Apply Filters Button -->
                    <div class="flex items-end">
                        <button type="submit"
                            style="width: 100%; padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                            Apply filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Reservations Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Resource</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Start Date/Time</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">End Date/Time</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($reservations as $reservation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm">
                                <div class="text-gray-900 font-medium">{{ $reservation->resource->name }}</div>
                                <div class="text-xs text-gray-600">
                                    @switch($reservation->resource->type)
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
                                        @default
                                            {{ ucfirst($reservation->resource->type) }}
                                    @endswitch
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->start_at->format('M d, Y h:i A') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->end_at->format('M d, Y h:i A') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium
                                    @switch($reservation->status)
                                        @case('pending')
                                            bg-orange-100 text-orange-800
                                            @break
                                        @case('approved')
                                            bg-blue-100 text-blue-800
                                            @break
                                        @case('active')
                                            bg-green-100 text-green-800
                                            @break
                                        @case('finished')
                                            bg-gray-100 text-gray-800
                                            @break
                                        @case('rejected')
                                            bg-red-100 text-red-800
                                            @break
                                        @case('cancelled')
                                            bg-gray-100 text-gray-800
                                            @break
                                    @endswitch
                                ">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('reservations.show', $reservation->id) }}" class="text-blue-900 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">View</a>
                                    @if($reservation->status !== 'active' && $reservation->status !== 'finished' && $reservation->status !== 'cancelled')
                                    <form method="POST" action="{{ route('reservations.cancel', $reservation->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to cancel this reservation?')" class="text-red-600 hover:underline focus:outline-none focus:ring-2 focus:ring-red-800 rounded">Cancel</button>
                                    </form>
                                    @else
                                    <span class="text-gray-400 text-xs">Cannot cancel</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-gray-600 text-sm mb-4">No reservations found.</p>
                                <a href="{{ route('resources.index') }}" class="text-blue-900 hover:underline text-sm">Browse resources to make a reservation</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reservations->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $reservations->links() }}
            </div>
            @endif
        </div>

        <!-- Mobile View Notice -->
        <div class="mt-4 text-xs text-gray-500 text-center md:hidden">
            <p>Swipe horizontally to view all columns</p>
        </div>

        <!-- New Reservation Button -->
        <div class="mt-6 text-center md:text-right">
            <a href="{{ route('resources.index') }}" 
                style="display: inline-block; padding: 8px 24px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; text-decoration: none; transition: all 0.3s;">
                + New Reservation
            </a>
        </div>
    </div>
</div>
@endsection
