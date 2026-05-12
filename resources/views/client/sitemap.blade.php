<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?> 
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
<loc>https://www.quickdials.com/</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod>
<changefreq>weekly</changefreq>
<priority>1.00</priority>
</url>
<url>
<loc>https://www.quickdials.com/about-us</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.quickdials.com/contact-us</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.quickdials.com/careers</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/pricing</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod>
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/blog</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/privacy-policy</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/terms-conditions</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.quickdials.com/copyright-policy</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>

<url>
<loc>https://www.quickdials.com/business-owners</loc>
<lastmod>2026-04-27T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
<url>
<loc>https://www.quickdials.com/courses/playwright-automation-training-in-noida</loc>
<lastmod>2026-04-03T10:30:00+00:00</lastmod> 
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url> 
@foreach ($keywords as $keyword)
<url>
<loc>{{ route('showCity', $keyword->slug) }}</loc>     
<lastmod>{{ \Carbon\Carbon::parse($keyword->updated_at)->toAtomString() }}</lastmod>    
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
@endforeach 

@foreach ($categories as $category)
<url>     
<loc>{{ route('categories.show', $category->parent_slug) }}</loc>
<lastmod>{{ \Carbon\Carbon::parse($category->updated_at)->toAtomString() }}</lastmod>      
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
@endforeach 
@foreach ($childCategories as $child)
<url>     
<loc>{{ route('child.show', $child->child_slug) }}</loc>   
<lastmod>{{ \Carbon\Carbon::parse($child->updated_at)->toAtomString() }}</lastmod>     
<changefreq>weekly</changefreq>
<priority>0.80</priority>
</url>
@endforeach     
</urlset>