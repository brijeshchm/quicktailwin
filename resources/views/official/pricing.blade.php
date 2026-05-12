
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
    </style>
 
 

 

{{-- ══════════════════════════
     PRICING SECTION
══════════════════════════ --}}
<main>
<section class="py-20 bg-slate-100/60">
    <div class="container mx-auto px-4 md:px-6">

        {{-- Section header --}}
        <div class="text-center mb-14 anim-fade-up">
            <h2 class="text-3xl md:text-5xl font-bold text-gray-900 leading-snug tracking-tight mb-4">
                Welcome to
                <span class="text-indigo-600">
                    QuickDials<sup class="text-amber-500 text-2xl font-normal align-super">™</sup>
                </span><span class="text-gray-900">.com</span>
            </h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg leading-relaxed">
                Pick a plan that suits your business size and how fast you want to grow. Every package gives you easy system access and tools to manage your enquiries smoothly. Higher plans come with more user access and extra coins, which help you reach more customers and handle more requests. All plans are made to keep things simple, clear, and easy to use for your daily business needs.
            </p>
            <div class="w-24 h-1 bg-indigo-600 mx-auto mt-6 rounded-full"></div>
        </div>

        {{-- Pricing cards --}}
        @php
        $packages = [
            [
                'name'        => 'INR ₹ 0 Free',
                'price'       => 'Coins (555)',
                'description' => 'Long time system login access',
                'gradient'    => 'from-green-50 to-gray-100',
                'border'      => 'border-gray-200',
                'badge'       => null,
                'cta'         => 'Get Started',
                'cta_style'   => 'outline',
                'features'    => [
                    'Online system',
                    'Full access',
                    'Push Notification',
                    'Roles & Permissions',
                    'Coins (555) Free First Time',
                ],
            ],
            [
                'name'        => 'INR ₹ 1000',
                'price'       => 'Coins (1111)',
                'description' => 'Long time system login access',
                'gradient'    => 'from-indigo-50 to-indigo-100',
                'border'      => 'border-indigo-300',
                'badge'       => 'Most Popular',
                'cta'         => 'Choose Premium',
                'cta_style'   => 'solid',
                'features'    => [
                    'Online system',
                    'Full access',
                    'Push Notification',
                    'Roles & Permissions',
                    'Unlimited support',
                ],
            ],
            [
                'name'        => 'INR ₹ 10000',
                'price'       => 'Coins (12500)',
                'description' => 'Unlimited Users Access',
                'gradient'    => 'from-amber-50 to-yellow-50',
                'border'      => 'border-amber-200',
                'badge'       => 'Best Value',
                'cta'         => 'Go Royal',
                'cta_style'   => 'outline',
                'features'    => [
                    'Online system',
                    'Luxury 5-star venue booking',
                    'Full access',
                    'Push Notification',
                    'Roles & Permissions',
                    'Unlimited support',
                ],
            ],
            [
                'name'        => 'INR ₹ 3000',
                'price'       => 'Coins (3529)',
                'description' => 'Unlimited Users Access',
                'gradient'    => 'from-green-50 to-gray-100',
                'border'      => 'border-gray-200',
                'badge'       => null,
                'cta'         => 'Get Started',
                'cta_style'   => 'outline',
                'features'    => [
                    'Online system',
                    'Full access',
                    'Push Notification',
                    'Roles & Permissions',
                    'Coins (3529) Free First Time',
                ],
            ],
            [
                'name'        => 'INR ₹ 2000',
                'price'       => 'Coins (2272)',
                'description' => 'Long time system login access',
                'gradient'    => 'from-indigo-50 to-indigo-100',
                'border'      => 'border-indigo-300',
                'badge'       => null,
                'cta'         => 'Get Started',
                'cta_style'   => 'solid',
                'features'    => [
                    'Online system',
                    'Full access',
                    'Push Notification',
                    'Roles & Permissions',
                ],
            ],
            [
                'name'        => 'INR ₹ 5000',
                'price'       => 'Coins (6099)',
                'description' => 'Unlimited Users Access',
                'gradient'    => 'from-indigo-50 to-indigo-100',
                'border'      => 'border-indigo-300',
                'badge'       => 'Most Popular',
                'cta'         => 'Choose Premium',
                'cta_style'   => 'solid',
                'features'    => [
                    'Online system',
                    'Full access',
                    'Push Notification',
                    'Roles & Permissions',
                    'Unlimited support',
                    'Coins (3529) Free First Time',
                ],
            ],
        ];
        @endphp

        <div class="grid md:grid-cols-3 gap-7 max-w-6xl mx-auto items-stretch">
            @foreach($packages as $i => $pkg)
            <div class="pkg-card relative flex flex-col rounded-3xl border-2 {{ $pkg['border'] }} bg-gradient-to-b {{ $pkg['gradient'] }} shadow-md overflow-hidden anim-fade-up"
                 style="animation-delay: {{ $i * 0.12 }}s">

                {{-- Badge --}}
                @if($pkg['badge'])
                <div class="absolute top-5 right-5">
                    <span class="inline-flex items-center gap-1 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        {{ $pkg['badge'] }}
                    </span>
                </div>
                @endif

                <div class="p-8 flex-1 flex flex-col">

                    {{-- Name + description --}}
                    <div class="mb-5">
                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $pkg['name'] }}</h3>
                        <p class="text-gray-500 text-sm">{{ $pkg['description'] }}</p>
                    </div>

                    {{-- Price --}}
                    <div class="mb-7">
                        <span class="text-4xl font-bold text-gray-900">{{ $pkg['price'] }}</span>
                        <span class="text-gray-400 ml-2 text-sm">starting from</span>
                    </div>

                    {{-- Features --}}
                    <ul class="space-y-3 mb-8 flex-1">
                        @foreach($pkg['features'] as $feature)
                        <li class="flex items-start gap-3 text-sm text-gray-700">
                            <div class="w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>

                    {{-- CTA --}}
                    @if($pkg['cta_style'] === 'solid')
                        <button class="w-full py-3.5 rounded-full font-semibold text-base text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-300/40 hover:shadow-indigo-400/50 transition-all">
                            {{ $pkg['cta'] }}
                        </button>
                    @else
                        <button class="w-full py-3.5 rounded-full font-semibold text-base text-indigo-600 border-2 border-indigo-300 hover:bg-indigo-600 hover:text-white transition-all">
                            {{ $pkg['cta'] }}
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
