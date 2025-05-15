@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header with modern greeting -->
    <div class="mb-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl p-6 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-white mb-4 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-bold">Halo, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-blue-100 mt-2">{{ now()->format('l, d F Y') }}</p>
                <div class="mt-3 bg-white/20 px-3 py-1 rounded-full inline-block backdrop-blur-sm">
                    <p class="text-white text-sm">Status: <span class="font-semibold">Aktif</span></p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ url('user/attendance') }}" class="bg-white text-indigo-700 hover:bg-blue-50 font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center">
                    <i class="fas fa-clock mr-2"></i> Absen
                </a>
                <a href="{{ url('user/permission') }}" class="bg-indigo-700 text-white hover:bg-indigo-800 font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center">
                    <i class="fas fa-envelope mr-2"></i> Izin
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Attendance Snapshot Card -->
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full border border-gray-100">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-lg">Snapshot Kehadiran</h3>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Minggu Ini</span>
                </div>
                <div class="p-5">
                    <div class="flex flex-wrap gap-6 justify-between">
                        @php
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                            $currentDay = now()->startOfDay();
                            $startOfWeek = $currentDay->copy()->startOfWeek();
                            $attendanceRecords = $attendanceRecords ?? [];
                        @endphp

                        @for ($i = 0; $i < 5; $i++)
                            @php
                                $day = $startOfWeek->copy()->addDays($i);
                                $dateKey = $day->format('Y-m-d');
                                $status = $attendanceRecords[$dateKey] ?? 'absent';

                                // Determine status class and icon
                                if ($status == 'present') {
                                    $statusClass = 'bg-green-500';
                                    $statusIcon = 'fa-check';
                                    $tooltip = 'Hadir';
                                } elseif ($status == 'partial') {
                                    $statusClass = 'bg-yellow-500';
                                    $statusIcon = 'fa-hourglass-half';
                                    $tooltip = 'Check-in';
                                } elseif (isset($attendanceRecords[$dateKey])) {
                                    $statusClass = 'bg-red-500';
                                    $statusIcon = 'fa-times';
                                    $tooltip = 'Absen';
                                } else {
                                    $statusClass = $day->isPast() ? 'bg-red-500' : 'bg-gray-200';
                                    $statusIcon = $day->isPast() ? 'fa-times' : 'fa-clock';
                                    $tooltip = $day->isPast() ? 'Absen' : 'Belum waktunya';
                                }

                                // Today highlight
                                $ringClass = $day->isToday() ? 'ring-4 ring-blue-300 ring-opacity-50' : '';
                            @endphp

                            <div class="text-center flex flex-col items-center" x-data="{ showTooltip: false }">
                                <p class="text-gray-400 text-xs mb-2">{{ substr($days[$i], 0, 3) }}</p>
                                <div class="relative" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
                                    <div class="w-14 h-14 {{ $statusClass }} {{ $ringClass }} rounded-full flex items-center justify-center shadow-sm transition-transform hover:-translate-y-1 duration-300">
                                        <span class="text-white text-xl font-medium">{{ $day->day }}</span>
                                    </div>
                                    <div class="absolute -top-1 -right-1 {{ $statusClass }} rounded-full w-5 h-5 flex items-center justify-center shadow-sm">
                                        <i class="fas {{ $statusIcon }} text-white text-xs"></i>
                                    </div>

                                    <!-- Tooltip -->
                                    <div x-show="showTooltip" x-transition class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded whitespace-nowrap">
                                        {{ $tooltip }}
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Card -->
        <div class="col-span-1">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full border border-gray-100">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-lg">Statistik Bulan Ini</h3>
                </div>
                <div class="grid grid-cols-2 h-[calc(100%-64px)]">
                    <div class="flex flex-col items-center justify-center p-6 border-r border-gray-100 transition-colors hover:bg-green-50">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                        </div>
                        <h4 class="text-3xl font-bold text-green-500">{{ $stats['present'] ?? 0 }}</h4>
                        <p class="text-gray-500 text-sm mt-1">Kehadiran</p>
                    </div>
                    <div class="flex flex-col items-center justify-center p-6 transition-colors hover:bg-yellow-50">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-envelope text-yellow-500 text-2xl"></i>
                        </div>
                        <h4 class="text-3xl font-bold text-yellow-500">{{ $stats['permission'] ?? 0 }}</h4>
                        <p class="text-gray-500 text-sm mt-1">Izin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Attendance Chart -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 text-lg">Tren Kehadiran</h3>
                <div class="flex space-x-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="text-xs text-gray-500">Hadir</span>
                    <span class="inline-block w-3 h-3 rounded-full bg-yellow-400 ml-2"></span>
                    <span class="text-xs text-gray-500">Izin</span>
                </div>
            </div>
            <div class="p-5">
                <canvas id="attendanceChart" height="240"></canvas>
            </div>
        </div>

        <!-- Recent Attendance -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 text-lg">Riwayat Terbaru</h3>
                <a href="{{ url('user/history') }}" class="text-sm text-blue-500 hover:text-blue-700 font-medium">Lihat Semua</a>
            </div>
            <div class="p-3 max-h-[320px] overflow-y-auto">
                @forelse ($attendances as $attendance)
                    <div class="p-3 border-b border-gray-100 last:border-0 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                @if ($attendance->check_in && $attendance->check_out)
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-green-500"></i>
                                    </div>
                                @elseif ($attendance->check_in)
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-hourglass-half text-yellow-500"></i>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-times text-red-500"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">{{ $attendance->location->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $attendance->room->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-700">{{ $attendance->check_in->format('d M Y') }}</p>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <i class="fas fa-sign-in-alt mr-1"></i> {{ $attendance->check_in->format('H:i') }}
                                    @if($attendance->check_out)
                                    <i class="fas fa-sign-out-alt ml-2 mr-1"></i> {{ $attendance->check_out->format('H:i') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <div class="w-16 h-16 bg-blue-50 rounded-full mx-auto flex items-center justify-center mb-3">
                            <i class="fas fa-calendar-times text-blue-300 text-xl"></i>
                        </div>
                        <p class="text-gray-500 mb-1">Belum ada riwayat absensi</p>
                        <a href="{{ url('user/attendance') }}" class="text-blue-500 hover:text-blue-700 font-medium text-sm">Mulai Absen Sekarang</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Announcements & Tips Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Announcements -->
        <div class="col-span-1 lg:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg">Pengumuman Penting</h3>
            </div>
            <div class="p-5">
                <div class="flex items-start mb-4 bg-blue-50 p-4 rounded-xl">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-bullhorn text-blue-500"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-700 mb-1">Jadwal Ujian Tengah Semester</h4>
                        <p class="text-blue-600 text-sm">Ujian Tengah Semester akan dilaksanakan dari tanggal 15-20 April 2025. Pastikan kehadiran minimum 80% untuk mengikuti ujian.</p>
                    </div>
                </div>

                <div class="flex items-start bg-indigo-50 p-4 rounded-xl">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-indigo-500"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-indigo-700 mb-1">Pengaturan Absensi</h4>
                        <p class="text-indigo-600 text-sm">Jangan lupa absen sebelum pukul 08:00 setiap hari. Izin harus diajukan minimal 1 hari sebelumnya dengan bukti yang valid.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg">Tips Absensi</h3>
            </div>
            <div class="p-5">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-green-500 text-sm"></i>
                        </div>
                        <p class="text-sm text-gray-600">Datang 15 menit lebih awal untuk menghindari keterlambatan</p>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-map-marker-alt text-yellow-500 text-sm"></i>
                        </div>
                        <p class="text-sm text-gray-600">Pastikan GPS smartphone aktif saat melakukan absensi</p>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-triangle text-red-500 text-sm"></i>
                        </div>
                        <p class="text-sm text-gray-600">Jangan lupa checkout setelah selesai kegiatan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('attendanceChart').getContext('2d');

        // Generate last 7 days for chart
        const labels = [];
        for (let i = 6; i >= 0; i--) {
            const d = new Date();
            d.setDate(d.getDate() - i);
            labels.push(d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
        }

        // Sample data - in real app, this would come from backend
        const presentData = [5, 4, 6, 5, 5, 4, {{ $stats['present'] ?? 0 }}];
        const permissionData = [0, 1, 0, 0, 0, 1, {{ $stats['permission'] ?? 0 }}];

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Hadir',
                        data: presentData,
                        borderColor: '#40c057',
                        backgroundColor: 'rgba(64, 192, 87, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointBackgroundColor: '#40c057',
                        pointRadius: 3,
                        pointHoverRadius: 5
                    },
                    {
                        label: 'Izin',
                        data: permissionData,
                        borderColor: '#ffd43b',
                        backgroundColor: 'rgba(255, 212, 59, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffd43b',
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        ticks: {
                            stepSize: 2,
                            font: {
                                size: 10
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    });
</script>
@endsection
