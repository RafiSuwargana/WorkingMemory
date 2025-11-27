<div>
    <x-layouts.app>
        <x-slot name="userMenu">
            <button wire:click="logout" 
                    class="text-sm text-red-600 hover:text-red-800 font-medium">
                Keluar
            </button>
        </x-slot>

        <div class="space-y-8">
        <!-- Welcome Section -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Selamat Datang di Working Memory Task
                        </h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                            <p>
                                Platform test kognitif untuk mengukur kemampuan memori kerja Anda. 
                                Terdapat 3 jenis test yang harus diselesaikan secara berurutan.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                        <button wire:click="startTests"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Mulai Test
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Overview -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <!-- Speed Task -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 bg-red-100 rounded-full flex items-center justify-center">
                                <span class="text-red-600 font-semibold text-sm">1</span>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Speed Task
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    Kecepatan Memori
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-gray-600">Test kecepatan mengingat gambar</span>
                    </div>
                </div>
            </div>

            <!-- Energy Task -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 font-semibold text-sm">2</span>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Energy Task
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    Energi Mental
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-gray-600">Test penjumlahan titik domino</span>
                    </div>
                </div>
            </div>

            <!-- Capacity Task -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">3</span>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Capacity Task
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    Kapasitas Memori
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-gray-600">Test kapasitas mengingat gambar</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Test Sessions -->
        @if($testSessions->count() > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Riwayat Test Terakhir
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Test yang pernah Anda lakukan sebelumnya
                </p>
            </div>
            <ul class="divide-y divide-gray-200">
                @foreach($testSessions as $session)
                <li>
                    <div class="px-4 py-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ ucfirst($session->test_type) }} Task
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $session->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-500">
                                Status: 
                                <span class="font-medium 
                                    @if($session->status === 'completed') text-green-600
                                    @elseif($session->status === 'in_progress') text-yellow-600
                                    @else text-gray-600 @endif">
                                    {{ $session->status === 'completed' ? 'Selesai' : ($session->status === 'in_progress' ? 'Berlangsung' : 'Pending') }}
                                </span>
                            </div>
                            @if($session->status === 'completed')
                            <div class="text-sm text-gray-500">
                                Akurasi: <span class="font-medium">{{ number_format($session->calculateAccuracy(), 1) }}%</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada test</h3>
            <p class="mt-1 text-sm text-gray-500">
                Mulai test pertama Anda untuk melihat riwayat di sini.
            </p>
            </div>
        @endif
        </div>
    </x-layouts.app>
</div>