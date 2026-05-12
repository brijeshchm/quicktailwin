            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--<li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            
                        </li>--> 
		 
						@if(Auth::user()->current_user_can('client_dashboard'))
						<li>
                            <a href="{{url('/developer/dashboard')}}"><i class="fa fa-th-large"></i> Client Dashboard</a>
                        </li>
					 	@endif	
						
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('lead_dashboard') )
						
						
						<li>
                            <a href="#"><i class="fa fa-registered"></i> Leads Dashboard<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li>
								<a href="{{url('/developer/lead-dashboard')}}"><i class=""></i>Leads Dashboard</a>
								</li>
						 
								<li>
								<a href="{{url('/developer/lead-conversion')}}"><i class=""></i>Leads Conversion</a>
								</li>
							 
						 
                            </ul>
                            
                        </li>		
						
						
					 	@endif	
						
					 @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_lead'))
							<li>
								<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Leads<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{url('/developer/new-lead')}}"><i class=""></i> Assign Leads</a>
									</li>	
									@if(Auth::user()->current_user_can('administrator'))									
									<!--<li>
										<a href="/developer/lead"><i class="fa fa-leanpub fa-fw"></i> All Leads</a>
									</li>-->
									@endif
										@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('add_lead'))		
								<li>
										<a href="{{url('/developer/lead/add-lead')}}"><i class=""></i> Add Lead</a>
									</li>
									@endif
									@if(Auth::user()->current_user_can('administrator'))		
										<li>
										<a href="{{url('/developer/push-lead')}}"><i class=""></i> Push Leads</a>
									</li>
								@endif
								
								@if(Auth::user()->current_user_can('administrator'))		
										<li>
										<a href="{{url('/developer/new-lead/not-interested')}}"><i class=""></i> Not Interested</a>
									</li>
								@endif
								</ul>
							</li>
							@endif
						@if(Auth::user()->current_user_can('administrator'))							
						 <li>
                            <a href="#"><i class="fa fa-plus-square fa-fw"></i>Roles &amp; Capabilities<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/developer/permission')}}"><i class=""></i> Permissions</a>
                                </li>
						 
                                <li>
                                    <a href="{{url('/developer/role-permission')}}"><i class=""></i> Role Permissions</a>
                                </li>
							 
                                <li>
                                    <a href="{{url('/developer/form-type')}}"><i class=""></i> Form Type</a>
                                </li>
							 
						 
                            </ul>
                            
                        </li>
						@endif
                        @if(Auth::user()->current_user_can('administrator') )
						<li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> Users<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/developer/list-users')}}"><i class=""></i> All Users</a>
                                </li>
							     @if(Auth::user()->current_user_can('administrator'))
                                <li>
                                    <a href="{{url('/developer/register')}}"><i class=""></i> Create User</a>
                                </li>
								@endif
                            </ul>
                            
                        </li>	
						
						@endif
						
					  @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager') || Auth::user()->current_user_can('all_city') )
                        <li>
                            <a href="{{url('/developer/cities')}}"><i class="fa fa-balance-scale fa-fw"></i> Client Cities</a>
                        </li>	 
						@endif
						 
					 @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager')  || Auth::user()->current_user_can('seo_manager') ||  Auth::user()->current_user_can('all_keyword'))
						
						<li>
								<a href="#"><i class="fa fa-bars fa-fw"></i>Categories<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level <?php  if(Request::segment(2)=='keyword_sell_count'){ echo  "collapse in"; } ?>">
								@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('parent_category') )	
								<li>
								<a href="{{url('/developer/parent_category')}}"><i class=""></i> Parent Category</a>
								</li>
								@endif
								@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('child_category') )	
								<li>
								<a href="{{url('/developer/child_category')}}"><i class=""></i> Child Category</a>
								</li>
								@endif
								@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager')|| Auth::user()->current_user_can('all_keyword'))	
								<li>
								<a href="{{url('/developer/keyword')}}"><i class=""></i> Business Keywords</a>
								</li>
								@endif
								@if(Auth::user()->current_user_can('administrator'))	
								<li>
								<a href="{{url('/developer/keyword_sell_count')}}" class="<?php if(Request::segment(2)=='keyword_sell_count'){ echo "active"; } ?>"><i class=""></i> Keyword Category Count</a>
								</li> 
								@endif
								@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('seo_kwd_assign'))	
								<li>
								<a href="{{url('/developer/seo-kwd-assign')}}" class="<?php if(Request::segment(2)=='seo-kwd-assign'){ echo "active"; } ?>"><i class=""></i> Seo kwd Assign</a>
								</li> 
								@endif
								</ul>
							</li>
                    
					@endif
						 						
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_client'))
                        <li>
                            <a href="#"><i class="fa fa-handshake-o fa-fw"></i> Clients<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_client'))
							   <li>
                                    <a href="{{url('/developer/clients/list')}}"><i class=""></i> All Clients</a>
                                </li>
                                <li>
                                    <a href="{{url('/developer/clients/register')}}"><i class=""></i> Create Client</a>
                                </li>
                                
                                <li>
                                    <a href="{{url('/developer/clients/meetings')}}"><i class=""></i>Follow Up Client</a>
                                </li>
								 <li>
                                    <a href="{{url('/developer/clients/search')}}"><i class=""></i> Search Client</a>
                                </li>
								  @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('order_history')) 
								<li>
                                    <a href="{{url('/developer/order-history')}}"><i class=""></i> Order History</a>
                                </li> 
								@endif	
						
						@endif
						   @if(Auth::user()->current_user_can('administrator')) 						
                                <li>
                                    <a href="{{url('/developer/clients/categories')}}"><i class=""></i> Categories</a>
                                </li> 
                                <li>
                                    <a href="{{url('/developer/transactions')}}"><i class=""></i> Transactions</a>
                                </li>  									
							@endif
							
							@if(Auth::user()->current_user_can('administrator'))
                                <li>
                                    <a href="{{url('/developer/clients/list/deleted-clients')}}"><i class=""></i> Deleted Clients</a>
                                </li>
							@endif
                            </ul>
                             
                        </li>	
							@endif
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('lead_bulk_upload'))
							<li>
								<a href="#"><i class="fa fa-upload fa-fw"></i>Bulk Upload<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{url('/developer/bulkupload/lead')}}"><i class=""></i> Lead Bulk Upload</a>
									</li>


										 @if(Auth::user()->current_user_can('administrator') )
									<li>
										<a href="{{url('/developer/bulkupload/zone')}}"><i class="fa fa-upload fa-fw"></i> Zone Bulk Upload</a>
									</li>
								@endif 



								 	<!-- @if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('keyword_bulk_upload'))
									<li>
										<a href="{{url('/developer/bulkupload/keyword')}}"><i class="fa fa-upload fa-fw"></i> Keyword Bulk Upload</a>
									</li>
								@endif -->
								</ul>
							</li>							
							@endif
							
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('lead_transfer') )
								<li><a href="{{url('/developer/permanent-transfer')}}"><i class="fa fa-arrow-right"></i>Transfer</a></li>
							@endif
							
							@if(Auth::user()->current_user_can('administrator') )
							<li>
								<a href="#"><i class="fa fa-inr fa-fw"></i>Bank<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{url('/developer/mode/modedetails')}}"><i class=""></i> Mode Details</a>
									</li>
								 
									<li>
										<a href="{{url('/developer/banks/banksdetails')}}"><i class=""></i> Bank Details</a>
									</li>
								
								</ul>
							</li>
							@endif
							
							@if(Auth::user()->current_user_can('administrator'))
							<li>
								<a href="#"><i class="fa fa-cap fa-fw"></i>Occupation<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{url('/developer/occupation')}}"><i class=""></i> All Occupation</a>
									</li>
								
								</ul>
							</li>
							@endif
							@if(Auth::user()->current_user_can('administrator'))
							<li>
								<a href="#"><i class="fa fa-cap fa-fw"></i>Home Slider<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{url('/developer/home_slider')}}"><i class=""></i> All Home Slider</a>
									</li>
								
								</ul>
							</li>
							@endif
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_SEO'))
							<li>
								<a href="#"><i class="fa fa-cap fa-fw"></i>Author<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="{{url('/developer/author')}}"><i class=""></i> All Author</a>
									</li>								
								</ul>
							</li>
							@endif
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_zone'))						
							
							<li>
								<a href="#"><i class="fa fa-map-marker fa-fw"></i>Client Area<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
								<li>
								<a href="{{url('/developer/zone')}}"><i class=""></i> Zone</a>
								</li>
								<li>
								<a href="{{url('/developer/area')}}"><i class=""></i> Area</a>
								</li>

							
								
								</ul>
							</li>
													
						@endif
						
						
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_SEO'))						
							
							<li>
								<a href="#"><i class="fa fa fa-bullhorn fa-fw"></i>SEO<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level <?php  if(Request::segment(2)=='seo-work' || Request::segment(2)=='classified-profile' || Request::segment(2)=='seo' || Request::segment(2)=='seo' || Request::segment(2)=='category' || Request::segment(2)=='categoryEdit' || Request::segment(2)=='childcategoryEdit' ){ echo  "collapse in"; } ?>">
							<li>
								<a href="{{url('/developer/seo')}}" class="<?php if(Request::segment(2)=='seo'){ echo "active"; } ?>"><i class=""></i>Keyword SEO</a>
							</li>

							<li>
								<a href="{{url('/developer/classified-profile')}}" class="<?php if(Request::segment(2)=='classified-profile'){ echo "active"; } ?>"><i class=""></i>Classified Profile</a>
							</li> 
							<li> 
								<a href="{{url('/developer/seo-work')}}" class="<?php if(Request::segment(2)=='seo-work'){ echo "active"; } ?>"><i class=""></i>Keyword Work</a>
							</li> 


							<li>
								<a href="{{url('/developer/assignSeoKeyword')}}" class="<?php if(Request::segment(2)=='assignSeoKeyword'){ echo "active"; } ?>"><i class=""></i>Assign Keyword</a>
								</li> 
								<li>
								<a href="{{url('/developer/category/seo')}}" class="<?php if(Request::segment(2)=='category'){ echo "active"; } ?>"><i class=""></i> Category SEO</a>
								</li>

	                           <li>
								<a href="{{url('/developer/childcategory/seo')}}" class="<?php if(Request::segment(2)=='childcategory' || Request::segment(2)=='categoryEdit'){ echo "active"; } ?>"><i class=""></i> Child Category SEO</a>
								</li>
							
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('seo_city') )
	                           <li>
								<a href="{{url('/developer/seoCity')}}"><i class=""></i> Seo City</a>
								</li>
							@endif
								
							@if(Auth::user()->current_user_can('administrator') )
	                           <li>
								<a href="{{url('/developer/seo-report')}}"><i class=""></i> Seo Report</a>
								</li>
							@endif
								</ul>
							</li>
													
						@endif
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('all_SEO') )
						  
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('cms_manager') )
							
							<li>
								<a href="#"><i class="fa fa-gear fa-fw"></i>CMS Manage<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level <?php  if(Request::segment(3)=='blogdetails' || Request::segment(3)=='addBlog' || Request::segment(3)=='editBlog'){ echo  "collapse in"; } ?>">
								<li>
									<a href="{{url('/developer/blog/blogdetails')}}"   class="<?php if(Request::segment(3)=='blogdetails' || Request::segment(3)=='addBlog' || Request::segment(3)=='editBlog' ){ echo "active"; } ?>"><i class=""></i> Add Blog</a>
							</li>
							<li>
								<a href="{{url('/developer/testimonials/testimonialsdetails')}}"><i class=""></i>Testimonials</a>
							</li>
								
								</ul>
							</li>
							@endif
													
						@endif
						
						
						
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->