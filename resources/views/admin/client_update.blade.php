<?php echo View::make('admin/header'); ?>
<link rel="stylesheet" href="{{ asset('drag_drop/jquery.ezdz.min.css')}}">
<style>
#btnAllRight,#btnRight,#btnLeft,#btnAllLeft{
	display:block;
	margin:5px auto;
	width:30px;
}
</style>     
 
   <div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
				<h1 class="page-header">Update "{{{ ucwords($client->business_name) }}}"</h1>
		</div>               
	</div>
<style>


.page-header {
    padding-bottom: 9px;
    margin: 4px 0 20px;
    border-bottom: 1px solid #eee;
}


	#sidebar {
	width: 250px;
	background-color: #1E3A8A;
	color: white;
    padding: 9px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    height: auto;
	}
	#page-content{
	display: flex;
	}
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
		.sidebar-item a{
			color:#fff;
		}
        .sidebar-item a:hover {
            background-color: #2a3b6c;
        }

        .sidebar-item a.active {
            background-color: #3b5998;
        }

        .sidebar-item i {
            font-size: 20px;
        }

        /* Content Area Styles */
        .section-content {
            flex: 1;
            padding: 0px 20px;
            background-color: #fff;
            display: none;
        }

        .section-content.active {
            display: block;
        }

        /* Form Styles */
        .form-container {            
            margin: 0 auto;
            background-color: white;
            padding: 7px 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group label span {
            color: red;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group select {
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="black" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            background-size: 12px;
        }

        .save-btn {
            background-color: #f4a261;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .save-btn:hover {
            background-color: #e68a00;
        }
    </style>
  <div id="page-content"> 
  <div id="sidebar">
        <div class="sidebar-item active" onclick="showContent('personalDetails')">
            <i class="fa fa-user"></i> <a href="#personalDetails">Personal Details</a>
        </div>
        <div class="sidebar-item" onclick="showContent('information')">
            <i class="fa fa-phone"></i><a href="#information"> Business Information</a>
        </div>
        <div class="sidebar-item" onclick="showContent('businessLocation')">
            <i class="fa fa-map-marker"></i><a href="#businessLocation">Business Location</a>
        </div>
        <div class="sidebar-item" onclick="showContent('uploadProfile')">
            <i class="fa fa-camera"></i> <a href="#uploadProfile">Company Logo</a>
        </div>
        <div class="sidebar-item" onclick="showContent('uploadGallery')">
            <i class="fa fa-image"></i> <a href="#uploadGallery">Upload Gallery</a>
        </div>
        <div class="sidebar-item" onclick="showContent('certificate')">
            <i class="fa fa-certificate"></i> <a href="#certificate">Certificate</a>
        </div>
        <div class="sidebar-item" onclick="showContent('award')">
            <i class="fa fa-trophy"></i> <a href="#award">Award</a>
        </div>
        <div class="sidebar-item" onclick="showContent('keywords')">
            <i class="fa fa-key"></i> <a href="#keywords">Assigned Keywords</a>
        </div>
        
        <div class="sidebar-item" onclick="showContent('accountSettings')">
            <i class="fa fa-cog"></i> <a href="#accountSettings">Account Settings</a>
        </div>
        <div class="sidebar-item" onclick="showContent('leads')">
            <i>📋</i><a href="#leads"> View All Lead</a>
        </div>
        <div class="sidebar-item" onclick="showContent('discussion')">
            <i>💬</i> <a href="#discussion">Discussion</a>
        </div>
        <div class="sidebar-item" onclick="showContent('payment')">
            <i>💳</i> <a href="#payment"> Payment Order</a>
        </div>
    </div>

    <!-- Content Area -->
    <div class="section-content active" id="personalDetails">
        <div class="form-container">
			<h4>Personal Details</h4>
		 
			<form class="form-horizontal personal_details" autocomplete="off"  method="POST" onsubmit="return ClientController.editSavePersonalDetails(this,<?php echo (isset($client->id)? $client->id:""); ?>)" >
					{{csrf_field()}}
			   
					<div class="form-group col-md-6">
						<div class="col-md-12"> 
 						<label>Title*:</label>
                    <select class="form-control" name="sirName">
                      <option value=""> Select Sir Name</option>
                      <option value="Ms" @if ('Ms'== old('sirName'))
                      selected="selected"	
                      @else
                      {{ (isset($client) && $client->sirName == 'Ms' ) ? "selected":"" }} @endif >Ms</option>
                      <option value="Mr" @if ('Mr'== old('sirName'))
                      selected="selected"	
                      @else
                      {{ (isset($client) && $client->sirName == 'Mr' ) ? "selected":"" }} @endif>Mr</option>
                      <option value="Mrs" @if ('Mrs'== old('sirName'))
                      selected="selected"	
                      @else
                      {{ (isset($client) && $client->sirName == 'Mrs' ) ? "selected":"" }} @endif>Mrs</option>
                    </select>							 
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<div class="col-md-12"> 
							<label>First Name*:</label>
					<input type="text" class="form-control" name="first_name" value="{{ old('first_name',(isset($client)) ? $client->first_name:"")}}" placeholder="Enter First Name">
					</div>
					</div>

					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						 <label>Middle Name:</label>
                    <input type="text" class="form-control" value="{{ old('middle_name',(isset($client)) ? $client->middle_name:"")}}" name="middle_name" placeholder="Enter Middle Name">
                
               
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						<label>Last Name:</label>
                    <input type="text" class="form-control" value="{{ old('last_name',(isset($client)) ? $client->last_name:"")}}" name="last_name" placeholder="Enter Last Name">
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						 <label>DOB*:</label>
                    <input type="text" class="form-control dob" value="{{ old('dob',(isset($client)) ? $client->dob:"")}}" name="dob" placeholder="Enter DOB">
                  
               
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						   <label>Email ID*:</label>
                    <input type="email" class="form-control" value="{{ old('personal_email',(isset($client)) ? $client->personal_email:"")}}" name="personal_email" placeholder="Enter Email" >
                  
               
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						    <label>Marital Status*:</label>
                    <select class="form-control" name="marital">
              <option value="Single" @if ('Single'== old('marital'))
								selected="selected"	
							@else
							{{ (isset($client) && $client->marital == 'Single' ) ? "selected":"" }} @endif>Single</option>
            				<option value="Married" @if ('Married'== old('marital'))
								selected="selected"	
							@else
							{{ (isset($client) && $client->marital == 'Married' ) ? "selected":"" }} @endif>Married</option>
            				<option value="Widowed" @if ('Married'== old('marital'))
								selected="selected"	
							@else
							{{ (isset($client) && $client->marital == 'Widowed' ) ? "selected":"" }} @endif>Widowed</option>

            				<option value="Divorced" @if ('Divorced'== old('marital'))
								selected="selected"	
							@else
							{{ (isset($client) && $client->marital == 'Divorced' ) ? "selected":"" }} @endif>Divorced</option>


                    </select>
                    
                    
               
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						   <label>Mobile*:</label>
                   
                    <input type="text" class="form-control" name="personal_phone" value="{{ old('personal_phone',(isset($client)) ? $client->personal_phone:"")}}" placeholder="Enter personal Mobile" >
               
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						  <label>Country:</label>
                  
                  <select class="form-control" name="country"> 
                  <option value="101" @if ('101'== old('country'))
                  selected="selected"	
                  @else
                  {{ (isset($client) && $client->country == '101' ) ? "selected":"" }} @endif>India</option>
                  </select>
                 
               
						</div>
					</div>

					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						<label>State:</label>                     
						<select class="form-control select2-single-state" name="personal_state" onchange="per_select_city(this.value);">
						@if($statesis)
						@foreach($statesis as $state)
						<option value="{{$state->id}}"  @if ($state->id== old('personal_state'))
						selected="selected"	
						@else
						{{ (isset($client) && $client->personal_state_id == $state->id ) ? "selected":"" }} @endif>{{$state->name}}</option>
						@endforeach
						@endif
						</select>
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="col-md-12"> 					 
                    	<label>City:</label>
						<select class="form-control show_cityList" name="personal_city" onchange="per_select_zone(this.value);">
						<option value="">Select City</option>					
						</select>                   
						</div>
					</div>

					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						 <label>Zone:</label>
						 <select class="form-control show_zoneList" name="personal_zone">
						<option value="">Select Zone</option>	
						
						</select>
                    
						</div>
					</div>
					 
									
					<div class="form-group col-md-6">
					 
						<div class="col-md-12"> 
						   <label>Area:</label>
                    <input type="text" class="form-control" name="personal_area" value="{{ old('personal_area',(isset($client)) ? $client->personal_area:"")}}"  placeholder="Enter personal Area">
                 
                
						</div>
					</div>	
					 
					<div class="form-group col-md-6">
					 
						<div class="col-md-12"> 
						   
                      <label>Pincode:</label>
                    <input type="text" class="form-control" name="personal_pincode" value="{{ old('personal_pincode',(isset($client)) ? $client->personal_pincode:"")}}"  maxlength="6" placeholder="Enter Personal Pincode">
                
						</div>
					</div>	

					<div class="form-group col-md-6">
						<div class="col-md-12"> 
						 <label>Address:</label>
                    <textarea type="text" class="form-control" name="personal_address"   placeholder="Enter personal address">{{ old('personal_address',(isset($client)) ? $client->personal_address:"")}} </textarea>
                   
                   
						</div>
					</div>	

					<div class="form-group col-md-6">
						<div class="col-sm-12"> 
						 <label>Gender:</label>
                    <select class="form-control" name="gender">
                        <option>Select Gender</option>
                        <option value="Male" @if ('Male'== old('gender'))
								selected="selected"	
							@else
							{{ (isset($client) && $client->gender == 'Male' ) ? "selected":"" }} @endif>Male</option>
                        <option value="Female" @if ('Female'== old('gender'))
								selected="selected"	
							@else
							{{ (isset($client) && $client->gender == 'Female' ) ? "selected":"" }} @endif>Female</option>
                        <option value="Other" @if ('Other'== old('gender'))
								selected="selected"	
							@else
							{{ (isset($client) && $client->gender == 'Other' ) ? "selected":"" }} @endif>Other</option>
                    </select>
						</div>
					</div>
					 

					<div class="form-group"> 
					<div class="col-sm-12"> 
					<input type="hidden" name="location_info" value="location_info">
					<div class="col-sm-offset-2 col-sm-4 text-right">
						<input type="submit" value="SAVE" class="btn btn-warning">
					</div>
					</div>
				</div>
			</form>
		
             		 
        </div>
    </div>

    <!-- Placeholder Content for Sections -->
    <div class="section-content" id="information">
        <div class="form-container">
            <h4>Business Information</h4>
           
			<form class="form-horizontal"  action="" onsubmit="return ClientController.ediSaveBusinessInfo(this,<?php echo (isset($client->id)? $client->id:""); ?>)" method="POST">
				{{csrf_field()}}
				<div class="form-group col-md-6">
					<div class="col-md-12">
					 <label>Business Name:</label>                
                    
                       <input name="business_name" type="text" class="form-control" value="{{ old('business_name',(isset($client)) ? $client->business_name:"")}}" placeholder="Please enter business name">
                   
               
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-md-12"> 
					  <label>*Email:</label>
                      <input name="email" type="email" class="form-control" id="Email" value="{{ old('email',(isset($client)) ? $client->email:"")}}" placeholder="Please enter Email" >
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					<label>Primary Mobile No: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					
						<input type="text" class="form-control" name="mobile" value="{{ old('mobile',(isset($client)) ? $client->mobile:"")}}" placeholder="Enter Primary Number">
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					<label>WhatsApp: </label>
					
						<input type="text" class="form-control" name="whatsapp" value="{{ old('whatsapp',(isset($client)) ? $client->whatsapp:"")}}" placeholder="Enter whats app">
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					<label>Country:</label>
                  
                  <select class="form-control" name="country"> 
                  <option value="101" @if ('101'== old('country'))
                  selected="selected"	
                  @else
                  {{ (isset($client) && $client->country == '101' ) ? "selected":"" }} @endif>India</option>
                  </select>
                 
					</div>
				</div>			 
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					<label>State:</label>                     
					<select class="select2-single-state form-control state" name="state" onchange="select_city(this.value);">
						      @if($statesis)
                      @foreach($statesis as $state)
                    <option value="{{$state->id}}"  @if ($state->id== old('state'))
                        selected="selected"	
                      @else
                      {{ (isset($client) && $client->state_id == $state->id ) ? "selected":"" }} @endif>{{$state->name}}</option>
                        @endforeach
                        @endif
					</select>
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					 <label>City:</label>
                    <select class="form-control dropdown-arrow dropdown-arrow-inverse city-form select_cityList" name="city" onchange="select_zone(this.value);">
                      <option value="">Select City</option>
                      @if(!empty($client->city_id))
                      <option value="{{$client->city_id}}" selected>{{$client->city}}</option>
                      @endif						
                    </select>           
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					 <label>Zone:</label>
                   <select class="form-control select_zoneList search_zone" name="zone">
					<option value="">Select Zone</option>		
						
						</select>
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					 <label>Area:</label>
                    <input type="text" class="form-control" name="area" value="{{ old('area',(isset($client->area)) ? $client->area:"")}}" placeholder="Enter Area">
                    
            
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					 <label>Pincode:</label>
                    <input type="text" name="pincode" class="form-control" value="{{ old('pincode',(isset($client->pincode)) ? $client->pincode:"")}}" placeholder="Enter Pincode">
            
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					  <label>Address:</label>
                     <textarea name="address" class="form-control" style="height: 100px"> {{ old('address',(isset($client)) ? $client->address:"")}}</textarea>
                   
               
            
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					   <label>Landmark:</label>
                    <input name="landmark" type="text" class="form-control"   value="{{ old('landmark',(isset($client)) ? $client->landmark:"")}}">
                 
               
            
					</div>
				</div>
				 
				
				<div class="form-group col-md-12">
					<div class="col-sm-12"> 
					
                    <label>Business Info:</label>
                   
                     <textarea name="business_intro" class="form-control" id="about"   rows="7">{{ old('business_intro',(isset($client->business_intro)) ? $client->business_intro:"")}}</textarea>
                    
              
               
            
					</div>
				</div>
				 
				 
				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					
                    <label>Google Map :</label>
                                
                    <input name="business_map" type="text" class="form-control" value="{{ old('business_map', $client->business_map ?? '') }}" >

               
            
					</div>
				</div>
				 
				 
			
			 

				<div class="form-group col-md-6">
					<div class="col-sm-12"> 
					<label>Website: </label>					 
						<input type="text" class="form-control" name="website" value="{{ old('website',(isset($client)) ? $client->website:"")}}" placeholder="Enter Website">
					</div>
				</div>
   			<?php
            $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

            $times = [
                "24:00" => "Open 24 Hrs",
                "00:00" => "Closed"
            ];

            // generate time slots
            for ($h = 0; $h < 24; $h++) {
                foreach (['00', '30'] as $m) {
                    $key = sprintf('%02d:%s', $h, $m);
                    $times[$key] = $key;
                }
            }

            $time = !empty($client->time) ? json_decode($client->time) : [];           
            ?>
  			<?php foreach ($days as $day): ?>
            <div class="form-group col-md-12">
              	<div class="col-md-12" style="display: flex;"> 
                 

                    <!-- Day -->
                  <div class="col-md-2">
                      <label class="font-weight-bold">
                          <?= ucfirst($day); ?>
                      </label>
                
					</div>
                    <!-- From -->
                    <div class="col-md-4">
                        <select class="form-control time-from"
                            name="time[<?= $day; ?>][from]">
                            <?php foreach ($times as $key => $value): ?>
                                <option value="<?= $key; ?>"
                                    <?= (!empty($time->$day->from) && $time->$day->from == $key) ? 'selected' : '' ?>>
                                    <?= $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                   
                    </div>

                    <!-- To Label -->
                    <div class="col-md-1 text-center">
                        <strong>To</strong>
                    </div>

                    <!-- To -->
                    <div class="col-md-4">
                        <select class="form-control time-to"
                            name="time[<?= $day; ?>][to]">
                            <?php foreach ($times as $key => $value): ?>
                                <option value="<?= $key; ?>"
                                    <?= (!empty($time->$day->to) && $time->$day->to == $key) ? 'selected' : '' ?>>
                                    <?= $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
               
            </div>
            <?php endforeach; ?>
   			<div class="form-group col-md-12">
					<div class="col-sm-12"> 
					     <label for="Country" class="col-md-4 col-lg-3 col-form-label">Hours of Operation</label>
                      <div class="col-md-4 col-lg-4">
                       
							<input type="radio" name="display_hofo" value="1" <?php echo (!empty($client->display_hofo) || $client->display_hofo == '1')?"checked":""; ?>>
							  <label class="radio-inline">Display Hours of Operation</label>
                      </div>
                       <div class="col-md-4 col-lg-5">
                         <input type="radio" name="display_hofo" value="0" <?php echo (empty($client->display_hofo) || $client->display_hofo == '0')?"checked":""; ?>>
						 <label class="radio-inline">Do Not Display Hours of Operation</label>
                      </div>
					</div>
				</div>
				<div class="form-group"> 
					<div class="col-sm-12"> 
					<input type="hidden" name="contact_info" value="contact_info">
					<div class="col-sm-offset-2 col-sm-4 text-right">
						<input type="submit" value="SAVE" class="btn btn-warning">
					</div>
					</div>
				</div>
			</form>
					 
	 
        </div>
    </div>


    <div class="section-content" id="businessLocation">
        <div class="form-container">
            <h4>Business Location</h4>			 
			<form class="form-horizontal" method="POST" action="#" id="assignedZone" onsubmit="return assignedZoneController.submit(this,<?php echo (isset($client->id)? $client->id:""); ?>)">
				{{ csrf_field() }}					
		<input type="hidden" name="client_id" value="<?php echo (isset($client->id)? $client->id:""); ?>" >
			<div class="form-group col-md-6">
				<div class="col-md-12"> 
				<label>Country:</label>
					<select class="form-control" name="country">
						<option value="">Select Country</option>
						<option value="101" @if ('101'== old('country'))
								selected="selected"	
							@else
							{{ (isset($client) && $client->country == '101' ) ? "selected":"" }} @endif>India</option>
				 
					</select>
				</div>
			</div>
			<div class="form-group col-md-6">
				<div class="col-md-12"> 
				<label for="state">State: <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					<select class="form-control select2-single-state" name="state_id">
						<?php
							$selected = '';
							if($statesis){
							foreach($statesis as $state){
								echo "<option value=\"".$state->id."\" >".$state->name."</otpion>";
							} }
						?>
					</select>
						
				</div>
			</div>
			<div class="form-group col-md-6">
				<div class="col-md-12"> 
					
				<label for="city">City:</label>
				<select class="dropdown-arrow dropdown-arrow-inverse city-form select2_single" name="cityid">
				<option value="">Select City</option>
				</select>
				</div>
			</div>	
						
			
			<div class="form-group col-md-6">
				<div class="col-md-12"> 
				<label for="zone">Zone:</label>
				<select name="zone_id" class="form-control">
					<option value="">Select Zone</option>
				</select>
				
			</div>
			</div>
			
			<div class="form-group col-md-6 other-zone">
				<div class="col-md-12"> 					
				<div class="show_otherInput"></div>
				
			</div>
			</div>
								
			<div class="col-md-3">
			<div class="form-group">
				<input type="submit" class="btn btn-warning" value="Submit" style="margin-top:20px;">
			</div>
			</div>
							
			</form>
			
			<div class="col-md-12">
			<div class="row">
			<div class=" table-responsive">
			<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-assigned-zones">
			<thead>
			<tr>
			<th><input type="checkbox" id="check-all" class="check-box"></th>
			<th>City</th>
			<th>Zone</th>
			<th>Action</th>
			</tr>
			</thead>
			</table>
			</div>

			 <div class="form-group">
                <div class="col-md-3">
				<button type="button" class="btn btn-success  btn-block" onclick="javascript:assignedZoneController.selectDeleteParmanent()" >Delete All </button>
				</div>
              </div>
			</div>
			</div>

				 
        </div>
    </div>
    <div class="section-content" id="uploadProfile">
        <div class="form-container">
            <h4>Company Logo</h4>
           
			<form class="profile-logo" id="profileLogo" action="" method="POST" enctype="multipart/form-data" > 
		 
			  <input type="hidden" name="business_id" value="{{$client->id}}">
                     <input type="hidden" name="upload_pics" value="upload_pics">
			<div class="form-group">
				<div class="col-md-12">
					<label for="year_of_estb">Year of Establishment:</label>
					 
					<select class="form-control" id="year_of_estb" name="year_of_estb">

					<option value="">Select Year</option>
					<?php for($i= 1970; $i<=2050; $i++){ ?>
					<option value="<?php echo $i; ?>"  @if ($i == old('year_of_estb'))
						selected="selected"	
					@else
					{{ (isset($client) && $client->year_of_estb == $i ) ? "selected":"" }} @endif><?php echo $i; ?></option>
					<?php  } ?>
					</select>


				</div>
			</div>
			<div class="form-group"> 
				<div class="col-md-12">
					<label for="certifications">Certifications:</label>
					<input type="text" class="form-control" id="certifications" name="certifications" value="{{ old('certifications',(isset($client)) ? $client->certifications:"")}}" placeholder="Comma separated certifications">
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-md-12">
					
					<label for="logo">Upload Logo:</label>					
					<?php
						if(!empty($client->logo)){
							
						$logo = unserialize($client->logo);
							
						if(!isset($logo['thumbnail'])){
							$logo['thumbnail'] = $logo['large'];
						}						
					?>
					<img loading="lazy" src="{{asset('/'.$logo['thumbnail']['src'])}}" width="100">  
					
				<a href="{{url('developer/clients/update/profileLogo/logoDel/'.$client->username)}}" class="btn btn-danger btn-sm" title="Remove my profile image" width="100"><i class="fa fa-trash"></i></a>
				<?php   }else{ ?>
					
						<input type="file" class="form-control" id="logo" name="logo" accept=".png,.jpeg,.jpg,.webp">
					
					<?php  	}  ?>
						
				</div>
				</div>
				<div class="form-group"> 
				<div class="col-md-12">
					<label for="">Upload Profile Pic:</label>
				
					<?php
						
						if(!empty($client->profile_pic)){
							$profile_pic = unserialize($client->profile_pic);
							if(!isset($profile_pic['thumbnail'])){
								$profile_pic['thumbnail'] = $profile_pic['large'];
							}
						
					?>
					<?php if(!empty($profile_pic['thumbnail'])){ ?><img loading="lazy" src="{{asset('/'.$profile_pic['thumbnail']['src'])}}" width="100"><?php  } ?>
						<a href="{{url('developer/clients/update/profileLogo/profilePicDel/'.$client->username)}}" class="btn btn-danger btn-sm" title="Remove my profile image" width="100"><i class="fa fa-trash"></i></a>
					<?php  }else{ ?>
								<input type="file" class="form-control" id="profile_pic" name="profile_pic" accept=".png,.jpeg,.jpg,.webp">
								
					
					<?php  } ?>
				
				</div>
			</div>

		 

			</form>

        </div>
    </div>
    <div class="section-content" id="uploadGallery">
        <div class="form-container">
            <h2>Upload Gallery</h2>
             <?php if(!empty($client->pictures)):
					$picture = unserialize($client->pictures);					
					for($i=0;$i<12;$i++){
						if(!isset($picture[$i])){
							$picture[$i]['large']['name'] = '';
						}
					}
				else:
					for($i=0;$i<12;$i++){
						$picture[$i]['large']['name'] = '';
					}
				endif; ?>
					
				<form id="imageform" method="post" enctype="multipart/form-data">
                     {{csrf_field()}}
                     <input type="hidden" name="business_id" value="{{$client->id}}">
                     <input type="hidden" name="upload_pics" value="upload_pics">
                    <div class="row mb-3">
                        <?php for($i=0;$i<21;$i++){                          
                      ?>
                      <div class="col-md-4 col-lg-4" id="image{{$i+1}}">
                      @if(empty($picture[$i]['large']['name']))
                      <input type="file" class="form-control fff" name="image{{$i+1}}" accept=".png, .jpg,.jpeg,.webp,.svg">
                      
                      @endif
                      <span class="img-help">
                        @if(isset($picture[$i]['large']['src'])&&!empty($picture[$i]['large']['src']))
                        <img loading="lazy" src="{{asset('/'.$picture[$i]['large']['src'])}}" style="height:75px;width:75px;">
                        <a href="javascript:void(0)" class="remove-thumbnail btn btn-danger btn-sm" data-srno="image{{$i+1}}" title="remove"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        @endif
                      </span>
                       <div class="pt-2"></div>                        
                      </div>
                      <?php  } ?>
                  </div>


                  </form> 
            


        </div>
    </div>
    
	 <div class="section-content" id="certificate">
        <div class="form-container">
            <h2>Certificate</h2>
              
  <style>                

                  .certificate_form img {

                    width: 120px;
                  }
                </style>
                <style>
                  .award-box {
                    border: 1px solid #e0e0e0;
                    padding: 12px;
                    border-radius: 6px;
                    margin-bottom: 15px;
                    height: 215px;

                  }

                  .award-box label {
                    font-weight: 600;
                    margin-bottom: 6px;
                    display: block;
                  }

                  .award-preview img {
                    max-width: 100px;
                    border: 1px solid #ddd;
                    padding: 5px;
                  }

                  .pdf-box {
                    width: 100px;
                    height: 100px;
                    border: 1px solid #ddd;
                  }

                  .btn-sm {
                    height: 34px;
                  }
                </style>
				 <form class="certificate_form" id="certificateForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="business_id"
                      value="{{ old('middle_name', (isset($client)) ? $client->id : "")}}">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                      <!-- pan no 1 -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Pan no</label>
                          <input type="text" name="pan_no" class="form-control"
                            value="{{ old('pan_no', (isset($client)) ? $client->pan_no : "")}}"
                            placeholder="Please pan no name">

                          @php
                            $pan_certificate = !empty($client->pan_certificate) ? json_decode($client->pan_certificate) : null;
                            $panPath = $pan_certificate->large->src ?? '';
                            $panUrl = $panPath ? asset($panPath) : '';
                            $ext = strtolower(pathinfo($panPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($panPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $panUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $panUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $panUrl }}">
                              @endif

                              <a href="{{ url('developer/clients/certificate/pan_certificate/' . $client->id) }}" class="btn btn-danger btn-sm"
                                title="Remove Award">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="pan_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>

                      <!-- ISO Certificate* -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>ISO Certificate*</label>
                          <input type="text" name="iso_no" class="form-control"
                            value="{{ old('iso_no', (isset($client)) ? $client->iso_no : "")}}"
                            placeholder="Please iso no">
                          @php
                            $isofile = !empty($client->iso_certificate) ? json_decode($client->iso_certificate) : null;
                            $isoPath = $isofile->large->src ?? '';
                            $isoUrl = $isoPath ? asset($isoPath) : '';
                            $ext = strtolower(pathinfo($isoPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($isoPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $isoUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $isoUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $isoUrl }}">
                              @endif
                              <a href="{{ url('developer/clients/certificate/iso_certificate/' . $client->id) }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="iso_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>
                      <!-- GST Certificate -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>GST No</label>
                          <input type="text" name="gst_no" class="form-control"
                            value="{{ old('gst_no', (isset($client)) ? $client->gst_no : "")}}"
                            placeholder="Please gst_no">
                          @php
                            $gstFile = !empty($client->gst_certificate) ? json_decode($client->gst_certificate) : null;
                            $gstPath = $gstFile->large->src ?? '';
                            $gstUrl = $gstPath ? asset($gstPath) : '';
                            $ext = strtolower(pathinfo($gstPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($gstPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $gstUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $gstUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $gstUrl }}">
                              @endif

                              <a href="{{ url('developer/clients/certificate/gst_certificate/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="gst_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>


                    </div>


                    <div class="row">
                      <!-- cin_no -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>CIN No</label>
                          <input type="text" name="cin_no" class="form-control"
                            value="{{ old('cin_no', (isset($client)) ? $client->cin_no : "")}}"
                            placeholder="Please cin no">
                          @php
                            $cinFile = !empty($client->cin_certificate) ? json_decode($client->cin_certificate) : null;
                            $cinPath = $cinFile->large->src ?? '';
                            $cinUrl = $cinPath ? asset($cinPath) : '';
                            $ext = strtolower(pathinfo($cinPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($cinPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $cinUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $cinUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $cinUrl }}">
                              @endif

                              <a href="{{ url('developer/clients/certificate/cin_certificate/' . $client->id) }}"
                                class="btn btn-danger btn-sm" title="Remove Award">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="cin_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>

                      <!-- msme_no -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>MSME No</label>
                          <input type="text" name="msme_no" class="form-control"
                            value="{{ old('msme_no', (isset($client)) ? $client->msme_no : "")}}"
                            placeholder="Please msme no">
                          @php
                            $msmeFile = !empty($client->msme_certificate) ? json_decode($client->msme_certificate) : null;
                            $msmePath = $msmeFile->large->src ?? '';
                            $msmeUrl = $msmePath ? asset($msmePath) : '';
                            $ext = strtolower(pathinfo($msmePath, PATHINFO_EXTENSION));
                          @endphp

                          @if($msmePath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $msmeUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $msmeUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $msmeUrl }}">
                              @endif
                              <a href="{{ url('developer/clients/certificate/msme_certificate/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="msme_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>

                      <!-- Certificate of Incorporation -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Certificate of Incorporation no</label>
                          <input type="text" name="coi_no" class="form-control"
                            value="{{ old('coi_no', (isset($client)) ? $client->coi_no : "")}}"
                            placeholder="Please Enter COI no">
                          @php
                            $coiFile = !empty($client->coi_certificate) ? json_decode($client->coi_certificate) : null;
                            $coiPath = $coiFile->large->src ?? '';
                            $coiUrl = $coiPath ? asset($coiPath) : '';
                            $ext = strtolower(pathinfo($coiPath, PATHINFO_EXTENSION));
                          @endphp

                          @if($coiPath)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $coiUrl }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $coiUrl }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $coiUrl }}">
                              @endif

                              <a href="{{ url('developer/clients/certificate/coi_certificate/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="coi_certificate" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <!-- other_certificate1 -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Other certificate 1</label>

                          @php
                            $certificate1File = !empty($client->other_certificate1) ? json_decode($client->other_certificate1) : null;
                            $cert1Path = $certificate1File->large->src ?? '';
                            $cert1Url = $cert1Path ? asset($cert1Path) : '';
                            $ext = strtolower(pathinfo($cert1Path, PATHINFO_EXTENSION));
                          @endphp

                          @if($cert1Path)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $cert1Url }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $cert1Url }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $cert1Url }}">
                              @endif

                              <a href="{{ url('developer/clients/certificate/other_certificate1/' . $client->id) }}"
                                class="btn btn-danger btn-sm" title="Remove Award">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="other_certificate1" class="form-control"
                              accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>

                      <!-- Other Certificate 2 -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Other Certificate 2</label>

                          @php
                            $cert2File = !empty($client->other_certificate2) ? json_decode($client->other_certificate2) : null;
                            $other2Path = $cert2File->large->src ?? '';
                            $other2Url = $other2Path ? asset($other2Path) : '';
                            $ext = strtolower(pathinfo($other2Path, PATHINFO_EXTENSION));
                          @endphp

                          @if($other2Path)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $other2Url }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $other2Url }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $other2Url }}">
                              @endif
                              <a href="{{ url('developer/clients/certificate/other_certificate2/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="other_certificate2" class="form-control"
                              accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>
                      <!-- Other Certificate 3 -->
                      <div class="col-md-4">
                        <div class="award-box">
                          <label>Other Certificate 3</label>

                          @php
                            $other3File = !empty($client->other_certificate3) ? json_decode($client->other_certificate3) : null;
                            $other3Path = $other3File->large->src ?? '';
                            $other3Url = $other3Path ? asset($other3Path) : '';
                            $ext = strtolower(pathinfo($other3Path, PATHINFO_EXTENSION));
                          @endphp

                          @if($other3Url)
                            <div class="award-preview images-div">
                              @if($ext === 'pdf')
                                <embed src="{{ $other3Url }}" type="application/pdf" class="pdf-box">
                                <a href="{{ $other3Url }}" target="_blank" class="btn btn-primary btn-sm mt-2">View</a>
                              @else
                                <img loading="lazy" src="{{ $other3Url }}">
                              @endif

                              <a href="{{ url('developer/clients/certificate/other_certificate3/' . $client->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>


                          @else
                            <input type="file" name="other_certificate3" class="form-control"
                              accept=".jpg,.jpeg,.png,.webp">
                          @endif
                        </div>
                      </div>
                    </div>
                  </form> 

        </div>
    </div>
  
	 <div class="section-content" id="award">
        <div class="form-container">
            <h2>Award</h2>
             
  <style>
                   

                  .certificate_form img {

                    width: 120px;
                  }
                </style>
                <style>
                  .award-box {
                    border: 1px solid #e0e0e0;
                    padding: 12px;
                    border-radius: 6px;
                    margin-bottom: 15px;
                    height: 215px;

                  }

                  .award-box label {
                    font-weight: 600;
                    margin-bottom: 6px;
                    display: block;
                  }

                  .award-preview img {
                    max-width: 100px;
                    border: 1px solid #ddd;
                    padding: 5px;
                  }

                  .pdf-box {
                    width: 100px;
                    height: 100px;
                    border: 1px solid #ddd;
                  }

                  .btn-sm {
                    height: 34px;
                  }
                </style>
				   <form class="award_form" id="awardFrom" method="POST"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="business_id"
                                            value="{{ old('middle_name', (isset($client)) ? $client->id : "")}}">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="row">
                                            <!-- AWARD 1 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 1 *</label>
                                                    <input type="text" name="award_name1" class="form-control"
                                                        value="{{ old('award_name1', (isset($client)) ? $client->award_name1 : "")}}"
                                                        placeholder="Please Award name">

                                                    @php
                                                        $award_img1 = !empty($client->award_img1) ? json_decode($client->award_img1) : null;
                                                        $award1Path = $award_img1->large->src ?? '';
                                                        $award1Url = $award1Path ? asset($award1Path) : '';
                                                        $ext = strtolower(pathinfo($award1Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award1Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award1Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award1Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award1Url }}">
                                                            @endif

                                                            <a href="{{ url('developer/clients/certificate/award_img1/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm" title="Remove Award">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img1" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- AWARD 2 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 2</label>
                                                    <input type="text" name="award_name2" class="form-control"
                                                        value="{{ old('award_name2', (isset($client)) ? $client->award_name2 : "")}}"
                                                        placeholder="Please Award name 2">
                                                    @php
                                                        $award2file = !empty($client->award_img2) ? json_decode($client->award_img2) : null;
                                                        $award2Path = $award2file->large->src ?? '';
                                                        $award2Url = $award2Path ? asset($award2Path) : '';
                                                        $ext = strtolower(pathinfo($award2Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award2Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award2Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award2Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award2Url }}">
                                                            @endif
                                                            <a href="{{ url('developer/clients/certificate/award_img2/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img2" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- AWARD 3 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 3</label>
                                                    <input type="text" name="award_name3" class="form-control"
                                                        value="{{ old('award_name3', (isset($client)) ? $client->award_name3 : "")}}"
                                                        placeholder="Please Award name 3">
                                                    @php
                                                        $award3File = !empty($client->award_img3) ? json_decode($client->award_img3) : null;
                                                        $award3Path = $award3File->large->src ?? '';
                                                        $award3Url = $award3Path ? asset($award3Path) : '';
                                                        $ext = strtolower(pathinfo($award3Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award3Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award3Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award3Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award3Url }}">
                                                            @endif

                                                            <a href="{{ url('developer/clients/certificate/award_img3/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img3" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row">
                                            <!-- AWARD 4 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 4 *</label>
                                                    <input type="text" name="award_name4" class="form-control"
                                                        value="{{ old('award_name4', (isset($client)) ? $client->award_name4 : "")}}"
                                                        placeholder="Please Award name 4">
                                                    @php
                                                        $award4File = !empty($client->award_img4) ? json_decode($client->award_img4) : null;
                                                        $award4Path = $award4File->large->src ?? '';
                                                        $award4Url = $award4Path ? asset($award4Path) : '';
                                                        $ext = strtolower(pathinfo($award4Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award4Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award4Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award4Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award4Url }}">
                                                            @endif

                                                            <a href="{{ url('developer/clients/certificate/award_img4/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm" title="Remove Award">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img4" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- AWARD 5 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 5</label>
                                                    <input type="text" name="award_name5" class="form-control"
                                                        value="{{ old('award_name5', (isset($client)) ? $client->award_name5 : "")}}"
                                                        placeholder="Please Award name 5">
                                                    @php
                                                        $award5File = !empty($client->award_img5) ? json_decode($client->award_img5) : null;
                                                        $award5Path = $award5File->large->src ?? '';
                                                        $award5Url = $award5Path ? asset($award5Path) : '';
                                                        $ext = strtolower(pathinfo($award5Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award5Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award5Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award5Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award5Url }}">
                                                            @endif
                                                            <a href="{{ url('developer/clients/certificate/award_img5/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img5" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- AWARD 6 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 6</label>
                                                    <input type="text" name="award_name6" class="form-control"
                                                        value="{{ old('award_name6', (isset($client)) ? $client->award_name6 : "")}}"
                                                        placeholder="Please Award name 6">
                                                    @php
                                                        $award6File = !empty($client->award_img6) ? json_decode($client->award_img6) : null;
                                                        $award6Path = $award6File->large->src ?? '';
                                                        $award6Url = $award6Path ? asset($award6Path) : '';
                                                        $ext = strtolower(pathinfo($award6Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award6Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award6Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award6Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award6Url }}">
                                                            @endif

                                                            <a href="{{ url('developer/clients/certificate/award_img6/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img6" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <!-- AWARD 7 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 7 *</label>
                                                    <input type="text" name="award_name7" class="form-control"
                                                        value="{{ old('award_name7', (isset($client)) ? $client->award_name7 : "")}}"
                                                        placeholder="Please Award name 7">
                                                    @php
                                                        $award7File = !empty($client->award_img7) ? json_decode($client->award_img7) : null;
                                                        $award7Path = $award7File->large->src ?? '';
                                                        $award7Url = $award7Path ? asset($award7Path) : '';
                                                        $ext = strtolower(pathinfo($award7Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award7Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award7Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award7Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award7Url }}">
                                                            @endif

                                                            <a href="{{ url('developer/clients/certificate/award_img7/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm" title="Remove Award">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img7" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- AWARD 8 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 8</label>
                                                    <input type="text" name="award_name8" class="form-control"
                                                        value="{{ old('award_name8', (isset($client)) ? $client->award_name8 : "")}}"
                                                        placeholder="Please Award name 8">
                                                    @php
                                                        $award8File = !empty($client->award_img8) ? json_decode($client->award_img8) : null;
                                                        $award8Path = $award8File->large->src ?? '';
                                                        $award8Url = $award8Path ? asset($award8Path) : '';
                                                        $ext = strtolower(pathinfo($award8Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award8Path)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award8Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award8Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award8Url }}">
                                                            @endif
                                                            <a href="{{ url('developer/clients/certificate/award_img8/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img8" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- AWARD 9 -->
                                            <div class="col-md-4">
                                                <div class="award-box">
                                                    <label>Award 9</label>
                                                    <input type="text" name="award_name9" class="form-control"
                                                        value="{{ old('award_name9', (isset($client)) ? $client->award_name9 : "")}}"
                                                        placeholder="Please Award name 9">
                                                    @php
                                                        $award9File = !empty($client->award_img9) ? json_decode($client->award_img9) : null;
                                                        $award9Path = $award9File->large->src ?? '';
                                                        $award9Url = $award9Path ? asset($award9Path) : '';
                                                        $ext = strtolower(pathinfo($award9Path, PATHINFO_EXTENSION));
                                                    @endphp

                                                    @if($award9Url)
                                                        <div class="award-preview images-div">
                                                            @if($ext === 'pdf')
                                                                <embed src="{{ $award9Url }}" type="application/pdf"
                                                                    class="pdf-box">
                                                                <a href="{{ $award9Url }}" target="_blank"
                                                                    class="btn btn-primary btn-sm ">View</a>
                                                            @else
                                                                <img loading="lazy" src="{{ $award9Url }}">
                                                            @endif

                                                            <a href="{{ url('developer/clients/certificate/award_img9/' . $client->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>


                                                    @else
                                                        <input type="file" name="award_img9" class="form-control"
                                                            accept=".jpg,.jpeg,.png,.webp">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>



                                       

                                    </form>

        </div>
    </div>
  
	<div class="section-content" id="keywords">
        <div class="form-container">
            <h4>Assigned Keywords</h4>
          


				<div id="ass_kw_wrapper" style="display:<?php echo ($client->client_type==="general")?"block":"block"; ?>;">
									 
				<form class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST" id="kw_form" name="kw_form" >
						{{csrf_field()}}
						<div class="form-group">
							
				<input type="hidden" name="client_id" id="clientIDASSKW" value="{{$client->username}}">									
				 
							
							<div class="col-md-12">
								<label for="keyword">Keywords:</label>
								<select class="form-control select2_single keyword_m" name="keyword[]"  multiple>
								<option value=""></option>
								@if($keywordlist)
								@foreach($keywordlist as $key)
									<option value="{{ $key->id }}">{{ $key->keyword}} </option>
								@endforeach
								@endif
								</select>
							</div>							 						 
							<input type="hidden" name="kw-submit" value="kw-submit">
							<div class="col-md-3">
								<label for="submit" style="visibility:hidden">Submit:</label>
								<input type="reset" class="btn btn-default hide reset_kw_submit" />
								<button type="submit" class="btn btn-warning btn-block kw-submit">Submit</button>
							</div>
						</div>
						<div class="form-group">
						</div>
					</form>

				 
					<style>
					.check-box{
						height:18px;
						width:20px;
						cursor:pointer;
					}
					</style>
					<div class="table-responsive col-md-12">
						<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-assigned-keywords">
							 
							<caption>Assigned Keywords</caption>
							<thead>
								<tr>
									<th><input type="checkbox" id="check-all" class="check-box"></th></th>											 
									<th>KW</th>
									<th>Child Category</th>
									<th>Parent Category</th>
									<!-- <th>City</th>
									<th>Zone</th> -->
									<!-- <th>Position</th> -->
									<!--<th>Price</th>-->
									<th>Action</th>
								</tr>
							</thead>
							 
						</table>
						<form class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
							{{csrf_field()}}
							<div class="form-group">
							@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('export_assign_keyword'))
								<div class="col-md-2">
									<input type="submit" class="btn btn-success btn-block" name="kw-export" value="Export">
								</div>	 
								@endif
									@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('assign_keyword_delete'))
								<div class="col-md-4">
									<button type="button" class="btn btn-success btn-block" onclick="javascript:assignedKeywordController.deleteSelectedAssignedKwds()">Delete Selected</button>
								</div>
								@endif
								 
							</div>
						</form>
					</div>

								 
							</div>


			 
        </div>
    </div>
    
	<div class="section-content" id="accountSettings">
        <div class="form-container">
            <h4>Account Settings</h4>
         
			<form id="submitActiveStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
				{{csrf_field()}}
				<div class="form-group col-md-6" style="display:flex">
					<div class="col-md-12">
						 Client Active Status: 
						<input type="checkbox" style="height:14px;width:14px;" class="active_status" name="active_status" value="1" <?php echo ($client->active_status)?"checked":""; ?> />
					</div>
					<div class="col-md-1">						 
						<input type="hidden" name="submit_active_status" value="1" />
					</div>
				</div>
			</form>

			<div>
				<form id="submitPaidStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
					{{csrf_field()}}
					<div class="form-group col-md-6">
						<div class="col-md-12">
							Client Paid Status: 
							<input type="checkbox" style="height:14px;width:14px;" class="paid_status" name="paid_status" value="1" <?php echo ($client->paid_status)?"checked":""; ?> />
						</div>
						<div class="col-md-1">
							
							<input type="hidden" name="submit_paid_status" value="1" />
						</div>
					</div>
				</form>
			</div>	

		
				<div>
					<form id="submitCertifiedStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
						{{csrf_field()}}
						<div class="form-group col-md-6">
							<div class="col-md-12">
								 Client Certified Status: 
								<input type="checkbox" style="height:14px;width:14px;" class="certified_status" name="certified_status" value="1" <?php echo ($client->certified_status)?"checked":""; ?> />
							</div>
							<div class="col-md-1">
								<label style="visibility:hidden">Submit:</label>
								<input type="hidden" name="submit_certified_status" value="1" />
							</div>
						</div>
					</form>

				</div>
				
		
				<div>
					<form id="submitTrustedStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
						{{csrf_field()}}
						<div class="form-group col-md-6">
							<div class="col-md-12">
								 Client Trusted Status: 
								<input type="checkbox" style="height:14px;width:14px;" class="trusted_status" name="trusted_status" value="1" <?php echo ($client->trusted_status)?"checked":""; ?> />
							</div>
							<div class="col-md-1">
								<label style="visibility:hidden">Submit:</label>
								<input type="hidden" name="submit_trusted_status" value="1" />
							</div>
						</div>
					</form>

				</div>
				<div>
					<form id="submitGSTtatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
						{{csrf_field()}}
						<div class="form-group col-md-6">
							<div class="col-md-12">
								 GST Status: 
								<input type="checkbox" style="height:14px;width:14px;" class="gst_status" name="gst_status" value="1" <?php echo ($client->gst_status)?"checked":""; ?> />
							</div>
							<div class="col-md-1">
								<label style="visibility:hidden">Submit:</label>
								<input type="hidden" name="submit_gst_status" value="1" />
							</div>
						</div>
					</form>

				</div>

							
				<div>

					<?php
					$userList = getUserList();				 
					?>
					<form id="submitAssignClient" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
						{{csrf_field()}}
					<input type="hidden" name="client_id" id="clientIDASSKW" value="{{$client->username}}">
						
						<div class="form-group">
							<div class="col-md-6">
								<label>Assign Client:</label>
									@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('client_package_name'))
								<select class="select2-single form-control assign_client" name="created_by">
									<?php
										foreach($userList as $user){
											$selected = "";
											if($user->id == $client->created_by):
												$selected = "selected";
											endif;
											?>
											<option value="{{ $user->id }}" <?php echo $selected; ?>>{{ $user->first_name.' '.$user->last_name; }}</option>
											<?php
										}
									?>
								</select>
								@else
									<?php
										foreach($userList as $user){
											if($user->id == $client->created_by):
												echo "<p>".$user->first_name.' '.$user->last_name."</p>";
											endif;
										}
									?>
								@endif
							</div>
							<div class="col-md-1">
								 
								<input type="hidden" name="submit_client_assign" value="1" />
								 
							</div>
						</div>
					</form>
				</div>
						
				<div>

					<?php
					$clientTypes = getClientsType();
					?>
					<form id="submitClientType" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
						{{csrf_field()}}
						<div class="form-group">
							<div class="col-md-6">
								<label>Client Package Name:</label>
									@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('client_package_name'))
								<select class="select2-single form-control client_type" name="client_type">
									<?php
										foreach($clientTypes as $key => $value){
											$selected = "";
											if($key == $client->client_type):
												$selected = "selected";
											endif;
											?>
											<option value="{{ $key }}" <?php echo $selected; ?>>{{ $value }}</option>
											<?php
										}
									?>
								</select>
								@else
									<?php
										foreach($clientTypes as $key => $value){
											if($key == $client->client_type):
												echo "<p>$value</p>";
											endif;
										}
									?>
								@endif
							</div>
							<div class="col-md-1">
								 
								<input type="hidden" name="submit_client_type" value="1" />
								 
							</div>
						</div>
					</form>
				</div>
						
				
			<div id="leads_count" style="display:<?php echo ($client->client_type==="gold" || $client->client_type==="diamond"|| $client->client_type==="platinum")?"block":"none"; ?>;">
						<form class="form-horizontal" id="count_based_subscription_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
							{{csrf_field()}}
							<div class="form-group">
						 
								<div class="col-md-6">
									<label>Coins Remaining:</label>
									<input type="text" class="form-control" value="{{$client->coins_amt}}" readonly />
								</div>
									@if($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager') )
								<div class="col-md-1">
									<label style="visibility:hidden">Submit:</label>
									<input type="hidden" name="submit_leads_count" value="1" />
								 
								</div>
								@endif
							</div>
						</form>
						<form class="form-horizontal" id="yearly_subs_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
							{{csrf_field()}}
							<div class="form-group">
								<div class="col-md-3">
									<label>Starting Date:</label>
									<input type="text" class="form-control x_date" name="expired_from" value="{{date_format(date_create($client->expired_from),'Y-m-d')}}" />
								</div>
								<div class="col-md-3">
									<label>End Date:</label>
									<input type="text" class="form-control y_date" name="expired_on" value="{{date_format(date_create($client->expired_on),'Y-m-d')}}" />
								</div>
									@if($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager') )
								<div class="col-md-2">
									<label style="visibility:hidden">Submit:</label>
									<input type="hidden" name="submit_yrly_subs_starting_date" value="1" />
									<button type="submit" class="btn btn-warning btn-block kw-submit">SAVE</button>
								</div>
								@endif
							</div>
						</form>
						
						<form class="form-horizontal" id="max_kw_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
							{{csrf_field()}}
							<div class="form-group">
								<div class="col-md-3">
									<label>Max Keywords:</label>
									<input type="number" min=0 step=1 class="form-control" name="max_kw" value="{{$client->max_kw}}" />
								</div>
								@if($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager') )
								<div class="col-md-2">
									<label style="visibility:hidden">Submit:</label>
									<input type="hidden" name="submit_max_kw" value="1" />
									<button type="submit" class="btn btn-warning btn-block kw-submit">SAVE</button>
								</div>
								@endif
							</div>
						</form>
						
						@if($client->coins_free=='0')
						<form class="form-horizontal" id="max_kw_form" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
							{{csrf_field()}}
							<div class="form-group">
								<div class="col-md-3">
									<label>₹ 0 : 555 Coins:</label>
									<input type="hidden" class="form-control" name="amt" value="555" />
								</div>
								@if($request->user()->current_user_can('administrator') || $request->user()->current_user_can('manager') )
								<div class="col-md-4">
									<label style="visibility:hidden">Submit:</label>
									<input type="hidden" name="submit_free_amt" value="1" />
									<button type="submit" class="btn btn-info btn-block kw-submit">Buy Package</button>
								</div>
								@endif
							</div>
						</form>
						
@endif

						
					</div>


               

                 
								


			 
        </div>
    </div>
    
	
	
	
	
	<div class="section-content" id="leads">
        <div class="form-container">
            <h4>View All Leads</h4>
           <div class="table-responsive col-md-12">
					<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-view-all-leads">
						<thead>
							<tr>
								<th>Name</th>
								<th>Mobile</th>
								<th>Email</th>										 
								<th>Course</th>
								<th>City</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Name</th>
								<th>Mobile</th>
								<th>Email</th>										 
								<th>Course</th>
								<th>City</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</tfoot>
					</table>
				</div>
				<form class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
					{{csrf_field()}}
					<div class="form-group">
						@if(Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('export_assign_lead') )
						<div class="col-md-3">
							<label style="visibility:hidden">Submit:</label>
							<input type="submit" class="btn btn-success btn-block" name="lead-export" value="Export">
						</div>
						@endif
					</div>
				</form>
        </div>
    </div>
    <div class="section-content" id="discussion">
        <div class="form-container">
            <h4>Client Discussion</h4>
			 
            
        </div>
    </div>
    <div class="section-content" id="payment">
        <div class="form-container">
            <h4>Payment Order</h4>
			<div>
					<!-- <form id="submitPackageStatus" class="form-horizontal" enctype="multipart/form-data" action="{{ url('developer/clients/update')."/".$client->username }}" method="POST">
						{{csrf_field()}}
						
						<div class="form-group">
						
							<div class="col-md-2">	
							<label>Package:-</label>
							</div>
							<div class="col-md-2">
								<label>Gold: Six Months</label>
								<input type="radio" style="height:14px;width:14px;" class="package_status" name="package_status" value="Gold" <?php echo (isset($client->client_type) && $client->client_type=='Gold')?"checked":""; ?> />
							</div> 
							<div class="col-md-2">
								<label>Diamond:</label>
								<input type="radio" style="height:14px;width:14px;" class="package_status" name="package_status" value="Diamond" <?php echo (isset($client->client_type) && $client->client_type=='Diamond')?"checked":""; ?> />
							</div>
							<div class="col-md-2">
								<label>Platinum:</label>
								<input type="radio" style="height:14px;width:14px;" class="package_status" name="package_status" value="Platinum" <?php echo (isset($client->client_type) && $client->client_type=='Platinum')?"checked":""; ?> />
							</div>
							<div class="col-md-1">
								<label style="visibility:hidden">Submit:</label>
								<input type="hidden" name="submit_packege_status" value="1" />
							</div>
						</div>
					</form> -->
				</div>
			<div>
			<form  class="form-horizontal order_validation" onsubmit="return client.submitClientPayOrder(this)" method="post">
					{{csrf_field()}}
					 
					<input type="hidden" name="client-id" value="<?php echo $client->username; ?>" />
					<div class="form-group">
					<label class="col-sm-2">Business Name<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					
					<div class="col-md-4"> 
						
					<input type="text" name="business_name" class="form-control" value="{{$client->business_name}}" placeholder="Business Name"> 
					</div>
					</div> 								
					
					<div class="form-group">
					<label class="col-sm-2">Package Name <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					
					<div class="col-md-6"> 								 
					<input type="text" name="package_name" class="form-control" value="{{ old('client_type',(isset($client)) ? $client->client_type:"")}}" placeholder="Package Name" readonly> 
					</div>
					</div>				 
					<div class="form-group">
					<label class="col-sm-2">Paid Amount<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					
					<div class="col-md-6"> 							 
					<input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Paid Amount" onkeypress="return isNumericKeyCheck(event);" onblur="handlingPaiAmt()"> 
					</div>
					</div> 
					
					<div class="form-group">
					<label class="col-sm-2">Coins <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					<div class="col-md-6">
					<label>Coins:</label>
					<input type="text" min=0 step=1 class="form-control" name="coins_amt" id="coins_per_lead" value="" onkeypress="return isNumericKeyCheck(event);" readonly/>
					</div>
					
					
					
					</div>
								
					<div class="form-group">
					<label class="col-sm-2">GST <sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					<div class="col-md-6"> 	
					<label class="radio-inline">
					<input type="radio" name="gst_status" value="Yes" onchange="paidgst(this.value)">Yes
					</label>
					<label class="radio-inline">
					<input type="radio" name="gst_status" value="No" onchange="nopaidgst(this.value)">No
					</label>

					</div>	
					</div>	
					<div class="form-group">
					<label class="col-sm-2">GST Amount</label>
					
					<div class="col-md-6"> 
						
					<input type="number" name="gst_tax" id="gst_tax" class="form-control" placeholder="GST Amount"> 
					</div>
					</div> 
					
					<div class="form-group">
					<label class="col-sm-2">GST Total Amount<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					
					<div class="col-md-6"> 
						
					<input type="number" name="gst_total_amount" id="gst_total_amount" class="form-control" placeholder="GST Total Amount" > 
					</div>
					</div> 


					<div class="form-group">
					<label class="col-sm-2">TDS<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
					<div class="col-md-6"> 	
					<label class="radio-inline">
					<input type="radio" name="tds_status" value="Yes" onchange="paidtds(this.value)" >Yes
					</label>
					<label class="radio-inline">
					<input type="radio" name="tds_status" value="No" onchange="nopaidtds(this.value)" >No
					</label>

					</div>	
					</div>	
					<div class="form-group">
					<label class="col-sm-2">TDS Amount</label>
					
					<div class="col-md-6"> 
						
					<input type="number" name="tds_amount" id="tds_amount" class="form-control" placeholder="TDS Amount" > 
					</div>
					</div> 
					
					<div class="form-group">
					<label class="col-sm-2">Total Amount<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>						 
					<div class="col-md-6"> 								 
					<input type="number" name="total_amount" id="total_amount" class="form-control" placeholder="Total Amount" > 
					</div>
					</div> 
					 
						
					
					<div class="form-group">
							<label class="col-sm-2" for="stud-payment_mode">Payment Mode<sup><i style="color:red" class="fa fa-asterisk fa-fw" aria-hidden="true"></i></sup></label>
							<div class="col-sm-6">
								<?php
																					
									foreach($moderesults as $moderesult){
										$modes[$moderesult->slug] = $moderesult->mode;
									}
								?>										
								<select class="form-control" id="stud-payment_mode" name="stud-payment_mode" >
									<option value="">Select Payment Mode</option>
									<?php foreach($modes as $key => $value): ?>
										<option value="<?php echo $key; ?>" <?php echo ($key=='cash')?"selected":""; ?>><?php echo $value; ?></option>
									<?php endforeach; ?>
										
								</select>
							</div>
						</div>					
						<?php foreach($modes as $key=>$value): ?>
							<?php if($key!='cash' && $key!='cheque'): ?>
								<div class="form-group hide-mode <?php echo $key; ?>">
									<label class="col-sm-2" for="stud-<?php echo $key; ?>"><?php echo $value; ?></label>
									<div class="col-sm-6">          
										<select class="form-control" id="stud-<?php echo $key; ?>" name="stud-<?php echo $key; ?>">
											<option value="" selected="selected">-- Select <?php echo $value; ?> --</option>
											<?php
											$banks =  App\Models\Banksdetails::where('mode',$key)->get();	
												 
												if( count($banks) > 0 ){
													foreach ($banks as $bank) {
														echo "<option value=\"".$bank->name."\">".$bank->name."</option>";
													}
												}
											?>
										</select>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
						<div class="form-group hide-mode cheque">
							<label class="col-sm-2" for="stud-chq_no">Cheque Number</label>
							<div class="col-sm-6">          
								<input type="text" class="form-control" id="stud-chq_no" name="stud-chq_no" placeholder="Enter Cheque Number">
							</div>
						</div>	
						
						<div class="form-group hide-mode bank">
							<label class="col-sm-2" for="stud-card_no">Card Number</label>
							<div class="col-sm-6">          
								<input type="text" class="form-control" maxlength="4" id="
								
								" name="stud-card_no" placeholder="Enter Last 4 Digit of Card Number">
							</div>
						</div>	
						
					 
					
					<div class="form-group">
					<label class="col-sm-2">Transaction-Id:</label>							 
					<div class="col-md-6"> 								 
					<input type="text" name="transactionid" class="form-control" placeholder="Enter Transaction-Id"> 
					
					</div>
					</div>	
					
					<div class="form-group">
					<label class="col-sm-2">Select ID Proof:</label>							 
					<div class="col-md-6"> 								 
					<select class="form-control" name="selectproofid"> 
					<option value="">Select ID Proof</option>
					<option value="Pan Card">Pan Card</option>
					<option value="Adhar Card">Adhar Card</option>
					<option value="Passport">Passport</option>
					<option value="Driver Licence">Driver Licence</option>
					</select>
					
					</div>
					</div>
					
					<div class="form-group">
					<label class="col-sm-2">ID Proof:</label>							 
					<div class="col-md-6"> 								 
					<input type="text" name="proofid" class="form-control" placeholder="Enter ID proof"> 
					
					</div>
					</div>
					<br>
					<div class="form-group">
						<div class="col-md-4 col-md-offset-2">
							<input type="hidden" name="pay-submit" value="savepay">
						<input type="hidden" class="resetData" >
							<input type="submit" class="btn btn-warning btn-block payOrder" value="Payment"> 
						</div>
						</div>
					
				</form>
				</div>
				<div class="table-responsive col-md-12">
						<table width="100%" class="table table-striped table-bordered table-hover" id="datatable-payment-history">
							<caption>Payment History</caption>
							<thead>
								<tr>
									<th>Date</th>
									<th>Paid Amount</th>
									<th>GST</th>
									<th>Total Amount</th>
									<th>Pay Mode</th>
									<th>Order PDF</th>
									<th>Proforma Invoice</th>
									<th>Invoice PDF</th>
									<th>Action</th>
								</tr>
							</thead>
							
							<tbody>
							
							</tbody>
								
						</table>
				</div>
								
								
								
								
								<!-- Modal -->
		 
								<script>
				 
		function paidgst(gst){			
			 
			var paid = parseInt($('#paid_amount').val());		
			//var tot = parseInt(((paid)*(.18)));			 
			 var tot = Math. round(((paid)*(.18)));			 
			 var gstamount = $('#gst_tax').val(tot);			 
			 var tatol= parseInt(paid + tot);			 
			 var tobe = $('#gst_total_amount').val(tatol);	 
			 
		}
		
		function nopaidgst(gstno){
			var paid = parseInt($('#paid_amount').val());		
			 var tot = parseInt(0);			 
			 var gstamount = $('#gst_tax').val(tot);			 
			 var tatol= paid + tot;			 
			 var tobe = $('#gst_total_amount').val(tatol);				   
		}
		
		function paidtds(tds){			
			 
			var tdspaid = parseInt($('#paid_amount').val());			 		 
			var gst_total_amount = parseInt($('#gst_total_amount').val());			 		 
			 var tottds = Math. round(((tdspaid)*(2))/100);			 
			 var gstamount = $('#tds_amount').val(tottds);			 
			 var tdstatol= parseInt(gst_total_amount - tottds);			 
			 var tdstobe = $('#total_amount').val(tdstatol);	 
			 
		}
		
		function nopaidtds(tdsno){
			var tdspaid = parseInt($('#paid_amount').val());	
			var gst_total_amount = parseInt($('#gst_total_amount').val());				
			 var tottds = parseInt(0);			 
			 var gstamount = $('#tds_amount').val(tottds);			 
			 var tdstatol= gst_total_amount - tottds;			 
			 var tdstobe = $('#total_amount').val(tdstatol);				   
		}
		
		 
		</script>
		
					 
					
        </div>
    </div>
</div>
    <script>
        function showContent(sectionId) {
            // Hide all content sections
            document.querySelectorAll('.section-content').forEach(content => {
                content.classList.remove('active');
            });

            // Remove active class from all sidebar items
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.classList.remove('active');
            });

            // Show the selected content section
            document.getElementById(sectionId).classList.add('active');

            // Highlight the selected sidebar item
            document.querySelector(`.sidebar-item[onclick="showContent('${sectionId}')"]`).classList.add('active');
        }
    </script>
	

	 <script>
 

</script>
<script>
 
	window.onload = function()
	{
		var state 	='<?php echo $client->state_id; ?>';
		var city 	= '<?php echo $client->city_id; ?>';	 
		var zone 	= '<?php echo $client->zone_id; ?>';	 
		select_city(state,city); 
		select_zone(city,zone); 

		var per_state 	='<?php echo $client->personal_state_id; ?>';
		var per_city 	= '<?php echo $client->personal_city_id; ?>';	 
		var per_zone 	= '<?php echo $client->personal_zone_id; ?>';	 
		per_select_city(per_state,per_city); 
		per_select_zone(per_city,per_zone); 

	}	 

function select_city(state,city){
	  
	var token = $('input[name=_token]').val(); 
	$.ajax({
	type: "POST",	 
	url: "{{URl('developer/city/getAjaxCity')}}",
	data: {sid:state,cid:city},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{
		$(".select_cityList").html(data);
	}
	});
}

function select_zone(city,zone){
	var token = $('input[name=_token]').val();
	$.ajax({
	type: "POST",	 
	url: "{{URl('developer/zone/getAjaxZone')}}",
	data: {city:city,zone:zone},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{
		$(".select_zoneList").html(data);
	}
	});
}


	 
function per_select_city(per_state,per_city){
	 
	var token = $('input[name=_token]').val(); 
	$.ajax({
	type: "POST",	 
	url: "{{URl('developer/city/getAjaxCity')}}",
	data: {sid:per_state,cid:per_city},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{
		$(".show_cityList").html(data);
	}
	});
}

function per_select_zone(per_city,per_zone){

	var token = $('input[name=_token]').val();
	$.ajax({
	type: "POST",	 
	url: "{{URl('developer/zone/getAjaxZone')}}",
	data: {city:per_city,zone:per_zone},
	headers: {'X-CSRF-TOKEN': token},		
	cache: false,
	success: function(data)
	{
		$(".show_zoneList").html(data);
	}
	});
}

 
</script>

	<div id="deleteClient" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			</div>
		</div>
	</div>
</div>
 

  <script type="text/javascript" src="{{asset('drag_drop/jquery-3.1.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('drag_drop/jquery.ezdz.min.js')}}"></script>
  <script>


    $('input[type="file"]').ezdz({
      text: 'Drag & Drop Image',
      validators: {
        maxWidth: 6000,
        maxHeight: 6000
      },
      reject: function (file, errors) {

        if (errors.mimeType) {
          alert(file.name + ' must be an image.');
        }
        if (errors.maxWidth) {
          alert('Max width exceeded is greater than 6000');
        }
        if (errors.maxHeight) {
          alert('Max height exceeded is greater than 6000');
        }
      }
    });

    // });

  </script>



  <script>
    let autoSaveTimer = null;

    const form = document.getElementById('certificateForm');

    form.addEventListener('change', function () {
      clearTimeout(autoSaveTimer);

      autoSaveTimer = setTimeout(() => {
        autoSaveForm();
      }, 800); // debounce
    });
   
    function autoSaveForm() {
	const clientId = "{{ isset($client->id) ? $client->id : '' }}"; 
    const formData = new FormData(form);     
	mainSpinner.start();      
		fetch("{{ url('developer/clients/save-certificate-auto') }}/" + clientId, {
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
      })
        .then(async (res) => {
          console.log(res);
          if (!res.ok) {         
            const errorData = await res.json();
            throw errorData;
          }
          return res.json();
        })
        .then(data => {
          console.log(data.status)
          if (data.status) {

            console.log('Auto-saved ✔');
            // hideLoader();
			mainSpinner.stop();
            if (!form.dataset.saved) {
              form.dataset.saved = "true";
              setTimeout(() => {
                // form.reset();              
                // form.dataset.saved = "";    
              }, 500);
            }


            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Successfully");
            $('#messaged .modal-body').html("<div class='alert alert-success'>" + data.msg + "</div>");
            $('#messaged').modal({ keyboard: false, backdrop: 'static' });
            $('#messaged').css({ 'width': '100%' });
            setInterval(function () {
              $("#messaged").modal("hide");
            }, 3000);

          } else {
            // hideLoader();
			mainSpinner.stop();
            console.warn('Auto-save failed');
          }
        })
        .catch((err) => {
			mainSpinner.stop();
        //   hideLoader();
          if (err.errors) {

            let errorHtml = "<div class='alert alert-danger'><ul>";

            Object.keys(err.errors).forEach(function (key) {
              errorHtml += "<li>" + err.errors[key][0] + "</li>";
            });

            errorHtml += "</ul></div>";

            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Validation Error");
            $('#messaged .modal-body').html(errorHtml);

          } else {
            console.error("Unexpected Error:", err);
          }


        });
    }
  </script>

  <script>
 

    const awardFrom = document.getElementById('awardFrom');

    awardFrom.addEventListener('change', function () {
      clearTimeout(autoSaveTimer);

      autoSaveTimer = setTimeout(() => {
        autoSaveForm();
      }, 800); // debounce
    });
   
    function autoSaveForm() {
	const clientId = "{{ isset($client->id) ? $client->id : '' }}"; 
    const formData = new FormData(awardFrom);     
	mainSpinner.start();      
		fetch("{{ url('developer/clients/save-award-auto') }}/" + clientId, {
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
      })
        .then(async (res) => {
          console.log(res);
          if (!res.ok) {         
            const errorData = await res.json();
            throw errorData;
          }
          return res.json();
        })
        .then(data => {
          console.log(data.status)
          if (data.status) {

            console.log('Auto-saved ✔');
            // hideLoader();
			mainSpinner.stop();
            if (!awardFrom.dataset.saved) {
              awardFrom.dataset.saved = "true";
              setTimeout(() => {
                 
              }, 500);
            }


            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Successfully");
            $('#messaged .modal-body').html("<div class='alert alert-success'>" + data.msg + "</div>");
            $('#messaged').modal({ keyboard: false, backdrop: 'static' });
            $('#messaged').css({ 'width': '100%' });
            setInterval(function () {
              $("#messaged").modal("hide");
            }, 3000);

          } else {
            // hideLoader();
			mainSpinner.stop();
            console.warn('Auto-save failed');
          }
        })
        .catch((err) => {
			mainSpinner.stop();
        //   hideLoader();
          if (err.errors) {

            let errorHtml = "<div class='alert alert-danger'><ul>";

            Object.keys(err.errors).forEach(function (key) {
              errorHtml += "<li>" + err.errors[key][0] + "</li>";
            });

            errorHtml += "</ul></div>";

            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Validation Error");
            $('#messaged .modal-body').html(errorHtml);

          } else {
            console.error("Unexpected Error:", err);
          }


        });
    }
  </script>

  <script>
 

    const imageform = document.getElementById('imageform');

    imageform.addEventListener('change', function () {
      clearTimeout(autoSaveTimer);

      autoSaveTimer = setTimeout(() => {
        autoSaveForm();
      }, 800); // debounce
    });
   
    function autoSaveForm() {
	const clientId = "{{ isset($client->id) ? $client->id : '' }}"; 
    const formData = new FormData(imageform);     
	mainSpinner.start();      
		fetch("{{ url('developer/clients/uploadClientGalleryPics') }}/" + clientId, {
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
      })
        .then(async (res) => {
          console.log(res);
          if (!res.ok) {         
            const errorData = await res.json();
            throw errorData;
          }
          return res.json();
        })
        .then(data => {
          console.log(data.status)
          if (data.status) {

            console.log('Auto-saved ✔');
            // hideLoader();
			mainSpinner.stop();
            if (!imageform.dataset.saved) {
              imageform.dataset.saved = "true";
              setTimeout(() => {
                 
              }, 500);
            }


            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Successfully");
            $('#messaged .modal-body').html("<div class='alert alert-success'>" + data.msg + "</div>");
            $('#messaged').modal({ keyboard: false, backdrop: 'static' });
            $('#messaged').css({ 'width': '100%' });
            setInterval(function () {
              $("#messaged").modal("hide");
            }, 3000);

          } else {
            // hideLoader();
			mainSpinner.stop();
            console.warn('Auto-save failed');
          }
        })
        .catch((err) => {
			mainSpinner.stop();
        //   hideLoader();
          if (err.errors) {

            let errorHtml = "<div class='alert alert-danger'><ul>";

            Object.keys(err.errors).forEach(function (key) {
              errorHtml += "<li>" + err.errors[key][0] + "</li>";
            });

            errorHtml += "</ul></div>";

            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Validation Error");
            $('#messaged .modal-body').html(errorHtml);

          } else {
            console.error("Unexpected Error:", err);
          }


        });
    }
  </script>

  <script>
 

    const profileLogo = document.getElementById('profileLogo');

    profileLogo.addEventListener('change', function () {
      clearTimeout(autoSaveTimer);

      autoSaveTimer = setTimeout(() => {
        autoSaveForm();
      }, 800); // debounce
    });
   
    function autoSaveForm() {
	const clientId = "{{ isset($client->id) ? $client->id : '' }}"; 
    const formData = new FormData(profileLogo);     
	mainSpinner.start();      
		fetch("{{ url('developer/clients/editSaveClientProfileLogo') }}/" + clientId, {
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
      })
        .then(async (res) => {
          console.log(res);
          if (!res.ok) {         
            const errorData = await res.json();
            throw errorData;
          }
          return res.json();
        })
        .then(data => {
          
          if (data.status) {

            console.log('Auto-saved ✔');
            // hideLoader();
			mainSpinner.stop();
            if (!profileLogo.dataset.saved) {
              profileLogo.dataset.saved = "true";
              setTimeout(() => {
                 
              }, 500);
            }


            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Successfully");
            $('#messaged .modal-body').html("<div class='alert alert-success'>" + data.msg + "</div>");
            $('#messaged').modal({ keyboard: false, backdrop: 'static' });
            $('#messaged').css({ 'width': '100%' });
            setInterval(function () {
              $("#messaged").modal("hide");
            }, 3000);

          } else {
            // hideLoader();
			mainSpinner.stop();
            console.warn('Auto-save failed');
          }
        })
        .catch((err) => {
			mainSpinner.stop();
        //   hideLoader();
          if (err.errors) {

            let errorHtml = "<div class='alert alert-danger'><ul>";

            Object.keys(err.errors).forEach(function (key) {
              errorHtml += "<li>" + err.errors[key][0] + "</li>";
            });

            errorHtml += "</ul></div>";

            $("#messaged").modal("show");
            $('#messaged .modal-title').text("Validation Error");
            $('#messaged .modal-body').html(errorHtml);

          } else {
            console.error("Unexpected Error:", err);
          }


        });
    }


	window.addEventListener("load", function(){
    if(window.location.hash){
        let section = window.location.hash.substring(1);		 
        showContent(section);
    }
});
  </script>

<?php echo View::make('admin/footer'); ?>
