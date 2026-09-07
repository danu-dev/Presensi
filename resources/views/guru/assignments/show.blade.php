@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('guru.assignments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">← Kembali ke daftar tugas</a>
        <div class="mt-2 flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $assignment->title }}</h1>
                <p class="text-sm text-gray-600">Kelas: <span class="font-semibold">{{ $assignment->room->name }}</span> | Deadline: <span class="font-semibold">{{ $assignment->due_date->format('d M Y, H:i') }}</span></p>
            </div>
            @if ($assignment->file_path)
                <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 text-indigo-600 rounded text-sm hover:bg-indigo-50">
                    Unduh Soal/Materi
                </a>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded text-green-800 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Daftar Pengumpulan Siswa ({{ $assignment->submissions->count() }})</h2>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Kumpul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berkas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai & Catatan</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($assignment->submissions as $submission)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $submission->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $submission->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $submission->submitted_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">
                                Unduh Tugas
                            </a>
                            @if ($submission->notes)
                                <p class="text-xs text-gray-500 mt-1 italic">"{{ $submission->notes }}"</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="font-bold {{ $submission->score !== null ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $submission->score !== null ? $submission->score . ' / 100' : 'Belum Dinilai' }}
                            </span>
                            @if ($submission->feedback)
                                <p class="text-xs text-gray-500 mt-0.5">{{ $submission->feedback }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <form action="{{ route('guru.submissions.grade', $submission) }}" method="POST" class="flex items-center justify-end space-x-2">
                                @csrf
                                <input type="number" name="score" min="0" max="100" value="{{ $submission->score }}" placeholder="0-100" required class="w-20 text-sm rounded border-gray-300 py-1 px-2">
                                <input type="text" name="feedback" value="{{ $submission->feedback }}" placeholder="Catatan/evaluasi" class="w-40 text-sm rounded border-gray-300 py-1 px-2">
                                <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded text-xs font-semibold hover:bg-indigo-700">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada siswa yang mengumpulkan tugas ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
