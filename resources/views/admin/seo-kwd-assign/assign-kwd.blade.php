
<?php echo View::make('admin/header'); ?>
	<!-- page content -->
 <div id="page-wrapper">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>SEO Assign Keyword</h3>
				</div>
			</div>
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
				 
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Assign Keyword List</h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<table id="datatable-assign-kwd-team" class="table table-striped table-bordered">
								<thead>
									<tr>
									 
										<th>kwd assign</th>
										 
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

<?php echo View::make('admin/footer'); ?>