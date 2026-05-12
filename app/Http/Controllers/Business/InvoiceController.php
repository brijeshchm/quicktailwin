<?php

namespace App\Http\Controllers\Business;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Client\Client;
use DB;
use App\Models\PaymentHistory;
use Barryvdh\DomPDF\Facade\Pdf;
class InvoiceController extends Controller
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


	public function billingHistory(Request $request)
	{		 
		return view('business.billingHistory');
	}



	/**
	 * Get paginated leads.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getBillingHistory(Request $request)
	{
		if ($request->ajax()) {
			$clientID = auth()->guard('clients')->user()->id;
			$payments = PaymentHistory::where('client_id', $clientID)
				->orderBy('created_at', 'desc')
				->paginate($request->input('length'));

			$returnLeads = $data = [];
			$returnLeads['draw'] = $request->input('draw');
			$returnLeads['recordsTotal'] = $payments->total();
			$returnLeads['recordsFiltered'] = $payments->total();
			foreach ($payments as $payment) {
				$action = '';
				$separator = '';
				if ($payment->invoice_status == '1') {
					// $action .= $separator . '<a href="javascript:void(0)" data-toggle="popover" title="Invoice PDF" id="invoiceBillingPdf" data-trigger="hover" data-placement="left" data-sid="' . $payment->id . '"><i aria-hidden="true" class="bi bi-file-earmark-pdf"></i></a>';			
					// 					$action .= $separator . '<a href="' . url('business/getinvoiceBillingPrintPdf/' . $payment->id) . '" target="_blank">
					//     <i aria-hidden="true" class="bi bi-file-earmark-pdf"></i>
					// </a>';

					$action .= $separator . '<a href="'.url('business/getinvoiceBillingPrintPdf/'.$payment->id).'">
					<i class="bi bi-file-earmark-pdf"></i>
				</a>';

				}

				$data[] = [
					date_format(date_create($payment->created_at), 'd M Y'),
					$payment->paid_amount,
					$payment->gst_tax,
					$payment->total_amount,
					$action,

				];
			}
			$returnLeads['data'] = $data;
			return response()->json($returnLeads);
		}
	}
	public function getinvoiceBillingPrintPdf(Request $request,$id)
	{
		$paymentid = $id;
		// $paymentid = $request->pid;
 
		$paymentprint = PaymentHistory::findOrFail($paymentid);
		$client = Client::select('business_name','mobile','email','pan_no','gst_no','sirName','first_name','last_name','address')->where('id', $paymentprint->client_id)->first();
	 

		$imagePath = ('https://www.quickdials.com/client/images/small-logo.jpg');
		$imageData = base64_encode(file_get_contents($imagePath));
		$imageSrc  = 'data:image/png;base64,' . $imageData;


		$pdf = Pdf::loadView(
			'business.getInvoicePrintPdfSlip',
			compact('paymentprint', 'client','imageSrc')
		);

		return $pdf->download(
			'invoice_'.$paymentid.'_'.date('d-m-Y_H-i-s').'.pdf'
		);



		 
	}

	// public function getinvoiceBillingPrintPdf(Request $request, $paymentid)
	// {

	// 	if ($paymentid) {


	// 		$paymentprint = PaymentHistory::find($paymnetid);
	// 		$client = Client::withTrashed()->where('id', $paymentprint->client_id)->first();
	// 		//	return response()->view("business.getInvoicePrintPdfSlip", ['paymentprint' => $paymentprint, 'client' => $client]);




	// 		$pdf = Pdf::loadView(
	// 			'business.getInvoicePrintPdfSlip',
	// 			compact('paymentprint', 'client')
	// 		);
	// 		return $pdf->download(
	// 			'invoice_' . $paymnetid . '_' . date('d-m-Y_H-i-s') . '.pdf'
	// 		);

	// 	}
	// }

	public function coinsHistory(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$client = Client::find($clientID);
		$coinsLeads = DB::table('assigned_leads')
			->join('leads', 'leads.id', '=', 'assigned_leads.lead_id')
			->leftjoin('citylists', 'leads.city_id', '=', 'citylists.id')
			->leftjoin('keyword', 'assigned_leads.kw_id', '=', 'keyword.id')

			->select('leads.*', 'assigned_leads.client_id', 'assigned_leads.lead_id', 'assigned_leads.created_at as created', 'assigned_leads.coins', 'assigned_leads.scrapLead')

			->orderBy('assigned_leads.created_at', 'desc')
			->where('assigned_leads.client_id', $clientID)->get();

		$search = [];
		if ($request->has('search')) {
			$search = $request->input('search');
		}
		return view('business.coins-history', ['search' => $search, 'client' => $client, 'coinsLeads' => $coinsLeads]);
	}



	/**
	 * Get paginated leads.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function getPaginatedPaymentHistory(Request $request)
	{
		$clientID = auth()->guard('clients')->user()->id;
		$payments = DB::table('payment_histories')
			->where('client_id', $clientID)
			->orderBy('created_at', 'desc')
			->paginate($request->input('length'));

		$returnLeads = $data = [];
		$returnLeads['draw'] = $request->input('draw');
		$returnLeads['recordsTotal'] = $payments->total();
		$returnLeads['recordsFiltered'] = $payments->total();
		foreach ($payments as $payment) {
			$action = '';
			$separator = '';
			$action .= $separator . '<a href="javascript:void(0)" data-toggle="popover" title="Invoice PDF" id="paymentPrint" data-trigger="hover" data-placement="left" data-sid="' . $payment->id . '"><i aria-hidden="true" class="fa fa-file-pdf-o"></i></a>';

			$data[] = [
				date_format(date_create($payment->created_at), 'd M Y'),
				$payment->paid_amount,
				$payment->gst_tax,
				$payment->total_amount,
				$payment->payment_mode,
			];
		}
		$returnLeads['data'] = $data;
		return response()->json($returnLeads);
	}
}
