<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Client\Client; //model
use Validator;
use Illuminate\Support\Facades\Input;
use Image;
use DB;
use Mail;
use Excel;
use session;
use App\Http\Controllers\SitemapsController as SMC;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Zone;
use App\Models\Lead;
use App\Models\User;
use App\Models\Keyword;
use App\Models\LeadFollowUp;
use App\Models\Status;
use App\Models\AssignedLead;

use App\Models\Occupation;
use App\Models\Citieslists;
use App\Models\AssignedZone;
use App\Models\KeywordSellCount;
use App\Models\Client\AssignedKWDS;
class BusinessController extends Controller
{
	protected $danger_msg = '';
	protected $success_msg = '';
	protected $warning_msg = '';
	protected $info_msg = '';
	protected $redirectTo = '/business-owners';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('client.business-owners');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function dashboard()
	{

		$clientID = auth()->guard('clients')->user()->id;
		$clientDetails = DB::table('clients')->where('id', $clientID)->first();
		$leads = DB::table('leads')
			->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->leftjoin('citylists', 'leads.city_id', '=', 'citylists.id')
			->leftjoin('areas', 'leads.area_id', '=', 'areas.id')
			->leftjoin('zones', 'leads.zone_id', '=', 'zones.id')
			->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created', 'areas.area', 'zones.zone')
			->orderBy('assigned_leads.created_at', 'desc')
			->where('assigned_leads.client_id', $clientID)->get();
		return view('business.dashboard', ['leads' => $leads, 'clientDetails' => $clientDetails]);
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
				'business_name' => 'required|regex:/[A-Za-z0-9 ]+/',
				'mobile' => 'required|unique:clients,mobile,NULL,id',
				'city' => 'required|max:50',
				'email' => 'required|email'
			], $messages);
			if ($validator->fails()) {
				return redirect("/business-owners")
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
					return redirect("/business-owners")
						->withErrors($validator)
						->withInput();
				}
				$slugExists = DB::table('clients')
					->select(DB::raw('business_slug'))
					->where('business_slug', 'like', '%' . $business_slug . '%')
					->orderBy('id', 'desc')
					->get();
				if (count($slugExists) > 0) {
					$business_slug = $slugExists[0]->business_slug;
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
			$last_name = preg_replace('/[^A-Za-z0-9]/', ' ', filter_var($request->input('last_name'), FILTER_SANITIZE_STRING));
			$last_name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			
			$client->last_name = $last_name;
			$client->city = $request->input('city');
			$client->mobile = $request->input('mobile');
			$client->email = $request->input('email');
			$client->max_kw = 30;

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

				$smsMessage = "Thanks for registering with Quick Dials.
				%0D%0ALogin %26 Update your profile to get more leads to grow your business.
				%0D%0A%0D%0ABusiness Name:" . $client->business_name . "
				%0D%0AURL:www.quickdials.com
				%0D%0AUID:" . $client->username . "
				%0D%0APassword:" . $pass . "
				%0D%0A--
				%0D%0ARegards
				%0D%0AQuickDials Team";

				sendSMS($client->mobile, $smsMessage);
				$this->success_msg .= 'Business registered successfully!';
				$request->session()->flash('success_msg', $this->success_msg);

				return redirect("/business/dashboard");
			} else {
				$this->danger_msg .= 'Business not registered!';
				$request->session()->flash('danger_msg', $this->danger_msg);
				return redirect("/business-owners");
			}
		}

	}


	/**
	 * Send client registration mail to client containing user name password.
	 *
	 * @param  object  $client
	 */
	public function sendUandP($client, $usr, $pass)
	{
		Mail::send('emails.register', ['client' => $client, 'usr' => $usr, 'pass' => $pass], function ($m) use ($client) {
			$m->from('otp@quickdials.com', 'quickdials');
			$m->to($client->email, $client->first_name . " " . $client->last_name)->subject('quickdials Login Credentials')->cc('clients@quickdials.com');
		});
	}



	/**
	 * Return Paginated Assigned Keywords
	 *
	 * @param $request - Request class instance
	 * @param $id - ClientID
	 * @return JSON object containing payload
	 */
	public function getAssignedZonesPagination(Request $request)
	{
		if ($request->ajax()) {
			$clientID = auth()->guard('clients')->user()->id;
			$leads = DB::table('assigned_zones')
				->join('zones', 'assigned_zones.zone_id', '=', 'zones.id')
				->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
				->select('assigned_zones.*', 'citylists.city', 'zones.zone', 'assigned_zones.id as assign_id')
				->orderBy('assigned_zones.id', 'desc')
				->where('assigned_zones.client_id', $clientID)
				->paginate($request->input('length'));

			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();

			foreach ($leads as $lead) {

				$action = '<a href="javascript:businessController.assignZoneDelete(' . $lead->id . ')" title="Delete" class="btn btn-danger"><i class="bi bi-trash" aria-hidden="true"></i></a>';

				if (!empty($lead->zone)) {
					$zonename = $lead->zone;
				} else {
					$zonename = "";

				}
				$data[] = [
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function assignZoneDelete(Request $request, $id)
	{
		$assignedZone = AssignedZone::findOrFail($id);
		if ($assignedZone->delete()) {
			$status = 1;
			$msg = "Assigned Zone Successfully!";
		} else {
			$status = 0;
			$msg = "Assigned Zone could not be Deleted!";
		}
		return response()->json(['status' => $status, 'msg' => $msg], 200);
	}




	public function getAjaxCities(Request $request)
	{

		$sid = $request->input('sid');
		$cid = $request->input('cid');
		$citys = DB::table('citylists')->where('state', $sid)->get();

		if ($citys) {
			echo '<option value="">Select City</option>';
			foreach ($citys as $city) {
				$selected = ($cid == $city->city) ? "selected" : '';

				echo '<option value="' . $city->city . '" ' . $selected . ' >' . $city->city . '</option>';

			}
		} else {
			echo '<option value="">No record found</option>';
		}
	}

	public function getAjaxZone(Request $request)
	{

		$cid = $request->input('city');
		$zid = $request->input('zone');
		$zones = DB::table('zones')->where('city_id', $cid)->get();

		if ($zones) {
			echo '<option value="">Select zone</option>';
			foreach ($zones as $zone) {
				$selected = ($zid == $zone->zone) ? "selected" : '';

				echo '<option value="' . $zone->id . '" ' . $selected . ' >' . $zone->zone . '</option>';

			}
			echo '<option value="Other">Other</option>';
		} else {
			echo '<option value="">No record found</option>';
		}


	}

	public function help(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);


		return view('business.help', ['client' => $client]);
	}

	public function buyPackage(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('business.buyPackage', ['search' => $search, 'client' => $client]);
	}

	/**
	 * Export assigned leads.
	 */
	public function getLeadsExcel(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;

		$assignedKWDS = DB::table('leads')
			->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->join('cities', 'leads.city_id', '=', 'cities.id')
			->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'cities.city')
			->orderBy('leads.created_at', 'desc')
			->where('assigned_leads.client_id', $clientID)
			->get();

		$arr = [];
		foreach ($assignedKWDS as $assKWDS) {
			$arr[] = [
				'Name' => $assKWDS->name,
				'Mobile' => $assKWDS->mobile,
				'Email' => $assKWDS->email,
				'Course' => $assKWDS->kw_text,
				'City' => $assKWDS->city,
				'Date' => date_format(date_create($assKWDS->created_at), 'd M, Y H:i:s'),
			];
		}
		$excel = \App::make('excel');
		Excel::create('assigned_leads', function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('xls');
	}


	/**
	 * Handling client remark
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function discussion(Request $request)
	{
		if ($request->input('discussion_form_submit') == 'Submit') {
			$admin_id = $request->input('admin-id');
			$client_id = $request->input('client-id');
			$discussion = $request->input('clientremark');
			$add_data = array(
				'client_id' => $client_id,
				'admin_id' => $admin_id,
				'name' => auth()->guard('clients')->user()->business_name,
				'discussion' => $discussion,
			);
			$add = DB::table('client_discussion')->insert($add_data);
			if ($add) {

				$resulsu = "Discussion Information Successfully";
				return response()->json(['status' => 1, 'result' => $resulsu]);
			} else {

				return response()->json(['status' => 0, 'result' => 'discussion Information not assigned']);
			}

		}

	}
}
