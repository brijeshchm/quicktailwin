<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use App\Models\AssignedLead;
use Auth;
//models
use App\Models\Client\Client;
use App\Models\ClientCategory;
use App\Models\Meeting;
use App\Models\Status;
use App\Models\Keyword;
use App\Models\Citieslists;
use Carbon\Carbon;

class DashboardController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{



		$totalClientsCount = Client::count();

		$totalPaidClientsCount = Client::where('paid_status', '1')->count();
		$totalRegClientsThisMonth = Client::where('paid_status', '1')->whereMonth('created_at', '=', date('m'))->count();
		$totalPendingRenewals = Client::where('paid_status', '0')->count();


		$citieslists = Citieslists::all();
		$clientCategories = ClientCategory::all();

		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}

		$kwds = Keyword::select('id', 'keyword')->orderBy('keyword', 'ASC')->get();
		$statuses = Status::where('lead_filter', 1)->get();
		return view('admin.index', [
			'totalClientsCount' => $totalClientsCount,
			'totalPaidClientsCount' => $totalPaidClientsCount,
			'totalRegClientsThisMonth' => $totalRegClientsThisMonth,
			'totalPendingRenewals' => $totalPendingRenewals,
			'citieslists' => $citieslists,
			'kwds' => $kwds,
			'statuses' => $statuses,
			'clientCategories' => $clientCategories,
			'search' => $search
		]);
	}


	/**
	 * Get Paid Clients - Pagination
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getPaidClients(Request $request)
	{
		if ($request->ajax()) {		 

			$leads = DB::table('clients');
			$leads = $leads->select('clients.*');
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('clients.username', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.business_name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.first_name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.last_name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.email', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('clients.mobile', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			if ($request->input('search.client_cat') != '') {
				$leads = $leads->join('assigned_client_categories', 'clients.id', '=', 'assigned_client_categories.client_id');
				$select = 'assigned_client_categories.client_category_id';
			}

			if ($request->input('search.paid_status') != '') {
				$leads = $leads->where('clients.paid_status', $request->input('search.paid_status'));
			}
			if ($request->input('search.client_type') != '') {
				$leads = $leads->where('clients.package_status', 'LIKE', $request->input('search.client_type'));
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

			if ($request->input('search.client_cat') != '') {
				$leads = $leads->where('assigned_client_categories.client_category_id', $request->input('search.client_cat'));
			}

			if (!$request->user()->current_user_can('administrator')) {

				if ($request->user()->current_user_can('manager')) {


					$leads = $leads->where('clients.created_by', $request->user()->id);

					if ($request->input('search.user') != '') {
						$leads = $leads->where('clients.created_by', '=', $request->input('search.user'));
					}


				} else {
					$user_id = $request->user()->id;
					$id = $request->input('search.user');
					if (!is_null($id) && !empty($id)) {
						$user_id = $id;
					}
					$leads = $leads->where('clients.created_by', '=', $user_id);


				}


			} else {
				if ($request->input('search.user') != '') {
					$leads = $leads->where('clients.created_by', '=', $request->input('search.user'));
				}
			}


			$leads = $leads->whereNull('clients.deleted_at');
			$leads = $leads->orderBy('clients.expired_on', 'DESC');
			$leads = $leads->where('clients.leads_remaining', '<', 15);
		 
			$leads = $leads->paginate($request->input('length'));
	 
			$returnLeads = [];
			$data = [];
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
				$doInclude = true;
				$assignedLeadsCount = 0;
				$assignedLeadsCount = AssignedLead::where('client_id', '=', $lead->id)->count();
				if ($request->input('search.client_cat') != '') {
					$count = DB::table('assigned_client_categories')->where('client_id', $lead->id)->where('client_category_id', $request->input('search.client_cat'))->count();
					if ($count == 0) {
						$returnLeads['recordsTotal'] = $returnLeads['recordsTotal'] - 1;
						$returnLeads['recordsFiltered'] = $returnLeads['recordsFiltered'] - 1;
						$doInclude = false;
					}
				}


				$owner_name = '';
				if ($lead->created_by != null && isset($owner[$lead->created_by])) {
					$owner_name = $owner[$lead->created_by];
				}

				if (null == $lead->expired_on) {
					$yrly_subs_end_date = '';
				} else {
					$yrly_subs_end_date = date_format(date_create($lead->expired_on), 'd-m-Y H:i A');
				}
				$type = "";
				switch ($lead->package_status) {
					case '1':
						$type = 'G';
						break;
					case '2':
						$type = 'D';
						break;
					case '3':
						$type = 'P';
						break;

				}
				if (!empty($type)) {
					$type = '<strong style="color:red">[' . $type . ']</strong>';
				} else {
					$type = "";
				}
				$paidOrNot = "";
				if ($lead->paid_status) {
					$paidOrNot = "<a style='color:red' href='#' title='Paid'>*</a>";
				}
				if ($doInclude) {
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
					$data[] = [
						"<a href='/developer/clients/update/{$lead->username}'>{$lead->username}</a>$paidOrNot",
						$lead->business_name . " " . $type,
						//($lead->first_name) ." ". ($lead->last_name),
						$lead->mobile,
						$assignedLeadsCount,
						$lead->leads_remaining,
						ucwords($lead->city),
						//"Rs.".($lead->balance_amt)." / Count:".($lead->leads_count)."(".$lead->leads_remaining.")",
						date_format(date_create($lead->expired_on), 'd-m-Y'),
						'<a title="Meeting" data-client_id_meeting="' . $lead->username . '" href="javascript:client.getClientMeetingForm(\'' . $lead->username . '\')" ' . $meetingPopover . '><i class="fa fa-meetup fa-fw" aria-hidden="true"></i></a>',
						$owner_name
					];
				}
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}

	public function getpendingLeadsDashboard(Request $request)
	{

		if ($request->ajax()) {
			 
			$leads = DB::table('leads as leads');	 
			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.email', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}



			// generating raw query to make join
			$rawQuery = "SELECT m1.*,m3.name as status_name FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) INNER JOIN status m3 ON m1.status = m3.id WHERE m2.id IS NULL";

			if (!empty($request->input('search.status'))) {		 
				$rawQuery .= " AND m1.status=" . $request->input('search.status');
			} else {
				$rawQuery .= " AND m1.status NOT IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Interested' || `name` LIKE 'NPUP')";
			}

			if (!empty($request->input('search.expdf'))) {
				echo "inner";
				$rawQuery .= " AND DATE(m1.expected_date_time)>='" . date('Y-m-d', strtotime($request->input('search.expdf'))) . "'";
			}

			if (!empty($request->input('search.expdt'))) {
				$rawQuery .= " AND DATE(m1.expected_date_time)<='" . date('Y-m-d', strtotime($request->input('search.expdt'))) . "'";
			}

			if ($request->input('search.expdf') == '' && $request->input('search.expdt') == '') {
				$rawQuery .= " AND DATE(m1.expected_date_time)<='" . date('Y-m-d') . "'";
			}
	 
			$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
			$leads = $leads->select('leads.*', DB::raw('`fu`.`status_name`'), DB::raw('`fu`.`status`'), DB::raw('`fu`.`expected_date_time`'), DB::raw('`fu`.`remark`'));


			if (!empty($request->input('search.lead_type'))) {
				$leads = $leads->where('leads.b_end', 'LIKE', $request->input('search.lead_type'));
			}

			if (!empty($request->input('search.course'))) {
				$leads = $leads->where('leads.kw_id', $request->input('search.course'));
			}
			if (!empty($request->input('search.city'))) {
				$leads = $leads->where('leads.city_name', '=', $request->input('search.city'));
			}
 
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

				$action = '';
				$separator = '';



				$action .= $separator . '<a data-lead_id_follow="' . $lead->id . '" href="javascript:pushLeadController.getLeadFollowupForm(' . $lead->id . ')"  title="Follow Up Leads"><i class="fa fa-fw fa-eye"></i></a>';
				$separator = ' | ';

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
					(new Carbon($lead->expected_date_time))->addMinutes(330)->format('d-m-Y h:i:s'),
					($lead->push_by) ? $owner[$lead->push_by] : '',
					$action
				];
				$returnLeads['recordCollection'][] = $lead->id;
			}
			$returnLeads['data'] = $data;	 
			return response()->json($returnLeads);

		} else {


			$totalClientsCount = Client::count();
			$totalPaidClientsCount = Client::where('paid_status', '1')->count();
			$totalRegClientsThisMonth = Client::where('paid_status', '1')->whereMonth('created_at', '=', date('m'))->count();
			$totalPendingRenewals = Client::where('paid_status', '0')->count();
			//$totalPendingRenewals = DB::table('clients')->sum(DB::raw('CASE WHEN ((paid_status=\'0\') || ((DATE(expired_on)<=DATE_ADD(curdate(), INTERVAL 15 DAY)))) THEN 1 ELSE 0 END'));

			$Cities = DB::table('clients')
				->select('clients.city')
				->distinct()
				->get();

			$clientCategories = ClientCategory::all();

			$search = [];
			if ($request->has('search')) {
				$search = $request->input('search');
			}

			$kwds = DB::table('leads')
				->select('leads.kw_text')
				->distinct()
				->get();
			$statuses = Status::where('lead_filter', 1)->get();
			return view('admin.index', [
				'totalClientsCount' => $totalClientsCount,
				'totalPaidClientsCount' => $totalPaidClientsCount,
				'totalRegClientsThisMonth' => $totalRegClientsThisMonth,
				'totalPendingRenewals' => $totalPendingRenewals,
				'Cities' => $Cities,
				'kwds' => $kwds,
				'statuses' => $statuses,
				'clientCategories' => $clientCategories,
				'search' => $search
			]);

		}
	}

}
