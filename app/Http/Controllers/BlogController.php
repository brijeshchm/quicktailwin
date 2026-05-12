<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Blogdetails;
use App\Models\Author;
use Image;
use Auth;
use Validator;

class BlogController extends Controller
{
	/**
	 * Create a new controller instance.
	 *	
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{


		return view('admin.blog.index');
	}

	/**
	 * add services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function add(Request $request)
	{

		$data['button'] = "Save";
		$data['authors'] = Author::where('status','1')->get();
		if ($request->isMethod('post') && $request->input('submit') == "Save") {



			$validator = Validator::make($request->all(), [
				'name' => 'required|string|min:10|max:165',
				'ratingvalue' => 'required|numeric|min:0|max:99999',
				'ratingcount' => 'required|integer|min:0',
				'title' => 'required|string|min:50|max:175',
				'slug' => 'required|string|min:50|max:175',
				'meta_title' => 'required|string|min:50|max:85',
				'meta_keywords' => 'required|string|max:255',
				'meta_description' => 'required|string|min:150|max:165',
				'description' => 'required|string|max:500',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			$blogdetails = new Blogdetails;
			$blogdetails->name = $request->input('name');
			$blogdetails->author = $request->input('author');
			$blogdetails->title = $request->input('title');
			$blogdetails->slug = generate_slug($request->input('title'));
			$blogdetails->description = $request->input('description');
			$blogdetails->meta_title = $request->input('meta_title');
			$blogdetails->meta_keywords = $request->input('meta_keywords');
			$blogdetails->meta_description = $request->input('meta_description');

			if ($blogdetails->save()) {
				return redirect('/developer/blog/blogdetails')->with('success', 'Blog Details successfully added!');
			} else {
				return redirect('/developer/blog/blogdetails')->with('failed', 'Blog Details not added!');

			}
		}
		return view('admin.blog.index', $data);
	}
	/**
	 * add services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function addBlog(Request $request)
	{

		if ($request->ajax()) {


			try {
				$validator = Validator::make($request->all(), [
					'name' => 'required|string|min:3|max:165',
					'ratingvalue' => 'required|numeric|min:0|max:99999',
					'ratingcount' => 'required|integer|min:0',
					'title' => 'required|string|min:10|max:175',

					'meta_title' => 'required|string',
					'meta_keywords' => 'required|string|max:255',
					'meta_description' => 'required|string',

				]);

				if ($validator->fails()) {
					$errorsBag = $validator->getMessageBag()->toArray();
					return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
				}


				$blogdetails = new Blogdetails;
				$blogdetails->name = $request->input('name');
				$blogdetails->author = $request->input('author');
				$blogdetails->title = $request->input('title');
				$blogdetails->slug = generate_slug($request->input('title'));
				$blogdetails->description = $request->input('description');
				$blogdetails->meta_title = $request->input('meta_title');
				$blogdetails->meta_keywords = $request->input('meta_keywords');
				$blogdetails->meta_description = $request->input('meta_description');

				if ($blogdetails->save()) {
					return response()->json([
						'status' => true,
						'msg' => 'Blog Add successfully'
					], 200);
				}

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'Blog not added'
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

	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{


		$data['edit_data'] = Blogdetails::find($id);
		$data['authors'] = Author::where('status','1')->get();
		$data['button'] = "Update";
		if ($request->isMethod('post') && $request->input('submit') == "Update") {


			$this->validate($request, [
				'name' => 'required|max:200',
				'description' => 'required',
				// 'image' => 'required',
				'meta_title' => 'required',
				'meta_keywords' => 'required',
				'meta_description' => 'required',

			]);

			$blogdetails = Blogdetails::find($id);
			$blogdetails->name = $request->input('name');
			$blogdetails->author = $request->input('author');
			$blogdetails->slug = generate_slug($request->input('meta_title'));
			$blogdetails->description = $request->input('description');
			$blogdetails->meta_title = $request->input('meta_title');
			$blogdetails->meta_keywords = $request->input('meta_keywords');
			$blogdetails->meta_description = $request->input('meta_description');
			$blogdetails->top_content = $request->input('top_content');
			$blogdetails->bottom_content = $request->input('bottom_content');
			//$file = $request->file('logo');
			// LOGO Pictures
			// *************
			$filePath = getFolderBlogStructure();

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

				$image['large'] = array(
					'name' => $filename,
					'alt' => $filename,
					'width' => '',
					'height' => '',
					'src' => $filePath . "/" . $filename
				);

				if (!empty($blogdetails->image)) {
					$oldLogoImages = unserialize($blogdetails->image);
				}
				$blogdetails->image = serialize($image);


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

				$bannerImage['large'] = array(
					'name' => $filename,
					'alt' => $filename,
					'width' => '',
					'height' => '',
					'src' => $filePath . "/" . $filename
				);

				if (!empty($blogdetails->image_banner)) {
					$oldLogoImages = unserialize($blogdetails->image_banner);
				}
				$blogdetails->image_banner = serialize($bannerImage);
			}

			if ($blogdetails->save()) {

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
				return redirect('/developer/blog/blogdetails')->with('success', 'Blog Details successfully Update!');
			} else {
				return redirect('/developer/blog/edit/' . $id)->with('failed', 'Blog details  not Update!');

			}
		}
		return view('admin.blog.blog_update', $data);
	}

	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateBlogMeta(Request $request, $id)
	{

		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [
				'name' => 'required|string|min:3|max:165',
				'ratingvalue' => 'required|numeric|min:0|max:99999',
				'ratingcount' => 'required|integer|min:0',
				'title' => 'required|string',
				'slug' => 'required|string',
				'meta_title' => 'required|string',
				'meta_keywords' => 'required|string|max:255',
				'meta_description' => 'required|string',
				// 'description' => 'required|string',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

				$blogdetails = Blogdetails::findOrFail($id);

				$blogdetails->update([
					'name' => $request->name,
					'author' => $request->author,
					'slug' => $request->slug,
					'title' => $request->title,
					// 'description' => $request->description,
					'meta_title' => $request->meta_title,
					'meta_keywords' => $request->meta_keywords,
					'meta_description' => $request->meta_description,
					'ratingvalue' => $request->ratingvalue,
					'ratingcount' => $request->ratingcount,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'Blog updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'Blog not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	}

	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateAboutBlog(Request $request, $id)
	{

		if ($request->ajax()) {


			$validator = Validator::make($request->all(), [
				// 'heading' => 'required|string|min:10|max:1065',			 
				'description' => 'required|string',
				// 'paragraph1' => 'required|string|max:255',
				// 'paragraph2' => 'nullable|string|max:255',
				// 'paragraph3' => 'nullable|string|max:255',
				// 'paragraph4' => 'nullable|string|max:255',
				// 'paragraph5' => 'nullable|string|max:255',
				// 'paragraph6' => 'nullable|string|max:255',

			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();
				return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
			}


			try {

				$blogdetails = Blogdetails::findOrFail($id);

				$blogdetails->update([
					// 'heading' => $request->heading,
					'description' => $request->description,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'Blog About updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'Blog not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	}

	/**
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

				$blogdetails = Blogdetails::findOrFail($id);

				$blogdetails->update([
					'top_content' => $request->top_content,
					'bottom_content' => $request->bottom_content,
				]);

				return response()->json([
					'status' => true,
					'msg' => 'Blog Description updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'Blog not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	}

	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateFaqBlog(Request $request, $id)
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

				$blogdetails = Blogdetails::findOrFail($id);

				$blogdetails->update([
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
					'msg' => 'Blog FAQ updated successfully'
				], 200);

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'Blog not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}


		}

	}

	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function updateBlogImage(Request $request, $id)
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
				$blogdetails = Blogdetails::find($id);

				// LOGO Pictures
				// *************
				$filePath = getFolderBlogStructure();

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

					$image['large'] = array(
						'name' => $filename,
						'alt' => $filename,
						'width' => '',
						'height' => '',
						'src' => $filePath . "/" . $filename
					);

					if (!empty($blogdetails->image)) {
						$oldLogoImages = unserialize($blogdetails->image);
					}
					$blogdetails->image = serialize($image);
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

					$bannerImage['large'] = array(
						'name' => $filename,
						'alt' => $filename,
						'width' => '',
						'height' => '',
						'src' => $filePath . "/" . $filename
					);

					if (!empty($blogdetails->image_banner)) {
						$oldLogoImages = unserialize($blogdetails->image_banner);
					}
					$blogdetails->image_banner = serialize($bannerImage);
				}

				if ($blogdetails->save()) {

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
						'msg' => 'Blog Description updated successfully'
					], 200);
				}

			} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

				return response()->json([
					'status' => false,
					'msg' => 'Blog not found'
				], 404);

			} catch (\Exception $e) {

				return response()->json([
					'status' => false,
					'msg' => $e->getMessage()
				], 500);
			}

		}

	}



	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginationBlog(Request $request)
	{
		if ($request->ajax()) {

			$blogdetails = Blogdetails::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {
				$blogdetails = $blogdetails->where(function ($query) use ($request) {
					$query->orWhere('name', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('title', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('slug', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('top_content', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('bottom_content', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('heading', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('about_blog', 'LIKE', '%' . $request->input('search.value') . '%');
					$query->orWhere('meta_title', 'LIKE', '%' . $request->input('search.value') . '%');

				});
			}
			$blogdetails = $blogdetails->paginate($request->input('length'));
			$recordCollection = [];
			$data = [];
			$recordCollection['draw'] = $request->input('draw');
			$recordCollection['recordsTotal'] = $blogdetails->total();
			$recordCollection['recordsFiltered'] = $blogdetails->total();

			foreach ($blogdetails as $blog) {
				$image = '';
				$action = '';
				$status = '';
				$separator = ' ';

				if ($blog->image != '') {
					$image = unserialize($blog->image);
					//$image = $image['thumbnail']['src'];
					$image = $image['large']['src'];
				}
				if (Auth::user()->current_user_can('admin') || Auth::user()->current_user_can('edit_blog')) {
					$action .= $separator . '<a href="/developer/blog/editBlog/' . $blog->id . '"><i class="fa fa-edit" aria-hidden="true"></i></a>  ';

				}


				if (Auth::user()->current_user_can('administrator')) {
					$action .= $separator . '   <a href="/developer/blog/delete/' . $blog->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}




				if ($blog->status == '1') {
					$status .= '<a href="/developer/blog/status/' . $blog->id . '/0" class="btn btn-info m-b-5">Active</a>';

				} else {
					$status .= '<a href="/developer/blog/status/' . $blog->id . '/1" class="btn btn-warning m-b-5">In-Active</a>';
				}

				$data[] = [
					$blog->name,
					$blog->title,
					'<img loading="lazy" src="' . url($image) . '" width="50px">',
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


		$delet_data = Blogdetails::find($id);

		if ($delet_data->image != '') {

			$image = unserialize($delet_data->image);
			//$thumbnail = $image['thumbnail']['src'];
			$large = $image['large']['src'];

			// if (file_exists($thumbnail)) {
			// 	unlink($thumbnail);
			// }
			if (file_exists($large)) {
				unlink($large);
			}

		}

		$edit_data = array('image' => "", );
		$del = Blogdetails::where('id', $id)->update($edit_data);
		return redirect('developer/blog/editBlog/' . $id)->with("success", "Blog image deleted successfully.");



	}

	public function delBlogBanner(Request $request, $id)
	{
		$delet_data = Blogdetails::find($id);
		if ($delet_data->image_banner != '') {

			$image = unserialize($delet_data->image_banner);

			$large = $image['large']['src'];
			if (file_exists($large)) {
				unlink($large);
			}

		}

		$edit_data = array('image_banner' => "", );
		$del = Blogdetails::where('id', $id)->update($edit_data);
		return redirect('developer/blog/editBlog/' . $id)->with("success", "Blog image deleted successfully.");



	}


	public function deleted(Request $request, $id)
	{

		$blogdetails = Blogdetails::findorFail($id);

		if ($blogdetails->image != '') {

			$image = unserialize($blogdetails->image);

			// if (!empty($image['thumbnail']['src'])) {
			// 	$thumbnail = $image['thumbnail']['src'];
			// 	if (file_exists($thumbnail)) {
			// 		unlink($thumbnail);
			// 	}
			// }

			if (!empty($image['large']['src'])) {
				$large = $image['large']['src'];
				if (file_exists($large)) {
					unlink($large);
				}
			}
		}
		if ($blogdetails->delete()) {
			return redirect('/developer/blog/blogdetails')->with('success', 'Blog successfully deleted!');
		} else {
			return redirect('/developer/blog/blogdetails')->with('failed', 'Blog not deleted!');
		}

	}



	public function status(Request $request, $id, $val)
	{
		$blogdetails = Blogdetails::find($id);
		$blogdetails->status = $val;
		if ($blogdetails->save()) {
			return redirect('developer/blog/blogdetails')->with("success", "Status updated successfully.");
		} else {
			return redirect('developer/blog/blogdetails')->with("failed", "Status updated successfully.");
		}

	}




}
