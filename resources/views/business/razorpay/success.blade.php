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


tr th{
	padding: 0px 10px;
}
.transaction-section table tr {
    border-bottom: 1px solid #6d6d6d;
    line-height: 2.9;
}

.transaction-section table tr td {
    text-align: left;
}
@media only screen and (max-width: 767px){
	.red-heading{
		font-size:12px;
	}
	#invoicePrintPdf{
		    margin-left: 70% !important;
    margin-top: 11px !important;
	}
}
	</style>
 
<div id="main" class="main">	
	    <div class="pagetitle">
      <h1>Success</h1>
      
    </div><!-- End Page Title -->
		<section class="section profile">
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
							 					  
							  
							<table width="100%">
							<tr>
							<td><strong>Summary</strong></td>
							<td><strong>Details</strong></td>
							</tr>
							<tr style="background-color:#ddd;color:#003453;">
							<th>Order Id</th>

							<td> <?php echo isset($_GET['order_id'])?$_GET['order_id']:""; ?></td>
							</tr> 							
							  
							
							<tr style="background-color:#f4f5f7;color:#003453;">
							<th>Name</th>

							<td><?php echo isset($_GET['card_holder_name'])?ucfirst($_GET['card_holder_name']):""; ?></td>
							</tr>
							<tr style="background-color:#ddd;color:#003453;">
							<th>Email</th>

							<td><?php echo isset($_GET['email'])?$_GET['email']:""; ?></td>
							</tr>
						 
							<tr style="background-color:#ddd;color:#003453;">
							<th>Amount</th>

							<td><?php echo isset($_GET['merchant_amount'])?$_GET['merchant_amount']:""; ?></td>
							</tr>
							<tr style="background-color:#f4f5f7;color:#003453;">
							<th>Pay To</th>

							<td> <?php echo isset($_GET['pay_to'])?$_GET['pay_to']:""; ?></td>
							</tr>
							
							<tr style="background-color:#ddd;color:#003453;">
							<th>Payment id</th>

							<td> <?php echo isset($_GET['payment_id'])?$_GET['payment_id']:""; ?></td>
							</tr>
							
							<tr style="background-color:#f4f5f7;color:#003453;">
							<th>Contact</th>

							<td><?php echo isset($_GET['phone'])?$_GET['phone']:""; ?></td>
							</tr>							 
							 
							<tr style="background-color:#ddd;color:#003453;">
							<th>Address</th>

							<td><?php echo (isset($_GET['city'])?$_GET['city']:"").', '.(isset($_GET['billing_state'])?$_GET['billing_state']:"").', '.(isset($_GET['billing_country'])?$_GET['billing_country']:""); ?></td>
							</tr>
												 
							<tr style="background-color:#f4f5f7;color:#003453;">
							<th>Pay Date</th>

							<td> <?php 	  
							echo date('j<\s\u\p>S</\s\u\p> M Y',strtotime(date('Y-m-d'))); ?></td>
							</tr>
							<tr style="border:none">
							<td>
						@if(!empty($paymentHistory->id))
						<a href="{{ url('business/getinvoiceBillingPrintPdf/' . optional($paymentHistory)->id) }}" class="btn btn-primary"  style="margin-left: 50%;"> <i class="fa fa-print"></i> Download Invoice</a>
					
						@else
	<a href="{{ url('business/billing-history')}}" class="btn btn-primary"  style="margin-left: 50%;"> <i class="fa fa-print"></i> Download Invoice</a>

						@endif
					</td>
							</tr>

							</table>

								
																
																
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
<script type="text/javascript">
  
</script>





@endsection