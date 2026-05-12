@props(['business', 'index' => 0, 'view' => 'list'])

@php
    $colorPalette = [
        'from-violet-500 to-indigo-600',
        'from-emerald-500 to-teal-600',
        'from-orange-500 to-amber-600',
        'from-blue-500 to-cyan-600',
        'from-pink-500 to-rose-600',
        'from-slate-500 to-gray-700',
        'from-sky-500 to-blue-600',
        'from-amber-500 to-yellow-600',
        'from-fuchsia-500 to-purple-600',
        'from-lime-500 to-green-600',
    ];
    $color = $colorPalette[$business['id'] % count($colorPalette)];

    $name = $business['name'] ?? 'Business Name';
    $words = explode(' ', $name);
    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

    $rating = $business['rating'] ?? 4.0;
    $reviewCount = $business['reviewCount'] ?? 0;
    $isOpen = $business['isOpen'] ?? true;
    $verified = $business['verified'] ?? false;
    $trending = $business['trending'] ?? false;
    $topSearch = $business['topSearch'] ?? false;
    $featured = $business['featured'] ?? false;
    $address = $business['address'] ?? '';
    $city = $business['city'] ?? '';
    $established = $business['established'] ?? '';
    $description = $business['description'] ?? '';
    $tags = $business['tags'] ?? [];
    $category = is_array($business['category'] ?? '') ? $business['category'] : [$business['category'] ?? ''];
    $phone = $business['phone'] ?? '';
    $slug = $business['business_slug'] ?? '';
    $openUntil = $business['openUntil'] ?? '8:00 PM';

    $filledStars = round($rating);
@endphp

@if($view === 'list')
{{-- LIST VIEW --}}
<div class="group relative bg-white border-b border-gray-100 last:border-b-0 transition-all duration-300 hover:bg-indigo-50/30"
     x-data="{ liked: false }">

    {{-- Left accent bar --}}
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-indigo-500 to-violet-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

    @if($featured)
    <div class="absolute top-0 right-0 bg-gradient-to-l from-amber-400 to-orange-400 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl tracking-wider uppercase z-10">Featured</div>
    @endif

    <div class="relative z-10 flex gap-3 sm:gap-5 items-start p-3 sm:p-5 pl-4 sm:pl-6">
        {{-- Avatar --}}
        <div class="relative flex-shrink-0">
            <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br {{ $color }} flex items-center justify-center shadow-lg">
                <span class="text-white text-lg sm:text-2xl font-bold">{{ $initials }}</span>
            </div>
            @if($isOpen)
            <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-[8px] sm:text-[9px] font-bold bg-emerald-500 text-white px-1.5 sm:px-2 py-0.5 rounded-full whitespace-nowrap shadow-md">OPEN</span>
            @endif
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-1">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <h3 class="font-bold text-gray-900 text-[13px] sm:text-[15px] leading-tight group-hover:text-indigo-600 transition-colors">
                            <a href="{{ route('business.details', $business['business_slug']) }}">{{ $name }}</a>
                        </h3>
                        @if($verified)
                        <span class="flex items-center gap-0.5 text-[9px] sm:text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full border border-emerald-100">
                            <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Verified
                        </span>
                        @endif
                        @if($trending)
                        <span class="flex items-center gap-0.5 text-[9px] sm:text-[10px] font-semibold text-orange-600 bg-orange-50 px-1.5 py-0.5 rounded-full border border-orange-100">
                            <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            Trending
                        </span>
                        @endif
                        @if($topSearch)
                        <span class="hidden sm:flex items-center gap-0.5 text-[10px] font-semibold text-violet-600 bg-violet-50 px-2 py-0.5 rounded-full border border-violet-100">
                            ✦ Top Search
                        </span>
                        @endif
                    </div>
                    @if($established)
                    <p class="text-[10px] sm:text-xs text-gray-400 mt-0.5">Est. {{ $established }}</p>
                    @endif
                </div>

                {{-- Like button --}}
                <button @click="liked = !liked" class="flex-shrink-0 p-1 sm:p-1.5 rounded-xl hover:bg-red-50 transition-colors">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-all" :class="liked ? 'fill-red-500 text-red-500' : 'text-gray-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </div>

            {{-- Rating --}}
            <div class="flex items-center gap-1.5 sm:gap-2 mt-1.5 flex-wrap">
                <span class="bg-emerald-500 text-white text-[10px] sm:text-xs font-bold px-1.5 py-0.5 rounded-md">{{ number_format($rating, 1) }}</span>
                <div class="flex items-center gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-3.5 h-3.5 {{ $i <= $filledStars ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <span class="text-[10px] sm:text-xs text-gray-400">({{ $reviewCount }})</span>
                @if($openUntil)
                <span class="hidden sm:inline text-xs text-gray-400">🕐 Open Hrs {{ $openUntil }}</span>
                @endif
            </div>

            {{-- Address --}}
            @if($address || $city)
            <p class="text-[10px] sm:text-xs text-gray-500 mt-1.5 flex items-start gap-1">
                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 flex-shrink-0 text-indigo-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="line-clamp-1">{{ collect([$address, $city])->filter()->implode(', ') }}</span>
            </p>
            @endif

            {{-- Description --}}
            @if($description)
            <p class="hidden sm:block text-xs text-gray-500 mt-1 line-clamp-1">{!! $description !!}</p>
            @endif

            {{-- Tags/Category --}}
            @if(count($category) > 0)
            <div class="flex items-center gap-1.5 mt-2 flex-wrap">
                @foreach(array_slice($category, 0, 5) as $tag)
                <span class="text-[9px] sm:text-[11px] text-indigo-600 bg-indigo-50 border border-indigo-100 px-1.5 sm:px-2 py-0.5 rounded-full font-medium">{{ $tag }}</span>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="relative z-10 px-3 sm:px-5 pb-3 sm:pb-4 pl-4 sm:pl-6">
        <div class="flex items-center gap-1.5 sm:gap-2 w-full">
            <a href="tel:{{ $phone }}" class="flex-1 flex items-center justify-center gap-1 sm:gap-1.5 py-1.5 sm:py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] sm:text-xs font-semibold shadow-sm shadow-indigo-200 transition-colors">
                📞 <span>Call</span>
            </a>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $phone) }}" target="_blank" rel="noopener noreferrer"
               class="flex-1 flex items-center justify-center gap-1 sm:gap-1.5 py-1.5 sm:py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] sm:text-xs font-semibold shadow-sm shadow-emerald-200 transition-colors">
                💬 <span>WhatsApp</span>
            </a>
            <button onclick="document.getElementById('enquiry-modal').classList.add('open')"
               class="flex-1 relative flex items-center justify-center gap-1 sm:gap-1.5 py-1.5 sm:py-2 rounded-xl bg-violet-600 hover:bg-violet-700 text-white text-[10px] sm:text-xs font-semibold shadow-sm shadow-violet-200 transition-colors">
                ✉ <span>Enquiry</span>
            </button>
            <a href="{{ route('business.details', $business['business_slug']) }}" target="_blank" rel="noopener noreferrer"
               class="flex-1 flex items-center justify-center gap-1 sm:gap-1.5 py-1.5 sm:py-2 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-[10px] sm:text-xs font-semibold shadow-sm shadow-sky-200 transition-colors">
                🗺 <span>View</span>
            </a>
        </div>
    </div>
</div>

@else
{{-- GRID VIEW --}}
<div class="group bg-white rounded-2xl border border-gray-100 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300 relative overflow-hidden flex flex-col"
     x-data="{ liked: false }">

    <div class="absolute top-0 inset-x-0 h-0.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

    @if($featured)
    <div class="absolute top-0 right-0 bg-gradient-to-l from-amber-400 to-orange-400 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl tracking-wider uppercase z-10">Featured</div>
    @endif

    <div class="p-5 flex flex-col flex-1">
        <div class="flex items-start justify-between mb-6">
            <div class="relative w-20 h-20 rounded-2xl bg-gradient-to-br {{ $color }} flex items-center justify-center shadow-md">
                <span class="text-white text-xl font-bold">{{ $initials }}</span>
                @if($isOpen)
                <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-[9px] font-bold bg-emerald-500 text-white px-2 py-0.5 rounded-full whitespace-nowrap shadow">OPEN</span>
                @endif
            </div>
            <button @click="liked = !liked" class="p-1.5 rounded-xl hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4 transition-all" :class="liked ? 'fill-red-500 text-red-500' : 'text-gray-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        </div>

        <h3 class="font-bold text-gray-900 text-sm group-hover:text-indigo-600 transition-colors mb-0.5">
            <a href="{{ route('business.details', $business['business_slug']) }}">{{ $name }}</a>
        </h3>
        <p class="text-[11px] text-gray-400 mb-3">{{ implode(', ', array_slice($category, 0, 2)) }}</p>

        <div class="flex items-center gap-2 mb-3">
            <span class="bg-emerald-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-md">{{ number_format($rating, 1) }}</span>
            <div class="flex items-center gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-3.5 h-3.5 {{ $i <= $filledStars ? 'fill-amber-400 text-amber-400' : 'fill-gray-200 text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                @endfor
            </div>
            <span class="text-xs text-gray-400">({{ $reviewCount }})</span>
        </div>

        <div class="flex flex-wrap gap-1 mb-3">
            @if($verified)
            <span class="flex items-center gap-0.5 text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">✓ Verified</span>
            @endif
            @if($trending)
            <span class="flex items-center gap-0.5 text-[10px] font-semibold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">↗ Trending</span>
            @endif
        </div>

        @if($address)
        <p class="text-[11px] text-gray-400 flex items-start gap-1 mb-1.5">
            📍 {{ $address }}
        </p>
        @endif

        @if($description)
        <p class="text-[11px] text-gray-500 line-clamp-2 flex-1 mb-4">{!! strip_tags($description) !!}</p>
        @endif

        <div class="mt-auto pt-1 flex items-center gap-1.5">
            <a href="tel:{{ $phone }}" class="flex-1 flex items-center justify-center gap-1 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-semibold transition-colors">📞 Call</a>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $phone) }}" target="_blank" class="flex-1 flex items-center justify-center gap-1 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-semibold transition-colors">💬 WhatsApp</a>
            <button  onclick="document.getElementById('enquiry-modal').classList.add('open')" class="flex-1 flex items-center justify-center gap-1 py-1.5 rounded-xl bg-violet-600 hover:bg-violet-700 text-white text-[10px] font-semibold transition-colors">✉ Enquiry</button>
        </div>
    </div>
</div>

  
@endif

 

