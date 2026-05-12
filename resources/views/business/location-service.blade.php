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

  <main id="main" class="main">
    <section class="section profile">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Location Information</button>
                </li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                  <!-- Profile Edit Form -->
                     <form class="profileSave" method="POST">
                        <input type="hidden" name="business_id" value="{{$client->id}}">
                      
                   <!-- #endregion -->
 
                 
                <div class="form-group">
                    <label>City:</label>
                    <select class="form-control">
                        <option>Ms</option>
                        <option>Mr</option>
                        <option>Mrs</option>
                    </select>
                    <label>Zone:</label>
                     <select class="form-control">
                        <option>Single</option>
                        <option>Married</option>
                    </select>
                </div>
                
                
                
            <div class="text-center"> 
                 <input type="hidden" name="savePersonal" value="savePersonalForm">
                <button type="submit" class="btn btn-primary">Save & Continue</button>
        
              </div>
 

                  
                  </form><!-- End Profile Edit Form -->

                </div>
	<div class="row"> 
      <table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="datatable-assigned-zones" role="grid" aria-describedby="datatable-assigned-zones_info" style="width: 100%;">
					<thead>
					<tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="datatable-assigned-zones" rowspan="1" colspan="1" style="width: 152.333px;" aria-sort="ascending" aria-label="Zone: activate to sort column descending">Zone</th><th class="sorting" tabindex="0" aria-controls="datatable-assigned-zones" rowspan="1" colspan="1" style="width: 147.333px;" aria-label="City: activate to sort column ascending">City</th><th class="sorting" tabindex="0" aria-controls="datatable-assigned-zones" rowspan="1" colspan="1" style="width: 152px;" aria-label="Action: activate to sort column ascending">Action</th></tr>
					</thead>
					<tbody>
            
          <tr role="row" class="odd"><td class="sorting_1">Jaipur</td><td>Jaipur</td><td><a href="javascript:void(0)" onclick="assignedAreaController.editZoneClient(508)" title="Zone Edit"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>  
        
        </td></tr>
          
          <tr role="row" class="even"><td class="sorting_1">Allahabad</td><td>Allahabad</td><td><a href="javascript:void(0)" onclick="assignedAreaController.editZoneClient(395)" title="Zone Edit"><i class="bi bi-pencil-square" aria-hidden="true"></i></a> 
        
        
        </td></tr>
          
          <tr role="row" class="odd"><td class="sorting_1">Anakapalle</td><td>Anakapalle</td><td><a href="javascript:void(0)" onclick="assignedAreaController.editZoneClient(383)" title="Zone Edit"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>
        
        
        </td></tr>
          
          <tr role="row" class="even"><td class="sorting_1">Ghaziabad</td><td>Ghaziabad</td><td><a href="javascript:void(0)" onclick="assignedAreaController.editZoneClient(291)" title="Zone Edit"><i class="fa fa-refresh" aria-hidden="true"></i></a> | <a href="javascript:assignedZoneController.delete(291)"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>
          
          <tr role="row" class="odd"><td class="sorting_1">Faridabad</td><td>Faridabad</td><td><a href="javascript:void(0)" onclick="assignedAreaController.editZoneClient(278)" title="Zone Edit"><i class="fa fa-refresh" aria-hidden="true"></i></a> | <a href="javascript:assignedZoneController.delete(278)"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>
          
          <tr role="row" class="even"><td class="sorting_1">Saket Delhi</td><td>Delhi</td><td><a href="javascript:void(0)" onclick="assignedAreaController.editZoneClient(271)" title="Zone Edit"><i class="bi bi-edit" aria-hidden="true"></i></a> </td></tr>
        
        
        </tbody>
      
      </table>
                
              </div> 
              </div> 

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

 @endsection