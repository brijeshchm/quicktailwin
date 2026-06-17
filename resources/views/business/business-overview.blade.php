@extends('business.layouts.app')
@section('title')
Business overview | QuickDials
@endsection 
@section('keyword')
Business Overview | QuickDials
@endsection
@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on QuickDials and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
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
               
                 <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                  <form class="buss_location" id="businessOverviewForm" method="POST" 
                      onsubmit="return businessController.saveBusinessOverview(this,<?php echo (isset($client->id)? $client->id:""); ?>)">
                      <input type="hidden" name="client_id" value="{{$client->id}}"> 

                      {{-- Auto-save status --}}
                  

                      <div class="form-group">
                          <label for="city">Business Description:</label>
                          <textarea name="business_description" type="text" class="form-control auto-save-field" placeholder="Please enter business Description">{{ old('business_description',(isset($client)) ? $client->business_description:"")}}</textarea>               
                      </div>

                      <div class="form-group">
                          <label>Business Overview:</label>                    
                          <textarea name="business_overview" type="text" class="form-control summernote auto-save-field" placeholder="Please enter business overview">{{ old('business_overview',(isset($client)) ? $client->business_overview:"")}}</textarea>
                      </div>
                      
                      <div class="text-center"> 
                          <input type="hidden" name="business_overView" value="businessOverView">
                          <button type="submit" class="btn btn-primary">Save & Continue</button>
                      </div>
    <div id="autoSaveStatus" style="display:none;"></div>
                  </form>
              </div>

                </div>
               
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
 
 

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script type="text/javascript">

var businessOverviewDebounce = null;
var clientId = "<?php echo (isset($client->id) ? $client->id : ''); ?>";

// ── Initialize Summernote ──
$('.summernote').summernote({
    height: 500,
    callbacks: {
        // Fires whenever content changes inside the editor
        onChange: function (contents, $editable) {
            clearTimeout(businessOverviewDebounce);
            businessOverviewDebounce = setTimeout(function () {
                triggerBusinessOverviewAutoSave();
            }, 1500); // wait 1.5s after typing stops
        },
        onBlur: function () {
            clearTimeout(businessOverviewDebounce);
            triggerBusinessOverviewAutoSave();
        }
    }
});

// ═══════════════════════════════════════════
// AUTO-SAVE — Business Overview Form
// ═══════════════════════════════════════════
(function () {
    var form = document.getElementById('businessOverviewForm');
    if (!form) return;

    // ── Plain textarea (Business Description) — debounce on input ──
    var plainFields = form.querySelectorAll('.auto-save-field:not(.summernote)');

    plainFields.forEach(function (field) {
        field.addEventListener('input', function () {
            clearTimeout(businessOverviewDebounce);
            businessOverviewDebounce = setTimeout(function () {
                triggerBusinessOverviewAutoSave();
            }, 1500);
        });

        field.addEventListener('blur', function () {
            clearTimeout(businessOverviewDebounce);
            triggerBusinessOverviewAutoSave();
        });
    });
})();

function triggerBusinessOverviewAutoSave() {
    var form = document.getElementById('businessOverviewForm');
    if (typeof businessController !== 'undefined' && businessController.saveBusinessOverview) {
        businessController.saveBusinessOverview(form, clientId);
        showAutoSaveStatus('Saving...', 'info');
    }
}

// ── Status indicator ──
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