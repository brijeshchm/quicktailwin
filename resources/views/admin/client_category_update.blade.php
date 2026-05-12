<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Client Category Update</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
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
					<div class="col-md-4">
						<form class="update_client_category" method="POST" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label for="">Name: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
								<input type="text" class="form-control" value="{{ $client_category->name }}" name="client_category_name">
							</div>
							<div class="form-group">
								<label for="">Image: </label>
								<input type="file" class="form-control" name="client_category_image">
							</div>
							<div class="form-group">
								<input type="submit" name="add_client_category" value="Update" class="btn btn-warning">
								<input type="reset" name="reset_client_category" value="Reset" class="hide">
							</div>
						</form>
					</div>
					<?php if(!empty($client_category->image)): ?>
					<div class="col-md-8">
						<?php
							$image = unserialize($client_category->image);
						?>
						<img src="<?php echo url($image['large']['src']); ?>" class="img-responsive" />
					</div>
					<?php endif; ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
