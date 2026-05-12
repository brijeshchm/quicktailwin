<?php echo View::make('admin/header');
 
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
							<div class="nc-form row form-group">
								<form method="POST" onsubmit="return pushLeadController.updateKeywordBussiness(this)" class="ng-pristine ng-valid">
									{{ csrf_field() }}
									<div class="col-md-12">
										<h4><u>Update Keyword:</u></h4>
									</div>
									
									<input type="hidden" name="id" value="<?php echo $edit_data->id;  ?>">
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
                                        @if(!empty($parentCategories))
                                        @foreach($parentCategories as $category)
                                        <option value="{{$category->id}}" @if ($category->id== old('parent_category_id'))
                                        selected="selected"	
                                        @else
                                        {{ (isset($edit_data) && $edit_data->parent_category_id == $category->id ) ? "selected":"" }} @endif>{{$category->parent_category}}</option>
                                        @endforeach
                                        @endif
										</select>
										@if ($errors->has('parent_category_id'))
											<span class="help-block">
												<strong>{{ $errors->first('parent_category_id') }}</strong>
											</span>
										@endif
									 
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="child_category_id">Select Child Category:</label>
										<select name="child_category_id" id="child_category_id" class="form-control select2-single">
										    
										 @if(!empty($childCategories))
                                        @foreach($childCategories as $childC)
                                        <option value="{{$childC->id}}" @if ($childC->id== old('parent_category_id'))
                                        selected="selected"	
                                        @else
                                        {{ (isset($edit_data) && $edit_data->child_category_id == $childC->id ) ? "selected":"" }} @endif>{{$childC->child_category}}</option>
                                        @endforeach
                                        @endif
										
										    
										</select>
										@if ($errors->has('child_category_id'))
											<span class="help-block">
												<strong>{{ $errors->first('child_category_id') }}</strong>
											</span>
										@endif
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="keyword">Update New Keyword:</label>
										<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Enter Keyword" value="{{ $edit_data->keyword }}">
										
									     
										
										
										
										@if ($errors->has('keyword'))
											<span class="help-block">
												<strong>{{ $errors->first('keyword') }}</strong>
											</span>
										@endif
									</div>
									
									
									
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 match_ht">
										<label for="category">Category:</label>
										<select name="category"  class="form-control select2-single">
											<option value="Category 1" @if ('Category 1' == old('category'))
                                        selected="selected"	
                                        @else
                                        {{ (isset($edit_data) && $edit_data->category ==  'Category 1' ) ? "selected":"" }} @endif>Category 1(120)</option>
											<option value="Category 2"  @if ('Category 2' == old('category'))
                                        selected="selected"	
                                        @else
                                        {{ (isset($edit_data) && $edit_data->category ==  'Category 2' ) ? "selected":"" }} @endif >Category 2(100)</option>
											
										<option value="Category 3"  @if ('Category 3' == old('category'))
                                        selected="selected"	
                                        @else
                                        {{ (isset($edit_data) && $edit_data->category ==  'Category 3' ) ? "selected":"" }} @endif >Category 3(90)</option>
											
										<option value="Category 4"  @if ('Category 4' == old('category'))
                                        selected="selected"	
                                        @else
                                        {{ (isset($edit_data) && $edit_data->category == 'Category 4' ) ? "selected":"" }} @endif >Category 4(80)</option>
										
										<option value="Category 5"  @if ('Category 5' == old('category'))
                                        selected="selected"	
                                        @else
                                        {{ (isset($edit_data) && $edit_data->category ==  'Category 5' ) ? "selected":"" }} @endif >Category 5(70)</option>
										
										<option value="Category X"  @if ('Category X' == old('category'))
                                        selected="selected"	
                                        @else
                                        {{ (isset($edit_data) && $edit_data->category ==  'Category X' ) ? "selected":"" }} @endif >Category X</option>
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
									
									<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 match_ht">
										<label for="keyword">Related Keyword:</label>
									
										  @if(!empty($edit_data->related_keyword))
                                      <?php  $relatedKeyword = unserialize($edit_data->related_keyword); ?>
                                        
                                        
                                        @foreach($relatedKeyword as $value)
                                        
                                      <?php   $courseSelected[] = $value; ?>
                                        @endforeach
                                        @endif
                                        
                                         
									    <select name="related_keyword[]" id="related_keyword" class="form-control select2-single" multiple>
									        
                                        @foreach($keywords as $keyword)
                                        @if(isset($courseSelected) && in_array($keyword->id,$courseSelected))
                                        <option value="{{ $keyword->id }}" selected>{{ $keyword->keyword }}</option>
                                        @else
                                        <option value="{{ $keyword->id }}">{{ $keyword->keyword }}</option>
                                        @endif
                                        @endforeach
										
										</select>
										
										
										
										@if ($errors->has('related_keyword'))
											<span class="help-block">
												<strong>{{ $errors->first('related_keyword') }}</strong>
											</span>
										@endif
									</div>
									
									
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="" style="visibility:hidden">Submit:</label>
										<input type="submit" class="btn btn-info btn-block form-control">
									</div>
								</form>
							</div>
						 
							 
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
					<form method="POST"  onsubmit="return pushLeadController.updateKeywordBussiness(this)">
						<div class="form-group">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Update Keyword</h4>
						<div class="alert alert-danger" style="display:none;"></div>
						<div class="alert alert-success" style="display:none;"></div>
							</div>
							<div class="modal-body">
								{{ csrf_field() }}
								<input type="hidden" name="id" >

								<!--<div class="col-md-3">
									<label>Select City:</label>
									<select name="city_id" id="update_city_id" class="form-control select2-single" style="width:100%">
										<?php foreach($cities as $city): ?>
										<option value="<?php echo $city->id; ?>"><?php echo ucfirst($city->city); ?></option>
										<?php endforeach; ?>
									</select>
								</div>-->
								
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
										<option value="Category X">Category X</option>
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
			
			
			
				<div id="messageModal" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">

				<!-- Modal content-->
				<div class="modal-content">
				  
						<div class="form-group">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Update Keyword</h4>
						<div class="alert alert-danger" style="display:none;"></div>
						<div class="alert alert-success" style="display:none;"></div>
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
