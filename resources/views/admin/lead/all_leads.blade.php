<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">All Leads</h1>
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
								<form method="GET" action="/developer/lead">
									{{ csrf_field() }}
									<div class="form-group">
										<div class="col-md-3">
											<label>City</label>
											<select class="form-control" name="search[city]">
												<option value="">-- SELECT CITY --</option>
												@if(count($cities)>0)
													@foreach($cities as $city)
														@if(isset($search['city']) && $search['city']==$city->id)
															<option value="{{ $city->id }}" selected>{{ $city->city }}</option>
														@else
															<option value="{{ $city->id }}">{{ $city->city }}</option>
														@endif
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Service</label>
											<select class="form-control course" name="search[course]">
												<option value="">-- SELECT COURSE --</option>
												@if(count($kwds)>0)
													@foreach($kwds as $kwd)
														@if(isset($search['course']) && $search['course']==$kwd->kw_text)
															<option value="{{ $kwd->kw_text }}" selected>{{ $kwd->kw_text }}</option>
														@else
															<option value="{{ $kwd->kw_text }}">{{ $kwd->kw_text }}</option>
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
												<option value="0" <?php echo (isset($search['lead_type'])&&$search['lead_type']=='0')?"selected":""; ?>>External (FrontEnd)</option>
												<option value="1" <?php echo (isset($search['lead_type'])&&$search['lead_type']=='1')?"selected":""; ?>>Internal (BackEnd)</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Date From</label>
											<input type="text" class="form-control datef" name="search[datef]" value="{{ old('search[datef]',(isset($search['datef'])) ? $search['datef']:"")}}">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Date To</label>
											<input type="text" class="form-control datet" name="search[datet]" value="{{ old('search[datet]',(isset($search['datet'])) ? $search['datet']:"")}}">
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
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-all-leads">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Lead</th>
                                        <th>Mobile</th>
                                        <!--th>Email</th-->
                                        <th>Owner</th>
                                        <th>Area</th>
                                        <th>Course</th>
                                        <th>City</th>
                                        <th>Date</th>
<th>Push By</th>
                                        <th>Client</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
                                        <th>Name</th>
										<th>Lead</th>
                                        <th>Mobile</th>
                                        <!--th>Email</th-->
                                        <th>Owner</th>
                                        <th>Area</th>
                                        <th>Service</th>
                                        <th>City</th>
                                        <th>Date</th>
<th>Push By</th>
                                        <th>Client</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- /.table-responsive -->
							@if(Auth::user()->current_user_can('administrator|admin'))
							<form id="export-leads" method="POST" onsubmit="return exportLeads()" action="{{ url('/developer/lead/getleadssexcel') }}">
								{{ csrf_field() }}
								<input type="hidden" name="search[city]" value="">
								<input type="hidden" name="search[course]" value="">
								<input type="hidden" name="search[datef]" value="">
								<input type="hidden" name="search[datet]" value="">
								<input type="hidden" name="search[value]" value="">
								<div class="form-group">
									<div class="col-md-3">
										<div class="row">
											<button type="submit" class="btn btn-success btn-block export-clients">Export</button>
										</div>
									</div>
								</div>
							</form>
							@endif
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
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
