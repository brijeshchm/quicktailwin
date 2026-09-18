@extends('business.business.layouts.app')

@section('title', 'Profile')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | LOGO
    |--------------------------------------------------------------------------
    */

    $logoSrc = null;

    if (!empty($client->logo)) {

        $logoData = @unserialize($client->logo);

        if (is_array($logoData)) {
            $logoSrc = $logoData['large']['src'] ?? null;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | BANNER
    |--------------------------------------------------------------------------
    */

    $bannerSrc = null;

    if (!empty($client->profile_pic)) {

        $bannerData = @unserialize($client->profile_pic);

        if (is_array($bannerData)) {
            $bannerSrc = $bannerData['large']['src'] ?? null;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | GALLERY
    |--------------------------------------------------------------------------
    */

    $picture = [];

    if (!empty($client->pictures)) {

        $pictureData = @unserialize($client->pictures);

        if (is_array($pictureData)) {
            $picture = $pictureData;
        }
    }


    /*
    | Always prepare 21 slots
    */

    for ($i = 0; $i < 21; $i++) {

        if (!isset($picture[$i])) {
            $picture[$i] = [];
        }

        if (!isset($picture[$i]['large'])) {
            $picture[$i]['large'] = [];
        }

        $picture[$i]['large']['name'] =
            $picture[$i]['large']['name'] ?? '';

        $picture[$i]['large']['src'] =
            $picture[$i]['large']['src'] ?? '';
    }

@endphp

 


<div class="animate-fade-in max-w-5xl space-y-6">

    {{-- PAGE HEADING --}}
    <div>

        <h1
            class="font-display text-xl font-bold text-slate-900 md:text-3xl"
        >
            {{ $tabs[$tab] ?? 'Media & Gallery' }}
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Manage your business logo, banner and gallery pictures.
        </p>

    </div>

 <div class="md:hidden"><select onchange="window.location=this.value" class="form-input h-12 bg-white text-base font-medium shadow-sm">
    
 @foreach($tabs as $key=>$label)
    
 <option value="{{ route('profile',['tab'=>$key]) }}" @selected($tab===$key)>{{ $label }}</option>@endforeach</select>

</div>

    {{-- ============================================================
         BRAND IDENTITY
    ============================================================= --}}

    <div
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        <div class="border-b border-slate-200 px-5 py-4 md:px-6">

            <h2 class="text-lg font-semibold text-slate-900">
                Brand Identity
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Upload your business logo and cover banner.
            </p>

        </div>


        <div class="grid gap-6 p-5 md:grid-cols-2 md:p-6">


            {{-- ====================================================
                 LOGO
            ===================================================== --}}

            <div>

                <div class="mb-2 flex items-center justify-between">

                    <label class="text-sm font-semibold text-slate-700">
                        Business Logo
                    </label>

                    <span class="text-xs text-slate-400">
                        Square recommended
                    </span>

                </div>


                <div
                    id="logoSlot"
                    class="brand-slot relative flex h-52 items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 transition hover:border-blue-400"
                    data-type="logo"
                    data-field="logo"
                    data-client-id="{{ $client->id }}"
                    data-delete-url="{{ url('business/profileLogo/logoDel/'.$client->id) }}"
                >

                    @if($logoSrc)

                        <img
                            src="{{ asset('/'.$logoSrc) }}"
                            alt="Business Logo"
                            class="brand-image h-full w-full bg-white object-contain p-4"
                        >

                        <button
                            type="button"
                            class="brand-delete absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-xl bg-white text-red-600 shadow-lg transition hover:bg-red-50"
                            title="Delete Logo"
                        >

                            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>

                        </button>

                    @else

                        <label
                            class="brand-upload-label flex h-full w-full cursor-pointer flex-col items-center justify-center gap-3 p-6 text-center"
                        >

                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-50 text-blue-600"
                            >

                               <svg
                                class="h-7 w-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3"
                                />
                            </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-slate-700">
                                    Upload Logo
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    Click to choose image
                                </p>

                            </div>

                            <input
                                type="file"
                                class="brand-file hidden"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                        </label>

                    @endif

                </div>


                <p class="mt-2 text-xs text-slate-400">
                    JPG, JPEG, PNG or WEBP. Maximum 5 MB.
                </p>

            </div>



            {{-- ====================================================
                 BANNER
            ===================================================== --}}

            <div>

                <div class="mb-2 flex items-center justify-between">

                    <label class="text-sm font-semibold text-slate-700">
                        Cover Banner
                    </label>

                    <span class="text-xs text-slate-400">
                        Landscape recommended
                    </span>

                </div>


                <div
                    id="bannerSlot"
                    class="brand-slot relative flex h-52 items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 transition hover:border-blue-400"
                    data-type="banner"
                    data-field="profile_pic"
                    data-client-id="{{ $client->id }}"
                    data-delete-url="{{ url('business/profileLogo/profilePicDel/'.$client->id) }}"
                >

                    @if($bannerSrc)

                        <img
                            src="{{ asset('/'.$bannerSrc) }}"
                            alt="Cover Banner"
                            class="brand-image h-full w-full object-cover"
                        >

                        <button
                            type="button"
                            class="brand-delete absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-xl bg-white text-red-600 shadow-lg transition hover:bg-red-50"
                            title="Delete Banner"
                        >

                            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>

                        </button>

                    @else

                        <label
                            class="brand-upload-label flex h-full w-full cursor-pointer flex-col items-center justify-center gap-3 p-6 text-center"
                        >

                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-50 text-blue-600"
                            >

                              <svg
                                class="h-7 w-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3"
                                />
                            </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-slate-700">
                                    Upload Cover Banner
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    Click to choose image
                                </p>

                            </div>

                            <input
                                type="file"
                                class="brand-file hidden"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                        </label>

                    @endif

                </div>


                <p class="mt-2 text-xs text-slate-400">
                    JPG, JPEG, PNG or WEBP. Maximum 5 MB.
                </p>

            </div>

        </div>

    </div>



    {{-- ============================================================
         BUSINESS GALLERY
    ============================================================= --}}

    <div
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        <div
            class="flex items-center gap-3 border-b border-slate-200 px-5 py-4 md:px-6"
        >

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
            >

                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>

            </div>


            <div>

                <h2 class="font-semibold text-slate-900">
                    Business Gallery
                </h2>

                <p class="text-xs text-slate-500">
                    Upload up to 21 business pictures.
                </p>

            </div>

        </div>



        <form
            id="imageform"
            method="POST"
            enctype="multipart/form-data"
            class="p-4 md:p-6"
        >

            @csrf

            <input
                type="hidden"
                name="business_id"
                value="{{ $client->id }}"
            >


            <div
                id="galleryGrid"
                data-client-id="{{ $client->id }}"
                class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"
            >

                @for($i = 0; $i < 21; $i++)

                    @php

                        $slot = $i + 1;

                        $imageSrc =
                            $picture[$i]['large']['src'] ?? '';

                        $hasImage =
                            !empty($imageSrc);

                    @endphp


                    <div
                        id="image{{ $slot }}"
                        class="gallery-slot relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-3 transition hover:border-blue-300 hover:shadow-sm"
                        data-slot="{{ $slot }}"
                    >

                        {{-- SLOT HEADER --}}
                        <div
                            class="mb-2 flex items-center justify-between"
                        >

                            <span class="text-xs font-medium text-slate-500">
                                Image {{ $slot }}
                            </span>

                        </div>



                        {{-- PREVIEW --}}
                        <div
                            id="previewWrap{{ $slot }}"
                            class="{{ $hasImage ? '' : 'hidden' }}"
                        >

                            <div
                                class="group relative overflow-hidden rounded-xl bg-white"
                            >

                                <img
                                    id="preview{{ $slot }}"
                                    src="{{ $hasImage ? asset('/'.$imageSrc) : '' }}"
                                    alt="Gallery image {{ $slot }}"
                                    class="h-44 w-full object-cover"
                                >


                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-slate-950/0 transition group-hover:bg-slate-950/30"
                                >

                                    <button
                                        type="button"
                                        class="remove-thumbnail invisible flex h-10 w-10 scale-90 items-center justify-center rounded-full bg-red-600 text-white opacity-0 shadow-lg transition hover:bg-red-700 group-hover:visible group-hover:scale-100 group-hover:opacity-100"
                                        data-slot="{{ $slot }}"
                                        title="Remove Image"
                                    >

                                        <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>

                                    </button>

                                </div>

                            </div>

                        </div>



                        {{-- UPLOAD BOX --}}
                        <label
                            id="dropzone{{ $slot }}"
                            for="imageInput{{ $slot }}"
                            class="{{ $hasImage ? 'hidden' : 'flex' }} min-h-[176px] cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-white px-4 py-6 text-center transition hover:border-blue-500 hover:bg-blue-50/40"
                        >

                            <div
                                class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-blue-600"
                            >

                                <svg
                                class="h-7 w-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3"
                                />
                            </svg>

                            </div>


                            <p class="text-sm font-semibold text-slate-700">
                                Click to upload
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                or drag & drop
                            </p>

                            <p class="mt-2 text-[11px] text-slate-400">
                                JPG, PNG, WEBP, SVG
                            </p>


                            <input
                                type="file"
                                id="imageInput{{ $slot }}"
                                name="image{{ $slot }}"
                                class="gallery-file hidden"
                                data-slot="{{ $slot }}"
                                accept=".jpg,.jpeg,.png,.webp,.svg"
                            >

                        </label>


                        <input
                            type="hidden"
                            name="remove_image{{ $slot }}"
                            id="remove_flag_{{ $slot }}"
                            value="0"
                        >

                    </div>

                @endfor

            </div>

        </form>

    </div>

</div>



{{-- ================================================================
     BRAND EMPTY TEMPLATE
================================================================ --}}

<template id="brandEmptyTemplate">

    <label
        class="brand-upload-label flex h-full w-full cursor-pointer flex-col items-center justify-center gap-3 p-6 text-center"
    >

        <div
            class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-50 text-blue-600"
        >

            <svg
                class="h-7 w-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3"
                />
            </svg>

        </div>


        <div>

            <p
                class="brand-upload-title text-sm font-semibold text-slate-700"
            >
                Upload Image
            </p>

            <p class="mt-1 text-xs text-slate-400">
                Click to choose image
            </p>

        </div>


        <input
            type="file"
            class="brand-file hidden"
            accept=".jpg,.jpeg,.png,.webp"
        >

    </label>

</template>



{{-- LOADING TEMPLATE --}}
<template id="brandLoadingTemplate">

    <div
        class="flex h-full w-full flex-col items-center justify-center gap-3"
    >

        <svg
            class="h-8 w-8 animate-spin text-blue-600"
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

        <span class="text-sm font-medium text-slate-500">
            Saving...
        </span>

    </div>

</template>



{{-- ================================================================
     TOAST
================================================================ --}}

<div
    id="toast-container"
    class="pointer-events-none fixed right-4 top-4 z-[9999] flex w-80 max-w-[calc(100%-2rem)] flex-col gap-2"
></div>



{{-- ================================================================
     GALLERY LOADER
================================================================ --}}

<div
    id="galleryLoader"
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
            Saving image...
        </span>

    </div>

</div>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const csrfToken =
        document.querySelector(
            'meta[name="csrf-token"]'
        ).content;


    /*
    |--------------------------------------------------------------------------
    | LOGO + BANNER UPLOAD ROUTE
    |--------------------------------------------------------------------------
    */

    const brandUploadUrl =
        "{{ route('profile.logo.upload') }}";



    /*
    |--------------------------------------------------------------------------
    | LOGO + BANNER
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.brand-slot')
        .forEach(function (slot) {

            /*
            |--------------------------------------------------------------------------
            | UPLOAD
            |--------------------------------------------------------------------------
            */

            slot.addEventListener(
                'change',
                async function (event) {

                    const input =
                        event.target.closest(
                            '.brand-file'
                        );


                    if (
                        !input ||
                        !input.files.length
                    ) {
                        return;
                    }


                    const file =
                        input.files[0];


                    const type =
                        slot.dataset.type;


                    const field =
                        slot.dataset.field;


                    const clientId =
                        slot.dataset.clientId;



                    /*
                    | File validation
                    */

                    const validTypes = [

                        'image/jpeg',
                        'image/png',
                        'image/webp'

                    ];


                    if (
                        !validTypes.includes(
                            file.type
                        )
                    ) {

                        showToast(
                            'Only JPG, PNG and WEBP images are allowed.',
                            'error'
                        );

                        input.value = '';

                        return;
                    }


                    if (
                        file.size >
                        5 * 1024 * 1024
                    ) {

                        showToast(
                            'Image must be less than 5 MB.',
                            'error'
                        );

                        input.value = '';

                        return;
                    }



                    /*
                    |--------------------------------------------------------------------------
                    | Local preview URL
                    |--------------------------------------------------------------------------
                    */

                    const previewUrl =
                        URL.createObjectURL(
                            file
                        );



                    /*
                    |--------------------------------------------------------------------------
                    | FORM DATA
                    |--------------------------------------------------------------------------
                    |
                    | Logo sends:
                    | logo => file
                    |
                    | Banner sends:
                    | profile_pic => file
                    |--------------------------------------------------------------------------
                    */

                    const formData =
                        new FormData();


                    formData.append(
                        field,
                        file
                    );


                    formData.append(
                        'type',
                        type
                    );


                    formData.append(
                        'business_id',
                        clientId
                    );



                    renderBrandLoading(
                        slot
                    );


                    try {

                        const response =
                            await fetch(
                                brandUploadUrl,
                                {

                                    method: 'POST',

                                    headers: {

                                        'X-CSRF-TOKEN':
                                            csrfToken,

                                        'Accept':
                                            'application/json'

                                    },

                                    body:
                                        formData

                                }
                            );


                        const data =
                            await response
                                .json()
                                .catch(
                                    function () {
                                        return {};
                                    }
                                );


                        if (
                            !response.ok ||
                            data.status === false
                        ) {

                            throw data;

                        }


                        /*
                        | Prefer server URL.
                        | If controller doesn't return src,
                        | use local preview.
                        */

                        const imageUrl =
                            data.src ||
                            data.url ||
                            previewUrl;


                        renderBrandImage(
                            slot,
                            imageUrl,
                            type
                        );


                        showToast(
                            data.msg ||
                            data.message ||
                            (
                                type === 'logo'
                                    ? 'Logo uploaded successfully.'
                                    : 'Banner uploaded successfully.'
                            ),
                            'success'
                        );

                    }

                    catch (error) {

                        renderBrandEmpty(
                            slot,
                            type
                        );


                        let message =
                            'Upload failed.';


                        if (
                            error &&
                            error.errors
                        ) {

                            const key =
                                Object.keys(
                                    error.errors
                                )[0];


                            if (
                                key &&
                                error.errors[key]
                            ) {

                                message =
                                    error.errors[key][0];

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
                            'error'
                        );

                    }

                }
            );



            /*
            |--------------------------------------------------------------------------
            | DELETE LOGO/BANNER
            |--------------------------------------------------------------------------
            */

            slot.addEventListener(
                'click',
                async function (event) {

                    const button =
                        event.target.closest(
                            '.brand-delete'
                        );


                    if (!button) {
                        return;
                    }


                    event.preventDefault();


                    const type =
                        slot.dataset.type;


                    const deleteUrl =
                        slot.dataset.deleteUrl;


                    /*
                    | Save old image in case delete fails
                    */

                    const oldImage =
                        slot.querySelector(
                            '.brand-image'
                        );


                    const oldSrc =
                        oldImage
                            ? oldImage.src
                            : '';


                    renderBrandLoading(
                        slot
                    );


                    try {

                        const response =
                            await fetch(
                                deleteUrl,
                                {

                                    method: 'GET',

                                    headers: {

                                        'Accept':
                                            'application/json',

                                        'X-CSRF-TOKEN':
                                            csrfToken

                                    }

                                }
                            );


                        const data =
                            await response
                                .json()
                                .catch(
                                    function () {

                                        return {
                                            status: true
                                        };

                                    }
                                );


                        if (!response.ok) {

                            throw data;

                        }


                        renderBrandEmpty(
                            slot,
                            type
                        );


                        showToast(
                            data.msg ||
                            data.message ||
                            (
                                type === 'logo'
                                    ? 'Logo removed successfully.'
                                    : 'Banner removed successfully.'
                            ),
                            'success'
                        );

                    }

                    catch (error) {

                        if (oldSrc) {

                            renderBrandImage(
                                slot,
                                oldSrc,
                                type
                            );

                        }

                        else {

                            renderBrandEmpty(
                                slot,
                                type
                            );

                        }


                        showToast(
                            'Unable to remove image.',
                            'error'
                        );

                    }

                }
            );

        });



    /*
    |--------------------------------------------------------------------------
    | BRAND IMAGE RENDER
    |--------------------------------------------------------------------------
    */

    function renderBrandImage(
        slot,
        src,
        type
    ) {

        const imageClass =
            type === 'logo'
                ? 'object-contain bg-white p-4'
                : 'object-cover';


        slot.innerHTML = `

            <img
                src="${escapeAttribute(src)}"
                alt="${type === 'logo' ? 'Business Logo' : 'Cover Banner'}"
                class="brand-image h-full w-full ${imageClass}"
            >

            <button
                type="button"
                class="brand-delete absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-xl bg-white text-red-600 shadow-lg transition hover:bg-red-50"
                title="Delete"
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

        `;

    }



    /*
    |--------------------------------------------------------------------------
    | BRAND EMPTY RENDER
    |--------------------------------------------------------------------------
    */

    function renderBrandEmpty(
        slot,
        type
    ) {

        const template =
            document.getElementById(
                'brandEmptyTemplate'
            );


        slot.innerHTML = '';


        slot.appendChild(
            template.content.cloneNode(
                true
            )
        );


        const title =
            slot.querySelector(
                '.brand-upload-title'
            );


        if (title) {

            title.textContent =
                type === 'logo'
                    ? 'Upload Logo'
                    : 'Upload Cover Banner';

        }

    }



    /*
    |--------------------------------------------------------------------------
    | BRAND LOADING
    |--------------------------------------------------------------------------
    */

    function renderBrandLoading(
        slot
    ) {

        const template =
            document.getElementById(
                'brandLoadingTemplate'
            );


        slot.innerHTML = '';


        slot.appendChild(
            template.content.cloneNode(
                true
            )
        );

    }



    /*
    |--------------------------------------------------------------------------
    |--------------------------------------------------------------------------
    | GALLERY
    |--------------------------------------------------------------------------
    |--------------------------------------------------------------------------
    */

    const galleryForm =
        document.getElementById(
            'imageform'
        );


    let galleryTimer = null;

    let gallerySaving = false;

    let galleryPending = false;



    /*
    |--------------------------------------------------------------------------
    | GALLERY FILE CHANGE
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.gallery-file'
        )
        .forEach(
            function (input) {

                input.addEventListener(
                    'change',
                    function () {

                        const file =
                            this.files[0];


                        const slot =
                            this.dataset.slot;


                        if (!file) {
                            return;
                        }



                        /*
                        | Validate image
                        */

                        if (
                            !file.type.startsWith(
                                'image/'
                            )
                        ) {

                            showToast(
                                'Please select a valid image.',
                                'error'
                            );

                            this.value = '';

                            return;
                        }


                        /*
                        | 10 MB gallery limit
                        */

                        if (
                            file.size >
                            10 * 1024 * 1024
                        ) {

                            showToast(
                                'Gallery image must be less than 10 MB.',
                                'error'
                            );

                            this.value = '';

                            return;
                        }



                        /*
                        | If replacing after delete,
                        | cancel delete flag.
                        */

                        const removeFlag =
                            document.getElementById(
                                'remove_flag_' + slot
                            );


                        if (removeFlag) {

                            removeFlag.value =
                                '0';

                        }



                        /*
                        | Instant preview
                        */

                        previewGalleryImage(
                            slot,
                            file
                        );



                        clearTimeout(
                            galleryTimer
                        );


                        galleryTimer =
                            setTimeout(
                                saveGallery,
                                700
                            );

                    }
                );

            }
        );



    /*
    |--------------------------------------------------------------------------
    | DRAG DROP
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '[id^="dropzone"]'
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


                        const slot =
                            this.id.replace(
                                'dropzone',
                                ''
                            );


                        const input =
                            document.getElementById(
                                'imageInput' + slot
                            );


                        if (
                            !input ||
                            !event.dataTransfer.files.length
                        ) {
                            return;
                        }


                        /*
                        | Transfer dropped file
                        */

                        const transfer =
                            new DataTransfer();


                        transfer.items.add(
                            event.dataTransfer.files[0]
                        );


                        input.files =
                            transfer.files;


                        input.dispatchEvent(
                            new Event(
                                'change',
                                {
                                    bubbles: true
                                }
                            )
                        );

                    }
                );

            }
        );



    /*
    |--------------------------------------------------------------------------
    | DELETE GALLERY IMAGE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            const button =
                event.target.closest(
                    '.remove-thumbnail'
                );


            if (!button) {
                return;
            }


            const slot =
                button.dataset.slot;


            const flag =
                document.getElementById(
                    'remove_flag_' + slot
                );


            const preview =
                document.getElementById(
                    'preview' + slot
                );


            const previewWrap =
                document.getElementById(
                    'previewWrap' + slot
                );


            const dropzone =
                document.getElementById(
                    'dropzone' + slot
                );


            const input =
                document.getElementById(
                    'imageInput' + slot
                );


            /*
            | Mark for delete
            */

            if (flag) {

                flag.value =
                    '1';

            }


            /*
            | Clear selected file
            */

            if (input) {

                input.value =
                    '';

            }


            /*
            | Hide preview
            */

            if (preview) {

                preview.src =
                    '';

            }


            if (previewWrap) {

                previewWrap.classList.add(
                    'hidden'
                );

            }


            /*
            | Show upload box again
            */

            if (dropzone) {

                dropzone.classList.remove(
                    'hidden'
                );


                dropzone.classList.add(
                    'flex'
                );

            }



            clearTimeout(
                galleryTimer
            );


            galleryTimer =
                setTimeout(
                    saveGallery,
                    300
                );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | GALLERY PREVIEW
    |--------------------------------------------------------------------------
    */

    function previewGalleryImage(
        slot,
        file
    ) {

        const preview =
            document.getElementById(
                'preview' + slot
            );


        const previewWrap =
            document.getElementById(
                'previewWrap' + slot
            );


        const dropzone =
            document.getElementById(
                'dropzone' + slot
            );


        if (
            !preview ||
            !previewWrap ||
            !dropzone
        ) {
            return;
        }


        const reader =
            new FileReader();


        reader.onload =
            function (event) {

                preview.src =
                    event.target.result;


                previewWrap.classList.remove(
                    'hidden'
                );


                dropzone.classList.add(
                    'hidden'
                );


                dropzone.classList.remove(
                    'flex'
                );

            };


        reader.readAsDataURL(
            file
        );

    }



    /*
    |--------------------------------------------------------------------------
    | SAVE GALLERY
    |--------------------------------------------------------------------------
    */

    function saveGallery() {

        if (!galleryForm) {
            return;
        }


        if (gallerySaving) {

            galleryPending =
                true;

            return;
        }


        gallerySaving =
            true;


        galleryPending =
            false;


        const formData =
            new FormData(
                galleryForm
            );


        showGalleryLoader();


        fetch(
            "{{ url('business/saveGallary') }}",
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

                gallerySaving =
                    false;


                hideGalleryLoader();


                if (
                    data.status === false
                ) {

                    showToast(
                        data.msg ||
                        'Unable to save gallery.',
                        'error'
                    );

                    return;

                }


                showToast(
                    data.msg ||
                    'Gallery saved successfully.',
                    'success'
                );



                /*
                | Clear delete flags after successful save
                */

                document
                    .querySelectorAll(
                        'input[id^="remove_flag_"]'
                    )
                    .forEach(
                        function (flag) {

                            flag.value =
                                '0';

                        }
                    );



                /*
                | Clear browser selected files.
                */

                document
                    .querySelectorAll(
                        '.gallery-file'
                    )
                    .forEach(
                        function (input) {

                            input.value =
                                '';

                        }
                    );



                /*
                | Another change happened
                | while save was running.
                */

                if (
                    galleryPending
                ) {

                    galleryPending =
                        false;


                    setTimeout(
                        saveGallery,
                        300
                    );

                }

            }
        )

        .catch(
            function (error) {

                gallerySaving =
                    false;


                hideGalleryLoader();


                let message =
                    'Something went wrong while saving gallery.';


                if (
                    error &&
                    error.errors
                ) {

                    const errors =
                        Object.values(
                            error.errors
                        );


                    if (
                        errors.length &&
                        errors[0].length
                    ) {

                        message =
                            errors[0][0];

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
    | LOADER
    |--------------------------------------------------------------------------
    */

    function showGalleryLoader() {

        const loader =
            document.getElementById(
                'galleryLoader'
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


    function hideGalleryLoader() {

        const loader =
            document.getElementById(
                'galleryLoader'
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



function escapeAttribute(
    value
) {

    return String(
        value || ''
    )
    .replaceAll(
        '&',
        '&amp;'
    )
    .replaceAll(
        '"',
        '&quot;'
    )
    .replaceAll(
        '<',
        '&lt;'
    )
    .replaceAll(
        '>',
        '&gt;'
    );

}

</script>

@endsection