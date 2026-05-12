<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\AddLeadRequest;
use Validator;
use DB;
use Mail;
use Excel;
use Auth;
use Carbon\Carbon;
use Cookie;

use App\Models\PushLead;
use App\Models\Lead;
use App\Models\LeadFollowUp;

use App\Models\Status;
use App\Models\User;
use App\Models\Course;
use App\Models\Citieslists;
use App\Models\Keyword;
use App\Models\AssignedLead;
use App\Models\KeywordSellCount;

use App\Models\Zone;
use App\Models\Area;
use App\Models\Client\Client;
use App\Events\LeadPush;
use App\Jobs\SendLeadMailJob;
class LeadController extends Controller
{


	public function updateremaining(Request $request)
	{
		$assignClient = DB::table('assigned_leads as assigned_leads');
		$assignClient = $assignClient->join('clients', 'clients.id', '=', 'assigned_leads.client_id');
		//$assignClient = $assignClient->selectRaw('assigned_leads.*,count(assigned_leads.lead_id) as leadscount');
		//$assignClient = $assignClient->select('assigned_leads.lead_id as leadscount','assigned_leads.client_id','clients.leads_remaining');
		$assignClient = $assignClient->select('assigned_leads.client_id', 'clients.leads_remaining');
		$assignClient = $assignClient->groupBy('client_id');
		$assignClient = $assignClient->get();


		if (!empty($assignClient)) {
			foreach ($assignClient as $assignC) {
				$leadscount = DB::table('assigned_leads')->where('client_id', $assignC->client_id)->get();

				$clients = DB::table('clients')->where('id', $assignC->client_id)->first();

				DB::table('clients')
					->where('id', $assignC->client_id)
					->update(['leads_remaining' => $clients->leads_remaining - count($leadscount)]);


			}

		}

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$leads = DB::table('leads');
			$leads = $leads->join('citylists', 'leads.city_id', '=', 'citylists.id');
			$leads = $leads->leftjoin('users', 'leads.push_by', '=', 'users.id');
			$leads = $leads->leftjoin('assigned_leads', 'leads.id', '=', 'lead_id', 'left join');
			$leads = $leads->select('leads.*', 'citylists.city', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'users.first_name', 'users.last_name', DB::raw("count('assigned_leads.client_id') as count"));

			$leads = $leads->groupBy(DB::raw('leads.id'));

			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.email', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			if ($request->input('search.city') != '') {
				$leads = $leads->where('leads.city_id', '=', $request->input('search.city'));
			}
			if ($request->input('search.course') != '') {
				$leads = $leads->where('leads.kw_text', 'LIKE', $request->input('search.course'));
			}
			if ($request->input('search.datef') != '') {
				$leads = $leads->whereDate('leads.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
			}
			if ($request->input('search.datet') != '') {
				$leads = $leads->whereDate('leads.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
			}
			if ($request->input('search.lead_type') != '') {
				$leads = $leads->where('leads.b_end', 'LIKE', $request->input('search.lead_type'));
			}
			$leads = $leads->orderBy('leads.id', 'desc');
			$leads = $leads->paginate($request->input('length'));

			$returnLeads = $data = $owner = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			$users = DB::table('users')->select('users.id', 'users.first_name', 'users.last_name')->get();
			if ($users) {
				foreach ($users as $user) {
					$owner[$user->id] = $user->first_name . " " . $user->last_name;
				}
			}

			foreach ($leads as $lead) {
				$owner_name = '';
				if ($lead->created_by != null && isset($owner[$lead->created_by])) {
					$owner_name = $owner[$lead->created_by];
				}
				$data[] = [
					($lead->b_end) ? $lead->name . " <i aria-hidden=\"true\" style=\"color:red\" class=\"fa fa-fw fa-asterisk\"></i>" : $lead->name,
					($lead->b_end) ? "Internal" : "External",
					$lead->mobile,
					//$lead->email,
					$owner_name,
					$lead->area,
					$lead->kw_text,
					$lead->city,
					(new Carbon($lead->created_at))->format('d-m-Y h:i:s'),
					($lead->first_name) ? $lead->first_name . ' ' . $lead->last_name : '-',
					($lead->id = $lead->lead_id) ? '<center>' . $lead->count . '</center>' : '<center style="color:#F00;"> 0 </center>',

					($request->user()->current_user_can('administrator|admin')) ? '<a href="/developer/lead/' . $lead->id . '" title="view clients"><i class="fa fa-fw fa-eye"></i></a>' . ' | ' . '<a href="javascript:leadRepost(' . $lead->id . ')" title="lead repost"><i class="fa fa-fw fa-repeat"></i></a>' : ''
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);

		} else {


			$cities = Citieslists::select('id', 'city')->orderBy('city', 'ASC')->get();
			$kwds = DB::table('leads')
				->select('leads.kw_text')
				->distinct()
				->get();
			$search = [];
			if ($request->has('search')) {
				$search = $request->input('search');
			}
			return view('admin.lead.all_leads', [
				'cities' => $cities,
				'kwds' => $kwds,
				'search' => $search
			]);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id = null)
	{

		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}

		$edit_data = Lead::findOrFail($id);
		$cities = Citieslists::get();
		$areas = Area::get();
		$zones = Zone::get();
		return view('admin.lead.edit-lead', ['cities' => $cities, 'edit_data' => $edit_data, 'areas' => $areas, 'zones' => $zones]);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateSaveLead(Request $request, $id = null)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'mobile' => 'required|unique:leads,mobile,' . $id . ',id,kw_text,' . $request->input('kw_text'),
			'city_id' => 'required',
			//	'area_zone'=>'required',
			'kw_text' => 'required',
			'created_by' => 'required',
		]);
		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			$errors = [];
			foreach ($errorsBag as $error) {
				$errors[] = implode("<br/>", $error);
			}
			$errors = implode("<br/>", $errors);
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => $errors
				]
			], 200);
		}
		try {
			$lead = Lead::findOrFail($id);
			if ($lead) {


				$city = Citieslists::where('city', $request->input('city_id'))->first();
				$lead->city_id = $city->id;
				$lead->city_name = $city->city;
				$lead->name = $request->input('name');
				if (!empty($request->input('email'))) {
					$lead->email = $request->input('email');
				}
				$lead->mobile = $request->input('mobile');
				$lead->created_by = $request->input('created_by');


				if ($request->input('area_zone') != '') {
					$lead->zone_id = $request->input('area_zone');
					$areas = DB::table(DB::raw("(SELECT * FROM areas WHERE id={$request->input('area_zone')}) as aa"));
					$areas = $areas->join('zones', 'zones.id', '=', DB::raw('`aa`.`zone_id`'));
					$areas = $areas->select('aa.id', 'aa.area', 'aa.zone_id', 'zones.zone');
					$areas = $areas->first();
					$lead->area = $areas->zone . " " . "(" . $areas->area . ")";
					$lead->area_id = $areas->id;
					$lead->zone_id = $areas->zone_id;
				}

				$keyword = Keyword::where('id', $request->input('kw_text'))->first();

				if (!empty($keyword)) {
					$lead->kw_id = $keyword->id;
					$lead->kw_text = $keyword->keyword;
					$bucketIndex = $keyword->bucket;
				} else {

					return response()->json([
						"statusCode" => 0,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Course not found please update"
						]
					], 200);

				}

				$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				if ($lead->save()) {
					return response()->json([
						"statusCode" => 1,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Lead updated successfully."
						]
					], 200);
				} else {
					return response()->json([
						"statusCode" => 0,
						"data" => [
							"responseCode" => 400,
							"payload" => "",
							"message" => "Lead not updated."
						]
					], 200);
				}
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => $e->getMessage()
				]
			], 200);
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('add_lead'))) {
			return view('errors.unauthorised');
		}
		return view('admin.lead.add-lead');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('add_lead'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {
			$cityname = $request->input('city_id');
			$city = Citieslists::where('city', 'LIKE', $request->input('city_id'))->first();
			$lead = new Lead;
			if (!empty($city->id)) {
				$lead->city_id = $city->id;
			}
			$lead->city_name = $cityname;
			$lead->name = $request->input('name');
			$emailToTestYet5 = $request->input('email');
			if ($request->has('email') && preg_match("/@yet5\.com$/i", $emailToTestYet5)) {
				$lead->email = '';
			} else {
				$lead->email = $request->input('email');
			}
			$lead->mobile = $request->input('mobile');

			if (Auth::check()) {
				$lead->created_by = $request->user()->id;
			}

			$lead->b_end = 1;

			if ($request->input('area_zone') != '') {
				$lead->zone_id = $request->input('area_zone');
				$areas = DB::table(DB::raw("(SELECT * FROM areas WHERE id={$request->input('area_zone')}) as aa"));
				$areas = $areas->join('zones', 'zones.id', '=', DB::raw('`aa`.`zone_id`'));
				$areas = $areas->select('aa.id', 'aa.area', 'aa.zone_id', 'zones.zone');
				$areas = $areas->first();
				$lead->area = $areas->zone . " " . "(" . $areas->area . ")";
				$lead->area_id = $areas->id;
				$lead->zone_id = $areas->zone_id;
			}



			$keyword = Keyword::where('keyword', 'LIKE', $request->input('kw_text'))->get();

			if (!empty($keyword)) {
				$lead->kw_id = $keyword[0]->id;
				$lead->kw_text = $keyword[0]->keyword;
				$bucketIndex = $keyword[0]->bucket;
			} else {
				return response()->json(['status' => 1, 'msg' => 'Keyword not found'], 404);
			}
			$status = Status::where('name', 'LIKE', 'New Lead')->first()->id;

			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;

			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));

			if ($lead->save()) {
				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->lead_id = $lead->id;
				$followUp->remark_by = Auth::user()->id;
				$followUp->save();
				leadassignWithoutZoneCounsellor($lead);


				Cookie::queue("showPopup", "yes", "60");


				return response()->json(['status' => 1, 'msg' => 'Lead added successfully'], 200);


			} else {
				$lead->delete();
				return response()->json(['status' => 0, 'errors' => 'Lead not added'], 400);

			}


		}
	}


	public function storeWithoutZone(AddLeadRequest $request)
	{


		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('add_lead'))) {
			return view('errors.unauthorised');
		}
		if ($request->ajax()) {
			$cityname = $request->input('city_id');
			$city = Citieslists::where('city', 'LIKE', $request->input('city_id'))->first();
			$lead = new Lead;
			if (!empty($city->id)) {
				$lead->city_id = $city->id;
			}
			$lead->city_name = $cityname;
			$lead->name = $request->input('name');
			$emailToTestYet5 = $request->input('email');
			if ($request->has('email') && preg_match("/@yet5\.com$/i", $emailToTestYet5)) {
				$lead->email = '';
			} else {
				$lead->email = $request->input('email');
			}
			$lead->mobile = $request->input('mobile');

			if (Auth::check()) {
				$lead->created_by = $request->user()->id;
			}

			$lead->b_end = 1;

			if ($request->input('area_zone') != '') {
				$lead->zone_id = $request->input('area_zone');
				$areas = DB::table(DB::raw("(SELECT * FROM areas WHERE id={$request->input('area_zone')}) as aa"));
				$areas = $areas->join('zones', 'zones.id', '=', DB::raw('`aa`.`zone_id`'));
				$areas = $areas->select('aa.id', 'aa.area', 'aa.zone_id', 'zones.zone');
				$areas = $areas->first();
				$lead->area = $areas->zone . " " . "(" . $areas->area . ")";
				$lead->area_id = $areas->id;
				$lead->zone_id = $areas->zone_id;
			}



			$keyword = Keyword::where('keyword', 'LIKE', $request->input('kw_text'))->get();

			if (count($keyword) > 0) {
				$lead->kw_id = $keyword[0]->id;
				$lead->kw_text = $keyword[0]->keyword;
				$bucketIndex = $keyword[0]->bucket;
			} else {
				return response()->json(['status' => 1, 'msg' => 'Keyword not found'], 404);
			}
			$status = Status::where('name', 'LIKE', 'New Lead')->first()->id;

			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;

			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));

			if ($lead->save()) {
				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->lead_id = $lead->id;
				$followUp->remark_by = Auth::user()->id;
				$followUp->save();
				leadassignWithoutZoneCounsellor($lead);
				Cookie::queue("showPopup", "yes", "60");
				return response()->json(['status' => 1, 'msg' => 'Lead added successfully'], 200);
			} else {
				$lead->delete();
				return response()->json(['status' => 0, 'errors' => 'Lead not added'], 400);

			}

		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function pushLead(Request $request, $id = null)
	{
		if (null == $id) {
			return response()->json([
				"statusCode" => 1,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => "Lead id cannot be null !!"
				]
			], 400);
		}
		if ($request->ajax()) {
			try {
				$lead = Lead::findOrFail($id);
			} catch (\Exception $e) {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 404,
						"payload" => "",
						"message" => "lead not found !!"
					]
				], 200);
			}

			try {
				$city = Citieslists::findOrFail($lead->city_id);
			} catch (\Exception $e) {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 404,
						"payload" => "",
						"message" => "City id not found please update city!!"
					]
				], 200);
			}

			try {
				$zone = Zone::findOrFail($lead->zone_id);
			} catch (\Exception $e) {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 404,
						"payload" => "",
						"message" => "Zone not found please update Zone!!"
					]
				], 200);
			}


			try {
				$keyword = Keyword::findOrFail($lead->kw_id);
				$bucketIndex = $keyword->bucket;
			} catch (\Exception $e) {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 404,
						"payload" => "",
						"message" => $e->getMessage(),
					]
				], 200);
			}

			if (!empty($lead)) {

				$clientsList = DB::table('clients');

				$clientsList = $clientsList->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id');

				$clientsList = $clientsList->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id');
				$clientsList = $clientsList->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id');
				$clientsList = $clientsList->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'clients.client_type');
				$clientsList = $clientsList->select('clients.*', 'assigned_kwds.*', 'assigned_kwds.city_id as assgn_city_id', 'keyword.keyword','keyword.slug', 'keyword.category', 'keyword.bucket');
				$clientsList = $clientsList->where('keyword.id', '=', $lead->kw_id);
				$clientsList = $clientsList->where('assigned_kwds.city_id', '=', $lead->city_id);

				//$clientsList = $clientsList->where('assigned_zones.zone_id','=',$request->input('area_zone'))
				$clientsList = $clientsList->where('assigned_zones.zone_id', '=', $lead->zone_id);
				//	$clientsList = $clientsList->where('assignedd_areas.area_id','=',$lead->area_id);

				$clientsList = $clientsList->whereNull('clients.deleted_at');
				$clientsList = $clientsList->where('clients.leads_remaining', '>', '0');
				//$clientsList = $clientsList->where('clients.balance_amt','>',50);
				//$clientsList = $clientsList->where('clients.expired_on','>',date("Y-m-d H:i:s"));
				/* 
				$clientsList = $clientsList->where(function($query){
					$query->where(function($query){
						$query->where('clients.leads_remaining','>','0')								
							->orWhere('clients.balance_amt','>','50') 				
							->orWhere('clients.expired_on','>',date("Y-m-d H:i:s"));					
					}); */

				/* ->orWhere(function($query){
					$query->where(function($query){
						$query->where('clients.client_type','free_subscription')
						->orWhere('clients.client_type','yearly_subscription');
					})
					->whereDate('clients.yrly_subs_end_date','>',date('Y-m-d'));
				})
				->orWhere(function($query){
					$query->where('clients.client_type','count_based_subscription')
						  ->where('clients.leads_remaining','>','0');
				}); */

				$clientsList = $clientsList->where('active_status', '1');
			 
				$clientsList = $clientsList->orderByRaw("
					CASE clients.client_type
					WHEN 'platinum' THEN 1
					WHEN 'diamond' THEN 2
					WHEN 'gold' THEN 3
					WHEN 'silver' THEN 4
					ELSE 5
					END
					");
				$clientsList = $clientsList->get();

				$defaulterClientsList = DB::table('clients');

				$defaulterClientsList = $defaulterClientsList->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id');
				//$defaulterClientsList = $defaulterClientsList->join('assignedd_areas','assignedd_areas.assigned_zone_id','=','assigned_zones.id');

				$defaulterClientsList = $defaulterClientsList->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id');
				$defaulterClientsList = $defaulterClientsList->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id');
				$defaulterClientsList = $defaulterClientsList->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position');
				$defaulterClientsList = $defaulterClientsList->select('clients.*', 'assigned_kwds.*', 'keyword.keyword','keyword.slug', 'keyword.category', 'keyword.bucket');
				$defaulterClientsList = $defaulterClientsList->where('keyword.id', '=', $lead->kw_id);

				$defaulterClientsList = $defaulterClientsList->where('assigned_zones.zone_id', '=', $lead->zone_id);
				//$defaulterClientsList = $defaulterClientsList->where('assignedd_areas.area_id','=',$lead->area_id);

				$defaulterClientsList = $defaulterClientsList->whereNull('clients.deleted_at');
				$defaulterClientsList = $defaulterClientsList->where(function ($query) {
					$query->where(function ($query) {

						//$query->whereIn('clients.client_type','lead_based')
						$query->where('clients.leads_remaining', '>', '0');
						// ->where('clients.leads_remaining','>','0');
					});
					/* ->orWhere(function($query){
						$query->where(function($query){
							$query->where('clients.client_type','free_subscription')
							->orWhere('clients.client_type','yearly_subscription');
						})
						->whereDate('clients.yrly_subs_end_date','<=',date('Y-m-d'));
					})
					->orWhere(function($query){
						$query->where('clients.client_type','count_based_subscription')
							  ->where('clients.leads_remaining','=','0');
					}); */


				});
				 

				$defaulterClientsList = $defaulterClientsList->orderByRaw("
					CASE clients.client_type
					WHEN 'platinum' THEN 1
					WHEN 'diamond' THEN 2
					WHEN 'gold' THEN 3
					WHEN 'silver' THEN 4
					ELSE 5
					END
					");
			 
				$defaulterClientsList = $defaulterClientsList->get();

				foreach ($defaulterClientsList as $defaulterClient) {
					//$this->intimateDefaulterClients($defaulterClient, $lead);
				}

				//return $clientsList;

				// BUCKET CALCULATION
				// ******************
				$max = $mCount = 5;
				$i = 0;
				$totalClients = count($clientsList);
				$buckets = [];
				foreach ($clientsList as $client) {
					if ($mCount == 0) {
						$j = $i;
						$buckets[++$j] = $buckets[$i++];
						$buckets[$j]['diamond'] = [];
						$mCount = $max - (count($buckets[$j], 1) - 5);
					}
					if ($client->sold_on_position == 'platinum') {
						$buckets[$i]['platinum'][] = $client;
					}
					if ($client->sold_on_position == 'diamond') {
						$buckets[$i]['diamond'][] = $client;
					}


					--$mCount;
				}
				$i = 0;
				$bucketCount = count($buckets);


				if (!empty($clientsList)) {
					foreach ($buckets as $bucket) {
						if ($bucketCount <= $bucketIndex || $bucketIndex == 0) {
							$bucketIndex = 0;
						}

						if ($bucketIndex == $i) {
							foreach ($bucket as $position => $clientss) {

								foreach ($clientss as $clientC) {

									if ($clientC->client_type) {
										$clnt = Client::find($clientC->client_id);

										if ($clnt) {
											$dontSave = 0;
											switch ($clientC->client_type) {
												case 'platinum':
													/*if($clientC->balance_amt-$clientC->cost_per_lead<0){
															$dontSave = 1;
														}else{
															$clnt->balance_amt = $clnt->balance_amt - $clientC->cost_per_lead;
														}*/

													if ($clientC->leads_remaining - 1 < 0) {
														$dontSave = 1;
													} else {
														$clnt->leads_remaining = $clnt->leads_remaining - 1;
													}

													/* if($clnt->balance_amt<50){
														$clnt->expired_on = date("Y-m-d H:i:s");
													} */
													break;
												case 'diamond':
													/* if($clientC->balance_amt-$clientC->cost_per_lead<0){
															$dontSave = 1;
														}else{
															$clnt->balance_amt = $clnt->balance_amt - $clientC->cost_per_lead;
														} */

													if ($clientC->leads_remaining - 1 < 0) {
														$dontSave = 1;
													} else {
														$clnt->leads_remaining = $clnt->leads_remaining - 1;
													}

													/* if($clnt->balance_amt<50){
														$clnt->expired_on = date("Y-m-d H:i:s");
													} */
													break;



											}
											/* switch($client->category){
												   case 'Category 1':
													   if($client->balance_amt-$client->cat1_price<0){
														   $dontSave = 1;
													   }else{
														   $clnt->balance_amt = $clnt->balance_amt - $client->cat1_price;
													   }
												   break;
												   case 'Category 2':
													   if($client->balance_amt-$client->cat2_price<0){
														   $dontSave = 1;
													   }else{
														   $clnt->balance_amt = $clnt->balance_amt - $client->cat2_price;
													   }
												   break;
												   case 'Category 3':
													   if($client->balance_amt-$client->cat3_price<0){
														   $dontSave = 1;
													   }else{
														   $clnt->balance_amt = $clnt->balance_amt - $client->cat3_price;
													   }
												   break;
												   case 'Category X':
													   if($client->sold_on_position=='premium'){
														   $amtToDeduct = $client->premium_price;
													   }
													   if($client->sold_on_position=='platinum'){
														   $amtToDeduct = $client->platinum_price;
													   }
													   if($client->sold_on_position=='king'){
														   $amtToDeduct = $client->king_price;
													   }
													   if($client->sold_on_position=='royal'){
														   $amtToDeduct = $client->royal_price;
													   }
													   if($client->sold_on_position=='preferred'){
														   $amtToDeduct = $client->preferred_price;
													   }
													   if($client->balance_amt-$amtToDeduct<0){
														   $dontSave = 1;
													   }else{
														   $clnt->balance_amt = $clnt->balance_amt - $amtToDeduct;
													   }
												   break;
											   } */
											if ($dontSave) {
												//$this->intimateDefaulterClients($client, $lead);
												continue;
											} else {

												$clnt->save();
											}
										}
									}
									/* else if($client->client_type == 'count_based_subscription'){
										$clnt = Client::find($client->id);
										if($clnt){
											//$dontSave = 0;
											if($clnt->leads_remaining==0){
												$this->intimateDefaulterClients($client, $lead);
												continue;
											}
											else{
												$clnt->leads_remaining = $clnt->leads_remaining-1;	
												if($clnt->leads_remaining==0){
													$clnt->expired_on = date("Y-m-d H:i:s");
												}
												$clnt->save();
											}
										}
									} */

									$assignvalidation = AssignedLead::where('client_id', $clientC->client_id)->where('kw_id', $lead->kw_id)->where('lead_id', $lead->id)->get()->count();
									if ($assignvalidation == 0) {

										$assignedLead = new AssignedLead;
										$assignedLead->kw_id = $lead->kw_id;
										$assignedLead->client_id = $clientC->client_id;
										$assignedLead->lead_id = $lead->id;
										// $assignedLead->coins = $coinsAmt;
										if ($assignedLead->save()) {
											$lead->push_by = Auth::user()->id;
											$lead->assign_status = 1;
											$lead->save();




											$mobile = "1234556787";
											if (!empty($clientC->mobile)) {
												$smsMessage = "Dear," . $clientC->first_name . ' ' . $clientC->last_name;
												$smsMessage .= "%0D%0A";
												$smsMessage .= "%0D%0AName: " . ucfirst($lead->name);
												$smsMessage .= "%0D%0ACourse: " . preg_replace('/&/', '', $lead->kw_text);
												$smsMessage .= "%0D%0ACity: " . $lead->city_name;
												if (!empty($lead->email)) {
													$smsMessage .= "%0D%0AEmail: " . $lead->email;
												}
												$smsMessage .= "%0D%0AMob: " . $lead->mobile;
												$smsMessage .= "%0D%0A QuickDials Team";
												//sendSMS(trim($client->mobile),$smsMessage);
												//sendSMS(trim($mobile),$smsMessage);
												if (!empty($clientC->sec_mobile)) {
													//sendSMS($client->sec_mobile,$smsMessage);
												}
											}
											if (!empty($clientC->email)) {
												 

											$frmcheckText = '';
											if (!empty($lead->frmcheck)) {
												$frmcheckArray = is_array($lead->frmcheck)
													? $lead->frmcheck
													: json_decode($lead->frmcheck, true);
												if (is_array($frmcheckArray)) {
													$frmcheckText = implode(', ', $frmcheckArray);
												}
											}

											$parts = array_filter([
											$lead->kw_text ? "Interested in {$lead->kw_text}" : '',
											$frmcheckText ? "Mode of {$frmcheckText}" : '',
											$lead->zone ? "Location {$lead->zone}" : '',
											$lead->plan ? "Plan {$lead->plan}" : '',
											$lead->age ? "Age {$lead->age}" : '',
											$lead->experience ? "Experience {$lead->experience}" : '',
											]);

											$remark = implode(" • ", $parts);

											if (!empty($lead->remark)) {
											$remark .= " " . trim($lead->remark);
											}

											$lead->remarks = $remark;	
												 
												$template = 'emails.sendlead';
												$clientname=$clientC->business_name;
												$check=  Mail::send($template, ['clientname'=>$clientname,'lead'=>$lead], function ($m) use ($clientC,$lead) {    
												$m->from('leads.quickdials@gmail.com', 'QuickDials');             

												$m->to($clientC->email, $lead->name)->subject($lead->kw_text.' | '.$lead->name.' - Quickdials.com');
												});

											}


										}
									}



								}

							}
							$kw = Keyword::find($lead->kw_id);
							$kw->bucket = $i + 1;
							$kw->save();
						}
						$i++;



					}



					return response()->json([
						"statusCode" => 1,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Lead pushed successfully !!"
						]
					], 200);


				} else {

					return response()->json([
						"statusCode" => 1,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Not Found Client in this area!!"
						]
					], 200);


				}


			}
		}

	}
	public function pushLeadWithoutZone(Request $request, $id = null)
	{

		if (!$id) {
			return response()->json([
				"statusCode" => false,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => "Lead id cannot be null !!"
				]
			], 400);
		}
		if ($request->ajax()) {
			$lead = Lead::find($id);
			if (!$lead) {
				return response()->json([
					"statusCode" => false,
					"data" => [
						"responseCode" => 404,
						"message" => "Lead not found !!"
					]
				], 404);
			}

			if (!Citieslists::where('id', $lead->city_id)->exists()) {
				return response()->json([
					"statusCode" => false,
					"data" => [
						"responseCode" => 404,
						"message" => "City not found, please update city !!"
					]
				], 404);
			}
			$keyword = Keyword::find($lead->kw_id);
			if (!$keyword) {
				return response()->json([
					"statusCode" => false,
					"data" => [
						"responseCode" => 404,
						"message" => "Course not found, please update course !!"
					]
				], 404);
			}

			$bucketIndex = (int) $keyword->bucket;


			if (!empty($lead)) { 

				$baseQuery  = DB::table('clients')				 
					 ->leftJoin('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id')
					->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
					->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
					->join(
						'keyword_sell_count',
						'keyword_sell_count.slug',
						'=',
						DB::raw('LOWER(clients.client_type)')
					)
					->select(
						'clients.id as client_id',
						'clients.business_name',
						'clients.client_type',
						'clients.coins_amt',
						'clients.mobile',
						'clients.email',
						'keyword.category',
						'keyword_sell_count.*'
					)
					->where('keyword.id', $lead->kw_id)
					->whereNull('clients.deleted_at')
					->where('clients.coins_amt', '>', '0');
					$orderBy = "
						CASE 
							WHEN LOWER(clients.client_type) = 'platinum' THEN 1
							WHEN LOWER(clients.client_type) = 'diamond' THEN 2
							WHEN LOWER(clients.client_type) = 'gold' THEN 3
							WHEN LOWER(clients.client_type) = 'silver' THEN 4
							ELSE 5
						END
					";
					$clientsList = (clone $baseQuery)
						->where('assigned_zones.city_id', $lead->city_id)
						->where('assigned_zones.zone_id', $lead->zone_id)
						->distinct()
						->orderByRaw($orderBy)
						->get();

					if ($clientsList->isEmpty()) {
						$clientsList = (clone $baseQuery)
							->where('assigned_zones.city_id', $lead->city_id)
							->distinct()
							->orderByRaw($orderBy)
							->get();
					}

					if ($clientsList->isEmpty()) {
						$clientsList = (clone $baseQuery)
							->distinct()
							->orderByRaw($orderBy)
							->get();
					}

					if ($clientsList->isEmpty()) {

					return response()->json([
						"statusCode" => 1,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Not Found Client in this area!!"
						]
					], 200);


				}
	 
				// ******************
				$max = $mCount = 4;
				$i = 0;
				$totalClients = count($clientsList);
				$buckets = [];
				foreach ($clientsList as $client) {
					if ($mCount == 0) {
						$j = $i;
						$buckets[++$j] = $buckets[$i++];
						$buckets[$j]['diamond'] = [];
						$mCount = $max - (count($buckets[$j], 1) - 4);
					}
					if ($client->client_type == 'platinum') {
						$buckets[$i]['platinum'][] = $client;
					}
					if ($client->client_type == 'diamond') {
						$buckets[$i]['diamond'][] = $client;
					}
					if ($client->client_type == 'gold') {
						$buckets[$i]['gold'][] = $client;
					}
					if ($client->client_type == 'silver') {
						$buckets[$i]['silver'][] = $client;
					}
					--$mCount;
				}
				$i = 0;
			 
				$bucketCount = count($buckets);
				if (!empty($clientsList)) {
					foreach ($buckets as $bucket) {
						if ($bucketCount <= $bucketIndex || $bucketIndex == 0) {
							$bucketIndex = 0;
						}

						if ($bucketIndex == $i) {
 
							foreach ($bucket as $position => $clientss) {

								foreach ($clientss as $clientC) {
 
									if ($clientC->client_type) {


										$clnt = Client::find($clientC->client_id);
 
										if ($clnt) {
											$dontSave = 0;										$keyword = Keyword::find($lead->kw_id);
										$keywordSellCount = KeywordSellCount::where('slug', strtolower($clientC->client_type))->first();


												$coinsAmt = match ($keyword->category) {
													'Category 1'  => $keywordSellCount->cat1_price,
													'Category 2'  => $keywordSellCount->cat2_price,
													'Category 3'  => $keywordSellCount->cat3_price,
													'Category 4'  => $keywordSellCount->cat4_price,
													'Category 5'  => $keywordSellCount->cat5_price,
													'Category 6'  => $keywordSellCount->cat6_price,
													'Category 7'  => $keywordSellCount->cat7_price,
													'Category 8'  => $keywordSellCount->cat8_price,
													'Category 9'  => $keywordSellCount->cat9_price,
													'Category 10' => $keywordSellCount->cat10_price,
													default       => 95,
												};
													if ($clientC->coins_amt < $coinsAmt) {
														continue;
													}
														
									$clnt->coins_amt -= $coinsAmt;
															 
									$assignvalidation = AssignedLead::where('client_id', $clientC->client_id)->where('kw_id', $lead->kw_id)->where('lead_id', $lead->id)->get();
							 
								 
									if ($assignvalidation->isEmpty()) {

										$assignedLead = new AssignedLead;
										$assignedLead->kw_id = $lead->kw_id;
										$assignedLead->client_id = $clientC->client_id;
										$assignedLead->lead_id = $lead->id;
										$assignedLead->coins = $coinsAmt;
										 
										if ($assignedLead->save()) {
											$lead->push_by = Auth::user()->id;
											$lead->assign_status = '1';
											$lead->pushed = '1';
											$lead->save();

											$mobile = "1234556787";
											if (!empty($clientC->mobile)) {
												// $smsMessage = "Dear," . $clnt->first_name . ' ' . $clnt->last_name;
												// $smsMessage .= "%0D%0A";
												// $smsMessage .= "%0D%0AName: " . ucfirst($lead->name);
												// $smsMessage .= "%0D%0ACourse: " . preg_replace('/&/', '', $lead->kw_text);
												// $smsMessage .= "%0D%0ACity: " . $lead->city_name;
												// if (!empty($lead->email)) {
												// 	$smsMessage .= "%0D%0AEmail: " . $lead->email;
												// }

												// $smsMessage .= "%0D%0AMob: " . $lead->mobile;
												// $smsMessage .= "%0D%0A QuickDials Team";
												//sendSMS(trim($client->mobile),$smsMessage);
												//sendSMS(trim($mobile),$smsMessage);
												if (!empty($clnt->sec_mobile)) {
													//sendSMS($client->sec_mobile,$smsMessage);
												}
											}
											if (!empty($clnt->email)) {

											$frmcheckText = '';
											if (!empty($lead->frmcheck)) {
												$frmcheckArray = is_array($lead->frmcheck)
													? $lead->frmcheck
													: json_decode($lead->frmcheck, true);
												if (is_array($frmcheckArray)) {
													$frmcheckText = implode(', ', $frmcheckArray);
												}
											}

											$parts = array_filter([
											$lead->kw_text ? "Interested in {$lead->kw_text}" : '',
											$frmcheckText ? "Mode of {$frmcheckText}" : '',
											$lead->zone ? "Location {$lead->zone}" : '',
											$lead->plan ? "Plan {$lead->plan}" : '',
											$lead->age ? "Age {$lead->age}" : '',
											$lead->experience ? "Experience {$lead->experience}" : '',
											]);

											$remark = implode(" • ", $parts);

											if (!empty($lead->remark)) {
											$remark .= " " . trim($lead->remark);
											}

											$lead->remarks = $remark;	
												 
												$template = 'emails.sendlead';
												$clientname=$clnt->business_name;
												$check=  Mail::send($template, ['clientname'=>$clientname,'lead'=>$lead], function ($m) use ($clnt,$lead) {    
												$m->from('leads.quickdials@gmail.com', 'QuickDials');             

												$m->to($clnt->email, $lead->name)->subject($lead->kw_text.' | '.$lead->name.' - Quickdials.com');
												});
											
												

											}
 										//event(new LeadPush($lead,$clnt->id));

										}
									}

									$clnt->save();	
								}

								}

							}
						
						}
						$kw = Keyword::find($lead->kw_id);
						$kw->bucket = $i + 1;					 
						$kw->save();

					}
					$i++;
				} 				 
			} 
		} 		
		return response()->json([
					"statusCode" => true,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Lead pushed successfully !!"
					]
				], 200);
			}
	}

 
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editss(Request $request, $id)
	{

		if (null == $id) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 500,
					"payload" => "",
					"message" => "lead id cannot be null"
				]
			], 200);
		}
		try {
			$lead = Lead::findOrFail($id);
			if ($lead) {

				$citieslists = Citieslists::orderBy('city', 'ASC')->get();
				$cityHtml = '';
				if (!empty($citieslists)) {
					foreach ($citieslists as $city) {
						if ($city->city == $lead->city_name) {
							$cityHtml .= '<option value="' . $city->city . '" selected>' . $city->city . '</option>';
						} else {
							$cityHtml .= '<option value="' . $city->city . '">' . $city->city . '</option>';
						}
					}
				}

				 
				$areaZoneOptionHtml = "";
				if (!empty($lead->zone_id)) {
					$zonelists = Zone::where('id',$lead->zone_id)->orderBy('zone', 'ASC')->first();
				if ($zonelists) {
					$areaZoneOptionHtml .= "<option value='{$zonelists->id}' selected>{$zonelists->zone} ({$zonelists->pincode})</option>";
				}
				}

				$keywordlists = Keyword::orderBy('keyword', 'ASC')->get();
				$kwOptionHtml = '<option value="" >Select Keyword</option>';
				if (!empty($keywordlists)) {
					foreach ($keywordlists as $keyword) {
						if ($keyword->id == $lead->kw_id) {
							$kwOptionHtml .= '<option value="' . $keyword->id . '" selected>' . $keyword->keyword . '</option>';
						} else {
							$kwOptionHtml .= '<option value="' . $keyword->id . '">' . $keyword->keyword . '</option>';
						}
					}
				}





				$userOptionHtml = "";
				if (null != $lead->created_by) {
					$user = DB::table('users');
					$user = $user->select('users.*');
					$user = $user->where('users.id', $lead->created_by);
					$user = $user->first();
					if ($user) {
						$userOptionHtml .= "<option value='{$user->id}' selected>{$user->first_name} {$user->last_name}</option>";
					}
				}
				$html = '
					<div id="newlead-edit-modal" class="modal fade" role="dialog">
						<div class="modal-dialog modal-lg">
							<form onsubmit="return pushLeadController.updateNewLead(this,' . $lead->id . ')">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-fw fa-pencil-square-o"></i> Edit Lead - "' . $lead->name . '"</h4>
									</div>
									<div class="modal-body">
										<div class="container col-md-12">
											<div class="row">
												<div class="alert alert-danger" style="display:none;"></div>
												<div class="alert alert-success" style="display:none;"></div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Select City</label>
														<select class="form-control location city select2-single" name="city_id">
															<option value="">-- SELECT CITY --</option>
																' . $cityHtml . '
														</select>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Name</label>
														<input class="form-control" placeholder="Name" type="text" name="name" value="' . $lead->name . '" />
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Email</label>
														<input class="form-control" placeholder="Email" name="email" type="email" value="' . $lead->email . '" />
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Mobile</label>
														<input class="form-control" placeholder="Mobile" name="mobile" type="tel" value="' . $lead->mobile . '" />
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Find Area</label>
														<select name="area_zone" class="form-control" tabindex="-1" aria-hidden="true">
															' . $areaZoneOptionHtml . '
														</select>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Find Course</label>
														<select class="form-control select2_course" name="kw_text" tabindex="-1" aria-hidden="true" >
															' . $kwOptionHtml . '
														</select>
													</div>
												</div>
												 
												<div class="col-md-4">
													<div class="form-group">
														<label>Find Owner</label>
														<select name="created_by" class="form-control" tabindex="-1" aria-hidden="true">
															' . $userOptionHtml . '
														</select>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Remark</label>
														<textarea class="form-control" rows="3" placeholder="Remark" name="remark">' . $lead->remark . '</textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-default">Update</button>
										<button type="button" class="btn btn-default" onclick="javascript:pushLeadController.closePushLeadEditModal()">Close</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				';
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => $html,
						"message" => ""
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 404,
						"payload" => "",
						"message" => "Lead not found"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Lead not found"
				]
			], 200);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateNewLead(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|unique:leads,name,' . $id . ',id,mobile,' . $request->input('mobile'),
			'mobile' => 'required',
			'city_id' => 'required',
			//	'area_zone'=>'required',
			'kw_text' => 'required',
			'created_by' => 'required',
		], [
			'name.unique' => 'Record already exists in the table.',
		]);
		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			$errors = [];
			foreach ($errorsBag as $error) {
				$errors[] = implode("<br/>", $error);
			}
			$errors = implode("<br/>", $errors);
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => $errors
				]
			], 200);
		}
		try {
			$lead = Lead::findOrFail($id);
			if ($lead) {


				$city = Citieslists::where('city', $request->input('city_id'))->first();
				$lead->city_id = $city->id;
				$lead->city_name = $city->city;
				$lead->name = $request->input('name');
				if (!empty($request->input('email'))) {
					$lead->email = $request->input('email');
				}
				$lead->mobile = $request->input('mobile');
				$lead->created_by = $request->input('created_by');


				if ($request->input('area_zone') != '') {
					$lead->zone_id = $request->input('area_zone');
					$areas = DB::table(DB::raw("(SELECT * FROM areas WHERE id={$request->input('area_zone')}) as aa"));
					$areas = $areas->join('zones', 'zones.id', '=', DB::raw('`aa`.`zone_id`'));
					$areas = $areas->select('aa.id', 'aa.area', 'aa.zone_id', 'zones.zone');
					$areas = $areas->first();
					$lead->area = $areas->zone . " " . "(" . $areas->area . ")";
					$lead->area_id = $areas->id;
					$lead->zone_id = $areas->zone_id;
				}

				$keyword = Keyword::where('id', $request->input('kw_text'))->first();

				if (count($keyword) > 0) {
					$lead->kw_id = $keyword->id;
					$lead->kw_text = $keyword->keyword;
					$bucketIndex = $keyword->bucket;
				} else {

					return response()->json([
						"statusCode" => 0,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Course not found please update"
						]
					], 200);

				}

				$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				if ($lead->save()) {
					return response()->json([
						"statusCode" => 1,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Lead updated successfully."
						]
					], 200);
				} else {
					return response()->json([
						"statusCode" => 0,
						"data" => [
							"responseCode" => 400,
							"payload" => "",
							"message" => "Lead not updated."
						]
					], 200);
				}
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => $e->getMessage()
				]
			], 200);
		}
	}

	public function intimateDefaulterClients($client, $lead)
	{
		$leadDetail = DB::table('leads')
			->join('citylists', 'leads.city_id', '=', 'citylists.id')
			->select('leads.*', 'citylists.city')
			->where('leads.id', $lead->id)
			->first();


		$assignvalidation = AssignedLead::where('client_id', $client->id)->where('kw_id', $leadDetail->kw_id)->where('lead_id', $leadDetail->id)->get()->count();
		if ($assignvalidation == 0) {

			$assignedLead = new AssignedLead;
			$assignedLead->kw_id = $leadDetail->kw_id;
			$assignedLead->client_id = $client->id;
			$assignedLead->lead_id = $leadDetail->id;
			// $assignedLead->coins = $coinsAmt;
			if ($assignedLead->save()) {
				$lead = Lead::findOrFail($lead->id);
				$lead->push_by = Auth::user()->id;
				$lead->assign_status = 1;
				$lead->save();


				$mobile = "1234556787";
				if (!empty($client->mobile)) {
					$smsMessage = "Dear," . $client->first_name . ' ' . $client->last_name;
					$smsMessage .= "%0D%0A";
					$smsMessage .= "%0D%0AName: " . ucfirst($leadDetail->name);
					$smsMessage .= "%0D%0ACourse: " . preg_replace('/&/', '', $leadDetail->kw_text);
					$smsMessage .= "%0D%0ACity: " . $leadDetail->city_name;
					if (!empty($leadDetail->email)) {
						$smsMessage .= "%0D%0AEmail: " . $leadDetail->email;
					}
					$smsMessage .= "%0D%0AMob: " . $leadDetail->mobile;
					$smsMessage .= "%0D%0A QuickDials Team";
					//sendSMS(trim($client->mobile),$smsMessage);
					//sendSMS(trim($mobile),$smsMessage);
					if (!empty($client->sec_mobile)) {
						//sendSMS($client->sec_mobile,$smsMessage);
					}
				}
				if (!empty($client->email)) {
					/* $template = 'emails.assignleadtoclient';
					$clientname=$client->business_name;
					$check=  Mail::send($template, ['clientname'=>$clientname,'lead'=>$lead], function ($m) use ($client,$lead) {    
					$m->from('info@quickdials.com', 'quickdials');             
					//$client->email
					$m->to('info@quicindia.in', $lead->name)->subject('quickdials Lead: '.$lead->kw_text)->cc('quickdials1@gmail.com');
					});	
					*/

				}


			}
		}



	}

	/**
	 * Send client registration mail to client containing user name password.
	 *
	 * @param  object  $client
	 */
	public function sendLeadEmail($client, $lead, $type = null)
	{
		$template = 'emails.sendlead';
		if (!is_null($type) && $type == 'defaulter') {
			$template = 'emails.send_lead_to_defaulters';
		}

		$check = Mail::send($template, ['client' => $client, 'lead' => $lead], function ($m) use ($client, $lead) {

			$m->from('info@quickdials.com', 'QuickDials');
			$email = "info@quicindia.com";
			//$client->email
			// $m->to('info@quicindia.in', $client->first_name." ".$client->last_name)->subject('quickdials Lead: '.$lead->kw_text);
		});

	}

	/**
	 * Get paginated leads.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getLeadsExcel(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('export_lead'))) {
			return view('errors.unauthorised');
		}

		$leads = DB::table('leads as leads');

		$leads = $leads->select('leads.*');
		if ($request->input('search.value') != '') {
			$leads = $leads->where(function ($query) use ($request) {
				$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('leads.email', 'LIKE', '%' . $request->input('search.value') . '%');
			});
		}
		if ($request->input('search.assign_status') != '') {
			$leads = $leads->where('leads.assign_status', '=', $request->input('search.assign_status'));
		}

		if ($request->input('search.lead_type') != '') {
			$leads = $leads->where('leads.b_end', '=', $request->input('search.lead_type'));
		}
		if ($request->input('search.user') != '') {
			$leads = $leads->where('leads.created_by', '=', $request->input('search.user'));
		}


		if ($request->input('search.city') != '') {
			$cityss = $request->input('search.city');
			$cityarr = explode(',', $cityss);
			if (!empty($cityarr)) {
				foreach ($cityarr as $city) {
					$cityList[] = $city;
				}
				$leads = $leads->whereIn('leads.city_name', $cityList);
			}
		}


		if ($request->input('search.course') != '') {
			$courses = $request->input('search.course');
			$coursesarr = explode(',', $courses);

			if (!empty($coursesarr)) {
				foreach ($coursesarr as $course) {
					$courseList[] = $course;
				}
				$leads = $leads->whereIn('leads.kw_text', $courseList);
			}
		}

		if ($request->input('search.status') != '') {
			$statuss = $request->input('search.status');
			$statusarr = explode(',', $statuss);

			if (!empty($statusarr)) {
				foreach ($statusarr as $status) {
					$statusList[] = $status;
				}
				$leads = $leads->whereIn('leads.status_id', $statusList);
			}
		}



		if ($request->input('search.datef') != '') {
			$leads = $leads->whereDate('leads.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
		}
		if ($request->input('search.datet') != '') {
			$leads = $leads->whereDate('leads.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
		}
		$leads = $leads->orderBy('leads.id', 'desc');
		$leads = $leads->get();

		$returnLeads = [];
		$arr = [];

		foreach ($leads as $lead) {
			$arr[] = [
				"Name" => $lead->name,
				"Mobile" => $lead->mobile,
				"Email" => $lead->email,
				"Area" => $lead->area,
				"Course" => $lead->kw_text,
				"City" => $lead->city_name,
				"Status" => $lead->status_name,
				"Date" => date_format(date_create($lead->created_at), 'd-M-Y')
			];
		}

		$excel = \App::make('excel');
		Excel::create('Leads_' . date('Y-m-d_H:i'), function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('xls');
	}

	// ***********
	// Lead Repost
	function leadRepost(Request $request, $id = null)
	{
		if (!$request->user()->current_user_can('administrator|admin')) {
			return view('errors.unauthorised');
		}
		if (null == $id) {
			return response()->json([
				'error' => 1,
				'error_bag' => [
					'description' => 'Lead id cannot be null'
				]
			], 400);
		}
		$lead = Lead::find($id);
		if ($lead && $lead->save()) {

			$keyword = Keyword::find($lead->kw_id);
			if ($keyword) {
				$bucketIndex = $keyword->bucket;
			} else {
				return response()->json(['status' => 1, 'msg' => 'Keyword not found'], 404);
			}

			$responseStatus = $this->sendLeadToBucket($lead, $bucketIndex);
			if ($responseStatus) {
				return response()->json(['status' => 1, 'msg' => 'Lead added successfully'], 200);
			} else {
				return response()->json([], 400);
			}
		}
	}
	// Lead Repost
	// ***********

	// **************************************
	// Send Lead To Bucket - Bucket Algorithm
	function sendLeadToBucket($lead, $bucketIndex)
	{
		// BUCKET ALGORITHM
		// ****************
		$clientsList = DB::table('clients')
			->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position')
			->select('clients.*', 'assigned_kwds.sold_on_position', 'keyword.category', 'keyword_sell_count.cat1_price', 'keyword_sell_count.cat2_price', 'keyword_sell_count.cat3_price', 'keyword.premium_price', 'keyword.platinum_price', 'keyword.king_price', 'keyword.royal_price', 'keyword.preferred_price')
			->where('keyword.id', '=', $lead->kw_id)
			->whereNull('clients.deleted_at')
			->where(function ($query) {
				$query->where(function ($query) {
					$query->where('clients.client_type', 'lead_based')
						->where('clients.balance_amt', '>', '0');
				})
					->orWhere(function ($query) {
						$query->where(function ($query) {
							$query->where('clients.client_type', 'free_subscription')
								->orWhere('clients.client_type', 'yearly_subscription');
						})
							->whereDate('clients.yrly_subs_end_date', '>', date('Y-m-d'));
					});
			})
			->where('active_status', '1')
			->orderby(DB::raw('(CASE `assigned_kwds`.`sold_on_position` WHEN \'premium\' THEN 1 WHEN \'platinum\' THEN 2 WHEN \'king\' THEN 3 WHEN \'royal\' THEN 4 WHEN \'preferred\' THEN 5 END)'), 'asc')
			//->orderby('comment_count','desc')
			//->tosql();
			->get();

		$defaulterClientsList = DB::table('clients')
			->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->join('keyword_sell_count', 'keyword_sell_count.slug', '=', 'assigned_kwds.sold_on_position')
			->select('clients.*', 'assigned_kwds.sold_on_position', 'keyword.category', 'keyword_sell_count.cat1_price', 'keyword_sell_count.cat2_price', 'keyword_sell_count.cat3_price', 'keyword.premium_price', 'keyword.platinum_price', 'keyword.king_price', 'keyword.royal_price', 'keyword.preferred_price')
			->where('keyword.id', '=', $lead->kw_id)
			->whereNull('clients.deleted_at')
			->where(function ($query) {
				$query->where(function ($query) {
					$query->where('clients.client_type', 'lead_based')
						->where('clients.balance_amt', '<=', '0');
				})
					->orWhere(function ($query) {
						$query->where(function ($query) {
							$query->where('clients.client_type', 'free_subscription')
								->orWhere('clients.client_type', 'yearly_subscription');
						})
							->whereDate('clients.yrly_subs_end_date', '<=', date('Y-m-d'));
					});
			})
			->orderby(DB::raw('(CASE `assigned_kwds`.`sold_on_position` WHEN \'premium\' THEN 1 WHEN \'platinum\' THEN 2 WHEN \'king\' THEN 3 WHEN \'royal\' THEN 4 WHEN \'preferred\' THEN 5 END)'), 'asc')
			//->orderby('comment_count','desc')
			//->tosql();
			->get();
		foreach ($defaulterClientsList as $defaulterClient) {
			$this->intimateDefaulterClients($defaulterClient, $lead);
		}

		//return $clientsList;

		// BUCKET CALCULATION
		// ******************
		$max = $mCount = 20;
		$i = 0;
		$totalClients = count($clientsList);
		$buckets = [];
		foreach ($clientsList as $client) {
			if ($mCount == 0) {
				$j = $i;
				$buckets[++$j] = $buckets[$i++];
				$buckets[$j]['preferred'] = [];
				$mCount = $max - (count($buckets[$j], 1) - 5);
			}
			if ($client->sold_on_position == 'premium') {
				$buckets[$i]['premium'][] = $client;
			}
			if ($client->sold_on_position == 'platinum') {
				$buckets[$i]['platinum'][] = $client;
			}
			if ($client->sold_on_position == 'king') {
				$buckets[$i]['king'][] = $client;
			}
			if ($client->sold_on_position == 'royal') {
				$buckets[$i]['royal'][] = $client;
			}
			if ($client->sold_on_position == 'preferred') {
				$buckets[$i]['preferred'][] = $client;
			}
			--$mCount;
		}
		$i = 0;
		$bucketCount = count($buckets);
		//return $buckets;

		foreach ($buckets as $bucket) {
			if ($bucketCount <= $bucketIndex || $bucketIndex == 0) {
				$bucketIndex = 0;
			}
			if ($bucketIndex == $i) {
				foreach ($bucket as $position => $clients) {
					foreach ($clients as $client) {
						if ($client->client_type == 'lead_based') {
							$clnt = Client::find($client->id);
							$dontSave = 0;
							switch ($client->category) {
								case 'Category 1':
								case 'Category 2':
								case 'Category 3':
									if ($client->balance_amt - $client->sold_on_price < 0) {
										$dontSave = 1;
									} else {
										$clnt->balance_amt = $clnt->balance_amt - $client->sold_on_price;
									}
									break;
								case 'Category X':
									if ($client->sold_on_position == 'premium') {
										$amtToDeduct = $client->sold_on_price;
									}
									if ($client->sold_on_position == 'platinum') {
										$amtToDeduct = $client->sold_on_price;
									}
									if ($client->sold_on_position == 'king') {
										$amtToDeduct = $client->sold_on_price;
									}
									if ($client->sold_on_position == 'royal') {
										$amtToDeduct = $client->sold_on_price;
									}
									if ($client->sold_on_position == 'preferred') {
										$amtToDeduct = $client->sold_on_price;
									}
									if ($client->balance_amt - $amtToDeduct < 0) {
										$dontSave = 1;
									} else {
										$clnt->balance_amt = $clnt->balance_amt - $amtToDeduct;
									}
									break;
							}
							/* switch($client->category){
								case 'Category 1':
									if($client->balance_amt-$client->cat1_price<0){
										$dontSave = 1;
									}else{
										$clnt->balance_amt = $clnt->balance_amt - $client->cat1_price;
									}
								break;
								case 'Category 2':
									if($client->balance_amt-$client->cat2_price<0){
										$dontSave = 1;
									}else{
										$clnt->balance_amt = $clnt->balance_amt - $client->cat2_price;
									}
								break;
								case 'Category 3':
									if($client->balance_amt-$client->cat3_price<0){
										$dontSave = 1;
									}else{
										$clnt->balance_amt = $clnt->balance_amt - $client->cat3_price;
									}
								break;
								case 'Category X':
									if($client->sold_on_position=='premium'){
										$amtToDeduct = $client->premium_price;
									}
									if($client->sold_on_position=='platinum'){
										$amtToDeduct = $client->platinum_price;
									}
									if($client->sold_on_position=='king'){
										$amtToDeduct = $client->king_price;
									}
									if($client->sold_on_position=='royal'){
										$amtToDeduct = $client->royal_price;
									}
									if($client->sold_on_position=='preferred'){
										$amtToDeduct = $client->preferred_price;
									}
									if($client->balance_amt-$amtToDeduct<0){
										$dontSave = 1;
									}else{
										$clnt->balance_amt = $clnt->balance_amt - $amtToDeduct;
									}
								break;
							} */
							if ($dontSave) {
								$this->intimateDefaulterClients($client, $lead);
								continue;
							} else {
								if ($clnt->balance_amt < 5) {
									$clnt->expired_on = date("Y-m-d H:i:s");
								}
								$clnt->save();
							}
						}
						$assignedLead = new AssignedLead;
						$assignedLead->kw_id = $lead->kw_id;
						$assignedLead->client_id = $client->id;
						$assignedLead->lead_id = $lead->id;
						$assignedLead->coins = $amtToDeduct;
						if ($assignedLead->save()) {
							// send leads through mail
							$leadDetail = DB::table('leads')
								->join('citylists', 'leads.city_id', '=', 'citylists.id')
								->select('leads.*', 'citylists.city')
								->where('leads.id', $lead->id)
								->get();
							if (null != $client->email || '' != $client->email) {
								$this->sendLeadEmail($client, $leadDetail[0]);
							}
							/* $smsMessage = "Enquiry on Quick Dials:
							%0D%0AName: ".$leadDetail[0]->name."
							%0D%0ALooking For: ".$leadDetail[0]->kw_text."
							%0D%0AIn City: ".$leadDetail[0]->city."
							%0D%0AMobile: ".$leadDetail[0]->mobile."
							%0D%0AEmail: ".$leadDetail[0]->email."
							%0D%0AArea: ".$leadDetail[0]->area."
							%0D%0ARemark: ".$leadDetail[0]->remark."
							%0D%0A--
							%0D%0AQuick Dials"; */
							$smsMessage = "Dear Institute,";
							$smsMessage .= "%0D%0A%0D%0A";
							$smsMessage .= $leadDetail[0]->name . " enquired for " . $leadDetail[0]->kw_text . " Training.";
							if (!empty($leadDetail[0]->email)) {
								$smsMessage .= "%0D%0AEmail: " . $leadDetail[0]->email;
							}
							$smsMessage .= "%0D%0AMob: " . $leadDetail[0]->mobile;
							$smsMessage .= "%0D%0ACity: " . $leadDetail[0]->city;
							$smsMessage .= "%0D%0AArea: " . $leadDetail[0]->area;
							$smsMessage .= "%0D%0A- Quick Dials Team";
							//	sendSMS($client->mobile,$smsMessage);
							//	if(!empty($client->sec_mobile))
							//	sendSMS($client->sec_mobile,$smsMessage);

						}
					}
				}


				$kw = Keyword::find($lead->kw_id);
				$kw->bucket = $i + 1;
				$kw->save();
			}
			$i++;
		}
		return true;
	}

	public function newlead(Request $request)
	{

		$citieslist = Citieslists::select('id', 'city')->orderBy('city', 'ASC')->get();

		$kwds = Keyword::select('id', 'keyword')->orderBy('keyword', 'asc')->get();
		$statuses = Status::where('lead_filter', 1)->orderBy('name', 'asc')->get();
		$search = [];


		if ($request->has('search')) {
			$search = $request->input('search');

		}
		$clientlist = Client::get();

		return view('admin.lead.newleads', [
			'citieslist' => $citieslist,
			'statuses' => $statuses,
			'kwds' => $kwds,
			'search' => $search,
			'clientlist' => $clientlist
		]);
	}
	public function getnewlead(Request $request)
	{

		if ($request->ajax()) {

			$leads = DB::table('leads');
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.kw_text', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.city_name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.email', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			if ($request->input('search.city') != '') {
				$leads = $leads->where('leads.city_name', '=', $request->input('search.city'));
			}
			if ($request->input('search.course') != '') {
				$leads = $leads->where('leads.kw_text', 'LIKE', $request->input('search.course'));
			}
			if ($request->input('search.datef') != '') {
				$leads = $leads->whereDate('leads.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
			}
			if ($request->input('search.datet') != '') {
				$leads = $leads->whereDate('leads.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
			}
			if ($request->input('search.lead_type') != '') {
				$leads = $leads->where('leads.b_end', 'LIKE', $request->input('search.lead_type'));
			}
			$leads = $leads->orderBy('leads.id', 'desc');
			$leads = $leads->paginate($request->input('length'));

			$returnLeads = $data = $owner = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			$returnLeads['recordCollection'] = [];
			$users = DB::table('users')->select('users.id', 'users.first_name', 'users.last_name')->get();
			if ($users) {
				foreach ($users as $user) {
					$owner[$user->id] = $user->first_name . " " . $user->last_name;
				}
			}


			$clients = DB::table('clients')->select('clients.business_name', 'clients.id')->get();
			if ($clients) {
				foreach ($clients as $client) {
					$clientname[$client->id] = $client->business_name;
				}
			}



			foreach ($leads as $lead) {

				$owner_name = '';
				if ($lead->created_by != null && isset($owner[$lead->created_by])) {
					$owner_name = $owner[$lead->created_by];
				}

				if ($lead->b_end == 1) {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:red\" class=\"fa fa-fw fa-asterisk\"></i>";
					$lead_from = "Internal";
				} else if ($lead->b_end == 2) {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:green\" class=\"fa fa-fw fa-adn\"></i>";
					$lead_from = "Advertise";
				} else if ($lead->b_end == 3) {
					$leadname = $lead->name;
					$lead_from = "Leads";
				} else {
					$leadname = $lead->name;
					$lead_from = "External";
				}
				$assign = "";
				$assignedLeadsCount = AssignedLead::where('lead_id', '=', $lead->id)->get();
				$meetingsHtml = '';

				foreach ($assignedLeadsCount as $assignedLeads) {
					$meetingsHtml .= '<li>' . $clientname[$assignedLeads->client_id] . '</li>';
				}
				if (!empty($assignedLeadsCount->count())) {

					$assign = '<ul class="assign-elements">
					<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span class="btn btn-success btn-xs">' . count($assignedLeadsCount) . '	</span>		 
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
					' . $meetingsHtml . ' 
					</ul>
					</li>
					</ul>';
				}

				$action = '';
				$separator = '';
				$action .= $separator . '<a data-lead_id_follow="' . $lead->id . '" href="javascript:pushLeadController.getLeadFollowupForm(' . $lead->id . ')"  title="Follow Up Leads"><i class="fa fa-fw fa-eye"></i></a>';
				$separator = ' | ';

				//	$action .= $separator.'<a href="/developer/lead/edit/'.$lead->id.'" title="Edit clients"><i class="fa fa-fw fa-edit"></i></a>';
				//	$separator = ' | ';


				$action .= $separator . '<a href="javascript:pushLeadController.newleaddelete(' . $lead->id . ')" title="lead Delete"><i class="fa fa-fw fa-trash"></i></a>';
				$separator = ' | ';

				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$lead->id'></th>",
					$leadname,
					$lead_from,
					$lead->mobile,
					$lead->status_name,
					$lead->kw_text,
					$lead->city_name,
					(new Carbon($lead->created_at))->format('d-m-Y h:i:s'),
					$assign,
					($lead->push_by) ? $owner[$lead->push_by] : '',
					$action
				];
				$returnLeads['recordCollection'][] = $lead->id;
			}
			$returnLeads['data'] = $data;



			return response()->json($returnLeads);

		}
	}

	public function assignlead(Request $request)
	{  

	
		if ($request->ajax()) {
			$clientID = $request->input('client_id');
			$ids = $request->input('ids');

			if (null == $ids) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Lead id cannot be null !!"
					]
				], 400);
			}
			if ($clientID) {

				foreach ($clientID as $key => $cid) {

					if (!empty($ids)) {

						for ($i = 0; $i < count($ids); $i++) {

							$client = Client::findOrFail($cid);

							if (($client->coins_amt) > 0) {

								$lead = Lead::findOrFail($ids[$i]);
								try {
									Citieslists::findOrFail($lead->city_id);
								} catch (\Exception $e) {
									continue;
								}
								try {
									$keyword = Keyword::findOrFail($lead->kw_id);

								} catch (\Exception $e) {
									continue;
								}
								$assignvalidation = AssignedLead::where('client_id', $cid)->where('kw_id', $lead->kw_id)->where('lead_id', $ids[$i])->get()->count();

								if ($assignvalidation == 0) {
									$assignedLead = new AssignedLead;
									$assignedLead->client_id = $cid;
									$assignedLead->lead_id = $ids[$i];
									$assignedLead->kw_id = $lead->kw_id;

									$keyword = Keyword::find($lead->kw_id);
									$keywordSellCount = KeywordSellCount::where('slug', strtolower($client->client_type))->first();


									if ($keyword->category == 'Category 1') {
										$coinsAmt = $keywordSellCount->cat1_price;
									} else if ($keyword->category == 'Category 2') {
										$coinsAmt = $keywordSellCount->cat2_price;
									} else if ($keyword->category == 'Category 3') {
										$coinsAmt = $keywordSellCount->cat3_price;
									} else if ($keyword->category == 'Category 4') {
										$coinsAmt = $keywordSellCount->cat4_price;
									} else if ($keyword->category == 'Category 5') {
										$coinsAmt = $keywordSellCount->cat5_price;
									} else if ($keyword->category == 'Category 6') {
										$coinsAmt = $keywordSellCount->cat6_price;
									} else if ($keyword->category == 'Category 7') {
										$coinsAmt = $keywordSellCount->cat7_price;
									} else if ($keyword->category == 'Category 8') {
										$coinsAmt = $keywordSellCount->cat8_price;
									} else if ($keyword->category == 'Category 9') {
										$coinsAmt = $keywordSellCount->cat9_price;
									} else if ($keyword->category == 'Category 10') {
										$coinsAmt = $keywordSellCount->cat10_price;
									} else {
										$coinsAmt = 95;
									}
								

									$client->coins_amt = $client->coins_amt - $coinsAmt;
									$client->save();
									$assignedLead->coins = $coinsAmt;


									if ($assignedLead->save()) {

										$lead->push_by = Auth::user()->id;
										$lead->assign_status = 1;
										$lead->save();

										$followUp = new LeadFollowUp;
										$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
										$followUp->lead_id = $lead->id;
										$followUp->expected_date_time = date('Y-m-d H:i:s');
										$followUp->client_id = $client->id;
										$followUp->save();

							$frmcheckText = '';
							if (!empty($lead->frmcheck)) {
								$frmcheckArray = is_array($lead->frmcheck)
									? $lead->frmcheck
									: json_decode($lead->frmcheck, true);
								if (is_array($frmcheckArray)) {
									$frmcheckText = implode(', ', $frmcheckArray);
								}
							}

							$parts = array_filter([
							$lead->kw_text ? "Interested in {$lead->kw_text}" : '',
							$frmcheckText ? "Mode of {$frmcheckText}" : '',
							$lead->zone ? "Location {$lead->zone}" : '',
							$lead->plan ? "Plan {$lead->plan}" : '',
							$lead->age ? "Age {$lead->age}" : '',
							$lead->experience ? "Experience {$lead->experience}" : '',
							]);

							$remark = implode(" • ", $parts);

							if (!empty($lead->remark)) {
							$remark .= " " . trim($lead->remark);
							}

							$lead->remarks = $remark;	

								$template = 'emails.sendlead';
								$clientname=$client->business_name;
								$check=  Mail::send($template, ['clientname'=>$clientname,'lead'=>$lead], function ($m) use ($client,$lead) {    
								$m->from('leads.quickdials@gmail.com', 'QuickDials');             
							 
								$m->to($client->email, $lead->name)->subject($lead->kw_text.' | '.$lead->name.' - Quickdials.com');
								});	
									 	
								//event(new LeadPush($lead,$cid));

								// SendLeadMailJob::dispatch($lead, $client->email);


								

									}
								}
							}
						}

					}
				}
			}
			$resulsu = "AssignedLead";
		}

		return response()->json(['status' => 1, 'data' => $resulsu]);



	}
	public function assignleadAPI(Request $request)
	{
		if ($request->ajax()) {
			$clientID = $request->input('client_id');
			$ids = $request->input('ids');

			if (null == $ids) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Lead id cannot be null !!"
					]
				], 400);
			}
			if ($clientID) {

				foreach ($clientID as $key => $cid) {

					if (!empty($ids)) {

						for ($i = 0; $i < count($ids); $i++) {

							$client = Client::findOrFail($cid);
							$lead = Lead::findOrFail($ids[$i]);

							$assignvalidation = AssignedLead::where('client_id', $cid)->where('kw_id', $lead->kw_id)->where('lead_id', $ids[$i])->get()->count();

							if ($assignvalidation == 0) {
								$assignedLead = new AssignedLead;
								$assignedLead->client_id = $cid;
								$assignedLead->lead_id = $ids[$i];
								$assignedLead->kw_id = $lead->kw_id;
								$leads_list = array(
									'FirstName' => $lead->name,
									'Mobile' => $lead->mobile,
									'Email' => $lead->email,
									'CityName' => $lead->city_name,
									'CourseName' => $lead->kw_text,
									'SourceName' => "quickdials"
								);

								$keyword = Keyword::find($lead->kw_id);
								$keywordSellCount = KeywordSellCount::where('slug', strtolower($client->client_type))->first();


								if ($keyword->category == 'Category 1') {
									$coinsAmt = $keywordSellCount->cat1_price;
								} else if ($keyword->category == 'Category 2') {
									$coinsAmt = $keywordSellCount->cat2_price;
								} else if ($keyword->category == 'Category 3') {
									$coinsAmt = $keywordSellCount->cat3_price;
								} else if ($keyword->category == 'Category 4') {
									$coinsAmt = $keywordSellCount->cat4_price;
								} else if ($keyword->category == 'Category 5') {
									$coinsAmt = $keywordSellCount->cat5_price;
								} else if ($keyword->category == 'Category 6') {
									$coinsAmt = $keywordSellCount->cat6_price;
								} else if ($keyword->category == 'Category 7') {
									$coinsAmt = $keywordSellCount->cat7_price;
								} else if ($keyword->category == 'Category 8') {
									$coinsAmt = $keywordSellCount->cat8_price;
								} else if ($keyword->category == 'Category 9') {
									$coinsAmt = $keywordSellCount->cat9_price;
								} else if ($keyword->category == 'Category 10') {
									$coinsAmt = $keywordSellCount->cat10_price;
								} else {
									$coinsAmt = '130';
								}


								$client->coins_amt = $client->coins_amt - $coinsAmt;
								$client->save();
								$assignedLead->coins = $coinsAmt;
								if ($assignedLead->save()) {

									$lead->push_by = Auth::user()->id;
									$lead->save();
									$followUp = new LeadFollowUp;
									$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
									$followUp->lead_id = $lead->id;
									$followUp->expected_date_time = date('Y-m-d H:i:s');
									$followUp->client_id = $client->id;
									$followUp->save();
								}

								$data['status'] = true;
								$data['leadslist'] = $leads_list;
							}
						}

					}
				}
			}
		}
		echo json_encode($data);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function newleaddelete($id)
	{
		try {
			$leads = Lead::findorFail($id);
			$assignedLead = AssignedLead::where('lead_id', $id)->get();
			if (!empty($assignedLead)) {
				foreach ($assignedLead as $alead) {
					$lead = DB::table('assigned_leads')->where('lead_id', $alead->lead_id)->delete();
				}
			}

			$leadFollowUps = LeadFollowUp::where('lead_id', $id)->get();
			if (!empty($leadFollowUps)) {
				foreach ($leadFollowUps as $leadFollowUp) {
					$lead = DB::table('lead_follow_ups')->where('lead_id', $leadFollowUp->lead_id)->delete();
				}
			}

			if ($leads->delete()) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "New lead deleted successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "New lead not deleted !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => $e->getMessage(),
				]
			], 200);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function clientAssignleaddelete($id)
	{
		try {
			$assignedLead = AssignedLead::findorFail($id);
			$client = Client::findorFail($assignedLead->client_id);
			if (!empty($client)) {
				$client->leads_remaining = $client->leads_remaining + 1;
				$client->save();
			}
			if ($assignedLead->delete()) {


				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Assign lead deleted successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Assign lead  not deleted !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => $e->getMessage(),
				]
			], 200);
		}
	}

	public function followUp(Request $request, $id = null)
	{

	
 		$lead = Lead::findOrFail($id);


		if ($lead) {
			$leadLastFollowUp = DB::table('lead_follow_ups as lead_follow_ups')
				->where('lead_follow_ups.lead_id', '=', $id)
				->select('lead_follow_ups.*')
				->orderBy('lead_follow_ups.id', 'desc')
				->first();

			$statuses = Status::where('lead_follow_up', '1')->orderBy('name', 'ASC')->get();

			$statusHtml = '';
			$disabled = '';
			$dateValue = '';
 
			if (!empty($statuses)) {
				foreach ($statuses as $status) {
					if ($lead->status_id == $status->id) {
						$selected = 'selected';
					 
						 

							if ($status->id == 14) {
							$leadJoind = 'display:block';
							}

							if (!$status->show_exp_date) {
							$disabled = 'disabled';
							if ($leadLastFollowUp->expected_date_time != NULL) {
							$dateValue = date_format(date_create($leadLastFollowUp->expected_date_time), 'd-F-Y g:i A');
							}
							}
						 


							$statusHtml .= '<option data-value="' . $status->show_exp_date . '" value="' . $status->id . '" ' . $selected . '>' . $status->name . '</option>';

						 
					}else {
							$statusHtml .= '<option data-value="' . $status->show_exp_date . '" value="' . $status->id . '" >' . $status->name . '</option>';
						}
				}
			}

			$getClientsList = getClientsList();
			//$clients = Client::where('conversion_status',1)->orderBy('business_name','ASC')->get();			 
			$clientsHtml = '';
			if (!empty($lead->lead_joined)) {
				$leadJoind = "display:block";
			} else {
				$leadJoind = "display:none";
			}
			if (!empty($getClientsList)) {
				foreach ($getClientsList as $client) {

					if ($lead->lead_joined == $client->id) {
						$selected = 'selected';

						$clientsHtml .= '<option data-value="' . $client->id . '" value="' . $client->id . '" ' . $selected . '>' . $client->business_name . '</option>';
					} else {

						$clientsHtml .= '<option data-value="' . $client->id . '" value="' . $client->id . '" >' . $client->business_name . '</option>';
					}

				}
			}


			$keywords = Keyword::select('id', 'keyword')->orderBy('keyword', 'asc')->get();
			$courseHtml = '';
			if (!empty($keywords)) {
				foreach ($keywords as $keyword) {

					if ($keyword->id == $lead->kw_id) {
						$courseHtml .= '<option value="' . $keyword->id . '" selected>' . $keyword->keyword . '</option>';
					} else {
						$courseHtml .= '<option value="' . $keyword->id . '">' . $keyword->keyword . '</option>';
					}

				}
			}

			$citieslists = Citieslists::orderBy('city', 'ASC')->get();
			$cityHtml = '';
			if (!empty($citieslists)) {
				foreach ($citieslists as $city) {
					if ($city->city == $lead->city_name) {
						$cityHtml .= '<option value="' . $city->id . '" selected>' . $city->city . '</option>';
					} else {
						$cityHtml .= '<option value="' . $city->id . '">' . $city->city . '</option>';
					}
				}
			}



			$areaZoneOptionHtml = "";
			if (!empty($lead->zone_id)) {			 
				$zonelists = Zone::where('id',$lead->zone_id)->orderBy('zone', 'ASC')->first();
				if ($zonelists) {
					$areaZoneOptionHtml .= "<option value='{$zonelists->id}' selected>{$zonelists->zone} ({$zonelists->pincode})</option>";
				}
			}

			$html = '<div class="row">
						<div class="x_content" style="padding:0">';
			$html .= '								
								<form onsubmit="return pushLeadController.submitLeadFollowupForm(' . $id . ',this)">																
									<div class="form-group">
									<div class="col-md-4">
										<label for="name">Name<span class="required">:</span></label>									 
										<p class="form-control-static" style="display:inline">' . $lead->name . '</p>
									</div>
								</div>
								<div class="form-group">
								 <div class="col-md-4">
										<label for="mobile">Mobile <span class="required">:</span></label>									 
										<p class="form-control-static" style="display:inline">' . $lead->mobile . '</p>
									 </div>
								</div>
								<div class="form-group">
									 <div class="col-md-4">
									<label for="email">Email <span class="required">:</span></label>							 
										<p class="form-control-static" style="display:inline">' . $lead->email . '</p>
								 </div>
								</div>
								<div class="form-group">
									 <div class="col-md-4">
									<label for="email">City <span class="required">*</span></label>							 
										<select class="select2-single form-control city" name="city_id" tabindex="-1">
											<option value="">-- SELECT CITY --</option>
											' . $cityHtml . '
										</select>
								 </div>
								</div>		

								<div class="form-group">
								<div class="col-md-4">
									<label>Find Area</label>
									<select name="area_zone" class="form-control" tabindex="-1" aria-hidden="true">
										' . $areaZoneOptionHtml . '
									</select>
								</div>
							</div>								
								 <div class="form-group">
									<div class="col-md-4">
										<label>Course <span class="required">*</span></label>
										<select class="form-control select2_course" name="course" tabindex="-1">
											<option value="">-- SELECT TECHNOLOGY --</option>
											' . $courseHtml . '
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-4">
										<label>Status <span class="required">*</span></label>
										<select class="form-control select2_status" name="status" tabindex="-1">
											<option value="">-- SELECT STATUS --</option> 
											 ' . $statusHtml . '
										</select>
									</div>
								</div>

								<div class="form-group joindLead" style="' . $leadJoind . '">
									<div class="col-md-4">
										<label>Cleints <span class="required">*</span></label>
										<select class="form-control select2_status" name="client" tabindex="-1">
											<option value="">-- SELECT CLIENT --</option> 
											 ' . $clientsHtml . '
										</select>
									</div>
								</div>
									<div class="form-group">
									<div class="col-md-4">
										<label for="expected_date_time">Student visit date and time <span class="required">*</span></label>
										<input type="text" id="expected_date_time" name="expected_date_time" class="form-control col-md-7 col-xs-12" value="' . $dateValue . '" placeholder="Expected Date &amp; Time" ' . $disabled . ' autocomplete="off">
									</div>
								</div> 							 
								<div class="form-group">
										<div class="col-md-4">
										<label>Remark<span class="required">*</span></label>
										<input type="hidden" name="lead_id" value="' . $lead->id . '">									 
										<textarea name="remark" rows="2" class="form-control">'.$lead->remark.'</textarea>
										</div>
									</div>								 
							 
								<div class="form-group">
									<div class="col-md-4">
										<label style="visibility:hidden">Submit</label>
										 	
										<button type="submit" class="btn btn-success btn-block">Submit</button>
									</div>
								</div>
								<div class="modal-footer" style="border-top: 0px solid #e5e5e5;">
									 
								</div>
							 
						</form>';


			$html .= '</div>
					</div> 
					<div class="table-responsive" style="overflow-x: hidden;">
					<p style="margin-top:10px;margin-bottom:3px;"><strong>Tele Coller Follow Up</strong>  <select onchange="javascript:pushLeadController.getAllFollowUps()" class="follow-up-count"><option value="5">Last 5</option><option value="all">All</option></select></p>
						<table id="datatable-lead-followUps" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Date</th>
									<th>Remark</th>
									<th>Name</th>
									<th>Status</th>
									<th>Expected Date</th>
								</tr>
							</thead>
						</table>
						 </div> ';



			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => $html,
					'message' => 'get leads'
				]
			], 200);
		} else {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => 'Leads not found'
				]
			], 200);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function storeLeadFollowup(Request $request, $id)
	{

	// dd($request->all());
		if ($request->ajax()) {
			$validator = Validator::make($request->all(), [

				'city_id' => 'required',
				'course' => 'required',
				'status' => 'required',
				'remark' => 'required',
				'area_zone'=>'required',


			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			// check now expected date and time if status is not - not interested/location issue
			$statusModel = Status::find($request->input('status'));
			if ($statusModel->name == 'Joined') {
				$validator = Validator::make($request->all(), [
					'client' => 'required',
				]);
				if ($validator->fails()) {
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
				}

			}
			if ($statusModel->show_exp_date) {
				$validator = Validator::make($request->all(), [
					'expected_date_time' => 'required',
				]);
				if ($validator->fails()) {
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
				}
			}

			$lead = Lead::find($id);
			$statusObj = Status::find($request->input('status'));
			$keywordObj = Keyword::find($request->input('course'));
			$lead->kw_id = $keywordObj->id;
			$lead->kw_text = $keywordObj->keyword;
			$cityObj = Citieslists::where('id', $request->input('city_id'))->first();
			$lead->city_id = $cityObj->id;
			$lead->city_name = $cityObj->city;
			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
			$lead->lead_joined = $request->input('client');

			if ($request->input('area_zone') != '') {
			 
				$zone = DB::table('zones')->where('id',$request->input('area_zone'))->select('id', 'zone')->first();	

				$lead->zone_id = $zone->id;
				$lead->zone = $zone->zone;
			}


			$lead->status_id = $request->input('status');
			$lead->status_name = $statusObj->name;
			if ($lead->save()) {

			return response()->json([
						'statusCode' => 1,
						'data' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);

				 
			}else{

return response()->json([
						'statusCode' => 1,
						'data' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);
			}
		}
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getFollowUps(Request $request, $id)
	{

		if ($request->ajax()) {

			$leads = DB::table('lead_follow_ups as lead_follow_ups')
				->join('status as status', 'status.id', '=', 'lead_follow_ups.status')
				->where('lead_follow_ups.lead_id', '=', $id)
				->select('lead_follow_ups.*', 'status.name as status_name')
				->orderBy('lead_follow_ups.id', 'desc');
			if ($request->input('count') != 'all') {
				$leads = $leads->take($request->input('count'));
			} else {
				$leads = $leads->take(100);
			}
			$leads = $leads->paginate($request->input('length'));


			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			foreach ($leads as $lead) {
				$user = User::find($lead->remark_by);
				if (!empty($user)) {
					$name = $user->first_name . ' ' . $user->last_name;
				} else {
					$name = "";
				}
				$data[] = [
					(new Carbon($lead->created_at))->format('d-m-Y h:i:s'),
					$lead->remark,
					$name,
					$lead->status_name,
					(isset($lead->expected_date_time) ? (new Carbon($lead->expected_date_time))->format('d-m-Y h:i A') : "")
				];

			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}



	public function indexNotInterested(Request $request)
	{


		$citieslist = Citieslists::select('id', 'city')->orderBy('city', 'ASC')->get();

		$kwds = Keyword::select('id', 'keyword')->orderBy('keyword', 'asc')->get();
		$statuses = Status::where('lead_filter', 1)->where('name', 'Not Interested')->get();
		$search = [];

		if ($request->has('search')) {
			$search = $request->input('search');

		}
		$clientlist = Client::get();

		return view('admin.lead.not_interested_leads', [
			'citieslist' => $citieslist,
			'statuses' => $statuses,
			'kwds' => $kwds,
			'search' => $search,
			'clientlist' => $clientlist
		]);

	}

	/**
	 * Move not interested.
	 *
	 * @param lead id(s) to send.
	 */
	public function moveNotInterested(Request $request)
	{

		$ids = $request->input('ids');

		if (!empty($ids)) {
			foreach ($ids as $id) {

				$lead = Lead::findorFail($id);

				if ($lead) {
					$leadFollowUp = DB::table('lead_follow_ups as lead_follow_ups');
					$leadFollowUp = $leadFollowUp->join('status as status', 'status.id', '=', 'lead_follow_ups.status');
					$leadFollowUp = $leadFollowUp->where('lead_follow_ups.lead_id', $lead->id);
					$leadFollowUp = $leadFollowUp->select('lead_follow_ups.*', 'status.name');
					$leadFollowUp = $leadFollowUp->orderBy('lead_follow_ups.id', 'desc');
					$leadFollowUp = $leadFollowUp->first();

					if (strcasecmp($leadFollowUp->name, 'Not Interested') == 0 || strcasecmp($leadFollowUp->name, 'Invalid Number') == 0) {
						$lead->move_not_interested = 1;
						$lead->save();
					}
				}
			}
			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => '',
					'message' => 'Moved successfully...'
				]
			], 200);
		} else {

			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => '',
					'message' => 'Please select check box.'
				]
			], 200);

		}

	}
	/**
	 * Move to lead.
	 *
	 * @param lead id(s) to send.
	 */
	public function moveToLeads(Request $request)
	{
		$ids = $request->input('ids');

		if (!empty($ids)) {
			foreach ($ids as $id) {

				$lead = Lead::findorFail($id);

				if ($lead) {
					$leadFollowUp = DB::table('lead_follow_ups as lead_follow_ups');
					$leadFollowUp = $leadFollowUp->join('status as status', 'status.id', '=', 'lead_follow_ups.status');
					$leadFollowUp = $leadFollowUp->where('lead_follow_ups.lead_id', $lead->id);
					$leadFollowUp = $leadFollowUp->select('lead_follow_ups.*', 'status.name');
					$leadFollowUp = $leadFollowUp->orderBy('lead_follow_ups.id', 'desc');
					$leadFollowUp = $leadFollowUp->first();

					if (strcasecmp($leadFollowUp->name, 'Not Interested') == 0 || strcasecmp($leadFollowUp->name, 'Invalid Number') == 0) {
						$lead->move_not_interested = 0;
						$lead->save();
					}
				}
			}
			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => '',
					'message' => 'Moved successfully...'
				]
			], 200);
		} else {

			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => '',
					'message' => 'Please select check box.'
				]
			], 200);

		}

	}

	/**
	 * Select selectDeleteParmanent.
	 *
	 * @param lead id(s) to send.
	 */
	public function selectDeleteParmanent(Request $request)
	{
		$ids = $request->input('ids');

		if (!empty($ids)) {
			foreach ($ids as $id) {

				$assignedLead = AssignedLead::where('lead_id', $id)->delete();
				$leads = DB::table('lead_follow_ups')->where('lead_id', $id)->delete();
				$lead = Lead::findorFail($id);
				$lead->delete();

			}
			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => '',
					'message' => 'Deleted Permanently successfully...'
				]
			], 200);
		} else {

			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => '',
					'message' => 'Please select check box.'
				]
			], 200);

		}

	}

}
