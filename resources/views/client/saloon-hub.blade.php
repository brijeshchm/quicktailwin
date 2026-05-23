@extends('client.layouts.app')
@section('title', $metaTitle ?? 'Quick Dials | A Local Search Engine for Businesses')
@section('description', $metaDescription ?? 'Category local search engine, for Certified Training Institutes near you Quickdials, Hotels, Salons, Real Estate, Travel, Healthcare, Education,Find addresses, phone numbers, reviews and ratings, photos, maps of businesses Find Only Certified Training Institutes')
@section('keyword', $metaKeywords ?? 'Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you')
@section('content')	 
 
@include('client.components.banner-section')
 

<div x-data="spaHub()" x-init="init()" class="bg-white">

    
    

    {{-- ════════════ MAIN SECTIONS ════════════ --}}
    <main class="pt-[60px]">
        <section id="hero">
            @include('client.saloon.components.hero-banner', ['spa' => $spa])
        </section>

        <div class="mx-12 h-px bg-gradient-to-r from-transparent via-stone-200 to-transparent"></div>

        <section id="spa-types">
            @include('client.saloon.components.saloon-types')
        </section>

        <section id="spa-types">
            @include('client.saloon.components.social-tag')
        </section>
        <section id="spa-types">
            @include('client.saloon.components.service-section')
        </section>

        <section id="gallery" class="bg-orange-50">
            @include('client.saloon.components.gallery')
        </section>

        <section id="info" class="bg-orange-50">
            @include('client.saloon.components.business-info', ['spa' => $spa])
        </section>

        <div class="mx-12 h-px bg-gradient-to-r from-transparent via-stone-200 to-transparent"></div>

        <section id="reviews">
            @include('client.saloon.components.reviews')
        </section>
    </main>

    {{-- ════════════ STICKY MOBILE ACTION BAR ════════════ --}}
    <div class="sticky-mob-bar fixed bottom-0 left-0 right-0 z-[999] hidden
                bg-white/97 backdrop-blur-xl border-t border-black/8 shadow-[0_-4px_24px_rgba(0,0,0,0.1)]
                px-3 py-2.5 gap-2 items-center"
         style="padding-bottom: calc(0.6rem + env(safe-area-inset-bottom));">

        {{-- Call --}}
        <a href="tel:{{ $spa['phone'] }}"
           class="flex-1 flex items-center justify-center gap-1.5 px-2 py-2.5 rounded-full
                  bg-green-500 text-white text-xs font-bold no-underline
                  shadow-md shadow-green-500/40 active:scale-95 transition-transform">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.02 2.2 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/>
            </svg>
            Call Now
        </a>

        {{-- WhatsApp --}}
        <a href="https://wa.me/{{ $spa['whatsapp'] }}?text={{ urlencode('Hi ' . $spa['name'] . '! I would like to book a treatment.') }}"
           target="_blank" rel="noopener noreferrer"
           class="flex-1 flex items-center justify-center gap-1.5 px-2 py-2.5 rounded-full
                  bg-[#25d366] text-white text-xs font-bold no-underline
                  shadow-md shadow-emerald-500/40 active:scale-95 transition-transform">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp
        </a>

        {{-- Enquire --}}
        <button @click="openModal()"
                class="flex-[1.3] flex items-center justify-center gap-1.5 px-2 py-2.5 rounded-full
                       bg-blue-500 text-white text-xs font-bold border-0 cursor-pointer
                       shadow-md shadow-blue-500/40 active:scale-95 transition-transform">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
            Enquire Now
        </button>
    </div>

 

    {{-- ════════════ ENQUIRY MODAL ════════════ --}}
    <div x-show="modalOpen"
         x-transition.opacity
         @keydown.escape.window="closeModal()"
         class="fixed inset-0 z-[1000] flex items-center justify-center p-4"
         style="display: none;">

        {{-- Backdrop --}}
        <div @click="closeModal()"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        
    </div>
</div>

{{-- ════════════ STYLES ════════════ --}}
<style>
    @media (max-width: 640px) {
        .sticky-mob-bar { display: flex !important; }
        main { padding-bottom: 80px; }
    }
</style>

{{-- ════════════ ALPINE.JS STATE ════════════ --}}
<script>
function spaHub() {
    return {
        scrolled:   false,
        modalOpen:  false,
        mobileMenu: false,

        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 50;
            });
        },

        scrollTo(id) {
            this.mobileMenu = false;
            document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
        },

        openModal() {
            this.modalOpen = true;
            document.body.style.overflow = 'hidden';
        },

        closeModal() {
            this.modalOpen = false;
            document.body.style.overflow = '';
        },
    };
}
</script>

 
 
 
 
@endsection