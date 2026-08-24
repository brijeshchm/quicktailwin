<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

@php
    $allowedCities = [
        'faridabad'
    ];

    $keywordArray = [
        'artificial-intelligence-training',
        'python-training',
        'workday-training',
        'sap-training',
        'banquet-hall',
        'cricket-academy',
        'data-science-training',
        'judo-karate',
        'distance-education',
        'data-analytics-training',
        'salesforce-training',
        'wedding-organisers'

    ];
@endphp

@foreach ($allowedCities as $city)
    @foreach ($keywordArray as $keyword)
        <url>
            <loc>{{ route('city.slug', [
                'city_slug' => $city,
                'service_slug' => $keyword
            ]) }}</loc>

            <changefreq>daily</changefreq>
            <priority>0.80</priority>
        </url>
    @endforeach
@endforeach

  

@php
    $noidaCities = [
        'noida'
    ];

    $keywordArrayNoida = [
        'aws-training','cloud-computing-training','devops-training','digital-marketing-training','full-stack-developer-training','azure-training','pmp-certification-training','mba-distance','car-service','computer-repair','shooting-academy','swimming-academy','boxing'
    ];
@endphp

@foreach ($noidaCities as $cityNoida)
    @foreach ($keywordArrayNoida as $keywordNoida)
        <url>
            <loc>{{ route('city.slug', [
                'city_slug' => $cityNoida,
                'service_slug' => $keywordNoida
            ]) }}</loc>

            <changefreq>daily</changefreq>
            <priority>0.80</priority>
        </url>
    @endforeach
@endforeach
</urlset>