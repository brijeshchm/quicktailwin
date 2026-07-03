@extends('client.layouts.app')
@section('title', 'News QuickDials- Local search, IT Training, Service, overseas education')
@section('description', 'News QuickDials- Local search, IT Training, Service, overseas education')
@section('keywords', 'News QuickDials- Local search, IT Training, Service, overseas education')
@section('content') 
 @extends('client.layouts.app')
@section('title', $seoTitle ?? 'News - QuickDials | Local search, IT Training, Service, overseas education')
@section('description', $seoDescription ?? 'Stay updated with the latest news across World, Business, Tech, Sports and more on QuickDials News.')
@section('keywords', 'QuickDials News, Local search, IT Training, Service, overseas education')
@section('content')
@include('client.components.banner-section')

<div
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
    class="min-h-screen bg-white font-sans"
>
 

 
    <div class="bg-white border-b border-gray-200 sticky top-14 z-40" x-data="{ el: null }">
        <div class="max-w-7xl mx-auto px-4 relative flex items-center">
            <button @click="$refs.tabs.scrollBy({ left: -200, behavior: 'smooth' })" class="flex-shrink-0 p-1 hover:bg-gray-100 rounded-full">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <div x-ref="tabs" class="flex gap-0 overflow-x-auto flex-1" style="scrollbar-width:none;-ms-overflow-style:none;">
                @foreach($categories as $cat)
                    <a
                        href="{{ $cat->parent_slug}}"
                        class="flex-shrink-0 px-4 py-3 text-sm font-medium border-b-2 transition-colors   text-gray-600 border-transparent hover:text-gray-800"
                    >
                        {{ $cat->parent_category }}
                    </a>
                @endforeach
            </div>

            <button @click="$refs.tabs.scrollBy({ left: 200, behavior: 'smooth' })" class="flex-shrink-0 p-1 hover:bg-gray-100 rounded-full">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="max-w-7xl mx-auto px-4 py-5">

        @if(($articles ?? collect())->isEmpty())
            {{-- Empty state — real production pages should always handle this --}}
            <div class="py-24 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2zM13 4v6h6"/></svg>
                <p class="text-sm">No articles published in this category yet.</p>
            </div>
        @else
            @php
                $featured = $articles->first();
                $mid = $articles->slice(1, 2);
                $sideSmall = $articles->slice(3, 3);
                $moreArticles = $articles->slice(6);
            @endphp

            {{-- Top Grid: Featured | Mid | Side --}}
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_1fr_320px] gap-5 mb-8">

                {{-- Featured Article --}}
                @if($featured)
                <a href="{{ route('news.show', $featured['slug']) }}" class="block group" data-reveal>
                    <div class="relative overflow-hidden rounded-lg">
                        <img src="{{ $featured['image'] }}" alt="{{ $featured['title'] }}" loading="eager"
                             class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3">
                            <span class="bg-[#0076D7] text-white text-[10px] font-bold px-2 py-0.5 rounded">{{ $featured['category'] }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h2 class="text-lg font-bold text-gray-900 leading-snug group-hover:text-[#0076D7] transition-colors line-clamp-3">
                            {{ $featured['title'] }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-500 line-clamp-3 leading-relaxed">{{ $featured['excerpt'] }}</p>
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <span class="font-medium text-gray-600">{{ $featured['source'] }}</span>
                                <span class="text-gray-300">&bull;</span>
                                <span>{{ $featured['time'] }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endif

                {{-- Middle Column --}}
                <div class="flex flex-col gap-5">
                    @foreach($mid as $article)
                        <a href="{{ route('news.show', $article['slug']) }}" class="block group" data-reveal data-reveal-delay="{{ $loop->index * 100 }}">
                            <div class="relative overflow-hidden rounded-lg">
                                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" loading="lazy"
                                     class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-2 left-2">
                                    <span class="bg-black/60 text-white text-[10px] font-semibold px-2 py-0.5 rounded">{{ $article['category'] }}</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <h3 class="text-sm font-bold text-gray-900 leading-snug group-hover:text-[#0076D7] transition-colors line-clamp-2">
                                    {{ $article['title'] }}
                                </h3>
                                <div class="flex items-center gap-1.5 text-xs text-gray-500 mt-2">
                                    <span class="font-medium text-gray-600">{{ $article['source'] }}</span>
                                    <span class="text-gray-300">&bull;</span>
                                    <span>{{ $article['time'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Right Side: Small Cards --}}
                <div class="border border-gray-200 rounded-lg overflow-hidden" data-reveal data-reveal-from="right">
                    <div class="divide-y divide-gray-100">
                        @foreach($sideSmall as $article)
                            <a href="{{ route('news.show', $article['slug']) }}" class="flex gap-3 p-3 hover:bg-gray-50 transition-colors group">
                                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" loading="lazy" class="w-20 h-16 object-cover rounded flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-semibold text-gray-800 leading-snug line-clamp-3 group-hover:text-[#0076D7] transition-colors">
                                        {{ $article['title'] }}
                                    </h4>
                                    <div class="flex items-center gap-1.5 text-[10px] text-gray-500 mt-1.5">
                                        <span class="font-medium text-gray-600">{{ $article['source'] }}</span>
                                        <span class="text-gray-300">&bull;</span>
                                        <span>{{ $article['time'] }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="p-3 text-center border-t border-gray-100">
                        <a href="{{ route('news.category', $activeCategory ?? 'latest') }}" class="text-[#0076D7] text-sm font-semibold hover:underline">
                            View more
                        </a>
                    </div>
                </div>
            </div>

            {{-- ===== LATEST VIDEO ===== --}}
            @if(!empty($videoArticles) && count($videoArticles))
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8" data-reveal>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#0076D7]" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        Latest Video
                    </h2>
                    @php $mainVideo = $videoArticles[0]; @endphp
                    <a href="{{ $mainVideo['url'] ?? '#' }}" class="relative rounded-xl overflow-hidden cursor-pointer group block">
                        <img src="{{ $mainVideo['image'] }}" alt="{{ $mainVideo['title'] }}" loading="lazy" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                            <div class="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 fill-[#0076D7] text-[#0076D7] ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                            <p class="text-white text-sm font-semibold line-clamp-2">{{ $mainVideo['title'] }}</p>
                            <p class="text-gray-300 text-xs mt-1">{{ $mainVideo['source'] }} &bull; {{ $mainVideo['time'] }}</p>
                        </div>
                    </a>
                </div>

                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#0076D7]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Related Video
                    </h2>
                    <div class="space-y-3">
                        @foreach(array_slice($videoArticles, 1) as $v)
                            <a href="{{ $v['url'] ?? '#' }}" class="flex gap-3 group">
                                <div class="relative flex-shrink-0">
                                    <img src="{{ $v['image'] }}" alt="{{ $v['title'] }}" loading="lazy" class="w-28 h-20 object-cover rounded-lg">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-8 h-8 rounded-full bg-white/80 flex items-center justify-center shadow">
                                            <svg class="w-3.5 h-3.5 fill-[#0076D7] text-[#0076D7] ml-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 leading-snug line-clamp-2 group-hover:text-[#0076D7] transition-colors">{{ $v['title'] }}</p>
                                    <div class="flex items-center gap-1.5 text-xs text-gray-500 mt-1.5">
                                        <span class="font-medium text-gray-600">{{ $v['source'] }}</span>
                                        <span class="text-gray-300">&bull;</span>
                                        <span>{{ $v['time'] }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- ===== MORE NEWS ===== --}}
            @if($moreArticles->isNotEmpty())
            <div class="mb-8" data-reveal>
                <h2 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">More Top Stories</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($moreArticles as $article)
                        <a href="{{ route('news.show', $article['slug']) }}" class="block group">
                            <div class="relative overflow-hidden rounded-lg">
                                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" loading="lazy" class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-2 left-2">
                                    <span class="bg-black/60 text-white text-[10px] font-semibold px-2 py-0.5 rounded">{{ $article['category'] }}</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <h3 class="text-sm font-semibold text-gray-900 leading-snug group-hover:text-[#0076D7] transition-colors line-clamp-3">
                                    {{ $article['title'] }}
                                </h3>
                                <div class="flex items-center gap-1.5 text-xs text-gray-500 mt-2">
                                    <span class="font-medium text-gray-600">{{ $article['source'] }}</span>
                                    <span class="text-gray-300">&bull;</span>
                                    <span>{{ $article['time'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        @endif

        {{-- Pagination — required once real data is wired in --}}
        @if(isset($articles) && method_exists($articles, 'links'))
            <div class="mt-6">{{ $articles->links() }}</div>
        @endif

    </main>
 

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var revealEls = document.querySelectorAll('[data-reveal]');
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var delay = parseInt(entry.target.getAttribute('data-reveal-delay') || '0', 10);
                setTimeout(function () { entry.target.classList.add('reveal-visible'); }, delay);
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
    revealEls.forEach(function (el) { obs.observe(el); });
});
</script>

<style>
    [data-reveal] { opacity: 0; transform: translateY(20px); transition: opacity .6s ease, transform .6s ease; }
    [data-reveal][data-reveal-from="right"] { transform: translateX(24px); }
    [data-reveal].reveal-visible { opacity: 1; transform: translate(0,0); }
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .line-clamp-3 { display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
    @media (prefers-reduced-motion: reduce) { [data-reveal] { opacity:1 !important; transform:none !important; transition:none !important; } }
</style>

 
  
 @endsection
