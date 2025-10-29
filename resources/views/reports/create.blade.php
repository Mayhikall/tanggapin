<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buat Laporan Baru
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
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Buat Laporan Baru</h1>
                        <p class="mt-2 text-sm text-gray-600">
                            Silakan isi form di bawah ini untuk membuat laporan pengaduan atau aspirasi
                        </p>
                    </div>

                    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" id="create-report-form">
                        @csrf
                        
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
                                       value="{{ old('title') }}"
                                       placeholder="Masukkan judul laporan..."
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">Pilih jenis laporan</option>
                                    <option value="pengaduan" {{ old('type') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                                    <option value="aspirasi" {{ old('type') == 'aspirasi' ? 'selected' : '' }}>Aspirasi</option>
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
                                   value="{{ old('date_of_incident') }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
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
                                      placeholder="Jelaskan secara detail mengenai laporan Anda..."
                                      class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('content') }}</textarea>
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
                                           id="create-location-address" 
                                           required 
                                           value="{{ old('location_address') }}"
                                           placeholder="Alamat lengkap lokasi kejadian..."
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    @error('location_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">Klik pada peta untuk memilih lokasi:</p>
                                    <div id="create-map" class="h-64 w-full rounded-lg border border-gray-300"></div>
                                </div>
                                
                                <input type="hidden" name="latitude" id="create-latitude" value="{{ old('latitude') }}">
                                <input type="hidden" name="longitude" id="create-longitude" value="{{ old('longitude') }}">
                                
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
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="mt-1 text-sm text-gray-500">
                                Pilih file gambar (JPG, PNG, maksimal 2MB) - Opsional
                            </p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('dashboard') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded-lg">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Default location (Jakarta center)
        var defaultLat = -6.2088;
        var defaultLng = 106.8456;
        
        // Initialize map
        var createMap = L.map('create-map').setView([defaultLat, defaultLng], 11);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(createMap);
        
        var createMarker = null;
        
        // Handle map click
        createMap.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            
            // Remove existing marker
            if (createMarker) {
                createMap.removeLayer(createMarker);
            }
            
            // Add new marker
            createMarker = L.marker([lat, lng]).addTo(createMap);
            
            // Update form fields
            document.getElementById('create-latitude').value = lat;
            document.getElementById('create-longitude').value = lng;
            
            // Reverse geocoding (optional)
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('create-location-address').value = data.display_name;
                    }
                })
                .catch(error => console.log('Geocoding error:', error));
        });

        // Try to get user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                
                // Update map view to user's location
                createMap.setView([lat, lng], 15);
                
                // Add marker at user's location
                createMarker = L.marker([lat, lng]).addTo(createMap);
                
                // Update form fields
                document.getElementById('create-latitude').value = lat;
                document.getElementById('create-longitude').value = lng;
                
                // Get address for user's location
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            document.getElementById('create-location-address').value = data.display_name;
                        }
                    })
                    .catch(error => console.log('Geocoding error:', error));
            }, function(error) {
                console.log('Geolocation error:', error);
            });
        }

        // Set max date to today
        document.getElementById('date_of_incident').max = new Date().toISOString().split('T')[0];
    </script>
</x-app-layout>