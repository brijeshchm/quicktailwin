<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use App\Models\Client\AssignedKWDS;
use App\Models\Client;
use App\Models\Keyword;
use App\Models\Citieslists;
use Session;
use App\Models\Client\Comment;

class SearchListController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showCityWithService(Request $request, $city, $search_kw)
	{
		try {

			$city = strtolower(str_replace(' ', '-', trim($city)));
			$search_kw = strtolower(str_replace(' ', '-', trim($search_kw)));
			// Validate city exists	  	 
			 
			$cityCheck = Citieslists::where('city_slug', $city)->first();
 
			if (!$cityCheck) {
				return response()->view('client.error410', [], 410);
			}

			// Fetch keyword details
			$keyword = DB::table('keyword as k')
				->join('parent_category as p', 'k.parent_category_id', '=', 'p.id')
				->join('child_category as c', 'k.child_category_id', '=', 'c.id')
				->where('k.slug', $search_kw)
				->select(
					'k.id as key_id',
					'k.keyword',
					'k.slug',
					'k.meta_title',
					'k.meta_description',
					'k.meta_keywords',
					'k.top_description',
					'k.bottom_description',
					'k.ratingvalue',
					'k.ratingcount',
					'p.form_type',
					'k.child_category_id',
					'k.parent_category_id',
					'k.faqq1',
					'k.faqa1',
					'k.faqq2',
					'k.faqa2',
					'k.faqq3',
					'k.faqa3',
					'k.faqq4',
					'k.faqa4',
					'k.faqq5',
					'k.faqa5',
					'k.faqq6',
					'k.faqa6',
					'k.heading',
					'k.courseabout',
					'k.paragraph1',
					'k.paragraph2',
					'k.paragraph3',
					'k.paragraph4',
					'k.paragraph5',
					'k.paragraph6',
					'p.parent_category',
					'c.child_category',
					'c.child_slug',
					'c.child_banner',
					'p.category_banner'
				)
				->first();
 
			// ✅ If keyword not found AND no business_slug match → 410
			if (empty($keyword)) {

				$client = Client::where('business_slug', $search_kw)->first();
				if (empty($client)) {
					return response()->view('client.error410', [], 410);
				}
			}

			$clientscheck = DB::table('clients')
				->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
				->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
				->leftJoin(DB::raw('(SELECT SUM(rating) AS rating, comment_client_ID, COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
				->select('clients.*', 'citylists.city','citylists.city_slug', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count', 'assigned_zones.*', 'keyword.slug')
				->where('citylists.city_slug', $city)
				->where('clients.active_status', '1')
				->where('keyword.slug', $search_kw)
				->orderByRaw("
                CASE clients.client_type
                WHEN 'platinum' THEN 1
                WHEN 'diamond' THEN 2
                WHEN 'gold' THEN 3
                WHEN 'silver' THEN 4
                ELSE 5
                END
            ")
				->groupBy('client_id')
				->get();

			if ($clientscheck->count() > 0) {
				$clientsList = $clientscheck;
			} else {
				$clientsList = DB::table('clients')
					->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
					->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id')
					->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
					->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
					->leftJoin(DB::raw('(SELECT SUM(rating) AS rating, comment_client_ID, COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
					->select('clients.*', 'citylists.city', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count', 'assigned_zones.*', 'keyword.slug')
					->where('keyword.slug', $search_kw)
					->orderByRaw("
                    CASE clients.client_type
                    WHEN 'platinum' THEN 1
                    WHEN 'diamond' THEN 2
                    WHEN 'gold' THEN 3
                    WHEN 'silver' THEN 4
                    ELSE 5
                    END
                ")
					->groupBy('client_id')
					->get();

				 
			}
 
			// CASE 1: keyword found — show search list
			if (!empty($keyword)) {
 
				$onlyClients = DB::table('clients')
					->leftJoin(DB::raw('(SELECT SUM(rating) AS rating, comment_client_ID, COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
					->select('clients.*', 'c.rating', 'c.comment_count')
					->where('city', ucwords(str_replace("-", " ", $city)))
					->where('business_slug', $search_kw)
					->get();
 
				$reviewsClientsList = DB::table('clients')
					->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
					->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id')
					->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
					->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
					->rightJoin(DB::raw('(SELECT SUM(rating) AS rating, comment_client_ID, COUNT(comment_ID) AS comment_count, comment_content FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
					->select('clients.*', 'citylists.city', 'citylists.city_slug','assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count', 'c.comment_content', 'keyword.slug')
					->where('citylists.city', ucwords(str_replace("-", " ", $city)))
					->where('keyword.slug', $search_kw)
					->get();

				$cities = Citieslists::select('id', 'city','city_slug')->get();
				$subcategory = DB::table('child_category')
					->join('parent_category', 'child_category.parent_category_id', '=', 'parent_category.id')
					->where('parent_category_id', $keyword->parent_category_id)
					->select('parent_category.*', 'child_category.*')
					->get();

				$kwdsList = Keyword::where('child_category_id', $keyword->child_category_id)
					->where('parent_category_id', $keyword->parent_category_id)
					->select('keyword', 'slug', 'icon')
					->orderBy('keyword', 'asc')
					->distinct()
					->get();

				$zones = DB::table('citylists')
					->join('zones', 'zones.city_id', '=', 'citylists.id')					
					->select('zones.id', 'zones.zone', 'zones.pincode','citylists.city_slug')
					->where('citylists.city', ucwords(str_replace("-", " ", $city)))
					->distinct()
					->orderBy('zones.zone', 'asc')
					->get();

 

				$firstZone = $zones->get(1);
				$area = ucwords(str_replace("-", " ", $city));				 
				if ($firstZone) {
					$zone = $firstZone->zone ?? '';
					$pincode = $firstZone->pincode ?? '';
					$area = $city . ', ' . $zone;
					if (!empty($pincode)) {
						$area .= ' ' . $pincode;
					}
				}
 
				return view('client.searchlist', [
					'clientsList' => $clientsList,
					'subcategory' => $subcategory,
					'reviewsClientsList' => $reviewsClientsList,
					'searchedKW' => $search_kw,
					'area' => $area,
					'onlyClients' => $onlyClients,
					'keyword' => $keyword,
					'city' => $city,
					'citiesList' => $cities,
					'zones' => $zones,
					'kwdsList' => $kwdsList,
				]);
			}

			// CASE 2: keyword not found — check business_slug
			$client = Client::where('business_slug', $search_kw)->first();

			if (!empty($client)) {

				$cities = Citieslists::select('id', 'city','city_slug')->get();
				$clientLists = Client::where('logo', '<>', '')
					->where('business_intro', '<>', '')
					->where('city', 'noida')
					->where('paid_status', '1')
					->limit(12)
					->get();

				$comments = Comment::where('comment_client_ID', $client->id)
					->where('comment_approved', 1)
					->orderBy('created_at', 'desc')
					->paginate(10);

				$sum = Comment::where('comment_client_ID', $client->id)->where('comment_approved', 1)->sum('rating');
				$count = Comment::where('comment_client_ID', $client->id)->where('comment_approved', 1)->count();
				$avgRating = $count != 0 ? ($sum / ($count * 5)) * 5 : 0;

				$graphQuery = Comment::select(DB::raw('*'))
					->from(DB::raw('(SELECT COUNT(*) as count, SUM(`rating`) as sum_rating, MONTH(DATE(`created_at`)) as month, DATE(`created_at`) as created_at FROM `comments` WHERE `comment_client_ID`=' . $client->id . ' AND `comment_approved`=1 GROUP BY MONTH(DATE(`created_at`)) ORDER BY created_at desc LIMIT 0,3) AS temp'))
					->orderBy('created_at')
					->get();

				$barGraphQuery = Comment::select(DB::raw('*'))
					->from(DB::raw('(SELECT COUNT(*) as count, SUM(`rating`) as sum_rating, rating FROM `comments` WHERE `comment_client_ID`=' . $client->id . ' AND `comment_approved`=1 GROUP BY `rating`) AS temp'))
					->orderBy('rating', 'desc')
					->get();

				$assignedKwds = DB::table('assigned_kwds')
					->join('keyword', 'keyword.id', '=', 'assigned_kwds.kw_id')
					->join('child_category', 'child_category.id', '=', 'assigned_kwds.child_cat_id')
					->select('keyword.keyword', 'keyword.slug', 'child_category.child_category as child_category_name', 'keyword.id as key_id', 'child_category.id as child_id')
					->where('assigned_kwds.client_id', '=', $client->id)
					->groupBy('kw_id')
					->get();

				$assignedCity = DB::table('assigned_kwds')
					->join('keyword', 'keyword.id', '=', 'assigned_kwds.kw_id')
					->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
					->join('child_category', 'child_category.id', '=', 'assigned_kwds.child_cat_id')
					->select('keyword.keyword', 'keyword.slug', 'citylists.city', 'child_category.child_category as child_category_name')
					->where('assigned_kwds.client_id', '=', $client->id)
					->groupBy('assigned_kwds.city_id')
					->get();

				$zones = DB::table('citylists')
					->join('zones', 'zones.city_id', '=', 'citylists.id')
					->where('citylists.city_slug', $city)
					->select('zones.id', 'zones.zone')
					->distinct()
					->get();
 
				return view('client.client-detail', [
					'client' => $client,
					'cities' => $cities,
					'comments' => $comments,
					'count' => $count,
					'sum' => $sum,
					'avgRating' => number_format($avgRating, 1, '.', ''),
					'graphQuery' => $graphQuery,
					'barGraphQuery' => $barGraphQuery,
					'assignedKwds' => $assignedKwds,
					'clientLists' => $clientLists,
					'clients' => $client,
					'assignedCity' => $assignedCity,
					'zones' => $zones,
				]);
			}

			// CASE 3: nothing matched — show city clients fallback
			$clientLists = Client::where('logo', '<>', '')
				->where('business_intro', '<>', '')
				->where('city',ucwords(str_replace("-", " ", $city)))
				->limit(12)
				->get();

			return view('client.cityclients', [
				'cityclients' => $clientLists,
				'clientLists' => $clientLists,
				'city' => $city,
				'search_kw' => $search_kw,
			]);

		} catch (\Exception $e) {
			// ✅ Any unexpected error or keyword not found → 410
			return response()->view('client.error410', [], 410);
		}
	}

	 
}
