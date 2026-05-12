@extends('client.layouts.appError')
@section('title')
Oops !Page Not Found
@endsection  
@section('content')	
 <div class="w-full"></div>

<div class="container mx-auto px-4">
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Oops! Page Not Found</h1>
        <h2 class="text-xl text-blue-600 hover:underline">
            <a href="{{ route('home') }}">Home</a>
        </h2>
    </div>
</div>
 
               
 
@endsection