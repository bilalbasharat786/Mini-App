<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jamal Collection | Welcome</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <div class="relative flex items-center justify-center min-h-screen overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-400 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-400 rounded-full blur-[120px]"></div>
        </div>

        <div class="z-10 w-full max-w-md px-6 py-12 bg-white shadow-2xl rounded-3xl border border-gray-100 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 mb-8 bg-black rounded-2xl shadow-lg">
                <span class="text-3xl font-bold text-white">J</span>
            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-3">
                Jamal Collection
            </h1>
            <p class="text-gray-500 mb-10 text-lg">
                Your destination for premium fashion. Please sign in to explore our latest arrivals.
            </p>

            <div class="space-y-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="flex items-center justify-center w-full py-4 text-white bg-black hover:bg-gray-800 rounded-xl font-bold transition duration-300 shadow-md">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-4 text-white bg-black hover:bg-gray-800 rounded-xl font-bold transition duration-300 shadow-md">
                            Log In
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="flex items-center justify-center w-full py-4 text-gray-900 bg-white border-2 border-gray-100 hover:border-gray-200 rounded-xl font-bold transition duration-300 shadow-sm">
                                Create Account
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <p class="mt-8 text-sm text-gray-400">
                &copy; {{ date('Y') }} Jamal Collection. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>