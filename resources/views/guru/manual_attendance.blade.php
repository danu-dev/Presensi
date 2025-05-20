{{-- @extends('layouts.app')

@section('styles')
<style>
    select.custom-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
    select.custom-select.border-red-500 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23EF4444' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    }
    input[type="date"].custom-date {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 2v2m8-2v2M4 8h12M4 4h12v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
    input[type="date"].custom-date.border-red-500 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23EF4444' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 2v2m8-2v2M4 8h12M4 4h12v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z'/%3e%3c/svg%3e");
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Manual Attendance</h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('guru.manual_attendance') }}" class="mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                            <select name="room_id" id="room_id" class="custom-select w-full bg-white border {{ $errors->has('room_id') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm py-2 px-3 pr-8 focus:ring-indigo-500 focus:border-indigo-500 hover:border-indigo-300 sm:text-sm appearance-none transition-colors duration-200" required aria-label="Pilih kelas">
                                <option value="">Pilih Kelas</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $selectedRoomId == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="date" id="date" value="{{ $date }}" class="custom-date w-full bg-white border {{ $errors->has('date') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm py-2 px-3 pr-8 focus:ring-indigo-500 focus:border-indigo-500 hover:border-indigo-300 sm:text-sm appearance-none transition-colors duration-200" required aria-label="Pilih tanggal">
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Muat Siswa
                            </button>
                        </div>
                    </div>
                </form>

                @if($selectedRoomId)
                <div class="mb-4">
                    <input type="text" id="student-search" class="w-full sm:w-1/2 border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Cari siswa berdasarkan nama..." aria-label="Cari siswa">
                </div>
                <form method="POST" action="{{ route('guru.manual_attendance') }}">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $selectedRoomId }}">
                    <input type="hidden" name="date" value="{{ $date }}">
                    <div class="overflow-x-auto max-h-[60vh]">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="student-table">
                                @foreach($students as $student)
                                    <tr class="student-row" data-name="{{ strtolower($student->name) }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex space-x-2">
                                                <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md cursor-pointer {{ isset($existingAttendances[$student->id]) ? 'bg-green-100 border-green-500' : 'bg-white' }} hover:bg-green-50">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="present" class="form-radio text-green-600" {{ isset($existingAttendances[$student->id]) ? 'checked' : '' }} aria-label="Tandai {{ $student->name }} sebagai Hadir">
                                                    <span class="ml-2 text-gray-700">Hadir</span>
                                                </label>
                                                <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md cursor-pointer {{ isset($permissions[$student->id]) ? 'bg-yellow-100 border-yellow-500' : 'bg-white' }} hover:bg-yellow-50">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="permission" class="form-radio text-yellow-600" {{ isset($permissions[$student->id]) ? 'checked' : '' }} aria-label="Tandai {{ $student->name }} sebagai Izin/Sakit">
                                                    <span class="ml-2 text-gray-700">Izin/Sakit</span>
                                                </label>
                                                <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md cursor-pointer {{ !isset($existingAttendances[$student->id]) && !isset($permissions[$student->id]) ? 'bg-red-100 border-red-500' : 'bg-white' }} hover:bg-red-50">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="absent" class="form-radio text-red-600" {{ !isset($existingAttendances[$student->id]) && !isset($permissions[$student->id]) ? 'checked' : '' }} aria-label="Tandai {{ $student->name }} sebagai Alpa">
                                                    <span class="ml-2 text-gray-700">Alpa</span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $students->appends(['room_id' => $selectedRoomId, 'date' => $date])->links('pagination::tailwind') }}
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Kehadiran
                        </button>
                    </div>
                </form>
                @else
                    <p class="text-gray-500 text-center">Silakan pilih kelas untuk melihat daftar siswa.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomSelect = document.querySelector('[name="room_id"]');
        roomSelect.addEventListener('change', function () {
            const roomId = this.value;
            if (roomId) {
                this.form.submit();
            }
        });
        const searchInput = document.querySelector('#student-search');
        const studentRows = document.querySelectorAll('.student-row');
        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            studentRows.forEach(row => {
                const studentName = row.dataset.name;
                row.style.display = studentName.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
@endsection --}}
@extends('layouts.app')

@section('styles')
<style>
    select.custom-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
    select.custom-select.border-red-500 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23EF4444' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    }
    input[type="date"].custom-date {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 2v2m8-2v2M4 8h12M4 4h12v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
    input[type="date"].custom-date.border-red-500 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23EF4444' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 2v2m8-2v2M4 8h12M4 4h12v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4z'/%3e%3c/svg%3e");
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Manual Attendance</h2>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('guru.manual_attendance') }}" class="mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                            <select name="room_id" id="room_id" class="custom-select w-full bg-white border {{ $errors->has('room_id') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm py-2 px-3 pr-8 focus:ring-indigo-500 focus:border-indigo-500 hover:border-indigo-300 sm:text-sm appearance-none transition-colors duration-200" required aria-label="Pilih kelas">
                                <option value="">Pilih Kelas</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $selectedRoomId == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="date" id="date" value="{{ $date }}" class="custom-date w-full bg-white border {{ $errors->has('date') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm py-2 px-3 pr-8 focus:ring-indigo-500 focus:border-indigo-500 hover:border-indigo-300 sm:text-sm appearance-none transition-colors duration-200" required aria-label="Pilih tanggal">
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Muat Siswa
                            </button>
                        </div>
                    </div>
                </form>

                @if($selectedRoomId)
                <div class="mb-4">
                    <input type="text" id="student-search" class="w-full sm:w-1/2 border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Cari siswa berdasarkan nama..." aria-label="Cari siswa">
                </div>
                <form method="POST" action="{{ route('guru.manual_attendance') }}">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $selectedRoomId }}">
                    <input type="hidden" name="date" value="{{ $date }}">
                    <div class="overflow-x-auto max-h-[60vh]">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-50 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="student-table">
                                @foreach($students as $student)
                                    <tr class="student-row" data-name="{{ strtolower($student->name) }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex space-x-2">
                                                <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md cursor-pointer {{ isset($existingAttendances[$student->id]) ? 'bg-green-100 border-green-500' : 'bg-white' }} hover:bg-green-50">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="present" class="form-radio text-green-600" {{ isset($existingAttendances[$student->id]) ? 'checked' : '' }} aria-label="Tandai {{ $student->name }} sebagai Hadir">
                                                    <span class="ml-2 text-gray-700">Hadir</span>
                                                </label>
                                                <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md cursor-pointer {{ isset($permissions[$student->id]) ? 'bg-yellow-100 border-yellow-500' : 'bg-white' }} hover:bg-yellow-50">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="permission" class="form-radio text-yellow-600" {{ isset($permissions[$student->id]) ? 'checked' : '' }} aria-label="Tandai {{ $student->name }} sebagai Izin/Sakit">
                                                    <span class="ml-2 text-gray-700">Izin/Sakit</span>
                                                </label>
                                                <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md cursor-pointer {{ !isset($existingAttendances[$student->id]) && !isset($permissions[$student->id]) ? 'bg-red-100 border-red-500' : 'bg-white' }} hover:bg-red-50">
                                                    <input type="radio" name="attendances[{{ $student->id }}]" value="absent" class="form-radio text-red-600" {{ !isset($existingAttendances[$student->id]) && !isset($permissions[$student->id]) ? 'checked' : '' }} aria-label="Tandai {{ $student->name }} sebagai Alpa">
                                                    <span class="ml-2 text-gray-700">Alpa</span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $students->appends(['room_id' => $selectedRoomId, 'date' => $date])->links('pagination::tailwind') }}
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Kehadiran
                        </button>
                    </div>
                </form>
                @else
                    <p class="text-gray-500 text-center">Silakan pilih kelas untuk melihat daftar siswa.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomSelect = document.querySelector('[name="room_id"]');
        roomSelect.addEventListener('change', function () {
            const roomId = this.value;
            if (roomId) {
                this.form.submit();
            }
        });
        const searchInput = document.querySelector('#student-search');
        const studentRows = document.querySelectorAll('.student-row');
        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            studentRows.forEach(row => {
                const studentName = row.dataset.name;
                row.style.display = studentName.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
@endsection
