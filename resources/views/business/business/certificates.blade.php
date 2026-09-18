@extends('business.business.layouts.app')

@section('title', 'Certificates')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | Certificate configuration
    |--------------------------------------------------------------------------
    */

    $certificates = [

        [
            'title'      => 'PAN No',
            'number'     => 'pan_no',
            'file'       => 'pan_certificate',
            'placeholder'=> 'Enter PAN No',
        ],

        [
            'title'      => 'ISO Certificate',
            'number'     => 'iso_no',
            'file'       => 'iso_certificate',
            'placeholder'=> 'Enter ISO No',
        ],

        [
            'title'      => 'GST No',
            'number'     => 'gst_no',
            'file'       => 'gst_certificate',
            'placeholder'=> 'Enter GST No',
        ],

        [
            'title'      => 'CIN No',
            'number'     => 'cin_no',
            'file'       => 'cin_certificate',
            'placeholder'=> 'Enter CIN No',
        ],

        [
            'title'      => 'MSME No',
            'number'     => 'msme_no',
            'file'       => 'msme_certificate',
            'placeholder'=> 'Enter MSME No',
        ],

        [
            'title'      => 'Certificate of Incorporation',
            'number'     => 'coi_no',
            'file'       => 'coi_certificate',
            'placeholder'=> 'Enter COI No',
        ],

        [
            'title'      => 'Other Certificate 1',
            'number'     => null,
            'file'       => 'other_certificate1',
            'placeholder'=> '',
        ],

        [
            'title'      => 'Other Certificate 2',
            'number'     => null,
            'file'       => 'other_certificate2',
            'placeholder'=> '',
        ],

        [
            'title'      => 'Other Certificate 3',
            'number'     => null,
            'file'       => 'other_certificate3',
            'placeholder'=> '',
        ],

    ];

@endphp


 

<div class="animate-fade-in max-w-5xl space-y-6">

    {{-- Page Heading --}}
    <div>

        <h1 class="font-display text-xl font-bold text-slate-900 md:text-3xl">
            Certificates
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Add your business registration numbers and supporting certificates.
            Changes are saved automatically.
        </p>

    </div>

<div class="md:hidden">
        <select
            onchange="window.location=this.value"
            class="form-input h-12 bg-white text-base font-medium shadow-sm"
        >
            @foreach($tabs as $key => $label)
                <option
                    value="{{ route('profile',['tab'=>$key]) }}"
                    @selected($tab === $key)
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Main Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Header --}}
        <div class="border-b border-slate-200 px-5 py-4 md:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

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
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15A2.25 2.25 0 0 0 6.75 21h10.5a2.25 2.25 0 0 0 2.25-2.25V14.25Z"
                        />
                    </svg>

                </div>

                <div>

                    <h2 class="font-semibold text-slate-900">
                        Business Certificates
                    </h2>

                    <p class="text-xs text-slate-500">
                        JPG, PNG, WEBP or PDF
                    </p>

                </div>

            </div>

        </div>


        {{-- Form --}}
        <form
            id="certificateForm"
            method="POST"
            enctype="multipart/form-data"
            class="p-5 md:p-6"
        >

            @csrf


            <input
                type="hidden"
                name="business_id"
                value="{{ $client->id }}"
            >


            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">

                @foreach($certificates as $index => $certificate)

                    @php

                        $fileField =
                            $certificate['file'];

                        $numberField =
                            $certificate['number'];


                        /*
                        |--------------------------------------------------------------------------
                        | Existing certificate
                        |--------------------------------------------------------------------------
                        */

                        $fileData = null;
                        $filePath = '';
                        $fileUrl  = '';
                        $ext      = '';


                        if (!empty($client->{$fileField})) {

                            $fileData =
                                json_decode(
                                    $client->{$fileField}
                                );


                            $filePath =
                                $fileData->large->src ?? '';


                            if ($filePath) {

                                $fileUrl =
                                    asset($filePath);


                                $ext =
                                    strtolower(
                                        pathinfo(
                                            $filePath,
                                            PATHINFO_EXTENSION
                                        )
                                    );

                            }

                        }

                    @endphp


                    <div
                        class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-300 hover:shadow-sm"
                    >

                        {{-- Heading --}}
                        <div class="mb-3">

                            <h3 class="text-sm font-semibold text-slate-800">
                                {{ $certificate['title'] }}
                            </h3>

                        </div>



                        {{-- Number Field --}}
                        @if($numberField)

                            <input
                                type="text"
                                name="{{ $numberField }}"
                                value="{{ old($numberField, $client->{$numberField} ?? '') }}"
                                class="certificate-number w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="{{ $certificate['placeholder'] }}"
                            >

                        @endif



                        {{-- Certificate --}}
                        <div class="{{ $numberField ? 'mt-4' : '' }}">


                            @if($filePath)

                                {{-- Existing File --}}
                                <div
                                    class="relative overflow-hidden rounded-xl border border-slate-200 bg-white"
                                >

                                    @if($ext === 'pdf')

                                        {{-- PDF --}}
                                        <div class="flex h-40 flex-col items-center justify-center gap-3">

                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">

                                                <svg
                                                    class="h-6 w-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15A2.25 2.25 0 0 0 6.75 21h10.5a2.25 2.25 0 0 0 2.25-2.25V14.25Z"
                                                    />
                                                </svg>

                                            </div>


                                            <a
                                                href="{{ $fileUrl }}"
                                                target="_blank"
                                                class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-100"
                                            >
                                                View PDF
                                            </a>

                                        </div>

                                    @else

                                        {{-- Image --}}
                                        <img
                                            src="{{ $fileUrl }}"
                                            alt="{{ $certificate['title'] }}"
                                            loading="lazy"
                                            class="h-40 w-full object-contain p-3"
                                        >

                                    @endif



                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        class="delete-certificate absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white text-red-600 shadow-md transition hover:bg-red-50"
                                        data-url="{{ url('business/certificate/'.$fileField.'/'.$client->id) }}"
                                        title="Delete Certificate"
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
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9M3.75 5.79h16.5"
                                            />
                                        </svg>

                                    </button>

                                </div>


                            @else

                                {{-- Upload Area --}}
                                <label
                                    class="certificate-dropzone flex min-h-[150px] cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-white px-4 py-5 text-center transition hover:border-blue-500 hover:bg-blue-50/40"
                                >

                                    <div
                                        class="mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-600"
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
                                                d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5A4.5 4.5 0 0 1 5.25 6.18"
                                            />
                                        </svg>

                                    </div>


                                    <p class="text-sm font-semibold text-slate-700">
                                        Upload Certificate
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Click or drag & drop
                                    </p>

                                    <p class="mt-1 text-[11px] text-slate-400">
                                        JPG, PNG, WEBP, PDF
                                    </p>


                                    <input
                                        type="file"
                                        name="{{ $fileField }}"
                                        class="certificate-file hidden"
                                        accept=".jpg,.jpeg,.png,.webp,.pdf"
                                    >

                                </label>

                            @endif

                        </div>


                        {{-- Error --}}
                        <div
                            class="field-error mt-2 text-xs font-medium text-red-600"
                            data-field="{{ $fileField }}"
                        ></div>

                    </div>

                @endforeach

            </div>

        </form>

    </div>

</div>



{{-- ================================================================
     LOADER
================================================================ --}}

<div
    id="certificateLoader"
    class="fixed inset-0 z-[9998] hidden items-center justify-center bg-slate-950/20 backdrop-blur-[1px]"
>

    <div class="flex items-center gap-3 rounded-xl bg-white px-5 py-4 shadow-xl">

        <svg
            class="h-5 w-5 animate-spin text-blue-600"
            fill="none"
            viewBox="0 0 24 24"
        >

            <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
            ></circle>

            <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"
            ></path>

        </svg>


        <span class="text-sm font-medium text-slate-700">
            Saving certificate...
        </span>

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
                'certificateForm'
            );


        if (!form) {
            return;
        }


        const csrfToken =
            document.querySelector(
                'meta[name="csrf-token"]'
            ).content;


        let saveTimer =
            null;


        let isSaving =
            false;


        let pendingSave =
            false;


        let pendingRefresh =
            false;



        /*
        |--------------------------------------------------------------------------
        | NUMBER FIELD CHANGE
        |--------------------------------------------------------------------------
        |
        | When field loses focus / changes:
        | Auto Save -> Show Success -> Reload Page
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.certificate-number'
            )
            .forEach(
                function (input) {

                    input.addEventListener(
                        'change',
                        function () {

                            clearTimeout(
                                saveTimer
                            );


                            saveTimer =
                                setTimeout(
                                    function () {

                                        saveCertificate(
                                            true
                                        );

                                    },
                                    400
                                );

                        }
                    );

                }
            );



        /*
        |--------------------------------------------------------------------------
        | FILE SELECT
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.certificate-file'
            )
            .forEach(
                function (input) {

                    input.addEventListener(
                        'change',
                        function () {

                            const file =
                                this.files[0];


                            if (!file) {
                                return;
                            }



                            /*
                            | Allowed files
                            */

                            const allowedTypes = [

                                'image/jpeg',
                                'image/png',
                                'image/webp',
                                'application/pdf'

                            ];


                            if (
                                !allowedTypes.includes(
                                    file.type
                                )
                            ) {

                                showToast(
                                    'Only JPG, PNG, WEBP or PDF files are allowed.',
                                    'error'
                                );


                                this.value =
                                    '';


                                return;

                            }



                            /*
                            | Max 10MB
                            */

                            if (
                                file.size >
                                10 * 1024 * 1024
                            ) {

                                showToast(
                                    'Certificate file must be less than 10 MB.',
                                    'error'
                                );


                                this.value =
                                    '';


                                return;

                            }



                            /*
                            | Auto Save + Refresh
                            */

                            saveCertificate(
                                true
                            );

                        }
                    );

                }
            );



        /*
        |--------------------------------------------------------------------------
        | SAVE CERTIFICATE
        |--------------------------------------------------------------------------
        */

        function saveCertificate(
            refreshPage = true
        ) {

            /*
            | If saving already
            */

            if (isSaving) {

                pendingSave =
                    true;


                if (refreshPage) {

                    pendingRefresh =
                        true;

                }


                return;

            }


            isSaving =
                true;


            pendingSave =
                false;


            const formData =
                new FormData(
                    form
                );


            showLoader();



            fetch(
                "{{ url('business/save-certificate-auto') }}",
                {

                    method:
                        'POST',

                    headers: {

                        'X-CSRF-TOKEN':
                            csrfToken,

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

                        throw data;

                    }


                    return data;

                }
            )

            .then(
                function (data) {

                    isSaving =
                        false;


                    hideLoader();



                    /*
                    | Controller failure
                    */

                    if (
                        data.status === false
                    ) {

                        showToast(
                            data.msg ||
                            'Unable to save certificate.',
                            'error'
                        );


                        return;

                    }



                    /*
                    | Success
                    */

                    showToast(
                        data.msg ||
                        'Certificate saved successfully.',
                        'success'
                    );



                    /*
                    |--------------------------------------------------------------------------
                    | PAGE AUTO REFRESH
                    |--------------------------------------------------------------------------
                    */

                    if (
                        refreshPage ||
                        pendingRefresh
                    ) {

                        setTimeout(
                            function () {

                                window.location.reload();

                            },
                            700
                        );


                        return;

                    }



                    /*
                    | Save pending changes
                    */

                    if (pendingSave) {

                        pendingSave =
                            false;


                        setTimeout(
                            function () {

                                saveCertificate(
                                    false
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


                    hideLoader();



                    /*
                    | Clear errors
                    */

                    document
                        .querySelectorAll(
                            '.field-error'
                        )
                        .forEach(
                            function (element) {

                                element.textContent =
                                    '';

                            }
                        );



                    let message =
                        'Something went wrong while saving.';



                    /*
                    | Laravel validation
                    */

                    if (
                        error &&
                        error.errors
                    ) {

                        const messages =
                            [];


                        Object.keys(
                            error.errors
                        )
                        .forEach(
                            function (field) {

                                const errorMessage =
                                    error.errors[
                                        field
                                    ][0];


                                messages.push(
                                    errorMessage
                                );


                                const element =
                                    document.querySelector(
                                        '[data-field="' +
                                        field +
                                        '"]'
                                    );


                                if (element) {

                                    element.textContent =
                                        errorMessage;

                                }

                            }
                        );


                        if (
                            messages.length
                        ) {

                            message =
                                messages[0];

                        }

                    }


                    else if (
                        error &&
                        (
                            error.msg ||
                            error.message
                        )
                    ) {

                        message =
                            error.msg ||
                            error.message;

                    }



                    showToast(
                        message,
                        'error',
                        5000
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | DELETE CERTIFICATE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (event) {

                const button =
                    event.target.closest(
                        '.delete-certificate'
                    );


                if (!button) {
                    return;
                }


                event.preventDefault();


                const url =
                    button.dataset.url;


                if (!url) {
                    return;
                }


                showLoader();


                fetch(
                    url,
                    {

                        method:
                            'GET',

                        headers: {

                            'X-CSRF-TOKEN':
                                csrfToken,

                            'Accept':
                                'application/json'

                        }

                    }
                )

                .then(
                    async function (
                        response
                    ) {

                        /*
                        | Your existing Laravel
                        | delete routes may redirect.
                        */

                        if (!response.ok) {

                            throw new Error(
                                'Delete failed'
                            );

                        }


                        return true;

                    }
                )

                .then(
                    function () {

                        hideLoader();


                        showToast(
                            'Certificate removed successfully.',
                            'success'
                        );


                        /*
                        | Auto refresh
                        */

                        setTimeout(
                            function () {

                                window.location.reload();

                            },
                            600
                        );

                    }
                )

                .catch(
                    function () {

                        hideLoader();


                        showToast(
                            'Unable to remove certificate.',
                            'error'
                        );

                    }
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | DRAG & DROP
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.certificate-dropzone'
            )
            .forEach(
                function (dropzone) {

                    dropzone.addEventListener(
                        'dragover',
                        function (event) {

                            event.preventDefault();


                            this.classList.add(
                                'border-blue-500',
                                'bg-blue-50'
                            );

                        }
                    );


                    dropzone.addEventListener(
                        'dragleave',
                        function () {

                            this.classList.remove(
                                'border-blue-500',
                                'bg-blue-50'
                            );

                        }
                    );


                    dropzone.addEventListener(
                        'drop',
                        function (event) {

                            event.preventDefault();


                            this.classList.remove(
                                'border-blue-500',
                                'bg-blue-50'
                            );


                            const input =
                                this.querySelector(
                                    '.certificate-file'
                                );


                            if (
                                !input ||
                                !event
                                    .dataTransfer
                                    .files
                                    .length
                            ) {

                                return;

                            }


                            const transfer =
                                new DataTransfer();


                            transfer.items.add(
                                event
                                    .dataTransfer
                                    .files[0]
                            );


                            input.files =
                                transfer.files;


                            input.dispatchEvent(
                                new Event(
                                    'change',
                                    {
                                        bubbles:
                                            true
                                    }
                                )
                            );

                        }
                    );

                }
            );



        /*
        |--------------------------------------------------------------------------
        | LOADER
        |--------------------------------------------------------------------------
        */

        function showLoader() {

            const loader =
                document.getElementById(
                    'certificateLoader'
                );


            if (!loader) {
                return;
            }


            loader
                .classList
                .remove(
                    'hidden'
                );


            loader
                .classList
                .add(
                    'flex'
                );

        }


        function hideLoader() {

            const loader =
                document.getElementById(
                    'certificateLoader'
                );


            if (!loader) {
                return;
            }


            loader
                .classList
                .add(
                    'hidden'
                );


            loader
                .classList
                .remove(
                    'flex'
                );

        }

    }
);



/*
|--------------------------------------------------------------------------
| TAILWIND TOAST
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

        success: {

            wrapper:
                'border-emerald-200 bg-emerald-50 text-emerald-800',

            icon:
                'text-emerald-500',

            path:
                'M5 13l4 4L19 7'

        },


        error: {

            wrapper:
                'border-red-200 bg-red-50 text-red-800',

            icon:
                'text-red-500',

            path:
                'M6 18 18 6M6 6l12 12'

        },


        info: {

            wrapper:
                'border-blue-200 bg-blue-50 text-blue-800',

            icon:
                'text-blue-500',

            path:
                'M12 4v2m0 12v2m8-8h-2M6 12H4'

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
        `pointer-events-auto flex translate-x-4 items-center gap-3 rounded-xl border px-4 py-3 opacity-0 shadow-lg transition-all duration-300 ${style.wrapper}`;


    toast.innerHTML = `

        <svg
            class="h-5 w-5 shrink-0 ${style.icon}"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="${style.path}"
            />

        </svg>


        <p class="flex-1 text-sm font-medium">
            ${escapeHtml(message)}
        </p>


        <button
            type="button"
            class="rounded p-1 opacity-60 hover:opacity-100"
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