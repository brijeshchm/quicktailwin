@extends('business.business.layouts.app')

@section('title', 'Payment Failed')

@section('keyword', '')

@section('description', '')

@section('content')

<div class="mx-auto flex min-h-[70vh] max-w-4xl items-center justify-center px-4 py-10">

    <div class="w-full rounded-2xl border border-red-100 bg-white p-6 text-center shadow-sm sm:p-10">

        {{-- Icon --}}
        <div
            class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-red-600"
        >
            <svg
                class="h-8 w-8"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18 18 6M6 6l12 12"
                />
            </svg>
        </div>


        {{-- Heading --}}
        <h1 class="mt-5 text-2xl font-bold text-slate-900 sm:text-3xl">
            Transaction Declined
        </h1>


        {{-- Message --}}
        <p class="mt-3 text-sm text-red-600 sm:text-base">
            Your transaction has been declined.
        </p>


        <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-500">
            No payment has been completed. You can try again or contact our support team if the issue continues.
        </p>


        {{-- Divider --}}
        <div class="my-6 border-t border-slate-200"></div>


        {{-- Support --}}
        <p class="text-sm text-slate-600">
            Having trouble?

            <a
                href="mailto:info@quickdials.com"
                rel="nofollow"
                class="font-semibold text-blue-600 hover:text-blue-700 hover:underline"
            >
                Contact us
            </a>
        </p>


        {{-- Actions --}}
        <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">

            <a
                href="{{ url('business/package') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
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
                        d="M12 4.5v15m7.5-7.5h-15"
                    />
                </svg>

                Continue to Pay
            </a>


            <a
                href="{{ route('business.package') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                Back to package
            </a>

        </div>

    </div>

</div>

@endsection