<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;
use Auth;
use DB;
use Image;
use App\Models\ChildCategory; //Model

use App\Models\ParentCategory; //Model
use App\Services\SeoLogService;
use App\Services\VersionsServices;
class ChildCategoryController extends Controller
{
	protected $danger_msg = '';
	protected $success_msg = '';
	protected $warning_msg = '';
	protected $info_msg = '';
	public function __construct(SeoLogService $seoLog, VersionsServices $versions)
	{
		$this->seoLog = $seoLog;
		$this->versions = $versions;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		if (!$request->user()->current_user_can('administrator') && (!$request->user()->current_user_can('seo_manager'))) {
			return view('errors.unauthorised');
		}
		$child_categories = DB::table('child_category')
			->join('parent_category', 'child_category.parent_category_id', '=', 'parent_category.id')
			->select('child_category.*', 'parent_category.parent_category')->orderBy('id', 'desc')
			->get();
		$parent_categories = ParentCategory::all();
		return view('admin/child_category', ['child_categories' => $child_categories, 'parent_categories' => $parent_categories]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		if (!$request->user()->current_user_can('administrator') && (!$request->user()->current_user_can('seo_manager'))) {
			return view('errors.unauthorised');
		}
		$validator = Validator::make($request->all(), [
			'child_category' => 'required|max:255|unique:child_category'
		]);

		if ($request->hasFile('pc_icon')) {
			$validator = Validator::make($request->all(), [
				'pc_icon' => 'required|mimes:jpeg,png,jpg,svg,webp',
			]);
		}


		if ($validator->fails()) {
			return redirect("developer/child_category")
				->withErrors($validator)
				->withInput();
		}




		$child_category = new ChildCategory;
		$child_category->child_category = $request->input('child_category');
		$child_category->child_slug = generate_slug($request->input('child_category'));
		$child_category->parent_category_id = $request->input('parent_category_id');

		if ($request->hasFile('pc_icon')) {

			$alt = $request->input('child_category');
			$filePath = getFolderCategoryStructure();
			$destinationPath = public_path($filePath);
			$filename = $this->saveImageSmart(
				$request->file('pc_icon'),
				$destinationPath,
				150,
				150
			);

			$image['pc_icon'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
			);
			$child_category->pc_icon = serialize($image);
		}



		if ($request->hasFile('child_banner')) {
			$filePath = getFolderCategoryStructure();
			$alt = $request->input('child_category');
			$destinationPath = public_path($filePath);
			$filename = $this->saveImageSmart(
				$request->file('child_banner'),
				$destinationPath,
				1200,
				190
			);

			$image['child_banner'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
			);
			$child_category->child_banner = serialize($image);

		}




		$child_category->save();
		$this->success_msg .= 'Child Category added succesfully!';
		$request->session()->flash('success_msg', $this->success_msg);
		return redirect("developer/child_category");
	}


	public function getchildCategoryPagination(Request $request)
	{
		if ($request->ajax()) {

			$childCategory = ChildCategory::join('parent_category', 'child_category.parent_category_id', '=', 'parent_category.id')
				->select('child_category.*', 'parent_category.parent_category')->orderBy('id', 'desc');
			if ($request->input('search.value') != '') {
				$childCategory = $childCategory->where(function ($query) use ($request) {
					$query->orWhere('child_category', 'LIKE', '%' . $request->input('search.value') . '%');

				});
			}


			$childCategory = $childCategory->paginate($request->input('length'));
			$recordCollection = [];
			$data = [];
			$recordCollection['draw'] = $request->input('draw');
			$recordCollection['recordsTotal'] = $childCategory->total();
			$recordCollection['recordsFiltered'] = $childCategory->total();

			foreach ($childCategory as $child) {
				$catImg = "";

				if (!empty($child->child_banner)) {

					$cicons = @unserialize($child->child_banner);

					if (is_array($cicons) && isset($cicons['child_banner']['src'])) {
						$imgPath = asset($cicons['child_banner']['src']);
						$catImg = '<img loading="lazy" src="' . $imgPath . '" width="100">';
					}
				}


				$catIcon = "";

				if (!empty($child->pc_icon)) {

					$vicons = @unserialize($child->pc_icon);

					if (is_array($vicons) && isset($vicons['pc_icon']['src'])) {
						$iconPath = asset($vicons['pc_icon']['src']);

						$catIcon = '<img loading="lazy" src="' . $iconPath . '" width="100">';
					}
				}


				$status = "";
				$action = "";

				if ($child->status == '1') {
					$status = '<a href="javascript:ChildController.status(' . $child->id . ',0)" 
				title="category status" class="btn btn-success">Active</a>';
				} else {
					$status = '<a href="javascript:ChildController.status(' . $child->id . ',1)" 
				title="category status" class="btn btn-danger">Inactive</a>';
				}
				$action = '';

				// Edit button
				$action .= '<a href="' . url('developer/editChildCategory/' . $child->id) . '">
                <i class="fa fa-edit fa-fw" aria-hidden="true"></i>
            </a>';

				 
				if (
					Auth::user()->current_user_can('administrator') ||
					Auth::user()->current_user_can('delete_child_category')
				) {

					$action .= ' <a href="javascript:void(0)" 
                    onclick="deleteChildCategory(' . $child->id . ', this)">
                    <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                 </a>';
				}
				$data[] = [
					$child->child_category,
					$child->parent_category,
					$catImg,
					$catIcon,				 
					$status,
					$action
				];
			}
			$recordCollection['data'] = $data;
			return response()->json($recordCollection);


		}
	}


	public function editChildCategory(Request $request, $id)
	{

		$edit_data = ChildCategory::findOrFail($id);

		if (!$request->user()->current_user_can('administrator') && (!$request->user()->current_user_can('seo_manager'))) {
			return view('errors.unauthorised');
		}
		$child_categories = DB::table('child_category')
			->join('parent_category', 'child_category.parent_category_id', '=', 'parent_category.id')
			->select('child_category.*', 'parent_category.parent_category')
			->get();
		$parent_categories = ParentCategory::all();
		return view('admin/editChildCategory', ['child_categories' => $child_categories, 'parent_categories' => $parent_categories, 'edit_data' => $edit_data]);
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



	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function storeChildCategory(Request $request)
	{

		if (!$request->user()->current_user_can('administrator') && (!$request->user()->current_user_can('seo_manager'))) {
			return view('errors.unauthorised');
		}


		$validator = Validator::make($request->all(), [
			'child_category' => 'required|max:255|unique:child_category,child_category,' . $request->input('id')
		]);


		if ($request->hasFile('pc_icon')) {
			$validator = Validator::make($request->all(), [
				'pc_icon' => 'required|mimes:jpeg,png,jpg,svg,webp',
			]);
		}

		if ($validator->fails()) {
			return redirect("developer/editChildCategory/" . $request->input('id'))
				->withErrors($validator)
				->withInput();
		}


		$child_category = ChildCategory::find($request->input('id'));
		$child_category->child_category = $request->input('child_category');
		$child_category->child_slug = generate_slug($request->input('child_category'));
		$child_category->parent_category_id = $request->input('parent_category_id');

		if ($request->hasFile('pc_icon')) {
			$filePath = getFolderCategoryStructure();
			$alt = $request->input('child_category');
			$destinationPath = public_path($filePath);
			$filename = $this->saveImageSmart(
				$request->file('pc_icon'),
				$destinationPath,
				90,
				90
			);

			$image['pc_icon'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
			);
			$child_category->pc_icon = serialize($image);

		}

		// else{
		// 	$child_category->pc_icon = $child_category->category_banner;
		// }

		if ($request->hasFile('child_banner')) {
			$filePath = getFolderCategoryStructure();
			$alt = $request->input('child_category');
			$destinationPath = public_path($filePath);
			$filename = $this->saveImageSmart(
				$request->file('child_banner'),
				$destinationPath,
				1200,
				190
			);

			$image['child_banner'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
			);
			$child_category->child_banner = serialize($image);

		}
		// if ($request->hasFile('child_banner')) {
		// 	$image = [];
		// 	$filePath = getFolderCourseStructure();
		// 	$file = $request->file('child_banner');
		// 	$bannefilename = $file->getClientOriginalName();
		// 	$destinationPath = public_path($filePath);
		// 	$nameArr = explode('.', $bannefilename);
		// 	$ext = array_pop($nameArr);
		// 	$name = implode('_', $nameArr);
		// 	if (file_exists($destinationPath . '/' . $bannefilename)) {
		// 		$bannefilename = $name . "_" . time() . '.' . $ext;
		// 	}
		// 	$file->move($destinationPath, $bannefilename);

		// 	$image['child_banner'] = array(
		// 		'name' => $bannefilename,
		// 		'alt' => $bannefilename,
		// 		'src' => $filePath . "/" . $bannefilename
		// 	);

		// 	$child_category->child_banner = serialize($image);
		// } else {

		// 	$child_category->child_banner = $child_category->child_banner;
		// }


		$child_category->save();
		$this->success_msg .= 'Child Category updated succesfully!';
		$request->session()->flash('success_msg', $this->success_msg);
		return redirect("developer/child_category");


	}



	public function imageDeleted(Request $request, $id)
	{
		$delet_data = ChildCategory::find($id);

		if ($delet_data->pc_icon != '') {
			$image = unserialize($delet_data->pc_icon);
			$thumbnail = '' . $image['pc_icon']['src'];
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}

		$edit_data = array('pc_icon' => "", );
		$del = ChildCategory::where('id', $id)->update($edit_data);
		return redirect('developer/editChildCategory/' . $id)->with("success", "Icon image deleted successfully.");
	}

	public function bannerDeleted(Request $request, $id)
	{
		$delet_data = ChildCategory::find($id);

		if ($delet_data->child_banner != '') {
			$image = unserialize($delet_data->child_banner);
			$thumbnail = '' . $image['child_banner']['src'];
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}

		$edit_data = array('child_banner' => "", );
		$del = ChildCategory::where('id', $id)->update($edit_data);
		return redirect('developer/editChildCategory/' . $id)->with("success", "Icon image deleted successfully.");
	}




	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{

		if ($request->ajax()) {
			if (!$request->user()->current_user_can('administrator') && (!$request->user()->current_user_can('seo_manager'))) {
				return response()->json(['status' => 0, 'msg' => 'Unauthorised access'], 200);
			}
			$child_category = ChildCategory::find($id);
			$request->session()->put('childCategoryToUpdate', $child_category->id);

			return response()->json(['status' => 1, 'child' => $child_category]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{

		if (!$request->user()->current_user_can('administrator') && (!$request->user()->current_user_can('seo_manager'))) {
			return view('errors.unauthorised');
		}
		if ($request->session()->has('childCategoryToUpdate')) {

			$validator = Validator::make($request->all(), [
				'child_category' => 'required|max:255|unique:child_category,child_category,' . $request->input('id')
			]);


			if ($validator->fails()) {
				return redirect("developer/child_category")
					->withErrors($validator)
					->withInput();
			}

			$childCategoryToUpdate = $request->session()->get('childCategoryToUpdate');
			if ($childCategoryToUpdate == $request->input('id')) {
				$child_category = ChildCategory::find($childCategoryToUpdate);
				$child_category->child_category = $request->input('child_category');
				$child_category->child_slug = generate_slug($request->input('child_category'));
				$child_category->parent_category_id = $request->input('parent_category_id');
				$child_category->save();
				$this->success_msg .= 'Child Category updated succesfully!';
				$request->session()->flash('success_msg', $this->success_msg);
				return redirect("developer/child_category");
			}
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
		//
		if ($request->ajax()) {
			if (!$request->user()->current_user_can('administrator')) {
				return response()->json(['status' => 0, 'msg' => 'Unauthorised access'], 200);
			}
			ChildCategory::destroy($id);
			return response()->json(['status' => 1, 'msg' => 'Child Category deleted succesfully!!']);
		}
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

			$parentCategory = ChildCategory::findOrFail($id);
			$parentCategory->status = $val;

			if ($parentCategory->save()) {
				$status = 1;
				$msg = "status updated successfully !";
			} else {
				$status = 0;
				$msg = "status could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateAboutChildCategory(Request $request, $id)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return response()->json(['status' => 1, 'errors' => 'errors unauthorised'], 400);
		}

		if (empty($id) || is_null($id)) {
			$danger_msg = 'Child Category cannot be null or blank.';
			return response()->json(['status' => 1, 'errors' => $danger_msg], 400);
		}
		$validator = Validator::make($request->all(), [
			'heading' => 'required|min:3|max:275',
			'paragraph1' => 'required|min:10|max:160',
			'courseabout' => 'required|min:45',
			'paragraph2' => 'required',
			'paragraph3' => 'required',

		]);

		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}


		$i = 0;

		$kwObj = ChildCategory::findOrFail($id);

		if ($kwObj) {
			$kwObj->heading = $request->input('heading');
			$kwObj->paragraph1 = $request->input('paragraph1');
			$kwObj->courseabout = $request->input('courseabout');
			$kwObj->paragraph2 = $request->input('paragraph2');
			$kwObj->paragraph3 = $request->input('paragraph3');
			$kwObj->paragraph4 = $request->input('paragraph4');
			$kwObj->paragraph5 = $request->input('paragraph5');
			$kwObj->paragraph6 = $request->input('paragraph6');


			if ($kwObj->isDirty()) {
				$originalValues = $kwObj->getOriginal();
				$changes = [];
				foreach ($kwObj->getDirty() as $field => $newValue) {
					$changes[$field] = json_encode([
						'old' => $originalValues[$field] ?? null,
						'new' => $newValue,
					]);

					$versionData['version'] = $kwObj->id;
					$versionData['updated_by'] = Auth::id();
					$versionData['table'] = "keyword";
					$versionData['attributes'] = $kwObj->keyword;
					$versionData['description'] = json_encode($changes);
				}
				$this->seoLog->createSeoLog($versionData);
			}
		}

		if (!empty($kwObj->save())) {
			$status = 1;
			$msg = "Child Category Update submitted successfully!";

		} else {
			$status = 0;
			$msg = "Child Category Update could not be submitted!";
		}

		return response()->json(['status' => $status, 'msg' => $msg], 200);
	}

}
