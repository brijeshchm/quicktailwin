<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddLeadRequest;

use App\Http\Requests;
use Carbon\Carbon;
use App\Models\Lead;
use App\Models\PushLead;
use App\Models\Citieslists;
use App\Models\Keyword;
use App\Models\AssignedLead;
use App\Models\Client\Client;
use DB;
use Validator;
use App\Models\User;

class PushLeadController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->wantsJson()) {
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
			$leads = DB::table('leads');
			$leads = $leads->leftjoin('citylists as cities', 'leads.city_id', '=', 'cities.id');
			$leads = $leads->select('leads.*', 'cities.city');
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.email', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			if ($request->input('search.created_by') != '') {
				$leads = $leads->where('leads.created_by', '=', $request->input('search.created_by'));
			}
			/* if($request->input('search.city')!=''){
				$leads = $leads->where('leads.city_id','=',$request->input('search.city'));
			}
			if($request->input('search.course')!=''){
				$leads = $leads->where('leads.kw_text','LIKE',$request->input('search.course'));
			}
			if($request->input('search.datef')!=''){
				$leads = $leads->whereDate('leads.created_at','>=',date_format(date_create($request->input('search.datef')),'Y-m-d'));
			}
			if($request->input('search.datet')!=''){
				$leads = $leads->whereDate('leads.created_at','<=',date_format(date_create($request->input('search.datet')),'Y-m-d'));
			}
			if($request->input('search.lead_type')!=''){
				$leads = $leads->where('leads.b_end','LIKE',$request->input('search.lead_type'));
			} */
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
				$owner_name = $disabled = '';
				$btnClass = 'danger';
				$btnText = 'Push';
				if ($lead->pushed == 1) {
					$disabled = 'disabled';
					$btnClass = 'success';
					$btnText = 'Pushed';
				}
				$popover = "data-toggle='popover' data-trigger='hover' data-placement='left' data-content='$lead->remark'";
				if ($lead->created_by != null && isset($owner[$lead->created_by])) {
					$owner_name = $owner[$lead->created_by];
				}

				$data[] = [
					(new Carbon($lead->created_at))->addMinutes(330)->format('d-m-Y'),
					($lead->b_end) ? $lead->name . " <i aria-hidden=\"true\" style=\"color:red\" class=\"fa fa-fw fa-asterisk\"></i>" : $lead->name,
					($lead->b_end) ? "Internal" : "External",
					$lead->mobile,
					//$lead->email,
					$owner_name,


					$lead->area,
					$lead->kw_text,
					$lead->city,
					//date_format(date_create($lead->created_at),'d-m-Y H:i:s'),
					//(new Carbon($lead->created_at))->addMinutes(330)->format('d-m-Y h:i:s'),
					'<a href="javascript:pushLeadController.delete(' . $lead->id . ')" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></a>' .
					' | ' .
					'<a href="javascript:pushLeadController.pushLead(' . $lead->id . ')" data-push="' . $lead->id . '" title="' . $btnText . '" class="btn btn-' . $btnClass . ' btn-xs" ' . $disabled . '>' . $btnText . '</a>'
					. ' | ' .
					'<a href="javascript:pushLeadController.editPushLead(' . $lead->id . ')" title="Edit" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-pencil"></i></a>'
					. ' | ' .
					'<a title="Remark" href="#" ' . $popover . ' class="btn btn-default btn-xs"><i class="fa fa-comments fa-fw" aria-hidden="true"></i></a>'
				];

			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		} else {
			return view('admin.push_leads');
		}
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(AddLeadRequest $request)
	{
		//
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		$validator = Validator::make($request->all(), [
			'name' => 'required|unique:leads,name,NULL,id,mobile,' . $request->input('mobile'),
			'mobile' => 'required',
			'city_id' => 'required',
			'area_zone' => 'required',
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
		$city = Citieslists::where('id', $request->input('city_id'))->first();
		$lead = new Lead;

		$lead->city_id = $city->id;
		$lead->name = $request->input('name');
		$emailToTestYet5 = $request->input('email');
		if ($request->has('email') && preg_match("/@yet5\.com$/i", $emailToTestYet5)) {
			$lead->email = '';
		} else {
			$lead->email = $request->input('email');

			$lead->mobile = $request->input('mobile');

			$lead->created_by = $request->created_by;
			if ($request->has('b_end')) {
				$lead->b_end = 1;
				//$lead->area = $request->input('area');
				//$lead->zone_id = $request->input('area_zone');
				$areas = DB::table(DB::raw("(SELECT * FROM areas WHERE id={$request->input('area_zone')}) as aa"));
				$areas = $areas->join('zones', 'zones.id', '=', DB::raw('`aa`.`zone_id`'));
				$areas = $areas->select('aa.id', 'aa.area', 'aa.zone_id', 'zones.zone');
				$areas = $areas->first();
				$lead->area = $areas->zone . " " . "(" . $areas->area . ")";
				$lead->area_id = $areas->id;
				$lead->zone_id = $areas->zone_id;
			}

			$keyword = Keyword::where('keyword', 'LIKE', $request->input('kw_text'))
				->where('city_id', $city->id)->get();
			if (count($keyword) > 0) {
				$lead->kw_id = $keyword[0]->id;
				$lead->kw_text = $keyword[0]->keyword;
				$bucketIndex = $keyword[0]->bucket;
			} else {
				return response()->json(['status' => 1, 'msg' => 'Keyword not found'], 404);
			}


			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
			if ($lead->save()) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Push lead added successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Push lead not added !!"
					]
				], 200);
			}
		}

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{

		if (null == $id) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 500,
					"payload" => "",
					"message" => "Push lead id cannot be null"
				]
			], 200);
		}
		try {
			$pushLead = Lead::findOrFail($id);

			if ($pushLead) {

				$areaZoneOptionHtml = "";
				if (null != $pushLead->zone_id) {
					$zones = DB::table('zones')->select('id', 'zone','pincode');
					$zones = $zones->where('id', $pushLead->zone_id);
					$zones = $zones->first();
					if ($zones) {
						$areaZoneOptionHtml .= "<option value='{$zones->id}' selected>{$zones->zone} ({$zones->pincode})</option>";
					}
				}
				$kwOptionHtml = "";
				if (null != $pushLead->kw_id) {
					$kwOptionHtml .= "<option value='{$pushLead->kw_text}' selected>{$pushLead->kw_text}</option>";
				}

				$citieslists = Citieslists::orderBy('city', 'ASC')->get();
				$cityHtml = '';
				if (!empty($citieslists)) {
					foreach ($citieslists as $city) {

						if ($city->id == $pushLead->city_id) {
							$cityHtml .= '<option value="' . $city->id . '" selected>' . $city->city . '</option>';
						} else {
							$cityHtml .= '<option value="' . $city->id . '">' . $city->city . '</option>';
						}
					}
				}


				$userOptionHtml = "";
				if (null != $pushLead->created_by) {
					$user = DB::table('users');
					$user = $user->select('id','first_name','last_name');
					$user = $user->where('users.id', $pushLead->created_by);
					$user = $user->first();
					if ($user) {
						$userOptionHtml .= "<option value='{$user->id}' selected>{$user->first_name} {$user->last_name}</option>";
					}
				}
				$html = '\
					<div id="pushlead-edit-modal" class="modal fade" role="dialog">
						<div class="modal-dialog modal-lg">
							<form onsubmit="return pushLeadController.updatePushLead(this,' . $pushLead->id . ')">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title"><i class="fa fa-fw fa-pencil-square-o"></i> Edit Lead - "' . $pushLead->name . '"</h4>
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
														<input class="form-control" placeholder="Name" type="text" name="name" value="' . $pushLead->name . '" />
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Email</label>
														<input class="form-control" placeholder="Email" name="email" type="email" value="' . $pushLead->email . '" />
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label>Mobile</label>
														<input class="form-control" placeholder="Mobile" name="mobile" type="tel" value="' . $pushLead->mobile . '" />
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
														<select class="form-control" name="kw_text" tabindex="-1" aria-hidden="true">
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
														<textarea class="form-control" rows="3" placeholder="Remark" name="remark">' . $pushLead->remark . '</textarea>
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
						"message" => "Push lead not found"
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
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{

// dd($request->all());
		$validator = Validator::make($request->all(), [
			'name' => 'required|unique:leads,name,' . $id . ',id,mobile,' . $request->input('mobile'),
			'mobile' => 'required',
			'city_id' => 'required',
			'area_zone'=>'required',
			'kw_text' => 'required',
			// 'created_by' => 'required',
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
			$pushLead = Lead::findOrFail($id);
			if ($pushLead) {


				$city = Citieslists::where('id',  $request->input('city_id'))->first();

				$pushLead->city_id = $city->id;
				$pushLead->city_name = $city->city;
				$pushLead->name = $request->input('name');

				$pushLead->email = $request->input('email');

				$pushLead->mobile = $request->input('mobile');
				$pushLead->created_by = $request->input('created_by');

				if ($request->input('area_zone')) {
					$zones = DB::table('zones')->select('id', 'zone', 'pincode')->where('id',$request->input('area_zone'))->first();
					$pushLead->zone_id = $zones->id;
					$pushLead->zone = $zones->zone;
				}


				$keyword = Keyword::where('keyword', 'LIKE', $request->input('kw_text'))->first();
				if (!empty($keyword)) {
					$pushLead->kw_id = $keyword->id;
					$pushLead->kw_text = $keyword->keyword;
				} else {
					return response()->json([
						"statusCode" => 0,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Keyword not found."
						]
					], 200);
				}


				$pushLead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));

				if ($pushLead->save()) {
					return response()->json([
						"statusCode" => 1,
						"data" => [
							"responseCode" => 200,
							"payload" => "",
							"message" => "Push lead updated successfully."
						]
					], 200);
				}
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Push lead not updated."
					]
				], 200);
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			$area = Lead::findorFail($id);
			if ($area->delete()) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Push lead deleted successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Push lead not deleted !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Push lead not found !!"
				]
			], 200);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeFromQueryForm(Request $request)
	{
		//
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Content-Type:application/json');

		//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		$validator = Validator::make($request->all(), [
			'iq_name' => 'required|unique:leads,name,NULL,id,mobile,' . $request->input('iq_mobile'),
			'iq_mobile' => 'required',
			'iq_course' => 'required',
			'iq_city' => 'required',
		], [
			'iq_name.unique' => 'Record already exists in the table.',
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
		$city = Citieslists::where('city', 'LIKE', $request->input('iq_city'))->first();
		if (!$city) {
			$city = new City;
			$city->city = $request->input('iq_city');
			$city->save();
		}
		$lead = new Lead;

		$lead->city_id = $city->id;
		$lead->name = $request->input('iq_name');
		$emailToTestYet5 = $request->input('iq_email');
		if ($request->has('iq_email') && preg_match("/@yet5\.com$/i", $emailToTestYet5)) {
			$lead->email = '';
		} else {
			$lead->email = $request->input('iq_email');
		}
		//$lead->email = $request->input('email');
		$lead->mobile = $request->input('iq_mobile');
		//$lead->created_by = Auth::user()->id;
		$lead->created_by = 1;

		$keyword = Keyword::where('keyword', 'LIKE', $request->input('iq_course'))
			->where('city_id', $city->id)->get();
		if (count($keyword) > 0) {
			$lead->kw_id = $keyword[0]->id;
			$lead->kw_text = $keyword[0]->keyword;
			$bucketIndex = $keyword[0]->bucket;
		} else {
			$lead->kw_text = $request->input('iq_course');
			//return response()->json(['status'=>1,'msg'=>'Keyword not found'],404);
		}

		$lead->remark = $request->input('iq_message');
		if ($lead->save()) {
			return response()->json([
				"statusCode" => 1,
				"data" => [
					"responseCode" => 200,
					"payload" => "",
					"message" => "Push lead added successfully !!"
				]
			], 200);
		} else {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 400,
					"payload" => "",
					"message" => "Push lead not added !!"
				]
			], 200);
		}
	}

	/* 	public function sendMailCurl(){
			$token = 'EBB7BF1C-6C99-4992-8CBC-8B80DF12A52C';
			$data = "token=$token&emailDetails[fromName]=demo&emailDetails[fromEmail]=mohit%40cybermaxsolutions.com&emailDetails[emailName]=NotATest&emailDetails[replyEmail]=mohit%40cybermaxsolutions.com&emailDetails[subject]=Hello+World&emailDetails[templateContent]=%3Chtml%3E%3Cbody%3E+%3Cb%3E+Hello+World+%3C%2Fb%3E+%3C%2Fbody%3E%3C%2Fhtml%3E&emailDetails[webpageversion]=true&emailDetails[toListID]=5499417";
			$url = "http://www.benchmarkemail.com/api/1.0/?output=json&method=emailCreate";

			$objURL = curl_init($url);
			//curl_setopt($objURL, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($objURL, CURLOPT_POST, 1);
			curl_setopt($objURL, CURLOPT_POSTFIELDS, $data);
			$retval = trim(curl_exec($objURL));
			dd($objURL);
			curl_close($objURL);
			return $retval;
		} */
}
