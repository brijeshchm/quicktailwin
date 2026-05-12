<?php echo View::make('admin/header'); 
$cityArr = $parentCatArr = $childCatArr = $keywordArr = [];
foreach($cities as $city){
	$cityArr[$city->id] = $city->city;
}
foreach($parentCategories as $parentCategory){
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
								<form method="POST" action="/developer/business_keyword">
									{{ csrf_field() }}
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="city_id">Select City:</label>
										<select name="city_id" id="city_id" class="form-control select2-single">
											<?php foreach($cities as $city): ?>
											<option value="<?php echo $city->id; ?>"><?php echo $city->city; ?></option>
											<?php endforeach; ?>										
										</select>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="parent_category_id">Select Parent Category:</label>
										<select name="parent_category_id" id="parent_category_id" class="form-control select2-single">
											<option value=""></option>
											<?php foreach($parentCategories as $parent_category): ?>
											<option value="<?php echo $parent_category->id; ?>"><?php echo $parent_category->parent_category; ?></option>
											<?php endforeach; ?>
										</select>
										 
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="child_category_id">Select Child Category:</label>
										<select name="child_category_id" id="child_category_id" class="form-control select2-single">
										</select>
									</div>									
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="keyword_id">Select Keyword:</label>
										<select name="keyword_id" id="keyword_id" class="form-control select2-single">
										</select>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<label for="category">Select Keyword Category:</label>
										<select name="category" id="category" class="form-control select2-single">
											<option value="cat1_price">Category 1 (80)</option>
											<option value="cat2_price">Category 2(60)</option>
											<option value="cat3_price">Category 3(40)</option>
											<option value="cat4_price">Category 3(40)</option>
											<option value="cat5_price">Category 3(40)</option>
										</select>
									</div>									
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><label style="visibility:hidden">Submit</label><input type="submit" class="btn btn-info btn-block" class="form-control"></div>
								</form>
							</div>
							<?php if(isset($businessKeywords) && count($businessKeywords)>0): ?>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Business Keyword</th>
                                        <th>Category</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($businessKeywords as $businessKeyword): ?>
                                    <tr>
                                        <td>{{ strtolower($cityArr[$businessKeyword->city_id]).' '.strtolower($parentCatArr[$businessKeyword->parent_category_id]).' '.strtolower($childCatArr[$businessKeyword->child_category_id]).' '.strtolower($keywordArr[$businessKeyword->keyword_id]) }}</td>
                                        <td>{{ $businessKeyword->category }}</td>
                                        <td><a href="/developer/business_keyword/update_keyword/<?php echo $businessKeyword->id; ?>"><i class="fa fa-refresh fa-fw" aria-hidden="true"></i></a></td>
                                        <td><a href="javascript:void(0)" onclick="javascript:deleteBusinessKeyword({{$businessKeyword->id}},this)"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></td>
                                    </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
							<?php else: ?>
							<div class="alert alert-danger">
								No Child Category Found !!
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
			<div id="updateBusinessKeywordModal" class="modal fade" role="dialog">
				<div class="modal-dialog modal-sm">

				<!-- Modal content-->
				<div class="modal-content">
					<form method="POST" action="/developer/keyword/update">
						<div class="form-group">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								{{ csrf_field() }}
								<input type="hidden" name="id">

								<label>Select City:</label>
								<select name="city_id" id="update_city_id" class="form-control select2-single" style="width:100%">
									<?php foreach($cities as $city): ?>
									<option value="<?php echo $city->id; ?>"><?php echo $city->city; ?></option>
									<?php endforeach; ?>
								</select>								
								
								<label>Select Parent Category:</label>
								<select name="parent_category_id" id="update_parent_category_id" class="form-control select2-single" style="width:100%">
									<?php foreach($parentCategories as $parent_category): ?>
									<option value="<?php echo $parent_category->id; ?>"><?php echo $parent_category->parent_category; ?></option>
									<?php endforeach; ?>
								</select>
								
								<label style="margin-top:34px;">Select Child Category:</label>
								<select name="child_category_id" id="update_child_category_id" class="form-control select2-single" style="width:100%">
								</select>								
								
								<label style="margin-top:34px;">Select Keyword:</label>
								<select name="keyword_id" id="update_child_category_id" class="form-control select2-single" style="width:100%">
								</select>								
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
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
