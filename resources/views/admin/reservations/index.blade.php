@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb and Header -->
        <div class="mb-8">
            <div class="text-sm text-gray-600 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-900 hover:underline">Admin Dashboard</a>
                <span class="mx-2">/</span>
                <span>Manage Reservations</span>
            </div>
            <h1 class="text-3xl font-semibold text-blue-900 mb-1">Manage Reservations</h1>
            <h2 class="text-base font-medium text-gray-600">Review and manage reservation requests</h2>
        </div>

        <!-- Filters Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('admin.reservations.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Resource Type Filter -->
                    <div>
                        <label for="resource_type" class="block text-sm font-medium text-gray-700 mb-1">Resource Type</label>
                        <select id="resource_type" name="resource_type" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Types</option>
                            <option value="server" {{ request('resource_type') == 'server' ? 'selected' : '' }}>Server</option>
                            <option value="vm" {{ request('resource_type') == 'vm' ? 'selected' : '' }}>VM</option>
                            <option value="storage" {{ request('resource_type') == 'storage' ? 'selected' : '' }}>Storage</option>
                            <option value="network" {{ request('resource_type') == 'network' ? 'selected' : '' }}>Network</option>
                        </select>
                    </div>

                    <!-- From Date -->
                    <div>
                        <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From</label>
                        <input id="from_date" name="from_date" type="date" value="{{ request('from_date') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- To Date -->
                    <div>
                        <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To</label>
                        <input id="to_date" name="to_date" type="date" value="{{ request('to_date') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input id="search" name="search" type="text" placeholder="User or resource..." value="{{ request('search') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- Apply Button -->
                    <div class="flex items-end lg:col-span-1">
                        <button type="submit" style="width: 100%; padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                            Apply filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Reservations Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Request ID</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">User</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Resource</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Period</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Status</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Submitted</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Pending Request 1 -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900 font-medium">#RES-001</td>
                            <td class="px-4 py-3 text-gray-700">Dr. Ahmed Hassan</td>
                            <td class="px-4 py-3 text-gray-700">Server-01</td>
                            <td class="px-4 py-3 text-gray-700">Jan 16 10:00 → Jan 16 16:00</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-orange-100 text-orange-800">Pending</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">Jan 14 3:45 PM</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1">
                                    <button onclick="approveReservation(1)" class="px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 focus:outline-none focus:ring-1 focus:ring-green-800">Approve</button>
                                    <button onclick="openRejectModal(1)" class="px-2 py-1 border border-red-300 text-red-600 text-xs font-medium rounded hover:bg-red-50 focus:outline-none focus:ring-1 focus:ring-red-800">Reject</button>
                                    <a href="{{ route('reservations.show', 1) }}" class="px-2 py-1 text-blue-900 text-xs font-medium rounded hover:underline focus:outline-none focus:ring-1 focus:ring-blue-800">View</a>
                                </div>
                            </td>
                        </tr>

                        <!-- Pending Request 2 with Conflict -->
                        <tr class="hover:bg-gray-50 transition border-l-4 border-l-red-500">
                            <td class="px-4 py-3">
                                <div>
                                    <p class="text-gray-900 font-medium">#RES-002</p>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700 mt-1">⚠ Conflict detected</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">Prof. Fatima Mohammed</td>
                            <td class="px-4 py-3 text-gray-700">VM-Cluster-02</td>
                            <td class="px-4 py-3 text-gray-700">Jan 17 14:00 → Jan 18 14:00</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-orange-100 text-orange-800">Pending</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">Jan 15 10:20 AM</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1">
                                    <button onclick="approveReservation(2)" class="px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 focus:outline-none focus:ring-1 focus:ring-green-800">Approve</button>
                                    <button onclick="openRejectModal(2)" class="px-2 py-1 border border-red-300 text-red-600 text-xs font-medium rounded hover:bg-red-50 focus:outline-none focus:ring-1 focus:ring-red-800">Reject</button>
                                    <a href="{{ route('reservations.show', 2) }}" class="px-2 py-1 text-blue-900 text-xs font-medium rounded hover:underline focus:outline-none focus:ring-1 focus:ring-blue-800">View</a>
                                </div>
                            </td>
                        </tr>

                        <!-- Approved Request -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900 font-medium">#RES-003</td>
                            <td class="px-4 py-3 text-gray-700">Dr. Omar Khalil</td>
                            <td class="px-4 py-3 text-gray-700">Storage-Array-01</td>
                            <td class="px-4 py-3 text-gray-700">Jan 20 09:00 → Jan 21 17:00</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">Approved</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">Jan 15 2:15 PM</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1">
                                    <button onclick="cancelReservation(3)" class="px-2 py-1 border border-gray-300 text-gray-600 text-xs font-medium rounded hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-gray-800">Cancel</button>
                                    <a href="{{ route('reservations.show', 3) }}" class="px-2 py-1 text-blue-900 text-xs font-medium rounded hover:underline focus:outline-none focus:ring-1 focus:ring-blue-800">View</a>
                                </div>
                            </td>
                        </tr>

                        <!-- Active Request -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900 font-medium">#RES-004</td>
                            <td class="px-4 py-3 text-gray-700">Dr. Sami Ahmed</td>
                            <td class="px-4 py-3 text-gray-700">Network-Switch-03</td>
                            <td class="px-4 py-3 text-gray-700">Jan 10 14:00 → Jan 13 14:00</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">Active</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">Jan 09 1:30 PM</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('reservations.show', 4) }}" class="px-2 py-1 text-blue-900 text-xs font-medium rounded hover:underline focus:outline-none focus:ring-1 focus:ring-blue-800">View</a>
                            </td>
                        </tr>

                        <!-- Rejected Request -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900 font-medium">#RES-005</td>
                            <td class="px-4 py-3 text-gray-700">Prof. Noor Hassan</td>
                            <td class="px-4 py-3 text-gray-700">Server-Legacy-04</td>
                            <td class="px-4 py-3 text-gray-700">Jan 12 10:00 → Jan 12 18:00</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">Jan 11 11:20 AM</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('reservations.show', 5) }}" class="px-2 py-1 text-blue-900 text-xs font-medium rounded hover:underline focus:outline-none focus:ring-1 focus:ring-blue-800">View</a>
                            </td>
                        </tr>

                        <!-- Finished Request -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900 font-medium">#RES-006</td>
                            <td class="px-4 py-3 text-gray-700">Dr. Layla Ibrahim</td>
                            <td class="px-4 py-3 text-gray-700">Server-01</td>
                            <td class="px-4 py-3 text-gray-700">Jan 05 09:00 → Jan 05 17:00</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">Finished</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">Jan 04 4:30 PM</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('reservations.show', 6) }}" class="px-2 py-1 text-blue-900 text-xs font-medium rounded hover:underline focus:outline-none focus:ring-1 focus:ring-blue-800">View</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-900 hover:underline text-sm">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Reject Reservation Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" onclick="if(event.target === this) closeRejectModal()">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Reject Reservation</h2>
        </div>
        <div class="px-6 py-4">
            <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-2">
                Reason for Rejection <span class="text-red-600">*</span>
            </label>
            <textarea 
                id="rejectReason" 
                rows="4" 
                placeholder="Please provide a reason for rejecting this reservation..."
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none text-sm"
            ></textarea>
            <p class="mt-2 text-xs text-gray-600">This reason will be visible to the requester.</p>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex gap-3 justify-end">
            <button 
                type="button" 
                onclick="closeRejectModal()" 
                style="padding: 8px 16px; border: 1px solid #d1d5db; color: #374151; font-weight: 500; font-size: 14px; border-radius: 6px; background-color: white; cursor: pointer; transition: all 0.3s;">
                Cancel
            </button>
            <button 
                type="button" 
                onclick="confirmReject()" 
                class="px-4 py-2 bg-red-600 text-white font-medium text-sm rounded-lg hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-red-800"
            >
                Reject
            </button>
        </div>
    </div>
</div>

<script>
let currentRejectId = null;

function openRejectModal(reservationId) {
    currentRejectId = reservationId;
    document.getElementById('rejectReason').value = '';
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    currentRejectId = null;
    document.getElementById('rejectReason').value = '';
}

function confirmReject() {
    const reason = document.getElementById('rejectReason').value.trim();
    
    if (!reason) {
        alert('Please provide a reason for rejection');
        return;
    }
    
    if (confirm('Are you sure you want to reject this reservation?')) {
        // API call would go here
        console.log('Rejecting reservation', currentRejectId, 'with reason:', reason);
        // location.reload();
    }
    
    closeRejectModal();
}

function approveReservation(reservationId) {
    if (confirm('Are you sure you want to approve this reservation?')) {
        // API call would go here
        console.log('Approving reservation', reservationId);
        // location.reload();
    }
}

function cancelReservation(reservationId) {
    if (confirm('Are you sure you want to cancel this reservation?')) {
        // API call would go here
        console.log('Cancelling reservation', reservationId);
        // location.reload();
    }
}

// Close modal when Escape key is pressed
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && !document.getElementById('rejectModal').classList.contains('hidden')) {
        closeRejectModal();
    }
});
</script>
@endsection
