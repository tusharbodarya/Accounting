<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Accounts;
use App\Models\ProductCategories;
use App\Models\Products;
use App\Models\SalesInvoice;
use App\Models\SaleChallan;
use App\Mail\sendInvoice;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesInvoice = SalesInvoice::join('accounts', 'sales_invoices.accountid', '=', 'accounts.id')
        ->select('sales_invoices.*', 'accounts.name as account_name')
        ->where('sales_invoices.is_deleted', 1)
        ->get();
        return view('tbl-files/tbl-salesinvoice')->with(['salesInvoice'=>$salesInvoice]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Categories = ProductCategories::where('deleted_at', 1)->get();
        $orderid = SalesInvoice::count();
        $orderid += 1;
        return view('add-files/add-saleinvoice')->with(['Categories' => $Categories, 'orderid' => $orderid]);
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
            "orderid" => 'required | unique:sales_invoices',
            "total" => 'required',
            "accountid" => 'required'
        ]);

        switch ($request->taxformat) {
            case 'gst':
                $centralTaxOP = Accounts::where('id','=','21')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance += $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id','=', '57')->first();
                $stateTaxOP->balance += $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '2')->first();
                $totalgst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $gst->balance += $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '59')->first();
                $totaltax = str_replace(',', '', $request->totaltax);
                $intTaxOP->balance += $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $igst->balance += $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '6')->first();
                $totalnongst = str_replace(',', '', $request->total) - str_replace(',', '', $request->totaltax);
                $nongst->balance += $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id',$request->accountid)->first();
        $total = str_replace(',', '', $request->total);
        $totalBalance->balance += $total;
        $totalBalance->save();

        $saleInvoice = new SalesInvoice;
        $saleInvoice->orderid = $request->orderid;
        $saleInvoice->accountid = $request->accountid;
        $saleInvoice->invoicetype = 'Sale Invoice';
        $saleInvoice->challannum = $request->challanno;
        $saleInvoice->orderdate = $request->orderdate;
        $saleInvoice->orderduedate = $request->orderduedate;
        $saleInvoice->taxformate = $request->taxformat;
        $saleInvoice->discountformate = $request->discountFormat;
        $saleInvoice->notes = $request->notes;
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
        $saleInvoice->productarray = $productarray;
        $saleInvoice->totaltax = $request->totaltax;
        $saleInvoice->totaldiscount = $request->totaldiscount;
        $saleInvoice->total = $request->total;
        $save = $saleInvoice->save();
        if ($save) {
            return back()->with('success', 'Sale Invoice has been Successfuly added.');
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
        $saleInvoice = SalesInvoice::join('accounts', 'sales_invoices.accountid', '=', 'accounts.id')
            ->select('sales_invoices.*', 'accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
            ->where('sales_invoices.id',$id)->first();
            $products = unserialize($saleInvoice->productarray);
        
        return view('views-files/saleInvoice')->with(['saleInvoice' => $saleInvoice,'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salesInvoice = SalesInvoice::join('accounts', 'sales_invoices.accountid', '=', 'accounts.id')
        ->select('sales_invoices.*', 'accounts.name as account_name', 'accounts.balance as balance', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('sales_invoices.id', $id)->first();
        $Categories = ProductCategories::where('deleted_at', 1)->get();
        $products = unserialize($salesInvoice->productarray);
        return view('edit-files/edit-saleinvoice')->with(['salesInvoice' =>$salesInvoice, 'Categories' =>$Categories, 'products' => $products]);
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
        $salesInvoice = SalesInvoice::where('id', $id)
            ->update([
                'challannum' => $request->challanno,
                'orderdate' => $request->orderdate,
                'orderduedate' => $request->orderduedate,
                'notes' => $request->notes
                ]);

        return redirect('/saleinvoice')->with('success', 'Sale Invoice has been Successfuly Updated.');
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

    public function saleInvoiceDelete($id){
        $salesInvoice = SalesInvoice::where('id', $id)->update(['is_deleted' => 0]);
        $salesInvoice = SalesInvoice::where('id', $id)->first();
        switch ($salesInvoice->taxformate) {
            case 'gst':
                $centralTaxOP = Accounts::where('id', '=', '21')->first();
                $totaltax = str_replace(',', '', $salesInvoice->totaltax);
                $totaltax = $totaltax / 2;
                $centralTaxOP->balance -= $totaltax;
                $centralTaxOP->save();
                $stateTaxOP = Accounts::where('id', '=', '57')->first();
                $stateTaxOP->balance -= $totaltax;
                $stateTaxOP->save();
                $gst = Accounts::where('id', '=', '2')->first();
                $totalgst = str_replace(',', '', $salesInvoice->total) - str_replace(',', '', $salesInvoice->totaltax);
                $gst->balance -= $totalgst;
                $gst->save();
                break;
            case 'igst':
                $intTaxOP = Accounts::where('id', '=', '3')->first();
                $totaltax = str_replace(',', '', $salesInvoice->totaltax);
                $intTaxOP->balance -= $totaltax;
                $intTaxOP->save();
                $igst = Accounts::where('id', '=', '11')->first();
                $totaligst = str_replace(',', '', $salesInvoice->total) - str_replace(',', '', $salesInvoice->totaltax);
                $igst->balance -= $totaligst;
                $igst->save();
                break;
            case 'other':
                $nongst = Accounts::where('id', '=', '6')->first();
                $totalnongst = str_replace(',', '', $salesInvoice->total) - str_replace(',', '', $salesInvoice->totaltax);
                $nongst->balance -= $totalnongst;
                $nongst->save();
                break;
        }

        $totalBalance = Accounts::where('id', $salesInvoice->accountid)->first();
        $total = str_replace(',', '', $salesInvoice->total);
        $totalBalance->balance -= $total;
        $totalBalance->save();
        return redirect('/saleinvoice')->with('success', 'Sale Invoice has been Successfuly Deleted.');
    }

     function fetchaccount(Request $req){
        switch ($req->accountstype) {
            case 'debit':
                $accounts = Accounts::where('is_deleted','=','1')->where('accountsgroup','=','41')->orwhere('accountsgroup','=','25')->orwhere('accountsgroup','=','24')->get();
                break;
             case 'cash':
                $accounts = Accounts::where('is_deleted','=','1')->where('accountsgroup','=','21')->get();
                break;
        }
        return  $accounts;
    }
    public function fetchac_details(Request $req){
            $accounts = Accounts::where('id',$req->accounts)->get();
             return  $accounts;
    }
    public function fetch_product(Request $req){
        $Products = Products::where('categories', $req->Category)->get();
        return $Products;
    }
    public function fetch_productsdetails(Request $req){
        $Products = Products::where('name', $req->product_name)->first();
        echo "
			<div id='p_price'> " . $Products->price . "</div>
			<div id='p_tax_rate' >" . $Products->tax . "</div>
			<div id='p_discount_rate'>" . $Products->discount . "</div>";
    }

    public function sendInvoice(){
        $details = [
            "title" => 'Sale Invoice',
            "body" => 'Recived Sale Invoice From Khodiyar Creation.'
        ];

        Mail::to('19bmiit109@gmail.com')->send(new sendInvoice($details));
        return "Invoice Sent";
    }

    public function salechallan(){
        $Categories = ProductCategories::where('deleted_at', 1)->get();
        $orderid = SaleChallan::count();
        $orderid += 1;
        return view('add-files/add-salechallan')->with(['Categories' => $Categories, 'orderid' => $orderid]);
    }

    public function salechallan_store(Request $req){
        $req->validate([
            "orderid" => 'required | unique:sale_challans',
            "total" => 'required',
            "accountid" => 'required'
        ]);

        $saleChallan = new SaleChallan;
        $saleChallan->orderid = $req->orderid;
        $saleChallan->accountid = $req->accountid;
        $saleChallan->invoicetype = 'Sale Challan';
        $saleChallan->challannum = $req->challanno;
        $saleChallan->orderdate = $req->orderdate;
        $saleChallan->orderduedate = $req->orderduedate;
        $saleChallan->taxformate = $req->taxformat;
        $saleChallan->discountformate = $req->discountFormat;
        $saleChallan->notes = $req->notes;
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
        $saleChallan->productarray = $productarray;
        $saleChallan->totaltax = $req->totaltax;
        $saleChallan->totaldiscount = $req->totaldiscount;
        $saleChallan->total = $req->total;
        $save = $saleChallan->save();
        if ($save) {
            return back()->with('success', 'Sale Invoice has been Successfuly added.');
        } else {
            return back()->with('fail', 'Somthing Went wrong, try Again Later');
        }
    }

    public function salechallan_show(){
        $SaleChallans = SaleChallan::join('accounts', 'sale_challans.accountid', '=', 'accounts.id')
        ->select('sale_challans.*', 'accounts.name as account_name')
        ->where('sale_challans.is_deleted', 1)
        ->get();
        return view('tbl-files/tbl-salechallan')->with(['SaleChallans' => $SaleChallans]);
    }

    public function saleChallan_edit($id){
        $saleChallans = SaleChallan::where('id', $id)->first();
        return view('edit-files/edit-salechallan')->with(['saleChallans' => $saleChallans]);
    }

    public function salechallan_update(Request $request, $id){
        $saleChallans = SaleChallan::where('id', $id)
        ->update([
            'challannum' => $request->challanno,
            'orderdate' => $request->orderdate,
            'orderduedate' => $request->orderduedate,
            'notes' => $request->notes
        ]);

        return redirect('/show-salechallan')->with('success', 'Sale Challan has been Successfuly Updated.');
    }

    public function saleChallanView($id){
        $saleChallan = SaleChallan::join('accounts', 'sale_challans.accountid', '=', 'accounts.id')
        ->select('sale_challans.*', 'accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('sale_challans.id', $id)->first();
        $products = unserialize($saleChallan->productarray);
        return view('views-files/salechallan')->with(['saleChallan' => $saleChallan, 'products' => $products]);
    }

    public function saleChallanDelete($id){
        $SaleChallan = SaleChallan::where('id', $id)->update(['is_deleted' => 0]);
        return redirect('/show-salechallan')->with('success', 'Sale Challan has been Successfuly Deleted.');
    }

}
