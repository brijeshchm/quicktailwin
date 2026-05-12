<?php echo View::make('admin/header'); ?>
<style>

	.assign-elements{
		list-style-type: none;
	}
	.assign-elements ul li{
padding: 5px;

	}
	.dropdown-menu-right li{
			list-style-type: circle;
	}
</style>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
					<div class="col-lg-9 col-md-6 col-sm-12"><a href="{{ url('developer/classified-profile') }}"><h3>{{$data['title']}}</h3></a></div>
                    
					<div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <button type="button" class="btn btn-primary" style="color:#fff;margin-top:10px;margin-bottom: 20px;"><a href="{{url('developer/classified-profile/add')}}" style="color:#fff"> <i class="fa fa-plus" aria-hidden="true"></i> Add Classified Profile</a></button>
                                 
                            
                            </div>
                            <div class="p-2 d-flex">
                                
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
							<div class="nc-form row form-group{{ $errors->has('city') ? ' has-error' : '' }}">
							@if(Request::segment(3)=='add')
							<form class="classified_profile" method="post" onsubmit="return classifiedProfileController.saveClassifiedProfile(this)" autocomplete="off" enctype="multipart/form-data"> 

							@elseif(Request::segment(3)=='edit')

							<form class="classified_profile" method="post" autocomplete="off" action="" onsubmit="return classifiedProfileController.editSaveClassifiedProfile(this,<?php echo (isset($edit_data->id)? $edit_data->id:""); ?>)" enctype="multipart/form-data">

							@endif
									{{ csrf_field() }}
									 					 
								 					 
									   
									<div class="col-lg-6">
										<label for="State">Website<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup>:</label>
										
									<input type="text" class="form-control" name="website" placeholder="Enter Web site" value="{{ old('website',(isset($edit_data)) ? $edit_data->website:"")}}">
										@if ($errors->has('website'))
											<span class="help-block">
												<strong>{{ $errors->first('website') }}</strong>
											</span>
										@endif	
									</div>						 
									   
									<div class="col-lg-6">
										<label for="State">User Name:</label>
										
									<input type="text" class="form-control" name="user_name" placeholder="Enter User Name" value="{{ old('user_name',(isset($edit_data)) ? $edit_data->user_name:"")}}">
										@if ($errors->has('user_name'))
											<span class="help-block">
												<strong>{{ $errors->first('user_name') }}</strong>
											</span>
										@endif	
									</div>						 
									<div class="col-lg-6">
										<label for="State">Email<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup>:</label>
										
									<input type="text" class="form-control" name="email" placeholder="Enter email" value="{{ old('email',(isset($edit_data)) ? $edit_data->email:"")}}">
										@if ($errors->has('email'))
											<span class="help-block">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif	
									</div>						 
									<div class="col-lg-6">
										<label for="State">Password<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup>:</label>
										
									<input type="text" class="form-control" name="password" placeholder="Enter password" value="{{ old('password',(isset($edit_data)) ? $edit_data->password:"")}}">
										@if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif	
									</div>						 
									<div class="col-lg-6">
										<label for="State">Profile URL Link<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup>:</label>
										
									<input type="text" class="form-control" name="profile_url" placeholder="Enter profile url link" value="{{ old('profile_url',(isset($edit_data)) ? $edit_data->profile_url:"")}}">
										@if ($errors->has('profile_url'))
											<span class="help-block">
												<strong>{{ $errors->first('profile_url') }}</strong>
											</span>
										@endif	
									</div>						 
									   
									<div class="col-lg-6">
										<label for="Status">Status: </label>
										<select class="form-control" name="status">
											<option value="">Select Status</option>
											<option value="un-public" @if ("un-public"== old('status'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->status =='un-public' ) ? "selected":"" }} @endif>Un-Public</option>
									<option value="public" @if ("public"== old('status'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->status =="public" ) ? "selected":"" }} @endif>Public</option>
										</select>
						 

										@if ($errors->has('status'))
											<span class="help-block">
												<strong>{{ $errors->first('status') }}</strong>
											</span>
										@endif	
									</div>	
									<div class="col-lg-6">
										<label for="Status">SEO Activity: </label>
										<select class="form-control" name="seo_activity">
									<option value="">Select seo activity</option>
									<option value="Article" @if ("Article"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =='Article' ) ? "selected":"" }} @endif>Article</option>

									<option value="Blog" @if ("Blog"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Blog" ) ? "selected":"" }} @endif>Blog</option>

									<option value="Social Bookmarking" @if ("Social Bookmarking"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Social Bookmarking" ) ? "selected":"" }} @endif>Social Bookmarking</option>
								
									<option value="Classifieds" @if ("Classifieds"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Classifieds" ) ? "selected":"" }} @endif>Classifieds</option>

									<option value="Backlink Building" @if ("Backlink Building"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Backlink Building" ) ? "selected":"" }} @endif>Backlink Building</option>

									<option value="Guest Posting" @if ("Guest Posting"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Guest Posting" ) ? "selected":"" }} @endif>Guest Posting</option>
									<option value="Forum Posting" @if ("Forum Posting"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Forum Posting" ) ? "selected":"" }} @endif>Forum Posting</option>

									<option value="Directory Submissions" @if ("Directory Submissions"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Directory Submissions" ) ? "selected":"" }} @endif>Directory Submissions</option>

									<option value="Influencer Outreach" @if ("Influencer Outreach"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Influencer Outreach" ) ? "selected":"" }} @endif>Influencer Outreach</option>

									<option value="Social Media Promotion" @if ("Social Media Promotion"== old('seo_activity'))
									selected="selected"	
									@else
									{{ (isset($edit_data) && $edit_data->seo_activity =="Social Media Promotion" ) ? "selected":"" }} @endif>Social Media Promotion</option>






										</select>
						 

										@if ($errors->has('status'))
											<span class="help-block">
												<strong>{{ $errors->first('status') }}</strong>
											</span>
										@endif	
									</div>	
				 
																	
								<div class="col-lg-3">										 
										<input type="submit" class="btn btn-info btn-block" class="form-control" style="margin-top:25px;">
									</div>


								</form>
							</div>
						@else
						<div class="nc-form row form-group">
								<form method="GET" action="" onsubmit="return filterAjaxSeoWork('datatable-seo-work',this)" autocomplete="off">
									{{ csrf_field() }}
									 						 
									 
									<div class="form-group">
										<div class="col-md-3">
											<label>Date From</label>
											<input type="text" class="form-control datef" name="search[datef]" value="{{ old('search[datef]',(isset($search['datef'])) ? $search['datef']:"")}}" placeholder="Create Date From">
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label>Date To</label>
											<input type="text" class="form-control datet" name="search[datet]" value="{{ old('search[datet]',(isset($search['datet'])) ? $search['datet']:"")}}" placeholder="Create Date To">
										</div>
									</div>
									 								 
								 
									<div class="form-group">
									<div class="col-md-3">
									<label>Select User</label>
									<select class="form-control select2-single" name="search[user]">
									<option value="">Select User</option>
									<?php $getUserList = getUserList(); ?>
									@if(isset($getUserList))
									@foreach($getUserList as $counsellor)
									@if(isset($search['user']) && $search['user']==$counsellor->id)
									<option value="{{ $counsellor->id }}" selected>{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
									@else
									<option value="{{$counsellor->id}}"  >{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
									@endif
									@endforeach
									@endif
									</select>
									</div>
									</div>
									<div class="form-group">
										<div class="col-md-3">
											<label style="visibility:hidden">Filter</label>
											<button type="submit" class="btn btn-block btn-info">Filter</button>
										</div>
									</div>
								</form>
							</div>
				
							  <div class="table-responsive table-virtical-grid">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-classified-profile">
                                <thead>
                                    <tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th>
                                      
                                    <th>Website</th>                                       
                                        <th>Email</th>
                                        <th>Password</th>
										<th>Profile URL Link</th>								 
										<th>Date </th>                                  
										<th>Owner </th>                                  
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
								 
                            </table>
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
		
	
        <!-- /#page-wrapper -->

<?php echo View::make('admin/footer'); ?>
