<?php echo View::make('admin.header'); ?>
	<!-- page content -->
    <div id="page-wrapper">
	     <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Permission</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
		<div class="">		 
			<div class="clearfix"></div>
			<div class="row">
			 <div class="col-md-12">
					<div class="alert alert-danger hide"></div>
					<div class="alert alert-success hide"></div>
					 @foreach (['danger', 'warning', 'success', 'info'] as $msg)
								@if(Session::has('alert-' . $msg))
									<div class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
								@endif
							@endforeach
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h4><small style="color:red">(Please use underscore inspite of space)</small></h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<br />
							<form class="form-horizontal form-label-left" action="#" method="POST" onsubmit="return permissionController.submit(this)">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<input type="text" class="form-control" name="permission" autocomplete="off">
									</div>
								</div>
								<div class="ln_solid"></div>
								<div class="form-group">
									<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
										<button type="reset" class="btn btn-primary">Reset</button>
										<button type="submit" class="btn btn-success">Submit</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-8 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Permission List</h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<table id="datatable-permission" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Name</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->

<?php echo View::make('admin.footer'); ?>