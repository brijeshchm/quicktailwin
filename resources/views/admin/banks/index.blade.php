<?php echo View::make('admin/header'); ?>

       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Banks Details</h1>
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
					@if(Session::has('failed'))
						<div class="alert alert-danger">
							{{Session::get('failed')}}
						</div>
					@endif					
                    <div class="panel panel-info">
                        <div class="panel-body">
						
						
						@if(Request::segment(3)=='edit')					
						<div class="nc-form row form-group{{ $errors->has('banks') ? ' has-error' : '' }}">
								<form method="POST" action="/developer/banks/edit/{{$edit_data->id}}">
									{{ csrf_field() }}
									<div class="col-md-12">
										<h4><u>Update Banks:</u></h4>
									</div>
									  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="mode">Select Mode:</label>
										<select name="mode" class="form-control">
											<option value="">Select Mode</option>
											<?php 
											if(!empty($modesdetails)){
											foreach($modesdetails as $modes): ?>
											<option value="<?php echo $modes->slug; ?>"  @if ($modes->slug== old('mode'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->mode == $modes->slug ) ? "selected":"" }} @endif  ><?php echo $modes->mode; ?></option>
											<?php endforeach;
											}
											?>
										</select>
										@if ($errors->has('mode'))
											<span class="help-block">
												<strong>{{ $errors->first('mode') }}</strong>
											</span>
										@endif
									</div>
									 
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="banks">Update Banks:</label>
										<input type="text" class="form-control" name="name" placeholder="Enter banks" value="{{ old('name',(isset($edit_data)) ? $edit_data->name:"")}}">
										@if ($errors->has('name'))
											<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
									</div>
									 
								 
									 
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="" style="visibility:hidden">Submit:</label>
										<input type="submit" class="btn btn-info btn-block form-control" name="submit" value="Update">
									</div>
								</form>
							</div>
							@else
									
								
							<div class="nc-form row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								<form method="POST" action="/developer/banks/add">
									{{ csrf_field() }}
									<div class="col-md-12">
										<h4><u>Add Banks:</u></h4>
									</div>
									 
									 
																 
									 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="mode">Select Mode:</label>
										<select name="mode" class="form-control">
											<option value="">Select Mode</option>
											<?php 
											if(!empty($modesdetails)){
											foreach($modesdetails as $modes): ?>
											<option value="<?php echo $modes->slug; ?>"><?php echo $modes->mode; ?></option>
											<?php endforeach;
											}
											?>
										</select>
										@if ($errors->has('mode'))
											<span class="help-block">
												<strong>{{ $errors->first('mode') }}</strong>
											</span>
										@endif
									</div>
									
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="banks">Add New Banks:</label>
										<input type="text" class="form-control" name="name" placeholder="Enter banks" value="{{ old('banks') }}">
										@if ($errors->has('name'))
											<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
									</div>	
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="" style="visibility:hidden">Submit:</label>
										<input type="submit" class="btn btn-info btn-block form-control" name="submit" value="Save">
									</div>
								</form>
							</div>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-banksdetails">
                                <thead>
                                    <tr>
                                        <th>Name</th>
										<th>Mode</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
										<th>Name</th>
										<th>Mode</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        
							
							@endif
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
 
		 
			<!-- deleteKeywordModal -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>