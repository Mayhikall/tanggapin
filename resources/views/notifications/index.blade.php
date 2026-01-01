<x-user-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('Notifikasi') }}
            </h2>
            @if(Auth::user()->unreadNotificationsCount() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-green-600 hover:text-green-800 font-medium">
                        Tandai Semua Sudah Dibaca
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
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

            <div class="user-card">
                <div class="p-6">
                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="flex items-start p-4 rounded-lg border {{ $notification->is_read ? 'bg-gray-50 border-gray-200' : 'bg-green-50 border-green-200' }}">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0 mr-4">
                                        @if($notification->type === 'approved')
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        @elseif($notification->type === 'rejected')
                                            <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $notification->title }}
                                            </p>
                                            <span class="text-xs text-gray-500">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ $notification->message }}
                                        </p>
                                        <div class="mt-3 flex items-center space-x-4">
                                            @if($notification->report_id)
                                                <a href="{{ route('reports.show', $notification->report_id) }}" 
                                                   class="text-sm text-green-600 hover:text-green-800 font-medium">
                                                    Lihat Laporan
                                                </a>
                                            @endif
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.read', $notification) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                                        Tandai Dibaca
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda belum memiliki notifikasi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
