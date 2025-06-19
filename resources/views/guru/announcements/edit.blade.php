@extends('layouts.app')

@section('title', 'Edit Pengumuman')
@section('header-title', 'Edit Pengumuman')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <div>
                        <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="flex-shrink-0 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="sr-only">Home</span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('guru.announcements.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Pengumuman</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-blue-600">Edit Pengumuman</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6">
                <div class="absolute inset-0 bg-noise opacity-10"></div>
                <div class="relative z-10 flex items-center">
                    <div class="p-3 rounded-lg bg-white/10 text-white mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">Edit Pengumuman</h2>
                </div>
            </div>

            <form action="{{ route('guru.announcements.update', $announcement->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <!-- Title Input -->
                <div class="mb-8">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" name="title" id="title" class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('title') border-red-500 @enderror" value="{{ old('title', $announcement->title) }}" placeholder="Contoh: Libur Semester Genap">
                        @error('title')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        @enderror
                    </div>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-2 text-sm text-gray-500">Judul yang jelas dan deskriptif</p>
                    @enderror
                </div>

                <!-- Description Input -->
                <div class="mb-8">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Isi Pengumuman <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="8" class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('description') border-red-500 @enderror" placeholder="Tulis detail pengumuman di sini...">{{ old('description', $announcement->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-2 text-sm text-gray-500">Gunakan format yang jelas dengan paragraf dan poin-poin jika diperlukan</p>
                    @enderror
                </div>

                <!-- Urgency and Expiry Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Urgency Select -->
                    <div>
                        <label for="urgency" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Urgensi <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative">
                            <select name="urgency" id="urgency" class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('urgency') border-red-500 @enderror">
                                <option value="low" {{ old('urgency', $announcement->urgency) == 'low' ? 'selected' : '' }}>Rendah (Informasi biasa)</option>
                                <option value="medium" {{ old('urgency', $announcement->urgency) == 'medium' ? 'selected' : '' }}>Sedang (Penting)</option>
                                <option value="high" {{ old('urgency', $announcement->urgency) == 'high' ? 'selected' : '' }}>Tinggi (Sangat penting)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('urgency')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-2 text-sm text-gray-500">Pilih tingkat kepentingan pengumuman</p>
                        @enderror
                    </div>

                    <!-- Expiry Date Input -->
                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kadaluarsa <span class="text-gray-500">(Opsional)</span></label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="date" name="expires_at" id="expires_at" class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('expires_at') border-red-500 @enderror" value="{{ old('expires_at', $announcement->expires_at ? $announcement->expires_at->format('Y-m-d') : '') }}">
                            @error('expires_at')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            @enderror
                        </div>
                        @error('expires_at')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-2 text-sm text-gray-500">Pengumuman akan disembunyikan setelah tanggal ini</p>
                        @enderror
                    </div>
                </div>

                <!-- Room Select -->
                <div class="mb-8">
                    <label for="room_id" class="block text-sm font-medium text-gray-700 mb-2">Ruangan <span class="text-gray-500">(Opsional)</span></label>
                    <div class="mt-1 relative">
                        <select name="room_id" id="room_id" class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('room_id') border-red-500 @enderror">
                            <option value="">Semua Ruangan</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $announcement->room_id) == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('room_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @else
                        <p class="mt-2 text-sm text-gray-500">Pilih ruangan untuk pengumuman spesifik, atau kosongkan untuk semua siswa</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('guru.announcements.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const expiresAtInput = document.getElementById('expires_at');
        expiresAtInput.addEventListener('change', function () {
            const today = new Date().toISOString().split('T')[0];
            if (this.value < today) {
                this.value = '';
                alert('Tanggal kadaluarsa tidak boleh sebelum hari ini.');
            }
        });
    });
</script>
@endsection
