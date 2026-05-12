<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client\Client;
use App\Models\Meeting;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Status;
use App\Models\Citieslists;
use App\Models\AssignedLead;
use Validator;
use DB;
use Auth;
use Crypt;


class MeetingController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {


			$leads = DB::table('clients');

			$rawQuery = "SELECT m1.*,m3.name as status_name FROM meetings m1 LEFT JOIN meetings m2 ON (m1.client_id = m2.client_id AND m1.id < m2.id) INNER JOIN status m3 ON m1.status = m3.id WHERE m2.id IS NULL";

			if (!empty($request->input('search.status'))) {
				$statuses = $request->input('search.status');
				$i = 0;
				if (!empty($statuses)) {
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
			} else {
				$rawQuery .= " AND m1.status NOT IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Interested' || `name` LIKE 'NPUP' || `name` LIKE 'Meeting Close')";

			}

			if (!empty($request->input('search.client_type'))) {
				$leads = $leads->where('clients.client_type', 'LIKE', $request->input('search.client_type'));
			}
			if ($request->input('search.datef') != '') {
				$rawQuery .= " AND DATE(m1.date_time)>='" . date('Y-m-d', strtotime($request->input('search.datef'))) . "'";
			}

			if ($request->input('search.datet') != '') {
				$rawQuery .= " AND DATE(m1.date_time)<='" . date('Y-m-d', strtotime($request->input('search.datet'))) . "'";
			}
			if ($request->input('search.datef') == '' && $request->input('search.datet') == '') {
				$rawQuery .= " AND DATE(m1.date_time)<='" . date('Y-m-d') . "'";
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
			if ($request->input('search.user') != '') {
				$leads = $leads->where('clients.created_by', '=', $request->input('search.user'));
			}

			$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'clients.id', '=', DB::raw('`fu`.`client_id`'));
			$leads = $leads->select('clients.*', DB::raw('`fu`.`id` as meeting_id'), DB::raw('`fu`.`date_time`'), DB::raw('`fu`.`status_name`'), DB::raw('`fu`.`remark`'));
			$leads = $leads->orderBy(DB::raw('`fu`.`date_time`'), 'desc');

			$leads = $leads->whereNull('clients.deleted_at');
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('clients.username', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.business_name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.city', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}


			$leads = $leads->paginate($request->input('length'));

			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			$returnLeads['recordCollection'] = [];

			foreach ($leads as $lead) {

				$type = "";
				switch ($lead->client_type) {
					case 'gold':
						$type = 'G';
						break;
					case 'diamond':
						$type = 'D';
						break;
					case 'platinum':
						$type = 'P';
						break;
					case 'silver':
						$type = 'S';
						break;

				}
				if (!empty($type)) {
					$type = '<strong style="color:red" >[' . $type . ']</strong>';
				} else {
					$type = "";
				}
				$assignedLeadsCount = 0;
				$assignedLeadsCount = AssignedLead::where('client_id', '=', $lead->id)->count();
				$username = '';
				if (!empty($lead->paid_status)) {
					$username = "<a href='/developer/clients/update/{$lead->username}' title='Paid client'>{$lead->username}</a>";
				} else {
					$username = "<a href='/developer/clients/update/{$lead->username}' style='color:red' title='Not Paid client'>{$lead->username}</a>";
				}

				$categories = DB::table('assigned_client_categories')->where('client_id', $lead->id)->get();
				$paidOrNot = "";
				if (!empty($categories)) {
					$paidOrNot = "<a style='color:blue' href='#' title='Assign Client Category'>*</a>";
				} else {

					$paidOrNot = "<a style='color:red' href='#' title='Not Assign Client Category'>*</a>";
				}
				if (!is_null($lead->created_by)) {
					$user = DB::table('users')->where('id', $lead->created_by)->first();
				}

				$disabled = '';

				$data[] = [
					$username . " " . $paidOrNot,
					$lead->business_name . '' . $type,
					$lead->city,
					(new Carbon($lead->date_time))->format('d-m-Y h:i:s'),
					$lead->status_name,
					$lead->remark,
					$assignedLeadsCount,
					((isset($user) && $user) ? $user->first_name . " " . $user->last_name : ""),
					'<a href="javascript:void(0)" onclick="javascript:client.getClientMeetingForm(\'' . $lead->username . '\')" title="View All"><i aria-hidden="true" class="fa fa-comments fa-fw"></i></a>'

				];

			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}

		$statuses = Status::orderBy('name', 'ASC')->get();
		$citieslist = Citieslists::select('id', 'city')->orderBy('city', 'ASC')->get();
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('admin.meeting.meeting', [
			'search' => $search,
			'citieslist' => $citieslist,
			'statuses' => $statuses
		]);
	}



	/**
	 * cleint meeting Store and follow up.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function followUpStore(Request $request, $id)
	{
		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [
				'sales_manager' => 'required',
				'status' => 'required',
				'remark' => 'required'
			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}



			$statusModel = Status::find($request->input('status'));

			if ($statusModel->show_exp_date) {
				$validator = Validator::make($request->all(), [
					'expected_date_time' => 'required'
				]);
				if ($validator->fails()) {
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
				}
			}
			$client = Client::where('id', $id)->first();
			if ($client) {
				$meeting = new Meeting;
				$meeting->client_id = $id;
				$meeting->assign_id = $request->input('sales_manager');
				$meeting->date_time = $request->input('expected_date_time');
				$meeting->status = $request->input('status');
				$meeting->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$meeting->remark_by = Auth::user()->id;
				if ($meeting->save()) {
					return response()->json([
						'statusCode' => 1,
						'data' => [
							'responseCode' => 200,
							'message' => 'Follow Up Successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 0,
						'data' => [
							'responseCode' => 400,
							'payload' => '',
							'message' => 'Follow Up not Successfully'
						]
					], 200);
				}
			} else {
				return response()->json([
					'statusCode' => 0,
					'data' => [
						'responseCode' => 404,
						'payload' => '',
						'message' => 'Client not found'
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


	public function getClientMeetingForm(Request $request, $client_id = null)
	{

		if (null == $client_id) {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => 'Client not found'
				]
			], 200);
		}
		$client_username = $client_id;
		$client = Client::where('username', 'LIKE', $client_username)->first();

		if ($client) {
			$meetings = Meeting::where('client_id', $client->id)->orderBy('created_at', 'desc')->first();
			$users = User::where('role', 'salesmanager')->get();
			$usersHtml = '';
			if (count($users) > 0) {
				foreach ($users as $user) {
					if (!empty($meetings)) {
						if ($user->id == $meetings->assign_id) {
							$usersHtml .= '<option value="' . $user->id . '" selected>' . $user->first_name . ' ' . $user->last_name . '</option>';
						} else {
							$usersHtml .= '<option  value="' . $user->id . '">' . $user->first_name . ' ' . $user->last_name . '</option>';
						}
					} else {
						$usersHtml .= '<option value="' . $user->id . '">' . $user->first_name . ' ' . $user->last_name . '</option>';
					}
				}
			}

			$statuses = Status::where('client_follow_up', 1)->get();

			$statusHtml = '';
			$disabled = '';
			$dateValue = '';
			if (!empty($statuses)) {
				foreach ($statuses as $status) {
					if (strcasecmp($status->name, 'new lead')) {
						$selected = '';
						if (!empty($meetings)) {
							if ($meetings->status == $status->id) {
								$selected = 'selected';
								if (!strcasecmp($status->name, 'Not Interested')) {

									$disabled = 'disabled';
									if ($meetings->date_time != NULL) {
										$dateValue = date_format(date_create($meetings->date_time), 'd-F-Y g:i A');
									}
								}
							}
							$statusHtml .= '<option data-value="' . $status->show_exp_date . '" value="' . $status->id . '" ' . $selected . '>' . $status->name . '</option>';

						} else {
							$statusHtml .= '<option data-value="' . $status->show_exp_date . '" value="' . $status->id . '" >' . $status->name . '</option>';
						}
					}
				}
			}

			$html = '
				<div id="client-meeting-modal" class="modal fade" role="dialog">
					<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fa fa-fw fa-comments"></i> Enter remark for client Follow Up</h4>
									<h4 class="client-success" style="margin-left: 296px;margin-top: -20px;"></h4><h4 class="client-error" style="margin-left: 296px;margin-top: -20px;"></h4>
								</div>
								<div class="modal-body">
								<form onsubmit="return client.submitClientMeetingForm(' . $client->id . ',this)">																
									<div class="form-group">
									<div class="col-md-4">
										<label for="name">Name<span class="required">:</span></label>									 
										<p class="form-control-static" style="display:inline">' . $client->business_name . '</p>
									</div>
								</div>
								<div class="form-group">
								 <div class="col-md-4">
										<label for="mobile">Mobile <span class="required">:</span></label>									 
										<p class="form-control-static" style="display:inline">' . $client->mobile . '</p>
									 </div>
								</div>
								<div class="form-group">
									 <div class="col-md-4">
									<label for="email">Email <span class="required">:</span></label>							 
										<p class="form-control-static" style="display:inline">' . ucfirst($client->city) . '</p>
								 </div>
								</div>
								<div class="form-group">
									 <div class="col-md-12">
									<label for="email">Email <span class="required">:</span></label>							 
										<p class="form-control-static" style="display:inline">' . $client->email . '</p>
								 </div>
								</div>
								
								<div class="form-group">
									 <div class="col-md-4">
									<label for="email">Select Sales Manager Executive<span class="required">:</span></label>							 
										<select class="form-control sms-control" name="sales_manager" tabindex="-1">
											<option value="">-- Select Sales Manager --</option>	
											' . $usersHtml . '											
										</select>
								 </div>
								</div>
								<div class="form-group">
									<div class="col-md-4">
										<label>Status <span class="required">*</span></label>
										<select class="form-control select2-single" name="status" tabindex="-1">
											<option value="">-- SELECT STATUS --</option> 
											 ' . $statusHtml . '
										</select>
									</div>
								</div>
									<div class="form-group">
									<div class="col-md-4">
										<label for="expected_date_time">Follow Up date and time <span class="required">*</span></label>
										<input type="text" id="expected_date_time" name="expected_date_time" class="form-control col-md-7 col-xs-12" value="' . $dateValue . '" placeholder="Expected Date &amp; Time" ' . $disabled . ' autocomplete="off">
									</div>
									
									 
								</div> 							 
								<div class="form-group">
										<div class="col-md-4">
										<label>Remark</label>										 
										<textarea name="remark" rows="2" class="form-control"></textarea>
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
							 
						</form>
						
					
					<div class="table-responsive" style="overflow-x: initial;">
					<p style="margin-top:10px;margin-bottom:3px;"><strong>Tele Coller Follow Up</strong>  <select onchange="javascript:leadController.getAllFollowUps()" class="follow-up-count"><option value="5">Last 5</option><option value="all">All</option></select></p>
						<table id="tele-coller-followups" class="table table-bordered table-striped table-hover">
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
						 </div>  					 
				 
					</div>
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
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => 'Client not found'
				]
			], 200);
		}
	}

	/**
	 * Return all scheduled meetings associated to the specified client.
	 *
	 * @param  int  $id
	 * @return JSON modal
	 */
	public function viewAllMeetings(Request $request, $client_id = null)
	{
		if (null == $client_id) {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => 'Client not found'
				]
			], 200);
		}
		$client_username = $client_id;
		$client = Client::findOrFail($client_id);
		$html = '';
		if ($client) {
			$meetings = Meeting::where('client_id', $client_id)->orderBy('date_time', 'desc')->get();
			if (count($meetings) > 0) {
				$meetingsHtml = '';
				foreach ($meetings as $meeting) {
					$meetingsHtml .= '<li>' . (new Carbon($meeting->date_time))->format('d-m-Y h:i:s') . ' => ' . $meeting->remark . '</li>';
				}
				$html = '\
					<div id="client-all-meetings-modal" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title"><i class="fa fa-fw fa-comments"></i> Meetings Scheduled</h4>
								</div>
								<div class="modal-body">
									<ol>
									' . $meetingsHtml . '
									</ol>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" onclick="javascript:client.closeClientAllMeetingsModal()">Close</button>
								</div>
							</div>
						</div>
					</div>
				';
			} else {
				$html = '\
					<div id="client-all-meetings-modal" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title"><i class="fa fa-fw fa-comments"></i> Meetings Scheduled</h4>
								</div>
								<div class="modal-body">
									<p>No meetings found...</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" onclick="javascript:client.closeClientAllMeetingsModal()">Close</button>
								</div>
							</div>
						</div>
					</div>
				';
			}
			return response()->json([
				'statusCode' => 1,
				'data' => [
					'responseCode' => 200,
					'payload' => $html,
					'message' => ''
				]
			], 200);
		} else {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => 'Client not found'
				]
			], 200);
		}
	}

	/**
	 * Mark meeting status as done.
	 *
	 * @param  int  $meeting_id
	 * @return JSON modal
	 */
	public function changeMeetingStatus(Request $request, $meeting_id)
	{
		try {
			$meeting = Meeting::findOrFail($meeting_id);
			$meeting->status = 1;
			if ($meeting->save()) {
				return response()->json([
					'statusCode' => 1,
					'data' => [
						'responseCode' => 200,
						'payload' => '',
						'message' => 'Meeting marked as done'
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				'statusCode' => 0,
				'data' => [
					'responseCode' => 404,
					'payload' => '',
					'message' => 'Specified meeting not found'
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
	public function getTeleCollerFollowups(Request $request, $id)
	{
		if ($request->ajax()) {
			$clients = Client::where('username', $id)->first();
			$meetings = DB::table('meetings as meeting')
				->join('status as status', 'status.id', '=', 'meeting.status')
				->join('users as users', 'users.id', '=', 'meeting.remark_by')
				->where('meeting.client_id', '=', $clients->id)
				->select('meeting.*', 'status.name as status_name', 'users.first_name', 'users.last_name')
				->orderBy('meeting.id', 'desc');

			$meetings = $meetings->take(100);
			$meetings = $meetings->paginate($request->input('length'));
			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $meetings->total();
			$returnLeads['recordsFiltered'] = $meetings->total();

			foreach ($meetings as $meeting) {
				$data[] = [
					(new Carbon($meeting->created_at))->format('d-m-Y h:i:s'),
					$meeting->remark,
					$meeting->first_name . ' ' . $meeting->last_name,
					$meeting->status_name,
					(new Carbon($meeting->date_time))->format('d-m-Y h:i A')
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}






}
