@extends('business.layouts.app')
@section('title')
Quick Dials | package
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on Quickinida and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection
@section('content')	

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Package</h1>
      
    </div><!-- End Page Title -->
<style>
  .price-row {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 10px 0;
  flex-wrap: wrap;
}

.price-label {
  width: 120px;
  font-weight: 600;
  color: #333;
}

.price-coins {
  width: 150px;
  color: #555;
}

.price-action a {
  color: #0d6efd;
  text-decoration: none;
  font-weight: 500;
}

.price-action a:hover {
  text-decoration: underline;
}

/* Mobile responsive */
@media (max-width: 768px) {
  .price-row {
    /* flex-direction: column; */
    align-items: flex-start;
    gap: 8px;
  }

  .price-label,
  .price-coins {
    width: auto;
  }
}

</style>
    <section class="section profile">
      <div class="row">
         

        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Membership</button>
                </li>

               

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Package Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-2 label ">Membership Type : </div>
                    <div class="col-lg-3 col-md-6"><?php  echo ucfirst($client->client_type); ?> Membership</div>
               
                    <div class="col-lg-3 col-md-2 label"><?php  echo ucfirst($client->client_type); ?> Membership Ends on </div>
                    <div class="col-lg-3 col-md-6"><?php
                     
                    if($client->expired_on !=='0000-00-00 00:00:00'){ echo date('d M, Y',strtotime($client->expired_on)); } ?></div>
                 
                   
                    
                  </div>
                  
                <?php  if($client->client_type != 'diamond'){ ?>
                  <div class="row">
                       <div class="col-lg-3 col-md-2 label">Remaining Cons</div>
                    <div class="col-lg-3 col-md-6"><a href="{{url('business/buy-package')}}">Buy Package</a>
                    </div>
                    <div class="col-lg-3 col-md-4 label">Extent Membership</div>
                    <div class="col-lg-3 col-md-8"><a href="">EXTEND PLATINUM MEMBERSHIP</a></div>
                      
                  </div>
                <?php  } 
                   
                
                ?>
                
                </div>
              </div> 
              
              
               <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Buy Details </h5>
                    @if(!empty($data))
                    @foreach($data as $datav)
 
                  @if($datav['amt'] =='0' )

                 

  <div class="price-row">
  <div class="price-label">
  ₹ {{ $datav['amt'] }}:
  </div>

  <div class="price-coins">
  {{ $datav['coins'] }} Coins
  </div>

  <div class="price-action">
  <a href="{{ url('business/subscribe-free/?status=correction&o='.$datav['encrypt']) }}">
  {{ $datav['package_bottom'] }}
  </a>
  </div>
  </div>


                  <!-- <div class="row">
                      <div class="col-lg-2 col-md-4 label "><i class="bi bi-currency-rupee"></i> {{ $datav['amt'] }}: </div>
                      <div class="col-lg-2 col-md-8"> {{$datav['coins']}} Coins</div>
                    
                      <div class="col-lg-3 col-md-8"> <a href="{{url('business/subscribe-free/?status=correction&o='.$datav['encrypt'])}}">{{$datav['package_bottom'] }}</a></div>
                    </div>  -->

                  @else


                  <div class="price-row">
  <div class="price-label">
  ₹ {{ $datav['amt'] }}:
  </div>

  <div class="price-coins">
  {{ $datav['coins'] }} Coins
  </div>

  <div class="price-action">
  <a href="{{url('business/pay-deposit/?status=correction&o='.$datav['encrypt'])}}">
  {{ $datav['package_bottom'] }}
  </a>
  </div>
  </div>
                  <!-- <div class="row">
                      <div class="col-lg-2 col-md-4 label "><i class="bi bi-currency-rupee"></i> {{ $datav['amt'] }}: </div>
                      <div class="col-lg-2 col-md-8"> {{$datav['coins']}} Coins</div>
                    
                      <div class="col-lg-3 col-md-8"> <a href="{{url('business/pay-deposit/?status=correction&o='.$datav['encrypt'])}}">{{$datav['package_bottom'] }}</a></div>
                    </div> -->
                @endif


                    @endforeach
                    @endif

 

                     <div class="row">
                    <div class="col-lg-12">

                        <strong>Note: 18% GST Extra on above packages </strong>

                    </div>
                    </div>




                </div>
              </div> 
              
              

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection