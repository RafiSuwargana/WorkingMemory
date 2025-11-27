<x-layouts.auth title="Register - Working Memory Task" header="Daftar Akun" subheader="Bergabung dengan Platform Penelitian">
    
    <livewire:auth.register />
    
    <x-slot name="footer">
        <p class="text-sm text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                Login di sini
            </a>
        </p>
    </x-slot>
    
</x-layouts.auth>