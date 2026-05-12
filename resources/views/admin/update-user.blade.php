<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Edit</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">			
					@if(Session::has('alert-success'))
						<div class="alert alert-success">
							{{Session::get('alert-success')}}
						</div>
					@endif		
					@if(Session::has('success_msg'))
						<div class="alert alert-success">
							{{Session::get('success_msg')}}
						</div>
					@endif
					@if(Session::has('danger'))
						<div class="alert alert-danger">
							{{Session::get('danger')}}
						</div>
					@endif					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            User Edit
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php if(!empty($user)): ?>
							<form class="form-horizontal" role="form" method="POST" action="{{ url('/developer/update-user/'.base64_encode($user->id)) }}">
								{{ csrf_field() }}

								<div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
									<label for="user_name" class="col-md-3 control-label">User Name OR Email<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>

									<div class="col-md-6">
										<input id="user_name" type="text" class="form-control" name="user_name" value="{{ $user->user_name }}" disabled>

										@if ($errors->has('user_name'))
											<span class="help-block">
												<strong>{{ $errors->first('user_name') }}</strong>
											</span>
										@endif
									</div>
								</div>						
								
								<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
									<label for="first_name" class="col-md-3 control-label">First Name<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>

									<div class="col-md-6">
										<input id="first_name" type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">

										@if ($errors->has('first_name'))
											<span class="help-block">
												<strong>{{ $errors->first('first_name') }}</strong>
											</span>
										@endif
									</div>
								</div>
								
								<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
									<label for="last_name" class="col-md-3 control-label">Last Name<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>

									<div class="col-md-6">
										<input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">

										@if ($errors->has('last_name'))
											<span class="help-block">
												<strong>{{ $errors->first('last_name') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
									<label for="mobile" class="col-md-3 control-label">Mobile<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>

									<div class="col-md-6">
										<input id="mobile" type="tel" class="form-control" name="mobile" value="{{ $user->mobile }}">

										@if ($errors->has('mobile'))
											<span class="help-block">
												<strong>{{ $errors->first('mobile') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<label for="email" class="col-md-3 control-label">E-Mail Address<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>

									<div class="col-md-6">
										<input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" disabled>

										@if ($errors->has('email'))
											<span class="help-block">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
									</div>
								</div>
								
								<div class="form-group{{ $errors->has('sec_email') ? ' has-error' : '' }}">
									<label for="sec_email" class="col-md-3 control-label">Secondary E-Mail Address</label>

									<div class="col-md-6">
										<input id="sec_email" type="sec_email" class="form-control" name="sec_email" value="{{ $user->sec_email }}">

										@if ($errors->has('sec_email'))
											<span class="help-block">
												<strong>{{ $errors->first('sec_email') }}</strong>
											</span>
										@endif
									</div>
								</div>						

								<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
									<label for="role" class="col-md-3 control-label">Role<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>

									<div class="col-md-6">
										<select id="role" class="form-control col-md-7 col-xs-12" <?php echo (Auth::user()->current_user_can('administrator'))?"name=\"role\"":"disabled"; ?>>
											<?php
											$roles = [
												"administrator"=>"Administrator",
												"manager"=>"Manager",
												"SEO"=>"SEO",
												"teleteam"=>"Tele Team",
												"salesmanager"=>"Sales Manager",
												"seo_manager"=>"SEO Manager"
											];
											?>
											<option value="">Select Role</option>
											@foreach($roles as $key=>$value)
												<option value="{{ $key }}" <?php echo ($key==$user->role)?"selected":""; ?>>{{ $value }}</option>
											@endforeach
										</select>

										@if ($errors->has('role'))
											<span class="help-block">
												<strong>{{ $errors->first('role') }}</strong>
											</span>
										@endif
									</div>
								</div>						
								<div class="form-group{{ $errors->has('capabilities') ? ' has-error' : '' }}"> 
									<label class="control-label col-md-3" for="capabilities">Capabilities<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
									<div class="col-md-6">
										<?php
										
										//	$capabilities = getCapabilities();
									
									
										$html = "";
										foreach($permissions as $permission){
											$selected = "";
											if(in_array($permission->permission,$userCaps,TRUE)){
												$selected = "selected";
											}
											$html.="<option value='$permission->permission' $selected>$permission->permission</option>";
										}
										?>
										<select id="capabilities" class="form-control chosen-select col-md-7 col-xs-12" multiple <?php echo (Auth::user()->current_user_can('administrator')||Auth::user()->current_user_can('manager') )?"name=\"capabilities[]\"":"disabled"; ?>>
										<?php echo $html; ?>
										</select>
										@if ($errors->has('capabilities'))
											<span class="help-block">
												<strong>{{ $errors->first('capabilities') }}</strong>
											</span>
										@endif
									</div>
								</div>
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<label for="password" class="col-md-3 control-label">Password<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>

									<div class="col-md-6">
										<div class=" input-group">
											<input id="password" type="password" class="form-control" name="password">
											<span class="input-group-addon pass-eye"><i class="fa fa-eye fa-fw pass-eye" aria-hidden="true"></i></span>
										</div>
										@if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
									<label for="password-confirm" class="col-md-3 control-label">Confirm Password<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>

									<div class="col-md-6">
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation">

										@if ($errors->has('password_confirmation'))
											<span class="help-block">
												<strong>{{ $errors->first('password_confirmation') }}</strong>
											</span>
										@endif
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-btn fa-user"></i> Update
										</button>
									</div>
								</div>
							</form>
                            <!-- /.table-responsive -->
							<?php else: ?>
							<div class="alert alert-warning">
								No result found.
							</div>							
							<?php endif; ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>