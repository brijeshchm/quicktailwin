@props([
    'icon',
    'count',
    'label',
    'color' => 'text-gray-800',
])

<div class="animate-flipInY bg-white rounded-lg shadow-sm border border-gray-100 p-5 flex flex-col items-center text-center hover:shadow-md transition-shadow duration-200">
    <div class="text-blue-500 mb-2">
        <i data-lucide="{{ $icon }}" class="w-8 h-8"></i>
    </div>

    <div class="text-3xl font-bold {{ $color }}">
        {{ $count }}
    </div>

    <h3 class="mt-2 text-sm font-semibold text-gray-600">
        {{ $label }}
        <small class="block text-xs text-gray-400 mt-0.5">
            (in {{ now()->format('M Y') }})
        </small>
    </h3>
</div>