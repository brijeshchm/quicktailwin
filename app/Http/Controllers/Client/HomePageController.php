<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddLeadRequest;
use DB;
use Mail;
use Artisan;
use Validator;
//model
use App\Models\Keyword;

use App\Models\Citieslists;
use App\Models\Lead;
use App\Models\ChildCategory;
use App\Models\ParentCategory;
use App\Models\ClientCategory;
use App\Models\Client\Client;
use App\AssignedClientCategory;
use App\Models\Blogdetails;
use App\Models\Testimonialsdetail;
use App\Models\LeadFollowUp;
use App\Models\Status;
use App\Models\Zone;
use App\Models\Contacts;
use App\Models\Client\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

 
use Illuminate\Support\Facades\Cache;


// use Illuminate\Support\Facades\Cache;
class HomePageController extends Controller
{
	/*
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
    {
        $weddingPlanning    = $this->getWeddingPlanning();
        $repairsServices    = $this->getRepairsServices();
        $homePage           = $this->getHomePage();
        $bannerKeyword      = $this->getBannerKeyword();
        $featuredBusinesses = $this->getFeaturedBusinesses();
        $businessOwners     = $this->getBusinessOwners();
        $popularSearches    = $this->getPopularSearches();
        $trending           = $this->getTrending();
        $blogPageList       = $this->getBlogList();

  		$clients = Client::get()->count();
        $keywordCount = Keyword::get()->count();
        $childCategory = ChildCategory::get()->count();
        $citieslists = Citieslists::get()->count();


		$city= "faridabad";
		$metaTitle ="QuickDials | India’s Leading Local Business Search Directory";
		$metaDescription  ="QuickDials is India’s trusted local business search and service directory, helping users find verified businesses, services, and professionals near them"; 
		$keyword = "";
        return view('client.index', compact(
            'blogPageList',
            'trending',
            'popularSearches',
            'businessOwners',
            'featuredBusinesses',
            'bannerKeyword',
            'homePage',
            'repairsServices','childCategory',
            'weddingPlanning','city','citieslists','keywordCount','clients',
			'metaTitle','metaDescription','keyword'
        ));
    }
 
    /*
     * Static "wedding planning" keyword tiles.
     */
    private function getWeddingPlanning(): array
    {
       $base = config('app.website') . 'popular/';
  
        return [
            ['url' => 'catering-services', 'img' => $base . 'Catering-Services.webp', 'alt' => 'Catering Services', 'title' => 'Catering Services', 'type' => 'keyword'],
            ['url' => 'banquet-hall', 'img' => $base . 'Banquet-Halls.webp', 'alt' => 'Banquet Halls', 'title' => 'Banquet Halls', 'type' => 'keyword'],
            ['url' => 'stage-decorators', 'img' => $base . 'Stage-Decorators.webp', 'alt' => 'Stage Decorators', 'title' => 'Stage Decorators', 'type' => 'keyword'],
            ['url' => 'makeup-artists', 'img' => $base . 'makeup-artists.jpg', 'alt' => 'Indian Makeup Artists', 'title' => 'Makeup Artists', 'type' => 'keyword'],
            ['url' => 'mehendi-artists', 'img' => $base . 'Mehendi-Artists.jpg', 'alt' => 'Indian Mehendi Artists', 'title' => 'Mehendi Artists', 'type' => 'keyword'],
            ['url' => 'bridal-wear', 'img' => $base . 'Bridal-Wear.jpg', 'alt' => 'Indian Bridal Wear', 'title' => 'Indian Bridal Wear', 'type' => 'keyword'],
        ];
    }
 
    /**
     * Static "repairs" keyword tiles with rating/count.
     */
    private function getRepairsServices(): array
    {
       
		$base = config('app.website') . 'popular/';
	 
 
        return [
            ['url' => 'ac-repair-service', 'img' => $base . 'AC-Service.jpg', 'alt' => 'AC Service', 'title' => 'AC Service', 'type' => 'keyword', 'rating' => '4.8', 'count' => '397'],
            ['url' => 'car-service', 'img' => $base . 'car-services.jpg', 'alt' => 'Car Services', 'title' => 'Car Services', 'type' => 'keyword', 'rating' => '4.5', 'count' => '359'],
            ['url' => 'laundry-service', 'img' => $base . 'washing-machines.jpg', 'alt' => 'Laundry Services', 'title' => 'Laundry Services', 'type' => 'keyword', 'rating' => '3.5', 'count' => '199'],
            ['url' => 'electricity-service', 'img' => $base . 'Electricity-Services.jpg', 'alt' => 'Electrician Services', 'title' => 'Electrician Services', 'type' => 'keyword', 'rating' => '4.8', 'count' => '475'],
            ['url' => 'hotels', 'img' => $base . 'Hotel-Services.jpg', 'alt' => 'Hotels', 'title' => 'Hotels', 'type' => 'keyword', 'rating' => '4.8', 'count' => '475'],
            ['url' => 'health-wellness', 'img' => $base . 'Fitness-Services.jpg', 'alt' => 'Health & Fitness', 'title' => 'Health & Fitness', 'type' => 'keyword', 'rating' => '4', 'count' => '374'],
            ['url' => 'electrician', 'img' => $base . 'Electricity-Services.jpg', 'alt' => 'Electrician', 'title' => 'Electrician', 'type' => 'keyword', 'rating' => '4.8', 'count' => '375'],
            ['url' => 'plumber', 'img' => $base . 'Plumber.jpg', 'alt' => 'Plumber', 'title' => 'Plumber', 'type' => 'keyword', 'rating' => '4.8', 'count' => '90'],
            ['url' => 'carpenters', 'img' => $base . 'carpenter.jpg', 'alt' => 'Carpenters', 'title' => 'Carpenters', 'type' => 'keyword', 'rating' => '4.8', 'count' => '463'],
            ['url' => 'washing-machine-repairs', 'img' => $base . 'washing-machines.jpg', 'alt' => 'Washing machine repairs', 'title' => 'Washing machine repairs', 'type' => 'keyword', 'rating' => '4.8', 'count' => '463'],
            ['url' => 'cctv-installation-training', 'img' => config('app.website') . 'img/CCTV-security.webp', 'alt' => 'CCTV Installation', 'title' => 'CCTV installation', 'type' => 'keyword', 'rating' => '4.8', 'count' => '463'],
        ];
    }
 
    /**
     * Static homepage category/child tiles.
     */
    private function getHomePage(): array
    {
         

		$img     = config('app.website') . 'img/';
		$popular = config('app.website') . 'popular/';
		$images  = config('app.website') . 'images/';
 
        return [

			 ['url' => 'artificial-intelligence-training', 'img' => $img . 'artificial-intelligence.webp', 'alt' => 'Artificial Intelligence Training', 'title' => 'Artificial Intelligence Training', 'type' => 'keyword', 'rating' => '4', 'count' => '434'],
			 ['url' => 'python-training', 'img' => $img . 'it_training.svg', 'alt' => '', 'title' => 'Python Training', 'type' => 'keyword', 'rating' => '4.75', 'count' => '789'],
			 ['url' => 'workday-training', 'img' => $img . 'it_training.svg', 'alt' => 'Workday Training', 'title' => 'Workday Training', 'type' => 'keyword', 'rating' => '4.75', 'count' => '539'],
			 ['url' => 'sap-training', 'img' => $img . 'it_training.svg', 'alt' => 'SAP Training', 'title' => 'SAP Training', 'type' => 'keyword', 'rating' => '4.75', 'count' => '678'],
			 ['url' => 'banquet-hall', 'img' => $popular . 'Banquet-Halls.webp', 'alt' => 'Banquet Hall', 'title' => 'Banquet Hall', 'type' => 'keyword', 'rating' => '4.5', 'count' => '778'],
	 		['url' => 'cricket-academy', 'img' => $popular . 'sports.png', 'alt' => 'Cricket academy', 'title' => 'Cricket Academy', 'type' => 'categories', 'rating' => '4.75', 'count' => '480'],
	 		['url' => 'data-science-training', 'img' => $img . 'data-science.webp', 'alt' => 'Data Science', 'title' => 'Data Science', 'type' => 'categories', 'rating' => '4.75', 'count' => '480'],
	 		['url' => 'judo-karate', 'img' => $img . 'judo-karate.webp', 'alt' => 'Judo Karate', 'title' => 'Judo Karate', 'type' => 'categories', 'rating' => '4.75', 'count' => '480'],
	 		['url' => 'distance-education', 'img' => $popular . 'Education.png', 'alt' => 'Distance Education', 'title' => 'Distance Education', 'type' => 'categories', 'rating' => '4.75', 'count' => '480'],
	 		['url' => 'data-analytics-training', 'img' => $img . 'data-analytics.webp', 'alt' => 'Data Analytics', 'title' => 'Data Analytics', 'type' => 'categories', 'rating' => '4.75', 'count' => '480'],
	 		['url' => 'salesforce-training', 'img' => $img . 'it_training.svg', 'alt' => 'Salesforce Training', 'title' => 'Salesforce Training', 'type' => 'categories', 'rating' => '4.75', 'count' => '480'],
	 		['url' => 'wedding-organisers', 'img' => $img . 'wedding.png', 'alt' => 'Wedding Organisers', 'title' => 'Wedding Organisers', 'type' => 'categories', 'rating' => '4.45', 'count' => '380'],



          //  ['url' => 'professional-courses', 'img' => $img . 'it_training.svg', 'alt' => 'IT Professional Courses', 'title' => 'Professional Courses', 'type' => 'categories', 'rating' => '4', 'count' => '434'],
            // ['url' => 'wedding-planning', 'img' => $img . 'wedding.png', 'alt' => 'Wedding pannel', 'title' => 'Wedding pannel', 'type' => 'keyword', 'rating' => '4', 'count' => '234'],
            // ['url' => 'electric-services', 'img' => $img . 'electric-services.webp', 'alt' => 'Electric Services', 'title' => 'Electric Services', 'type' => 'child', 'rating' => '3.5', 'count' => '377'],
            // ['url' => 'entrance-exams-coaching', 'img' => $popular . 'government-exam.png', 'alt' => 'Government exam coaching', 'title' => 'Government exam', 'type' => 'child', 'rating' => '3.5', 'count' => '229'],
            // ['url' => 'study-abroad', 'img' => $img . 'study-abroad.svg', 'alt' => 'Study Abroad', 'title' => 'Study Abroad', 'type' => 'child', 'rating' => '5', 'count' => '399'],
            // ['url' => 'spa-hub', 'img' => $img . 'Spa & Beauty.png', 'alt' => 'Spa & Beauty', 'title' => 'Spa & Beauty', 'type' => 'keyword', 'rating' => '5', 'count' => '325'],
            // ['url' => 'repair-services', 'img' => $img . 'Repairs-Services.svg', 'alt' => 'Repair Services', 'title' => 'Repair Services', 'type' => 'child', 'rating' => '5', 'count' => '389'],
            // ['url' => 'packers-and-movers', 'img' => $popular . 'Packers-movers.png', 'alt' => 'Packers & Movers', 'title' => 'Packers & Movers', 'type' => 'child', 'rating' => '3.5', 'count' => '199'],
            // ['url' => 'professional', 'img' => $popular . 'Professional.png', 'alt' => 'Professional Course', 'title' => 'Professional', 'type' => 'categories', 'rating' => '3.5', 'count' => '149'],
            // ['url' => 'contractors', 'img' => $img . 'contractors.png', 'alt' => 'Contractors Property', 'title' => 'Contractors', 'type' => 'child', 'rating' => '3.5', 'count' => '167'],
            // ['url' => 'collages-and-institutions', 'img' => $popular . 'Education.png', 'alt' => 'collages and Institutions', 'title' => 'Education', 'type' => 'categories', 'rating' => '3.5', 'count' => '197'],
            // ['url' => 'rent-or-buy', 'img' => $img . 'rent_buy.svg', 'alt' => 'Rent or Buy', 'title' => 'Rent & Buy', 'type' => 'child', 'rating' => '3.5', 'count' => '329'],
            // ['url' => 'sports-academy', 'img' => $popular . 'sports.png', 'alt' => 'Sport Academy', 'title' => 'Sport Academy', 'type' => 'child', 'rating' => '3.5', 'count' => '539'],
            // ['url' => 'medical', 'img' => $img . 'Medical.webp', 'alt' => 'Medical Medician', 'title' => 'Medical', 'type' => 'child', 'rating' => '3.5', 'count' => '269'],
            // ['url' => 'loan-service', 'img' => $popular . 'Loan.png', 'alt' => 'Loan Service', 'title' => 'Loan', 'type' => 'child', 'rating' => '3.5', 'count' => '69'],
            // ['url' => 'dance-classes', 'img' => $popular . 'Dancing.png', 'alt' => 'Dancing Class', 'title' => 'Dancing', 'type' => 'child', 'rating' => '3.5', 'count' => '79'],
            // ['url' => 'yoga-classes', 'img' => $popular . 'Yoga.png', 'alt' => 'Yoga Class', 'title' => 'Yoga', 'type' => 'child', 'rating' => '3.5', 'count' => '89'],
            // ['url' => 'security-system', 'img' => $img . 'CCTV-security.webp', 'alt' => 'CCTV Security', 'title' => 'CCTV Security', 'type' => 'child', 'rating' => '3.5', 'count' => '109'],
            // ['url' => 'tours-and-travels', 'img' => $images . 'tour-travels.png', 'alt' => 'Tours & Travels', 'title' => 'Tours & Travels', 'type' => 'keyword', 'rating' => '3.5', 'count' => '49'],
        ];
    }
 
    /**
     * Static homepage banner tiles (webp variants).
     */
    private function getBannerKeyword(): array
    {
		$img     = config('app.website') . 'img/';
		$popular = config('app.website') . 'popular/';
		$images  = config('app.website') . 'images/';
 
        return [
            ['url' => 'repair-services', 'img' => $img . 'Repairs-Services.webp', 'alt' => 'Repair Services', 'title' => 'Repair Services', 'type' => 'child', 'rating' => '5', 'count' => '389'],
            ['url' => 'rent-or-buy', 'img' => $img . 'Rent-buy.webp', 'alt' => 'Rent Or Buy', 'title' => 'Rent & Buy', 'type' => 'child', 'rating' => '3.5', 'count' => '329'],
            ['url' => 'packers-and-movers', 'img' => $img . 'Packers-movers.webp', 'alt' => 'Packers & Movers', 'title' => 'Packers & Movers', 'type' => 'child', 'rating' => '3.5', 'count' => '199'],
            ['url' => 'tours-and-travels', 'img' => $images . 'tour-travels.webp', 'alt' => 'Tours & Travels', 'title' => 'Tours & Travels', 'type' => 'keyword', 'rating' => '3.5', 'count' => '49'],
           
            ['url' => 'doctor', 'img' => $img . 'Doctor.webp', 'alt' => 'Doctor Clinic', 'title' => 'Doctor', 'type' => 'keyword', 'rating' => '4', 'count' => '234'],
            ['url' => 'electric-services', 'img' => $img . 'electric-services.webp', 'alt' => 'Electric Services', 'title' => 'Electric Services', 'type' => 'child', 'rating' => '3.5', 'count' => '377'],
            ['url' => 'entrance-exams-coaching', 'img' => $img . 'government-exam.webp', 'alt' => 'Government exam', 'title' => 'Government exam', 'type' => 'child', 'rating' => '3.5', 'count' => '229'],
            ['url' => 'study-abroad', 'img' => $img . 'study-abroad.svg', 'alt' => 'Study Abroad', 'title' => 'Study Abroad', 'type' => 'child', 'rating' => '5', 'count' => '399'],
            ['url' => 'spa-and-beauty', 'img' => $img . 'Spa-Beauty.webp', 'alt' => 'Spa & Beauty', 'title' => 'Spa & Beauty', 'type' => 'child', 'rating' => '5', 'count' => '325'],
           
            ['url' => 'contractors', 'img' => $img . 'contractors.webp', 'alt' => 'Contractors Builder', 'title' => 'Contractors', 'type' => 'child', 'rating' => '3.5', 'count' => '167'],
            ['url' => 'collages-and-institutions', 'img' => $img . 'Education.webp', 'alt' => 'Education collages', 'title' => 'Education', 'type' => 'categories', 'rating' => '3.5', 'count' => '197'],
            ['url' => 'sports-academy', 'img' => $img . 'sports.webp', 'alt' => 'Sport Academy', 'title' => 'Sport Academy', 'type' => 'child', 'rating' => '3.5', 'count' => '539'],
            ['url' => 'medical', 'img' => $img . 'Medical.webp', 'alt' => 'Medical', 'title' => 'Medical', 'type' => 'child', 'rating' => '3.5', 'count' => '269'],
            ['url' => 'loan-service', 'img' => $img . 'Loan.webp', 'alt' => 'Loan Service', 'title' => 'Loan', 'type' => 'child', 'rating' => '3.5', 'count' => '69'],
            ['url' => 'dance-classes', 'img' => $img . 'Dancing.webp', 'alt' => 'Dancing Class performance', 'title' => 'Dancing', 'type' => 'child', 'rating' => '3.5', 'count' => '79'],
            ['url' => 'yoga-classes', 'img' => $img . 'Yoga.webp', 'alt' => 'Yoga', 'title' => 'Yoga', 'type' => 'child', 'rating' => '3.5', 'count' => '89'],
            ['url' => 'security-system', 'img' => $img . 'CCTV-security.webp', 'alt' => 'CCTV Security', 'title' => 'CCTV Security', 'type' => 'child', 'rating' => '3.5', 'count' => '109'],
            ['url' => 'web-technologies', 'img' => $images . 'Web-Designers.webp', 'alt' => 'Web Designers', 'title' => 'Web Designers', 'type' => 'child', 'rating' => '3.5', 'count' => '106'],
        ];
    }
 
    /**
     * Top 8 featured clients (platinum > diamond > gold > silver > rest),
     * with logo, gallery, rating, and assigned keywords resolved.
     *
     * NOTE: keyword lookup is batched in a single query to avoid N+1
     * (previously one query per client inside the map() callback).
     */
    private function getFeaturedBusinesses()
    {
        $clientsList = DB::table('clients')
            ->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
            ->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
            ->leftJoin(DB::raw('(
                SELECT
                    comment_client_ID,
                    SUM(rating) AS rating,
                    COUNT(comment_ID) AS comment_count
                FROM comments
                GROUP BY comment_client_ID
            ) c'), 'c.comment_client_ID', '=', 'clients.id')
            ->select(
                'clients.*',
                'clients.id as client_id',
                'clients.business_slug',
                'clients.client_type',
                DB::raw('MAX(c.rating) as rating'),
                DB::raw('MAX(c.comment_count) as comment_count')
            )
            ->where('clients.active_status', '1')
            ->where('logo', '!=', '')
            ->whereNotNull('logo')
            ->where('pictures', '!=', '')
            ->where('business_slug', '!=', '')
            ->whereNotNull('pictures')
            ->groupBy('clients.id')
            ->orderByRaw("
                CASE MAX(clients.client_type)
                    WHEN 'platinum' THEN 1
                    WHEN 'diamond' THEN 2
                    WHEN 'gold' THEN 3
                    WHEN 'silver' THEN 4
                    ELSE 5
                END
            ")
            ->limit(8)
            ->get();
 
        $clientIds = $clientsList->pluck('client_id');
 
        // Single batched query instead of one query per client.
        $keywordsByClient = [];

	 if ($clientIds->isNotEmpty()) {
    $keywordsByClient = DB::table('assigned_kwds')
        ->join('keyword', 'keyword.id', '=', 'assigned_kwds.kw_id')
        ->join(
            'child_category',
            'child_category.id',
            '=',
            'assigned_kwds.child_cat_id'
        )
        ->select(
            'assigned_kwds.client_id',
            'keyword.keyword',
            'child_category.child_category as child_category_name'
        )
        ->whereIn('assigned_kwds.client_id', $clientIds)
        ->orderBy('assigned_kwds.id', 'desc')
        ->get()
        ->groupBy('client_id')
        ->map(function ($group) {
            return $group->take(3)->values()->toArray();
        })
        ->toArray();
}
		
 

        $certifiedImg = config('app.website') . 'img/q_verified.gif';
        $trustedImg   = config('app.website') . 'img/q_trust.gif';
        $gstImg       = config('app.website') . 'img/q_gst.gif';
 
        return $clientsList->map(function ($client) use ($keywordsByClient, $certifiedImg, $trustedImg, $gstImg) {
 
            $logoImage = 'client/images/default_pp_small.png';
            $altLogo   = 'Business Logo';
 
            if (!empty($client->logo)) {
                $cicons = @unserialize($client->logo);
                if (is_array($cicons) && !empty($cicons['large']['src'])) {
                    $logoImage = config('app.website') . $cicons['large']['src'];
                    $altLogo   = $cicons['large']['alt'] ?? $altLogo;
                }
            }
 
            $galleryArray = [];
            if (!empty($client->pictures)) {
                $galleryList = @unserialize($client->pictures);
                if (is_array($galleryList)) {
                    foreach ($galleryList as $value) {
                        $galleryArray[] = ['galley' => $value];
                    }
                }
            }
 
            $avgRating = '0';
            if ($client->rating && $client->comment_count) {
                $avgRating = number_format($client->rating / $client->comment_count, 1, '.', '');
            }
 
            return [
                'business_id'       => $client->client_id,
                'business_name'     => $client->business_name,
                'business_slug'     => $client->business_slug,
                'logo'              => $logoImage,
                'altLogo'           => $altLogo,
                'gallery'           => $galleryArray,
                'certifications'    => $client->certifications,
                'sirName'           => $client->sirName,
                'first_name'        => $client->first_name,
                'middle_name'       => $client->middle_name,
                'last_name'         => $client->last_name,
                'certified_status'  => $client->certified_status,
                'trusted_status'    => $client->trusted_status,
                'gst_status'        => $client->gst_status,
                'certified_img'     => $certifiedImg,
                'trusted_img'       => $trustedImg,
                'gst_img'           => $gstImg,
                'website'           => $client->website,
                'verified'          => $client->verified,
                'trending'          => $client->trending,
                'topSearch'         => $client->topSearch,
                'featured'          => $client->featured,
                'description'       => $client->description,
                'city'              => $client->city,
                'state'             => $client->state,
                'area'              => $client->area,
                'zone'              => $client->zone,
                'address'           => $client->address,
                'pincode'           => $client->pincode,
                'country'           => $client->country,
                'year_of_estb'      => $client->year_of_estb,
                'landmark'          => $client->landmark,
                'mapUrl'            => 'https://maps.google.com/?q=' . generate_slug($client->address),
                'whatsapp'          => '7559435943',
                'call'              => '917559435943',
                'rating'            => $client->rating,
                'openUntil'         => $client->openUntil,
                'avgRating'         => $avgRating,
                'comment_count'     => $client->comment_count,
               	'keywords' => $keywordsByClient[$client->client_id] ?? [],
            ];
        });
    }
 
    /**
     * Aggregate platform stats shown in the "trusted by" / stats strip.
     */
    private function getBusinessOwners(): array
    {
        return [
            'GrowClient'        => Client::count() . ' +',
            'Suppliers'         => ChildCategory::count() . ' +',
            'ProductsServices'  => Citieslists::count() . ' K+',
            'Keyword'           => Keyword::count() . ' +',
            'Store'             => ParentCategory::count() . ' +',
            'Platform'          => ParentCategory::count() . ' K+',
        ];
    }
 
    /**
     * Static "popular searches" tiles.
     */
    private function getPopularSearches(): array
    {
        $popular = config('app.website') . 'popular/';
 
        return [
            ['url' => 'computer-courses', 'img' => $popular . 'IT-Training.webp', 'alt' => 'computer courses', 'title' => 'computer courses', 'type' => 'categories', 'rating' => '3.5', 'count' => '139'],
            ['url' => 'entrance-exams-coaching', 'img' => $popular . 'Entrance-Exam.jpg', 'alt' => 'Entrance exam', 'title' => 'Entrance exam', 'type' => 'child', 'rating' => '3.5', 'count' => '99'],
            ['url' => 'packers-and-movers', 'img' => $popular . 'Packers-Movers.jpg', 'alt' => 'Packers & Movers', 'title' => 'Packers & Movers', 'type' => 'child', 'rating' => '3.5', 'count' => '132'],
            ['url' => 'interior-designer', 'img' => $popular . 'Interior-design.jpg', 'alt' => 'Interior Design', 'title' => 'Interior Design', 'type' => 'keyword', 'rating' => '3.5', 'count' => '192'],
            ['url' => 'real-estate', 'img' => $popular . 'real-estate-agent.jpg', 'alt' => 'Real Estate Agents', 'title' => 'Real Estate Agents', 'type' => 'child', 'rating' => '3.5', 'count' => '239'],
            ['url' => 'carpenters', 'img' => $popular . 'carpenter.jpg', 'alt' => 'Carpenters', 'title' => 'Carpenters', 'type' => 'keyword', 'rating' => '3.5', 'count' => '123'],
           
        ];
    }
 
    /**
     * Static "trending" list (no images, just text tiles).
     */
    private function getTrending(): array
    {
        return [
            ['url' => 'artificial-intelligence-training', 'title' => 'Artificial Intelligence', 'type' => 'keyword', 'rating' => '3.5', 'count' => '199'],
            ['url' => 'banquet-hall', 'title' => 'Wedding Planning', 'type' => 'keyword', 'rating' => '3.5', 'count' => '778'],
            ['url' => 'sap-training', 'title' => 'SAP Training', 'type' => 'keyword', 'rating' => '4', 'count' => '374'],
            ['url' => 'cricket-academy', 'title' => 'Cricket Academy', 'type' => 'keyword', 'rating' => '4.75', 'count' => '475'],
            ['url' => 'python-training', 'title' => 'Python Training', 'type' => 'keyword', 'rating' => '4.75', 'count' => '463'],
        ];
    }
 
    /*
     * Latest 3 published blog posts, formatted for the homepage blog widget.
     */
    private function getBlogList(): array
    {
        $blogPageList = [];
 
        $blogDetails = Blogdetails::where('status', '1')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();
 
        foreach ($blogDetails as $key => $blog) {
            $image = '';
            $alt   = '';
 
            if (!empty($blog->image)) {
                $imageData = @unserialize($blog->image);
                if (is_array($imageData) && !empty($imageData['large']['src'])) {
                    $image = config('app.website') . $imageData['large']['src'];
                    $alt   = $blog->name;
                }
            }
 
            $description = strip_tags($blog->description ?? '');
            $description = Str::limit($description, 220, '...');
 
            $blogPageList[$key] = [
                'url'         => $blog->slug,
                'img'         => $image,
                'alt'         => $alt,
                'title'       => $blog->name,
                'description' => ucfirst($description),
            ];
        }
 
        return $blogPageList;
    }

	public function saveEnquiry(Request $request)
	{
		if ($request->ajax()) {
			$validator = Validator::make($request->all(), [
				'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'email' => 'required|email|regex:/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i',
				'mobile' => 'required|numeric',
				'kw_text' => 'required',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();

				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}
			$lead = new Lead;
			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			$lead->email = $request->input('email');

			$lead->lead_form = $request->input('lead_form');
			$lead->from_page = filter_var($request->input('from_page'), FILTER_SANITIZE_STRING);
			$citySlug = $request->input('city_id');
			$cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : null;

			if (!empty($request->location)) {

				$zone = Zone::find($request->location);

				if ($zone) {
					$lead->zone_id = $zone->id;
					$lead->zone = $zone->zone;

					$city = Citieslists::find($zone->city_id);
					if ($city) {
						$lead->city_id = $city->id;
						$lead->city_name = $city->city;
					}
				}

			} else {

				$city = $cityName
					? Citieslists::where('city', $cityName)->first()
					: null;

				if ($city) {
					$lead->city_id = $city->id;
					$lead->city_name = $city->city;
				} else {
					// fallback
					$lead->city_name = $cityName ?: 'none';
				}
			}


			if ($request->has('b_end')) {
				$lead->b_end = $request->input('b_end');
			}

			$mobile = ltrim($request->input('mobile'), '0');
			$mobile = trim($mobile);
			$newmobile = preg_replace('/\s+/', '', $mobile);
			$lead->mobile = $newmobile;
			$keyword = Keyword::where('keyword', $request->input('kw_text'))->first();

			if (!empty($keyword)) {
				$lead->kw_id = $keyword->id;
				$lead->kw_text = $keyword->keyword;

			} else {
				$lead->kw_id = 0;
				$lead->kw_text = $request->input('kw_text');
			}


			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;
			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
			$lead->created_by = 101;

			$checklead = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->where('city_name', $cityName)->get()->count();
			if ($checklead > 0) {
				$currentdate = date('Y-m-d');
				$lastDate = date('', strtotime($currentdate . '- 4 day'));
				$checkday = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->whereDate('created_at', '>', date_format(date_create($lastDate), 'Y-m-d'))->get()->count();

				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
					//	$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);
				}


			} else {
				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
					//	$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);

				}
			}


		}

	}


	public function saveEnquiryWithoutZone(Request $request)
	{
 
			$validator = Validator::make($request->all(), [
				'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'email' => 'required|regex:/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i',
				'phone' => 'required|numeric',
				//	'phone' 	=> 'required|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im',				
				'kw_text' => 'required',
				 
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();

				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$lead = new Lead;
			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			$lead->email = $request->input('email');
			$lead->lead_form = $request->input('lead_form');
			$lead->plan = $request->input('whenToStart');
			$lead->age = $request->input('age');
			$lead->from_page = filter_var($request->input('from_page'), FILTER_SANITIZE_STRING);

			$citySlug = $request->input('city_id');
			$cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : null;

			if (!empty($request->location_id)) {

				$zone = Zone::find($request->location_id);

				if ($zone) {
					$lead->zone_id = $zone->id;
					$lead->zone = $zone->zone;

					$city = Citieslists::find($zone->city_id);
					if ($city) {
						$lead->city_id = $city->id;
						$lead->city_name = $city->city;
					}
				}

			} else {

				$city = $cityName
					? Citieslists::where('city', $cityName)->first()
					: null;

				if ($city) {
					$lead->city_id = $city->id;
					$lead->city_name = $city->city;
				} else {
					// fallback
					$lead->city_name = $cityName ?: 'none';
				}
			}


			 

			if ($request->frmcheck) {
				$lead->frmcheck = json_encode($request->frmcheck);
			}
			if ($request->location) {
				$lead->area = $request->location;
			}
			if ($request->appointment) {


				$lead->appointment = $request->appointment;
			}
			$phone = ltrim($request->input('phone'), '0');
			$phone = trim($phone);
			$newmobile = preg_replace('/\s+/', '', $phone);
			$lead->mobile = $newmobile;
			if ($request->country_code) {
				$lead->code = $request->country_code;
			}
			$kw_text = filter_var($request->input('kw_text'), FILTER_SANITIZE_STRING);
			$kw_text = preg_replace('/[^A-Za-z0-9]/', ' ', $kw_text);
			$kw_text = preg_replace('/\s+/', ' ', str_replace('&', '', trim($kw_text)));
			$keyword = Keyword::where('keyword', $kw_text)->first();

			if (!empty($keyword)) {
				$lead->kw_id = $keyword->id;
				$lead->kw_text = $keyword->keyword;
				$course_name = $keyword->keyword;
			} else {
				$lead->kw_id = 0;
				$lead->kw_text = $request->input('kw_text');
				$course_name = $request->input('kw_text');
			}

			$status = Status::where('name', 'New Lead')->first();
			if (!empty($status)) {
				$lead->status_id = $status->id;
				$lead->status_name = $status->name;
			}

			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('comment'))));
			$lead->created_by = 101;
			 

			$today = date('Y-m-d');
			$checklead = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->where('city_name', $cityName)->whereDate('created_at', '=', date_format(date_create($today), 'Y-m-d'))->get()->count();

			$currentdate = date('Y-m-d');
			$lastDate = date('Y-m-d', strtotime($currentdate . '- 4 day'));

			$checkday = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->whereDate('created_at', '>', date_format(date_create($lastDate), 'Y-m-d'))->get()->count();

			if (!empty($checklead) && $checklead > 0) {
				return response()->json([
					'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					 
				], 200);
			} else if (!empty($checkday) && $checkday > 0) {
				$lead->duplicate = '1';
				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('comment'))));
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					], 200);
				} else {
					return response()->json([
						'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					], 200);

				}
			} else {

				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('comment'))));
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					// leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					], 200);
				} else {
					return response()->json([
						'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					], 200);
				}
			}
		
	}


	 /**
     * Per-step validation rules.
     */
    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            0 => [
                'name'     => ['required', 'string', 'min:2', 'max:100'],
                'email'    => ['required', 'email:rfc', 'max:150'],
                'phone'    => ['required', 'regex:/^[\d]{10,15}$/'],
                
            ],
            1 => [
                'age'         => ['required', 'string', 'max:50'],
                'whenToStart' => ['required', 'string', 'max:50'],
				'location' => ['required', 'string', 'max:100'],
            ],
            2 => [
                'comment' => ['nullable', 'string', 'max:1000'],
            ],
            default => [],
        };
    }

    protected function validationMessages(): array
    {
        return [
            'name.required'        => 'Please enter your name.',
            'email.required'       => 'Email is required.',
            'email.email'          => 'Enter a valid email.',
            'phone.required'       => 'Phone is required.',
            'phone.regex'          => 'Enter a valid 10–15 digit phone number.',
            'location.required'    => 'Please select your city.',
            'age.required'         => 'Select your age range.',
            'whenToStart.required' => 'Select a timeline.',
        ];
    }

    /**
     * Normalize phone: strip spaces, dashes, parentheses, leading +.
     */
    protected function normalizePhone(Request $request): void
    {
        if ($request->filled('phone')) {
            $request->merge([
                'phone' => preg_replace('/\D/', '', $request->phone),
            ]);
        }
    }

    /**
     * AJAX: validate a single step.
     * POST /form/validate-step
     */
    public function validateStep(Request $request)
    {
        $this->normalizePhone($request);

        $step = (int) $request->input('step', 0);

        $validator = Validator::make(
            $request->all(),
            $this->rulesForStep($step),
            $this->validationMessages()
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        return response()->json(['success' => true]);
    }


	 

	public function saveEnquiryContact(Request $request)
	{

		if ($request->ajax()) {

			$validator = Validator::make($request->all(), [
				'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'email' => 'required|regex:/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i',
				'mobile' => 'required|numeric',
				'subject' => 'required',


			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();

				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$lead = new Contacts;
			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			$lead->email = $request->input('email');
			$lead->mobile = $request->input('mobile');
			$lead->subject = filter_var($request->input('subject'), FILTER_SANITIZE_STRING);

			$message = filter_var($request->input('message'), FILTER_SANITIZE_STRING);
			$message = preg_replace('/[^A-Za-z0-9]/', ' ', $message);
			$message = preg_replace('/\s+/', ' ', str_replace('&', '', trim($message)));
			$lead->message = $message;


			if ($lead->save()) {

				return response()->json([
					'statusCode' => true,
					'response' => [
						'responseCode' => 200,
						'payload' => '',
						'message' => 'Form submited successfully'
					]
				], 200);
			} else {
				return response()->json([
					'statusCode' => true,
					'response' => [
						'responseCode' => 200,
						'payload' => '',
						'message' => 'Some Error Follow up'
					]
				], 200);

			}
		}
	}

	public function saveTwoEnquiry(Request $request)
	{

		if ($request->ajax()) {

			$validator = Validator::make(
				$request->all(),
				[
					'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
					'mobile' => 'required|numeric',
					'kw_text' => 'required',
					'remark' => 'required',
					'terms' => 'required',
				],
				[
					'name' => 'Full name is required.',
					'mobile' => 'Phone no is required',
					'kw_text' => 'Service is required',
					'remark' => 'Remarks is required',
					'terms' => 'terms is required',
				]
			);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$lead = new Lead;
			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			$lead->email = $request->input('email');
			$lead->lead_form = $request->input('lead_form');
			$lead->from_page = filter_var($request->input('from_page'), FILTER_SANITIZE_STRING);
			$citySlug = $request->input('city_id');
			$cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : null;

			if (!empty($request->location)) {

				if (is_numeric($request->location)) {

					$zone = Zone::find($request->location);
					if (!empty($zone)) {
						$lead->zone_id = $zone->id;
						$lead->zone = $zone->zone;

						$city = Citieslists::find($zone->city_id);


						if (!empty($city)) {
							$lead->city_id = $city->id;
							$lead->city_name = $city->city;
						}
					}
				} else {

					$city = Citieslists::where('city', $request->location)->first();
					if (!empty($city)) {
						$lead->city_id = $city->id;
						$lead->city_name = $city->city;

						$zone = Zone::where('city_id', $city->id)->first();

						if (!empty($zone)) {
							$lead->zone_id = $zone->id;
							$lead->zone = $zone->zone;

						}
					}
				}

			} else {

				$city = $cityName
					? Citieslists::where('city', $cityName)->first()
					: null;

				if (!empty($city)) {
					$lead->city_id = $city->id;
					$lead->city_name = $city->city;

					$zone = Zone::where('city_id', $city->id)->first();
					if (!empty($zone)) {
						$lead->zone_id = $zone->id;
						$lead->zone = $zone->zone;
					}

				} else {
					// fallback
					$lead->city_name = $cityName ?: 'none';
				}
			}

			if ($request->has('b_end')) {
				$lead->b_end = $request->input('b_end');
			}

			$mobile = ltrim($request->input('mobile'), '0');
			$mobile = trim($mobile);
			$newmobile = preg_replace('/\s+/', '', $mobile);
			$lead->mobile = $newmobile;
			$lead->code = $request->code;
			$kw_text = filter_var($request->input('kw_text'), FILTER_SANITIZE_STRING);
			$kw_text = preg_replace('/[^A-Za-z0-9]/', ' ', $kw_text);
			$kw_text = preg_replace('/\s+/', ' ', str_replace('&', '', trim($kw_text)));
			$keyword = Keyword::where('keyword', $kw_text)->first();

			if (!empty($keyword)) {
				$lead->kw_id = $keyword->id;
				$lead->kw_text = $keyword->keyword;

			} else {
				$lead->kw_id = 0;
				$lead->kw_text = $request->input('kw_text');
			}
			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
			$lead->age = $request->input('age');
			$lead->experience = $request->input('experience');
			$lead->plan = $request->input('plan');
			$lead->created_by = 101;
			$lead->terms = $request->terms;


			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;

			$lead->created_by = 101;

			if ($request->frmcheck) {
				$lead->frmcheck = json_encode($request->frmcheck);
			}

			$today = date('Y-m-d');
			$checklead = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->where('city_name', $cityName)->whereDate('created_at', '=', date_format(date_create($today), 'Y-m-d'))->get()->count();
			//echo "<pre>";print_r($checklead);die;
			$currentdate = date('Y-m-d');
			$lastDate = date('Y-m-d', strtotime($currentdate . '- 4 day'));

			$checkday = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->whereDate('created_at', '>', date_format(date_create($lastDate), 'Y-m-d'))->get()->count();

			if (!empty($checklead) && $checklead > 0) {
				return response()->json([
					'statusCode' => 1,
					'response' => [
						'responseCode' => 200,
						'payload' => '',
						'message' => 'Follow Up created successfully'
					]
				], 200);
			} else if (!empty($checkday) && $checkday > 0) {
				$lead->duplicate = '1';
				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);

				}
			} else {

				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					// leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);
				}
			}
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function autoFormSave(Request $request)
	{
		$cityname = ucwords(str_replace("-", " ", $request->input('city_id')));
		$city = Citieslists::where('city', 'LIKE', ucwords(str_replace("-", " ", $request->input('city_id'))))->first();
		$lead = new Lead;
		if (!empty($city->id)) {
			$lead->city_id = $city->id;
			$lead->city_name = $city->city;
		} else {
			if ($cityname) {
				$lead->city_name = $cityname;
			} else {
				$lead->city_name = 'none';
			}
		}
		$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
		$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
		$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
		$lead->name = $name;

		if ($request->input('email') != '') {

			$lead->email = $request->input('email');
		}
		$mobile = ltrim($request->input('mobile'), '0');
		$mobile = trim($mobile);
		$newmobile = preg_replace('/\s+/', '', $mobile);
		$lead->mobile = $newmobile;
		$lead->lead_form = $request->input('lead_form');
		$lead->from_page = filter_var($request->input('from_page'), FILTER_SANITIZE_STRING);
		$keyword = Keyword::where('keyword', 'LIKE', $request->input('kw_text'))->get();
		if (!empty($keyword)) {
			$lead->kw_id = $keyword[0]->id;
			$lead->kw_text = $keyword[0]->keyword;
			$bucketIndex = $keyword[0]->bucket;
		}
		if ($request->has('b_end')) {
			$lead->b_end = $request->input('b_end');
		}
		$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
		$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;
		$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
		$lead->created_by = '1';

		$today = date('Y-m-d');
		$checklead = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->where('city_name', $cityname)->whereDate('created_at', '=', date_format(date_create($today), 'Y-m-d'))->get()->count();

		$currentdate = date('Y-m-d');
		$lastDate = date('Y-m-d', strtotime($currentdate . '- 4 day'));

		$checkday = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->whereDate('created_at', '>', date_format(date_create($lastDate), 'Y-m-d'))->get()->count();

		if (!empty($checklead) && $checklead > 0) {

		} else if (!empty($checkday) && $checkday > 0) {
			$lead->duplicate = '1';
			if ($lead->save()) {

				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->lead_id = $lead->id;

				$followUp->save();
			}
		} else {

			if ($lead->save()) {

				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->lead_id = $lead->id;
				//$followUp->remark_by =Auth::user()->id;
				$followUp->save();


			}
		}
		return response()->json([
			'status' => true,
			'response' => [
				'responseCode' => 200,
				'payload' => '',
				'message' => 'Lead successfully'
			]
		], 200);


	}

 public function enquirySendOtp(Request $request)
    {

 
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            //'password' => 'required',
        ]);
 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
 
    
       
    
          
	 
	 
		$otp = mt_rand(100000, 999999);
		$request->session()->put('otp', $otp);
           

            //$message = "{$otp} is quickdials Portal Verification Code for {$request->session()->get('client.mobile')}.";
            // $message = "{$otp} is Lead Portal Verification Code for {$request->session()->get('client.mobile')} quickdials";
            //     $templateId ='1707161786775524106';

            // //sendSMS($request->session()->get('client.mobile'),$message,$templateId);

 

			//  dd($user);
            $message = "{$otp} is QuickDials Verification Code for {$request->email} .";
            $subject = "{$otp} is QuickDials Verification Code";
        

			 $checkmail = Mail::send('emails.sendotp_to_email', ['otp' => $otp,'name'=>$request->email], function ($m) use ($message, $request, $subject) {
                $m->from('leads.quickdials@gmail.com', 'Login OTP');
                $m->to($request->input('email'), "")->subject($subject);
            });
            
            
       
        
        return response()->json([
            'status' => true,
            'message' => 'OTP has been sent to your email successfully',
            'otp' => $otp,
           
            
         
        ]);
    }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if ($request->ajax()) {

			$lead = new Lead;
			$citySlug = $request->input('city_id');
			$cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : null;

			if (!empty($request->location)) {

				$zone = Zone::find($request->location);

				if ($zone) {
					$lead->zone_id = $zone->id;
					$lead->zone = $zone->zone;

					$city = Citieslists::find($zone->city_id);
					if ($city) {
						$lead->city_id = $city->id;
						$lead->city_name = $city->city;
					}
				}

			} else {

				$city = $cityName
					? Citieslists::where('city', $cityName)->first()
					: null;

				if ($city) {
					$lead->city_id = $city->id;
					$lead->city_name = $city->city;
				} else {
					// fallback
					$lead->city_name = $cityName ?: 'none';
				}
			}


			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			if ($request->input('email') != '') {

				$lead->email = $request->input('email');
			}
			$lead->mobile = $request->input('mobile');
			$lead->lead_form = $request->input('lead_form');
			$keyword = Keyword::where('keyword', 'LIKE', $request->input('kw_text'))->get();
			if (!empty($keyword)) {
				$lead->kw_id = $keyword[0]->id;
				$lead->kw_text = $keyword[0]->keyword;
				$bucketIndex = $keyword[0]->bucket;
			} else {
				return response()->json(['status' => 1, 'msg' => 'Keyword not found'], 410);
			}
			if ($request->has('b_end')) {
				$lead->b_end = $request->input('b_end');
			}
			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;
			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
			$lead->created_by = '1';

			if ($lead->save()) {
				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->lead_id = $lead->id;
				//$followUp->remark_by =Auth::user()->id;
				$followUp->save();
				// leadassignWithoutZoneCounsellor($lead);
				return response()->json(['status' => 1, 'msg' => 'Lead added successfully'], 200);
			}

		}
	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function searchUser(Request $request)
	{
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		if ($request->wantsJson()) {
			$query = DB::table('users');
			$query = $query->select('users.id', 'users.first_name', 'users.last_name');
			$str = '';
			if ($request->input('q') != "") {
				$str = trim($request->input('q'));
				$query = $query->orWhere('users.first_name', 'LIKE', '%' . $str . '%');
				$query = $query->orWhere('users.last_name', 'LIKE', '%' . $str . '%');
			}
			$query = $query->get();
			return response()->json(['status' => 1, 'users' => $query]);
		}
	}

	/*
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function searchKWcc(Request $request)
	{
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		if ($request->wantsJson()) {
			$query = DB::table('keyword')
				->select('keyword.keyword', 'keyword.slug', 'keyword.id');
			$str = '';
			if ($request->input('q') != "") {
				$str = trim($request->input('q'));
				$query = $query->orWhere('keyword.keyword', 'LIKE', '%' . $str . '%');
				$query = $query->orderBy(DB::raw("CASE WHEN keyword.keyword LIKE '" . $str . "%' THEN 1 ELSE 2 END"));

				$query = $query->distinct()->get();
			}
			return response()->json(['status' => 1, 'areas' => $query]);
		}
	}


	/*
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function playwrightAutomation(Request $request)
	{		 
		$city = "noida";
		$area = "";
		$metaTitle = "Playwright Automation Testing Course | Learn Web Test Automation";
		$metaDescription = "Learn Playwright Automation to create fast, reliable web testing scripts for modern applications. Master end-to-end testing across multiple browsers.";		
		$keyword = "Play Wright Automation";
		return view('client.playwrightAutomation', ['city' => $city, 'area' => $area,'keyword'=>$keyword,'metaDescription'=>$metaDescription,'metaTitle'=>$metaTitle]);
	}


	/*
	 * Get matches trainers based on ajax.
	 *
	 * @param  string
	 * @return JSON Object having matched course details
	 */
	public function getCountryCode(Request $request)
	{
		if ($request->ajax()) {

			$len = strlen($request->input('id'));
			if (null == $request->input('id')) {
				$countryies = Citieslists::whereIn('id', ['278', '596', '961', '428'])->get();

			} else {

				$countryies = DB::table('zones')
					->join('citylists', 'citylists.id', '=', 'zones.city_id')
					->where(function ($query) use ($request) {
						$q = $request->input('id');
						$query->where('zones.zone', 'LIKE', "%$q%")
							->orWhere('citylists.city', 'LIKE', "%$q%");
					})
					->select('zones.id as zone_id', 'zones.zone', 'citylists.city', 'zones.pincode')
					->distinct()
					->get();


			}

			$html = '<div class="resultCode"><ul>';
			if (!empty($countryies)) {

				foreach ($countryies as $data) {

					$pos = stripos($data->city, $request->input('id'));
					if ($pos >= 0) {
						$str = substr($data->city, $pos, $len);
						$strong_str = "<strong>" . $str . "</strong>";
						$final_str = str_replace($str, $strong_str, $data->city);
						$html .= '<li><a data-city="' . strtolower($data->city) . '" 
							data-area="' . strtolower($data->zone) . '">
							' . ucwords($final_str) . ', ' . ucwords($data->zone) . '
						</a>
						</li>';

					} else {

						$html .= '<li><a data-city="' . strtolower($data->city) . '">' . ucwords($data->city) . '</a>
						</li>';

					}
				}

			}

			$zones = DB::table('zones')
				->join('citylists', 'citylists.id', '=', 'zones.city_id')
				->where(function ($query) use ($request) {
					$q = $request->input('id');
					$query->where('zones.zone', 'LIKE', "%$q%")
						->orWhere('zones.pincode', 'LIKE', "%$q%");
				})
				->select('zones.id as zone_id', 'zones.zone', 'citylists.city', 'zones.pincode')
				->distinct()
				->get();


			if (!empty($zones)) {

				foreach ($zones as $zone) {

					$pos = stripos($zone->zone, $request->input('id'));
					if ($pos >= 0) {
						$str = substr($zone->zone, $pos, $len);
						$strong_str = "<strong>" . $str . "</strong>";
						$final_str = str_replace($str, $strong_str, $zone->zone);
						$html .= '<li><a data-city="' . strtolower($data->city) . '" 
							data-area="' . strtolower($data->zone) . '">
							' . ucwords($final_str) . ', ' . ucwords($data->zone) . ', ' . ucwords($data->pincode) . '
						</a>
						</li>';


						$html .= '<li><a data-city="' . strtolower($zone->city) . '" 
							data-area="' . strtolower($zone->zone) . '">
							' . ucwords($final_str) . ', ' . ucwords($zone->zone) . ', ' . ucwords($zone->pincode) . '
						</a>
						</li>';


					} else {

						$html .= '<li><a data-city="' . strtolower($zone->city) . '">' . ucwords($zone->zone) . ', ' . ucwords($zone->city) . '></a></li>';

					}
				}

			}


			$areas = DB::table('citylists');
			$areas = $areas->join('zones', 'citylists.id', '=', 'zones.city_id');
			$areas = $areas->join('areas', 'zones.id', '=', 'areas.zone_id');

			$areas = $areas->where(function ($query) use ($request) {
				$query->where('area', 'LIKE', '%' . $request->input('id') . '%');
			});

			$areas = $areas->get();

			if (!empty($areas)) {

				foreach ($areas as $area) {

					$pos = stripos($area->area, $request->input('id'));
					if ($pos >= 0) {
						$str = substr($area->area, $pos, $len);
						$strong_str = "<strong>" . $str . "</strong>";
						$final_str = str_replace($str, $strong_str, $area->area);

						$html .= '<li><a data-city="' . strtolower($area->city) . '" data-area="" data-zone="">' . ucwords($final_str) . ', ' . ucwords($area->city) . '</a></li>';
					} else {
						$html .= '<li><a data-city="' . strtolower($area->city) . '">' . ucwords($area->area) . ', ' . ucwords($area->city) . '</a></li>';
					}
				}
			}
			$html .= '</ul></div>';
			echo $html;
		}
	}

	/*
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getKWList(Request $request)
	{
		$kwdsList = Keyword::where('child_category_id', $request->input('child_cat_id'))
			->where('parent_category_id', $request->input('parent_cat_id'))
			->select('keyword')
			->distinct()
			->get();
		return response()->json(['status' => 1, 'message' => $kwdsList]);
	}

	/*
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getCityKWList(Request $request)
	{
		$citiesList = DB::table('assigned_kwds')
			->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
			->select('citylists.city')
			->distinct()
			->get();
		return response()->json(['status' => 1, 'message' => $citiesList]);
	}

	 
	 
	 
 
	/*
	 * Subscribe to our newsletter
	 *
	 */
	public function newsletter(Request $request)
	{
		try {
			if (null == $request->input('email')) {
				throw new Exception("Enter valid email address");
			}
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
		$email = $request->input('email');
		Mail::send('emails.newsletter', ['email' => $email], function ($m) use ($email) {
			$m->from('info@quickdials.com', 'QuickDials');
			$m->to('info@quickdials.com', 'QuickDials')->subject('Newsletter Subscription');
		});

		return response()->json(['status' => 1, 'message' => 'Successfully subscribed to our newsletter']);
	}


	public function addLadsss(Request $request)
	{
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
	}

	public function businessServices(Request $request)
	{	
		// ── API fetch (cached 1 hour) ────────────────────────────────────────
        $apiData = Cache::remember('business_services', 3600, function () {
            try {
                $res = Http::timeout(30)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/business-services');
                return $res->successful() ? $res->json('data', []) : [];
            } catch (\Exception $e) {
                \Log::error('BusinessServices API: ' . $e->getMessage());
                return [];
            }
        });
 
        // ── Static data ──────────────────────────────────────────────────────
        $heroStats = [
            ['value' => '350+',  'label' => 'Register Business'],
            ['value' => '8000+', 'label' => 'Business Keyword'],
            ['value' => '200+',  'label' => 'Years'],
            ['value' => '20+',   'label' => 'Countries'],
        ];
 
        
 
        $featured = [
            ['name' => 'TechAxis IT Solutions', 'category' => 'Web Development',   'city' => 'Delhi',     'rating' => 4.8, 'reviews' => 312],
            ['name' => 'BrightMinds Coaching',  'category' => 'IIT JEE Coaching',  'city' => 'Mumbai',    'rating' => 4.6, 'reviews' => 189],
            ['name' => 'GreenLeaf Ayurveda',    'category' => 'Ayurvedic Clinic',   'city' => 'faridabad', 'rating' => 4.9, 'reviews' => 97],
            ['name' => 'StyleCraft Interiors',  'category' => 'Interior Design',    'city' => 'Hyderabad', 'rating' => 4.7, 'reviews' => 243],
        ];
 
        $sidebarStats = [
            ['icon' => 'building', 'val' => '350+',  'label' => 'Businesses'],
            ['icon' => 'search',   'val' => '8000+', 'label' => 'Keywords'],
            ['icon' => 'award',    'val' => '200+',  'label' => 'Years Exp.'],
            ['icon' => 'globe',    'val' => '20+',   'label' => 'Countries'],
        ];
 
        // Merge API data over static defaults if available
        $featuredFromApi = $apiData['featured']          ?? [];
        $statsFromApi    = $apiData['stats']             ?? [];
        $categorySections    = $apiData['businessServices']             ?? [];
 

 		$category = array_slice($categorySections, 1, 5);
 		$featuredCategory = array_slice($categorySections, 1, 5);

 
        if (!empty($featuredFromApi)) $featured    = $featuredFromApi;
        if (!empty($statsFromApi))    $heroStats   = $statsFromApi;
 

	$city = "delhi";
	$metaTitle = "Business Services in Delhi | QuickDials Local Business Directory";
	$metaDescription = "Find trusted business services in Delhi on QuickDials. Explore verified service providers, professionals, consultants, and local business solutions near you.";
	$keyword = "business services";

        return view('client.businessServices', compact(
            'heroStats', 'categorySections', 'featured', 'featuredCategory','sidebarStats', 'category','city','metaTitle','metaDescription','keyword'
        ));


 
	}



	public function category(Request $request)
	{
		 
 
            $data = Cache::remember('category_page_data', 3600, function () {
            $response = Http::timeout(10)->withoutVerifying()->get('https://api.quickdials.com/api/website/getCategories');
 
            if ($response->successful()) {
                return $response->json('data', []);
            }
 
            return [];
        });
 
        $categories = $data['categoryList'] ?? [];
        $childs     = $data['childs']       ?? [];
        
		$city = "delhi";
		$metaTitle = "Categories in delhi | QuickDials Local Business Directory";
		$metaDescription = "Find trusted Categories in Delhi on QuickDials. Explore verified service providers, professionals, consultants, and local business solutions near you.";
		$keyword = "Category";
 
        return view('client.category', compact('categories', 'childs','city','metaTitle','metaDescription','keyword'));



	}
	public function child(Request $request)
	{
		       
        $data = Cache::remember('child_keyword_page', 3600, function () {
            try {
                $res = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/getChild');
                return $res->successful() ? $res->json('data', []) : [];


            } catch (\Exception $e) {
                \Log::error('getChild API: ' . $e->getMessage());
                return [];
            }
        });
 
        $childs  = $data['childsList'] ?? [];
        $courses = $data['keywords']   ?? [];
 

		$city = "delhi";
		$metaTitle = "Sub Categories in delhi | QuickDials Local Business Directory";
		$metaDescription = "Find trusted sub categories in Delhi on QuickDials. Explore verified service providers, professionals, consultants, and local business solutions near you.";
		$keyword = "Sub category";

        return view('client.child', compact('childs', 'courses','city','metaTitle','metaDescription','keyword'));
 	}

	public function categories(Request $request, $slug)
	{
	
		$res = Http::timeout(10)->withoutVerifying()
			->get('https://api.quickdials.com/api/website/searchCategories', [
				'category-slug' => $slug,
			]);

		$response = $res->successful() ? $res->json() : null;
 

        if (!$response) {
            abort(410);
        }
 
        /* ── extract data (mirrors the Next.js component) ── */
        $kwData       = $response['data']['keyword']      ?? [];

		// dd($kwData);
        $categoryList = $response['data']['categoryList'] ?? [];
 
        $keyword          = $kwData['parent_category']   ?? '';
        $childCategory    = $kwData['parent_category']   ?? '';
        $childSlug        = $kwData['parent_slug']       ?? '';
        $topDescription   = strip_tags($kwData['top_description']    ?? '');
        $bottomDescription= strip_tags($kwData['bottom_description'] ?? '');
        $ratingCount      = $kwData['ratingcount']       ?? 0;
        $ratingValue      = $kwData['ratingvalue']       ?? 4.8;
        $bgImage          = $kwData['category_banner']   ?? '/computer-courses-training.jpg';
        $metaTitle        = $kwData['meta_title']        ?? $keyword;
        $metaDescription  = $kwData['meta_description']  ?? '';
         $metaKeywords  = $kwData['h1_heading']  ?? '';
        /* star image map */
        $starMap = [
            0 => 'star_1.png', 2 => 'star_2.png', 3 => 'star_3.png',
            3.5 => 'star_3.5.png', 4 => 'star_4.png', 4.5 => 'star_4.5.png',
            4.75 => 'star_4.75.png', 5 => 'star_5.png',
        ];
        $stars = $starMap[$ratingValue] ?? 'star_4.5.png';
 

		$faqs = [];
        for ($i = 1; $i <= 6; $i++) {
            $q = $kwData["faqq{$i}"] ?? '';
            $a = $kwData["faqa{$i}"] ?? '';
            if ($q && $a) $faqs[] = ['q' => $q, 'a' => $a];
        }



        /* category colour palette (index-based, mirrors Next.js CAT_STYLE) */
        $catColors = [
            '#1a5276','#1a6496','#4a235a','#b7770d','#0b3d5e',
            '#145a32','#2c3e50','#154360','#7b241c','#117a65',
            '#145a32','#784212','#1e8449','#1b4332',
        ];
 		$city = "faridabad";
        return view('client.category-slug', compact(
            'slug', 'keyword', 'childCategory','kwData', 'childSlug',
            'topDescription', 'bottomDescription','faqs',
            'ratingCount', 'ratingValue', 'stars', 'bgImage',
            'categoryList', 'catColors','metaKeywords',
            'metaTitle', 'metaDescription','city'
        ));
    

 




	}



	public function childSlus(Request $request, $child_slug)
	{
		  
 
    
            $res = Http::timeout(10)->withoutVerifying()
                ->get('https://api.quickdials.com/api/website/searchChild', [
                    'child-slug' => $child_slug,
                ]);
 
            

			   $response = $res->successful() ? $res->json() : null;
       
 
        if (!$response) {
            abort(410);
        }
 
        /* ── extract data (mirrors the Next.js component) ── */
        $kwData       = $response['data']['keyword']      ?? [];
        $childLists = $response['data']['childLists'] ?? []; 
        $keyword          = $kwData['child_category']   ?? '';
        $childCategory    = $kwData['child_category']   ?? '';
        $childSlug        = $kwData['child_slug']       ?? '';
        $topDescription   = strip_tags($kwData['top_description']    ?? '');
        $bottomDescription= strip_tags($kwData['bottom_description'] ?? '');
        $ratingCount      = $kwData['ratingcount']       ?? 0;
        $ratingValue      = $kwData['ratingvalue']       ?? 4.8;
        $bgImage          = $kwData['category_banner']   ?? '/computer-courses-training.jpg';
        $metaTitle        = $kwData['meta_title']        ?? $keyword;
        $metaDescription  = $kwData['meta_description']  ?? '';
        $metaKeywords  = $kwData['h1_heading']  ?? '';
 
  		$faqs = [];
        for ($i = 1; $i <= 6; $i++) {
            $q = $kwData["faqq{$i}"] ?? '';
            $a = $kwData["faqa{$i}"] ?? '';
            if ($q && $a) $faqs[] = ['q' => $q, 'a' => $a];
        }

        /* star image map */
        $starMap = [
            0 => 'star_1.png', 2 => 'star_2.png', 3 => 'star_3.png',
            3.5 => 'star_3.5.png', 4 => 'star_4.png', 4.5 => 'star_4.5.png',
            4.75 => 'star_4.75.png', 5 => 'star_5.png',
        ];
        $stars = $starMap[$ratingValue] ?? 'star_4.5.png';
 
        /* category colour palette (index-based, mirrors Next.js CAT_STYLE) */
        $catColors = [
            '#1a5276','#1a6496','#4a235a','#b7770d','#0b3d5e',
            '#145a32','#2c3e50','#154360','#7b241c','#117a65',
            '#145a32','#784212','#1e8449','#1b4332',
        ];
 		$city = "faridabad";
		
        return view('client.child-slug', compact(
            'child_slug', 'keyword', 'childCategory', 'childSlug',
            'topDescription', 'bottomDescription','metaKeywords',
            'ratingCount', 'ratingValue', 'stars', 'bgImage',
            'childLists', 'catColors','faqs','kwData',
            'metaTitle', 'metaDescription','city'
        ));
    
	}

	public function weddingPannel(Request $request)
	{
		 $stats = [
            ['value' => '10,000+', 'label' => 'Happy Couples'],
            ['value' => '500+',    'label' => 'Verified Vendors'],
            ['value' => '4.9★',   'label' => 'Avg Rating'],
            ['value' => '50+',    'label' => 'Cities'],
        ];
 
       $categories = [
			['name' => 'Banquet Halls',     'slug' => 'banquet-hall',     'img' => '/popular/Banquet-Halls.webp'],
			['name' => 'Decor & Flowers',   'slug' => 'flower-decoration',     'img' => '/popular/Flower_Decoration.jpg'],
			['name' => 'Invitation Cards',  'slug' => 'invitation-cards',  'img' => '/popular/Invitation_Cards_pre.png'],
			['name' => 'Caterers & Food',   'slug' => 'caterers-food',     'img' => '/popular/Caterers_Food.png'],
			['name' => 'Trousseau Packing', 'slug' => 'trousseau-packing', 'img' => '/popular/Trousseau_Packing_pre.png'],
			['name' => 'Photography',       'slug' => 'photography',       'img' => '/popular/Photography_pre.png'],
			['name' => 'Mehendi Artists',   'slug' => 'mehendi-artists',   'img' => '/popular/Mehendi_Artists_pre.png'],
			['name' => 'Musicians & DJ',    'slug' => 'musicians-dj',      'img' => '/popular/Musicians_DJ_pre.png'],
			['name' => 'Choreography',      'slug' => 'choreography',      'img' => '/popular/Choreography_pre.png'],
			['name' => 'Wedding Cakes',     'slug' => 'wedding-cakes',     'img' => '/popular/Wedding_cakes.png'],
		];

		$brideCategories = [
			['name' => 'Makeup Artists',     'slug' => 'makeup-artists',     'img' => 'popular/Makeup_Artists_bride.png'],
			['name' => 'Mehendi Artists',    'slug' => 'mehendi-artists',    'img' => 'popular/Mehendi_Artists_bride.png'],
			['name' => 'Bridal Wear',        'slug' => 'bridal-wear',        'img' => 'popular/Bridal_Wear_bride.png'],
			['name' => 'Bridal Entry',       'slug' => 'bridal-entry',       'img' => 'popular/Bridal_Entry_bride.png'],
			['name' => 'Varmala',            'slug' => 'varmala',            'img' => 'popular/varmala3.jpeg'],
			['name' => 'Wedding footwear',   'slug' => 'wedding-footwear',   'img' => 'popular/Wedding_footwear.png'],
			['name' => 'Bridal Jewellery',   'slug' => 'bridal-jewellery',   'img' => 'popular/Bridal_Jewellery_bride.png'],
			['name' => 'Invitation Cards',   'slug' => 'invitation-cards',   'img' => 'popular/Invitation_Cards_bride.png'],
			['name' => 'Honeymoon Planning', 'slug' => 'honeymoon-planning', 'img' => 'popular/Honeymoon_Planning_bride.png'],
		];

		$groomCategories = [
			['name' => 'Wedding Suit',         'slug' => 'wedding-suit',         'img' => 'popular/Wedding_Suit_groom.png'],
			['name' => 'Mehendi Artists Groom',      'slug' => 'mehendi-artists-groom',      'img' => 'popular/Mehendi_Artists_groom.png'],
			['name' => 'Sherwani & Wear',      'slug' => 'sherwani-wear',        'img' => 'popular/Sherwani_Wear_groom.png'],
			['name' => 'Groom Entry',          'slug' => 'groom-entry',          'img' => 'popular/Groom_Entry_groom.png'],
			['name' => 'Wedding Rath',         'slug' => 'wedding-rath',         'img' => 'popular/Wedding_Rath_groom.png'],
			['name' => 'Fireworks & Crackers', 'slug' => 'fireworks-crackers',   'img' => 'popular/Fireworks_Crackers.png'],
			['name' => 'Grooming & Hair',      'slug' => 'grooming-hair',        'img' => 'popular/Grooming_Hair_groom.png'],
			['name' => 'Dhol & Band',          'slug' => 'dhol-band',            'img' => 'popular/Dhol_Band_groom.png'],
			['name' => 'Pre-Wedding Shoot',    'slug' => 'pre-wedding-shoot',    'img' => 'popular/Pre-Wedding_Shoot_groom.png'],
		];

		$prewedding = [
			['name' => 'Wedding Astrologers',         'slug' => 'wedding-astrologers',         'img' => 'popular/Wedding-Astrologers.png'],
			['name' => 'Marriage Certificate Agents', 'slug' => 'marriage-certificate-agents', 'img' => 'popular/Marriage-Certificate-Agents.png'],
			['name' => 'Jewellery Showrooms',         'slug' => 'jewellery-showrooms',         'img' => 'popular/Jewellery-Showrooms.png'],
			['name' => 'Readymade Garments',          'slug' => 'readymade-garments',          'img' => 'popular/Readymade-Garments.png'],
			['name' => 'Haldi Stage Decors',          'slug' => 'haldi-stage-decors',          'img' => 'popular/Haldi-Stage-Decors.png'],
			['name' => 'Wedding Card Printers',       'slug' => 'wedding-card-printers',       'img' => 'popular/Wedding-Card-Printers.png'],
			['name' => 'Hotels',                      'slug' => 'hotels',                      'img' => 'popular/Hotels.png'],
			['name' => 'Honeymoon Tour Packages',     'slug' => 'honeymoon-tour-packages',     'img' => 'popular/Honeymoon-Tour-Packages.png'],
		];

		$bigDay = [
			['name' => 'Stage Decorators',       'slug' => 'stage-decorators',       'img' => 'popular/Stage_Decorators.png'],
			['name' => 'Wedding Caterers',       'slug' => 'wedding-caterers',       'img' => 'popular/Wedding_Caterers.png'],
			['name' => 'Cold Pyro & Fog Matka',  'slug' => 'cold-pyro-fog-matka',    'img' => 'popular/Cold_Pyro_Fog_Matka.png'],
			['name' => 'DJ Services',            'slug' => 'dj-services',            'img' => 'popular/DJ_Services.png'],
			['name' => 'Wedding Bands',          'slug' => 'wedding-bands',          'img' => 'popular/Wedding-Bands.png'],
			['name' => 'Singer dancer',          'slug' => 'singer-dancer',          'img' => 'popular/Singer_dancer.png'],
			['name' => 'Wedding Choreographers', 'slug' => 'wedding-choreographers', 'img' => 'popular/Wedding_Choreographers.png'],
			['name' => 'Wedding Organisers',     'slug' => 'wedding-organisers',     'img' => 'popular/Wedding_Organisers.png'],
		];

        $venues = [
            ['name' => 'The Taj Mahal Palace', 'location' => 'Colaba, Mumbai',       'rating' => 4.9, 'reviews' => 124, 'price' => '₹₹₹₹', 'img' => 'popular/The_Taj_Mahal_Palace.jpg'],
            ['name' => 'JW Marriott Juhu',     'location' => 'Juhu, Mumbai',         'rating' => 4.8, 'reviews' => 98,  'price' => '₹₹₹₹', 'img' => 'popular/venues2.jpg'],
            ['name' => 'Sahara Star',          'location' => 'Vile Parle, Mumbai',   'rating' => 4.7, 'reviews' => 156, 'price' => '₹₹₹',  'img' => 'popular/Sahara_Star.jpg'],
            ['name' => 'The Leela',            'location' => 'Andheri, Mumbai',      'rating' => 4.8, 'reviews' => 112, 'price' => '₹₹₹₹', 'img' => 'popular/The_Leela.jpg'],
            ['name' => 'ITC Maratha',          'location' => 'Andheri East, Mumbai', 'rating' => 4.6, 'reviews' => 84,  'price' => '₹₹₹',  'img' => 'popular/ITC_Maratha.jpg'],
        ];
 
        $steps = [
            ['number' => '01', 'icon' => 'popular/Choose_Your_Dream.png', 'title' => 'Choose Your Dream',    'desc' => 'Browse thousands of venues, vendors, and wedding professionals across India. Filter by budget, location, and style to find your perfect match.'],
            ['number' => '02', 'icon' => 'popular/Plan_with_Experts.png', 'title' => 'Plan with Experts',    'desc' => 'Our dedicated wedding planners work closely with you to craft every detail — from invitations to reception — ensuring nothing is left to chance.'],
            ['number' => '03', 'icon' => 'popular/Celebrate_Forever.png', 'title' => 'Celebrate Forever',   'desc' => 'Step into the most magical day of your life, knowing every detail has been thoughtfully arranged. Focus on love — we handle the rest.'],
        ];
 
        $testimonials = [
            ['name' => 'Priya & Rahul Sharma',   'location' => 'Mumbai',    'date' => 'December 2024', 'rating' => 5, 'text' => 'Shaadi6 made our dream wedding a reality. From finding the perfect venue at The Taj to coordinating with 15 different vendors seamlessly — every moment was magical.', 'avatar' => 'PR', 'grad' => 'from-pink-400 to-red-500',    'package' => 'Royal Package'],
            ['name' => 'Ananya & Vikram Mehta',  'location' => 'Delhi',     'date' => 'October 2024',  'rating' => 5, 'text' => 'From the mehendi ceremony to the reception, everything was perfect. Our wedding planner was always available, incredibly organized, and made us feel calm throughout.',  'avatar' => 'AV', 'grad' => 'from-amber-400 to-orange-500', 'package' => 'Premium Package'],
            ['name' => 'Deepa & Arjun Nair',     'location' => 'faridabad', 'date' => 'February 2025', 'rating' => 5, 'text' => 'We had no idea how to plan a wedding for 400 guests. Shaadi6 took care of everything — venue, catering, flowers, even the honeymoon. Most stress-free experience ever.',  'avatar' => 'DA', 'grad' => 'from-purple-400 to-pink-500',  'package' => 'Royal Package'],
        ];
			$city = "delhi";
			$metaTitle = "Wedding Planning Services in Delhi | QuickDials";
			$metaDescription = "Find trusted wedding planning services in Delhi on QuickDials. Explore verified wedding planners, decorators, caterers, photographers, and event experts near you.";
			$keyword = "Wedding Planning";
 
        return view('client.wedding-planning', compact(
            'stats','categories','brideCategories','groomCategories',
            'venues','steps','testimonials','prewedding','bigDay','city','metaTitle','metaDescription','keyword'
        ));
		 

	}

	

	
	public function spaHub(Request $request)
	{


	 $spa = [
            'name'        => 'Serenity Spa & Wellness',
            'tagline'     => 'Pure indulgence, modern wellness',
            'phone'       => '+917595439543',
            'whatsapp'    => '917595439543',
            'email'       => 'info@quickdials.com',
            'address'     => '42 Lotus Garden Lane, Koregaon Park, Pune',
            'slug'        => 'serenity-spa-pune',
             'location'  => 'Koregaon Park · Pune',
		 
        'est'       => '2013',
        ];
$reviews =  [
           
            
        ];
 
		$services = keyword::where('child_category_id','293')->get();
 
		$city = "delhi";
		$metaTitle = "Spa Hub in Delhi | QuickDials";
		$metaDescription = "Find trusted spa hubs in Delhi on QuickDials. Explore verified spa centres, wellness services, massage therapies, body treatments, and relaxation experts near you.";
		$keyword = "spa hub in Delhi";
  	return view('client.spa-hub', compact('spa','reviews','services','city','metaTitle','metaDescription','keyword'));
	}
	
	public function saloonHub(Request $request)
	{


	 $spa = [
            'name'        => 'Serenity Spa & Wellness',
            'tagline'     => 'Pure indulgence, modern wellness',
            'phone'       => '+919876543210',
            'whatsapp'    => '919876543210',
            'email'       => 'info@quickdials.com',
            'address'     => '42 Lotus Garden Lane, Koregaon Park, Pune',
            'slug'        => 'serenity-spa-pune',
             'location'  => 'Koregaon Park · Pune',
		 
        'est'       => '2013',
        ];
$reviews =  [
            ['name' => 'Priya M.',  'rating' => 5, 'created_at' => '2025-03-15', 'treatment' => 'Signature Retreat',  'text' => "Absolutely heavenly — three hours of uninterrupted bliss. Staff is attentive, ambiance is world-class, and the products are genuinely luxurious. Serenity is the best spa I've ever visited.",                  'color' => '#f97316'],
            ['name' => 'Rohan K.',  'rating' => 5, 'created_at' => '2025-02-10', 'treatment' => 'Hot Stone Therapy',  'text' => "The hot stone therapy was exactly what my back needed. Every detail was considered — the music, aromas, temperature. I left feeling like a different person. Already booked my next session.",                'color' => '#ea580c'],
            ['name' => 'Ananya S.', 'rating' => 5, 'created_at' => '2025-01-22', 'treatment' => "Couple's Retreat",   'text' => "Booked for our anniversary — the private suite was set up with incredible thoughtfulness. Both of us agree it was the most memorable thing we've done together.",                                              'color' => '#f59e0b'],
            ['name' => 'Deepak V.', 'rating' => 4, 'created_at' => '2024-12-05', 'treatment' => 'Ayurvedic Ritual',   'text' => "Authentic and deeply relaxing — herbal oils of excellent quality and a therapist who explained each step. Slightly long wait on Saturday but the treatment was excellent.",                                    'color' => '#0d9488'],
            ['name' => 'Meera T.',  'rating' => 5, 'created_at' => '2024-11-18', 'treatment' => 'Facial Glow',        'text' => "My skin hasn't looked this good in years — even a week after. Fully bespoke to my skin type and the products were genuinely premium. Worth every rupee and more.",                                              'color' => '#7c3aed'],
            ['name' => 'Sanjay R.', 'rating' => 5, 'created_at' => '2024-10-30', 'treatment' => 'Swedish Massage',    'text' => "My first spa experience and Serenity made it unforgettable. The Swedish massage was deeply relaxing, the environment thoughtful. I've been back twice already.",                                                  'color' => '#db2777'],
        ];
 		$city = "delhi";
		$metaTitle = "saloon Hub in Delhi | QuickDials";
		$metaDescription = "Find trusted saloon hubs in Delhi on QuickDials. Explore verified spa centres, wellness services, massage therapies, body treatments, and relaxation experts near you.";
		$keyword = "saloon hub in Delhi";

  	return view('client.saloon-hub', compact('spa','reviews','city','metaTitle','metaDescription','keyword'));
	}


	public function getZones($city_id)
	{

		$zones = DB::table('zones');
		$zones = $zones->join('citylists', 'citylists.id', '=', 'zones.city_id');
		$zones = $zones->where('citylists.city', $city_id);
		$zones = $zones->get();

		return response()->json($zones);
	}

	public function getAjaxLocation(Request $request)
	{

		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
 

		 $cid = trim($request->input('q'));


		$zoneResults = collect();

		if (!empty($cid)) {

			$zoneResults = DB::table('zones')
				->join('citylists', 'citylists.id', '=', 'zones.city_id')
				->where(function ($q) use ($cid) {
					$q->where('zones.zone', 'LIKE', "{$cid}%")
						->orWhere('citylists.city', 'LIKE', "{$cid}%")
						->orWhere('zones.city_id', $cid)
						->orWhere('zones.pincode', 'LIKE', "{$cid}%");
				})
				->select(
					'zones.id as zone_id',
					'zones.zone',
					'citylists.id as city_id',
					'citylists.city as cityName',
					'zones.pincode'
				)
				->orderBy('zones.zone', 'asc')
				->distinct()
				->get();

		} else {

			$defaultCities = collect([
				'Hyderabad',
				'Patna',
				'Gorakhpur',
				'Faridabad',
				'Delhi',
				'Noida',
				'Ghaziabad',
				'Mumbai',
				'Pune',
				'Meerut',
				'faridabad',
				'Indore',
				'Kanpur',
				'Chennai',
				'Kolkata',
				'Coimbatore',
				'Prayagraj'
			]);

			$zoneResults = DB::table('zones')
				->join('citylists', 'citylists.id', '=', 'zones.city_id')
				->whereIn('citylists.city', $defaultCities)
				->select(
					DB::raw('MIN(zones.id) as zone_id'),
					DB::raw('MIN(zones.zone) as zone'),
					'citylists.id as city_id',
					'citylists.city as cityName',
					DB::raw('NULL as pincode')
				)
				->groupBy('citylists.id', 'citylists.city')
				->orderBy('zone', 'asc')
				->orderBy('citylists.city')
				->get();
		}

		// -------- TRANSFORM USING COLLECTION --------
		$data = $zoneResults->map(function ($zone) {

			$cityDetails = collect([
				$zone->zone ?? null,
				$zone->cityName ?? null,
			])->filter()->implode(', ');

			if (!empty($zone->pincode)) {
				$cityDetails .= ' - ' . $zone->pincode;
			}

			return [
				'id' => $zone->zone_id,
				'city' => $zone->cityName,
				'cityDetails' => ucfirst($cityDetails)
			];

		})->unique('cityDetails')->values();

		return response()->json([
			'status' => true,
			'message' => 'Successfully',
			'data' => $data
		], 200);
		
	}

	public function getAjaxKeyword(Request $request)
	{

		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
	 
			$query = DB::table('keyword')
				->select('keyword.keyword', 'keyword.slug', 'keyword.id');
			$str = '';
			if ($request->input('q') != "") {
				$str = trim($request->input('q'));
				$query = $query->orWhere('keyword.keyword', 'LIKE', '%' . $str . '%');
				$query = $query->orderBy(DB::raw("CASE WHEN keyword.keyword LIKE '" . $str . "%' THEN 1 ELSE 2 END"));

				$query = $query->distinct()->get();
			}
			 
		
		return response()->json([
			'status' => true,
			'message' => 'Successfully',
			'data' => $query
		], 200);
		
	}





	

}
