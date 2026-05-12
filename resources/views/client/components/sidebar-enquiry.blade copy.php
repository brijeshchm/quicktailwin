{{-- Sidebar 3-step enquiry form --}}
<div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-indigo-500/15"
     x-data="sidebarEnquiry()">

    <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-indigo-500 via-violet-500 to-purple-600 p-[2px]"></div>

    <div class="relative bg-white rounded-[22px] overflow-hidden">
        {{-- Header with steps --}}
        <div class="relative bg-gradient-to-br from-indigo-600 via-violet-600 to-purple-700 px-4 pt-3 pb-3 overflow-hidden">
            <div class="flex items-center gap-2.5 mb-1">
                <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center border border-white/30">
                    ⚡
                </div>
                <h2 class="text-white font-bold text-base">Quick Enquiry</h2>
            </div>
            <p class="text-white/70 text-xs mb-2">We'll connect you with the best vendors instantly.</p>

            {{-- Step indicator --}}
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

            {{-- SUCCESS --}}
            <div x-show="showSuccess" x-cloak class="text-center py-8">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-xl">
                    <span class="text-3xl">✓</span>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-1">Request Submitted!</h3>
                <p class="text-xs text-gray-500 mb-4">Our team will reach out to you shortly.</p>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full animate-pulse-slow" style="width:60%"></div>
                </div>
            </div>

            {{-- STEP 0 --}}
            <div x-show="step === 0 && !showSuccess" x-cloak class="space-y-1.5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Step 1 — Your Details</p>

                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Full Name</label>
                    <div class="relative">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                        <input type="text" x-model="form.name" placeholder="Your full name"
                               class="w-full text-xs border rounded-lg pl-7 pr-3 py-1.5 outline-none transition-all placeholder-gray-400 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                               :class="errors.name ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200'">
                    </div>
                    <p x-show="errors.name" x-text="errors.name" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Email</label>
                    <div class="relative">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400">✉</span>
                        <input type="email" x-model="form.email" placeholder="you@example.com"
                               class="w-full text-xs border rounded-lg pl-7 pr-3 py-1.5 outline-none transition-all placeholder-gray-400 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                               :class="errors.email ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200'">
                    </div>
                    <p x-show="errors.email" x-text="errors.email" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Phone</label>
                    <div class="relative">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400">📞</span>
                        <input type="tel" x-model="form.phone" placeholder="+91 00000 00000"
                               class="w-full text-xs border rounded-lg pl-7 pr-3 py-1.5 outline-none transition-all placeholder-gray-400 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                               :class="errors.phone ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200'">
                    </div>
                    <p x-show="errors.phone" x-text="errors.phone" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Your Location</label>
                    <div class="relative">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 z-10 pointer-events-none">📍</span>
                        <input type="text" x-model="form.location" x-model.lazy="locationQuery"
                               @input="showCities = true; form.location = ''"
                               @focus="showCities = true"
                               @blur="setTimeout(() => showCities = false, 200)"
                               placeholder="Search city…"
                               class="w-full text-xs border border-gray-200 rounded-lg pl-8 pr-3 py-1.5 outline-none transition-all placeholder-gray-400 bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                               :class="errors.location ? 'border-red-400' : 'border-gray-200'">
                        <div x-show="showCities" x-cloak class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl max-h-40 overflow-y-auto">
                            <template x-for="city in filteredCities" :key="city">
                                <button type="button" @click="selectCity(city)" class="w-full text-left px-3 py-2 text-xs hover:bg-indigo-50 hover:text-indigo-700 text-gray-700 flex items-center gap-2">
                                    📍 <span x-text="city"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    <p x-show="errors.location" x-text="errors.location" class="text-[10px] text-red-500 mt-0.5 mt-4"></p>
                </div>

                <button type="button" @click="nextStep()"
                        class="w-full flex items-center justify-center gap-2 py-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-200 hover:from-indigo-700 hover:to-violet-700 transition-all">
                    Next →
                </button>
            </div>

            {{-- STEP 1 --}}
            <div x-show="step === 1 && !showSuccess" x-cloak class="space-y-2.5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Step 2 — Preferences</p>

                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">Age Range</label>
                    <select x-model="form.age" class="w-full text-xs border border-gray-200 rounded-xl px-3 py-2 outline-none bg-white cursor-pointer focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                            :class="errors.age ? 'border-red-400 ring-2 ring-red-100' : ''">
                        <option value="">Select Age Range</option>
                        @foreach(['Under 20', '20 – 24', '25 – 29', '30 – 34', '35 – 39', '40 – 44', '45 – 49', '50 – 54', '55 – 59', '60+'] as $age)
                        <option>{{ $age }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.age" x-text="errors.age" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                <div>
                    <label class="text-[10px] font-semibold text-gray-500 mb-0.5 block">When to Start?</label>
                    <select x-model="form.whenToStart" class="w-full text-xs border border-gray-200 rounded-xl px-3 py-2 outline-none bg-white cursor-pointer focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                            :class="errors.whenToStart ? 'border-red-400 ring-2 ring-red-100' : ''">
                        <option value="">Select Timeline</option>
                        @foreach(['Immediately', 'Within 1 Week', 'Within 1 Month', 'Within 3 Months', 'Within 6 Months', 'Just Exploring'] as $timeline)
                        <option>{{ $timeline }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.whenToStart" x-text="errors.whenToStart" class="text-[10px] text-red-500 mt-0.5"></p>
                </div>

                <div class="flex gap-2 pt-0.5">
                    <button type="button" @click="step = 0" class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-gray-100 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-200 transition-all">
                        ← Back
                    </button>
                    <button type="button" @click="nextStep()" class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-200 hover:from-indigo-700 hover:to-violet-700 transition-all">
                        Next →
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

                {{-- Summary --}}
                <div class="bg-indigo-50 border border-indigo-100 rounded-xl px-3 py-2 space-y-1 mb-2">
                    <p class="text-[9px] font-bold text-indigo-600 uppercase tracking-widest mb-1">Summary</p>
                    <p class="text-[10px] text-indigo-700"><span x-text="form.name"></span> · <span x-text="form.email"></span></p>
                    <p class="text-[10px] text-indigo-700"><span x-text="form.phone"></span> · <span x-text="form.location"></span></p>
                    <p class="text-[10px] text-indigo-700"><span x-text="form.age"></span> · <span x-text="form.whenToStart"></span></p>
                </div>

                <div class="flex gap-2">
                    <button type="button" @click="step = 1" class="flex items-center justify-center gap-1 px-3 py-2 bg-gray-100 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-200 transition-all">←</button>
                    <button type="button" @click="submitForm()" class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-200 hover:from-indigo-700 hover:to-violet-700 transition-all">
                        ✉ Submit Enquiry
                    </button>
                </div>
                <p class="text-[9px] text-gray-400 text-center mt-2">By submitting you agree to our Terms &amp; Privacy Policy</p>
            </div>

        </div>
    </div>
</div>

<script>
function sidebarEnquiry() {
    return {
        step: 0,
        showSuccess: false,
        showCities: false,
        form: {
            name: '', email: '', phone: '', location: '',
            age: '', whenToStart: '', comment: ''
        },
        errors: {},
        cities: ['Faridabad','New Delhi','Noida','Gurugram','Ghaziabad','Mumbai','Pune','Bengaluru','Chennai','Hyderabad','Jaipur','Lucknow','Chandigarh','Ahmedabad','Surat','Kolkata','Patna','Bhopal','Indore','Nagpur'],
        get filteredCities() {
            const q = this.form.location?.toLowerCase() ?? '';
            return q ? this.cities.filter(c => c.toLowerCase().includes(q)) : this.cities;
        },
        selectCity(city) {
            this.form.location = city;
            this.showCities = false;
        },
        validateStep(s) {
            const e = {};
            if (s === 0) {
                if (!this.form.name.trim()) e.name = 'Required';
                if (!/\S+@\S+\.\S+/.test(this.form.email)) e.email = 'Valid email required';
                if (this.form.phone.length < 10) e.phone = 'Min 10 digits';
                if (!this.form.location) e.location = 'Required';
            }
            if (s === 1) {
                if (!this.form.age) e.age = 'Required';
                if (!this.form.whenToStart) e.whenToStart = 'Required';
            }
            return e;
        },
        nextStep() {
            this.errors = this.validateStep(this.step);
            if (Object.keys(this.errors).length === 0) this.step++;
        },
        submitForm() {
            this.showSuccess = true;
            setTimeout(() => {
                this.showSuccess = false;
                this.step = 0;
                this.form = { name:'', email:'', phone:'', location:'', age:'', whenToStart:'', comment:'' };
            }, 3000);
        }
    }
}
</script>
