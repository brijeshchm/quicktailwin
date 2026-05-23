 

@php
   
 
    $timezone = 'Asia/Kolkata';

    
    $contacts = [
        [
            'icon'      => '📍',
            'label'     => 'Address',
            'l1'        => '42 Lotus Garden Lane, Koregaon Park',
            'l2'        => 'Pune, Maharashtra – 411001',
            'href'      => 'https://maps.google.com/?q=Koregaon+Park+Pune',
            'cta'       => 'Get Directions',
            'color_key' => 'orange',
        ],
        [
            'icon'      => '📞',
            'label'     => 'Phone',
            'l1'        => '+91 98765 43210',
            'l2'        => '+91 20 2605 7890',
            'href'      => 'tel:+919876543210',
            'cta'       => 'Call Now',
            'color_key' => 'green',
        ],
        [
            'icon'      => '✉️',
            'label'     => 'Email',
            'l1'        => 'hello@serenityspa.in',
            'l2'        => 'bookings@serenityspa.in',
            'href'      => 'mailto:hello@serenityspa.in',
            'cta'       => 'Email Us',
            'color_key' => 'indigo',
        ],
        [
            'icon'      => '🌐',
            'label'     => 'Website',
            'l1'        => 'www.serenityspa.in',
            'l2'        => '@SerenitySpaIndia',
            'href'      => 'https://www.serenityspa.in',
            'cta'       => 'Visit Site',
            'color_key' => 'amber',
        ],
    ];

     
    $hours = [
        ['days' => [1, 2, 3, 4, 5], 'open' => 9,  'close' => 21, 'label' => 'Monday – Friday', 'time' => '9:00 AM – 9:00 PM'],
        ['days' => [6],             'open' => 8,  'close' => 22, 'label' => 'Saturday',        'time' => '8:00 AM – 10:00 PM'],
        ['days' => [0],             'open' => 10, 'close' => 20, 'label' => 'Sunday',          'time' => '10:00 AM – 8:00 PM'],
        ['days' => [],              'open' => 10, 'close' => 19, 'label' => 'Public Holidays', 'time' => '10:00 AM – 7:00 PM'],
    ];

    /*
    |--------------------------------------------------------------------------
    | Quick action buttons (bottom of right column)
    |--------------------------------------------------------------------------
    */
    $quickActions = [
        ['href' => 'tel:+919876543210',          'icon' => '📞',  'label' => 'Call Us'],
        ['href' => 'mailto:hello@serenityspa.in', 'icon' => '✉️',  'label' => 'Email Us'],
        ['href' => 'https://maps.google.com/?q=Koregaon+Park+Pune', 'icon' => '🗺️', 'label' => 'Directions'],
    ];

     
    $map = [
        'line1' => '42 Lotus Garden Lane',
        'line2' => 'Koregaon Park, Pune, Maharashtra – 411001',
        'href'  => 'https://maps.google.com/?q=Koregaon+Park+Pune',
    ];
    
  
     
    $isOpenNow    =  "";

    // Pre-built Tailwind class sets per color key.
    // Keeping all classes as full literal strings so Tailwind's JIT picks them up.
    $palette = [
        'orange' => [
            'icon_bg' => 'bg-orange-50',
            'text'    => 'text-orange-500',
            'border'  => 'border-orange-500/20',
            'cta_bg'  => 'bg-orange-50',
            'shadow'  => 'hover:shadow-orange-500/20',
            'accent'  => 'before:bg-orange-500',
        ],
        'green' => [
            'icon_bg' => 'bg-green-50',
            'text'    => 'text-green-500',
            'border'  => 'border-green-500/20',
            'cta_bg'  => 'bg-green-50',
            'shadow'  => 'hover:shadow-green-500/20',
            'accent'  => 'before:bg-green-500',
        ],
        'indigo' => [
            'icon_bg' => 'bg-indigo-50',
            'text'    => 'text-indigo-500',
            'border'  => 'border-indigo-500/20',
            'cta_bg'  => 'bg-indigo-50',
            'shadow'  => 'hover:shadow-indigo-500/20',
            'accent'  => 'before:bg-indigo-500',
        ],
        'amber' => [
            'icon_bg' => 'bg-amber-50',
            'text'    => 'text-amber-500',
            'border'  => 'border-amber-500/20',
            'cta_bg'  => 'bg-amber-50',
            'shadow'  => 'hover:shadow-amber-500/20',
            'accent'  => 'before:bg-amber-500',
        ],
    ];

    // Pre-encode hours for Alpine to recalculate "open now" client-side without a page reload
    $hoursForJs = array_map(fn($r) => [
        'days'  => $r['days'],
        'open'  => $r['open'],
        'close' => $r['close'],
    ], $hours);
@endphp

<section
    id="visit"
    class="mx-auto max-w-7xl px-6 py-12"
    x-data="businessInfo({
        hours:        {{ Js::from($hoursForJs) }},
        initialOpen:  {{ $isOpenNow ? 'true' : 'false' }},
        initialDow:   {{ (int) now($timezone)->dayOfWeek }},
        tzOffsetMin:  {{ now($timezone)->utcOffset() }},
    })"
    x-init="init($el); startTicker();"
>

    {{-- ─── Local keyframes (Tailwind doesn't ship custom keyframes by default) ─── --}}
    <style>
        @keyframes biPinFloat   { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        @keyframes biPinShadow  { 0%,100% { transform: scaleX(1); opacity: 0.4; } 50% { transform: scaleX(0.7); opacity: 0.2; } }
        @keyframes biPulseRing  { 0% { transform: scale(0.85); box-shadow: 0 0 0 0 rgba(34,197,94,0.5); } 70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(34,197,94,0); } 100% { transform: scale(0.85); box-shadow: 0 0 0 0 rgba(34,197,94,0); } }
        @keyframes biHoursGlow  { from { box-shadow: 0 0 0 0 rgba(249,115,22,0); } to { box-shadow: 0 0 14px 2px rgba(249,115,22,0.1); } }

        .bi-pin-float    { animation: biPinFloat   2.4s ease-in-out infinite; display: inline-block; }
        .bi-pin-shadow   { animation: biPinShadow  2.4s ease-in-out infinite; }
        .bi-pulse-ring   { animation: biPulseRing  2s   infinite; }
        .bi-hours-glow   { animation: biHoursGlow  3s   ease-in-out infinite alternate; }

        /* Card entrance — toggled via [data-bi-reveal][data-in] */
        [data-bi-reveal] { opacity: 0; transform: translateY(28px); transition: opacity 0.55s ease, transform 0.55s ease; }
        [data-bi-reveal][data-in="true"] { opacity: 1; transform: translateY(0); }

        /* Left accent bar on contact card hover */
        .bi-contact { position: relative; }
        .bi-contact::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
            border-radius: 4px 0 0 4px;
            transform: scaleY(0); transform-origin: bottom;
            transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
        }
        .bi-contact:hover::before { transform: scaleY(1); }
        .bi-contact:hover .bi-icon { transform: rotate(-8deg) scale(1.12); }
        .bi-icon { transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1); }
    </style>

    {{-- ─── Header ─────────────────────────────────────────── --}}
    <div class="mb-10 flex flex-wrap items-end justify-between gap-6">
        <div>
            <div class="mb-3 text-xs font-bold uppercase tracking-[0.18em] text-orange-600">
                Visit Us
            </div>
            <h2 class="font-serif text-[clamp(2rem,4vw,3.5rem)] font-bold leading-tight text-slate-900">
                Come Find
                <span class="bg-gradient-to-r from-amber-400 via-orange-500 to-amber-600 bg-clip-text text-transparent">
                    Serenity
                </span>
            </h2>
        </div>

        {{-- "Open Now" badge — reactive --}}
        <div
            class="flex flex-shrink-0 items-center gap-2.5 rounded-full border-[1.5px] px-5 py-2.5 transition-all"
            :class="isOpen
                ? 'bg-green-50 border-green-500/35 shadow-md shadow-green-500/15'
                : 'bg-red-50 border-red-500/30'"
        >
            <span
                class="inline-block h-2.5 w-2.5 flex-shrink-0 rounded-full"
                :class="isOpen ? 'bg-green-500 bi-pulse-ring' : 'bg-red-500'"
            ></span>
            <span
                class="text-[0.82rem] font-extrabold tracking-wide"
                :class="isOpen ? 'text-green-600' : 'text-red-600'"
                x-text="isOpen ? 'Open Now · Welcoming Guests' : 'Currently Closed'"
            ></span>
        </div>
    </div>

    {{-- ─── Body grid ──────────────────────────────────────── --}}
    <div class="grid items-start gap-8 md:grid-cols-2">

        {{-- ═══════════════════════════════════════════════
             LEFT COLUMN — Contact cards
        ═══════════════════════════════════════════════ --}}
        <div class="flex flex-col gap-3">
            @foreach ($contacts as $i => $c)
                @php $p = $palette[$c['color_key']]; @endphp
                <div
                    data-bi-reveal
                    style="transition-delay: {{ $i * 80 }}ms;"
                    class="bi-contact group flex flex-wrap items-center gap-4 overflow-hidden rounded-2xl border-[1.5px] border-slate-200 bg-white px-5 py-4 transition-all duration-300
                           hover:translate-x-1 hover:shadow-lg
                           {{ $p['shadow'] }} {{ $p['accent'] }}
                           sm:flex-nowrap"
                >
                    {{-- Icon --}}
                    <div class="bi-icon flex h-12 w-12 flex-shrink-0 items-center justify-center self-start rounded-2xl text-2xl sm:self-auto {{ $p['icon_bg'] }}">
                        {{ $c['icon'] }}
                    </div>

                    {{-- Text block --}}
                    <div class="min-w-0 flex-1">
                        <div class="mb-1 text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">
                            {{ $c['label'] }}
                        </div>
                        <div class="mb-0.5 truncate text-sm font-bold text-slate-900">
                            {{ $c['l1'] }}
                        </div>
                        <div class="text-xs text-slate-400">
                            {{ $c['l2'] }}
                        </div>
                    </div>

                    {{-- CTA --}}
                    <a
                        href="{{ $c['href'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-block whitespace-nowrap rounded-full border-[1.5px] px-4 py-2 text-center text-[0.7rem] font-extrabold uppercase tracking-wider transition-transform hover:scale-105
                               {{ $p['text'] }} {{ $p['border'] }} {{ $p['cta_bg'] }}
                               max-sm:w-full max-sm:flex-1"
                    >
                        {{ $c['cta'] }}
                    </a>
                </div>
            @endforeach
        </div>

        {{-- ═══════════════════════════════════════════════
             RIGHT COLUMN — Hours + Map + Quick Actions
        ═══════════════════════════════════════════════ --}}
        <div class="flex flex-col gap-4">

            {{-- ─── Hours card ──────────────────────────────── --}}
            <div
                data-bi-reveal
                style="transition-delay: 100ms;"
                class="rounded-3xl border-[1.5px] border-slate-200 bg-white p-6 shadow-[0_8px_32px_rgba(0,0,0,0.05)] sm:p-7"
            >
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="font-serif text-xl font-bold text-slate-900">Opening Hours</h3>
                    <span class="rounded-full border border-orange-500/20 bg-orange-50 px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-[0.18em] text-orange-600">
                        ⏱ Live
                    </span>
                </div>

                @foreach ($hours as $h)
                    <div
                        data-row-days="{{ json_encode($h['days']) }}"
                        class="mb-1.5 flex items-center justify-between rounded-xl px-4 py-3 transition-colors max-sm:flex-col max-sm:items-start max-sm:gap-0.5 max-sm:px-3.5 max-sm:py-3"
                        :class="isToday({{ json_encode($h['days']) }})
                            ? 'bg-gradient-to-br from-orange-500/[0.08] to-amber-500/[0.06] border border-orange-500/20 bi-hours-glow'
                            : ''"
                    >
                        <span
                            class="flex items-center gap-2 text-[0.88rem]"
                            :class="isToday({{ json_encode($h['days']) }})
                                ? 'font-bold text-orange-700'
                                : 'font-normal text-slate-600'"
                        >
                            {{ $h['label'] }}
                            <template x-if="isToday({{ json_encode($h['days']) }})">
                                <span class="rounded bg-orange-500 px-1.5 py-0.5 text-[0.58rem] font-extrabold uppercase tracking-wider text-white">
                                    TODAY
                                </span>
                            </template>
                        </span>
                        <span
                            class="text-[0.88rem] font-bold tabular-nums"
                            :class="isToday({{ json_encode($h['days']) }}) ? 'text-orange-500' : 'text-slate-900'"
                        >
                            {{ $h['time'] }}
                        </span>
                    </div>
                @endforeach

                <div class="mt-4 rounded-xl border border-orange-500/10 bg-gradient-to-br from-orange-50 to-amber-50 px-4 py-3 text-center text-[0.78rem] text-slate-500">
                    🌿 Walk-ins welcome · Call ahead on weekends for availability
                </div>
            </div>

            {{-- ─── Map card with floating pin ──────────────── --}}
            <div
                data-bi-reveal
                style="transition-delay: 180ms;"
                class="relative overflow-hidden rounded-[20px] border-[1.5px] border-orange-500/20 bg-gradient-to-br from-orange-50 to-amber-100 p-6"
            >
                {{-- Grid texture --}}
                <div
                    class="absolute inset-0 opacity-[0.05]"
                    style="background-image: linear-gradient(rgba(249,115,22,1) 1px,transparent 1px),linear-gradient(90deg,rgba(249,115,22,1) 1px,transparent 1px); background-size: 28px 28px;"
                ></div>
                {{-- Decorative blobs --}}
                <div class="absolute -top-8 -right-8 h-32 w-32 rounded-full bg-orange-500/[0.07]"></div>
                <div class="absolute -bottom-5 left-5 h-20 w-20 rounded-full bg-amber-500/[0.06]"></div>

                <div class="relative flex items-center gap-6 max-sm:flex-col max-sm:items-start max-sm:gap-4">
                    {{-- Floating pin --}}
                    <div class="flex-shrink-0 text-center">
                        <div class="bi-pin-float">
                            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-orange-500 to-orange-600 text-2xl shadow-lg shadow-orange-500/40">
                                📍
                            </div>
                        </div>
                        <div class="bi-pin-shadow mx-auto mt-1.5 h-1.5 w-5 rounded-full bg-black/[0.12]"></div>
                    </div>

                    {{-- Address --}}
                    <div class="min-w-0 flex-1">
                        <div class="mb-1 text-[0.95rem] font-extrabold text-slate-900">
                            {{ $map['line1'] }}
                        </div>
                        <div class="mb-3.5 text-[0.82rem] text-slate-500">
                            {{ $map['line2'] }}
                        </div>
                        <a
                            href="{{ $map['href'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 rounded-full bg-orange-500 px-4 py-1.5 text-[0.72rem] font-extrabold uppercase tracking-wider text-white shadow-md shadow-orange-500/40 transition-transform hover:scale-105"
                        >
                            Open in Maps →
                        </a>
                    </div>
                </div>
            </div>

            {{-- ─── Quick action strip ──────────────────────── --}}
            <div
                data-bi-reveal
                style="transition-delay: 260ms;"
                class="flex gap-2.5 max-sm:flex-col"
            >
                @foreach ($quickActions as $a)
                    <a
                        href="{{ $a['href'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex flex-1 items-center gap-3.5 rounded-2xl border-[1.5px] border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-900 transition-all duration-200
                               hover:-translate-y-0.5 hover:border-orange-500 hover:text-orange-600 hover:shadow-lg hover:shadow-orange-500/15
                               justify-center max-sm:w-full max-sm:justify-start"
                    >
                        <span class="text-lg">{{ $a['icon'] }}</span>
                        <span>{{ $a['label'] }}</span>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     ALPINE COMPONENT LOGIC
═══════════════════════════════════════════════════════════ --}}
<script>
    function businessInfo({ hours, initialOpen, initialDow, tzOffsetMin }) {
        return {
            hours,
            isOpen: initialOpen,
            todayDow: initialDow,
            tzOffsetMin,   // business TZ offset in minutes (from server)

            /* Returns the current Date in the business's timezone */
            businessNow() {
                const now = new Date();
                // Shift "now" by the difference between user TZ and business TZ
                const userOffset = -now.getTimezoneOffset();   // user TZ offset (min)
                const diff       = this.tzOffsetMin - userOffset;
                return new Date(now.getTime() + diff * 60 * 1000);
            },

            recalc() {
                const now = this.businessNow();
                this.todayDow = now.getDay();   // 0=Sun
                const h = now.getHours();

                const row = this.hours.find(r => r.days.includes(this.todayDow));
                this.isOpen = !!row && h >= row.open && h < row.close;
            },

            isToday(daysArray) {
                if (!Array.isArray(daysArray) || daysArray.length === 0) return false;
                return daysArray.includes(this.todayDow);
            },

            /* Re-check open status every minute so the badge stays accurate
               on long-open tabs (e.g. user leaves the page open from 8:55 → 9:05). */
            startTicker() {
                setInterval(() => this.recalc(), 60 * 1000);
            },

            /* Scroll-reveal staggered entrance */
            init(root) {
                const els = root.querySelectorAll('[data-bi-reveal]');
                if (!('IntersectionObserver' in window)) {
                    els.forEach(el => el.setAttribute('data-in', 'true'));
                    return;
                }
                const io = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.setAttribute('data-in', 'true');
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.06 });
                els.forEach(el => io.observe(el));
            },
        };
    }
</script>
