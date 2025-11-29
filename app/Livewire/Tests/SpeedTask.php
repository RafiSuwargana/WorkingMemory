<?php

namespace App\Livewire\Tests;

use Livewire\Component;
use App\Models\TestSession;
use App\Models\TestResult;
use App\Models\TestAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SpeedTask extends Component
{
    protected $listeners = ['spacePressed' => 'handleSpacePress', 'numberPressed' => 'handleAnswer'];
    
    public $currentQuestion = 1;
    public $totalQuestions = 50;
    public $simulationQuestions = 3;
    
    public $isSimulation = true;
    public $isCompleted = false;
    public $isTransition = false;
    
    public $currentImages = [];
    public $correctAnswer = null;
    
    public $answered = false;
    public $userAnswer = null;
    
    public $totalCorrect = 0;
    public $accuracy = 0;

    public $testSession;

    // Test data array berdasarkan data yang benar
    public $testData = [
        ['shape_target' => 1, 'shape_distractor' => 12, 'correct_response' => 2],
        ['shape_target' => 12, 'shape_distractor' => 1, 'correct_response' => 1],
        ['shape_target' => 1, 'shape_distractor' => 10, 'correct_response' => 2],
        ['shape_target' => 10, 'shape_distractor' => 3, 'correct_response' => 1],
        ['shape_target' => 3, 'shape_distractor' => 14, 'correct_response' => 1],
        ['shape_target' => 14, 'shape_distractor' => 1, 'correct_response' => 2],
        ['shape_target' => 1, 'shape_distractor' => 14, 'correct_response' => 1],
        ['shape_target' => 14, 'shape_distractor' => 4, 'correct_response' => 2],
        ['shape_target' => 4, 'shape_distractor' => 13, 'correct_response' => 1],
        ['shape_target' => 13, 'shape_distractor' => 1, 'correct_response' => 2],
        ['shape_target' => 1, 'shape_distractor' => 10, 'correct_response' => 1],
        ['shape_target' => 10, 'shape_distractor' => 5, 'correct_response' => 2],
        ['shape_target' => 5, 'shape_distractor' => 9, 'correct_response' => 1],
        ['shape_target' => 9, 'shape_distractor' => 5, 'correct_response' => 2],
        ['shape_target' => 5, 'shape_distractor' => 14, 'correct_response' => 2],
        ['shape_target' => 14, 'shape_distractor' => 3, 'correct_response' => 2],
        ['shape_target' => 3, 'shape_distractor' => 13, 'correct_response' => 1],
        ['shape_target' => 13, 'shape_distractor' => 6, 'correct_response' => 1],
        ['shape_target' => 6, 'shape_distractor' => 14, 'correct_response' => 2],
        ['shape_target' => 14, 'shape_distractor' => 4, 'correct_response' => 1],
        ['shape_target' => 4, 'shape_distractor' => 14, 'correct_response' => 1],
        ['shape_target' => 14, 'shape_distractor' => 1, 'correct_response' => 1],
        ['shape_target' => 1, 'shape_distractor' => 15, 'correct_response' => 2],
        ['shape_target' => 15, 'shape_distractor' => 3, 'correct_response' => 2],
        ['shape_target' => 3, 'shape_distractor' => 12, 'correct_response' => 1],
        ['shape_target' => 12, 'shape_distractor' => 7, 'correct_response' => 2],
        ['shape_target' => 7, 'shape_distractor' => 9, 'correct_response' => 1],
        ['shape_target' => 9, 'shape_distractor' => 3, 'correct_response' => 1],
        ['shape_target' => 3, 'shape_distractor' => 11, 'correct_response' => 2],
        ['shape_target' => 11, 'shape_distractor' => 3, 'correct_response' => 2],
        ['shape_target' => 3, 'shape_distractor' => 8, 'correct_response' => 2],
        ['shape_target' => 8, 'shape_distractor' => 7, 'correct_response' => 1],
        ['shape_target' => 7, 'shape_distractor' => 8, 'correct_response' => 1],
        ['shape_target' => 8, 'shape_distractor' => 2, 'correct_response' => 1],
        ['shape_target' => 2, 'shape_distractor' => 12, 'correct_response' => 2],
        ['shape_target' => 12, 'shape_distractor' => 1, 'correct_response' => 2],
        ['shape_target' => 1, 'shape_distractor' => 15, 'correct_response' => 2],
        ['shape_target' => 15, 'shape_distractor' => 2, 'correct_response' => 2],
        ['shape_target' => 2, 'shape_distractor' => 8, 'correct_response' => 1],
        ['shape_target' => 8, 'shape_distractor' => 6, 'correct_response' => 1],
        ['shape_target' => 6, 'shape_distractor' => 8, 'correct_response' => 2],
        ['shape_target' => 8, 'shape_distractor' => 2, 'correct_response' => 1],
        ['shape_target' => 2, 'shape_distractor' => 11, 'correct_response' => 2],
        ['shape_target' => 11, 'shape_distractor' => 2, 'correct_response' => 2],
        ['shape_target' => 2, 'shape_distractor' => 9, 'correct_response' => 1],
        ['shape_target' => 9, 'shape_distractor' => 11, 'correct_response' => 1],
        ['shape_target' => 1, 'shape_distractor' => 3, 'correct_response' => 1],
        ['shape_target' => 8, 'shape_distractor' => 10, 'correct_response' => 2],
        ['shape_target' => 4, 'shape_distractor' => 6, 'correct_response' => 1],
        ['shape_target' => 6, 'shape_distractor' => 9, 'correct_response' => 2],
    ];

    public function mount()
    {
        Log::info('=== MOUNT START ===');
        
        // Ensure we start with simulation
        $this->isSimulation = true;
        $this->currentQuestion = 1;
        $this->answered = false;
        
        Log::info('After setting properties - isSimulation: ' . ($this->isSimulation ? 'true' : 'false') . ', currentQuestion: ' . $this->currentQuestion);
        
        $this->testSession = TestSession::create([
            'user_id' => Auth::id(),
            'test_type' => 'speed',
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
        
        $this->loadQuestion();
        Log::info('Speed test mounted - Question: ' . $this->currentQuestion . ', Simulation: ' . ($this->isSimulation ? 'true' : 'false'));
        Log::info('=== MOUNT END ===');
    }

    public function loadQuestion()
    {
        Log::info('Loading question - Q' . $this->currentQuestion . ', Simulation: ' . ($this->isSimulation ? 'true' : 'false'));
        
        if ($this->isSimulation) {
            // Simulation questions
            if ($this->currentQuestion == 1) {
                $this->currentImages = [13, 3]; // Simulasi 1
            } elseif ($this->currentQuestion == 2) {
                $this->currentImages = [13, 4]; // Simulasi 2 - 13 from previous
            } elseif ($this->currentQuestion == 3) {
                $this->currentImages = [10, 4]; // Simulasi 3
            }
            $this->correctAnswer = null; // No scoring in simulation
        } else {
            // Real test questions
            $questionIndex = $this->currentQuestion - 1;
            if (isset($this->testData[$questionIndex])) {
                $data = $this->testData[$questionIndex];
                $shapeTarget = $data['shape_target'];
                $shapeDistractor = $data['shape_distractor'];
                $correctResponse = $data['correct_response'];
                
                // Position images based on correct_response
                if ($correctResponse == 1) {
                    $this->currentImages = [$shapeTarget, $shapeDistractor];
                    $this->correctAnswer = 1;
                } else {
                    $this->currentImages = [$shapeDistractor, $shapeTarget];
                    $this->correctAnswer = 2;
                }
            }
        }
        
        // Reset answer state
        $this->answered = false;
        $this->userAnswer = null;
        
        Log::info('Question loaded - Images: [' . implode(', ', $this->currentImages) . '], Correct: ' . $this->correctAnswer);
    }

    public function handleSpacePress()
    {
        if ($this->isCompleted) {
            return redirect('http://127.0.0.1:8000/instructionEnergy');
        }
        
        // Hanya untuk simulasi Q1 saja
        if ($this->isSimulation && $this->currentQuestion == 1) {
            $this->currentQuestion++;
            $this->answered = false;
            $this->userAnswer = null;
            $this->loadQuestion();
        }
    }

    public function testMethod()
    {
        // Method sederhana untuk test
        $this->currentQuestion++;
        if ($this->currentQuestion > 10) {
            $this->currentQuestion = 1;
        }
    }

    public function forceNext()
    {
        $this->currentQuestion = 2;
        $this->isSimulation = true;
        $this->answered = false;
        $this->loadQuestion();
        $this->dispatch('$refresh');
    }

    public function handleAnswer($position)
    {
        if ($this->answered && !$this->isTransition) {
            return; // Prevent multiple answers (kecuali di transisi)
        }
        
        // Handle transisi - dari transisi ke tes sesungguhnya
        if ($this->isTransition) {
            $this->isTransition = false;
            $this->currentQuestion = 1;
            $this->answered = false;
            $this->userAnswer = null;
            $this->loadQuestion();
            return;
        }
        
        $this->answered = true;
        $this->userAnswer = $position;
        
        if (!$this->isSimulation) {
            // Real question - save and score
            $isCorrect = ($position == $this->correctAnswer);
            if ($isCorrect) {
                $this->totalCorrect++;
            }
            
            // Save to database
            TestResult::create([
                'test_session_id' => $this->testSession->id,
                'question_number' => $this->currentQuestion,
                'question_data' => [
                    'images' => $this->currentImages,
                    'is_simulation' => false,
                ],
                'correct_answer' => $this->correctAnswer,
                'user_answer' => $position,
                'is_correct' => $isCorrect,
                'response_time' => 0,
                'timeout' => false,
                'question_started_at' => now(),
                'answered_at' => now(),
            ]);
        }
        
        // Auto advance untuk simulasi dan tes sesungguhnya
        $this->currentQuestion++;
        
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

    public function nextQuestion()
    {
        $this->currentQuestion++;
        Log::info('Moving to question: ' . $this->currentQuestion);
        
        // Check if simulation complete
        if ($this->isSimulation && $this->currentQuestion > $this->simulationQuestions) {
            $this->isSimulation = false;
            $this->currentQuestion = 1; // Start real test at Q1
            Log::info('Simulation complete, starting real test');
        }
        
        // Check if test complete
        if (!$this->isSimulation && $this->currentQuestion > $this->totalQuestions) {
            $this->completeTest();
            return;
        }
        
        // Reset answered state
        $this->answered = false;
        $this->userAnswer = null;
        
        // Load next question
        $this->loadQuestion();
        
        Log::info('Question updated - Current Q: ' . $this->currentQuestion . ', Simulation: ' . ($this->isSimulation ? 'true' : 'false'));
    }

    public function completeTest()
    {
        $this->isCompleted = true;
        $this->accuracy = round(($this->totalCorrect / $this->totalQuestions) * 100, 1);
        
        // Update test session
        $this->testSession->update([
            'status' => 'completed',
            'completed_at' => now(),
            'total_score' => $this->totalCorrect,
            'accuracy_percentage' => $this->accuracy,
        ]);
        
        Log::info('Test completed - Score: ' . $this->totalCorrect . '/' . $this->totalQuestions . ' (' . $this->accuracy . '%)');
    }

    public function render()
    {
        return view('livewire.tests.speed-task');
    }
}