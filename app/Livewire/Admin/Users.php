<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
class Users extends Component
{
    use WithPagination;

    public $search = '';

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

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        if ($user && !$user->hasRole('admin')) {
            $user->delete();
            session()->flash('message', 'User berhasil dihapus.');
        }
    }

    public function render()
    {
        $users = User::role('peserta')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->withCount('testSessions')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users', [
            'users' => $users
        ]);
    }
}
