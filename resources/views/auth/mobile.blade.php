@extends('layouts.app')
 @section('title')
     OTP  
@endsection
@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="margin-top: 50px;">
                <div class="login-heading">Mobile OTP</div>
                <div class="panel-body" style="margin-top: 45px;">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/developer/login/otp') }}">
                        {{ csrf_field() }}

                     
                       
						
						<div class="form-group">
							<label for="otp_to_email" class="col-md-4 control-label color-text">Email</label>
                            <div class="col-md-6">
				            <select id="otp_to_email" class="form-control emailhide" name="otp_to_email" onchange="emailval(this);">
									<option value="">-- Select the email --</option>
									@if($email)
										@foreach($email as $email_v)
									<option value="{{$email_v->email}}">{{$email_v->email}}</option>
									@endforeach
									@endif
 
								</select>
                            </div>
						</div>
						
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

function mobileval(sel)
{
   var mobile =  (sel.value);
  
   if(mobile !='')
   {	   
	  $('.emailhide').attr("disabled", "disabled"); 
	   
   }else{
	 
	     $('.emailhide').removeAttr("disabled");
   }
}

function emailval(sel)
{
   var mobile =  (sel.value);
 
   if(mobile !='')
   {	   
	  $('.mobilehide').attr("disabled", "disabled"); 
	   
   }else{
	  
	     $('.mobilehide').removeAttr("disabled");
   }
}
</script>
@endsection
