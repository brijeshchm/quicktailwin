 
@if(!empty($repairsData['data']['repairsServices']))
 
@php
$repairGradients = [
    'rgba(59,130,246,0.6)',   // blue
    'rgba(234,179,8,0.6)',    // yellow
    'rgba(6,182,212,0.6)',    // cyan
    'rgba(217,119,6,0.6)',    // amber
    'rgba(22,163,74,0.6)',    // green
    'rgba(99,102,241,0.6)',   // indigo
    'rgba(239,68,68,0.6)',    // rose
    'rgba(75,85,99,0.6)',     // gray
    'rgba(168,85,247,0.6)',   // purple
    'rgba(6,182,212,0.6)',    // cyan
    'rgba(22,163,74,0.6)',    // green
    'rgba(75,85,99,0.6)',     // gray
    'rgba(59,130,246,0.6)',   // blue
    'rgba(99,102,241,0.6)',   // indigo
    'rgba(217,119,6,0.6)',    // amber
    'rgba(234,179,8,0.6)',    // yellow
];
$repairItems = is_array($repairsData['data']['repairsServices']) ? $repairsData['data']['repairsServices'] : [];
@endphp
 
<section class="py-4 bg-white border-b border-gray-100">
    <div class="w-full px-4 md:px-8">
 
        {{-- Header --}}
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                    {{-- Wrench icon --}}
                    <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-black text-gray-900 leading-tight">Repair &amp; Services</h2>
                    <p class="text-gray-500 text-xs">Professional home repair at your doorstep.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('category.list') }}"
                   class="hidden sm:block text-blue-600 text-xs font-semibold hover:underline mr-1">
                    View All
                </a>
                <button onclick="repairScroll('left')" id="repair-prev"
                    class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-gray-500
                           hover:border-orange-400 hover:text-orange-500 hover:bg-orange-50
                           disabled:opacity-25 disabled:cursor-not-allowed transition-all opacity-25 cursor-not-allowed"
                    disabled>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="repairScroll('right')" id="repair-next"
                    class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-gray-500
                           hover:border-orange-400 hover:text-orange-500 hover:bg-orange-50 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
 
        {{-- Scrollable track --}}
        <div class="relative overflow-hidden"
             onmouseenter="repairPaused=true"
             onmouseleave="repairPaused=false">
            <div id="repair-scroll-track"
                 class="flex gap-3 overflow-x-auto pb-2"
                 style="scroll-behavior:smooth; scrollbar-width:none; -ms-overflow-style:none;">
 
                @foreach($repairItems as $i => $service)


                  @php
                $catUrl = match($service['type'] ?? '') {
                'keyword'    => route('showCity',        $service['url']),
                'child'      => route('child.show',      $service['url']),
                'categories' => route('categories.show', $service['url'])

                };
                @endphp



                @php
                    $grad = $repairGradients[$i % count($repairGradients)];
                @endphp
                <a href="{{ $catUrl }}"> 
                <div class="shrink-0 rounded-xl overflow-hidden relative group cursor-pointer border border-gray-100
                            hover:shadow-md hover:-translate-y-0.5 transition-all duration-300"
                     style="width:calc((100% - 12px) / 2.2); min-width:120px; max-width:200px;">
 
                    {{-- Image area --}}
                    <div class="relative overflow-hidden" style="height:100px;">
                        <a href="{{ $catUrl }}">
                            <img src="{{ $service['img'] ?? '' }}"
                                 alt="{{ $service['title'] ?? '' }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out"
                                 loading="lazy"
                                 style="height:100px;"/>
                        </a>
                        {{-- Gradient overlay matching COLOR_MAP --}}
                        <div class="absolute inset-0 pointer-events-none"
                             style="background: linear-gradient(to top, {{ $grad }}, transparent);"></div>
                    </div>
 
                    {{-- Card body --}}
                    <div class="p-2 bg-white relative">
                        <p class="text-[11px] font-bold text-gray-900 truncate mb-0.5">
                            <a href="{{ route('showCity', $service['url']) }}">{{ $service['title'] ?? '' }}</a>
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-0.5 text-[9px] text-gray-500">
                                <span class="text-yellow-400 text-[10px]">★</span>
                                <span class="font-semibold text-gray-700">{{ $service['rating'] ?? '4.5' }}</span>
                                <span class="text-gray-400">({{ $service['count'] ?? '333' }})</span>
                            </span>
                            <span class="text-[9px] font-semibold text-blue-600 group-hover:text-orange-500 transition-colors">
                                Book
                            </span>
                        </div>
                        {{-- Orange underline on hover --}}
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-orange-400
                                    scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                    </div>
                </div>

</a>
                @endforeach
 
            </div>
        </div>
    </div>
</section>
 
<style>
    #repair-scroll-track::-webkit-scrollbar { display: none; }
</style>
 
<script>
// ─── Repair Services Scroll ────────────────────────────────────────────────
let repairPaused = false;
const repairTrack = document.getElementById('repair-scroll-track');
const repairPrev  = document.getElementById('repair-prev');
const repairNext  = document.getElementById('repair-next');
 
function getRepairStep() {
    if (!repairTrack) return 160;
    const first = repairTrack.firstElementChild;
    return first ? first.offsetWidth + 12 : 160;
}
 
function updateRepairBtns() {
    if (!repairTrack) return;
    const atStart = repairTrack.scrollLeft <= 2;
    const atEnd   = repairTrack.scrollLeft >= repairTrack.scrollWidth - repairTrack.clientWidth - 4;
 
    repairPrev.disabled = atStart;
    repairPrev.classList.toggle('opacity-25',         atStart);
    repairPrev.classList.toggle('cursor-not-allowed', atStart);
    repairNext.disabled = atEnd;
    repairNext.classList.toggle('opacity-25',         atEnd);
    repairNext.classList.toggle('cursor-not-allowed', atEnd);
}
 
function repairScroll(dir) {
    if (!repairTrack) return;
    const step = getRepairStep();
    repairTrack.scrollBy({ left: dir === 'left' ? -step : step, behavior: 'smooth' });
}
 
if (repairTrack) {
    repairTrack.addEventListener('scroll', updateRepairBtns, { passive: true });
    updateRepairBtns();
 
    // Auto-scroll every 2 s, loop back when at end
    setInterval(() => {
        if (repairPaused) return;
        const atEnd = repairTrack.scrollLeft >= repairTrack.scrollWidth - repairTrack.clientWidth - 4;
        if (atEnd) {
            repairTrack.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            repairTrack.scrollBy({ left: getRepairStep(), behavior: 'smooth' });
        }
    }, 2000);
}
</script>
@endif



 