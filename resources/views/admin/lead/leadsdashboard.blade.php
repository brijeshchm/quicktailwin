<?php echo View::make('admin/header'); ?>
<style>
.cancelBtn{
display:inherit;
width:-webkit-fill-available;
}
#reportrange span{
display:none;
}
#reportrange_test{
margin-top
}
.calling_status h5{

float: left;
}
.x_panel {
width: 100%;
padding: 0px 5px;
display: inline-block;
background: #fff;
border: 1px solid #E6E9ED;
-webkit-column-break-inside: avoid;
-moz-column-break-inside: avoid;
column-break-inside: avoid;
opacity: 1;
transition: all .2s ease;
}
.widget_summary .w_left {
    float: left;
    text-align: left;
}
.widget_summary .w_center {
    float: left;
}
.widget_summary .w_right {
    float: left;
    text-align: right;
}
.w_25 {
    width: 25%;
}
.w_55 {
    width: 55%;
}
.w_50 {
    width: 50%;
}
.w_20 {
    width: 20%;
}
.w_15 {
    width: 15%;
}
.panel_toolbox>li {
    float: right;
    cursor: pointer;
}
.panel_toolbox {
    float: right;
    min-width: 70px;
}
.calling_status{
    border-bottom: 1px solid #ddd;
	margin-bottom: 6px;
}

.bg-blue {
    background: #3498DB!important;
    border: 1px solid #3498DB!important;
    color: #fff;
}
.blue {
    color: #3498DB;
}
.bg-green {
    background: #1ABB9C!important;
    border: 1px solid #1ABB9C!important;
    color: #fff;
}

.green {
    color: #1ABB9C;
}
.bg-red {
    background-color: #931111 !important;
    border: 1px solid #931111!important;
    color: #fff;
}
.red {
    color: #931111 !important;
}

.bg-purple {
    background: #9B59B6!important;
    border: 1px solid #9B59B6!important;
    color: #fff;
}
.purple {
    color: #9B59B6;
}
.bg-black {
    background: #000!important;
    border: 1px solid #000!important;
    color: #fff;
}
.black {
    color: #000;
}
.bg-pink {
    background: #FFC0CB!important;
    border: 1px solid #FFC0CB!important;
    color: #fff;
}
.pink {
    color: #FFC0CB;
}
.bg-dark-green {
    background-color: #027a06;
    border: 1px solid #027a06!important;
    color: #fff;
}
.dark-green {
    color: #027a06;
}

.bg-light-red {
    background-color: #E74C3C !important;
    border: 1px solid #E74C3C!important;
    color: #fff;
}.bg-light-red {
    background-color: #E74C3C !important;
    border: 1px solid #E74C3C!important;
    color: #fff;
}
						</style>	
		<div id="page-wrapper" role="main" ng-controller="counsellorDashboard">
            <div class="row">
                <div class="col-lg-12">
                    <h5>Leads Dashboard</h5>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                
                                <div class="col-xs-9 text-right">
								<div class="huge" ng-bind="total_leads">				 
									</div>
                                 
                                    <div>Total Leads</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                               
                                <div class="col-xs-9 text-right">
                                    <div class="huge" ng-bind="total_joined"></div>
                                    <div>Joined</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                
                                <div class="col-xs-9 text-right">
                                    <div class="huge" ng-bind="total_interested"></div>
                               
                                    <div>Interested</div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                
                                <div class="col-xs-9 text-right">
                                    <div class="huge" ng-bind="total_follow_up"></div>
                                    <div>Follow Up</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> -->
            <div class="row" >
			<div class="col-md-5 col-sm-5 col-xs-12">
				<div class="x_panel tile fixed_height_320" >				 
					<div class="x_title calling_status">
						<h5>Daily Calling Status (<small><%fromDate%> - <%toDate%></small>)</h5>	
											
						<ul class="nav navbar-right panel_toolbox">
						 
							<li id="reportrange_test" >
								<a href="javascript:void(0)" ng-click="showDCS_DateRangePicker()">
									<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
									<span></span> <b class="caret"></b>
								</a>
								<div ng-show="dcs_DateRangePicker" class="well" style="position:absolute;top:40px;left:0;right:auto;display:block;max-width:none;z-index:3001;
								direction:ltr;text-align:left;float:left;width:300px;margin-left:-253px;">
									<div class="col-xs-6"><label>From:</label><input type="text" class="form-control fromDate" value="<?php echo date('Y-m-d')?>" /></div>
									<div class="col-xs-6"><label>To:</label><input type="text" class="form-control toDate" value="<?php echo date('Y-m-d')?>" /></div>
									<div class="col-xs-6 col-xs-offset-6" style="padding-top:10px;"><input type="submit" value="submit" class="btn btn-success btn-block" ng-click="getCallingStatus()" /></div>
								</div>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>New Leads</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-blue" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%dcs_new_lead_percent%>%;">
										<span class="sr-only" ng-bind="dcs_new_lead_percent">Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="blue" ng-bind="dcs_new_lead"></span>
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Interested</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%dcs_interested_percent%>%;">
										<span class="sr-only" ng-bind="dcs_interested_percent"> Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="green" ng-bind="dcs_interested"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Pending</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-red" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%dcs_pending_percent%>%;">
										<span class="sr-only" ng-bind="dcs_pending_percent"> % Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="red" ng-bind="dcs_pending"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Not Intr...</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-light-red" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%dcs_not_interested_percent%>%;">
										<span class="sr-only" ng-bind="dcs_not_interested_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="light-red" ng-bind="dcs_not_interested"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Visits</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-purple" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%dcs_visits_percent%>%;">
										<span class="sr-only" ng-bind="dcs_visits_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="purple" ng-bind="dcs_visits"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Assign lead</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-black" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%dcs_total_assign_lead_percent%>%;">
										<span class="sr-only" ng-bind="dcs_total_assign_lead_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="black" ng-bind="dcs_total_assign_lead"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Client Assign</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-pink" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%dcs_total_client_assign_percent%>%;">
										<span class="sr-only" ng-bind="dcs_total_client_assign_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="pink assign"></span>  
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Joined</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-dark-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%dcs_joined_percent%>%;">
										<span class="sr-only" ng-bind="dcs_joined_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="dark-green" ng-bind="dcs_joined"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						 @if(Auth::user()->current_user_can('administrator')) 
						Lead:<%leadlast%> 
					 @endif
						<h5>Total Call Count: <span style="float:right;margin-right: 20px;" ng-bind="dcs_total_call_count_leads">[L]</span> </h5>
					</div>
				</div>
			</div>
			
			<div class="col-md-5 col-sm-5 col-xs-12">
				<div class="x_panel tile fixed_height_320">
					<div class="x_title calling_status">
						<h5>Weekly Calling Status</h5>
						<ul class="nav navbar-right panel_toolbox">
							<!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>-->
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>New Leads</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-blue" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%wcs_new_lead_percent%>%;">
										<span class="sr-only" ng-bind="wcs_new_lead_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="blue" ng-bind="wcs_new_lead"></span>
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Interested</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%wcs_interested_percent%>%;">
										<span class="sr-only" ng-bind="wcs_interested_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="green" ng-bind="wcs_interested"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Pending</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-red" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%wcs_pending_percent%>%;">
										<span class="sr-only" ng-bind="wcs_pending_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="red" ng-bind="wcs_pending"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Not Intr...</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-light-red" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%wcs_not_interested_percent%>%;">
										<span class="sr-only" ng-bind="wcs_not_interested_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="light-red" ng-bind="wcs_not_interested"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Visits</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-purple" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%wcs_visits_percent%>%;">
										<span class="sr-only" ng-bind="wcs_visits_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="purple" ng-bind="wcs_visits"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Assign Lead</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-purple" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%wcs_total_assign_lead_percent%>%;">
										<span class="sr-only" ng-bind="wcs_total_assign_lead_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="purple" ng-bind="wcs_total_assign_lead"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Client Assign</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-purple" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%wcs_total_cleint_assign_percent%>%;">
										<span class="sr-only" ng-bind="wcs_total_cleint_assign_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="purple" ng-bind="wcs_total_client_assign"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="widget_summary">
							<div class="w_left w_25">
								<span>Joined</span>
							</div>
							<div class="w_center w_55">
								<div class="progress">
									<div class="progress-bar bg-dark-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<%wcs_joined_percent%>%;">
										<span class="sr-only" ng-bind="wcs_joined_percent">% Complete</span>
									</div>
								</div>
							</div>
							<div class="w_right w_15">
								<span class="dark-green" ng-bind="wcs_joined"></span>
							</div>
							<div class="clearfix"></div>
						</div>
						<h5>Total Call Count: <span style="float:right;margin-right: 20px;" ng-bind="wcs_total_call_count_leads">[L] </span> </h5>
					</div>
				</div>
			</div>

			</div>
		
			<!--Lead dashboard followup -->
           <div class="row">
                <div class="col-lg-12">
					<div class="x_title">
						<h2>Pending Follow Up Leads</h2>
						<div class="clearfix"></div>
					</div>
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
							<form method="GET" action="" novalidate onsubmit="return filterAjaxLeadData('datatable-pending-leads-dashboard',this)" autocomplete="off">
								 
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
											<label>Date Followup From</label>
											<input type="text" class="form-control datef" name="search[datef]" value="{{ old('search[datef]',(isset($search['datef'])) ? $search['datef']:"")}}" placeholder="Enter Followup From">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Date Followup To</label>
											<input type="text" class="form-control datet" name="search[datet]" value="{{ old('search[datet]',(isset($search['datet'])) ? $search['datet']:"")}}" placeholder="Enter Followup To">
										</div>
									</div>
									
									<!--<div class="form-group">
										<div class="col-md-3">
										<label>Select User</label>
											<select class="form-control select2-single" name="search[user]">
									<option value="">Select User</option>
								<?php $getUserList = getUserList(); ?>
										@if(isset($getClientsList))
										@foreach($getClientsList as $counsellor)
										@if(isset($search['user']) && $search['user']==$counsellor->id)
										<option value="{{ $counsellor->id }}" selected>{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
										@else
										<option value="{{$counsellor->id}}"  >{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
										@endif
										@endforeach
										@endif
								</select>
										</div>
									</div>-->
									<div class="form-group">
										<div class="col-md-3">
											<label style="visibility:hidden">Filter</label>
											<button type="submit" class="btn btn-block btn-info">Filter</button>
										</div>
									</div>
								</form>
							</div>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-pending-leads-dashboard">
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                        <th>Name</th>                                       
                                        <th>Mobile</th>
                                        <!--th>Email</th-->
										<th>Owner</th>
                                        <th>Status</th>
                                        <th>Course</th>
                                        <th>City</th>
                                        <th>Date</th>
										<th>Push By</th>
										 
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
										<th></th>
                                        <th>Name</th>										 
                                        <th>Mobile</th>
                                        <!--th>Email</th-->
                                       <th>Owner</th>
                                        <th>Status</th>
                                        <th>Course</th>
                                        <th>City</th>
                                        <th>Date</th>
										<th>Push By</th>
                                       
                                        <th>Action</th>
                                        
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- /.table-responsive -->
							@if(Auth::user()->current_user_can('administrator'))
							<form id="export-leads" method="POST" onsubmit="return exportLeads()" action="{{ url('/developer/lead/getleadssexcel') }}">
								{{ csrf_field() }}
								<input type="hidden" name="search[city]" value="">
								<input type="hidden" name="search[course]" value="">
								<input type="hidden" name="search[datef]" value="">
								<input type="hidden" name="search[datet]" value="">
								<input type="hidden" name="search[value]" value="">
								<!--<div class="form-group">
									<div class="col-md-3">
									 
											<button type="submit" class="btn btn-success btn-block export-clients">Export</button>
										 
									</div>
								</div>-->
								
								
								
									 
							</form>
							
							
							<!---
							<div class="form-group">
									<div class="col-md-3">
										 
											<button type="submit" class="btn btn-success btn-block" onclick="javascript:pushLeadController.leadAssignModel()" >Assign Leads</button>
										 
									</div>
								</div>-->
							@endif
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
             <!-- /.row -->
            <div class="row">
                
                <!-- /.col-lg-8 -->
                  <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
			
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