@extends('layouts.app')

@section('title', 'Tambah Proyek')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 font-['Inter']">Tambah Proyek</h1>
            <p class="mt-1 text-sm text-gray-600">Anda dapat menambahkan banyak proyek sekaligus</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div id="projects-container">
                    <!-- Template untuk input proyek -->
                    <div class="project-form mb-8 p-4 border border-gray-200 rounded-lg" data-index="0">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Proyek #1</h3>
                            <button type="button" class="remove-project text-red-600 hover:text-red-800 text-sm font-medium" onclick="removeProject(this)">
                                Hapus
                            </button>
                        </div>

                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="projects[0][title]" class="block text-sm font-medium text-gray-700">Judul</label>
                            <div class="mt-1">
                                <input type="text"
                                       class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('projects.0.title') border-red-300 @enderror"
                                       id="projects[0][title]"
                                       name="projects[0][title]"
                                       value="{{ old('projects.0.title') }}"
                                       placeholder="Contoh: Aplikasi Monitoring Covid-19"
                                       required>
                            </div>
                            @error('projects.0.title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-4">
                            <label for="projects[0][image]" class="block text-sm font-medium text-gray-700">Gambar</label>
                            <div class="mt-1">
                                <input type="file"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all duration-300 @error('projects.0.image') border-red-300 @enderror"
                                       id="projects[0][image]"
                                       name="projects[0][image]"
                                       placeholder="Contoh: project.png">
                            </div>
                            @error('projects.0.image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="projects[0][description]" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <div class="mt-1">
                                <textarea
                                    class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm min-h-[120px] py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('projects.0.description') border-red-300 @enderror"
                                    id="projects[0][description]"
                                    name="projects[0][description]"
                                    required>{{ old('projects.0.description') }}</textarea>
                            </div>
                            @error('projects.0.description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Tim -->
                        <div class="mb-4">
                            <label for="projects[0][team_name]" class="block text-sm font-medium text-gray-700">Nama Tim</label>
                            <div class="mt-1">
                                <input type="text"
                                       class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('projects.0.team_name') border-red-300 @enderror"
                                       id="projects[0][team_name]"
                                       name="projects[0][team_name]"
                                       value="{{ old('projects.0.team_name') }}"
                                       placeholder="Contoh: Tim A"
                                       required>
                            </div>
                            @error('projects.0.team_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teknologi -->
                        <div class="mb-4">
                            <label for="projects[0][technologies]" class="block text-sm font-medium text-gray-700">Teknologi</label>
                            <div class="mt-1">
                                <input type="text"
                                       class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3 transition-all duration-300 hover:border-indigo-300 @error('projects.0.technologies') border-red-300 @enderror"
                                       id="projects[0][technologies]"
                                       name="projects[0][technologies]"
                                       value="{{ old('projects.0.technologies') }}"
                                       placeholder="Contoh: Laravel, Vue.js, MySQL"
                                       required>
                            </div>
                            @error('projects.0.technologies')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" id="add-project" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Proyek Lain
                    </button>
                </div>

                <!-- Tombol -->
                <div class="flex space-x-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Semua
                    </button>
                    <a href="{{ route('admin.projects.index') }}"
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
    let projectCount = 1;

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-project').addEventListener('click', addProjectForm);
    });

    function addProjectForm() {
        projectCount++;
        const container = document.getElementById('projects-container');
        const template = document.querySelector('.project-form').cloneNode(true);

        // Update semua atribut dan ID dengan index baru
        template.setAttribute('data-index', projectCount - 1);
        template.querySelector('h3').textContent = `Proyek #${projectCount}`;

        const inputs = template.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            const name = input.getAttribute('name').replace('[0]', `[${projectCount - 1}]`);
            const id = input.getAttribute('id').replace('[0]', `[${projectCount - 1}]`);

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

    function removeProject(button) {
        const projectForm = button.closest('.project-form');
        if (document.querySelectorAll('.project-form').length > 1) {
            projectForm.remove();
            // Update nomor urut proyek yang tersisa
            updateProjectNumbers();
        } else {
            alert('Anda harus memiliki setidaknya satu form proyek.');
        }
    }

    function updateProjectNumbers() {
        const forms = document.querySelectorAll('.project-form');
        forms.forEach((form, index) => {
            form.setAttribute('data-index', index);
            form.querySelector('h3').textContent = `Proyek #${index + 1}`;

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
        projectCount = forms.length;
    }
</script>
@endsection
@endsection
