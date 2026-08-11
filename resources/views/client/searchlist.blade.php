@extends('client.layouts.app')
@section('title', $metaTitle ?? $keyword . ' in ' . ucwords(strtolower(str_replace('-', ' ', $city))) . ' | QuickDials')
@section('description', $metaDescription ?? 'Find the best ' . $keyword . ' in ' . ucwords(strtolower(str_replace('-', ' ', $city))) . ' with QuickDials. Discover verified businesses, addresses, phone numbers, reviews, ratings, photos, maps, and top local services near you.')
@php
    $allowedCities = [
        'faridabad','delhi', 'noida',
        'gurgaon', 'bangalore'
    ];

     $singleCities = [
        'faridabad'
    ];


    $keywordArray = [
        'artificial-intelligence-training', 'python-training', 'workday-training',
        'sap-training', 'banquet-hall', 'cricket-academy'
    ];
    $currentCity    = strtolower(trim($city ?? ''));
    $currentKeyword = strtolower(trim($kwData['keyword_slug'] ?? ''));

    $shouldIndex = in_array($currentCity, $allowedCities) 
        && in_array($currentKeyword, $keywordArray);
 
   
@endphp

@section('meta_robots')
<meta name="robots" content="{{ $shouldIndex ? 'index, follow' : 'noindex, nofollow' }}">
@endsection
@section('og_image', !empty($kwData['key_icon'])
    ? asset($kwData['key_icon'])
    : asset('client/images/quickdials-og.png'))
@section('content') 

<style>  
    #enquiry-modal { display: none; }
    #enquiry-modal.open { display: flex; }
    body.modal-open { overflow: hidden; } 
#scroll-progress {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: #2563eb;
    transform-origin: left;
    transform: scaleX(0);
    z-index: 9999;
    border-radius: 0 9999px 9999px 0;
    transition: transform 0.1s linear;
}

.bg-white h3{
    font-size: 1.025rem;
    line-height: 1.75rem;
    font-weight: 700;
}
.bg-white h2{
    font-size: 1.025rem;
    line-height: 1.75rem;
    font-weight: 700;
}
</style> 
<div id="scroll-progress"></div> 
<script>
window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
    const total    = document.documentElement.scrollHeight - window.innerHeight;
    const pct      = total > 0 ? scrolled / total : 0;
    document.getElementById('scroll-progress').style.transform = `scaleX(${pct})`;
}, { passive: true });
</script>
@include('client.components.banner-section')
@php
$sortOptions = ['Best Match', 'Highest Rated', 'Most Reviews', 'Newest', 'Name A–Z'];
$otherCities = ['hyderabad','delhi','noida','gurgaon','mumbai','faridabad'];

$starMap = [
    0 => 'star_1.png', 2 => 'star_2.png', 3 => 'star_3.png',
    3.5 => 'star_3.5.png', 4 => 'star_4.png', 4.5 => 'star_4.5.png',
    4.75 => 'star_4.75.png', 5 => 'star_5.png',
];

$bgImage = $bgImage ?? '/client/images/computer-courses-training.jpg';

// Calculate star image key
$starKey = 0;
foreach ($starMap as $k => $v) {
    if ($ratingValue >= $k) $starKey = $k;
}
$starImg = $starMap[$starKey] ?? 'star_4.5.png';

// Reviews stats
$totalReviews = count($reviews ?? []);
$avgRating = $totalReviews > 0
    ? round(collect($reviews)->avg(fn($r) => floatval($r->avg_rating ?? 0)), 1)
    : 0;
$starCounts = [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
foreach ($reviews ?? [] as $r) {
    $s = min(5, max(1, round(floatval($r->avg_rating ?? 0))));
    $starCounts[$s] = ($starCounts[$s] ?? 0) + 1;
}
$starPercentages = collect([5,4,3,2,1])->map(fn($s) => [
    'star' => $s,
    'count' => $starCounts[$s],
    'percent' => $totalReviews > 0 ? round(($starCounts[$s] / $totalReviews) * 100) : 0
]);
 
@endphp
@include('client.layouts.common_country_data')
<div class="min-h-screen bg-gray-50 flex flex-col mt-4"
     x-data="listingPage()" x-init="init()">

  @php
    $hasBanners = is_countable($keywordBanners) && count($keywordBanners) > 0;
@endphp

@php     
    $serviceName = !empty($metaTitle)
        ? $metaTitle
        : "";

    $serviceDescription = $metaDescription? $metaDescription: 'India’s leading local business search and service directory. Find trusted businesses, services, it training, professionals, and service providers near you with QuickDials..';
    $cityName =$city ?: 'faridabad';
    if (!empty($childCat) && !empty($childSlug)) {
        $items[] = ['name' => ucfirst($childCat), 'url' => route('city.slug', ['city_slug'=> $cityName,'service_slug' => $childSlug]) ];
    }

 
@endphp 
@php   
 
$keywordImg= !empty($kwData['key_icon'])
    ? asset($kwData['key_icon'])
    : asset('client/images/quickdials-og.png');
    $schemas = [];  
     
     $schemas[] = [
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        'name' => "Quickdials",
        'url' => "https://www.quickdials.com/",
    ];
    

      // ---- 2. SERVICE (only if service data exists) ----
    if (!empty($serviceName)) {
        $schemas[] = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            "@id"=> url()->current()."#service",
            'name'        => $serviceName ?? '',
            "serviceType"=> $serviceName,
            'description' => $serviceDescription ?? '',
            'url'         => url()->current(),        
            "areaServed"=> [
                    "@type"=> "City",
                    "name"=>$cityName ?? '',
                ],
            'provider'    => [
                '@type' => 'Organization',
                "@id"=> "https://www.quickdials.com/#organization",
                'name'  => 'QuickDials',
                'url'   => route('home'),
            ],
        ];
    }

    if (!empty($metaTitle) && !empty($cityDetails['city'])) {

        $address = [
            '@type'          => 'PostalAddress',
            'addressLocality' => $cityDetails['city'],
            'addressCountry'  => 'IN',
        ];

        // Only add optional address fields if they actually have data
        if (!empty($cityDetails['state'])) {
            $address['addressRegion'] = $cityDetails['state'];
        }
        if (!empty($cityDetails['pincode'])) {
            $address['postalCode'] = $cityDetails['pincode'] ?? '560008';
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'LocalBusiness',
            'name'     => $metaTitle,
            'url'      => url()->current(),
            'address'  => $address,
        ];

        // Only add image if present
        if (!empty($keywordImg)) {
            $schema['image'] = $keywordImg;
        }

        // // Only add aggregateRating if BOTH value and count are real (non-zero, non-empty)
        // if (!empty($ratingValue) && !empty($ratingCount)) {
        //     $schema['aggregateRating'] = [
        //         '@type'       => 'AggregateRating',
        //         'ratingValue' => (string) $ratingValue,
        //         'ratingCount' => (string) $ratingCount,
        //         'bestRating'  => '5',
        //     ];
        // }

        $schemas[] = $schema;
    }
 

    if(!empty($businesses)){

        foreach($businesses as $clientBus){
    
            if (!empty($clientBus['logo']) && !empty($clientBus['name']) && !empty($clientBus['business_slug'])) {

                $address = [
                    '@type'          => 'PostalAddress',
                    'addressLocality' => $clientBus['city'],
                    'addressCountry'  => 'IN',
                ];

                // Only add optional address fields if they actually have data
                if (!empty($clientBus['state'])) {
                    $address['addressRegion'] = $clientBus['state'];
                }
                if (!empty($clientBus['pincode'])) {
                    $address['postalCode'] = $clientBus['pincode'];
                }
                if (!empty($clientBus['city'])) {
                    $address['streetAddress'] = $clientBus['landmark'] ?? $clientBus['city'];
                }

                $schema = [
                    '@context' => 'https://schema.org',
                    '@type'    => 'LocalBusiness',
                    'name'     => $clientBus['name'],
                    'url' =>    route('business.details',$clientBus['business_slug']),     
                    'address'  => $address,
                ];

                // Only add image if present
                if (!empty($clientBus['logo'])) {
                    $schema['image'] = $clientBus['logo'];
                }


        
        

                $schemas[] = $schema;
            }
        }

    }


    if (!empty($businesses)) {
       
        foreach ($businesses as $i => $item) {
            $listItem[] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'url'     => route('business.details',$item['business_slug']),
                 
            ];
        }

          $schemas[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            'itemListElement' => $listItem,
        ];
    }
                     
 
 

 
@endphp

@if(!empty($schemas))
<script type="application/ld+json">
{!! json_encode(
    count($schemas) === 1 ? $schemas[0] : $schemas,
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
) !!}
</script>
@endif 
@if($hasBanners)
<div x-data='bannerSlider(@json($keywordBanners), 4000)'
     x-init="init()"
     @mouseenter="pause()"
     @mouseleave="resume()"
     @keydown.window.arrow-left.prevent="prev()"
     @keydown.window.arrow-right.prevent="next()"
     x-show="showAd"
     x-cloak
     class="relative w-full overflow-hidden h-48 group rounded-lg shadow-md">
   
    <template x-for="(banner, idx) in banners" :key="banner.id">
        <div class="absolute inset-0 w-full h-full transition-opacity duration-700 ease-in-out"
             :class="idx === current ? 'opacity-100 z-10' : 'opacity-0 z-0'"
             :aria-hidden="idx !== current">        
            <template x-if="banner.click_url">
                <a :href="banner.click_url" rel="noopener sponsored" class="block w-full h-full">
                    <img :src="banner.image_url"
                         :alt="banner.alt_text"
                         :loading="idx === 0 ? 'eager' : 'lazy'"
                         :fetchpriority="idx === 0 ? 'high' : 'auto'"
                         width="1351sw" height="190"
                         class="w-full h-full object-contain" />
                </a>
            </template>

            <template x-if="!banner.click_url">
                <img :src="banner.image_url"
                     :alt="banner.alt_text"
                     :loading="idx === 0 ? 'eager' : 'lazy'"
                     :fetchpriority="idx === 0 ? 'high' : 'auto'"
                     width="1200" height="190"
                     class="w-full h-full object-cover" />
            </template>

            <div class="absolute inset-0 bg-indigo-900/50 pointer-events-none"></div>

            <div class="absolute inset-0 px-3 sm:px-8 py-3 sm:py-5 flex items-center gap-3 sm:gap-5 pointer-events-none">
                <div class="flex-1 min-w-0 text-white"></div>
                <div class="flex-shrink-0 flex items-center gap-2 sm:gap-3"></div>
            </div>
        </div>
    </template>

    {{-- Pagination dots --}}
    <div x-show="banners.length > 1"
         class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-20">
        <template x-for="(b, idx) in banners" :key="'dot-'+b.id">
            <button @click="goTo(idx)"
                    :class="idx === current ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80 w-2'"
                    class="h-2 rounded-full transition-all duration-300"
                    :aria-label="'Go to slide ' + (idx + 1)"></button>
        </template>
    </div>

    {{-- Arrows --}}
    <button x-show="banners.length > 1" @click="prev()" aria-label="Previous"
            class="absolute left-2 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 hover:bg-black/60 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <button x-show="banners.length > 1" @click="next()" aria-label="Next"
            class="absolute right-2 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 hover:bg-black/60 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    {{-- Progress bar --}}
    <div x-show="banners.length > 1"
         class="absolute bottom-0 left-0 h-1 bg-white/80 z-20 transition-all ease-linear"
         :style="`width: ${progress}%; transition-duration: ${timer ? interval : 0}ms`">
    </div>
</div>


<script>
function bannerSlider(banners, interval = 4000) {
    return {
        banners: banners || [],
        current: 0,
        timer: null,
        interval: interval,
        progress: 0,
        showAd: true,

        init() {
            console.log('Slider init — banners loaded:', this.banners.length, this.banners);
            if (this.banners.length > 1) {
                this.start();
                document.addEventListener('visibilitychange', () => {
                    document.hidden ? this.pause() : this.resume();
                });
            }
        },
        start()  { this.progress = 100; this.timer = setInterval(() => this.next(), this.interval); },
        pause()  { clearInterval(this.timer); this.timer = null; this.progress = 0; },
        resume() { if (!this.timer && this.banners.length > 1) this.start(); },
        next()   { this.current = (this.current + 1) % this.banners.length; this.resetProgress(); },
        prev()   { this.current = (this.current - 1 + this.banners.length) % this.banners.length; this.resetProgress(); },
        goTo(idx){ this.current = idx; this.pause(); setTimeout(() => this.resume(), 50); },
        resetProgress() { this.progress = 0; requestAnimationFrame(() => { this.progress = 100; }); }
    }
}
</script>
@else
    {{-- Hero Banner --}}
    <div x-show="showAd" x-cloak
         class="relative w-full overflow-hidden h-48"
         style="background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-indigo-900/50"></div>
        <div class="relative w-full px-3 sm:px-8 py-3 sm:py-5 flex items-center gap-3 sm:gap-5 h-full">
            <div class="flex-1 min-w-0">
                
            </div>
            <div class="flex-shrink-0 flex items-center gap-2 sm:gap-3">
                
                
            </div>
        </div>
    </div>
@endif
    {{-- Filter / Sort bar --}}
    <div class="w-full bg-white border-b border-gray-100 px-4 sm:px-6 py-2">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
                {{-- Breadcrumb --}}
                <nav class="text-black text-xs sm:text-sm mb-1 flex items-center gap-1.5 flex-wrap">
                    <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                    <span>›</span>
                    @if($city)
                    <a href="{{ route('showCity', $city)}}" class="hover:text-indigo-600">{{ ucfirst($city) }}</a>
                    <span>›</span>
                    @endif
                    <span>{{ $keyword }} in {{ ucwords(strtolower(str_replace('-', ' ', $city))) }}</span>

                       <!-- <span>›</span>
                    <span class="text-gray-600">{{ $keyword }} in {{ ucwords(strtolower(str_replace('-', ' ', $city))) }}</span> -->
                </nav>
                           
                <div itemscope itemtype="https://schema.org/Product" class="space-y-2">    
                    <div itemprop="name">
                        <h1 class="text-lg font-bold text-gray-900 leading-tight">{{ !empty($kwData['h1_heading']) ? $kwData['h1_heading'] : trim(($keyword ?? '') . (!empty($city) ? ' in ' . ucwords(strtolower(str_replace('-', ' ', $city))) : '' ))}}</h1>
                    </div>                           
                    <div itemprop="aggregateRating"
                        itemscope
                        itemtype="https://schema.org/AggregateRating"
                        class="flex items-center gap-2 text-sm">
                        <img  itemprop="image" src="{{ asset('client/images/' . $starImg) }}"
                        alt="{{ $ratingValue }} out of 5 stars"
                        class="lazy-image h-4 w-auto"
                        width="80"
                        height="16"
                        loading="lazy"
                        decoding="async"
                        >
                        <span class="font-semibold text-gray-900">
                        <span itemprop="ratingValue">{{ $ratingValue }}</span>
                        </span>
                        <span class="text-gray-500">out of</span>
                        <span itemprop="bestRating">5</span>
                        <span class="text-gray-500">based on</span>
                        <span itemprop="ratingCount">{{ $ratingCount }}</span>
                        <span class="text-gray-500">ratings</span>
                        
                    </div>
                  
                  
                </div> 
                 <p class="pt-1">{{ $kwData['short_definition']??'' }}</p>
            </div>

            {{-- Controls --}}
            <div class="flex items-center gap-2 flex-wrap">
                <div class="relative">
                    <label for="sort-businesses" class="sr-only">
                    Sort businesses
                    </label>
                    <select x-model="sortBy" @change="applyFilters()" class="appearance-none pl-3 pr-7 py-1.5 text-xs font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-xl outline-none cursor-pointer hover:border-indigo-300 transition-colors">
                        @foreach($sortOptions as $opt)
                        <option>{{ $opt }}</option>
                        @endforeach
                    </select>
                    <span class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs">▾</span>
                </div>
                <button @click="showFilters = !showFilters"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium border transition-all"
                        :class="showFilters ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300 hover:text-indigo-600'">
                    ⚙ Filters
                    <span x-show="activeFilterCount > 0" x-text="activeFilterCount"
                          class="w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center"></span>
                </button>
                 <div class="flex items-center bg-gray-100 rounded-xl p-0.5">
                    <button @click="view = 'list'; applyFilters()"
                            class="p-1.5 rounded-lg transition-all"
                            :class="view==='list' ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-400 hover:text-gray-600'">☰</button>
                    <button @click="view = 'grid'; applyFilters()"
                            class="p-1.5 rounded-lg transition-all"
                            :class="view==='grid' ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-400 hover:text-gray-600'">⊞</button>
                </div>
                
            </div>
        </div>

     

        {{-- Advanced filters --}}
        <div x-show="showFilters" x-cloak class="pt-3 mt-3 border-t border-gray-100 flex items-center gap-6 flex-wrap">
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500 font-medium">Min Rating:</span>
                <div class="flex gap-1">
                    @foreach([0, 3, 4, 4.5] as $r)
                    <button @click="minRating = {{ $r }}; applyFilters()"
                            class="px-2 py-0.5 text-xs font-medium rounded-lg border transition-all"
                            :class="minRating === {{ $r }} ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-gray-500 border-gray-200 hover:border-amber-300'">
                        {{ $r === 0 ? 'All' : $r . '+' }}
                    </button>
                    @endforeach
                </div>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" x-model="verifiedOnly" @change="applyFilters()" class="w-3.5 h-3.5 accent-indigo-600">
                <span class="text-xs text-gray-600 font-medium">Verified only</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" x-model="openOnly" @change="applyFilters()" class="w-3.5 h-3.5 accent-indigo-600">
                <span class="text-xs text-gray-600 font-medium">Currently open</span>
            </label>
            <button @click="resetFilters()" class="text-xs text-gray-400 hover:text-red-500 ml-auto">Reset</button>
        </div>

        {{-- Search --}}
        <div class="w-full py-2.5 flex items-center gap-3">
            <div class="flex-1 flex items-center bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 gap-2 hover:border-indigo-300 focus-within:border-indigo-400 focus-within:ring-2 focus-within:ring-indigo-100 transition-all">
            
                <input type="text" placeholder="Search {{ $keyword }}…"
                       x-model="search" @input="applyFilters()"
                       class="flex-1 text-sm text-gray-800 placeholder-gray-400 bg-transparent outline-none min-w-0 border-gray-200">
                <button x-show="search" @click="search = ''; applyFilters()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
        </div>
    </div>  
    <div class="flex-1 w-full flex gap-5 px-4 sm:px-6 py-5 items-start"> 
        <main class="flex-1 min-w-0">
            <div id="listings-container" x-show="filteredCount > 0">
@if(!empty($businesses))
    @php
        $adInterval = 4;   
        $businessChunks = collect($businesses)->chunk($adInterval);
    @endphp

    @foreach($businessChunks as $chunkIndex => $chunk)

        {{-- ONE grid wrapper for the ENTIRE chunk --}}
        <div :class="view === 'grid'
            ? 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-4 mb-6'
            : 'bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden divide-y divide-gray-50 mb-6'"
             id="chunk-{{ $chunkIndex }}">
            @foreach($chunk as $bIndex => $business)
                @php $globalIndex = $chunkIndex * $adInterval + $bIndex; @endphp
                <div class="business-card"
                     data-name="{{ strtolower($business['name'] ?? '') }}"
                     data-category="{{ strtolower(is_array($business['category'] ?? '') ? implode(',', $business['category']) : ($business['category'] ?? '')) }}"
                     data-rating="{{ $business['rating'] ?? 0 }}"
                     data-verified="{{ ($business['verified'] ?? false) ? '1' : '0' }}"
                     data-open="{{ ($business['active_status'] ?? false) ? '1' : '0' }}"
                     data-reviews="{{ $business['reviewCount'] ?? 0 }}"
                     x-show="shouldShow($el)">
                    <x-business-card :business="$business" :index="$globalIndex" :view="'list'" />
                </div>
            @endforeach
        </div>      
        @if(!$loop->last)
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 my-3 shadow-md">
                    <div class="relative px-5 py-4 flex items-center gap-5 flex-wrap sm:flex-nowrap">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5 flex-wrap">
                                <span class="text-[9px] font-bold text-white/60 border border-white/20 px-2 py-0.5 rounded-full uppercase tracking-widest">Sponsored</span>
                                <span class="text-[9px] font-bold text-amber-300 bg-amber-300/10 border border-amber-300/20 px-2 py-0.5 rounded-full animate-pulse">Featured Offer</span>
                            </div>
                            <p class="text-white font-bold text-base sm:text-lg leading-tight">Get ₹500 Cashback on Your First Interior Design Order</p>
                            <p class="text-white/70 text-xs mt-0.5">Verified interior designers · Free consultation · 10,000+ happy homes</p>
                        </div>
                        <a href="{{ route('login') }}" class="flex-shrink-0 bg-white text-teal-700 font-bold text-sm px-5 py-2.5 rounded-xl hover:bg-white/90 shadow-lg whitespace-nowrap">Claim Offer</a>
                    </div>
            </div>
        @endif
    @endforeach

    {{-- Enquiry Modal --}}
    <div id="enquiry-modal"
         class="fixed inset-0 z-[210] items-center justify-center p-4"
         style="background:rgba(10,15,40,.75);backdrop-filter:blur(14px);"
         onclick="if(event.target===this)this.classList.remove('open')">
        <div class="relative w-full max-w-md overflow-hidden"
             style="border-radius:1.75rem;"
             onclick="event.stopPropagation()">
            @include('client.layouts.enquiry-popup-form', [
                'keywordList' => $keyword,
                'planOptions' => '',
                'formId' => 'modal'
            ])
        </div>
    </div>
@endif
 <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 my-3 shadow-md">
                    <div class="relative px-5 py-4 flex items-center gap-5 flex-wrap sm:flex-nowrap">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5 flex-wrap">
                                <span class="text-[9px] font-bold text-white/60 border border-white/20 px-2 py-0.5 rounded-full uppercase tracking-widest">Sponsored</span>
                                <span class="text-[9px] font-bold text-amber-300 bg-amber-300/10 border border-amber-300/20 px-2 py-0.5 rounded-full animate-pulse">Featured Offer</span>
                            </div>
                            <p class="text-white font-bold text-base sm:text-lg leading-tight">Get ₹500 Cashback on Your First Interior Design Order</p>
                            <p class="text-white/70 text-xs mt-0.5">Verified interior designers · Free consultation · 10,000+ happy homes</p>
                        </div>
                        <a href="{{ route('login') }}" class="flex-shrink-0 bg-white text-teal-700 font-bold text-sm px-5 py-2.5 rounded-xl hover:bg-white/90 shadow-lg whitespace-nowrap">Claim Offer</a>
                    </div>
                </div>
            </div>

            @if($totalReviews)
            {{-- Reviews Section --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-4">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-gray-900">User Reviews</h2>
                    
                </div>

                {{-- Rating summary --}}
                <div class="flex items-center gap-6 mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-blue-700">{{ $avgRating }}</div>
                        <div class="flex items-center gap-0.5 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <div class="text-xs text-gray-500 mt-1">{{ $totalReviews }} reviews</div>
                    </div>
                    <div class="flex-1 space-y-1.5">
                        @foreach($starPercentages as $s)
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 w-3">{{ $s['star'] }}</span>
                            <svg class="w-3 h-3 fill-amber-400 text-amber-400" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full" style="width: {{ $s['percent'] }}%"></div>
                            </div>
                            <span class="text-xs text-gray-400 w-16">{{ $s['percent'] }}% ({{ $s['count'] }})</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{-- Review list --}}
                @forelse($reviews as $review)
                @php
                    $rName = $review->business_name ?? 'Anonymous';
                    $rWords = explode(' ', $rName);
                    $rInitials = strtoupper(substr($rWords[0], 0, 1) . (isset($rWords[1]) ? substr($rWords[1], 0, 1) : ''));
                    $rRating = round(floatval($review->avg_rating ?? 0));
                @endphp
                <div class="flex gap-3 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                        {{ $rInitials }}
                    </div>
                    <div class="flex-1">
                        <span class="text-sm font-semibold text-gray-800">{{ $rName }}</span>
                        <div class="flex items-center gap-0.5 mt-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3.5 h-3.5 {{ $i <= $rRating ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        @if(!empty($review->comment_content))
                        <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">{{ $review->comment_content }}</p>
                        @endif
                        @if(!empty($review->comment_author))
                        <p class="text-xs text-gray-500 mt-1 font-semibold">— {{ $review->comment_author }}</p>
                        @endif
                        <button class="flex items-center gap-1 text-xs text-gray-400 hover:text-blue-600 mt-1.5 transition-colors">👍 Helpful</button>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">No reviews yet.</p>
                @endforelse
            </div>

            @endif
            {{-- Property Banner --}}
            <div class="w-full bg-[#E9D9B8] rounded-lg p-4 mt-4 md:p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 flex items-center justify-center overflow-hidden rounded-lg">
    
    <img 
        src="{{ $kwData['key_icon'] ?? $kwData['child_icon'] ??'' }}" 
        alt="{{ $keyword }}"
        class="w-16 h-16 object-contain group-hover:scale-105 transition-transform duration-500"
        width="100"
        height="100"
        loading="lazy"
        decoding="async">
</div>
                <div>
                        <h3 class="text-lg md:text-xl font-bold text-gray-800">Attention!</h3>
                        <p class="text-sm md:text-base font-semibold text-gray-700">Advertise Owners</p>
                    </div>
                </div>
                <div class="text-center md:text-left max-w-md">
                    <p class="text-sm md:text-base text-gray-800 leading-relaxed">Looking to {{ $keyword }}? Advertise on Quickdials Provider</p>
                </div>
                <div>
                    <button class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-md flex items-center gap-2 transition">
                        Advertise Now →
                    </button>
                </div>
            </div>

            {{-- Quick Response Section --}}
            <div class="py-10 bg-gray-50 mt-4 rounded-2xl">
                <div class="px-4">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="text-4xl">⏱️</div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">Get Quick Responses in <span class="text-blue-600">less than 60 Minutes</span></h2>
                            <p class="text-gray-600 mt-1">Businesses shown here are currently active and respond faster than average</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    
                        @if($quickBusinesses)
                        @foreach($quickBusinesses ?? [] as $qb)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                            <div class="relative w-full h-48 overflow-hidden rounded-t-2xl bg-gray-100">
                                <img loading="lazy"
                                    decoding="async" src="{{ $qb['image'] ?? '' }}" alt="{{ $qb['name'] ?? '' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" >
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= floor($qb['rating'] ?? 0) ? 'fill-yellow-400' : 'fill-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $qb['rating'] ?? 0 }}</span>
                                    <span class="text-gray-500 text-sm">({{ $qb['reviewCount'] ?? 0 }} Ratings)</span>
                                </div>
                                <h3 class="font-semibold text-lg leading-tight mb-1 line-clamp-2">{{ $qb['name'] ?? '' }}</h3>
                                <p class="text-gray-600 text-sm mb-4">{{ $qb['location'] ?? '' }}</p>
                                <div class="flex gap-3">
                                    <a href="{{ route('business.details', $qb['slug']) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-xl font-medium transition-all flex items-center justify-center gap-2">
                                        💬 Send Enquiry
                                    </a>
                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $qb['phone'] ?? '') }}" rel="nofollow noopener noreferrer" target="_blank"
                                       class="flex items-center justify-center w-12 h-12 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                                        <img src="{{ asset('WhatsApp.svg') }}" alt="WhatsApp" class="w-6 h-6" loading="lazy"
                                            decoding="async">
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

            @if(!empty($growthBusiness))
            {{-- Grow Your Business Banner --}}
            <section class="w-full bg-[#057AEC] rounded-lg overflow-hidden mt-4">
                <div class="flex flex-col lg:flex-row items-center">
                    <div class="flex-1 text-white px-6 py-10 md:px-10">
                        <span class="text-2xl md:text-3xl font-bold mb-3">Trying to grow your business?</span>
                        <p class="text-sm md:text-base mb-6 text-gray-200">Create a listing on Quickdials now and start getting enquiries</p>
                        <div class="flex flex-wrap items-center gap-6 md:gap-10 mb-6">
                            <div><h3 class="text-xl font-bold text-orange-300">{{ $growthBusiness['Keyword'] ??''}}</h3><p class="text-sm text-gray-200">Service Visitors</p></div>
                            <div class="hidden md:block w-px h-10 bg-gray-400"></div>
                            <div><h3 class="text-xl font-bold text-orange-300">{{ $growthBusiness['ProductsServices']??'' }}</h3><p class="text-sm text-gray-200">Products Services</p></div>
                            <div class="hidden md:block w-px h-10 bg-gray-400"></div>
                            <div><h3 class="text-xl font-bold text-orange-300">{{ $growthBusiness['GrowClient']??'' }}</h3><p class="text-sm text-gray-200">Listed Businesses</p></div>
                        </div>
                        <a href="{{ route('login') }}" class="inline-block bg-orange-500 hover:bg-orange-600 px-6 py-3 rounded-md font-semibold mb-6 transition">Add Your Business</a>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-200">
                            <p>⚙️ Create your complete profile</p>
                            <p>⚙️ Display your service offerings</p>
                            <p>⚙️ Respond to customer enquiries</p>
                            <p>⚙️ Beat the competition</p>
                        </div>
                    </div>
                </div>
            </section>
@endif
        </main>

        {{-- Sidebar --}}
        <aside class="hidden lg:block w-80 xl:w-96 flex-shrink-0 sticky top-[80px] self-start">
            <div class="pt-2">@include('client.components.sidebar-enquiry')</div>

            {{-- Ad Tiles --}}
            <div class="pb-3 pt-2 border-t border-gray-100 mt-3 flex flex-col gap-2">
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 p-3 cursor-pointer hover:-translate-y-0.5 transition-transform">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 flex-shrink-0 bg-white/20 rounded-xl flex items-center justify-center border border-white/30">🛏</div>
                        <div class="flex-1 min-w-0">
                            <span class="text-[9px] font-bold text-white/60 uppercase tracking-widest">Sponsored</span>
                            <p class="text-white font-bold text-xs leading-tight">Sleep Better Tonight</p>
                            <p class="text-white/70 text-[10px]">Orthopedic mattresses from ₹4,999</p>
                        </div>
                        <button class="flex-shrink-0 flex items-center gap-1 px-2.5 py-1 bg-white/20 hover:bg-white/30 border border-white/30 text-white text-[10px] font-bold rounded-lg transition-all whitespace-nowrap">View Deals ↗</button>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 p-3 cursor-pointer hover:-translate-y-0.5 transition-transform">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 flex-shrink-0 bg-white/20 rounded-xl flex items-center justify-center border border-white/30">🛍</div>
                        <div class="flex-1 min-w-0">
                            <span class="text-[9px] font-bold text-white/60 uppercase tracking-widest">Sponsored</span>
                            <p class="text-white font-bold text-xs leading-tight">Home Decor Sale</p>
                            <p class="text-white/70 text-[10px]">Up to 60% off on premium furniture</p>
                        </div>
                        <button class="flex-shrink-0 flex items-center gap-1 px-2.5 py-1 bg-white/20 hover:bg-white/30 border border-white/30 text-white text-[10px] font-bold rounded-lg transition-all whitespace-nowrap">Shop Now ↗</button>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    {{-- Agents comparison table --}}
    @if(count($agents ?? []) > 0)
    <section class="w-full p-4">
        <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold mb-4">TOP {{ count($agents) }} {{ $keyword }} in {{ ucwords(strtolower(str_replace('-', ' ', $city))) }}</h2>
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
  @if( !in_array($cityName, $singleCities) ||
    !in_array($kwData['keyword_slug'], $keywordArray))
    {{-- Course About --}}
    @if(!empty($kwData['heading']) && !empty($kwData['courseabout']))
    <div class="border rounded-lg p-4 bg-white shadow-sm mx-4">
        <section class="rounded-md p-1">
            <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-semibold text-blue-900">{{ $kwData['heading'] }}</h2>
            <div class="w-full h-[2px] bg-teal-500 mt-3 mb-5"></div>
            <div class="text-gray-800 leading-relaxed mb-5">{!! $kwData['courseabout'] !!}</div>
            <ul class="space-y-3">
                @foreach(['paragraph1','paragraph2','paragraph3','paragraph4','paragraph5','paragraph6','paragraph7','paragraph8'] as $p)
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
@endif

    @if($shouldIndex && $cityName =='faridabad')
       {{-- top_wcity_description --}}
    @if(!empty($kwData['top_wcity_description']))
     @php
    $top_wcity_heading = '';

    if (!empty($kwData['top_wcity_heading'])) {
        $top_wcity_heading=  $kwData['top_wcity_heading'];
    }   
    @endphp

    <div class="bg-white rounded-2xl p-6 mt-4 mx-4">
        <h2 class="text-lg font-bold text-gray-900 mb-3"> {{ $top_wcity_heading }}</h2>
        <div class="text-sm text-gray-600 leading-relaxed">{!! $kwData['top_wcity_description'] !!}</div>
    </div>
    @endif


     {{-- bottom_wcity_heading --}}
    @if(!empty($kwData['bottom_wcity_description']))
    
    @php
    $bottom_wcity_heading = '';
    if (!empty($kwData['bottom_wcity_heading'])) {
        $bottom_wcity_heading=  $kwData['bottom_wcity_heading'];
    }   
    @endphp
    <div class="bg-white rounded-2xl p-6 mt-4 mx-4">
        <h2 class="text-lg font-bold text-gray-900 mb-3"> {{ $bottom_wcity_heading }}</h2>
        <div class="text-sm text-gray-600 leading-relaxed">{!! $kwData['bottom_wcity_description'] !!}</div>
    </div>
    @endif

@endif

  @if(!in_array($cityName, $singleCities) ||
    !in_array($kwData['keyword_slug'], $keywordArray))
    {{-- Top Description --}}
    @if(!empty($topDescription))
    <div class="bg-white rounded-2xl p-6 mt-4 mx-4">
    @php
    $defaultHeading = '';

    if (!empty($kwData['top_heading'])) {
        $defaultHeading=  $kwData['top_heading'];
    }else{
     $defaultHeading = 'Trusted '. $keyword . ' in ' . ucwords(strtolower(str_replace('-', ' ', $city)));
    }    
    @endphp

    <h2 class="text-lg font-bold text-gray-900 mb-3">
         {{ $defaultHeading }}
    </h2>
    <div class="text-sm text-gray-600 leading-relaxed">{!! $topDescription !!}</div>
    </div>
    @endif

@endif


<style>
    .leading-relaxed h3{
        font-size: 1.225rem;
        line-height: 1.75rem;
        font-weight: 700;

    }

    .leading-relaxed h4{
        font-size: 1.125rem;
        line-height: 1.75rem;
        font-weight: 700;

    }

    .leading-relaxed h5{
        font-size: 0.925rem;
        line-height: 1.75rem;
        font-weight: 700;

    }
    table {
        width:100%;
    }
    </style>

    @if(!in_array($cityName, $singleCities) ||
    !in_array($kwData['keyword_slug'], $keywordArray))
    {{-- Bottom Description --}}
    @if(!empty($bottomDescription))


     @php
    $bottom_heading = '';

    if (!empty($kwData['bottom_heading'])) {
        $bottom_heading=  $kwData['bottom_heading'];
    }else{
     $bottom_heading = 'Find the Best '.$keyword . ' in ' . ucwords(strtolower(str_replace('-', ' ', $city)));
    }    
    @endphp

    <div class="bg-white rounded-2xl shadow-sm p-6 mt-4 mx-4">
        <h2 class="text-lg font-bold text-gray-900 mb-3">{{ $bottom_heading }}</h2>
        <div class="text-sm text-gray-600 leading-relaxed">{!! $bottomDescription !!}</div>
    </div>
    @endif


    {{-- extra_description --}}
    @if(!empty($kwData['extra_description']))
     @php
    $extra_heading = '';

    if (!empty($kwData['extra_heading'])) {
        $extra_heading=  $kwData['extra_heading'];
    }else{
     $extra_heading = $keyword . ' in ' .ucwords(strtolower(str_replace('-', ' ', $city)));
    }    
    @endphp

    <div class="bg-white rounded-2xl shadow-sm p-6 mt-4 mx-4">
        <h2 class="text-lg font-bold text-gray-900 mb-3"> {{ $extra_heading }}</h2>
        <div class="text-sm text-gray-600 leading-relaxed">{!! $kwData['extra_description'] !!}</div>
    </div>
    @endif
@endif


  @if($shouldIndex && $cityName =='faridabad')
              
  @if($kwData['keyword_slug']=='artificial-intelligence-training' && $cityName =='faridabad')
    <div class="bg-white rounded-2xl shadow-sm p-6 mt-4 mx-4" x-data="{ openFaq: null }">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            💬 Frequently Asked Questions(FAQ's) {{ $city }}
        </h3>
        <div class="space-y-2">
        
            
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 1 ? null : 1"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Is AI training suitable for beginners?</h3> 
                    <span x-text="openFaq === 1 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 1" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Yes, training in AI is good for beginners too. Anyone interested in learning about Artificial Intelligence can be part of this course. There is no need to have prior knowledge about AI to start with. Some basic knowledge of computers is preferable, but the course starts from the basics and moves ahead gradually.
                </div>
            </div>



              <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 2 ? null : 2"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>What skills will AI training develop?</h3> 
                    <span x-text="openFaq === 2 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 2" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   After this training, you will become knowledgeable about the basics of AI, ways of using AI technology, and project work. This knowledge may prove helpful in helping you prepare for AI-related jobs in the future. Additionally, you will acquire problem-solving, data analysis, and application skills that will enable you to prepare yourself for jobs that involve AI in the future.
                </div>
            </div>
           

            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 3 ? null : 3"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>How long does artificial intelligence training take?</h3> 
                    <span x-text="openFaq === 3 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 3" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                    The duration of most artificial intelligence training courses is between 6 and 9 months. This varies from course to course and according to other factors like the method of training and the batch that one opts for. In this duration, you will learn about AI and how to implement it practically.
                </div>
            </div>
           

            

            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 4 ? null : 4"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Does AI course provide placement assistance Faridabad?</h3> 
                    <span x-text="openFaq === 4 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 4" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Yes, many AI courses in Faridabad offer placement assistance. You get help with making your resume, preparing for an interview, and with your job placements. Your job placement will depend on your skills, projects, and the performance of your interview. Some institutes even conduct mock interviews to prepare you for the job.
                </div>
            </div>
           
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 5 ? null : 5"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>How does AI course support career growth?</h3> 
                    <span x-text="openFaq === 5 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 5" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                 An AI class will teach you the skills that many firms need, and this could boost your resume and even enable you to apply for jobs. AI will also make your work easier by enabling you to complete your tasks much faster.
                </div>
            </div>
           
            
            
            
        </div>
    </div>
    @elseif($kwData['keyword_slug']=='python-training' && $cityName =='faridabad')


     <div class="bg-white rounded-2xl shadow-sm p-6 mt-4 mx-4" x-data="{ openFaq: null }">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            💬  Frequently Asked Questions About Python Training in Faridabad
        </h3>
        <div class="space-y-2">
        
            
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 1 ? null : 1"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>What is the duration of Python training in Faridabad?	</h3> 
                    <span x-text="openFaq === 1 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 1" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   It all depends on the course level, curriculum, training mode, and class schedule. A simple Python program may take a few weeks, but more complicated courses involving Data Science, Machine Learning, or other projects may take months. 
                </div>
            </div>



              <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 2 ? null : 2"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3> How much does Python training cost in Faridabad?</h3> 
                    <span x-text="openFaq === 2 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 2" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   The cost of Python training in Faridabad depends on the course duration, the trainer's experience, the training mode, projects, certification, and other technologies. Urban Pro currently lists Python training rates of about ₹300–₹500 per hour, while its Faridabad Python course page gives ₹3,600–₹6,000/month for 1-to-1 classes and ₹2,880–₹4,800/month for group classes.
                </div>
            </div>
           

            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 3 ? null : 3"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Can beginners join Python classes in Faridabad?</h3> 
                    <span x-text="openFaq === 3 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 3" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                    Yes, beginner learners can take Python classes that are designed for learners who do not have any programming knowledge at all. Computer basics is good but prior Python programming knowledge is not normally needed.
                </div>
            </div>
           

            

            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 4 ? null : 4"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Are online Python classes available in Faridabad?</h3> 
                    <span x-text="openFaq === 4 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 4" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Yes, there are different classes for online learners, classroom training and one-to-one training available for Faridabad learners. Online learning may help students and professionals who dont want to travel daily. Live online classes with video recording options are also available, in addition to one-to-one training.
                </div>
            </div>
           
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 5 ? null : 5"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Is Python useful for data science and AI careers?</h3> 
                    <span x-text="openFaq === 5 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 5" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                 Yes, Python is useful if you want to learn Data Science or AI. It is used for working with data, making charts and building Machine Learning models. You can start with basic Python and later learn tools like Pandas, NumPy and Scikit-learn. After learning Python, you can explore roles like Data Analyst, Data Scientist, ML Engineer or AI Developer. Other skills and project practice are also needed.
                </div>
            </div>
           
            
            
            
        </div>
    </div>

    @elseif($kwData['keyword_slug']=='workday-training' && $cityName =='faridabad')

  <div class="bg-white rounded-2xl shadow-sm p-6 mt-4 mx-4" x-data="{ openFaq: null }">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            💬 Frequently Asked Questions About Workday Training in Faridabad</h3>
        <div class="space-y-2">
        
            
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 1 ? null : 1"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>What is the duration of Workday training in Faridabad?</h3> 
                    <span x-text="openFaq === 1 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 1" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Every training institute has their own duration for each course. The time required to complete a basic Workday course can be just a few weeks, but a comprehensive one like HCM can take more time. Some institutes have courses ranging from 45+ hours, whereas some in Faridabad offer two-month courses as well.
                </div>
            </div>



              <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 2 ? null : 2"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>How much does Workday training cost in Faridabad?</h3> 
                    <span x-text="openFaq === 2 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 2" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Workday Training charges are based on the module, time period, instructor, practical training, and the type of training that is being offered. The currently published fee structure varies between Rs. 15,000 and Rs. 34,000 for some courses, whereas others fall within a higher fee structure.
                </div>
            </div>
           

            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 3 ? null : 3"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Can beginners join Workday classes in Faridabad?</h3> 
                    <span x-text="openFaq === 3 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 3" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                    Yes, beginner level students may begin with basic understanding of Workday and HCM. But having knowledge of Human Resource, Payroll, Business Process, and basic IT can make the learning process easier. It would be better to select a course which begins with basics rather than selecting advanced courses.
                </div>
            </div>
           

            

            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 4 ? null : 4"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Are online Workday classes available in Faridabad?</h3> 
                    <span x-text="openFaq === 4 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 4" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Yes, Classes for Workday online are available, and many training institutions offer live online batch classes as well as physical class sessions. Online classes are good for professionals and students who are unable to attend class sessions at the training institution daily.
                </div>
            </div>
           
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 5 ? null : 5"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Do Workday courses include practical training?</h3> 
                    <span x-text="openFaq === 5 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 5" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                 It all depends on the institution. There are some that incorporate practical projects and Workday system training, whereas others just concentrate on theory alone. When signing up for the program, ask whether practical training is given in the fees and how long you will be given for practicing. 
                </div>
            </div>
           
            
            
            
        </div>
    </div>

    @elseif($kwData['keyword_slug']=='sap-training' && $cityName =='faridabad')

        <div class="bg-white rounded-2xl shadow-sm p-6 mt-4 mx-4" x-data="{ openFaq: null }">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            💬 Frequently Asked Questions About Workday Training in Faridabad</h3>
        <div class="space-y-2">
        
            
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 1 ? null : 1"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>What is the duration of Workday training in Faridabad?</h3> 
                    <span x-text="openFaq === 1 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 1" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Every training institute has their own duration for each course. The time required to complete a basic Workday course can be just a few weeks, but a comprehensive one like HCM can take more time. Some institutes have courses ranging from 45+ hours, whereas some in Faridabad offer two-month courses as well.
                </div>
            </div>



              <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 2 ? null : 2"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>How much does Workday training cost in Faridabad?</h3> 
                    <span x-text="openFaq === 2 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 2" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Workday Training charges are based on the module, time period, instructor, practical training, and the type of training that is being offered. The currently published fee structure varies between Rs. 15,000 and Rs. 34,000 for some courses, whereas others fall within a higher fee structure.
                </div>
            </div>
           

            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 3 ? null : 3"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Can beginners join Workday classes in Faridabad?</h3> 
                    <span x-text="openFaq === 3 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 3" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                    Yes, beginner level students may begin with basic understanding of Workday and HCM. But having knowledge of Human Resource, Payroll, Business Process, and basic IT can make the learning process easier. It would be better to select a course which begins with basics rather than selecting advanced courses.
                </div>
            </div>
           

            

            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 4 ? null : 4"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Are online Workday classes available in Faridabad?</h3> 
                    <span x-text="openFaq === 4 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 4" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                   Yes, Classes for Workday online are available, and many training institutions offer live online batch classes as well as physical class sessions. Online classes are good for professionals and students who are unable to attend class sessions at the training institution daily.
                </div>
            </div>
           
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === 5 ? null : 5"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3>Do Workday courses include practical training?</h3> 
                    <span x-text="openFaq === 5 ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
                </button>
                <div x-show="openFaq === 5" x-cloak class="px-4 pb-4 text-xs text-gray-500 leading-relaxed border-t border-gray-100 pt-3" >
                 It all depends on the institution. There are some that incorporate practical projects and Workday system training, whereas others just concentrate on theory alone. When signing up for the program, ask whether practical training is given in the fees and how long you will be given for practicing. 
                </div>
            </div>
           
            
            
            
        </div>
    </div>

    @elseif($kwData['keyword_slug']=='banquet-hall' && $cityName =='faridabad')



    @elseif($kwData['keyword_slug']=='cricket-academy' && $cityName =='faridabad')



    @endif

  @else 
    {{-- FAQ --}}
    @if(count($faqs ?? []) > 0)
    <div class="bg-white rounded-2xl shadow-sm p-6 mt-4 mx-4" x-data="{ openFaq: null }">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            💬 Frequently Asked Questions(FAQ's) of {{ $keyword }}
        </h3>
        <div class="space-y-2">
        
            @foreach($faqs as $fi => $faq)
            @if(!empty($faq['q']) && !empty($faq['a']))
            <div  class="border border-gray-100 rounded-xl overflow-hidden mt-4">
                <button @click="openFaq = openFaq === {{ $fi }} ? null : {{ $fi }}"
                        class="w-full flex items-center justify-between px-4 py-3 text-left text-sm font-medium text-gray-800 hover:bg-gray-50 transition-colors" >
                 <h3> {{ $faq['q'] }}</h3> 
                    <span x-text="openFaq === {{ $fi }} ? '▲' : '▼'" class="text-gray-600 text-base flex-shrink-0 ml-2"></span>
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
@endif



    {{-- Related Categories --}}
    @if(!empty($relatedCategory))
    <div class="bg-white py-10 border-t border-gray-200 mt-4">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-4 md:mb-6">Related {{ $keyword }} Categories in <span class="text-blue-600">{{ ucwords(strtolower(str_replace('-', ' ',  $city ?: 'faridabad'))) }}</span></h2>
            <div class="flex flex-wrap gap-x-8 gap-y-3 text-[15px]">
                @foreach($relatedCategory as $slug_c => $name)
                <a href="{{ route('city.slug', ['city_slug'=> $cityName,'service_slug' => $slug_c])}}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">{{ $name }}</a>
                @endforeach
            </div>
            <div class="mt-8">
                <a href="{{ route('showCity',$city) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">View All Categories →</a>
            </div>
        </div>
    </div>
    @endif

    {{-- Other Cities --}}
    <div class="bg-white rounded-2xl p-6 mt-4 mx-4">
        <h2 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2"> Find {{ $keyword }} in Other City</h2>
        <ul class="flex flex-wrap gap-2 text-sm text-gray-600">
            @foreach($otherCities as $i => $c)
            <li class="flex items-center">
                <a href="{{ route('city.slug', ['city_slug' => $c,
                'service_slug' => $kwData['keyword_slug']?? null
                ]) }}" class="hover:text-indigo-600">{{ $keyword }} in {{ ucfirst($c) }}</a>
                @if($i !== count($otherCities) - 1)
                <span class="mx-1 text-gray-400">|</span>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
 
    {{-- Related Services --}}
    @if(!empty($servicesRelated))
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-4 mb-4 mx-4">
        <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-blue-900"> Find Services Related to {{ $keyword }} in {{ ucfirst($city) }}</h2>
        <ul class="flex flex-wrap gap-2 text-sm text-gray-600">
            @foreach($servicesRelated as $i => $service)
            <li class="flex items-center">
                <a href="{{ route('city.slug', ['city_slug'=>  $city ?: 'faridabad','service_slug' => $service['url']]) }}" class="hover:text-indigo-600">{{ $service['keyword'] ?? '' }}</a>
                @if($i !== count($servicesRelated) - 1)
                <span class="mx-1 text-gray-400">|</span>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    @endif
   
</div>

<script>
function listingPage() {
    return {
        showAd: true,
        view: 'list',
        search: '',
        sortBy: 'Best Match',
        activeCategory: 'All',
        minRating: 0,
        verifiedOnly: false,
        openOnly: false,
        showFilters: true,
        filteredCount: {{ count(collect($businesses)->flatten(1)->all()) }},

        get activeFilterCount() {
            return [this.verifiedOnly, this.openOnly, this.minRating > 0].filter(Boolean).length;
        },

        init() {
            this.applyFilters();
        },

        shouldShow(el) {
            const q = this.search.toLowerCase();
            const name = el.dataset.name ?? '';
            const cat = el.dataset.category ?? '';
            const rating = parseFloat(el.dataset.rating ?? 0);
            const verified = el.dataset.verified === '1';
            const open = el.dataset.open === '1';

            const matchSearch = !q || name.includes(q) || cat.includes(q);
            const matchCat = this.activeCategory === 'All' || cat.includes(this.activeCategory.toLowerCase());
            const matchRating = rating >= this.minRating;
            const matchVerified = !this.verifiedOnly || verified;
            const matchOpen = !this.openOnly || open;

            return matchSearch && matchCat && matchRating && matchVerified && matchOpen;
        },

        applyFilters() {
            this.$nextTick(() => {
                const cards = document.querySelectorAll('.business-card');
                let count = 0;
                cards.forEach(card => {
                    const visible = this.shouldShow(card);
                    card.style.display = visible ? '' : 'none';
                    if (visible) count++;
                });
                this.filteredCount = count;
            });
        },

        resetFilters() {
            this.search = '';
            this.activeCategory = 'All';
            this.minRating = 0;
            this.verifiedOnly = false;
            this.openOnly = false;
            this.applyFilters();
        }
    }
}
</script>
  
@endsection
