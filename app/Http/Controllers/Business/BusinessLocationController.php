<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Client\Client;
use Validator;
use App\Models\Zone;
use App\Models\Citieslists;
use App\Models\AssignedZone;
use App\Models\State;

class BusinessLocationController extends Controller
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

	public function locationInformation(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('business.locationInformation', ['search' => $search, 'client' => $client]);
	}
	public function saveBusinessLocation(Request $request, $id)
	{
		if ($request->ajax()) {

			if ($request->input('zone_id') == "Other") {


				$validator = Validator::make($request->all(), [
					'city_id' => 'required|max:25',
					//'other' 	=> 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',	
					'other' => 'required|min:3|max:32|regex:/^(?!.*(.)\1{3,}).+$/',
				]);


			} else {
				$validator = Validator::make($request->all(), [
					'city_id' => 'required|max:255',
					'zone_id' => 'required|max:255',

				]);
			}

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}
			$assignedZone = new AssignedZone;
			$assignedZone->city_id = $request->input('city_id');
			if ($request->input('zone_id') == "Other") {
				$checkZone = Zone::where('zone', $request->input('other'))->where('city_id', $request->input('city_id'))->first();
				if (empty($checkZone)) {
					$zone = new Zone;
					$zone->city_id = $request->input('city_id');
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

			$checkAssignedZone = AssignedZone::where('client_id', $request->input('client_id'))->where('zone_id', $zone_id)->where('city_id', $request->input('city_id'))->first();

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
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}

	}

	public function saveLocationInformation(Request $request)
	{
		if ($request->has('location_form_submit')) {

			$client = Client::find($request->input('business_id'));
			$id = $request->input('business_id');
			$messages = ['mobile.regex' => 'Mobile number cannot start with 0.'];
			$validator = Validator::make($request->all(), [
				'business_name' => 'required|unique:clients,business_name,' . $id . ',id,city,' . $request->input('city'),
				'landmark' => 'regex:/[a-zA-z ]$/',
				'city' => 'required|regex:/[a-zA-z ]+$/',
				'state' => 'required|regex:/[a-zA-z ()]+$/',
				'country' => 'required|regex:/[a-zA-z ]+$/',

			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$string = $request->input('business_name');
			$string = filter_var($string, FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$string = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));		
			$client->business_name = $string;
			$client->address = $request->input('address');
			$client->landmark = $request->input('landmark');
			$client->business_city = $request->input('city');
			$client->state = $request->input('state');
			$client->country = $request->input('country');

			if ($client->save()) {
				$client = Client::find($id);

				$resulsu = "Location Information Updated Successfully";
				return response()->json(['status' => 1, 'result' => $resulsu]);
			} else {

				return response()->json(['status' => 0, 'result' => 'Location Information not assigned']);
			}
		}
	}




	public function businessLocation(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		$statesis = State::get();
		return view('business.business-location', ['search' => $search, 'client' => $client, 'statesis' => $statesis]);
	}

	


}
