@extends('business.layouts.app')

@section('title')
Business FAQs | Location
@endsection


@section('keyword')
Find Best It Training Centre near You, Find Best It Training Institute near You,
Find Top 10 IT Training Institute near You, Find Best Entrance Exam Preparation
Centre Near you, Top 10 Entrance Exam Centre Near you, Find Best Distance
Education Centre Near You, Find Top 10 Distance Education Centre Near You,
Find Best School And Colleges Near You, Find Top 10 school And College Near You,
Get Education Loan, GET Free career Counselling, Find Best overseas education
consultants Near you, Find Top 10 overseas education consultants Near you
@endsection


@section('description')
Find Only Certified Training Institutes, Coaching Centers near you on QuickDials
and Get Free counseling, Free Demo Classes, and Get Placement Assistence.
@endsection


@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- ============================================================
         PAGE HEADER
    ============================================================= --}}

    <div>

        <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">
            Business FAQs
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Add frequently asked questions about your business.
            Changes are saved automatically.
        </p>

    </div>



    {{-- ============================================================
         AUTO SAVE STATUS
    ============================================================= --}}

    <div
        id="autoSaveStatus"
        class="hidden"
    ></div>



    {{-- ============================================================
         FAQ CARD
    ============================================================= --}}

    <div
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        {{-- Header --}}
        <div class="border-b border-slate-200 px-5 py-4 md:px-6">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.625 9.75a3.375 3.375 0 1 1 6.75 0c0 2.25-3.375 2.25-3.375 4.5m0 3h.008v.008H12v-.008Z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>

                </div>


                <div>

                    <h2 class="text-lg font-semibold text-slate-900">
                        Frequently Asked Questions
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        You can add up to 10 questions and answers.
                    </p>

                </div>

            </div>

        </div>



        {{-- ========================================================
             FORM
        ========================================================= --}}

        <form
            id="faqForm"
            action="{{ route('business.faqs.save') }}"
            method="POST"
            class="p-5 md:p-6"
        >

            @csrf


            <input
                type="hidden"
                name="client_id"
                value="{{ $client->id }}"
            >


            <input
                type="hidden"
                name="savePersonal"
                value="savePersonalForm"
            >



            {{-- FAQ LIST --}}
            <div class="space-y-5">

                @for($i = 1; $i <= 10; $i++)

                    @php

                        $questionField =
                            'faqq' . $i;

                        $answerField =
                            'faqa' . $i;

                    @endphp


                    <div
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 md:p-5"
                    >

                        {{-- FAQ Heading --}}
                        <div
                            class="mb-4 flex items-center justify-between"
                        >

                            <div class="flex items-center gap-2">

                                <span
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700"
                                >
                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                </span>


                                <h3
                                    class="text-sm font-semibold text-slate-800"
                                >
                                    FAQ {{ $i }}
                                </h3>

                            </div>


                            <span
                                id="faqSaved{{ $i }}"
                                class="hidden text-xs font-medium text-emerald-600"
                            >
                                Saved
                            </span>

                        </div>



                        {{-- QUESTION --}}
                        <div>

                            <label
                                for="{{ $questionField }}"
                                class="mb-1.5 block text-sm font-medium text-slate-700"
                            >
                                FAQ Question {{ $i }}
                            </label>


                            <input
                                type="text"
                                id="{{ $questionField }}"
                                name="{{ $questionField }}"
                                value="{{ old($questionField, $client->{$questionField} ?? '') }}"
                                class="faq-auto-save w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Enter FAQ Question {{ $i }}"
                                autocomplete="off"
                            >


                            <div
                                class="faq-error mt-1 text-xs font-medium text-red-600"
                                data-error="{{ $questionField }}"
                            ></div>

                        </div>



                        {{-- ANSWER --}}
                        <div class="mt-4">

                            <label
                                for="{{ $answerField }}"
                                class="mb-1.5 block text-sm font-medium text-slate-700"
                            >
                                FAQ Answer {{ $i }}
                            </label>


                            <textarea
                                id="{{ $answerField }}"
                                name="{{ $answerField }}"
                                rows="4"
                                class="faq-auto-save w-full resize-none rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Enter FAQ Answer {{ $i }}"
                            >{{ old($answerField, $client->{$answerField} ?? '') }}</textarea>


                            <div
                                class="faq-error mt-1 text-xs font-medium text-red-600"
                                data-error="{{ $answerField }}"
                            ></div>

                        </div>

                    </div>

                @endfor

            </div>



            {{-- ====================================================
                 FOOTER
            ===================================================== --}}

            <div
                class="mt-6 flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between"
            >

                <p
                    id="lastSavedText"
                    class="text-xs text-slate-500"
                >
                    Changes are saved automatically.
                </p>


                <button
                    type="submit"
                    id="faqSaveButton"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                >

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17.25 6.75v-1.5A2.25 2.25 0 0 0 15 3H5.25A2.25 2.25 0 0 0 3 5.25v13.5A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V9m-3.75-6v6m0 0h-6m6 0L9 17.25"
                        />
                    </svg>


                    <span>
                        Save FAQs
                    </span>

                </button>

            </div>

        </form>

    </div>

</div>



{{-- ================================================================
     TOAST
================================================================ --}}

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
                'faqForm'
            );


        if (!form) {
            return;
        }


        const saveButton =
            document.getElementById(
                'faqSaveButton'
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


        let lastSnapshot =
            getSnapshot();



        /*
        |--------------------------------------------------------------------------
        | AUTO SAVE
        |--------------------------------------------------------------------------
        |
        | Input:
        | save 1.2 sec after user stops typing.
        |
        | Blur:
        | save immediately.
        |--------------------------------------------------------------------------
        */

        form
            .querySelectorAll(
                '.faq-auto-save'
            )
            .forEach(
                function (field) {


                    /*
                    | While typing
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
                    | User leaves field
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
        | MANUAL SAVE
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
            manual = false
        ) {

            const current =
                getSnapshot();



            /*
            | Nothing changed
            */

            if (
                !manual &&
                current === lastSnapshot
            ) {

                return;

            }



            /*
            | A request is already running.
            |
            | Mark another save as pending,
            | so latest text is not lost.
            */

            if (isSaving) {

                pendingSave =
                    true;


                if (manual) {

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


            setButtonSaving(
                true
            );


            showAutoSaveStatus(
                'Saving...',
                'info'
            );



            const formData =
                new FormData(
                    form
                );



            /*
            |--------------------------------------------------------------------------
            | AJAX SAVE
            |--------------------------------------------------------------------------
            */

            fetch(
                form.action,
                {

                    method:
                        'POST',

                    headers: {

                        /*
                        | Important if Laravel
                        | controller uses:
                        |
                        | $request->ajax()
                        */

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
                    |--------------------------------------------------------------------------
                    | Check controller status
                    |--------------------------------------------------------------------------
                    |
                    | Supports:
                    |
                    | status = 1
                    | status = true
                    |
                    |--------------------------------------------------------------------------
                    */

                    if (
                        data.status === 0 ||
                        data.status === false
                    ) {

                        showAutoSaveStatus(
                            data.msg ||
                            data.message ||
                            'Unable to save FAQs.',
                            'danger'
                        );


                        return;

                    }



                    /*
                    | Remember exactly what
                    | was submitted.
                    */

                    lastSnapshot =
                        current;



                    /*
                    | Success
                    */

                    showAutoSaveStatus(
                        manual
                            ? 'FAQs saved successfully.'
                            : 'Saved automatically',
                        'success'
                    );


                    if (lastSavedText) {

                        lastSavedText.textContent =
                            'Last saved just now';

                    }



                    /*
                    |--------------------------------------------------------------------------
                    | Latest content changed during AJAX request
                    |--------------------------------------------------------------------------
                    */

                    if (
                        pendingSave ||
                        getSnapshot() !== lastSnapshot
                    ) {

                        const shouldManual =
                            pendingManual;


                        pendingSave =
                            false;


                        pendingManual =
                            false;


                        setTimeout(
                            function () {

                                saveForm(
                                    shouldManual
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
                    | VALIDATION ERRORS
                    |--------------------------------------------------------------------------
                    |
                    | Supports Laravel:
                    |
                    | {
                    |    errors: {
                    |       faqq1: [...]
                    |    }
                    | }
                    |--------------------------------------------------------------------------
                    */

                    if (
                        data.errors
                    ) {

                        Object.keys(
                            data.errors
                        )
                        .forEach(
                            function (field) {

                                const message =
                                    Array.isArray(
                                        data.errors[field]
                                    )
                                        ? data.errors[field][0]
                                        : data.errors[field];


                                showFieldError(
                                    field,
                                    message
                                );

                            }
                        );


                        showAutoSaveStatus(
                            'Please check validation errors.',
                            'danger'
                        );


                        showToast(
                            'Please check FAQ fields.',
                            'error'
                        );


                        return;

                    }



                    /*
                    | Session expired
                    */

                    if (
                        error.status === 419
                    ) {

                        showAutoSaveStatus(
                            'Session expired. Please refresh the page.',
                            'danger'
                        );


                        return;

                    }



                    /*
                    | Generic error
                    */

                    showAutoSaveStatus(
                        data.msg ||
                        data.message ||
                        'Error saving FAQs.',
                        'danger'
                    );


                    showToast(
                        data.msg ||
                        data.message ||
                        'Unable to save FAQs.',
                        'error'
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | FORM SNAPSHOT
        |--------------------------------------------------------------------------
        */

        function getSnapshot() {

            const params =
                new URLSearchParams();


            form
                .querySelectorAll(
                    '.faq-auto-save'
                )
                .forEach(
                    function (field) {

                        params.append(
                            field.name,
                            field.value
                        );

                    }
                );


            return params.toString();

        }



        /*
        |--------------------------------------------------------------------------
        | BUTTON
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
                        : 'Save FAQs';

            }

        }



        /*
        |--------------------------------------------------------------------------
        | SHOW FIELD ERROR
        |--------------------------------------------------------------------------
        */

        function showFieldError(
            fieldName,
            message
        ) {

            const field =
                form.querySelector(
                    '[name="' +
                    CSS.escape(
                        fieldName
                    ) +
                    '"]'
                );


            const error =
                form.querySelector(
                    '[data-error="' +
                    CSS.escape(
                        fieldName
                    ) +
                    '"]'
                );


            if (field) {

                field.classList.add(
                    'border-red-500',
                    'focus:border-red-500',
                    'focus:ring-red-100'
                );

            }


            if (error) {

                error.textContent =
                    message || '';

            }

        }



        /*
        |--------------------------------------------------------------------------
        | CLEAR FIELD ERROR
        |--------------------------------------------------------------------------
        */

        function clearFieldError(
            fieldName
        ) {

            const field =
                form.querySelector(
                    '[name="' +
                    CSS.escape(
                        fieldName
                    ) +
                    '"]'
                );


            const error =
                form.querySelector(
                    '[data-error="' +
                    CSS.escape(
                        fieldName
                    ) +
                    '"]'
                );


            if (field) {

                field.classList.remove(
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
                    '.faq-auto-save'
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
| AUTO SAVE STATUS
|--------------------------------------------------------------------------
*/

function showAutoSaveStatus(
    text,
    type = 'info'
) {

    const status =
        document.getElementById(
            'autoSaveStatus'
        );


    if (!status) {
        return;
    }


    const styles = {

        success:
            'border border-emerald-200 bg-emerald-50 text-emerald-800',

        danger:
            'border border-red-200 bg-red-50 text-red-800',

        info:
            'border border-blue-200 bg-blue-50 text-blue-800'

    };


    status.className =
        'rounded-xl px-4 py-3 text-sm font-medium transition ' +
        (
            styles[type] ||
            styles.info
        );


    status.textContent =
        text;


    status.classList.remove(
        'hidden'
    );


    /*
    | Don't hide while Saving...
    */

    if (
        type === 'info'
    ) {

        return;

    }


    setTimeout(
        function () {

            status.classList.add(
                'hidden'
            );

        },
        3000
    );

}



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