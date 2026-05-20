@extends('client.layouts.app')
@section('title', $metaTitle ?? $keyword . ' | QuickDials - Trusted Local Search')

@section('description', $metaDescription ?? 'Find the best ' . $keyword . ' services with QuickDials. Explore verified businesses, phone numbers, addresses, reviews, ratings, photos, maps, and trusted local service providers near you.')

@section('keyword', $metaKeywords ?? $keyword . ', best ' . $keyword . ', top ' . $keyword . ' services, verified businesses, local business directory, QuickDials, nearby services, reviews and ratings, trusted businesses, contact details, local search engine India')




@section('content')	
@include('client.components.banner-section')

 @php
 
 
$bgImage = $bgImage ?? '/client/images/computer-courses-training.jpg';

 @endphp

<div x-show="showAd" x-cloak
         class="relative w-full overflow-hidden h-40"
         style="background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-indigo-900/50"></div>
        <div class="relative w-full px-3 sm:px-8 py-3 sm:py-5 flex items-center gap-3 sm:gap-5 h-full">
            <div class="flex-1 min-w-0">
                
            </div>
            <div class="flex-shrink-0 flex items-center gap-2 sm:gap-3">
                
                
            </div>
        </div>
    </div>


  


<div class="container mx-auto px-4 py-7">

    {{-- ── Breadcrumb + Title ── --}}
    <div class="flex items-start justify-between gap-3 flex-wrap border-b border-slate-100 pb-5">
        <div>
            <nav class="text-xs sm:text-sm text-slate-500 mb-1 flex items-center gap-1.5 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">Home</a>
                <span>›</span>
             
                    <a href="{{ route('category.list') }}" class="hover:text-indigo-600 transition-colors">Categories</a>
                    <span>›</span>
              
                <span class="text-slate-600">{{ $keyword }}</span>
            </nav>

            <h1 class="text-lg sm:text-xl font-bold text-slate-900 leading-tight">{{ $keyword }}</h1>

            {{-- ── Star Rating ── --}}
            <div class="flex items-center gap-2 text-sm mt-2 flex-wrap">
                <img loading="lazy" decoding="async" src="/client/images/{{ $stars }}" alt="{{ $ratingValue }} star rating" class="star-img" />
                <span class="font-semibold">{{ $ratingValue }}</span>
                <span class="text-slate-400">out of 5</span>
                <span class="text-slate-400">based on</span>
                <span class="font-semibold">{{ number_format($ratingCount) }}</span>
                <span class="text-slate-400">ratings</span>
            </div>
 
          
        </div>
    </div>

    {{-- ── Course Tiles + Sidebar ── --}}
    <div class="flex flex-col lg:flex-row gap-7 items-start mt-6">
 <main class="flex-1 min-w-0"> 
        {{-- Course grid --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-extrabold text-slate-900">Top {{ $keyword }}</h2>
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

 
            @if(!empty($topDescription))
               @php
                    $defaultHeading = '';

                    if (!empty($kwData['top_heading'])) {
                    $defaultHeading=  $kwData['top_heading'];
                    }else{
                    $defaultHeading = 'Trusted '. $keyword;
                    }    
                    @endphp
                <div class="mt-8 prose prose-sm max-w-none text-slate-600 leading-relaxed">
                    <h2 class="text-lg font-bold text-gray-900 mb-3"> {{ $defaultHeading }}</h2>
                    <p>{{ $topDescription }}</p>
                </div>
            @endif
        </div>
</main>

  <aside class="lg:block w-80 xl:w-96 flex-shrink-0 sticky top-[80px] self-start">


 <div class="reveal-r" id="enquiry-sidebar">
                @include('client.layouts.enquiry_common_popup')
                
            </div>

           
        
        </aside>
   
     
        

    </div>


    
    {{-- Agents comparison table --}}
    @if(count($agents ?? []) > 0)
    <section class="w-full p-4">
        <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold mb-4">TOP {{ count($agents) }} {{ $keyword }}</h2>
        <div class="w-full overflow-x-auto border rounded-lg">
            <table class="w-full border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-3 text-left font-semibold min-w-[150px]">Name</th>
                        @foreach($agents as $agent)
                        <th class="border px-4 py-3 text-left text-blue-600 hover:underline cursor-pointer whitespace-nowrap">{{ $agent['name'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                    $agentRows = [
                        'Address' => 'address', 'About' => 'about',
                        'Services Offered' => 'Services_Offered', 'Listed Categories' => 'Listed_Categories',
                        'Year of Establishment' => 'Year_of_Establishment', 'Reviews' => 'No_of_Reviews',
                        'Rating' => 'Rating', 'Service Type' => 'Training_Type',
                        'Government Recognition' => 'Government_Recognition',
                    ];
                    @endphp
                    @foreach($agentRows as $label => $key)
                    @php $allEmpty = collect($agents)->every(fn($a) => empty($a[$key])); @endphp
                    @if(!$allEmpty)
                    <tr>
                        <td class="border px-4 py-3 font-semibold">{{ $label }}</td>
                        @foreach($agents as $agent)
                        <td class="border px-4 py-3 text-sm leading-relaxed min-w-[200px]">
                            {{ empty($agent[$key]) ? '—' : (is_array($agent[$key]) ? implode(', ', $agent[$key]) : $agent[$key]) }}
                        </td>
                        @endforeach
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    @endif

    {{-- Course About --}}
    @if(!empty($kwData['heading']) && !empty($kwData['courseabout']))
    <div class="border rounded-lg p-4 bg-white shadow-sm mx-4">
        <section class="rounded-md p-1">
            <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-semibold text-blue-900">{{ $kwData['heading'] }}</h2>
            <div class="w-full h-[2px] bg-teal-500 mt-3 mb-5"></div>
            <div class="text-gray-800 leading-relaxed mb-5">{!! $kwData['courseabout'] !!}</div>
            <ul class="space-y-3">
                @foreach(['paragraph1','paragraph2','paragraph3','paragraph4','paragraph5','paragraph6'] as $p)
                @if(!empty($kwData[$p]))
                <li class="flex items-start gap-2 text-gray-800">
                    <span class="text-orange-500 mt-1">✔</span>
                    <span>{!! $kwData[$p] !!}</span>
                </li>
                @endif
                @endforeach
            </ul>
        </section>
    </div>
    @endif

    
   

    {{-- Bottom Description --}}
    @if(!empty($bottomDescription))

      @php
    $bottom_heading = '';

    if (!empty($kwData['bottom_heading'])) {
        $bottom_heading=  $kwData['bottom_heading'];
    }else{
     $bottom_heading = 'Find the Best '.$keyword;
    }    
    @endphp
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-4 mx-4">
        <h2 class="text-lg font-bold text-gray-900 mb-3"> {{ $bottom_heading }} </h2>
        <div class="text-sm text-gray-600 leading-relaxed">{!! $bottomDescription !!}</div>
    </div>
    @endif

    {{-- FAQ --}}
    @if(count($faqs ?? []) > 0)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-4 mx-4" x-data="{ openFaq: null }">
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            💬 Frequently Asked Questions — {{ $keyword }}
        </h2>
        <div class="space-y-2">
        
            @foreach($faqs as $fi => $faq)
            @if(!empty($faq['q']) && !empty($faq['a']))
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === {{ $fi }} ? null : {{ $fi }}"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                  {{ $faq['q'] }} 
                    <span x-text="openFaq === {{ $fi }} ? '▲' : '▼'" class="text-gray-400 text-xs flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === {{ $fi }}" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   {!! $faq['a'] !!}
                </div>
            </div>
            @endif
            @endforeach
            
        </div>
    </div>
    @endif




     
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