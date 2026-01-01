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
                            <a href="#home" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Beranda</a>
                            <a href="#features" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Fitur</a>
                            <a href="#about" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Tentang</a>
                            <a href="#contact" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Kontak</a>
                            <a href="{{ route('map.index') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Peta Aduan</a>
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
                        <a href="#home" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
                        <a href="#features" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Fitur</a>
                        <a href="#about" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Tentang</a>
                        <a href="#contact" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Kontak</a>
                        <a href="{{ route('map.index') }}" class="text-gray-700 hover:text-green-600 block px-3 py-2 rounded-md text-base font-medium">Peta Aduan</a>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        <span class="text-green-600">Tanggapin</span> - Suara Anda, Kami Dengar
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-600 mb-4 max-w-3xl mx-auto font-semibold">
                        Aplikasi Sistem Aduan Masyarakat
                    </p>
                    
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                        Platform digital untuk menyampaikan pengaduan dan aspirasi kepada pemerintah dengan mudah, cepat, dan transparan
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @guest
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-8 rounded-lg transition duration-200 text-center shadow-lg">
                                Sampaikan Aduan Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-medium py-3 px-8 rounded-lg transition duration-200 text-center">
                                Masuk ke Akun
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
                    <p class="text-lg text-gray-600">Kemudahan dan transparansi dalam setiap langkah</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Mudah Digunakan</h3>
                        <p class="text-gray-600">Proses pengaduan yang simple dan cepat. Cukup isi form, upload foto, dan kirim!</p>
                    </div>

                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Aman & Terpercaya</h3>
                        <p class="text-gray-600">Data Anda aman dengan sistem enkripsi. Identitas terlindungi dengan baik</p>
                    </div>

                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Transparan & Terlacak</h3>
                        <p class="text-gray-600">Pantau status pengaduan Anda secara real-time dari pending hingga selesai</p>
                    </div>

                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Lokasi Akurat</h3>
                        <p class="text-gray-600">Tandai lokasi kejadian dengan peta interaktif untuk laporan yang lebih detail</p>
                    </div>

                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Upload Bukti Foto</h3>
                        <p class="text-gray-600">Lampirkan foto sebagai bukti pendukung untuk memperkuat laporan Anda</p>
                    </div>

                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mx-auto mb-4">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Respon Cepat</h3>
                        <p class="text-gray-600">Tim admin akan segera menindaklanjuti setiap aduan yang masuk dengan profesional</p>
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
                        <p class="text-lg text-gray-600 mb-4">
                            <strong>Tanggapin</strong> adalah platform digital yang memudahkan masyarakat untuk menyampaikan pengaduan dan aspirasi kepada pemerintah daerah.
                        </p>
                        <p class="text-lg text-gray-600 mb-6">
                            Kami percaya bahwa setiap suara masyarakat penting dan berhak untuk didengar. Melalui sistem yang transparan dan akuntabel, kami menjembatani komunikasi antara masyarakat dan pemerintah untuk menciptakan lingkungan yang lebih baik.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-medium text-gray-900">Proses Pengaduan yang Mudah</p>
                                    <p class="text-sm text-gray-600">Cukup beberapa klik untuk menyampaikan keluhan Anda</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-medium text-gray-900">Tracking Status Real-time</p>
                                    <p class="text-sm text-gray-600">Pantau perkembangan laporan Anda kapan saja</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-600">
                                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-medium text-gray-900">Akuntabilitas Pemerintah</p>
                                    <p class="text-sm text-gray-600">Mendorong tata kelola yang lebih baik dan transparan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 lg:mt-0">
                        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl p-8 text-white shadow-2xl">
                            <h3 class="text-2xl font-bold mb-6">Statistik Platform</h3>
                            <div class="space-y-6">
                                <div class="flex justify-between items-center border-b border-green-400 pb-4">
                                    <div>
                                        <p class="text-green-100 text-sm">Total Laporan</p>
                                        <p class="text-3xl font-bold">2,450+</p>
                                    </div>
                                    <svg class="h-12 w-12 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="flex justify-between items-center border-b border-green-400 pb-4">
                                    <div>
                                        <p class="text-green-100 text-sm">Pengguna Aktif</p>
                                        <p class="text-3xl font-bold">1,200+</p>
                                    </div>
                                    <svg class="h-12 w-12 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-green-100 text-sm">Tingkat Penyelesaian</p>
                                        <p class="text-3xl font-bold">85%</p>
                                    </div>
                                    <svg class="h-12 w-12 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
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
                        <p class="text-gray-600">Gresik, Jawa Timur, Indonesia</p>
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
                        <p class="text-gray-400 mt-2">Sistem Aduan Masyarakat Digital</p>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-400">&copy; {{ date('Y') }} Tanggapin - Aplikasi Sistem Aduan Masyarakat. All rights reserved.</p>
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