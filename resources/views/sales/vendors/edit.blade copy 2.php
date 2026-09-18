<x-layouts.sales.app
    :title="($isCreating ? 'Add vendor' : 'Edit '.$vendor->business_name).' · Vendorflow'"
    header="Vendor editor"
>

@php

    /*
    |--------------------------------------------------------------------------
    | Sidebar Sections
    |--------------------------------------------------------------------------
    */

    $sections = [
        'personal-details'      => 'Personal Details',
        'business-information'  => 'Business Information',
        'business-meta'         => 'Business Meta',
        'business-overview'     => 'Business Overview',
        'faqs'                  => 'FAQs',
        'business-location'     => 'Business Location',
        'company-logo'          => 'Company Logo',
        'gallery'               => 'Gallery',
        'certificates'          => 'Certificates',
        'awards'                => 'Awards',
        'recent-activity'       => 'Recent Activity',
        'assigned-keywords'     => 'Assigned Keywords',
        'account-settings'      => 'Account Settings',
        'leads'                 => 'Leads',
        'discussion'            => 'Discussion',
        'payment-orders'        => 'Payment Orders',
    ];

    /*
    |--------------------------------------------------------------------------
    | Default Active Tab
    |--------------------------------------------------------------------------
    */

    $activeSection = request('section', 'personal-details');

@endphp

<style>

[x-cloak] {
    display: none !important;
}


/*
|--------------------------------------------------------------------------
| Mobile horizontal tabs
|--------------------------------------------------------------------------
*/

.editor-tabs-scroll,
.vendor-tabs-scroll {
    width: 100%;
    max-width: 100%;

    overflow-x: auto !important;
    overflow-y: hidden !important;

    -webkit-overflow-scrolling: touch;

    scrollbar-width: none;

    scroll-behavior: smooth;

    touch-action: pan-x;
}

.editor-tabs-scroll::-webkit-scrollbar,
.vendor-tabs-scroll::-webkit-scrollbar {
    display: none;
}


/*
|--------------------------------------------------------------------------
| Inputs
|--------------------------------------------------------------------------
*/

.vendor-input {
    display: block;

    width: 100%;
    min-width: 0;

    height: 44px;

    margin-top: 8px;

    padding: 0 12px;

    border: 1px solid #dfe7ec;

    border-radius: 8px;

    background: #fff;

    color: #243746;

    font-size: 16px;

    outline: none;
}

.vendor-input:focus {
    border-color: #315b80;

    box-shadow:
        0 0 0 4px
        rgba(49, 91, 128, 0.10);
}


.vendor-textarea {
    display: block;

    width: 100%;
    min-width: 0;

    margin-top: 8px;

    padding: 12px;

    border: 1px solid #dfe7ec;

    border-radius: 8px;

    background: #fff;

    color: #243746;

    font-size: 16px;

    line-height: 1.5;

    resize: vertical;

    outline: none;
}

.vendor-textarea:focus {
    border-color: #315b80;

    box-shadow:
        0 0 0 4px
        rgba(49, 91, 128, 0.10);
}


@media (min-width: 640px) {

    .vendor-input,
    .vendor-textarea {
        font-size: 14px;
    }

}

</style>
<div
    x-data="vendorEditor()"
    class="w-full min-w-0 space-y-4 px-3 sm:px-4 lg:px-0"
>

    {{-- PAGE HEADER --}}
    <div class="flex min-w-0 flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div class="min-w-0">

            <a
                href="{{ route('sales.vendors.index') }}"
                class="text-xs font-semibold text-[#315b80] hover:underline"
            >
                ← Back to vendors
            </a>

            <h1
                class="mt-3 font-display text-2xl font-semibold tracking-[-0.04em]"
            >
                {{ $isCreating ? 'Add vendor' : $vendor->business_name }}
            </h1>

            <p class="mt-1 text-sm text-[#718394]">

                {{ $isCreating
                    ? 'Create a vendor profile for review.'
                    : 'Keep this profile, its activity, and its account health current.'
                }}

            </p>

        </div>


       @if (!$isCreating)

        <div class="flex shrink-0">

            <span
                class="
                    rounded-full
                    bg-[#e4f4eb]
                    px-3 py-1.5
                    text-xs
                    font-semibold
                    text-[#26734b]
                "
            >
                {{ ucfirst($vendor->status) }}
            </span>

        </div>

    @endif

    </div>


    {{-- VENDOR TOP TABS --}}
    @if(!$isCreating)

    

 

    <div
        data-vendor-tabs
        data-current-id="{{ $vendor->id }}"
        data-vendors='@json($tabVendors)'
        class="
            vendor-tabs-scroll
            flex
            max-w-full
            gap-2
            overflow-x-auto
            overscroll-x-contain
            pb-2
        "
    ></div>
 

    @endif

<div
    class="
        grid
        w-full
        min-w-0
        grid-cols-1
        gap-4
        overflow-hidden

        lg:grid-cols-[230px_minmax(0,1fr)]
        lg:gap-5
    "
> 

    


        {{-- ====================================================== --}}
        {{-- LEFT SIDEBAR --}}
        {{-- ====================================================== --}}

   
<aside
    class="
        w-full
        min-w-0
        max-w-full
        overflow-hidden
        rounded-xl
        border border-[#dfe7ec]
        bg-white
        p-2
        shadow-[0_5px_18px_rgba(18,38,58,0.035)]

        sm:rounded-2xl
        sm:p-3

        lg:sticky
        lg:top-4
        lg:h-fit
    "
>
    <p
        class="
            mb-2
            hidden
            px-2
            text-[10px]
            font-semibold
            uppercase
            tracking-[0.12em]
            text-[#9aa9b5]

            lg:block
        "
    >
        Editor sections
    </p>

    <div
        x-ref="editorTabs"
        class="
            editor-tabs-scroll
            flex
            w-full
            min-w-0
            max-w-full
            touch-pan-x
            gap-2
            overflow-x-auto
            overflow-y-hidden
            overscroll-x-contain
            scroll-smooth
            pb-2

            lg:block
            lg:overflow-visible
            lg:pb-0
        "
    >
        @foreach ($sections as $key => $section)

            <button
                type="button"

                @click="openSection('{{ $key }}', $event)"

                class="
                    mb-0
                    inline-flex
                    min-h-10
                    flex-none
                    shrink-0
                    items-center
                    justify-center
                    whitespace-nowrap
                    rounded-lg
                    px-3
                    py-2
                    text-xs
                    font-medium
                    transition

                    lg:mb-1
                    lg:flex
                    lg:w-full
                    lg:justify-start
                    lg:px-2.5
                    lg:text-left
                "

                :class="
                    activeSection === '{{ $key }}'
                        ? 'bg-[#315b80] text-white shadow-sm'
                        : 'text-[#718394] hover:bg-[#e9f2f7] hover:text-[#315b80]'
                "
            >
                {{ $section }}
            </button>

        @endforeach
    </div>
</aside>


        {{-- ====================================================== --}}
        {{-- MAIN FORM --}}
        {{-- ====================================================== --}}

        <form
    id="vendorEditorForm"
    method="POST"
    action="{{ $isCreating
        ? route('sales.vendors.store')
        : route('sales.vendors.update', $vendor)
    }}"
    class="
        w-full
        min-w-0
        max-w-full
        overflow-hidden
        rounded-xl
        border border-[#dfe7ec]
        bg-white
        shadow-[0_5px_18px_rgba(18,38,58,0.035)]

        sm:rounded-2xl
    "
>

            @csrf

            @if (!$isCreating)
                @method('PUT')
            @endif



            {{-- ================================================== --}}
            {{-- PERSONAL DETAILS --}}
            {{-- ================================================== --}}

            <section
                x-show="activeSection === 'personal-details'"
                x-cloak
            >

                <x-editor-heading
                    title="Personal Details"
                    subtitle="Vendor owner and contact information."
                />

                <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-7">


                    {{-- Owner Name --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Owner name
                        </label>

                        <input
                            type="text"
                            name="owner_name"
                            value="{{ old('owner_name', $vendor->owner_name) }}"
                            class="vendor-input"
                        >

                    </div>


                    {{-- Owner Email --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Owner email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $vendor->email) }}"
                            class="vendor-input"
                        >

                    </div>


                    {{-- Primary Mobile --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Primary mobile
                        </label>

                        <input
                            type="text"
                            name="mobile"
                            value="{{ old('mobile', $vendor->mobile) }}"
                            class="vendor-input"
                        >

                    </div>


                    {{-- Alternate Mobile --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Alternate mobile
                        </label>

                        <input
                            type="text"
                            name="alternate_mobile"
                            value="{{ old('alternate_mobile', $vendor->alternate_mobile) }}"
                            class="vendor-input"
                        >

                    </div>


                    {{-- WhatsApp --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            WhatsApp
                        </label>

                        <input
                            type="text"
                            name="whatsapp"
                            value="{{ old('whatsapp', $vendor->whatsapp) }}"
                            class="vendor-input"
                        >

                    </div>

                </div>

            </section>



            {{-- ================================================== --}}
            {{-- BUSINESS INFORMATION --}}
            {{-- ================================================== --}}

            <section
                x-show="activeSection === 'business-information'"
                x-cloak
            >

                <div class="border-b border-[#edf1f3] p-5 sm:p-7">

                    <p
                        class="
                            text-[10px]
                            font-semibold
                            uppercase
                            tracking-[0.16em]
                            text-[#a14f47]
                        "
                    >
                        Profile essentials
                    </p>

                    <h2
                        class="
                            mt-2
                            font-display
                            text-2xl
                            font-semibold
                            tracking-[-0.04em]
                        "
                    >
                        Business Information
                    </h2>

                    <p class="mt-1 max-w-2xl text-sm leading-6 text-[#718394]">
                        Basic information about the vendor business.
                    </p>

                </div>


                <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-7">


                    {{-- Business Name --}}
                    <div class="sm:col-span-2">

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Business name
                        </label>

                        <input
                            type="text"
                            name="business_name"
                            value="{{ old('business_name', $vendor->business_name) }}"
                            class="vendor-input"
                        >

                    </div>


                    {{-- Business Email --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Business email
                        </label>

                        <input
                            type="email"
                            name="business_email"
                            value="{{ old('business_email', $vendor->business_email) }}"
                            class="vendor-input"
                        >

                    </div>


                    {{-- Category --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Category
                        </label>

                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $vendor->category) }}"
                            class="vendor-input"
                        >

                    </div>


                    {{-- Website --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Website
                        </label>

                        <input
                            type="url"
                            name="website"
                            value="{{ old('website', $vendor->website) }}"
                            placeholder="https://example.com"
                            class="vendor-input"
                        >

                    </div>


                    {{-- Business Hours --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Business hours
                        </label>

                        <input
                            type="text"
                            name="business_hours"
                            value="{{ old('business_hours', $vendor->business_hours) }}"
                            placeholder="09:00 AM - 06:00 PM"
                            class="vendor-input"
                        >

                    </div>


                    {{-- Status --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Status
                        </label>

                        <select
                            name="status"
                            class="vendor-input"
                        >

                            <option
                                value="active"
                                @selected(old('status', $vendor->status) === 'active')
                            >
                                Active
                            </option>

                            <option
                                value="pending"
                                @selected(old('status', $vendor->status) === 'pending')
                            >
                                Pending
                            </option>

                            <option
                                value="inactive"
                                @selected(old('status', $vendor->status) === 'inactive')
                            >
                                Inactive
                            </option>

                            <option
                                value="suspended"
                                @selected(old('status', $vendor->status) === 'suspended')
                            >
                                Suspended
                            </option>

                        </select>

                    </div>


                    {{-- Sales Executive --}}
                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Sales executive
                        </label>

                        <input
                            type="text"
                            name="sales_executive"
                            value="{{ old('sales_executive', $vendor->sales_executive) }}"
                            class="vendor-input"
                        >

                    </div>

                </div>

            </section>



            {{-- ================================================== --}}
            {{-- BUSINESS META --}}
            {{-- ================================================== --}}

            <section
                x-show="activeSection === 'business-meta'"
                x-cloak
            >

                <div class="border-b border-[#edf1f3] p-5 sm:p-7">

                    <p
                        class="
                            text-[10px]
                            font-semibold
                            uppercase
                            tracking-[0.16em]
                            text-[#a14f47]
                        "
                    >
                        Search Engine
                    </p>

                    <h2 class="mt-2 font-display text-2xl font-semibold">
                        Business Meta
                    </h2>

                    <p class="mt-1 text-sm text-[#718394]">
                        Manage SEO title, description and keywords.
                    </p>

                </div>


                <div class="grid gap-4 p-5 sm:p-7">


                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Meta title
                        </label>

                        <input
                            type="text"
                            name="meta_title"
                            value="{{ old('meta_title', $vendor->meta_title) }}"
                            class="vendor-input"
                        >

                    </div>


                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Meta description
                        </label>

                        <textarea
                            name="meta_description"
                            rows="4"
                            class="vendor-textarea"
                        >{{ old('meta_description', $vendor->meta_description) }}</textarea>

                    </div>


                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Meta keywords
                        </label>

                        <textarea
                            name="meta_keywords"
                            rows="3"
                            class="vendor-textarea"
                        >{{ old('meta_keywords', $vendor->meta_keywords) }}</textarea>

                    </div>


                </div>

            </section>



            {{-- ================================================== --}}
            {{-- BUSINESS OVERVIEW --}}
            {{-- ================================================== --}}

            <section
                x-show="activeSection === 'business-overview'"
                x-cloak
            >

                <div class="border-b border-[#edf1f3] p-5 sm:p-7">

                    <h2 class="font-display text-2xl font-semibold">
                        Business Overview
                    </h2>

                    <p class="mt-1 text-sm text-[#718394]">
                        Complete description and available services.
                    </p>

                </div>


                <div class="grid gap-5 p-5 sm:p-7">


                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Full business description
                        </label>

                        <textarea
                            name="full_description"
                            rows="7"
                            class="vendor-textarea"
                        >{{ old('full_description', $vendor->full_description) }}</textarea>

                    </div>


                    <div>

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Services and facilities
                        </label>

                        <textarea
                            name="services"
                            rows="5"
                            class="vendor-textarea"
                        >{{ old('services', $vendor->services) }}</textarea>

                    </div>


                </div>

            </section>



            {{-- ================================================== --}}
            {{-- BUSINESS LOCATION --}}
            {{-- ================================================== --}}

            <section
                x-show="activeSection === 'business-location'"
                x-cloak
            >

                <div class="border-b border-[#edf1f3] p-5 sm:p-7">

                    <h2 class="font-display text-2xl font-semibold">
                        Business Location
                    </h2>

                    <p class="mt-1 text-sm text-[#718394]">
                        Address and service location information.
                    </p>

                </div>


                <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-7">


                    @php

                        $locations = [

                            ['country', 'Country'],
                            ['state', 'State'],
                            ['city', 'City'],
                            ['zone', 'Zone'],
                            ['area', 'Area'],
                            ['pincode', 'Pincode'],
                            ['landmark', 'Landmark'],

                        ];

                    @endphp


                    @foreach($locations as [$name, $label])

                        <div>

                            <label class="text-xs font-semibold text-[#435b6d]">
                                {{ $label }}
                            </label>

                            <input
                                type="text"
                                name="{{ $name }}"
                                value="{{ old($name, $vendor->{$name}) }}"
                                class="vendor-input"
                            >

                        </div>

                    @endforeach


                    <div class="sm:col-span-2">

                        <label class="text-xs font-semibold text-[#435b6d]">
                            Full Address
                        </label>

                        <textarea
                            name="address"
                            rows="4"
                            class="vendor-textarea"
                        >{{ old('address', $vendor->address) }}</textarea>

                    </div>


                </div>

            </section>



            {{-- ================================================== --}}
            {{-- OTHER TABS PLACEHOLDER --}}
            {{-- ================================================== --}}

            @foreach([
                'faqs'              => 'FAQs',
                'company-logo'      => 'Company Logo',
                'gallery'           => 'Gallery',
                'certificates'      => 'Certificates',
                'awards'            => 'Awards',
                'recent-activity'   => 'Recent Activity',
                'assigned-keywords' => 'Assigned Keywords',
                'account-settings'  => 'Account Settings',
                'leads'             => 'Leads',
                'discussion'        => 'Discussion',
                'payment-orders'    => 'Payment Orders',
            ] as $key => $title)

                <section
                    x-show="activeSection === '{{ $key }}'"
                    x-cloak
                >

                    <div class="border-b border-[#edf1f3] p-5 sm:p-7">

                        <h2 class="font-display text-2xl font-semibold">
                            {{ $title }}
                        </h2>

                    </div>


                    <div class="p-5 sm:p-7">

                        <div
                            class="
                                rounded-xl
                                border
                                border-dashed
                                border-[#dfe7ec]
                                bg-[#f8fafb]
                                px-5
                                py-12
                                text-center
                            "
                        >

                            <p class="text-sm font-semibold text-[#435b6d]">
                                {{ $title }}
                            </p>

                            <p class="mt-1 text-xs text-[#718394]">
                                Add {{ strtolower($title) }} fields here.
                            </p>

                        </div>

                    </div>

                </section>

            @endforeach



            {{-- ================================================== --}}
            {{-- SAVE BUTTON --}}
            {{-- ================================================== --}}

            <div
                class="
                    flex
                    flex-col-reverse
                    gap-2
                    border-t
                    border-[#edf1f3]
                    p-5

                    sm:flex-row
                    sm:justify-end
                    sm:p-7
                "
            >

                <a
                    href="{{ route('sales.vendors.index') }}"
                    class="
                        inline-flex
                        h-11
                        items-center
                        justify-center
                        rounded-lg
                        border
                        border-[#dfe7ec]
                        px-4
                        text-sm
                        font-semibold
                        text-[#718394]
                        hover:bg-[#f7f9fb]
                    "
                >
                    Discard
                </a>


                <button
                    type="submit"
                    class="
                        h-11
                        rounded-lg
                        bg-[#a14f47]
                        px-5
                        text-sm
                        font-semibold
                        text-white
                        transition
                        hover:bg-[#8f433d]
                    "
                >

                    {{ $isCreating ? 'Create vendor' : 'Save changes' }}

                </button>

            </div>


        </form>

    </div>

</div>



{{-- ============================================================ --}}
{{-- ALPINE JS --}}
{{-- ============================================================ --}}

<script>

function vendorEditor() {

    return {

        activeSection: @js($activeSection),

        openSection(section) {

            this.activeSection = section;

            const url = new URL(window.location.href);

            url.searchParams.set('section', section);

            window.history.replaceState(
                {},
                '',
                url.toString()
            );


            if (window.innerWidth < 1024) {

                this.$nextTick(() => {

                    const form = document.getElementById(
                        'vendorEditorForm'
                    );

                    if (form) {

                        form.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                    }

                });

            }

        }

    };

}

</script>


{{-- ============================================================ --}}
{{-- REUSABLE TAILWIND CLASSES --}}
{{-- If you don't use @apply, replace these with full classes --}}
{{-- ============================================================ --}}

<style>

    [x-cloak] {
        display: none !important;
    }

</style>

</x-layouts.sales.app>