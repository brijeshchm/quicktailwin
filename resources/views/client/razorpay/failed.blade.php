<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Payment Declined — QuickDials</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="index, nofollow">
    <link rel="shortcut icon" href="{{ asset('client/images/favicon.png') }}" type="image/png" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50">
@php
    // Safely capture failure details from URL/session if available
    $orderId   = e($_GET['order_id']   ?? '');
    $reason    = e($_GET['reason']     ?? '');
    $amount    = e($_GET['amount']     ?? '');
    $paymentId = e($_GET['payment_id'] ?? '');
    $supportEmail = 'info@quickdials.com';
    $supportPhone = '+91-7595439543';
@endphp
<main class="min-h-screen relative overflow-hidden bg-gradient-to-br from-rose-50 via-white to-orange-50">

    {{-- Decorative orbs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-rose-200/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-orange-200/30 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-2xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        {{-- ════════════ ANIMATED FAILED ICON ════════════ --}}
        <div class="text-center mb-6 sm:mb-8">
            <div class="failed-icon-wrap relative inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 rounded-full
                        bg-gradient-to-br from-rose-400 to-red-500 mb-4 sm:mb-5
                        shadow-xl shadow-rose-300/50">
                <svg class="failed-cross w-10 h-10 sm:w-12 sm:h-12 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-2 tracking-tight">
                Payment Declined
            </h1>
            <p class="text-sm sm:text-base text-slate-500 max-w-md mx-auto">
                Don't worry — <strong class="text-slate-700">no money has been deducted</strong>.
                Let's get this sorted in 2 minutes.
            </p>
        </div>

        {{-- ════════════ FAILURE INFO CARD ════════════ --}}
        <div class="bg-white rounded-2xl shadow-xl shadow-rose-900/5 border border-rose-100/60 overflow-hidden mb-5">
            <div class="bg-gradient-to-r from-rose-500 to-red-500 px-6 py-5 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-rose-50/80 mb-1">Transaction Status</p>
                        <p class="text-2xl sm:text-3xl font-extrabold">Failed</p>
                    </div>
                    <svg class="w-10 h-10 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>

            {{-- Details if available --}}
            @if($orderId || $amount || $paymentId || $reason)
            <div class="divide-y divide-slate-100">
                @if($orderId)
                <div class="flex items-center justify-between px-6 py-3.5">
                    <span class="text-sm text-slate-500 font-medium">Order ID</span>
                    <span class="text-sm font-mono font-semibold text-slate-800">{{ $orderId }}</span>
                </div>
                @endif
                @if($amount)
                <div class="flex items-center justify-between px-6 py-3.5">
                    <span class="text-sm text-slate-500 font-medium">Amount</span>
                    <span class="text-sm font-semibold text-slate-800">₹{{ number_format((float)$amount, 2) }}</span>
                </div>
                @endif
                @if($paymentId)
                <div class="flex items-center justify-between px-6 py-3.5">
                    <span class="text-sm text-slate-500 font-medium">Reference ID</span>
                    <span class="text-sm font-mono font-semibold text-slate-800">{{ $paymentId }}</span>
                </div>
                @endif
                @if($reason)
                <div class="flex items-center justify-between px-6 py-3.5">
                    <span class="text-sm text-slate-500 font-medium">Reason</span>
                    <span class="text-sm font-semibold text-rose-600 text-right max-w-[200px]">{{ $reason }}</span>
                </div>
                @endif
            </div>
            @endif
        </div>

        {{-- ════════════ WHY THIS HAPPENED (collapsible) ════════════ --}}
        <div class="bg-white rounded-2xl shadow-lg shadow-slate-900/5 border border-slate-200/60 overflow-hidden mb-5"
             x-data="{ open: false }">
            <button @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50/60 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                        <span class="text-base">💡</span>
                    </div>
                    <span class="font-bold text-slate-800 text-sm">Why did this happen?</span>
                </div>
                <svg class="w-5 h-5 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="display: none;"
                 class="px-6 pb-5">
                <ul class="space-y-2.5 text-sm text-slate-600">
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mt-2 shrink-0"></span>
                        <span><strong class="text-slate-700">Insufficient balance</strong> — check your account funds</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mt-2 shrink-0"></span>
                        <span><strong class="text-slate-700">Incorrect details</strong> — verify card/UPI info</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mt-2 shrink-0"></span>
                        <span><strong class="text-slate-700">Bank declined</strong> — daily/transaction limit reached</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mt-2 shrink-0"></span>
                        <span><strong class="text-slate-700">Network issue</strong> — payment got interrupted</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mt-2 shrink-0"></span>
                        <span><strong class="text-slate-700">OTP expired</strong> — try again with a fresh OTP</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- ════════════ ACTION BUTTONS ════════════ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">

            {{-- Primary: Retry --}}
            <a href="{{ url('business/package') }}"
               class="group inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold
                      bg-gradient-to-r from-indigo-600 to-blue-600 text-white
                      shadow-lg shadow-indigo-300/40
                      hover:shadow-xl hover:shadow-indigo-400/50 hover:-translate-y-0.5
                      active:translate-y-0 transition-all duration-200">
                <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Try Payment Again
            </a>

            {{-- Secondary: Back --}}
            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl text-sm font-bold
                      bg-white text-slate-700 border-2 border-slate-200
                      hover:border-slate-300 hover:bg-slate-50 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        </div>

        {{-- ════════════ HELP CARD ════════════ --}}
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100/60 rounded-2xl p-5 sm:p-6 mb-6">
            <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                <span class="text-base">🤝</span> Need help? We're here for you
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                {{-- Email --}}
                <a href="mailto:{{ $supportEmail }}?subject=Payment Failed - Order {{ $orderId }}&body=Hi Support team,%0D%0A%0D%0AMy payment failed.%0D%0AOrder ID: {{ $orderId }}%0D%0AReference: {{ $paymentId }}%0D%0A%0D%0APlease help."
                   class="flex items-center gap-3 p-3.5 rounded-xl bg-white border border-blue-200/60 hover:border-blue-400 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Email Support</p>
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $supportEmail }}</p>
                    </div>
                </a>

                {{-- Phone / WhatsApp --}}
                <a href="https://wa.me/917595439543?text=Hi%2C%20my%20payment%20failed.%20Order%20ID%3A%20{{ $orderId }}"
                   target="_blank" rel="nofollow noopener noreferrer"
                   class="flex items-center gap-3 p-3.5 rounded-xl bg-white border border-emerald-200/60 hover:border-emerald-400 hover:shadow-md transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">WhatsApp Us</p>
                        <p class="text-xs font-bold text-slate-800">Chat instantly</p>
                    </div>
                </a>
            </div>

            <p class="text-[11px] text-slate-500 mt-3 text-center">
                Average response time: <strong class="text-slate-700">under 30 minutes</strong>
            </p>
        </div>

        {{-- ════════════ TRUST FOOTER ════════════ --}}
        <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 text-[11px] text-slate-400">
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">No money deducted</span>
            </div>
            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
            <div class="flex items-center gap-1.5">
                <span class="font-medium">Razorpay Verified</span>
            </div>
            <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
            <div class="flex items-center gap-1.5">
                <span class="font-medium">Refund (if any) in 5-7 days</span>
            </div>
        </div>

    </div>
</main>

{{-- ════════════ ANIMATIONS ════════════ --}}
<style>
@keyframes shake {
    0%, 100%       { transform: scale(1) translateX(0); }
    10%            { transform: scale(1.05) translateX(-3px); }
    20%, 40%, 60%  { transform: scale(1.05) translateX(3px); }
    30%, 50%, 70%  { transform: scale(1.05) translateX(-3px); }
    80%            { transform: scale(1.05) translateX(2px); }
    90%            { transform: scale(1.05) translateX(-2px); }
}
@keyframes drawCross {
    from { stroke-dashoffset: 50; }
    to   { stroke-dashoffset: 0; }
}
@keyframes pulse-ring {
    0%   { transform: scale(0.9); opacity: 0.8; }
    100% { transform: scale(1.6); opacity: 0; }
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.failed-icon-wrap {
    animation: shake .6s ease-out .2s backwards;
}
.failed-icon-wrap::before {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f43f5e, #ef4444);
    z-index: -1;
    animation: pulse-ring 1.8s ease-out infinite;
}
.failed-cross path {
    stroke-dasharray: 50;
    stroke-dashoffset: 50;
    animation: drawCross .5s ease-out .5s forwards;
}
main > div > div { animation: slideUp .5s ease backwards; }
main > div > div:nth-child(2) { animation-delay: 0.15s; }
main > div > div:nth-child(3) { animation-delay: 0.25s; }
main > div > div:nth-child(4) { animation-delay: 0.35s; }
main > div > div:nth-child(5) { animation-delay: 0.45s; }

/* Mobile tweaks */
@media (max-width: 640px) {
    main > div { padding: 16px 12px; }
}
</style>

{{-- Alpine.js for accordion --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>