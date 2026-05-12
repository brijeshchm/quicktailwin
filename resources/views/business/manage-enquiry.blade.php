@extends('business.layouts.app')
@section('title')
Personal Details
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on Quick Dials and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection
@section('content')	

  <main id="main" class="main">
    <section class="section profile">
      <div class="row">
        
        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

 
 
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Manage Enquiry</button>
                </li>

                <li class="nav-item profile_success">
                    </li>
 

              </ul>
              <div class="tab-content pt-2">

             <style>
 

        
              </style>

                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                 
                <form class="profileSave" method="POST">
                 
                      
                              
                    <div class="form-group">
                    
                    <?php   $clientID = auth()->guard('clients')->user()->id;

                      $client = App\Models\Client\Client::find($clientID);  ?>
                        <div class="form-check form-switch">
                       
                         <input class="form-check-input" type="checkbox" id="pauseLeadChecked"  value="{{ $client->pauseLead??'' }}" data-client_id="{{ $client->id }}" @if(!empty($client->pauseLead)) {{ "checked"}} @endif>
                       <label class="form-check-label" for="pauseLeadChecked"><h4>Pause Lead</h4></label>
                        </div>
                    </div>
                 
          
 

                  
                  </form><!-- End Profile Edit Form -->

                </div>

                 
                
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

 @endsection