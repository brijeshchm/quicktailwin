<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\State;
use App\Models\Citieslists;
use App\Models\Modesdetails;
use App\Models\Banksdetails;
use App\Models\ClientCategory;
use App\Models\ParentCategory;
use App\Models\Occupation;
use App\Models\Keyword;
use App\Models\AssignedClientCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use DB;
class VendorController extends Controller
{
    public function index(Request $request): View
    {

    $vendors = Client::query()
            ->search($request->string('search')->toString())
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->when($request->filled('city'), fn ($query) => $query->where('city', $request->string('city')->toString()))
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')->toString()))
            ->when($request->filled('sales_executive'), fn ($query) => $query->where('sales_executive', $request->string('sales_executive')->toString()))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('sales.vendors.index', [
            'vendors' => $vendors,
            'cities' => '',
            'categories' => '',
            'executives' =>'',
        ]);


        
    }

    public function create(): View
    {
 
        return view('sales.vendors.edit', [
            'vendor' => new Client(['status' => 'pending']),
            'tabVendors' => Client::query()->latest()->limit(12)->get(['id', 'business_name', 'status']),
            'isCreating' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $vendor = Client::create($this->validatedData($request));

        return redirect()
            ->route('sales.vendors.edit', $vendor)
            ->with('success', 'Vendor created and added to pending review.');
    }

    public function edit(Request $request,  Client $vendor): View
    {

   
   


    $citylist = Citieslists::all();
    $clientCategories = ClientCategory::all();
    $parentCategory = ParentCategory::all();

	$kwds = DB::table('assigned_kwds')
				->join('citylists', 'assigned_kwds.city_id', '=', 'citylists.id')
				->join('parent_category', 'assigned_kwds.parent_cat_id', '=', 'parent_category.id')
				->join('child_category', 'assigned_kwds.child_cat_id', '=', 'child_category.id')
				->join('keyword', 'assigned_kwds.kw_id', '=', 'keyword.id')
				->select('assigned_kwds.*', 'citylists.city', 'parent_category.parent_category', 'child_category.child_category', 'keyword.keyword','keyword.slug')
				->where('assigned_kwds.client_id', $vendor->id)
				->get();


			$distinctCities = DB::table('keyword')
				->join('citylists', 'keyword.city_id', '=', 'citylists.id')
				->select('citylists.*', 'keyword.city_id')
				->distinct()
				->get();
	$statesis = State::get();

    	$assignedClientCategories = AssignedClientCategory::select('client_category_id')->where('client_id', $vendor->id)->get();
			$accs = [];
			foreach ($assignedClientCategories as $acc) {
				$accs[] = $acc->client_category_id;
			}
			$assignedClientCategories = $accs;


			
			$moderesults = Modesdetails::get();
			$banksdetails = Banksdetails::all();

	$occupations = Occupation::where('status', '1')->get();
	$keywordlists = Keyword::whereNotExists(function ($query) use ($vendor) {
				$query->select(DB::raw(1))
					->from('assigned_kwds')
					->whereColumn('assigned_kwds.kw_id', 'keyword.id')
					->where('assigned_kwds.client_id', $vendor->id);
			})->get();

        return view('sales.vendors.edit', ['vendor' => $vendor, 'kwds' => $kwds, 'request' => $request, 'distinctCities' => $distinctCities, 'clientCategories' => $clientCategories, 'assignedClientCategories' => $assignedClientCategories, 'citylist' => $citylist, 'parentCategory' => $parentCategory, 'moderesults' => $moderesults, 'statesis' => $statesis, 'occupations' => $occupations, 'keywordlist' => $keywordlists, 'isCreating' => true,]);
    }

    public function update(Request $request, Client $vendor): RedirectResponse
    {
        $vendor->update($this->validatedData($request));

        return back()->with('success', 'Vendor profile updated successfully.');
    }

    public function destroy(Client $vendor): RedirectResponse
    {
        $vendor->delete();

        return redirect()->route('sales.vendors.index')->with('success', 'Vendor deleted.');
    }

    public function toggleStatus(Client $vendor): RedirectResponse
    {
        $vendor->update([
            'status' => $vendor->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Vendor status updated.');
    }

    public function export(Request $request): Response
    {
        $vendors = Client::query()
            ->search($request->string('search')->toString())
            ->latest()
            ->get(['id', 'business_name', 'owner_name', 'email', 'mobile', 'city', 'category', 'status', 'sales_executive', 'created_at']);

        $rows = collect([[
            'Vendor ID',
            'Business Name',
            'Owner Name',
            'Email',
            'Mobile',
            'City',
            'Category',
            'Status',
            'Sales Executive',
            'Created Date',
        ]])
            ->merge($vendors->map(fn (Client $vendor): array => [
                $vendor->id,
                $vendor->business_name,
                $vendor->owner_name,
                $vendor->email,
                $vendor->mobile,
                $vendor->city,
                $vendor->category,
                $vendor->status,
                $vendor->sales_executive,
                $vendor->created_at?->toDateString(),
            ]));

        $csv = $rows->map(fn (array $row): string => collect($row)
            ->map(fn ($value): string => '"' . str_replace('"', '""', (string) $value) . '"')
            ->implode(','))
            ->implode("\n");

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="vendors.csv"',
        ]);
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'business_name' => ['required', 'string', 'max:160'],
            'owner_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'mobile' => ['required', 'string', 'max:30'],
            'alternate_mobile' => ['nullable', 'string', 'max:30'],
            'business_email' => ['nullable', 'email', 'max:160'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'business_slug' => ['nullable', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:80'],
            'state' => ['nullable', 'string', 'max:80'],
            'city' => ['required', 'string', 'max:80'],
            'zone' => ['nullable', 'string', 'max:80'],
            'area' => ['nullable', 'string', 'max:80'],
            'pincode' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:500'],
            'landmark' => ['nullable', 'string', 'max:160'],
            'website' => ['nullable', 'url', 'max:200'],
            'google_map_url' => ['nullable', 'url', 'max:300'],
            'business_hours' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'seo_url' => ['nullable', 'string', 'max:200'],
            'canonical_url' => ['nullable', 'url', 'max:300'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'full_description' => ['nullable', 'string'],
            'services' => ['nullable', 'string'],
            'facilities' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:active,pending,inactive,suspended'],
            'sales_executive' => ['nullable', 'string', 'max:120'],
            'assigned_keywords' => ['nullable', 'array'],
            'assigned_keywords.*' => ['string', 'max:80'],
        ]);
    }
}