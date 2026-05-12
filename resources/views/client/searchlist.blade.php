@extends('client.layouts.app')
@section('title', $metaTitle ?? $metaTitle . ' in ' . ucfirst($city))
@section('description', $metaDescription ?? '')
@section('keyword', $metaKeywords ?? '')

@section('content')

 {{-- In your layout <head> or @push('styles') --}}
<style>
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
</style>

{{-- In your layout <body> --}}
<div id="scroll-progress"></div>

{{-- In @push('scripts') --}}
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
$otherCities = ['noida','delhi','gurgaon','faridabad','ghaziabad','mumbai','pune','greater-noida','chandigarh','meerut','ahmedabad','bangalore','lucknow','agra','indore','gorakhpur','kanpur','vijayawada','nashik','varanasi'];

$starMap = [
    0 => 'star_1.png', 2 => 'star_2.png', 3 => 'star_3.png',
    3.5 => 'star_3.5.png', 4 => 'star_4.png', 4.5 => 'star_4.5.png',
    4.75 => 'star_4.75.png', 5 => 'star_5.png',
];

$bgImage = $bgImage ?? '/computer-courses-training.jpg';

// Calculate star image key
$starKey = 0;
foreach ($starMap as $k => $v) {
    if ($ratingValue >= $k) $starKey = $k;
}
$starImg = $starMap[$starKey] ?? 'star_4.5.png';

// Reviews stats
$totalReviews = count($reviews ?? []);
$avgRating = $totalReviews > 0
    ? round(collect($reviews)->avg(fn($r) => floatval($r['avg_rating'] ?? 0)), 1)
    : 0;
$starCounts = [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];
foreach ($reviews ?? [] as $r) {
    $s = min(5, max(1, round(floatval($r['avg_rating'] ?? 0))));
    $starCounts[$s] = ($starCounts[$s] ?? 0) + 1;
}
$starPercentages = collect([5,4,3,2,1])->map(fn($s) => [
    'star' => $s,
    'count' => $starCounts[$s],
    'percent' => $totalReviews > 0 ? round(($starCounts[$s] / $totalReviews) * 100) : 0
]);
@endphp

<div class="min-h-screen bg-gray-50 flex flex-col mt-4"
     x-data="listingPage()" x-init="init()">

  

    {{-- Hero Banner --}}
    <div x-show="showAd" x-cloak
         class="relative w-full overflow-hidden h-40"
         style="background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-indigo-900/50"></div>
        <div class="relative w-full px-3 sm:px-8 py-3 sm:py-5 flex items-center gap-3 sm:gap-5 h-full">
            <div class="flex-1 min-w-0">
                <!-- <div class="flex items-center gap-1.5 sm:gap-2 mb-0.5 sm:mb-1 flex-wrap">
                    <span class="text-[9px] sm:text-[10px] font-bold text-white/60 border border-white/20 px-1.5 sm:px-2 py-0.5 rounded-full uppercase tracking-widest">Advertisement</span>
                    <span class="text-[9px] sm:text-[10px] font-bold text-amber-300 bg-amber-300/10 border border-amber-300/20 px-1.5 sm:px-2 py-0.5 rounded-full animate-pulse">Limited Time Offer</span>
                </div> -->
                <!-- <h2 class="text-white font-bold text-sm sm:text-xl leading-snug">Transform Your Sleep — Up to 50% Off Premium Mattresses</h2> -->
                <!-- <p class="text-white/70 text-[10px] sm:text-sm mt-0.5 hidden sm:block">Free delivery · 100-night trial · EMI starting ₹799/mo</p> -->
            </div>
            <div class="flex-shrink-0 flex items-center gap-2 sm:gap-3">
                
                
            </div>
        </div>
    </div>

    {{-- Filter / Sort bar --}}
    <div class="w-full bg-white border-b border-gray-100 px-4 sm:px-6 py-2">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
                {{-- Breadcrumb --}}
                <nav class="text-black text-xs sm:text-sm mb-1 flex items-center gap-1.5 flex-wrap">
                    <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                    <span>›</span>
                    @if($childSlug)
                    <a href="{{ route('child.show', $childSlug) }}" class="hover:text-indigo-600">{{ $childCat }}</a>
                    <span>›</span>
                    @endif
                    <span class="text-gray-600">{{ $keyword }} in {{ $area }}</span>
                </nav>

                <h1 class="text-lg font-bold text-gray-900 leading-tight">{{ $keyword }} in {{ ucfirst($city) }}</h1>

                {{-- Rating --}}
                <!-- <div itemscope itemtype="https://schema.org/Product" >
                <div itemProp="aggregateRating" itemScope itemType="https://schema.org/AggregateRating"
                     class="flex items-center gap-2 text-sm mt-1">
                    <img src="/client/images/{{ $starImg }}" alt="{{ $ratingValue }} star rating" class="h-4 w-auto">
                    <span itemProp="ratingValue">{{ $ratingValue }}</span>
                    <span>out of</span>
                    <span itemProp="bestRating">5</span>
                    <span>based on</span>
                    <span itemProp="ratingCount">{{ $ratingCount }}</span>
                    <span>ratings</span>
                </div></div> -->







                <div itemscope itemtype="https://schema.org/Product" class="space-y-2">

    {{-- Required: Product Name --}}
    <meta itemprop="name" content="{{ $productName ?? $serviceName ?? 'QuickDials Service' }}">

    {{-- Required: Product Image --}}
    @if(!empty($kwData['key_icon']))
        <meta itemprop="image" content="{{ $kwData['key_icon'] ?? $kwData['child_icon'] ??'' }}">
    @endif

    {{-- Optional: Description --}}
    @if(!empty($metaDescription))
        <meta itemprop="description" content="{{ $metaDescription }}">
    @endif

    {{-- Aggregate Rating --}}
    <div itemprop="aggregateRating"
         itemscope
         itemtype="https://schema.org/AggregateRating"
         class="flex items-center gap-2 text-sm">

        <img src="{{ asset('client/images/' . $starImg) }}"
             alt="{{ $ratingValue }} out of 5 stars"
             class="h-4 w-auto"
             width="80"
             height="16"
             loading="lazy">

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

                <p class="text-sm text-gray-500 mt-1">
                    Showing <span class="font-semibold text-gray-800" x-text="filteredCount"></span> results for
                    <span class="font-semibold text-blue-700">{{ $keyword }} in {{ ucfirst($city) }}</span>
                </p>
            </div>

            {{-- Controls --}}
            <div class="flex items-center gap-2 flex-wrap">
                <div class="relative">
                    <select x-model="sortBy" @change="applyFilters()"
                            class="appearance-none pl-3 pr-7 py-1.5 text-xs font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-xl outline-none cursor-pointer hover:border-indigo-300 transition-colors">
                        @foreach($sortOptions as $opt)
                        <option>{{ $opt }}</option>
                        @endforeach
                    </select>
                    <span class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs">▾</span>
                </div>

                <!-- <button @click="showFilters = !showFilters"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium border transition-all"
                        :class="showFilters ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300 hover:text-indigo-600'">
                    ⚙ Filters
                    <span x-show="activeFilterCount > 0"
                          class="w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center"
                          x-text="activeFilterCount"></span>
                </button> -->


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
                <!-- <div class="flex items-center bg-gray-100 rounded-xl p-0.5">
                    <button @click="view = 'list'" class="p-1.5 rounded-lg transition-all" :class="view === 'list' ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-400 hover:text-gray-600'">☰</button>
                    <button @click="view = 'grid'" class="p-1.5 rounded-lg transition-all" :class="view === 'grid' ? 'bg-white shadow-sm text-indigo-600' : 'text-gray-400 hover:text-gray-600'">⊞</button>
                </div> -->
            </div>
        </div>

        {{-- Category tabs --}}
        <div class="flex gap-2 flex-wrap mt-2">
            @foreach($categories as $cat)
            <button @click="activeCategory = '{{ $cat }}'; applyFilters()"
                    class="px-3 py-1 text-xs font-medium rounded-full border transition-all"
                    :class="activeCategory === '{{ $cat }}' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300'">
                {{ $cat }}
            </button>
            @endforeach
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
                <span class="text-gray-400 flex-shrink-0">🔍</span>
                <input type="text" placeholder="Search {{ $keyword }}…"
                       x-model="search" @input="applyFilters()"
                       class="flex-1 text-sm text-gray-800 placeholder-gray-400 bg-transparent outline-none min-w-0 border-gray-200">
                <button x-show="search" @click="search = ''; applyFilters()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
        </div>
    </div>

    {{-- Two-column body --}}
    <div class="flex-1 w-full flex gap-5 px-4 sm:px-6 py-5 items-start">

        {{-- Main content --}}
        <main class="flex-1 min-w-0">
 
            {{-- Listings --}}
            <!-- <div x-show="filteredCount === 0" class="text-center py-20">
                <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🔍</span>
                </div>
                <p class="text-gray-700 font-semibold mb-1">No businesses found</p>
                <p class="text-gray-400 text-sm">Try adjusting your search or filters</p>
                <button @click="resetFilters()" class="mt-4 px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700">Clear all filters</button>
            </div> -->

            <div id="listings-container" x-show="filteredCount > 0">
                @php $adInterval = 5; @endphp
                @foreach($businesses as $chunkIndex => $chunk)
                @php $chunkStart = $chunkIndex * $adInterval; @endphp

                <div :class="view === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4' : 'bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden divide-y divide-gray-50'"
                     id="chunk-{{ $chunkIndex }}">

                    <a 
                        href="{{ route('business.details', $chunk['business_slug']) }}"
                        class="block"
                    >
                    <div class="business-card"
                         data-name="{{ strtolower($chunk['name'] ?? '') }}"
                         data-category="{{ strtolower(is_array($chunk['category'] ?? '') ? implode(',', $chunk['category']) : ($chunk['category'] ?? '')) }}"
                         data-rating="{{ $chunk['rating'] ?? 4.0 }}"
                         data-verified="{{ $chunk['verified'] ? '1' : '0' }}"
                         data-open="{{ $chunk['isOpen'] ? '1' : '0' }}"
                         data-reviews="{{ $chunk['reviewCount'] ?? 0 }}"
                         x-show="shouldShow($el)">
                        <x-business-card :business="$chunk" :index="$chunkIndex" :view="'list'" />
                    </div>
                    </a>
                </div>

                {{-- Inline ad after every chunk except last --}}
               
                @endforeach


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
                @forelse($reviews ?? [] as $review)
                @php
                    $rName = $review['business_name'] ?? 'Anonymous';
                    $rWords = explode(' ', $rName);
                    $rInitials = strtoupper(substr($rWords[0], 0, 1) . (isset($rWords[1]) ? substr($rWords[1], 0, 1) : ''));
                    $rRating = round(floatval($review['avg_rating'] ?? 0));
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
                        @if(!empty($review['comment_content']))
                        <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">{{ $review['comment_content'] }}</p>
                        @endif
                        @if(!empty($review['comment_author']))
                        <p class="text-xs text-gray-500 mt-1 font-semibold">— {{ $review['comment_author'] }}</p>
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
        alt="{{ $qb['name'] ?? '' }}"
        class="w-8 h-8 object-contain group-hover:scale-105 transition-transform duration-500"
    >

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
                        @foreach($quickBusinesses ?? [] as $qb)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                            <div class="relative w-full h-48 overflow-hidden rounded-t-2xl bg-gray-100">
                                <img src="{{ $qb['image'] ?? '' }}" alt="{{ $qb['name'] ?? '' }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $qb['phone'] ?? '') }}" target="_blank"
                                       class="flex items-center justify-center w-12 h-12 border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" class="w-6 h-6">
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Grow Your Business Banner --}}
            <section class="w-full bg-[#057AEC] rounded-lg overflow-hidden mt-4">
                <div class="flex flex-col lg:flex-row items-center">
                    <div class="flex-1 text-white px-6 py-10 md:px-10">
                        <h2 class="text-2xl md:text-3xl font-bold mb-3">Trying to grow your business?</h2>
                        <p class="text-sm md:text-base mb-6 text-gray-200">Create a listing on Quickdials now and start getting enquiries</p>
                        <div class="flex flex-wrap items-center gap-6 md:gap-10 mb-6">
                            <div><h3 class="text-xl font-bold text-orange-300">{{ $growthBusiness['Keyword'] }}</h3><p class="text-sm text-gray-200">Service Visitors</p></div>
                            <div class="hidden md:block w-px h-10 bg-gray-400"></div>
                            <div><h3 class="text-xl font-bold text-orange-300">{{ $growthBusiness['ProductsServices'] }}</h3><p class="text-sm text-gray-200">Products Services</p></div>
                            <div class="hidden md:block w-px h-10 bg-gray-400"></div>
                            <div><h3 class="text-xl font-bold text-orange-300">{{ $growthBusiness['GrowClient'] }}</h3><p class="text-sm text-gray-200">Listed Businesses</p></div>
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
        <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold mb-4">TOP {{ count($agents) }} {{ $keyword }} in {{ ucfirst($city) }}</h2>
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
        <section class="bg-gray-100 border rounded-md p-6">
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

    {{-- Top Description --}}
    @if(!empty($topDescription))
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-4 mx-4">
        <h2 class="text-lg font-bold text-gray-900 mb-3">Trusted {{ $keyword }}</h2>
        <div class="text-sm text-gray-600 leading-relaxed">{!! $topDescription !!}</div>
    </div>
    @endif

    {{-- Bottom Description --}}
    @if(!empty($bottomDescription))
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-4 mx-4">
        <h2 class="text-lg font-bold text-gray-900 mb-3">Find the Best {{ $keyword }} in {{ $area }}</h2>
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




    {{-- Related Categories --}}
    @if(!empty($relatedCategory))
    <div class="bg-white py-10 border-t border-gray-200 mt-4">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900 mb-4 md:mb-6">Related Categories in <span class="text-blue-600">{{ ucfirst($city) }}</span></h2>
            <div class="flex flex-wrap gap-x-8 gap-y-3 text-[15px]">
                @foreach($relatedCategory as $slug => $name)
                <a href="{{ route('child.show', $slug) }}" class="text-gray-700 hover:text-blue-600 transition-colors duration-200">{{ $name }}</a>
                @endforeach
            </div>
            <div class="mt-8">
                <a href="{{ route('category.list') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">View All Categories →</a>
            </div>
        </div>
    </div>
    @endif

    {{-- Other Cities --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-4 mx-4">
        <h2 class="text-base font-bold text-gray-900 mb-3 flex items-center gap-2">🔍 Find {{ $keyword }} in Other City</h2>
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
        <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-blue-900">🔍 Find Services Related to {{ $keyword }}</h2>
        <ul class="flex flex-wrap gap-2 text-sm text-gray-600">
            @foreach($servicesRelated as $i => $service)
            <li class="flex items-center">
                <a href="{{ route('showCity', $service['url']) }}" class="hover:text-indigo-600">{{ $service['title'] ?? '' }}</a>
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
  

{{-- Modal: REMOVED `hidden`, controlled fully by CSS --}}
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

<style>
    #enquiry-modal { display: none; }
    #enquiry-modal.open { display: flex; }
    body.modal-open { overflow: hidden; }
</style>

@endsection
