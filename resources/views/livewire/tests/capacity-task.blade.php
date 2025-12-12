<div class="min-h-screen bg-white flex items-center justify-center">
    <div class="w-full max-w-6xl mx-auto p-4">


        @if($isCompleted)
            <!-- Completion Screen -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 mb-4">Tes Kapasitas Selesai!</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600">{{ $totalCorrect }}</div>
                        <div class="text-sm text-gray-600">Jawaban Benar</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($accuracy, 1) }}%</div>
                        <div class="text-sm text-gray-600">Akurasi</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-purple-600">{{ $totalTrials }}</div>
                        <div class="text-sm text-gray-600">Total Trial</div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('dashboard') }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Kembali ke Dashboard
                    </a>
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
                                 alt="Memory Image {{ $imageNumber }}" 
                                 class="w-32 h-32 object-contain mx-auto">
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif($isTesting)
            <!-- Testing Phase -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-blue-600 mb-4">Pilih gambar yang telah Anda ingat!</h2>
                    <p class="text-gray-600">Klik gambar yang sesuai dengan gambar yang ditampilkan sebelumnya</p>
                    <div class="mt-2">
                        <span class="text-sm text-gray-500">
                            Dipilih: {{ count($userAnswers) }}/{{ count($correctAnswers) }}
                        </span>
                    </div>
                </div>



                <!-- Test Images Grid (Always 8 images in 4x2 grid) -->
                <div class="grid grid-cols-4 gap-4 max-w-4xl mx-auto">
                    @foreach($testImages as $index => $imageNumber)
                        <div class="relative">
                            <button 
                                wire:click="handleImageClick({{ $index }})"
                                @class([
                                    'w-full aspect-square bg-gray-50 rounded-lg p-2 border-2 transition-all duration-200 hover:shadow-md',
                                    'border-blue-500 bg-blue-50 shadow-lg' => in_array($index, $userAnswers),
                                    'border-gray-200' => !in_array($index, $userAnswers),
                                    'cursor-not-allowed opacity-50' => $answered
                                ])
                                @if($answered) disabled @endif>
                                <img src="{{ asset('images/capacity/' . $imageNumber . '.png') }}" 
                                     alt="Test Image {{ $imageNumber }}" 
                                     class="w-full h-full object-contain">
                            </button>
                            
                            @if(in_array($index, $userAnswers))
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ array_search($index, $userAnswers) + 1 }}</span>
                                </div>
                            @endif
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
        @if(!$isCompleted)
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

    <!-- Feedback Overlay -->
    @if($showFeedback)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 text-center max-w-md mx-4">
                @if($feedbackType === 'correct')
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="text-xl font-bold mb-2 text-green-600">Benar!</div>
                    <div class="text-gray-600">Anda memilih gambar yang tepat.</div>
                @else
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="text-xl font-bold mb-2 text-red-600">Salah!</div>
                    <div class="text-gray-600">Gambar yang dipilih tidak tepat.</div>
                @endif
            </div>
        </div>
    @endif
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
