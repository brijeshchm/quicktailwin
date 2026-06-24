<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Client;
use Illuminate\Support\Facades\Cache;
class CitySlugController extends Controller
{
    /**
     * Fetch data from the QuickDials API.
     */
    private function fetchData(string $city, string $keyword): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withoutVerifying()->get('https://api.quickdials.com/api/website/city/keyword', [
                    'city'    => $city,
                    'keyword' => $keyword,
                ]);
 
            return $response->successful() ? $response->json() : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
    /**
     * Fetch data from the QuickDials API.
     */
    private function businessOwnersData(): ?array
    {
        try {
                $res = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/business-owners');
                return $res->successful() ? $res->json() : null;
            } catch (\Exception $e) {
                \Log::error('BusinessOwners API: ' . $e->getMessage());
                return null;
            }
              
    }

    /**
     * Check if a city is valid via the QuickDials city-check API.
     */
    private function cityExists(string $city): bool
    {
		
		 
        try {
            $response = Http::timeout(5)
               ->withoutVerifying()->get('https://api.quickdials.com/api/website/checkCity', ['city' => $city]);			 

                  
            if (!$response->successful()) return false;

            $data = $response->json();
					 
            return ($data['status'] ?? false) === true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    
    /**
     * Check if a city is valid via the QuickDials city-check API.
     */
    private function serviceExists(string $slug): bool
    {
				 
        try {
            $response = Http::timeout(5)
               ->withoutVerifying()->get('https://api.quickdials.com/api/website/getKeyword', ['keyword' => $slug]);
                 
            if (!$response->successful()) return false;
            $data = $response->json();			 		 
            return ($data['status'] ?? false) === true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Fetch data from the QuickDials API.
     */
    private function fetchKeywordData(string $slug): ?array
    {
        try {
             $response = Http::timeout(5)
               ->withoutVerifying()->get('https://api.quickdials.com/api/website/getKeyword', ['keyword' => $slug]);
 
            return $response->successful() ? $response->json() : null;
        } catch (\Throwable $e) {
            return null;
        }
    }


    /**
     * Fetch data from the QuickDials API.
     */
    private function fetchCityData(string $city=null)
    {
        try {
             $response = Http::timeout(5)
               ->withoutVerifying()->get('https://api.quickdials.com/api/website/getCityList', ['city' => $city]);
 
            return $response->successful() ? $response->json() : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
     

    /**
     * Fetch data from the QuickDials API.
     */
    private function fetchBusinessData(string $slug=null)
    {
 
        try {
                $res = Http::timeout(10)->withoutVerifying()
                ->get('https://api.quickdials.com/api/website/business-details', [
                    'business_slug' => $slug,
                ]);
 
                return $res->successful() ? $res->json() : null;
          
        } catch (\Throwable $e) {
            return null;
        }
    }
     

    /**
     * Normalize a raw API business record into the UI shape.
     */
    private function normalizeBusiness(array $b, int $index): array
    {
        $colorPalette = [
            'from-violet-500 to-indigo-600', 'from-emerald-500 to-teal-600',
            'from-orange-500 to-amber-600',  'from-blue-500 to-cyan-600',
            'from-pink-500 to-rose-600',     'from-slate-500 to-gray-700',
            'from-sky-500 to-blue-600',      'from-amber-500 to-yellow-600',
            'from-fuchsia-500 to-purple-600','from-lime-500 to-green-600',
        ];

        $tags     = $this->normalizeArray($b['tags'] ?? []);
        $category = $this->normalizeArray($b['category'] ?? []);
        $name     = $b['business_name'] ?? 'Business Name';
        $id       = $b['business_id'] ?? $index;

        $gallery = is_array($b['gallery'] ?? null)
            ? $b['gallery']
            : [];


            $overviewBusiness = $b['overviewBusiness'][0];
 

        return [
            'id'            => $id,
            'name'          => $name,
            'business_slug' => $b['business_slug'] ?? '',
            'category'      => array_slice($category, 0, 5),
            'rating'        => (float) ($b['avgRating'] ?? 4.0),
            'reviewCount'   => (int)   ($b['comment_count'] ?? $b['review_count'] ?? 0),
            'address'       => $b['address'] ?? '',
            'city'          => $b['city'] ?? '',
            'openUntil'     => $b['openUntil'] ?? $b['open_until'] ?? '9:00 AM',
            'isOpen'        => $b['isOpen'] ?? $b['is_open'] ?? true,
            'verified'      => $b['verified'] ?? $b['trusted_status'] ?? false,
            'trending'      => $b['trending'] ?? false,
            'topSearch'     => $b['topSearch'] ?? $b['top_search'] ?? false,
            'featured'      => $b['featured'] ?? false,
            'tags'          => array_slice($tags, 0, 5),
            'phone'         => $b['call'] ?? '',
            'whatsapp'      => $b['whatsapp'] ?? '',
            'color'         => $colorPalette[$id % count($colorPalette)],
            'description'   => $b['description'] ?? '',
            'responseTime'  => $b['responseTime'] ?? $b['response_time'] ?? '< 15 min',
            'established'   => $b['year_of_estb'] ?? '',
            'certifications'   => $b['certifications'] ?? '',
            'gallery'   => $gallery ?? '',
            'overviewBusiness'   => $overviewBusiness ?? '',
        ];
    }

    /**
     * Normalize an agent record for the comparison table.
     */
    private function normalizeAgent(array $b): array
    {
        $tags     = $this->normalizeArray($b['tags'] ?? []);
        $category = $this->normalizeArray($b['category'] ?? []);
        $name     = $b['business_name'] ?? '';

        $govParts = array_filter([
            !empty($b['gst_no'])  ? "GST No: {$b['gst_no']}"   : null,
            !empty($b['pan_no'])  ? "PAN No: {$b['pan_no']}"   : null,
            !empty($b['iso_no'])  ? "ISO No: {$b['iso_no']}"   : null,
            !empty($b['msme_no']) ? "MSME No: {$b['msme_no']}" : null,
            !empty($b['cin_no'])  ? "CIN No: {$b['cin_no']}"   : null,
        ]);

        $govRecognition = count($govParts)
            ? "{$name} has been registered with " . implode(', ', $govParts) . '.'
            : "{$name} has no government recognition details available.";

        return [
            'name'                 => $name,
            'address'              => $b['address'] ?? '',
            'about'                => $b['description'] ?? '',
            'Services_Offered'     => implode(', ', $tags),
            'Year_of_Establishment'=> $b['year_of_estb'] ?? '',
            'No_of_Reviews'        => $b['comment_count'] ?? 0,
            'Rating'               => $b['avgRating'] ?? 0,
            'Training_Type'        => null,
            'Mode_of_Instruction'  => null,
            'Listed_Categories'    => implode(', ', $category),
            'Government_Recognition'=> $govRecognition,
            'Certificate_Awards'   => '',
            'FAQ'                  => '',
        ];
    }

    /**
     * Convert tags/category that may be array or key-value object.
     */
    private function normalizeArray(mixed $value): array
    {
        if (is_array($value)) return array_values($value);
        return [];
    }
    /**
     * Convert tags/category that may be array or key-value object.
     */
    private function getClientDetail($businessResponse,$slug): \Illuminate\Contracts\View\View
    {
         
        $data        = $businessResponse['data']         ?? [];
        $clientsList = $data['clientsList']       ?? [];
       
        $certificate = $data['certificate']       ?? [];
        $comment     = $data['comment']           ?? [];
        $areaBusiness    = $data['area_business']     ?? [];
        $overviewBusiness= $data['overview_business'] ?? [];
        $relatedSearches = $data['related_searches']  ?? [];
    $keywordList = Cache::remember('keyword_list', 3600, function () {
            try {
                $res = Http::timeout(10)
                    ->get('https://api.quickdials.com/api/website/get-keyword-list');
                return $res->successful() ? ($res->json('data') ?? []) : [];
            } catch (\Exception $e) {
                return [];
            }
        });
     
 
        // Gallery images
        $gallery = is_array($clientsList['gallery'] ?? null)
            ? $clientsList['gallery']
            : [];
 
        $hImages = array_slice($gallery, 0, (int) ceil(count($gallery) / 2)) ?: [
            asset('/images/gallery.jpg'),
        ];
        $vImages = array_slice($gallery, (int) ceil(count($gallery) / 2)) ?: [
            asset('/images/gallery.jpg'),
        ];
 
        // Services / assigned keywords
        $assignKeyword = is_array($clientsList['assign_keyword'] ?? null)
            ? $clientsList['assign_keyword']
            : [];
 
        // Related searches — object to array
        $relatedList = [];
        if (is_array($relatedSearches)) {
            foreach ($relatedSearches as $sl => $title) {
                $relatedList[] = ['slug' => $sl, 'title' => is_string($title) ? $title : $sl];
            }
        }
 
        // Certifications (up to 10)
        $certifications = [];
        for ($i = 1; $i <= 10; $i++) {
            $name = $certificate["award_name{$i}"] ?? null;
            $img  = $certificate["award_img{$i}"]  ?? null;
            if ($name || $img) {
                $certifications[] = ['name' => $name, 'img' => $img, 'index' => $i];
            }
        }
 
        // Government recognitions
        $govDocs = [
            ['title' => 'CIN',   'no' => $certificate['cin_no']   ?? null, 'img' => $certificate['cin_certificate']   ?? null, 'tileBg' => 'linear-gradient(135deg,#1e3a8a,#2563eb)',  'color' => '#1d4ed8'],
            ['title' => 'MSME',  'no' => $certificate['msme_no']  ?? null, 'img' => $certificate['msme_certificate']  ?? null, 'tileBg' => 'linear-gradient(135deg,#78350f,#b45309)',  'color' => '#92400e'],
            ['title' => 'GST',   'no' => $certificate['gst_no']   ?? null, 'img' => $certificate['gst_certificate']   ?? null, 'tileBg' => 'linear-gradient(135deg,#7f1d1d,#dc2626)',  'color' => '#b91c1c'],
            ['title' => 'ISO',   'no' => $certificate['iso_no']   ?? null, 'img' => $certificate['iso_certificate']   ?? null, 'tileBg' => 'linear-gradient(135deg,#14532d,#151c80)',  'color' => '#15803d'],
            ['title' => 'DPIIT', 'no' => $certificate['dpiit_no'] ?? null, 'img' => $certificate['dpiit_certificate'] ?? null, 'tileBg' => 'linear-gradient(135deg,#802e15,#16a34a)',  'color' => '#151c80'],
            ['title' => 'COI',   'no' => $certificate['coi_no']   ?? null, 'img' => $certificate['coi_certificate']   ?? null, 'tileBg' => 'linear-gradient(135deg,#14532d,#802e15)',  'color' => '#802e15'],
            ['title' => 'PAN',   'no' => $certificate['pan_no']   ?? null, 'img' => $certificate['pan_certificate']   ?? null, 'tileBg' => 'linear-gradient(135deg,#7c1580,#16a34a)',  'color' => '#7c1580'],
        ];
        $govDocs = array_values(array_filter($govDocs, fn($g) => $g['no'] || $g['img']));
 
        // Reviews
        $reviews = is_array($comment) ? array_values($comment) : [];
 
        $gradients = ['from-rose-500 to-orange-400','from-indigo-500 to-purple-600','from-teal-400 to-cyan-500','from-blue-600 to-violet-600','from-emerald-400 to-teal-600','from-amber-500 to-red-500'];

		  $linearGradients = ['linear-gradient(135deg,#1e3a8a,#2563eb)','linear-gradient(135deg,#78350f,#b45309)','linear-gradient(135deg,#7f1d1d,#dc2626)','linear-gradient(135deg,#7c1580,#16a34a)','linear-gradient(135deg,#14532d,#151c80)','linear-gradient(135deg,#14532d,#802e15)'];
 
        $bgColors = ['rgba(99,102,241,0.18)','rgba(244,63,94,0.18)','rgba(234,88,12,0.18)','rgba(20,184,166,0.18)','rgba(168,85,247,0.18)','rgba(37,99,235,0.18)','rgba(234,179,8,0.18)','rgba(34,197,94,0.18)'];
        $iconColors = ['#6366f1','#f43f5e','#ea580c','#14b8a6','#a855f7','#2563eb','#ca8a04','#16a34a'];
 
        $planOptions = ['Immediate', 'Within Week', 'Within Months', 'Not Planned Yet'];
 
        $googleMapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($clientsList['address'] ?? 'Bangalore');
        $mapSrc = 'https://www.google.com/maps/embed/v1/search?key=AIzaSyAPFOcLOlCcBCtp764h9HflPfA56VlCFo0&q=' . urlencode($clientsList['address'] ?? 'Bangalore');
 
        $yearEst  = $clientsList['year_of_estb'] ?? 2012;
        $yearsExp = date('Y') - (int)$yearEst;
 
        $todayDay = date('l'); // "Monday", "Tuesday", etc.
        $hours = [
            ['day'=>'Monday',    'hours'=>'9:00 AM – 7:00 PM'],
            ['day'=>'Tuesday',   'hours'=>'9:00 AM – 7:00 PM'],
            ['day'=>'Wednesday', 'hours'=>'9:00 AM – 7:00 PM'],
            ['day'=>'Thursday',  'hours'=>'9:00 AM – 7:00 PM'],
            ['day'=>'Friday',    'hours'=>'9:00 AM – 7:00 PM'],
            ['day'=>'Saturday',  'hours'=>'9:00 AM – 7:00 PM'],
            ['day'=>'Sunday',    'hours'=>'Closed'],
        ];
 
   





        $metaTitle = !empty($clientsList['meta_title'])
        ? $clientsList['meta_title']
        : ($clientsList['business_name'] ?? '') . ' | ' . ($clientsList['city'] ?? '') . ' | QuickDials';

        $metaKeywords = !empty($clientsList['meta_keywords'])
        ? $clientsList['meta_keywords']
        : ($clientsList['business_name'] ?? '') . ' | QuickDials';

        $relatedSearches = $data['related_searches'] ?? [];
        $services        = array_values(array_slice($relatedSearches, 0, 4));
        $serviceText     = implode(', ', $services);

        $metaDescription = !empty($clientsList['meta_description'])
        ? $clientsList['meta_description']
        : ($clientsList['business_name'] ?? '') . ' in ' . ($clientsList['city'] ?? '') .
        ' - ' . $serviceText .
        '. View address, photos, reviews and contact details on QuickDials.';





        return view('client.client-detail', compact(
            'slug', 'clientsList', 'keywordList','certificate','metaTitle','metaKeywords','metaDescription',
            'comment', 'areaBusiness', 'overviewBusiness',
            'relatedList', 'gallery', 'hImages', 'vImages',
            'assignKeyword', 'certifications', 'govDocs', 'reviews',
            'gradients', 'bgColors', 'iconColors', 'planOptions',
            'googleMapUrl', 'mapSrc', 'yearsExp', 'yearEst',
            'todayDay', 'hours','linearGradients'
        ));
    }

    /**
     * Replace {{city}} placeholder and strip basic HTML.
     */
    private function getsearchlist($response, $slug, $city): \Illuminate\Contracts\View\View
    {
         

        $businessOwners = $this->businessOwnersData();

        $growthBusiness = $businessOwners['data']['businessOwners'] ?? [];

        
        $data     = $response['data'] ?? [];
   
        $kwData   = $data['keyword'] ?? [];
        $keywordBanners   = $kwData['keywordBanners'] ?? [];
 
        // ── Keyword / meta ─────────────────────────────────────────────────
        $keyword    = $this->replaceCity($kwData['keyword'] ?? $slug, $city);
        $area       = $kwData['area'] ?? $city;
        $childSlug  = $kwData['child_slug'] ?? '';
        $childCat   = $kwData['child_category'] ?? '';
        $ratingCount = (int) ($kwData['ratingcount'] ?? 0);
        $ratingValue = (float) ($kwData['ratingvalue'] ?? 4.8);
        $bgImage    = $kwData['category_banner'] ?? '/computer-courses-training.jpg';
 
        $topDescription    = $this->replaceCity($kwData['top_description'] ?? '', $area);
        $bottomDescription = $this->replaceCity($kwData['bottom_description'] ?? '', $area);
 
        // ── FAQs ───────────────────────────────────────────────────────────
        $faqs = [];
        for ($i = 0; $i <= 10; $i++) {
            $q = $this->replaceCity($kwData["faqq{$i}"] ?? '', $city);
            $a = $this->replaceCity($kwData["faqa{$i}"] ?? '', $city);
            if ($q && $a) $faqs[] = ['q' => $q, 'a' => $a];
        }

        // ── Businesses ─────────────────────────────────────────────────────
        $rawList    = $data['clientsList'] ?? [];
        
        $agents    = $data['agents'] ?? [];
        $businesses = collect($rawList)
            ->map(fn ($b, $i) => $this->normalizeBusiness($b, $i))
            ->all();


             
        // ── Agents comparison table ────────────────────────────────────────
        $agents = collect($agents)
            ->map(fn ($b) => $this->normalizeAgent($b))
            ->all();
 
        // ── Reviews ────────────────────────────────────────────────────────
        $reviews = $data['reviewList'] ?? [];

        // ── Related data ───────────────────────────────────────────────────
        $relatedCategory = $data['relatedCategory'] ?? [];
        $servicesRelated = $data['servicesRelated'] ?? [];

        // ── Dynamic categories list ────────────────────────────────────────
        $categories = array_merge(
            ['All'],
            array_values(array_unique(
                collect($businesses)->pluck('category')->flatten()->filter()->unique()->values()->all()
            ))
        );


         
 


    

        // ── Chunk businesses for ad insertion every 5 ─────────────────────
        $businessChunks = array_chunk($businesses, 5);
        $quickBusinesses = $data['quickBusinesses'] ?? [];
        $responseZones = $this->fetchCityData($city);
        $zones     = $responseZones['data'] ?? [];
 

        			
		
    //         $keywordBanners = DB::table('keyword_banners')
    // ->where('keyword_id', '2973')
    // ->orderBy('sort_order')
    // ->get()
    // ->map(function ($b) {
    //     $b->image_url = asset($b->image_path);
    //     $b->alt_text  = $b->alt_text ?: 'Banner';
    //     $b->click_url = $b->client_slug ? url('/business-details/' . $b->client_slug) : null;
    //     return $b;
    // })
    // ->values();
	
	
        return view('client.searchlist ', compact(
            'city', 'slug', 'keyword', 'area','zones',
            'childSlug', 'childCat',
            'ratingCount', 'ratingValue', 'bgImage',
            'topDescription', 'bottomDescription',
            'faqs', 'kwData','keywordBanners',
            'businesses', 'businessChunks',
            'agents', 'reviews', 'categories',
            'relatedCategory', 'servicesRelated',
            'quickBusinesses','growthBusiness'
        ) + [
            'metaTitle'       => $kwData['meta_title'] ?? "{$keyword} in " . ucfirst($city),
            'metaDescription' => $kwData['meta_description'] ?? '',
            'metaKeywords'    => $kwData['meta_keywords'] ?? '',
        ]);
    }


    /**
     * Replace {{city}} placeholder and strip basic HTML.
     */
    private function replaceCity(string $text, string $city): string
    {
        return str_ireplace('{{city}}', ucfirst($city), $text);
    }

    /**
     * Handle  GET /{city}/{slug}
     */

    public function showCityWithService(Request $request, string $city, string $slug)
    {
        $city = strtolower($city);
 
        // 1. Validate city
        if (!$this->cityExists($city)) {
              abort(410);
           
        }

        // 2. If slug is NOT a service, try it as a business slug
        if (!$this->serviceExists($slug)) {
            
            $businessResponse = $this->fetchBusinessData($slug);
           if (!$businessResponse) {
              
               abort(410);
            }

             
            return $this->getClientDetail($businessResponse,$slug);
        }

        // 3. Otherwise treat as service / search listing
        $response = $this->fetchData($city, $slug);

        
        if (!$response) {
            abort(410);
        }

        return $this->getsearchlist($response, $slug, $city);
    }


   



     /**
     * Handle  GET /{city}/{slug}
     */
    public function showCityOrService(Request $request, string $slug)
    {
        $slug = strtolower($slug);
 
        // ── Validate city ──────────────────────────────────────────────────
        if (!$this->serviceExists($slug)) {
            abort(410);
        }

        // ── Fetch data ─────────────────────────────────────────────────────
        $response = $this->fetchKeywordData($slug);
    
        $data     = $response['data'] ?? [];
        $kwData   = $data['keyword'] ?? [];
        $businessOwners = $this->businessOwnersData();

        $growthBusiness = $businessOwners['data']['businessOwners'] ?? [];
        // ── Keyword / meta ─────────────────────────────────────────────────
        $keyword    = $this->replaceCity($kwData['keyword'] ?? $slug, '');
        $area       = $kwData['area'] ?? '';
        $childSlug  = $kwData['child_slug'] ?? '';
        $childCat   = $kwData['child_category'] ?? '';
        $ratingCount = (int) ($kwData['ratingcount'] ?? 0);
        $ratingValue = (float) ($kwData['ratingvalue'] ?? 4.8);
        $bgImage    = $kwData['category_banner'] ?? '/computer-courses-training.jpg';
 
        $topDescription    = $this->replaceCity($kwData['top_description'] ?? '', $area);
        $bottomDescription = $this->replaceCity($kwData['bottom_description'] ?? '', $area);
 
        // ── FAQs ───────────────────────────────────────────────────────────
        $faqs = [];
        for ($i = 0; $i <= 10; $i++) {
            $q = $this->replaceCity($kwData["faqq{$i}"] ?? '', '');
            $a = $this->replaceCity($kwData["faqa{$i}"] ?? '', '');
            if ($q && $a) $faqs[] = ['q' => $q, 'a' => $a];
        }
 
        // ── Businesses ─────────────────────────────────────────────────────
        $rawList    = $data['clientsList'] ?? [];
        $agents    = $data['agents'] ?? [];
        $businesses = collect($rawList)
            ->map(fn ($b, $i) => $this->normalizeBusiness($b, $i))
            ->all();


         
        // ── Agents comparison table ────────────────────────────────────────
        $agents = collect($agents)
            ->map(fn ($b) => $this->normalizeAgent($b))
            ->all();

        // ── Reviews ────────────────────────────────────────────────────────
        $reviews = $data['reviewList'] ?? [];

        // ── Related data ───────────────────────────────────────────────────
        $relatedCategory = $data['relatedCategory'] ?? [];
        $servicesRelated = $data['servicesRelated'] ?? [];

        // ── Dynamic categories list ────────────────────────────────────────
        $categories = array_merge(
            ['All'],
            array_values(array_unique(
                collect($businesses)->pluck('category')->flatten()->filter()->unique()->values()->all()
            ))
        );

        // ── Chunk businesses for ad insertion every 5 ─────────────────────
        $businessChunks = array_chunk($businesses, 5);

        // ── Quick response businesses (static sample; replace with API if available) ──
        $quickBusinesses = $data['quickBusinesses'] ?? [];
            // $zones = DB::table('citylists')
            // ->join('zones', 'zones.city_id', '=', 'citylists.id')					
            // ->select('zones.id', 'zones.zone', 'zones.pincode','citylists.city_slug')
           
            // ->distinct()
            // ->orderBy('zones.zone', 'asc')
            // ->get();
                $city = "";

        $responseZones = $this->fetchCityData();
         $zones     = $responseZones['data'] ?? [];

       
        return view('client.searchkeyword', compact(
            'city', 'slug', 'keyword', 'area','zones',
            'childSlug', 'childCat',
            'ratingCount', 'ratingValue', 'bgImage',
            'topDescription', 'bottomDescription',
            'faqs', 'kwData',
            'businesses', 'businessChunks',
            'agents', 'reviews', 'categories',
            'relatedCategory', 'servicesRelated',
            'quickBusinesses','growthBusiness'
        ) + [
            'metaTitle'       => $kwData['meta_title'] ?? "{$keyword} ",
            'metaDescription' => $kwData['meta_description'] ?? '',
            'metaKeywords'    => $kwData['meta_keywords'] ?? '',
        ]);
    }





}
