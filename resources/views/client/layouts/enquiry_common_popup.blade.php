{{-- resources/views/business/partials/enquiry-form.blade.php --}}
<div data-enquiry-form class="rounded-2xl border overflow-hidden" style="border-color:rgba(59,130,246,.15);">

    {{-- Header --}}
    <div class="px-6 py-5" style="background:linear-gradient(135deg,#2563EB 0%,#0891b2 100%);">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-white text-lg">Make an Enquiry</h3>
           
            <button onclick="document.getElementById('enquiry-modal').classList.remove('open')"
                    class="w-8 h-8 rounded-full flex items-center justify-center text-white/70 hover:text-white"
                    style="background:rgba(255,255,255,.12);">✕</button>
            
        </div>

        {{-- Step indicators --}}
        <div class="flex items-center gap-0">
            @foreach(['Contact','Details','Message','Verify'] as $si => $label)
            <div class="flex items-center flex-1 last:flex-none">
                <div class="flex flex-col items-center gap-1">
                    <div class="step-dot {{ $si===0 ? 'active' : 'pending' }}"
                         data-dot="{{ $si+1 }}"
                         style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;
                                {{ $si===0 ? 'background:#fff;color:#2563eb;' : 'background:rgba(255,255,255,.2);color:rgba(255,255,255,.7);' }}">
                        {{ $si+1 }}
                    </div>
                    <span class="text-[9px] font-semibold {{ $si===0 ? 'text-white' : 'text-white/50' }}">{{ $label }}</span>
                </div>
                @if($si < 3)
                <div class="step-line flex-1 h-px mx-1" data-line="{{ $si+1 }}"
                     style="{{ $si===0 ? 'background:rgba(255,255,255,.5);' : 'background:rgba(255,255,255,.2);' }}"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Body --}}
    <div class="bg-white px-6 py-5">

        {{-- ══ STEP 1 — Contact ══ --}}
        <div data-step="1">
            <p class="text-sm font-semibold text-gray-500 mb-4">Step 1 — Your contact details</p>
            <div class="space-y-3">

                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Full Name *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">👤</span>
                        <input type="text" id="ef-name" placeholder="Enter your name"
                               class="ef-input pl-9 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition-all">
                    </div>
                    <p id="err-name" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Email Address *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">✉️</span>
                        <input type="email" id="ef-email" placeholder="Enter Email"
                               class="ef-input pl-9 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition-all">
                    </div>
                    <p id="err-email" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Mobile Number *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">📞</span>
                        <input type="tel" id="ef-phone" placeholder="Enter Phone"
                               maxlength="10"
                               class="ef-input pl-9 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition-all">
                    </div>
                    <p id="err-phone" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <button onclick="efNext(1)"
                        class="w-full py-3 mt-2 rounded-xl font-bold text-white text-sm transition-colors hover:opacity-90"
                        style="background:#2563eb;">
                    Continue →
                </button>
            </div>
        </div>

        {{-- ══ STEP 2 — Details ══ --}}
        <div data-step="2" class="hidden">
            <p class="text-sm font-semibold text-gray-500 mb-4">Step 2 — Booking details</p>
            <div class="space-y-3">

                {{-- Searchable Service Dropdown --}}
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Service *</label>
                    <input type="hidden" id="kw_text_value" name="kw_text" value="">
                    <div class="relative" id="service-dropdown">
                        <button type="button" onclick="toggleServiceDropdown()"
                                class="w-full flex items-center justify-between gap-2 border border-gray-200 rounded-xl px-4 py-2.5 bg-white text-left hover:border-blue-300 transition-all">
                            <span id="service-selected-label" class="text-sm text-gray-400">Select a service…</span>
                            <svg id="service-chevron" class="w-4 h-4 text-gray-400 shrink-0 transition-transform duration-200"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="service-panel"
                             class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-xl z-[60] overflow-hidden">
                            <div class="p-2 border-b border-gray-100 sticky top-0 bg-white">
                                <div class="flex items-center gap-2 bg-gray-50 rounded-lg px-3 py-2 border border-gray-200 focus-within:border-blue-400 transition-all">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                                    </svg>
                                    <input type="text" id="service-search-input"
                                           placeholder="Search services..."
                                           autocomplete="off"
                                           class="flex-1 text-sm bg-transparent outline-none text-gray-700 placeholder-gray-400"
                                           onkeyup="handleServiceSearch(this.value)" onclick="searchKeyEmpty()">
                                    <button type="button" id="service-search-clear"
                                            onclick="clearServiceSearch()"
                                            class="hidden text-gray-300 hover:text-gray-500 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div id="service-loading" class="hidden flex items-center gap-2 px-4 py-3">
                                <div class="w-4 h-4 border-2 border-blue-200 border-t-blue-500 rounded-full animate-spin shrink-0"></div>
                                <span class="text-sm text-gray-400">Searching...</span>
                            </div>
                            <ul id="service-options-list" class="max-h-48 overflow-y-auto py-1"></ul>
                            <div id="service-empty" class="hidden px-4 py-4 text-center text-sm text-gray-400">
                                No services found
                            </div>
                        </div>
                    </div>
                    <p id="err-service" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                {{-- Age Range --}}
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Age Range</label>
                    <select id="ef-age" name="age"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none bg-white focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition-all">
                        <option value="">Select Age Range</option>
                        @foreach(['Under 20','20 – 24','25 – 29','30 – 34','35 – 39','40 – 44','45 – 49','50 – 54','55 – 59','60+'] as $age)
                        <option value="{{ $age }}" {{ $age == '25 – 29' ? 'selected' : '' }}>{{ $age }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Timeline --}}
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">When do you want to Start? *</label>
                    <select id="ef-plan" name="plan"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none bg-white focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition-all">
                        <option value="">Select timeline…</option>
                        @foreach(['Immediately','Within 1 Week','Within 1 Month','Within 3 Months','Within 6 Months','Just Exploring'] as $timeline)
                        <option value="{{ $timeline }}" {{ $timeline == 'Immediately' ? 'selected' : '' }}>{{ $timeline }}</option>
                        @endforeach
                    </select>
                    <p id="err-plan" class="text-xs text-red-500 mt-1 hidden"></p>
                </div>

                <div class="flex gap-2 mt-2">
                    <button onclick="efBack(2)"
                            class="flex-1 py-2.5 rounded-xl font-semibold text-blue-600 border border-blue-200 hover:bg-blue-50 text-sm transition-colors">
                        ← Back
                    </button>
                    <button onclick="efNext(2)"
                            class="flex-1 py-2.5 rounded-xl font-semibold text-white text-sm transition-colors hover:opacity-90"
                            style="background:#2563eb;">
                        Continue →
                    </button>
                </div>
            </div>
        </div>

        {{-- ══ STEP 3 — Message ══ --}}
        <div data-step="3" class="hidden">
            <p class="text-sm font-semibold text-gray-500 mb-4">Step 3 — Additional message</p>
            <div class="space-y-3">
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Message</label>
                    <textarea id="ef-comment" name="comment" rows="4"
                              placeholder="Any special requests or questions…"
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition-all resize-none"></textarea>
                </div>
                <div class="flex gap-2 mt-2">
                    <button onclick="efBack(3)"
                            class="flex-1 py-2.5 rounded-xl font-semibold text-blue-600 border border-blue-200 hover:bg-blue-50 text-sm transition-colors">
                        ← Back
                    </button>
                    <button onclick="efSend()"
                            id="ef-send-btn"
                            class="flex-1 py-2.5 rounded-xl font-semibold text-white text-sm flex items-center justify-center gap-1.5 transition-colors hover:opacity-90"
                            style="background:#2563eb;">
                        Send Enquiry ✓
                    </button>
                </div>
            </div>
        </div>

        {{-- ══ STEP 4 — OTP ══ --}}
        <div data-step="4" class="hidden">
            <div class="text-center mb-5">
                <div class="w-12 h-12 mx-auto mb-3 rounded-full flex items-center justify-center text-2xl"
                     style="background:rgba(37,99,235,.08);">🔒</div>
                <p class="text-sm font-bold text-gray-800">Verify your email</p>
                <p class="text-xs text-gray-400 mt-1">
                    OTP sent to <span id="ef-otp-email" class="font-semibold text-gray-600"></span>
                </p>
            </div>

            {{-- OTP boxes --}}
            <div class="flex gap-2 justify-center mb-2" id="ef-otp-inputs">
                @for($o = 0; $o < 6; $o++)
                <input type="text" inputmode="numeric" maxlength="1"
                       data-otp-idx="{{ $o }}"
                       class="otp-box text-center text-xl font-bold border-2 border-gray-200 rounded-xl outline-none transition-all focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                       style="width:44px;height:52px;">
                @endfor
            </div>

            <p id="err-otp" class="text-xs text-red-500 text-center mb-3 hidden"></p>

            {{-- Resend --}}
            <p class="text-center text-xs text-gray-400 mb-4">
                Didn't receive it?
                <span id="ef-resend-countdown">Resend in <span id="ef-countdown-num" class="font-semibold text-blue-500">30</span>s</span>
                <button id="ef-resend-btn" onclick="efResendOtp()"
                        class="hidden text-blue-500 hover:text-blue-700 font-semibold transition-colors">
                    Resend OTP
                </button>
            </p>

            <div class="flex gap-2">
                <button onclick="efBack(4)"
                        class="flex-1 py-2.5 rounded-xl font-semibold text-blue-600 border border-blue-200 hover:bg-blue-50 text-sm transition-colors">
                    ← Back
                </button>
                <button onclick="efVerifyOtp()"
                        id="ef-verify-btn"
                        class="flex-1 py-2.5 rounded-xl font-semibold text-white text-sm transition-colors hover:opacity-90 flex items-center justify-center gap-1.5"
                        style="background:#2563eb;">
                    Verify & Submit
                </button>
            </div>
        </div>

        {{-- ══ SUCCESS ══ --}}
        <div data-success class="hidden flex flex-col items-center py-8 text-center gap-4">
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-3xl"
                 style="background:rgba(37,99,235,.08);">✅</div>
            <div>
                <p class="font-bold text-gray-900 text-lg">Enquiry Sent!</p>
                <p class="text-sm text-gray-400 mt-1">We'll get back to you within 24 hours.</p>
            </div>
            <button onclick="location.reload()"
                    class="px-5 py-2 rounded-full text-sm font-semibold text-blue-600 border border-blue-200 hover:bg-blue-50 transition-colors">
                New Enquiry
            </button>
        </div>

    </div>
</div>

<script>
(function () {

    // ═══════════════════════════════════════════════════════
    // STEP NAVIGATION
    // ═══════════════════════════════════════════════════════
    const CSRF = () => document.querySelector('meta[name="csrf-token"]').content;

    function efShowStep(n) {
        document.querySelectorAll('[data-step]').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('[data-success]').forEach(el => el.classList.add('hidden'));
        const target = document.querySelector(`[data-step="${n}"]`);
        if (target) target.classList.remove('hidden');
        updateStepUI(n);
    }

    function updateStepUI(current) {
        // Dots
        document.querySelectorAll('[data-dot]').forEach(dot => {
            const n = parseInt(dot.dataset.dot);
            if (n < current) {
                dot.style.background = '#fff';
                dot.style.color = '#16a34a';
                dot.innerHTML = '✓';
            } else if (n === current) {
                dot.style.background = '#fff';
                dot.style.color = '#2563eb';
                dot.innerHTML = n;
            } else {
                dot.style.background = 'rgba(255,255,255,.2)';
                dot.style.color = 'rgba(255,255,255,.7)';
                dot.innerHTML = n;
            }
        });

        // Lines
        document.querySelectorAll('[data-line]').forEach(line => {
            const n = parseInt(line.dataset.line);
            line.style.background = n < current ? 'rgba(255,255,255,.9)' : 'rgba(255,255,255,.2)';
        });

        // Step labels
        document.querySelectorAll('.step-dot + span, [data-dot] ~ span').forEach((span, i) => {
            span.style.opacity = (i + 1) === current ? '1' : '0.5';
        });
    }

    window.efBack = function (currentStep) {
        efShowStep(currentStep - 1);
    };

    // ═══════════════════════════════════════════════════════
    // VALIDATION HELPERS
    // ═══════════════════════════════════════════════════════
    function showErr(id, msg) {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = msg;
        el.classList.remove('hidden');
        // Shake the input
        const input = el.previousElementSibling?.querySelector('input,select,textarea')
                   || el.previousElementSibling;
        if (input) {
            input.classList.add('border-red-400', 'ring-2', 'ring-red-100');
            setTimeout(() => input.classList.remove('border-red-400', 'ring-2', 'ring-red-100'), 2000);
        }
    }

    function hideErr(id) {
        const el = document.getElementById(id);
        if (el) el.classList.add('hidden');
    }

    function setLoading(btnId, loading, defaultHTML) {
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.disabled = loading;
        btn.innerHTML = loading
            ? `<span class="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span> Please wait…`
            : defaultHTML;
    }

    // ═══════════════════════════════════════════════════════
    // STEP 1 VALIDATION
    // ═══════════════════════════════════════════════════════
    window.efNext = function (step) {
        if (step === 1) {
            const name  = document.getElementById('ef-name').value.trim();
            const email = document.getElementById('ef-email').value.trim();
            const phone = document.getElementById('ef-phone').value.trim();
            let valid   = true;

            hideErr('err-name'); hideErr('err-email'); hideErr('err-phone');

            if (!name || name.length < 2) {
                showErr('err-name', 'Please enter your full name (at least 2 characters).');
                valid = false;
            }
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showErr('err-email', 'Please enter a valid email address.');
                valid = false;
            }
            if (!phone || !/^[6-9]\d{9}$/.test(phone)) {
                showErr('err-phone', 'Please enter a valid 10-digit Indian mobile number.');
                valid = false;
            }
            if (valid) efShowStep(2);
        }

        if (step === 2) {
            const service = document.getElementById('kw_text_value').value.trim();
            const plan    = document.getElementById('ef-plan').value.trim();
            let valid     = true;

            hideErr('err-service'); hideErr('err-plan');

            if (!service) {
                showErr('err-service', 'Please select a service.');
                valid = false;
            }
            if (!plan) {
                showErr('err-plan', 'Please select when you want to start.');
                valid = false;
            }
            if (valid) efShowStep(3);
        }
    };

    // ═══════════════════════════════════════════════════════
    // STEP 3 — SEND ENQUIRY + OTP
    // ═══════════════════════════════════════════════════════
    window.efSend = async function () {
        setLoading('ef-send-btn', true, 'Send Enquiry ✓');

        const payload = {
            name:    document.getElementById('ef-name').value.trim(),
            email:   document.getElementById('ef-email').value.trim(),
            phone:   document.getElementById('ef-phone').value.trim(),
            kw_text: document.getElementById('kw_text_value').value.trim(),
            age:     document.getElementById('ef-age').value,
            plan:    document.getElementById('ef-plan').value,
            comment: document.getElementById('ef-comment').value.trim(),
        };

        try {
            const res  = await fetch('/client/enquirySendOtp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                },
                body: JSON.stringify({ email: payload.email, formData: payload }),
            });
            const data = await res.json();

            if (data.status) {
                document.getElementById('ef-otp-email').textContent = payload.email;
                efShowStep(4);
                initOtpBoxes();
                efStartCountdown();
                setTimeout(() => document.querySelector('[data-otp-idx="0"]')?.focus(), 100);
            } else {
                alert(data.message || 'Failed to send OTP. Please try again.');
            }
        } catch {
            alert('Network error. Please try again.');
        } finally {
            setLoading('ef-send-btn', false, 'Send Enquiry ✓');
        }
    };

    // ═══════════════════════════════════════════════════════
    // OTP BOXES
    // ═══════════════════════════════════════════════════════
    function initOtpBoxes() {
        const boxes = document.querySelectorAll('[data-otp-idx]');
        boxes.forEach((box, idx) => {
            box.value = '';
            box.classList.remove('border-blue-500', 'bg-blue-50');
            box.classList.add('border-gray-200');

            box.oninput = function () {
                const char = this.value.replace(/\D/g, '').slice(-1);
                this.value = char;
                this.classList.toggle('border-blue-500', !!char);
                this.classList.toggle('bg-blue-50', !!char);
                this.classList.toggle('border-gray-200', !char);
                document.getElementById('err-otp').classList.add('hidden');
                if (char && idx < boxes.length - 1) boxes[idx + 1].focus();
            };

            box.onkeydown = function (e) {
                if (e.key === 'Backspace') {
                    e.preventDefault();
                    if (this.value) {
                        this.value = '';
                        this.classList.remove('border-blue-500', 'bg-blue-50');
                        this.classList.add('border-gray-200');
                    } else if (idx > 0) {
                        boxes[idx - 1].focus();
                        boxes[idx - 1].value = '';
                        boxes[idx - 1].classList.remove('border-blue-500', 'bg-blue-50');
                        boxes[idx - 1].classList.add('border-gray-200');
                    }
                } else if (e.key === 'ArrowLeft' && idx > 0) boxes[idx - 1].focus();
                else if (e.key === 'ArrowRight' && idx < boxes.length - 1) boxes[idx + 1].focus();
            };

            box.onfocus = () => box.select();
        });

        // Paste support
        document.getElementById('ef-otp-inputs').onpaste = function (e) {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            boxes.forEach((b, i) => {
                b.value = pasted[i] || '';
                b.classList.toggle('border-blue-500', !!b.value);
                b.classList.toggle('bg-blue-50', !!b.value);
                b.classList.toggle('border-gray-200', !b.value);
            });
            boxes[Math.min(pasted.length, boxes.length - 1)].focus();
        };
    }

    function getOtp() {
        return Array.from(document.querySelectorAll('[data-otp-idx]')).map(b => b.value).join('');
    }

    // ═══════════════════════════════════════════════════════
    // STEP 4 — VERIFY OTP & SUBMIT
    // ═══════════════════════════════════════════════════════
    window.efVerifyOtp = async function () {
        const otp   = getOtp();
        const email = document.getElementById('ef-otp-email').textContent;
        document.getElementById('err-otp').classList.add('hidden');

        if (otp.length !== 6) {
            const errEl = document.getElementById('err-otp');
            errEl.textContent = 'Please enter all 6 digits.';
            errEl.classList.remove('hidden');
            return;
        }

        setLoading('ef-verify-btn', true, 'Verify & Submit');

        const payload = {
            name:    document.getElementById('ef-name').value.trim(),
            email:   email,
            phone:   document.getElementById('ef-phone').value.trim(),
            kw_text: document.getElementById('kw_text_value').value.trim(),
            age:     document.getElementById('ef-age').value,
            plan:    document.getElementById('ef-plan').value,
            comment: document.getElementById('ef-comment').value.trim(),
            otp:     otp,
        };

        try {
            const res  = await fetch('/client/lead/saveEnquiry', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                },
                body: JSON.stringify(payload),
            });
            const data = await res.json();

            if (data.status) {
                // Show success
                document.querySelectorAll('[data-step]').forEach(el => el.classList.add('hidden'));
                document.querySelector('[data-success]').classList.remove('hidden');
                updateStepUI(5);
            } else {
                const errEl = document.getElementById('err-otp');
                errEl.textContent = data.message || 'Invalid or expired OTP.';
                errEl.classList.remove('hidden');
            }
        } catch {
            const errEl = document.getElementById('err-otp');
            errEl.textContent = 'Network error. Please try again.';
            errEl.classList.remove('hidden');
        } finally {
            setLoading('ef-verify-btn', false, 'Verify & Submit');
        }
    };

    // ═══════════════════════════════════════════════════════
    // OTP COUNTDOWN + RESEND
    // ═══════════════════════════════════════════════════════
    let _countdownTimer = null;

    function efStartCountdown(sec = 30) {
        const countdownEl = document.getElementById('ef-resend-countdown');
        const numEl       = document.getElementById('ef-countdown-num');
        const resendBtn   = document.getElementById('ef-resend-btn');
        countdownEl.classList.remove('hidden');
        resendBtn.classList.add('hidden');
        numEl.textContent = sec;
        if (_countdownTimer) clearInterval(_countdownTimer);
        _countdownTimer = setInterval(() => {
            sec--;
            numEl.textContent = sec;
            if (sec <= 0) {
                clearInterval(_countdownTimer);
                countdownEl.classList.add('hidden');
                resendBtn.classList.remove('hidden');
            }
        }, 1000);
    }

    window.efResendOtp = async function () {
        const email = document.getElementById('ef-otp-email').textContent;
        document.getElementById('ef-resend-btn').disabled = true;
        try {
            await fetch('/client/enquirySendOtp', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF() },
                body: JSON.stringify({ email, resend: true }),
            });
            document.querySelectorAll('[data-otp-idx]').forEach(b => {
                b.value = '';
                b.classList.remove('border-blue-500', 'bg-blue-50');
                b.classList.add('border-gray-200');
            });
            document.getElementById('err-otp').classList.add('hidden');
            efStartCountdown();
            setTimeout(() => document.querySelector('[data-otp-idx="0"]')?.focus(), 100);
        } catch {
            document.getElementById('err-otp').textContent = 'Failed to resend. Please try again.';
            document.getElementById('err-otp').classList.remove('hidden');
        } finally {
            document.getElementById('ef-resend-btn').disabled = false;
        }
    };

 

    let allServices   = [];
    let svcSelected   = { value: '', label: '' };
    let svcOpen       = false;
    let svcTimer      = null;

    window.toggleServiceDropdown = function () {
        svcOpen ? closeSvc() : openSvc();
    };

    function openSvc() {
        svcOpen = true;
        document.getElementById('service-panel').classList.remove('hidden');
        document.getElementById('service-chevron').style.transform = 'rotate(180deg)';
        renderSvc(allServices, '');
        setTimeout(() => document.getElementById('service-search-input').focus(), 60);
    }

    function closeSvc() {
        svcOpen = false;
        document.getElementById('service-panel').classList.add('hidden');
        document.getElementById('service-chevron').style.transform = '';
        document.getElementById('service-search-input').value = '';
        document.getElementById('service-search-clear').classList.add('hidden');
    }

    document.addEventListener('mousedown', function (e) {
        const dd = document.getElementById('service-dropdown');
        if (dd && !dd.contains(e.target)) closeSvc();
    });

    window.handleServiceSearch = function (q) {
        document.getElementById('service-search-clear').classList.toggle('hidden', !q.trim());
        clearTimeout(svcTimer);
        const local = allServices.filter(s => s.label.toLowerCase().includes(q.toLowerCase()));
        renderSvc(local, q);
        if (q.trim().length >= 2) {
            svcTimer = setTimeout(() => fetchSvc(q.trim()), 300);
        }
    };
    window.searchKeyEmpty = function () {
        const q  = "";
        document.getElementById('service-search-clear').classList.toggle('hidden', !q.trim());
        clearTimeout(svcTimer);
        
        const local = allServices.filter(s => s.label.toLowerCase().includes());
        renderSvc(local , );
        
            svcTimer = setTimeout(() => fetchSvc(q.trim()), 300);
        
    };

    window.clearServiceSearch = function () {
        document.getElementById('service-search-input').value = '';
        document.getElementById('service-search-clear').classList.add('hidden');
        renderSvc(allServices, '');
        document.getElementById('service-search-input').focus();
    };

    async function fetchSvc(q) {
        document.getElementById('service-loading').classList.remove('hidden');
        document.getElementById('service-loading').classList.add('flex');
        try {
            const res  = await fetch(`/location/getAjaxService?q=${encodeURIComponent(q)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF() }
            });
            const data = await res.json();
            const items = (data.keywords  ?? []).map(i => ({
                value: i.slug  ?? '',
                label: i.keyword ?? ''
            }));
            if (items.length) allServices = items;
            renderSvc(items.length ? items : allServices.filter(s =>
                s.label.toLowerCase().includes(q.toLowerCase())
            ), q);
        } catch {
            renderSvc(allServices.filter(s =>
                s.label.toLowerCase().includes(q.toLowerCase())
            ), q);
        } finally {
            document.getElementById('service-loading').classList.remove('flex');
            document.getElementById('service-loading').classList.add('hidden');
        }
    }

    function renderSvc(list, q) {
        const ul    = document.getElementById('service-options-list');
        const empty = document.getElementById('service-empty');
        if (!list.length) {
            ul.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }
        empty.classList.add('hidden');
        const ql = (q || '').toLowerCase();
        ul.innerHTML = list.map(s => {
            const lbl    = s.label;
            const mi     = lbl.toLowerCase().indexOf(ql);
            const hl     = ql && mi >= 0
                ? `${lbl.slice(0, mi)}<mark class="bg-yellow-100 text-yellow-800 rounded px-0.5 not-italic">${lbl.slice(mi, mi + ql.length)}</mark>${lbl.slice(mi + ql.length)}`
                : lbl;
            const active = s.value === svcSelected.value;
            return `<li>
                <button type="button"
                    onmousedown="selectSvc('${s.value.replace(/'/g,"\\'")}','${s.label.replace(/'/g,"\\'")}')"
                    class="w-full flex items-center gap-3 px-4 py-2.5 text-left text-sm transition-colors
                           ${active ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-700'}">
                    <span class="w-4 h-4 shrink-0 flex items-center justify-center">
                        ${active ? `<svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>` : ''}
                    </span>
                    <span>${hl}</span>
                </button>
            </li>`;
        }).join('');
    }

    window.selectSvc = function (value, label) {
        svcSelected = { value, label };
        document.getElementById('kw_text_value').value         = value;
        document.getElementById('service-selected-label').textContent = label;
        document.getElementById('service-selected-label').classList.replace('text-gray-400', 'text-gray-800');
        document.getElementById('err-service').classList.add('hidden');
        closeSvc();
        renderSvc(allServices, '');
    };

    // Init
    document.addEventListener('DOMContentLoaded', () => renderSvc(allServices, ''));

})();
</script>