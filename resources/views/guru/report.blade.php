@extends('layouts.app')

@section('title', 'Laporan Absensi')

@section('content')
<div class="w-full min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-6 md:py-10 lg:py-12 overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 md:mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 transition-all">Laporan Absensi</h2>
                <p class="text-sm md:text-base text-gray-600 mt-1">Lihat data absensi siswa yang Anda kelola</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('guru.manual_attendance') }}" class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-user-edit mr-2"></i> Absensi Manual
                </a>
                <a href="{{ url('guru/dashboard') }}" class="bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-600 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Statistik Ringkas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-4 md:p-6 border-l-4 border-blue-500">
                <h6 class="text-sm md:text-base text-gray-500 mb-1">Total Absensi</h6>
                <h3 class="text-xl md:text-2xl font-bold text-blue-600">{{ $attendances->total() }}</h3>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-4 md:p-6 border-l-4 border-green-500">
                <h6 class="text-sm md:text-base text-gray-500 mb-1">Hadir Hari Ini</h6>
                <h3 class="text-xl md:text-2xl font-bold text-green-600">{{ $todayStats['present'] ?? 0 }}</h3>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-4 md:p-6 border-l-4 border-indigo-500">
                <h6 class="text-sm md:text-base text-gray-500 mb-1">Tanggal</h6>
                <h3 class="text-lg font-bold text-indigo-600">{{ now()->locale('id')->isoFormat('D MMMM YYYY') }}</h3>
            </div>
        </div>

        <!-- Filter dan Tabel -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all">
            <div class="bg-gray-50 p-4 md:p-5 rounded-t-xl border-b">
                <h5 class="text-base md:text-lg font-bold text-gray-800">Daftar Absensi</h5>
            </div>
            <div class="p-4 md:p-6">
                <!-- Filter -->
                <form method="GET" action="{{ url('guru/report') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 mb-6">
                    <div class="flex items-center bg-gray-50 rounded-lg shadow-sm border border-gray-200 hover:border-blue-300 transition-all">
                        <span class="px-3 py-2 text-gray-600"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" name="start_date" class="border-0 bg-transparent focus:ring-2 focus:ring-blue-400 focus:border-blue-500 rounded-r-lg w-full" value="{{ request('start_date') }}" placeholder="Tanggal Mulai">
                    </div>
                    <div class="flex items-center bg-gray-50 rounded-lg shadow-sm border border-gray-200 hover:border-blue-300 transition-all">
                        <span class="px-3 py-2 text-gray-600"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" name="end_date" class="border-0 bg-transparent focus:ring-2 focus:ring-blue-400 focus:border-blue-500 rounded-r-lg w-full" value="{{ request('end_date') }}" placeholder="Tanggal Selesai">
                    </div>
                    <div class="flex items-center bg-gray-50 rounded-lg shadow-sm border border-gray-200 hover:border-blue-300 transition-all">
                        <span class="px-3 py-2 text-gray-600"><i class="fas fa-door-open"></i></span>
                        <select name="room_id" class="border-0 bg-transparent rounded-r-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 w-full">
                            <option value="">Semua Ruangan</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <a href="{{ url('guru/report/export') }}?{{ http_build_query(request()->query()) }}" class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-file-export mr-2"></i> Ekspor Excel
                    </a>
                </form>

                <!-- Tabel -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Nama Siswa</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Lokasi</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Ruangan</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Check-In</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Check-Out</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $attendance)
                                <tr class="hover:bg-gray-50 transition-colors border-t border-gray-200">
                                    <td class="p-3 md:p-4 text-sm md:text-base font-medium">{{ $attendance->user->name }}</td>
                                    <td class="p-3 md:p-4 text-sm md:text-base">{{ $attendance->location->name }}</td>
                                    <td class="p-3 md:p-4 text-sm md:text-base">{{ $attendance->room->name }}</td>
                                    <td class="p-3 md:p-4 text-sm md:text-base">
                                        <span class="text-blue-600">
                                            {{ $attendance->check_in->format('H:i:s') }}
                                        </span>
                                        <div class="text-xs text-gray-500">
                                            {{ $attendance->check_in->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="p-3 md:p-4 text-sm md:text-base">
                                        @if($attendance->check_out)
                                            <span class="text-blue-600">
                                                {{ $attendance->check_out->format('H:i:s') }}
                                            </span>
                                            <div class="text-xs text-gray-500">
                                                {{ $attendance->check_out->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-3 md:p-4">
                                        @if(str_contains($attendance->status, 'manual'))
                                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-lg text-sm font-medium">
                                                <i class="fas fa-user-edit mr-1"></i>
                                                {{ str_contains($attendance->status, 'absent') ? 'Manual (Absen)' : 'Manual (Hadir)' }}
                                            </span>
                                        @elseif ($attendance->check_in && !$attendance->check_out)
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-lg text-sm font-medium">Partial</span>
                                        @elseif ($attendance->check_in && $attendance->check_out)
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-lg text-sm font-medium">Hadir</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-lg text-sm font-medium">Absen</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada data absensi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $attendances->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection