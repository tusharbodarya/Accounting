<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Accounts;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::join('accounts as fromac', 'transactions.fromaccount', '=', 'fromac.id')
        ->join('accounts as toac', 'transactions.toaccount', '=', 'toac.id')
        ->select('transactions.*', 'fromac.name as fromac_name', 'toac.name as toac_name')->get();
        return view('tbl-files/tbl-transactions')->with('transactions', $transactions);
    }

    public function bank_create(){
        $fromaccounts = Accounts::where('is_deleted', 1)->where('accountsgroup', 17)->orWhere('accountsgroup', 18)->orWhere('accountsgroup', 19)->get();
        $toaccounts = Accounts::where('is_deleted', 1)->orderBy('name', 'ASC')->get();
        return view('add-files/add-banktransaction')->with(['fromaccounts' => $fromaccounts, 'toaccounts' => $toaccounts]);
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
