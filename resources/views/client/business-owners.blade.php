 
@extends('client.layouts.app')

@section('title', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
@section('description', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
@section('keyword', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')

@section('content')
 @include('client.components.banner-section')
 
<style>
  
.gradient-text {
    background: linear-gradient(135deg, #2563eb 0%, #7c3aed 50%, #06b6d4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ══════════════════════════════════════════
   ORB ANIMATIONS
══════════════════════════════════════════ */
.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    animation: orb-float 10s ease-in-out infinite;
}
.orb-1 { width:600px;height:600px;background:rgba(96,165,250,.15);top:-12rem;left:-12rem;animation-delay:0s; }
.orb-2 { width:500px;height:500px;background:rgba(167,139,250,.10);top:2.5rem;right:-12rem;animation-delay:3s; }
.orb-3 { width:300px;height:300px;background:rgba(34,211,238,.15);bottom:0;left:50%;animation-delay:6s; }
@keyframes orb-float {
    0%,100% { transform: translate(0,0) scale(1); }
    33%      { transform: translate(40px,-30px) scale(1.3); }
    66%      { transform: translate(-20px,20px) scale(0.9); }
}

/* ══════════════════════════════════════════
   MORPHING BLOB
══════════════════════════════════════════ */
.blob {
    position: absolute;
    pointer-events: none;
    filter: blur(24px);
    opacity: .3;
    animation: blob-morph 12s ease-in-out infinite;
}
@keyframes blob-morph {
    0%,100% { border-radius:60% 40% 30% 70%/60% 30% 70% 40%; transform:rotate(0deg); }
    33%      { border-radius:30% 60% 70% 40%/50% 60% 30% 60%; transform:rotate(120deg); }
    66%      { border-radius:50% 40% 60% 30%/40% 50% 60% 70%; transform:rotate(240deg); }
}

/* ══════════════════════════════════════════
   GLOW CARD BORDER
══════════════════════════════════════════ */
.glow-card-wrap { position:relative; }
.glow-border {
    position:absolute;
    inset:-2px;
    border-radius:1.5rem;
    opacity:.8;
    filter:blur(4px);
    background:linear-gradient(135deg,#2563eb,#7c3aed,#06b6d4,#2563eb);
    background-size:300% 300%;
    animation:glow-rotate 5s linear infinite;
    z-index:0;
}
@keyframes glow-rotate { to { background-position:300% 300%; } }
.glow-card-inner { position:relative;z-index:1;background:white;border-radius:1.5rem;overflow:hidden; }

/* ══════════════════════════════════════════
   FORM HEADER SHIMMER
══════════════════════════════════════════ */
.form-header-shimmer {
    position:absolute;inset:0;opacity:.3;
    background:linear-gradient(90deg,transparent 0%,rgba(255,255,255,.4) 50%,transparent 100%);
    background-size:200% 100%;
    animation:shimmer-h 3s linear infinite;
}
@keyframes shimmer-h { to { background-position:200% 0%; } }

/* ══════════════════════════════════════════
   STAT CARD TILT (CSS only)
══════════════════════════════════════════ */
.stat-card {
    transition: transform .25s ease, box-shadow .25s ease;
    transform-style: preserve-3d;
}
.stat-card:hover { transform:translateY(-4px) scale(1.04); box-shadow:0 8px 24px rgba(37,99,235,.12); }

/* ══════════════════════════════════════════
   BENEFIT ROW
══════════════════════════════════════════ */
.benefit-row { transition: transform .2s ease; }
.benefit-row:hover { transform: translateX(4px) scale(1.01); }

/* ══════════════════════════════════════════
   SUCCESS STORY SLIDER
══════════════════════════════════════════ */
.story-slide { transition: opacity .35s ease, transform .35s ease; }
.story-slide.hidden-slide { opacity:0; pointer-events:none; position:absolute; top:0; left:0; right:0; }

/* ══════════════════════════════════════════
   REVEAL
══════════════════════════════════════════ */
.reveal { opacity:0; transform:translateY(28px); transition:opacity .5s ease,transform .5s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.reveal-left { opacity:0; transform:translateX(-20px); transition:opacity .5s ease,transform .5s ease; }
.reveal-left.visible { opacity:1; transform:translateX(0); }

/* ══════════════════════════════════════════
   COUNT-UP TARGETS
══════════════════════════════════════════ */
/* (handled by JS) */

/* ══════════════════════════════════════════
   PACKAGE CARD
══════════════════════════════════════════ */
.pkg-card { transition:transform .2s ease,box-shadow .2s ease,border-color .2s; cursor:pointer; }
.pkg-card:hover { transform:translateY(-3px) scale(1.04); }
.pkg-card.selected-starter { border-color:#64748b !important; background:linear-gradient(to bottom,#f8fafc,#f1f5f9); box-shadow:0 4px 16px rgba(100,116,139,.15); }
.pkg-card.selected-growth  { border-color:#2563eb !important; background:linear-gradient(to bottom,#eff6ff,#eef2ff); box-shadow:0 4px 16px rgba(37,99,235,.18); }
.pkg-card.selected-premium { border-color:#7c3aed !important; background:linear-gradient(to bottom,#f5f3ff,#faf5ff); box-shadow:0 4px 16px rgba(124,58,237,.18); }

/* ══════════════════════════════════════════
   INPUT FOCUS RING
══════════════════════════════════════════ */
.form-input {
    width:100%;padding:.625rem 1rem .625rem 2.25rem;
    border-radius:.75rem;border:1px solid #e2e8f0;
    background:#f8fafc;font-size:.875rem;outline:none;
    transition:all .2s ease;
}
.form-input:focus {
    border-color:#60a5fa;background:white;
    box-shadow:0 0 0 4px rgba(37,99,235,.08), 0 4px 16px rgba(37,99,235,.1);
}
.form-input:hover:not(:focus) { border-color:#cbd5e1;background:white; }
select.form-input { padding-left:1rem; }

/* ══════════════════════════════════════════
   SUBMIT BUTTON GRADIENT
══════════════════════════════════════════ */
.submit-btn {
    background:linear-gradient(to right,#2563eb,#4f46e5,#7c3aed);
    transition:all .2s ease;
    box-shadow:0 8px 24px rgba(37,99,235,.35);
}
.submit-btn:hover { filter:brightness(1.08); transform:translateY(-1px); }
.submit-btn:active { transform:scale(.97); }
.submit-btn:disabled { background:linear-gradient(to right,#94a3b8,#cbd5e1);box-shadow:none;cursor:not-allowed; }

/* ══════════════════════════════════════════
   LIVE ACTIVITY PULSE
══════════════════════════════════════════ */
.live-dot { animation:live-pulse 1.4s ease-in-out infinite; }
@keyframes live-pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.3;transform:scale(.8)} }

/* ══════════════════════════════════════════
   SUCCESS STATE
══════════════════════════════════════════ */
#form-success { display:none; }
#form-success.show { display:flex; }

/* ══════════════════════════════════════════
   FAQ ACCORDION
══════════════════════════════════════════ */
.faq-body { max-height:0;overflow:hidden;transition:max-height .35s cubic-bezier(0.04,.62,.23,.98); }
.faq-body.open { max-height:400px; }
.faq-bar { position:absolute;left:0;top:0;bottom:0;width:3px;
    background:linear-gradient(to bottom,#60a5fa,#818cf8,#a78bfa);
    border-radius:0 2px 2px 0;transform:scaleY(0);transform-origin:top;
    transition:transform .3s ease; }
.faq-item.open .faq-bar { transform:scaleY(1); }
.faq-chevron { transition:transform .28s ease; }
.faq-item.open .faq-chevron { transform:rotate(180deg); }

/* ══════════════════════════════════════════
   REVIEW SLIDER
══════════════════════════════════════════ */
.review-page { display:none; }
.review-page.active { display:grid; }
.review-card { transition:transform .25s ease,box-shadow .25s ease; }
.review-card:hover { transform:translateY(-6px);box-shadow:0 12px 32px rgba(0,0,0,.1); }

/* ══════════════════════════════════════════
   HOW IT WORKS — PROGRESS LINE
══════════════════════════════════════════ */
.step-card { transition:transform .25s ease,box-shadow .25s ease; }
.step-card:hover { transform:translateY(-6px) scale(1.02);box-shadow:0 12px 32px rgba(37,99,235,.1); }

/* ══════════════════════════════════════════
   CITY CHIP
══════════════════════════════════════════ */
.city-chip { transition:transform .2s cubic-bezier(.34,1.56,.64,1); }
.city-chip:hover { transform:scale(1.08) translateY(-1px); }

/* ══════════════════════════════════════════
   TAG CHIP HOVER
══════════════════════════════════════════ */
.tag-chip { transition:transform .2s cubic-bezier(.34,1.56,.64,1),background .2s,color .2s; }
.tag-chip:hover { transform:scale(1.08) translateY(-2px); background:#2563eb!important;color:white!important; }

/* ══════════════════════════════════════════
   FLOATING BADGE ANIMATION
══════════════════════════════════════════ */
.float-badge { animation:float-badge 3s ease-in-out infinite; }
@keyframes float-badge {
    0%,100% { transform:translateY(0); }
    50%      { transform:translateY(-6px); }
}

/* ══════════════════════════════════════════
   CONFETTI PIECE
══════════════════════════════════════════ */
.confetti-piece {
    position:absolute;width:8px;height:8px;border-radius:2px;
    animation:confetti-burst 1.2s ease-out forwards;
}
@keyframes confetti-burst {
    0%   { opacity:1; transform:translate(0,0) rotate(0deg) scale(1); }
    100% { opacity:0; }
}

/* ══════════════════════════════════════════
   GRID BACKGROUND
══════════════════════════════════════════ */
.bg-grid {
    background-image:linear-gradient(#2563eb 1px,transparent 1px),linear-gradient(90deg,#2563eb 1px,transparent 1px);
    background-size:60px 60px;
    opacity:.05;
}

/* ══════════════════════════════════════════
   PROGRESS BAR STEPS
══════════════════════════════════════════ */
.progress-line {
    background:linear-gradient(90deg,#2563eb,#7c3aed,#2563eb);
    background-size:200% 100%;
    animation:progress-shimmer 3s linear infinite;
}
@keyframes progress-shimmer { to { background-position:200% 0%; } }

/* ══════════════════════════════════════════
   NEWSLETTER-STYLE DARK CARD
══════════════════════════════════════════ */
.why-card-inner { animation:why-x 1.5s ease-in-out infinite; }
@keyframes why-x { 0%,100%{transform:translateX(0)} 50%{transform:translateX(2px)} }
</style>
 

 

{{-- ══════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════ --}}
<section class="relative pt-12 pb-20 overflow-hidden"
         style="background:linear-gradient(135deg,#f0f4ff 0%,#f8f6ff 40%,#eff9ff 100%);">

    {{-- Orbs & blobs --}}
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="blob w-64 h-64 bg-blue-300" style="top:5rem;right:5rem;"></div>
    <div class="blob w-48 h-48 bg-violet-300" style="bottom:5rem;left:2.5rem;animation-delay:4s;"></div>
    <div class="absolute inset-0 pointer-events-none bg-grid"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-14 items-start">

            {{-- ════════════════════════════════
                 LEFT COLUMN
            ════════════════════════════════ --}}
            <div class="pt-6 space-y-6">

                {{-- Badge --}}
                <div class="reveal inline-flex items-center gap-2 bg-white/80 backdrop-blur
                            border border-blue-100 text-blue-700 text-sm font-semibold
                            px-4 py-2 rounded-full shadow-sm">
                    ✨ Join 8,100+ Suppliers on QuickDials
                </div>

                {{-- Animated Title --}}
                <div class="reveal" style="transition-delay:.08s;">
                    <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold
                               text-slate-900 leading-tight mb-4 tracking-tight">
                        Grow <span class="gradient-text">Your</span> Business<br>
                        <span class="text-slate-700">With QuickDials</span>
                    </h1>
                    <p class="text-slate-500 text-base leading-relaxed max-w-lg">
                        India's fastest-growing B2B marketplace. List for free, or choose a
                        premium plan to unlock leads, visibility, and growth tools.
                    </p>
                </div>

                {{-- STATS GRID --}}
                <div class="reveal grid grid-cols-3 gap-3" style="transition-delay:.16s;">
                    @foreach($stats as $stat)
                    <div class="stat-card bg-white/80 backdrop-blur rounded-2xl p-3.5
                                border border-white shadow-sm text-center">
                        <div class="w-8 h-8 {{ $stat['bg'] }} rounded-lg flex items-center
                                    justify-center mx-auto mb-2">
                            @include('client.components.partials.biz-icon', ['icon' => $stat['icon'], 'color' => $stat['color']])


                        </div>
                        <div class="text-base font-extrabold text-slate-800 count-up-val"
                             data-target="{{ preg_replace('/[^0-9]/', '', $stat['value']) }}"
                             data-suffix="{{ preg_replace('/[0-9,]/', '', $stat['value']) }}">
                            {{ $stat['value'] }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium mt-0.5 leading-tight">
                            {{ $stat['label'] }}
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- BENEFITS --}}
                <div class="reveal space-y-2.5" style="transition-delay:.22s;">
                    @foreach($benefits as $b)
                    <div class="benefit-row flex items-center gap-3 bg-white/70 backdrop-blur
                                rounded-xl p-3.5 border {{ $b['border'] }}">
                        <div class="w-9 h-9 {{ $b['bg'] }} rounded-xl flex items-center
                                    justify-center flex-shrink-0">
                            @include('client.components.partials.biz-icon', ['icon' => $b['icon'], 'color' => $b['color']])
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-slate-700 text-sm">{{ $b['title'] }}</div>
                            <div class="text-xs text-slate-400">{{ $b['desc'] }}</div>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 flex-shrink-0" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    @endforeach
                </div>

                {{-- SUCCESS STORY SLIDER --}}
                <div class="reveal" style="transition-delay:.28s;">
                    <div id="story-slider" class="relative rounded-2xl overflow-hidden"
                         data-stories="{{ json_encode($successStories) }}">
                        {{-- Rendered by JS --}}
                        <div class="bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-700
                                    rounded-2xl p-5 min-h-[200px] flex items-center justify-center">
                            <div class="text-white/40 text-sm">Loading stories…</div>
                        </div>
                    </div>
                </div>

                {{-- CITIES --}}
                <div class="reveal bg-white/70 backdrop-blur rounded-2xl border border-white
                            shadow-sm p-4" style="transition-delay:.34s;">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Cities We Cover</span>
                        </div>
                        <span class="text-[10px] text-blue-500 font-medium">500+ cities</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach([['Mumbai','1.2K'],['Delhi','1.1K'],['Bangalore','980'],['Hyderabad','870'],['Ahmedabad','760'],['Chennai','720'],['Pune','680'],['Surat','540'],['Jaipur','460'],['Kolkata','420'],['Lucknow','390']] as $i => $city)
                        <span class="city-chip inline-flex items-center gap-1 text-[10px] font-semibold
                                     px-2.5 py-1 rounded-full border cursor-default
                                     bg-blue-50 text-blue-600 border-blue-100 hover:bg-blue-100">
                            {{ $city[0] }} <span class="text-[8px] opacity-60">{{ $city[1] }}</span>
                        </span>
                        @endforeach
                        <span class="city-chip inline-flex items-center text-[10px] font-semibold
                                     px-2.5 py-1 rounded-full border cursor-default
                                     bg-slate-100 text-slate-500 border-slate-200">+ 489 more</span>
                    </div>
                </div>

                {{-- TRUSTED BY --}}
                <div class="reveal bg-white/70 backdrop-blur rounded-2xl border border-white
                            shadow-sm p-4" style="transition-delay:.40s;">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-center">
                        Trusted by businesses across India
                    </div>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach([['TS','TataSteel','bg-blue-100 text-blue-700'],['RI','Reliance','bg-red-100 text-red-700'],['IN','Infosys','bg-indigo-100 text-indigo-700'],['MH','Mahindra','bg-orange-100 text-orange-700'],['WI','Wipro','bg-violet-100 text-violet-700'],['HC','HCL','bg-emerald-100 text-emerald-700'],['HD','HDFC','bg-rose-100 text-rose-700'],['GR','Godrej','bg-teal-100 text-teal-700']] as $brand)
                        <div class="flex flex-col items-center gap-1 p-2 rounded-xl cursor-default
                                    transition-all hover:scale-105 hover:-translate-y-0.5 {{ $brand[2] }}">
                            <div class="text-sm font-extrabold">{{ $brand[0] }}</div>
                            <div class="text-[8px] font-semibold opacity-70 leading-tight text-center">{{ $brand[1] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- ── END LEFT COLUMN ── --}}

            {{-- ════════════════════════════════
                 RIGHT COLUMN — FORM
            ════════════════════════════════ --}}
            <div class="relative flex flex-col gap-5" id="enquiry">

                {{-- Floating badge --}}
                <div class="float-badge absolute -top-4 -right-4 z-20 bg-white rounded-2xl
                            px-4 py-2.5 shadow-xl border border-slate-100
                            flex items-center gap-2.5">
                    <div class="flex -space-x-1.5">
                        @foreach(['bg-blue-400','bg-emerald-400','bg-violet-400','bg-amber-400'] as $c)
                        <div class="w-6 h-6 rounded-full {{ $c }} border-2 border-white"></div>
                        @endforeach
                    </div>
                    <div class="text-xs">
                        <div class="font-bold text-slate-800">8,100+</div>
                        <div class="text-slate-400">active sellers</div>
                    </div>
                </div>

                {{-- GLOW CARD FORM --}}
                <div class="glow-card-wrap">
                    <div class="glow-border"></div>
                    <div class="glow-card-inner shadow-2xl">

                        {{-- Card header --}}
                        <div class="relative bg-gradient-to-br from-blue-600 via-indigo-600
                                    to-violet-700 p-5 overflow-hidden">
                            <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>
                            <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-white/10 rounded-full"></div>
                            <div class="form-header-shimmer"></div>
                            <div class="relative flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl
                                            flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">List Your Business</h2>
                                    <p class="text-blue-200 text-xs">Free forever · Upgrade anytime</p>
                                </div>
                                <div class="ml-auto animate-spin" style="animation-duration:20s;">
                                    <svg class="w-5 h-5 text-amber-300 opacity-60" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.09 6.26L20 9l-5 3.64 1.91 6.36L12 15.27l-4.91 3.73L9 12.64 4 9l5.91-.74L12 2z"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- FORM --}}
                        <div class="p-5">
                            {{-- FORM STATE --}}
                            <form id="biz-form" class="space-y-3" novalidate>
                                @csrf

                                {{-- Business Name --}}
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">
                                        Business / Company Name
                                    </label>
                                    <div class="relative">
                                        <svg class="field-icon absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                                        <input name="businessName" type="text" placeholder="e.g. Sharma Enterprises"
                                               class="form-input" required minlength="2" />
                                    </div>
                                    <p class="field-error text-red-500 text-[10px] mt-0.5 hidden"></p>
                                </div>

                                {{-- Email + Phone --}}
                                <div class="grid grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                                        <div class="relative">
                                            <svg class="field-icon absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                            <input name="email" type="email" placeholder="Enter Email"
                                                   class="form-input" required />
                                        </div>
                                        <p class="field-error text-red-500 text-[10px] mt-0.5 hidden"></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Phone</label>
                                        <div class="relative">
                                            <svg class="field-icon absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.63A2 2 0 012 .9h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.09a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 15z"/></svg>
                                            <input name="phone" type="tel" placeholder="+91 98765 43210"
                                                   class="form-input" required minlength="10" />
                                        </div>
                                        <p class="field-error text-red-500 text-[10px] mt-0.5 hidden"></p>
                                    </div>
                                </div>

                                {{-- City + Category --}}
                                <div class="grid grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">City</label>
                                        <div class="relative">
                                            <svg class="field-icon absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                            <input name="city" type="text" placeholder="Mumbai"
                                                   class="form-input" required minlength="2" />
                                        </div>
                                        <p class="field-error text-red-500 text-[10px] mt-0.5 hidden"></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Category</label>
                                        <select name="businessCategory" class="form-input" required>
                                            <option value="">Select…</option>
                                            @foreach($categories as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                        <p class="field-error text-red-500 text-[10px] mt-0.5 hidden"></p>
                                    </div>
                                </div>

                                {{-- Package --}}
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                                        Interested Package
                                    </label>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($packages as $pkg)
                                        <div class="pkg-card relative rounded-xl p-2.5 border-2 border-slate-200
                                                    bg-white text-center"
                                             data-pkg="{{ $pkg['id'] }}"
                                             onclick="selectPkg(this,'{{ $pkg['id'] }}')">
                                            @if($pkg['badge'])
                                            <div class="absolute -top-2 left-1/2 -translate-x-1/2 text-[9px]
                                                        font-bold text-white px-2 py-0.5 rounded-full whitespace-nowrap
                                                        {{ $pkg['id'] === 'growth' ? 'bg-blue-500' : 'bg-violet-500' }}">
                                                {{ $pkg['badge'] }}
                                            </div>
                                            @endif
                                            <div class="text-lg mb-1">
                                                {{ $pkg['icon'] === 'globe' ? '🌐' : ($pkg['icon'] === 'trending' ? '📈' : '✨') }}
                                            </div>
                                            <div class="text-[10px] font-semibold text-slate-700 leading-tight">
                                                {{ $pkg['name'] }}
                                            </div>
                                            <div class="pkg-check absolute top-1 right-1 hidden">
                                                <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="packageInterest" id="pkg-hidden" required />
                                    <p id="pkg-error" class="text-red-500 text-[10px] mt-1 hidden">Please select a package</p>
                                </div>

                                {{-- Submit --}}
                                <button type="submit" id="submit-btn"
                                        class="submit-btn w-full py-3 mt-1 text-white font-bold
                                               rounded-xl text-sm flex items-center justify-center gap-2">
                                    <span id="btn-idle" class="flex items-center gap-2">
                                        🚀 Start Your Business Free
                                        <svg class="w-4 h-4 btn-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </span>
                                    <span id="btn-loading" class="hidden flex items-center gap-2">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"/><path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8V0C5.37 0 0 5.37 0 12h4z"/></svg>
                                        Registering your business…
                                    </span>
                                </button>

                                <div class="flex items-center justify-center gap-5 pt-1">
                                    @foreach([['🔒','100% Secure'],['⚡','2 min setup'],['⭐','4.8★ rated']] as $trust)
                                    <div class="flex items-center gap-1 text-[10px] text-slate-400 font-medium">
                                        {{ $trust[0] }} {{ $trust[1] }}
                                    </div>
                                    @endforeach
                                </div>
                            </form>

                            {{-- SUCCESS STATE --}}
                            <div id="form-success" class="hidden relative py-6 text-center flex-col items-center">
                                <div id="confetti-container" class="absolute inset-0 overflow-hidden pointer-events-none"></div>
                                <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-500
                                            rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </div>
                                <h3 class="text-xl font-extrabold text-slate-800 mb-2">You're All Set!</h3>
                                <p class="text-slate-500 text-sm mb-5">Our team will contact you within 24 hours to activate your listing.</p>
                                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100
                                            rounded-xl p-3.5 text-sm text-emerald-700 font-medium">
                                    Package selected: <span id="success-pkg" class="font-bold"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- LIVE ACTIVITY FEED --}}
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white shadow-sm overflow-hidden">
                    <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100">
                        <div class="live-dot w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Live Activity</span>
                        <span class="ml-auto text-[10px] text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full border border-slate-100">Real-time</span>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach([
                            ['PF','Priya Fashion House','Surat','Growth','2 min ago','from-pink-400 to-rose-500'],
                            ['TV','TechVision Solutions','Bangalore','Premium','11 min ago','from-blue-400 to-indigo-500'],
                            ['ME','Mehta Electronics','Ahmedabad','Starter','23 min ago','from-amber-400 to-orange-500'],
                            ['GL','GreenLeaf Organics','Pune','Growth','38 min ago','from-emerald-400 to-teal-500'],
                        ] as $item)
                        <div class="flex items-center gap-3 px-4 py-3 transition-all cursor-default
                                    hover:bg-blue-50/80 hover:translate-x-0.5">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br {{ $item[5] }}
                                        flex items-center justify-center text-white text-[10px]
                                        font-extrabold flex-shrink-0">
                                {{ $item[0] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold text-slate-700 truncate">{{ $item[1] }}</div>
                                <div class="text-[10px] text-slate-400">{{ $item[2] }}</div>
                            </div>
                            <div class="flex flex-col items-end gap-0.5">
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full
                                    {{ $item[3] === 'Premium' ? 'bg-violet-50 text-violet-600 border border-violet-100'
                                     : ($item[3] === 'Growth' ? 'bg-blue-50 text-blue-600 border border-blue-100'
                                     : 'bg-slate-50 text-slate-500 border border-slate-100') }}">
                                    {{ $item[3] }}
                                </span>
                                <span class="text-[9px] text-slate-300">{{ $item[4] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- POPULAR CATEGORIES --}}
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Top Categories</span>
                        <span class="text-[10px] text-blue-500 font-medium">View all</span>
                    </div>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach([
                            ['Retail','🛍️','bg-blue-50 text-blue-600','2.3K'],['Food','🍜','bg-orange-50 text-orange-500','1.8K'],
                            ['Health','🏥','bg-emerald-50 text-emerald-500','1.4K'],['Tech','⚡','bg-violet-50 text-violet-500','1.1K'],
                            ['Realty','🏠','bg-rose-50 text-rose-500','980'],['Auto','🚗','bg-cyan-50 text-cyan-500','860'],
                            ['Beauty','💅','bg-pink-50 text-pink-500','740'],['Finance','💰','bg-teal-50 text-teal-500','620'],
                        ] as $cat)
                        <div class="flex flex-col items-center gap-1 p-2.5 rounded-xl border
                                    border-slate-100 bg-white hover:shadow-sm transition-all
                                    cursor-default hover:-translate-y-0.5 hover:scale-105">
                            <div class="w-8 h-8 {{ $cat[2] }} rounded-lg flex items-center justify-center text-lg">
                                {{ $cat[1] }}
                            </div>
                            <span class="text-[9px] font-semibold text-slate-600 leading-tight">{{ $cat[0] }}</span>
                            <span class="text-[8px] text-slate-400">{{ $cat[3] }}+</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- WHY QUICKDIALS DARK CARD --}}
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-4 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-20"
                         style="background:radial-gradient(circle at 80% 20%,#3b82f6 0%,transparent 50%)"></div>
                    <div class="relative">
                        <div class="text-xs font-bold text-slate-300 uppercase tracking-wide mb-3">Why QuickDials?</div>
                        <div class="space-y-2.5">
                            @foreach([
                                ['Avg. lead increase','10x','within first 30 days','📈','text-emerald-400'],
                                ['Business response rate','94%','buyers contact listed sellers','👥','text-blue-400'],
                                ['Setup time','< 2 min','from signup to going live','⏱️','text-amber-400'],
                            ] as $wi)
                            <div class="flex items-center gap-3 bg-white/5 rounded-xl px-3 py-2.5">
                                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0 text-base">
                                    {{ $wi[3] }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[10px] text-slate-400 leading-tight">{{ $wi[0] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $wi[2] }}</div>
                                </div>
                                <div class="text-base font-extrabold {{ $wi[4] }} flex-shrink-0">{{ $wi[1] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            {{-- ── END RIGHT COLUMN ── --}}
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════════════════ --}}
<section class="py-12 relative overflow-hidden"
         style="background:linear-gradient(135deg,#eef2ff 0%,#f0f9ff 50%,#faf5ff 100%);">
    <div class="absolute inset-0 pointer-events-none opacity-40"
         style="background:radial-gradient(circle at 20% 50%,#bfdbfe 0%,transparent 40%),radial-gradient(circle at 80% 50%,#ddd6fe 0%,transparent 40%)"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-10">
            <div class="reveal">
                <div class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1">How It Works</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    Get Live in <span class="gradient-text">4 Steps</span>
                </h2>
            </div>
            <div class="reveal inline-flex items-center gap-2 bg-white/80 backdrop-blur
                        border border-emerald-100 text-emerald-600 text-xs font-bold
                        px-4 py-2 rounded-full shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 live-dot"></span>
                Under 10 minutes — start to live
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 relative">
            {{-- Progress line --}}
            <div class="hidden lg:block absolute top-7 left-[12%] right-[12%] h-0.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="progress-line h-full rounded-full w-full"></div>
            </div>

            @foreach([
                ['01','Register','Fill the quick form in under 60 seconds','💬','from-blue-500 to-blue-600','bg-blue-50','~60 sec'],
                ['02','Verify','Our team calls to confirm your details','✅','from-violet-500 to-purple-600','bg-violet-50','~2 min'],
                ['03','Go Live','Your listing reaches thousands of buyers','🚀','from-indigo-500 to-blue-600','bg-indigo-50','~3 min'],
                ['04','Grow','Receive leads & manage via your dashboard','📈','from-emerald-500 to-teal-600','bg-emerald-50','Ongoing'],
            ] as $i => $step)
            <div class="step-card reveal relative bg-white/80 backdrop-blur rounded-2xl p-5
                        border border-white shadow-sm hover:border-blue-100 cursor-default"
                 style="transition-delay:{{ $i * 0.12 }}s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $step[4] }}
                                flex items-center justify-center shadow-lg text-xl">
                        {{ $step[3] }}
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-black gradient-text leading-none">{{ $step[0] }}</div>
                        <div class="text-[9px] font-bold px-2 py-0.5 rounded-full mt-0.5 {{ $step[5] }} text-slate-600">
                            {{ $step[6] }}
                        </div>
                    </div>
                </div>
                <h3 class="font-extrabold text-slate-800 text-sm mb-1">{{ $step[1] }}</h3>
                <p class="text-[11px] text-slate-400 leading-relaxed">{{ $step[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     FEATURES
══════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="reveal text-3xl font-bold mb-2">Powerful Features for Your Business</h2>
        <p class="reveal text-gray-500 mb-10">Discover how Quick Dials can transform your workforce management</p>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($features as $i => $feat)
            <div class="reveal bg-white rounded-2xl p-6 shadow-md hover:shadow-xl
                        transition-all duration-300 hover:scale-105 cursor-default"
                 style="transition-delay:{{ $i * 0.1 }}s;">
                <div class="text-4xl mb-4">{{ $feat['icon'] }}</div>
                <h3 class="font-semibold text-lg mb-2">{{ $feat['title'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $feat['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     GROW SECTION
══════════════════════════════════════════════════ --}}
<section class="bg-gray-100">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-10 text-center">
        <h2 class="reveal text-2xl md:text-3xl font-bold">
            How Quick Dials help You to Grow your Business
        </h2>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-10">
        <div class="reveal">
            <h3 class="text-xl font-semibold mb-3">How Quick Dials help You to Grow your Business?</h3>
            <p class="text-gray-600 mb-4">Quick Dials helps grow your business by boosting local visibility, generating quality leads, and connecting you with customers searching for your services.</p>
            <h4 class="font-semibold mb-2">What is Quick Dials?</h4>
            <p class="text-gray-600 mb-4">A platform designed for students, parents, and professionals seeking reliable information across India's diverse education and industrial sectors.</p>
            <ul class="space-y-2">
                @foreach(['Education: Schools, coaching centers, institutions','Manufacturing: Automotive, pharma, textiles','Service Industries: IT, finance, tourism, healthcare','Core Sectors: Electricity, steel, refinery, cement'] as $item)
                <li class="flex items-start gap-2 text-gray-700">
                    <span class="text-blue-600">✔</span> {{ $item }}
                </li>
                @endforeach
            </ul>
            <h4 class="font-semibold mt-6 mb-2">Benefits after associating with us:</h4>
            <ul class="space-y-2">
                @foreach(['Lead replacement policy if not relevant','Refund policy if we fail to deliver','End-to-end support','Leads shared via SMS & Email'] as $item)
                <li class="flex items-start gap-2 text-gray-700">
                    <span class="text-green-600">✔</span> {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
        <div class="reveal" style="transition-delay:.2s;">
            <h3 class="text-xl font-semibold mb-3">Why choose Quick Dials for growing your business?</h3>
            <ul class="space-y-2 mb-6">
                @foreach(['Unique work module different from others','Conversion-focused system','Manually verified leads','Organic + inorganic lead generation','Strong channel partnerships','Double verified leads by experts'] as $item)
                <li class="flex items-start gap-2 text-gray-700">
                    <span class="text-purple-600">✔</span> {{ $item }}
                </li>
                @endforeach
            </ul>
            <h3 class="text-xl font-semibold mb-2">Contact Us:</h3>
            <p class="text-gray-600">
                📞 +91-75-5943-5943<br>
                📧 info@quickdials.com<br>
                🌐 www.quickdials.com
            </p>
            <a href="#enquiry"
               class="inline-block mt-5 bg-blue-600 text-white px-6 py-2 rounded-lg
                      shadow hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all">
                Get Started
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     TESTIMONIALS / REVIEW SLIDER
══════════════════════════════════════════════════ --}}
<section class="py-16 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal text-center mb-10">
            <div class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-2">What They Say</div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">
                Businesses <span class="gradient-text">Love Us</span>
            </h2>
            <p class="text-slate-500 text-sm">Real stories from real business owners across India</p>
        </div>

        {{-- Review Slider --}}
        <div id="review-slider" data-reviews="{{ json_encode($reviewList) }}">
            {{-- Skeleton while JS boots --}}
            <div class="grid sm:grid-cols-3 gap-4">
                @foreach([1,2,3] as $s)
                <div class="bg-white rounded-2xl p-5 shadow border h-40 animate-pulse"></div>
                @endforeach
            </div>
        </div>

        {{-- CTA Banner --}}
        <div class="reveal mt-12">
            <div class="relative rounded-3xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 p-10 text-center relative">
                    <div class="absolute inset-0 opacity-10 pointer-events-none"
                         style="background:radial-gradient(circle at 20% 50%,white 0%,transparent 40%),radial-gradient(circle at 80% 50%,white 0%,transparent 40%)"></div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">
                        Ready to Grow Your Business?
                    </h3>
                    <p class="text-blue-100 mb-7">Join 8,100+ suppliers already thriving on QuickDials</p>
                    <a href="#enquiry"
                       class="inline-flex items-center gap-3 bg-white text-blue-700 font-extrabold
                              px-8 py-4 rounded-2xl shadow-2xl hover:shadow-blue-900/30
                              hover:scale-105 hover:-translate-y-0.5 active:scale-95 transition-all text-base">
                        🏢 List Your Business Free
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════
     FAQ
══════════════════════════════════════════════════ --}}
@if(count($faqs))
<section class="py-20 relative overflow-hidden"
         style="background:linear-gradient(160deg,#f8faff 0%,#f0f4ff 45%,#f5f0ff 100%);">
    <div class="absolute inset-0 pointer-events-none opacity-35"
         style="background-image:linear-gradient(#c7d7f8 1px,transparent 1px),linear-gradient(90deg,#c7d7f8 1px,transparent 1px);background-size:64px 64px;"></div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal text-center mb-12">
            <div class="inline-flex items-center gap-2 border rounded-full px-4 py-1.5 mb-5"
                 style="background:rgba(59,130,246,.08);border-color:rgba(59,130,246,.2);">
                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 live-dot"></div>
                <span class="text-blue-600 text-xs font-semibold tracking-widest uppercase">Got Questions?</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">
                Frequently Asked <span class="gradient-text">Questions</span>
            </h2>
            <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                Everything you need to know about listing your business on QuickDials.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-8 mt-8">
                @foreach([['< 2 hrs','Avg. response time'],['4.9 ★','Support rating'],['8,100+','Businesses listed']] as $fs)
                <div class="flex items-center gap-2.5">
                    <span class="text-lg font-extrabold text-blue-600">{{ $fs[0] }}</span>
                    <span class="text-slate-400 text-xs leading-tight">{{ $fs[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3" id="faq-grid">
            @foreach($faqs as $i => $faq)
            <div class="faq-item reveal relative rounded-2xl border border-slate-200 bg-white/80
                        overflow-hidden transition-all duration-300 hover:border-blue-200 hover:shadow-md"
                 style="transition-delay:{{ $i * 0.05 }}s;">
                <div class="faq-bar"></div>
                <button class="faq-trigger w-full flex items-center gap-3.5 px-5 py-4 text-left group">
                    <div class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center
                                flex-shrink-0 group-hover:bg-blue-50 transition-all">
                        <span class="text-slate-400 group-hover:text-blue-500 font-bold text-sm">
                            {{ $i + 1 }}
                        </span>
                    </div>
                    <span class="flex-1 min-w-0 text-sm font-semibold text-slate-700
                                 group-hover:text-slate-900 leading-snug">
                        {{ $faq['q'] }}
                    </span>
                    <svg class="faq-chevron w-3.5 h-3.5 text-slate-400 flex-shrink-0"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="faq-body">
                    <div class="px-5 pb-5 pl-16 text-sm text-slate-500 leading-relaxed
                                border-t border-slate-100 pt-3">
                        {{ $faq['a'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="reveal mt-10 flex justify-center">
            <div class="flex flex-col sm:flex-row items-center gap-5 rounded-2xl px-7 py-5
                        border border-indigo-100 backdrop-blur-sm bg-white/70 shadow-sm">
                <div class="text-center sm:text-left">
                    <div class="text-slate-800 font-semibold text-sm">Still have questions?</div>
                    <div class="text-slate-400 text-xs mt-0.5">Our team typically responds in under 2 hours</div>
                </div>
                <a href="#enquiry"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600
                          text-white text-sm font-semibold px-5 py-2.5 rounded-xl
                          hover:scale-105 hover:-translate-y-0.5 active:scale-95 transition-all
                          whitespace-nowrap shadow-lg shadow-indigo-300/40">
                    💬 Talk to us
                </a>
            </div>
        </div>
    </div>
</section>
@endif
 
<script>
(function () {
    /* ══════════════════════════════════════════
       REVEAL ON SCROLL
    ══════════════════════════════════════════ */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal,.reveal-left')
            .forEach(el => observer.observe(el));

    /* ══════════════════════════════════════════
       COUNT-UP ANIMATION
    ══════════════════════════════════════════ */
    document.querySelectorAll('.count-up-val').forEach(el => {
        const end    = parseInt(el.dataset.target) || 0;
        const suffix = el.dataset.suffix || '';
        const dur    = 2000;
        let started  = false;

        const cuObs = new IntersectionObserver(([entry]) => {
            if (entry.isIntersecting && !started) {
                started = true;
                let t0 = null;
                const tick = (ts) => {
                    if (!t0) t0 = ts;
                    const p = Math.min((ts - t0) / dur, 1);
                    const val = Math.floor((1 - Math.pow(1 - p, 3)) * end);
                    el.textContent = val.toLocaleString() + suffix;
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
                cuObs.disconnect();
            }
        }, { threshold: 0.5 });
        cuObs.observe(el);
    });

    /* ══════════════════════════════════════════
       SUCCESS STORY SLIDER
    ══════════════════════════════════════════ */
    const sliderEl = document.getElementById('story-slider');
    if (sliderEl) {
        const stories = JSON.parse(sliderEl.dataset.stories || '[]');
        let idx = 0, timer = null, paused = false;

        const render = () => {
            if (!stories.length) return;
            const s = stories[idx];
            const dots = stories.map((_, i) =>
                `<button onclick="storyGo(${i})" class="rounded-full transition-all duration-300 ${
                    i === idx ? 'w-4 h-1.5 bg-white' : 'w-1.5 h-1.5 bg-white/30 hover:bg-white/60'
                }"></button>`
            ).join('');
            const metrics = s.metrics.map(m =>
                `<div class="bg-white/10 rounded-xl p-2.5 text-center">
                    <div class="text-white font-extrabold text-base">${m.value}</div>
                    <div class="text-white/60 text-[9px] leading-tight mt-0.5">${m.label}</div>
                </div>`
            ).join('');
            sliderEl.innerHTML = `
            <div class="relative bg-gradient-to-br ${s.grad} rounded-2xl overflow-hidden p-5">
                <div class="absolute inset-0 opacity-20" style="background:radial-gradient(circle at 10% 90%,#fff 0%,transparent 50%)"></div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-white/70 animate-pulse"></div>
                            <span class="text-[10px] font-bold text-white/70 uppercase tracking-widest">Success Story</span>
                        </div>
                        <div class="flex items-center gap-1.5">${dots}</div>
                    </div>
                    <div class="flex items-start gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-extrabold text-sm flex-shrink-0">${s.initials}</div>
                        <div class="flex-1 min-w-0">
                            <div class="text-white font-bold text-sm leading-tight">${s.name}</div>
                            <div class="text-white/60 text-[11px]">${s.category} · ${s.city}</div>
                        </div>
                        <div class="text-amber-300 flex-shrink-0">★★★★★</div>
                    </div>
                    <p class="text-white/80 text-xs leading-relaxed mb-4 italic">"${s.quote}"</p>
                    <div class="grid grid-cols-3 gap-2">${metrics}</div>
                </div>
                <button onclick="storyGo(${(idx - 1 + stories.length) % stories.length})"
                        class="absolute left-2 top-1/2 -translate-y-1/2 w-6 h-6 bg-white/10
                               hover:bg-white/25 rounded-full flex items-center justify-center">
                    ‹
                </button>
                <button onclick="storyGo(${(idx + 1) % stories.length})"
                        class="absolute right-2 top-1/2 -translate-y-1/2 w-6 h-6 bg-white/10
                               hover:bg-white/25 rounded-full flex items-center justify-center">
                    ›
                </button>
            </div>`;

            sliderEl.addEventListener('mouseenter', () => { paused = true; clearInterval(timer); });
            sliderEl.addEventListener('mouseleave', () => { paused = false; startTimer(); });
        };

        window.storyGo = (i) => { idx = ((i % stories.length) + stories.length) % stories.length; render(); };
        const startTimer = () => {
            clearInterval(timer);
            timer = setInterval(() => { if (!paused && stories.length > 1) { idx = (idx + 1) % stories.length; render(); } }, 3800);
        };
        render();
        startTimer();
    }

    /* ══════════════════════════════════════════
       REVIEW SLIDER
    ══════════════════════════════════════════ */
    const reviewSliderEl = document.getElementById('review-slider');
    if (reviewSliderEl) {
        const rawReviews = JSON.parse(reviewSliderEl.dataset.reviews || '[]');
        const colors = ['from-blue-400 to-indigo-500','from-pink-400 to-rose-500','from-emerald-400 to-teal-500','from-amber-400 to-orange-500'];

        const reviews = rawReviews.map((r, i) => ({
            name: r.comment_author || 'Anonymous',
            biz:  r.business_name  || '',
            initials: (r.comment_author || 'AN').trim().split(/\s+/).slice(0,2).map(w => w[0]).join('').toUpperCase(),
            color: colors[i % colors.length],
            stars: Math.min(Math.round((Number(r.rating) || 10) / 2), 5),
            text:  r.comment_content || 'Great service!',
            tag:   r.client_type    || 'Verified',
        }));

        const PER_PAGE = 3;
        const totalPages = Math.max(1, Math.ceil(reviews.length / PER_PAGE));
        let page = 0, rTimer, rPaused = false;

        const renderReviews = () => {
            const current = reviews.slice(page * PER_PAGE, (page + 1) * PER_PAGE);
            const fallback = [
                { name:'Ramesh K.', biz:'Auto Parts', initials:'RK', color:colors[0], stars:5, text:'Best platform for B2B leads in India!', tag:'Verified' },
                { name:'Priya S.', biz:'Textiles',    initials:'PS', color:colors[1], stars:5, text:'Revenue doubled in 3 months. Highly recommend.', tag:'Premium' },
                { name:'Ankit M.', biz:'Electronics', initials:'AM', color:colors[2], stars:5, text:'Got 40+ inquiries in the first week!', tag:'Growth' },
            ];
            const toRender = current.length ? current : fallback;

            reviewSliderEl.innerHTML = `
            <div class="relative">
                <div class="grid sm:grid-cols-3 gap-4">
                    ${toRender.map(r => `
                    <div class="review-card bg-white rounded-2xl p-5 shadow border hover:shadow-lg transition">
                        <div class="flex justify-between mb-2">
                            <div class="flex">${'★'.repeat(r.stars)}<span class="text-yellow-400">${'☆'.repeat(5-r.stars)}</span></div>
                            <span class="text-xs text-blue-600">${r.tag}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3 italic">"${r.text}"</p>
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-r ${r.color} flex items-center justify-center text-white text-xs font-bold">${r.initials}</div>
                            <div>
                                <div class="text-sm font-semibold">${r.name}</div>
                                <div class="text-xs text-gray-400">${r.biz}</div>
                            </div>
                        </div>
                    </div>`).join('')}
                </div>
                <button onclick="revGo(${page-1})" class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-blue-50">◀</button>
                <button onclick="revGo(${page+1})" class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-blue-50">▶</button>
            </div>
            <div class="flex justify-center mt-4 gap-2">
                ${Array.from({length:totalPages}).map((_,i)=>`
                <button onclick="revGo(${i})" class="w-2 h-2 rounded-full ${i===page?'bg-blue-500':'bg-gray-300'}"></button>`).join('')}
            </div>`;
        };

        window.revGo = (i) => {
            page = ((i % totalPages) + totalPages) % totalPages;
            renderReviews();
        };
        const startRevTimer = () => {
            clearInterval(rTimer);
            if (totalPages > 1) rTimer = setInterval(() => { if (!rPaused) { page = (page+1)%totalPages; renderReviews(); }}, 4500);
        };
        renderReviews();
        startRevTimer();

        reviewSliderEl.addEventListener('mouseenter', () => { rPaused = true; });
        reviewSliderEl.addEventListener('mouseleave', () => { rPaused = false; });
    }

    /* ══════════════════════════════════════════
       PACKAGE SELECTOR
    ══════════════════════════════════════════ */
    let selectedPkg = null;

    window.selectPkg = (el, id) => {
        selectedPkg = id;
        document.getElementById('pkg-hidden').value = id;
        document.getElementById('pkg-error').classList.add('hidden');

        document.querySelectorAll('.pkg-card').forEach(c => {
            c.classList.remove('selected-starter','selected-growth','selected-premium');
            c.querySelector('.pkg-check')?.classList.add('hidden');
        });
        el.classList.add(`selected-${id}`);
        el.querySelector('.pkg-check')?.classList.remove('hidden');
    };

    /* ══════════════════════════════════════════
       FORM VALIDATION & SUBMIT
    ══════════════════════════════════════════ */
    const form = document.getElementById('biz-form');
    if (form) {
        form.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.querySelectorAll('.field-icon').forEach(ic => ic.classList.replace('text-slate-400','text-blue-500'));
            });
            input.addEventListener('blur', () => {
                input.parentElement.querySelectorAll('.field-icon').forEach(ic => ic.classList.replace('text-blue-500','text-slate-400'));
            });
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            let valid = true;

            form.querySelectorAll('[required]').forEach(field => {
                const wrap = field.closest('div');
                const err  = wrap?.querySelector('.field-error');
                const val  = field.value.trim();
                if (!val || (field.type === 'email' && !/\S+@\S+\.\S+/.test(val)) || (field.minLength && val.length < field.minLength)) {
                    valid = false;
                    if (err) { err.textContent = field.type === 'email' ? 'Enter a valid email' : field.name === 'phone' ? 'Enter a valid phone number' : `${field.name} is required`; err.classList.remove('hidden'); }
                } else {
                    err?.classList.add('hidden');
                }
            });

            if (!selectedPkg) {
                valid = false;
                document.getElementById('pkg-error').classList.remove('hidden');
            }

            if (!valid) return;

            const btn = document.getElementById('submit-btn');
            document.getElementById('btn-idle').classList.add('hidden');
            document.getElementById('btn-loading').classList.remove('hidden');
            btn.disabled = true;

            try {
                const fd = new FormData(form);
                fd.append('packageInterest', selectedPkg);
                await fetch('{{ route("business-owners.submit") }}', { method:'POST', body:fd, headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'} });
            } catch (_) {}

            await new Promise(r => setTimeout(r, 1800));

            // Show success
            form.classList.add('hidden');
            const successEl = document.getElementById('form-success');
            successEl.classList.remove('hidden');
            successEl.classList.add('show');
            document.getElementById('success-pkg').textContent = selectedPkg;

            // Confetti
            const container = document.getElementById('confetti-container');
            const colors = ['#2563eb','#7c3aed','#06b6d4','#10b981','#f59e0b','#ef4444'];
            for (let i = 0; i < 30; i++) {
                const piece = document.createElement('div');
                piece.className = 'confetti-piece';
                piece.style.cssText = `
                    background:${colors[i%6]};
                    left:50%;top:50%;
                    animation-duration:${0.8+Math.random()*0.6}s;
                `;
                piece.style.setProperty('--tx', `${(Math.random()-0.5)*300}px`);
                piece.style.setProperty('--ty', `${(Math.random()-0.5)*300}px`);
                piece.style.setProperty('--r',  `${Math.random()*720}deg`);
                container.appendChild(piece);
                setTimeout(() => piece.remove(), 1500);
            }
        });
    }

    /* ══════════════════════════════════════════
       FAQ ACCORDION
    ══════════════════════════════════════════ */
    document.querySelectorAll('.faq-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.faq-item');
            const body = item.querySelector('.faq-body');
            const isOpen = item.classList.contains('open');

            document.querySelectorAll('.faq-item').forEach(i => {
                i.classList.remove('open');
                i.querySelector('.faq-body').classList.remove('open');
                i.style.borderColor = '';
                i.style.background  = '';
            });

            if (!isOpen) {
                item.classList.add('open');
                body.classList.add('open');
                item.style.borderColor = '#bfdbfe';
                item.style.background  = 'linear-gradient(to bottom right,#eff6ff,#eef2ff)';
            }
        });
    });

})();
</script>

<style>
/* Confetti uses CSS custom properties set via JS */
.confetti-piece {
    animation-name: confetti-burst !important;
    transform-origin: center;
}
@keyframes confetti-burst {
    0%   { opacity:1; transform:translate(0,0) rotate(0deg) scale(1); }
    100% { opacity:0; transform:translate(var(--tx),var(--ty)) rotate(var(--r)) scale(var(--s,.6)); }
}
</style>
 



@endsection

