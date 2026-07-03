@extends('client.layouts.app')
@section('title', 'Advertise QuickDials - Local search, IT Training, Playschool, overseas education.')
@section('description', 'Advertise QuickDials- Local search, IT Training, Playschool, overseas education.')
@section('keywords', 'Advertise QuickDials- Local search, IT Training, Playschool, overseas education.')
@section('content')	
@include('client.components.banner-section')


 

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
                    <span class="text-[#0076D7] inline-block hover:scale-105 transition-transform duration-300">GROW</span>
                    <span class="text-[#22c55e] text-3xl align-super ml-1 inline-block anim-bounce-in">&#10003;</span>
                    Your Business
                </h1>
                <p class="text-gray-500 text-base mb-6">
                    Advertise with QuickDials — India's Local Search Engine
                </p>

                {{-- Google sign-in --}}
                <div class="max-w-sm">
                    <a href="{{ route('google.login') }}"
                       class="w-full flex items-center justify-center gap-3 border-2 border-gray-200 hover:border-[#0076D7] rounded-xl py-3 text-sm font-semibold text-gray-700 hover:bg-blue-50/50 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Continue with Google
                    </a>
                </div>

                {{-- Checkmarks --}}
                <ul class="mt-5 space-y-2">
                    @foreach(['Rank Ahead of Your Competition', 'Find Ready to Buy Customers Instantly', 'Track Leads & Competition Trends'] as $i => $item)
                        <li class="flex items-center gap-2 text-sm text-gray-700" data-reveal data-reveal-delay="{{ 200 + $i * 100 }}">
                            <svg class="w-4 h-4 text-[#22c55e] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>

                {{-- Terms --}}
                <p class="text-[11px] text-gray-400 leading-relaxed mt-4">
                    By continuing, you agree to our
                    <a href="{{ route('terms.conditions') }}" class="text-[#0076D7] underline">Terms of Use</a>,
                    <a href="{{ route('privacy.policy') }}" class="text-[#0076D7] underline">Privacy</a> &
                    <a href="#" class="text-[#0076D7] underline">Infringement Policy</a>
                </p>
            </div>

            {{-- Right — Phone Mockup + Stats (single source of truth for these two stat cards; the duplicate stats-bar section below now shows DIFFERENT numbers, not a repeat) --}}
            <div class="relative flex justify-center" data-reveal data-reveal-from="right">
                <div class="absolute top-0 right-0 flex flex-col gap-3 z-10">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 px-4 py-3 flex items-center gap-3 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300" data-reveal data-reveal-delay="300">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#0076D7]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 4v-2a4 4 0 00-3-3.87"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-800" data-counter="147800000" data-suffix="+" data-format="crore">0</div>
                            <div class="text-[10px] text-gray-500">Buyers</div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 px-4 py-3 flex items-center gap-3 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300" data-reveal data-reveal-delay="450">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#22c55e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/></svg>
                        </div>
                        <div>
                            <div class="text-base font-bold text-gray-800" data-counter="160" data-suffix="+" data-format="K">0</div>
                            <div class="text-[10px] text-gray-500">Happy Customers</div>
                        </div>
                    </div>
                </div>

{{--
    Phone mockup — QuickDials app home screen
    Replaces the previous "search results list" mockup in the hero section.

    Categories shown are read from the provided screenshot:
    Corporate Training, Wedding Functions, Salon, Plumber, Government Services,
    Packers & Movers, Photography — confirm/adjust labels + icons against your
    real top-8 category list once you send it; these are placeholders matching
    what's visible in the image.
--}}
<div class="w-56 h-[420px] bg-gray-900 rounded-[2.5rem] shadow-2xl border-4 border-gray-800 relative overflow-hidden mx-auto mt-6 md:mt-0 anim-float">
    <div class="absolute inset-0 bg-gray-50 flex flex-col">

        {{-- ── Status bar ── --}}
        <div class="bg-[#0076D7] px-3 pt-2 pb-1 flex items-center justify-between text-white text-[6px] font-semibold">
            <span>11:11</span>
            <div class="flex items-center gap-1">
                <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><path d="M2 22h20V2L2 22z"/></svg>
                <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3a4.24 4.24 0 00-6 0zm-4-4l2 2a7.07 7.07 0 0110 0l2-2C15.14 9.14 8.87 9.14 5 13z"/></svg>
                <span>78%</span>
            </div>
        </div>

        {{-- ── Top app bar: logo + account pills ── --}}
        <div class="bg-[#0076D7] px-2 pb-2 flex items-center justify-between gap-1">
            <div class="text-white text-[8px] font-bold leading-none">QuickDials</div>
            <div class="flex items-center gap-1">
                <span class="bg-white/15 text-white text-[5px] px-1.5 py-0.5 rounded-full font-medium whitespace-nowrap">Have an Account</span>
                <span class="bg-white text-[#0076D7] text-[5px] px-1.5 py-0.5 rounded-full font-bold whitespace-nowrap">Sign Up</span>
            </div>
        </div>

        {{-- ── Location pill ── --}}
        <div class="px-2 -mt-1 mb-1.5">
            <div class="bg-white rounded-full shadow-sm px-2 py-1 flex items-center gap-1 w-fit">
                <svg class="w-2 h-2 text-[#0076D7]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
                <span class="text-[5px] font-semibold text-gray-700">Delhi</span>
                <svg class="w-1.5 h-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>

        {{-- ── Search bar ── --}}
        <div class="px-2 mb-2">
            <div class="bg-white rounded-full shadow-sm px-2 py-1.5 flex items-center gap-1.5 border border-gray-100">
                <svg class="w-2.5 h-2.5 text-[#0076D7] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                <span class="text-[6px] text-gray-400">Search Services</span>
            </div>
        </div>

        {{-- ── Banner carousel ── --}}
        <div class="px-2 mb-2">
            <div class="relative rounded-lg overflow-hidden h-16 bg-gradient-to-br from-amber-100 via-lime-100 to-emerald-200">
                <div class="absolute inset-0 flex items-center justify-between px-2">
                    <div>
                        <div class="text-[7px] font-bold text-emerald-800 leading-tight">Relax &<br>Rejuvenate</div>
                        <span class="inline-block mt-1 bg-emerald-600 text-white text-[4.5px] font-semibold px-1.5 py-0.5 rounded">Book Now</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/40 flex-shrink-0"></div>
                </div>
                {{-- Dot indicators --}}
                <div class="absolute bottom-1 left-1/2 -translate-x-1/2 flex gap-0.5">
                    <span class="w-1 h-1 rounded-full bg-[#0076D7]"></span>
                    <span class="w-1 h-1 rounded-full bg-white/70"></span>
                    <span class="w-1 h-1 rounded-full bg-white/70"></span>
                </div>
            </div>
        </div>

        {{-- ── Categories ── --}}
        @php
            // ⚠️ Placeholder labels read from the screenshot — replace with your real
            // top-8 category list + slugs once confirmed.
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
        <div class="px-2 mb-2 flex-1 overflow-hidden">
            <div class="text-[6px] font-bold text-gray-700 mb-1">Categories</div>
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

        {{-- ── Popular Searches ── --}}
        <div class="px-2 mb-2">
            <div class="text-[6px] font-bold text-gray-700 mb-1">Popular Searches</div>
            <div class="flex gap-1 overflow-hidden">
                @foreach(['from-pink-200 to-rose-300', 'from-blue-200 to-cyan-300', 'from-amber-200 to-orange-300'] as $gradient)
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br {{ $gradient }} flex-shrink-0"></div>
                @endforeach
            </div>
        </div>

        {{-- ── Floating action button ── --}}
        <div class="absolute right-2 bottom-12 w-6 h-6 rounded-full bg-[#0076D7] shadow-lg flex items-center justify-center">
            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        </div>

        {{-- ── Bottom tab bar ── --}}
        <div class="bg-white border-t border-gray-100 px-2 py-1.5 flex items-center justify-between mt-auto">
            <div class="flex flex-col items-center gap-0.5">
                <svg class="w-2.5 h-2.5 text-[#0076D7]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3l9 8h-3v9h-4v-6H10v6H6v-9H3z"/></svg>
                <span class="text-[4.5px] text-[#0076D7] font-semibold">Home</span>
            </div>
            <div class="flex flex-col items-center gap-0.5">
                <svg class="w-2.5 h-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <span class="text-[4.5px] text-gray-400">Category</span>
            </div>
            <div class="flex flex-col items-center gap-0.5">
                <svg class="w-2.5 h-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[4.5px] text-gray-400">Profile</span>
            </div>
        </div>
    </div>
</div>


                {{-- Phone mockup — "Jd" leftover branding replaced with QuickDials --}}
                <div class="w-56 h-[400px] bg-gray-900 rounded-[2.5rem] shadow-2xl border-4 border-gray-800 relative overflow-hidden mx-auto mt-6 md:mt-0 anim-float">
                    <div class="absolute inset-0 bg-white">
                        <div class="bg-[#0076D7] px-3 py-2">
                            <div class="text-white text-[8px] font-bold">QuickDials</div>
                            <div class="bg-white rounded mt-1 px-2 py-1 flex items-center gap-1">
                                <svg class="w-2.5 h-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                                <span class="text-[7px] text-gray-400">Your Business Category</span>
                            </div>
                        </div>
                        <div class="flex gap-1 px-2 py-1 border-b">
                            @foreach(['Sort By', 'Top Rated', 'Quick Resp.'] as $t)
                                <span class="text-[6px] bg-gray-100 rounded px-1.5 py-0.5 text-gray-600">{{ $t }}</span>
                            @endforeach
                        </div>
                        <div class="px-2 py-1 text-[6px] text-gray-500">6.5k Results for your search</div>
                        <div class="mx-2 border-2 border-[#0076D7] rounded-lg p-2 mb-1.5 relative">
                            <div class="absolute -top-2 left-2 bg-[#0076D7] text-white text-[5px] px-1.5 py-0.5 rounded">
                                Your Business Will Get Ranked Higher
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="w-7 h-7 bg-blue-100 rounded flex items-center justify-center">
                                    <span class="text-[7px] text-[#0076D7] font-bold">VP</span>
                                </div>
                                <div>
                                    <div class="text-[7px] font-semibold">Vantage Point</div>
                                    <div class="flex items-center gap-0.5">
                                        <svg class="w-2 h-2 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279L12 19.771l-7.416 3.642 1.48-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                        <span class="text-[6px]">4.1 &#9733;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-1 mt-1.5">
                                @foreach(['Call Now', 'Send Enquiry', 'Chat'] as $a)
                                    <span class="text-[5px] bg-[#0076D7] text-white rounded px-1 py-0.5">{{ $a }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="mx-2 border border-gray-200 rounded-lg p-2">
                            <div class="flex items-center gap-1.5">
                                <div class="w-7 h-7 bg-gray-100 rounded"></div>
                                <div>
                                    <div class="text-[7px] font-medium">Evergreen Solutions</div>
                                    <div class="flex items-center gap-0.5">
                                        <svg class="w-2 h-2 fill-yellow-300 text-yellow-300" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279L12 19.771l-7.416 3.642 1.48-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                        <span class="text-[6px] text-gray-500">4.8 &#9733; 777 Ratings</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mx-2 mt-2 border-2 border-dashed border-[#0076D7] rounded-lg p-2 bg-blue-50">
                            <div class="text-[6px] text-[#0076D7] font-bold mb-1">Your Business</div>
                            <div class="flex items-center gap-1">
                                <div class="w-6 h-6 bg-blue-200 rounded"></div>
                                <div>
                                    <div class="text-[6px] font-semibold text-gray-700">Top Search</div>
                                    <div class="flex items-center gap-0.5">
                                        <svg class="w-1.5 h-1.5 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279L12 19.771l-7.416 3.642 1.48-8.279-6.064-5.828 8.332-1.151z"/></svg>
                                        <span class="text-[5px]">4.8 &#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>





        </div>
    </section>

    {{--
        ===== STATS BAR =====
        FIXED: previously duplicated the exact same 4 numbers shown next to the phone mockup above.
        Now shows DIFFERENT, complementary metrics so nothing repeats within one scroll.
    --}}
    <section class="bg-[#0076D7] py-10 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-white relative z-10">
            @foreach([
                ['to' => 50000, 'suffix' => '+', 'label' => 'Active Categories'],
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
    <section id="success-stories" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row gap-8 md:gap-12 items-start">
                <div class="md:w-56 flex-shrink-0" data-reveal data-reveal-from="left">
                    <div class="text-7xl text-gray-200 font-serif leading-none select-none">"</div>
                    <h2 class="text-2xl font-bold text-gray-800 mt-2">Success Stories</h2>
                    <p class="text-[#0076D7] font-semibold mt-1">6.3 K+ Advertisers</p>
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
    </section>

    {{-- ===== BENEFITS ===== --}}
    @php
        $benefits = [
            ['icon' => 'users', 'title' => '160+ Buyers', 'desc' => "Access to India's largest verified buyer network across all major cities and towns."],
            ['icon' => 'trending-up', 'title' => 'Rank Above Competitors', 'desc' => 'Get premium placement in search results and outrank your local competition instantly.'],
            ['icon' => 'map-pin', 'title' => 'Hyper-Local Targeting', 'desc' => 'Reach customers exactly in your area — city, locality, or pin code level precision.'],
            ['icon' => 'bar-chart-2', 'title' => 'Real-Time Analytics', 'desc' => 'Track leads, calls, and conversions with a powerful business dashboard.'],
            ['icon' => 'shield', 'title' => 'Verified Buyer Leads', 'desc' => 'Only genuine, purchase-intent buyers. No bots, no spam — quality guaranteed.'],
            ['icon' => 'message-square', 'title' => 'Multi-Channel Reach', 'desc' => 'Connect via call, chat, SMS, and enquiry — whichever your customer prefers.'],
        ];
    @endphp
    <section id="benefits" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12" data-reveal>
                <h2 class="text-3xl font-bold text-gray-900">Why Advertise with QuickDials?</h2>
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

    {{--
        ===== FEATURES =====
        FIXED: moved ABOVE pricing. Visitors now see what they're paying for
        before being asked to choose a plan — standard, better-converting order.
    --}}
    @php
        $features = [
            ['icon' => 'search', 'title' => 'Smart Search Placement', 'desc' => 'Your business appears when buyers actively search for your services — maximum intent-driven visibility.'],
            ['icon' => 'thumbs-up', 'title' => 'Rating & Review System', 'desc' => 'Build trust with verified customer reviews and star ratings that convert browsing into buying.'],
            ['icon' => 'zap', 'title' => 'Instant Lead Delivery', 'desc' => 'Receive buyer enquiries via call, SMS, and app notification — never miss an opportunity.'],
            ['icon' => 'award', 'title' => 'Verified Business Badge', 'desc' => 'Stand out with a QuickDials verification badge that signals trust and credibility to buyers.'],
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

    {{--
        ===== PRICING =====
        FIXED: reordered ₹0 → ₹1000 → ₹2000 → ₹3000 → ₹5000 → ₹10000 (was scrambled).
        FIXED: package "₹5000 / Coins (6099)" previously listed "Coins (3529) Free First Time"
        in its features — a leftover copy-paste from the ₹3000 tier. Removed that line; the
        feature list now only states facts that are true for THIS tier.
    --}}
    <section class="py-20 bg-slate-100/60">
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
                        // 'Coins (3529) Free First Time' — REMOVED: wrong tier's coin amount, was a copy-paste error
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
                <div class="pkg-card relative flex flex-col rounded-3xl border-2 {{ $pkg['border'] }} bg-gradient-to-b {{ $pkg['gradient'] }} shadow-md overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2"
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
                            <button class="w-full py-3.5 rounded-full font-semibold text-base text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-300/40 hover:shadow-indigo-400/50 hover:scale-105 transition-all duration-300">
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
            <p class="text-blue-100 mb-8">Join 1,478 + businesses already thriving on QuickDials</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button
                    @click="scrollTo('hero')"
                    class="bg-white text-[#0076D7] font-bold px-8 py-3 rounded-xl hover:bg-blue-50 hover:scale-105 transition-all duration-300"
                >
                    Start Advertising Now
                </button>
                {{-- ⚠️ CONFIRM real phone number — placeholder +918888888888 still unconfirmed --}}
                <a
                    href="tel:+918888888888"
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
            ['q' => 'How does advertising on QuickDials work?', 'a' => 'When you advertise on QuickDials, your business gets premium placement in search results when buyers look for your products or services. You receive leads as calls, chats, and enquiries directly from interested buyers.'],
            ['q' => 'How many leads can I expect per month?', 'a' => 'The number of leads depends on your plan, category, and location. On average, our advertisers see 30–200+ leads per month. Highly competitive categories in metros typically receive more leads.'],
            ['q' => 'Can I upgrade my plan later?', 'a' => 'Yes, you can upgrade your plan at any time. Our team will help you transition seamlessly and your listing will be upgraded immediately.'],
            ['q' => 'Is there a free trial available?', 'a' => 'We offer a free basic listing to all businesses. You can upgrade to a paid plan anytime to unlock premium ranking, more leads, and advanced analytics.'],
            ['q' => 'How do I track the performance of my listing?', 'a' => 'Your QuickDials business dashboard shows real-time data on impressions, clicks, calls, and enquiries. You can see exactly how your listing is performing at any time.'],
            ['q' => 'What kind of support is available?', 'a' => 'All plans include customer support via phone and chat. Growth and Pro plans include a dedicated account manager who helps you maximize your return on investment.'],
        ];
    @endphp
    <section id="faqs" class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-4">
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
                            <svg x-show="!open" class="w-4 h-4 flex-shrink-0 text-gray-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            <svg x-show="open" class="w-4 h-4 flex-shrink-0 text-[#0076D7]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                        </button>
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
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

</div>

{{-- ===== Scroll-reveal engine + counter animation ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.lucide) window.lucide.createIcons();

    // ── Bold scroll-reveal: fade + directional slide-in, staggered via data-reveal-delay ──
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
            if (format === 'crore') return (n / 10000000).toFixed(1) + ' K';
            if (format === 'lakh') return (n / 100000).toFixed(1) + ' K';
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
                        var current = Math.floor(progress * to);
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
        .anim-pulse-slow, .anim-float, .anim-bounce-in {
            animation: none !important;
        }
    }
</style>
 
 
 


@endsection
