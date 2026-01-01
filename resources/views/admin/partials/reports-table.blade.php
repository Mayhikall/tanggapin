<!-- Reports Table -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                    Laporan
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                    Pengguna
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                    Jenis
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                    Tanggal
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                    Lokasi
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                    Status
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($reports as $report)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($report->image)
                                <div class="flex-shrink-0 h-12 w-12">
                                    <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('storage/' . $report->image) }}" alt="">
                                </div>
                            @else
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($report->title, 40) }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($report->content, 60) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $report->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $report->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($report->type == 'pengaduan')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-300">
                                Pengaduan
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-300">
                                Aspirasi
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div>{{ $report->date_of_incident->format('d/m/Y') }}</div>
                        <div class="text-xs">{{ $report->created_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ Str::limit($report->location_address, 30) }}</div>
                        <div class="text-xs text-gray-500">{{ number_format($report->latitude, 4) }}, {{ number_format($report->longitude, 4) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-status-badge :status="$report->status" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            @if($report->status === 'pending')
                                <!-- Approve Button -->
                                <form action="{{ route('admin.approve', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-bold rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm"
                                            onclick="return confirm('Yakin ingin menyetujui laporan ini?')">
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Approve
                                    </button>
                                </form>

                                <!-- Reject Button -->
                                <form action="{{ route('admin.reject', $report) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-bold rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm"
                                            onclick="return confirm('Yakin ingin menolak laporan ini?')">
                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Reject
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-600 font-semibold italic">
                                    {{ $report->status === 'approved' ? 'Sudah Disetujui' : 'Sudah Ditolak' }}
                                </span>
                            @endif

                            <!-- View Detail Button -->
                            <a href="{{ route('admin.report.detail', $report) }}" 
                               class="inline-flex items-center px-3 py-1.5 border-2 border-gray-300 text-xs font-bold rounded-md text-gray-800 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm">
                                <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-gray-600">
                            <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-bold text-gray-900">Tidak ada laporan</h3>
                            <p class="mt-1 text-sm text-gray-600">Belum ada laporan yang sesuai dengan filter yang dipilih.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($reports->hasPages())
    <div class="mt-6">
        {{ $reports->links() }}
    </div>
@endif