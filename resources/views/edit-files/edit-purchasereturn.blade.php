@extends('layouts.layout')
@section('css')
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.css') }}">
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/accounting.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                <h4 class="mb-0 font-size-18">Add Purchase Invoice</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Purchase</a></li>
                        <li class="breadcrumb-item active">Add Purchase Invoice</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('content')
    <span id="hdata" data-df="dd-mm-yyyy" data-curr="$"></span>
    <div class="row">
        <div class="col-xl-12">
            <div class="card card-shadow mb-4">
                <form method="post" id="data_form" action="{{ route('purchasereturn.update', $PurchaseReturn->id) }}">
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
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <h3 class="title">
                                            Bill To
                                            <a href='add-accounts.php' class="btn btn-primary">Add Account</a>
                                        </h3>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <select name="accountype" class="selectpicker form-control"
                                        onchange="findaccounts(this.value)">
                                        <option value="" hidden>Select Account Type</option>
                                        <option value="cash">Cash</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </div>
                                <hr>
                                <div class="form-row">
                                        <select id="accountid" name="accountid" class="selectpicker form-control">
                                            <option value='{{ $PurchaseReturn->accountid }}' hidden>{{ $PurchaseReturn->account_name }}</option>
                                        </select>
                                    </div>
                                <div id="supplier">
                                    <div class="clientinfo">
                                        Account Details
                                        <hr>
                                        <input type="hidden" name="supplier_id" id="supplier_id" value="0">
                                        <div id="accounter_name">
                                            NAME : {{ $PurchaseReturn->account_name }}
                                            <br>
                                            Balance : {{ $PurchaseReturn->balance }}
                                        </div>
                                    </div>
                                    <hr>Product Group
                                    <select id="productgroup" name="productgroup" class="selectpicker form-control">
                                        <option value='' hidden>Select Product Group</option>
                                        @foreach ($Categories as $Category)
                                            <option value='{{ $Category->id }}'>{{ $Category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">
                                <div class="form-row">
                                    <div class="col-sm-6"><label for="orderid" class="caption">Bill No </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                    aria-hidden="true"></span></div>
                                            <input class="form-control" name="orderid" value="{{ $PurchaseReturn->orderid }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="challanno" class="caption">Challan No </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                    aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" value="{{ $PurchaseReturn->challannum }}" placeholder="Challan No #" name="challanno">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label>Order Date To Due Date</label>
                                        <div class="input-daterange input-group" data-date-format="yyyy-mm-dd"
                                            data-date-autoclose="true" data-provide="datepicker">
                                            <input type="text" class="form-control" name="orderdate" autocomplete="off" value="{{ $PurchaseReturn->orderdate }}" />
                                            <input type="text" class="form-control" name="orderduedate" autocomplete="off" value="{{ $PurchaseReturn->orderduedate }}"/>
                                        </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-6">
                                        <label for="taxformat" class="caption">Tax </label>
                                        <select class="form-control round" onchange="changeTaxFormat(this.value)"
                                            name="taxformat" id="taxformat">

                                            <option value="gst" data-tformat="cgst">CGST + SGST</option>
                                            <option value="igst" data-tformat="igst">IGST</option>
                                            <option value="other">other</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="discountFormat" class="caption"> Discount</label>
                                            <select class="form-control" onchange="changeDiscountFormat(this.value)"
                                                name="discountFormat" id="discountFormat">
                                                <option value="b_p"> % Discount Before TAX</option>
                                                <option value="bflat">Flat Discount Before TAX</option>
                                                <option value="%"> % Discount After TAX</option>
                                                <option value="flat">Flat Discount After TAX</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <label for="toAddInfo" class="caption"> </label>
                                        <textarea class="form-control" name="notes" rows="2" placeholder="Enter Description For Invoice">{{ $PurchaseReturn->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">
                            <thead>
                                <tr class="item_header bg-primary white">
                                    <th width="30%" class="text-center">Item Name</th>
                                    <th width="8%" class="text-center"> Quantity</th>
                                    <th width="10%" class="text-center">Rate</th>
                                    <th width="10%" class="text-center">Tax(%)</th>
                                    <th width="10%" class="text-center">Tax</th>
                                    <th width="7%" class="text-center"> Discount</th>
                                    <th width="10%" class="text-center">Amount($)</th>
                                    <th width="5%" class="text-center"> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $cval = 0; ?>
                                @foreach ($products as $p)
                                <?php $cval += 1; ?>
                                <tr class="table-active">
                                    <td class="td">
                                        <select id="products" name="product_name[]" onchange="getproduct(this.value, {{ $cval - 1 }})" class="selectpicker product_name form-control">
                                            <option value="{{ $p['product_name'] }}" hidden>{{ $p['product_name'] }}</option>
                                        </select>
                                    </td>
                                    <td class="td">
                                        <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-{{ $cval - 1 }}"
                                            onkeypress="return isNumber(event)" onkeyup="rowTotal('{{ $cval - 1 }}'), billUpyog()"
                                            autocomplete="off" value="{{ $p['product_qty'] }}">
                                    </td>
                                    <td class="td">
                                        <input type="text" class="form-control req prc" name="product_price[]" id="price-{{ $cval - 1 }}"
                                            onkeypress="return isNumber(event)" onkeyup="rowTotal('{{ $cval - 1 }}'), billUpyog()"
                                            autocomplete="off" value="{{ $p['product_price'] }}">
                                    </td>
                                    <td class="td">
                                        <input type="text" class="form-control vat " name="product_tax[]" id="vat-{{ $cval - 1 }}"
                                            onkeypress="return isNumber(event)" onkeyup="rowTotal('{{ $cval - 1 }}'), billUpyog()"
                                            autocomplete="off" value="{{ $p['product_tax'] }}">
                                    </td>
                                    <td class="td"><input name="texttaxa[]" class="text-center form-control"
                                            id="texttaxa-{{ $cval - 1 }}" readonly value="{{ $p['texttaxa'] }}">
                                    </td>
                                    <td class="td">
                                        <input type="text" class="form-control discount" name="product_discount[]"
                                            onkeypress="return isNumber(event)" id="discount-{{ $cval - 1 }}"
                                            onkeyup="rowTotal('{{ $cval - 1 }}'), billUpyog()" autocomplete="off" value="{{ $p['product_discount'] }}">
                                    </td>
                                    <td class="td">
                                        <strong><input class='form-control ttlText' id="result-{{ $cval - 1 }}" name="ammount[]" value="{{ $p['ammount'] }}"
                                                readonly></strong>
                                    </td>
                                    <td class="td" class="text-center"><button type="button" data-rowid="" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                                    <input type="hidden" name="taxa[]" id="taxa-{{ $cval - 1 }}" value="{{ $cval - 1 }}">
                                    <input type="hidden" name="disca[]" id="disca-{{ $cval - 1 }}" value="{{ $cval - 1 }}">
                                    <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-{{ $cval - 1 }}" value="{{ $cval - 1 }}">
                                    <input type="hidden" class="pdIn" name="pid[]" id="pid-{{ $cval - 1 }}" value="{{ $cval - 1 }}">
                                    <input type="hidden" name="unit[]" id="unit-{{ $cval - 1 }}" value="">
                                    <input type="hidden" name="hsn[]" id="hsn-{{ $cval - 1 }}" value="">
                                </tr>
                                @endforeach
                                <tr class="last-item-row">
                                    <td class="add-row row">
                                        <button type="button" class="btn btn-primary" id="addproduct">
                                            <i class="fa fa-plus-square"></i> Add Row </button>
                                    </td>
                                    <td colspan="7"></td>
                                </tr>
                                <tr style="display: table-row;">
                                    <td class="td" colspan="6" align="right"><input type="hidden" value="0" id="subttlform"
                                            name="subtotal"><strong> Total Tax(<span
                                                class="currenty lightMode">$</span>)</strong>
                                    </td>
                                    <td class="td" align="left" colspan="2">
                                        <input id="taxr" name='totaltax' class="form-control" value="0" readonly>
                                    </td>
                                </tr>
                                <tr style="display: table-row;">
                                    <td class="td" colspan="6" align="right">
                                        <strong> Total Discount(<span class="currenty lightMode">$</span>)</strong>
                                    </td>
                                    <td class="td" align="left" colspan="2">
                                        <input id="discs" name="totaldiscount" value="0" class="form-control" readonly>
                                    </td>
                                </tr>
                                <tr style="display: table-row;">
                                    <td class="td" colspan="6" align="right">
                                        <strong> Grand Total(<span class="currenty lightMode">$</span>)</strong>
                                    </td>
                                    <td class="td" align="left" colspan="2"><input type="text" name="total"
                                            class="form-control" id="invoiceyoghtml" readonly="">
                                    </td>
                                </tr>
                                <tr style="display: table-row;">
                                    <td style="padding-left: 78%;"><input type="submit" class="btn btn-primary sub-btn"
                                            value="Generate Order" id="submit-data" data-loading-text="Creating...">
                                    </td>
                                    <td style="padding-left: 58%;">
                                        <a href="/purchasereturn" class="btn btn-danger">Cancel</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" value="stockreturn/action" id="action-url">
                    <input type="hidden" value="0" name="person_type">
                    <input type="hidden" value="puchase_search" id="billtype">
                    <input type="hidden" value="{{ $cval - 1 }}" name="counter" id="ganak">
                    <input type="hidden" value="$" name="currency">
                    <input type="hidden" value="%" name="tax_format" id="tax_format">
                    <input type="hidden" value="yes" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="%" name="discount_Format" id="discount_format">
                    <input type="hidden" value="10.00" name="shipRate" id="ship_rate">
                    <input type="hidden" value="incl" name="ship_taxtype" id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 44 || charCode > 57)) {
                return false;
            }
            return true;
        }

        var dtformat = $('#hdata').attr('data-df');
        var currency = $('#hdata').attr('data-curr');
    </script>
    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/%40chenfengyuan/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/invoice.js') }}"></script>
    <script src="{{ asset('assets/js/invoice1.js') }}"></script>
@endsection
