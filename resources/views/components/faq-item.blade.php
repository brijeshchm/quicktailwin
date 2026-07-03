@props(['q', 'a'])

<div x-data="faqItem" class="border-b border-gray-200 last:border-0">
    <button
        type="button"
        @click="open = !open"
        class="w-full flex justify-between items-center py-4 text-left text-sm font-medium text-gray-800 hover:text-brand-blue transition-colors"
    >
        <span>{{ $q }}</span>
        <i data-lucide="chevron-down" class="w-4 h-4 flex-shrink-0 text-gray-400 transition-transform" x-show="!open"></i>
        <i data-lucide="chevron-up" class="w-4 h-4 flex-shrink-0 text-brand-blue" x-show="open" x-cloak></i>
    </button>
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <p class="pb-4 text-sm text-gray-600 leading-relaxed">{{ $a }}</p>
    </div>
</div>
