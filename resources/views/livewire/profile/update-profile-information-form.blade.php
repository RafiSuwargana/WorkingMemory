<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <form wire:submit="updateProfileInformation" class="space-y-5">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input wire:model="name" id="name" name="name" type="text"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-200"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input wire:model="email" id="email" name="email" type="email"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all duration-200"
                required autocomplete="username" />
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !
            auth()->user()->hasVerifiedEmail())
            <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                <p class="text-sm text-amber-800">
                    Email Anda belum diverifikasi.
                    <button wire:click.prevent="sendVerification" class="underline font-medium hover:text-amber-900">
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-sm font-medium text-green-700">
                    Link verifikasi baru telah dikirim ke alamat email Anda.
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-colors duration-200">
                Simpan
            </button>

            <x-action-message class="text-sm text-green-600 font-medium" on="profile-updated">
                Tersimpan!
            </x-action-message>
        </div>
    </form>
</section>