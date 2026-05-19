
@extends('client.layouts.app')
@section('title', 'Package Price Quick Dials- Local search, IT Training, Service, overseas education')
@section('description', 'Package Price Dials- Local search, IT Training, Service, overseas education')
@section('keyword', 'Package Price Dials- Local search, IT Training, Service, overseas education')

@section('content') 
 
<style>
    [x-cloak] { display: none !important; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-fade-up { animation: fadeUp .55s ease both; }

    .pkg-card {
        transition: transform .22s ease, box-shadow .22s ease;
    }
    .pkg-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,.13);
    }

    /* Disable hover-lift on touch devices to prevent sticky hover */
    @media (hover: none) {
        .pkg-card:hover { transform: none; box-shadow: 0 4px 12px -2px rgba(0,0,0,.08); }
    }
</style>

<main>
<section class="py-10 sm:py-16 md:py-20 bg-slate-100/60">
    <div class="container mx-auto px-4 md:px-6">

        {{-- Section header --}}
        <div class="text-center mb-8 sm:mb-12 md:mb-14 anim-fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-gray-900 leading-snug tracking-tight mb-3 md:mb-4">
                Welcome to
                <span class="text-indigo-600">
                    QuickDials<sup class="text-amber-500 text-lg sm:text-xl md:text-2xl font-normal align-super">™</sup>
                </span><span class="text-gray-900">.com</span>
            </h2>
            <div class="w-16 sm:w-20 md:w-24 h-1 bg-indigo-600 mx-auto mt-4 md:mt-6 rounded-full"></div>
        </div>

        {{-- Pricing cards --}}
        

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-5 md:gap-7 max-w-6xl mx-auto items-stretch">
            @foreach($data as $i => $pkg)
            <div class="pkg-card relative flex flex-col rounded-2xl md:rounded-3xl border-2 {{ $pkg['border'] }} bg-gradient-to-b {{ $pkg['gradient'] }} shadow-md overflow-hidden anim-fade-up"
                 style="animation-delay: ">

              
                <div class="p-5 sm:p-6 md:p-8 flex-1 flex flex-col">

                    {{-- Name + description --}}
                  <div class="mb-4 md:mb-5 pr-20 sm:pr-0 flex">
    
 

    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-1">
        <span class="text-green-600">₹</span>{{ number_format($pkg['amt']) }}
    </h3>

    <p class="mt-2 inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-sm font-medium shadow-sm">
        🪙 Coins : {{ number_format($pkg['coins']) }}
    </p>

</div>
   
                    @if($pkg['cta_style'] === 'solid')
                        <button class="w-full py-3.5 rounded-full font-semibold text-base text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-300/40 hover:shadow-indigo-400/50 transition-all">
                         <a href="{{url('payment/checkout?status=correction&encrypt='.$pkg['encrypt']) }}">  Buy Now</a>
                        </button>
                    @else
                        <button class="w-full py-3.5 rounded-full font-semibold text-base text-indigo-600 border-2 border-indigo-300 hover:bg-indigo-600 hover:text-white transition-all">
                             <a href="{{url('payment/checkout?status=correction&encrypt='.$pkg['encrypt']) }}" >  Buy Now</a>
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
</main>  


 @endsection
