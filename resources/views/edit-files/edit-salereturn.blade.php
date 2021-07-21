@extends('layouts.layout')
@section('css')
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.css') }}">
    <script type='text/javascript'>
        accounting.settings = {
            number: {
                precision: 2,
                thousand: ',',
                decimal: '.'
            }
        };
        var two_fixed = 2;
    </script>
    <style type="text/css">
        .row {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: 10px;
            margin-left: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .td {
            padding: 10px;
        }

        label {
            margin-top: 15px;
        }

    </style>
@endsection
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Edit Sale Return</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sale</a></li>
                        <li class="breadcrumb-item active">Edit Sale Return</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-shadow mb-4">
                <form method="post" id="data_form" action="{{ route('salesreturn.update', $SalesReturn->id )}}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
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
                    <div class="row">
                        <div class="col-sm-12 cmp-pnl">
                            <div class="inner-cmp-pnl">
                                <div class="form-row">
                                    <div class="col-sm-6"><label for="orderid" class="caption">Bill No </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                    aria-hidden="true"></span></div>
                                            <input class="form-control" name="orderid" value="{{ $SalesReturn->orderid }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="challanno" class="caption">Challan No </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                    aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" value="{{ $SalesReturn->challannum }}"
                                                placeholder="Challan No #" name="challanno">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label>Order Date To Due Date</label>
                                    <div class="input-daterange input-group" data-date-format="yyyy-mm-dd"
                                        data-date-autoclose="true" data-provide="datepicker">
                                        <input type="text" class="form-control" name="orderdate"
                                            value="{{ $SalesReturn->orderdate }}" autocomplete="off" />
                                        <input type="text" class="form-control" name="orderduedate"
                                            value="{{ $SalesReturn->orderduedate }}" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo" class="caption"> </label>
                                        <textarea class="form-control" name="notes" rows="2"
                                            placeholder="Enter Description For Invoice">{{ $SalesReturn->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.js') }}"></script>
@endsection
