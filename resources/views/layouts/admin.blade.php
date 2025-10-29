<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TangGapin') }} - Admin Dashboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Additional Styles -->
        <style>
            .admin-sidebar {
                @apply bg-gradient-to-b from-green-700 to-green-800 shadow-2xl;
            }
            .admin-content {
                @apply bg-gray-50 min-h-screen;
            }
            .admin-table {
                @apply bg-white rounded-xl shadow-lg overflow-hidden;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen overflow-hidden">
            <!-- Modern Green Sidebar -->
            <div class="admin-sidebar w-64 flex-shrink-0 flex flex-col transition-all duration-300 ease-in-out lg:w-64 md:w-20">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-center px-4 py-6 border-b border-green-600">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-green-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="hidden lg:block">
                            <h2 class="text-xl font-bold text-white">TangGapin</h2>
                            <p class="text-xs text-green-200">Admin Panel</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white shadow-lg' : 'text-green-100 hover:bg-green-600 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-green-300 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v2H8V5z"/>
                        </svg>
                        <span class="ml-3 hidden lg:block">Dashboard</span>
                        @if(request()->routeIs('admin.dashboard'))
                            <div class="ml-auto w-2 h-2 bg-green-200 rounded-full"></div>
                        @endif
                    </a>

                    <!-- Reports Management -->
                    <div class="space-y-1">
                        <div class="flex items-center px-4 py-2">
                            <span class="text-xs font-semibold text-green-300 uppercase tracking-wider hidden lg:block">Reports</span>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-green-100 hover:bg-green-600 hover:text-white">
                            <svg class="w-5 h-5 text-green-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="ml-3 hidden lg:block">All Reports</span>
                        </a>
                        <a href="{{ route('admin.dashboard', ['status' => 'pending']) }}" 
                           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-green-100 hover:bg-green-600 hover:text-white">
                            <svg class="w-5 h-5 text-green-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="ml-3 hidden lg:block">Pending Review</span>
                            <span class="ml-auto bg-yellow-500 text-yellow-900 text-xs px-2 py-1 rounded-full font-medium hidden lg:block">
                                {{ \App\Models\Report::where('status', 'pending')->count() }}
                            </span>
                        </a>
                    </div>

                    <!-- Users Management -->
                    <div class="space-y-1">
                        <div class="flex items-center px-4 py-2">
                            <span class="text-xs font-semibold text-green-300 uppercase tracking-wider hidden lg:block">Users</span>
                        </div>
                        <a href="#" 
                           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-green-100 hover:bg-green-600 hover:text-white">
                            <svg class="w-5 h-5 text-green-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <span class="ml-3 hidden lg:block">All Users</span>
                        </a>
                    </div>

                    <!-- System -->
                    <div class="space-y-1">
                        <div class="flex items-center px-4 py-2">
                            <span class="text-xs font-semibold text-green-300 uppercase tracking-wider hidden lg:block">System</span>
                        </div>
                        <a href="#" 
                           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-green-100 hover:bg-green-600 hover:text-white">
                            <svg class="w-5 h-5 text-green-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="ml-3 hidden lg:block">Settings</span>
                        </a>
                    </div>
                </nav>

                <!-- Admin Profile Section -->
                <div class="px-4 py-4 border-t border-green-600">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                                class="group w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-green-100 hover:bg-green-600 hover:text-white">
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center ring-2 ring-green-500">
                                <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-3 text-left hidden lg:block">
                                <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-green-300">Administrator</p>
                            </div>
                            <svg class="ml-auto w-4 h-4 transition-transform duration-200 hidden lg:block" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Admin Dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute bottom-full left-4 right-4 mb-2 bg-white rounded-xl shadow-xl py-2 z-50">
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
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header Bar -->
                <header class="bg-white shadow-sm border-b border-gray-200 z-10">
                    <div class="flex items-center justify-between px-6 py-4">
                        <!-- Page Title -->
                        <div class="flex items-center space-x-4">
                            <button class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            @isset($header)
                                {{ $header }}
                            @else
                                <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                            @endisset
                        </div>

                        <!-- Header Actions -->
                        <div class="flex items-center space-x-3">
                            <!-- Notifications -->
                            <button class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors duration-200 relative">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h11a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                @if(\App\Models\Report::where('status', 'pending')->count() > 0)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                        {{ \App\Models\Report::where('status', 'pending')->count() }}
                                    </span>
                                @endif
                            </button>

                            <!-- Quick Actions -->
                            <a href="{{ route('dashboard') }}" 
                               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-sm font-medium">
                                View Site
                            </a>
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="admin-content flex-1 overflow-y-auto">
                    <div class="p-6">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-data="{ sidebarOpen: false }" 
             x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-50 lg:hidden">
        </div>

        <!-- Alpine.js for interactivity -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>