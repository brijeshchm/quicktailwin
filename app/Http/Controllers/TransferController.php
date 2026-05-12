<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Keyword;
use Auth;
use DB;
use Validator;
use App\Models\User;
use App\Models\Lead;
use App\Models\Demo;
use App\Models\Status;
use Excel;
use Carbon\Carbon;
use Session;

class TransferController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		$keyword = Keyword::all();
		$statuss = Status::where('lead_filter', 1)->get();
		$users = [];
		if ($request->user()->current_user_can('administrator')) {
			$users = User::select('id', 'first_name', 'last_name')->orderBy('first_name', 'ASC')->get();
		} else {
			$users = User::select('first_name', 'last_name')->where('id', $request->user()->id)->get();
		}
		return view('admin.transfer.transfer', ['keyword' => $keyword, 'users' => $users, 'statuss' => $statuss]);
	}

	/**
	 * Transfer the resources
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function transfer(Request $request)
	{	 
		$validator = Validator::make($request->all(), [
			'transfer' => 'required',
			'transfer_from' => 'required',
			'transfer_to' => 'required',

		]);
		if ($validator->fails()) {
			return redirect('/developer/permanent-transfer')
				->withErrors($validator)
				->withInput();
		}
		switch ($request->input('transfer')) {
			case 'all_leads':
				$transfer = 'leads';
				break;

			case 'all_demos':
				$transfer = 'demos';
				break;

		}


		if (isset($transfer) && $transfer == 'leads') {
			 
			$leads = DB::table('leads as leads');			 // generating raw query to make join


			$leads = $leads->where('created_by', $request->transfer_from);
			if ($request->input('leaddf') != '') {
				$leads = $leads->whereDate('leads.created_at', '>=', date_format(@date_create($request->input('leaddf')), 'Y-m-d'));
				$leads = $leads->whereDate('leads.created_at', '<=', date_format(@date_create($request->input('leaddt')), 'Y-m-d'));
			}
			 
			if ($request->input('course') != '') {
				$courses = $request->input('course');
				foreach ($courses as $course) {
					$courseList[] = $course;
				}
				$leads = $leads->whereIn('leads.kw_text', $courseList);
			}


			if ($request->input('status') != '') {
				$status_data = $request->input('status');

				foreach ($status_data as $status) {
					$statusList[] = $status;
				}
				$leads = $leads->whereIn('leads.status_id', $statusList);
			}
		 
			$leads = $leads->get();
		 
			if (count($leads)) {
				$users = User::select('id', 'first_name')->get();
				$usr = [];
				foreach ($users as $user) {
					$usr[$user->id] = $user->first_name;
				}
				$leadsUpdate = DB::table('leads as leads');

				$leadsUpdate = $leadsUpdate->where('created_by', $request->transfer_from);

				if ($request->input('course') != '') {
					$courses = $request->input('course');
					foreach ($courses as $course) {
						$courseList[] = $course;
					}
					$leadsUpdate = $leadsUpdate->whereIn('leads.kw_text', $courseList);
				}
				if ($request->input('status') != '') {
					$status_data = $request->input('status');
					foreach ($status_data as $status) {
						$statusList[] = $status;
					}
					$leadsUpdate = $leadsUpdate->whereIn('leads.status_id', $statusList);
				}
				if ($request->input('leaddf') != '') {
					$leadsUpdate = $leadsUpdate->whereDate('leads.created_at', '>=', date_format(date_create($request->input('leaddf')), 'Y-m-d'));
					$leadsUpdate = $leadsUpdate->whereDate('leads.created_at', '<=', date_format(date_create($request->input('leaddt')), 'Y-m-d'));
				}
		 
				$leadsUpdate = $leadsUpdate->update(['created_by' => $request->transfer_to]);

				if ($leadsUpdate) {
					$request->session()->flash('alert-success', 'Lead successfully transfer!');
					return redirect('/developer/permanent-transfer')->with('alert-success', 'Lead successfully transfer!');

				}
			} else {
				return redirect('/developer/permanent-transfer')
					->withErrors(['No lead(s) found for transfer'])
					->withInput();
			}
		}


	}

}
