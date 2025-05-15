@extends('layouts.app')

@section('title', 'Edit Konten Home')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 font-['Inter']">Edit Konten Home</h1>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.home.update', $homeContent->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                    <div class="mt-1">
                        <input type="text"
                               class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('title') border-red-300 @enderror"
                               id="title"
                               name="title"
                               value="{{ old('title', $homeContent->title) }}"
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
                               value="{{ old('subtitle', $homeContent->subtitle) }}"
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
                            required>{{ old('description', $homeContent->description) }}</textarea>
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
                               name="image">
                    </div>
                    @if ($homeContent->image_path)
                        <div class="mt-2">
                            <img src="{{ Storage::url($homeContent->image_path) }}" alt="{{ $homeContent->title }}" class="w-24 h-24 object-cover rounded-md">
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        </div>
                    @else
                        <p class="mt-2 text-sm text-gray-500">Belum ada gambar yang diunggah.</p>
                    @endif
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex space-x-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Perubahan
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
