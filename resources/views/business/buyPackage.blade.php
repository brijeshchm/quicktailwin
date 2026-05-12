@extends('business.layouts.app')
@section('title')
Buy Package  
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on Quick Dials and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection
@section('content')	

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Package</h1>
      
    </div><!-- End Page Title -->

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
                    <div class="col-lg-3 col-md-4 label ">Membership Type : </div>
                    <div class="col-lg-9 col-md-8"><?php  echo ucfirst($client->client_type); ?> Membership</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label"><?php  echo ucfirst($client->client_type); ?> Membership Ends on </div>
                    <div class="col-lg-9 col-md-8"><?php  echo date('d M, Y',strtotime($client->expired_on)); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Buy More Package</div>
                    <div class="col-lg-9 col-md-8"><a href="">Buy Package</a></div>
                  </div>
                <?php  if($client->client_type != 'diamond'){ ?>
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Extent Membership</div>
                    <div class="col-lg-9 col-md-8"><a href="">EXTEND PLATINUM MEMBERSHIP</a></div>
                  </div>
                  <?php  } ?>
                </div>
              </div> 

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection