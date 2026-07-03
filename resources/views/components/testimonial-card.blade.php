@props(['name', 'business', 'category', 'quote', 'since'])

@php
    $initials = collect(explode(' ', $name))->map(fn ($n) => $n[0] ?? '')->implode('');
    $colors = ['#0076D7', '#22c55e', '#f97316', '#a855f7', '#06b6d4'];
    $color = $colors[strlen($name) % count($colors)];
@endphp

<div class="reveal bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition-shadow duration-200 hover:shadow-xl">
    <div class="relative h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
        <div class="w-20 h-20 rounded-full flex items-center justify-center text-white text-2xl font-bold"
             style="background: {{ $color }}">
            {{ $initials }}
        </div>
        <div class="absolute inset-0 flex items-center justify-center">
            <button type="button"
                    class="w-12 h-12 rounded-full bg-white/90 flex items-center justify-center shadow-lg hover:bg-white transition-colors"
                    aria-label="Play testimonial video for {{ $name }}">
                <i data-lucide="play" class="w-5 h-5 fill-brand-blue text-brand-blue ml-0.5"></i>
            </button>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-black/40 to-transparent"></div>
        <div class="absolute bottom-2 left-3 text-white">
            <p class="text-xs font-semibold">{{ $name }}</p>
            <p class="text-[10px] opacity-80">{{ $business }}</p>
        </div>
    </div>
    <div class="p-4">
        <span class="text-[10px] bg-blue-50 text-brand-blue px-2 py-0.5 rounded-full font-medium">{{ $category }}</span>
        <p class="mt-2 text-xs text-gray-600 leading-relaxed line-clamp-3">&ldquo;{{ $quote }}&rdquo;</p>
        <p class="mt-2 text-[10px] text-gray-400">Customer since {{ $since }}</p>
    </div>
</div>
