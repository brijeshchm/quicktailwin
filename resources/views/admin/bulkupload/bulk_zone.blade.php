<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Bulk Upload - Zone</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
				<div class="row">
					<div class="col-md-2">
						<h3>Bulk Upload</h3>
						</div>
						<div class="col-md-5">
						<!-- <form  method="POST"  action="{{ url('/developer/bulkupload/downloadexcellead') }}">
								{{ csrf_field() }}
								 
								<div class="form-group">						 

								<button type="submit" class="btn-success  btn-block download-excel-formate">Download Excel Format</button>
										
								 
								</div>
						</form> -->
						
					</div>
				</div>
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
					<form class="form-horizontal" action="{{ url('developer/bulkupload/zone') }}" method="POST" enctype="multipart/form-data">
						{{csrf_field()}}
						 
							 
						<div class="form-group">
							<label class="control-label col-sm-2" for="">Upload Excel: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							<div class="col-sm-4"> 
								<input type="file" class="form-control" value="" name="upload_file"  required>
							</div>
						</div>
						<div class="form-group"> 
							<div class="col-sm-offset-0 col-sm-4 text-right">
								<input type="submit" name="upload_submit" value="Upload" class="btn btn-warning">
							</div>
						</div>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			 
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
