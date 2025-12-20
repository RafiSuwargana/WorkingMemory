<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .logout-link {
            position: fixed;
            top: 20px;
            right: 20px;
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
            z-index: 9999;
        }

        .logout-link:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        function logout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                window.location.href = '/logout';
            }
        }
    </script>
</head>

<body>
    <a href="#" onclick="logout()" class="logout-link">Keluar</a>

    {{ $slot }}

    @livewireScripts
</body>

</html>