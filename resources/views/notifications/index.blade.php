@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb and Header -->
        <div class="mb-8">
            <div class="text-sm text-gray-600 mb-2">
                <a href="/" class="text-blue-900 hover:underline">Home</a>
                <span class="mx-2">/</span>
                <span>Notifications</span>
            </div>
            <h1 class="text-3xl font-semibold text-blue-900 mb-1">Notifications</h1>
            <h2 class="text-base font-medium text-gray-600">System messages and reservation updates</h2>
        </div>

        <!-- Toolbar Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <!-- Status Filter -->
                <div>
                    <label for="filter" class="block text-sm font-medium text-gray-700 mb-1">Filter</label>
                    <select id="filter" name="filter" onchange="filterNotifications(this.value)" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                        <option value="all">All Notifications</option>
                        <option value="unread">Unread</option>
                        <option value="important">Important</option>
                    </select>
                </div>

                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input id="search" name="search" type="text" placeholder="Search notifications..." class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                </div>

                <!-- Mark All as Read Button -->
                <div>
                    <button onclick="markAllAsRead()" style="width: 100%; padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                        Mark all as read
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Notifications List -->
            <div class="lg:col-span-2">
                <div class="space-y-3">
                    <!-- Notification 1: Approved Reservation -->
                    <div class="notification-item bg-white border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 hover:shadow-sm transition" onclick="showDetails(1)">
                        <div class="flex items-start gap-3">
                            <!-- Read/Unread Indicator -->
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-blue-600 mt-2"></div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-tight">Reservation Approved</h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 flex-shrink-0">Reservation</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">Your reservation for Server-01 from Jan 16 10:00 to 16:00 has been approved by the administrator.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">2 hours ago</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 2: Maintenance Alert -->
                    <div class="notification-item bg-white border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 hover:shadow-sm transition" onclick="showDetails(2)">
                        <div class="flex items-start gap-3">
                            <!-- Read Indicator -->
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-gray-300 mt-2"></div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-tight">Maintenance Scheduled</h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800 flex-shrink-0">Maintenance</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">Storage-Array-01 will undergo maintenance on January 20, 2026 from 12:00 AM to 6:00 AM UTC.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">5 hours ago</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 3: Unread Important - Conflict Warning -->
                    <div class="notification-item bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:border-blue-400 hover:shadow-sm transition" onclick="showDetails(3)">
                        <div class="flex items-start gap-3">
                            <!-- Unread Indicator -->
                            <div class="flex-shrink-0 w-3 h-3 rounded-full bg-red-600 mt-1.5"></div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-tight">Reservation Conflict Detected</h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800 flex-shrink-0">System</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">⚠ Your reservation (#RES-002) for VM-Cluster-02 overlaps with another reservation. Please review and contact support.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">20 minutes ago</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 4: Reservation Rejected -->
                    <div class="notification-item bg-white border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 hover:shadow-sm transition" onclick="showDetails(4)">
                        <div class="flex items-start gap-3">
                            <!-- Read Indicator -->
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-gray-300 mt-2"></div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-tight">Reservation Rejected</h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800 flex-shrink-0">Reservation</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">Your reservation (#RES-005) for Server-Legacy-04 has been rejected. Reason: Resource is scheduled for maintenance during requested period.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">1 day ago</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 5: Reservation Expiring Soon -->
                    <div class="notification-item bg-white border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 hover:shadow-sm transition" onclick="showDetails(5)">
                        <div class="flex items-start gap-3">
                            <!-- Read Indicator -->
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-gray-300 mt-2"></div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-tight">Reservation Expiring Soon</h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-orange-100 text-orange-800 flex-shrink-0">Reservation</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">Your reservation for Network-Switch-03 expires in 2 hours (Jan 13, 14:00). Make sure to release the resource if no longer needed.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">3 days ago</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 6: System Update -->
                    <div class="notification-item bg-white border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 hover:shadow-sm transition" onclick="showDetails(6)">
                        <div class="flex items-start gap-3">
                            <!-- Read Indicator -->
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-gray-300 mt-2"></div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-tight">System Update Completed</h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 flex-shrink-0">System</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">The Data Center Reservation system has been updated with improved reservation management features.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">1 week ago</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification 7: New Resource Available -->
                    <div class="notification-item bg-white border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 hover:shadow-sm transition" onclick="showDetails(7)">
                        <div class="flex items-start gap-3">
                            <!-- Read Indicator -->
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-gray-300 mt-2"></div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-semibold text-gray-900 text-sm leading-tight">New Resource Available</h3>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 flex-shrink-0">System</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">A new high-performance server (Server-02) has been added to the available resources pool.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs text-gray-500">5 days ago</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State (hidden by default) -->
                    <div id="emptyState" class="text-center py-12 hidden">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                        <p class="mt-1 text-sm text-gray-600">You're all caught up!</p>
                    </div>
                </div>
            </div>

            <!-- Details Panel -->
            <div id="detailsPanel" class="hidden lg:block bg-white border border-gray-200 rounded-lg shadow-sm p-6 h-fit">
                <div class="space-y-4">
                    <div>
                        <h3 id="detailsTitle" class="text-lg font-semibold text-gray-900">Select a notification</h3>
                        <p id="detailsTimestamp" class="text-xs text-gray-500 mt-1"></p>
                    </div>

                    <p id="detailsMessage" class="text-sm text-gray-700 leading-relaxed border-t border-gray-200 pt-4 hidden">
                        
                    </p>

                    <div id="detailsActions" class="border-t border-gray-200 pt-4 space-y-2 hidden">
                        <a id="viewLink" href="#" class="block w-full px-4 py-2 bg-blue-900 text-white text-sm font-medium rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-offset-2 transition text-center">
                            View Related Item
                        </a>
                        <button onclick="deleteNotification()" class="w-full px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-gray-800">
                            Delete
                        </button>
                    </div>

                    <!-- Desktop Instructions -->
                    <div class="text-center text-sm text-gray-600 border-t border-gray-200 pt-4">
                        <p>Click a notification on the left to view details</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Details Modal -->
        <div id="detailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 lg:hidden" onclick="if(event.target === this) closeDetails()">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full max-h-96 overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h2 id="modalTitle" class="text-lg font-semibold text-gray-900">Notification Details</h2>
                    <button onclick="closeDetails()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <p id="modalTimestamp" class="text-xs text-gray-500"></p>
                    <p id="modalMessage" class="text-sm text-gray-700 leading-relaxed"></p>
                    <div id="modalActions" class="space-y-2 border-t border-gray-200 pt-4">
                        <a id="modalViewLink" href="#" class="block w-full px-4 py-2 bg-blue-900 text-white text-sm font-medium rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-800 text-center">
                            View Related Item
                        </a>
                        <button onclick="deleteNotification()" class="w-full px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-gray-800">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-8">
            <a href="/" class="text-blue-900 hover:underline text-sm">
                ← Back to Home
            </a>
        </div>
    </div>
</div>

<script>
// Sample notification data
const notifications = {
    1: {
        title: 'Reservation Approved',
        timestamp: '2 hours ago',
        message: 'Your reservation (#RES-001) for Server-01 from Jan 16 10:00 to 16:00 has been approved by the administrator. You can now use the resource during the specified time period.',
        category: 'Reservation',
        link: '{{ route("reservations.show", 1) }}'
    },
    2: {
        title: 'Maintenance Scheduled',
        timestamp: '5 hours ago',
        message: 'Storage-Array-01 will undergo maintenance on January 20, 2026 from 12:00 AM to 6:00 AM UTC. All existing reservations during this period will be cancelled. Please plan accordingly.',
        category: 'Maintenance',
        link: '{{ route("resources.show", 1) }}'
    },
    3: {
        title: 'Reservation Conflict Detected',
        timestamp: '20 minutes ago',
        message: '⚠ Your reservation (#RES-002) for VM-Cluster-02 overlaps with another reservation. Two reservations cannot be active for the same resource during overlapping time periods. Please contact support to resolve this conflict.',
        category: 'System',
        link: '{{ route("reservations.show", 2) }}'
    },
    4: {
        title: 'Reservation Rejected',
        timestamp: '1 day ago',
        message: 'Your reservation (#RES-005) for Server-Legacy-04 has been rejected. Reason: Resource is scheduled for maintenance during requested period. Please submit a new reservation for a different date or resource.',
        category: 'Reservation',
        link: '{{ route("reservations.show", 5) }}'
    },
    5: {
        title: 'Reservation Expiring Soon',
        timestamp: '3 days ago',
        message: 'Your reservation for Network-Switch-03 expires in 2 hours (Jan 13, 14:00). Make sure to release the resource if no longer needed to free it up for other users.',
        category: 'Reservation',
        link: '{{ route("reservations.show", 4) }}'
    },
    6: {
        title: 'System Update Completed',
        timestamp: '1 week ago',
        message: 'The Data Center Reservation system has been updated with improved reservation management features, enhanced conflict detection, and better resource availability tracking. Please refresh the page if you experience any issues.',
        category: 'System',
        link: '#'
    },
    7: {
        title: 'New Resource Available',
        timestamp: '5 days ago',
        message: 'A new high-performance server (Server-02) has been added to the available resources pool. The server features 32GB RAM, 16 CPUs, and 1TB SSD storage. You can now make reservations for this resource.',
        category: 'System',
        link: '{{ route("resources.show", 1) }}'
    }
};

let currentNotificationId = null;

function showDetails(id) {
    const notification = notifications[id];
    if (!notification) return;

    currentNotificationId = id;

    // Desktop panel
    document.getElementById('detailsTitle').textContent = notification.title;
    document.getElementById('detailsTimestamp').textContent = notification.timestamp;
    document.getElementById('detailsMessage').textContent = notification.message;
    document.getElementById('detailsMessage').classList.remove('hidden');
    
    document.getElementById('detailsActions').classList.remove('hidden');
    document.getElementById('viewLink').href = notification.link;

    // Mobile modal
    document.getElementById('modalTitle').textContent = notification.title;
    document.getElementById('modalTimestamp').textContent = notification.timestamp;
    document.getElementById('modalMessage').textContent = notification.message;
    document.getElementById('modalViewLink').href = notification.link;

    // Show modal on mobile
    if (window.innerWidth < 1024) {
        document.getElementById('detailsModal').classList.remove('hidden');
    }

    // Show desktop panel
    document.getElementById('detailsPanel').classList.remove('hidden');
}

function closeDetails() {
    document.getElementById('detailsModal').classList.add('hidden');
}

function filterNotifications(filter) {
    console.log('Filtering by:', filter);
    // API call would go here
}

function markAllAsRead() {
    if (confirm('Mark all notifications as read?')) {
        // API call would go here
        console.log('Marking all as read');
        // location.reload();
    }
}

function deleteNotification() {
    if (confirm('Delete this notification?')) {
        // API call would go here
        console.log('Deleting notification', currentNotificationId);
        // location.reload();
    }
}

// Close modal when Escape key is pressed
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && !document.getElementById('detailsModal').classList.contains('hidden')) {
        closeDetails();
    }
});
</script>
@endsection
