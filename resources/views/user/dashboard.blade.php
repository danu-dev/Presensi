@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Hero Header with Glassmorphism Effect -->
    <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 shadow-xl backdrop-blur-sm bg-opacity-90">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="text-white mb-4 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-bold">Selamat datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-blue-100 mt-2 opacity-90">{{ now()->translatedFormat('l, d F Y') }}</p>
                <div class="mt-3 bg-white/10 backdrop-blur-sm px-4 py-1.5 rounded-full inline-flex items-center border border-white/20">
                    <span class="relative flex h-2 w-2 mr-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <p class="text-white text-sm font-medium">Status: <span class="font-semibold">Aktif</span></p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ url('user/attendance') }}" class="bg-white/90 hover:bg-white text-indigo-700 font-medium py-2.5 px-5 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    Absen Sekarang
                </a>
                <a href="{{ url('user/permission') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white font-medium py-2.5 px-5 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                    </svg>
                    Ajukan Izin
                </a>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Attendance Snapshot Card -->
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Snapshot Kehadiran</h3>
                        <p class="text-sm text-gray-500 mt-1">Aktivitas minggu ini</p>
                    </div>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2.5 py-1 rounded-full font-medium">Minggu Ini</span>
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

                                if ($status == 'Sudah Absen Keluar') {
                                    $statusClass = 'bg-gradient-to-br from-green-400 to-green-500';
                                    $statusIcon = 'fa-check';
                                    $tooltip = 'Hadir';
                                } elseif ($status == 'partial') {
                                    $statusClass = 'bg-gradient-to-br from-yellow-400 to-yellow-500';
                                    $statusIcon = 'fa-hourglass-half';
                                    $tooltip = 'Check-in';
                                } else {
                                    $statusClass = $day->isPast() ? 'bg-gradient-to-br from-red-400 to-red-500' : 'bg-gray-200';
                                    $statusIcon = $day->isPast() ? 'fa-times' : 'fa-clock';
                                    $tooltip = $day->isPast() ? 'Absen' : 'Belum waktunya';
                                }

                                $ringClass = $day->isToday() ? 'ring-4 ring-blue-300/50' : '';
                            @endphp

                            <div class="text-center flex flex-col items-center group" x-data="{ showTooltip: false }">
                                <p class="text-gray-500 text-xs mb-2 font-medium">{{ substr($days[$i], 0, 3) }}</p>
                                <div class="relative" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
                                    <div class="w-14 h-14 {{ $statusClass }} {{ $ringClass }} rounded-full flex items-center justify-center shadow-sm transition-all duration-300 group-hover:scale-110 group-hover:shadow-md">
                                        <span class="text-white text-lg font-semibold">{{ $day->day }}</span>
                                    </div>
                                    <div class="absolute -top-1 -right-1 bg-white rounded-full w-5 h-5 flex items-center justify-center shadow-sm border border-gray-100">
                                        <i class="fas {{ $statusIcon }} text-xs {{ $day->isPast() && !isset($attendanceRecords[$dateKey]) ? 'text-red-500' : 'text-white' }}"></i>
                                    </div>

                                    <div x-show="showTooltip" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-1"
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1.5 bg-gray-800 text-white text-xs rounded-lg whitespace-nowrap shadow-lg">
                                        {{ $tooltip }}
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
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
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-lg">Statistik Bulan Ini</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ now()->translatedFormat('F Y') }}</p>
                </div>
                <div class="grid grid-cols-2 h-[calc(100%-72px)]">
                    <div class="flex flex-col items-center justify-center p-6 border-r border-gray-100 transition-all hover:bg-green-50/50 group">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3 transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-3xl font-bold text-gray-800 group-hover:text-green-600">{{ $stats['present'] ?? 0 }}</h4>
                        <p class="text-gray-500 text-sm mt-1">Kehadiran</p>
                        <div class="mt-2 text-xs text-green-500 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                            {{ round(($stats['present'] ?? 0)/20*100) }}% dari target
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center p-6 transition-all hover:bg-yellow-50/50 group">
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-3 transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-3xl font-bold text-gray-800 group-hover:text-yellow-600">{{ $stats['permission'] ?? 0 }}</h4>
                        <p class="text-gray-500 text-sm mt-1">Izin</p>
                        <div class="mt-2 text-xs text-yellow-500 font-medium">
                            {{ round(($stats['permission'] ?? 0)/20*100) }}% dari kuota
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Attendance Chart -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Tren Kehadiran</h3>
                    <p class="text-sm text-gray-500 mt-1">7 hari terakhir</p>
                </div>
                <div class="flex space-x-3">
                    <div class="flex items-center">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 mr-1.5"></span>
                        <span class="text-xs text-gray-500">Hadir</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-yellow-400 mr-1.5"></span>
                        <span class="text-xs text-gray-500">Izin</span>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <canvas id="attendanceChart" height="240"></canvas>
            </div>
        </div>

        <!-- Recent Attendance -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Riwayat Terbaru</h3>
                    <p class="text-sm text-gray-500 mt-1">5 absensi terakhir</p>
                </div>
                <a href="{{ url('user/history') }}" class="text-sm text-blue-500 hover:text-blue-700 font-medium flex items-center">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <div class="p-3 max-h-[320px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-50">
                @forelse ($attendances as $attendance)
                    <div class="p-3 border-b border-gray-100 last:border-0 hover:bg-gray-50/50 rounded-lg transition-colors group">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                @if ($attendance->check_in && $attendance->check_out)
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 transition-transform group-hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @elseif ($attendance->check_in)
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3 transition-transform group-hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3 transition-transform group-hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">{{ $attendance->location->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $attendance->room->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-700">{{ $attendance->check_in->translatedFormat('d M Y') }}</p>
                                <div class="flex items-center text-xs text-gray-500 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $attendance->check_in->format('H:i') }}
                                    @if($attendance->check_out)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-2 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $attendance->check_out->format('H:i') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <div class="w-16 h-16 bg-blue-50 rounded-full mx-auto flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 mb-1">Belum ada riwayat absensi</p>
                        <a href="{{ url('user/attendance') }}" class="text-blue-500 hover:text-blue-700 font-medium text-sm inline-flex items-center">
                            Mulai Absen Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Announcements & Tips Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Announcements -->
        <div class="col-span-1 lg:col-span-2 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg">Pengumuman Penting</h3>
                <p class="text-sm text-gray-500 mt-1">Informasi terbaru untuk siswa</p>
            </div>
            <div class="p-5">
                @forelse ($announcements as $announcement)
                    @php
                        $bgGradient = $announcement->urgency == 'high' ? 'from-red-50 to-red-100' : ($announcement->urgency == 'medium' ? 'from-yellow-50 to-yellow-100' : 'from-blue-50 to-blue-100');
                        $borderColor = $announcement->urgency == 'high' ? 'border-red-100 hover:border-red-200' : ($announcement->urgency == 'medium' ? 'border-yellow-100 hover:border-yellow-200' : 'border-blue-100 hover:border-blue-200');
                        $iconColor = $announcement->urgency == 'high' ? 'text-red-500' : ($announcement->urgency == 'medium' ? 'text-yellow-500' : 'text-blue-500');
                        $titleColor = $announcement->urgency == 'high' ? 'text-red-700' : ($announcement->urgency == 'medium' ? 'text-yellow-700' : 'text-blue-700');
                        $textColor = $announcement->urgency == 'high' ? 'text-red-600' : ($announcement->urgency == 'medium' ? 'text-yellow-600' : 'text-blue-600');
                    @endphp
                    <div class="flex items-start mb-4 bg-gradient-to-r {{ $bgGradient }} p-4 rounded-xl border {{ $borderColor }} group transition-colors cursor-pointer"
                         @click="$store.announcementModal.openModal({
                             title: '{{ addslashes($announcement->title) }}',
                             description: '{{ addslashes($announcement->description) }}',
                             urgency: '{{ $announcement->urgency }}',
                             creator: '{{ addslashes($announcement->creator->name) }}',
                             created_at: '{{ $announcement->created_at->translatedFormat('d M Y') }}',
                             expires_at: '{{ $announcement->expires_at ? $announcement->expires_at->translatedFormat('d M Y') : '' }}',
                             room: '{{ $announcement->room ? addslashes($announcement->room->name) : 'Semua Ruangan' }}'
                         })">
                        <div class="flex-shrink-0 w-10 h-10 bg-{{ $announcement->urgency == 'high' ? 'red' : ($announcement->urgency == 'medium' ? 'yellow' : 'blue') }}-100 rounded-full flex items-center justify-center mr-4 transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $iconColor }}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold {{ $titleColor }} mb-1">{{ $announcement->title }}</h4>
                            <p class="text-sm {{ $textColor }}">{{ Str::limit($announcement->description, 100) }}</p>
                            <div class="mt-2 flex items-center text-xs {{ $textColor }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                Diposting oleh {{ $announcement->creator->name }} pada {{ $announcement->created_at->translatedFormat('d M Y') }}
                                @if($announcement->expires_at)
                                    | Kadaluarsa: {{ $announcement->expires_at->translatedFormat('d M Y') }}
                                @endif
                                | Ruangan: {{ $announcement->room ? $announcement->room->name : 'Semua Ruangan' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center">
                        <div class="w-16 h-16 bg-blue-50 rounded-full mx-auto flex items-center justify-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-500">Tidak ada pengumuman saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg">Tips Absensi</h3>
                <p class="text-sm text-gray-500 mt-1">Cara optimal menggunakan sistem</p>
            </div>
            <div class="p-5">
                <div class="space-y-4">
                    <div class="flex items-center p-3 rounded-lg hover:bg-green-50/50 transition-colors group">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600">Datang 15 menit lebih awal untuk menghindari keterlambatan</p>
                    </div>

                    <div class="flex items-center p-3 rounded-lg hover:bg-yellow-50/50 transition-colors group">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3 transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600">Pastikan GPS smartphone aktif saat melakukan absensi</p>
                    </div>

                    <div class="flex items-center p-3 rounded-lg hover:bg-red-50/50 transition-colors group">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3 transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600">Jangan lupa checkout setelah selesai kegiatan</p>
                    </div>

                    <div class="flex items-center p-3 rounded-lg hover:bg-blue-50/50 transition-colors group">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 transition-transform group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-600">Hubungi admin jika menemui masalah teknis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcement Modal -->
    <div x-data="announcementModal" x-show="isOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         @click.self="closeModal">
        <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 backdrop-blur-sm bg-opacity-95 border border-gray-100"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800" x-text="announcement.title"></h3>
                <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div :class="{
                'bg-red-50 border-red-200': announcement.urgency === 'high',
                'bg-yellow-50 border-yellow-200': announcement.urgency === 'medium',
                'bg-blue-50 border-blue-200': announcement.urgency === 'low'
            }" class="p-4 rounded-xl border">
                <p class="text-gray-700 mb-2" x-text="announcement.description"></p>
                <div class="text-sm text-gray-600">
                    <p><span class="font-medium">Urgensi:</span> <span x-text="announcement.urgency.charAt(0).toUpperCase() + announcement.urgency.slice(1)"></span></p>
                    <p><span class="font-medium">Dibuat oleh:</span> <span x-text="announcement.creator"></span></p>
                    <p><span class="font-medium">Tanggal Dibuat:</span> <span x-text="announcement.created_at"></span></p>
                    <p><span class="font-medium">Ruangan:</span> <span x-text="announcement.room"></span></p>
                    <p x-show="announcement.expires_at"><span class="font-medium">Kadaluarsa:</span> <span x-text="announcement.expires_at"></span></p>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button @click="closeModal" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                    Tutup
                </button>
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
        // Initialize Alpine.js store for announcement modal
        Alpine.store('announcementModal', {
            isOpen: false,
            announcement: {
                title: '',
                description: '',
                urgency: '',
                creator: '',
                created_at: '',
                expires_at: '',
                room: ''
            },
            openModal(data) {
                this.announcement = data;
                this.isOpen = true;
            },
            closeModal() {
                this.isOpen = false;
                this.announcement = {
                    title: '',
                    description: '',
                    urgency: '',
                    creator: '',
                    created_at: '',
                    expires_at: '',
                    room: ''
                };
            }
        });

        // Chart.js for Attendance Trend
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const labels = [];
        for (let i = 6; i >= 0; i--) {
            const d = new Date();
            d.setDate(d.getDate() - i);
            labels.push(d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }));
        }

        const attendances = @json($attendances);
        const permissions = @json(auth()->user()->permissions()
            ->whereBetween('date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->get());

        const presentData = new Array(7).fill(0);
        const permissionData = new Array(7).fill(0);
        const userId = {{ auth()->id() }};
        const today = new Date('{{ now()->toDateString() }}');
        const startDate = new Date(today);
        startDate.setDate(today.getDate() - 6);

        // Process attendance data
        attendances.forEach(attendance => {
            if (attendance.user_id === userId) {
                const checkInDate = new Date(attendance.check_in);
                if (checkInDate >= startDate && checkInDate <= today) {
                    const dayIndex = Math.floor((today - checkInDate) / (1000 * 60 * 60 * 24));
                    if (attendance.check_in && (attendance.check_out || attendance.status === 'Sudah Absen')) {
                        presentData[6 - dayIndex]++;
                    }
                }
            }
        });

        // Process permission data
        permissions.forEach(permission => {
            const permissionDate = new Date(permission.date);
            if (permissionDate >= startDate && permissionDate <= today && permission.status === 'approved') {
                const dayIndex = Math.floor((today - permissionDate) / (1000 * 60 * 60 * 24));
                permissionData[6 - dayIndex]++;
            }
        });

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Hadir',
                        data: presentData,
                        borderColor: '#40c057',
                        backgroundColor: 'rgba(64, 192, 87, 0.05)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointBackgroundColor: '#40c057',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBorderWidth: 2,
                        pointBorderColor: '#ffffff'
                    },
                    {
                        label: 'Izin',
                        data: permissionData,
                        borderColor: '#ffd43b',
                        backgroundColor: 'rgba(255, 212, 59, 0.05)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointBackgroundColor: '#ffd43b',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBorderWidth: 2,
                        pointBorderColor: '#ffffff'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: { size: 12 },
                        bodyFont: { size: 10 },
                        padding: 10
                    }
                }
            }
        });
    });
</script>
@endsection
