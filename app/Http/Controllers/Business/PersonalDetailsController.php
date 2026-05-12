<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Client\Client; //model
use Validator;
use App\Models\Occupation;
use App\Models\Citieslists;
use App\Models\Zone;
use App\Models\State;
class PersonalDetailsController extends Controller
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

	public function personalDetails(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$edit_data = Client::find($clientID);
		$occupations = Occupation::where('status', '1')->get();
		$citys = Citieslists::get();
		$states = State::where('country_id', '101')->get();
		return view('business.personal-details', ['edit_data' => $edit_data, 'occupations' => $occupations, 'citys' => $citys, 'states' => $states]);
	}

	public function savePersonalDetails(Request $request, $id)
	{ 
		if (!$request->ajax()) {
			return response()->json([
				'status' => 0,
				'msg' => 'Invalid request'
			], 400);
		}

		// ✅ Validation (fixed field name mismatches)
		$validator = Validator::make($request->all(), [
			'sirName' => 'required|string|max:255',
			'first_name' => 'required|string|max:255',
			'dob' => 'required|date',
			'personal_email' => 'required|email',
			'marital' => 'required|string',
			'personal_phone' => 'required|string|max:15',
			'country' => 'required',
			'personal_state' => 'required|integer',
			'personal_city' => 'required|integer',
			'personal_zone' => 'required|integer',
			'personal_area' => 'required|string',
			'personal_pincode' => 'required|string|max:10',
			'personal_address' => 'required|string',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 0,
				'errors' => $validator->errors()
			], 422);
		}

		// ✅ Client existence check
		$client = Client::find($id);
		if (!$client) {
			return response()->json([
				'status' => 0,
				'msg' => 'Client not found'
			], 404);
		}

		// ✅ Assign values
		$client->sirName = $request->sirName;
		$client->first_name = ucfirst($request->first_name);
		$client->middle_name = $request->middle_name;
		$client->last_name = $request->last_name;
		$client->dob =date('Y-m-d',strtotime($request->dob));
		$client->personal_email = $request->personal_email;
		$client->marital = $request->marital;
		$client->personal_phone = $request->personal_phone;	 
		$client->gender = $request->gender;		 
		$client->personal_area = $request->personal_area;
		$client->personal_pincode = $request->personal_pincode;
 
		$client->personal_address = $request->personal_address;

		// ✅ City mapping
		if ($city = Citieslists::find($request->personal_city)) {
			$client->personal_city_id = $city->id;
			$client->personal_city = $city->city;
		}

		// ✅ State mapping
		if ($state = State::find($request->personal_state)) {
			$client->personal_state_id = $state->id;
			$client->personal_state = $state->name;
		}
		// ✅ State mapping
		if ($zone = Zone::find($request->personal_zone)) {
			$client->personal_zone_id = $zone->id;
			$client->personal_zone = $zone->zone;
		}

		$client->save();

		return response()->json([
			'status' => 1,
			'msg' => 'Personal Details updated successfully!'
		], 200);
	}



}
