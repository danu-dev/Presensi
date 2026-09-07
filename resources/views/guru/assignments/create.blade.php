@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('guru.assignments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">← Kembali ke daftar tugas</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Buat Tugas Baru</h1>
    </div>

    <form action="{{ route('guru.assignments.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow sm:rounded-lg p-6 space-y-6">
        @csrf

        <div>
            <label for="room_id" class="block text-sm font-medium text-gray-700">Ruang Kelas</label>
            <select name="room_id" id="room_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Pilih Kelas</option>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                @endforeach
            </select>
            @error('room_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Judul Tugas</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Tugas Mandiri Pemrograman Web">
            @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi / Instruksi</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Instruksi pengerjaan tugas...">{{ old('description') }}</textarea>
            @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="due_date" class="block text-sm font-medium text-gray-700">Batas Waktu (Deadline)</label>
            <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('due_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="file" class="block text-sm font-medium text-gray-700">Lampiran Materi/Soal (Opsional, max 10MB)</label>
            <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('file') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('guru.assignments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700 shadow-sm">Simpan & Terbitkan</button>
        </div>
    </form>
</div>
@endsection
