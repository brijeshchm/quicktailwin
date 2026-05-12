@extends('business.layouts.app')
@section('title')
  Quick Dials | package
@endsection
@section('keyword')
  Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near
  You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance
  Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find
  Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education
  consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
  Find Only Certified Training Institutes, Coaching Centers near you on Quickinida and Get Free counseling, Free Demo
  Classes, and Get Placement Assistence.
@endsection
@section('content')

  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Account Settings</h1>

    </div><!-- End Page Title -->

    <section class="section profile">
    <div class="row">


      <div class="col-xl-12">

      <div class="card">
        <div class="card-body pt-3">
        <div class="tab-content pt-2">
          <div class="tab-pane fade show active profile-overview" id="profile-overview">

          <div class="row">
            <div class="col-lg-4 col-md-4 label "> Client Active Status: : </div>
            <div class="col-lg-4 col-md-8">
            <?php  
            if (!empty($client->active_status)) {
              echo "Active";
            } else {
              echo "In-Active";
            }
              ?>
            </div>

            <div class="col-lg-3 col-md-8">
            <?php
              if ($client->active_status == '1') {
                $active_status = '<a title="Active Profile" class="btn btn-success">Active</a>';
              } else {
                $active_status = '<a title="Inactive Profile" class="btn btn-danger">Inactive</a>';
              }
              echo $active_status;
            ?>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-4 label ">Client Paid Status : </div>
            <div class="col-lg-4 col-md-8">

            <?php
            if ($client->paid_status == '1') {
            $paid_status = 'Paid';
            } else {
            $paid_status = 'Un-Paid';
            }
            echo $paid_status;
            ?>
            </div>

            <div class="col-lg-3 col-md-8"> <?php

            if ($client->paid_status == '1') {
              $paidStatus = '<a title="Paid profile" class="btn btn-success">Paid</a>';
            } else {
              $paidStatus = '<a title="Un-Paid profile" class="btn btn-danger">Un-Paid</a>';
            }
            echo $paidStatus;
            ?>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4 col-md-4 label "> Client Certified Status: </div>
            <div class="col-lg-4 col-md-8">


            <?php

          if ($client->certified_status == '1') {
            $certified_status = 'Certified';
          } else {
            $certified_status = 'Un-Certified';
          }
          echo $certified_status;
            ?>

            </div>

            <div class="col-lg-3 col-md-8">

            <?php

          if ($client->certified_status == '1') {
            $certifiedStatus = '<a title="Certified Business" class="btn btn-success">Certified</a>';
          } else {
            $certifiedStatus = '<a title="Un-Certified Business" class="btn btn-danger">Un-Certified</a>';
          }
          echo $certifiedStatus;
            ?>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4 col-md-4 label "> Client Trusted Status: </div>
            <div class="col-lg-4 col-md-8">


            <?php

          if ($client->trusted_status == '1') {
            $trusted_status = 'Trusted';
          } else {
            $trusted_status = 'Un-Trusted';
          }
          echo $trusted_status;
            ?>

            </div>

            <div class="col-lg-3 col-md-8">

            <?php

          if ($client->trusted_status == '1') {
            $trustedStatus = '<a title="Trusted Business" class="btn btn-success">Trusted</a>';
          } else {
            $trustedStatus = '<a title="Un-trusted Business" class="btn btn-danger">Un-Trusted</a>';
          }
          echo $trustedStatus;
            ?>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-md-4 label "> Client GST Status: </div>
            <div class="col-lg-4 col-md-8">


            <?php

          if ($client->gst_status == '1') {
            $gst_status = 'GST Business';
          } else {
            $gst_status = 'NO-GST';
          }
          echo $gst_status;
            ?>

            </div>

            <div class="col-lg-3 col-md-8">

            <?php

          if ($client->gst_status == '1') {
            $gststatus = '<a title="GST Business" class="btn btn-success">GST Business</a>';
          } else {
            $gststatus = '<a title="No GST Business" class="btn btn-danger">NO GST Business</a>';
          }
          echo $gststatus;
            ?>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4 col-md-4 label ">Pausing and resuming the lead : </div>
            <div class="col-lg-4 col-md-8">


            <?php

            if ($client->pauseLead == '1') {
              $pauseLead = 'Resuming';
            } else {
              $pauseLead = 'Un-Resuming';
            }
            echo $pauseLead;
            ?>
            </div>

            <div class="col-lg-3 col-md-8">
            <?php

  if ($client->pauseLead == '1') {
    $pauseLeadStatus = '<a title="Pause Lead" class="btn btn-success">Pause Lead</a>';
  } else {
    $pauseLeadStatus = '<a title="Un-Pause Lead" class="btn btn-danger">Un-Pause Lead</a>';
  }
  echo $pauseLeadStatus;
            ?>


            </div>
          </div>

          <div class="row">
            <div class="col-lg-4 col-md-4 label "> Membership Type : </div>
            <div class="col-lg-4 col-md-8">

            <?php
  if ($client->client_type) {
    echo $client->client_type;
  }
            ?>
            </div>

            <div class="col-lg-3 col-md-8">


            <?php

  if (!empty($client->client_type)) {  ?>
            <a title="Course status" class="btn btn-success"><?php  echo $client->client_type; ?></a>
            <?php  } ?>


            </div>
          </div>
          <!-- <div class="row">
            <div class="col-lg-4 col-md-4 label ">Subscript expire  : </div>
            <div class="col-lg-4 col-md-8"> 26-7-2026</div>

             <div class="col-lg-3 col-md-8"> <a href="">Buy Package</a></div>
            </div> -->



          </div>
        </div>



        </div>
      </div>

      </div>
    </div>
    </section>

  </main><!-- End #main -->
@endsection