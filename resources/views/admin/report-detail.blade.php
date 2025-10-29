<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">
                Detail Laporan - Admin View
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="text-green-600 hover:text-green-700 flex items-center">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard Admin
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
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
                        
                        <!-- Admin Actions -->
                        @if($report->status === 'pending')
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.approve', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center"
                                            onclick="return confirm('Yakin ingin menyetujui laporan ini?')">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.reject', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center"
                                            onclick="return confirm('Yakin ingin menolak laporan ini?')">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Reject
                                    </button>
                                </form>
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
                                    <div id="admin-map" class="h-64 w-full rounded-lg"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">
                            <!-- User Information -->
                            <div class="bg-blue-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pelapor</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                        <dd class="text-sm text-gray-900">{{ $report->user->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="text-sm text-gray-900">{{ $report->user->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                                        <dd class="text-sm text-gray-900">{{ ucfirst($report->user->role) }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Report Details -->
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
                                    @if($report->updated_at->ne($report->created_at))
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                                            <dd class="text-sm text-gray-900">{{ $report->updated_at->format('d F Y, H:i') }}</dd>
                                        </div>
                                    @endif
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="text-sm text-gray-900">
                                            @if($report->status === 'pending')
                                                <span class="text-yellow-600">Menunggu Review</span>
                                            @elseif($report->status === 'approved')
                                                <span class="text-green-600">Disetujui</span>
                                            @else
                                                <span class="text-red-600">Ditolak</span>
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