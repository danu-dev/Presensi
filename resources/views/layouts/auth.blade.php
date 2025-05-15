<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel Auth') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Ensure the image fills the height for smaller screens */
        @media (max-width: 768px) {
            .auth-image {
                height: 200px;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div id="app">
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="/" class="text-xl font-bold text-indigo-600">
                                {{ config('app.name', 'Laravel Auth') }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center">
                        @guest
                            <a href="/login" class="text-gray-500 hover:text-gray-700 mx-3 font-medium">Login</a>
                            <a href="/register" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">Register</a>
                        @else
                            <div class="relative">
                                <div class="flex items-center">
                                    <span class="mr-2 text-gray-700">{{ Auth::user()->name }}</span>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
