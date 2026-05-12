@extends('business.layouts.app')
@section('title')
Quick Dials | Business Keyword
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on Estivaledge and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection
@section('content')	
 

  <main id="main" class="main">
<style>
    /* .help-block{  
    color: #ff0000;
    position: relative;
    margin-top: 61px;
    display: block;
    margin-left: -207px;
    } */
    .help-block{  
      color: #ff0000;
      display: block;
      margin-top: 64px;
      text-align: center;
      position: absolute;
      margin-left: 170px;
    }


    .select2-container--bootstrap .select2-selection--single {
    height: 46px !important;
    line-height: 1.42857143;
    padding: 6px 24px 6px 12px;
}

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
            position: relative;
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

  
 
</style>
    <div class="pagetitle">
      <h1>Business keywords</h1>
    </div> 
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <!-- Table with stripped rows -->
               
                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                  <!-- Profile Edit Form -->
                     <form class="keyword_form" method="POST"  onsubmit="return businessController.saveKeywordAssign(this,<?php echo (isset($clientID)? $clientID:""); ?>)">
                      <input type="hidden" name="business_id" value="<?php echo (isset($clientID)? $clientID:""); ?>">
                                  
  
                  <div class="form-group">
                    <label for="keyword">Keyword:</label>
                    <select class="form-control select2-keyword" name="keyword">
                      <option value="">Select Keyword</option>
                        @if(!empty($keywordlist))
                          @foreach($keywordlist as $keyword)
                        <option value="{{ $keyword->id}}">{{$keyword->keyword}}</option>
                        @endforeach
                        @endif
                      
                    </select>
                   

                </div>  
                
                
            <div class="text-center"> 
                 <input type="hidden" name="savePersonal" value="savePersonalForm">
                <button type="submit" class="btn btn-primary">Save & Continue</button>
              </div>
              </form>
              </div>	
				    <div class="row">
              <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-assigned-keywords">
                <thead>
                  <tr>
                    <th>Keywords</th>
                    <th>Parent Category</th>
                    <th>Child Category</th>
                 
                    <th>Action</th>
                  </tr>
                </thead>
                 </table> 
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

  </main>
  
<script>

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
 
</script>


@endsection
