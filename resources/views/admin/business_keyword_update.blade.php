<?php echo View::make('admin/header');
$cityArr = $parentCatArr = $childCatArr = $keywordArr = [];
foreach ($cities as $city) {
	$cityArr[$city->id] = $city->city;
}
foreach ($parentCategories as $parentCategory) {
	$parentCatArr[$parentCategory->id] = $parentCategory->parent_category;
}
foreach ($childCategories as $childCategory) {
	$childCatArr[$childCategory->id] = $childCategory->child_category;
}
foreach ($keywords as $keyword) {
	$keywordArr[$keyword->id] = $keyword->keyword;
}
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Business Keyword Update</h1>
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
					<div class="row form-group{{ $errors->has('keyword') ? ' has-error' : '' }}">
						<form method="POST" action="/developer/business_keyword/update">
							{{ csrf_field() }}
							<input type="hidden" name="id" value="<?php echo $businessKeyword->id; ?>">
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<label for="city_id">Select City:</label>
								<select name="city_id" id="city_id" class="form-control select2-single">
									<?php foreach ($cities as $city): ?>
									<?php
	$selected = '';
	if ($city->id == $businessKeyword->city_id)
		$selected = 'selected';
											?>
									<option value="<?php echo $city->id; ?>" <?php echo $selected; ?>>
										<?php echo $city->city; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<label for="parent_category_id">Select Parent Category:</label>
								<select name="parent_category_id" id="parent_category_id"
									class="form-control select2-single">
									<option value=""></option>
									<?php foreach ($parentCategories as $parent_category): ?>
									<?php
	$selected = '';
	if ($parent_category->id == $businessKeyword->parent_category_id)
		$selected = 'selected';
											?>
									<option value="<?php echo $parent_category->id; ?>" <?php echo $selected; ?>>
										<?php echo $parent_category->parent_category; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<label for="child_category_id">Select Child Category:</label>
								<select name="child_category_id" id="child_category_id"
									class="form-control select2-single">
									<option value=""></option>
									<?php foreach ($childCategories as $child_category): ?>
									<?php
	$selected = '';
	if ($child_category->id == $businessKeyword->child_category_id)
		$selected = 'selected';
											?>
									<option value="<?php echo $child_category->id; ?>" <?php echo $selected; ?>>
										<?php echo $child_category->child_category; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<label for="keyword_id">Select Keyword:</label>
								<select name="keyword_id" id="keyword_id" class="form-control select2-single">
									<option value=""></option>
									<?php foreach ($keywords as $keyword): ?>
									<?php
	$selected = '';
	if ($keyword->id == $businessKeyword->keyword_id)
		$selected = 'selected';
											?>
									<option value="<?php echo $keyword->id; ?>" <?php echo $selected; ?>>
										<?php echo $keyword->keyword; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								<label for="category">Select Keyword Category:</label>
								<select name="category" id="category" class="form-control select2-single">
									<option value="cat1_price" <?php echo ($businessKeyword->category == 'cat1_price') ? "selected" : ""; ?>>Category 1</option>
									<option value="cat2_price" <?php echo ($businessKeyword->category == 'cat2_price') ? "selected" : ""; ?>>Category 2</option>
									<option value="cat3_price" <?php echo ($businessKeyword->category == 'cat3_price') ? "selected" : ""; ?>>Category 3</option>
								</select>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><label
									style="visibility:hidden">Submit</label><input type="submit"
									class="btn btn-info btn-block" class="form-control"></div>
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
</div>
<!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>