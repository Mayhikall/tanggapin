<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">
                Edit Laporan
            </h2>
            <a href="{{ route('reports.show', $report) }}" class="text-green-600 hover:text-green-700 flex items-center">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Detail
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <!-- Alert if report is not editable -->
                    @if($report->status !== 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        Perhatian
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Laporan yang sudah disetujui atau ditolak tidak dapat diedit.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('reports.update', $report) }}" method="POST" enctype="multipart/form-data" id="edit-report-form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Title and Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Judul Laporan *
                                </label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       required 
                                       value="{{ old('title', $report->title) }}"
                                       {{ $report->status !== 'pending' ? 'readonly' : '' }}
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 {{ $report->status !== 'pending' ? 'bg-gray-100' : '' }}">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Laporan *
                                </label>
                                <select name="type" 
                                        id="type" 
                                        required 
                                        {{ $report->status !== 'pending' ? 'disabled' : '' }}
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 {{ $report->status !== 'pending' ? 'bg-gray-100' : '' }}">
                                    <option value="">Pilih jenis laporan</option>
                                    <option value="pengaduan" {{ old('type', $report->type) == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                                    <option value="aspirasi" {{ old('type', $report->type) == 'aspirasi' ? 'selected' : '' }}>Aspirasi</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Date of Incident -->
                        <div class="mb-6">
                            <label for="date_of_incident" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Kejadian *
                            </label>
                            <input type="date" 
                                   name="date_of_incident" 
                                   id="date_of_incident" 
                                   required 
                                   value="{{ old('date_of_incident', $report->date_of_incident->format('Y-m-d')) }}"
                                   {{ $report->status !== 'pending' ? 'readonly' : '' }}
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 {{ $report->status !== 'pending' ? 'bg-gray-100' : '' }}">
                            @error('date_of_incident')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Laporan *
                            </label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="4" 
                                      required 
                                      {{ $report->status !== 'pending' ? 'readonly' : '' }}
                                      placeholder="Jelaskan secara detail mengenai laporan Anda..."
                                      class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 {{ $report->status !== 'pending' ? 'bg-gray-100' : '' }}">{{ old('content', $report->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Lokasi Kejadian *
                            </label>
                            <div class="space-y-4">
                                <div>
                                    <input type="text" 
                                           name="location_address" 
                                           id="edit-location-address" 
                                           required 
                                           value="{{ old('location_address', $report->location_address) }}"
                                           {{ $report->status !== 'pending' ? 'readonly' : '' }}
                                           placeholder="Alamat lengkap lokasi kejadian..."
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 {{ $report->status !== 'pending' ? 'bg-gray-100' : '' }}">
                                    @error('location_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                @if($report->status === 'pending')
                                    <div>
                                        <p class="text-sm text-gray-600 mb-2">Klik pada peta untuk memilih lokasi:</p>
                                        <div id="edit-map" class="h-64 w-full rounded-lg border border-gray-300"></div>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-sm text-gray-600 mb-2">Lokasi laporan:</p>
                                        <div id="edit-map" class="h-64 w-full rounded-lg border border-gray-300"></div>
                                    </div>
                                @endif
                                
                                <input type="hidden" name="latitude" id="edit-latitude" value="{{ old('latitude', $report->latitude) }}">
                                <input type="hidden" name="longitude" id="edit-longitude" value="{{ old('longitude', $report->longitude) }}">
                                
                                @error('latitude')
                                    <p class="mt-1 text-sm text-red-600">Lokasi harus dipilih pada peta</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Pendukung
                            </label>
                            
                            @if($report->image)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $report->image) }}" 
                                         alt="Gambar Laporan" 
                                         class="w-32 h-32 object-cover rounded-lg border">
                                </div>
                            @endif
                            
                            @if($report->status === 'pending')
                                <input type="file" 
                                       name="image" 
                                       id="image" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $report->image ? 'Pilih file baru untuk mengganti gambar existing' : 'Pilih file gambar (JPG, PNG, maksimal 2MB)' }}
                                </p>
                            @else
                                <p class="text-sm text-gray-500 italic">Gambar tidak dapat diubah karena laporan sudah diproses</p>
                            @endif
                            
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        @if($report->status === 'pending')
                            <div class="flex items-center justify-between">
                                <div>
                                    <form action="{{ route('reports.destroy', $report) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center">
                                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus Laporan
                                        </button>
                                    </form>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('reports.show', $report) }}" 
                                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded-lg">
                                        Batal
                                    </a>
                                    <button type="submit" 
                                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                                        Update Laporan
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize map
        var editMap = L.map('edit-map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 15);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(editMap);
        
        // Add existing marker
        var editMarker = L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(editMap);
        
        @if($report->status === 'pending')
            // Allow editing if status is pending
            editMap.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                
                // Update marker position
                editMarker.setLatLng([lat, lng]);
                
                // Update form fields
                document.getElementById('edit-latitude').value = lat;
                document.getElementById('edit-longitude').value = lng;
                
                // Reverse geocoding (optional)
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            document.getElementById('edit-location-address').value = data.display_name;
                        }
                    })
                    .catch(error => console.log('Geocoding error:', error));
            });
        @endif
    </script>
</x-app-layout>