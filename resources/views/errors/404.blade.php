<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noindex, follow">
    <link rel="shortcut icon" href="{{asset('client/images/favicon.png')}}" type="image/png" />
    <title>@yield('title')</title>   
   @vite(['resources/css/app.css', 'resources/js/app.js'])    
</head>
<body class="min-h-screen bg-white text-gray-900 antialiased" x-data="appData()">


  
    @include('client.layouts.navbar')
 
    <main>
    
   
<section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 px-4">
    <div class="max-w-2xl mx-auto text-center">

        <!-- Big 404 -->
        <h1 class="text-8xl md:text-9xl font-extrabold text-blue-600 tracking-tight">
            404
        </h1>

        <!-- Heading -->
        <h2 class="mt-4 text-3xl md:text-4xl font-bold text-gray-900">
            Oops! Page Not Found
        </h2>

        <!-- Description -->
        <p class="mt-4 text-base md:text-lg text-gray-600">
            The page you're looking for doesn't exist or has been moved.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://www.quickdials.com"
               class="inline-block px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-200">
                Back to Home
            </a>
            <a href="https://www.quickdials.com/contact-us"
               class="inline-block px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg border border-blue-600 hover:bg-blue-50 transition-all duration-200">
                Contact Support
            </a>
        </div>

    </div>
</section>




    </main>


 
</body>
</html>



 