<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Accountsgroup;
use App\Models\Transaction;

class AccountsController extends Controller
{

    function addaccount(Request $req)
    {
        $req->validate([
            "name" => 'required | unique:accounts',
        ]);
        $Accounts = new Accounts;
        $Accounts->name = $req->name;
        $Accounts->effecton = $req->effecton;
        $Accounts->accountsgroup = $req->accountsgroup;
        $Accounts->area = $req->area;
        $Accounts->city = $req->city;
        $Accounts->pincode = $req->pincode;
        $Accounts->state = $req->state;
        $Accounts->panno = $req->panno;
        $Accounts->aadharno = $req->aadharno;
        $Accounts->gstno = $req->gstno;
        $Accounts->balance = $req->balance;
        $Accounts->actype = $req->actype;
        $save = $Accounts->save();

        if ($save) {
            return back()->with('success', 'Account  has been Successfuly added.');
        } else {
            return back()->with('fail', 'Somthing Went wrong, try Again Later');
        }
    }

    function tbl_fetchaccounts()
    {
        $fetch_account = Accounts::join('accountsgroups', 'accounts.accountsgroup', '=', 'accountsgroups.id')
            ->select('accounts.*', 'accountsgroups.groupname')
            ->where('accounts.is_deleted', 1)
            ->get();
        return view('tbl-files/tbl-accounts')->with('fetch_account', $fetch_account);
    }

    function fetchacdetails(Request $req)
    {
        //  $fetchacdetails = Accounts::where('id','=',$req->id)->get();
        $fetchacdetails = Accounts::join('accountsgroups', 'accounts.accountsgroup', '=', 'accountsgroups.id')
            ->where('accounts.id', '=', $req->id)
            ->select('accounts.*', 'accountsgroups.groupname')
            ->get();
        return $fetchacdetails;
    }

    //edit Accounts
    function edit_accounts($id)
    {
        $editac =  Accounts::join('accountsgroups', 'accounts.accountsgroup', '=', 'accountsgroups.id')
            ->where('accounts.id', $id)
            ->select('accounts.*', 'accountsgroups.groupname')->first();
        $data = [
            'editac' => $editac
        ];
        return view('edit-files.edit-accounts', $data);
    }


    function update_ac(Request $req)
    {
        $req->validate([
            "name" => 'required',
        ]);
        $update_ac = Accounts::where('id', $req->id)
            ->update([
                'name' => $req->name,
                'effecton' => $req->effecton,
                'accountsgroup' => $req->accountsgroup,
                'area' => $req->area,
                'city' => $req->city,
                'pincode' => $req->pincode,
                'state' => $req->state,
                'panno' => $req->panno,
                'aadharno' => $req->aadharno,
                'gstno' => $req->gstno,
                'balance' => $req->balance,
                'actype' => $req->actype,
            ]);

        return redirect('/tbl-accounts')->with('success', 'Account  has been Successfuly Updated.');
    }

    function delete_account(Request $req)
    {
        $delete_ac = Accounts::where('id', $req->id)->update(['is_deleted' => 0]);
        return redirect('/tbl-accounts')->with('success', 'Account  has been Successfuly Deleted.');
    }



    // Account Groups
    function addacgroup(Request $req)
    {
        $req->validate([
            "groupname" => 'required | unique:accountsgroups',
        ]);

        $Accountsgroup = new Accountsgroup;
        $Accountsgroup->groupname = $req->groupname;
        $Accountsgroup->effecton = $req->effecton;
        $Accountsgroup->sequence = $req->sequence;
        $save = $Accountsgroup->save();

        if ($save) {
            return back()->with('success', 'Account Group has been Successfuly added.');
        } else {
            return back()->with('fail', 'Somthing Went wrong, try Again Later');
        }
    }


    function fetchaccountsgroup(Request $req)
    {
        $check_accountgroup = Accountsgroup::where('effecton', '=', $req->effecton)->get();
        foreach ($check_accountgroup as $ac) {
            echo "<option value='$ac->id'>$ac->groupname</option>";
        }
        // return View("add-files/add-accounts", ['check_accountgroup'=>$check_accountgroup]);
    }

    function tbl_fetchaccountsgroup()
    {
        $fetch_accountgroup = Accountsgroup::where('is_deleted', '=', '1')->get();
        return view('tbl-files/tbl-accountsgroup')->with('fetch_accountgroup', $fetch_accountgroup);
    }

    function fetchacgroupdetails(Request $req)
    {
        $fetchacgroupdetails = Accountsgroup::where('is_deleted', '=', '1')->get();
        return $fetchacgroupdetails;
    }

    //edit Accounts Group
    function edit_accountsgroup($id)
    {
        $editacgroup =  Accountsgroup::where('id', $id)->first();
        $data = [
            'editacgroup' => $editacgroup
        ];
        return view('edit-files.edit-accountsgroup', $data);
    }

    function update_acgroup(Request $req)
    {
        $req->validate([
            "groupname" => 'required'
        ]);
        $update_acgroup = Accountsgroup::where('id', $req->id)
            ->update([
                'groupname' => $req->groupname,
                'effecton' => $req->effecton,
                'sequence' => $req->sequence
            ]);

        return redirect('/tbl-accountsgroup')->with('success', 'Account Group has been Successfuly Updated.');
    }

    function delete_accountgroup(Request $req)
    {
        $delete_acgroup = Accountsgroup::where('id', $req->id)->update(['is_deleted' => 0]);
        return redirect('/tbl-accountsgroup')->with('success', 'Account Group has been Successfuly Deleted.');
    }

    // Transactions
    function transactions()
    {
        $accounts = Accounts::where('is_deleted', 1)->orderBy('name', 'ASC')->get();
        return view('add-files/add-transaction')->with('accounts', $accounts);
    }
    function fetch_transactionac(Request $req)
    {

        switch ($req->accountstype) {
            case 'cash':
                $Accounts = Accounts::where('accountsgroup', '=', '21')->where('is_deleted', 1)->get();
                return $Accounts;
            case 'bank':
                $Accounts = Accounts::where('accountsgroup', '=', '17')->orwhere('accountsgroup', '=', '18')->where('is_deleted', 1)->get();
                return $Accounts;
        }
    }

    function fetch_transactionacdetails(Request $req)
    {
        $transactionacDetails = Accounts::where('id', $req->acid)->first();
        return $transactionacDetails;
    }

    function store_transaction(Request $req){
        $req->validate([
            "company_name" => 'required',
            "toaccount" => 'required',
            "ammount" => 'required'
        ]);
        switch ($req->RcptPymt) {
            case 'Receipt':
                $fromAccount = Accounts::where('id', $req->accountid)->first();
                $total = str_replace(',', '', $req->ammount);
                $fromAccount->balance += $total;
                $fromAccount->save();

                $toAccount = Accounts::where('id', $req->toaccount)->first();
                $total = str_replace(',', '', $req->ammount);
                $toAccount->balance -= $total;
                $toAccount->save();
                break;
            case 'Payment':
                $fromAccount = Accounts::where('id', $req->accountid)->first();
                $total = str_replace(',', '', $req->ammount);
                $fromAccount->balance -= $total;
                $fromAccount->save();

                $toAccount = Accounts::where('id', $req->toaccount)->first();
                $total = str_replace(',', '', $req->ammount);
                $toAccount->balance += $total;
                $toAccount->save();
                break;
        }
        $transaction = new Transaction;
        $transaction->accountype = $req->accountype;
        $transaction->fromaccount = $req->accountid;
        $transaction->RcptPymt = $req->RcptPymt;
        $transaction->toaccount = $req->toaccount;
        $transaction->ammount = $req->ammount;
        $transaction->date = $req->date;
        $transaction->income_type = $req->income_type;
        $transaction->income_method = $req->income_method;
        $transaction->note = $req->note;
        $save = $transaction->save();
        if ($save) {
            return back()->with('success', 'Transaction Successfuly added.');
        } else {
            return back()->with('fail', 'Somthing Went wrong, try Again Later');
        }
    }

    function index_transaction(){
        $transactions = Transaction::join('accounts as fromac', 'transactions.fromaccount', '=', 'fromac.id')
        ->join('accounts as toac', 'transactions.toaccount', '=', 'toac.id')
        ->select('transactions.*', 'fromac.name as fromac_name', 'toac.name as toac_name')->get();
        return view('tbl-files/tbl-transactions')->with('transactions', $transactions);
    }

    function transaction_view($id){
        $transaction = Transaction::leftJoin('accounts as fa', 'fa.id', '=', 'transactions.fromaccount')
        ->leftJoin('accounts as ta', 'ta.id', '=', 'transactions.toaccount')
        ->select('transactions.*', 'fa.name as fromname','ta.name as toname', 'fa.city as fromcity')
        ->where('transactions.id', $id)
        ->first();
        return view('views-files/transactions')->with('transaction', $transaction);
    }

    function accountstatement(){
        $account = Accounts::where('is_deleted', 1)->get();
        return view('statements.accountstatement')->with('account', $account);
    }
}
