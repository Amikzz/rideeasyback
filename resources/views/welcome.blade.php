<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RideEasy Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            background: linear-gradient(to right, #f8fafc, #e5e7eb);
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full px-6 py-12 bg-white shadow-lg rounded-lg border border-gray-200">
        <div class="flex justify-center mb-8">
            <img src="images/pngtree-high-detailed-bus-vector-png-image_6172563.png" width="200" height="200" alt="Logo" class="object-cover">
        </div>
        <h1 class="text-4xl font-semibold text-center text-gray-900 mb-4">Welcome to RideEasy Portal</h1>
        <p class="text-lg text-gray-700 text-center mb-8">Conductors and Admins, please log in to explore.</p>
        <div class="flex justify-center space-x-4">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="px-6 py-3 bg-gray-900 text-white rounded-lg text-lg hover:bg-gray-800 transition duration-300">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg text-lg hover:bg-blue-500 transition duration-300">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 bg-green-600 text-white rounded-lg text-lg hover:bg-green-500 transition duration-300">Register</a>
                @endif
            @endauth
        </div>
    </div>
</div>
</body>
</html>
