<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Search Client</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					@if(count($errors)>0)
						<div class="alert alert-danger">
							@foreach($errors->all() as $error)
							{{ $error }}.<br>
							@endforeach 
						</div>
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
					<form class="form-horizontal" action="{{ url('developer/clients/list') }}" method="GET">
						{{csrf_field()}}
						<div class="form-group">
							<label class="control-label col-sm-2" for="uid">User ID: </label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" value="{{ old('uid') }}" name="uid">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="b_name">Business Name: </label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" name="b_name" value="{{ old('b_name') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Email: </label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="mobile">Mobile: </label>
							<div class="col-sm-4"> 
								<input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
							</div>
						</div>
						<div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-4 text-right">
								<input type="submit" name="filter" value="Submit" class="btn btn-warning">
							</div>
						</div>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
