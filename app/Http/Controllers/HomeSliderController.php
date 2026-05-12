<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use App\Models\HomeSlider; 
use App\Models\FormType; 

class HomeSliderController extends Controller
{
	protected $danger_msg = '';
	protected $success_msg = '';
	protected $warning_msg = '';
	protected $info_msg = '';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{		 
		$homeSliders = HomeSlider::orderBy('id', 'desc')->get();	
		$data['title'] = "All Slider";
		$data['header'] = "All Slider";		
		return view('admin.home_slider.index', ['homeSliders' => $homeSliders,'data'=>$data]);
	}

/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function sliderAdd()
	{
		$data['title'] = "Add Home Slider";
		$data['header'] = "Add Home Slider";
		return view('admin.home_slider.index', ['data' => $data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}
		 
		$validator = Validator::make($request->all(), [
			'image' => 'required|mimes:jpeg,png,jpg,svg,webp',		 
		]);

		if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


		$homeSlider = new HomeSlider;
		$homeSlider->slug = $request->input('slug');		 
		$alt = $request->input('slug');
		 

		if ($request->hasFile('image')) {
			$filePath = getFolderCategoryStructure();
			$destinationPath = public_path($filePath);
				$filename = $this->saveImageSmart(
					$request->file('image'),
					$destinationPath,
					null,
					null
				);

				$image = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
				);
			$homeSlider->image = json_encode($image);				 
		} 

		 

 
		
			if ($homeSlider->save()) {
				$status = true;
				$msg = "Submitted successfully!";

			} else {
				$status = false;
				$msg = "Submitted, Please try again!";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		 
			
			$edit_data = HomeSlider::find(base64_decode($id));	
 			
			$data['title'] = "Edit Slider";
			$data['header'] = "Edit Slider";
			return view('admin.home_slider.index', ['edit_data' => $edit_data,'data'=>$data]);
		 
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request,$id)
	{
		 	 
	if ($request->hasFile('image')) {
			$validator = Validator::make($request->all(), [
			'image' => 'required|mimes:jpeg,png,jpg,svg,webp',		 
		]);
	}else{

		$validator = Validator::make($request->all(), [
		'image' => 'nullable',
		]);
	}

		if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}
			$homeSlider = HomeSlider::find($id);	
				$alt = $request->input('slug');
				if ($request->hasFile('image')) {
				$filePath = getFolderCategoryStructure();
				$destinationPath = public_path($filePath);
				$filename = $this->saveImageSmart(
				$request->file('image'),
				$destinationPath,
				null,
				null
				);

				$image= array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
				);
				$homeSlider->image = json_encode($image);

				} 
 
	 			$homeSlider->slug = $request->input('slug');
		
		if ($homeSlider->save()) {
				$status = true;
				$msg = "Update successfully!";

			} else {
				$status = false;
				$msg = "Update, Please try again!";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
			
	}



	public function getHomeSliderPagination(Request $request)
	{

		if ($request->ajax()) {

			$homeSlider = HomeSlider::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {

				$homeSlider = $homeSlider->where(function ($query) use ($request) {
					$query->where('slug', 'LIKE', '%' . $request->input('search.value') . '%');
						 
				});
			}
			$homeSlider = $homeSlider->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $homeSlider->total();
			$returnLeads['recordsFiltered'] = $homeSlider->total();
			$returnLeads['recordCollection'] = [];
			foreach ($homeSlider as $slider) {

				$action = '';
				$separator = '';
				$action .= '<a href="/developer/home_slider/edit/' . base64_encode($slider->id) . '" title="slider Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';


				if ($slider->id > 3) {
					$action .= '<a href="javascript:homeSliderController.delete(' . $slider->id . ')" title="Delete slider" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

				$status="";
				if ($slider->status == '1') {
					$status .= '<a href="javascript:homeSliderController.status(' . $slider->id . ',0)" title="slider status" class="btn btn-success" >Active</a>';
				} else {
					$status .= '<a href="javascript:homeSliderController.status(' . $slider->id . ',1)" title="slider status" class="btn btn-danger" >Inactive</a>';
				}


				if (!empty($slider->image)) {
				$vicons = json_decode($slider->image, true);
				 
				$icons = '<img loading="lazy" src="' . asset('/' . $vicons['src']) . '" width="70px">';
				} else {
				$icons = "";
				}
				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$slider->id'></th>",
					$slider->slug,				 
					$icons,				 
					$status,				 
					$action

				];
				$returnLeads['recordCollection'][] = $slider->id;
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}


	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		if ($request->ajax()) {
			 
			$delet_data = HomeSlider::find($id);
			if ($delet_data->image != '') {
			$image = json_decode($delet_data->image);			 
			$thumbnail = ''. $image->src;		 
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}
		 
		
		if (HomeSlider::destroy($id)) {
				$status = true;
				$msg = "Delete successfully!";

			} else {
				$status = false;
				$msg = "Not Delete Please try again!";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}

	 
 

	public function imageDeleted(Request $request, $id)
	{
		$delet_data = HomeSlider::find($id);
 
		if ($delet_data->image != '') {
			$image = json_decode($delet_data->image);
		 
			$thumbnail = '' . $image->src;
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}

		$edit_data = array('image' => "", );
		$del = HomeSlider::where('id', $id)->update($edit_data);
	 
			
		return redirect('developer/home_slider/edit/' . base64_encode($id))->with("success", "Icon image deleted successfully.");
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

 


	/**
	 * Remove the specified resource from storage status.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function status(request $request, $id, $val)
	{
		if ($request->ajax()) {

			$homeSlider = HomeSlider::findOrFail($id);
			$homeSlider->status = $val;

			if ($homeSlider->save()) {
				$status = 1;
				$msg = "status updated successfully !";
			} else {
				$status = 0;
				$msg = "status could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}


}
