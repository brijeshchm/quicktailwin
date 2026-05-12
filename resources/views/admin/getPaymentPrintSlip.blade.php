<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Quick Dials-Order_<?php echo date('d-m-Y H:i:s'); ?></title>
		<link rel="stylesheet" href="style.css">
		<link href="<?php echo asset('admin/printstyle.css'); ?>" rel="stylesheet">
	</head>
	<body>
		<header>
			<h1>Quick Dials Order Details </h1>
				 
	
			<section>
			<img src="https://www.quickdials.com/client/images/small-logo.png">
			</section>
			<address>
			
				<b style="font-size: 18px;">Quick Dials Service Pvt Ltd</b>
				<p> Address:Pillar No.33, NH-19, opposite flyover, Faridabad, haryana </p>
				<p>Phone : +91-75-5943-5943</p>
				<p>Email : info@quickdials.com</p>
				<p>Website : www.quickdials.com</p>
				<p>GST No : </p>
				<p>TAN No : </p>
				
			</address>
			</header>
			<aside><h1></h1></aside>
		<article>	 
		<p>Dear <strong><?php echo $paymentuprint->business_name ?>,</strong></p>
		<p style="font-size: 12px;">We are privileged to serve you and we greatly value our relationship! 
The order form with the following details has been successfully created.</p>
		</article>	 
		<article>	 
				 
			<table class="meta">
				<tr>
					<th><span>Order Number</span></th>
					<td><span>#<?php echo $paymentuprint->order_number ?></span></td>
				</tr>
				<tr>
					<th><span >Order Date</span></th>
					<td><span ><?php echo date('d-M-Y',strtotime($paymentuprint->order_date)); ?></span></td>
				</tr> 
				<tr>
					<th><span >Customer Name</span></th>
					<td><span id="prefix"></span><span><?php echo ucfirst($paymentuprint->customer_name) ?></span></td>
				</tr>
				<tr>
					<th><span >Phone</span></th>
					<td><span id="prefix" ></span><span><?php echo $paymentuprint->mobile ?></span></td>
				</tr>	
				<tr>
					<th><span >Business Name </span></th>
					<td><span id="prefix" ></span><span><?php echo ucfirst($paymentuprint->business_name); ?>	</span></td>
				</tr>	
				<tr>
					<th><span >Package Name</span></th>
					<td><span id="prefix" ></span><span><?php echo $paymentuprint->package_name ?></span></td>
				</tr>
				<tr>
					<th><span >Leads</span></th>
					<td><span id="prefix" ></span><span><?php echo $paymentuprint->leads_count ?></span></td>
				</tr>

				
				<?php if($paymentuprint->package_name=='Diamond'){ ?>
				<tr>
					<th><span >Duration</span></th>
					<td><span id="prefix" ></span><span contenteditable><?php  echo date('d-M-Y',strtotime($paymentuprint->expired_from));?>  To <?php echo date('d-M-Y',strtotime($paymentuprint->expired_on)); ?></span></td>
				</tr>				
		 	    <tr>
					<th><span >Total Order Amount</span></th>
					<td><span id="prefix" ></span><span contenteditable><?php echo $paymentuprint->paid_amount ?> INR</span></td>					
				</tr> 
				
				<?php }else if($paymentuprint->package_name=='Gold'){ ?>
				 
				 <tr>
					<th><span >Duration</span></th>
					<td><span id="prefix" ></span><span contenteditable><?php  echo date('d-M-Y',strtotime($paymentuprint->expired_from));?>  To <?php echo date('d-M-Y',strtotime($paymentuprint->expired_on)); ?></span></td>
				</tr>	
				<tr>
					<th><span >Total Order Amount</span></th>
					<td><span id="prefix" ></span><span contenteditable><?php echo $paymentuprint->paid_amount ?> INR</span></td>
					</tr>
				<?php }if($paymentuprint->package_name=='Platinum'){ ?>
				<tr>
					<th><span >Leads</span></th>
					<td><span id="prefix" ></span><span contenteditable><?php  echo date('d-M-Y',strtotime($paymentuprint->expired_from));?>  To <?php echo date('d-M-Y',strtotime($paymentuprint->expired_on)); ?></span></td>
				</tr>
					
				
				<tr>
					<th><span >Total Order Amount</span></th>
					<td><span id="prefix" ></span><span contenteditable> <?php echo $paymentuprint->paid_amount ?> INR</span></td>
					</tr>
				
				<?php } ?>
				 
			</table>
			</article>
			 
			<article>
			<b>Payment Details: </b>
			
			<table class="balance">
							 
				<tr>
					<th><span >Amount Paid</span></th>
					<td><span data-prefix></span><span><?php echo $paymentuprint->paid_amount ?></span></td>
				</tr>
				<tr>
					<th><span >GST</span></th>
					<td><span data-prefix></span><span style="font-weight: 700;"><?php echo $paymentuprint->gst_tax ?></span></td>
				</tr>
				<tr>
					<th><span >TDS</span></th>
					<td><span data-prefix></span><span><?php echo $paymentuprint->tds_amount ?></span></td>
				</tr>
			
				<tr>
					<th><span >Total Amount</span></th>
					<td><span data-prefix></span><span><?php echo $paymentuprint->total_amount ?></span></td>
				</tr>
				
				
			</table>
			
			<table class="amount">
				<tr>	
					<th><span >Mode of payment</span></th>				
					<td style="width:224px"><span><?php echo ucfirst($paymentuprint->payment_mode); ?></span></td>
				</tr>
		 
				<tr>	
					<th><span >Payment Bank</span></th>				
					<td style="width:224px"><span><?php if(!empty($paymentuprint->payment_bank)) {?>
				<?php echo ucfirst($paymentuprint->payment_bank); ?> 
				<?php }else  if(!empty($paymentuprint->chq_card_no)) { ?>
				Cheque No <?php echo $paymentuprint->chq_card_no ?>
				<?php }else  if(!empty($paymentuprint->pay_paytm)) { ?>
				 <?php echo $paymentuprint->pay_paytm ?>
				<?php }else  if(!empty($paymentuprint->pay_neft)) { ?>
				  <?php echo $paymentuprint->pay_neft ?>
				<?php }else  if(!empty($paymentuprint->pay_googlePay)) { ?>
				 <?php echo $paymentuprint->pay_googlePay ?> <?php } ?> 		</span></td>
				</tr>
			 
				
				<?php if(!empty($paymentuprint->chq_card_no)) {?>
				<tr>	
					<th><span >Cheque No</span></th>				
					<td style="width:224px"><span><?php echo $paymentuprint->chq_card_no ?></span></td>
				</tr>
				<?php } ?>
				<tr>	
					<th><span >Amount in Words</span></th>				
					<td style="width:224px"><span><?php echo $paymentuprint->paid_amt_in_words ?></span></td>
				</tr>
 
				 <?php if(!empty($paymentuprint->transactionid)){ ?>
				<tr>	
					<th><span >TransactionId</span></th>				
					<td style="width:224px"><span>#<?php echo $paymentuprint->transactionid ?></span></td>
				</tr>
				 <?php } ?>
				 <?php if($paymentuprint->proofid){ ?>
				<tr>	
					<th><span >ID Proof</span></th>				
					<td style="width:224px"><span><?php echo $paymentuprint->selectproofid ?>(<?php echo $paymentuprint->proofid ?>)</span></td>
				</tr>
 
				 <?php } ?>
 
				 
				
				
			</table>
			 
			 
			 
		</article>
		 
		
		
		<article>
		<b>Listing Details: </b>
		<table class="inventory">
				<thead>
					<tr>
						<!-- <th><span >City</span></th> -->
						<th><span >Category</span></th>
						<!-- <th><span >Subcategory</span></th> -->
						<th><span >Keyword</span></th>						 
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($assignKeyword)){ 																			
					foreach($assignKeyword as $keyword){

					?>
					<tr>
					<!-- <td><?php echo $keyword->city;  ?></td> -->
					<td><?php echo $keyword->parent_category; ?></td>
					<!-- <td><?php echo $keyword->child_category; ?></td> -->
					<td><?php echo $keyword->keyword; ?></td>
					</tr>
					<?php } } ?>

					  
					 
				</tbody>
			</table>
			
		</article>
			<article>
		<strong>Note:</strong><p style="margin: -15px 0px 0px 52px;font-size: 12px;margin-bottom:4px;">You can check your balance value and the pending lead details while login your quickdials.com.</p>		
		<p style="font-size: 12px;margin-bottom:6px;">Apart from this No verbal and written commitment will not consider.</p>
		<p style="font-size: 12px;margin-bottom:6px;">This contract (which term includes this order form and terms expressly referred to herein) represent the entire agreement between the concerned parties and shall prevail over, exclude and supersede any other terms or conditions, oral or written.</p>
		<p style="font-size: 12px;margin-bottom:6px;">Your Advertisement will be activated within 3 days of the payment clearance,</p>
		<p style="font-size: 12px;margin-bottom:6px;">Should you have any queries, please contact us on our email to <a style="color: #005DFF;" href="https://www.quickdials.com/contact-us" target="_blank">help@quickdials.com.</a></p>
		
		<p style="font-size: 12px;margin-bottom:6px;">This is an advertisement contract and the applicable rate of TDS is @ 2% only under section 194C. Kindly deduct TDS on the net amount only (Contract /Package value) excluding Tax portion.</p>
		<p style="font-size: 12px;margin-bottom:6px;">Timings: Monday to Sunday: 24/7.</p>
		<p style="font-size: 12px;margin-bottom:6px;">Please click below to refer the terms and conditions.</p>		
		</article>
		<article>
		<strong><a href="https://www.quickdials.com/privacy-policy" target="_blank">Terms & Condition :</a></strong>
		<p style="font-size: 12px;margin-bottom:6px;">Looking forward to a long and fruitful association with you!</p>
		<p style="font-size: 12px;margin-bottom:6px;">Sincerely, </p>
		<strong>Team Quick Dials Service Pvt. Ltd.</strong>
		<p style="font-size: 12px;margin-top:4px;">Regd Office: UNIT 101 OXFORD TOWERS, 139/88 HAL OLD AIRPORT RD, H.A.L II Stage, Bangalore North, Bangalore- 560008, Karnataka.</p>
			</article>
		<aside>
			<h1><span></span></h1>
			<div class="thank" style="text-align:center">
				Thank You ! 
				 
			</div>
		</aside>
		<br>
		<br>
		<br>
		<br>
		<br>
		 
	</body>
</html>