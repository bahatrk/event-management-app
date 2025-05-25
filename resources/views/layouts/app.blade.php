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

<body class="font-sans antialiased min-h-screen flex flex-col">
    <!-- Navigation (Fixed to Top) -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-white shadow">
        @auth
            @include('layouts.navigation')
        @endauth

        @guest
            @include('layouts.guest-navigation')
        @endguest
    </div>

    <!-- Content Wrapper with padding to prevent overlap -->
    <div class="flex flex-col justify-between min-h-screen pt-20 bg-gray-100">

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Success message with Alpine.js fade-out --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow" role="alert">
                {{ session('error') }}
            </div>
        @elseif (session('info'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)"
                class="mb-4 p-4 bg-blue-100 text-blue-800 rounded shadow" role="alert">
                {{ session('info') }}
            </div>
        @endif
        <!-- Page Content -->
        <main class="flex-grow flex justify-center px-4 sm:px-6 lg:px-8 my-8">
            <div class="w-full max-w-7xl">
                {{ $slot }}
            </div>
        </main>

        <!-- Page Footer -->
        <footer class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500">© {{ date('Y') }} Event Management. All rights reserved.</p>
            </div>
        </footer>

    </div>


    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</body>

</html>
