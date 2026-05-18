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
		<section class="section profile">
			<div class="container">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						 
		                <div class="tab-content">
		                     
		                    <div class="tab-pane fade show active" id="transaction" role="tabpanel" aria-labelledby="transaction">
		                      <div class="transaction-section">
							   <section class="showcase">
   <div class="container">
    <div class="text-center">
      <h1 class="display-3">Thank You!</h1>
      <p class="lead text-danger">Your transaction has been declined.</p>
      <hr>
      <p>
        Having trouble? <a href="mailto:info@quickdials.com">Contact us</a>
      </p>
      <p class="lead">
        <a class="btn btn-primary btn-sm" href="{{url('business/package')}}" role="button">Continue to Pay</a>
      </p>
    </div>
    </div>
</section>
							  
							  
							 
								
																
																
								 
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