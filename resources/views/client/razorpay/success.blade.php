<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Payment Successful — QuickDials</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="{{ asset('client/images/favicon.png') }}" type="image/png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50">

@php
    // Sanitize all GET values once at the top
    $orderId   = e($_GET['order_id'] ?? '');
    $name      = e(ucfirst($_GET['card_holder_name'] ?? ''));
    $email     = e($_GET['email'] ?? '');
    $amount    = e($_GET['merchant_amount'] ?? '0');
    $payTo     = e($_GET['pay_to'] ?? '');
    $paymentId = e($_GET['payment_id'] ?? '');
    $phone     = e($_GET['phone'] ?? '');
    $city      = e($_GET['city'] ?? '');
    $state     = e($_GET['billing_state'] ?? '');
    $country   = e($_GET['billing_country'] ?? '');
    $coins     = e($_GET['coins'] ?? '');

    $address = trim(implode(', ', array_filter([$city, $state, $country])));
    $payDate = date('jS M Y, h:i A');
@endphp

<main class="min-h-screen relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-teal-50">

    {{-- Decorative orbs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-200/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        {{-- ════════════ ANIMATED SUCCESS ICON ════════════ --}}
        <div class="text-center mb-6 sm:mb-8">
            <div class="success-icon-wrap inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 rounded-full
                        bg-gradient-to-br from-emerald-400 to-teal-500 mb-4 sm:mb-5
                        shadow-xl shadow-emerald-300/50">
                <svg class="success-tick w-10 h-10 sm:w-12 sm:h-12 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-2 tracking-tight">
                Payment Successful!
            </h1>
            <p class="text-sm sm:text-base text-slate-500 max-w-md mx-auto">
                Thank you @if($name)<span class="font-semibold text-slate-700">{{ $name }}</span>@endif — your transaction has been completed securely.
            </p>
        </div>

        {{-- ════════════ AMOUNT CARD ════════════ --}}
        <div class="bg-white rounded-2xl shadow-xl shadow-emerald-900/5 border border-emerald-100/60 overflow-hidden mb-5">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-5 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-50/80 mb-1">Amount Paid</p>
                        <p class="text-3xl sm:text-4xl font-extrabold">₹{{ number_format((float)$amount, 2) }}</p>
                    </div>
                    @if($coins)
                    <div class="text-right">
                        <p class="text-xs font-semibold uppercase tracking-widest text-emerald-50/80 mb-1">Coins Earned</p>
                        <p class="text-2xl font-bold">+{{ number_format((int)$coins) }} 🪙</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ════════════ TRANSACTION DETAILS CARD ════════════ --}}
        <div class="bg-white rounded-2xl shadow-lg shadow-slate-900/5 border border-slate-200/60 overflow-hidden mb-5">

            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                    </svg>
                    Transaction Details
                </h2>
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider rounded-full">
                    Confirmed
                </span>
            </div>

            <div class="divide-y divide-slate-100">
                @php
                    $rows = [
                        ['icon' => 'hash',  'label' => 'Order ID',   'value' => $orderId,   'mono' => true],
                        ['icon' => 'user',  'label' => 'Name',       'value' => $name],
                        ['icon' => 'mail',  'label' => 'Email',      'value' => $email,     'truncate' => true],
                        ['icon' => 'phone', 'label' => 'Contact',    'value' => $phone],
                        ['icon' => 'pin',   'label' => 'Address',    'value' => $address],
                        ['icon' => 'card',  'label' => 'Pay To',     'value' => $payTo],
                        ['icon' => 'key',   'label' => 'Payment ID', 'value' => $paymentId, 'mono' => true],
                        ['icon' => 'clock', 'label' => 'Pay Date',   'value' => $payDate],
                    ];
                @endphp

                @foreach($rows as $row)
                    @if(!empty($row['value']))
                    <div class="flex items-center justify-between px-6 py-3.5 hover:bg-slate-50/60 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                                <span class="text-slate-500 text-xs">
                                    @switch($row['icon'])
                                        @case('hash')  #          @break
                                        @case('user')  👤         @break
                                        @case('mail')  ✉️         @break
                                        @case('phone') 📞         @break
                                        @case('pin')   📍         @break
                                        @case('card')  💳         @break
                                        @case('key')   🔑         @break
                                        @case('clock') 🕐         @break
                                    @endswitch
                                </span>
                            </div>
                            <span class="text-sm text-slate-500 font-medium">{{ $row['label'] }}</span>
                        </div>
                        <span class="text-sm font-semibold text-slate-800 text-right ml-3
                                     {{ !empty($row['mono']) ? 'font-mono text-xs' : '' }}
                                     {{ !empty($row['truncate']) ? 'truncate max-w-[150px] sm:max-w-none' : '' }}">
                            {{ $row['value'] }}
                        </span>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- ════════════ ACTION BUTTONS ════════════ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
            @if(!empty($paymentHistory->id))
                <a href="{{ url('business/getinvoiceBillingPrintPdf/' . optional($paymentHistory)->id) }}"
                   class="group inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold
                          bg-gradient-to-r from-emerald-500 to-teal-500 text-white
                          shadow-lg shadow-emerald-300/40
                          hover:shadow-xl hover:shadow-emerald-400/50 hover:-translate-y-0.5
                          active:translate-y-0 transition-all duration-200">
                    <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Invoice
                </a>
            @else

                <a href="{{ url('business/billing-history') }}" 
                   class="group inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold
                          bg-gradient-to-r from-emerald-500 to-teal-500 text-white
                          shadow-lg shadow-emerald-300/40 hover:shadow-xl hover:-translate-y-0.5
                          transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    View Billing History
                </a>
            @endif

            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold
                      bg-white text-slate-700 border-2 border-slate-200
                      hover:border-slate-300 hover:bg-slate-50 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Back to Home
            </a>
        </div>

        {{-- ════════════ "WHAT'S NEXT" CARD ════════════ --}}
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100/60 rounded-2xl p-5 sm:p-6 mb-6">
            <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                <span class="text-base">✨</span> What's Next?
            </h3>
            <ul class="space-y-2 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    A confirmation email has been sent to <strong>{{ $email ?: 'your email' }}</strong>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Your coins will be credited to your wallet within 5 minutes
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Download your GST-compliant invoice anytime from billing history
                </li>
            </ul>
        </div>

        {{-- ════════════ TRUST FOOTER ════════════ --}}
        <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 text-[11px] text-slate-400">
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">256-bit SSL Secured</span>
            </div>
            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
            <div class="flex items-center gap-1.5">
                <span class="font-medium">Powered by Razorpay</span>
            </div>
            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
            <div class="flex items-center gap-1.5">
                <span class="font-medium">GST Compliant</span>
            </div>
        </div>

        {{-- ════════════ HELP LINK ════════════ --}}
        <p class="text-center text-xs text-slate-400 mt-6">
            Facing any issue?
            <a href="{{ url('contact-us') }}" class="text-emerald-600 hover:underline font-semibold">
                Contact Support
            </a>
        </p>

    </div>
</main>

{{-- ════════════ ANIMATIONS ════════════ --}}
<style>
@keyframes scaleIn {
    0%   { transform: scale(0); opacity: 0; }
    60%  { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}
@keyframes drawTick {
    from { stroke-dashoffset: 50; }
    to   { stroke-dashoffset: 0; }
}
.success-icon-wrap {
    animation: scaleIn .6s cubic-bezier(.34, 1.56, .64, 1) backwards;
}
.success-tick path {
    stroke-dasharray: 50;
    stroke-dashoffset: 50;
    animation: drawTick .6s ease-out .4s forwards;
}

/* Confetti pop on success */
@keyframes pulse-ring {
    0%   { transform: scale(0.9); opacity: 1; }
    100% { transform: scale(1.6); opacity: 0; }
}
.success-icon-wrap::before {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #14b8a6);
    z-index: -1;
    animation: pulse-ring 1.5s ease-out infinite;
}
.success-icon-wrap {
    position: relative;
}

/* Card entrance */
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
main > div > div:not(.text-center) {
    animation: slideUp .5s ease backwards;
}
main > div > div:nth-child(2) { animation-delay: 0.15s; }
main > div > div:nth-child(3) { animation-delay: 0.25s; }
main > div > div:nth-child(4) { animation-delay: 0.35s; }
main > div > div:nth-child(5) { animation-delay: 0.45s; }
</style>

{{-- ════════════ CONFETTI EFFECT ════════════ --}}
<script>
// Simple confetti burst on page load
(function () {
    const colors = ['#10b981', '#14b8a6', '#f59e0b', '#3b82f6', '#ec4899'];
    const confettiCount = 50;

    for (let i = 0; i < confettiCount; i++) {
        const c = document.createElement('div');
        c.style.cssText = `
            position: fixed;
            top: -10px;
            left: ${Math.random() * 100}%;
            width: ${Math.random() * 8 + 4}px;
            height: ${Math.random() * 8 + 4}px;
            background: ${colors[Math.floor(Math.random() * colors.length)]};
            border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
            opacity: ${Math.random() * 0.8 + 0.2};
            z-index: 9999;
            pointer-events: none;
            animation: confetti-fall ${Math.random() * 3 + 2}s ease-out forwards;
            transform: rotate(${Math.random() * 360}deg);
        `;
        document.body.appendChild(c);
        setTimeout(() => c.remove(), 5000);
    }
})();

// Auto-print invoice option (optional)
// window.addEventListener('load', () => setTimeout(() => window.print(), 1000));
</script>

<style>
@keyframes confetti-fall {
    to {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
    }
}

/* Print styles */
@media print {
    .success-icon-wrap, button, a.bg-gradient-to-r, .bg-blue-50 { display: none !important; }
    body { background: white; }
}

/* Mobile optimizations */
@media (max-width: 640px) {
    main > div { padding: 16px; }
}
</style>

</body>
</html>