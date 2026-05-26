@extends('client.layouts.app')
@section('title', $metaTitle ?? 'Find Top Clinics & Doctors Near You | Aura Health')
@section('description', $metaDescription ?? 'Book verified specialists across India. Compare clinics by rating, location & specialty. Trusted by 10k+ patients.')
@section('keyword', $metaKeywords ?? 'Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you')
@section('content')	 
 
@include('client.components.banner-section')
 
 

<div class="flex flex-col min-h-screen">

    {{-- ============ HERO ============ --}}
    <section class="relative bg-gradient-to-b from-sidebar to-white pt-16 sm:pt-24 pb-20 sm:pb-32 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-40 -left-40 w-96 h-96 bg-accent/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="container relative z-10 max-w-5xl text-center">
            <div 
                 class="transition-all duration-700">

                <span class="inline-block mb-6 bg-primary/10 text-primary px-4 py-1.5 rounded-full text-sm font-medium">
                    Aura Health Concierge
                </span>

                <h1 class="text-4xl sm:text-5xl md:text-7xl font-bold font-serif tracking-tight mb-6">
                    World-Class Healthcare,<br class="hidden md:block">
                    <span class="text-primary italic font-light">Curated for You.</span>
                </h1>

                <p class="text-lg sm:text-xl text-muted-foreground mb-10 max-w-2xl mx-auto leading-relaxed">
                    Discover top-rated clinics and leading specialists.
                </p>

                <form action="{{ route('home') }}" method="GET"
                      class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl border p-2 flex flex-col sm:flex-row gap-2 items-center">
                    <div class="flex-1 w-full relative">
                        <i data-lucide="search" class="w-5 h-5 text-muted-foreground absolute left-4 top-1/2 -translate-y-1/2"></i>
                        <input type="text" name="q" value="{{ $search ?? '' }}"
                               placeholder="Search by clinic, specialty, or doctor..."
                               class="w-full pl-12 pr-4 h-12 bg-transparent focus:outline-none text-base">
                    </div>
                    <div class="hidden sm:block w-px h-8 bg-border"></div>
                    <div class="flex-1 w-full relative">
                        <i data-lucide="map-pin" class="w-5 h-5 text-muted-foreground absolute left-4 top-1/2 -translate-y-1/2"></i>
                        <input type="text" name="location" value="{{ $location ?? '' }}"
                               placeholder="Location..."
                               class="w-full pl-12 pr-4 h-12 bg-transparent focus:outline-none text-base">
                    </div>
                    <button type="submit"
                            class="w-full sm:w-auto h-12 px-8 bg-primary hover:bg-primary/90 text-white rounded-xl font-medium text-base transition-colors">
                        Find Care
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- ============ PREMIER CLINICS ============ --}}
    <section class="py-16 sm:py-24 bg-white">
        <div class="container">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold font-serif mb-4 flex items-center gap-3">
                        <i data-lucide="building-2" class="w-8 h-8 text-primary"></i>
                        Premier Clinics
                    </h2>
                    <p class="text-muted-foreground text-lg max-w-2xl">
                        Accredited facilities offering state-of-the-art technology and exceptional patient care.
                    </p>
                </div>
                <a href="#" class="hidden md:inline-flex items-center gap-2 border border-border px-4 py-2 rounded-lg hover:bg-muted/30 transition-colors">
                    View All Clinics
                </a>
            </div>
 
            {{-- ✅ FIXED EMPTY CHECK --}}
            @if (empty($clinics))
                <div class="text-center py-12 text-muted-foreground">No clinics found.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($clinics as $i => $clinic)
                        <x-clinic-card :clinic="$clinic" :index="$i" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============ TRUST SECTION (unchanged) ============ --}}
    <section class="py-16 sm:py-24 bg-primary text-white">
        {{-- ... your trust section content ... --}}
    </section>

    {{-- ============ FEATURED DOCTORS ============ --}}
    <section class="py-16 sm:py-24 bg-sidebar">
        <div class="container">
            <div class="text-center max-w-2xl mx-auto mb-12 md:mb-16">
                <h2 class="text-3xl md:text-4xl font-bold font-serif mb-4">Leading Specialists</h2>
                <p class="text-muted-foreground text-lg">
                    Book consultations with distinguished medical professionals across various specialties.
                </p>
            </div>

            {{-- ✅ ADDED NULL GUARD --}}
            @if (empty($doctors))
                <div class="text-center py-12 text-muted-foreground">No doctors found.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($doctors as $i => $doctor)
                        <x-doctor-card :doctor="$doctor" :index="$i" show-clinic-name />
                    @endforeach
                </div>
            @endif

            <div class="mt-12 text-center">
                <a href="#" class="inline-flex items-center gap-2 border border-primary text-primary hover:bg-primary hover:text-white transition-colors rounded-full px-8 py-3 font-medium">
                    Explore All Specialists
                </a>
            </div>
        </div>
    </section>

</div>
 



 

 
@endsection