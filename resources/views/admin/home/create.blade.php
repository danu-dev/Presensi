@extends('layouts.app')

@section('title', 'Tambah Konten Home')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 font-['Inter']">Tambah Konten Home</h1>
        </div>
        <!-- Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.home.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ submitting: false, imagePreview: null }" @submit="submitting = true">
                @csrf
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                    <div class="mt-1">
                        <input type="text"
                               class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('title') border-red-300 @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Contoh: Selamat Datang di Website Kami"
                               required>
                    </div>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Subjudul -->
                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700">Subjudul</label>
                    <div class="mt-1">
                        <input type="text"
                               class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('subtitle') border-red-300 @enderror"
                               id="subtitle"
                               name="subtitle"
                               value="{{ old('subtitle') }}"
                               placeholder="Contoh: Kami bergerak di bidang teknologi"
                               required>
                    </div>
                    @error('subtitle')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <div class="mt-1">
                        <textarea
                            class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm min-h-[120px] py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('description') border-red-300 @enderror"
                            id="description"
                            name="description"
                            required>{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Gambar -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                    <div class="mt-1">
                        <input type="file"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all duration-300 @error('image') border-red-300 @enderror"
                               id="image"
                               name="image"
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               @change="handleImageChange($event)">
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <!-- Pratinjau Gambar -->
                    <div x-show="imagePreview" class="mt-4">
                        <p class="text-sm text-gray-600">Pratinjau Gambar:</p>
                        <img :src="imagePreview" alt="Pratinjau Gambar" class="mt-2 max-w-xs rounded-md shadow-sm">
                    </div>
                </div>
                <!-- Tombol -->
                <div class="flex space-x-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:bg-gray-400 disabled:cursor-not-allowed"
                            :disabled="submitting">
                        <span x-show="!submitting">Simpan</span>
                        <span x-show="submitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                    <a href="{{ route('admin.home.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('form', () => ({
            submitting: false,
            imagePreview: null,
            handleImageChange(event) {
                const file = event.target.files[0];
                if (!file) {
                    this.imagePreview = null;
                    return;
                }

                // Validasi format dan ukuran file
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (!allowedTypes.includes(file.type)) {
                    alert('Format gambar tidak valid. Gunakan JPEG, PNG, JPG, atau GIF.');
                    event.target.value = '';
                    this.imagePreview = null;
                    return;
                }
                if (file.size > maxSize) {
                    alert('Ukuran gambar terlalu besar. Maksimum 2MB.');
                    event.target.value = '';
                    this.imagePreview = null;
                    return;
                }

                // Buat pratinjau gambar
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }));
    });
</script>
@endsection