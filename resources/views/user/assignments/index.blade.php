@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Tugas Saya</h1>
        <p class="text-sm text-gray-600">Lihat tugas yang diberikan guru dan kumpulkan tepat waktu.</p>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded text-green-800 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($assignments as $assignment)
            @php
                $submission = $assignment->submissions->first();
                $isPassed = now()->gt($assignment->due_date);
            @endphp
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-50 text-indigo-700">
                            {{ $assignment->room->name }}
                        </span>
                        @if ($submission)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-800">
                                Sudah Dikumpul
                            </span>
                        @elseif ($isPassed)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-800">
                                Terlewat
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-yellow-100 text-yellow-800">
                                Belum Dikumpul
                            </span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $assignment->title }}</h3>
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4">{{ $assignment->description ?? 'Tidak ada instruksi khusus.' }}</p>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <div class="text-xs text-gray-500 mb-3">
                        Batas: <span class="font-medium text-gray-700">{{ $assignment->due_date->format('d M Y, H:i') }}</span>
                    </div>
                    <a href="{{ route('user.assignments.show', $assignment) }}" class="w-full text-center block py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm font-semibold transition">
                        {{ $submission ? 'Lihat Status / Edit' : 'Kerjakan & Kumpul' }}
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-lg border border-dashed border-gray-300">
                Belum ada tugas untuk kelas Anda.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
