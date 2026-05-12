<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddLeadRequest;
use DB;
use Mail;
use Artisan;
use Validator;
//model
use App\Models\Keyword;

use App\Models\Citieslists;
use App\Models\Lead;
use App\Models\ChildCategory;
use App\Models\ParentCategory;
use App\Models\ClientCategory;
use App\Models\Client\Client;
use App\AssignedClientCategory;
use App\Models\Blogdetails;
use App\Models\Testimonialsdetail;
use App\Models\LeadFollowUp;
use App\Models\Status;
use App\Models\Zone;
use App\Models\Contacts;
use App\Models\Client\Comment;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

 
use Illuminate\Support\Facades\Cache;


// use Illuminate\Support\Facades\Cache;
class HomePageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */


	public function index()
	{
 		$responses = Http::pool(fn (Pool $pool) => [
            $pool->as('home')->withoutVerifying()->get('https://api.quickdials.com/api/website/homePage'),
            $pool->as('repairs')->withoutVerifying()->get('https://api.quickdials.com/api/website/repairsServices'),
            $pool->as('wedding')->withoutVerifying()->get('https://api.quickdials.com/api/website/weddingPlanning'),
        ]);

        $homeData    = $responses['home']->json()    ?? [];

      
        $repairsData = $responses['repairs']->json() ?? [];
        $weddingData = $responses['wedding']->json() ?? [];
 



        return view('client.index', compact('homeData', 'repairsData', 'weddingData'));
	}

	public function saveEnquiry(Request $request)
	{
		if ($request->ajax()) {
			$validator = Validator::make($request->all(), [
				'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'email' => 'required|email|regex:/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i',
				'mobile' => 'required|numeric',
				'kw_text' => 'required',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();

				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}
			$lead = new Lead;
			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			$lead->email = $request->input('email');

			$lead->lead_form = $request->input('lead_form');
			$lead->from_page = filter_var($request->input('from_page'), FILTER_SANITIZE_STRING);
			$citySlug = $request->input('city_id');
			$cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : null;

			if (!empty($request->location)) {

				$zone = Zone::find($request->location);

				if ($zone) {
					$lead->zone_id = $zone->id;
					$lead->zone = $zone->zone;

					$city = Citieslists::find($zone->city_id);
					if ($city) {
						$lead->city_id = $city->id;
						$lead->city_name = $city->city;
					}
				}

			} else {

				$city = $cityName
					? Citieslists::where('city', $cityName)->first()
					: null;

				if ($city) {
					$lead->city_id = $city->id;
					$lead->city_name = $city->city;
				} else {
					// fallback
					$lead->city_name = $cityName ?: 'none';
				}
			}


			if ($request->has('b_end')) {
				$lead->b_end = $request->input('b_end');
			}

			$mobile = ltrim($request->input('mobile'), '0');
			$mobile = trim($mobile);
			$newmobile = preg_replace('/\s+/', '', $mobile);
			$lead->mobile = $newmobile;
			$keyword = Keyword::where('keyword', $request->input('kw_text'))->first();

			if (!empty($keyword)) {
				$lead->kw_id = $keyword->id;
				$lead->kw_text = $keyword->keyword;

			} else {
				$lead->kw_id = 0;
				$lead->kw_text = $request->input('kw_text');
			}


			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;
			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
			$lead->created_by = 101;

			$checklead = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->where('city_name', $cityName)->get()->count();
			if ($checklead > 0) {
				$currentdate = date('Y-m-d');
				$lastDate = date('', strtotime($currentdate . '- 4 day'));
				$checkday = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->whereDate('created_at', '>', date_format(date_create($lastDate), 'Y-m-d'))->get()->count();

				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
					//	$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);
				}


			} else {
				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
					//	$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);

				}
			}


		}

	}


	public function saveEnquiryWithoutZone(Request $request)
	{
 
			$validator = Validator::make($request->all(), [
				'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'email' => 'required|regex:/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i',
				'phone' => 'required|numeric',
				//	'phone' 	=> 'required|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im',				
				'kw_text' => 'required',
				// 'terms' => 'accepted',
				// 'code' => 'required',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();

				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$lead = new Lead;
			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			$lead->email = $request->input('email');
			$lead->lead_form = $request->input('lead_form');
			$lead->plan = $request->input('plan');
			$lead->from_page = filter_var($request->input('from_page'), FILTER_SANITIZE_STRING);

			$citySlug = $request->input('city_id');
			$cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : null;

			if (!empty($request->location_id)) {

				$zone = Zone::find($request->location_id);

				if ($zone) {
					$lead->zone_id = $zone->id;
					$lead->zone = $zone->zone;

					$city = Citieslists::find($zone->city_id);
					if ($city) {
						$lead->city_id = $city->id;
						$lead->city_name = $city->city;
					}
				}

			} else {

				$city = $cityName
					? Citieslists::where('city', $cityName)->first()
					: null;

				if ($city) {
					$lead->city_id = $city->id;
					$lead->city_name = $city->city;
				} else {
					// fallback
					$lead->city_name = $cityName ?: 'none';
				}
			}


			 

			if ($request->frmcheck) {
				$lead->frmcheck = json_encode($request->frmcheck);
			}
			$phone = ltrim($request->input('phone'), '0');
			$phone = trim($phone);
			$newmobile = preg_replace('/\s+/', '', $phone);
			$lead->mobile = $newmobile;
			// if ($request->input(key: 'code')) {
			// 	$lead->code = $request->input(key: 'code');
			// }
			$kw_text = filter_var($request->input('kw_text'), FILTER_SANITIZE_STRING);
			$kw_text = preg_replace('/[^A-Za-z0-9]/', ' ', $kw_text);
			$kw_text = preg_replace('/\s+/', ' ', str_replace('&', '', trim($kw_text)));
			$keyword = Keyword::where('keyword', $kw_text)->first();

			if (!empty($keyword)) {
				$lead->kw_id = $keyword->id;
				$lead->kw_text = $keyword->keyword;
				$course_name = $keyword->keyword;
			} else {
				$lead->kw_id = 0;
				$lead->kw_text = $request->input('kw_text');
				$course_name = $request->input('kw_text');
			}

			$status = Status::where('name', 'New Lead')->first();
			if (!empty($status)) {
				$lead->status_id = $status->id;
				$lead->status_name = $status->name;
			}
			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('comment'))));
			$lead->created_by = 101;
			// $lead->terms = $request->terms;
			// if ($request->zone) {

			// 	$zone = Zone::find($request->zone);
			// 	$lead->zone_id = $zone->id;
			// 	$lead->zone = $zone->zone;
			// } else {
			// 	if (!empty($city->id)) {
			// 		$zone = Zone::where('city_id', $city->id)->first();
			// 		$lead->zone_id = $zone->id;
			// 		$lead->zone = $zone->zone;
			// 	}
			// }

			$today = date('Y-m-d');
			$checklead = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->where('city_name', $cityName)->whereDate('created_at', '=', date_format(date_create($today), 'Y-m-d'))->get()->count();

			$currentdate = date('Y-m-d');
			$lastDate = date('Y-m-d', strtotime($currentdate . '- 4 day'));

			$checkday = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->whereDate('created_at', '>', date_format(date_create($lastDate), 'Y-m-d'))->get()->count();

			if (!empty($checklead) && $checklead > 0) {
				return response()->json([
					'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					 
				], 200);
			} else if (!empty($checkday) && $checkday > 0) {
				$lead->duplicate = '1';
				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('comment'))));
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					//leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					], 200);
				} else {
					return response()->json([
						'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					], 200);

				}
			} else {

				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('comment'))));
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					// leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					], 200);
				} else {
					return response()->json([
						'status' => true,
					'success' => true,				 
					'message' => 'Enquiry submitted successfully'
					], 200);
				}
			}
		
	}


	 /**
     * Per-step validation rules.
     */
    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            0 => [
                'name'     => ['required', 'string', 'min:2', 'max:100'],
                'email'    => ['required', 'email:rfc', 'max:150'],
                'phone'    => ['required', 'regex:/^[\d]{10,15}$/'],
                
            ],
            1 => [
                'age'         => ['required', 'string', 'max:50'],
                'whenToStart' => ['required', 'string', 'max:50'],
				'location' => ['required', 'string', 'max:100'],
            ],
            2 => [
                'comment' => ['nullable', 'string', 'max:1000'],
            ],
            default => [],
        };
    }

    protected function validationMessages(): array
    {
        return [
            'name.required'        => 'Please enter your name.',
            'email.required'       => 'Email is required.',
            'email.email'          => 'Enter a valid email.',
            'phone.required'       => 'Phone is required.',
            'phone.regex'          => 'Enter a valid 10–15 digit phone number.',
            'location.required'    => 'Please select your city.',
            'age.required'         => 'Select your age range.',
            'whenToStart.required' => 'Select a timeline.',
        ];
    }

    /**
     * Normalize phone: strip spaces, dashes, parentheses, leading +.
     */
    protected function normalizePhone(Request $request): void
    {
        if ($request->filled('phone')) {
            $request->merge([
                'phone' => preg_replace('/\D/', '', $request->phone),
            ]);
        }
    }

    /**
     * AJAX: validate a single step.
     * POST /form/validate-step
     */
    public function validateStep(Request $request)
    {
        $this->normalizePhone($request);

        $step = (int) $request->input('step', 0);

        $validator = Validator::make(
            $request->all(),
            $this->rulesForStep($step),
            $this->validationMessages()
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        return response()->json(['success' => true]);
    }


	public function validateStep_old(Request $request)
	{

		$step = $request->step;
		//  dd($request->all());
		$rules = [];

		if ($step == 1) {
			$rules = [
				'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'email' => 'nullable|email|regex:/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i',


				'mobile' => [
					'required',
					'regex:/^(\+?[1-9]\d{1,14}|0?[6-9]\d{9})$/'
				],
				'location' => 'required',
				// 'code' => 'required',
			];
			$messages = [
				'name.required' => 'Full name is required.',
				'email.required' => 'Email is required.',
				'email.email' => 'Email is invalid.',
				'mobile.required' => 'Phone number is required.',
				'mobile.regex' => 'Please enter a valid number.',
				'location.required' => 'Your location is required.',
				'code.required' => 'Country code is required.',
			];
		}

		if ($step == 2) {
			$rules = [
				'age' => 'required',
				// 'frmcheck' => 'required|array',
				// 'frmcheck.*' => 'required',
				'plan' => 'required',
				// 'kw_text' => 'required',
				// 'experience' => 'required',
			];

			$messages = [
				'age' => 'Please select age',
				'plan' => 'Please select When you want',
				'experience' => 'Please select experience',
				'frmcheck.required' => 'Please select your experience level',
				'frmcheck.min' => 'Please select at least one option',
			];
		}

		if ($step == 3) {
			$rules = [
				'remark' => 'required|max:500',
			];

			$messages = [
				'remark' => 'Please Enter you message',
			];
		}

		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {

			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => false, 'errors' => $errorsBag], 400);
		}

		return response()->json(['status' => true]);
	}

	public function saveEnquiryContact(Request $request)
	{

		if ($request->ajax()) {

			$validator = Validator::make($request->all(), [
				'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'email' => 'required|regex:/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i',
				'mobile' => 'required|numeric',
				'subject' => 'required',


			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();

				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$lead = new Contacts;
			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			$lead->email = $request->input('email');
			$lead->mobile = $request->input('mobile');
			$lead->subject = filter_var($request->input('subject'), FILTER_SANITIZE_STRING);

			$message = filter_var($request->input('message'), FILTER_SANITIZE_STRING);
			$message = preg_replace('/[^A-Za-z0-9]/', ' ', $message);
			$message = preg_replace('/\s+/', ' ', str_replace('&', '', trim($message)));
			$lead->message = $message;


			if ($lead->save()) {

				return response()->json([
					'statusCode' => 1,
					'response' => [
						'responseCode' => 200,
						'payload' => '',
						'message' => 'Form submited successfully'
					]
				], 200);
			} else {
				return response()->json([
					'statusCode' => 1,
					'response' => [
						'responseCode' => 200,
						'payload' => '',
						'message' => 'Some Error Follow up'
					]
				], 200);

			}
		}
	}

	public function saveTwoEnquiry(Request $request)
	{

		if ($request->ajax()) {

			$validator = Validator::make(
				$request->all(),
				[
					'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:32',
					'mobile' => 'required|numeric',
					'kw_text' => 'required',
					'remark' => 'required',
					'terms' => 'required',
				],
				[
					'name' => 'Full name is required.',
					'mobile' => 'Phone no is required',
					'kw_text' => 'Service is required',
					'remark' => 'Remarks is required',
					'terms' => 'terms is required',
				]
			);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}

			$lead = new Lead;
			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			$lead->email = $request->input('email');
			$lead->lead_form = $request->input('lead_form');
			$lead->from_page = filter_var($request->input('from_page'), FILTER_SANITIZE_STRING);
			$citySlug = $request->input('city_id');
			$cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : null;

			if (!empty($request->location)) {

				if (is_numeric($request->location)) {

					$zone = Zone::find($request->location);
					if (!empty($zone)) {
						$lead->zone_id = $zone->id;
						$lead->zone = $zone->zone;

						$city = Citieslists::find($zone->city_id);


						if (!empty($city)) {
							$lead->city_id = $city->id;
							$lead->city_name = $city->city;
						}
					}
				} else {

					$city = Citieslists::where('city', $request->location)->first();
					if (!empty($city)) {
						$lead->city_id = $city->id;
						$lead->city_name = $city->city;

						$zone = Zone::where('city_id', $city->id)->first();

						if (!empty($zone)) {
							$lead->zone_id = $zone->id;
							$lead->zone = $zone->zone;

						}
					}
				}

			} else {

				$city = $cityName
					? Citieslists::where('city', $cityName)->first()
					: null;

				if (!empty($city)) {
					$lead->city_id = $city->id;
					$lead->city_name = $city->city;

					$zone = Zone::where('city_id', $city->id)->first();
					if (!empty($zone)) {
						$lead->zone_id = $zone->id;
						$lead->zone = $zone->zone;
					}

				} else {
					// fallback
					$lead->city_name = $cityName ?: 'none';
				}
			}

			if ($request->has('b_end')) {
				$lead->b_end = $request->input('b_end');
			}

			$mobile = ltrim($request->input('mobile'), '0');
			$mobile = trim($mobile);
			$newmobile = preg_replace('/\s+/', '', $mobile);
			$lead->mobile = $newmobile;
			$lead->code = $request->code;
			$kw_text = filter_var($request->input('kw_text'), FILTER_SANITIZE_STRING);
			$kw_text = preg_replace('/[^A-Za-z0-9]/', ' ', $kw_text);
			$kw_text = preg_replace('/\s+/', ' ', str_replace('&', '', trim($kw_text)));
			$keyword = Keyword::where('keyword', $kw_text)->first();

			if (!empty($keyword)) {
				$lead->kw_id = $keyword->id;
				$lead->kw_text = $keyword->keyword;

			} else {
				$lead->kw_id = 0;
				$lead->kw_text = $request->input('kw_text');
			}
			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
			$lead->age = $request->input('age');
			$lead->experience = $request->input('experience');
			$lead->plan = $request->input('plan');
			$lead->created_by = 101;
			$lead->terms = $request->terms;


			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;

			$lead->created_by = 101;

			if ($request->frmcheck) {
				$lead->frmcheck = json_encode($request->frmcheck);
			}

			$today = date('Y-m-d');
			$checklead = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->where('city_name', $cityName)->whereDate('created_at', '=', date_format(date_create($today), 'Y-m-d'))->get()->count();
			//echo "<pre>";print_r($checklead);die;
			$currentdate = date('Y-m-d');
			$lastDate = date('Y-m-d', strtotime($currentdate . '- 4 day'));

			$checkday = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->whereDate('created_at', '>', date_format(date_create($lastDate), 'Y-m-d'))->get()->count();

			if (!empty($checklead) && $checklead > 0) {
				return response()->json([
					'statusCode' => 1,
					'response' => [
						'responseCode' => 200,
						'payload' => '',
						'message' => 'Follow Up created successfully'
					]
				], 200);
			} else if (!empty($checkday) && $checkday > 0) {
				$lead->duplicate = '1';
				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					//leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);

				}
			} else {

				if ($lead->save()) {

					$followUp = new LeadFollowUp;
					$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
					$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
					$followUp->expected_date_time = date('Y-m-d H:i:s');
					$followUp->lead_id = $lead->id;
					//$followUp->remark_by =Auth::user()->id;
					$followUp->save();

					// leadassignWithoutZoneCounsellor($lead);

					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Follow Up created successfully'
						]
					], 200);
				} else {
					return response()->json([
						'statusCode' => 1,
						'response' => [
							'responseCode' => 200,
							'payload' => '',
							'message' => 'Some Error Follow up'
						]
					], 200);
				}
			}
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function autoFormSave(Request $request)
	{
		$cityname = ucwords(str_replace("-", " ", $request->input('city_id')));
		$city = Citieslists::where('city', 'LIKE', ucwords(str_replace("-", " ", $request->input('city_id'))))->first();
		$lead = new Lead;
		if (!empty($city->id)) {
			$lead->city_id = $city->id;
			$lead->city_name = $city->city;
		} else {
			if ($cityname) {
				$lead->city_name = $cityname;
			} else {
				$lead->city_name = 'none';
			}
		}
		$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
		$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
		$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
		$lead->name = $name;

		if ($request->input('email') != '') {

			$lead->email = $request->input('email');
		}
		$mobile = ltrim($request->input('mobile'), '0');
		$mobile = trim($mobile);
		$newmobile = preg_replace('/\s+/', '', $mobile);
		$lead->mobile = $newmobile;
		$lead->lead_form = $request->input('lead_form');
		$lead->from_page = filter_var($request->input('from_page'), FILTER_SANITIZE_STRING);
		$keyword = Keyword::where('keyword', 'LIKE', $request->input('kw_text'))->get();
		if (!empty($keyword)) {
			$lead->kw_id = $keyword[0]->id;
			$lead->kw_text = $keyword[0]->keyword;
			$bucketIndex = $keyword[0]->bucket;
		}
		if ($request->has('b_end')) {
			$lead->b_end = $request->input('b_end');
		}
		$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
		$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;
		$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
		$lead->created_by = '1';

		$today = date('Y-m-d');
		$checklead = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->where('city_name', $cityname)->whereDate('created_at', '=', date_format(date_create($today), 'Y-m-d'))->get()->count();

		$currentdate = date('Y-m-d');
		$lastDate = date('Y-m-d', strtotime($currentdate . '- 4 day'));

		$checkday = Lead::where('mobile', $newmobile)->where('kw_text', $request->input('kw_text'))->whereDate('created_at', '>', date_format(date_create($lastDate), 'Y-m-d'))->get()->count();

		if (!empty($checklead) && $checklead > 0) {

		} else if (!empty($checkday) && $checkday > 0) {
			$lead->duplicate = '1';
			if ($lead->save()) {

				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->lead_id = $lead->id;

				$followUp->save();
			}
		} else {

			if ($lead->save()) {

				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->lead_id = $lead->id;
				//$followUp->remark_by =Auth::user()->id;
				$followUp->save();


			}
		}
		return response()->json([
			'status' => true,
			'response' => [
				'responseCode' => 200,
				'payload' => '',
				'message' => 'Lead successfully'
			]
		], 200);


	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if ($request->ajax()) {

			$lead = new Lead;
			$citySlug = $request->input('city_id');
			$cityName = $citySlug ? ucwords(str_replace('-', ' ', $citySlug)) : null;

			if (!empty($request->location)) {

				$zone = Zone::find($request->location);

				if ($zone) {
					$lead->zone_id = $zone->id;
					$lead->zone = $zone->zone;

					$city = Citieslists::find($zone->city_id);
					if ($city) {
						$lead->city_id = $city->id;
						$lead->city_name = $city->city;
					}
				}

			} else {

				$city = $cityName
					? Citieslists::where('city', $cityName)->first()
					: null;

				if ($city) {
					$lead->city_id = $city->id;
					$lead->city_name = $city->city;
				} else {
					// fallback
					$lead->city_name = $cityName ?: 'none';
				}
			}


			$string = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
			$string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
			$name = preg_replace('/\s+/', ' ', str_replace('&', '', trim($string)));
			$lead->name = $name;
			if ($request->input('email') != '') {

				$lead->email = $request->input('email');
			}
			$lead->mobile = $request->input('mobile');
			$lead->lead_form = $request->input('lead_form');
			$keyword = Keyword::where('keyword', 'LIKE', $request->input('kw_text'))->get();
			if (!empty($keyword)) {
				$lead->kw_id = $keyword[0]->id;
				$lead->kw_text = $keyword[0]->keyword;
				$bucketIndex = $keyword[0]->bucket;
			} else {
				return response()->json(['status' => 1, 'msg' => 'Keyword not found'], 404);
			}
			if ($request->has('b_end')) {
				$lead->b_end = $request->input('b_end');
			}
			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;
			$lead->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
			$lead->created_by = '1';

			if ($lead->save()) {
				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = htmlspecialchars(strip_tags(trim($request->input('remark'))));
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->lead_id = $lead->id;
				//$followUp->remark_by =Auth::user()->id;
				$followUp->save();
				// leadassignWithoutZoneCounsellor($lead);
				return response()->json(['status' => 1, 'msg' => 'Lead added successfully'], 200);
			}

		}
	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function searchUser(Request $request)
	{
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		if ($request->wantsJson()) {
			$query = DB::table('users');
			$query = $query->select('users.id', 'users.first_name', 'users.last_name');
			$str = '';
			if ($request->input('q') != "") {
				$str = trim($request->input('q'));
				$query = $query->orWhere('users.first_name', 'LIKE', '%' . $str . '%');
				$query = $query->orWhere('users.last_name', 'LIKE', '%' . $str . '%');
			}
			$query = $query->get();
			return response()->json(['status' => 1, 'users' => $query]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function searchKWcc(Request $request)
	{
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		if ($request->wantsJson()) {
			$query = DB::table('keyword')
				->select('keyword.keyword', 'keyword.slug', 'keyword.id');
			$str = '';
			if ($request->input('q') != "") {
				$str = trim($request->input('q'));
				$query = $query->orWhere('keyword.keyword', 'LIKE', '%' . $str . '%');
				$query = $query->orderBy(DB::raw("CASE WHEN keyword.keyword LIKE '" . $str . "%' THEN 1 ELSE 2 END"));

				$query = $query->distinct()->get();
			}
			return response()->json(['status' => 1, 'areas' => $query]);
		}
	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function searchKW(Request $request)
	{

		$query = DB::table('keyword')
			->select('keyword.keyword', 'keyword.slug', 'keyword.id');
		$str = '';
		if ($request->input('search_kw') != "") {
			$str = trim($request->input('search_kw'));
			$query = $query->orWhere('keyword.keyword', 'LIKE', '%' . $str . '%');
			$query = $query->orderBy(DB::raw("CASE WHEN keyword.keyword LIKE '" . $str . "%' THEN 1 ELSE 2 END"));

			$query = $query->distinct()->get();

		}
		$html = "";
		foreach ($query as $q) {
			$html .= "<li><a href='#'><i class='fa fa-search'></i>" . trim($q->keyword) . "</a></li>";
		}
		$query = DB::table('clients')
			->select('clients.business_name');
		$str = '';
		if ($request->input('search_kw') != "") {
			$str = trim($request->input('search_kw'));
			$query = $query->orWhere('clients.business_name', 'LIKE', '%' . $str . '%');
			$query = $query->orderBy(DB::raw("CASE WHEN clients.business_name LIKE '" . $str . "%' THEN 1 ELSE 2 END"), 'DESC');
			$query = $query->distinct()->get();
		}

		foreach ($query as $q) {
			$html .= "<li><a href='#'><i class='fa fa-search'></i>" . trim($q->business_name) . "</a></li>";
		}
		return response()->json(['status' => 1, 'message' => $html]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function playwrightAutomation(Request $request)
	{
		$keyword = array(
			'ratingvalue' => '4.75',
			'ratingcount' => 'city314',
			'slug' => "playwright-automation-training-in-noida",
			'meta_title' => "Top Playwright Automation Training Institute in Noida",
			'keyword' => "playwright automation",
			'meta_keywords' => "playwright automation, Playwright Automation Training in Noida, Playwright Automation Course in Noida, Playwright Automation Classes in Noida ",
			'meta_description' => "Join the best Playwright Automation Training in Noida. A comprehensive curriculum designed for beginners and experienced. Start your tech career now.",
			'h1' => "Playwright Automation Course in Noida",
			'top_description' => "If you are planning to step into automation testing or switch from manual to automation, this Playwright Automation Training in Noida is designed to help you actually work with automation, not just learn it. Most courses teach you syntax. This one focuses on execution. You will understand how automation behaves in real projects, how scripts fail, how to debug them, and how to handle situations where things don’t work on the first attempt.",
			'bottom_description' => "Playwright Automation Training in Noida",

			'heading' => "About Playwright Automation Course",
			'courseabout' => "This Playwright Automation Course in Noida is built around real-world testing practices.
Instead of limiting learning to theory, the course takes you through:.",
			'paragraph1' => "Writing your first automation script",
			'paragraph2' => "Handling real-time execution challenges",
			'paragraph3' => "Managing test flows and failures",
			'paragraph4' => "Understanding how testing actually works in production environments",
			'paragraph5' => "",
			'paragraph6' => "",
			'h2' => 'Why Choose the Playwright Automation Course?',
			'form_type' => "form_edu",
			'faqq1' => "Do I need coding knowledge to start",
			'faqa1' => "No. Basic understanding helps, but everything is taught from scratch",
			'faqq2' => "Is this course beginner-friendly",
			'faqa2' => "Yes. It starts from the basics and gradually moves to advanced topics",
			'faqq3' => "Will I work on real projects",
			'faqa3' => "Yes. You all practice on real-world scenarios",
			'faqq4' => "Is online training available",
			'faqa4' => "Yes. Both online and offline options are available.",
			'faqq5' => "What makes this different",
			'faqa5' => "The focus is on practical implementation, not just completing topics",


		);
		$city = "noida";
		$area = "";
		return view('client.playwrightAutomation', ['keyword' => (object) $keyword, 'city' => $city, 'area' => $area]);
	}


	/**
	 * Get matches trainers based on ajax.
	 *
	 * @param  string
	 * @return JSON Object having matched course details
	 */
	public function getCountryCode(Request $request)
	{
		if ($request->ajax()) {

			$len = strlen($request->input('id'));
			if (null == $request->input('id')) {
				$countryies = Citieslists::whereIn('id', ['278', '596', '961', '428'])->get();

			} else {

				$countryies = DB::table('zones')
					->join('citylists', 'citylists.id', '=', 'zones.city_id')
					->where(function ($query) use ($request) {
						$q = $request->input('id');
						$query->where('zones.zone', 'LIKE', "%$q%")
							->orWhere('citylists.city', 'LIKE', "%$q%");
					})
					->select('zones.id as zone_id', 'zones.zone', 'citylists.city', 'zones.pincode')
					->distinct()
					->get();


			}

			$html = '<div class="resultCode"><ul>';
			if (!empty($countryies)) {

				foreach ($countryies as $data) {

					$pos = stripos($data->city, $request->input('id'));
					if ($pos >= 0) {
						$str = substr($data->city, $pos, $len);
						$strong_str = "<strong>" . $str . "</strong>";
						$final_str = str_replace($str, $strong_str, $data->city);
						$html .= '<li><a data-city="' . strtolower($data->city) . '" 
							data-area="' . strtolower($data->zone) . '">
							' . ucwords($final_str) . ', ' . ucwords($data->zone) . '
						</a>
						</li>';

					} else {

						$html .= '<li><a data-city="' . strtolower($data->city) . '">' . ucwords($data->city) . '</a>
						</li>';

					}
				}

			}

			$zones = DB::table('zones')
				->join('citylists', 'citylists.id', '=', 'zones.city_id')
				->where(function ($query) use ($request) {
					$q = $request->input('id');
					$query->where('zones.zone', 'LIKE', "%$q%")
						->orWhere('zones.pincode', 'LIKE', "%$q%");
				})
				->select('zones.id as zone_id', 'zones.zone', 'citylists.city', 'zones.pincode')
				->distinct()
				->get();


			if (!empty($zones)) {

				foreach ($zones as $zone) {

					$pos = stripos($zone->zone, $request->input('id'));
					if ($pos >= 0) {
						$str = substr($zone->zone, $pos, $len);
						$strong_str = "<strong>" . $str . "</strong>";
						$final_str = str_replace($str, $strong_str, $zone->zone);
						$html .= '<li><a data-city="' . strtolower($data->city) . '" 
							data-area="' . strtolower($data->zone) . '">
							' . ucwords($final_str) . ', ' . ucwords($data->zone) . ', ' . ucwords($data->pincode) . '
						</a>
						</li>';


						$html .= '<li><a data-city="' . strtolower($zone->city) . '" 
							data-area="' . strtolower($zone->zone) . '">
							' . ucwords($final_str) . ', ' . ucwords($zone->zone) . ', ' . ucwords($zone->pincode) . '
						</a>
						</li>';


					} else {

						$html .= '<li><a data-city="' . strtolower($zone->city) . '">' . ucwords($zone->zone) . ', ' . ucwords($zone->city) . '></a></li>';

					}
				}

			}


			$areas = DB::table('citylists');
			$areas = $areas->join('zones', 'citylists.id', '=', 'zones.city_id');
			$areas = $areas->join('areas', 'zones.id', '=', 'areas.zone_id');

			$areas = $areas->where(function ($query) use ($request) {
				$query->where('area', 'LIKE', '%' . $request->input('id') . '%');
			});

			$areas = $areas->get();

			if (!empty($areas)) {

				foreach ($areas as $area) {

					$pos = stripos($area->area, $request->input('id'));
					if ($pos >= 0) {
						$str = substr($area->area, $pos, $len);
						$strong_str = "<strong>" . $str . "</strong>";
						$final_str = str_replace($str, $strong_str, $area->area);

						$html .= '<li><a data-city="' . strtolower($area->city) . '" data-area="" data-zone="">' . ucwords($final_str) . ', ' . ucwords($area->city) . '</a></li>';
					} else {
						$html .= '<li><a data-city="' . strtolower($area->city) . '">' . ucwords($area->area) . ', ' . ucwords($area->city) . '</a></li>';
					}
				}
			}
			$html .= '</ul></div>';
			echo $html;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getKWList(Request $request)
	{
		$kwdsList = Keyword::where('child_category_id', $request->input('child_cat_id'))
			->where('parent_category_id', $request->input('parent_cat_id'))
			->select('keyword')
			->distinct()
			->get();
		return response()->json(['status' => 1, 'message' => $kwdsList]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getCityKWList(Request $request)
	{
		$citiesList = DB::table('assigned_kwds')
			->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
			->select('citylists.city')
			->distinct()
			->get();
		return response()->json(['status' => 1, 'message' => $citiesList]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function callHtml($html)
	{
		if (view()->exists('client.html.' . $html)) {
			return view('client.html.' . $html);
		} else {
			return view('404');
		}
	}

	 

	/**
	 * Display a listing of the client categories resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function cityCategories(Request $request, $city, $part_slug)
	{
		$part_id = ParentCategory::where('parent_slug', $part_slug)->first();
		$subcategory = DB::table('keyword')
			->select('keyword.*', 'keyword.id as key_id', 'keyword.faqq1', 'keyword.faqa1', 'keyword.faqq2', 'keyword.faqa2', 'keyword.faqq3', 'keyword.faqa3', 'keyword.faqq4', 'keyword.faqa4', 'keyword.faqq5', 'keyword.faqa5', 'keyword.meta_title', 'keyword.meta_description', 'keyword.meta_keywords', 'keyword.top_description', 'keyword.bottom_description', 'keyword.ratingvalue', 'keyword.ratingcount')
			->where('keyword.parent_category_id', $part_id->id)->get();

		$cateoryClient = DB::table('clients')
			->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
			->leftJoin(DB::raw('(SELECT SUM(rating) AS rating,comment_client_ID,COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
			->select('clients.*', 'citylists.city', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count')
			->where('citylists.city', 'LIKE', $city)
			->where('clients.active_status', '1')
			->where('assigned_kwds.parent_cat_id', $part_id->id)
			->orderByRaw("
				CASE clients.client_type
				WHEN 'platinum' THEN 1
				WHEN 'diamond' THEN 2
				WHEN 'gold' THEN 3
				WHEN 'silver' THEN 4
				ELSE 5
				END
				")

			->groupBy('client_id')
			->get();

		return view('client.courseprogram_client', ['cateoryClient' => $cateoryClient, 'subcategory' => $subcategory, 'part_id' => $part_id, 'city' => $city]);
	}
	/**
	 * Display a listing of the client categories resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function subcategories(Request $request, $city, $part_slug, $child_slug)
	{
		$part_id = ParentCategory::where('parent_slug', $part_slug)->first();
		$child_id = ChildCategory::where('child_slug', $child_slug)->first();

		$subcategory = DB::table('child_category')
			->join('parent_category', 'child_category.parent_category_id', '=', 'parent_category.id')
			->where('parent_category_id', $part_id->id)
			->select('parent_category.*', 'child_category.*')->limit(24)
			->get();


		$kwdsList = Keyword::where('child_category_id', $child_id->id)
			->where('parent_category_id', $part_id->id)
			->select('keyword')
			->distinct()
			->get();


		$subCateoryClient = DB::table('clients')
			->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
			->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
			->rightJoin(DB::raw('(SELECT SUM(rating) AS rating,comment_client_ID,COUNT(comment_ID) AS comment_count,comment_content  FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
			//->join('parent_category','assigned_kwds.parent_cat_id','=','parent_category.id')	

			->select('clients.id', 'clients.business_name', 'clients.business_slug', 'clients.website', 'clients.city', 'clients.logo', 'assigned_kwds.*', 'c.rating', 'c.comment_count', 'c.comment_content')
			->where('assigned_kwds.parent_cat_id', $part_id->id)
			->where('citylists.city', 'LIKE', $city)
			->where('assigned_kwds.child_cat_id', $child_id->id)
			->groupBy('client_id')
			->get();


		$subCateoryClient = DB::table('clients')
			->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
			->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
			->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
			->leftJoin(DB::raw('(SELECT SUM(rating) AS rating,comment_client_ID,COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
			->select('clients.*', 'citylists.city', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count')
			->where('citylists.city', 'LIKE', $city)
			->where('clients.active_status', '1')
			->where('assigned_kwds.child_cat_id', $child_id->id)
			->orderByRaw("
				CASE clients.client_type
				WHEN 'platinum' THEN 1
				WHEN 'diamond' THEN 2
				WHEN 'gold' THEN 3
				WHEN 'silver' THEN 4
				ELSE 5
				END
				")
			->groupBy('client_id')
			->get();
		$clientCategories = ClientCategory::all();
		return view('client.subcourseprogram_client', ['subCateoryClient' => $subCateoryClient, 'subcategory' => $subcategory, 'part_id' => $part_id, 'child_id' => $child_id, 'kwdsList' => $kwdsList, 'city' => $city]);
	}

	 

	/**
	 * Display a listing of the clients of categories resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function showCityOrService(Request $request, $city = null)
	{
		$city = strtolower(str_replace(' ', '-', trim($city)));


		try {

			$parent = ParentCategory::where('parent_slug', $city)->first();
			$child = ChildCategory::where('child_slug', $city)->first();
			$clientCheck = Client::where('city', ucwords(str_replace("-", " ", $city)))->first();
			$keywordCheck = Keyword::where('slug', $city)->first();
			$cityCheck = Citieslists::where('city_slug', $city)->first();

			if (!$parent && !$child && !$clientCheck && !$keywordCheck && !$cityCheck) {
				return response()->view('client.error410', [], 410);
			}

			$clientLists = Client::where('logo', '<>', '')->where('business_intro', '<>', '')->limit(12)->get();
			$checkcity = Client::where('logo', '<>', '')
				->where('city', ucwords(str_replace("-", " ", $city)))
				->where('active_status', '1')
				->whereNull('deleted_at')
				->get();

			if ($checkcity->isNotEmpty()) {
				$cityclients = $checkcity;
				$clientBanner = ChildCategory::whereNotNull('child_banner')->where('child_banner', '!=', '')->first();
				$keyword = "";
				return view('client.cityclients', ['cityclients' => $cityclients, 'clientBanner' => $clientBanner, 'keyword' => $keyword]);
			}

			// --- shared queries ---
			$reviewsClientsList = DB::table('clients')
				->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->rightJoin(DB::raw('(SELECT SUM(rating) AS rating,comment_client_ID,COUNT(comment_ID) AS comment_count,comment_content FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
				->select('clients.*', 'citylists.city', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count', 'c.comment_content')
				->where('keyword.slug', $city)
				->groupBy('client_id')
				->get();

			$keywordlist = DB::table('keyword')
				->join('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
				->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
				->select('keyword.*', 'parent_category.*', 'child_category.*', 'keyword.id as key_id', 'keyword.faqq1', 'keyword.faqa1', 'keyword.faqq2', 'keyword.faqa2', 'keyword.faqq3', 'keyword.faqa3', 'keyword.faqq4', 'keyword.faqa4', 'keyword.faqq5', 'keyword.faqa5', 'keyword.meta_title', 'keyword.meta_description', 'keyword.meta_keywords', 'keyword.top_description', 'keyword.bottom_description', 'keyword.ratingvalue', 'keyword.ratingcount', 'keyword.child_category_id')
				->groupBy('child_category.child_slug')
				->where('parent_category.parent_slug', $city)->get();


			$clientskeyword = DB::table('clients')
				->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
				->join('assigned_zones', 'clients.id', '=', 'assigned_zones.client_id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->join('citylists', 'assigned_zones.city_id', '=', 'citylists.id')
				->leftJoin(DB::raw('(SELECT SUM(rating) AS rating, comment_client_ID, COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
				->select('clients.*', 'citylists.city', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count', 'assigned_zones.*', 'keyword.slug')
				->where('keyword.slug', $city)
				->orderByRaw("
					CASE clients.client_type
					WHEN 'platinum' THEN 1
					WHEN 'diamond' THEN 2
					WHEN 'gold' THEN 3
					WHEN 'silver' THEN 4
					ELSE 5
					END
					")
				->groupBy('client_id')
				->get();



			// --- 2. Check parent category ---
			$parentCategories = DB::table('keyword')
				->join('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
				->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
				->select('keyword.*', 'parent_category.*', 'child_category.*', 'parent_category.id as key_id', 'parent_category.faqq1', 'parent_category.faqa1', 'parent_category.faqq2', 'parent_category.faqa2', 'parent_category.faqq3', 'parent_category.faqa3', 'parent_category.faqq4', 'parent_category.faqa4', 'parent_category.faqq5', 'parent_category.faqa5', 'parent_category.meta_title', 'parent_category.meta_description', 'parent_category.meta_keywords', 'parent_category.top_description', 'parent_category.bottom_description', 'parent_category.ratingvalue', 'parent_category.ratingcount', 'keyword.child_category_id')
				->groupBy('child_category.child_slug')
				->where('parent_category.parent_slug', $city)->first();

			if (!empty($parentCategories)) {
				$clientskeyword = DB::table('clients')
					->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
					->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
					->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
					->join('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
					->leftJoin(DB::raw('(SELECT SUM(rating) AS rating,comment_client_ID,COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
					->select('clients.*', 'citylists.city', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count', 'keyword.*')
					->where('parent_category.parent_slug', $city)
					->orderByRaw("CASE clients.client_type WHEN 'platinum' THEN 1 WHEN 'diamond' THEN 2 WHEN 'gold' THEN 3 WHEN 'silver' THEN 4 ELSE 5 END")
					->groupBy('client_id')
					->get();

				return view('client.parentKeyword', ['clientskeyword' => $clientskeyword, 'keyword' => $parentCategories, 'reviewsClientsList' => $reviewsClientsList, 'clientLists' => $clientLists, 'city' => $city, 'keywordlist' => $keywordlist]);
			}

			// --- 3. Check child category ---
			$childCategories = DB::table('keyword')
				->join('parent_category', 'keyword.parent_category_id', '=', 'parent_category.id')
				->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
				->select('keyword.*', 'parent_category.*', 'child_category.*', 'child_category.id as key_id', 'child_category.faqq1', 'child_category.faqa1', 'child_category.faqq2', 'child_category.faqa2', 'child_category.faqq3', 'child_category.faqa3', 'child_category.faqq4', 'child_category.faqa4', 'parent_category.faqq5', 'child_category.faqa5', 'child_category.meta_title', 'child_category.meta_description', 'child_category.meta_keywords', 'child_category.top_description', 'parent_category.bottom_description', 'child_category.ratingvalue', 'child_category.ratingcount', 'keyword.child_category_id')
				->where('child_category.child_slug', $city)->first();

			if (!empty($childCategories)) {
				$clientskeyword = DB::table('clients')
					->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
					->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
					->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
					->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
					->leftJoin(DB::raw('(SELECT SUM(rating) AS rating,comment_client_ID,COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
					->select('clients.*', 'citylists.city', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count', 'keyword.*')
					->where('child_category.child_slug', $city)
					->orderByRaw("CASE clients.client_type WHEN 'platinum' THEN 1 WHEN 'diamond' THEN 2 WHEN 'gold' THEN 3 WHEN 'silver' THEN 4 ELSE 5 END")
					->groupBy('client_id')
					->get();

				return view('client.childKeyword', ['clientskeyword' => $clientskeyword, 'keyword' => $childCategories, 'reviewsClientsList' => $reviewsClientsList, 'city' => $city, 'keywordlist' => $keywordlist]);
			}

			// --- 4. Check keyword slug (exact) ---
			$keyword = DB::table('keyword')
				->join('child_category', 'keyword.child_category_id', '=', 'child_category.id')
				->join('parent_category', 'child_category.parent_category_id', '=', 'parent_category.id')
				->select('keyword.*', 'child_category.*', 'parent_category.*', 'keyword.id as key_id', 'keyword.faqq1', 'keyword.faqa1', 'keyword.faqq2', 'keyword.faqa2', 'keyword.faqq3', 'keyword.faqa3', 'keyword.faqq4', 'keyword.faqa4', 'keyword.faqq5', 'keyword.faqa5', 'keyword.meta_title', 'keyword.meta_description', 'keyword.meta_keywords', 'keyword.top_description', 'keyword.bottom_description', 'keyword.ratingvalue', 'keyword.ratingcount', 'keyword.child_category_id', 'child_category.child_slug', 'keyword.heading', 'keyword.courseabout', 'keyword.paragraph1', 'keyword.paragraph2', 'keyword.paragraph3', 'keyword.paragraph4', 'keyword.paragraph5', 'keyword.paragraph6')
				->where('keyword.slug', $city)
				->first();

				dd($keyword);
//  $bgImage    = $kwData['category_banner'] ?? '/computer-courses-training.jpg';


			if (!empty($keyword)) {
				return view('client.searchkeyword', ['clientskeyword' => $clientskeyword, 'keyword' => $keyword, 'reviewsClientsList' => $reviewsClientsList, 'clientLists' => $clientLists, 'city' => $city]);
			}

			// --- 5. Check business slug ---
			$clients = Client::where('business_slug', $city)->where('logo', '<>', '')->get();

			if ($clients->count() > 0) {
				$client = $clients->first();
				$cities = Citieslists::select('id', 'city','city_slug')->get();
				$clientLists = Client::where('logo', '<>', '')->where('business_intro', '<>', '')->where('city', 'noida')->where('active_status', '1')->limit(12)->get();

				$comments = Comment::where('comment_client_ID', $client->id)->where('comment_approved', 1)->orderBy('created_at', 'desc')->paginate(10);
				$sum = Comment::where('comment_client_ID', $client->id)->where('comment_approved', 1)->sum('rating');
				$count = Comment::where('comment_client_ID', $client->id)->where('comment_approved', 1)->count();
				$avgRating = $count != 0 ? ($sum / ($count * 5)) * 5 : 0;

				$graphQuery = Comment::select(DB::raw('*'))
					->from(DB::raw('(SELECT COUNT(*) as count, SUM(`rating`) as sum_rating, MONTH(DATE(`created_at`)) as month, DATE(`created_at`) as created_at FROM `comments` WHERE `comment_client_ID`=' . $client->id . ' AND `comment_approved`=1 GROUP BY MONTH(DATE(`created_at`)) ORDER BY created_at desc LIMIT 0,3) AS temp'))
					->orderBy('created_at')->get();

				$barGraphQuery = Comment::select(DB::raw('*'))
					->from(DB::raw('(SELECT COUNT(*) as count, SUM(`rating`) as sum_rating, rating FROM `comments` WHERE `comment_client_ID`=' . $client->id . ' AND `comment_approved`=1 GROUP BY `rating`) AS temp'))
					->orderBy('rating', 'desc')->get();

				$assignedKwds = DB::table('assigned_kwds')
					->join('keyword', 'keyword.id', '=', 'assigned_kwds.kw_id')
					->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
					->join('child_category', 'child_category.id', '=', 'assigned_kwds.child_cat_id')
					->select('keyword.keyword', 'keyword.slug', 'citylists.city', 'child_category.child_category as child_category_name')
					->where('assigned_kwds.client_id', '=', $client->id)
					->groupBy('kw_id')->get();

				$assignedCity = DB::table('assigned_kwds')
					->join('keyword', 'keyword.id', '=', 'assigned_kwds.kw_id')
					->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
					->join('child_category', 'child_category.id', '=', 'assigned_kwds.child_cat_id')
					->select('keyword.keyword', 'keyword.slug', 'citylists.city', 'child_category.child_category as child_category_name')
					->where('assigned_kwds.client_id', '=', $client->id)
					->groupBy('assigned_kwds.city_id')->get();

				return view('client.client-detail', ['client' => $client, 'cities' => $cities, 'comments' => $comments, 'count' => $count, 'sum' => $sum, 'avgRating' => number_format($avgRating, 1, '.', ''), 'graphQuery' => $graphQuery, 'barGraphQuery' => $barGraphQuery, 'assignedKwds' => $assignedKwds, 'clientLists' => $clientLists, 'clients' => $clients, 'assignedCity' => $assignedCity]);
			}

			// ✅ FALLBACK: nothing matched anywhere — show default clients (lic not null)
			$clientBanner = ChildCategory::whereNotNull('child_banner')->where('child_banner', '!=', '')->first();
			$keyword = "";
			return view('client.cityclients', ['cityclients' => $checkcity, 'clientBanner' => $clientBanner, 'keyword' => $keyword]);

		} catch (\Exception $e) {
			return response()->view('client.error410', [], 410);
		}
	}

	/**
	 * Subscribe to our newsletter
	 *
	 */
	public function newsletter(Request $request)
	{
		try {
			if (null == $request->input('email')) {
				throw new Exception("Enter valid email address");
			}
		} catch (\Exception $e) {
			return response()->json(['status' => 0, 'message' => $e->getMessage()]);
		}
		$email = $request->input('email');
		Mail::send('emails.newsletter', ['email' => $email], function ($m) use ($email) {
			$m->from('info@quickdials.com', 'QuickDials');
			$m->to('info@quickdials.com', 'QuickDials')->subject('Newsletter Subscription');
		});

		return response()->json(['status' => 1, 'message' => 'Successfully subscribed to our newsletter']);
	}


	public function addLadsss(Request $request)
	{
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
	}

	public function businessServices(Request $request)
	{
		 

// ── API fetch (cached 1 hour) ────────────────────────────────────────
        $apiData = Cache::remember('business_services', 3600, function () {
            try {
                $res = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/business-services');
                return $res->successful() ? $res->json('data', []) : [];
            } catch (\Exception $e) {
                \Log::error('BusinessServices API: ' . $e->getMessage());
                return [];
            }
        });
 
        // ── Static data ──────────────────────────────────────────────────────
        $heroStats = [
            ['value' => '350+',  'label' => 'Register Business'],
            ['value' => '8000+', 'label' => 'Business Keyword'],
            ['value' => '200+',  'label' => 'Years'],
            ['value' => '20+',   'label' => 'Countries'],
        ];
 
        
 
        $featured = [
            ['name' => 'TechAxis IT Solutions', 'category' => 'Web Development',   'city' => 'Delhi',     'rating' => 4.8, 'reviews' => 312],
            ['name' => 'BrightMinds Coaching',  'category' => 'IIT JEE Coaching',  'city' => 'Mumbai',    'rating' => 4.6, 'reviews' => 189],
            ['name' => 'GreenLeaf Ayurveda',    'category' => 'Ayurvedic Clinic',   'city' => 'Bangalore', 'rating' => 4.9, 'reviews' => 97],
            ['name' => 'StyleCraft Interiors',  'category' => 'Interior Design',    'city' => 'Hyderabad', 'rating' => 4.7, 'reviews' => 243],
        ];
 
        $sidebarStats = [
            ['icon' => 'building', 'val' => '350+',  'label' => 'Businesses'],
            ['icon' => 'search',   'val' => '8000+', 'label' => 'Keywords'],
            ['icon' => 'award',    'val' => '200+',  'label' => 'Years Exp.'],
            ['icon' => 'globe',    'val' => '20+',   'label' => 'Countries'],
        ];
 
        // Merge API data over static defaults if available
        $featuredFromApi = $apiData['featured']          ?? [];
        $statsFromApi    = $apiData['stats']             ?? [];
        $categorySections    = $apiData['businessServices']             ?? [];
 

 $category = array_slice($categorySections, 1, 5);
 $featuredCategory = array_slice($categorySections, 1, 5);

 
        if (!empty($featuredFromApi)) $featured    = $featuredFromApi;
        if (!empty($statsFromApi))    $heroStats   = $statsFromApi;
 
        return view('client.businessServices', compact(
            'heroStats', 'categorySections', 'featured', 'featuredCategory','sidebarStats', 'category'
        ));


 
	}



	public function category(Request $request)
	{
		 
 
            $data = Cache::remember('category_page_data', 3600, function () {
            $response = Http::timeout(10)->withoutVerifying()->get('https://api.quickdials.com/api/website/getCategories');
 
            if ($response->successful()) {
                return $response->json('data', []);
            }
 
            return [];
        });
 
        $categories = $data['categoryList'] ?? [];
        $childs     = $data['childs']       ?? [];
        
 
 
        return view('client.category', compact('categories', 'childs'));



	}
	public function child(Request $request)
	{
		       
        $data = Cache::remember('child_keyword_page', 3600, function () {
            try {
                $res = Http::timeout(10)->withoutVerifying()
                    ->get('https://api.quickdials.com/api/website/getChild');
                return $res->successful() ? $res->json('data', []) : [];


            } catch (\Exception $e) {
                \Log::error('getChild API: ' . $e->getMessage());
                return [];
            }
        });
 
        $childs  = $data['childsList'] ?? [];
        $courses = $data['keywords']   ?? [];
//   dd($data);
        return view('client.child', compact('childs', 'courses'));
 	}

	public function categories(Request $request, $slug)
	{



	$cacheKey = 'category_slug_' . md5($slug);
 
        $response = Cache::remember($cacheKey, 3600, function () use ($slug) {
            $res = Http::timeout(10)->withoutVerifying()
                ->get('https://api.quickdials.com/api/website/searchCategories', [
                    'category-slug' => $slug,
                ]);
 
            return $res->successful() ? $res->json() : null;
        });
//  dd($response);
        if (!$response) {
            abort(404);
        }
 
        /* ── extract data (mirrors the Next.js component) ── */
        $kwData       = $response['data']['keyword']      ?? [];
        $categoryList = $response['data']['categoryList'] ?? [];
 
        $keyword          = $kwData['parent_category']   ?? '';
        $childCategory    = $kwData['parent_category']   ?? '';
        $childSlug        = $kwData['parent_slug']       ?? '';
        $topDescription   = strip_tags($kwData['top_description']    ?? '');
        $bottomDescription= strip_tags($kwData['bottom_description'] ?? '');
        $ratingCount      = $kwData['ratingcount']       ?? 0;
        $ratingValue      = $kwData['ratingvalue']       ?? 4.8;
        $bgImage          = $kwData['category_banner']   ?? '/computer-courses-training.jpg';
        $metaTitle        = $kwData['meta_title']        ?? $keyword;
        $metaDescription  = $kwData['meta_description']  ?? '';
 
        /* star image map */
        $starMap = [
            0 => 'star_1.png', 2 => 'star_2.png', 3 => 'star_3.png',
            3.5 => 'star_3.5.png', 4 => 'star_4.png', 4.5 => 'star_4.5.png',
            4.75 => 'star_4.75.png', 5 => 'star_5.png',
        ];
        $stars = $starMap[$ratingValue] ?? 'star_4.5.png';
 
        /* category colour palette (index-based, mirrors Next.js CAT_STYLE) */
        $catColors = [
            '#1a5276','#1a6496','#4a235a','#b7770d','#0b3d5e',
            '#145a32','#2c3e50','#154360','#7b241c','#117a65',
            '#145a32','#784212','#1e8449','#1b4332',
        ];
 
        return view('client.category-slug', compact(
            'slug', 'keyword', 'childCategory', 'childSlug',
            'topDescription', 'bottomDescription',
            'ratingCount', 'ratingValue', 'stars', 'bgImage',
            'categoryList', 'catColors',
            'metaTitle', 'metaDescription'
        ));
    



		// $parentCategories = ParentCategory::get();
		// $childCategories = ChildCategory::get();
		// $businessServices = DB::table('parent_category')
		// 	->join('child_category', 'child_category.parent_category_id', '=', 'parent_category.id')
		// 	->select('parent_category.*', 'child_category.*')
		// 	->where('parent_category.parent_slug', $slug)
		// 	->groupBy('child_slug')
		// 	->orderBy('child_category', 'asc')
		// 	->get();


		// $keyword = DB::table('parent_category')->where('parent_slug', $slug)->first();

		// if (!empty($keyword)) {



		// 	$clientsList = DB::table('clients')
		// 		->join('assigned_kwds', 'clients.id', '=', 'assigned_kwds.client_id')
		// 		->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
		// 		->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
		// 		->leftJoin(DB::raw('(SELECT SUM(rating) AS rating,comment_client_ID,COUNT(comment_ID) AS comment_count FROM comments GROUP BY comment_client_ID) c'), 'c.comment_client_ID', '=', 'clients.id')
		// 		->select('clients.*', 'citylists.city', 'assigned_kwds.sold_on_position', 'c.rating', 'c.comment_count')
		// 		->where('assigned_kwds.parent_cat_id', '=', $keyword->id)
		// 		->orderByRaw("
		// 		CASE clients.client_type
		// 		WHEN 'platinum' THEN 1
		// 		WHEN 'diamond' THEN 2
		// 		WHEN 'gold' THEN 3
		// 		WHEN 'silver' THEN 4
		// 		ELSE 5
		// 		END
		// 		")

		// 		->groupBy('client_id')
		// 		->get();
		// 	$city = "";
		// 	return view('client.category', ['businessServices' => $businessServices, 'parentCategories' => $parentCategories, 'childCategories' => $childCategories, 'keyword' => $keyword, 'clientsList' => $clientsList, 'city' => $city]);
		// } else {

		// 	return response()->view('client.errorpage', [], 404);

		// }





	}



	public function childSlus(Request $request, $child_slug)
	{
		 

	$cacheKey = 'category_slug_' . md5($child_slug);
 
        $response = Cache::remember($cacheKey, 3600, function () use ($child_slug) {
            $res = Http::timeout(10)->withoutVerifying()
                ->get('https://api.quickdials.com/api/website/searchChild', [
                    'child-slug' => $child_slug,
                ]);
 
            return $res->successful() ? $res->json() : null;
        });
//  dd($response);
        if (!$response) {
            abort(404);
        }
 
        /* ── extract data (mirrors the Next.js component) ── */
        $kwData       = $response['data']['keyword']      ?? [];
        $childLists = $response['data']['childLists'] ?? [];
 
        $keyword          = $kwData['child_category']   ?? '';
        $childCategory    = $kwData['child_category']   ?? '';
        $childSlug        = $kwData['child_slug']       ?? '';
        $topDescription   = strip_tags($kwData['top_description']    ?? '');
        $bottomDescription= strip_tags($kwData['bottom_description'] ?? '');
        $ratingCount      = $kwData['ratingcount']       ?? 0;
        $ratingValue      = $kwData['ratingvalue']       ?? 4.8;
        $bgImage          = $kwData['category_banner']   ?? '/computer-courses-training.jpg';
        $metaTitle        = $kwData['meta_title']        ?? $keyword;
        $metaDescription  = $kwData['meta_description']  ?? '';
 
        /* star image map */
        $starMap = [
            0 => 'star_1.png', 2 => 'star_2.png', 3 => 'star_3.png',
            3.5 => 'star_3.5.png', 4 => 'star_4.png', 4.5 => 'star_4.5.png',
            4.75 => 'star_4.75.png', 5 => 'star_5.png',
        ];
        $stars = $starMap[$ratingValue] ?? 'star_4.5.png';
 
        /* category colour palette (index-based, mirrors Next.js CAT_STYLE) */
        $catColors = [
            '#1a5276','#1a6496','#4a235a','#b7770d','#0b3d5e',
            '#145a32','#2c3e50','#154360','#7b241c','#117a65',
            '#145a32','#784212','#1e8449','#1b4332',
        ];
 
        return view('client.child-slug', compact(
            'child_slug', 'keyword', 'childCategory', 'childSlug',
            'topDescription', 'bottomDescription',
            'ratingCount', 'ratingValue', 'stars', 'bgImage',
            'childLists', 'catColors',
            'metaTitle', 'metaDescription'
        ));
    
	}

	public function weddingPannel(Request $request)
	{
		 $stats = [
            ['value' => '10,000+', 'label' => 'Happy Couples'],
            ['value' => '500+',    'label' => 'Verified Vendors'],
            ['value' => '4.9★',   'label' => 'Avg Rating'],
            ['value' => '50+',    'label' => 'Cities'],
        ];
 
        $categories = [
            ['name' => 'Banquet Halls',     'img' => '/images/wedding/banquet.jpg'],
            ['name' => 'Decor & Flowers',   'img' => '/images/wedding/decor.jpg'],
            ['name' => 'Invitation Cards',  'img' => '/images/wedding/invitation.jpg'],
            ['name' => 'Caterers & Food',   'img' => '/images/wedding/catering.jpg'],
            ['name' => 'Trousseau Packing', 'img' => '/images/wedding/trousseau.jpg'],
            ['name' => 'Photography',       'img' => '/images/wedding/photography.jpg'],
            ['name' => 'Mehendi Artists',   'img' => '/images/wedding/mehendi.jpg'],
            ['name' => 'Musicians & DJ',    'img' => '/images/wedding/music.jpg'],
            ['name' => 'Choreography',      'img' => '/images/wedding/choreo.jpg'],
            ['name' => 'Wedding Cakes',     'img' => '/images/wedding/cake.jpg'],
        ];
 
        $brideCategories = [
            ['name' => 'Makeup Artists',    'img' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=400&h=300&fit=crop'],
            ['name' => 'Mehendi Artists',   'img' => 'https://images.unsplash.com/photo-1583391733981-8498408ee54a?w=400&h=300&fit=crop'],
            ['name' => 'Bridal Wear',       'img' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=400&h=300&fit=crop'],
            ['name' => 'Stage Decor',       'img' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400&h=300&fit=crop'],
            ['name' => 'Trousseau Packing', 'img' => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=400&h=300&fit=crop'],
            ['name' => 'South Rituals',     'img' => 'https://images.unsplash.com/photo-1583939411023-14783179e581?w=400&h=300&fit=crop'],
            ['name' => 'Bridal Jewellery',  'img' => 'https://images.unsplash.com/photo-1601121141499-c88a7a935e00?w=400&h=300&fit=crop'],
            ['name' => 'Invitation Cards',  'img' => 'https://images.unsplash.com/photo-1523438885200-e635ba2c371e?w=400&h=300&fit=crop'],
            ['name' => 'Honeymoon Planning','img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&h=300&fit=crop'],
        ];
 
        $groomCategories = [
            ['name' => 'Wedding Suit',      'img' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=400&h=300&fit=crop'],
            ['name' => 'Mehendi Artists',   'img' => 'https://images.unsplash.com/photo-1583391733981-8498408ee54a?w=400&h=300&fit=crop'],
            ['name' => 'Sherwani & Wear',   'img' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=400&h=300&fit=crop'],
            ['name' => 'Groom Entry',       'img' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop'],
            ['name' => 'South Rituals',     'img' => 'https://images.unsplash.com/photo-1583939411023-14783179e581?w=400&h=300&fit=crop'],
            ['name' => 'North Rituals',     'img' => 'https://images.unsplash.com/photo-1594552072238-b8a33785b6cd?w=400&h=300&fit=crop'],
            ['name' => 'Grooming & Hair',   'img' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=400&h=300&fit=crop'],
            ['name' => 'Dhol & Band',       'img' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=400&h=300&fit=crop'],
            ['name' => 'Pre-Wedding Shoot', 'img' => 'https://images.unsplash.com/photo-1537633552985-df8429e8048b?w=400&h=300&fit=crop'],
        ];
 
        $venues = [
            ['name' => 'The Taj Mahal Palace', 'location' => 'Colaba, Mumbai',       'rating' => 4.9, 'reviews' => 124, 'price' => '₹₹₹₹', 'img' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=700&h=500&fit=crop'],
            ['name' => 'JW Marriott Juhu',     'location' => 'Juhu, Mumbai',         'rating' => 4.8, 'reviews' => 98,  'price' => '₹₹₹₹', 'img' => 'https://images.unsplash.com/photo-1464207687429-7505649dae38?w=700&h=500&fit=crop'],
            ['name' => 'Sahara Star',          'location' => 'Vile Parle, Mumbai',   'rating' => 4.7, 'reviews' => 156, 'price' => '₹₹₹',  'img' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=700&h=500&fit=crop'],
            ['name' => 'The Leela',            'location' => 'Andheri, Mumbai',      'rating' => 4.8, 'reviews' => 112, 'price' => '₹₹₹₹', 'img' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=700&h=500&fit=crop'],
            ['name' => 'ITC Maratha',          'location' => 'Andheri East, Mumbai', 'rating' => 4.6, 'reviews' => 84,  'price' => '₹₹₹',  'img' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=700&h=500&fit=crop'],
        ];
 
        $steps = [
            ['number' => '01', 'icon' => '🔍', 'title' => 'Choose Your Dream',    'desc' => 'Browse thousands of venues, vendors, and wedding professionals across India. Filter by budget, location, and style to find your perfect match.'],
            ['number' => '02', 'icon' => '📅', 'title' => 'Plan with Experts',    'desc' => 'Our dedicated wedding planners work closely with you to craft every detail — from invitations to reception — ensuring nothing is left to chance.'],
            ['number' => '03', 'icon' => '❤️', 'title' => 'Celebrate Forever',   'desc' => 'Step into the most magical day of your life, knowing every detail has been thoughtfully arranged. Focus on love — we handle the rest.'],
        ];
 
        $testimonials = [
            ['name' => 'Priya & Rahul Sharma',   'location' => 'Mumbai',    'date' => 'December 2024', 'rating' => 5, 'text' => 'Shaadi6 made our dream wedding a reality. From finding the perfect venue at The Taj to coordinating with 15 different vendors seamlessly — every moment was magical.', 'avatar' => 'PR', 'grad' => 'from-pink-400 to-red-500',    'package' => 'Royal Package'],
            ['name' => 'Ananya & Vikram Mehta',  'location' => 'Delhi',     'date' => 'October 2024',  'rating' => 5, 'text' => 'From the mehendi ceremony to the reception, everything was perfect. Our wedding planner was always available, incredibly organized, and made us feel calm throughout.',  'avatar' => 'AV', 'grad' => 'from-amber-400 to-orange-500', 'package' => 'Premium Package'],
            ['name' => 'Deepa & Arjun Nair',     'location' => 'Bangalore', 'date' => 'February 2025', 'rating' => 5, 'text' => 'We had no idea how to plan a wedding for 400 guests. Shaadi6 took care of everything — venue, catering, flowers, even the honeymoon. Most stress-free experience ever.',  'avatar' => 'DA', 'grad' => 'from-purple-400 to-pink-500',  'package' => 'Royal Package'],
        ];
 
        $prewedding = [
            'Wedding Astrologers','Marriage Certificate Agents','Jewellery Showrooms',
            'Readymade Garments','Haldi Stage Decors','Wedding Card Printers',
            'Hotels','Honeymoon Tour Packages',
        ];
 
        $bigDay = [
            'Stage Decorators','Wedding Caterers','Jewellery Showrooms','DJ Services',
            'Wedding Bands','Bridal Makeup Artists','Wedding Choreographers','Party Organisers',
        ];
 
        return view('client.wedding-planning', compact(
            'stats','categories','brideCategories','groomCategories',
            'venues','steps','testimonials','prewedding','bigDay'
        ));
		 

	}




	public function getZones($city_id)
	{

		$zones = DB::table('zones');
		$zones = $zones->join('citylists', 'citylists.id', '=', 'zones.city_id');
		$zones = $zones->where('citylists.city', $city_id);
		$zones = $zones->get();

		return response()->json($zones);
	}



}
