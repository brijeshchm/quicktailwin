{{-- resources/views/business/partials/enquiry-form.blade.php --}}
{{-- $formId = 'sidebar' or 'modal' --}}

<style>
    
/* ══════ ENQUIRY FORM STEPS ══════ */
.step-dot { width:1.75rem;height:1.75rem;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;transition:all .3s; }
.step-dot.done { background:white;color:#2563eb; }
.step-dot.active { background:white;color:#1d4ed8;box-shadow:0 0 0 3px rgba(255,255,255,.4); }
.step-dot.pending { background:rgba(255,255,255,.2);color:rgba(255,255,255,.6); }
.step-line { flex:1;height:2px;margin:.875rem .375rem .875rem;border-radius:9999px;transition:background .5s; }
.ef-input { width:100%;padding:.625rem 1rem .625rem 2.25rem;border-radius:.75rem;border:1.5px solid rgba(37,99,235,.18);background:rgba(37,99,235,.04);font-size:.875rem;outline:none;color:#1e3a8a;transition:all .2s; }
.ef-input:focus { border-color:#2563eb;box-shadow:0 0 0 4px rgba(37,99,235,.1);background:white; }
select.ef-input { padding-left:1rem; }

/* ══════ OTP BOXES ══════ */
.otp-box { width:2.75rem;height:3.5rem;text-align:center;font-size:1.25rem;font-weight:900;border-radius:.75rem;border:1.5px solid rgba(37,99,235,.2);background:rgba(37,99,235,.02);color:#1d4ed8;outline:none;transition:all .2s; }
.otp-box.filled { border-color:#2563eb;background:rgba(37,99,235,.07);box-shadow:0 0 0 4px rgba(37,99,235,.1); }

</style>
<div data-enquiry-form class="rounded-2xl border overflow-hidden" style="border-color:rgba(59,130,246,.15);">

    {{-- Header --}}
    <div class="px-6 py-5" style="background:linear-gradient(135deg,#2563EB 0%,#0891b2 100%);">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-white text-lg">Make an Enquiry</h3>
            
            <button onclick="document.getElementById('enquiry-modal').classList.remove('open')"
                    class="w-8 h-8 rounded-full flex items-center justify-center text-white/70 hover:text-white" style="background:rgba(255,255,255,.12);">✕</button>
             
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
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Full Name fff*</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                       
                        <input type="hidden" name="lead_form" value="1">
                        <input type="hidden" name="kw_text"   id="kw_text"   value="{{ $keywordList }}">
                        <input type="hidden" name="city_id"   id="city_id"   class="city" value="{{ $city }}">
                        <input type="hidden" name="from_page" id="from_page" value="{{ request()->path() }}">                       
                        <input type="text" name="name" placeholder="Enter Name" class="ef-input" required>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Email Address *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">✉️</span>
                        <input type="email" name="email" placeholder="Enter Email" class="ef-input" required>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Mobile Number *</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">📞</span>
                        <input type="tel" name="phone" placeholder="Enter Phone" class="ef-input" required>
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
                 
                <!-- <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Preferred Date *</label>
                    <input type="date" name="date" class="ef-input" style="padding-left:1rem;">
                </div> -->
                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">Location</label>
                    
        <div x-data="{
        open: false,
        search: '',
        selected: '',
        selectedLabel: '',
        cities: @js($zones ?? []),
        get filtered() {
            const term = this.search.toLowerCase().trim();
            if (!term) return this.cities;
            return this.cities.filter(c =>
                (c.cityDetails || c.city || '').toLowerCase().includes(term)
            );
        }
     }"
     @click.away="open = false"
     class="relative w-full">

    {{-- Hidden input submitted with form (city ID) --}}
    <input type="hidden" name="location" :value="selected">

    {{-- Search/Display input --}}
    <div class="relative">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">📍</span>

        <input type="text"
               x-model="search"
               @click="open = true"
               @focus="open = true"
               @input="open = true"
               :placeholder="selectedLabel || 'Search or select city...'"
               autocomplete="off"
               class="ef-input pl-9 pr-9 cursor-pointer">

        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none transition-transform"
              :class="open && 'rotate-180'">▼</span>
    </div>

    {{-- Dropdown --}}
    <ul x-show="open"
        x-cloak
        x-transition.opacity
        class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">

        <template x-for="city in filtered" :key="city.id || city.city">
            <li @click="
                    selected = city.id || city.city;
                    selectedLabel = city.cityDetails || city.city;
                    search = '';
                    open = false;
                "
                :class="selected === (city.id || city.city) ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700'"
                class="px-3 py-2 hover:bg-blue-50 cursor-pointer text-sm flex items-center justify-between">
                <span x-text="city.cityDetails || city.city"></span>
                <span x-show="selected === (city.id || city.city)" class="text-blue-600">✓</span>
            </li>
        </template>

        <li x-show="filtered.length === 0" class="px-3 py-3 text-sm text-gray-400 text-center">
            No cities found
        </li>
    </ul>
</div>

      
                </div>





                <div>
                    <label class="text-xs font-semibold text-gray-500 mb-1 block">When do you want to Start?</label>
                    <select name="plan" class="ef-input">
                       @foreach(['Immediately','Within 1 Week','Within 1 Month','Within 3 Months','Within 6 Months','Just Exploring'] as $timeline)
                        <option>{{ $timeline }}</option>
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


<style>#enquiry-modal.open{display:flex;}</style>




<script>
(function () {
    document.querySelectorAll('[data-enquiry-form]').forEach(form => {
        const steps    = form.querySelectorAll('[data-step]');
        const dots     = form.querySelectorAll('[data-dot]');
        const lines    = form.querySelectorAll('[data-line]');
        const otpBoxes = form.querySelectorAll('.otp-box');
        let current = 1;
        let leadId  = null;

        // ════════ STEP NAVIGATION ════════
        const show = (n) => {
            current = n;
            steps.forEach(s => s.classList.toggle('hidden', +s.dataset.step !== n));
            dots.forEach(d => {
                const dn = +d.dataset.dot;
                d.className = 'step-dot ' + (dn < n ? 'done' : dn === n ? 'active' : 'pending');
                d.textContent = dn < n ? '✓' : dn;
            });
            lines.forEach(l => {
                l.style.background = +l.dataset.line < n
                    ? 'rgba(255,255,255,.7)'
                    : 'rgba(255,255,255,.2)';
            });
        };

        // ════════ VALIDATION HELPERS ════════
        const showError = (input, msg) => {
            removeError(input);
            const err = document.createElement('p');
            err.className = 'error-msg text-xs text-red-500 mt-1';
            err.textContent = msg;
            input.parentElement.appendChild(err);
            input.classList.add('border-red-500');
        };

        const removeError = (input) => {
            input.classList.remove('border-red-500');
            const existing = input.parentElement.querySelector('.error-msg');
            if (existing) existing.remove();
        };

        const validateStep = (stepNum) => {
            const stepEl = form.querySelector(`[data-step="${stepNum}"]`);
            const inputs = stepEl.querySelectorAll('[required]');
            let valid = true;

            inputs.forEach(input => {
                removeError(input);
                const val = input.value.trim();

                if (!val) {
                    showError(input, 'This field is required');
                    valid = false;
                    return;
                }

                if (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
                    showError(input, 'Enter a valid email');
                    valid = false;
                }

                if (input.type === 'tel' && !/^[+]?[0-9]{10,15}$/.test(val.replace(/\s/g, ''))) {
                    showError(input, 'Enter a valid 10-digit number');
                    valid = false;
                }
            });

            return valid;
        };

        // ════════ NEXT BUTTON ════════
        form.querySelectorAll('[data-next]').forEach(btn => {
            btn.addEventListener('click', () => {
                if (validateStep(current)) show(current + 1);
            });
        });

        // ════════ BACK BUTTON ════════
        form.querySelectorAll('[data-back]').forEach(btn => {
            btn.addEventListener('click', () => show(current - 1));
        });

        // ════════ SEND BUTTON (AJAX SUBMIT) ════════
        form.querySelectorAll('[data-send]').forEach(btn => {
            btn.addEventListener('click', async () => {
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = 'Sending…';

                // Collect form data
                const formData = new FormData();
                form.querySelectorAll('input, textarea, select').forEach(el => {
                    if (el.name) formData.append(el.name, el.value);
                });

                try {
                    const res = await fetch('/client/lead/saveEnquiry', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await res.json();

                    if (data.success) {
                        leadId = data.lead_id;

                        // Skip OTP for now → go directly to success
                        // OR show OTP step if you implement OTP later
                        showSuccess();

                    } else {
                        // Show validation errors
                        if (data.errors) {
                            Object.entries(data.errors).forEach(([field, messages]) => {
                                const input = form.querySelector(`[name="${field}"]`);
                                if (input) showError(input, messages[0]);
                            });

                            // Go back to step with error
                            if (data.errors.name || data.errors.email || data.errors.phone) {
                                show(1);
                            }
                        }
                        alert(data.message || 'Please fix the errors and try again.');
                    }

                } catch (err) {
                    console.error('Submit failed:', err);
                    alert('Network error. Please check your connection and try again.');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        });

        // ════════ SUCCESS STATE ════════
        const showSuccess = () => {
            steps.forEach(s => s.classList.add('hidden'));
            form.querySelector('[data-success]')?.classList.remove('hidden');
        };

        // ════════ OTP BOXES ════════
        otpBoxes.forEach((box, i) => {
            box.addEventListener('input', () => {
                box.value = box.value.replace(/\D/g, '').slice(-1);
                box.classList.toggle('filled', !!box.value);
                if (box.value && i < otpBoxes.length - 1) otpBoxes[i + 1].focus();
            });
            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !box.value && i > 0) otpBoxes[i - 1].focus();
            });
        });

        // ════════ VERIFY OTP (placeholder — implement when OTP service ready) ════════
        form.querySelectorAll('[data-verify]').forEach(btn => {
            btn.addEventListener('click', () => {
                const otp = Array.from(otpBoxes).map(b => b.value).join('');
                if (otp.length < 5) {
                    alert('Please enter complete OTP');
                    return;
                }
                showSuccess();
            });
        });

        // ════════ CLEAR ERRORS ON INPUT ════════
        form.querySelectorAll('input, textarea, select').forEach(el => {
            el.addEventListener('input', () => removeError(el));
        });
    });
})();
</script>

<!-- 

<script>

    
/* ── 3-Step Enquiry Form ── */
(function () {
    document.querySelectorAll('[data-enquiry-form]').forEach(form => {
        const steps = form.querySelectorAll('[data-step]');
        const dots  = form.querySelectorAll('[data-dot]');
        const lines = form.querySelectorAll('[data-line]');
        let current = 1;

        const show = (n) => {
            current = n;
            steps.forEach(s => s.classList.toggle('hidden', +s.dataset.step !== n));
            dots.forEach(d => {
                const dn = +d.dataset.dot;
                d.className = 'step-dot ' + (dn < n ? 'done' : dn === n ? 'active' : 'pending');
                d.textContent = dn < n ? '✓' : dn;
            });
            lines.forEach(l => { l.style.background = +l.dataset.line < n ? 'rgba(255,255,255,.7)' : 'rgba(255,255,255,.2)'; });
        };

        form.querySelectorAll('[data-next]').forEach(btn => {
            btn.addEventListener('click', () => show(current + 1));
        });
        form.querySelectorAll('[data-back]').forEach(btn => {
            btn.addEventListener('click', () => show(current - 1));
        });
        form.querySelectorAll('[data-send]').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.disabled = true;
                btn.textContent = 'Sending…';
                setTimeout(() => {
                    show(4);
                    form.querySelector('[data-step="4"]').classList.remove('hidden');
                    steps.forEach(s => s.classList.add('hidden'));
                    form.querySelector('[data-step="4"]').classList.remove('hidden');
                }, 1100);
            });
        });

        // OTP boxes
        const otpBoxes = form.querySelectorAll('.otp-box');
        otpBoxes.forEach((box, i) => {
            box.addEventListener('input', () => {
                box.value = box.value.replace(/\D/g,'').slice(-1);
                box.classList.toggle('filled', !!box.value);
                if (box.value && i < otpBoxes.length - 1) otpBoxes[i+1].focus();
            });
            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !box.value && i > 0) otpBoxes[i-1].focus();
            });
        });

        form.querySelectorAll('[data-verify]').forEach(btn => {
            btn.addEventListener('click', () => {
                const otp = Array.from(otpBoxes).map(b => b.value).join('');
                if (otp.length < 5) return;
                form.querySelector('[data-success]')?.classList.remove('hidden');
                steps.forEach(s => s.classList.add('hidden'));
                form.querySelector('[data-success]')?.classList.remove('hidden');
            });
        });
    });
})();

</script> -->