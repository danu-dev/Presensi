@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800"><i class="bi bi-file-earmark-text mr-2"></i> Riwayat Absensi</h2>
        <p class="text-gray-500 text-sm md:text-base">Lihat riwayat absensi Anda, {{ auth()->user()->name }}</p>
    </div>

    <!-- Riwayat Absensi -->
    <div class="flex flex-col gap-4">
        @forelse ($attendances as $attendance)
            <div x-data="{ open: false }" class="bg-white rounded-xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div @click="open = !open" class="p-4 md:p-5 flex justify-between items-center cursor-pointer hover:bg-gray-50 transition-colors duration-200" :class="{ 'rounded-b-none': open }">
                    <div>
                        <h5 class="text-base md:text-lg font-semibold text-gray-800 mb-0">{{ $attendance->check_in->toDateString() }}</h5>
                        <p class="text-gray-500 text-sm mb-0">{{ $attendance->location->name }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if ($attendance->check_out)
                            <span class="bg-green-500 text-white text-xs md:text-sm font-medium px-3 py-1 rounded-lg">Selesai</span>
                        @else
                            <span class="bg-yellow-400 text-gray-800 text-xs md:text-sm font-medium px-3 py-1 rounded-lg">Belum Check-Out</span>
                        @endif
                        <i class="bi bi-chevron-down text-gray-600 transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                    </div>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="p-4 md:p-5 bg-gray-50 rounded-b-xl">
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="text-gray-600 font-semibold min-w-[100px] text-sm md:text-base">Lokasi:</span>
                            <span class="text-gray-800 text-sm md:text-base">{{ $attendance->location->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 font-semibold min-w-[100px] text-sm md:text-base">Ruangan:</span>
                            <span class="text-gray-800 text-sm md:text-base">{{ $attendance->room->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 font-semibold min-w-[100px] text-sm md:text-base">Check-In:</span>
                            <span class="text-gray-800 text-sm md:text-base">{{ $attendance->check_in->toTimeString() }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-600 font-semibold min-w-[100px] text-sm md:text-base">Check-Out:</span>
                            <span class="text-gray-800 text-sm md:text-base">
                                @if ($attendance->check_out)
                                    {{ $attendance->check_out->toTimeString() }}
                                @else
                                    Belum Check-Out
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-md p-10 flex flex-col items-center justify-center">
                <i class="bi bi-calendar-x text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-600 text-base md:text-lg">Belum ada riwayat absensi.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-6">
        {{ $attendances->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Custom Pagination Styling -->
<style>
    .pagination .page-link {
        @apply text-blue-500 rounded-lg mx-1 transition-colors duration-300;
    }
    .pagination .page-item.active .page-link {
        @apply bg-blue-500 border-blue-500 text-white;
    }
    .pagination .page-link:hover {
        @apply bg-blue-600 text-white;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
