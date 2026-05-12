<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
	<title>quickdials-Invoice_<?php echo date('d-m-Y H:i:s'); ?></title>
		<link href="<?php echo asset('admin/invoiceprintpdf.css'); ?>" rel="stylesheet">
	</head>
	<body>
		<header>
			<h1 >E-Invoice</h1>
			<address >
				<b style="font-size: 18px;">Quick Dials Pvt Ltd</b>
				<p> G-13, Sector-3 Noida, U.P India </p>
				<p>Phone : 120-49999</p>
				<p>Email : info@quickdials.com</p>
				<p>Website : www.quickdials.com</p>
				<img src="https://www.quickdials.com/client/images/small-logo.png">
			</address>
			<table class="meta">
				<tr>
					<th><span >GSTIN</span></th>
					<td><strong>09AAECL0574H1ZG</strong></td>
				</tr>
				<tr>
					<th><span >PAN No</span></th>
					<td><strong >AABCQ2259D</strong></td>
				</tr>			 
				<tr>
					<th><span >TAN</span></th>
					<td><strong >BLRQ01951F</strong></td>
				</tr>			 
				<tr>
					<th><span >CIN No</span></th>
					<td><strong >U63112KA2026PTC215594</strong></td>
				</tr>		 
				<tr>
					<th><span >Date of Invoice</span></th>
					<td><span ><?php echo date('d-M-Y',strtotime($paymentprint->order_date)); ?></span></td>
				</tr>
				 				 
				 
			</table> 
		</header>
		<hr>		
		<article>					 
			
			
			 <b style="margin-left:8px;font-size: 12px;font-weight: bold;">Details of Receiver </b>
			   <b style="float: right;margin-right: 160px;font-size: 12px;font-weight: bold;">Address </b>
			<table class="receiver">
			
				 <thead>
				 <tr>			 
				<td>	 
				Business Name: <b style="font-size: 15px;">&nbsp;&nbsp;  <?php echo ucwords($client->business_name); ?></b>				 
				<p>Phone : &nbsp;&nbsp;{{ $client->mobile ?? 'N/A' }}</p>
				<p>Email : &nbsp;&nbsp;&nbsp;&nbsp;{{ $client->email ?? 'N/A' }}</p>
				<p>PAN:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $client->pan_no ?? 'N/A' }}</p>
				<p>GST:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $client->gst_no ?? 'N/A' }}</p>
		 </td> 

		 	<td>	 
				<p>Name  : &nbsp;&nbsp;&nbsp;{{$client->sirName??''}}. {{$client->first_name??''}} &nbsp;{{ $client->last_name??''}}</p>
				<p> Address: {{$client->address??'N/A'}} </p>		 
				<p>GSTIN:&nbsp;&nbsp;&nbsp;&nbsp;{{ $client->gst_no ?? 'N/A' }}</p>
			</td>
				</tr>
				</thead>
				 
			</table>	
			
			
			<hr>
			<table class="inventory">
				<thead>
					<tr>
						<th><span >S.No</span></th>
						<th><span >Package</span></th>
						<th><span >Duration</span></th>
						<th><span >Rate(Per Package )</span></th>						
						<th><span >Amount</span></th>
						
					</tr>
				</thead>
				<tbody>
					<tr style="height: 104px;">
						<td><span >1</span></td>					 
						<?php if($paymentprint->package_name=='Gold'){ ?>
						<td><span >Gold</span></td>
						<td><span ><?php  echo date('d-M-Y',strtotime($paymentprint->expired_from));?>  To <?php echo date('d-M-Y',strtotime($paymentprint->expired_on)); ?></span></td>	
						<td><span ><?php echo $paymentprint->paid_amount; ?></span></td>	
				
				<?php }else if($paymentprint->package_name=='Diamond'){ ?>
				 
						<td><span >Diamond</span></td>
						<td><span ><?php  echo date('d-M-Y',strtotime($paymentprint->expired_from));?>  To <?php echo date('d-M-Y',strtotime($paymentprint->expired_on)); ?></span></td>	
						<td><span ><?php echo $paymentprint->paid_amount; ?></span></td>
				<?php }if($paymentprint->package_name=='Platinum'){ ?>
					
					<td><span >Platinum</span></td>
						<td><span ><?php  echo date('d-M-Y',strtotime($paymentprint->expired_from));?>  To <?php echo date('d-M-Y',strtotime($paymentprint->expired_on)); ?></span></td>	
						<td><span ><?php echo $paymentprint->paid_amount; ?></span></td>
				
				<?php } ?>
						
					<td><?php echo $paymentprint->paid_amount; ?></td>	 
					</tr>
					<tr>
					<td colspan="3"></td>
					<td><span >GST</span></td>
					<td><span><?php echo $paymentprint->gst_tax?> INR</span></td>
					</tr>
					<tr>
					<td colspan="3"></td>
					<td><span >TDS</span></td>
					<td><span><?php echo $paymentprint->tds_amount?> INR</span></td>
					</tr>
				<tr>
					<td colspan="3"></td>
					<td><span >Total Amount</span></td>
					<td><span><?php echo $paymentprint->total_amount; ?> INR</span></td>
				</tr>
				
				<tr  style="height: 50px;">
					<td colspan="2" style="text-align:left;padding: 15px;">Total Invoice Value (In figure)<br>
					Invoice Value (In Words)
					</td>
					<td colspan="3" style="text-align:left;padding: 15px;"><b style="font-size: 12px;font-weight: bold;">Rs.<?php echo $paymentprint->total_amount; ?> INR</b><br>
					
					<b style="font-size: 12px;font-weight: bold;">Amt in Words:</b><?php echo $paymentprint->paid_amt_in_words; ?> 
					</td>
					 
				</tr>

				<tr><td colspan="5" style="text-align:left;margin-left:8px;font-size: 12px;font-weight: bold;">Payment Details ( Cheque )</td></tr>
				<tr>
				
				<td>Mode of Payment</td><td>Date</td><td>GST</td><td>TDS</td><td>Total Amount</td></tr>
				<tr style="height: 60px;">		
				<td><?php echo ucfirst($paymentprint->payment_mode); ?>/<?php if(!empty($paymentprint->payment_bank)) {?>
				<?php echo ucfirst($paymentprint->payment_bank); ?> 
				<?php }else  if(!empty($paymentprint->chq_card_no)) { ?>
				Cheque No <?php echo $paymentprint->chq_card_no ?>  
				<?php }else  if(!empty($paymentprint->pay_paytm)) { ?>
				 <?php echo $paymentprint->pay_paytm ?>  
				<?php }else  if(!empty($paymentprint->pay_neft)) { ?>
				  <?php echo $paymentprint->pay_neft ?>  
				<?php }else  if(!empty($paymentprint->pay_googlePay)) { ?>
				 <?php echo $paymentprint->pay_googlePay ?> <?php } ?> 				
				</td>				
				<td><?php echo date('d M-Y',strtotime($paymentprint->created_at)); ?></td>			
				<td><?php echo $paymentprint->gst_tax; ?> INR</td>	
				<td><?php echo $paymentprint->tds_amount; ?> INR</td>	
				<td><?php echo $paymentprint->total_amount; ?> INR</td>
				 
				
				</tr>
				
				
				</tbody>
			</table>
			
			
			 
			
			<table class="amount">
				 
				<tr>
				 
					<td style="padding-top: 30px;"><span><b style="font-size: 12px;font-weight: bold;">Note:</b> This is a system generated invoice and hence no signature is required</span></td>
					<td class="td-amount" ><span>Autherised Signature</span></td>
				</tr>
				 
				
				
			</table>
			 
			 
			 
		</article>
		<aside>
			<h1><span ><b style="font-weight: 700;">Regd. Office:</b>G-13, Sector-3, Noida,Pin Code-201301 (UP), India.</span></h1>
			<div class="thank" style="text-align:center">
				Thank You ! 
				 
			</div>
		</aside>
	</body>
</html>