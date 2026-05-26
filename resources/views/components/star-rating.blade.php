@props([
    'rating' => 0,
    'count' => null,
    'showCount' => true,
    'size' => 'sm', // sm | md | lg
])

@php
    $sizes = ['sm' => 'w-3.5 h-3.5', 'md' => 'w-4 h-4', 'lg' => 'w-5 h-5'];
    $iconClass = $sizes[$size] ?? $sizes['sm'];
    $full = floor($rating);
    $half = ($rating - $full) >= 0.5;
    $empty = 5 - $full - ($half ? 1 : 0);
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-1.5']) }}>
    <div class="flex items-center">
        @for ($i = 0; $i < $full; $i++)
            <i data-lucide="star" class="{{ $iconClass }} fill-accent text-accent"></i>
        @endfor
        @if ($half)
            <span class="relative inline-block {{ $iconClass }}">
                <i data-lucide="star" class="{{ $iconClass }} text-muted-foreground/30 absolute inset-0"></i>
                <span class="absolute inset-0 overflow-hidden" style="width:50%">
                    <i data-lucide="star" class="{{ $iconClass }} fill-accent text-accent"></i>
                </span>
            </span>
        @endif
        @for ($i = 0; $i < $empty; $i++)
            <i data-lucide="star" class="{{ $iconClass }} text-muted-foreground/30"></i>
        @endfor
    </div>
    @if ($showCount)
        <span class="text-sm font-medium text-muted-foreground">
            {{ number_format($rating, 1) }}{{ $count !== null ? " ($count)" : '' }}
        </span>
    @endif
</div>