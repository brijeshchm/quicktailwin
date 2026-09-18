@extends('business.business.layouts.app')

@section('title', 'Awards')

@section('content')

 

<div class="animate-fade-in max-w-5xl space-y-6">

    {{-- =========================================================
         PAGE HEADING
    ========================================================== --}}
    <div>
        <h1 class="font-display text-xl font-bold text-slate-900 md:text-3xl">
           {{ $tabs[$tab] }}
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Add your business awards and recognitions.
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


    {{-- =========================================================
         AWARDS CARD
    ========================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4 md:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">

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
                            d="M16.5 18.75h-9m9 0a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-9a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3m9 0v1.5m-9-1.5v1.5M9 22.5h6M12 6v6m0 0 2.25-2.25M12 12 9.75 9.75"
                        />
                    </svg>

                </div>

                <div>

                    <h2 class="font-semibold text-slate-900">
                        Business Awards
                    </h2>

                    <p class="text-xs text-slate-500">
                        You can add up to 9 awards.
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
             FORM
        ====================================================== --}}
        <form
            id="awardForm"
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


            {{-- AWARD GRID --}}
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">

                @for($i = 1; $i <= 9; $i++)

                    @php

                        $awardNameField = 'award_name' . $i;
                        $awardImageField = 'award_img' . $i;

                        $awardFile = null;
                        $awardPath = '';
                        $awardUrl = '';
                        $extension = '';

                        if (!empty($client->{$awardImageField})) {

                            $awardFile = json_decode(
                                $client->{$awardImageField}
                            );

                            $awardPath =
                                $awardFile->large->src ?? '';

                            if ($awardPath) {

                                $awardUrl =
                                    asset($awardPath);

                                $extension =
                                    strtolower(
                                        pathinfo(
                                            $awardPath,
                                            PATHINFO_EXTENSION
                                        )
                                    );

                            }

                        }

                    @endphp


                    <div
                        class="award-card rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-300 hover:shadow-sm"
                    >

                        {{-- Award Heading --}}
                        <div class="mb-3 flex items-center justify-between">

                            <label
                                for="award_name{{ $i }}"
                                class="text-sm font-semibold text-slate-700"
                            >
                                Award {{ $i }}
                            </label>


                            <span
                                id="awardStatus{{ $i }}"
                                class="hidden text-xs font-medium text-emerald-600"
                            >
                                Saved
                            </span>

                        </div>


                        {{-- =================================================
                             AWARD NAME
                        ================================================== --}}
                        <input
                            type="text"
                            id="award_name{{ $i }}"
                            name="award_name{{ $i }}"
                            value="{{ old($awardNameField, $client->{$awardNameField} ?? '') }}"
                            data-award="{{ $i }}"
                            class="award-name w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            placeholder="Enter award name"
                        >


                        {{-- =================================================
                             IMAGE/PDF
                        ================================================== --}}
                        <div class="mt-4">

                            @if($awardPath)

                                <div
                                    id="awardPreviewWrap{{ $i }}"
                                    class="relative overflow-hidden rounded-xl border border-slate-200 bg-white"
                                >

                                    @if($extension === 'pdf')

                                        {{-- PDF Preview --}}
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
                                                href="{{ $awardUrl }}"
                                                target="_blank"
                                                class="text-sm font-medium text-blue-600 hover:underline"
                                            >
                                                View PDF
                                            </a>

                                        </div>

                                    @else

                                        {{-- Image Preview --}}
                                        <img
                                            src="{{ $awardUrl }}"
                                            alt="Award {{ $i }}"
                                            class="h-40 w-full object-contain p-2"
                                            loading="lazy"
                                        >

                                    @endif


                                    {{-- Delete Button --}}
                                    <button
                                        type="button"
                                        class="delete-award absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white text-red-600 shadow-md transition hover:bg-red-50"
                                        data-award="{{ $i }}"
                                        data-url="{{ url('business/award/award_img'.$i.'/'.$client->id) }}"
                                        title="Remove Award"
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
                                    id="awardDropzone{{ $i }}"
                                    for="awardImage{{ $i }}"
                                    class="flex min-h-[150px] cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-white px-4 py-5 text-center transition hover:border-blue-500 hover:bg-blue-50/40"
                                >

                                    <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-600">

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
                                        Upload Award
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        JPG, PNG or WEBP
                                    </p>


                                    <input
                                        type="file"
                                        id="awardImage{{ $i }}"
                                        name="award_img{{ $i }}"
                                        class="award-file hidden"
                                        data-award="{{ $i }}"
                                        accept=".jpg,.jpeg,.png,.webp"
                                    >

                                </label>

                            @endif

                        </div>

                    </div>

                @endfor

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



{{-- ================================================================
     LOADER
================================================================ --}}
<div
    id="awardLoader"
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
            Saving award...
        </span>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById(
            'awardForm'
        );


    if (!form) {
        return;
    }


    const csrfToken =
        document.querySelector(
            'meta[name="csrf-token"]'
        ).content;


    let saveTimer = null;

    let isSaving = false;

    let pendingSave = false;



    /*
    |--------------------------------------------------------------------------
    | AWARD NAME AUTO SAVE
    |--------------------------------------------------------------------------
    |
    | Save after user stops typing.
    | No page refresh here, otherwise typing would be annoying.
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.award-name'
        )
        .forEach(
            function (input) {

                input.addEventListener(
                    'input',
                    function () {

                        clearTimeout(
                            saveTimer
                        );


                        saveTimer =
                            setTimeout(
                                function () {

                                    saveAwards(
                                        false
                                    );

                                },
                                1200
                            );

                    }
                );


                /*
                | Save immediately on leaving input
                */

                input.addEventListener(
                    'blur',
                    function () {

                        clearTimeout(
                            saveTimer
                        );


                        saveAwards(
                            false
                        );

                    }
                );

            }
        );



    /*
    |--------------------------------------------------------------------------
    | FILE SELECT
    |--------------------------------------------------------------------------
    |
    | Auto upload then refresh page.
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.award-file'
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
                        | Validate image
                        */

                        const allowedTypes = [

                            'image/jpeg',
                            'image/png',
                            'image/webp'

                        ];


                        if (
                            !allowedTypes.includes(
                                file.type
                            )
                        ) {

                            showToast(
                                'Only JPG, PNG or WEBP image allowed.',
                                'error'
                            );


                            this.value =
                                '';


                            return;

                        }



                        /*
                        | Max 5 MB
                        */

                        if (
                            file.size >
                            5 * 1024 * 1024
                        ) {

                            showToast(
                                'Image must be less than 5 MB.',
                                'error'
                            );


                            this.value =
                                '';


                            return;

                        }


                        /*
                        | Upload immediately
                        */

                        saveAwards(
                            true
                        );

                    }
                );

            }
        );



    /*
    |--------------------------------------------------------------------------
    | SAVE FORM
    |--------------------------------------------------------------------------
    |
    | refreshPage = true
    | -> file upload
    |
    | refreshPage = false
    | -> award name update
    |--------------------------------------------------------------------------
    */

    function saveAwards(
        refreshPage = false
    ) {

        if (isSaving) {

            pendingSave =
                true;

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
            "{{ url('business/save-award-auto') }}",
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
                | Save failed from controller
                */

                if (
                    data.status === false
                ) {

                    showToast(
                        data.msg ||
                        'Unable to save award.',
                        'error'
                    );


                    return;

                }



                showToast(
                    data.msg ||
                    'Award saved successfully.',
                    'success'
                );



                /*
                |--------------------------------------------------------------------------
                | FILE UPLOAD -> AUTO REFRESH
                |--------------------------------------------------------------------------
                */

                if (refreshPage) {

                    setTimeout(
                        function () {

                            window.location.reload();

                        },
                        700
                    );


                    return;

                }



                /*
                | Something changed while
                | previous save was running
                */

                if (pendingSave) {

                    pendingSave =
                        false;


                    setTimeout(
                        function () {

                            saveAwards(
                                false
                            );

                        },
                        300
                    );

                }

            }
        )

        .catch(
            function (error) {

                isSaving =
                    false;


                hideLoader();


                let message =
                    'Something went wrong while saving.';



                /*
                | Laravel validation errors
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
                        function (key) {

                            if (
                                error.errors[key] &&
                                error.errors[key][0]
                            ) {

                                messages.push(
                                    error.errors[key][0]
                                );

                            }

                        }
                    );


                    if (
                        messages.length
                    ) {

                        message =
                            messages.join(
                                ' '
                            );

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
    | DELETE AWARD IMAGE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            const button =
                event.target.closest(
                    '.delete-award'
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
                    | Your existing delete
                    | method may return HTML redirect.
                    |
                    | We only care whether
                    | request succeeded.
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
                        'Award image removed successfully.',
                        'success'
                    );


                    /*
                    | Refresh after deletion
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
                        'Unable to remove award image.',
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
            '[id^="awardDropzone"]'
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


                        const award =
                            this.id.replace(
                                'awardDropzone',
                                ''
                            );


                        const input =
                            document.getElementById(
                                'awardImage' +
                                award
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
                'awardLoader'
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
                'awardLoader'
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

});



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