<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?> 
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
 @php
    $onlineslugs = [
        'sap-training',
        'sap-mm-training',
        'sap-fico-training',
        'sap-sd-training',
        'sap-pp-training',
        'sap-basis-training',
        'sap-hr-training',
        'sap-hcm-training',
        'sap-abap-training',
        'sap-success-factors-training',
        'workday-training',
        'aws-training',
        'salesforce-training',
        'artificial-intelligence-training',
        'python-training',
        'data-science-training',
        'data-analytics-training',
        'power-bi-training',
        'tableau-training',
        'machine-learning-training',
        'deep-learning-training',
        'mean-stack-training',
        'mern-stack-training',
        'react-js-training',
        'react-native-training',
        'full-stack-developer-training',
        'devops-training',
        'cloud-computing-training',
        'google-cloud-training',
    ];
@endphp

@foreach ($onlineslugs as $slug)
<url>
    <loc>https://www.quickdials.com/online/{{ $slug }}</loc>
    <lastmod>2026-06-09T10:30:00+00:00</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.80</priority>
</url>
@endforeach

</urlset>