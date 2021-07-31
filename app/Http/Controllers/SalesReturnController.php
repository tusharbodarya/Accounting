<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesReturn;
use App\Models\ProductCategories;
use App\Models\Accounts;

class SalesReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesReturns = SalesReturn::join('accounts', 'sales_returns.accountid', '=', 'accounts.id')
        ->select('sales_returns.*', 'accounts.name as account_name')
        ->where('sales_returns.is_deleted', 1)
        ->get();
        return view('tbl-files/tbl-salesreturn')->with(['salesReturns' => $salesReturns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Categories = ProductCategories::where('is_deleted', 1)->get();
        $orderid = SalesReturn::count();
        $orderid += 1;
        return view('add-files/add-salesreturn')->with(['Categories' => $Categories, 'orderid' => $orderid]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "orderid" => 'required | unique:sales_returns',
            "total" => 'required',
            "accountid" => 'required'
        ]);

        switch ($request->taxformat) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '21')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance -= $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '57')->first();
                $stateTaxOP->balance -= $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '2')->first();
                $totalgst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $gst->balance -= $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '59')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $intTaxOP->balance -= $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $igst->balance -= $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '6')->first();
                $totalnongst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $nongst->balance -= $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $request->accountid)->first();
        $total = str_replace(',', '', $request->total);
        $totalBalance->balance -= $total;
        $totalBalance->save();

        $saleReturn = new SalesReturn;
        $saleReturn->orderid = $request->orderid;
        $saleReturn->accountid = $request->accountid;
        $saleReturn->invoicetype = 'Sale Return';
        $saleReturn->challannum = $request->challanno;
        $saleReturn->orderdate = $request->orderdate;
        $saleReturn->orderduedate = $request->orderduedate;
        $saleReturn->taxformate = $request->taxformat;
        $saleReturn->discountformate = $request->discountFormat;
        $saleReturn->notes = $request->notes;
        $product_name = $request->product_name;
        $product_qty = $request->product_qty;
        $product_price = $request->product_price;
        $product_tax = $request->product_tax;
        $texttaxa = $request->texttaxa;
        $product_discount = $request->product_discount;
        $ammount = $request->ammount;
        $size = sizeof($product_name);
        $products  = array();
        for ($i = 0; $i < $size; $i++) {
            $products[] = array(
                'product_name' => $product_name[$i],
                'product_qty' => $product_qty[$i],
                'product_price' => $product_price[$i],
                'product_tax' => $product_tax[$i],
                'texttaxa' => $texttaxa[$i],
                'product_discount' => $product_discount[$i],
                'ammount' => $ammount[$i]
            );
        }
        $productarray = serialize($products);
        $saleReturn->productarray = $productarray;
        $saleReturn->totaltax = $request->totaltax;
        $saleReturn->totaldiscount = $request->totaldiscount;
        $saleReturn->total = $request->total;
        $save = $saleReturn->save();
        if ($save) {
            return back()->with('success', 'Sale Return has been Successfuly added.');
        } else {
            return back()->with('fail', 'Somthing Went wrong, try Again Later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salesReturn = SalesReturn::join('accounts', 'sales_returns.accountid', '=', 'accounts.id')
        ->select('sales_returns.*', 'accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('sales_returns.id', $id)->first();
        $products = unserialize($salesReturn->productarray);
        return view('views-files/salesreturn')->with(['salesReturn' => $salesReturn, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $SalesReturn = SalesReturn::join('accounts', 'sales_returns.accountid', '=', 'accounts.id')
        ->select('sales_returns.*', 'accounts.name as account_name', 'accounts.balance as balance', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('sales_returns.id', $id)->first();
        $Categories = ProductCategories::where('is_deleted', 1)->get();
        $products = unserialize($SalesReturn->productarray);
        return view('edit-files/edit-salereturn')->with(['SalesReturn' =>$SalesReturn, 'Categories' => $Categories, 'products' => $products]);
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
        $SalesReturn = SalesReturn::where('id', $id)->first();
        switch ($SalesReturn->taxformate) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '21')->first();
                $totaltax = str_replace(',', '', $SalesReturn->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance += $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '57')->first();
                $stateTaxOP->balance += $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '2')->first();
                $totalgst = str_replace(',', '', $SalesReturn->total) - str_replace(',', '', $SalesReturn->totaltax);
                $gst->balance += $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '59')->first();
                $totaltax = str_replace(',', '', $SalesReturn->totaltax);
                $intTaxOP->balance += $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $SalesReturn->total) - str_replace(',', '', $SalesReturn->totaltax);
                $igst->balance += $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '6')->first();
                $totalnongst = str_replace(',', '', $SalesReturn->total) - str_replace(',', '', $SalesReturn->totaltax);
                $nongst->balance += $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $SalesReturn->accountid)->first();
        $total = str_replace(',', '', $SalesReturn->total);
        $totalBalance->balance += $total;
        $totalBalance->save();

        $request->validate([
            "orderid" => 'required',
            "total" => 'required',
            "accountid" => 'required'
        ]);
        switch ($request->taxformat) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '21')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance -= $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '57')->first();
                $stateTaxOP->balance -= $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '2')->first();
                $totalgst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $gst->balance -= $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '59')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $intTaxOP->balance -= $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $igst->balance -= $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '6')->first();
                $totalnongst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $nongst->balance -= $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $request->accountid)->first();
        $total = str_replace(',', '', $request->total);
        $totalBalance->balance -= $total;
        $totalBalance->save();

        $product_name = $request->product_name;
        $product_qty = $request->product_qty;
        $product_price = $request->product_price;
        $product_tax = $request->product_tax;
        $texttaxa = $request->texttaxa;
        $product_discount = $request->product_discount;
        $ammount = $request->ammount;
        $size = sizeof($product_name);
        $products  = array();
        for ($i = 0; $i < $size; $i++) {
            $products[] = array(
                'product_name' => $product_name[$i],
                'product_qty' => $product_qty[$i],
                'product_price' => $product_price[$i],
                'product_tax' => $product_tax[$i],
                'texttaxa' => $texttaxa[$i],
                'product_discount' => $product_discount[$i],
                'ammount' => $ammount[$i]
            );
        }
        $productarray = serialize($products);
        $SalesReturn = SalesReturn::where('id', $id)
        ->update([
            'orderid' => $request->orderid,
            'accountid' => $request->accountid,
            'challannum' => $request->challanno,
            'orderdate' => $request->orderdate,
            'orderduedate' => $request->orderduedate,
            'taxformate' => $request->taxformat,
            'discountformate' => $request->discountFormat,
            'notes' => $request->notes,
            'productarray' => $productarray,
            'totaltax' => $request->totaltax,
            'totaldiscount' => $request->totaldiscount,
            'total' => $request->total
        ]);

        return redirect('/salesreturn')->with('success', 'Sale Return has been Successfuly Updated.');
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

    public function salesReturnDelete($id){
        $SalesReturn = SalesReturn::where('id', $id)->update(['is_deleted' => 0]);
        $SalesReturn = SalesReturn::where('id', $id)->first();
        switch ($SalesReturn->taxformate) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '21')->first();
                $totaltax = str_replace(',', '', $SalesReturn->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance += $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '57')->first();
                $stateTaxOP->balance += $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '2')->first();
                $totalgst = str_replace(',', '', $SalesReturn->total) - str_replace(',', '', $SalesReturn->totaltax);
                $gst->balance += $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '59')->first();
                $totaltax = str_replace(',', '', $SalesReturn->totaltax);
                $intTaxOP->balance += $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $SalesReturn->total) - str_replace(',', '', $SalesReturn->totaltax);
                $igst->balance += $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '6')->first();
                $totalnongst = str_replace(',', '', $SalesReturn->total) - str_replace(',', '', $SalesReturn->totaltax);
                $nongst->balance += $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $SalesReturn->accountid)->first();
        $total = str_replace(',', '', $SalesReturn->total);
        $totalBalance->balance += $total;
        $totalBalance->save();
        return redirect('/salesreturn')->with('success', 'Sale Return has been Successfuly Deleted.');
    }
}
