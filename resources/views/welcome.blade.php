<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Working Memory Task Platform</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Welcome page loaded successfully');
        });
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Inter', sans-serif;
        }
        .professional-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 30%, #2563eb 70%, #3b82f6 100%);
            box-shadow: 0 8px 32px rgba(30, 58, 138, 0.3);
        }
        .welcome-bg {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.08) 0%, rgba(37, 99, 235, 0.04) 50%, rgba(59, 130, 246, 0.06) 100%);
        }
        .hero-illustration {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 30%, #2563eb 70%, #3b82f6 100%);
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(30, 58, 138, 0.4);
        }
        .floating-sparkle {
            position: absolute;
            animation: float 3s ease-in-out infinite;
        }
        .floating-sparkle:nth-child(1) { top: 20%; right: 30%; animation-delay: 0s; }
        .floating-sparkle:nth-child(2) { top: 15%; right: 15%; animation-delay: 1s; }
        .floating-sparkle:nth-child(3) { top: 25%; right: 20%; animation-delay: 2s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-10px) scale(1.1); }
        }
        
        .brain-shine {
            animation: shine 2s ease-in-out infinite;
        }
        
        @keyframes shine {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .celebrate-animation {
            animation: celebrate 1.5s ease-in-out infinite;
        }
        
        @keyframes celebrate {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-5px) rotate(5deg); }
            75% { transform: translateY(-3px) rotate(-5deg); }
        }
        
        .dot-pattern {
            background-image: radial-gradient(circle, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        .task-card {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.08) 0%, rgba(37, 99, 235, 0.06) 100%);
            border: 1px solid rgba(30, 58, 138, 0.1);
            transition: all 0.3s ease;
        }
        .task-card:hover {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.12) 0%, rgba(37, 99, 235, 0.1) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.15);
        }
    </style>
</head>
<body class="welcome-bg min-h-screen flex items-center justify-center py-8 dot-pattern" x-data="modalHandler()">
    <div class="max-w-6xl w-full mx-auto px-4">
        
        <!-- Mobile Welcome Header -->
        <div class="lg:hidden text-center mb-8">
            <div class="mb-6">
                <div class="mx-auto h-16 w-16 bg-gradient-to-br from-blue-800 to-blue-900 rounded-2xl flex items-center justify-center shadow-xl">
                    <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                Selamat Datang di<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-800 to-blue-900">
                    Working Memory Task
                </span>
            </h1>
            <p class="text-gray-600 text-sm">
                Platform tes kognitif untuk mengukur kemampuan memori kerja
            </p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-12 items-center min-h-screen lg:min-h-[90vh]">
            
            <!-- Welcome Section - Left Side -->
            <div class="hidden lg:flex lg:flex-col lg:justify-center lg:items-center lg:p-6">
                <div class="text-center space-y-6">
                    <!-- Hero Illustration -->
                    <div class="relative mx-auto w-80 h-80 hero-illustration flex items-center justify-center mb-8">
                        <!-- Floating Sparkles -->
                        <div class="floating-sparkle">
                            <i class="fas fa-star text-white text-3xl"></i>
                        </div>
                        <div class="floating-sparkle">
                            <i class="fas fa-star text-white text-2xl"></i>
                        </div>
                        <div class="floating-sparkle">
                            <i class="fas fa-star text-white text-2xl"></i>
                        </div>
                        
                        <!-- Main Illustration Content -->
                        <div class="relative z-10 flex items-center justify-center">
                            <!-- Brain Icon -->
                            <div class="brain-shine">
                                <svg class="h-24 w-24 text-yellow-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            
                            <!-- Celebrating People -->
                            <div class="absolute -bottom-8 left-0 right-0 flex justify-center items-end space-x-4">
                                <div class="celebrate-animation">
                                    <i class="fas fa-user text-white text-3xl"></i>
                                </div>
                                <div class="celebrate-animation" style="animation-delay: 0.5s;">
                                    <i class="fas fa-user text-white text-3xl"></i>
                                </div>
                                <div class="celebrate-animation" style="animation-delay: 1s;">
                                    <i class="fas fa-user text-white text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="absolute top-10 left-10 w-6 h-6 bg-green-400 rounded-full opacity-80"></div>
                        <div class="absolute bottom-16 right-8 w-5 h-5 bg-yellow-300 rounded-full opacity-70"></div>
                        <div class="absolute top-1/2 left-4 w-4 h-4 bg-blue-300 rounded-full opacity-60"></div>
                    </div>
                    
                    <!-- Welcome Text -->
                    <div class="space-y-6">
                        <h1 class="text-4xl font-bold text-gray-800">
                            Selamat Datang di<br>
                            <span class="text-gray-800">
                                Working Memory Task
                            </span>
                        </h1>
                        <p class="text-gray-600 text-lg leading-relaxed max-w-lg mx-auto">
                            Mengukur kemampuan memori kerja Anda melalui berbagai jenis tes yang telah dirancang khusus.
                        </p>
                        
                        <!-- Task Cards Preview -->
                        <div class="grid grid-cols-3 gap-4 mt-8">
                            <div class="task-card p-4 rounded-xl text-center">
                                <div class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center font-bold mx-auto mb-2 text-sm">1</div>
                                <p class="text-xs text-gray-700 font-medium">Speed Task</p>
                            </div>
                            <div class="task-card p-4 rounded-xl text-center">
                                <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold mx-auto mb-2 text-sm">2</div>
                                <p class="text-xs text-gray-700 font-medium">Energy Task</p>
                            </div>
                            <div class="task-card p-4 rounded-xl text-center">
                                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold mx-auto mb-2 text-sm">3</div>
                                <p class="text-xs text-gray-700 font-medium">Capacity Task</p>
                            </div>
                        </div>
                        
                        <!-- Progress Dots -->
                        <div class="flex justify-center space-x-3 pt-6">
                            <div class="w-4 h-4 bg-blue-800 rounded-full shadow-md"></div>
                            <div class="w-4 h-4 bg-blue-300 rounded-full shadow-md"></div>
                            <div class="w-4 h-4 bg-blue-500 rounded-full shadow-md"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Login Form Section - Right Side -->
            <div class="w-full flex flex-col justify-center items-center lg:p-6">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden w-full max-w-lg">
                    

                        <!-- Header with Logo -->
                        <div class="professional-gradient px-10 py-10 text-center relative overflow-hidden">
                            <!-- Background Pattern -->
                            <div class="absolute inset-0 opacity-10">
                                <div class="absolute top-4 left-4 w-20 h-20 border-2 border-white rounded-full"></div>
                                <div class="absolute bottom-4 right-4 w-16 h-16 border border-white rounded-full"></div>
                                <div class="absolute top-1/2 right-8 w-8 h-8 border border-white rounded-full"></div>
                            </div>
                            
                            <div class="relative z-10">
                                <!-- Logo -->
                                <div class="mb-6">
                                    <div class="mx-auto h-16 w-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <h2 class="text-3xl font-bold text-white mb-2">Masuk</h2>
                                <p class="text-blue-100 text-sm">Working Memory Task Platform</p>
                            </div>
                        </div>
                        
                        <!-- Body -->
                        <div class="px-10 py-8">
                            <!-- Login/Register Buttons -->
                            <div class="space-y-4">
                                <a href="{{ route('login') }}" 
                                   class="w-full py-4 px-4 professional-gradient text-white rounded-xl hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 font-semibold flex items-center justify-center space-x-2 transform hover:scale-105">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Login ke Platform</span>
                                </a>
                                
                                <a href="{{ route('register') }}" 
                                   class="w-full py-4 px-4 bg-white text-blue-800 rounded-xl border-2 border-blue-800 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 transition-all duration-300 font-semibold flex items-center justify-center space-x-2 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Daftar Akun Baru</span>
                                </a>
                            </div>
                            
                            <!-- Info -->
                            <div class="mt-6 text-center">
                                

                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Login Modal -->
        <div x-show="showLogin" 
             x-cloak
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" @click="showLogin = false"></div>
            
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-auto overflow-hidden z-10">
                    <!-- Header -->
                    <div class="professional-gradient px-10 py-8 text-center relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-4 left-4 w-16 h-16 border-2 border-white rounded-full"></div>
                            <div class="absolute bottom-4 right-4 w-12 h-12 border border-white rounded-full"></div>
                            <div class="absolute top-1/2 right-6 w-6 h-6 border border-white rounded-full"></div>
                        </div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div></div>
                                <button @click="showLogin = false" type="button" class="text-white hover:text-gray-200 cursor-pointer">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Logo -->
                            <div class="mb-4">
                                <div class="mx-auto h-12 w-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-white mb-2">Login</h3>
                            <p class="text-blue-100 text-sm">Working Memory Task Platform</p>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="px-10 py-8">
                        <livewire:auth.login />
                    </div>
                    
                    <!-- Footer -->
                    <div class="bg-gray-50 px-10 py-6 border-t text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun? 
                            <button @click="showRegister = true; showLogin = false" type="button" class="text-blue-800 hover:text-blue-900 font-medium cursor-pointer">
                                Daftar sekarang
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register Modal -->
        <div x-show="showRegister" 
             x-cloak
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" @click="showRegister = false"></div>
            
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-auto overflow-hidden z-10">
                    <!-- Header -->
                    <div class="professional-gradient px-10 py-8 text-center relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-4 left-4 w-16 h-16 border-2 border-white rounded-full"></div>
                            <div class="absolute bottom-4 right-4 w-12 h-12 border border-white rounded-full"></div>
                            <div class="absolute top-1/2 right-6 w-6 h-6 border border-white rounded-full"></div>
                        </div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div></div>
                                <button @click="showRegister = false" type="button" class="text-white hover:text-gray-200 cursor-pointer">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Logo -->
                            <div class="mb-4">
                                <div class="mx-auto h-12 w-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-white mb-2">Register</h3>
                            <p class="text-blue-100 text-sm">Working Memory Task Platform</p>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="px-10 py-8">
                        <livewire:auth.register />
                    </div>
                    
                    <!-- Footer -->
                    <div class="bg-gray-50 px-10 py-6 border-t text-center">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun? 
                            <button @click="showLogin = true; showRegister = false" type="button" class="text-blue-800 hover:text-blue-900 font-medium cursor-pointer">
                                Login di sini
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>
