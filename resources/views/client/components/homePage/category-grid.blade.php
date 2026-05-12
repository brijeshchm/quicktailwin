
@if(!empty($homeData['data']['homePage']))
<section class="py-10 px-4 md:px-8">
    <h2 class="text-xl font-black text-gray-900 mb-6">Browse Categories</h2>
    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">

        @foreach($homeData['data']['homePage'] as $cat)

        @php
        $catUrl = match($cat['type'] ?? '') {
        'keyword'    => route('showCity',        $cat['url']),
        'child'      => route('child.show',      $cat['url']),
        'categories' => route('categories.show', $cat['url'])
      
        };
        @endphp

 
        <a href="{{ $catUrl }}"
           class="flex flex-col items-center gap-2 p-3 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all group text-center block">
            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                <img src="{{ $cat['img'] ?? '' }}" alt="{{ $cat['title'] ?? '' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            </div>
            <span class="text-xs font-semibold text-gray-700 group-hover:text-blue-700 leading-tight">{{ $cat['title'] ?? '' }}</span>
        </a>
        @endforeach
    </div>
</section>
@endif