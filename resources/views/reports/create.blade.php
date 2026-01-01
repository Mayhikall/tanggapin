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
                                <!-- Location Search -->
                                <div class="relative">
                                    <div class="relative">
                                        <input type="text" 
                                               id="location-search" 
                                               placeholder="Cari lokasi... (contoh: Monas Jakarta)"
                                               autocomplete="off"
                                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 pl-10">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <div id="search-loading" class="absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                                            <svg class="animate-spin h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- Search Results Dropdown -->
                                    <div id="search-results" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg hidden max-h-64 overflow-y-auto">
                                    </div>
                                </div>

                                <div>
                                    <label for="create-location-address" class="block text-xs text-gray-500 mb-1">Alamat Terpilih:</label>
                                    <input type="text" 
                                           name="location_address" 
                                           id="create-location-address" 
                                           required 
                                           value="{{ old('location_address') }}"
                                           placeholder="Klik peta atau cari lokasi di atas..."
                                           readonly
                                           class="block w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    @error('location_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">Atau klik pada peta untuk memilih lokasi:</p>
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
                                Gambar Pendukung *
                            </label>
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   accept="image/*"
                                   required
                                   onchange="previewImage(event)"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <p class="mt-1 text-sm text-gray-500">
                                Pilih file gambar (JPG, PNG, maksimal 2MB) - Wajib
                            </p>
                            
                            <!-- Preview -->
                            <div id="image-preview" class="mt-3 hidden">
                                <p class="text-sm text-gray-600 mb-2">Preview:</p>
                                <img id="preview-img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border">
                                <p id="file-info" class="text-xs text-gray-500 mt-1"></p>
                            </div>
                            
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Video -->
                        <div class="mb-6">
                            <label for="video" class="block text-sm font-medium text-gray-700 mb-2">
                                Video Pendukung (Opsional)
                            </label>
                            <input type="file" 
                                   name="video" 
                                   id="video" 
                                   accept="video/mp4,video/mov,video/avi"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-sm text-gray-500">
                                Pilih file video (MP4, MOV, AVI, maksimal 50MB) - Opsional
                            </p>
                            
                            @error('video')
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
        
        // Function to set location on map
        function setLocation(lat, lng, address) {
            if (createMarker) {
                createMap.removeLayer(createMarker);
            }
            
            createMarker = L.marker([lat, lng]).addTo(createMap);
            createMap.setView([lat, lng], 16);
            
            document.getElementById('create-latitude').value = lat;
            document.getElementById('create-longitude').value = lng;
            document.getElementById('create-location-address').value = address;
        }
        
        // Handle map click
        createMap.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            
            if (createMarker) {
                createMap.removeLayer(createMarker);
            }
            
            createMarker = L.marker([lat, lng]).addTo(createMap);
            
            document.getElementById('create-latitude').value = lat;
            document.getElementById('create-longitude').value = lng;
            
            // Reverse geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('create-location-address').value = data.display_name;
                    }
                })
                .catch(error => console.log('Geocoding error:', error));
        });

        // Location Search Functionality
        const searchInput = document.getElementById('location-search');
        const searchResults = document.getElementById('search-results');
        const searchLoading = document.getElementById('search-loading');
        let searchTimeout = null;

        // Debounced search function
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            
            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            
            // Hide results if query is too short
            if (query.length < 3) {
                searchResults.classList.add('hidden');
                searchResults.innerHTML = '';
                return;
            }
            
            // Show loading
            searchLoading.classList.remove('hidden');
            
            // Debounce search (wait 500ms after user stops typing)
            searchTimeout = setTimeout(() => {
                searchLocation(query);
            }, 500);
        });

        // Search location using Nominatim
        function searchLocation(query) {
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5&addressdetails=1`;
            
            fetch(url, {
                headers: {
                    'Accept-Language': 'id'
                }
            })
                .then(response => response.json())
                .then(data => {
                    searchLoading.classList.add('hidden');
                    displaySearchResults(data);
                })
                .catch(error => {
                    searchLoading.classList.add('hidden');
                    console.log('Search error:', error);
                });
        }

        // Display search results
        function displaySearchResults(results) {
            searchResults.innerHTML = '';
            
            if (results.length === 0) {
                searchResults.innerHTML = `
                    <div class="px-4 py-3 text-sm text-gray-500">
                        Lokasi tidak ditemukan. Coba kata kunci lain.
                    </div>
                `;
                searchResults.classList.remove('hidden');
                return;
            }
            
            results.forEach(result => {
                const item = document.createElement('div');
                item.className = 'px-4 py-3 hover:bg-green-50 cursor-pointer border-b border-gray-100 last:border-0 transition-colors';
                item.innerHTML = `
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-green-600 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${result.display_name}</p>
                            <p class="text-xs text-gray-500">${result.type ? result.type.replace('_', ' ') : 'Lokasi'}</p>
                        </div>
                    </div>
                `;
                
                item.addEventListener('click', function() {
                    const lat = parseFloat(result.lat);
                    const lng = parseFloat(result.lon);
                    const address = result.display_name;
                    
                    // Set location on map
                    setLocation(lat, lng, address);
                    
                    // Clear search
                    searchInput.value = '';
                    searchResults.classList.add('hidden');
                });
                
                searchResults.appendChild(item);
            });
            
            searchResults.classList.remove('hidden');
        }

        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });

        // Handle keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchResults.classList.add('hidden');
            }
        });

        // Try to get user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                
                createMap.setView([lat, lng], 15);
                createMarker = L.marker([lat, lng]).addTo(createMap);
                
                document.getElementById('create-latitude').value = lat;
                document.getElementById('create-longitude').value = lng;
                
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
        
        // Preview image function
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                const preview = document.getElementById('image-preview');
                const img = document.getElementById('preview-img');
                const info = document.getElementById('file-info');
                
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                    
                    const sizeKB = (file.size / 1024).toFixed(2);
                    info.textContent = `${file.name} (${sizeKB} KB)`;
                };
                
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>