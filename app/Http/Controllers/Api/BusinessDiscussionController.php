<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class BusinessDiscussionController extends Controller
{
	protected $danger_message = '';
	protected $success_message = '';
	protected $warning_message = '';
	protected $info_message = '';
	protected $redirectTo = '/business-owners';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{

	}



	/**
	 * Return paginated resources.
	 *
	 * @return JSON Payload.
	 */
	public function getDiscussion(Request $request)
	{
		 if (!Auth::guard('sanctum')->check()) {
			return response()->json([
				'status' => false,
                    'message' => 'Unauthenticated: Token is missing or invalid',
                    'error' => 'token_missing_or_invalid'
                ], 401);
        }

		$user = auth('sanctum')->user();
		if (!$user) {
			return response()->json([
				'status' => false,
				'message' => 'Unauthenticated: Token is missing or invalid',
				'error' => 'token_missing_or_invalid'
			], 401);
		}
			$data['discussion'] = DB::table('client_discussion')
				->orderBy('id', 'desc')
				->where('client_id', $user->id)
				->get();
			echo json_encode($data);	
	}
}
