<?php echo View::make('admin/header'); ?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">All Clients</h1>
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
			@if(Session::has('danger'))
				<div class="alert alert-danger">
					{{Session::get('danger')}}
				</div>
			@endif					
			<div class="panel panel-info">
				<div class="panel-body">
					<div class="nc-form row form-group">
						<form method="GET" action="/developer/clients/list" autocomplete="off">
							{{ csrf_field() }}
							<div class="form-group">
								<div class="col-md-3">
									 
									<label>Client Type</label>
									<select class="form-control" name="search[client_type]">											 
									<?php $clientsType = getClientsType(); ?>
										@if(count($clientsType)>0)
											@foreach($clientsType as $key=>$value)
												@if(isset($search['client_type']) && $search['client_type']==$key)
													<option value="{{ $key }}" selected>{{ $value }}</option>
												@else
													<option value="{{ $key }}">{{ $value }}</option>
												@endif
											@endforeach
										@endif
											 
									</select>
								</div>
							</div>
							<div class="form-group">
							 
								<div class="col-md-3">
									<label>City</label>
									<select class="form-control select2-single-city" name="search[city][]" multiple>
										<option value="">-- SELECT CITY --</option>
										@if(count($citylist)>0)
												@if(isset($search['city']))
													@foreach($search['city'] as $value)
														{{--*/ $citySelected[] = $value /*--}}
													@endforeach
												@endif
												@foreach($citylist as $city)
													@if(isset($citySelected) && in_array($city->city,$citySelected))
														<option value="{{ $city->city }}" selected>{{ $city->city }}</option>
													@else
														<option value="{{ $city->city }}">{{ $city->city }}</option>
													@endif
												@endforeach
											@endif
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label>Date From</label>
									<input type="text" class="form-control datef" name="search[datef]" value="{{ old('search[datef]',(isset($search['datef'])) ? $search['datef']:"")}}" placeholder="Date From">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label>Date To</label>
									<input type="text" class="form-control datet" name="search[datet]" value="{{ old('search[datet]',(isset($search['datet'])) ? $search['datet']:"")}}" placeholder="Date To">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label>Client Category</label>
									<select class="form-control client_category" name="search[client_category]">
										<option value="">-- SELECT CLIENT CATEGEORY --</option>
										@if(count($clientCategories)>0)
											@foreach($clientCategories as $clientCategory)
												@if(isset($search['client_category']) && $search['client_category']==$clientCategory->id)
													<option value="{{ $clientCategory->id }}" selected>{{ $clientCategory->parent_category }}</option>
												@else
													<option value="{{ $clientCategory->id }}">{{ $clientCategory->parent_category }}</option>
												@endif
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label>Paid/Unpaid</label>
									<select class="form-control" name="search[paid_status]">									
										<option value="" <?php echo (isset($search['paid_status'])&&$search['paid_status']=='')?"selected":""; ?>>-- Paid/UnPaid Status--</option>
												<option value="1" <?php echo (isset($search['paid_status'])&&$search['paid_status']=='1')?"selected":""; ?>>Paid</option>
												<option value="0" <?php echo (isset($search['paid_status'])&&$search['paid_status']=='0')?"selected":""; ?>>Unpaid</option>
									</select>
								</div>
							</div>
							<div class="form-group">
									<div class="col-md-3">
									<label>Select User</label>
									<select class="form-control select2-single" name="search[user]">
									<option value="">Select User</option>
									<?php $getUserList = getUserList(); ?>
									@if(isset($getUserList))
									@foreach($getUserList as $counsellor)
									@if(isset($search['user']) && $search['user']==$counsellor->id)
									<option value="{{ $counsellor->id }}" selected>{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
									@else
									<option value="{{$counsellor->id}}"  >{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
									@endif
									@endforeach
									@endif
									</select>
									</div>
							</div>
							<div class="form-group">
								<div class="col-lg-3">
								<label for="keyword">Keyword:</label>
								<input type="text" class="form-control" name="search[keyword]" placeholder="Search keyword" value="{{ old('search[keyword]',(isset($search['keyword'])) ? $search['keyword']:"")}}">
							</div>
							</div> 
							
							
							<div class="form-group">
								<div class="col-md-3">
									<label style="visibility:hidden">Filter</label>
									<button type="submit" class="btn btn-block btn-info" >Filter</button>
								</div>
							</div>
						
							
							
							<!--div class="col-lg-2">
								<label for="uid">User ID:</label>
								<input type="text" class="form-control" name="uid" placeholder="" value="{{ $request->input('uid') }}">
							</div>
							<div class="col-lg-2">
								<label for="b_name">Business Name:</label>
								<input type="text" class="form-control" name="b_name" placeholder="" value="{{ $request->input('b_name') }}">
							</div>
							<div class="col-lg-2">
								<label for="email">Email:</label>
								<input type="text" class="form-control" name="email" placeholder="" value="{{ $request->input('email') }}">
							</div>
							<div class="col-lg-2">
								<label for="mobile">Mobile:</label>
								<input type="text" class="form-control" name="mobile" placeholder="" value="{{ $request->input('mobile') }}">
							</div>
							<div class="col-lg-2">
								<label for="" style="visibility:hidden">submit</label>
								<input type="submit" name="filter" class="btn btn-info btn-block" class="form-control">
							</div-->
							
							
							
							
							
							
						</form>
					</div>
					<?php //if(isset($clients) && count($clients)>0): ?>
					   <div class="table-responsive table-virtical-grid">
					<table width="100%" class="table table-bordered table-hover table-striped" id="datatable-clients">
						<thead>
							<tr>
								<th>User_ID</th>
								<th>Business_Name</th>
								
								<th>Name</th>
								<th>City</th>
								<th>Email</th>
								<th>Mobile</th>
								<!--<th>Keyword</th>-->
								<th>Leads</th>							
								<th>Created at</th>
								<th>Created by</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
					</div>
					<!-- /.table-responsive -->
					<form id="export-clients" method="POST" onsubmit="return exportClients()" action="{{ url('/developer/clients/list/getclientsexcel') }}">
						{{ csrf_field() }}
						<input type="hidden" name="search[client_type]" value="">
						<input type="hidden" name="search[city]" value="">
						<input type="hidden" name="search[datef]" value="">
						<input type="hidden" name="search[datet]" value="">
						<input type="hidden" name="search[client_category]" value="">
						<input type="hidden" name="search[paid_status]" value="">
						<input type="hidden" name="search[user]" value="">
						 
						 
						<div class="form-group">
							
							<div class="col-md-3">
								<div class="row">
									<button type="submit" class="btn btn-success btn-block export-clients">Export</button>
								</div>
							</div>
							
						</div>
					</form>
					
					<?php //else: ?>
					<!--div class="alert alert-danger">
						Client(s) Not Found !!
					</div-->
					<?php //endif; ?>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->

	<!-- Modal -->
	<div id="updateKeywordSellCountModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-sm">

		<!-- Modal content-->
		<div class="modal-content">
			<form method="POST" action="/developer/keyword_sell_count/update">
			<div class="form-group">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					{{ csrf_field() }}
					<input type="hidden" name="id">
					
					<label style="margin-top:34px;">Keyword Category:</label>
					<input type="text" class="form-control" name="name">
					<label style="margin-top:34px;">Keyword Category Count:</label>
					<input type="number" class="form-control" name="count">
					<label style="margin-top:34px;">Keyword Category 1 Price:</label>
					<input type="number" class="form-control" name="cat1_price" placeholder="0">
					<label style="margin-top:34px;">Keyword Category 2 Price:</label>
					<input type="number" class="form-control" name="cat2_price" placeholder="0">
					<label style="margin-top:34px;">Keyword Category 3 Price:</label>
					<input type="number" class="form-control" name="cat3_price" placeholder="0">
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info">Update</button>
				</div>
			</div>
			</form>
		</div>

		</div>
	</div>
	<!-- Modal -->
	<!-- deleteClientModal -->
	<div id="deleteClient" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			</div>
		</div>
	</div>
	<!-- deleteClientModal -->
</div>
<!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
