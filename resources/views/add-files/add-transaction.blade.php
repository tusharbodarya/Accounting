@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Transaction</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Transaction</a></li>
                        <li class="breadcrumb-item active">Add Transaction</li>
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
                    <h4 class="card-title mb-4">Add New Transaction</h4>

                    <form class="form-horizontal" action="{{ route('fetch-transaction') }}" method="POST">
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
                        <div class="row table-info">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="accountype">Name</label>
                                    <select name="accountype" class="selectpicker form-control"
                                        onchange="findaccounts(this.value)">
                                        <option value="cash">Cash</option>
                                        <option value="bank">Bank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name">Select C/o</label>
                                    <input list="accountid" class="form-control"  name="accountid" onchange="getaccounts(this.value)" id="fromaccount" autocomplete="off">
                                        <datalist id="accountid">
                                        </datalist>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="RcptPymt">Rcpt/Pymt</label>
                                    <select name="RcptPymt" id="RcptPymt" class="form-control">
                                        <option value='Receipt'>Receipt</option>
                                        <option value='Payment'>Payment </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row table-info">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="company_name">C/o</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('ammount') }}"
                                        autocomplete="off"><span class="text-danger">@error('company_name'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="toaccount">To Account</label>
                                    <select id="toaccount" name="toaccount" class="form-control">
                                        <option value="{{ old('toaccount') }}" hidden>Under </option>
                                        @if (!empty($accounts))
                                                @foreach ($accounts as $ac)
                                                    <option value='{{ $ac->id }}'>{{ $ac->name }} </option>
                                                @endforeach
                                            @endif
                                    </select>
                                        <span class="text-danger">@error('toaccount'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="ammount">Amount</label>
                                    <input type="text" class="form-control" id="ammount" name="ammount" value="{{ old('ammount') }}" autocomplete="off">
                                     <span class="text-danger">@error('ammount'){{ $message }}@enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row table-info">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Auto Close</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="dd-mm-yyyy"
                                            data-date-format="dd-mm-yyyy" data-provide="datepicker"
                                            data-date-autoclose="true" name="date">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="income_type">Type</label>
                                    <select name="income_type" id="income_type" class="form-control">
                                        <option value='CREDIT'>INCOME/CREDIT</option>
                                        <option value='DEBIT'>EXPENSE/DEBIT </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="income_method">Method</label>
                                    <select name="income_method" id="income_method" class="form-control">
                                        <option value='CASH'>CASH</option>
                                        <option value='CARD'>CARD </option>
                                        <option value='CHEQUE'>CHEQUE </option>
                                        <option value='BANK'>BANK </option>
                                        <option value='OTHER'>OTHER </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row table-info">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <input type="text" class="form-control" id="note" name="note" placeholder="Enter Notes">
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div>
                            <button type="submit" class="btn btn-info w-md">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
@endsection
@section('script')
    <script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            findaccounts('cash');
        });

        function findaccounts(name) {
            var accountstype = name;
            console.log(accountstype);
            $.ajax({
                url: "/fetch-transactionac",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    accountstype: accountstype,
                },
                cache: false,
                success: function(result) {
                    console.log(result);
                    var accounts = "";
                    $.each(result, function(index, value) {
                        accounts +=  "<option value=" + value.id + ">"+value.name+"</option>";
                    });
                    $("#accountid").html(accounts);
                }
            });
        }

   function getaccounts(id){
     var acid  = id;
            $.ajax({
                url: "/fetch-transactionacdetails",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    acid: acid
                },
                cache: false,
                success: function(result) {
                    $("#company_name").val(result.name);
                }
            });
       }
    </script>
@endsection
