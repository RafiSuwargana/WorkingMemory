<div class="min-h-screen bg-white flex items-center justify-center" x-data="{
    timeoutTimer: null,
    testStartTime: null,
    debugCountdown: 15000,
    debugInterval: null,
    selectedImages: [],
    expectedCount: @json(count($correctAnswers)),

    toggleImage(index) {
        const idx = this.selectedImages.indexOf(index);
        if (idx > -1) {
            this.selectedImages.splice(idx, 1);
        } else {
            this.selectedImages.push(index);
        }

        // Auto submit when correct number selected
        if (this.selectedImages.length === this.expectedCount) {
            $wire.submitAnswerFromClient(this.selectedImages);
        }
    },

    isSelected(index) {
        return this.selectedImages.includes(index);
    },

    startTestTimer() {
        console.log('startTestTimer called, debugTimer:', @json($debugTimer));
        if (this.timeoutTimer) {
            clearTimeout(this.timeoutTimer);
        }
        if (this.debugInterval) {
            clearInterval(this.debugInterval);
        }

        this.testStartTime = Date.now();
        this.debugCountdown = 15000;
        this.selectedImages = [];

        // Start debug countdown if in local environment
        const isDebug = @json($debugTimer);
        console.log('Setting up debug interval, isDebug:', isDebug);
        if (isDebug) {
            this.debugInterval = setInterval(() => {
                this.debugCountdown -= 100;
                console.log('Debug countdown:', this.debugCountdown);
                if (this.debugCountdown <= 0) {
                    this.debugCountdown = 0;
                    clearInterval(this.debugInterval);
                }
            }, 100);
        }

        this.timeoutTimer = setTimeout(() => {
            console.log('Timeout triggered!');
            $wire.handleTimeout();
        }, 15000); // 15 seconds
    },

    clearTestTimer() {
        console.log('Clearing test timer');
        if (this.timeoutTimer) {
            clearTimeout(this.timeoutTimer);
            this.timeoutTimer = null;
        }
        if (this.debugInterval) {
            clearInterval(this.debugInterval);
            this.debugInterval = null;
        }
    }
}" x-on:startTestTimer.window="console.log('startTestTimer.window event received'); startTestTimer()"
    x-on:show-capacity-feedback.window="clearTestTimer(); setTimeout(() => { $wire.hideFeedbackAndProceed(); }, 200)">
    <div class="w-full max-w-6xl mx-auto p-4">


        @if($isCompleted)
        <!-- Completion Screen -->
        <div class="w-full flex flex-col items-center justify-center text-center mb-4">
            <div class="mb-6 w-full flex flex-col items-center">
                <div class="mb-6 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        Jawaban kamu: {{ $testSession->correct_answers ?? 0 }}/{{ $totalTrials }}
                    </h3>
                    <p class="text-xl text-gray-700 mb-2">
                        Tingkat Akurasi: {{ number_format($accuracy, 1) }}%
                    </p>
                    <p class="text-xl text-gray-700 mb-4">
                        Total Waktu: {{ $testSession->total_time ? number_format($testSession->total_time / 1000, 1) :
                        '0' }} detik
                    </p>
                    @if($testSession->average_response_time)
                    <p class="text-xl text-gray-700 mb-4">
                        Rata-rata Waktu Respon: {{ number_format($testSession->average_response_time / 1000, 2) }} detik
                    </p>
                    @endif
                </div>
                <div class="text-center">
                    <p class="text-xl text-gray-700 mb-4">
                        Terimakasih telah berpartisipasi!
                    </p>
                    <p class="text-lg text-gray-600">Klik Spasi untuk menuju tes berikutnya!</p>
                </div>
            </div>
        </div>
        @elseif($isMemorizing)
        <!-- Memorization Phase -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-red-600 mb-4">Ingat gambar berikut ini!</h2>
                <div class="text-lg text-gray-700 mb-4">
                    Waktu tersisa: <span class="font-bold text-red-500">{{ $memorizeTimeLeft }}</span> detik
                </div>
                <p class="text-gray-600">Tekan SPASI untuk melanjutkan atau tunggu hingga waktu habis</p>
            </div>

            <!-- Memory Images -->
            <div class="flex justify-center items-center gap-8">
                @foreach($memoryImages as $imageNumber)
                <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                    <img src="{{ asset('images/capacity/' . $imageNumber . '.png') }}"
                        alt="Memory Image {{ $imageNumber }}" class="w-32 h-32 object-contain mx-auto" loading="eager">
                </div>
                @endforeach
            </div>
        </div>
        @elseif($showFeedback)
        <!-- Feedback Screen -->
        <div class="min-h-screen flex items-center justify-center">
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
        @elseif($isTesting)
        <!-- Testing Phase -->
        <div class="bg-white rounded-lg shadow-md p-8" x-init="
            console.log('Testing phase mounted, starting timer...');
            startTestTimer();
        ">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-blue-600 mb-4">Pilih gambar yang telah Anda ingat!</h2>
                <p class="text-gray-600">Klik gambar yang sesuai dengan gambar yang ditampilkan sebelumnya</p>
                <div class="mt-2">
                    <span class="text-sm text-gray-500">
                        Dipilih: <span x-text="selectedImages.length"></span>/{{ count($correctAnswers) }}
                    </span>
                </div>
                @if($debugTimer)
                <div class="mt-2 p-2 bg-yellow-100 border border-yellow-300 rounded text-base font-mono inline-block">
                    Debug Timer: <span x-text="Math.max(0, Math.ceil(debugCountdown / 100) / 10).toFixed(1)"></span>s
                </div>
                @endif
            </div>



            <!-- Test Images Grid (Always 8 images in 4x2 grid) -->
            <div class="grid grid-cols-4 gap-4 max-w-4xl mx-auto">
                @foreach($testImages as $index => $imageNumber)
                <div class="relative">
                    <button @click="toggleImage({{ $index }})" :disabled="@json($answered)" :class="{
                            'border-blue-500 bg-blue-50 shadow-lg': isSelected({{ $index }}),
                            'border-gray-200': !isSelected({{ $index }}),
                            'cursor-not-allowed opacity-50': @json($answered)
                        }"
                        class="w-full aspect-square bg-gray-50 rounded-lg p-2 border-2 transition-all duration-200 hover:shadow-md">
                        <img src="{{ asset('images/capacity/' . $imageNumber . '.png') }}"
                            alt="Test Image {{ $imageNumber }}" class="w-full h-full object-contain" loading="eager">
                    </button>

                    <div x-show="isSelected({{ $index }})"
                        class="absolute -top-2 -right-2 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold"
                            x-text="selectedImages.indexOf({{ $index }}) + 1"></span>
                    </div>
                </div>
                @endforeach
            </div>

            @if($answered)
            <div class="mt-6 text-center">
                <div class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100">
                    <span class="text-gray-600">Memproses jawaban...</span>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Progress Bar -->
        @if(!$isCompleted && !$showFeedback)
        <div class="mt-6">
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                    style="width: {{ ($currentTrial / $totalTrials) * 100 }}%"></div>
            </div>
            <div class="text-center text-sm text-gray-500 mt-2">
                Progress: {{ $currentTrial }} / {{ $totalTrials }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    let memorizeTimer;

    // Space key handler
    document.addEventListener('keydown', function(event) {
        if (event.code === 'Space') {
            event.preventDefault();
            @this.call('handleSpacePress');
        }
    });

    // Listen for timer start
    window.addEventListener('startMemorizeTimer', function() {
        memorizeTimer = setInterval(function() {
            @this.call('decrementTimer');
        }, 1000);
    });

    // Listen for timer stop
    window.addEventListener('stopMemorizeTimer', function() {
        if (memorizeTimer) {
            clearInterval(memorizeTimer);
        }
    });
});
</script>