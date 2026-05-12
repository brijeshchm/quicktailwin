{{-- resources/views/business/partials/enquiry-form.blade.php --}}
{{-- $formId = 'sidebar' or 'modal' --}}
<div data-enquiry-form class="rounded-2xl border overflow-hidden" style="border-color:rgba(59,130,246,.15);">

    {{-- Header --}}
    <div class="px-6 py-5" style="background:linear-gradient(135deg,#2563EB 0%,#0891b2 100%);">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-white text-lg">Make an Enquiry</h3>
            @if($formId === 'modal')
            <button onclick="document.getElementById('enquiry-modal').classList.remove('open')"
                    class="w-8 h-8 rounded-full flex items-center justify-center text-white/70 hover:text-white" style="background:rgba(255,255,255,.12);">✕</button>
            @endif
        </div>

        {{-- Step indicators --}}
        <div class="flex items-center gap-0">
            @foreach(['Contact','Details','Message','Verify'] as $si => $label)
            <div class="flex items-center flex-1 last:flex-none">
                <div class="flex flex-col items-center gap-1">
                    <div class="step-dot {{ $si===0?'active':'pending' }}" data-dot="{{ $si+1 }}">{{ $si+1 }}</div>
                    <span class="text-[9px] font-semibold {{ $si===0?'text-white':'text-white/50' }}">{{ $label }}</span>
                </div>
                @if($si < 3)
                <div class="step-line" data-line="{{ $si+1 }}"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Body --}}
    <div class="bg-white px-6 py-5">

        {{-- Step 1 --}}
        <div data-step="1">
            <p class="text-sm font-semibold text-gray-500 mb-4">Step 1 — Your contact details</p>
            <div class="space-y-3">
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Full Name *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                        <input type="text" name="name" placeholder="Enter Name" class="ef-input" required>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Email Address *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">✉️</span>
                        <input type="email" name="email" placeholder="john@example.com" class="ef-input" required>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Mobile Number *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">📞</span>
                        <input type="tel" name="phone" placeholder="Enter Phone no" class="ef-input" required>
                    </div>
                </div>
                <button data-next class="w-full py-3 mt-2 rounded-xl font-bold text-white text-sm" style="background:#2563eb;">
                    Continue →
                </button>
            </div>
        </div>

        {{-- Step 2 --}}
        <div data-step="2" class="hidden">
            <p class="text-sm font-semibold text-gray-500 mb-4">Step 2 — Booking details</p>
            <div class="space-y-3">
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Service *</label>
                    <select name="kw_text" class="ef-input">
                        <option value="">Select a service…</option>
                        @foreach($keywordList as $kw)
                        <option value="{{ $kw['slug'] ?? '' }}">{{ $kw['keyword'] ?? $kw }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Preferred Date *</label>
                    <input type="date" name="date" class="ef-input" style="padding-left:1rem;">
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">When do you want to Start?</label>
                    <select name="plan" class="ef-input">
                        @foreach($planOptions as $plan)
                        <option value="{{ $plan }}">{{ $plan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2 mt-2">
                    <button data-back class="flex-1 py-2.5 rounded-xl font-semibold text-blue-600 border border-blue-200 hover:bg-blue-50 text-sm">← Back</button>
                    <button data-next class="flex-1 py-2.5 rounded-xl font-semibold text-white text-sm" style="background:#2563eb;">Continue →</button>
                </div>
            </div>
        </div>

        {{-- Step 3 --}}
        <div data-step="3" class="hidden">
            <p class="text-sm font-semibold text-gray-500 mb-4">Step 3 — Additional message</p>
            <div class="space-y-3">
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Message (optional)</label>
                    <textarea name="comment" rows="3" placeholder="Any special requests or questions…"
                              class="ef-input resize-none" style="padding-left:1rem;"></textarea>
                </div>
                <div class="flex gap-2 mt-2">
                    <button data-back class="flex-1 py-2.5 rounded-xl font-semibold text-blue-600 border border-blue-200 hover:bg-blue-50 text-sm">← Back</button>
                    <button data-send class="flex-1 py-2.5 rounded-xl font-semibold text-white text-sm flex items-center justify-center gap-1.5" style="background:#2563eb;">
                        Send Enquiry ✓
                    </button>
                </div>
            </div>
        </div>

        {{-- Step 4 — OTP --}}
        <div data-step="4" class="hidden">
            <div class="text-center mb-4">
                <div class="w-10 h-10 mx-auto mb-2 rounded-full flex items-center justify-center text-xl" style="background:rgba(37,99,235,.08);">🔒</div>
                <p class="text-sm font-bold text-gray-800">Verify your mobile</p>
                <p class="text-xs text-gray-400 mt-0.5">OTP sent to your number</p>
            </div>
            <div class="flex gap-2 justify-center mb-4">
                @for($o=0;$o<5;$o++)
                <input type="text" inputmode="numeric" maxlength="1" class="otp-box">
                @endfor
            </div>
            <div class="flex gap-2">
                <button data-back class="flex-1 py-2.5 rounded-xl font-semibold text-blue-600 border border-blue-200 hover:bg-blue-50 text-sm">← Back</button>
                <button data-verify class="flex-1 py-2.5 rounded-xl font-semibold text-white text-sm" style="background:#2563eb;">Verify &amp; Submit</button>
            </div>
        </div>

        {{-- Success state --}}
        <div data-success class="hidden flex flex-col items-center py-8 text-center gap-4">
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-3xl" style="background:rgba(37,99,235,.08);">✅</div>
            <div>
                <p class="font-bold text-gray-900 text-lg">Enquiry Sent!</p>
                <p class="text-sm text-gray-400 mt-1">We'll get back to you within 24 hours.</p>
            </div>
            <button onclick="location.reload()" class="px-5 py-2 rounded-full text-sm font-semibold text-blue-600 border border-blue-200 hover:bg-blue-50">
                New Enquiry
            </button>
        </div>

    </div>
</div>


