<x-user-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">
                Detail Laporan
            </h2>
            <a href="{{ route('dashboard') }}" class="text-green-600 hover:text-green-700 flex items-center">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $report->title }}</h1>
                            <div class="flex items-center mt-2 space-x-4">
                                @if($report->type == 'pengaduan')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        Pengaduan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        Aspirasi
                                    </span>
                                @endif
                                <x-status-badge :status="$report->status" />
                            </div>
                        </div>
                        @if($report->status === 'pending')
                            <div class="flex space-x-2">
                                <a href="{{ route('reports.edit', $report) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Edit
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Description -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Deskripsi</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-700 whitespace-pre-line">{{ $report->content }}</p>
                                </div>
                            </div>

                            <!-- Image -->
                            @if($report->image)
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">Gambar Pendukung</h3>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <img src="{{ asset('storage/reports/' . $report->image) }}" 
                                             alt="Gambar Laporan" 
                                             class="max-w-full h-auto rounded-lg shadow-lg">
                                    </div>
                                </div>
                            @endif

                            <!-- Map -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Lokasi</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 mb-3">{{ $report->location_address }}</p>
                                    <div id="show-map" class="h-64 w-full rounded-lg"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">
                            <!-- Details -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Laporan</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Kejadian</dt>
                                        <dd class="text-sm text-gray-900">{{ $report->date_of_incident->format('d F Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                                        <dd class="text-sm text-gray-900">{{ $report->created_at->format('d F Y, H:i') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="text-sm text-gray-900">
                                            @if($report->status === 'pending')
                                                Menunggu Review
                                            @elseif($report->status === 'approved')
                                                Disetujui
                                            @else
                                                Ditolak
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Koordinat</dt>
                                        <dd class="text-xs text-gray-700">
                                            {{ number_format($report->latitude, 6) }}, {{ number_format($report->longitude, 6) }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
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
        var showMap = L.map('show-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 15);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(showMap);
        
        // Add marker at report location
        L.marker([{{ $report->latitude }}, {{ $report->longitude }}])
            .addTo(showMap)
            .bindPopup('{{ $report->location_address }}')
            .openPopup();
    </script>
</x-user-layout>