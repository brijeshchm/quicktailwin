<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Push Leads</h1>
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
							<style>
								.btn-danger,.btn-success{
									margin:5px 0;
								}
							</style>
							<div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-push-leads">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Lead</th>
                                        <th>Mobile</th>
                                        <!--th>Email</th-->
                                        <th>Owner</th>
                                        <!--<th>Source</th>-->
                                        <th>Area</th>
                                        <th>Course</th>
                                        <th>City</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
								 
                            </table>
							</div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<!-- deleteClientModal -->
			<div id="deleteClient" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
					</div>
				</div>
			</div>
			<!-- deleteClientModal -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
