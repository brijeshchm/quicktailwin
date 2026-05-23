 

@php
    $services = [
        [
            'icon'  => '✂️',
            'title' => 'Haircut & Styling',
            'desc'  => 'Precision cuts tailored to your face shape. Bob, pixie, layers, or classic — our stylists craft your perfect shape.',
            'price' => 'From ₹500',
            'tag'   => 'Most Popular',
            'slug'  => 'haircut-styling',
            'img'   => 'https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?w=800&q=80',
        ],
        [
            'icon'  => '🎨',
            'title' => 'Hair Coloring',
            'desc'  => 'Global color, balayage, highlights, ombre, or fashion hues. Premium international brands only.',
            'price' => 'From ₹1,500',
            'tag'   => 'Trending',
            'slug'  => 'hair-coloring',
            'img'   => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?w=800&q=80',
        ],
        [
            'icon'  => '✨',
            'title' => 'Keratin Treatment',
            'desc'  => 'Smooth, frizz-free hair for 3–6 months. Formaldehyde-free Brazilian keratin, customized for Indian hair.',
            'price' => 'From ₹3,500',
            'tag'   => 'Top Rated',
            'slug'  => 'keratin-treatment',
            'img'   => 'https://images.unsplash.com/photo-1500840216050-6ffa99d75160?w=800&q=80',
        ],
        [
            'icon'  => '👰',
            'title' => 'Bridal Makeup',
            'desc'  => 'Complete bridal look — airbrush foundation, eye artistry, contouring. Trial session included.',
            'price' => 'From ₹8,000',
            'tag'   => 'Signature',
            'slug'  => 'bridal-makeup',
            'img'   => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&q=80',
        ],
        [
            'icon'  => '💃',
            'title' => 'Party Makeup',
            'desc'  => 'Glamorous event looks for receptions, engagements, and sangeets. Long-wear formulas, high-def finish.',
            'price' => 'From ₹2,000',
            'tag'   => '',
            'slug'  => 'party-makeup',
            'img'   => 'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?w=800&q=80',
        ],
        [
            'icon'  => '💅',
            'title' => 'Nail Art',
            'desc'  => 'Gel manicure, pedicure, nail extensions, 3D nail art, chrome powder, press-ons. Full nail care.',
            'price' => 'From ₹600',
            'tag'   => '',
            'slug'  => 'nail-art',
            'img'   => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=800&q=80',
        ],
        [
            'icon'  => '🌿',
            'title' => 'Hair Spa',
            'desc'  => 'Deep-conditioning Moroccan argan oil or Kerastase treatments. Scalp massage + steam.',
            'price' => 'From ₹800',
            'tag'   => '',
            'slug'  => 'hair-spa',
            'img'   => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=800&q=80',
        ],
        [
            'icon'  => '👁️',
            'title' => 'Eyebrow Threading & Tint',
            'desc'  => 'Microblading-style precision threading plus brow lamination and HD brow tinting.',
            'price' => 'From ₹200',
            'tag'   => '',
            'slug'  => 'eyebrow-threading',
            'img'   => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=800&q=80',
        ],
        [
            'icon'  => '🌸',
            'title' => 'Facial & Skincare',
            'desc'  => 'Gold facial, O3+ vitamin C brightening, anti-aging collagen, and deep pore cleansing sessions.',
            'price' => 'From ₹1,000',
            'tag'   => '',
            'slug'  => 'facial-skincare',
            'img'   => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800&q=80',
        ],
    ];
@endphp

<section
    class="mx-auto max-w-7xl px-6 py-20"
    x-data
    x-init="
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.setAttribute('data-in', 'true');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.08 });
        $el.querySelectorAll('[data-reveal]').forEach(el => obs.observe(el));
    "
>
    {{-- ─── Local keyframes (Tailwind doesn't ship these natively) ─── --}}
    <style>
        /* Card entrance */
        [data-reveal]                  { opacity: 0; transform: translateY(40px); transition: opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1); }
        [data-reveal][data-in="true"]  { opacity: 1; transform: translateY(0); }

        /* Tag badge pulse */
        @keyframes salonTagPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(225,29,72,0.5); }
            50%      { box-shadow: 0 0 0 6px rgba(225,29,72,0); }
        }
        .salon-tag-pulse { animation: salonTagPulse 2.4s ease-in-out infinite; }

        /* Header title gradient sweep */
        @keyframes salonGradSweep {
            0%   { background-position:   0% 50%; }
            100% { background-position: 200% 50%; }
        }
        .salon-title-shimmer {
            background: linear-gradient(90deg, #1c1917 0%, #e11d48 50%, #1c1917 100%);
            background-size: 200% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: salonGradSweep 6s linear infinite;
        }

        /* "Book Now" arrow shimmer on card hover */
        @keyframes salonArrowSlide {
            0%   { transform: translateX(0); }
            50%  { transform: translateX(4px); }
            100% { transform: translateX(0); }
        }
        .group:hover .salon-arrow { animation: salonArrowSlide 0.7s ease-in-out infinite; }

        /* Icon gentle rock on hover */
        @keyframes salonIconRock {
            0%, 100% { transform: rotate(0deg) scale(1.1); }
            25%      { transform: rotate(-8deg) scale(1.1); }
            75%      { transform: rotate(8deg)  scale(1.1); }
        }
        .group:hover .salon-icon { animation: salonIconRock 1.2s ease-in-out infinite; }

        /* Animated border glow ring */
        @keyframes salonBorderGlow {
            0%, 100% { box-shadow: 0 16px 40px rgba(225,29,72,0.10), 0 0 0 0 rgba(225,29,72,0.0); }
            50%      { box-shadow: 0 16px 40px rgba(225,29,72,0.18), 0 0 0 4px rgba(225,29,72,0.08); }
        }
        .group:hover { animation: salonBorderGlow 2.4s ease-in-out infinite; }

        /* Tag entrance bounce */
        @keyframes salonTagIn {
            0%   { opacity: 0; transform: translateY(-8px) scale(0.8); }
            70%  { opacity: 1; transform: translateY(2px)  scale(1.05); }
            100% { opacity: 1; transform: translateY(0)    scale(1); }
        }
    </style>

    {{-- ─── Header ───────────────────────────────────── --}}
    <div class="mb-14 text-center" data-reveal>
        <div class="mb-2.5 text-[0.62rem] font-extrabold uppercase tracking-[0.24em] text-rose-600">
            What We Offer
        </div>
        <h2 class="mb-4 font-serif text-[clamp(2rem,4vw,3.2rem)] font-bold leading-tight">
            <span class="salon-title-shimmer">Our Services</span>
        </h2>
        <p class="mx-auto max-w-xl text-base leading-relaxed text-stone-500">
            Expert treatments using premium international brands. Every service is crafted to enhance your natural beauty.
        </p>
    </div>

    {{-- ─── Cards grid ───────────────────────────────── --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($services as $i => $s)
            <article
                data-reveal
                style="transition-delay: {{ $i * 80 }}ms;"
                class="group relative cursor-default overflow-hidden rounded-[24px] border-[1.5px] border-slate-200 bg-white transition-all duration-500 ease-out
                       hover:-translate-y-2 hover:border-rose-500/40"
            >
                {{-- ─── Image header (with zoom on hover) ─── --}}
                <div class="relative h-44 overflow-hidden">
                    <img
                        src="{{ $s['img'] }}"
                        alt="{{ $s['title'] }}"
                        loading="lazy"
                        class="h-full w-full object-cover transition-all duration-[1200ms] ease-out group-hover:scale-110 group-hover:brightness-110"
                    >

                    {{-- Dark gradient for text legibility --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/5 to-transparent"></div>

                    {{-- Rose tint that fades in on hover --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-600/0 via-rose-600/0 to-rose-600/0 transition-all duration-500 group-hover:from-rose-600/20 group-hover:via-rose-600/5 group-hover:to-transparent"></div>

                    {{-- Floating icon badge (bottom-left of image, half overlapping body) --}}
                    <div
                        class="salon-icon absolute -bottom-6 left-5 flex h-[52px] w-[52px] items-center justify-center rounded-2xl bg-gradient-to-br from-rose-600 to-rose-700 text-2xl shadow-lg shadow-rose-600/40 transition-transform duration-300 group-hover:scale-110"
                    >
                        {{ $s['icon'] }}
                    </div>

                    {{-- Tag badge — pulses if present --}}
                    @if (!empty($s['tag']))
                        <div
                            class="absolute right-4 top-4 rounded-full border border-white/40 bg-rose-600/95 px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.12em] text-white backdrop-blur-md salon-tag-pulse"
                            style="animation: salonTagIn 0.6s cubic-bezier(.34,1.56,.64,1) backwards, salonTagPulse 2.4s ease-in-out infinite; animation-delay: {{ ($i * 80) + 300 }}ms, {{ ($i * 80) + 900 }}ms;"
                        >
                            {{ $s['tag'] }}
                        </div>
                    @endif
                </div>

                {{-- ─── Body ─── --}}
                <div class="px-6 pb-6 pt-9">
                    {{-- Title --}}
                    <h3 class="mb-2 font-serif text-[1.15rem] font-bold leading-snug text-stone-900 transition-colors duration-300 group-hover:text-rose-700">
                        {{ $s['title'] }}
                    </h3>

                    {{-- Description --}}
                    <p class="mb-5 text-[13px] leading-relaxed text-stone-500">
                        {{ $s['desc'] }}
                    </p>

                    {{-- Bottom row --}}
                    <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                        {{-- Price --}}
                        <div class="text-sm font-extrabold text-stone-800 transition-all duration-300 group-hover:scale-110 group-hover:text-rose-600">
                            {{ $s['price'] }}
                        </div>

                        {{-- Book Now → shimmer-arrow link --}}
                        <a
                            href="{{ url('/book?service=' . urlencode($s['slug'])) }}"
                            class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3.5 py-1.5 text-[11px] font-extrabold uppercase tracking-wider text-rose-700 transition-all duration-300
                                   hover:bg-rose-600 hover:text-white hover:shadow-md hover:shadow-rose-600/40
                                   group-hover:bg-rose-600 group-hover:text-white group-hover:shadow-md group-hover:shadow-rose-600/40"
                        >
                            Book Now
                            <span class="salon-arrow" aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>

                {{-- Bottom-edge gradient line (fades in on hover) --}}
                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-rose-500 via-rose-600 to-rose-700 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            </article>
        @endforeach
    </div>
</section>