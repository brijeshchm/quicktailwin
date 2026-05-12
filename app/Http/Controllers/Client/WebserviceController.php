<?php

namespace App\Http\Controllers\Client;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Mail;
use Artisan;
//use Illuminate\Support\Facades\DB;

use App\Models\lead;
use App\Models\Client\Client; //model
use Session;
use Validator;
class WebserviceController extends Controller
{


	//list of lead according to client id
	public function leadslist(Request $request)
	{

		$base_path = $request->root();
		$jsonData = json_decode(trim(file_get_contents('php://input')), true);
		if ($jsonData) {
			$user_name = $jsonData['username'];

			if (!empty($user_name)) {
				$clientid = Client::select('id', 'username', 'business_name')->where('username', $user_name)->first();
				if (!empty($clientid)) {
					$leads = DB::table('leads')
						->join('assigned_leads', 'leads.id', '=', 'assigned_leads.lead_id')
						->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id')
						->orderBy('leads.created_at', 'desc')
						->orderBy('leads.id', 'desc')
						->where('assigned_leads.client_id', $clientid->id)
						->get();
					if (!empty($leads)) {
						foreach ($leads as $key => $val) {
							$leads_list[$key] = array(
								'name' => $val->name,
								'mobile' => $val->mobile,
								'email' => $val->email,
								'cityName' => $val->city_name,
								'course' => $val->kw_text,
							);
						}

						$data['status'] = true;
						$data['leadslist'] = $leads_list;



					} else {
						$data['status'] = false;
						$data['msg'] = "Not record founds!";
					}

				} else {
					$data['status'] = false;
					$data['msg'] = "Not exit this user name, please try again right!";
				}

			} else {

				$data['status'] = false;
				$data['msg'] = "All field required.";
			}


		} else {
			$data['status'] = false;
			$data['msg'] = 'Some error oops';
		}

		echo json_encode($data);
	}

	public function addLead(Request $request)
	{

		$base_path = $request->root();
		$jsonData = json_decode(trim(file_get_contents('php://input')), true);
	 
		if ($jsonData) {
			$name = $jsonData['name'];

			if (!empty($name)) {

				$lead = new Lead;
				$lead->name = $jsonData['name'];
				$lead->mobile = $jsonData['mobile'];
				$lead->email = $jsonData['email'];
				$lead->city_name = $jsonData['cityName'];
				$lead->kw_text = $jsonData['course'];

				if ($lead->save()) {
					$data['status'] = true;
					$data['msg'] = "Insert successfully lead";

				} else {
					$data['status'] = false;
					$data['msg'] = "Not Insert successfully lead!";
				}

			} else {

				$data['status'] = false;
				$data['msg'] = "name field required.";
			}


		} else {
			$data['status'] = false;
			$data['msg'] = 'Some error oops';
		}

		echo json_encode($data);
	}



	public function add(Request $request)
	{

		$base_path = $request->root();
		$jsonData = json_decode(trim(file_get_contents('php://input')), true);

		if ($jsonData) {
			$name = $jsonData['name'];

			if (!empty($name)) {

				$lead = new Lead;
				$lead->name = $jsonData['name'];
				$lead->mobile = $jsonData['mobile'];
				$lead->email = $jsonData['email'];
				$lead->city_name = $jsonData['cityName'];
				$lead->kw_text = $jsonData['course'];

				if ($lead->save()) {
					$data['status'] = true;
					$data['msg'] = "Insert successfully lead";

				} else {
					$data['status'] = false;
					$data['msg'] = "Not Insert successfully lead!";
				}

			} else {

				$data['status'] = false;
				$data['msg'] = "name field required.";
			}


		} else {
			$data['status'] = false;
			$data['msg'] = 'Some error oops';
		}

		echo json_encode($data);
	}












}
