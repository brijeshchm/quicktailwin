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

use Spatie\PdfToImage\Pdf;

class CertificateController extends Controller
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


	public function getBusinessCertificate(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);	 
		return view('business.certificate', ['client' => $client]);
	}


	public function autoSaveCertificate(Request $request)
	{



		$validator = Validator::make($request->all(), [

			'iso_no' => 'nullable|string|max:50',
			'gst_no' => 'nullable|string|max:20',
			'cin_no' => 'nullable|string|max:30',
			'msme_no' => 'nullable|string|max:30',
			'pan_no' => 'nullable|string|max:10',
			'iso_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'gst_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'cin_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'msme_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'coi_certificate' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',

		]);
		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => false, 'errors' => $errorsBag], 400);
		}


		$client = Client::find($request->business_id);

		$clean = function ($value) {
			return preg_replace('/[^a-zA-Z0-9\-\/]/', '', strip_tags($value));
		};

		$client->iso_no = $clean($request->iso_no);
		$client->gst_no = $clean($request->gst_no);
		$client->cin_no = $clean($request->cin_no);
		$client->msme_no = $clean($request->msme_no);
		$client->pan_no = $clean($request->pan_no);
		$client->coi_no = $clean($request->coi_no);


		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);

		if ($request->hasFile('pan_certificate')) {

			$pan_certificate = $this->saveImageSmart(
				$request->file('pan_certificate'),
				$destinationPath,
				1000,
				1000
			);

			$client->pan_certificate = json_encode([
				'large' => [
					'name' => $request->pan_no,
					'alt' => $request->pan_no,
					'src' => $filePath . '/' . $pan_certificate
				]
			]);
		}


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

		if ($request->hasFile('coi_certificate')) {
			$coi_certificate = $this->saveImageSmart(
				$request->file('coi_certificate'),
				$destinationPath,
				1000,
				1000
			);

			$client->coi_certificate = json_encode([
				'large' => [
					'name' => $request->coi_no,
					'alt' => $request->coi_no,
					'src' => $filePath . '/' . $coi_certificate
				]
			]);
		}

		if ($request->hasFile('other_certificate1')) {
			$other_certificate1 = $this->saveImageSmart(
				$request->file('other_certificate1'),
				$destinationPath,
				1000,
				1000
			);

			$client->other_certificate1 = json_encode([
				'large' => [
					'name' => "",
					'alt' => "",
					'src' => $filePath . '/' . $other_certificate1
				]
			]);
		}

		if ($request->hasFile('other_certificate2')) {
			$other_certificate2 = $this->saveImageSmart(
				$request->file('other_certificate2'),
				$destinationPath,
				1000,
				1000
			);

			$client->other_certificate2 = json_encode([
				'large' => [
					'name' => "",
					'alt' => "",
					'src' => $filePath . '/' . $other_certificate2
				]
			]);
		}

		if ($request->hasFile('other_certificate3')) {
			$other_certificate3 = $this->saveImageSmart(
				$request->file('other_certificate3'),
				$destinationPath,
				1000,
				1000
			);

			$client->other_certificate3 = json_encode([
				'large' => [
					'name' => "",
					'alt' => "",
					'src' => $filePath . '/' . $other_certificate3
				]
			]);
		}
		if ($request->hasFile('other_certificate4')) {
			$other_certificate4 = $this->saveImageSmart(
				$request->file('other_certificate4'),
				$destinationPath,
				1000,
				1000
			);

			$client->other_certificate4 = json_encode([
				'large' => [
					'name' => "",
					'alt' => "",
					'src' => $filePath . '/' . $other_certificate4
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

	public function getBusinessAward(Request $request)
	{

		// echo  phpinfo();  die;
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		return view('business.award', ['client' => $client]);
	}

	public function saveBusinessAward(Request $request)
	{



		$validator = Validator::make($request->all(), [

			'award_name1' => 'nullable|max:255',
			'award_name2' => 'nullable|max:255',

			'award_img1' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'award_img2' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'award_img3' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'award_img4' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'award_img5' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'award_img6' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'award_img7' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'award_img8' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
			'award_img9' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg,pdf|max:10240',
		]);
		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}


		$client = Client::find($request->business_id);

		$clean = function ($value) {
			return preg_replace('/[^a-zA-Z0-9\-\/]/', '', strip_tags($value));
		};

		$client->award_name1 = $clean($request->award_name1);
		$client->award_name2 = $clean($request->award_name2);
		$client->award_name3 = $clean($request->award_name3);
		$client->award_name4 = $clean($request->award_name4);
		$client->award_name5 = $clean($request->award_name5);

		$client->award_name6 = $clean($request->award_name6);
		$client->award_name7 = $clean($request->award_name7);
		$client->award_name8 = $clean($request->award_name8);
		$client->award_name9 = $clean($request->award_name9);



		$filePath = getFolderStructure();
		$destinationPath = public_path($filePath);


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
		if ($request->hasFile('award_img6')) {
			$award_img6 = $this->saveImageSmart(
				$request->file('award_img6'),
				$destinationPath,
				1000,
				1000
			);

			$client->award_img6 = json_encode([
				'large' => [
					'name' => $request->award_name6,
					'alt' => $request->award_name6,
					'src' => $filePath . '/' . $award_img6
				]
			]);
		}

		if ($request->hasFile('award_img7')) {
			$award_img7 = $this->saveImageSmart(
				$request->file('award_img7'),
				$destinationPath,
				1000,
				1000
			);

			$client->award_img7 = json_encode([
				'large' => [
					'name' => $request->award_name7,
					'alt' => $request->award_name7,
					'src' => $filePath . '/' . $award_img7
				]
			]);
		}

		if ($request->hasFile('award_img8')) {
			$award_img8 = $this->saveImageSmart(
				$request->file('award_img8'),
				$destinationPath,
				1000,
				1000
			);

			$client->award_img8 = json_encode([
				'large' => [
					'name' => $request->award_name8,
					'alt' => $request->award_name8,
					'src' => $filePath . '/' . $award_img8
				]
			]);
		}
		if ($request->hasFile('award_img9')) {
			$award_img9 = $this->saveImageSmart(
				$request->file('award_img9'),
				$destinationPath,
				1000,
				1000
			);

			$client->award_img9 = json_encode([
				'large' => [
					'name' => $request->award_name9,
					'alt' => $request->award_name9,
					'src' => $filePath . '/' . $award_img9
				]
			]);
		}


		if ($client->save()) {
			$status = 1;
			$msg = "Award updated successfully !";
		} else {
			$status = 0;
			$msg = "Award could not be successfully, Please try again !";
		}
		return response()->json(['status' => $status, 'msg' => $msg], 200);


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


		//  if ($ext === 'pdf') {

		//     // ✅ save pdf to PUBLIC folder
//     $pdfName = $filename . '.pdf';
//     $file->move($destinationPath, $pdfName);

		//     // ✅ absolute pdf path
//     $fullPdfPath = $destinationPath . '/' . $pdfName;

		//     if (!file_exists($fullPdfPath)) {
//         throw new \Exception('PDF file not found');
//     }

		//     // output images also in PUBLIC
//     $folder = $filename;
//     // $outputDir = public_path('pdf_images/' . $folder);
//     $outputDir = $destinationPath . '/' . $filename;
//     if (!file_exists($outputDir)) {
//         mkdir($outputDir, 0777, true);
//     }

		//     $pdf = new Pdf($fullPdfPath);
//     $pdf->setResolution(300);

		//     $images = [];

		//     foreach (range(1, $pdf->getNumberOfPages()) as $page) {
//         $imageName = "page_{$page}.png";
//         $imagePath = $outputDir . '/' . $imageName;

		//         $pdf->setPage($page)->saveImage($imagePath);

		//         // ✅ public URL
//         $images[] = asset("pdf_images/{$folder}/{$imageName}");
//     }

		//     return $images;
// }

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

	public function certificateDel($slug, $id)
	{

		$delet_data = Client::findOrFail($id);

		$client = Client::find($id);

		if ($delet_data->$slug != '') {
			$image = json_decode($delet_data->$slug);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array($slug => "", );
		$del = Client::where('id', $id)->update($edit_data);
		return redirect('business/business-certificate');
	}

	public function awardDel($slug, $id)
	{

		$delet_data = Client::findOrFail($id);

		$client = Client::find($id);

		if ($delet_data->$slug != '') {
			$image = json_decode($delet_data->$slug);

			$large = '' . $image->large->src;
			if (!empty($image->thumbnail->src)) {
				$thumbnail = '' . $image->thumbnail->src;
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}
		}

		$edit_data = array($slug => "", );
		$del = Client::where('id', $id)->update($edit_data);

		return redirect('business/business-award');

	}
}
