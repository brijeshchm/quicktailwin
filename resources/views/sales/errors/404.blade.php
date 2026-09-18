@extends('layouts.app')
@section('title','Page not found')
@section('content')
<div class="flex min-h-[60vh] flex-col items-center justify-center text-center"><h1 class="font-display text-6xl font-bold text-primary">404</h1><h2 class="mt-4 font-display text-2xl font-semibold">Page not found</h2><p class="mt-2 max-w-md text-slate-500">The page you're looking for doesn't exist or has been moved.</p><a href="{{ route('dashboard') }}" class="btn btn-primary mt-6">Back to Dashboard</a></div>
@endsection
