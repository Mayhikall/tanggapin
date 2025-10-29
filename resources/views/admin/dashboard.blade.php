<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin - Manajemen Laporan</h1>
    </x-slot>

    <div class="space-y-6">
        <div class="max-w-full">
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
                    <!-- Header with Statistics -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-4">Semua Laporan Pengguna</h1>
                        
                        <!-- Quick Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-blue-600">Total Laporan</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ \App\Models\Report::count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-yellow-600">Menunggu Review</p>
                                        <p class="text-2xl font-bold text-yellow-900">{{ \App\Models\Report::where('status', 'pending')->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-green-600">Disetujui</p>
                                        <p class="text-2xl font-bold text-green-900">{{ \App\Models\Report::where('status', 'approved')->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-red-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-red-600">Ditolak</p>
                                        <p class="text-2xl font-bold text-red-900">{{ \App\Models\Report::where('status', 'rejected')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="mb-6">
                        <form id="filter-form" class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-48">
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Filter Jenis Laporan</label>
                                <select name="type" id="type" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">Semua Jenis</option>
                                    <option value="pengaduan" {{ request('type') == 'pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                                    <option value="aspirasi" {{ request('type') == 'aspirasi' ? 'selected' : '' }}>Aspirasi</option>
                                </select>
                            </div>

                            <div class="flex-1 min-w-48">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                                <select name="status" id="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div>
                                <button type="button" id="reset-filters" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg">
                                    Reset Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Reports Table -->
                    <div id="reports-table-container">
                        @include('admin.partials.reports-table', ['reports' => $reports])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeFilter = document.getElementById('type');
            const statusFilter = document.getElementById('status');
            const resetButton = document.getElementById('reset-filters');
            const tableContainer = document.getElementById('reports-table-container');

            // Function to fetch filtered results
            function fetchReports() {
                const formData = new FormData();
                if (typeFilter.value) formData.append('type', typeFilter.value);
                if (statusFilter.value) formData.append('status', statusFilter.value);

                fetch('{{ route("admin.dashboard") }}?' + new URLSearchParams(formData), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            // Add event listeners
            typeFilter.addEventListener('change', fetchReports);
            statusFilter.addEventListener('change', fetchReports);

            // Reset filters
            resetButton.addEventListener('click', function() {
                typeFilter.value = '';
                statusFilter.value = '';
                fetchReports();
            });
        });
    </script>
</x-admin-layout>