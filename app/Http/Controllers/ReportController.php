<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Accountsgroup;

class ReportController extends Controller
{
    function trading(){
        $creditac_groups = Accountsgroup::join('accounts as ac', 'accountsgroups.id','=', 'ac.accountsgroup')
        ->select('accountsgroups.*','ac.name', 'ac.balance')
        ->whereRaw('exists( SELECT * FROM accounts WHERE accountsgroups.id = ac.accountsgroup )')
        ->where('accountsgroups.effecton', 'Trading Accounts')
        ->where('ac.is_deleted',1)
        ->where('accountsgroups.sequence', 'left')->get();
        $debitac_groups = Accountsgroup::join('accounts as ac', 'accountsgroups.id', '=', 'ac.accountsgroup')
        ->select('accountsgroups.*', 'ac.name', 'ac.balance')
        ->whereRaw('exists( SELECT * FROM accounts WHERE accountsgroups.id = accounts.accountsgroup )')
        ->where('accountsgroups.effecton', 'Trading Accounts')
        ->where('ac.is_deleted', 1)
        ->where('accountsgroups.sequence', 'right')->get();
        return view('views-files.trading')->with(['creditac_groups'=> $creditac_groups, 'debitac_groups'=> $debitac_groups]);
    }

    function balancesheet(){
        $liabilityac_groups = Accountsgroup::join('accounts as ac', 'accountsgroups.id', '=', 'ac.accountsgroup')
        ->select('accountsgroups.*', 'ac.name', 'ac.balance')
        ->whereRaw('exists( SELECT * FROM accounts WHERE accountsgroups.id = ac.accountsgroup )')
        ->where('accountsgroups.effecton', 'Balance Sheet')
        ->where('ac.is_deleted', 1)
        ->where('accountsgroups.sequence', 'left')->get();
        $assetac_groups = Accountsgroup::join('accounts as ac', 'accountsgroups.id', '=', 'ac.accountsgroup')
        ->select('accountsgroups.*', 'ac.name', 'ac.balance')
        ->whereRaw('exists( SELECT * FROM accounts WHERE accountsgroups.id = accounts.accountsgroup )')
        ->where('accountsgroups.effecton', 'Balance Sheet')
        ->where('ac.is_deleted', 1)
        ->where('accountsgroups.sequence', 'right')->get();
        return view('views-files.balancesheet')->with(['liabilityac_groups' => $liabilityac_groups, 'assetac_groups' => $assetac_groups]);
    }

    function profit_loss()
    {
        $incomeac_groups = Accountsgroup::join('accounts as ac', 'accountsgroups.id', '=', 'ac.accountsgroup')
        ->select('accountsgroups.*', 'ac.name', 'ac.balance')
        ->whereRaw('exists( SELECT * FROM accounts WHERE accountsgroups.id = ac.accountsgroup )')
        ->where('accountsgroups.effecton', 'Profit & Loss Accounts')
        ->where('ac.is_deleted', 1)
        ->where('accountsgroups.sequence', 'left')->get();
        $expenseac_groups = Accountsgroup::join('accounts as ac', 'accountsgroups.id', '=', 'ac.accountsgroup')
        ->select('accountsgroups.*', 'ac.name', 'ac.balance')
        ->whereRaw('exists( SELECT * FROM accounts WHERE accountsgroups.id = accounts.accountsgroup )')
        ->where('accountsgroups.effecton', 'Profit & Loss Accounts')
        ->where('ac.is_deleted', 1)
        ->where('accountsgroups.sequence', 'right')->get();
        return view('views-files.p&l')->with(['incomeac_groups' => $incomeac_groups, 'expenseac_groups' => $expenseac_groups]);
    }
}
