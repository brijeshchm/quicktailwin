 @extends('business.layouts.app')
@section('title')
 
@endsection 
@section('keyword')
 
@endsection
@section('description')
 
@endsection
@section('content')
<style>
	  a.disabled {
  pointer-events: none;
  cursor: default;
}  
.red-heading{
    font-size: 18px;
	
}

tr th{
	padding: 0px 10px;
}
.transaction-section table tr {
    border-bottom: 1px solid #6d6d6d;
    line-height: 2.9;
}
@media only screen and (max-width: 767px){
	.red-heading{
		font-size:12px;
	}
	#ccavenuePrintPdf{
	margin-left: 70% !important;
    margin-top: 11px !important;
	}
}


.thanksection{
		    background: linear-gradient(90deg, #ffeed3, #fff3e4);
		    padding: 45px;
		    text-align: center;
		}
		.thankheading h1{
		    font-size: 72px;
		    background: -webkit-linear-gradient(#f6c46a, #fc944c);
		    -webkit-background-clip: text;
		    -webkit-text-fill-color: transparent;
		    border-bottom: 2px solid #014655;
		    width: 320px;
		    margin: auto;
		}
		.thanks-desc{
		    margin-top: 45px;
			text-align: center;
		}
		.thanks-desc p{
		    margin-top: 15px;
		    margin-bottom: 15px;
		}
		.button5 {
    width: 42%;
}
	</style>
 	 <input type="hidden" name="_token" value="{{ csrf_token() }}" /> 
	  <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="main">	
		<section class="fee-deposit">
			<div class="container">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						 <nav>
		                    <div class="nav payment-form" role="tablist">
			                    <a class="nav-item disabled" data-toggle="tab" href="#Student-Detail" role="tab" aria-controls="nav-home" aria-selected="true" >Details</a>
			                    <a class="nav-item disabled" data-toggle="tab" href="#transaction" role="tab" aria-controls="nav-profile" aria-selected="false" >Transaction</a>
			                   
			                    <a class="nav-item active" data-toggle="tab" href="#confirmation" role="tab" aria-controls="nav-about" aria-selected="false">Confirmation</a>
								
							<a class="nav-item"  data-toggle="tab" href="#faceanissue" role="tab" aria-controls="nav-home" aria-selected="true">Face an issue</a>
		                    </div>
		                </nav>
		                <div class="tab-content">
		                     
		                    <div class="tab-pane fade show active" id="confirmation" role="tabpanel" aria-labelledby="confirmation">
		                      <div class="transaction-section">
							 									<div class="row">
								<div class="col-md-12">
								<div class="thankheading">
								<h1>Thanks!!</h1>
								</div>
								<div class="thanks-desc">
								<strong>Thanks for submitting the fees.</strong>

								<p>Your receipt will be issued after verifying the <strong>Successful Payment </strong>screenshot submitted by you. For more information kindly contact your Learning Consultant.</p>
								<a href="{{url('/')}}" class="button5">GET BACK TO OUR HOME PAGE</a>
								</div>
								</div>
								</div>

								
																
																
						</div>
		                    </div>
		                    
		                    <div class="tab-pane fade" id="faceanissue" role="tabpanel" aria-labelledby="faceanissue">
								<div class="student-payment">
		                      		<h3>Face an issue</h3>
		                      		<form method="POST" onsubmit="return homeController.faceAnIssue(this)" action="" autocomplete="off">
		                       
		                      			<div class="form-inline">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<div class="ans">
										    <input type="text" name="name" value="{{ old('name', (isset($data->name)) ? $data->name:"")}}" class="form-control" placeholder="Enter Full Name *">
											
										@if ($errors->has('name'))
											<span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
										 
										@endif
										</div>
										<div class="ans">
										    <input type="text" name="email" value="{{ old('email',(isset($data->email)) ? $data->email:"")}}"  class="form-control" placeholder="E-mail *">
										    @if ($errors->has('email'))
											<span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
										 
										@endif
										</div>
										</div>
		                      			<div class="form-inline">	
										   <div class="ans">
											 <input type="text" name="phone" value="{{ old('phone',(isset($data->phone)) ? $data->phone:"")}}"  class="form-control" maxlength="16" onkeypress="return isNumberKey(event);" placeholder="Contact No. *">
											 @if ($errors->has('phone'))
											<span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
										 
										@endif
										</div>
										<div class="ans">
										  <textarea type="text" name="remark" class="form-control" placeholder="Enter Face an issue remark *">{{ old('remark',(isset($data->remark)) ? $data->remark:"")}}</textarea>
											@if ($errors->has('remark'))
											<span class="help-block"><strong>{{ $errors->first('remark') }}</strong></span>
										 
										@endif
										</div>
		                      			</div>  
									   
									    <button type="submit" class="face-issue-button" name="submit">Submit</button>
									</form>
		                      	</div>
							</div>
		                      
		                </div>
					</div>
				</div>
			</div>
		</section>

		 
	</div>
<script src="{{asset('select2/js/select2.full.js')}}" async></script>

<script>
/* 
 $(document).ready(function() {
	 alert('ss');

}); */
 //$(".select_country").select2();
</script>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
 





@endsection