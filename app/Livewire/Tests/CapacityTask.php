<?php

namespace App\Livewire\Tests;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\TestSession;
use App\Models\TestResult;
use App\Models\TestAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.app')]
class CapacityTask extends Component
{
    protected $listeners = [
        'spacePressed' => 'handleSpacePress', 
        'imageClicked' => 'handleImageClick',
        'preloadComplete' => 'handlePreloadComplete',
        'preloadProgress' => 'updatePreloadProgress'
    ];

    public $currentTrial = 1;
    public $totalTrials = 0; // Akan diisi otomatis berdasarkan jumlah testData

    public $isMemorizing = true; // Fase mengingat 2 gambar
    public $isTesting = false; // Fase tes dengan 8 gambar
    public $isCompleted = false;
    public $isTransition = false;
    public $isPreloading = true; // Fase preload gambar
    public $preloadProgress = 0; // Progress preload (0-100%)

    public $memoryImages = []; // 2 gambar yang harus diingat
    public $testImages = []; // 8 gambar untuk dipilih (termasuk 2 yang diingat)
    public $correctAnswers = []; // Index dari gambar yang benar

    public $answered = false;
    public $userAnswers = []; // Gambar yang dipilih user
    public $correctCount = 0;
    public $totalCorrect = 0;
    public $accuracy = 0;

    public $memorizeTimeLeft = 10; // Timer untuk fase memorisasi
    public $testSession;
    public $showDebugInfo = false; // Set true untuk melihat kunci jawaban

    public $timeoutOccurred = false;
    public $testStartTime = null;
    public $debugTimer = false;

    public $showFeedback = false;
    public $feedbackType = null; // 'correct', 'wrong'

    // Test data sesuai dengan data yang diberikan (lengkap dengan 8 alternatif)
    public $testData = [
        ['correct_response' => '13', 'stimuli' => [13, 6], 'alternatives' => [13, 1, 6, 3, 5, 9, 2, 4]],
        ['correct_response' => '23', 'stimuli' => [7, 24], 'alternatives' => [2, 7, 24, 17, 3, 4, 5, 16]],
        ['correct_response' => '47', 'stimuli' => [5, 1], 'alternatives' => [9, 10, 7, 5, 15, 6, 1, 3]],
        // ['correct_response' => '15', 'stimuli' => [2, 18], 'alternatives' => [2, 8, 6, 4, 18, 11, 7, 22]],
        // ['correct_response' => '67', 'stimuli' => [14, 15], 'alternatives' => [5, 7, 4, 8, 9, 14, 15, 1]],
        // ['correct_response' => '45', 'stimuli' => [15, 18], 'alternatives' => [3, 5, 9, 15, 18, 13, 16, 20]],
        // ['correct_response' => '67', 'stimuli' => [9, 4], 'alternatives' => [1, 13, 10, 7, 24, 9, 4, 5]],
        // ['correct_response' => '28', 'stimuli' => [26, 28], 'alternatives' => [3, 26, 7, 8, 10, 11, 5, 28]],
        // ['correct_response' => '45', 'stimuli' => [5, 11], 'alternatives' => [14, 25, 18, 5, 11, 2, 4, 9]],
        // ['correct_response' => '23', 'stimuli' => [13, 11], 'alternatives' => [1, 13, 11, 3, 4, 5, 7, 8]],
        // ['correct_response' => '135', 'stimuli' => [14, 30, 24], 'alternatives' => [14, 7, 30, 5, 24, 8, 9, 15]],
        // ['correct_response' => '246', 'stimuli' => [11, 9, 5], 'alternatives' => [13, 11, 7, 9, 4, 5, 6, 1]],
        // ['correct_response' => '145', 'stimuli' => [10, 23, 16], 'alternatives' => [10, 14, 8, 23, 16, 9, 7, 6]],
        // ['correct_response' => '234', 'stimuli' => [6, 9, 19], 'alternatives' => [1, 6, 9, 19, 17, 5, 3, 2]],
        // ['correct_response' => '578', 'stimuli' => [10, 5, 17], 'alternatives' => [19, 13, 6, 4, 10, 3, 5, 17]],
        // ['correct_response' => '467', 'stimuli' => [19, 23, 30], 'alternatives' => [11, 9, 8, 19, 7, 23, 30, 10]],
        // ['correct_response' => '567', 'stimuli' => [20, 6, 16], 'alternatives' => [2, 12, 4, 1, 20, 6, 16, 5]],
        // ['correct_response' => '368', 'stimuli' => [13, 7, 20], 'alternatives' => [17, 16, 13, 6, 5, 7, 9, 20]],
        // ['correct_response' => '258', 'stimuli' => [27, 5, 14], 'alternatives' => [15, 27, 1, 9, 5, 13, 12, 14]],
        // ['correct_response' => '157', 'stimuli' => [14, 25, 8], 'alternatives' => [14, 7, 6, 5, 25, 13, 8, 9]],
        // ['correct_response' => '3457', 'stimuli' => [19, 11, 15, 30], 'alternatives' => [1, 6, 19, 11, 15, 10, 30, 7]],
        // ['correct_response' => '1257', 'stimuli' => [19, 14, 24, 1], 'alternatives' => [19, 14, 7, 4, 24, 12, 1, 5]],
        // ['correct_response' => '2467', 'stimuli' => [4, 2, 14, 6], 'alternatives' => [11, 4, 19, 2, 17, 14, 6, 7]],
        // ['correct_response' => '1568', 'stimuli' => [9, 13, 5, 23], 'alternatives' => [9, 1, 14, 8, 13, 5, 21, 23]],
        // ['correct_response' => '2346', 'stimuli' => [16, 23, 22, 11], 'alternatives' => [5, 16, 23, 22, 4, 11, 3, 2]],
        // ['correct_response' => '3456', 'stimuli' => [9, 19, 12, 8], 'alternatives' => [2, 7, 9, 19, 12, 8, 4, 10]],
        // ['correct_response' => '1457', 'stimuli' => [8, 22, 16, 18], 'alternatives' => [8, 6, 10, 22, 16, 21, 18, 23]],
        // ['correct_response' => '2358', 'stimuli' => [27, 3, 22, 23], 'alternatives' => [2, 27, 3, 13, 22, 16, 25, 23]],
        // ['correct_response' => '3567', 'stimuli' => [2, 22, 5, 6], 'alternatives' => [11, 12, 2, 7, 22, 5, 6, 10]],
        // ['correct_response' => '2578', 'stimuli' => [8, 17, 20, 10], 'alternatives' => [5, 8, 9, 11, 17, 13, 20, 10]],
        // ['correct_response' => '12367', 'stimuli' => [8, 14, 13, 10, 12], 'alternatives' => [8, 14, 13, 9, 2, 10, 12, 6]],
        // ['correct_response' => '25678', 'stimuli' => [25, 4, 17, 21, 19], 'alternatives' => [24, 25, 3, 6, 4, 17, 21, 19]],
        // ['correct_response' => '23567', 'stimuli' => [14, 18, 26, 12, 30], 'alternatives' => [5, 14, 18, 6, 26, 12, 30, 2]],
        // ['correct_response' => '14678', 'stimuli' => [3, 6, 2, 4, 16], 'alternatives' => [3, 9, 5, 6, 11, 2, 4, 16]],
        // ['correct_response' => '23567', 'stimuli' => [13, 12, 25, 19, 21], 'alternatives' => [11, 13, 12, 8, 25, 19, 21, 9]],
        // ['correct_response' => '12568', 'stimuli' => [30, 19, 6, 11, 29], 'alternatives' => [30, 19, 3, 9, 6, 11, 7, 29]],
        // ['correct_response' => '24678', 'stimuli' => [11, 29, 16, 1, 27], 'alternatives' => [12, 11, 5, 29, 8, 16, 1, 27]],
        // ['correct_response' => '23456', 'stimuli' => [21, 26, 19, 13, 2], 'alternatives' => [7, 21, 26, 19, 13, 2, 9, 3]],
        // ['correct_response' => '34678', 'stimuli' => [20, 4, 22, 24, 19], 'alternatives' => [16, 10, 20, 4, 9, 22, 24, 19]],
        // ['correct_response' => '45678', 'stimuli' => [9, 28, 27, 30, 3], 'alternatives' => [21, 25, 5, 9, 28, 27, 30, 3]],
        // ['correct_response' => '135678', 'stimuli' => [26, 27, 22, 19, 10, 14], 'alternatives' => [26, 2, 27, 6, 22, 19, 10, 14]],
        // ['correct_response' => '124567', 'stimuli' => [4, 16, 19, 11, 6, 28], 'alternatives' => [4, 16, 5, 19, 11, 6, 28, 3]],
        // ['correct_response' => '245678', 'stimuli' => [13, 14, 12, 3, 28, 30], 'alternatives' => [7, 13, 11, 14, 12, 3, 28, 30]],
        // ['correct_response' => '123456', 'stimuli' => [12, 2, 13, 11, 1, 6], 'alternatives' => [12, 2, 13, 11, 1, 6, 4, 26]],
        // ['correct_response' => '234567', 'stimuli' => [28, 9, 5, 14, 17, 7], 'alternatives' => [4, 28, 9, 5, 14, 17, 7, 12]],
        // ['correct_response' => '345678', 'stimuli' => [2, 23, 22, 7, 10, 20], 'alternatives' => [14, 6, 2, 23, 22, 7, 10, 20]],
        // ['correct_response' => '245678', 'stimuli' => [5, 30, 3, 11, 19, 8], 'alternatives' => [12, 5, 1, 30, 3, 11, 19, 8]],
        // ['correct_response' => '124567', 'stimuli' => [24, 28, 9, 29, 17, 19], 'alternatives' => [24, 28, 2, 9, 29, 17, 19, 7]],
        // ['correct_response' => '134567', 'stimuli' => [21, 29, 5, 28, 1, 27], 'alternatives' => [21, 3, 29, 5, 28, 1, 27, 6]],
        // ['correct_response' => '145678', 'stimuli' => [2, 29, 16, 26, 7, 14], 'alternatives' => [2, 6, 8, 29, 16, 26, 7, 14]]
    ];

    public function mount()
    {
        Log::info('=== CAPACITY MOUNT START ===');

        // Set total trials based on testData array length
        $this->totalTrials = count($this->testData);
        $this->debugTimer = config('app.env') === 'local';

        // Check for existing in-progress session
        $existingSession = TestSession::where('user_id', Auth::id())
            ->where('test_type', 'capacity')
            ->where('status', 'in_progress')
            ->first();

        if ($existingSession) {
            // Delete existing session and its results for fresh start
            Log::info('Found existing capacity session, deleting for fresh start');

            // Delete any existing results
            TestResult::where('test_session_id', $existingSession->id)->delete();

            // Delete the session
            $existingSession->delete();

            Log::info('Deleted old capacity session, creating new one');
        }

        $this->initializeTest();
        $this->startMemorization();

        Log::info('=== CAPACITY MOUNT END ===');
    }

    public function initializeTest()
    {
        // Buat test session
        $this->testSession = TestSession::create([
            'user_id' => Auth::id(),
            'test_type' => 'capacity',
            'status' => 'in_progress',
            'started_at' => now(),
            'total_questions' => $this->totalTrials,
        ]);
    }

    public function startMemorization()
    {
        $currentData = $this->testData[$this->currentTrial - 1];

        // Set memory images (stimuli yang harus diingat)
        $this->memoryImages = $currentData['stimuli'];

        // Set test images (alternatives untuk dipilih) - sudah 8 gambar lengkap
        $this->testImages = $currentData['alternatives'];

        // Parse correct answers dari string ke array index (0-based)
        $correctResponseString = $currentData['correct_response'];
        $this->correctAnswers = [];

        for ($i = 0; $i < strlen($correctResponseString); $i++) {
            $position = (int) $correctResponseString[$i];
            if ($position > 0 && $position <= count($this->testImages)) {
                $this->correctAnswers[] = $position - 1; // Convert to 0-based index
            }
        }

        $this->isMemorizing = true;
        $this->isTesting = false;
        $this->answered = false;
        $this->userAnswers = [];
        $this->memorizeTimeLeft = 10;

        // Start countdown
        $this->dispatch('startMemorizeTimer');
    }

    public function proceedToTest()
    {
        $this->isMemorizing = false;
        $this->isTesting = true;
        $this->timeoutOccurred = false;
        $this->testStartTime = microtime(true);
        $this->dispatch('stopMemorizeTimer');
        $this->dispatch('startTestTimer');
    }

    public function handleSpacePress()
    {
        if ($this->isMemorizing) {
            $this->proceedToTest();
        } elseif ($this->isCompleted) {
            return redirect()->route('dashboard');
        }
    }

    public function handleTimeout()
    {
        if ($this->answered || !$this->isTesting || $this->timeoutOccurred) {
            return;
        }

        // Set flag bahwa timeout terjadi, tapi jangan disable input
        // Biarkan user tetap bisa menjawab
        $this->timeoutOccurred = true;

        Log::info('Timeout occurred on trial ' . $this->currentTrial . ', waiting for user answer');
    }

    public function submitAnswerFromClient($selectedImages)
    {
        if ($this->answered) {
            return;
        }

        $this->userAnswers = $selectedImages;
        $this->submitAnswer();
    }

    public function submitAnswer()
    {
        if ($this->answered) {
            return;
        }

        $this->answered = true;

        // Calculate response time
        $responseTime = ($this->testStartTime) ?
            round((microtime(true) - $this->testStartTime) * 1000) : 0;

        // Check correct answers
        $correctCount = 0;
        $wrongCount = 0;

        // Count correct selections
        foreach ($this->userAnswers as $answer) {
            if (in_array($answer, $this->correctAnswers)) {
                $correctCount++;
            } else {
                $wrongCount++;
            }
        }

        // User harus memilih SEMUA jawaban yang benar dan TIDAK ADA yang salah
        $expectedAnswers = count($this->correctAnswers);
        $isCorrect = ($correctCount == $expectedAnswers) && ($wrongCount == 0) && (count($this->userAnswers) == $expectedAnswers);

        // Check if timeout occurred - if yes, always mark as slow and incorrect
        if ($this->timeoutOccurred) {
            $this->feedbackType = 'slow';
            $isCorrect = false; // Always incorrect if timeout
        } else {
            if ($isCorrect) {
                $this->totalCorrect++;
                $this->feedbackType = 'correct';
            } else {
                $this->feedbackType = 'wrong';
            }
        }

        // Create test result for this trial
        $testResult = TestResult::create([
            'test_session_id' => $this->testSession->id,
            'question_number' => $this->currentTrial,
            'question_data' => [
                'stimuli' => $this->memoryImages,
                'alternatives' => $this->testImages,
                'correct_response' => $this->testData[$this->currentTrial - 1]['correct_response'],
                'is_simulation' => false,
            ],
            'correct_answer' => json_encode($this->correctAnswers),
            'user_answer' => json_encode($this->userAnswers),
            'is_correct' => $isCorrect,
            'response_time' => $responseTime,
            'timeout' => $this->timeoutOccurred,
            'question_started_at' => now()->subMilliseconds($responseTime),
            'answered_at' => now(),
        ]);

        // Update session total time
        $this->updateSessionTotalTime();

        // Create test answer according to the schema
        TestAnswer::create([
            'test_result_id' => $testResult->id,
            'answer_type' => 'capacity_choice',
            'answer_data' => [
                'trial_number' => $this->currentTrial,
                'memory_images' => $this->memoryImages,
                'test_images' => $this->testImages,
                'user_answers' => $this->userAnswers,
                'correct_answers' => $this->correctAnswers,
                'is_correct' => $isCorrect,
                'correct_count' => $correctCount
            ],
            'time_taken' => 0, // Could add timing if needed
        ]);

        // Show feedback
        $this->showFeedback = true;
        $this->dispatch('show-capacity-feedback');
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

    public function nextTrial()
    {
        if ($this->currentTrial >= $this->totalTrials) {
            $this->completeTest();
        } else {
            $this->currentTrial++;
            $this->startMemorization();
        }
    }

    public function completeTest()
    {
        $this->isCompleted = true;

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

        Log::info('Capacity test completed - Total: ' . $correctAnswers . '/' . $totalRealQuestions . ', Accuracy: ' . $this->accuracy . '%, Avg Response: ' . ($avgResponseTime ? round($avgResponseTime, 2) : 'N/A') . 'ms');
    }

    public function decrementTimer()
    {
        if ($this->memorizeTimeLeft > 0) {
            $this->memorizeTimeLeft--;
        }

        if ($this->memorizeTimeLeft == 0 && $this->isMemorizing) {
            $this->proceedToTest();
        }
    }

    public function toggleDebugInfo()
    {
        $this->showDebugInfo = !$this->showDebugInfo;
    }

    public function hideFeedbackAndProceed()
    {
        $this->showFeedback = false;
        $this->nextTrial();
    }

    public function handlePreloadComplete()
    {
        Log::info('Capacity images preload completed');
        $this->isPreloading = false;
        $this->preloadProgress = 100;
    }

    public function updatePreloadProgress($progress)
    {
        $this->preloadProgress = $progress;
        Log::info('Capacity preload progress: ' . $progress . '%');
    }

    public static function getNextTestType($userId)
    {
        // Check completion status in order
        $completedTests = TestSession::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->pluck('test_type')
            ->toArray();

        $testOrder = ['speed', 'energy', 'capacity'];

        foreach ($testOrder as $testType) {
            if (!in_array($testType, $completedTests)) {
                return $testType;
            }
        }

        return null; // All tests completed
    }

    public function render()
    {
        return view('livewire.tests.capacity-task');
    }
}
