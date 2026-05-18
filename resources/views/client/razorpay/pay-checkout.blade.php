<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Checkout — QuickDials</title>
    <meta name="keywords" content="Quickdials Payment checkout">
    <meta name="description" content="Quickdials Payment checkout">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="robots" content="noindex, follow">

    <meta name="author" content="Quick Dials">
    <meta property="og:title" content="Quickdials Payment checkout" />
    <meta property="og:description" content="Quickdials Payment checkout" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="@yield('og_image', asset('client/images/quickdials-og.png'))" />

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Quickdials Payment checkout" />
    <meta name="twitter:description" content="Quickdials Payment checkout" />
    <meta name="twitter:image" content="@yield('og_image', asset('client/images/quickdials-og.png'))" />

    {{-- GEO --}}
    <meta name="geo.region" content="IN" />
    <meta name="geo.placename" content="India" />

    {{-- Verification --}}
    <meta name="google-site-verification" content="O8A-LG3YpW7vOcPtVP9OuNrEcLfLf1kW2tTVpFpHNxM" />
    <meta name="msvalidate.01" content="456AED0115D50D42C4F3A79DAB89D41D" />

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('client/images/favicon.png') }}" type="image/png" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ FIX #1: Load jQuery BEFORE Razorpay script --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- ✅ FIX #1: Razorpay script in head (loads before usage) --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>

<main id="main" class="main relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/40 min-h-screen">

    {{-- DECORATIVE BACKGROUND ORBS --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-[#3876F1]/20 to-[#1B1464]/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -left-32 w-80 h-80 bg-gradient-to-tr from-[#006FBA]/15 to-[#042D6E]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-gradient-to-tl from-indigo-200/40 to-blue-100/20 rounded-full blur-3xl"></div>
    </div>

    <section class="section profile relative z-10 py-8 md:py-12 lg:py-16 px-4">
        <div class="max-w-4xl mx-auto">

            {{-- HEADER --}}
            <div class="flex flex-col items-center mb-8">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/80 backdrop-blur-sm border border-emerald-200/60 rounded-full shadow-sm mb-4">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">256-bit SSL Secure Checkout</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-[#042D6E] tracking-tight">Review Your Order</h1>
                <p class="text-sm text-slate-500 mt-2">Verify your details before proceeding to payment</p>
            </div>

            {{-- ✅ FIX #5: GLOBAL ERROR ALERT (visible since hidden inputs can't show inline errors) --}}
            <div id="payment-error-alert" class="hidden mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-start gap-3" role="alert">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-red-800">Payment cannot proceed</h4>
                    <p id="payment-error-message" class="text-sm text-red-700 mt-0.5"></p>
                </div>
                <button type="button" id="dismiss-error" class="text-red-400 hover:text-red-600" aria-label="Dismiss">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- MAIN CARD --}}
            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-[#1B1464] via-[#3876F1] to-[#006FBA] rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>

                <div class="relative bg-white rounded-2xl shadow-xl shadow-blue-900/5 overflow-hidden">
                    <div class="h-1.5 bg-gradient-to-r from-[#1B1464] via-[#3876F1] to-[#006FBA]"></div>

                    <div class="p-6 sm:p-8 md:p-10 lg:p-12">

                        {{-- TOTAL AMOUNT --}}
                        <div class="text-center mb-10 pb-10 border-b border-dashed border-slate-200">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400 mb-3">Total Payable</div>
                            <div class="flex items-baseline justify-center gap-1">
                                <span class="text-3xl md:text-4xl font-medium text-slate-400 mt-2">₹</span>
                                <span class="text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-[#1B1464] via-[#3876F1] to-[#006FBA] bg-clip-text text-transparent tracking-tight leading-none">
                                    @if($data->amt){{ number_format(($data->amt * 0.18) + $data->amt, 2) }}@endif
                                </span>
                            </div>
                            <div class="inline-flex items-center gap-2 mt-4 px-3 py-1 bg-blue-50 rounded-full">
                                <svg class="w-3.5 h-3.5 text-[#3876F1]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span class="text-xs font-medium text-[#042D6E]">Inclusive of 18% GST</span>
                            </div>
                        </div>

                        {{-- ORDER SUMMARY --}}
                        <div class="mb-10">
                            <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 mb-5">Order Details</h2>
                            <div class="space-y-3">

                                <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-slate-50/80 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-[#3876F1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                        <span class="text-sm font-medium text-slate-500">Customer Name</span>
                                    </div>
                                    <span class="text-sm font-semibold text-[#042D6E]">
                                        @if($data->customer_name){{ $data->customer_name }}@else <span class="text-slate-300">—</span>@endif
                                    </span>
                                </div>

                                <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-slate-50/80 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-[#3876F1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="text-sm font-medium text-slate-500">Email Address</span>
                                    </div>
                                    <span class="text-sm font-semibold text-[#042D6E] truncate max-w-[180px] sm:max-w-none">
                                        @if($data->email){{ $data->email }}@else <span class="text-slate-300">—</span>@endif
                                    </span>
                                </div>

                                <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-slate-50/80 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-[#3876F1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </div>
                                        <span class="text-sm font-medium text-slate-500">Mobile Number</span>
                                    </div>
                                    <span class="text-sm font-semibold text-[#042D6E]">
                                        @if($data->phone){{ $data->phone }}@else <span class="text-slate-300">—</span>@endif
                                    </span>
                                </div>

                                <div class="flex items-center justify-between py-3 px-4 rounded-xl bg-gradient-to-r from-amber-50/60 to-orange-50/40 border border-amber-100/60">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 7.234 6 8.034 6 9c0 .966.602 1.766 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V17a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 15.766 14 14.966 14 14c0-.966-.602-1.766-1.324-2.246A4.535 4.535 0 0011 11.092V9.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V6z" clip-rule="evenodd"/></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-slate-700">Coins Credited</div>
                                            <div class="text-[10px] text-amber-700/70">Bonus reward on this purchase</div>
                                        </div>
                                    </div>
                                    <span class="text-sm font-bold text-amber-700">
                                        @if($data->coins)+{{ $data->coins }} ₹@else <span class="text-slate-300">—</span>@endif
                                    </span>
                                </div>

                            </div>
                        </div>

                        {{-- PRICE BREAKDOWN --}}
                        <div class="mb-10 p-5 rounded-xl bg-slate-50/70 border border-slate-100">
                            <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 mb-4">Price Breakdown</h3>
                            <div class="space-y-2.5">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Subtotal</span>
                                    <span class="font-medium text-slate-800">₹@if($data->amt){{ number_format($data->amt, 2) }}@endif</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">GST (18%)</span>
                                    <span class="font-medium text-slate-800">₹@if($data->amt){{ number_format($data->amt * 0.18, 2) }}@endif</span>
                                </div>
                                <div class="border-t border-slate-200 pt-2.5 mt-2.5 flex justify-between items-center">
                                    <span class="font-semibold text-[#042D6E]">Total</span>
                                    <span class="font-bold text-lg text-[#042D6E]">₹@if($data->amt){{ number_format(($data->amt * 0.18) + $data->amt, 2) }}@endif</span>
                                </div>
                            </div>
                        </div>

                        {{-- ✅ FIX #2: REMOVED <form> wrapper, button is now type="button" so it never submits a form --}}
                        <div id="razorpay-frm-payment">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="tid" id="tid" readonly />
                            <input type="hidden" name="merchant_order_id" id="merchant_order_id">
                            <input type="hidden" name="language" value="EN">
                            <input type="hidden" name="currency" id="currency" value="INR">

                            {{-- ✅ FIX #4: Dynamic environment-aware URLs --}}
                            <input type="hidden" name="surl" id="surl" value="https://www.quickdials.com/success">
                            <input type="hidden" name="furl" id="furl" value="https://www.quickdials.com/failed">


                            <!-- <input type="hidden" name="surl" id="surl" value="http://localhost:8000/success">
                            <input type="hidden" name="furl" id="furl" value="http://localhost:8000/failed"> -->



                            <input type="hidden" id="amount1" value="{{ $data->amt ?? '' }}" readonly>
                            <input type="hidden" id="amount2" value="{{ $data->amt ?? '' }}" readonly>
                            <input type="hidden" id="amount3" value="{{ $data->amt ?? '' }}" readonly>
                            <input type="hidden" id="paid_amount" name="paid_amount" value="{{ $data->amt ?? '' }}" readonly>
                            <input type="hidden" id="gst_tax" name="gst_tax" value="{{ $data->amt ? $data->amt * 0.18 : '' }}" readonly>
                            <input type="hidden" id="gst_total_amount" name="gst_total_amount" value="{{ $data->amt ? ($data->amt * 0.18) + $data->amt : '' }}" readonly>

                            <input type="hidden" name="billing_name" id="billing-name" value="{{ $data->customer_name }}">
                            <input type="hidden" name="billing_email" id="billing-email" value="{{ $data->email }}">
                            <input type="hidden" name="billing_phone" id="billing-phone" value="{{ $data->phone }}">
                            <input type="hidden" name="coins" id="coins" value="{{ $data->coins }}">
                            <input type="hidden" name="client_id" id="client_id" value="{{ $data->client_id }}">
                            <input type="hidden" name="username" id="username" value="{{ $data->username }}">
                            <input type="hidden" name="billing_country" id="billing_country" value="{{ $data->country }}">
                            <input type="hidden" name="billing_state" id="billing_state" value="{{ $data->state }}">
                            <input type="hidden" name="city" id="city" value="{{ $data->city }}">
                            <input type="hidden" name="RAZOR_KEY_ID" id="RAZOR_KEY_ID" value="{{ RAZOR_KEY_ID }}">

                            {{-- ACTION BUTTONS --}}
                            <div class="flex flex-col-reverse sm:flex-row gap-3 sm:gap-4">

                                <!-- <a href="{{ url('/business/package') }}"
                                   class="group/cancel flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 text-sm font-semibold
                                          bg-white text-slate-700 border-2 border-slate-200 rounded-xl
                                          hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900
                                          transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-slate-100">
                                    <svg class="w-4 h-4 group-hover/cancel:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                    Cancel
                                </a> -->

                                {{-- ✅ FIX #2: type="button" so no form submission --}}
                                {{-- ✅ FIX #6: Has loading state slots --}}
                                <button type="button"
                                        id="razor-pay-now"
                                        class="group/pay flex-[2] relative inline-flex items-center justify-center gap-2 px-6 py-4 text-sm font-bold
                                               bg-gradient-to-br from-[#3876F1] via-[#1C19B0] to-[#1B1464]
                                               text-white rounded-xl overflow-hidden
                                               shadow-lg shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/40
                                               hover:-translate-y-0.5 active:translate-y-0
                                               disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:shadow-lg
                                               transition-all duration-300
                                               focus:outline-none focus:ring-4 focus:ring-blue-300">

                                    <span class="absolute inset-0 -translate-x-full group-hover/pay:translate-x-full transition-transform duration-700 bg-gradient-to-r from-transparent via-white/20 to-transparent" aria-hidden="true"></span>

                                    {{-- Idle state --}}
                                 <span id="pay-btn-idle"
      class="relative z-10 inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl shadow-lg transition-all duration-300">

    <!-- Lock Icon -->
    <svg class="w-5 h-5"
         fill="none"
         stroke="currentColor"
         viewBox="0 0 24 24">
        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
    </svg>

    <!-- Text -->
    <span class="tracking-wide uppercase font-semibold">
        Pay Securely Now
    </span>

    <!-- Arrow Icon -->
    <svg class="w-4 h-4 group-hover/pay:translate-x-1 transition-transform"
         fill="none"
         stroke="currentColor"
         viewBox="0 0 24 24">
        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 8l4 4m0 0l-4 4m4-4H3"/>
    </svg>

</span>

                                    {{-- Loading state --}}
                                    <span id="pay-btn-loading" class="hidden relative z-10 inline-flex items-center gap-2">
                                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="tracking-wide uppercase">Opening Razorpay...</span>
                                    </span>
                                </button>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- TRUST BADGES --}}
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4 sm:gap-6 md:gap-8 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#3876F1]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="font-medium">Powered by Razorpay</span>
                </div>
                <div class="hidden sm:block w-px h-4 bg-slate-300"></div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span class="font-medium">End-to-end Encrypted</span>
                </div>
                <div class="hidden sm:block w-px h-4 bg-slate-300"></div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    <span class="font-medium">GST Compliant Invoice</span>
                </div>
                <div class="hidden sm:block w-px h-4 bg-slate-300"></div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#042D6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span class="font-medium">UPI · Cards · Net Banking</span>
                </div>
            </div>

            <p class="text-center text-xs text-slate-400 mt-6 max-w-md mx-auto">
                By clicking "Pay Securely Now", you agree to QuickDials's <a href="#" class="text-[#3876F1] hover:underline font-medium">Terms of Service</a> and authorize this transaction.
            </p>

        </div>
    </section>

</main>

{{-- ============================================ --}}
{{-- ✅ FIXED PAYMENT SCRIPT --}}
{{-- ============================================ --}}
<script>
jQuery(document).ready(function ($) {

    // ✅ FIX #8: Generate order ID immediately on document ready
    var orderTimestamp = new Date().getTime();
    $('#tid').val(orderTimestamp);
    $('#merchant_order_id').val('QI_' + Math.floor((Math.random() * 1000) + 1) + '_' + orderTimestamp);

    // ✅ FIX #3: Set CSRF token globally for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ============================================
    // Helper: Show error
    // ============================================
    function showError(message) {
        $('#payment-error-message').text(message);
        $('#payment-error-alert').removeClass('hidden');
        // Scroll to error
        $('html, body').animate({
            scrollTop: $('#payment-error-alert').offset().top - 20
        }, 300);
    }

    function hideError() {
        $('#payment-error-alert').addClass('hidden');
    }

    // ✅ FIX #5: Dismiss error button
    $('#dismiss-error').on('click', hideError);

    // ============================================
    // Helper: Toggle button loading state
    // ============================================
    function setButtonLoading(isLoading) {
        var $btn = $('#razor-pay-now');
        if (isLoading) {
            $btn.prop('disabled', true);
            $('#pay-btn-idle').addClass('hidden');
            $('#pay-btn-loading').removeClass('hidden');
        } else {
            $btn.prop('disabled', false);
            $('#pay-btn-idle').removeClass('hidden');
            $('#pay-btn-loading').addClass('hidden');
        }
    }

    // ============================================
    // ✅ FIX #2: Click handler — no form submission
    // ============================================
    $('#razor-pay-now').on('click', function (e) {
        e.preventDefault(); // ✅ FIX #2: Prevent at TOP, not at bottom
        hideError();
 
        // Read all values
        var $form        = $('#razorpay-frm-payment');
        var total        = $form.find('#gst_total_amount').val() * 100;
        var merchant_order_id  = $form.find('#merchant_order_id').val();
        var merchant_surl_id   = $form.find('#surl').val();
        var merchant_furl_id   = $form.find('#furl').val();
        var card_holder_name_id = $form.find('#billing-name').val();
        var merchant_total     = total;
        var paid_amount        = $form.find('#paid_amount').val();
        var merchant_amount    = $form.find('#gst_total_amount').val();
        var gst_tax            = $form.find('#gst_tax').val();
        var currency_code_id   = $form.find('#currency').val();
        var key_id             = $form.find('#RAZOR_KEY_ID').val();
        var email              = $form.find('#billing-email').val();
        var phone              = $form.find('#billing-phone').val();
        var coins              = $form.find('#coins').val();
        var client_id          = $form.find('#client_id').val();
        var username           = $form.find('#username').val();
        var billing_country    = $form.find('#billing_country').val();
        var billing_state      = $form.find('#billing_state').val();
        var city               = $form.find('#city').val();
 
        // ✅ FIX #5: Validation with visible error message
        if (!card_holder_name_id || card_holder_name_id.trim() === '') {
            showError('Customer name is missing. Please go back and complete your details.');
            return false;
        }
        if (!email || email.trim() === '') {
            showError('Email address is missing. Please go back and complete your details.');
            return false;
        }
        if (!phone || phone.trim() === '') {
            showError('Mobile number is missing. Please go back and complete your details.');
            return false;
        }
        if (!merchant_amount || merchant_amount <= 0) {
            showError('Invalid payment amount. Please refresh the page.');
            return false;
        }
        if (!key_id) {
            showError('Payment gateway not configured. Please contact support.');
            return false;
        }

        // ✅ FIX #6: Lock button to prevent double-click
        setButtonLoading(true);

        var razorpay_options = {
            key: key_id,
            amount: merchant_total,
            name: 'Quick Dials Pvt Ltd',
            description: 'Package Pay',
            image: 'https://www.quickdials.com/client/images/small-logo.jpg',
            netbanking: true,
            currency: currency_code_id,
            prefill: {
                name: card_holder_name_id,
                email: email,
                contact: phone
            },
            notes: {
                soolegal_order_id: merchant_order_id
            },
            handler: function (transaction) {
 
                // ✅ FIX #6: Keep loading state during AJAX
                $.ajax({
                    url: '/razorPayCheckout',
                    type: 'POST',
                    data: {
                        razorpay_payment_id: transaction.razorpay_payment_id,
                        merchant_order_id: merchant_order_id,
                        merchant_surl_id: merchant_surl_id,
                        merchant_furl_id: merchant_furl_id,
                        card_holder_name_id: card_holder_name_id,
                        merchant_total: merchant_total,
                        merchant_amount: merchant_amount,
                        currency_code_id: currency_code_id,
                        pay: 'Quick Dials Pvt Ltd',
                        email: email,
                        phone: phone,
                        billing_country: billing_country,
                        billing_state: billing_state,
                        city: city,
                        coins: coins,
                        client_id: client_id,
                        username: username,
                        gst_tax: gst_tax,
                        paid_amount: paid_amount
                    },
                    dataType: 'json',
                    success: function (res) {
                        try {
                            var obj = (typeof res.data === 'string') ? jQuery.parseJSON(res.data) : res.data;
                            window.location = res.redirectURL
                                + '?getpay='        + encodeURIComponent(obj.getpay)
                                + '&card_holder_name=' + encodeURIComponent(obj.card_holder_name)
                                + '&merchant_amount='  + encodeURIComponent(obj.merchant_amount)
                                + '&order_id='         + encodeURIComponent(obj.order_id)
                                + '&currency_code_id=' + encodeURIComponent(obj.currency_code)
                                + '&pay_to='           + encodeURIComponent(obj.pay_to)
                                + '&coins='            + encodeURIComponent(obj.coins)
                                + '&email='            + encodeURIComponent(obj.email)
                                + '&phone='            + encodeURIComponent(obj.phone)
                                + '&payment_id='       + encodeURIComponent(obj.razorpay_payment_id)
                                + '&billing_country='  + encodeURIComponent(obj.billing_country)
                                + '&billing_state='    + encodeURIComponent(obj.billing_state)
                                + '&city='             + encodeURIComponent(obj.city);
                        } catch (err) {
                            setButtonLoading(false);
                            showError('Payment recorded but redirect failed. Payment ID: ' + transaction.razorpay_payment_id + '. Please contact support.');
                            console.error('Parse error:', err, res);
                        }
                    },
                    // ✅ FIX #7: AJAX error handler — CRITICAL for money-taken-but-no-redirect cases
                    error: function (xhr, status, error) {
                        setButtonLoading(false);
                        var errMsg = 'Payment was successful but our server could not record it. ';
                        errMsg += 'Please save this Payment ID and contact support: ' + transaction.razorpay_payment_id;
                        showError(errMsg);
                        console.error('AJAX error:', status, error, xhr.responseText);
                    }
                });
            },
            modal: {
                ondismiss: function () {
                    // ✅ FIX #6: Re-enable button if user closes Razorpay modal
                    setButtonLoading(false);
                }
            }
        };

        try {
            var razorpayInstance = new Razorpay(razorpay_options);
            razorpayInstance.on('payment.failed', function (response) {
                setButtonLoading(false);
                showError('Payment failed: ' + (response.error.description || 'Please try again.'));
                console.error('Razorpay payment failed:', response.error);
            });
            razorpayInstance.open();
        } catch (err) {
            setButtonLoading(false);
            showError('Could not open payment gateway. Please refresh and try again.');
            console.error('Razorpay init error:', err);
        }
    });

});
</script>

</body>
</html>