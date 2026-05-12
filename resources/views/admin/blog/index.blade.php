<?php echo View::make('admin/header'); ?>

       <div id="page-wrapper">
            <div class="row">
               <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2><a href="{{url('developer/blog/blogdetails')}}">Blog Details</a></h2>
                     
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <button type="button" class="btn btn-primary" style="color:#fff;margin-top:20px"><a href="{{url('developer/blog/addBlog')}}" style="color:#fff"> <i class="fa fa-plus" aria-hidden="true"></i> Add Blog</a></button>
                                 
                            
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                <!-- /.col-lg-12 -->
            </div>
			  <style>
/* ==== Custom Panel Section Styling ==== */
.section-border {
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 30px;
    background-color: #f9f9f9;
}

.section-border h4 {
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    margin: -25px -25px 20px -25px;
    border-radius: 10px 10px 0 0;
    font-size: 18px;
    font-weight: 600;
}

.section-border label {
    font-weight: 500;
}

.btn-primary {
    border-radius: 5px;
}
.panel-body{

padding:0px;
}
</style>
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
						   <div class="section-border"> 
						
					@if(Request::segment(3)=='editBlog' || Request::segment(3)=='addBlog'	)
				<div class=" row form-group{{ $errors->has('mode') ? ' has-error' : '' }}">
				@if(Request::segment(3)=='addBlog')
				<form method="POST" action="" class="form-horizontal" onsubmit="return blogController.saveBlog(this)" enctype="multipart/form-data">
				 
				@endif
						{{ csrf_field() }}

						<div class="form-group">
						<label for="name" class="col-md-2 control-label">Author</label>
						<div class="col-md-8">
							<select type="text" class="form-control" name="author" >
								<option value="">Select Author</option>
								@if($authors)
									@foreach($authors as $author)

									<option value="{{ $author->id}}" @if ($author->id== old('author'))
                    selected="selected"	
                    @else
                    {{ (isset($edit_data) && $edit_data->author ==$author->id ) ? "selected":"" }} @endif>{{ $author->name}}</option>
									@endforeach
									@endif
								

							</select>
							@if ($errors->has('author'))
								<span class="error alert-danger">
									<strong>{{ $errors->first('author') }}</strong>
								</span>
							@endif
						</div>
					</div>	
					<div class="form-group">
						<label for="name" class="col-md-2 control-label">Name</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="name" placeholder="Enter Bog Name" value="{{ old('name',(isset($edit_data)) ? $edit_data->name:"")}}">
							@if ($errors->has('name'))
								<span class="error alert-danger">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif
						</div>
					</div>			
					   <div class="form-group">
                    <label class="col-md-2 control-label">Title URL</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="title" value="{{ old('title',(isset($edit_data)) ? $edit_data->title:"")}}" placeholder="Enter Title">                     </div>
                </div>				
								
								<div class="form-group">
									<label for="meta_title" class="col-md-2 control-label">Meta Title</label>
									<div class="col-md-8">
										<textarea class="form-control" name="meta_title" placeholder="Enter Meta Title">{{ old('meta_title',(isset($edit_data)) ? $edit_data->meta_title:"")}}</textarea>
										@if ($errors->has('meta_title'))
											<span class="error alert-danger">
												<strong>{{ $errors->first('meta_title') }}</strong>
											</span>
										@endif
									</div>
								</div>
								 

								<div class="form-group">
									<label for="meta_keywords" class="col-md-2 control-label">Meta Keywords</label>
									<div class="col-md-8">
										<textarea class="form-control" name="meta_keywords" placeholder="Enter Meta Keywords">{{ old('meta_title',(isset($edit_data)) ? $edit_data->meta_keywords:"")}}</textarea>
										@if ($errors->has('meta_keywords'))
											<span class="error alert-danger">
												<strong>{{ $errors->first('meta_keywords') }}</strong>
											</span>
										@endif
									</div>
								</div>
								
								<div class="form-group">
									<label for="meta_description" class="col-md-2 control-label">Meta Description</label>
									<div class="col-md-8">
										<textarea class="form-control" name="meta_description" placeholder="Enter Meta Description">{{ old('meta_description',(isset($edit_data)) ? $edit_data->meta_description:"")}}</textarea>
										@if ($errors->has('meta_description'))
											<span class="error alert-danger">
												<strong>{{ $errors->first('meta_description') }}</strong>
											</span>
										@endif
									</div>
								</div>							 
								
						<div class="form-group">
								<label for="ratingValue" class="col-md-2 control-label">Rating Value</label>
								<div class="col-md-8">
								<select class="form-control" name="ratingvalue">
								<option value="">Select Rating Value</option>
								<?php 
								$rating = array(1,2,3,3.5,4,4.5,4.75,5);
								foreach($rating as $key=>$value){	
								?>
								<option value="<?php echo $value; ?>" @if ("$value"== old('ratingvalue'))
								selected="selected"	
								@else
								{{ (isset($edit_data) && $edit_data->ratingvalue ==$value ) ? "selected":"" }} @endif><?php echo $value; ?></option>
								<?php } ?>
								</select>
										
								</div>
							</div>

							<div class="form-group">
								<label for="ratingcount" class="col-md-2 control-label">Rating Count</label>
								<div class="col-md-8">								 
									<input type="number" class="form-control" name="ratingcount" value="{{ old('ratingcount', $edit_data->ratingcount ?? '') }}">
								</div>
							</div>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary" name="submit" value="{{$button}}">
											 Submit
										</button>
									</div>
								</div>
									 
								</form>
							</div>
							</div>
							@else
									
								 
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-blogdetails">
                                <thead>
                                    <tr>
                                        <th>Name</th>
										<th>Title</th>                                        
										<th>Image</th>                                        
										<th>Status</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
										<th>Name</th>
										<th>Title</th>                                        
										<th>Image</th>                                       
										<th>Status</th>                                       
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