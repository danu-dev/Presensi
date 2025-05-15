@extends('layouts.app')

@section('title', 'Ajukan Izin - SIHADIR')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 md:py-10 lg:py-12">
    <!-- Form Header -->
    <div class="bg-indigo-600 text-white text-center px-4 py-6 md:px-6 md:py-8 lg:px-8 lg:py-10 relative">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_10%_20%,rgba(255,255,255,0.15)_0%,transparent_20%),radial-gradient(circle_at_90%_50%,rgba(255,255,255,0.1)_0%,transparent_15%),radial-gradient(circle_at_40%_80%,rgba(255,255,255,0.2)_0%,transparent_15%)] opacity-60"></div>
        <div class="relative z-10 max-w-3xl mx-auto">
            <div class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 text-indigo-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                </svg>
            </div>
            <h2 class="text-xl md:text-2xl lg:text-3xl font-semibold font-['Inter']">Ajukan Izin</h2>
            <p class="text-sm md:text-base lg:text-lg opacity-90 mt-2">Isi form berikut dengan lengkap dan jelas</p>
        </div>
    </div>

    <!-- Form Body -->
    <div class="max-w-3xl mx-auto px-4 py-6 md:px-6 md:py-8 lg:px-8 lg:py-10 space-y-6">
        <!-- Status Pengajuan Terakhir -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h5 class="text-lg font-semibold text-gray-800 mb-4">Status Pengajuan Terakhir</h5>
            @if ($lastPermission)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Nama Izin</p>
                            <p class="text-gray-800 font-medium">{{ $lastPermission->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14H7v-2h5v2zm5-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="text-gray-800 font-medium">
                                <span class="{{ $lastPermission->status == 'approved' ? 'text-green-600' : ($lastPermission->status == 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                    {{ $lastPermission->status ? ucfirst($lastPermission->status) : 'Menunggu Validasi' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-sm">Belum ada pengajuan izin sebelumnya.</p>
            @endif
        </div>

        <!-- Session Messages -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity class="rounded-md bg-green-50 p-4 flex justify-between items-center">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-green-700 hover:text-green-900 focus:outline-none">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity class="rounded-md bg-red-50 p-4 flex justify-between items-center">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
                <button @click="show = false" class="text-red-700 hover:text-red-900 focus:outline-none">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Permission Form -->
        <form method="POST" action="{{ route('user.submit.permission') }}" enctype="multipart/form-data" x-data="{ fileName: 'Pilih atau seret file ke sini', preview: null, progress: 0, uploading: false }" @submit="if (!fileName || fileName === 'Pilih atau seret file ke sini') { $event.preventDefault(); alert('Mohon lengkapi semua kolom form!'); } else { uploading = true; let interval = setInterval(() => { if (progress < 100) { progress += 10; } else { clearInterval(interval); $event.target.submit(); } }, 200); }" class="space-y-6">
            @csrf

            <!-- Nama Izin -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-700 relative group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                        </svg>
                        Nama Izin
                        <svg class="w-4 h-4 ml-2 text-gray-500 group-hover:text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <span class="absolute left-0 top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">Contoh: Sakit, Keperluan Keluarga</span>
                </label>
                <div class="relative">
                    <input type="text" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 pl-10 pr-3 transition-all duration-300 hover:border-indigo-300 @error('name') border-red-300 @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama izin" required>
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                    </svg>
                </div>
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-gray-700 relative group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3h18v18H3V3zm16 16V5H5v14h14zm-6-8h4v2h-4v-2zm-6 0h4v2H7v-2z"/>
                        </svg>
                        Deskripsi
                        <svg class="w-4 h-4 ml-2 text-gray-500 group-hover:text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <span class="absolute left-0 top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">Jelaskan alasan izin secara detail</span>
                </label>
                <div class="relative">
                    <textarea class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 pl-10 pr-3 min-h-[100px] transition-all duration-300 hover:border-indigo-300 @error('description') border-red-300 @enderror" id="description" name="description" placeholder="Jelaskan alasan izin" required>{{ old('description') }}</textarea>
                    <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3h18v18H3V3zm16 16V5H5v14h14zm-6-8h4v2h-4v-2zm-6 0h4v2H7v-2z"/>
                    </svg>
                </div>
                @error('description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Izin -->
            <div class="space-y-2">
                <label for="date" class="block text-sm font-medium text-gray-700 relative group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h2v2H7v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z"/>
                        </svg>
                        Tanggal Izin
                        <svg class="w-4 h-4 ml-2 text-gray-500 group-hover:text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <span class="absolute left-0 top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">Pilih tanggal izin Anda</span>
                </label>
                <div class="relative">
                    <input type="date" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 pl-10 pr-3 transition-all duration-300 hover:border-indigo-300 @error('date') border-red-300 @enderror" id="date" name="date" value="{{ old('date') ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h2v2H7v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z"/>
                    </svg>
                </div>
                @error('date')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bukti (Foto) -->
            <div class="space-y-2">
                <label for="proof_image" class="block text-sm font-medium text-gray-700 relative group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                        </svg>
                        Bukti (Foto)
                        <svg class="w-4 h-4 ml-2 text-gray-500 group-hover:text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <span class="absolute left-0 top-8 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">Unggah foto sebagai bukti (misalnya surat dokter)</span>
                </label>
                <div class="relative">
                    <div class="flex items-center bg-gray-100 rounded-lg shadow-sm overflow-hidden">
                        <label for="proof_image" class="flex-grow px-4 py-3 text-gray-500 text-sm truncate cursor-pointer" x-text="fileName"></label>
                        <div class="bg-indigo-600 text-white px-4 py-3 font-semibold hover:bg-indigo-700 transition-colors duration-300 cursor-pointer text-sm">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4v7h-2l3-3 3 3h-2v7H8v-7H6l3-3 3 3h-2V4h4zM4 16v2h16v-2H4z"/>
                            </svg>
                            Browse
                        </div>
                        <input type="file" class="absolute opacity-0 w-full h-full cursor-pointer" id="proof_image" name="proof_image" accept="image/*" required @change="fileName = $event.target.files[0] ? $event.target.files[0].name : 'Pilih atau seret file ke sini'; preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                    </div>
                    <div x-show="uploading" class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300" :style="{ width: progress + '%' }"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Mengunggah: <span x-text="progress + '%'"></span></p>
                    </div>
                    <div class="h-44 bg-gray-100 rounded-lg shadow-sm flex items-center justify-center mt-2 overflow-hidden" x-show="preview && !uploading" x-transition.opacity>
                        <img :src="preview" alt="Preview" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="h-44 bg-gray-100 rounded-lg shadow-sm flex flex-col items-center justify-center mt-2 text-gray-500" x-show="!preview && !uploading">
                        <svg class="w-10 h-10 mb-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                        </svg>
                        <p class="text-sm">Preview gambar akan muncul di sini</p>
                    </div>
                </div>
                @error('proof_image')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 3h20v12H8l-6 6V3zm2 2v10.586L5.414 14H20V5H4zm4 2h8v2H8V7zm0 4h5v2H8v-2z"/>
                </svg>
                Kirim Pengajuan
            </button>

            <!-- Back Link -->
            <a href="{{ route('user.dashboard') }}" class="flex items-center justify-center mt-6 text-indigo-600 hover:text-indigo-800 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection