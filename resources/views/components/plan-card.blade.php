@props(['name', 'price', 'desc', 'features', 'highlight' => false])

<div class="reveal rounded-2xl p-6 border-2 relative transition-transform duration-200 hover:-translate-y-1.5
    {{ $highlight ? 'border-brand-blue bg-brand-blue text-white shadow-xl' : 'border-gray-200 bg-white text-gray-800 shadow-md' }}">

    @if ($highlight)
        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brand-green text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wide">
            Most Popular
        </div>
    @endif

    <div class="text-xs font-bold uppercase tracking-widest mb-1 {{ $highlight ? 'text-blue-200' : 'text-brand-blue' }}">
        {{ $name }}
    </div>
    <div class="text-3xl font-bold mt-2">{{ $price }}</div>
    <p class="text-xs mt-1 mb-4 {{ $highlight ? 'text-blue-100' : 'text-gray-500' }}">{{ $desc }}</p>

    <ul class="space-y-2 mb-6">
        @foreach ($features as $feature)
            <li class="flex items-start gap-2 text-xs">
                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 flex-shrink-0 mt-0.5 {{ $highlight ? 'text-green-300' : 'text-brand-green' }}"></i>
                <span>{{ $feature }}</span>
            </li>
        @endforeach
    </ul>

    <button type="button"
            onclick="document.getElementById('hero').scrollIntoView({behavior:'smooth'})"
            class="w-full py-2.5 rounded-lg text-sm font-semibold transition-all
                {{ $highlight ? 'bg-white text-brand-blue hover:bg-blue-50' : 'bg-brand-blue text-white hover:bg-brand-blue-dark' }}">
        Get Started
    </button>
</div>
