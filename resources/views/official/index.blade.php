@extends('client.layouts.app')
@section('title', 'Quick Dials- Local search, IT Training, Service, overseas education')
@section('description', 'Quick Dials- Local search, IT Training, Service, overseas education')
@section('keyword', 'Quick Dials- Local search, IT Training, Service, overseas education')

@section('content')

 
  <!-- Start Slider Area -->
  <div id="home" class="slider-area">
    <div class="bend niceties preview-2">
      <div id="ensign-nivoslider" class="slides">
        <img loading="lazy" src="{{asset('public/official/img/slider/Quick Dials.jpg')}}" alt="Quick Dial" title="#slider-direction-1" />        
      </div>

      <!-- direction 1 -->
      <div id="slider-direction-1" class="slider-direction">
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="slider-content">
                <!-- layer 1 -->
                <div class="layer-1-1 hidden-xs wow" data-wow-duration="2s" data-wow-delay=".2s">
                 <!-- <h2 class="title1">Effortless Lead Management System </h2>-->
                  <h2 class="title1">Any successful career starts with a good Eduction </h2>
                </div>
				
				 

				<div class="sentance hidden-xs wow" style="width:100%; margin-top: 35px;">
                  <h2 class="title1">
				  <div class="verticalFlip">
					<span>Grow up future choose right career.</span>
					<span>Your bright future is our mission.</span>
					<span>Education Is Key To Success.</span>
					 
					</div></h2>
                </div>
				  
                <!-- layer 2 -->
                <div class="layer-1-2 wow" data-wow-duration="2s" data-wow-delay=".1s">
                  <h1 class="title2">Quick Dials is the best place to get certified institutions to enhance interpersonal skills.</h1>
                  
                </div>
				
                <!-- layer 3 -->
                <div class="layer-1-3 hidden-xs wow" data-wow-duration="2s" data-wow-delay=".2s">
                  <a class="ready-btn page-scroll" href="jacascript:void(0)" data-toggle="modal" data-target="#inquiry">Get Connected</a>&nbsp;&nbsp;
                  
                </div>
                <div class="plan-demo-btns" style="margin-top: 40px"> <a href="https://www.quickdials.com/" target="_black" class="header-plans-btn" style="color:#fff !important"> <i class="fa fa-forward"></i> See certified institutions<i class="fa fa-backward"></i></a><div class="clearfix"></div></div>
              </div>
            </div>
          </div>
        </div>
      </div>

     
	  
	  
    </div>
  </div>
  <!-- End Slider Area -->
 
  <div id="about" class="services-area area-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="section-headline services-head text-center">
            <h2><span>Quick </span>India</h2>
          </div>
        </div>
      </div>
      <div class="row text-center">
        <div class="services-contents">
          <!-- Start Left services -->
          
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="about-move">
              <div class="services-details">
                <div class="single-services">                   
                  <p>
                    Quick Dials is one of the most promising start-ups in India in 2023. Start-up offering B2C model as match-making admission solution to students and Professionals, Quick Dials is unique platform which connects education seekers with education providers with excellent career counselling.</p>
<p> Quick Dials is an extensive search engine for the students, parents, Professionals and education industry players who are seeking information on education sector in India.One can rely on Quick Dials for getting most relevant data on Institutes, colleges and universities. </p>
					 
                </div>
              </div>
             
            </div>
          </div>  
		  
          <div class="col-md-3 col-sm-3 col-xs-12">
		  <style>
		.modal-header .close {
		margin-top: 4px;
		margin-right: 13px;
		}
		  </style>
            <div class="about-move">
              <div class="services-details">
                <div class="single-services">
                  <a class="services-icon" href="javascript:void(0)">
											<i class="fa fa-rocket"></i>
										</a>
                  <h6><strong>Vision</strong></h6>
				  <article>
						<?php
							$comment = "Quick Dials has been created for fulfil a vision of quality education along with education with the help of certified Institutions. In Modern era we wanted to uniform educational societies with the help of technologies for better Nation built-up";
							if(strlen($comment)>150){
								$replacement = "<span style='display:none;'>";
								$comment = substr_replace($comment,$replacement,150,0);
								$replacement = "</span>";
								$comment = substr_replace($comment,$replacement,strlen($comment),0);
								echo $comment;
								?>
								<a href="javascript:void(0);" class="read-more">Read More..</a>
								<a href="javascript:void(0);" class="read-less hide">Read Less </a>
								<?php
							}else{
								echo $comment;
							}
						?>
					</article>
                  
                </div>
              </div>
              <!-- end about-details -->
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="about-move">
              <div class="services-details">
                <div class="single-services">
                  <a class="services-icon" href="javascript:void(0)">
											<i class="fa fa-laptop"></i>
										</a>
                  <h6><strong>USP’s</strong></h6>
				<article>
						<?php
							$comment = "Quick Dials first technology driven education start-up of India providing match making solution for students education needs in all sectors.
					Quick Dials have extensive In-house personalized counselling to understand student’s need and help him make the most informed decision.";
							if(strlen($comment)>150){
								$replacement = "<span style='display:none;'>";
								$comment = substr_replace($comment,$replacement,150,0);
								$replacement = "</span>";
								$comment = substr_replace($comment,$replacement,strlen($comment),0);
								echo $comment;
								?>
								<a href="javascript:void(0);" class="read-more">Read More..</a>
								<a href="javascript:void(0);" class="read-less hide">Read Less </a>
								<?php
							}else{
								echo $comment;
							}
						?>
					</article>
                  

                </div>
              </div>
              <!-- end about-details -->
            </div>
          </div>
         
          <div class="col-md-3 col-sm-3 col-xs-12">
        
            <div class=" about-move">
              <div class="services-details">
                <div class="single-services">
                  <a class="services-icon" href="javascript:void(0)">
											<i class="fa fa-trophy"></i>
										</a>
                  <h6><strong>Quick Dials For Institutions</strong></h6>
				     <article>
						<?php
							$comment = "Quick Dials provides a non-conventional platform which focuses on delivering quality leads and highly motivated candidates.Our extensive In-house one-one personalized counselling providing an edge to the clients looking for highly specific and active database.";
							if(strlen($comment)>150){
								$replacement = "<span style='display:none;'>";
								$comment = substr_replace($comment,$replacement,150,0);
								$replacement = "</span>";
								$comment = substr_replace($comment,$replacement,strlen($comment),0);
								echo $comment;
								?>
								<a href="javascript:void(0);" class="read-more">Read More..</a>
								<a href="javascript:void(0);" class="read-less hide">Read Less </a>
								<?php
							}else{
								echo $comment;
							}
						?>
					</article>         
				 

                </div>
              </div>
             
            </div>
          </div>    
		  
		  <div class="col-md-3 col-sm-3 col-xs-12">
        
            <div class=" about-move">
              <div class="services-details">
                <div class="single-services">
                  <a class="services-icon" href="javascript:void(0)">
											<i class="fa fa-user"></i>
										</a>
                  <h6><strong>Quick Dials For Students</strong></h6>
				     <article>
						<?php
							$comment = "Students can use Quick Dials as one stop destination to search about their Coaching Institutes, IT Training Centres, Overseas Education consultant`s available courses, College admission process and lots more interactive tools to simplify the process of finding alma-mater. The website has the repository of more than 1,000 Institutes, Coaching Centres, School, colleges and 10,000 courses categorized in different streams like IT Training, Civil Services, Entrance Exam Preparation, Management, Engineering, Medical, Arts, Distance Education and much more. One can classify Education needs on the basis of location, Reviews and Certification. Quick Dials Certified Business Partners are assuring to students Quality Education, Campus Placement, Best Faculty, Fees Refund assurance.";
							if(strlen($comment)>150){
								$replacement = "<span style='display:none;'>";
								$comment = substr_replace($comment,$replacement,150,0);
								$replacement = "</span>";
								$comment = substr_replace($comment,$replacement,strlen($comment),0);
								echo $comment;
								?>
								<a href="javascript:void(0);" class="read-more">Read More..</a>
								<a href="javascript:void(0);" class="read-less hide">Read Less </a>
								<?php
							}else{
								echo $comment;
							}
						?>
					</article>            
				  

                </div>
              </div>
             
            </div>
          </div>
           
          
        </div>
      </div>
	    <div class="row text-center">
	   
	  
	  </div>
	  
	  
    </div>
  </div>
  <div id="faq" class="about-area area-padding">
     <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="section-headline text-center">
            <h2>FAQ's Question</h2>
          </div>
        </div>
      </div>
      <div class="row">
          
       <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="faq-details">
            <div class="panel-group" id="accordion">
               
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="check-title">
											<a data-toggle="collapse" class="active" data-parent="#accordion" href="#check1">
                                                <span class="acc-icons"></span>Why should I create a business profile on Quick Dials?.
											</a>
										</h4>
                </div>
                <div id="check1" class="panel-collapse collapse in">
                  <div class="panel-body">
                    <p>
                     Quick Dials offers a non-conventional platform dedicated to delivering high-quality leads and connecting educational institutions with motivated candidates. Our in-house personalized counseling further enhances our service, providing a competitive edge to clients seeking access to a highly specific and active database of prospective students.
                    </p>
                  </div>
                </div>
              </div>
             
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="check-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#check2">
                                                <span class="acc-icons"></span> I want to add more services to my profile. How can I do that?.
											</a>
										</h4>
                </div>
                <div id="check2" class="panel-collapse collapse">
                  <div class="panel-body">
                    <p>
                      Connect from our expert customer support at help@quickdials.com 
                    </p>
                  </div>
                </div>
              </div>
              
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="check-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#check3">
                                                <span class="acc-icons"></span>What are leads? How can I get them?
											</a>
										</h4>
                </div>
                <div id="check3" class="panel-collapse collapse ">
                  <div class="panel-body">
                    <p>
                       Quick Dials offers extensive on-site and on-web support, subject to a few terms & conditions.
                    </p>
                  </div>
                </div>
              </div>
               
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="check-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#check4">
                                                <span class="acc-icons"></span>Low Price
											</a>
										</h4>
                </div>
                <div id="check4" class="panel-collapse collapse">
                  <div class="panel-body">
                    <p>
                      Quick Dials offers the best pricing in its class, providing a sufficient number of users under a single license.
                    </p>
                  </div>
                </div>
              </div>
               
            </div>
          </div>
        </div> 
        
		
		
        
      </div>
      
    </div>
   </div>

   
   
  
  
  
  <div id="features" class="services-area area-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="section-headline services-head text-center">
            <h2>Application Features</h2>
          </div>
        </div>
      </div>
      <div class="row text-center">
        <div class="services-contents">
         
		   <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="about-move">
              <div class="services-details">
                <div class="single-services">
                  <a class="services-icon" href="javascript:void(0)">
				<img loading="lazy" alt="Lead Management Software" src="{{asset('/public/client/images/business/group.png')}}">
										</a>
                  <h4>Leads generate for Business</h4>
                  <p>
                     
                  </p>
                </div>
              </div>
              
            </div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="about-move">
              <div class="services-details">
                <div class="single-services">
                  <a class="services-icon" href="javascript:void(0)">
					<img loading="lazy" alt="Lead Management Software" src="{{asset('public/client/images/business/head_phone.png')}}">
										</a>
                  <h4>Clearing of doubts using 'chat' with counselor</h4>
                  <p>
                    
                  </p>
                </div>
              </div>
              
            </div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-12">
           
            <div class="about-move">
              <div class="services-details">
                <div class="single-services">
                  <a class="services-icon" href="javascript:void(0)">
										<img loading="lazy" alt="Lead Management Software" src="{{asset('public/client/images/business/customized-training.png')}}">
										</a>
                  <h4>Real interactive class room experience from expert faculty Techer</h4>
                  <p>
                    
                  </p>
                </div>
              </div>
              
            </div>
          </div>
		  </div>
		   
		
           
          
		
      </div>
	  
	  
	  
    </div>
  </div>
  </div>
  
 
  
  
  
  
  <!-- End Faq Area -->

  <!-- Start Wellcome Area -->
  <div class="wellcome-area">
    <div class="well-bg">
      <div class="test-overly"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="wellcome-text subscribe-form">
              <div class="well-text text-center">
                <h2>Welcome To Quick Dials</h2>
                <p>
                  Quick Dials is the best place to track and crack your leads to generate and grow your business.
                </p>
				<div id="sendsubscribe">Your subscribe has been sent. Thank you!</div>
              <div id="errorsubscribe"></div>
			 
			   <form method="post" class="subscribe">
                <div class="subs-feilds">
				
                  <div class="suscribe-input">				  
				    <div class="form-group">
				   {{csrf_field()}}
				   
                    <input type="email" class="form-control width-80" name="email" id="email" placeholder="Your Email" data-rule="subscribe-email" data-msg="Please enter a valid email">
					 <div class="validation"></div> 
                    <button type="submit" class="add-btn width-20">Subscribe</button>
					
                   </div>
					 
					
                  </div>
                </div>
				</form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Wellcome Area -->

     
 

 
  <!-- Start Suscrive Area -->
  <div class="suscribe-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs=12">
          <div class="suscribe-text text-center">
            <h3>Welcome to Quick Dials</h3>
            <a class="sus-btn" href="javascript:void(0)" data-toggle="modal" data-target="#inquiry">Get A quote</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Suscrive Area -->
  
   
<!-- Modal -->
<div id="inquiry" class="modal fade" role="dialog" style="top:60px !important;">
  <div class="modal-dialog inquiry-form">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Inquiry Form </h4>
		 <div id="sendinquiry" >Your message has been sent. Thank you!</div>
         <div id="errorinquiry"></div>
      </div>
        <div class="modal-body">  
       <form method="post" role="form" class="inquiryForm">
    
       {{csrf_field()}}
                
                <div class="form-group">
				<label>Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="name:4" data-msg="Please enter name" />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
				<label>Mobile</label>
                  <input type="tel" class="form-control" name="mobile" id="mobile" placeholder="Your mobile" min="-10" max="10"  data-rule="mobile" data-msg="Please enter a valid mobile" />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
				<label>Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
				<label>City</label>
                  <input type="text" class="form-control" name="city" id="city" placeholder="Your City" data-rule="city:4" data-msg="Please enter city" />
                  <div class="validation"></div>
                </div>
                 <div class="form-group">
				<label>Message</label>
                  <textarea type="text" class="form-control" name="message" id="message" placeholder="Your message" data-rule="message" data-msg="Please enter enquiry" /></textarea>
                  <div class="validation"></div>
                </div>
               
     
      <div class="modal-footer">
           <button type="submit" class="btn btn-default">Submit</button>
              
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
       </div>
    </div>

  </div>
</div>
  
  

  @endsection
   
