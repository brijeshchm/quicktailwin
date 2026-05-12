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
                                <button type="button" class="btn btn-primary" style="color:#fff;margin-top:20px"><a href="{{url('developer/occupationAdd/add')}}" style="color:#fff"> <i class="fa fa-plus" aria-hidden="true"></i> Add Occupation</a></button>
                                 
                            
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
							<form class="occupation_form" method="post" onsubmit="return occupationController.saveOccupation(this)" autocomplete="off" enctype="multipart/form-data"> 

							@elseif(Request::segment(3)=='edit')

							<form class="occupation_form" method="post" autocomplete="off" action="" onsubmit="return occupationController.editSaveOccupation(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multipart/form-data">

							@endif
									{{ csrf_field() }}

									   
									<div class="col-lg-3">
										<label for="State">Occupation name:</label>
										
									<input type="text" class="form-control" name="name" placeholder="Enter Occupation Name" value="{{ old('name',(isset($edit_data)) ? $edit_data->name:"")}}">
										@if ($errors->has('name'))
											<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
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
								<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-occupation">
					 
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                        <th>Name</th>    
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
			<div id="msgModal" class="modal fade" role="dialog">
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
