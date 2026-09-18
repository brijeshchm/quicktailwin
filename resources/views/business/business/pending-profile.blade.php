@extends('business.business.layouts.app')
@section('title','Reviews')
@section('content')
@php $avg=count($reviews)?collect($reviews)->avg('rating'):0; @endphp
<div class="animate-fade-in space-y-5 md:space-y-6"><div>
    
<h1 class="font-display text-xl font-bold md:text-3xl">Customer Reviews</h1>

<p class="mt-1 text-sm text-slate-500 md:text-base">Read customer feedback and respond from one place.</p></div>
 @php
    
    $percent = $completion['total'];
    $color = $percent >= 80 ? 'emerald' : ($percent >= 50 ? 'amber' : 'destructive');
@endphp

<div class="card p-4">
    <div class="mb-2 flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
            Profile Completion
        </p>
        <span class="font-display text-lg font-bold text-{{ $color }}-600">
            {{ round($percent) }}%
        </span>
    </div>

    <div class="h-2 w-full overflow-hidden rounded-full bg-secondary">
        <div class="h-full rounded-full bg-{{ $color }}-500 transition-all duration-500"
             style="width: {{ round($percent) }}%"></div>
    </div>

    @if($percent < 100 && !empty($completion['missing_fields']))
        <details class="mt-3 text-xs text-slate-500">
            <summary class="cursor-pointer font-medium">
                Complete these to boost your profile
            </summary>
            <ul class="mt-2 list-disc space-y-1 pl-4">
                @foreach(array_slice($completion['missing_fields'], 0, 6) as $field)
                    <li>{{ ucwords(str_replace('_', ' ', $field)) }}</li>
                @endforeach
            </ul>
        </details>
    @endif
</div>
  
</div>
@endsection
