<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Testimonialsdetail;
use Image;
use Auth;

class TestimonialsController extends Controller
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


		return view('admin.testimonials.index');
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
		if ($request->isMethod('post') && $request->input('submit') == "Save") {

			$this->validate($request, [
				'name' => 'required',
				'description' => 'required',
				'title' => 'required',
				'location' => 'required',
				'rating' => 'required',


			]);


			$testimonialsdetails = new Testimonialsdetail;
			$testimonialsdetails->name = $request->input('name');
			$testimonialsdetails->company_name = $request->input('company_name');
			$testimonialsdetails->title = $request->input('title');
			$testimonialsdetails->slug = generate_slug($request->input('title'));
			$testimonialsdetails->description = $request->input('description');
			$testimonialsdetails->location = $request->input('location');
			$testimonialsdetails->rating = $request->input('rating');


			//$file = $request->file('logo');
			// LOGO Pictures
			// *************
			if ($request->hasFile('image')) {
				$image = [];
				$filePath = getFolderStructure();

				$file = $request->file('image');
				$filename = $file->getClientOriginalName();
				$destinationPath = public_path($filePath);
				$nameArr = explode('.', $filename);
				$ext = array_pop($nameArr);
				$name = implode('_', $nameArr);
				if (file_exists($destinationPath . '/' . $filename)) {
					$filename = $name . "_" . time() . '.' . $ext;
				}
				$file->move($destinationPath, $filename);

				$image['large'] = array(
					'name' => $filename,
					'alt' => $filename,
					'width' => '',
					'height' => '',
					'src' => $filePath . "/" . $filename
				);



				$testimonialsdetails->image = serialize($image);
			}

			if ($testimonialsdetails->save()) {
				return redirect('/developer/testimonials/testimonialsdetails')->with('success', 'Testimonials Details successfully added!');
			} else {
				return redirect('/developer/testimonials/testimonialsdetails')->with('failed', 'Testimonials Details not added!');

			}


		}
		return view('admin.testimonials.index', $data);
	}


	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$data['edit_data'] = Testimonialsdetail::find($id);
		$data['button'] = "Update";
		if ($request->isMethod('post') && $request->input('submit') == "Update") {
			$this->validate($request, [
				'name' => 'required',
				'description' => 'required',
				'title' => 'required',
				'location' => 'required',
				'rating' => 'required',
			]);

			$testimonialsdetails = Testimonialsdetail::find($id);
			$testimonialsdetails->name = $request->input('name');
			$testimonialsdetails->company_name = $request->input('company_name');
			$testimonialsdetails->title = $request->input('title');
			$testimonialsdetails->slug = generate_slug($request->input('title'));
			$testimonialsdetails->description = $request->input('description');
			$testimonialsdetails->location = $request->input('location');
			$testimonialsdetails->rating = $request->input('rating');

			//$file = $request->file('logo');
			// LOGO Pictures
			// *************
			if ($request->hasFile('image')) {
				$image = [];
				$filePath = getFolderStructure();
				$file = $request->file('image');
				$filename = $file->getClientOriginalName();
				$destinationPath = public_path($filePath);
				$nameArr = explode('.', $filename);
				$ext = array_pop($nameArr);
				$name = implode('_', $nameArr);
				if (file_exists($destinationPath . '/' . $filename)) {
					$filename = $name . "_" . time() . '.' . $ext;
				}
				$file->move($destinationPath, $filename);


				$image['large'] = array(
					'name' => $filename,
					'alt' => $filename,
					'width' => '',
					'height' => '',
					'src' => $filePath . "/" . $filename
				);

				if (!empty($testimonialsdetails->image)) {
					$oldLogoImages = unserialize($testimonialsdetails->logo);
				}


				$testimonialsdetails->image = serialize($image);
			}



			if ($testimonialsdetails->save()) {

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
				return redirect('/developer/testimonials/testimonialsdetails')->with('success', 'Testimonials Details successfully Update!');
			} else {
				return redirect('/developer/testimonials/edit/' . $id)->with('failed', 'Testimonials details  not Update!');

			}
		}
		return view('admin.testimonials.index', $data);
	}



	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginationTestimonials(Request $request)
	{
		if ($request->ajax()) {

			$testimonials = Testimonialsdetail::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {
				$testimonials = $testimonials->where(function ($query) use ($request) {
					$query->orWhere('name', 'LIKE', '%' . $request->input('search.value') . '%');

				});
			}
			$testimonials = $testimonials->paginate($request->input('length'));
			$recordCollection = [];
			$data = [];
			$recordCollection['draw'] = $request->input('draw');
			$recordCollection['recordsTotal'] = $testimonials->total();
			$recordCollection['recordsFiltered'] = $testimonials->total();

			foreach ($testimonials as $testimonial) {


				$large = '';
				if (!empty($testimonial->image)) {
					$image = unserialize($testimonial->image);

					$large = $image['large']['src'];
				}
				$action = '';
				$separator = '';
				if (Auth::user()->current_user_can('administrator')) {
					$action .= $separator . '<a href="/developer/testimonials/edit/' . $testimonial->id . '"><i class="fa fa-edit" aria-hidden="true"></i></a> | <a href="/developer/testimonials/delete/' . $testimonial->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

				if (Auth::user()->current_user_can('admin|gb_associate')) {
					$action .= $separator . '<a href="/developer/testimonials/edit/' . $testimonial->id . '"><i class="fa fa-edit" aria-hidden="true"></i></a>';

				}

				$data[] = [
					$testimonial->name,
					$testimonial->title,
					(isset($large) ? '<img loading="lazy" src="' . url($large) . '" width="50px">' : ""),
					$action,
				];
			}
			$recordCollection['data'] = $data;
			return response()->json($recordCollection);


		}
	}

	public function imageDeleted(Request $request, $id)
	{


		$delet_data = Testimonialsdetail::find($id);

		if ($delet_data->image != '') {

			$image = unserialize($delet_data->image);

			$large = $image['large']['src'];
			if (!empty($image['thumbnail']['src'])) {
				$thumbnail = $image['thumbnail']['src'];
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}
			if (file_exists($large)) {
				unlink($large);
			}

		}

		$edit_data = array('image' => "", );
		$del = Testimonialsdetails::where('id', $id)->update($edit_data);
		return redirect('developer/testimonials/edit/' . $id)->with("success", "Testimonials image deleted successfully.");



	}


	public function deleted(Request $request, $id)
	{

		$testimonialsdetails = Testimonialsdetail::findorFail($id);

		if ($testimonialsdetails->image != '') {

			$image = unserialize($testimonialsdetails->image);

			if (!empty($image['thumbnail']['src'])) {
				$thumbnail = $image['thumbnail']['src'];
				if (file_exists($thumbnail)) {
					unlink($thumbnail);
				}
			}

			if (!empty($image['large']['src'])) {
				$large = $image['large']['src'];
				if (file_exists($large)) {
					unlink($large);
				}
			}
		}




		if ($testimonialsdetails->delete()) {
			return redirect('/developer/testimonials/testimonialsdetails')->with('success', 'Testimonials successfully deleted!');
		} else {
			return redirect('/developer/testimonials/testimonialsdetails')->with('failed', 'Testimonials not deleted!');
		}

	}






}
