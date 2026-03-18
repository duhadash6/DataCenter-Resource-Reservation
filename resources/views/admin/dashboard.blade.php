@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Top Header -->
    <div class="bg-white border-b-2 border-primary-lighter sticky top-16 z-10">
        <div class="container py-6">
            <div class="flex-between gap-4 flex-column flex-md-row">
                <div>
                    <h1 class="text-3xl font-bold text-primary mb-1">Admin Dashboard</h1>
                    <h2 class="text-base font-medium text-gray-600">Data Center overview and management</h2>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.resources.index') }}"
                        class="btn btn-secondary">
                        Manage Resources
                    </a>
                    <a href="{{ route('admin.reservations.index') }}"
                        class="btn btn-primary">
                        Manage Reservations
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-8">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 grid-md-cols-3 gap-6 mb-8">
            <!-- Total Resources Card -->
            <div class="card">
                <div class="card-body">
                    <p class="text-sm font-medium text-gray-600 mb-2">Total Resources</p>
                    <div class="flex-between">
                        <p class="text-3xl font-bold text-gray-900">{{ $totalResources }}</p>
                        <span class="badge badge-success">{{ $availableResources }} Available</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Active in system</p>
                </div>
            </div>

            <!-- Pending Requests Card -->
            <div class="card">
                <div class="card-body">
                    <p class="text-sm font-medium text-gray-600 mb-2">Pending Requests</p>
                    <div class="flex-between">
                        <p class="text-3xl font-bold text-gray-900">{{ $pendingReservations }}</p>
                        <span class="badge badge-warning">⚠ Needs Review</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Awaiting approval</p>
                </div>
            </div>

            <!-- Active Reservations Card -->
            <div class="card">
                <div class="card-body">
                    <p class="text-sm font-medium text-gray-600 mb-2">Active Reservations</p>
                    <div class="flex-between">
                        <p class="text-3xl font-bold text-gray-900">{{ $activeReservations }}</p>
                        <span class="badge badge-success">↑ In Use</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Currently running</p>
                </div>
            </div>
        </div>

        <!-- Section 1: Pending Reservation Requests -->
        <div class="card mb-8">
            <div class="card-header">
                <h2 class="text-lg font-bold text-gray-900">Pending Reservation Requests</h2>
            </div>
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Resource</th>
                                <th>Period</th>
                                <th>Submitted at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingReservationsData as $reservation)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $reservation->user->name }}</td>
                                <td class="text-gray-900">{{ $reservation->resource->name }}</td>
                                <td class="text-gray-700">{{ $reservation->start_at->format('M d H:i') }} → {{ $reservation->end_at->format('M d H:i') }}</td>
                                <td class="text-gray-600">{{ $reservation->created_at->format('M d H:i') }}</td>
                                <td>
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.reservations.approve', $reservation->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Approve
                                            </button>
                                        </form>
                                        <button 
                                            onclick="showRejectModal({{ $reservation->id }})"
                                            class="btn btn-danger btn-sm">
                                            Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">No pending requests</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Section 2: Resource Status Overview -->
        <div class="card mb-8">
            <div class="card-header">
                <h2 class="text-lg font-bold text-gray-900">Resource Status Overview</h2>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 grid-md-cols-4 gap-4">
                    <div class="p-4 rounded-lg border-l-4 border-success bg-white">
                        <p class="text-sm text-gray-600 font-medium">Available</p>
                        <p class="text-2xl font-bold text-success mt-2">{{ $availableResources }}</p>
                        <p class="text-xs text-gray-500 mt-1">Ready for reservation</p>
                    </div>
                    <div class="p-4 rounded-lg border-l-4 border-info bg-white">
                        <p class="text-sm text-gray-600 font-medium">Reserved</p>
                        <p class="text-2xl font-bold text-info mt-2">{{ $reservedResources }}</p>
                        <p class="text-xs text-gray-500 mt-1">Currently in use</p>
                    </div>
                    <div class="p-4 rounded-lg border-l-4 border-warning bg-white">
                        <p class="text-sm text-gray-600 font-medium">Maintenance</p>
                        <p class="text-2xl font-bold text-warning mt-2">{{ $maintenanceResources }}</p>
                        <p class="text-xs text-gray-500 mt-1">Under maintenance</p>
                    </div>
                    <div class="p-4 rounded-lg border-l-4 border-danger bg-white">
                        <p class="text-sm text-gray-600 font-medium">Total</p>
                        <p class="text-2xl font-bold text-danger mt-2">{{ $totalResources }}</p>
                        <p class="text-xs text-gray-500 mt-1">All resources</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-lg font-bold text-gray-900">Recent Activity</h2>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                    <div class="flex gap-4 pb-4 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-primary-light flex-center flex-shrink-0">
                            <span class="text-white font-bold text-sm">{{ substr($activity->actor->name ?? 'U', 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex-between">
                                <p class="font-medium text-gray-900">
                                    <span class="text-primary font-bold">{{ $activity->actor->name ?? 'Unknown' }}</span>
                                    <span class="text-gray-600 font-normal">{{ $activity->action }}</span>
                                </p>
                                <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $activity->target_type }} #{{ $activity->target_id }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-6">No recent activity</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex-center z-50">
    <div class="card w-full max-w-md">
        <div class="card-header">
            <h3 class="text-lg font-bold text-gray-900">Reject Reservation</h3>
        </div>
        <form method="POST" id="rejectForm">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Rejection Reason</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>
            </div>
            <div class="card-footer justify-end">
                <button type="button" onclick="closeRejectModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-danger">Reject</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showRejectModal(reservationId) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = `/admin/reservations/${reservationId}/reject`;
        modal.classList.remove('hidden');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });
</script>

@endsection