@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <div class="mb-6 flex items-center text-sm text-gray-600">
            <a href="{{ route('reservations.index') }}" class="text-blue-900 hover:underline">My Reservations</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">Reservation Details</span>
        </div>

        <!-- Page Title -->
        <h1 class="text-3xl font-semibold text-blue-900 mb-8">Reservation Details</h1>

        <!-- Reservation Info Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Reservation ID</label>
                        <p class="text-sm text-gray-900 font-medium mt-1">#RES-2026-001234</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Resource</label>
                        <p class="text-sm text-gray-900 font-medium mt-1">Server-01 (Physical Server)</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Start Date/Time</label>
                        <p class="text-sm text-gray-900 font-medium mt-1">January 16, 2026 at 10:00 AM</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Duration</label>
                        <p class="text-sm text-gray-900 font-medium mt-1">6 hours</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Status</label>
                        <p class="text-sm mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                Approved
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Requested On</label>
                        <p class="text-sm text-gray-900 font-medium mt-1">January 14, 2026 at 3:45 PM</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Approved On</label>
                        <p class="text-sm text-gray-900 font-medium mt-1">January 15, 2026 at 9:30 AM</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Approved By</label>
                        <p class="text-sm text-gray-900 font-medium mt-1">Dr. Fatima Mohammed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Justification Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Justification</h3>
            <p class="text-sm text-gray-700 leading-relaxed">
                We need this server for running machine learning experiments as part of our research project on distributed computing. The experiments require continuous operation for the specified period to ensure data consistency and accurate results collection.
            </p>
        </div>

        <!-- Admin Notes Section (if applicable) -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">Admin Notes</h3>
            <p class="text-sm text-blue-800 leading-relaxed">
                Approved with standard terms. Ensure proper resource cleanup after reservation ends.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <div class="flex flex-col md:flex-row gap-3">
                <a href="{{ route('reservations.index') }}" 
                    style="display: block; padding: 8px 24px; border: 1px solid #d1d5db; color: #374151; font-weight: 500; border-radius: 6px; background-color: white; text-decoration: none; text-align: center; transition: all 0.3s;">
                    ← Back to My Reservations
                </a>
                <button 
                    onclick="if(confirm('Are you sure you want to cancel this reservation?')) { fetch('{{ route('reservations.cancel', 1) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}}).then(() => { window.location.href='{{ route('reservations.index') }}'; }); }"
                    style="padding: 8px 24px; border: 1px solid #fecaca; color: #dc2626; font-weight: 500; border-radius: 6px; background-color: white; cursor: pointer; transition: all 0.3s;">
                    Cancel Reservation
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
