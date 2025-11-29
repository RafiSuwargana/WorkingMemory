<div class="min-h-screen bg-white flex items-center justify-center p-4" x-data="{ 
    handleKeydown(event) {
        if (event.key === ' ') {
            event.preventDefault();
            $wire.handleSpacePress();
        }
        // Handle number keys 0-9 for energy task answers
        if (event.key >= '0' && event.key <= '9') {
            event.preventDefault();
            $wire.handleAnswer(parseInt(event.key));
        }
    }
}" 
x-on:keydown.window="handleKeydown($event)">
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

        @if($isCompleted)
            <!-- Completion Phase -->
            <div class="w-full flex flex-col items-center justify-center text-center mb-4">
                <div class="mb-6 w-full flex flex-col items-center">
                    <div class="mb-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            Jawaban kamu: {{ $totalCorrect }}/{{ $totalQuestions }}
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
                    Sudah mengerti cara mainnya? Lanjutkan penjumlahan...
                </h2>
                
                <div class="mb-6 text-center">
                </div>
                
                <!-- Sample domino card -->
                <div class="flex justify-center items-center mb-4">
                    <div class="text-center">
                        <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/energy/B1.png" 
                                 alt="Contoh kartu domino" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>
                
                <p class="text-gray-600">Klik angka 0-9 pada keyboard!</p>
            </div>

        @elseif($isSimulation)
            <!-- Simulation Phase -->
            <div class="w-full flex flex-col items-center justify-center text-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-3">
                    Simulasi {{ $currentQuestion }} dari {{ $simulationQuestions }}
                </h2>
                
                @if($currentQuestion == 1)
                    <h3 class="text-lg text-gray-700 mb-4 text-center">
                        Ingat jumlah titik pada kartu dibawah!
                    </h3>
                @elseif($currentQuestion == 2)
                    <h3 class="text-lg text-gray-700 mb-4 text-center">
                        Jumlahkan titik kartu ini dengan jumlah titik angka pada kartu sebelumnya!
                    </h3>
                @elseif($currentQuestion == 3)
                    <h3 class="text-lg text-gray-700 mb-4 text-center">
                        Jumlahkan kartu sebelumnya dengan kartu yang ini..
                    </h3>
                @else
                    <h3 class="text-lg text-gray-700 mb-4 text-center">
                        Jumlahkan kartu sebelumnya dengan kartu yang ini..
                    </h3>
                @endif
                
                <div class="flex justify-center items-center mb-4">
                    <!-- Single domino card -->
                    <div class="text-center">
                        <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/energy/{{ $currentImage }}.png" 
                                 alt="Kartu domino" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>
                
                @if($currentQuestion == 1)
                    <p class="text-gray-600">Klik spasi!</p>
                @else
                    <p class="text-gray-600">Ketik jawaban (angka 0-9) pada keyboard</p>
                @endif
            </div>

        @else
            <!-- Real Test Phase -->
            <div class="w-full flex flex-col items-center justify-center text-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-3">
                    Soal {{ $currentQuestion }} dari {{ $totalQuestions }}
                </h2>
                
                <h3 class="text-lg text-gray-700 mb-4 text-center">
                    Jumlahkan titik kartu ini dengan kartu sebelumnya!
                </h3>
                
                <div class="flex justify-center items-center mb-4">
                    <!-- Single domino card -->
                    <div class="text-center">
                        <div class="w-32 h-32 border-2 border-gray-300 rounded-lg mb-2 flex items-center justify-center">
                            <img src="/images/energy/{{ $currentImage }}.png" 
                                 alt="Kartu domino" 
                                 class="max-w-full max-h-full object-contain">
                        </div>
                    </div>
                </div>
                
                <p class="text-gray-600">Ketik jawaban (angka 0-9) pada keyboard</p>
            </div>
        @endif

    </div>
</div>
