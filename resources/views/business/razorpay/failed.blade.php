 @extends('business.layouts.app')
@section('title')
 
@endsection 
@section('keyword')
 
@endsection
@section('description')
 
@endsection
@section('content')

  
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
 





@endsection