<?php echo View::make('admin/header'); ?>

       <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Mode Details</h1>
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
						<div class="nc-form row form-group{{ $errors->has('mode') ? ' has-error' : '' }}">
								<form method="POST" action="/developer/mode/edit/{{$edit_data->id}}">
									{{ csrf_field() }}
									<div class="col-md-12">
										<h4><u>Update Mode:</u></h4>
									</div>
									 
									 
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="mode">Update New Mode:</label>
										<input type="text" class="form-control" name="mode" placeholder="Enter Mode" value="{{ old('mode',(isset($edit_data)) ? $edit_data->mode:"")}}">
										@if ($errors->has('mode'))
											<span class="help-block">
												<strong>{{ $errors->first('mode') }}</strong>
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
									
								
							<div class="nc-form row form-group{{ $errors->has('mode') ? ' has-error' : '' }}">
								<form method="POST" action="/developer/mode/add">
									{{ csrf_field() }}
									<div class="col-md-12">
										<h4><u>Add Mode:</u></h4>
									</div>
									 
									 
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="mode">Add New Mode:</label>
										<input type="text" class="form-control" name="mode" placeholder="Enter Mode" value="{{ old('mode') }}">
										@if ($errors->has('mode'))
											<span class="help-block">
												<strong>{{ $errors->first('mode') }}</strong>
											</span>
										@endif
									</div>								 
									 
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="" style="visibility:hidden">Submit:</label>
										<input type="submit" class="btn btn-info btn-block form-control" name="submit" value="Save">
									</div>
								</form>
							</div>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-modedetails">
                                <thead>
                                    <tr>
                                        <th>Mode</th>
										<th>Slug</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
										<th>Mode</th>
										<th>Slug</th>                                        
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

			<!-- Modal -->
			<div id="updateKeywordModal" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
					<form method="POST" action="/developer/keyword/update">
						<div class="form-group">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Update Keyword</h4>
							</div>
							<div class="modal-body">
								{{ csrf_field() }}
								<input type="hidden" name="id">
 
								
								<div class="col-md-3">
									 
								</div>
								
								<div class="col-md-3">
									<label>Select Child Category:</label>
									<select name="child_category_id" id="update_child_category_id" class="form-control select2-single" style="width:100%">
									</select>
								</div>
								
								<div class="col-md-3">
									<label>Enter Keyword:</label>
									<input type="text" class="form-control" id="update_keyword" name="keyword" placeholder="Enter Child Category">
								</div>
								
								<div class="col-md-3">
									<label>Select Category:</label>
									<select name="category" id="update_category" class="form-control select2-single category" style="width:100%">
										<option value="Category 1">Category 1</option>
										<option value="Category 2">Category 2</option>
										<option value="Category 3">Category 3</option>
										<option value="Category X">Category X</option>
									</select>
								</div>
								
								<div class="col-md-3 premium_price">
									<label>Premium Price:</label>
									<input type="number" class="form-control" id="update_premium_price" name="premium_price">
								</div>
								
								<div class="col-md-3 platinum_price">
									<label>Platinum Price:</label>
									<input type="number" class="form-control" id="update_platinum_price" name="platinum_price">
								</div>
								
								<div class="col-md-3 royal_price">
									<label>Royal Price:</label>
									<input type="number" class="form-control" id="update_royal_price" name="royal_price">
								</div>
								
								<div class="col-md-3 king_price">
									<label>King Price:</label>
									<input type="number" class="form-control" id="update_king_price" name="king_price">
								</div>
								
								<div class="col-md-3 preferred_price">
									<label>Preferred Price:</label>
									<input type="number" class="form-control" id="update_preferred_price" name="preferred_price">
								</div>
								<div class="clearfix"></div>
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
			<!-- deleteKeywordModal -->
			<div id="deleteClient" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
					</div>
				</div>
			</div>
			<!-- deleteKeywordModal -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>