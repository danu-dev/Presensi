@extends('layouts.app')

@section('title', 'Tambah Galeri')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 font-['Inter']">Tambah Galeri</h1>
            <p class="mt-1 text-sm text-gray-600">Anda dapat menambahkan banyak galeri sekaligus</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div id="gallery-container">
                    <!-- Template untuk input galeri -->
                    <div class="gallery-form mb-8 p-4 border border-gray-200 rounded-lg" data-index="0">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Galeri #1</h3>
                            <button type="button" class="remove-gallery text-red-600 hover:text-red-800 text-sm font-medium" onclick="removeGallery(this)">
                                Hapus
                            </button>
                        </div>

                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="gallery[0][title]" class="block text-sm font-medium text-gray-700">Judul</label>
                            <div class="mt-1">
                                <input type="text"
                                       class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('gallery.0.title') border-red-300 @enderror"
                                       id="gallery[0][title]"
                                       name="gallery[0][title]"
                                       value="{{ old('gallery.0.title') }}"
                                       placeholder="Masukkan judul galeri"
                                       required>
                            </div>
                            @error('gallery.0.title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-4">
                            <label for="gallery[0][image]" class="block text-sm font-medium text-gray-700">Gambar</label>
                            <div class="mt-1">
                                <input type="file"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all duration-300 @error('gallery.0.image') border-red-300 @enderror"
                                       id="gallery[0][image]"
                                       name="gallery[0][image]"
                                       required>
                            </div>
                            @error('gallery.0.image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="gallery[0][description]" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <div class="mt-1">
                                <textarea
                                    class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm min-h-[120px] py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('gallery.0.description') border-red-300 @enderror"
                                    id="gallery[0][description]"
                                    name="gallery[0][description]"
                                    placeholder="Tambahkan deskripsi galeri">{{ old('gallery.0.description') }}</textarea>
                            </div>
                            @error('gallery.0.description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" id="add-gallery" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Galeri Lain
                    </button>
                </div>

                <!-- Tombol -->
                <div class="flex space-x-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Semua
                    </button>
                    <a href="{{ route('admin.gallery.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    let galleryCount = 1;

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-gallery').addEventListener('click', addGalleryForm);
    });

    function addGalleryForm() {
        galleryCount++;
        const container = document.getElementById('gallery-container');
        const template = document.querySelector('.gallery-form').cloneNode(true);

        // Update semua atribut dan ID dengan index baru
        template.setAttribute('data-index', galleryCount - 1);
        template.querySelector('h3').textContent = `Galeri #${galleryCount}`;

        const inputs = template.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            const name = input.getAttribute('name').replace('[0]', `[${galleryCount - 1}]`);
            const id = input.getAttribute('id').replace('[0]', `[${galleryCount - 1}]`);

            input.setAttribute('name', name);
            input.setAttribute('id', id);
            if (input.type !== 'file') {
                input.value = '';
            }

            // Reset kelas error
            input.classList.remove('border-red-300');

            // Hapus pesan error jika ada
            const errorElement = input.nextElementSibling;
            if (errorElement && errorElement.classList.contains('text-red-600')) {
                errorElement.remove();
            }
        });

        // Tambahkan form baru ke container
        container.appendChild(template);
    }

    function removeGallery(button) {
        const galleryForm = button.closest('.gallery-form');
        if (document.querySelectorAll('.gallery-form').length > 1) {
            galleryForm.remove();
            // Update nomor urut galeri yang tersisa
            updateGalleryNumbers();
        } else {
            alert('Anda harus memiliki setidaknya satu form galeri.');
        }
    }

    function updateGalleryNumbers() {
        const forms = document.querySelectorAll('.gallery-form');
        forms.forEach((form, index) => {
            form.setAttribute('data-index', index);
            form.querySelector('h3').textContent = `Galeri #${index + 1}`;

            // Update semua name dan id atribut
            const inputs = form.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                const oldName = input.getAttribute('name');
                const oldId = input.getAttribute('id');

                const newName = oldName.replace(/\[\d+\]/, `[${index}]`);
                const newId = oldId.replace(/\[\d+\]/, `[${index}]`);

                input.setAttribute('name', newName);
                input.setAttribute('id', newId);
            });
        });
        galleryCount = forms.length;
    }
</script>
@endsection
@endsection
