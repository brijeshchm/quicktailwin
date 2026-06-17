@extends('business.layouts.app')
@section('title')
Bisiness FAQs | Location
@endsection 
@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You, Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance Education Centre Near You, Find Top 10 Distance Education Centre Near You, Find Best School And Colleges Near You, Find Top 10 school And College Near You, Get Education Loan, GET Free career Counselling, Find Best overseas education consultants Near you, Find Top 10 overseas education consultants Near you

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

#autoSaveStatus {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    z-index: 9999;
    transition: opacity 0.3s;
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
               
            <form class="buss_location" id="faqForm" method="POST" 
    onsubmit="return businessController.saveBusinessFaqs(this,<?php echo (isset($client->id)? $client->id:""); ?>)">
    
    <input type="hidden" name="client_id" value="{{$client->id}}"> 

    {{-- Status indicator --}}
    <div id="autoSaveStatus" class="text-sm text-muted mb-3" style="display:none;">
        <i class="fa fa-check-circle text-success"></i> <span id="autoSaveText">Saved</span>
    </div>

    @for($i = 1; $i <= 10; $i++)
    <div class="form-group">
        <label class="col-md-2 control-label">FAQ Question {{ $i }}</label>
        <div class="col-md-8">
            <input class="form-control faq-auto-save" 
                name="faqq{{ $i }}" 
                placeholder="Enter FAQ Question {{ $i }}" 
                value="{{ old('faqq'.$i, isset($client) ? $client->{'faqq'.$i} : '') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2 control-label">FAQ Answer {{ $i }}</label>
        <div class="col-md-8">
            <textarea class="form-control faq-auto-save" 
                name="faqa{{ $i }}" 
                placeholder="Enter FAQ Answer {{ $i }}">{{ old('faqa'.$i, isset($client) ? $client->{'faqa'.$i} : '') }}</textarea>
        </div>
    </div>
    @endfor

    <div class="text-center"> 
        <input type="hidden" name="savePersonal" value="savePersonalForm">
        <!-- <button type="submit" class="btn btn-primary">Save & Continue</button> -->
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
const businessController = {

    saveBusinessFaqs: function(form, clientId) {
        var formData = new FormData(form);
        $.ajax({
            url: '/business/saveBusinessFaqs/' + clientId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest' // important — triggers $request->ajax()
            },
            success: function(response) {
                showAutoSaveStatus('✅ Saved', 'success');
            },
            error: function(xhr) {
                showAutoSaveStatus('❌ Error saving', 'danger');
                console.error(xhr.responseJSON);
            }
        });
        return false; // prevent normal form submit when called manually
    }
};

// ═══════════════════════════════════════════
// AUTO-SAVE LOGIC — Triggers on blur/change
// ═══════════════════════════════════════════
(function () {
    var form        = document.getElementById('faqForm');
    var clientId    = "<?php echo (isset($client->id) ? $client->id : ''); ?>";
    var debounceTimer = null;

    if (!form) return;

    var fields = form.querySelectorAll('.faq-auto-save');

    fields.forEach(function (field) {

        // ── Trigger on blur (when user leaves field) ──
        field.addEventListener('blur', function () {
            autoSaveTrigger(form, clientId);
        });

        // ── Trigger on change with debounce (while typing pause) ──
        field.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                autoSaveTrigger(form, clientId);
            }, 1500); // wait 1.5s after typing stops
        });
    });

})();

// ── Actual AJAX auto-save function ──
function autoSaveTrigger(form, clientId) {
    if (!clientId) return;

    showAutoSaveStatus('Saving...', 'warning');

    var formData = new FormData(form);

    $.ajax({
        url: '/business/saveBusinessFaqs/' + clientId,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function (response) {
            if (response.status) {
                showAutoSaveStatus('✅ Saved automatically', 'success');
            } else {
                showAutoSaveStatus('❌ ' + (response.msg || 'Save failed'), 'danger');
            }
        },
        error: function (xhr) {
            console.error('Auto-save error:', xhr.responseJSON);
            showAutoSaveStatus('❌ Error saving', 'danger');
        }
    });
}

// ── Show status message ──
function showAutoSaveStatus(text, type) {
    var statusEl = document.getElementById('autoSaveStatus');
    var textEl   = document.getElementById('autoSaveText');

    if (!statusEl || !textEl) return;

    textEl.textContent  = text;
    statusEl.style.display = 'block';

    statusEl.className = 'text-sm mb-3';
    if (type === 'success') statusEl.classList.add('text-success');
    if (type === 'danger')  statusEl.classList.add('text-danger');
    if (type === 'warning') statusEl.classList.add('text-warning');

    // Auto-hide after 3 seconds (except while saving)
    if (type !== 'warning') {
        setTimeout(function () {
            statusEl.style.display = 'none';
        }, 3000);
    }
}
</script>
 
 
 
	
 @endsection