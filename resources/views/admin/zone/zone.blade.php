<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Zone</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<div class="alert alert-success hide"></div>
					<div class="alert alert-danger hide"></div>
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
							<div class="nc-form row form-group{{ $errors->has('city') ? ' has-error' : '' }}">
								<form method="POST" action="#" onsubmit="return zoneController.submit(this)">
									{{ csrf_field() }}
									<div class="col-lg-4 text-right">
										<label for="">City:</label>
										<select name="city_id" class="form-control"></select>
									</div>
									<div class="col-lg-4 text-right">
										<label for="">Enter zone here:</label>
										<input type="text" class="form-control" name="zone" placeholder="Enter City Zone">
										<button type="reset" class="btn btn-primary" style="margin-top:10px;">Reset</button>
										<input type="submit" class="btn btn-info" value="Submit" style="margin-top:10px;">
									</div>
								</form>
							</div>
							<div class="table-responsive">
								<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-zone">
									<thead>
										<tr>
											<th>Zone</th>
											<th>City</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
								<!-- /.table-responsive -->								
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
