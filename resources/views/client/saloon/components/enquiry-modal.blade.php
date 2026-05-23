{{--
    resources/views/components/enquiry-modal.blade.php

    4-step booking enquiry modal with phone OTP verification.
    - Pure Tailwind for styling
    - Alpine.js for all interactivity, AJAX, OTP UX
    - Self-contained: include anywhere a trigger button can dispatch
      `window.dispatchEvent(new CustomEvent('open-enquiry'))`

    Usage:
        @include('components.enquiry-modal')

        <button onclick="window.dispatchEvent(new CustomEvent('open-enquiry'))">
            Book Now
        </button>

    Required in layout <head>:
        <meta name="csrf-token" content="{{ csrf_token() }}">
--}}

@php
    $services = config('booking.services');
    $slots    = config('booking.slots');
    $country  = config('booking.phone.country_code', '+91');
    $digits   = (int) config('booking.phone.digits', 10);
    $otpLen   = (int) config('booking.otp.length', 6);
@endphp

<div
    x-data="enquiryModal({
        services:    {{ Js::from($services) }},
        slots:       {{ Js::from($slots) }},
        countryCode: {{ Js::from($country) }},
        phoneDigits: {{ $digits }},
        otpLength:   {{ $otpLen }},
        sendOtpUrl:  '{{ route('booking.otp') }}',
        storeUrl:    '{{ route('booking.store') }}',
        csrf:        document.querySelector('meta[name=csrf-token]')?.content,
    })"
    @open-enquiry.window="open()"
    @keydown.window.escape="if (isOpen) close()"
    x-cloak
>
    {{-- ─── BACKDROP + CENTERED MODAL ─────────────────────────── --}}
    <div
        x-show="isOpen"
        x-transition.opacity.duration.200ms
        @click.self="close()"
        class="fixed inset-0 z-[10000] flex items-end justify-center bg-black/55 p-0 backdrop-blur-sm sm:items-center sm:p-4"
    >
        {{-- Modal card --}}
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-5 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative max-h-[95vh] w-full max-w-[480px] overflow-hidden rounded-t-3xl bg-white shadow-2xl sm:rounded-3xl"
        >
            {{-- ═══════════════════════════════════════════════
                 HEADER (orange gradient)
            ═══════════════════════════════════════════════ --}}
            <div class="relative bg-gradient-to-br from-orange-500 to-orange-600 px-6 pt-5 pb-4">
                {{-- Close button --}}
                <button
                    type="button"
                    @click="close()"
                    aria-label="Close"
                    class="absolute right-3.5 top-3.5 flex h-7 w-7 items-center justify-center rounded-full bg-white/20 text-white transition hover:bg-white/30"
                >✕</button>

                {{-- Title + subtitle --}}
                <div class="mb-1 font-serif text-xl font-extrabold text-white">
                    <span x-show="step < 4">Book Your Treatment</span>
                    <span x-show="step === 4">You're All Set!</span>
                </div>
                <div class="text-[11px] font-medium text-white/80">
                    <span x-show="step === 1">Step 1 of 3 · Enter your details</span>
                    <span x-show="step === 2">Step 2 of 3 · Choose your treatment</span>
                    <span x-show="step === 3">Step 3 of 3 · Verify your mobile number</span>
                    <span x-show="step === 4">Booking request submitted successfully</span>
                </div>

                {{-- Step pills --}}
                <div class="mt-3.5 flex gap-1.5">
                    <template x-for="(lbl, i) in stepLabels" :key="lbl">
                        <div class="flex flex-1 flex-col items-center gap-1">
                            <div
                                class="flex h-6 w-6 items-center justify-center rounded-full text-[11px] font-extrabold transition-all duration-300"
                                :class="step > (i+1) ? 'bg-white text-orange-600'
                                      : step === (i+1) ? 'bg-white/90 text-orange-600 ring-[3px] ring-white/30'
                                      : 'bg-white/25 text-white/60'"
                            >
                                <span x-text="step > (i+1) ? '✓' : (i+1)"></span>
                            </div>
                            <div
                                class="text-[9px] font-semibold uppercase tracking-wider"
                                :class="step === (i+1) ? 'text-white' : 'text-white/55'"
                                x-text="lbl"
                            ></div>
                        </div>
                    </template>
                </div>

                {{-- Progress bar --}}
                <div class="mt-3.5 h-[3px] overflow-hidden rounded-full bg-white/20">
                    <div
                        class="h-full rounded-full bg-white transition-[width] duration-400"
                        :style="`width: ${((step - 1) / 3) * 100}%`"
                    ></div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════
                 BODY — scrollable so long content works on phones
            ═══════════════════════════════════════════════ --}}
            <div class="max-h-[calc(95vh-180px)] overflow-y-auto p-6">

                {{-- ─── STEP 1: Name + Phone ─── --}}
                <div x-show="step === 1" class="flex flex-col gap-4">
                    <div>
                        <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                            Full Name <span class="text-orange-500">*</span>
                        </label>
                        <input
                            type="text"
                            x-model.trim="form.name"
                            placeholder="Priya Sharma"
                            maxlength="100"
                            class="w-full rounded-xl border-[1.5px] border-slate-200 bg-white px-3.5 py-2.5 text-sm transition-colors focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20"
                            :class="errors.name ? 'border-red-400' : ''"
                        >
                        <p x-show="errors.name" class="mt-1 text-xs text-red-500" x-text="errors.name?.[0]"></p>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                            Mobile Number <span class="text-orange-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <div class="flex w-16 flex-shrink-0 items-center justify-center rounded-xl border-[1.5px] border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm font-bold text-slate-700">
                                {{ $country }}
                            </div>
                            <input
                                type="tel"
                                x-model="form.phone"
                                @input="form.phone = form.phone.replace(/\D/g,'').slice(0, phoneDigits)"
                                placeholder="98765 43210"
                                inputmode="numeric"
                                :maxlength="phoneDigits"
                                class="w-full rounded-xl border-[1.5px] border-slate-200 bg-white px-3.5 py-2.5 text-sm transition-colors focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20"
                                :class="errors.phone ? 'border-red-400' : ''"
                            >
                        </div>
                        <p x-show="errors.phone" class="mt-1 text-xs text-red-500" x-text="errors.phone?.[0]"></p>
                        <p x-show="!errors.phone" class="mt-1 text-[11px] text-slate-400">
                            OTP will be sent to verify this number
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="goToStep(2)"
                        :disabled="!canProceedStep1"
                        class="w-full rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 px-4 py-3 text-sm font-extrabold text-white shadow-lg shadow-orange-500/40 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-45 disabled:hover:translate-y-0"
                    >
                        Next →
                    </button>
                </div>

                {{-- ─── STEP 2: Treatment + Date + Time ─── --}}
                <div x-show="step === 2" class="flex flex-col gap-4">
                    <div>
                        <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                            Select Treatment <span class="text-orange-500">*</span>
                        </label>
                        <select
                            x-model="form.service"
                            class="w-full rounded-xl border-[1.5px] border-slate-200 bg-white px-3.5 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20"
                        >
                            <option value="">— Choose a treatment —</option>
                            <template x-for="s in services" :key="s">
                                <option :value="s" x-text="s"></option>
                            </template>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                                Date <span class="text-orange-500">*</span>
                            </label>
                            <input
                                type="date"
                                x-model="form.date"
                                :min="today"
                                class="w-full rounded-xl border-[1.5px] border-slate-200 bg-white px-3.5 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20"
                            >
                        </div>
                        <div>
                            <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                                Time <span class="text-orange-500">*</span>
                            </label>
                            <select
                                x-model="form.time"
                                class="w-full rounded-xl border-[1.5px] border-slate-200 bg-white px-3.5 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20"
                            >
                                <option value="">— Pick slot —</option>
                                <template x-for="s in slots" :key="s">
                                    <option :value="s" x-text="s"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wider text-slate-700">
                            Special Requests <span class="font-normal normal-case text-slate-400">(optional)</span>
                        </label>
                        <textarea
                            x-model="form.notes"
                            rows="2"
                            maxlength="1000"
                            placeholder="Allergies, preferences, occasion…"
                            class="w-full resize-none rounded-xl border-[1.5px] border-slate-200 bg-white px-3.5 py-2.5 text-sm focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20"
                        ></textarea>
                    </div>

                    {{-- 🍯 Honeypot --}}
                    <div class="hidden" aria-hidden="true">
                        <input type="text" x-model="form.website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="flex gap-2">
                        <button
                            type="button"
                            @click="step = 1"
                            class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-600 transition-colors hover:bg-slate-50"
                        >← Back</button>
                        <button
                            type="button"
                            @click="requestOtp()"
                            :disabled="!canProceedStep2 || sendingOtp"
                            class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 px-4 py-3 text-sm font-extrabold text-white shadow-lg shadow-orange-500/40 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-45 disabled:hover:translate-y-0"
                        >
                            <svg x-show="sendingOtp" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-opacity="0.25"/>
                                <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                            <span x-text="sendingOtp ? 'Sending OTP…' : 'Verify with OTP →'"></span>
                        </button>
                    </div>
                </div>

                {{-- ─── STEP 3: OTP Entry ─── --}}
                <div x-show="step === 3" class="flex flex-col items-center gap-5">
                    <div class="text-center">
                        <div class="mb-2 text-3xl">📱</div>
                        <div class="mb-1 text-[0.95rem] font-bold text-slate-900">
                            OTP sent to {{ $country }} <span x-text="form.phone"></span>
                        </div>
                        <div class="text-xs text-slate-400">
                            Enter the {{ $otpLen }}-digit code to confirm your booking
                        </div>
                    </div>

                    {{-- Demo OTP hint (visible only when backend is in demo mode) --}}
                    <div
                        x-show="demoOtp"
                        class="w-full rounded-xl border-[1.5px] border-dashed border-orange-500 bg-orange-50 px-4 py-2 text-center text-xs font-bold text-orange-600"
                    >
                        🔐 Demo OTP: <span class="text-base tracking-[0.2em]" x-text="demoOtp"></span>
                    </div>

                    {{-- {{ $otpLen }} digit boxes --}}
                    <div class="flex gap-2">
                        <template x-for="(d, i) in otp" :key="i">
                            <input
                                type="text"
                                inputmode="numeric"
                                maxlength="1"
                                :value="otp[i]"
                                @input="onOtpInput(i, $event)"
                                @keydown="onOtpKeydown(i, $event)"
                                @paste="onOtpPaste($event)"
                                :ref="el => otpRefs[i] = el"
                                class="h-13 w-11 rounded-xl border-2 text-center text-[1.3rem] font-extrabold text-slate-900 outline-none transition-colors"
                                :class="otp[i]
                                    ? 'border-orange-500 bg-orange-50'
                                    : 'border-slate-200 bg-white'"
                                style="height: 52px;"
                            >
                        </template>
                    </div>

                    <p x-show="errors.otp" class="text-xs font-semibold text-red-500" x-text="errors.otp?.[0]"></p>

                    <button
                        type="button"
                        @click="submit()"
                        :disabled="otp.join('').length < otpLength || submitting"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 px-4 py-3 text-sm font-extrabold text-white shadow-lg shadow-orange-500/40 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-45 disabled:hover:translate-y-0"
                    >
                        <svg x-show="submitting" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-opacity="0.25"/>
                            <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                        <span x-text="submitting ? 'Verifying…' : 'Verify & Confirm Booking →'"></span>
                    </button>

                    <div class="text-[11px] text-slate-400">
                        <template x-if="resendTimer > 0">
                            <span>Resend OTP in <span x-text="resendTimer"></span>s</span>
                        </template>
                        <template x-if="resendTimer <= 0">
                            <button
                                type="button"
                                @click="requestOtp()"
                                :disabled="sendingOtp"
                                class="cursor-pointer border-none bg-transparent text-[11px] font-bold text-orange-500 disabled:opacity-50"
                            >Resend OTP</button>
                        </template>
                    </div>
                </div>

                {{-- ─── STEP 4: Success ─── --}}
                <div x-show="step === 4" class="py-2 text-center">
                    {{-- Animated check --}}
                    <div
                        class="mx-auto mb-5 flex h-[72px] w-[72px] items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-green-600 shadow-lg shadow-green-500/35"
                        style="animation: enquiryBounce 1.2s ease infinite;"
                    >
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                             style="stroke-dasharray:100;stroke-dashoffset:0;animation:enquiryCheck 0.5s ease forwards;">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>

                    <div class="mb-1 font-serif text-[1.2rem] font-extrabold text-slate-900">
                        Booking Requested!
                    </div>
                    <div class="mb-5 text-sm text-slate-500" x-text="successMessage"></div>

                    {{-- Summary card --}}
                    <div class="mb-5 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-left">
                        <template x-for="row in summaryRows" :key="row[0]">
                            <div
                                x-show="row[1]"
                                class="flex gap-2 border-b border-slate-100 py-1.5 text-[13px] last:border-0"
                            >
                                <span class="min-w-[110px] text-slate-400" x-text="row[0]"></span>
                                <span class="font-semibold text-slate-900" x-text="row[1]"></span>
                            </div>
                        </template>
                    </div>

                    <div class="mb-5 rounded-xl border-[1.5px] border-orange-500/20 bg-orange-50 px-4 py-2.5 text-[11px] text-amber-800">
                        📞 Our team will call you on
                        <strong>{{ $country }} <span x-text="form.phone"></span></strong>
                        to confirm the booking.
                    </div>

                    <button
                        type="button"
                        @click="close()"
                        class="w-full rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 px-4 py-3 text-sm font-extrabold text-white shadow-lg shadow-orange-500/40 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl"
                    >Done</button>
                </div>

            </div>
        </div>
    </div>

    {{-- Keyframes (Tailwind doesn't ship custom ones natively) --}}
    <style>
        @keyframes enquiryCheck    { from { stroke-dashoffset: 100; } to { stroke-dashoffset: 0; } }
        @keyframes enquiryBounce   { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        [x-cloak] { display: none !important; }
    </style>
</div>

{{-- ═══════════════════════════════════════════════════════════
     ALPINE COMPONENT LOGIC
═══════════════════════════════════════════════════════════ --}}
<script>
function enquiryModal(config) {
    return {
        // ── Config (from server) ──
        services:    config.services,
        slots:       config.slots,
        countryCode: config.countryCode,
        phoneDigits: config.phoneDigits,
        otpLength:   config.otpLength,
        sendOtpUrl:  config.sendOtpUrl,
        storeUrl:    config.storeUrl,
        csrf:        config.csrf,

        // ── UI state ──
        isOpen:        false,
        step:          1,
        stepLabels:    ['Details', 'Treatment', 'Verify', 'Confirmed'],
        sendingOtp:    false,
        submitting:    false,
        resendTimer:   0,
        resendInterval: null,
        demoOtp:       '',
        successMessage:'',
        errors:        {},

        // ── OTP entry ──
        otp:     [],
        otpRefs: [],

        // ── Form ──
        form: {
            name: '', phone: '', service: '', date: '', time: '',
            notes: '', website: '',  // honeypot
        },

        /* ───────────── Lifecycle ───────────── */
        init() {
            this.otp = Array(this.otpLength).fill('');
        },

        open() {
            this.reset();
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },

        close() {
            this.isOpen = false;
            document.body.style.overflow = '';
            this.clearResendTimer();
        },

        reset() {
            this.step = 1;
            this.form = { name: '', phone: '', service: '', date: '', time: '', notes: '', website: '' };
            this.otp = Array(this.otpLength).fill('');
            this.errors = {};
            this.demoOtp = '';
            this.successMessage = '';
            this.sendingOtp = false;
            this.submitting = false;
            this.clearResendTimer();
        },

        /* ───────────── Computed ───────────── */
        get canProceedStep1() {
            return this.form.name.trim().length >= 2
                && this.form.phone.length === this.phoneDigits;
        },

        get canProceedStep2() {
            return !!(this.form.service && this.form.date && this.form.time);
        },

        get today() {
            return new Date().toISOString().split('T')[0];
        },

        get summaryRows() {
            const dateLabel = this.form.date
                ? new Date(this.form.date + 'T00:00:00').toLocaleDateString('en-IN', {
                    weekday: 'short', day: 'numeric', month: 'short', year: 'numeric',
                  })
                : '';
            return [
                ['👤 Name',     this.form.name],
                ['📱 Mobile',   this.countryCode + ' ' + this.form.phone],
                ['🌸 Treatment', this.form.service],
                ['📅 Date',     dateLabel],
                ['⏰ Time',     this.form.time],
                ['📝 Notes',    this.form.notes],
            ];
        },

        /* ───────────── Step nav ───────────── */
        goToStep(n) {
            this.errors = {};
            this.step = n;
        },

        /* ───────────── OTP send / resend ───────────── */
        async requestOtp() {
            if (this.sendingOtp) return;
            this.errors = {};
            this.sendingOtp = true;

            try {
                const res = await fetch(this.sendOtpUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type':      'application/json',
                        'Accept':            'application/json',
                        'X-CSRF-TOKEN':      this.csrf,
                        'X-Requested-With':  'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        name:  this.form.name,
                        phone: this.form.phone,
                    }),
                });
                const data = await res.json();

                if (!res.ok) {
                    this.errors._general = data.message || 'Could not send OTP.';
                    if (data.errors) this.errors = { ...this.errors, ...data.errors };
                    return;
                }

                this.demoOtp = data.demo_otp || '';
                this.startResendTimer(data.resend_seconds || 30);
                this.step = 3;
                this.otp = Array(this.otpLength).fill('');

                // Auto-focus first OTP box after the DOM updates
                this.$nextTick(() => this.otpRefs[0]?.focus());

            } catch (e) {
                this.errors._general = 'Network error. Please try again.';
            } finally {
                this.sendingOtp = false;
            }
        },

        startResendTimer(seconds) {
            this.clearResendTimer();
            this.resendTimer = seconds;
            this.resendInterval = setInterval(() => {
                this.resendTimer--;
                if (this.resendTimer <= 0) this.clearResendTimer();
            }, 1000);
        },

        clearResendTimer() {
            if (this.resendInterval) clearInterval(this.resendInterval);
            this.resendInterval = null;
        },

        /* ───────────── OTP input handling ───────────── */
        onOtpInput(i, e) {
            const v = e.target.value.replace(/\D/g, '').slice(-1);
            this.otp[i] = v;
            e.target.value = v;
            // Auto-advance
            if (v && i < this.otpLength - 1) {
                this.otpRefs[i + 1]?.focus();
            }
        },

        onOtpKeydown(i, e) {
            // Backspace on empty cell → move to previous
            if (e.key === 'Backspace' && !this.otp[i] && i > 0) {
                this.otpRefs[i - 1]?.focus();
            }
            // Left/Right arrow nav
            if (e.key === 'ArrowLeft'  && i > 0)                  this.otpRefs[i - 1]?.focus();
            if (e.key === 'ArrowRight' && i < this.otpLength - 1) this.otpRefs[i + 1]?.focus();
        },

        onOtpPaste(e) {
            e.preventDefault();
            const txt = (e.clipboardData || window.clipboardData).getData('text');
            const digits = txt.replace(/\D/g, '').slice(0, this.otpLength).split('');
            digits.forEach((d, idx) => {
                this.otp[idx] = d;
                if (this.otpRefs[idx]) this.otpRefs[idx].value = d;
            });
            // Focus the next empty cell, or the last cell
            const nextIdx = Math.min(digits.length, this.otpLength - 1);
            this.otpRefs[nextIdx]?.focus();
        },

        /* ───────────── Submit booking ───────────── */
        async submit() {
            if (this.submitting) return;
            this.errors = {};
            this.submitting = true;

            try {
                const res = await fetch(this.storeUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type':      'application/json',
                        'Accept':            'application/json',
                        'X-CSRF-TOKEN':      this.csrf,
                        'X-Requested-With':  'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        name:           this.form.name,
                        phone:          this.form.phone,
                        service:        this.form.service,
                        preferred_date: this.form.date,
                        preferred_time: this.form.time,
                        notes:          this.form.notes,
                        otp:            this.otp.join(''),
                        website:        this.form.website,
                    }),
                });
                const data = await res.json();

                if (res.status === 422) {
                    this.errors = data.errors || {};
                    return;
                }
                if (res.status === 429) {
                    this.errors._general = data.message || 'Rate limit hit.';
                    return;
                }
                if (!res.ok) {
                    this.errors._general = data.message || 'Could not submit booking.';
                    return;
                }

                this.successMessage = data.message || "We'll confirm your appointment within 2 hours.";
                this.step = 4;

            } catch (e) {
                this.errors._general = 'Network error. Please try again.';
            } finally {
                this.submitting = false;
            }
        },
    };
}
</script>
