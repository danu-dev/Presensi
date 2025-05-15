@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg p-6 sm:p-8 mt-6">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-4 sm:p-5 rounded-t-2xl -mt-6 -mx-6 sm:-mt-8 sm:-mx-8 mb-6">
            <h5 class="flex items-center font-semibold text-lg sm:text-xl m-0">
                <i class="fas fa-user mr-2"></i> Edit Profile
            </h5>
        </div>

        <!-- Form -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Image -->
            <div class="text-center mb-6">
                <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('img/pro.png') }}"
                     alt="Profile" class="w-28 h-28 sm:w-32 sm:h-32 object-cover rounded-full border-4 border-blue-400 shadow-md hover:scale-105 transition-transform duration-300">
                <div class="mt-3">
                    <label for="profile_photo" class="inline-flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg text-sm font-medium hover:bg-blue-500 cursor-pointer transition-colors duration-300">
                        <i class="fas fa-camera mr-1"></i> Ganti Foto
                        <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>

            <!-- Name Input -->
            <div class="mb-5">
                <label for="name" class="block text-gray-700 font-semibold text-sm mb-2">Nama</label>
                <input type="text" name="name" id="name" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-5">
                <label for="email" class="block text-gray-700 font-semibold text-sm mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('email') border-red-500 @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-5">
                <label for="password" class="block text-gray-700 font-semibold text-sm mb-2">Kata Sandi Baru (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('password') border-red-500 @enderror">
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Confirmation Input -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-semibold text-sm mb-2">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-blue-400 to-blue-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:from-blue-500 hover:to-blue-700 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 active:translate-y-0 active:shadow-md">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
