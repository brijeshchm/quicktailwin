<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Bulk Upload - Keywords</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
				<div class="row">
					<div class="col-md-2">
						<h3>Bulk Upload</h3>
						</div>
						<div class="col-md-5">
						<form  method="POST"  action="{{ url('/developer/bulkupload/downloadexcelformate') }}">
								{{ csrf_field() }}
								 
								<div class="form-group">						 

								<button type="submit" class="btn-success  btn-block download-excel-formate">Download Excel Format</button>
										
								 
								</div>
						</form>
						
					</div>
				</div>
            <div class="row">
                <div class="col-lg-12">
				
					@if(count($errors)>0)
						
						<!--div class="alert alert-danger">
							@foreach($errors->all() as $error)
							{{ $error }}.<br>
							@endforeach 
						</div-->
					@endif
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
					<form class="form-horizontal" action="{{ url('developer/bulkupload/keyword') }}" method="POST" enctype="multipart/form-data">
						{{csrf_field()}}
						<div class="form-group">
							<label class="control-label col-sm-2" for="">Upload Excel: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							<div class="col-sm-4"> 
								<input type="file" class="form-control" value="" name="upload_file">
							</div>
						</div>
						<div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-4 text-right">
								<input type="submit" name="upload_submit" value="Upload" class="btn btn-warning">
							</div>
						</div>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="row">
 <div class="col-lg-6">
			<form method="POST" action="{{ url('/developer/keyword/getparentcategory') }}">
			{{ csrf_field() }}
			 
			<div class="form-group">
			<div class="col-md-4">
			<div class="row">
			<button type="submit" class="btn btn-success btn-block export-clients">Parent Category Export</button>
			</div>
			</div>
			</div>
			</form>
            <!-- /.row -->
        </div>
	 <div class="col-lg-6">
			<form method="POST" action="{{ url('/developer/keyword/getchildcategory') }}">
			{{ csrf_field() }}
			 
			<div class="form-group">
			<div class="col-md-4">
			<div class="row">
			<button type="submit" class="btn btn-success btn-block export-clients">Child Category Export</button>
			</div>
			</div>
			</div>
			</form>
            <!-- /.row -->
        </div>
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
