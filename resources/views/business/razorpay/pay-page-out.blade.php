 @extends('business.layouts.app')
@section('title')
 
@endsection 
@section('keyword')
 
@endsection
@section('description')
 
@endsection
@section('content')
	<div class="main">
 	
<style type="text/css">
.payment-trans-button{margin-top: 35px;padding: 0px 10px;text-align: start;display: flex;justify-content: space-between;flex-wrap: wrap;}
.payment-edit-button{border: none;background-color: transparent;font-size: 15px;font-weight: 500;color: #1A73E8;}
.payment-cancel-button {border: none;padding: 6px 45px;font-size: 14px;height: 40px;border-radius: 4px;margin-left: 325px;border: 1px solid #053554;background-color: #fff;}
.payment-proceed-button{border: none;padding: 7px 45px;font-size: 14px;height: 40px;background:linear-gradient(45deg,#3876F1,#1C19B0);color: #fff;text-transform: uppercase;border-radius: 4px;}
.payment-process-new {margin: 0;display: grid;
    grid-template-columns: auto auto auto auto auto;padding: 17px 50px !important;background-color:#E6EEFF;text-align:center;}
.payment-button4:focus,.payment-proceed-button:focus{box-shadow: none;}
.tab-content #payment-student-Detail ,.tab-content #transaction{padding: 30px 90px;}
.tab1-list .nav-item1.active .text-payment{color:#1B1464;}
.barcode-blur img{width:68%;}
.arrow-top-line{  position: relative;
}
.arrow-top-line2,.arrow-top-line3{  position: relative;
}
.arrow-top-line:before{
  position: absolute;
  top: -10px;
  left:50%;
  margin-left: -10px;
  content:"";
  display:block;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-bottom: 10px solid #297AEC; 
}
.arrow-top-line2:before{
  position: absolute;
  top: -10px;
  left:50%;
  margin-left: -10px;
  content:"";
  display:block;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-bottom: 10px solid #036293; 
}
.arrow-top-line3:before{
  position: absolute;
  top: -10px;
  left:50%;
  margin-left: -10px;
  content:"";
  display:block;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-bottom: 10px solid #6639B6; 
}

.uplaod{background-color: #fff;
    border: 1px solid #b2b2b26e;
    box-shadow: 0 3px 6px #00000017;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 500;
    width: 60%;
    margin: auto;
    margin-top: 9px;
    color: #042D6E;
    /* display: block; */
    /* width: auto; */
    padding: 6px;}
    .copy-popup-model .modal-body
    {padding: 10px;
    background-color: #000000;
    color: #fff;}
    .copy-popup-model .modal-body h6{
        margin-bottom: 0px;}
    i.fa.fa-cloud-upload{margin-right:7px;}
.tab-content #payment{padding: 30px 0px 0px;}
.gopayment-width {
    width: 40%;
}
#payment nav img{max-width: 80%;}
.copy-clip-new span a{color:#000;}
.googlepayment-barcode-new {background-color: #DBEBFF;text-align:center;border-radius: 10px;position: relative;box-shadow: 0 3px 6px #00000017;    padding: 20px 0px 95px;
}
a.new-payment-type:before {content: "";position:absolute;bottom: -17px;left: 20%;display:inline-block;width: 60%;border-bottom: #D2CFCF solid 4px;}
a.google-pay-active.active:before{border-bottom: #297AEC solid 4px;}
a.paytm-pay-active.active:before{	border-bottom: #036293 solid 4px;}
a.phonepe-pay-active.active:before{border-bottom: #6639B6 solid 4px;}
a.upi-pay-active.active:before{border-bottom: #E9661C solid 4px;}
a.new-payment-type {position: relative;}
.copy-clip-new{border-radius: 5px;display: flex;justify-content: space-between;box-sizing: content-box;align-items: center;	padding: 7px 15px;font-size: 14px;background-color: #fff;margin: 20px auto;box-shadow: 0 3px 6px #00000017;}
.copy-clip-new span{font-weight: 500;}
.payment-upi-id-details p{font-size: 15px;font-weight: 500;margin-top: 15px;margin-bottom:4px;}
.payment-upi-id-details span{font-size: 14px;font-weight: 400;}
.dorp-scan-doc-new{position: absolute;text-align:center;left:0;right:0;bottom: -57px;width: 60%;margin: 25px auto 0;box-shadow: 0 3px 6px #00000017;background-color: #fff;border-radius: 5px;padding: 10px;}
.upload-copy-icon-new h4{color: #042D6E;font-size: 18px;font-weight: 600;margin-top: 10px;margin-bottom: 0px;}
.upload-copy-icon-new p{font-size: 10px !important;font-weight: 400;color: #A2A2A2;}
.upload-file-new{position: relative;}
.upload-file-new button{width: 115px;padding: 7px;outline: none;margin: 10px;background-color: #fff;border: 1px solid #b2b2b26e;box-shadow: 0 3px 6px #00000017;border-radius: 7px;font-size: 14px;font-weight: 500;color: #042D6E;}
.payment-method-tech-new-padding{padding-bottom: 130px;}
.googlepayment-barcode-new .img-logo{width: 100%;height: 77px;    line-height: 77px;}
.line-right-pay.active:after{content: '';width: 144px;border-bottom: solid 2px !important;background-image: linear-gradient(to right,#1B1464,#006FBA);    position: absolute;left: -144px;top: 50%;z-index: 1;}
@media only screen and (max-width: 767px) {
    .dorp-scan-doc-new{    width: 75% !important;
}
    .googlepayment-barcode-new{padding: 20px 0px 95px;}
    span.select2.select2-container.select2-container--bootstrap{width:100% !important;}
    .gopayment-width{width:100%;}
.payment-trans-button button{width: 100%;margin-top: 20px;}
.form-row.form-avd-first-box {display: flex;flex-wrap: nowrap;}
.payment-cancel-button{margin-left: 12px;}
.payment-edit-button,.payment-cancel-button{margin-top: 15px;}
.student-payment-new {padding: 20px 20px;border-top: 5px solid #134F8B;}
#payment nav img {max-width: 90%;}
.payment-process-new {margin: 0;text-align: inherit;display: flex;padding: 17px 12px !important;background-color: #E6EEFF;flex-wrap: nowrap;}
.tab1-list {margin-top: 0px !important;}
.tab-content #payment-student-Detail, .tab-content #transaction{padding: 0px;}
.consular-fee-deposit {padding: 45px 0px !important;}
.my-mr-5 {margin-right: 25px !important;}
.line-right-pay.active:after {content: '';width: 48px;position: absolute;left: -47px;top: 50%;z-index: 1;}
.line-right-pay:after {content: '';width: 23px !important;border-bottom: solid 2px!important;border-color: #e9e9e9!important;position: absolute!important;left: -24px!important;top: 50%!important;z-index: 1!important;color: #000;
}
}
.consular-fee-deposit{padding: 0px 0px 45px;}
.student-payment-new p {font-size: 14px;}
.tab1-list{box-shadow: rgb(0 0 0 / 25%) 0px 10px 30px;border-radius: 5px;margin-top: -122px;}
.student-payment-new{border-top: 5px solid;border-left-width: 0;border-right-width: 0;border-image: linear-gradient(to right, #1B1464, #006FBA) 1 stretch;background-color: #fff;}
.nav.paymentonline-form {display: flex;justify-content: center;padding: 24px 0px 45px;background-color: #fff;}
.student-payment-new h3{font-size: 18px;margin-bottom: 1px;font-weight: 600;text-transform: uppercase;}
.text-payment{font-size: 14px;font-weight: 400 !important;line-height: 20px;width: 109px;display: flex;margin-left: -26px;
	margin-top: 8px;justify-content: center;color: #707070;}
.pay-responsive-img {width: 60%;}
.nav-item1{background-color: #E9E9E9;border-radius: 50%;width: 52px;color: #000 !important;height: 52px;font-size: 14px;line-height: 52px;text-align: center;}
.tab1-list .nav-item1.active {background-image: linear-gradient(to right,#1B1464,#006FBA);border-radius: 50%;width: 52px;      color: #000 !important;height: 52px;font-size: 14px;line-height: 52px;text-align: center;}
.details-tab {display: flex;align-items: center;flex-direction: column;}
.tab-content .form-row .form-group{display: flex;}
.payment-button4{margin: auto;display: block;width: 100%;height: 40px;margin-top: 15px;border: none;font-size: 14px;    background: linear-gradient(45deg,#3876F1,#1C19B0);border-radius: 4px;}
.payment-button4 a{	color: #fff !important;}
.payment-form-avd {transition: border linear .2s,box-shadow linear .2s;-webkit-border-radius: 0;-moz-border-radius: 0;vertical-align: middle;width: 100%;height: auto;padding: 6px 15px;border-radius: 4px;background-color: #E9E9E9;font-weight: 400;text-transform: inherit;border: 1px solid rgba(0, 43, 92, 0.08);font-size: 14px;outline: none;line-height: inherit;letter-spacing: 0px;}
.payment-form-avd:focus{border-color: #134f8b !important;color: #495057;outline: 0;box-shadow: none;}
.my-mr-5{margin-right: 9rem;}
.country-code-selected{margin-right: 15px;background-color: #E9E9E9;transition: border linear .2s,box-shadow linear .2s;
	    -webkit-border-radius: 0;-moz-border-radius: 0;border-radius: 0;vertical-align: middle;width: 175px;color: #6e696a;
	    height: auto;padding: 6px 15px;border-radius: 0;background-color: #E9E9E9;font-weight: 400;text-transform: inherit;
	    border: 1px solid rgba(0, 43, 92, 0.08);font-size: 14px;outline: none;	    line-height: inherit;
	    letter-spacing: 0px;}
.line-right-pay{position: relative;}
.line-right-pay:after {    content: '';width: 144px;border-bottom: solid 2px;border-color: #e9e9e9;    position: absolute;
    left: -144px;top: 50%;z-index: 1;}
.title-pay-order td:first-child{padding: 7px 27px;}
.title-pay-order td:last-child{padding: 7px 40px;}
.pay-order td:first-child{background-color: #D2CFCF;padding: 7px 22px;border-top-left-radius: 24px;border-bottom-left-radius: 24px;font-weight: 600;width: 22%;font-size: 15px;}
.pay-order td:last-child{background-color: #E9E9E9;border-top-right-radius: 24px;border-bottom-right-radius: 24px;padding: 7px 40px;font-weight: 300;font-size: 15px;}
.pay-order{border: 12px solid #fff;}
.transaction-section-payment table {text-align: initial;}
.help-block {display: block;margin-top: 0px;color: #ff0000;font-size: 12px;position: absolute;top: 38px;left: 78px;}
.drop-zone__input {
       opacity: 0;
    position: absolute;
    display: block;
    flex-wrap: wrap;
    overflow: hidden;
    width: 100%;
    padding:4px;
    cursor:pointer;
}
    }
.gopayment-width{text-align: center;}
			</style>	
	<script>
		window.onload = function() {
			var d = new Date().getTime();
			document.getElementById("tid").value = d;
			var o = "CC_"+Math.floor((Math.random() * 1000) + 1)+"_"+d;
			document.getElementById("merchant_order_id").value = o;
		//	document.getElementById("feesGooglePayorder").value = o;
		//	document.getElementById("feesPhonePayorder").value = o;
			document.getElementById("feesPayTmorder").value = o;
			//document.getElementById("feesUPIorder").value = o;	
			 
		};
	</script>
	<section class="consular-tp-banner">
	<img loading="lazy" src="{{asset('public/img/pay/consular-banner.png')}}" alt="consular-banner" class="img-fluid">
	</section>
				
				
	<section class="consular-fee-deposit">
	<div class="container">
	<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
	<div class="tab1-list">
		<nav>
		<div class="nav paymentonline-form" role="tablist">
		
		<a class="nav-item1 my-mr-5 active disabled" data-toggle="tab" href="#payment-student-Detail" role="tab"
		aria-controls="nav-home" aria-selected="false"><img loading="lazy" src="{{asset('public/img/pay/baseline-person.png')}}" alt="person" class="img-fluid pay-responsive-img"><span class="text-payment">Details</span></a>
		
		<a class="nav-item1 my-mr-5 line-right-pay active disabled" data-toggle="tab" href="#transaction" role="tab"
		aria-controls="nav-profile" aria-selected="false"><img loading="lazy" src="{{asset('public/img/pay/verified-user.png')}}" alt="verify" class="img-fluid pay-responsive-img "><div class="text-payment">Verify Details </div></a>
		
		<a class="nav-item1  line-right-pay active" data-toggle="tab" href="#payment" role="tab"
		aria-controls="nav-contact" aria-selected="true"><img loading="lazy" src="{{asset('public/img/pay/wallet.png')}}" alt="wallet" class="img-fluid pay-responsive-img"><div class="text-payment">Payment</div></a>

		</div>
		</nav>
	<div class="tab-content student-payment-new">
	 
	 
	<div class="tab-pane fade show active" id="payment" role="tabpanel" aria-labelledby="payment">
	
	<nav>
	<div class="nav payment-process-new" role="tablist">
	<?php //echo  "<pre>";print_r($paymentMode);die;
	if(!empty($paymentMode)){
		foreach($paymentMode as $mode){
			if($mode->mode=='GooglePay'){
	?>
	<a class="nav-item-payment-type new-payment-type google-pay-active active" data-toggle="tab" href="#GooglePay" role="tab"
	aria-controls="nav-profile" aria-selected="false">
	
	<img loading="lazy" src="{{asset('public/img/pay/google-payment.png')}}" alt="google" class="img-fluid">
	
	</a>
			<?php }else if($mode->mode=='PayTm'){ ?>
 
<a class="nav-item-payment-type new-payment-type paytm-pay-active" data-toggle="tab" href="#PayTm" role="tab"
	aria-controls="nav-about" aria-selected="false">
	<img loading="lazy" src="{{asset('public/img/pay/paytm-payment.png')}}" alt="paytm" class="img-fluid">
	</a>


			<?php }else if($mode->mode=='PhonePay'){ ?>
<a class="nav-item-payment-type new-payment-type phonepe-pay-active" data-toggle="tab" href="#PhonePay" role="tab"
	aria-controls="nav-contact" aria-selected="false"><img loading="lazy" src="{{asset('/public/img/pay/phonepay-payment.png')}}" alt="phonepay" class="img-fluid"></a>
		<?php 	}else if($mode->mode=='UPI'){ ?>
<a class="nav-item-payment-type new-payment-type phonepe-pay-active" data-toggle="tab" href="#UPI" role="tab"
	aria-controls="nav-contact" aria-selected="false"><img loading="lazy" src="{{asset('/public/img/pay/upi-payment.png')}}" alt="upi" class="img-fluid"></a>
	<?php  } } } ?>
	
	  
	
<form name="razorpay_frm_payment" class="razorpay-frm-payment" id="razorpay-frm-payment" method="post">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />

<input type="hidden" name="tid" id="tid" readonly />
<input type="hidden" name="merchant_order_id" id="merchant_order_id"> 
<input type="hidden" name="language" value="EN"> 
<input type="hidden" name="currency" id="currency" value="INR"> 
<input type="hidden" name="surl" id="surl" value="https://www.quickdials.com/success/"> 
<input type="hidden" name="furl" id="furl" value="https://www.quickdials.com/failed/"> 
<!--<input type="hidden" name="surl" id="surl" value="http://localhost:8000/success/"> 
<input type="hidden" name="furl" id="furl" value="http://localhost:8000/failed/">  -->

<input type="hidden" class="form-control" id="amount" name="amount" placeholder="amount" value="<?php echo $data->amt; ?>" readonly="readonly">
<input type="hidden" name="billing_name" class="form-control" id="billing-name" value="<?php echo $data->name; ?>" Placeholder="Name" required> 
<input type="hidden" name="billing_email"class="form-control" id="billing-email" value="<?php echo $data->email; ?>" Placeholder="Email" required>
<input type="hidden" name="billing_phone" class="form-control" id="billing-phone" value="<?php echo $data->phone; ?>" Placeholder="Phone" required>  

<input type="hidden" name="course" class="form-control" id="course" value="<?php echo $data->course; ?>" Placeholder="Course">  
<input type="hidden" name="billing_country" class="form-control" id="billing_country" value="<?php echo $data->country; ?>" Placeholder="Country">
<input type="hidden" name="billing_state" class="form-control" id="billing_state" value="<?php echo $data->state; ?>" Placeholder="State"> 

<input type="hidden" name="city" class="form-control" id="city" value="<?php echo $data->city; ?>" >
<input type="hidden" name="RAZOR_KEY_ID" class="form-control" id="RAZOR_KEY_ID" value="<?php echo RAZOR_KEY_ID; ?>" >
 
 
<!--
<a class="edit-button"  href="{{url('fees-deposit?status=correction&o='.$_GET['o'])}}" >Edit Now</a>
<a class="cancel-button" href="{{url('fees-deposit')}}">Cancel</a> -->

<a type="submit"  class="nav-item-payment-type new-payment-type phonepe-pay-active" id="razor-pay-now" ><img loading="lazy" src="{{asset('/public/img/pay/group450.png')}}" alt="group450" class="img-fluid"></a>

<!--<a href="{{url('airpay')}}">.</a>-->
<!-- <a href="{{url('cromajuspay')}}"><img loading="lazy" src="{{asset('/public/img/pay/group450.png')}}" alt="ss" class="img-fluid"></a> -->
 

</form>


	</div>
	</nav>
	<div class="tab-content">
	<!-- ======= Paytm Section ================= -->
	
	<?php if($paymentMode){
$i=0;
foreach($paymentMode as $payment){	
 $i++;
	?>
	<div class="tab-pane fade show <?php if($i==1){ echo "active"; }?>" id="<?php echo $payment->mode; ?>" role="tabpanel"
	aria-labelledby="<?php echo $payment->mode; ?>">
	<div class="payment-main pt-5 payment-method-tech-new-padding">
	<div class="gopayment-width">
	<div class="googlepayment-barcode-new text-center">
	<div class="img-logo">
	<?php  if($payment->mode=='GooglePay'){ ?>
	<img loading="lazy" src="{{asset('/public/img/pay/google-pay-new-icon.png')}}" class="img-fluid">
	<?php  }else if($payment->mode=='PayTm'){ ?>
	<img loading="lazy" src="{{asset('/public/img/pay/Paytm_logo-new-payment.png')}}" class="img-fluid" style="width: 35%;">
	<?php  }else if($payment->mode=='PhonePay'){ ?>
	<img loading="lazy" src="{{asset('/public/img/pay/PhonePe.png')}}" class="img-fluid">
	
	<?php  }else if($payment->mode=='UPI'){ ?>
	<img loading="lazy" src="{{asset('/public/img/pay/upipay.png')}}" class="img-fluid">
	<?php  } ?>
	</div>

<a style="border-radius: 5px;display: flex;justify-content: space-between;box-sizing: content-box;align-items: center;padding: 7px 15px;width:60%;font-size: 14px;background-color: #fff;margin: 20px auto;color: #000;font-weight: 500;box-shadow: 0 3px 6px #00000017;" href="javascript:void(0);"> <?php  if($payment->name){ echo $payment->name; } ?> <i class="fa fa-clone" style="color: #9f9b9b;
" aria-hidden="true"></i></a>
	
<!-- <a style="border-radius: 5px;display: flex;justify-content: space-between;box-sizing: content-box;align-items: center;padding: 7px 15px;width:60%;font-size: 14px;background-color: #fff;margin: 20px auto;color: #000;font-weight: 500;box-shadow: 0 3px 6px #00000017;" href="javascript:void(0);"  onclick="copyToClipboard('<?php  if(isset($payment->number)){ echo $payment->number; } ?>')"><?php  if($payment->number){ echo $payment->number; } ?> <?php  if($payment->name){ echo '('.$payment->name.')'; } ?> <i class="fa fa-clone" style="color: #9f9b9b;-->
<!--" aria-hidden="true"></i></a>-->
<a style="border-radius: 5px;display: flex;justify-content: space-between;box-sizing: content-box;align-items: center;padding: 7px 15px;width:60%;font-size: 14px;background-color: #fff;margin: 20px auto;color: #000;font-weight: 500;box-shadow: 0 3px 6px #00000017;" href="javascript:void(0);"  onclick="copyToClipboard('<?php  if(isset($payment->number)){ echo $payment->number; } ?>')"><?php  if($payment->number){ echo $payment->number; } ?> <i class="fa fa-clone" style="color: #9f9b9b;
" aria-hidden="true"></i></a>
	

	 


	<div class="barcode-blur">
	
	<?php $qrfile = unserialize($payment->qrfile); 
	if(!empty($qrfile)){
	?>
	<img loading="lazy" src="{{asset('public/'.$qrfile['qrfile']['src'])}}" alt="copy-icon" class="img-fluid">
	<?php  }else{ ?>
	<div class="arrow-top-line" style="background-color: #297AEC;color:#fff;padding: 10px 35px;font-size: 14px;margin-bottom: 15px;">QR Code Not Avoilable kindly use Mobile Number for payment</div>
	 <img loading="lazy" src="{{asset('public/img/pay/BARCODE.png')}}" alt="copy-icon" class="img-fluid">
	 <?php  } ?>
	</div>
	
	<div class="payment-upi-id-details mt-3">
	 <p>UPI ID: <?php  if($payment->upi){ echo $payment->upi; } ?></p> 
	<span>Please Upload Payment Screenshot.</span>
	</div>
	
    <form enctype="multipart/form-data"  method="post" id="Pay<?php echo $payment->mode; ?>" data-pid="Pay<?php echo $payment->mode ?>">
	<div class="dorp-scan-doc-new">
	<div class="upload-copy-icon-new">
	<img loading="lazy" src="{{asset('public/img/pay/file-payment-ses.png')}}" alt="upload-copy" class="img-fluid">
	<h4>Proof of Payment</h4>

	<p>Upload your Screenshot.</p>
	<a href="javascript:void(0);" id="getfees<?php echo $payment->mode; ?>Image">
	<div class="upload-file-new">	
	<input type="hidden" name="mobile" value="<?php  if($payment->number){ echo $payment->number; } ?>" >
	<input type="hidden" name="to_be_pay" value="<?php  if($payment->name){ echo $payment->name; }else{  echo $payment->name; } ?>" >
	<input type="hidden" name="o" value="<?php echo $_GET['o']; ?>" > 
	<input type="hidden" name="mode" value="<?php echo $payment->mode; ?>" >
	<input type="hidden" name="order_id"  id="fees<?php echo $payment->mode; ?>order"   >	
	<input type="file" name="photoimg" class="drop-zone__input" accept="image/png, image/jpeg,.pdf" /><div class="uplaod"><i class="fa fa-cloud-upload" aria-hidden="true"></i><span>Upload</span></div>	 
	<span class="loadview"></span>
	</div></a>
	</div>
	</div>
	</form>
	
	</div>
	</div>
	</div>
	</div>
	
	<?php   } } ?>

	<!--<div class="tab-pane fade" id="paytm-payment" role="tabpanel" aria-labelledby="paytm-payment">
	<div class="payment-main pt-5 payment-method-tech-new-padding">
	<div class="gopayment-width">
	<div class="googlepayment-barcode-new">
	<div class="img-logo">
	<img loading="lazy" src="{{asset('public/img/pay/Paytm_logo-new-payment.png')}}" class="img-fluid" style="width: 35%;
	">
	</div>
	<a style="border-radius: 5px;display: flex;justify-content: space-between;box-sizing: content-box;align-items: center;padding: 7px 15px;width:60%;font-size: 14px;background-color: #fff;margin: 20px auto;color: #000;font-weight: 500;box-shadow: 0 3px 6px #00000017;" href="javascript:void(0);"  onclick="copyToClipboard('<?php // if($paymentMode->number){ echo $paymentMode->number; } ?>')"><?php  //if($paymentMode->number){ echo $paymentMode->number; } ?> <i class="fa fa-clone" aria-hidden="true" style="color: #9f9b9b;
"></i></a>

	
	


	<div class="barcode-blur">
	
	<?php  
	if(!empty($paytm_qrfile)){
	?>
	<img loading="lazy" src="{{asset('public/'.$paytm_qrfile['qrfile']['src'])}}" alt="copy-icon" class="img-fluid">
	<?php  } else{ ?>
	 <div class="arrow-top-line2" style="background-color: #036293;color:#fff;padding: 10px 35px;font-size: 14px;margin-bottom: 15px;">QR Code Not Avoilable kindly use Mobile Number for payment</div>
	 <img loading="lazy" src="{{asset('public/img/pay/BARCODE.png')}}"  alt="copy-icon" class="img-fluid">
	 <?php  } ?>
	</div>
	<div class="payment-upi-id-details mt-3"> 
	<span>Please Upload Payment Screenshot.</span>
	</div>
	<form enctype="multipart/form-data"  method="post" id="feesPayTmPay" data-pid="feesPayTmPay">
	<div class="dorp-scan-doc-new">
	<div class="upload-copy-icon-new">
	<img loading="lazy" src="{{asset('public/img/pay/file-payment-ses.png')}}" alt="upload-copy" class="img-fluid">
	<h4>Proof of Payment</h4>

	<p>Upload your Screenshot.</p>
	<a href="javascript:void(0);" id="getfeesPayTmImage">
	<div class="upload-file-new">	
	<input type="hidden" name="mobile" value="<?php // if($paymentMode->number){ echo $paymentMode->number; } ?>" >
	<input type="hidden" name="to_be_pay" value="<?php // if($paymentMode->name){ echo $paymentMode->name; }else{  echo $paymentMode->name; } ?>" >
	<input type="hidden" name="o" value="<?php echo $_GET['o']; ?>" > 
	<input type="hidden" name="mode" value="Paytm" >
	<input type="hidden" name="order_id" id="feesPayTmPayorder"   >
	
	<input type="file" name="photoimg" class="drop-zone__input" accept="image/png, image/jpeg,.pdf" /><div class="uplaod"><i class="fa fa-cloud-upload" aria-hidden="true"></i><span>Upload</span></div>
	 
	<span class="loadview"></span>
	 
 
	</div></a>
	</div>
	</div>
	</form>
	
	</div>
	</div>
	</div>
	</div>


	<div class="tab-pane fade" id="phonepe" role="tabpanel" aria-labelledby="phonepe">
	<div class="payment-main pt-5 payment-method-tech-new-padding">
	<div class="gopayment-width">
	<div class="googlepayment-barcode-new">
	<div class="img-logo">
	<img loading="lazy" src="{{asset('public/img/pay/PhonePe.png')}}" class="img-fluid">
	</div>
<a href="javascript:void(0);"  style="border-radius: 5px;display: flex;justify-content: space-between;box-sizing: content-box;align-items: center;padding: 7px 15px;width:60%;font-size: 14px;background-color: #fff;margin: 20px auto;color: #000;font-weight: 500;box-shadow: 0 3px 6px #00000017;" onclick="copyToClipboard('<?php  //if($paymentMode->number){ echo $paymentMode->number; } ?>')"><?php // if($paymentMode->number){ echo $paymentMode->number; } ?> <i class="fa fa-clone" style="color: #9f9b9b;" aria-hidden="true"></i></a> 
	 


	<div class="barcode-blur">
	<?php  
	if(!empty($phonePay_qrfile)){
	?>
	<img loading="lazy" src="{{asset('public/'.$phonePay_qrfile['qrfile']['src'])}}" alt="copy-icon" class="img-fluid">
	<?php  }else{ ?>
	<div class="arrow-top-line3" style="background-color: #6639B6;color:#fff;padding: 10px 35px;font-size: 14px;margin-bottom: 15px;">QR Code Not Avoilable kindly use Mobile Number for payment</div>
	 <img loading="lazy" src="{{asset('public/img/pay/BARCODE.png')}}"  alt="copy-icon" class="img-fluid">
	<?php  } ?>
	</div>
	<div class="payment-upi-id-details mt-3">
	 
	<span>Please Upload Payment Screenshot.</span>

	</div>
	
	<form enctype="multipart/form-data"  method="post" id="feesPhonePay" data-pid="feesPhonePay">
	<div class="dorp-scan-doc-new">
	<div class="upload-copy-icon-new">
	<img loading="lazy" src="{{asset('public/img/pay/file-payment-ses.png')}}" alt="upload-copy" class="img-fluid">
	<h4>Proof of Payment</h4>

	<p>Upload your Screenshot.</p>
	<a href="javascript:void(0);" id="getfeesPhonePayImage">
	<div class="upload-file-new">	
	<input type="hidden" name="mobile" value="<?php // if($paymentMode->number){ echo $paymentMode->number; } ?>" >
	<input type="hidden" name="to_be_pay" value="<?php  //if($paymentMode->name){ echo $paymentMode->name; }else{  echo $paymentMode->name; } ?>" >
	<input type="hidden" name="o" value="<?php echo $_GET['o']; ?>" > 
	<input type="hidden" name="mode" value="PhonePay" >
	<input type="hidden" name="order_id" id="feesPhonePayorder"   >
	
	<input type="file" name="photoimg" class="drop-zone__input" accept="image/png, image/jpeg,.pdf" /><div class="uplaod"><i class="fa fa-cloud-upload" aria-hidden="true"></i><span>Upload</span></div>
	 
	<span class="loadview"></span>
	 
 
	</div></a>
	</div>
	</div>
	</form>
	</div>
	</div>
	</div>
	</div>
	
	
	
<div class="tab-pane fade" id="upipe" role="tabpanel" aria-labelledby="upipe">
	<div class="payment-main pt-5 payment-method-tech-new-padding">
	<div class="gopayment-width">
	<div class="googlepayment-barcode-new">
	<div class="img-logo">
	<img loading="lazy" src="{{asset('public/img/pay/upipay.png')}}" class="img-fluid">
	</div>
<a href="javascript:void(0);"  style="border-radius: 5px;display: flex;justify-content: space-between;box-sizing: content-box;align-items: center;padding: 7px 15px;width:60%;font-size: 14px;background-color: #fff;margin: 20px auto;color: #000;font-weight: 500;box-shadow: 0 3px 6px #00000017;" onclick="copyToClipboard('<?php //  if($paymentMode->upi){ echo $paymentMode->upi; } ?>')"><?php // if($paymentMode->upi){ echo $paymentMode->upi; } ?> <i class="fa fa-clone" style="color: #9f9b9b;" aria-hidden="true"></i></a> 
	 


	<div class="barcode-blur">
 
	</div>
	<div class="payment-upi-id-details mt-3">
	 
	<span>Please Upload Payment Screenshot.</span>

	</div>
	
	<form enctype="multipart/form-data"  method="post" id="feesUPIPay" data-pid="feesUPIPay">
	<div class="dorp-scan-doc-new">
	<div class="upload-copy-icon-new">
	<img loading="lazy" src="{{asset('public/img/pay/file-payment-ses.png')}}" alt="upload-copy" class="img-fluid">
	<h4>Proof of Payment</h4>

	<p>Upload your Screenshot.</p>
	<a href="javascript:void(0);" id="getfeesUPIPayImage">
	<div class="upload-file-new">	
	<input type="hidden" name="mobile" value="<?php  //if($paymentMode->upi){ echo $paymentMode->upi; } ?>" name="mobile">
	<input type="hidden" name="to_be_pay" value="<?php  //if($paymentMode->UPI_emp){ echo $paymentMode->UPI_emp; }else{  echo $paymentMode->UPI_trainer; } ?>" >
	<input type="hidden" name="o" value="<?php echo $_GET['o']; ?>" > 
	<input type="hidden" name="mode" value="UPI" >
	<input type="hidden" name="order_id" id="feesUPIPayorder"   >
	<input type="file" name="photoimg" class="drop-zone__input" accept="image/png, image/jpeg,.pdf" /><div class="uplaod"><i class="fa fa-cloud-upload" aria-hidden="true"></i><span>Upload</span></div>
	<span class="loadview"></span>
	</div></a>
	</div>
	</div>
	</form>
	</div>
	</div>
	</div>
	</div>-->
	
	</div>
	</div>
	<div class="tab-pane fade" id="confirmation" role="tabpanel" aria-labelledby="confirmation">
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</section>
	</div>
	
	<div id="success" class="modal fade" role="dialog">						

		<div class="modal-dialog" style="max-width: 200px !important;margin: 15.75rem auto;">

		<div class="modal-content copy-popup-model">					 

		<div class="modal-body">

		<p style="font-size:12px">Mobile Number Copied</p>				 

		</div>

		</div>

		</div>

		</div>
		
		<!--<a href="{{url('airpay')}}">Airpay</a>-->
	
	<script>


 function copyToClipboard(element) {   

 

        var $temp = $("<input>");

        $("body").append($temp);

        $temp.val(element).select();

        document.execCommand("copy");

        $temp.remove();

      

        $("#success").modal();

        setTimeout(function(){        

        $('#success').modal("hide");

            

        }, 1000);        

    

        } 

</script>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

							 @endsection