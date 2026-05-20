<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Client\Client; //model
use App\Models\Client\Comment; //model
use App\Models\Client\AssignedKWDS; //model

use App\Models\Citieslists; //model
use DB;
use Session;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Cache;
class ClientDetailController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(string $slug)
	{
 
	 $cacheKey = 'business_detail_' . md5($slug);
 
        $response = Cache::remember($cacheKey, 3600, function () use ($slug) {
            try {
                $res = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/business-details', [
                        'business_slug' => $slug,
                    ]);
                return $res->successful() ? $res->json() : null;
            } catch (\Exception $e) {
                \Log::error('BusinessDetail API: ' . $e->getMessage());
                return null;
            }
        });
 
        if (!$response) abort(410);
 
        $data        = $response['data']         ?? [];
        $clientsList = $data['clientsList']       ?? [];
      
        $certificate = $data['certificate']       ?? [];
        $recentActivity = $data['recentActivity']       ?? [];
 
        $comment     = $data['comment']           ?? [];
        $areaBusiness    = $data['area_business']     ?? [];
        $overviewBusiness= $data['overview_business'] ?? [];
        $relatedSearches = $data['related_searches']  ?? [];
 
        // Keyword list for enquiry form (cached separately)
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
            'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=700&h=500&fit=crop',
        ];
        $vImages = array_slice($gallery, (int) ceil(count($gallery) / 2)) ?: [
            'https://images.unsplash.com/photo-1464207687429-7505649dae38?w=700&h=500&fit=crop',
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
        if($certificate["award_name1"] ){
        for ($i = 1; $i <= 10; $i++) {
            $name = $certificate["award_name{$i}"] ?? null;
            $img  = $certificate["award_img{$i}"]  ?? null;
            if ($name || $img) {
                $certifications[] = ['name' => $name, 'img' => $img, 'index' => $i];
            }
        }
        }



             // Certifications (up to 10)
        $recentActivitys = [];
       
        for ($i = 1; $i <= 6; $i++) {
            $name = $recentActivity["recent_name{$i}"] ?? null;
            $img  = $recentActivity["recent_img{$i}"]  ?? null;
            $paragraph   = $recentActivity["recent_paragraph{$i}"]  ?? null;
            if ($name || $img) {
                $recentActivitys[] = ['name' => $name, 'img' => $img,'paragraph'=>$paragraph, 'index' => $i];
            }
        }
        
        
        $defaultImg = "";  
        $recentActivitys = [];

        for ($i = 1; $i <= 6; $i++) {
            $name      = $recentActivity["recent_name{$i}"]      ?? null;
            $img       = $recentActivity["recent_img{$i}"]       ?? null;
            $paragraph = $recentActivity["recent_paragraph{$i}"] ?? null;
        
            if ($img) {
                $recentActivitys[] = [
                    'name'      => $name,
                    'img'       => $img,
                    'paragraph' => $paragraph,
                    'index'     => $i,
                ];
            }
        }
 

        $govDocs = [];
        if($certificate['cin_no']){
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
        }

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

        $areaBusiness    = $data['area_business']     ?? [];
        $overviewBusiness= $data['overview_business'] ?? [];
        $relatedSearches = $data['related_searches']  ?? [];
 

 
        $metaTitle = $clientsList['business_name'] .'|'. $clientsList['city']. '| '.'QuickDials';
        $metaKeywords =$clientsList['business_name'] .'| '.'QuickDials';

        $relatedSearches = $data['related_searches'] ?? []; 
        $services = array_values(array_slice($relatedSearches, 0, 4)); 
        $serviceText = implode(', ', $services);
        $metaDescription = $clientsList['business_name'] . ' in ' . $clientsList['city'] .
            ' - ' . $serviceText .
            '. View address, photos, reviews and contact details on QuickDials.';

 
        return view('client.client-detail', compact(
            'slug', 'response', 'clientsList', 'certificate','metaTitle','metaKeywords','metaDescription',
            'comment', 'areaBusiness', 'overviewBusiness',
            'relatedList', 'keywordList', 'gallery', 'hImages', 'vImages',
            'assignKeyword', 'certifications', 'govDocs', 'reviews',
            'gradients', 'bgColors', 'iconColors', 'planOptions',
            'googleMapUrl', 'mapSrc', 'yearsExp', 'yearEst','recentActivitys',
            'todayDay', 'hours','linearGradients'
        ));
	
	 

	}


    
     /**
     * Handle  GET /{city}/{slug}
     */
    public function businessDetails(Request $request)
    {
               
   
        $response = $this->getBusinessList();

        $data = $response['data'] ?? [];
        // ── Keyword / meta ─────────────────────────────────────────────────
      
        // ── Businesses ─────────────────────────────────────────────────────
        $rawList    = $data['agents'] ?? [];
      
        $businesses = collect($rawList)
            ->map(fn ($b, $i) => $this->normalizeBusiness($b, $i))
            ->all();
 
  $businessOwners = $this->businessOwnersData();

        $growthBusiness = $businessOwners['data']['businessOwners'] ?? [];
        
        // ── Chunk businesses for ad insertion every 5 ─────────────────────
        $businessChunks = array_chunk($businesses, 5);

        
 
         
                $city = "";

        $responseZones = $this->fetchCityData();
        $zones     = $responseZones['data'] ?? [];

        

         return view('client.business-details', compact(
            'city', 'zones','growthBusiness',
         
            'businesses', 'businessChunks',
            
        ) + [
            'metaTitle'       => "QuickDials - India’s Trusted Local Business Search Engine.",
            'metaDescription' => "QuickDials is India’s leading local business search engine to discover top-rated IT training institutes, hotels, salons, healthcare services, real estate, travel agencies, schools, colleges, and more near you. Find verified business listings, addresses, phone numbers, reviews, ratings, photos, and maps across India.",
            'metaKeywords'    => "QuickDials, local business directory India, business listing website, IT training institutes near me, coaching centres near me, hotels near me, salons near me, healthcare services, real estate services, travel agencies, schools and colleges near me, certified institutes, education consultants, online business directory, local search engine India, top businesses near me, business reviews and ratings.",
        ]);
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
    private function getBusinessList(): ?array
    {
        try {
                $res = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/get-business-list');
                return $res->successful() ? $res->json() : null;
            } catch (\Exception $e) {
                \Log::error('BusinessOwners API: ' . $e->getMessage());
                return null;
            }
              
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
            'openUntil'     => $b['openUntil'] ?? $b['open_until'] ?? '8:00 PM',
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


}
