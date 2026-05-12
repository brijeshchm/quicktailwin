<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">				
                    <h1 class="page-header">SEO Report</h1>
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
					@if(Session::has('danger_msg'))
						<div class="alert alert-danger">
							{{Session::get('danger_msg')}}
						</div>
					@endif					
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <div class="nc-form row">
							 
								<form method="GET" action="/developer/seo-report" autocomplete="off">
									{{ csrf_field() }}
									<div class="form-group col-md-3">
										<label>Date From</label>
										 <input type="text" class="form-control datef" name="search[datef]" value="{{ old('search[datef]',(isset($search['datef'])) ? $search['datef']:"")}}" placeholder="Call Date From">
									
									</div>
									<div class="form-group col-md-3">
										<label>Date to </label>
										 <input type="text" class="form-control datet" name="search[datet]" value="{{ old('search[datet]',(isset($search['datet'])) ? $search['datet']:"")}}" placeholder="Call Date To">
									
									</div>
									<div class="form-group col-md-3">
										<label>user</label>
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
									 
									<div class="col-md-3 col-md-offset-9">
										<input type="submit" class="btn btn-info btn-block">
									</div>
								</form>
							</div>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="datatable-seo-report" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Version</th>
											<th>Table</th>
											<th>Attributes</th>
											<th>Description</th>
											<th>Owner name</th>
											<th>Date</th>										 
										</tr>
									</thead>
									 
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
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
<?php echo View::make('admin/footer'); ?>