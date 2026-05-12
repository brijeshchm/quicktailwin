{{-- ─────────────────────────────────────────
    WEDDING PLANNING
───────────────────────────────────────── --}}
@if(!empty($weddingData['data']['weddingPlanning']))
<section class="relative overflow-hidden py-4 border-b border-yellow-900/50">
    {{-- Golden gradient background --}}
    <div class="absolute inset-0 bg-gradient-to-r from-[#7a4f00] via-[#b87800] to-[#7a4f00]"></div>
    <div class="absolute inset-0" style="background:radial-gradient(ellipse 70% 100% at 50% 50%,rgba(220,160,0,0.35),transparent)"></div>
    {{-- Shimmer sweep --}}
    <div class="absolute inset-0 opacity-30 pointer-events-none" style="background:linear-gradient(108deg,transparent 25%,rgba(255,215,0,0.55) 50%,transparent 75%);background-size:200% 100%;animation:shimmer-sweep 4s linear infinite;"></div>
 
    <div class="relative z-10 w-full px-4 md:px-8">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-md bg-pink-500/30 border border-pink-400/40 flex items-center justify-center shrink-0">
                    <svg class="w-3 h-3 text-pink-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402C1 3.759 3.8 1 7.2 1c1.99 0 3.814 1.046 4.8 2.698C13 1.046 14.81 1 16.8 1 20.2 1 23 3.76 23 7.191c0 4.105-5.37 8.863-11 14.402z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-black text-yellow-100 leading-tight drop-shadow">Wedding Planning</h2>
                    <p class="text-yellow-200/60 text-[10px] leading-none mt-0.5">Everything for your perfect day</p>
                </div>
            </div>
            <a href="{{ route('child.show', 'wedding-planning') }}" class="text-yellow-200 text-[10px] font-semibold hover:underline flex items-center gap-0.5">
                View All
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
 
        <div class="grid grid-cols-6 gap-2">
            @foreach($weddingData['data']['weddingPlanning'] as $i => $ws)
             @php
                $catUrl = match($ws['type'] ?? '') {
                'keyword'    => route('showCity',        $ws['url']),
                'child'      => route('child.show',      $ws['url']),
                'categories' => route('categories.show', $ws['url'])

                };
                @endphp

 <a href="{{ $catUrl }}">
            <div class="{{ $i >= 6 ? 'hidden md:block' : '' }} cursor-pointer group flex flex-col items-center gap-1.5">
                <div class="w-full aspect-square rounded-lg overflow-hidden border border-yellow-500/30 group-hover:border-yellow-300/70 shadow-md group-hover:shadow-yellow-500/20 group-hover:shadow-lg transition-all duration-300">
                   
                        <img src="{{ $ws['img'] ?? '' }}" alt="{{ $ws['title'] ?? '' }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out" loading="lazy"/>
                   
                </div>
                <span class="text-[9px] font-bold text-yellow-100 group-hover:text-yellow-300 text-center w-full px-0.5 transition-colors drop-shadow leading-tight line-clamp-2">
                    {{ $ws['title'] ?? '' }}
                </span>
            </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif