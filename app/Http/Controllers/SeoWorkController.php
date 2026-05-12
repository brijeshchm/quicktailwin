<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoWork;
use App\Models\Keyword;
use App\Models\Citieslists;
use App\Models\City;
use App\Models\SeoKwdAssign;
use App\Models\User;
use App\Models\ClassifiedProfile;
use Validator;
use Auth;

class SeoWorkController extends Controller
{
    /**
     * Display a listing of SEO work records.
     */
    public function index(Request $request)
    {
        $data['title'] = "Seo Work";
        $data['header'] = "Seo Work";
        $keywords = Keyword::get();
        $citieslists = City::get();
        $search = [];
        if ($request->has('search')) {
            $search = $request->input('search');
        }
      
        return view('admin.seo-work.index', ['search' => $search, 'data' => $data,'keywords'=>$keywords,'citieslists'=>$citieslists]);


    }
    /**
     * Show the form for creating a new SEO work record.
     */
    public function seoWorkAdd(Request $request)
    {
        $data['title'] = "Add SEO Work";
        $data['header'] = "Add SEO Work";

        $citieslists = City::get();
         if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can( 'salesmanager') ||  Auth::user()->current_user_can( 'manager')) {
           
            $keywords = Keyword::pluck('keyword')->toArray();
 
        } else {
            
            $keywords = SeoKwdAssign::select('kwd_assign')->where('seo_id', Auth::id())->first();
            $keywords = json_decode($keywords->kwd_assign);
        }
        $classifiedProfiles = ClassifiedProfile::get();
        return view('admin.seo-work.index', ['data' => $data, 'keywords' => $keywords, 'citieslists' => $citieslists, 'classifiedProfiles' => $classifiedProfiles]);
    }


    /**
     * Store a new SEO work record.
     */
    public function seoWorkSave(Request $request)
    {


        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'keyword' => 'required|string|max:255',
                'website' => 'required|url|max:255',
                'backlink' => 'required|url|max:255|unique:seo_works,backlink',
                'index_status' => 'required|string|in:pending,complete',
                'city' => 'required|string|max:100',


            ]);

            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }

            try {
                $seoWork = new SeoWork;
                $seoWork->keyword = $request->input('keyword');
                $seoWork->website = $request->input('website');
                $classifiedProfile = ClassifiedProfile::where('website', $request->input('website'))->first();

                if (!empty($classifiedProfile)) {
                    $seoWork->email = $classifiedProfile->email;
                }
                if (!empty($classifiedProfile)) {
                    $seoWork->password = $classifiedProfile->password;
                }
                $seoWork->backlink = $request->input('backlink');
                $seoWork->index_status = $request->input('index_status');
                $seoWork->index_value = $request->input('index_value');
                $seoWork->city = $request->input('city');
                $seoWork->created_by = Auth::id();

                if ($seoWork->save()) {
                    $status = 1;
                    $msg = "SEO Work submitted successfully!";

                } else {
                    $status = 0;
                    $msg = "SEO Work could not be submitted, Please try again!";
                }
                return response()->json(['status' => $status, 'msg' => $msg], 200);


            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    /**
     * Display the specified SEO work record.
     */
    public function edit($id)
    {
        $data['title'] = "Edit Seo Work";
        $data['header'] = "Edit Seo Work";
     

        if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can( 'salesmanager') ||  Auth::user()->current_user_can( 'manager')) {

            
            $keywords = Keyword::pluck('keyword');
 
        } else {
            
            $keywords = SeoKwdAssign::select('kwd_assign')->where('seo_id', Auth::id())->first();
            $keywords = json_decode($keywords->kwd_assign);
        }
        $citieslists = City::get();
        $edit_data = SeoWork::findOrFail(base64_decode($id));
        $classifiedProfiles = ClassifiedProfile::get();
        return view('admin.seo-work.index', ['data' => $data, 'edit_data' => $edit_data, 'keywords' => $keywords, 'citieslists' => $citieslists, 'classifiedProfiles' => $classifiedProfiles]);

    }

    /**
     * Update the specified SEO work record.
     */
    public function seoWorkEditSave(Request $request, $id)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'keyword' => 'required|string|max:255',
                'website' => 'required|url|max:255',
              
                'index_status' => 'required|string|in:pending,complete',
                'city' => 'required|string|max:100',
                'backlink' => 'required|url|max:255|unique:seo_works,backlink,' . $id,


            ]);

            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }

            try {
                $seoWork = SeoWork::findOrFail($id);
                $seoWork->keyword = $request->input('keyword');
                $seoWork->website = $request->input('website');

                $classifiedProfile = ClassifiedProfile::where('website', $request->input('website'))->first();

                if (!empty($classifiedProfile)) {
                    $seoWork->email = $classifiedProfile->email;
                }
                if (!empty($classifiedProfile)) {
                    $seoWork->password = $classifiedProfile->password;
                }
                $seoWork->backlink = $request->input('backlink');
                $seoWork->index_status = $request->input('index_status');
                $seoWork->index_value = $request->input('index_value');
                $seoWork->city = $request->input('city');
                $seoWork->updated_by = Auth::id();

                if ($seoWork->save()) {
                    $status = 1;
                    $msg = "SEO Work updated successfully!";

                } else {
                    $status = 0;
                    $msg = "SEO Work could not be updated, Please try again!";
                }

                return response()->json(['status' => $status, 'msg' => $msg], 200);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }




    public function getSeoWorkPagination(Request $request)
    {
 
        if ($request->ajax()) {
            $search = $request->input('search', []);
            // dd($search);
            $seoWorks = SeoWork::orderBy('id', 'desc');
            if ($request->input('search.value') != '') {

                $seoWorks = $seoWorks->where(function ($query) use ($request) {
                    $query->orWhere('keyword', 'LIKE', '%' . $request->input('search.value') . '%')
                        ->orWhere('city', 'LIKE', '%' . $request->input('search.value') . '%');
                });
            }
       
            if(!empty($search['city'])) {
                $seoWorks = $seoWorks->whereIn('city', $search['city']);
            }
        
			if (!empty($search['course'])) {
				$seoWorks = $seoWorks->whereIn('keyword', $search['course']);
			}
			if (!empty($search['status'])) {
				$seoWorks = $seoWorks->whereIn('index_status', $search['status']);
			}
           
			if (!empty($search['datef'])) {
				$seoWorks = $seoWorks->whereDate('created_at', '>=', date_format(date_create($search['datef']), 'Y-m-d'));
			}
			if (!empty($search['datet'])) {
				$seoWorks = $seoWorks->whereDate('created_at', '<=', date_format(date_create($search['datet']), 'Y-m-d'));
			}
			 
            if(!empty($search['user'])) {
               $seoWorks =  $seoWorks->where('created_by', $search['user']);
            }

            $seoWorks = $seoWorks->paginate($request->input('length'));
            $returnLeads = $data = [];
            $returnLeads['draw'] = $request->input('draw');
            $returnLeads['recordsTotal'] = $seoWorks->total();
            $returnLeads['recordsFiltered'] = $seoWorks->total();
            $returnLeads['recordCollection'] = [];
            $users = User::select('users.id', 'users.first_name', 'users.last_name')->get();
            if ($users) {
                foreach ($users as $user) {
                    $owner[$user->id] = $user->first_name . " " . $user->last_name;
                }
            }
            foreach ($seoWorks as $seo) {

                $action = '';
                $separator = '';
                if ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_SEO')) {
                    $action .= '<a href="/developer/seo-work/edit/' . base64_encode($seo->id) . '" title="occupation Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                }
                if ($request->user()->current_user_can('administrator')) {
                    $action .= $separator . '<a href="javascript:seoWorkController.delete(\'' . base64_encode($seo->id) . '\')" title="Delete occupation" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';


                    $separator = ' | ';


                }
                $owner_name = '';
                if ($seo->created_by != null && isset($owner[$seo->created_by])) {
                    $owner_name = $owner[$seo->created_by];

                } else if ($seo->updated_by != null && isset($owner[$seo->updated_by])) {
                    $owner_name = $owner[$seo->updated_by];
                }
                
                $data[] = [
                    "<th><input type='checkbox' class='check-box' value='$seo->id'></th>",
                    $seo->keyword,
                    $seo->backlink,
                    $seo->email,
                    $seo->password,
                    $seo->city,
                    date('d-m-Y H:i:s', strtotime($seo->created_at)),
                    $owner_name,
                    $action

                ];
                $returnLeads['recordCollection'][] = $seo->id;
            }
            $returnLeads['data'] = $data;
            return response()->json($returnLeads);
        }


    }

    /**
     * Remove the specified SEO work record.
     */
    public function destroy($id)
    {
        try {
            $seoWork = SeoWork::findOrFail(base64_decode($id));
            $seoWork->delete();

            return response()->json(['status' => true, 'msg' => 'SEO work deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


}
