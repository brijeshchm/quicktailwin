@extends('business.business.layouts.app')
@section('title','Reviews')
@section('content')
@php $avg=count($reviews)?collect($reviews)->avg('rating'):0; @endphp
<div class="animate-fade-in space-y-5 md:space-y-6"><div>
    
<h1 class="font-display text-xl font-bold md:text-3xl">Customer Reviews</h1>

<p class="mt-1 text-sm text-slate-500 md:text-base">Read customer feedback and respond from one place.</p></div>
 <div class="card flex flex-col gap-5 p-5 sm:flex-row sm:items-center">
    
 <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-100 text-amber-600"><i data-lucide="star" class="h-8 w-8 fill-current"></i></div>
 
 
 <div>
    
 
 <div class="flex items-end gap-2"><span class="font-display text-4xl font-bold">{{ number_format($avg,1) }}</span><span class="pb-1 text-sm text-slate-500">out of 5</span></div>
 
 
 <div class="mt-1 flex gap-1">@for($s=1;$s<=5;$s++)<i data-lucide="star" class="h-4 w-4 {{ $s<=round($avg)?'fill-amber-500 text-amber-500':'text-slate-300' }}"></i>@endfor</div>


</div><div class="sm:ml-auto"><p class="font-display text-2xl font-bold">{{ count($reviews) }}</p><p class="text-sm text-slate-500">Total reviews</p></div></div>
 <div class="space-y-4">
    
 @foreach($reviews as $i=>$review)
    
 <div class="card animate-slide-up stagger-{{ ($i%5)+1 }} p-5 md:p-6">
    
 <div class="flex items-start gap-4"><span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-primary/10 font-display font-bold text-primary">{{ strtoupper(substr($review->comment_author,0,1)) }}</span><div class="min-w-0 flex-1"><div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-start"><div><h2 class="font-semibold">{{ $review->comment_author }}</h2><div class="mt-1 flex gap-0.5">@for($s=1;$s<=5;$s++)<i data-lucide="star" class="h-4 w-4 {{ $s<=$review->rating?'fill-amber-500 text-amber-500':'text-slate-300' }}"></i>@endfor</div></div><p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</p></div><div class="relative mt-4 rounded-xl bg-secondary/50 p-4"><i data-lucide="quote" class="absolute right-3 top-3 h-6 w-6 text-primary/10"></i><p class="pr-6 text-sm leading-relaxed">{{ $review->comment_content }}</p></div>

 

</div>

</div>

</div>
 
 @endforeach

</div>
</div>
@endsection
