@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="min-h-screen bg-white py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Profil Saya</h2>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col items-center mb-6">
                <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('img/pro.png') }}"
                     alt="{{ auth()->user()->name }}"
                     class="w-24 h-24 object-cover rounded-full border-2 border-gray-200 mb-4">
                <h3 class="text-lg font-medium text-gray-800">{{ auth()->user()->name }}</h3>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                <p class="text-sm text-gray-500">{{ auth()->user()->role === 'user' ? 'Siswa' : ($user->role === 'guru' ? 'Guru' : 'Admin') }}</p>
                <p class="text-sm text-gray-500">NISN: {{ auth()->user()->nisn ?? '-' }}</p>
            </div>

            <a href="{{ route('profile.update') }}"
               class="w-full bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
