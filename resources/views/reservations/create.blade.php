@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-blue-900 mb-2">Create a Reservation</h1>
            <h2 class="text-base font-medium text-gray-600">Select a period and provide a justification</h2>
        </div>

        <!-- Resource Summary Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="text-sm font-semibold text-blue-900 mb-3">Selected Resource</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="text-xs font-medium text-blue-800">Resource Name</label>
                    <p class="text-sm text-blue-900 font-medium mt-1">Server-01</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-blue-800">Type</label>
                    <p class="text-sm text-blue-900 font-medium mt-1">Physical Server</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-blue-800">Status</label>
                    <p class="text-sm mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            Available
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-blue-800">Location</label>
                    <p class="text-sm text-blue-900 font-medium mt-1">Rack 1 / DC A</p>
                </div>
            </div>
        </div>

        <!-- Error Alert (Sample - uncomment when needed) -->
        <!-- 
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-red-800">
                <span class="font-semibold">Error:</span> Time conflict with an existing reservation (Jan 16, 10:00 AM - 4:00 PM).
            </p>
        </div>
        -->

        <!-- Warning Alert (Sample - uncomment when needed) -->
        <!-- 
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-orange-800">
                <span class="font-semibold">Warning:</span> This resource is under maintenance from Jan 18 to Jan 19. Your selected period overlaps with this maintenance window.
            </p>
        </div>
        -->

        <!-- Reservation Form -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <form method="POST" action="{{ route('reservations.store', $resource->id) }}" class="space-y-6">
                @csrf
                
                <!-- Hidden Resource ID -->
                <input type="hidden" name="resource_id" value="{{ $resource->id }}">

                <!-- Start Date/Time -->
                <div>
                    <label for="start_at" class="block text-sm font-medium text-gray-700 mb-2">
                        Start Date/Time <span class="text-red-600">*</span>
                    </label>
                    <input 
                        id="start_at" 
                        name="start_at" 
                        type="datetime-local" 
                        required
                        value="{{ old('start_at') }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" 
                    />
                    <span class="text-xs text-red-600 mt-1 block">@error('start_at') {{ $message }} @enderror</span>
                </div>

                <!-- End Date/Time -->
                <div>
                    <label for="end_at" class="block text-sm font-medium text-gray-700 mb-2">
                        End Date/Time <span class="text-red-600">*</span>
                    </label>
                    <input 
                        id="end_at" 
                        name="end_at" 
                        type="datetime-local" 
                        required
                        value="{{ old('end_at') }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" 
                    />
                    <span class="text-xs text-red-600 mt-1 block">@error('end_at') {{ $message }} @enderror</span>
                </div>

                <!-- Justification / Notes -->
                <div>
                    <label for="justification" class="block text-sm font-medium text-gray-700 mb-2">
                        Justification / Notes <span class="text-red-600">*</span>
                    </label>
                    <textarea 
                        id="justification" 
                        name="justification" 
                        rows="4" 
                        placeholder="Describe the purpose of this reservation..."
                        required
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition resize-vertical">{{ old('justification') }}</textarea>
                    <span class="text-xs text-gray-500 mt-1 block">Provide at least 20 characters</span>
                    <span class="text-xs text-red-600 mt-1 block">@error('justification') {{ $message }} @enderror</span>
                </div>

                <!-- Confirmation Checkbox -->
                <div class="flex items-start">
                    <input 
                        id="confirm" 
                        name="confirm" 
                        type="checkbox" 
                        required
                        class="h-4 w-4 text-blue-800 border-gray-300 rounded focus:ring-blue-800 mt-1">
                    <label for="confirm" class="ml-3 text-sm text-gray-700">
                        I confirm the reservation details are correct <span class="text-red-600">*</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                    <a href="{{ route('resources.show', 1) }}" class="text-blue-900 hover:underline text-sm focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">
                        ← Back to Resource
                    </a>
                    <div class="flex gap-3 w-full md:w-auto">
                        <button 
                            type="button"
                            onclick="window.history.back()"
                            style="flex: 1; padding: 8px 24px; border: 1px solid #d1d5db; color: #374151; font-weight: 500; border-radius: 6px; background-color: white; cursor: pointer; transition: all 0.3s;">
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            style="flex: 1; padding: 8px 24px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                            Submit Reservation Request
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Note -->
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-xs text-gray-600">
                <span class="font-semibold">Note:</span> Your reservation request will be reviewed by administrators. You will receive a notification once your request is approved or rejected. Reservations typically require 24 hours advance notice.
            </p>
        </div>
    </div>
</div>
@endsection
