@extends('business.business.layouts.app')

@section('title', 'Profile')

@section('content')

 

<div class="animate-fade-in max-w-5xl space-y-4 md:space-y-6">

    {{-- Heading --}}
    <div>

        <h1 class="font-display text-xl font-bold md:text-3xl">
            {{ $tabs[$tab] ?? 'Recent Activity' }}
        </h1>

    </div>


    {{-- Global Auto Save Status --}}
    <div
        id="autoSaveStatus"
        class="hidden"
    ></div>


    {{-- Mobile Tabs --}}
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


    {{-- ============================================================
         RECENT ACTIVITY
    ============================================================= --}}

    @if($tab === 'recent')

        <form
            id="recentActivityForm"
            action="{{ route('recent.activity.save') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >

            @csrf


            <input
                type="hidden"
                name="business_id"
                value="{{ $client->id ?? '' }}"
            >


            {{-- Header Card --}}
            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
            >

                <div class="border-b border-slate-200 px-5 py-4 md:px-6">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
                        >

                            <i
                                data-lucide="activity"
                                class="h-5 w-5"
                            ></i>

                        </div>


                        <div>

                            <h3 class="font-display text-lg font-semibold text-slate-900">
                                Recent Activities
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Add your latest events, updates and business activities.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Activities --}}
                <div
                    class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3 md:p-6"
                >

                    @for($i = 1; $i <= 6; $i++)

                        @php

                            $imgField =
                                'recent_img' . $i;

                            $nameField =
                                'recent_name' . $i;

                            $paraField =
                                'recent_paragraph' . $i;


                            /*
                            |--------------------------------------------------------------------------
                            | Existing image
                            |--------------------------------------------------------------------------
                            */

                            $recentImg =
                                !empty($client->{$imgField})
                                    ? json_decode($client->{$imgField})
                                    : null;


                            $recentPath =
                                $recentImg->large->src ?? '';


                            $recentUrl =
                                $recentPath
                                    ? asset($recentPath)
                                    : '';


                            $extension =
                                strtolower(
                                    pathinfo(
                                        $recentPath,
                                        PATHINFO_EXTENSION
                                    )
                                );


                            $isRequired =
                                ($i === 1);


                            $badgeNum =
                                str_pad(
                                    $i,
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                );

                        @endphp


                        <div
                            class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-300 hover:shadow-sm"
                        >

                            {{-- Card Header --}}
                            <div
                                class="mb-4 flex items-center justify-between"
                            >

                                <div class="flex items-center gap-2">

                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-600"
                                    >
                                        {{ $badgeNum }}
                                    </span>


                                    <h4
                                        class="text-sm font-semibold text-slate-800"
                                    >

                                        Recent Activity {{ $i }}

                                        @if($isRequired)

                                            <span class="text-red-500">
                                                *
                                            </span>

                                        @endif

                                    </h4>

                                </div>

                            </div>



                            {{-- =================================================
                                 MEDIA
                            ================================================== --}}

                            <div
                                id="recentMedia{{ $i }}"
                                class="mb-4"
                            >

                                {{-- Existing Preview --}}
                                <div
                                    id="recentPreviewWrap{{ $i }}"
                                    class="{{ $recentPath ? '' : 'hidden' }} relative overflow-hidden rounded-xl border border-slate-200 bg-white"
                                >

                                    @if($recentPath)

                                        @if($extension === 'pdf')

                                            <div
                                                class="flex h-40 flex-col items-center justify-center gap-3"
                                            >

                                                <div
                                                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600"
                                                >

                                                    <i
                                                        data-lucide="file-text"
                                                        class="h-6 w-6"
                                                    ></i>

                                                </div>


                                                <a
                                                    href="{{ $recentUrl }}"
                                                    target="_blank"
                                                    class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-100"
                                                >
                                                    View File
                                                </a>

                                            </div>

                                        @else

                                            <img
                                                id="recentPreview{{ $i }}"
                                                src="{{ $recentUrl }}"
                                                alt="Recent activity {{ $i }}"
                                                loading="lazy"
                                                class="h-40 w-full object-cover"
                                            >

                                        @endif


                                        {{-- Delete --}}
                                        <button
                                            type="button"
                                            class="delete-recent-image absolute right-2 top-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white text-red-600 shadow-md hover:bg-red-50"
                                            data-field="{{ $imgField }}"
                                            data-index="{{ $i }}"
                                            data-client="{{ $client->id }}"
                                            title="Remove image"
                                        >

                                            <i
                                                data-lucide="trash-2"
                                                class="h-4 w-4"
                                            ></i>

                                        </button>

                                    @else

                                        <img
                                            id="recentPreview{{ $i }}"
                                            src=""
                                            alt=""
                                            class="h-40 w-full object-cover"
                                        >

                                    @endif

                                </div>



                                {{-- IMPORTANT:
                                     Keep file input permanently in DOM.
                                     Do NOT replace it with innerHTML.
                                --}}

                                <label
                                    id="recentUploadBox{{ $i }}"
                                    for="recent_img{{ $i }}_input"
                                    class="{{ $recentPath ? 'hidden' : 'flex' }} h-40 cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-white text-center transition hover:border-blue-500 hover:bg-blue-50/40"
                                >

                                    <div
                                        class="mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-600"
                                    >

                                        <i
                                            data-lucide="upload-cloud"
                                            class="h-5 w-5"
                                        ></i>

                                    </div>


                                    <span
                                        class="text-sm font-semibold text-slate-700"
                                    >
                                        Click to upload
                                    </span>


                                    <span
                                        class="mt-1 text-xs text-slate-400"
                                    >
                                        JPG, PNG, WEBP — Max 5MB
                                    </span>

                                </label>


                                {{-- File input stays OUTSIDE preview HTML --}}
                                <input
                                    type="file"
                                    id="recent_img{{ $i }}_input"
                                    name="{{ $imgField }}"
                                    data-index="{{ $i }}"
                                    class="recent-file hidden"
                                    accept=".jpg,.jpeg,.png,.webp"
                                >

                            </div>



                            {{-- =================================================
                                 NAME
                            ================================================== --}}

                            <div class="space-y-4">

                                <div>

                                    <label
                                        class="mb-1.5 block text-xs font-medium text-slate-600"
                                    >
                                        Activity Name
                                    </label>


                                    <input
                                        type="text"
                                        name="{{ $nameField }}"
                                        value="{{ old($nameField, $client->{$nameField} ?? '') }}"
                                        class="auto-save-field w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                        placeholder="e.g. Event title {{ $i }}"
                                        @if($isRequired) required @endif
                                    >


                                    <div
                                        class="field-error mt-1 text-xs font-medium text-red-600"
                                        data-error="{{ $nameField }}"
                                    ></div>

                                </div>



                                {{-- Description --}}
                                <div>

                                    <label
                                        class="mb-1.5 block text-xs font-medium text-slate-600"
                                    >
                                        Description
                                    </label>


                                    <textarea
                                        name="{{ $paraField }}"
                                        rows="3"
                                        class="auto-save-field w-full resize-none rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                        placeholder="Briefly describe this activity..."
                                    >{{ old($paraField, $client->{$paraField} ?? '') }}</textarea>


                                    <div
                                        class="field-error mt-1 text-xs font-medium text-red-600"
                                        data-error="{{ $paraField }}"
                                    ></div>

                                </div>

                            </div>

                        </div>

                    @endfor

                </div>



                {{-- Footer --}}
                <div
                    class="flex items-center justify-between border-t border-slate-200 bg-slate-50 px-5 py-4 md:px-6"
                >

                    <p
                        id="recentLastSaved"
                        class="text-xs text-slate-500"
                    >
                        Changes are saved automatically.
                    </p>


                    <button
                        type="submit"
                        id="recentSaveButton"
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                    >

                        <i
                            data-lucide="save"
                            class="h-4 w-4"
                        ></i>

                        <span>
                            Save Activities
                        </span>

                    </button>

                </div>

            </div>

        </form>

    @endif

</div>



{{-- ================================================================
     LOADER
================================================================ --}}

<div
    id="recentLoader"
    class="fixed inset-0 z-[9998] hidden items-center justify-center bg-slate-950/20 backdrop-blur-[1px]"
>

    <div
        class="flex items-center gap-3 rounded-xl bg-white px-5 py-4 shadow-xl"
    >

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
            Saving...
        </span>

    </div>

</div>



{{-- Toast --}}
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
                'recentActivityForm'
            );


        if (!form) {
            return;
        }


        const token =
            form.querySelector(
                'input[name="_token"]'
            ).value;


        const saveButton =
            document.getElementById(
                'recentSaveButton'
            );


        const saveButtonText =
            saveButton
                ? saveButton.querySelector(
                    'span'
                )
                : null;


        let debounceTimer =
            null;


        let isSaving =
            false;


        let pendingSave =
            false;


        let pendingRefresh =
            false;


        let lastSnapshot =
            getTextSnapshot();



        /*
        |--------------------------------------------------------------------------
        | TEXT AUTO SAVE
        |--------------------------------------------------------------------------
        |
        | Auto-save name / description after user stops typing.
        | No refresh while typing.
        |--------------------------------------------------------------------------
        */

        form
            .querySelectorAll(
                '.auto-save-field'
            )
            .forEach(
                function (field) {

                    field.addEventListener(
                        'input',
                        function () {

                            clearFieldError(
                                field.name
                            );


                            clearTimeout(
                                debounceTimer
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
                    | Save when field loses focus
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
        | FILE SELECT
        |--------------------------------------------------------------------------
        |
        | Preview -> auto upload -> refresh page.
        |--------------------------------------------------------------------------
        */

        form
            .querySelectorAll(
                '.recent-file'
            )
            .forEach(
                function (input) {

                    input.addEventListener(
                        'change',
                        function () {

                            const file =
                                this.files[0];


                            const index =
                                this.dataset.index;


                            if (!file) {
                                return;
                            }



                            /*
                            | Validate file
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
                                    'Only JPG, PNG and WEBP images are allowed.',
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
                            |--------------------------------------------------------------------------
                            | PREVIEW
                            |--------------------------------------------------------------------------
                            |
                            | IMPORTANT:
                            | Input is NOT removed from DOM.
                            |--------------------------------------------------------------------------
                            */

                            previewImage(
                                index,
                                file
                            );



                            /*
                            | Auto-upload and refresh
                            */

                            saveForm(
                                true
                            );

                        }
                    );

                }
            );



        /*
        |--------------------------------------------------------------------------
        | PREVIEW IMAGE
        |--------------------------------------------------------------------------
        */

        function previewImage(
            index,
            file
        ) {

            const preview =
                document.getElementById(
                    'recentPreview' +
                    index
                );


            const previewWrap =
                document.getElementById(
                    'recentPreviewWrap' +
                    index
                );


            const uploadBox =
                document.getElementById(
                    'recentUploadBox' +
                    index
                );


            if (
                !preview ||
                !previewWrap
            ) {

                return;

            }


            const reader =
                new FileReader();


            reader.onload =
                function (event) {

                    preview.src =
                        event.target.result;


                    preview.classList.remove(
                        'hidden'
                    );


                    previewWrap.classList.remove(
                        'hidden'
                    );


                    if (uploadBox) {

                        uploadBox.classList.add(
                            'hidden'
                        );


                        uploadBox.classList.remove(
                            'flex'
                        );

                    }

                };


            reader.readAsDataURL(
                file
            );

        }



        /*
        |--------------------------------------------------------------------------
        | MANUAL SUBMIT
        |--------------------------------------------------------------------------
        */

        form.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                clearTimeout(
                    debounceTimer
                );


                /*
                | Manual save + page refresh
                */

                saveForm(
                    true
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | SAVE
        |--------------------------------------------------------------------------
        |
        | refreshPage = false:
        | text auto-save
        |
        | refreshPage = true:
        | image upload/manual save
        |--------------------------------------------------------------------------
        */

        function saveForm(
            refreshPage = false
        ) {

            const currentSnapshot =
                getTextSnapshot();



            /*
            | Nothing changed
            | unless file is selected.
            */

            const hasFile =
                Array
                    .from(
                        form.querySelectorAll(
                            '.recent-file'
                        )
                    )
                    .some(
                        function (input) {

                            return (
                                input.files &&
                                input.files.length
                            );

                        }
                    );


            if (
                !refreshPage &&
                !hasFile &&
                currentSnapshot === lastSnapshot
            ) {

                return;

            }



            /*
            | Save already running
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


            clearErrors();


            setButtonSaving(
                true
            );


            showStatus(
                'Saving...',
                'info'
            );


            showLoader();



            const formData =
                new FormData(
                    form
                );


            fetch(
                form.action,
                {

                    method:
                        'POST',

                    headers: {

                        'X-CSRF-TOKEN':
                            token,

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

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


                    hideLoader();


                    setButtonSaving(
                        false
                    );



                    /*
                    | Application-level failure
                    */

                    if (
                        data.success === false ||
                        data.status === false
                    ) {

                        showStatus(
                            data.message ||
                            data.msg ||
                            'Save failed.',
                            'danger'
                        );


                        return;

                    }



                    /*
                    | Saved
                    */

                    lastSnapshot =
                        currentSnapshot;


                    showStatus(
                        'Saved successfully.',
                        'success'
                    );


                    showToast(
                        data.message ||
                        data.msg ||
                        'Recent activity saved successfully.',
                        'success'
                    );


                    const lastSaved =
                        document.getElementById(
                            'recentLastSaved'
                        );


                    if (lastSaved) {

                        lastSaved.textContent =
                            'Last saved just now';

                    }



                    /*
                    |--------------------------------------------------------------------------
                    | AUTO REFRESH
                    |--------------------------------------------------------------------------
                    |
                    | Refresh when:
                    |
                    | - image selected/uploaded
                    | - manual Save button
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
                    | Save latest pending text
                    */

                    if (
                        pendingSave ||
                        getTextSnapshot() !==
                            lastSnapshot
                    ) {

                        pendingSave =
                            false;


                        setTimeout(
                            function () {

                                saveForm(
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


                    setButtonSaving(
                        false
                    );


                    const data =
                        error.data ||
                        {};


                    /*
                    | Laravel validation
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


                        showStatus(
                            'Please check validation errors.',
                            'danger'
                        );


                        showToast(
                            'Please check validation errors.',
                            'error'
                        );


                        return;

                    }



                    if (
                        error.status === 419
                    ) {

                        showStatus(
                            'Session expired. Please refresh page.',
                            'danger'
                        );


                        return;

                    }



                    showStatus(
                        data.message ||
                        'Save failed. Please try again.',
                        'danger'
                    );


                    showToast(
                        data.message ||
                        'Save failed. Please try again.',
                        'error'
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | DELETE IMAGE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (event) {

                const button =
                    event.target.closest(
                        '.delete-recent-image'
                    );


                if (!button) {
                    return;
                }


                event.preventDefault();


                const field =
                    button.dataset.field;


                const clientId =
                    button.dataset.client;


                if (
                    !field ||
                    !clientId
                ) {

                    return;

                }



                /*
                | Optional confirmation
                */

                if (
                    !confirm(
                        'Remove this image?'
                    )
                ) {

                    return;

                }


                showLoader();


                const deleteUrl =
                    "{{ url('business/recent') }}"
                    + '/'
                    + encodeURIComponent(field)
                    + '/'
                    + encodeURIComponent(clientId);



                fetch(
                    deleteUrl,
                    {

                        method:
                            'DELETE',

                        headers: {

                            'X-CSRF-TOKEN':
                                token,

                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'

                        }

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

                        hideLoader();


                        if (
                            data.success === false ||
                            data.status === false
                        ) {

                            throw data;

                        }


                        showToast(
                            data.message ||
                            data.msg ||
                            'Image removed successfully.',
                            'success'
                        );


                        /*
                        |--------------------------------------------------------------------------
                        | AUTO REFRESH AFTER DELETE
                        |--------------------------------------------------------------------------
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
                            'Unable to remove image.',
                            'error'
                        );

                    }
                );

            }
        );



        /*
        |--------------------------------------------------------------------------
        | FORM SNAPSHOT
        |--------------------------------------------------------------------------
        |
        | Only use text fields.
        | Do not include files in snapshot.
        |--------------------------------------------------------------------------
        */

        function getTextSnapshot() {

            const params =
                new URLSearchParams();


            form
                .querySelectorAll(
                    '.auto-save-field'
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
                        : 'Save Activities';

            }

        }



        /*
        |--------------------------------------------------------------------------
        | LOADER
        |--------------------------------------------------------------------------
        */

        function showLoader() {

            const loader =
                document.getElementById(
                    'recentLoader'
                );


            if (!loader) {
                return;
            }


            loader.classList.remove(
                'hidden'
            );


            loader.classList.add(
                'flex'
            );

        }


        function hideLoader() {

            const loader =
                document.getElementById(
                    'recentLoader'
                );


            if (!loader) {
                return;
            }


            loader.classList.add(
                'hidden'
            );


            loader.classList.remove(
                'flex'
            );

        }



        /*
        |--------------------------------------------------------------------------
        | ERRORS
        |--------------------------------------------------------------------------
        */

        function clearErrors() {

            form
                .querySelectorAll(
                    '.field-error'
                )
                .forEach(
                    function (element) {

                        element.textContent =
                            '';

                    }
                );


            form
                .querySelectorAll(
                    '.auto-save-field'
                )
                .forEach(
                    function (field) {

                        field.classList.remove(
                            'border-red-500'
                        );

                    }
                );

        }


        function clearFieldError(
            fieldName
        ) {

            const error =
                form.querySelector(
                    '[data-error="' +
                    CSS.escape(
                        fieldName
                    ) +
                    '"]'
                );


            if (error) {

                error.textContent =
                    '';

            }

        }


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
                    'border-red-500'
                );

            }


            if (error) {

                error.textContent =
                    message;

            }

        }

    }
);



/*
|--------------------------------------------------------------------------
| STATUS
|--------------------------------------------------------------------------
*/

function showStatus(
    message,
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
        'rounded-xl px-4 py-3 text-sm font-medium ' +
        (
            styles[type] ||
            styles.info
        );


    status.textContent =
        message;


    status.classList.remove(
        'hidden'
    );


    if (
        type !== 'info'
    ) {

        setTimeout(
            function () {

                status.classList.add(
                    'hidden'
                );

            },
            3000
        );

    }

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


    const classes = {

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
        `pointer-events-auto flex translate-x-4 items-center gap-3 rounded-xl border px-4 py-3 opacity-0 shadow-lg transition-all duration-300 ${classes[type] || classes.success}`;


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