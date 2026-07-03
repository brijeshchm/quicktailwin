@extends('layouts.app')
 @section('title')
     OTP  
@endsection
@section('content')
<div class="container">
    <div class="row">
	 
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="margin-top: 50px;">
                <div class="login-heading color-text">Mobile OTP</div>
                <div class="panel-body" style="margin-top: 45px;">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/developer/login/otp') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                            <label for="otp" class="col-md-4 control-label color-text">OTP</label>

                            <div class="col-md-6">
                                <input id="otp" type="password" class="form-control" name="otp" placeholder="Enter OTP">
								@if ($errors->has('otp'))
									<span class="help-block">
										<strong>{{ $errors->first('otp') }}</strong>
									</span>
								@endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Secure Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
