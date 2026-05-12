<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use App\Models\Author; 
use App\Models\FormType; 

class AuthorController extends Controller
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
		$Authors = Author::orderBy('id', 'desc')->get();	
		$data['title'] = "All Author";
		$data['header'] = "All Author";		
		return view('admin.author.index', ['Authors' => $Authors,'data'=>$data]);
	}

/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function authorAdd()
	{
		$data['title'] = "Add Author";
		$data['header'] = "Add Author";
		return view('admin.author.index', ['data' => $data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		 
		 
		$validator = Validator::make($request->all(), [
			'image' => 'required|mimes:jpeg,png,jpg,svg,webp',		 
			'name' => 'required',		 
			// 'comment' => 'nullable',		 
		]);

		if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


		$author = new Author;
		$author->linkedin_url = $request->input('linkedin_url');		 
		$author->name = $request->input('name');		 
		$author->comment = $request->input('comment');		 
		$alt = $request->input('name');
		 

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
			$author->image = json_encode($image);				 
		} 

		 

 
		
			if ($author->save()) {
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
		 
			
			$edit_data = Author::find(base64_decode($id));	
 			
			$data['title'] = "Edit author";
			$data['header'] = "Edit author";
			return view('admin.author.index', ['edit_data' => $edit_data,'data'=>$data]);
		 
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
			$author = Author::find($id);	
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
				$author->image = json_encode($image);

				} 
 
	 		 
			$author->linkedin_url = $request->input('linkedin_url');		 
			$author->name = $request->input('name');		 
			$author->comment = $request->input('comment');	
		
		if ($author->save()) {
				$status = true;
				$msg = "Update successfully!";

			} else {
				$status = false;
				$msg = "Update, Please try again!";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
			
	}



	public function getAuthorPagination(Request $request)
	{

		if ($request->ajax()) {

			$authors = Author::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {

				$authors = $authors->where(function ($query) use ($request) {
					$query->where('name', 'LIKE', '%' . $request->input('search.value') . '%');
					 
						 
				});
			}
			$authors = $authors->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $authors->total();
			$returnLeads['recordsFiltered'] = $authors->total();
			$returnLeads['recordCollection'] = [];
			foreach ($authors as $author) {

				$action = '';
				$separator = '';
				$action .= '<a href="/developer/author/edit/' . base64_encode($author->id) . '" title="slider Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';


				if ($author->id > 3) {
					$action .= '<a href="javascript:AuthorController.delete(' . $author->id . ')" title="Delete slider" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

				$status="";
				if ($author->status == '1') {
					$status .= '<a href="javascript:AuthorController.status(' . $author->id . ',0)" title="slider status" class="btn btn-success" >Active</a>';
				} else {
					$status .= '<a href="javascript:AuthorController.status(' . $author->id . ',1)" title="slider status" class="btn btn-danger" >Inactive</a>';
				}


				if (!empty($author->image)) {
				$vicons = json_decode($author->image, true);
				 
				$icons = '<img loading="lazy" src="' . asset('/' . $vicons['src']) . '" width="70px">';
				} else {
				$icons = "";
				}
				$data[] = [
					"<th><input type='checkbox' class='check-box' value='$author->id'></th>",
					$author->name,				 
					$icons,				 
					$status,				 
					$action

				];
				$returnLeads['recordCollection'][] = $author->id;
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
			 
			$delet_data = Author::find($id);
			if ($delet_data->image != '') {
			$image = json_decode($delet_data->image);			 
			$thumbnail = ''. $image->src;		 
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}
		 
		
		if (Author::destroy($id)) {
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
		$delet_data = Author::find($id);
 
		if ($delet_data->image != '') {
			$image = json_decode($delet_data->image);
		 
			$thumbnail = '' . $image->src;
			if (file_exists($thumbnail)) {
				unlink($thumbnail);
			}
		}

		$edit_data = array('image' => "", );
		$del = Author::where('id', $id)->update($edit_data);
	 
			
		return redirect('developer/author/edit/' . base64_encode($id))->with("success", "Icon image deleted successfully.");
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

			$author = Author::findOrFail($id);
			$author->status = $val;

			if ($author->save()) {
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
