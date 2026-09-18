@extends('business.business.layouts.app')

@section('title','Profile')

@section('content')

<div class="animate-fade-in max-w-5xl space-y-4 md:space-y-6">

    <div>
        <h1 class="font-display text-xl font-bold md:text-3xl">
            {{ $tabs[$tab] ?? '' }}
        </h1>
    </div>

    <div id="autoSaveStatus"></div>

    {{-- Mobile Tabs --}}
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


    @if($tab === 'seo')

        <form
            id="updateBusinessMeta"
            action="{{ route('updateBusiness.meta') }}"
            method="POST"
            class="card space-y-6 p-6"
            x-data="{
                title: @js($client->meta_title ?? ''),
                description: @js($client->meta_description ?? '')
            }"
        >

            @csrf

            <input type="hidden" name="redirect_tab" value="seo">

            <div>
                <h3 class="font-display text-lg font-semibold">
                    Search Engine Optimization
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Control how your business appears in search results.
                </p>
            </div>


            {{-- Meta Title --}}
            <div>

                <label class="mb-2 flex justify-between text-sm font-medium">

                    <span>Meta Title</span>

                    <span
                        class="text-xs text-slate-400"
                        x-text="title.length + '/60'"
                    ></span>

                </label>

                <input
                    type="text"
                    name="meta_title"
                    x-model="title"
                    maxlength="60"
                    class="form-input"
                    placeholder="Best Plumber in New York | Acme Plumbing"
                    value="{{ old('meta_title', $client->meta_title ?? '') }}"
                >

            </div>


            {{-- Meta Description --}}
            <div>

                <label class="mb-2 flex justify-between text-sm font-medium">

                    <span>Meta Description</span>

                    <span
                        class="text-xs text-slate-400"
                        x-text="description.length + '/160'"
                    ></span>

                </label>

                <textarea
                    name="meta_description"
                    x-model="description"
                    maxlength="160"
                    class="form-input form-textarea min-h-[110px]"
                    placeholder="Acme Plumbing offers 24/7 emergency services..."
                >{{ old('meta_description', $client->meta_description ?? '') }}</textarea>

            </div>


            {{-- Business Overview --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Business Overview
                </label>

                <div
                    id="overviewEditor"
                    class="bg-white"
                    style="min-height:220px;"
                ></div>

                <textarea
                    name="business_intro"
                    id="overview"
                    class="hidden"
                >{{ old('business_intro', $client->business_intro ?? '') }}</textarea>

            </div>


            <div class="flex justify-end border-t pt-5">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Save SEO Details
                </button>

            </div>

        </form>

    @endif

</div>


{{-- Toast --}}
<div
    id="toast-container"
    class="pointer-events-none fixed right-4 top-4 z-[9999] flex w-80 flex-col gap-2"
></div>


{{-- Quill CSS --}}
<link
    href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
    rel="stylesheet"
>


{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- Quill --}}
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('updateBusinessMeta');

    if (!form) return;


    /*
    |--------------------------------------------------------------------------
    | Quill Editor
    |--------------------------------------------------------------------------
    */

    const overviewField = document.getElementById('overview');

    let quill = null;


    if (
        overviewField &&
        document.getElementById('overviewEditor')
    ) {

        quill = new Quill('#overviewEditor', {

            theme: 'snow',

            placeholder:
                'Detailed history, mission, and services offered...',

            modules: {

                toolbar: [

                    [
                        {
                            header: [1, 2, 3, false]
                        }
                    ],

                    [
                        'bold',
                        'italic',
                        'underline'
                    ],

                    [
                        {
                            list: 'ordered'
                        },
                        {
                            list: 'bullet'
                        }
                    ],

                    [
                        'blockquote',
                        'code-block'
                    ],

                    [
                        'link'
                    ],

                    [
                        'clean'
                    ]

                ]

            }

        });


        /*
        | Existing database content
        */

        quill.root.innerHTML =
            overviewField.value || '';

    }



    /*
    |--------------------------------------------------------------------------
    | AJAX Form
    |--------------------------------------------------------------------------
    */

    let isSaving = false;


    form.addEventListener('submit', function (e) {

        e.preventDefault();


        /*
        | Important:
        | Copy Quill HTML into hidden textarea
        */

        if (quill && overviewField) {

            overviewField.value = quill.root.innerHTML;

        }


        saveForm();

    });



    function saveForm() {

        if (isSaving) return;

        isSaving = true;


        const submitBtn =
            form.querySelector('button[type="submit"]');


        if (submitBtn) {

            submitBtn.disabled = true;

        }


        showToast(
            'Saving...',
            'info',
            1500
        );


        /*
        | Remove old errors
        */

        $(form)
            .find('.help-block')
            .remove();


        $(form)
            .find('.has-error')
            .removeClass('has-error');


        /*
        | Serialize form
        */

        let formData =
            $(form).serialize();


        /*
        | Add Client ID
        */

        formData +=
            '&client_id={{ $client->id ?? '' }}';


        $.ajax({

            type: 'POST',

            url:
                "{{ route('updateBusiness.meta') }}",

            data: formData,

            cache: false,


            success: function (response) {

                isSaving = false;


                if (submitBtn) {

                    submitBtn.disabled = false;

                }


                showToast(
                    'Profile saved successfully',
                    'success'
                );

            },


            error: function (xhr) {

                isSaving = false;


                if (submitBtn) {

                    submitBtn.disabled = false;

                }


                let response =
                    xhr.responseJSON;


                if (
                    response &&
                    response.errors
                ) {

                    Object.keys(
                        response.errors
                    ).forEach(function (key) {

                        const input =
                            $(form).find(
                                '[name="' + key + '"]'
                            );


                        input.addClass(
                            'has-error'
                        );


                        $('<span class="help-block block mt-1 text-sm text-red-600">' +
                            response.errors[key][0] +
                        '</span>')
                        .insertAfter(input);

                    });


                    showToast(
                        'Please check validation errors',
                        'error'
                    );

                }

                else {

                    showToast(
                        'Something went wrong',
                        'error'
                    );

                }

            }

        });

    }

});


 

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
                'bg-emerald-50 border-emerald-200 text-emerald-800',

            icon:
                `<svg class="h-5 w-5 shrink-0 text-emerald-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M5 13l4 4L19 7" />
                </svg>`

        },


        error: {

            bg:
                'bg-red-50 border-red-200 text-red-800',

            icon:
                `<svg class="h-5 w-5 shrink-0 text-red-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12" />
                </svg>`

        },


        info: {

            bg:
                'bg-blue-50 border-blue-200 text-blue-800',

            icon:
                `<svg class="h-5 w-5 shrink-0 animate-spin text-blue-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">

                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 4v2m0 12v2m8-8h-2M6 12H4" />

                </svg>`

        }

    };


    const style =
        styles[type] ||
        styles.success;


    const toast =
        document.createElement('div');


    toast.className =
        `pointer-events-auto flex items-center gap-3 rounded-xl border ${style.bg} px-4 py-3 shadow-lg transition-all duration-300 translate-x-4 opacity-0`;


    toast.innerHTML = `

        ${style.icon}

        <p class="flex-1 text-sm font-medium">
            ${message}
        </p>

        <button
            type="button"
            class="shrink-0 rounded p-1"
        >
            ×
        </button>

    `;


    container.appendChild(toast);


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

</script>

@endsection