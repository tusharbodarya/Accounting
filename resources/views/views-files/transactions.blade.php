@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Transaction</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Accounts</a></li>
                        <li class="breadcrumb-item active">View Transaction</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
<div style="padding-left: 50px;">
	<button class="button" onclick="printDivp('pdf')">PRINT</button>
</div>
<div id="pdf">
	<div style="border: 3px solid;margin: 50px; background-color: white;" >
		<div style="text-align: center;border-bottom: 2px solid;background-color: #f2f2f2;width: 100%;">
			<p style="font-size: xx-large;padding-top: 0px;margin-top: 0px;margin-bottom: 0px;padding-bottom: 0px;">{{ strtoupper(Auth::user()->name) }}</p>
		</div>
		<div style="text-align: center;border-bottom: 2px solid;padding: 5px;">
            <p style="font-size: small;padding-top: 0px;margin-top: 0px;margin-bottom: 0px;padding-bottom: 0px;">Near Jalaram Steel,Kapodra,Surat,Gujarat.</p>
            <p style="font-size: small;padding-top: 0px;margin-top: 0px;margin-bottom: 0px;padding-bottom: 0px;">Mobile : 9898100804</p>
        </div>
        <div style="border-bottom: 2px solid;width: 100%;padding: 5px;">
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: left;">Vou. No. :</p>
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: center;">Bank Receipt</p>
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: right;">Date : 21/10/2017</p>
			<p style="clear: both;margin-bottom: 0rem;"></p>
		</div>
		<div style="border-bottom: 2px solid;padding: 5px;">
            <p style="font-size: inherit;font-weight: bolder;margin-top: 15px;">Received with thanks from M/s.  {{ $transaction->fromname }}, {{ $transaction->fromcity }}</p>
            <p style="font-size: inherit;font-weight: bolder;margin-top: 15px;">The sum of Rupees Ninety Two Thousand Two Hundred Ninety Six Only</p>
            <p style="font-size: inherit;font-weight: bolder;margin-top: 15px;">Rupees : {{ $transaction->ammount }} /-</p>
            <p style="font-size: inherit;font-weight: bolder;margin-top: 15px;"><span>Cheque/D.D.No.:229845</span><span style="padding-left: 20%;"> Dated :21/10/2017</span></p>
            <p style="font-size: inherit;font-weight: bolder;margin-top: 15px;">Drawn on : {{ $transaction->toname }}</p>
            <p style="font-size: inherit;font-weight: bolder;margin-top: 15px;"><span>Against advance / full / part payment of our Bill No</span><span style="padding-left: 20%;"> Dt :</span></p>
        </div>
		<div style="border-top: 2px solid;width: 100%;padding-bottom: 15%;">
			{{-- <?php
             echo '<pre>';
                print_r($transaction);
                die;
                 ?> --}}
		</div>
        <div style="padding: 15px;">
            <span style="font-size: smaller;">This receipt is valid subject to realization of cheque</span>
            <span style="font-size: smaller;margin-left: 50%;">(Authorised Signatory)</span>
        </div>
	</div>
</div>
@endsection
@section('script')
<script>
	function printDivp(divName){
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;

	}
</script>
@endsection