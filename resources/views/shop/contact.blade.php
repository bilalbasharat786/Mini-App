<x-app-layout>

    <main class="w-full py-16 sm:py-24 bg-[#FAFAFA] min-h-screen flex flex-col justify-center overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 w-full">
            
            <div class="flex flex-col items-center text-center mb-16 sm:mb-24 transition-all duration-700 ease-in-out transform translate-y-0 opacity-100">
                <span class="text-[#C5A059] text-[10px] sm:text-xs font-bold tracking-[0.3em] uppercase mb-4">
                    Get In Touch
                </span>
                <div class="flex items-center justify-center gap-2 text-3xl sm:text-4xl md:text-5xl text-gray-900 tracking-widest uppercase" style="font-family: 'Playfair Display', serif;">
                    <span class="font-extrabold">CONTACT</span> <span class="font-light text-gray-400">US</span>
                </div>
                <div class="w-16 sm:w-24 h-[2px] bg-[#C5A059] mt-6 rounded-full shadow-[0_0_10px_rgba(197,160,89,0.3)]"></div>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-24">
                
                <div class="w-full lg:w-1/2 flex justify-center lg:justify-end relative transition-all duration-1000 ease-out transform translate-x-0 opacity-100">
                    <div class="absolute top-4 -left-4 sm:top-6 sm:-left-6 w-full h-full border-2 border-[#C5A059]/40 z-0 hidden sm:block"></div>
                    
                    <div class="relative z-10 w-full max-w-[500px] aspect-[4/5] overflow-hidden bg-white shadow-xl">
                        <img src="{{ asset('images/contact_img.png') }}" alt="Jamal Collection Store" class="w-full h-full object-cover transition-transform duration-[10s] hover:scale-110">
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex flex-col justify-center items-start text-left transition-all duration-1000 ease-out transform translate-x-0 opacity-100">
                    
                    <div class="mb-12">
                        <h3 class="text-2xl sm:text-3xl font-medium text-[#121212] mb-6 tracking-wide" style="font-family: 'Playfair Display', serif;">
                            Our Store
                        </h3>
                        
                        <div class="flex flex-col gap-5">
                            <a href="tel:+923105087313" class="group flex items-center gap-4 text-gray-600 hover:text-[#C5A059] transition-colors duration-300">
                                <div class="w-12 h-12 flex items-center justify-center bg-white border border-gray-200 group-hover:border-[#C5A059] rounded-full shadow-sm transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.076-7.076l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <span class="text-sm sm:text-base tracking-wider">+92 310 508 7313</span>
                            </a>

                            <a href="mailto:officialjamalcollection@gmail.com" class="group flex items-center gap-4 text-gray-600 hover:text-[#C5A059] transition-colors duration-300">
                                <div class="w-12 h-12 flex items-center justify-center bg-white border border-gray-200 group-hover:border-[#C5A059] rounded-full shadow-sm transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <span class="text-sm sm:text-base tracking-wide">officialjamalcollection@gmail.com</span>
                            </a>
                        </div>
                    </div>

                    <hr class="w-full border-gray-200 mb-10" />

                    <div>
                        <h3 class="text-xl sm:text-2xl font-medium text-[#121212] mb-4 tracking-wide" style="font-family: 'Playfair Display', serif;">
                            Careers at Jamal Collection
                        </h3>
                        <p class="text-gray-500 text-sm sm:text-base leading-relaxed mb-8 max-w-md">
                            We're always looking for passionate individuals to join our growing team. Learn more about our teams and job openings.
                        </p>
                        
                        <button class="group relative px-8 py-3 bg-transparent overflow-hidden text-xs sm:text-sm font-semibold tracking-widest uppercase border border-[#121212] text-[#121212] transition-colors duration-300">
                            <span class="absolute inset-0 bg-[#121212] translate-y-full transition-transform duration-500 ease-out group-hover:translate-y-0"></span>
                            <span class="relative z-10 transition-colors duration-300 group-hover:text-white">
                                Explore Opportunities
                            </span>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </main>

</x-app-layout>