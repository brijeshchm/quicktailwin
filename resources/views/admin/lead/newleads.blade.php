<?php echo View::make('admin/header'); ?>
<style>

	.assign-elements{
		list-style-type: none;
	}
	.assign-elements ul li{
padding: 5px;

	}
	.dropdown-menu-right li{
			list-style-type: circle;
	}
</style>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h5>New Leads</h5>
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
											<label>Service</label>
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
											<?php $leadFilterstatus = leadFilterstatus(); ?>
											@if(count($leadFilterstatus)>0)
												@if(isset($search['status']))
													@foreach($search['status'] as $value)
														{{--*/ $statusSelected[] = $value /*--}}
													@endforeach
												@endif
												@foreach($leadFilterstatus as $status)
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
										<label>Call Date From</label>
										<input type="text" class="form-control calldf" name="search[calldf]" value="{{ old('search[calldf]',(isset($search['calldf'])) ? $search['calldf']:"")}}" placeholder="Call Date From">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-3">
										<label>Call Date To</label>
										<input type="text" class="form-control calldt" name="search[calldt]" value="{{ old('search[calldt]',(isset($search['calldt'])) ? $search['calldt']:"")}}" placeholder="Call Date To">
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
							  <div class="table-responsive table-virtical-grid">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-new-leads">
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                        <th>Name</th>
                                        <th>Lead</th>
                                        <th>Mobile</th>
                                        <!--th>Email</th-->
                                        <!--<th>Owner</th> -->
                                        <!--<th>Remarks</th>-->
                                        <th>Status</th>
                                        <th>Service</th>
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
                                        <th>Service</th>
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
							</div>
                            <!-- /.table-responsive -->
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('export_lead'))
							<form id="export-leads" method="POST" onsubmit="return exportLeads()" action="{{ url('/developer/lead/getleadssexcel') }}">
								{{ csrf_field() }}
								<input type="hidden" name="search[city]" value="" multiple>
								<input type="hidden" name="search[course]" value="" >
								<input type="hidden" name="search[status]" value="" >
								<input type="hidden" name="search[datef]" value="">
								<input type="hidden" name="search[datet]" value="">
								<input type="hidden" name="search[assign_status]" value="">
								<input type="hidden" name="search[user]" value="">
								<input type="hidden" name="search[lead_type]" value="">
								<input type="hidden" name="search[value]" value="">
								<div class="form-group">
									<div class="col-md-2">
									 
											<button type="submit" class="btn btn-success btn-block export-clients">Export</button>
										 
									</div>
								</div>
															
									 
							</form>
							@endif
							
							
							<div class="form-group">
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('assign_lead_to_client'))
							<div class="col-md-2">

							<button type="submit" class="btn btn-success btn-block" onclick="javascript:pushLeadController.leadAssignModel()" >Assign Leads</button>

							</div>

							@endif
								@if(Auth::user()->current_user_can('administrator'))
							
									<!--<div class="col-md-2">
										 
											<button type="submit" class="btn btn-success btn-block" onclick="javascript:pushLeadController.leadAssignWithAPI()" >Assign API</button>
										 
									</div>-->
									@endif
									
							@if(Auth::user()->current_user_can('administrator'))
					 
							<div class="col-md-2">
							<button type="button" class="btn btn-success  btn-block move-not-interested" onclick="javascript:pushLeadController.moveNotInterested()" >Move to Not Int.</button>
							</div>					 
							@endif						
				
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('delete_lead') )
							<div class="col-md-2">
							<button type="button" class="btn btn-success  btn-block" onclick="javascript:pushLeadController.selectDeleteParmanent()" >Delete Per</button>
							</div>
							@endif
							
								</div>
								
								
								</div>
							 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
             
            <!-- /.row -->
			
			<!-- deleteClientModal -->
			<div id="deleteClient" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
					</div>
				</div>
			</div>
			<!-- deleteClientModal -->
			
			<div id="leadAssignModel" class="modal fade" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Assign Lead To Client</h4>
						<div class="assignsuccess" style="color:green"></div>
					</div>
					<div class="modal-body">
						<form action="" method="post">
						<select class="form-control select2-single" id="client_id" name="client_id[]" multiple="multiple">
						<option value="">Select Client	</option>
						@if($clientlist)
							@foreach($clientlist as $client)
						<option value="<?php echo $client->id; ?>"><?php echo $client->business_name?>	</option>
						@endforeach
						@endif
						</select>
						<div class="form-group" style="padding-top:20px;margin-bottom:0">
							<div class="col-md-3" style="margin:0 auto;float:none;">
								<button type="button" style="background-color:#169f85;color:#fff;" onclick="javascript:pushLeadController.leadAssignToClient()" class="btn btn-block">Submit</button>
							</div>
							<div class="clearfix"></div>
						</div>
						</form>
					</div>
					 
				</div>

			</div>
		</div>	
		
			<div id="leadAssignAPIModel" class="modal fade" role="dialog">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Assign Lead To Client BY API</h4>
						<div class="assignsuccess" style="color:green"></div>
					</div>
					<div class="modal-body">
						<form action="" method="post">
						<select class="form-control select2-single" id="clientid" name="clientid[]" multiple="multiple">
						<option value="">Select Client	</option>
						@if($clientlist)
							@foreach($clientlist as $client)
						<option value="<?php echo $client->id; ?>"><?php echo $client->business_name?>	</option>
						@endforeach
						@endif
						</select>
						<div class="form-group" style="padding-top:20px;margin-bottom:0">
							<div class="col-md-3" style="margin:0 auto;float:none;">
								<button type="button" style="background-color:#169f85;color:#fff;" onclick="javascript:pushLeadController.leadAssignToClientByAPI()" class="btn btn-block">Submit</button>
							</div>
							<div class="clearfix"></div>
						</div>
						</form>
					</div>
					 
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
		
	
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
