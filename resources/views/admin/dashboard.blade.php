@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-25 to-gray-50">

    <!-- Main Content -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Dashboard Overview</h1>
                <div class="flex items-center">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></div>
                    <p class="text-gray-600 font-medium">
                        System status: <span class="text-emerald-600">All systems operational</span>
                    </p>
                </div>
            </div>
            <div class="mt-4 md:mt-0 p-3 bg-white rounded-xl shadow-xs border border-gray-100 flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <i class="fas fa-calendar-day text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-medium">Today's date</p>
                    <p class="text-sm font-semibold text-gray-800">{{ now()->format('l, F j, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-5 transition-all duration-300 hover:shadow-sm hover:-translate-y-1">
                <div class="flex justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total Users</p>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $users }}</h3>
                        <div class="flex items-center text-xs">
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full mr-2">+12.5%</span>
                            <span class="text-gray-500">vs last month</span>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <i class="fas fa-users text-indigo-600"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                        <span>View all users</span>
                        <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-5 transition-all duration-300 hover:shadow-sm hover:-translate-y-1">
                <div class="flex justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Locations</p>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $locations }}</h3>
                        <div class="flex items-center text-xs">
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full mr-2">+8.3%</span>
                            <span class="text-gray-500">vs last month</span>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.locations.index') }}" class="text-xs font-medium text-blue-600 hover:text-blue-800 flex items-center">
                        <span>Manage locations</span>
                        <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-5 transition-all duration-300 hover:shadow-sm hover:-translate-y-1">
                <div class="flex justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Rooms</p>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $rooms }}</h3>
                        <div class="flex items-center text-xs">
                            <span class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full mr-2">+5.2%</span>
                            <span class="text-gray-500">vs last month</span>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                        <i class="fas fa-door-open text-amber-600"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.rooms.index') }}" class="text-xs font-medium text-amber-600 hover:text-amber-800 flex items-center">
                        <span>Manage rooms</span>
                        <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-5 transition-all duration-300 hover:shadow-sm hover:-translate-y-1">
                <div class="flex justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Today's Attendance</p>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $attendancesToday }}</h3>
                        <div class="flex items-center text-xs">
                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full mr-2">{{ round(($attendancesToday/$users)*100) }}%</span>
                            <span class="text-gray-500">of total users</span>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-purple-600"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500" style="width: {{ ($attendancesToday/$users)*100 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Stat Card 5 -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-5 transition-all duration-300 hover:shadow-sm hover:-translate-y-1">
                <div class="flex justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Pending Requests</p>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $pendingPermissions }}</h3>
                        <div class="flex items-center text-xs">
                            <span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded-full mr-2">+3 new</span>
                            <span class="text-gray-500">since yesterday</span>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-rose-50 flex items-center justify-center">
                        <i class="fas fa-hourglass-half text-rose-600"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-100">
                    <a href="#" class="text-xs font-medium text-rose-600 hover:text-rose-800 flex items-center">
                        <span>Review requests</span>
                        <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Analytics Chart -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Attendance Analytics</h3>
                            <p class="text-xs text-gray-500 mt-1">Weekly overview of check-ins</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="relative">
                                <select class="appearance-none bg-gray-50 text-gray-700 py-1.5 px-3 pr-8 rounded-lg text-xs font-medium focus:outline-none focus:ring-1 focus:ring-indigo-500 border border-gray-200">
                                    <option>This Week</option>
                                    <option>Last Week</option>
                                    <option>This Month</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fas fa-chevron-down text-[10px]"></i>
                                </div>
                            </div>
                            <button class="p-1.5 bg-gray-50 text-gray-700 rounded-lg border border-gray-200 hover:bg-gray-100">
                                <i class="fas fa-download text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="h-80">
                        <canvas id="analyticsChart"></canvas>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">Daily Average</p>
                            <p class="text-lg font-bold text-gray-900">{{ round(array_sum($data)/7) }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">Highest Day</p>
                            <p class="text-lg font-bold text-gray-900">{{ max($data) }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">Lowest Day</p>
                            <p class="text-lg font-bold text-gray-900">{{ min($data) }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <p class="text-xs text-gray-500 mb-1">Weekly Total</p>
                            <p class="text-lg font-bold text-gray-900">{{ array_sum($data) }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>Data from {{ now()->startOfWeek()->format('M j') }} - {{ now()->endOfWeek()->format('M j, Y') }}</span>
                        </div>
                        <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                            <span>Detailed report</span>
                            <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Recent Activity</h3>
                                <p class="text-xs text-gray-500 mt-1">Latest system events</p>
                            </div>
                            <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                                <span>View all</span>
                                <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100 max-h-[360px] overflow-y-auto">
                        <!-- Activity Item -->
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-check text-emerald-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">Check-in recorded</p>
                                        <span class="text-xs text-gray-500">2 min ago</span>
                                    </div>
                                    <p class="text-xs text-gray-500">John Doe - Classroom 3A</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item -->
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-user-plus text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">New user registered</p>
                                        <span class="text-xs text-gray-500">1 hour ago</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Jane Smith - Teacher</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item -->
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-exclamation text-rose-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">Permission request</p>
                                        <span class="text-xs text-gray-500">3 hours ago</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Michael Brown - Sick leave</p>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Item -->
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-amber-600 text-xs"></i>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">New location added</p>
                                        <span class="text-xs text-gray-500">5 hours ago</span>
                                    </div>
                                    <p class="text-xs text-gray-500">Building C - Admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-4 grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.users.create') }}" class="p-3 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors group">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center mr-3 group-hover:bg-indigo-200 transition-colors">
                                    <i class="fas fa-user-plus text-indigo-600 text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Add User</span>
                            </div>
                        </a>

                        <a href="{{ route('admin.locations.create') }}" class="p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-map-marker-alt text-blue-600 text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Add Location</span>
                            </div>
                        </a>

                        <a href="{{ route('admin.rooms.create') }}" class="p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors group">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center mr-3 group-hover:bg-amber-200 transition-colors">
                                    <i class="fas fa-door-open text-amber-600 text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Add Room</span>
                            </div>
                        </a>

                        <a href="#" class="p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors">
                                    <i class="fas fa-file-export text-purple-600 text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Export Data</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize Analytics Chart
    const ctx = document.getElementById('analyticsChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.02)');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Attendance',
                data: @json($data),
                backgroundColor: gradient,
                borderColor: '#6366f1',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6366f1',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#111827',
                    bodyColor: '#6b7280',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            return context.parsed.y + ' check-ins';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#9ca3af'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#9ca3af'
                    }
                }
            }
        }
    });

    // Animate stat numbers
    document.querySelectorAll('.stat-number').forEach(element => {
        const target = parseInt(element.textContent);
        const duration = 1500;
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const animate = () => {
            current += increment;
            if (current > target) current = target;
            element.textContent = Math.floor(current);
            if (current < target) {
                requestAnimationFrame(animate);
            }
        };

        animate();
    });
</script>

<style>
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    /* Smooth transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    /* Shadow styles */
    .shadow-xs {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    /* Custom animations */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endsection
@endsection
