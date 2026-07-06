@extends('client.layouts.app')
@section('title', 'Advertise QuickDials - Local search, IT Training, Playschool, overseas education.')
@section('description', 'Advertise QuickDials- Local search, IT Training, Playschool, overseas education.')
@section('keywords', 'Advertise QuickDials- Local search, IT Training, Playschool, overseas education.')
@section('content')	
@include('client.components.banner-section')

{{-- Use this only for testing --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        @keyframes phoneFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .anim-float {
            animation: phoneFloat 4s ease-in-out infinite;
        }

        @keyframes pingSlow {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            75%, 100% {
                transform: scale(1.7);
                opacity: 0;
            }
        }

        .anim-ping-slow {
            animation: pingSlow 2s infinite;
        }

        @keyframes pulseRing {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(0, 118, 215, 0.4);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(0, 118, 215, 0);
            }
        }

        .anim-pulse-ring {
            animation: pulseRing 2s infinite;
        }
    </style>

   <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

<div
    x-data="{
        scrolled: false,
        activeNav: '',
        scrollTo(id) {
            document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
            this.activeNav = id;
        }
    }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
    class="min-h-screen bg-white font-sans overflow-x-hidden"
>

    

    {{-- ===== BREADCRUMB ===== --}}
    <div class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-2 flex items-center gap-1 text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-[#0076D7]">Home</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700">Advertise your Business</span>
        </div>
    </div>
 



    {{-- ===== HERO ===== --}}
    <section class="bg-white relative overflow-hidden" id="hero">
        {{-- Ambient background shapes for hero energy --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-50 rounded-full blur-3xl opacity-60 pointer-events-none anim-pulse-slow"></div>
        <div class="absolute top-40 -left-24 w-72 h-72 bg-green-50 rounded-full blur-3xl opacity-50 pointer-events-none anim-pulse-slow" style="animation-delay:1.5s"></div>

        <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-8 items-center relative z-10">

            {{-- Left --}}
            <div data-reveal data-reveal-from="left">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-3">
                    <span class="text-gradient-anim inline-block hover:scale-105 transition-transform duration-300">GROW</span>
                    <span class="text-[#22c55e] text-3xl align-super ml-1 inline-block anim-bounce-in">&#10003;</span>
                    Your Business with QuickDials
                </h1>
                <p class="text-gray-500 text-base mb-6">                  
                   Get Noticed Fast - Create your business profile, bring in qualified leads, and increase your online visibility, all from one platform
                </p>

                {{-- Mobile number lead capture (primary CTA) --}}
                
                <h2>Sign Up Today</h2>
                {{-- Checkmarks --}}
                <ul class="mt-5 space-y-2">
                    @foreach(['Get Connected with Buyers', 'Establish Credibility with Your Business Profile', 'Answer All Inquiries in One Place'] as $i => $item)
                        <li class="flex items-center gap-2 text-sm text-gray-700" data-reveal data-reveal-delay="{{ 200 + $i * 100 }}">
                            <svg class="w-4 h-4 text-[#22c55e] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Right — Single Phone Mockup + floating stat cards + ranked-business teaser --}}
            <div class="relative flex justify-center" data-reveal data-reveal-from="right">

                {{-- Floating stat cards --}}
                <div class="absolute top-0 right-0 flex flex-col gap-3 z-20">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 px-4 py-3 flex items-center gap-3 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300" data-reveal data-reveal-delay="300">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#0076D7]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 4v-2a4 4 0 00-3-3.87"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-800" data-counter="182000000" data-suffix="+" data-format="crore">0</div>
                            <div class="text-[10px] text-gray-500">Buyers</div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 px-4 py-3 flex items-center gap-3 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300" data-reveal data-reveal-delay="450">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#22c55e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-800" data-counter="630000" data-suffix="+" data-format="lakh">0</div>
                            <div class="text-[10px] text-gray-500">Happy Customers</div>
                        </div>
                    </div>
                </div>

                {{-- Phone mockup — tilts gently on mouse move, floats continuously --}}
                <div
                    x-data="{ rx: 0, ry: 0 }"
                    @mousemove="rx = (($event.offsetY / $el.offsetHeight) - 0.5) * -10; ry = (($event.offsetX / $el.offsetWidth) - 0.5) * 10"
                    @mouseleave="rx = 0; ry = 0"
                    :style="`transform: perspective(1000px) rotateX(${rx}deg) rotateY(${ry}deg)`"
                    class="w-64 h-[460px] bg-gray-900 rounded-[2.5rem] shadow-2xl border-4 border-gray-800 relative overflow-hidden mx-auto mt-10 anim-float transition-transform duration-300 ease-out"
                >
                    <div class="absolute inset-0 bg-gray-50 flex flex-col">

                        {{-- Status bar --}}
                        <div class="bg-[#0076D7] px-3 pt-2 pb-1 flex items-center justify-between text-white text-[7px] font-semibold flex-shrink-0">
                            <span>11:11</span>
                            <div class="flex items-center gap-1">
                                <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><path d="M2 22h20V2L2 22z"/></svg>
                                <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3a4.24 4.24 0 00-6 0zm-4-4l2 2a7.07 7.07 0 0110 0l2-2C15.14 9.14 8.87 9.14 5 13z"/></svg>
                                <span>78%</span>
                            </div>
                        </div>

                        {{-- Top app bar --}}
                        <div class="bg-[#0076D7] px-2.5 pb-2.5 flex items-center justify-between gap-1 flex-shrink-0">
                            <div class="text-white text-[9px] font-bold leading-none">QuickDials</div>
                            <div class="flex items-center gap-1">
                                <span class="bg-white/15 text-white text-[5.5px] px-1.5 py-0.5 rounded-full font-medium whitespace-nowrap">Have an Account</span>
                                <span class="bg-white text-[#0076D7] text-[5.5px] px-1.5 py-0.5 rounded-full font-bold whitespace-nowrap">Sign Up</span>
                            </div>
                        </div>

                        {{-- Location pill --}}
                        <div class="px-2.5 -mt-1.5 mb-2 flex-shrink-0 flex">
                            <div class="bg-white rounded-full shadow-sm px-2 py-1 flex items-center gap-1 w-fit">
                                <svg class="w-2 h-2 text-[#0076D7]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
                                <span class="text-[5.5px] font-semibold text-gray-700">Delhi</span>
                                <svg class="w-1.5 h-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                              <div class="bg-white rounded-full shadow-sm px-2 py-1.5 flex items-center gap-1.5 border border-gray-100 w-150">
                                <svg class="w-2.5 h-2.5 text-[#0076D7] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                                <span class="text-[6.5px] text-gray-400">Search Services</span>
                            </div>
                        </div>

                        {{-- Search bar --}}
                      

                        {{-- Auto-rotating banner carousel --}}
                        <div class="px-2.5 mb-2 flex-shrink-0" x-data="{ slide: 0 }" x-init="setInterval(() => slide = (slide + 1) % 3, 2200)">
                            <div class="relative rounded-lg overflow-hidden h-16 bg-gradient-to-br from-amber-100 via-lime-100 to-emerald-200">
                                <div class="absolute inset-0 flex items-center justify-between px-2">
                                    <div>
                                        <div class="text-[7.5px] font-bold text-emerald-800 leading-tight">Services &<br>IT Training</div>
                                        <span class="inline-block mt-1 bg-emerald-600 text-white text-[5px] font-semibold px-1.5 py-0.5 rounded">Book Now</span>
                                    </div>
                                    <div class="w-10 h-10 rounded-full bg-white/40 flex-shrink-0"></div>
                                </div>
                                <div class="absolute bottom-1 left-1/2 -translate-x-1/2 flex gap-0.5">
                                    <template x-for="i in 3" :key="i">
                                        <span class="w-1 h-1 rounded-full transition-colors duration-300" :class="slide === i - 1 ? 'bg-[#0076D7]' : 'bg-white/70'"></span>
                                    </template>
                                </div>
                            </div>


                             

                        </div>

                        {{-- Ranked-higher business teaser card --}}
                        <div class="mx-2.5 border-2 border-[#0076D7] rounded-lg p-2 mb-2 relative flex-shrink-0 bg-white">
                            <div class="absolute -top-2 left-2 bg-[#0076D7] text-white text-[5px] px-1.5 py-0.5 rounded whitespace-nowrap">
                                Your Business Will Get Ranked Higher
                            </div>
                            <div class="flex items-center gap-1.5 mt-1">
                                <div class="w-7 h-7 bg-blue-100 rounded flex items-center justify-center relative">
                                    <span class="text-[7px] text-[#0076D7] font-bold">ETI</span>
                                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#22c55e] rounded-full border border-white anim-ping-slow"></span>
                                </div>
                                <div>
                                    <div class="text-[7px] font-semibold">ElevateTech India</div>
                                    <div class="flex items-center gap-0.5">
                                        <svg class="w-2 h-2 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279L12 19.771l-7.416 3.642 1.48-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                        <span class="text-[6px]">4.6 &#9733;</span>
                                        <span class="text-[6px]">Lift Manufacturer, Lift Modernization, New Lift Installation</span>
                                    </div>
                                </div>
                            </div>


                            <div class="flex gap-1 mt-1.5">
                                @foreach(['Call Now', 'Send Enquiry', 'Chat'] as $a)
                                    <span class="text-[5px] bg-[#0076D7] text-white rounded px-1 py-0.5">{{ $a }}</span>
                                @endforeach
                            </div>
                        </div>


   {{-- Ranked-higher business teaser card --}}
                        <div class="mx-2.5 border-2 border-[#0076D7] rounded-lg p-2 mb-2 relative flex-shrink-0 bg-white">
                            <div class="absolute -top-2 left-2 bg-[#0076D7] text-white text-[5px] px-1.5 py-0.5 rounded whitespace-nowrap">
                                Your Business Will Get 2nd Ranked Higher
                            </div>
                            <div class="flex items-center gap-1.5 mt-1">
                                <div class="w-7 h-7 bg-blue-100 rounded flex items-center justify-center relative">
                                    <span class="text-[7px] text-[#0076D7] font-bold">WST</span>
                                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#22c55e] rounded-full border border-white anim-ping-slow"></span>
                                </div>
                                <div>
                                    <div class="text-[7px] font-semibold">Web Solution Technology</div>
                                    <div class="flex items-center gap-0.5">
                                        <svg class="w-2 h-2 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279L12 19.771l-7.416 3.642 1.48-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                        <span class="text-[6px]">4.8 &#9733;</span>
                                        <span class="text-[6px]">Website development, E-commerce website development, Responsive web design, App Developer</span>
                                    </div>
                                </div>
                            </div>


                            <div class="flex gap-1 mt-1.5">
                                @foreach(['Call Now', 'Send Enquiry', 'Chat'] as $a)
                                    <span class="text-[5px] bg-[#0076D7] text-white rounded px-1 py-0.5">{{ $a }}</span>
                                @endforeach
                            </div>
                        </div>




                        {{-- Categories --}}
                        @php
                            // ⚠️ Placeholder labels — replace with your real top-8 category list + slugs once confirmed.
                            $mockCategories = [
                                ['icon' => 'graduation-cap', 'label' => 'Corporate Training'],
                                ['icon' => 'heart',          'label' => 'Wedding Functions'],
                                ['icon' => 'scissors',       'label' => 'Salon'],
                                ['icon' => 'wrench',         'label' => 'Plumber'],
                                ['icon' => 'landmark',       'label' => 'Government'],
                                ['icon' => 'truck',          'label' => 'Packers & Movers'],
                                ['icon' => 'camera',         'label' => 'Photography'],
                                ['icon' => 'grid',           'label' => 'More'],
                            ];
                        @endphp
                        <div class="px-2.5 mb-2 flex-1 overflow-hidden">
                            <div class="text-[6.5px] font-bold text-gray-700 mb-1">Categories</div>
                            <div class="grid grid-cols-4 gap-x-1 gap-y-1.5">
                                @foreach($mockCategories as $cat)
                                    <div class="flex flex-col items-center gap-0.5">
                                        <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center">
                                            <i data-lucide="{{ $cat['icon'] }}" class="w-3 h-3 text-[#0076D7]"></i>
                                        </div>
                                        <span class="text-[4.5px] text-gray-600 text-center leading-tight">{{ $cat['label'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Floating action button --}}
                        <div class="absolute right-2.5 bottom-14 w-6 h-6 rounded-full bg-[#0076D7] shadow-lg flex items-center justify-center anim-pulse-ring">
                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </div>

                        {{-- Bottom tab bar --}}
                        <div class="bg-white border-t border-gray-100 px-2.5 py-2 flex items-center justify-between mt-auto flex-shrink-0">
                            <div class="flex flex-col items-center gap-0.5">
                                <svg class="w-2.5 h-2.5 text-[#0076D7]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3l9 8h-3v9h-4v-6H10v6H6v-9H3z"/></svg>
                                <span class="text-[5px] text-[#0076D7] font-semibold">Home</span>
                            </div>
                            <div class="flex flex-col items-center gap-0.5">
                                <svg class="w-2.5 h-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                <span class="text-[5px] text-gray-400">Category</span>
                            </div>
                            <div class="flex flex-col items-center gap-0.5">
                                <svg class="w-2.5 h-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="text-[5px] text-gray-400">Profile</span>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </section>

    {{-- ===== STATS BAR ===== --}}
    <section class="bg-[#0076D7] py-10 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-white relative z-10">
            @foreach([
                ['to' => 379, 'suffix' => '+', 'label' => 'Active Categories'],
                ['to' => 95, 'suffix' => '%', 'label' => 'Lead Response Rate'],
                ['to' => 24, 'suffix' => '/7', 'label' => 'Customer Support'],
                ['to' => 4, 'suffix' => '.8★', 'label' => 'Avg. Advertiser Rating'],
            ] as $i => $stat)
                <div data-reveal data-reveal-delay="{{ $i * 120 }}">
                    <div class="text-3xl font-bold" data-counter="{{ $stat['to'] }}" data-suffix="{{ $stat['suffix'] }}">0</div>
                    <div class="text-blue-200 text-sm mt-1">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ===== SUCCESS STORIES ===== --}}
    @php
        $testimonials = [
            ['name' => 'Rajesh Chhabria', 'business' => 'Chhabria and Sons', 'category' => 'Sanitaryware dealers', 'quote' => "From 1 showroom to 4 in 20 years, QuickDials's growing returns have helped us to dominate the market.", 'since' => '14 years'],
            ['name' => 'Varshini', 'business' => 'V2 Makeover', 'category' => 'Makeup artists', 'quote' => 'Genuine leads from QuickDials keep my business active and support me as a woman entrepreneur.', 'since' => '4 years'],
            ['name' => 'Gourab Neogi', 'business' => 'Tally Academy', 'category' => 'Computer training institutes', 'quote' => 'QuickDials helped increase our profit from 9% to 63% and strengthened our marketing and business.', 'since' => '7 years'],
            ['name' => 'Priya Sharma', 'business' => 'Bliss Beauty Studio', 'category' => 'Beauty salons', 'quote' => 'My customer base tripled in just 2 years. QuickDials brings verified, ready-to-book clients every day.', 'since' => '5 years'],
        ];
        $avatarColors = ['#0076D7', '#22c55e', '#f97316', '#a855f7', '#06b6d4'];
    @endphp
    <!-- <section id="success-stories" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-start">
                <div class="md:w-56 flex-shrink-0" data-reveal data-reveal-from="left">
                    <div class="text-7xl text-gray-200 font-serif leading-none select-none">"</div>
                    <h2 class="text-2xl font-bold text-gray-800 mt-2">Success Stories</h2>
                    <p class="text-[#0076D7] font-semibold mt-1">6.3 Lakh+ Advertisers</p>
                    <button class="mt-4 border-2 border-[#0076D7] text-[#0076D7] px-5 py-2 rounded-lg text-sm font-semibold hover:bg-[#0076D7] hover:text-white hover:scale-105 transition-all duration-300">
                        See All Stories
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 flex-1">
                    @foreach($testimonials as $i => $t)
                        @php
                            $initials = collect(explode(' ', $t['name']))->map(fn($n) => $n[0])->join('');
                            $color = $avatarColors[strlen($t['name']) % count($avatarColors)];
                        @endphp
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2"
                             data-reveal data-reveal-delay="{{ $i * 120 }}">
                            <div class="relative h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden group">
                                <div class="w-20 h-20 rounded-full flex items-center justify-center text-white text-2xl font-bold transition-transform duration-300 group-hover:scale-110" style="background: {{ $color }};">
                                    {{ $initials }}
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <button class="w-12 h-12 rounded-full bg-white/90 flex items-center justify-center shadow-lg hover:bg-white hover:scale-110 transition-all duration-300">
                                        <svg class="w-5 h-5 fill-[#0076D7] text-[#0076D7] ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </button>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-black/40 to-transparent"></div>
                                <div class="absolute bottom-2 left-3 text-white">
                                    <p class="text-xs font-semibold">{{ $t['name'] }}</p>
                                    <p class="text-[10px] opacity-80">{{ $t['business'] }}</p>
                                </div>
                            </div>
                            <div class="p-4">
                                <span class="text-[10px] bg-blue-50 text-[#0076D7] px-2 py-0.5 rounded-full font-medium">{{ $t['category'] }}</span>
                                <p class="mt-2 text-xs text-gray-600 leading-relaxed line-clamp-3">"{{ $t['quote'] }}"</p>
                                <p class="mt-2 text-[10px] text-gray-400">Customer since {{ $t['since'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>-->

    {{-- ===== BENEFITS ===== --}}
    
    <section id="benefits" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12" data-reveal>
                <h2 class="text-3xl font-bold text-gray-900">Advertise on Quick Dials: Grow Your Business with Greater Online Visibility</h2>
              
                <h4 class="text-gray-500 mt-2 text-sm">Reach More Customers and Grow Faster with Quick Dials</h4>
<p>In the present-day competitive world of business, an online presence becomes important in order to attract more customers and remain ahead of your competitors. Quick Dials is a reliable business directory service that can help businesses reach out to those who are looking for their products or services. No matter whether you are a startup, a local business, or an already established business, Quick Dials will provide you with all necessary means for development.</p>

            </div>
         
        </div>
    </section>


     {{-- ===== CTA BANNER ===== --}}
    <section class="py-14 bg-[#0076D7] relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 anim-pulse-slow" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="max-w-3xl mx-auto px-4 text-center text-white relative z-10" data-reveal>
            <h2 class="text-3xl font-bold mb-3">Ready to Grow Your Business?</h2>
            <p class="text-blue-100 mb-8">Join 1.8 K+ businesses already thriving on QuickDials</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
              <a
    href="{{ route('login') }}"
    class="btn-shimmer bg-white text-[#0076D7] font-bold px-8 py-3 rounded-xl hover:bg-blue-50 hover:scale-105 transition-all duration-300 inline-block"
>
    Start Advertising Now
</a>
               
                <a
                    href="tel:+917559435943"
                    class="flex items-center justify-center gap-2 border-2 border-white text-white font-semibold px-8 py-3 rounded-xl hover:bg-white/10 hover:scale-105 transition-all duration-300"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.61 21 3 13.39 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/></svg>
                    Talk to Our Team
                </a>
            </div>
        </div>
    </section>



    @php
        $benefits = [
            ['icon' => 'users', 'title' => 'Attract More Potential Customers: ', 'desc' => "Let your business be discovered by those customers who are looking for your kind of products or services in your area and in different business categories."],
            ['icon' => 'trending-up', 'title' => 'Business Exposure: ', 'desc' => 'Enhance your online exposure using a professionally maintained listing of your business.'],
            ['icon' => 'map-pin', 'title' => 'Quality Lead Generation:', 'desc' => 'Gain leads which are actual customers who are actively seeking businesses such as yours.'],
            ['icon' => 'bar-chart-2', 'title' => 'Gain Customer Trust: ', 'desc' => 'Provide a detailed listing of your business along with all the necessary information including business details and customer testimonials.'],
            ['icon' => 'shield', 'title' => 'Business Listing Made Easy:', 'desc' => 'Manage your profile and other listings conveniently using an easy-to-use dashboard.'],
            ['icon' => 'message-square', 'title' => 'Budget-friendly Business Solutions: ', 'desc' => 'Select from a variety of advertising and listing plans tailored for all kinds of businesses.'],
        ];
    @endphp
    <section id="benefits" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12" data-reveal>
                <h2 class="text-3xl font-bold text-gray-900">Why Advertise on Quick Dials?</h2>
                <p class="text-gray-500 mt-2 text-sm">India's most trusted local search platform — built to grow your business</p>
                </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($benefits as $i => $b)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-[#0076D7]/30 group"
                         data-reveal data-reveal-delay="{{ $i * 90 }}">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <i data-lucide="{{ $b['icon'] }}" class="w-7 h-7 text-[#0076D7]"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">{{ $b['title'] }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $b['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>





    {{-- ===== FEATURES ===== --}}
    @php
        $features = [
            ['icon' => 'search', 'title' => 'Attract More Potential Customers: ', 'desc' => 'Let your business be discovered by those customers who are looking for your kind of products or services in your area and in different business categories.'],
            ['icon' => 'thumbs-up', 'title' => 'Business Exposure: ', 'desc' => 'Enhance your online exposure using a professionally maintained listing of your business.'],
            ['icon' => 'zap', 'title' => 'Quality Lead Generation: ', 'desc' => 'Gain leads which are actual customers who are actively seeking businesses such as yours.'],
            ['icon' => 'award', 'title' => 'Gain Customer Trust: ', 'desc' => 'Provide a detailed listing of your business along with all the necessary information including business details and customer testimonials.'],

            ['icon' => 'award', 'title' => 'Business Listing Made Easy: ', 'desc' => 'Manage your profile and other listings conveniently using an easy-to-use dashboard.'],


            ['icon' => 'award', 'title' => 'Budget-friendly Business Solutions: ', 'desc' => 'Select from a variety of advertising and listing plans tailored for all kinds of businesses'],

         ];
    @endphp
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12" data-reveal>
                <h2 class="text-3xl font-bold text-gray-900">Why Advertise on Quick Dials?</h2>
              
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($features as $i => $f)
                    <div class="flex gap-4 p-6 bg-white rounded-xl border border-gray-100 hover:border-[#0076D7] hover:shadow-lg transition-all duration-300 group"
                         data-reveal data-reveal-from="{{ $i % 2 === 0 ? 'left' : 'right' }}" data-reveal-delay="{{ $i * 100 }}">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-[#0076D7] rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300 group-hover:scale-110">
                            <i data-lucide="{{ $f['icon'] }}" class="w-6 h-6 text-[#0076D7] group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $f['title'] }}</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    




    {{-- ===== FEATURES ===== --}}
    @php
        $features = [
            ['icon' => 'search', 'title' => 'Business Listing Standard: ', 'desc' => 'Create a professional business listing to help customers locate your business easily on the internet.'],
            ['icon' => 'thumbs-up', 'title' => 'Business Listing Premium: ', 'desc' => 'Boost your presence and stand out from others by using premium business listings which will get you more enquiries.'],
            ['icon' => 'zap', 'title' => 'Featured Business Listing:', 'desc' => 'Get your business featured and increase your visibility among others in selected categories.'],
            ['icon' => 'award', 'title' => 'Leads Generation Solutions: ', 'desc' => 'Generate quality leads for yourself with the help of qualified customer enquiries received via your Quick Dials account.'],

            ['icon' => 'award', 'title' => 'Business Listing Made Easy: ', 'desc' => 'Manage your profile and other listings conveniently using an easy-to-use dashboard.'],

 
         ];
    @endphp
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12" data-reveal>
                <h2 class="text-3xl font-bold text-gray-900">Quick Dials Advertising Plans?</h2>
              
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($features as $i => $f)
                    <div class="flex gap-4 p-6 bg-white rounded-xl border border-gray-100 hover:border-[#0076D7] hover:shadow-lg transition-all duration-300 group"
                         data-reveal data-reveal-from="{{ $i % 2 === 0 ? 'left' : 'right' }}" data-reveal-delay="{{ $i * 100 }}">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-[#0076D7] rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300 group-hover:scale-110">
                            <i data-lucide="{{ $f['icon'] }}" class="w-6 h-6 text-[#0076D7] group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $f['title'] }}</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    



    {{-- ===== FEATURES ===== --}}
    @php
        $features = [
            ['icon' => 'search', 'title' => 'Build Your Business Profile ', 'desc' => 'Register for your business with accurate contact information, services, and other business details.'],
            ['icon' => 'thumbs-up', 'title' => 'Select the Appropriate Plan', 'desc' => 'Get an appropriate listing or advertising plan for your business in accordance with your requirements.'],
            ['icon' => 'zap', 'title' => 'Create Your Business Profile: ', 'desc' => 'Upload pictures of your business including logo, services offered, and working hours to get more customers.'],
            ['icon' => 'award', 'title' => 'Receive Inquiries from Customers', 'desc' => 'With the active profile, customers will be able to find your business and make inquiries through Quick Dials.'],

            ['icon' => 'award', 'title' => 'Start Growing Your Business with Quick Dials ', 'desc' => 'If you aim to boost your brand awareness, bring in more customers from the locality, or get high-quality business leads, then Quick Dials can serve as an effective platform for you. Be part of many businesses who have built their online presence with Quick Dials..'],

 
         ];
    @endphp
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12" data-reveal>
                <h2 class="text-3xl font-bold text-gray-900">How to Get Started with Quick Dials?</h2>
              
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($features as $i => $f)
                    <div class="flex gap-4 p-6 bg-white rounded-xl border border-gray-100 hover:border-[#0076D7] hover:shadow-lg transition-all duration-300 group"
                         data-reveal data-reveal-from="{{ $i % 2 === 0 ? 'left' : 'right' }}" data-reveal-delay="{{ $i * 100 }}">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-[#0076D7] rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300 group-hover:scale-110">
                            <i data-lucide="{{ $f['icon'] }}" class="w-6 h-6 text-[#0076D7] group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $f['title'] }}</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    


     {{-- ===== CTA BANNER ===== --}}
    <section class="py-14 bg-[#0076D7] relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 anim-pulse-slow" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="max-w-3xl mx-auto px-4 text-center text-white relative z-10" data-reveal>
            <h2 class="text-3xl font-bold mb-3">Ready to Grow Your Business?</h2>
            <p class="text-blue-100 mb-8">Join 1.8 K+ businesses already thriving on QuickDials</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                 <a
    href="{{ route('login') }}"
    class="btn-shimmer bg-white text-[#0076D7] font-bold px-8 py-3 rounded-xl hover:bg-blue-50 hover:scale-105 transition-all duration-300 inline-block"
>
    Start Advertising Now
</a>
               
                <a
                    href="tel:+917559435943"
                    class="flex items-center justify-center gap-2 border-2 border-white text-white font-semibold px-8 py-3 rounded-xl hover:bg-white/10 hover:scale-105 transition-all duration-300"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.61 21 3 13.39 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/></svg>
                    Talk to Our Team
                </a>
            </div>
        </div>
    </section>


    {{-- ===== FEATURES ===== --}}
    @php
        $features = [
            ['icon' => 'search', 'title' => 'Business Listing', 'desc' => 'List your business and ensure that customers can find out about your services through the Internet.'],
            ['icon' => 'thumbs-up', 'title' => 'Verified Business Listing', 'desc' => 'Gain credibility with customers by creating a verified business listing.'],
            ['icon' => 'zap', 'title' => 'Lead Generation', 'desc' => 'Get genuine leads from customers who are interested in your services and products.'],
            ['icon' => 'award', 'title' => 'Smart Lead Management', 'desc' => 'Manage all the customer leads using one simple interface.'],

            ['icon' => 'award', 'title' => 'Smart Lead Management', 'desc' => 'Manage all the customer leads using one simple interface.'],


            ['icon' => 'award', 'title' => 'Business Profile Management', 'desc' => 'Edit your contact info, business hours, services offered, and any other business information you wish to add'],



            ['icon' => 'award', 'title' => 'Product/Service Offering', 'desc' => 'Promote your products and services to get more customers.'],


            ['icon' => 'award', 'title' => 'Photo/Videos', 'desc' => 'Upload photos and videos about your business for customers to see.'],


            ['icon' => 'award', 'title' => 'Reviews/Ratings', 'desc' => 'Gather customer opinions through their reviews and ratings.'],


['icon' => 'award', 'title' => 'Business Analysis', 'desc' => 'Analyze the number of times your profile has been viewed, customers who have interacted, and other metrics to measure your business`s success.'],


['icon' => 'award', 'title' => 'Search Visibility', 'desc' => 'Increase your chances of being seen by customers in their search results.'],

['icon' => 'award', 'title' => 'Integration of Location & Map', 'desc' => 'Help your customers locate you easily through proper addresses and maps.'],

['icon' => 'award', 'title' => 'Direct Communication to Customers', 'desc' => 'Enable your customers to connect with you immediately via phone calls, messages, or enquiries.'],

['icon' => 'award', 'title' => 'Listing Your Business Multi-Categories', 'desc' => 'List your business in multiple categories so as to increase the visibility of your business.'],

['icon' => 'award', 'title' => 'Promote Your Business', 'desc' => 'Make your business stand out by using promotional tools for your business.'],

['icon' => 'award', 'title' => 'Customer Support', 'desc' => 'Have all your support needs covered regarding your business listing and account.'],

['icon' => 'award', 'title' => 'Responsive Experience', 'desc' => 'Manage your business listings and replies from customers from wherever you may be, anytime.'],

['icon' => 'award', 'title' => 'Security in One Business Dashboard', 'desc' => 'Have access to all your business data in one business dashboard.'],

['icon' => 'award', 'title' => 'Updating Your Business Profile', 'desc' => 'Update your business profiles regularly for increased visibility to your customers.'],




        ];
    @endphp
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12" data-reveal>
                <h2 class="text-3xl font-bold text-gray-900">Powerful Features for Your Business</h2>
                <p class="text-gray-500 mt-2 text-sm">Everything you need to attract, convert, and retain customers</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($features as $i => $f)
                    <div class="flex gap-4 p-6 bg-white rounded-xl border border-gray-100 hover:border-[#0076D7] hover:shadow-lg transition-all duration-300 group"
                         data-reveal data-reveal-from="{{ $i % 2 === 0 ? 'left' : 'right' }}" data-reveal-delay="{{ $i * 100 }}">
                        <div class="w-12 h-12 bg-blue-50 group-hover:bg-[#0076D7] rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300 group-hover:scale-110">
                            <i data-lucide="{{ $f['icon'] }}" class="w-6 h-6 text-[#0076D7] group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $f['title'] }}</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== PRICING ===== --}}
    <section id="pricing" class="py-20 bg-slate-100/60">
        <div class="container mx-auto px-4 md:px-6">

            <div class="text-center mb-14" data-reveal>
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-snug tracking-tight mb-4">
                    Welcome to
                    <span class="text-indigo-600">
                        QuickDials<sup class="text-amber-500 text-2xl font-normal align-super">™</sup>
                    </span><span class="text-gray-900">.com</span>
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed">
                    Pick a plan that suits your business size and how fast you want to grow. Every package gives you easy system access and tools to manage your enquiries smoothly. Higher plans come with more user access and extra coins, which help you reach more customers and handle more requests. All plans are made to keep things simple, clear, and easy to use for your daily business needs.
                </p>
                <div class="w-24 h-1 bg-indigo-600 mx-auto mt-6 rounded-full"></div>
            </div>

            @php
            $packages = [
                [
                    'name'        => 'INR ₹ 0 Free',
                    'price'       => 'Coins (555)',
                    'description' => 'Long time system login access',
                    'gradient'    => 'from-green-50 to-gray-100',
                    'border'      => 'border-gray-200',
                    'badge'       => null,
                    'cta'         => 'Get Started',
                    'cta_style'   => 'outline',
                    'features'    => [
                        'Online system',
                        'Full access',
                        'Push Notification',
                        'Roles & Permissions',
                        'Coins (555) Free First Time',
                        'Verified & Unique Leads Only',
                        'Spam-Free & Duplicate-Free Leads',
                        'Fresh Leads, Every Time',
                        'Get 1 Free Service After Every 3 Bookings',
                    ],
                ],
                [
                    'name'        => 'INR ₹ 1000',
                    'price'       => 'Coins (1111)',
                    'description' => 'Long time system login access',
                    'gradient'    => 'from-indigo-50 to-indigo-100',
                    'border'      => 'border-indigo-300',
                    'badge'       => 'Most Popular',
                    'cta'         => 'Choose Premium',
                    'cta_style'   => 'solid',
                    'features'    => [
                        'Online system',
                        'Full access',
                        '100% Verified & Unique Leads',
                        'Roles & Permissions',
                        'Unlimited support',
                        'Verified & Unique Leads Only',
                        'Spam-Free & Duplicate-Free Leads',
                        'Fresh Leads, Every Time',
                        'Get 1 Free Service After Every 3 Bookings',
                    ],
                ],
                [
                    'name'        => 'INR ₹ 2000',
                    'price'       => 'Coins (2272)',
                    'description' => 'Long time system login access',
                    'gradient'    => 'from-indigo-50 to-indigo-100',
                    'border'      => 'border-indigo-300',
                    'badge'       => null,
                    'cta'         => 'Get Started',
                    'cta_style'   => 'solid',
                    'features'    => [
                        'Online system',
                        'Full access',
                        'Push Notification',
                        'Roles & Permissions',
                        'Verified & Unique Leads Only',
                        'Spam-Free & Duplicate-Free Leads',
                        'Fresh Leads, Every Time',
                        'Get 1 Free Service After Every 3 Bookings',
                    ],
                ],
                [
                    'name'        => 'INR ₹ 3000',
                    'price'       => 'Coins (3529)',
                    'description' => 'Unlimited Users Access',
                    'gradient'    => 'from-green-50 to-gray-100',
                    'border'      => 'border-gray-200',
                    'badge'       => null,
                    'cta'         => 'Get Started',
                    'cta_style'   => 'outline',
                    'features'    => [
                        'Online system',
                        'Full access',
                        'Push Notification',
                        'Roles & Permissions',
                        'Coins (3529) Free First Time',
                        'Verified & Unique Leads Only',
                        'Spam-Free & Duplicate-Free Leads',
                        'Fresh Leads, Every Time',
                        'Get 1 Free Service After Every 3 Bookings',
                    ],
                ],
                [
                    'name'        => 'INR ₹ 5000',
                    'price'       => 'Coins (6099)',
                    'description' => 'Unlimited Users Access',
                    'gradient'    => 'from-indigo-50 to-indigo-100',
                    'border'      => 'border-indigo-300',
                    'badge'       => 'Most Popular',
                    'cta'         => 'Choose Premium',
                    'cta_style'   => 'solid',
                    'features'    => [
                        'Online system',
                        'Full access',
                        'Push Notification',
                        'Roles & Permissions',
                        'Unlimited support',
                        'Verified & Unique Leads Only',
                        'Spam-Free & Duplicate-Free Leads',
                        'Fresh Leads, Every Time',
                        'Get 1 Free Service After Every 3 Bookings',
                    ],
                ],
                [
                    'name'        => 'INR ₹ 10000',
                    'price'       => 'Coins (12500)',
                    'description' => 'Unlimited Users Access',
                    'gradient'    => 'from-amber-50 to-yellow-50',
                    'border'      => 'border-amber-200',
                    'badge'       => 'Best Value',
                    'cta'         => 'Go Royal',
                    'cta_style'   => 'outline',
                    'features'    => [
                        'Online system',
                        'Luxury 5-star venue booking',
                        'Full access',
                        'Push Notification',
                        'Roles & Permissions',
                        'Unlimited support',
                        'Verified & Unique Leads Only',
                        'Spam-Free & Duplicate-Free Leads',
                        'Fresh Leads, Every Time',
                        'Get 1 Free Service After Every 3 Bookings',
                    ],
                ],
            ];
            @endphp

            <div class="grid md:grid-cols-3 gap-7 max-w-6xl mx-auto items-stretch">
                @foreach($packages as $i => $pkg)
                <div class="pkg-card relative flex flex-col rounded-3xl border-2 {{ $pkg['border'] }} bg-gradient-to-b {{ $pkg['gradient'] }} shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 {{ $pkg['badge'] === 'Most Popular' ? 'md:scale-105 ring-2 ring-indigo-200' : '' }}"
                     data-reveal data-reveal-delay="{{ $i * 100 }}">

                    @if($pkg['badge'])
                    <div class="absolute top-5 right-5">
                        <span class="inline-flex items-center gap-1 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow anim-bounce-in" style="animation-delay: {{ 0.4 + $i * 0.1 }}s">
                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ $pkg['badge'] }}
                        </span>
                    </div>
                    @endif

                    <div class="p-8 flex-1 flex flex-col">

                        <div class="mb-5">
                            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $pkg['name'] }}</h3>
                            <p class="text-gray-500 text-sm">{{ $pkg['description'] }}</p>
                        </div>

                        <div class="mb-7">
                            <span class="text-4xl font-bold text-gray-900">{{ $pkg['price'] }}</span>
                            <span class="text-gray-400 ml-2 text-sm">starting from</span>
                        </div>

                        <ul class="space-y-3 mb-8 flex-1">
                            @foreach($pkg['features'] as $feature)
                            <li class="flex items-start gap-3 text-sm text-gray-700">
                                <div class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>

                        @if($pkg['cta_style'] === 'solid')
                            <button class="btn-shimmer w-full py-3.5 rounded-full font-semibold text-base text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-300/40 hover:shadow-indigo-400/50 hover:scale-105 transition-all duration-300">
                                {{ $pkg['cta'] }}
                            </button>
                        @else
                            <button class="w-full py-3.5 rounded-full font-semibold text-base text-indigo-600 border-2 border-indigo-300 hover:bg-indigo-600 hover:text-white hover:scale-105 transition-all duration-300">
                                {{ $pkg['cta'] }}
                            </button>
                        @endif

                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ===== CTA BANNER ===== --}}
    <section class="py-14 bg-[#0076D7] relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 anim-pulse-slow" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="max-w-3xl mx-auto px-4 text-center text-white relative z-10" data-reveal>
            <h2 class="text-3xl font-bold mb-3">Ready to Grow Your Business?</h2>
            <p class="text-blue-100 mb-8">Join 1.8 K+ businesses already thriving on QuickDials</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                 <a
    href="{{ route('login') }}"
    class="btn-shimmer bg-white text-[#0076D7] font-bold px-8 py-3 rounded-xl hover:bg-blue-50 hover:scale-105 transition-all duration-300 inline-block"
>
    Start Advertising Now
</a>
               
                <a
                    href="tel:+917559435943"
                    class="flex items-center justify-center gap-2 border-2 border-white text-white font-semibold px-8 py-3 rounded-xl hover:bg-white/10 hover:scale-105 transition-all duration-300"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.61 21 3 13.39 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/></svg>
                    Talk to Our Team
                </a>
            </div>
        </div>
    </section>

    {{-- ===== FAQs ===== --}}
    @php
        $faqs = [
            ['q' => 'Why should I include my business on Quick Dials?', 'a' => 'Including your business on Quick Dials allows you to increase your visibility online, connect with more local clients, and get actual queries regarding your business.'],
            ['q' => 'How can I begin using Quick Dials?', 'a' => 'All you have to do is just fill in your information, make a profile of your business, and select a package according to your business requirements.'],
            ['q' => 'Which kind of businesses can sign up for Quick Dials?', 'a' => 'Quick Dials works for all businesses whether it is local stores, service businesses, start-ups, professionals, or well-established enterprises.'],
            ['q' => 'How will I receive inquiries from customers?', 'a' => 'You will be receiving customer queries through phone calls, inquiry forms, or other ways which are available on your business profile.'],
            ['q' => 'Am I able to update my business profile whenever I want?', 'a' => 'Yes. You can update your business profile, contacts, services, operating hours, and other details whenever required.'],
            ['q' => 'Which plan should I choose?', 'a' => 'We have made our plans keeping different business objectives in mind. You can check the features available or consult us for making the best choice.'],
            ['q' => 'Should my business profile be verified?', 'a' => 'Yes. If your business qualifies then you can get your profile verified for more credibility and customer identification.'],
            ['q' => 'Can I change my plan?', 'a' => 'Of course. You have the option to change your plan anytime in order to get access to more features and expand your business reach.'],
            ['q' => 'Can I target customers from specific locations?', 'a' => 'Yes. Based on your choice of the plan, you will be able to focus on your visibility in specific cities that are pertinent to your business.'],
            ['q' => 'What kind of support do you offer?', 'a' => 'Our dedicated support staff can help you in account set-up, managing your profile and any questions related to your plan.'],
            ['q' => 'How will I know about my business inquiries?', 'a' => 'Your business dashboard will allow you to keep track of all the inquiries made by your customers.'],
        ];
    @endphp
    <section id="faqs" class="py-16 bg-white">
        <div class="mx-auto px-4">
            <div class="text-center mb-10" data-reveal>
                <h2 class="text-3xl font-bold text-gray-900">Frequently Asked Questions</h2>
                <p class="text-gray-500 mt-2 text-sm">Everything you need to know before getting started</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-6 py-2" data-reveal>
                @foreach($faqs as $faq)
                    <div x-data="{ open: false }" class="border-b border-gray-200 last:border-0">
                        <button
                            @click="open = !open"
                            class="w-full flex justify-between items-center py-4 text-left text-sm font-medium text-gray-800 hover:text-[#0076D7] transition-colors"
                        >
                            {{ $faq['q'] }}
                            <svg class="w-4 h-4 flex-shrink-0 text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180 text-[#0076D7]' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="overflow-hidden"
                            style="display:none;"
                        >
                            <p class="pb-4 text-sm text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== STICKY MOBILE CTA (conversion booster — visible only on small screens) ===== --}}
    <div
        x-data="{ show: false }"
        x-init="window.addEventListener('scroll', () => show = window.scrollY > 500)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-full opacity-0"
        class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 shadow-2xl px-4 py-3 flex items-center gap-3"
        style="display:none;"
    >
        <a href="tel:+918888888888" class="flex-1 flex items-center justify-center gap-1.5 border-2 border-[#0076D7] text-[#0076D7] font-semibold py-2.5 rounded-lg text-sm">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.61 21 3 13.39 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/></svg>
            Call
        </a>
        <button @click="scrollTo('hero')" class="flex-1 bg-[#0076D7] text-white font-semibold py-2.5 rounded-lg text-sm">
            Advertise Now
        </button>
    </div>
    

</div>

{{-- ===== Scroll-reveal engine + counter animation ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) window.lucide.createIcons();

    // ── Scroll-reveal: fade + directional slide-in, staggered via data-reveal-delay ──
    var revealEls = document.querySelectorAll('[data-reveal]');
    var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var delay = parseInt(entry.target.getAttribute('data-reveal-delay') || '0', 10);
                setTimeout(function () {
                    entry.target.classList.add('reveal-visible');
                }, delay);
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    revealEls.forEach(function (el) { revealObserver.observe(el); });

    // ── Animated counters ──
    document.querySelectorAll('[data-counter]').forEach(function (el) {
        var to = parseInt(el.getAttribute('data-counter'), 10);
        var suffix = el.getAttribute('data-suffix') || '';
        var format = el.getAttribute('data-format');
        var started = false;

        function formatValue(n) {
            if (format === 'crore') return (n / 10000000).toFixed(1) + ' Crore';
            if (format === 'lakh') return (n / 100000).toFixed(1) + ' Lakh';
            return n.toString();
        }

        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && !started) {
                    started = true;
                    var dur = 1800;
                    var startTime = null;

                    function tick(now) {
                        if (!startTime) startTime = now;
                        var progress = Math.min((now - startTime) / dur, 1);
                        var eased = 1 - Math.pow(1 - progress, 3); // ease-out-cubic
                        var current = Math.floor(eased * to);
                        el.textContent = formatValue(current) + (progress >= 1 ? suffix : '');
                        if (progress < 1) {
                            requestAnimationFrame(tick);
                        } else {
                            el.textContent = formatValue(to) + suffix;
                        }
                    }
                    requestAnimationFrame(tick);
                }
            });
        }, { threshold: 0.3 });

        counterObserver.observe(el);
    });
});
</script>

<style>
    /* ── Scroll-reveal base states ── */
    [data-reveal] {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }
    [data-reveal][data-reveal-from="left"] { transform: translateX(-40px); }
    [data-reveal][data-reveal-from="right"] { transform: translateX(40px); }
    [data-reveal].reveal-visible {
        opacity: 1;
        transform: translate(0, 0);
    }

    /* ── Ambient hero blobs ── */
    @keyframes pulseSlow {
        0%, 100% { opacity: 0.5; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.08); }
    }
    .anim-pulse-slow { animation: pulseSlow 6s ease-in-out infinite; }

    /* ── Floating phone mockup ── */
    @keyframes floatY {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .anim-float { animation: floatY 4.5s ease-in-out infinite; }

    /* ── Bounce-in for checkmark / badges ── */
    @keyframes bounceIn {
        0% { opacity: 0; transform: scale(0.3); }
        60% { opacity: 1; transform: scale(1.15); }
        100% { opacity: 1; transform: scale(1); }
    }
    .anim-bounce-in { animation: bounceIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both; }

    /* ── Animated gradient headline text ── */
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    .text-gradient-anim {
        background: linear-gradient(90deg, #0076D7, #22c55e, #0076D7);
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: gradientShift 4s ease-in-out infinite;
    }

    /* ── Notification "online" dot ping ── */
    @keyframes pingSlow {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.6); }
        100% { box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
    }
    .anim-ping-slow { animation: pingSlow 1.8s ease-out infinite; }

    /* ── Floating action button pulse ring ── */
    @keyframes pulseRing {
        0%, 100% { box-shadow: 0 0 0 0 rgba(0, 118, 215, 0.4); }
        50% { box-shadow: 0 0 0 5px rgba(0, 118, 215, 0); }
    }
    .anim-pulse-ring { animation: pulseRing 2.2s ease-in-out infinite; }

    /* ── Shimmer sweep on primary buttons ── */
    .btn-shimmer { position: relative; overflow: hidden; }
    .btn-shimmer::after {
        content: '';
        position: absolute;
        top: 0; left: -75%;
        width: 50%; height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.5), transparent);
        transform: skewX(-20deg);
        transition: left 0.6s ease;
    }
    .btn-shimmer:hover::after { left: 125%; }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ── Respect reduced-motion preference ── */
    @media (prefers-reduced-motion: reduce) {
        [data-reveal] {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }
        .anim-pulse-slow, .anim-float, .anim-bounce-in, .anim-ping-slow, .anim-pulse-ring, .text-gradient-anim {
            animation: none !important;
        }
        .btn-shimmer::after { display: none; }
    }
</style>

 



@endsection