<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome | InvenTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gradient-to-r from-gray-300 via-gray-500 to-gray-700 flex items-center justify-center">

<div class="relative bg-white/60 backdrop-blur-xl shadow-xl rounded-2xl p-8 max-w-lg w-full border border-gray-400">
    <h1 class="text-4xl font-bold text-gray-800 tracking-wider">InvenTrack</h1>
    <p class="mt-3 text-gray-700 text-lg">Effortless Inventory Tracking for Smart Businesses.</p>

    <div class="mt-6 space-x-4">
        <a href="{{ route('register') }}" class="px-6 py-2 rounded-full text-white bg-gray-800 hover:bg-gray-900 transition">
            Get Started
        </a>
        <a href="{{ route('login') }}" class="px-6 py-2 rounded-full text-gray-700 border border-gray-500 hover:bg-gray-100 transition">
            Login
        </a>
    </div>

    <footer class="mt-6 text-gray-200 text-sm">
        © {{ date('Y') }} InvenTrack. All Rights Reserved.
    </footer>
</div>

</body>
</html>
