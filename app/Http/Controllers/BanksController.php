<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banksdetails;
use App\Models\Modesdetails;
class BanksController extends Controller
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
		$data['modesdetails'] = Modesdetails::get();
		return view('admin.banks.index', $data);
	}

	/**
	 * add services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function add(Request $request)
	{
		$data['modesdetails'] = Modesdetails::get();
		if ($request->isMethod('post') && $request->input('submit') == "Save") {
			$this->validate($request, [
				'name' => 'required|unique:banksdetails,name|max:200',
			]);


			$banksdetails = new Banksdetails;
			$banksdetails->name = $request->input('name');
			$banksdetails->mode = $request->input('mode');
			if ($banksdetails->save()) {
				return redirect('/developer/banks/banksdetails')->with('success', 'Banks Details successfully added!');
			} else {
				return redirect('/developer/banks/banksdetails')->with('failed', 'Banks Details not added!');

			}


		}
		return view('admin.banks.index', $data);
	}


	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id)
	{
		$data['edit_data'] = Banksdetails::find($id);
		$data['modesdetails'] = Modesdetails::get();

		if ($request->isMethod('post') && $request->input('submit') == "Update") {
			$this->validate($request, [
				'name' => 'required|max:32|unique:banksdetails,name,' . $id,
			]);

			$banksdetails = Banksdetails::find($id);
			$banksdetails->name = $request->input('name');
			$banksdetails->mode = $request->input('mode');

			if ($banksdetails->save()) {
				return redirect('/developer/banks/banksdetails')->with('success', 'Banks Details successfully Update!');
			} else {
				return redirect('/developer/banks/edit/' . $id)->with('failed', 'Banks details  not Update!');

			}
		}
		return view('admin.banks.index', $data);
	}



	/**
	 * Edit services
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginationBanks(Request $request)
	{
		if ($request->ajax()) {

			$banksdetails = Banksdetails::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {
				$banksdetails = $banksdetails->where(function ($query) use ($request) {
					$query->orWhere('name', 'LIKE', '%' . $request->input('search.value') . '%');

				});
			}
			$banksdetails = $banksdetails->paginate($request->input('length'));
			$recordCollection = [];
			$data = [];
			$recordCollection['draw'] = $request->input('draw');
			$recordCollection['recordsTotal'] = $banksdetails->total();
			$recordCollection['recordsFiltered'] = $banksdetails->total();		 
			foreach ($banksdetails as $banks) {

				$data[] = [
					$banks->name,
					$banks->mode,
					'<a href="/developer/banks/edit/' . $banks->id . '"><i class="fa fa-edit" aria-hidden="true"></i></a> | <a href="/developer/banks/delete/' . $banks->id . '"><i class="fa fa-trash" aria-hidden="true"></i></a>'
				];
			}
			$recordCollection['data'] = $data;
			return response()->json($recordCollection);


		}
	}




	public function deleted(Request $request, $id)
	{

		$banksdetails = Banksdetails::findorFail($id);
		if ($banksdetails->delete()) {

			return redirect('/developer/banks/banksdetails')->with('success', 'Banks successfully deleted!');
		} else {
			return redirect('/developer/banks/banksdetails')->with('failed', 'Banks not deleted!');
		}

	}






}