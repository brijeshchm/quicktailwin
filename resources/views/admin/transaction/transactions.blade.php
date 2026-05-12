<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Transactions</h1>
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
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-all-transactions">
                                <thead>
                                    <tr>
                                        <th>ClientID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Key</th>
                                        <th>Value</th>
                                        <th>Date</th>
										<th>Action</th>
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
                                        <th>ClientID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Key</th>
                                        <th>Value</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- /.table-responsive -->
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
