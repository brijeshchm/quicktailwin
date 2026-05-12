<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
 

use App\Http\Requests;
use App\Http\Controllers\Controller;
 
use App\Models\Client\Comment;
use Illuminate\Support\Facades\Validator;
use DB;

class ReviewController extends Controller
{


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
 
		if ($request->ajax()) {

			$validator = Validator::make($request->all(), [
				'comment_author' => 'required|regex:/^[A-Za-z ]/',
				'comment_author_phone' => 'required|numeric',
				'comment_author_email' => 'required|email',
				'comment_content' => 'required',
				's_rating' => 'required|numeric|max:5|min:1',
			]);

			if ($validator->fails()) {
				$errorsBag = $validator->getMessageBag()->toArray();

				return response()->json(['status' => true, 'errors' => $errorsBag], 400);
			}
	 

		 
			$dd = DB::table('comments')
				->select(DB::raw("DATEDIFF(DATE(now()),(SELECT max(DATE(`created_at`)) FROM `comments` WHERE `comment_author_email`='" . $request->input('comment_author_email') . "' AND `comment_client_ID`=" . $request->currentClient . ")) as date"))
				->take(1)
				->get();

			if (!empty($dd)) {
				if ($dd[0]->date <= 30 && !is_null($dd[0]->date)) {			 
					return response()->json(["status" => false, "message" => "You cannot give review more than one in a month"],400);
				}
			}

			$comment = new Comment();
			$comment->comment_client_ID = $request->currentClient;
			$comment->comment_author = $request->input('comment_author');
			$comment->comment_author_phone = $request->input('comment_author_phone');
			$comment->comment_author_email = $request->input('comment_author_email');
			$comment->comment_content = $request->input('comment_content');
			$comment->rating = $request->input('s_rating');
			$comment->comment_author_IP = $request->ip();
			if ($comment->save()) {
				return response()->json(["status" => true, "message" => "Review successfully submitted."]);
			} else {
				return response()->json(["status" => 0, "message" => "Error occured."]);
			}
		}
		return response()->json(["status" => 0, "message" => "Client not found or invalid ajax request."]);
	}

 




}
