<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\TestSession;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public $totalUsers = 0;
    public $totalTests = 0;
    public $completedTests = 0;
    public $inProgressTests = 0;

    public function mount()
    {
        // Check if user is admin
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        $this->totalUsers = User::role('peserta')->count();
        $this->totalTests = TestSession::count();
        $this->completedTests = TestSession::where('status', 'completed')->count();
        $this->inProgressTests = TestSession::where('status', 'in_progress')->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
