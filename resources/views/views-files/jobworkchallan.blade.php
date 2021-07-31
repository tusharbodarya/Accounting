@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Purchase Challan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Purchase</a></li>
                        <li class="breadcrumb-item active">Add Purchase Challan</li>
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
	<div style="border: 3px solid;margin: 50px; background-color: #fff;" >
		<div style="text-align: center;border-bottom: 2px solid;background-color: #f2f2f2;width: 100%;">
			<p style="font-size: xx-large;padding-top: 0px;margin-top: 0px;margin-bottom: 0px;padding-bottom: 0px;">{{ strtoupper(Auth::user()->name) }}</p>
		</div>
		<div style="border-bottom: 2px solid;width: 100%">
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: left;">{{ $jobworkchallan->invoicetype }}</p>
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: center;">TAX INVOICE</p>
			<p style="float: left;width: 33.33%;margin-bottom: 0rem;text-align: right;" >Original</p>
			<p style="clear: both;margin-bottom: 0rem;"></p>
		</div>
		<div style="display: flex;">
			<div style="width: 65%;border-right: 2px solid;">
				<p>M/S :<b> {{ $jobworkchallan->account_name }}</b></p>
				<p><b>{{ $jobworkchallan->city }} - {{ $jobworkchallan->pincode }}</b></p>
				<p>GST NO : <b>{{ $jobworkchallan->gstno }}</b></p>
				<p style="clear: both;margin-bottom: 0rem;"></p>
			</div>
			<div style="width: 35%;border-bottom: 2px solid;background-color: #f2f2f2;margin-bottom: 40px;">
				<p style="margin-bottom: 0rem;">Bill No : <b>{{ $jobworkchallan->orderid }}</b></p>
				<p style="margin-bottom: 0rem;">Challen Date : {{ date_format(date_create($jobworkchallan->created_at),"d/m/Y") }} </p>
				<p style="margin-bottom: 0rem;">Challen No : <b>{{ $jobworkchallan->challannum }}</b></p>
				<p style="clear: both;margin-bottom: 0rem;"></p>
			</div>
		</div>
		<div style="border-top: 2px solid;width: 100%;">
			<table style="width: 100%;margin-bottom: 10%;">
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
			<p style="width: 6%;">{{ $jobworkchallan->totaldiscount }}</p>
			<p style="width: 11%;">{{ $taxableval }}</p>
			<p style="width: 6.5%;">{{ number_format(str_replace(',','',$jobworkchallan->totaltax) / 2,2) }}</p>
			<p style="width: 6.5%;">{{ number_format(str_replace(',','',$jobworkchallan->totaltax) / 2,2) }}</p>
			<p style="width: 10%;">{{ round(str_replace(',','',$jobworkchallan->total)) }}</p>
		</div>
		<div style="display: flex;">
			<table style="width: 73%;border-top: 2px solid;">
				<tr style="border-bottom: 1px solid;">
					<th style="width: 4%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">Type</th>
					<th style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">Niddle 1</th>
					<th style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">Niddle 2</th>
					<th style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">Niddle 3</th>
					<th style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">Niddle 4</th>
					<th style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">Niddle 5</th>
					<th style="width: 16%;margin-bottom: 0rem;text-align: center;" height="40">Niddle 6</th>
				</tr>
				<tr style="border-bottom: 1px solid;">
					<td style="width: 4%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">Sarre</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->saree_niddle1 }}</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->saree_niddle2 }}</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->saree_niddle3 }}</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->saree_niddle4 }}</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->saree_niddle5 }}</td>
					<td style="width: 16%;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->saree_niddle6 }}</td>
				</tr>
				<tr>
					<td style="width: 4%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">Lace</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->lace_niddle1 }}</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->lace_niddle2 }}</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->lace_niddle3 }}</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->lace_niddle4 }}</td>
					<td style="width: 16%;border-right: 1px solid;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->lace_niddle5 }}</td>
					<td style="width: 16%;margin-bottom: 0rem;text-align: center;" height="40">{{ $jobworkchallan->lace_niddle6 }}</td>
				</tr>
			</table>
			<div style="width: 27%;border-top: 2px solid;border-left: 2px solid;">
				<div style="display: flex;background-color: #f2f2f2;height: 35px;padding-bottom: 30px;border-bottom: 1px solid;" >
					<p style="text-align: left;width: 50%;">Grand Total : </p><p style="text-align:left;width: 50%;"><b>{{ round(str_replace(',','',$jobworkchallan->total)) }}</b></p>
				</div>
				<div>
					Note : {{ $jobworkchallan->notes }}
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

		document.body.innerHTML =  printContents +printContents;

		window.print();

		document.body.innerHTML = originalContents;

	}
// 	function printDivp(divName)
// {
//     var mywindow = window.open('', 'PRINT', 'height=400,width=600');

//     mywindow.document.write('<html><head><title>' + document.title  + '</title>');
//     mywindow.document.write('</head><body >');
//     mywindow.document.write('<h1>' + document.title  + '</h1>');
//     mywindow.document.write(document.getElementById(divName).innerHTML);
//     mywindow.document.write('</body></html>');

//     mywindow.document.close(); // necessary for IE >= 10
//     mywindow.focus(); // necessary for IE >= 10*/

//     mywindow.print();
//     mywindow.close();

//     return true;
// }
</script>
@endsection