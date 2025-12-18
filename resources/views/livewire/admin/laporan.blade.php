<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Laporan Hasil Tes</h1>
                <p class="mt-2 text-sm text-gray-600">Hasil tes dari semua peserta</p>
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

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <input type="text" wire:model.live="search" placeholder="Cari nama atau email peserta..."
                class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">

            <select wire:model.live="filterTestType"
                class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Jenis Tes</option>
                <option value="speed">Speed Test</option>
                <option value="energy">Energy Test</option>
                <option value="capacity">Capacity Test</option>
            </select>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Tes Selesai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($user->completed_tests_count == 3) bg-green-100 text-green-800
                                @elseif($user->completed_tests_count > 0) bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $user->completed_tests_count }}/3
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="viewDetails({{ $user->id }})" class="text-blue-600 hover:text-blue-900">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data peserta
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