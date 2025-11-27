<?php

namespace App\Livewire;

use App\Models\TestSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

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
        return redirect()->route('instructions');
    }

    public function render()
    {
        $user = Auth::user();
        $testSessions = TestSession::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'testSessions' => $testSessions
        ]);
    }
}
