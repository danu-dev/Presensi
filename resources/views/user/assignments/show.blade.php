@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('user.assignments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">← Kembali ke daftar tugas</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $assignment->title }}</h1>
        <p class="text-sm text-gray-600">Kelas: {{ $assignment->room->name }} | Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}</p>
    </div>

    @if (session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded text-green-800 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded text-red-800 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Instruksi Tugas</h2>
        <div class="text-sm text-gray-700 whitespace-pre-line mb-4">
            {{ $assignment->description ?? 'Tidak ada petunjuk tambahan.' }}
        </div>
        @if ($assignment->file_path)
            <div class="p-3 bg-gray-50 rounded border border-gray-200 inline-block">
                <span class="text-xs text-gray-500 block mb-1">Materi / Lampiran Soal:</span>
                <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" class="text-indigo-600 hover:underline text-sm font-semibold">
                    Unduh Dokumen Soal
                </a>
            </div>
        @endif
    </div>

    @if ($submission)
        <div class="bg-white rounded-lg shadow p-6 mb-6 border-l-4 border-green-500">
            <h2 class="text-lg font-bold text-gray-900 mb-2">Status Pengumpulan</h2>
            <p class="text-sm text-gray-600">Dikumpulkan pada: <span class="font-medium text-gray-800">{{ $submission->submitted_at->format('d M Y, H:i') }}</span></p>
            <div class="mt-2 text-sm">
                Berkas Anda: <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-indigo-600 underline">Lihat File</a>
            </div>
            @if ($submission->notes)
                <p class="text-xs text-gray-500 mt-1 italic">Catatan: "{{ $submission->notes }}"</p>
            @endif

            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-sm font-semibold">Hasil Penilaian: </span>
                @if ($submission->score !== null)
                    <span class="text-lg font-bold text-green-600">{{ $submission->score }} / 100</span>
                    @if ($submission->feedback)
                        <p class="text-xs text-gray-600 mt-1">Catatan Guru: {{ $submission->feedback }}</p>
                    @endif
                @else
                    <span class="text-sm text-yellow-600 font-semibold">Menunggu pemeriksaan guru</span>
                @endif
            </div>
        </div>
    @endif

    @if (now()->lte($assignment->due_date))
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">{{ $submission ? 'Kirim Ulang / Perbarui Tugas' : 'Form Pengumpulan Tugas' }}</h2>
            <form action="{{ route('user.assignments.submit', $assignment) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tulis catatan pengerjaan jika ada...">{{ old('notes', $submission->notes ?? '') }}</textarea>
                    @error('notes') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700">Unggah File Tugas (PDF, DOCX, ZIP, Gambar, max 10MB)</label>
                    <input type="file" name="file" id="file" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('file') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-semibold shadow">
                        {{ $submission ? 'Perbarui Berkas' : 'Kirim Tugas Sekarang' }}
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="p-4 bg-gray-100 rounded-lg text-center text-sm text-gray-600">
            Waktu pengumpulan tugas ini telah berakhir.
        </div>
    @endif
</div>
@endsection
