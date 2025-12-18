<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\TestSession;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class Laporan extends Component
{
    use WithPagination;

    public $search = '';
    public $filterTestType = '';
    public $selectedUser = null;
    public $showDetailModal = false;
    public $testDetails = [];

    public function mount()
    {
        // Check if user is admin
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterTestType()
    {
        $this->resetPage();
    }

    public function viewDetails($userId)
    {
        $this->selectedUser = User::with([
            'testSessions' => function ($query) {
                $query->where('status', 'completed')
                    ->with('testResults')
                    ->orderBy('completed_at', 'desc');
            }
        ])->find($userId);

        $this->showDetailModal = true;
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->selectedUser = null;
    }

    public function exportData()
    {
        // TODO: Implement export functionality
        session()->flash('message', 'Export functionality coming soon.');
    }

    public function render()
    {
        $users = User::role('peserta')
            ->withCount([
                'testSessions as completed_tests_count' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterTestType, function ($query) {
                $query->whereHas('testSessions', function ($q) {
                    $q->where('test_type', $this->filterTestType)
                        ->where('status', 'completed');
                });
            })
            ->latest('created_at')
            ->paginate(15);

        return view('livewire.admin.laporan', [
            'users' => $users
        ]);
    }
}
