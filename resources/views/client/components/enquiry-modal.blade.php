<div x-data="enquiryModal()"
     x-show="open"
     style="display:none"
     @open-enquiry.window="openWith($event.detail)"
     @keydown.escape.window="close()"
     class="fixed inset-0 z-[999] flex items-center justify-center"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <div class="absolute inset-0 bg-black/70 backdrop-blur-md" @click="close()"></div>

    <div class="relative z-10 mx-4 w-[calc(100vw-2rem)] max-w-sm
                md:mx-0 md:w-full md:max-w-3xl md:h-[560px]
                max-h-[92vh] bg-white rounded-3xl shadow-2xl
                overflow-hidden flex flex-col md:flex-row"
         @click.stop
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4">

        {{-- LEFT PANEL --}}
        <div class="hidden md:flex md:w-5/12 relative flex-col overflow-hidden flex-shrink-0">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-violet-700"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/80 via-violet-900/70 to-black/60 z-10"></div>
            <div class="relative z-20 flex flex-col justify-between h-full p-7">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center shadow-lg ring-2 ring-white/20 flex-shrink-0">
                        <span class="text-white font-bold text-base" x-text="business.initials || '?'"></span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-white/60 text-[10px] font-semibold uppercase tracking-widest">Quick Enquiry</p>
                        <p class="text-white font-bold text-sm leading-tight truncate" x-text="business.name || 'Business'"></p>
                    </div>
                </div>
                <div>
                    <h2 class="text-white font-bold text-2xl leading-snug mb-2">Get a free<br>consultation</h2>
                    <p class="text-white/70 text-sm leading-relaxed">Fill out the form and we'll connect within minutes.</p>
                </div>
                <div class="space-y-2">
                    @foreach(['Your Info','Preferences','Message'] as $si => $lbl)
                    <div class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-300"
                         :class="{{ $si }} === step ? 'bg-white/20' : 'opacity-40'">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0 text-xs font-bold transition-all"
                             :class="{{ $si }} < step ? 'bg-emerald-400 text-white' : ({{ $si }} === step ? 'bg-white text-indigo-600' : 'bg-white/20 text-white/50')">
                            <template x-if="{{ $si }} < step"><span>✓</span></template>
                            <template x-if="{{ $si }} >= step"><span>{{ ['👤','⚙️','✉️'][$si] }}</span></template>
                        </div>
                        <span class="text-white text-xs font-semibold">{{ $lbl }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- MOBILE BANNER --}}
        <div class="md:hidden relative h-28 flex-shrink-0 bg-gradient-to-br from-indigo-600 to-violet-700">
            <div class="absolute inset-0 bg-gradient-to-b from-indigo-900/60 to-indigo-900/80"></div>
            <div class="relative z-10 h-full flex items-center px-5 gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex-shrink-0 flex items-center justify-center shadow-lg ring-2 ring-white/30">
                    <span class="text-white font-bold text-sm" x-text="business.initials || '?'"></span>
                </div>
                <div>
                    <p class="text-white/60 text-[10px] uppercase tracking-widest font-semibold">Quick Enquiry</p>
                    <p class="text-white font-bold text-base leading-tight" x-text="business.name || 'Business'"></p>
                    <p class="text-white/70 text-xs mt-0.5">Response within &lt; 15 min</p>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="flex-1 flex flex-col overflow-hidden min-h-0">

            {{-- Progress bar --}}
            <div class="h-1 bg-gray-100 flex-shrink-0">
                <div class="h-full bg-gradient-to-r from-violet-500 via-indigo-500 to-cyan-400 transition-all duration-500"
                     :style="`width:${(step/3)*100}%`"></div>
            </div>

            {{-- Close --}}
            <button @click="close()"
                    class="absolute top-3 right-3 z-20 w-8 h-8 flex items-center justify-center
                           rounded-xl bg-white/80 backdrop-blur-sm text-gray-500
                           hover:text-gray-800 hover:bg-white transition-all shadow-sm text-sm">✕</button>

            {{-- Desktop step label --}}
            <div class="hidden md:flex items-center gap-2 px-5 pt-4 pb-1 flex-shrink-0">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">
                    Step <span x-text="step + 1"></span> / 3
                </span>
                <div class="flex-1 h-px bg-gray-100"></div>
                <span class="text-xs text-gray-400" x-text="['Your Info','Preferences','Message'][step]"></span>
            </div>

            {{-- Mobile dots --}}
            <div class="flex md:hidden items-center justify-center gap-2 pt-3 flex-shrink-0">
                @foreach(range(0,2) as $si)
                <div class="h-1.5 rounded-full transition-all duration-300"
                     :class="{{ $si }} === step ? 'w-6 bg-indigo-600' : ({{ $si }} < step ? 'w-4 bg-emerald-400' : 'w-4 bg-gray-200')"></div>
                @endforeach
            </div>

            <div class="flex-1 overflow-y-auto px-5 py-4">

                {{-- SUCCESS --}}
                <div x-show="showSuccess" style="display:none"
                     class="flex flex-col items-center justify-center text-center gap-4 py-10 min-h-[280px]">
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-3xl flex items-center justify-center shadow-xl">
                        <span class="text-white text-4xl font-bold">✓</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-xl mb-1">Enquiry Sent!</h3>
                        <p class="text-sm text-gray-500"><span x-text="business.name || 'The business'"></span> will respond within 15 min.</p>
                        <p class="text-xs text-gray-400 mt-2">This window closes automatically…</p>
                    </div>
                    <div class="w-48 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div x-ref="shrinkBar" class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full w-full"></div>
                    </div>
                </div>

                {{-- STEP 0 --}}
                <div x-show="!showSuccess && step === 0" style="display:none" class="space-y-3">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Step 1 — Your Details</p>

                    @foreach([['name','Full Name','Your full name','text','👤'],['email','Email','Enter Email','email','✉️'],['phone','Phone','Enter Phone','tel','📞']] as [$f,$lbl,$ph,$t,$ico])
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ $lbl }}</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none">{{ $ico }}</span>
                            <input type="{{ $t }}" x-model="form.{{ $f }}" placeholder="{{ $ph }}"
                                   :class="errors.{{ $f }} ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100'"
                                   class="w-full text-sm border rounded-xl pl-8 pr-3 py-2.5 outline-none transition-all placeholder-gray-400 bg-white">
                        </div>
                        <p x-show="errors.{{ $f }}" x-text="errors.{{ $f }}" style="display:none" class="text-[10px] text-red-500 mt-0.5"></p>
                    </div>
                    @endforeach

                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Location</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none">📍</span>
                            <select x-model="form.location"
                                    :class="errors.location ? 'border-red-400 ring-2 ring-red-100' : 'border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100'"
                                    class="w-full text-sm border rounded-xl pl-8 pr-8 py-2.5 appearance-none outline-none bg-white cursor-pointer transition-all">
                                <option value="">Select Location</option>
                                @foreach($zones ?? [] as $zone)
                                <option value="{{ $zone['id'] }}">{{ $zone['cityDetails'] }}</option>
                                @endforeach
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs">▾</span>
                        </div>
                        <p x-show="errors.location" x-text="errors.location" style="display:none" class="text-[10px] text-red-500 mt-0.5"></p>
                    </div>

                    <button type="button" @click="next()"
                            class="w-full py-2.5 mt-1 bg-gradient-to-r from-indigo-600 to-violet-600 text-white
                                   text-sm font-semibold rounded-xl shadow-lg hover:from-indigo-700 hover:to-violet-700 active:scale-95 transition-all">
                        Next →
                    </button>
                </div>

                {{-- STEP 1 --}}
                <div x-show="!showSuccess && step === 1" style="display:none" class="space-y-3">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Step 2 — Preferences</p>

                    @foreach([['age','Age Range',['Under 20','20–24','25–29','30–34','35–39','40–44','45–49','50–54','55–59','60+']],['whenToStart','When to Start?',['Immediately','Within 1 Week','Within 1 Month','Within 3 Months','Just Exploring']]] as [$f,$lbl,$opts])
                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">{{ $lbl }}</label>
                        <div class="relative">
                            <select x-model="form.{{ $f }}"
                                    :class="errors.{{ $f }} ? 'border-red-400 ring-2 ring-red-100 text-red-500' : 'border-gray-200 text-gray-700 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100'"
                                    class="w-full text-sm border rounded-xl px-3 py-2.5 appearance-none outline-none bg-white cursor-pointer transition-all">
                                <option value="">Select {{ $lbl }}</option>
                                @foreach($opts as $o)<option>{{ $o }}</option>@endforeach
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs">▾</span>
                        </div>
                        <p x-show="errors.{{ $f }}" x-text="errors.{{ $f }}" style="display:none" class="text-[10px] text-red-500 mt-0.5"></p>
                    </div>
                    @endforeach

                    <div class="flex gap-2 pt-1">
                        <button type="button" @click="step = 0" class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 active:scale-95 transition-all">← Back</button>
                        <button type="button" @click="next()" class="flex-1 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-semibold rounded-xl shadow-lg hover:from-indigo-700 hover:to-violet-700 active:scale-95 transition-all">Next →</button>
                    </div>
                </div>

                {{-- STEP 2 --}}
                <div x-show="!showSuccess && step === 2" style="display:none" class="space-y-3">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Step 3 — Your Message</p>

                    <div>
                        <label class="text-xs font-semibold text-gray-600 mb-1 block">Message</label>
                        <textarea x-model="form.comment" rows="3" placeholder="Tell them what you need…"
                                  class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 outline-none
                                         focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 placeholder-gray-400 resize-none transition-all"></textarea>
                    </div>

                    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-3 text-xs text-gray-600 space-y-1">
                        <p class="text-[9px] font-bold text-indigo-600 uppercase tracking-widest mb-1">Summary</p>
                        <p><span class="font-semibold text-indigo-700">Name:</span> <span x-text="form.name"></span></p>
                        <p><span class="font-semibold text-indigo-700">Contact:</span> <span x-text="form.phone"></span> · <span x-text="form.email"></span></p>
                        <p><span class="font-semibold text-indigo-700">Location:</span> <span x-text="form.location"></span> · <span x-text="form.age"></span></p>
                        <p><span class="font-semibold text-indigo-700">Timeline:</span> <span x-text="form.whenToStart"></span></p>
                    </div>

                    <div class="flex gap-2">
                        <button type="button" @click="step = 1" class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 active:scale-95 transition-all">← Back</button>
                        <button type="button" @click="submit()"
                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5
                                       bg-gradient-to-r from-indigo-600 to-violet-600 text-white
                                       text-sm font-semibold rounded-xl shadow-lg
                                       hover:from-indigo-700 hover:to-violet-700 active:scale-95 transition-all">
                            ✉ Submit Enquiry
                        </button>
                    </div>
                    <p class="text-[10px] text-gray-400 text-center">By submitting you agree to our Terms &amp; Privacy Policy</p>
                </div>

            </div>{{-- /scroll --}}
        </div>{{-- /right panel --}}
    </div>{{-- /modal box --}}
</div>{{-- /modal root --}}

<script>
function enquiryModal() {
    return {
        open: false, step: 0, showSuccess: false,
        business: { name: '', initials: '' },
        form: { name:'', email:'', phone:'', location:'', age:'', whenToStart:'', comment:'' },
        errors: {},

        openWith(detail) {
            this.business    = detail;
            this.step        = 0;
            this.showSuccess = false;
            this.errors      = {};
            this.form        = { name:'', email:'', phone:'', location:'', age:'', whenToStart:'', comment:'' };
            this.open        = true;
            document.body.style.overflow = 'hidden';
        },

        close() { this.open = false; document.body.style.overflow = ''; },

        validate() {
            const e = {};
            if (this.step === 0) {
                if (!this.form.name.trim())                        e.name     = 'Required';
                if (!/\S+@\S+\.\S+/.test(this.form.email))        e.email    = 'Valid email required';
                if (this.form.phone.replace(/\D/g,'').length < 7) e.phone    = 'Valid phone required';
                if (!this.form.location)                           e.location = 'Pick a city';
            }
            if (this.step === 1) {
                if (!this.form.age)         e.age         = 'Select age range';
                if (!this.form.whenToStart) e.whenToStart = 'Select timeline';
            }
            return e;
        },

        next() { this.errors = this.validate(); if (Object.keys(this.errors).length) return; this.step++; },

        submit() {
            this.showSuccess = true;
            this.$nextTick(() => {
                if (this.$refs.shrinkBar)
                    this.$refs.shrinkBar.style.animation = 'shrink 3s linear forwards';
            });
            setTimeout(() => { this.showSuccess = false; this.close(); }, 3000);
        }
    };
}

function openEnquiry(name = '', initials = '') {
    if (!initials && name) {
        const w = name.trim().split(' ').filter(Boolean);
        initials = ((w[0]?.[0] ?? '') + (w[1]?.[0] ?? '')).toUpperCase();
    }
    window.dispatchEvent(new CustomEvent('open-enquiry', { detail: { name, initials } }));
}
</script>