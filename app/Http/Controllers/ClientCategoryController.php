<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Image;
use Illuminate\Support\Facades\Input; 
use App\Models\ClientCategory; 

class ClientCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}
		$clientCategories = clientCategory::all();
		return view('admin.client_category', ['clientCategories' => $clientCategories]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
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
			if (!$request->user()->current_user_can('administrator')) {
				return response()->json(['status' => 0, 'message' => 'Unauthorised access'], 200);
			}
			$validator = Validator::make($request->all(), [
				'client_category_name' => 'required',
				'client_category_image' => 'mimes:jpeg,jpg|max:2048',
			]);
			if ($validator->fails()) {
				return response()->json(['status' => 0]);
			}

			$clientCategory = new ClientCategory;
			$clientCategory->name = $request->input('client_category_name');

			// PROFILE PICTURE
			// ***************
			if ($request->hasFile('client_category_image')) {
				$image = [];
				$filePath = getFolderStructure();
				$file = Input::file('client_category_image');
				$filename = $file->getClientOriginalName();
				$destinationPath = public_path($filePath);
				$nameArr = explode('.', $filename);
				$ext = array_pop($nameArr);
				$name = implode('_', $nameArr);
				if (file_exists($destinationPath . '/' . $filename)) {
					$filename = $name . "_" . time() . '.' . $ext;
				}
				$file->move($destinationPath, $filename);
				//$client->logo = $filePath."/".$filename;
				$img = Image::make($destinationPath . '/' . $filename);
				$image['large'] = array(
					'name' => $filename,
					'alt' => $filename,
					'width' => $img->width() . 'px',
					'height' => $img->height() . 'px',
					'src' => $filePath . "/" . $filename
				);
				if ($img->width() > 150) {
					$h = $img->height();
					$w = $img->width();
					$newHeight = ($h * 150) / $w;
					$img->resize(150, $newHeight);
					$name = $name . "_" . time();
					$name .= '_150x' . $newHeight . '.' . $ext;
					$img->save($destinationPath . '/' . $name);
					//$client->logo = $filePath.'/'.$name;
					$image['thumbnail'] = array(
						'name' => $name,
						'alt' => $name,
						'width' => '150px',
						'height' => $newHeight . 'px',
						'src' => $filePath . "/" . $name
					);
				}
				$clientCategory->image = serialize($image);
			}
			// ***************
			// PROFILE PICTURE

			 
			if ($clientCategory->save()) {
				return response()->json(['status' => 1, 'clientCategory' => $clientCategory]);
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}
		$clientCategory = ClientCategory::find($id);
		return view('admin.client_category_update', ['client_category' => $clientCategory]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}
		$validator = Validator::make($request->all(), [
			'client_category_name' => 'required',
			'client_category_image' => 'mimes:jpeg,jpg|max:2048',
		]);
		if ($validator->fails()) {
			return redirect("/developer/clients/categories/update/" . $id)
				->withErrors($validator)
				->withInput();
		}

		$clientCategory = ClientCategory::find($id);
		$clientCategory->name = $request->input('client_category_name');

		// PROFILE PICTURE
		// ***************
		if ($request->hasFile('client_category_image')) {
			$image = [];
			$filePath = getFolderStructure();
			$file = Input::file('client_category_image');
			$filename = $file->getClientOriginalName();
			$destinationPath = public_path($filePath);
			$nameArr = explode('.', $filename);
			$ext = array_pop($nameArr);
			$name = implode('_', $nameArr);
			if (file_exists($destinationPath . '/' . $filename)) {
				$filename = $name . "_" . time() . '.' . $ext;
			}
			$file->move($destinationPath, $filename);
			//$client->logo = $filePath."/".$filename;
			$img = Image::make($destinationPath . '/' . $filename);
			$image['large'] = array(
				'name' => $filename,
				'alt' => $filename,
				'width' => $img->width() . 'px',
				'height' => $img->height() . 'px',
				'src' => $filePath . "/" . $filename
			);
			if ($img->width() > 150) {
				$h = $img->height();
				$w = $img->width();
				$newHeight = ($h * 150) / $w;
				$img->resize(150, $newHeight);
				$name = $name . "_" . time();
				$name .= '_150x' . $newHeight . '.' . $ext;
				$img->save($destinationPath . '/' . $name);
				//$client->logo = $filePath.'/'.$name;
				$image['thumbnail'] = array(
					'name' => $name,
					'alt' => $name,
					'width' => '150px',
					'height' => $newHeight . 'px',
					'src' => $filePath . "/" . $name
				);
			}
			if (!empty($clientCategory->image)) {
				$oldImages = unserialize($clientCategory->image);
			}
			$clientCategory->image = serialize($image);
		}
		 
		if ($clientCategory->save()) {
			if (isset($oldImages)) {
				foreach ($oldImages as $oldImage) {
					try {
						if (!unlink(public_path($oldImage['src'])))
							throw new Exception("Old image not deleted...");
					} catch (Exception $e) {
						echo $e->getMessage();
					}
				}
			}
			return redirect("/developer/clients/categories/update/" . $id);
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
			if (!$request->user()->current_user_can('administrator')) {
				return response()->json(['status' => 0, 'message' => 'Unauthorised access'], 200);
			}
			$clientCategory = ClientCategory::find($id);
			if (!empty($clientCategory->image)) {
				$oldImages = unserialize($clientCategory->image);
				if (isset($oldImages)) {
					foreach ($oldImages as $oldImage) {
						try {
							if (!unlink(public_path($oldImage['src'])))
								throw new Exception("Old image not deleted...");
						} catch (Exception $e) {
							echo $e->getMessage();
						}
					}
				}
			}
			if ($clientCategory->delete()) {
				return response()->json(['status' => 1, 'clientCategory' => $clientCategory]);
			}
		}
	}
}
