<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-100 antialiased">
    <header class="w-full py-4 px-6 flex justify-between items-center bg-[#141421]/80 shadow-md fixed z-50">
        <h1 class="text-2xl font-bold text-indigo-400">
         <a href="/" class="hover:text-indigo-500 transition">
            AdManager
            </a>
        </h1>

        <nav class="flex items-center gap-6">
            <a href="/" class="hover:text-indigo-400 transition">Home</a>

            @auth
                <a href="{{ route('admin.dashboard') }}"
                    class="text-indigo-300 font-semibold hover:text-indigo-400 transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-gray-100 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
                    Create Account
                </a>
            @endauth
        </nav>
    </header>
    {{ $slot }}
</body>

</html>
