<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Child Categories</h1>
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
							<div class="nc-form row form-group{{ $errors->has('child_category') ? ' has-error' : '' }}">
								<form method="POST" action="/developer/storeChildCategory" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="col-lg-4">
				<input type="hidden" name="id" value="{{$edit_data->id}}">
										<label for="parent_category_id">Select Parent Category:</label>
                                    <select class="form-control select2-single select_category" name="parent_category_id" >
                                    <option value=""></option>
                                    @if(!empty($parent_categories))
                                    @foreach($parent_categories as $category)
                                    <option value="{{$category->id}}" @if ($category->id== old('parent_category_id'))
                                    selected="selected"	
                                    @else
                                    {{ (isset($edit_data) && $edit_data->parent_category_id == $category->id ) ? "selected":"" }} @endif>{{$category->parent_category}}</option>
                                    @endforeach
                                    @endif
                                    </select>
									</div>
									 
									<div class="col-lg-4">
										<label for="child_category">Child Category:</label>
										<input type="text" class="form-control" name="child_category" id="child_category" placeholder="Enter Child Category" value="{{ old('child_category',(isset($edit_data)) ? $edit_data->child_category:"")}}">
										@if ($errors->has('child_category'))
											<span class="help-block">
												<strong>{{ $errors->first('child_category') }}</strong>
											</span>
										@endif										
									 
									</div>
										
										<div class="col-lg-4">
										<label for="icon">Icon:(65*65Pixels)</label>
										
										
										@if(!empty($edit_data->pc_icon))
										<?php 
									 
										$image = unserialize($edit_data->pc_icon);
										$image = $image['pc_icon']['src'];

										?>
										@if(isset($image)&&!empty($image))
										<img src="{{url(''.$image)}}" style="height:75px;width:75px;">
										<a href="{{url('developer/childCategory/del_icon/'.$edit_data->id)}}" title="remove"><i class="fa fa-remove fa-trash" aria-hidden="true"></i></a>
										<input type="hidden" class="" name="image" value="{{ $edit_data->pc_icon }}" >
										@endif
										@else
										<input type="file" class="form-control" name="pc_icon">
										
										
										@endif
										
									 
										@if ($errors->has('pc_icon'))
											<span class="help-block">
												<strong>{{ $errors->first('pc_icon') }}</strong>
											</span>
										@endif										
									
									</div>
									<div class="col-lg-6">
										<label for="icon">Child banner:(1170*165)</label>
										
										
										@if(!empty($edit_data->child_banner))
										<?php 
									 
										$image = unserialize($edit_data->child_banner);
										$image = $image['child_banner']['src'];

										?>
										@if(isset($image)&&!empty($image))
										<img src="{{url(''.$image)}}" style="height:75px;width:200px;">
										<a href="{{url('developer/childCategory/del_child_banner/'.$edit_data->id)}}" title="remove"><i class="fa fa-remove fa-trash" aria-hidden="true"></i></a>
										<input type="hidden" name="child_banner" value="{{ $edit_data->child_banner }}" >
											@endif
										@else
										<input type="file" class="form-control" name="child_banner">
																		
										@endif
										
									 
										@if ($errors->has('child_banner'))
											<span class="help-block">
												<strong>{{ $errors->first('child_banner') }}</strong>
											</span>
										@endif										
										 
									</div>
										<div class="col-lg-3">
									
										<input type="submit" class="btn btn-info btn-block" class="form-control" name="submit" style="margin-top:10px;">
										</div>
									
								</form>
							</div>
							
							  <!-- /.table-responsive -->
						
 
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
