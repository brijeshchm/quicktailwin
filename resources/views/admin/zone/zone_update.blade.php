<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Zone Edit</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">		
					@if(Session::has('success'))
						<div class="alert alert-success">
							{{Session::get('success')}}
						</div>
					@endif
					@if(Session::has('danger'))
						<div class="alert alert-danger">
							{{Session::get('danger')}}
						</div>
					@endif
					@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<?php if(isset($edit_data)): ?>
							<form class="form-horizontal" role="form" method="POST" action="{{ url('/developer/zone/update/'.$edit_data->id) }}">
								{{ csrf_field() }}

								<div class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
									<label for="city_id" class="col-md-4 control-label">City</label>

									<div class="col-md-6">
										<select name="cityid" class="form-control select2-single">	 											
									@if(!empty($citylists))
									@foreach($citylists as $citys)								 
									<option value="{{$citys->id}}"  
									@if ($citys->id== old('cityid'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->city_id == $citys->id ) ? "selected":"" }} @endif   >
									{{$citys->city}}</option>
									@endforeach
									@endif
							 
										</select>

										@if ($errors->has('city_id'))
											<span class="help-block">
												<strong>{{ $errors->first('city_id') }}</strong>
											</span>
										@endif
									</div>
								</div>
								
								<div class="form-group{{ $errors->has('zone_id') ? ' has-error' : '' }}">
									<label for="zone_id" class="col-md-4 control-label">Zone</label>

									<div class="col-md-6">
										<input type="text" name="zone" class="form-control" value="{{ $edit_data->zone }}">									 

										@if ($errors->has('zone'))
											<span class="help-block">
												<strong>{{ $errors->first('zone') }}</strong>
											</span>
										@endif
									</div>
								</div>
								  

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary pull-right">Update</button>
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