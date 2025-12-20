<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-10 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">
                    Laporan Hasil Tes
                </h1>
                <p class="mt-1 text-sm text-gray-500">Hasil tes dari semua peserta</p>
            </div>
            <div class="flex gap-3">
                <button wire:click="openExportModal"
                    class="inline-flex items-center px-4 py-2 bg-gray-900 rounded-lg text-sm font-medium text-white hover:bg-gray-800 transition-colors duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </button>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Search Filter -->
        <div class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" wire:model.live="search" placeholder="Cari nama atau email peserta..."
                    class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-200">
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Tes Selesai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full
                                @if($user->completed_tests_count == 3) bg-green-100 text-green-800
                                @elseif($user->completed_tests_count > 0) bg-amber-100 text-amber-800
                                @else bg-gray-100 text-gray-600
                                @endif">
                                {{ $user->completed_tests_count }}/3
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="viewDetails({{ $user->id }})"
                                class="text-gray-700 hover:text-gray-900 transition-colors duration-150">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">Tidak ada data peserta</p>
                            </div>
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

    <!-- Export Modal -->
    @if($showExportModal)
    <div x-data x-show="true" x-transition.opacity class="fixed z-50 inset-0 overflow-y-auto"
        aria-labelledby="export-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" wire:click="closeExportModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900" id="export-modal-title">
                            Export Data Hasil Tes
                        </h3>
                        <button wire:click="closeExportModal"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Pilih jenis tes yang ingin diexport ke Excel</p>
                </div>

                <div class="bg-white px-6 py-6">
                    <div class="space-y-2">
                        <!-- Export All Tests -->
                        <button wire:click="exportExcel('all')"
                            class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-gray-100 rounded-lg">
                                    <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Export Semua Tes</p>
                                    <p class="text-xs text-gray-500">3 sheet (Speed, Energy, Capacity)</p>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Export Speed Test -->
                        <button wire:click="exportExcel('speed')"
                            class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-gray-100 rounded-lg">
                                    <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Export Speed Test</p>
                                    <p class="text-xs text-gray-500">Hanya data Speed Test</p>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Export Energy Test -->
                        <button wire:click="exportExcel('energy')"
                            class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-gray-100 rounded-lg">
                                    <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Export Energy Test</p>
                                    <p class="text-xs text-gray-500">Hanya data Energy Test</p>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Export Capacity Test -->
                        <button wire:click="exportExcel('capacity')"
                            class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-gray-100 rounded-lg">
                                    <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Export Capacity Test</p>
                                    <p class="text-xs text-gray-500">Hanya data Capacity Test</p>
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4">
                    <button wire:click="closeExportModal" type="button"
                        class="w-full inline-flex justify-center rounded-lg border border-gray-300 px-4 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedUser)
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Detail Hasil Tes - {{ $selectedUser->name }}
                            </h3>
                            <div class="mt-4">
                                <div class="text-sm text-gray-600 mb-4">
                                    Email: {{ $selectedUser->email }}
                                </div>

                                @if($selectedUser->testSessions->count() > 0)
                                <div class="space-y-4">
                                    @foreach($selectedUser->testSessions as $session)
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ ucfirst($session->test_type)
                                                    }} Test</h4>
                                                <p class="text-sm text-gray-600">{{ $session->completed_at->format('d M
                                                    Y H:i') }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if($session->test_type == 'speed') bg-blue-100 text-blue-800
                                                @elseif($session->test_type == 'energy') bg-green-100 text-green-800
                                                @else bg-purple-100 text-purple-800
                                                @endif">
                                                {{ ucfirst($session->test_type) }}
                                            </span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 mt-3">
                                            <div>
                                                <span class="text-sm text-gray-600">Skor:</span>
                                                <span class="ml-2 font-semibold">{{ $session->correct_answers }}/{{
                                                    $session->total_questions }}</span>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-600">Akurasi:</span>
                                                <span class="ml-2 font-semibold">{{
                                                    number_format(($session->correct_answers /
                                                    $session->total_questions) * 100, 1) }}%</span>
                                            </div>
                                            <div>
                                                <span class="text-sm text-gray-600">Total Waktu:</span>
                                                <span class="ml-2 font-semibold">{{ $session->total_time ?
                                                    number_format($session->total_time / 1000, 1) : '0' }}s</span>
                                            </div>
                                            @if($session->average_response_time)
                                            <div>
                                                <span class="text-sm text-gray-600">Avg Response:</span>
                                                <span class="ml-2 font-semibold">{{
                                                    number_format($session->average_response_time / 1000, 2) }}s</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-sm text-gray-500">Belum ada tes yang diselesaikan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="closeModal" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>