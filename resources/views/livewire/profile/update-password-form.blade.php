<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <form wire:submit="updatePassword" class="space-y-5">
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">Password
                Saat Ini</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password"
                type="password"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-200"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-1.5" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">Password
                Baru</label>
            <input wire:model="password" id="update_password_password" name="password" type="password"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-200"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <label for="update_password_password_confirmation"
                class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation"
                name="password_confirmation" type="password"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-200"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-colors duration-200">
                Simpan
            </button>

            <x-action-message class="text-sm text-green-600 font-medium" on="password-updated">
                Tersimpan!
            </x-action-message>
        </div>
    </form>
</section>