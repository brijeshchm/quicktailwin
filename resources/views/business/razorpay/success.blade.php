@extends('business.business.layouts.app')

@section('title', 'Payment Success')

@section('keyword', '')

@section('description', '')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | Payment Details
    |--------------------------------------------------------------------------
    */

    $paymentDetails = [

        [
            'label' => 'Order ID',
            'value' => request('order_id', ''),
        ],

        [
            'label' => 'Name',
            'value' => request('card_holder_name')
                ? ucfirst(request('card_holder_name'))
                : '',
        ],

        [
            'label' => 'Email',
            'value' => request('email', ''),
        ],

        [
            'label' => 'Amount',
            'value' => request('merchant_amount')
                ? '₹ ' . request('merchant_amount')
                : '',
        ],

        [
            'label' => 'Pay To',
            'value' => request('pay_to', ''),
        ],

        [
            'label' => 'Payment ID',
            'value' => request('payment_id', ''),
        ],

        [
            'label' => 'Contact',
            'value' => request('phone', ''),
        ],

        [
            'label' => 'Address',
            'value' => collect([
                request('city'),
                request('billing_state'),
                request('billing_country'),
            ])
            ->filter()
            ->implode(', '),
        ],

        [
            'label' => 'Pay Date',
            'value' => now()->format('jS M Y'),
        ],

    ];

@endphp


<div class="mx-auto max-w-5xl space-y-6 px-3 py-4 sm:px-4 md:py-6">

    {{-- ============================================================
         PAGE HEADER
    ============================================================= --}}

    <div>

        <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">
            Payment Confirmation
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Your payment transaction details are shown below.
        </p>

    </div>



    {{-- ============================================================
         PAYMENT SUCCESS BOX
    ============================================================= --}}

    <div
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        {{-- Success Header --}}
        <div
            class="border-b border-emerald-100 bg-emerald-50 px-4 py-5 sm:px-6"
        >

            <div class="flex items-start gap-3">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600"
                >

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
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>


                <div>

                    <h2 class="text-lg font-semibold text-emerald-800">
                        Payment Successful
                    </h2>

                    <p class="mt-1 text-sm text-emerald-700">
                        Your payment has been processed successfully.
                    </p>

                </div>

            </div>

        </div>



        {{-- ========================================================
             PAYMENT STEPS
        ========================================================= --}}

        <div class="border-b border-slate-200 px-3 py-5 sm:px-6">

            <div
                class="flex items-start justify-between gap-2"
            >

                {{-- Details --}}
                <div class="flex flex-1 flex-col items-center text-center">

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-600"
                    >
                        ✓
                    </div>

                    <span class="mt-2 text-xs font-medium text-slate-500">
                        Details
                    </span>

                </div>


                <div
                    class="mt-4 h-0.5 flex-1 bg-emerald-200"
                ></div>


                {{-- Transaction --}}
                <div class="flex flex-1 flex-col items-center text-center">

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-600"
                    >
                        ✓
                    </div>

                    <span class="mt-2 text-xs font-medium text-slate-500">
                        Transaction
                    </span>

                </div>


                <div
                    class="mt-4 h-0.5 flex-1 bg-blue-200"
                ></div>


                {{-- Confirmation --}}
                <div class="flex flex-1 flex-col items-center text-center">

                   <div
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-600"
                    >
                        ✓
                    </div>

                    <span class="mt-2 text-xs font-semibold text-blue-600">
                        Success
                    </span>

                </div>

            </div>

        </div>



        {{-- ========================================================
             TABS
        ========================================================= --}}

        <div class="border-b border-slate-200 px-4 sm:px-6">

            <div class="flex gap-1 overflow-x-auto">

                <button
                    type="button"
                    id="confirmationTab"
                    onclick="openPaymentTab('confirmation')"
                    class="payment-tab whitespace-nowrap border-b-2 border-blue-600 px-4 py-3 text-sm font-semibold text-blue-600"
                >
                    Confirmation
                </button>


                <button
                    type="button"
                    id="issueTab"
                    onclick="openPaymentTab('faceIssue')"
                    class="payment-tab whitespace-nowrap border-b-2 border-transparent px-4 py-3 text-sm font-medium text-slate-500 transition hover:text-slate-800"
                >
                    Face an Issue
                </button>

            </div>

        </div>



        {{-- ========================================================
             CONFIRMATION TAB
        ========================================================= --}}

        <div
            id="confirmation"
            class="payment-tab-content"
        >

            <div class="p-4 sm:p-6">

                <div class="mb-5">

                    <h3 class="text-lg font-semibold text-slate-900">
                        Transaction Summary
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Please keep these payment details for your records.
                    </p>

                </div>



                {{-- =================================================
                     DESKTOP TABLE
                ================================================== --}}

                <div
                    class="hidden overflow-hidden rounded-xl border border-slate-200 md:block"
                >

                    <table class="w-full text-sm">

                        <thead class="bg-slate-50">

                            <tr>

                                <th
                                    class="w-1/3 px-5 py-3 text-left font-semibold text-slate-700"
                                >
                                    Summary
                                </th>

                                <th
                                    class="px-5 py-3 text-left font-semibold text-slate-700"
                                >
                                    Details
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-200">

                            @foreach($paymentDetails as $detail)

                                <tr
                                    class="transition hover:bg-slate-50"
                                >

                                    <th
                                        class="px-5 py-3.5 text-left font-medium text-slate-600"
                                    >
                                        {{ $detail['label'] }}
                                    </th>


                                    <td
                                        class="break-all px-5 py-3.5 font-medium text-slate-900"
                                    >
                                        {{ $detail['value'] ?: '-' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>



                {{-- =================================================
                     MOBILE VERSION
                ================================================== --}}

                <div class="space-y-3 md:hidden">

                    @foreach($paymentDetails as $detail)

                        <div
                            class="rounded-xl border border-slate-200 bg-slate-50 p-4"
                        >

                            <p
                                class="text-xs font-semibold uppercase tracking-wide text-slate-500"
                            >
                                {{ $detail['label'] }}
                            </p>


                            <p
                                class="mt-1 break-all text-sm font-semibold text-slate-900"
                            >
                                {{ $detail['value'] ?: '-' }}
                            </p>

                        </div>

                    @endforeach

                </div>



                {{-- =================================================
                     INVOICE BUTTON
                ================================================== --}}

                <div
                    class="mt-6 flex justify-end border-t border-slate-200 pt-5"
                >

                    @if(!empty($paymentHistory->id))

                        <a
                            href="{{ url('business/getinvoiceBillingPrintPdf/' . $paymentHistory->id) }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 sm:w-auto"
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
                                    d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"
                                />
                            </svg>

                            Download Invoice

                        </a>

                    @else

                        <a
                            href="{{ url('business/billing-history') }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 sm:w-auto"
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
                                    d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"
                                />
                            </svg>

                            Download Invoice

                        </a>

                    @endif

                </div>

            </div>

        </div>



        {{-- ========================================================
             FACE AN ISSUE TAB
        ========================================================= --}}

        <div
            id="faceIssue"
            class="payment-tab-content hidden"
        >

            <div class="p-4 sm:p-6">

                <div class="mb-6">

                    <h3 class="text-lg font-semibold text-slate-900">
                        Face an Issue?
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Tell us about the problem with your payment and our team will assist you.
                    </p>

                </div>



                <form
                    method="POST"
                    action=""
                    autocomplete="off"
                    class="space-y-5"
                    onsubmit="return homeController.faceAnIssue(this)"
                >

                    @csrf



                    {{-- Name + Email --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Name --}}
                        <div>

                            <label
                                for="issue_name"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Full Name
                                <span class="text-red-500">*</span>
                            </label>


                            <input
                                type="text"
                                id="issue_name"
                                name="name"
                                value="{{ old('name', $data->name ?? '') }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Enter full name"
                            >


                            @error('name')

                                <p class="mt-1 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- Email --}}
                        <div>

                            <label
                                for="issue_email"
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Email
                                <span class="text-red-500">*</span>
                            </label>


                            <input
                                type="email"
                                id="issue_email"
                                name="email"
                                value="{{ old('email', $data->email ?? '') }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                placeholder="Enter email address"
                            >


                            @error('email')

                                <p class="mt-1 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>



                    {{-- Phone --}}
                    <div>

                        <label
                            for="issue_phone"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Contact Number
                            <span class="text-red-500">*</span>
                        </label>


                        <input
                            type="text"
                            id="issue_phone"
                            name="phone"
                            value="{{ old('phone', $data->phone ?? '') }}"
                            maxlength="16"
                            inputmode="numeric"
                            onkeypress="return isNumberKey(event)"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            placeholder="Enter contact number"
                        >


                        @error('phone')

                            <p class="mt-1 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- Remark --}}
                    <div>

                        <label
                            for="issue_remark"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Describe Your Issue
                            <span class="text-red-500">*</span>
                        </label>


                        <textarea
                            id="issue_remark"
                            name="remark"
                            rows="5"
                            class="w-full resize-none rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            placeholder="Explain the payment issue..."
                        >{{ old('remark', $data->remark ?? '') }}</textarea>


                        @error('remark')

                            <p class="mt-1 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- Submit --}}
                    <div
                        class="flex justify-end border-t border-slate-200 pt-5"
                    >

                        <button
                            type="submit"
                            name="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 sm:w-auto"
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
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"
                                />
                            </svg>

                            Submit Issue

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<script>

/*
|--------------------------------------------------------------------------
| PAYMENT TABS
|--------------------------------------------------------------------------
*/

function openPaymentTab(tab) {

    const confirmation =
        document.getElementById(
            'confirmation'
        );


    const issue =
        document.getElementById(
            'faceIssue'
        );


    const confirmationTab =
        document.getElementById(
            'confirmationTab'
        );


    const issueTab =
        document.getElementById(
            'issueTab'
        );


    if (
        !confirmation ||
        !issue
    ) {
        return;
    }



    /*
    |--------------------------------------------------------------------------
    | Confirmation
    |--------------------------------------------------------------------------
    */

    if (tab === 'confirmation') {

        confirmation.classList.remove(
            'hidden'
        );


        issue.classList.add(
            'hidden'
        );


        confirmationTab.className =
            'payment-tab whitespace-nowrap border-b-2 border-blue-600 px-4 py-3 text-sm font-semibold text-blue-600';


        issueTab.className =
            'payment-tab whitespace-nowrap border-b-2 border-transparent px-4 py-3 text-sm font-medium text-slate-500 transition hover:text-slate-800';


        return;

    }



    /*
    |--------------------------------------------------------------------------
    | Face Issue
    |--------------------------------------------------------------------------
    */

    confirmation.classList.add(
        'hidden'
    );


    issue.classList.remove(
        'hidden'
    );


    issueTab.className =
        'payment-tab whitespace-nowrap border-b-2 border-blue-600 px-4 py-3 text-sm font-semibold text-blue-600';


    confirmationTab.className =
        'payment-tab whitespace-nowrap border-b-2 border-transparent px-4 py-3 text-sm font-medium text-slate-500 transition hover:text-slate-800';

}



/*
|--------------------------------------------------------------------------
| ONLY NUMBER
|--------------------------------------------------------------------------
*/

function isNumberKey(event) {

    const key =
        event.key;


    if (
        key === 'Backspace' ||
        key === 'Delete' ||
        key === 'Tab' ||
        key === 'ArrowLeft' ||
        key === 'ArrowRight'
    ) {

        return true;

    }


    return /^[0-9]$/.test(
        key
    );

}

</script>

@endsection