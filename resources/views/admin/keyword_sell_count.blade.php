@include('admin.header')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>{{$data['header']}}</h2>
                     
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <button type="button" class="btn btn-primary" style="color:#fff;margin-top:20px"><a href="{{url('developer/keyword_sell_count/add')}}" style="color:#fff"> <i class="fa fa-plus" aria-hidden="true"></i> Add keyword Sell</a></button>
                                 
                            
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
				
                    <div class="panel panel-info">
                        <div class="panel-body">			 

							@if(Request::segment(3)=='add'  || Request::segment(3)=='edit'  )
							<div class="nc-form row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							@if(Request::segment(3)=='add')
							<form class="keywordSell_form" method="post" onsubmit="return keywordSellCountController.saveKeywordSellCount(this)" autocomplete="off" enctype="multipart/form-data"> 

							@elseif(Request::segment(3)=='edit')

							<form class="keywordSell_form" method="post" autocomplete="off" action="" onsubmit="return keywordSellCountController.editSaveKeywordSellCount(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multipart/form-data">

							@endif
									{{ csrf_field() }}
									<div class="col-lg-3">
										<label for="name">Add New Keyword Package:</label>
										<input type="text" class="form-control" name="name" id="name" placeholder="Enter Key Category Name" value="{{ old('name',(isset($edit_data)) ? $edit_data->name:"")}}">
										@if ($errors->has('name'))
											<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="count">Keyword Max Count:</label>
										<input type="number" class="form-control" name="count" id="count" placeholder="Enter Key Category Count" value="{{ old('count',(isset($edit_data)) ? $edit_data->count:"")}}">
										@if ($errors->has('count'))
											<span class="help-block">
												<strong>{{ $errors->first('count') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="cat1_price">Category 1 Coin : 80,90)</label>
										<input type="number" class="form-control" name="cat1_price" id="cat1_price" value="{{ old('cat1_price',(isset($edit_data)) ? $edit_data->cat1_price:"")}}" placeholder="Category 1 Coin">
										@if ($errors->has('cat1_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat1_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="cat2_price">Category 2 Coin:(91,120)</label>
										<input type="number" class="form-control" name="cat2_price" id="cat2_price" value="{{ old('cat2_price',(isset($edit_data)) ? $edit_data->cat2_price:"")}}" placeholder="Category 2 Coin">
										@if ($errors->has('cat2_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat2_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="cat3_price">Category 3 Coin :(121,140)</label>
										<input type="number" class="form-control" name="cat3_price" id="cat3_price" value="{{ old('cat3_price',(isset($edit_data)) ? $edit_data->cat3_price:"")}}" placeholder="Category 3 Coin">
										@if ($errors->has('cat3_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat3_price') }}</strong>
											</span>
										@endif
									 
									</div>
									<div class="col-lg-3">
										<label for="cat3_price">Category 4 Coin :(141,180)</label>
										<input type="number" class="form-control" name="cat4_price" id="cat4_price" value="{{ old('cat4_price',(isset($edit_data)) ? $edit_data->cat4_price:"")}}" placeholder="Category 4 Coin">
										@if ($errors->has('cat4_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat4_price') }}</strong>
											</span>
										@endif
									 
									</div>
									
									<div class="col-lg-3">
										<label for="cat5_price">Category 5 Coin :(181,200)</label>
										<input type="number" class="form-control" name="cat5_price" id="cat5_price" value="{{ old('cat5_price',(isset($edit_data)) ? $edit_data->cat5_price:"")}}" placeholder="Category 5 Coin">
										@if ($errors->has('cat5_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat5_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="cat5_price">Category 6 Coin :(201,250)</label>
										<input type="number" class="form-control" name="cat6_price" id="cat6_price" value="{{ old('cat6_price',(isset($edit_data)) ? $edit_data->cat6_price:"")}}" placeholder="Category 6 Coin">
										@if ($errors->has('cat6_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat6_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="cat5_price">Category 7 Coin :(251,300)</label>
										<input type="number" class="form-control" name="cat7_price" id="cat7_price" value="{{ old('cat7_price',(isset($edit_data)) ? $edit_data->cat7_price:"")}}" placeholder="Category 7 Coin">
										@if ($errors->has('cat7_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat7_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="cat8_price">Category 8 Coin :(301,350)</label>
										<input type="number" class="form-control" name="cat8_price" id="cat8_price" value="{{ old('cat8_price',(isset($edit_data)) ? $edit_data->cat8_price:"")}}" placeholder="Category 8 Coin">
										@if ($errors->has('cat8_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat8_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="cat8_price">Category 9 Coin :(351,400)</label>
										<input type="number" class="form-control" name="cat9_price" id="cat9_price" value="{{ old('cat9_price',(isset($edit_data)) ? $edit_data->cat9_price:"")}}" placeholder="Category 9 Coin">
										@if ($errors->has('cat9_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat9_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3">
										<label for="cat10_price">Category 10 Coin :(401,500)</label>
										<input type="number" class="form-control" name="cat10_price" id="cat10_price" value="{{ old('cat10_price',(isset($edit_data)) ? $edit_data->cat10_price:"")}}" placeholder="Category 10 Coin">
										@if ($errors->has('cat10_price'))
											<span class="help-block">
												<strong>{{ $errors->first('cat10_price') }}</strong>
											</span>
										@endif
									</div>




									
										<div class="col-lg-3" style="margin-top:10px;">
										 
										<input type="submit" class="btn btn-info btn-block" class="form-control" style="margin-top:10px;">
									</div>
									
								</form>

									
							</div>
							@else
							 
<div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-keywordSellCounts">
                                <thead>
                                    <tr>
									 
                                        <th>Name</th>
                                        <th>Keyword Count</th>
                                        <th>Category 1 Coin</th>
                                        <th>Category 2 Coin</th>
                                        <th>Category 3 Coin</th>
                                         <th>Category 4 Coin</th>
                                        <th>Category 5 Coin</th>
                                        <th>Category 6 Coin</th>
                                        <th>Category 7 Coin</th>
                                        <th>Category 8 Coin</th>
                                        <th>Category 9 Coin</th>
                                        <th>Category 10 Coin</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                              
                            </table>
                      </div>
							@endif
							 
							 
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
							<input type="number" class="form-control" name="cat2_price" placeholder="Keyword Category 2 Price">
							<label style="margin-top:34px;">Keyword Category 3 Price:</label>
							<input type="number" class="form-control" name="cat3_price" placeholder="Keyword Category 3 Price">
							<label style="margin-top:34px;">Keyword Category 4 Price:</label>
							<input type="number" class="form-control" name="cat4_price" placeholder="Keyword Category 4 Price">
							
							<label style="margin-top:34px;">Keyword Category 5 Price:</label>
							<input type="number" class="form-control" name="cat5_price" placeholder="Keyword Category 5 Price">
							
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
        </div>
      

<?php echo View::make('admin/footer'); ?>
