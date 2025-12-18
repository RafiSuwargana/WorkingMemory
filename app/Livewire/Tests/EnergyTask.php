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
    protected $listeners = [
        'spacePressed' => 'handleSpacePress',
        'numberPressed' => 'handleAnswer',
        'preloadComplete' => 'handlePreloadComplete',
        'preloadProgress' => 'updatePreloadProgress'
    ];

    public $currentQuestion = 1;
    public $totalQuestions = 0; // Akan diisi otomatis berdasarkan jumlah testData
    public $simulationQuestions = 4; // 4 simulasi untuk energy task

    public $isSimulation = true;
    public $isCompleted = false;
    public $isTransition = false;
    public $isPreloading = true; // Fase preload gambar
    public $preloadProgress = 0; // Progress preload (0-100%)

    public $currentImage = null; // Energy task hanya 1 gambar per tampilan
    public $previousTotal = 0; // Menyimpan total sebelumnya untuk penjumlahan

    public $answered = false;
    public $userAnswer = null;

    public $totalCorrect = 0;
    public $accuracy = 0;
    public $showFeedback = false;
    public $feedbackType = null; // 'correct', 'wrong', 'slow'
    public $timeoutOccurred = false;
    public $inputDisabled = false;
    public $questionStartTime = null;
    public $debugTimer = false; // For local debugging
    public $remainingTime = 15000; // Debug timer countdown

    public $testSession;

    // Test data untuk 49 soal tes sesungguhnya
    public $testData = [
        ['stim' => 'B1', 'correct_response' => 2],
        ['stim' => 'B4', 'correct_response' => 5],
        ['stim' => 'B44', 'correct_response' => 8],
        ['stim' => 'B3', 'correct_response' => 7],
        ['stim' => 'B33', 'correct_response' => 6],
        // ['stim' => 'B0', 'correct_response' => 3],
        // ['stim' => 'B2', 'correct_response' => 2],
        // ['stim' => 'B33', 'correct_response' => 5],
        // ['stim' => 'B3', 'correct_response' => 6],
        // ['stim' => 'B2', 'correct_response' => 5],
        // ['stim' => 'B55', 'correct_response' => 7],
        // ['stim' => 'B444', 'correct_response' => 9],
        // ['stim' => 'B4', 'correct_response' => 8],
        // ['stim' => 'B1', 'correct_response' => 5],
        // ['stim' => 'B1', 'correct_response' => 2],
        // ['stim' => 'B0', 'correct_response' => 1],
        // ['stim' => 'B0', 'correct_response' => 0],
        // ['stim' => 'B4', 'correct_response' => 4],
        // ['stim' => 'B3', 'correct_response' => 7],
        // ['stim' => 'B33', 'correct_response' => 6],
        // ['stim' => 'B3', 'correct_response' => 6],
        // ['stim' => 'B33', 'correct_response' => 6],
        // ['stim' => 'B2', 'correct_response' => 5],
        // ['stim' => 'B5', 'correct_response' => 7],
        // ['stim' => 'B1', 'correct_response' => 6],
        // ['stim' => 'B1', 'correct_response' => 2],
        // ['stim' => 'B0', 'correct_response' => 1],
        // ['stim' => 'B10', 'correct_response' => 0],
        // ['stim' => 'B0', 'correct_response' => 0],
        // ['stim' => 'B2', 'correct_response' => 2],
        // ['stim' => 'B3', 'correct_response' => 5],
        // ['stim' => 'B4', 'correct_response' => 7],
        // ['stim' => 'B666', 'correct_response' => 0],
        // ['stim' => 'B7', 'correct_response' => 3],
        // ['stim' => 'B4', 'correct_response' => 1],
        // ['stim' => 'B77', 'correct_response' => 1],
        // ['stim' => 'B0', 'correct_response' => 7],
        // ['stim' => 'B8', 'correct_response' => 8],
        // ['stim' => 'B2', 'correct_response' => 0],
        // ['stim' => 'B4', 'correct_response' => 6],
        // ['stim' => 'B444', 'correct_response' => 8],
        // ['stim' => 'B8', 'correct_response' => 2],
        // ['stim' => 'B1', 'correct_response' => 9],
        // ['stim' => 'B3', 'correct_response' => 4],
        // ['stim' => 'B0', 'correct_response' => 3],
        // ['stim' => 'B5', 'correct_response' => 5],
        // ['stim' => 'B1', 'correct_response' => 6],
        // ['stim' => 'B8', 'correct_response' => 9],
        // ['stim' => 'B1', 'correct_response' => 9],
    ];

    public function mount()
    {
        Log::info('=== ENERGY MOUNT START ===');

        // Set total questions based on testData array length
        $this->totalQuestions = count($this->testData);

        // Check for existing in-progress session
        $existingSession = TestSession::where('user_id', Auth::id())
            ->where('test_type', 'energy')
            ->where('status', 'in_progress')
            ->first();

        if ($existingSession) {
            // Delete existing session and its results for fresh start
            Log::info('Found existing energy session, deleting for fresh start');

            // Delete any existing results
            TestResult::where('test_session_id', $existingSession->id)->delete();

            // Delete the session
            $existingSession->delete();

            Log::info('Deleted old energy session, creating new one');
        }

        // Create new session
        $this->testSession = TestSession::create([
            'user_id' => Auth::id(),
            'test_type' => 'energy',
            'status' => 'in_progress',
            'started_at' => now(),
            'total_questions' => $this->totalQuestions,
        ]);

        // Start fresh
        $this->isSimulation = true;
        $this->currentQuestion = 1;
        $this->answered = false;
        $this->previousTotal = 0;
        $this->inputDisabled = false;
        $this->debugTimer = config('app.env') === 'local';

        $this->loadQuestion();
        Log::info('Energy test mounted - Question: ' . $this->currentQuestion . ', Simulation: ' . ($this->isSimulation ? 'true' : 'false'));
        Log::info('=== ENERGY MOUNT END ===');
    }

    public function loadQuestion()
    {
        Log::info('Loading energy question - Q' . $this->currentQuestion . ', Simulation: ' . ($this->isSimulation ? 'true' : 'false'));

        if ($this->isSimulation) {
            // Simulation questions with proper image assignment
            if ($this->currentQuestion == 1) {
                $this->currentImage = 'B3'; // Simulasi 1: B3.png (3 dots)
                $this->previousTotal = 0; // Start with 0, user should remember 3 dots
            } elseif ($this->currentQuestion == 2) {
                $this->currentImage = 'B33'; // Simulasi 2: B33.png (3 dots)
                $this->previousTotal = 3; // Previous image B3 had 3 dots
            } elseif ($this->currentQuestion == 3) {
                $this->currentImage = 'B0'; // Simulasi 3: B0.png (0 dots)
                $this->previousTotal = 3; // Previous image B33 had 3 dots
            } elseif ($this->currentQuestion == 4) {
                $this->currentImage = 'B6'; // Simulasi 4: B6.png (6 dots)
                $this->previousTotal = 0; // Previous image B0 had 0 dots
            }
        } else {
            // Real test questions
            $questionIndex = $this->currentQuestion - 1;
            if (isset($this->testData[$questionIndex])) {
                $data = $this->testData[$questionIndex];
                $this->currentImage = $data['stim'];
                // previousTotal will be tracked from previous answers
            }
        }

        // Reset answer state
        $this->answered = false;
        $this->userAnswer = null;
        $this->inputDisabled = false;
        $this->timeoutOccurred = false;
        $this->questionStartTime = microtime(true);

        Log::info('Energy question loaded - Image: ' . $this->currentImage . ', Previous Total: ' . $this->previousTotal);

        // Dispatch event to start timer for real questions, but not during feedback
        if (!$this->isSimulation && !$this->isTransition && !$this->isCompleted && !$this->showFeedback) {
            $this->dispatch('question-loaded');
        }
    }

    public function handleSpacePress()
    {
        if ($this->isCompleted) {
            $nextTest = \App\Livewire\Tests\SpeedTask::getNextTestType(Auth::id());
            if ($nextTest === 'capacity') {
                return redirect()->route('instructionCapacity');
            } else {
                return redirect()->route('dashboard');
            }
        }

        // Untuk simulasi 1 saja (seperti speed task)
        if ($this->isSimulation && $this->currentQuestion == 1 && !$this->inputDisabled) {
            $this->inputDisabled = true;
            $this->currentQuestion++;
            $this->answered = false;
            $this->userAnswer = null;
            $this->loadQuestion();
        }
    }

    public function handleTimeout()
    {
        if ($this->answered || $this->isSimulation || $this->isTransition || $this->isCompleted || $this->timeoutOccurred) {
            return;
        }

        // Set flag bahwa timeout terjadi, tapi jangan disable input
        // Biarkan user tetap bisa menjawab
        $this->timeoutOccurred = true;

        Log::info('Timeout occurred on question ' . $this->currentQuestion . ', waiting for user answer');
    }

    public function handleAnswer($answer)
    {
        if ($this->inputDisabled || ($this->answered && !$this->isTransition)) {
            return; // Prevent multiple answers and disabled input
        }

        // Disable input immediately
        $this->inputDisabled = true;

        // Handle transisi - keyboard input untuk restart simulasi saja
        if ($this->isTransition) {
            if ($answer == 1) {
                // Restart simulation (jika dibutuhkan)
                $this->restartSimulation();
                return;
            }
            // Input lain tidak melakukan apa-apa di transisi
            return;
        }

        $this->answered = true;
        $this->userAnswer = $answer;

        // Calculate response time
        $responseTime = ($this->questionStartTime) ?
            round((microtime(true) - $this->questionStartTime) * 1000) : 0;

        if (!$this->isSimulation) {
            // Real question - save and score
            $questionIndex = $this->currentQuestion - 1;
            $correctAnswer = isset($this->testData[$questionIndex]) ? $this->testData[$questionIndex]['correct_response'] : 0;

            // For 2-digit numbers, user should input the last digit
            $expectedInput = $correctAnswer;
            if ($correctAnswer >= 10) {
                $expectedInput = $correctAnswer % 10; // Get last digit
            }

            $isCorrect = ($answer == $expectedInput);

            // Check if timeout occurred - if yes, always mark as slow and incorrect
            if ($this->timeoutOccurred) {
                $this->feedbackType = 'slow';
                $isCorrect = false; // Always incorrect if timeout
            } else {
                if ($isCorrect) {
                    $this->feedbackType = 'correct';
                } else {
                    $this->feedbackType = 'wrong';
                }
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
                'response_time' => $responseTime,
                'timeout' => $this->timeoutOccurred,
                'question_started_at' => now()->subMilliseconds($responseTime),
                'answered_at' => now(),
            ]);

            // Update session total time
            $this->updateSessionTotalTime();

            // Show feedback
            $this->showFeedback = true;
            $this->dispatch('show-feedback');
            return;
        }

        // For simulation question 2-4, check if answer is correct
        if ($this->isSimulation && ($this->currentQuestion >= 2 && $this->currentQuestion <= 4)) {
            // Set correct answers for simulation feedback based on image and previous total
            $correctAnswer = 0;
            $expectedInput = 0;

            if ($this->currentQuestion == 2) {
                // Image B33 (3 dots) + previous image B3 (3 dots) = 6
                $correctAnswer = 6; // 3 + 3 = 6
                $expectedInput = 6; // Single digit, input 6
            } elseif ($this->currentQuestion == 3) {
                // Image B0 (0 dots) + previous image B33 (3 dots) = 3
                $correctAnswer = 3; // 0 + 3 = 3
                $expectedInput = 3; // Single digit, input 3
            } elseif ($this->currentQuestion == 4) {
                // Image B6 (6 dots) + previous image B0 (0 dots) = 6
                $correctAnswer = 6; // 6 + 0 = 6
                $expectedInput = 6; // Single digit, input 6
            }

            $isCorrect = ($answer == $expectedInput);

            if ($isCorrect) {
                $this->feedbackType = 'correct';
                // Show feedback and then proceed
                $this->showFeedback = true;
                $this->dispatch('show-feedback');
            } else {
                $this->feedbackType = 'wrong';
                // Show feedback but don't proceed, reset to try again
                $this->showFeedback = true;
                $this->dispatch('show-feedback-retry');
            }
            return;
        }

        // For simulation question 1, auto advance without feedback
        $this->proceedAfterFeedback();
    }

    private function updateSessionTotalTime()
    {
        $totalTime = TestResult::where('test_session_id', $this->testSession->id)
            ->whereJsonContains('question_data->is_simulation', false)
            ->sum('response_time');

        $this->testSession->update([
            'total_time' => $totalTime
        ]);
    }

    public function proceedAfterFeedback()
    {
        $this->showFeedback = false;
        $this->feedbackType = null;

        // Auto advance untuk simulasi dan tes sesungguhnya
        $this->currentQuestion++;

        // Update previous total untuk simulasi berdasarkan dots dari image sebelumnya
        if ($this->isSimulation) {
            if ($this->currentQuestion == 3) {
                $this->previousTotal = 3; // Previous image B33 had 3 dots
            } elseif ($this->currentQuestion == 4) {
                $this->previousTotal = 0; // Previous image B0 had 0 dots
            } elseif ($this->currentQuestion == 5) {
                $this->previousTotal = 6; // Previous image B6 had 6 dots (for transition)
            }
        }

        if ($this->isSimulation && $this->currentQuestion > $this->simulationQuestions) {
            // Setelah simulasi selesai, masuk ke state transisi
            $this->isSimulation = false;
            $this->isTransition = true;
            $this->currentQuestion = 1;
            $this->answered = false;
            $this->userAnswer = null;
            $this->inputDisabled = false;
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

    public function proceedAfterRetry()
    {
        $this->showFeedback = false;
        $this->feedbackType = null;
        $this->answered = false;
        $this->userAnswer = null;
        $this->inputDisabled = false;

        // Reset the same question to try again
        $this->loadQuestion();
    }

    private function completeTest()
    {
        $this->isCompleted = true;
        $this->inputDisabled = true;

        // Calculate final statistics
        $totalRealQuestions = TestResult::where('test_session_id', $this->testSession->id)
            ->whereJsonContains('question_data->is_simulation', false)
            ->count();

        $correctAnswers = TestResult::where('test_session_id', $this->testSession->id)
            ->whereJsonContains('question_data->is_simulation', false)
            ->where('is_correct', true)
            ->count();

        $wrongAnswers = $totalRealQuestions - $correctAnswers;

        // Calculate average response time (only for non-timeout answers)
        $avgResponseTime = TestResult::where('test_session_id', $this->testSession->id)
            ->whereJsonContains('question_data->is_simulation', false)
            ->where('timeout', false)
            ->avg('response_time');

        $this->accuracy = $totalRealQuestions > 0 ?
            round(($correctAnswers / $totalRealQuestions) * 100, 1) : 0;

        // Update session with complete statistics
        $this->testSession->update([
            'status' => 'completed',
            'completed_at' => now(),
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'accuracy' => $this->accuracy,
            'average_response_time' => $avgResponseTime ? round($avgResponseTime, 2) : 0
        ]);

        Log::info('Energy test completed - Total: ' . $correctAnswers . '/' . $totalRealQuestions . ', Accuracy: ' . $this->accuracy . '%, Avg Response: ' . ($avgResponseTime ? round($avgResponseTime, 2) : 'N/A') . 'ms');
    }

    public function restartSimulation()
    {
        // Reset to beginning of simulation
        $this->isSimulation = true;
        $this->isTransition = false;
        $this->currentQuestion = 1;
        $this->answered = false;
        $this->userAnswer = null;
        $this->inputDisabled = false;
        $this->showFeedback = false;
        $this->feedbackType = null;
        $this->previousTotal = 0;

        $this->loadQuestion();
    }

    public function proceedToRealTest()
    {
        // Proceed directly to real test from transition
        $this->isTransition = false;
        $this->isSimulation = false;
        $this->currentQuestion = 1;
        $this->answered = false;
        $this->userAnswer = null;
        $this->inputDisabled = false;
        $this->showFeedback = false;
        $this->feedbackType = null;
        $this->previousTotal = 0;

        $this->loadQuestion();
        // Force refresh the component state
        $this->dispatch('$refresh');
    }

    public function handlePreloadComplete()
    {
        Log::info('Energy images preload completed');
        $this->isPreloading = false;
        $this->preloadProgress = 100;
    }

    public function updatePreloadProgress($progress)
    {
        $this->preloadProgress = $progress;
        Log::info('Energy preload progress: ' . $progress . '%');
    }

    public function render()
    {
        return view('livewire.tests.energy-task');
    }
}
