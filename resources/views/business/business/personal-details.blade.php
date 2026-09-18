@extends('business.business.layouts.app')
@section('title','Profile')
@section('content')
 


<div class="animate-fade-in max-w-5xl space-y-4 md:space-y-6"><div><h1 class="font-display text-xl font-bold md:text-3xl">

{{ $tabs[$tab] }}
</h1>


</div>

<div> 
 
<div id="autoSaveStatus"> </div>

</div>
 <div class="md:hidden">
    
 <select onchange="window.location=this.value" class="form-input h-12 bg-white text-base font-medium shadow-sm">
    
 @foreach($tabs as $key=>$label)
    
 <option value="{{ route('profile',['tab'=>$key]) }}" @selected($tab===$key)>{{ $label }}</option>@endforeach

</select>

</div>
 

 @if($tab==='personal')


 <form id="personalDetailsForm" action="{{ route('business.profile.update') }}" method="POST" class="card space-y-6 p-6">
    
 @csrf 
 
 <input type="hidden" name="redirect_tab" value="personal">
  <div class="grid gap-6 md:grid-cols-3">
    
       
        
        <div class="space-y-2">
            
        <label class="text-sm font-medium">First Name*</label>
               
        <input type="text" class="form-input auto-save-field" value="{{ old('first_name', (isset($client)) ? $client->first_name : "")}}" name="first_name" placeholder="Enter First Name">    
        </div>


        <div class="space-y-2">
            
        <label class="text-sm font-medium">Middle Name:*</label>
        
           <input type="text" class="form-input auto-save-field" name="middle_name" value="{{ old('middle_name', (isset($client)) ? $client->middle_name : "")}}" placeholder="Enter Middle Name">
    
        </div>
        <div class="space-y-2">
            
        <label class="text-sm font-medium">Last Name:*</label>
        
        <input type="text" class="form-input auto-save-field" name="last_name" value="{{ old('last_name', (isset($client)) ? $client->last_name : "")}}" placeholder="Enter Last Name">
    
        </div>




    
    
    </div>
  


  <div class="border-t pt-6">
    
  
   
  <div class="grid gap-4 md:grid-cols-3">
    
  <div>
    <label class="mb-2 block text-sm font-medium">Personal Email</label>  
  <input name="personal_email" value="{{ $client->personal_email }}" class="form-input auto-save-field" paceholder="Enter personal email">
 </div>
   
  <div><label class="mb-2 block text-sm font-medium">Personal phone</label><input name="personal_phone" value="{{ $client->personal_phone }}" class="form-input auto-save-field" placeholder="Enter personal phone"></div>
  


   <div>
            <label class="mb-2 block text-sm font-medium">State</label>
            <select id="state" name="personal_state" class="form-input w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary">
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ $client->personal_state_id == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>
        </div>

    <div class="show_cityList">
            <label class="mb-2 block text-sm font-medium">City</label>
            <select id="city" name="personal_city" class="form-input auto-save-field w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary">
                <option value="">Select City</option>
            </select>
        </div>

 
  <div><label class="mb-2 block text-sm font-medium">Personal Area</label><input type="text" name="personal_area" value="{{ $client->personal_area }}" class="form-input auto-save-field" placeholder="Enter personal area"></div>
  <div><label class="mb-2 block text-sm font-medium">Personal Pincode</label><input type="text" name="personal_pincode" value="{{ $client->personal_pincode }}" class="form-input auto-save-field" placeholder="Enter personal pincode"></div>

  <div><label class="mb-2 block text-sm font-medium">Address</label><input type="text" name="personal_address" value="{{ $client->personal_address }}" class="form-input auto-save-field" placeholder="Enter Address"></div>




 </div>


</div>
 



  <div class="sticky bottom-24 flex justify-end border-t bg-white/90 pt-5 backdrop-blur md:bottom-4"><button class="btn btn-primary"><i data-lucide="save" class="h-4 w-4"></i>Save Profile</button></div>
 </form>
 
 @endif
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
window.onload = function () {
    var state = "{{ $client->personal_state_id }}";
    var city  = "{{ $client->personal_city_id }}";
    var zone  = "{{ $client->zone_id }}";

    getCity(state, city);
};

var clientId = {{ isset($client->id) ? $client->id : 'null' }};

function getCity(state, city) {
    var token = $('input[name=_token]').val();
    $.ajax({
        type: "POST",
        url: "{{ route('business.cities.ajax') }}",
        data: { sid: state, cid: city },
        headers: { 'X-CSRF-TOKEN': token },
        cache: false,
        success: function (data) {
            $('#city').html(data);
            bindSelectAutoSave($('#city')[0]);
            //if (typeof callback === 'function') callback();
        }
    });
}

 

// Re-fire chain when State changes manually
$(document).on('change', '#state', function () {
    getCity($(this).val(), '');
});

// Re-fire Zone chain when City changes manually
// $(document).on('change', '#city', function () {
//     selectZone($(this).val(), '');
// });

function bindSelectAutoSave(selectEl) {
    if (!selectEl) return;
    selectEl.addEventListener('change', function () {
        setTimeout(triggerAutoSave, 400);
    });
}

// ═══════════════════════════════════════════
// AUTO-SAVE — Profile Info Form
// ═══════════════════════════════════════════
(function () {
    var form         = document.getElementById('personalDetailsForm');
    var debounceTimer = null;
    var isSaving      = false;
    var lastSnapshot;

    if (!form) return;
    lastSnapshot = $(form).serialize();

    form.querySelectorAll('.auto-save-field').forEach(function (field) {
        if (field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') {
            field.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(triggerAutoSave, 1500);
            });
            field.addEventListener('blur', function () {
                clearTimeout(debounceTimer);
                triggerAutoSave();
            });
        }
        if (field.tagName === 'SELECT') {
            field.addEventListener('change', function () {
                setTimeout(triggerAutoSave, 600);
            });
        }
    });

    // Manual "Save Profile" button submit
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearTimeout(debounceTimer);
        saveForm(true);
    });

    window.triggerAutoSave = function () {
        saveForm(false);
    };

    function saveForm(isManual) {
        var current = $(form).serialize();
        if (!isManual && current === lastSnapshot) return; // nothing changed
        if (isSaving) return;

        isSaving = true;
        showAutoSaveStatus('Saving...', 'info');

        var token = $('input[name=_token]').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('business.profile.update') }}",
            data: current + '&client_id=' + clientId,
            headers: { 'X-CSRF-TOKEN': token },
            cache: false,
            success: function () {
                isSaving = false;
                lastSnapshot = current;
                showAutoSaveStatus(isManual ? 'Profile saved successfully' : 'Saved', 'success');
            },

            error: function (jqXHR, textStatus, errorThrown) {
					var response = JSON.parse(jqXHR.responseText);

					showAutoSaveStatus('❌ Validation error', 'danger');

					if (response.errors) {
						var errors = response.errors;
						$('#personalDetailsForm').find('.form-input').removeClass('has-error');
						$('#personalDetailsForm').find('.help-block').remove();

						for (var key in errors) {
							if (errors.hasOwnProperty(key)) {
								var el = $('#personalDetailsForm').find('*[name="' + key + '"]');
								$('<span class="help-block"><strong>' + errors[key][0] + '</strong></span>').insertAfter(el);
								el.closest('.form-input').addClass('has-error');
							}
						}
					} else {
						alert('Something went wrong');
					}
		} 

        });
    }
})();

function showAutoSaveStatus(text, type) {
    var statusEl = document.getElementById('autoSaveStatus');
    if (!statusEl) return;

    var base = 'mb-4 rounded-md px-3 py-2 text-sm font-medium';
    var typeClasses = {
        success: 'bg-green-100 text-green-800',
        danger:  'bg-red-100 text-red-800',
        info:    'bg-blue-100 text-blue-800'
    };

    statusEl.className = base + ' ' + (typeClasses[type] || typeClasses.info);
    statusEl.textContent = text;
    statusEl.classList.remove('hidden');

    if (type !== 'info') {
        setTimeout(function () {
            statusEl.classList.add('hidden');
        }, 3000);
    }
}

function isNumberKey(e) {
    var a = e.keyCode || e.charCode;
    return !!(a >= 48) && !!(a <= 57);
}
</script>

 

@endsection
