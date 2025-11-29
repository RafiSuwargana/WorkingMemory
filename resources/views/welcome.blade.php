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

        /* Responsive adjustments for better split screen */
        @media (max-width: 1536px) {
            .welcome-section {
                display: none !important;
            }
        }
        
        .compact-header {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.08) 0%, rgba(37, 99, 235, 0.04) 50%, rgba(59, 130, 246, 0.06) 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(30, 58, 138, 0.1);
        }
    </style>
</head>
<body class="welcome-bg min-h-screen flex items-center justify-center py-4 dot-pattern" x-data="{ showLogin: false, showRegister: false }">
    <div class="max-w-md w-full mx-auto px-4">
        
        <!-- Compact Welcome Header - Always Visible -->
        <div class="compact-header text-center">
            <div class="mb-4">
                <div class="mx-auto h-12 w-12 bg-gradient-to-br from-blue-800 to-blue-900 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-xl font-bold text-gray-800 mb-1">
                Selamat Datang di<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-800 to-blue-900">
                    Working Memory Task
                </span>
            </h1>
            <p class="text-gray-600 text-sm">
                Platform tes kognitif untuk mengukur kemampuan memori kerja
            </p>
        </div>
        
        <div class="flex justify-center items-center">
            
            <!-- Login Form Section - Centered -->
            <div class="w-full flex flex-col justify-center items-center">
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden w-full">
                    

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
                                   class="w-full py-4 px-4 professional-gradient text-white rounded-xl hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 font-semibold flex items-center justify-center space-x-2 transform hover:scale-105">
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
