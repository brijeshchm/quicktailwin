<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use App\Models\AssignedLead;

//models
use App\Models\Client\Client;
use App\Models\ClientCategory;
use App\Models\Meeting;
use App\Models\Status;
use App\Models\Keyword;
use App\Models\Lead;
use App\Models\Citieslists;
use Carbon\Carbon;

class LeadDashboardController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, $id = null)
	{
		$totalLeadCount = Lead::count();
		$totalPaidClientsCount = Client::where('paid_status', '1')->count();
		$totalRegClientsThisMonth = Client::where('paid_status', '1')->whereMonth('created_at', '=', date('m'))->count();
		$totalPendingRenewals = Client::where('paid_status', '0')->count();
		$totalPendingRenewals = DB::table('clients')->sum(DB::raw('CASE WHEN ((paid_status=\'0\') || ((DATE(expired_on)<=DATE_ADD(curdate(), INTERVAL 15 DAY)))) THEN 1 ELSE 0 END'));


		$citieslist = Citieslists::all();
		$clientCategories = ClientCategory::all();

		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}

		$kwds = Keyword::select('id', 'keyword')->orderBy('keyword', 'ASC')->get();
		$statuses = Status::where('lead_filter', 1)->get();
		return view('admin.lead.leadsdashboard', [
			'totalLeadCount' => $totalLeadCount,
			'totalPaidClientsCount' => $totalPaidClientsCount,
			'totalRegClientsThisMonth' => $totalRegClientsThisMonth,
			'totalPendingRenewals' => $totalPendingRenewals,
			'citieslist' => $citieslist,
			'kwds' => $kwds,
			'statuses' => $statuses,
			'clientCategories' => $clientCategories,
			'search' => $search
		]);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function leadconversion(Request $request, $id = null)
	{

		$totalLeadCount = Lead::count();
		$totalPaidClientsCount = Client::where('paid_status', '1')->count();
		$totalRegClientsThisMonth = Client::where('paid_status', '1')->whereMonth('created_at', '=', date('m'))->count();
		$totalPendingRenewals = Client::where('paid_status', '0')->count();
		$totalPendingRenewals = DB::table('clients')->sum(DB::raw('CASE WHEN ((paid_status=\'0\') || ((DATE(expired_on)<=DATE_ADD(curdate(), INTERVAL 15 DAY)))) THEN 1 ELSE 0 END'));


		$citieslist = Citieslists::all();
		$clientCategories = ClientCategory::all();

		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}

		$kwds = Keyword::select('id', 'keyword')->orderBy('keyword', 'ASC')->get();
		$statuses = Status::where('lead_filter', 1)->get();
		return view('admin.lead.leadsconversion', [
			'totalLeadCount' => $totalLeadCount,
			'totalPaidClientsCount' => $totalPaidClientsCount,
			'totalRegClientsThisMonth' => $totalRegClientsThisMonth,
			'totalPendingRenewals' => $totalPendingRenewals,
			'citieslist' => $citieslist,
			'kwds' => $kwds,
			'statuses' => $statuses,
			'clientCategories' => $clientCategories,
			'search' => $search
		]);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function leadDashboard(Request $request, $id = null)
	{

		if ($request->wantsJson()) {

			$user_id = $request->user()->id;
			$viewAll = false;
			$viewManage = false;
			if ((is_null($id) || empty($id)) && ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager'))) {
				$viewAll = true;
			}

			if (!is_null($id) || !empty($id)) {
				$user_id = $id;
			}


			$response = [];

			//// FIND TOTAL LEADS OF A COUNSELLOR		
			if (!empty($viewAll)) {

				$todays = strtotime("now");
				$leadlast = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status  AND DATE(m1.created_at)='" . date('Y-m-d', $todays) . "'";
				$leadlast = $leadlast->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leadlast = $leadlast->where('leads.created_by', '=', $user_id)->first();
				$response['leadlast'] = (isset($leadlast->created_at) ? $leadlast->created_at : "");


			} else {
				$todays = strtotime("now");
				$leadlast = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status  AND DATE(m1.created_at)='" . date('Y-m-d', $todays) . "'";
				$leadlast = $leadlast->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leadlast = $leadlast->where('leads.created_by', '=', $user_id)->first();
				$response['leadlast'] = (isset($leadlast->created_at) ? $leadlast->created_at : "");
			}
			if (!empty($viewAll)) {
				$response['total_leads'] = Lead::count();
			} else {
				$response['total_leads'] = Lead::where('created_by', '=', $user_id)->count();
			}


			// FIND WHOSE LAST FOLLOW UP IS JOINED			
			$leads = DB::table('leads as leads');
			$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) WHERE m2.id IS NULL AND m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Joined')";
			$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

			if ($viewAll) {
				$response['total_joined'] = $leads->count();
			} else {
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['total_joined'] = $leads->count();
			}

			// FIND WHOSE LAST FOLLOW UP IS INTERESTED			
			$leads = DB::table('leads as leads');
			$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) WHERE m2.id IS NULL AND m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Interested')";
			$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

			if ($viewAll) {
				$response['total_interested'] = $leads->count();
			} else {
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['total_interested'] = $leads->count();
			}



			// FIND FOLLOW UPS EXCLUDING INTERESTED,NOT INTERESTED,LOC ISSUE,JOINED,ATTENDED DEMO
			$leads = DB::table('leads as leads');
			$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 LEFT JOIN lead_follow_ups m2 ON (m1.lead_id = m2.lead_id AND m1.id < m2.id) WHERE m2.id IS NULL AND m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'New Lead')";
			$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

			if ($viewAll) {
				$response['total_follow_up'] = $leads->count();

			} else {
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['total_follow_up'] = $leads->count();
			}



			// FIND DAILY CALLING STATUS		
			$baseValue = 150;
			$from_unix_time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			$yesterday = strtotime("now");

			// NEW LEADS				
			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$leads = $leads->whereDate('leads.created_at', '=', date('Y-m-d', $yesterday));
				$response['daily_calling_status']['new_lead'] = $leads->count();
				$response['daily_calling_status']['new_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$leads = $leads->whereDate('leads.created_at', '=', date('Y-m-d', $yesterday));
				$leads = $leads->where('leads.created_by', '=', $user_id);

				$response['daily_calling_status']['new_lead'] = $leads->count();
				$response['daily_calling_status']['new_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);

			}



			// INTERESTED
			// **********

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'interested') AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['daily_calling_status']['interested'] = $leads->count();
				$response['daily_calling_status']['interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Interested') AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['interested'] = $leads->count();
				$response['daily_calling_status']['interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);

			}


			// PENDING
			// *******				
			if (!empty($viewAll)) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Connected' || `name` LIKE 'Call Later') AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['daily_calling_status']['pending'] = $leads->count();
				$response['daily_calling_status']['pending_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Connected' || `name` LIKE 'Call Later') AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['pending'] = $leads->count();
				$response['daily_calling_status']['pending_percent'] = round(($leads->count() / $baseValue) * 100, 2);

			}

			// NOT INTERESTED
			// **************

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Invalid Number' || `name` LIKE 'Not Interested') AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['daily_calling_status']['not_interested'] = $leads->count();
				$response['daily_calling_status']['not_interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Invalid Number' || `name` LIKE 'Not Interested') AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['not_interested'] = $leads->count();
				$response['daily_calling_status']['not_interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);

			}

			// Visits 
			// ******

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Visited' ) AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['daily_calling_status']['visits'] = $leads->count();
				$response['daily_calling_status']['visits_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Visited' ) AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['visits'] = $leads->count();
				$response['daily_calling_status']['visits_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// Total lead Assign  
			// ******

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE  DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['daily_calling_status']['total_assign_lead'] = $leads->count();
				$response['daily_calling_status']['total_assign_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.push_by', '=', $user_id);
				$response['daily_calling_status']['total_assign_lead'] = $leads->count();
				$response['daily_calling_status']['total_assign_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// Total Client Assign  
			// ******				 
			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE  DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "' GROUP BY m1.client_id";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

				$leads = $leads->get();
				$clientHtml = '';
				if (!empty($leads)) {
					foreach ($leads as $assignedLeads) {
						$clientsname = DB::table('clients')->where('id', $assignedLeads->client_id)->first();
						if (!empty($clientsname)) {
							$clientHtml .= '<li><a href="#"><i class="icon-user-lock"></i>' . $clientsname->business_name . '</a></li>';
						}
					}
				}

				$assign = '<ul class="breadcrumb-elements">
					<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					' . count($leads) . '			 
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
					' . $clientHtml . ' 
					</ul>
					</li>
					</ul>';
				$response['daily_calling_status']['total_client_assign'] = $assign;
				$response['daily_calling_status']['total_client_assign_percent'] = round((count($leads) / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "' GROUP BY m1.client_id";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.push_by', '=', $user_id);

				$leads = $leads->get();

				$clientHtml = '';
				if (!empty($leads)) {
					foreach ($leads as $assignedLeads) {

						$clientsname = DB::table('clients')->where('id', $assignedLeads->client_id)->first();
						if (!empty($clientsname)) {
							$clientHtml .= '<li><a href="#"><i class="icon-user-lock"></i>' . $clientsname->business_name . '</a></li>';
						}
					}
				}
				$assign = '<ul class="breadcrumb-elements">
					<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					' . count($leads) . '			 
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
					' . $clientHtml . ' 
					</ul>
					</li>
					</ul>';

				$response['daily_calling_status']['total_client_assign'] = $assign;
				$response['daily_calling_status']['total_client_assign_percent'] = round((count($leads) / $baseValue) * 100, 2);
			}


			// JOINED 
			// ******

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Joined') AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['daily_calling_status']['joined'] = $leads->count();
				$response['daily_calling_status']['joined_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Joined' ) AND DATE(m1.created_at)='" . date('Y-m-d', $yesterday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['joined'] = $leads->count();
				$response['daily_calling_status']['joined_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// TOTAL CALL COUNT
			// ****************
			// LEADS
			// *****
			$response['daily_calling_status']['total_call_count_leads'] = $response['daily_calling_status']['interested'] + $response['daily_calling_status']['pending'] + $response['daily_calling_status']['not_interested'] + $response['daily_calling_status']['visits'] + $response['daily_calling_status']['joined'];



			// FIND WEEKLY CALLING STATUS
			// **************************
			//$baseValue = 700;
			$baseValue = 150;
			$monday = strtotime("last monday midnight");
			$now = strtotime("now");
			$sunday = strtotime("next sunday", $monday);
			$diff = date_diff(date_create(date('Y-m-d', $monday)), date_create(date('Y-m-d', $now)));
			$baseValue *= ($diff->days + 1);
			// NEW LEADS
			// *********

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$leads = $leads->whereDate('leads.created_at', '>=', date('Y-m-d', $monday));
				$leads = $leads->whereDate('leads.created_at', '<=', date('Y-m-d', $sunday));

				$response['weekly_calling_status']['new_lead'] = $leads->count();
				$response['weekly_calling_status']['new_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$leads = $leads->whereDate('leads.created_at', '>=', date('Y-m-d', $monday));
				$leads = $leads->whereDate('leads.created_at', '<=', date('Y-m-d', $sunday));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['weekly_calling_status']['new_lead'] = $leads->count();
				$response['weekly_calling_status']['new_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);

			}

			// INTERESTED
			// **********

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Interested') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['weekly_calling_status']['interested'] = $leads->count();
				$response['weekly_calling_status']['interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Interested') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['weekly_calling_status']['interested'] = $leads->count();
				$response['weekly_calling_status']['interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}


			// PENDING
			// *******

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Connected' || `name` LIKE 'Call Later') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

				$response['weekly_calling_status']['pending'] = $leads->count();
				$response['weekly_calling_status']['pending_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE  `name` LIKE 'Not Connected' || `name` LIKE 'Call Later') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['weekly_calling_status']['pending'] = $leads->count();
				$response['weekly_calling_status']['pending_percent'] = round(($leads->count() / $baseValue) * 100, 2);

			}

			// NOT INTERESTED
			// **************

			if ($viewAll) {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Invalid Number' || `name` LIKE 'Not Interested') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['weekly_calling_status']['not_interested'] = $leads->count();
				$response['weekly_calling_status']['not_interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Invalid Number' || `name` LIKE 'Not Interested') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['weekly_calling_status']['not_interested'] = $leads->count();
				$response['weekly_calling_status']['not_interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// JOINED
			// ******

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Joined') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['weekly_calling_status']['joined'] = $leads->count();
				$response['weekly_calling_status']['joined_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Joined') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['weekly_calling_status']['joined'] = $leads->count();
				$response['weekly_calling_status']['joined_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// Visited
			// ******

			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Visited' ) AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['weekly_calling_status']['visits'] = $leads->count();
				$response['weekly_calling_status']['visits_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Visited') AND DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['weekly_calling_status']['visits'] = $leads->count();
				$response['weekly_calling_status']['visits_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// Total Assign lead
			// ******				
			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE  DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['weekly_calling_status']['total_assign_lead'] = $leads->count();
				$response['weekly_calling_status']['total_assign_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE  DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.push_by', '=', $user_id);
				$response['weekly_calling_status']['total_assign_lead'] = $leads->count();
				$response['weekly_calling_status']['total_assign_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// Total Client Assign
			// ******				
			if ($viewAll) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE  DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "' GROUP BY client_id";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

				$response['weekly_calling_status']['total_client_assign'] = $leads->count();
				$response['weekly_calling_status']['total_cleint_assign_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE  DATE(m1.created_at)>='" . date('Y-m-d', $monday) . "' AND DATE(m1.created_at)<='" . date('Y-m-d', $sunday) . "' GROUP BY client_id";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.push_by', '=', $user_id);

				$response['weekly_calling_status']['total_client_assign'] = $leads->count();
				$response['weekly_calling_status']['total_cleint_assign_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}
			$response['weekly_calling_status']['total_call_count_leads'] = $response['weekly_calling_status']['interested'] + $response['weekly_calling_status']['pending'] + $response['weekly_calling_status']['not_interested'] + $response['weekly_calling_status']['joined'] + $response['weekly_calling_status']['visits'];
			return response()->json(compact('response'), 200);


		}

	}



	/**
	 * Return daily calling status based on received date in post request.
	 *
	 * @param user id, from and to date.
	 * @return JSON Object.
	 */
	public function getCallingStatus(Request $request, $id = null)
	{
		if ($request->wantsJson()) {
			$user_id = $request->user()->id;

			$viewAll = false;

			if ((is_null($id) || empty($id)) && ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager'))) {
				$viewAll = true;
			}

			if (!is_null($id) && !empty($id)) {
				$user_id = $id;
			}

			// FIND DAILY CALLING STATUS
			// *************************
			$baseValue = 150;
			$response = [];

			$fromDate = $request->input('fromDate');
			$toDate = $request->input('toDate');


			$diff = date_diff(date_create($fromDate), date_create($toDate));
			$baseValue *= ($diff->days + 1);
			// NEW LEADS
			// *********
			if (!empty($viewAll)) {

				$leads = DB::table('leads as leads');
				if (!empty($fromDate))
					$leads = $leads->whereDate('leads.created_at', '>=', $fromDate);
				if (!empty($toDate))
					$leads = $leads->whereDate('leads.created_at', '<=', $toDate);

				$response['daily_calling_status']['new_lead'] = $leads->count();
				$response['daily_calling_status']['new_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				if (!empty($fromDate))
					$leads = $leads->whereDate('leads.created_at', '>=', $fromDate);
				if (!empty($toDate))
					$leads = $leads->whereDate('leads.created_at', '<=', $toDate);
				$leads = $leads->where('leads.created_by', '=', $user_id);

				$response['daily_calling_status']['new_lead'] = $leads->count();
				$response['daily_calling_status']['new_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			if (!empty($viewAll)) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Interested') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

				$response['daily_calling_status']['interested'] = $leads->count();
				$response['daily_calling_status']['interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);

			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Interested') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['interested'] = $leads->count();
				$response['daily_calling_status']['interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// PENDING
			// *******

			if (!empty($viewAll)) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'NPUP' || `name` LIKE 'Call Later' || `name` LIKE 'Switched Off') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

				$response['daily_calling_status']['pending'] = $leads->count();
				$response['daily_calling_status']['pending_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'NPUP' || `name` LIKE 'Not Reachable' || `name` LIKE 'Call Later' || `name` LIKE 'Switched Off') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['pending'] = $leads->count();
				$response['daily_calling_status']['pending_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}


			/* if(!empty($viewAll)){
			$leads = DB::table('leads as leads');
			$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Connected' || `name` LIKE 'Call Later') AND DATE(m1.created_at)>='".$fromDate."' AND DATE(m1.created_at)<='".$toDate."'";
			$leads = $leads->join(DB::raw('('.$rawQuery.') as fu'),'leads.id','=',DB::raw('`fu`.`lead_id`'));				 
			$response['daily_calling_status']['pending'] = $leads->count();
			$response['daily_calling_status']['pending_percent'] = round(($leads->count()/$baseValue)*100, 2);
			}else{

				//echo $fromDate.'--'.$toDate.'--'.$user_id; 

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Call Later') AND DATE(m1.created_at) >= '".$fromDate."' AND DATE(m1.created_at) <='".$toDate."'";
				$leads = $leads->join(DB::raw('('.$rawQuery.') as fu'),'leads.id','=',DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by','=',$user_id);
				$response['daily_calling_status']['pending'] = $leads->count();
				$response['daily_calling_status']['pending_percent'] = round(($leads->count()/$baseValue)*100, 2);


			} */


			// NOT INTERESTED
			// **************

			if (!empty($viewAll)) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Invalid Number' || `name` LIKE 'Not Interested') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['daily_calling_status']['not_interested'] = $leads->count();
				$response['daily_calling_status']['not_interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Invalid Number' || `name` LIKE 'Not Interested') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['not_interested'] = $leads->count();
				$response['daily_calling_status']['not_interested_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// Visited
			// **********

			if (!empty($viewAll)) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Visited') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

				$response['daily_calling_status']['visits'] = $leads->count();
				$response['daily_calling_status']['visits_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Visited') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['visits'] = $leads->count();
				$response['daily_calling_status']['visits_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}


			// Total lead Assign  
			// ******

			if (!empty($viewAll)) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE  DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

				$response['daily_calling_status']['total_assign_lead'] = $leads->count();
				$response['daily_calling_status']['total_assign_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.push_by', '=', $user_id);
				$response['daily_calling_status']['total_assign_lead'] = $leads->count();
				$response['daily_calling_status']['total_assign_lead_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// Total Client Assign  
			// ******

			if (!empty($viewAll)) {

				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "' GROUP BY client_id";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->get();
				$clientHtml = '';
				if (!empty($leads)) {
					foreach ($leads as $assignedLeads) {
						$clientsname = DB::table('clients')->where('id', $assignedLeads->client_id)->first();
						if (!empty($clientsname)) {
							$clientHtml .= '<li><a href="#"><i class="icon-user-lock"></i>' . $clientsname->business_name . '</a></li>';
						}
					}
				}
				$assign = '<ul class="breadcrumb-elements">
							<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							 ' . count($leads) . '			 
							</a>
							<ul class="dropdown-menu dropdown-menu-right">
							' . $clientHtml . ' 
							</ul>
							</li>
							</ul>';
				$response['daily_calling_status']['total_client_assign'] = $assign;
				//$response['daily_calling_status']['total_client_assign'] = $leads->count();
				$response['daily_calling_status']['total_assign_lead_percent'] = round((count($leads) / $baseValue) * 100, 2);




			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM assigned_leads m1 WHERE DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "' GROUP BY client_id";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.push_by', '=', $user_id);
				$leads = $leads->get();

				$clientHtml = '';
				if (!empty($leads)) {
					foreach ($leads as $assignedLeads) {

						$clientsname = DB::table('clients')->where('id', $assignedLeads->client_id)->first();
						if (!empty($clientsname)) {
							$clientHtml .= '<li><a href="#"><i class="icon-user-lock"></i>' . $clientsname->business_name . '</a></li>';
						}
					}
				}
				$assign = '<ul class="breadcrumb-elements">
					<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					' . count($leads) . '			 
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
					' . $clientHtml . ' 
					</ul>
					</li>
					</ul>';
				//$response['daily_calling_status']['total_client_assign'] = $leads->count();
				$response['daily_calling_status']['total_client_assign'] = $assign;
				$response['daily_calling_status']['total_assign_lead_percent'] = round((count($leads) / $baseValue) * 100, 2);
			}





			// JOINED
			// ******

			if (!empty($viewAll)) {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Joined' ) AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$response['daily_calling_status']['joined'] = $leads->count();
				$response['daily_calling_status']['joined_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			} else {
				$leads = DB::table('leads as leads');
				$rawQuery = "SELECT m1.* FROM lead_follow_ups m1 WHERE m1.status IN (SELECT id FROM `status` WHERE `name` LIKE 'Joined') AND DATE(m1.created_at)>='" . $fromDate . "' AND DATE(m1.created_at)<='" . $toDate . "'";
				$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));
				$leads = $leads->where('leads.created_by', '=', $user_id);
				$response['daily_calling_status']['joined'] = $leads->count();
				$response['daily_calling_status']['joined_percent'] = round(($leads->count() / $baseValue) * 100, 2);
			}

			// TOTAL CALL COUNT
			// ****************
			// LEADS
			// *****
			$response['daily_calling_status']['total_call_count_leads'] = $response['daily_calling_status']['interested'] + $response['daily_calling_status']['pending'] + $response['daily_calling_status']['not_interested'] + $response['daily_calling_status']['visits'] + $response['daily_calling_status']['joined'];
			// DEMOS
			// *****
			// RETURNING RESULT SET
			// ********************
			return response()->json(compact('response'), 200);
		}
	}
	public function getpendingLeadsDashboard(Request $request)
	{

		if ($request->ajax()) {

			$user_id = $request->user()->id;

			$id = $request->input('search.counsellor');


			$viewAll = false;
			if ((is_null($id) || empty($id)) && ($request->user()->current_user_can('administrator'))) {
				$viewAll = true;
			}
			if (!is_null($id) && !empty($id)) {
				$user_id = $id;
			}



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


			if ($request->input('search.status') != '') {
				echo "status";
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


					//$rawQuery .= " AND m1.status=".$request->input('search.status');
				}
			} else {
				$rawQuery .= " AND m1.status NOT IN (SELECT id FROM `status` WHERE `name` LIKE 'Not Interested' || `name` LIKE 'NPUP')";
			}


			if (!empty($request->input('search.datef'))) {

				$rawQuery .= "AND DATE(m1.expected_date_time)>='" . date('Y-m-d', strtotime($request->input('search.datef'))) . "'";
			}

			if (!empty($request->input('search.datet'))) {
				$rawQuery .= " AND DATE(m1.expected_date_time)<='" . date('Y-m-d', strtotime($request->input('search.datet'))) . "'";
			}



			$leads = $leads->join(DB::raw('(' . $rawQuery . ') as fu'), 'leads.id', '=', DB::raw('`fu`.`lead_id`'));

			$leads = $leads->select('leads.*', DB::raw('`fu`.`status_name`'), DB::raw('`fu`.`status`'), DB::raw('`fu`.`expected_date_time`'), DB::raw('`fu`.`remark`'));


			if ($request->input('search.lead_type') != '') {
				$leads = $leads->where('leads.b_end', $request->input('search.lead_type'));
			}


			if ($request->input('search.course') != '') {
				$courses = $request->input('search.course');
				if (!empty($courses)) {
					foreach ($courses as $course) {
						$courseList[] = $course;
					}
					$leads = $leads->whereIn('leads.kw_text', $courseList);
				}
			}

			if ($request->input('search.city') != '') {
				$cityss = $request->input('search.city');

				if (!empty($cityss)) {
					foreach ($cityss as $city) {
						$cityList[] = $city;
					}
					$leads = $leads->whereIn('leads.city_name', $cityList);
				}
			}


			$leads = $leads->where('leads.created_by', '=', $user_id);


			if ($request->input('search.datef') != '') {
				$leads = $leads->whereDate('leads.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
			}




			$leads = $leads->orderBy('expected_date_time', 'ASC');
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
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:red\" title=\"User Lead\">[UL]</i>";

				} else if ($lead->b_end == 2) {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:green\" class=\"fa fa-fw fa-adn\" title=\"Advertise\"></i>";

				} else if ($lead->b_end == 3) {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:blue\" title=\"Lead Portal\">[LP]</i>";

				} else {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:red\" title=\"Website\">[W]</i>";

				}

				$action = '';
				$separator = '';

				$action .= $separator . '<a data-lead_id_follow="' . $lead->id . '" href="javascript:pushLeadController.getLeadFollowupForm(' . $lead->id . ')"  title="' . $lead->remark . '"><i class="fa fa-fw fa-eye"></i></a>';
				$separator = ' | ';


				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$lead->id'></th>",
					$leadname,
					$lead->mobile,
					($lead->created_by) ? $owner[$lead->created_by] : '',
					$lead->status_name,
					$lead->kw_text,
					$lead->city_name,
					(date('Y-m-d',strtotime($lead->expected_date_time))),
					($lead->push_by) ? $owner[$lead->push_by] : '',

					$action
				];
				$returnLeads['recordCollection'][] = $lead->id;
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);

		}




	}
	public function getpendingLeadConversion(Request $request)
	{

		if ($request->ajax()) {

			$leads = DB::table('assigned_leads as assigned_leads');
			$leads = $leads->leftJoin('leads', 'leads.id', '=', 'assigned_leads.lead_id');
			$leads = $leads->leftJoin('clients', 'clients.id', '=', 'assigned_leads.client_id');

			if ($request->input('search.value') != '') {
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('leads.name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.mobile', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('leads.email', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}
			$leads = $leads->select('leads.*', 'assigned_leads.*', 'assigned_leads.created_at as assignDate');


			if ($request->input('search.lead_type') != '') {
				$leads = $leads->where('leads.b_end', $request->input('search.lead_type'));
			}


			if ($request->input('search.client') != '') {

				$leads = $leads->where('assigned_leads.client_id', $request->input('search.client'));
			}

			if ($request->input('search.status') != '') {
				$statuss = $request->input('search.status');

				if (!empty($statuss)) {
					foreach ($statuss as $status) {
						$statussList[] = $status;
					}
					$leads = $leads->whereIn('leads.status_id', $statussList);
				}
			}
			if ($request->input('search.course') != '') {
				$courses = $request->input('search.course');
				if (!empty($courses)) {
					foreach ($courses as $course) {
						$courseList[] = $course;
					}
					$leads = $leads->whereIn('leads.kw_text', $courseList);
				}
			}

			if ($request->input('search.city') != '') {
				$cityss = $request->input('search.city');

				if (!empty($cityss)) {
					foreach ($cityss as $city) {
						$cityList[] = $city;
					}
					$leads = $leads->whereIn('leads.city_name', $cityList);
				}
			}



			$leads = $leads->where('clients.conversion_status', '=', 1);


			if ($request->input('search.datef') != '') {
				$leads = $leads->whereDate('assigned_leads.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
			}
			if ($request->input('search.datet') != '') {
				$leads = $leads->whereDate('assigned_leads.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
			}



			$leads = $leads->orderBy('assigned_leads.created_at', 'DESC');
			$leads = $leads->paginate($request->input('length'));
			$returnLeads = $data = $owner = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();
			$returnLeads['recordCollection'] = [];
			foreach ($leads as $lead) {


				$users = DB::table('users')->where('id', $lead->created_by)->select('users.id', 'users.first_name', 'users.last_name')->first();
				$pushBy = DB::table('users')->where('id', $lead->push_by)->select('users.id', 'users.first_name', 'users.last_name')->first();
				if (!empty($users)) {
					$userName = $users->first_name;
				} else {
					$userName = '';

				}
				if (!empty($pushBy)) {
					$pushByName = $pushBy->first_name;
				} else {
					$pushByName = '';

				}

				if ($lead->b_end == 1) {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:red\" title=\"User Lead\">[UL]</i>";

				} else if ($lead->b_end == 2) {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:green\" class=\"fa fa-fw fa-adn\" title=\"Advertise\"></i>";

				} else if ($lead->b_end == 3) {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:blue\" title=\"Lead Portal\">[LP]</i>";

				} else {
					$leadname = $lead->name . " <i aria-hidden=\"true\" style=\"color:red\" title=\"Website\">[W]</i>";

				}

				$action = '';
				$separator = '';

				$action .= $separator . '<a data-lead_id_follow="' . $lead->lead_id . '" href="javascript:pushLeadController.getLeadFollowupForm(' . $lead->lead_id . ')"  title="' . $lead->remark . '"><i class="fa fa-fw fa-eye"></i></a>';
				$separator = ' | ';


				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$lead->lead_id'></th>",
					$leadname,
					//$lead->fistName, 				
					$lead->mobile,
					$userName,
					//($lead->created_by)? $owner[$lead->created_by]:'',									
					$lead->status_name,
					$lead->kw_text,
					$lead->city_name,
					//'date',					
					(new Carbon($lead->assignDate))->format('d-m-Y h:i:s'),
					$pushByName,

					$action
				];
				$returnLeads['recordCollection'][] = $lead->lead_id;
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);

		}
	}

}
