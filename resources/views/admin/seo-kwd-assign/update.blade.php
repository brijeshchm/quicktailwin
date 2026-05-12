
<?php echo View::make('admin/header'); ?>
	<!-- page content -->
	 <div id="page-wrapper">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Update - {{$edit_seoKwdAssign->seo_id}}</h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-info">
						<div class="x_title">
							@foreach (['danger', 'warning', 'success', 'info'] as $msg)
								@if(Session::has('alert-' . $msg))
									<div class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
								@endif
							@endforeach
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							<h2>Update Form <small>(Update Permission)</small></h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<br />
							<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="/developer/seo-kwd-assign/update/<?php echo $id;?>">
									{{ csrf_field() }}
								<div class="form-group">
									<label class="col-xs-12" for="role">Role <span class="required">*</span></label>
									<div class="col-xs-5">									 

									 <select class="form-control select2-single" name="seo_id">
									<option value="">Select User</option>
									@if(!empty($users))
									@foreach($users as $user)
									<option value="{{$user->id}}" @if ($user->id== old('seo_id'))
									selected="selected"
										@else
									{{ (isset($edit_seoKwdAssign) && $edit_seoKwdAssign->seo_id == $user->id ) ? "selected":"" }} @endif>{{ $user->first_name}} {{ $user->last_name}}</option>

									@endforeach
									@endif
										</select>
										 
									</div>
									
								</div>
								<div class="form-group">
									<label class="col-xs-12" for="name">Permission <span class="required"></span></label>
									<div class="col-xs-5">
									<select id="source" class="form-control" multiple style="height:200px;">
											<?php echo $usersAssigns['sourcePermissions']; ?>
										</select>
									</div>
									<div class="col-xs-2 text-center" style="margin:10px 0;">
										<input type='button' id='btnAllRight' value='>>'>
										<input type='button' id='btnRight' value='>'>
										<input type='button' id='btnLeft' value='<'>
										<input type='button' id='btnAllLeft' value='<<'>
									</div>
									<div class="col-xs-5">
										<select id="destination" name="kwd_assign[]" class="form-control" multiple style="height:200px;">
											<?php echo $usersAssigns['destinationPermissions']; ?>
										</select>
									</div>
								</div>
								
								
							 
								<div class="ln_solid"></div>
								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
										<button type="submit" class="btn btn-success">Submit</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->

<?php echo View::make('admin/footer'); ?>