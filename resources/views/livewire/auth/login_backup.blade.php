<div>
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
<div>
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Test Button -->
    <div class="mb-4">
        <button type="button" wire:click="testLivewire" class="w-full py-2 px-4 bg-green-500 text-white rounded text-sm">
            🧪 TEST LIVEWIRE (Klik untuk test koneksi)
        </button>
    </div>
    
    <form wire:submit.prevent="login" class="space-y-6">
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold mb-3 flex items-center space-x-2 text-blue-900">
                <i class="fas fa-envelope text-blue-600"></i>
                <span>Email Address</span>
            </label>
            <input wire:model.defer="email" type="email" id="email" 
                   class="w-full px-4 py-4 rounded-xl border-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all hover:border-blue-300"
                   style="border-color: rgba(59, 130, 246, 0.2); background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(37, 99, 235, 0.05) 100%);"
                   placeholder="Masukkan email Anda..."
                   required autofocus>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold mb-3 flex items-center space-x-2 text-blue-900">
                <i class="fas fa-lock text-blue-600"></i>
                <span>Password</span>
            </label>
            <div class="relative">
                <input wire:model.defer="password" type="password" id="password"
                       class="w-full px-4 py-4 pr-12 rounded-xl border-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all hover:border-blue-300"
                       style="border-color: rgba(59, 130, 246, 0.2); background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(37, 99, 235, 0.05) 100%);"
                       placeholder="Masukkan password Anda..."
                       required>
                <button type="button" 
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-blue-600 hover:text-blue-800 transition-colors"
                        onclick="togglePasswordVisibility()">
                    <i id="passwordIcon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model.defer="remember" id="remember" type="checkbox" 
                   class="w-4 h-4 rounded border-2 focus:ring-2 focus:ring-blue-500 text-blue-600"
                   style="border-color: rgba(59, 130, 246, 0.3);">
            <label for="remember" class="ml-2 text-sm text-blue-700">
                Ingat saya
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full py-4 px-4 text-white rounded-xl hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 font-semibold flex items-center justify-center space-x-2 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                style="background: linear-gradient(135deg, rgba(59, 130, 246, 1) 0%, rgba(37, 99, 235, 1) 50%, rgba(29, 78, 216, 1) 100%);"
                wire:loading.attr="disabled">
            <span wire:loading.remove class="flex items-center space-x-2">
                <i class="fas fa-sign-in-alt"></i>
                <span>Masuk ke Platform</span>
            </span>
            <span wire:loading class="flex items-center justify-center space-x-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Loading...</span>
            </span>
        </button>
    </form>
    
    <script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }
    </script>
</div>
