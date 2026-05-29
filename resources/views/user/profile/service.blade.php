@extends('user.layouts.guest')

@section('title', 'User Service')

@section('description', 'User Service')

@section('keyword', 'User Service')
@section('content')

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

               {{-- 📊 Left: Step Indicator --}}
        <div class="lg:col-span-3">
            @include('user.profile.step-indicator', ['currentStep' => 'service'])
        </div>
         

        <div class="lg:col-span-9">
    <div class="flex items-center justify-between mb-5 pt-4">
        <h2 class="text-2xl font-semibold text-gray-800">
            Services for You
        </h2>
        <a href=""
           class="text-sm text-blue-600 hover:underline font-medium flex items-center gap-1">
            <i data-lucide="briefcase" class="w-4 h-4"></i>
            My Services
        </a>
    </div>

    @if($services->count() > 0)
    @foreach ($services as $service)
    
   
    @php

     
    $status     = $service->follow_status ?? 'active';
    $isJoined   = '1';
    $isInterested = '0';

    // Status badge styles
    $statusStyles = [
        '1'   => 'bg-green-100 text-green-700',
        '14'   => 'bg-green-100 text-green-700',
        '2'  => 'bg-yellow-100 text-yellow-700',
        '3' => 'bg-gray-100 text-gray-500',
        '8' => 'bg-gray-100 text-gray-500',
        '7' => 'bg-gray-100 text-gray-500',
        '10' => 'bg-gray-100 text-gray-500',
        '9' => 'bg-gray-100 text-gray-500',
        '15'   => 'bg-red-100 text-red-600',
        '5'   => 'bg-red-100 text-red-600',
        '6'   => 'bg-red-100 text-red-600',
        '4'   => 'bg-red-100 text-red-600',
    ];
    $statusClass = $statusStyles[$status] ?? 'bg-gray-100 text-gray-600';
@endphp

<div class="service-card group relative bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300"
     data-service-id="{{ $service->id }}">

    <div class="flex">
        {{-- LEFT: Company Logo / Initial --}}
        <div class="relative w-24 flex-shrink-0 bg-gradient-to-br from-blue-600 to-indigo-700 flex flex-col items-center justify-center p-4 text-white">
            
                <span class="text-2xl font-extrabold leading-none">
                    {{ strtoupper(substr($service->kw_text, 0, 1)) }}
                </span>
        
        </div>

        {{-- RIGHT: Details --}}
        <div class="flex-1 p-4">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    {{-- Service Name (category tag) --}}
                    <span class="inline-block text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded uppercase tracking-wide mb-1">
                        {{ $service->kw_text }}
                    </span>

                    {{-- Company Name --}}
                    <h3 class="text-sm font-bold text-gray-900 leading-snug">
                        {{ $service->client_companies }}
                    </h3>

                    @if(!empty($service->city_name))
                        <p class="text-xs text-gray-600 mt-1 line-clamp-2">{{ $service->city_name }}</p>
                    @endif
                </div>

                {{-- Status Badge --}}
                <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full uppercase {{ $statusClass }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ ucfirst($service->follow_status) }}
                </span>
            </div>

            {{-- Meta info --}}
            <div class="flex items-center gap-3 mt-2 text-[11px] text-gray-500">
                @if(!empty($service->city_name))
                    <span class="flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-3 h-3"></i>
                        {{ $service->city_name }}
                    </span>
                @endif
                @if(!empty($service->assigned_count))
                    <span class="flex items-center gap-1">
                        <i data-lucide="users" class="w-3 h-3"></i>
                        {{ $service->assigned_count }} joined
                    </span>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-2 mt-3 pt-3 border-t border-dashed border-gray-200">

                {{-- Interested Button --}}
                @if($service->follow_status)
                    <button type="button" disabled
                            class="interested-btn inline-flex items-center gap-1 bg-amber-100 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded cursor-default">
                        <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                        {{ $service->follow_status }}
                    </button>
                @endif
                     

                {{-- Join Button --}}
                @if($service->follow_status=='Joined')
                    <button type="button" disabled
                            class="join-btn inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1.5 rounded cursor-default">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        Joined
                    </button>
                @elseif($service->follow_status === 'Meeting Close' || $service->follow_status == 'Sales Close')
                    <button type="button" disabled
                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-400 text-xs font-semibold px-3 py-1.5 rounded cursor-not-allowed">
                        Closed
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
    @else
        <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
            <i data-lucide="briefcase" class="w-12 h-12 mx-auto text-gray-300 mb-3"></i>
            <p class="text-gray-600 font-medium">No services available</p>
        </div>
    @endif
</div>
      
    
    
    </div>
</div>


        </div>


@endsection