<?php echo View::make('admin/header');
 
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Icons</h1>
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
							<div class="nc-form row form-group">
								<form method="POST" onsubmit="return assignedKeywordController.keywordIconUpdate(this,<?php echo $edit_data->id ?>)" class="ng-pristine ng-valid" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="col-md-12">
										<h4><u>Update Keyword:</u></h4>
									</div>				
									  
								  
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="icon">Icon:</label>
										<?php
										if(isset($edit_data) && $edit_data->icon !=''){
										$data = json_decode($edit_data->icon, true);
										 ?>
										 <img loading="lazy" src="<?php echo asset($data['src'])?>" width="100px" >
										<a href="/developer/keyword/icon_del/{{$edit_data->id}}" class="btn btn-inverse btn-circle m-b-5"><i class="fa fa-trash" aria-hidden="true" style="color:red"></i></a>
										<input type="hidden" class="" name="icon_del" value="{{ $edit_data->icon }}" >										
										<?php  }else{ ?>
									 
										<input type="file" class="form-control" name="icon" placeholder="Enter Icon" accept=".jpeg,.jpg,.png,.svg,.webp">
									 
										<?php  } ?>
										@if ($errors->has('icon'))
											<span class="help-block">
												<strong>{{ $errors->first('icon') }}</strong>
											</span>
										@endif
									</div>
									 
									
							 
									
									
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="" style="visibility:hidden">Submit:</label>
										<input type="submit" class="btn btn-info btn-block form-control">
									</div>
								</form>
							</div>
						 
							 
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
