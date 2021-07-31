@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Purchase Return</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Purchase</a></li>
                        <li class="breadcrumb-item active">Add Purchase Return</li>
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
		<div style="border-bottom: 2px solid;padding: 25px;"></div>
		<div style="border-bottom: 2px solid;width: 100%">
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: left;">{{ $purchaseReturn->invoicetype }}</p>
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: center;">TAX INVOICE</p>
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: right;">Original</p>
			<p style="clear: both;margin-bottom: 0rem;"></p>
		</div>
		<div style="display: flex;">
			<div style="width: 65%;border-right: 2px solid;">
				<p>M/S : <b>{{ $purchaseReturn->account_name }}</b></p>
				<p><b>{{ $purchaseReturn->city }} - {{ $purchaseReturn->pincode }}</b></p>
				<p>GST NO : <b>{{ $purchaseReturn->gstno }}</b></p>
				<p style="clear: both;margin-bottom: 0rem;"></p>
			</div>
			<div style="width: 35%;border-bottom: 2px solid;background-color: #f2f2f2;margin-bottom: 40px;">
				<p style="margin-bottom: 0rem;">Bill No : <b>{{ $purchaseReturn->orderid }}</b></p>
				<p style="margin-bottom: 0rem;">Challen Date : {{ date_format(date_create($purchaseReturn->created_at),"d/m/Y") }} </p>
				<p style="margin-bottom: 0rem;">Challen No : <b>{{ $purchaseReturn->challannum }}</b></p>
				<p style="clear: both;margin-bottom: 0rem;"></p>
			</div>
		</div>
		<div style="border-top: 2px solid;width: 100%;">
			<table style="width: 100%;">
				<thead>
					<tr style="text-align:center">
						<th style="border-right: 2px solid;width: 3%;">Sr.</th>
						<th style="border-right: 2px solid;width: 33%;">Product Name</th>
						<th style="border-right: 2px solid;width: 6%;">HSN/SAC</th>
						<th style="border-right: 2px solid;width: 6%;">Design</th>
						<th style="border-right: 2px solid;width: 6%;">QTY</th>
						<th style="border-right: 2px solid;width: 6%;">Rate</th>
						<th style="border-right: 2px solid;width: 6%;">Discount</th>
						<th style="border-right: 2px solid;width: 6%;">Taxable</th>
						<th style="border-right: 2px solid;width: 5%;">GST</th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;width: 13%;" colspan="2">Tax Amount</th>						
						<th style="width: 10%;">Net</th>
					</tr>
					<tr style="text-align:center">
						<th style="border-right: 2px solid;border-bottom: 2px solid;"></th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;"></th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;">COD</th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;">COD</th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;"></th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;"></th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;"></th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;">Amount</th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;">%</th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;">Central</th>
						<th style="border-right: 2px solid;border-bottom: 2px solid;">State/UT</th>
						<th style="border-bottom: 2px solid;">Amount</th>
					</tr>
				</thead>
				<tbody>
						<?php
							$sr = 0;
							$taxableval = 0;
						 ?>
						@foreach ($products as $p)
						<?php    $product = explode("-",$p['product_name']);
								 $taxable = (str_replace(',','',$p['product_price']) - ((str_replace(',','',$p['product_price']) * $p['product_discount'] / 100))) * $p['product_qty'];
							 	 $taxableval += $taxable;
							 ?>
						<tr>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ $sr += 1 }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ $product[0] }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;"></td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ isset($product[1]) ? $product[1] : "" }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ $p['product_qty'] }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ number_format((float)str_replace(',','',$p['product_price']),2) }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ number_format((float)str_replace(',','',$p['product_discount']),2) }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ $taxable }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{  number_format((float)str_replace(',','',$p['product_tax']),2) }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ number_format(str_replace(',','',$p['texttaxa']) / 2,2) }}</td>
							<td style="border-bottom: 2px solid;border-right: 2px solid;">{{ number_format(str_replace(',','',$p['texttaxa']) / 2,2) }}</td>
							<td style="border-bottom: 2px solid;">{{  $p['ammount'] }}</td>
						</tr>
						@endforeach
				</tbody>
			</table>
		</div>
		<div style="border-top: 2px solid;background-color: #f2f2f2;display: flex;width: 100%;">
			<p style="width: 54%;">GSTIN No. : <span> {{ Auth::user()->gstno }}</span></p>
			<p style="width: 6%;">Total</p>
			<p style="width: 6%;">{{ $purchaseReturn->totaldiscount }}</p>
			<p style="width: 11%;">{{ $taxableval }}</p>
			<p style="width: 6.5%;">{{ number_format(str_replace(',','',$purchaseReturn->totaltax) / 2,2) }}</p>
			<p style="width: 6.5%;">{{ number_format(str_replace(',','',$purchaseReturn->totaltax) / 2,2) }}</p>
			<p style="width: 10%;">{{ $purchaseReturn->total }}</p>
		</div>
		<div style="display: flex;">
			<div style="width: 73%;border-top: 2px solid;">
				<p style="margin-bottom: 0rem;">Bank Name : {{ Auth::user()->bankname }}</p>
				<p style="margin-bottom: 0rem;">Bank A/C No. : {{ Auth::user()->acno }}</p>
				<p style="margin-bottom: 0rem;">RTGS/IFSC Code : {{ Auth::user()->ifsc }}</p>
			</div>
			<div style="width: 27%;border-top: 2px solid;border-left: 2px solid;"></div>
		</div>
		<div style="display: flex;">
			<div style="width: 73%;border-top: 2px solid;">
				<p>Total GST : {{ $purchaseReturn->totaltax }}</p>
				<p>Bill Amount : {{ $purchaseReturn->total }}</p>
			</div>
			<div style="width: 27%;border-top: 2px solid;border-left: 2px solid;">
				<div style="display: flex;background-color: #f2f2f2;height: 30px;padding-bottom: 30px;border: 1px solid;" >
					<p style="text-align: left;width: 50%;">Grand Total</p><p style="text-align:left;width: 50%;">{{ $purchaseReturn->total }}</p>
				</div>
				<div>
					Note : {{ $purchaseReturn->notes }}
				</div>
			</div>
		</div>
		<div style="display: flex;">
			<div style="width: 73%;border-top: 2px solid;">
				<h6>Terms & Condition :</h6>
				<ol>
					<li>Goods once sold will not be taken back.</li>
					<li>Interest @18% p.a. will be charged if payment is not made within due date.</li>
					<li>Our risk and responsibility ceases as soon as the goods leave our premises.</li>
					<li>"Subject to 'SURAT' Jurisdiction only. <strong>E.&.O.E</strong>"</li>
				</ol>
			</div>
			<div style="width: 27%;border-top: 2px solid;float: right;padding: 10px;">
				<p style="float: right;">For, {{ strtoupper(Auth::user()->name) }}</p>
				<br>
				<br>
				<br>
				<p style="padding-left: 90px;">(Authorised Signatory)</p>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
	function printDivp(divName){
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents +'<br>'+printContents;

		window.print();

		document.body.innerHTML = originalContents;

	}
</script>
@endsection