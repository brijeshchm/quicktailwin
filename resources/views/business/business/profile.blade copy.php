@extends('business.business.layouts.app')
@section('title','Profile')
@section('content')
@php $tabs=['general'=>'Basic Info','personal'=>'Personal Details','seo'=>'SEO Meta','keywords'=>'Service Keywords','locations'=>'Service Areas','media'=>'Media & Gallery','awards'=>'Awards','certs'=>'Certificates','socials'=>'Social Links'];

 @endphp
<div class="animate-fade-in max-w-5xl space-y-4 md:space-y-6"><div><h1 class="font-display text-xl font-bold md:text-3xl">
{{ $tabs[$tab] }}
 
</h1>


</div>

<div> 
 
<div id="autoSaveStatus"> </div>

</div>
 <div class="md:hidden"><select onchange="window.location=this.value" class="form-input h-12 bg-white text-base font-medium shadow-sm">
    
 @foreach($tabs as $key=>$label)
    
 <option value="{{ route('profile',['tab'=>$key]) }}" @selected($tab===$key)>{{ $label }}</option>@endforeach</select>

</div>
 @if($tab==='general')


 <form id="profileInfoForm" method="POST" class="card space-y-6 p-6" 
    action="{{ route('business.profile.update') }}"  >
    
 @csrf   
 
 <input type="hidden" name="redirect_tab" value="general">
 <input type="hidden" name="client_id" value="{{ (isset($client->id)? $client->id:"") }}">
  <div class="grid gap-4 md:grid-cols-3">
    
        <div class="space-y-2">
        
            <label class="text-sm font-medium">Business Name</label>
            
            <input name="business_name" value="{{ $client->business_name }}" class="form-input auto-save-field">    
        </div>
      <div class="space-y-2">
            
        <label class="text-sm font-medium">Mobile</label>
        
        <input type="tel" name="mobile" value="{{ $client->mobile }}" class="form-input auto-save-field" placeholder="Enter mobile"  onkeypress="return isNumberKey(event);" maxlength="16">
    
        </div>
      
      <div class="space-y-2">
        
            <label class="text-sm font-medium">Email Address (Login)</label>
            
            <input name="email" value="{{ $client->email }}" class="form-input auto-save-field" placeholder="Enter email">    
        </div>
        
        
    
  <div><label class="mb-2 block text-sm font-medium">Second Mobile</label>
  
  <input type="tel" name="second_mobile" value="{{ $client->second_mobile }}" class="form-input auto-save-field" placeholder="Enter Second Mobile" onkeypress="return isNumberKey(event);" maxlength="16"></div>
  

  
    
  <div><label class="mb-2 block text-sm font-medium">WhatsApp No:</label>
  
  <input type="tel" name="whatsapp" value="{{ $client->whatsapp }}" class="form-input auto-save-field" placeholder="Enter WhatsApp No" onkeypress="return isNumberKey(event);" maxlength="16"></div>
  
    
  <div><label class="mb-2 block text-sm font-medium">Second WhatsApp No:</label>
  
  <input type="tel" name="second_whatsapp" value="{{ $client->second_whatsapp }}" class="form-input auto-save-field" placeholder="Second WhatsApp No" onkeypress="return isNumberKey(event);" maxlength="16"></div>
  
    
    </div>
  

<div class="border-t pt-6">
    <h3 class="mb-4 font-display text-lg font-semibold">Location Details</h3>

    <div class="grid gap-4 md:grid-cols-3">

        <div>
            <label class="mb-2 block text-sm font-medium">State</label>
            <select id="state" name="state" class="form-input auto-save-field w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary">
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ $client->state_id == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="show_cityList">
            <label class="mb-2 block text-sm font-medium">City</label>
            <select id="city" name="city" class="form-input auto-save-field w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary">
                <option value="">Select City</option>
            </select>
        </div>

        <div class="select_zoneList">
            <label class="mb-2 block text-sm font-medium">Zone</label>
            <select id="zone" name="zone" class="form-input auto-save-field w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary">
                <option value="">Select Zone</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium">Area</label>
            <input type="text" name="area" value="{{ $client->area }}" class="form-input auto-save-field w-full rounded-md border-gray-300">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium">Pincode</label>
            <input type="text" name="pincode" value="{{ $client->pincode }}" class="form-input auto-save-field w-full rounded-md border-gray-300">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium">Google Map</label>
            <input type="text" name="business_map" value="{{ $client->business_map }}" class="form-input auto-save-field w-full rounded-md border-gray-300" placeholder="Google Map">
        </div>

    </div>
</div>

 
 
  <div class="border-t pt-6"> 
  
  <h3 class="mb-4 font-display text-lg font-semibold">Address & Hours</h3>


 <div class="grid gap-4 md:grid-cols-3">
 
    
<div><label class="mb-2 block text-sm font-medium">Landmark</label><input name="landmark" value="{{ $client->landmark }}" class="form-input auto-save-field"></div>


<div><label class="mb-2 block text-sm font-medium">Full Address</label><input name="address" value="{{ $client->address }}" class="form-input auto-save-field"></div>

 

   
        <div class="space-y-2">
            
        <label class="text-sm font-medium">Year Established</label> 


         <select class="form-input auto-save-field" id="year_of_estb" name="year_of_estb">
            <option value="">Select Year</option>
            <?php for($i= 1970; $i<=2050; $i++){ ?>
            <option value="<?php echo $i; ?>" @if ($i == old('year_of_estb')) selected @else {{ (isset($client) && $client->year_of_estb == $i ) ? "selected":"" }} @endif><?php echo $i; ?></option>
            <?php } ?>
        </select>
    
        </div>
<div><label class="mb-2 block text-sm font-medium">Website</label><input name="website" value="{{ $client->website }}" class="form-input auto-save-field" placeholder="https://"></div>
 
  




</div>


 @php
    $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

    $times = ["24:00" => "Open 24 Hrs", "00:00" => "Closed"];
    for ($h = 0; $h < 24; $h++) {
        foreach (['00', '30'] as $m) {
            $key = sprintf('%02d:%s', $h, $m);
            $times[$key] = $key;
        }
    }

    // FIX: default to object, not array — avoids "read property on array" crash
    $time = !empty($client->time) ? json_decode($client->time) : (object) [];
@endphp

<div class="pt-6">
    <div class="mb-4 flex items-center justify-between">
        <h3 class="font-display text-lg font-semibold">Business Hours</h3>
        
    </div>

    <div class="space-y-3">
        @foreach ($days as $day)
            @php
                $dayTime = $time->$day ?? null;
                $fromVal = $dayTime->from ?? '';
                $toVal   = $dayTime->to ?? '';
            @endphp

            <div class="flex flex-col gap-3 rounded-md border border-gray-200 p-3 sm:flex-row sm:items-center sm:gap-4">

                <label class="w-28 shrink-0 text-sm font-semibold capitalize">
                    {{ $day }}
                </label>

                <div class="flex flex-1 flex-col items-stretch gap-2 sm:flex-row sm:items-center">

                    <select
                        class="form-input time-from auto-save-field day-{{ $day }} w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary sm:w-1/2"
                        name="time[{{ $day }}][from]">
                        @foreach ($times as $key => $label)
                            <option value="{{ $key }}" {{ $fromVal === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <span class="hidden text-center text-sm font-medium text-gray-500 sm:block sm:w-8">
                        to
                    </span>

                    <select
                        class="form-input time-to auto-save-field day-{{ $day }} w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary sm:w-1/2"
                        name="time[{{ $day }}][to]">
                        @foreach ($times as $key => $label)
                            <option value="{{ $key }}" {{ $toVal === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
        @endforeach
    </div>
</div>


</div>
  <div class="sticky bottom-24 flex justify-end border-t bg-white/90 pt-5 backdrop-blur md:bottom-4"><button class="btn btn-primary"><i data-lucide="save" class="h-4 w-4"></i>Save Profile</button></div>
 </form>

  @endif
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
window.onload = function () {
    var state = "{{ $client->state_id }}";
    var city  = "{{ $client->city_id }}";
    var zone  = "{{ $client->zone_id }}";

    getCity(state, city, function () {
        selectZone(city, zone);
    });
};

var clientId = {{ isset($client->id) ? $client->id : 'null' }};

function getCity(state, city, callback) {
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
            if (typeof callback === 'function') callback();
        }
    });
}

function selectZone(city, zone) {
    var token = $('input[name=_token]').val();
    $.ajax({
        type: "POST",
        url: "{{ route('business.zone.ajax') }}",
        data: { city: city, zone: zone },
        headers: { 'X-CSRF-TOKEN': token },
        cache: false,
        success: function (data) {
            $('#zone').html(data);
            bindSelectAutoSave($('#zone')[0]);
        }
    });
}

// Re-fire chain when State changes manually
$(document).on('change', '#state', function () {
    getCity($(this).val(), '', function () {
        selectZone('', '');
    });
});

// Re-fire Zone chain when City changes manually
$(document).on('change', '#city', function () {
    selectZone($(this).val(), '');
});

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
    var form         = document.getElementById('profileInfoForm');
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
            error: function () {
                isSaving = false;
                showAutoSaveStatus('Save failed. Please try again.', 'danger');
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
