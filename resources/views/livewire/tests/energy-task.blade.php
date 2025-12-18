<div class="min-h-screen bg-white flex items-center justify-center p-4" x-data="{
    timeoutTimer: null,
    questionStartTime: null,
    debugCountdown: 15000,
    debugInterval: null,

    startTimer() {
        if (this.timeoutTimer) {
            clearTimeout(this.timeoutTimer);
        }
        if (this.debugInterval) {
            clearInterval(this.debugInterval);
        }

        this.questionStartTime = Date.now();
        this.debugCountdown = 15000;

        // Start debug countdown if in local environment
        if (@json($debugTimer)) {
            this.debugInterval = setInterval(() => {
                this.debugCountdown -= 100;
                if (this.debugCountdown <= 0) {
                    clearInterval(this.debugInterval);
                }
            }, 100);
        }

        this.timeoutTimer = setTimeout(() => {
            $wire.handleTimeout();
        }, 15000); // 15 seconds
    },

    clearTimer() {
        if (this.timeoutTimer) {
            clearTimeout(this.timeoutTimer);
            this.timeoutTimer = null;
        }
        if (this.debugInterval) {
            clearInterval(this.debugInterval);
            this.debugInterval = null;
        }
    },

    handleKeydown(event) {
        // Check if input is disabled
        if (@json($inputDisabled) || @json($showFeedback)) {
            return;
        }

        if (event.key === ' ') {
            event.preventDefault();
            this.clearTimer();
            $wire.handleSpacePress();
        }
        // Handle number keys 0-9 for energy task answers
        if (event.key >= '0' && event.key <= '9') {
            event.preventDefault();
            this.clearTimer();
            $wire.handleAnswer(parseInt(event.key));
        }
    }
}" x-on:keydown.window="handleKeydown($event)"
    x-on:show-feedback.window="setTimeout(() => { $wire.proceedAfterFeedback(); }, 250)"
    x-on:show-feedback-retry.window="setTimeout(() => { $wire.proceedAfterRetry(); }, 250)" x-init="
    $wire.on('question-loaded', () => {
        // Clear any existing timer first
        clearTimer();
        // Only start timer for real test questions, with proper delay after feedback
        if (!@json($isSimulation) && !@json($isTransition) && !@json($isCompleted) && !@json($showFeedback)) {
            setTimeout(() => {
                // Double check conditions before starting timer
                if (!@json($showFeedback) && !@json($inputDisabled)) {
                    startTimer();
                }
            }, 300); // Increased delay to avoid conflict with feedback
        }
    });

    $wire.on('$refresh', () => {
        // Clear any existing timers on component refresh
        clearTimer();
        // Re-check if we need to start timer after refresh with longer delay
        setTimeout(() => {
            if (!@json($isSimulation) && !@json($isTransition) && !@json($isCompleted) && !@json($showFeedback)) {
                startTimer();
            }
        }, 400);
    });
">
    <style>
        .energy-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }
    </style>

    <div class="energy-container">

        @if($isPreloading)
        <!-- Preloading Screen -->
        <div class="min-h-screen flex flex-col items-center justify-center text-center">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-blue-600 mb-4">Memuat Gambar Tes...</h2>
                <p class="text-lg text-gray-600 mb-6">Mohon tunggu sementara kami menyiapkan gambar untuk tes Anda.</p>

                <!-- Progress Bar -->
                <div class="w-80 bg-gray-200 rounded-full h-4 mx-auto mb-4">
                    <div class="bg-blue-600 h-4 rounded-full transition-all duration-300"
                        style="width: {{ $preloadProgress }}%"></div>
                </div>

                <!-- Progress Text -->
                <p class="text-sm text-gray-500">{{ $preloadProgress }}% selesai</p>
            </div>

            <!-- Loading Animation -->
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600"></div>
        </div>
        @elseif($showFeedback)
        <!-- Feedback Display -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            @if($feedbackType === 'correct')
            <div class="text-center">
                <div class="text-9xl mb-8">✓</div>
                <h3 class="text-6xl font-bold text-green-600">Benar!</h3>
            </div>
            @elseif($feedbackType === 'wrong')
            <div class="text-center">
                <div class="text-9xl mb-8">✗</div>
                <h3 class="text-6xl font-bold text-red-600">Salah!</h3>
            </div>
            @elseif($feedbackType === 'slow')
            <div class="text-center">
                <div class="text-9xl mb-8">⏰</div>
                <h3 class="text-6xl font-bold text-orange-600">Kamu terlalu lama mengerjakan soal ini!</h3>
            </div>
            @endif
        </div>

        @elseif($isCompleted)
        <!-- Completion Phase -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            <div class="mb-6 w-full flex flex-col items-center">
                <div class="mb-6 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        Jawaban kamu: {{ $testSession->correct_answers ?? 0 }}/{{ $totalQuestions }}
                    </h3>
                    <p class="text-xl text-gray-700 mb-2">
                        Tingkat Akurasi: {{ $accuracy ?? 0 }}%
                    </p>
                    <p class="text-xl text-gray-700 mb-4">
                        Total Waktu: {{ $testSession->total_time ? number_format($testSession->total_time / 1000, 1) :
                        '0' }} detik
                    </p>
                    <p class="text-xl text-gray-700 mb-4">
                        Rata-rata Waktu Respon: {{ number_format(($testSession->average_response_time ?? 0) / 1000, 2)
                        }} detik
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-xl text-gray-700 mb-4">
                        Terimakasih telah berpartisipasi!
                    </p>
                    <p class="text-lg text-gray-600">Klik Spasi untuk menuju tes berikutnya!</p>
                </div>
            </div>
        </div>

        @elseif($isTransition)
        <!-- Transition Phase -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Sudah mengerti cara mainnya? Lanjutkan penjumlahan...
            </h2>

            <div class="mb-6 text-center">
            </div>

            <!-- Sample domino card -->
            <div class="flex justify-center items-center mb-4">
                <div class="text-center">
                    <div class="w-40 h-40 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/energy/B1.png" alt="Contoh kartu domino"
                            class="max-w-full max-h-full object-contain">
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button wire:click="restartSimulation"
                    class="px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                    Belum Mengerti (Ulangi Simulasi)
                </button>
                <p class="text-gray-600 flex items-center mx-4">atau</p>
                <button wire:click="proceedToRealTest"
                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                    Sudah Mengerti (Mulai Test)
                </button>
            </div>
        </div>

        @elseif($isSimulation)
        <!-- Simulation Phase -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">
                Simulasi {{ $currentQuestion }} dari {{ $simulationQuestions }}
            </h2>

            @if($currentQuestion == 1)
            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Ingat jumlah titik pada kartu dibawah!
            </h3>
            @elseif($currentQuestion == 2)
            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Jumlahkan titik kartu ini dengan jumlah titik angka pada kartu sebelumnya!
            </h3>
            @elseif($currentQuestion == 3)
            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Jumlahkan kartu sebelumnya dengan kartu yang ini..
            </h3>
            @else
            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Jumlahkan kartu sebelumnya dengan kartu yang ini..
            </h3>
            @endif

            <div class="flex justify-center items-center mb-4">
                <!-- Single domino card -->
                <div class="text-center">
                    <div
                        class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 lg:w-56 lg:h-56 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/energy/{{ $currentImage }}.png" alt="Kartu domino"
                            class="max-w-full max-h-full object-contain">
                    </div>
                </div>
            </div>

            @if($currentQuestion == 1)
            <p class="text-lg text-gray-600">Klik spasi!</p>
            @else
            <p class="text-lg text-gray-600">Ketik jawaban (angka 0-9) pada keyboard</p>
            <p class="text-base text-gray-500 mt-1">*Jika jawaban 2 digit, ketik angka terakhir saja (contoh: jawaban
                12,
                ketik 2)</p>
            @endif
        </div>

        @else
        <!-- Real Test Phase -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">
                Soal {{ $currentQuestion }} dari {{ $totalQuestions }}
            </h2>

            @if($debugTimer)
            <div class="mb-2 p-2 bg-yellow-100 border border-yellow-300 rounded text-base font-mono">
                Debug Timer: <span x-text="Math.max(0, Math.ceil(debugCountdown / 100) / 10).toFixed(1)"></span>s
            </div>
            @endif

            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Jumlahkan titik kartu ini dengan kartu sebelumnya!
            </h3>
            <div class="flex justify-center items-center mb-4">
                <!-- Single domino card -->
                <div class="text-center">
                    <div class="w-40 h-40 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/energy/{{ $currentImage }}.png" alt="Kartu domino"
                            class="max-w-full max-h-full object-contain">
                    </div>
                </div>
            </div>

            <p class="text-lg text-gray-600">Ketik jawaban (angka 0-9) pada keyboard</p>
            <p class="text-base text-gray-500 mt-1">*Jika jawaban 2 digit, ketik angka terakhir saja (contoh: jawaban
                12,
                ketik 2)</p>
        </div>
        @endif

    </div>
</div>

<!-- Include preloader script -->
<script src="{{ asset('js/energy-preloader.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let preloadStarted = false;

        // Start preloading if not already started and we're in preloading state
        if (@json($isPreloading) && !preloadStarted) {
            preloadStarted = true;
            startEnergyPreloading();
        }

        // Preloading function
        function startEnergyPreloading() {
            if (window.energyPreloader) {
                window.energyPreloader
                    .onProgress((loaded, total, percentage) => {
                        @this.call('updatePreloadProgress', percentage);
                    })
                    .onComplete(() => {
                        @this.call('handlePreloadComplete');
                    })
                    .preloadAll()
                    .catch(error => {
                        console.error('Energy preloading failed:', error);
                        // Continue anyway if preloading fails
                        @this.call('handlePreloadComplete');
                    });
            } else {
                console.error('Energy preloader not found, skipping preload');
                @this.call('handlePreloadComplete');
            }
        }
    });
</script>