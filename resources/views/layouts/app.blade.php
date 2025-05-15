<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false, profileOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sistem Absensi Kelas - SIHADIR')</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Leaflet CSS untuk Peta -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background-color: #f7fafc; /* Ganti bg-gray-100 dengan warna lebih soft */
        }
        .sidebar-gradient {
            background: linear-gradient(180deg, #1e40af, #1e3a8a);
        }
        [x-cloak] {
            display: none;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .nav-link-sidebar {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #ffffff;
            font-weight: 600; /* Sedikit lebih tebal untuk kesan modern */
            border-radius: 0.5rem; /* Radius sedikit lebih besar */
            transition: all 0.3s ease;
        }
        .nav-link-sidebar:hover {
            background: rgba(255, 255, 255, 0.15); /* Opacity lebih tinggi untuk kontras */
            padding-left: 1.5rem;
        }
        .nav-link-sidebar.active {
            background: rgba(255, 255, 255, 0.2); /* Styling untuk link aktif */
        }
        .nav-link-sub {
            display: block;
            padding: 0.5rem 1rem;
            color: #e2e8f0;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link-sub:hover {
            color: #ffffff;
            padding-left: 1.25rem;
            background: rgba(255, 255, 255, 0.05); /* Efek hover lebih halus */
        }
        /* Topbar */
        header {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); /* Bayangan lebih lembut */
        }
        /* Dropdown Profile */
        .profile-dropdown {
            animation: slideDown 0.3s ease-in-out;
        }
        /* Footer */
        footer {
            background: #ffffff;
            box-shadow: inset 0 1px 0 rgba(0, 0, 0, 0.05); /* Bayangan dalam lebih halus */
        }
    </style>

    @yield('styles')
</head>
<body class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 sidebar-gradient text-white transform transition-transform duration-300 ease-in-out z-20 shadow-lg"
         :class="{ '-translate-x-full': !sidebarOpen }"
         x-cloak>
        <div class="p-5 flex items-center justify-between border-b border-blue-800/50">
            <a href="{{ url('/') }}" class="font-['Poppins'] font-bold text-2xl tracking-wide hover:text-blue-200 transition duration-300">
                Presensi
            </a>
            <button class="md:hidden text-white hover:text-blue-200" @click="sidebarOpen = false">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <nav class="mt-6 px-3">
            <ul class="space-y-2">
                @auth
                    @if (auth()->user()->role == 'user')
                        <li><a href="{{ url('user/dashboard') }}" class="nav-link-sidebar {{ request()->is('user/dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
                        <li><a href="{{ url('user/attendance') }}" class="nav-link-sidebar {{ request()->is('user/attendance') ? 'active' : '' }}"><i class="fas fa-check-circle mr-2"></i> Absensi</a></li>
                        <li><a href="{{ url('user/history') }}" class="nav-link-sidebar {{ request()->is('user/history') ? 'active' : '' }}"><i class="fas fa-history mr-2"></i> Riwayat</a></li>
                        <li><a href="{{ url('user/permission') }}" class="nav-link-sidebar {{ request()->is('user/permission') ? 'active' : '' }}"><i class="fas fa-file-alt mr-2"></i> Izin</a></li>
                    @elseif (auth()->user()->role == 'guru')
                        <li><a href="{{ url('guru/dashboard') }}" class="nav-link-sidebar {{ request()->is('guru/dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
                        <li><a href="{{ url('guru/report') }}" class="nav-link-sidebar {{ request()->is('guru/report') ? 'active' : '' }}"><i class="fas fa-chart-bar mr-2"></i> Laporan Absensi</a></li>
                        <li><a href="{{ url('guru/permissions') }}" class="nav-link-sidebar {{ request()->is('guru/permissions') ? 'active' : '' }}"><i class="fas fa-check-square mr-2"></i> Validasi Izin</a></li>
                    @elseif (auth()->user()->role == 'admin')
                        <li><a href="{{ url('admin/dashboard') }}" class="nav-link-sidebar {{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a></li>
                        <li x-data="{ open: false }">
                            <a href="#" class="nav-link-sidebar" @click.prevent="open = !open">
                                <i class="fas fa-database mr-2"></i> Kelola Data
                                <i class="fas fa-chevron-down ml-auto transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                            </a>
                            <ul x-show="open" class="pl-4 mt-1 space-y-1" x-transition>
                                <li><a href="{{ route('admin.users.index') }}" class="nav-link-sub">Kelola Pengguna</a></li>
                                <li><a href="{{ route('admin.locations.index') }}" class="nav-link-sub">Kelola Lokasi</a></li>
                                <li><a href="{{ route('admin.rooms.index') }}" class="nav-link-sub">Kelola Ruangan</a></li>
                            </ul>
                        </li>
                        <li x-data="{ open: false }">
                            <a href="#" class="nav-link-sidebar" @click.prevent="open = !open">
                                <i class="fas fa-folder mr-2"></i> Konten
                                <i class="fas fa-chevron-down ml-auto transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                            </a>
                            <ul x-show="open" class="pl-4 mt-1 space-y-1" x-transition>
                                <li><a href="{{ route('admin.home.index') }}" class="nav-link-sub">Home</a></li>
                                <li><a href="{{ route('admin.about.index') }}" class="nav-link-sub">About</a></li>
                                <li><a href="{{ route('admin.gallery.index') }}" class="nav-link-sub">Galeri</a></li>
                                <li><a href="{{ route('admin.projects.index') }}" class="nav-link-sub">Proyek</a></li>
                                <li><a href="{{ route('admin.students.index') }}" class="nav-link-sub">Siswa</a></li>
                            </ul>
                        </li>
                    @endif
                @else
                    <li x-data="{ open: false }">
                        <a href="#" class="nav-link-sidebar" @click.prevent="open = !open">
                            <i class="fas fa-bars mr-2"></i> Menu
                            <i class="fas fa-chevron-down ml-auto transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                        </a>
                        <ul x-show="open" class="pl-4 mt-1 space-y-1" x-transition>
                            <li><a href="{{ url('/') }}#home" class="nav-link-sub">Home</a></li>
                            <li><a href="{{ url('/') }}#about" class="nav-link-sub">About</a></li>
                            <li><a href="{{ url('/') }}#gallery" class="nav-link-sub">Galeri</a></li>
                            <li><a href="{{ url('/') }}#projects" class="nav-link-sub">Proyek</a></li>
                            <li><a href="{{ url('/') }}#students" class="nav-link-sub">Siswa</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('login') }}" class="nav-link-sidebar {{ request()->routeIs('login') ? 'active' : '' }}"><i class="fas fa-sign-in-alt mr-2"></i> Login</a></li>
                    <li><a href="{{ url('/register') }}" class="nav-link-sidebar {{ request()->is('register') ? 'active' : '' }}"><i class="fas fa-user-plus mr-2"></i> Register</a></li>
                @endauth
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 w-full transition-all duration-300" :class="{ 'lg:ml-64': sidebarOpen }">
        <!-- Topbar -->
        <header class="bg-white shadow-md px-4 py-4 flex items-center justify-between sticky top-0 z-10 w-full box-border">
            <div class="flex items-center space-x-4">
                <button class="text-[#1e40af] hover:text-[#1e3a8a] transition-colors duration-300" @click="sidebarOpen = !sidebarOpen">
                    <i class="fas text-lg" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800 font-['Inter']">@yield('header-title', 'Dashboard')</h1>
            </div>
            <div x-data="{ open: false }" class="relative">
                @auth
                    <button @click="open = !open" class="flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-full transition-colors duration-300">
                        <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('img/pro.png') }}"
                             alt="Profile" class="w-10 h-10 rounded-full border-2 border-[#1e40af] shadow-sm">
                        <div class="text-left hidden md:block">
                            <span class="text-sm font-semibold text-gray-700 font-['Inter']">{{ auth()->user()->name }}</span>
                            <p class="text-xs text-gray-500 capitalize font-['Inter']">{{ auth()->user()->role }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="profile-dropdown absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-10 overflow-hidden">
                        <div class="p-3 border-b border-gray-100 bg-gray-50">
                            <p class="text-sm font-semibold text-gray-700 font-['Inter']">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 capitalize font-['Inter']">{{ auth()->user()->role }}</p>
                        </div>
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-700 hover:bg-[#1e40af] hover:text-white transition-colors duration-300 font-['Inter']">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-[#1e40af] hover:text-white transition-colors duration-300 font-['Inter']">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <!-- Main Content -->
        <main class="w-full max-w-full px-4 py-6 sm:px-6 lg:px-8 box-border">
            @yield('content')
        </main>

        <!-- Footer -->
        {{-- <footer class="bg-white border-t border-gray-200 py-4 mt-8 text-gray-600 text-sm shadow-inner w-full box-border">
            <div class="max-w-full px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
                <p class="mb-2 md:mb-0 font-['Inter']">© {{ date('Y') }} SIHADIR - Sistem Informasi Hadir. All rights reserved.</p>
                <p class="mb-0 font-['Inter']">Developed with <i class="fas fa-heart text-red-500"></i> for better education</p>
            </div>
        </footer> --}}
    </div>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Leaflet JS untuk Peta -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @yield('scripts')
</body>
</html>
