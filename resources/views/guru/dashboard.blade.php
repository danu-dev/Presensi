@extends('layouts.app')
@section('title', 'Dashboard Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-8 md:px-8 md:py-10 flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white">
                        Selamat {{ now()->format('H') < 12 ? 'Pagi' : (now()->format('H') < 15 ? 'Siang' : (now()->format('H') < 18 ? 'Sore' : 'Malam')) }}, 
                        <span class="text-yellow-300">{{ auth()->user()->name }}</span>
                    </h1>
                    <p class="text-blue-100 mt-2 md:text-lg">{{ now()->locale('id')->format('l, d F Y') }}</p>
                </div>
                <div class="flex items-center bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-3">
                    <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-check text-blue-700 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Status sistem</p>
                        <p class="text-white font-semibold">Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <!-- Ruangan Dikelola -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-6 flex justify-between">
                    <div>
                        <p class="text-gray-500 font-medium text-sm">Ruangan Dikelola</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $rooms->count() }}</h3>
                        <p class="text-green-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-check-circle mr-1"></i> Terintegrasi
                        </p>
                    </div>
                    <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-door-open text-green-500 text-2xl"></i>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3">
                    <a href="{{ url('guru/rooms') }}" class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center">
                        Detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Izin Menunggu -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-6 flex justify-between">
                    <div>
                        <p class="text-gray-500 font-medium text-sm">Izin Menunggu</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $pendingPermissions ?? 0 }}</h3>
                        <p class="text-yellow-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-clock mr-1"></i> Perlu validasi
                        </p>
                    </div>
                    <div class="h-16 w-16 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope-open-text text-yellow-500 text-2xl"></i>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3">
                    <a href="{{ url('guru/permissions') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center">
                        Validasi sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Hadir Hari Ini -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-6 flex justify-between">
                    <div>
                        <p class="text-gray-500 font-medium text-sm">Hadir Hari Ini</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $todayStats['present'] ?? 0 }}</h3>
                        <p class="text-blue-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-user-check mr-1"></i> Siswa
                        </p>
                    </div>
                    <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-blue-500 text-2xl"></i>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3">
                    <a href="{{ url('guru/report?start_date=' . now()->toDateString() . '&end_date=' . now()->toDateString()) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center">
                        Lihat detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Izin Disetujui -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <div class="p-6 flex justify-between">
                    <div>
                        <p class="text-gray-500 font-medium text-sm">Izin Disetujui</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $todayStats['permission'] ?? 0 }}</h3>
                        <p class="text-indigo-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-file-alt mr-1"></i> Hari ini
                        </p>
                    </div>
                    <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-indigo-500 text-2xl"></i>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3">
                    <a href="{{ url('guru/permissions?status=approved&date=' . now()->toDateString()) }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium flex items-center">
                        Lihat detail <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Absensi Chart -->
            <div class="xl:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-chart-line mr-2 text-blue-500"></i>
                            Statistik Absensi Minggu Ini
                        </h3>
                        <div class="text-sm font-medium text-gray-500">
                            {{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M Y') }}
                        </div>
                    </div>
                    <div class="h-80 md:h-96">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pengumuman & Aksi -->
            <div class="xl:col-span-1">
                <!-- Aksi Cepat -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                        <h3 class="text-white font-bold flex items-center">
                            <i class="fas fa-bolt mr-2"></i> Aksi Cepat
                        </h3>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <a href="{{ url('guru/report') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-4 rounded-lg shadow hover:shadow-lg transition-all flex items-center justify-center">
                            <i class="fas fa-file-export mr-2"></i> Ekspor Laporan Absensi
                        </a>
                        
                        <a href="{{ url('guru/permissions') }}" class="bg-gradient-to-r from-indigo-400 to-indigo-500 text-white py-3 px-4 rounded-lg shadow hover:shadow-lg transition-all flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i> Validasi Izin Siswa
                        </a>
                        
                        <a href="{{ url('guru/manual-attendance') }}" class="bg-gradient-to-r from-green-400 to-green-500 text-white py-3 px-4 rounded-lg shadow hover:shadow-lg transition-all flex items-center justify-center">
                            <i class="fas fa-user-check mr-2"></i> Absen Manual
                        </a>
                        
                        <a href="#" class="bg-gradient-to-r from-purple-400 to-purple-500 text-white py-3 px-4 rounded-lg shadow hover:shadow-lg transition-all flex items-center justify-center">
                            <i class="fas fa-bell mr-2"></i> Buat Pengumuman
                        </a>
                    </div>
                </div>

                <!-- Pengumuman -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-6 py-4">
                        <h3 class="text-white font-bold flex items-center">
                            <i class="fas fa-bullhorn mr-2"></i> Pengumuman Penting
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-orange-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-orange-700 font-medium">
                                        Validasi izin harus dilakukan sebelum pukul 17:00
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700 font-medium">
                                        Rapat evaluasi guru akan dilaksanakan pada {{ now()->addDays(3)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Activity & Student List -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-8">
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <h3 class="text-white font-bold flex items-center">
                        <i class="fas fa-history mr-2"></i> Aktivitas Terbaru
                    </h3>
                </div>
                <div class="p-6">
                    <div class="divide-y divide-gray-100">
                        <div class="py-3 flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                <i class="fas fa-user-check text-blue-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Ahmad Syahrul melakukan absensi di Ruang 3A</p>
                                <p class="text-xs text-gray-500">{{ now()->subMinutes(15)->format('H:i') }} - {{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="py-3 flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Anda menyetujui izin dari Siti Rahma</p>
                                <p class="text-xs text-gray-500">{{ now()->subHours(2)->format('H:i') }} - {{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="py-3 flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                                <i class="fas fa-file-alt text-yellow-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Permintaan izin baru dari Budi Santoso</p>
                                <p class="text-xs text-gray-500">{{ now()->subHours(3)->format('H:i') }} - {{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="py-3 flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                                <i class="fas fa-file-export text-indigo-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Anda mengekspor laporan absensi</p>
                                <p class="text-xs text-gray-500">{{ now()->subDay()->format('H:i') }} - {{ now()->subDay()->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Status -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                    <h3 class="text-white font-bold flex items-center">
                        <i class="fas fa-users mr-2"></i> Status Siswa Hari Ini
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-around mb-6">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-2">
                                <i class="fas fa-user-check text-green-500 text-2xl"></i>
                            </div>
                            <h4 class="text-2xl font-bold text-gray-800">{{ $todayStats['present'] ?? 0 }}</h4>
                            <p class="text-sm text-gray-500">Hadir</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-2">
                                <i class="fas fa-file-alt text-yellow-500 text-2xl"></i>
                            </div>
                            <h4 class="text-2xl font-bold text-gray-800">{{ $todayStats['permission'] ?? 0 }}</h4>
                            <p class="text-sm text-gray-500">Izin</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-2">
                                <i class="fas fa-user-times text-red-500 text-2xl"></i>
                            </div>
                            <h4 class="text-2xl font-bold text-gray-800">{{ $todayStats['absent'] ?? 0 }}</h4>
                            <p class="text-sm text-gray-500">Absen</p>
                        </div>
                    </div>
                    
                    <div class="rounded-lg bg-gray-50 p-4">
                        <div class="flex justify-between items-center mb-3">
                            <h5 class="font-medium text-gray-700">Persentase Kehadiran</h5>
                            <span class="text-sm font-bold text-green-500">
                                @php
                                    $totalStudents = ($todayStats['present'] ?? 0) + ($todayStats['permission'] ?? 0) + ($todayStats['absent'] ?? 0);
                                    $presentPercentage = $totalStudents > 0 ? round((($todayStats['present'] ?? 0) / $totalStudents) * 100) : 0;
                                @endphp
                                {{ $presentPercentage }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $presentPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    
    // Day names and data from controller
    const dayNames = [@foreach($weeklyData as $data)'{{ $data['day'] }}'@if(!$loop->last),@endif @endforeach];
    const presentData = [@foreach($weeklyData as $data){{ $data['present'] }}@if(!$loop->last),@endif @endforeach];
    const permissionData = [@foreach($weeklyData as $data){{ $data['permission'] }}@if(!$loop->last),@endif @endforeach];
    const absentData = [@foreach($weeklyData as $data){{ $data['absent'] }}@if(!$loop->last),@endif @endforeach];
    
    const attendanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dayNames,
            datasets: [
                {
                    label: 'Hadir',
                    data: presentData,
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Izin',
                    data: permissionData,
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderColor: 'rgba(245, 158, 11, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Absen',
                    data: absentData,
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>
@endsection