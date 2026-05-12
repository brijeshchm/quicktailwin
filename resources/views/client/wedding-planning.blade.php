@extends('client.layouts.app')

@section('title', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owner.')
@section('description', 'Looking for Wedding Organizers in Noida, Noida Sector 16? Get flawless event planning with décor, catering, themes, and venue management handled by experts near you.')
@section('keyword', 'Wedding Organizers, Wedding Organizers in Noida, Noida Sector 16, Wedding Planners Noida, Noida Sector 16, Marriage Event near you, Wedding Management near you, Wedding Decoration, Marriage Ceremony Planners, Wedding Services')

@section('content')	 
 

 
<style>
 

/* ══════════════════════════════════════════
   HERO
══════════════════════════════════════════ */
.hero-section {
    position: relative;
    min-height: 52vh;
    overflow: hidden;
    background: url('https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=1400&h=900&fit=crop') center/cover no-repeat;
}
@media(min-width:768px)  { .hero-section { min-height: 65vh; } }
@media(min-width:1280px) { .hero-section { min-height: 70vh; } }

.hero-overlay-l {
    background: linear-gradient(to right,
        rgba(45,15,5,.78) 0%,
        rgba(40,12,4,.62) 28%,
        rgba(30,8,2,.35)  48%,
        rgba(15,4,1,.10)  64%,
        transparent 76%);
}
.hero-overlay-b { background: linear-gradient(to bottom, rgba(0,0,0,.15) 0%, transparent 50%, rgba(0,0,0,.32) 100%); }
.hero-orb { position:absolute;bottom:0;left:0;width:460px;height:280px;border-radius:50%;opacity:.25;filter:blur(80px);pointer-events:none;background:radial-gradient(circle,#C0392B 0%,transparent 70%); }
.hero-particle { position:absolute;border-radius:50%;filter:blur(20px);animation:ptcl-float linear infinite; }
@keyframes ptcl-float { 0% { transform:translateY(0);opacity:0; } 15% { opacity:.55; } 85% { opacity:.55; } 100% { transform:translateY(-160px);opacity:0; } }

.gradient-headline {
    background: linear-gradient(90deg, #f0c040 0%, #fef9e7 45%, #C0392B 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ══════════════════════════════════════════
   GLITTER / SPARKLE (category & venue bg)
══════════════════════════════════════════ */
.glitter-star {
    position:absolute;line-height:1;pointer-events:none;user-select:none;z-index:2;
    animation: twinkle var(--dur) var(--delay) ease-in-out infinite;
}
@keyframes twinkle {
    0%,100% { opacity:0;  transform:scale(.2) rotate(0deg); }
    35%      { opacity:1;  transform:scale(1.6) rotate(80deg); }
    50%      { opacity:1;  transform:scale(1.4) rotate(140deg); }
    70%      { opacity:.8; transform:scale(1.1) rotate(200deg); }
}
.shimmer-bar {
    position:absolute;inset:0;pointer-events:none;
    background:linear-gradient(90deg,transparent 0%,rgba(255,255,255,.35) 50%,transparent 100%);
    width:40%;animation:shimmer-sweep 3.5s 1s ease-in-out infinite;
}
@keyframes shimmer-sweep {
    0%   { transform:translateX(-100%) skewX(-20deg); }
    100% { transform:translateX(400%)  skewX(-20deg); }
}

/* ══════════════════════════════════════════
   ROSE PETALS (bride section)
══════════════════════════════════════════ */
.rose-petal {
    position:absolute;border-radius:150% 0 150% 0;pointer-events:none;
    animation:petal-fall var(--dur) var(--delay) ease-in infinite;will-change:top,transform;
}
@keyframes petal-fall {
    0%   { top:-30px;opacity:0; }
    5%   { opacity:.85; }
    90%  { opacity:.7; }
    100% { top:110%;opacity:0; }
}

/* ══════════════════════════════════════════
   CATEGORY / BRIDE / GROOM IMAGE CARDS
══════════════════════════════════════════ */
.img-card { position:relative;overflow:hidden;border-radius:.75rem;cursor:pointer; }
.img-card img { transition:transform .7s cubic-bezier(.22,1,.36,1); }
.img-card:hover img { transform:scale(1.1); }
.img-card .overlay-hover {
    position:absolute;inset:0;background:rgba(192,57,43,0);
    transition:background .3s ease;
}
.img-card:hover .overlay-hover { background:rgba(192,57,43,.18); }
.img-card .ring-hover {
    position:absolute;inset:0;border-radius:.75rem;
    box-shadow:inset 0 0 0 0 rgba(240,192,64,0);
    transition:box-shadow .3s ease;
}
.img-card:hover .ring-hover { box-shadow:inset 0 0 0 2px rgba(240,192,64,.7); }

/* ══════════════════════════════════════════
   VENUE CAROUSEL
══════════════════════════════════════════ */
#venue-track { display:flex;gap:24px;width:max-content;will-change:transform; }
.venue-card { flex-shrink:0;width:340px;border-radius:1.25rem;overflow:hidden;
    background:white;box-shadow:0 4px 20px rgba(0,0,0,.08);
    transition:box-shadow .3s ease; }
.venue-card:hover { box-shadow:0 10px 40px rgba(0,0,0,.14); }
.venue-card img { transition:transform .7s ease; }
.venue-card:hover img { transform:scale(1.07); }

/* ══════════════════════════════════════════
   REVEAL ON SCROLL
══════════════════════════════════════════ */
.reveal { opacity:0;transform:translateY(28px);transition:opacity .55s ease,transform .55s ease; }
.reveal.visible { opacity:1;transform:translateY(0); }
.reveal-l { opacity:0;transform:translateX(-28px);transition:opacity .55s ease,transform .55s ease; }
.reveal-l.visible { opacity:1;transform:translateX(0); }
.reveal-r { opacity:0;transform:translateX(28px);transition:opacity .55s ease,transform .55s ease; }
.reveal-r.visible { opacity:1;transform:translateX(0); }
.reveal-s { opacity:0;transform:scale(.9);transition:opacity .45s ease,transform .45s ease; }
.reveal-s.visible { opacity:1;transform:scale(1); }

/* Stagger delays */
 
.d-0{transition-delay:0s}.d-1{transition-delay:.07s}.d-2{transition-delay:.14s}
.d-3{transition-delay:.21s}.d-4{transition-delay:.28s}.d-5{transition-delay:.35s}
.d-6{transition-delay:.42s}.d-7{transition-delay:.49s}.d-8{transition-delay:.56s}

/* ══════════════════════════════════════════
   STEP CARDS (How It Works)
══════════════════════════════════════════ */
.step-circle {
    width:8rem;height:8rem;border-radius:50%;
    background:linear-gradient(135deg,rgba(192,57,43,.10),rgba(240,192,64,.10));
    border:2px solid rgba(192,57,43,.2);
    display:flex;align-items:center;justify-content:center;
    position:relative;box-shadow:0 8px 24px rgba(192,57,43,.12);
    transition:transform .3s ease;
}
.step-circle:hover { transform:scale(1.08) rotate(4deg); }
.step-num {
    position:absolute;top:-.75rem;right:-.75rem;
    width:2.5rem;height:2.5rem;border-radius:50%;
    background:var(--primary);color:white;font-weight:700;font-size:.875rem;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 4px 12px rgba(192,57,43,.35);
}

/* ══════════════════════════════════════════
   TESTIMONIAL CARDS
══════════════════════════════════════════ */
.testimonial-card { transition:transform .3s ease,box-shadow .3s ease; }
.testimonial-card:hover { transform:translateY(-6px);box-shadow:0 16px 48px rgba(0,0,0,.12); }

/* ══════════════════════════════════════════
   GOLD BACKGROUND (category / venue)
══════════════════════════════════════════ */
.gold-bg { background:linear-gradient(135deg,#fffbe8 0%,#fff3c0 35%,#ffe896 65%,#ffd84d 100%); }

/* ══════════════════════════════════════════
   SERIF HEADINGS
══════════════════════════════════════════ */
.serif { font-family: var(--serif); }
</style>
 

{{-- ════════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════ --}}
<section class="hero-section flex items-start">

    {{-- Overlays --}}
    <div class="absolute inset-0 hero-overlay-l"></div>
    <div class="absolute inset-0 hero-overlay-b"></div>
    <div class="hero-orb"></div>

    {{-- Bokeh particles --}}
    @foreach(range(1,8) as $p)
    <div class="hero-particle"
         style="width:{{ rand(14,52) }}px;height:{{ rand(14,52) }}px;
                left:{{ rand(0,50) }}%;top:{{ rand(0,100) }}%;
                background:{{ $p % 2 === 0 ? 'rgba(240,192,64,.18)' : 'rgba(192,57,43,.14)' }};
                animation-duration:{{ rand(8,15) }}s;
                animation-delay:{{ rand(0,8) }}s;">
    </div>
    @endforeach

    {{-- Content --}}
    <div class="relative z-10 w-full px-6 md:px-14 lg:px-20 pt-10 md:pt-16 lg:pt-20 pb-10">

        {{-- Ornamental badge --}}
        <div class="reveal flex items-center gap-2 md:gap-3 mb-4 md:mb-5">
            <div class="h-px w-8 md:w-14 bg-red-400"></div>
            <span class="text-red-400 text-sm">♥</span>
            <div class="h-px w-8 md:w-14 bg-red-400"></div>
            <span class="text-red-300 text-[10px] md:text-xs font-semibold tracking-[.15em] uppercase ml-1">
                Shaadi6 · India's #1 Wedding Platform
            </span>
        </div>

        {{-- Headline --}}
        <h1 class="reveal serif font-bold text-white leading-none mb-1 d-1"
            style="font-size:clamp(2.4rem,5.5vw,5.5rem);">
            Where Every
        </h1>
        <h1 class="reveal serif font-bold leading-none mb-4 md:mb-5 d-2 gradient-headline"
            style="font-size:clamp(2.4rem,5.5vw,5.5rem);">
            Dream Begins
        </h1>

        <p class="reveal text-white/70 text-sm md:text-base lg:text-lg max-w-md leading-relaxed mb-6 d-3">
            India's most loved wedding planning platform — venues, vendors &amp;
            everything curated for your special day.
        </p>

        {{-- Stats --}}
        <div class="reveal flex flex-nowrap gap-x-5 md:gap-x-8 pt-4 border-t border-white/20 d-4">
            @foreach($stats as $i => $stat)
            <div class="flex items-center gap-2 md:gap-4 flex-shrink-0">
                @if($i !== 0)
                <div class="w-px h-6 md:h-8 bg-white/25"></div>
                @endif
                <div>
                    <p class="serif font-bold text-white text-sm md:text-xl lg:text-2xl leading-none">
                        {{ $stat['value'] }}
                    </p>
                    <p class="text-white/50 text-[10px] md:text-xs mt-0.5">{{ $stat['label'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════
     CATEGORY SECTION  (golden glitter bg)
════════════════════════════════════════════ --}}
<section class="py-6 relative overflow-hidden gold-bg">

    {{-- Glitter stars (server-generated, CSS animated) --}}
    @php
    $starChars = ['✦','✧','★','✦','✧','✶','✸'];
    $sparkles  = collect(range(0,49))->map(fn($i) => [
        'top'   => rand(0,95).'%',
        'left'  => rand(0,98).'%',
        'size'  => [1=>'16px',2=>'22px',3=>'30px'][rand(1,3)],
        'char'  => $starChars[$i % count($starChars)],
        'delay' => number_format(rand(0,500)/100, 2).'s',
        'dur'   => number_format(rand(150,300)/100, 2).'s',
        'red'   => $i % 2 === 0,
    ]);
    @endphp

    @foreach($sparkles as $s)
    <span class="glitter-star" style="top:{{ $s['top'] }};left:{{ $s['left'] }};font-size:{{ $s['size'] }};
        color:{{ $s['red'] ? 'rgba(220,30,50,1)' : 'rgba(255,255,255,1)' }};
        text-shadow:{{ $s['red'] ? '0 0 8px rgba(255,50,50,1),0 0 18px rgba(220,0,30,.8)' : '0 0 8px rgba(255,255,255,1),0 0 18px rgba(255,255,255,.8)' }};
        --dur:{{ $s['dur'] }};--delay:{{ $s['delay'] }};">{{ $s['char'] }}</span>
    @endforeach
    <div class="shimmer-bar"></div>

    {{-- Bokeh orbs --}}
    <div class="absolute top-0 right-0 w-72 h-72 opacity-40 pointer-events-none"
         style="background:radial-gradient(circle,#f0c040 0%,transparent 70%);transform:translate(30%,-30%);"></div>
    <div class="absolute bottom-0 left-0 w-56 h-56 opacity-30 pointer-events-none"
         style="background:radial-gradient(circle,#f0c040 0%,transparent 70%);transform:translate(-30%,30%);"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10">
        <div class="reveal text-center mb-4">
            <h2 class="serif text-xl md:text-2xl font-bold text-gray-900 mb-1">Wedding Prerequisites</h2>
            <p class="text-amber-800/50 text-[11px] max-w-lg mx-auto">Everything you need for your special day, carefully curated.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
            @foreach($categories as $i => $cat)
            <div class="reveal img-card d-{{ min($i,8) }}" style="aspect-ratio:16/10;">
                <img src="{{ $cat['img'] }}" alt="{{ $cat['name'] }}"
                     class="absolute inset-0 w-full h-full object-cover"
                     onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=300&fit=crop'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/15 to-transparent"></div>
                <div class="overlay-hover"></div>
                <div class="ring-hover"></div>
                <div class="absolute bottom-0 left-0 right-0 p-2">
                    <p class="text-white text-[11px] md:text-xs font-semibold leading-tight drop-shadow">
                        {{ $cat['name'] }}
                    </p>
                    <p class="text-amber-400 text-[9px] font-medium mt-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                        Explore →
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════
     TOP CATEGORIES GRID
════════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-6 py-10">
    <h1 class="serif text-4xl font-bold text-center mb-10">Wedding Planning</h1>

    <div class="grid grid-cols-3 md:grid-cols-6 gap-6 mb-16">
        @foreach([
            ['name'=>'Banquet Halls','img'=>'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=400&fit=crop'],
            ['name'=>'Catering Services','img'=>'https://images.unsplash.com/photo-1555244162-803834f70033?w=400&h=400&fit=crop'],
            ['name'=>'Stage Decorators','img'=>'https://images.unsplash.com/photo-1478827387698-1527781a4887?w=400&h=400&fit=crop'],
            ['name'=>'Photographers','img'=>'https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=400&h=400&fit=crop'],
            ['name'=>'Pandits','img'=>'https://images.unsplash.com/photo-1583939411023-14783179e581?w=400&h=400&fit=crop'],
            ['name'=>'Invitation Cards','img'=>'https://images.unsplash.com/photo-1523438885200-e635ba2c371e?w=400&h=400&fit=crop'],
        ] as $cat)
        <a href="{{ route('category.list') }}" class="group block reveal">
            <div class="relative h-48 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition">
                <img src="{{ $cat['img'] }}" alt="{{ $cat['name'] }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white font-medium text-sm">{{ $cat['name'] }}</div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Photographer Banner --}}
    <div class="relative h-[300px] rounded-3xl overflow-hidden mb-16 reveal">
        <img src="https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=1200&h=600&fit=crop"
             alt="Wedding Photographers" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/40"></div>
        <div class="absolute inset-0 flex items-center justify-center text-center text-white px-6">
            <div>
                <h2 class="serif text-3xl md:text-4xl font-bold mb-4">
                    Choose the Best Photographers<br>to capture your special moments!
                </h2>
                <button class="bg-white text-black px-10 py-3 rounded-full font-semibold
                               hover:bg-orange-500 hover:text-white transition-colors">
                    EXPLORE NOW →
                </button>
            </div>
        </div>
    </div>

    {{-- Pre-Wedding Planning --}}
    <div class="mb-16">
        <h2 class="serif text-3xl font-semibold mb-8 reveal">Pre-Wedding Planning</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($prewedding as $i => $item)
            <div class="reveal d-{{ min($i,8) }} bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                <div class="h-48 bg-gray-100 relative flex items-center justify-center text-6xl">💍</div>
                <div class="p-4 text-center font-medium text-sm">{{ $item }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Wedding Sweets Banner --}}
    <div class="reveal bg-gradient-to-r from-purple-700 to-pink-600 text-white rounded-3xl
                p-10 mb-16 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-1">
            <h2 class="serif text-4xl font-bold mb-4">Looking for Wedding Sweets</h2>
            <p class="text-xl opacity-90">Make your big day even sweeter with the best sweets &amp; dry fruits</p>
        </div>
        <button class="bg-white text-purple-700 px-10 py-4 rounded-full font-semibold text-lg
                       hover:bg-orange-400 hover:text-white transition-colors">
            EXPLORE NOW →
        </button>
    </div>

    {{-- For Your Big Day --}}
    <div class="mb-16">
        <h2 class="serif text-3xl font-semibold mb-8 reveal">For Your Big Day</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($bigDay as $i => $item)
            <div class="reveal d-{{ min($i,8) }} bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow transition">
                <div class="text-5xl mb-4">🎉</div>
                <p class="font-semibold text-sm">{{ $item }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Honeymoon & Travel --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
        <div class="reveal bg-white rounded-3xl p-8 shadow-sm">
            <h3 class="serif text-2xl font-bold mb-4">Honeymoon Packages</h3>
            <p class="text-gray-600 mb-6">Plan your loveliest holiday moments with us</p>
            <button class="bg-black text-white px-8 py-3 rounded-full hover:bg-red-700 transition-colors">Explore Now</button>
        </div>
        <div class="reveal bg-white rounded-3xl p-8 shadow-sm">
            <h3 class="serif text-2xl font-bold mb-4">Travel Agent</h3>
            <p class="text-gray-600 mb-6">Travel and explore your dream destination with us</p>
            <button class="bg-black text-white px-8 py-3 rounded-full hover:bg-red-700 transition-colors">Explore Now</button>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════
     BRIDE SECTION
════════════════════════════════════════════ --}}
<section class="py-8 bg-white relative overflow-hidden">

    {{-- Rose petals --}}
    @php
    $petalColors = ['#e60000','#cc0000','#ff1a1a','#dd0000','#ff0000','#cc1100'];
    $petals = collect(range(0,29))->map(fn($i) => [
        'left'   => rand(0,100).'%',
        'w'      => rand(8,22),
        'h'      => rand(6,16),
        'color'  => $petalColors[$i % count($petalColors)],
        'dur'    => number_format(rand(40,80)/10, 1).'s',
        'delay'  => number_format(rand(0,700)/100, 2).'s',
        'rotate' => rand(0,360),
    ]);
    @endphp

    @foreach($petals as $p)
    <div class="rose-petal"
         style="left:{{ $p['left'] }};width:{{ $p['w'] }}px;height:{{ $p['h'] }}px;
                transform:rotate({{ $p['rotate'] }}deg);
                background:radial-gradient(ellipse at 30% 30%,{{ $p['color'] }}dd,{{ $p['color'] }}ff);
                box-shadow:inset 0 1px 3px rgba(255,255,255,.4);
                --dur:{{ $p['dur'] }};--delay:{{ $p['delay'] }};">
    </div>
    @endforeach

    <div class="container mx-auto px-4 md:px-6 relative z-10">

        {{-- Header --}}
        <div class="reveal mb-6 md:mb-10">
            <span class="inline-flex items-center gap-2 bg-red-50 text-red-700 text-xs font-bold
                         tracking-widest uppercase px-4 py-1.5 rounded-full mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-red-700"></span>
                For the Bride
            </span>
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                <div>
                    <h2 class="serif text-2xl md:text-4xl font-bold text-gray-900 leading-tight">
                        Wedding Planning <br><span class="text-red-600">for Bride</span>
                    </h2>
                    <div class="w-14 h-1 bg-red-600 rounded-full mt-3"></div>
                </div>
                <a href="{{ route('category.list') }}" class="self-start md:self-auto border border-red-200 text-red-700
                                   hover:bg-red-600 hover:text-white rounded-full px-5 py-2
                                   text-sm flex items-center gap-2 transition-all">
                    View All Bride Services →
                </a>
            </div>
        </div>

        {{-- Grid + Feature card --}}
        <div class="grid lg:grid-cols-3 gap-4 items-stretch">
            <div class="lg:col-span-2 grid grid-cols-3 gap-2 sm:gap-3">
                @foreach($brideCategories as $i => $item)
                <div class="reveal d-{{ min($i,8) }} img-card group shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="relative overflow-hidden" style="height:6rem; @media(min-width:640px){height:8rem;} @media(min-width:768px){height:9rem;}">
                        <div class="h-24 sm:h-32 md:h-36 overflow-hidden">
                            <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                 onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=300&fit=crop'">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                        <div class="overlay-hover"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 px-2 py-1.5">
                        <p class="text-white font-semibold text-[10px] sm:text-xs leading-tight drop-shadow">
                            {{ $item['name'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Feature card (desktop only) --}}
            <div class="reveal-r hidden lg:block group relative rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-shadow cursor-pointer">
                <img src="https://images.unsplash.com/photo-1532712938310-34cb3982ef74?w=600&h=800&fit=crop"
                     alt="Grand Bridal Entry"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                     onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=600&h=800&fit=crop'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                <div class="overlay-hover"></div>
                <div class="absolute bottom-5 left-5 right-5">
                    <span class="inline-block bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full mb-2">
                        Featured
                    </span>
                    <p class="serif text-white font-bold text-lg leading-snug drop-shadow">Grand Bridal Entry</p>
                    <p class="text-white/75 text-sm mt-1">Luxury cars &amp; phoolon ki chadar for the bride</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════
     VENUE SECTION  (golden + auto-scroll)
════════════════════════════════════════════ --}}
<section class="py-8 relative overflow-hidden gold-bg">

    {{-- Reuse glitter stars --}}
    @foreach($sparkles->take(30) as $s)
    <span class="glitter-star" style="top:{{ $s['top'] }};left:{{ $s['left'] }};font-size:{{ $s['size'] }};
        color:{{ $s['red'] ? 'rgba(220,30,50,1)' : 'rgba(255,255,255,1)' }};
        text-shadow:{{ $s['red'] ? '0 0 8px rgba(255,50,50,1)' : '0 0 8px rgba(255,255,255,1)' }};
        --dur:{{ $s['dur'] }};--delay:{{ $s['delay'] }};">{{ $s['char'] }}</span>
    @endforeach
    <div class="shimmer-bar"></div>

    <div class="relative z-10">
        <div class="container mx-auto px-4 md:px-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="reveal-l">
                    <h2 class="serif text-3xl md:text-4xl font-bold text-gray-900 mb-2">Top Venues in Mumbai</h2>
                    <p class="text-amber-800/50 max-w-xl text-sm">Discover breathtaking locations for your perfect celebration.</p>
                </div>
                <a href="{{ route('category.list') }}" class="reveal-r text-red-700 font-medium hover:underline flex items-center gap-1 text-sm">
                    View all venues →
                </a>
            </div>
        </div>

        {{-- Drag-to-scroll carousel --}}
        <div id="venue-viewport" class="overflow-hidden px-4 md:px-6 pb-6 select-none" style="cursor:grab;">
            <div id="venue-track">
                @php $allVenues = array_merge($venues, $venues, $venues); @endphp
                @foreach($allVenues as $i => $venue)
                <div class="venue-card" style="pointer-events:none;">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $venue['img'] }}" alt="{{ $venue['name'] }}"
                             class="w-full h-full object-cover" draggable="false"
                             onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=700&h=500&fit=crop'">
                        <div class="absolute top-4 right-4 bg-white px-2 py-1 rounded text-xs font-bold shadow-sm">
                            {{ $venue['price'] }}
                        </div>
                    </div>
                    <div class="p-5 bg-white">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="serif font-bold text-xl text-gray-900 leading-none line-clamp-1">
                                {{ $venue['name'] }}
                            </h3>
                            <div class="flex items-center gap-1 bg-green-50 text-green-700 px-2 py-0.5 rounded text-sm font-medium flex-shrink-0">
                                ★ {{ $venue['rating'] }}
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm mb-4 flex items-center gap-1">
                            📍 {{ $venue['location'] }}
                        </p>
                        <div class="w-full h-px bg-gray-100 mb-4"></div>
                        <div class="flex justify-between items-center text-sm font-medium">
                            <span class="text-gray-400">{{ $venue['reviews'] }} Reviews</span>
                            <span class="text-red-600">Request Pricing</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════
     GROOM SECTION
════════════════════════════════════════════ --}}
<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4 md:px-6">

        <div class="reveal mb-6 md:mb-10">
            <span class="inline-flex items-center gap-2 bg-gray-900/10 text-gray-800 text-xs font-bold
                         tracking-widest uppercase px-4 py-1.5 rounded-full mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-gray-800"></span>
                For the Groom
            </span>
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
                <div>
                    <h2 class="serif text-2xl md:text-4xl font-bold text-gray-900 leading-tight">
                        Wedding Planning <br><span class="text-gray-700">for Groom</span>
                    </h2>
                    <div class="w-14 h-1 bg-gray-800 rounded-full mt-3"></div>
                </div>
                <a href="{{ route('category.list') }}" class="self-start border border-gray-300 text-gray-800 hover:bg-gray-900 hover:text-white
                                   rounded-full px-5 py-2 text-sm flex items-center gap-2 transition-all">
                    View All Groom Services →
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-4 items-stretch">

            {{-- Feature card --}}
            <div class="reveal-l hidden lg:block group relative rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-shadow cursor-pointer">
                <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&h=800&fit=crop"
                     alt="Royal Groom Entry"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                <div class="absolute bottom-5 left-5 right-5">
                    <span class="inline-block bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-full mb-2">Featured</span>
                    <p class="serif text-white font-bold text-lg leading-snug drop-shadow">Royal Groom Entry</p>
                    <p class="text-white/75 text-sm mt-1">Make a grand entrance your guests will never forget</p>
                </div>
            </div>

            {{-- Grid --}}
            <div class="lg:col-span-2 grid grid-cols-3 gap-2 sm:gap-3">
                @foreach($groomCategories as $i => $item)
                <div class="reveal d-{{ min($i,8) }} img-card group shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="h-24 sm:h-32 md:h-36 overflow-hidden">
                        <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                             onerror="this.src='https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=300&fit=crop'">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/10 to-transparent"></div>
                    <div class="overlay-hover"></div>
                    <div class="absolute bottom-0 left-0 right-0 px-2 py-1.5">
                        <p class="text-white font-semibold text-[10px] sm:text-xs leading-tight drop-shadow">
                            {{ $item['name'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════
     HOW IT WORKS
════════════════════════════════════════════ --}}
<section class="py-14 bg-white overflow-hidden">
    <div class="container mx-auto px-4 md:px-6">

        <div class="reveal text-center mb-20">
            <p class="text-red-600 font-semibold tracking-widest uppercase text-sm mb-3">Simple Process</p>
            <h2 class="serif text-3xl md:text-5xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg">
                Planning your dream wedding is easier than you think. Three simple steps to your perfect day.
            </p>
            <div class="w-24 h-1 bg-red-600 mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="relative">
            {{-- Dashed connector --}}
            <div class="hidden md:block absolute top-16 h-0.5"
                 style="left:calc(16.66% + 20px);right:calc(16.66% + 20px);border-top:2px dashed rgba(192,57,43,.3);"></div>

            <div class="grid md:grid-cols-3 gap-12 md:gap-8">
                @foreach($steps as $i => $step)
                <div class="reveal d-{{ $i }} flex flex-col items-center text-center relative">
                    <div class="relative mb-8">
                        <div class="step-circle">
                            <div class="w-20 h-20 rounded-full bg-red-50 flex items-center justify-center text-4xl shadow-inner">
                                {{ $step['icon'] }}
                            </div>
                        </div>
                        <div class="step-num">{{ $i + 1 }}</div>
                        <div class="absolute inset-0 rounded-full blur-xl scale-150"
                             style="background:rgba(192,57,43,.05);"></div>
                    </div>
                    <h3 class="serif text-2xl font-bold text-gray-900 mb-4">{{ $step['title'] }}</h3>
                    <p class="text-gray-500 leading-relaxed max-w-xs text-sm">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="reveal text-center mt-16">
            <button class="inline-flex items-center gap-2 bg-red-600 text-white rounded-full
                           px-10 py-4 font-semibold text-lg shadow-lg shadow-red-200
                           hover:shadow-red-300 hover:-translate-y-1 transition-all duration-300">
                Start Planning Today ❤️
            </button>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════
     TESTIMONIALS
════════════════════════════════════════════ --}}
<section class="py-14 relative overflow-hidden">
    <div class="absolute inset-0 pointer-events-none"
         style="background:linear-gradient(135deg,rgba(192,57,43,.05),white,rgba(240,192,64,.05));"></div>
    <div class="absolute top-0 left-0 right-0 h-px"
         style="background:linear-gradient(to right,transparent,rgba(192,57,43,.3),transparent);"></div>
    <div class="absolute bottom-0 left-0 right-0 h-px"
         style="background:linear-gradient(to right,transparent,rgba(192,57,43,.3),transparent);"></div>

    <div class="container mx-auto px-4 md:px-6 relative">

        <div class="reveal text-center mb-16">
            <p class="text-red-600 font-semibold tracking-widest uppercase text-sm mb-3">Love Stories</p>
            <h2 class="serif text-3xl md:text-5xl font-bold text-gray-900 mb-4">What Couples Say</h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg">
                Thousands of couples have trusted us with their most precious day.
            </p>
            <div class="w-24 h-1 bg-red-600 mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($testimonials as $i => $t)
            <div class="reveal d-{{ $i }} testimonial-card bg-white rounded-3xl p-8 shadow-md
                        border border-gray-100 flex flex-col">
                <div class="mb-6 text-red-200 text-4xl font-serif">"</div>
                <div class="flex gap-1 mb-4">
                    @for($s = 0; $s < $t['rating']; $s++)
                    <span class="text-amber-400 text-sm">★</span>
                    @endfor
                </div>
                <p class="text-gray-700 leading-relaxed flex-1 mb-6 italic font-light text-sm">
                    "{{ $t['text'] }}"
                </p>
                <div class="mb-6">
                    <span class="text-xs font-semibold bg-red-50 text-red-700 px-3 py-1 rounded-full">
                        {{ $t['package'] }}
                    </span>
                </div>
                <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br {{ $t['grad'] }}
                                flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ $t['avatar'] }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $t['name'] }}</p>
                        <p class="text-gray-400 text-xs">{{ $t['location'] }} · {{ $t['date'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-20 max-w-4xl mx-auto text-center">
            @foreach([
                ['value'=>'10,000+','label'=>'Happy Couples'],
                ['value'=>'500+',   'label'=>'Verified Vendors'],
                ['value'=>'50+',    'label'=>'Cities Covered'],
                ['value'=>'4.9★',  'label'=>'Average Rating'],
            ] as $i => $stat)
            <div class="reveal d-{{ $i }}">
                <p class="serif text-3xl md:text-4xl font-bold text-red-600 mb-1">{{ $stat['value'] }}</p>
                <p class="text-gray-500 text-sm font-medium">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Wedding Guide / Content --}}
<div class="max-w-7xl mx-auto px-6 pb-20">
    <div class="reveal prose max-w-none">
        <h2 class="serif text-3xl font-bold mb-6">Mumbai's Wedding Planning Guide</h2>
        <p class="text-lg text-gray-600 leading-relaxed">
            Essential Wedding Requirements: Crafting the Perfect Celebration with Perfect Wedding Planning.
            From selecting the ideal venue to coordinating with the best vendors — let us help you create
            memories that last a lifetime.
        </p>
    </div>
</div>

 
{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">

<script>
(function () {

    /* ── IntersectionObserver reveals ── */
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.07, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal,.reveal-l,.reveal-r,.reveal-s')
            .forEach(el => io.observe(el));

    /* ── Venue auto-scroll carousel ── */
    const CARD_W  = 340;
    const GAP     = 24;
    const STRIDE  = CARD_W + GAP;
    const LOOP_AT = STRIDE * 5;     // 5 original venues
    const SPEED   = 0.7;

    const vp        = document.getElementById('venue-viewport');
    const track     = document.getElementById('venue-track');
    let offset      = 0;
    let dragging    = false;
    let dragStartX  = 0;
    let dragStartOff= 0;
    let velocity    = 0;
    let lastX       = 0;
    let raf;

    const applyOffset = (val) => {
        let o = val % LOOP_AT;
        if (o > 0) o -= LOOP_AT;
        offset = o;
        track.style.transform = `translateX(${o}px)`;
    };

    const tick = () => {
        if (!dragging) {
            offset -= SPEED;
            if (Math.abs(offset) >= LOOP_AT) offset += LOOP_AT;
            track.style.transform = `translateX(${offset}px)`;
        }
        raf = requestAnimationFrame(tick);
    };
    raf = requestAnimationFrame(tick);

    /* Mouse */
    vp.addEventListener('mousedown', e => {
        dragging = true; dragStartX = e.clientX; dragStartOff = offset;
        velocity = 0; lastX = e.clientX; vp.style.cursor = 'grabbing';
    });
    vp.addEventListener('mousemove', e => {
        if (!dragging) return;
        velocity = e.clientX - lastX; lastX = e.clientX;
        applyOffset(dragStartOff + (e.clientX - dragStartX));
    });
    const endDrag = () => {
        if (!dragging) return;
        dragging = false; vp.style.cursor = 'grab';
        offset += velocity;
    };
    vp.addEventListener('mouseup', endDrag);
    vp.addEventListener('mouseleave', endDrag);

    /* Touch */
    vp.addEventListener('touchstart', e => {
        dragging = true; dragStartX = e.touches[0].clientX;
        dragStartOff = offset; velocity = 0; lastX = e.touches[0].clientX;
    }, { passive: true });
    vp.addEventListener('touchmove', e => {
        if (!dragging) return;
        velocity = e.touches[0].clientX - lastX; lastX = e.touches[0].clientX;
        applyOffset(dragStartOff + (e.touches[0].clientX - dragStartX));
    }, { passive: true });
    vp.addEventListener('touchend', () => {
        dragging = false; offset += velocity;
    });

})();
</script>
 
 
@endsection