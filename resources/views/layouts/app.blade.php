<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jamal Collection') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#FAFAFA] text-gray-900">
    
    <header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="flex items-center justify-between py-4 sm:py-6 px-4 sm:px-8 md:px-12 max-w-[1400px] mx-auto">
            
          <a href="{{ route('shop.home') }}" class="flex items-center gap-2 sm:gap-3 text-2xl sm:text-3xl font-extrabold tracking-tight hover:text-[#C5A059] transition-transform duration-300 hover:scale-105" style="font-family: 'Playfair Display', serif;">
                <img src="{{ asset('images/logo.png') }}" alt="Jamal Collection Logo" class="h-8 sm:h-10 md:h-12 w-auto object-contain">
            </a>
            <ul class="hidden sm:flex gap-6 md:gap-8 lg:gap-10">
                @php
                    $navItems = [
                        ['name' => 'HOME', 'url' => route('shop.home')],
                        ['name' => 'MEN', 'url' => route('shop.category', 'men')],       // NAYA LINK
                        ['name' => 'WOMEN', 'url' => route('shop.category', 'women')],   // NAYA LINK
                       ['name' => 'CONTACT', 'url' => route('shop.contact')],
                    ];
                @endphp
                @foreach($navItems as $item)
                    <li>
                        <a href="{{ $item['url'] }}" class="relative flex flex-col items-center group text-xs md:text-sm font-semibold tracking-widest uppercase text-gray-800 hover:text-[#C5A059] transition-colors duration-300">
                            {{ $item['name'] }}
                            <span class="absolute -bottom-2 w-0 h-[2px] bg-[#C5A059] transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-4 sm:gap-6">
                <a href="{{ route('shop.search') }}" class="hover:scale-110 transition-transform text-gray-800 hover:text-[#C5A059]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                </a>

              <a href="{{ route('user.orders') }}" class="hover:scale-110 transition-transform text-gray-800 hover:text-[#C5A059]" title="My Orders">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </a>

                <a href="/register" class="hover:scale-110 transition-transform text-gray-800 hover:text-[#C5A059]" title="Sign Up / Login">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </a>

             <a href="{{ route('wishlist.index') }}" class="relative hover:scale-110 transition-transform text-gray-800 hover:text-[#C5A059]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                    @php $wishlistCount = session('wishlist') ? count(session('wishlist')) : 0; @endphp
                    @if($wishlistCount > 0)
                        <span class="absolute -right-1.5 -top-1.5 w-[18px] h-[18px] flex items-center justify-center bg-[#C5A059] text-white rounded-full text-[9px] font-bold shadow-md">
                            {{ $wishlistCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('cart.index') }}" class="relative hover:scale-110 transition-transform text-gray-800 hover:text-[#C5A059]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute -right-1.5 -top-1.5 w-[18px] h-[18px] flex items-center justify-center bg-[#C5A059] text-white rounded-full text-[9px] font-bold shadow-md">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                <button onclick="document.getElementById('mobile-menu').classList.remove('translate-x-full')" class="sm:hidden ml-2 hover:scale-110 transition-transform text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="fixed inset-0 z-[100] bg-white flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out sm:hidden shadow-2xl">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <span class="text-xl font-extrabold text-[#C5A059]" style="font-family: 'Playfair Display', serif;">Jamal Collection</span>
                <button onclick="document.getElementById('mobile-menu').classList.add('translate-x-full')" class="p-2 bg-gray-50 rounded-full hover:bg-gray-100 text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="flex flex-col text-gray-800 mt-4 px-4 gap-2">
                @foreach($navItems as $item)
                    <a href="{{ $item['url'] }}" class="py-4 px-4 rounded-lg font-semibold tracking-widest text-sm uppercase hover:bg-gray-50 hover:text-[#C5A059] hover:border-l-4 hover:border-[#C5A059] transition-all">
                        {{ $item['name'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    <div class="min-h-screen bg-[#FAFAFA]">
        {{ $slot }}
    </div>

    <footer class="bg-[#121212] pt-16 sm:pt-24 pb-8 border-t-[3px] border-[#C5A059]">
        <div class="max-w-[1400px] mx-auto px-6 sm:px-12 lg:px-24">
            
            <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_1fr] gap-12 sm:gap-16 mb-16">
                
                <div class="flex flex-col items-start">
                    <div class="bg-white/5 p-4 rounded-xl backdrop-blur-sm mb-6 border border-white/10">
                        <img src="{{ asset('images/logo.png') }}" alt="Jamal Collection Logo" class="w-28 sm:w-36 object-contain brightness-0 invert">
                    </div>
                    
                    <p class="text-gray-400 text-xs sm:text-sm leading-relaxed max-w-sm tracking-wide">
                        Welcome to <span class="text-[#C5A059] font-medium">Jamal Collection</span> —
                        your go-to destination for stylish fashion and premium quality.
                        We bring you the latest trends, crafted with care and delivered
                        with love, straight to your doorstep.
                    </p>
                </div>

                <div>
                    <h3 class="text-white text-xs sm:text-sm font-bold tracking-[0.2em] uppercase mb-6">
                        Company
                    </h3>
                    <ul class="flex flex-col gap-4 text-gray-400 text-xs sm:text-sm">
                        <li class="group flex items-center">
                            <span class="w-0 h-[1px] bg-[#C5A059] mr-0 transition-all duration-300 group-hover:w-4 group-hover:mr-3"></span>
                            <a href="#" class="group-hover:text-[#C5A059] transition-colors duration-300">Return Refund Policy</a>
                        </li>
                        <li class="group flex items-center">
                            <span class="w-0 h-[1px] bg-[#C5A059] mr-0 transition-all duration-300 group-hover:w-4 group-hover:mr-3"></span>
                            <a href="#" class="group-hover:text-[#C5A059] transition-colors duration-300">Shipping Policy</a>
                        </li>
                        <li class="group flex items-center">
                            <span class="w-0 h-[1px] bg-[#C5A059] mr-0 transition-all duration-300 group-hover:w-4 group-hover:mr-3"></span>
                            <a href="#" class="group-hover:text-[#C5A059] transition-colors duration-300">Terms & Conditions</a>
                        </li>
                        <li class="group flex items-center">
                            <span class="w-0 h-[1px] bg-[#C5A059] mr-0 transition-all duration-300 group-hover:w-4 group-hover:mr-3"></span>
                            <a href="#" class="group-hover:text-[#C5A059] transition-colors duration-300">Privacy Policy</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white text-xs sm:text-sm font-bold tracking-[0.2em] uppercase mb-6">
                        Get In Touch
                    </h3>
                    <ul class="flex flex-col gap-4 text-gray-400 text-xs sm:text-sm">
                        
                        <li class="flex items-start gap-3 hover:text-white transition-colors duration-300">
                            <svg class="w-5 h-5 text-[#C5A059] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>
                            <span class="tracking-widest">+92-3105087313</span>
                        </li>
                        
                        <li class="flex items-start gap-3 hover:text-white transition-colors duration-300">
                            <svg class="w-5 h-5 text-[#C5A059] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <span class="tracking-wider">officialjamalcollection@gmail.com</span>
                        </li>
                        
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#C5A059] shrink-0" fill="currentColor" viewBox="0 0 24 24">
                               <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                            <a href="https://www.facebook.com/profile.php?id=61583732707640" target="_blank" rel="noopener noreferrer" class="hover:text-[#C5A059] transition-colors duration-300 tracking-widest">
                                Facebook
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-800/80 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-widest text-center md:text-left">
                    © {{ date('Y') }} <span class="text-[#C5A059]">Jamal Collection</span>. All Rights Reserved.
                </p>
                <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-widest text-center md:text-right">
                    Designed & Developed by <span class="text-white font-medium">Muhammad Bilal</span>.
                </p>
            </div>
            
        </div>
    </footer>

</body>
</html>
