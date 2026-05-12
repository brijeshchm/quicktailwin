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
                                <button type="button" class="btn btn-primary" style="color:#fff;margin-top:20px"><a href="{{url('developer/form-type/add')}}" style="color:#fff"> <i class="fa fa-plus" aria-hidden="true"></i> Add Form Type</a></button>
                                 
                            
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
							<form class="form_type" method="post" onsubmit="return formTypeController.saveFormType(this)" autocomplete="off" enctype="multipart/form-data"> 

							@elseif(Request::segment(3)=='edit')

							<form class="form_type" method="post" autocomplete="off" action="" onsubmit="return formTypeController.editSaveFormType(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multipart/form-data">

							@endif
									{{ csrf_field() }}
									   
									<div class="col-lg-3">
										<label for="State">Form Type:</label>
										
									<input type="text" class="form-control" name="form_type" placeholder="Enter Form type" value="{{ old('form_type',(isset($edit_data)) ? $edit_data->form_type:"")}}">
										@if ($errors->has('form_type'))
											<span class="help-block">
												<strong>{{ $errors->first('form_type') }}</strong>
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
								<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-form-type">
					 
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                        <th>Form Type</th>
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
