@extends('client.layouts.app')
@section('title', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
@section('description', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')
@section('keyword', 'Quick Dials- Local search, IT Training, Playschool, overseas education, Business owners')




@section('content')
	<style>
		.inner-client-div .grid-info h3{
			height:auto;
		}
		.inner-client-div .grid-info .get-quotes{
			margin-top:-25px;
		}
		.font-11{
			font-size:11px;
		}
	</style>
		<div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 third-add-section">
          
                 <?php  
                    if(!empty($keyword->child_banner)){
                    $cicons= unserialize($keyword->child_banner); 
                    if (!empty($cicons)) {
                    ?>
                    
                    <img loading="lazy" src="{{asset(''.$cicons['child_banner']['src'])}}" alt="{{ $cicons['child_banner']['name'] }}">
                    
                    <?php  }else{ ?>
                    
                    <img loading="lazy" src="<?php echo asset('client/images/computer-courses-training.jpg'); ?>" alt="computer-courses-training">
                    <?php  } }else{ 
                        
                        if(!empty($keyword->category_banner)){
                    $cicons= unserialize($keyword->category_banner); 
                    if($cicons){
                    ?>
                    
                    <img loading="lazy" src="{{asset(''.$cicons['category_banner']['src'])}}" alt="{{ $cicons['category_banner']['name'] }}">
                    
                    
                    <?php  } }else{  ?>
                    <img loading="lazy" src="<?php echo asset('client/images/computer-courses-training.jpg'); ?>" alt="computer-courses-training">
                    
                    <?php } } ?>  
                
                </div>
        </div>
    </div>
	
    <div class="container">
        <div class="clearfix"></div>
        <h2 class="title">Service {{$child_id->child_category}} </span> </h2>
       <br>
	   <div class="category-box">
	   <div class="course-program">
	   	<ul class="">
		@if(!empty($kwdsList))
		<?php $i = 0; $x = 5; ?>
			@foreach($kwdsList as $keyword)
	   <li class=""><a href="{{ route('showCity', $keyword->slug) }}" class="keystore">{{$keyword->keyword}}</a></li>
	   
	   @endforeach
	   @endif
	  
 
	   
	   </ul>
	   </div>
	   </div>
	    
    </div>
    
    
    <div class="container">

        <div class="col-sm-9 col-md-9 reviews-box-main mainContainer">
            <a href="#top"></a>
			@if(!empty($subCateoryClient))
				<?php $n=0;?>
				@foreach($subCateoryClient as $client)
				
				<div class="col-sm-12 col-md-12 reviews-box-1 line-content">
					<div class="col-sm-4 col-md-4 serchlist-img "><a href="{{ route('business.details', $client->business_slug) }}" title="{{$client->business_name }}">
						<?php if(null != $client->logo){
							$profilePic = unserialize($client->logo);
							?><img loading="lazy" src="<?php echo asset(''.$profilePic['large']['src']); ?>" alt="{{$client->business_name}}" title="{{$client->business_name}}" height="141" /><?php
						}else{
							?><img loading="lazy" src="<?php echo asset('client/images/default_pp_small.jpg'); ?>" alt="Business Logo" title="Business Logo" height="141" style="width:100%" /><?php
						}
						?>
						@if($client->client_type != 'FreeListing')
						<p> <i class="fa fa-fw fa fa-thumbs-up serchlist-location-icon" aria-hidden="true"></i></p>
						@endif
						</a>
					</div>
					<div class="col-sm-5 col-md-5 aboutcomp">
				 
					<!-- <div class="" <?php if($n==0){ ?> style="" <?php } $n++; ?>>-->
						 
						<a href="{{ route('business.details', $client->business_slug) }}" >
							<span class="serchlist-txt-1">
								<img src="{{ asset('/img/office.png')}}" alt="office" loading="lazy" width="20">						 							
								<?php echo ucfirst(substr($client->business_name,0,28));?>
							</span>
							<?php
								$badge = $client->sold_on_position;
							?>
						 
							 
						</a>
				 
						<div class="certified" <?php if($client->certified_status==1){ ?> style="background-image: url(../client/images/certified-icon.png);" <?php } ?>>
						 
						<?php
							$arr=[];
							if(!empty($client->address)){
								$arr['address'] = $client->address;
							}
							if(!empty($client->landmark)){
								$arr['landmark'] = $client->landmark;
							}
							if(!empty($client->city)){
								$arr['city'] = $client->city;
							}
							if(!empty($client->state)){
								$arr['state'] = $client->state;
							}
							if(!empty($client->country)){
								$arr['country'] = $client->country;
							}
							$addr = getAddress($arr,30);
							if($addr->ispositiveresponse){
							?>
								<div class="serchlist-txt">
									<img src="{{ asset('/img/map.png')}}" alt="office" loading="lazy" width="18">
									<?php if($addr->issubstr): ?>
										<a href="{{ route('business.details', $client->business_slug) }}">{{ $addr->substr }}</a>
										<sapn data-toggle="tooltip" data-placement="bottom" title="{{ $addr->fullstr }}">more</span>
									<?php else: ?>
										<a href="{{ route('business.details', $client->business_slug) }}">{{ $addr->substr }}</a>
									<?php endif; ?>
								</div>
							<?php						
							}
						?>
						 
						 
						<div class="serchlist-txt">
						<img src="{{ asset('/img/clock.png')}}" alt="clock" loading="lazy" width="18">							 
							<a href="{{ route('business.details', $client->business_slug) }}" ><span class="serchlist-txt">
							<?php
							if(!empty($client->time)){
								$times = json_decode($client->time);
								$today =  strtolower(date('l'));
								echo "Opening Hrs (Today ".$times->$today->from." - ".$times->$today->to.")";
							}else{
								echo "No working hours available";
							}
							?>
							</span></a>
						</div>
							<div class="serchlist-txt" >
							<img src="{{ asset('/img/service.png')}}" alt="service" loading="lazy" width="18">
							<span class="serchlist-txt">
								<div class="col-md-12 service-text" >
								<ul>
								<?php
								
						$assignedKwds = DB::table('assigned_kwds')
							  ->join('keyword','keyword.id','=','assigned_kwds.kw_id')
							  ->join('child_category','child_category.id','=','assigned_kwds.child_cat_id')
							  ->select('keyword.keyword','keyword.slug','child_category.child_category as child_category_name')
							  ->where('assigned_kwds.client_id','=',$client->id)
							  ->limit(2)
							  ->get();
				  
									$firstHalf = [];
									$secondHalf = [];
									$i = 1;
									$inPopupArr = [];
									foreach($assignedKwds as $assignedKwd){										 
												 ?>
								
										 <li>
											<a href="{{ route('showCity', $assignedKwd->slug) }}" class="keystore"><?php echo $assignedKwd->keyword; ?></a>
										</li>
												 
												 
												 <?php  }  ?>
							</ul>
									</div>
							
									 
							 </span>
						</div>
						</div>
					 
						<div class="serchlist-txt-btn"><span class="sms-view open-popup"><span>SMS/Email</span></span>&nbsp;&nbsp;&nbsp;<a href="{{ route('business.details', $client->business_slug) }}"  class="sms-view"><span>View Details</span></a></div>
					
					 
					</div>

					<div class="col-sm-2 col-md-2 btnBox">
						<a href="{{ route('business.details', $client->business_slug) }}"><span class="serchlist-txt-1">User Rating</span></a>
						 <div class="serchlist-txt">
    @php
        if ($client->comment_count > 0) {
            $avgRating = ($client->rating / (5 * $client->comment_count)) * 5;
            $avgRating = number_format($avgRating, 1, '.', '');

            $whole = floor($avgRating);
            $fraction = $avgRating - $whole;
            $remain = 5 - $whole;
        } else {
            $avgRating = 0;
            $whole = 0;
            $fraction = 0;
            $remain = 5;
        }
    @endphp

    {{-- Full Stars --}}
    @for ($i = 0; $i < $whole; $i++)
        <a href="{{ route('business.details', $client->business_slug) }}" class="emptystar fullstar"></a>
    @endfor

    {{-- Half Star --}}
    @if ($fraction > 0 && $fraction < 1)
        <a href="{{ route('business.details', $client->business_slug) }}" class="emptystar halfstar"></a>
        @php $remain--; @endphp
    @endif

    {{-- Empty Stars --}}
    @for ($i = 0; $i < $remain; $i++)
        <a href="{{ route('business.details', $client->business_slug) }}" class="emptystar"></a>
    @endfor

    {{-- Rating Text --}}
    <a href="{{ route('business.details', $client->business_slug) }}">
        <span class="serchlist-rating">
            ({{ $avgRating }} Rating out of {{ $client->comment_count ?? 0 }} Votes)
        </span>
    </a>
</div>
						<button class="serchlist-btn open-popup" title="Best Offer {{$client->business_name }}">Enquiry Now</button>
					</div>

					<div class="col-sm-12 col-md-12" style="padding-left:0;">
						<div class="clickBlick"><a href="{{ route('business.details', $client->business_slug) }}" ><i class="fa fa-fw fa fa-sun-o" aria-hidden="true"></i></a><a href="{{ route('business.details', $client->business_slug) }}" ><span>Click here to view your friend rating</span></a></div>
					</div>
				</div>
				@endforeach
			@endif
				 
			
			 <ul id="pagin" ></ul>
<style>
.current .btn-info{
color: green;
}

#pagin li {
display: inline-block;
padding: 6px;
margin: 5px;
background-color: #C94A30; 
}

#pagin li a{
color: #fff;
}
</style>
 <script>
 
//Pagination
	pageSize = 20;
	var pageCount =  $(".line-content").length / pageSize;
    
     for(var i = 0 ; i<pageCount;i++){
        
       $("#pagin").append('<li><a href="#top">'+(i+1)+'</a></li> ');
     }
        $("#pagin li").first().find("a").addClass("current")
    showPage = function(page) {
	    $(".line-content").hide();
	    $(".line-content").each(function(n) {
	        if (n >= pageSize * (page - 1) && n < pageSize * page)
	            $(this).show();
	    });        
	}
    
	showPage(1);

	$("#pagin li a").click(function() {
	    $("#pagin li a").removeClass("current btn btn-info");
	    $(this).addClass("current btn btn-info");
	    showPage(parseInt($(this).text())) 
	});
	</script>
			
			
		 
        </div>
        <div class="col-sm-3 col-md-3 side-data reviews-box-1 rightsidedata">
       
  	 
			 <div class="enquiry-card">
        <h3>Fill out the form to receive the best offers <span>{{$keyword->parent_category}}</span></h3>
        <p>We’ll send you the contact details instantly free of charge</p>

       

		<div class="fieldblock">  
				@if($keyword->form_type =='form_edu')
				 <div class="level-title">What level of {{$keyword->parent_category}} do you need?</div>
				<div class="fieldblock-form">
					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="fresher">
					<span>Fresher</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="online">
					<span>Online</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="offline">
					<span>Offline</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="crashcourse">
					<span>Crash Course</span>
					</label>
				</div>
					@elseif($keyword->form_type =='form_pg')

				<div class="fieldblock-form">
					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="shared">
					<span>Shared</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="single">
					<span>Single</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="male">
					<span>Male</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="female">
					<span>Female</span>
					</label>
				</div>
				@elseif($keyword->form_type =='form_serv')

				<div class="fieldblock-form">
					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="ac_split">
					<span>AC Split</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="ac_window">
					<span>AC Window</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="freez_single_door">
					<span>Freeze Single Door</span>
					</label>						 
				</div>
				@else
				<div class="fieldblock-form">							 
				<input type="hidden" name="frmcheck[]" value="dummy">					 
												
				</div>
				@endif
			</div>
        

        <div class="form-group input-icon">
            <span></span>
            <input type="text" placeholder="Enter Full Name">
        </div>
        <div class="form-group input-icon">
            <span></span>
            <input type="text" placeholder="Mobile Number">
        </div>
        <button class="btn">Send Advisor &raquo;&raquo;</button>
    </div>
			
	  
	    <div class="side-data-txt">
		<p>Featured Service Advertising</p>
	</div>
	<div class="side-row-1">
		<img loading="lazy" src="<?php echo asset('landing/img/ads1.png'); ?>" alt="advertise" title="advertise">
	</div>
	
        </div>
    </div>
    
    
    
    
    @if(!empty($child_id->faqq1))
		<div class="container"> 		 
		<div class="category-description">  
		<h4>FAQ:- <?php  if(!empty($child_id->child_category)){ $key = preg_replace('/{{city}}/i',strtoupper($city),$child_id->child_category); echo trim($key); } ?>  </h4> 
			<div itemscope itemtype="https://schema.org/FAQPage">
			<?php if(!empty($child_id->faqq1)){ ?>
			<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
			<h5 itemprop="name"><strong><?php  if(!empty($child_id->faqq1)){
			$faqq1 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqq1);
			echo trim($faqq1); } ?>?</strong></h5>
			<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer" style="display: block;">
			<div itemprop="text">
			<?php  if(!empty($child_id->faqa1)){
			$faqa1 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqa1);
			echo trim($faqa1); } ?>
			 

			</div>
			</div>
			</div>
			<?php } ?>


			<?php if(!empty($child_id->faqq2)){ ?>
			<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
			<h5 itemprop="name"><strong><?php  if(!empty($child_id->faqq2)){
			$faqq2 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqq2);
			echo trim($faqq2); } ?>?</strong></h5>
			<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
			<div itemprop="text">
			<?php  if(!empty($child_id->faqa2)){
			$faqa2 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqa2);
			echo trim($faqa2); } ?>
		 
			</div>
			</div>
			</div>
			<?php } ?>		
			<?php if(!empty($child_id->faqq3)){ ?>
			<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
			<h5 itemprop="name"><strong><?php  if(!empty($child_id->faqq3)){
			$faqq3 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqq3);
			echo trim($faqq3); } ?>?</strong></h5>
			<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
			<div itemprop="text">
			<?php  if(!empty($child_id->faqa3)){
			$faqa3 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqa3);
			echo trim($faqa3); } ?>
			 
			</div>
			</div>
			</div>
			<?php } ?>		
			<?php if(!empty($child_id->faqq4)){ ?>
			<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
			<h5 itemprop="name"><strong><?php  if(!empty($child_id->faqq4)){
			$faqq4 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqq4);
			echo trim($faqq4); } ?>?</strong></h5>
			<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
			<div itemprop="text">
			<?php  if(!empty($child_id->faqa4)){
			$faqa4 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqa4);
			echo trim($faqa4); } ?>
			 
			</div>
			</div>
			</div>
			<?php } ?>		
			<?php if(!empty($child_id->faqq5)){ ?>
			<div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
			<h5 itemprop="name"><strong><?php  if(!empty($child_id->faqq5)){
			$faqq5 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqq5);
			echo trim($faqq5); } ?>?</strong></h5>
			<div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
			<div itemprop="text">
			<?php  if(!empty($child_id->faqa5)){
			$faqa5 = preg_replace('/{{city}}/i',ucfirst(Request::segment(1)),$child_id->faqa5);
			echo trim($faqa5); } ?>
		 
			</div>
			</div>
			</div>
			<?php } ?>


			</div>
		
		</div>
		
		 
		</div>
		@endif
    <div class="bestDealpopup"> 
		<?php 	

$value = Cookie::get('showPopup');	 
	//	if(Auth::guard('clients')->check() || ($value =="yes"))
			?>
        <a href="javascript:void(0);" class="dealclosebtn">&nbsp;</a> 
 
	   <h4>Need Expert Advice ?</h4>
        <div class="jbt"> Fill this form to Grab the best Deals on "<span class="orng"><?php echo $child_id->child_category; ?> </span>"</div>
        <div class="bdc">
            <!--{{url('/client/lead/add-lead')}}-->
            <form class="form-inline" method="post" onsubmit="return homeController.saveEnquiry(this)">
                <aside>
			<!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
                    <p><label for="yn">Your Name <span>*</span></label>
						<input type="hidden" name="lead_form" value="1" />
						<input type="hidden" name="kw_text" value="<?php echo $child_id->child_category; ?>" />
						<input type="hidden" name="city_id" class="city" value="{{Request::segment(1)}}" />
                        <input class="jinp" type="text" placeholder="Enter Full Name" name="name" value="">
						<input type="hidden" name="from_page" value="{{ request()->path() }}">
                    </p>
                    <p>
                        <label for="ymn">Your Mobile<span>*</span></label>
                        <input class="jinp" type="tel" placeholder="Enter Mobile" name="mobile" value="" >
                    </p>
                    <p>
                        <label for="yei">Your Email ID <span></span></label>
                        <input class="jinp" type="text" placeholder="Enter Email" name="email" value="">
                    </p>
                    <p>
                        <label class="moblab">&nbsp;</label>
						<!--<input class="jbtn" type="submit" value="Submit" />-->
						<input class="jbtn" type="submit" name="submit" value="Submit" />
						<input type="reset" class="reset_lead_form hide" value="reset" />
                        <!--button type="button" class="jbtn">Submit</button-->
                    </p>
                </aside>
            </form>
        </div>

        <section class="bdn">
            <aside class="jpb">
                <p>
                    <span class="bul"></span>Your number will be shared only to these experts
                </p>
                <p>
                    <span class="bul"></span> Get Free Expert Online Counseling</p>
                <p>
                    <span class="bul"></span> Get Free Demo Classes
                </p>
                <p>
                    <span class="bul"></span> Get Fees & Discounts
                </p>
            </aside>
        </section>
    </div>
   
@endsection