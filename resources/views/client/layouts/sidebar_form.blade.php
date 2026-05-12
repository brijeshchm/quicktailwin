<div class="enquiry-card">
        <h3>Fill out the form to receive the best offers <span>{{ $keyword->keyword ?? '' }}</span></h3>
        <p>We’ll send you the contact details instantly free of charge</p>
 
        <form class="lead_Form" id="lead_Form" onsubmit="return homeController.saveTwoEnquiry(this)" method="POST">
                        {{ csrf_field() }} 

		<div class="steps">
			<span class="active"></span>
			<span></span>
			<!-- <span></span> -->
			<span></span>
			</div>

  <!-- STEP 1 -->
      <div class="form-step active">
        <span>Your Details</span>
			
        <div class="erbr">
        <input type="text" name="name" placeholder="Full Name" >       
        </div>
         <div class="erbr">
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
        </div>
       		 
      
	<input type="hidden" name="lead_form" value="1" />
	<input type="hidden" name="kw_text" id="kw_text" value="{{ !empty($keyword->keyword) ? $keyword->keyword : '' }}" />
	<input type="hidden" name="city_id" id="city_id" class="city" value="{{Request::segment(1)}}" />
	<input type="hidden" name="from_page" id="from_page" value="{{ request()->path() }}">


        <div class="div-code">
				<div class="drop-number dropwn">
					<div class="dropdown">
						<div class="drop-input-wrapper form-group">
							<img loading="lazy" class="flag-icon selectedFlag"
								src="https://flagcdn.com/w40/in.png"
								alt="Flag">

							<input type="text" class="dropwn-input" placeholder="Search country">
							<span class="clear-icon removeFlag">&#10005;</span>
							<span class="dropdown-icon">&#9662;</span>
						</div>
						<div class="erbr">
						<input type="hidden" class="countryCode" name="code">
						</div>
						<div class="dropdown-list"></div>
					</div>

	                <div class="quick_arrow form-group erbr">                         
                    <input type="tel" class="quick-remove" name="mobile" maxlength="15" placeholder="Phone No*">
					</div>
				</div>
		</div>
		<div class="erbr">
              What is your <strong>Location?</strong>
        <select name="location" class="select2_location">
       
		  	@if(!empty($zones))
				@foreach($zones as $zone)
					<option value="{{ $zone->id}}">{{ $zone->zone }} {{$zone->pincode}}</option>

				@endforeach
				@endif        
        </select>
        </div>
	

        <div class="btn-center">
        <button type="button" onclick="validateSidebar(this, 1)">Save & Continue</button>
        </div>
      </div>
     <!-- STEP 2 -->
      <div class="form-step">
        

 			
 			<div class="erbr">		
		<div class="fieldblock">  
				 
				  @if(!empty($keyword) && !empty($keyword->form_type) && $keyword->form_type === 'form_edu')
				<div class="fieldblock-form">

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="fresher">
					<span>Fresher</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="online" checked>
					<span>Online</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="offline">
					<span>Offline</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="crashcourse">
					<span>Crash Course</span>
					</label>
				</div>
					@elseif( !empty($keyword) && !empty($keyword->form_type) && $keyword->form_type === 'form_pg')

				<div class="fieldblock-form">
					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="shared">
					<span>Shared</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="single">
					<span>Single</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="male">
					<span>Male</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="female">
					<span>Female</span>
					</label>
				</div>
				@elseif(!empty($keyword) && !empty($keyword->form_type) && $keyword->form_type === 'form_doctor')

					<link href="{{asset('vendor/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">    
					<link href="{{asset('admin/vendor/datepicker/jquery-ui.css')}}" rel="stylesheet">
					<link href="{{asset('business/assets/css/daterangepicker.css')}}" rel="stylesheet">  


				<div class="fieldblock-form">
					<label class="radio-item">					 
					<span>Appointment</span>
					</label>

				 
					
        <div class="form-group input-icon">
    
           	<input type="hidden" name="frmcheck[]" value="none">	
			  <input type="text" name="appointment" placeholder="Select Date" class="appointment" > 
								
			<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
			<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

				 <script>
					$(document).ready(function () {
					 $('.appointment').datepicker({
							minDate: 0,                  
							dateFormat: 'yy-mm-dd',
							changeMonth: true,
							changeYear: true
					});
					});
				 </script>
				</div>
				</div>

				@elseif(!empty($keyword) && !empty($keyword->form_type) && $keyword->form_type === 'form_serv' )

				<div class="fieldblock-form">
					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="ac_split">
					<span>AC Split</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="ac_window">
					<span>AC Window</span>
					</label>

					<label class="radio-item">
					<input type="checkbox" name="frmcheck[]" value="freez_single_door">
					<span>Freeze Single Door</span>
					</label>						 
				</div>
				@else
				<div class="fieldblock-form">							 
				<input type="hidden" name="frmcheck[]" value="none">					 
												
				</div>
				@endif
			</div>
          
</div>
					<div class="erbr">
						What’s your <strong>Age</strong>
						<select name="age" class="select2_age" >
							<option value="">Select Age*</option>			
							@for($i = 1; $i < 100; $i += 4)			 
								<option value="{{$i}}" {{ $i == 17 ? 'selected' : '' }}>{{ $i }} + Age</option>				 
							@endfor			 
						</select>
					</div>
					<div class="erbr">
					When you want to <strong>Start</strong>
						<select name="plan" class="select2_plane">
						<option value="Immediate">Immediate</option>				 
						<option value="Within week">Within Week</option>				 
						<option value="Within months">Within Months </option>				 
						<option value="Not planned yet">Not Planned Yet</option>
						</select>
					</div>
 
      
				@if(!empty($keyword) && !empty($keyword->form_type) && $keyword->form_type === 'form_edu')	
				<div class="erbr">
				<select name="experience">
				<option value="">Select Experience*</option>			
				@for($i = 0; $i < 50; $i += 5)			 
				<option value="{{$i}}" {{ $i == 5 ? 'selected' : '' }}>{{ $i }} + Exp</option>				 
				@endfor
				</select>
				</div>
				@else
				<input type="hidden" name="experience" value="1">
				@endif
	 

        <div class="btn-center">
        <button type="button" onclick="prevStep()">Back</button>
        <button type="button" onclick="validateSidebar(this,2)">Save & Continue</button>
        </div>
      </div>

      <!-- STEP 3 -->
      <div class="form-step">
        <span>Confirm</span>
         <div class="erbr">
        <textarea name="remark" placeholder="Enter Remarks"></textarea>
        </div>

        <div class="terms">
            <input type="checkbox" name="terms" value="1" checked/>                
            I agree to the Quickdials terms and conditions <a href="{{route('terms.conditions')}}" target="_blank">Terms & Conditions</a>
        </div>

        <div class="btn-center"> 
        <button type="button" onclick="prevStep()">Back</button>
			
        <button type="submit" >Submit</button>
 			<div class="loaderForm" style="display:none;">
			<img src="{{ asset('/public/client/images/btn-ajax-loader.gif')}}" width="20" alt="loader">
			Processing...
			</div>
        </div>
      </div>
  
		<input type="reset" class="reset_lead_form hide" value="reset" />
	 </form>
    </div>
		
		<div class="side-row-1">
		<div class="side-data-txt">
		<p>Featured Service Advertising</p>
		</div>
		<img loading="lazy" src="<?php echo asset('landing/img/ads1.png'); ?>" alt="advertise" title="advertise">
		</div>
		

		<?php 
		if(!empty($keyword) && !empty($keyword->form_type) && $keyword->form_type === 'cloud-computing'){

		?>
		<div class="side-row-1">

		<div class="side-data-txt">
		<p>Cloud Advertising</p>
		</div>
		<img loading="lazy" src="<?php echo asset('landing/img/cloud-adv.png'); ?>" alt="advertise" title="advertise">
		</div>
		<?php  } ?>

	








 <style>
 .form-side strong{ color:#0076d7; }
 .form-side{   
    border: 1px solid #ddd;
    border-radius: 5px; 
     
 }
 .side-row-form {
    margin-top: 10px;
    
    text-align: center;
    display: grid
;
}
 </style>
 	 
 
      
			
	


		<div class="side-enquiry">
        <h3>Fill out the form to receive the best offers <span>{{ !empty($keyword->keyword) ? $keyword->keyword : '' }}</span></h3>
        <p>We’ll send you the contact details instantly free of charge</p>
 
        <form class="lead_Form autoLeadForm" onsubmit="return homeController.saveTwoEnquiry(this)" method="POST" autocomplete="off"
    autocorrect="off"
    autocapitalize="off">
         {{ csrf_field() }} 

       <div class="form-group input-icon">   
           
			  <input type="text" placeholder="Your Name" class="" id="name" name="name">   
				<input type="hidden" name="lead_form" value="1" />
				<input type="hidden" name="kw_text" id="kw_text" value="{{ old('searchedKW', $searchedKW ?? '') }}" />
				<input type="hidden" name="city_id" id="city_id" class="city" value="{{Request::segment(1)}}" />
				<input type="hidden" name="from_page" id="from_page" value="{{ request()->path() }}">
				<input type="hidden" name="remark"  value="remark">
				<input type="hidden" name="terms"  value="1" checked>
        </div>
        <div class="form-group input-icon">
        
            <input type="tel" placeholder="Your Mobile Number" class="" id="mobile" name="mobile">

        </div>
        <button class="btn">Send Advisor &raquo;&raquo;</button>
		<input type="reset" class="reset_lead_form hide" value="reset" />
	 </form>
    </div>


<div class="side-row-1">
		<div class="side-data-txt">
		<p>Featured Service Advertising</p>
		</div>
		<img loading="lazy" src="<?php echo asset('landing/img/entrance-exam.png'); ?>" alt="advertise" title="advertise">
		</div>








		
	<script>
		let currentStep = 0;
		const steps = document.querySelectorAll(".form-step");
		const indicators = document.querySelectorAll(".steps span");
		function validateSidebar(THIS, step) {

			var $this = $(THIS);
			// var form = document.querySelector("form");

			let form = document.getElementById('lead_Form');
			let formData = new FormData(form);

			// add extra value
			formData.append('step', step);

			fetch('/form/validate-step', {
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
				},
				body: formData
			})
				.then(res => res.json())
				.then(res => {
					if (res.status) {
						nextStep();
					} else {
						showErrorsForm($('#lead_Form'), res.errors);
					}
				});
		}

		function showErrorsForm($form, errors) {

			// remove old errors
			$form.find('.erbr').removeClass('has-error');
			$form.find('.help-block').remove();
 
			$.each(errors, function (key, messages) {

				if (key === 'frmcheck') {
 
					$input = $form.find('input[name="frmcheck[]"]');
				 
				} else {
					let name = key.replace(/\./g, '\\.');
					$input = $form.find('[name="' + name + '"]');
				}
  
				if ($input.length) {
					let $wrapper = $input.closest('.erbr');

					$wrapper.addClass('has-error');

					$wrapper.append(
						'<span class="help-block"><strong>' + messages[0] + '</strong></span>'
					);
				}
			});
		}

		function nextStep() {

			if (currentStep < steps.length - 1) {
				steps[currentStep].classList.remove("active");
				indicators[currentStep].classList.remove("active");
				currentStep++;
				steps[currentStep].classList.add("active");
				indicators[currentStep].classList.add("active");
			}
		}

	 

		function prevStep() {
			if (currentStep > 0) {
				steps[currentStep].classList.remove("active");
				indicators[currentStep].classList.remove("active");
				currentStep--;
				steps[currentStep].classList.add("active");
				indicators[currentStep].classList.add("active");
			}
		}
	 


	</script>

