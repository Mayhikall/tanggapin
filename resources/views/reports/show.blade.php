<x-app-layout>
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
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-red-800">{{ session('error') }}</p>
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
                        @if($report->status === 'pending')
                            <div class="flex space-x-2">
                                <a href="{{ route('reports.edit', $report) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('reports.destroy', $report) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
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
                                        <img src="{{ asset('storage/' . $report->image) }}" 
                                             alt="Gambar Laporan" 
                                             class="max-w-full h-auto rounded-lg shadow-lg">
                                    </div>
                                </div>
                            @endif

                            <!-- Video -->
                            @if($report->video)
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">Video Pendukung</h3>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        @php
                                            $videoPath = $report->video;
                                            $videoUrl = asset('storage/' . implode('/', array_map('rawurlencode', explode('/', $videoPath))));
                                        @endphp
                                        <video controls class="w-full rounded-lg shadow-lg">
                                            <source src="{{ $videoUrl }}" type="video/mp4">
                                            Browser Anda tidak mendukung video tag.
                                        </video>
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

                            <!-- Feedback Section (only for approved reports owned by current user) -->
                            @if($report->status === 'approved')
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border border-green-200">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                                        <svg class="w-5 h-5 inline mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                        Umpan Balik
                                    </h3>

                                    @if($report->hasFeedback())
                                        <!-- Show existing feedback -->
                                        <div class="bg-white rounded-lg p-4">
                                            <div class="flex items-center mb-2">
                                                <span class="text-sm font-medium text-gray-700 mr-2">Rating Anda:</span>
                                                <div class="flex">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-5 h-5 {{ $i <= $report->feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            @if($report->feedback->comment)
                                                <p class="text-gray-600 text-sm">{{ $report->feedback->comment }}</p>
                                            @endif
                                            <p class="text-xs text-gray-400 mt-2">Dikirim {{ $report->feedback->created_at->diffForHumans() }}</p>
                                        </div>
                                    @else
                                        <!-- Feedback form -->
                                        <form action="{{ route('feedback.store', $report) }}" method="POST">
                                            @csrf
                                            <p class="text-sm text-gray-600 mb-4">Laporan Anda telah disetujui. Berikan rating dan komentar Anda tentang penanganan aduan ini.</p>
                                            
                                            <!-- Star Rating -->
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                                                <div class="flex items-center space-x-1" x-data="{ rating: 0, hover: 0 }">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <button type="button" 
                                                                @click="rating = {{ $i }}"
                                                                @mouseenter="hover = {{ $i }}"
                                                                @mouseleave="hover = 0"
                                                                class="focus:outline-none">
                                                            <svg class="w-8 h-8 transition-colors duration-150" 
                                                                 :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-gray-300'"
                                                                 fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        </button>
                                                    @endfor
                                                    <input type="hidden" name="rating" x-model="rating" required>
                                                </div>
                                                @error('rating')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Comment -->
                                            <div class="mb-4">
                                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Komentar (Opsional)</label>
                                                <textarea name="comment" 
                                                          id="comment" 
                                                          rows="3" 
                                                          placeholder="Berikan komentar Anda tentang penanganan aduan..."
                                                          class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('comment') }}</textarea>
                                                @error('comment')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button type="submit" 
                                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Kirim Feedback
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
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
</x-app-layout>