<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Client Category</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
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
					<div class="col-md-4">
						<form class="add_client_category" onsubmit="return clientCategory.addClientCategory(this)" action="{{ url('developer/clients/add_client_category') }}" method="POST" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label for="">Name: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
								<input type="text" class="form-control" value="" name="client_category_name">
							</div>
							<div class="form-group">
								<label for="">Image: </label>
								<input type="file" class="form-control" name="client_category_image">
							</div>
							<div class="form-group">
								<input type="submit" name="add_client_category" value="Submit" class="btn btn-warning">
								<input type="reset" name="reset_client_category" value="Reset" class="hide">
							</div>
						</form>
					</div>
					<div class="col-md-8">
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Image</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
								@if(count($clientCategories)>0)
									@foreach($clientCategories as $clientCategory)
										<tr>
											<td>{{$clientCategory->id}}</td>
											<td>{{$clientCategory->name}}</td>
											<td>
												<?php
													if(!empty($clientCategory->image)){
														echo '<i class="fa fa-check" style="color:green" aria-hidden="true"></i>';
													}else{
														echo '<i class="fa fa-times" style="color:red" aria-hidden="true"></i>';
													}
												?>
											</td>
											<td><a href="/developer/clients/categories/update/{{$clientCategory->id}}"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a></td>
											<td><a href="javascript:void(0)" onclick="return clientCategory.deleteClientCategory(<?php echo $clientCategory->id;?>,this)"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
