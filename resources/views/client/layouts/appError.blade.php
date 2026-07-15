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
<title>@yield('title')</title>   
@vite(['resources/css/app.css', 'resources/js/app.js'])    
</head>
<body class="min-h-screen bg-white text-gray-900 antialiased" x-data="appData()">
@include('client.layouts.navbar')
<main>
@yield('content')
</main>
@include('client.layouts.footer')
</body>
</html>



 