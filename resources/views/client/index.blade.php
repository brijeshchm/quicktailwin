 
@extends('client.layouts.app')
@section('title', 'QuickDials - India’s Trusted Local Business Search Engine')
@section('description', 'QuickDials is India’s leading local business search engine to find top-rated IT training institutes, wedding services, academy, real estate, and repair services.')
@section('keywords', 'QuickDials, Local business directory in India, Business listing, IT Training Institutes near me, Wedding book near me, Hotels near me, Salons near me, Healthcare services, Schools & Colleges near me, Business reviews, ratings, contact, and address')
@section('content')
@include('client.components.homePage.hero-section')
@include('client.components.homePage.category-grid')
@include('client.components.homePage.blog-service')
@include('client.components.homePage.stats-banner')

  <section class="py-10 px-4 md:px-8">
    <h2 class="text-xl font-black text-gray-900 mb-6">
        Browse Search
    </h2>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">

        @php
            $cityKeywordMap = [

              
                'noida' => [
                    'aws-training',
                    'cloud-computing-training',
                    'devops-training',
                    'digital-marketing-training',
                    'full-stack-developer-training',
                    'azure-training',
                    'pmp-certification-training',
                    'mba-distance',
                    'car-service',
                    'computer-repair',
                    'shooting-academy',
                    'swimming-academy',
                    'boxing',
                ],

                'delhi' => [
                    'sap-mm-training',
                    'sap-fico-training',
                    'sap-hana-training',
                    'power-bi-training',
                    'machine-learning-training',
                    'react-native-training',
                    'cyber-security-training',
                    'certified-ethical-hacking-training',
                    'nodejs-training',
                    'taekwondo',
                    'football-academy',
                    'photo-and-videography',
                ],

                'bangalore' => [
                    'sap-sd-training',
                    'sap-hcm-training',
                    'sap-success-factors-training',
                    'workday-hcm-functional',
                    'tableau-training',
                    'deep-learning-training',
                    'php-training',
                    'mern-stack-training',
                    'catering-services',
                    'event-organizers',
                    'tent-house',
                    'table-tennis',
                    'archery',
                ],

            ];

            $noCitySlugs = [
                'wedding-planning',
                'spa-hub'
            ];
        @endphp


        @foreach($cityKeywordMap as $city => $keywords)

            @foreach($keywords as $keyword)

                @php
                    $popSUrl = in_array($keyword, $noCitySlugs)
                        ? route('showCity', $keyword)
                        : route('city.slug', [
                            'city_slug'    => $city,
                            'service_slug' => $keyword
                        ]);

                    $title = ucwords(str_replace('-', ' ', $keyword));
                @endphp


                <a href="{{ $popSUrl }}"
                   class="flex flex-col items-center gap-2 p-3 rounded-2xl
                          border border-gray-100 hover:border-blue-200
                          hover:bg-blue-50/50 transition-all group
                          text-center">

               

                    <span class="text-xs font-semibold text-gray-700
                                 group-hover:text-blue-700 leading-tight">

                        {{ $title }}

                    </span>

                    <span class="text-[10px] text-gray-400">
                        {{ ucfirst($city) }}
                    </span>

                </a>

            @endforeach

        @endforeach

    </div>
</section>

@endsection

