<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instruksi - Energy Task</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white">
    <div class="h-screen flex items-center justify-center">
        <div class="max-w-4xl mx-auto p-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">
                Instruksi Energy Task
            </h1>
            
            <div class="text-lg text-gray-700 mb-8 space-y-4">
                <p>Ini adalah halaman instruksi untuk Energy Task.</p>
                <p>Instruksi lengkap akan ditambahkan di sini...</p>
            </div>
            
            <div class="mt-8">
                <a href="{{ route('test.energy') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    Mulai Energy Test
                </a>
            </div>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>