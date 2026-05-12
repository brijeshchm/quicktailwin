<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cities</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
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
                    <div class="panel panel-info">
                        <div class="panel-body">
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('add_city') )
							<div class="nc-form row form-group{{ $errors->has('city') ? ' has-error' : '' }}">
								<form method="POST" action="/developer/cities">
									{{ csrf_field() }}
									<div class="col-lg-3">
										<label for="State">State:</label>									 
										
										<select type="text" class="form-control" name="state" >
										<option value="">Select State</option> 
										@if(!empty($states))
											@foreach($states as $state)
										<option value="{{$state->state}}">{{$state->state}}</option>
										@endforeach
										@endif									
										</select>
										@if ($errors->has('state'))
											<span class="help-block">
												<strong>{{ $errors->first('state') }}</strong>
											</span>
										@endif	
									</div>
									<div class="col-lg-3">
										<label for="city">Add New City:</label>
										<input type="text" class="form-control" name="city" id="city" placeholder="Enter City Name" value="{{ old('city') }}">
										@if ($errors->has('city'))
											<span class="help-block">
												<strong>{{ $errors->first('city') }}</strong>
											</span>
										@endif										
										 
									</div>
									<div class="col-lg-3">
										<label for="latitude">Latitude:Remove °(x.xxxxN) </label>
										<input type="text" class="form-control" name="latitude" placeholder="Enter Latitude" value="{{ old('latitude') }}">
										@if ($errors->has('latitude'))
											<span class="help-block">
												<strong>{{ $errors->first('latitude') }}</strong>
											</span>
										@endif										
										 
									</div>
									<div class="col-lg-3">
										<label for="longitude">longitude:Remove°(x.xxxxE)</label>
										<input type="text" class="form-control" name="longitude"  placeholder="Enter longitude" value="{{ old('longitude') }}">
										@if ($errors->has('longitude'))
											<span class="help-block">
												<strong>{{ $errors->first('longitude') }}</strong>
											</span>
										@endif										
										
									</div>
																	
									<div class="col-lg-3">										 
										<input type="submit" class="btn btn-info btn-block" class="form-control" style="margin-top:10px;">
									</div>
								</form>
							</div>
						@endif
						<div class="table-responsive">
								<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-citylist">
					 
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                        <th>City</th>    
                                        <th>State</th>										 
                                        <th>Action</th>
										 
                                    </tr>
                                </thead>
                              
                            </table>
                            <!-- /.table-responsive -->
												 
                        </div>
						
						
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

			<!-- Modal -->
			<div id="updateCityModal" class="modal fade" role="dialog">
				<div class="modal-dialog modal-sm">

				<!-- Modal content-->
				<div class="modal-content">
					<form method="POST" action="/developer/cities/update">
					<div class="form-group">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-info">Update</button>
						</div>
					</div>
					</form>
				</div>

				</div>
			</div>
			<!-- Modal -->
        </div>
        <!-- /#page-wrapper -->
<script>
$('#datatable-citylist').datatable();
</script>
<?php echo View::make('admin/footer'); ?>
