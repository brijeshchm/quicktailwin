@extends('business.layouts.app')
@section('title')
  Quick Dials | Students
@endsection
@section('keyword')
  Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near
  You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance
  Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find
  Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education
  consultants Near you, Find Top 10 overseas education consultants Near you

@endsection
@section('description')
  Find Only Certified Training Institutes, Coaching Centers near you on Estivaledge and Get Free counseling, Free Demo
  Classes, and Get Placement Assistence.
@endsection
@section('content')


  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Lead Follow</h1>
    </div>
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <!-- Table with stripped rows -->


              <div class="row">

                <div id="leads_filter" class="col-md-12"
                  style="border-bottom:2px solid #E6E9ED;margin-bottom:10px;padding-bottom:10px;">
                  <form method="GET" action="" novalidate autocomplete="off" class="row g-3">

                    <div class="col-md-3">
                      <label for="Date From" class="form-label">Follow Up Date From </label>
                      <input type="text" class="form-control leaddf"
                        value="{{ old('search[expdf]', (isset($search['expdf'])) ? $search['expdf'] : "")}}"
                        name="search[expdf]" placeholder="Create Date From">
                    </div>
                    <div class="col-md-3">
                      <label for="validationDefault02" class="form-label">Follow Up Date To</label>
                      <input type="text" class="form-control leaddt"
                        value="{{ old('search[expdt]', (isset($search['expdt'])) ? $search['expdt'] : "")}}"
                        name="search[expdt]" placeholder="Create Date To">
                    </div>

                    <div class="col-md-3">
                      <label for="validationDefault02" class="form-label">Service</label>
                      <select class="form-control select2-keyword" name="search[service][]" multiple>

                        <option value="">Select Service</option>

                        @if(!empty($services))
                          @if(isset($search['service']))
                            @foreach($search['service'] as $value)
                              {{ $courseSelected[] = $value }}
                            @endforeach
                          @endif
                          @foreach($services as $service)
                            @if(isset($courseSelected) && in_array($service->id, $courseSelected))
                              <option value="{{ $service->id }}" selected>{{ $service->keyword }}</option>
                            @else
                              <option value="{{ $service->id }}">{{ $service->keyword }}</option>
                            @endif
                          @endforeach
                        @endif

                      </select>
                    </div>

                    <div class="col-md-3">
                      <label for="validationDefault02" class="form-label">Status</label>
                      <select class="form-control select2-status" name="search[status][]" multiple> @if(!empty($statues))
                        @if(isset($search['status']))
                          @foreach($search['status'] as $value)
                            {{ $statusSelected[] = $value }}
                          @endforeach
                        @endif
                        @foreach($statues as $status)
                          @if(isset($statusSelected) && in_array($status->id, $statusSelected))
                            <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                          @else
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                          @endif
                        @endforeach
                      @endif

                      </select>
                      <button type="submit" class="form-control btn btn-block btn-info"
                        style="margin-top: 7px;background:#0d6efd;color:#fff">Filter</button>
                    </div>

                    <!-- <div class="col-md-3">
                              <label for="filter" class="form-label"></label>
                               <button type="submit" class="form-control btn btn-block btn-info" style="margin-top: 7px;">Filter</button>
                              </div> -->




                  </form>
                </div>
                <table width="100%" class="table table-striped table-bordered table-hover" id="datatable-lead-dashboard">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>
                        <b>N</b>ame
                      </th>
                      <th>Mobile</th>
                     
                      <th>Service</th>
                      <th>City</th>
                      <th>Status</th>
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


@endsection