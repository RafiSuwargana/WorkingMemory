<div class="min-h-screen bg-white flex items-center justify-center p-4" x-data="{
    timeoutTimer: null,
    questionStartTime: null,
    debugCountdown: 1200,
    debugInterval: null,

    startTimer() {
        if (this.timeoutTimer) {
            clearTimeout(this.timeoutTimer);
        }
        if (this.debugInterval) {
            clearInterval(this.debugInterval);
        }

        this.questionStartTime = Date.now();
        this.debugCountdown = 1200;

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
            <div class="mb-2 p-2 bg-yellow-100 border border-yellow-300 rounded text-base font-mono">
                Debug Timer: <span x-text="Math.max(0, Math.ceil(debugCountdown / 100) / 10).toFixed(1)"></span>s
            </div>
            @endif

            <h3 class="text-xl text-gray-700 mb-4 text-center">
                Klik angka 1 atau angka 2 pada keyboard!
            </h3>

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

            <p class="text-lg text-gray-600">Klik angka 1 atau 2 pada keyboard</p>
        </div>
        @endif

    </div>
</div>