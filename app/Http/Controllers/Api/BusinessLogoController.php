<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Client\Client; //model
use Validator;
use Exception;

class BusinessLogoController extends Controller
{
	protected $danger_message = '';
	protected $success_message = '';
	protected $warning_message = '';
	protected $info_message = '';
	protected $redirectTo = '/business-owners';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{

	}
	public function profileLogo(Request $request)
	{
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
		$data['client'] = Client::find($user->id);
		echo json_encode($data);
	}


	public function saveProfileLogo(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'business_id' => 'required|exists:clients,id',
			'logo'        => 'nullable|mimes:jpeg,jpg,png,svg,webp|max:12048',
			'profile_pic' => 'nullable|mimes:jpeg,jpg,png,svg,webp|max:12048',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$client = Client::findOrFail($request->business_id);

		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);

		if (!file_exists($destinationPath)) {
			mkdir($destinationPath, 0777, true);
		}

		try {

			/* ================= LOGO ================= */
			if ($request->hasFile('logo')) {

				 
				if (!empty($client->logo)) {
					$oldLogo = unserialize($client->logo);
					if (!empty($oldLogo['large']['src'])) {
						$oldPath = public_path($oldLogo['large']['src']);
						if (file_exists($oldPath)) {
							unlink($oldPath);
						}
					}
				}

				// 🟢 UPLOAD NEW LOGO
				$filename = $this->saveImageSmart(
					$request->file('logo'),
					$destinationPath,
					250,
					141
				);

				$client->logo = serialize([
					'large' => [
						'name' => $filename,
						'alt'  => $client->business_name,
						'src'  => $filePath . '/' . $filename
					]
				]);
			}

			/* ================= PROFILE PIC ================= */
			if ($request->hasFile('profile_pic')) {

			 
				if (!empty($client->profile_pic)) {
					$oldProfile = unserialize($client->profile_pic);
					if (!empty($oldProfile['large']['src'])) {
						$oldProfile = public_path($oldProfile['large']['src']);
						if (file_exists($oldProfile)) {
							unlink($oldProfile);
						}
					}
				}

				// 🟢 UPLOAD NEW PROFILE PIC
				$filename = $this->saveImageSmart(
					$request->file('profile_pic'),
					$destinationPath,
					1200,
					180
				);

				$client->profile_pic = serialize([
					'large' => [
						'name' => $filename,
						'alt'  => $filename,
						'src'  => $filePath . '/' . $filename
					]
				]);
			}

			$client->save();

			return response()->json([
				'status'  => true,
				'message' => 'Images updated successfully',
				'data' => [
					'logo'        => optional(unserialize($client->logo))['large']['src'] ?? '#',
					'profile_pic' => optional(unserialize($client->profile_pic))['large']['src'] ?? '#'
				]
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => false,
				'message' => $e->getMessage()
			], 500);
		}
	}

	public function saveProfileLogo_old(Request $request)
	{
		$client = Client::findOrFail($request->business_id);

		$validator = Validator::make($request->all(), [
			'business_id' => 'required|exists:clients,id',
			'logo' => 'nullable|mimes:jpeg,jpg,png,svg,webp|max:12048',
			'profile_pic' => 'nullable|mimes:jpeg,jpg,png,svg,webp|max:12048',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);

		try {

			/* LOGO */
			if ($request->hasFile('logo')) {
				$filename = $this->saveImageSmart(
					$request->file('logo'),
					$destinationPath,
					250,
					141
				);

				$client->logo = serialize([
					'large' => [
						'name' => $filename,
						'alt' => $client->business_name,
						'src' => $filePath . '/' . $filename
					]
				]);
			}

			/* PROFILE BANNER */
			if ($request->hasFile('profile_pic')) {
				$filename = $this->saveImageSmart(
					$request->file('profile_pic'),
					$destinationPath,
					1200,
					180
				);

				$client->profile_pic = serialize([
					'large' => [
						'name' => $filename,
						'alt' => $filename,
						'src' => $filePath . '/' . $filename
					]
				]);
			}

			$client->save();

			return response()->json([
				'status' => true,
				'message' => 'Images saved successfully',
				'data' => [
					'logo' => optional(unserialize($client->logo))['large']['src'] ?? '#',
					'profile_pic' => optional(unserialize($client->profile_pic))['large']['src'] ?? '#'
				]
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => false,
				'message' => $e->getMessage()
			], 500);
		}
	}



	public function logoDel(Request $request, $business_id)
	{

		$validator = Validator::make(
			['business_id' => $business_id],
			[
				'business_id' => 'required|integer|exists:clients,id',
			]
		);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'errors' => $validator->errors()
			], 422);
		}


		$delet_data = Client::findOrFail($business_id);

		if ($delet_data->logo != '') {
			$image = unserialize($delet_data->logo);

			$large = '' . $image['large']['src'];

			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array('logo' => "", );
		$del = Client::where('id', $delet_data->id)->update($edit_data);
		if ($del) {
			$data['status'] = true;
			$data['message'] = "Successfully Deleted!";

		} else {
			$data['status'] = true;
			$data['message'] = "Not deleted logo!";

		}
		echo json_encode($data);
	}


	public function profilePicDel(Request $request, $business_id)
	{


		$validator = Validator::make(
			['business_id' => $business_id],
			[
				'business_id' => 'required|integer|exists:clients,id',
			]
		);


		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}

		$delet_data = Client::findOrFail($business_id);


		if ($delet_data->profile_pic != '') {
			$image = unserialize($delet_data->profile_pic);
			$large = '' . $image['large']['src'];
			if (file_exists($large)) {
				unlink($large);
			}
		}
		$edit_data = array('profile_pic' => "", );
		$del = Client::where('id', $business_id)->update($edit_data);
		if ($del) {
			$data['status'] = true;
			$data['message'] = "Successfully Deleted!";

		} else {
			$data['status'] = true;
			$data['message'] = "Not deleted logo!";

		}
		echo json_encode($data);

	}
	public function uploadPictures(Request $request)
	{
		$id = $request->input('business_id');
		$client = Client::find($id);
		if (!empty($client->pictures)) {
			$picture = unserialize($client->pictures);
			$picture['large']['name'] = '';
			for ($i = 0; $i < 12; $i++) {
				if (!isset($picture[$i])) {
					$picture[$i]['large']['name'] = '';
				}
			}
		}
		for ($i = 0; $i < 12; $i++) {
			if (isset($picture[$i]['large']['src']) && !empty($picture[$i]['large']['src'])) {
				$data[$i][$picture[$i]['large']['src']] = $picture[$i]['large']['src'];

			}
		}
		echo json_encode($data);

	}

	public function saveGallery(Request $request)
	{
		// dd($request->all());
 
		$validator = Validator::make($request->all(), [
			'business_id'     => 'required|exists:clients,id',
			// 'images.*'        => 'image|mimes:jpg,jpeg,png,webp,svg|max:5120',
			// 'remove_images'   => 'array'
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => false,
				'errors' => $validator->errors()
			], 422);
		}

		$client = Client::findOrFail($request->business_id);

		// 1️⃣ Existing images
		$images = $client->pictures ? unserialize($client->pictures) : [];

		// 2️⃣ DELETE SELECTED IMAGES
		if ($request->filled('remove_images')) {

			$removeImages = $request->remove_images; // array
 
			foreach ($images as $key => $img) {
				if (in_array($img['large']['src'], $removeImages)) {

					$path = public_path($img['large']['src']);
					if (file_exists($path)) {
						unlink($path);
					}

					unset($images[$key]);
				}
			}
		}

		// Reindex array
		$images = array_values($images);

		// 3️⃣ Upload NEW images
		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);

		if (!file_exists($destinationPath)) {
			mkdir($destinationPath, 0777, true);
		}

		foreach ($request->file('image', []) as $file) {


		$newImages = $request->image; // array

 
			$ext  = strtolower($file->getClientOriginalExtension());
			$name = uniqid('gallery_');

			if ($ext === 'svg') {
				$finalName = $name . '.svg';
				$file->move($destinationPath, $finalName);
			} else {
				$finalName = $this->saveImageSmart($file, $destinationPath, 850, 600);
			}

			$images[] = [
				'large' => [
					'name' => $finalName,
					'alt'  => $finalName,
					'src'  => $filePath . '/' . $finalName
				]
			];
		}

		// 4️⃣ Save final images
		$client->pictures = serialize($images);
		$client->save();

		return response()->json([
			'status'  => true,
			'message' => 'Gallery updated successfully',
			'data'    => $images
		]);


	}

	public function saveGallary_old(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'business_id' => 'required|integer|exists:clients,id',
		]);
		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}

		$id = $request->business_id;
		$client = Client::findOrFail($request->business_id);
		$oldImages = !empty($client->pictures) ? unserialize($client->pictures) : [];
		$images = [];

		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);

		if (!file_exists($destinationPath)) {
			mkdir($destinationPath, 0777, true);
		}

		for ($i = 0; $i < 20; $i++) {

			$field = 'image' . ($i + 1);

			if ($request->hasFile($field)) {

				$file = $request->file($field);
				$ext = strtolower($file->getClientOriginalExtension());

				$baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				$safeName = str_replace(' ', '_', $baseName);
				$baseFile = $safeName . '_' . time() . '_' . $i;

				/* ---------- SVG ---------- */
				if ($ext === 'svg') {
					$finalName = $baseFile . '.svg';
					$file->move($destinationPath, $finalName);
				}
				/* ---------- WEBP ---------- */ else {
					$finalName = $this->saveImageSmart(
						$file,
						$destinationPath,
						850,
						600
					);
				}

				$images[$i]['large'] = [
					'name' => $finalName,
					'alt' => $finalName,
					'width' => '',
					'height' => '',
					'src' => $filePath . '/' . $finalName
				];

			} else if (isset($_FILES['image' . ($i + 1)]) && $_FILES['image' . ($i + 1)]['size'] == 0) {
			} else {
				// Keep old image if not replaced
				if (isset($oldImages[$i])) {
					$images[$i] = $oldImages[$i];
					unset($oldImages[$i]);
				}
			}
		}

		$client->pictures = count($images) ? serialize($images) : '';
		$client->save();

		/* ---------- DELETE REMOVED IMAGES ---------- */
		foreach ($oldImages as $old) {
			if (!empty($old['large']['src'])) {
				$oldPath = public_path($old['large']['src']);
				if (file_exists($oldPath)) {
					unlink($oldPath);
				}
			}
		}

		$client = Client::find($id);
		if (!empty($client->pictures)) {
			$picture = unserialize($client->pictures);
			$picture['large']['name'] = '';
			for ($i = 0; $i < 12; $i++) {
				if (!isset($picture[$i])) {
					$picture[$i]['large']['name'] = '';
				}
			}
		}
		for ($i = 0; $i < 12; $i++) {
			if (isset($picture[$i]['large']['src']) && !empty($picture[$i]['large']['src'])) {
				$data[$i][$picture[$i]['large']['src']] = $picture[$i]['large']['src'];

			}
		}
		echo json_encode($data);

	}

	public function convertToWebp($imagePath, $destination, $filename)
	{
		$info = getimagesize($imagePath);

		switch ($info['mime']) {
			case 'image/jpeg':
				$image = imagecreatefromjpeg($imagePath);
				break;

			case 'image/png':
				$image = imagecreatefrompng($imagePath);
				imagepalettetotruecolor($image);
				imagealphablending($image, true);
				imagesavealpha($image, true);
				break;

			case 'image/webp':
				$image = imagecreatefromwebp($imagePath);
				break;

			default:
				throw new \Exception('Unsupported image format');
		}

		// Resize (optional but recommended)
		$maxWidth = 1200;
		$width = imagesx($image);
		$height = imagesy($image);

		if ($width > $maxWidth) {
			$newHeight = ($maxWidth / $width) * $height;
			$newImage = imagecreatetruecolor($maxWidth, $newHeight);
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
		} else {
			$newImage = $image;
		}

		$finalName = $filename . '.webp';
		imagewebp($newImage, $destination . '/' . $finalName, 75);

		imagedestroy($image);
		imagedestroy($newImage);

		return $finalName;
	}



	private function saveImageSmart($file, $destinationPath, $width = null, $height = null)
	{
		$ext = strtolower($file->getClientOriginalExtension());
		$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$name = str_replace(' ', '_', $name);
		$filename =  time();

		// ✅ SVG → Save directly
		if ($ext === 'svg') {
			$finalName = $filename . '.svg';
			$file->move($destinationPath, $finalName);
			return $finalName;
		}

		if ($ext === 'pdf') {
			$finalName = $filename . '.pdf';
			$file->move($destinationPath, $finalName);
			return $finalName;
		}

		// ✅ Raster → Convert to WEBP
		$imagePath = $file->getPathname();

		switch ($ext) {
			case 'jpg':
			case 'jpeg':
				$src = imagecreatefromjpeg($imagePath);
				break;
			case 'png':
				$src = imagecreatefrompng($imagePath);
				imagepalettetotruecolor($src);
				imagealphablending($src, true);
				imagesavealpha($src, true);
				break;
			case 'webp':
				$src = imagecreatefromwebp($imagePath);
				break;
			default:
				throw new \Exception('Unsupported image type');
		}

		$width = $width ?? imagesx($src);
		$height = $height ?? imagesy($src);

		$dst = imagecreatetruecolor($width, $height);
		imagealphablending($dst, false);
		imagesavealpha($dst, true);

		imagecopyresampled(
			$dst,
			$src,
			0,
			0,
			0,
			0,
			$width,
			$height,
			imagesx($src),
			imagesy($src)
		);

		$finalName = $filename . '.webp';
		imagewebp($dst, $destinationPath . '/' . $finalName, 80);

		imagedestroy($src);
		imagedestroy($dst);

		return $finalName;
	}


	public function saveBusinessCertificate(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'business_id' => 'required|exists:clients,id',
			'iso_no' => 'nullable|max:255',
			'gst_no' => 'nullable|max:255',
			'cin_no' => 'nullable|max:255',
			'msme_no' => 'nullable|max:255',
		 

		]);
		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}


		$client = Client::find($request->business_id);
 

			$clean = function ($value) {
			return preg_replace('/[^a-zA-Z0-9\-\/]/', '', strip_tags($value));
			};

		

			$client->iso_no  = $clean($request->iso_no);
			$client->gst_no  = $clean($request->gst_no);
			$client->cin_no  = $clean($request->cin_no);
			$client->msme_no = $clean($request->msme_no);



		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);

		if ($request->hasFile('iso_certificate')) {

 		$this->deleteOldCertificate($client->iso_certificate);


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
		if ($request->hasFile('gst_certificate')) {
			$this->deleteOldCertificate($client->gst_certificate);
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
			$this->deleteOldCertificate($client->cin_certificate);
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
			$this->deleteOldCertificate($client->msme_certificate);
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



		if ($client->save()) {
			$status = true;
			$msg = "Certificate updated successfully !";
		} else {
			$status = false;
			$msg = "Certificate could not be successfully, Please try again !";
		}
		return response()->json(['status' => $status, 'msg' => $msg], 200);

	}
	private function deleteOldCertificate($json)
	{
		if (!empty($json)) {
			$data = json_decode($json, true);
			if (!empty($data['large']['src'])) {
				$path = public_path($data['large']['src']);
				if (file_exists($path)) {
					unlink($path);
				}
			}
		}
	}

	public function saveBusinessAward(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'business_id' => 'required|exists:clients,id',
			'award_name1' => 'nullable|max:255',
			'award_name2' => 'nullable|max:255',
		]);
		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}


		$client = Client::find($request->business_id);


	$clean = function ($value) {
		return preg_replace('/[^a-zA-Z0-9\-\/]/', '', strip_tags($value));
		};

		

			$client->award_name1  = $clean($request->award_name1);
			$client->award_name2  = $clean($request->award_name2);
			$client->award_name3  = $clean($request->award_name3);
			$client->award_name4 = $clean($request->award_name4);
			$client->award_name5  = $clean($request->award_name5);

		 

		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);


		if ($request->hasFile('award_img1')) {
			$this->deleteOldCertificate($client->award_img1);
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
			$this->deleteOldCertificate($client->award_img2);
			$award_img2 = $this->saveImageSmart(
				$request->file('award_img2'),
				$destinationPath,
				1000,
				1000
			);

			$client->award_img2 = json_encode([
				'large' => [
					'name' => $request->award_name2,
					'alt' => '',
					'src' => $filePath . '/' . $award_img2
				]
			]);
		}
		if ($request->hasFile('award_img3')) {
			$this->deleteOldCertificate($client->award_img3);
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
			$this->deleteOldCertificate($client->award_img4);
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
			$this->deleteOldCertificate($client->award_img5);
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
			$status = true;
			$msg = "Awar updated successfully !";
		} else {
			$status = 0;
			$msg = "Awar could not be successfully, Please try again !";
		}
		return response()->json(['status' => $status, 'msg' => $msg], 200);

	}




}
