@extends('layouts.app')

@section('title', 'Ajukan Izin - SIHADIR')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8 md:py-12">
    <!-- Glassmorphic Header -->
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_10%_20%,rgba(255,255,255,0.2)_0%,transparent_20%),radial-gradient(circle_at_90%_50%,rgba(255,255,255,0.15)_0%,transparent_15%),radial-gradient(circle_at_40%_80%,rgba(255,255,255,0.25)_0%,transparent_15%)] opacity-70"></div>
            <div class="relative z-10 py-8 md:py-10 px-6 md:px-10 text-center">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-white/90 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg backdrop-blur-sm">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-indigo-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-white font-['Inter'] tracking-tight">Ajukan Izin</h1>
                <p class="text-indigo-100 mt-3 text-sm md:text-base max-w-lg mx-auto">Isi formulir berikut dengan lengkap untuk mengajukan izin ketidakhadiran</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <!-- Last Submission Status Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h2v2H7v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z"/>
                    </svg>
                    Status Pengajuan Terakhir
                </h3>
            </div>
            <div class="p-6">
                @if ($lastPermission)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Nama Izin</h4>
                                <p class="text-gray-800 font-semibold mt-1">{{ $lastPermission->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $lastPermission->date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                <div class="mt-1 flex items-center">
                                    @if($lastPermission->status == 'approved')
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Disetujui
                                        </span>
                                    @elseif($lastPermission->status == 'rejected')
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Menunggu
                                        </span>
                                    @endif
                                </div>
                                @if($lastPermission->status)
                                    <p class="text-xs text-gray-500 mt-1">Diperbarui: {{ $lastPermission->updated_at->format('d M Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500">Belum ada pengajuan izin sebelumnya</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Session Messages -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity class="rounded-xl bg-green-50 border border-green-200 p-4 mb-8 flex items-start shadow-sm">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800 focus:outline-none">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity class="rounded-xl bg-red-50 border border-red-200 p-4 mb-8 flex items-start shadow-sm">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-red-600 hover:text-red-800 focus:outline-none">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Permission Form -->
        <form method="POST" action="{{ route('user.submit.permission') }}" enctype="multipart/form-data"
              x-data="{ fileName: 'Pilih atau seret file ke sini', preview: null, progress: 0, uploading: false }"
              @submit="if (!fileName || fileName === 'Pilih atau seret file ke sini') { $event.preventDefault(); alert('Mohon lengkapi semua kolom form!'); } else { uploading = true; let interval = setInterval(() => { if (progress < 100) { progress += 10; } else { clearInterval(interval); $event.target.submit(); } }, 200); }"
              class="space-y-6 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 p-6 md:p-8">
            @csrf

            <!-- Nama Izin -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-700 relative group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                        </svg>
                        Nama Izin
                        <span class="ml-2 text-xs text-gray-500 group-hover:text-indigo-600 transition-colors">(wajib)</span>
                    </span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                        </svg>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-300 hover:border-indigo-300 @error('name') border-red-300 @enderror"
                           placeholder="Contoh: Sakit, Keperluan Keluarga" required>
                </div>
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-gray-700 relative group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 3h18v18H3V3zm16 16V5H5v14h14zm-6-8h4v2h-4v-2zm-6 0h4v2H7v-2z"/>
                        </svg>
                        Deskripsi Alasan
                        <span class="ml-2 text-xs text-gray-500 group-hover:text-indigo-600 transition-colors">(wajib)</span>
                    </span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute top-3 left-3">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 3h18v18H3V3zm16 16V5H5v14h14zm-6-8h4v2h-4v-2zm-6 0h4v2H7v-2z"/>
                        </svg>
                    </div>
                    <textarea id="description" name="description" rows="4"
                              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-300 hover:border-indigo-300 @error('description') border-red-300 @enderror"
                              placeholder="Jelaskan alasan izin secara detail" required>{{ old('description') }}</textarea>
                </div>
                @error('description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Izin -->
            <div class="space-y-2">
                <label for="date" class="block text-sm font-medium text-gray-700 relative group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h2v2H7v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z"/>
                        </svg>
                        Tanggal Izin
                        <span class="ml-2 text-xs text-gray-500 group-hover:text-indigo-600 transition-colors">(wajib)</span>
                    </span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h2v2H7v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z"/>
                        </svg>
                    </div>
                    <input type="date" id="date" name="date" value="{{ old('date') ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all duration-300 hover:border-indigo-300 @error('date') border-red-300 @enderror" required>
                </div>
                @error('date')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bukti (Foto) -->
            <div class="space-y-2">
                <label for="proof_image" class="block text-sm font-medium text-gray-700 relative group">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 4h16v12H8l-4 4V4zm2 2v10.586L7.414 15H18V6H6zm2 2h8v2H8V8zm0 4h5v2H8v-2z"/>
                        </svg>
                        Bukti Pendukung
                        <span class="ml-2 text-xs text-gray-500 group-hover:text-indigo-600 transition-colors">(wajib)</span>
                    </span>
                </label>
                <div class="mt-1">
                    <!-- File Upload Area -->
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-300 transition-colors duration-300"
                         @dragover.prevent="$event.dataTransfer.dropEffect = 'copy';"
                         @drop.prevent="const files = $event.dataTransfer.files; if (files.length) { $refs.proof_image.files = files; fileName = files[0].name; preview = URL.createObjectURL(files[0]); }">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="proof_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                    <span x-text="fileName"></span>
                                    <input id="proof_image" name="proof_image" type="file" class="sr-only" accept="image/*" required
                                           x-ref="proof_image"
                                           @change="fileName = $event.target.files[0] ? $event.target.files[0].name : 'Pilih atau seret file ke sini'; preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                                </label>
                                <p class="pl-1">atau seret ke sini</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF maksimal 5MB</p>
                        </div>
                    </div>

                    <!-- Upload Progress -->
                    <div x-show="uploading" class="mt-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Mengunggah...</span>
                            <span x-text="progress + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-300" :style="{ width: progress + '%' }"></div>
                        </div>
                    </div>

                    <!-- Preview Area -->
                    <div class="mt-4">
                        <div x-show="preview && !uploading" x-transition.opacity class="border border-gray-200 rounded-lg p-2">
                            <p class="text-sm font-medium text-gray-700 mb-2">Pratinjau:</p>
                            <img :src="preview" alt="Preview dokumen" class="max-w-full h-auto max-h-64 mx-auto rounded">
                        </div>
                    </div>
                </div>
                @error('proof_image')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="pt-6">
                <div class="flex justify-between">
                    <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2 -ml-1 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2 3h20v12H8l-6 6V3zm2 2v10.586L5.414 14H20V5H4zm4 2h8v2H8V7zm0 4h5v2H8v-2z"/>
                        </svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
