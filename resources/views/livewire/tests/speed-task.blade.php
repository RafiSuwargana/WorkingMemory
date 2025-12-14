<div class="min-h-screen bg-white flex items-center justify-center p-4" x-data="{
    timeoutTimer: null,
    questionStartTime: null,
    debugCountdown: 1200,
    debugInterval: null,

    startTimer() {
        // Prevent multiple timers from starting
        if (this.timeoutTimer) {
            return;
        }
        
        // Clear any existing timers (safety check)
        this.clearTimer();

        this.questionStartTime = Date.now();
        this.debugCountdown = 1200;

        // Start debug countdown if in local environment
        const isDebugMode = @json($debugTimer);
        
        if (isDebugMode) {
            this.debugInterval = setInterval(() => {
                this.debugCountdown = Math.max(0, this.debugCountdown - 100);
                if (this.debugCountdown <= 0) {
                    clearInterval(this.debugInterval);
                    this.debugInterval = null;
                }
            }, 100);
        }

        this.timeoutTimer = setTimeout(() => {
            $wire.handleTimeout();
        }, 1200); // 1.2 seconds
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
        if (event.key === '1') {
            event.preventDefault();
            this.clearTimer();
            $wire.handleAnswer(1);
        }
        if (event.key === '2') {
            event.preventDefault();
            this.clearTimer();
            $wire.handleAnswer(2);
        }
    }
}" x-on:keydown.window="handleKeydown($event)"
    x-on:show-feedback.window="setTimeout(() => { $wire.proceedAfterFeedback(); }, 250)"
    x-on:show-feedback-retry.window="setTimeout(() => { $wire.proceedAfterRetry(); }, 1500)" x-init="
        // Auto start timer for real test questions
        $wire.on('question-loaded', () => {
            setTimeout(() => {
                if (!@json($isSimulation) && !@json($isTransition) && !@json($isCompleted) && !@json($showFeedback) && !@json($inputDisabled)) {
                    if (!this.timeoutTimer) {
                        startTimer();
                    }
                }
            }, 50);
        });
    "
">
    <style>
        .speed-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }
        
        /* Optimasi untuk memastikan gambar loading dengan cepat */
        .speed-container img {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            will-change: contents;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
            /* Force hardware acceleration */
            transform: translate3d(0, 0, 0);
            -webkit-transform: translate3d(0, 0, 0);
        }
        
        /* Critical CSS untuk gambar container */
        .speed-container .w-32.h-32 {
            contain: layout style paint;
            will-change: contents;
        }
        
        /* Preload indicator styles */
        .preload-overlay {
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        
        /* Force image caching */
        .speed-container img[src*="/images/speed/"] {
            /* Prefetch hint for better caching */
            image-rendering: auto;
            object-fit: contain;
        }
    </style>

    <div class="speed-container">



        @if($showFeedback)
        <!-- Feedback Display -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            @if($feedbackType === 'correct')
            <div class="mb-6 text-center">
                <div class="text-6xl mb-4">✓</div>
                <h3 class="text-3xl font-bold text-green-600 mb-4">Benar!</h3>
                <div class="flex justify-center gap-4">
                    <div class="w-20 h-20 border-2 border-green-500 rounded-lg flex items-center justify-center">
                        <img src="/images/speed/{{ $currentImages[$correctAnswer-1] }}.png" alt="Correct Answer"
                            class="max-w-full max-h-full object-contain">
                    </div>
                </div>
            </div>
            @elseif($feedbackType === 'wrong')
            <div class="mb-6 text-center">
                <div class="text-6xl mb-4">✗</div>
                <h3 class="text-3xl font-bold text-red-600 mb-4">Salah!</h3>
                <div class="flex justify-center gap-8">
                    <div class="text-center">
                        <div class="text-base text-gray-600 mb-2">Jawaban Anda:</div>
                        <div class="w-20 h-20 border-2 border-red-500 rounded-lg flex items-center justify-center">
                            <img src="/images/speed/{{ $currentImages[$userAnswer-1] }}.png" alt="Your Answer"
                                class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-base text-gray-600 mb-2">Jawaban Benar:</div>
                        <div class="w-20 h-20 border-2 border-green-500 rounded-lg flex items-center justify-center">
                            <img src="/images/speed/{{ $currentImages[$correctAnswer-1] }}.png" alt="Correct Answer"
                                class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>
            </div>
            @elseif($feedbackType === 'timeout')
            <div class="mb-6 text-center">
                <div class="text-6xl mb-4">⏰</div>
                <h3 class="text-3xl font-bold text-orange-600 mb-4">Waktu Habis!</h3>
                <div class="text-center">
                    <div class="text-base text-gray-600 mb-2">Jawaban Benar:</div>
                    <div
                        class="w-20 h-20 border-2 border-green-500 rounded-lg flex items-center justify-center mx-auto">
                        <img src="/images/speed/{{ $currentImages[$correctAnswer-1] }}.png" alt="Correct Answer"
                            class="max-w-full max-h-full object-contain">
                    </div>
                </div>
            </div>
            @endif
        </div>

        @elseif($isCompleted)
        <!-- Completion Phase -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            <div class="mb-6 w-full flex flex-col items-center">
                <div class="mb-6 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        Jawaban kamu: {{ $totalCorrect }}/50
                    </h3>
                    <p class="text-xl text-gray-700 mb-2">
                        Tingkat Akurasi: {{ $accuracy }}%
                    </p>
                    <p class="text-xl text-gray-700 mb-4">
                        Total Waktu: {{ number_format($testSession->total_time / 1000, 1) }} detik
                    </p>
                    <p class="text-xl text-gray-700 mb-4">
                        Rata-rata Waktu Respon: {{ number_format(($testSession->average_response_time ?? 0) / 1000, 2) }} detik
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
                Sudah mengerti cara mainnya?
            </h2>

            <div class="mb-6 text-center">
                <p class="text-xl text-gray-700 mb-4">
                    Setelah ini Anda harus menjawab dengan cepat!
                </p>
            </div>

            <!-- Dua kotak seperti soal biasa -->
            <div class="flex justify-center items-center gap-8 mb-6">
                <!-- Image 1 -->
                <div class="text-center">
                    <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/speed/1.png" alt="Gambar 1" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="text-xl font-bold">1</div>
                </div>

                <!-- Image 2 -->
                <div class="text-center">
                    <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/speed/10.png" alt="Gambar 2" class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="text-xl font-bold">2</div>
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
                Ingat kedua gambar berikut beserta posisinya! Klik spasi untuk melanjutkan!
            </h3>
            @elseif($currentQuestion == 2)
            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Gambar di nomor manakah yang ada pada gambar sebelumnya? Klik angka 1 atau angka 2 pada keyboard!
            </h3>
            @else
            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Simulasi terakhir. Klik angka 1 atau angka 2 pada keyboard!
            </h3>
            @endif

            <div class="flex justify-center items-center gap-8 mb-4">
                <!-- Image 1 -->
                <div class="text-center">
                    <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/speed/{{ $currentImages[0] }}.png" alt="Gambar 1"
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="text-xl font-bold">1</div>
                </div>

                <!-- Image 2 -->
                <div class="text-center">
                    <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/speed/{{ $currentImages[1] }}.png" alt="Gambar 2"
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="text-xl font-bold">2</div>
                </div>
            </div>

            @if($currentQuestion == 1)
            <p class="text-lg text-gray-600">Tekan SPASI untuk melanjutkan</p>
            @else
            <p class="text-lg text-gray-600">Klik angka 1 atau 2 pada keyboard</p>
            @endif
        </div>

        @else
        <!-- Real Test Phase -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-3">
                Soal {{ $currentQuestion }} dari {{ $totalQuestions }}
            </h2>

            @if($debugTimer)
            <div class="mb-2 p-2 bg-yellow-100 border border-yellow-300 rounded text-base font-mono" x-init="
                // Auto-start timer for real test phase after delay (only if no timer exists)
                setTimeout(() => {
                    checkAndStartTimer();
                }, 500);
            ">
                Debug Timer: <span x-text="(debugCountdown / 1000).toFixed(1)"></span>s 
                <span x-show="debugCountdown <= 0" class="text-red-600 font-bold">TIMEOUT!</span>
                <div class="text-xs text-gray-600 mt-1">
                    Timer state: <span x-text="timeoutTimer ? 'Running' : 'Stopped'"></span> |
                    Debug interval: <span x-text="debugInterval ? 'Active' : 'Inactive'"></span>
                </div>
                <button @click="startTimer()" class="mt-1 px-2 py-1 bg-blue-500 text-white text-xs rounded">
                    Manual Start Timer
                </button>
            </div>
            @endif

            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Klik angka 1 atau angka 2 pada keyboard!
            </h3>

            <div class="flex justify-center items-center gap-8 mb-4" x-init="
                // Final fallback: Auto-start timer when real test images are rendered
                setTimeout(() => {
                    checkAndStartTimer();
                }, 800);
            ">
                <!-- Image 1 -->
                <div class="text-center">
                    <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/speed/{{ $currentImages[0] }}.png" alt="Gambar 1"
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="text-xl font-bold">1</div>
                </div>

                <!-- Image 2 -->
                <div class="text-center">
                    <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                        <img src="/images/speed/{{ $currentImages[1] }}.png" alt="Gambar 2"
                            class="max-w-full max-h-full object-contain">
                    </div>
                    <div class="text-xl font-bold">2</div>
                </div>
            </div>

            <p class="text-lg text-gray-600">Klik angka 1 atau 2 pada keyboard</p>
        </div>
        @endif

    </div>
    
    <!-- Hidden images for preloading - ensures all images are cached -->
    <div style="position: absolute; left: -9999px; top: -9999px; visibility: hidden; pointer-events: none;">
        @for($i = 1; $i <= 15; $i++)
        <img src="/images/speed/{{ $i }}.png" alt="" style="width: 1px; height: 1px;">
        @endfor
    </div>
</div>

