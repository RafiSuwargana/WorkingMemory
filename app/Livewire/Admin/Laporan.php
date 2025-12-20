<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\TestSession;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use App\Exports\TestResultsExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.app')]
class Laporan extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUser = null;
    public $showDetailModal = false;
    public $showExportModal = false;
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

    public function openExportModal()
    {
        $this->showExportModal = true;
    }

    public function closeExportModal()
    {
        $this->showExportModal = false;
    }

    public function exportExcel($testType = 'all')
    {
        $this->closeExportModal();

        $filename = $testType === 'all'
            ? 'all_test_results_' . now()->format('Y-m-d') . '.xlsx'
            : $testType . '_test_results_' . now()->format('Y-m-d') . '.xlsx';

        $this->dispatch('toast', type: 'success', message: 'Export Excel berhasil diunduh!');

        return Excel::download(new TestResultsExport($testType), $filename);
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
            ->latest('created_at')
            ->paginate(15);

        return view('livewire.admin.laporan', [
            'users' => $users
        ]);
    }
}
