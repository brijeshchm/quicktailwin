<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Deleted Clients</h1>
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
								<form method="GET" action="/developer/clients/list/deleted-clients">
									{{ csrf_field() }}
									<div class="col-lg-2">
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
										<input type="tel" class="form-control" name="mobile" placeholder="" value="{{ $request->input('mobile') }}">
									</div>
									<div class="col-lg-2">
										<label for="" style="visibility:hidden">submit</label>
										<input type="submit" name="filter" class="btn btn-info btn-block" class="form-control">
									</div>
								</form>
							</div>
							<?php if(isset($clients) && count($clients)>0): ?>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>User_ID</th>
                                        <th>Business_Name</th>
                                        <th>Name</th>
                                        <!--th>City</th-->
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                        <th>See</th>
                                        <th>Restore</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($clients as $client): ?>
                                    <tr>
                                        <td>{{ $client->username }}</td>
                                        <td>{{ $client->business_name }}</td>
                                        <td>{{ $client->first_name." ".$client->last_name }}</td>
                                        <!--td>{{ $client->city }}</td-->
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->mobile }}</td>
                                        <td class="text-center"><a href="/developer/clients/update/{{$client->username}}"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a></td>
                                        <td class="text-center"><a href="javascript:void(0)" onclick="javascript:deleteClient({{$client->id}},this,'hdelete')"><i class="fa fa-trash fa-fw" style="color:red" aria-hidden="true"></i></a></td>
										<td class="text-center"><a href="/developer/clients/list/deleted-clients/{{$client->username}}"><i class="fa fa-eye fa-fw" aria-hidden="true"></i></a></td>
										<td class="text-center"><a href="javascript:void(0)" onclick="javascript:deleteClient({{$client->id}},this,'restore')"><i class="fa fa-rocket fa-fw" aria-hidden="true"></i></a></td>
                                    </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
							<?php else: ?>
							<div class="alert alert-danger">
								Client(s) Not Found !!
							</div>
							<?php endif; ?>
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
