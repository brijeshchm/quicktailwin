@props(['accreditation'])

<div x-data="{ open: false }" class="relative inline-block">
    <div @mouseenter="open = true" @mouseleave="open = false"
         class="inline-flex items-center gap-2 rounded-full border border-accent/30 bg-accent/5 px-3 py-1.5 text-sm hover:bg-accent/10 transition-colors cursor-help">
        <i data-lucide="award" class="w-4 h-4 text-accent"></i>
        <span class="font-medium">{{ $accreditation->name }}</span>
    </div>

    <div x-show="open" x-cloak x-transition
         class="absolute z-20 bottom-full mb-2 left-0 max-w-xs w-max bg-white border rounded-lg shadow-lg p-3 text-sm">
        <p class="font-semibold">{{ $accreditation->issuing_body }}</p>
        <p class="text-xs text-muted-foreground">
            Issued: {{ $accreditation->year }}
            @if ($accreditation->expiry_year) · Valid until: {{ $accreditation->expiry_year }} @endif
        </p>
    </div>
</div>