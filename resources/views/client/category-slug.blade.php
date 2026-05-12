@extends('client.layouts.app')
 @section('title', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
@section('description', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
@section('keyword', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')

@section('content')	
@include('client.components.banner-section')

 
<div class="bg-indigo-600 text-white">
    <div class="container mx-auto px-4 py-6 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-indigo-200 mb-0.5">Professional Training</p>
            <h2 class="text-base sm:text-lg font-extrabold leading-tight">
                Globallyss d Recognised Certifications — PMP, CISA, SAP, Oracle &amp; 200+ more
            </h2>
        </div>
        <a href="{{ route('category.list') }}"
           class="shrink-0 px-5 py-2 bg-white text-indigo-700 font-bold rounded-lg text-sm hover:bg-indigo-50 transition-colors shimmer-btn whitespace-nowrap">
            Browse All Courses →
        </a>
    </div>
</div>


<div class="container mx-auto px-4 py-7">

    {{-- ── Breadcrumb + Title ── --}}
    <div class="flex items-start justify-between gap-3 flex-wrap border-b border-slate-100 pb-5">
        <div>
            <nav class="text-xs sm:text-sm text-slate-500 mb-1 flex items-center gap-1.5 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">Home</a>
                <span>›</span>
                @if(!empty($childSlug))
                    <a href="{{ route('categories.show', $childSlug) }}" class="hover:text-indigo-600 transition-colors">{{ $childCategory }}</a>
                    <span>›</span>
                @endif
                <span class="text-slate-600">{{ $keyword }}</span>
            </nav>

            <h1 class="text-lg sm:text-xl font-bold text-slate-900 leading-tight">{{ $keyword }}</h1>

            {{-- ── Star Rating ── --}}
            <div class="flex items-center gap-2 text-sm mt-2 flex-wrap">
                <img src="/client/images/{{ $stars }}" alt="{{ $ratingValue }} star rating" class="star-img" />
                <span class="font-semibold">{{ $ratingValue }}</span>
                <span class="text-slate-400">out of 5</span>
                <span class="text-slate-400">based on</span>
                <span class="font-semibold">{{ number_format($ratingCount) }}</span>
                <span class="text-slate-400">ratings</span>
            </div>

            @if(!empty($topDescription))
                <p class="text-slate-600 text-sm mt-3 max-w-2xl leading-relaxed">{{ $topDescription }}</p>
            @endif
        </div>
    </div>

    {{-- ── Course Tiles + Sidebar ── --}}
    <div class="flex flex-col lg:flex-row gap-7 items-start mt-6">
 <main class="flex-1 min-w-0"> 
        {{-- Course grid --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-extrabold text-slate-900">Top Professional Courses</h2>
                <a href="{{ route('category.list') }}" class="text-xs text-indigo-600 font-semibold hover:underline">View all →</a>
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                @forelse($categoryList as $i => $course)
                    @php
                        $bg    = $catColors[$i % count($catColors)];
                        $delay = min($i * 55, 800);
                        $img   = $course['img']      ?? '';
                        $title = $course['title']    ?? ($course['name'] ?? '');
                        $url   = $course['url']      ?? '#';
                        $rating= $course['rating']   ?? '';

                    @endphp
                    <div class="animate-tile" style="animation-delay: {{ $delay }}ms">
                        <a href="{{ route('child.show', $url) }}" >
                            <div class="tile-card group bg-white border border-slate-200 rounded-xl overflow-hidden">

                                {{-- Coloured image strip --}}
                                <div class="h-24 sm:h-28 relative overflow-hidden" style="background:{{ $bg }}">
                                    @if(!empty($img))
                                        <img
                                            src="{{ $img }}"
                                            alt="{{ $title }}"
                                            loading="lazy"
                                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out"
                                            onerror="this.style.display='none'"
                                        />
                                    @endif
                                    <div class="absolute inset-x-0 bottom-0 h-8 bg-gradient-to-t from-black/30 to-transparent pointer-events-none"></div>
                                </div>

                                {{-- Title + rating --}}
                                <div class="px-2 py-2.5 sm:px-3 flex items-start justify-between gap-1">
                                    <p class="text-[11px] sm:text-xs font-bold text-slate-900 leading-snug group-hover:text-indigo-700 transition-colors flex-1">
                                        {{ $title }}
                                    </p>
                                    @if(!empty($rating))
                                        <div class="flex items-center gap-0.5 text-amber-500 shrink-0 mt-0.5">
                                            {{-- Star SVG --}}
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-[10px] font-semibold text-slate-700">{{ $rating }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="col-span-full text-slate-400 text-sm py-8 text-center">No courses found for this category.</p>
                @endforelse
            </div>

            @if(!empty($bottomDescription))
                <div class="mt-8 prose prose-sm max-w-none text-slate-600 leading-relaxed">
                    <p>{{ $bottomDescription }}</p>
                </div>
            @endif
        </div>
</main>

  <aside class="hidden lg:block w-80 xl:w-96 flex-shrink-0 sticky top-[80px] self-start">


          @include('client.layouts.common_sidebar_form')
        
        </aside>
   
     
        

    </div>



     
</div>
 
{{-- ══════════════════════════════════════
     ALPINE.JS LOGIC
════════════════════════════════════════ --}}
<script>
/* ── Country + Location data ── */
const COUNTRIES = [
    {flag:"🇦🇺",name:"Australia",code:"+61"},{flag:"🇦🇹",name:"Austria",code:"+43"},
    {flag:"🇧🇩",name:"Bangladesh",code:"+880"},{flag:"🇧🇪",name:"Belgium",code:"+32"},
    {flag:"🇧🇷",name:"Brazil",code:"+55"},{flag:"🇨🇦",name:"Canada",code:"+1"},
    {flag:"🇨🇳",name:"China",code:"+86"},{flag:"🇩🇰",name:"Denmark",code:"+45"},
    {flag:"🇫🇷",name:"France",code:"+33"},{flag:"🇩🇪",name:"Germany",code:"+49"},
    {flag:"🇭🇰",name:"Hong Kong",code:"+852"},{flag:"🇮🇳",name:"India",code:"+91"},
    {flag:"🇮🇩",name:"Indonesia",code:"+62"},{flag:"🇮🇪",name:"Ireland",code:"+353"},
    {flag:"🇮🇱",name:"Israel",code:"+972"},{flag:"🇮🇹",name:"Italy",code:"+39"},
    {flag:"🇯🇵",name:"Japan",code:"+81"},{flag:"🇯🇴",name:"Jordan",code:"+962"},
    {flag:"🇰🇪",name:"Kenya",code:"+254"},{flag:"🇲🇾",name:"Malaysia",code:"+60"},
    {flag:"🇲🇽",name:"Mexico",code:"+52"},{flag:"🇳🇱",name:"Netherlands",code:"+31"},
    {flag:"🇳🇿",name:"New Zealand",code:"+64"},{flag:"🇳🇬",name:"Nigeria",code:"+234"},
    {flag:"🇳🇴",name:"Norway",code:"+47"},{flag:"🇵🇰",name:"Pakistan",code:"+92"},
    {flag:"🇵🇭",name:"Philippines",code:"+63"},{flag:"🇵🇱",name:"Poland",code:"+48"},
    {flag:"🇵🇹",name:"Portugal",code:"+351"},{flag:"🇶🇦",name:"Qatar",code:"+974"},
    {flag:"🇷🇺",name:"Russia",code:"+7"},{flag:"🇸🇦",name:"Saudi Arabia",code:"+966"},
    {flag:"🇸🇬",name:"Singapore",code:"+65"},{flag:"🇿🇦",name:"South Africa",code:"+27"},
    {flag:"🇰🇷",name:"South Korea",code:"+82"},{flag:"🇪🇸",name:"Spain",code:"+34"},
    {flag:"🇸🇪",name:"Sweden",code:"+46"},{flag:"🇨🇭",name:"Switzerland",code:"+41"},
    {flag:"🇹🇼",name:"Taiwan",code:"+886"},{flag:"🇹🇿",name:"Tanzania",code:"+255"},
    {flag:"🇹🇭",name:"Thailand",code:"+66"},{flag:"🇹🇷",name:"Turkey",code:"+90"},
    {flag:"🇦🇪",name:"UAE",code:"+971"},{flag:"🇬🇧",name:"United Kingdom",code:"+44"},
    {flag:"🇺🇸",name:"United States",code:"+1"},{flag:"🇻🇳",name:"Vietnam",code:"+84"},
];

const LOCATIONS = [
    "Abu Dhabi","Ahmedabad","Amsterdam","Auckland","Bangalore","Bangkok","Barcelona",
    "Beijing","Berlin","Brisbane","Brussels","Budapest","Cairo","Cape Town","Chennai",
    "Chicago","Colombo","Copenhagen","Dallas","Delhi","Dubai","Dublin","Frankfurt",
    "Glasgow","Guangzhou","Helsinki","Ho Chi Minh City","Hong Kong","Houston","Hyderabad",
    "Istanbul","Jakarta","Johannesburg","Karachi","Kuala Lumpur","Lagos","Lahore",
    "London","Los Angeles","Madrid","Manchester","Melbourne","Mexico City","Miami",
    "Milan","Mumbai","Munich","Nairobi","New York","Oslo","Paris","Perth","Prague",
    "Pune","Riyadh","Rome","San Francisco","São Paulo","Seoul","Shanghai","Singapore",
    "Stockholm","Sydney","Taipei","Tokyo","Toronto","Vancouver","Vienna","Warsaw","Zürich",
];

/* ── Alpine component ── */
function stepForm() {
    return {
        step: 1,
        done: false,
        steps: ['Your Details', 'Course Interest', 'Confirm'],

        selectedCountry: COUNTRIES.find(c => c.name === 'India') || COUNTRIES[0],
        countrySearch: '',

        form: { name:'', email:'', phone:'', location:'', course:'', message:'' },

        init() { /* nothing async needed */ },

        filteredCountries() {
            const q = this.countrySearch.toLowerCase();
            return q
                ? COUNTRIES.filter(c => c.name.toLowerCase().includes(q) || c.code.includes(q))
                : COUNTRIES;
        },

        filteredLocations() {
            const q = this.form.location.toLowerCase();
            const list = q
                ? LOCATIONS.filter(l => l.toLowerCase().includes(q))
                : LOCATIONS;
            return list.slice(0, 8);
        },

        nextStep() {
            if (this.step < 3) this.step++;
        },

        submit() {
            /* 
             * Wire up to your Laravel API endpoint, e.g.:
             * fetch('/api/enquiry', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(this.form) })
             */
            this.done = true;
        },

        reset() {
            this.step = 1;
            this.done = false;
            this.form = { name:'', email:'', phone:'', location:'', course:'', message:'' };
            this.selectedCountry = COUNTRIES.find(c => c.name === 'India') || COUNTRIES[0];
        },
    };
}

/* ── Scroll reveal ── */
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver(
        entries => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }),
        { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );
    document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
});
</script>

 


@endsection