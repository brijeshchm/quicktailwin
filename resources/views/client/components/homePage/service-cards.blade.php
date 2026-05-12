{{-- ─────────────────────────────────────────
    POPULAR SERVICE CARDS (scrollable)
───────────────────────────────────────── --}}


@if(!empty($homeData['data']['popularSearches']))
<section class="py-4 bg-gray-50 border-y border-gray-100">
    <div class="w-full px-4 md:px-8">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="text-sm font-black text-gray-900 mb-0.5">Popular Services</h2>
                <p class="text-gray-500 text-xs">Most requested services in your area.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('business.services') }}" class="hidden sm:flex items-center gap-1 text-blue-600 text-xs font-semibold hover:underline mr-1">
                    View All
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <button onclick="serviceScroll('left')" id="svc-prev"
                    class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-all opacity-30 cursor-not-allowed">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button onclick="serviceScroll('right')" id="svc-next"
                    class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
 
        <div class="relative overflow-hidden">
            <div id="service-scroll-track"
                 onmouseenter="svcPaused=true" onmouseleave="svcPaused=false"
                 class="flex gap-3 overflow-x-auto pb-2"
                 style="scroll-behavior:smooth; scrollbar-width:none; -ms-overflow-style:none;">
                @foreach($homeData['data']['popularSearches'] as $svc)
                 @php
                $popSUrl = match($svc['type'] ?? '') {
                'keyword'    => route('showCity',        $svc['url']),
                'child'      => route('child.show',      $svc['url']),
                'categories' => route('categories.show', $svc['url'])

                };
                @endphp
                 <a href="{{ $popSUrl }}"
   title="{{ $svc['title'] ?? '' }}"
   class="block shrink-0 rounded-xl overflow-hidden relative group cursor-pointer shadow-sm hover:shadow-md transition-shadow duration-300"
   style="width:calc((100% - 12px) / 2.2); min-width:120px; max-width:200px;">

    <div class="h-[110px] sm:h-[130px] overflow-hidden relative">
        <img src="{{ $svc['img'] ?? '' }}"
             alt="{{ $svc['title'] ?? '' }}"
             loading="lazy"
             decoding="async"
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out"/>

        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent" aria-hidden="true"></div>

        @if(!empty($svc['tag']))
            <span class="absolute top-1.5 left-1.5 bg-white/20 text-white text-[9px] font-semibold px-1.5 py-0.5 rounded-full border border-white/20">
                {{ $svc['tag'] }}
            </span>
        @endif
    </div>

    <div class="bg-white px-2 py-1.5 border-t border-gray-100 relative">
        <p class="text-[11px] font-bold text-gray-800 truncate">
            {{ $svc['title'] ?? '' }}
        </p>
        <p class="text-[9px] text-blue-600 font-medium mt-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
            Explore →
        </p>
        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left" aria-hidden="true"></div>
    </div>

</a>

                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
 
 
<script>
// ─── Service Cards scroll ──────────────────────────────────────────────────
let svcPaused = false;
const svcTrack = document.getElementById('service-scroll-track');
 
function updateSvcBtns() {
    if (!svcTrack) return;
    document.getElementById('svc-prev').classList.toggle('opacity-30', svcTrack.scrollLeft <= 4);
    document.getElementById('svc-prev').classList.toggle('cursor-not-allowed', svcTrack.scrollLeft <= 4);
    document.getElementById('svc-next').classList.toggle('opacity-30', svcTrack.scrollLeft >= svcTrack.scrollWidth - svcTrack.clientWidth - 4);
}
if (svcTrack) {
    svcTrack.addEventListener('scroll', updateSvcBtns, { passive: true });
    setInterval(() => {
        if (svcPaused || !svcTrack) return;
        const atEnd = svcTrack.scrollLeft >= svcTrack.scrollWidth - svcTrack.clientWidth - 4;
        svcTrack.scrollBy({ left: atEnd ? -svcTrack.scrollWidth : (svcTrack.firstElementChild?.offsetWidth + 12 || 160), behavior: 'smooth' });
    }, 1000);
}
 
function serviceScroll(dir) {
    if (!svcTrack) return;
    const step = (svcTrack.firstElementChild?.offsetWidth + 12) || 160;
    svcTrack.scrollBy({ left: dir === 'left' ? -step : step, behavior: 'smooth' });
}
 

</script>
 