@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-white py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Simple Card -->
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <!-- Clean Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Edit Profile</h2>
            </div>

            <!-- Form Content -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="profile-form">
                @csrf
                @method('PUT')

                <!-- Profile Picture Section -->
                <div class="flex flex-col items-center mb-6">
                    <div class="relative group">
                        <img id="profile-preview" src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('img/pro.png') }}"
                            class="w-24 h-24 object-cover rounded-full border-2 border-gray-200 transition-all duration-300 group-hover:border-indigo-600"
                            alt="Profile picture">
                        <label for="profile_photo" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full cursor-pointer transition-all duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                            aria-label="Change profile photo">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            <input type="file" name="profile_photo" id="profile_photo" class="sr-only" accept="image/*" onchange="previewImage(event)">
                        </label>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Max 2MB</p>
                </div>

                <!-- Form Fields -->
                <div class="space-y-5">
                    <!-- Name Field -->
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                            class="peer w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-300 transition-all duration-300 placeholder-transparent"
                            placeholder="Full Name" required>
                        <label for="name" class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all duration-300 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                            Full Name
                        </label>
                        @error('name')
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                            class="peer w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-300 transition-all duration-300 placeholder-transparent"
                            placeholder="Email Address" required>
                        <label for="email" class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all duration-300 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                            Email Address
                        </label>
                        @error('email')
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="peer w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-300 transition-all duration-300 placeholder-transparent"
                            placeholder="New Password">
                        <label for="password" class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all duration-300 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                            New Password (optional)
                        </label>
                        <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-indigo-600 transition-colors duration-300" onclick="togglePassword('password')" aria-label="Toggle password visibility">
                            <svg id="password-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="peer w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-indigo-600 focus:ring-1 focus:ring-indigo-300 transition-all duration-300 placeholder-transparent"
                            placeholder="Confirm New Password">
                        <label for="password_confirmation" class="absolute left-4 -top-2.5 bg-white px-1 text-sm text-gray-600 transition-all duration-300 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">
                            Confirm New Password
                        </label>
                        <button type="button" class="absolute right-3 top-3 text-gray-500 hover:text-indigo-600 transition-colors duration-300" onclick="togglePassword('password_confirmation')" aria-label="Toggle password visibility">
                            <svg id="password_confirmation-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-300 flex items-center justify-center"
                        x-data="{ loading: false }" @click="loading = true; setTimeout(() => loading = false, 2000)"
                        :disabled="loading">
                        <span x-show="!loading" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Save Changes
                        </span>
                        <span x-show="loading" class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    // Image preview function
    function previewImage(event) {
        const reader = new FileReader();
        const output = document.getElementById('profile-preview');
        const file = event.target.files[0];

        if (!file) return;

        // Validate file type and size
        if (!file.type.match('image.*')) {
            alert('Please select an image file (jpg, png, etc.)');
            event.target.value = '';
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Image size must be less than 2MB');
            event.target.value = '';
            return;
        }

        reader.onloadstart = () => {
            output.classList.add('opacity-50');
        };

        reader.onload = () => {
            output.src = reader.result;
            output.classList.remove('opacity-50');
        };

        reader.onerror = () => {
            output.classList.remove('opacity-50');
            alert('Error loading image. Please try another file.');
            event.target.value = '';
        };

        reader.readAsDataURL(file);
    }

    // Toggle password visibility
    function togglePassword(id) {
        const input = document.getElementById(id);
        const button = document.querySelector(`#${id}-eye`).parentElement;

        if (input.type === 'password') {
            input.type = 'text';
            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
            `;
        } else {
            input.type = 'password';
            button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            `;
        }
    }

    // Initialize floating labels
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('input').forEach(input => {
            if (input.value) {
                const label = input.previousElementSibling;
                if (label) {
                    label.classList.add('-top-2.5', 'text-sm', 'text-indigo-600');
                    label.classList.remove('top-3', 'text-base', 'text-gray-400');
                }
            }
        });
    });
</script>
@endsection
