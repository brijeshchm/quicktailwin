<?php

namespace App\Http\Controllers\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Citieslists;
use App\Models\State;
use App\Models\Country;


use App\Models\RazorpayHistory;
use App\Models\PaymentHistory;
use App\Models\Client\Client;

use Mail;

class WebsiteRazorpayController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		//testing Key  brijeshchauhansit@gmail.com
		define('RAZOR_KEY_ID', 'rzp_test_S4xUXChoSZWOwY');
		define('RAZOR_KEY_SECRET', 'k7hFQ9R5yfSaMnhuC3ps9S9O');

	}

	public function validation_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	public function dataEncodeJsonBase64($o)
	{
		$o = json_encode($o);
		$o = base64_encode($o);
		return $o;
	}


	function dataDecodeJsonBase64($o)
	{
		$o = base64_decode($o);
		$o = json_decode($o);

		return $o;
	}
	public function payDeposit(Request $request)
	{
		if (isset($_GET['status'], $_GET['o']) && !empty($_GET['o'])) {
			$o = base64_decode($_GET['o'], $strict = false);
			$data = json_decode($o);
			$status = $_GET['status'];
		} else {
			$data = array();
		}
		return view('business.razorpay.pay-checkout', ['data' => $data]);

	}

	/**
	 * Return the specified resource from storage.
	 *
 
	 */
	public function saveProcessing(Request $request)
	{



		if ($request->isMethod('post') && $request->input('checkout') == "CheckOut") {

			$this->validate($request, [
				'name' => 'required|string|regex:/^[\pL\s\-]+$/u|min:3|max:32',
				'email' => 'required|regex:/^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i',
				//	'pincode' 	=> 'required|numeric',					
				'phone' => 'required|numeric',
				'amount' => 'required|numeric',
				'course' => 'required|string|min:3|max:32',
				'country' => 'required|numeric',
				'state' => 'required|numeric',
				'city' => 'required',
				//	'address' 	=> 'required',						 					
			]);



			$data['name'] = $this->validation_input($request->input('name'));
			$data['email'] = $this->validation_input($request->input('email'));
			$data['course'] = $this->validation_input($request->input('course'));
			//	$data['pincode'] = $this->validation_input($request->input('pincode'));
			$data['amt'] = $this->validation_input($request->input('amount'));
			$data['phone'] = $this->validation_input($request->input('phone'));
			//	$data['add'] = $this->validation_input($request->input('address'));		
			//	$cityname =City::where('city_id',$request->input('city'))->first()->city_name;
			$statename = State::where('state_id', $request->input('state'))->first()->state_name;
			$countryname = $request->input('country');
			;

			$data['city'] = $this->validation_input($request->input('city'));
			$data['state'] = $this->validation_input($statename);
			$data['country'] = $this->validation_input($countryname);

			$d = time();
			$traisaction = "QI_" . rand(10, 99) . '_' . $d;
			if (!empty($data)) {

				$s = 1;

			} else {
				$s = 0;
			}



			Session::put('buyerFirstName', $request->input('name'));
			Session::put('buyerEmail', $request->input('email'));
			Session::put('clientName', $request->input('course'));
			Session::put('amount', $request->input('amount'));
			Session::put('buyerPhone', $request->input('phone'));
			Session::put('buyerState', $statename);
			Session::put('buyerCountry', $countryname);
			Session::put('buyerCity', $request->input('city'));
			Session::put('buyerPinCode', $request->input('pincode'));
			Session::put('course', $request->input('course'));

			if ($s == 1) {
				$inv = $this->dataEncodeJsonBase64($data);
				$inv = "&inv=" . $inv;
				$o = $this->dataEncodeJsonBase64($data);

				return redirect('/pay-checkout?status=incompete&o=' . $o . $inv);
				exit;

			} else {
				return redirect('/pay-deposit');
			}


			return view('business.razorpay.pay-deposit');
		}
	}




	/**
	 * Return the specified resource from storage.
	 *
	 
	 */
	public function razCheckOut(Request $request)
	{

		$data = $this->dataDecodeJsonBase64($_GET['encrypt']);

		return view('client.razorpay.pay-checkout', ['data' => $data]);
	}
	/**
	 * Return the get package.
	 *
	 
	 */
	 

	public function getPackage(Request $request)
	{
    /* ── 1. Decode & validate input ── */
    $encrypt = $request->input('encrypt');
    $getData = $this->dataDecodeJsonBase64($encrypt);
   

    /* ── 2. Fetch client safely ── */
    $client = Client::find($getData->client_id);
   

    /* ── 3. Common payload ── */
    $common = [
        'business_name' => trim($client->business_name),
        'customer_name' => trim($client->sirName) . ' ' . $client->first_name . ' ' . $client->last_name,
        'email'         => trim($client->email),
        'phone'         => $client->mobile,
        'country'       => $client->country,
        'state'         => $client->state,
        'city'          => $client->city,
        'client_id'     => $client->id,
        'tds_status'    => 'No',
        'tds_amount'    => '0',
    ];

    /* ── 4. Packages ── */
    $packages = [
        'coins_1000'  => [1000,  1111],   // 0.90
        'coins_2000'  => [2000,  2272],   // 0.89
        'coins_3000'  => [3000,  3529],   // 0.86
        'coins_5000'  => [5000,  6099],   // 0.84
        'coins_10000' => [10000, 12500],  // 0.78
    ];

    /* ── 5. Color themes (one per card, cycles if packages exceed colors) ── */
    $colors = [
        ['gradient' => 'from-green-50 to-gray-100',     'border' => 'border-gray-200',   'cta_style' => 'outline'],
        ['gradient' => 'from-indigo-50 to-indigo-100',  'border' => 'border-indigo-300', 'cta_style' => 'solid'],
        ['gradient' => 'from-amber-50 to-yellow-50',    'border' => 'border-amber-200',  'cta_style' => 'outline'],
        ['gradient' => 'from-green-50 to-gray-100',     'border' => 'border-gray-200',   'cta_style' => 'solid'],
        ['gradient' => 'from-indigo-50 to-indigo-100',  'border' => 'border-indigo-300', 'cta_style' => 'outline'],
    ];

    /* ── 6. Badges (optional — null = no badge) ── */
    $badges = [null, 'Most Popular', 'Best Value', null, null];

    /* ── 7. Build packages ── */
    $data  = [];
    $index = 0;

    foreach ($packages as $key => [$amount, $coins]) {

        $gst   = round($amount * 0.18);
        $theme = $colors[$index % count($colors)];   // safe cycle if more pkgs than colors
        $badge = $badges[$index] ?? null;

        $item = array_merge($common, $theme, [
            'amt'              => $amount,
            'gst_status'       => 'yes',
            'gst_tax'          => $gst,
            'gst_total_amount' => $amount + $gst,
            'total_amount'     => $amount + $gst,
            'coins'            => $coins,
            'package'          => "{$amount} Rs to {$coins} Coins",
            'package_bottom'   => "Buy Package",
            'badge'            => $badge,
            'cta'              => $badge === 'Most Popular' ? 'Choose Premium'
                                : ($badge === 'Best Value' ? 'Go Royal' : 'Get Started'),
        ]);

        $item['encrypt'] = $this->dataEncodeJsonBase64($item);

        $data[$key] = $item;
        $index++;
    }
	 

    return view('client.razorpay.pay-package', compact('data'));
}
		
 
	function get_curl_handle($payment_id, $data)
	{
 
		$url = 'https://api.razorpay.com/v1/payments/' . $payment_id;
		// $url = 'https://api.razorpay.com/v1/payments/' . $payment_id . '/capture';
		$key_id = 'rzp_test_S4xUXChoSZWOwY';
		$key_secret = 'k7hFQ9R5yfSaMnhuC3ps9S9O';
		$params = http_build_query($data);
		//cURL Request
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		return $ch;
	}

	public function razorPayCheckout(Request $request)
	{
 
		if (!empty($request->razorpay_payment_id) && !empty($request->merchant_order_id)) {

			$json = array();
			$razorpay_payment_id = $request->razorpay_payment_id;
			$merchant_order_id = $request->merchant_order_id;
			$currency_code = $request->currency_code_id;

			$dataFlesh = array(
				'card_holder_name' => $request->card_holder_name_id,
				'merchant_amount' => $request->merchant_amount,
				'merchant_total' => $request->merchant_total / 100,
				'surl' => $request->merchant_surl_id,
				'furl' => $request->merchant_furl_id,
				'currency_code' => $currency_code,
				'order_id' => $request->merchant_order_id,
				'razorpay_payment_id' => $request->razorpay_payment_id,
				'pay_to' => $request->pay,
				'coins' => $request->coins,
				'gst_tax' => $request->gst_tax,
				'client_id' => $request->client_id,
				'username' => $request->username,
				'paid_amount' => $request->paid_amount,

				'email' => $request->email,
				'phone' => $request->phone,
				// 'address' => $_POST['address'],
				'city' => $request->city,
				'billing_country' => $request->billing_country,
				'billing_state' => $request->billing_state,
				'getpay' => 1,
			);

			$paymentInfo = $dataFlesh;
			$order_info = array('order_status_id' => $_POST['merchant_order_id']);
			$amount = $request->merchant_total;
			$currency_code = $request->currency_code_id;
			// bind amount and currecy code
			$data = array(
				'amount' => $amount,
				'currency' => $currency_code,
			);

 
			$success = false;
			$error = '';
			try {


				$ch = $this->get_curl_handle($razorpay_payment_id, $data);
				//execute post
				$result = curl_exec($ch);
				$data = json_decode($result);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 

				if ($result === false) {
					$success = false;
					$error = 'Curl error: ' . curl_error($ch);
					//false case

					$clientdeatails = Client::find($paymentInfo['client_id']);
					$paymenthistory = new PaymentHistory;
					$paymenthistory->client_id = $paymentInfo['client_id'];
					$paymenthistory->paymentcollect = $paymentInfo['client_id'];
					$paymenthistory->customer_name = $paymentInfo['card_holder_name'];
					$paymenthistory->order_number = $paymentInfo['order_id'];
					$paymenthistory->business_name = $clientdeatails->business_name;
					$paymenthistory->mobile = $paymentInfo['phone'];
					$paymenthistory->email = $paymentInfo['email'];
					$paymenthistory->package_name = $clientdeatails->client_type;
					$paymenthistory->coins_amt = $paymentInfo['coins'];
					$paymenthistory->selectproofid = "";
					$paymenthistory->proofid = "";
					$paymenthistory->paid_amount = $paymentInfo['paid_amount'];
					$paymenthistory->tds_status = "No";
					$paymenthistory->tds_amount = "0";
					$paymenthistory->gst_tax = $paymentInfo['gst_tax'];
					$paymenthistory->gst_total_amount = $paymentInfo['merchant_amount'];
					$paymenthistory->gst_status = "Yes";
					$paymenthistory->total_amount = $paymentInfo['merchant_amount'];
					$paymenthistory->transactionid = $paymentInfo['razorpay_payment_id'];
					$paymenthistory->paymentcollect = 0;
					$paymenthistory->payment_mode = "razorpay";
					$paymenthistory->status = "faild";
					$paymenthistory->payment_bank = "";
					$paymenthistory->save();

					  








				} else {
					$response_array = json_decode($result, true);
					//Check success response
					if ($http_status === 200 and isset($response_array['error']) === false) {
						$success = true;
					} else {
						$success = false;
						if (!empty($response_array['error']['code'])) {
						 

								$error  =  $response_array['error']['code'] . ':' . $response_array['error']['description'];
						} else {
						 
							$error  = 'Invalid Response <br/>' . $result;
						}
					}
				}
				//close connection
				curl_close($ch);
			} catch (Exception $e) {
				 
					$success = false;
					 
					$error = $e->getMessage();
			}
			if ($success === true) {


				if (!$order_info['order_status_id']) {
					$json['msg'] ='order status id empty';
					$json['data'] = json_encode($paymentInfo);
					$json['redirectURL'] = $request->merchant_surl_id;
				} else {


					$clientdeatails = Client::find($paymentInfo['client_id']);
					$paymenthistory = new PaymentHistory;
					$paymenthistory->client_id = $paymentInfo['client_id'];
					$paymenthistory->paymentcollect = $paymentInfo['client_id'];
					$paymenthistory->customer_name = $paymentInfo['card_holder_name'];
					$paymenthistory->order_number = $paymentInfo['order_id'];
					$paymenthistory->business_name = $clientdeatails->business_name;
					$paymenthistory->mobile = $paymentInfo['phone'];
					$paymenthistory->email = $paymentInfo['email'];
					$paymenthistory->package_name = $clientdeatails->client_type;
					$paymenthistory->coins_amt = $paymentInfo['coins'];
					$paymenthistory->selectproofid = "";
					$paymenthistory->proofid = "";
					$paymenthistory->paid_amount = $paymentInfo['paid_amount'];
					$paymenthistory->tds_status = "No";
					$paymenthistory->tds_amount = "0";
					$paymenthistory->gst_tax = $paymentInfo['gst_tax'];
					$paymenthistory->gst_total_amount = $paymentInfo['merchant_amount'];
					$paymenthistory->gst_status = "Yes";
					$paymenthistory->total_amount = $paymentInfo['merchant_amount'];
					$paymenthistory->transactionid = $paymentInfo['razorpay_payment_id'];
					$paymenthistory->paymentcollect = 0;
					$paymenthistory->payment_mode = "razorpay";
					$paymenthistory->status = "success";
					$paymenthistory->payment_bank = "";
					$paymenthistory->save();

					$clientdeatails->coins_amt = $clientdeatails->coins_amt + $paymentInfo['coins'];
					if ($clientdeatails->expired_on == '0000-00-00 00:00:00' || $clientdeatails->expired_on == 'NULL') {

						$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));

					} else if (strtotime($clientdeatails->expired_on) > strtotime(date('Y-m-d'))) {
						$newDate = date('Y-m-d', strtotime($clientdeatails->expired_on . ' +365 days'));

					} else if (strtotime($clientdeatails->expired_on) < strtotime(date('Y-m-d'))) {
						$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));

					} else {
						$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));
					}
					$clientdeatails->expired_on = $newDate;
					$clientdeatails->active_status = "1";
					$clientdeatails->paid_status = "1";
					$clientdeatails->save();

					$json['data'] = json_encode($paymentInfo);
					$json['redirectURL'] = $request->merchant_surl_id;
				}
			} else {


				$json['data'] = json_encode($paymentInfo); 
				$json['redirectURL'] = $_POST['merchant_furl_id'];
			}
			$json['msg'] = 'success';
		} else {

			$json['msg'] = 'An error occured. Contact site administrator, please!';
		}
		header('Content-Type: application/json');
		echo json_encode($json);
	}


	public function success(Request $request)
	{
	 
		$data = $request->order_id;	
	 
		if (!$request->filled('order_id')) {
			abort(400, 'Order ID missing');
		}
 	 
		$paymentHistory = PaymentHistory::where('order_number', $request->order_id)->first();

		if ($paymentHistory) {
			$check = $paymentHistory->update([
				'invoice_status' => '1'				 
			]);	 
		}
 
		return view('client.razorpay.success', [
			'data' => $data,
			'paymentHistory' => $paymentHistory
		]);
	}


	public function failed(Request $request)
	{

		return view('client.razorpay.failed');
	}

	public function getInvoicePrintPdf(Request $request)
	{

		if (isset($_POST['pid'])) {
			if ($request->input('action') == 'getInvoicePrintPdf') {

				$order_id = $_POST['pid'];
				$paydetails = RazorpayHistory::where('order_id', $order_id)->first();

				return response()->view("site.feesrazorpay.getPayPrintSlipInvoiceRazorpay", ['paydetails' => $paydetails]);

				die;
			}
		}
	}







 
 


	public function airpay(Request $request)
	{
		date_default_timezone_set('Asia/Kolkata');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');


		$buyerEmail = "test@gmail.com";//trim($_POST['buyerEmail']);
		$buyerPhone = '8457425742';//trim($_POST['buyerPhone']);
		$buyerFirstName = "First Name";//trim($_POST['buyerFirstName']);
		$buyerLastName = "last Name";//trim($_POST['buyerLastName']);
		$buyerAddress = "Address";//trim($_POST['buyerAddress']);
		$amount = "1.00";//trim($_POST['amount']);
		$buyerCity = "Noida";//trim($_POST['buyerCity']);
		$buyerState = "UP";//trim($_POST['buyerState']);
		$buyerPinCode = 852574;//trim($_POST['buyerPinCode']);
		$buyerCountry = "India";//trim($_POST['buyerCountry']);
		$orderid = mt_rand(1000, 9999); //trim($_POST['orderid']); //Your System Generated Order ID
		// $hiddenmod = trim($_POST['directindexvar']);
		$currency = 356;//trim($_POST['currency']);
		$isocurrency = "INR";//trim($_POST['isocurrency']);

		//$this->config();
		$username = '9563650'; // Username
		$password = 'WeZ4CrwA'; // Password
		$secret = 'U6eQEwZ3b9FNtdj3'; // API key
		$mercid = '274181'; //Merchant ID 

		$this->airpayvalidation($buyerEmail, $buyerPhone, $buyerFirstName, $buyerLastName, $buyerAddress, $amount, $buyerCity, $buyerState, $buyerPinCode, $buyerCountry, $orderid, $currency, $isocurrency);
		//include('site/feesrazorpay/config.php');
		//include('site/feesrazorpay/checksum.php');
		//include('site/feesrazorpay/validation.php');


		// $date = date('Y-m-d');
		// $alldata   = $buyerEmail.$buyerFirstName.$buyerLastName.$buyerAddress.$buyerCity.$buyerState.$buyerCountry.$amount.$orderid.$hiddenmod;
		// $privatekey = Checksum::encrypt($username.":|:".$password, $secret);
		// $keySha256 = Checksum::encryptSha256($username."~:~".$password);
		// $checksum = Checksum::calculateChecksum($alldata,$keySha256);

		$alldata = $buyerEmail . $buyerFirstName . $buyerLastName . $buyerAddress . $buyerCity . $buyerState . $buyerCountry . $amount . $orderid;
		// 	$privatekey = Checksum::encrypt($username.":|:".$password, $secret);
		//     $keySha256 = Checksum::encryptSha256($username."~:~".$password);
		//     $checksum = Checksum::calculateChecksumSha256($alldata.date('Y-m-d'),$keySha256);

		$privatekey = $this->encrypt($username . ":|:" . $password, $secret);
		$keySha256 = $this->encryptSha256($username . "~:~" . $password);
		$checksum = $this->calculateChecksumSha256($alldata . date('Y-m-d'), $keySha256);

		// Session::put('alldata',$alldata);
		// Session::put('keySha256',$keySha256);
		Session::put('checksum', $checksum);


		$hiddenmod = "";
		$this->processform($checksum);
	}




	public function config()
	{
		$username = '9563650'; // Username
		$password = 'WeZ4CrwA'; // Password
		$secret = 'U6eQEwZ3b9FNtdj3'; // API key
		$mercid = '274181'; //Merchant ID   
	}

	//for checksom
	public function calculateChecksum($data, $secret_key)
	{
		$checksum = md5($data . $secret_key);
		return $checksum;
	}

	public function encrypt($data, $salt)
	{
		// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
		$key = hash('SHA256', $salt . '@' . $data);
		return $key;
	}

	public function encryptSha256($data)
	{
		$key = hash('SHA256', $data);
		return $key;
	}
	public function calculateChecksumSha256($data, $salt)
	{
		$checksum = hash('SHA256', $salt . '@' . $data);
		return $checksum;
	}


	public function outputForm($checksum)
	{
		//ksort($_POST);

		foreach ($_POST as $key => $value) {
			echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
		}
		echo '<input type="hidden" name="checksum" value="' . $checksum . '" />' . "\n";
	}

	public function verifyChecksum($checksum, $all, $secret)
	{
		$cal_checksum = Checksum::calculateChecksum($secret, $all);
		$bool = 0;
		if ($checksum == $cal_checksum) {
			$bool = 1;
		}

		return $bool;
	}

	public function subscribeFree(Request $request)
	{

		if (isset($_GET['status'], $_GET['o']) && !empty($_GET['o'])) {
			$oo = base64_decode($_GET['o'], $strict = false);
			$data = json_decode($oo);
			$status = $_GET['status'];
		} else {
			$data = array();
		}


		return view('business.razorpay.subscribe-free', ['data' => $data, 'oo' => $_GET['o']]);

	}
	public function saveSubscribeFree(Request $request, $id)
	{
		if ($request->ajax()) {
			$oo = base64_decode($_POST['oo'], $strict = false);
			$data = json_decode($oo);


			$clientdeatails = Client::find($data->client_id);
			if ($clientdeatails->coins_free == '0') {
				$paymenthistory = new PaymentHistory;
				$paymenthistory->client_id = $data->client_id;
				$paymenthistory->customer_name = $data->customer_name;
				$paymenthistory->business_name = $clientdeatails->business_name;
				$paymenthistory->mobile = $data->phone;
				$paymenthistory->email = $data->email;
				$paymenthistory->package_name = 'Gold';
				$paymenthistory->coins_amt = $data->coins;
				$paymenthistory->selectproofid = "";
				$paymenthistory->proofid = "";
				$paymenthistory->paid_amount = '0';
				$paymenthistory->tds_status = "No";
				$paymenthistory->tds_amount = "0";
				$paymenthistory->gst_tax = '0';
				$paymenthistory->gst_total_amount = '0';
				$paymenthistory->gst_status = "Yes";
				$paymenthistory->total_amount = '0';
				$paymenthistory->transactionid = $request->input('merchant_order_id');
				$paymenthistory->order_number = $request->input('merchant_order_id');
				$paymenthistory->paymentcollect = 0;
				$paymenthistory->payment_mode = "free subscribe";
				$paymenthistory->payment_bank = "";
				$paymenthistory->invoice_status = '1';
				$paymenthistory->save();


				$clientdeatails->coins_amt = $clientdeatails->coins_amt + $data->coins;
				if ($clientdeatails->expired_on == '0000-00-00 00:00:00' || $clientdeatails->expired_on == 'NULL') {

					$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));

				} else if (strtotime($clientdeatails->expired_on) > strtotime(date('Y-m-d'))) {
					$newDate = date('Y-m-d', strtotime($clientdeatails->expired_on . ' +365 days'));

				} else if (strtotime($clientdeatails->expired_on) < strtotime(date('Y-m-d'))) {
					$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));

				} else {
					$newDate = date('Y-m-d', strtotime(now() . ' +365 days'));
				}
				$clientdeatails->expired_on = $newDate;
				$clientdeatails->active_status = "1";
				$clientdeatails->paid_status = "1";
				$clientdeatails->coins_free = "1";
				if ($clientdeatails->save()) {
					$status = true;
					$msg = "Free subscribed successfully ";
				} else {
					$status = false;
					$msg = "Not subscribed successfully ";
				}
			} else {
				$status = false;
				$msg = "Already subscribed!";
			}

			return response()->json(['status' => $status, 'msg' => $msg], 200);
		}
	}
}
