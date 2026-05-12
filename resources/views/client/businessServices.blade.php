@extends('client.layouts.app')
@section('title')
Quick Dials- Business Services
@endsection 
@section('keyword')
Quick Dials-  Business Services list 
@endsection
@section('description'),  
Quick Dials- Business Services POPULAR CATEGORIES, B2B & BUSINESS SERVICES
@endsection
@section('content')	
@include('client.components.banner-section')
<style>
/* ══════════════════════════════════════════
   COLOUR MAP  (mirrors JS COLOR object)
══════════════════════════════════════════ */
/* stored as CSS custom-property groups — used by utility classes below */
.cs-blue   { --bg:#eff6ff; --text:#1d4ed8; --border:#bfdbfe; --dot:#3b82f6; --head:#2563eb; }
.cs-indigo { --bg:#eef2ff; --text:#4338ca; --border:#c7d2fe; --dot:#6366f1; --head:#4f46e5; }
.cs-green  { --bg:#ecfdf5; --text:#065f46; --border:#a7f3d0; --dot:#10b981; --head:#059669; }
.cs-orange { --bg:#fff7ed; --text:#c2410c; --border:#fed7aa; --dot:#f97316; --head:#ea580c; }
.cs-amber  { --bg:#fffbeb; --text:#92400e; --border:#fde68a; --dot:#f59e0b; --head:#d97706; }
.cs-teal   { --bg:#f0fdfa; --text:#134e4a; --border:#99f6e4; --dot:#14b8a6; --head:#0f766e; }
.cs-pink   { --bg:#fdf2f8; --text:#9d174d; --border:#fbcfe8; --dot:#ec4899; --head:#db2777; }
.cs-purple { --bg:#faf5ff; --text:#6b21a8; --border:#e9d5ff; --dot:#a855f7; --head:#9333ea; }
.cs-cyan   { --bg:#ecfeff; --text:#164e63; --border:#a5f3fc; --dot:#06b6d4; --head:#0891b2; }
.cs-rose   { --bg:#fff1f2; --text:#9f1239; --border:#fecdd3; --dot:#f43f5e; --head:#e11d48; }

/* Reusable colour helpers */
.c-pill { background:var(--bg);color:var(--text);border-color:var(--border); }
.c-pill:hover { filter:brightness(.94); box-shadow:0 1px 4px rgba(0,0,0,.08); }
.c-dot  { background:var(--dot); }
.c-item-btn {
    background:white;color:var(--text);border:1px solid var(--border);
    transition:background .15s,box-shadow .15s;
}
.c-item-btn:hover { background:var(--bg); box-shadow:0 2px 8px rgba(0,0,0,.07); }

/* ══════════════════════════════════════════
   REVEAL
══════════════════════════════════════════ */
.reveal { opacity:0;transform:translateY(20px);transition:opacity .45s ease,transform .45s ease; }
.reveal.visible { opacity:1;transform:translateY(0); }

/* ══════════════════════════════════════════
   FEATURED CARD HOVER
══════════════════════════════════════════ */
.featured-card { transition:box-shadow .2s ease,transform .2s ease; }
.featured-card:hover { box-shadow:0 6px 24px rgba(0,0,0,.1);transform:translateY(-2px); }

/* ══════════════════════════════════════════
   HERO DECORATIVE CIRCLES
══════════════════════════════════════════ */
.hero-circle {
    position:absolute;border-radius:50%;background:rgba(255,255,255,.05);
    pointer-events:none;
}

/* ══════════════════════════════════════════
   HORIZONTAL FEATURED SCROLLER (mobile)
══════════════════════════════════════════ */
#feat-scroll {
    display:flex;gap:.75rem;overflow-x:auto;scroll-snap-type:x mandatory;
    scrollbar-width:none;-ms-overflow-style:none;
}
#feat-scroll::-webkit-scrollbar { display:none; }
#feat-scroll > * { scroll-snap-align:start;flex-shrink:0;width:200px; }

/* ══════════════════════════════════════════
   CATEGORY SECTION HEAD BAR
══════════════════════════════════════════ */
.cat-head { background:var(--head);color:white; }

/* ══════════════════════════════════════════
   SIDEBAR STICKY
══════════════════════════════════════════ */
.sidebar-sticky { position:sticky;top:5rem; }

/* ══════════════════════════════════════════
   SCROLL ARROW BUTTONS
══════════════════════════════════════════ */
.scroll-arrow {
    width:1.75rem;height:1.75rem;border-radius:50%;
    background:rgba(255,255,255,.9);box-shadow:0 1px 6px rgba(0,0,0,.12);
    border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;
    transition:background .15s;flex-shrink:0;
}
.scroll-arrow:hover { background:white; }
.scroll-arrow:disabled { opacity:.35;cursor:default; }
</style>
 
 



@php
/* PHP colour map — mirrors JS COLOR object */
$colorMap = [
    'blue'   => ['bg'=>'bg-blue-50', 
      'text'=>'text-blue-700',
        'border'=>'border-blue-200',
           'dot'=>'bg-blue-500',
              'head'=>'bg-blue-600'],
    'indigo' => ['bg'=>'bg-indigo-50', 'text'=>'text-indigo-700', 'border'=>'border-indigo-200', 'dot'=>'bg-indigo-500', 'head'=>'bg-indigo-600'],
    'green'  => ['bg'=>'bg-emerald-50','text'=>'text-emerald-700','border'=>'border-emerald-200','dot'=>'bg-emerald-500','head'=>'bg-emerald-600'],
    'orange' => ['bg'=>'bg-orange-50', 'text'=>'text-orange-700', 'border'=>'border-orange-200', 'dot'=>'bg-orange-500', 'head'=>'bg-orange-600'],
    'amber'  => ['bg'=>'bg-amber-50',  'text'=>'text-amber-700',  'border'=>'border-amber-200',  'dot'=>'bg-amber-500',  'head'=>'bg-amber-600'],
    'teal'   => ['bg'=>'bg-teal-50',   'text'=>'text-teal-700',   'border'=>'border-teal-200',   'dot'=>'bg-teal-500',   'head'=>'bg-teal-600'],
    'pink'   => ['bg'=>'bg-pink-50',   'text'=>'text-pink-700',   'border'=>'border-pink-200',   'dot'=>'bg-pink-500',   'head'=>'bg-pink-600'],
    'purple' => ['bg'=>'bg-purple-50', 'text'=>'text-purple-700', 'border'=>'border-purple-200', 'dot'=>'bg-purple-500', 'head'=>'bg-purple-600'],
    'cyan'   => ['bg'=>'bg-cyan-50',   'text'=>'text-cyan-700',   'border'=>'border-cyan-200',   'dot'=>'bg-cyan-500',   'head'=>'bg-cyan-600'],
    'rose'   => ['bg'=>'bg-rose-50',   'text'=>'text-rose-700',   'border'=>'border-rose-200',   'dot'=>'bg-rose-500',   'head'=>'bg-rose-600'],
];
@endphp

<div class="min-h-screen bg-gray-50 font-sans">

    {{-- ════════════════════════════════════════
         HERO
    ════════════════════════════════════════ --}}
    <div class="relative bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-600 overflow-hidden">
        <div class="hero-circle" style="width:16rem;height:16rem;top:-4rem;right:-4rem;"></div>
        <div class="hero-circle" style="width:10rem;height:10rem;bottom:-2.5rem;left:33%;"></div>

        <div class="relative max-w-7xl mx-auto px-4 py-10">

            {{-- Breadcrumb --}}
            <nav class="text-xs text-blue-200 mb-4 flex items-center gap-1.5 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-white font-medium">Business Services</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white leading-tight">
                        Business Services Directory
                    </h1>
                    <p class="text-blue-100 text-sm mt-2 max-w-xl">
                        Explore thousands of verified businesses across India — browse by category, city, or keyword.
                    </p>
                </div>

                {{-- Hero Stats --}}
                <div class="flex gap-3 flex-wrap">
                    @foreach($heroStats as $stat)
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 text-center
                                border border-white/20">
                        <div class="text-xl font-bold text-white">{{ $stat['value'] }}</div>
                        <div class="text-[10px] text-blue-200 mt-0.5">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════
         MAIN LAYOUT
    ════════════════════════════════════════ --}}
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex gap-8 items-start">

            {{-- ══════════════════════════════
                 LEFT — MAIN CONTENT
            ══════════════════════════════ --}}
            <main class="flex-1 min-w-0 space-y-6">

                {{-- Quick Jump Nav --}}
                

                {{-- Category Sections --}}

               <div class="space-y-6">
        @php $colors = array_keys($colorMap); @endphp

        @foreach($categorySections as $title => $sections)
        @php
            $k         = $loop->index;                    
            $colorName = $colors[$k % count($colors)];    
            $c         = $colorMap[$colorName];
            $css       = 'cs-' . $colorName;
            $slug      = Str::slug($title);
        @endphp

        <div id="cat-{{ $slug }}"
             class="reveal {{ $css }} bg-white rounded-2xl border border-gray-100
                    shadow-sm overflow-hidden"
             style="transition-delay:{{ min($k * 0.04, 0.3) }}s;">

            {{-- Section header --}}
            <div class="cat-head px-5 py-3 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-white/60"></span>
                <h2 class="text-sm font-bold">{{ $title }}</h2>
            </div>

            {{-- Items grid --}}
            <div class="p-4">
                <div class="flex flex-wrap gap-2">
                    @foreach($sections as $item)
                    <a href="{{ route('child.show', $item['child_slug']) }}"
                       class="c-item-btn px-3.5 py-1.5 rounded-lg text-sm font-medium
                              flex items-center gap-1.5">
                        @if(!empty($item['icon']))
                        <img src="{{ $item['icon'] }}"
                             alt="{{ $item['alt'] }}"
                             class="w-4 h-4 object-contain shrink-0">
                        @endif
                        {{ $item['child_category'] }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

    @endforeach
</div>

                

                {{-- About Section --}}
                <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-3">
                        About QuickDials Business Services
                    </h2>
                    <div class="text-sm text-gray-600 leading-relaxed space-y-3">
                        <p>
                            QuickDials is India's fastest-growing local business directory, connecting millions
                            of consumers with verified businesses across 200+ cities. Whether you're looking for
                            IT training, medical services, home repairs, or restaurants — we have it all.
                        </p>
                        <p>
                            Our directory features over 8,000 business keywords and 350+ registered businesses,
                            each verified for authenticity. Browse by category, read real reviews, and connect
                            directly with businesses via phone or website — all for free.
                        </p>
                        <p>
                            Are you a business owner? List your business for free on QuickDials and reach
                            thousands of potential customers searching for your services every day.
                        </p>
                        <a href="{{ route('business.services') }}"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700
                                  text-white text-xs font-bold px-4 py-2.5 rounded-xl
                                  transition-colors mt-1">
                            List Your Business Free
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </main>

            {{-- ══════════════════════════════
                 RIGHT — SIDEBAR
            ══════════════════════════════ --}}
            <aside class="w-72 shrink-0 space-y-5 hidden lg:block">
                <div class="sidebar-sticky space-y-5">

                    {{-- Featured Businesses --}}
                    <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                <polyline points="17 6 23 6 23 12"/>
                            </svg>
                            Featured Businesses
                        </h3>
                        <div class="space-y-3">
                            @foreach($featured as $biz)
                            <div class="featured-card bg-white rounded-2xl border border-gray-100
                                        shadow-sm p-4 flex flex-col gap-3">
                                <div class="flex items-start justify-between">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500
                                                to-indigo-600 flex items-center justify-center
                                                text-white font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($biz['name'], 0, 1)) }}
                                    </div>
                                    <span class="text-[10px] bg-amber-50 text-amber-700 border
                                                 border-amber-200 rounded-full px-2 py-0.5
                                                 font-semibold flex items-center gap-1">
                                        ★ {{ $biz['rating'] }}
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 leading-tight">
                                        {{ $biz['name'] }}
                                    </h4>
                                    <p class="text-xs text-blue-600 mt-0.5 font-medium">
                                        {{ $biz['category'] }}
                                    </p>
                                    <div class="flex items-center gap-1 mt-1 text-xs text-gray-400">
                                        📍 {{ $biz['city'] }}
                                        <span class="mx-1">·</span>
                                        {{ $biz['reviews'] }} reviews
                                    </div>
                                </div>
                                <button class="w-full flex items-center justify-center gap-1.5
                                               bg-orange-500 hover:bg-orange-600 text-white
                                               text-xs font-bold py-2 rounded-xl transition-colors">
                                    📞 Call Now
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Stats Card --}}
                    <div class="reveal bg-gradient-to-br from-blue-600 to-indigo-700
                                rounded-2xl p-5 text-white">
                        <h3 class="text-sm font-bold mb-1">A Few Stats About QuickDials</h3>
                        <p class="text-xs text-blue-200 mb-4 leading-relaxed">
                            Trusted by millions across India since 2010.
                        </p>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($sidebarStats as $stat)
                            <div class="bg-white/10 rounded-xl p-3 text-center">
                                <div class="text-lg mb-1">
                                    @switch($stat['icon'])
                                        @case('building') 🏢 @break
                                        @case('search')   🔍 @break
                                        @case('award')    🏆 @break
                                        @case('globe')    🌐 @break
                                        @default          📊
                                    @endswitch
                                </div>
                                <div class="text-base font-bold">{{ $stat['val'] }}</div>
                                <div class="text-[10px] text-blue-300">{{ $stat['label'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Post Requirement --}}
                    <div class="reveal bg-orange-50 border border-orange-200 rounded-2xl p-5">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center
                                        justify-center shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">
                                    Do you have any Requirement?
                                </h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    Tell us what you need and we'll connect you with the right businesses.
                                </p>
                            </div>
                        </div>
                        <button class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white
                                       text-xs font-bold py-2.5 rounded-xl transition-colors
                                       flex items-center justify-center gap-2">
                            Post Your Requirement
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Top Categories Quick Links --}}
                    <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                        <h3 class="text-sm font-bold text-gray-900 mb-3">Top Categories</h3>
                        
                    </div>

                </div>
            </aside>

        </div>
    </div>

    {{-- ════════════════════════════════════════
         MOBILE — Horizontal Featured Scroller
         (shown only on small screens)
    ════════════════════════════════════════ --}}
    <div class="lg:hidden px-4 pb-8">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                📈 Featured Businesses
            </h3>
            <div class="flex gap-1">
                <button id="feat-left"  class="scroll-arrow" aria-label="Scroll left"  disabled>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5"><path d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button id="feat-right" class="scroll-arrow" aria-label="Scroll right">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5"><path d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <div id="feat-scroll">
            @foreach($featured as $biz)
            <div class="featured-card bg-white rounded-2xl border border-gray-100 shadow-sm p-4
                        flex flex-col gap-3">
                <div class="flex items-start justify-between">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600
                                flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr($biz['name'], 0, 1)) }}
                    </div>
                    <span class="text-[10px] bg-amber-50 text-amber-700 border border-amber-200
                                 rounded-full px-2 py-0.5 font-semibold">★ {{ $biz['rating'] }}</span>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-900 leading-tight line-clamp-2">
                        {{ $biz['name'] }}
                    </h4>
                    <p class="text-[10px] text-blue-600 mt-0.5">{{ $biz['category'] }}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">📍 {{ $biz['city'] }}</p>
                </div>
                <button class="w-full bg-orange-500 text-white text-[10px] font-bold py-1.5
                               rounded-lg transition-colors hover:bg-orange-600">
                    📞 Call Now
                </button>
            </div>
            @endforeach
        </div>
    </div>

</div>

 
<script>
(function () {

    /* ── IntersectionObserver reveals ── */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.06, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    /* ── Mobile featured horizontal auto-scroll ── */
    const scroll   = document.getElementById('feat-scroll');
    const btnLeft  = document.getElementById('feat-left');
    const btnRight = document.getElementById('feat-right');

    if (scroll) {
        let hovered = false;
        let autoTimer;

        const CARD_W = () => {
            const first = scroll.firstElementChild;
            return first ? first.offsetWidth + 12 : 212;
        };

        const updateArrows = () => {
            if (!btnLeft || !btnRight) return;
            btnLeft.disabled  = scroll.scrollLeft <= 4;
            btnRight.disabled = scroll.scrollLeft >= scroll.scrollWidth - scroll.clientWidth - 4;
        };

        const doScroll = (dir) => {
            scroll.scrollBy({ left: dir === 'left' ? -CARD_W() : CARD_W(), behavior: 'smooth' });
        };

        scroll.addEventListener('scroll', updateArrows, { passive: true });
        updateArrows();

        btnLeft?.addEventListener('click',  () => doScroll('left'));
        btnRight?.addEventListener('click', () => doScroll('right'));

        scroll.addEventListener('mouseenter', () => { hovered = true;  clearInterval(autoTimer); });
        scroll.addEventListener('mouseleave', () => { hovered = false; startAuto(); });
        scroll.addEventListener('touchstart', () => { hovered = true;  clearInterval(autoTimer); }, { passive: true });
        scroll.addEventListener('touchend',   () => { setTimeout(() => { hovered = false; startAuto(); }, 2000); }, { passive: true });

        const startAuto = () => {
            clearInterval(autoTimer);
            autoTimer = setInterval(() => {
                if (hovered) return;
                const atEnd = scroll.scrollLeft >= scroll.scrollWidth - scroll.clientWidth - 4;
                if (atEnd) {
                    scroll.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    doScroll('right');
                }
            }, 2000);
        };

        startAuto();
    }

    /* ── Smooth anchor scroll for jump-nav ── */
    document.querySelectorAll('a[href^="#cat-"]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const target = document.querySelector(link.getAttribute('href'));
            if (!target) return;
            const offset = 80;
            window.scrollTo({
                top: target.getBoundingClientRect().top + window.scrollY - offset,
                behavior: 'smooth',
            });
        });
    });

})();
</script>
 
    
       
@endsection