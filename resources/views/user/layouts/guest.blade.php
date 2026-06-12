<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title')</title>
<meta name="keywords" content="@yield('keyword')">
<meta name="description" content="@yield('description')">     
<meta name="csrf-token" content="{{ csrf_token() }}" />  
@if (request()->is('/'))
    <link rel="canonical" href="https://www.quickdials.com/" />
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

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    @include('client.layouts.navbar')

     

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>lucide.createIcons();</script>

 
<script>
    // Re-render icons after dynamic content
    document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
</script>
</body>
</html>