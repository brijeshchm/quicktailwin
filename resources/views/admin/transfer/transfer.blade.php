<?php echo View::make('admin/header'); ?>
	<!-- page content -->
    <div id="page-wrapper">
		<div class="">
			<div class="page-title">
				<div class="title_left">
					<h3>Transfer (Leads)</h3>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					 
					 @foreach (['danger', 'warning', 'success', 'info'] as $msg)
								@if(Session::has('alert-' . $msg))
									<div class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
								@endif
								@endforeach
						
					@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<div class="x_panel">
						<div id="leads_filter" class="col-md-12" style="border-bottom:2px solid #E6E9ED;margin-bottom:10px;padding-bottom:10px;">
							<form method="POST" action="/developer/permanent-transfer" novalidate autocomplete="off">
							    {{ csrf_field() }}
								<div class="form-group">
									<div class="col-md-3">
										<label>Transfer Parmanently <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<select class="form-control" name="transfer">
											<option value="">Select Transfer</option>
											<option value="all_leads">All Leads</option>									 
											 										 
										</select>
									</div>
								</div>
								
								@if(count($users)>0)
								<div class="form-group">
									<div class="col-md-3">
										<label>From Owner <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<select class="form-control" name="transfer_from">
											<option value="">-- SELECT USER --</option>
												@foreach($users as $user)
													@if(isset($search['user']) && $search['user']==$user->id)
														<option value="{{ $user->id }}" selected>{{ $user->first_name }} {{ $user->last_name }}</option>
													@else
														<option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
													@endif
												@endforeach
										</select>
									</div>
								</div>
								@endif
								@if(count($users)>0)
								<div class="form-group">
									<div class="col-md-3">
										<label>To New Owner <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<select class="form-control" name="transfer_to">
											<option value="">-- SELECT USER --</option>
												@foreach($users as $user)
													@if(isset($search['user']) && $search['user']==$user->id)
														<option value="{{ $user->id }}" selected>{{ $user->first_name }} {{ $user->last_name }}</option>
													@else
														<option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
													@endif
												@endforeach
										</select>
										
									</div>
								</div>
								@endif
								
								<div class="form-group">
										<div class="col-md-3">
											<label>Course</label>
											<select class="form-control course select2-single" name="course[]" multiple>
												<option value="">-- SELECT COURSE --</option>		 
												
												@if(count($keyword)>0)
												@if(isset($search['course']))
													@foreach($search['course'] as $value)
														{{--*/ $courseSelected[] = $value /*--}}
													@endforeach
												@endif
												@foreach($keyword as $kwd)
													@if(isset($courseSelected) && in_array($kwd->id,$courseSelected))
														<option value="{{ $kwd->keyword }}" selected>{{ $kwd->keyword }}</option>
													@else
														<option value="{{ $kwd->keyword }}">{{ $kwd->keyword }}</option>
													@endif
												@endforeach
											@endif
											</select>
										</div>
									</div>
									<div class="form-group">
									<div class="col-md-3">
										<label>Status</label>
										<select class="form-control select2-single" name="status[]" multiple>
											<option value="">-- SELECT STATUS --</option>
											@if(!empty($statuss))
												@foreach($statuss as $status)
													@if(isset($search['status']) && $search['status']==$status->id)
														<option value="{{ $status->id }}" selected>{{ $status->name }}</option>
													@else
														<option value="{{ $status->id }}">{{ $status->name }}</option>
													@endif
												@endforeach
											@endif
										</select>
									</div>
								</div> 
								<div class="form-group">
									<div class="col-md-3">
										<label>From Date</label>
										<input type="text" class="form-control leaddf" name="leaddf" autocomplete="off" placeholder="Enter Create Date From">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-3">
										<label>To Date</label>
										<input type="text" class="form-control leaddt" name="leaddt" autocomplete="off" placeholder="Enter Create Date To">
									</div>
								</div>
							 
						  
								
								 <div class="form-group">
									<div class="col-md-3">
										<label style="visibility:hidden">Filter</label>
										<button type="submit" class="btn btn-block btn-info">Transfer</button>
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