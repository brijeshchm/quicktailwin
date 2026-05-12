 
@extends('client.layouts.app')
 
@section('title', 'Cantact us Quick Dials- Local search, IT Training, Service, overseas education')
@section('description', 'Cantact us Quick Dials- Local search, IT Training, Service, overseas education')
@section('keyword', 'Cantact us Quick Dials- Local search, IT Training, Service, overseas education')

@section('content') 
  
 @include('client.components.banner-section')
 
{{-- ══════════════════════════════════════
     MAIN
════════════════════════════════════════ --}}
<main class="relative mt-4">

    {{-- Grid background lines --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden grid-lines">
        @for($i = 0; $i < 20; $i++)
            <div style="left: {{ ($i / 19) * 100 }}%"></div>
        @endfor
    </div>

    <section class="relative z-10 px-6 pt-10 pb-14 max-w-7xl mx-auto">

        {{-- ── HERO HEADER ── --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5 mb-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-violet-200 bg-violet-100/70 mb-4 anim-fade-up" style="animation-delay:.05s">
                    <svg class="w-3 h-3 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="text-xs font-semibold text-violet-700 tracking-wider uppercase">Get In Touch</span>
                </div>

                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight tracking-tight anim-fade-up" style="animation-delay:.1s">
                    We'd love to <span class="gradient-text">hear from you</span>
                </h1>

                <p class="text-base text-gray-500 mt-3 max-w-lg leading-relaxed anim-fade-up" style="animation-delay:.16s">
                    A question, a partnership idea, or just a hello — our team is always ready to talk.
                </p>
            </div>

            <div class="shrink-0 anim-fade-up" style="animation-delay:.22s">
                <a href="mailto:info@quickdials.com"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-semibold text-white text-sm shadow-lg shadow-violet-300/40 hover:shadow-xl transition-all duration-200 btn-gradient">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Us Now
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- ── QUICK CONTACT CARDS ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-14">

            @php
            $contactInfo = [
                [
                    'label'     => 'Phone',
                    'value'     => '+91-75-9543-9543',
                    'sub'       => 'Mon–Fri, 9am–6pm EST',
                    'href'      => 'tel:+917595439543',
                    'iconBg'    => 'bg-violet-50',
                    'iconColor' => 'text-violet-600',
                    'icon'      => 'phone',
                    'delay'     => '0s',
                ],
                [
                    'label'     => 'Email',
                    'value'     => 'info@quickdials.com',
                    'sub'       => 'We reply within 24 hours',
                    'href'      => 'mailto:info@quickdials.com',
                    'iconBg'    => 'bg-blue-50',
                    'iconColor' => 'text-blue-600',
                    'icon'      => 'mail',
                    'delay'     => '.1s',
                ],
                [
                    'label'     => 'Support',
                    'value'     => 'support@quickdials.com',
                    'sub'       => '24/7 live chat available',
                    'href'      => 'mailto:support@quickdials.com',
                    'iconBg'    => 'bg-emerald-50',
                    'iconColor' => 'text-emerald-600',
                    'icon'      => 'globe',
                    'delay'     => '.2s',
                ],
            ];
            @endphp

            @foreach($contactInfo as $item)
            <a href="{{ $item['href'] }}"
               class="contact-card group relative flex items-center gap-4 rounded-2xl border border-gray-100 bg-white px-5 py-4 shadow-sm no-underline anim-fade-up"
               style="animation-delay:{{ $item['delay'] }}">

                <div class="w-10 h-10 rounded-xl {{ $item['iconBg'] }} flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                    @if($item['icon'] === 'phone')
                        <svg class="w-4 h-4 {{ $item['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    @elseif($item['icon'] === 'mail')
                        <svg class="w-4 h-4 {{ $item['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4 {{ $item['iconColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @endif
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-0.5">{{ $item['label'] }}</p>
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $item['value'] }}</p>
                    <p class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $item['sub'] }}
                    </p>
                </div>

                <svg class="ml-auto w-4 h-4 text-gray-200 group-hover:text-violet-400 group-hover:translate-x-1 shrink-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
            @endforeach
        </div>

        {{-- ── OFFICES ── --}}
        <div class="mb-14">

            {{-- Section header --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">Our Offices</h2>
                    <p class="text-xs text-gray-400">Locations around the world</p>
                </div>
                <div class="flex-1 h-px bg-gradient-to-r from-violet-200 to-transparent ml-2 anim-scale-x" style="animation-delay:.2s"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">

                {{-- HEAD OFFICE (spans 2 cols) --}}
                <div class="col-span-1 lg:col-span-2 anim-fade-up" style="animation-delay:.05s">
                    <div class="relative overflow-hidden rounded-2xl border border-violet-200 bg-gradient-to-br from-violet-50 to-purple-50 p-8 shadow-md hover:shadow-lg transition-shadow duration-300 group h-full">

                        {{-- Decorative orb --}}
                        <div class="absolute top-0 right-0 w-64 h-64 rounded-full blur-3xl bg-violet-300/20 pointer-events-none -translate-y-1/2 translate-x-1/2"></div>

                        <div class="relative z-10 flex flex-col sm:flex-row gap-6 sm:items-start justify-between">
                            <div class="flex flex-col gap-4">

                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg shadow-violet-300/40">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold text-white bg-violet-600 mb-0.5">
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            Head Office
                                        </span>
                                        <p class="text-xs text-gray-400 leading-none">India</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-2xl font-extrabold text-gray-900 mb-1">QuickDials Internet Pvt Ltd</h3>
                                    <p class="text-sm text-gray-500">UNIT 101 OXFORD TOWERS, 139/88 HAL OLD AIRPORT RD, H.A.L II Stage, Bangalore North, Bangalore- 560008, Karnataka</p>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <a href="tel:+917595439543" class="flex items-center gap-2 text-sm font-medium text-violet-600 hover:opacity-70 transition-opacity">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        +91-75-9543-9543
                                    </a>
                                    <a href="mailto:info@quickdials.com" class="flex items-center gap-2 text-sm font-medium text-violet-600 hover:opacity-70 transition-opacity">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        info@quickdials.com
                                    </a>
                                    <p class="flex items-center gap-2 text-sm text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Mon–Fri, 9am–6pm PST
                                    </p>
                                </div>
                            </div>

                            <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer"
                               class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-violet-500 to-purple-600 text-white text-sm font-semibold shadow-md shadow-violet-300/40 hover:shadow-lg transition-all duration-200 self-start">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                View on Map
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- BRANCH OFFICES --}}
                @php
                $branches = [
                    [
                        'city'     => 'Bangalore',
                        'country'  => 'India',
                        'address'  => 'UNIT 101 OXFORD TOWERS, 139/88 HAL OLD AIRPORT RD, H.A.L II Stage, Bangalore North, Bangalore- 560008, Karnataka',
                        'phone'    => '+91-75-9543-9543',
                        'hours'    => 'Mon–Fri, 9am–6pm EST',
                        'flag'     => '🇮🇳',
                        'gradient' => 'from-blue-500 to-indigo-500',
                        'bg'       => 'from-blue-50 to-indigo-50',
                        'border'   => 'border-blue-100',
                        'accent'   => 'text-blue-600',
                        'delay'    => '.1s',
                    ],
                    [
                        'city'     => 'Noida',
                        'country'  => 'India',
                        'address'  => 'G-13, Sector-3, Noida, UP, India, 201301',
                        'phone'    => '+91-75-9543-9543',
                        'hours'    => 'Mon–Fri, 9am–6pm GMT',
                        'flag'     => '🇮🇳',
                        'gradient' => 'from-rose-500 to-pink-500',
                        'bg'       => 'from-rose-50 to-pink-50',
                        'border'   => 'border-rose-100',
                        'accent'   => 'text-rose-600',
                        'delay'    => '.2s',
                    ],
                ];
                @endphp

                @foreach($branches as $office)
                <div class="card-lift rounded-2xl border {{ $office['border'] }} bg-gradient-to-br {{ $office['bg'] }} p-6 shadow-sm group cursor-default anim-fade-up" style="animation-delay:{{ $office['delay'] }}">

                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $office['gradient'] }} flex items-center justify-center shadow-sm text-base">
                            {{ $office['flag'] }}
                        </div>
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Branch</span>
                    </div>

                    <h4 class="text-lg font-bold text-gray-900 mb-0.5">{{ $office['city'] }}</h4>
                    <p class="text-xs text-gray-400 mb-3">{{ $office['country'] }}</p>
                    <p class="text-sm text-gray-500 leading-snug">{{ $office['address'] }}</p>

                    <div class="mt-4 pt-4 border-t border-white/70 flex flex-col gap-1.5">
                        <a href="tel:{{ preg_replace('/[^+\d]/', '', $office['phone']) }}"
                           class="flex items-center gap-1.5 text-xs font-medium {{ $office['accent'] }} hover:opacity-70 transition-opacity">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $office['phone'] }}
                        </a>
                        <p class="flex items-center gap-1.5 text-xs text-gray-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $office['hours'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── FORM + FEATURES ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- LEFT: features --}}
            <div class="flex flex-col gap-6 anim-fade-left" style="animation-delay:.3s">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Send us a message</h2>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Fill out the form and our team will reach out as soon as possible.
                    </p>
                </div>

                <div class="flex flex-col gap-4">
                    @php
                    $features = [
                        ['icon'=>'zap',      'title'=>'Lightning Fast',   'desc'=>'Average response under 2 hours',    'bg'=>'bg-amber-50',   'color'=>'text-amber-500'],
                        ['icon'=>'shield',   'title'=>'Secure & Private', 'desc'=>'Your data stays safe with us',      'bg'=>'bg-emerald-50', 'color'=>'text-emerald-500'],
                        ['icon'=>'headphone','title'=>'24/7 Support',     'desc'=>'Around-the-clock assistance',        'bg'=>'bg-violet-50',  'color'=>'text-violet-500'],
                    ];
                    @endphp

                    @foreach($features as $i => $f)
                    <div class="flex items-center gap-3 anim-fade-up" style="animation-delay:{{ $i * 0.1 + 0.1 }}s">
                        <div class="w-9 h-9 rounded-xl {{ $f['bg'] }} flex items-center justify-center shrink-0">
                            @if($f['icon'] === 'zap')
                                <svg class="w-4 h-4 {{ $f['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            @elseif($f['icon'] === 'shield')
                                <svg class="w-4 h-4 {{ $f['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 {{ $f['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $f['title'] }}</p>
                            <p class="text-xs text-gray-400">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 mb-3 uppercase tracking-wider font-semibold">Follow us</p>
                    <p class="text-xs text-gray-300">Social links coming soon.</p>
                </div>
            </div>

            {{-- RIGHT: Contact Form (Alpine.js) --}}
            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm p-6 anim-fade-right" style="animation-delay:.38s"
                 x-data="contactForm()" x-init="init()">

                {{-- Success --}}
                <div x-show="submitted" x-cloak class="flex flex-col items-center justify-center gap-4 py-12 text-center">
                    <div class="relative w-16 h-16 anim-pop-in">
                        <div class="pulse-ring absolute inset-0 rounded-full"></div>
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-lg shadow-green-200 relative z-10">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1.5">Message Sent!</h3>
                        <p class="text-gray-400 text-sm max-w-xs">Our team will get back to you within 24 hours.</p>
                    </div>
                    <button @click="reset()" class="text-sm text-violet-500 hover:text-violet-700 underline underline-offset-4 transition-colors">
                        Send another message
                    </button>
                </div>

                {{-- Form --}}
                <div x-show="!submitted">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-3.5">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Full Name</label>
                            <input x-model="form.name" type="text" placeholder="Jane Smith" required
                                   class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 text-sm placeholder-gray-300" />
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</label>
                            <input x-model="form.email" type="email" placeholder="jane@company.com" required
                                   class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 text-sm placeholder-gray-300" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5 mb-3.5">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</label>
                        <select x-model="form.subject" required
                                class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 appearance-none cursor-pointer">
                            <option value="" disabled selected>Select a topic...</option>
                            <option value="general">General Inquiry</option>
                            <option value="sales">Sales &amp; Pricing</option>
                            <option value="support">Technical Support</option>
                            <option value="partnership">Partnership</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1.5 mb-3.5">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Message</label>
                        <textarea x-model="form.message" rows="4" placeholder="Tell us how we can help..." required
                                  class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-900 text-sm placeholder-gray-300 resize-none"></textarea>
                    </div>

                    <button type="button" @click="submit()" :disabled="loading"
                            class="relative w-full mt-1 py-3.5 rounded-xl font-semibold text-white overflow-hidden btn-gradient hover:opacity-90 transition-opacity disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2">

                        {{-- Loading state --}}
                        <template x-if="loading">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 spinner" viewBox="0 0 24 24" fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                Sending...
                            </span>
                        </template>

                        {{-- Default state --}}
                        <template x-if="!loading">
                            <span class="flex items-center gap-1.5 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold rounded-md shadow transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Message
                            </span>
                        </template>
                    </button>
                </div>

            </div>{{-- /form card --}}
        </div>

    </section>
</main>

 

{{-- ══════════════════════════════════════
     ALPINE COMPONENT
════════════════════════════════════════ --}}
<script>
function contactForm() {
    return {
        loading:   false,
        submitted: false,
        form: { name: '', email: '', subject: '', message: '' },

        init() { /* nothing async needed */ },

        async submit() {
            if (!this.form.name || !this.form.email || !this.form.subject || !this.form.message) return;

            this.loading = true;

            try {
                /*
                 * Wire to your Laravel API:
                 * const res = await fetch('/api/contact', {
                 *   method: 'POST',
                 *   headers: {
                 *     'Content-Type': 'application/json',
                 *     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                 *   },
                 *   body: JSON.stringify(this.form),
                 * });
                 */

                // Simulate network delay (remove when wiring real API)
                await new Promise(r => setTimeout(r, 1600));

                this.submitted = true;
            } catch (err) {
                console.error('Contact form error:', err);
            } finally {
                this.loading = false;
            }
        },

        reset() {
            this.submitted = false;
            this.form = { name: '', email: '', subject: '', message: '' };
        },
    };
}
</script>

 


 
 @endsection
