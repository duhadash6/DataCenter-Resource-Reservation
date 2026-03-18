@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb and Header -->
        <div class="mb-8">
            <div class="text-sm text-gray-600 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-900 hover:underline">Admin Dashboard</a>
                <span class="mx-2">/</span>
                <span>Activity Log</span>
            </div>
            <h1 class="text-3xl font-semibold text-blue-900 mb-1">Activity Log</h1>
            <h2 class="text-base font-medium text-gray-600">Traceability of critical system actions</h2>
        </div>

        <!-- Filters Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('admin.activity-log') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- User Filter -->
                    <div>
                        <label for="user" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                        <select id="user" name="user" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Users</option>
                            <option value="admin_1" {{ request('user') == 'admin_1' ? 'selected' : '' }}>Admin Panel</option>
                            <option value="dr_ahmed" {{ request('user') == 'dr_ahmed' ? 'selected' : '' }}>Dr. Ahmed Hassan</option>
                            <option value="prof_fatima" {{ request('user') == 'prof_fatima' ? 'selected' : '' }}>Prof. Fatima Mohammed</option>
                            <option value="dr_omar" {{ request('user') == 'dr_omar' ? 'selected' : '' }}>Dr. Omar Khalil</option>
                            <option value="system" {{ request('user') == 'system' ? 'selected' : '' }}>System</option>
                        </select>
                    </div>

                    <!-- Action Type Filter -->
                    <div>
                        <label for="actionType" class="block text-sm font-medium text-gray-700 mb-1">Action Type</label>
                        <select id="actionType" name="actionType" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                            <option value="">All Actions</option>
                            <option value="resource_create" {{ request('actionType') == 'resource_create' ? 'selected' : '' }}>Resource Created</option>
                            <option value="resource_update" {{ request('actionType') == 'resource_update' ? 'selected' : '' }}>Resource Updated</option>
                            <option value="resource_delete" {{ request('actionType') == 'resource_delete' ? 'selected' : '' }}>Resource Deleted</option>
                            <option value="reservation_approve" {{ request('actionType') == 'reservation_approve' ? 'selected' : '' }}>Reservation Approved</option>
                            <option value="reservation_reject" {{ request('actionType') == 'reservation_reject' ? 'selected' : '' }}>Reservation Rejected</option>
                            <option value="reservation_create" {{ request('actionType') == 'reservation_create' ? 'selected' : '' }}>Reservation Created</option>
                            <option value="user_login" {{ request('actionType') == 'user_login' ? 'selected' : '' }}>User Login</option>
                            <option value="status_change" {{ request('actionType') == 'status_change' ? 'selected' : '' }}>Status Changed</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div>
                        <label for="fromDate" class="block text-sm font-medium text-gray-700 mb-1">From</label>
                        <input id="fromDate" name="fromDate" type="date" value="{{ request('fromDate') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <div>
                        <label for="toDate" class="block text-sm font-medium text-gray-700 mb-1">To</label>
                        <input id="toDate" name="toDate" type="date" value="{{ request('toDate') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>

                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input id="search" name="search" type="text" placeholder="Search logs..." value="{{ request('search') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex gap-3 justify-end pt-2">
                    <a href="{{ route('admin.activity-log') }}" style="display: inline-block; padding: 8px 16px; border: 1px solid #d1d5db; color: #374151; font-weight: 500; font-size: 14px; border-radius: 6px; text-decoration: none; transition: all 0.3s;">
                        Clear Filters
                    </a>
                    <button type="submit" style="padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; font-size: 14px; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Activity Log Table -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Timestamp</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Actor</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Action</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Target</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-900">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Log Entry 1: Reservation Approved -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 15, 2026</div>
                                <div class="text-xs text-gray-500">14:32:15 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">Admin Panel</div>
                                <div class="text-xs text-gray-500">admin@datacenter.local</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">Reservation Approved</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">#RES-001</span>
                                <div class="text-xs text-gray-500">Server-01</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(1)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 2: Resource Updated -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 15, 2026</div>
                                <div class="text-xs text-gray-500">13:47:22 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">Admin Panel</div>
                                <div class="text-xs text-gray-500">admin@datacenter.local</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">Resource Updated</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">Server-02</span>
                                <div class="text-xs text-gray-500">Type: Server</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(2)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 3: Reservation Rejected -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 15, 2026</div>
                                <div class="text-xs text-gray-500">12:15:45 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">Admin Panel</div>
                                <div class="text-xs text-gray-500">admin@datacenter.local</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-red-100 text-red-800">Reservation Rejected</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">#RES-005</span>
                                <div class="text-xs text-gray-500">Server-Legacy-04</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(3)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 4: Resource Created -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 14, 2026</div>
                                <div class="text-xs text-gray-500">16:23:08 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">Admin Panel</div>
                                <div class="text-xs text-gray-500">admin@datacenter.local</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">Resource Created</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">Server-02</span>
                                <div class="text-xs text-gray-500">New resource</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(4)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 5: Status Changed -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 14, 2026</div>
                                <div class="text-xs text-gray-500">10:05:33 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">System</div>
                                <div class="text-xs text-gray-500">system@datacenter.local</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800">Status Changed</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">VM-Cluster-02</span>
                                <div class="text-xs text-gray-500">Type: VM</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(5)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 6: User Login -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 14, 2026</div>
                                <div class="text-xs text-gray-500">09:42:17 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">Dr. Ahmed Hassan</div>
                                <div class="text-xs text-gray-500">ahmed@university.edu</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">User Login</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">User Account</span>
                                <div class="text-xs text-gray-500">Auth session</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(6)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 7: Reservation Created -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 14, 2026</div>
                                <div class="text-xs text-gray-500">08:21:54 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">Prof. Fatima Mohammed</div>
                                <div class="text-xs text-gray-500">fatima@university.edu</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-purple-100 text-purple-800">Reservation Created</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">#RES-002</span>
                                <div class="text-xs text-gray-500">VM-Cluster-02</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(7)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 8: Resource Updated -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 13, 2026</div>
                                <div class="text-xs text-gray-500">15:38:42 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">Admin Panel</div>
                                <div class="text-xs text-gray-500">admin@datacenter.local</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">Resource Updated</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">Storage-Array-01</span>
                                <div class="text-xs text-gray-500">Type: Storage</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(8)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 9: Maintenance Status Change -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 13, 2026</div>
                                <div class="text-xs text-gray-500">07:14:28 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">System</div>
                                <div class="text-xs text-gray-500">system@datacenter.local</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800">Status Changed</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">Network-Switch-03</span>
                                <div class="text-xs text-gray-500">Maintenance mode</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(9)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>

                        <!-- Log Entry 10: User Login -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-900">
                                <div class="font-medium">Jan 13, 2026</div>
                                <div class="text-xs text-gray-500">06:55:11 UTC</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-gray-900 font-medium">Dr. Omar Khalil</div>
                                <div class="text-xs text-gray-500">omar@university.edu</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-800">User Login</span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <span class="font-medium">User Account</span>
                                <div class="text-xs text-gray-500">Auth session</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                <button onclick="showDetails(10)" class="text-blue-900 hover:underline">View details</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination (optional) -->
            <div class="border-t border-gray-200 px-4 py-3 flex items-center justify-between bg-gray-50">
                <p class="text-sm text-gray-600">Showing 1 to 10 of 247 entries</p>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-100">← Previous</button>
                    <button class="px-3 py-1 border border-gray-300 bg-blue-900 text-white text-sm rounded">1</button>
                    <button class="px-3 py-1 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-100">2</button>
                    <button class="px-3 py-1 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-100">3</button>
                    <button class="px-3 py-1 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-100">Next →</button>
                </div>
            </div>
        </div>

        <!-- Empty State (hidden by default) -->
        <div id="emptyState" class="bg-white border border-gray-200 rounded-lg shadow-sm p-12 text-center hidden">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No activity found</h3>
            <p class="mt-1 text-sm text-gray-600">Try adjusting your filter criteria</p>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-8">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-900 hover:underline text-sm">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" onclick="if(event.target === this) closeDetailsModal()">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-96 overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h2 id="modalTitle" class="text-lg font-semibold text-gray-900">Activity Details</h2>
            <button onclick="closeDetailsModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="px-6 py-4">
            <div class="space-y-4">
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Timestamp</label>
                    <p id="modalTimestamp" class="text-sm text-gray-900 font-medium mt-1"></p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Actor</label>
                    <p id="modalActor" class="text-sm text-gray-900 font-medium mt-1"></p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Action</label>
                    <p id="modalAction" class="text-sm text-gray-900 font-medium mt-1"></p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Target</label>
                    <p id="modalTarget" class="text-sm text-gray-900 font-medium mt-1"></p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Changes</label>
                    <div id="modalChanges" class="text-sm text-gray-900 mt-1 bg-gray-50 border border-gray-200 rounded p-3 font-mono text-xs space-y-1"></div>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">IP Address</label>
                    <p id="modalIP" class="text-sm text-gray-900 font-medium mt-1"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Sample detailed activity data
const activityDetails = {
    1: {
        timestamp: 'Jan 15, 2026 at 14:32:15 UTC',
        actor: 'Admin Panel (admin@datacenter.local)',
        action: 'Reservation Approved',
        target: '#RES-001 (Server-01)',
        changes: [
            'Status: pending → approved',
            'Approved by: Admin Panel',
            'Approval time: 2026-01-15 14:32:15'
        ],
        ip: '192.168.1.100'
    },
    2: {
        timestamp: 'Jan 15, 2026 at 13:47:22 UTC',
        actor: 'Admin Panel (admin@datacenter.local)',
        action: 'Resource Updated',
        target: 'Server-02 (Type: Server)',
        changes: [
            'Status: available → reserved',
            'Location: "Data Center A" → "Data Center B"',
            'Updated at: 2026-01-15 13:47:22'
        ],
        ip: '192.168.1.100'
    },
    3: {
        timestamp: 'Jan 15, 2026 at 12:15:45 UTC',
        actor: 'Admin Panel (admin@datacenter.local)',
        action: 'Reservation Rejected',
        target: '#RES-005 (Server-Legacy-04)',
        changes: [
            'Status: pending → rejected',
            'Reason: "Resource scheduled for maintenance"',
            'Rejection time: 2026-01-15 12:15:45'
        ],
        ip: '192.168.1.100'
    },
    4: {
        timestamp: 'Jan 14, 2026 at 16:23:08 UTC',
        actor: 'Admin Panel (admin@datacenter.local)',
        action: 'Resource Created',
        target: 'Server-02 (New resource)',
        changes: [
            'Name: "Server-02"',
            'Type: server',
            'Status: available',
            'CPU: 32, RAM: 128GB, Storage: 2TB'
        ],
        ip: '192.168.1.100'
    },
    5: {
        timestamp: 'Jan 14, 2026 at 10:05:33 UTC',
        actor: 'System (system@datacenter.local)',
        action: 'Status Changed',
        target: 'VM-Cluster-02 (Type: VM)',
        changes: [
            'Status: available → maintenance',
            'Reason: "Automatic system update"',
            'Change time: 2026-01-14 10:05:33'
        ],
        ip: 'N/A'
    },
    6: {
        timestamp: 'Jan 14, 2026 at 09:42:17 UTC',
        actor: 'Dr. Ahmed Hassan (ahmed@university.edu)',
        action: 'User Login',
        target: 'User Account (Auth session)',
        changes: [
            'Login successful',
            'Session ID: sess_abc123xyz789',
            'Login time: 2026-01-14 09:42:17'
        ],
        ip: '203.45.123.67'
    },
    7: {
        timestamp: 'Jan 14, 2026 at 08:21:54 UTC',
        actor: 'Prof. Fatima Mohammed (fatima@university.edu)',
        action: 'Reservation Created',
        target: '#RES-002 (VM-Cluster-02)',
        changes: [
            'Status: pending (awaiting approval)',
            'Start: Jan 17, 2026 14:00 UTC',
            'End: Jan 18, 2026 14:00 UTC'
        ],
        ip: '203.45.200.45'
    },
    8: {
        timestamp: 'Jan 13, 2026 at 15:38:42 UTC',
        actor: 'Admin Panel (admin@datacenter.local)',
        action: 'Resource Updated',
        target: 'Storage-Array-01 (Type: Storage)',
        changes: [
            'Capacity: "10TB" → "15TB"',
            'Status: available',
            'Updated at: 2026-01-13 15:38:42'
        ],
        ip: '192.168.1.100'
    },
    9: {
        timestamp: 'Jan 13, 2026 at 07:14:28 UTC',
        actor: 'System (system@datacenter.local)',
        action: 'Status Changed',
        target: 'Network-Switch-03 (Maintenance mode)',
        changes: [
            'Status: available → maintenance',
            'Maintenance window: 48 hours',
            'Change time: 2026-01-13 07:14:28'
        ],
        ip: 'N/A'
    },
    10: {
        timestamp: 'Jan 13, 2026 at 06:55:11 UTC',
        actor: 'Dr. Omar Khalil (omar@university.edu)',
        action: 'User Login',
        target: 'User Account (Auth session)',
        changes: [
            'Login successful',
            'Session ID: sess_def456uvw012',
            'Login time: 2026-01-13 06:55:11'
        ],
        ip: '203.45.150.89'
    }
};

function showDetails(id) {
    const activity = activityDetails[id];
    if (!activity) return;

    document.getElementById('modalTitle').textContent = activity.action;
    document.getElementById('modalTimestamp').textContent = activity.timestamp;
    document.getElementById('modalActor').textContent = activity.actor;
    document.getElementById('modalAction').textContent = activity.action;
    document.getElementById('modalTarget').textContent = activity.target;
    document.getElementById('modalIP').textContent = activity.ip;

    const changesContainer = document.getElementById('modalChanges');
    changesContainer.innerHTML = '';
    activity.changes.forEach(change => {
        const line = document.createElement('div');
        line.textContent = change;
        changesContainer.appendChild(line);
    });

    document.getElementById('detailsModal').classList.remove('hidden');
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.add('hidden');
}

// Close modal when Escape key is pressed
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && !document.getElementById('detailsModal').classList.contains('hidden')) {
        closeDetailsModal();
    }
});
</script>
@endsection
