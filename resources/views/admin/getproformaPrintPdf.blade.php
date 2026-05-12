<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
	<title>quickdials-Proforma-Invoice_<?php echo date('d-m-Y H:i:s'); ?></title>
		<link href="<?php echo asset('admin/invoiceprintpdf.css'); ?>" rel="stylesheet">
	</head>
	<body>
		<header>
			<h1 >Proforma Invoice</h1>
			<address >
				<b style="font-size: 18px;">Quick Dials Pvt Ltd</b>
				<p> G-13, Third Floor, Sector-3 Noida, U.P India </p>
				<p>Phone : 120-4271088</p>
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
					<th><span >Date of Proforma Invoice</span></th>
					<td><span ><?php echo date('d-M-Y',strtotime($paymentprint->order_date)); ?></span></td>
				</tr>
				 				 
				 
			</table> 
		</header>
		<hr>		
		<article>					 
			
			
			 <b style="margin-left:8px;font-size: 12px;font-weight: bold;">Details of Receiver (Billed to) </b>
			   <b style="float: right;margin-right: 160px;font-size: 12px;font-weight: bold;">Details of Consignee (Shipped to) </b>
			<table class="receiver">
			
				 <thead>
				 <tr>			 
				<td>	 
				 Name: <b style="font-size: 15px;">&nbsp;&nbsp;  <?php echo ucwords($client->business_name); ?></b>
				<p> Address: <?php echo $client->address; ?>,<?php echo $client->city; ?></p>
				<p>Phone : &nbsp;&nbsp;<?php echo $client->mobile; ?></p>
				<p>Email : &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $client->email; ?></p>
				<!--<p>PAN:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;gggg</p>
				<p>GSTIN:&nbsp;&nbsp;&nbsp;&nbsp;HHHH</p>-->
		 </td>
		   
		 <td>	 
		
				 Name: <b style="font-size: 15px;">&nbsp;&nbsp;  <?php echo ucwords($client->business_name); ?></b>
				<p> Address: <?php echo $client->address; ?> </p>
				<p>Phone : &nbsp;&nbsp;<?php echo $client->mobile; ?></p>
				<p>Email : &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $client->email; ?></p>
			<!--	<p>GSTIN:&nbsp;&nbsp;&nbsp;&nbsp;09AAGFC7730B2ZO</p>-->
		 </td>
				</tr>
				</thead>
				 
			</table>	
			
			
			<hr>
			<table class="inventory">
				<thead>
					<tr>
						<th><span >S.No</span></th>
						<th><span >Package/Lead</span></th>
						<th><span >Duration</span></th>
						<th><span >Rate(Per Package )</span></th>						
						<th><span >Amount</span></th>
						
					</tr>
				</thead>
				<tbody>
					<tr style="height: 104px;">
						<td><span >1</span></td>					 
						<?php if($paymentprint->package_name=='gold'){ ?>
						<td><span >Gold <?php echo '('.$paymentprint->leads_count.' Lead )'; ?></span></td>
						<td><span ><?php  echo date('d-M-Y',strtotime($paymentprint->expired_from));?>  To <?php echo date('d-M-Y',strtotime($paymentprint->expired_on)); ?></span></td>	
						<td><span ><?php echo $paymentprint->paid_amount; ?></span></td>	
				
				<?php }else if($paymentprint->package_name=='diamond'){ ?>
				 
						<td><span >Diamond <?php echo '('.$paymentprint->leads_count.' Lead )'; ?></span></td>
						<td><span ><?php  echo date('d-M-Y',strtotime($paymentprint->expired_from));?>  To <?php echo date('d-M-Y',strtotime($paymentprint->expired_on)); ?></span></td>	
						<td><span ><?php echo $paymentprint->paid_amount; ?></span></td>
				<?php }if($paymentprint->package_name=='platinum'){ ?>
					
					<td><span >Platinum <?php echo '('.$paymentprint->leads_count.' Lead )'; ?></span></td>
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
				<td>Mode of Payment</td>				 
				<td>Date</td>				
				<td>GST</td>
				<td>TDS</td>
				<td>Total Amount</td>
			
				 
				
				</tr>
				<tr>		
				<td>NA </td>				 		
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
			<h1><span ><b style="font-weight: 700;">Regd. Office:</b> Delhi,Pin  (UP), India.</span></h1>
			<div class="thank" style="text-align:center">
				Thank You ! 
				 
			</div>
		</aside>
	</body>
</html>