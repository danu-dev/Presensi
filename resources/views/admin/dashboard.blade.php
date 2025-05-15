@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header with Greeting and Date -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 animate-fade-in">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 font-['Poppins']">Dashboard Admin</h1>
                <div class="flex items-center mt-2">
                    <div class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></div>
                    <p class="text-gray-600 font-medium">
                        Selamat datang kembali! Sistem berjalan normal.
                    </p>
                </div>
            </div>
            <div class="mt-4 md:mt-0 p-3 bg-white rounded-xl shadow-sm flex items-center space-x-3">
                <i class="fas fa-calendar-alt text-indigo-600"></i>
                <div>
                    <p class="text-sm text-gray-500">Hari ini</p>
                    <p class="text-base font-semibold text-gray-800">{{ now()->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Card 1: Total Users -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-sm p-5 transform transition-all duration-300 hover:shadow-md hover:scale-105">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-blue-600 mb-1">Total Pengguna</p>
                        <h3 class="text-3xl font-bold text-gray-800 font-['Poppins'] mb-2 count-up" data-target="{{ $users }}">0</h3>
                        <div class="flex items-center text-xs font-medium text-blue-800">
                            <span class="px-1.5 py-0.5 bg-blue-100 rounded-md mr-1">
                                <i class="fas fa-user-check"></i>
                            </span>
                            <span>Aktif & Terdaftar</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center shadow-md">
                        <i class="fas fa-users text-xl text-white"></i>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="mt-4 block text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    Kelola pengguna <i class="fas fa-chevron-right text-xs ml-1"></i>
                </a>
            </div>

            <!-- Card 2: Locations -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl shadow-sm p-5 transform transition-all duration-300 hover:shadow-md hover:scale-105">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-emerald-600 mb-1">Total Lokasi</p>
                        <h3 class="text-3xl font-bold text-gray-800 font-['Poppins'] mb-2 count-up" data-target="{{ $locations }}">0</h3>
                        <div class="flex items-center text-xs font-medium text-emerald-800">
                            <span class="px-1.5 py-0.5 bg-emerald-100 rounded-md mr-1">
                                <i class="fas fa-wifi"></i>
                            </span>
                            <span>Semua terpantau</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-emerald-500 flex items-center justify-center shadow-md">
                        <i class="fas fa-map-marker-alt text-xl text-white"></i>
                    </div>
                </div>
                <a href="{{ route('admin.locations.index') }}" class="mt-4 block text-sm font-medium text-emerald-600 hover:text-emerald-800 transition-colors">
                    Kelola lokasi <i class="fas fa-chevron-right text-xs ml-1"></i>
                </a>
            </div>

            <!-- Card 3: Rooms -->
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl shadow-sm p-5 transform transition-all duration-300 hover:shadow-md hover:scale-105">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-amber-600 mb-1">Total Ruangan</p>
                        <h3 class="text-3xl font-bold text-gray-800 font-['Poppins'] mb-2 count-up" data-target="{{ $rooms }}">0</h3>
                        <div class="flex items-center text-xs font-medium text-amber-800">
                            <span class="px-1.5 py-0.5 bg-amber-100 rounded-md mr-1">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </span>
                            <span>Tersedia untuk guru</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center shadow-md">
                        <i class="fas fa-door-open text-xl text-white"></i>
                    </div>
                </div>
                <a href="{{ route('admin.rooms.index') }}" class="mt-4 block text-sm font-medium text-amber-600 hover:text-amber-800 transition-colors">
                    Kelola ruangan <i class="fas fa-chevron-right text-xs ml-1"></i>
                </a>
            </div>

            <!-- Card 4: Today's Attendance -->
            <div class="bg-gradient-to-br from-violet-50 to-violet-100 rounded-2xl shadow-sm p-5 transform transition-all duration-300 hover:shadow-md hover:scale-105">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-violet-600 mb-1">Absensi Hari Ini</p>
                        <h3 class="text-3xl font-bold text-gray-800 font-['Poppins'] mb-2 count-up" data-target="{{ $attendancesToday }}">0</h3>
                        <div class="flex items-center text-xs font-medium text-violet-800">
                            <span class="px-1.5 py-0.5 bg-violet-100 rounded-md mr-1">
                                <i class="fas fa-clock"></i>
                            </span>
                            <span>{{ now()->format('H:i') }} WIB</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-violet-500 flex items-center justify-center shadow-md">
                        <i class="fas fa-clipboard-check text-xl text-white"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>Progress</span>
                        <span class="font-medium">{{ $attendancesToday }} / {{ $users }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-violet-600 h-2 rounded-full" style="width: {{ min(100, ($attendancesToday / max(1, $users)) * 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Card 5: Pending Permissions -->
            <div class="bg-gradient-to-br from-rose-50 to-rose-100 rounded-2xl shadow-sm p-5 transform transition-all duration-300 hover:shadow-md hover:scale-105">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-rose-600 mb-1">Izin Pending</p>
                        <h3 class="text-3xl font-bold text-gray-800 font-['Poppins'] mb-2 count-up" data-target="{{ $pendingPermissions }}">0</h3>
                        <div class="flex items-center text-xs font-medium text-rose-800">
                            <span class="px-1.5 py-0.5 bg-rose-100 rounded-md mr-1">
                                <i class="fas fa-hourglass-half"></i>
                            </span>
                            <span>Menunggu persetujuan</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-rose-500 flex items-center justify-center shadow-md">
                        <i class="fas fa-clipboard-list text-xl text-white"></i>
                    </div>
                </div>
                <a href="#" class="mt-4 block text-sm font-medium text-rose-600 hover:text-rose-800 transition-colors">
                    Tinjau sekarang <i class="fas fa-chevron-right text-xs ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Weekly Attendance Chart (Expanded) -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800 font-['Poppins']">Statistik Absensi Mingguan</h3>
                        <div class="flex items-center space-x-2">
                            <div class="relative">
                                <select class="appearance-none bg-gray-100 text-gray-700 py-1 px-3 pr-8 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option>Minggu Ini</option>
                                    <option>Minggu Lalu</option>
                                    <option>2 Minggu Lalu</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <button class="p-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                <i class="fas fa-download text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <div class="relative h-72">
                        <canvas id="attendanceChart"></canvas>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-calculator text-indigo-500 mr-1.5 text-xs"></i>
                                <p class="text-xs text-gray-500">Rata-rata Harian</p>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ round(array_sum($data) / max(1, count($data))) }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-arrow-up text-green-500 mr-1.5 text-xs"></i>
                                <p class="text-xs text-gray-500">Tertinggi</p>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ max($data) }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-arrow-down text-rose-500 mr-1.5 text-xs"></i>
                                <p class="text-xs text-gray-500">Terendah</p>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ min($data) }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-sum text-amber-500 mr-1.5 text-xs"></i>
                                <p class="text-xs text-gray-500">Total Minggu</p>
                            </div>
                            <p class="text-lg font-bold text-gray-800">{{ array_sum($data) }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-2"></i>
                            @php
                                $currentDay = now()->startOfDay();
                                $startOfWeek = $currentDay->copy()->startOfWeek();
                                $endOfWeek = $currentDay->copy()->endOfWeek();
                            @endphp
                            <span>Data dari {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}</span>
                        </div>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Analisis lanjutan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side Dashboard Elements -->
            <div class="space-y-8">
                <!-- Recent Activities Panel -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-800 font-['Poppins']">Aktivitas Terbaru</h3>
                            <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                                <span>Lihat semua</span>
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100 max-h-[360px] overflow-y-auto custom-scrollbar">
                        <!-- Activity Item 1 -->
                        <div class="flex items-center p-4 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex-shrink-0 flex items-center justify-center mr-4">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-800 truncate">Check-in berhasil</p>
                                    <span class="text-xs text-gray-500">{{ now()->subMinutes(5)->format('H:i') }}</span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Ahmad Fauzi - Ruang Kelas 3A
                                </p>
                            </div>
                        </div>

                        <!-- Activity Item 2 -->
                        <div class="flex items-center p-4 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex-shrink-0 flex items-center justify-center mr-4">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-800 truncate">Pengguna baru terdaftar</p>
                                    <span class="text-xs text-gray-500">{{ now()->subHours(2)->format('H:i') }}</span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Budi Santoso - Guru Matematika
                                </p>
                            </div>
                        </div>

                        <!-- Activity Item 3 -->
                        <div class="flex items-center p-4 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-rose-100 flex-shrink-0 flex items-center justify-center mr-4">
                                <i class="fas fa-exclamation-circle text-rose-600"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-800 truncate">Permintaan izin baru</p>
                                    <span class="text-xs text-gray-500">{{ now()->subHours(3)->format('H:i') }}</span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Dewi Susanti - Izin sakit
                                </p>
                            </div>
                        </div>

                        <!-- Activity Item 4 -->
                        <div class="flex items-center p-4 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-amber-100 flex-shrink-0 flex items-center justify-center mr-4">
                                <i class="fas fa-map-marked-alt text-amber-600"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-800 truncate">Lokasi baru ditambahkan</p>
                                    <span class="text-xs text-gray-500">{{ now()->subHours(5)->format('H:i') }}</span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Gedung Baru - Oleh Admin
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions and System Status -->
                <div class="grid grid-cols-1 gap-8">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 font-['Poppins']">Aksi Cepat</h3>
                        </div>

                        <div class="p-4 grid grid-cols-2 gap-3">
                            <a href="{{ route('admin.users.create') }}" class="flex items-center p-3 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-plus text-blue-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Tambah User</span>
                            </a>

                            <a href="{{ route('admin.locations.create') }}" class="flex items-center p-3 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">
                                <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-map-marker-plus text-emerald-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Tambah Lokasi</span>
                            </a>

                            <a href="{{ route('admin.rooms.create') }}" class="flex items-center p-3 bg-amber-50 rounded-xl hover:bg-amber-100 transition-colors">
                                <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-door-open text-amber-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Tambah Ruangan</span>
                            </a>

                            <a href="#" class="flex items-center p-3 bg-violet-50 rounded-xl hover:bg-violet-100 transition-colors">
                                <div class="w-9 h-9 rounded-full bg-violet-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-file-export text-violet-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-800">Export Laporan</span>
                            </a>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 font-['Poppins']">Status Sistem</h3>
                        </div>

                        <div class="p-6 space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Database</span>
                                    <span class="text-xs font-medium px-2 py-1 bg-green-100 text-green-800 rounded-full">Online</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 95%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Performa: 95%</p>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">API</span>
                                    <span class="text-xs font-medium px-2 py-1 bg-green-100 text-green-800 rounded-full">Online</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Performa: 100%</p>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Storage</span>
                                    <span class="text-xs font-medium px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">75% Used</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">187.5 GB / 250 GB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Animated count up effect for numbers
    document.querySelectorAll('.count-up').forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 1500;
        const increment = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current > target) current = target;
            counter.textContent = Math.floor(current);
            if (current < target) {
                requestAnimationFrame(updateCounter);
            }
        };

        updateCounter();
    });

    // Attendance Chart
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.25)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.02)');

    const weeklyLabels = @json($labels);
    const weeklyData = @json($data);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: weeklyLabels,
            datasets: [{
                label: 'Absensi',
                data: weeklyData,
                borderColor: '#6366f1',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#6366f1',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
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
                            family: "'Poppins', sans-serif",
                            size: 11
                        },
                        color: '#64748b'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Poppins', sans-serif",
                            size: 11
                        },
                        color: '#64748b'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1e293b',
                    bodyColor: '#475569',
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: {
                        family: "'Poppins', sans-serif",
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        family: "'Poppins', sans-serif",
                        size: 13
                    },
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return 'Hari ' + context[0].label;
                        },
                        label: function(context) {
                            return context.formattedValue + ' absensi tercatat';
                        }
                    }
                }
            }
        }
    });
</script>

<style>
    /* Custom Animations and Styling */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.4s ease-out;
    }

    /* Custom Scrollbar Styling */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>
@endsection
@endsection
