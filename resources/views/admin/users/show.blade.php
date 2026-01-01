<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">
                Detail User
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-8">
                    <div class="flex items-end space-x-4">
                        <div class="h-20 w-20 rounded-full bg-white flex items-center justify-center shadow-lg">
                            <span class="text-3xl font-bold text-green-600">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="text-white mb-2">
                            <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                            <p class="text-green-100">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <!-- Nama -->
                        <div>
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Nama Lengkap</label>
                            <p class="text-lg text-gray-900">{{ $user->name }}</p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Email</label>
                            <p class="text-lg text-gray-900">{{ $user->email }}</p>
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Role</label>
                            @if($user->isAdmin())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    User
                                </span>
                            @endif
                        </div>

                        <!-- Terdaftar -->
                        <div>
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Terdaftar Sejak</label>
                            <p class="text-lg text-gray-900">{{ $user->created_at->format('d F Y H:i') }}</p>
                        </div>

                        <!-- Last Update -->
                        <div class="col-span-2">
                            <label class="text-sm font-medium text-gray-500 mb-2 block">Terakhir Diupdate</label>
                            <p class="text-lg text-gray-900">{{ $user->updated_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t pt-6 flex items-center justify-end space-x-4">
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-flex items-center">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
