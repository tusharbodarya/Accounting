<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\ProductCategories;
use App\Models\Products;
use App\Models\PurchaseChallan;
use App\Models\SaleChallan;
use App\Models\JobWorkChallan;
use App\Mail\sendInvoice;

class ChallanController extends Controller
{
    public function PurchaseChallan()
    {
        $Categories = ProductCategories::where('is_deleted', 1)->get();
        $orderid = PurchaseChallan::count();
        $orderid += 1;
        return view('add-files/add-purchasechallan')->with(['Categories' => $Categories, 'orderid' => $orderid]);
    }

    public function PurchaseChallan_store(Request $req)
    {
        $req->validate([
            "orderid" => 'required',
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
        $PurchaseChallan = PurchaseChallan::join('accounts', 'purchase_challans.accountid', '=', 'accounts.id')
        ->select('purchase_challans.*', 'accounts.name as account_name', 'accounts.balance as balance', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('purchase_challans.id', $id)->first();
        $Categories = ProductCategories::where('is_deleted', 1)->get();
        $products = unserialize($PurchaseChallan->productarray);
        return view('edit-files/edit-PurchaseChallan')->with(['PurchaseChallan' =>$PurchaseChallan, 'Categories' => $Categories, 'products' => $products]);
    }

    public function PurchaseChallan_update(Request $request, $id)
    {
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

        $PurchaseChallan = PurchaseChallan::where('id', $id)
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

        return redirect('/show-purchasechallan')->with('success', 'Sale Challan has been Successfuly Updated.');
    }

    public function purchaseChallanView($id)
    {
        $purchaseChallan = PurchaseChallan::join('accounts', 'purchase_challans.accountid', '=', 'accounts.id')
        ->select('purchase_challans.*', 'accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('purchase_challans.id', $id)->first();
        $products = unserialize($purchaseChallan->productarray);
        return view('views-files/purchasechallan')->with(['purchaseChallan' => $purchaseChallan, 'products' => $products]);
    }

    public function purchaseChallanDelete($id)
    {
        $PurchaseChallans = PurchaseChallan::where('id', $id)->update(['is_deleted' => 0]);
        return redirect('/show-purchasechallan')->with('success', 'Purchase Challan has been Successfuly Deleted.');
    }

    public function salechallan()
    {
        $Categories = ProductCategories::where('is_deleted', 1)->get();
        $orderid = SaleChallan::count();
        $orderid += 1;
        return view('add-files/add-salechallan')->with(['Categories' => $Categories, 'orderid' => $orderid]);
    }

    public function salechallan_store(Request $req)
    {
        $req->validate([
            "orderid" => 'required',
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

    public function salechallan_show()
    {
        $SaleChallans = SaleChallan::join('accounts', 'sale_challans.accountid', '=', 'accounts.id')
        ->select('sale_challans.*', 'accounts.name as account_name')
        ->where('sale_challans.is_deleted', 1)
        ->get();
        return view('tbl-files/tbl-salechallan')->with(['SaleChallans' => $SaleChallans]);
    }

    public function saleChallan_edit($id)
    {
        $SaleChallan = SaleChallan::join('accounts', 'sale_challans.accountid', '=', 'accounts.id')
        ->select('sale_challans.*', 'accounts.name as account_name', 'accounts.balance as balance', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('sale_challans.id', $id)->first();
        $Categories = ProductCategories::where('is_deleted', 1)->get();
        $products = unserialize($SaleChallan->productarray);
        return view('edit-files/edit-salechallan')->with(['SaleChallan' =>$SaleChallan, 'Categories' => $Categories, 'products' => $products]);
    }

    public function salechallan_update(Request $request, $id)
    {
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

        $SaleChallan = SaleChallan::where('id', $id)
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

        return redirect('/show-salechallan')->with('success', 'Sale Challan has been Successfuly Updated.');
    }

    public function saleChallanView($id)
    {
        $saleChallan = SaleChallan::join('accounts', 'sale_challans.accountid', '=', 'accounts.id')
        ->select('sale_challans.*', 'accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('sale_challans.id', $id)->first();
        $products = unserialize($saleChallan->productarray);
        return view('views-files/salechallan')->with(['saleChallan' => $saleChallan, 'products' => $products]);
    }

    public function saleChallanDelete($id)
    {
        $SaleChallan = SaleChallan::where('id', $id)->update(['is_deleted' => 0]);
        return redirect('/show-salechallan')->with('success', 'Sale Challan has been Successfuly Deleted.');
    }

    public function jobworkchallan()
    {
        $Categories = ProductCategories::where('is_deleted', 1)->get();
        $orderid = JobWorkChallan::where('is_deleted', 1)->count();
        $orderid += 1;
        return view('add-files/add-jobworkchallan')->with(['Categories' => $Categories, 'orderid' => $orderid]);
    }

    public function jobworkchallan_store(Request $req)
    {
        $req->validate([
            "orderid" => 'required',
            "total" => 'required',
            "accountid" => 'required'
        ]);

        $jobworkchallan = new JobWorkChallan;
        $jobworkchallan->orderid = $req->orderid;
        $jobworkchallan->accountid = $req->accountid;
        $jobworkchallan->productcategory = $req->productgroup;
        $jobworkchallan->invoicetype = 'Job Work Challan';
        $jobworkchallan->challannum = $req->challanno;
        $jobworkchallan->orderdate = $req->orderdate;
        $jobworkchallan->orderduedate = $req->orderduedate;
        $jobworkchallan->taxformate = $req->taxformat;
        $jobworkchallan->discountformate = $req->discountFormat;
        $jobworkchallan->notes = $req->notes;
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
        $jobworkchallan->productarray = $productarray;
        $jobworkchallan->totaltax = $req->totaltax;
        $jobworkchallan->totaldiscount = $req->totaldiscount;
        $jobworkchallan->total = $req->total;
        $save = $jobworkchallan->save();
        if ($save) {
            return back()->with('success', 'Job Work Challan has been Successfuly added.');
        } else {
            return back()->with('fail', 'Somthing Went wrong, try Again Later');
        }
    }

    public function jobworkchallan_show()
    {
        $jobworkchallan = JobWorkChallan::join('accounts', 'job_work_challans.accountid', '=', 'accounts.id')
        ->select('job_work_challans.*', 'accounts.name as account_name')
        ->where('job_work_challans.is_deleted', 1)
        ->get();
        return view('tbl-files/tbl-jobworkchallan')->with(['jobworkchallan' => $jobworkchallan]);
    }

    public function jobworkchallan_edit($id)
    {
        $JobWorkChallan = JobWorkChallan::join('accounts', 'job_work_challans.accountid', '=', 'accounts.id')
        ->select('job_work_challans.*', 'accounts.name as account_name', 'accounts.balance as balance', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('job_work_challans.id', $id)->first();
        $Categories = ProductCategories::where('is_deleted', 1)->get();
        $products = unserialize($JobWorkChallan->productarray);
        return view('edit-files/edit-jobworkchallan')->with(['JobWorkChallan' =>$JobWorkChallan, 'Categories' => $Categories, 'products' => $products]);
    }

    public function jobworkchallan_update(Request $request, $id)
    {
        
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
        
        $jobworkchallan = JobWorkChallan::where('id', $id)
            ->update([
                'orderid' => $request->orderid,
                'accountid' => $request->accountid,
                'productcategory' => $request->productgroup,
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

        return redirect('/show-jobworkchallan')->with('success', 'Job Work Challan has been Successfuly Updated.');
    }

    public function jobworkchallanView($id)
    {
        $jobworkchallan = JobWorkChallan::join('accounts', 'job_work_challans.accountid', '=', 'accounts.id')
        ->join('product_categories as pc', 'job_work_challans.productcategory', '=', 'pc.id')
        ->select('job_work_challans.*', 'pc.*','accounts.name as account_name', 'accounts.gstno as gstno', 'accounts.city as city', 'accounts.pincode as pincode',)
        ->where('job_work_challans.id', $id)->first();
        $products = unserialize($jobworkchallan->productarray);
        return view('views-files/jobworkchallan')->with(['jobworkchallan' => $jobworkchallan, 'products' => $products]);
    }

    public function jobworkchallanDelete($id)
    {
        $jobworkchallan = JobWorkChallan::where('id', $id)->update(['is_deleted' => 0]);
        return redirect('/show-jobworkchallan')->with('success', 'Job Work Challan has been Successfuly Deleted.');
    }
}
