<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TangGapin') }} - User Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Additional Styles -->
        <style>
            .user-card {
                @apply bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-green-50 to-emerald-50">
        <div class="min-h-screen">
            <!-- Minimalist Green Navbar -->
            <nav class="bg-green-600 shadow-lg sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo & Brand -->
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-white">TangGapin</span>
                            </a>
                        </div>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden md:flex items-center space-x-6">
                            <a href="{{ route('dashboard') }}" 
                               class="text-green-100 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-green-700 text-white' : '' }}">
                                <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v2H8V5z"/>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('reports.create') }}" 
                               class="text-green-100 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->routeIs('reports.create') ? 'bg-green-700 text-white' : '' }}">
                                <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Buat Laporan
                            </a>
                        </div>

                        <!-- User Menu -->
                        <div class="hidden md:flex items-center space-x-4">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" 
                                        class="flex items-center space-x-2 text-green-100 hover:text-white px-3 py-2 rounded-lg transition-colors duration-200">
                                    <div class="w-8 h-8 bg-green-700 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="font-medium">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg py-2 z-50">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" 
                                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profile Settings
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden">
                            <button type="button" 
                                    x-data="{ mobileOpen: false }" 
                                    @click="mobileOpen = !mobileOpen"
                                    class="text-green-100 hover:text-white p-2 rounded-lg transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Navigation Menu -->
                    <div x-data="{ mobileOpen: false }" x-show="mobileOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="md:hidden bg-green-700 border-t border-green-800">
                        <div class="px-2 pt-2 pb-3 space-y-1">
                            <a href="{{ route('dashboard') }}" 
                               class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-800 transition-colors duration-200">
                                Dashboard
                            </a>
                            <a href="{{ route('reports.create') }}" 
                               class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-800 transition-colors duration-200">
                                Buat Laporan
                            </a>
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-800 transition-colors duration-200">
                                Profile Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-red-600 transition-colors duration-200">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-green-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-6 sm:py-8">
                {{ $slot }}
            </main>
        </div>

        <!-- Alpine.js for interactivity -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>