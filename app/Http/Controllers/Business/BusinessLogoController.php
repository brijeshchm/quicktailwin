<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Client\Client; //model
use Validator;
use Exception;

class BusinessLogoController extends Controller
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
	public function profileLogo(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		return view('business.profileLogo', ['client' => $client]);
	}
	public function saveProfileLogo(Request $request)
	{
		// dd($request->all());
		// if ($request->ajax()) {
			$client = Client::find($request->input('business_id'));
			$id = $request->input('business_id');
			$validator = Validator::make($request->all(), [
				'logo' => 'mimes:jpeg,jpg,png,svg,webp|max:12048',
				'profile_pic' => 'mimes:jpeg,jpg,png,svg,webp|max:12048'
			], [
				'profile_pic.dimensions' => 'Please upload Banner of given size -> [Minimum Height:319px] &amp; [Minimum Width:1137px].',
				'logo.dimensions' => 'Please upload profile logo of given size -> .[Maximum Height:150px] &amp; [Maximum Width:300px]'
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => false, 'errors' => $errorsBag], 400);
			}
		$client = Client::findOrFail($request->business_id);

		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);

		try {

			/* LOGO */
			if ($request->hasFile('logo')) {
				$filenameLogo = $this->saveImageSmart(
					$request->file('logo'),
					$destinationPath,
					250,
					141
				);

				$client->logo = serialize([
					'large' => [
						'name' => $filenameLogo,
						'alt' => $filenameLogo,
						'src' => $filePath . '/' . $filenameLogo
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
				'msg' => 'Profile Logo saved successfully',
				'data' => [
					'logo' => optional(unserialize($client->logo))['large']['src'] ?? '#',
					'profile_pic' => optional(unserialize($client->profile_pic))['large']['src'] ?? '#'
				]
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => false,
				'msg' => $e->getMessage()
			], 500);
		}
	
	}
	 
	public function logoDel($id)
	{

		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);

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
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/profile-logo');

	}


	public function profilePicDel($id)
	{

		$delet_data = Client::findOrFail($id);
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
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
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/profile-logo');

	}
	public function uploadPictures(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('business.uploadPictures', ['search' => $search, 'client' => $client]);
	}
private function saveImageSmart($file, $destinationPath, $width = null, $height = null)
{
    $ext = strtolower($file->getClientOriginalExtension());
    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $name = str_replace(' ', '_', $name);
    $filename = time();

    // ✅ SVG → Save directly
    if ($ext === 'svg') {
        $finalName = $filename . '.svg';
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

    $width  = $width ?? imagesx($src);
    $height = $height ?? imagesy($src);

    $dst = imagecreatetruecolor($width, $height);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);

    imagecopyresampled(
        $dst, $src,
        0, 0, 0, 0,
        $width, $height,
        imagesx($src), imagesy($src)
    );

    $finalName = $filename . '.webp';
    imagewebp($dst, $destinationPath . '/' . $finalName, 80);

    imagedestroy($src);
    imagedestroy($dst);

    return $finalName;
}

	 
public function saveGallary(Request $request)
{
     
	 
    $client = Client::findOrFail($request->business_id);
    $oldImages = !empty($client->pictures) ? unserialize($client->pictures) : [];
    $images = [];

    $filePath = getFolderStructure();
    $destinationPath = public_path($filePath);

    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    for ($i = 0; $i < 21; $i++) {

        $field = 'image' . ($i + 1);
			 
        if ($request->hasFile($field)) {

            $file = $request->file($field);
            $ext = strtolower($file->getClientOriginalExtension());

            $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = str_replace(' ', '_', $baseName);
            $baseFile =  time() . '_' . $i;

            /* ---------- SVG ---------- */
            if ($ext === 'svg') {
                $finalName = $baseFile . '.svg';
                $file->move($destinationPath, $finalName);
            }
          
            else {
                $finalName = $this->saveImageSmart(
                    $file,
                    $destinationPath,
                    850,
                    600
                );
            }

            $images[$i]['large'] = [
                'name' => $finalName,
                'alt'  => $finalName,
                'width' => '',
                'height' => '',
                'src' => $filePath . '/' . $finalName
            ];

        	} else if (isset($_FILES['image' . ($i + 1)]) && $_FILES['image' . ($i + 1)]['size'] == 0) {
						} else {
			 
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

    $request->session()->flash('success_msg', 'Profile gallery updated successfully!');
    return redirect("/business/gallery-pictures");
}
	 

	// public function saveGallary(Request $request)
	// {
	// 	if (!$request->has('fourth_form_submit')) {
	// 		return redirect("/business/gallery-pictures");
	// 	}

	// 	$client = Client::find($request->business_id);
	// 	$id = $client->id;

	// 	$images = [];
	// 	$oldImages = !empty($client->pictures) ? unserialize($client->pictures) : [];

	// 	$filePath = getFolderStructure();
	// 	$destinationPath = public_path($filePath);

	// 	if (!file_exists($destinationPath)) {
	// 		mkdir($destinationPath, 0777, true);
	// 	}

	// 	for ($i = 0; $i < 12; $i++) {

	// 		$field = 'image' . ($i + 1);

	// 		if ($request->hasFile($field)) {

	// 			$file = $request->file($field);
	// 			$ext = strtolower($file->getClientOriginalExtension());

	// 			$baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
	// 			$safeName = str_replace(' ', '_', $baseName);
	// 			$filename = $safeName . '_' . time() . '_' . $i;

	// 			/* =========================
	// 			   SVG → Save directly
	// 			========================= */
	// 			if ($ext === 'svg') {

	// 				$finalName = $filename . '.svg';
	// 				$file->move($destinationPath, $finalName);

	// 			} else {

	// 				/* =========================
	// 				   COMPRESS & CONVERT TO WEBP
	// 				========================= */
	// 				// $finalName = $this->convertToWebp(
	// 				// 	$file->getRealPath(),
	// 				// 	$destinationPath,
	// 				// 	$filename
	// 				// );

	// 				$filename = $this->saveImageSmart(
	// 				$file->getRealPath(),
	// 				$destinationPath,
	// 				550,
	// 				400
	// 			);
	// 			}

	// 			$images[$i]['large'] = [
	// 				'name' => $finalName,
	// 				'alt' => $finalName,
	// 				'width' => '',
	// 				'height' => '',
	// 				'src' => $filePath . '/' . $finalName
	// 			];

	// 		} else {
	// 			// Keep old image if new not uploaded
	// 			if (isset($oldImages[$i])) {
	// 				$images[$i] = $oldImages[$i];
	// 				unset($oldImages[$i]);
	// 			}
	// 		}
	// 	}

	// 	$client->pictures = count($images) ? serialize($images) : '';
	// 	$client->save();

	// 	/* =========================
	// 	   DELETE REMOVED OLD IMAGES
	// 	========================= */
	// 	foreach ($oldImages as $old) {
	// 		if (!empty($old['large']['src'])) {
	// 			@unlink(public_path($old['large']['src']));
	// 		}
	// 	}

	// 	$request->session()->flash('success_msg', 'Profile gallery updated successfully!');
	// 	return redirect("/business/gallery-pictures");
	// }

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

}
