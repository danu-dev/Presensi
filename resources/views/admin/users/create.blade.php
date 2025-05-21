@extends('layouts.app')

@section('header-title', 'Tambah Pengguna')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Tambah Pengguna Baru</h1>
            <p class="mt-1 text-sm text-gray-600">Masukkan informasi pengguna baru di bawah ini. Anda bisa menambahkan banyak pengguna sekaligus.</p>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="px-4 py-5 sm:p-6">
                    <div id="users-container">
                        <!-- Template untuk input pengguna -->
                        <div class="user-form mb-8 p-4 border border-gray-200 rounded-lg" data-index="0">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Pengguna #1</h3>
                                <button type="button" class="remove-user text-red-600 hover:text-red-800 text-sm font-medium" onclick="removeUser(this)">
                                    Hapus
                                </button>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="users[0][name]" class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" name="users[0][name]" id="users[0][name]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('users.*.name') border-red-300 @enderror" value="{{ old('users.0.name') }}" placeholder="Contoh: John Doe">
                                    @error('users.0.name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <label for="users[0][email]" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                    <input type="email" name="users[0][email]" id="users[0][email]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('users.*.email') border-red-300 @enderror" value="{{ old('users.0.email') }}" placeholder="Contoh: john@example.com">
                                    @error('users.0.email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <label for="users[0][nisn]" class="block text-sm font-medium text-gray-700">NISN <span class="nisn-required text-red-500">*</span></label>
                                    <input type="text" name="users[0][nisn]" id="users[0][nisn]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('users.*.nisn') border-red-300 @enderror" value="{{ old('users.0.nisn') }}" placeholder="Contoh: 1234567890">
                                    <p class="mt-1 text-xs text-gray-500">Wajib untuk role User (siswa).</p>
                                    @error('users.0.nisn')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <label for="users[0][password]" class="block text-sm font-medium text-gray-700">Password</label>
                                    <input type="password" name="users[0][password]" id="users[0][password]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('users.*.password') border-red-300 @enderror" placeholder="Minimal 6 karakter">
                                    @error('users.0.password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <label for="users[0][role]" class="block text-sm font-medium text-gray-700">Role</label>
                                    <select id="users[0][role]" name="users[0][role]" class="user-role mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('users.*.role') border-red-300 @enderror" onchange="toggleNisnRequirement(this)">
                                        <option value="user" {{ old('users.0.role') == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="guru" {{ old('users.0.role') == 'guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="admin" {{ old('users.0.role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('users.0.role')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" id="add-user" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Pengguna Lain
                        </button>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let userCount = 1;

    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi untuk form pertama
        const firstRoleSelect = document.querySelector('.user-role');
        if (firstRoleSelect) {
            toggleNisnRequirement(firstRoleSelect);
        }

        // Event listener untuk tombol tambah pengguna
        document.getElementById('add-user').addEventListener('click', addUserForm);
    });

    function addUserForm() {
        userCount++;
        const container = document.getElementById('users-container');
        const template = document.querySelector('.user-form').cloneNode(true);

        // Update semua atribut dan ID dengan index baru
        template.setAttribute('data-index', userCount - 1);
        template.querySelector('h3').textContent = `Pengguna #${userCount}`;

        const inputs = template.querySelectorAll('input, select');
        inputs.forEach(input => {
            const name = input.getAttribute('name').replace('[0]', `[${userCount - 1}]`);
            const id = input.getAttribute('id').replace('[0]', `[${userCount - 1}]`);

            input.setAttribute('name', name);
            input.setAttribute('id', id);
            input.value = '';

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

        // Inisialisasi toggle NISN untuk form baru
        const newRoleSelect = template.querySelector('.user-role');
        toggleNisnRequirement(newRoleSelect);
    }

    function removeUser(button) {
        const userForm = button.closest('.user-form');
        if (document.querySelectorAll('.user-form').length > 1) {
            userForm.remove();
            // Update nomor urut pengguna yang tersisa
            updateUserNumbers();
        } else {
            alert('Anda harus memiliki setidaknya satu form pengguna.');
        }
    }

    function updateUserNumbers() {
        const forms = document.querySelectorAll('.user-form');
        forms.forEach((form, index) => {
            form.setAttribute('data-index', index);
            form.querySelector('h3').textContent = `Pengguna #${index + 1}`;

            // Update semua name dan id atribut
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                const oldName = input.getAttribute('name');
                const oldId = input.getAttribute('id');

                const newName = oldName.replace(/\[\d+\]/, `[${index}]`);
                const newId = oldId.replace(/\[\d+\]/, `[${index}]`);

                input.setAttribute('name', newName);
                input.setAttribute('id', newId);
            });
        });
        userCount = forms.length;
    }

    function toggleNisnRequirement(selectElement) {
        const userForm = selectElement.closest('.user-form');
        const nisnInput = userForm.querySelector('input[name*="nisn"]');
        const nisnRequired = userForm.querySelector('.nisn-required');

        if (selectElement.value === 'user') {
            nisnInput.setAttribute('required', 'required');
            nisnRequired.style.display = 'inline';
        } else {
            nisnInput.removeAttribute('required');
            nisnRequired.style.display = 'none';
        }
    }
</script>
@endsection
