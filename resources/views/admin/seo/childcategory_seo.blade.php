<?php echo View::make('admin/header'); ?>
        
 @if(Request::segment(2)=='childcategoryEdit'  && Request::segment(1)=='developer'  )
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Update SEO Fields - {{$keyword->child_category}}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			 <style>
/* ==== Custom Panel Section Styling ==== */
.section-border {
    border: 2px solid #ddd;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 30px;
    background-color: #f9f9f9;
}

.section-border h4 {
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    margin: -25px -25px 20px -25px;
    border-radius: 10px 10px 0 0;
    font-size: 18px;
    font-weight: 600;
}

.section-border label {
    font-weight: 500;
}

.btn-primary {
    border-radius: 5px;
}
.panel-body{

padding:0px;
}
</style>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">			
					@if(Session::has('alert-success'))
						<div class="alert alert-success">
							{{Session::get('alert-success')}}
						</div>
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Keyword SEO Fields Add
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<form class="form-horizontal" role="form" method="POST" action="{{ url('/developer/updateChildcategorySEO/seo/'.$keyword->id) }}">
								{{ csrf_field() }}

								<div class="form-group">
									<label for="meta_title" class="col-md-2 control-label">Meta Title</label>
									<div class="col-md-8">
										<textarea class="form-control" name="meta_title" placeholder="Enter Meta Title">{{ $keyword->meta_title }}</textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label for="meta_description" class="col-md-2 control-label">Meta Description</label>
									<div class="col-md-8">
										<textarea class="form-control" name="meta_description" placeholder="Enter Meta Description">{{ $keyword->meta_description }}</textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label for="meta_keywords" class="col-md-2 control-label">Meta Keywords</label>
									<div class="col-md-8">
										<textarea class="form-control" name="meta_keywords" placeholder="Enter Meta Keywords">{{ $keyword->meta_keywords }}</textarea>
									</div>
								</div>
								
								
								<div class="form-group">
									<label for="ratingValue" class="col-md-2 control-label">Rating Value</label>
									<div class="col-md-8">
									<select class="form-control" name="ratingvalue">
									<option value="">Select Rating Value</option>
									<?php 
									$rating = array(1,2,3,3.5,4,4.5,4.75,5);
									foreach($rating as $key=>$value){	
									?>
									<option value="<?php echo $value; ?>" @if ("$value"== old('ratingvalue'))
									selected="selected"	
									@else
									{{ (isset($keyword) && $keyword->ratingvalue ==$value ) ? "selected":"" }} @endif><?php echo $value; ?></option>
									<?php } ?>
									</select>
										 
									</div>
								</div>

								<div class="form-group">
									<label for="ratingcount" class="col-md-2 control-label">Rating Count</label>
									<div class="col-md-8">								 
										<input type="number" class="form-control" name="ratingcount" value="{{ $keyword->ratingcount }}">
									</div>
								</div>

								<div class="form-group">
									<label for="FAQ" class="col-md-2 control-label">FAQ Question 1</label>
									<div class="col-md-8">
										<input class="form-control" name="faqq1" placeholder="Enter FAQ Question 1" value="{{ $keyword->faqq1 }}">
									</div>
								</div>
								
								<div class="form-group">
									<label for="FAQ Answer 1" class="col-md-2 control-label">FAQ Answer 1</label>
									<div class="col-md-8">
										<textarea class="form-control" name="faqa1" placeholder="Enter FAQ Answer 1">{{ $keyword->faqa1 }}</textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label for="FAQ Question 2" class="col-md-2 control-label">FAQ Question 2</label>
									<div class="col-md-8">
										<input class="form-control" name="faqq2" placeholder="Enter FAQ Question 2" value="{{ $keyword->faqq2 }}">
									</div>
								</div>
								
								<div class="form-group">
									<label for="FAQ Answer 2" class="col-md-2 control-label">FAQ Answer 2</label>
									<div class="col-md-8">
										<textarea class="form-control" name="faqa2" placeholder="Enter FAQ Answer 2">{{ $keyword->faqa2 }}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="FAQ Question 3" class="col-md-2 control-label">FAQ Question 3</label>
									<div class="col-md-8">
										<input class="form-control" name="faqq3" placeholder="Enter FAQ Question 3" value="{{ $keyword->faqq3 }}">
									</div>
								</div>
								
								<div class="form-group">
									<label for="FAQ Answer 3" class="col-md-2 control-label">FAQ Answer 3</label>
									<div class="col-md-8">
										<textarea class="form-control" name="faqa3" placeholder="Enter FAQ Answer 3">{{ $keyword->faqa3 }}</textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label for="FAQ Question 4" class="col-md-2 control-label">FAQ Question 4</label>
									<div class="col-md-8">
										<input class="form-control" name="faqq4" placeholder="Enter FAQ Question 4" value="{{ $keyword->faqq4 }}">
									</div>
								</div>
								
								<div class="form-group">
									<label for="FAQ Answer 4" class="col-md-2 control-label">FAQ Answer 4</label>
									<div class="col-md-8">
										<textarea class="form-control" name="faqa4" placeholder="Enter FAQ Answer 4">{{ $keyword->faqa4 }}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="FAQ Question 5" class="col-md-2 control-label">FAQ Question 5</label>
									<div class="col-md-8">
										<input class="form-control" name="faqq5" placeholder="Enter FAQ Question 5" value="{{ $keyword->faqq5 }}">
									</div>
								</div>
								
								<div class="form-group">
									<label for="FAQ Answer 5" class="col-md-2 control-label">FAQ Answer 5</label>
									<div class="col-md-8">
										<textarea class="form-control" name="faqa5" placeholder="Enter FAQ Answer 5">{{ $keyword->faqa5 }}</textarea>
									</div>
								</div>
							
								
							
								
								<div class="form-group">
									<label for="top_description" class="col-md-2 control-label">Page Top Description(only 500 character )</label>
									<div class="col-md-8">
										<textarea class="form-control" name="top_description" placeholder="Enter Page Top Description"  rows="9">{{ $keyword->top_description }}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="bottom_description" class="col-md-2 control-label">Page Bottom Description</label>
									<div class="col-md-8">
										<textarea class="form-control" name="bottom_description" placeholder="Enter Page Bottom Description"  rows="9">{{ $keyword->bottom_description }}</textarea>
									</div>
								</div>	
								<div class="form-group">
									<div class="col-md-8 col-md-offset-2">
										<button type="submit" class="btn btn-primary">
											  Submit
										</button>
									</div>
								</div>
							</form>

							<div class="section-border">
            <h4>About Child Category Content</h4>
            <form class="form-horizontal" method="POST" onsubmit="return ChildController.updateAboutChildCategory(this,<?php echo (isset($keyword->id)? $keyword->id:""); ?>)" >
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="col-md-2 control-label">Heading</label>
                    <div class="col-md-8">
                        <input class="form-control" name="heading" value="{{ $keyword->heading }}" placeholder="Enter heading">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">About</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="courseabout" rows="5" placeholder="Enter About Section">{{ $keyword->courseabout }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Paragraph 1</label>
                    <div class="col-md-8">
                        <input class="form-control" name="paragraph1" value="{{ $keyword->paragraph1 }}" placeholder="Enter paragraph 1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Paragraph 2</label>
                    <div class="col-md-8">
                        <input class="form-control" name="paragraph2" value="{{ $keyword->paragraph2 }}" placeholder="Enter paragraph 2">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Paragraph 3</label>
                    <div class="col-md-8">
                        <input class="form-control" name="paragraph3" value="{{ $keyword->paragraph3 }}" placeholder="Enter paragraph 3">
                    </div>
                </div>
                <div class="form-group">
                    <label for="meta_keywords" class="col-md-2 control-label">paragraph4</label>
                    <div class="col-md-8">
                        <input class="form-control" name="paragraph4" placeholder="Enter paragraph4" value="{{ $keyword->paragraph4 }}"> 
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="meta_keywords" class="col-md-2 control-label">paragraph5</label>
                    <div class="col-md-8">
                        <input class="form-control" name="paragraph5" placeholder="Enter paragraph5" value="{{ $keyword->paragraph5 }}"> 
                    </div>
                </div>
                <div class="form-group">
                    <label for="meta_keywords" class="col-md-2 control-label">paragraph6</label>
                    <div class="col-md-8">
                        <input class="form-control" name="paragraph6" placeholder="Enter paragraph6" value="{{ $keyword->paragraph6 }}"> 
                    </div>
                </div>
                 <div class="form-group text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn"></i> Submit
                        </button>
                    </div>
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
        </div>
        <!-- /#page-wrapper -->

@else
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">				
                    <h1 class="page-header">Child Category For SEO</h1>
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
                            Child Category List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="datatable-seo" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Child Category</th>
											<th>Meta Title</th>
											<th>Meta Keywords</th>
											<th>Meta Description</th>
											<th>Action</th>
										 
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
@endif
<?php echo View::make('admin/footer'); ?>