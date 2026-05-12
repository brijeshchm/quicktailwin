
<?php echo View::make('admin/header'); ?>
 <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h5>Not Interested Leads</h5>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="alert alert-danger hide"></div>
					<div class="alert alert-success hide"></div>
					@if(Session::has('alert-success'))
						<div class="alert alert-success">{{Session::get('alert-success')}}</div>
					@endif
					     <div class="panel panel-info">
                        <div class="panel-body">
							<div class="nc-form row form-group">
							<form method="GET" action="/developer/new-lead" autocomplete="off">
									{{ csrf_field() }}
									 
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
											<label>Course</label>
											<select class="form-control course select2-single" name="search[course][]" multiple>
												<option value="">-- SELECT COURSE --</option>		 
												
												@if(count($kwds)>0)
												@if(isset($search['course']))
													@foreach($search['course'] as $value)
														{{--*/ $courseSelected[] = $value /*--}}
													@endforeach
												@endif
												@foreach($kwds as $kwd)
													@if(isset($courseSelected) && in_array($kwd->keyword,$courseSelected))
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
											<label>Lead Type</label>
											<select class="form-control course" name="search[lead_type]">
												<option value="" <?php echo (isset($search['lead_type'])&&$search['lead_type']=='')?"selected":""; ?>>-- SELECT LEAD TYPE --</option>
												<option value="0" <?php echo (isset($search['lead_type'])&&$search['lead_type']=='0')?"selected":""; ?>>Website</option>
												<option value="1" <?php echo (isset($search['lead_type'])&&$search['lead_type']=='1')?"selected":""; ?>>User Lead</option>
												<option value="2" <?php echo (isset($search['lead_type'])&&$search['lead_type']=='2')?"selected":""; ?>>Advertise</option>
												<option value="3" <?php echo (isset($search['lead_type'])&&$search['lead_type']=='3')?"selected":""; ?>>Lead Portal</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Assign Lead</label>
											<select class="form-control course" name="search[assign_status]">
												<option value="" <?php echo (isset($search['assign_status'])&&$search['assign_status']=='')?"selected":""; ?>>-- SELECT ASSIGN LEAD--</option>
												<option value="1" <?php echo (isset($search['assign_status'])&&$search['assign_status']=='1')?"selected":""; ?>>Assign Lead</option>
												<option value="0" <?php echo (isset($search['assign_status'])&&$search['assign_status']=='0')?"selected":""; ?>>Un Assign Lead </option>
												 
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Date From</label>
											<input type="text" class="form-control datef" name="search[datef]" value="{{ old('search[datef]',(isset($search['datef'])) ? $search['datef']:"")}}" placeholder="Create Date From">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Date To</label>
											<input type="text" class="form-control datet" name="search[datet]" value="{{ old('search[datet]',(isset($search['datet'])) ? $search['datet']:"")}}" placeholder="Create Date To">
										</div>
									</div>
										<div class="form-group">
									<div class="col-md-3">
										<label>Follow Up Date From</label>
										<input type="text" class="form-control expdf" name="search[expdf]" value="{{ old('search[expdf]',(isset($search['expdf'])) ? $search['expdf']:"")}}" autocomplete="off" placeholder="Follow Date From">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-3">
										<label>Follow Up Date To</label>
										<input type="text" class="form-control expdt" name="search[expdt]" value="{{ old('search[expdt]',(isset($search['expdt'])) ? $search['expdt']:"")}}" placeholder="Follow Date From">
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
						</div>
						<style>
						.check-box{
							height:18px;
							width:20px;
							cursor:pointer;
						}
						</style>
						<div class="table-responsive table-virtical-grid">
							 <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-lead-not-interested">
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                        <th>Name</th>
                                        <!--<th>Lead</th>-->
                                        <th>Mobile</th>
                                        <!--th>Email</th-->
                                        <th>Owner</th> 
                                        <!--<th>Remarks</th>-->
                                        <th>Status</th>
                                        <th>Course</th>
                                        <th>City</th>
										<th>Date</th>
										<!--<th>FollowUp Date</th>-->
                                        <th>Assign</th>
										<th>Push By</th>
                                       <!-- <th>Client</th>-->
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
										<th></th>
                                        <th>Name</th>
										<!--<th>Lead</th>-->
                                        <th>Mobile</th>
                                        <!--th>Email</th-->
										<th>Owner</th> 
                                       <!-- <th>Remarks</th>-->
                                        <th>Status</th>
                                        <th>Course</th>
                                        <th>City</th>
										<th>Date</th>
										<!--<th>FollowUp Date</th>-->
                                        <th>Assign</th>
										<th>Push By</th>
                                       <!-- <th>Client</th>-->
                                        <th>Action</th>
                                        
                                    </tr>
                                </tfoot>
                            </table>
							<form id="export-leads" method="POST" onsubmit="return exportNotLeads()" action="{{ url('/lead/getleadsexcelNotInterested') }}">
								{{ csrf_field() }}
								<input type="hidden" name="search[source]" value="">
								<input type="hidden" name="search[expdf]" value="">
								<input type="hidden" name="search[expdt]" value="">
								<input type="hidden" name="search[leaddf]" value="">
								<input type="hidden" name="search[leaddt]" value="">
								<input type="hidden" name="search[course]" value="">
								<input type="hidden" name="search[status]" value="">
								<input type="hidden" name="search[user]" value="">
								<input type="hidden" name="search[value]" value="">
								<input type="hidden" name="search[not_interested]" value="1">
								<!--<div class="form-group">
									<div class="col-md-2">
										<button type="button" class="btn btn-success btn-block bulk-sms" onclick="javascript:leadController.bulkSms()">Bulk SMS</button>
									</div>
								</div>-->
								<div class="form-group">
									<div class="col-md-2">
									    @if (Auth::user()->role =='administrator' )
										<button type="submit" class="btn btn-success btn-block export-leads">Export</button>
										@endif
									</div>
								</div>
							<div class="form-group">
								<div class="col-md-2">
								@if (Auth::user()->role =='super_admin' || Auth::user()->role =='administrator')
								 
								<button type="button" class="btn btn-success  btn-block move-not-interested" onclick="javascript:pushLeadController.moveToLeads()" >Move To Lead</button>
								@endif

								</div>
								</div>
								<div class="form-group">
								<div class="col-md-2">
								@if (Auth::user()->role =='administrator')
								 
								<button type="button" class="btn btn-success  btn-block" onclick="javascript:pushLeadController.selectDeleteParmanent()" >Delete Per</button>
								@endif

								</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
	 
		<style>
			#followUpModal .form-control{
				margin-bottom:10px;
			}
		</style>
		<div id="followUpModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Follow Up</h4>
					</div>
					<div class="modal-body" style="padding-top:0">
					</div>
					<!--div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div-->
				</div>

			</div>
		</div>
		<div id="bulkSmsModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Bulk SMS</h4>
					</div>
					<div class="modal-body">
						<textarea placeholder="Enter your custom message here..." id="bulkSmsControl" rows="10" class="form-control"></textarea>
						<div class="form-group" style="padding-top:20px;margin-bottom:0">
							<div class="col-md-3" style="margin:0 auto;float:none;">
								<button type="button" style="background-color:#169f85;color:#fff;" onclick="javascript:leadController.sendBulkSms()" class="btn btn-block">Submit</button>
							</div>
							<div class="clearfix"></div>
						</div>
						
					</div>
					<!--div class="modal-footer">
						<button type="button" class="btn btn-default" >Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div-->
				</div>

			</div>
		</div>
		
			<div id="lead-follow-modal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Follow Up</h4>
					</div>
					<div class="modal-body" style="padding-top:0">
					</div>
					 
				</div>

			</div>
		</div>
	</div>
	<!-- /page content -->
<?php echo View::make('admin/footer'); ?>