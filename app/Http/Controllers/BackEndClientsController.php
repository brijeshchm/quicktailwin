<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;
use Illuminate\Support\Facades\Input;
use Image;
//use Intervention\Image\ImageManagerStatic as Image;
use Excel;
use Mail;
use Auth;
use Response;
use App\Models\Client\Client; //model
use App\Models\Keyword; //model
use App\Models\Client\AssignedKWDS; //model
use App\Models\KeywordSellCount; //model
use App\Models\City; //model
use App\Models\Citieslists; //model
use App\Models\ClientCategory; //model
use App\Models\AssignedClientCategory; //model
//use App\AssignedClientCity; //model
use App\Models\AssignedLead; //model
use App\Models\AssignedArea; //model
use App\Models\AssignedZone; //model
use App\Models\AssigneddArea; //model
use App\Models\Meeting; //model
use App\Models\Transaction; //model
use Carbon\Carbon; //model
use App\Models\ParentCategory; //Model
use App\Models\ChildCategory; //Model
use App\Models\PaymentHistory; //Model
use App\Models\Modesdetails; //Model
use App\Models\Banksdetails; //Model
use App\Models\State;
use App\Models\Zone; //Model
use Exception;
use Illuminate\Validation\Rule;
use App\Models\Occupation;
class BackEndClientsController extends Controller
{
	protected $danger_msg = '';
	protected $success_msg = '';
	protected $warning_msg = '';
	protected $info_msg = '';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, $id = null)
	{
		if (!is_null($id)) {
			$clients = Client::where('username', $id)->get();
			return view('admin.client_detail', ['clients' => $clients, 'request' => $request]);
		}
		if ($request->has('filter')) {
			$query = '';
			$query .= "SELECT * FROM `clients` WHERE 1=1";
			if (null !== $request->input('uid') && !empty($request->input('uid'))) {
				$query .= " AND `username`='" . $request->input('uid') . "'";
			}
			if (null !== $request->input('b_name') && !empty($request->input('b_name'))) {
				$query .= " AND `business_name` LIKE '%" . $request->input('b_name') . "%'";
			}
			if (null !== $request->input('email') && !empty($request->input('email'))) {
				$query .= " AND `email`='" . $request->input('email') . "'";
			}
			if (null !== $request->input('mobile') && !empty($request->input('mobile'))) {
				$query .= " AND `mobile`='" . $request->input('mobile') . "'";
			}
			$query .= " AND `deleted_at` IS NULL ORDER BY `id` DESC";
			//return $clients = Client::select(DB::raw($query))->toSql();
			//return $clients = DB::raw($query);
			$clients = DB::select($query);
		} else {
			$clients = Client::all();
			$citylist = Citieslists::all();
			$clientCategories = ParentCategory::all();
		}


		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('admin.clients_list', ['clients' => $clients, 'request' => $request, 'citylist' => $citylist, 'clientCategories' => $clientCategories, 'search' => $search]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deletedClients(Request $request, $id = null)
	{


		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_delete'))) {
			return view('errors.unauthorised');
		}
		if (!is_null($id)) {
			$clients = Client::withTrashed()->where('username', $id)->get();
			return view('admin.client_detail', ['clients' => $clients, 'request' => $request]);
		}
		if ($request->has('filter')) {
			$query = '';
			$query .= "SELECT * FROM `clients` WHERE 1=1";
			if (null !== $request->input('uid') && !empty($request->input('uid'))) {
				$query .= " AND `username`='" . $request->input('uid') . "'";
			}
			if (null !== $request->input('b_name') && !empty($request->input('b_name'))) {
				$query .= " AND `business_name` LIKE '%" . $request->input('b_name') . "%'";
			}
			if (null !== $request->input('email') && !empty($request->input('email'))) {
				$query .= " AND `email`='" . $request->input('email') . "'";
			}
			if (null !== $request->input('mobile') && !empty($request->input('mobile'))) {
				$query .= " AND `mobile`='" . $request->input('mobile') . "'";
			}
			$query .= " AND `deleted_at` IS NOT NULL ORDER BY `id` DESC";
			//return $clients = Client::select(DB::raw($query))->toSql();
			//return $clients = DB::raw($query);
			$clients = DB::select($query);
		} else {
			$clients = Client::onlyTrashed()->get();
		}
		return view('admin.deleted_clients', ['clients' => $clients, 'request' => $request]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.client_register');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if ($request->has('initial_form_submit')) {

			$client = new Client;
			$messages = ['mobile.regex' => 'Mobile number cannot start with 0.'];
			$validator = Validator::make($request->all(), [
			 	'business_name' => [
					'required',
					'regex:/^[A-Za-z0-9 ]+$/',
					Rule::unique('clients', 'business_name')         
						->where('city', $request->city),
				],

				// 'business_name' => 'required|regex:/[A-Za-z0-9 ]+/',
				'mobile' => 'required|unique:clients,mobile,NULL,id',
				'city' => 'required|max:50',
				'email' => 'required|email'
			], $messages);
			if ($validator->fails()) {
				return redirect("/developer/clients/register")
					->withErrors($validator)
					->withInput();
			} else {
				// GENERATING SLUG
				// ***************
				$business_slug = NULL;
				$string = $request->input('business_name');
				$string = filter_var($string, FILTER_SANITIZE_STRING);
				$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
				$string = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
				$business_slug = trim(generate_slug(trim($string)));

				if (is_null($business_slug)) {
					return redirect("/developer/clients/register")
						->withErrors($validator)
						->withInput();
				}
				$slugExists = DB::table('clients')
					->select(DB::raw('business_slug'))
					->where('business_slug', 'like', '%' . $business_slug . '%')
					->orderBy('id', 'desc')
					->first();
				if (!empty($slugExists)) {
					$business_slug = $slugExists->business_slug;
					$business_slug = explode("-", $business_slug);
					$end = end($business_slug);
					reset($business_slug);
					if (!is_numeric($end)) {
						$business_slug[] = 1;
					} else {
						++$end;
						$business_slug[count($business_slug) - 1] = $end;
					}
					$business_slug = implode("-", $business_slug);
				}
			}

			$string = filter_var($request->input('business_name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$businessName = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$client->business_name = $businessName;
			$client->business_slug = $business_slug;

			$pass = rand(000001, 999999);
			$client->password = bcrypt($pass);


			$first_name = preg_replace('/[^A-Za-z0-9]/', ' ', filter_var($request->input('first_name'), FILTER_SANITIZE_STRING));
			$first_name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$client->first_name = $first_name;
			$client->last_name = $request->input('last_name');
			$client->city = $request->input('city');
			$cityId = Citieslists::where('city', $request->input('city'))->first();
			if (!empty($cityId)) {
				$client->city_id = $cityId->id;
			}
			$client->mobile = $request->input('mobile');
			$client->email = $request->input('email');
			$client->max_kw = 999;
			$client->client_type = 'gold';
			$client->active_status = '1';


			$client->created_by = $request->user()->id;


			if ($client->save()) {
				$client = Client::find($client->id);
				$cityname = $request->input('city');
				$clientIDToAppend = $clientID = $client->id;
				if (strlen((string) $clientID) < 4) {
					$clientIDToAppend = str_pad($clientIDToAppend, 4, '0', STR_PAD_LEFT);
				}
				$client->username = $usr = strtoupper(substr($cityname, 0, 2)) . $clientIDToAppend;
				$client->save();
				$client = Client::find($clientID);
				//$this->sendUandP($client,$usr,$pass);
				$smsMessage = "Thanks for registering with QuickDials.
				%0D%0ALogin %26 Update your profile to get more leads to grow your business.
				%0D%0A%0D%0ABusiness Name:" . $client->business_name . "
				%0D%0AURL:www.quickdials.com
				%0D%0AUID:" . $client->username . "
				%0D%0APassword:" . $pass . "
				%0D%0A--
				%0D%0ARegards
				%0D%0AQuickDials Team";
				//	sendSMS($client->mobile,$smsMessage);
				$this->success_msg .= 'Business registered successfully!';
				$request->session()->flash('success_msg', $this->success_msg);
				$request->session()->flash('registration_status', 1);
				$request->session()->flash('show_first_form', 1);
				$request->session()->flash('clientData', $client);
				return redirect("/developer/clients/update/" . $client->username);
			} else {
				$this->danger_msg .= 'Business not registered!';
				$request->session()->flash('danger_msg', $this->danger_msg);
				return redirect("/developer/clients/register");
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
	public function update(Request $request, $id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
			return view('errors.unauthorised');
		}
		if (!is_null($id)) {

			$clients = Client::withTrashed()->where('username', $id)->get();
			if (!empty($clients)) {
				foreach ($clients as $c) {
					$client = $c;
					break;
				}
			}

			// SAVE CLIENT ACTIVE STATUS
			// *************************
			if ($request->has('submit_active_status')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				$client->active_status = $request->input('active_status');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client status updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
				}
			}


			// SAVE CLIENT PAID STATUS
			// ***********************
			if ($request->has('submit_paid_status')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				$client->paid_status = $request->input('paid_status');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client paid status updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
				}
			}


			// SAVE CLIENT Certified STATUS
			// ***********************
			if ($request->has('submit_certified_status')) {
				$client = Client::withTrashed()->where('username', $id)->first();

				$client->certified_status = $request->input('certified_status');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client Certified status updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
				}
			}
			if ($request->has('submit_trusted_status')) {
				$client = Client::withTrashed()->where('username', $id)->first();

				$client->trusted_status = $request->input('trusted_status');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client trusted status updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
				}
			}
			if ($request->has('submit_gst_status')) {
				$client = Client::withTrashed()->where('username', $id)->first();

				$client->gst_status = $request->input('gst_status');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client GST updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
				}
			}

			// SAVE CLIENT TYPE
			// ****************
			if ($request->has('submit_client_type')) {

				if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('package_name'))) {
					return repsonse()->json(['status' => 0, 'message' => 'You don`t have permission'], 200);
				}
				$client = Client::withTrashed()->where('username', $id)->first();
				$client->client_type = $request->input('client_type');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client type updated successfully']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated successfully']);
				}
			}

			// SAVE YEARLY SUBS DATE
			// *********************
			if ($request->has('submit_yrly_subs_starting_date')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				if (!$request->user()->current_user_can('administrator')) {
					return response()->json(['status' => 0, 'message' => 'Unauthorised to update subscription date.'], 200);
				}

				$client->expired_from = $request->input('expired_from');
				$client->expired_on = $request->input('expired_on');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Date updated successfully']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Date update failed']);
				}
			}

			// SAVE MAX KWDS
			// *************
			if ($request->has('submit_max_kw')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager'))) {
					return response()->json(['status' => 0, 'message' => 'Unauthorised to update max. kw field']);
				}
				$client->max_kw = $request->input('max_kw');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Maximum Keywords field updated successfully']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Maximum Keywords field not updated successfully']);
				}
			}
			if ($request->has('submit_free_amt')) {

		 
				$clientdeatails = Client::withTrashed()->where('username', $id)->first();
				if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager'))) {
					return response()->json(['status' => 0, 'message' => 'Unauthorised to update max. kw field']);
				}
			

			 if ($clientdeatails->coins_free == '0') {
				$paymenthistory = new PaymentHistory;
				$paymenthistory->client_id = $clientdeatails->id;
				$paymenthistory->customer_name = $clientdeatails->business_name;
				$paymenthistory->business_name = $clientdeatails->business_name;
				$paymenthistory->mobile = $clientdeatails->mobile;
				$paymenthistory->email = $clientdeatails->email;
				$paymenthistory->package_name = $clientdeatails->client_type;
				$paymenthistory->coins_amt = '555';
				$paymenthistory->selectproofid = "";
				$paymenthistory->proofid = "";
				$paymenthistory->paid_amount = '0';
				$paymenthistory->tds_status = "No";
				$paymenthistory->tds_amount = "0";
				$paymenthistory->gst_tax = '0';
				$paymenthistory->gst_total_amount = '0';
				$paymenthistory->gst_status = "Yes";
				$paymenthistory->total_amount = '0';
				$paymenthistory->transactionid = 'FREE-'.time();;
				$paymenthistory->order_number = 'FREE-'.time();
				$paymenthistory->paymentcollect = 0;
				$paymenthistory->payment_mode = "free subscribe";
				$paymenthistory->payment_bank = "";
				$paymenthistory->invoice_status = '1';
				$paymenthistory->save();


				$clientdeatails->coins_amt = $clientdeatails->coins_amt + 555;
				if ($clientdeatails->expired_on == '0000-00-00 00:00:00' || $clientdeatails->expired_on == 'NULL') {

					$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));

				} else if (strtotime($clientdeatails->expired_on) > strtotime(date('Y-m-d'))) {
					$newDate = date('Y-m-d', strtotime($clientdeatails->expired_on . ' +365 days'));

				} else if (strtotime($clientdeatails->expired_on) < strtotime(date('Y-m-d'))) {
					$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));

				} else {
					$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));
				}
				$clientdeatails->expired_on = $newDate;
				$clientdeatails->active_status = "1";
				$clientdeatails->paid_status = "1";
				$clientdeatails->coins_free = "1";
							  
				if ($clientdeatails->save()) {
					return response()->json(['status' => 1, 'message' => 'Free subscribed successfully']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Not subscribed successfully']);
				}
			}
			}


			// SAVE ASSIGNED KEYWORDS
			// **********************
			if ($request->has('kw-submit')) {


				$client = Client::withTrashed()->where('username', $id)->first();

				if (!$client) {
					return response()->json([
						'status' => false,
						'errors' => 'Client not found'
					], 404);
				}
				if (!$client->client_type) {
					return response()->json([
						'status' => false,
						'errors' => 'Kindly update the client package name'
					], 404);
				}

				$keywordArray = $request->input('keyword');

				if (empty($keywordArray) || !is_array($keywordArray)) {
					return response()->json([
						'status' => false,
						'errors' => 'Keyword is required'
					], 400);
				}

				$saveStatus = false;

				DB::beginTransaction();

				try {

					$keywordSellCount = KeywordSellCount::where('slug', 'diamond')->first();

					foreach ($keywordArray as $keyid) {

						$keyword = Keyword::find($keyid);
						if (!$keyword) {
							continue;
						}

						// ✅ Fast duplicate check
						$alreadyAssigned = AssignedKWDS::where([
							'client_id' => $client->id,
							'kw_id' => $keyword->id,
							'parent_cat_id' => $keyword->parent_category_id,
							'child_cat_id' => $keyword->child_category_id,
						])->exists();

						if ($alreadyAssigned) {
							continue;
						}

						$assignedKWDS = new AssignedKWDS();
						$assignedKWDS->client_id = $client->id;
						$assignedKWDS->parent_cat_id = $keyword->parent_category_id;
						$assignedKWDS->child_cat_id = $keyword->child_category_id;
						$assignedKWDS->kw_id = $keyword->id;
						$assignedKWDS->sold_on_position = strtolower($client->client_type);
						$keywordSellCount = KeywordSellCount::where('slug', $client->client_type)->first();
						if (!empty($keywordSellCount)) {
							if ($keyword->category === 'Category 1') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat1_price;
							} else if ($keyword->category === 'Category 2') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat2_price;
							} else if ($keyword->category === 'Category 3') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat3_price;
							} elseif ($keyword->category === 'Category 4') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat4_price;
							} elseif ($keyword->category === 'Category 5') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat5_price;
							} elseif ($keyword->category === 'Category 6') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat6_price;
							} elseif ($keyword->category === 'Category 7') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat7_price;
							} elseif ($keyword->category === 'Category 8') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat8_price;
							} elseif ($keyword->category === 'Category 9') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat9_price;
							} elseif ($keyword->category === 'Category 10') {
								$assignedKWDS->sold_on_price = $keywordSellCount->cat10_price;
							} else {
								$assignedKWDS->sold_on_price = '220';
							}
						} else {
							$assignedKWDS->sold_on_price = '220';
						}

						if ($assignedKWDS->save()) {	
						 
							if ($client->client_type == 'diamond' || $client->client_type = 'platinum') {
								$keyword->increment($client->client_type . '_pos_sold');
							}
							$keyword->save();
						}
						$saveStatus = true;
					}

					DB::commit();

				} catch (\Exception $e) {
					DB::rollBack();

					return response()->json([
						'status' => false,
						'errors' => $e->getMessage()
					], 500);
				}

				if ($saveStatus) {
					return response()->json([
						'status' => true,
						'msg' => 'Keyword assigned successfully!'
					]);
				}

				return response()->json([
					'status' => false,
					'msg' => 'No new keyword assigned'
				]);
			}

			// EXPORT LEADS LIST
			// *****************
			if ($request->has('lead-export')) {
				$client = Client::withTrashed()->where('id', $id)->first();
				$clientID = $client->id;
				$assignedKWDS = DB::table('leads')
					->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
					//  ->join('cities','leads.city_id','=','cities.id')
					// ->select('leads.*','assigned_leads.client_id','assigned_leads.lead_id','cities.city')
					->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.id as s_id', 'assigned_leads.created_at as assigncreate')
					->where('assigned_leads.client_id', $clientID)
					->orderBy('leads.created_at', 'desc')
					->get();


				foreach ($assignedKWDS as $assKWDS) {
					$arr[] = [
						'Name' => $assKWDS->name,
						'Mobile' => $assKWDS->mobile,
						'Email' => $assKWDS->email,
						'Course' => $assKWDS->kw_text,
						'City' => $assKWDS->city_name,
						'Date' => date_format(date_create($assKWDS->assigncreate), 'd-m-Y H:i:s'),
					];
				}
				$excel = \App::make('excel');
				Excel::create('assigned_leads_' . date('Y-m-d_H:i'), function ($excel) use ($arr) {
					$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
						$sheet->fromArray($arr);
					});
				})->export('xls');
			}



			$kwds = DB::table('assigned_kwds')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('parent_category', 'assigned_kwds.parent_cat_id', '=', 'parent_category.id')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->select('assigned_kwds.*', 'citylists.city', 'parent_category.parent_category', 'child_category.child_category', 'keyword.keyword')
				->where('assigned_kwds.client_id', $client->id)
				->get();

			$distinctCities = DB::table('keyword')
				->join('citylists', 'keyword.city_id', '=', 'citylists.id')
				->select('citylists.*', 'keyword.city_id')
				->distinct()
				->get();

			$citylist = Citieslists::get();
			$clientCategories = ClientCategory::all();
			$parentCategory = ParentCategory::all();

			$assignedClientCategories = AssignedClientCategory::select('client_category_id')->where('client_id', $client->id)->get();
			$accs = [];
			foreach ($assignedClientCategories as $acc) {
				$accs[] = $acc->client_category_id;
			}
			$assignedClientCategories = $accs;


			$moderesults = Modesdetails::get();
			$banksdetails = Banksdetails::all();
			$statesis = State::get();
			$occupations = Occupation::where('status', '1')->get();

			// $keywordlists = Keyword::orderBy('keyword', 'ASC')->get();
	 
			$keywordlists = Keyword::whereNotExists(function ($query) use ($client) {
				$query->select(DB::raw(1))
					->from('assigned_kwds')
					->whereColumn('assigned_kwds.kw_id', 'keyword.id')
					->where('assigned_kwds.client_id', $client->id);
			})->get();
 

			return view('admin.client_update', ['client' => $client, 'kwds' => $kwds, 'request' => $request, 'distinctCities' => $distinctCities, 'clientCategories' => $clientCategories, 'assignedClientCategories' => $assignedClientCategories, 'citylist' => $citylist, 'parentCategory' => $parentCategory, 'moderesults' => $moderesults, 'statesis' => $statesis, 'occupations' => $occupations, 'keywordlist' => $keywordlists]);
		}

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editSavePersonalDetails(Request $request, $id)
	{
		try {

			$validator = Validator::make($request->all(), [

				'sirName' => 'required|string|max:10',
				'first_name' => 'required|string|max:100',
				'middle_name' => 'nullable|string|max:100',
				'last_name' => 'required|string|max:100',

				'dob' => 'required|date|before:today',

				'personal_email' => 'required|email|max:255',
				'marital' => 'required|in:Single,Married,Divorced,Widowed',
				'personal_phone' => 'required|digits_between:10,16',

				'country' => 'required|string|max:100',

				'personal_state' => 'required|integer|exists:state,id',
				'personal_city' => 'required|integer|exists:citylists,id',
				'personal_zone' => 'required|integer|exists:zones,id',

				'personal_area' => 'required|string|max:255',
				'personal_pincode' => 'required|digits_between:6,6',
				'personal_address' => 'required|string|max:500',

				'gender' => 'required|in:Male,Female,Other',
			]);

			if ($validator->fails()) {
				return response()->json([
					'status' => true,
					'errors' => $validator->errors()
				], 422);
			}

			$client = Client::withTrashed()->findOrFail($id);

			/* ---------- PERSONAL DETAILS ---------- */

			$client->sirName = $request->sirName;
			$client->first_name = $request->first_name;
			$client->middle_name = $request->middle_name;
			$client->last_name = $request->last_name;
			$client->dob = date('Y-m-d', strtotime($request->dob));

			$client->personal_email = $request->personal_email;
			$client->marital = $request->marital;
			$client->personal_phone = $request->personal_phone;
			$client->country = $request->country;

			/* ---------- LOCATION DETAILS ---------- */

			$city = Citieslists::find($request->personal_city);
			$state = State::find($request->personal_state);
			$zone = Zone::find($request->personal_zone);

			$client->personal_city_id = $city->id;
			$client->personal_city = $city->city;

			$client->personal_state_id = $state->id;
			$client->personal_state = $state->name;

			$client->personal_zone_id = $zone->id;
			$client->personal_zone = $zone->zone;

			$client->personal_area = $request->personal_area;
			$client->personal_pincode = $request->personal_pincode;
			$client->personal_address = $request->personal_address;
			$client->gender = $request->gender;

			$client->save();

			return response()->json([
				'status' => true,
				'msg' => 'Personal details updated successfully'
			], 200);

		} catch (\Exception $e) {
			return response()->json([
				'status' => false,
				'msg' => $e->getMessage()
			], 500);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function ediSaveBusinessInfo(Request $request, $id)
	{

		if ($request->ajax()) {
			try {
				if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
					$status = false;
					$msg = 'Unauthorised Permission';
					$code = 400;
				}
				if (!is_null($id)) {

					$client = Client::withTrashed()->where('id', $id)->first();
					$validator = Validator::make($request->all(), [
						'business_name' => [
							'required',
							'string',
							'max:255',
							Rule::unique('clients', 'business_name')->ignore($id),
						],
						'email' => [
							'required',
							'email',
							'max:255',
							Rule::unique('clients', 'email')->ignore($id),
						],
						'mobile' => [
							'required',
							'digits_between:10,15',
							Rule::unique('clients', 'mobile')->ignore($id),
						],
						 'whatsapp' => 'nullable|integer',

						'country' => 'nullable|integer',
						'state' => 'nullable|integer',
						'city' => 'nullable|integer',
						'zone' => 'nullable|integer',

						'area' => 'nullable|string|max:255',
						'pincode' => 'nullable|digits:6',
						'address' => 'nullable|string|max:500',
						'landmark' => 'nullable|string|max:255',

					 
						'business_intro' => 'nullable|string|max:2000',
					 
						'business_map' => 'nullable|string|max:255',


				 
						'website' => 'nullable|url|max:255',

						'time' => 'nullable|array',
						// 'time.*.from' => 'nullable|date_format:H:i',
						// 'time.*.to' => 'nullable|date_format:H:i',

						'display_hofo' => 'nullable|in:0,1',
					]);


					if ($validator->fails()) {
						$errorsBag = $validator->getMessageBag()->toArray();
						return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
					}


					$string = filter_var($request->input('business_name'), FILTER_SANITIZE_STRING);
					$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
					$businessName = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
					$client->business_name = $businessName;

					$business_slug = trim(generate_slug($request->input('business_name')));

					$slugExists = DB::table('clients')
						->select(DB::raw('business_slug'))
						->where('business_slug', 'like', '%' . $business_slug . '%')
						->orderBy('id', 'desc')
						->first();
					if (!empty($slugExists)) {
						$business_slug = $slugExists->business_slug;
						$business_slug = explode("-", $business_slug);
						$end = end($business_slug);
						reset($business_slug);
						if (!is_numeric($end)) {
							$business_slug[] = 1;
						} else {
							++$end;
							$business_slug[count($business_slug) - 1] = $end;
						}
						$business_slug = implode("-", $business_slug);
					}

					$client->business_slug = $business_slug;

					$client->email = $request->input('email');
					$client->mobile = $request->input('mobile');

					$client->mobile = $request->input('mobile');
					$client->whatsapp = $request->input('whatsapp');
					$client->country = $request->input('country');

					$city = Citieslists::find($request->city);
					$state = State::find($request->state);
					$zone = Zone::find($request->zone);

					// City
					if ($city) {
					$client->city_id = $city->id;
					$client->city = $city->city;
					}

					// State
					if ($state) {
					$client->state_id = $state->id;
					$client->state = $state->name;
					}

					// Zone
					if ($zone) {
					$client->zone_id = $zone->id;
					$client->zone = $zone->zone;
					}
					$client->area = $request->input('area');
					$client->pincode = $request->input('pincode');
					$client->address = $request->input('address');
					$client->landmark = $request->input('landmark');
					$client->address = $request->input('address');
					$client->business_intro = $request->input('business_intro');
				 
					$client->website = $request->input('website');
					$client->business_map = $request->input('business_map');
					$client->display_hofo = $request->input('display_hofo');
					if($request->input('time')){
					$client->time = json_encode($request->input('time'));
					}
					if ($client->save()) {
						$status = true;
						$msg = 'Busineess Information Updated Successfully';
						$code = 200;
					} else {
						$status = false;
						$msg = 'Busineess Information Not Updated';
						$code = 400;
					}

				}
			} catch (Exception $e) {
				$status = false;
				$msg = $e->getMessage();
				$code = 400;
			}
			return response()->json(['status' => $status, 'msg' => $msg], $code);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function clientConversionStatus(Request $request, $id)
	{
		if ($request->ajax()) {

			if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
				$status = false;
				$msg = 'Unauthorised Permission';
				$code = 400;
			}
			try {
				if (!is_null($id)) {

					$client = Client::withTrashed()->where('username', $id)->first();

					$client->conversion_status = $request->input('conversion_status');
				}
				if ($client->save()) {
					$status = true;
					$msg = 'Conversion Updated Successfully';
					$code = 200;
				} else {
					$status = false;
					$msg = 'Conversion Information Not Updated';
					$code = 400;
				}


			} catch (Exception $e) {
				$status = false;
				$msg = $e->getMessage();
				$code = 400;
			}
			return response()->json(['status' => $status, 'msg' => $msg], $code);
		}
	}


	public function autoSaveCertificate(Request $request,$client_id)
	{		 
//  dd($request->all());
			$validator = Validator::make($request->all(), [

				 'iso_no'  => 'nullable|string|max:50',
				'gst_no'  => 'nullable|string|max:20',
				'cin_no'  => 'nullable|string|max:30',
				'msme_no' => 'nullable|string|max:30',
				'pan_no'  => 'nullable|string|max:10',
				'iso_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'gst_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'cin_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'msme_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'coi_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			 
			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => false, 'errors' => $errorsBag], 400);
			}


			$client = Client::find($request->business_id);

			$clean = function ($value) {
			return preg_replace('/[^a-zA-Z0-9\-\/]/', '', strip_tags($value));
			};

			$client->iso_no  = $clean($request->iso_no);
			$client->gst_no  = $clean($request->gst_no);
			$client->cin_no  = $clean($request->cin_no);
			$client->msme_no = $clean($request->msme_no);
			$client->pan_no  = $clean($request->pan_no);
			$client->coi_no  = $clean($request->coi_no);
		 
		 
			$filePath = getFolderStructure();
			$destinationPath = public_path($filePath);

			if ($request->hasFile('pan_certificate')) {

				$pan_certificate = $this->saveImageSmart(
					$request->file('pan_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->pan_certificate = json_encode([
					'large' => [
						'name' => $request->pan_no,
						'alt' => $request->pan_no,
						'src' => $filePath . '/' . $pan_certificate
					]
				]);
			}
			

			if ($request->hasFile('iso_certificate')) {
				$iso_certificate = $this->saveImageSmart(
					$request->file('iso_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->iso_certificate = json_encode([
					'large' => [
						'name' => $request->iso_no,
						'alt' => $request->iso_no,
						'src' => $filePath . '/' . $iso_certificate
					]
				]);
			}

			if ($request->hasFile('gst_certificate')) {
				$gst_certificate = $this->saveImageSmart(
					$request->file('gst_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->gst_certificate = json_encode([
					'large' => [
						'name' => $request->gst_no,
						'alt' => $request->gst_no,
						'src' => $filePath . '/' . $gst_certificate
					]
				]);
			}
			if ($request->hasFile('cin_certificate')) {
				$cin_certificate = $this->saveImageSmart(
					$request->file('cin_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->cin_certificate = json_encode([
					'large' => [
						'name' => $request->cin_no,
						'alt' => $request->cin_no,
						'src' => $filePath . '/' . $cin_certificate
					]
				]);
			}
			if ($request->hasFile('msme_certificate')) {
				$msme_certificate = $this->saveImageSmart(
					$request->file('msme_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->msme_certificate = json_encode([
					'large' => [
						'name' => $request->msme_no,
						'alt' => $request->msme_no,
						'src' => $filePath . '/' . $msme_certificate
					]
				]);
			}

			if ($request->hasFile('coi_certificate')) {
				$coi_certificate = $this->saveImageSmart(
					$request->file('coi_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->coi_certificate = json_encode([
					'large' => [
						'name' => $request->coi_no,
						'alt' => $request->coi_no,
						'src' => $filePath . '/' . $coi_certificate
					]
				]);
			}
			
			if ($request->hasFile('other_certificate1')) {
				$other_certificate1 = $this->saveImageSmart(
					$request->file('other_certificate1'),
					$destinationPath,
					1000,
					1000
				);

				$client->other_certificate1 = json_encode([
					'large' => [
						'name' => "",
						'alt' => "",
						'src' => $filePath . '/' . $other_certificate1
					]
				]);
			}
			
			if ($request->hasFile('other_certificate2')) {
				$other_certificate2 = $this->saveImageSmart(
					$request->file('other_certificate2'),
					$destinationPath,
					1000,
					1000
				);

				$client->other_certificate2 = json_encode([
					'large' => [
						'name' => "",
						'alt' => "",
						'src' => $filePath . '/' . $other_certificate2
					]
				]);
			}

			if ($request->hasFile('other_certificate3')) {
				$other_certificate3 = $this->saveImageSmart(
					$request->file('other_certificate3'),
					$destinationPath,
					1000,
					1000
				);

				$client->other_certificate3 = json_encode([
					'large' => [
						'name' => "",
						'alt' => "",
						'src' => $filePath . '/' . $other_certificate3
					]
				]);
			}
			if ($request->hasFile('other_certificate4')) {
				$other_certificate4 = $this->saveImageSmart(
					$request->file('other_certificate4'),
					$destinationPath,
					1000,
					1000
				);

				$client->other_certificate4 = json_encode([
					'large' => [
						'name' => "",
						'alt' => "",
						'src' => $filePath . '/' . $other_certificate4
					]
				]);
			}
			 

			if ($client->save()) {
				$status = 1;
				$msg = "Certificate updated successfully !";
			} else {
				$status = 0;
				$msg = "Certificate could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		

	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editSaveClientProfileLogo(Request $request, $id)
	{

	 

			 
			$client = Client::withTrashed()->where('id', $id)->first();
			$validator = Validator::make($request->all(), [
				'logo' => 'mimes:jpeg,jpg,png,svg,webp|max:12048',
				'profile_pic' => 'mimes:jpeg,jpg,png,svg,webp|max:12048',
				'year_of_estb' => 'required',
			], [
				'profile_pic.dimensions' => 'Please upload Banner of given size -> [Minimum Height:319px] &amp; [Minimum Width:1137px].',
				'logo.dimensions' => 'Please upload profile logo of given size -> .[Maximum Height:150px] &amp; [Maximum Width:300px]'
			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				$status = true;
				$msg = '';
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

			 
				$client->year_of_estb = $request->input('year_of_estb');
				$client->certifications = $request->input('certifications');
				// LOGO Pictures
				// *************
				$filePath = getFolderStructure();
				$destinationPath = public_path($filePath);
				/* LOGO */
				if ($request->hasFile('logo')) {
					$filename = $this->saveImageSmart(
						$request->file('logo'),
						$destinationPath,
						250,
						141
					);

					$client->logo = serialize([
						'large' => [
							'name' => $filename,
							'alt' => $filename,
							'src' => $filePath . '/' . $filename
						]
					]);
				}

				/* PROFILE BANNER */
				if ($request->hasFile('profile_pic')) {
					$filename = $this->saveImageSmart(
						$request->file('profile_pic'),
						$destinationPath,
						1200,
						180
					);

					$client->profile_pic = serialize([
						'large' => [
							'name' => $filename,
							'alt' => $filename,
							'src' => $filePath . '/' . $filename
						]
					]);
				}

				if ($client->save()) {
					$status = true;
					$msg = 'Contact Information Updated Successfully';
					$code = 200;
				} else {
					$status = false;
					$msg = 'Contact Information Not Updated';
					$code = 400;
				}


			} catch (Exception $e) {

				$status = false;
				$msg = $e->getMessage();
				$code = 400;
			}

			return response()->json(['status' => $status, 'msg' => $msg], 200);
		

	}


	private function saveImageSmart($file, $destinationPath, $width = null, $height = null)
	{
		$ext = strtolower($file->getClientOriginalExtension());
		$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$name = str_replace(' ', '_', $name);
		$filename = time();

		// ✅ SVG → Save directly
		if ($ext === 'svg') {
			$finalName = $filename . '.svg';
			$file->move($destinationPath, $finalName);
			return $finalName;
		}

		// ✅ Raster → Convert to WEBP
		$imagePath = $file->getPathname();

		switch ($ext) {
			case 'jpg':
			case 'jpeg':
				$src = imagecreatefromjpeg($imagePath);
				break;
			case 'png':
				$src = imagecreatefrompng($imagePath);
				imagepalettetotruecolor($src);
				imagealphablending($src, true);
				imagesavealpha($src, true);
				break;
			case 'webp':
				$src = imagecreatefromwebp($imagePath);
				break;
			default:
				throw new \Exception('Unsupported image type');
		}

		$width = $width ?? imagesx($src);
		$height = $height ?? imagesy($src);

		$dst = imagecreatetruecolor($width, $height);
		imagealphablending($dst, false);
		imagesavealpha($dst, true);

		imagecopyresampled(
			$dst,
			$src,
			0,
			0,
			0,
			0,
			$width,
			$height,
			imagesx($src),
			imagesy($src)
		);

		$finalName = $filename . '.webp';
		imagewebp($dst, $destinationPath . '/' . $finalName, 80);

		imagedestroy($src);
		imagedestroy($dst);

		return $finalName;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function uploadClientGalleryPics(Request $request, $id)
	{	 
		 
			try {
				 

				if ($request->has('upload_pics')) {
					$client = Client::withTrashed()->where('id', $id)->first();
					$oldImages = !empty($client->pictures) ? unserialize($client->pictures) : [];
					$images = [];

					if (!empty($client->pictures)) {
						$oldImages = unserialize($client->pictures);
					}

					$filePath = getFolderStructure();
					$destinationPath = public_path($filePath);

					if (!file_exists($destinationPath)) {
						mkdir($destinationPath, 0777, true);
					}
					for ($i = 0; $i < 12; $i++) {
						$field = 'image' . ($i + 1);
						if ($request->hasFile($field)) {

							$file = $request->file($field);
							$ext = strtolower($file->getClientOriginalExtension());

							$baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
							$safeName = str_replace(' ', '_', $baseName);
							$baseFile = $safeName . '_' . time() . '_' . $i;

							/* ---------- SVG ---------- */
							if ($ext === 'svg') {
								$finalName = $baseFile . '.svg';
								$file->move($destinationPath, $finalName);
							}
							/* ---------- WEBP ---------- */ else {
								$finalName = $this->saveImageSmart(
									$file,
									$destinationPath,
									550,
									400
								);
							}

							$images[$i]['large'] = [
								'name' => $finalName,
								'alt' => $finalName,
								'width' => '',
								'height' => '',
								'src' => $filePath . '/' . $finalName
							];

						} else if (isset($_FILES['image' . ($i + 1)]) && $_FILES['image' . ($i + 1)]['size'] == 0) {
						} else {

							if (isset($oldImages[$i])) {
								$images[$i] = $oldImages[$i];
								unset($oldImages[$i]);
							}
						}
					}


					if (!empty($images)) {
						$client->pictures = serialize($images);
					}

					if ($client->save()) {
						$status = true;
						$msg = 'Gallery Image Updated Successfully';
						$code = 200;
					} else {
						$status = false;
						$msg = 'Gallery Image Not Updated';
						$code = 400;
					}
				} else {

					$status = false;
					$msg = 'Please Select Image';
					$code = 400;
				}


			} catch (Exception $e) {
				$status = false;
				$msg = $e->getMessage();
				$code = 400;
			}
			return response()->json(['status' => $status, 'msg' => $msg], $code);
	

	}










	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function assignClientToEmployee(Request $request, $id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
			return view('errors.unauthorised');
		}

		if ($request->has('submit_client_assign')) {

			$client = Client::withTrashed()->where('username', $request->input('client_id'))->first();
			$client->created_by = $request->input('created_by');
			if ($client->save()) {
				return response()->json(['status' => 1, 'message' => 'Created by client updated successfully !!']);
			} else {
				return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
			}
		}




	}

	public function autoSaveAward(Request $request,$id)
	{
 
	 
			$validator = Validator::make($request->all(), [
			 
				'award_name1' => 'nullable|max:255',
				'award_name2' => 'nullable|max:255',

				'award_img1' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'award_img2' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'award_img3' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'award_img4' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'award_img5' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'award_img6' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'award_img7' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'award_img8' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
				'award_img9' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			$client = Client::find($request->business_id);
			
			$clean = function ($value) {
			return preg_replace('/[^a-zA-Z0-9\-\/]/', '', strip_tags($value));
			};

			$client->award_name1  = $clean($request->award_name1);
			$client->award_name2  = $clean($request->award_name2);
			$client->award_name3  = $clean($request->award_name3);
			$client->award_name4 = $clean($request->award_name4);
			$client->award_name5  = $clean($request->award_name5);

			$client->award_name6  = $clean($request->award_name6);
			$client->award_name7  = $clean($request->award_name7);
			$client->award_name8  = $clean($request->award_name8);
			$client->award_name9 = $clean($request->award_name9); 
			 
		 
		 
			$filePath = getFolderStructure();
			$destinationPath = public_path($filePath);

		 
			if ($request->hasFile('award_img1')) {
				$award_img1 = $this->saveImageSmart(
					$request->file('award_img1'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img1 = json_encode([
					'large' => [
						'name' => $request->award_name1,
						'alt' => $request->award_name1,
						'src' => $filePath . '/' . $award_img1
					]
				]);
			}
			if ($request->hasFile('award_img2')) {
				$award_img2 = $this->saveImageSmart(
					$request->file('award_img2'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img2 = json_encode([
					'large' => [
						'name' => $request->award_name2,
						'alt' => $request->award_name2,
						'src' => $filePath . '/' . $award_img2
					]
				]);
			}
			if ($request->hasFile('award_img3')) {
				$award_img3 = $this->saveImageSmart(
					$request->file('award_img3'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img3 = json_encode([
					'large' => [
						'name' => $request->award_name3,
						'alt' => $request->award_name3,
						'src' => $filePath . '/' . $award_img3
					]
				]);
			}
			if ($request->hasFile('award_img4')) {
				$award_img4 = $this->saveImageSmart(
					$request->file('award_img4'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img4 = json_encode([
					'large' => [
						'name' => $request->award_name4,
						'alt' => $request->award_name4,
						'src' => $filePath . '/' . $award_img4
					]
				]);
			}
			if ($request->hasFile('award_img5')) {
				$award_img5 = $this->saveImageSmart(
					$request->file('award_img5'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img5 = json_encode([
					'large' => [
						'name' => $request->award_name5,
						'alt' => $request->award_name5,
						'src' => $filePath . '/' . $award_img5
					]
				]);
			}
			if ($request->hasFile('award_img6')) {
				$award_img6 = $this->saveImageSmart(
					$request->file('award_img6'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img6 = json_encode([
					'large' => [
						'name' => $request->award_name6,
						'alt' => $request->award_name6,
						'src' => $filePath . '/' . $award_img6
					]
				]);
			}

			if ($request->hasFile('award_img7')) {
				$award_img7 = $this->saveImageSmart(
					$request->file('award_img7'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img7 = json_encode([
					'large' => [
						'name' => $request->award_name7,
						'alt' => $request->award_name7,
						'src' => $filePath . '/' . $award_img7
					]
				]);
			}
			
			if ($request->hasFile('award_img8')) {
				$award_img8 = $this->saveImageSmart(
					$request->file('award_img8'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img8 = json_encode([
					'large' => [
						'name' => $request->award_name8,
						'alt' => $request->award_name8,
						'src' => $filePath . '/' . $award_img8
					]
				]);
			}
			if ($request->hasFile('award_img9')) {
				$award_img9 = $this->saveImageSmart(
					$request->file('award_img9'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img9 = json_encode([
					'large' => [
						'name' => $request->award_name9,
						'alt' => $request->award_name9,
						'src' => $filePath . '/' . $award_img9
					]
				]);
			}


			if ($client->save()) {
				$status = 1;
				$msg = "Award updated successfully !";
			} else {
				$status = 0;
				$msg = "Award could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function conversionClientStatus(Request $request, $id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
			return view('errors.unauthorised');
		}
		if (!is_null($id)) {


			// SAVE CLIENT submit_conversion_client client 
			// *************************
			if ($request->has('submit_conversion_client')) {

				$client = Client::withTrashed()->where('username', $id)->first();
				$client->conversion_status = $request->input('conversion_status');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Conversion client updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Conversion Client not updated !!']);
				}
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
	public function clientPaidStatus(Request $request, $id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
			return view('errors.unauthorised');
		}
		if (!is_null($id)) {



			// SAVE CLIENT PAID STATUS
			// ***********************
			if ($request->has('submit_paid_status')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				$client->paid_status = $request->input('paid_status');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client paid status updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
				}
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
	public function clientCertifiedStatus(Request $request, $id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
			return view('errors.unauthorised');
		}
		if (!is_null($id)) {


			// SAVE CLIENT Certified STATUS
			// ***********************
			if ($request->has('submit_certified_status')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				$client->certified_status = $request->input('certified_status');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client Certified status updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
				}
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
	public function clientPackegeStatus(Request $request, $id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
			return view('errors.unauthorised');
		}
		if (!is_null($id)) {


			// SAVE CLIENT PACKEGE STATUS
			// ***********************
			if ($request->has('submit_packege_status')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				$client->client_type = strtolower($request->input('package_status'));
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Client Package status updated successfully !!']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Client not updated !!']);
				}
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
	public function clientLeadsCount(Request $request, $id)
	{
		if ($request->ajax()) {
			try {
				if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
					return view('errors.unauthorised');
				}
				if (!is_null($id)) {


					if ($request->has('submit_leads_count')) {
						$client = Client::withTrashed()->where('username', $id)->first();
						if ((!$request->user()->current_user_can('administrator'))) {
							return response()->json([
								'statusCode' => 0
								,
								'data' => [
									'responseCode' => 200
									,
									'payload' => ''
									,
									'message' => 'Unauthorised to update leads count and cost/lead'
								]

							]);
						}
						$leads_count_diff = $request->input('leads_count') - $client->leads_count;
						/* if($leads_count_diff<0){
							return response()->json(['status'=>0,'message'=>'Leads Count field cannot be updated because leads quota limits are reached']);
						} */
						$client->leads_count = $request->input('leads_count');
						$client->leads_remaining = $client->leads_remaining + $leads_count_diff;
						$client->cost_per_lead = $request->input('cost_per_lead');
						if ($client->save()) {
							return response()->json(['status' => true, 'msg' => 'Leads count field updated successfully'], 200);

						} else {
							return response()->json(['status' => false, 'msg' => 'Leads Count field not updated successfully'], 200);

						}
					}
				}
			} catch (\Exception $e) {
				$status = 0;
				$msg = $e->getMessage();
			}

			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}

	}



	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function clientBalanceAmount(Request $request, $id)
	{

		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
			return view('errors.unauthorised');
		}
		if (!is_null($id)) {


			// SAVE BALANCE AMOUNT
			// *******************
			if ($request->has('submit_balance_amt')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				if ($client->client_type == 'general') {
					return response()->json(['status' => 0, 'message' => 'Balance amount cannot be updated for general client.']);
				}
				/* if(($client->client_type=='lead_based' or $client->client_type=='yearly_subscription' or $client->client_type=='free_subscription' or $client->client_type=='count_based_subscription') and !$request->user()->current_user_can('administrator')){
					return response()->json(['status'=>0,'message'=>'Unauthorised to update amount.'],200);
				} */
				$client->balance_amt = $request->input('balance_amt');
				if ($client->balance_amt > 0) {
					$client->paid_status = 1;
				}
				if ($client->save()) {
					//$transaction = new Transaction;
					//$transaction->client_id = $client->id;
					//$transaction->key = 'balance_amt';
					//$transaction->value = $request->input('balance_amt');
					//$transaction->save();
					return response()->json(['status' => 1, 'message' => 'Balance amount updated successfully, please reload the page.']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Balance amount update failed']);
				}
			}

			// SAVE YEARLY SUBS DATE
			// *********************
			if ($request->has('submit_yrly_subs_starting_date')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				if (!$request->user()->current_user_can('administrator')) {
					return response()->json(['status' => 0, 'message' => 'Unauthorised to update subscription date.'], 200);
				}

				$client->expired_from = $request->input('expired_from');
				$client->expired_on = $request->input('expired_on');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Date updated successfully']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Date update failed']);
				}
			}

			$clients = Client::withTrashed()->where('username', $id)->get();
			if (count($clients) > 0) {
				foreach ($clients as $c) {
					$client = $c;
					break;
				}
			}

			//$kwds = AssignedKWDS::where('client_id',$client->username)->get();
			$kwds = DB::table('assigned_kwds')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('parent_category', 'assigned_kwds.parent_cat_id', '=', 'parent_category.id')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->select('assigned_kwds.*', 'citylists.city', 'parent_category.parent_category', 'child_category.child_category', 'keyword.keyword','keyword.slug')
				->where('assigned_kwds.client_id', $client->id)
				->get();

			$distinctCities = DB::table('keyword')
				->join('citylists', 'keyword.city_id', '=', 'citylists.id')
				->select('citylists.*', 'keyword.city_id')
				->distinct()
				->get();

			$citylist = Citieslists::all();
			$clientCategories = ClientCategory::all();
			$parentCategory = ParentCategory::all();

			$assignedClientCategories = AssignedClientCategory::select('client_category_id')->where('client_id', $client->id)->get();
			$accs = [];
			foreach ($assignedClientCategories as $acc) {
				$accs[] = $acc->client_category_id;
			}
			$assignedClientCategories = $accs;
			$moderesults = Modesdetails::get();
			$banksdetails = Banksdetails::all();
			return view('admin.client_update', ['client' => $client, 'kwds' => $kwds, 'request' => $request, 'distinctCities' => $distinctCities, 'clientCategories' => $clientCategories, 'assignedClientCategories' => $assignedClientCategories, 'citylist' => $citylist, 'parentCategory' => $parentCategory, 'moderesults' => $moderesults]);
		}

	}





	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function clientYrlySubsStartingSate(Request $request, $id)
	{


		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('client_update'))) {
			return view('errors.unauthorised');
		}
		if (!is_null($id)) {


			// SAVE YEARLY SUBS DATE
			// *********************
			if ($request->has('submit_yrly_subs_starting_date')) {
				$client = Client::withTrashed()->where('username', $id)->first();
				if (!$request->user()->current_user_can('administrator')) {
					return response()->json(['status' => 0, 'message' => 'Unauthorised to update subscription date.'], 200);
				}

				$client->expired_from = $request->input('expired_from');
				$client->expired_on = $request->input('expired_on');
				if ($client->save()) {
					return response()->json(['status' => 1, 'message' => 'Date updated successfully']);
				} else {
					return response()->json(['status' => 0, 'message' => 'Date update failed']);
				}
			}


		}

	}






	/**
	 * Return Paginated Assigned Keywords
	 *
	 * @param $request - Request class instance
	 * @param $id - ClientID
	 * @return JSON object containing payload
	 */
	public function getPaginatedAssignedKeywords(Request $request, $id = null)
	{
		if ($request->ajax()) {
			if (null !== $id) {
				$client = Client::where('username', $id)->first();
				$clientID = $client->id;
			}
			$leads = DB::table('assigned_kwds as assigned_kwds')
				//	->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				//->join('zones','assigned_kwds.zone_id','=','zones.id')
				->join('parent_category', 'assigned_kwds.parent_cat_id', '=', 'parent_category.id')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->select('assigned_kwds.*', 'parent_category.parent_category', 'child_category.child_category', 'keyword.keyword')
				->orderBy('assigned_kwds.created_at', 'desc')
				->where('assigned_kwds.client_id', $clientID);


			if ($request->input('search.value') != '') {
				$leads = $leads->where('keyword.keyword', 'LIKE', '%' . $request->input('search.value') . '%');
			}

			$leads = $leads->paginate($request->input('length'));

			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			$returnLeads['recordCollection'] = [];

			foreach ($leads as $lead) {

				$action = '';
				$separator = '';
				if ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_assign_keyword')) {
					$action .= $separator . "<a href='javascript:void(0)' onclick='javascript:keyword.editAssignedKeyword({$lead->id},this,\"show_assigned_keyword_update_form\")'><i class='fa fa-pencil fa-fw' aria-hidden='true'></i></a>";
					$separator = ' | ';
				}
				if ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('assign_keyword_delete')) {
					$action .= $separator . "<a href='javascript:void(0)' onclick='javascript:deleteAssignedKW({$lead->id},this,\"del_ass_kw\")'><i class='fa fa-trash fa-fw' aria-hidden='true'></i></a>";
					$separator = ' | ';
				}
				$data[] = [
					"<th class='text-center'><input type='checkbox' class='check-box' value='$lead->id'></th>",
					$lead->keyword,
					$lead->child_category,
					$lead->parent_category,
					// ucfirst($lead->sold_on_position),
					$action
				];
				$returnLeads['recordCollection'][] = $lead->id;
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function deleteSelectedAssignedKwds(Request $request)
	{
		$ids = $request->input('ids');
		foreach ($ids as $id) {
			$lead = AssignedKWDS::findorFail($id);
			if ($lead) {
				$lead->delete();
			}
		}
		return response()->json([
			'statusCode' => 1,
			'data' => [
				'responseCode' => 200,
				'payload' => '',
				'message' => 'Selected deleted successfully !!'
			]
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updatePriceAssignedKwds(Request $request, $id = null)
	{
		if ($request->ajax()) {
			if (null !== $id) {
				$client = Client::where('username', $id)->first();
				$clientID = $client->id;
			}
			$assignedKwds = AssignedKWDS::where('client_id', $clientID)->get();
			foreach ($assignedKwds as $assignedKwd) {
				$singleAssignedKwd = AssignedKWDS::findOrFail($assignedKwd->id);
				$kwdSellCount = KeywordSellCount::where('slug', $singleAssignedKwd->sold_on_position)->first();
				$kwd = Keyword::findOrFail($singleAssignedKwd->kw_id);
				$price = $singleAssignedKwd->sold_on_price;
				switch ($kwd->category) {
					case 'Category 1':
						$price = $kwdSellCount->cat1_price;
						break;
					case 'Category 2':
						$price = $kwdSellCount->cat2_price;
						break;
					case 'Category 3':
						$price = $kwdSellCount->cat3_price;
						break;
				}
				$singleAssignedKwd->sold_on_price = $price;
				$singleAssignedKwd->save();
			}
			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => '',
					'message' => 'Updated price successfully !!'
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
	public function destroy(Request $request, $delete, $id)
	{
		if ($request->ajax()) {
			if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('delete_client'))) {
				return view('errors.unauthorised');
			}
			if ("sdelete" === $delete) {
				Client::find($id)->delete();
				return response()->json(['status' => 1, 'msg' => 'Client deleted successfully!!']);
			}
			if ("hdelete" === $delete) {
				Client::withTrashed()->where('id', $id)->forceDelete();
				$lead = DB::table('assigned_leads')->where('client_id', $id)->delete();
				$assigned_kwds = DB::table('assigned_kwds')->where('client_id', $id)->delete();
				$assigned_client_categories = DB::table('assigned_client_categories')->where('client_id', $id)->delete();
				return response()->json(['status' => 1, 'msg' => 'Client deleted permanently!!']);
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function restore(Request $request, $id = null)
	{
		if ($request->ajax() && !is_null($id)) {
			Client::withTrashed()->where('id', $id)->restore();
			return response()->json(['status' => 1, 'msg' => 'Client restored successfully!!']);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function searchForm(Request $request)
	{
		return view('admin.client_search');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getField(Request $request, $what, $id = null)
	{
		if ($request->ajax()) {

			if ("city" === $what) {
				$city_id = $request->input('city');
				$zone = DB::table('zones')
					->join('citylists', 'zones.city_id', '=', 'citylists.id')
					->select('citylists.id', 'citylists.city', 'zones.*')
					->where('zones.city_id', $request->input('city'))
					->get();


					// dd($zone);
				return response()->json(['status' => 1, 'result' => $zone]);
			}
			if ("zone" === $what) {
				$zoneID = $request->input('zone');
				return response()->json(['status' => 1, 'result' => $zoneID]);
			}
			if ("parent_cat" === $what) {


				$child_cat = DB::table('keyword')
					->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
					->select('child_category.id', 'child_category.child_category', 'keyword.parent_category_id', 'keyword.child_category_id')

					->where('keyword.parent_category_id', $request->input('parent_cat'))
					->groupBy('child_category_id')
					//	->distinct()
					->get();
				return response()->json(['status' => 1, 'result' => $child_cat]);
			}


			if ("child_cat" === $what) {

				$child_cat = DB::table('keyword')
					->where('parent_category_id', $request->input('parent_cat'))
					->where('child_category_id', $request->input('child_cat'))
					->get();

				return response()->json(['status' => 1, 'result' => $child_cat]);
			}
			if ("kw" === $what) {


				// $city_id = $request->input('city');
				$keyw = $request->input('kw');
				$result = [];
				if (!empty($keyw)) {
					$keyword = Keyword::find($request->input('kw'));
					$assKWDSC = AssignedKWDS::where('kw_id', $request->input('kw'))->where('sold_on_position', 'platinum')->get()->count();

					$keywordSellCount = KeywordSellCount::all();

					foreach ($keywordSellCount as $ksc) {
						switch ($ksc->slug) {
							case 'platinum':
								if ($assKWDSC <= 2 && ((($keyword->platinum_pos_sold + $ksc->count) - $assKWDSC > 0)))
									$result['platinum'] = 'Platinum';

								break;
							case 'diamond':
								if ($ksc->count - $keyword->diamond_pos_sold > 0)
									$result['diamond'] = 'Diamond';

								break;
							case 'gold':
								if ($ksc->count - $keyword->diamond_pos_sold > 0)
									$result['Gold'] = 'Gold';

								break;
							case 'silver':
								if ($ksc->count - $keyword->diamond_pos_sold > 0)
									$result['Silver'] = 'Silver';
								break;
						}
					}
				}

				return response()->json(['status' => 1, 'result' => $result]);
			}
			if ("position" === $what) {
				$result = [];
				$keyword = Keyword::find($request->input('kw'));
				$keywordSellCount = KeywordSellCount::where('slug', $request->input('position'))->first();
				if ($keyword->category == 'Category 1') {
					$result['price'] = $keywordSellCount->cat1_price;
				} else if ($keyword->category == 'Category 2') {
					$result['price'] = $keywordSellCount->cat2_price;
				} else if ($keyword->category == 'Category 3') {
					$result['price'] = $keywordSellCount->cat3_price;
				} else if ($keyword->category == 'Category 4') {
					$result['price'] = $keywordSellCount->cat4_price;
				} else if ($keyword->category == 'Category 5') {
					$result['price'] = $keywordSellCount->cat5_price;
				} else if ($keyword->category == 'Category 6') {
					$result['price'] = $keywordSellCount->cat6_price;
				} else if ($keyword->category == 'Category 7') {
					$result['price'] = $keywordSellCount->cat7_price;
				} else if ($keyword->category == 'Category 8') {
					$result['price'] = $keywordSellCount->cat8_price;
				} else if ($keyword->category == 'Category 9') {
					$result['price'] = $keywordSellCount->cat9_price;
				} else if ($keyword->category == 'Category 10') {
					$result['price'] = $keywordSellCount->cat10_price;
				} else if ($keyword->category == 'Category X') {
					switch ($request->input('position')) {
						case 'diamond':
							$result['price'] = $keyword->diamond_price;
							break;
						case 'platinum':
							$result['price'] = $keyword->platinum_price;
							break;

					}
				}
				return response()->json(['status' => 1, 'result' => $result]);
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delKW(Request $request, $id)
	{
		if ($request->ajax()) {
			$assignedKW = AssignedKWDS::find($id);
			$kw = Keyword::find($assignedKW->kw_id);
			switch ($assignedKW->sold_on_position) {
				case 'diamond':
					$kw->diamond_pos_sold = $kw->diamond_pos_sold - 1;
					break;
				case 'platinum':
					$kw->platinum_pos_sold = $kw->platinum_pos_sold - 1;
					break;

			}
			$kw->save();
			$assignedKW->delete();
			return response()->json(['status' => 1, 'result' => 'Assigned keyword deleted successfully']);
		} else {
			return response()->json(['status' => 0, 'result' => 'Not deleted']);
		}
	}

	/**
	 * Send client registration mail to client containing user name password.
	 *
	 * @param  object  $client
	 */
	public function sendUandP($client, $usr, $pass)
	{
		$mailStatus = 1;
		try {
			Mail::send('emails.register', ['client' => $client, 'usr' => $usr, 'pass' => $pass], function ($m) use ($client) {
				$m->from('info@quickdials.com', 'QuickDials');
				$m->to($client->email, $client->first_name . " " . $client->last_name)->subject('QuickDials Login Credentials')->cc('help@quickdials.com');
			});
		} catch (\Exception $e) {
			$mailStatus = 0;
		}
		return $mailStatus;
	}

	/**
	 * Get paginated leads.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginatedTransactions(Request $request, $id = null)
	{
		//if($request->ajax()){
		//$leads = Lead::orderBy('id','desc')->paginate($request->input('length'));
		if (null !== $id) {
			$client = Client::where('username', $id)->first();
			$clientID = $client->id;
		}
		$leads = DB::table('payment_histories')
			->where('client_id', $clientID)
			->orderBy('created_at', 'desc')
			->paginate($request->input('length'));

		$returnLeads = $data = [];
		$returnLeads['draw'] = $request->input('draw');
		$returnLeads['recordsTotal'] = $leads->total();
		$returnLeads['recordsFiltered'] = $leads->total();
		foreach ($leads as $lead) {

			$data[] = [
				$lead->total_amount,
				$lead->leads_count,
				date_format(date_create($lead->created_at), 'd-m-Y H:i:s'),


			];
		}
		$returnLeads['data'] = $data;
		return response()->json($returnLeads);
		//}
	}


	/**
	 * Get paginated leads.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginatedLeads(Request $request, $id = null)
	{
		if ($request->ajax()) {
			//$leads = Lead::orderBy('id','desc')->paginate($request->input('length'));
			if (null !== $id) {
				$client = Client::where('username', $id)->first();
				$clientID = $client->id;
			}
			$leads = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
				//   ->join('cities','leads.city_id','=','cities.id')
				//->join('keyword','leads.kw_id','=','keyword.id')
				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.id as s_id', 'assigned_leads.created_at as created')
				->orderBy('leads.created_at', 'desc')
				//->orderBy('leads.id','desc')
				//->whereNull('leads.deleted_at')

				->where('assigned_leads.client_id', $clientID);

			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.kw_text', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.email', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}

			$leads = $leads->paginate($request->input('length'));

			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			foreach ($leads as $lead) {

				$action = '';
				$separator = '';
				$action .= $separator . '<a data-lead_id_follow="' . $lead->id . '" href="javascript:pushLeadController.getLeadFollowupForm(' . $lead->lead_id . ')"  title="Follow Up Leads"><i class="fa fa-comments fa-fw"></i></a>';
				$separator = ' | ';
				$action .= $separator . '<a href="javascript:pushLeadController.clientAssignleaddelete(' . $lead->s_id . ')" title="lead Delete"><i class="fa fa-fw fa-trash"></i></a>';
				$separator = ' | ';


				$data[] = [
					$lead->name,
					$lead->mobile,
					$lead->email,
					$lead->kw_text,
					$lead->city_name,
					date_format(date_create($lead->created), 'd-m-Y H:i:s'),

					$action
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);

		}
	}

	/**
	 * Get paginated leads.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getDescussion(Request $request, $id = null)
	{
		if ($request->ajax()) {
			//$leads = Lead::orderBy('id','desc')->paginate($request->input('length'));
			if (null !== $id) {
				$client = Client::where('username', $id)->first();
				$clientID = $client->id;
			}
			echo $clientID;
			die;
			$leads = DB::table('client_discussion')
				->where('client_id', $clientID)
				->paginate($request->input('length'));

			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			foreach ($leads as $lead) {
				/* $sources = $lead->source()->where('id',$lead->source)->get();
				foreach($sources as $source){
					$src = $source;
				}
				$courses = $lead->course()->where('id',$lead->course)->get();
				foreach($courses as $course){
					$crs = $course;
				}
				$statuses = $lead->status()->where('id',$lead->status)->get();
				foreach($statuses as $status){
					$sts = $status;
				} */
				$data[] = [
					$lead->createdate . '' . $lead->discussion,

				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
			//return $leads->links();
		}
	}

	/**
	 * Generate New Password
	 *
	 * @param  int  $id
	 * @return JSON Response
	 */
	public function generateNewPass(Request $request, $id = null)
	{
		if ($request->ajax()) {
			if (null !== $id) {
				$client = Client::where('username', $id)->first();
				$clientID = $client->id;
			}
			$pass = rand(000001, 999999);
			$client->password = bcrypt($pass);
			if ($client->save()) {
				$smsMessage = "Thanks for registering with QuickDials.
				%0D%0ALogin %26 Update your profile to get more leads to grow your business.
				%0D%0A%0D%0ABusiness Name:" . $client->business_name . "
				%0D%0AURL:www.quickdials.com
				%0D%0AUID:" . $client->username . "
				%0D%0APassword:" . $pass . "
				%0D%0A--
				%0D%0ARegards
				%0D%0AQuickDials Team";
				sendSMS($client->mobile, $smsMessage);
				$mailStatus = $this->sendUandP($client, $id, $pass);
				return response()->json(['status' => 1, 'username' => $client->username, 'password' => $pass, 'mailStatus' => $mailStatus]);
			}
		}
	}

	/**
	 * Get paginated clients.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginatedClients(Request $request)
	{

		if ($request->ajax()) {

			$leads = DB::table('clients');
			$select = 'clients.*';
			if ($request->input('search.keyword') != '') {
				$leads = $leads->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id');
				$leads = $leads->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id');
				$leads = $leads->where('keyword.keyword', 'LIKE', '%' . $request->input('search.keyword') . '%');
				$leads = $leads->groupBy('assigned_kwds.client_id');
				$select = 'keyword.keyword';
			}

			if ($request->input('search.client_category') != '') {
				$leads = $leads->join('assigned_client_categories', 'clients.id', '=', 'assigned_client_categories.client_id');
				$select = 'assigned_client_categories.client_category_id';
			}
			$leads = $leads->select('clients.*', $select);


			$leads = $leads->orderBy('clients.id', 'desc');
			$leads = $leads->whereNull('clients.deleted_at');
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('clients.username', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.business_name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.business_slug', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.email', 'LIKE', '%' . $request->input('search.value') . '%');

				});
			}
			/* if($request->input('search.paid_status')!=''){
				if($request->input('search.paid_status')=='1'){
					$leads = $leads->where('clients.paid_status','1');
				}else{
					$leads = $leads->where('clients.paid_status','0');
				}
			}
			 */
			if ($request->input('search.paid_status') != '') {
				$leads = $leads->where('clients.paid_status', $request->input('search.paid_status'));

			}
			if ($request->input('search.client_type') != '') {
				$leads = $leads->where('clients.client_type', 'LIKE', $request->input('search.client_type'));
			}
			if ($request->input('search.city') != '') {
				$cityss = $request->input('search.city');

				if (!empty($cityss)) {
					foreach ($cityss as $city) {
						$cityList[] = $city;
					}
					$leads = $leads->whereIn('clients.city', $cityList);
				}
			}
			if ($request->input('search.datef') != '') {
				$leads = $leads->whereDate('clients.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
			}
			if ($request->input('search.datet') != '') {
				$leads = $leads->whereDate('clients.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
			}


			if ($request->input('search.client_category') != '') {

				$leads = $leads->where('assigned_client_categories.client_category_id', $request->input('search.client_category'));
			}


			if (!$request->user()->current_user_can('administrator') && !$request->user()->current_user_can('lead_show_all')) {

				if ($request->user()->current_user_can('manager')) {

					$leads = $leads->where('clients.created_by', $request->user()->id);

					if ($request->input('search.user') != '') {
						$leads = $leads->where('clients.created_by', '=', $request->input('search.user'));
					}


				} else {

					$leads = $leads->where('clients.created_by', '=', $request->user()->id);
				}


			} else {

				if ($request->input('search.user') != '') {
					$leads = $leads->where('clients.created_by', '=', $request->input('search.user'));
				}
			}




			$leads = $leads->paginate($request->input('length'));

			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();

			foreach ($leads as $lead) {

				$type = "";
				switch ($lead->client_type) {
					case 'gold':
						$type = 'G';
						break;
					case 'diamond':
						$type = 'D';
						break;
					case 'silver':
						$type = 'S';
						break;
					case 'platinum':
						$type = 'P';
						break;

				}
				if (!empty($type)) {
					$type = '<strong style="color:red" >[' . $type . ']</strong>';
				} else {
					$type = "";
				}


				$assignedLeadsCount = 0;
				$assignedLeadsCount = AssignedLead::where('client_id', '=', $lead->id)->count();

				$meetingPopover = $popover = '';
				if (null != $lead->remark) {
					$popover = explode("|", $lead->remark);
					$popover = end($popover);
					$popover = explode("-", $popover);
					$popover = "[" . date('d-m-Y', $popover[0]) . "] " . $popover[1];
					$popover = "data-toggle='popover' data-trigger='hover' data-placement='left' data-content='$popover'";
				}
				// Getting meetingPopover
				$meeting = Meeting::where('client_id', $lead->id)->orderBy('created_at', 'desc')->first();
				if ($meeting) {
					$meetingPopover = "[" . (new Carbon($meeting->date_time))->format('d-m-Y') . "] " . $meeting->remark;
					$meetingPopover = "data-toggle='popover' data-trigger='hover' data-placement='left' data-content='$meetingPopover'";
				}
				// Getting meetingPopover				
				$username = '';
				if (!empty($lead->paid_status)) {
					$username = "<a href='/developer/clients/update/{$lead->username}' title='Paid client'>{$lead->username}</a>";
				} else {
					$username = "<a href='/developer/clients/update/{$lead->username}' style='color:red' title='Not Paid client'>{$lead->username}</a>";
				}

				$action = $separator = '';
				$action = '<a title="edit" href="/developer/clients/update/' . $lead->username . '"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i></a>' . ' | ' . '<a title="view details" href="/developer/clients/list/' . $lead->username . '"><i class="fa fa-eye fa-fw" aria-hidden="true"></i></a>' . ' | ' . '<a title="Follow Up" data-client_id_meeting="' . $lead->username . '" href="javascript:client.getClientMeetingForm(\'' . $lead->username . '\')" ' . $meetingPopover . '><i class="fa fa-comments fa-fw" aria-hidden="true"></i></a>';

				if ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('delete_client')) {
					$action .= $separator . ' | <a title="delete" href="javascript:void(0)" onclick="javascript:deleteClient(' . $lead->id . ',this,\'delete\')"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a>';
					$separator = ' | ';
				}

				if (!is_null($lead->created_by)) {
					$user = DB::table('users')->where('id', $lead->created_by)->first();
				}
				$categories = DB::table('assigned_client_categories')->where('client_id', $lead->id)->get();
				$paidOrNot = "";
				if (!empty($categories)) {
					$paidOrNot = "<a style='color:blue' href='#' title='Assign Client Category'>*</a>";
				} else {

					$paidOrNot = "<a style='color:red' href='#' title='Not Assign Client Category'>*</a>";
				}

				$data[] = [
					$username . " " . $paidOrNot,
					$lead->business_name . '' . $type,
					$lead->first_name . ' ' . $lead->last_name,
					$lead->city,
					$lead->email,
					$lead->mobile,
					//(isset($lead->keyword)?$lead->keyword:""),
					$assignedLeadsCount,
					(new Carbon($lead->created_at))->format('d-m-Y'),
					((isset($user) && $user) ? $user->first_name . " " . $user->last_name : ""),
					$action
				];
				unset($user);
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}

	/**
	 * Get paginated clients.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getClientsExcel(Request $request)
	{
		//if($request->ajax()){
		$leads = DB::table('clients');
		$select = 'clients.*';
		if ($request->input('search.client_category') != '') {
			$leads = $leads->join('assigned_client_categories', 'clients.id', '=', 'assigned_client_categories.client_id');
			$select = 'assigned_client_categories.client_category_id';
		}
		$leads = $leads->select('clients.*', $select);
		$leads = $leads->orderBy('clients.id', 'desc');
		$leads = $leads->whereNull('clients.deleted_at');
		if ($request->input('search.value') != '') {
			$leads = $leads->where(function ($query) use ($request) {
				$query->orWhere('clients.username', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('clients.business_name', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('clients.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('clients.email', 'LIKE', '%' . $request->input('search.value') . '%');
			});
		}
		if ($request->input('search.client_type') != '') {
			$leads = $leads->where('clients.client_type', 'LIKE', $request->input('search.client_type'));
		}

		if ($request->input('search.user') != '') {
			$leads = $leads->where('clients.created_by', '=', $request->input('search.user'));
		}
		if ($request->input('search.paid_status') != '') {
			$leads = $leads->where('clients.paid_status', 'LIKE', $request->input('search.paid_status'));
		}

		if ($request->input('search.city') != '') {
			$cityss = $request->input('search.city');
			$cityarr = explode(',', $cityss);
			if (!empty($cityarr)) {
				foreach ($cityarr as $city) {
					$cityList[] = $city;
				}
				$leads = $leads->whereIn('clients.city', $cityList);
			}
		}
		if ($request->input('search.datef') != '') {
			$leads = $leads->whereDate('clients.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
		}
		if ($request->input('search.datet') != '') {
			$leads = $leads->whereDate('clients.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
		}
		if ($request->input('search.client_category') != '') {
			$leads = $leads->where('assigned_client_categories.client_category_id', $request->input('search.client_category'));
		}
		$leads = $leads->get();

		$returnLeads = [];
		$data = [];
		//$returnLeads['draw'] = $request->input('draw');
		//$returnLeads['recordsTotal'] = $leads->total();
		//$returnLeads['recordsFiltered'] = $leads->total();
		foreach ($leads as $lead) {
			$assignedClientCategories = DB::table('assigned_client_categories')->where('client_id', $lead->id)->get();
			$clientCategories = DB::table('client_categories')->get();
			$acs = '';
			foreach ($assignedClientCategories as $assignedClientCategory) {
				foreach ($clientCategories as $clientCategory) {
					if ($clientCategory->id == $assignedClientCategory->client_category_id) {
						$acs .= $clientCategory->name . ",";
					}
				}
			}
			$acs = trim(implode(",", explode(",", $acs)), ' ,');

			$assignedLeadsCount = 0;
			$assignedLeadsCount = AssignedLead::where('client_id', '=', $lead->id)->count();

			$type = 'General';
			switch ($lead->client_type) {
				case 'lead_based':
					$type = 'Lead Based';
					break;
				case 'yearly_subscription':
					$type = 'Yearly Subscription';
					break;
				case 'free_subscription':
					$type = 'Free Subscription';
					break;
			}

			$arr[] = [
				"Reg_Date" => date_format(date_create($lead->created_at), 'd-F-Y'),
				"UID" => $lead->username,
				"Business Name" => $lead->business_name,
				"Client Type" => $type,
				"Client Category" => (null == $acs ? "" : $acs),
				"Name" => $lead->first_name . ' ' . $lead->last_name,
				"City" => $lead->city,
				"Email" => $lead->email,
				"Mobile" => $lead->mobile,
				"Leads" => "$assignedLeadsCount",
				"Exp Date" => (($lead->yrly_subs_end_date != NULL) ? date_format(date_create($lead->yrly_subs_end_date), 'd-F-Y') : "NULL"),
				"Remaining Amt" => (($lead->balance_amt == 0 || $lead->balance_amt == NULL) ? "0" : $lead->balance_amt),
				"Address" => $lead->address . ', ' . $lead->landmark . ', ' . $lead->city . ', ' . $lead->state . ', ' . $lead->country
			];
		}

		$excel = \App::make('excel');
		Excel::create('clients', function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('xls');
		//}
	}

	/**
	 * Handling client remark
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function remark(Request $request, $id = null)
	{
		if (null == $id) {
			return response() - json(['msg' => 'Client Not Found'], 400);
		}

		if ($request->has('action') && $request->input('action') == 'getClientRF') {
			$html = '';
			$client = Client::where('username', 'LIKE', $id)->first();
			$remark = '';
			if (null != $client->remark) {
				$remarks = explode("|", $client->remark);
				$remarks = array_slice($remarks, -10, 10, true);
				//return $remarks;

				foreach ($remarks as $remrk) {
					if (!empty($remrk)) {
						$remrk = explode("-", $remrk);
						$remrk = "[" . date('d-m-Y H:i:s', $remrk[0]) . "] " . $remrk[1];
						$remark .= $remrk . "<br>";
					}
				}
			}

			$warningDiv = '<div class="alert alert-warning">{{remark}}</div>';
			if (!empty($remark)) {
				$warningDiv = preg_replace('/{{remark}}/', $remark, $warningDiv);
			} else {
				$remark .= '<strong>No Remark Available !!</strong><br>';
				$warningDiv = preg_replace('/{{remark}}/', $remark, $warningDiv);
			}
			$html .= '<div class="modal fade" id="client-remark-modal" role="dialog">
				<div class="modal-dialog">
					<form onsubmit="return client.submitClientRF(this)">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title"><i class="fa fa-fw fa-comments"></i> Enter remark to your client</h4>
							</div>
							<div class="modal-body">
								' . $warningDiv . '
								<div class="form-group">
									<label>Remark</label>
									<input type="hidden" name="client-id" value="' . $client->username . '" />
									<textarea name="client-remark" rows="5" class="form-control"></textarea>
								</div>
								<div class="has-error">
									<span class="help-block">
										<strong>Note:</strong>
										<strong>Use of | and - not allowed in remark</strong><br>
										<strong>Remark field cannot be blank</strong><br>
									</span>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-default">Submit</button>
								<button type="button" class="btn btn-default" onclick="javascript:client.closeClientRF()">Close</button>
							</div>
						</div>
					</form>
				</div>
			</div>';
			return response()->json([$html], 200);
		}

		if ($request->has('action') && $request->input('action') == 'submitClientRF') {
			$client = Client::where('username', 'LIKE', $id)->first();
			$time = time();
			$html = "[" . date('d-m-Y H:i:s', $time) . "] " . $request->input('clientRemark');
			if (null == $client->remark) {
				$client->remark = $time . "-" . $request->input('clientRemark');
			} else {
				$client->remark .= "|" . $time . "-" . $request->input('clientRemark');
			}
			if ($client->save()) {
				return response()->json([$html], 200);
			}
		}
	}


	/**
	 * Handling client remark
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function remarkDiscussion(Request $request, $id = null)
	{
		if (null == $id) {
			return response() - json(['msg' => 'Client Not Found'], 400);
		}

		$admin_id = $request->user()->id;

		if ($request->input('action') == 'submitClientDiscussion') {
			$client = Client::where('username', 'LIKE', $id)->first();
			$discussion = $request->input('clientRemark');
			$add_data = array(
				'client_id' => $client->id,
				'admin_id' => $admin_id,
				'name' => $request->user()->first_name,
				'discussion' => $discussion,
			);

			$add = DB::table('client_discussion')->insert($add_data);
			$client = Client::where('username', $id)->first();
			$discussion = DB::table('client_discussion')->where('client_id', $client->id)->where('admin_id', $admin_id)->get();

		}
		$time = time();
		$html = "[" . date('d-m-Y H:i:s', $time) . "] " . $request->input('clientRemark');
		return response()->json([$html], 200);
	}


	/**
	 * Handling client remark
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function paymentClient(Request $request)
	{


		if ($request->ajax()) {

			$id = $request->input('client-id');
			if (null == $id) {
				return response()->json(['msg' => 'Client Not Found'], 400);
			}
			$validator = Validator::make($request->all(), [

				'business_name' => 'required',
				'package_name' => 'required',
				'selectproofid' => 'required',
				'paid_amount' => 'required',
				'gst_status' => 'required',
				'gst_total_amount' => 'required',
				'tds_status' => 'required',
				'total_amount' => 'required',
				// 'paid_amt_in_words'=>'required',
				'stud-payment_mode' => 'required',
				//'pay_mode_details'=>'required',
				//	'expired_from'=>'required',
				//	'expired_on'=>'required',
				'coins_amt' => 'required',
				// 'leads_count'=>'required',

			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}




			if ($request->input('pay-submit') == 'savepay' && !empty($request->input('paid_amount'))) {

				$client = Client::withTrashed()->where('username', $id)->first();

				$paymenthistory = new PaymentHistory;
				$paymenthistory->client_id = $client->id;
				$paymenthistory->customer_name = $client->first_name . ' ' . $client->last_name;
				$paymenthistory->business_name = trim($request->input('business_name'));
				$paymenthistory->mobile = $client->mobile;
				$paymenthistory->email = $client->email;
				$paymenthistory->package_name = $request->input('package_name');
				// $paymenthistory->leads_count = $request->input('leads_count');
				// $paymenthistory->cost_per_lead = $request->input('coins_lead');
				$paymenthistory->coins_amt = $request->input('coins_amt');
				//	$paymenthistory->expired_from = $request->input('expired_from');
				//	$paymenthistory->expired_on = $request->input('expired_on');
				$paymenthistory->selectproofid = $request->input('selectproofid');
				$paymenthistory->proofid = $request->input('proofid');
				$paid_amount = $request->input('paid_amount');
				$paymenthistory->paid_amount = $paid_amount;
				$tds_status = $request->input('tds_status');
				$paymenthistory->tds_status = $request->input('tds_status');
				$gst_tax = $request->input('gst_tax');
				$paymenthistory->gst_tax = $gst_tax;
				$gst_total_amount = $request->input('gst_total_amount');
				$paymenthistory->gst_total_amount = $gst_total_amount;
				$gst_status = $request->input('gst_status');
				$paymenthistory->gst_status = $request->input('gst_status');
				$tds_amount = $request->input('tds_amount');
				$paymenthistory->tds_amount = $tds_amount;
				$total_amount = $request->input('total_amount');
				$paymenthistory->total_amount = $total_amount;
				// $paid_amt_in_words=$request->input('paid_amt_in_words');
				// $paymenthistory->paid_amt_in_words = $paid_amt_in_words;
				//$pay_mode_details=$request->input('pay_mode_details');
				//$paymenthistory->pay_mode_details = $pay_mode_details;
				$transactionid = $request->input('transactionid');
				$paymenthistory->transactionid = $transactionid;
				$paymenthistory->paymentcollect = $request->user()->id;

				// payment mode
				if (!empty($request->input('stud-payment_mode'))) {
					$stud_payment_mode = $request->input('stud-payment_mode');
					if ("cash" == $request->input('stud-payment_mode')) {
						$stud_payment_bank = "cash";
					} else if ("bank" == $stud_payment_mode) {
						if (!empty($request->input('stud-bank'))) {
							$stud_payment_bank = $request->input('stud-bank');
							$stud_card_no = $request->input('stud-card_no');
							$paymenthistory->bank_card_no = $stud_card_no;

						}


					} else if ("cheque" == $stud_payment_mode) {
						if (!empty($request->input('stud-chq_no'))) {
							$stud_card_chq_no = $request->input('stud-chq_no');
							$paymenthistory->chq_card_no = $stud_card_chq_no;

						}
						$stud_payment_bank = "cheque";
					} else if ("paytm" == $stud_payment_mode) {
						if (!empty($request->input('stud-paytm'))) {
							$stud_paytm = $request->input('stud-paytm');
							$paymenthistory->pay_paytm = $stud_paytm;
							$stud_payment_bank = "paytm";
						}

					} else if ("neft" == $stud_payment_mode) {
						if (!empty($request->input('stud-neft'))) {
							$stud_neft = $request->input('stud-neft');
							$paymenthistory->pay_neft = $stud_neft;
							$stud_payment_bank = "neft";
						}

					} else if ("googlepay" == $stud_payment_mode) {
						if (!empty($request->input('stud-googlepay'))) {
							$pay_googlepay = $request->input('stud-googlepay');
							$paymenthistory->pay_googlePay = $pay_googlepay;
							$stud_payment_bank = "googlepay";
						}

					} else {
						if (!empty($request->input('stud-' . $stud_payment_mode))) {
							$stud_payment_bank = $request->input('stud-' . $stud_payment_mode);
						}

					}

				}
				$paymenthistory->payment_mode = $stud_payment_mode;
				$paymenthistory->payment_bank = $stud_payment_bank;

				if ($paymenthistory->save()) {
					$paymentupdate = PaymentHistory::find($paymenthistory->id);
					$cityname = $request->input('business_name');
					$clientIDToAppend = $clientID = $client->id;
					/* if(strlen((string)$clientID)<4){
					$clientIDToAppend = str_pad($clientIDToAppend, 4, '0', STR_PAD_LEFT);
					} */
					$order_number = strtoupper(substr($cityname, 0, 2)) . $clientIDToAppend . $paymenthistory->id;
					$paymentupdate->order_number = $order_number;
					$paymentupdate->save();

					/* $assignKeyword = DB::table('assigned_kwds')
								->join('cities','assigned_kwds.city_id','=','cities.id')
								->join('parent_category','assigned_kwds.parent_cat_id','=','parent_category.id')
								->join('child_category','assigned_kwds.child_cat_id','=','child_category.id')
								->join('keyword','assigned_kwds.kw_id','=','keyword.id')
								->select('assigned_kwds.*','cities.city','parent_category.parent_category','child_category.child_category','keyword.keyword')
								->where('assigned_kwds.client_id',$client->id)
								->get();

					Mail::send('emails.send_client-orderform',['client'=>$client,'order_number'=>$order_number,'total_amount'=>$total_amount,'paid_amount'=>$paid_amount,'gst_tax'=>$gst_tax,'tds_amount'=>$tds_amount,'payment_mode'=>$stud_payment_mode,'assignKeyword'=>$assignKeyword,'paid_amt_in_words'=>$paid_amt_in_words,'pay_mode_details'=>$pay_mode_details,'transactionid'=>$transactionid,'paymentupdate'=>$paymentupdate], function ($m) use ($client) {
				$m->from('info@quickdials.com', 'quickdials');
				$email = "info@quickdials.com";
				$m->to("info@quickdials.com", $client->first_name." ".$client->last_name)->subject('quickdials Order Details')->cc('help@quickdials.com');
			}); */



					return response()->json(['status' => 1, 'success' => 'Client Order payment successfully !!']);
				} else {
					return response()->json(['status' => 0, 'failed' => 'Client not updated !!']);
				}



			}

		}
	}

	/**
	 * Get paginated leads.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginatedPaymentHistory(Request $request, $id = null)
	{

		//if($request->ajax()){
		//$leads = Lead::orderBy('id','desc')->paginate($request->input('length'));
		if (null !== $id) {
			$client = Client::where('username', $id)->first();
			$clientID = $client->id;
		}


		$payments = DB::table('payment_histories')
			->where('client_id', $clientID)
			->orderBy('created_at', 'desc')
			->paginate($request->input('length'));

		$returnLeads = $data = [];
		$returnLeads['draw'] = $request->input('draw');
		$returnLeads['recordsTotal'] = $payments->total();
		$returnLeads['recordsFiltered'] = $payments->total();
		foreach ($payments as $payment) {
			$orderpdf = '';
			$invoicepdf = '';
			$action = '';
			$separator = '';
			$proforma = '';
			$orderpdf .= $separator . '<a href="javascript:void(0)" data-toggle="popover" title="Oder PDF" id="paymentPrint" data-trigger="hover" data-placement="left" data-sid="' . $payment->id . '"><i aria-hidden="true" class="fa fa-file-pdf-o"></i></a> ';
			$proforma .= $separator . '<a href="javascript:void(0)" data-toggle="popover" title="Proforma Invoice PDF" id="proformaPrintPdf" data-trigger="hover" data-placement="left" data-sid="' . $payment->id . '"><i aria-hidden="true" class="fa fa-file-pdf-o"></i></a>';
			if ($payment->invoice_status == 1) {
				$invoicepdf .= $separator . '<a href="javascript:void(0)" data-toggle="popover" title="Invoice PDF" id="invoicePrintPdf" data-trigger="hover" data-placement="left" data-sid="' . $payment->id . '"><i aria-hidden="true" class="fa fa-file-pdf-o"></i></a>';
			} else {
				if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('client_invoice_approved')) {
					$invoicepdf .= $separator . '<a href="javascript:client.clientOrderHistoryStatus(' . $payment->id . ')" data-toggle="popover" title="Invoice Status Pending" ><i aria-hidden="true" class="fa fa-thumbs-up"></i></a>';
				}
			}

			$action .= $separator . '<a href="/developer/order-history/update/' . base64_encode($payment->id) . '" class="btn btn-info btn-sm"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a>';
			if ($request->user()->current_user_can('administrator')) {
				$action .= $separator . ' <a href="javascript:client.clientOrderHistoryDelete(' . $payment->id . ')" title="clientOrderhistory Delete"><i class="fa fa-fw fa-trash"></i></a>';
			}


			$data[] = [
				date_format(date_create($payment->created_at), 'd M Y'),
				$payment->paid_amount,
				$payment->gst_tax,
				$payment->total_amount,
				ucfirst($payment->payment_mode),
				$orderpdf,
				$proforma,
				$invoicepdf,
				$action,

			];
		}
		$returnLeads['data'] = $data;
		return response()->json($returnLeads);
		//}
	}





	public function getpaymentPrintfile(Request $request)
	{

		return view('admin.getPaymentPrintSlip');
	}




	public function getpaymentPrint(Request $request)
	{
		if (isset($_POST['pid'])) {

			if ($request->input('action') == 'getPaymentPrint') {
				$paymnetid = $_POST['pid'];

				$paymentuprint = PaymentHistory::find($paymnetid);
				$client = Client::withTrashed()->where('id', $paymentuprint->client_id)->first();
				$assignKeyword = DB::table('assigned_kwds')
					->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
					->join('parent_category', 'assigned_kwds.parent_cat_id', '=', 'parent_category.id')
					->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
					->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
					->select('assigned_kwds.*', 'citylists.city', 'parent_category.parent_category', 'child_category.child_category', 'keyword.keyword','keyword.slug')
					->where('assigned_kwds.client_id', $client->id)
					->get();

				return response()->view("admin.getPaymentPrintSlip", ['paymentuprint' => $paymentuprint, 'client' => $client, 'assignKeyword' => $assignKeyword]);
				die;
			}
		}


	}


	public function getinvoicePrintPdf(Request $request)
	{
		if (isset($_POST['pid'])) {

			if ($request->input('action') == 'getinvoicePrintPdf') {
				$paymnetid = $_POST['pid'];
				$paymentprint = PaymentHistory::find($paymnetid);
				$client = Client::withTrashed()->where('id', $paymentprint->client_id)->first();
				return response()->view("admin.getInvoicePrintPdfSlip", ['paymentprint' => $paymentprint, 'client' => $client]);

				die;
			}
		}


	}

	public function getproformaPrintPdf(Request $request)
	{
		if (isset($_POST['pid'])) {
			if ($request->input('action') == 'getproformaPrintPdf') {
				$paymnetid = $_POST['pid'];
				$paymentprint = PaymentHistory::find($paymnetid);
				$client = Client::withTrashed()->where('id', $paymentprint->client_id)->first();
				return response()->view("admin.getproformaPrintPdf", ['paymentprint' => $paymentprint, 'client' => $client]);

				die;
			}
		}


	}


	/**
	 * Show resource update form.
	 *
	 * @param client id
	 * @param target id
	 * @param Request
	 * @return resource update form
	 */
	public function editAssignedKeyword(Request $request, $id, $target_id)
	{

		$assignedKwd = AssignedKWDS::findOrFail($target_id);

		$citylist = Citieslists::all();

		$cityOptions = "<option value=\"\">Select City</option>";
		if (count($citylist) > 0) {
			foreach ($citylist as $distinctCity) {
				$selected = "";
				if ($distinctCity->id == $assignedKwd->city_id)
					$selected = "selected";
				$cityOptions .= "<option value=\"{$distinctCity->id}\" {$selected}>{$distinctCity->city}</option>";
			}
		}
		$zonelist = DB::table('zones')
			->select('zones.*')
			->where('zones.city_id', $assignedKwd->city_id)
			->get();

		$zoneOptions = "<option value=\"\">Select Zone</option>";
		if (count($zonelist) > 0) {
			foreach ($zonelist as $zone) {
				$selected = "";
				if ($zone->id == $assignedKwd->zone_id)
					$selected = "selected";
				$zoneOptions .= "<option value=\"{$zone->id}\" {$selected}>{$zone->zone}</option>";
			}
		}

		$parentCategory = ParentCategory::all();


		$parentCatOptions = "<option value=''>Select Parent</option>";
		if (count($parentCategory) > 0) {
			foreach ($parentCategory as $parent_cat) {
				$selected = "";
				if ($parent_cat->id == $assignedKwd->parent_cat_id)
					$selected = "selected";
				$parentCatOptions .= "<option value=\"{$parent_cat->id}\" {$selected}>{$parent_cat->parent_category}</option>";
			}
		}
		$child_cats = DB::table('keyword')
			->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
			->select('child_category.id', 'child_category.child_category', 'keyword.parent_category_id', 'keyword.child_category_id')
			//->where('keyword.city_id',$assignedKwd->city_id)
			->where('keyword.parent_category_id', $assignedKwd->parent_cat_id)
			->groupBy('child_category_id')
			//->distinct()
			->get();
		$childCatOptions = "<option value=''>Select Child</option>";
		if (count($child_cats) > 0) {
			foreach ($child_cats as $child_cat) {
				$selected = "";
				if ($child_cat->id == $assignedKwd->child_cat_id)
					$selected = "selected";
				$childCatOptions .= "<option value=\"{$child_cat->id}\" {$selected}>{$child_cat->child_category}</option>";
			}
		}
		$child_cats = DB::table('keyword')
			//->where('city_id',$assignedKwd->city_id)
			->where('parent_category_id', $assignedKwd->parent_cat_id)
			->where('child_category_id', $assignedKwd->child_cat_id)
			->get();
		$keywordOptions = "<option value=''>Select Keyword</option>";
		//$keywordOptions = "";
		if (count($child_cats) > 0) {
			foreach ($child_cats as $child_cat) {
				$selected = "";
				if ($child_cat->id == $assignedKwd->kw_id)
					$selected = "selected";
				$keywordOptions .= "<option value=\"{$child_cat->id}\" {$selected}>{$child_cat->keyword}</option>";
			}
		}
		$keyword = Keyword::find($assignedKwd->kw_id);
		$keywordSellCount = KeywordSellCount::all();

		$assKWDSC = AssignedKWDS::where('city_id', $assignedKwd->city_id)->where('kw_id', $assignedKwd->kw_id)->where('sold_on_position', 'platinum')->where('id', '!=', $target_id)->get()->count();
		//	$assKWDSC = AssignedKWDS::where('city_id',$assignedKwd->city_id)->where('kw_id',$assignedKwd->kw_id)->where('sold_on_position','platinum')->get()->count();

		$result = [];
		foreach ($keywordSellCount as $ksc) {

			switch ($ksc->slug) {
				case 'platinum':
					if (($assKWDSC <= 2) && (((($ksc->count) + 3) - $assKWDSC - $keyword->platinum_pos_sold) > 0))
						$result['platinum'] = 'Platinum';
					break;
				case 'diamond':
					if ($ksc->count - $keyword->diamond_pos_sold > 0)
						$result['diamond'] = 'Diamond';
					break;

			}
		}


		$positionOptions = "<option value=''>Select Position</option>";
		if (count($result) > 0) {
			if (!array_key_exists($assignedKwd->sold_on_position, $result))
				$result[$assignedKwd->sold_on_position] = ucwords($assignedKwd->sold_on_position);
			foreach ($result as $key => $value) {
				$selected = "";
				if ($key == $assignedKwd->sold_on_position) {
					$selected = "selected";
					$positionOptions .= "<option value=\"{$key}\" {$selected}>{$value}</option>";
				} else {
					$positionOptions .= "<option value=\"{$key}\" >{$value}</option>";

				}
			}

		}

		$price = '';
		$resultPrice = [];
		//$price = "";
		$keyword = Keyword::find($assignedKwd->kw_id);
		$keywordSellCount = KeywordSellCount::where('slug', $assignedKwd->sold_on_position)->first();

		if (!empty($keywordSellCount)) {

			if ($keyword->category == 'Category 1') {
				$resultPrice['price'] = $keywordSellCount->cat1_price;
			} else if ($keyword->category == 'Category 2') {
				$resultPrice['price'] = $keywordSellCount->cat2_price;
			} else if ($keyword->category == 'Category 3') {
				$resultPrice['price'] = $keywordSellCount->cat3_price;
			} else if ($keyword->category == 'Category X') {
				switch ($assignedKwd->sold_on_position) {
					case 'diamond':
						$resultPrice['price'] = $keyword->premium_price;
						break;
					case 'platinum':
						$resultPrice['price'] = $keyword->platinum_price;
						break;
					case 'silver':
						$resultPrice['price'] = $keyword->platinum_price;
						break;
					case 'gold':
						$resultPrice['price'] = $keyword->platinum_price;
						break;

				}
			}
		}


		$html = "
				<div class=\"modal-body\">
					<form class=\"form-horizontal\" enctype=\"multipart/form-data\" action=\"" . url('developer/clients/update/' . $id . '/update-assigned-keyword/' . $target_id) . "\" method=\"POST\" id=\"update-assigned-keyword\">
						<div class=\"form-group\">
							<label class=\"control-label col-sm-2\">City:</label>
							<div class=\"col-sm-10\">
								<select class=\"select2-single city form-control\" name=\"city\">
								{$cityOptions}
								</select>
							</div>
						</div>
						
						<div class=\"form-group\">
							<label class=\"control-label col-sm-2\">Zone:</label>
							<div class=\"col-sm-10\">
								<select class=\"form-control zone\" name=\"zone_id\">
								{$zoneOptions}
								</select>
							</div>
						</div>
						
						<div class=\"form-group\">
							<label class=\"control-label col-sm-2\">Parent:</label>
							<div class=\"col-sm-10\">
								<select class=\"select2-single parent form-control\" name=\"parent\">
								{$parentCatOptions}
								</select>
							</div>
						</div>
						<div class=\"form-group\">
							<label class=\"control-label col-sm-2\">Child:</label>
							<div class=\"col-sm-10\">
								<select class=\"select2-single child form-control\" name=\"child\">
								{$childCatOptions}
								</select>
							</div>
						</div>
						<div class=\"form-group\">
							<label class=\"control-label col-sm-2\">Keyword:</label>
							<div class=\"col-sm-10\">
								<select class=\"form-control kw\" name=\"kw\">
								{$keywordOptions}
								</select>
							</div>
						</div>
						<div class=\"form-group\">
							<label class=\"control-label col-sm-2\">Position:</label>
							<div class=\"col-sm-10\">
								<select class=\"select2-single position form-control\" name=\"position\">
								{$positionOptions}
								</select>
							</div>
						</div>
						<div class=\"form-group\">
							<label class=\"control-label col-sm-2\">Price:</label>
							<div class=\"col-sm-10\">
								<input type=\"text\" class=\"form-control price\" value=\"{$resultPrice['price']}\" name=\"price\">
							</div>
						</div>
						<div class=\"form-group\">
							<div class=\"col-sm-offset-2 col-sm-10\">
								<button type=\"submit\" class=\"btn btn-default\">Submit</button>
								<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
							</div>
						</div>
					</form>
				</div>";
		return response()->json(['html' => $html], 200);
	}

	/**
	 * Update resource specified.
	 *
	 * @param Request
	 * @param client id
	 * @param target id
	 */
	public function updateAssignedKeyword(Request $request, $id, $target_id)
	{
		if ($request->ajax()) {
			$client = Client::withTrashed()->where('username', $id)->first();

			$validator = Validator::make($request->all(), [

				'city' => 'required',
				'zone_id' => 'required',
				'parent' => 'required',
				'child' => 'required',
				'kw' => 'required',
				'position' => 'required',


			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$validator = Validator::make($request->all(), [
				'kw' => 'required|unique:assigned_kwds,kw_id,' . $target_id . ',id,child_cat_id,' . $request->input('child') . ',parent_cat_id,' . $request->input('parent') . ',city_id,' . $request->input('city') . ',client_id,' . $client->id,
			]);
			if ($validator->fails()) {
				return response()->json(['status' => 0, 'message' => 'Assigned keyword must be unique']);
			}

			$assignedKWDS = AssignedKWDS::findOrFail($target_id);
			//$assignedKWDS->client_id = $client->id;
			// backing up old sold_on_position
			$old_sold_on_position = $assignedKWDS->sold_on_position;
			// backing up old sold_on_position
			$assignedKWDS->city_id = $request->input('city');
			$assignedKWDS->zone_id = $request->input('zone_id');
			$assignedKWDS->parent_cat_id = $request->input('parent');
			$assignedKWDS->child_cat_id = $request->input('child');
			$assignedKWDS->kw_id = $request->input('kw');
			$assignedKWDS->sold_on_position = $request->input('position');
			$assignedKWDS->sold_on_price = $request->input('price');

			$keyword = Keyword::find($request->input('kw'));
			$keywordSellCount = KeywordSellCount::where('slug', $request->input('position'))->first();
			if ($keyword->category === 'Category 1') {
				$assignedKWDS->sold_on_price = $keywordSellCount->cat1_price;
			} else if ($keyword->category === 'Category 2') {
				$assignedKWDS->sold_on_price = $keywordSellCount->cat2_price;
			} else if ($keyword->category === 'Category 3') {
				$assignedKWDS->sold_on_price = $keywordSellCount->cat3_price;
			} else if ($keyword->category === 'Category X') {
				switch ($request->input('position')) {
					case 'diamond':
						$assignedKWDS->sold_on_price = $keyword->diamond_price;
						break;
					case 'platinum':
						$assignedKWDS->sold_on_price = $keyword->platinum_price;
						break;

				}
			}

			if ($assignedKWDS->save()) {
				switch ($request->input('position')) {
					case 'diamond':
						$keyword->diamond_pos_sold = $keyword->diamond_pos_sold + 1;
						break;
					case 'platinum':
						$keyword->platinum_pos_sold = $keyword->platinum_pos_sold + 1;
						break;

				}
				switch ($old_sold_on_position) {
					case 'diamond':
						$keyword->diamond_pos_sold = $keyword->diamond_pos_sold - 1;
						break;
					case 'platinum':
						$keyword->platinum_pos_sold = $keyword->platinum_pos_sold - 1;
						break;

				}
				$keyword->save();
				return response()->json(['status' => 1, 'result' => 'Assigned keyword updated successfully']);
			} else {
				return response()->json(['status' => 0, 'result' => 'Assigned keyword not updated successfully']);
			}
		}
	}

	/**
	 *
	 *
	 *
	 */
	public function getAssignedZones(Request $request, $id)
	{

		if ($request->ajax()) {
			//echo $client_username;die;
			$client_username = $id;
			//$clientID = auth()->guard('clients')->user()->id;
			$clientID = Client::where('username', $client_username)->first();
			$leads = DB::table('assigned_zones');

			if ($request->input('search.value') != '') {

				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('citylists.city', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('zones.zone', 'LIKE', '%' . $request->input('search.value') . '%');
					// ->orWhere('leads.email','LIKE','%'.$request->input('search.value').'%');
				});
			}
			$leads = $leads->join('zones', 'assigned_zones.zone_id', '=', 'zones.id')
				->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
				->select('assigned_zones.*', 'citylists.city', 'zones.zone', 'assigned_zones.id as assign_id')
				->orderBy('assigned_zones.id', 'desc')
				->where('assigned_zones.client_id', $clientID->id)
				->paginate($request->input('length'));


			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();

			foreach ($leads as $lead) {

				$action = '<a href="javascript:assignedZoneController.delete(' . $lead->assign_id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				if (!empty($lead->zone)) {
					$zonename = $lead->zone;
				} else {
					$zonename = "";

				}
				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$lead->assign_id'></th>",
					$lead->city,
					$zonename,
					$action,

				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}

	/**
	 *
	 *
	 *
	 */
	public function getAssignedAreas(Request $request, $id)
	{
		$client_username = $id;
		if ($request->ajax()) {
			$client = Client::where('username', $client_username)->first();

			$assignedAreas = DB::table(DB::raw("(SELECT * FROM assigned_areas WHERE client_id={$client->id} ) as aa"));
			$assignedAreas = $assignedAreas->join('areas', 'areas.id', '=', DB::raw('`aa`.`area_id`'));
			$assignedAreas = $assignedAreas->join('zones', 'zones.id', '=', 'areas.zone_id');
			$assignedAreas = $assignedAreas->join('citylists', 'citylists.id', '=', 'zones.city_id');
			$assignedAreas = $assignedAreas->select('aa.id', 'aa.client_id', 'aa.area_id', 'areas.area', 'areas.zone_id', 'zones.zone', 'zones.city_id', 'citylists.city');

			$assignedAreas = $assignedAreas->orderBy('aa.id', 'desc');
			$assignedAreas = $assignedAreas->paginate($request->input('length'));
			$returnassignedareas = $data = [];
			$returnassignedareas['draw'] = $request->input('draw');
			$returnassignedareas['recordsTotal'] = $assignedAreas->total();
			$returnassignedareas['recordsFiltered'] = $assignedAreas->total();
			foreach ($assignedAreas as $assignedarea) {
				$data[] = [
					$assignedarea->area,
					$assignedarea->zone,
					$assignedarea->city,
					'<a href="/developer/area/update/' . $assignedarea->id . '"><i class="fa fa-refresh" aria-hidden="true"></i></a> | <a href="javascript:assignedAreaController.delete(' . $assignedarea->id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>'
				];
			}
			$returnassignedareas['data'] = $data;
			return response()->json($returnassignedareas);
		}
	}

	/**
	 * We are considering area as zone for now
	 *
	 */
	public function addAreaToClient(Request $request, $id)
	{
		$client_username = $id;
		$client = Client::where('username', $client_username)->first();

		$validator = Validator::make($request->all(), [
			'area_id' => 'required|unique:assigned_areas,area_id,NULL,id,client_id,' . $client->id,
			'zone_id' => 'required'
			//'city_id'=>'required',
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

		$assignedArea = new AssignedArea;
		$assignedArea->area_id = $request->input('area_id');
		$assignedArea->client_id = $client->id;
		if ($assignedArea->save()) {
			return response()->json([
				"statusCode" => 1,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => "Area assgined successfully !!"
				]
			], 200);
		} else {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 400,
					"payload" => "",
					"message" => "area not assigned !!"
				]
			], 200);
		}
	}

	/**
	 * We are considering area as zone for now
	 *
	 */
	public function addZoneToClient(Request $request, $id)
	{

		if ($request->ajax()) {

			if ($request->input('zone_id') == "Other") {
				$validator = Validator::make($request->all(), [
					'state_id' => 'required|max:32',
					'country' => 'required|max:32',
					'cityid' => 'required|max:32',
					'other' => 'required|min:3|max:32|regex:/^(?!.*(.)\1{3,}).+$/',
				]);

			} else {
				$validator = Validator::make($request->all(), [
					//'city_id' 	=> 'required|max:35',
					//'zone_id' => 'required|max:35',
					'state_id' => 'required|max:32',
					'country' => 'required|max:32',
				]);
			}

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}
			$client = Client::find($id);
			if (empty($request->input('zone_id')) && !empty($request->input('cityid')) && !empty($request->input('state_id'))) {

				$zones = Zone::where('city_id', $request->input('cityid'))->get();
				if (!empty($zones)) {
					foreach ($zones as $zone) {
						$assignedZone = new AssignedZone;
						$assignedZone->city_id = $request->input('cityid');
						$assignedZone->zone_id = $zone->id;
						$assignedZone->client_id = $client->id;
						$assignedZone->state_id = $request->input('state_id');
						$checkAssignedZone = AssignedZone::where('client_id', $client->id)->where('zone_id', $zone->id)->where('city_id', $request->input('cityid'))->where('state_id', $request->input('state_id'))->first();

						if (empty($checkAssignedZone)) {
							if ($assignedZone->save()) {

								$areas = DB::table('areas');
								$areas = $areas->where('areas.zone_id', '=', $zone->id);
								$areas = $areas->select('areas.id', 'areas.area');
								$areas = $areas->get();
								if (!empty($areas)) {
									foreach ($areas as $area) {
										$assigneddArea = new AssigneddArea;
										$assigneddArea->client_id = $client->id;
										$assigneddArea->state_id = $request->input('state_id');
										$assigneddArea->city_id = $request->input('cityid');
										$assigneddArea->assigned_zone_id = $zone->id;
										$assigneddArea->area_id = $area->id;
										$checkAssignedArea = AssigneddArea::where('client_id', $client->id)->where('assigned_zone_id', $zone->id)->where('city_id', $request->input('cityid'))->where('area_id', $area->id)->where('state_id', $request->input('state_id'))->first();
										if (empty($checkAssignedArea)) {
											$assigneddArea->save();
										} else {
											$already = 1;
										}

									}
								}
								$add = 1;
							}
						} else {
							$already = 1;

						}
					}
				}
				if (!empty($add)) {
					$status = true;
					$msg = 'Business Location add successfully';
					$code = 200;
				} else {
					if (!empty($already)) {
						$status = 0;
						$msg = "Already exists all City, Please add right city !";
						$code = 400;
					} else {
						$status = false;
						$msg = 'City not assigned';
						$code = 400;
					}

				}




			} else if (empty($request->input('zone_id')) && empty($request->input('cityid')) && !empty($request->input('state_id'))) {

				//state
				$states = State::where('id', $request->input('state_id'))->first();
				$cities = Citieslists::where('state_id', $states->id)->get();
				if (!empty($cities)) {
					foreach ($cities as $citis) {

						$zones = Zone::where('city_id', $citis->id)->get();
						if (!empty($zones)) {
							foreach ($zones as $zone) {
								$assignedZone = new AssignedZone;
								$assignedZone->city_id = $citis->id;
								$assignedZone->zone_id = $zone->id;
								$assignedZone->client_id = $client->id;
								$assignedZone->state_id = $states->id;
								$checkAssignedZone = AssignedZone::where('client_id', $client->id)->where('zone_id', $zone->id)->where('city_id', $citis->id)->where('state_id', $states->id)->first();

								if (empty($checkAssignedZone)) {
									if ($assignedZone->save()) {
										$areas = DB::table('areas');
										$areas = $areas->where('areas.zone_id', '=', $zone->id);
										$areas = $areas->select('areas.id', 'areas.area');
										$areas = $areas->get();
										if (!empty($areas)) {
											foreach ($areas as $area) {
												$assigneddArea = new AssigneddArea;
												$assigneddArea->client_id = $client->id;
												$assigneddArea->state_id = $states->id;
												$assigneddArea->city_id = $citis->id;
												$assigneddArea->assigned_zone_id = $zone->id;
												$assigneddArea->area_id = $area->id;
												$checkAssignedArea = AssigneddArea::where('client_id', $client->id)->where('assigned_zone_id', $zone->id)->where('city_id', $citis->id)->where('area_id', $area->id)->where('state_id', $states->id)->first();
												if (empty($checkAssignedArea)) {
													$assigneddArea->save();
												}
											}
										}
									}
									$add = 1;
								} else {
									$already = 1;
								}
							}
						}
					}
				}
				if (!empty($add)) {
					$status = true;
					$msg = 'Business Location add successfully';
					$code = 200;
				} else {
					if (!empty($already)) {
						$status = 0;
						$msg = "Already exists, Please add right city !";
						$code = 400;
					} else {
						$status = false;
						$msg = 'City not assigned';
						$code = 400;
					}
				}

			} elseif (!empty($request->input('zone_id')) && ($request->input('zone_id') != 'Other') && !empty($request->input('cityid')) && !empty($request->input('state_id'))) {
				//zone
				$assignedZone = new AssignedZone;
				$assignedZone->city_id = $request->input('cityid');
				$assignedZone->zone_id = $request->input('zone_id');
				$assignedZone->client_id = $request->input('client_id');
				$assignedZone->state_id = $request->input('state_id');
				$checkAssignedZone = AssignedZone::where('client_id', $request->input('client_id'))->where('zone_id', $request->input('zone_id'))->where('city_id', $request->input('cityid'))->first();

				if (empty($checkAssignedZone)) {
					if ($assignedZone->save()) {
						$areas = DB::table('areas');
						$areas = $areas->where('areas.zone_id', '=', $request->input('zone_id'));
						$areas = $areas->select('areas.id', 'areas.area');
						$areas = $areas->get();
						if (!empty($areas)) {
							foreach ($areas as $area) {
								$assigneddArea = new AssigneddArea;
								$assigneddArea->client_id = $request->input('client_id');
								$assigneddArea->state_id = $request->input('state_id');
								$assigneddArea->city_id = $request->input('cityid');
								$assigneddArea->assigned_zone_id = $request->input('zone_id');
								$assigneddArea->area_id = $area->id;
								$checkAssignedArea = AssigneddArea::where('client_id', $request->input('client_id'))->where('assigned_zone_id', $request->input('zone_id'))->where('city_id', $request->input('cityid'))->where('area_id', $area->id)->where('state_id', $request->input('state_id'))->first();
								if (empty($checkAssignedArea)) {
									$assigneddArea->save();

								}
							}
						}
						$add = 1;
					}
				} else {
					$already = 1;
				}


				if (!empty($add)) {
					$status = 1;
					$msg = "Business Location updated successfully !";
				} else {

					if (!empty($already)) {
						$status = false;
						$msg = "Already exists, Please add right city !";
						$code = 400;
					} else {
						$status = false;
						$msg = "Business Location could not be successfully, Please try again !";
						$code = 400;
					}
				}


			} else if (!empty($request->input('zone_id') == 'Other') && !empty($request->input('cityid')) && !empty($request->input('state_id')) && !empty($request->input('other'))) {

				//Other
				$assignedZone = new AssignedZone;
				$assignedZone->city_id = $request->input('cityid');
				if ($request->input('zone_id') == "Other") {
					$checkZone = Zone::where('zone', $request->input('other'))->where('city_id', $request->input('cityid'))->first();
					if (empty($checkZone)) {
						$zone = new Zone;
						$zone->city_id = $request->input('cityid');
						$zone->zone = ucfirst($request->input('other'));
						$zone->save();
						$zone_id = $zone->id;
					} else {
						$zone_id = $checkZone->id;
					}

				} else {
					$zone_id = $request->input('zone_id');
				}
				$assignedZone->zone_id = $zone_id;
				$assignedZone->client_id = $request->input('client_id');
				$assignedZone->state_id = $request->input('state_id');
				$checkAssignedZone = AssignedZone::where('client_id', $request->input('client_id'))->where('zone_id', $zone_id)->where('city_id', $request->input('cityid'))->where('state_id', $request->input('state_id'))->first();
				if (empty($checkAssignedZone)) {
					if ($assignedZone->save()) {
						$status = 1;
						$msg = "Business Location updated successfully !";
					} else {
						$status = 0;
						$msg = "Business Location could not be successfully, Please try again !";
					}
				} else {
					$status = 0;
					$msg = "Already exists <strong>" . $request->input('other') . "</strong> Please add right zone !";
				}

			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroyAreaFromClient(Request $request, $id, $assigned_area_id)
	{
		try {
			$assginedArea = AssignedArea::findorFail($assigned_area_id);
			if ($assginedArea->delete()) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Assigned area deleted successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Assigned area not deleted !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Assigned area not found !!"
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
	public function destroyZoneFromClient(Request $request, $id, $assigned_zone_id)
	{
		try {
			$assginedArea = AssignedZone::findorFail($assigned_zone_id);
			if ($assginedArea->delete()) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Assigned zone deleted successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Assigned zone not deleted !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Assigned zone not found !!"
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
	public function selectAssignZoneDelete(Request $request)
	{

		$ids = $request->input('ids');
		try {
			if (!empty($ids)) {
				foreach ($ids as $id) {

					$assignedZone = AssignedZone::find($id);

					if (!empty($assignedZone)) {
						AssigneddArea::where('assigned_zone_id', $assignedZone->zone_id)->where('client_id', $assignedZone->client_id)->where('state_id', $assignedZone->state_id)->where('city_id', $assignedZone->city_id)->delete();
						$assignedZone->delete();
						$delete = 1;
					}
				}
			}
			if (!empty($delete)) {
				$status = 1;
				$msg = "Assigned Zone Successfully!";
			} else {
				$status = 0;
				$msg = "Assigned Zone could not be Deleted!";
			}

		} catch (Exception $e) {
			$status = 0;
			$msg = $e->getMessage();
		}
		return response()->json(['status' => $status, 'msg' => $msg], 200);
	}


	/**
	 * Show the form for editing the specified resource assigned to client.
	 *
	 * @param $request,$id,form.
	 * @return JSON.
	 */
	public function editAssignedZone(Request $request, $id, $assigned_zone_id)
	{
		$client_username = $id;
		try {
			$client = Client::where('username', $client_username)->first();
			if ($client) {
				$assignedZone = DB::table(DB::raw("(SELECT * FROM assigned_zones WHERE id={$assigned_zone_id} ) as aa"));
				$assignedZone = $assignedZone->join('zones', 'zones.id', '=', DB::raw('`aa`.`zone_id`'));
				$assignedZone = $assignedZone->join('citylists', 'citylists.id', '=', 'zones.city_id');
				$assignedZone = $assignedZone->select('aa.id', 'aa.client_id', 'aa.zone_id', 'zones.zone', 'zones.city_id', 'citylists.city');
				$assignedZone = $assignedZone->first();

				$areas = DB::table('areas');
				$areas = $areas->where('areas.zone_id', '=', $assignedZone->zone_id);
				$areas = $areas->select('areas.id', 'areas.area');
				$areas = $areas->get();

				$assignedAreas = DB::table('assignedd_areas');
				$assignedAreas = $assignedAreas->where('assigned_zone_id', $assignedZone->id);
				$assignedAreas = $assignedAreas->select('assignedd_areas.area_id')->get();

				$tmp = [];
				foreach ($assignedAreas as $assignedArea) {
					$tmp[] = $assignedArea->area_id;
				}
				$assignedArea = $tmp;

				$allAreasHtml = '';
				foreach ($areas as $area) {
					$checked = '';
					if (count($assignedArea) > 0 && in_array($area->id, $assignedArea)) {
						$checked = 'checked';
					}
					$allAreasHtml .= '
						<div class="col-md-4">
							<div class="checkbox">
								<label><input type="checkbox" name="assigned_areas[]" value="' . $area->id . '" ' . $checked . '> ' . $area->area . '</label>
							</div>
						</div>
					';
				}

				$html = '
					<div id="editAssignedZone" class="modal fade" role="dialog">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<form id="assignedZoneAreas" role="form" action="" method="POST">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">' . $assignedZone->city . ' -> ' . $assignedZone->zone . '</h4>
										' . csrf_field() . '
										<input type="hidden" name="assigned-zone-record-id" value="' . $assignedZone->id . '" />
									</div>
									<div class="modal-body">
										<div class="alert alert-danger hide"></div>
										<div class="alert alert-success hide"></div>
										<div class="container col-md-12">
											<div class="row">
											' . $allAreasHtml . '
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="modal-footer">
										<button type="button" class="pull-left btn btn-default" onclick="checkAll(\'editAssignedZone\')">Check All</button>
										<button type="button" class="pull-left btn btn-default" onclick="unCheckAll(\'editAssignedZone\')">Uncheck All</button>
										<button type="submit" class="btn btn-default">Submit</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				';
				return response()->json([
					'statusCode' => 1,
					'data' => [
						'responseCode' => 200,
						'payload' => $html,
						'message' => ''
					]
				], 200);
			} else {
				throw new Exception('No client found having id: ' . $client_username);
			}
		} catch (\Exception $e) {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => $e->getMessage()
				]
			], 200);
		}
	}

	/**
	 * Show the form for editing the specified resource assigned to client.
	 *
	 * @param $request,$id,form.
	 * @return JSON.
	 */
	public function editAssignedZoneClient(Request $request, $id, $assigned_zone_id)
	{
		$client_username = $id;

		//echo $assigned_zone_id;die;
		try {
			$client = Client::where('username', $client_username)->first();
			if ($client) {


				$assignedZone = AssignedZone::findOrFail($assigned_zone_id);

				DB::table(DB::raw("(SELECT * FROM assigned_zones WHERE id={$assigned_zone_id} ) as aa"));
				$assignedZone = DB::table(DB::raw("(SELECT * FROM assigned_zones WHERE id={$assigned_zone_id} ) as aa"));
				$assignedZone = $assignedZone->join('zones', 'zones.id', '=', DB::raw('`aa`.`zone_id`'));
				$assignedZone = $assignedZone->join('citylists', 'citylists.id', '=', 'zones.city_id');
				$assignedZone = $assignedZone->select('aa.id', 'aa.client_id', 'aa.zone_id', 'zones.zone', 'zones.city_id', 'citylists.city');
				$assignedZone = $assignedZone->first();

				$areas = DB::table('areas');
				$areas = $areas->where('areas.zone_id', '=', $assignedZone->zone_id);
				$areas = $areas->select('areas.id', 'areas.area');
				$areas = $areas->get();

				$assignedAreas = DB::table('assignedd_areas');
				$assignedAreas = $assignedAreas->where('assigned_zone_id', $assignedZone->id);
				$assignedAreas = $assignedAreas->select('assignedd_areas.area_id')->get();

				$tmp = [];
				foreach ($assignedAreas as $assignedArea) {
					$tmp[] = $assignedArea->area_id;
				}
				$assignedArea = $tmp;

				$allAreasHtml = '';
				$citieslists = Citieslists::orderBy('city', 'ASC')->get();
				$cityHtml = '';
				if (!empty($citieslists)) {
					foreach ($citieslists as $city) {
						if ($city->city == $assignedZone->city_id) {
							$cityHtml .= '<option value="' . $city->city . '" selected>' . $city->city . '</option>';
						} else {
							$cityHtml .= '<option value="' . $city->city . '">' . $city->city . '</option>';
						}
					}
				}

				$html = '
					<div id="editAssignedZone" class="modal fade" role="dialog">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<form id="assignedZoneAreas" role="form" action="" method="POST">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Zone Edit</h4>										 
										<input type="hidden" name="assigned-zone-record-id" value="' . $assignedZone->id . '" />
									</div>
									<div class="modal-body">
									
										<div class="alert alert-danger hide"></div>
										<div class="alert alert-success hide"></div>
										<div class="container col-md-12">
											 
											
												<div class="row">
											<div class="col-md-4 text-right">	
									<div class="form-group">
										<div class="row">
										
										<label for="">City:</label>
										<select class="form-control location city select2-single" name="city_id">
															<option value="">-- SELECT CITY --</option>
																' . $cityHtml . '
														</select>
										</div>
									</div>
									</div>
									
									<div class="col-md-4 text-right">
									<div class="form-group">
										<label for="">Zone:</label>
										<select name="zone_id" class="form-control"></select>
										<button type="reset" class="btn btn-primary" style="margin-top:10px;">Reset</button>
										<input type="submit" class="btn btn-info" value="Submit" style="margin-top:10px;">
									</div>
									</div>
											</div>
											
											
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="modal-footer">
										<button type="button" class="pull-left btn btn-default" onclick="checkAll(\'editAssignedZone\')">Check All</button>
										<button type="button" class="pull-left btn btn-default" onclick="unCheckAll(\'editAssignedZone\')">Uncheck All</button>
										<button type="submit" class="btn btn-default">Submit</button>
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				';
				return response()->json([
					'statusCode' => 1,
					'data' => [
						'responseCode' => 200,
						'payload' => $html,
						'message' => ''
					]
				], 200);
			} else {
				throw new Exception('No client found having id: ' . $client_username);
			}
		} catch (\Exception $e) {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => $e->getMessage()
				]
			], 200);
		}
	}

	/**
	 * Show the form for editing the specified resource assigned to client.
	 *
	 * @param $request,$id,form.
	 * @return JSON.
	 */
	public function updateAssignedZoneAreas(Request $request, $id)
	{		  
		$client_username = $id;
		$assigned_zone_id = $request->input('assigned-zone-record-id');
		//submitted areas
		$requestAssignedAreas = $request->input('assigned_areas');
		$tmp = [];
		if (count($requestAssignedAreas) > 0) {
			foreach ($requestAssignedAreas as $requestAssignedArea) {
				$tmp[] = $requestAssignedArea;
			}
		}
		$requestAssignedAreas = $tmp;
		try {
			$client = Client::where('username', $client_username)->first();
			if ($client) {
				$assignedZone = DB::table(DB::raw("(SELECT * FROM assigned_zones WHERE id={$assigned_zone_id} ) as aa"));
				$assignedZone = $assignedZone->join('zones', 'zones.id', '=', DB::raw('`aa`.`zone_id`'));
				$assignedZone = $assignedZone->join('citylists', 'citylists.id', '=', 'zones.city_id');
				$assignedZone = $assignedZone->select('aa.id', 'aa.client_id', 'aa.zone_id', 'zones.zone', 'zones.city_id', 'citylists.city');
				$assignedZone = $assignedZone->first();

				//all areas
				$areas = DB::table('areas');
				$areas = $areas->where('areas.zone_id', '=', $assignedZone->zone_id);
				$areas = $areas->select('areas.id', 'areas.area');
				$areas = $areas->get();

				//assigned areas
				$assignedAreas = DB::table('assignedd_areas');
				$assignedAreas = $assignedAreas->where('assigned_zone_id', $assignedZone->id);
				$assignedAreas = $assignedAreas->select('assignedd_areas.area_id')->get();

				$tmp = [];
				foreach ($assignedAreas as $assignedArea) {
					$tmp[] = $assignedArea->area_id;
				}
				$assignedArea = $tmp;

				foreach ($areas as $area) {
					if (in_array($area->id, $requestAssignedAreas) && !in_array($area->id, $assignedArea)) {
						$assigneddArea = new AssigneddArea;
						$assigneddArea->assigned_zone_id = $assignedZone->id;
						$assigneddArea->area_id = $area->id;
						$assigneddArea->save();
					} else if (!in_array($area->id, $requestAssignedAreas) && in_array($area->id, $assignedArea)) {
						AssigneddArea::where('assigned_zone_id', $assignedZone->id)->where('area_id', $area->id)->delete();
						//$deleted = DB::delete('delete from assignedd_areas where assigned_zone_id=\''.$assignedZone->id.'\' && area_id=\''.$area->id.'\'');
					}
				}
				return response()->json([
					'statusCode' => 1,
					'data' => [
						'responseCode' => 200,
						'payload' => [],
						'message' => 'Areas assigned updated successfully'
					]
				], 200);
			} else {
				throw new Exception('No client found having id: ' . $client_username);
			}
		} catch (\Exception $e) {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => $e->getMessage()
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
	public function geteditpayment(Request $request, $id)
	{
		if ($request->ajax()) {
			if (!$request->user()->current_user_can('administrator|admin|gb_associate')) {
				return response()->json(['status' => 0, 'message' => 'Unauthorised access'], 200);
			}
			$paymentHistory = PaymentHistory::find($id);
			$request->session()->put('keywordToUpdate', $paymentHistory->id);

			return response()->json(['status' => 1, 'paymentHistory' => $paymentHistory]);
		}
	}


	/**
	 * Delete transaction amuunt client .
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function clientTransactionDelete($id)
	{
		try {
			$transactiondelete = Transaction::findorFail($id);
			if ($transactiondelete->delete()) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Transaction deleted successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Transaction  not deleted !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Transaction not found !!"
				]
			], 200);
		}
	}

	public function logoDel($id)
	{
		$delet_data = Client::withTrashed()->where('username', $id)->first();

		if ($delet_data->logo != '') {
			$image = unserialize($delet_data->logo);

			$large = '' . $image['large']['src'];
			if (!empty($image['thumbnail']['src'])) {
				$thumbnail = '' . $image['thumbnail']['src'];
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('logo' => "", );
		$del = Client::where('username', $id)->update($edit_data);
		return redirect("/developer/clients/update/" . $id . "#uploadProfile");

	}


	public function profilePicDel($id)
	{
		$delet_data = Client::withTrashed()->where('username', $id)->first();
		if ($delet_data->profile_pic != '') {
			$image = unserialize($delet_data->profile_pic);
			$large = '' . $image['large']['src'];
			if (!empty($image['thumbnail']['src'])) {
				$thumbnail = '' . $image['thumbnail']['src'];
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}
		$edit_data = array('profile_pic' => "", );
		$del = Client::where('username', $id)->update($edit_data);

		return redirect("/developer/clients/update/" . $id . "#uploadProfile");

	}

	public function saveAssignKeyword(Request $request, $id)
	{
		 

		if ($request->ajax()) {

			$client = Client::withTrashed()->where('id', $id)->first();


			$validator = Validator::make($request->all(), [

				'keyword' => 'required|unique:assigned_kwds,kw_id,NULL,id,client_id,' . $client->id . ',kw_id,' . $request->input('keyword'),



			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}




			$data = [];
			$keyw = Keyword::find($request->input('keyword'));

			if (!empty($keyw)) {

				$assignvalidation = AssignedKWDS::where('parent_cat_id', $keyw->parent_category_id)->where('child_cat_id', $keyw->child_category_id)->where('kw_id', $keyw->id)->where('client_id', $client->id)->get()->count();

				if ($assignvalidation == 0) {

					$assignedKWDS = new AssignedKWDS;
					$assignedKWDS->client_id = $client->id;

					$assignedKWDS->parent_cat_id = $keyw->parent_category_id;
					$assignedKWDS->child_cat_id = $keyw->child_category_id;
					$assignedKWDS->kw_id = $keyw->id;
					$assignedKWDS->sold_on_position = 'diamond';

					$keyword = Keyword::find($keyw->id);
					$keywordSellCount = KeywordSellCount::where('slug', 'diamond')->first();
					if (!empty($keywordSellCount)) {
						if ($keyword->category === 'Category 1') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat1_price;
						} else if ($keyword->category === 'Category 2') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat2_price;
						} else if ($keyword->category === 'Category 3') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat3_price;
						} elseif ($keyword->category === 'Category 4') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat4_price;
						} elseif ($keyword->category === 'Category 5') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat5_price;
						} elseif ($keyword->category === 'Category 6') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat6_price;
						} elseif ($keyword->category === 'Category 7') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat7_price;
						} elseif ($keyword->category === 'Category 8') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat8_price;
						} elseif ($keyword->category === 'Category 9') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat9_price;
						} elseif ($keyword->category === 'Category 10') {
							$assignedKWDS->sold_on_price = $keywordSellCount->cat10_price;
						} else {
							$assignedKWDS->sold_on_price = '220';
						}
					}

					if ($assignedKWDS->save()) {
						$keyword->diamond_pos_sold = $keyword->diamond_pos_sold + 1;
					}


					if ($keyword->save()) {
						$status = true;
						$msg = "Keyword Assign add successfully !";
					} else {
						$status = false;
						$msg = "Keyword Assign could not be successfully, Please try again !";
					}
				} else {
					$status = false;
					$msg = "Already exist Keyword, Please try again !";
				}


			} else {
				$status = false;
				$msg = "Keyword not found, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);

		}
	}


	
public function certificateDel($slug,$id)
{
	 
		$delet_data = Client::findOrFail($id);
	 
		$client = Client::find($id);

		if ($delet_data->$slug != '') {
			$image = json_decode($delet_data->$slug);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array($slug => "", );
		$del = Client::where('id', $id)->update($edit_data);
		 
		return redirect("/developer/clients/update/" . $delet_data->username . "#certificate");

	}

		
	public function awardDel($slug,$id)
	{
		
			$delet_data = Client::findOrFail($id);
		
			$client = Client::find($id);

			if ($delet_data->$slug != '') {
				$image = json_decode($delet_data->$slug);

				$large = '' . $image->large->src;
				if (!empty($image->thumbnail->src)) {
					$thumbnail = '' . $image->thumbnail->src;
					if (file_exists($thumbnail)) {
						unlink($thumbnail);
					}
				}
				if (file_exists($large)) {
					unlink($large);
				}
			}

			$edit_data = array($slug => "", );
			$del = Client::where('id', $id)->update($edit_data);
			
			return redirect("/developer/clients/update/" . $delet_data->username . "#award");

	}


	public function gstDel($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->gst_certificate != '') {
			$image = json_decode($delet_data->gst_certificate);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('gst_certificate' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-certificate');
	}

	public function other1Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->other_certificate1 != '') {
			$image = json_decode($delet_data->other_certificate1);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('other_certificate1' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-certificate');
	}
	public function other2Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->other_certificate2 != '') {
			$image = json_decode($delet_data->other_certificate2);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('other_certificate2' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-certificate');
	}
	public function other3Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->other_certificate3 != '') {
			$image = json_decode($delet_data->other_certificate3);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('other_certificate3' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-certificate');
	}
	public function other4Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->other_certificate4 != '') {
			$image = json_decode($delet_data->other_certificate4);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('other_certificate4' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-certificate');
	}



	public function cinDel($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->cin_certificate != '') {
			$image = json_decode($delet_data->cin_certificate);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('cin_certificate' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-certificate');
	}

	public function msmeDel($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->msme_certificate != '') {
			$image = json_decode($delet_data->msme_certificate);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('msme_certificate' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-certificate');
	}

	public function awd1Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img1 != '') {
			$image = json_decode($delet_data->award_img1);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img1' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}

	public function awd2Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img2 != '') {
			$image = json_decode($delet_data->award_img2);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img2' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}

	public function awd3Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img3 != '') {
			$image = json_decode($delet_data->award_img3);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img3' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}

	public function awd4Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img4 != '') {
			$image = json_decode($delet_data->award_img4);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img4' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}

	public function awd5Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img5 != '') {
			$image = json_decode($delet_data->award_img5);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img5' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}



	
	public function awd6Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img6 != '') {
			$image = json_decode($delet_data->award_img6);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img6' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}



	
	public function awd7Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img7 != '') {
			$image = json_decode($delet_data->award_img7);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img7' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}



	
	public function awd8Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img8 != '') {
			$image = json_decode($delet_data->award_img8);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img8' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}


	
	public function awd9Del($id)
	{
		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		if ($delet_data->award_img9 != '') {
			$image = json_decode($delet_data->award_img9);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('award_img9' => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-award');
	}


}