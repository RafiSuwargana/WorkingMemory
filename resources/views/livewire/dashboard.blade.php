<div x-data="{
    showInstructionModal: false,
    understoodInstructions: false,
    proceedToTest() {
        if (this.understoodInstructions) {
            this.showInstructionModal = false;
            $wire.startTests();
        }
    }
}">
    <div class="space-y-8">
        <!-- Alert Messages -->
        @if (session('error'))
        <div class="bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if (session('message'))
        <div class="bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('message') }}</p>
                </div>
            </div>
        </div>
        @endif

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
                        <button @click="showInstructionModal = true"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
            <div
                class="bg-white overflow-hidden shadow rounded-lg {{ $speedTest ? 'ring-2 ring-green-200 bg-green-50' : '' }}">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="h-8 w-8 {{ $speedTest ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                @if($speedTest)
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                @else
                                <span class="text-red-600 font-semibold text-sm">1</span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Speed Task
                                </dt>
                                <dd class="text-lg font-medium {{ $speedTest ? 'text-green-900' : 'text-gray-900' }}">
                                    Kecepatan Memori
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    @if($speedTest)
                    <div class="space-y-1">
                        <div class="text-xs text-gray-600">Status: <span
                                class="font-semibold text-green-700">Selesai</span></div>
                        <div class="text-xs text-gray-600 flex flex-wrap gap-x-3 gap-y-1">
                            <span>Akurasi: <span class="font-semibold">{{ number_format($speedTest->calculateAccuracy(),
                                    1) }}%</span></span>
                            <span>Benar: <span class="font-semibold">{{ $speedTest->correct_answers }}/{{
                                    $speedTest->total_questions }}</span></span>
                            <span>Waktu: <span class="font-semibold">{{ number_format($speedTest->total_time / 1000, 1)
                                    }}s</span></span>
                        </div>
                    </div>
                    @else
                    <div class="text-sm">
                        <span class="text-gray-600">Test kecepatan mengingat gambar</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Energy Task -->
            <div
                class="bg-white overflow-hidden shadow rounded-lg {{ $energyTest ? 'ring-2 ring-orange-200 bg-orange-50' : '' }}">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="h-8 w-8 {{ $energyTest ? 'bg-orange-100' : 'bg-orange-100' }} rounded-full flex items-center justify-center">
                                @if($energyTest)
                                <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                @else
                                <span class="text-orange-600 font-semibold text-sm">2</span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Energy Task
                                </dt>
                                <dd class="text-lg font-medium {{ $energyTest ? 'text-orange-900' : 'text-gray-900' }}">
                                    Energi Mental
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    @if($energyTest)
                    <div class="space-y-1">
                        <div class="text-xs text-gray-600">Status: <span
                                class="font-semibold text-orange-700">Selesai</span></div>
                        <div class="text-xs text-gray-600 flex flex-wrap gap-x-3 gap-y-1">
                            <span>Akurasi: <span class="font-semibold">{{
                                    number_format($energyTest->calculateAccuracy(), 1) }}%</span></span>
                            <span>Benar: <span class="font-semibold">{{ $energyTest->correct_answers }}/{{
                                    $energyTest->total_questions }}</span></span>
                            <span>Waktu: <span class="font-semibold">{{ number_format($energyTest->total_time / 1000, 1)
                                    }}s</span></span>
                        </div>
                    </div>
                    @else
                    <div class="text-sm">
                        <span class="text-gray-600">Test penjumlahan titik domino</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Capacity Task -->
            <div
                class="bg-white overflow-hidden shadow rounded-lg {{ $capacityTest ? 'ring-2 ring-green-200 bg-green-50' : '' }}">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="h-8 w-8 {{ $capacityTest ? 'bg-green-100' : 'bg-blue-100' }} rounded-full flex items-center justify-center">
                                @if($capacityTest)
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                @else
                                <span class="text-blue-600 font-semibold text-sm">3</span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Capacity Task
                                </dt>
                                <dd
                                    class="text-lg font-medium {{ $capacityTest ? 'text-green-900' : 'text-gray-900' }}">
                                    Kapasitas Memori
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    @if($capacityTest)
                    <div class="space-y-1">
                        <div class="text-xs text-gray-600">Status: <span
                                class="font-semibold text-blue-700">Selesai</span></div>
                        <div class="text-xs text-gray-600 flex flex-wrap gap-x-3 gap-y-1">
                            <span>Akurasi: <span class="font-semibold">{{
                                    number_format($capacityTest->calculateAccuracy(), 1) }}%</span></span>
                            <span>Benar: <span class="font-semibold">{{ $capacityTest->correct_answers }}/{{
                                    $capacityTest->total_questions }}</span></span>
                            <span>Waktu: <span class="font-semibold">{{ number_format($capacityTest->total_time / 1000,
                                    1) }}s</span></span>
                        </div>
                    </div>
                    @else
                    <div class="text-sm">
                        <span class="text-gray-600">Test kapasitas mengingat gambar</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Instructions -->
    <div x-show="showInstructionModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center p-4 z-50"
        style="backdrop-filter: blur(2px);">

        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-8">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">
                        Instruksi Umum
                    </h3>
                    <p class="text-gray-500 mt-2">Silakan baca dengan teliti sebelum memulai tes</p>
                </div>

                <!-- Instructions Content -->
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                        <p>
                            Pada tes ini, anda akan disajikan tiga sesi pengukuran yang meliputi <strong
                                class="text-blue-700">Tes Kecepatan</strong>,
                            <strong class="text-blue-700">Tes Energi</strong>, dan <strong class="text-blue-700">Tes
                                Kapasitas Memori Kerja</strong>.
                        </p>
                    </div>

                    <p>
                        Setiap tes berisi <strong>50 stimulus</strong> yang anda harus jawab dengan mengklik tombol di
                        keyboard sesuai
                        perintah pada setiap tesnya.
                    </p>

                    <p>
                        Anda tidak boleh berhenti pada saat sesi berlangsung. Namun, jika harus berhenti, anda cukup
                        mengklik tombol <strong class="bg-gray-200 px-2 py-1 rounded text-xs">'Esc'</strong> pada
                        keyboard,
                        kemudian klik tombol <strong class="bg-gray-200 px-2 py-1 rounded text-xs">'Spasi'</strong>
                        jika akan melanjutkan.
                    </p>

                    <p>
                        Setiap stimulus yang muncul memiliki durasi tertentu yang akan terus berjalan meski respon anda
                        keliru atau tidak merespon. Anda diminta untuk <strong>merespon secepat mungkin</strong> ketika
                        anda mendapatkan
                        jawabannya.
                    </p>

                    <p>
                        Jika ada pertanyaan, silakan anda bertanya pada fasilitator.
                    </p>
                </div>

                <!-- Warning Box -->
                <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-800 font-medium">
                                Dengan melanjutkan, anda menyetujui untuk berpartisipasi pada tes ini.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Checkbox Confirmation -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <label for="understood" class="flex items-start cursor-pointer">
                        <input x-model="understoodInstructions" id="understood" type="checkbox"
                            class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <span class="ml-3 text-sm font-medium text-gray-900">
                            Saya telah membaca dan memahami instruksi di atas serta bersedia berpartisipasi dalam tes
                            ini
                        </span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4 mt-8">
                    <button @click="showInstructionModal = false"
                        class="flex-1 inline-flex justify-center items-center px-4 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </button>

                    <button @click="proceedToTest()" :disabled="!understoodInstructions" :class="understoodInstructions
                                ? 'bg-green-600 hover:bg-green-700 text-white shadow-lg transform hover:scale-105'
                                : 'bg-gray-300 text-gray-500 cursor-not-allowed'"
                        class="flex-1 inline-flex justify-center items-center px-4 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span x-text="understoodInstructions ? 'Mulai Test' : 'Centang Persetujuan'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>