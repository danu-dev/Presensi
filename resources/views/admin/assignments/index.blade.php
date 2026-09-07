@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Monitoring Tugas & Pembelajaran</h1>
        <p class="text-sm text-gray-600">Pantau seluruh penugasan guru dan statistik pengumpulan siswa di sekolah.</p>
    </div>

    <!-- Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-indigo-500">
            <div class="text-sm font-medium text-gray-500">Total Tugas Dibuat</div>
            <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['total_assignments'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
            <div class="text-sm font-medium text-gray-500">Total Tugas Terkumpul</div>
            <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['total_submissions'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
            <div class="text-sm font-medium text-gray-500">Sudah Dinilai Guru</div>
            <div class="mt-2 text-3xl font-extrabold text-gray-900">{{ $stats['graded_submissions'] }}</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form action="{{ route('admin.assignments.index') }}" method="GET" class="flex items-center space-x-4">
            <label for="room_id" class="text-sm font-medium text-gray-700">Filter Ruang Kelas:</label>
            <select name="room_id" id="room_id" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Semua Kelas</option>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                @endforeach
            </select>
            @if (request('room_id'))
                <a href="{{ route('admin.assignments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul & Guru Pengampu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batas Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statistik Siswa</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($assignments as $assignment)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $assignment->title }}</div>
                            <div class="text-xs text-gray-500">Oleh: {{ $assignment->creator->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $assignment->room->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $assignment->due_date->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $assignment->submissions->count() }} Terkumpul
                            ({{ $assignment->submissions->whereNotNull('score')->count() }} dinilai)
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada penugasan terdata.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
