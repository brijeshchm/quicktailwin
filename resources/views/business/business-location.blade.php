@extends('business.layouts.app')
@section('title')
Location Service | Location
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on Quick Dials and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection
@section('content')	
 

  
<style>
    .help-block{  
    color: #ff0000;
    position: relative;
    margin-top: 61px;
    display: block;
    margin-left: -150px;
    }
    .select2-container--bootstrap .select2-selection--single {
    height: 46px !important;
    line-height: 1.42857143;
    padding: 6px 24px 6px 12px;
}


div.dataTables_paginate ul.pagination {
    margin: 2px 0;
    white-space: nowrap;
}


.pagination {
    display: inline-block;
    padding-left: 0;
    margin: 20px 0;
    border-radius: 4px;
}

.pagination>li {
    display: inline;
}

.pagination>li:first-child>a, .pagination>li:first-child>span {
    margin-left: 0;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
}


.pagination>li>a, .pagination>li>span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #337ab7;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
}

 

.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    z-index: 3;
    color: #fff;
    cursor: default;
    background-color: #337ab7;
    border-color: #337ab7;
}
</style>
  <main id="main" class="main">
    <section class="section profile">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Business Location</button>
                </li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
               
                  <form class="buss_location" method="POST" onsubmit="return businessController.saveBusinessLocation(this,<?php echo (isset($client->id)? $client->id:""); ?>)">
                  <input type="hidden" name="client_id" value="{{$client->id}}"> 
                <div class="form-group">
                    <label for="state"> State:</label>
                    <select class="form-control select2-single-state" name="state_id" onchange="get_city(this.value);">
                      <option value="">Select State</option>
                    <?php
                      $selected = '';
                      if($statesis){
                        foreach($statesis as $state){
                          echo "<option value=\"".$state->id."\" >".$state->name."</otpion>";
                        }
                      }
                      ?>
                    </select>

                    </div>
                  <div class="form-group">
                    <label for="city">City:</label>
                    <select class="form-control show_cityList search_city" name="cityiesid" onchange="get_zone(this.value);">
                
                    </select>
                    OR 
                    <label for="zone">Area:</label>
                     <select class="form-control show_zoneList search_zone" name="zone_id" onchange="get_otherZone(this.value);">
                     
                    </select>
                    <div class="show_otherInput" ></div>

                </div>
                
            <div class="text-center"> 
                 <input type="hidden" name="savePersonal" value="savePersonalForm">
                <button type="submit" class="btn btn-primary">Save & Continue</button>
        
              </div>
 

                  
                  </form><!-- End Profile Edit Form -->

                </div>
                <div class="row pt-2" style="border-top: 2px solid rgb(235, 238, 244);    margin-top: 40px;"> 
                  <div class="table-responsive table-virtical-grid" >
                    <table class="table table-striped table-bordered table-hover" id="datatable-assigned-zones" >
                        <thead>
                        <tr role="row">
                         <th><input type="checkbox" id="check-all" class="check-box"></th>
                          <th>City</th>
                          <th>Area</th><th>Action</th></tr>
                        </thead>
                  </table>
                </div>
	            <div class="form-group">
                <div class="col-md-3">
							    <button type="button" class="btn btn-success  btn-block" onclick="javascript:enquiryController.selectDeleteParmanent()" >Delete All </button>
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
 <script>	
	// window.onload = function()
	// {
	// get_city(sid,cid);	 

	// }	 
	</script> 
<script>



function get_city(state,city){

	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('business/state/getAjaxSate')}}",
	data: {state:state,city:city},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{
    // console.log(data);
		$(".show_cityList").html(data);
	}
	});
}

function get_zone(city,zone){

	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('business/zone/getAjaxZone')}}",
	data: {city:city,zone:zone},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{
		$(".show_zoneList").html(data);
	}
	});
}


function get_otherZone(other){
 
 if(other == 'Other'){
		$(".show_otherInput").html('<input class="form-control" value="" name="other" style="margin-top: 22px;">');
 }else{
  
    $(".show_otherInput").html('');

 }
	 
}
</script>
 
	
 @endsection