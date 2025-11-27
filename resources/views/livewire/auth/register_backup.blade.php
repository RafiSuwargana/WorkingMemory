<div>
    @if($message)
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($error)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-red-800">{{ $error }}</p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Test Buttons -->
    <div class="mb-4 grid grid-cols-3 gap-2">
        <button type="button" wire:click="testLivewire" class="py-2 px-4 bg-green-500 text-white rounded text-xs">
            🧪 TEST LIVEWIRE
        </button>
        <button type="button" wire:click="testRegister" class="py-2 px-4 bg-blue-500 text-white rounded text-xs">
            🚀 TEST REGISTER
        </button>
        <button type="button" wire:click="clearForm" class="py-2 px-4 bg-red-500 text-white rounded text-xs">
            🗑️ CLEAR FORM
        </button>
    </div>
    
    <!-- Debug Info -->
    <div class="mb-4 p-3 bg-gray-100 border rounded text-xs">
        <strong>Debug Status:</strong><br>
        Name: <span class="font-mono">{{ $name ?? 'empty' }}</span><br>
        Email: <span class="font-mono">{{ $email ?? 'empty' }}</span><br>
        Password Length: <span class="font-mono">{{ strlen($password ?? '') }}</span><br>
        Confirmation Length: <span class="font-mono">{{ strlen($password_confirmation ?? '') }}</span>
    </div>
    
    <form wire:submit.prevent="register" class="space-y-6">
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold mb-3 flex items-center space-x-2 text-blue-900">
                <i class="fas fa-user text-blue-600"></i>
                <span>Nama Lengkap</span>
            </label>
            <input wire:model="name" type="text" id="name" name="name"
                   class="w-full px-4 py-4 rounded-xl border-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all hover:border-blue-300"
                   style="border-color: rgba(59, 130, 246, 0.2); background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(37, 99, 235, 0.05) 100%);"
                   placeholder="Masukkan nama lengkap Anda..."
                   required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold mb-3 flex items-center space-x-2 text-blue-900">
                <i class="fas fa-envelope text-blue-600"></i>
                <span>Email Address</span>
            </label>
            <input wire:model="email" type="email" id="email" name="email"
                   class="w-full px-4 py-4 rounded-xl border-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all hover:border-blue-300"
                   style="border-color: rgba(59, 130, 246, 0.2); background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(37, 99, 235, 0.05) 100%);"
                   placeholder="Masukkan email Anda..."
                   required>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold mb-3 flex items-center space-x-2 text-blue-900">
                <i class="fas fa-lock text-blue-600"></i>
                <span>Password</span>
            </label>
            <input wire:model="password" type="password" id="password" name="password"
                   class="w-full px-4 py-4 rounded-xl border-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all hover:border-blue-300"
                   style="border-color: rgba(59, 130, 246, 0.2); background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(37, 99, 235, 0.05) 100%);"
                   placeholder="Minimal 8 karakter..."
                   required>
        </div>

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold mb-3 flex items-center space-x-2 text-blue-900">
                <i class="fas fa-shield-alt text-blue-600"></i>
                <span>Konfirmasi Password</span>
            </label>
            <input wire:model="password_confirmation" type="password" id="password_confirmation" name="password_confirmation"
                   class="w-full px-4 py-4 rounded-xl border-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all hover:border-blue-300"
                   style="border-color: rgba(59, 130, 246, 0.2); background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(37, 99, 235, 0.05) 100%);"
                   placeholder="Ulangi password Anda..."
                   required>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full py-4 px-4 text-white rounded-xl hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 font-semibold flex items-center justify-center space-x-2 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                style="background: linear-gradient(135deg, rgba(59, 130, 246, 1) 0%, rgba(37, 99, 235, 1) 50%, rgba(29, 78, 216, 1) 100%);"
                wire:loading.attr="disabled">
            <span wire:loading.remove class="flex items-center space-x-2">
                <i class="fas fa-user-plus"></i>
                <span>Daftar Akun</span>
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
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Register form loaded');
        
        // Enable manual input fallback
        const inputs = ['name', 'email', 'password', 'password_confirmation'];
        inputs.forEach(inputName => {
            const input = document.getElementById(inputName);
            if (input) {
                input.addEventListener('input', function(e) {
                    console.log(`${inputName} input changed:`, e.target.value);
                });
                
                input.addEventListener('focus', function() {
                    console.log(`${inputName} focused`);
                    this.removeAttribute('readonly');
                });
                
                input.addEventListener('keypress', function(e) {
                    console.log(`${inputName} keypress:`, e.key);
                });
            }
        });
        
        // Listen for Livewire events
        window.addEventListener('livewire:load', () => {
            console.log('Livewire loaded for register');
        });
        
        window.addEventListener('livewire:update', () => {
            console.log('Livewire updated');
        });
    });
    </script>
</div>
