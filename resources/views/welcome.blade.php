<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KELAS DIGITAL - XI RPL 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite('resources/js/app.js','resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(99, 101, 241, 0.664), rgba(168, 85, 247, 0.664)),
                        url('img/bg.jpg') no-repeat center center;
            background-size: cover;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
            position: relative;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(168, 85, 247, 0.4), transparent 60%);
        }
        .gallery-img {
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .gallery-img img {
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .gallery-img:hover img {
            transform: scale(1.1);
        }
        .gallery-img .overlay {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            background: linear-gradient(to top, rgba(79, 70, 229, 0.8), rgba(99, 102, 241, 0.4));
        }
        @keyframes floating {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .floating {
            animation: floating 6s ease-in-out infinite;
            filter: drop-shadow(0 20px 30px rgba(79, 70, 229, 0.3));
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .spinner {
            animation: spin 1.2s cubic-bezier(0.5, 0.1, 0.5, 0.9) infinite;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            transition: all 0.3s ease;
            z-index: 40;
        }
        .navbar.scrolled {
            background-color: white;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-collapse {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .nav-link {
            position: relative;
            font-weight: 500;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #6366f1;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .custom-btn {
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
        }
        .custom-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        .custom-btn:hover::before {
            left: 100%;
        }
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.1), 0 10px 10px -5px rgba(79, 70, 229, 0.04);
        }
        .glow {
            position: relative;
        }
        .glow::after {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            right: -15px;
            bottom: -15px;
            background: radial-gradient(circle at center, rgba(99, 102, 241, 0.3), transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
            border-radius: 30px;
        }
        .glow:hover::after {
            opacity: 1;
        }
        .glass {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
        }
        @media (max-width: 768px) {
            .navbar-collapse {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                width: 75%;
                max-width: 300px;
                background-color: white;
                box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
                padding: 2rem;
                transform: translateX(-100%);
                transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                overflow-y: auto;
                z-index: 50;
                display: block !important;
            }
            .navbar-collapse.show {
                transform: translateX(0);
            }
            .navbar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 49;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.4s ease;
            }
            .navbar-backdrop.show {
                opacity: 1;
                visibility: visible;
            }
        }
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            background-color: #6366f1;
            width: 0%;
            z-index: 100;
            transition: width 0.1s ease;
        }
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f5f5f5;
        }
        ::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-700">
    <!-- Progress Bar -->
    <div class="progress-bar"></div>

    <!-- Preloader -->
    <div class="loader fixed inset-0 bg-white flex justify-center items-center z-50 transition-opacity duration-500">
        <div class="flex flex-col items-center">
            <div class="spinner w-16 h-16 border-4 border-[#6366f1] border-t-transparent rounded-full"></div>
            <p class="mt-4 text-[#6366f1] font-medium animate-pulse">Loading...</p>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl md:text-2xl font-bold text-black flex items-center">
                <i class="bi bi-mortarboard-fill mr-2"></i>XI RPL 2
            </a>
            <button class="navbar-toggler md:hidden bg-white/20 text-white w-10 h-10 flex items-center justify-center rounded-full focus:outline-none backdrop-blur-md z-50" onclick="toggleMenu()">
                <i class="bi bi-list text-xl"></i>
            </button>
            <div class="navbar-backdrop" onclick="toggleMenu()"></div>
            <div class="navbar-collapse md:flex md:space-x-8 font-medium flex-col md:flex-row items-start md:items-center" id="navbarNav">
                <div class="flex items-center justify-between w-full md:hidden mb-8">
                    <a href="/" class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="bi bi-mortarboard-fill mr-2"></i>XI RPL 2
                    </a>
                    <button class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-800" onclick="toggleMenu()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <a href="#home" class="nav-link block md:inline-block py-3 md:py-0 text-gray-800 md:text-white hover:text-[#6366f1] transition-colors duration-300">Home</a>
                <a href="#about" class="nav-link block md:inline-block py-3 md:py-0 text-gray-800 md:text-white hover:text-[#6366f1] transition-colors duration-300">Tentang</a>
                <a href="#gallery" class="nav-link block md:inline-block py-3 md:py-0 text-gray-800 md:text-white hover:text-[#6366f1] transition-colors duration-300">Galeri</a>
                <a href="#projects" class="nav-link block md:inline-block py-3 md:py-0 text-gray-800 md:text-white hover:text-[#6366f1] transition-colors duration-300">Projek</a>
                <a href="#students" class="nav-link block md:inline-block py-3 md:py-0 text-gray-800 md:text-white hover:text-[#6366f1] transition-colors duration-300">Siswa</a>
                <a href="#contact" class="nav-link block md:inline-block py-3 md:py-0 text-gray-800 md:text-white hover:text-[#6366f1] transition-colors duration-300">Kontak</a>
                <div class="mt-8 md:hidden">
                    <a href="#contact" class="bg-[#6366f1] text-white px-6 py-3 rounded-full font-medium hover:bg-[#4f46e5] transition-all duration-300 inline-block">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section pt-36 md:pt-40 pb-32 text-white" id="home">
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center">
                @forelse ($homeContents as $content)
                    <div class="lg:w-1/2 text-center lg:text-left" data-aos="fade-right" data-aos-duration="1000">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">{{ $content->title }}</h1>
                        <h2 class="text-xl md:text-2xl font-semibold mb-6 opacity-90">{{ $content->subtitle }}</h2>
                        <p class="text-lg opacity-90 mb-8 max-w-lg mx-auto lg:mx-0">{{ $content->description }}</p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                            <a href="#projects" class="custom-btn bg-white text-[#6366f1] px-8 py-4 rounded-full font-semibold hover:bg-[#6366f1] hover:text-white transition-all duration-300 shadow-lg flex items-center">
                                <span>Lihat Projek</span>
                                <i class="bi bi-arrow-right ml-2"></i>
                            </a>
                            <a href="#contact" class="custom-btn border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-[#6366f1] transition-all duration-300 flex items-center">
                                <i class="bi bi-chat-dots mr-2"></i>
                                <span>Hubungi Kami</span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:w-1/2 mt-12 lg:mt-0 hidden lg:block" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                        <img src="{{ $content->image_path ? Storage::url($content->image_path) : 'img/hero-bg.jng' }}" class="floating mx-auto max-w-[80%] rounded-2xl" alt="Class Activity">
                    </div>
                @empty
                    <div class="lg:w-1/2 text-center lg:text-left" data-aos="fade-right" data-aos-duration="1000">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">Kelas Digital <br><span class="text-[#c7d2fe]">XI RPL 2</span></h1>
                        <h2 class="text-xl md:text-2xl font-semibold mb-6 opacity-90">Rekayasa Perangkat Lunak</h2>
                        <p class="text-lg opacity-90 mb-8 max-w-lg mx-auto lg:mx-0">Kami adalah kelas pemrograman yang penuh kreativitas, inovasi, dan semangat kolaborasi dalam dunia digital.</p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                            <a href="#projects" class="custom-btn bg-white text-[#6366f1] px-8 py-4 rounded-full font-semibold hover:bg-[#6366f1] hover:text-white transition-all duration-300 shadow-lg flex items-center">
                                <span>Lihat Projek</span>
                                <i class="bi bi-arrow-right ml-2"></i>
                            </a>
                            <a href="#contact" class="custom-btn border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-[#6366f1] transition-all duration-300 flex items-center">
                                <i class="bi bi-chat-dots mr-2"></i>
                                <span>Hubungi Kami</span>
                            </a>
                        </div>
                    </div>
                    <div class="lg:w-1/2 mt-12 lg:mt-0 hidden lg:block" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                        <img src="https://cdn-icons-png.flaticon.com/512/3976/3976626.png" class="floating mx-auto max-w-[80%] rounded-2xl" alt="Class Activity">
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-20 md:py-32 bg-white" id="about">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#6366f1] font-semibold text-sm uppercase tracking-wider">Tentang Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Mengenal Lebih Dekat XI RPL 2</h2>
                <div class="w-20 h-1.5 bg-[#6366f1] rounded-full mx-auto mt-4"></div>
            </div>
            @forelse ($abouts as $about)
                <div class="border-b border-gray-100 py-10" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right" data-aos-delay="200">
                            <div class="relative glow">
                                @if ($about->image_path)
                                    <img src="{{ Storage::url($about->image_path) }}" alt="{{ $about->title }}" class="rounded-2xl shadow-xl w-full object-cover h-[350px] md:h-[450px]">
                                @endif
                            </div>
                        </div>
                        <div class="md:w-1/2 text-center md:text-left" data-aos="fade-left" data-aos-delay="300">
                            <span class="text-[#6366f1] font-semibold text-sm uppercase tracking-wider">Profil Kelas</span>
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-2 mb-6">{{ $about->title }}</h3>
                            <p class="text-gray-600 mb-6 text-lg">{{ $about->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="border-b border-gray-100 py-10" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex flex-col md:flex-row items-center gap-16">
                        <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right" data-aos-delay="200">
                            <div class="relative glow">
                                <img src="https://via.placeholder.com/600x400" alt="Tentang Kami" class="rounded-2xl shadow-xl w-full object-cover h-[350px] md:h-[450px]">
                            </div>
                        </div>
                        <div class="md:w-1/2 text-center md:text-left" data-aos="fade-left" data-aos-delay="300">
                            <span class="text-[#6366f1] font-semibold text-sm uppercase tracking-wider">Profil Kelas</span>
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mt-2 mb-6">Kelas XI RPL 2</h3>
                            <p class="text-gray-600 mb-6 text-lg">Kami adalah kelompok siswa yang bersemangat dalam dunia teknologi, fokus pada pengembangan perangkat lunak dan inovasi digital.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-20 md:py-32 bg-gray-50" id="gallery">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#6366f1] font-semibold text-sm uppercase tracking-wider">Dokumentasi</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Galeri Kegiatan</h2>
                <div class="w-20 h-1.5 bg-[#6366f1] rounded-full mx-auto mt-4"></div>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Dokumentasi aktivitas dan prestasi kelas kami dalam berbagai kegiatan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse ($galleries as $gallery)
                    <div class="gallery-img h-96" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="relative h-full w-full overflow-hidden">
                            <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                            <div class="overlay absolute inset-0 flex flex-col items-center justify-center text-white opacity-0 hover:opacity-100 p-6 transition-opacity duration-300">
                                <h5 class="text-2xl font-bold mb-2">{{ $gallery->title }}</h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="gallery-img h-96" data-aos="zoom-in" data-aos-delay="100">
                        <div class="relative h-full w-full overflow-hidden">
                            <img src="https://via.placeholder.com/600x400" alt="Kegiatan 1" class="w-full h-full object-cover">
                            <div class="overlay absolute inset-0 flex flex-col items-center justify-center text-white opacity-0 hover:opacity-100 p-6 transition-opacity duration-300">
                                <h5 class="text-2xl font-bold mb-2">Kegiatan 1</h5>
                            </div>
                        </div>
                    </div>
                    <div class="gallery-img h-96" data-aos="zoom-in" data-aos-delay="200">
                        <div class="relative h-full w-full overflow-hidden">
                            <img src="https://via.placeholder.com/600x400" alt="Kegiatan 2" class="w-full h-full object-cover">
                            <div class="overlay absolute inset-0 flex flex-col items-center justify-center text-white opacity-0 hover:opacity-100 p-6 transition-opacity duration-300">
                                <h5 class="text-2xl font-bold mb-2">Kegiatan 2</h5>
                            </div>
                        </div>
                    </div>
                    <div class="gallery-img h-96" data-aos="zoom-in" data-aos-delay="300">
                        <div class="relative h-full w-full overflow-hidden">
                            <img src="https://via.placeholder.com/600x400" alt="Kegiatan 3" class="w-full h-full object-cover">
                            <div class="overlay absolute inset-0 flex flex-col items-center justify-center text-white opacity-0 hover:opacity-100 p-6 transition-opacity duration-300">
                                <h5 class="text-2xl font-bold mb-2">Kegiatan 3</h5>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="500">
                <a href="#" class="custom-btn bg-[#6366f1] text-white px-8 py-4 rounded-full font-semibold hover:bg-[#4f46e5] transition-all duration-300 inline-flex items-center">
                    <i class="bi bi-images mr-2"></i>
                    <span>Lihat Semua Foto</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section class="py-20 md:py-32 bg-white" id="projects">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#6366f1] font-semibold text-sm uppercase tracking-wider">Portfolio</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Projek</h2>
                <div class="w-20 h-1.5 bg-[#6366f1] rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($projects as $project)
                    @php
                        $descId = 'desc-' . $loop->iteration;
                    @endphp

                    <div class="card overflow-hidden hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="h-56 overflow-hidden">
                            <img src="{{ $project->image_path ? Storage::url($project->image_path) : 'https://via.placeholder.com/600x400' }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        </div>
                        <div class="p-6">
                            <h5 class="text-xl font-bold text-gray-800 mb-3">{{ $project->title }}</h5>

                            <p class="text-gray-600 mb-4">
                                {{ \Illuminate\Support\Str::limit($project->description, 100) }}
                                @if(strlen($project->description) > 100)
                                    <span id="{{ $descId }}-dots"></span>
                                    <span id="{{ $descId }}-more" class="hidden">{{ substr($project->description, 100) }}</span>
                                    <button onclick="toggleDesc('{{ $descId }}')" class="text-[#6366f1] hover:underline text-sm ml-1" id="{{ $descId }}-btn">Lihat Selengkapnya</button>
                                @endif
                            </p>

                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach (explode(',', $project->technologies) as $tech)
                                    <span class="bg-[#6366f1]/10 text-[#6366f1] px-3 py-1 rounded-full text-sm font-medium">{{ trim($tech) }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="p-6 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-gray-600 text-sm font-medium">{{ $project->team_name }}</span>
                            <a href="#" class="border border-[#6366f1] text-[#6366f1] px-4 py-2 rounded-full text-sm font-medium hover:bg-[#6366f1] hover:text-white transition-all duration-300">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="card overflow-hidden hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                        <div class="h-56 overflow-hidden">
                            <img src="https://via.placeholder.com/600x400" alt="Project 1" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        </div>
                        <div class="p-6">
                            <h5 class="text-xl font-bold text-gray-800 mb-3">Aplikasi Catatan</h5>
                            <p class="text-gray-600 mb-4">Aplikasi sederhana untuk mencatat tugas harian.</p>
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="bg-[#6366f1]/10 text-[#6366f1] px-3 py-1 rounded-full text-sm font-medium">HTML</span>
                                <span class="bg-[#6366f1]/10 text-[#6366f1] px-3 py-1 rounded-full text-sm font-medium">CSS</span>
                                <span class="bg-[#6366f1]/10 text-[#6366f1] px-3 py-1 rounded-full text-sm font-medium">JavaScript</span>
                            </div>
                        </div>
                        <div class="p-6 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-gray-600 text-sm font-medium">Tim Alpha</span>
                            <a href="#" class="border border-[#6366f1] text-[#6366f1] px-4 py-2 rounded-full text-sm font-medium hover:bg-[#6366f1] hover:text-white transition-all duration-300">Detail</a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="400">
                <a href="#" class="custom-btn bg-[#6366f1] text-white px-8 py-4 rounded-full font-semibold hover:bg-[#4f46e5] transition-all duration-300 inline-flex items-center">
                    <i class="bi bi-folder2-open mr-2"></i>
                    <span>Lihat Semua Projek</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Students Section -->
    <section class="py-20 md:py-32 bg-gray-50" id="students">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#6366f1] font-semibold text-sm uppercase tracking-wider">Tim Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Siswa Kami</h2>
                <div class="w-20 h-1.5 bg-[#6366f1] rounded-full mx-auto mt-4"></div>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Mengenal lebih dekat dengan siswa-siswa berPillars of our class</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($students as $student)
                    <div class="card p-6 text-center hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="relative mx-auto mb-8 glow">
                            <div class="w-32 h-32 rounded-full mx-auto overflow-hidden border-4 border-white shadow-lg hover:border-[#6366f1] transition-all duration-300">
                                <img src="{{ $student->image_path ? Storage::url($student->image_path) : 'https://via.placeholder.com/150' }}" alt="{{ $student->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            </div>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-1">{{ $student->name }}</h5>
                        <p class="text-[#6366f1] font-medium mb-3">{{ $student->role ?? 'Siswa' }}</p>
                        <div class="flex justify-center gap-3">
                            @if($student->github_url)
                                <a href="{{ $student->github_url }}" class="w-9 h-9 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-github"></i></a>
                            @endif
                            @if($student->linkedin_url)
                                <a href="{{ $student->linkedin_url }}" class="w-9 h-9 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-linkedin"></i></a>
                            @endif
                            @if($student->instagram_url)
                                <a href="{{ $student->instagram_url }}" class="w-9 h-9 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-instagram"></i></a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class ров-card p-6 text-center hover:-translate-y-2 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                        <div class="relative mx-auto mb-8 glow">
                            <div class="w-32 h-32 rounded-full mx-auto overflow-hidden border-4 border-white shadow-lg hover:border-[#6366f1] transition-all duration-300">
                                <img src="https://via.placeholder.com/150" alt="John Doe" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            </div>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-1">John Doe</h5>
                        <p class="text-[#6366f1] font-medium mb-3">Siswa</p>
                        <div class="flex justify-center gap-3">
                            <a href="#" class="w-9 h-9 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-github"></i></a>
                            <a href="#" class="w-9 h-9 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="w-9 h-9 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="500">
                <a href="#" class="custom-btn bg-[#6366f1] text-white px-8 py-4 rounded-full font-semibold hover:bg-[#4f46e5] transition-all duration-300 inline-flex items-center">
                    <i class="bi bi-people mr-2"></i>
                    <span>Lihat Semua Siswa</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 md:py-32 bg-white relative" id="contact">
        <div class="absolute top-0 left-0 w-full overflow-hidden" style="transform: translateY(-1px);">
            <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
                <path fill="#f9fafb" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,74.7C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,80C1248,75,1344,53,1392,42.7L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
            </svg>
        </div>
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-[#6366f1] font-semibold text-sm uppercase tracking-wider">Kontak</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2">Hubungi Kami</h2>
                <div class="w-20 h-1.5 bg-[#6366f1] rounded-full mx-auto mt-4"></div>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Punya pertanyaan atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <div class="lg:col-span-2">
                    <div class="card p-8" data-aos="fade-right" data-aos-delay="100">
                        <h3 class="text-2xl font-bold mb-6 text-gray-800">Informasi Kontak</h3>
                        <div class="flex items-start mb-8">
                            <div class="bg-[#6366f1]/10 rounded-full w-12 h-12 flex items-center justify-center text-[#6366f1] mr-6 shrink-0">
                                <i class="bi bi-geo-alt-fill text-xl"></i>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-800 mb-1">Alamat</h5>
                                <p class="text-gray-600">Jl. Pendidikan No. 123, Kota Teknologi<br>Kode Pos 12345</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-8">
                            <div class="bg-[#6366f1]/10 rounded-full w-12 h-12 flex items-center justify-center text-[#6366f1] mr-6 shrink-0">
                                <i class="bi bi-telephone-fill text-xl"></i>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-800 mb-1">Telepon</h5>
                                <p class="text-gray-600">(021) 1234-5678</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-8">
                            <div class="bg-[#6366f1]/10 rounded-full w-12 h-12 flex items-center justify-center text-[#6366f1] mr-6 shrink-0">
                                <i class="bi bi-envelope-fill text-xl"></i>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-800 mb-1">Email</h5>
                                <p class="text-gray-600">xii.rpl2@sekolah.edu</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 bg-[#6366f1]/10 text-[#6366f1] rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="w-10 h-10 bg-[#6366f1]/10 text-[#6366f1] rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="w-10 h-10 bg-[#6366f1]/10 text-[#6366f1] rounded-full flex items-center justify-center hover:bg-[#6366f1] hover:text-white transition-all duration-300"><i class="bi bi-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-3">
                    <div class="card p-8" data-aos="fade-left" data-aos-delay="200">
                        <h3 class="text-2xl font-bold mb-6 text-gray-800">Kirim Pesan</h3>
                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <input type="text" id="name" class="w-full pl-11 p-4 border border-gray-300 rounded-lg focus:ring-[#6366f1] focus:border-[#6366f1] bg-gray-50" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <input type="email" id="email" class="w-full pl-11 p-4 border border-gray-300 rounded-lg focus:ring-[#6366f1] focus:border-[#6366f1] bg-gray-50" placeholder="Masukkan email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                        <i class="bi bi-chat-left-text"></i>
                                    </div>
                                    <input type="text" id="subject" class="w-full pl-11 p-4 border border-gray-300 rounded-lg focus:ring-[#6366f1] focus:border-[#6366f1] bg-gray-50" placeholder="Masukkan subjek pesan" required>
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                                <div class="relative">
                                    <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none text-gray-400">
                                        <i class="bi bi-pencil"></i>
                                    </div>
                                    <textarea id="message" rows="5" class="w-full pl-11 p-4 border border-gray-300 rounded-lg focus:ring-[#6366f1] focus:border-[#6366f1] bg-gray-50" placeholder="Tulis pesan anda disini..." required></textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="bg-[#6366f1] text-white px-8 py-4 rounded-full font-semibold hover:bg-[#4f46e5] transition-all duration-300 flex items-center ml-auto">
                                    <span>Kirim Pesan</span>
                                    <i class="bi bi-send ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-20 mt-auto relative">
        <div class="absolute top-0 left-0 w-full overflow-hidden" style="transform: translateY(-1px);">
            <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,53.3C384,64,480,96,576,96C672,96,768,64,864,48C960,32,1056,32,1152,42.7C1248,53,1344,75,1392,85.3L1440,96L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
            </svg>
        </div>
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="lg:col-span-2">
                    <a href="/" class="text-2xl font-bold flex items-center mb-6">
                        <i class="bi bi-mortarboard-fill mr-2"></i>XI RPL 2
                    </a>
                    <p class="text-gray-300 mb-8 max-w-md">Website kelas XI RPL 2 sebagai media informasi dan portofolio karya siswa jurusan Rekayasa Perangkat Lunak.</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#6366f1] transition-all duration-300"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#6366f1] transition-all duration-300"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-[#6366f1] transition-all duration-300"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-6 text-[#6366f1]">Tautan Cepat</h5>
                    <div class="flex flex-col space-y-3">
                        <a href="#home" class="text-gray-300 hover:text-white transition-all duration-300 inline-flex items-center">
                            <i class="bi bi-chevron-right text-xs mr-2"></i> Home
                        </a>
                        <a href="#about" class="text-gray-300 hover:text-white transition-all duration-300 inline-flex items-center">
                            <i class="bi bi-chevron-right text-xs mr-2"></i> Tentang
                        </a>
                        <a href="#gallery" class="text-gray-300 hover:text-white transition-all duration-300 inline-flex items-center">
                            <i class="bi bi-chevron-right text-xs mr-2"></i> Galeri
                        </a>
                        <a href="#projects" class="text-gray-300 hover:text-white transition-all duration-300 inline-flex items-center">
                            <i class="bi bi-chevron-right text-xs mr-2"></i> Projek
                        </a>
                        <a href="#students" class="text-gray-300 hover:text-white transition-all duration-300 inline-flex items-center">
                            <i class="bi bi-chevron-right text-xs mr-2"></i> Siswa
                        </a>
                        <a href="#contact" class="text-gray-300 hover:text-white transition-all duration-300 inline-flex items-center">
                            <i class="bi bi-chevron-right text-xs mr-2"></i> Kontak
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 mt-16 pt-8 text-center">
                <p class="text-gray-400">© 2025 XI RPL 2 - All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-[#6366f1] text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-[#4f46e5] transition-all duration-300 opacity-0 invisible">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });

            // Preloader
            setTimeout(() => {
                document.querySelector('.loader').classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    document.querySelector('.loader').style.display = 'none';
                }, 500);
            }, 800);

            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            const navLinks = document.querySelectorAll('.nav-link');
            const backToTopBtn = document.getElementById('back-to-top');

            function handleScroll() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                    navLinks.forEach(link => {
                        link.classList.remove('md:text-white');
                        link.classList.add('text-gray-800');
                        link.classList.add('md:hover:text-[#6366f1]');
                    });
                } else {
                    navbar.classList.remove('scrolled');
                    navLinks.forEach(link => {
                        link.classList.add('md:text-white');
                        link.classList.remove('text-gray-800');
                        link.classList.remove('md:hover:text-[#6366f1]');
                    });
                }

                // Back to top button visibility
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('opacity-0', 'invisible');
                    backToTopBtn.classList.add('opacity-100', 'visible');
                } else {
                    backToTopBtn.classList.add('opacity-0', 'invisible');
                    backToTopBtn.classList.remove('opacity-100', 'visible');
                }

                // Progress bar
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                document.querySelector('.progress-bar').style.width = scrolled + '%';
            }

            window.addEventListener('scroll', handleScroll);
            handleScroll();

            // Back to top button
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                        document.getElementById('navbarNav').classList.remove('show');
                        document.querySelector('.navbar-backdrop').classList.remove('show');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            });

            // Form submission handling
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('Pesan Anda telah dikirim! (Ini adalah simulasi)');
                    form.reset();
                });
            }
        });

        // Mobile menu toggle
        function toggleMenu() {
            const navbar = document.getElementById('navbarNav');
            const backdrop = document.querySelector('.navbar-backdrop');
            navbar.classList.toggle('show');
            backdrop.classList.toggle('show');
            document.body.classList.toggle('overflow-hidden');
        }
        function toggleDesc(id) {
        const dots = document.getElementById(`${id}-dots`);
        const moreText = document.getElementById(`${id}-more`);
        const btnText = document.getElementById(`${id}-btn`);

        if (moreText.classList.contains("hidden")) {
            dots.style.display = "none";
            moreText.classList.remove("hidden");
            btnText.innerText = "Sembunyikan";
        } else {
            dots.style.display = "inline";
            moreText.classList.add("hidden");
            btnText.innerText = "Lihat Selengkapnya";
        }
    }
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
