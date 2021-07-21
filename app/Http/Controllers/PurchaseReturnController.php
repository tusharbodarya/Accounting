<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseReturn;
use App\Models\ProductCategories;
use App\Models\Accounts;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseReturns = purchaseReturn::join('accounts', 'purchase_returns.accountid', '=', 'accounts.id')
        ->select('purchase_returns.*', 'accounts.name as account_name')
        ->where('purchase_returns.is_deleted', 1)
        ->get();
        return view('tbl-files/tbl-purchasereturn')->with(['purchaseReturns' => $purchaseReturns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Categories = ProductCategories::where('deleted_at', 1)->get();
        $orderid = PurchaseReturn::count();
        $orderid += 1;
        return view('add-files/add-purchasereturn')->with(['Categories' => $Categories, 'orderid' => $orderid]);
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
            "orderid" => 'required | unique:purchase_returns',
            "total" => 'required',
            "accountid" => 'required'
        ]);

        switch ($request->taxformat) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '20')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance -= $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '56')->first();
                $stateTaxOP->balance -= $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '10')->first();
                $totalgst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $gst->balance -= $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '58')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $intTaxOP->balance -= $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $igst->balance -= $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '14')->first();
                $totalnongst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $nongst->balance -= $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $request->accountid)->first();
        $total = str_replace(',', '', $request->total);
        $totalBalance->balance -= $total;
        $totalBalance->save();

        $purchaseReturn = new PurchaseReturn;
        $purchaseReturn->orderid = $request->orderid;
        $purchaseReturn->accountid = $request->accountid;
        $purchaseReturn->invoicetype = 'Purchase Return';
        $purchaseReturn->challannum = $request->challanno;
        $purchaseReturn->orderdate = $request->orderdate;
        $purchaseReturn->orderduedate = $request->orderduedate;
        $purchaseReturn->taxformate = $request->taxformat;
        $purchaseReturn->discountformate = $request->discountFormat;
        $purchaseReturn->notes = $request->notes;
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
        $purchaseReturn->productarray = $productarray;
        $purchaseReturn->totaltax = $request->totaltax;
        $purchaseReturn->totaldiscount = $request->totaldiscount;
        $purchaseReturn->total = $request->total;
        $save = $purchaseReturn->save();
        if ($save) {
            return redirect('/purchasereturn')->with('success', 'purchase Return has been Successfuly added.');
        } else {
            return redirect('/purchasereturn')->with('fail', 'Somthing Went wrong, try Again Later');
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
        $purchaseReturn = PurchaseReturn::join('accounts', 'purchase_returns.accountid', '=', 'accounts.id')
        ->select('purchase_returns.*', 'accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('purchase_returns.id', $id)->first();
        $products = unserialize($purchaseReturn->productarray);
        return view('views-files/purchasereturn')->with(['purchaseReturn' => $purchaseReturn, 'products' => $products]);
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

    public function purchaseReturnDelete($id){
        $PurchaseReturn = PurchaseReturn::where('id', $id)->update(['is_deleted' => 0]);
        $PurchaseReturn = PurchaseReturn::where('id', $id)->first();
        switch ($PurchaseReturn->taxformate) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '20')->first();
                $totaltax = str_replace(',', '', $PurchaseReturn->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance += $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '56')->first();
                $stateTaxOP->balance += $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '10')->first();
                $totalgst = str_replace(',', '', $PurchaseReturn->total) - str_replace(',', '', $PurchaseReturn->totaltax);
                $gst->balance += $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '58')->first();
                $totaltax = str_replace(',', '', $PurchaseReturn->totaltax);
                $intTaxOP->balance += $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $PurchaseReturn->total) - str_replace(',', '', $PurchaseReturn->totaltax);
                $igst->balance += $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '14')->first();
                $totalnongst = str_replace(',', '', $PurchaseReturn->total) - str_replace(',', '', $PurchaseReturn->totaltax);
                $nongst->balance += $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $PurchaseReturn->accountid)->first();
        $total = str_replace(',', '', $PurchaseReturn->total);
        $totalBalance->balance += $total;
        $totalBalance->save();
        return redirect('/purchasereturn')->with('success', 'Purchase Return has been Successfuly Deleted.');
    }
}
