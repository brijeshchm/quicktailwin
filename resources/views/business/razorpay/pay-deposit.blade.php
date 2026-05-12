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
.payment-process-new {margin: 0;display: flex;justify-content: space-around;padding: 17px 166px !important;background-color:#E6EEFF;text-align:center;}
.payment-button4:focus,.payment-proceed-button:focus{box-shadow: none;}
.tab1-list .nav-item1.active .text-payment{color:#1B1464;}

.tab-content #payment-student-Detail ,.tab-content #transaction{padding: 30px 90px;}
.pincode-css{width:152px;}
span.select2.select2-container.select2-container--default{width:100% !important;}
.state-css{width:140px;}
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
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
transition: background-color 5000s ease-in-out 0s;
-webkit-text-fill-color: #495057 !important;
}
span.select2-selection.select2-selection--single.country-code.choosecode.country-code-selected,.select2-container--default .select2-selection--single {
     padding: 6px 15px;
    display: block;
    border-radius: 4px;
    background-color: #E9E9E9;
    font-weight: 400;
    text-transform: inherit;
    border: 1px solid rgba(0, 43, 92, 0.08);
    font-size: 14px;
    outline: none;
    line-height: inherit;
    letter-spacing: 0px;
}
::placeholder {
 color: #495057;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder,.select2-container .select2-selection--single .select2-selection__rendered{    font-weight: 400 !important;    color: #495057bf;

}
.select2-container--default .select2-selection--single .select2-selection__rendered{    line-height: inherit !important;
}
#payment nav img{max-width: 80%;}
.copy-clip-new span a{color:#000;}
.googlepayment-barcode-new {padding: 20px 55px 95px;background-color: #DBEBFF;text-align:center;border-radius: 10px;position: relative;box-shadow: 0 3px 6px #00000017;}
a.new-payment-type:before {content: "";position:absolute;bottom: -17px;left: 20%;display:inline-block;width: 60%;border-bottom: #D2CFCF solid 4px;}
a.google-pay-active.active:before{border-bottom: #297AEC solid 4px;}
a.paytm-pay-active.active:before{	border-bottom: #036293 solid 4px;}
a.phonepe-pay-active.active:before{border-bottom: #6639B6 solid 4px;}
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
.line-right-pay.active:after{content: '';width: 144px;border-bottom: solid 2px;background-image: linear-gradient(to right,#1B1464,#006FBA);    position: absolute;left: -144px;top: 50%;z-index: 1;}
@media only screen and (max-width: 767px) {
    span.select2.select2-container.select2-container--bootstrap,.country-code-selected{width:100% !important;}
    .gopayment-width{width:100%;}
    .state-css {
    width: 89px;
}
.pincode-css {
    width: 68px;
}
.help-block2{left: 78px !important;}
.payment-trans-button button{width: 100%;text-align: center;
        margin-left: 0px;margin-top: 20px;}
		 
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
.payment-form-avd {transition: border linear .2s,box-shadow linear .2s;-webkit-border-radius: 0;-moz-border-radius: 0;vertical-align: middle;width: 100%;padding: 6px 15px;border-radius: 4px;background-color: #E9E9E9;font-weight: 400;text-transform: inherit;border: 1px solid rgba(0, 43, 92, 0.08);font-size: 14px;outline: none;line-height: inherit;letter-spacing: 0px;}
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
.help-block2 {display: block;margin-top: 0px;color: #ff0000;font-size: 12px;position: absolute;top: 38px;left: 111px;}

.drop-zone__input {
       opacity: 0;
    position: absolute;
    display: block;
    flex-wrap: wrap;
    overflow: hidden;
    width: 100%;
    padding:4px;
} 
    }
.gopayment-width{text-align: center;}
			</style>			
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
		<a class="nav-item1 active my-mr-5" data-toggle="tab" href="#payment-student-Detail" role="tab"
		aria-controls="nav-home" aria-selected="true"><img loading="lazy" src="{{asset('public/img/pay/baseline-person.png')}}" alt="Details" class="img-fluid pay-responsive-img"><span class="text-payment">Details</span></a>
		
		<a class="nav-item1 my-mr-5 line-right-pay disabled" data-toggle="tab" href="#transaction" role="tab"
		aria-controls="nav-profile" aria-selected="false"><img loading="lazy" src="{{asset('public/img/pay/verified-user.png')}}" alt="Verify" class="img-fluid pay-responsive-img "><div class="text-payment">Verify Details </div></a>
		
		<a class="nav-item1  line-right-pay disabled" data-toggle="tab" href="#payment" role="tab"
		aria-controls="nav-contact" aria-selected="false"><img loading="lazy" src="{{asset('public/img/pay/wallet.png')}}" alt="Payment" class="img-fluid pay-responsive-img"><div class="text-payment">Payment</div></a>

		</div>
		</nav>
	<div class="tab-content student-payment-new">
	<div class="tab-pane fade show active" id="payment-student-Detail" role="tabpanel"
	aria-labelledby="Student-Detail">
	<div class="mt-0" >
	<h3 style="text-align:center;">Please Enter Your Details Here</h3>
	<p class="mb-4" style="text-align:center;">Fill all form field to go next step</p>
		<?php 
	
	if(isset($_GET['status'],$_GET['o'])&& !empty($_GET['o'])){
	$o = base64_decode ( $_GET['o'], $strict=false );
	$data = json_decode($o);
	$status = $_GET['status'];
	}else{
		$data=array();
	}
	 
	?>
	<form action="{{url('/save-processing')}}" method="post" autocomplete="off">
	<div class="form-row form-avd-first-box">
	<div class="form-group col-md-12">
	<label for="companyName" class="col-form-label-sm">Name*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<input type="hidden" name="id" value="{{ $id }}" />
	<input type="text" class="form-control payment-form-avd" name="name" placeholder="Enter Full Name" value="{{ old('name', (isset($data->name)) ? $data->name:"")}}" >
		@if ($errors->has('name'))
		<span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>

		@endif
	</div>
	<!--<div class="form-group col-md-6">
	<input type="text" class="form-control payment-form-avd" name="last_name" placeholder="Enter Last Name" value="{{ old('last_name', (isset($data->last_name)) ? $data->last_name:"")}}">
	</div>-->

	</div>

	<div class="form-row">
	<div class="form-group col-md-12">
	<label for="companyName" class="col-form-label-sm">Email*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<input type="text" class="form-control payment-form-avd" name="email" id="exampleFormControlInput1" placeholder="Enter Email Id" value="{{ old('email',(isset($data->email)) ? $data->email:"")}}">
	
	@if ($errors->has('email'))
		<span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>

		@endif
	</div>


	</div>


	<div class="form-row">
	<div class="form-group col-md-4">
	<label for="code" class="col-form-label-sm">Code*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
 	 
	<?php 
	$geodata = json_decode(file_get_contents("http://ipinfo.io/".$_SERVER['REMOTE_ADDR']));
	$countryies = countryCode($geodata->country=null);
	?>
	<select name="code" class="country-code choosecode country-code-selected">

	@if(!empty($countryies))
	@foreach($countryies as $country)
	<option value="{{$country->phonecode}}" <?php if($country->sortname==$geodata->country){  echo "selected";} ?>>+{{$country->phonecode}}({{$country->sortname}})</option>
	@endforeach
	@endif
	</select>
	 
	</div>
	
	<div class="form-group col-md-8">
	<label for="mobile" class="col-form-label-sm">Mobile*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
 	
	<input type="tel" class="form-control payment-form-avd" name="phone" placeholder="Enter Mobile Number" maxlength="16" onkeypress="return isNumberKey(event);" value="{{ old('phone',(isset($data->phone)) ? $data->phone:"")}}"> 
		
	@if ($errors->has('phone'))
		<span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>

		@endif
	
	</div>


	</div>

	<div class="form-row">
	<div class="form-group col-md-12">
	<label for="companyName" class="col-form-label-sm">Course*&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<input type="text" class="form-control payment-form-avd" name="course" placeholder="Enter Course" value="{{ old('course',(isset($data->course)) ? $data->course:"")}}">
	@if ($errors->has('course'))
		<span class="help-block"><strong>{{ $errors->first('course') }}</strong></span>

		@endif
	</div>


	</div>


	<div class="form-row">
	<div class="form-group col-md-12">
	<label for="companyName" class="col-form-label-sm">Amount*&nbsp;&nbsp;</label>
	<input type="text" class="form-control payment-form-avd" name="amount" placeholder="Enter Amount" maxlength="16" onkeypress="return isNumberKey(event);"  value="{{ old('amount',(isset($data->amt)) ? $data->amt:"")}}">
		@if ($errors->has('amount'))
		<span class="help-block"><strong>{{ $errors->first('amount') }}</strong></span>
		@endif
	</div>
	</div>

	<div class="form-row">
	<div class="form-group col-md-6">
	<label for="inputState" class="col-form-label-sm">Country&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<select name="country" class="form-control payment-form-avd select_country">
	<option value="">select Country</option>
	<?php $countryes = App\Country::orderby('country_name')->get();								?>
	@if(!empty($countryes))
	@foreach($countryes as $country)

	<option value="{{$country->country_id}}"  >{{$country->country_name}}</option>
	@endforeach
	@endif
	</select>
		@if ($errors->has('country'))
		<span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>

		@endif
	</div>

	<div class="form-group col-md-6 state-help-box">
	<label for="inputState" class="col-form-label-sm state-css">State</label>
	<select name="state" class="form-control payment-form-avd show_state select2_state ">
	<option value="">Select State</option>
	<option value=""></option>
	</select>
@if ($errors->has('state'))
		<span class="help-block2"><strong>{{ $errors->first('state') }}</strong></span>

		@endif
	</div>
	</div>
	
	<div class="form-row">
	<div class="form-group col-md-6">
	<label for="inputCity" class="col-form-label-sm">City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<input type="text" class="form-control payment-form-avd" name="city" placeholder="Enter City" value="{{ old('city',(isset($data->city)) ? $data->city:"")}}">
	@if ($errors->has('city'))
		<span class="help-block"><strong>{{ $errors->first('city') }}</strong></span>

		@endif
	</div>

	<div class="form-group col-md-6">
	<label for="inputState" class="col-form-label-sm pincode-css">Pin Code&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<input type="text" class="form-control payment-form-avd" name="pincode" placeholder="Enter Pin Code" value="{{ old('pincode',(isset($data->pincode)) ? $data->pincode:"")}}">

	</div>
	</div>

	<button type="submit"  name="checkout" value="CheckOut" class="btn payment-button4" style="color:#fff">PROCEED</button>

	</form>
	</div>
	</div>
	
 
	 
	
	 
	</div>
	</div>
	</div>
	</div>
	</div>
	</section>
	</div>
 @endsection