@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Bank</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Transactions</a></li>
                        <li class="breadcrumb-item active">Add Bank</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add New Bank Transaction</h4>

                    <form class="form-horizontal" action="{{ route('add-files.addaccount') }}" method="POST">
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::get('fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('fail') }}
                            </div>
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="fromac">Bank Account</label>
                                    <select id="fromac" name="fromac" class="form-control">
                                        @if (!empty($fromaccounts))
                                            @foreach ($fromaccounts as $fac)
                                                <option value='{{ $fac->id }}'>{{ $fac->name }} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="RcptPymt">Rcpt/Pymt</label>
                                    <select name="RcptPymt" id="RcptPymt" class="form-control">
                                        <option value='Receipt'>Receipt</option>
                                        <option value='Payment'>Payment </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="accountsgroup">Opp. A/c.</label>
                                    <select id="accountsgroup" name="accountsgroup" class="form-control">
                                        @if (!empty($toaccounts))
                                            @foreach ($toaccounts as $tac)
                                                <option value='{{ $tac->id }}'>{{ $tac->name }} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="effecton">Effect On</label>
                                    <select id="effecton" name="effecton" class="form-control">
                                        <option value='' hidden>Effect On </option>
                                        <option value='Balance Sheet'>Balance Sheet</option>
                                        <option value='Profit & Loss Accounts'>Profit & Loss Accounts </option>
                                        <option value='Trading Accounts'>Trading Accounts </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <label>
                            <h4><u>Party Details</u></h4>
                        </label>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" name="area" placeholder="Enter Area">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter City">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" class="form-control" id="pincode" name="pincode"
                                        placeholder="Enter Pincode">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        placeholder="Enter State">
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="panno">PAN NO.</label>
                                    <input type="text" class="form-control" id="panno" name="panno"
                                        placeholder="Enter PAN NO">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="aadharno">Aadhar No.</label>
                                    <input type="text" class="form-control" id="aadharno" name="aadharno"
                                        placeholder="Enter Aadhar No">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="gstno">GSTIN NO.</label>
                                    <input type="text" class="form-control" id="gstno" name="gstno"
                                        placeholder="Enter GSTIN NO">
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <label>
                            <h4><u>Balance Details</u></h4>
                        </label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="balance">Opening Balance</label>
                                    <input type="text" class="form-control" id="balance" name="balance"
                                        placeholder="Enter Opening Balance">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="actype">Account Type</label>
                                    <select id="actype" name="actype" class="form-control">
                                        <option value='Credit'>Credit </option>
                                        <option value='Debit'>Debit</option>
                                        <option value='Asset'>Asset</option>
                                        <option value='Liability'>Liability</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
