@extends('layouts.app')

@section('title', 'Detail Izin')

@section('content')
<div class="w-full min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-6 md:py-10 lg:py-12 overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 md:mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 transition-all">Detail Izin</h2>
                <p class="text-sm md:text-base text-gray-600 mt-1">Detail pengajuan izin siswa</p>
            </div>
            <a href="{{ url('guru/permissions') }}" class="bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-600 transition-all duration-300 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Izin
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Informasi Izin -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all">
            <div class="bg-gray-50 p-4 md:p-5 rounded-t-xl border-b flex justify-between items-center">
                <h5 class="text-base md:text-lg font-bold text-gray-800">Informasi Izin</h5>
                <div>
                    @if ($permission->status === 'approved')
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm font-medium">Disetujui</span>
                    @elseif ($permission->status === 'rejected')
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-lg text-sm font-medium">Ditolak</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg text-sm font-medium animate-pulse">Pending</span>
                    @endif
                </div>
            </div>
            <div class="p-4 md:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-5">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 hover:border-blue-200 transition-all">
                            <h6 class="text-sm md:text-base text-gray-500 mb-1">Nama Siswa</h6>
                            <p class="text-base md:text-lg font-semibold text-gray-800">{{ $permission->user->name }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 hover:border-blue-200 transition-all">
                            <h6 class="text-sm md:text-base text-gray-500 mb-1">Alasan</h6>
                            <p class="text-base md:text-lg font-semibold text-gray-800">{{ $permission->name }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 hover:border-blue-200 transition-all">
                            <h6 class="text-sm md:text-base text-gray-500 mb-1">Deskripsi</h6>
                            <p class="text-sm md:text-base text-gray-700">{{ $permission->description }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 hover:border-blue-200 transition-all">
                            <h6 class="text-sm md:text-base text-gray-500 mb-1">Tanggal</h6>
                            <p class="text-base md:text-lg font-semibold text-gray-800">
                                {{ isset($permission->date) ? \Carbon\Carbon::parse($permission->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'Tidak ada tanggal' }}
                            </p>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Bukti) -->
                    <div>
                        <h6 class="text-sm md:text-base text-gray-500 mb-3">Bukti</h6>
                        <div class="border border-gray-200 rounded-lg p-1 hover:shadow-md transition-all">
                            @if ($permission->proof_image)
                                <a href="{{ Storage::url($permission->proof_image) }}" target="_blank" class="block">
                                    <img src="{{ Storage::url($permission->proof_image) }}" alt="Bukti Izin" class="w-full h-auto max-h-96 object-cover rounded-lg shadow-sm hover:opacity-90 transition-all">
                                </a>
                                <div class="mt-2 text-center">
                                    <a href="{{ Storage::url($permission->proof_image) }}" download class="text-blue-500 hover:text-blue-700 text-sm">
                                        <i class="fas fa-download mr-1"></i> Download Bukti
                                    </a>
                                </div>
                            @else
                                <div class="bg-gray-50 rounded-lg p-8 flex items-center justify-center text-gray-500 border-2 border-dashed border-gray-300">
                                    <div class="text-center">
                                        <i class="fas fa-file-image text-3xl mb-2"></i>
                                        <p>Tidak ada bukti tersedia</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Form Validasi (jika status masih pending) -->
                @if (!$permission->status)
                    <hr class="my-6 border-gray-200">
                    <div class="bg-blue-50 p-5 rounded-lg border border-blue-100 mt-6">
                        <h6 class="text-base md:text-lg font-semibold text-blue-800 mb-3">Validasi Izin</h6>
                        <form action="{{ url('guru/validate-permission/' . $permission->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <select name="status" class="w-full sm:w-auto border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition-all">
                                <option value="approved">Setujui</option>
                                <option value="rejected">Tolak</option>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-600 transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-check mr-2"></i> Submit
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection