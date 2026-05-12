<?php echo View::make('admin/header'); ?>
<style>
#btnAllRight,#btnRight,#btnLeft,#btnAllLeft{
	display:block;
	margin:5px auto;
	width:30px;
}
</style>      
	  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Update "{{{ ucwords($client->business_name) }}}"</h1>
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
					<ul id="client-update-pills" class="nav nav-pills">
						<li class="active"><a data-toggle="pill" href="#location_info">Location Information</a></li>
						<li><a data-toggle="pill" href="#contact_info">Contact Information</a></li>
						<li><a data-toggle="pill" href="#other_info">Other Information</a></li>
						<li><a data-toggle="pill" href="#upload_pics">Upload Pictures</a></li>
						<li><a data-toggle="pill" href="#leads_pos">Assigned Keywords</a></li>
						<li><a data-toggle="pill" href="#view_all_leads">View All Leads</a></li>
						<li><a data-toggle="pill" href="#client_discussion">Client Discussion</a></li>
						<li><a data-toggle="pill" href="#payment_order">Payment Order</a></li>
					</ul>
					<div class="tab-content">
						<div id="location_info" class="tab-pane fade in active">
							<!--h3 class="text-right"><span style="border-bottom:2px dotted #00ABEA;">Location Information</span></h3-->
							<p>
								<form class="form-horizontal" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<label class="control-label col-sm-2" for="">User ID: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-sm-4">
											<!--input type="text" class="form-control" value="CC0001" disabled-->
											<p class="form-control-static"><strong>{{ $client->username or "" }}</strong></p>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="">Business Name: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-sm-4"> 
										 											
											 <?php if(Auth::user()->role == 'update_business_name' || Auth::user()->role == 'administrator'): ?>
											<input type="text" class="form-control" name="business_name" value="{{ $client->business_name}}">
											<?php else: ?>
											<input type="text" class="form-control" name="business_name" value="{{ $client->business_name or "" }}" readonly>
										
											<?php endif; ?> 
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="address">Address: </label>
										<div class="col-sm-4"> 
											<textarea class="form-control" name="address" rows="4" id="address">{{ $client->address or "" }}</textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="landmark">Landmark: </label>
										<div class="col-sm-4"> 
											<input type="text" class="form-control" name="landmark" value="{{ $client->landmark or "" }}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="city">City: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-sm-4"> 
										 
										<select class="dropdown-arrow dropdown-arrow-inverse city-form select2-single-city city" name="city">
										<option value="">Select City</option>
										@if(!empty($client->city))
										<option value="{{$client->city}}" selected>{{$client->city}}</option>
										@endif

										</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="state">State: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-sm-4">
											<?php $states = getStates(); ?>
											<select class="form-control select2-single-state" name="state">
												<?php
													$selected = '';
													foreach($states as $state){
														$selected = ($state==$client->state)?"selected":"";
														echo "<option value=\"".$state."\" ".$selected.">".$state."</otpion>";
													}
												?>
											</select>
											<!--input type="text" class="form-control" value="Uttar Pradesh"-->
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="country">Country: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-sm-4"> 
											<input type="text" class="form-control" name="country" value="{{ $client->country or "" }}">
										</div>
									</div>
									<div class="form-group"> 
										<div class="col-sm-offset-2 col-sm-4 text-right">
											<input type="submit" name="location_info" value="SAVE" class="btn btn-warning">
										</div>
									</div>
								</form>
							</p>
								@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('assigned_client_update'))							 
							<p>
								<form id="submitAssignClient" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<label class="control-label col-sm-3" for="country">Assigned Client: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-md-3">										
											<?php $counsellors = Auth()->user()->all();  ?>
										<select class="form-control assign_client" name="assign_client">
										<option value="">Select User</option>
										
										@if(isset($counsellors))
										@foreach($counsellors as $counsellor)
										@if(isset($client->created_by) && $client->created_by==$counsellor->id)
										<option value="{{ $counsellor->id }}" selected>{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
										@else
										<option value="{{$counsellor->id}}"  >{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
										@endif
										@endforeach
										@endif
										</select>
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_assign_client" value="1" />
										</div>
									</div>
								</form>
							</p>
							@endif
						</div>
						<div id="contact_info" class="tab-pane fade">
							<!--h3 class="text-right"><span style="border-bottom:2px dotted #00ABEA;">Contact Information</span></h3-->
							<p>
								<form class="form-horizontal" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<label class="control-label col-sm-2" for="contact_person">Contact Person: </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="contact_person" value="{{ $client->first_name." ".$client->last_name }}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="mobile">Primary Mobile No: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-sm-4"> 
											<input type="text" class="form-control" name="mobile" value="{{ $client->mobile or "" }}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="sec_mobile">Secondary Mobile No: </label>
										<div class="col-sm-4"> 
											<input type="text" class="form-control" name="sec_mobile" value="{{ $client->sec_mobile or "" }}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="landline">Landline No: </label>
										<div class="col-sm-4">
											<div class="col-sm-2"><div class="row"><input type="text" class="form-control" name="countrycode" value="+91" disabled></div></div>
											<div class="col-sm-4"><div class="row"><input type="text" class="form-control" name="stdcode" value="{{ $client->stdcode or "" }}"></div></div>
											<div class="col-sm-6"><div class="row"><input type="text" class="form-control" name="landline" value="{{ $client->landline or "" }}"></div></div>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="fax">Fax No: </label>
										<div class="col-sm-4"> 
											<input type="text" class="form-control" name="fax" value="{{ $client->fax or "" }}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="tollfree">Toll Free No: </label>
										<div class="col-sm-4"> 
											<input type="text" class="form-control" name="tollfree" value="{{ $client->tollfree or "" }}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="email">Email: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-sm-4"> 
											<input type="text" class="form-control" name="email" value="{{ $client->email or "" }}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="website">Website: </label>
										<div class="col-sm-4"> 
											<input type="text" class="form-control" name="website" value="{{ $client->website or "" }}">
										</div>
									</div>
									<div class="form-group"> 
										<div class="col-sm-offset-2 col-sm-4 text-right">
											<input type="submit" name="contact_info" value="SAVE" class="btn btn-warning">
										</div>
									</div>
								</form>
							</p>
						</div>
						<div id="other_info" class="tab-pane fade">
							<!--h3>Menu 2</h3-->
							<div class="col-md-12" style="margin:20px 0;">
								<div class="row">					 				 
						 
								<form id="submitConversionClient" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<label class="control-label col-sm-2" for="country">Conversion Client: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-md-3">										 
										<select class="form-control conversion_status" name="conversion_status">
										<option value="">Select Conversion</option>				
										 
										<option value="1" <?php if(isset($client->conversion_status) && $client->conversion_status==1){ echo "selected"; } ?>>Conversion</option>
									 
										<option value="0" <?php if(isset($client->conversion_status) && $client->conversion_status==0){ echo "selected"; } ?> >Non Conversion</option>			 	
										</select>
									 
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_conversion_client" value="1" />
										</div>
									</div>
								</form>					 
						 
								</div>
								<hr>
								<div class="row">
								<form method="POST" action="#" id="assignedZone" onsubmit="return assignedZoneController.submit(this)">
									{{ csrf_field() }}
								
									<div class="col-md-4 text-right">	
									<div class="form-group">
										<div class="row">
										
										<label for="">City:</label>
										<select name="city_id" class="form-control"></select>
										</div>
									</div>
									</div>
									
									<div class="col-md-4 text-right">
									<div class="form-group">
										<label for="">Zone:</label>
										<select name="zone_id" class="form-control"></select>
										<button type="reset" class="btn btn-primary" style="margin-top:10px;">Reset</button>
										<input type="submit" class="btn btn-info" value="Submit" style="margin-top:10px;">
									</div>
									</div>
									<!--div class="col-md-4 text-right">
										<div class="row">
										<label for="">Enter area here:</label>
										<select name="area_id" class="form-control"></select>
										<button type="reset" class="btn btn-primary" style="margin-top:10px;">Reset</button>
										<input type="submit" class="btn btn-info" value="Submit" style="margin-top:10px;">
										</div>
									</div-->
								</form>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class=" table-responsive">
									<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-assigned-zones">
										<thead>
											<tr>
												<!--th>Area</th-->
												<th>Zone</th>
												<th>City</th>
												<th>Action</th>
											</tr>
										</thead>
									</table>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<hr>
							 
						</div>
						<div id="upload_pics" class="tab-pane fade">
							<!--h3>Menu 2</h3-->
							<?php if(!empty($client->pictures)):
								$picture = unserialize($client->pictures);
								/* $picture = array_diff($picture, array('')); */
								/* $picture = array_slice($picture,0);
								for($i=(count($picture));$i<12;$i++){
									$picture[$i]['large']['name'] = '';
								} */
								for($i=0;$i<12;$i++){
									if(!isset($picture[$i])){
										$picture[$i]['large']['name'] = '';
									}
								}
							else:
								for($i=0;$i<12;$i++){
									$picture[$i]['large']['name'] = '';
								}
							endif; 
							
						//	echo "<pre>";print_r($picture);
							
							?>	
							<p>
								<form class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
									<?php for($i=0;$i<12;$i++): ?>
										<div class="col-md-4 line-space" id="image{{$i+1}}">
											@if(empty($picture[$i]['large']['name']))
											<input type="file" class="form-control" name="image{{$i+1}}">
											@endif
											<span class="help-block">
												@if(isset($picture[$i]['large']['src'])&&!empty($picture[$i]['large']['src']))
												<img src="{{asset(''.$picture[$i]['large']['src'])}}" style="height:75px;width:75px;">
												<a href="javascript:void(0)" class="remove-thumbnail" data-srno="image{{$i+1}}" title="remove"><i class="fa fa-times fa-fw" aria-hidden="true"></i></a>
												@endif
											</span>
										</div>
										<?php if(($i+1)%3==0){echo "<div class=\"clearfix\"></div>";} ?>
									<?php endfor; ?>
										<hr>
										<div class="col-md-4 col-md-offset-4">
											<input type="submit" class="btn btn-info btn-block line-space" name="upload_pics" value="SAVE">
										</div>
									</div>
								</form>
							</p>
						</div>
						<div id="leads_pos" class="tab-pane fade">
							<!--h3>Menu 2</h3-->
							<?php
								$clientTypes = getClientsType();
							?>
							<div>
								<form id="submitActiveStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Client Active Status:</label>
											<input type="checkbox" style="height:14px;width:14px;" class="active_status" name="active_status" value="1" <?php echo ($client->active_status)?"checked":""; ?> />
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_active_status" value="1" />
										</div>
									</div>
								</form>
							</div>
							<div>
								<form id="submitPaidStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Client Paid Status:</label>
											<input type="checkbox" style="height:14px;width:14px;" class="paid_status" name="paid_status" value="1" <?php echo ($client->paid_status)?"checked":""; ?> />
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_paid_status" value="1" />
										</div>
									</div>
								</form>
							</div>	

							<div>
								<form id="submitCertifiedStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Client Certified Status:</label>
											<input type="checkbox" style="height:14px;width:14px;" class="certified_status" name="certified_status" value="1" <?php echo ($client->certified_status)?"checked":""; ?> />
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_certified_status" value="1" />
										</div>
									</div>
								</form>
							</div>
							 
							<div>
								<form id="submitClientType" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Client Package Name:</label>
												@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('client_package_name'))
											<select class="select2-single form-control client_type" name="client_type">
												<?php
													foreach($clientTypes as $key => $value){
														$selected = "";
														if($key == $client->client_type):
															$selected = "selected";
														endif;
														?>
														<option value="{{ $key }}" <?php echo $selected; ?>>{{ $value }}</option>
														<?php
													}
												?>
											</select>
											@else
												<?php
													foreach($clientTypes as $key => $value){
														if($key == $client->client_type):
															echo "<p>$value</p>";
														endif;
													}
												?>
											@endif
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_client_type" value="1" />
											<!--button type="submit" class="btn btn-warning btn-block kw-submit"><i class="fa fa-plus fa-fw" aria-hidden="true"></i></button-->
										</div>
									</div>
								</form>
							</div>
							<div>
							<!--	<form class="form-horizontal" id="balance_amt_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Paid Amount:</label>
											<input type="text" class="form-control" name="balance_amt" value="{{$client->balance_amt or 0}}" />
										</div>
										@if($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager') )
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_balance_amt" value="1" />
											<button type="submit" class="btn btn-warning btn-block kw-submit">SAVE</button>
										</div>										
										@endif
									</div>
								</form>-->
							</div>
							<!--<div id="yearly_subs" style="display:<?php echo ($client->client_type==="yearly_subscription"||$client->client_type==="free_subscription")?"block":"none"; ?>;">
								<form class="form-horizontal" id="yearly_subs_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Starting Date:</label>
											<input type="text" class="form-control x_date" name="yrly_subs_starting_date" value="{{date_format(date_create($client->yrly_subs_start_date),'Y-m-d')}}" />
										</div>
										<div class="col-md-3">
											<label>End Date:</label>
											<input type="text" class="form-control y_date" value="{{date_format(date_create($client->yrly_subs_end_date),'Y-m-d')}}" />
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_yrly_subs_starting_date" value="1" />
											<button type="submit" class="btn btn-warning btn-block kw-submit">SAVE</button>
										</div>
									</div>
								</form>
							</div>-->
							<!--<div id="max_kw" style="display:<?php echo ($client->client_type==="free_subscription"||$client->client_type==="general")?"block":"none"; ?>;">
								<form class="form-horizontal" id="max_kw_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Max Keywords:ff</label>
											<input type="number" min=0 step=1 class="form-control" name="max_kw" value="{{$client->max_kw or 0}}" />
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_max_kw" value="1" />
											<button type="submit" class="btn btn-warning btn-block kw-submit">SAVE</button>
										</div>
									</div>
								</form>
							</div>-->
							<div id="leads_count" style="display:<?php echo ($client->client_type==="Gold" || $client->client_type==="Diamond"|| $client->client_type==="Platinum")?"block":"none"; ?>;">
								<form class="form-horizontal" id="count_based_subscription_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
									<!--	<div class="col-md-3">
											<label>Leads Count:</label>
											<input type="number" min=0 step=1 class="form-control" name="leads_count" value="{{$client->leads_count or 0}}" />
										</div>
										<div class="col-md-3">
											<label>Cost/Lead:</label>
											<input type="number" min=0 step=1 class="form-control" name="cost_per_lead" value="{{$client->cost_per_lead or 0}}" />
										</div>-->
										<div class="col-md-3">
											<label>Coins Remaining:</label>
											<input type="text" class="form-control" value="{{$client->coins_amt}}" readonly />
										</div>
											@if($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager') )
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_leads_count" value="1" />
										<!--	<button type="submit" class="btn btn-warning btn-block kw-submit">SAVE</button>-->
										</div>
										@endif
									</div>
								</form>
								<form class="form-horizontal" id="yearly_subs_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Starting Date:</label>
											<input type="text" class="form-control x_date" name="expired_from" value="{{date_format(date_create($client->expired_from),'Y-m-d')}}" />
										</div>
										<div class="col-md-3">
											<label>End Date:</label>
											<input type="text" class="form-control y_date" name="expired_on" value="{{date_format(date_create($client->expired_on),'Y-m-d')}}" />
										</div>
											@if($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager') )
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_yrly_subs_starting_date" value="1" />
											<button type="submit" class="btn btn-warning btn-block kw-submit">SAVE</button>
										</div>
										@endif
									</div>
								</form>
								
								<form class="form-horizontal" id="max_kw_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<div class="col-md-3">
											<label>Max Keywords:</label>
											<input type="number" min=0 step=1 class="form-control" name="max_kw" value="{{$client->max_kw or 0}}" />
										</div>
										@if($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager') )
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_max_kw" value="1" />
											<button type="submit" class="btn btn-warning btn-block kw-submit">SAVE</button>
										</div>
										@endif
									</div>
								</form>
								
							</div>
							<div id="ass_kw_wrapper" style="display:<?php echo ($client->client_type==="general")?"block":"block"; ?>;">
								<form class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST" id="kw_form" name="kw_form" >
									{{csrf_field()}}
									<div class="form-group">
									<!--<div class="col-md-2">	
									 
										<label for="">City:</label>
										<select name="city_id" class="form-control  city"></select>
										 
									</div>-->
									<input type="hidden" name="client_id" id="clientIDASSKW" value="{{$client->username}}">
									
									<div class="col-md-2">
											<label>City:</label>
											<select class="select2-single form-control city" name="city"  >
												@if(!empty($citylist))
														<option value="">Select City</option>
													@foreach($citylist as $distinctCity)
														<option value="{{$distinctCity->id}}">{{ucfirst($distinctCity->city)}}</option>
													@endforeach
												@endif
											</select>
										</div>
									
									
									<div class="col-md-2">									 
										<label for="">Zone:</label>
										<select name="zone_id" class="form-control zone" ></select>		 
								 
									</div>
									
										<!--<div class="col-md-2">
											<label>City:</label>
											<select class="select2-single form-control city" name="city" required>
												@if(!empty($citylist))
														<option value="">Select City</option>
													@foreach($citylist as $distinctCity)
														<option value="{{$distinctCity->id}}">{{ucfirst($distinctCity->city)}}</option>
													@endforeach
												@endif
											</select>
										</div>-->
										

										<div class="col-md-2">
											<label>Parent:</label>
												<select class="select2-single form-control parent" id="parentv" name="parent">
												@if(!empty($parentCategory))
														<option value="">Select Parent</option>
													@foreach($parentCategory as $parent)
														<option value="{{$parent->id}}">{{ucfirst($parent->parent_category)}}</option>
													@endforeach
												@endif
											</select>								
											
										</div>
										<div class="col-md-2">
											<label>Child:</label>
											<select class="select2-single form-control child" name="child" id="childv" >
											</select>
										</div>
										
										<div class="col-md-2">
											<label>Keywords:</label>
											<select class="form-control kw" name="kw" id="kwv" >
											
											</select>
										</div>
										<!--<div class="col-md-6">
											<label>:</label>
										 							
											
									<div class="form-group">
									<label class="col-xs-12">Keywords</label>
									<div class="col-xs-5">
									<select id="source" class="form-control" multiple="" style="height:200px;">
								 
									</select>
									</div>
									<div class="col-xs-2 text-center" style="margin:10px 0;">
									<input type="button" id="btnAllRight" value=">>">
									<input type="button" id="btnRight" value=">">
									<input type="button" id="btnLeft" value="<">
									<input type="button" id="btnAllLeft" value="<<">
									</div>
									<div class="col-xs-5">
									<select id="destination" name="kw[]" class="form-control" multiple="" style="height:200px;">
								 
									</select>
									</div>
									</div>
										</div>-->
										<div class="col-md-2">
											<label>Position:</label>
											<select class="select2-single form-control position" name="position" id="positionv">
										<!--	<option value="Free Listing">Free Listing</option>-->
											</select>
										</div>
										<div class="col-md-1">
											<label>Price:</label>
											<input type="text" class="form-control price" disabled>
										</div>
										<input type="hidden" name="kw-submit" value="kw-submit">
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="reset" class="btn btn-default hide reset_kw_submit" />
											<button type="submit" class="btn btn-warning btn-block kw-submit"><i class="fa fa-plus fa-fw" aria-hidden="true"></i></button>
										</div>
									</div>
									<div class="form-group">
									</div>
								</form>
								<style>
								.check-box{
									height:18px;
									width:20px;
									cursor:pointer;
								}
								</style>
								<div class="table-responsive col-md-12">
									<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-assigned-keywords"><!--dataTables-example-->
										<caption>Assigned Keywords</caption>
										<thead>
											<tr>
												<th><input type="checkbox" id="check-all" class="check-box"></th></th>											 
												<th>KW</th>
												<th>Child Category</th>
												<th>Parent Category</th>
												<th>City</th>
												<th>Zone</th>
												<th>Position</th>
												<!--<th>Price</th>-->
												<th>Action</th>
											</tr>
										</thead>
										<!--tbody>
											@foreach($kwds as $kwd)
											<tr>
												<td>{{ $kwd->id }}</td>
												<td>{{ $kwd->keyword }}</td>
												<td>{{ $kwd->child_category }}</td>
												<td>{{ $kwd->parent_category }}</td>
												<td>{{ $kwd->city }}</td>
												<td>{{ ucfirst($kwd->sold_on_position) }}</td>
												<td>{{ $kwd->sold_on_price }}</td>
												<td><a href="javascript:void(0)" onclick='javascript:deleteAssignedKW({{$kwd->id}},this,"del_ass_kw")'><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a> | <a href="javascript:void(0)" onclick='javascript:deleteAssignedKW({{$kwd->id}},this,"del_ass_kw")'><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></td>
											</tr>
											@endforeach
										</tbody-->
									</table>
									<form class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
										{{csrf_field()}}
										<div class="form-group">
										@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('export_assign_keyword'))
											<div class="col-md-2">
												<input type="submit" class="btn btn-success btn-block" name="kw-export" value="Export">
											</div>	 
											@endif
												@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('assign_keyword_delete'))
											<div class="col-md-2">
												<button type="button" class="btn btn-success btn-block" onclick="javascript:assignedKeywordController.deleteSelectedAssignedKwds()">Delete Selected</button>
											</div>
											@endif
											<!--<div class="col-md-2">
												<button type="button" class="btn btn-success btn-block" onclick="javascript:assignedKeywordController.updatePriceAssignedKwds()">Update Price</button>
											</div>-->
										</div>
									</form>
								</div>

								<div class="table-responsive col-md-12">
									<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-transactions">
										<caption>Transactions</caption>
										<thead>
											<tr>
												<th>Amount</th>
												<th>Lead</th>
												<th>Date</th>
												
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Amount</th>
												<th>Lead</th>
												<th>Date</th>
												 
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						
						<div id="view_all_leads" class="tab-pane fade">
							<div class="table-responsive col-md-12">
								<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-view-all-leads">
									<thead>
										<tr>
											<th>Name</th>
											<th>Mobile</th>
											<th>Email</th>										 
											<th>Course</th>
											<th>City</th>
											<th>Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Name</th>
											<th>Mobile</th>
											<th>Email</th>										 
											<th>Course</th>
											<th>City</th>
											<th>Date</th>
											<th>Action</th>
										</tr>
									</tfoot>
								</table>
							</div>
							<form class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
								{{csrf_field()}}
								<div class="form-group">
									@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('export_assign_lead') )
									<div class="col-md-3">
										<label style="visibility:hidden">Submit:</label>
										<input type="submit" class="btn btn-success btn-block" name="lead-export" value="Export">
									</div>
									@endif
								</div>
							</form>
						</div>
						
						<div id="client_discussion" class="tab-pane fade">
						
						<hr>
						
						<div class="row" id="discussion">
						<div class="col-md-2"> 
						</div>
						<div class="col-md-6 offset-4"> 
							 <?php   $admin_id	= $request->user()->id;
							  
							 
							//echo "<pre>";	 print_r($request->user()->first_name);
								$client = DB::table('clients')->where('username',$client->username)->first();
								$discussion = DB::table('client_discussion')->where('client_id',$client->id)->where('admin_id',$admin_id)->get();
								if(!empty($discussion)){

								foreach($discussion as $remrk){ ?>

								<p><?php echo $remrk->createdate.' '.$remrk->name.':'.$remrk->discussion."<br>"; ?></p>
							<?php	}
								
								}else{
									
									echo '<div class="alert alert-warning">No Discussion founds </div>';
								}
								
							 ?>
							 <div id="client-remark">
							 </div> 
							 
							 <div id="success-remark">
							 </div>
							</div> 
							</div> 
							<hr>
						<form  class="form-horizontal" onsubmit="return client.submitClientDiscussion(this)" method="post">
								{{csrf_field()}}
								
								<div class="form-group">
								<label class="col-sm-2">Discussion</label>
							 
								<div class="col-md-4"> 
								<input type="hidden" name="client-id" value="<?php echo $client->username; ?>" />
								<textarea name="clientremark" rows="5" class="form-control"></textarea>
								</div>
								</div> 
								<br>
							 <div class="form-group">
									<div class="col-md-4 col-md-offset-2">
									 
										<button type="submit" class="btn btn-warning btn-block kw-submit" value="discussion">SAVE</button>
									</div>
									</div>
							 
							</form>
							
						</div>
						
						<div id="payment_order" class="tab-pane fade">						
						<hr> 
							 <div id="success-payment">
							 </div> 
							 <div>
								<form id="submitPackageStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
									{{csrf_field()}}
									
									<div class="form-group">
									
										<div class="col-md-2">	
										<label>Package:-</label>
										</div>
										<div class="col-md-2">
											<label>Gold: Six Months</label>
											<input type="radio" style="height:14px;width:14px;" class="package_status" name="package_status" value="Gold" <?php echo (isset($client->client_type) && $client->client_type=='Gold')?"checked":""; ?> />
										</div> 
										<div class="col-md-2">
											<label>Diamond:</label>
											<input type="radio" style="height:14px;width:14px;" class="package_status" name="package_status" value="Diamond" <?php echo (isset($client->client_type) && $client->client_type=='Diamond')?"checked":""; ?> />
										</div>
										<div class="col-md-2">
											<label>Platinum:</label>
											<input type="radio" style="height:14px;width:14px;" class="package_status" name="package_status" value="Platinum" <?php echo (isset($client->client_type) && $client->client_type=='Platinum')?"checked":""; ?> />
										</div>
										<div class="col-md-1">
											<label style="visibility:hidden">Submit:</label>
											<input type="hidden" name="submit_packege_status" value="1" />
										</div>
									</div>
								</form>
							</div>
							 <div>
						<form  class="form-horizontal order_validation" onsubmit="return client.submitClientPayOrder(this)"  method="post">
								{{csrf_field()}}
								<?php // echo "<pre>";print_r($client);?>
								
								<!--<div class="form-group">
								<label class="col-sm-2">Customer Name</label>							 
								<div class="col-md-4"> 
								
								<input type="text" name="customer_name" class="form-control" value="{{$client->first_name or ""}} {{$client->last_name or ""}}" placeholder="Customer Name">
								</div>
								</div> -->
								<input type="hidden" name="client-id" value="<?php echo $client->username; ?>" />
								<div class="form-group">
								<label class="col-sm-2">Business Name<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							 
								<div class="col-md-4"> 
								 
								<input type="text" name="business_name" class="form-control" value="{{$client->business_name or ""}}" placeholder="Business Name"> 
								</div>
								</div> 								
							 
								<div class="form-group">
								<label class="col-sm-2">Package Name <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							 
								<div class="col-md-4"> 								 
								<input type="text" name="package_name" class="form-control" value="{{$client->client_type or ""}}" placeholder="Package Name"> 
								</div>
								</div> 	
						
							<!--	<div class="form-group">
									<label class="col-sm-2">Expire<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-md-3">
											<label>Starting Date:</label>
											<input type="text" class="form-control x_date" name="expired_from" value="" />
										</div>
										<div class="col-md-3">
											<label>End Date:</label>
											<input type="text" class="form-control y_date" name="expired_on" value="" />
										</div>
										 
								</div>-->
								
								<div class="form-group">
								<label class="col-sm-2">Paid Amount<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							 
								<div class="col-md-4"> 							 
								<input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Paid Amount" onkeypress="return isNumericKeyCheck(event);" onblur="handlingPaiAmt()"> 
								</div>
								</div> 
								
								<div class="form-group">
								<label class="col-sm-2">Coins <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
								<div class="col-md-3">
								<label>Coins:</label>
								<input type="text" min=0 step=1 class="form-control" name="coins_amt" id="coins_per_lead" value="" onkeypress="return isNumericKeyCheck(event);" readonly/>
								</div>
								
								
							  
								</div>
								
								
								<!--<div class="form-group">
								<label class="col-sm-2">Leads<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
								<div class="col-md-3">
								<label>Cost/Lead:</label>
								<input type="number" min=0 step=1 class="form-control" name="cost_per_lead" id="cost_per_lead" value="{{$client->cost_per_lead or 0}}" onblur="handlingFee()" />
								</div>
								
								
								<div class="col-md-3">
								<label>Leads Count:</label>
								<input type="number" min=0 step=1 class="form-control" name="leads_count" id="leadscount" value="{{$client->leads_count or 0}}" readonly />
								</div> 
								</div>-->
								
								<div class="form-group">
								<label class="col-sm-2">GST <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
								<div class="col-md-4"> 	
								<label class="radio-inline">
								<input type="radio" name="gst_status" value="Yes" onchange="paidgst(this.value)">Yes
								</label>
								<label class="radio-inline">
								<input type="radio" name="gst_status" value="No" onchange="nopaidgst(this.value)">No
								</label>

								</div>	
								</div>	
								<div class="form-group">
								<label class="col-sm-2">GST Amount</label>
							 
								<div class="col-md-4"> 
								 
								<input type="number" name="gst_tax" id="gst_tax" class="form-control" placeholder="GST Amount"> 
								</div>
								</div> 
								
								<div class="form-group">
								<label class="col-sm-2">GST Total Amount<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							 
								<div class="col-md-4"> 
								 
								<input type="number" name="gst_total_amount" id="gst_total_amount" class="form-control" placeholder="GST Total Amount" > 
								</div>
								</div> 


								<div class="form-group">
								<label class="col-sm-2">TDS<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
								<div class="col-md-4"> 	
								<label class="radio-inline">
								<input type="radio" name="tds_status" value="Yes" onchange="paidtds(this.value)" >Yes
								</label>
								<label class="radio-inline">
								<input type="radio" name="tds_status" value="No" onchange="nopaidtds(this.value)" >No
								</label>

								</div>	
								</div>	
								<div class="form-group">
								<label class="col-sm-2">TDS Amount</label>
							 
								<div class="col-md-4"> 
								 
								<input type="number" name="tds_amount" id="tds_amount" class="form-control" placeholder="TDS Amount" > 
								</div>
								</div> 
								
								<div class="form-group">
								<label class="col-sm-2">Total Amount<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>						 
								<div class="col-md-4"> 								 
								<input type="number" name="total_amount" id="total_amount" class="form-control" placeholder="Total Amount" > 
								</div>
								</div> 
								
								<!--<div class="form-group">
								<label class="col-sm-2">Pay Amount in Words<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							 
								<div class="col-md-4">								 
								<textarea type="text" name="paid_amt_in_words" class="form-control" placeholder="paid amt in words"> </textarea>
								</div>
								</div> -->
								 
								
								<div class="form-group">
										<label class="col-sm-2" for="stud-payment_mode">Payment Mode<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
										<div class="col-sm-4">
											<?php
												 												
												foreach($moderesults as $moderesult){
													$modes[$moderesult->slug] = $moderesult->mode;
												}
											?>										
											<select class="form-control" id="stud-payment_mode" name="stud-payment_mode" >
												<option value="">Select Payment Mode</option>
												<?php foreach($modes as $key => $value): ?>
													<option value="<?php echo $key; ?>" <?php echo ($key=='cash')?"selected":""; ?>><?php echo $value; ?></option>
												<?php endforeach; ?>
												 
											</select>
										</div>
									</div>					
									<?php foreach($modes as $key=>$value): ?>
										<?php if($key!='cash' && $key!='cheque'): ?>
											<div class="form-group hide-mode <?php echo $key; ?>">
												<label class="col-sm-2" for="stud-<?php echo $key; ?>"><?php echo $value; ?></label>
												<div class="col-sm-4">          
													<select class="form-control" id="stud-<?php echo $key; ?>" name="stud-<?php echo $key; ?>">
														<option value="" selected="selected">-- Select <?php echo $value; ?> --</option>
														<?php
														$banks =  App\Models\Banksdetails::where('mode',$key)->get();	
															//$banks = $wpdb->get_results("SELECT * FROM `banks_details` WHERE `mode`='".$key."'");
															if( count($banks) > 0 ){
																foreach ($banks as $bank) {
																	echo "<option value=\"".$bank->name."\">".$bank->name."</option>";
																}
															}
														?>
													</select>
												</div>
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
									<div class="form-group hide-mode cheque">
										<label class="col-sm-2" for="stud-chq_no">Cheque Number</label>
										<div class="col-sm-4">          
										  <input type="text" class="form-control" id="stud-chq_no" name="stud-chq_no" placeholder="Enter Cheque Number">
										</div>
									</div>	
								 
									<div class="form-group hide-mode bank">
										<label class="col-sm-2" for="stud-card_no">Card Number</label>
										<div class="col-sm-4">          
										  <input type="text" class="form-control" maxlength="4" id="
										  
										  " name="stud-card_no" placeholder="Enter Last 4 Digit of Card Number">
										</div>
									</div>	
									
								 <!--<div class="form-group">
								<label class="col-sm-2">Pay Mode Details<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>							 
								<div class="col-md-4"> 								 
								<textarea type="text" name="pay_mode_details" class="form-control" placeholder="Enter Pay Mode Details"> </textarea>
								</div>
								</div> -->
								
								<div class="form-group">
								<label class="col-sm-2">Transaction-Id:</label>							 
								<div class="col-md-4"> 								 
								<input type="text" name="transactionid" class="form-control" placeholder="Enter Transaction-Id"> 
								
								</div>
								</div>	
								
								<div class="form-group">
								<label class="col-sm-2">Select ID Proof:</label>							 
								<div class="col-md-4"> 								 
								<select class="form-control" name="selectproofid"> 
								<option value="">Select ID Proof</option>
								<option value="Pan Card">Pan Card</option>
								<option value="Adhar Card">Adhar Card</option>
								<option value="Passport">Passport</option>
								<option value="Driver Licence">Driver Licence</option>
								</select>
								
								</div>
								</div>
								
								<div class="form-group">
								<label class="col-sm-2">ID Proof:</label>							 
								<div class="col-md-4"> 								 
								<input type="text" name="proofid" class="form-control" placeholder="Enter ID proof"> 
								
								</div>
								</div>
								<br>
							 <div class="form-group">
									<div class="col-md-4 col-md-offset-2">
									 <input type="hidden" name="pay-submit" value="savepay">
									<input type="hidden" class="resetData" >
										<input type="submit" class="btn btn-warning btn-block payOrder" value="Payment"> 
									</div>
									</div>
							 
							</form>
							</div>
							<div class="table-responsive col-md-12">
									<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-payment-history">
										<caption>Payment History</caption>
										<thead>
											<tr>
												<th>Date</th>
												<th>Paid Amount</th>
												<th>GST</th>
												<th>Total Amount</th>
												<th>Pay Mode</th>
												<th>Order PDF</th>
												<th>Proforma Invoice</th>
												<th>Invoice PDF</th>
												<th>Action</th>
											</tr>
										</thead>
										
										<tbody>
										
										</tbody>
										 
									</table>
								</div>
								
								
								
								
								<!-- Modal -->
		 
								<script>
				 
		function paidgst(gst){			
			 
			var paid = parseInt($('#paid_amount').val());		
			//var tot = parseInt(((paid)*(.18)));			 
			 var tot = Math. round(((paid)*(.18)));			 
			 var gstamount = $('#gst_tax').val(tot);			 
			 var tatol= parseInt(paid + tot);			 
			 var tobe = $('#gst_total_amount').val(tatol);	 
			 
		}
		
		function nopaidgst(gstno){
			var paid = parseInt($('#paid_amount').val());		
			 var tot = parseInt(0);			 
			 var gstamount = $('#gst_tax').val(tot);			 
			 var tatol= paid + tot;			 
			 var tobe = $('#gst_total_amount').val(tatol);				   
		}
		
		function paidtds(tds){			
			 
			var tdspaid = parseInt($('#paid_amount').val());			 		 
			var gst_total_amount = parseInt($('#gst_total_amount').val());			 		 
			 var tottds = Math. round(((tdspaid)*(2))/100);			 
			 var gstamount = $('#tds_amount').val(tottds);			 
			 var tdstatol= parseInt(gst_total_amount - tottds);			 
			 var tdstobe = $('#total_amount').val(tdstatol);	 
			 
		}
		
		function nopaidtds(tdsno){
			var tdspaid = parseInt($('#paid_amount').val());	
			var gst_total_amount = parseInt($('#gst_total_amount').val());				
			 var tottds = parseInt(0);			 
			 var gstamount = $('#tds_amount').val(tottds);			 
			 var tdstatol= gst_total_amount - tottds;			 
			 var tdstobe = $('#total_amount').val(tdstatol);				   
		}
		
		 
		</script>
		
						</div>
					</div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<!-- deleteKeywordModal -->
			<div id="deleteClient" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
					</div>
				</div>
			</div>
			<!-- deleteKeywordModal -->
        </div>
        <!-- /#page-wrapper -->
 <script>


 </script>
<?php echo View::make('admin/footer'); ?>
