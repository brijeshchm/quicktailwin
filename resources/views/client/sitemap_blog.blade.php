<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

@foreach ($blogs as $blog)
<url>
    <loc>{{ url('blog/'.$blog->slug) }}</loc>    
    <lastmod>{{ \Carbon\Carbon::parse($blog->updated_at)->toAtomString() }}</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
</url>
@endforeach


</urlset>


 