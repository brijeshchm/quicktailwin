<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Client Details  <a href="/developer/clients/update/{{ $clients[0]['username'] }}" title="Update Client" class="btn btn-warning">UPDATE</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="return generateNewPass()" class="btn btn-warning">Send Password</a></h1>
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
							<?php if(isset($clients) && count($clients)>0): foreach($clients as $client): ?>
							<div class="col-md-12">
								<div class="row">
									<table width="100%" class="table table-striped table-bordered table-hover">
										<caption><strong>Location Information</strong></caption>
										<tr>
											<th>Business Name</th>
											<td>{{ (null!==$client->business_name)?$client->business_name:"" }}</td>
											<th>City</th>
											<td>{{ (null!==$client->city)?$client->city:"" }}</td>
										</tr>
										<tr>
											<th>Address</th>
											<td>{{ (null!==$client->address)?$client->address:"" }}</td>
											<th>State</th>
											<td>{{ (null!==$client->state)?$client->state:"" }}</td>
										</tr>
										<tr>
											<th>Landmark</th>
											<td>{{ (null!==$client->landmark)?$client->landmark:"" }}</td>
											<th>Country</th>
											<td>{{ (null!==$client->country)?$client->country:"" }}</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<table width="100%" class="table table-striped table-bordered table-hover">
										<caption><strong>Contact Information</strong></caption>
										<tr>
											<th>Contact Person</th>
											<td>{{ (null!==$client->first_name)?$client->first_name:"" }} {{ (null!==$client->last_name)?$client->last_name:"" }}</td>
											<th>Primary Mobile No:</th>
											<td>{{ (null!==$client->mobile)?$client->mobile:"" }}</td>
										</tr>
										<tr>
											<th>Secondary Mobile No:</th>
											<td>{{ (null!==$client->sec_mobile)?$client->sec_mobile:"" }}</td>
											<th>Landline No:</th>
											<td>{{ (null!==$client->stdcode)?("+91-".$client->stdcode):"" }}-{{ (null!==$client->landline)?$client->landline:"" }}</td>
										</tr>
										<tr>
											<th>Fax No:</th>
											<td>{{ (null!==$client->fax)?$client->fax:"" }}</td>
											<th>Toll Free No:</th>
											<td>{{ (null!==$client->tollfree)?$client->tollfree:"" }}</td>
										</tr>
										<tr>
											<th>Email ID:</th>
											<td>{{ (null!==$client->email)?$client->email:"" }}</td>
											<th>Website:</th>
											<td>{{ (null!==$client->website)?$client->website:"" }}</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row">
									<table width="100%" class="table table-striped table-bordered table-hover">
										<caption><strong>Other Information</strong></caption>
										<tr>
											<th>Display Hours of Operation</th>
											<td>{{ (0==$client->display_hofo)?"Yes":"No" }}</td>
											<th>Hours of Operation</th>
											<td>
												<?php
													$time = $client->time;
													$timeStatus=false;
													if(!empty($time)){
														$time = json_decode($time);
														if(count($time)>0)
															$timeStatus=true;
													}
													if($timeStatus):
													?>
														<ul>
															<?php foreach($time as $k=>$v):?>
																<li>{{ ucfirst($k) }}: {{ $v->from }} to {{ $v->to }}</li>
															<?php endforeach; ?>
														</ul>
													<?php
													endif;
												?>
											</td>
										</tr>
										<tr>
											<th>Payment Mode Accepted:</th>
											<td>
												<?php
													$pma = $client->payment_mode_accepted;
													$pmaStatus=false;
													if(!empty($pma)){
														$pma = unserialize($pma);
														if(count($pma)>0)
															$pmaStatus=true;
													}
													if($pmaStatus):
													?>
														<ul>
															<?php foreach($pma as $k=>$v):?>
																<li>{{ $k }}</li>
															<?php endforeach; ?>
														</ul>
													<?php
													endif;
												?>
											</td>
											<th>Year of Establishment:</th>
											<td>{{ (null!==$client->year_of_estb)?$client->year_of_estb:"" }}</td>
										</tr>
										<tr>
											<th>Certifications:</th>
											<td>
												<?php
													$certifications = $client->certifications;
													$certificationsStatus=false;
													if(!empty($certifications)){
														$certifications = unserialize($certifications);
														if(count($certifications)>0)
															$certificationsStatus=true;
													}
													if($certificationsStatus):
													?>
														<ul>
															<?php foreach($certifications as $k=>$v):?>
																<li>{{ $v }}</li>
															<?php endforeach; ?>
														</ul>
													<?php
													endif;
												?>
											</td>
											<th>Logo:</th>
											<td>
												<?php
													$logo = $client->logo;
													$logoStatus=false;
													if(!empty($logo)){
														$logo = unserialize($logo);
														if(count($logo)>0)
															$logoStatus=true;
													}
													if($logoStatus):
													 
													?>
														<img src="/<?php echo asset($logo['thumbnail']['src']); ?>" alt="logo" />
													<?php
													endif;
												?>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<?php endforeach; ?>
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
			<!-- Modal -->
			<div id="generalPopup" class="modal fade" role="dialog">
				<div class="modal-dialog modal-md">
					<!-- Modal content-->
					<div class="modal-content">
					</div>
				</div>
			</div>
			<!-- Modal -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
