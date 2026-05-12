<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
 
 
class InterviewController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		  

		 return view('interview.index');
	}
   public function phpInterview()
	{ 
		return view('interview.php-question');

	}
     
   public function mysqlInterview()
	{ 
		return view('interview.mysql-question');

	}
   public function technicalInterview()
	{ 
		return view('interview.technical-question');

	}
	
   public function laravelInterview()
	{ 
		return view('interview.laravel-question');

	}
     
	
   public function javascriptInterview()
	{ 
		return view('interview.javascript-question');

	}
	
   public function reactjsInterview()
	{ 
		return view('interview.reactjs-question');

	}
	
   public function restapiInterview()
	{ 
		return view('interview.restapi-question');

	}
     

}
