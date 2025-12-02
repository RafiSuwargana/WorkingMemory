<?php

namespace App\Livewire;

use App\Models\TestSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home');
    }

    public function startTests()
    {
        // Get next test type
        $nextTestType = \App\Livewire\Tests\SpeedTask::getNextTestType(Auth::id());
        switch ($nextTestType) {
            case 'speed':
                return redirect()->route('instructionspeed');
            case 'energy':
                logger('Redirecting to energy instruction');
                return redirect()->route('instructionEnergy');
            case 'capacity':
                return redirect()->route('instructionCapacity');
            default:
                // All tests completed
                return redirect()->route('dashboard')->with('message', 'Semua tes telah selesai!');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $testSessions = TestSession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get specific test sessions for each test type
        $speedTest = TestSession::where('user_id', $user->id)
            ->where('test_type', 'speed')
            ->where('status', 'completed')
            ->first();

        $energyTest = TestSession::where('user_id', $user->id)
            ->where('test_type', 'energy')
            ->where('status', 'completed')
            ->first();

        $capacityTest = TestSession::where('user_id', $user->id)
            ->where('test_type', 'capacity')
            ->where('status', 'completed')
            ->first();

        return view('livewire.dashboard', [
            'testSessions' => $testSessions,
            'speedTest' => $speedTest,
            'energyTest' => $energyTest,
            'capacityTest' => $capacityTest
        ]);
    }
}
