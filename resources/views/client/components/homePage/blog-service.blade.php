{{-- ─────────────────────────────────────────
    BLOG SECTION
───────────────────────────────────────── --}}
@if(!empty($homeData['data']['blogList']))
<div class="py-10 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-8">
            <h5 class="text-2xl font-bold text-gray-900 mb-2">Blog</h5>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($homeData['data']['blogList'] as $blog)
            <div class="rounded-xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                <a href="{{ route('blog.details', $blog['url']) }}" target="_blank" rel="noopener noreferrer">
                    <div class="relative w-full h-[150px] overflow-hidden">
                        <img src="{{ $blog['img'] ?? '' }}" alt="{{ $blog['alt'] ?? $blog['title'] ?? '' }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" loading="lazy"/>
                    </div>
                </a>
                <div class="p-4 flex flex-col gap-2">
                    <h3 class="text-sm font-bold text-gray-900 leading-snug hover:text-violet-600 transition-colors">
                        <a href="{{ route('blog.details', $blog['url']) }}" target="_blank" rel="noopener noreferrer">{{ $blog['title'] ?? '' }}</a>
                    </h3>
                    <p class="text-xs text-gray-600 text-justify font-medium leading-relaxed">
                        {{ Str::limit($blog['excerpt'] ?? '', 120) }}
                        <a href="{{ route('blog.details', $blog['url']) }}" target="_blank" rel="noopener noreferrer"
                           class="text-violet-600 hover:underline ml-1">View More...</a>
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('blog.show') }}" target="_blank" rel="noopener noreferrer"
               class="inline-block px-6 py-2 rounded-full border border-violet-500 text-violet-600 text-sm font-semibold hover:bg-violet-600 hover:text-white transition-all duration-200">
                View All
            </a>
        </div>
    </div>
</div>
@endif