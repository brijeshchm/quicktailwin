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
	 


	/*
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
	 

	}


	/*
	 * Get paginated kwds export.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getchildcategory(Request $request)
	{
		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}

		$childCategories = ChildCategory::all();

		$filename = "Child_category_list.csv";

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '"');

		$fp = fopen('php://output', 'w');

		// CSV Header
		fputcsv($fp, ['ID', 'Child Category']);

		// CSV Data
		foreach ($childCategories as $child) {

			fputcsv($fp, [
				$child->id,
				$child->child_category
			]);
		}

		fclose($fp);
		exit;
	}


		public function downloadExcelLead()
		{
		  
		  
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="addLead'.date('Y-m-d H:i a').'.csv"');
		$data = array(
		'Name,Email,Mobile,Service,city,Remarks',
		'Test,test@xyz.com,1234567891,PHP,Delhi,Interested',
		 
		);

		$fp = fopen('php://output', 'wb');
		foreach ( $data as $line ) {
		$val = explode(",", $line);
		fputcsv($fp, $val);
		}
		fclose($fp);
		 
		  
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
    if ($request->isMethod('post')) {

        $validator = Validator::make($request->all(), [
            'upload_file' => 'required',
        ]);

        if ($validator->fails()) {
            $errorsBag = $validator->getMessageBag()->toArray();

            return response()->json([
                'status' => 1,
                'errors' => $errorsBag
            ], 400);
        }

        $allowedFileType = [
            'text/csv',
            'application/vnd.ms-excel'
        ];

        if (in_array($_FILES["upload_file"]["type"], $allowedFileType)) {

            $lead_type = $request->input('lead_type');

            if ($request->hasFile('upload_file')) {

                $filePath = "excell";
                $file = $request->file('upload_file');

                $filename = str_replace(' ', '_', trim($file->getClientOriginalName()));

                $destinationPath = public_path($filePath);

                $file->move($destinationPath, $filename);

                $csvFile = fopen($destinationPath . '/' . $filename, 'r');

                fgetcsv($csvFile);

                $add = 0;

                while (($row = fgetcsv($csvFile)) !== FALSE) {

                    $name    = trim($row[0]);
                    $email   = trim($row[1]);
                    $mobile  = trim($row[2]);
                    $service = trim($row[3]);
                    $city    = trim($row[4]);
                    $remarks = trim($row[5]);

                    if ($name != "") {

                        // City
                        $citys = Citieslists::where('city', $city)->first();

                        if ($citys) {
                            $city_id   = $citys->id;
                            $city_name = $citys->city;
                        } else {
                            $city_id   = 0;
                            $city_name = $city;
                        }

                        // Keyword / Course
                        $courses = Keyword::where('keyword', $service)->first();

                        if ($courses) {
                            $course_id   = $courses->id;
                            $course_name = $courses->keyword;
                        } else {
                            $course_id   = 0;
                            $course_name = $service;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | CHECK DUPLICATE
                        | mobile + kw_id both same
                        |--------------------------------------------------------------------------
                        */

                        $checkLead = Lead::where('mobile', $mobile)
                            ->where('kw_id', $course_id)
                            ->first();

                        $lead = new Lead;

                        $lead->name         = $name;
                        $lead->email        = $email;
                        $lead->mobile       = $mobile;
                        $lead->code         = '91';
                        $lead->city_id      = $city_id;
                        $lead->city_name    = $city_name;
                        $lead->kw_id        = $course_id;
                        $lead->kw_text      = $course_name;
                        $lead->created_by   = '1';
                        $lead->remark       = $remarks;
                        $lead->b_end        = $lead_type;
                        $lead->status_id    = '1';
                        $lead->status_name  = 'New Lead';

                        // Duplicate flag
                        if ($checkLead) {
                            $lead->duplicate = '1';
                        } else {
                            $lead->duplicate = '0';
                        }

                        if ($lead->save()) {

                            $followUp = new LeadFollowUp;
                            $followUp->status = '1';
                            $followUp->remark = $remarks;
                            $followUp->lead_id = $lead->id;
                            $followUp->expected_date_time = date('Y-m-d H:i:s');
                            $followUp->save();

                            $add = 1;
                        }
                    }
                }

                fclose($csvFile);

                if ($add) {
                    return response()->json([
                        'status' => true,
                        'msg' => 'Bulk Upload successfully'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Not Bulk Upload'
                    ], 200);
                }
            }
        }
    }
}

}
