@php
    $accents = [
        'orange' => [
            'text'   => 'text-orange-600',
            'price'  => 'text-orange-600',
            'border' => 'border-orange-500/30',
            'shadow' => 'shadow-orange-500/20',
            'badge'  => 'bg-orange-500',
        ],
        'amber' => [
            'text'   => 'text-amber-600',
            'price'  => 'text-amber-600',
            'border' => 'border-amber-500/30',
            'shadow' => 'shadow-amber-500/20',
            'badge'  => 'bg-amber-500',
        ],
        'teal' => [
            'text'   => 'text-teal-600',
            'price'  => 'text-teal-600',
            'border' => 'border-teal-500/30',
            'shadow' => 'shadow-teal-500/20',
            'badge'  => 'bg-teal-500',
        ],
        'indigo' => [
            'text'   => 'text-indigo-600',
            'price'  => 'text-indigo-600',
            'border' => 'border-indigo-500/30',
            'shadow' => 'shadow-indigo-500/20',
            'badge'  => 'bg-indigo-500',
        ],
        'rose' => [
            'text'   => 'text-rose-600',
            'price'  => 'text-rose-600',
            'border' => 'border-rose-500/30',
            'shadow' => 'shadow-rose-500/20',
            'badge'  => 'bg-rose-500',
        ],
        'stone' => [
            'text'   => 'text-stone-600',
            'price'  => 'text-stone-600',
            'border' => 'border-stone-500/30',
            'shadow' => 'shadow-stone-500/20',
            'badge'  => 'bg-stone-500',
        ],
    ];

    $services = [
        [
            'icon'  => '🫧',
            'acc'   => 'orange',
            'cat'   => 'Massage',
            'title' => 'Swedish Massage',
            'sub'   => 'Classic Relaxation',
            'desc'  => 'Long flowing strokes ease tension, restore circulation, and melt stress away from every muscle.',
            'dur'   => '60–90 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80',
        ],
        [
            'icon'  => '🔥',
            'acc'   => 'amber',
            'cat'   => 'Massage',
            'title' => 'Hot Stone Therapy',
            'sub'   => 'Deep-Tissue Warmth',
            'desc'  => 'Basalt stones heated to precision melt through chronic tension layer by layer.',
            'dur'   => '75–90 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=800&q=80',
        ],
        [
            'icon'  => '🌿',
            'acc'   => 'teal',
            'cat'   => 'Healing',
            'title' => 'Ayurvedic Ritual',
            'sub'   => 'Ancient Wisdom',
            'desc'  => 'Dosha-aligned herbal oils meet 5,000-year-old techniques for full-body rebalance.',
            'dur'   => '90–120 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=800&q=80',
        ],
        [
            'icon'  => '💆',
            'acc'   => 'indigo',
            'cat'   => 'Healing',
            'title' => 'Aromatherapy',
            'sub'   => 'Sensory Journey',
            'desc'  => 'Bespoke oil blends paired with feather-light touch for a profoundly calming experience.',
            'dur'   => '60 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?w=800&q=80',
        ],
        [
            'icon'  => '🛁',
            'acc'   => 'teal',
            'cat'   => 'Healing',
            'title' => 'Hydrotherapy',
            'sub'   => 'Water Therapy',
            'desc'  => 'Mineral-rich baths with targeted jets to reduce inflammation and invigorate the body.',
            'dur'   => '45 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1560750588-73207b1ef5b8?w=800&q=80',
        ],
        [
            'icon'  => '✨',
            'acc'   => 'orange',
            'cat'   => 'Facial',
            'title' => 'Facial Glow',
            'sub'   => 'Luminous Results',
            'desc'  => 'Deep cleanse, professional exfoliation, and layered hydration — all bespoke to your skin.',
            'dur'   => '45–60 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800&q=80',
        ],
        [
            'icon'  => '🧘',
            'acc'   => 'amber',
            'cat'   => 'Signature',
            'title' => 'Signature Retreat',
            'sub'   => '3-Hour Flagship',
            'desc'  => 'Massage + facial + body wrap — three uninterrupted hours of complete, private renewal.',
            'dur'   => '180 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?w=800&q=80',
        ],
        [
            'icon'  => '🌸',
            'acc'   => 'rose',
            'cat'   => 'Couples',
            'title' => "Couple's Retreat",
            'sub'   => 'Shared Sanctuary',
            'desc'  => 'Private twin-suite rituals side-by-side — tailored for two, perfect for any occasion.',
            'dur'   => '120 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800&q=80',
        ],
        [
            'icon'  => '💅',
            'acc'   => 'stone',
            'cat'   => 'Beauty',
            'title' => 'Nail & Polish',
            'sub'   => 'Refined Detail',
            'desc'  => 'Premium manicure and pedicure with nourishing treatments and expert shaping.',
            'dur'   => '30–60 min',
            'from'  => '',
            'img'   => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=800&q=80',
        ],
    ];

    $featuredIndex = 6;
    $visibleCount  = 6;
    $visible       = array_slice($services, 0, $visibleCount);

    // Defensive: if $featuredIndex points outside the available range, clamp it
    if ($featuredIndex < 0 || $featuredIndex >= count($services)) {
        $featuredIndex = 0;
    }

    // Encode services for Alpine to switch the featured panel client-side
    $jsServices = collect($services)->map(function ($s) use ($accents) {
        $a = $accents[$s['acc']];
        return [
            'title' => $s['title'],
            'sub'   => $s['sub'],
            'desc'  => $s['desc'],
            'dur'   => $s['dur'],
            'from'  => $s['from'],
            'img'   => $s['img'],
            'cat'   => $s['cat'],
            'price' => $a['price'],
        ];
    })->values();
@endphp

<section
    id="spa-types"
    class="mx-auto max-w-7xl px-6 py-12"
    x-data="spaTypes({
        services: {{ Js::from($jsServices) }},
        initial: {{ (int) $featuredIndex }},
    })"
    x-init="initObserver($el)"
>
    {{-- ─── Header ───────────────────────────────────────────── --}}
    <div class="mb-8 flex flex-wrap items-end justify-between gap-8">
        <div>
            <div class="mb-3 text-xs font-bold uppercase tracking-[0.18em] text-orange-600">
                Our Treatments
            </div>
            <h2 class="font-serif text-[clamp(2rem,4vw,3.2rem)] font-bold leading-tight text-slate-900">
                Curated for
                <span class="bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 bg-clip-text text-transparent">
                    Every Need
                </span>
            </h2>
        </div>
        <p class="max-w-[340px] text-sm leading-relaxed text-slate-500">
            Each treatment is designed as a complete experience — every detail attended to with care.
        </p>
    </div>

    {{-- ─── Body grid ────────────────────────────────────────── --}}
    <div class="grid items-start gap-6 lg:grid-cols-[300px_1fr]">

        {{-- ─── Featured panel ──────────────────────────────── --}}
        <div
            class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_16px_48px_rgba(0,0,0,0.08)] transition-all duration-300"
            :class="animating ? 'opacity-0 translate-y-2.5' : 'opacity-100 translate-y-0'"
        >
            {{-- Hero image --}}
            <div class="relative h-56 overflow-hidden">
                <img
                    :src="featured.img"
                    :alt="featured.title"
                    class="h-full w-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/10 to-transparent"></div>

                {{-- Featured badge --}}
                <div class="absolute left-3 top-3 rounded-full border border-white/30 bg-white/15 px-2.5 py-0.5 text-[10px] font-extrabold uppercase tracking-[0.18em] text-white backdrop-blur-md">
                    ✦ Featured
                </div>

                {{-- Title overlay --}}
                <div class="absolute inset-x-4 bottom-3.5">
                    <div class="mb-1 text-[10px] font-extrabold uppercase tracking-[0.2em] text-white/75"
                         x-text="featured.sub"></div>
                    <div class="font-serif text-[1.35rem] font-bold leading-tight text-white"
                         x-text="featured.title"></div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 pb-6 pt-5">
                <p class="mb-5 text-sm leading-relaxed text-slate-500"
                   x-text="featured.desc"></p>

           

                 
            </div>
        </div>

        {{-- ─── Card grid ───────────────────────────────────── --}}
        <div class="grid grid-cols-2 gap-3.5 md:grid-cols-3">
            @foreach ($visible as $i => $s)
                @php $a = $accents[$s['acc']]; @endphp
                <article
                    data-spa-card
                    data-spa-index="{{ $i }}"
                    @mouseenter="selectFeatured({{ $i }})"
                    @click="selectFeatured({{ $i }})"
                    @keydown.enter="selectFeatured({{ $i }})"
                    @keydown.space.prevent="selectFeatured({{ $i }})"
                    tabindex="0"
                    role="button"
                    :aria-pressed="featuredIndex === {{ $i }}"
                    class="group cursor-pointer overflow-hidden rounded-2xl border-[1.5px] bg-white opacity-0 translate-y-5
                           transition-all duration-300 ease-out
                           hover:-translate-y-[3px] hover:shadow-[0_12px_32px_rgba(0,0,0,0.1)] hover:border-orange-500/30
                           focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-500"
                    :class="featuredIndex === {{ $i }}
                            ? 'border-orange-500/50 shadow-[0_8px_28px_rgba(249,115,22,0.15)]'
                            : 'border-slate-200'"
                    style="--delay: {{ $i * 50 }}ms"
                >
                    {{-- Image --}}
                    <div class="relative h-[140px] overflow-hidden">
                        <img
                            src="{{ $s['img'] }}"
                            alt="{{ $s['title'] }}"
                            loading="lazy"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        />

                        {{-- "Selected" pill --}}
                        <div
                            x-show="featuredIndex === {{ $i }}"
                            x-transition.opacity
                            class="absolute right-2.5 top-2.5 rounded-full bg-orange-500 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider text-white"
                        >
                            Selected ✓
                        </div>

                        {{-- Category pill --}}
                        <div class="absolute bottom-2.5 left-2.5 rounded-full bg-black/45 px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.12em] text-white/90 backdrop-blur-md">
                            {{ $s['cat'] }}
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="px-4 py-3.5">
                        <h3 class="mb-1 text-sm font-bold leading-snug text-slate-900">
                            {{ $s['title'] }}
                        </h3>
                        <p class="mb-2.5 text-xs text-slate-400">{{ $s['sub'] }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-400">⏱ {{ $s['dur'] }}</span>
                            <span
                                class="text-sm font-extrabold"
                                :class="featuredIndex === {{ $i }} ? 'text-orange-500' : '{{ $a['price'] }}'"
                            >
                                {{ $s['from'] }}
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── Alpine component logic ───────────────────────────────── --}}
<script>
    
    function spaTypes({ services, initial }) {
        return {
            services: services,
            featuredIndex: initial,
            animating: false,

            get featured() {
                return this.services[this.featuredIndex] || this.services[0];
            },

            selectFeatured(index) {
                if (index === this.featuredIndex) return;
                this.animating = true;
                setTimeout(() => {
                    this.featuredIndex = index;
                    this.animating = false;
                }, 240);
            },

            initObserver(root) {
                const cards = root.querySelectorAll('[data-spa-card]');
                if (!('IntersectionObserver' in window)) {
                    cards.forEach(c => { c.style.opacity = 1; c.style.transform = 'none'; });
                    return;
                }
                const io = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const el = entry.target;
                            const delay = el.style.getPropertyValue('--delay') || '0ms';
                            el.style.transitionDelay = delay;
                            el.style.opacity = 1;
                            el.style.transform = 'translateY(0)';
                            io.unobserve(el);
                        }
                    });
                }, { threshold: 0.07 });

                cards.forEach(c => io.observe(c));
            },
        };
    }
</script>