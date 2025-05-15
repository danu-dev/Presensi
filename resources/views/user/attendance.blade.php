@extends('layouts.app')

@section('title', 'Form Absensi')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <!-- Top Bar dengan Real-time Clock -->
    <div class="bg-white rounded-2xl p-4 shadow-md mb-6 flex flex-col md:flex-row justify-between items-center">
        <div class="flex items-center">
            <div class="bg-indigo-100 p-3 rounded-lg mr-4">
                <svg class="w-7 h-7 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">Form Absensi</h2>
                <p class="text-gray-500 text-sm">Silakan lakukan absensi Anda untuk hari ini, {{ auth()->user()->name }}</p>
            </div>
        </div>

        <div class="mt-4 md:mt-0 flex items-center space-x-2">
            <div x-data="clockComponent()" class="flex items-center">
                <span x-text="time" class="text-2xl md:text-3xl font-bold text-indigo-600 tabular-nums"></span>
                <span x-text="seconds" class="text-indigo-400 text-sm ml-1 tabular-nums"></span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Form Input -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-4">
                    <h3 class="text-white font-bold flex items-center text-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                        Detail Absensi
                    </h3>
                </div>

                @if (session('success') || session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition.opacity class="transition-all duration-500">
                    <div class="{{ session('success') ? 'bg-green-50 border-l-4 border-green-400' : 'bg-red-50 border-l-4 border-red-400' }} p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if (session('success'))
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                @else
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium {{ session('success') ? 'text-green-800' : 'text-red-800' }}">
                                    {{ session('success') ?? session('error') }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <button @click="show = false" class="{{ session('success') ? 'text-green-500 hover:text-green-600' : 'text-red-500 hover:text-red-600' }} focus:outline-none">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <form id="attendanceForm" action="{{ url('user/attendance') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Status Card -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if ($todayAttendance && $todayAttendance->check_out)
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                                            </svg>
                                        </div>
                                    @elseif ($todayAttendance)
                                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M15 1H9v2h6V1zm-4 13h2V8h-2v6zm8.03-6.61l1.42-1.42c-.43-.51-.9-.99-1.41-1.41l-1.42 1.42C16.07 4.74 14.12 4 12 4c-4.97 0-9 4.03-9 9s4.02 9 9 9 9-4.03 9-9c0-2.12-.74-4.07-1.97-5.61zM12 20c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-700">Status Absensi Hari Ini</h3>
                                    <p class="text-xs text-gray-500">{{ now()->format('l, d F Y') }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                @if ($todayAttendance && $todayAttendance->check_out)
                                    bg-green-100 text-green-800
                                @elseif ($todayAttendance)
                                    bg-yellow-100 text-yellow-800
                                @else
                                    bg-blue-100 text-blue-800
                                @endif">
                                @if ($todayAttendance && $todayAttendance->check_out)
                                    Selesai
                                @elseif ($todayAttendance)
                                    Absen Masuk
                                @else
                                    Belum Absen
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Attendance Info -->
                    <div class="space-y-5">
                        <div>
                            <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                                    </svg>
                                    Lokasi
                                </div>
                            </label>
                            <div class="relative">
                                <select name="location_id" id="location_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 pl-3 pr-10 appearance-none" onchange="updateSelectedLocation()">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}"
                                                data-lat="{{ $location->latitude }}"
                                                data-lon="{{ $location->longitude }}"
                                                data-radius="{{ $location->radius }}">
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                                    </svg>
                                    Ruangan
                                </div>
                            </label>
                            <div class="relative">
                                <select name="room_id" id="room_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 pl-3 pr-10 appearance-none">
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="type" id="attendance_type">

                    <div class="mt-8">
                        <div x-data="{ loading: false }" class="flex flex-col gap-3">
                            @if ($todayAttendance && !$todayAttendance->check_out)
                                <button type="button" @click="loading = true; submitAttendance('check_out')"
                                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium shadow-sm transition-all duration-300"
                                    :disabled="loading">
                                    <span x-show="!loading">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                        </svg>
                                        Absen Pulang
                                    </span>
                                    <span x-show="loading" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Memproses...
                                    </span>
                                </button>
                            @elseif (!$todayAttendance)
                                <button type="button" @click="loading = true; submitAttendance('check_in')"
                                    class="w-full flex items-center justify-center py-3 px-4 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium shadow-sm transition-all duration-300"
                                    :disabled="loading">
                                    <span x-show="!loading">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M13 3h-2v10h2V3zm4.83 2.17l-1.42 1.42C17.99 7.86 19 9.81 19 12c0 3.87-3.13 7-7 7s-7-3.13-7-7c0-2.19 1.01-4.14 2.58-5.42L6.17 5.17C4.23 6.82 3 9.26 3 12c0 4.97 4.03 9 9 9s9-4.03 9-9c0-2.74-1.23-5.18-3.17-6.83z"/>
                                        </svg>
                                        Absen Masuk
                                    </span>
                                    <span x-show="loading" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Memproses...
                                    </span>
                                </button>
                            @else
                                <div class="flex items-center justify-center bg-green-50 text-green-700 font-medium py-3 px-4 rounded-lg">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/>
                                    </svg>
                                    Anda sudah selesai absen hari ini
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden mt-6">
                <div class="bg-blue-500 p-4">
                    <h3 class="text-white font-bold flex items-center text-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        Informasi
                    </h3>
                </div>
                <div class="p-4">
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.58 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                            <p class="text-sm text-gray-600">Absensi dibuka mulai pukul <span class="font-semibold">05:00</span> setiap hari.</p>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.58 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                            <p class="text-sm text-gray-600">Pastikan Anda berada dalam radius lokasi yang ditentukan untuk dapat melakukan absensi.</p>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.58 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                            <p class="text-sm text-gray-600">Jangan lupa melakukan Check-Out setelah selesai kegiatan.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column - Map -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden h-full">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4">
                    <h3 class="text-white font-bold flex items-center text-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                        </svg>
                        Peta Lokasi
                    </h3>
                </div>
                <div x-data="{ mapLoading: true }" class="relative">
                    <!-- Loading Overlay -->
                    <div x-show="mapLoading" class="absolute inset-0 bg-gray-100 bg-opacity-50 flex items-center justify-center z-10">
                        <div class="text-center">
                            <svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-700">Memuat peta...</p>
                        </div>
                    </div>

                    <div id="map" class="w-full h-[calc(100vh-280px)]"></div>

                    <!-- Map Legend -->
                    <div class="bg-white rounded-lg shadow-md absolute bottom-4 left-4 p-3 z-10">
                        <h4 class="text-xs font-semibold text-gray-700 mb-2">Legenda:</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-red-500 border-2 border-white shadow-sm mr-2"></div>
                                <span class="text-xs text-gray-600">Lokasi Anda</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-green-500 border-2 border-white shadow-sm mr-2"></div>
                                <span class="text-xs text-gray-600">Lokasi Absensi</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-yellow-400 border-2 border-white shadow-sm mr-2"></div>
                                <span class="text-xs text-gray-600">Lokasi Terpilih</span>
                            </div>
                        </div>
                    </div>

                    <!-- Distance Indicator -->
                    <div id="distanceIndicator" class="hidden bg-white rounded-lg shadow-md absolute top-4 right-4 p-3 z-10">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-indigo-600 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                            </svg>
                            <span id="distanceText" class="text-xs font-medium text-gray-700">Menghitung jarak...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    function clockComponent() {
        return {
            time: '',
            seconds: '',
            init() {
                this.updateTime();
                setInterval(() => this.updateTime(), 1000);
            },
            updateTime() {
                const now = new Date();
                this.time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                this.seconds = ':' + now.getSeconds().toString().padStart(2, '0');
            }
        };
    }

    let map, userMarker, locationMarkers = [], locationCircles = [];
    let userLocation = { lat: null, lon: null };
    let isSubmitting = false; // Flag untuk mencegah permintaan ganda

    function initializeMap(lat, lon) {
        userLocation.lat = lat;
        userLocation.lon = lon;

        map = L.map('map', {
            scrollWheelZoom: true,
            zoomControl: false
        }).setView([lat, lon], 15);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors © <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        const userIcon = L.divIcon({
            className: 'user-marker',
            html: `
                <div class="relative">
                    <div class="absolute w-24 h-24 bg-blue-500 rounded-full opacity-20 animate-ping" style="top: -12px; left: -12px;"></div>
                    <div class="absolute w-14 h-14 bg-blue-500 rounded-full opacity-30" style="top: -7px; left: -7px;"></div>
                    <div class="bg-red-500 w-6 h-6 rounded-full border-2 border-white shadow-lg relative z-10"></div>
                </div>
            `,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });

        userMarker = L.marker([lat, lon], {
            icon: userIcon,
            zIndexOffset: 1000
        }).addTo(map);

        userMarker.bindPopup('<div class="text-center"><b>Lokasi Anda</b><br><span class="text-xs text-gray-500">Koordinat diperbarui otomatis</span></div>');

        const locationSelect = document.getElementById('location_id');
        for (let i = 0; i < locationSelect.options.length; i++) {
            const option = locationSelect.options[i];
            const locLat = parseFloat(option.getAttribute('data-lat'));
            const locLon = parseFloat(option.getAttribute('data-lon'));
            const radius = parseInt(option.getAttribute('data-radius'));
            const locName = option.text;

            const markerIcon = L.divIcon({
                className: 'location-marker',
                html: '<div class="bg-green-500 w-5 h-5 rounded-full border-2 border-white shadow-md flex items-center justify-center"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });

            const marker = L.marker([locLat, locLon], {
                icon: markerIcon
            }).addTo(map);

            const popupContent = `
                <div class="text-center p-1">
                    <h3 class="font-bold text-gray-800">${locName}</h3>
                    <p class="text-xs text-gray-500">Radius: ${radius} meter</p>
                </div>
            `;

            marker.bindPopup(popupContent);
            locationMarkers.push(marker);

            const circle = L.circle([locLat, locLon], {
                color: '#10B981',
                fillColor: '#10B981',
                fillOpacity: 0.1,
                radius: radius,
                weight: 2
            }).addTo(map);

            locationCircles.push(circle);
        }

        updateDistanceIndicator();
        setTimeout(() => {
            map.invalidateSize();
            document.querySelector('[x-data="{ mapLoading: true }"]').setAttribute('x-data', '{ mapLoading: false }');
        }, 300);
    }

    function updateSelectedLocation() {
        const select = document.getElementById('location_id');
        const selectedOption = select.options[select.selectedIndex];
        const locationLat = parseFloat(selectedOption.getAttribute('data-lat'));
        const locationLon = parseFloat(selectedOption.getAttribute('data-lon'));

        map.flyTo([locationLat, locationLon], 16, {
            duration: 1.5,
            easeLinearity: 0.25
        });

        locationMarkers.forEach((marker, index) => {
            if (marker.getLatLng().lat === locationLat && marker.getLatLng().lng === locationLon) {
                marker.setIcon(L.divIcon({
                    className: 'location-marker-selected',
                    html: '<div class="bg-yellow-400 w-6 h-6 rounded-full border-2 border-white shadow-md flex items-center justify-center transition-all duration-300"></div>',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                }));
                marker.openPopup();

                locationCircles[index].setStyle({
                    color: '#FBBF24',
                    fillColor: '#FBBF24',
                    fillOpacity: 0.2,
                    weight: 3
                });
            } else {
                marker.setIcon(L.divIcon({
                    className: 'location-marker',
                    html: '<div class="bg-green-500 w-5 h-5 rounded-full border-2 border-white shadow-md flex items-center justify-center"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                }));
                marker.closePopup();

                locationCircles[index].setStyle({
                    color: '#10B981',
                    fillColor: '#10B981',
                    fillOpacity: 0.1,
                    weight: 2
                });
            }
        });

        updateDistanceIndicator();
    }

    function updateDistanceIndicator() {
        const select = document.getElementById('location_id');
        if (!select || !userLocation.lat) return;

        const selectedOption = select.options[select.selectedIndex];
        const locationLat = parseFloat(selectedOption.getAttribute('data-lat'));
        const locationLon = parseFloat(selectedOption.getAttribute('data-lon'));
        const radius = parseInt(selectedOption.getAttribute('data-radius'));

        const distance = haversineDistance(
            userLocation.lat,
            userLocation.lon,
            locationLat,
            locationLon
        );

        const distIndicator = document.getElementById('distanceIndicator');
        const distText = document.getElementById('distanceText');

        distIndicator.classList.remove('hidden');

        if (distance <= radius) {
            distText.innerHTML = `<span class="text-green-600 font-medium">Dalam radius:</span> ${Math.round(distance)}m dari ${radius}m`;
            distIndicator.classList.add('bg-green-50');
            distIndicator.classList.remove('bg-red-50', 'bg-white');
        } else {
            distText.innerHTML = `<span class="text-red-600 font-medium">Di luar radius:</span> ${Math.round(distance)}m dari ${radius}m`;
            distIndicator.classList.add('bg-red-50');
            distIndicator.classList.remove('bg-green-50', 'bg-white');
        }
    }

    function haversineDistance(lat1, lon1, lat2, lon2) {
        const earthRadius = 6371000; // meters
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                 Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                 Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return earthRadius * c;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }

    function setupLocationTracking() {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;

            initializeMap(lat, lon);
            updateSelectedLocation();

            navigator.geolocation.watchPosition(function(pos) {
                const newLat = pos.coords.latitude;
                const newLon = pos.coords.longitude;

                document.getElementById('latitude').value = newLat;
                document.getElementById('longitude').value = newLon;

                userLocation.lat = newLat;
                userLocation.lon = newLon;

                if (userMarker) {
                    userMarker.setLatLng([newLat, newLon]);
                }

                updateDistanceIndicator();
            }, function(error) {
                console.error("Error in watch position:", error);
            }, {
                enableHighAccuracy: true,
                maximumAge: 10000,
                timeout: 10000
            });

        }, function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mendapatkan Lokasi',
                text: 'Pastikan GPS diaktifkan dan izinkan akses lokasi.',
            });
            initializeMap(-6.2088, 106.8456);
            updateSelectedLocation();
        }, {
            enableHighAccuracy: true,
            maximumAge: 10000,
            timeout: 10000
        });
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function submitAttendance(type) {
        // Cegah pemrosesan jika sedang dalam proses
        if (isSubmitting) {
            console.log('Submission already in progress, ignoring.');
            return;
        }

        isSubmitting = true;

        const form = document.getElementById('attendanceForm');
        const button = form.querySelector('button');
        const loadingSpan = button.querySelector('span[x-show="loading"]');
        const normalSpan = button.querySelector('span[x-show="!loading"]');

        // Nonaktifkan tombol dan atur state loading
        button.disabled = true;
        normalSpan.style.display = 'none';
        loadingSpan.style.display = 'flex';

        document.getElementById('attendance_type').value = type;
        const formData = new FormData(form);

        console.log('Submitting attendance:', Object.fromEntries(formData));

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json().catch(() => {
                return response.text().then(text => {
                    throw new Error(`HTTP error ${response.status}: ${text}`);
                });
            });
        })
        .then(data => {
            console.log('Response data:', data);
            button.disabled = false;
            normalSpan.style.display = 'block';
            loadingSpan.style.display = 'none';
            isSubmitting = false;

            Swal.fire({
                icon: data.success ? 'success' : 'error',
                title: data.success ? 'Sukses' : 'Gagal',
                text: data.message || data.error || 'Terjadi kesalahan.',
                confirmButtonColor: '#4F46E5',
                timer: 3000,
                timerProgressBar: true,
            });

            if (data.success) {
                setTimeout(() => window.location.reload(), 1000);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            button.disabled = false;
            normalSpan.style.display = 'block';
            loadingSpan.style.display = 'none';
            isSubmitting = false;

            Swal.fire({
                icon: 'error',
                title: 'Gagal Mengirim Absensi',
                text: error.message.includes('HTTP error') ? 'Terjadi masalah dengan server. Silakan coba lagi.' : error.message,
                confirmButtonColor: '#4F46E5',
                timer: 3000,
                timerProgressBar: true,
            });
        });

        // Timeout untuk mencegah loading macet
        setTimeout(() => {
            if (isSubmitting) {
                button.disabled = false;
                normalSpan.style.display = 'block';
                loadingSpan.style.display = 'none';
                isSubmitting = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengirim Absensi',
                    text: 'Permintaan absensi gagal. Silakan coba lagi.',
                    confirmButtonColor: '#4F46E5',
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        }, 10000);
    }

    // Terapkan debounce pada event click
    document.addEventListener('DOMContentLoaded', function() {
        setupLocationTracking();

        const checkInButton = document.querySelector('button[onclick*="check_in"]');
        const checkOutButton = document.querySelector('button[onclick*="check_out"]');

        if (checkInButton) {
            const debouncedCheckIn = debounce(() => submitAttendance('check_in'), 500);
            checkInButton.addEventListener('click', debouncedCheckIn);
            // Ganti onclick inline untuk mencegah binding ganda
            checkInButton.removeAttribute('onclick');
        }

        if (checkOutButton) {
            const debouncedCheckOut = debounce(() => submitAttendance('check_out'), 500);
            checkOutButton.addEventListener('click', debouncedCheckOut);
            checkOutButton.removeAttribute('onclick');
        }
    });
</script>

<style>
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .leaflet-popup-content {
        margin: 10px 12px;
    }

    .leaflet-popup-tip {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .leaflet-control-zoom {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .leaflet-control-zoom-in, .leaflet-control-zoom-out {
        background-color: white !important;
        color: #4F46E5 !important;
    }

    .leaflet-control-zoom-in:hover, .leaflet-control-zoom-out:hover {
        background-color: #F3F4F6 !important;
        color: #4338CA !important;
    }

    @keyframes ping {
        0% {
            transform: scale(0.95);
            opacity: 1;
        }
        70% {
            transform: scale(1.3);
            opacity: 0;
        }
        100% {
            transform: scale(0.95);
            opacity: 0;
        }
    }

    .animate-ping {
        animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
</style>
@endsection
