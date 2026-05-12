<!DOCTYPE html>
 
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>pay_<?php echo $paydetails->name.'_'.date_format(date_create(),"d-m-Y H:i:s"); ?></title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">   
  <link href="{{asset('public/printdata/invoiceslips.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<!-- Container -->
<div class="container-fluid invoice-container">
  <!-- Header -->
  <header style="padding: 32px 0 1px;">
    <div class="container">
      <div class="row align-items-center padding-invoice-em-top">
        <div class="col-sm-4 text-sm-left mb-3 mb-sm-0">
          <img id="logo" src="https://www.quickdials.com/client/images/small-logo.jpg" title="Quick Dials" alt="Quick Dials Logo" width="250" />
        </div>
        <div class="col-sm-8 text-sm-left">
          <div class="header-info-section">
            <div class="header-info">
              <div class="header-info-icon">
                <img src="{{asset('public/printdata/location.svg')}}">
              </div>
              <div class="header-info-address">
                <p>G-13, Sector 3, Noida, Uttar Pradesh 201301</p>
              </div>
            </div>
          </div>
          <div class="header-info-section" style="display:-webkit-box;" >
            <div class="header-info">
              <div class="header-info-icon">
                <img src="{{asset('public/printdata/phone.svg')}}">
              </div>
              <div class="header-info-address">
                <p>+91-120-23444333</p>
              </div>
            </div>
            <div class="header-info" style="width: 167px;margin-left:0px;">
              <div class="header-info-icon">
                <img src="{{asset('public/printdata/mobile.svg')}}">
              </div>
              <div class="header-info-address">
                <p>+91-2334444</p>
              </div>
            </div>
            <div class="header-info">
              <div class="header-info-icon">
                <img src="{{asset('public/printdata/Message.svg')}}">
              </div>
              <div class="header-info-address">
                <p>team-accounts@quickdials.com</p>
              </div>
            </div>
            <div class="header-info" style="margin-left:0px;">
              <div class="header-info-icon">
                <img src="{{asset('public/printdata/web.svg')}}">
              </div>
              <div class="header-info-address">
                <p>www.quickdials.com</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  
  <!-- Main Content -->
  <main>
    <div class="container-fluid title-invoice student-invoice border-bottom">
      <div class="row padding-invoice-em" style="margin-top: 0px;">
        <div class="col-lg-12 pd-none">
          <h3>Pay Amount
          </h3>
        </div>

      </div>
    </div>
 <div class="container-fluid title-invoice em-invoice" >
    <div class="Container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-table st-invoice-table padding-invoice padding-invoice-em-body">
            <table id="tablestudents">
             <tbody>
			  <tr style="background-color:#f4f5f7;color:#003453;">    
                <td colspan="3" style="font-size:14px  !important; font-weight:600 !important; border-right: 2px solid #9b9b9b !important;">Order ID : <span class="stcss"><?php if(!empty($paydetails->order_id)){ echo $paydetails->order_id; } ?></span></td>			
                <td colspan="3" style="font-size:14px  !important;font-weight:600 !important;">Name : <span class="stcss"><?php if(!empty($paydetails->name)){ echo ucwords($paydetails->name); } ?></span></td> 
              </tr>
              <tr style="background-color:#ddd;color:#003453;">
			   <td colspan="3" style="font-size:14px  !important;font-weight:600 !important;border-right: 2px solid #9b9b9b !important;">Mobile : <span class="stcss"><?php if(!empty($paydetails->phone)){ echo $paydetails->phone; } ?></span></td>    
			   <td colspan="3" style="font-size:14px  !important;font-weight:600 !important;">Email : <span class="stcss"><?php if(!empty($paydetails->email)){ echo $paydetails->email; } ?></span></td> 
			  
              </tr>
                    <tr style="background-color:#f4f5f7;color:#003453;">
					 <td colspan="3" style="font-size:14px  !important;font-weight:600 !important;border-right: 2px solid #9b9b9b !important;">Amount : <span class="stcss"><?php
						if( $paydetails->merchant_amount ){ echo ucfirst($paydetails->merchant_amount); }
						?></span>  </td>
						<td colspan="3" style="font-size:14px  !important; font-weight:600 !important;">Course : <span class="stcss"><?php if(!empty($paydetails->course)){ echo $paydetails->course; } ?></span></td>
				    </tr>
                    <tr style="background-color:#ddd;color:#003453;">
                     	<td colspan="3" style="font-size:14px  !important; font-weight:600 !important;border-right: 2px solid #9b9b9b !important;">Country : <span class="stcss"><?php if($paydetails->billing_country){ echo ucfirst($paydetails->billing_country); }   ?></span></td>   
                     	<td colspan="3" style="font-size:14px  !important;font-weight:600 !important;">Payment id : <span class="stcss"><?php
						if( $paydetails->razorpay_payment_id ){ echo ucfirst($paydetails->razorpay_payment_id); }
						?></span></td>
		            </tr>  
						  
						<tr style="background-color:#f4f5f7;color:#003453;">
						<td colspan="3" style="font-size:14px  !important;font-weight:600 !important;border-right: 2px solid #9b9b9b !important; ">Date : <span class="stcss"><?php if(!empty($paydetails->created_at)){ echo date_format(date_create($paydetails->created_at), "d-M-Y"); } ?></span></td>
						
					
							<td colspan="3" style="font-size:14px  !important;font-weight:600 !important;">Address : <span class="stcss"><?php if(!empty($paydetails->city)){ echo ucfirst($paydetails->city).', '.ucfirst($paydetails->billing_state).', '.ucfirst($paydetails->billing_country); }  ?></span></td>				
						</tr>
						
						
				  
			   
			  
			  
			  </tbody>
			
			</table><hr>

 
          </div>
        </div>
      </div>
    </div>
  </div>
    </div>

  
  
   
  
  </main>
  <!-- Footer -->
  <footer class="text-center mt-2">
    <div class="btn-group btn-group-sm d-print-none" style="margin-bottom: 44px;color:#fff"> <a href="javascript::void(0);" onclick="window.print();" class="btn btn-primary border shadow-none" style="color:#fff"><i class="fa fa-print"></i> Save</a>   </div>
    </footer>
 

  </footer>

</div>
</body>
</html>