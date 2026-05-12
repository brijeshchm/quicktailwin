<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassifiedProfile;
use App\Models\Keyword;
use App\Models\Citieslists;
use App\Models\City;
use App\Models\User;
use Validator;
use Auth;
use Illuminate\Validation\Rule;
class ClassifiedProfileController extends Controller
{
    /**
     * Display a listing of SEO work records.
     */
    public function index(Request $request)
    {
        $data['title'] = "Classified Profile";
        $data['header'] = "Classified Profile";
        $data['keywords'] = Keyword::get();
        $data['citieslists'] = City::get();
        $search = [];
        if ($request->has('search')) {
            $search = $request->input('search');
        }

        return view('admin.classified-profile.index', ['search' => $search, 'data' => $data]);


    }
    /**
     * Show the form for creating a new SEO work record.
     */
    public function classifiedProfileAdd(Request $request)
    {
        $data['title'] = "Add Classified Profile";
        $data['header'] = "Add Classified Profile";
        $keywords = Keyword::get();
        $citieslists = City::get();
        return view('admin.classified-profile.index', ['data' => $data, 'keywords' => $keywords, 'citieslists' => $citieslists]);
    }


    /**
     * Store a new SEO work record.
     */
    public function classifiedProfileSave(Request $request)
    {


        if ($request->ajax()) {

            $validator = Validator::make(
                $request->all(),
                [
                    'website' => [
                        'required',
                        'url',
                        'max:255',

                        Rule::unique('classified_profiles', 'website')
                            ->where(function ($query) use ($request) {
                                return $query->where('email', $request->email);
                            })
                            ->ignore($request->id),
                    ],

                    'seo_activity' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'password' => 'required',
                    'profile_url' => 'required|url|max:255',
                ],

                [
                    // Custom error messages
                    'website.unique' => 'This website, email is already registered.',
                    'email' => 'This email is required.',

                ]
            );



            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }

            try {
                $classifiedProfile = new ClassifiedProfile;
                $classifiedProfile->website = trim($request->input('website'));
                $classifiedProfile->seo_activity = trim($request->input('seo_activity'));
                $classifiedProfile->user_name = trim($request->input('user_name'));
                $classifiedProfile->email = trim($request->input('email'));
                $classifiedProfile->password = trim($request->input('password'));
                $classifiedProfile->profile_url = trim($request->input('profile_url'));
                $classifiedProfile->status = trim($request->input('status'));
                $classifiedProfile->created_by = Auth::id();

                if ($classifiedProfile->save()) {
                    $status = 1;
                    $msg = "SEO Profile submitted successfully!";

                } else {
                    $status = 0;
                    $msg = "SEO Profile could not be submitted, Please try again!";
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
        $data['title'] = "Edit Classified Profile";
        $data['header'] = "Edit Classified Profile";
        $keywords = Keyword::get();
        $citieslists = City::get();
        $edit_data = classifiedProfile::findOrFail(base64_decode($id));
        return view('admin.classified-profile.index', ['data' => $data, 'edit_data' => $edit_data, 'keywords' => $keywords, 'citieslists' => $citieslists]);

    }

    /**
     * Update the specified Classified work record.
     */
    public function classifiedProfileEditSave(Request $request, $id)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'website' => [
                    'required',
                    'url',
                    'max:255',

                    Rule::unique('classified_profiles', 'website')
                        ->where('email', $request->input('email'))
                        ->ignore($id, 'id'),
                ],

                'seo_activity' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required',
                'profile_url' => 'required|url|max:255',




            ], [
                // Custom error messages
                'website.unique' => 'This website, email is already registered.',
                'email' => 'This email is required.',

            ]);

            if ($validator->fails()) {
                $errorsBag = $validator->getMessageBag()->toArray();
                return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
            }

            try {
                $classifiedProfile = ClassifiedProfile::findOrFail($id);
                $classifiedProfile->website = trim($request->input('website'));
                $classifiedProfile->seo_activity = trim($request->input('seo_activity'));
                $classifiedProfile->user_name = trim($request->input('user_name'));
                $classifiedProfile->email = trim($request->input('email'));
                $classifiedProfile->password = trim($request->input('password'));
                $classifiedProfile->profile_url = trim($request->input('profile_url'));
                $classifiedProfile->status = trim($request->input('status'));
                $classifiedProfile->updated_by = Auth::id();

                if ($classifiedProfile->save()) {
                    $status = 1;
                    $msg = "Classified Profile updated successfully!";

                } else {
                    $status = 0;
                    $msg = "Classified Profile could not be updated, Please try again!";
                }

                return response()->json(['status' => $status, 'msg' => $msg], 200);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }




    public function getclassifiedProfilePagination(Request $request)
    {

        if ($request->ajax()) {
            $search = $request->input('search', []);
            $classifiedProfiles = ClassifiedProfile::orderBy('id', 'desc');
            if ($request->input('search.value') != '') {

                $classifiedProfiles = $classifiedProfiles->where(function ($query) use ($request) {
                    $query->where('website', 'LIKE', '%' . $request->input('search.value') . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->input('search.value') . '%');
                });
            }
            	if (!empty($search['datef'])) {
				$classifiedProfiles = $classifiedProfiles->whereDate('created_at', '>=', date_format(date_create($search['datef']), 'Y-m-d'));
			}
			if (!empty($search['datet'])) {
				$classifiedProfiles = $classifiedProfiles->whereDate('created_at', '<=', date_format(date_create($search['datet']), 'Y-m-d'));
			}
			 
            if(!empty($search['user'])) {
               $classifiedProfiles =  $classifiedProfiles->where('created_by', $search['user']);
            }
            $classifiedProfiles = $classifiedProfiles->paginate($request->input('length'));
            $returnLeads = $data = [];
            $returnLeads['draw'] = $request->input('draw');
            $returnLeads['recordsTotal'] = $classifiedProfiles->total();
            $returnLeads['recordsFiltered'] = $classifiedProfiles->total();
            $returnLeads['recordCollection'] = [];
            $users = User::select('users.id', 'users.first_name', 'users.last_name')->get();
            if ($users) {
                foreach ($users as $user) {
                    $owner[$user->id] = $user->first_name . " " . $user->last_name;
                }
            }
            foreach ($classifiedProfiles as $seo) {

                $action = '';
                $separator = '';
                if ($request->user()->current_user_can('administrator') || $request->user()->current_user_can('all_SEO')) {
                    $action .= '<a href="/developer/classified-profile/edit/' . base64_encode($seo->id) . '" title="occupation Edit" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                }
                if ($request->user()->current_user_can('administrator')) {
                    $action .= $separator . '<a href="javascript:classifiedProfileController.delete(\'' . base64_encode($seo->id) . '\')" title="Delete occupation" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';


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

                    $seo->website,
                    $seo->email,
                    $seo->password,
                    $seo->profile_url,
                    date('d-m-Y H:s:i', strtotime($seo->created_at)),
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
            $classifiedProfile = ClassifiedProfile::findOrFail(base64_decode($id));
            $classifiedProfile->delete();

            return response()->json(['status' => true, 'msg' => 'Classified Profile deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


}
