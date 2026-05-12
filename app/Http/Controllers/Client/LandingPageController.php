<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Mail;
use Artisan;

//model

use App\Models\City;
use App\Models\ChildCategory;
use App\Models\ParentCategory;
use App\Models\Client\Client;
use App\Models\Blogdetails;
use App\Models\Testimonialsdetails;

class LandingPageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $menuArr = [];
    $parentCategories = ParentCategory::take(7)->get();

    $clientCategories = DB::table('client_categories as cc')
      ->leftJoin(DB::raw('(SELECT acc.client_category_id, COUNT(acc.client_category_id) as clients_count FROM assigned_client_categories acc INNER JOIN clients c ON c.id=acc.client_id WHERE c.client_type NOT LIKE \'general\' GROUP BY acc.client_category_id) AS cmt'), 'cc.id', '=', 'cmt.client_category_id')
      ->select('cc.*', 'cmt.*')
      ->where('cc.image', '!=', '')
      ->take(8)
      ->get();

    $clients = Client::get();
    $cities = City::where('popular', '1')->get();

    if (count($parentCategories) > 0) {
      foreach ($parentCategories as $parentCategory) {
        $childCategories = ChildCategory::where('parent_category_id', $parentCategory->id)->get();
        $menuArr[$parentCategory->parent_category]['parent'][] = $parentCategory;
        foreach ($childCategories as $childCategory) {
          $menuArr[$parentCategory->parent_category]['child'][] = $childCategory;
        }
      }
    }
    $subcategory = DB::table('child_category')
      ->join('parent_category', 'child_category.parent_category_id', '=', 'parent_category.id')
      ->where('parent_category_id', 4)
      ->select('parent_category.*', 'child_category.*')
      ->get();

    $blogdetails = Blogdetails::where('status', '1')->limit(3)->orderBy('id', 'DESC')->get();
    $testimonialsdetails = Testimonialsdetails::limit(3)->orderBy('id', 'DESC')->get();

    return view('client.ads.landingpage', ['menuArr' => $menuArr, 'clientCategories' => $clientCategories, 'cities' => $cities, 'clients' => $clients, 'blogdetails' => $blogdetails, 'testimonialsdetails' => $testimonialsdetails, 'subcategory' => $subcategory]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function entranceexamcoaching()
  {
    return view('client.ads.entranceexamcoaching');
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function entrance_exam_coaching()
  {
    return view('landing.entrance_exam_coaching');
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function it_training()
  {
    return view('landing.it_training');
  }

  public function iit_entrance_exam()
  {
    return view('landing.iit_entrance_exam');
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function multimedia()
  {
    return view('landing.multimedia');
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function foreign_language()
  {
    return view('landing.foreign_language');
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function distance_education()
  {
    return view('landing.distance_education');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function studyabroad()
  {
    return view('client.ads.studyabroad');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function distanceeducation()
  {
    return view('client.distanceeducation');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function ittraining()
  {
    return view('client.ads.ittraining');
  }


  public function leadslist(Request $request)
  {
    echo "test";
    die;
  }
  public function thankyou(Request $request)
  {
    return view('landing.thank-you');
  }

}
