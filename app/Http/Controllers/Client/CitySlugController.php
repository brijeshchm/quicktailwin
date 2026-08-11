<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Client;
use App\Models\Keyword;
use App\Helpers\BusinessOverviewGenerator;
use App\Models\Client\AssignedKWDS;
 
use App\Models\Citieslists;
use App\Models\City;
use App\Models\Blogdetails;
use App\Models\ChildCategory;
use App\Models\Lead;
use Session;
use App\Models\ParentCategory;
use App\Models\Client\Comment;
use App\Models\HomeSlider;
use Illuminate\Support\Facades\Cache;
class CitySlugController extends Controller
{
    /**
     * Fetch data from the QuickDials API.
     */
    private function fetchData(string $city, string $keyword): ?array
    {  
 
		$cityName = ucwords(str_replace('-', ' ', $city));
		//$keywordName = ucwords(str_replace('-', ' ', $search_kw));
		$city = strtolower(str_replace(' ', '-', trim($city)));
		$search_kw = strtolower(str_replace(' ', '-', trim($keyword)));


		$keywordDetails = DB::table('keyword')
			->leftjoin('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
			->leftjoin('child_category', 'keyword.child_category_id', '=', 'child_category.id')
		 
			->where('keyword.slug', $search_kw)
			->select('keyword.*', 'parent_category.*','child_category.*', 'keyword.id as key_id', 'keyword.faqq1', 'keyword.faqa1', 'keyword.faqq2', 'keyword.faqa2', 'keyword.faqq3', 'keyword.faqa3', 'keyword.faqq4', 'keyword.faqa4', 'keyword.faqq5', 'keyword.faqa5','keyword.faqq6', 'keyword.faqa6', 'keyword.faqq7', 'keyword.faqa7','keyword.faqq8', 'keyword.faqa8','keyword.faqq9', 'keyword.faqa9','keyword.faqq10', 'keyword.faqa10','keyword.meta_title', 'keyword.meta_description', 'keyword.h1_heading', 'keyword.top_description', 'keyword.bottom_description', 'keyword.ratingvalue', 'keyword.ratingcount','keyword.courseabout','keyword.heading','keyword.paragraph1','keyword.paragraph2','keyword.paragraph3','keyword.paragraph4','keyword.paragraph5','keyword.paragraph6','keyword.paragraph7','keyword.paragraph8','keyword.slug','keyword.bottom_heading','keyword.top_heading','keyword.extra_heading','keyword.extra_description')
			->first();
 
			 

		$courseabout ="";
		$heading ="";
		$paragraph1 ="";
		$paragraph2="";
		$paragraph3 ="";
		$paragraph4 ="";
		$paragraph5 ="";
		$paragraph6 ="";
		$paragraph7 ="";
		$paragraph8 ="";
		$meta_title ="";
		$h1_heading ="";
		$short_definition ="";
		$meta_description ="";
		$bottom_description = "";
		$top_description = "";
		$top_wcity_description ="";
		$top_wcity_heading ="";
		$bottom_wcity_heading ="";
		$bottom_wcity_description ="";
        if (!$keywordDetails) {
            return null;  
        }
	 

		$keywordBanners = [];
		if($keywordDetails){				 			
		   $keywordBanners = DB::table('keyword_banners')
			->where('keyword_id', $keywordDetails->key_id)
			->orderBy('sort_order')
			->get()
			->map(function ($b) {
				$b->image_url = $b->image_path ? asset($b->image_path) :'client/images/computer-courses-training.jpg';
				$b->alt_text  = $b->alt_text ?: 'Banner';
				$b->click_url = $b->client_slug ? '/businessdetails/' . $b->client_slug : null;
				return $b;
			})
			->values();
		}
	
		$category_banner = config('app.website') . 'client/images/computer-courses-training.jpg';

		$alt = "";

		$zones = DB::table('citylists')->join('zones', 'zones.city_id', '=', 'citylists.id')->where('citylists.city', 'LIKE', $city)->select('zones.id', 'zones.zone')->orderBy('zones.zone', 'asc')->distinct()->get();

		$firstZone = $zones->first();
		$area = $city;

		if ($firstZone) {
			$zone = $firstZone->zone ?? '';
			$pincode = $firstZone->pincode ?? '';
			$area = $city . ', ' . $zone;
			if (!empty($pincode)) {
				$area .= ' ' . $pincode;
			}
		}


		if (!empty($keywordDetails->category_banner)) {
			$cicons = unserialize($keywordDetails->category_banner);

			if (!empty($cicons)) {
				$category_banner = config('app.website') . $cicons['category_banner']['src'];
				$alt = $cicons['category_banner']['name'];
			}
		}
		$child_icon =config('app.website') . 'client/images/it_training.jpg';
		$key_icon =config('app.website') . 'client/images/it_training.jpg';
		$child_alt =$keywordDetails->keyword;
		
		if (!empty($keywordDetails->pc_icon)) {
			$childcons = unserialize($keywordDetails->pc_icon);
 
			if (!empty($childcons)) {
				$child_icon = config('app.website') . $childcons['pc_icon']['src'];
				$child_alt = $childcons['pc_icon']['name'];
			}
		}
		
		if (!empty($keywordDetails->icon)) {
			$keycons = json_decode($keywordDetails->icon);

			if (!empty($keycons)) {
				$key_icon = config('app.website') . $keycons->src;
				$child_alt = $keywordDetails->keyword;
			}
		}

		if (!empty($keywordDetails->meta_title)) {
			$meta_title = preg_replace('/{{city}}/i', ucfirst($city), $keywordDetails->meta_title);
		} else {
			$meta_title =  $keywordDetails->keyword . ' in ' . ucfirst($city) . ' | Quickdials';

		}
		if (!empty($keywordDetails->h1_heading)) {
			$h1_heading = preg_replace('/{{city}}/i', ucfirst($city), $keywordDetails->h1_heading);
		}  

		if (!empty($keywordDetails->short_definition)) {
			$short_definition = preg_replace('/{{city}}/i', ucfirst($city), $keywordDetails->short_definition);
		} 

		if (!empty($keywordDetails->top_wcity_description)) {
			$top_wcity_description = $keywordDetails->top_wcity_description;
		}  

		if (!empty($keywordDetails->top_wcity_heading)) {
			$top_wcity_heading = $keywordDetails->top_wcity_heading;
		}  

		if (!empty($keywordDetails->bottom_wcity_heading)) {
			$bottom_wcity_heading = $keywordDetails->bottom_wcity_heading;
		}  

		if (!empty($keywordDetails->bottom_wcity_description)) {
			$bottom_wcity_description = $keywordDetails->bottom_wcity_description;
		}  

		if (!empty($keywordDetails->meta_description)) {
			$meta_description = preg_replace('/{{city}}/i', ucfirst($city), $keywordDetails->meta_description);


		} else {
			$meta_description =  'Find the best ' . strtolower($keywordDetails->keyword) .
               ' in ' . ucfirst($city) .
               '. Compare ratings, reviews, contact details and book services on Quickdials.';

		}
		
		if (!empty($keywordDetails->courseabout)) {
			$courseabout = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->courseabout);
		}
		if (!empty($keywordDetails->heading)) {
			$heading = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->heading);
		}
		if (!empty($keywordDetails->paragraph1)) {
			$paragraph1 = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->paragraph1);
		}
		if (!empty($keywordDetails->paragraph2)) {
			$paragraph2 = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->paragraph2);
		}
		if (!empty($keywordDetails->paragraph3)) {
			$paragraph3 = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->paragraph3);
		}
		if (!empty($keywordDetails->paragraph4)) {
			$paragraph4 = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->paragraph4);
		}
		if (!empty($keywordDetails->paragraph5)) {
			$paragraph5 = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->paragraph5);
		}
		if (!empty($keywordDetails->paragraph6)) {
			$paragraph6 = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->paragraph6);
		}

		if (!empty($keywordDetails->paragraph7)) {
			$paragraph7 = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->paragraph7);
		}


		if (!empty($keywordDetails->paragraph8)) {
			$paragraph8 = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->paragraph8);
		}
	
		if (!empty($keywordDetails->top_description)) {
			$top_description = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->top_description);
		}
		
		if (!empty($keywordDetails->bottom_description)) {
			$bottom_description = preg_replace('/{{city}}/i', ucfirst($area), $keywordDetails->bottom_description);
		}
		 

		 

		$data['keyword'] = array(
			'keyword' => $keywordDetails->keyword,
			'keyword_slug' => generate_slug($keywordDetails->keyword),
			'category_banner' => $category_banner,
			'child_icon' => $child_icon,
			'child_alt' => $child_alt,
			'key_icon' => $key_icon,
			'key_alt' => $child_alt,
			'alt' => $alt,
			'meta_title' => $meta_title,
			'h1_heading' => $h1_heading,
			'short_definition' => $short_definition,
			'meta_description' => $meta_description,
			'top_description' => $top_description,
			'bottom_description' => $bottom_description,
			'top_wcity_description' => $top_wcity_description,
			'top_wcity_heading' => $top_wcity_heading,
			'bottom_wcity_heading' => $bottom_wcity_heading,
			'bottom_wcity_description' => $bottom_wcity_description,
			'courseabout' => $courseabout,
			'heading' => $heading,
			'paragraph1' => $paragraph1,
			'paragraph2' => $paragraph2,
			'paragraph3' => $paragraph3,
			'paragraph4' => $paragraph4,
			'paragraph5' => $paragraph5,
			'paragraph6' => $paragraph6,			 
			'paragraph7' => $paragraph7,			 
			'paragraph8' => $paragraph8,			 
			'bottom_heading' => preg_replace('/{{city}}/i', ucfirst($city), $keywordDetails->bottom_heading),
			'top_heading' => preg_replace('/{{city}}/i', ucfirst($city), $keywordDetails->top_heading),
			'extra_heading' => preg_replace('/{{city}}/i', ucfirst($city), $keywordDetails->extra_heading),
			'extra_description' => preg_replace('/{{city}}/i', ucfirst($city), $keywordDetails->extra_description),
			'faqq1' => $keywordDetails->faqq1,
			'faqa1' => $keywordDetails->faqa1,
			'faqq2' => $keywordDetails->faqq2,
			'faqa2' => $keywordDetails->faqa2,
			'faqq3' => $keywordDetails->faqq3,
			'faqa3' => $keywordDetails->faqa3,
			'faqq4' => $keywordDetails->faqq4,
			'faqa4' => $keywordDetails->faqa4,
			'faqq5' => $keywordDetails->faqq5,
			'faqa5' => $keywordDetails->faqa5,
			'faqq6' => $keywordDetails->faqq6,
			'faqa6' => $keywordDetails->faqa6,

			'faqq7' => $keywordDetails->faqq7,
			'faqa7' => $keywordDetails->faqa7,

			'faqq8' => $keywordDetails->faqq8,
			'faqa8' => $keywordDetails->faqa8,

			'faqq9' => $keywordDetails->faqq9,
			'faqa9' => $keywordDetails->faqa9,

			'faqq10' => $keywordDetails->faqq10,
			'faqa10' => $keywordDetails->faqa10,

			'ratingvalue' => $keywordDetails->ratingvalue,
			'ratingcount' => $keywordDetails->ratingcount,
			'parent_category' => $keywordDetails->parent_category,
			'parent_slug' => $keywordDetails->parent_slug,
			'child_category' => $keywordDetails->child_category,
			'child_slug' => $keywordDetails->child_slug,
			'zone' => $zones,
			'city' => $cityName,
			'area' => $area,
			'keywordBanners' => $keywordBanners,

		);

 


		$clientsList = DB::table('clients')
			->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id')
			->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
			->leftJoin(DB::raw('(
        SELECT SUM(rating) AS rating, comment_client_ID, COUNT(comment_ID) AS comment_count
        FROM comments GROUP BY comment_client_ID
    ) c'), 'c.comment_client_ID', '=', 'clients.id')
			->select(
				'clients.id as business_id',
				'clients.business_name',
				'clients.category_service',
				'clients.verified',			 
				'clients.gst_status',
				'clients.active_status',
				'clients.trending',			 
				'clients.topSearch',			 
				'clients.trusted_status',
				'clients.featured',
				'clients.openUntil',
				'clients.address',
				'clients.year_of_estb',
				'clients.certified_status',
				'clients.certifications',
				'clients.business_slug',
				'clients.client_type',			 
				'clients.pictures',			 
				'clients.logo',			 
				'clients.city',			 
				'clients.state',			 
				'clients.pincode',			 
				'clients.landmark',			 
				'clients.business_description',			 
				'citylists.city',
				'keyword.keyword as keywords',
				'keyword.slug as slugs',
				DB::raw('COALESCE(c.rating,0) as rating'),
				DB::raw('COALESCE(c.comment_count,0) as comment_count')
			)
			->where('citylists.city', $city)
			 ->where('clients.active_status', '1')
			->where('keyword.slug', $search_kw)
			 ->groupBy('clients.id')			 
			->orderByRaw("
        CASE clients.client_type
            WHEN 'platinum' THEN 1
            WHEN 'diamond' THEN 2
            WHEN 'gold' THEN 3
            WHEN 'silver' THEN 4
            ELSE 5
        END
    ")
			->limit(20)->get();

		$data['clientsList'] = $clientsList->map(function ($client) {

			$logoImage = config('app.website') . 'client/images/default_pp_small.png';
			$altLogo = "Business Logo";
			if (!empty($client->logo)) {
				$cicons = unserialize($client->logo);
				if (!empty($cicons)) {
					$logoImage = config('app.website') . $cicons['large']['src'];
					$altLogo = $cicons['large']['name'];
				}
			}


			$galleryArray = array();
			if (!empty($client->pictures)) {
				$galleryList = unserialize($client->pictures);
				if (!empty($galleryList)) {
					foreach ($galleryList as $key => $value) {

						$galleryArray[$key] = array(
							'galley' => $value

						);

					}
				}
			}
			$certified_img = config('app.website') . 'img/q_verified.gif';
			$trusted_img = config('app.website') . 'img/q_trust.gif';
			$gst_img = config('app.website') . 'img/q_gst.gif';
		 
            $avgRating = ($client->rating && $client->comment_count > 0)
            ? number_format($client->rating / $client->comment_count, 1)
            : "0";


			$assignedKeywords = DB::table('assigned_kwds')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->where('assigned_kwds.client_id', $client->business_id)
				->orderBy('keyword', 'asc')
				->distinct()
				->limit(10)
				->pluck('keyword.keyword', 'keyword.slug')
				->toArray();

			$assignedCategory = DB::table('assigned_kwds')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->where('assigned_kwds.client_id', $client->business_id)
				->orderBy('child_category', 'asc')
				->distinct()
				->limit(10)
				->pluck('child_category.child_category', 'child_category.child_slug')
				->toArray();
				
				
					$workingHoursHtml = '10AM to 7PM';
					$categorySlug = $client->category_service;

					  $template = BusinessOverviewGenerator::generate(
                        $client,
                        $workingHoursHtml,
                        $categorySlug
                    );
						 	
				
			return [
				'business_id' => $client->business_id,
				'business_name' => $client->business_name,
				'business_slug' => $client->business_slug,
				'logo' => $logoImage ?? '',
				'altLogo' => $altLogo ?? '',
				'gallery' => $galleryArray ?? '',
				'certifications' => $client->certifications,				 
				'certified_status' => $client->certified_status,
				'trusted_status' => $client->trusted_status,
				'gst_status' => $client->gst_status,
				'certified_img' => $certified_img,
				'trusted_img' => $trusted_img,
				'gst_img' => $gst_img,			 
				'city' => $client->city ??'faridabad',	 		 
				'state' => $client->state ?? 'Karnataka',	 		 
				'pincode' => !empty($client->pincode) ? $client->pincode : '560008',		 
				'landmark' => $client->landmark ??'OLD AIRPORT RD',	 		 
				'verified' => $client->verified ,
				'active_status' => $client->active_status,
				'trending' => $client->trending,			 
				'topSearch' => $client->topSearch,
				'featured' => $client->featured,				 
				'mapUrl' => "https://maps.google.com/?q=" . generate_slug($client->address),				 
				'address' => $client->address,			 
				'established' => $client->year_of_estb,			 
				'rating' => $client->rating,
				'avgRating' => $avgRating,
				'call' => "917559435943",
				'whatsapp' => "917559435943",
				'reviewCount' => $client->comment_count,
				'tags' => $assignedKeywords,
				'category' => $assignedCategory ?? null,
				'businessDescription' => $client->business_description ?? $template ?? null,
			];
		});
 
	$clientsAgents = DB::table('clients')
    ->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
    ->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
    ->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id')
    ->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
    ->leftJoin(DB::raw('(
        SELECT comment_client_ID,
               SUM(rating)        AS rating,
               AVG(rating)        AS avg_rating,
               COUNT(comment_ID)  AS comment_count
        FROM comments
        GROUP BY comment_client_ID
    ) c'), 'c.comment_client_ID', '=', 'clients.id')
    ->select(
       
		'clients.id as business_id',
		'clients.business_name',
		'clients.category_service',
		'clients.verified',
		'clients.year_of_estb',
		'clients.gst_status',
		'clients.active_status',
		'clients.trusted_status',
		'clients.certified_status',
		'clients.trending',
		'clients.topSearch',
		'clients.openUntil',
		'clients.year_of_estb',
		'clients.address',
		'clients.featured',	 
		'clients.business_slug',
		'clients.client_type',			 
		'citylists.city',  
        DB::raw('MIN(citylists.city)    as city'),
        DB::raw('MIN(keyword.keyword)   as keywords'),
        DB::raw('MIN(keyword.slug)      as slugs'),
        'c.rating',
        'c.avg_rating',
        'c.comment_count'
    )
	 ->where('citylists.city', $city)
    ->where('clients.active_status', '1')
    ->where('keyword.slug', $search_kw)
    ->groupBy('clients.id')
    ->orderByRaw("
        CASE clients.client_type
            WHEN 'platinum' THEN 1
            WHEN 'diamond'  THEN 2
            WHEN 'gold'     THEN 3
            WHEN 'silver'   THEN 4
            ELSE 5
        END
    ")
    ->limit(5)
    ->get();
 
		$data['agents'] = $clientsAgents->map(function ($client) {

			$logoImage = config('app.website') . 'client/images/default_pp_small.png';
			$altLogo = "Business Logo";
			if (!empty($client->logo)) {
				$cicons = unserialize($client->logo);
				if (!empty($cicons)) {
					$logoImage = config('app.website') . $cicons['large']['src'];
					$altLogo = $cicons['large']['name'];
				}
			}


			$galleryArray = array();
			if (!empty($client->pictures)) {
				$galleryList = unserialize($client->pictures);
				if (!empty($galleryList)) {
					foreach ($galleryList as $key => $value) {

						$galleryArray[$key] = array(
							'galley' => $value

						);

					}
				}
			}
			$certified_img = config('app.website') . 'img/q_verified.gif';
			$trusted_img = config('app.website') . 'img/q_trust.gif';
			$gst_img = config('app.website') . 'img/q_gst.gif';
			$avgRating = "0";
			if ($client->rating) {
				$avgRating = ($client->rating / (5 * $client->comment_count)) * 5;
				$avgRating = number_format($avgRating, 1, '.', '');
			}


			$assignedKeywords = DB::table('assigned_kwds')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->where('assigned_kwds.client_id', $client->business_id)
				->orderBy('keyword', 'asc')
				->distinct()
				->limit(10)
				->pluck('keyword.keyword', 'keyword.slug')
				->toArray();

			$assignedCategory = DB::table('assigned_kwds')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->where('assigned_kwds.client_id', $client->business_id)
				->orderBy('child_category', 'asc')
				->distinct()
				->limit(10)
				->pluck('child_category.child_category', 'child_category.child_slug')
				->toArray();
				
				
					$workingHoursHtml = '10AM to 7PM';
					$categorySlug = $client->category_service;

					 

                     $template = BusinessOverviewGenerator::generate(
                        $client,
                        $workingHoursHtml,
                        $categorySlug
                    );
				 
			return [
				'business_id' => $client->business_id,
				'business_name' => $client->business_name,
				'business_slug' => $client->business_slug,			 
				'certified_status' => $client->certified_status,
				'trusted_status' => $client->trusted_status,
				'gst_status' => $client->gst_status,
				'certified_img' => $certified_img,
				'trusted_img' => $trusted_img,
				'gst_img' => $gst_img,				 
				'city' => $client->city,			 
				'verified' => $client->verified,
				'trending' => $client->trending,
				'topSearch' => $client->topSearch,
				'featured' => $client->featured,			 
				'mapUrl' => "https://maps.google.com/?q=" . generate_slug($client->address),				 
				'address' => $client->address,			 
				'year_of_estb' => $client->year_of_estb,			
				'rating' => $client->rating,
				'avgRating' => $avgRating,
				'call' => "917559435943",
				'whatsapp' => "917559435943",
				'comment_count' => $client->comment_count,
				'tags' => $assignedKeywords,
				'category' => $assignedCategory ?? null,
				'businesDescription' => $template ?? null,

			];
		});


		$servicesRelated = Keyword::where('child_category_id', $keywordDetails->child_category_id)
			->where('parent_category_id', $keywordDetails->parent_category_id)
			->select('keyword', 'icon', 'slug','meta_description')
			->orderBy('keyword', 'asc')
			->distinct()
			->get();

		$servicesRelatedList = $servicesRelated->map(function ($keyword) use ($cityName){
			$img = "";
			$alt = "";
 
			if (!empty($keyword->icon)) {

				$data = json_decode($keyword->icon, true);
				if (is_array($data) && !empty($data['src'])) {
					$img = config('app.website') . $data['src'];
					$alt = $data['name'] ?? $keyword->keyword;
				}

			}

			return [
				'url' =>$keyword->slug,
				'img' => $img,
				'alt' => $alt,
				'title' => $keyword->keyword. ' in ' .$cityName ?: 'faridabad',
				'keyword' => $keyword->keyword,
				'type' => 'keyword',
				'city_slug' => strtolower($cityName) ?: 'faridabad',
				'meta_description' => replaceCity($keyword->meta_description, $cityName),
			];
		})->values()->toArray();

		$data['servicesRelated'] = $servicesRelatedList;

		$cities = City::where('popular', '1')->get();
		$cityList = array();
		if ($cities) {
			foreach ($cities as $ckey => $cvalue) {

				$cityList[$ckey] = array(
					'url' => '/' . strtolower($cvalue->city) . '/' . $keywordDetails->slug,
					'title' => $keywordDetails->keyword . ' in ' . $cvalue->city,

				);

			}
		}



		$defaultLogo = config('app.website') . 'client/images/default_pp_small.png';
$businessIds = $data['clientsList']->pluck('business_id');

 

$reviewList = DB::table('clients')
    ->leftJoin(DB::raw('(
        SELECT
            comment_client_ID,
            SUM(rating)        AS total_rating,
            COUNT(comment_ID)  AS comment_count,
            MAX(comment_author)  AS comment_author,
            MAX(comment_content) AS comment_content
        FROM comments
        GROUP BY comment_client_ID
    ) c'), 'c.comment_client_ID', '=', 'clients.id')
    ->select(
        'clients.id as business_id',
        'clients.business_slug',
        'clients.business_name',
        'clients.logo',
        'clients.client_type',
        DB::raw('COALESCE(c.total_rating, 0) as rating'),
        DB::raw('COALESCE(c.comment_count, 0) as comment_count'),
        'c.comment_author',
        'c.comment_content'
    )
    ->whereIn('clients.id', $businessIds)
    ->where('clients.active_status', '1')
    ->whereNotNull('c.comment_content')
    ->orderByRaw("
        CASE clients.client_type
            WHEN 'platinum' THEN 1
            WHEN 'diamond'  THEN 2
            WHEN 'gold'     THEN 3
            WHEN 'silver'   THEN 4
            ELSE 5
        END
    ")
    ->get()
    ->map(function ($business) use ($defaultLogo) {

        $cicons = @unserialize($business->logo);

        if ($cicons !== false && isset($cicons['large']['src'], $cicons['large']['name'])) {
            $business->logo_image = config('app.website') . $cicons['large']['src'];
            $business->alt_logo   = $cicons['large']['name'];
        } else {
            $business->logo_image = $defaultLogo;
            $business->alt_logo   = 'Business Logo';
        }

        $business->avg_rating = $business->comment_count > 0
            ? round($business->rating / $business->comment_count, 1)
            : 0;

        unset($business->logo);

        return $business;
    });

    $data['reviewList'] = $reviewList;


    $data['findOtherLocation'] = $cityList;



		 $relatedCategory = DB::table('keyword')
    ->join('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
    ->join('child_category', 'child_category.parent_category_id', '=', 'parent_category.id')
    ->where('keyword.slug', $search_kw)
    ->orderBy('child_category.child_category', 'asc')
    ->distinct()
    ->pluck('child_category.child_category', 'child_category.child_slug')
    ->toArray();


		$data['relatedCategory'] = $relatedCategory;
	
        return $data;
	 

    }

    

    /*
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
    

    /*
     * Check if a city exists, by slug.
     */
    private function cityExists(string $city): bool
    {
        // $citySlug = strtolower(trim($city));
        // if (empty($citySlug)) {
        //     return false;
        // }
        // return Cache::remember("city_exists_{$citySlug}", 3600, function () use ($citySlug) {
        //     return DB::table('citylists')
        //         ->where('city_slug', $citySlug)
        //         ->exists();
        // });


		$citySlug = trim(strtolower($city));

		return Cache::remember("city_exists_{$citySlug}", 3600, function () use ($citySlug) {
			return DB::table('citylists')
				->where(function ($query) use ($citySlug) {
					$query->where('city_slug', $citySlug)          // Exact match
						->orWhere('city_slug', 'LIKE', "%{$citySlug}%"); // Partial match
				})
				->exists();
		});


    }

 
    /**
     * Check if a city is valid via the QuickDials city-check API.
     */
    private function serviceExists(string $slug): bool
    {
        $search_kw = strtolower(str_replace(' ', '-', trim($slug)));
        $exists = DB::table('keyword')
            ->where('keyword.slug', $search_kw)
            ->exists();
        return $exists;
    }

    /**
     * Fetch data from the QuickDials API.
     */
    private function fetchKeywordData(string $slug): ?array
    {
        $search_kw = strtolower(str_replace(' ', '-', trim($slug)));
		$city = '';

		$keywordDetails = DB::table('keyword')
			->leftjoin('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
			->leftjoin('child_category', 'keyword.child_category_id', '=', 'child_category.id')
			->where('slug', $search_kw)
			->select('keyword.*', 'parent_category.*', 'child_category.*', 'keyword.id as key_id', 'keyword.faqq1', 'keyword.faqa1', 'keyword.faqq2', 'keyword.faqa2', 'keyword.faqq3', 'keyword.faqa3', 'keyword.faqq4', 'keyword.faqa4', 'keyword.faqq5', 'keyword.faqa5','keyword.faqq6','keyword.faqa6','keyword.faqq7','keyword.faqa7','keyword.faqq8','keyword.faqa8','keyword.faqq9','keyword.faqa9','keyword.faqq10','keyword.faqa10','keyword.meta_title', 'keyword.meta_description', 'keyword.h1_heading', 'keyword.top_description', 'keyword.bottom_description', 'keyword.ratingvalue', 'keyword.ratingcount','keyword.courseabout','keyword.heading','keyword.paragraph1','keyword.paragraph2','keyword.paragraph3','keyword.paragraph4','keyword.paragraph5','keyword.paragraph6','keyword.paragraph7','keyword.paragraph8','keyword.slug','keyword.bottom_heading','keyword.top_heading','keyword.extra_heading','keyword.extra_description'
			)
			->first();
		 
			$courseabout ="";
			$heading ="";
			$h1_heading ="";
			$short_definition ="";
			$top_wcity_description ="";
			$top_wcity_heading ="";
			$bottom_wcity_heading ="";
			$bottom_wcity_description ="";
			$paragraph1 ="";
			$paragraph2="";
			$paragraph3 ="";
			$paragraph4 ="";
			$paragraph5 ="";
			$paragraph6 ="";
			$paragraph7 ="";
			$paragraph8 ="";

			if(!$keywordDetails){
				return  null;
			}
		$category_banner = config('app.website') . 'client/images/computer-courses-training.jpg';
		$child_icon =config('app.website') . 'client/images/it_training.jpg';
		$key_icon =config('app.website') . 'client/images/it_training.jpg';
		$child_alt =$keywordDetails->keyword;
		$alt = "";

		if (!empty($keywordDetails->category_banner)) {
			$cicons = unserialize($keywordDetails->category_banner);

			if (!empty($cicons)) {
				$category_banner = config('app.website') . $cicons['category_banner']['src'];
				$alt = $cicons['category_banner']['name'];
			}
		}
		
		if (!empty($keywordDetails->pc_icon)) {
			$childcons = unserialize($keywordDetails->pc_icon);

			if (!empty($childcons)) {
				$child_icon = config('app.website') . $childcons['pc_icon']['src'];
				$child_alt = $childcons['pc_icon']['name'];
			}
		}
		
		if (!empty($keywordDetails->icon)) {
			$keycons = json_decode($keywordDetails->icon);

			if (!empty($keycons)) {
				$key_icon = config('app.website') . $keycons->src;
				$key_alt = $keywordDetails->keyword;
			}
		}

		if (!empty($keywordDetails->meta_title)) {
			$meta_title = replaceCity($keywordDetails->meta_title,'');
		} else {
			$meta_title = 'Best ' . $keywordDetails->keyword . ' - Reviews, Ratings & Contact Details | Quickdials';

		}
		if (!empty($keywordDetails->h1_heading)) {
			$h1_heading = replaceCity($keywordDetails->h1_heading,'');
		}  

		if (!empty($keywordDetails->short_definition)) {
			$short_definition = replaceCity($keywordDetails->short_definition,'');
		}  

		if (!empty($keywordDetails->top_wcity_description)) {
			$top_wcity_description = $keywordDetails->top_wcity_description;
		}  

		if (!empty($keywordDetails->top_wcity_heading)) {
			$top_wcity_heading = $keywordDetails->top_wcity_heading;
		}  

		if (!empty($keywordDetails->bottom_wcity_heading)) {
			$bottom_wcity_heading = $keywordDetails->bottom_wcity_heading;
		}  

		if (!empty($keywordDetails->bottom_wcity_description)) {
			$bottom_wcity_description = $keywordDetails->bottom_wcity_description;
		}  

		if (!empty($keywordDetails->meta_description)) {
			$meta_description = replaceCity($keywordDetails->meta_description,'');
		} else {
			$meta_description = 'Find the best ' . strtolower($keywordDetails->keyword) . '. Compare ratings, reviews, contact details and service information on Quickdials.';
		}
	
		$top_description = "";
		if (!empty($keywordDetails->top_description)) {
			$top_description = replaceCity($keywordDetails->top_description,'');
		}
		$bottom_description = "";
		if (!empty($keywordDetails->bottom_description)) {
			$bottom_description = replaceCity($keywordDetails->bottom_description,'');
		}
		
		if (!empty($keywordDetails->courseabout)) {
			$courseabout = replaceCity($keywordDetails->courseabout,'');
		}
		
		if (!empty($keywordDetails->heading)) {
			$heading = replaceCity($keywordDetails->heading,'');
		}
		if (!empty($keywordDetails->paragraph1)) {
			$paragraph1 = replaceCity($keywordDetails->paragraph1,'');
		}
		if (!empty($keywordDetails->paragraph2)) {
			$paragraph2 = replaceCity($keywordDetails->paragraph2,'');
		}
		if (!empty($keywordDetails->paragraph3)) {
			$paragraph3 = replaceCity($keywordDetails->paragraph3,'');
		}
		if (!empty($keywordDetails->paragraph4)) {
			$paragraph4 = replaceCity($keywordDetails->paragraph4,'');
		}
		if (!empty($keywordDetails->paragraph5)) {
			$paragraph5 = replaceCity($keywordDetails->paragraph5,'');
		}
		if (!empty($keywordDetails->paragraph6)) {
			$paragraph6 = replaceCity($keywordDetails->paragraph6,'');
		}
		if (!empty($keywordDetails->paragraph7)) {
			$paragraph7 = replaceCity($keywordDetails->paragraph7,'');
		}
		if (!empty($keywordDetails->paragraph8)) {
			$paragraph8 = replaceCity($keywordDetails->paragraph8,'');
		}

		$data['keyword'] = array(
			'keyword' => $keywordDetails->keyword,
			'keyword_slug' => $keywordDetails->slug,
			'category_banner' => $category_banner,
			'alt' => $alt,
			'child_icon' => $child_icon,
			'child_alt' => $child_alt,
			'key_icon' => $key_icon,
			'key_alt' => $child_alt,
			'meta_title' => $meta_title,
			'h1_heading' => $h1_heading,
			'short_definition' => $short_definition,
			'top_wcity_description' => $top_wcity_description,
			'top_wcity_heading' => $top_wcity_heading,
			'bottom_wcity_heading' => $bottom_wcity_heading,
			'bottom_wcity_description' => $bottom_wcity_description,
			'meta_description' => $meta_description,
			'top_description' => $top_description,
			'bottom_description' => $bottom_description,	
			'bottom_heading'    => replaceCity($keywordDetails->bottom_heading, $city),
			'top_heading'       => replaceCity($keywordDetails->top_heading, $city),
			'extra_heading'     => replaceCity($keywordDetails->extra_heading, $city),
			'extra_description' => replaceCity($keywordDetails->extra_description, $city),

			'courseabout' => replaceCity($courseabout, $city),

			'heading' => $heading,
			'paragraph1' => $paragraph1,
			'paragraph2' => $paragraph2,
			'paragraph3' => $paragraph3,
			'paragraph4' => $paragraph4,
			'paragraph5' => $paragraph5,
			'paragraph6' => $paragraph6,
			'paragraph7' => $paragraph7,
			'paragraph8' => $paragraph8,
 		
			'ratingvalue' => $keywordDetails->ratingvalue,
			'ratingcount' => $keywordDetails->ratingcount,
			'parent_category' => $keywordDetails->parent_category,
			'parent_slug' => $keywordDetails->parent_slug,
			'child_category' => $keywordDetails->child_category,
			'child_slug' => $keywordDetails->child_slug,

		);

		for ($i = 1; $i <= 10; $i++) {
		$data['keyword']["faqq{$i}"] = replaceCity($keywordDetails->{"faqq{$i}"}, $city);
		$data['keyword']["faqa{$i}"] = replaceCity($keywordDetails->{"faqa{$i}"}, $city);
		}

		$keywordName = ucwords(str_replace('-', ' ', $search_kw));


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
				'clients.id as business_id',
				'clients.business_name',
				'clients.category_service',
				'clients.verified',			 
				'clients.gst_status',
				'clients.active_status',
				'clients.trending',			 
				'clients.topSearch',			 
				'clients.trusted_status',
				'clients.featured',
				'clients.openUntil',
				'clients.address',
				'clients.year_of_estb',
				'clients.certified_status',
				'clients.certifications',
				'clients.business_slug',
				'clients.client_type',			 
				'clients.city',		
				'clients.state',		
				'clients.pincode',		
				'clients.logo',		
				'clients.business_description',		
				'clients.pictures',		
				
				'keyword.keyword as keywords',
				'keyword.slug as slugs',
				DB::raw('MAX(c.rating) as rating'),
				DB::raw('MAX(c.comment_count) as comment_count')
			)

			->where('keyword.keyword', 'LIKE', "%{$keywordName}%")
			->where('clients.active_status', '1')
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

			->get();


		$data['clientsList'] = $clientsList->map(function ($client) {

			$logoImage = config('app.website') . 'client/images/default_pp_small.png';
			$altLogo = "Business Logo";
			if (!empty($client->logo)) {
				$cicons = unserialize($client->logo);

				if (!empty($cicons)) {
					$logoImage = config('app.website') . $cicons['large']['src'];
					$altLogo = $cicons['large']['alt'];
				}
			}

		 

				 
				$assignedKeywords = DB::table('assigned_kwds')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->where('assigned_kwds.client_id', $client->business_id)
				->orderBy('keyword', 'asc')
				->distinct()
				->limit(10)
				->pluck('keyword.keyword', 'keyword.slug')
				->toArray();


				$assignedCategory = DB::table('assigned_kwds')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->where('assigned_kwds.client_id', $client->business_id)
				->orderBy('child_category', 'asc')
				->distinct()
				->limit(10)
				->pluck('child_category.child_category', 'child_category.child_slug')
				->toArray();
 

			$galleryArray = array();
			if (!empty($client->pictures)) {
				$galleryList = unserialize($client->pictures);
				if (!empty($galleryList)) {
					foreach ($galleryList as $key => $value) {

						$galleryArray[$key] = array(
							'galley' => $value
						);
					}
				}
			}
			$certified_img = config('app.website') . 'img/q_verified.gif';
			$trusted_img = config('app.website') . 'img/q_trust.gif';
			$gst_img = config('app.website') . 'img/q_gst.gif';
			 
			

              $avgRating = ($client->rating && $client->comment_count > 0)
            ? number_format($client->rating / $client->comment_count, 1)
            : "0";

			$workingHoursHtml = '10AM to 7PM ';
            $categorySlug = $client->category_service;
                $template = BusinessOverviewGenerator::generate(
                $client,
                $workingHoursHtml,
                $categorySlug
            );
					
			return [
				'business_id' => $client->business_id,
				'business_name' => $client->business_name,
				'business_slug' => $client->business_slug,
				'logo' => $logoImage ?? '',
				'altLogo' => $altLogo ?? '',
				'gallery' => $galleryArray ?? '',
	 
				 
				'certified_status' => $client->certified_status,
				'trusted_status' => $client->trusted_status,
				'gst_status' => $client->gst_status,
				 
				'certified_img' => $certified_img,
				'trusted_img' => $trusted_img,
				'gst_img' => $gst_img,
			 
				'verified' => $client->verified,
				'trending' => $client->trending,
				'topSearch' => $client->topSearch,
				'featured' => $client->featured,			 
				'city' => $client->city ??'faridabad',	 		 
				'state' => $client->state ?? 'Karnataka',	 		 
				'pincode' => !empty($client->pincode) ? $client->pincode : '560008',		 
				'landmark' => $client->landmark ??'OLD AIRPORT RD',	 				 
				'address' => $client->address,			 
				'year_of_estb' => $client->year_of_estb,
	 
				'mapUrl' => "https://maps.google.com/?q=" . generate_slug($client->address),
				'whatsapp' => '7559435943',
				'call' => '917559435943',
				'rating' => $client->rating,
				'openUntil' => $client->openUntil,
				'avgRating' => $avgRating,				 	
                'reviewCount' => $client->comment_count,
				'tags' => $assignedKeywords ?? null,
				'category' => $assignedCategory ?? null,
			 
				'businessDescription' => $client->business_description ?? $template ?? null,
			];
		});

	$clientsAgents = DB::table('clients')
    ->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
    ->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
    ->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id')
    ->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
    ->leftJoin(DB::raw('(
        SELECT SUM(rating) AS rating,
               AVG(rating) AS avg_rating,
               comment_client_ID,
               COUNT(comment_ID) AS comment_count
        FROM comments
        GROUP BY comment_client_ID
    ) c'), 'c.comment_client_ID', '=', 'clients.id')
    ->select(
        'clients.id as business_id',
				'clients.business_name',
				'clients.category_service',
				'clients.verified',			 
				'clients.gst_status',
				'clients.active_status',
				'clients.trending',			 
				'clients.topSearch',			 
				'clients.trusted_status',
				'clients.featured',
				'clients.openUntil',
				'clients.address',
				'clients.year_of_estb',
				'clients.certified_status',
				'clients.certifications',
				'clients.business_slug',
				'clients.client_type',			 
				'clients.state',			 
				'clients.area',			 
				'clients.zone',			 
				'clients.pincode',			 
				'clients.country',			 
				'clients.landmark',			 
				 
        
     
        'citylists.city',
        'keyword.keyword as keywords',
        'keyword.slug as slugs',
        'clients.client_type',
        'c.rating',
        'c.avg_rating',
        'c.comment_count'
    )
    
    ->where('clients.active_status', '1')
    ->where('keyword.slug', $search_kw)
	->groupBy('clients.id')
    ->orderByRaw("
        CASE clients.client_type
            WHEN 'platinum' THEN 1
            WHEN 'diamond'  THEN 2
            WHEN 'gold'     THEN 3
            WHEN 'silver'   THEN 4
            ELSE 5
        END
    ")
    ->limit(5)
    ->get();


		$data['agents'] = $clientsAgents->map(function ($client) {

			$logoImage = config('app.website') . 'client/images/default_pp_small.png';
			$altLogo = "Business Logo";
			if (!empty($client->logo)) {
				$cicons = unserialize($client->logo);

				if (!empty($cicons)) {
					$logoImage = config('app.website') . $cicons['large']['src'];
					$altLogo = $cicons['large']['alt'];
				}
			}

			$assignedKeywords = DB::table('assigned_kwds')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->where('assigned_kwds.client_id', $client->business_id)
				->orderBy('keyword', 'asc')
				->distinct()
				->limit(10)
				->pluck('keyword.keyword', 'keyword.slug')
				->toArray();


				$assignedCategory = DB::table('assigned_kwds')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->where('assigned_kwds.client_id', $client->business_id)
				->orderBy('child_category', 'asc')
				->distinct()
				->limit(10)
				->pluck('child_category.child_category', 'child_category.child_slug')
				->toArray();
 

			$galleryArray = array();
			if (!empty($client->pictures)) {
				$galleryList = unserialize($client->pictures);
				if (!empty($galleryList)) {
					foreach ($galleryList as $key => $value) {

						$galleryArray[$key] = array(
							'galley' => $value
						);
					}
				}
			}
			$certified_img = config('app.website') . 'img/q_verified.gif';
			$trusted_img = config('app.website') . 'img/q_trust.gif';
			$gst_img = config('app.website') . 'img/q_gst.gif';
			$avgRating = "0";
			if ($client->rating) {
				$avgRating = ($client->rating / (5 * $client->comment_count)) * 5;
				$avgRating = number_format($avgRating, 1, '.', '');
			}
			
			$workingHoursHtml = '10AM to 7PM';
			$categorySlug = $client->category_service;

			  $template = BusinessOverviewGenerator::generate(
                        $client,
                        $workingHoursHtml,
                        $categorySlug
                    );
			return [
				'business_id' => $client->business_id,
				'business_name' => $client->business_name,
				'business_slug' => $client->business_slug,
				'logo' => $logoImage ?? '',
				'altLogo' => $altLogo ?? '',
				'gallery' => $galleryArray ?? '',
				'certifications' => $client->certifications,			 
				'certified_status' => $client->certified_status,
				'trusted_status' => $client->trusted_status,
				'gst_status' => $client->gst_status,			 
				'certified_img' => $certified_img,
				'trusted_img' => $trusted_img,
				'gst_img' => $gst_img,			 
				'verified' => $client->verified,
				'trending' => $client->trending,
				'topSearch' => $client->topSearch,
				'featured' => $client->featured,				 
			 
				 
				'area' => $client->area,
				'zone' => $client->zone,
				'address' => $client->address,		 
				'country' => $client->country,
				'year_of_estb' => $client->year_of_estb,
				 
				'city' => $client->city ??'faridabad',	 		 
				'state' => $client->state ?? 'Karnataka',	 		 
				'pincode' => !empty($client->pincode) ? $client->pincode : '560008',		 
				'landmark' => $client->landmark ??'OLD AIRPORT RD',	 
				'mapUrl' => "https://maps.google.com/?q=" . generate_slug($client->address),
				'whatsapp' => '7559435943',
				'call' => '917559435943',
				'rating' => $client->rating,
				'openUntil' => $client->openUntil,
				'avgRating' => $avgRating,
				'comment_count' => $client->comment_count,				 
				'tags' => $assignedKeywords ?? null,
				'category' => $assignedCategory ?? null,
				'overviewBusiness' => $template ?? null,
			];
		});


		$servicesRelated = Keyword::where('child_category_id', $keywordDetails->child_category_id)
			->where('parent_category_id', $keywordDetails->parent_category_id)
			->select('keyword', 'icon', 'slug')
			->orderBy('keyword', 'asc')
			->distinct()
			->get();

		$servicesRelatedList = $servicesRelated->map(function ($keyword) {
			$img = "";
			$alt = "";

			if (!empty($keyword->icon)) {

				$data = json_decode($keyword->icon, true);
				if (is_array($data) && !empty($data['src'])) {
					$img = config('app.website') . $data['src'];
					$alt = $data['alt'] ?? $keyword->keyword;
				}

			}

			return [
				'url' => $keyword->slug,
				'img' => $img,
				'alt' => $alt,
				'title' => $keyword->keyword,
				'type' => 'keyword',
			];
		})->values()->toArray();



		$data['servicesRelated'] = $servicesRelatedList;

		$cities = City::where('popular', '1')->get();
		$cityList = array();
		if ($cities) {
			foreach ($cities as $ckey => $cvalue) {

				$cityList[$ckey] = array(
					'url' => strtolower($cvalue->city) . '/' . $keywordDetails->slug,
					'title' => $keywordDetails->keyword . ' in ' . $cvalue->city,

				);

			}
		}

		$data['findOtherLocation'] = $cityList;

		$defaultLogo = config('app.website') . 'client/images/default_pp_small.png';
        $businessIds = $data['clientsList']->pluck('business_id');
		$reviewList = DB::table('clients')
		->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
		->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
		->leftJoin(DB::raw('(
		SELECT 
		comment_client_ID,
		SUM(rating) AS total_rating,
		COUNT(comment_ID) AS comment_count,
		MAX(comment_author) AS comment_author,
		MAX(comment_content) AS comment_content
		FROM comments
		GROUP BY comment_client_ID
		) c'), 'c.comment_client_ID', '=', 'clients.id')
		->select(
		'clients.id as business_id',
		'clients.business_slug as business_slug',
		'clients.business_name',
		'clients.logo',
		'clients.client_type',
		DB::raw('COALESCE(c.total_rating, 0) as rating'),
		DB::raw('COALESCE(c.comment_count, 0) as comment_count'),
		'c.comment_author',
		'c.comment_content'
		)
		 ->whereIn('clients.id', $businessIds)
		->where('clients.active_status', '1')
		->whereNotNull('c.comment_content')
		->groupBy(
		'clients.id'       
		)
		->orderByRaw("
		CASE clients.client_type
		WHEN 'platinum' THEN 1
		WHEN 'diamond'  THEN 2
		WHEN 'gold'     THEN 3
		WHEN 'silver'   THEN 4
		ELSE 5
		END
		")
		->get()
		->map(function ($business) use ($defaultLogo) {

	 
		$cicons = @unserialize($business->logo);

		if ($cicons !== false && isset($cicons['large']['src'], $cicons['large']['name'])) {
		$business->logo_image = config('app.website') . $cicons['large']['src'];
		$business->alt_logo   = $cicons['large']['name'];
		} else {
		$business->logo_image = $defaultLogo;
		$business->alt_logo   = 'Business Logo';
		}

		
		$business->avg_rating = $business->comment_count > 0
		? round($business->rating / $business->comment_count, 1)
		: 0;

	
		unset($business->logo);

		return $business;
		});
			$data['reviewList'] = $reviewList;
		 $relatedCategory = DB::table('keyword')
    ->join('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
    ->join('child_category', 'child_category.parent_category_id', '=', 'parent_category.id')
    ->where('keyword.slug', $search_kw)
    ->orderBy('child_category.child_category', 'asc')
    ->distinct()
    ->pluck('child_category.child_category', 'child_category.child_slug')
    ->toArray();


		$data['relatedCategory'] = $relatedCategory;

		return $data;




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
    private function fetchCityDetails(string $city=null)
    {
        try {
             $response = Http::timeout(5)
               ->withoutVerifying()->get('https://api.quickdials.com/api/website/getZoneDetails', ['city' => $city]);
 
            return $response->successful() ? $response->json() : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
     

        /**
     * Fetch a single business's profile by slug.
     */
    private function fetchBusinessData(string $slug = null)
    {
      
		$business_slug = $slug;

		$clientscheck = DB::table('clients')
			->leftJoin('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
			->leftJoin('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->leftJoin('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
			->leftJoin(DB::raw('(
        SELECT ROUND(AVG(rating), 1) AS average_rating, comment_client_ID, COUNT(comment_ID) AS comment_count
        FROM comments GROUP BY comment_client_ID
    ) c'), 'c.comment_client_ID', '=', 'clients.id')
			->select(
				'clients.*',
				'clients.id as business_id',
				'assigned_kwds.*',
				'clients.city',
				'assigned_kwds.sold_on_position',
				'c.average_rating',
				'c.comment_count'
			)
			->where('clients.business_slug', $business_slug)
			 ->where('clients.active_status', '1')
			->orderByRaw("
        CASE clients.client_type
            WHEN 'platinum' THEN 1
            WHEN 'diamond' THEN 2
            WHEN 'gold' THEN 3
            WHEN 'silver' THEN 4
            ELSE 5
        END
    ")
			->first();
		 
		if (!$clientscheck) {
                return null;

        }

			$logoImage = config('app.website') . 'client/images/default_pp_small.png';
			$altLogo = "Business Logo";
			if (!empty($clientscheck->logo)) {
				$cicons = unserialize($clientscheck->logo);

				if (!empty($cicons)) {
					$logoImage = config('app.website') . $cicons['large']['src'];
					$altLogo = $cicons['large']['name'];
				}
			}
			$profile_pic = config('app.website') . 'client/images/default_profile_pic.jpg';
			$altbanner = "";
			if (!empty($clientscheck->profile_pic)) {
				$banner = unserialize($clientscheck->profile_pic);

				if (!empty($banner)) {
					$profile_pic = config('app.website') . $banner['large']['src'];
					$altLogo = $clientscheck->business_name;
				}
			}

			$gallery = "";
			$altbanner = "";
			$galleryArray = array();
			if (!empty($clientscheck->pictures)) {
				$galleryList = unserialize($clientscheck->pictures);
				if (!empty($galleryList)) {
					foreach ($galleryList as $pkey => $gvalue) {
						$galleryArray[] = config('app.website') . $gvalue['large']['src'];

					}
				}
			}


  

				$assignedKeywords = DB::table('assigned_kwds')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->where('assigned_kwds.client_id', $clientscheck->business_id)
				->orderBy('keyword', 'asc')
				->distinct()
				->pluck('keyword.keyword','keyword.slug');
 

			$assignedCity = DB::table('assigned_kwds')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->where('assigned_kwds.client_id', $clientscheck->business_id)
				->distinct()
				->pluck('citylists.city')
				->toArray();

			$time = "";
			if ($clientscheck->time) {
				$time = json_decode($clientscheck->time);

			}

			$certified_img = config('app.website') . 'img/q_verified.gif';
			$trusted_img = config('app.website') . 'img/q_trust.gif';
			$gst_img = config('app.website') . 'img/q_gst.gif';

			$social = array(
				'facebook_url' => $clientscheck->facebook_url,
				'facebook_img' => '',
				'instagram_url' => $clientscheck->instagram_url,
				'instagram_img' => '',
				'twitter_url' => $clientscheck->twitter_url,
				'twitter_img' => '',
				'linkedin_url' => $clientscheck->linkedin_url,
				'linkedin_img' => '',
				'pinterest_url' => $clientscheck->pinterest_url,
				'pinterest_img' => '',
				'youtube_url' => $clientscheck->youtube_url,
				'youtube_img' => '',

			);


			$businessName = !empty($client->business_name) ? $clientscheck->business_name : 'our company';
			$data['comment'] = Comment::where('comment_client_ID', $clientscheck->business_id)
				->where('comment_approved', '1')
				->orderBy('created_at', 'desc')
				->get()
				->toArray();

			$sum = Comment::where('comment_client_ID', $clientscheck->business_id)
				->where('comment_approved', '1')
				->sum('rating');

			$count = Comment::where('comment_client_ID', $clientscheck->business_id)
				->where('comment_approved', '1')
				->count();

			$avgRating = 0;
			if ($count != 0)
				$avgRating = $clientscheck->average_rating;
		 
			$addressText = !empty($clientscheck->address) ? $clientscheck->address : '';
			$mapText = !empty($clientscheck->business_map) ? '\n Directions: ' . $clientscheck->business_map : '';
			$profile_url = 'https://www.quickdials.com/businessdetails/' . $clientscheck->business_slug;
			$keyword = "";
			$address_data = "Greetings from {$businessName},\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information"
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. "{$mapText}";

			$for_service = "Greetings from {$businessName},\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information of the services offered by our business please refer "
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. ", Or {$profile_url}";
			$for_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$count} Votes.\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information about the services offered by our business"
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. ". Or visit our profile: {$profile_url}";

			$user_share = array(
				'address_share' => $address_data,
				'for_service' => $for_service,
				'for_review' => $for_review,

			);
			
			$faqs = array(
				'faqq1' => $clientscheck->faqq1,
			'faqa1' => $clientscheck->faqa1,
			'faqq2' => $clientscheck->faqq2,
			'faqa2' => $clientscheck->faqa2,
			'faqq3' => $clientscheck->faqq3,
			'faqa3' => $clientscheck->faqa3,
			'faqq4' => $clientscheck->faqq4,
			'faqa4' => $clientscheck->faqa4,
			'faqq5' => $clientscheck->faqq5,
			'faqa5' => $clientscheck->faqa5,
			'faqq6' => $clientscheck->faqq6,
			'faqa6' => $clientscheck->faqa6,

			'faqq7' => $clientscheck->faqq7,
			'faqa7' => $clientscheck->faqa7,

			'faqq8' => $clientscheck->faqq8,
			'faqa8' => $clientscheck->faqa8,

			'faqq9' => $clientscheck->faqq9,
			'faqa9' => $clientscheck->faqa9,

			'faqq10' => $clientscheck->faqq10,
			'faqa10' => $clientscheck->faqa10,
			);
					
			
			$data['clientsList'] = [
				'business_id' => $clientscheck->business_id,
				'meta_title' => $clientscheck->meta_title,
				'meta_description' => $clientscheck->meta_description,
				'h1_heading' => $clientscheck->h1_heading,
				'business_name' => $clientscheck->business_name,
				'business_slug' => $clientscheck->business_slug,
				'business_url' => config('app.website') . 'businessdetails/' . $clientscheck->business_slug,
				'logo' => $logoImage ?? '',
				'altLogo' => $altLogo . ' Logo' ?? '',
				'profile_banner' => $profile_pic ?? '',
				'altbanner' => $altbanner ?? '',
				'gallery' => $galleryArray ?? '',
				'business_intro' => $clientscheck->business_intro,
				'assign_keyword' => $assignedKeywords,
				'service_city' => $assignedCity,
				'certifications' => $clientscheck->certifications,
				'sirName' => $clientscheck->sirName,
				'first_name' => $clientscheck->first_name,
				'middle_name' => $clientscheck->middle_name,
				'last_name' => $clientscheck->last_name,
				'email' => $clientscheck->email,
				'mobile' => $clientscheck->mobile,
				'call' => '917559435943',
				'whatsapp' => '917559435943',
				'certified_status' => $clientscheck->certified_status,
				'trusted_status' => $clientscheck->trusted_status,
				'gst_status' => $clientscheck->gst_status,
				'certified_img' => $certified_img,
				'trusted_img' => $trusted_img,
				'gst_img' => $gst_img,
				'website' => $clientscheck->website,
				'city' => $clientscheck->city,
				'state' => $clientscheck->state,
				'area' => $clientscheck->area,
				'zone' => $clientscheck->zone,
				'address' => $clientscheck->address,
				 
				'pincode' => $clientscheck->pincode,
				'country_id' => $clientscheck->country,
				'country' => 'India',
				'year_of_estb' => $clientscheck->year_of_estb,
				'time' => $time,
				'landmark' => $clientscheck->landmark,
				'rating' => $clientscheck->average_rating,
				'ratingCount' => $clientscheck->comment_count,				 
				'social' => $social,
				'user_share' => $user_share,
				'faqs' => $faqs,
			];
			$isoImage = "";
			if (!empty($clientscheck->iso_certificate)) {
				$iso_certificate = json_decode($clientscheck->iso_certificate);

				if (!empty($iso_certificate)) {
					$isoImage = config('app.website') . $iso_certificate->large->src;
				}
			}
			$gstImage = "";
			if (!empty($clientscheck->gst_certificate)) {
				$gst_certificate = json_decode($clientscheck->gst_certificate);

				if (!empty($gst_certificate)) {
					$gstImage = config('app.website') . $gst_certificate->large->src;
				}
			}
			
			$cinImage = "";
			if (!empty($clientscheck->cin_certificate)) {
				$cin_certificate = json_decode($clientscheck->cin_certificate);

				if (!empty($cin_certificate)) {
					$cinImage = config('app.website') . $cin_certificate->large->src;
				}
			}
			$panImage = "";
			if (!empty($clientscheck->pan_certificate)) {
				$pan_certificate = json_decode($clientscheck->pan_certificate);

				if (!empty($pan_certificate)) {
					$panImage = config('app.website') . $pan_certificate->large->src;
				}
			}
			$coiImage = "";
			if (!empty($clientscheck->coi_certificate)) {
				$coi_certificate = json_decode($clientscheck->coi_certificate);

				if (!empty($coi_certificate)) {
					$coiImage = config('app.website') . $coi_certificate->large->src;
				}
			}
			$dpiitImage = "";
			if (!empty($clientscheck->dpiit_certificate)) {
				$dpiit_certificate = json_decode($clientscheck->dpiit_certificate);

				if (!empty($dpiit_certificate)) {
					$dpiitImage = config('app.website') . $dpiit_certificate->large->src;
				}
			}

			$msmeImage = "";
			if (!empty($clientscheck->msme_certificate)) {
				$msme_certificate = json_decode($clientscheck->msme_certificate);

				if (!empty($msme_certificate)) {
					$msmeImage = config('app.website') . $msme_certificate->large->src;
				}
			}

			$awardimg1 = "";
			if (!empty($clientscheck->award_img1)) {
				$award_img1 = json_decode($clientscheck->award_img1);

				if (!empty($award_img1)) {
					$awardimg1 = config('app.website') . $award_img1->large->src;
				}
			}

			$awardimg2 = "";
			if (!empty($clientscheck->award_img2)) {
				$award_img2 = json_decode($clientscheck->award_img2);

				if (!empty($award_img2)) {
					$awardimg2 = config('app.website') . $award_img2->large->src;
				}
			}


			$awardimg3 = "";
			if (!empty($clientscheck->award_img3)) {
				$award_img3 = json_decode($clientscheck->award_img3);

				if (!empty($award_img3)) {
					$awardimg3 = config('app.website') . $award_img3->large->src;
				}
			}


			$awardimg4 = "";
			if (!empty($clientscheck->award_img4)) {
				$award_img4 = json_decode($clientscheck->award_img4);

				if (!empty($award_img4)) {
					$awardimg4 = config('app.website') . $award_img4->large->src;
				}
			}


			$awardimg5 = "";
			if (!empty($clientscheck->award_img5)) {
				$award_img5 = json_decode($clientscheck->award_img5);

				if (!empty($award_img5)) {
					$awardimg5 = config('app.website') . $award_img5->large->src;
				}
			}

			$awardimg6 = "";
			if (!empty($clientscheck->award_img6)) {
				$award_img6 = json_decode($clientscheck->award_img6);

				if (!empty($award_img6)) {
					$awardimg6 = config('app.website') . $award_img6->large->src;
				}
			}
			$awardimg7 = "";
			if (!empty($clientscheck->award_img7)) {
				$award_img7 = json_decode($clientscheck->award_img7);

				if (!empty($award_img7)) {
					$awardimg7 = config('app.website') . $award_img7->large->src;
				}
			}


				$awardimg8 = "";
			if (!empty($clientscheck->award_img8)) {
				$award_img8 = json_decode($clientscheck->award_img8);

				if (!empty($award_img8)) {
					$awardimg8 = config('app.website') . $award_img8->large->src;
				}
			}

				$awardimg9 = "";
			if (!empty($clientscheck->award_img9)) {
				$award_img9 = json_decode($clientscheck->award_img9);

				if (!empty($award_img9)) {
					$awardimg9 = config('app.website') . $award_img9->large->src;
				}
			}


				$awardimg10 = "";
				if (!empty($clientscheck->award_img10)) {
				$award_img10 = json_decode($clientscheck->award_img10);

				if (!empty($award_img10)) {
				$awardimg10 = config('app.website') . $award_img10->large->src;
				}
				}



			


			$data['certificate'] = [
				'gst_no' => $clientscheck->gst_no ?? null,
				'gst_certificate' => $gstImage,
				'pan_no' => $clientscheck->pan_no,
				'pan_certificate' => $panImage,
				'cin_no' => $clientscheck->cin_no ?? null,
				'cin_certificate' => $cinImage,
				'iso_no' => $clientscheck->iso_no ?? null,
				'iso_certificate' => $isoImage ?? null,
				'msme_no' => $clientscheck->msme_no ?? null,
				'msme_certificate' => $msmeImage ?? null,
				'coi_no' => $clientscheck->coi_no ?? null,
				'coi_certificate' => $coiImage ?? null,
				'dpiit_no' => $clientscheck->dpiit_no ?? null,
				'dpiit_certificate' => $dpiitImage ?? null,
				'award_name1' => $clientscheck->award_name1,
				'award_img1' => $awardimg1,
				'award_name2' => $clientscheck->award_name2,
				'award_img2' => $awardimg2,
				'award_name3' => $clientscheck->award_name3,
				'award_img3' => $awardimg3,
				'award_name4' => $clientscheck->award_name4,
				'award_img4' => $awardimg4,
				'award_name5' => $clientscheck->award_name5,
				'award_img5' => $awardimg5,
				'award_name6' => $clientscheck->award_name6,
				'award_img6' => $awardimg6,

				'award_name7' => $clientscheck->award_name7,
				'award_img7' => $awardimg7,

				'award_name8' => $clientscheck->award_name8,
				'award_img8' => $awardimg8,

				'award_name9' => $clientscheck->award_name9,
				'award_img9' => $awardimg9,

				'award_name10' => $clientscheck->award_name10,
				'award_img10' => $awardimg10,
			];

			$defaultImg = "";
			$recentActivity = [];

			for ($i = 1; $i <= 6; $i++) {
			$imgField  = "recent_img{$i}";
			$nameField = "recent_name{$i}";
			$paraField = "recent_paragraph{$i}";

			// Default image (used if no upload)
			$imgUrl = $defaultImg;

			// If image exists, decode JSON and build full URL
			if (!empty($clientscheck->$imgField)) {
			$decoded = json_decode($clientscheck->$imgField);
			if (!empty($decoded->large->src)) {
			$imgUrl = config('app.website') . $decoded->large->src;
			}
			}

			// Add to output array (matches your original flat structure)
			$recentActivity[$nameField] = $clientscheck->$nameField;
			$recentActivity[$imgField]  = $imgUrl;
			$recentActivity[$paraField] = $clientscheck->$paraField;
			}

			$data['recentActivity'] = $recentActivity;




			if (!empty($assignedKeywords)) {
				$findKeywords = Keyword::select('child_category_id')->where('keyword', $assignedKeywords->first())->first();

				$relKeywords = Keyword::select('keyword','slug')->where('child_category_id', $findKeywords->child_category_id)
					->orderBy('keyword', 'asc')
					->pluck('keyword.keyword','keyword.slug')
					->toArray();

				$data['related_searches'] = $relKeywords;
			}
			
			
				$businessName = $clientscheck->business_name ?? 'this business';
				$area         = $clientscheck->area ?? '';
				$city         = $clientscheck->city ?? '';
				$location     = trim($area . ($area && $city ? ', ' : '') . $city);

				if(!empty($clientscheck->business_description)){

				$area_business = [
				'heading' =>
				($clientscheck->business_name ?? '') .
				' in ' .
				($clientscheck->area ?? '') .
				', ' .
				($clientscheck->city ?? ''),

				'paragraph' => $clientscheck->business_description,
				];

				}else{


				$area_business = [
				'heading' =>
				($clientscheck->business_name ?? '') .
				' in ' .
				($clientscheck->area ?? '') .
				', ' .
				($clientscheck->city ?? ''),

				'paragraph' => "{$businessName}, located in {$location}, has built a strong reputation as a trusted name in {$city} for delivering professional, reliable, and customer-focused services. With years of hands-on experience, a skilled team, and a strong commitment to quality, {$businessName} It caters to a wide range of customer needs across {$city} and is open from 10:00 AM to 7:00 PM., ensuring timely service, transparent pricing, and lasting results every time.",
				];


				}

			$data['area_business'] = $area_business;

			$workingHoursHtml = '';

			if (!empty($clientscheck->time)) {

				$times = json_decode($clientscheck->time);
				$today = strtolower(date('l'));

				// Today
				if (isset($times->$today)) {
					$workingHoursHtml .= $times->$today->from . ' - ' . $times->$today->to;
				}

				// Other days
				foreach ($times as $day => $time) {
					$workingHoursHtml .= ucfirst($day) . ' ' . $time->from . ' - ' . $time->to;
				}

			} else {
				$workingHoursHtml .= '';
			}

			// ─── Extract once for clarity & to avoid repetition ───
			$businessName = $clientscheck->business_name ?? 'this business';
			$area         = $clientscheck->area ?? '';
			$city         = $clientscheck->city ?? '';
			$location     = trim($area . ($area && $city ? ', ' : '') . $city);

			// ─── Paragraph 1 ───
			$overviewParagraph = "{$businessName} in {$location} is a trusted service provider in {$city}, known for quality, reliability, and customer satisfaction. With experienced professionals, modern tools, and a strong commitment to service excellence, {$businessName} delivers consistent results every time. {$workingHoursHtml} The highly experienced team and It caters to a wide range of customer needs across {$city} and is open from 10:00 AM to 7:00 PM., offering flexible scheduling and personalized service to suit individual requirements.";

			// ─── Paragraph 2 ───
			$overviewParagraph2 = "Whether you need a one-time service or ongoing support, {$businessName} in {$location} has the right solution for you. With a wide range of offerings backed by professional handling and quality workmanship, {$businessName} stands as a comprehensive choice for customers across {$city}. From first contact to job completion, the team ensures transparent pricing, on-time service, and lasting quality outcomes. Get in touch with {$businessName} today to learn more or schedule a visit.";



				if(!empty($clientscheck->business_overview)){
							$overview_business = [
							'heading' => 'Overview of Business',
							'paragraph' => $clientscheck->business_overview,
							'paragraph1' => ''
						];
				}else{
					
					$overview_business = [
							'heading' => 'Overview of Business',
							'paragraph' => $overviewParagraph,
							'paragraph1' => $overviewParagraph2
						];				
					
				}
			$data['overview_business'] = $overview_business;
			
			
			return $data;
		
        
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

        $overviewBusiness = $b['businessDescription']; 
 
        return [
            'id'            => $id,
            'name'          => $name,
            'business_slug' => $b['business_slug'] ?? '',
            'category'      => array_slice($category, 0, 5),
            'rating'        => (float) ($b['avgRating'] ?? 0),
            'reviewCount'   => (int)   ($b['reviewCount'] ?? 0),
            'address'       => $b['address'] ?? '',
            'state'       => $b['state'] ?? 'Karnataka',
            'city'          => $b['city'] ?? 'faridabad',
            'pincode'          => $b['pincode'] ?? '560008',
            'landmark'          => $b['landmark'] ?? '',
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
            'businessDescription'   => $overviewBusiness ?? '',
            'logo'   => $b['logo'] ?? '',
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
    
        $clientsList = $businessResponse['clientsList']       ?? [];
       
        $certificate = $businessResponse['certificate']       ?? [];
        $comment     = $businessResponse['comment']           ?? [];
        $areaBusiness    = $businessResponse['area_business']     ?? [];
        $overviewBusiness= $businessResponse['overview_business'] ?? [];
        $relatedSearches = $businessResponse['related_searches']  ?? [];
  


            $keyword = trim($slug);

            // 🔹 Base Keyword Query
            $keywordList = DB::table('keyword')
            ->when(empty($keyword), function ($q) {
            // Default/popular keywords shown when no search term is given
            $q->whereIn('id', [
            288, 601, 1517, 159, 602, 1624,
            166, 536, 1937, 1481, 570, 1665,
            ]);
            })
            ->when(!empty($keyword), function ($q) use ($keyword) {
            $q->where('keyword', 'LIKE', "%{$keyword}%");
            })
            ->select(
            DB::raw("'keyword' as type"),
            'keyword',
            DB::raw("LOWER(REPLACE(keyword, ' ', '-')) as slug")
            )
            ->orderBy('keyword', 'asc')
            ->limit(50)
            ->get();

           

            // 🔹 Merge client data only when searching
            if (!empty($keyword)) {

            $clientData = DB::table('clients')
            ->where('business_name', 'LIKE', "%{$keyword}%")
            ->where('active_status', '1')
            ->select(
            DB::raw("'company' as type"),
            DB::raw("business_name as keyword"),
            DB::raw("business_slug as slug")
            )
            ->orderBy('business_name', 'asc')
            ->limit(50)
            ->get();

            $keywordList = $keywordList->merge($clientData);
            }

    
		 

     
 
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
        $assignKeyword = $clientsList['assign_keyword'] 
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
 
        $googleMapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($clientsList['address'] ?? 'faridabad');
        $mapSrc = 'https://www.google.com/maps/embed/v1/search?key=AIzaSyAPFOcLOlCcBCtp764h9HflPfA56VlCFo0&q=' . urlencode($clientsList['address'] ?? 'faridabad');
 
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

        $metaKeywords = !empty($clientsList['h1_heading'])
        ? $clientsList['h1_heading']
        : ($clientsList['business_name'] ?? '') . ' | QuickDials';

        $relatedSearches = $businessResponse['related_searches'] ?? [];
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

    /*
     * Replace {{city}} placeholder and strip basic HTML.
     */
    private function getsearchlist($response, $slug, $city): \Illuminate\Contracts\View\View
    {
         
        $businessOwners = $this->businessOwnersData(); 
        $growthBusiness = $businessOwners['data']['businessOwners'] ?? [];
  
        $kwData   = $response['keyword'] ?? [];
        $keywordBanners   = $kwData['keywordBanners'] ?? [];
 
        // ── Keyword / meta ─────────────────────────────────────────────────
        $keyword    = replaceCity($kwData['keyword'] ?? $slug, $city);
        $area       = $kwData['area'] ?? $city;
        $childSlug  = $kwData['child_slug'] ?? '';
        $childCat   = $kwData['child_category'] ?? '';
        $ratingCount = (int) ($kwData['ratingcount'] ?? 0);
        $ratingValue = (float) ($kwData['ratingvalue'] ?? 0);
        $bgImage    = $kwData['category_banner'] ?? '/computer-courses-training.jpg';
  
		$topDescription = !empty($kwData['top_description']) ? replaceCity($kwData['top_description'], $area) : '';
		$bottomDescription = !empty($kwData['bottom_description']) ? replaceCity($kwData['bottom_description'], $area) : '';
        // ── FAQs ───────────────────────────────────────────────────────────
        $faqs = [];
        for ($i = 0; $i <= 10; $i++) {
            $q = replaceCity($kwData["faqq{$i}"] ?? '', $city);
            $a = replaceCity($kwData["faqa{$i}"] ?? '', $city);
            if ($q && $a) $faqs[] = ['q' => $q, 'a' => $a];
        }

        // ── Businesses ─────────────────────────────────────────────────────
        $rawList    = $response['clientsList'] ?? [];
       
        $agents    = $response['agents'] ?? [];
        $businesses = collect($rawList)
            ->map(fn ($b, $i) => $this->normalizeBusiness($b, $i))
            ->all();

 
             
        // ── Agents comparison table ────────────────────────────────────────
        $agents = collect($agents)
            ->map(fn ($b) => $this->normalizeAgent($b))
            ->all();
 
        // ── Reviews ────────────────────────────────────────────────────────
        $reviews = $response['reviewList'] ?? [];
 
        // ── Related data ───────────────────────────────────────────────────
        $relatedCategory = $response['relatedCategory'] ?? [];
        $servicesRelated = $response['servicesRelated'] ?? [];

        // ── Dynamic categories list ────────────────────────────────────────
        $categories = array_merge(
            ['All'],
            array_values(array_unique(
                collect($businesses)->pluck('category')->flatten()->filter()->unique()->values()->all()
            ))
        );

		// ── Chunk businesses for ad insertion every 5 ─────────────────────
        $businessChunks = array_chunk($businesses, 5);
        $quickBusinesses =  [];
        $responseZones = $this->fetchCityData($city);
        $responseCityDetails = $this->fetchCityDetails($city);
        $zones     = $responseZones['data'] ?? [];
        $cityDetails     = $responseCityDetails['data'] ?? [];
 	
		 
        return view('client.searchlist', compact(
            'city', 'slug', 'keyword', 'area','zones',
            'childSlug', 'childCat','cityDetails',
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
            'metaKeywords'    => $kwData['h1_heading'] ?? '',
        ]);
    }


    /**
     * Replace {{city}} placeholder and strip basic HTML.
     */
	private function replaceCity(?string $text, ?string $city = ''): string
	{
		$text = trim($text ?? '');
		$city = trim($city ?? '');

		if ($text === '') {
			return '';
		}

		if ($city === '') {
			// Remove both "in {{city}}" and "{{city}}"
			$text = preg_replace('/\s*(?:in\s+)?{{city}}\s*/i', ' ', $text);
		} else {
			// Replace "{{city}}" with the formatted city name
			$cityName = ucwords(strtolower(str_replace('-', ' ', $city)));

			$text = str_ireplace('{{city}}', $cityName, $text);
		}

		// Remove extra spaces
		$text = preg_replace('/\s+/', ' ', $text);

		// Remove spaces before commas
		$text = preg_replace('/\s+,/', ',', $text);

		// Ensure one space after commas
		$text = preg_replace('/,\s*/', ', ', $text);

		return trim($text, " \t\n\r\0\x0B,");
	}


    /**
     * Handle  GET /{city}/{slug}
     */
	public function showCityWithService(Request $request, string $city, string $slug)
	{

 
    $citySlug   = strtolower(trim($city));
    $keySlugRaw = strtolower(trim($slug));
    $newSlug    = strtolower(str_replace(' ', '-', trim($slug)));

    $cityMap    = $this->getCitySlugMap();     // cached, in-memory
    $keywordMap = $this->getKeywordSlugMap();  // cached, in-memory

    $defaultCity = config('app.default_city_slug', 'faridabad');

    // ---- CATEGORY CHECK ----
    $category = $this->categoriesCheck($newSlug);

    if (!empty($category)) {
        // No real city in URL (e.g. /categories/{slug}) — redirect with default city
        if ($citySlug === 'categories' || !isset($cityMap[$citySlug])) {
            // return redirect()->route('city.slug', [
            //     'city_slug'     => $defaultCity,
            //     'service_slug' => $newSlug,
            // ], 301);

			return redirect()->route('showCity', $newSlug, 301);
        }

        // Real city present but not canonical (wrong case/format) — normalize it
        $cityName = $this->resolveBestCandidate($citySlug, $cityMap);

	 
        if ($cityName && $citySlug !== $cityName) {
            return redirect()->route('city.slug', [
                'city_slug'     => $cityName,
                'service_slug' => $newSlug,
            ], 301);
        }
		$newCat = $this->categoriesCheckDetails($newSlug);
	 

        return $this->categoriesListPage($newCat, $newSlug, $cityName ?? $city);
    }

    // ---- CHILD CHECK ----
    $child = $this->childCheck($newSlug);

    if (!empty($child)) {
	
        if ($citySlug === 'child' || !isset($cityMap[$citySlug])) {
            // return redirect()->route('city.slug', [
            //     'city_slug'  => $defaultCity,
            //     'service_slug' => $newSlug,
            // ], 301);
			return redirect()->route('showCity', $newSlug, 301);
			
        }

        $cityName = $this->resolveBestCandidate($citySlug, $cityMap);
	 
        if ($cityName && $citySlug !== $cityName) {
            // return redirect()->route('city.slug', [
            //     'city_slug'  => $cityName,
            //     'service_slug' => $newSlug,
            // ], 301);

			return redirect()->route('showCity', $newSlug, 301);
        }
		 $newchild = $this->childCheckdetails($newSlug);

        return $this->childListPage($newchild, $newSlug, $cityName ?? $city);
    }

    // ---- Resolve city (no DB call) ----
    $cityName = $this->resolveBestCandidate($citySlug, $cityMap);
   $slugUrl = $this->resolveBestCandidate($newSlug, $keywordMap);
 
    if (!$cityName) {
  
 		$cityData = $cityMap[$cityName] ?? null;
        if (!isset($cityData) && !$slugUrl) {			 
			abort(410);
            //return redirect()->route('home');
        }
        // return redirect()->route('city.slug', [
        //     'city_slug'    => $defaultCity,
        //     'service_slug' => $slug,
        // ], 301);
		if($slugUrl){
			return redirect()->route('showCity', $slugUrl, 301);	
		}	
    }

    if ($citySlug !== $cityName) {
        return redirect()->route('city.slug', [
            'city_slug'    => $cityName,
            'service_slug' => $slug,
        ], 301);
    }

    // ---- Resolve keyword/service (no DB call) ----
  

    if ($slugUrl) {
        if ($keySlugRaw !== $slugUrl) {
            return redirect()->route('city.slug', [
                'city_slug'    => $cityName,
                'service_slug' => $slugUrl,
            ], 301);
        }

        $response = $this->fetchData($cityName, $slugUrl);
        if (!$response) {
            abort(410);
        }

        return $this->getsearchlist($response, $slugUrl, $cityName);
    }

    $clientMap = $this->getClientSlugMap(); // cached, in-memory
    $slugUrl   = $this->resolveBestCandidate($newSlug, $clientMap);

    if ($slugUrl && $slugUrl !== $slug) {
        return redirect()->route('city.slug', [
            'city_slug'    => $cityName,
            'service_slug' => $slugUrl,
        ], 301);
    }

    if ($slugUrl) {
        if (!$this->clientsExists($slugUrl)) {
            abort(410);
        }
        $businessResponse = $this->fetchBusinessData($slugUrl);
        if (!$businessResponse) {

            return redirect()->route('home');
        }

        return $this->getClientDetail($businessResponse, $slugUrl);
    }

    abort(410);
}
 

	 

		
	public function categoriesCheck($slug)
	{
		$categoryDetails = DB::table('parent_category')
			->where('parent_slug', $slug)
			->first();

		if ($categoryDetails) {
			return $categoryDetails;
		}

		return null;
	}
			
	public function categoriesCheckDetails($slug)
	{

	 
		return Cache::remember("category_check_{$slug}", now()->addHours(6), function () use ($slug) {
			$res = Http::withoutVerifying()
				->get('https://api.quickdials.com/api/website/searchCategories', [
					'category-slug' => $slug,
				]);

			return $res->successful() ? $res->json() : null;
		});
	}


	public function categoriesListPage($response,$slug,$city)
	{
		 
 
        /* ── extract data (mirrors the Next.js component) ── */
        $kwData       = $response['data']['keyword']      ?? [];

	 
        $categoryList = $response['data']['categoryList'] ?? [];
 
        $keyword          = $kwData['parent_category']   ?? '';
        $childCategory    = $kwData['parent_category']   ?? '';
        $childSlug        = $kwData['parent_slug']       ?? '';
       
		$topDescription = !empty($kwData['top_description']) ? replaceCity($kwData['top_description'], $city) : '';
		$bottomDescription = !empty($kwData['bottom_description']) ? replaceCity($kwData['bottom_description'], $city) : '';

        $ratingCount      = $kwData['ratingcount']       ?? 0;
        $ratingValue      = $kwData['ratingvalue']       ?? 0;
        $bgImage          = $kwData['category_banner']   ?? '/computer-courses-training.jpg';
       		 
		$metaTitle = !empty($kwData['meta_title']) ? replaceCity($kwData['meta_title'], $city) : '';
		$metaDescription = !empty($kwData['meta_description']) ? replaceCity($kwData['meta_description'], $city) : '';
		$metaKeywords = !empty($kwData['h1_heading']) ? replaceCity($kwData['h1_heading'], $city) : '';

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
 		 
        return view('client.category-slug', compact(
            'slug', 'keyword', 'childCategory','kwData', 'childSlug',
            'topDescription', 'bottomDescription','faqs',
            'ratingCount', 'ratingValue', 'stars', 'bgImage',
            'categoryList', 'catColors','metaKeywords',
            'metaTitle', 'metaDescription','city'
        ));
	}



	public function childCheck($child_slug)
	{
		  
 		$childDetails = ChildCategory::where('child_slug', $child_slug)->first();
    if($childDetails){

		return $childDetails;
	}
        
	return null;
	}

	public function childCheckdetails($child_slug)
	{
		     
            $res = Http::timeout(10)->withoutVerifying()
                ->get('https://api.quickdials.com/api/website/searchChild', [
                    'child-slug' => $child_slug,
                ]);
 			$response = $res->successful() ? $res->json() : null;
        
    		return $response;
	}



	public function childListPage($response, $child_slug,$city)
	{	      
 
        /* ── extract data (mirrors the Next.js component) ── */
        $kwData       = $response['data']['keyword']  ?? [];
		 
        $childLists = $response['data']['childLists'] ?? []; 
        $keyword          = $kwData['child_category']   ?? '';
        $childCategory    = $kwData['child_category']   ?? '';
        $childSlug        = $kwData['child_slug']       ?? '';
        
		$topDescription = !empty($kwData['top_description']) ? replaceCity($kwData['top_description'], $city) : '';
		$bottomDescription = !empty($kwData['bottom_description']) ? replaceCity($kwData['bottom_description'], $city) : '';
      
        $ratingCount      = $kwData['ratingcount']       ?? 0;
        $ratingValue      = $kwData['ratingvalue']       ?? 4.8;
        $bgImage          = $kwData['category_banner']   ?? '/computer-courses-training.jpg';

    
		$metaTitle = !empty($kwData['meta_title']) ? replaceCity($kwData['meta_title'], $city) : '';
		$metaDescription = !empty($kwData['meta_description']) ? replaceCity($kwData['meta_description'], $city) : '';
		$metaKeywords = !empty($kwData['h1_heading']) ? replaceCity($kwData['h1_heading'], $city) : '';


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
 		 
		
        return view('client.child-slug', compact(
            'child_slug', 'keyword', 'childCategory', 'childSlug',
            'topDescription', 'bottomDescription','metaKeywords',
            'ratingCount', 'ratingValue', 'stars', 'bgImage',
            'childLists', 'catColors','faqs','kwData',
            'metaTitle', 'metaDescription','city'
        ));
    
	}

	private function getClientSlugMap(): array
	{
		return Cache::remember('client_slug_map', now()->addHours(6), function () {
			return DB::table('clients')->pluck('business_slug','business_slug')->all();
		});
	}
    private function resolveBestCandidate(string $inputSlug, array $slugMap): ?string
	{
		$tokens = array_values(array_filter(explode('-', $inputSlug), fn ($p) => $p !== ''));
		$candidates = $this->generateSubsequenceSlugs($tokens);

		// Longest candidate first = most specific match wins.
		usort($candidates, fn ($a, $b) => strlen($b) <=> strlen($a));
 
		foreach ($candidates as $candidate) {
 
			if (isset($slugMap[$candidate])) {

 
				return $candidate;
			}
		}

		return null;
	}
    
	/**
     * Check if a city is valid via the QuickDials city-check API.
     */
    private function clientsExists(string $slug): bool
    {
        $search_kw = strtolower(str_replace(' ', '-', trim($slug)));
        $exists = DB::table('clients')
            ->where('business_slug', $search_kw)
            ->exists();
        return $exists;
    }


	/**
	 * Full slug => slug map, cached. Rebuilds only when cache expires or is flushed.
	 */
	private function getCitySlugMap(): array
	{
		return Cache::remember('citylists_slug_map', now()->addHours(6), function () {
			return DB::table('citylists')->pluck('city_slug', 'city_slug')->all();
		});
	}

	private function getKeywordSlugMap(): array
	{
		return Cache::remember('keyword_slug_map', now()->addHours(6), function () {
			return DB::table('keyword')->pluck('slug', 'slug')->all();
		});
	}

 
	

	 

	
	private function generateSubsequenceSlugs(array $tokens): array
	{
		$tokens = array_slice($tokens, 0, 8);
		$count  = count($tokens);
		$result = [];

		for ($mask = 1; $mask < (1 << $count); $mask++) {
			$subset = [];
			for ($bit = 0; $bit < $count; $bit++) {
				if ($mask & (1 << $bit)) {
					$subset[] = $tokens[$bit];
				}
			}
			$result[] = implode('-', $subset);
		}

		return array_unique($result);
	}

     /**
     * Handle  GET /{city}/{slug}
     */
    public function showCityOrService(Request $request, string $slug)
    {
		// ── Normalize once ───────────────────────────────────────────────────
		$slug = strtolower(trim($slug));
		$newSlug = strtolower(str_replace(' ', '-', trim($slug)));  
		$keywordMap = $this->getKeywordSlugMap(); // cached, in-memory
		$cityMap    = $this->getCitySlugMap(); 
		$slugUrl    = $this->resolveBestCandidate($newSlug, $keywordMap);
		$city= "faridabad";

		
		$category = $this->categoriesCheck($newSlug);
 
		if($category){

		$newCategory = $this->categoriesCheckDetails($newSlug);
		return $this->categoriesListPage($newCategory,$newSlug,$city);
		}
		$child = $this->childCheck($newSlug);
 
		if(!empty($child)){
		$newchild = $this->childCheckDetails($newSlug);
 

		return $this->childListPage($newchild,$newSlug,$city);
		}

		
		$cityName = $this->resolveBestCandidate($newSlug, $cityMap);

		if (!empty($cityName)) {
			$cityKeyword = $this->cityKeyword();
			return $this->cityKeywordPage($cityKeyword,$cityName);			
		}

		// If a canonical/better match exists and differs from input → 301 redirect
		if ($slugUrl && $slugUrl !== $slug) {
			return redirect()->route('showCity', $slugUrl, 301);
		}

		// Final slug to use downstream: prefer resolved match, fallback to input
		$finalSlug = $slugUrl ?: $slug;

		// ── Validate city ────────────────────────────────────────────────────
		if (!$this->serviceExists($finalSlug)) {
			return redirect()->route('home');
		}

		// ── Fetch data ───────────────────────────────────────────────────────
		$response = $this->fetchKeywordData($finalSlug);
 

		if (!$response) {
			return redirect()->route('home');
		}		

        $kwData   = $response['keyword'] ?? [];
        $businessOwners = $this->businessOwnersData();

        $growthBusiness = $businessOwners['data']['businessOwners'] ?? [];
        // ── Keyword / meta ─────────────────────────────────────────────────
        $keyword    = replaceCity($kwData['keyword'] ?? $slug, '');
        $area       = $kwData['area'] ?? '';
        $childSlug  = $kwData['child_slug'] ?? '';
        $childCat   = $kwData['child_category'] ?? '';
        $ratingCount = (int) ($kwData['ratingcount'] ?? 0);
        $ratingValue = (float) ($kwData['ratingvalue'] ?? 4.8);
        $bgImage    = $kwData['category_banner'] ?? '/client/images/computer-courses-training.jpg';  

		$topDescription = !empty($kwData['top_description']) ? replaceCity($kwData['top_description'], $area) : '';
		$bottomDescription = !empty($kwData['bottom_description']) ? replaceCity($kwData['bottom_description'], $area) : '';
 
        // ── FAQs ───────────────────────────────────────────────────────────
        $faqs = [];
        for ($i = 0; $i <= 10; $i++) {
            $q = replaceCity($kwData["faqq{$i}"] ?? '', '');
            $a = replaceCity($kwData["faqa{$i}"] ?? '', '');
            if ($q && $a) $faqs[] = ['q' => $q, 'a' => $a];
        }
 
        // ── Businesses ─────────────────────────────────────────────────────
        $rawList    = $response['clientsList'] ?? [];
     
        $agents    = $response['agents'] ?? [];
        $businesses = collect($rawList)
            ->map(fn ($b, $i) => $this->normalizeBusiness($b, $i))
            ->all();
          
        // ── Agents comparison table ────────────────────────────────────────
        $agents = collect($agents)
            ->map(fn ($b) => $this->normalizeAgent($b))
            ->all();

        // ── Reviews ────────────────────────────────────────────────────────
        $reviews = $response['reviewList'] ?? [];

        // ── Related data ───────────────────────────────────────────────────
        $relatedCategory = $response['relatedCategory'] ?? [];
        $servicesRelated = $response['servicesRelated'] ?? [];

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
        $quickBusinesses = [];
         
        $city = "";

        $responseZones = $this->fetchCityData();
        $zones     = $responseZones['data'] ?? [];
  
        $cityDetails     =  [
				"zone" => "faridabad North",
				"city" => "faridabad",
				"pincode" => '560008',
				"city_slug" => "faridabad",
				"state" => "Karnataka",
		];

 

        return view('client.searchkeyword', compact(
            'city', 'slug', 'keyword', 'area','zones',
            'childSlug', 'childCat','cityDetails',
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
            'metaKeywords'    => $kwData['h1_heading'] ?? '',
        ]);


    }

/*
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function searchKW(Request $request)
	{

		$str = trim($request->input('q'));
		$query = DB::table('keyword')
			->select('keyword.keyword', 'keyword.slug', 'keyword.id');
		$str = '';
		if ($request->input('q') != "") {
			$str = trim($request->input('q'));
			$query = $query->orWhere('keyword.keyword', 'LIKE', '%' . $str . '%');
			$query = $query->orderBy(DB::raw("CASE WHEN keyword.keyword LIKE '" . $str . "%' THEN 1 ELSE 2 END"));
			$query = $query->distinct()->first();
		} 
	  
		$city = 'delhi';
		$slug = strtolower($query->slug);
 
        // 1. Validate city
        if (!$slug) {     
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

	public function cityKeyword()
	{	
		// ── API fetch (cached 1 hour) ────────────────────────────────────────
        $apiData = Cache::remember('business_services', 3600, function () {
            try {
                $res = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/business-services');
                return $res->successful() ? $res->json('data', []) : [];
            } catch (\Exception $e) {
                \Log::error('BusinessServices API: ' . $e->getMessage());
                return [];
            }
        });
		return $apiData;
 
	}
	


	public function cityKeywordPage($apiData,$city)
	{	
		 
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
 

	 
	$metaTitle = "Business Services in Delhi | QuickDials Local Business Directory";
	$metaDescription = "Find trusted business services in Delhi on QuickDials. Explore verified service providers, professionals, consultants, and local business solutions near you.";
	$keyword = "business services";

        return view('client.city-keyword', compact(
            'heroStats', 'categorySections', 'featured', 'featuredCategory','sidebarStats', 'category','city','metaTitle','metaDescription','keyword'
        ));


 
	}
	
}
