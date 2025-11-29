<div>
    <!-- Pesan Sukses -->
    @if($message)
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
            <p class="font-bold">✅ SUKSES!</p>
            <p class="text-sm">{{ $message }}</p>
        </div>
    @endif

    <!-- Pesan Error -->
    @if($error)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
            <p class="font-bold">❌ ERROR!</p>
            <p class="text-sm">{{ $error }}</p>
        </div>
    @endif
    


    <div class="space-y-8">
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium mb-2 text-gray-700">
                Email
            </label>
            <input wire:model="email" 
                   type="email" 
                   id="email" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                   placeholder="contoh@email.com"
                   required>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium mb-2 text-gray-700">
                Password
            </label>
            <input wire:model="password" 
                   type="password" 
                   id="password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                   placeholder="Masukkan password..."
                   required>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="remember" id="remember" type="checkbox" class="mr-2">
            <label for="remember" class="text-sm text-gray-600">Ingat saya</label>
        </div>

        <!-- Submit Button -->
        <button type="button" 
                wire:click="login"
                class="w-full py-4 bg-gradient-to-r from-blue-800 via-blue-700 to-blue-900 text-white rounded-xl hover:from-blue-900 hover:via-blue-800 hover:to-blue-950 focus:outline-none disabled:opacity-50 transition font-semibold text-lg shadow-lg"
                wire:loading.attr="disabled"
                wire:target="login">
            <span wire:loading.remove wire:target="login">
                LOGIN SEKARANG
            </span>
            <span wire:loading wire:target="login">
                Sedang login...
            </span>
        </button>
    </div>
</div>