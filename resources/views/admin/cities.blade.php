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
									<div class="col-lg-4">
										<label for="city">Add New City:</label>
										<input type="text" class="form-control" name="city" id="city" placeholder="Enter City Name" value="{{ old('city') }}">
										@if ($errors->has('city'))
											<span class="help-block">
												<strong>{{ $errors->first('city') }}</strong>
											</span>
										@endif										
										<input type="submit" class="btn btn-info btn-block" class="form-control" style="margin-top:10px;">
									</div>
									<div class="col-lg-4">
										<label for="popular">Mark as Popular City:</label>
										<!--input type="checkbox" class="form-control" name="popular" id="popular"-->
										<div class="checkbox">
											<label><input type="checkbox" name="popular" id="popular" value="1">Check the box to mark as popular</label>
										</div>
									</div>
								</form>
							</div>
						@endif
							<?php if(isset($allCities) && count($allCities)>0): ?>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>City</th>
                                        <th>Popular</th>
										@if(Auth::user()->current_user_can('administrator|admin'))
                                        <th>Update</th>
                                        <th>Delete</th>
										@endif
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($allCities as $city): ?>
                                    <tr>
                                        <td>{{ $city->city }}</td>
                                        <td><?php echo $city->popular?"<i style='color:green' class='fa fa-fw fa-check' aria-hidden='true'></i>":"<i class='fa fa-fw fa-times' style='color:red' aria-hidden='true'></i>"?></td>
										@if(Auth::user()->current_user_can('administrator|admin'))
                                        <td><a href="javascript:void(0)" onclick="javascript:updateCity({{$city->id}},this)"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a></td>
                                        <td><a href="javascript:void(0)" onclick="javascript:deleteCity({{$city->id}},this)"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></td>
										@endif
                                    </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
							<?php else: ?>
							<div class="alert alert-danger">
								No City Found !!
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

<?php echo View::make('admin/footer'); ?>
