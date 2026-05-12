<?php echo View::make('admin/header'); ?>
        <div id="page-wrapper">
           <div class="row">
               <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2><a href="{{url('developer/blog/blogdetails')}}">Blog Details</a></h2>
                     
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <button type="button" class="btn btn-primary" style="color:#fff;margin-top:20px"><a href="{{url('developer/blog/addBlog')}}" style="color:#fff"> <i class="fa fa-plus" aria-hidden="true"></i> Add Blog</a></button>
                                 
                            
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                <!-- /.col-lg-12 -->
            </div>
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

<div class="panel panel-default">
  

    <div class="panel-body">
         
        <div class="section-border">
            <h4>Blog Information</h4>
            <form class="form-horizontal" method="POST" onsubmit="return blogController.updateBlogMeta(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
                {{ csrf_field() }}


                <div class="form-group">
						<label for="name" class="col-md-2 control-label">Author</label>
						<div class="col-md-8">
							<select type="text" class="form-control" name="author" >
								<option value="">Select Author</option>
								@if($authors)
									@foreach($authors as $author)

									<option value="{{ $author->id}}" @if ($author->id== old('author'))
                    selected="selected"	
                    @else
                    {{ (isset($edit_data) && $edit_data->author ==$author->id ) ? "selected":"" }} @endif>{{ $author->name}}</option>
									@endforeach
									@endif
								

							</select>
							@if ($errors->has('author'))
								<span class="error alert-danger">
									<strong>{{ $errors->first('author') }}</strong>
								</span>
							@endif
						</div>
					</div>	


                <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" value="{{ old('name',(isset($edit_data)) ? $edit_data->name:"")}}" placeholder="Enter "> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="title" value="{{ old('title',(isset($edit_data)) ? $edit_data->title:"")}}" placeholder="Enter Title">      
                                   </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Slug</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="slug" value="{{ old('slug', $edit_data->slug ?? '') }}" placeholder="Enter slug url"> 
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Meta Title</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="meta_title" placeholder="Enter Meta Title">{{ old('meta_title', $edit_data->meta_title ?? '') }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Meta Description</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="meta_description" placeholder="Enter Meta Description">{{ old('meta_description', $edit_data->meta_description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Meta Keywords</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="meta_keywords" placeholder="Enter Meta Keywords" rows="5">{{ old('meta_keywords', $edit_data->meta_keywords ?? '') }}</textarea>
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
                    <option value="<?php echo $value; ?>"  @if ("$value"== old('ratingvalue'))
                    selected="selected"	
                    @else
                    {{ (isset($edit_data) && $edit_data->ratingvalue ==$value ) ? "selected":"" }} @endif><?php echo $value; ?></option>
                    <?php } ?>
                    </select>
                            
                    </div>
                </div>

                <div class="form-group">
                    <label for="ratingcount" class="col-md-2 control-label">Rating Count</label>
                    <div class="col-md-8">								 
                        <input type="number" class="form-control" name="ratingcount" value="{{ old('ratingcount', $edit_data->ratingcount ?? '') }}">
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="hidden" name="submit" value="Update">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn"></i> Update
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ==================== PAGE CONTENT SECTION ==================== --}}
        <div class="section-border">
            <h4>About Description</h4>
            <form class="form-horizontal" method="POST" onsubmit="return blogController.updateAboutBlog(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" >
                {{ csrf_field() }}

                <!-- <div class="form-group">
                    <label class="col-md-2 control-label">Heading</label>
                    <div class="col-md-8">
                        <input class="form-control" name="heading" value="{{ $edit_data->heading }}" placeholder="Enter heading">
                    </div>
                </div> -->

                 <div class="form-group">
                    <label class="col-md-2 control-label">Description</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="description" placeholder="Enter description" rows="7">{{ old('description', $edit_data->description ?? '') }}</textarea>
                    </div>
                </div>

                
                 <div class="form-group text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn"></i> Update Blog 
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="section-border">
            <h4>Page Content</h4>
            <form class="form-horizontal" method="POST" onsubmit="return blogController.updatePageContent(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" >
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-md-2 control-label">Page Top Description (max 500 chars)</label>
                    <div class="col-md-10">
                        <textarea class="form-control summernote" id="editor" name="top_content" rows="20" placeholder="Enter Page Top Description">{{ old('top_content', $edit_data->top_content ?? '') }}</textarea>
                    </div>
                </div>
            <div class="form-group ">
                <label for="bottom_content" class="col-md-2 control-label">Page Bottom Description</label>
                <div class="col-md-10">
                <textarea class="form-control summernote" id="editor" name="bottom_content" placeholder="Enter Page Bottom Description" rows="15">{{ old('bottom_content', $edit_data->bottom_content ?? '') }}</textarea>
                </div>
            </div>	
            <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn"></i> Submit
            </button>
        </div>
            </form>
        </div>

  {{-- ==================== PAGE CONTENT SECTION ==================== --}}
        <div class="section-border">
            <h4>Blog Image</h4>
            <form class="form-horizontal" method="POST" onsubmit="return blogController.updateBlogImage(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group">
                    <label class="col-md-2 control-label">Image(900*400)</label>
                    <div class="col-md-8">                    

                    <?php 
                        if(!empty($edit_data->image)){
                        $image = unserialize($edit_data->image);
                        $image = $image['large']['src'];
                        ?>
                        @if(isset($image)&&!empty($image))
                        <img loading="lazy" src="{{url($image)}}" style="height:75px;width:75px;">
                        <a href="{{url('developer/blog/del_icon/'.$edit_data->id)}}" title="remove"><i class="fa fa-times fa-fw" aria-hidden="true"></i></a>
                        <input type="hidden" class="" name="image" value="{{ $edit_data->image }}" >
                        @endif
                        <?php  }else{ ?>
                            <input type="file" class="form-control" name="image"  accept=".jpg, .jpeg, .png, .webp">
                        <?php  } ?>
                        @if ($errors->has('image'))
                            <span class="error alert-danger">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
									<label for="image" class="col-md-2 control-label">Image banner(900*250)<span>*</span></label>
									<div class="col-md-7">
										
										<span class="blog-block">									 
										<?php 
										if(!empty($edit_data->image_banner)){
									 	$bimage = unserialize($edit_data->image_banner);
										$imagev = $bimage['large']['src'];
										?>
										@if(isset($imagev)&&!empty($imagev))
										<img loading="lazy" src="{{url($imagev)}}" style="height:75px;width:75px;">
										<a href="{{url('developer/blog/del_blog_banner/'.$edit_data->id)}}" title="remove"><i class="fa fa-times fa-fw" aria-hidden="true"></i></a>
										<input type="hidden" class="" name="image_banner" value="{{ $edit_data->image_banner }}" >
										@endif
										<?php  }else{ ?>
										 <input type="file" class="form-control" name="image_banner"  accept=".jpg, .jpeg, .png, .webp">
 										<?php  } ?>
										@if ($errors->has('image_banner'))
											<span class="error alert-danger">
												<strong>{{ $errors->first('image_banner') }}</strong>
											</span>
										@endif
										</span>
									</div>
								</div>
                 
 
                 <div class="form-group text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" name="submit" value="update_image" class="btn btn-primary">
                            <i class="fa fa-btn"></i> Update Image
                        </button>
                    </div>
                </div>
            </form>
        </div>


        {{-- ==================== FAQ SECTION ==================== --}}
        <div class="section-border">
            <h4>FAQ Section</h4>
            <form class="form-horizontal" method="POST" onsubmit="return blogController.updateFaqBlog(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)">
                {{ csrf_field() }}

        <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 1</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq1" placeholder="Enter FAQ Question 1" value="{{ $edit_data->faqq1 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 1</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa1" placeholder="Enter FAQ Answer 1">{{ $edit_data->faqa1 }}</textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 2</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq2" placeholder="Enter FAQ Question 2" value="{{ $edit_data->faqq2 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 2</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa2" placeholder="Enter FAQ Answer 2">{{ $edit_data->faqa2 }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 3</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq3" placeholder="Enter FAQ Question 3" value="{{ $edit_data->faqq3 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 3</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa3" placeholder="Enter FAQ Answer 3">{{ $edit_data->faqa3 }}</textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 4</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq4" placeholder="Enter FAQ Question 4" value="{{ $edit_data->faqq4 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 4</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa4" placeholder="Enter FAQ Answer 4">{{ $edit_data->faqa4 }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 5</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq5" placeholder="Enter FAQ Question 5" value="{{ $edit_data->faqq5 }}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 5</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa5" placeholder="Enter FAQ Answer 5">{{ $edit_data->faqa5 }}</textarea>
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
</div>

                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
 
 
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script type="text/javascript">
$('.summernote').summernote({
height: 500
});
</script>
<?php echo View::make('admin/footer'); ?>