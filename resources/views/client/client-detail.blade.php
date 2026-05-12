@extends('client.layouts.app')
 
@section('title', $title | 'Quick dials')
@section('description', $description?? 'Quick dials')
@section('keyword', $keyword ??'Quick dials')

@section('content')
@include('client.components.banner-section')
 <div id="scroll-progress"></div>
 
<style>
/* ══════ VARIABLES ══════ */
:root { --primary:#2563eb; --accent:#0891b2; }

/* ══════ SCROLL PROGRESS ══════ */
#scroll-progress { position:fixed;top:0;left:0;height:3px;background:var(--primary);z-index:9999;width:0;transition:width .1s linear; }

/* ══════ HERO BANNER ══════ */
.hero-wrap { position:relative;overflow:hidden;display:flex; }
.hero-img { transition:transform .5s ease; }
.hero-overlay-l { position:absolute;inset:0;background:linear-gradient(to right,rgba(30,58,138,.88) 0%,rgba(37,99,235,.45) 45%,rgba(59,130,246,.1) 100%); }
.hero-overlay-b { position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.12),transparent,rgba(0,0,0,.28)); }
.tile-slider { overflow:hidden;position:relative;flex:1; }
.tile-img { position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0;transition:opacity .65s ease; }
.tile-img.active { opacity:1; }

/* ══════ STICKY ACTION BAR ══════ */
.sticky-bar { position:sticky;top:3.5rem;z-index:50;background:rgba(255,255,255,.85);backdrop-filter:blur(20px);border-bottom:1px solid rgba(59,130,246,.15);box-shadow:0 1px 24px rgba(37,99,235,.08); }
.glow-pulse { animation:glow-p 2.2s ease-in-out infinite; }
@keyframes glow-p { 0%,100%{box-shadow:0 4px 14px rgba(37,99,235,.35)} 50%{box-shadow:0 4px 28px rgba(37,99,235,.7)} }

/* ══════ INFO STRIP ══════ */
.info-strip { background:linear-gradient(90deg,#0f172a 0%,#1e1b4b 50%,#0f172a 100%); }

/* ══════ SECTION BADGE ══════ */
.section-badge { display:inline-flex;align-items:center;gap:.375rem;font-size:.65rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;padding:.25rem .75rem;border-radius:9999px;margin-bottom:.75rem; }

/* ══════ REVEAL ══════ */
.reveal { opacity:0;transform:translateY(20px);transition:opacity .55s cubic-bezier(.22,1,.36,1),transform .55s cubic-bezier(.22,1,.36,1); }
.reveal.visible { opacity:1;transform:translateY(0); }
.reveal-r { opacity:0;transform:translateX(24px);transition:opacity .55s ease,transform .55s ease; }
.reveal-r.visible { opacity:1;transform:translateX(0); }
.d-0{transition-delay:0s}.d-1{transition-delay:.07s}.d-2{transition-delay:.14s}.d-3{transition-delay:.21s}.d-4{transition-delay:.28s}.d-5{transition-delay:.35s}

/* ══════ ENQUIRY FORM STEPS ══════ */
.step-dot { width:1.75rem;height:1.75rem;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;transition:all .3s; }
.step-dot.done { background:white;color:#2563eb; }
.step-dot.active { background:white;color:#1d4ed8;box-shadow:0 0 0 3px rgba(255,255,255,.4); }
.step-dot.pending { background:rgba(255,255,255,.2);color:rgba(255,255,255,.6); }
.step-line { flex:1;height:2px;margin:.875rem .375rem .875rem;border-radius:9999px;transition:background .5s; }
.ef-input { width:100%;padding:.625rem 1rem .625rem 2.25rem;border-radius:.75rem;border:1.5px solid rgba(37,99,235,.18);background:rgba(37,99,235,.04);font-size:.875rem;outline:none;color:#1e3a8a;transition:all .2s; }
.ef-input:focus { border-color:#2563eb;box-shadow:0 0 0 4px rgba(37,99,235,.1);background:white; }
select.ef-input { padding-left:1rem; }

/* ══════ OTP BOXES ══════ */
.otp-box { width:2.75rem;height:3.5rem;text-align:center;font-size:1.25rem;font-weight:900;border-radius:.75rem;border:1.5px solid rgba(37,99,235,.2);background:rgba(37,99,235,.02);color:#1d4ed8;outline:none;transition:all .2s; }
.otp-box.filled { border-color:#2563eb;background:rgba(37,99,235,.07);box-shadow:0 0 0 4px rgba(37,99,235,.1); }

/* ══════ GALLERY GRID ══════ */
.gallery-grid-item { position:relative;overflow:hidden;border-radius:.75rem;cursor:pointer; }
.gallery-grid-item img { width:100%;height:100%;object-fit:cover;transition:transform .5s ease; }
.gallery-grid-item:hover img { transform:scale(1.07); }
.gallery-grid-item .gallery-overlay { position:absolute;inset:0;background:rgba(37,99,235,.3);opacity:0;transition:opacity .3s; }
.gallery-grid-item:hover .gallery-overlay { opacity:1; }

/* ══════ LIGHTBOX ══════ */
#lightbox { position:fixed;inset:0;z-index:300;background:rgba(15,23,42,.97);backdrop-filter:blur(32px);display:none;align-items:center;justify-content:center; }
#lightbox.open { display:flex; }

/* ══════ GALLERY MODAL ══════ */
#gallery-modal { position:fixed;inset:0;z-index:200;background:#fff;display:none;flex-direction:column; }
#gallery-modal.open { display:flex; }

/* ══════ SERVICE CARDS ══════ */
.service-card { transition:transform .25s ease,box-shadow .25s ease; }
.service-card:hover { transform:translateY(-4px);box-shadow:0 8px 24px rgba(37,99,235,.12); }

/* ══════ CERT TILES ══════ */
.cert-tile { transition:transform .3s ease,box-shadow .3s ease; }
.cert-tile.active-tile { transform:scale(1.02);box-shadow:0 4px 24px rgba(0,0,0,.22); }

/* ══════ REVIEW CARDS ══════ */
.review-card { transition:transform .25s ease,box-shadow .25s ease;background:#fafcff;border:1px solid rgba(59,130,246,.12); }
.review-card:hover { transform:translateY(-3px);box-shadow:0 12px 32px rgba(37,99,235,.1); }

/* ══════ SHARE DROPDOWN ══════ */
#share-dropdown { display:none;position:absolute;top:calc(100% + .5rem);left:0;z-index:60;background:white;border-radius:1rem;box-shadow:0 8px 32px rgba(0,0,0,.12);border:1px solid rgba(59,130,246,.12);min-width:13rem;overflow:hidden; }
#share-dropdown.open { display:block; }

/* ══════ VIDEO MODAL ══════ */
#video-modal { position:fixed;inset:0;z-index:999;background:rgba(0,0,0,.82);backdrop-filter:blur(8px);display:none;align-items:center;justify-content:center;padding:1rem; }
#video-modal.open { display:flex; }

/* ══════ HEADING UNDERLINE ══════ */
.heading-ul { position:relative;display:inline-block; }
.heading-ul::after { content:'';position:absolute;bottom:-6px;left:0;width:0;height:3px;background:linear-gradient(90deg,#2563eb,#0891b2);border-radius:9999px;transition:width .6s ease .2s; }
.heading-ul.in-view::after { width:100%; }

/* ══════ ACTIVITY CARDS ══════ */
.activity-card { transition:transform .3s ease,box-shadow .3s ease;border:1px solid rgba(59,130,246,.1); }
.activity-card:hover { transform:translateY(-4px);box-shadow:0 10px 32px rgba(37,99,235,.1); }
.activity-card img { transition:transform .5s ease; }
.activity-card:hover img { transform:scale(1.06); }

/* ══════ MOBILE BOTTOM BAR ══════ */
@media(min-width:768px) { #mobile-bar { display:none !important; } }
</style>
 

{{-- Scroll progress --}}


{{-- ════════════════════════════════════════
     HERO BANNER
════════════════════════════════════════ --}}
<div class="hero-wrap" style="height:46vh;min-height:380px;">

    {{-- Main hero image --}}
    <div class="relative flex-1 overflow-hidden">
        <img src="{{ $clientsList['profile_banner'] ?? 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=1400&h=600&fit=crop' }}"
             alt="{{ $clientsList['business_name'] ?? '' }}"
             class="hero-img absolute inset-0 w-full h-full object-cover" style="transform:scale(1.06);">
        <div class="hero-overlay-l"></div>
        <div class="hero-overlay-b"></div>

        <div class="absolute bottom-0 left-0 right-0 px-6 md:px-16 pb-6 md:pb-8 z-10">
            <div class="flex items-center gap-4 md:gap-5 mb-3">
                {{-- Logo --}}
                <div class="rounded-2xl overflow-hidden shadow-2xl flex items-center justify-center shrink-0"
                     style="width:80px;height:80px;@media(min-width:768px){width:160px;height:160px;}
                            border:2px solid rgba(255,255,255,.35);background:rgba(255,255,255,.1);backdrop-filter:blur(14px);">
                    <img src="{{ $clientsList['logo'] ?? '/logo.png' }}"
                         alt="{{ $clientsList['business_name'] ?? '' }}"
                         class="w-full h-full object-cover"
                         onerror="this.style.display='none'">
                </div>
                {{-- Name --}}
                <h1 class="text-2xl md:text-5xl font-extrabold text-white leading-tight tracking-tight"
                    style="text-shadow:0 2px 30px rgba(30,58,138,.6);">
                    {{ $clientsList['business_name'] ?? 'Business Name' }}
                </h1>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-white/80 text-xs font-medium">
                <div class="flex items-center gap-1">
                    @for($s=0;$s<5;$s++)<span class="text-yellow-400">★</span>@endfor
                    <span class="font-bold text-white ml-1">{{ $clientsList['rating'] ?? '' }}</span>
                    <span class="text-white/55">({{ $clientsList['ratingCount'] ?? '' }} reviews)</span>
                </div>
                <span class="text-[10px] font-bold tracking-wide text-white rounded-full px-2.5 py-0.5 flex items-center gap-1.5" style="background:#16a34a;">
                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>Open Now
                </span>
                <span class="flex items-center gap-1">📍 {{ $clientsList['address'] ?? 'India' }}</span>
            </div>
        </div>
    </div>

    {{-- Right image tiles (desktop) --}}
    <div class="hidden md:flex flex-col" style="width:38%;gap:3px;">
        <div class="tile-slider flex-1" style="border-left:3px solid rgba(255,255,255,.18);">
            @foreach($hImages as $i => $img)
            <img src="{{ $img }}" alt="Gallery" class="tile-img {{ $i===0?'active':'' }}"
                 data-h-slide="{{ $i }}"
                 onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=700&h=500&fit=crop'">
            @endforeach
            <div class="absolute bottom-2 left-3 flex items-center gap-1.5 z-10" id="h-dots"></div>
        </div>
        <div class="tile-slider flex-1" style="border-left:3px solid rgba(255,255,255,.18);">
            @foreach($vImages as $i => $img)
            <img src="{{ $img }}" alt="Gallery" class="tile-img {{ $i===0?'active':'' }}"
                 data-v-slide="{{ $i }}"
                 onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=700&h=500&fit=crop'">
            @endforeach
            <div class="absolute bottom-2 right-3 flex flex-col items-center gap-1 z-10" id="v-dots"></div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════
     STICKY ACTION BAR (desktop)
════════════════════════════════════════ --}}
<div class="hidden md:block sticky-bar">
    <div class="w-full px-8 md:px-16 py-3 flex flex-wrap gap-2 items-center">
        <a href="tel:+917559435943">
            <button class="glow-pulse flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm text-white" style="background:#16a34a;">
                📞 Call Now
            </button>
        </a>
        <a href="https://wa.me/917559435943" target="_blank" rel="noreferrer">
            <button class="flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm text-white" style="background:#25D366;">
                💬 WhatsApp
            </button>
        </a>
        <button onclick="document.getElementById('enquiry-modal').classList.add('open')"
                class="flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm text-white" style="background:#2563eb;">
            ✉️ Enquire Now
        </button>
        <button onclick="document.getElementById('location-modal').classList.add('open')"
                class="flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm text-blue-700 border border-blue-200 hover:bg-blue-50">
            📍 Location
        </button>
        <div class="relative">
            <button onclick="document.getElementById('share-dropdown').classList.toggle('open')"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-sm text-blue-700 border border-blue-200 hover:bg-blue-50">
                🔗 Share
            </button>
            <div id="share-dropdown">
                <div class="px-3 py-2 text-[10px] font-black tracking-widest uppercase border-b text-gray-400">Share this page</div>
                <button onclick="copyPageLink(this)" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 text-left">
                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-base" style="background:rgba(37,99,235,.1)">🔗</span>
                    Copy Link
                </button>
                <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank"
                   class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-base" style="background:rgba(37,211,102,.1)">💬</span>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════
     INFO STRIP
════════════════════════════════════════ --}}
<div class="info-strip w-full">
    <div class="w-full px-8 md:px-16 py-3 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            @foreach([
                ['📍', $clientsList['address'] ?? 'India',         $googleMapUrl,  'rgba(251,146,60,.12)', 'rgba(251,146,60,.2)'],
                ['📞', '+91-75-5943-5943',                         'tel:+917559435943', 'rgba(56,189,248,.12)', 'rgba(56,189,248,.2)'],
                ['✉️', $clientsList['email'] ?? '',                 'mailto:'.($clientsList['email']??'#'), 'rgba(167,139,250,.12)', 'rgba(167,139,250,.2)'],
            ] as [$icon, $text, $href, $bg, $border])
            @if($text)
            <a href="{{ $href }}" target="{{ str_starts_with($href,'http')?'_blank':'' }}"
               class="flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-medium transition-all hover:brightness-125"
               style="background:{{ $bg }};border:1px solid {{ $border }};color:rgba(255,255,255,.75);">
                {{ $icon }} {{ Str::limit($text, 40) }}
            </a>
            @endif
            @endforeach
        </div>
        <div class="flex items-center gap-1.5">
            <span class="text-[10px] font-bold tracking-widest uppercase mr-2" style="color:rgba(255,255,255,.3);">Follow</span>
            @foreach([
                ['📸', $clientsList['social']['instagram_url'] ?? '#', 'linear-gradient(135deg,#f43f5e,#a855f7,#f59e0b)'],
                ['👥', $clientsList['social']['facebook_url']  ?? '#', '#1877f2'],
                ['🐦', $clientsList['social']['twitter_url']   ?? '#', '#333'],
                ['💬', 'https://wa.me/917559435943',                   '#25d366'],
            ] as [$icon, $href, $bg])
            <a href="{{ $href }}" target="_blank"
               class="w-7 h-7 rounded-full flex items-center justify-center hover:scale-110 transition-transform text-sm"
               style="background:{{ $bg }};">{{ $icon }}</a>
            @endforeach
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════
     ABOUT + ENQUIRY FORM
════════════════════════════════════════ --}}
<section class="bg-white">
    <div class="w-full px-8 md:px-16 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Left: About --}}
            <div class="space-y-6 reveal">
                <span class="section-badge" style="background:rgba(59,130,246,.1);color:#2563eb;border:1px solid rgba(59,130,246,.2);">
                    ✨ About Us
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold leading-tight tracking-tight text-gray-900">
                    {{ $clientsList['business_name'] ?? '' }}<br>
                    <span style="color:#2563eb;">in {{ $clientsList['city'] ?? 'India' }}</span>
                </h2>
                <p class="text-gray-600 leading-relaxed">{{ $clientsList['business_intro'] ?? '' }}</p>

                {{-- Stats --}}
                <div class="grid grid-cols-4 gap-2">
                    @foreach([
                        [($clientsList['rating'] ?? '').'★', 'Rating',      'rgba(234,179,8,.1)',   '#b45309', 'rgba(234,179,8,.25)'],
                        [$yearsExp.' Yr',                    'Est. '.$yearEst, 'rgba(99,102,241,.1)', '#4338ca', 'rgba(99,102,241,.25)'],
                        ['200+',                             'Events/yr',   'rgba(244,63,94,.1)',   '#be123c', 'rgba(244,63,94,.25)'],
                        ['30+',                              'Awards',      'rgba(20,184,166,.1)',  '#0f766e', 'rgba(20,184,166,.25)'],
                    ] as [$val,$label,$bg,$color,$border])
                    <div class="flex flex-col items-center px-2 py-2 rounded-xl"
                         style="background:{{ $bg }};border:1px solid {{ $border }};">
                        <span class="text-lg font-extrabold leading-none" style="color:{{ $color }};">{{ $val }}</span>
                        <span class="text-[9px] font-semibold uppercase tracking-wide mt-0.5" style="color:{{ $color }};opacity:.7;">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Website + Social --}}
                <div class="flex flex-wrap items-center gap-3">
                    @if(!empty($clientsList['website']))
                    <a href="{{ $clientsList['website'] }}" target="_blank"
                       class="flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center" style="background:rgba(37,99,235,.08);">
                            🌐
                        </div>
                        {{ $clientsList['website'] }}
                    </a>
                    @endif
                </div>
            </div>

            {{-- Right: Enquiry Form (sidebar version) --}}
            <div class="reveal-r" id="enquiry-sidebar">
                @include('client.layouts.enquiry_common_popup', ['keywordList' => $keywordList, 'planOptions' => $planOptions, 'formId' => 'sidebar'])
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     SERVICES SECTION
════════════════════════════════════════ --}}
@if(count($assignKeyword))
<section style="background:linear-gradient(135deg,#f0f4ff 0%,#e8edf8 100%);">
    <div class="w-full px-8 md:px-16 py-10">
        <span class="section-badge reveal" style="background:rgba(37,99,235,.1);color:#2563eb;border:1px solid rgba(37,99,235,.2);">What We Offer</span>
        <h2 class="heading-ul text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-8 reveal">Our Services</h2>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            @foreach($assignKeyword as $i => $keyword)
            @php $bg = $bgColors[$i % count($bgColors)]; $color = $iconColors[$i % count($iconColors)]; @endphp
            <div class="service-card reveal d-{{ min($i%6,5) }} rounded-xl p-3 flex flex-col gap-2 cursor-default border bg-white"
                 style="border-color:rgba(37,99,235,.1);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-lg" style="background:{{ $bg }};">
                    🔧
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-xs mb-0.5 leading-tight">{{ $keyword }}</h3>
                    <p class="text-gray-400 text-[10px] leading-snug">Expert {{ $keyword }} services</p>
                </div>
                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full self-start"
                      style="background:{{ $bg }};color:{{ $color }};border:1px solid {{ $color }}33;">
                    Custom Quote
                </span>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════
     GALLERY SECTION
════════════════════════════════════════ --}}
@if(count($gallery))
<section style="background:linear-gradient(135deg,#f0fdfa 0%,#e0f2fe 100%);">
    <div class="w-full px-8 md:px-16 pt-8 pb-2">
        <div class="flex items-end justify-between mb-6">
            <div>
                <span class="section-badge reveal" style="background:rgba(20,184,166,.12);color:#0f766e;border:1px solid rgba(20,184,166,.25);">Gallery</span>
                <h2 class="heading-ul text-3xl font-extrabold text-gray-900 tracking-tight reveal">Photos &amp; Videos</h2>
            </div>
            <button onclick="document.getElementById('gallery-modal').classList.add('open')"
                    class="flex items-center gap-2 text-sm font-bold px-4 py-2 rounded-xl text-white" style="background:#0f172a;">
                View All ({{ count($gallery) }})
            </button>
        </div>
    </div>

    <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-1.5 px-8 md:px-16 pb-8">
        @foreach($gallery as $i => $img)
        <div class="gallery-grid-item reveal d-{{ min($i%6,5) }} {{ $i===0?'col-span-2 row-span-2':'' }}"
             style="aspect-ratio:{{ $i===0?'1/1':'4/3' }};border:1px solid rgba(59,130,246,.1);"
             onclick="openLightbox({{ $i }})">
            <img src="{{ $img }}" alt="Gallery {{ $i+1 }}"
                 onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=300&fit=crop'">
            <div class="gallery-overlay"></div>
            <div class="absolute inset-0 flex items-end p-2 opacity-0 hover:opacity-100 transition-opacity">
                <span class="text-white text-[10px] font-bold rounded-full px-2 py-0.5 bg-white/20 backdrop-blur-sm">View</span>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ════════════════════════════════════════
     RECENT ACTIVITY
════════════════════════════════════════ --}}
<section style="background:linear-gradient(180deg,#f8faff 0%,#eef4ff 100%);">
    <div class="w-full px-8 md:px-16 py-10">
        <div class="flex items-end justify-between mb-7">
            <div>
                <span class="section-badge" style="background:rgba(37,99,235,.1);color:#2563eb;">Recent Activity</span>
                <h2 class="heading-ul text-2xl md:text-3xl font-extrabold text-gray-900 reveal">
                    Latest from <span style="color:#2563eb;">{{ $clientsList['business_name'] ?? '' }}</span>
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
            @foreach([
                ['Chef\'s Spring Tasting Menu','Introducing bold seasonal ingredients with a refined European twist.','2 days ago','Food'],
                ['Behind the Kitchen','Go behind the scenes with our culinary team as they prepare for a busy service.','5 days ago','Video'],
                ['Weekend Brunch Setup','Our beautiful weekend brunch table — book your spot before it fills up.','1 week ago','Events'],
                ['Private Dining Launch','Our newly refurbished private dining suite is now open for bookings.','10 days ago','Venue'],
            ] as $i => [$title,$desc,$date,$tag])
            @php
            $tagColors = ['Food'=>['rgba(249,115,22,.12)','#ea580c'],'Video'=>['rgba(124,58,237,.12)','#7c3aed'],'Events'=>['rgba(20,184,166,.12)','#0d9488'],'Venue'=>['rgba(37,99,235,.12)','#2563EB']];
            $tc = $tagColors[$tag] ?? ['rgba(100,116,139,.1)','#64748b'];
            @endphp
            <div class="activity-card reveal d-{{ $i }} rounded-2xl overflow-hidden shadow-sm bg-white {{ $i>=4?'hidden md:block':'' }}">
                <div class="relative overflow-hidden" style="aspect-ratio:16/9;">
                    <img src="{{ $gallery[$i] ?? 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=225&fit=crop' }}"
                         alt="{{ $title }}" class="w-full h-full object-cover">
                    <div class="absolute top-3 left-3">
                        <span class="text-[10px] font-black tracking-widest uppercase px-2.5 py-1 rounded-full"
                              style="background:{{ $tc[0] }};color:{{ $tc[1] }};backdrop-filter:blur(8px);">{{ $tag }}</span>
                    </div>
                </div>
                <div class="px-4 py-3.5">
                    <p class="text-[10px] font-semibold text-gray-400 mb-1">{{ $date }}</p>
                    <h4 class="font-bold text-gray-900 text-sm leading-snug mb-1">{{ $title }}</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     GOVERNMENT RECOGNITIONS
════════════════════════════════════════ --}}
 @if(count($govDocs))
<section style="background:linear-gradient(180deg,#f0f4ff 0%,#e8edf8 100%);">
    <div class="w-full px-8 md:px-16 py-10">

        <div class="flex items-end justify-between mb-7">
            <div>
                <span class="section-badge" style="background:rgba(29,78,216,.12);color:#1d4ed8;">Official</span>
                <h2 class="heading-ul text-2xl md:text-3xl font-extrabold text-gray-900 reveal">
                    Government <span style="color:#1d4ed8;">Recognitions</span>
                </h2>
            </div>
            <span class="text-xs text-gray-400 hidden md:block">Click a tile to preview</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[38%_1fr] gap-6">

            {{-- ── Left: tile list ── --}}
            <div class="flex flex-col gap-3" id="gov-tiles">
                @foreach($govDocs as $i => $doc)

                {{-- Tile button --}}
                <div class="cert-tile {{ $i===0?'active-tile':'' }} relative overflow-hidden
                             rounded-2xl flex items-center gap-3 px-4 py-3 cursor-pointer"
                     style="background:{{ $doc['tileBg'] }};
                            box-shadow:{{ $i===0?'0 4px 24px rgba(0,0,0,.22)':'0 1px 6px rgba(0,0,0,.1)' }};"
                     onclick="selectGov({{ $i }})">

                    {{-- Thumbnail --}}
                    <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border-2 flex items-center justify-center"
                         style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.2);">
                        @if(!empty($doc['img']))
                            <img src="{{ $doc['img'] }}" alt="{{ $doc['title'] }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-xl">🏛️</span>
                        @endif
                    </div>

                    {{-- Labels --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-black tracking-widest uppercase text-white/50 mb-0.5">
                            {{ $doc['no'] ?? '' }}
                        </p>
                        <p class="text-sm font-bold text-white leading-tight truncate">{{ $doc['title'] }}</p>
                        <p class="text-[10px] text-white/55">{{ $doc['title'] }} Authority of India</p>
                    </div>

                    {{-- Mobile chevron --}}
                    <span class="gov-chevron md:hidden shrink-0 text-blue-200 text-sm transition-transform duration-300
                                 {{ $i===0?'rotate-180':'' }}">▼</span>

                    {{-- Desktop active dot --}}
                    <div class="gov-dot hidden md:block w-2 h-2 rounded-full bg-blue-200 shrink-0 animate-pulse
                                {{ $i===0?'':'opacity-0' }}"></div>
                </div>

                {{-- ── Mobile inline accordion (image expands below tile) ── --}}
                <div class="gov-accordion md:hidden overflow-hidden transition-all duration-300 ease-in-out
                             {{ $i===0?'max-h-[600px] mt-2 opacity-100':'max-h-0 opacity-0' }}"
                     id="gov-accordion-{{ $i }}">
                    <div class="rounded-2xl bg-white p-4"
                         style="box-shadow:0 4px 24px rgba(0,0,0,.1);border:1px solid rgba(0,0,0,.06);">

                        {{-- Pill --}}
                        <div class="flex justify-center mb-3">
                            <span class="inline-block w-10 h-1 rounded-full"
                                  style="background:{{ $doc['color'] }};"></span>
                        </div>

                        <p class="text-[10px] font-black tracking-widest uppercase text-gray-400 text-center mb-0.5">
                            Government Document
                        </p>
                        <h3 class="text-base font-black text-center mb-1"
                            style="color:{{ $doc['color'] }};">{{ $doc['title'] }}</h3>
                        <p class="text-[10px] text-gray-400 text-center mb-3">
                            {{ $doc['title'] }} Authority of India
                        </p>

                        {{-- Document image --}}
                        @if(!empty($doc['img']))
                        <div class="rounded-xl overflow-hidden"
                             style="box-shadow:0 2px 12px rgba(0,0,0,.08);border:1px solid rgba(0,0,0,.06);">
                            <img src="{{ $doc['img'] }}" alt="{{ $doc['title'] }}" class="w-full block">
                        </div>
                        @else
                        <div class="rounded-xl flex flex-col items-center gap-3 py-6 text-center"
                             style="background:rgba(29,78,216,.06);">
                            <span class="text-5xl">🏛️</span>
                            <p class="text-sm font-bold" style="color:{{ $doc['color'] }};">{{ $doc['title'] }}</p>
                        </div>
                        @endif

                        {{-- Meta row --}}
                        <div class="flex items-center justify-between mt-3 px-1">
                            <div>
                                <p class="text-[9px] text-gray-400 uppercase font-bold">Document No.</p>
                                <p class="text-xs font-bold text-gray-700">{{ $doc['no'] ?? '—' }}</p>
                            </div>
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full"
                                 style="background:rgba(22,163,74,.1);">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                <span class="text-[10px] font-bold text-green-700">Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>

            {{-- ── Right: desktop preview panel ── --}}
            <div class="hidden md:flex flex-col" id="gov-preview">
                @if(!empty($govDocs[0]))
                @php $first = $govDocs[0]; @endphp
                <div class="rounded-3xl bg-white flex flex-col flex-1 overflow-hidden w-[600px] h-[200px]"
                     style="box-shadow:0 4px 40px rgba(0,0,0,.1);border:1px solid rgba(0,0,0,.06);">
                    <div class="flex justify-center pt-5 pb-2">
                        <span class="inline-block w-12 h-1.5 rounded-full"
                              style="background:{{ $first['color'] }};"></span>
                    </div>
                    <div class="px-8 pb-4 text-center" id="gov-preview-title">
                        <p class="text-[10px] font-black tracking-widest uppercase text-gray-400 mb-1">
                            Government Document
                        </p>
                        <h3 class="text-xl font-black" style="color:{{ $first['color'] }};">
                            {{ $first['title'] }}
                        </h3>
                    </div>
                    <div class="flex-1 min-h-0 px-6 pb-6 w-[600px] h-[200px]" id="gov-preview-img">
                    

						@if(!empty($first['img']))
<div class="rounded-2xl overflow-hidden"
     style="box-shadow:0 2px 20px rgba(0,0,0,.08);">
    <img src="{{ $first['img'] }}" alt="{{ $first['title'] }}"
         class="w-full object-cover">
</div>
@endif
                        <div class="flex items-center justify-between mt-3 px-1">
                            <div>
                                <p class="text-[9px] text-gray-400 uppercase font-bold">Document No.</p>
                                <p class="text-xs font-bold text-gray-700">{{ $first['no'] ?? '—' }}</p>
                            </div>
                            <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full"
                                 style="background:rgba(22,163,74,.1);">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                <span class="text-[10px] font-bold text-green-700">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</section>

<style>
.gov-accordion {
    transition: max-height .35s cubic-bezier(.32,.72,0,1),
                opacity    .3s ease,
                margin-top .25s ease;
}
</style>

<script>
function selectGov(i) {
    const tiles      = document.querySelectorAll('#gov-tiles .cert-tile');
    const accordions = document.querySelectorAll('.gov-accordion');
    const chevrons   = document.querySelectorAll('.gov-chevron');
    const dots       = document.querySelectorAll('.gov-dot');
    const GOV_DATA   = @json($govDocs);

    tiles.forEach((t, ti) => {
        const isActive = ti === i;

        // Tile shadow
        t.classList.toggle('active-tile', isActive);
        t.style.boxShadow = isActive
            ? '0 4px 24px rgba(0,0,0,.22)'
            : '0 1px 6px rgba(0,0,0,.1)';

        // Chevron rotation (mobile)
        if (chevrons[ti]) chevrons[ti].classList.toggle('rotate-180', isActive);

        // Active dot (desktop)
        if (dots[ti]) dots[ti].classList.toggle('opacity-0', !isActive);

        // Accordion (mobile)
        if (accordions[ti]) {
            if (isActive) {
                accordions[ti].style.maxHeight = '600px';
                accordions[ti].style.opacity   = '1';
                accordions[ti].style.marginTop = '.5rem';
            } else {
                accordions[ti].style.maxHeight = '0';
                accordions[ti].style.opacity   = '0';
                accordions[ti].style.marginTop = '0';
            }
        }
    });

    // Desktop preview panel update
    const doc = GOV_DATA[i];
    if (!doc) return;

    const titleEl = document.getElementById('gov-preview-title');
    const imgEl   = document.getElementById('gov-preview-img');

    if (titleEl) titleEl.innerHTML =
        `<p class="text-[10px] font-black tracking-widest uppercase text-gray-400 mb-1">Government Document</p>
         <h3 class="text-xl font-black" style="color:${doc.color};">${doc.title}</h3>`;

    if (imgEl) imgEl.innerHTML = (doc.img
        ? `<div class="rounded-2xl overflow-hidden" style="box-shadow:0 2px 20px rgba(0,0,0,.08);">
               <img src="${doc.img}" alt="${doc.title}" class="w-full">
           </div>`
        : `<div class="rounded-xl flex flex-col items-center gap-3 py-8 text-center"
                style="background:rgba(29,78,216,.06);">
               <span class="text-6xl">🏛️</span>
               <p class="text-sm font-bold" style="color:${doc.color};">${doc.title}</p>
           </div>`) +
        `<div class="flex items-center justify-between mt-3 px-1">
             <div>
                 <p class="text-[9px] text-gray-400 uppercase font-bold">Document No.</p>
                 <p class="text-xs font-bold text-gray-700">${doc.no || '—'}</p>
             </div>
             <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full" style="background:rgba(22,163,74,.1);">
                 <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                 <span class="text-[10px] font-bold text-green-700">Active</span>
             </div>
         </div>`;
}
</script>
@endif

{{-- ════════════════════════════════════════
     CERTIFICATIONS & AWARDS
════════════════════════════════════════ --}}



@if(count($certifications))
<section style="background:linear-gradient(180deg,#fffbf0 0%,#fef9ec 100%);">
    <div class="w-full px-8 md:px-16 py-10">

        <div class="flex items-end justify-between mb-7">
            <div>
                <span class="section-badge" style="background:rgba(217,119,6,.12);color:#d97706;">Verified</span>
                <h2 class="heading-ul text-2xl md:text-3xl font-extrabold text-gray-900 reveal">
                    <span style="color:#d97706;">Awards</span>
                </h2>
            </div>
            <span class="text-xs text-gray-400 hidden md:block">Click a tile to preview</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[1fr_38%] gap-6">

            {{-- Desktop preview (left) --}}
            <div class="hidden md:flex flex-col" id="cert-preview">
                @if(!empty($certifications[0]))

				
                <div class="rounded-3xl bg-white flex flex-col flex-1 overflow-hidden"
                     style="box-shadow:0 4px 40px rgba(0,0,0,.1);border:1px solid rgba(0,0,0,.06);">
                    <div class="flex justify-center pt-5 pb-2">
                        <span class="inline-block w-12 h-1.5 rounded-full bg-amber-500"></span>
                    </div>
                    <div class="px-8 pb-4 text-center" id="cert-preview-title">
                        <p class="text-[10px] font-black tracking-widest uppercase text-gray-400 mb-1">Certificate</p>
                        <h3 class="text-xl font-black text-amber-600">{{ $certifications[0]['name'] }}</h3>
                    </div>
                    <div class="flex-1 min-h-0 px-6 pb-6" id="cert-preview-img">
                        @if(!empty($certifications[0]['img']))
                        <div class="rounded-2xl overflow-hidden" style="box-shadow:0 2px 20px rgba(0,0,0,.08);">
                            <img src="{{ $certifications[0]['img'] }}"
                                 alt="{{ $certifications[0]['name'] }}" class="w-full">
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Tile list (right desktop / full-width mobile) --}}
            <div class="flex flex-col gap-3" id="cert-tiles">
                @foreach($certifications as $i => $cert)
  @php $bg = $linearGradients[$i % count($linearGradients)];  @endphp
                {{-- Tile button --}}
                <div class="cert-tile {{ $i===0 ? 'active-tile' : '' }} relative overflow-hidden
                             rounded-2xl flex items-center gap-3 px-4 py-3 cursor-pointer"
                     style="background:{{ $bg }};
                            box-shadow:{{ $i===0 ? '0 4px 24px rgba(0,0,0,.22)' : '0 1px 6px rgba(0,0,0,.1)' }};"
                     onclick="selectCert({{ $i }})">

                    {{-- Thumbnail --}}
                    <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border-2 flex items-center justify-center"
                         style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.2);">
                        @if(!empty($cert['img']))
                            <img src="{{ $cert['img'] }}" alt="{{ $cert['name'] }}"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-xl">🏅</span>
                        @endif
                    </div>

                    {{-- Label --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white leading-tight truncate">{{ $cert['name'] }}</p>
                    </div>

                    {{-- Mobile chevron --}}
                    <span class="cert-chevron md:hidden shrink-0 text-amber-300 text-sm transition-transform duration-300
                                 {{ $i===0 ? 'rotate-180' : '' }}">▼</span>

                    {{-- Desktop active dot --}}
                    <div class="cert-active-dot hidden md:block w-2 h-2 rounded-full bg-amber-300 shrink-0 animate-pulse
                                {{ $i===0 ? '' : 'opacity-0' }}"></div>
                </div>

                {{-- ── Mobile inline accordion ── --}}
                <div class="cert-accordion md:hidden overflow-hidden transition-all duration-300 ease-in-out
                             {{ $i===0 ? 'max-h-[600px] mt-2 opacity-100' : 'max-h-0 opacity-0' }}"
                     id="cert-accordion-{{ $i }}">
                    <div class="rounded-2xl bg-white p-4"
                         style="box-shadow:0 4px 24px rgba(0,0,0,.1);border:1px solid rgba(0,0,0,.06);">
                        {{-- Pill --}}
                        <div class="flex justify-center mb-3">
                            <span class="inline-block w-10 h-1 rounded-full bg-amber-500"></span>
                        </div>
                        <p class="text-[10px] font-black tracking-widest uppercase text-gray-400 text-center mb-0.5">
                            Certificate
                        </p>
                        <h3 class="text-base font-black text-amber-600 text-center mb-3">
                            {{ $cert['name'] }}
                        </h3>
                        @if(!empty($cert['img']))
                        <div class="rounded-xl overflow-hidden"
                             style="box-shadow:0 2px 12px rgba(0,0,0,.08);border:1px solid rgba(0,0,0,.06);">
                            <img src="{{ $cert['img'] }}" alt="{{ $cert['name'] }}" class="w-full block">
                        </div>
                        @else
                        <div class="rounded-xl flex flex-col items-center gap-3 py-6 text-center"
                             style="background:rgba(217,119,6,.08);">
                            <span class="text-5xl">🏅</span>
                            <p class="text-sm font-bold text-amber-700">{{ $cert['name'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @endforeach
            </div>

        </div>
    </div>
</section>

<style>
/* Smooth accordion via max-height transition */
.cert-accordion {
    transition: max-height .35s cubic-bezier(.32,.72,0,1),
                opacity    .3s ease,
                margin-top .25s ease;
}
</style>

<script>
function selectCert(i) {
    const tiles     = document.querySelectorAll('#cert-tiles .cert-tile');
    const accordions= document.querySelectorAll('.cert-accordion');
    const chevrons  = document.querySelectorAll('.cert-chevron');
    const dots      = document.querySelectorAll('.cert-active-dot');
    const CERTS_DATA= @json($certifications);   // already defined in parent page

    tiles.forEach((t, ti) => {
        const isActive = ti === i;
        // Tile style
        t.classList.toggle('active-tile', isActive);
        t.style.boxShadow = isActive
            ? '0 4px 24px rgba(0,0,0,.22)'
            : '0 1px 6px rgba(0,0,0,.1)';
        // Chevron (mobile)
        if (chevrons[ti]) chevrons[ti].classList.toggle('rotate-180', isActive);
        // Active dot (desktop)
        if (dots[ti]) dots[ti].classList.toggle('opacity-0', !isActive);
        // Accordion (mobile)
        if (accordions[ti]) {
            if (isActive) {
                accordions[ti].style.maxHeight = '600px';
                accordions[ti].style.opacity   = '1';
                accordions[ti].style.marginTop = '.5rem';
            } else {
                accordions[ti].style.maxHeight = '0';
                accordions[ti].style.opacity   = '0';
                accordions[ti].style.marginTop = '0';
            }
        }
    });

    // Desktop preview panel
    const cert = CERTS_DATA[i];
    if (!cert) return;
    const titleEl = document.getElementById('cert-preview-title');
    const imgEl   = document.getElementById('cert-preview-img');
    if (titleEl) titleEl.innerHTML =
        `<p class="text-[10px] font-black tracking-widest uppercase text-gray-400 mb-1">Certificate</p>
         <h3 class="text-xl font-black text-amber-600">${cert.name || ''}</h3>`;
    if (imgEl) imgEl.innerHTML = cert.img
        ? `<div class="rounded-2xl overflow-hidden" style="box-shadow:0 2px 20px rgba(0,0,0,.08);">
               <img src="${cert.img}" alt="${cert.name || ''}" class="w-full">
           </div>`
        : `<div class="rounded-xl flex flex-col items-center gap-3 py-8 text-center"
                style="background:rgba(217,119,6,.08);">
               <span class="text-6xl">🏅</span>
               <p class="text-sm font-bold text-amber-700">${cert.name || ''}</p>
           </div>`;
}
</script>
@endif


 

{{-- ════════════════════════════════════════
     HOURS & CONTACT
════════════════════════════════════════ --}}
<section class="bg-white">
    <div class="w-full px-8 md:px-16 py-8 reveal">
        <div class="rounded-2xl overflow-hidden border" style="border-color:rgba(234,88,12,.15);">
            <div class="px-6 py-3.5 flex items-center gap-3" style="background:linear-gradient(135deg,#f59e0b 0%,#ea580c 100%);">
                <span class="text-white">🕐</span>
                <span class="font-bold text-white text-sm">Hours &amp; Contact</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-blue-50">
                {{-- Hours --}}
                <div class="px-6 py-5">
                    <p class="text-[10px] font-black tracking-widest uppercase mb-3" style="color:#f59e0b;">Opening Hours</p>
                    <div class="space-y-1.5">
                        @foreach($hours as $h)
                        @php $isToday = $h['day'] === $todayDay; $isClosed = $h['hours'] === 'Closed'; @endphp
                        <div class="flex justify-between items-center text-xs rounded-lg px-2 py-1 {{ $isToday?'':''}}"
                             style="{{ $isToday?'background:rgba(37,99,235,.07);':'' }}">
                            <div class="flex items-center gap-1.5">
                                @if($isToday)<span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>@endif
                                <span class="{{ $isToday?'font-bold text-blue-700':($isClosed?'text-gray-300':'text-gray-500') }}">{{ $h['day'] }}</span>
                            </div>
                            <span class="{{ $isToday?'font-semibold text-blue-700':($isClosed?'text-gray-300':'text-gray-400') }}">{{ $h['hours'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- Contact --}}
                <div class="px-6 py-5">
                    <p class="text-[10px] font-black tracking-widest uppercase mb-3" style="color:#0891b2;">Get In Touch</p>
                    <div class="space-y-3">
                        @foreach([
                            ['📍', $clientsList['business_name'] ?? '', null, '#ea580c'],
                            ['📞', '+917559435943', 'tel:+917559435943', '#0891b2'],
                            ['✉️', $clientsList['email'] ?? '', 'mailto:'.($clientsList['email']??'#'), '#7c3aed'],
                            ['🌐', $clientsList['website'] ?? '', $clientsList['website'] ?? '#', '#2563eb'],
                        ] as [$icon,$text,$href,$color])
                        @if($text)
                        <div class="flex items-start gap-2.5">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center shrink-0 mt-0.5 text-sm"
                                 style="background:{{ $color }}18;">{{ $icon }}</div>
                            @if($href)
                            <a href="{{ $href }}" class="text-xs text-gray-600 hover:text-blue-600 transition-colors leading-snug">{{ $text }}</a>
                            @else
                            <p class="text-xs text-gray-500 leading-snug">{{ $text }}</p>
                            @endif
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                {{-- Social + CTA --}}
                <div class="px-6 py-5 flex flex-col justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-black tracking-widest uppercase mb-3" style="color:#7c3aed;">Follow Us</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach([
                                ['📸', $clientsList['social']['instagram_url'] ?? '#', 'linear-gradient(135deg,#f43f5e,#a855f7,#f59e0b)'],
                                ['👥', $clientsList['social']['facebook_url']  ?? '#', '#1877f2'],
                                ['💬', 'https://wa.me/917559435943',                   '#25d366'],
                            ] as [$icon,$href,$bg])
                            <a href="{{ $href }}" target="_blank"
                               class="w-9 h-9 rounded-full flex items-center justify-center hover:opacity-80 transition-opacity"
                               style="background:{{ $bg }};color:#fff;">{{ $icon }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ $googleMapUrl }}" target="_blank"
                       class="flex items-center justify-center gap-2 text-xs font-bold rounded-xl py-2.5 text-white hover:opacity-90 transition-opacity"
                       style="background:linear-gradient(135deg,#f59e0b,#ea580c);">
                        📍 Get Directions
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     RELATED SEARCHES
════════════════════════════════════════ --}}
@if(count($relatedList))
<section class="bg-white">
    <div class="w-full px-8 md:px-16 py-6 reveal">
        <div class="rounded-2xl overflow-hidden border" style="border-color:rgba(234,88,12,.15);">
            <div class="px-6 py-3.5 flex items-center gap-3" style="background:linear-gradient(135deg,rgb(11,218,245),rgb(12,182,234));">
                <span class="font-bold text-white text-sm">Related Searches</span>
            </div>
            <div class="px-6 py-5">
                <ul class="flex flex-wrap gap-2">
                    @foreach($relatedList as $i => $item)
                    <li>
                        <a href="{{ route('showCity', $item['slug']) }}" class="text-blue-600 hover:underline text-sm">
                            {{ $item['title'] }}{{ $i < count($relatedList)-1 ? ' |' : '' }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════
     AREA / OVERVIEW BUSINESS
════════════════════════════════════════ --}}
@if(!empty($areaBusiness['heading']) || !empty($overviewBusiness['heading']))
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 md:px-8">
        @if(!empty($areaBusiness['heading']))
        <div class="reveal text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">{{ $areaBusiness['heading'] }}</h1>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">{{ $areaBusiness['paragraph'] ?? '' }}</p>
        </div>
        @endif
        <div class="grid md:grid-cols-12 gap-10 items-start">
            <div class="md:col-span-8 reveal">
                @if(!empty($overviewBusiness['heading']))
                <h2 class="text-3xl font-semibold text-gray-900 mb-6">{{ $overviewBusiness['heading'] }}</h2>
                <div class="text-gray-700 leading-relaxed space-y-4">
                    <p>{{ $overviewBusiness['paragraph'] ?? '' }}</p>
                    <p class="font-medium text-gray-800">{{ $overviewBusiness['paragraph1'] ?? '' }}</p>
                </div>
                @endif
            </div>
            <div class="md:col-span-4 reveal-r">
                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-8 sticky top-24">
                    <h3 class="font-semibold text-xl mb-6 flex items-center gap-3">
                        🏢 Why Choose Us?
                    </h3>
                    <div class="space-y-6">
                        @foreach([['👥','Expert Faculty','Industry-experienced trainers'],['🏆','Certification','Industry-recognized certificates'],['🎯','Job-Oriented','Placement assistance & projects']] as $w)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-white flex items-center justify-center shadow-sm text-lg">{{ $w[0] }}</div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $w[1] }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $w[2] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════
     REVIEWS
════════════════════════════════════════ --}}
<section style="background:linear-gradient(135deg,#faf5ff 0%,#ede9fe 40%,#f0f9ff 100%);">
    <div class="w-full px-8 md:px-16 py-10">
        <div class="reveal mb-12 flex flex-col items-center text-center gap-5">
            <span class="section-badge" style="background:rgba(168,85,247,.12);color:#7c3aed;border:1px solid rgba(168,85,247,.25);">Customer Reviews</span>
            <h2 class="heading-ul text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">What People Say</h2>
            <button onclick="document.getElementById('review-form-modal').classList.add('open')"
                    class="flex items-center justify-center gap-2.5 px-7 py-4 rounded-2xl font-bold text-base text-white"
                    style="background:linear-gradient(135deg,#6d28d9,#a855f7,#ec4899);box-shadow:0 4px 24px rgba(124,58,237,.4);">
                ★ Write Your Review
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="rounded-2xl p-8 sticky top-20 border" style="background:linear-gradient(135deg,#2563EB,#0891b2);">
                    <h3 class="text-lg font-bold text-white/80 mb-4">Overall Rating</h3>
                    <div class="flex items-end gap-3 mb-6">
                        <span class="text-6xl font-extrabold tracking-tighter leading-none text-white">{{ $clientsList['rating'] ?? '5' }}</span>
                        <div class="pb-1.5">
                            <div class="flex text-yellow-400 mb-1">★★★★★</div>
                            <span class="text-sm text-white/60">{{ $clientsList['ratingCount'] ?? '' }} reviews</span>
                        </div>
                    </div>
                    <div class="space-y-2.5">
                        @foreach([85,10,3,1,1] as $i => $pct)
                        <div class="flex items-center gap-2">
                            <span class="w-3 text-xs text-white/50 text-right">{{ 5-$i }}</span>
                            <span class="text-yellow-400 text-xs">★</span>
                            <div class="flex-1 h-2 rounded-full overflow-hidden" style="background:rgba(255,255,255,.2);">
                                <div class="h-full rounded-full bg-white" style="width:{{ $pct }}%;"></div>
                            </div>
                            <span class="w-8 text-xs text-white/50">{{ $pct }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Review cards --}}
            <div class="lg:col-span-2 flex flex-col gap-4">
                {{-- Filter row --}}
                <div class="flex flex-wrap gap-2" id="review-filters">
                    @foreach(['all'=>'All','5'=>'5★','4'=>'4★','3'=>'3★','2'=>'2★','1'=>'1★'] as $key => $label)
                    <button class="review-filter-btn px-3 py-1.5 rounded-full text-xs font-bold transition-all {{ $key==='all'?'text-white':'text-purple-700'}} "
                            style="{{ $key==='all'?'background:linear-gradient(135deg,#7c3aed,#a855f7);box-shadow:0 2px 12px rgba(124,58,237,.35);':'background:rgba(124,58,237,.08);border:1px solid rgba(124,58,237,.18);' }}"
                            data-filter="{{ $key }}" onclick="filterReviews(this, '{{ $key }}')">
                        {{ $label }}
                    </button>
                    @endforeach
                </div>

                <div class="h-px" style="background:rgba(124,58,237,.1);"></div>

                <div id="review-list" class="flex flex-col gap-4">
                    @forelse($reviews as $i => $review)
                    @php
                    $grad = $gradients[$i % count($gradients)];
                    $author = $review['comment_author'] ?? 'Anonymous';
                    $initials = strtoupper(substr($author,0,2));
                    $rating = (int)($review['rating'] ?? 5);
                    @endphp
                    <div class="review-card reveal d-{{ min($i%6,5) }} rounded-2xl p-6 border"
                         data-rating="{{ $rating }}">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 shrink-0 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md bg-gradient-to-br {{ $grad }}">
                                {{ $initials }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center flex-wrap gap-2 mb-1">
                                    <h4 class="font-bold text-gray-900">{{ $author }}</h4>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full"
                                          style="background:rgba(34,197,94,.1);color:#15803d;border:1px solid rgba(34,197,94,.2);">
                                        ✓ Verified
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="flex text-yellow-400">
                                        @for($s=0;$s<5;$s++)<span class="text-sm {{ $s<$rating?'text-yellow-400':'text-gray-200' }}">★</span>@endfor
                                    </div>
                                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($review['created_at'] ?? now())->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-500 leading-relaxed text-sm">"{{ $review['comment_content'] ?? 'Great experience!' }}"</p>
                    </div>
                    @empty
                    <div class="py-12 text-center rounded-2xl" style="background:rgba(124,58,237,.04);border:1px dashed rgba(124,58,237,.2);">
                        <p class="font-bold text-gray-400 text-sm">No reviews yet. Be the first!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     MOBILE BOTTOM BAR
════════════════════════════════════════ --}}
<div id="mobile-bar" class="fixed left-0 bottom-2 right-0 z-50 flex items-center gap-2 px-4 py-3 md:hidden"
     style="background:rgba(255,255,255,.95);backdrop-filter:blur(16px);border-top:1px solid rgba(59,130,246,.15);box-shadow:0 -4px 24px rgba(37,99,235,.1);">
    <a href="tel:+917559435943" class="flex-1">
        <button class="w-full flex items-center justify-center gap-1.5 py-3 rounded-2xl font-bold text-sm text-white" style="background:#16a34a;">
            📞 Call Now
        </button>
    </a>
    <a href="https://wa.me/917559435943" target="_blank" rel="noreferrer" class="flex-1">
        <button class="w-full flex items-center justify-center gap-1.5 py-3 rounded-2xl font-bold text-sm text-white" style="background:#25D366;">
            💬 WhatsApp
        </button>
    </a>
    <button class="flex-1 flex items-center justify-center gap-1.5 py-3 rounded-2xl font-bold text-sm text-white glow-pulse"
            style="background:#2563EB;"
            onclick="document.getElementById('enquiry-modal').classList.add('open')">
        ✉️ Enquire Now
    </button>
</div>

{{-- ════════════════════════════════════════
     ENQUIRY MODAL (popup)
════════════════════════════════════════ --}}
<div id="enquiry-modal" class="fixed inset-0 z-[210] hidden items-center justify-center p-4"
     style="background:rgba(10,15,40,.75);backdrop-filter:blur(14px);"
     onclick="if(event.target===this)this.classList.remove('open')">
    <div class="relative w-full max-w-md overflow-hidden" style="border-radius:1.75rem;" onclick="event.stopPropagation()">
        @include('client.layouts.enquiry_common_popup', ['keywordList' => $keywordList, 'planOptions' => $planOptions, 'formId' => 'modal'])
    </div>
</div>
{{-- Show modal by adding .open = display:flex --}}
<style>#enquiry-modal.open{display:flex;}</style>

{{-- ════════════════════════════════════════
     LOCATION MODAL
════════════════════════════════════════ --}}
<div id="location-modal" class="fixed inset-0 z-[210] hidden items-center justify-center p-4"
     style="background:rgba(10,15,40,.75);backdrop-filter:blur(14px);"
     onclick="if(event.target===this)this.classList.remove('open')">
    <div class="bg-white rounded-2xl p-6 w-full max-w-xl" onclick="event.stopPropagation()">
        <h2 class="text-xl font-bold mb-4">Find Us</h2>
        <p class="text-gray-500 text-sm flex items-start gap-2 mb-4">
            📍 {{ $clientsList['address'] ?? '' }}
        </p>
        <iframe src="{{ $mapSrc }}" width="100%" height="300" style="border:0;border-radius:.75rem;" allowfullscreen loading="lazy"></iframe>
        <a href="{{ $googleMapUrl }}" target="_blank" rel="noreferrer"
           class="mt-4 flex items-center justify-center gap-2 w-full py-2.5 rounded-xl font-semibold text-blue-700 border border-blue-200 hover:bg-blue-50 transition-colors">
            📍 View on Google Maps
        </a>
    </div>
</div>
<style>#location-modal.open{display:flex;}</style>

{{-- ════════════════════════════════════════
     LIGHTBOX
════════════════════════════════════════ --}}
<div id="lightbox" onclick="if(event.target===this)closeLightbox()">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 w-10 h-10 rounded-full flex items-center justify-center text-white/60 hover:text-white" style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);">✕</button>
    <button onclick="lbPrev()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full flex items-center justify-center text-white/60 hover:text-white" style="background:rgba(255,255,255,.1);">‹</button>
    <button onclick="lbNext()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full flex items-center justify-center text-white/60 hover:text-white" style="background:rgba(255,255,255,.1);">›</button>
    <div id="lightbox-content" class="max-w-5xl max-h-[90vh] p-8 md:p-16 flex items-center justify-center w-full">
        <img id="lightbox-img" src="" alt="" class="max-w-full max-h-full object-contain rounded-xl shadow-2xl">
    </div>
</div>

{{-- ════════════════════════════════════════
     GALLERY MODAL
════════════════════════════════════════ --}}
<div id="gallery-modal">
    <div class="flex items-center gap-3 px-4 py-3 shrink-0" style="background:#1a1a2e;border-bottom:1px solid rgba(255,255,255,.08);">
        <button onclick="document.getElementById('gallery-modal').classList.remove('open')" class="flex items-center gap-1.5 text-white/70 hover:text-white">
            ‹ <span class="text-sm font-semibold hidden sm:inline">Back</span>
        </button>
        <div class="flex-1 min-w-0">
            <p class="text-white font-bold text-sm truncate">{{ $clientsList['business_name'] ?? '' }}</p>
        </div>
        <a href="tel:+917559435943" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-white" style="background:#22c55e;">📞 Call</a>
        <button onclick="document.getElementById('gallery-modal').classList.remove('open');document.getElementById('enquiry-modal').classList.add('open');"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-white" style="background:#2563eb;">✉️ Enquire</button>
    </div>
    <div class="flex-1 overflow-y-auto p-3" style="background:#f9fafb;">
        <div class="grid gap-2" style="grid-template-columns:repeat(3,1fr);grid-auto-rows:160px;">
            @foreach($gallery as $i => $img)
            <div class="gallery-grid-item {{ $i===0?'col-span-1 row-span-2':'' }}"
                 onclick="closeLightbox();openLightbox({{ $i }})">
                <img src="{{ $img }}" alt="Gallery {{ $i+1 }}"
                     onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=300&fit=crop'">
                <div class="gallery-overlay"></div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Review Form Modal (simple) --}}
<div id="review-form-modal" class="fixed inset-0 z-[220] hidden items-center justify-center p-4"
     style="background:rgba(10,15,40,.75);backdrop-filter:blur(14px);"
     onclick="if(event.target===this)this.classList.remove('open')">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md" onclick="event.stopPropagation()">
        <h2 class="text-xl font-bold mb-4">Write a Review</h2>
        <div id="star-input" class="flex gap-2 mb-4">
            @for($s=1;$s<=5;$s++)<span class="text-3xl cursor-pointer text-gray-300 star-btn" data-star="{{ $s }}" onclick="setRating({{ $s }})">★</span>@endfor
        </div>
        <input type="hidden" id="review-rating-val" value="0">
        <input type="text" id="review-name-val" placeholder="Your name" class="w-full border rounded-xl px-3 py-2.5 text-sm mb-3 outline-none focus:border-blue-400">
        <textarea rows="3" id="review-text-val" placeholder="Share your experience…" class="w-full border rounded-xl px-3 py-2.5 text-sm mb-4 resize-none outline-none focus:border-blue-400"></textarea>
        <button onclick="submitReview()" class="w-full py-3 rounded-xl font-bold text-white text-sm" style="background:linear-gradient(135deg,#7c3aed,#a855f7);">
            Submit Review
        </button>
    </div>
</div>
<style>#review-form-modal.open{display:flex;}</style>

 

 
{{-- Pass PHP data to JS --}}
<script>
const GALLERY  = @json($gallery);
const GOV_DOCS = @json($govDocs);
const CERTS    = @json($certifications);
const H_IMGS   = @json($hImages);
const V_IMGS   = @json($vImages);
</script>

<script>
(function () {
    /* ── Scroll progress ── */
    const bar = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
        const pct = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight) || 0;
        bar.style.width = (pct * 100) + '%';
    }, { passive: true });

    /* ── Reveal ── */
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.06, rootMargin: '0px 0px -30px 0px' });
    document.querySelectorAll('.reveal,.reveal-r').forEach(el => io.observe(el));

    /* ── Heading underline ── */
    const hio = new IntersectionObserver((entries) => entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('in-view');
    }), { threshold: 0.3 });
    document.querySelectorAll('.heading-ul').forEach(el => hio.observe(el));

    /* ── Hero image sliders ── */
    let hIdx = 0, vIdx = 0;
    const hImgs = document.querySelectorAll('[data-h-slide]');
    const vImgs = document.querySelectorAll('[data-v-slide]');

    const slide = (imgs, idx) => { imgs.forEach(i => i.classList.remove('active')); if (imgs[idx]) imgs[idx].classList.add('active'); };

    if (hImgs.length) setInterval(() => { hIdx = (hIdx + 1) % hImgs.length; slide(hImgs, hIdx); }, 3000);
    if (vImgs.length) setInterval(() => { vIdx = (vIdx + 1) % vImgs.length; slide(vImgs, vIdx); }, 3800);

    /* ── Share dropdown close on outside click ── */
    document.addEventListener('click', (e) => {
        const dd = document.getElementById('share-dropdown');
        if (dd && !dd.parentElement.contains(e.target)) dd.classList.remove('open');
    });

})();

/* ── Lightbox ── */
let lbIdx = 0;
function openLightbox(i) {
    lbIdx = i;
    document.getElementById('lightbox-img').src = GALLERY[i] || '';
    document.getElementById('lightbox').classList.add('open');
}
function closeLightbox() { document.getElementById('lightbox').classList.remove('open'); }
function lbNext() { lbIdx = (lbIdx + 1) % GALLERY.length; document.getElementById('lightbox-img').src = GALLERY[lbIdx]; }
function lbPrev() { lbIdx = (lbIdx - 1 + GALLERY.length) % GALLERY.length; document.getElementById('lightbox-img').src = GALLERY[lbIdx]; }
document.addEventListener('keydown', (e) => {
    if (!document.getElementById('lightbox').classList.contains('open')) return;
    if (e.key === 'ArrowRight') lbNext();
    if (e.key === 'ArrowLeft')  lbPrev();
    if (e.key === 'Escape')     closeLightbox();
});
 

/* ── Review filter ── */
function filterReviews(btn, filter) {
    document.querySelectorAll('.review-filter-btn').forEach(b => {
        b.style.background = 'rgba(124,58,237,.08)';
        b.style.boxShadow  = 'none';
        b.style.color      = '#7c3aed';
    });
    btn.style.background = 'linear-gradient(135deg,#7c3aed,#a855f7)';
    btn.style.boxShadow  = '0 2px 12px rgba(124,58,237,.35)';
    btn.style.color      = 'white';

    document.querySelectorAll('#review-list .review-card').forEach(card => {
        const rating = card.dataset.rating;
        card.style.display = (filter === 'all' || rating === filter) ? '' : 'none';
    });
}

/* ── Review star rating ── */
function setRating(n) {
    document.getElementById('review-rating-val').value = n;
    document.querySelectorAll('.star-btn').forEach((s, i) => {
        s.style.color = i < n ? '#f59e0b' : '#d1d5db';
    });
}

/* ── Submit review ── */
function submitReview() {
    const rating = document.getElementById('review-rating-val').value;
    const name   = document.getElementById('review-name-val').value;
    const text   = document.getElementById('review-text-val').value;
    if (!rating || !name || !text) return alert('Please fill all fields and select a rating.');
    document.getElementById('review-form-modal').classList.remove('open');
    // TODO: POST to your review API
    alert('Thank you for your review!');
}

/* ── Copy link ── */
function copyPageLink(btn) {
    navigator.clipboard.writeText(window.location.href).catch(() => {});
    const orig = btn.textContent;
    btn.textContent = '✓ Copied!';
    setTimeout(() => { btn.textContent = orig; document.getElementById('share-dropdown').classList.remove('open'); }, 2000);
}

/* ── 3-Step Enquiry Form ── */
(function () {
    document.querySelectorAll('[data-enquiry-form]').forEach(form => {
        const steps = form.querySelectorAll('[data-step]');
        const dots  = form.querySelectorAll('[data-dot]');
        const lines = form.querySelectorAll('[data-line]');
        let current = 1;

        const show = (n) => {
            current = n;
            steps.forEach(s => s.classList.toggle('hidden', +s.dataset.step !== n));
            dots.forEach(d => {
                const dn = +d.dataset.dot;
                d.className = 'step-dot ' + (dn < n ? 'done' : dn === n ? 'active' : 'pending');
                d.textContent = dn < n ? '✓' : dn;
            });
            lines.forEach(l => { l.style.background = +l.dataset.line < n ? 'rgba(255,255,255,.7)' : 'rgba(255,255,255,.2)'; });
        };

        form.querySelectorAll('[data-next]').forEach(btn => {
            btn.addEventListener('click', () => show(current + 1));
        });
        form.querySelectorAll('[data-back]').forEach(btn => {
            btn.addEventListener('click', () => show(current - 1));
        });
        form.querySelectorAll('[data-send]').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.disabled = true;
                btn.textContent = 'Sending…';
                setTimeout(() => {
                    show(4);
                    form.querySelector('[data-step="4"]').classList.remove('hidden');
                    steps.forEach(s => s.classList.add('hidden'));
                    form.querySelector('[data-step="4"]').classList.remove('hidden');
                }, 1100);
            });
        });

        // OTP boxes
        const otpBoxes = form.querySelectorAll('.otp-box');
        otpBoxes.forEach((box, i) => {
            box.addEventListener('input', () => {
                box.value = box.value.replace(/\D/g,'').slice(-1);
                box.classList.toggle('filled', !!box.value);
                if (box.value && i < otpBoxes.length - 1) otpBoxes[i+1].focus();
            });
            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !box.value && i > 0) otpBoxes[i-1].focus();
            });
        });

        form.querySelectorAll('[data-verify]').forEach(btn => {
            btn.addEventListener('click', () => {
                const otp = Array.from(otpBoxes).map(b => b.value).join('');
                if (otp.length < 5) return;
                form.querySelector('[data-success]')?.classList.remove('hidden');
                steps.forEach(s => s.classList.add('hidden'));
                form.querySelector('[data-success]')?.classList.remove('hidden');
            });
        });
    });
})();
</script>
 
  







 
@endsection