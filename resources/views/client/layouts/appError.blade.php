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
    
    @yield('content')
    </main>


 
</body>
</html>



 