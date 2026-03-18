@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb and Header -->
        <div class="mb-8">
            <div class="text-sm text-gray-600 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-900 hover:underline">Admin Dashboard</a>
                <span class="mx-2">/</span>
                <span>Statistics</span>
            </div>
            <h1 class="text-3xl font-semibold text-blue-900 mb-1">Statistics</h1>
            <h2 class="text-base font-medium text-gray-600">Utilization and activity overview</h2>
        </div>

        <!-- Filters Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <!-- Date Range Filter -->
                <div>
                    <label for="dateRange" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <select id="dateRange" onchange="updateCharts(this.value)" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                        <option value="7">Last 7 days</option>
                        <option value="30" selected>Last 30 days</option>
                        <option value="90">Last 90 days</option>
                    </select>
                </div>

                <!-- Resource Type Filter -->
                <div>
                    <label for="resourceType" class="block text-sm font-medium text-gray-700 mb-1">Resource Type</label>
                    <select id="resourceType" onchange="updateCharts()" class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                        <option value="">All Types</option>
                        <option value="server">Server</option>
                        <option value="vm">VM</option>
                        <option value="storage">Storage</option>
                        <option value="network">Network</option>
                    </select>
                </div>

                <!-- Refresh Button -->
                <div>
                    <button onclick="refreshStatistics()" style="width: 100%; padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Top KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Occupancy Rate Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Occupancy Rate</p>
                        <p class="text-3xl font-semibold text-gray-900">68%</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mt-3">↑ 5% from last week</p>
            </div>

            <!-- Total Reservations Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Reservations (Month)</p>
                        <p class="text-3xl font-semibold text-gray-900">156</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mt-3">↑ 12% from last month</p>
            </div>

            <!-- Resources in Maintenance Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Resources in Maintenance</p>
                        <p class="text-3xl font-semibold text-gray-900">3</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mt-3">3 resources (12.5% of total)</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Reservations by Resource Type -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Reservations by Resource Type</h3>
                <div class="relative h-64">
                    <canvas id="typeChart"></canvas>
                </div>
                <div class="mt-4 flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-blue-600"></div>
                        <span class="text-gray-700">Server (45)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-green-600"></div>
                        <span class="text-gray-700">VM (38)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-orange-600"></div>
                        <span class="text-gray-700">Storage (42)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-purple-600"></div>
                        <span class="text-gray-700">Network (31)</span>
                    </div>
                </div>
            </div>

            <!-- Resources by Status -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resources by Status</h3>
                <div class="relative h-64">
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="mt-4 flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-green-500"></div>
                        <span class="text-gray-700">Available (12)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-orange-500"></div>
                        <span class="text-gray-700">Reserved (8)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-gray-400"></div>
                        <span class="text-gray-700">Maintenance (3)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded bg-red-500"></div>
                        <span class="text-gray-700">Down (1)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservations Over Time -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reservations Over Time (Last 30 Days)</h3>
            <div class="relative h-80">
                <canvas id="timeChart"></canvas>
            </div>
            <div class="mt-4 flex flex-wrap gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-1 bg-blue-600"></div>
                    <span class="text-gray-700">New Reservations</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-1 bg-green-600"></div>
                    <span class="text-gray-700">Approved</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-1 bg-red-600"></div>
                    <span class="text-gray-700">Rejected</span>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-8">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-900 hover:underline text-sm">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Include Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>

<script>
let typeChart, statusChart, timeChart;

// Initialize all charts
document.addEventListener('DOMContentLoaded', function() {
    initializeTypeChart();
    initializeStatusChart();
    initializeTimeChart();
});

function initializeTypeChart() {
    const ctx = document.getElementById('typeChart').getContext('2d');
    typeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Server', 'VM', 'Storage', 'Network'],
            datasets: [{
                label: 'Reservations',
                data: [45, 38, 42, 31],
                backgroundColor: [
                    'rgba(37, 99, 235, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(234, 88, 12, 0.8)',
                    'rgba(147, 51, 234, 0.8)'
                ],
                borderColor: [
                    'rgb(37, 99, 235)',
                    'rgb(34, 197, 94)',
                    'rgb(234, 88, 12)',
                    'rgb(147, 51, 234)'
                ],
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
}

function initializeStatusChart() {
    const ctx = document.getElementById('statusChart').getContext('2d');
    statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Reserved', 'Maintenance', 'Down'],
            datasets: [{
                data: [12, 8, 3, 1],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(234, 88, 12, 0.8)',
                    'rgba(156, 163, 175, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgb(34, 197, 94)',
                    'rgb(234, 88, 12)',
                    'rgb(156, 163, 175)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}

function initializeTimeChart() {
    const ctx = document.getElementById('timeChart').getContext('2d');
    timeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan 1', 'Jan 3', 'Jan 5', 'Jan 7', 'Jan 9', 'Jan 11', 'Jan 13', 'Jan 15', 'Jan 17', 'Jan 19', 'Jan 21', 'Jan 23', 'Jan 25', 'Jan 27', 'Jan 29', 'Jan 31'],
            datasets: [
                {
                    label: 'New Reservations',
                    data: [8, 12, 15, 10, 14, 18, 16, 20, 19, 21, 24, 22, 25, 23, 26, 28],
                    borderColor: 'rgb(37, 99, 235)',
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgb(37, 99, 235)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                },
                {
                    label: 'Approved',
                    data: [6, 10, 12, 9, 11, 15, 13, 17, 16, 18, 20, 19, 22, 20, 23, 25],
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgb(34, 197, 94)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                },
                {
                    label: 'Rejected',
                    data: [1, 1, 2, 0, 2, 2, 2, 2, 2, 2, 3, 2, 2, 2, 2, 2],
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgb(239, 68, 68)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 12
                        },
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'line'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
}

function updateCharts(dateRange) {
    const selectedRange = dateRange || document.getElementById('dateRange').value;
    const selectedType = document.getElementById('resourceType').value;
    
    console.log('Updating charts with range:', selectedRange, 'type:', selectedType);
    // API call would go here to fetch updated data
}

function refreshStatistics() {
    console.log('Refreshing statistics...');
    // Show loading indicator or toast
    // Then make API call to refresh data
}
</script>
@endsection
