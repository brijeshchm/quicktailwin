<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\client\Client;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $leads = DB::table('transactions')
                ->leftJoin('clients', 'transactions.client_id', '=', 'clients.id')
                ->select('transactions.*', 'clients.username', 'clients.business_name', 'clients.client_type')
                ->orderBy('transactions.created_at', 'desc')
                ->paginate($request->input('length'));

            $returnLeads = $data = [];
            $returnLeads['draw'] = $request->input('draw');
            $returnLeads['recordsTotal'] = $leads->total();
            $returnLeads['recordsFiltered'] = $leads->total();
            foreach ($leads as $lead) {
                $key = '';
                switch ($lead->key) {
                    case 'balance_amt':
                        $key = 'Amount';
                        break;
                    default:
                        $key = $lead->key;
                        break;
                }
                $type = '';
                switch ($lead->client_type) {
                    case 'gold':
                        $type = 'Gold';
                        break;
                    case 'diamond':
                        $type = 'Diamond';
                        break;
                    case 'platinum':
                        $type = 'Platinum';
                        break;
                }
                $data[] = [
                    "<a href='/developer/clients/update/$lead->username'>$lead->username</a>",
                    $lead->business_name,
                    $type,
                    $key,
                    $lead->value,
                    date_format(date_create($lead->created_at), 'd-m-Y H:i:s'),
                    ($request->user()->current_user_can('administrator|admin')) ? '<a href="javascript:client.clientTransactionDelete(' . $lead->id . ')" title="Transaction Delete"><i class="fa fa-fw fa-trash"></i></a>' : '',
                ];
            }
            $returnLeads['data'] = $data;
            return response()->json($returnLeads);
        }
        $search = [];
        if ($request->has('search')) {
            $search = $request->input('search');
        }
        return view('admin.transaction.transactions', ['search' => $search]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
