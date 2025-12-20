<?php

namespace App\Livewire\Tests;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TestSession;
use App\Models\TestResult;
use App\Models\TestAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

#[Layout('components.layouts.task-standalone')]
class SpeedTask extends Component
{
    private const TIMEOUT_MS = 1200;

    protected $listeners = ['spacePressed' => 'handleSpacePress', 'numberPressed' => 'handleAnswer'];

    public $currentQuestion = 1;
    public $totalQuestions;
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
    public $showFeedback = false;
    public $feedbackType = null; // 'correct', 'wrong', 'timeout'
    public $timeoutOccurred = false;
    public $inputDisabled = false;
    public $questionStartTime = null;
    public $questionUid = null; // Unique token per rendered question; prevents stale timers from previous questions
    public $debugTimer = false; // For local debugging
    public $remainingTime = self::TIMEOUT_MS; // Debug timer countdown

    public $testSession;

    // Test data array berdasarkan data yang benar
    public $testData = [
        ['shape_target' => 1, 'shape_distractor' => 12, 'correct_response' => 2],
        ['shape_target' => 12, 'shape_distractor' => 1, 'correct_response' => 1],
        ['shape_target' => 1, 'shape_distractor' => 10, 'correct_response' => 2],
        ['shape_target' => 10, 'shape_distractor' => 3, 'correct_response' => 1],
        ['shape_target' => 3, 'shape_distractor' => 14, 'correct_response' => 1],
        // ['shape_target' => 14, 'shape_distractor' => 1, 'correct_response' => 2],
        // ['shape_target' => 1, 'shape_distractor' => 14, 'correct_response' => 1],
        // ['shape_target' => 14, 'shape_distractor' => 4, 'correct_response' => 2],
        // ['shape_target' => 4, 'shape_distractor' => 13, 'correct_response' => 1],
        // ['shape_target' => 13, 'shape_distractor' => 1, 'correct_response' => 2],
        // ['shape_target' => 1, 'shape_distractor' => 10, 'correct_response' => 1],
        // ['shape_target' => 10, 'shape_distractor' => 5, 'correct_response' => 2],
        // ['shape_target' => 5, 'shape_distractor' => 9, 'correct_response' => 1],
        // ['shape_target' => 9, 'shape_distractor' => 5, 'correct_response' => 2],
        // ['shape_target' => 5, 'shape_distractor' => 14, 'correct_response' => 2],
        // ['shape_target' => 14, 'shape_distractor' => 3, 'correct_response' => 2],
        // ['shape_target' => 3, 'shape_distractor' => 13, 'correct_response' => 1],
        // ['shape_target' => 13, 'shape_distractor' => 6, 'correct_response' => 1],
        // ['shape_target' => 6, 'shape_distractor' => 14, 'correct_response' => 2],
        // ['shape_target' => 14, 'shape_distractor' => 4, 'correct_response' => 1],
        // ['shape_target' => 4, 'shape_distractor' => 14, 'correct_response' => 1],
        // ['shape_target' => 14, 'shape_distractor' => 1, 'correct_response' => 1],
        // ['shape_target' => 1, 'shape_distractor' => 15, 'correct_response' => 2],
        // ['shape_target' => 15, 'shape_distractor' => 3, 'correct_response' => 2],
        // ['shape_target' => 3, 'shape_distractor' => 12, 'correct_response' => 1],
        // ['shape_target' => 12, 'shape_distractor' => 7, 'correct_response' => 2],
        // ['shape_target' => 7, 'shape_distractor' => 9, 'correct_response' => 1],
        // ['shape_target' => 9, 'shape_distractor' => 3, 'correct_response' => 1],
        // ['shape_target' => 3, 'shape_distractor' => 11, 'correct_response' => 2],
        // ['shape_target' => 11, 'shape_distractor' => 3, 'correct_response' => 2],
        // ['shape_target' => 3, 'shape_distractor' => 8, 'correct_response' => 2],
        // ['shape_target' => 8, 'shape_distractor' => 7, 'correct_response' => 1],
        // ['shape_target' => 7, 'shape_distractor' => 8, 'correct_response' => 1],
        // ['shape_target' => 8, 'shape_distractor' => 2, 'correct_response' => 1],
        // ['shape_target' => 2, 'shape_distractor' => 12, 'correct_response' => 2],
        // ['shape_target' => 12, 'shape_distractor' => 1, 'correct_response' => 2],
        // ['shape_target' => 1, 'shape_distractor' => 15, 'correct_response' => 2],
        // ['shape_target' => 15, 'shape_distractor' => 2, 'correct_response' => 2],
        // ['shape_target' => 2, 'shape_distractor' => 8, 'correct_response' => 1],
        // ['shape_target' => 8, 'shape_distractor' => 6, 'correct_response' => 1],
        // ['shape_target' => 6, 'shape_distractor' => 8, 'correct_response' => 2],
        // ['shape_target' => 8, 'shape_distractor' => 2, 'correct_response' => 1],
        // ['shape_target' => 2, 'shape_distractor' => 11, 'correct_response' => 2],
        // ['shape_target' => 11, 'shape_distractor' => 2, 'correct_response' => 2],
        // ['shape_target' => 2, 'shape_distractor' => 9, 'correct_response' => 1],
        // ['shape_target' => 9, 'shape_distractor' => 11, 'correct_response' => 1],
        // ['shape_target' => 1, 'shape_distractor' => 3, 'correct_response' => 1],
        // ['shape_target' => 8, 'shape_distractor' => 10, 'correct_response' => 2],
        // ['shape_target' => 4, 'shape_distractor' => 6, 'correct_response' => 1],
        // ['shape_target' => 6, 'shape_distractor' => 9, 'correct_response' => 2],
    ];

    public static function getNextTestType($userId)
    {
        // Check completion status in order
        $speedCompleted = TestSession::where('user_id', $userId)
            ->where('test_type', 'speed')
            ->where('status', 'completed')
            ->exists();

        if (!$speedCompleted) {
            return 'speed';
        }

        $energyCompleted = TestSession::where('user_id', $userId)
            ->where('test_type', 'energy')
            ->where('status', 'completed')
            ->exists();

        if (!$energyCompleted) {
            return 'energy';
        }

        $capacityCompleted = TestSession::where('user_id', $userId)
            ->where('test_type', 'capacity')
            ->where('status', 'completed')
            ->exists();

        if (!$capacityCompleted) {
            return 'capacity';
        }

        return null; // All tests completed
    }

    private function resumeSession()
    {
        // Count only real test results (simulation not saved to DB)
        $realTestResults = TestResult::where('test_session_id', $this->testSession->id)
            ->whereJsonContains('question_data->is_simulation', false)
            ->count();

        $this->totalCorrect = TestResult::where('test_session_id', $this->testSession->id)
            ->where('is_correct', true)
            ->whereJsonContains('question_data->is_simulation', false)
            ->count();

        // Determine current state based on real test results only
        if ($realTestResults == 0) {
            // No real test results yet - could be in simulation or transition
            // Start from simulation since we don't track simulation progress
            $this->isSimulation = true;
            $this->currentQuestion = 1;
            $this->isTransition = false;
        } else {
            // In real test
            $this->isSimulation = false;
            $this->isTransition = false;
            $this->currentQuestion = $realTestResults + 1;

            // Check if test should be complete
            if ($this->currentQuestion > $this->totalQuestions) {
                $this->completeTest();
                return;
            }
        }

        $this->answered = false;
    }

    public function mount()
    {
        Log::info('=== MOUNT START ===');

        // Set total questions dynamically from test data
        $this->totalQuestions = count($this->testData);

        // Check for existing in-progress session
        $existingSession = TestSession::where('user_id', Auth::id())
            ->where('test_type', 'speed')
            ->where('status', 'in_progress')
            ->first();

        if ($existingSession) {
            // Delete existing session and its results for fresh start
            Log::info('Found existing session, deleting for fresh start');

            // Delete any existing results
            TestResult::where('test_session_id', $existingSession->id)->delete();

            // Delete the session
            $existingSession->delete();

            // Create new session
            $this->testSession = TestSession::create([
                'user_id' => Auth::id(),
                'test_type' => 'speed',
                'status' => 'in_progress',
                'started_at' => now(),
                'total_questions' => $this->totalQuestions,
            ]);

            // Start fresh
            $this->isSimulation = true;
            $this->currentQuestion = 1;
            $this->answered = false;

            Log::info('Deleted old session, created new one');
        } else {
            // Create new session
            $this->testSession = TestSession::create([
                'user_id' => Auth::id(),
                'test_type' => 'speed',
                'status' => 'in_progress',
                'started_at' => now(),
                'total_questions' => $this->totalQuestions,
            ]);

            // Start fresh
            $this->isSimulation = true;
            $this->currentQuestion = 1;
            $this->answered = false;
        }

        $this->inputDisabled = false;
        $this->debugTimer = config('app.env') === 'local';
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
                $this->correctAnswer = null; // No scoring for Q1
            } elseif ($this->currentQuestion == 2) {
                $this->currentImages = [13, 4]; // Simulasi 2 - 13 from previous
                $this->correctAnswer = 1; // 13 is from previous question, position 1
            } elseif ($this->currentQuestion == 3) {
                $this->currentImages = [10, 4]; // Simulasi 3
                $this->correctAnswer = 2; // Set correct answer for demo feedback
            }
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
        $this->inputDisabled = false;
        $this->timeoutOccurred = false;
        $this->questionStartTime = microtime(true);
        $this->questionUid = (string) Str::uuid();

        Log::info('Question loaded - Images: [' . implode(', ', $this->currentImages) . '], Correct: ' . $this->correctAnswer);

        // Notify browser that a new question (token) has started so it can reset the timer.
        // This is the safest way to avoid chained timeouts across Livewire re-renders.
        $this->dispatch(
            'question-changed',
            questionUid: $this->questionUid,
            isSimulation: $this->isSimulation,
            isTransition: $this->isTransition,
            isCompleted: $this->isCompleted,
            showFeedback: $this->showFeedback,
            inputDisabled: $this->inputDisabled,
            timeoutMs: self::TIMEOUT_MS,
            debugTimer: $this->debugTimer,
        );

        // Dispatch event to start timer for real questions, but not during feedback
        if (!$this->isSimulation && !$this->isTransition && !$this->isCompleted && !$this->showFeedback) {
            $this->dispatch('question-loaded');
        }
    }

    public function handleSpacePress()
    {
        if ($this->isCompleted) {
            // Force refresh the session status from database
            $this->testSession->refresh();

            $nextTest = self::getNextTestType(Auth::id());
            if ($nextTest === 'energy') {
                return redirect()->route('instructionEnergy');
            } else {
                return redirect()->route('dashboard');
            }
        }

        // Hanya untuk simulasi Q1 saja
        if ($this->isSimulation && $this->currentQuestion == 1 && !$this->inputDisabled) {
            $this->inputDisabled = true;
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

    public function handleTimeout($questionUid = null, $clientResponseTime = null)
    {
        // Back-compat: old client called handleTimeout(1200)
        if (is_numeric($questionUid) && $clientResponseTime === null) {
            $clientResponseTime = $questionUid;
            $questionUid = null;
        }

        // Ignore stale timer events from previous question renders
        if (is_string($questionUid) && $this->questionUid && $questionUid !== $this->questionUid) {
            return;
        }

        if ($this->inputDisabled || $this->answered || $this->isSimulation || $this->isTransition || $this->isCompleted) {
            return;
        }

        // Stop client timers ASAP
        $this->dispatch('clear-timer');

        $this->inputDisabled = true;
        $this->answered = true;
        $this->timeoutOccurred = true;
        $this->feedbackType = 'timeout';

        // IMPORTANT: keep timeout duration fixed; server-side questionStartTime differs from
        // when the client timer actually starts (network + render delay), which can make
        // computed durations look random.
        $responseTime = self::TIMEOUT_MS;
        if (is_numeric($clientResponseTime)) {
            $clientResponseTime = (int) round($clientResponseTime);
            if ($clientResponseTime > 0 && $clientResponseTime < 60000) {
                $responseTime = $clientResponseTime;
            }
        }

        // Save timeout result
        TestResult::create([
            'test_session_id' => $this->testSession->id,
            'question_number' => $this->currentQuestion,
            'question_data' => [
                'images' => $this->currentImages,
                'is_simulation' => false,
            ],
            'correct_answer' => $this->correctAnswer,
            'user_answer' => null,
            'is_correct' => false,
            'response_time' => $responseTime,
            'timeout' => true,
            'question_started_at' => now()->subMilliseconds($responseTime),
            'answered_at' => now(),
        ]);

        // Update session total time
        $this->updateSessionTotalTime();

        $this->showFeedback = true;
        $this->dispatch('show-feedback');
    }

    public function handleAnswer($position, $questionUid = null, $clientResponseTime = null)
    {
        // Back-compat: old client called handleAnswer(pos, rt)
        if (is_numeric($questionUid) && $clientResponseTime === null) {
            $clientResponseTime = $questionUid;
            $questionUid = null;
        }

        // Ignore stale key presses from previous question renders
        if (is_string($questionUid) && $this->questionUid && $questionUid !== $this->questionUid) {
            return;
        }

        if ($this->inputDisabled || ($this->answered && !$this->isTransition)) {
            return; // Prevent multiple answers and disabled input
        }

        // Disable input immediately
        $this->inputDisabled = true;

        // Handle transisi - hanya tombol yang handle, tidak ada keyboard input
        if ($this->isTransition) {
            // Keyboard input tidak melakukan apa-apa di transisi
            $this->inputDisabled = false;
            return;
        }

        $this->answered = true;
        $this->userAnswer = $position;

        // Calculate response time
        $responseTime = ($this->questionStartTime) ?
            round((microtime(true) - $this->questionStartTime) * 1000) : 0;

        // Prefer client-side timing (aligns with when the timer actually started in the browser).
        if (is_numeric($clientResponseTime)) {
            $clientResponseTime = (int) round($clientResponseTime);
            if ($clientResponseTime >= 0 && $clientResponseTime < 60000) {
                $responseTime = $clientResponseTime;
            }
        }

        // Hard guard: we never accept answers beyond the test timeout.
        // Client should already block this, but this makes the server authoritative too.
        if (!$this->isSimulation && $responseTime > self::TIMEOUT_MS) {
            $this->inputDisabled = false;
            $this->answered = false;
            return;
        }

        if (!$this->isSimulation) {
            // Real question - save and score
            $isCorrect = ($position == $this->correctAnswer);

            if ($isCorrect) {
                $this->totalCorrect++;
                $this->feedbackType = 'correct';
            } else {
                $this->feedbackType = 'wrong';
            }

            // Save to database
            $testResult = TestResult::create([
                'test_session_id' => $this->testSession->id,
                'question_number' => $this->currentQuestion,
                'question_data' => [
                    'images' => $this->currentImages,
                    'is_simulation' => false,
                ],
                'correct_answer' => $this->correctAnswer,
                'user_answer' => $position,
                'is_correct' => $isCorrect,
                'response_time' => $responseTime,
                'timeout' => false,
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

        // For simulation question 2-3, check if answer is correct
        if ($this->isSimulation && ($this->currentQuestion == 2 || $this->currentQuestion == 3)) {
            $isCorrect = ($position == $this->correctAnswer);

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
        // Clear timer explicitly before proceeding
        $this->dispatch('clear-timer');

        $this->showFeedback = false;
        $this->feedbackType = null;

        // Auto advance untuk simulasi dan tes sesungguhnya
        $this->currentQuestion++;

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
        // Clear timer explicitly before retry
        $this->dispatch('clear-timer');

        $this->showFeedback = false;
        $this->feedbackType = null;
        $this->answered = false;
        $this->userAnswer = null;
        $this->inputDisabled = false;

        // Reset the same question to try again
        $this->loadQuestion();
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

        $this->loadQuestion();
    }

    public function proceedToRealTest()
    {
        // Clear any existing timers first
        $this->dispatch('clear-timer');

        // Proceed directly to real test from transition
        $this->isTransition = false;
        $this->isSimulation = false;
        $this->currentQuestion = 1;
        $this->answered = false;
        $this->userAnswer = null;
        $this->inputDisabled = false;
        $this->showFeedback = false;
        $this->feedbackType = null;

        $this->loadQuestion();
        // Force refresh the component state
        $this->dispatch('$refresh');
    }
    public function completeTest()
    {
        $this->isCompleted = true;
        $this->accuracy = round(($this->totalCorrect / $this->totalQuestions) * 100, 1);

        // Calculate final statistics
        $avgResponseTime = TestResult::where('test_session_id', $this->testSession->id)
            ->whereJsonContains('question_data->is_simulation', false)
            ->where('timeout', false)
            ->avg('response_time');

        // Update session total time
        $this->updateSessionTotalTime();

        // Update test session
        $this->testSession->update([
            'status' => 'completed',
            'completed_at' => now(),
            'total_questions' => $this->totalQuestions,
            'correct_answers' => $this->totalCorrect,
            'wrong_answers' => $this->totalQuestions - $this->totalCorrect,
            'average_response_time' => $avgResponseTime ? round($avgResponseTime, 2) : 0,
        ]);

        Log::info('Test completed - Score: ' . $this->totalCorrect . '/' . $this->totalQuestions . ' (' . $this->accuracy . '%)');
    }



    public function render()
    {
        return view('livewire.tests.speed-task');
    }
}
