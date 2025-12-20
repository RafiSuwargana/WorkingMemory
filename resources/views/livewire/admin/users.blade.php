<div wire:ignore.self x-data="{
    editOpen: false,
    editLoading: false,
    openEdit(userId) {
        this.editOpen = true;
        this.editLoading = true;

        this.$wire.openEditModal(userId)
            .then(() => { this.editLoading = false; })
            .catch(() => { this.editLoading = false; });
    },
    closeEdit() {
        this.editOpen = false;
        this.editLoading = false;
        this.$wire.closeEditModal();
    }
}" class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Pengguna</h1>
                <p class="mt-2 text-sm text-gray-600">Daftar semua pengguna peserta</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input type="text" wire:model.live="search" placeholder="Cari nama atau email..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Users Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Terdaftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Diubah pada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">{{
                            $user->roles->first()->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d M
                            Y H:i:s') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->updated_at->format('d M
                            Y H:i:s') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button x-on:click="openEdit({{ $user->id }})"
                                class="text-blue-600 hover:text-blue-900 mr-4 disabled:opacity-50">
                                Edit
                            </button>
                            <button wire:click="deleteUser({{ $user->id }})"
                                wire:confirm="Apakah Anda yakin ingin menghapus user ini?"
                                class="text-red-600 hover:text-red-900">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data pengguna
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Edit Modal (Alpine handles instant open/close) -->
    <div x-cloak x-show="editOpen" x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-on:click="closeEdit()"></div>

            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <div x-on:click.stop x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 relative">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Edit Pengguna</h3>

                            <!-- Loading overlay to prevent stale data flashes -->
                            <div x-show="editLoading" class="mt-4 flex items-center justify-center gap-3 py-10">
                                <svg class="h-6 w-6 animate-spin text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <p class="text-sm text-gray-600">Memuat data pengguna...</p>
                            </div>

                            <div x-show="!editLoading" class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" wire:model.defer="name"
                                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" wire:model.defer="email"
                                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                    <select wire:model.defer="role"
                                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 capitalize">
                                        @foreach($roles as $roleOption)
                                        <option class="capitalize" value="{{ $roleOption }}">{{ $roleOption }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Password (opsional)</label>
                                    <input type="password" wire:model.defer="password"
                                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                        autocomplete="new-password">
                                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                    <input type="password" wire:model.defer="password_confirmation"
                                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                        autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button wire:click="updateUser" wire:loading.attr="disabled" wire:target="updateUser"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                        <span wire:loading.remove wire:target="updateUser">Simpan</span>
                        <span wire:loading wire:target="updateUser">Menyimpan...</span>
                    </button>
                    <button x-on:click="closeEdit()" wire:loading.attr="disabled" wire:target="updateUser"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm disabled:opacity-50">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>