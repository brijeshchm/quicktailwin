<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Excel;
//Models
use App\Models\Keyword;
use App\Models\ChildCategory;
use App\Models\ParentCategory;
use App\Models\Lead;
use App\Models\Status;
use App\Models\LeadFollowUp;
use App\Models\Citieslists;
use Auth;
class BulkUploadController extends Controller
{
	public function createBulkUploadKeyword(Request $request)
	{
		if (!$request->user()->current_user_can('administrator|admin')) {
			return view('errors.unauthorised');
		}
		return view('admin.bulkupload.bulk_uploadkeyword');
	}

	public function storeBulkUploadKewyword(Request $request)
	{
		if (!$request->user()->current_user_can('administrator|admin')) {
			return view('errors.unauthorised');
		}
		$file = Input::file('upload_file');
		$results = Excel::load($file)->get();
		$arr = [];
		foreach ($results as $result) {
			$arrayToPass = [];
			foreach ($result as $key => $value) {
				$arrayToPass[$key] = $value;
			}
			$validator = Validator::make($arrayToPass, [
				//	'keyword' => 'required|max:255|unique:keyword,keyword,NULL,id,child_category_id,'.$result->child_category.',parent_category_id,'.$result->parent_category,
				//	'keyword' => 'required|max:255|unique:keyword,keyword,NULL,id,child_category_id,'.$result->child_category_id.',parent_category_id,'.$result->parent_category_id.',keyword,'.$result->keyword,
				'keyword' => 'required|unique:keyword,keyword',
				'child_category' => 'required',
				'parent_category' => 'required',
				'category' => 'required',
			]);
			if (!$validator->fails()) {
				$keyword = new Keyword;
				$keyword->keyword = $result->keyword;
				//$keyword->child_category_id = $result->child_category;
				$keyword->child_category_id = ($result->child_category) ? ChildCategory::where('child_category', $result->child_category)->first()->id : "";
				//$keyword->parent_category_id = $result->parent_category;
				$keyword->parent_category_id = ($result->parent_category) ? ParentCategory::where('parent_category', $result->parent_category)->first()->id : "";
				//$keyword->city_id = $result->city_id;
				$keyword->category = $result->category;

				if ($keyword->save()) {

				}
			}
		}
		$request->session()->flash('success_msg', 'Keyword upload successfully!!');
		return redirect('developer/bulkupload/keyword');
	}

	/* dowload excel formate add lead */
	public function downloadExcelFormate()
	{

		$arr[] = [
			"parent_category_id" => 'Computer Courses & Training',
			"child_category_id" => 'Programming Languages Training',
			"keyword" => 'R Programming Training',
			"category" => 'Category 1',
		];


		date_default_timezone_set('Asia/Kolkata');
		$excel = \App::make('excel');

		Excel::create('add_keyword_' . date('Y-m-d H:i a'), function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('xls');

	}



	/**
	 * Get paginated kwds export.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getparentcategory(Request $request)
	{

		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}

		$parentCategory = ParentCategory::all();

		$arr = [];
		foreach ($parentCategory as $parent) {
			$arr[] = [
				"id" => $parent->id,
				"Parent Category" => $parent->parent_category,
			];
		}
		$excel = \App::make('excel');
		Excel::create('Parent_category_list_' . date('Y-m-d_H:i'), function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('csv');

	}


	/**
	 * Get paginated kwds export.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getchildcategory(Request $request)
	{
		//if($request->ajax()){
		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}

		$childCategories = ChildCategory::all();



		$returnLeads = [];
		$arr = [];
		foreach ($childCategories as $child) {
			$arr[] = [
				"id" => $child->id,
				"Child Category" => $child->child_category,
			];
		}
		$excel = \App::make('excel');
		Excel::create('Child_category_list', function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('xls');
		//}
	}

	public function downloadExcelLead()
	{

		$arr[] = [
			"name" => 'test',
			"mobile" => '3216549875',
			"email" => 'test@gmail.com',
			"city" => 'Noida',
			"course" => 'php',

		];


		date_default_timezone_set('Asia/Kolkata');
		$excel = \App::make('excel');

		Excel::create('add_lead_' . date('Y-m-d_H:i'), function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('csv');

	}
	public function createBulkUploadLead(Request $request)
	{
		if (!($request->user()->current_user_can('administrator') || $request->user()->current_user_can('lead_bulk_upload'))) {
			return view('errors.unauthorised');
		}
		return view('admin.bulkupload.bulk_uploadlead');
	}

	public function storeBulkUploadLead(Request $request)
	{

		$file = Input::file('upload_file');
		$results = Excel::load($file)->get();
		$user_id = $request->input('user_id');
		$lead_type = $request->input('lead_type');

		$arr = [];
		foreach ($results as $result) {

			if (!empty($result->email)) {
				$email = $result->email;

			} else {
				$email = "";
			}

			$citys = Citieslists::where('city', $result->city)->first();
			if (!empty($citys)) {
				$city_id = $citys->id;
				$city_name = $citys->city;
			} else {
				$city_id = '0';
				$city_name = $result->city;
			}

			$courses = Keyword::where('keyword', $result->course)->first();
			if (!empty($courses)) {
				$course_id = ($result->course) ? Keyword::where('keyword', $result->course)->first()->id : "";
				$course_name = $courses->keyword;
			} else {
				$course_id = '0';
				$course_name = $result->course;
			}


			$lead = new Lead;
			$lead->name = $result->name;
			$lead->email = $result->email;
			$lead->mobile = substr(trim($result->mobile), -10);
			$lead->city_id = $city_id;
			$lead->city_name = $city_name;
			$lead->kw_id = $course_id;
			$lead->kw_text = $course_name;
			$lead->created_by = $user_id;
			$lead->remark = 'New Lead';
			$lead->b_end = $lead_type;

			$lead->status_id = Status::where('name', 'LIKE', 'New Lead')->first()->id;
			$lead->status_name = Status::where('name', 'LIKE', 'New Lead')->first()->name;

			if ($lead->save()) {
				$followUp = new LeadFollowUp;
				$followUp->status = Status::where('name', 'LIKE', 'New Lead')->first()->id;
				$followUp->remark = "New Lead";
				$followUp->lead_id = $lead->id;
				$followUp->lead_id = $lead->id;
				$followUp->expected_date_time = date('Y-m-d H:i:s');
				$followUp->save();
			}
		}

		$request->session()->flash('success_msg', 'Lead upload successfully!!');
		return redirect('developer/bulkupload/lead');
	}
}
