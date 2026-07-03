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
                             
                                 
                            
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
                    <div class="panel panel-info">
                        <div class="panel-body">
						   @if(Request::segment(3)=='view'  )
							<div class="nc-form row form-group{{ $errors->has('city') ? ' has-error' : '' }}">
						 

						 
									   
	                                <div class="col-lg-3">
										<label for="State">Name:</label>
										{{ ((isset($edit_data)) ? $edit_data->name:"") }}
									 
									</div>		

									<div class="col-lg-3">
										<label for="State">Email:</label>
										{{ ((isset($edit_data)) ? $edit_data->email:"") }}
									 
									</div>	
                                    
                                    
                                    <div class="col-lg-3">
										<label for="State">Mobile:</label>
										{{ ((isset($edit_data)) ? $edit_data->mobile:"") }}
									 
									</div>	



                                    <div class="col-lg-3">
										<label for="State">Subject:</label>
										{{ ((isset($edit_data)) ? $edit_data->subject:"") }}
									 
									</div>	



																	
								 
								</form>
							</div>
						@else
						<div class="table">
								<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-contacts">
					 
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                        <th>Name</th>
                                        <th>Email</th>
										<th>mobile</th> 
										<th>Subject</th> 
										<th>Message</th> 
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
