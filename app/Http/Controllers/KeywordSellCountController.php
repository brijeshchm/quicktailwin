<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use DB;

use App\Models\KeywordSellCount;
class KeywordSellCountController extends Controller
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
    public function index(Request $request)
    {
        $keywordSellCounts = KeywordSellCount::all();
        $data['header'] = "All Keyword sell count";

        return view('admin.keyword_sell_count', ['keywordSellCounts' => $keywordSellCounts,'data'=>$data]);
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $keywordSellCounts = KeywordSellCount::all();
        $data['header'] = "Add Keyword sell count";

        return view('admin.keyword_sell_count', ['keywordSellCounts' => $keywordSellCounts,'data'=>$data]);
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
            'name' => 'required|max:255|alpha|unique:keyword_sell_count',
            'count' => 'required|integer',
            'cat1_price' => 'required|numeric|between:80,90',
            'cat2_price' => 'required|numeric|between:91,120',
            'cat3_price' => 'required|numeric|between:121,140',
            'cat4_price' => 'required|numeric|between:141,180',
            'cat5_price' => 'required|numeric|between:181,200',
            'cat6_price' => 'required|numeric|between:201,250',
            'cat7_price' => 'required|numeric|between:251,300',
            'cat8_price' => 'required|numeric|between:301,350',
            'cat9_price' => 'required|numeric|between:351,400',
            'cat10_price' => 'required|numeric|between:401,500',           
        ]);       
            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }

        $keywordSellCount = new KeywordSellCount;
        $keywordSellCount->name = $request->input('name');
        $keywordSellCount->slug = generate_slug($request->input('name'), '-');
        $keywordSellCount->count = $request->input('count');
        $keywordSellCount->cat1_price = $request->input('cat1_price');
        $keywordSellCount->cat2_price = $request->input('cat2_price');
        $keywordSellCount->cat3_price = $request->input('cat3_price');
        $keywordSellCount->cat4_price = $request->input('cat4_price');
        $keywordSellCount->cat5_price = $request->input('cat5_price');
        $keywordSellCount->cat6_price = $request->input('cat6_price');
        $keywordSellCount->cat7_price = $request->input('cat7_price');
        $keywordSellCount->cat8_price = $request->input('cat8_price');
        $keywordSellCount->cat9_price = $request->input('cat9_price');
        $keywordSellCount->cat10_price = $request->input('cat10_price');
        
       if ($keywordSellCount->save()) {
				$status = 1;
				$msg = "Keyword Sell Count submitted successfully!";

			} else {
				$status = 0;
				$msg = "Keyword Sell Count could not be submitted, Please try again!";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {  
        
            $edit_data = KeywordSellCount::find(base64_decode($id));                
            $data['header'] = "Edit Keyword sell count";

            return view('admin.keyword_sell_count', ['edit_data' => $edit_data,'data'=>$data]);
            
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {  
            $validator = Validator::make($request->all(), [
           
           'name' => 'required|max:255|unique:keyword_sell_count,name,' . $id . ',id',
            'count' => 'required|integer',
            'cat1_price' => 'required|numeric|between:80,90',
            'cat2_price' => 'required|numeric|between:91,120',
            'cat3_price' => 'required|numeric|between:121,140',
            'cat4_price' => 'required|numeric|between:141,180',
            'cat5_price' => 'required|numeric|between:181,200',
            'cat6_price' => 'required|numeric|between:201,250',
            'cat7_price' => 'required|numeric|between:251,300',
            'cat8_price' => 'required|numeric|between:301,350',
            'cat9_price' => 'required|numeric|between:351,400',
            'cat10_price' => 'required|numeric|between:401,500',           
        ]);       
            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }
        
                $keywordSellCount = KeywordSellCount::find($id);
                $keywordSellCount->name = $request->input('name');
                $keywordSellCount->count = $request->input('count');
                $keywordSellCount->cat1_price = $request->input('cat1_price');
                $keywordSellCount->cat2_price = $request->input('cat2_price');
                $keywordSellCount->cat3_price = $request->input('cat3_price');
                $keywordSellCount->cat4_price = $request->input('cat4_price');
                $keywordSellCount->cat5_price = $request->input('cat5_price');
                $keywordSellCount->cat6_price = $request->input('cat6_price');
                $keywordSellCount->cat7_price = $request->input('cat7_price');
                $keywordSellCount->cat8_price = $request->input('cat8_price');
                $keywordSellCount->cat9_price = $request->input('cat9_price');
                $keywordSellCount->cat10_price = $request->input('cat10_price');
                if ($keywordSellCount->save()) {
                $status = 1;
                $msg = "Keyword Sell Count submitted successfully!";

                } else {
                $status = 0;
                $msg = "Keyword Sell Count could not be submitted, Please try again!";
                }
                return response()->json(['status' => $status, 'msg' => $msg], 200);


    }
        
   
	public function getKeywordSellCountPagination(Request $request)
	{

		if ($request->ajax()) {

			$keywordSellCounts = KeywordSellCount::orderBy('id', 'desc');
			if ($request->input('search.value') != '') {

				$keywordSellCounts = $keywordSellCounts->where(function ($query) use ($request) {
					$query->orWhere('name', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}


			$keywordSellCounts = $keywordSellCounts->paginate($request->input('length'));
			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $keywordSellCounts->total();
			$returnLeads['recordsFiltered'] = $keywordSellCounts->total();
			$returnLeads['recordCollection'] = [];
			foreach ($keywordSellCounts as $keywordSellCount) {

				$action = '';
				$status = '';

				$action .= '<a href="/developer/keyword_sell_count/edit/' . base64_encode($keywordSellCount->id) . '" title="occupation Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';


				if ($keywordSellCount->id > 9) {
					$action .= '<a href="javascript:keywordSellCountController.delete(' . $keywordSellCount->id . ')" title="Delete occupation" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

				}

				if ($keywordSellCount->status == '1') {
					$status .= '<a href="javascript:keywordSellCountController.status(' . $keywordSellCount->id . ',0)" title="occupation status" class="btn btn-success" >Active</a>';
				} else {
					$status .= '<a href="javascript:keywordSellCountController.status(' . $keywordSellCount->id . ',1)" title="occupation status" class="btn btn-danger" >Inactive</a>';
				}

				$data[] = [
					 
					$keywordSellCount->name,
					$keywordSellCount->count,
					$keywordSellCount->cat1_price,
					$keywordSellCount->cat2_price,
					$keywordSellCount->cat3_price,
					$keywordSellCount->cat4_price,
					$keywordSellCount->cat5_price,
					$keywordSellCount->cat6_price,
					$keywordSellCount->cat7_price,
					$keywordSellCount->cat8_price,
					$keywordSellCount->cat9_price,
					$keywordSellCount->cat10_price,
					$status,
					$action
				];
				$returnLeads['recordCollection'][] = $keywordSellCount->id;
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}

/**
	 * Remove the specified resource from storage status.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function status(request $request, $id, $val)
	{
		if ($request->ajax()) {

			$keywordSellCount = KeywordSellCount::findOrFail($id);
			$keywordSellCount->status = $val;

			if ($keywordSellCount->save()) {
				$status = 1;
				$msg = "keywordSellCount status updated successfully !";
			} else {
				$status = 0;
				$msg = "keywordSellCount status could not be successfully, Please try again !";
			}
			return response()->json(['status' => $status, 'msg' => $msg], 200);
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
            KeywordSellCount::destroy($id);
            return response()->json(['status' => 1, 'msg' => 'Keyword Sell Count deleted succesfully!!']);
        }
    }
}
