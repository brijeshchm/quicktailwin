@extends('business.business.layouts.app')
@section('title','Profile')
@section('content')
 
<div class="animate-fade-in max-w-5xl space-y-4 md:space-y-6">
    
    <div><h1 class="font-display text-xl font-bold md:text-3xl">
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


 <form id="profileInfoForm" class="card space-y-6 p-6" action="{{ route('business.profile.info') }}"  method="POST" >    
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
            <select id="state" name="state" class="form-input w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary">
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
            <select id="city" name="city" class="form-input w-full rounded-md border-gray-300 focus:border-primary focus:ring-primary">
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
<div
    id="toast-container"
    class="pointer-events-none fixed right-4 top-4 z-[9999] flex w-80 flex-col gap-2"
></div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(function () {

    const clientId = @json($client->id ?? null);

    const initialState = @json($client->state_id ?? '');
    const initialCity  = @json($client->city_id ?? '');
    const initialZone  = @json($client->zone_id ?? '');

    const form = document.getElementById('profileInfoForm');

    let debounceTimer = null;
    let isSaving = false;
    let pendingSave = false;
    let lastSnapshot = '';

    if (form) {
        lastSnapshot = $(form).serialize();
    }


    /*
    |--------------------------------------------------------------------------
    | CSRF Token
    |--------------------------------------------------------------------------
    */

    function getToken() {
        return $(form).find('input[name="_token"]').val()
            || $('meta[name="csrf-token"]').attr('content');
    }


    /*
    |--------------------------------------------------------------------------
    | Load Cities
    |--------------------------------------------------------------------------
    */

    function getCity(state, selectedCity = '', callback = null) {

        if (!state) {
            $('#city').html('<option value="">Select City</option>');
            $('#zone').html('<option value="">Select Zone</option>');

            if (typeof callback === 'function') {
                callback('');
            }

            return;
        }

        $.ajax({
            type: 'POST',

            url: "{{ route('business.cities.ajax') }}",

            data: {
                sid: state,
                cid: selectedCity
            },

            headers: {
                'X-CSRF-TOKEN': getToken()
            },

            cache: false,

            success: function (data) {

                $('#city').html(data);

                const cityId = $('#city').val() || selectedCity || '';

                if (typeof callback === 'function') {
                    callback(cityId);
                }
            },

            error: function () {
                showToast('Unable to load cities', 'error');
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Load Zones
    |--------------------------------------------------------------------------
    */

    function selectZone(city, selectedZone = '', callback = null) {

        if (!city) {
            $('#zone').html('<option value="">Select Zone</option>');

            if (typeof callback === 'function') {
                callback();
            }

            return;
        }

        $.ajax({
            type: 'POST',

            url: "{{ route('business.zone.ajax') }}",

            data: {
                city: city,
                zone: selectedZone
            },

            headers: {
                'X-CSRF-TOKEN': getToken()
            },

            cache: false,

            success: function (data) {

                $('#zone').html(data);

                if (typeof callback === 'function') {
                    callback();
                }
            },

            error: function () {
                showToast('Unable to load zones', 'error');
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Initial State -> City -> Zone
    |--------------------------------------------------------------------------
    */

    if (initialState) {

        getCity(initialState, initialCity, function (cityId) {

            selectZone(
                initialCity || cityId,
                initialZone
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | State Changed
    |--------------------------------------------------------------------------
    */

    $(document).on('change', '#state', function () {

        const stateId = $(this).val();

        clearTimeout(debounceTimer);

        getCity(stateId, '', function (cityId) {

            selectZone(cityId, '', function () {

                triggerAutoSave();

            });

        });

    });


    /*
    |--------------------------------------------------------------------------
    | City Changed
    |--------------------------------------------------------------------------
    */

    $(document).on('change', '#city', function () {

        const cityId = $(this).val();

        clearTimeout(debounceTimer);

        selectZone(cityId, '', function () {

            triggerAutoSave();

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Auto Save Fields
    |--------------------------------------------------------------------------
    */

    if (form) {

        /*
        | Text/Input fields
        */

        $(form).on(
            'input',
            '.auto-save-field:not(select)',
            function () {

                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(function () {
                    triggerAutoSave();
                }, 1500);

            }
        );


        /*
        | Blur - save immediately
        */

        $(form).on(
            'blur',
            '.auto-save-field:not(select)',
            function () {

                clearTimeout(debounceTimer);

                triggerAutoSave();

            }
        );


        /*
        | Other selects
        |
        | State and city are excluded because they need
        | city/zone AJAX loading first.
        */

        $(form).on(
            'change',
            'select.auto-save-field:not(#state):not(#city)',
            function () {

                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(function () {

                    triggerAutoSave();

                }, 400);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Manual Save
        |--------------------------------------------------------------------------
        */

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            clearTimeout(debounceTimer);

            saveForm(true);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Global Trigger
    |--------------------------------------------------------------------------
    */

    window.triggerAutoSave = function () {

        saveForm(false);

    };


    /*
    |--------------------------------------------------------------------------
    | Save Form
    |--------------------------------------------------------------------------
    */

    function saveForm(isManual = false) {

        if (!form) {
            return;
        }

        const current = $(form).serialize();


        /*
        | Don't save if nothing changed
        */

        if (!isManual && current === lastSnapshot) {
            return;
        }


        /*
        | If another save is running,
        | queue another save.
        */

        if (isSaving) {

            pendingSave = true;

            return;
        }


        isSaving = true;
        pendingSave = false;


        showToast(
            isManual ? 'Saving profile...' : 'Saving...',
            'info',
            1200
        );


        /*
        | Remove previous validation errors
        */

        $(form)
            .find('.form-input')
            .removeClass('has-error border-red-500');


        $(form)
            .find('.help-block')
            .remove();


        /*
        | AJAX Save
        */

        $.ajax({

            type: 'POST',

            url: "{{ route('business.profile.info') }}",

            data: current + '&client_id=' + encodeURIComponent(clientId ?? ''),

            headers: {
                'X-CSRF-TOKEN': getToken()
            },

            cache: false,


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            success: function (response) {

                isSaving = false;

                lastSnapshot = current;


                showToast(
                    isManual
                        ? 'Profile saved successfully'
                        : 'Saved',
                    'success'
                );


                /*
                | Something changed while request
                | was running - save latest data.
                */

                if (
                    pendingSave ||
                    $(form).serialize() !== lastSnapshot
                ) {

                    pendingSave = false;

                    setTimeout(function () {
                        saveForm(false);
                    }, 300);

                }

            },


            /*
            |--------------------------------------------------------------------------
            | Error
            |--------------------------------------------------------------------------
            */

            error: function (xhr) {

                // IMPORTANT
                isSaving = false;


                let response = xhr.responseJSON;


                if (
                    response &&
                    response.errors
                ) {

                    const errors = response.errors;


                    Object.keys(errors).forEach(function (key) {

                        const field = $(form).find(
                            '[name="' + key + '"]'
                        ).first();


                        if (!field.length) {
                            return;
                        }


                        field.addClass(
                            'has-error border-red-500'
                        );


                        $('<span>', {
                            class:
                                'help-block mt-1 block text-sm font-medium text-red-600',

                            text:
                                errors[key][0]

                        }).insertAfter(field);

                    });


                    showToast(
                        'Please check validation errors',
                        'error'
                    );

                }

                else {

                    showToast(
                        xhr.status === 419
                            ? 'Session expired. Please refresh the page.'
                            : 'Something went wrong while saving',
                        'error'
                    );

                }

            }

        });

    }

});


/*
|--------------------------------------------------------------------------
| Toast Notification
|--------------------------------------------------------------------------
*/

function showToast(
    message,
    type = 'success',
    duration = 3000
) {

    const container =
        document.getElementById('toast-container');


    if (!container) return;


    const styles = {

        success: {

            bg:
                'bg-emerald-50 border-emerald-200 text-emerald-800',

            icon: `
                <svg
                    class="h-5 w-5 shrink-0 text-emerald-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            `
        },


        error: {

            bg:
                'bg-red-50 border-red-200 text-red-800',

            icon: `
                <svg
                    class="h-5 w-5 shrink-0 text-red-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            `
        },


        info: {

            bg:
                'bg-blue-50 border-blue-200 text-blue-800',

            icon: `
                <svg
                    class="h-5 w-5 shrink-0 animate-spin text-blue-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke-opacity=".25"
                    />

                    <path
                        stroke-linecap="round"
                        d="M21 12a9 9 0 00-9-9"
                    />
                </svg>
            `
        }

    };


    const style =
        styles[type] || styles.success;


    const toast =
        document.createElement('div');


    toast.className = `
        pointer-events-auto
        flex items-center gap-3
        rounded-xl border
        ${style.bg}
        px-4 py-3
        shadow-lg
        transition-all
        duration-300
        translate-x-4
        opacity-0
    `;


    toast.innerHTML = `

        ${style.icon}

        <p class="flex-1 text-sm font-medium">
            ${escapeToastHtml(message)}
        </p>

        <button
            type="button"
            class="shrink-0 rounded p-1 opacity-60 hover:opacity-100"
        >
            ×
        </button>

    `;


    container.appendChild(toast);


    requestAnimationFrame(function () {

        toast.classList.remove(
            'translate-x-4',
            'opacity-0'
        );

    });


    function dismiss() {

        toast.classList.add(
            'translate-x-4',
            'opacity-0'
        );


        setTimeout(function () {

            toast.remove();

        }, 300);

    }


    toast
        .querySelector('button')
        .addEventListener(
            'click',
            dismiss
        );


    setTimeout(
        dismiss,
        duration
    );

}


/*
|--------------------------------------------------------------------------
| Prevent HTML inside toast message
|--------------------------------------------------------------------------
*/

function escapeToastHtml(value) {

    const div =
        document.createElement('div');

    div.textContent = value;

    return div.innerHTML;

}


/*
|--------------------------------------------------------------------------
| Number Only
|--------------------------------------------------------------------------
*/

function isNumberKey(e) {

    const key =
        e.keyCode || e.charCode;

    return key >= 48 && key <= 57;

}
</script>

 
 

@endsection
