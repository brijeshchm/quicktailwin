@extends('client.layouts.app')
@section('title', 'Testimonials Quick Dials- Local search, IT Training, Service, overseas education')
@section('description', 'Testimonials Dials- Local search, IT Training, Service, overseas education')
@section('keyword', 'Testimonials Dials- Local search, IT Training, Service, overseas education')

@section('content')

<div class="about-bg page-hearder-area">
    <div class="official-overly"></div> 
  </div> 
<style>
 .single-services > img {
    width: 70px;
    height: 70px;
    border-radius: 50px;
    display: block;
    margin: 0 auto;
}

</style>
  <div id="services" class="services-area area-padding">
    <div class="container">
      
      <div class="row">
       <div class="aboutus">
		<div class="container">
		 
		<div class="col-md-12">
				 <div class="row text-center">
        <div class="services-contents">
 @if(!empty($testimonialsdetails))
	 @foreach($testimonialsdetails as $testimonials)
          <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="about-move">
              <div class="services-details">
                <div class="single-services" style="background-image: url(./public/client/images/bg-image.png);">
				<?php
				$image='';
				if($testimonials->image!=''){
				$image = unserialize($testimonials->image);
				//$image = $image['thumbnail']['src'];
				$image = $image['large']['src'];

				}	

				if(!empty($image)){
				?>
				
				<img loading="lazy" src="<?php echo (isset($image)?url($image):"");  ?>" title="{{$testimonials->name}}" alt="{{$testimonials->name}}">
				<?php }else{ ?>												  
					<img loading="lazy" src="{{asset('/public/images/unknown-user.jpg')}}" title="Estival user" alt="Estival user">
				<?php  } ?>
					<h4>{{$testimonials->name}}</h4> 
					<address>
					<strong>{{$testimonials->company_name}}, {{$testimonials->location}}</strong>
						
					</address>
                 <h5>{{$testimonials->title}}</h5>
                
				 <p>
                    <?php echo ucfirst(substr($testimonials->description,0,200));?>
                  </p>
              
                </div>
              </div>
           
            </div>
          </div> 
		  
		
		  @endforeach
  @endif
		  
 
		 
		  
		  
          

	  	

		 
		  
        </div>
      </div>
  
				 
				
			</div>
			 
		</div>
	</div>
        
      </div>
    </div>
  </div>
 
  
  
 @endsection
