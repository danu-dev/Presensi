@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 font-['Inter']">Edit Siswa</h1>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <div class="mt-1">
                        <input type="text"
                               class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('name') border-red-300 @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $student->name) }}"
                               required>
                    </div>
                    @error('name')
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
                    @if ($student->image_path)
                        <div class="mt-2">
                            <img src="{{ Storage::url($student->image_path) }}" alt="{{ $student->name }}" class="w-24 h-24 object-cover rounded-md">
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        </div>
                    @else
                        <p class="mt-2 text-sm text-gray-500">Belum ada gambar yang diunggah.</p>
                    @endif
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <div class="mt-1">
                        <input type="text"
                               class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('role') border-red-300 @enderror"
                               id="role"
                               name="role"
                               value="{{ old('role', $student->role) }}"
                               required>
                    </div>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GitHub URL -->
                <div>
                    <label for="github_url" class="block text-sm font-medium text-gray-700">GitHub URL</label>
                    <div class="mt-1">
                        <input type="url"
                               class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('github_url') border-red-300 @enderror"
                               id="github_url"
                               name="github_url"
                               value="{{ old('github_url', $student->github_url) }}">
                    </div>
                    @error('github_url')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- LinkedIn URL -->
                <div>
                    <label for="linkedin_url" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                    <div class="mt-1">
                        <input type="url"
                               class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('linkedin_url') border-red-300 @enderror"
                               id="linkedin_url"
                               name="linkedin_url"
                               value="{{ old('linkedin_url', $student->linkedin_url) }}">
                    </div>
                    @error('linkedin_url')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instagram URL -->
                <div>
                    <label for="instagram_url" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                    <div class="mt-1">
                        <input type="url"
                               class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('instagram_url') border-red-300 @enderror"
                               id="instagram_url"
                               name="instagram_url"
                               value="{{ old('instagram_url', $student->instagram_url) }}">
                    </div>
                    @error('instagram_url')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex space-x-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.students.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
