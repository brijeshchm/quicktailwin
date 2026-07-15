<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="robots" content="index, nofollow">
<link rel="canonical" href="{{ url()->current() }}" />
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('client/images/favicon.png') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('client/images/favicon.png') }}">
<title>No results found @if(request('q')) for "{{ request('q') }}" @endif — QuickDials</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-gray-900 antialiased" x-data="appData()">

@include('client.layouts.navbar')

<main>
<section class="min-h-[80vh] flex items-center justify-center bg-gray-50 px-4 py-16">
    <div class="max-w-xl w-full mx-auto text-center">

        {{-- Icon badge --}}
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-50">
            <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.34-4.34M18 10.5a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
            </svg>
        </div>

        {{-- Heading --}}
        <h1 class="mt-6 text-2xl md:text-3xl font-bold text-gray-900">
            No results found
            @if(request('q'))
                for &ldquo;{{ request('q') }}&rdquo;
            @endif
        </h1>

        <p class="mt-3 text-base text-gray-500">
            We couldn't find a match. Check the spelling, try a broader term, or browse popular categories below.
        </p>

  
  <div class="flex flex-wrap items-center gap-1.5 mt-2 justify-center" id="trending-tags">
                    <span class="text-gray-400 text-[11px] font-medium">Trending:</span>
                   
                    
                    @if(!empty($trending))
                        @foreach($trending as $tag)
                            <button
                                onclick="redirectSearch('{{ $tag['url'] ?? $tag['title'] }}', heroSelectedCity)"
                                aria-label="Search {{ $tag['url'] }}"
                                class="text-[11px] bg-gray-100 hover:bg-blue-50 border border-gray-200 hover:border-blue-200 text-gray-500 hover:text-blue-700 px-2.5 py-0.5 rounded-full transition-colors"
                            >{{ $tag['title'] }}</button>
                        @endforeach
                    @else
                        @foreach(['AC Repair Service','Wedding Planner','Home Loan','Dentist','Pizza Near Me'] as $tag)
                            <button
                                onclick="redirectSearch('{{ Str::slug($tag) }}', heroSelectedCity)"
                                aria-label="Search {{ Str::slug($tag) }}"
                                class="text-[11px] bg-gray-100 hover:bg-blue-50 border border-gray-200 hover:border-blue-200 text-gray-500 hover:text-blue-700 px-2.5 py-0.5 rounded-full transition-colors"
                            >{{ $tag }}</button>
                        @endforeach
                    @endif
                </div>

        {{-- Secondary actions --}}
        <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center border-t border-gray-200 pt-8">
            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900">
                &larr; Back to Home
            </a>
            <a href="{{ url('/contact-us') }}"
               class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-blue-600 hover:text-blue-700">
                Contact Support
            </a>
        </div>

    </div>
</section>
</main>
<script>
    let heroSelectedCity = 'bangalore';
    function redirectSearch(keyword, city) { 
    if (!keyword || !city) return;
    const c = city.toLowerCase().replace(/\s+/g, '-');
    const k = keyword.toLowerCase().replace(/\s+/g, '-');
    window.location.href = `/${c}/${k}`;
}
</script>
@include('client.layouts.footer')

</body>
</html>