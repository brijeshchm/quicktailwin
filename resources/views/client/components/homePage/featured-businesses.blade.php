{{-- ─────────────────────────────────────────
    FEATURED BUSINESSES  (with ImageSlider)
───────────────────────────────────────── --}}
@if(!empty($homeData['data']['featuredBusinesses']))
 
{{-- ImageSlider styles (scoped, no external deps) --}}
<style>
.img-slider { position:relative; width:100%; height:160px; overflow:hidden; background:#f3f4f6; }
.img-slider-track { display:flex; height:100%; transition:opacity .5s ease; }
.img-slider-track img {
    position:absolute; inset:0;
    width:100%; height:100%; object-fit:cover;
    opacity:0;
    transition:opacity .6s ease;
    transform:scale(1);
    transition:opacity .6s ease, transform .5s ease;
}
.img-slider-track img.active { opacity:1; transform:scale(1.04); }
.img-slider-track img.prev   { opacity:0; transform:scale(1); }
 
/* Prev / Next buttons */
.slider-nav {
    position:absolute; top:50%; transform:translateY(-50%);
    background:rgba(0,0,0,.55); color:#fff;
    border:none; border-radius:50%;
    width:24px; height:24px;
    font-size:14px; line-height:1;
    cursor:pointer; z-index:10;
    display:flex; align-items:center; justify-content:center;
    opacity:0; transition:opacity .2s;
}
.img-slider:hover .slider-nav { opacity:1; }
.slider-nav.left  { left:6px; }
.slider-nav.right { right:6px; }
 
/* Dot indicators */
.slider-dots {
    position:absolute; bottom:6px; left:50%; transform:translateX(-50%);
    display:flex; gap:4px; z-index:10;
}
.slider-dot {
    width:5px; height:5px; border-radius:50%;
    background:rgba(255,255,255,.5); cursor:pointer;
    transition:background .2s, transform .2s;
    border:none; padding:0;
}
.slider-dot.active { background:#fff; transform:scale(1.3); }
 
/* Default placeholder icon */
.slider-placeholder {
    width:100%; height:100%;
    display:flex; align-items:center; justify-content:center;
    color:#d1d5db;
}
</style>
 
<section class="py-10 bg-white">
    <div class="w-full px-4 md:px-8">
        <div class="text-center mb-7">
            <h2 class="text-base font-black text-gray-900 mb-1.5">Featured Businesses</h2>
            <p class="text-gray-500 text-xs max-w-xl mx-auto">Discover top-rated professionals and highly recommended places.</p>
        </div>
 
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($homeData['data']['featuredBusinesses'] as $bizIdx => $biz)
 
            @php
               
                $baseUrl   = 'https://www.quickdials.com/';
                $defaultImg = $baseUrl . 'client/images/default_pp_small.png';
                $gallery   = $biz['gallery'] ?? [];
 
                $images = [];
                foreach ($gallery as $item) {
                    if (is_array($item)) {
                        // Structure (a): galley.large.src
                        $path = $item['galley']['large']['src'] ?? null;
                        if ($path) {
                            if (str_starts_with($path, 'http')) {
                                $images[] = $path;
                            } else {
                                $images[] = rtrim($baseUrl,'/') . '/' . ltrim($path, '/');
                            }
                            continue;
                        }
                        // Structure (b): logo key
                        $logo = $item['logo'] ?? null;
                        if ($logo) {
                            $images[] = str_starts_with($logo,'http') ? $logo : rtrim($baseUrl,'/').'/'.ltrim($logo,'/');
                            continue;
                        }
                    } elseif (is_string($item) && $item !== '') {
                        $images[] = str_starts_with($item,'http') ? $item : rtrim($baseUrl,'/').'/'.ltrim($item,'/');
                    }
                }
 
                if (empty($images)) { $images[] = $defaultImg; }
 
                $sliderId  = 'slider-' . $bizIdx;
                $imagesJson = json_encode($images);
            @endphp
 
            <div class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-lg hover:shadow-gray-200/50 hover:border-gray-200 transition-all duration-300 flex flex-col">
 
                {{-- ── IMAGE SLIDER ── --}}
                <div class="img-slider" id="{{ $sliderId }}"
                     onmouseenter="sliders['{{ $sliderId }}'].pause()"
                     onmouseleave="sliders['{{ $sliderId }}'].play()">
 
                    {{-- Images --}}
                    <div class="img-slider-track" id="{{ $sliderId }}-track">
                        @foreach($images as $imgIdx => $imgSrc)
                        <img src="{{ $imgSrc }}"
                             alt="{{ $biz['business_name'] ?? 'Gallery' }}"
                             class="{{ $imgIdx === 0 ? 'active' : '' }}"
                             loading="{{ $imgIdx === 0 ? 'eager' : 'lazy' }}"
                             onerror="this.src='{{ $defaultImg }}'"/>
                        @endforeach
                    </div>
 
                    {{-- Prev / Next (only if >1 image) --}}
                    @if(count($images) > 1)
                    <button class="slider-nav left" onclick="sliders['{{ $sliderId }}'].prev()" aria-label="Previous">&#8249;</button>
                    <button class="slider-nav right" onclick="sliders['{{ $sliderId }}'].next()" aria-label="Next">&#8250;</button>
 
                    {{-- Dots --}}
                    <div class="slider-dots" id="{{ $sliderId }}-dots">
                        @foreach($images as $imgIdx => $imgSrc)
                        <button class="slider-dot {{ $imgIdx === 0 ? 'active' : '' }}"
                                onclick="sliders['{{ $sliderId }}'].goTo({{ $imgIdx }})"
                                aria-label="Slide {{ $imgIdx + 1 }}"></button>
                        @endforeach
                    </div>
                    @endif
 
                    {{-- Rating badge --}}
                    <div class="absolute top-2.5 right-2.5 bg-white/90 backdrop-blur-sm px-1.5 py-0.5 rounded-md flex items-center gap-0.5 shadow-sm z-10">
                        <svg class="w-3 h-3 text-yellow-400 fill-yellow-400" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <span class="font-bold text-xs text-gray-900">{{ $biz['avgRating'] ?? '' }}</span>
                        <span class="text-[10px] text-gray-500">({{ $biz['rating'] ?? '' }})</span>
                    </div>
 
                    {{-- JS data attr --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            initSlider('{{ $sliderId }}', {!! $imagesJson !!}, 5000);
                        });
                    </script>
                </div>
                {{-- ── END SLIDER ── --}}
 
                <div class="p-3.5 flex flex-col flex-1">
 
                    {{-- Rating + Verified row --}}
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[10px] font-bold text-blue-600 bg-blue-600/10 px-1.5 py-0.5 rounded flex items-center gap-0.5">
                            <svg class="w-3 h-3 text-yellow-400 fill-yellow-400" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            {{ $biz['avgRating'] ?? '' }}
                            <span class="text-[9px] text-gray-400">({{ $biz['rating'] ?? '' }})</span>
                        </span>
                        @if(!empty($biz['trusted_status']))
                        <span class="text-[10px] font-medium text-emerald-600 flex items-center gap-0.5 bg-emerald-50 px-1.5 py-0.5 rounded">
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Verified
                        </span>
                        @endif
                    </div>
 
                    {{-- Business name --}}
                    <h3 class="text-sm font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-blue-600 transition-colors">
                        <a href="{{ route('business.details', $biz['business_slug']) }}">{{ $biz['business_name'] ?? '' }}</a>
                    </h3>
 
                    <div class="space-y-1.5 mb-3 flex-1">
                        {{-- Keywords --}}
                        @if(!empty($biz['keywords']))
                        <div class="flex items-center gap-1 flex-wrap">
                            @foreach(array_slice($biz['keywords'], 0, 3) as $kw)
                            <span class="text-[9px] sm:text-[11px] text-indigo-600 bg-indigo-50 border border-indigo-100 px-1.5 sm:px-2 py-0.5 rounded-full font-medium">
                                {{ $kw['keyword'] ?? $kw }}
                            </span>
                            @endforeach
                        </div>
                        @endif
 
                        {{-- Address --}}
                        @if(!empty($biz['address']))
                        <div class="flex items-start gap-2 text-gray-600">
                            <svg class="w-3.5 h-3.5 shrink-0 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-xs leading-tight">{{ $biz['address'] }}</span>
                        </div>
                        @endif
 
                        {{-- Phone --}}
                        @if(!empty($biz['call']))
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-3.5 h-3.5 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <a href="tel:{{ $biz['call'] }}" class="text-xs font-medium hover:text-blue-600 transition-colors">{{ $biz['call'] }}</a>
                        </div>
                        @endif
                    </div>
 
                    <div class="pt-2.5 border-t border-gray-100">
                        <a href="{{ route('business.details', $biz['business_slug']) }}"
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 rounded-lg transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
                
            </div>
            @endforeach
        </div>
 
        <!-- <div class="mt-7 text-center">
            <button class="px-6 py-2 rounded-full border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition-colors">
                Load More Businesses
            </button>
        </div> -->
    </div>
</section>
 
{{-- ── ImageSlider JS engine ────────────────────────────────────────────── --}}
<script>
/*
 * Vanilla JS ImageSlider — mirrors ImageSlider.tsx behaviour exactly.
 * Called once per business card via initSlider().
 * All slider instances live in window.sliders = { 'slider-0': {...}, ... }
 */
window.sliders = window.sliders || {};
 
function initSlider(id, images, interval) {
    if (!images || images.length === 0) return;
 
    const el    = document.getElementById(id);
    const track = document.getElementById(id + '-track');
    const dotsEl= document.getElementById(id + '-dots');
    if (!el || !track) return;
 
    const imgs  = track.querySelectorAll('img');
    const dots  = dotsEl ? dotsEl.querySelectorAll('.slider-dot') : [];
    let current = 0;
    let timer   = null;
    let paused  = false;
 
    function goTo(idx) {
        // Remove active from current
        imgs[current].classList.remove('active');
        if (dots[current]) dots[current].classList.remove('active');
 
        current = (idx + imgs.length) % imgs.length;
 
        imgs[current].classList.add('active');
        if (dots[current]) dots[current].classList.add('active');
    }
 
    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }
 
    function play() {
        paused = false;
        if (imgs.length <= 1) return;
        timer = setInterval(next, interval || 5000);
    }
 
    function pause() {
        paused = true;
        clearInterval(timer);
    }
 
    play();
 
    window.sliders[id] = { goTo, next, prev, play, pause };
}
</script>
@endif
