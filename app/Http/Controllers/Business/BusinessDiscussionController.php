<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class BusinessDiscussionController extends Controller
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
	 * Return paginated resources.
	 *
	 * @return JSON Payload.
	 */
	public function getDiscussion(Request $request)
	{
		if ($request->ajax()) {

			$clientID = auth()->guard('clients')->user()->id;
			$discussion = DB::table('client_discussion')
				->orderBy('id', 'desc')
				->where('client_id', $clientID)
				->paginate($request->input('length'));

			$returnLeads = [];
			$data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $discussion->total();
			$returnLeads['recordsFiltered'] = $discussion->total();

			foreach ($discussion as $lead) {
				$data[] = [
					date_format(date_create($lead->createdate), 'd-m-Y H:i:s'),
					$lead->discussion,
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);

		}
	}
}
