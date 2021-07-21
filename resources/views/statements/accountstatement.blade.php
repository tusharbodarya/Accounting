@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Accounts Statement</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Accounts</a></li>
                        <li class="breadcrumb-item active">Add Accounts Statement</li>
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
                    <h4 class="card-title mb-4">Add New Account Statement</h4>

                    <form class="form-horizontal" action="{{ route('add-files.addacgroup') }}" method="POST">
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

                        @csrf

                        <div class="form-group">
                            <label for="account_id">Account Name</label>
                            <select name="account_id" id="account_id" class="form-control">
                                <option value=''>Select Acccounts</option>
                                <option value='All_accounts'>All-Acccounts</option>
                                <option value='Payment'>Payment </option>
                            </select>
                            <span class="text-danger">@error('account_id'){{ $message }}@enderror</span>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="RcptPymt">Rcpt/Pymt</label>
                                    <select name="RcptPymt" id="RcptPymt" class="form-control">
                                        <option value="">Select Rcpt/Pymt</option>
                                        <option value="All_transactions">All-Transactions</option>
                                        <option value='Receipt'>Receipt</option>
                                        <option value='Payment'>Payment </option>
                                    </select>
                                    <span class="text-danger">@error('RcptPymt'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Order Date To Due Date</label>
                                        <div class="input-daterange input-group" data-date-format="yyyy-mm-dd"
                                            data-date-autoclose="true" data-provide="datepicker">
                                            <input type="text" class="form-control" name="orderdate" autocomplete="off" />
                                            <input type="text" class="form-control" name="orderduedate" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div>
                                    <button type="submit" class="btn btn-primary w-md">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
        @section('css')
            <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
                type="text/css">
            <link rel="stylesheet" href="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.css') }}">
        @endsection
        @section('script')
            <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
            <script src="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.js') }}"></script>
        @endsection
