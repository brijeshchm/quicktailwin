<?php echo View::make('admin.header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Lead</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					@if(count($errors)>0)
						<!--div class="alert alert-danger">
							@foreach($errors->all() as $error)
							{{ $error }}.<br>
							@endforeach 
						</div-->
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
					<form class="form-horizontal lead_form" role="form" method="POST" action="{{ url('/developer/lead/add-lead') }}" novalidate autocomplete="off">
						{{csrf_field()}}
						<input type="hidden" name="b_end" value="1" />
                        <div class="form-group">
                            <label for="city_id" class="col-md-4 control-label">City</label>
                            <div class="col-md-6">
								<select class="form-control location city select2-single-city" name="city_id">
								</select>
                            </div>
                        </div>						
						
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Enter Name">
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="col-md-4 control-label">Mobile</label>

                            <div class="col-md-6">
                                <input type="tel" class="form-control" name="mobile" placeholder="Enter Mobile">
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label for="area" class="col-md-4 control-label">Area</label>

                            <div class="col-md-6">
								<!--textarea class="form-control" rows="1" name="area" id="area"></textarea-->
								<select class="form-control" name="area_zone" id="area"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kw_text" class="col-md-4 control-label">Course Interested</label>
                            <div class="col-md-6">
                                <!--input type="text" class="form-control home-search" name="kw_text" autocomplete="off">
								<div class="ajax-suggest ajax-suggest-lead-home" style="display: none;"><ul></ul></div-->
								<select class="form-control" name="kw_text" id="kw_text" placeholder="Enter Name"></select>
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label for="remark" class="col-md-4 control-label">Remark</label>

                            <div class="col-md-6">
                                <textarea name="remark" class="form-control" rows="5" placeholder="Enter Remark"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">ADD</button>
								<input type="reset" class="btn btn-default hide reset_lead_form" />
                            </div>
                        </div>
					</form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
		<div id="msgModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
		
<?php echo View::make('admin.footer'); ?>
