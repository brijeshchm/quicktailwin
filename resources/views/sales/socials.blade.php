@extends('business.business.layouts.app')

@section('title', 'Profile')

@section('content')

@php

  

    /*
    |--------------------------------------------------------------------------
    | Social fields
    |--------------------------------------------------------------------------
    */

    $socials = [

        [
            'key'   => 'facebook_url',
            'label' => 'Facebook',
            'icon'  => 'facebook',
            'color' => 'text-blue-600',
        ],

        [
            'key'   => 'instagram_url',
            'label' => 'Instagram',
            'icon'  => 'instagram',
            'color' => 'text-pink-600',
        ],

        [
            'key'   => 'twitter_url',
            'label' => 'Twitter / X',
            'icon'  => 'twitter',
            'color' => 'text-sky-500',
        ],

        [
            'key'   => 'linkedin_url',
            'label' => 'LinkedIn',
            'icon'  => 'linkedin',
            'color' => 'text-blue-700',
        ],

        [
            'key'   => 'youtube_url',
            'label' => 'YouTube',
            'icon'  => 'youtube',
            'color' => 'text-red-600',
        ],

        [
            'key'   => 'pinterest_url',
            'label' => 'Pinterest',
            'icon'  => 'link',
            'color' => 'text-red-500',
        ],

    ];

@endphp


<div class="animate-fade-in max-w-5xl space-y-4 md:space-y-6">

    {{-- =========================================================
         PAGE HEADING
    ========================================================== --}}

    <div>

        <h1 class="font-display text-xl font-bold text-slate-900 md:text-3xl">
            {{ $tabs[$tab] ?? 'Profile' }}
        </h1>

    </div>



    {{-- =========================================================
         AUTO SAVE STATUS
    ========================================================== --}}

    <div
        id="autoSaveStatus"
        class="hidden"
    ></div>



    {{-- =========================================================
         MOBILE TABS
    ========================================================== --}}

    <div class="md:hidden">

        <select
            onchange="window.location=this.value"
            class="form-input h-12 w-full bg-white text-base font-medium shadow-sm"
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



    {{-- =========================================================
         SOCIAL LINKS
    ========================================================== --}}

    @if($tab === 'socials')

        <form
            id="socialForm"
            action="{{ route('profile.socials.save') }}"
            method="POST"
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >

            @csrf

           

            <input
                type="hidden"
                name="redirect_tab"
                value="socials"
            >


            <input
                type="hidden"
                name="business_id"
                value="{{ $client->id }}"
            >



            {{-- Header --}}
            <div class="border-b border-slate-200 px-5 py-5 md:px-6">

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
                    >

                        <i
                            data-lucide="share-2"
                            class="h-5 w-5"
                        ></i>

                    </div>


                    <div>

                        <h3 class="font-display text-lg font-semibold text-slate-900">
                            Social Media Links
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Connect customers with your official social profiles.
                        </p>

                    </div>

                </div>

            </div>



            {{-- Fields --}}
            <div class="grid gap-5 p-5 md:grid-cols-2 md:p-6">

                @foreach($socials as $social)

                    @php

                        $key =
                            $social['key'];

                    @endphp


                    <div>

                        <label
                            for="{{ $key }}"
                            class="mb-2 flex items-center gap-2 text-sm font-medium text-slate-700"
                        >

                            <i
                                data-lucide="{{ $social['icon'] }}"
                                class="h-4 w-4 {{ $social['color'] }}"
                            ></i>

                            {{ $social['label'] }}

                        </label>


                        <input
                            type="url"
                            id="{{ $key }}"
                            name="{{ $key }}"
                            value="{{ old($key, $client->{$key} ?? '') }}"
                            class="auto-save-field w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            placeholder="https://..."
                            autocomplete="off"
                        >


                        {{-- Validation Error --}}
                        <div
                            class="field-error mt-1 text-sm font-medium text-red-600"
                            data-error="{{ $key }}"
                        ></div>

                    </div>

                @endforeach

            </div>



            {{-- Footer --}}
            <div
                class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between md:px-6"
            >

                <div class="text-xs text-slate-500">

                    <span id="lastSavedText">
                        Changes are saved automatically.
                    </span>

                </div>


                <button
                    type="submit"
                    id="socialSaveBtn"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                >

                    <i
                        data-lucide="save"
                        class="h-4 w-4"
                    ></i>

                    <span>
                        Save Social Links
                    </span>

                </button>

            </div>

        </form>

    @endif

</div>



{{-- =============================================================
     TOAST CONTAINER
============================================================= --}}

<div
    id="toast-container"
    class="pointer-events-none fixed right-4 top-4 z-[9999] flex w-80 max-w-[calc(100%-2rem)] flex-col gap-2"
></div>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'socialForm'
            );


        /*
        | Social form doesn't exist
        | on another tab
        */

        if (!form) {
            return;
        }


        const saveButton =
            document.getElementById(
                'socialSaveBtn'
            );


        const saveButtonText =
            saveButton
                ? saveButton.querySelector(
                    'span'
                )
                : null;


        const lastSavedText =
            document.getElementById(
                'lastSavedText'
            );


        let debounceTimer =
            null;


        let isSaving =
            false;


        let pendingSave =
            false;


        let pendingManual =
            false;


        /*
        |--------------------------------------------------------------------------
        | INITIAL SNAPSHOT
        |--------------------------------------------------------------------------
        */

        let lastSnapshot =
            getSnapshot();



        /*
        |--------------------------------------------------------------------------
        | AUTO SAVE FIELDS
        |--------------------------------------------------------------------------
        */

        form
            .querySelectorAll(
                '.auto-save-field'
            )
            .forEach(
                function (field) {


                    /*
                    | User typing
                    */

                    field.addEventListener(
                        'input',
                        function () {

                            clearTimeout(
                                debounceTimer
                            );


                            clearFieldError(
                                field.name
                            );


                            /*
                            | Auto-save after 1.2 sec
                            */

                            debounceTimer =
                                setTimeout(
                                    function () {

                                        saveForm(
                                            false
                                        );

                                    },
                                    1200
                                );

                        }
                    );



                    /*
                    | Save immediately
                    | when user leaves field
                    */

                    field.addEventListener(
                        'blur',
                        function () {

                            clearTimeout(
                                debounceTimer
                            );


                            saveForm(
                                false
                            );

                        }
                    );

                }
            );



        /*
        |--------------------------------------------------------------------------
        | MANUAL SAVE BUTTON
        |--------------------------------------------------------------------------
        */

        form.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                clearTimeout(
                    debounceTimer
                );


                saveForm(
                    true
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | SAVE FORM
        |--------------------------------------------------------------------------
        */

        function saveForm(
            isManual = false
        ) {

            const current =
                getSnapshot();



            /*
            | No changes
            */

            if (
                !isManual &&
                current === lastSnapshot
            ) {

                return;

            }



            /*
            | Another request is running.
            | Do not lose changes.
            */

            if (isSaving) {

                pendingSave =
                    true;


                if (isManual) {

                    pendingManual =
                        true;

                }


                return;

            }


            isSaving =
                true;


            pendingSave =
                false;


            clearAllErrors();


            showToast(
                'Saving...',
                'info'
            );


            setButtonSaving(
                true
            );


            const formData =
                new FormData(
                    form
                );



            /*
            |--------------------------------------------------------------------------
            | AJAX
            |--------------------------------------------------------------------------
            |
            | Form contains:
            |
            | _token
            | _method = PATCH
            |
            | So Laravel will automatically
            | treat POST as PATCH.
            |--------------------------------------------------------------------------
            */

            fetch(
                form.action,
                {

                    method:
                        'POST',

                    headers: {

                        'X-Requested-With':
                            'XMLHttpRequest',

                        'Accept':
                            'application/json'

                    },

                    body:
                        formData

                }
            )

            .then(
                async function (
                    response
                ) {

                    const data =
                        await response
                            .json()
                            .catch(
                                function () {

                                    return {};

                                }
                            );


                    if (!response.ok) {

                        throw {
                            status:
                                response.status,

                            data:
                                data
                        };

                    }


                    return data;

                }
            )

            .then(
                function (data) {

                    isSaving =
                        false;


                    setButtonSaving(
                        false
                    );


                    /*
                    | IMPORTANT:
                    |
                    | use fresh snapshot AFTER save
                    |
                    | because user may have typed
                    | during request.
                    */

                    lastSnapshot =
                        current;


                    showToast(
                        isManual
                            ? 'Social links saved successfully.'
                            : 'Saved',
                        'success'
                    );


                    if (lastSavedText) {

                        lastSavedText.textContent =
                            'Last saved just now';

                    }



                    /*
                    | Save again if user changed
                    | something during request
                    */

                    if (
                        pendingSave ||
                        getSnapshot() !== lastSnapshot
                    ) {

                        const manual =
                            pendingManual;


                        pendingSave =
                            false;


                        pendingManual =
                            false;


                        setTimeout(
                            function () {

                                saveForm(
                                    manual
                                );

                            },
                            250
                        );

                    }

                }
            )

            .catch(
                function (error) {

                    isSaving =
                        false;


                    setButtonSaving(
                        false
                    );


                    const data =
                        error.data ||
                        {};


                    /*
                    |--------------------------------------------------------------------------
                    | LARAVEL VALIDATION
                    |--------------------------------------------------------------------------
                    */

                    if (
                        error.status === 422 &&
                        data.errors
                    ) {

                        Object.keys(
                            data.errors
                        )
                        .forEach(
                            function (field) {

                                showFieldError(
                                    field,
                                    data.errors[field][0]
                                );

                            }
                        );


                        showToast(
                            'Please check the highlighted fields.',
                            'danger'
                        );


                        showToast(
                            'Please check validation errors.',
                            'error'
                        );


                        return;

                    }



                    /*
                    | CSRF expired
                    */

                    if (
                        error.status === 419
                    ) {

                        showToast(
                            'Session expired. Please refresh the page.',
                            'danger'
                        );


                        showToast(
                            'Session expired. Please refresh the page.',
                            'error'
                        );


                        return;

                    }



                    /*
                    | General Error
                    */

                    showToast(
                        data.message ||
                        'Save failed. Please try again.',
                        'danger'
                    );


                    showToast(
                        data.message ||
                        'Unable to save social links.',
                        'error'
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | GET CURRENT FORM SNAPSHOT
        |--------------------------------------------------------------------------
        */

        function getSnapshot() {

            const data =
                new FormData(
                    form
                );


            return new URLSearchParams(
                data
            ).toString();

        }



        /*
        |--------------------------------------------------------------------------
        | BUTTON LOADING
        |--------------------------------------------------------------------------
        */

        function setButtonSaving(
            saving
        ) {

            if (!saveButton) {
                return;
            }


            saveButton.disabled =
                saving;


            if (saveButtonText) {

                saveButtonText.textContent =
                    saving
                        ? 'Saving...'
                        : 'Save Social Links';

            }

        }



        /*
        |--------------------------------------------------------------------------
        | FIELD ERROR
        |--------------------------------------------------------------------------
        */

        function showFieldError(
            field,
            message
        ) {

            const input =
                form.querySelector(
                    '[name="' +
                    CSS.escape(field) +
                    '"]'
                );


            const error =
                form.querySelector(
                    '[data-error="' +
                    CSS.escape(field) +
                    '"]'
                );


            if (input) {

                input.classList.add(
                    'border-red-500',
                    'focus:border-red-500',
                    'focus:ring-red-100'
                );

            }


            if (error) {

                error.textContent =
                    message;

            }

        }



        /*
        |--------------------------------------------------------------------------
        | CLEAR FIELD ERROR
        |--------------------------------------------------------------------------
        */

        function clearFieldError(
            field
        ) {

            const input =
                form.querySelector(
                    '[name="' +
                    CSS.escape(field) +
                    '"]'
                );


            const error =
                form.querySelector(
                    '[data-error="' +
                    CSS.escape(field) +
                    '"]'
                );


            if (input) {

                input.classList.remove(
                    'border-red-500',
                    'focus:border-red-500',
                    'focus:ring-red-100'
                );

            }


            if (error) {

                error.textContent =
                    '';

            }

        }



        /*
        |--------------------------------------------------------------------------
        | CLEAR ALL ERRORS
        |--------------------------------------------------------------------------
        */

        function clearAllErrors() {

            form
                .querySelectorAll(
                    '.auto-save-field'
                )
                .forEach(
                    function (field) {

                        clearFieldError(
                            field.name
                        );

                    }
                );

        }

    }
);



 

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


    if (!container) {
        return;
    }


    const styles = {

        success:
            'border-emerald-200 bg-emerald-50 text-emerald-800',

        error:
            'border-red-200 bg-red-50 text-red-800',

        info:
            'border-blue-200 bg-blue-50 text-blue-800'

    };


    const toast =
        document.createElement(
            'div'
        );


    toast.className =
        `pointer-events-auto flex translate-x-4 items-center gap-3 rounded-xl border px-4 py-3 opacity-0 shadow-lg transition-all duration-300 ${styles[type] || styles.success}`;


    toast.innerHTML = `

        <p class="flex-1 text-sm font-medium">
            ${escapeHtml(message)}
        </p>

        <button
            type="button"
            class="rounded p-1 text-lg leading-none opacity-60 hover:opacity-100"
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
        .querySelector(
            'button'
        )
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
| ESCAPE HTML
|--------------------------------------------------------------------------
*/

function escapeHtml(
    value
) {

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