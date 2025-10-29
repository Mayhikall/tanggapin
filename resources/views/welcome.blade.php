<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Tanggapin') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-green-600">Tanggapin</h1>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="#home" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Home</a>
                            <a href="#features" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Features</a>
                            <a href="#about" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">About</a>
                            <a href="#contact" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Contact</a>
                        </div>
                    </div>

                    <!-- Auth Links -->
                    @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">Admin Dashboard</a>
                                @else
                                    <a href="{{ url('/dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">Dashboard</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500" onclick="toggleMobileMenu()">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="md:hidden hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t">
                        <a href="#home" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Home</a>
                        <a href="#features" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Features</a>
                        <a href="#about" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">About</a>
                        <a href="#contact" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Contact</a>
                        @guest
                            <div class="border-t pt-3 mt-3">
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white block px-3 py-2 rounded-md text-base font-medium mt-2">Register</a>
                                @endif
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="bg-gradient-to-r from-green-50 to-green-100 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-8">
                        <div class="flex items-center justify-center h-24 w-24 rounded-full bg-green-600 shadow-lg">
                            <svg class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        Selamat Datang di <span class="text-green-600">Tanggapin</span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                        Aplikasi Sistem Aduan Masyarakat
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @guest
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center">
                                Mulai Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="border border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center">
                                Masuk
                            </a>
                        @else
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center">
                                    Ke Admin Dashboard
                                </a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 text-center">
                                    Ke Dashboard
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                    <p class="text-lg text-gray-600">Solusi lengkap untuk kebutuhan manajemen Anda</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Keamanan Terjamin</h3>
                        <p class="text-gray-600">Sistem user role yang aman dengan autentikasi berlapis</p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Interface Modern</h3>
                        <p class="text-gray-600">Desain hijau modern yang clean dan user-friendly</p>
                    </div>

                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Performa Cepat</h3>
                        <p class="text-gray-600">Optimasi kecepatan untuk pengalaman yang lancar</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Tentang Tanggapin</h2>
                        <p class="text-lg text-gray-600 mb-6">
                            Tanggapin adalah platform manajemen yang dirancang khusus untuk memberikan pengalaman terbaik dalam mengelola data dan informasi Anda. Dengan tema hijau yang menyegarkan dan antarmuka yang intuitif.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-600">
                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-700">Sistem role user yang fleksibel</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-600">
                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-700">Dashboard yang informatif dan mudah digunakan</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-600">
                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-700">Keamanan data terdepan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 lg:mt-0">
                        <div class="bg-green-600 rounded-lg p-8 text-white">
                            <h3 class="text-xl font-bold mb-4">Statistik Platform</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span>User Aktif</span>
                                    <span class="font-bold">1,000+</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Uptime</span>
                                    <span class="font-bold">99.9%</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Rating</span>
                                    <span class="font-bold">4.8/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
                    <p class="text-lg text-gray-600">Ada pertanyaan? Tim kami siap membantu Anda</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Email</h3>
                        <p class="text-gray-600">info@tanggapin.com</p>
                    </div>

                    <div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Telepon</h3>
                        <p class="text-gray-600">+62 123 456 789</p>
                    </div>

                    <div>
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Lokasi</h3>
                        <p class="text-gray-600">Jakarta, Indonesia</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-2xl font-bold text-green-400">Tanggapin</h3>
                        <p class="text-gray-400 mt-2">Sistem manajemen modern dengan tema hijau</p>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-green-400 transition duration-200">Privacy</a>
                        <a href="#" class="text-gray-400 hover:text-green-400 transition duration-200">Terms</a>
                        <a href="#contact" class="text-gray-400 hover:text-green-400 transition duration-200">Contact</a>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-400">&copy; {{ date('Y') }} Tanggapin. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- JavaScript for Mobile Menu -->
        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }

            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        </script>
    </body>
</html>