{{-- Sidebar 3-step enquiry form --}}
@php
    $tracking = [
        'kw_text'   => !empty($keyword) ? $keyword : '',
        'city_id'   => Request::segment(1) ?? '',
        'from_page' => request()->path(),
        'lead_form' => 1,
    ];


      $zonesForAlpine = collect($zones)->map(function ($z) {
        $z = (array) $z;
        return [
            'id'   => $z['id'],
            'name' => $z['cityDetails'],
             
        ];
    })->filter(fn($z) => !empty($z['name']))->values()->all();
 
@endphp

<div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-indigo-500/15"
     x-data="sidebarEnquiry(@js($tracking) , @js($zonesForAlpine))">

    <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-indigo-500 via-violet-500 to-purple-600 p-[2px]"></div>

    <div class="relative bg-white rounded-[22px] overflow-hidden">

        {{-- Header with steps --}}
        <div class="relative bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 px-4 pt-3 pb-3 overflow-hidden">
            <div class="flex items-center gap-2.5 mb-1">
                <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center border border-white/30">⚡</div>
                <h2 class="text-white font-bold text-base">Quick Enquiry</h2>
            </div>
            <p class="text-white/70 text-xs mb-2">We'll connect you with the best vendors instantly.</p>

            <div class="flex items-center gap-0 mt-2">
                @foreach(['Your Info' => 'ℹ', 'Preferences' => '📋', 'Message' => '✉'] as $label => $icon)
                @php $i = $loop->index; @endphp
                <div class="flex items-center flex-1 last:flex-none">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center border-2 transition-all duration-300 z-10"
                         :class="{
                             'bg-emerald-400 border-emerald-400': {{ $i }} < step,
                             'bg-white border-white': {{ $i }} === step,
                             'bg-white/10 border-white/30': {{ $i }} > step
                         }">
                        <span :class="{{ $i }} < step ? 'text-white' : ({{ $i }} === step ? 'text-indigo-600' : 'text-white/50')" class="text-sm">
                            <template x-if="{{ $i }} < step">✓</template>
                            <template x-if="{{ $i }} >= step">{{ $icon }}</template>
                        </span>
                    </div>
                    @if(!$loop->last)
                    <div class="flex-1 h-0.5 mx-1 relative overflow-hidden rounded-full bg-white/20">
                        <div class="absolute inset-y-0 left-0 bg-emerald-400 rounded-full transition-all duration-500"
                             :style="{{ $i }} < step ? 'width: 100%' : 'width: 0%'"></div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="flex mt-1.5">
                @foreach(['Your Info', 'Preferences', 'Message'] as $label)
                @php $i = $loop->index; @endphp
                <div class="flex-1 text-[10px] font-semibold transition-colors"
                     :class="{{ $i }} === step ? 'text-white' : 'text-white/40'">{{ $label }}</div>
                @endforeach
            </div>
        </div>

        {{-- Form body --}}
        <div class="px-4 pb-3 pt-2">

            {{-- Honeypot (anti-spam) --}}
            <input type="text" x-model="form.website" tabindex="-1" autocomplete="off"
                   class="absolute opacity-0 pointer-events-none -left-[9999px]" aria-hidden="true">

            {{-- Hidden tracking fields (kept for non-JS scrapers; Alpine state is the source of truth) --}}
            <input type="hidden" name="lead_form" value="{{ $tracking['lead_form'] }}">
            <input type="hidden" name="kw_text"   id="kw_text"   value="{{ $tracking['kw_text'] }}">
            <input type="hidden" name="city_id"   id="city_id"   class="city" value="{{ $tracking['city_id'] }}">
            <input type="hidden" name="from_page" id="from_page" value="{{ $tracking['from_page'] }}">

            {{-- Server error banner --}}
            <div x-show="submitError" x-cloak class="mb-2 px-3 py-2 bg-red-50 border border-red-200 rounded-lg text-[11px] text-red-700">
                <span x-text="submitError"></span>
            </div>

            {{-- SUCCESS --}}
            <div x-show="showSuccess" x-cloak class="text-center py-8">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-xl">
                    <span class="text-3xl text-white">✓</span>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">Request Submitted!</h3>
                <p class="text-xs text-gray-500 mb-4">Our team will reach out to you shortly.</p>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full animate-pulse" style="width:60%"></div>
                </div>
            </div>

            {{-- STEP 0 --}}
            <div x-show="step === 0 && !showSuccess" x-cloak class="space-y-1.5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Step 1 — Your Details</p>

                {{-- Name --}}
                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Full Name</label>
                    <div class="relative">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <input type="text" x-model="form.name" placeholder="Your full name"
                               class="w-full text-xs border rounded-lg pl-7 pr-3 py-1.5 outline-none transition-all placeholder-gray-400 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                               :class="errors.name ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200'">
                    </div>
                    <p x-show="errors.name" x-text="errors.name" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Email</label>
                    <div class="relative">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                                <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                            </svg>
                        </span>
                        <input type="email" x-model="form.email" placeholder="Enter Email"
                               class="w-full text-xs border rounded-lg pl-7 pr-3 py-1.5 outline-none transition-all placeholder-gray-400 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                               :class="errors.email ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200'">
                    </div>
                    <p x-show="errors.email" x-text="errors.email" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                {{-- Phone --}}
                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Phone</label>
                    <div class="relative">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <input type="tel" x-model="form.phone" placeholder="Enter Phone"
                               class="w-full text-xs border rounded-lg pl-7 pr-3 py-1.5 outline-none transition-all placeholder-gray-400 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                               :class="errors.phone ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200'">
                    </div>
                    <p x-show="errors.phone" x-text="errors.phone" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                <button type="button" @click="nextStep()" :disabled="loading"
                        class="w-full flex items-center justify-center gap-2 py-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-200 hover:from-indigo-700 hover:to-violet-700 transition-all disabled:opacity-60 disabled:cursor-not-allowed">
                    <span x-show="!loading">Next →</span>
                    <span x-show="loading" x-cloak class="flex items-center gap-2">
                        <svg class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Validating…
                    </span>
                </button>
            </div>

            {{-- STEP 1 --}}
            <div x-show="step === 1 && !showSuccess" x-cloak class="space-y-2.5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Step 2 — Preferences</p>

            
                 

                {{-- Location --}}
<div>
    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Your Location</label>
    <div class="relative">
        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 z-10 pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
            </svg>
        </span>

        <input type="text"
               x-model="form.location"
               @input="showCities = true"
               @focus="showCities = true"
               @blur="setTimeout(() => showCities = false, 200)"
               placeholder="Search city…"
               autocomplete="off"
               class="w-full text-xs border rounded-lg pl-7 pr-3 py-1.5 outline-none transition-all placeholder-gray-400 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
               :class="errors.location ? 'border-red-400' : 'border-gray-200'">

        {{-- ✅ ONE dropdown wrapper only --}}
        <div x-show="showCities"
             x-cloak
             class="absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-xl max-h-48 overflow-y-auto">

            {{-- Empty state --}}
            <template x-if="filteredCities.length === 0">
                <div class="px-3 py-2 text-xs text-gray-400 italic">No cities found</div>
            </template>

            {{-- City list --}}
            <template x-for="zone in filteredCities" :key="zone.id ?? zone.slug ?? zone.name">
                <button type="button"
                        @mousedown.prevent="selectCity(zone)"
                        class="w-full text-left px-3 py-2 text-xs hover:bg-indigo-50 hover:text-indigo-700 text-gray-700 flex items-center gap-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3 text-gray-400 flex-shrink-0">
                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                    </svg>
                    <span x-text="zone.name"></span>
                </button>
            </template>
        </div>
    </div>
    <p x-show="errors.location" x-text="errors.location" class="text-[10px] text-red-500 mt-0.5"></p>
</div>

                {{-- Age --}}
                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Age Range</label>
                    <select x-model="form.age" class="w-full text-xs border rounded-xl px-3 py-2 outline-none bg-white cursor-pointer focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                            :class="errors.age ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200'">
                        <option value="">Select Age Range</option>
                        @foreach(['Under 20','20 – 24','25 – 29','30 – 34','35 – 39','40 – 44','45 – 49','50 – 54','55 – 59','60+'] as $age)
                        <option>{{ $age }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.age" x-text="errors.age" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                {{-- When to start --}}
                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">When to Start?</label>
                    <select x-model="form.whenToStart" class="w-full text-xs border rounded-xl px-3 py-2 outline-none bg-white cursor-pointer focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                            :class="errors.whenToStart ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200'">
                        <option value="">Select Timeline</option>
                        @foreach(['Immediately','Within 1 Week','Within 1 Month','Within 3 Months','Within 6 Months','Just Exploring'] as $timeline)
                        <option>{{ $timeline }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.whenToStart" x-text="errors.whenToStart" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                <div class="flex gap-2 pt-0.5">
                    <button type="button" @click="step = 0" :disabled="loading" class="flex-1 py-2 bg-gray-100 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-200 transition-all disabled:opacity-60">← Back</button>
                    <button type="button" @click="nextStep()" :disabled="loading" class="flex-1 py-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-200 hover:from-indigo-700 hover:to-violet-700 transition-all disabled:opacity-60">
                        <span x-show="!loading">Next →</span>
                        <span x-show="loading" x-cloak>Validating…</span>
                    </button>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div x-show="step === 2 && !showSuccess" x-cloak>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Step 3 — Your Message</p>

                <div class="mb-2">
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Comments</label>
                    <textarea x-model="form.comment" placeholder="Tell us what you're looking for…" rows="4"
                              class="w-full text-xs border border-gray-200 rounded-xl px-3 py-2 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 placeholder-gray-400 transition-all resize-none"></textarea>
                </div>

                <div class="bg-indigo-50 border border-indigo-100 rounded-xl px-3 py-2 space-y-1 mb-2">
                    <p class="text-[9px] font-bold text-indigo-600 uppercase tracking-widest mb-1">Summary</p>
                    <p class="text-[10px] text-indigo-700"><span x-text="form.name"></span> · <span x-text="form.email"></span></p>
                    <p class="text-[10px] text-indigo-700"><span x-text="form.phone"></span> · <span x-text="form.location"></span></p>
                    <p class="text-[10px] text-indigo-700"><span x-text="form.age"></span> · <span x-text="form.whenToStart"></span></p>
                </div>

                <div class="flex gap-2">
                    <button type="button" @click="step = 1" :disabled="loading" class="px-3 py-2 bg-gray-100 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-200 transition-all disabled:opacity-60">←</button>
                    <button type="button" @click="submitForm()" :disabled="loading" class="flex-1 py-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-200 hover:from-indigo-700 hover:to-violet-700 transition-all disabled:opacity-60">
                        <span x-show="!loading">✉ Submit Enquiry</span>
                        <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            Submitting…
                        </span>
                    </button>
                </div>
                <p class="text-[9px] text-gray-400 text-center mt-2">By submitting you agree to our Terms &amp; Privacy Policy</p>
            </div>

        </div>
    </div>
</div>

 <script>
function sidebarEnquiry(tracking = {}, zones = []) {

    // Reset user fields but KEEP tracking
    const baseForm = () => ({
        name: '', email: '', phone: '',
        location: '',          // display name shown in input
        location_slug: '',     // clean slug for DB / attribution
        location: null,     // optional zone FK
        age: '', whenToStart: '', comment: '',
        website: '',           // honeypot
        kw_text:   tracking.kw_text   || '',
        city_id:   tracking.city_id   || '',
        from_page: tracking.from_page || '',
        lead_form: tracking.lead_form || 1,
    });

    return {
        step: 0,
        loading: false,
        showSuccess: false,
        showCities: false,
        submitError: '',
        form: baseForm(),
        errors: {},

        // 👇 dynamic from $zonesForAlpine — array of {id, name, slug}
      cities: Array.isArray(zones) ? zones : [],  
 
        get csrf() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        },

        get filteredCities() {
            const q = (this.form.location || '').toLowerCase().trim();
            if (!q) return this.cities.slice(0, 30);   // show first 30 when empty
            return this.cities
                .filter(c => (c.name || '').toLowerCase().includes(q))
                .slice(0, 30);
        },

        selectCity(zone) {
            this.form.location      = zone.name;
            this.form.location_slug = zone.slug || '';
            this.form.location   = zone.id   || null;
            this.showCities = false;
        },

        clientValidate(s) {
            const e = {};
            if (s === 0) {
                if (!this.form.name.trim()) e.name = 'Required';
                if (!/\S+@\S+\.\S+/.test(this.form.email)) e.email = 'Valid email required';
                const digits = (this.form.phone || '').replace(/\D/g, '');
                if (digits.length < 10) e.phone = 'Enter phone number (min 10 digits)';
            }
            if (s === 1) {
                if (!this.form.location) e.location = 'Required';
                if (!this.form.age) e.age = 'Required';
                if (!this.form.whenToStart) e.whenToStart = 'Required';
            }
            return e;
        },

        async postJson(url, payload) {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(payload),
            });
            const data = await res.json().catch(() => ({}));
            return { status: res.status, data };
        },

        mapServerErrors(serverErrors) {
            const mapped = {};
            for (const [key, val] of Object.entries(serverErrors || {})) {
                mapped[key] = Array.isArray(val) ? val[0] : val;
            }
            return mapped;
        },

        async nextStep() {
            this.submitError = '';
            this.errors = this.clientValidate(this.step);
            if (Object.keys(this.errors).length > 0) return;

            this.loading = true;
            try {
                const { status, data } = await this.postJson(
                    '{{ route("form.validate.step") }}',
                    { step: this.step, ...this.form }
                );

                if (status === 422) {
                    this.errors = this.mapServerErrors(data.errors);
                    return;
                }
                if (data.success) {
                    this.errors = {};
                    this.step++;
                } else {
                    this.submitError = 'Validation failed. Please check your details.';
                }
            } catch (err) {
                this.submitError = 'Network error. Please try again.';
            } finally {
                this.loading = false;
            }
        },

        async submitForm() {
            this.submitError = '';
            this.loading = true;
            try {
                const { status, data } = await this.postJson(
                    '/client/lead/saveEnquiry',
                    this.form
                );

                if (status === 422) {
                    this.errors = this.mapServerErrors(data.errors);
                    this.submitError = 'Please review your details.';
                    if (this.errors.name || this.errors.email || this.errors.phone) this.step = 0;
                    else if (this.errors.location || this.errors.age || this.errors.whenToStart) this.step = 1;
                    return;
                }

                if (data.success) {
                    this.showSuccess = true;
                    setTimeout(() => {
                        this.showSuccess = false;
                        this.step = 0;
                        this.form = baseForm();
                        this.errors = {};
                    }, 3500);
                } else {
                    this.submitError = data.message || 'Could not submit. Try again.';
                }
            } catch (err) {
                this.submitError = 'Network error. Please try again.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>