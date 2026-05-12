{{-- ─── Login Modal ─── --}}
<div id="login-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 relative">

        {{-- Close --}}
        <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Logo & heading --}}
        <div class="text-center mb-6">
            <img src="{{ asset('client/images/small-logo.png') }}" alt="QuickDials"
                 class="h-10 mx-auto mb-3 object-contain" onerror="this.style.display='none'">
            <h2 class="text-lg font-black text-gray-900">Welcome Back</h2>
            <p class="text-sm text-gray-500 mt-1">Sign in to your QuickDials account</p>
        </div>

        {{-- Google --}}
        <a href="{{ route('google.login') }}"
           class="w-full flex items-center justify-center gap-3 border-2 border-gray-200 hover:border-gray-300 rounded-xl py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all mb-4">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Continue with Google
        </a>

        <div class="flex items-center gap-3 mb-4">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400 font-medium">or</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        {{-- ══ STEP 1: Email ══ --}}
        <div id="step-email">
            <input
                type="email"
                id="login-email"
                name="email"
                 autocomplete="off"
                placeholder="Enter your email"
                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all mb-1"
            />
            <p id="email-error" class="text-xs text-red-500 mb-3 hidden"></p>
            <button
                onclick="handleEmailLogin()"
                id="email-btn"
                class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-2.5 rounded-xl text-sm transition-colors flex items-center justify-center gap-2"
            >
               Send OTP
            </button>
        </div>

        {{-- ══ STEP 2: OTP ══ --}}
        <div id="step-otp" class="hidden">
            <button onclick="backToEmail()" class="flex items-center gap-1 text-sm text-gray-400 hover:text-gray-600 mb-4 transition-colors">
                <svg class="w-4 h-4" stroke="currentColor" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </button>

            <p class="text-sm text-gray-500 mb-4 text-center">
                We sent a 6-digit code to<br>
                <span id="otp-email-display" class="font-semibold text-gray-800"></span>
            </p>

            {{-- OTP boxes --}}
            <div class="flex gap-2 justify-center mb-1" id="otp-inputs">
                <input type="text" inputmode="numeric" maxlength="1" data-idx="0"
                    class="otp-box w-11 h-13 text-center text-xl font-bold border-2 border-gray-200 rounded-xl outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                    style="width:44px;height:52px;" />
                <input type="text" inputmode="numeric" maxlength="1" data-idx="1"
                    class="otp-box w-11 h-13 text-center text-xl font-bold border-2 border-gray-200 rounded-xl outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                    style="width:44px;height:52px;" />
                <input type="text" inputmode="numeric" maxlength="1" data-idx="2"
                    class="otp-box w-11 h-13 text-center text-xl font-bold border-2 border-gray-200 rounded-xl outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                    style="width:44px;height:52px;" />
                <input type="text" inputmode="numeric" maxlength="1" data-idx="3"
                    class="otp-box w-11 h-13 text-center text-xl font-bold border-2 border-gray-200 rounded-xl outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                    style="width:44px;height:52px;" />
                <input type="text" inputmode="numeric" maxlength="1" data-idx="4"
                    class="otp-box w-11 h-13 text-center text-xl font-bold border-2 border-gray-200 rounded-xl outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                    style="width:44px;height:52px;" />
                <input type="text" inputmode="numeric" maxlength="1" data-idx="5"
                    class="otp-box w-11 h-13 text-center text-xl font-bold border-2 border-gray-200 rounded-xl outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                    style="width:44px;height:52px;" />
            </div>

            <p id="otp-error" class="text-xs text-red-500 text-center mb-3 hidden"></p>

            <button
                onclick="handleVerifyOtp()"
                id="verify-btn"
                class="w-full bg-sky-500 hover:bg-sky-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-2.5 rounded-xl text-sm transition-colors flex items-center justify-center gap-2 mb-3"
            >
                Verify & Login
            </button>

            <p class="text-center text-sm text-gray-500">
                Didn't receive it?
                <span id="resend-countdown" class="text-gray-400">
                    Resend in <span id="countdown-num" class="font-semibold text-sky-500">30</span>s
                </span>
                <button id="resend-btn" onclick="handleResend()"
                        class="hidden text-sky-500 hover:text-sky-700 font-semibold transition-colors">
                    Resend OTP
                </button>
            </p>
        </div>

        {{-- ══ STEP 3: Success ══ --}}
        <div id="step-success" class="hidden text-center py-4">
            <div class="w-16 h-16 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-9 h-9 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">You're in!</h3>
            <p class="text-sm text-gray-500">
                Logged in as <span id="success-email" class="font-semibold text-gray-700"></span>
            </p>
            <p class="text-xs text-gray-400 mt-2">Redirecting…</p>
        </div>

    </div>
</div>

<script>
const CSRF = () => document.querySelector('meta[name="csrf-token"]').content;

// ── Modal open/close ──────────────────────────────────────────────────────────
function openLoginModal() {
    document.getElementById('login-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('login-email')?.focus(), 100);
}

function closeLoginModal() {
    document.getElementById('login-modal').classList.add('hidden');
    document.body.style.overflow = '';
    resetModal();
}

// Close on backdrop click
document.getElementById('login-modal').addEventListener('click', function(e) {
    if (e.target === this) closeLoginModal();
});

// Close on Escape
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLoginModal(); });

// ── Reset ─────────────────────────────────────────────────────────────────────
function resetModal() {
    showStep('email');
    document.getElementById('login-email').value = '';
    document.getElementById('email-error').classList.add('hidden');
    document.querySelectorAll('.otp-box').forEach(b => {
        b.value = '';
        b.classList.remove('border-sky-500', 'bg-sky-50', 'text-sky-700');
        b.classList.add('border-gray-200');
    });
    document.getElementById('otp-error').classList.add('hidden');
    if (window._resendTimer) clearInterval(window._resendTimer);
}

function showStep(step) {
    ['email','otp','success'].forEach(s =>
        document.getElementById('step-' + s).classList.add('hidden')
    );
    document.getElementById('step-' + step).classList.remove('hidden');
}

// ── Helpers ───────────────────────────────────────────────────────────────────
function setLoading(btnId, loading, defaultText) {
    const btn = document.getElementById(btnId);
    btn.disabled = loading;
    btn.innerHTML = loading
        ? `<span class="w-4 h-4 border-2 border-white/40 border-t-white rounded-full animate-spin"></span> Loading…`
        : defaultText;
}

function showError(elId, msg) {
    const el = document.getElementById(elId);
    el.textContent = msg;
    el.classList.remove('hidden');
}

function hideError(elId) {
    document.getElementById(elId).classList.add('hidden');
}

// ── STEP 1: Send OTP ──────────────────────────────────────────────────────────
async function handleEmailLogin() {
    const email = document.getElementById('login-email').value.trim();
    hideError('email-error');
 
    if (!email) { showError('email-error', 'Please enter your email address.'); return; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showError('email-error', 'Please enter a valid email address.'); return; }

    setLoading('email-btn', true, 'Continue with Email');
    try {
        const res  = await fetch('/auth/send-otp', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ email }),
        });
        const data = await res.json();

        if (data.status) {
            document.getElementById('otp-email-display').textContent = email;
            showStep('otp');
            initOtpInputs();
            startCountdown();
            setTimeout(() => document.querySelector('.otp-box')?.focus(), 100);
        } else {
            showError('email-error', data.message || 'Failed to send OTP. Please try again.');
        }
    } catch {
        showError('email-error', 'Network error. Please try again.');
    } finally {
        setLoading('email-btn', false, 'Continue with Email');
    }
}

// ── OTP input behaviour ───────────────────────────────────────────────────────
function initOtpInputs() {
    const boxes = document.querySelectorAll('.otp-box');
    boxes.forEach((box, idx) => {
        box.value = '';

        box.oninput = function() {
            const char = this.value.replace(/\D/g,'').slice(-1);
            this.value = char;
            this.classList.toggle('border-sky-500', !!char);
            this.classList.toggle('bg-sky-50',      !!char);
            this.classList.toggle('text-sky-700',   !!char);
            this.classList.toggle('border-gray-200', !char);
            hideError('otp-error');
            if (char && idx < 5) boxes[idx + 1].focus();
        };

        box.onkeydown = function(e) {
            if (e.key === 'Backspace') {
                e.preventDefault();
                if (this.value) {
                    this.value = '';
                    this.classList.remove('border-sky-500','bg-sky-50','text-sky-700');
                    this.classList.add('border-gray-200');
                } else if (idx > 0) {
                    boxes[idx - 1].focus();
                    boxes[idx - 1].value = '';
                    boxes[idx - 1].classList.remove('border-sky-500','bg-sky-50','text-sky-700');
                    boxes[idx - 1].classList.add('border-gray-200');
                }
            } else if (e.key === 'ArrowLeft'  && idx > 0) boxes[idx - 1].focus();
            else if (e.key === 'ArrowRight' && idx < 5) boxes[idx + 1].focus();
        };

        box.onfocus = function() { this.select(); };
    });

    // Paste support
    document.getElementById('otp-inputs').onpaste = function(e) {
        e.preventDefault();
        const pasted = e.clipboardData.getData('text').replace(/\D/g,'').slice(0, 6);
        boxes.forEach((b, i) => {
            b.value = pasted[i] || '';
            b.classList.toggle('border-sky-500', !!b.value);
            b.classList.toggle('bg-sky-50',      !!b.value);
            b.classList.toggle('text-sky-700',   !!b.value);
            b.classList.toggle('border-gray-200', !b.value);
        });
        boxes[Math.min(pasted.length, 5)].focus();
    };
}

function getOtpValue() {
    return Array.from(document.querySelectorAll('.otp-box')).map(b => b.value).join('');
}

// ── STEP 2: Verify OTP ────────────────────────────────────────────────────────
async function handleVerifyOtp() {
    const otp   = getOtpValue();
    const email = document.getElementById('otp-email-display').textContent;
    hideError('otp-error');

    if (otp.length !== 6) { showError('otp-error', 'Please enter all 6 digits.'); return; }

    setLoading('verify-btn', true, 'Verify & Login');
    try {
        const res  = await fetch('/client-verify-otp', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            credentials: 'include',
            body: JSON.stringify({ email, otp }),
        });
        const data = await res.json();

        if (data.status) {
            document.getElementById('success-email').textContent = email;
            showStep('success');
            setTimeout(() => { window.location.href = data.redirect; }, 1500);
        } else {
            showError('otp-error', data.message || 'Invalid or expired code.');
        }
    } catch {
        showError('otp-error', 'Network error. Please try again.');
    } finally {
        setLoading('verify-btn', false, 'Verify & Login');
    }
}

// ── Resend countdown ──────────────────────────────────────────────────────────
function startCountdown(sec = 30) {
    const countdownEl = document.getElementById('resend-countdown');
    const numEl       = document.getElementById('countdown-num');
    const resendBtn   = document.getElementById('resend-btn');

    countdownEl.classList.remove('hidden');
    resendBtn.classList.add('hidden');
    numEl.textContent = sec;

    if (window._resendTimer) clearInterval(window._resendTimer);
    window._resendTimer = setInterval(() => {
        sec--;
        numEl.textContent = sec;
        if (sec <= 0) {
            clearInterval(window._resendTimer);
            countdownEl.classList.add('hidden');
            resendBtn.classList.remove('hidden');
        }
    }, 1000);
}

async function handleResend() {
    const email = document.getElementById('otp-email-display').textContent;
    document.getElementById('resend-btn').disabled = true;
    try {
        await fetch('/auth/send-otp', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ email }),
        });
        document.querySelectorAll('.otp-box').forEach(b => {
            b.value = '';
            b.classList.remove('border-sky-500','bg-sky-50','text-sky-700');
            b.classList.add('border-gray-200');
        });
        hideError('otp-error');
        startCountdown();
        setTimeout(() => document.querySelector('.otp-box')?.focus(), 100);
    } catch {
        showError('otp-error', 'Failed to resend. Please try again.');
    } finally {
        document.getElementById('resend-btn').disabled = false;
    }
}

// ── Back to email ─────────────────────────────────────────────────────────────
function backToEmail() {
    if (window._resendTimer) clearInterval(window._resendTimer);
    showStep('email');
}
</script>