<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
@foreach ($keywords as $keyword)
<url>     
      <loc>{{ route('city.slug', ['city_slug' => 'bangalore','service_slug' => $keyword->slug ]) }}</loc>
      <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>    
      <changefreq>weekly</changefreq>
      <priority>0.80</priority>
</url>
@endforeach 
@foreach ($keywords as $keyword)
<url>
      <loc>{{ route('city.slug', ['city_slug' => 'noida','service_slug' => $keyword->slug ]) }}</loc>
      <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>    
      <changefreq>weekly</changefreq>
      <priority>0.80</priority>
</url>
@endforeach
@foreach ($keywords as $keyword)
<url>
<loc>{{ route('city.slug', ['city_slug' => 'delhi','service_slug' => $keyword->slug ]) }}</loc>
<lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>  
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
@endforeach 
@foreach ($keywords as $keyword)
<url>
      <loc>{{ route('city.slug', ['city_slug' => 'lucknow','service_slug' => $keyword->slug ]) }}</loc>
      <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.80</priority>
</url>
@endforeach
@foreach ($keywords as $keyword)
<url>
      <loc>{{ route('city.slug', ['city_slug' => 'gorakhpur','service_slug' => $keyword->slug ]) }}</loc>
      <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.80</priority>
</url>
@endforeach

</urlset>