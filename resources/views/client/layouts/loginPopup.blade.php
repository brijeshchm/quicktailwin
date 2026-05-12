{{-- Login Popup Component --}}
<div
    x-data="loginPopup()"
    x-show="isOpen"
    x-cloak
    @keydown.escape.window="close()"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
>
    {{-- Backdrop --}}
    <div
        class="absolute inset-0 bg-black/40 backdrop-blur-sm"
        @click="close()"
        aria-hidden="true"
    ></div>

    {{-- Modal --}}
    <div
        role="dialog"
        aria-modal="true"
        aria-labelledby="login-title"
        class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        @click.stop
    >
        {{-- Close button --}}
        <button
            @click="close()"
            aria-label="Close"
            class="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors"
        >
            <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        {{-- Back button (OTP step only) --}}
        <button
            x-show="step === 'otp'"
            @click="step = 'email'; otp = ''; otpError = ''"
            aria-label="Back"
            class="absolute top-4 left-4 z-10 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors"
        >
            <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>

        {{-- ══ EMAIL STEP ══ --}}
        <div x-show="step === 'email'" class="px-8 pt-10 pb-8">
            <h2 id="login-title" class="text-2xl font-bold text-gray-900 mb-1">Login</h2>
            <p class="text-sm text-gray-500 mb-6">Enter your email to receive a one-time password</p>

            <div class="space-y-3">
                <div class="flex flex-col gap-1">
                    <label for="login-email" class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email Address</label>

                    <div :class="emailError ? 'border-red-400 ring-1 ring-red-200' : 'border-gray-200 focus-within:border-sky-400 focus-within:ring-1 focus-within:ring-sky-100'"
                         class="flex items-center border rounded-xl overflow-hidden transition-all duration-150">
                        <span class="pl-3 text-gray-400 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input
                            id="login-email"
                            type="email"
                            x-model="email"
                            @keydown.enter="sendOtp()"
                            @input="emailError = ''"
                            placeholder="Enter Email"
                            autocomplete="email"
                            class="flex-1 px-3 py-3 text-sm text-gray-800 placeholder-gray-400 bg-transparent outline-none"
                        />
                    </div>
                    <p x-show="emailError" x-text="emailError" class="text-xs text-red-500 pl-1 mt-0.5"></p>
                </div>

                <button
                    @click="sendOtp()"
                    :disabled="loading"
                    class="w-full bg-sky-500 hover:bg-sky-600 active:bg-sky-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl text-sm transition-colors shadow-sm flex items-center justify-center gap-2"
                >
                    <span x-show="loading" class="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                    <span x-text="loading ? 'Sending OTP…' : 'Send OTP'"></span>
                </button>

                <div class="flex items-center gap-3">
                    <span class="flex-1 h-px bg-gray-100"></span>
                    <span class="text-xs text-gray-400 font-medium">OR</span>
                    <span class="flex-1 h-px bg-gray-100"></span>
                </div>

                
                    href="{{ route('google.login') }}"
                    class="flex items-center justify-center gap-2.5 w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm no-underline"
                >
                     
                    Continue with Google
                </a>
            </div>

            <div class="flex justify-center gap-1.5 mt-6">
                <span class="block w-5 h-1.5 rounded-full bg-sky-500"></span>
                <span class="block w-1.5 h-1.5 rounded-full bg-gray-200"></span>
            </div>
        </div>

        {{-- ══ OTP STEP ══ --}}
        <div x-show="step === 'otp'" class="px-8 pt-12 pb-8">
            <h2 id="login-title" class="text-2xl font-bold text-gray-900 mb-1">Check your email</h2>
            <p class="text-sm text-gray-500 mb-6">
                We sent a 6-digit code to <span class="font-semibold text-gray-700" x-text="email"></span>
            </p>

            <div class="space-y-4">
                {{-- OTP inputs --}}
                <div class="flex gap-2 justify-center" @paste.prevent="handlePaste($event)">
                    <template x-for="(digit, idx) in otpDigits" :key="idx">
                        <input
                            type="text"
                            inputmode="numeric"
                            maxlength="1"
                            :value="digit"
                            :disabled="loading"
                            @input="handleOtpInput(idx, $event)"
                            @keydown="handleOtpKeydown(idx, $event)"
                            @focus="$event.target.select()"
                            :class="digit ? 'border-sky-500 bg-sky-50 text-sky-700' : 'border-gray-200 bg-white text-gray-800'"
                            class="w-11 h-13 text-center text-xl font-bold border-2 rounded-xl outline-none transition-all duration-150 focus:border-sky-400 focus:ring-2 focus:ring-sky-100 disabled:opacity-50 disabled:cursor-not-allowed"
                            style="width:44px; height:52px;"
                            x-ref="'otp_' + idx"
                        />
                    </template>
                </div>

                <p x-show="otpError" x-text="otpError" class="text-xs text-red-500 text-center"></p>

                <button
                    @click="verifyOtp()"
                    :disabled="loading || otp.replace(/\s/g,'').length !== 6"
                    class="w-full bg-sky-500 hover:bg-sky-600 active:bg-sky-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl text-sm transition-colors shadow-sm flex items-center justify-center gap-2"
                >
                    <span x-show="loading" class="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                    <span x-text="loading ? 'Verifying…' : 'Verify & Login'"></span>
                </button>

                <p class="text-center text-sm text-gray-500">
                    Didn't receive it?
                    <template x-if="resendCountdown > 0">
                        <span class="text-gray-400">Resend in <span class="font-semibold text-sky-500" x-text="resendCountdown + 's'"></span></span>
                    </template>
                    <template x-if="resendCountdown === 0">
                        <button @click="resendOtp()" :disabled="loading" class="text-sky-500 hover:text-sky-700 font-semibold transition-colors disabled:opacity-50">
                            Resend OTP
                        </button>
                    </template>
                </p>
            </div>

            <div class="flex justify-center gap-1.5 mt-6">
                <span class="block w-1.5 h-1.5 rounded-full bg-gray-200"></span>
                <span class="block w-5 h-1.5 rounded-full bg-sky-500"></span>
            </div>
        </div>

        {{-- ══ SUCCESS STEP ══ --}}
        <div x-show="step === 'success'" class="px-8 py-12 flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-green-50 flex items-center justify-center mb-4">
                <svg class="w-9 h-9 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">You're in!</h2>
            <p class="text-sm text-gray-500 mb-6">
                Logged in as <span class="font-semibold text-gray-700" x-text="email"></span>
            </p>
            <button @click="close()" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2.5 px-8 rounded-xl text-sm transition-colors shadow-sm">
                Continue
            </button>
        </div>
    </div>
</div>

 
<script>
function loginPopup() {
    return {
        isOpen: false,
        step: 'email',
        email: '',
        emailError: '',
        otp: '',
        otpDigits: ['','','','','',''],
        otpError: '',
        loading: false,
        resendCountdown: 0,
        _timer: null,

        open()  { this.isOpen = true; this.$nextTick(() => document.getElementById('login-email')?.focus()); },
        close() {
            this.isOpen = false;
            this.step = 'email';
            this.email = ''; this.emailError = '';
            this.otp = ''; this.otpDigits = ['','','','','',''];
            this.otpError = ''; this.loading = false;
            this.resendCountdown = 0;
            if (this._timer) clearInterval(this._timer);
        },

        validateEmail() {
            if (!this.email.trim()) { this.emailError = 'Please enter your email address.'; return false; }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) { this.emailError = 'Please enter a valid email address.'; return false; }
            this.emailError = ''; return true;
        },

        startCountdown(sec = 30) {
            this.resendCountdown = sec;
            if (this._timer) clearInterval(this._timer);
            this._timer = setInterval(() => {
                this.resendCountdown--;
                if (this.resendCountdown <= 0) clearInterval(this._timer);
            }, 1000);
        },

        // ── OTP input handlers ──────────────────────────────────────────────────
        handleOtpInput(idx, e) {
            const char = e.target.value.replace(/\D/g,'').slice(-1);
            this.otpDigits[idx] = char;
            this.otp = this.otpDigits.join('');
            if (this.otpError) this.otpError = '';
            if (char && idx < 5) {
                this.$nextTick(() => this.$refs['otp_' + (idx+1)]?.focus());
            }
        },
        handleOtpKeydown(idx, e) {
            if (e.key === 'Backspace') {
                e.preventDefault();
                if (this.otpDigits[idx]) {
                    this.otpDigits[idx] = '';
                } else if (idx > 0) {
                    this.$refs['otp_' + (idx-1)]?.focus();
                    this.otpDigits[idx-1] = '';
                }
                this.otp = this.otpDigits.join('');
            } else if (e.key === 'ArrowLeft'  && idx > 0) this.$refs['otp_' + (idx-1)]?.focus();
            else if (e.key === 'ArrowRight' && idx < 5) this.$refs['otp_' + (idx+1)]?.focus();
        },
        handlePaste(e) {
            const pasted = e.clipboardData.getData('text').replace(/\D/g,'').slice(0,6);
            this.otpDigits = Array.from({length:6}, (_,i) => pasted[i] || '');
            this.otp = this.otpDigits.join('');
            this.$nextTick(() => this.$refs['otp_' + Math.min(pasted.length, 5)]?.focus());
        },

        // ── API calls ────────────────────────────────────────────────────────────
        async sendOtp() {
            if (!this.validateEmail()) return;
            this.loading = true; this.emailError = '';
            try {
                const res  = await fetch('/api/auth/send-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ email: this.email }),
                });
                const data = await res.json();
                if (data.status) { this.step = 'otp'; this.startCountdown(); }
                else this.emailError = data.message || 'Failed to send OTP.';
            } catch { this.emailError = 'Network error. Please try again.'; }
            finally { this.loading = false; }
        },

        async verifyOtp() {
            const clean = this.otp.replace(/\s/g,'');
            if (clean.length !== 6) { this.otpError = 'Please enter all 6 digits.'; return; }
            this.otpError = ''; this.loading = true;
            try {
                const res  = await fetch('/client-verify-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    credentials: 'include',
                    body: JSON.stringify({ email: this.email, otp: clean }),
                });
                const data = await res.json();
                if (data.status) {
                    this.step = 'success';
                    setTimeout(() => { window.location.href = data.redirect; }, 1200);
                } else { this.otpError = data.message || 'Invalid or expired code.'; }
            } catch { this.otpError = 'Network error. Please try again.'; }
            finally { this.loading = false; }
        },

        async resendOtp() {
            if (this.resendCountdown > 0 || this.loading) return;
            this.otp = ''; this.otpDigits = ['','','','','','']; this.otpError = '';
            this.loading = true;
            try {
                await fetch('/api/auth/send-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ email: this.email }),
                });
                this.startCountdown();
            } catch { this.otpError = 'Failed to resend. Please try again.'; }
            finally { this.loading = false; }
        },
    }
}
</script>
 