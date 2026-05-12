<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Parent Categories</h1>
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
							<div class="nc-form row form-group{{ $errors->has('parent_category') ? ' has-error' : '' }}">
								<form method="POST" action="/developer/parent_category" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="col-lg-4">
										<label for="parent_category">Add New Parent Category:</label>
										<input type="text" class="form-control" name="parent_category" id="parent_category" placeholder="Enter Parent Category" value="{{ old('parent_category') }}">
										@if ($errors->has('parent_category'))
											<span class="help-block">
												<strong>{{ $errors->first('parent_category') }}</strong>
											</span>
										@endif
									</div>
								
									<div class="col-lg-4">
										<label for="pc_icon">Category Banner</label>
										<input type="file" name="category_banner" class="form-control" />
										@if ($errors->has('category_banner'))
											<span class="help-block">
												<strong>{{ $errors->first('category_banner') }}</strong>
											</span>
										@endif
									
									</div>
									
										<div class="col-lg-4">
										<label for="pc_icon">Icon</label>
										<input type="file" name="category_icon" class="form-control" />
										@if ($errors->has('category_icon'))
											<span class="help-block">
												<strong>{{ $errors->first('category_icon') }}</strong>
											</span>
										@endif
									 	<input type="submit" class="btn btn-info btn-block" class="form-control" name="submit" style="margin-top:10px;">
									</div>
									
								</form>
							</div>
						 
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-categories">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                         <th>Category Banner</th>
                                        <th>Icon</th>
                                        <th>Form Type</th>
                                        <th>Sataus</th>

                                        <th>Action</th>
                                    
                                    </tr>
                                </thead>
                                </table>
                            
							 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

			<!-- Modal -->
		 
			<!-- Modal -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
