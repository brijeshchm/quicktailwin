<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Checkout — QuickDials</title>
    <meta name="keywords" content="Quickdials Payment checkout">
    <meta name="description" content="Quickdials Payment checkout">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="robots" content="noindex, follow">

    <meta name="author" content="Quick Dials">
    <meta property="og:title" content="Quickdials Payment checkout" />
    <meta property="og:description" content="Quickdials Payment checkout" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="@yield('og_image', asset('client/images/quickdials-og.png'))" />

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Quickdials Payment checkout" />
    <meta name="twitter:description" content="Quickdials Payment checkout" />
    <meta name="twitter:image" content="@yield('og_image', asset('client/images/quickdials-og.png'))" />

    {{-- GEO --}}
    <meta name="geo.region" content="IN" />
    <meta name="geo.placename" content="India" />

    {{-- Verification --}}
    <meta name="google-site-verification" content="O8A-LG3YpW7vOcPtVP9OuNrEcLfLf1kW2tTVpFpHNxM" />
    <meta name="msvalidate.01" content="456AED0115D50D42C4F3A79DAB89D41D" />

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('client/images/favicon.png') }}" type="image/png" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ FIX #1: Load jQuery BEFORE Razorpay script --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- ✅ FIX #1: Razorpay script in head (loads before usage) --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>

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
		                    
		                
		                      
		                </div>
					</div>
				</div>
			</div>
		</section>

		 
	</div>

</body>
</html>