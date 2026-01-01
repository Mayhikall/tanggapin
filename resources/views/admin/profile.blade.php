<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900">Profile Settings</h1>
    </x-slot>

    <div class="space-y-6">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
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

        <!-- Profile Header -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-8">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center ring-4 ring-green-400 shadow-lg">
                        <span class="text-3xl font-bold text-green-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                        <p class="text-green-100">{{ $user->email }}</p>
                        <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-white">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Administrator
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information Form -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Profile</h3>
                <p class="text-sm text-gray-500">Update nama dan email akun Anda.</p>
            </div>
            <form method="POST" action="{{ route('admin.profile.update') }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-800 mb-2">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                           class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3" required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-800 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                           class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3" required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Password Form -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Update Password</h3>
                <p class="text-sm text-gray-500">Pastikan menggunakan password yang kuat dan unik.</p>
            </div>
            <form method="POST" action="{{ route('admin.profile.password') }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="current_password" class="block text-sm font-bold text-gray-800 mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" 
                           class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3" required>
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-800 mb-2">Password Baru</label>
                    <input type="password" name="password" id="password" 
                           class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3" required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-800 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors duration-200">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Information -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Akun</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-500">Role</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Administrator
                            </span>
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-500">Terdaftar Sejak</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-500">Email Terverifikasi</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center text-green-600">
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center text-yellow-600">
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Belum Diverifikasi
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm font-medium text-gray-500">Terakhir Diperbarui</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
