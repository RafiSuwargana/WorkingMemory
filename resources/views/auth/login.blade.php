<x-layouts.auth title="Login - Working Memory Task" header="Login" subheader="Masuk ke Platform Penelitian">
    
    <!-- Test Content -->
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded">
        <h3 class="font-bold text-blue-800">✅ Halaman Login Berfungsi!</h3>
        <p class="text-sm text-blue-600">Layout auth berhasil dimuat dengan benar</p>
    </div>
    
    <!-- Livewire Component -->
    <livewire:auth.login />
    
    <x-slot name="footer">
        <p class="text-sm text-gray-600">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                Daftar di sini
            </a>
        </p>
    </x-slot>
    
</x-layouts.auth>