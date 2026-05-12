<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Client\Client;
use Validator;
use DB;
use Excel;
use App\Models\Lead;
use Carbon\Carbon;
use App\Models\LeadFollowUp;
use App\Models\Status;
use App\Models\AssignedLead;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
class EnquiryController extends Controller
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
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function followUp(Request $request, $id)
	{
		if ($request->ajax()) {

			$clientID = auth()->guard('clients')->user()->id;
			$lead = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
				->orderBy('assigned_leads.created_at', 'desc')
				->where('assigned_leads.client_id', $clientID)->where('leads.id', $id)->first();

			$leadLastFollowUp = DB::table('lead_follow_ups as lead_follow_ups')
				->where('lead_follow_ups.lead_id', '=', $id)
				->where('lead_follow_ups.client_id', '=', $clientID)
				->select('lead_follow_ups.*')
				->orderBy('lead_follow_ups.id', 'desc')
				->first();

			$statuses = DB::table('status')->where('lead_follow_up', '1')->get();

			$statusHtml = '';
			$disabled = '';
			$dateValue = '';


			if (!empty($statuses)) {
				foreach ($statuses as $status) {
					if (strcasecmp($status->name, 'new lead')) {
						$selected = '';
						if (!empty($leadLastFollowUp)) {
							if ($leadLastFollowUp->status == $status->id) {
								$selected = 'selected';
								if (!$status->show_exp_date) {
									$disabled = 'disabled';
									if ($leadLastFollowUp->expected_date_time != NULL) {
										$dateValue = date_format(date_create($leadLastFollowUp->expected_date_time), 'd-F-Y g:i A');
									}
								}
							}
						} else {
							if (1 == $status->id) {
								$selected = 'selected';
								if (!$status->show_exp_date) {
									$disabled = 'disabled';
									if ($leadLastFollowUp->expected_date_time != NULL) {
										$dateValue = date_format(date_create($leadLastFollowUp->expected_date_time), 'd-F-Y g:i A');
									}
								}
							}

						}
						$statusHtml .= '<option data-value="' . $status->show_exp_date . '" value="' . $status->id . '" ' . $selected . '>' . $status->name . '</option>';
					}
				}
			}

			$html = '<div class="row">
						<div class="x_content" style="padding:0">';
			$number = $lead->mobile;
			$html .= '<form class="form-label-left" method="post" onsubmit="return enquiryController.storeFollowUp(' . $id . ',this)">
				 
					 
				    <div class="row">
                        <div class="col-md-4" style="display:flex;">
                        <label for=" " class="col-md-3 col-lg-3 col-form-label">Name :</label>
                        
                        <p name="name" type="text" class="form-control-static" > ' . $lead->name . '</p>
                        </div>
                        	
                        <div class="col-md-4" style="display:flex;">
                        <label for="" class="col-md-3 col-lg-3 col-form-label">Email :</label>
                         	 <p name="email" type="text" class="form-control-static" > ' . $lead->email . '</p>
                        </div>
                        
                         <div class="col-md-4" style="display:flex;">
                         <label for=" " class="col-md-3 col-lg-3 col-form-label">Mobile :</label>
                         <p name="mobile" type="tel" class="form-control-static" > ' . $lead->mobile . '</p>
                        </div>
                        
                    </div>
				 					 
				     <div class="row">
                           <div class="col-md-4" style="display:flex;">
                         <label for="" class="col-md-3 col-lg-3 col-form-label">City :</label>
                         	 <p name="city name" type="text" class="form-control-static" > ' . $lead->city_name . '</p>
                        </div>
                       
                        <div class="col-md-4" style="display:flex;">
                         <label for="" class="col-md-3 col-lg-4 col-form-label">Keyword :</label>
                         	 <p name="keyword" type="text" class="form-control-static" > ' . $lead->kw_text . '</p>
                        </div>
                        
                         <div class="col-md-4" style="display:flex;">
                         <label for="" class="col-md-3 col-lg-3 col-form-label">Date :</label>
                         	 <p name="date" type="text" class="form-control-static" > ' . date('d M Y', strtotime($lead->created)) . '</p>
                        </div>                        
                    </div>
								 
                <div class="row mb-3">
                
                <div class="col-md-4">
                <label for="" class="">Status :</label>
                <select class="select2_single form-control" name="status" tabindex="-1">
                <option value="">-- Select status --</option> 
                ' . $statusHtml . '
                </select>
                
                </div>
                
                <div class="col-md-4">
                <label for="expected_date_time">Expected Date &amp; Time <span class="required">*</span></label>
                <input type="text" id="expected_date_time" name="expected_date_time" class="form-control" value="' . $dateValue . '" placeholder="Expected Date &amp; Time" ' . $disabled . ' autocomplete="off">
                </div>
                
                <div class="col-md-4">
                <label for="remark">Counsellor Remark <span class="required">*</span></label>
                <textarea name="remark" rows="1" class="form-control col-md-7 col-xs-12"></textarea>
                </div>
                </div>
                <div class="form-group" style="float:right;">
                <div class="col-md-11" style="float:right;">
                	<label style="visibility:hidden">Submit</label>
                	<button type="submit" class="btn btn-success btn-block" name="submit" value="Submit">Submit</button>
                </div>
                </div>
							</form>';

			$html .= '</div>
					</div> 
					<p style="margin-top:10px;margin-bottom:3px;"><strong>Follow Up Status</strong>  <select onchange="javascript:enquiryController.getAllFollowUps()" class="follow-up-count"><option value="5">Last 5</option><option value="all">All</option></select></p>
					<div class="" style="overflow-x: none;">
						<table id="datatable-enquiry-followups" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Date</th>
									<th>Counsellor Remark</th>
									<th>Status</th>
									<th>Expected Date</th>
								</tr>
							</thead>
						</table>
					</div>';

			return response()->json(['status' => 1, 'html' => $html], 200);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function storeFollowUp(Request $request, $id)
	{
		if ($request->ajax()) {
			$validator = Validator::make($request->all(), [

				'status' => 'required',
				'remark' => 'required',

			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			// check now expected date and time if status is not - not interested/location issue
			$statusModel = Status::find($request->input('status'));
			//if($statusModel->name!='Not Interested' && $statusModel->name!='Location Issue'){
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
			if (!empty($lead)) {
				$leadFollowUp = new LeadFollowUp;
				$status = Status::findorFail($request->input('status'));
				if (!strcasecmp($status->name, 'npup')) {
					$npupCount = LeadFollowUp::where('lead_id', $id)->where('status', $status->id)->count();
					if ($npupCount >= 15) {
						$status = Status::where('name', 'LIKE', 'Not Interested')->first();
						$leadFollowUp->status = $status->id;
					} else {
						$leadFollowUp->status = $request->input('status');
					}
				} else {
					$leadFollowUp->status = $request->input('status');
				}


				$leadFollowUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$leadFollowUp->lead_id = $id;
				$leadFollowUp->client_id = auth()->guard('clients')->user()->id;
				$leadFollowUp->expected_date_time = NULL;
				if ($request->input('expected_date_time') != '') {
					$leadFollowUp->expected_date_time = date('Y-m-d H:i:s', strtotime($request->input('expected_date_time')));
				}
				if ($leadFollowUp->save()) {
					return response()->json(['status' => 1], 200);
				}
			} else {

				return response()->json(['status' => 0, '' => "Enquiry not found"], 200);
			}
		}
	}




	public function pauseLead(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;

		$client = Client::find($clientID);

		if (!$client) {
			return response()->json(['status' => false, 'message' => 'Client not found'], 404);
		}

		if ($request->pauseLead == 'true') {

			$client->pauseLead = 1;
		} else {

			$client->pauseLead = 0;
		}
		if ($client->save()) {
			return response()->json(['status' => true, 'message' => 'Pause lead updated']);
		} else {
			return response()->json(['status' => false, 'message' => 'Pause lead updated']);

		}



	}


	public function scrapLead(Request $request)
	{

		//echo $request->clientId;echo "<pre>";print_r($_POST);die;

		$assignedLead = AssignedLead::find($request->leadId);
		$coinsLeads = DB::table('assigned_leads')->where('lead_id', $assignedLead->lead_id)->where('scrapPay', '0')->get();
		$scrapStatusLeads = DB::table('assigned_leads')->where('lead_id', $assignedLead->lead_id)->where('scrapLead', '1')->get()->count();

		if (!empty($assignedLead)) {
			if ($coinsLeads->count() == $scrapStatusLeads + 1) {
				foreach ($coinsLeads as $coinsLead) {
					$client = Client::find($coinsLead->client_id);
					$client->coins_amt = $client->coins_amt + $coinsLead->coins;
					$client->save();
					$assignedclnLead = AssignedLead::find($coinsLead->id);
					$assignedclnLead->scrapPay = '1';
					$assignedclnLead->save();
				}
			}

			$assignedLead->scrapLead = '1';
			$assignedLead->scrapValue = $request->scrapValue;
			if ($assignedLead->save()) {
				$status = true;
				$msg = "Scrap update successfully";

			} else {
				$status = false;
				$msg = "Scrap update successfully";
			}

		}

		return response()->json(['status' => $status, 'msg' => $msg]);

	}

	public function readLead(Request $request)
	{

		$assignedLead = AssignedLead::find($request->assingId);

		if (!$assignedLead) {
			return response()->json(['status' => false, 'message' => 'assignedLead not found'], 404);
		}

		$assignedLead->readLead = '1';
		if ($assignedLead->save()) {
			return response()->json(['status' => true, 'message' => 'Pause lead updated']);
		} else {
			return response()->json(['status' => false, 'message' => 'Pause lead updated']);
		}
	}

	public function favoritleads(Request $request)
	{

		$assignedLead = AssignedLead::find($request->assingId);

		if (!$assignedLead) {
			return response()->json(['status' => false, 'message' => 'assignedLead not found'], 404);
		}

		$assignedLead->favorite_lead = '1';
		if ($assignedLead->save()) {
			return response()->json(['status' => true, 'message' => 'Pause lead updated']);
		} else {
			return response()->json(['status' => false, 'message' => 'Pause lead updated']);
		}
	}
	/**
	 * Return paginated resources.
	 *
	 * @return JSON Payload.
	 */
	public function getLeads(Request $request)
	{
		if ($request->ajax()) {

			$clientID = auth()->guard('clients')->user()->id;


			$leads = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')

				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
				->orderBy('assigned_leads.created_at', 'desc')

				->where('assigned_leads.client_id', $clientID)
				->paginate($request->input('length'));

			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			foreach ($leads as $lead) {
				$data[] = [
					$lead->name,
					$lead->mobile,
					$lead->email,
					$lead->kw_text,
					$lead->city_name,
					date_format(date_create($lead->created), 'd-m-Y H:i:s')
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);

		}
	}

	public function enquiry(Request $request)
	{
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		$clientID = auth()->guard('clients')->user()->id;
		$statues = Status::where('lead_filter', '1')->get();
		$services = DB::table('assigned_kwds')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->select('keyword.id', 'keyword.keyword','keyword.slug')
			->orderBy('keyword.keyword', 'asc')
			->where('assigned_kwds.client_id', $clientID)
			->get();
		return view('business.leadlist', [
			'search' => $search,
			'statues' => $statues,
			'services' => $services
		]);
	}

	public function newEnquiry(Request $request)
	{
		$client = auth()->guard('clients')->user();

		if (!$client) {
			return redirect()->route('login');
		}

		$clientID = $client->id;

		$clientDetails = DB::table('clients')
			->where('id', $clientID)
			->first();

		$rating = DB::table('comments')
			->where('comment_client_ID', $client->id)
			->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
			->first();

		$avgRating = ($rating->total > 0)
			? round($rating->sum / $rating->total, 1)
			: 0;

		$ratingCount = $rating->total ?? 0;

		$leads = DB::table('leads')
			->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->where('assigned_leads.client_id', $client->id)
			->orderBy('assigned_leads.created_at', 'desc')
			->where('assigned_leads.readLead', '0')
			->select(
				'leads.id as lead_id',
				'leads.name',
				'leads.mobile',
				'leads.email',
				'leads.kw_text',
				'leads.zone',
				'leads.city_name',
				'leads.plan',
				'leads.address',
				'leads.age',
				'leads.experience',
				'leads.remark',
				'assigned_leads.created_at as created',
				'assigned_leads.coins',
				'assigned_leads.id as assignId',
				'assigned_leads.client_id as clientId',
				'assigned_leads.readLead',
				'assigned_leads.scrapLead',
				'assigned_leads.scrapPay',
				'assigned_leads.scrapValue',
				'assigned_leads.favorite_lead',
			)
			->paginate(30);

		$businessName = $clientDetails->business_name ?? 'Our Company';
		$address = $clientDetails->address ?? '';
		$map = $clientDetails->business_map ?? '';
		$profileUrl = url('business-details/' . ($clientDetails->business_slug ?? ''));

		// Transform Data (Fast Way)
		$leads->getCollection()->transform(function ($lead) use ($businessName, $address, $map, $profileUrl, $avgRating, $ratingCount) {

			$keyword = $lead->kw_text ?? 'your enquiry';
			$location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));


			// 🔹 Share Lead Details



			$lead->share_address = "Greetings from {$businessName},\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information"
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. "{$profileUrl}";

			$lead->share_service = "Greetings from {$businessName},\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information of the services offered by our business please refer "
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. ", Or {$profileUrl}";
			$lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information about the services offered by our business"
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. ". Or visit our profile: {$profileUrl}";


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

			$lead->share_lead =
				"Name: {$lead->name}\n" .
				"Mobile: {$lead->mobile}\n" .
				"Email: {$lead->email}\n" .
				"Service: {$keyword}\n" .
				"Location: {$location}\n" .
				"remark: {$remark}";

			$lead->remarks = $remark;
			return $lead;
		});



		return view('business.new-enquiry', ['leads' => $leads]);
	}


	public function newEnquiry_old(Request $request)
	{
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}

		$clientID = auth()->guard('clients')->user()->id;


		$leads = DB::table('leads')
			->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->leftjoin('citylists', 'leads.city_id', '=', 'citylists.id')
			->leftjoin('areas', 'leads.area_id', '=', 'areas.id')
			->leftjoin('zones', 'leads.zone_id', '=', 'zones.id')
			->select('leads.*', 'assigned_leads.*', 'assigned_leads.client_id as clientId', 'assigned_leads.lead_id', 'assigned_leads.id as assignId', 'assigned_leads.created_at as created', 'areas.area', 'zones.zone')

			->orderBy('assigned_leads.created_at', 'desc')
			// ->where('assigned_leads.readLead', '0')
			->where('assigned_leads.client_id', $clientID)->limit('20')->get();


		$client = Client::select('id', 'address', 'business_name', 'business_slug')->where('id', $clientID)->first();

		if ($client->address) {
			$address = urlencode($client->address);
			$url = "https://nominatim.openstreetmap.org/search?q={$address}&format=json&limit=1";

			$options = [
				"http" => [
					"header" => "User-Agent: MyWebsite/1.0 (contact@mywebsite.com)\r\n"
				]
			];

			$context = stream_context_create($options);
			$response = file_get_contents($url, false, $context);
			$geodata = json_decode($response, true);

			if (!empty($geodata[0])) {
				$latitude = $geodata[0]['lat'];
				$longitude = $geodata[0]['lon'];
				$map = 'https://www.google.com/maps?q=' . $latitude . ',' . $longitude;
			}


		} else {
			$map = "";
		}


		$rating = DB::table('comments')
			->where('comment_client_ID', $clientID)
			->selectRaw('
				COUNT(*) as comment_count,
				COALESCE(SUM(rating),0) as total_rating
			')
			->first();
		if (!empty($rating)) {
			$avgRating = ($rating->comment_count > 0)
				? round($rating->total_rating / $rating->comment_count, 1)
				: 0;
			$ratingCount = $rating->comment_count;
		} else {
			$avgRating = 0;
			$ratingCount = 0;
		}

		//  dd($leads);
		if (!empty($leads)) {

			$leads_list = [];

			$businessName = $client->business_name ?? 'our company';
			$addressText = $client->address ?? '';
			$mapText = !empty($client->business_map) ? '\n Directions: ' . $client->business_map : '';
			$profile_url = 'https://www.quickdials.com/business-details/' . $client->business_slug;

			foreach ($leads as $val) {

				$keyword = $val->kw_text ?? 'your enquiry';

				$coins = !empty($val->scrapLead)
					? ['color' => 'green', 'coin' => $val->coins]
					: (!empty($val->coins) ? ['color' => 'red', 'coin' => $val->coins] : null);

				$created = \Carbon\Carbon::parse($val->created)->diffForHumans() . ' ago';
 
				$cityName = trim(($val->city_name ?? '') . (!empty($val->zone) ? ', ' . $val->zone : ''));

				$frmcheckText = !empty($val->frmcheck) && is_array($val->frmcheck)
					? implode(', ', $val->frmcheck)
					: '';

				$remarkParts = array_filter([
					$val->kw_text ? "Interested in {$val->kw_text}" : null,
					$frmcheckText ? "Mode of {$frmcheckText}" : null,
					$val->zone ? "Location {$val->zone}" : null,
					$val->plan ? "Plan {$val->plan}" : null,
					$val->age ? "Age {$val->age}" : null,
					$val->experience ? "Experience {$val->experience}" : null,
				]);

				$remark = trim(implode(' • ', $remarkParts) . ' ' . ($val->remark ?? ''));

				$user_share = [
					'address_share' => "Greetings from {$businessName},\n"
						. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
						. "For more information"
						. ($addressText ? ", you can visit us at {$addressText}" : "")
						. "{$mapText}",

					'for_service' => "Greetings from {$businessName},\n"
						. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
						. "For more information of the services offered by our business"
						. ($addressText ? ", you can visit us at {$addressText}" : "")
						. ", Or {$profile_url}",

					'for_review' => "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
						. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
						. "For more information about the services offered by our business"
						. ($addressText ? ", you can visit us at {$addressText}" : "")
						. ". Or visit our profile: {$profile_url}",

					'share_lead' => 'Name: ' . trim($val->name ?? '') .
						', Mobile: ' . trim($val->mobile ?? '') .
						', Email: ' . trim($val->email ?? '') .
						', Service: ' . trim($val->kw_text ?? '') .
						', Location: ' . $cityName,
				];

				$leads_list[] = [
					'lead_id' => $val->lead_id ?? null,
					'assignId' => $val->assignId ?? null,
					'favorite_lead' => $val->favorite_lead ?? 0,
					'readLead' => $val->readLead ?? 0,
					'scrapLead' => $val->scrapLead ?? 0,
					'scrapPay' => $val->scrapPay ?? 0,
					'scrapValue' => $val->scrapValue ?? 0,
					'primeLead' => $val->primeLead ?? 0,
					'name' => trim($val->name ?? '') ?: null,
					'mobile' => trim($val->mobile ?? '') ?: null,
					'email' => trim($val->email ?? '') ?: null,
					'remark' => $remark ?: null,
					'cityName' => $cityName ?: null,
					'kw_text' => trim($val->kw_text ?? '') ?: null,
					'client_id' => $val->client_id ?? null,
					'createdDate' => $created,
					'coins' => $coins,
					'user_share' => $user_share,
				];

			}
			//  dd($leads_list);	

		}

		return view('business.new-enquiry', ['leads' => $leads_list]);
	}

	public function myLead(Request $request)
	{



		$client = auth()->guard('clients')->user();

		if (!$client) {
			return redirect()->route('login');
		}

		$clientID = $client->id;

		$clientDetails = DB::table('clients')
			->where('id', $clientID)
			->first();

		$rating = DB::table('comments')
			->where('comment_client_ID', $client->id)
			->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
			->first();

		$avgRating = ($rating->total > 0)
			? round($rating->sum / $rating->total, 1)
			: 0;

		$ratingCount = $rating->total ?? 0;

		$leads = DB::table('leads')
			->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->where('assigned_leads.client_id', $client->id)
			->orderBy('assigned_leads.created_at', 'desc')
			->where('assigned_leads.favorite_lead', '!=', '1')
			->select(
				'leads.id as lead_id',
				'leads.name',
				'leads.mobile',
				'leads.email',
				'leads.kw_text',
				'leads.zone',
				'leads.city_name',
				'leads.plan',
				'leads.address',
				'leads.age',
				'leads.experience',
				'leads.remark',
				'assigned_leads.created_at as created',
				'assigned_leads.coins',
				'assigned_leads.id as assignId',
				'assigned_leads.client_id as clientId',
				'assigned_leads.readLead',
				'assigned_leads.scrapLead',
				'assigned_leads.scrapPay',
				'assigned_leads.scrapValue',
				'assigned_leads.favorite_lead',
			)
			->paginate(30);

		$businessName = $clientDetails->business_name ?? 'Our Company';
		$address = $clientDetails->address ?? '';
		$map = $clientDetails->business_map ?? '';
		$profileUrl = url('business-details/' . ($clientDetails->business_slug ?? ''));

		// Transform Data (Fast Way)
		$leads->getCollection()->transform(function ($lead) use ($businessName, $address, $map, $profileUrl, $avgRating, $ratingCount) {

			$keyword = $lead->kw_text ?? 'your enquiry';
			$location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));


			// 🔹 Share Lead Details



			$lead->share_address = "Greetings from {$businessName},\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information"
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. "{$profileUrl}";

			$lead->share_service = "Greetings from {$businessName},\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information of the services offered by our business please refer "
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. ", Or {$profileUrl}";
			$lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information about the services offered by our business"
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. ". Or visit our profile: {$profileUrl}";


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

			$lead->share_lead =
				"Name: {$lead->name}\n" .
				"Mobile: {$lead->mobile}\n" .
				"Email: {$lead->email}\n" .
				"Service: {$keyword}\n" .
				"Location: {$location}\n" .
				"remark: {$remark}";

			$lead->remarks = $remark;
			return $lead;
		});





		return view('business.myLead', ['leads' => $leads]);
	}

	public function favoriteEnquiry(Request $request)
	{


		$client = auth()->guard('clients')->user();

		if (!$client) {
			return redirect()->route('login');
		}

		$clientID = $client->id;

		$clientDetails = DB::table('clients')
			->where('id', $clientID)
			->first();

		$rating = DB::table('comments')
			->where('comment_client_ID', $client->id)
			->selectRaw('COUNT(*) as total, COALESCE(SUM(rating),0) as sum')
			->first();

		$avgRating = ($rating->total > 0)
			? round($rating->sum / $rating->total, 1)
			: 0;

		$ratingCount = $rating->total ?? 0;

		$leads = DB::table('leads')
			->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->where('assigned_leads.client_id', $client->id)
			->orderBy('assigned_leads.created_at', 'desc')
			->where('assigned_leads.favorite_lead', '1')
			->select(
				'leads.id as lead_id',
				'leads.name',
				'leads.mobile',
				'leads.email',
				'leads.kw_text',
				'leads.zone',
				'leads.city_name',
				'leads.plan',
				'leads.address',
				'leads.age',
				'leads.experience',
				'leads.remark',
				'assigned_leads.created_at as created',
				'assigned_leads.coins',
				'assigned_leads.id as assignId',
				'assigned_leads.client_id as clientId',
				'assigned_leads.readLead',
				'assigned_leads.scrapLead',
				'assigned_leads.scrapPay',
				'assigned_leads.scrapValue',
				'assigned_leads.favorite_lead',
			)
			->paginate(30);

		$businessName = $clientDetails->business_name ?? 'Our Company';
		$address = $clientDetails->address ?? '';
		$map = $clientDetails->business_map ?? '';
		$profileUrl = url('business-details/' . ($clientDetails->business_slug ?? ''));

		// Transform Data (Fast Way)
		$leads->getCollection()->transform(function ($lead) use ($businessName, $address, $map, $profileUrl, $avgRating, $ratingCount) {

			$keyword = $lead->kw_text ?? 'your enquiry';
			$location = trim(($lead->city_name ?? '') . (!empty($lead->zone) ? ', ' . $lead->zone : ''));


			// 🔹 Share Lead Details



			$lead->share_address = "Greetings from {$businessName},\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information"
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. "{$profileUrl}";

			$lead->share_service = "Greetings from {$businessName},\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information of the services offered by our business please refer "
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. ", Or {$profileUrl}";
			$lead->share_review = "Greetings from {$businessName}, Rated {$avgRating} Rating out of {$ratingCount} Votes.\n"
				. "We’re following up on your enquiry made on Quickdials for {$keyword}.\n"
				. "For more information about the services offered by our business"
				. (!empty($addressText) ? ", you can visit us at {$addressText}" : "")
				. ". Or visit our profile: {$profileUrl}";


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

			$lead->share_lead =
				"Name: {$lead->name}\n" .
				"Mobile: {$lead->mobile}\n" .
				"Email: {$lead->email}\n" .
				"Service: {$keyword}\n" .
				"Location: {$location}\n" .
				"remark: {$remark}";

			$lead->remarks = $remark;
			return $lead;
		});



		return view('business.favorite-enquiry', ['leads' => $leads]);
	}


	/**
	 * Return paginated resources.
	 *
	 * @return JSON Payload.
	 */

	public function getPaginatedLeads(Request $request)
	{
		if ($request->ajax()) {


			$clientID = auth()->guard('clients')->user()->id;
			$leads = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
				->orderBy('assigned_leads.created_at', 'desc')
				->where('assigned_leads.client_id', $clientID);


			// generating raw query to make join
			$rawQuery = "SELECT m1.*,m3.name as status_name FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) INNER JOIN status m3 ON m1.status = m3.id WHERE m2.id IS NULL";



			if ($request->input('search.status') != '') {
				$statuses = $request->input('search.status');
				$i = 0;
				foreach ($statuses as $status) {
					if (!$i) {
						$rawQuery .= " AND (m1.status=" . $status;
						$i = 1;
					} else {
						$rawQuery .= " || m1.status=" . $status;
					}
				}
				$rawQuery .= ")";

			}

			if ($request->input('search.expdf') != '') {
				$rawQuery .= " AND DATE(m1.expected_date_time)>='" . date('Y-m-d', strtotime($request->input('search.expdf'))) . "'";
			}

			if ($request->input('search.expdt') != '') {
				$rawQuery .= " AND DATE(m1.expected_date_time)<='" . date('Y-m-d', strtotime($request->input('search.expdt'))) . "'";
			}

			$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
			// generating raw query to make join

			$leads = $leads->select('leads.*', DB::raw('`fu`.`status_name`'), DB::raw('`fu`.`status`'), DB::raw('`fu`.`expected_date_time`'), DB::raw('`fu`.`remark`'), DB::raw('`fu`.`created_at` as follow_up_date'));
			$leads = $leads->orderBy('leads.id', 'desc');
			$leads = $leads->where('assigned_leads.client_id', $clientID);



			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.email', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.kw_text', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.city_name', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}

			if ($request->input('search.leaddf') != '') {
				$leads = $leads->whereDate('leads.created_at', '>=', date_format(date_create($request->input('search.leaddf')), 'Y-m-d'));
			}
			if ($request->input('search.leaddt') != '') {
				$leads = $leads->whereDate('leads.created_at', '<=', date_format(date_create($request->input('search.leaddt')), 'Y-m-d'));
			}
			if ($request->input('search.service') != '') {
				$courses = $request->input('search.service');
				foreach ($courses as $course) {
					$courseList[] = $course;
				}
				$leads = $leads->whereIn('leads.kw_id', $courseList);
			}

			$leads = $leads->paginate($request->input('length'));


			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			$returnLeads['recordCollection'] = [];

			foreach ($leads as $lead) {

				$action = '';
				$separator = '';
				$action .= $separator . '<a href="javascript:enquiryController.getfollowUps(' . $lead->id . ')" title="followUp"><i class="bi bi-eye" aria-hidden="true"></i></a>';
				$separator = ' | ';





				$npupMark = '';
				$status = Status::where('name', 'LIKE', 'NPUP')->first();
				if ($status) {
					$npupCount = LeadFollowUp::where('lead_id', $lead->id)->where('status', $status->id)->count();
					if ($npupCount >= 9) {
						$npupMark .= ' <span class="light-red">*</span>';
					}
				}
				$data[] = [

					$lead->name,
					$lead->mobile,
					$lead->kw_text,
					$lead->city_name,

					$lead->status_name . $npupMark,
					(new Carbon($lead->created_at))->format('d-m-Y h:i:s'),

					($lead->expected_date_time == NULL) ? "" : (new Carbon($lead->expected_date_time))->format('d-m-Y h:i A'),

					$action
				];
				$returnLeads['recordCollection'][] = $lead->id;

			}

			$returnLeads['data'] = $data;
			return response()->json($returnLeads);

		}
	}

	public function getEnquiry(Request $request)
	{
		if ($request->ajax()) {

			$clientID = auth()->guard('clients')->user()->id;
			$leads = DB::table('leads')
				->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
				->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created')
				->orderBy('assigned_leads.created_at', 'desc')
				->where('assigned_leads.client_id', $clientID);
			if ($request->input('search.leaddf') != '') {
				$leads = $leads->whereDate('assigned_leads.created_at', '>=', date_format(date_create($request->input('search.leaddf')), 'Y-m-d'));
			}
			if ($request->input('search.leaddt') != '') {
				$leads = $leads->whereDate('assigned_leads.created_at', '<=', date_format(date_create($request->input('search.leaddt')), 'Y-m-d'));
			}



			$leads = $leads->paginate($request->input('length'));
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			$returnLeads['recordCollection'] = [];
			foreach ($leads as $lead) {

				$action = '';
				$separator = '';

				$action .= $separator . '<a href="javascript:enquiryController.getfollowUps(' . $lead->id . ')" title="followUp"><i class="bi bi-eye" aria-hidden="true"></i></a>';
				$separator = ' | ';
				$data[] = [
					$lead->name,
					$lead->mobile,
					$lead->email,
					$lead->kw_text,
					$lead->city_name,
					date_format(date_create($lead->created), 'd M, Y H:i'),
					$action
				];
				$returnLeads['recordCollection'][] = $lead->id;
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
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
				->where('lead_follow_ups.client_id', '=', auth()->guard('clients')->user()->id)
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
				$data[] = [
					(date('d-m-y h:i:s', strtotime($lead->created_at))),
					$lead->remark,
					$lead->status_name,
					(isset($lead->expected_date_time) ? date('d-m-y h:i A', strtotime($lead->expected_date_time)) : "")
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
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



	public function manageEnquiry(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$leads = DB::table('leads')
			->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->leftjoin('citylists', 'leads.city_id', '=', 'citylists.id')
			->leftjoin('areas', 'leads.area_id', '=', 'areas.id')
			->leftjoin('zones', 'leads.zone_id', '=', 'zones.id')
			->select('leads.*', 'assigned_leads.*', 'assigned_leads.client_id as clientId', 'assigned_leads.lead_id', 'assigned_leads.id as assignId', 'assigned_leads.created_at as created', 'areas.area', 'zones.zone')

			->orderBy('assigned_leads.created_at', 'desc')
			->where('assigned_leads.client_id', $clientID)->limit('20')->get();

		return view('business.manage-enquiry', ['leads' => $leads]);
	}

	public function leadFollowUp(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;

		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}

		$statues = Status::where('lead_filter', '1')->get();
		$services = DB::table('assigned_kwds')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->select('keyword.id', 'keyword.keyword','keyword.slug')
			->orderBy('keyword.keyword', 'asc')
			->where('assigned_kwds.client_id', $clientID)
			->get();



		return view('business.lead-dashboard', ['search' => $search, 'statues' => $statues, 'services' => $services]);
	}


	/**
	 * Return paginated resources.
	 *
	 * @return JSON Payload.
	 */


	public function getLeadFollow(Request $request)
	{
		if ($request->ajax()) {

			$user_id = $request->user()->id;


			$data = [];


			$leads = DB::table('leads as leads');
			$leads = $leads->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id');

			// generating raw query to make join
			$rawQuery = "SELECT m1.*,m3.name as status_name FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) INNER JOIN status m3 ON m1.status = m3.id WHERE m2.id IS NULL";

			if ($request->input('search.status') != '') {


				$statuses = $request->input('search.status');
				$i = 0;
				foreach ($statuses as $status) {
					if (!$i) {
						$rawQuery .= " AND (m1.status=" . $status;
						$i = 1;
					} else {
						$rawQuery .= " || m1.status=" . $status;
					}
				}
				$rawQuery .= ")";

			} else {

				$rawQuery .= " AND m1.status NOT IN (SELECT id FROM `status` WHERE `name` LIKE 'not interested' || `name` LIKE 'Not Connected' || `name` LIKE 'Other Joined' || `name` LIKE 'Joined' || `name` LIKE 'Invalid Number'   )";
			}

			if ($request->input('search.expdf') != '') {

				$rawQuery .= " AND DATE(m1.expected_date_time)>='" . date('Y-m-d', strtotime($request->input('search.expdf'))) . "'";
			}

			if ($request->input('search.expdt') != '') {

				$rawQuery .= " AND DATE(m1.expected_date_time)<='" . date('Y-m-d', strtotime($request->input('search.expdt'))) . "'";
			}

			if ($request->input('search.expdf') == '' && $request->input('search.expdt') == '') {


				$rawQuery .= " AND DATE(m1.expected_date_time)<='" . date('Y-m-d') . "'";
			}

			$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
			// generating raw query to make join

			$leads = $leads->select('leads.*', DB::raw('`fu`.`status_name`'), DB::raw('`fu`.`status`'), DB::raw('`fu`.`expected_date_time`'), DB::raw('`fu`.`remark`'));
			$leads = $leads->orderBy('leads.id', 'desc');
			$leads = $leads->where('assigned_leads.client_id', $user_id);
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			if ($request->input('search.service') != '') {
				$courses = $request->input('search.service');
				foreach ($courses as $course) {
					$courseList[] = $course;
				}
				$leads = $leads->whereIn('leads.kw_id', $courseList);
			}


			$leads = $leads->get();


			if ($leads) {
				//$data = [];
				foreach ($leads as $lead) {
					$data[] = [
						'target_id' => $lead->id,
						'expected_date_time' => ($lead->expected_date_time == NULL) ? "" : $lead->expected_date_time,
						'name' => $lead->name,
						'mobile' => $lead->mobile,
						'kw_text' => $lead->kw_text,
						'status_name' => $lead->status_name,
						'status' => $lead->status,
						'remark' => $lead->remark
					];
				}

			}



			usort($data, function ($a, $b) {
				$t1 = strtotime($a['expected_date_time']);
				$t2 = strtotime($b['expected_date_time']);
				//return $t1 - $t2; //ascending
				return $t2 - $t1; //descending
			});


			$currentPage = Paginator::resolveCurrentPage();
			$collection = new Collection($data);
			$perPage = $request->input('length');
			$currentPageSearchResults = $collection->slice($currentPage * $perPage - $perPage, $perPage)->all();
			$leads = new Paginator($currentPageSearchResults, count($collection), $perPage, $currentPage);

			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			$returnLeads['recordCollection'] = [];

			foreach ($leads->items() as $lead) {
				$action = '';
				$separator = '';




				$action .= $separator . '<a href="javascript:enquiryController.getfollowUps(' . $lead['target_id'] . ')" title="followUp"><i class="bi bi-eye" aria-hidden="true"></i></a>';

				$data[] = [


					($lead['expected_date_time'] == "") ? "" : (new Carbon($lead['expected_date_time']))->format('d-m-Y h:i A'),
					$lead['name'],
					$lead['mobile'],
					$lead['mobile'],
					$lead['kw_text'],

					$lead['status_name'],
					$action
				];

				$returnLeads['recordCollection'][] = $lead['target_id'];
			}

			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}


}
