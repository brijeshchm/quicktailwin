<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Follow Up Client</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-info">
						<div class="panel-body">
							<div class="nc-form row form-group">
								<form method="GET" action="/developer/clients/meetings" autocomplete="off">
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
												@if(count($citieslist)>0)
												@if(isset($search['city']))
													@foreach($search['city'] as $value)
														{{--*/ $citySelected[] = $value /*--}}
													@endforeach
												@endif
												@foreach($citieslist as $city)
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
											<label>Status</label>
											<select class="form-control select2-single" name="search[status][]" multiple>
												<option value="">-- SELECT STATUS --</option>
												@if(count($statuses)>0)
												@if(isset($search['status']))
													@foreach($search['status'] as $value)
														{{--*/ $statusSelected[] = $value /*--}}
													@endforeach
												@endif
												@foreach($statuses as $status)
													@if(isset($statusSelected) && in_array($status->id,$statusSelected))
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
											<label>Date Followup From</label>
											<input type="text" class="form-control datef" name="search[datef]" value="{{ old('search[datef]',(isset($search['datef'])) ? $search['datef']:"")}}" placeholder="Enter Followup Date From">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Date Followup To</label>
											<input type="text" class="form-control datet" name="search[datet]" value="{{ old('search[datet]',(isset($search['datet'])) ? $search['datet']:"")}}" placeholder="Enter Followup Date To">
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
										<div class="col-md-3">
											<label style="visibility:hidden">Filter</label>
											<button type="submit" class="btn btn-block btn-info">Filter</button>
										</div>
									</div>
								</form>
							</div>
							<div class="table-responsive">
								<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-meetings">
									<thead>
										<tr>
											<th>UID</th>
											<th>Business Name</th>
											<th>City</th>
											<th>Date &amp; Time</th>
											<th>Status</th>
											<th>Comment</th>
											<th>lead</th>
											<th>Created by</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>UID</th>
											<th>Business Name</th>
											<th>City</th>
											<th>Date &amp; Time</th>
											<th>Status</th>
											<th>Comment</th>
											<th>lead</th>
											<th>Created by</th>
											<th>Action</th>
										</tr>
									</tfoot>
								</table>
							</div>
							<!-- /.table-responsive -->
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
			</div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
<?php echo View::make('admin/footer'); ?>		