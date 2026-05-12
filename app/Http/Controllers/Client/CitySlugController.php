<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use DB;
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
 
        // ── Validate city ──────────────────────────────────────────────────
        if (!$this->cityExists($city)) {
            abort(410);
        }

        // ── Fetch data ─────────────────────────────────────────────────────
        $response = $this->fetchData($city, $slug);
        $businessOwners = $this->businessOwnersData();

        $growthBusiness = $businessOwners['data']['businessOwners'] ?? [];
       
          
        $data     = $response['data'] ?? [];
    
        $kwData   = $data['keyword'] ?? [];
 
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
        for ($i = 1; $i <= 6; $i++) {
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


            // dd($agents);
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
 
        return view('client.searchlist ', compact(
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
            'metaTitle'       => $kwData['meta_title'] ?? "{$keyword} in " . ucfirst($city),
            'metaDescription' => $kwData['meta_description'] ?? '',
            'metaKeywords'    => $kwData['meta_keywords'] ?? '',
        ]);
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
// dd($ratingCount);
        // ── FAQs ───────────────────────────────────────────────────────────
        $faqs = [];
        for ($i = 1; $i <= 6; $i++) {
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


            // dd($businesses);
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

       
        return view('client.searchkeyword ', compact(
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
