<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('keyword')">
    <meta name="description" content="@yield('description')">     
    <meta name="csrf-token" content="{{ csrf_token() }}" />
   {{-- Canonical URL --}}
@if (request()->is('/'))
    <link rel="canonical" href="{{ url('/') }}" />
@elseif (View::hasSection('canonical'))
    @yield('canonical')
@else
    <link rel="canonical" href="{{ url()->current() }}" />
@endif
{{-- Meta Robots --}}
@if (View::hasSection('meta_robots'))
    @yield('meta_robots')
@else
    <meta name="robots" content="index, follow">
@endif
<meta name="author" content="Quick Dials">
<meta property="og:title" content="@yield('title', 'Quick Dials')" />
<meta property="og:description" content="@yield('description')" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="website" />
<meta property="og:image" content="@yield('og_image', asset('client/images/quickdials-og.png'))" />
<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="@yield('title')" />
<meta name="twitter:description" content="@yield('description')" />
<meta name="twitter:image" content="@yield('og_image', asset('client/images/quickdials-og.png'))" />
<!-- GEO Dynamic -->
<meta name="geo.region" content="@yield('geo_region', 'IN')" />
<meta name="geo.placename" content="@yield('geo_city', 'India')" />
<meta name="geo.position" content="@yield('geo_position', '')" />
<!-- Verification -->
<meta name="google-site-verification" content="O8A-LG3YpW7vOcPtVP9OuNrEcLfLf1kW2tTVpFpHNxM" />
<meta name="msvalidate.01" content="456AED0115D50D42C4F3A79DAB89D41D" />
<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('client/images/favicon.png') }}" type="image/png" />
       <!------Google Analytic Script End----->
      
<script>
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i+"?ref=bwt";
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "wgjukc5z45");
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KZF3WGSW');</script>
<!-- End Google Tag Manager -->


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KF6W10RN9L"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-KF6W10RN9L');
</script>

   @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        .pulse-ring::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: #f97316;
            animation: pulse-ring 1.5s ease-out infinite;
        }

        /* Rotating word animation */
        @keyframes wordFadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .word-animate { animation: wordFadeIn 0.3s ease forwards; }

        /* Dot pattern background */
        .dot-bg {
            background-image: radial-gradient(circle, rgba(59,130,246,0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Card slider */
        .slider-track { scroll-behavior: smooth; overflow: hidden; }

        /* Dropdown fade */
        .dropdown-enter {
            animation: dropIn 0.15s ease forwards;
        }
        @keyframes dropIn {
            from { opacity: 0; transform: translateY(6px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .hidden-init { display: none; }
    </style>

    
</head>
<body class="min-h-screen bg-white text-gray-900 antialiased">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KZF3WGSW"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

@php
     
    $serviceName = !empty($metaTitle)
        ? $metaTitle
        : "";

    $serviceDescription = 'India leading local business search & service directory | QuickDials.';
    $cityName =$city ?? '';
    if (!empty($childCat) && !empty($childSlug)) {
        $items[] = ['name' => ucfirst($childCat), 'url' => route('child.show', $childSlug)];
    }
    $items =[];
    // if(request()->segment(1)){
    // $items[] = ['name' => request()->segment(1), 'url' => url()->current()];
    // }
    if (!empty($keyword)) {
        $items[] = ['name' => $keyword, 'url' => url()->current()];
    } 

    $breadcrumbs = array_merge(
        [['name' => 'Home', 'url' => url('/')]],
        $items
    );


@endphp

 
@php
   
    $schemas = [];

  
    $schemas[] = [
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => 'QuickDials',
        'url'      => url('/'),
        'logo'     => asset('client/images/small-logo.jpg'),
        'sameAs'   => [
            'https://www.facebook.com/quickdialsofficial/',
            'https://x.com/Quickdials',
            'https://www.linkedin.com/company/quickdialsoffical/',
            'https://www.pinterest.com/quickdialsoffical/',
            'https://www.instagram.com/quickdialsoffical/',
            'https://www.youtube.com/@quickdialsofficial/',
        ],
    ];

    // ---- 2. SERVICE (only if service data exists) ----
    if (!empty($serviceName)) {
        $schemas[] = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => $serviceName ?? '',
            'description' => $serviceDescription ?? '',
            'url'         => url()->current(),
            'areaServed'  => $cityName ?? null,
            'provider'    => [
                '@type' => 'Organization',
                'name'  => 'QuickDials',
                'url'   => url('/'),
            ],
        ];
    }

    // ---- 3. BREADCRUMBS ----
    if (!empty($breadcrumbs)) {
        $breadcrumbList = [];
        foreach ($breadcrumbs as $i => $item) {
            $breadcrumbList[] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $item['name'],
                'item'     => $item['url'],
            ];
        }

        $schemas[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $breadcrumbList,
        ];
    }

    

    // ---- 5. FAQ ----
    if (!empty($faqs)) {
        $validFaqs = collect($faqs)
            ->filter(fn($f) => !empty($f['q']) && !empty($f['a']))
            ->map(fn($f) => [
                '@type'          => 'Question',
                'name'           => $f['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => strip_tags($f['a']),
                ],
            ])
            ->values()
            ->all();

        if (!empty($validFaqs)) {
            $schemas[] = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => $validFaqs,
            ];
        }
    }
@endphp

@if(!empty($schemas))
<script type="application/ld+json">
{!! json_encode(
    count($schemas) === 1 ? $schemas[0] : $schemas,
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
) !!}
</script>
@endif

  
    @include('client.layouts.navbar')



 
    <main>
      
        @yield('content')

    </main>

    @include('client.layouts.footer')
 
<script>
    

// ─── Auto Detect City by Location ─────────────────────────────────────────
function applyDetectedCity(cityName) {
    if (!cityName) return;
    const formatted = cityName
        .split('-')
        .map(w => w.charAt(0).toUpperCase() + w.slice(1))
        .join(' ');
    const lower = formatted.toLowerCase();

    heroSelectedCity = lower;

    // Update all city labels
    ['hero-city-label', 'sticky-city-label', 'mobile-city-label'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = formatted;
    });

    // Re-render city list with new selection highlighted
    renderHeroCityList(CITIES);
}

function detectCityFromIP() {
    fetch('https://ipapi.co/json/')
        .then(res => res.json())
        .then(data => {
            if (data.city) applyDetectedCity(data.city);
        })
        .catch(() => {
            // Keep default city (Bangalore) if all fails
        });
}

function detectCityFromCoords(lat, lng) {
  
    fetch(`https://ipapi.co/json/`)
        .then(res => res.json())
        .then(data => {
            if (data.city) applyDetectedCity(data.city);
        })
        .catch(() => detectCityFromIP());
}

// ─── Start detection ───────────────────────────────────────────────────────
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        position => detectCityFromCoords(position.coords.latitude, position.coords.longitude),
        error    => detectCityFromIP(),   // denied or error → fallback to IP
        { timeout: 5000 }
    );
} else {
    detectCityFromIP();
}
 
</script>
 
</body>
</html>
