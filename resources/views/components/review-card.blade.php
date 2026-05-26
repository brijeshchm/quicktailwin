@props(['review', 'doctorName' => null])

<article {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-border/50 shadow-sm p-6']) }}>
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-primary/5 border border-border flex items-center justify-center text-primary font-medium">
                {{ $review->initials }}
            </div>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-semibold">{{ $review->patient_name }}</span>
                    @if ($review->is_verified)
                        <span class="inline-flex items-center gap-1 h-5 px-1.5 text-xs bg-green-50 text-green-700 border border-green-200 rounded">
                            <i data-lucide="check-circle-2" class="w-3 h-3"></i> Verified Patient
                        </span>
                    @endif
                </div>
                <div class="text-sm text-muted-foreground">
                    {{ $review->review_date->format('F j, Y') }}
                    @if ($doctorName)<span class="text-xs">· {{ $doctorName }}</span>@endif
                </div>
            </div>
        </div>
        <x-star-rating :rating="$review->rating" :show-count="false" />
    </div>

    @if ($review->title)
        <h4 class="font-semibold mb-2">{{ $review->title }}</h4>
    @endif

    <p class="text-muted-foreground text-sm leading-relaxed mb-4">"{{ $review->comment }}"</p>

    @if ($review->helpful_count > 0)
        <div class="flex items-center gap-1.5 text-xs text-muted-foreground font-medium mb-3">
            <i data-lucide="thumbs-up" class="w-3.5 h-3.5"></i>
            {{ $review->helpful_count }} people found this helpful
        </div>
    @endif

    @if ($review->clinic_reply)
        <div class="mt-3 pt-3 border-t border-border/40">
            <div class="bg-primary/5 border border-primary/15 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="w-5 h-5 rounded-full bg-primary flex items-center justify-center">
                        <i data-lucide="building-2" class="w-2.5 h-2.5 text-white"></i>
                    </span>
                    <span class="text-xs font-bold text-primary">Clinic Response</span>
                    @if ($review->clinic_reply_date)
                        <span class="text-xs text-muted-foreground">
                            · {{ $review->clinic_reply_date->format('M j, Y') }}
                        </span>
                    @endif
                </div>
                <p class="text-sm text-foreground/80 leading-relaxed">{{ $review->clinic_reply }}</p>
            </div>
        </div>
    @endif
</article>