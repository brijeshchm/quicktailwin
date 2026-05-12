<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Client\Client;
use DB;
use Log;
use Validator;
use function PHPUnit\Framework\isFalse;
class ProfileController extends Controller
{
    public function profileInfo(Request $request)
    {
        try {

            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            // Check if user is active

            $user = auth('sanctum')->user();
    
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            if (!$user->active_status) {
                $user->tokens()->delete();
                return response()->json(['status' => false, 'message' => 'User account is inactive',], 403);
            }

            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            $times = ["24:00" => "Open 24 Hrs", "00:00" => "00:00", "00:30" => "00:30", "01:00" => "01:00", "01:30" => "01:30", "02:00" => "02:00", "02:30" => "02:30", "03:00" => "03:00", "03:30" => "03:30", "04:00" => "04:00", "04:30" => "04:30", "05:00" => "05:00", "05:30" => "05:30", "06:00" => "06:00", "06:30" => "06:30", "07:00" => "07:00", "07:30" => "07:30", "08:00" => "08:00", "08:30" => "08:30", "09:00" => "09:00", "09:30" => "09:30", "10:00" => "10:00", "10:30" => "10:30", "11:00" => "11:00", "11:30" => "11:30", "12:00" => "12:00", "12:30" => "12:30", "13:00" => "13:00", "13:30" => "13:30", "14:00" => "14:00", "14:30" => "14:30", "15:00" => "15:00", "15:30" => "15:30", "16:00" => "16:00", "16:30" => "16:30", "17:00" => "17:00", "17:30" => "17:30", "18:00" => "18:00", "18:30" => "18:30", "19:00" => "19:00", "19:30" => "19:30", "20:00" => "20:00", "20:30" => "20:30", "21:00" => "21:00", "21:30" => "21:30", "22:00" => "22:00", "22:30" => "22:30", "23:00" => "23:00", "23:30" => "23:30", "closed" => "Closed"];
            if (!empty($user->time)) {
                $time = json_decode($user->time);
            } else {
                $time = "";
            }
            if (!empty($user->certifications)) {
                $certifications = $user->certifications;
            } else {
                $certifications = "";
            }
            if (!empty($user->profile_pic)) {
                $profile_pic = unserialize($user->profile_pic);
            } else {
                $profile_pic = "";
            }
            if (!empty($user->pictures)) {
                $pictures = unserialize($user->pictures);
            } else {
                $pictures = "";
            }

            $data['userDetails'] = array(
                'client_id' => $user->id,
                'username' => $user->username,
                'business_slug' => $user->business_slug,
                'business_name' => $user->business_name,
                'business_intro' => $user->business_intro,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'client_type' => $user->client_type,
                'balance_amt' => $user->balance_amt,
                'coins_amt' => $user->coins_amt,
                'leads_remaining' => $user->leads_remaining,
                'expired_from' => $user->expired_from,
                'expired_on' => $user->expired_on,
                'certified_status' => $user->certified_status,
                'city_id' => $user->city_id,
                'city' => $user->city,
                'address' => $user->address,
                'landmark' => $user->landmark,
                'state' => $user->state,
                'country' => $user->country,
                'time' => $time,
                'days' => $days,
                'times' => $times,
                'certifications' => $certifications,
                'year_of_estb' => $user->year_of_estb,
                'profile_pic' => $profile_pic,
                'pictures' => $pictures,
                'active_status' => $user->active_status,
            );

            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => 'get data record',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to : ' . $e->getMessage(),
            ], 500);
        }


    }

    public function saveProfile(Request $request)
    {
        try {
            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'email' => 'required|max:255|unique:clients,email,' . $user->id . ',id',
                'year_of_estb' => 'required',


            ]);

            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }

            $user = Client::find($user->id);
            $user->display_hofo = $request->input('display_hofo');
            $user->business_intro = $request->input('business_intro');
            $user->year_of_estb = $request->input('year_of_estb');
            $user->certifications = (!empty($request->input('certifications'))) ? serialize(explode(',', $request->input('certifications'))) : "";
            // if (!empty($request->time)) {
            // $user->time =json_encode($request->time);
            // } 

            if ($user->save()) {

                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                $times = ["24:00" => "Open 24 Hrs", "00:00" => "00:00", "00:30" => "00:30", "01:00" => "01:00", "01:30" => "01:30", "02:00" => "02:00", "02:30" => "02:30", "03:00" => "03:00", "03:30" => "03:30", "04:00" => "04:00", "04:30" => "04:30", "05:00" => "05:00", "05:30" => "05:30", "06:00" => "06:00", "06:30" => "06:30", "07:00" => "07:00", "07:30" => "07:30", "08:00" => "08:00", "08:30" => "08:30", "09:00" => "09:00", "09:30" => "09:30", "10:00" => "10:00", "10:30" => "10:30", "11:00" => "11:00", "11:30" => "11:30", "12:00" => "12:00", "12:30" => "12:30", "13:00" => "13:00", "13:30" => "13:30", "14:00" => "14:00", "14:30" => "14:30", "15:00" => "15:00", "15:30" => "15:30", "16:00" => "16:00", "16:30" => "16:30", "17:00" => "17:00", "17:30" => "17:30", "18:00" => "18:00", "18:30" => "18:30", "19:00" => "19:00", "19:30" => "19:30", "20:00" => "20:00", "20:30" => "20:30", "21:00" => "21:00", "21:30" => "21:30", "22:00" => "22:00", "22:30" => "22:30", "23:00" => "23:00", "23:30" => "23:30", "closed" => "Closed"];
                // if (!empty($request->time)) {
                //     $time =json_encode($request->time);
                // } else {
                //     $time = $user->time;
                // }
                if (!empty($user->certifications)) {
                    $certifications = $user->certifications;
                } else {
                    $certifications = "";
                }
                if (!empty($user->profile_pic)) {
                    $profile_pic = unserialize($user->profile_pic);
                } else {
                    $profile_pic = "";
                }
                if (!empty($user->pictures)) {
                    $pictures = unserialize($user->pictures);
                } else {
                    $pictures = "";
                }
                $data['userDetails'] = array(
                    'client_id' => $user->id,
                    'username' => $user->username,
                    'business_slug' => $user->business_slug,
                    'business_name' => $user->business_name,
                    'business_intro' => $user->business_intro,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'client_type' => $user->client_type,
                    'balance_amt' => $user->balance_amt,
                    'coins_amt' => $user->coins_amt,
                    'leads_remaining' => $user->leads_remaining,
                    'expired_from' => $user->expired_from,
                    'expired_on' => $user->expired_on,
                    'certified_status' => $user->certified_status,
                    'city_id' => $user->city_id,
                    'city' => $user->city,
                    'address' => $user->address,
                    'landmark' => $user->landmark,
                    'state' => $user->state,
                    'country' => $user->country,
                    'time' => $time,
                    'days' => $days,
                    'times' => $times,
                    'certifications' => $certifications,
                    'year_of_estb' => $user->year_of_estb,
                    'profile_pic' => $profile_pic,
                    'pictures' => $pictures,
                    'active_status' => $user->active_status,
                );

                $data['status'] = true;
                $data['message'] = "Profile updated successfully!";
                 
               
            } else {
                $data['status'] = false;
                $data['message'] = "Profile not updated successfully!";
            }
        } catch (\Exception $e) {
                $data['status'] = false;
                $data['message'] = 'Failed to : ' . $e->getMessage();
            
        }
        echo json_encode($data);

    }


    public function profileLogo(Request $request)
    {
        try {

            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            // Check if user is active

            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            if (!$user->active_status) {
                $user->tokens()->delete();
                return response()->json(['status' => false, 'message' => 'User account is inactive',], 403);
            }


            if (!empty($user->profile_pic)) {
                $profile_pic = unserialize($user->profile_pic);
            } else {
                $profile_pic = "";
            }
            if (!empty($user->logo)) {
                $logo = unserialize($user->logo);
            } else {
                $logo = "";
            }

            $data['userDetails'] = array(
                'client_id' => $user->id,
                'username' => $user->username,
                'business_slug' => $user->business_slug,
                'profile_pic' => $profile_pic,
                'logo' => $logo,
                'active_status' => $user->active_status,
            );

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function saveProfileLogo(Request $request)
    {
        try {

            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'logo' => 'mimes:jpeg,jpg,png|max:2048',
                'profile_pic' => 'mimes:jpeg,jpg,png|max:2048|dimensions:min_width=1137,min_height=319'


            ]);

            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }

            $user = Client::find($user->id);
            if ($request->file('logo')) {
                $image = [];
                $filePath = getFolderStructure();
                $file = $request->file('logo');
                $filename = str_replace(' ', '_', $file->getClientOriginalName());
                $destinationPath = public_path($filePath);
                $nameArr = explode('.', $filename);
                $ext = array_pop($nameArr);
                $name = implode('_', $nameArr);
                if (file_exists($destinationPath . '/' . $filename)) {
                    $filename = $name . "_" . time() . '.' . $ext;
                }
                $file->move($destinationPath, $filename);
                $image['large'] = array(
                    'name' => $filename,
                    'alt' => $filename,
                    'width' => '',
                    'height' => '',
                    'src' => $filePath . "/" . $filename
                );
                $user->logo = serialize($image);
            }

            // PROFILE PICTURE
            // ***************
            if ($request->hasFile('profile_pic')) {
                $image = [];
                $filePath = getFolderStructure();

                $file = $request->file('profile_pic');
                $filename = str_replace(' ', '_', $file->getClientOriginalName());
                $destinationPath = public_path($filePath);
                $nameArr = explode('.', $filename);
                $ext = array_pop($nameArr);
                $name = implode('_', $nameArr);
                if (file_exists($destinationPath . '/' . $filename)) {
                    $filename = $name . "_" . time() . '.' . $ext;
                }
                $file->move($destinationPath, $filename);


                $image['large'] = array(
                    'name' => $filename,
                    'alt' => $filename,
                    'width' => '',
                    'height' => '',
                    'src' => $filePath . "/" . $filename
                );


                $user->profile_pic = serialize($image);
            }


            if ($user->save()) {

                if (!empty($user->profile_pic)) {
                    $profile_pic = unserialize($user->profile_pic);
                } else {
                    $profile_pic = "";
                }
                if (!empty($user->logo)) {
                    $logo = unserialize($user->logo);
                } else {
                    $logo = "";
                }
                $data['userDetails'] = array(
                    'client_id' => $user->id,
                    'username' => $user->username,
                    'business_slug' => $user->business_slug,
                    'business_name' => $user->business_name,
                    'profile_pic' => $profile_pic,
                    'logo' => $logo,
                    'active_status' => $user->active_status,
                );

                $message = "Profile logo successfully!";
                return response()->json(['status' => true, 'data' => $data, 'message' => $message], 200);
            } else {
                return response()->json(['status' => 0, 'data' => '', 'message' => 'Profile not successfully update'], 400);
            }




        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve users: ' . $e->getMessage(),
            ], 500);
        }


    }
    public function logoDel(Request $request)
    {
        try {

            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            // Check if user is active

            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            if (!$user->active_status) {
                $user->tokens()->delete();
                return response()->json(['status' => false, 'message' => 'User account is inactive',], 403);
            }


            $delet_data = Client::findOrFail($user->id);


            if ($delet_data->logo != '') {
                $image = unserialize($delet_data->logo);

                $large = '' . $image['large']['src'];
                if (!empty($image['thumbnail']['src'])) {
                    $thumbnail = '' . $image['thumbnail']['src'];
                    if (file_exists($thumbnail)) {
                        unlink($thumbnail);
                    }
                }
                if (file_exists($large)) {
                    unlink($large);
                }
            }

            $edit_data = array('logo' => "", );
            $del = Client::where('id', $user->id)->update($edit_data);
            $user = Client::find($user->id);
            if (!empty($user->profile_pic)) {
                $profile_pic = unserialize($user->profile_pic);
            } else {
                $profile_pic = "";
            }
            if (!empty($user->logo)) {
                $logo = unserialize($user->logo);
            } else {
                $logo = "";
            }

            $data['userDetails'] = array(
                'client_id' => $user->id,
                'username' => $user->username,
                'business_slug' => $user->business_slug,
                'profile_pic' => $profile_pic,
                'logo' => $logo,
                'active_status' => $user->active_status,
            );

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function profilePicDel(Request $request)
    {
        try {

            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            // Check if user is active

            $user = auth('sanctum')->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
            }

            if (!$user->active_status) {
                $user->tokens()->delete();
                return response()->json(['status' => false, 'message' => 'User account is inactive',], 403);
            }


            $delet_data = Client::findOrFail($user->id);


            if ($delet_data->profile_pic != '') {
                $image = unserialize($delet_data->profile_pic);

                $large = '' . $image['large']['src'];
                if (!empty($image['thumbnail']['src'])) {
                    $thumbnail = '' . $image['thumbnail']['src'];
                    if (file_exists($thumbnail)) {
                        unlink($thumbnail);
                    }
                }
                if (file_exists($large)) {
                    unlink($large);
                }
            }

            $edit_data = array('profile_pic' => "", );
            $del = Client::where('id', $user->id)->update($edit_data);
            $user = Client::find($user->id);
            if (!empty($user->profile_pic)) {
                $profile_pic = unserialize($user->profile_pic);
            } else {
                $profile_pic = "";
            }
            if (!empty($user->logo)) {
                $logo = unserialize($user->logo);
            } else {
                $logo = "";
            }

            $data['userDetails'] = array(
                'client_id' => $user->id,
                'username' => $user->username,
                'business_slug' => $user->business_slug,
                'profile_pic' => $profile_pic,
                'logo' => $logo,
                'active_status' => $user->active_status,
            );

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users: ' . $e->getMessage(),
            ], 500);
        }
    }



	public function saveBusinessCertificate(Request $request, $id)
	{
 
		 

			$validator = Validator::make($request->all(), [

				'iso_no' => 'nullable|max:255',
				'gst_no' => 'nullable|max:255',
				'cin_no' => 'nullable|max:255',
				'msme_no' => 'nullable|max:255',
				'award_name1' => 'nullable|max:255',
				'award_name2' => 'nullable|max:255',
			]);
			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			$client = Client::find($request->business_id);

			$client->iso_no = $request->input('iso_no');
			$client->gst_no = $request->input('gst_no');
			$client->cin_no = $request->input('cin_no');
			$client->msme_no = $request->input('msme_no');

			$clean = function ($value) {
			return preg_replace('/[^a-zA-Z0-9\-\/]/', '', strip_tags($value));
			};

			$client->award_name1  = $clean($request->award_name1);
			$client->award_name2  = $clean($request->award_name2);
			$client->award_name3  = $clean($request->award_name3);
			$client->award_name4 = $clean($request->award_name4);
			$client->award_name5  = $clean($request->award_name5);

			$client->iso_no  = $clean($request->iso_no);
			$client->gst_no  = $clean($request->gst_no);
			$client->cin_no  = $clean($request->cin_no);
			$client->msme_no = $clean($request->msme_no);
			 


		 
			$filePath = getFolderStructure();
			$destinationPath = public_path($filePath);

			if ($request->hasFile('iso_certificate')) {
				$iso_certificate = $this->saveImageSmart(
					$request->file('iso_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->iso_certificate = json_encode([
					'large' => [
						'name' => $request->iso_no,
						'alt' => $request->iso_no,
						'src' => $filePath . '/' . $iso_certificate
					]
				]);
			}
			if ($request->hasFile('pan_certificate')) {
				$pan_certificate = $this->saveImageSmart(
					$request->file('pan_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->pan_certificate = json_encode([
					'large' => [
						'name' => "",
						'alt' => "",
						'src' => $filePath . '/' . $pan_certificate
					]
				]);
			}


			if ($request->hasFile('gst_certificate')) {
				$gst_certificate = $this->saveImageSmart(
					$request->file('gst_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->gst_certificate = json_encode([
					'large' => [
						'name' => $request->gst_no,
						'alt' => $request->gst_no,
						'src' => $filePath . '/' . $gst_certificate
					]
				]);
			}
			if ($request->hasFile('cin_certificate')) {
				$cin_certificate = $this->saveImageSmart(
					$request->file('cin_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->cin_certificate = json_encode([
					'large' => [
						'name' => $request->cin_no,
						'alt' => $request->cin_no,
						'src' => $filePath . '/' . $cin_certificate
					]
				]);
			}
			if ($request->hasFile('msme_certificate')) {
				$msme_certificate = $this->saveImageSmart(
					$request->file('msme_certificate'),
					$destinationPath,
					1000,
					1000
				);

				$client->msme_certificate = json_encode([
					'large' => [
						'name' => $request->msme_no,
						'alt' => $request->msme_no,
						'src' => $filePath . '/' . $msme_certificate
					]
				]);
			}
			if ($request->hasFile('award_img1')) {
				$award_img1 = $this->saveImageSmart(
					$request->file('award_img1'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img1 = json_encode([
					'large' => [
						'name' => $request->award_name1,
						'alt' => $request->award_name1,
						'src' => $filePath . '/' . $award_img1
					]
				]);
			}
			if ($request->hasFile('award_img2')) {
				$award_img2 = $this->saveImageSmart(
					$request->file('award_img2'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img2 = json_encode([
					'large' => [
						'name' => $request->award_name2,
						'alt' => $request->award_name2,
						'src' => $filePath . '/' . $award_img2
					]
				]);
			}
			if ($request->hasFile('award_img3')) {
				$award_img3 = $this->saveImageSmart(
					$request->file('award_img3'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img3 = json_encode([
					'large' => [
						'name' => $request->award_name3,
						'alt' => $request->award_name3,
						'src' => $filePath . '/' . $award_img3
					]
				]);
			}
			if ($request->hasFile('award_img4')) {
				$award_img4 = $this->saveImageSmart(
					$request->file('award_img4'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img4 = json_encode([
					'large' => [
						'name' => $request->award_name4,
						'alt' => $request->award_name4,
						'src' => $filePath . '/' . $award_img4
					]
				]);
			}
			if ($request->hasFile('award_img5')) {
				$award_img5 = $this->saveImageSmart(
					$request->file('award_img5'),
					$destinationPath,
					1000,
					1000
				);

				$client->award_img5 = json_encode([
					'large' => [
						'name' => $request->award_name5,
						'alt' => $request->award_name5,
						'src' => $filePath . '/' . $award_img5
					]
				]);
			}


			if ($client->save()) {
				$status = 1;
				$msg = "Certificate updated successfully !";
			} else {
				$status = 0;
				$msg = "Certificate could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		 

	}



}
