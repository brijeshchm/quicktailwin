<?php echo View::make('admin/header');
$cityArr = $parentCatArr = $childCatArr = $keywordArr = [];
foreach($cities as $city){
	$cityArr[$city->id] = $city->city;
}
foreach($parent_categories as $parentCategory){
	$parentCatArr[$parentCategory->id] = $parentCategory->parent_category;
}
foreach($childCategories as $childCategory){
	$childCatArr[$childCategory->id] = $childCategory->child_category;
}
foreach($keywords as $keyword){
	$keywordArr[$keyword->id] = $keyword->keyword;
}
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Business Keywords</h1>
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
							<div class="nc-form row form-group{{ $errors->has('keyword') ? ' has-error' : '' }}">
								<form method="POST" action="/developer/keyword">
									{{ csrf_field() }}
									<div class="col-md-12">
										<h4><u>Add Keyword:</u></h4>
									</div>
									<!--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="city_id">Select City:</label>
										<select name="city_id" id="city_id" class="form-control select2-single">
											<?php foreach($cities as $city): ?>
											<option value="<?php echo $city->id; ?>"><?php echo $city->city; ?></option>
											<?php endforeach; ?>										
										</select>
									</div>	-->								
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="parent_category_id">Select Parent Category:</label>
										<select name="parent_category_id" id="parent_category_id" class="form-control select2-single">
											<option value=""></option>
											<?php foreach($parent_categories as $parent_category): ?>
											<option value="<?php echo $parent_category->id; ?>"><?php echo $parent_category->parent_category; ?></option>
											<?php endforeach; ?>
										</select>
										@if ($errors->has('parent_category_id'))
											<span class="help-block">
												<strong>{{ $errors->first('parent_category_id') }}</strong>
											</span>
										@endif
										<!--input type="text" class="form-control" name="parent_category_id" id="parent_category_id" placeholder="Enter Parent Category" value="{{ old('child_category') }}"-->
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="child_category_id">Select Child Category:</label>
										<select name="child_category_id" id="child_category_id" class="form-control select2-single">
										</select>
										@if ($errors->has('child_category_id'))
											<span class="help-block">
												<strong>{{ $errors->first('child_category_id') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="keyword">Add New Keyword:</label>
										<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Enter Keyword" value="{{ old('keyword') }}">
										@if ($errors->has('keyword'))
											<span class="help-block">
												<strong>{{ $errors->first('keyword') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="category">Category:</label><?php //echo"<pre>";print_r($keywordSellCounts); ?>
										<select name="category" id="category" class="form-control select2-single category">
											<option value="">Select Category</option>										 
											<option value="Category 1">Category 1 ({{ $keywordSellCounts->cat1_price }})</option>
											<option value="Category 2">Category 2 ({{ $keywordSellCounts->cat2_price }})</option>										 
											<option value="Category 3">Category 3 ({{ $keywordSellCounts->cat3_price }})</option>
											<option value="Category 4">Category 4 ({{ $keywordSellCounts->cat4_price }})</option>
											<option value="Category 5">Category 5 ({{ $keywordSellCounts->cat5_price }})</option>
											<option value="Category 6">Category 6 ({{ $keywordSellCounts->cat6_price }})</option>
											<option value="Category 7">Category 7 ({{ $keywordSellCounts->cat7_price }})</option>
											<option value="Category 8">Category 8 ({{ $keywordSellCounts->cat8_price }})</option>
											<option value="Category 9">Category 9 ({{ $keywordSellCounts->cat9_price }})</option>
											<option value="Category 10">Category 10 ({{ $keywordSellCounts->cat10_price }})</option>
											<option value="Category X">Category X</option>
										</select>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 premium_price match_ht">
										<label for="premium_price">Daimond Price:</label>
										<input type="number" class="form-control" name="premium_price" id="premium_price" placeholder="Enter Price" value="{{ old('premium_price') }}">
										@if ($errors->has('premium_price'))
											<span class="help-block">
												<strong>{{ $errors->first('premium_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 platinum_price match_ht">
										<label for="platinum_price">Platinum Price:</label>
										<input type="number" class="form-control" name="platinum_price" id="platinum_price" placeholder="Enter Price" value="{{ old('platinum_price') }}">
										@if ($errors->has('platinum_price'))
											<span class="help-block">
												<strong>{{ $errors->first('platinum_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 royal_price match_ht">
										<label for="royal_price">Royal Price:</label>
										<input type="number" class="form-control" name="royal_price" id="royal_price" placeholder="Enter Price" value="{{ old('royal_price') }}">
										@if ($errors->has('royal_price'))
											<span class="help-block">
												<strong>{{ $errors->first('royal_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 king_price match_ht">
										<label for="king_price">King Price:</label>
										<input type="number" class="form-control" name="king_price" id="king_price" placeholder="Enter Price" value="{{ old('king_price') }}">
										@if ($errors->has('king_price'))
											<span class="help-block">
												<strong>{{ $errors->first('king_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 preferred_price match_ht">
										<label for="preferred_price">Preferred Price:</label>
										<input type="number" class="form-control" name="preferred_price" id="preferred_price" placeholder="Enter Price" value="{{ old('preferred_price') }}">
										@if ($errors->has('preferred_price'))
											<span class="help-block">
												<strong>{{ $errors->first('preferred_price') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="" style="visibility:hidden">Submit:</label>
										<input type="submit" class="btn btn-info btn-block form-control">
									</div>
								</form>
							</div>
							<div class="nc-form row">
								<div class="col-md-12">
									<h4><u>Filter KWDS:</u></h4>
								</div>
								<form method="GET">
									{{ csrf_field() }}
									<!--<div class="form-group col-md-3">
										<label>City</label>
										<select class="form-control" name="search[city]">
											<option value="">-- SELECT CITY --</option>
											@if(count($fCities)>0)
												@foreach($fCities as $city)
													@if(isset($search['city']) && $search['city']==$city->id)
														<option value="{{ $city->id }}" selected>{{ $city->city }}</option>
													@else
														<option value="{{ $city->id }}">{{ $city->city }}</option>
													@endif
												@endforeach
											@endif
										</select>
									</div>-->
									<div class="form-group col-md-3">
										<label>Parent Category</label>
										<select class="form-control" name="search[pc]">
											<option value="">-- SELECT PC --</option>
											@if(count($fParentCategories)>0)
												@foreach($fParentCategories as $city)
													@if(isset($search['pc']) && $search['pc']==$city->id)
														<option value="{{ $city->id }}" selected>{{ $city->parent_category }}</option>
													@else
														<option value="{{ $city->id }}">{{ $city->parent_category }}</option>
													@endif
												@endforeach
											@endif
										</select>
									</div>
									<div class="form-group col-md-3">
										<label>Child Category</label>
										<select class="form-control" name="search[cc]">
											<option value="">-- SELECT CC --</option>
											@if(count($fChildCategories)>0)
												@foreach($fChildCategories as $city)
													@if(isset($search['cc']) && $search['cc']==$city->id)
														<option value="{{ $city->id }}" selected>{{ $city->child_category }}</option>
													@else
														<option value="{{ $city->id }}">{{ $city->child_category }}</option>
													@endif
												@endforeach
											@endif
										</select>
									</div>
									<div class="form-group col-md-3">
										<label>Category</label>
										<select class="form-control" name="search[cat]">
											<option value="">-- SELECT CATEGORY --</option>
											@if(count($fCategories)>0)
												@foreach($fCategories as $city)
													@if(isset($search['cat']) && $search['cat']==$city->category)
														<option value="{{ $city->category }}" selected>{{ $city->category }}</option>
													@else
														<option value="{{ $city->category }}">{{ $city->category }}</option>
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
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-view-all-kwds">
                                <thead>
                                    <tr>
                                        <th>SEO</th>
                                        <th>Keyword</th>
										<!--<th>City</th>
                                        <th>KWC</th-->
                                        <th>Child</th>
                                        <th>Parent</th>
                                        <th>Category</th>
                                        <!--th>Premium_Price</th>
                                        <th>Platinum_Price</th>
                                        <th>Royal_Price</th>
                                        <th>King_Price</th>
                                        <th>Preferred_Price</th>
                                        <th>Premium_Sold</th>
                                        <th>Platinum_Sold</th>
                                        <th>Royal_Sold</th>
                                        <th>King_Sold</th>
                                        <th>Preferred_Sold</th-->
                                         <th>Icon</th>
                                        <th>Action</th>
                                         
                                    </tr>
                                </thead>
								<tfoot>
                                    <tr>
                                        <th>Keyword</th>
										<!--<th>City</th>
                                        <th>KWC</th-->
                                        <th>Child</th>
                                        <th>Parent</th>
                                        <th>Category</th>
                                        <!--th>Premium_Price</th>
                                        <th>Platinum_Price</th>
                                        <th>Royal_Price</th>
                                        <th>King_Price</th>
                                        <th>Preferred_Price</th>
                                        <th>Premium_Sold</th>
                                        <th>Platinum_Sold</th>
                                        <th>Royal_Sold</th>
                                        <th>King_Sold</th>
                                        <th>Preferred_Sold</th-->
                                           <th>Icon</th>
                                        <th>Action</th>
                                       
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- /.table-responsive -->
								@if((Auth::user()->current_user_can('administrator')) || Auth::user()->current_user_can('export_keyword') )
							<form id="export-kwds" method="POST" onsubmit="return exportKwds()" action="{{ url('/developer/keyword/getkwdsexcel') }}">
								{{ csrf_field() }}
								<input type="hidden" name="search[city]" value="">
								<input type="hidden" name="search[pc]" value="">
								<input type="hidden" name="search[cc]" value="">
								<input type="hidden" name="search[cat]" value="">
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

			<!-- Modal -->
			<div id="updateKeywordModal" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
					<form method="POST"  onsubmit="return pushLeadController.updateKeywordBussiness(this)" enctype="multipart/form-data">
						<div class="form-group">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Update Keyword</h4>
						<div class="alert alert-danger" style="display:none;"></div>
						<div class="alert alert-success" style="display:none;"></div>
							</div>
							<div class="modal-body">
								{{ csrf_field() }}
								<input type="hidden" name="id">								
								<div class="col-md-3 keyv">
									<label>Select Parent Category:</label>
									<select name="parent_category_id" id="update_parent_category_id" class="form-control select2-single" style="width:100%">
										<?php foreach($parent_categories as $parent_category): ?>
										<option value="<?php echo $parent_category->id; ?>"><?php echo $parent_category->parent_category; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								
								<div class="col-md-3 keyv">
									<label>Select Child Category:</label>
									<select name="child_category_id" id="update_child_category_id" class="form-control select2-single" style="width:100%">
									</select>
								</div>
								
								<div class="col-md-3 keyv">
									<label>Enter Keyword:</label>
									<input type="text" class="form-control" id="update_keyword" name="keyword" placeholder="Enter Child Category">
								</div>
								
								<div class="col-md-3 ">
									<label>Select Category:</label>
									<select name="category" id="update_category" class="form-control select2-single category" style="width:100%">
										<option value="Category 1">Category 1 ({{ $keywordSellCounts->cat1_price }})</option>
											<option value="Category 2">Category 2 ({{ $keywordSellCounts->cat2_price }})</option>										 
											<option value="Category 3">Category 3 ({{ $keywordSellCounts->cat3_price }})</option>
											<option value="Category 4">Category 4 ({{ $keywordSellCounts->cat4_price }})</option>
											<option value="Category 5">Category 5 ({{ $keywordSellCounts->cat5_price }})</option>
											<option value="Category 6">Category 6 ({{ $keywordSellCounts->cat6_price }})</option>
											<option value="Category 7">Category 7 ({{ $keywordSellCounts->cat7_price }})</option>
											<option value="Category 8">Category 8 ({{ $keywordSellCounts->cat8_price }})</option>
											<option value="Category 9">Category 9 ({{ $keywordSellCounts->cat9_price }})</option>
											<option value="Category 10">Category 10 ({{ $keywordSellCounts->cat10_price }})</option>
									</select>
								</div>
								
								<div class="col-md-3 premium_price">
									<label>Premium Price:</label>
									<input type="number" class="form-control" id="update_premium_price" name="premium_price">
								</div>
								
								<div class="col-md-3 platinum_price">
									<label>Platinum Price:</label>
									<input type="number" class="form-control" id="update_platinum_price" name="platinum_price">
								</div>
								
								<div class="col-md-3 royal_price">
									<label>Royal Price:</label>
									<input type="number" class="form-control" id="update_royal_price" name="royal_price">
								</div>
								
								<div class="col-md-3 king_price">
									<label>King Price:</label>
									<input type="number" class="form-control" id="update_king_price" name="king_price">
								</div>
								
								<div class="col-md-3 preferred_price">
									<label>Preferred Price:</label>
									<input type="number" class="form-control" id="update_preferred_price" name="preferred_price">
								</div>
								
						 
								
								<div class="col-md-8">
									<label>Related Keyword:</label>
									 <select class="form-control select2-single" name="related_keyword[]" multiple>
									   <option value="">Select Keyword</option>
									   @if(!empty($keywords))
									   @foreach($keywords as $keyVal)
									    <option value="{{$keyVal->id}}">{{$keyVal->keyword}}</option>
									    @endforeach
									    @endif
									     
									     </select>
								</div>
								
								
								
								<div class="clearfix"></div>
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
			<!-- deleteKeywordModal -->
			<div id="deleteClient" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
					</div>
				</div>
			</div>

			<!-- Modal -->
			<!-- deleteKeywordModal -->
			<div id="showBucketViewCityZone" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
					</div>
				</div>
			</div>
			<!-- deleteKeywordModal -->
        </div>
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
