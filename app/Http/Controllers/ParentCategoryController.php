<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Validator;
use Auth;
use App\Models\ParentCategory; 
use App\Models\FormType; 
use App\Services\SeoLogService;
use App\Services\VersionsServices;
class ParentCategoryController extends Controller
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
		$parent_categories = ParentCategory::orderBy('id', 'desc')->get();
		$formType = FormType::orderBy('id', 'desc')->get();
		return view('admin/parent_category', ['parent_categories' => $parent_categories,'formType'=>$formType]);
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
			'parent_category' => 'required|max:255|unique:parent_category'
		]);

		if ($validator->fails()) {
			return redirect("developer/parent_category")
				->withErrors($validator)
				->withInput();
		}



		$parent_category = new ParentCategory;
		$parent_category->parent_category = $request->input('parent_category');
		$parent_category->parent_slug = generate_slug($request->input('parent_category'));
		$alt = $request->input('parent_category');
	 

		if ($request->hasFile('category_icon')) {
			$filePath = getFolderCategoryStructure();
			$destinationPath = public_path($filePath);
				$filename = $this->saveImageSmart(
					$request->file('category_icon'),
					$destinationPath,
					90,
					90
				);

				$image['category_icon'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
				);
			$parent_category->category_icon = serialize($image);
				 
		} 

		if ($request->hasFile('category_banner')) {
			$image = [];
			$filePath = getFolderCategoryStructure();
			$file = $request->file('category_banner');
			$filename = $file->getClientOriginalName();
			$destinationPath = public_path($filePath);
			$nameArr = explode('.', $filename);
			$ext = array_pop($nameArr);
			$name = implode('_', $nameArr);
			if (file_exists($destinationPath . '/' . $filename)) {
				$filename = $name . "_" . time() . '.' . $ext;
			}
			$file->move($destinationPath, $filename);

			$image['category_banner'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
			);

			$parent_category->category_banner = serialize($image);
		}


		if ($parent_category->save()) {
			$this->success_msg .= 'Parent Category added succesfully!';
			$request->session()->flash('success_msg', $this->success_msg);
		} else {
			$this->danger_msg .= 'Parent Category not added!';
			$request->session()->flash('danger_msg', $this->danger_msg);
		}
		return redirect("developer/parent_category");
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
			$parent_category = ParentCategory::find($id);
			$formType = FormType::orderBy('id', 'desc')->get();
			$request->session()->put('parentCategoryToUpdate', $parent_category->id);
			return response()->json(['status' => 1, 'msg' => '<input type="hidden" name="_token" value="' . csrf_token() . '"><input type="hidden" value="' . $parent_category->id . '" name="id"><div class="form-group"><label>Enter the name:</label><input type="text" name="parent_category" class="form-control" value="' . $parent_category->parent_category . '"></div><div class="form-group"><label>Enter the ICON:</label><input type="text" name="pc_icon" class="form-control" value="' . $parent_category->pc_icon . '" placeholder="fa fa-fw fa-icon_name"></div>']);
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
		if ($request->session()->has('parentCategoryToUpdate')) {

			$validator = Validator::make($request->all(), [
				'parent_category' => 'required|max:255|unique:parent_category,parent_category,' . $request->input('id')
			]);

			if ($validator->fails()) {
				return redirect("developer/parent_category")
					->withErrors($validator)
					->withInput();
			}

			$parentCategoryToUpdate = $request->session()->get('parentCategoryToUpdate');
			if ($parentCategoryToUpdate == $request->input('id')) {
				$parent_category = ParentCategory::find($parentCategoryToUpdate);
				$parent_category->parent_category = $request->input('parent_category');
				$parent_category->parent_slug = generate_slug($request->input('parent_category'));
				$parent_category->pc_icon = $request->input('pc_icon');
				$parent_category->save();
				$this->success_msg .= 'Parent Category updated succesfully!';
				$request->session()->flash('success_msg', $this->success_msg);
				return redirect("developer/parent_category");
			}
		}
	}


	public function getParentCategoryPagination(Request $request)
    {    
        if($request->ajax()){
			
			$category = ParentCategory::orderBy('id','desc');
			if($request->input('search.value')!=''){
				$category = $category->where(function($query) use($request){
				$query->orWhere('parent_category','LIKE','%'.$request->input('search.value').'%');
			 
				});
			}
			$category = $category->paginate($request->input('length'));
			$recordCollection = [];
			$data = [];
			$recordCollection['draw'] = $request->input('draw');
			$recordCollection['recordsTotal'] = $category->total();
			$recordCollection['recordsFiltered'] = $category->total();
	 
			foreach($category as $categ){	 
				$catImg = "";

				if (!empty($categ->category_banner)) {

				$cicons = @unserialize($categ->category_banner);

				if (is_array($cicons) && isset($cicons['category_banner']['src'])) {
					$imgPath = asset($cicons['category_banner']['src']);
					$catImg = '<img loading="lazy" src="'.$imgPath.'" width="100">';
				}
				}


					$catIcon = "";

					if (!empty($categ->category_icon)) {

					$vicons = @unserialize($categ->category_icon);

					if (is_array($vicons) && isset($vicons['category_icon']['src'])) {
					$iconPath = asset($vicons['category_icon']['src']);

					$catIcon = '<img loading="lazy" src="'.$iconPath.'" width="100">';
					}
					}


				$status = "";

				if ($categ->status == '1') {
				$status = '<a href="javascript:CategoryController.status('.$categ->id.',0)" 
				title="category status" class="btn btn-success">Active</a>';
				} else {
				$status = '<a href="javascript:CategoryController.status('.$categ->id.',1)" 
				title="category status" class="btn btn-danger">Inactive</a>';
				}
				$editLink = '<a href="'.url('developer/editCategory/'.$categ->id).'">
                <i class="fa fa-edit fa-fw" aria-hidden="true"></i>
             </a>';
				$data[] = [
					$categ->parent_category,
					$catImg,				  					
					$catIcon,		
					$categ->form_type,	
					$status,
					$editLink 
				];
			}
			$recordCollection['data'] = $data;
			return response()->json($recordCollection);
			
			
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
			if (!$request->user()->current_user_can('administrator') && (!$request->user()->current_user_can('seo_manager'))) {
				return response()->json(['status' => 0, 'msg' => 'Unauthorised access'], 200);
			}
			ParentCategory::destroy($id);
			return response()->json(['status' => 1, 'msg' => 'Parent Category deleted succesfully!!']);
		}
	}

	public function editCategory(Request $request, $id)
	{

		$edit_data = ParentCategory::findOrFail($id);
		$formType = FormType::orderBy('id', 'desc')->get();
		return view('admin/category/editCategory', ['edit_data' => $edit_data,'formType'=>$formType]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editStoreCategory(Request $request)
	{

		if (!$request->user()->current_user_can('administrator') && (!$request->user()->current_user_can('seo_manager'))) {
			return view('errors.unauthorised');
		}


		$validator = Validator::make($request->all(), [
			'parent_category' => 'required|max:255|unique:parent_category,parent_category,' . $request->input('id')
		]);
		if ($validator->fails()) {
			return redirect("developer/editCategory/" . $request->input('id'))
				->withErrors($validator)
				->withInput();
		}


		$category = ParentCategory::find($request->input('id'));
		$category->parent_category = $request->input('parent_category');
		$category->form_type = $request->input('form_type');
		$category->parent_slug = generate_slug($request->input('parent_category'));

		$alt = $request->input('parent_category');
		if ($request->hasFile('category_icon')) {
			$filePath = getFolderCategoryStructure();
			$destinationPath = public_path($filePath);
				$filename = $this->saveImageSmart(
					$request->file('category_icon'),
					$destinationPath,
					90,
					90
				);

				$image['category_icon'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
				);
			$category->category_icon = serialize($image);
				 
			} 

		 
		if ($request->hasFile('category_banner')) {
			$filePath = getFolderCategoryStructure();
			$destinationPath = public_path($filePath);
				$filename = $this->saveImageSmart(
					$request->file('category_banner'),
					$destinationPath,
					1200,
					190
				);

				$image['category_banner'] = array(
				'name' => $filename,
				'alt' => $alt,
				'src' => $filePath . "/" . $filename
				);
			$category->category_banner = serialize($image);
				 
			}
			
			// else{
			// 	$category->category_banner = $category->category_banner;
			// }
		 


		$category->save();
		$this->success_msg .= 'Category updated succesfully!';
		$request->session()->flash('success_msg', $this->success_msg);
		return redirect("developer/parent_category");


	}



	public function imageDeleted(Request $request, $id)
	{
		$delet_data = ParentCategory::find($id);

		if ($delet_data->category_icon != '') {
			$image = unserialize($delet_data->category_icon);
			$thumbnail = '' . $image['category_icon']['src'];
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}

		$edit_data = array('category_icon' => "", );
		$del = ParentCategory::where('id', $id)->update($edit_data);
		return redirect('developer/editCategory/' . $id)->with("success", "Icon image deleted successfully.");
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


	public function imageBannerDeleted(Request $request, $id)
	{
		$delet_data = ParentCategory::find($id);

		if ($delet_data->category_banner != '') {
			$image = unserialize($delet_data->category_banner);
			$thumbnail = '' . $image['category_banner']['src'];
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}

		$edit_data = array('category_banner' => "", );
		$del = ParentCategory::where('id', $id)->update($edit_data);
		return redirect('developer/editCategory/' . $id)->with("success", "Icon image deleted successfully.");
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

			$parentCategory = ParentCategory::findOrFail($id);
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
	public function updateAboutCategory(Request $request, $id)
	{ 
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('edit_SEO'))) {
			return response()->json(['status' => 1, 'errors' => 'errors unauthorised'], 400);
		}

		if (empty($id) || is_null($id)) {
			$danger_msg = 'Category cannot be null or blank.';
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

		$kwObj = ParentCategory::findOrFail($id);

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
			$msg = "Category Update submitted successfully!";

		} else {
			$status = 0;
			$msg = "Category Update could not be submitted!";
		}

		return response()->json(['status' => $status, 'msg' => $msg], 200);
	}

	  



}
