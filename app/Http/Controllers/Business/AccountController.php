<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Client\Client;

class AccountController extends Controller
{
	protected $danger_msg = '';
	protected $success_msg = '';
	protected $warning_msg = '';
	protected $info_msg = '';
	protected $redirectTo = '/business-owners';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{

	}

	function dataEncodeJsonBase64($o){
				$o = json_encode($o);
				$o = base64_encode($o);
				return $o;
	}
	function dataDecodeJsonBase64($o){
				$o = base64_decode($o);
				$o = json_decode($o); 
				
				return $o;
	}
	public function package(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
 
	 	$data = [];

		$common = [
			'business_name' => trim($client->business_name),
			'customer_name' => trim($client->sirName).' '.$client->first_name.' '.$client->last_name,
			'email'         => trim($client->email),
			'phone'         => $client->mobile,
			'country'       => $client->country,
			'state'         => $client->state,
			'city'          => $client->city,
			'client_id'     => $client->id,
			'username'      => $client->username,
			'tds_status'    => 'No',
			'tds_amount'    => '0',
		];

		$packages = [
			'coins_1000'  => [1000, 1111], //0.90
			'coins_2000'  => [2000, 2272],//0.89
			'coins_3000'  => [3000, 3529],//0.86
			'coins_5000'  => [5000, 6099], //0.84
			'coins_10000' => [10000, 12500],//0.78
			'coins_20000' => [20000, 27777],//0.72
			'coins_40000' => [40000, 57777],//0.70
			'coins_50000' => [50000, 76923],//0.66
		];

		/* ✅ Free Package */
		if ($client->coins_free == '0') {
			$free = array_merge($common, [
				'amt' => 0,
				'gst_status' => 'No',
				'gst_tax' => '0',
				'gst_total_amount' => '0',
				'total_amount' => '0',
				'coins' => 555,
				'package' => 'Free Package',
				'package_bottom' => "Free Package",
			]);

			$free['encrypt'] = $this->dataEncodeJsonBase64($free);
			$data['coins_free'] = $free;
		}

		/* ✅ Paid Packages */
		foreach ($packages as $key => [$amount, $coins]) {

			$gst = round($amount * 0.18);

			$item = array_merge($common, [
				'amt' => $amount,
				'gst_status' => 'yes',
				'gst_tax' => $gst,
				'gst_total_amount' => $amount + $gst,
				'total_amount' => $amount + $gst,
				'coins' => $coins,
				'package' => "{$amount} Rs to {$coins} Coins",
				'package_bottom' => "Buy Package",
			]);

			$item['encrypt'] = $this->dataEncodeJsonBase64($item);
			$data[$key] = $item;
		}
 
// dd($data);
		return view('business.package', ['search' => $search, 'client' => $client,'data'=>$data]);
	}

	public function accountSettings(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('business.account-settings', ['search' => $search, 'client' => $client]);
	}

	public function buyPackage(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('business.buyPackage', ['search' => $search, 'client' => $client]);
	}
}
