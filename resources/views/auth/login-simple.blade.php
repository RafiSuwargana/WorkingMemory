<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Working Memory Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .professional-gradient {
            background: linear-gradient(135deg, rgba(30, 58, 138, 1) 0%, rgba(37, 99, 235, 1) 50%, rgba(29, 78, 216, 1) 100%);
        }
    </style>
    @livewireStyles
</head>

<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full mx-auto p-4 md:p-8 lg:p-10">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="professional-gradient px-16 py-12 text-center relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-4 left-4 w-16 h-16 border-2 border-white rounded-full"></div>
                    <div class="absolute bottom-4 right-4 w-12 h-12 border border-white rounded-full"></div>
                    <div class="absolute top-1/2 right-6 w-6 h-6 border border-white rounded-full"></div>
                </div>

                <div class="relative z-10">


                    <h3 class="text-2xl font-bold text-white mb-2">Login</h3>
                    <p class="text-blue-100 text-sm">Working Memory Task Platform</p>
                </div>
            </div>

            <!-- Content -->
            <div class="px-16 py-12">
                @livewire('auth.login')
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-16 py-10 border-t text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-800 hover:text-blue-900 font-medium">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                Kembali ke Beranda
            </a>
        </div>
    </div>

    @livewireScripts
</body>

</html>