<div class="min-h-screen bg-white flex items-center justify-center p-4" x-data="{ 
    handleKeydown(event) {
        if (event.key === ' ') {
            event.preventDefault();
            $wire.handleSpacePress();
        }
        if (event.key === '1') {
            event.preventDefault();
            $wire.handleAnswer(1);
        }
        if (event.key === '2') {
            event.preventDefault();
            $wire.handleAnswer(2);
        }
    }
}" 
x-on:keydown.window="handleKeydown($event)">
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

        @if($isCompleted)
            <!-- Completion Phase -->
            <div class="w-full flex flex-col items-center justify-center text-center mb-4">
                <div class="mb-6 w-full flex flex-col items-center">
                    <div class="mb-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            Jawaban kamu: {{ $totalCorrect }}/50
                        </h3>
                        <p class="text-lg text-gray-700 mb-4">
                            Tingkat Akurasi: {{ $accuracy }}%
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-lg text-gray-700 mb-4">
                            Terimakasih telah berpartisipasi!
                        </p>
                        <p class="text-gray-600">Klik Spasi untuk menuju tes berikutnya!</p>
                    </div>
                </div>
            </div>

        @elseif($isTransition)
            <!-- Transition Phase -->
            <div class="w-full flex flex-col items-center justify-center text-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-6">
                    Sudah mengerti cara mainnya?
                </h2>
                
                <div class="mb-6 text-center">
                    <p class="text-lg text-gray-700 mb-4">
                        Setelah ini Anda harus menjawab dengan cepat!
                    </p>
                </div>
                
                <!-- Dua kotak seperti soal biasa -->
                <div class="flex justify-center items-center gap-8 mb-4">
                    <!-- Image 1 -->
                    <div class="text-center">
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/speed/1.png" 
                                 alt="Gambar 1" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                        <div class="text-lg font-bold">1</div>
                    </div>
                    
                    <!-- Image 2 -->
                    <div class="text-center">
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/speed/10.png" 
                                 alt="Gambar 2" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                        <div class="text-lg font-bold">2</div>
                    </div>
                </div>
                
                <p class="text-gray-600">Klik angka 1 atau 2 pada keyboard!</p>
            </div>

        @elseif($isSimulation)
            <!-- Simulation Phase -->
            <div class="w-full flex flex-col items-center justify-center text-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-3">
                    Simulasi {{ $currentQuestion }} dari {{ $simulationQuestions }}
                </h2>

                
                @if($currentQuestion == 1)
                    <h3 class="text-lg text-gray-700 mb-4 text-center">
                        Ingat kedua gambar berikut beserta posisinya! Klik spasi untuk melanjutkan!
                    </h3>
                @elseif($currentQuestion == 2)
                    <h3 class="text-lg text-gray-700 mb-4 text-center">
                        Gambar di nomor manakah yang ada pada gambar sebelumnya? Klik angka 1 atau angka 2 pada keyboard!
                    </h3>
                @else
                    <h3 class="text-lg text-gray-700 mb-4 text-center">
                        Simulasi terakhir. Klik angka 1 atau angka 2 pada keyboard!
                    </h3>
                @endif
                
                <div class="flex justify-center items-center gap-8 mb-4">
                    <!-- Image 1 -->
                    <div class="text-center">
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/speed/{{ $currentImages[0] }}.png" 
                                 alt="Gambar 1" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                        <div class="text-lg font-bold">1</div>
                    </div>
                    
                    <!-- Image 2 -->
                    <div class="text-center">
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/speed/{{ $currentImages[1] }}.png" 
                                 alt="Gambar 2" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                        <div class="text-lg font-bold">2</div>
                    </div>
                </div>
                
                @if($currentQuestion == 1)
                    <p class="text-gray-600">Tekan SPASI untuk melanjutkan</p>
                @else
                    <p class="text-gray-600">Klik angka 1 atau 2 pada keyboard</p>
                @endif
            </div>

        @else
            <!-- Real Test Phase -->
            <div class="w-full flex flex-col items-center justify-center text-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-3">
                    Soal {{ $currentQuestion }} dari {{ $totalQuestions }}
                </h2>
                
                <h3 class="text-lg text-gray-700 mb-4 text-center">
                    Klik angka 1 atau angka 2 pada keyboard!
                </h3>
                
                <div class="flex justify-center items-center gap-8 mb-4">
                    <!-- Image 1 -->
                    <div class="text-center">
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/speed/{{ $currentImages[0] }}.png" 
                                 alt="Gambar 1" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                        <div class="text-lg font-bold">1</div>
                    </div>
                    
                    <!-- Image 2 -->
                    <div class="text-center">
                        <div class="w-24 h-24 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/speed/{{ $currentImages[1] }}.png" 
                                 alt="Gambar 2" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                        <div class="text-lg font-bold">2</div>
                    </div>
                </div>
                
                <p class="text-gray-600">Klik angka 1 atau 2 pada keyboard</p>
            </div>
        @endif

    </div>
</div>