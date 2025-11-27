<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Working Memory Task' }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        .auth-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="auth-bg min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-auto p-6">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-8 text-center">
                <div class="mb-4">
                    <div class="mx-auto h-16 w-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-brain text-3xl text-white"></i>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">{{ $header ?? 'Working Memory Task' }}</h1>
                <p class="text-blue-100 text-sm">{{ $subheader ?? 'Platform Penelitian Kognitif' }}</p>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 text-center border-t">
                {{ $footer ?? '' }}
            </div>
        </div>
        
        <!-- Back to home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-white hover:text-blue-200 text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>