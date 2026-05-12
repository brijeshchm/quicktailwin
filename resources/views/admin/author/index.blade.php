<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
			<div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>{{$data['header']}}</h2>
                     
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <button type="button" class="btn btn-primary" style="color:#fff;margin-top:20px"><a href="{{url('developer/author/add')}}" style="color:#fff"> <i class="fa fa-plus" aria-hidden="true"></i> Add Author</a></button>
                                 
                            
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
                    <div class="panel panel-info">
                        <div class="panel-body">
						   @if(Request::segment(3)=='add'  || Request::segment(3)=='edit'  )
							<div class="nc-form row form-group{{ $errors->has('city') ? ' has-error' : '' }}">
							@if(Request::segment(3)=='add')
							<form class="city_form" method="post" onsubmit="return AuthorController.saveAuthor(this)" autocomplete="off" enctype="multipart/form-data"> 

							@elseif(Request::segment(3)=='edit')

							<form class="city_form" method="post" autocomplete="off" action="" onsubmit="return AuthorController.editSaveAuthor(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multipart/form-data">

							@endif
									{{ csrf_field() }}

									   
									<div class="col-lg-3">
										<label for="State">Name:</label>
										
									<input type="text" class="form-control" name="name" placeholder="Enter name" value="{{ old('title',(isset($edit_data)) ? $edit_data->name:"")}}">
										@if ($errors->has('name'))
											<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif	
									</div>			

									 
									

									
									<div class="col-lg-3">
										<label for="State">linkedin url:</label>
										
									<input type="text" class="form-control" name="linkedin_url" placeholder="Enter linkedin_url" value="{{ old('linkedin_url',(isset($edit_data)) ? $edit_data->linkedin_url:"")}}">
										@if ($errors->has('linkedin_url'))
											<span class="help-block">
												<strong>{{ $errors->first('linkedin_url') }}</strong>
											</span>
										@endif	
									</div>
									<div class="col-lg-3">
									 	<label for="pc_icon">Image</label>
									 	@if(!empty($edit_data->image))
										<?php 
									 
										$image = json_decode($edit_data->image);
										
										$image = $image->src;

										?>
										@if(isset($image)&&!empty($image))
										<img loading="lazy" src="{{url(''.$image)}}" style="height:75px;width:75px;">
										<a href="{{url('developer/author/del_img/'.$edit_data->id)}}" title="remove"><i class="fa fa-remove fa-trash" aria-hidden="true"></i></a>
										<input type="hidden" class="" name="image" value="{{ $edit_data->image }}" >
										
										@endif
										@else
											<input type="file" class="form-control" name="image">
										@endif
										
										@if ($errors->has('image'))
											<span class="help-block">
												<strong>{{ $errors->first('image') }}</strong>
											</span>
										@endif
										
									</div>			

									<div class="col-lg-12">
								<label for="State">Comment:</label>										
									<input type="text" class="form-control" name="comment" placeholder="Enter comment" row="5" value="{{ old('comment',(isset($edit_data)) ? $edit_data->comment:"")}}">
										@if ($errors->has('comment'))
											<span class="help-block">
												<strong>{{ $errors->first('comment') }}</strong>
											</span>
										@endif	
								</div>
																	
									<div class="col-lg-3">										 
										<input type="submit" class="btn btn-info btn-block" class="form-control" style="margin-top:25px;">
									</div>
								</form>
							</div>
						@else
						<div class="table">
								<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-author">
					 
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                        <th>Name</th>
                                        <th>Image</th>
										<th>Status</th> 
                                        <th>Action</th>
										 
                                    </tr>
                                </thead>
                               
                            </table>
                            <!-- /.table-responsive -->
												 
                        </div>
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
        </div>
        <!-- /#page-wrapper -->
 
<?php echo View::make('admin/footer'); ?>
