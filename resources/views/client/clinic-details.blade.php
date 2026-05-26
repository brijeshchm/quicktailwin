@extends('client.layouts.app')
@section('title', $metaTitle ?? 'Find Top Clinics & Doctors Near You | Aura Health')
@section('description', $metaDescription ?? 'Book verified specialists across India. Compare clinics by rating, location & specialty. Trusted by 10k+ patients.')
@section('keyword', $metaKeywords ?? 'Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you')
@section('content')	 
 
@include('client.components.banner-section')
 



 {{-- 🔑 Tailwind config MUST come BEFORE the CDN script --}}
    <script>
        window.tailwind = window.tailwind || {};
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:     { DEFAULT: '#1a4731', foreground: '#ffffff' },
                        accent:      { DEFAULT: '#d4a843', foreground: '#1a4731' },
                        background:  '#ffffff',
                        foreground:  '#1a1a1a',
                        muted:       { DEFAULT: '#f4f1ec', foreground: '#6b6258' },
                        sidebar:     '#f9f7f4',
                        border:      '#e4ddd2',
                        card:        { DEFAULT: '#ffffff', foreground: '#1a1a1a' },
                        destructive: { DEFAULT: '#dc2626', foreground: '#ffffff' },
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans:  ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>

    {{-- Now load Tailwind --}}
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    {{-- Alpine.js (with intersect plugin) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Custom CSS (NO @apply, NO @layer) --}}
    <style>
         
        .font-serif { font-family: 'Playfair Display', Georgia, serif; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .tabular-nums { font-variant-numeric: tabular-nums; }
    </style>
  
 
<div x-data="clinicDetail()" x-init="init()" class="min-h-screen bg-[#f9f7f4]">

    {{-- ═══════════════ HERO ═══════════════ --}}
    <div class="relative h-[58vh] min-h-[420px] overflow-hidden">
        <div class="absolute inset-0" :style="`transform: translateY(${parallaxY}px); will-change: transform`">
            @if ($clinic->cover_image_url)
                <img src="{{ $clinic->cover_image_url }}" alt="{{ $clinic->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-primary/80 to-primary"></div>
            @endif
        </div>

        <div class="absolute inset-0 bg-gradient-to-t from-[#0d1b2a] via-[#0d1b2a]/60 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#0d1b2a]/40 to-transparent"></div>

        <div class="absolute inset-0 flex flex-col justify-end pb-8" :style="`opacity: ${heroOpacity}`">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 w-full">
                <div class="flex flex-col md:flex-row md:items-end gap-6">

                    {{-- Logo --}}
                    <div class="w-24 h-24 md:w-28 md:h-28 rounded-2xl overflow-hidden border-4 border-white/90 shadow-2xl bg-white shrink-0">
                        @if ($clinic->logo_url)
                            <img src="{{ $clinic->logo_url }}" alt="{{ $clinic->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-3xl font-bold text-primary">
                                {{ substr($clinic->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    {{-- Title + tags --}}
                    <div class="flex-1">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold bg-white/15 backdrop-blur-sm text-white border border-white/25 px-3 py-1 rounded-full">
                                <i data-lucide="sparkles" class="w-3 h-3"></i> {{ $clinic->specialty }}
                            </span>
                            @if ($clinic->years_in_operation)
                                <span class="inline-flex items-center gap-1.5 text-xs font-medium bg-white/10 backdrop-blur-sm text-white/90 border border-white/20 px-3 py-1 rounded-full">
                                    <i data-lucide="calendar" class="w-3 h-3"></i> Est. {{ now()->year - $clinic->years_in_operation }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium bg-green-400/20 backdrop-blur-sm text-green-200 border border-green-400/30 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> Open Now
                            </span>
                        </div>

                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-serif text-white leading-tight mb-2">
                            {{ $clinic->name }}
                        </h1>
                        <p class="text-lg text-white/75 font-light max-w-2xl">
                            {{ $clinic->tagline ?? Str::limit($clinic->about, 100) }}
                        </p>
                    </div>

                    {{-- Rating + CTA --}}
                    <div class="shrink-0 flex flex-col items-start md:items-end gap-3">
                        <div class="text-right">
                            <div class="flex items-center gap-2 justify-end">
                                <div class="flex gap-0.5">
                                    @for ($s = 1; $s <= 5; $s++)
                                        <i data-lucide="star"
                                           class="w-5 h-5 {{ $s <= round($clinic->rating) ? 'fill-accent text-accent' : 'text-white/30' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-2xl font-bold text-white">{{ number_format($clinic->rating, 1) }}</span>
                            </div>
                            <p class="text-white/60 text-sm mt-0.5">{{ number_format($clinic->review_count) }} patient reviews</p>
                        </div>
                        @if ($clinic->doctors->isNotEmpty())
                            <a href=""
                               class="inline-flex items-center gap-2 bg-accent hover:bg-accent/90 text-primary font-semibold px-8 py-3 rounded-lg shadow-xl shadow-accent/30 text-base transition-all">
                                Book Appointment <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════ STICKY NAV ═══════════════ --}}
    <div class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-border/50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center overflow-x-auto" style="scrollbar-width: none">
                <template x-for="section in sections" :key="section">
                    <button @click="scrollTo(section)"
                            :class="activeSection === section ? 'text-primary' : 'text-muted-foreground hover:text-foreground'"
                            class="relative shrink-0 px-5 py-4 text-sm font-medium transition-colors capitalize">
                        <span x-text="section"></span>
                        <span x-show="activeSection === section"
                              class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    {{-- ═══════════════ STATS ROW ═══════════════ --}}
    <div class="bg-white border-b border-border/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach ([
                    ['icon' => 'users',        'value' => $stats['patients'],     'suffix' => '+', 'label' => 'Patients Served'],
                    ['icon' => 'stethoscope',  'value' => $stats['doctors'],      'suffix' => '',  'label' => 'Specialists'],
                    ['icon' => 'alarm-clock',  'value' => $stats['wait_time'],    'suffix' => 'm', 'label' => 'Avg Wait Time'],
                    ['icon' => 'heart-pulse',  'value' => $stats['satisfaction'], 'suffix' => '%', 'label' => 'Satisfaction'],
                ] as $stat)
                    <div x-data="counter({{ $stat['value'] }})" x-intersect.once="animate()"
                         class="flex flex-col items-center text-center p-4 rounded-2xl bg-[#f9f7f4]">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 text-primary mb-2"></i>
                        <div class="text-3xl font-bold text-foreground tabular-nums">
                            <span x-text="Math.floor(current).toLocaleString()">0</span>{{ $stat['suffix'] }}
                        </div>
                        <div class="text-xs font-medium text-muted-foreground uppercase tracking-wider mt-1">
                            {{ $stat['label'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ═══════════════ MAIN + SIDEBAR ═══════════════ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-10">

                {{-- ───── OVERVIEW ───── --}}
                <section id="section-overview">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-1 h-7 rounded-full bg-primary"></div>
                        <h2 class="text-2xl font-bold font-serif text-foreground">About {{ $clinic->name }}</h2>
                    </div>

                    <div class="bg-white rounded-2xl border border-border/50 p-6 shadow-sm">
                        <p class="text-foreground/80 leading-relaxed text-[15px]">{{ $clinic->about }}</p>

                        <div class="mt-6 pt-6 border-t border-border/50 grid sm:grid-cols-2 gap-5">
                            <div>
                                <h4 class="font-semibold text-foreground mb-3 flex items-center gap-2">
                                    <i data-lucide="wifi" class="w-4 h-4 text-primary"></i> Amenities & Services
                                </h4>
                                <ul class="space-y-2">
                                    @foreach (($clinic->amenities ?? []) as $a)
                                        <li class="flex items-center gap-2 text-sm text-muted-foreground">
                                            <i data-lucide="check-circle-2" class="w-4 h-4 text-green-500 shrink-0"></i>
                                            {{ $a }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-semibold text-foreground mb-3 flex items-center gap-2">
                                    <i data-lucide="activity" class="w-4 h-4 text-primary"></i> Accepted Insurance
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (($clinic->insurances ?? []) as $ins)
                                        <span class="text-xs font-medium bg-primary/5 border border-primary/20 text-primary px-2.5 py-1 rounded-md">
                                            {{ $ins }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ───── ACCREDITATIONS ───── --}}
                <section id="section-accreditations">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-1 h-7 rounded-full bg-primary"></div>
                        <h2 class="text-2xl font-bold font-serif text-foreground">Accreditations & Certifications</h2>
                    </div>
                    <p class="text-muted-foreground text-sm mb-6 ml-4">
                        Recognized by leading healthcare regulatory bodies for excellence and patient safety.
                    </p>

                    <div class="space-y-4">
                        @foreach ($clinic->accreditations as $i => $acc)
                            <div x-data="{ shown: false }"
                                 x-intersect.once="setTimeout(() => shown = true, {{ $i * 80 }})"
                                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-1 translate-y-3'"
                                 class="group relative flex items-start gap-4 p-5 rounded-2xl border border-border/60 bg-white shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-500">
                                <div class="shrink-0 w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                    <i data-lucide="shield-check" class="w-6 h-6 text-primary"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-foreground leading-tight">{{ $acc->name }}</p>
                                    <p class="text-sm text-muted-foreground mt-0.5">{{ $acc->issuing_body }}</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-xs font-medium text-primary border border-primary/30 bg-primary/5 px-2 py-0.5 rounded-md">Since {{ $acc->year }}</span>
                                        @if ($acc->expiry_year)
                                            <span class="text-xs text-muted-foreground border border-border px-2 py-0.5 rounded-md">Valid until {{ $acc->expiry_year }}</span>
                                        @endif
                                    </div>
                                </div>
                                <i data-lucide="badge-check" class="shrink-0 w-5 h-5 text-accent opacity-80 mt-0.5"></i>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 grid grid-cols-3 gap-3">
                        @foreach ([
                            ['icon' => 'award',        'label' => 'Award-Winning Care'],
                            ['icon' => 'shield-check', 'label' => 'Internationally Certified'],
                            ['icon' => 'sparkles',     'label' => 'Top-Rated Facility'],
                        ] as $t)
                            <div class="flex flex-col items-center gap-2 p-4 rounded-xl bg-primary/5 border border-primary/10 text-center">
                                <i data-lucide="{{ $t['icon'] }}" class="w-5 h-5 text-primary"></i>
                                <span class="text-xs font-semibold text-foreground">{{ $t['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- ───── SPECIALISTS ───── --}}
                <section id="section-specialists">
                    <div class="flex items-center justify-between gap-3 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-7 rounded-full bg-primary"></div>
                            <h2 class="text-2xl font-bold font-serif text-foreground">Our Specialists</h2>
                        </div>
                        @if ($clinic->doctors->isNotEmpty())
                            <span class="bg-primary/10 text-primary px-3 py-1 rounded-md text-sm font-medium">
                                {{ $clinic->doctors->count() }} Doctors
                            </span>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @foreach ($clinic->doctors as $i => $doctor)
                            <div x-data="{ shown: false }"
                                 x-intersect.once="setTimeout(() => shown = true, {{ $i * 90 }})"
                                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
                                 class="group relative flex flex-col sm:flex-row gap-5 p-5 rounded-2xl border border-border/60 bg-white shadow-sm hover:shadow-lg hover:border-primary/20 transition-all duration-500">

                                <div class="absolute top-4 right-4 w-2.5 h-2.5 rounded-full {{ $doctor->is_available_today ? 'bg-green-400' : 'bg-muted-foreground/30' }} ring-2 ring-white"
                                     title="{{ $doctor->is_available_today ? 'Available today' : 'Not available today' }}"></div>

                                <div class="shrink-0">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden border-2 border-border/50 bg-muted">
                                        @if ($doctor->image_url)
                                            <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-2xl font-bold text-primary/40">
                                                {{ $doctor->initials }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-start gap-2 mb-1">
                                        <h3 class="text-lg font-bold text-foreground">{{ $doctor->name }}</h3>
                                        <span class="text-xs text-muted-foreground border border-border px-2 py-0.5 rounded">{{ $doctor->title }}</span>
                                    </div>
                                    <p class="text-primary font-semibold text-sm">{{ $doctor->specialty }}</p>
                                    @if ($doctor->subspecialty)
                                        <p class="text-muted-foreground text-sm">{{ $doctor->subspecialty }}</p>
                                    @endif

                                    <div class="flex flex-wrap gap-4 mt-3 text-sm">
                                        <span class="flex items-center gap-1.5 text-muted-foreground">
                                            <i data-lucide="briefcase-medical" class="w-3.5 h-3.5"></i>
                                            {{ $doctor->years_experience }} yrs experience
                                        </span>
                                        <span class="flex items-center gap-1.5 text-muted-foreground">
                                            <i data-lucide="star" class="w-3.5 h-3.5 fill-accent text-accent"></i>
                                            {{ number_format($doctor->rating, 1) }} ({{ $doctor->review_count }})
                                        </span>
                                        <span class="flex items-center gap-1.5 text-muted-foreground">
                                            <i data-lucide="dollar-sign" class="w-3.5 h-3.5"></i>
                                            ${{ number_format($doctor->consultation_fee, 0) }} consult
                                        </span>
                                    </div>

                                    @if (!empty($doctor->languages))
                                        <div class="flex items-center gap-1.5 mt-2 text-sm text-muted-foreground">
                                            <i data-lucide="languages" class="w-3.5 h-3.5"></i>
                                            {{ implode(', ', $doctor->languages) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="shrink-0 flex sm:flex-col items-center sm:items-end justify-between gap-2 sm:pt-1">
                                    @if ($doctor->accepts_insurance)
                                        <span class="text-xs text-green-600 font-medium flex items-center gap-1">
                                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Insurance
                                        </span>
                                    @endif
                                    <a href=""
                                       class="inline-flex items-center gap-1 bg-primary hover:bg-primary/90 text-white text-sm font-medium px-4 py-2 rounded-md transition-colors">
                                        Book <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- ───── REVIEWS ───── --}}
                <section id="section-reviews">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-1 h-7 rounded-full bg-primary"></div>
                        <h2 class="text-2xl font-bold font-serif text-foreground">Patient Reviews</h2>
                    </div>

                    {{-- Rating overview --}}
                    <div class="bg-white rounded-2xl border border-border/50 p-6 shadow-sm mb-6">
                        <div class="flex flex-col sm:flex-row gap-8">
                            <div class="shrink-0 flex flex-col items-center justify-center p-4 rounded-xl bg-[#f9f7f4] min-w-[130px]">
                                <div class="text-5xl font-bold text-foreground mb-2">{{ number_format($avgRating, 1) }}</div>
                                <div class="flex gap-0.5 mb-2">
                                    @for ($s = 1; $s <= 5; $s++)
                                        <i data-lucide="star"
                                           class="w-5 h-5 {{ $s <= round($avgRating) ? 'fill-accent text-accent' : 'text-muted-foreground/25' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-sm text-muted-foreground font-medium">{{ number_format($clinic->review_count) }} reviews</p>
                            </div>

                            <div class="flex-1 space-y-2.5">
                                @php $total = $clinic->reviews->count(); @endphp
                                @foreach ([5, 4, 3, 2, 1] as $r)
                                    @php
                                        $count = $ratingCounts[$r];
                                        $pct = $total > 0 ? round(($count / $total) * 100) : 0;
                                        $color = $r >= 4 ? 'bg-accent' : ($r === 3 ? 'bg-amber-300' : 'bg-muted-foreground/30');
                                    @endphp
                                    <div x-data="{ width: 0 }" x-intersect.once="setTimeout(() => width = {{ $pct }}, 100)"
                                         class="flex items-center gap-3">
                                        <span class="text-sm text-muted-foreground w-16 text-right shrink-0">{{ $r }} star{{ $r > 1 ? 's' : '' }}</span>
                                        <div class="flex-1 h-2 bg-muted/50 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ $color }} transition-all duration-1000 ease-out"
                                                 :style="`width: ${width}%`"></div>
                                        </div>
                                        <span class="text-sm font-medium w-8 shrink-0">{{ $count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Review list --}}
                    @php $colors = ['bg-blue-100 text-blue-700','bg-teal-100 text-teal-700','bg-violet-100 text-violet-700','bg-amber-100 text-amber-700','bg-rose-100 text-rose-700']; @endphp
                    <div class="space-y-4">
                        @foreach ($clinic->reviews as $review)
                            <div class="p-5 rounded-2xl border border-border/60 bg-white shadow-sm hover:shadow-md transition-all duration-300">
                                <div class="flex items-start gap-4">
                                    <div class="shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold {{ $colors[$review->id % count($colors)] }}">
                                        {{ $review->initials }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <span class="font-semibold text-foreground">{{ $review->patient_name }}</span>
                                            @if ($review->is_verified)
                                                <span class="inline-flex items-center gap-1 text-xs text-primary font-medium bg-primary/10 px-2 py-0.5 rounded-full border border-primary/20">
                                                    <i data-lucide="badge-check" class="w-3 h-3"></i> Verified Patient
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="flex gap-0.5">
                                                @for ($s = 1; $s <= 5; $s++)
                                                    <i data-lucide="star"
                                                       class="w-4 h-4 {{ $s <= $review->rating ? 'fill-accent text-accent' : 'text-muted-foreground/30' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-muted-foreground">{{ $review->review_date->format('F j, Y') }}</span>
                                        </div>
                                        @if ($review->title)
                                            <p class="font-semibold text-sm mb-1">{{ $review->title }}</p>
                                        @endif
                                        <p class="text-sm text-muted-foreground leading-relaxed">{{ $review->comment }}</p>
                                        @if ($review->helpful_count > 0)
                                            <div class="flex items-center gap-1.5 mt-3 text-xs text-muted-foreground">
                                                <i data-lucide="thumbs-up" class="w-3.5 h-3.5"></i>
                                                <span>{{ $review->helpful_count }} people found this helpful</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 text-center">
                        <a href=""
                           class="inline-flex items-center gap-1 border border-border px-4 py-2 rounded-md font-medium hover:bg-muted/30 transition-colors">
                            View All Reviews <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </section>

                {{-- ───── LOCATION ───── --}}
                <section id="section-location">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-1 h-7 rounded-full bg-primary"></div>
                        <h2 class="text-2xl font-bold font-serif text-foreground">Location & Directions</h2>
                    </div>

                    <div class="bg-white rounded-2xl border border-border/50 overflow-hidden shadow-sm">
                        {{-- Map placeholder --}}
                        <div class="h-52 bg-gradient-to-br from-blue-50 to-teal-50 relative flex items-center justify-center overflow-hidden">
                            <div class="relative flex flex-col items-center gap-2">
                                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center shadow-lg shadow-primary/30 animate-bounce">
                                    <i data-lucide="map-pin" class="w-6 h-6 text-white"></i>
                                </div>
                                <div class="bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2 shadow-md text-center">
                                    <p class="font-semibold text-sm text-foreground">{{ $clinic->name }}</p>
                                    <p class="text-xs text-muted-foreground">{{ $clinic->address }}, {{ $clinic->city }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 grid sm:grid-cols-2 gap-5">
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-primary mt-0.5 shrink-0"></i>
                                    <div>
                                        <p class="font-semibold text-sm text-foreground">Address</p>
                                        <p class="text-sm text-muted-foreground">{{ $clinic->address }}</p>
                                        <p class="text-sm text-muted-foreground">{{ $clinic->city }}</p>
                                    </div>
                                </div>
                                @if ($clinic->phone)
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="phone" class="w-5 h-5 text-primary shrink-0"></i>
                                        <a href="tel:{{ $clinic->phone }}" class="font-semibold text-sm text-foreground hover:text-primary">{{ $clinic->phone }}</a>
                                    </div>
                                @endif
                                @if ($clinic->email)
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="mail" class="w-5 h-5 text-primary shrink-0"></i>
                                        <a href="mailto:{{ $clinic->email }}" class="text-sm font-medium text-foreground hover:text-primary">{{ $clinic->email }}</a>
                                    </div>
                                @endif
                                @if ($clinic->website)
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="globe" class="w-5 h-5 text-primary shrink-0"></i>
                                        <a href="{{ $clinic->website }}" target="_blank" rel="noopener"
                                           class="text-sm font-medium text-primary hover:underline">
                                            {{ str_replace(['https://','http://'], '', $clinic->website) }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h4 class="font-semibold text-foreground mb-3 flex items-center gap-2 text-sm">
                                    <i data-lucide="clock" class="w-4 h-4 text-primary"></i> Opening Hours
                                </h4>
                                <div class="space-y-1.5">
                                    @php $today = now()->format('l'); @endphp
                                    @foreach (($clinic->opening_hours ?? []) as $h)
                                        @php $isToday = $h['day'] === $today; @endphp
                                        <div class="flex justify-between text-sm rounded-lg px-2.5 py-1 {{ $isToday ? 'bg-primary/10 font-semibold' : '' }}">
                                            <span class="{{ $isToday ? 'text-primary' : 'text-muted-foreground' }}">{{ $h['day'] }}</span>
                                            @if (!empty($h['is_closed']))
                                                <span class="text-red-500">Closed</span>
                                            @else
                                                <span class="{{ $isToday ? 'text-primary' : 'text-foreground font-medium' }}">
                                                    {{ $h['open'] }} – {{ $h['close'] }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- ═══════════════ SIDEBAR ═══════════════ --}}
            <aside class="space-y-5">
                <div class="sticky top-20 space-y-4"  >

                    {{-- Quick book card --}}
                    <div class="rounded-xl border bg-card text-card-foreground border-border/50 shadow-md overflow-hidden">
                        <div class="bg-gradient-to-br from-primary to-primary/80 p-5 text-white">
                            <h3 class="font-bold text-lg font-serif mb-1">Book Your Visit</h3>
                            <p class="text-white/75 text-sm">Reserve your appointment with a specialist today</p>
                        </div>
                        <div class="p-5 space-y-3">
                            @foreach ($clinic->doctors->take(3) as $doc)
                                <a href=""
                                   class="flex items-center gap-3 p-3 rounded-xl border border-border/50 hover:border-primary/30 hover:bg-primary/5 transition-all group">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-muted shrink-0">
                                        @if ($doc->image_url)
                                            <img src="{{ $doc->image_url }}" alt="{{ $doc->name }}" class="w-full h-full object-cover"> sss
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-sm font-bold text-primary/40">
                                                {{ $doc->initials }}
                                            </div>
                                        @endif 


                                        asdasd
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-sm text-foreground truncate">{{ $doc->name }}</p>
                                        <p class="text-xs text-muted-foreground truncate">{{ $doc->specialty }}</p>
                                    </div>
                                    <div class="w-2 h-2 rounded-full shrink-0 {{ $doc->is_available_today ? 'bg-green-400' : 'bg-muted-foreground/30' }}"></div>
                                </a>
                            @endforeach
                            @if ($clinic->doctors->isNotEmpty())
                                <a href=""
                                   class="flex items-center justify-center gap-2 w-full mt-2 bg-primary hover:bg-primary/90 text-white font-semibold text-sm py-3 rounded-lg transition-colors">
                                    <i data-lucide="calendar" class="w-4 h-4"></i> Schedule Appointment
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Why choose us --}}
                    <div class="rounded-2xl border border-border/50 shadow-sm bg-white p-5">
                        <h4 class="text-base font-semibold flex items-center gap-2 mb-4">
                            <i data-lucide="graduation-cap" class="w-4 h-4 text-primary"></i> Why Choose Us
                        </h4>
                        <div class="space-y-3 text-sm text-muted-foreground">
                            <div class="flex items-center gap-3">
                                <i data-lucide="shield-check" class="w-4 h-4 text-primary"></i>
                                <span>{{ $clinic->accreditations->count() }} major accreditations</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i data-lucide="users" class="w-4 h-4 text-primary"></i>
                                <span>{{ $clinic->years_in_operation ?? 10 }}+ years of experience</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i data-lucide="award" class="w-4 h-4 text-accent"></i>
                                <span>Award-winning specialists</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i data-lucide="heart-pulse" class="w-4 h-4 text-accent"></i>
                                <span>{{ $stats['satisfaction'] }}% patient satisfaction</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i data-lucide="activity" class="w-4 h-4 text-primary"></i>
                                <span>{{ count($clinic->insurances ?? []) }} insurance plans accepted</span>
                            </div>
                        </div>
                    </div>

                    {{-- Emergency banner --}}
                    @if ($clinic->phone)
                        <div class="p-4 rounded-xl border border-red-200 bg-red-50 text-center">
                            <p class="text-xs font-medium text-red-600 mb-1">Medical Emergency?</p>
                            <a href="tel:{{ $clinic->phone }}" class="text-lg font-bold text-foreground hover:text-red-600">{{ $clinic->phone }}</a>
                            <p class="text-xs text-muted-foreground mt-0.5">Call us immediately</p>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>

    {{-- ═══════════════ BOTTOM CTA ═══════════════ --}}
    <div class="bg-gradient-to-r from-primary to-primary/80 mt-12 py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold font-serif text-white mb-3">
                Ready to prioritize your health?
            </h2>
            <p class="text-white/75 text-lg mb-8 max-w-xl mx-auto">
                Book an appointment with one of our specialists at {{ $clinic->name }} today.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                @if ($clinic->doctors->isNotEmpty())
                    <a href=""
                       class="inline-flex items-center gap-2 bg-accent hover:bg-accent/90 text-primary font-semibold px-10 py-4 rounded-lg shadow-xl shadow-black/20 text-base transition-all">
                        Book Appointment <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                @endif
                @if ($clinic->phone)
                    <a href="tel:{{ $clinic->phone }}"
                       class="inline-flex items-center gap-2 border border-white/40 text-white hover:bg-white/10 font-semibold px-8 py-4 rounded-lg transition-all">
                        <i data-lucide="phone" class="w-4 h-4"></i> Call Now
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

 
<script>
function clinicDetail() {
    return {
        sections: ['overview', 'accreditations', 'specialists', 'reviews', 'location'],
        activeSection: 'overview',
        parallaxY: 0,
        heroOpacity: 1,

        init() {
            window.addEventListener('scroll', this.onScroll.bind(this), { passive: true });
            this.onScroll();
        },

        onScroll() {
            const y = window.scrollY;
            // Parallax (slower than scroll)
            this.parallaxY = y * 0.3;
            // Fade hero out as it scrolls
            this.heroOpacity = Math.max(0, 1 - (y / 400));
            // Active section detection
            for (const s of this.sections) {
                const el = document.getElementById(`section-${s}`);
                if (!el) continue;
                const rect = el.getBoundingClientRect();
                if (rect.top <= 150 && rect.bottom > 150) {
                    this.activeSection = s;
                    break;
                }
            }
        },

        scrollTo(section) {
            this.activeSection = section;
            const el = document.getElementById(`section-${section}`);
            if (el) {
                const offset = 80;
                window.scrollTo({ top: el.offsetTop - offset, behavior: 'smooth' });
            }
        }
    }
}

function counter(target) {
    return {
        current: 0,
        target: target,
        animate() {
            const duration = 1500;
            const step = this.target / (duration / 16);
            const timer = setInterval(() => {
                this.current += step;
                if (this.current >= this.target) {
                    this.current = this.target;
                    clearInterval(timer);
                }
            }, 16);
        }
    }
}
</script>
 

 

 <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) lucide.createIcons();
        });
        document.addEventListener('alpine:initialized', () => {
            if (window.lucide) lucide.createIcons();
        });
    </script>


 

 
@endsection