<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">				
                    <h1 class="page-header">Distinct Keywords For SEO</h1>
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
					@if(Session::has('danger_msg'))
						<div class="alert alert-danger">
							{{Session::get('danger_msg')}}
						</div>
					@endif					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Distinct Keywords List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="datatable-seo" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Keyword</th>
											<th>Meta Title</th>
											<th>Meta Keywords</th>
											<th>Meta Description</th>
											<th>Action</th>
											<th>Signal</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Keyword</th>
											<th>Meta Title</th>
											<th>Meta Keywords</th>
											<th>Meta Description</th>
											<th>Action</th>
											<th>Signal</th>
										</tr>
									</tfoot>
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
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>