<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tanggapin') }} - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        .admin-sidebar {
            @apply bg-white;
        }

        .admin-content {
            @apply bg-white min-h-screen;
        }

        .admin-table {
            @apply bg-white rounded-xl shadow-lg overflow-hidden;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Overlay untuk mobile/tablet -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-white bg-opacity-70 backdrop-blur-sm z-40 lg:hidden" style="display: none;">
        </div>

        <!-- Modern White Sidebar -->
        <div class="admin-sidebar fixed lg:static inset-y-0 left-0 w-full sm:w-80 md:w-80 flex-shrink-0 flex flex-col transition-transform duration-300 ease-in-out z-50 lg:translate-x-0 lg:w-64 shadow-2xl lg:shadow-none"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between px-4 py-4 lg:py-6">
                <div class="flex items-center space-x-2 lg:space-x-3">
                    <div
                        class="w-8 h-8 lg:w-10 lg:h-10 bg-green-600 rounded-lg lg:rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base lg:text-xl font-bold text-gray-900">Tanggapin</h2>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>
                <!-- Close button untuk mobile -->
                <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-3 lg:px-4 py-4 lg:py-6 space-y-1 lg:space-y-2">
                <!-- Reports Management -->
                <div class="space-y-1">
                    <div class="flex items-center px-3 lg:px-4 py-1.5 lg:py-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Reports</span>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false"
                        class="group flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-xs lg:text-sm font-medium rounded-lg lg:rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') && (!request('tab') || request('tab') === '') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 {{ request()->routeIs('admin.dashboard') && (!request('tab') || request('tab') === '') ? 'text-white' : 'text-gray-500 group-hover:text-green-600' }}" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="ml-2 lg:ml-3">All Reports</span>
                    </a>
                    <a href="{{ route('admin.dashboard', ['tab' => 'pending-review']) }}" @click="sidebarOpen = false"
                        class="group flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-xs lg:text-sm font-medium rounded-lg lg:rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') && request('tab') === 'pending-review' ? 'bg-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 {{ request()->routeIs('admin.dashboard') && request('tab') === 'pending-review' ? 'text-white' : 'text-gray-500 group-hover:text-green-600' }}" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="ml-2 lg:ml-3">Pending Review</span>
                        <span
                            class="ml-auto bg-yellow-400 text-gray-900 text-xs px-1.5 lg:px-2.5 py-0.5 lg:py-1 rounded-full font-bold shadow-lg">
                            {{ \App\Models\Report::where('status', 'pending')->count() }}
                        </span>
                    </a>
                </div>

                <!-- Users Management -->
                <div class="space-y-1">
                    <div class="flex items-center px-3 lg:px-4 py-1.5 lg:py-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</span>
                    </div>
                    <a href="{{ route('admin.dashboard.user') }}" @click="sidebarOpen = false"
                        class="group flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-xs lg:text-sm font-medium rounded-lg lg:rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard.user') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 {{ request()->routeIs('admin.dashboard.user') ? 'text-white' : 'text-gray-500 group-hover:text-green-600' }}" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        <span class="ml-2 lg:ml-3">All Users</span>
                        <span class="ml-auto {{ request()->routeIs('admin.dashboard.user') ? 'bg-white text-green-600' : 'bg-gray-200 text-gray-600' }} text-xs px-2 py-0.5 rounded-full font-bold">
                            {{ \App\Models\User::count() }}
                        </span>
                    </a>
                </div>

                <!-- Feedback Management -->
                <div class="space-y-1">
                    <div class="flex items-center px-3 lg:px-4 py-1.5 lg:py-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Feedback</span>
                    </div>
                    <a href="{{ route('admin.feedbacks.index') }}" @click="sidebarOpen = false"
                        class="group flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-xs lg:text-sm font-medium rounded-lg lg:rounded-xl transition-all duration-200 {{ request()->routeIs('admin.feedbacks.*') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 {{ request()->routeIs('admin.feedbacks.*') ? 'text-white' : 'text-gray-500 group-hover:text-green-600' }}" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <span class="ml-2 lg:ml-3">User Feedback</span>
                        <span class="ml-auto {{ request()->routeIs('admin.feedbacks.*') ? 'bg-white text-green-600' : 'bg-yellow-100 text-yellow-700' }} text-xs px-2 py-0.5 rounded-full font-bold">
                            {{ \App\Models\Feedback::count() }}
                        </span>
                    </a>
                </div>

                <!-- Peta Aduan -->
                <div class="space-y-1">
                    <div class="flex items-center px-3 lg:px-4 py-1.5 lg:py-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Peta</span>
                    </div>
                    <a href="{{ route('admin.map') }}" @click="sidebarOpen = false"
                        class="group flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-xs lg:text-sm font-medium rounded-lg lg:rounded-xl transition-all duration-200 {{ request()->routeIs('admin.map') ? 'bg-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 {{ request()->routeIs('admin.map') ? 'text-white' : 'text-gray-500 group-hover:text-green-600' }}" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="ml-2 lg:ml-3">Peta Aduan</span>
                    </a>
                </div>

               
            </nav>

            <!-- Admin Profile Section -->
            <div class="px-3 lg:px-4 py-3 lg:py-4">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="group w-full flex items-center px-3 lg:px-4 py-2.5 lg:py-3 text-xs lg:text-sm font-medium rounded-lg lg:rounded-xl transition-all duration-200 text-gray-700 hover:bg-green-50 hover:text-green-600">
                        <div
                            class="w-7 h-7 lg:w-8 lg:h-8 bg-green-600 rounded-full flex items-center justify-center ring-2 ring-green-400 shadow-lg flex-shrink-0">
                            <span
                                class="text-xs lg:text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-2 lg:ml-3 text-left flex-1 min-w-0">
                            <p class="text-xs lg:text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <svg class="ml-2 w-3 h-3 lg:w-4 lg:h-4 transition-transform duration-200 text-gray-500 group-hover:text-green-600 flex-shrink-0"
                            :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Admin Dropdown -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute bottom-full left-4 right-4 mb-2 bg-white rounded-xl shadow-xl py-2 z-50">
                        <a href="{{ route('admin.profile.edit') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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
            <header class="bg-white z-10">
                <div class="flex items-center justify-between px-4 lg:px-6 py-4">
                    <!-- Hamburger Menu -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors duration-200 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                    <!-- Page Title / Header Content -->
                    <div class="flex-1 flex items-center justify-between ml-4 lg:ml-0">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                        @endisset
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="admin-content flex-1 overflow-y-auto">
                <div class="p-4 lg:p-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
