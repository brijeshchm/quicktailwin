@props(['icon', 'title', 'desc'])

<div class="reveal bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center transition-transform duration-200 hover:-translate-y-1">
    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <i data-lucide="{{ $icon }}" class="w-7 h-7 text-brand-blue"></i>
    </div>
    <h3 class="font-semibold text-gray-800 mb-2">{{ $title }}</h3>
    <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
</div>
