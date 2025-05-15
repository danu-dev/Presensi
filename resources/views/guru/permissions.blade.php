@extends('layouts.app')

@section('title', 'Validasi Izin')

@section('content')
<div class="w-full min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-6 md:py-10 lg:py-12 overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 md:mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 transition-all">Validasi Izin</h2>
                <p class="text-sm md:text-base text-gray-600 mt-1">Kelola dan validasi pengajuan izin siswa</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('guru.manual_attendance') }}" class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-green-600 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-user-edit mr-2"></i> Absensi Manual
                </a>
                <a href="{{ url('guru/dashboard') }}" class="bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-600 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Filter dan Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-4 md:p-6 border-l-4 border-blue-500">
                <h6 class="text-sm md:text-base text-gray-500 mb-1">Total Pengajuan</h6>
                <h3 class="text-xl md:text-2xl font-bold text-blue-600">{{ $permissions->total() }}</h3>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all p-4 md:p-6 border-l-4 border-yellow-400">
                <h6 class="text-sm md:text-base text-gray-500 mb-1">Menunggu Validasi</h6>
                <div class="flex items-center">
                    <h3 class="text-xl md:text-2xl font-bold text-yellow-500">{{ $permissions->where('status', null)->count() }}</h3>
                    @if($permissions->where('status', null)->count() > 0)
                        <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">!</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabel Validasi Izin -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all">
            <div class="bg-gray-50 p-4 md:p-5 rounded-t-xl border-b">
                <h5 class="text-base md:text-lg font-bold text-gray-800">Daftar Pengajuan Izin</h5>
            </div>
            <div class="p-4 md:p-6">
                <!-- Filter Status -->
                <form method="GET" action="{{ url('guru/permissions') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
                    <select name="status" class="w-full sm:w-auto border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </form>

                <!-- Tabel -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-left">
                        <thead class="bg-blue-500 text-white">
                            <tr>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Nama Siswa</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Alasan</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Deskripsi</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Bukti</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Status</th>
                                <th class="p-3 md:p-4 text-sm md:text-base font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr class="hover:bg-gray-50 transition-colors border-t border-gray-200">
                                    <td class="p-3 md:p-4 text-sm md:text-base font-medium">{{ $permission->user->name }}</td>
                                    <td class="p-3 md:p-4 text-sm md:text-base">{{ $permission->name }}</td>
                                    <td class="p-3 md:p-4 text-sm md:text-base">{{ \Illuminate\Support\Str::limit($permission->description, 50) }}</td>
                                    <td class="p-3 md:p-4">
                                        <a href="{{ route('guru.permission.show', $permission->id) }}" class="inline-block text-blue-500 border border-blue-500 font-medium py-1 px-3 rounded-lg hover:bg-blue-500 hover:text-white transition-all duration-300">
                                            <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                    </td>
                                    <td class="p-3 md:p-4">
                                        @if ($permission->status === 'approved')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-lg text-sm font-medium">Disetujui</span>
                                        @elseif ($permission->status === 'rejected')
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-lg text-sm font-medium">Ditolak</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-lg text-sm font-medium animate-pulse">Pending</span>
                                        @endif
                                    </td>
                                    <td class="p-3 md:p-4">
                                        @if (!$permission->status)
                                            <form action="{{ url('guru/validate-permission/' . $permission->id) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                                                @csrf
                                                <select name="status" class="w-full sm:w-auto text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                                                    <option value="approved">Setujui</option>
                                                    <option value="rejected">Tolak</option>
                                                </select>
                                                <button type="submit" class="bg-blue-500 text-white font-medium py-1 px-2 rounded-lg shadow-sm hover:bg-blue-600 transition-all duration-300 flex items-center justify-center text-sm">
                                                    <i class="fas fa-check mr-1"></i> Submit
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 text-sm italic">Sudah divalidasi</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada pengajuan izin.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $permissions->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection