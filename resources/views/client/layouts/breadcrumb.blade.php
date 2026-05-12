
    <nav aria-label="Breadcrumb" class="py-3 px-4">
    <ol class="flex flex-wrap items-center gap-1.5 text-sm text-gray-600">
        @if(!empty($items))
        @foreach($items as $i => $item)
            <li class="flex items-center gap-1.5">
                @if($i === 0)
                    {{-- Home icon --}}
                    <a href="{{ $item['url'] }}"
                       class="flex items-center gap-1 text-gray-500 hover:text-blue-600 transition-colors"
                       title="Home">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="sr-only sm:not-sr-only">{{ $item['name'] }}</span>
                    </a>
                @elseif($i < count($items) - 1)
                    <a href="{{ $item['url'] }}"
                       class="hover:text-blue-600 transition-colors line-clamp-1">
                        {{ $item['name'] }}
                    </a>
                @else
                    <span class="text-gray-900 font-semibold line-clamp-1" aria-current="page">
                        {{ $item['name'] }}
                    </span>
                @endif

                @if($i < count($items) - 1)
                    <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                @endif
            </li>
        @endforeach
        @endif
    </ol>
</nav>