<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900">Dashboard Admin</h1>
    </x-slot>

    <div class="space-y-4 lg:space-y-6">
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

            <!-- Page Header -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Manajemen User</h2>
                </div>
            </div>

            <div class="bg-white overflow-hidden rounded-lg">
                <div class="p-4 lg:p-6">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Manajemen User</h2>
                            <button onclick="openAddUserModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah User
                            </button>
                        </div>

                        <!-- Users Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Email</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Role</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Terdaftar</th>
                                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($users as $user)
                                        <tr class="hover:bg-gray-50" id="user-row-{{ $user->id }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                        <span class="text-sm font-semibold text-green-600">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium text-gray-900 user-name-{{ $user->id }}">{{ $user->name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-600 user-email-{{ $user->id }}">{{ $user->email }}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium user-role-{{ $user->id }} {{ $user->isAdmin() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <div class="flex items-center justify-end space-x-3">
                                                    <button onclick='editUserInline(@json($user))' class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                        Edit
                                                    </button>
                                                    @if($user->id !== auth()->id())
                                                        <button onclick="deleteUser({{ $user->id }})" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                            Hapus
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada user
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Edit User</h3>
            </div>
            
            <form id="editUserForm" method="POST" action="" class="p-6 space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Nama</label>
                    <input type="text" name="name" id="editName" class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Email</label>
                    <input type="email" name="email" id="editEmail" class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Role</label>
                    <select name="role" id="editRole" class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Password Baru (Opsional)</label>
                    <input type="password" name="password" id="editPassword" class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="editPasswordConfirmation" class="block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 py-2.5 px-3">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeEditUserModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2.5 px-4 rounded-lg transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg transition-colors duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        let currentEditingUserId = null;

        function openAddUserModal() {
            window.location.href = '/admin/users/create';
        }

        function editUserInline(user) {
            currentEditingUserId = user.id;
            
            // Set form values dari data user yang sudah ada
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editRole').value = user.role || 'user';
            document.getElementById('editPassword').value = '';
            document.getElementById('editPasswordConfirmation').value = '';
            
            document.getElementById('editUserForm').action = `/admin/users/${user.id}`;
            document.getElementById('editUserModal').classList.remove('hidden');
        }

        function closeEditUserModal() {
            document.getElementById('editUserModal').classList.add('hidden');
            currentEditingUserId = null;
        }

        function deleteUser(userId) {
            if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Handle form submission
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const userId = currentEditingUserId;
            const formData = new FormData(this);
            
            fetch(`/admin/users/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload halaman untuk update data
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Gagal update user'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Jika error, reload aja untuk aman
                location.reload();
            });
        });

        // Close modal when clicking outside
        document.getElementById('editUserModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditUserModal();
            }
        });
    </script>
</x-admin-layout>
