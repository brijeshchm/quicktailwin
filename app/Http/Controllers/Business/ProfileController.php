<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Models\Client\Client; //model
use Validator;
use Illuminate\Support\Facades\Input;
use Image;
use DB;
use Mail;
use Excel;
use session;
use App\Http\Controllers\SitemapsController as SMC;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Zone;
use App\Models\Lead;
use App\Models\User;
use App\Models\Keyword;
use App\Models\LeadFollowUp;
use App\Models\Status;
use App\Models\AssignedLead;
use App\Models\AssigneddArea;
use App\Models\Citieslists;
use App\Models\AssignedZone;
use App\Models\State;
use App\Models\Occupation;
class ProfileController extends Controller
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

	public function profileInfo(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

		$states = State::where('country_id', '101')->get();
		$occupations = Occupation::where('status', '1')->get();
		return view('business.profile', ['client' => $client, 'states' => $states, 'occupations' => $occupations]);
	}



	public function saveProfileInfo(Request $request)
	{
 
		if ($request->ajax()) {
			$id = $request->client_id;
			$validator = Validator::make($request->all(), [

				'business_name' => [
					'required',
					'string',
					'max:255',
					Rule::unique('clients', 'business_name')->ignore($id),
				],

				'email' => [
					'required',
					'email',
					Rule::unique('clients', 'email')->ignore($id),
				],

				'mobile' => [
					'required',
					'digits_between:10,15',
					Rule::unique('clients', 'mobile')->ignore($id),
				],

				'landmark' => 'required|string',
				'address' => 'required|string',
				'city' => 'required',
				'state' => 'required',
				'zone' => 'required',
				// 'country' => 'required',
				'pincode' => 'required',
		 
				'website' => 'nullable|string|max:150',
				'time' => 'nullable|array',
				// 'time.*.from' => 'nullable|date_format:H:i',
				// 'time.*.to' => 'nullable|date_format:H:i',
			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}
			$state = State::find($request->state);
			$city = Citieslists::find($request->city);

			$client = Client::find($id);
			$string = $request->input('business_name');
			$string = filter_var($string, FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$string = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$client->business_name = $string;
			$client->email = $request->input('email');
			$client->mobile = $request->input('mobile');
			$client->whatsapp = $request->input('whatsapp');
			$client->second_mobile = $request->input('second_mobile');
			$client->second_whatsapp = $request->input('second_whatsapp');
			$client->address = $request->input('address');
			$client->landmark = $request->input('landmark');
			$client->country ="101";
 
			$zone = Zone::find($request->zone);
			if ($zone) {
			 
				$client->zone_id = $zone->id;
				$client->zone = $zone->zone;
			}

			$client->occupation = $request->input('occupation');
			$client->year_of_estb = $request->input('year_of_estb');

			$client->state_id = $state?->id;
			$client->state = $state?->name;
			$client->city_id = $city?->id;
			$client->city = $city?->city;
			$client->area = $request->input('area');

			$client->business_intro = $request->input('business_intro');
			$client->certifications = $request->input('certifications');
			$client->display_hofo = $request->input('display_hofo');
			$client->business_map = $request->input('business_map');
	 
			$client->website = $request->input('website');
			 
	 
				$time = $request->input('time');
				if (is_array($time) && !empty($time)) {
				$client->time = json_encode($time);
				}

			if ($client->save()) {
				$status = 1;
				$msg = "Personal Details updated successfully !";
			} else {
				$status = 0;
				$msg = "Personal Details could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}

	}


	public function getBusinessSocial(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		return view('business.social', ['client' => $client]);
	}

 

public function saveBusinessSocial(Request $request)
{
    

    $validator = Validator::make($request->all(), [

        'business_id'   => 'required|integer',

        'facebook_url'  => 'nullable|url|max:255',
        'instagram_url' => 'nullable|url|max:255',
        'twitter_url'   => 'nullable|url|max:255',
        'linkedin_url'  => 'nullable|url|max:255',
        'pinterest_url' => 'nullable|url|max:255',
        'youtube_url'   => 'nullable|url|max:255',

    ]);


    /*
    |--------------------------------------------------------------------------
    | Validation Error
    |--------------------------------------------------------------------------
    */

    if ($validator->fails()) {

        return response()->json([

            'status'  => false,

            'message' => 'Please check validation errors.',

            'errors'  => $validator
                ->errors()
                ->toArray(),

        ], 422);

    }


    /*
    |--------------------------------------------------------------------------
    | Find Business
    |--------------------------------------------------------------------------
    */

    $client = Client::find(
        $request->business_id
    );


    if (!$client) {

        return response()->json([

            'status'  => false,

            'message' => 'Business not found.',

        ], 404);

    }


    /*
    |--------------------------------------------------------------------------
    | Update Social Links
    |--------------------------------------------------------------------------
    */

    $client->facebook_url =
        $request->facebook_url;

    $client->instagram_url =
        $request->instagram_url;

    $client->twitter_url =
        $request->twitter_url;

    $client->linkedin_url =
        $request->linkedin_url;

    $client->pinterest_url =
        $request->pinterest_url;

    $client->youtube_url =
        $request->youtube_url;


    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    if ($client->save()) {

        return response()->json([

            'status'  => true,

            'message' => 'Social media links updated successfully.',

            'msg'     => 'Social media links updated successfully.',

        ], 200);

    }


    /*
    |--------------------------------------------------------------------------
    | Failed
    |--------------------------------------------------------------------------
    */

    return response()->json([

        'status'  => false,

        'message' => 'Social media links could not be updated. Please try again.',

    ], 500);
}

	public function saveBusinessSocial_old(Request $request)
	{

		if ($request->ajax()) {
 
			$validator = Validator::make($request->all(), [

				'facebook_url' => 'nullable|url|max:255',
				'instagram_url' => 'nullable|url|max:255',
				'twitter_url' => 'nullable|url|max:255',
				'linkedin_url' => 'nullable|url|max:255',
				'pinterest_url' => 'nullable|url|max:255',
				'youtube_url' => 'nullable|url|max:255',
			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

// dd($request->facebook_url);
			$client = Client::find($request->business_id);

			$client->facebook_url = $request->facebook_url;
			$client->instagram_url = $request->instagram_url;
			$client->twitter_url = $request->twitter_url;
			$client->linkedin_url = $request->linkedin_url;
			$client->pinterest_url = $request->pinterest_url;
			$client->youtube_url = $request->youtube_url;

			if ($client->save()) {
				$status = 1;
				$msg = "Personal Details updated successfully !";
			} else {
				$status = 0;
				$msg = "Personal Details could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}

	}

	public function saveBusinessLocation(Request $request)
	{
		if ($request->ajax()) {

			if ($request->input('zone_id') == "Other") {
				$validator = Validator::make($request->all(), [
					'state_id' => 'required|max:32',
					'city_id' => 'required|max:32',
					'other' => 'required|min:3|max:32|regex:/^(?!.*(.)\1{3,}).+$/',
				]);

			} else {
				$validator = Validator::make($request->all(), [
					//'city_id' 	=> 'required|max:35',
					//'zone_id' => 'required|max:35',
					'state_id' => 'required|max:32',
				]);
			}

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$id = $request->input('client_id');
			$client = Client::find($id);
			if (empty($request->input('zone_id')) && !empty($request->input('city_id')) && !empty($request->input('state_id'))) {

				$zones = Zone::where('city_id', $request->input('city_id'))->get();
				if (!empty($zones)) {
					foreach ($zones as $zone) {
						$assignedZone = new AssignedZone;
						$assignedZone->city_id = $request->input('city_id');
						$assignedZone->zone_id = $zone->id;
						$assignedZone->client_id = $client->id;
						$assignedZone->state_id = $request->input('state_id');
						$checkAssignedZone = AssignedZone::where('client_id', $client->id)->where('zone_id', $zone->id)->where('city_id', $request->input('city_id'))->where('state_id', $request->input('state_id'))->first();

						if (empty($checkAssignedZone)) {
							if ($assignedZone->save()) {

								$areas = DB::table('areas');
								$areas = $areas->where('areas.zone_id', '=', $zone->id);
								$areas = $areas->select('areas.id', 'areas.area');
								$areas = $areas->get();
								if (!empty($areas)) {
									foreach ($areas as $area) {
										$assigneddArea = new AssigneddArea;
										$assigneddArea->client_id = $client->id;
										$assigneddArea->state_id = $request->input('state_id');
										$assigneddArea->city_id = $request->input('city_id');
										$assigneddArea->assigned_zone_id = $zone->id;
										$assigneddArea->area_id = $area->id;
										$checkAssignedArea = AssigneddArea::where('client_id', $client->id)->where('assigned_zone_id', $zone->id)->where('city_id', $request->input('city_id'))->where('area_id', $area->id)->where('state_id', $request->input('state_id'))->first();
										if (empty($checkAssignedArea)) {
											$assigneddArea->save();
										} else {
											$already = 1;
										}

									}
								}
								$add = 1;
							}
						} else {
							$already = 1;

						}
					}
				}
				if (!empty($add)) {
					$status = true;
					$msg = 'Business Location add successfully';
					$code = 200;
				} else {
					if (!empty($already)) {
						$status = 0;
						$msg = "Already exists all City, Please add right city !";
						$code = 400;
					} else {
						$status = false;
						$msg = 'City not assigned';
						$code = 400;
					}

				}




			} else if (empty($request->input('zone_id')) && empty($request->input('city_id')) && !empty($request->input('state_id'))) {

				//state
				$states = State::where('id', $request->input('state_id'))->first();
				$cities = Citieslists::where('state_id', $states->id)->get();
				if (!empty($cities)) {
					foreach ($cities as $citis) {

						$zones = Zone::where('city_id', $citis->id)->get();
						if (!empty($zones)) {
							foreach ($zones as $zone) {
								$assignedZone = new AssignedZone;
								$assignedZone->city_id = $citis->id;
								$assignedZone->zone_id = $zone->id;
								$assignedZone->client_id = $client->id;
								$assignedZone->state_id = $states->id;
								$checkAssignedZone = AssignedZone::where('client_id', $client->id)->where('zone_id', $zone->id)->where('city_id', $citis->id)->where('state_id', $states->id)->first();

								if (empty($checkAssignedZone)) {
									if ($assignedZone->save()) {
										$areas = DB::table('areas');
										$areas = $areas->where('areas.zone_id', '=', $zone->id);
										$areas = $areas->select('areas.id', 'areas.area');
										$areas = $areas->get();
										if (!empty($areas)) {
											foreach ($areas as $area) {
												$assigneddArea = new AssigneddArea;
												$assigneddArea->client_id = $client->id;
												$assigneddArea->state_id = $states->id;
												$assigneddArea->city_id = $citis->id;
												$assigneddArea->assigned_zone_id = $zone->id;
												$assigneddArea->area_id = $area->id;
												$checkAssignedArea = AssigneddArea::where('client_id', $client->id)->where('assigned_zone_id', $zone->id)->where('city_id', $citis->id)->where('area_id', $area->id)->where('state_id', $states->id)->first();
												if (empty($checkAssignedArea)) {
													$assigneddArea->save();
												}
											}
										}
									}
									$add = 1;
								} else {
									$already = 1;
								}
							}
						}
					}
				}
				if (!empty($add)) {
					$status = true;
					$msg = 'Business Location add successfully';
					$code = 200;
				} else {
					if (!empty($already)) {
						$status = 0;
						$msg = "Already exists, Please add right city !";
						$code = 400;
					} else {
						$status = false;
						$msg = 'City not assigned';
						$code = 400;
					}
				}

			} elseif (!empty($request->input('zone_id')) && ($request->input('zone_id') != 'Other') && !empty($request->input('city_id')) && !empty($request->input('state_id'))) {
				//zone
				$assignedZone = new AssignedZone;
				$assignedZone->city_id = $request->input('city_id');
				$assignedZone->zone_id = $request->input('zone_id');
				$assignedZone->client_id = $request->input('client_id');
				$assignedZone->state_id = $request->input('state_id');
				$checkAssignedZone = AssignedZone::where('client_id', $request->input('client_id'))->where('zone_id', $request->input('zone_id'))->where('city_id', $request->input('city_id'))->first();

				if (empty($checkAssignedZone)) {
					if ($assignedZone->save()) {
						$areas = DB::table('areas');
						$areas = $areas->where('areas.zone_id', '=', $request->input('zone_id'));
						$areas = $areas->select('areas.id', 'areas.area');
						$areas = $areas->get();
						if (!empty($areas)) {
							foreach ($areas as $area) {
								$assigneddArea = new AssigneddArea;
								$assigneddArea->client_id = $request->input('client_id');
								$assigneddArea->state_id = $request->input('state_id');
								$assigneddArea->city_id = $request->input('city_id');
								$assigneddArea->assigned_zone_id = $request->input('zone_id');
								$assigneddArea->area_id = $area->id;
								$checkAssignedArea = AssigneddArea::where('client_id', $request->input('client_id'))->where('assigned_zone_id', $request->input('zone_id'))->where('city_id', $request->input('city_id'))->where('area_id', $area->id)->where('state_id', $request->input('state_id'))->first();
								if (empty($checkAssignedArea)) {
									$assigneddArea->save();

								}
							}
						}
						$add = 1;
					}
				} else {
					$already = 1;
				}


				if (!empty($add)) {
					$status = 1;
					$msg = "Business Location updated successfully !";
				} else {

					if (!empty($already)) {
						$status = 0;
						$msg = "Already exists, Please add right city !";
						$code = 400;
					} else {
						$status = false;
						$msg = "Business Location could not be successfully, Please try again !";
						$code = 400;
					}
				}
			} else if (!empty($request->input('zone_id') == 'Other') && !empty($request->input('city_id')) && !empty($request->input('state_id')) && !empty($request->input('other'))) {

				//Other
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
				$assignedZone->state_id = $request->input('state_id');
				$checkAssignedZone = AssignedZone::where('client_id', $request->input('client_id'))->where('zone_id', $zone_id)->where('city_id', $request->input('city_id'))->where('state_id', $request->input('state_id'))->first();
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

			}


			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}

 
	}


 /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignZoneDelete(Request $request, $id)
    { 

	 
		$assignedZone = AssignedZone::findOrFail($id);
		if (!empty($assignedZone)) {
			AssigneddArea::where('assigned_zone_id',$assignedZone->zone_id)->where('client_id',$assignedZone->client_id)->where('state_id',$assignedZone->state_id)->where('city_id',$assignedZone->city_id)->delete();		 					 
			if ($assignedZone->delete()) {
				$status=1;							 
				$msg="Assigned Zone Successfully!";	
			}else{
				$status=0;							 
				$msg="Assigned Zone could not be Deleted!";	
			}
			return response()->json(['status'=>$status,'msg'=>$msg],200); 
    	}
	}

	
	public function getBusinessCertificate(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		return view('business.certificate', ['client' => $client]);
	}

 



}
