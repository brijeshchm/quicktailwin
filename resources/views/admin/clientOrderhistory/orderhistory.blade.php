<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Client Order History</h1>
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
						<form method="GET" action="/developer/order-history" autocomplete="off">
							{{ csrf_field() }}
							<div class="form-group">
								<div class="col-md-3">
									<label>Client Type</label>
									<select class="form-control" name="search[client_type]">										 							 
											<?php
									$clientTypes = getClientsType();
										foreach($clientTypes as $key=>$value){
											$selected = '';
											if(isset($search['client_type']) && $search['client_type']==$key)
												$selected = 'selected';
											echo "<option value='$key' $selected>$value</option>";
										}
										?>
									</select>
								</div>
							</div>
							
							  
							 
							<div class="form-group">
								<div class="col-md-3">
									<label>Date From</label>
									<input type="text" class="form-control datef" name="search[datef]" value="{{ old('search[datef]',(isset($search['datef'])) ? $search['datef']:"")}}" placeholder="Select Date From">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label>Date To</label>
									<input type="text" class="form-control datet" name="search[datet]" value="{{ old('search[datet]',(isset($search['datet'])) ? $search['datet']:"")}}" placeholder="Select Date To">
								</div>
							</div>
						 
							 
							
							<div class="form-group">
								<div class="col-md-3">
									<label style="visibility:hidden">Filter</label>
									<button type="submit" class="btn btn-block btn-info" >Filter</button>
								</div>
							</div>
						
						 
							
							
							
							
							
						</form>
					</div>
					  <div class="table-responsive table-virtical-grid">
						
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-all-order-history">
                                <thead>
                                    <tr>
                                        <th>ClientID</th>
                                        <th>Name</th>
                                        <th>Type</th>                                         
                                        <th>Paid Amount</th>
                                        <th>GST</th>
                                        <th>Total Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Collect By</th>
                                        <th>Date</th>
                                        <th>Order PDF</th>
										<th>Proforma Invoice</th>
                                       	<th>Invoice PDF</th>
										<th>Action</th>
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
										 <th>ClientID</th>
                                        <th>Name</th>
                                        <th>Type</th>                                         
                                        <th>Paid Amount</th>
                                        <th>GST</th>
                                        <th>Total Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Collect By</th>
                                        <th>Date</th>
                                        <th>Order PDF</th>
										<th>Proforma Invoice</th>
										<th>Invoice PDF</th>
										<th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- /.table-responsive -->
							
							
							@if(Auth::user()->current_user_can('administrator'))
							<form id="export-orderhistory" method="POST" onsubmit="return getorderhistoryexcel()" action="{{ url('/developer/orderhistory/getorderhistoryexcel') }}">
								{{ csrf_field() }}
								<input type="hidden" name="search[client_type]" value="">							 
								<input type="hidden" name="search[datef]" value="">
								<input type="hidden" name="search[datet]" value="">		
								<input type="hidden" name="search[value]" value="">								
								<div class="form-group">
									<div class="col-md-3">									 
											<button type="submit" class="btn btn-success btn-block export-clients">Export</button>										 
									</div>
								</div>								 
							</form>
						 
								</div>
							@endif
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

<?php echo View::make('admin/footer'); ?>
