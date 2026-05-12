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
 
        $title = $clientsList['meta_title']??"";
        $keyword = $clientsList['meta_keyword']??"";
       $description = $clientsList['meta_description']??"";
        return view('client.client-detail', compact(
            'slug', 'response', 'clientsList', 'certificate','title','keyword','description',
            'comment', 'areaBusiness', 'overviewBusiness',
            'relatedList', 'keywordList', 'gallery', 'hImages', 'vImages',
            'assignKeyword', 'certifications', 'govDocs', 'reviews',
            'gradients', 'bgColors', 'iconColors', 'planOptions',
            'googleMapUrl', 'mapSrc', 'yearsExp', 'yearEst',
            'todayDay', 'hours','linearGradients'
        ));
	
		// $clients = Client::where('business_slug', $slug)->get();
		// $cities = Citieslists::all();
		// $clientLists = Client::where('logo', '<>', '')->where('business_intro', '<>', '')->where('city', 'noida')->where('paid_status', '1')->limit(12)->get();
		// if (count($clients) > 0) {
		// 	foreach ($clients as $c) {
		// 		$client = $c;
		// 		break;
		// 	}
		// 	Session::put('currentClient', $client);
		// 	$comments = Comment::where('comment_client_ID', $client->id)
		// 		->where('comment_approved', 1)
		// 		->orderBy('created_at', 'desc')
		// 		->paginate(10);

		// 	$sum = Comment::where('comment_client_ID', $client->id)
		// 		->where('comment_approved', 1)
		// 		->sum('rating');
		// 	$count = Comment::where('comment_client_ID', $client->id)
		// 		->where('comment_approved', 1)
		// 		->count();
		// 	$avgRating = 0;
		// 	if ($count != 0)
		// 		$avgRating = ($sum / ($count * 5)) * 5;
		// 	//'(SELECT COUNT(*) as count, SUM(`rating`) as sum_rating, MONTH(DATE(`created_at`)) as month, DATE(`created_at`) as created_at FROM `comments` WHERE `comment_client_ID`='.$client->id.' AND `comment_approved`=1 AND DATE(`created_at`)>=\':date\' GROUP BY MONTH(DATE(`created_at`)) ORDER BY created_at desc LIMIT 0,3) AS temp'
		// 	$graphQuery = Comment::select(DB::raw('*'))
		// 		->from(DB::raw('(SELECT COUNT(*) as count, SUM(`rating`) as sum_rating, MONTH(DATE(`created_at`)) as month, DATE(`created_at`) as created_at FROM `comments` WHERE `comment_client_ID`=' . $client->id . ' AND `comment_approved`=1 GROUP BY MONTH(DATE(`created_at`)) ORDER BY created_at desc LIMIT 0,3) AS temp'))
		// 		->orderBy('created_at')
		// 		->get();
		// 	$barGraphQuery = Comment::select(DB::raw('*'))
		// 		->from(DB::raw('(SELECT COUNT(*) as count, SUM(`rating`) as sum_rating, rating FROM `comments` WHERE `comment_client_ID`=' . $client->id . ' AND `comment_approved`=1 GROUP BY `rating`) AS temp'))
		// 		->orderBy('rating', 'desc')
		// 		->get();

		// 	$assignedKwds = DB::table('assigned_kwds')
		// 		->join('keyword', 'keyword.id', '=', 'assigned_kwds.kw_id')
				 
		// 		->join('child_category', 'child_category.id', '=', 'assigned_kwds.child_cat_id')
		// 		->select('keyword.keyword', 'keyword.slug','child_category.child_category as child_category_name', 'keyword.id as key_id', 'child_category.id as child_id')
		// 		->where('assigned_kwds.client_id', '=', $client->id)
		// 		->groupBy('kw_id')
		// 		->get();

			 
		// 	$assignedCity = DB::table('assigned_zones')
			 
		// 		->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
				 
		// 		->select('citylists.city')
		// 		->where('assigned_zones.client_id', '=', $client->id)
		// 		->groupBy('assigned_zones.city_id')
		// 		->get();
 

		// 	return view('client.client-detail', ['client' => $client, 'cities' => $cities, 'comments' => $comments, 'count' => $count, 'sum' => $sum, 'avgRating' => number_format($avgRating, 1, '.', ''), 'graphQuery' => $graphQuery, 'barGraphQuery' => $barGraphQuery, 'assignedKwds' => $assignedKwds, 'clientLists' => $clientLists, 'clients' => $clients, 'assignedCity' => $assignedCity]);
		// } else {
		// 	return response()->view('client.errorpage', [], 410);
		// }


	}

}
