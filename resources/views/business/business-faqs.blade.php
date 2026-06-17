@extends('business.layouts.app')
@section('title')
Bisiness FAQs | Location
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
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Business FAQ</button>
                </li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
               
                  <form class="buss_location" method="POST" onsubmit="return businessController.saveBusinessFaqs(this,<?php echo (isset($client->id)? $client->id:""); ?>)">
                  <input type="hidden" name="client_id" value="{{$client->id}}"> 
                                  
              <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 1</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq1" placeholder="Enter FAQ Question 1" value="{{ old('faqq1',(isset($client)) ? $client->faqq1:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 1</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa1" placeholder="Enter FAQ Answer 1">{{ old('faqa1',(isset($client)) ? $client->faqa1:"")}}</textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 2</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq2" placeholder="Enter FAQ Question 2" value="{{ old('faqq2',(isset($client)) ? $client->faqq2:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 2</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa2" placeholder="Enter FAQ Answer 2">{{ old('faqa2',(isset($client)) ? $client->faqa2:"")}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 3</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq3" placeholder="Enter FAQ Question 3" value="{{ old('faqq3',(isset($client)) ? $client->faqq3:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 3</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa3" placeholder="Enter FAQ Answer 3">{{ old('faqa3',(isset($client)) ? $client->faqa3:"")}}</textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 4</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq4" placeholder="Enter FAQ Question 4" value="{{ old('faqq4',(isset($client)) ? $client->faqq4:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 4</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa4" placeholder="Enter FAQ Answer 4">{{ old('faqa4',(isset($client)) ? $client->faqa4:"")}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 5</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq5" placeholder="Enter FAQ Question 5" value="{{ old('faqq5',(isset($client)) ? $client->faqq5:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 5</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa5" placeholder="Enter FAQ Answer 5">{{ old('faqa5',(isset($client)) ? $client->faqa5:"")}}</textarea>
                </div>
            </div>


            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 6</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq6" placeholder="Enter FAQ Question 6" value="{{ old('faqq6',(isset($client)) ? $client->faqq6:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 6</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa6" placeholder="Enter FAQ Answer 6">{{ old('faqa6',(isset($client)) ? $client->faqa6:"")}}</textarea>
                </div>
            </div>
            

            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 7</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq7" placeholder="Enter FAQ Question 7" value="{{ old('faqq7',(isset($client)) ? $client->faqq7:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 7</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa7" placeholder="Enter FAQ Answer 7">{{ old('faqa7',(isset($client)) ? $client->faqa7:"")}}</textarea>
                </div>
            </div>
            

            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 8</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq8" placeholder="Enter FAQ Question 8" value="{{ old('faqq8',(isset($client)) ? $client->faqq8:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 8</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa8" placeholder="Enter FAQ Answer 8">{{ old('faqa8',(isset($client)) ? $client->faqa8:"")}}</textarea>
                </div>
            </div>
            

            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 9</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq9" placeholder="Enter FAQ Question 9" value="{{ old('faqq9',(isset($client)) ? $client->faqq9:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 9</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa9" placeholder="Enter FAQ Answer 9">{{ old('faqa9',(isset($client)) ? $client->faqa9:"")}}</textarea>
                </div>
            </div>
            

            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Question 10</label>
                <div class="col-md-8">
                    <input class="form-control" name="faqq10" placeholder="Enter FAQ Question 10" value="{{ old('faqq10',(isset($client)) ? $client->faqq10:"")}}">
                </div>
            </div>
            
            <div class="form-group">
                <label for="top_description" class="col-md-2 control-label">FAQ Answer 10</label>
                <div class="col-md-8">
                    <textarea class="form-control" name="faqa10" placeholder="Enter FAQ Answer 10">{{ old('faqa10',(isset($client)) ? $client->faqa10:"")}}</textarea>
                </div>
            </div>     
                
                
              <div class="text-center"> 
                 <input type="hidden" name="savePersonal" value="savePersonalForm">
                <button type="submit" class="btn btn-primary">Save & Continue</button>
        
              </div>
 

                  
                  </form>
                  
                   

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