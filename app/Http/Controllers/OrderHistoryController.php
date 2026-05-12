<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Client\Client;
use App\Models\PaymentHistory;
use App\Models\Modesdetails;
use App\Models\Banksdetails;
use Validator;
use Carbon\Carbon;
use DB;
use Auth;
use Excel;

class OrderHistoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->ajax()) {

			$leads = DB::table('payment_histories')
				->leftJoin('clients', 'payment_histories.client_id', '=', 'clients.id')
				->leftJoin('users', 'payment_histories.paymentcollect', '=', 'users.id');


			if ($request->input('search.client_type') != '') {

				$leads = $leads->where('payment_histories.package_name', '=', $request->input('search.client_type'));
			}

			if ($request->input('search.datef') != '') {
				$leads = $leads->whereDate('payment_histories.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
			}
			if ($request->input('search.datet') != '') {
				$leads = $leads->whereDate('payment_histories.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
			}

			$leads = $leads->select('payment_histories.*', 'clients.username', 'clients.business_name as businessName', 'clients.client_type', 'users.first_name', 'users.last_name');
			if ($request->input('search.value') != '') {
				echo $request->input('search.value');
				$leads = $leads->where(function ($query) use ($request) {
					$query->orWhere('payment_histories.customer_name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('payment_histories.business_name', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('payment_histories.email', 'LIKE', '%' . $request->input('search.value') . '%')
						->orWhere('payment_histories.mobile', 'LIKE', '%' . $request->input('search.value') . '%');
				});
			}

			$leads = $leads->orderBy('payment_histories.created_at', 'desc');
			$leads = $leads->paginate($request->input('length'));

			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $leads->total();
			$returnLeads['recordsFiltered'] = $leads->total();


			foreach ($leads as $lead) {
				$orderpdf = '';
				$invoicepdf = '';
				$action = '';
				$separator = '';
				$proforma = '';
				$orderpdf .= $separator . '<a href="javascript:void(0)" data-toggle="popover" title="Oder PDF" id="paymentPrint" data-trigger="hover" data-placement="left" data-sid="' . $lead->id . '"><i aria-hidden="true" class="fa fa-file-pdf-o"></i></a> ';
				$proforma .= $separator . '<a href="javascript:void(0)" data-toggle="popover" title="Proforma Invoice PDF" id="proformaPrintPdf" data-trigger="hover" data-placement="left" data-sid="' . $lead->id . '"><i aria-hidden="true" class="fa fa-file-pdf-o"></i></a>';

				if ($lead->invoice_status == 1) {
					$invoicepdf .= $separator . '<a href="javascript:void(0)" data-toggle="popover" title="Invoice PDF" id="invoicePrintPdf" data-trigger="hover" data-placement="left" data-sid="' . $lead->id . '"><i aria-hidden="true" class="fa fa-file-pdf-o"></i></a>';
				} else {
					if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('client_invoice_approved')) {
						$invoicepdf .= $separator . '<a href="javascript:client.clientOrderHistoryStatus(' . $lead->id . ')" data-toggle="popover" title="Invoice Status Pending" ><i aria-hidden="true" class="fa fa-thumbs-up"></i></a>';
					}

				}

				$action .= $separator . '<a href="/developer/order-history/update/' . base64_encode($lead->id) . '" class="btn btn-info btn-sm"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a>';
				if ($request->user()->current_user_can('administrator')) {
					$action .= $separator . ' <a href="javascript:client.clientOrderHistoryDelete(' . $lead->id . ')" title="clientOrderhistory Delete"><i class="fa fa-fw fa-trash"></i></a>';
				}

				$type = '';
				switch ($lead->package_name) {
					case 'Gold':
						$type = 'Gold';
						break;
					case 'Diamond':
						$type = 'Diamond';
						break;
					case 'Platinum':
						$type = 'Platinum';
						break;
				}
				$data[] = [
					"<a href='/developer/clients/update/$lead->username'>$lead->username</a>",
					$lead->business_name,
					$type,
					$lead->paid_amount,
					$lead->gst_tax,
					$lead->total_amount,
					ucfirst($lead->payment_mode),
					($lead->first_name . ' ' . $lead->last_name),
					date_format(date_create($lead->created_at), 'd-m-Y H:i:s'),
					$orderpdf,
					$proforma,
					$invoicepdf,
					$action
				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}

		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('admin.clientOrderhistory.orderhistory', ['search' => $search]);
	}
	/**
	 * Delete transaction amuunt client .
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function clientOrderHistoryDelete($id)
	{
		try {

			$paymentHistory = PaymentHistory::findorFail($id);


			if ($paymentHistory->delete()) {
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Order deleted successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Order  not deleted !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Order not found !!"
				]
			], 200);
		}
	}

	/**
	 * Delete transaction amuunt client .
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function status($id)
	{
		try {

			$paymentHistory = PaymentHistory::findorFail($id);
			$client = Client::findorFail($paymentHistory->client_id);
			$leads_count_diff = $paymentHistory->leads_count + $client->leads_count;
			$client->leads_count = $paymentHistory->leads_count;
			$client->leads_remaining = $client->leads_remaining + $paymentHistory->leads_count;
			;
			$client->cost_per_lead = $paymentHistory->cost_per_lead;
			$client->client_type = $paymentHistory->package_name;
			$client->expired_from = $paymentHistory->expired_from;
			$client->expired_on = $paymentHistory->expired_on;
			$client->balance_amt = $paymentHistory->total_amount;
			$client->coins_amt = $client->coins_amt + $paymentHistory->coins_amt;
			$client->paid_status = 1;
			$client->certified_status = 1;
			$client->active_status = 1;

			if ($client->save()) {
				$paymentHistory->invoice_status = '1';
				$paymentHistory->save();
				return response()->json([
					"statusCode" => 1,
					"data" => [
						"responseCode" => 200,
						"payload" => "",
						"message" => "Invoice Status Approved successfully !!"
					]
				], 200);
			} else {
				return response()->json([
					"statusCode" => 0,
					"data" => [
						"responseCode" => 400,
						"payload" => "",
						"message" => "Invoice Status  not successfully !!"
					]
				], 200);
			}
		} catch (\Exception $e) {
			return response()->json([
				"statusCode" => 0,
				"data" => [
					"responseCode" => 404,
					"payload" => "",
					"message" => "Invoice Status not found !!"
				]
			], 200);
		}
	}
	public function edit(Request $request, $id)
	{


		$order_id = base64_decode($id);

		$paymentHistory = PaymentHistory::find($order_id);
		$moderesults = Modesdetails::get();
		$banksdetails = Banksdetails::get();
		$client = Client::where('id', $paymentHistory->client_id)->first();

		return view('admin.clientOrderhistory.update_orderhistory', ['paymentHistory' => $paymentHistory, 'moderesults' => $moderesults, 'banksdetails' => $banksdetails, 'client' => $client]);

	}

	public function update(Request $request)
	{


		$validator = Validator::make($request->all(), [
			'package_name' => 'required',
			'paid_amount' => 'required',
			'gst_status' => 'required',
			'gst_total_amount' => 'required',
			'tds_status' => 'required',
			'total_amount' => 'required',
			// 'paid_amt_in_words'=>'required',
			'stud-payment_mode' => 'required',
			//	'pay_mode_details'=>'required',
			//	'leads_count'=>'required',
			'coins_amt' => 'required',
			//	'expired_from'=>'required',
			//	'expired_on'=>'required',

		]);
		if ($validator->fails()) {
			$errorsBag = $validator->getMessageBag()->toArray();
			return response()->json(['status' => 1, 'errors' => $errorsBag], 400);
		}



		if ($request->input('Update_order') == 'UpdateOrder' && !empty($request->input('paid_amount'))) {

			$order_id = $request->input('order_id');
			$paymenthistory = PaymentHistory::find($order_id);
			$paymenthistory->package_name = $request->input('package_name');
			// $paymenthistory->leads_count = $request->input('leads_count');
			$paymenthistory->coins_amt = $request->input('coins_amt');
			//	$paymenthistory->expired_from = $request->input('expired_from');
			//	$paymenthistory->expired_on = $request->input('expired_on');
			$paymenthistory->selectproofid = $request->input('selectproofid');
			$paymenthistory->proofid = $request->input('proofid');
			$paid_amount = $request->input('paid_amount');
			$paymenthistory->paid_amount = $paid_amount;
			$gst_tax = $request->input('gst_tax');
			$paymenthistory->gst_status = $request->input('gst_status');
			$paymenthistory->gst_tax = $gst_tax;
			$gst_total_amount = $request->input('gst_total_amount');
			$paymenthistory->gst_total_amount = $gst_total_amount;
			$paymenthistory->tds_status = $request->input('tds_status');
			$tds_amount = $request->input('tds_amount');
			$paymenthistory->tds_amount = $tds_amount;
			$total_amount = $request->input('total_amount');
			$paymenthistory->total_amount = $total_amount;

			//	$paid_amt_in_words=$request->input('paid_amt_in_words');
			//	$paymenthistory->paid_amt_in_words = $paid_amt_in_words;
			//$pay_mode_details=$request->input('pay_mode_details');
			//$paymenthistory->pay_mode_details = $pay_mode_details;
			$transactionid = $request->input('transactionid');
			$paymenthistory->transactionid = $transactionid;
			$paymenthistory->payment_updatedBy = Auth::user()->id;

			// payment mode
			if (!empty($request->input('stud-payment_mode'))) {
				$stud_payment_mode = $request->input('stud-payment_mode');
				if ("cash" == $request->input('stud-payment_mode')) {
					$stud_payment_bank = "cash";
				} else if ("bank" == $stud_payment_mode) {
					if (!empty($request->input('stud-bank'))) {
						$stud_payment_bank = $request->input('stud-bank');
						$stud_card_no = $request->input('stud-card_no');
						$paymenthistory->bank_card_no = $stud_card_no;

					}


				} else if ("cheque" == $stud_payment_mode) {
					if (!empty($request->input('stud-chq_no'))) {
						$stud_card_chq_no = $request->input('stud-chq_no');
						$paymenthistory->chq_card_no = $stud_card_chq_no;

					}
					$stud_payment_bank = "cheque";
				} else if ("paytm" == $stud_payment_mode) {
					if (!empty($request->input('stud-paytm'))) {
						$stud_paytm = $request->input('stud-paytm');
						$paymenthistory->pay_paytm = $stud_paytm;
						$stud_payment_bank = "paytm";
					}

				} else if ("neft" == $stud_payment_mode) {
					if (!empty($request->input('stud-neft'))) {
						$stud_neft = $request->input('stud-neft');
						$paymenthistory->pay_neft = $stud_neft;
						$stud_payment_bank = "neft";
					}

				} else if ("googlepay" == $stud_payment_mode) {
					if (!empty($request->input('stud-googlepay'))) {
						$pay_googlepay = $request->input('stud-googlepay');
						$paymenthistory->pay_googlePay = $pay_googlepay;
						$stud_payment_bank = "googlepay";
					}

				} else {
					if (!empty($request->input('stud-' . $stud_payment_mode))) {
						$stud_payment_bank = $request->input('stud-' . $stud_payment_mode);
					}

				}

			}



			$paymenthistory->payment_mode = $stud_payment_mode;
			$paymenthistory->payment_bank = $stud_payment_bank;	 
			if ($paymenthistory->save()) {
				return response()->json(['status' => 1, 'success' => 'Client Order payment successfully !!']);
			} else {
				return response()->json(['status' => 0, 'failed' => 'Client not updated !!']);
			}



		}

		$order_id = base64_decode($id);		 
		$paymentHistory = PaymentHistory::find($order_id);
		$moderesults = Modesdetails::get();
		$banksdetails = Banksdetails::get();

		return view('admin.clientOrderhistory.update_orderhistory', ['paymentHistory' => $paymentHistory, 'moderesults' => $moderesults, 'banksdetails' => $banksdetails]);

	}

	/**
	 * Get paginated leads.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getorderhistoryexcel(Request $request)
	{
		if (!$request->user()->current_user_can('administrator')) {
			return view('errors.unauthorised');
		}
		$leads = DB::table('payment_histories as payment');
		$leads = $leads->join('clients', 'clients.id', '=', 'payment.client_id');
		$leads = $leads->select('payment.*', 'clients.username', 'clients.business_name');
		if ($request->input('search.value') != '') {
			$leads = $leads->where(function ($query) use ($request) {
				$query->orWhere('payment.customer_name', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('payment.business_name', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('payment.email', 'LIKE', '%' . $request->input('search.value') . '%')
					->orWhere('payment.mobile', 'LIKE', '%' . $request->input('search.value') . '%');
			});
		}
		if ($request->input('search.client_type') != '') {
			$leads = $leads->where('payment.package_name', '=', $request->input('search.client_type'));
		}

		if ($request->input('search.datef') != '') {
			$leads = $leads->whereDate('payment.created_at', '>=', date_format(date_create($request->input('search.datef')), 'Y-m-d'));
		}
		if ($request->input('search.datet') != '') {
			$leads = $leads->whereDate('payment.created_at', '<=', date_format(date_create($request->input('search.datet')), 'Y-m-d'));
		}
		$leads = $leads->orderBy('payment.created_at', 'desc');
		$leads = $leads->get();

		$returnLeads = [];
		$arr = [];
		$users = DB::table('users')->select('users.id', 'users.first_name', 'users.last_name')->get();
		if ($users) {
			foreach ($users as $user) {
				$owner[$user->id] = $user->first_name . " " . $user->last_name;
			}
		}


		foreach ($leads as $lead) {
			$paymentcollect = '';
			if ($lead->paymentcollect != null && isset($owner[$lead->paymentcollect])) {
				$paymentcollect = $owner[$lead->paymentcollect];
			}
			$paymentupdatedBy = '';
			if ($lead->payment_updatedBy != null && isset($owner[$lead->payment_updatedBy])) {
				$paymentupdatedBy = $owner[$lead->payment_updatedBy];
			}




			$arr[] = [
				"User name" => $lead->username,
				"Order Number" => $lead->order_number,
				"Business Name" => $lead->business_name,
				"Customer Name" => $lead->customer_name,
				"Mobile" => $lead->mobile,
				"Package Name" => $lead->package_name,
				"Leads Count" => $lead->leads_count,
				"Paid Amount" => $lead->paid_amount,
				"Total Amount" => $lead->total_amount,
				"Payment Mode" => $lead->payment_mode,
				"Payment Collect" => $paymentcollect,
				"Collect Updated By" => $paymentupdatedBy,
				"Expired from" => date_format(date_create($lead->expired_from), 'd-M-Y'),
				"Expired On" => date_format(date_create($lead->expired_on), 'd-M-Y'),
			];
		}

		$excel = \App::make('excel');
		Excel::create('orderhistory_' . date('Y-m-d_H:i'), function ($excel) use ($arr) {
			$excel->sheet('Sheet 1', function ($sheet) use ($arr) {
				$sheet->fromArray($arr);
			});
		})->export('xls');
	}







}
