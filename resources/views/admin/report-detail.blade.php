<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900">
                Detail Laporan
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center transition-colors duration-200">
                Kembali
                <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $report->title }}</h1>
                        <div class="flex items-center mt-3 space-x-3">
                            @if($report->type == 'pengaduan')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Pengaduan
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Aspirasi
                                </span>
                            @endif
                            <x-status-badge :status="$report->status" />
                        </div>
                    </div>
                    
                    <!-- Admin Actions -->
                    @if($report->status === 'pending')
                        <div class="flex space-x-3">
                            <form action="{{ route('admin.approve', $report) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold inline-flex items-center shadow-md transition-colors duration-200"
                                        onclick="return confirm('Yakin ingin menyetujui laporan ini?')">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Approve
                                </button>
                            </form>

                            <form action="{{ route('admin.reject', $report) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold inline-flex items-center shadow-md transition-colors duration-200"
                                        onclick="return confirm('Yakin ingin menolak laporan ini?')">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reject
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Main Content - Left Side -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Description -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Deskripsi</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $report->content }}</p>
                    </div>
                </div>

                <!-- Image -->
                @if($report->image)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Gambar Pendukung</h3>
                        </div>
                        <div class="p-6">
                            <img src="{{ asset('storage/' . $report->image) }}" 
                                 alt="Gambar Laporan" 
                                 class="w-full max-w-2xl h-auto rounded-lg shadow-lg">
                        </div>
                    </div>
                @endif

                <!-- Video -->
                @if($report->video)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Video Pendukung</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $videoPath = $report->video;
                                $videoUrl = asset('storage/' . implode('/', array_map('rawurlencode', explode('/', $videoPath))));
                            @endphp
                            <video controls class="w-full max-w-2xl rounded-lg shadow-lg">
                                <source src="{{ $videoUrl }}" type="video/mp4">
                                Browser Anda tidak mendukung video tag.
                            </video>
                        </div>
                    </div>
                @endif

                <!-- Map -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Lokasi</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">{{ $report->location_address }}</p>
                        <div id="admin-map" class="h-72 w-full rounded-lg border border-gray-200"></div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Right Side -->
            <div class="space-y-6">
                <!-- User Information -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Informasi Pelapor</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                <dd class="text-base font-semibold text-gray-900 mt-1">{{ $report->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $report->user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Role</dt>
                                <dd class="mt-1">
                                    @if($report->user->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Administrator
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            User
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Report Details -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Detail Laporan</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Kejadian</dt>
                                <dd class="text-sm font-semibold text-gray-900 mt-1">{{ $report->date_of_incident->format('d F Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $report->created_at->format('d F Y, H:i') }}</dd>
                            </div>
                            @if($report->updated_at->ne($report->created_at))
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $report->updated_at->format('d F Y, H:i') }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($report->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Menunggu Review
                                        </span>
                                    @elseif($report->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Koordinat</dt>
                                <dd class="text-xs font-mono text-gray-700 mt-1 bg-gray-100 px-2 py-1 rounded">
                                    {{ number_format($report->latitude, 6) }}, {{ number_format($report->longitude, 6) }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet Map for showing location -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize map for showing location (read-only)
        var adminMap = L.map('admin-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 15);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(adminMap);
        
        // Add marker at report location
        L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
            .addTo(adminMap)
            .bindPopup('{{ $report->location_address }}')
            .openPopup();
    </script>
</x-admin-layout>