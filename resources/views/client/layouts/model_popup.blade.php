<div class="commonPopup">
	<a href="javascript:void(0);" class="dealclosebtn">&nbsp;</a>


	<div class="callback-wrapper">
		<div class="left-panel">
			<h2>Begin your journey with QuickDials</h2>
			<p><strong>Connect with trusted experts effortlessly</strong></p>
			<div class="benefits">
				<h4>Trust & Benefits:</h4>
				<ul>
					<li>✔ Shared only with selected experts</li>
					<li>✔ Get Free Expert Online Counseling</li>
					<li>✔ Industry-Certified Instructors</li>
					<li>✔ Book Your Free Education Demo Class</li>
					<li>✔ Get Fees & Discounts</li>
				</ul>
			</div>
		</div>
		<div class="right-panel">
			<h2>Need Expert Advice ?</h2>
			<p>Fill this form to Grab the best Deals on 
			</p>

			<div class="popup-box">



				<!-- Progress -->
				<div class="commonStep">
					<span class="active"></span>
					<span></span>
					<!-- <span></span> -->
					<span></span>
				</div>

				<!-- Form onsubmit="return homeController.saveTwoEnquiry(this)" method="POST"-->
				<form class="popup-form" id="commPopleadForm" onsubmit="return homeController.saveTwoEnquiry(this)"
					method="POST" autocomplete="off"
    autocorrect="off"
    autocapitalize="off">

					<!-- STEP 1 -->
					<div class="comm-popup-step active">
						<span>Your Details</span>

						<div class="erbr">
							<input type="text" name="name" placeholder="Full Name">
						</div>
						<div class="erbr">
							<input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
						</div>


						<input type="hidden" name="lead_form" value="1" />
						<input type="hidden" name="kw_text" id="kw_text"
							value="<?php echo isset($searchedKW) ? $searchedKW : ''; ?>" />
						<input type="hidden" name="city_id" id="city_id" class="city" value="{{Request::segment(1)}}" />
						<input type="hidden" name="from_page" id="from_page" value="{{ request()->path() }}">


						<div class="div-code">
							<div class="drop-number dropwn">
								<div class="dropdown">
									<div class="drop-input-wrapper form-group">
										<img loading="lazy" class="flag-icon selectedFlag" src="https://flagcdn.com/w40/in.png"
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
									<input type="tel" class="quick-remove" name="mobile" maxlength="15"
										placeholder="Phone No*">
								</div>
							</div>
						</div>
					<div class="erbr">
						What is your <strong>Location?</strong>
						<select name="location" id="zone_id" class="select2_location">
							<option value="">Select Location</option>
						</select>
					</div>
					<div class="btn-center">
						<button type="button" onclick="validateCommonStep(this, 1)">Save & Continue</button>
					</div>
					</div>
					<!-- STEP 2 -->
					<div class="comm-popup-step">
						
					<div class="erbr">
						What is your <strong>service?</strong>
						<select name="kw_text" class="select2_service">
							<option value="">Select Service</option>
						</select>
					</div>
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

						<div class="erbr">
							What’s your <strong>Age</strong>
							<select name="age" class="select2_age">
								<option value="">Select Age*</option>
								@for($i = 1; $i < 100; $i += 2)
									<option value="{{$i}}" {{ $i == 19 ? 'selected' : '' }}>{{ $i }} + Age</option>
								@endfor
							</select>
						</div>
						<div class="erbr">
							When you want to <strong>Start</strong>
							<select name="plan" class="select2_plane">
								<option value="Immediate" selected>Immediate</option>
								<option value="Within week">Within Week</option>
								<option value="Within months">Within Months </option>
								<option value="Not planned yet">Not Planned Yet</option>
							</select>
						</div>

 
					@if(!empty($keyword) && !empty($keyword->form_type) && $keyword->form_type === 'form_edu')
						<div class="erbr">

							<select name="experience">

								<option value="">Select Experience*</option>
								@for($i = 0; $i < 21; $i += 3)
									<option value="{{$i}}" {{ $i == 3 ? 'selected' : '' }}>{{ $i }} + Exp</option>
								@endfor
							</select>
						</div>
					@else
					<input type="hidden" name="experience" value="1">
					@endif

						<div class="btn-center">
							<button type="button" onclick="prevCommaPopupStep()">Back</button>
							<button type="button" onclick="validateCommonStep(this,2)">Save & Continue</button>
						</div>
					</div>

					<!-- STEP 3 -->
					<div class="comm-popup-step">
						<span>Confirm</span>
						<div class="erbr">
							<textarea name="remark" placeholder="Enter Remarks"></textarea>
						</div>

						<div class="terms">
							<input type="checkbox" name="terms" value="1" checked />
							I agree to the Quickdials terms and conditions <a href="{{route('terms.conditions')}}" target="_blank">Terms
								& Conditions</a>
						</div>

						<div class="btn-center">
							<button type="button" onclick="prevCommaPopupStep()">Back</button>
							<button type="submit">Submit</button>

					<div class="loaderForm" style="display:none;">
					<img src="{{ asset('/public/client/images/btn-ajax-loader.gif')}}" width="20" alt="Loader">
					Processing...
					</div>
						</div>
					</div>

				</form>
			</div>

		</div>
	</div>




</div>

 

	<script>
	 
		let currentcommonStep = 0;
		const commonPopupSteps = document.querySelectorAll(".comm-popup-step");

		const commonIndicators = document.querySelectorAll(".commonStep span");

	 
 


		function validateCommonStep(THIS, step) {

			var $this = $(THIS);
			let form = document.getElementById('commPopleadForm');
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
						nextCommonPopupStep();
					} else {
						showErrors($('#commPopleadForm'), res.errors);
					}
				});
		}


		 

		function showErrors($form, errors) {

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

				// let name = key.replace(/\./g, '\\.');
				// let $input = $form.find('[name="' + name + '"]');
				if ($input.length) {
					let $wrapper = $input.closest('.erbr');

					$wrapper.addClass('has-error');

					$wrapper.append(
						'<span class="help-block"><strong>' + messages[0] + '</strong></span>'
					);
				}
			});
		}

	 

		function nextCommonPopupStep() {

			if (currentcommonStep < commonPopupSteps.length - 1) {
				commonPopupSteps[currentcommonStep].classList.remove("active");
				commonIndicators[currentcommonStep].classList.remove("active");
				currentcommonStep++;
				commonPopupSteps[currentcommonStep].classList.add("active");
				commonIndicators[currentcommonStep].classList.add("active");
			}
		}

	 

		function prevCommaPopupStep() {
			if (currentcommonStep > 0) {
				commonPopupSteps[currentcommonStep].classList.remove("active");
				commonIndicators[currentcommonStep].classList.remove("active");
				currentcommonStep--;
				commonPopupSteps[currentcommonStep].classList.add("active");
				commonIndicators[currentcommonStep].classList.add("active");
			}
		}


	</script>



