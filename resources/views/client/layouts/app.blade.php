<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title')</title> 
<meta name="description" content="@yield('description')">     
<meta name="csrf-token" content="{{ csrf_token() }}" />
@if (request()->is('/'))
<link rel="canonical" href="https://www.quickdials.com/" />
@elseif (View::hasSection('canonical'))
@yield('canonical')
@else
<link rel="canonical" href="{{ url()->current() }}" />
@endif
@if(View::hasSection('meta_robots'))
@yield('meta_robots')
@else
<meta name="robots" content="index, follow">
@endif
<meta name="author" content="QuickDials">
<meta property="og:title" content="@yield('title', 'QuickDials')" />
<meta property="og:description" content="@yield('description')" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="website" />
<meta property="og:image" content="@yield('og_image', asset('client/images/quickdials-og.png'))" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="@yield('title')" />
<meta name="twitter:description" content="@yield('description')" />
<meta name="twitter:image" content="@yield('og_image', asset('client/images/quickdials-og.png'))" />
<meta name="geo.region" content="@yield('geo_region', 'IN')" />
<meta name="geo.placename" content="@yield('geo_city', 'India')" />
<meta name="geo.position" content="@yield('geo_position', '')" />
<meta name="google-site-verification" content="O8A-LG3YpW7vOcPtVP9OuNrEcLfLf1kW2tTVpFpHNxM" />
<meta name="msvalidate.01" content="456AED0115D50D42C4F3A79DAB89D41D" />
<link rel="icon" href="{{ asset('client/images/favicon.png') }}" type="image/png" />
<link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KF6W10RN9L"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-KF6W10RN9L');
</script>
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
@php     
    $serviceName = !empty($metaTitle)
        ? $metaTitle
        : "";

    $serviceDescription = $metaDescription? $metaDescription: 'India’s leading local business search and service directory. Find trusted businesses, services, it training, professionals, and service providers near you with QuickDials..';
    $cityName =$city ?: 'bangalore';
    if (!empty($childCat) && !empty($childSlug)) {
        $items[] = ['name' => ucfirst($childCat), 'url' => route('child.show', $childSlug)];
    }
    $items =[];
    if(request()->segment(1) ===$city){
    $items[] = ['name' => $keyword .' in '. $city, 'url' => url()->current()];
    }else 
    if (!empty($keyword)) {
        $items[] = ['name' => $keyword, 'url' => url()->current()];
    } 

    $breadcrumbs = array_merge(
        [['name' => 'Home', 'url' => route('home')]],
        $items
    );
@endphp 
@php   
    $schemas = [];  
    if (request()->is('/')){
    $schemas[] = [
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => 'QuickDials Internet Pvt Ltd',
        'url'      => route('home'),
        'logo'     => asset('client/images/small-logo.jpg'),
        'sameAs'   => [
            'https://www.facebook.com/quickdialsofficial/',
            'https://x.com/Quickdials',
            'https://www.linkedin.com/company/quickdialsoffical/',
            'https://www.pinterest.com/quickdialsoffical/',
            'https://www.instagram.com/quickdialsoffical/',
            'https://www.youtube.com/@quickdialsofficial',
        ],
    ];
}

if (request()->is('/')){
 $schemas[] = [
    '@context'    => 'https://schema.org',
    '@type'       => 'LocalBusiness',
    'name'        => 'Quickdials Pvt Ltd.',
    'image'       => asset('client/images/small-logo.jpg'),
    '@id'         => 'https://www.quickdials.com/#localbusiness',
    'url'         => route('home'),
    'telephone'   => '91-7559435943',
    'priceRange'  => '₹1000 - ₹1,00,000',
    'description' => 'QuickDials, local search engine India, local business directory India, online business directory, business listing website, top businesses near me, IT training institutes near me, coaching centres near me, hotels near me, salons near me, healthcare services, real estate services, travel agencies, schools and colleges near me, certified institutes, education consultants, local business listings, business reviews and ratings, trusted local services, find businesses near me.',

    'address' => [
        '@type'          => 'PostalAddress',
        'streetAddress'  => 'UNIT 101 OXFORD TOWERS, 139/88 HAL OLD AIRPORT RD, H.A.L II Stage, Bangalore North, Bangalore- 560008, Karnataka',
        'addressLocality'=> 'Bangalore',
        'postalCode'     => '560008',
        'addressCountry' => 'IN',
    ],

    'geo' => [
        '@type'     => 'GeoCoordinates',
        'latitude'  => 12.9658,
        'longitude' => 77.6421,
    ],

    'openingHoursSpecification' => [
        '@type'      => 'OpeningHoursSpecification',
        'dayOfWeek'  => [
            'Monday', 'Tuesday', 'Wednesday',
            'Thursday', 'Friday', 'Saturday', 'Sunday',
        ],
        'opens'  => '00:00',
        'closes' => '23:59',
    ],
 

    'serviceArea' => [
        '@type' => 'Country',
        'name'  => 'India',
    ],

    'areaServed' => [
        ['@type' => 'City', 'name' => 'Noida'],
        ['@type' => 'City', 'name' => 'Delhi'],
        ['@type' => 'City', 'name' => 'Hyderabad'],
        ['@type' => 'City', 'name' => 'Chennai'],
        ['@type' => 'City', 'name' => 'Kolkata'],
        ['@type' => 'City', 'name' => 'Ahmedabad'],
        ['@type' => 'City', 'name' => 'Jaipur'],
        ['@type' => 'City', 'name' => 'Gurgaon'],
        ['@type' => 'City', 'name' => 'Lucknow'],
        ['@type' => 'City', 'name' => 'Chandigarh'],
        ['@type' => 'City', 'name' => 'Indore'],
        ['@type' => 'City', 'name' => 'Pune'],
        ['@type' => 'City', 'name' => 'Mumbai'],
        ['@type' => 'City', 'name' => 'Bangalore'],
      
    ],
];
 }


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
                'url'   => route('home'),
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
</head>
<body class="min-h-screen bg-white text-gray-900 antialiased">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KZF3WGSW"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@include('client.layouts.navbar')
<main>
@yield('content')
</main>
@include('client.layouts.footer')
<script>
var searchCity       = '';
// var heroSelectedCity = '';
// var stickySelectedCity = '';
var cityDetected     = false;   

// ── Global state (must be declared, was previously implicit/undefined) ──
var cityDetected = false;
var searchCity = '';
 
 

document.addEventListener('DOMContentLoaded', function () {
    // No geolocation permission prompt on page load.
    // Go straight to IP-based detection, which requires no browser permission.
    detectCityFromIP();
});

// ── Call this ONLY from an explicit user action ──────────────────────
// e.g. <button onclick="requestPreciseLocation()">📍 Use my exact location</button>
function requestPreciseLocation() {
    if (!navigator.geolocation) {
        return;
    }
    navigator.geolocation.getCurrentPosition(
        gpsSuccess,
        gpsError,
        {
            timeout: 10000,
            maximumAge: 60000,
            enableHighAccuracy: false,
        }
    );
}

async function gpsSuccess(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;

    try {
        var response = await fetch(
            'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lon,
            {
                headers: {
                    'Accept-Language': 'en',
                },
            }
        );

        if (!response.ok) throw new Error('Nominatim request failed');

        var data = await response.json();
        var city = data.address.city ;
              console.log('data',data);
 
        if (city) {
            applyCity(city);
        } else {
            detectCityFromIP();
        }
    } catch (error) {
        detectCityFromIP();
    }
}

function gpsError(error) {
    detectCityFromIP();
}

// ── IP-based detection (no permission prompt required) ───────────────
function detectCityFromIP() {
    if (cityDetected) return;

    fetch('https://ipapi.co/json/')
        .then(function (res) {
            if (!res.ok) throw new Error('ipapi.co response error');
            return res.json();
        })
        .then(function (data) {
            console.log('detectCityFromIP',city);
            if (data.city) {
                applyCity(data.city);
            } else {
                applyDefaultCity();
            }
        })
        .catch(function () {
            applyDefaultCity();
        });
}

// ── Safe default if all detection fails — no third-party JSONP script ──
function applyDefaultCity() {
    if (cityDetected) return;
    applyCity('bangalore'); // confirm/replace with your actual site default
}

function applyCity(rawCity) {
    if (!rawCity || cityDetected) return;

    cityDetected = true;

    var formatted = rawCity
        .toLowerCase()
        .replace(/-/g, ' ')
        .trim()
        .split(' ')
        .filter(Boolean)
        .map(function (word) {
            return word.charAt(0).toUpperCase() + word.slice(1);
        })
        .join(' ');

    var cityLower = formatted.toLowerCase();

    searchCity = formatted;
    heroSelectedCity = cityLower;
    stickySelectedCity = formatted;

    ['hero-city-label', 'sticky-city-label', 'mobile-city-label'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.textContent = formatted;
        }
    });

    var cityIdInputs = document.querySelectorAll('input[name="city_id"]');
    if (cityIdInputs.length > 0) {
        cityIdInputs.forEach(function (input) {
            input.value = cityLower;
        });
    } else {
        var autoInput = document.createElement('input');
        autoInput.type = 'hidden';
        autoInput.name = 'city_id';
        autoInput.id = 'city_id_auto';
        autoInput.value = cityLower;
        document.body.appendChild(autoInput);
    }

    var cityIdById = document.getElementById('city_id');
    if (cityIdById) {
        cityIdById.value = cityLower;
    }

    if (
        typeof $ !== 'undefined' &&
        typeof $citySelect !== 'undefined' &&
        $citySelect &&
        $citySelect.length
    ) {
        var option = new Option(formatted, cityLower, true, true);
        $citySelect.append(option).trigger('change');
    }

    var plainSelect = document.getElementById('city-select');
    if (plainSelect) {
        var found = false;
        for (var i = 0; i < plainSelect.options.length; i++) {
            if (plainSelect.options[i].value.toLowerCase() === cityLower) {
                plainSelect.selectedIndex = i;
                found = true;
                break;
            }
        }
        if (!found) {
            var newOpt = document.createElement('option');
            newOpt.value = cityLower;
            newOpt.text = formatted;
            newOpt.selected = true;
            plainSelect.appendChild(newOpt);
        }
    }

    var hiddenInput = document.getElementById('selected-city');
    if (hiddenInput) {
        hiddenInput.value = cityLower;
    }
}

</script>
 

 
</body>
</html>
