@props(['doctor', 'index' => 0, 'showClinicName' => false])

<div x-data="{ shown: false }"
     x-intersect.once="setTimeout(() => shown = true, {{ $index * 100 }})"
     x-bind:class="shown ? 'opacity-100 translate-y-0' : 'opacity-1 translate-y-5'"
     class="group h-full transition-all duration-500 ease-out">

    <article class="h-full overflow-hidden rounded-xl border border-border/50 bg-white transition-all duration-300 hover:shadow-md">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="relative shrink-0">
                    <div class="h-20 w-20 rounded-full border-2 border-white shadow-sm overflow-hidden bg-primary/5 flex items-center justify-center">
                        @if ($doctor['image'])
                            <img src="{{ $doctor['image'] }}" alt="{{ $doctor['name'] }}" loading="lazy"
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-primary font-medium text-lg">{{ $doctor->initials }}</span>
                        @endif
                    </div>
                    @if ($doctor['is_available_today'])
                        <span class="absolute bottom-1 right-1 h-3.5 w-3.5 rounded-full bg-green-500 border-2 border-white"
                              title="Available today"></span>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-lg font-serif truncate">
                        <a href="" class="hover:text-primary transition-colors">
                            {{ $doctor['name'] }}
                        </a>
                    </h3>
                    <p class="text-primary font-medium text-sm">{{ $doctor['title'] }}</p>
                    <p class="text-muted-foreground text-sm truncate mb-2">
                        {{ $doctor['specialty'] }}
                    </p>
                    <x-star-rating :rating="$doctor['rating']" :count="4" size="sm" />
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                    <i data-lucide="graduation-cap" class="w-4 h-4 shrink-0"></i>
                    <span class="truncate">Education</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                    <i data-lucide="languages" class="w-4 h-4 shrink-0"></i>
                    <span class="truncate">Language</span>
                </div>
            </div>
        </div>

        <div class="p-4 bg-muted/30 border-t flex items-center justify-between">
            <div class="text-sm">
                Consultation: <strong>$300</strong>
            </div>
            <a href=""
               class="inline-flex items-center gap-1.5 bg-primary hover:bg-primary/90 text-white text-sm font-medium px-4 py-2 rounded-full transition-colors">
                Book <i data-lucide="calendar" class="w-4 h-4"></i>
            </a>
        </div>
    </article>
</div>