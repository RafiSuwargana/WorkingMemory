<div class="max-w-md mx-auto">
    <!-- Pesan Sukses -->
    @if($success_message)
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-bold text-lg">✅ BERHASIL!</p>
                    <p class="text-sm">{{ $success_message }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Pesan Error -->
    @if($error_message)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-bold text-lg">❌ GAGAL!</p>
                    <p class="text-sm">{{ $error_message }}</p>
                </div>
            </div>
        </div>
    @endif
    

    
    <div class="space-y-10">
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold mb-2 text-blue-800">
                Nama Lengkap
            </label>
            <input wire:model="name" 
                   type="text" 
                   id="name" 
                   name="name"
                   class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-500 focus:outline-none"
                   placeholder="Masukkan nama lengkap Anda..."
                   required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold mb-2 text-blue-800">
                Email Address
            </label>
            <input wire:model="email" 
                   type="email" 
                   id="email" 
                   name="email"
                   class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-500 focus:outline-none"
                   placeholder="contoh@email.com"
                   required>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold mb-2 text-blue-800">
                Password
            </label>
            <input wire:model="password" 
                   type="password" 
                   id="password" 
                   name="password"
                   class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-500 focus:outline-none"
                   placeholder="Minimal 8 karakter..."
                   required>
        </div>

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold mb-2 text-blue-800">
                Konfirmasi Password
            </label>
            <input wire:model="password_confirmation" 
                   type="password" 
                   id="password_confirmation" 
                   name="password_confirmation"
                   class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:border-blue-500 focus:outline-none"
                   placeholder="Ulangi password Anda..."
                   required>
        </div>

        <!-- Submit Button -->
        <button type="button" 
                wire:click="register"
                class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 focus:outline-none disabled:opacity-50 transition font-semibold text-lg shadow-lg"
                wire:loading.attr="disabled"
                wire:target="register">
            <span wire:loading.remove wire:target="register">
                DAFTAR SEKARANG
            </span>
            <span wire:loading wire:target="register">
                ⏳ Sedang mendaftar...
            </span>
        </button>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✅ Register page loaded successfully!');
        
        // Make sure all inputs are working
        const inputs = ['name', 'email', 'password', 'password_confirmation'];
        inputs.forEach(inputName => {
            const input = document.getElementById(inputName);
            if (input) {
                console.log(`✅ Input ${inputName} found and ready`);
                
                // Make sure inputs can be typed in
                input.addEventListener('focus', function() {
                    this.removeAttribute('readonly');
                    console.log(`📝 ${inputName} is now active for typing`);
                });
                
                input.addEventListener('input', function(e) {
                    console.log(`✏️ ${inputName} value: "${e.target.value}"`);
                });
            }
        });
    });
    </script>
</div>
