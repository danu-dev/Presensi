@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center justify-center gap-2">
                <i class="bi bi-file-earmark-text-fill text-indigo-600"></i>
                Riwayat Absensi Anda
            </h1>
            <p class="text-gray-600 mt-2">Lihat riwayat absensi Anda, {{ auth()->user()->name }}</p>
        </div>

        <!-- Attendance List -->
        <div class="space-y-6">
            @forelse ($attendances as $attendance)
                <div x-data="{ open: false }" class="bg-white rounded-3xl shadow-xl overflow-hidden border-l-4 border-indigo-500 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <!-- Card Header -->
                    <div @click="open = !open" class="flex justify-between items-center p-6 cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">{{ $attendance->check_in->format('l, d F Y') }}</h3>
                            <p class="text-sm text-gray-500">{{ $attendance->location->name }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if ($attendance->check_out)
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">Selesai</span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full font-medium">Belum Check-Out</span>
                            @endif
                            <i class="bi bi-chevron-down text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                        </div>
                    </div>

                    <!-- Expanded Details -->
                    <div x-show="open" x-transition.duration.300ms class="bg-gray-50 px-6 pb-6 pt-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 font-medium">Lokasi:</p>
                                <p class="text-gray-800">{{ $attendance->location->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-medium">Ruangan:</p>
                                <p class="text-gray-800">{{ $attendance->room->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-medium">Check-In:</p>
                                <p class="text-gray-800">{{ $attendance->check_in->format('H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-medium">Check-Out:</p>
                                <p class="text-gray-800">
                                    @if ($attendance->check_out)
                                        {{ $attendance->check_out->format('H:i') }}
                                    @else
                                        <span class="text-red-500">Belum dilakukan</span>
                                    @endif
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-gray-600 font-medium">Foto Saat Absen:</p>
                                @if ($attendance->photo)
                                    <img src="{{ asset('storage/' . $attendance->photo) }}" alt="Foto Absensi" class="w-28 h-28 object-cover rounded-xl border border-gray-200 shadow-sm mt-2">
                                @else
                                    <p class="text-gray-400 text-sm mt-2">Tidak ada foto tersedia</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl shadow-md p-10 text-center">
                    <i class="bi bi-calendar-x text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-700">Belum ada riwayat absensi</h3>
                    <p class="text-gray-500 mt-1">Silakan lakukan check-in terlebih dahulu.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {{ $attendances->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Custom Styling for Pagination -->
<style>
    .pagination .page-link {
        @apply text-indigo-500 rounded-lg mx-1 transition-colors duration-300;
    }
    .pagination .page-item.active .page-link {
        @apply bg-indigo-500 border-indigo-500 text-white;
    }
    .pagination .page-link:hover {
        @apply bg-indigo-600 text-white;
    }
</style>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs @3.x.x/dist/cdn.min.js" defer></script>
@endsection
