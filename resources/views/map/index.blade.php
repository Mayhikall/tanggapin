<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tanggapin') }} - Peta Aduan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #map { height: calc(100vh - 80px); width: 100%; }
        .leaflet-popup-content { max-width: 300px; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-900">Peta Aduan</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Filter -->
                    <select id="type-filter" class="rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">Semua Jenis</option>
                        <option value="pengaduan">Pengaduan</option>
                        <option value="aspirasi">Aspirasi</option>
                    </select>
                    <select id="status-filter" class="rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">Semua Status</option>
                        <option value="pending">Direview</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-green-600 hover:text-green-800 font-medium">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Map Container -->
    <div id="map"></div>

    <!-- Legend -->
    <div class="fixed bottom-4 left-4 bg-white rounded-lg shadow-lg p-4 z-[1000]">
        <h4 class="font-medium text-gray-900 mb-2">Legenda</h4>
        <div class="space-y-2">
            <p class="text-xs font-medium text-gray-500 mb-1">Jenis:</p>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-red-500 mr-2"></div>
                <span class="text-sm text-gray-600">Pengaduan</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-blue-500 mr-2"></div>
                <span class="text-sm text-gray-600">Aspirasi</span>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t space-y-1">
            <p class="text-xs font-medium text-gray-500 mb-1">Status:</p>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 rounded-full bg-yellow-400 mr-2"></span>
                <span class="text-xs text-gray-600">Direview</span>
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                <span class="text-xs text-gray-600">Disetujui</span>
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                <span class="text-xs text-gray-600">Ditolak</span>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 z-[1000]">
        <div class="text-center">
            <p class="text-2xl font-bold text-green-600" id="total-reports">0</p>
            <p class="text-sm text-gray-600">Total Aduan</p>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize map centered on Indonesia
        var map = L.map('map').setView([-2.5, 118], 5);

        // Add tile layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Create marker icons
        var redIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div style="background-color: #ef4444; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [24, 24],
            iconAnchor: [12, 12],
            popupAnchor: [0, -12]
        });

        var blueIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div style="background-color: #3b82f6; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>',
            iconSize: [24, 24],
            iconAnchor: [12, 12],
            popupAnchor: [0, -12]
        });

        var markers = L.layerGroup().addTo(map);

        // Generate star rating HTML
        function getStarRating(rating) {
            if (!rating) return '';
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += `<span style="color: ${i <= rating ? '#fbbf24' : '#d1d5db'}">★</span>`;
            }
            return `<div style="margin-top: 8px; font-size: 16px;">${stars} <span style="font-size: 12px; color: #6b7280;">(${rating}/5)</span></div>`;
        }

        // Get status badge style
        function getStatusBadgeStyle(status) {
            switch (status) {
                case 'approved':
                    return 'background-color: #dcfce7; color: #166534;';
                case 'rejected':
                    return 'background-color: #fee2e2; color: #991b1b;';
                default: // pending
                    return 'background-color: #fef9c3; color: #854d0e;';
            }
        }

        // Load reports
        function loadReports() {
            var type = document.getElementById('type-filter').value;
            var status = document.getElementById('status-filter').value;
            
            var url = '{{ route("api.reports.map") }}';
            var params = [];
            if (type) params.push('type=' + type);
            if (status) params.push('status=' + status);
            if (params.length > 0) url += '?' + params.join('&');

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    markers.clearLayers();
                    document.getElementById('total-reports').textContent = data.length;

                    data.forEach(function(report) {
                        var icon = report.type === 'pengaduan' ? redIcon : blueIcon;
                        var typeStyle = report.type === 'pengaduan' 
                            ? 'background-color: #fee2e2; color: #991b1b;' 
                            : 'background-color: #dbeafe; color: #1e40af;';
                        var statusStyle = getStatusBadgeStyle(report.status);
                        
                        // Rating and comment HTML for approved reports only
                        var feedbackHtml = '';
                        if (report.status === 'approved' && report.rating) {
                            feedbackHtml = getStarRating(report.rating);
                            if (report.comment) {
                                feedbackHtml += `<p style="font-size: 12px; color: #4b5563; margin: 6px 0 0 0; font-style: italic; border-left: 2px solid #10b981; padding-left: 8px;">"${report.comment}"</p>`;
                            }
                        }
                        
                        var popupContent = `
                            <div style="padding: 8px; font-family: system-ui, sans-serif; max-width: 280px;">
                                <span style="display: inline-block; padding: 2px 10px; font-size: 11px; font-weight: 500; border-radius: 9999px; ${typeStyle}; margin-bottom: 8px;">
                                    ${report.type_label}
                                </span>
                                <span style="display: inline-block; padding: 2px 10px; font-size: 11px; font-weight: 500; border-radius: 9999px; ${statusStyle}; margin-bottom: 8px; margin-left: 4px;">
                                    ${report.status_label}
                                </span>
                                <h3 style="font-weight: 600; color: #111827; font-size: 14px; margin: 8px 0 4px 0;">${report.title}</h3>
                                <p style="font-size: 12px; color: #6b7280; margin: 0 0 8px 0;">${report.location_address}</p>
                                ${feedbackHtml}
                                <div style="margin-top: 8px; font-size: 11px; color: #6b7280;">
                                    <span>Oleh: ${report.user_name}</span><br>
                                    <span>${report.created_at}</span>
                                </div>
                            </div>
                        `;

                        L.marker([report.latitude, report.longitude], { icon: icon })
                            .bindPopup(popupContent)
                            .addTo(markers);
                    });

                    // Fit bounds if there are markers
                    if (data.length > 0) {
                        var group = new L.featureGroup(markers.getLayers());
                        map.fitBounds(group.getBounds().pad(0.1));
                    }
                })
                .catch(error => console.error('Error loading reports:', error));
        }

        // Initial load
        loadReports();

        // Filter change handlers
        document.getElementById('type-filter').addEventListener('change', loadReports);
        document.getElementById('status-filter').addEventListener('change', loadReports);
    </script>
</body>
</html>
