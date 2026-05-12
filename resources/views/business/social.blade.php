@extends('business.layouts.app')
@section('title')
Profile Quick Dials
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
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Socials </button>
                </li>

                <li class="nav-item profile_success">
                    </li>
 

              </ul>
              <div class="tab-content pt-2">

             <style>
           .form-control {
            flex: 1;
            padding: 12px;
            background: #f5f5f5;
            border: 2px solid #ddd;
            border-radius: 4px;
            color: #000;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #a5a2c9;
            background: #fff;
        }
         .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
        }

        .form-group label {
            color: #000;
            font-size: 1em;
            flex: 0 0 150px;
            letter-spacing: 1px;
        }

              @media (max-width: 768px) {
           
            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-group label {
                flex: none;
            }

            .form-control {
                width: 100%;
                border-radius: 4px;
            }

            .verify-btn, .image-upload button, .save-btn {
                border-radius: 4px;
            }
        }
          .help-block{  
          color: #ff0000;
          position: relative;

          margin-top: 61px;
          display: block;
          margin-left: -207px;
          }
              
              </style>
             

                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

               <form class="profile_info" method="POST" onsubmit="return businessController.editSaveSocials(this,<?php echo (isset($client->id)? $client->id:""); ?>)">
                <input type="hidden" name="business_id" value="{{ old('middle_name',(isset($client)) ? $client->id:"")}}">             
                 
                <div class="form-group">
                    <label>Facebok URL:</label>                   
                       <input name="facebook_url" type="text" class="form-control" value="{{ old('facebook_url',(isset($client)) ? $client->facebook_url:"")}}" placeholder="Please enter facebook url">
                    <label>Instagram URL*:</label>
                      <input name="instagram_url" type="text" class="form-control" value="{{ old('instagram_url',(isset($client)) ? $client->instagram_url:"")}}" placeholder="Please enter instagram url" >
                </div>
                <div class="form-group">
                  <label>twitter URL*:</label>                   
                    <input type="text" class="form-control" name="twitter_url" value="{{ old('twitter_url',(isset($client)) ? $client->twitter_url:"")}}" placeholder="Enter twitter url" >
                
                    
                 <label> linkedin URL*:</label>
 
                    <input type="text" class="form-control" name="linkedin_url" value="{{ old('linkedin_url',(isset($client)) ? $client->linkedin_url:"")}}" placeholder="Enter linkedin url">             
                          
                            
                </div>                          
                <div class="form-group">
                  
                    
                          
                 <label> Pinterest URL*:</label>
 
                    <input type="text" class="form-control" name="pinterest_url" value="{{ old('pinterest_url',(isset($client)) ? $client->pinterest_url:"")}}" placeholder="Enter pinterest url">             
                            
                          
                 <label> Youtube URL*:</label>
 
                  <input type="text" class="form-control" name="youtube_url" value="{{ old('youtube_url',(isset($client)) ? $client->youtube_url:"")}}" placeholder="Enter pinterest url">             
                            
                </div>                          
            <div class="text-center"> 
                 <input type="hidden" name="saveSocials" value="saveSocialForm">
                <button type="submit" class="btn btn-primary">Save & Continue</button>
        
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