<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900">
            Peta Aduan
        </h1>
    </x-slot>

    <div class="space-y-6">
        <!-- Filter & Stats -->
        <div class="bg-white rounded-xl shadow-md p-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-gray-700">Filter:</label>
                    <select id="type-filter" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Semua Tipe</option>
                        <option value="pengaduan">Pengaduan</option>
                        <option value="aspirasi">Aspirasi</option>
                    </select>
                    <select id="status-filter" class="rounded-lg border-gray-300 text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Semua Status</option>
                        <option value="pending">Direview</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="flex items-center space-x-4">
                    <span id="report-count" class="text-sm text-gray-600">Total: 0 laporan</span>
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="text-xs text-gray-600">Pengaduan</span>
                        <span class="w-3 h-3 rounded-full bg-blue-500 ml-2"></span>
                        <span class="text-xs text-gray-600">Aspirasi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div id="admin-map" class="h-[600px] w-full"></div>
        </div>
    </div>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize map
        var map = L.map('admin-map').setView([-6.2088, 106.8456], 10);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var markers = [];

        // Generate star rating HTML
        function getStarRating(rating) {
            if (!rating) return '';
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += `<span style="color: ${i <= rating ? '#fbbf24' : '#d1d5db'}">★</span>`;
            }
            return `<div style="margin-top: 4px; font-size: 14px;">${stars} <span style="font-size: 11px; color: #6b7280;">(${rating}/5)</span></div>`;
        }

        // Load reports
        function loadReports() {
            const type = document.getElementById('type-filter').value;
            const status = document.getElementById('status-filter').value;
            
            let url = '/api/reports/map?admin=1';
            if (type) url += `&type=${type}`;
            if (status) url += `&status=${status}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Clear existing markers
                    markers.forEach(m => map.removeLayer(m));
                    markers = [];

                    document.getElementById('report-count').textContent = `Total: ${data.length} laporan`;

                    data.forEach(report => {
                        const color = report.type === 'pengaduan' ? '#EF4444' : '#3B82F6';
                        const icon = L.divIcon({
                            className: 'custom-marker',
                            html: `<div style="background-color: ${color}; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"></div>`,
                            iconSize: [24, 24],
                            iconAnchor: [12, 12]
                        });

                        const statusBadge = report.status === 'approved' ? 'background-color: #dcfce7; color: #166534;' :
                                          report.status === 'rejected' ? 'background-color: #fee2e2; color: #991b1b;' :
                                          'background-color: #fef9c3; color: #854d0e;';

                        const typeBadge = report.type === 'pengaduan' ? 'background-color: #fee2e2; color: #991b1b;' : 'background-color: #dbeafe; color: #1e40af;';

                        // Show rating only for approved reports
                        const ratingHtml = report.status === 'approved' && report.rating ? getStarRating(report.rating) : '';

                        const marker = L.marker([report.latitude, report.longitude], { icon: icon })
                            .bindPopup(`
                                <div style="min-width: 220px; font-family: system-ui, sans-serif;">
                                    <h3 style="font-weight: 600; font-size: 14px; margin: 0 0 8px 0;">${report.title}</h3>
                                    <p style="font-size: 12px; color: #6b7280; margin: 0 0 8px 0;">${report.location_address}</p>
                                    <div style="display: flex; gap: 6px; margin-bottom: 8px;">
                                        <span style="font-size: 11px; padding: 2px 8px; border-radius: 9999px; ${typeBadge}">${report.type_label}</span>
                                        <span style="font-size: 11px; padding: 2px 8px; border-radius: 9999px; ${statusBadge}">${report.status_label}</span>
                                    </div>
                                    ${ratingHtml}
                                    <p style="font-size: 11px; color: #6b7280; margin: 8px 0 4px 0;">Oleh: ${report.user_name}</p>
                                    <p style="font-size: 11px; color: #9ca3af; margin: 0 0 8px 0;">${report.created_at}</p>
                                    <a href="/admin/reports/${report.id}/detail" style="font-size: 12px; color: #16a34a; text-decoration: none;">Lihat Detail →</a>
                                </div>
                            `)
                            .addTo(map);
                        
                        markers.push(marker);
                    });

                    // Fit bounds if markers exist
                    if (markers.length > 0) {
                        const group = new L.featureGroup(markers);
                        map.fitBounds(group.getBounds().pad(0.1));
                    }
                })
                .catch(error => console.log('Error:', error));
        }

        // Event listeners
        document.getElementById('type-filter').addEventListener('change', loadReports);
        document.getElementById('status-filter').addEventListener('change', loadReports);

        // Initial load
        loadReports();
    </script>
</x-admin-layout>
