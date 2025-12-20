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
    public $usersCompleted3Tests = 0;
    public $usersNotCompleted3Tests = 0;

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

        // Count users who have completed 3 tests
        $this->usersCompleted3Tests = User::role('peserta')
            ->withCount([
                'testSessions' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->having('test_sessions_count', '>=', 3)
            ->count();

        // Count users who have not completed 3 tests
        $this->usersNotCompleted3Tests = $this->totalUsers - $this->usersCompleted3Tests;
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
