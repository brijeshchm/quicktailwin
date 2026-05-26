@props(['clinic', 'index' => 0])
 
<div x-data="{ shown: false }"
     x-intersect.once="setTimeout(() => shown = true, {{ $index * 100 }})"
     x-bind:class="shown ? 'opacity-100 translate-y-0' : 'opacity-1 translate-y-5'"
     class="group h-full transition-all duration-500 ease-out">

    <a href="" class="block h-full">
        <article class="h-full overflow-hidden rounded-xl border border-border/50 bg-white transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="relative aspect-video overflow-hidden bg-muted">
                @if ($clinic['image'])
                    <img src="{{ $clinic['image'] }}" alt="{{ $clinic['name'] }}"
                         loading="lazy"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                        <span class="font-serif italic text-2xl text-primary opacity-50">
                            {{ substr($clinic['name'], 0, 1) }}
                        </span>
                    </div>
                @endif

                @if ($clinic['specialty'])
                    <span class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-medium px-2.5 py-1 rounded-full shadow-sm">
                        {{ $clinic['specialty'] }}
                    </span>
                @endif
            </div>

            <div class="p-6">
                <h3 class="text-xl font-bold font-serif mb-1 group-hover:text-primary transition-colors line-clamp-1">
                    {{ $clinic['name'] }}
                </h3>
              

                <div class="flex items-center gap-1.5 text-sm text-muted-foreground mb-3">
                    <i data-lucide="map-pin" class="w-4 h-4 shrink-0"></i>
                    <span class="line-clamp-1">{{ $clinic['city'] }}</span>
                </div>

                <x-star-rating :rating="$clinic['rating']" :count="$clinic['reviews']" />

                <div class="pt-4 mt-4 border-t flex items-center justify-between text-sm font-medium text-primary">
                    <span>View Profile</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                </div>
            </div>
        </article>
    </a>
</div>