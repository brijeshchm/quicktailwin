@extends('business.business.layouts.app')

@section('title', 'Profile')

@section('content')
 

<div class="animate-fade-in max-w-5xl space-y-4 md:space-y-6">

    <div>
        <h1 class="font-display text-xl font-bold md:text-3xl">
            {{ $tabs[$tab] ?? '' }}
        </h1>
    </div>


    {{-- Mobile Tabs --}}
    <div class="md:hidden">

        <select
            onchange="window.location=this.value"
            class="form-input h-12 bg-white text-base font-medium shadow-sm"
        >

            @foreach($tabs as $key => $label)

                <option
                    value="{{ route('profile', ['tab' => $key]) }}"
                    @selected($tab === $key)
                >
                    {{ $label }}
                </option>

            @endforeach

        </select>

    </div>

@if($tab === 'locations')

<div class="card overflow-hidden">

    {{-- Heading --}}
    <div class="border-b p-6">

        <h3 class="font-display text-lg font-semibold">
            Service Areas
        </h3>

        <p class="mt-1 text-sm text-slate-500">
            Specify cities and neighborhoods you serve.
        </p>

    </div>


    {{-- ADD LOCATION --}}
    <form
        id="locationService"
        action="{{ route('profile.locations.add') }}"
        method="POST"
        class="grid gap-4 bg-secondary/30 p-5 md:grid-cols-4"
    >

        @csrf

        <input
            type="hidden"
            name="client_id"
            value="{{ $client->id }}"
        >


        {{-- STATE --}}
        <div>

            <label class="mb-2 block text-xs font-medium">
                State *
            </label>

            <select
                id="state"
                name="state_id"
                class="form-input w-full"
            >

                <option value="">
                    Select State
                </option>

                @foreach($states as $state)

                    <option value="{{ $state->id }}">
                        {{ $state->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- CITY --}}
        <div>

            <label class="mb-2 block text-xs font-medium">
                City *
            </label>

            <select
                id="city"
                name="city_id"
                class="form-input w-full"
            >

                <option value="">
                    Select City
                </option>

            </select>

        </div>


        {{-- ZONE --}}
        <div>

            <label class="mb-2 block text-xs font-medium">
                Area / Neighborhood *
            </label>

            <select
                id="zone"
                name="zone_id"
                class="form-input w-full"
            >

                <option value="">
                    Select Zone
                </option>

            </select>


            {{-- OTHER INPUT --}}
            <div
                id="otherZoneWrap"
                class="mt-3 hidden"
            >

                <input
                    type="text"
                    id="otherZone"
                    name="other"
                    class="form-input w-full"
                    placeholder="Enter Area / Neighborhood"
                >

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex items-end">

            <button
                type="submit"
                id="addLocationBtn"
                class="btn btn-primary w-full"
            >

                <i
                    data-lucide="plus"
                    class="h-4 w-4"
                ></i>

                <span>
                    Add Area
                </span>

            </button>

        </div>


        {{-- Validation --}}
        <div
            id="locationErrors"
            class="md:col-span-4"
        ></div>

    </form>



    {{-- LOCATION LIST --}}
    <div id="locationListWrap">

        <div
            id="locationList"
            class="grid gap-4 p-5 md:grid-cols-2"
        >

            @forelse($locations as $location)

                <div
                    class="location-row flex items-center justify-between rounded-xl border bg-white p-4"
                >

                    <div class="flex items-start gap-3">

                        <span
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary"
                        >

                            <i
                                data-lucide="map-pin"
                                class="h-5 w-5"
                            ></i>

                        </span>


                        <div>

                            <p class="font-semibold">
                                {{ $location->zone }}
                            </p>

                            <p class="text-xs text-slate-500">
                                {{ $location->city }}
                            </p>

                        </div>

                    </div>


                    {{-- DELETE --}}
                    <form
                        action="{{ route('profile.locations.delete', $location->assign_id) }}"
                        method="POST"
                        class="location-delete-form"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="delete-location-btn flex h-8 w-8 items-center justify-center rounded-lg text-red-600 hover:bg-red-50"
                        >

                            <i
                                data-lucide="trash-2"
                                class="h-4 w-4"
                            ></i>

                        </button>

                    </form>

                </div>

            @empty

                <div class="col-span-full p-8 text-center text-slate-500">
                    No service areas added.
                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if(method_exists($locations, 'links'))

            <div
                id="locationPagination"
                class="border-t px-5 py-4"
            >

                {{ $locations->appends([
                    'tab' => 'locations'
                ])->links() }}

            </div>

        @endif

    </div>

</div>

@endif


 
   

</div>


{{-- Toast --}}
<div
    id="toast-container"
    class="pointer-events-none fixed right-4 top-4 z-[9999] flex w-80 flex-col gap-2"
></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

$(document).ready(function () {


    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    function csrfToken() {

        return $('#locationService')
            .find('input[name="_token"]')
            .val();

    }



    /*
    |--------------------------------------------------------------------------
    | LOAD CITY
    |--------------------------------------------------------------------------
    */

    function getCity(stateId) {

        if (!stateId) {

            $('#city').html(
                '<option value="">Select City</option>'
            );

            $('#zone').html(
                '<option value="">Select Zone</option>'
            );

            hideOtherZone();

            return;
        }


        $('#city').html(
            '<option value="">Loading...</option>'
        );


        $('#zone').html(
            '<option value="">Select Zone</option>'
        );


        hideOtherZone();


        $.ajax({

            type: 'POST',

            url: "{{ route('business.cities.ajax') }}",

            data: {
                sid: stateId,
                cid: ''
            },

            headers: {
                'X-CSRF-TOKEN': csrfToken()
            },

            success: function (data) {

                $('#city').html(data);

            },

            error: function () {

                $('#city').html(
                    '<option value="">Select City</option>'
                );

                showToast(
                    'Unable to load cities',
                    'error'
                );

            }

        });

    }



    /*
    |--------------------------------------------------------------------------
    | LOAD ZONE
    |--------------------------------------------------------------------------
    */

    function getZone(cityId) {

        if (!cityId) {

            $('#zone').html(
                '<option value="">Select Zone</option>'
            );

            hideOtherZone();

            return;
        }


        $('#zone').html(
            '<option value="">Loading...</option>'
        );


        hideOtherZone();


        $.ajax({

            type: 'POST',

            url: "{{ route('business.zone.ajax') }}",

            data: {
                city: cityId,
                zone: ''
            },

            headers: {
                'X-CSRF-TOKEN': csrfToken()
            },

            success: function (data) {

                $('#zone').html(data);

            },

            error: function () {

                $('#zone').html(
                    '<option value="">Select Zone</option>'
                );

                showToast(
                    'Unable to load areas',
                    'error'
                );

            }

        });

    }



    /*
    |--------------------------------------------------------------------------
    | STATE CHANGE
    |--------------------------------------------------------------------------
    */

    $('#state').on('change', function () {

        const stateId = $(this).val();

        getCity(stateId);

    });



    /*
    |--------------------------------------------------------------------------
    | CITY CHANGE
    |--------------------------------------------------------------------------
    */

    $('#city').on('change', function () {

        const cityId = $(this).val();

        getZone(cityId);

    });



    /*
    |--------------------------------------------------------------------------
    | ZONE CHANGE - SHOW OTHER INPUT
    |--------------------------------------------------------------------------
    */

    $('#zone').on('change', function () {

        const selectedValue =
            ($(this).val() || '')
                .toString()
                .trim()
                .toLowerCase();


        const selectedText =
            ($(this).find('option:selected').text() || '')
                .trim()
                .toLowerCase();


        /*
        | Works in both cases:
        |
        | <option value="Other">Other</option>
        |
        | OR
        |
        | <option value="123">Other</option>
        */

        if (
            selectedValue === 'other' ||
            selectedText === 'other'
        ) {

            showOtherZone();

        } else {

            hideOtherZone();

        }

    });



    /*
    |--------------------------------------------------------------------------
    | SHOW OTHER
    |--------------------------------------------------------------------------
    */

    function showOtherZone() {

        $('#otherZoneWrap')
            .removeClass('hidden');

        $('#otherZone')
            .prop('required', true)
            .focus();

    }



    /*
    |--------------------------------------------------------------------------
    | HIDE OTHER
    |--------------------------------------------------------------------------
    */

    function hideOtherZone() {

        $('#otherZoneWrap')
            .addClass('hidden');

        $('#otherZone')
            .prop('required', false)
            .val('');

    }



    /*
    |--------------------------------------------------------------------------
    | ADD LOCATION
    |--------------------------------------------------------------------------
    */

    $('#locationService').on('submit', function (e) {

        e.preventDefault();


        const form =
            $(this);


        const button =
            $('#addLocationBtn');


        /*
        | Clear old validation
        */

        $('#locationErrors').html('');

        form
            .find('.help-block')
            .remove();

        form
            .find('.border-red-500')
            .removeClass('border-red-500');


        /*
        | Validation
        */

        if (!$('#state').val()) {

            showFieldError(
                $('#state'),
                'Please select State.'
            );

            return;
        }


        if (!$('#city').val()) {

            showFieldError(
                $('#city'),
                'Please select City.'
            );

            return;
        }


        if (!$('#zone').val()) {

            showFieldError(
                $('#zone'),
                'Please select Area / Neighborhood.'
            );

            return;
        }



        /*
        | Check whether OTHER is selected
        */

        const zoneValue =
            ($('#zone').val() || '')
                .toString()
                .trim()
                .toLowerCase();


        const zoneText =
            ($('#zone option:selected').text() || '')
                .trim()
                .toLowerCase();


        const isOther =
            zoneValue === 'other' ||
            zoneText === 'other';



        /*
        | Validate Other textbox
        */

        if (
            isOther &&
            !$('#otherZone').val().trim()
        ) {

            showFieldError(
                $('#otherZone'),
                'Please enter Area / Neighborhood.'
            );

            $('#otherZone').focus();

            return;
        }



        /*
        | Disable button
        */

        button.prop(
            'disabled',
            true
        );


        button
            .find('span')
            .text('Adding...');


        showToast(
            'Adding service area...',
            'info',
            1000
        );



        /*
        |--------------------------------------------------------------------------
        | AJAX SAVE
        |--------------------------------------------------------------------------
        */

        $.ajax({

            type: 'POST',

            url: form.attr('action'),

            data: form.serialize(),

            cache: false,


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            success: function (response) {

                button.prop(
                    'disabled',
                    false
                );


                button
                    .find('span')
                    .text('Add Area');


                showToast(
                    response.message ||
                    'Service area added successfully',
                    'success'
                );


                /*
                | Reset Zone
                */

                $('#zone').val('');


                /*
                | Reset Other input
                */

                hideOtherZone();


                /*
                |--------------------------------------------------------------------------
                | AUTO REFRESH LOCATION LIST
                |--------------------------------------------------------------------------
                |
                | No full page reload.
                |
                */

                loadLocationPage(
                    "{{ route('profile', ['tab' => 'locations']) }}"
                );

            },


            /*
            |--------------------------------------------------------------------------
            | ERROR
            |--------------------------------------------------------------------------
            */

            error: function (xhr) {

                button.prop(
                    'disabled',
                    false
                );


                button
                    .find('span')
                    .text('Add Area');


                if (
                    xhr.status === 422 &&
                    xhr.responseJSON &&
                    xhr.responseJSON.errors
                ) {

                    const errors =
                        xhr.responseJSON.errors;


                    Object.keys(errors)
                        .forEach(function (key) {

                            const field =
                                form
                                    .find(
                                        '[name="' + key + '"]'
                                    )
                                    .first();


                            if (field.length) {

                                showFieldError(
                                    field,
                                    errors[key][0]
                                );

                            }

                        });


                    showToast(
                        'Please check validation errors',
                        'error'
                    );

                    return;

                }


                if (xhr.status === 419) {

                    showToast(
                        'Session expired. Please refresh the page.',
                        'error'
                    );

                    return;

                }


                showToast(
                    xhr.responseJSON?.message ||
                    'Something went wrong while saving',
                    'error'
                );

            }

        });

    });



    /*
    |--------------------------------------------------------------------------
    | FIELD ERROR
    |--------------------------------------------------------------------------
    */

    function showFieldError(
        field,
        message
    ) {

        field.addClass(
            'border-red-500'
        );


        $('<span>', {

            class:
                'help-block mt-1 block text-sm font-medium text-red-600',

            text:
                message

        }).insertAfter(field);

    }



    /*
    |--------------------------------------------------------------------------
    | DELETE LOCATION
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'submit',
        '.location-delete-form',
        function (e) {

            e.preventDefault();


            const form =
                $(this);


            const button =
                form.find(
                    '.delete-location-btn'
                );


            button.prop(
                'disabled',
                true
            );


            showToast(
                'Deleting...',
                'info',
                800
            );


            $.ajax({

                type: 'POST',

                url:
                    form.attr('action'),

                data:
                    form.serialize(),


                success:
                    function (response) {

                        showToast(
                            response.message ||
                            'Service area deleted successfully',
                            'success'
                        );


                        /*
                        | Auto refresh after delete
                        */

                        loadLocationPage(
                            window.currentLocationPage ||
                            "{{ route('profile', ['tab' => 'locations']) }}"
                        );

                    },


                error:
                    function (xhr) {

                        button.prop(
                            'disabled',
                            false
                        );


                        showToast(
                            xhr.responseJSON?.message ||
                            'Unable to delete service area',
                            'error'
                        );

                    }

            });

        }
    );



    /*
    |--------------------------------------------------------------------------
    | AJAX PAGINATION
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'click',
        '#locationPagination a',
        function (e) {

            e.preventDefault();


            const url =
                $(this).attr('href');


            if (!url) {
                return;
            }


            loadLocationPage(url);

        }
    );



    /*
    |--------------------------------------------------------------------------
    | AUTO REFRESH LOCATION LIST
    |--------------------------------------------------------------------------
    */

    function loadLocationPage(url) {

        if (!url) {
            return;
        }


        window.currentLocationPage =
            url;


        $('#locationListWrap')
            .addClass(
                'pointer-events-none opacity-50'
            );


        $.ajax({

            url: url,

            type: 'GET',

            cache: false,


            success: function (html) {

                const newPage =
                    new DOMParser()
                        .parseFromString(
                            html,
                            'text/html'
                        );


                const newLocationList =
                    newPage.querySelector(
                        '#locationListWrap'
                    );


                if (newLocationList) {

                    $('#locationListWrap')
                        .html(
                            newLocationList.innerHTML
                        );

                }


                $('#locationListWrap')
                    .removeClass(
                        'pointer-events-none opacity-50'
                    );


                /*
                | Reload Lucide icons
                */

                if (
                    typeof lucide !==
                    'undefined'
                ) {

                    lucide.createIcons();

                }

            },


            error: function () {

                $('#locationListWrap')
                    .removeClass(
                        'pointer-events-none opacity-50'
                    );


                showToast(
                    'Unable to refresh service areas',
                    'error'
                );

            }

        });

    }

});



/*
|--------------------------------------------------------------------------
| TOAST
|--------------------------------------------------------------------------
*/

function showToast(
    message,
    type = 'success',
    duration = 3000
) {

    const container =
        document.getElementById(
            'toast-container'
        );


    if (!container) return;


    const styles = {

        success: {
            bg:
                'bg-emerald-50 border-emerald-200 text-emerald-800'
        },

        error: {
            bg:
                'bg-red-50 border-red-200 text-red-800'
        },

        info: {
            bg:
                'bg-blue-50 border-blue-200 text-blue-800'
        }

    };


    const style =
        styles[type] ||
        styles.success;


    const toast =
        document.createElement(
            'div'
        );


    toast.className =
        `pointer-events-auto flex items-center gap-3 rounded-xl border ${style.bg} px-4 py-3 shadow-lg transition-all duration-300 translate-x-4 opacity-0`;


    toast.innerHTML = `

        <p class="flex-1 text-sm font-medium">
            ${escapeHtml(message)}
        </p>

        <button
            type="button"
            class="shrink-0 rounded p-1"
        >
            ×
        </button>

    `;


    container.appendChild(
        toast
    );


    requestAnimationFrame(
        function () {

            toast.classList.remove(
                'translate-x-4',
                'opacity-0'
            );

        }
    );


    function dismiss() {

        toast.classList.add(
            'translate-x-4',
            'opacity-0'
        );


        setTimeout(
            function () {

                toast.remove();

            },
            300
        );

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



function escapeHtml(value) {

    const div =
        document.createElement(
            'div'
        );

    div.textContent =
        value || '';

    return div.innerHTML;

}

</script>
 
@endsection