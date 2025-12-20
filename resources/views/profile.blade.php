<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-900">Profile Saya</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola informasi profil dan keamanan akun Anda</p>
            </div>

            <div class="space-y-6">
                <!-- Profile Information Card -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Profil</h2>
                        <p class="mt-1 text-sm text-gray-500">Perbarui informasi profil dan alamat email akun Anda</p>
                    </div>
                    <div class="p-6">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <!-- Update Password Card -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Ubah Password</h2>
                        <p class="mt-1 text-sm text-gray-500">Pastikan akun Anda menggunakan password yang kuat untuk
                            tetap aman</p>
                    </div>
                    <div class="p-6">
                        <livewire:profile.update-password-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>