<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

#[Layout('components.layouts.app')]
class Users extends Component
{
    use WithPagination;

    public $search = '';

    public ?int $editingUserId = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'peserta';

    public $roles = [];

    public function mount()
    {
        // Check if user is admin
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard');
        }

        $this->roles = Role::query()->pluck('name')->all();
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
            $this->dispatch('toast', type: 'success', message: 'User berhasil dihapus.');
        }
    }

    public function openEditModal(int $userId): void
    {
        $user = User::findOrFail($userId);

        $this->editingUserId = $user->id;
        $this->name = (string) $user->name;
        $this->email = (string) $user->email;
        $this->password = '';
        $this->password_confirmation = '';

        $currentRole = $user->roles()->pluck('name')->first();
        $this->role = $currentRole ?: 'peserta';

        $this->resetValidation();
    }

    public function closeEditModal(): void
    {
        $this->editingUserId = null;
        $this->resetValidation();
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function updateUser(): void
    {
        if (!$this->editingUserId) {
            return;
        }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->editingUserId)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
        ]);

        $user = User::findOrFail($this->editingUserId);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->syncRoles([$validated['role']]);

        $this->closeEditModal();
        $this->dispatch('toast', type: 'success', message: 'User berhasil diperbarui.');
    }

    public function render()
    {
        $users = User::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })
            ->withCount('testSessions')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users', [
            'users' => $users,
            'roles' => $this->roles,
        ]);
    }
}
