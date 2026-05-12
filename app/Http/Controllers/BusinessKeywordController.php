<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
 

use App\Models\Citieslists; //Model
use App\Models\ParentCategory; //Model
use App\Models\ChildCategory; //Model
use App\Models\Keyword; //Model
use App\Models\KeywordSellCount; //Model
use App\Models\BusinessKeyword; //Model

class BusinessKeywordController extends Controller
{
	protected $danger_msg = '';
	protected $success_msg = '';
	protected $warning_msg = '';
	protected $info_msg = '';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
		$businessKeywords = BusinessKeyword::all();
		$cities = Citieslists::all();
		$parentCategories = ParentCategory::all();
		$childCategories = ChildCategory::all();
		$keywords = Keyword::all();
		return view('admin/business_keyword', ['businessKeywords' => $businessKeywords, 'cities' => $cities, 'parentCategories' => $parentCategories, 'childCategories' => $childCategories, 'keywords' => $keywords]);
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'city_id' => 'required|unique:business_keyword,city_id,NULL,id,parent_category_id,' . $request->input('parent_category_id') . ',child_category_id,' . $request->input('child_category_id') . ',keyword_id,' . $request->input('keyword_id'),
			'parent_category_id' => 'required|integer',
			'child_category_id' => 'required|integer',
			'keyword_id' => 'required|integer',
			'category' => 'required'
		]);

		if ($validator->fails()) {
			return redirect("developer/business_keyword")
				->withErrors($validator)
				->withInput();
		}

		$businessKeyword = new BusinessKeyword;
		$businessKeyword->city_id = $request->input('city_id');
		$businessKeyword->parent_category_id = $request->input('parent_category_id');
		$businessKeyword->child_category_id = $request->input('child_category_id');
		$businessKeyword->keyword_id = $request->input('keyword_id');
		$businessKeyword->category = $request->input('category');
		$businessKeyword->save();
		$this->success_msg .= 'business keyword added succesfully!';
		$request->session()->flash('success_msg', $this->success_msg);
		return redirect("developer/business_keyword");
	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		 
		if ($request->ajax()) {
			$businessKeyword = BusinessKeyword::find($id);
			$childCategories = ChildCategory::where('parent_category_id', $businessKeyword->parent_category_id)->get();
			$keywords = Keyword::where('child_category_id', $businessKeyword->child_category_id)->get();


			$request->session()->put('businessKeywordToUpdate', $businessKeyword->id);

			return response()->json(['status' => 1, 'businessKeyword' => $businessKeyword, 'childCategories' => $childCategories, 'keywords' => $keywords]);
		} else {

			$businessKeyword = BusinessKeyword::find($id);
			$cities = Citieslists::all();
			$parentCategories = ParentCategory::all();
			$request->session()->put('businessKeywordToUpdate', $businessKeyword->id);
			$childCategories = ChildCategory::where('parent_category_id', $businessKeyword->parent_category_id)->get();
			$keywords = Keyword::where('child_category_id', $businessKeyword->child_category_id)->get();

			return view('developer/business_keyword_update', ['businessKeyword' => $businessKeyword, 'cities' => $cities, 'parentCategories' => $parentCategories, 'childCategories' => $childCategories, 'keywords' => $keywords]);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		if ($request->session()->has('businessKeywordToUpdate')) {

			$validator = Validator::make($request->all(), [
				'city_id' => 'required|unique:business_keyword,city_id,NULL,id,parent_category_id,' . $request->input('parent_category_id') . ',child_category_id,' . $request->input('child_category_id') . ',keyword_id,' . $request->input('keyword_id'),
				'parent_category_id' => 'required|integer',
				'child_category_id' => 'required|integer',
				'keyword_id' => 'required|integer',
				'category' => 'required'
			]);
			$businessKeywordToUpdate = $request->session()->get('businessKeywordToUpdate');
			if ($validator->fails()) {
				return redirect("/developer/business_keyword/update_keyword/" . $businessKeywordToUpdate)
					->withErrors($validator)
					->withInput();
			}

			if ($businessKeywordToUpdate == $request->input('id')) {

				$businessKeyword = BusinessKeyword::find($businessKeywordToUpdate);
				$businessKeyword->city_id = $request->input('city_id');
				$businessKeyword->parent_category_id = $request->input('parent_category_id');
				$businessKeyword->child_category_id = $request->input('child_category_id');
				$businessKeyword->keyword_id = $request->input('keyword_id');
				$businessKeyword->category = $request->input('category');
				$businessKeyword->save();
				$this->success_msg .= 'business keyword updated succesfully!';
				$request->session()->flash('success_msg', $this->success_msg);
				return redirect("developer/business_keyword");
			}
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
			BusinessKeyword::destroy($id);
			return response()->json(['status' => 1, 'msg' => 'Business Keyword deleted succesfully!!']);
		}
	}

	/**
	 * Send the child categories in response related to the requested id.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getKeywords(Request $request, $id)
	{

		$keywords = Keyword::where('child_category_id', $id)->get();
		if ($request->ajax()) {
			return response()->json(['status' => 1, 'keywords' => $keywords]);
		} else {
			return $keywords;
		}
	}

	public function getChildCategoriesHelper($request, $id)
	{

		$child_category = ChildCategory::where('parent_category_id', $id)->get();
		return $child_category;
	}
}
