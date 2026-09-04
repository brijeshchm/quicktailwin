<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
<loc>https://www.quickdials.com/</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod>
<changefreq>daily</changefreq>
<priority>1.00</priority>
</url>
<url>
<loc>https://www.quickdials.com/about-us</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.quickdials.com/contact-us</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.quickdials.com/careers</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/pricing</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod>
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/blog</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/privacy-policy</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/terms-conditions</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.quickdials.com/copyright-policy</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/business-owners</loc>
<lastmod>2026-06-09T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.quickdials.com/courses/playwright-automation-training-in-noida</loc>
<lastmod>2026-04-03T10:30:00+00:00</lastmod> 
<changefreq>daily</changefreq>
<priority>0.80</priority>
</url>  
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


@php
    $delhiCities = [
        'delhi'
    ];
    $keywordArrayDelhi = [
        'sap-mm-training','sap-fico-training','sap-hana-training','power-bi-training','machine-learning-training','react-native-training','cyber-security-training','certified-ethical-hacking-training','nodejs-training','taekwondo','football-academy','photo-and-videography'
    ];
@endphp
@foreach ($delhiCities as $cityDelhi)
    @foreach ($keywordArrayDelhi as $keywordDelhi)
        <url>
            <loc>{{ route('city.slug', [
                'city_slug' => $cityDelhi,
                'service_slug' => $keywordDelhi
            ]) }}</loc>
            <changefreq>daily</changefreq>
            <priority>0.80</priority>
        </url>
    @endforeach
@endforeach


</urlset>