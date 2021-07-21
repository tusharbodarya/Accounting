<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Accounts;
use App\Models\ProductCategories;
use App\Models\Products;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseChallan;
use App\Mail\sendInvoice;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseinvoices = PurchaseInvoice::join('accounts', 'purchase_invoices.accountid', '=', 'accounts.id')
            ->select('purchase_invoices.*', 'accounts.name as account_name')
            ->where('purchase_invoices.is_deleted', 1)
            ->get();
        return view('tbl-files/tbl-purchaseinvoice')->with(['purchaseinvoices' => $purchaseinvoices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Categories = ProductCategories::where('deleted_at', 1)->get();
        $orderid = PurchaseInvoice::count();
        $orderid += 1;
        return view('add-files/add-purchaseorder')->with(['Categories' => $Categories, 'orderid' => $orderid]);
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
            "orderid" => 'required | unique:purchase_invoices',
            "total" => 'required',
            "accountid" => 'required'
        ]);

        switch ($request->taxformat) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '20')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance += $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '56')->first();
                $stateTaxOP->balance += $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '10')->first();
                $totalgst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $gst->balance += $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '58')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $intTaxOP->balance += $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $igst->balance += $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '14')->first();
                $totalnongst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $nongst->balance += $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $request->accountid)->first();
        $total = str_replace(',', '', $request->total);
        $totalBalance->balance += $total;
        $totalBalance->save();

        $purchaseInvoice = new PurchaseInvoice;
        $purchaseInvoice->orderid = $request->orderid;
        $purchaseInvoice->accountid = $request->accountid;
        $purchaseInvoice->invoicetype = 'Purchase Invoice';
        $purchaseInvoice->challannum = $request->challanno;
        $purchaseInvoice->orderdate = $request->orderdate;
        $purchaseInvoice->orderduedate = $request->orderduedate;
        $purchaseInvoice->taxformate = $request->taxformat;
        $purchaseInvoice->discountformate = $request->discountFormat;
        $purchaseInvoice->notes = $request->notes;
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
        $purchaseInvoice->productarray = $productarray;
        $purchaseInvoice->totaltax = $request->totaltax;
        $purchaseInvoice->totaldiscount = $request->totaldiscount;
        $purchaseInvoice->total = $request->total;
        $save = $purchaseInvoice->save();
        if ($save) {
            return back()->with('success', 'Purchase Invoice has been Successfuly added.');
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
        $purchaseInvoice = PurchaseInvoice::join('accounts', 'purchase_invoices.accountid', '=', 'accounts.id')
        ->select('purchase_invoices.*', 'accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('purchase_invoices.id', $id)->first();
        $products = unserialize($purchaseInvoice->productarray);
        return view('views-files/purchaseinvoice')->with(['purchaseInvoice' => $purchaseInvoice, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseInvoice = PurchaseInvoice::where('id', $id)->first();
        return view('edit-files/edit-purchaseinvoice')->with(['purchaseInvoice' => $purchaseInvoice]);
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
        $purchaseInvoice = PurchaseInvoice::where('id', $id)
        ->update([
            'challannum' => $request->challanno,
            'orderdate' => $request->orderdate,
            'orderduedate' => $request->orderduedate,
            'notes' => $request->notes
        ]);

        return redirect('/purchaseinvoice')->with('success', 'Purchase Invoice has been Successfuly Updated.');
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

    public function purchaseInvoiceDelete($id){
        $PurchaseInvoice = PurchaseInvoice::where('id', $id)->update(['is_deleted' => 0]);
        $PurchaseInvoice = PurchaseInvoice::where('id', $id)->first();
        switch ($PurchaseInvoice->taxformate) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '20')->first();
                $totaltax = str_replace(',', '', $PurchaseInvoice->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance -= $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '56')->first();
                $stateTaxOP->balance -= $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '10')->first();
                $totalgst = str_replace(',', '', $PurchaseInvoice->total) - str_replace(',', '', $PurchaseInvoice->totaltax);
                $gst->balance -= $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '58')->first();
                $totaltax = str_replace(',', '', $PurchaseInvoice->totaltax);
                $intTaxOP->balance -= $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $PurchaseInvoice->total) - str_replace(',', '', $PurchaseInvoice->totaltax);
                $igst->balance -= $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '14')->first();
                $totalnongst = str_replace(',', '', $PurchaseInvoice->total) - str_replace(',', '', $PurchaseInvoice->totaltax);
                $nongst->balance -= $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $PurchaseInvoice->accountid)->first();
        $total = str_replace(',', '', $PurchaseInvoice->total);
        $totalBalance->balance -= $total;
        $totalBalance->save();
        return redirect('/purchaseinvoice')->with('success', 'Purchase Invoice has been Successfuly Deleted.');
    }

    public function PurchaseChallan()
    {
        $Categories = ProductCategories::where('deleted_at', 1)->get();
        $orderid = PurchaseChallan::count();
        $orderid += 1;
        return view('add-files/add-purchasechallan')->with(['Categories' => $Categories, 'orderid' => $orderid]);
    }

    public function PurchaseChallan_store(Request $req)
    {
        $req->validate([
            "orderid" => 'required | unique:purchase_challans',
            "total" => 'required',
            "accountid" => 'required'
        ]);

        $PurchaseChallan = new PurchaseChallan;
        $PurchaseChallan->orderid = $req->orderid;
        $PurchaseChallan->accountid = $req->accountid;
        $PurchaseChallan->invoicetype = 'Purchase Challan';
        $PurchaseChallan->challannum = $req->challanno;
        $PurchaseChallan->orderdate = $req->orderdate;
        $PurchaseChallan->orderduedate = $req->orderduedate;
        $PurchaseChallan->taxformate = $req->taxformat;
        $PurchaseChallan->discountformate = $req->discountFormat;
        $PurchaseChallan->notes = $req->notes;
        $product_name = $req->product_name;
        $product_qty = $req->product_qty;
        $product_price = $req->product_price;
        $product_tax = $req->product_tax;
        $texttaxa = $req->texttaxa;
        $product_discount = $req->product_discount;
        $ammount = $req->ammount;
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
        $PurchaseChallan->productarray = $productarray;
        $PurchaseChallan->totaltax = $req->totaltax;
        $PurchaseChallan->totaldiscount = $req->totaldiscount;
        $PurchaseChallan->total = $req->total;
        $save = $PurchaseChallan->save();
        if ($save) {
            return back()->with('success', 'Sale Invoice has been Successfuly added.');
        } else {
            return back()->with('fail', 'Somthing Went wrong, try Again Later');
        }
    }

    public function PurchaseChallan_show()
    {
        $PurchaseChallans = PurchaseChallan::join('accounts', 'purchase_challans.accountid', '=', 'accounts.id')
        ->select('purchase_challans.*', 'accounts.name as account_name')
        ->where('purchase_challans.is_deleted', 1)
        ->get();
        return view('tbl-files/tbl-purchasechallan')->with(['PurchaseChallans' => $PurchaseChallans]);
    }

    public function PurchaseChallan_edit($id)
    {
        $PurchaseChallans = PurchaseChallan::where('id', $id)->first();
        return view('edit-files/edit-PurchaseChallan')->with(['PurchaseChallans' => $PurchaseChallans]);
    }

    public function PurchaseChallan_update(Request $request, $id)
    {
        $PurchaseChallans = PurchaseChallan::where('id', $id)
            ->update([
                'challannum' => $request->challanno,
                'orderdate' => $request->orderdate,
                'orderduedate' => $request->orderduedate,
                'notes' => $request->notes
            ]);

        return redirect('/show-purchasechallan')->with('success', 'Sale Challan has been Successfuly Updated.');
    }

    public function purchaseChallanView($id){
        $purchaseChallan = PurchaseChallan::join('accounts', 'purchase_challans.accountid', '=', 'accounts.id')
        ->select('purchase_challans.*', 'accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('purchase_challans.id', $id)->first();
        $products = unserialize($purchaseChallan->productarray);
        return view('views-files/purchasechallan')->with(['purchaseChallan' => $purchaseChallan, 'products' => $products]);
    }

    public function purchaseChallanDelete($id){
        $PurchaseChallans = PurchaseChallan::where('id', $id)->update(['is_deleted' => 0]);
        return redirect('/show-purchasechallan')->with('success', 'Purchase Challan has been Successfuly Deleted.');
    }
}
