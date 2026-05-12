<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
@foreach ($keywords as $keyword)
<url>     
      <loc>{{ url('bangalore/'.$keyword->slug) }}</loc>
      <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>    
      <changefreq>weekly</changefreq>
      <priority>0.80</priority>
</url>
@endforeach 
@foreach ($keywords as $keyword)
<url>     
      <loc>{{ url('noida/'.$keyword->slug) }}</loc>
      <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>    
      <changefreq>weekly</changefreq>
      <priority>0.80</priority>
</url>
@endforeach
@foreach ($keywords as $keyword)
<url>     
<loc>{{ url('delhi/'.$keyword->slug) }}</loc>
<lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>  
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
@endforeach 
@foreach ($keywords as $keyword)
<url>     
      <loc>{{ url('lucknow/'.$keyword->slug) }}</loc>
      <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.80</priority>
</url>
@endforeach
@foreach ($keywords as $keyword)
<url>     
      <loc>{{ url('gorakhpur/'.$keyword->slug) }}</loc>
      <lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>
      <changefreq>weekly</changefreq>
      <priority>0.80</priority>
</url>
@endforeach

</urlset>