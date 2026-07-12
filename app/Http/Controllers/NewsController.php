<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\NewsArticle;
use App\Models\ChildCategory;
use App\Models\Author;
use Image;
use Auth;
use Validator;

class NewsController extends Controller
{
	/**
	 * Create a new controller instance.
	 *	
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{


		return view('admin.news.index');
	}

	/**
	 * add services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function add(Request $request)
	{

	date_default_timezone_set('Asia/Kolkata');
		$data['button'] = "Save";
		$data['authors'] = Author::where('status','1')->get();
		$data['childs'] = ChildCategory::orderBy('child_category', 'asc')->get();
		if ($request->isMethod('post') && $request->input('submit') == "Save") {



			$validator = Validator::make($request->all(), [
				'name' => 'required|string|min:10|max:165',
				'ratingvalue' => 'required|numeric|min:0|max:99999',
				'ratingcount' => 'required|integer|min:0',
				'title' => 'required|string|min:50|max:175',
				'slug' => 'required|string|min:50|max:175',
				'meta_title' => 'required|string|min:50|max:85',
				'h1_heading' => 'required|string|max:255',
				'meta_description' => 'required|string|min:150|max:165',
				'description' => 'required|string|max:500',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			$news = new NewsArticle;
			$news->name = $request->input('name');
			$news->author = $request->input('author');
			$news->title = $request->input('title');
			$news->slug = generate_slug($request->input('title'));
			$news->description = $request->input('description');
			$news->meta_title = $request->input('meta_title');
			$news->h1_heading = $request->input('h1_heading');
			$news->meta_description = $request->input('meta_description');

			if ($news->save()) {
				return redirect('/developer/news/news')->with('success', 'news Details successfully added!');
			} else {
				return redirect('/developer/news/news')->with('failed', 'news Details not added!');

			}
		}
		return view('admin.news.index', $data);
	}
	/**
	 * add services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function addNews(Request $request)
	{
		date_default_timezone_set('Asia/Kolkata');
		if ($request->ajax()) {
			try {
				$validator = Validator::make($request->all(), [
					'name' => 'required|string|min:3|max:165',
					'ratingvalue' => 'required|numeric|min:0|max:99999',
					'ratingcount' => 'required|integer|min:0',
					'title' => 'required|string|min:10|max:175',

					'meta_title' => 'required|string',
					'h1_heading' => 'required|string|max:255',
					'meta_description' => 'required|string',

				]);

				if ($validator->fails()) {
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
				}


				$news = new NewsArticle;
				$news->name = $request->input('name');
				$news->author = $request->input('author');
				$news->title = $request->input('title');
				$news->slug = generate_slug($request->input('title'));
				$news->description = $request->input('description');
				$news->meta_title = $request->input('meta_title');
				$news->h1_heading = $request->input('h1_heading');
				$news->meta_description = $request->input('meta_description');
				$news->ratingvalue = $request->input('ratingvalue');
				$news->ratingcount = $request->input('ratingcount');


				$category = ChildCategory::where('id',$request->input('category'))->first();

				if(!empty($category)){
				$news->category_id = $category->id;
				$news->category_name = $category->child_slug;
				}
				if ($news->save()) {
					return response()->json([
						'status' => true,
						'msg' => 'news Add successfully'
					], 200);
				}

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'news not added'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}
		}

	}

	private function saveImageSmart($file, $destinationPath, $width = null, $height = null)
	{
		$ext = strtolower($file->getClientOriginalExtension());
		$name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
		$name = str_replace(' ', '_', $name);
		$filename =  time() . rand(1000,9999);

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

	/*
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{

		date_default_timezone_set('Asia/Kolkata');
		$data['edit_data'] = NewsArticle::find($id);
		$data['authors'] = Author::where('status','1')->get();
		$data['childs'] = ChildCategory::orderBy('child_category', 'asc')->get();
		$data['button'] = "Update";
		 
		return view('admin.news.news_update', $data);
	}

	/*
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateNewsMeta(Request $request, $id)
	{

		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [
				'name' => 'required|string|min:3|max:165',
				'ratingvalue' => 'required|numeric|min:0|max:99999',
				'ratingcount' => 'required|integer|min:0',
				'title' => 'required|string',
				'slug' => 'required|string',
				'meta_title' => 'required|string',
				'h1_heading' => 'required|string|max:255',
				'meta_description' => 'required|string',
				// 'description' => 'required|string',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

				$news = NewsArticle::findOrFail($id);
				$category = ChildCategory::where('id',$request->category)->first();

			 
				$news->update([
					'name' => $request->name,
					'author' => $request->author,
					'slug' => $request->slug,
					'title' => $request->title,
					// 'description' => $request->description,
					'meta_title' => $request->meta_title,
					'h1_heading' => $request->h1_heading,
					'meta_description' => $request->meta_description,
					'ratingvalue' => $request->ratingvalue,
					'ratingcount' => $request->ratingcount,
					'category_id' => $category->id,
					'category_name' => $category->child_slug,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'news updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'news not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	}

	/*
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateAboutnews(Request $request, $id)
	{

		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [
				'heading' => 'nullable',			 
				'description' => 'required|string',
			 

			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

				$news = NewsArticle::findOrFail($id);

				$news->update([
					'heading' => $request->heading,
					'description' => $request->description,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'News About updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'news not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	}

	/*
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updatePageContent(Request $request, $id)
	{

		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [

				'top_content' => 'nullable|string',
				'bottom_content' => 'nullable|string',

			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

				$news = NewsArticle::findOrFail($id);
 
				$news->update([
					'top_content' => $request->top_content,
					'bottom_content' => $request->bottom_content,
					'bottom_heading' => $request->bottom_heading,
					'top_heading' => $request->top_heading,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'news Description updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'news not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	}

	/*
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateFaqNews(Request $request, $id)
	{

		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [

				'faqq1' => 'nullable|string|max:1999',
				'faqa1' => 'nullable|string|max:1999',
				'faqq2' => 'nullable|string|max:1999',
				'faqa2' => 'nullable|string|max:1999',
				'faqq3' => 'nullable|string|max:1999',
				'faqa3' => 'nullable|string|max:1999',
				'faqq4' => 'nullable|string|max:1999',
				'faqa4' => 'nullable|string|max:1999',
				'faqq5' => 'nullable|string|max:1999',
				'faqa5' => 'nullable|string|max:1999',

			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

				$news = NewsArticle::findOrFail($id);

				$news->update([
					'faqq1' => $request->faqq1,
					'faqa1' => $request->faqa1,
					'faqq2' => $request->faqq2,
					'faqa2' => $request->faqa2,
					'faqq3' => $request->faqq3,
					'faqa3' => $request->faqa3,
					'faqq4' => $request->faqq4,
					'faqa4' => $request->faqa4,
					'faqq5' => $request->faqq5,
					'faqa5' => $request->faqa5,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'news FAQ updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'news not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	}

	/*
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateNewsImage(Request $request, $id)
	{


		if ($request->ajax()) {
			if ($request->hasFile('image') && $request->hasFile('image_banner')) {
				$validator = Validator::make($request->all(), [

					'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
					'image_banner' => 'nullable|mimes:jpg,jpeg,png,webp|max:4096',

				]);
				if ($validator->fails()) {
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
				}

			}




			try {
				$news = NewsArticle::find($id);

				// LOGO Pictures
				// *************
				$filePath = getFolderNewsStructure();

				if ($request->hasFile('image')) {
					$file = $request->file('image');
					$filename = $file->getClientOriginalName();
					$destinationPath = public_path($filePath);
					$filename = $this->saveImageSmart(
						$request->file('image'),
						$destinationPath,
						900,
						400
					);

					$image['image'] = array(
						'name' => $filename,
						'alt' => $filename,
						'width' => '',
						'height' => '',
						'src' => $filePath . "/" . $filename
					);

				 
					$news->image = json_encode($image);
				}

				if ($request->hasFile('image_banner')) {
					$bannerImage = [];
					$file = $request->file('image_banner');
					$filename = $file->getClientOriginalName();
					$destinationPath = public_path($filePath);

					$filename = $this->saveImageSmart(
						$request->file('image_banner'),
						$destinationPath,
						900,
						250
					);

					$bannerImage['image_banner'] = array(
						'name' => $filename,
						'alt' => $filename,
						'width' => '',
						'height' => '',
						'src' => $filePath . "/" . $filename
					);

				 
					$news->image_banner = json_encode($bannerImage);
				}

				if ($news->save()) {

					if (isset($oldLogoImages)) {
						foreach ($oldLogoImages as $oldImage) {
							try {
								if (!unlink(public_path($oldImage['src'])))
									throw new Exception("Old logo image not deleted...");
							} catch (Exception $e) {
								echo $e->getMessage();
							}
						}
					}
					return response()->json([
						'status' => true,
						'msg' => 'news Description updated successfully'
					], 200);
				}

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'news not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}

		}

	}



	/*
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginationnews(Request $request)
	{
		if ($request->ajax()) {

			$news = NewsArticle::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {
				$news = $news->where(function ($query) use ($request) {
					$query->orWhere('name', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('title', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('slug', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('top_content', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('bottom_content', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('heading', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('about_news', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('meta_title', 'LIKE', '%' . $request->input('search.value') . '%');

				});
			}
			$news = $news->paginate($request->input('length'));
			$recordCollection = [];
			$data = [];
			$recordCollection['draw'] = $request->input('draw');
			$recordCollection['recordsTotal'] = $news->total();
			$recordCollection['recordsFiltered'] = $news->total();

			foreach ($news as $news) {
				$image = '';
				$action = '';
				$status = '';
				$separator = ' ';

			 
				if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('edit_news')) {
					$action .= $separator . '<a href="/developer/news/editNews/' . $news->id . '"><i class="fa fa-edit" aria-hidden="true"></i></a>  ';

				}


				if (Auth::user()->current_user_can('administrator')) {
					$action .= $separator . '   <a href="/developer/news/delete/' . $news->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}




				if ($news->status == '1') {
					$status .= '<a href="/developer/news/status/' . $news->id . '/0" class="btn btn-info m-b-5">Active</a>';

				} else {
					$status .= '<a href="/developer/news/status/' . $news->id . '/1" class="btn btn-warning m-b-5">In-Active</a>';
				}

				$data[] = [
					$news->name,
					$news->title,				 
					$status,
					$action,
				];
			}
			$recordCollection['data'] = $data;
			return response()->json($recordCollection);


		}
	}

	public function imageDeleted(Request $request, $id)
	{


		$delet_data = NewsArticle::find($id);

		if ($delet_data->image != '') {

			$image = json_decode($delet_data->image);
		 
			$large = $image->image->src;

		 
			if (file_exists($large)) {
				unlink($large);
			}

		}

		$edit_data = array('image' => "", );
		$del = NewsArticle::where('id', $id)->update($edit_data);
		return redirect('developer/news/editNews/' . $id)->with("success", "news image deleted successfully.");



	}

	public function delNewsBanner(Request $request, $id)
	{
		$delet_data = NewsArticle::find($id);
		if ($delet_data->image_banner != '') {

			$image = json_decode($delet_data->image_banner);

			$large = $image->image_banner->src;
			if (file_exists($large)) {
				unlink($large);
			}

		}

		$edit_data = array('image_banner' => "", );
		$del = NewsArticle::where('id', $id)->update($edit_data);
		return redirect('developer/news/editnews/' . $id)->with("success", "news image deleted successfully.");



	}


	public function deleted(Request $request, $id)
	{

		$news = NewsArticle::findorFail($id);

		if ($news->image != '') {

			$image = json_decode($news->image);

	 

			if (!empty($image->image->src)) {
				$large = $image->image->src;
				if (file_exists($large)) {
					unlink($large);
				}
			}
		}
		if ($news->delete()) {
			return redirect('/developer/news/news-list')->with('success', 'news successfully deleted!');
		} else {
			return redirect('/developer/news/news')->with('failed', 'news not deleted!');
		}

	}



	public function status(Request $request, $id, $val)
	{
		$news = NewsArticle::find($id);
		$news->status = $val;
		if ($news->save()) {
			return redirect('developer/news/news-list')->with("success", "Status updated successfully.");
		} else {
			return redirect('developer/news/news-list')->with("failed", "Status updated successfully.");
		}

	}




}
