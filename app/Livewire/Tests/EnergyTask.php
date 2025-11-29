<?php

namespace App\Livewire\Tests;

use Livewire\Component;
use App\Models\TestSession;
use App\Models\TestResult;
use App\Models\TestAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnergyTask extends Component
{
    protected $listeners = ['spacePressed' => 'handleSpacePress', 'numberPressed' => 'handleAnswer'];
    
    public $currentQuestion = 1;
    public $totalQuestions = 49; // 49 soal tes sesungguhnya
    public $simulationQuestions = 4; // 4 simulasi untuk energy task
    
    public $isSimulation = true;
    public $isCompleted = false;
    public $isTransition = false;
    
    public $currentImage = null; // Energy task hanya 1 gambar per tampilan
    public $previousTotal = 0; // Menyimpan total sebelumnya untuk penjumlahan
    
    public $answered = false;
    public $userAnswer = null;
    
    public $totalCorrect = 0;
    public $accuracy = 0;

    public $testSession;

    // Test data untuk 49 soal tes sesungguhnya
    public $testData = [
        ['stim' => 'B1', 'correct_response' => 2],
        ['stim' => 'B4', 'correct_response' => 5],
        ['stim' => 'B44', 'correct_response' => 8],
        ['stim' => 'B3', 'correct_response' => 7],
        ['stim' => 'B33', 'correct_response' => 6],
        ['stim' => 'B0', 'correct_response' => 3],
        ['stim' => 'B2', 'correct_response' => 2],
        ['stim' => 'B33', 'correct_response' => 5],
        ['stim' => 'B3', 'correct_response' => 6],
        ['stim' => 'B2', 'correct_response' => 5],
        ['stim' => 'B55', 'correct_response' => 7],
        ['stim' => 'B444', 'correct_response' => 9],
        ['stim' => 'B4', 'correct_response' => 8],
        ['stim' => 'B1', 'correct_response' => 5],
        ['stim' => 'B1', 'correct_response' => 2],
        ['stim' => 'B0', 'correct_response' => 1],
        ['stim' => 'B0', 'correct_response' => 0],
        ['stim' => 'B4', 'correct_response' => 4],
        ['stim' => 'B3', 'correct_response' => 7],
        ['stim' => 'B33', 'correct_response' => 6],
        ['stim' => 'B3', 'correct_response' => 6],
        ['stim' => 'B33', 'correct_response' => 6],
        ['stim' => 'B2', 'correct_response' => 5],
        ['stim' => 'B5', 'correct_response' => 7],
        ['stim' => 'B1', 'correct_response' => 6],
        ['stim' => 'B1', 'correct_response' => 2],
        ['stim' => 'B0', 'correct_response' => 1],
        ['stim' => 'B10', 'correct_response' => 0],
        ['stim' => 'B0', 'correct_response' => 0],
        ['stim' => 'B2', 'correct_response' => 2],
        ['stim' => 'B3', 'correct_response' => 5],
        ['stim' => 'B4', 'correct_response' => 7],
        ['stim' => 'B666', 'correct_response' => 0],
        ['stim' => 'B7', 'correct_response' => 3],
        ['stim' => 'B4', 'correct_response' => 1],
        ['stim' => 'B77', 'correct_response' => 1],
        ['stim' => 'B0', 'correct_response' => 7],
        ['stim' => 'B8', 'correct_response' => 8],
        ['stim' => 'B2', 'correct_response' => 0],
        ['stim' => 'B4', 'correct_response' => 6],
        ['stim' => 'B444', 'correct_response' => 8],
        ['stim' => 'B8', 'correct_response' => 2],
        ['stim' => 'B1', 'correct_response' => 9],
        ['stim' => 'B3', 'correct_response' => 4],
        ['stim' => 'B0', 'correct_response' => 3],
        ['stim' => 'B5', 'correct_response' => 5],
        ['stim' => 'B1', 'correct_response' => 6],
        ['stim' => 'B8', 'correct_response' => 9],
        ['stim' => 'B1', 'correct_response' => 9],
    ];

    public function mount()
    {
        Log::info('=== ENERGY MOUNT START ===');
        
        // Ensure we start with simulation
        $this->isSimulation = true;
        $this->currentQuestion = 1;
        $this->answered = false;
        $this->previousTotal = 0;
        
        Log::info('After setting properties - isSimulation: ' . ($this->isSimulation ? 'true' : 'false') . ', currentQuestion: ' . $this->currentQuestion);
        
        $this->testSession = TestSession::create([
            'user_id' => Auth::id(),
            'test_type' => 'energy',
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
        
        $this->loadQuestion();
        Log::info('Energy test mounted - Question: ' . $this->currentQuestion . ', Simulation: ' . ($this->isSimulation ? 'true' : 'false'));
        Log::info('=== ENERGY MOUNT END ===');
    }

    public function loadQuestion()
    {
        Log::info('Loading energy question - Q' . $this->currentQuestion . ', Simulation: ' . ($this->isSimulation ? 'true' : 'false'));
        
        if ($this->isSimulation) {
            // Simulation questions
            if ($this->currentQuestion == 1) {
                $this->currentImage = 'B3'; // Simulasi 1: B3.png
                $this->previousTotal = 3; // B3 = 3 titik
            } elseif ($this->currentQuestion == 2) {
                $this->currentImage = 'B33'; // Simulasi 2: B33.png  
                // previousTotal tetap 3 dari simulasi 1
            } elseif ($this->currentQuestion == 3) {
                $this->currentImage = 'B0'; // Simulasi 3: B0.png
                $this->previousTotal = 6; // 3 + 3 = 6
            } elseif ($this->currentQuestion == 4) {
                $this->currentImage = 'B6'; // Simulasi 4: B6.png
                $this->previousTotal = 6; // 6 + 0 = 6
            }
        } else {
            // Real test questions
            $questionIndex = $this->currentQuestion - 1;
            if (isset($this->testData[$questionIndex])) {
                $data = $this->testData[$questionIndex];
                $this->currentImage = $data['stim'];
                // previousTotal akan di-track dari jawaban sebelumnya
            }
        }
        
        // Reset answer state
        $this->answered = false;
        $this->userAnswer = null;
        
        Log::info('Energy question loaded - Image: ' . $this->currentImage . ', Previous Total: ' . $this->previousTotal);
    }

    public function handleSpacePress()
    {
        if ($this->isCompleted) {
            return redirect('http://127.0.0.1:8000/instructionCapacity');
        }
        
        // Untuk simulasi 1 saja (seperti speed task)
        if ($this->isSimulation && $this->currentQuestion == 1) {
            $this->currentQuestion++;
            $this->answered = false;
            $this->userAnswer = null;
            $this->loadQuestion();
        }
    }

    public function handleAnswer($answer)
    {
        if ($this->answered && !$this->isTransition) {
            return; // Prevent multiple answers (kecuali di transisi)
        }
        
        // Handle transisi - dari transisi ke tes sesungguhnya
        if ($this->isTransition) {
            $this->isTransition = false;
            $this->isSimulation = false;
            $this->currentQuestion = 1;
            $this->answered = false;
            $this->userAnswer = null;
            $this->loadQuestion();
            return;
        }
        
        $this->answered = true;
        $this->userAnswer = $answer;
        
        if (!$this->isSimulation) {
            // Real question - save and score
            $questionIndex = $this->currentQuestion - 1;
            $correctAnswer = isset($this->testData[$questionIndex]) ? $this->testData[$questionIndex]['correct_response'] : 0;
            $isCorrect = ($answer == $correctAnswer);
            
            if ($isCorrect) {
                $this->totalCorrect++;
            }
            
            // Save to database
            TestResult::create([
                'test_session_id' => $this->testSession->id,
                'question_number' => $this->currentQuestion,
                'question_data' => [
                    'image' => $this->currentImage,
                    'previous_total' => $this->previousTotal,
                    'is_simulation' => false,
                ],
                'correct_answer' => $correctAnswer,
                'user_answer' => $answer,
                'is_correct' => $isCorrect,
                'response_time' => 0,
                'timeout' => false,
                'question_started_at' => now(),
                'answered_at' => now(),
            ]);
        }
        
        // Auto advance untuk simulasi dan tes sesungguhnya
        $this->currentQuestion++;
        
        // Update previous total untuk simulasi
        if ($this->isSimulation) {
            if ($this->currentQuestion == 3) {
                $this->previousTotal = 6; // 3 + 3 = 6
            } elseif ($this->currentQuestion == 4) {
                $this->previousTotal = 6; // 6 + 0 = 6  
            } elseif ($this->currentQuestion == 5) {
                $this->previousTotal = 12; // 6 + 6 = 12
            }
        }
        
        if ($this->isSimulation && $this->currentQuestion > $this->simulationQuestions) {
            // Setelah simulasi selesai, masuk ke state transisi
            $this->isSimulation = false;
            $this->isTransition = true;
            $this->currentQuestion = 1;
            $this->answered = false;
            $this->userAnswer = null;
            // Tidak load question, tampilkan transisi dulu
            return;
        }
        
        if (!$this->isSimulation && !$this->isTransition && $this->currentQuestion > $this->totalQuestions) {
            $this->completeTest();
            return;
        }
        
        $this->answered = false;
        $this->userAnswer = null;
        $this->loadQuestion();
    }

    public function completeTest()
    {
        $this->isCompleted = true;
        $this->accuracy = $this->totalQuestions > 0 ? round(($this->totalCorrect / $this->totalQuestions) * 100, 1) : 0;
        
        // Update test session
        $this->testSession->update([
            'status' => 'completed',
            'completed_at' => now(),
            'total_score' => $this->totalCorrect,
            'accuracy_percentage' => $this->accuracy,
        ]);
        
        Log::info('Energy test completed - Score: ' . $this->totalCorrect . '/' . $this->totalQuestions . ' (' . $this->accuracy . '%)');
    }

    public function render()
    {
        return view('livewire.tests.energy-task');
    }
}
