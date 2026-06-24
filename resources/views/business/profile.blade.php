@extends('business.layouts.app')
@section('title')
Profile QuickDials
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on QuickDials and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
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
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Business Details</button>
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
                <form class="profile_info" id="profileInfoForm" method="POST" 
    onsubmit="return businessController.editProfileInfo(this,<?php echo (isset($client->id)? $client->id:""); ?>)">
    <input type="hidden" name="business_id" value="{{ old('middle_name',(isset($client)) ? $client->id:"")}}">

    {{-- Auto-save status --}}
  

    <div class="form-group">
        <label>Business Name*:</label>                
        <input name="business_name" type="text" class="form-control auto-save-field" value="{{ old('business_name',(isset($client)) ? $client->business_name:"")}}" placeholder="Please enter business name">
        <label>Email*:</label>
        <input name="email" type="email" class="form-control auto-save-field" id="Email" value="{{ old('email',(isset($client)) ? $client->email:"")}}" placeholder="Please enter Email">
    </div>

    <div class="form-group">
        <label>Mobile*:</label>                   
        <input type="text" class="form-control auto-save-field" name="mobile" value="{{ old('mobile',(isset($client)) ? $client->mobile:"")}}" placeholder="Enter Mobile">
        <label>WhatsApp No:</label>
        <input type="text" class="form-control auto-save-field" name="whatsapp" value="{{ old('whatsapp',(isset($client)) ? $client->whatsapp:"")}}" placeholder="Enter whats app no">
    </div>

    <div class="form-group">
        <label>Country*:</label>
        <select class="form-control auto-save-field" name="country"> 
            <option value="101" @if ('101'== old('country')) selected @else {{ (isset($client) && $client->country == '101' ) ? "selected":"" }} @endif>India</option>
        </select>
        <label>State*:</label>                     
        <select class="select2-single-state form-control state auto-save-field" name="state" onchange="get_city(this.value);">
            @if($states)
                @foreach($states as $state)
                <option value="{{$state->id}}" @if ($state->id== old('state')) selected @else {{ (isset($client) && $client->state_id == $state->id ) ? "selected":"" }} @endif>{{$state->name}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="form-group">                 
        <label>City*:</label>
        <select class="form-control show_cityList search_city auto-save-field" name="city" onchange="select_zone(this.value);">
            <option value="">Select City</option>
        </select>           
        <label>Zone:</label>
        <select class="form-control select_zoneList search_zone auto-save-field" name="zone">
            <option value="">Select Zone</option>		
        </select>
    </div>

    <div class="form-group">
        <label>Area:</label>
        <input type="text" class="form-control auto-save-field" name="area" value="{{ old('area',(isset($client->area)) ? $client->area:"")}}" placeholder="Enter Area">
        <label>Pincode*:</label>
        <input type="text" name="pincode" class="form-control auto-save-field" value="{{ old('pincode',(isset($client->pincode)) ? $client->pincode:"")}}" placeholder="Enter Pincode" maxlength="6">
    </div> 

    <div class="form-group">
        <label>Landmark:</label>
        <input name="landmark" type="text" class="form-control auto-save-field" value="{{ old('landmark',(isset($client)) ? $client->landmark:"")}}">
        <label>Year of Establishment:</label>              
        <select class="form-control auto-save-field" id="year_of_estb" name="year_of_estb">
            <option value="">Select Year</option>
            <?php for($i= 1970; $i<=2050; $i++){ ?>
            <option value="<?php echo $i; ?>" @if ($i == old('year_of_estb')) selected @else {{ (isset($client) && $client->year_of_estb == $i ) ? "selected":"" }} @endif><?php echo $i; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label>Address:</label>
        <textarea name="address" class="form-control auto-save-field" style="height: 100px">{{ old('address',(isset($client)) ? $client->address:"")}}</textarea>
    </div>
    <div class="form-group">              
        <label>Certifications:</label>                                
        <input name="certifications" type="text" class="form-control auto-save-field" value="{{ old('certifications', $client->certifications ?? '') }}" placeholder="Enter Certifications Comma separated if more than">
        <label>Google Map :</label>
        <input name="business_map" type="text" class="form-control auto-save-field" value="{{ old('business_map', $client->business_map ?? '') }}" placeholder="Enter business Map">
    </div>
    <?php
    $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
    $times = ["24:00" => "Open 24 Hrs", "00:00" => "Closed"];
    for ($h = 0; $h < 24; $h++) {
        foreach (['00', '30'] as $m) {
            $key = sprintf('%02d:%s', $h, $m);
            $times[$key] = $key;
        }
    }
    $time = !empty($client->time) ? json_decode($client->time) : [];
    ?>

    <?php foreach ($days as $day): ?>
    <div class="form-group">
        <div class="col-md-12" style="display: flex;"> 
            <label class="font-weight-bold"><?= ucfirst($day); ?></label>
            <div class="col-md-4">
                <select class="form-control time-from auto-save-field" name="time[<?= $day; ?>][from]">
                    <?php foreach ($times as $key => $value): ?>
                        <option value="<?= $key; ?>" <?= (!empty($time->$day->from) && $time->$day->from == $key) ? 'selected' : '' ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-1 text-center"><strong>To</strong></div>
            <div class="col-md-4">
                <select class="form-control time-to auto-save-field" name="time[<?= $day; ?>][to]">
                    <?php foreach ($times as $key => $value): ?>
                        <option value="<?= $key; ?>" <?= (!empty($time->$day->to) && $time->$day->to == $key) ? 'selected' : '' ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="text-center"> 
        <input type="hidden" name="savePersonal" value="savePersonalForm">
        <button type="submit" class="btn btn-primary">Save & Continue</button>
    </div>
  <div id="autoSaveStatus" style="display:none;"></div>
</form>
                
                 
                 
                </div>

                 
                
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
 <script>
 
	window.onload = function()
	{
		var state 	='<?php echo $client->state_id; ?>';
		var city 	= '<?php echo $client->city_id; ?>';	 
    var zone 	= '<?php echo $client->zone_id; ?>';	 

  
		get_city(state,city); 
    select_zone(city,zone); 
	}	 

function get_city(state,city){
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "post",	 
	url: "{{URl('business/cities/getajaxcities')}}",
	data: {sid:state,cid:city},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{
		$(".show_cityList").html(data);
	}
	});
}


function select_zone(city,zone){
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "POST",	 
	url: "{{URl('business/zone/getAjaxZone')}}",
	data: {city:city,zone:zone},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{
		$(".select_zoneList").html(data);
	}
	});
}



// ═══════════════════════════════════════════
// AUTO-SAVE — Profile Info Form
// ═══════════════════════════════════════════
(function () {
    var form          = document.getElementById('profileInfoForm');
    var clientId       = "<?php echo (isset($client->id) ? $client->id : ''); ?>";
    var debounceTimer  = null;

    if (!form) return;

    var fields = form.querySelectorAll('.auto-save-field');

    fields.forEach(function (field) {

        // ── Text/textarea: debounce while typing ──
        if (field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') {
            field.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    triggerAutoSave();
                }, 1500);
            });

            field.addEventListener('blur', function () {
                clearTimeout(debounceTimer);
                triggerAutoSave();
            });
        }

        // ── Select dropdowns: save after slight delay ──
        if (field.tagName === 'SELECT') {
            field.addEventListener('change', function () {
                // Wait for city/zone AJAX chains to finish populating
                setTimeout(function () {
                    triggerAutoSave();
                }, 600);
            });
        }
    });

    function triggerAutoSave() {
        if (typeof businessController !== 'undefined' && businessController.editProfileInfo) {
            businessController.editProfileInfo(form, clientId);
            showAutoSaveStatus('Saving...', 'info');
        }
    }
})();

function showAutoSaveStatus(text, type) {
    var statusEl = document.getElementById('autoSaveStatus');
    if (!statusEl) return;

    statusEl.textContent = text;
    statusEl.style.display = 'block';
    statusEl.style.padding = '8px 12px';
    statusEl.style.marginBottom = '10px';
    statusEl.style.borderRadius = '4px';
    statusEl.style.fontSize = '0.9em';

    if (type === 'success') {
        statusEl.style.background = '#d4edda';
        statusEl.style.color = '#155724';
    } else if (type === 'danger') {
        statusEl.style.background = '#f8d7da';
        statusEl.style.color = '#721c24';
    } else {
        statusEl.style.background = '#d1ecf1';
        statusEl.style.color = '#0c5460';
    }

    if (type !== 'info') {
        setTimeout(function () {
            statusEl.style.display = 'none';
        }, 3000);
    }
}

</script>
 @endsection