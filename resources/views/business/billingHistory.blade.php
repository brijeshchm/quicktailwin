@extends('business.layouts.app')
@section('title')
Quick Dials | Billing History
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
      <h1>Billing History</h1>
    
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

           
            
            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

               
                <div class="card-body">
                

                  <table class="table table-striped table-bordered table-hover" id="datatable-payment-billing-history">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Paid Amount</th>
                        <th>GST</th>
                        <th>Total Amount</th>
                        <th>Invoice PDF</th>
                      </tr>
                    </thead>
                    
                  </table>

                </div>

              </div>
            </div> 

           
            
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
         
      </div>
    </section>

  </main><!-- End #main -->

 @endsection