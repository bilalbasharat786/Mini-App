<x-app-layout>
    <main class="bg-[#FAFAFA] min-h-screen py-10 sm:py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col items-center mb-12 sm:mb-16 text-center">
                <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-3">
                    Join Jamal Collection
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-widest uppercase flex gap-3" style="font-family: 'Playfair Display', serif;">
                    <span class="text-gray-400 font-light">CREATE</span> <span class="text-gray-900">ACCOUNT</span>
                </h2>
                <div class="w-20 h-[2px] bg-[#C5A059] mt-5"></div>
            </div>

            <div class="bg-white p-6 sm:p-10 border border-gray-100 shadow-xl rounded-sm">
                
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" class="text-gray-600 font-bold tracking-wide uppercase text-xs mb-2 block" :value="__('Full Name')" />
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                               class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs" />
                    </div>

                    <div>
                        <x-input-label for="email" class="text-gray-600 font-bold tracking-wide uppercase text-xs mb-2 block" :value="__('Email Address')" />
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="password" class="text-gray-600 font-bold tracking-wide uppercase text-xs mb-2 block" :value="__('Password')" />
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm"/>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" class="text-gray-600 font-bold tracking-wide uppercase text-xs mb-2 block" :value="__('Confirm Password')" />
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="w-full bg-white border border-gray-200 px-4 py-3.5 outline-none focus:border-[#C5A059] focus:ring-1 focus:ring-[#C5A059]/20 transition-all text-sm text-gray-800 placeholder-gray-400 rounded-sm shadow-sm"/>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center gap-6 sm:justify-between">
                        <a class="text-sm text-gray-600 hover:text-[#C5A059] rounded-md transition-colors font-medium" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button type="submit" class="group relative bg-[#121212] text-white px-10 py-4 text-xs font-bold tracking-widest uppercase rounded-sm shadow-xl hover:shadow-[#C5A059]/20 transition-all duration-300 overflow-hidden w-full sm:w-auto">
                            <span class="absolute inset-0 bg-[#C5A059] translate-y-full transition-transform duration-500 ease-out group-hover:translate-y-0"></span>
                            <span class="relative z-10 flex items-center justify-center gap-2 transition-colors duration-300">
                                {{ __('Register') }}
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>
