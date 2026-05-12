<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Register Client</h1>
                </div>
            
            </div>      
            <div class="row">
                <div class="col-lg-12">
					@if(count($errors)>0)
					 
					@endif
					@if(Session::has('success_msg'))
						<div class="alert alert-success">
							{{Session::get('success_msg')}}
						</div>
					@endif
					@if(Session::has('danger_msg'))
						<div class="alert alert-danger">
							{{Session::get('danger_msg')}}
						</div>
					@endif
					<form class="form-horizontal" action="{{ url('developer/clients/register') }}" method="POST">
						{{csrf_field()}}
						<div class="form-group{{ $errors->has('business_name') ? ' has-error' : '' }}">
							<label class="control-label col-sm-2" for="">Business Name: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" value="{{ old('business_name') }}" name="business_name" placeholder="Business Name">
								@if ($errors->has('business_name'))
									<span class="help-block">
										<strong>{{ $errors->first('business_name') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
							<label class="control-label col-sm-2" for="first_name">First Name: </label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
								@if ($errors->has('first_name'))
									<span class="help-block">
										<strong>{{ $errors->first('first_name') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
							<label class="control-label col-sm-2" for="last_name">Last Name: </label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
								@if ($errors->has('last_name'))
									<span class="help-block">
										<strong>{{ $errors->first('last_name') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label class="control-label col-sm-2" for="email">Email: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Email Name">
								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
							<label class="control-label col-sm-2" for="mobile">Mobile: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" placeholder="Enter Mobile ">
								@if ($errors->has('mobile'))
									<span class="help-block">
										<strong>{{ $errors->first('mobile') }}</strong>
									</span>
								@endif
							</div>
						</div>
						<!--<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
							<label class="control-label col-sm-2" for="city">City: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" name="city" value="{{ old('city') }}">
								@if ($errors->has('city'))
									<span class="help-block">
										<strong>{{ $errors->first('city') }}</strong>
									</span>
								@endif
							</div>
						</div>	-->
						
						<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
							<label class="control-label col-sm-2" for="city">City: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							<div class="col-sm-4"> 
							<select class="form-control city select2-single-city" name="city">
									<option value="">-- SELECT CITY --</option>									 
								</select>
						</div>
						</div>
						<div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-4 text-right">
								<input type="submit" name="initial_form_submit" value="Start Your Business" class="btn btn-warning">
							</div>
						</div>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
