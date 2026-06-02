{{-- resources/views/spa/components/hero-banner.blade.php --}}

@php
    $spa = $spa ?? [
        'name'      => 'Serenity Spa & Wellness',
        'phone'     => '+9175-9543-9543',
        'whatsapp'  => '917595439543',
        'location'  => 'Koregaon Park · Pune',
        'address'   => 'Koregaon Park, Pune',
        'est'       => '2013',
    ];
 
    $rotatingWords = ['Renewal', 'Serenity', 'Balance', 'Bliss', 'Harmony'];
    // $services = [
    //     'Swedish Massage', 'Hot Stone Therapy', 'Ayurvedic Ritual',
    //     'Aromatherapy', 'Hydrotherapy', 'Facial Glow',
    //     'Signature 3-Hour Retreat', "Couple's Retreat", 'Nail & Polish',
    // ];
    $timeSlots = [
        '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM',
        '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM',
    ];
    $steps = [
        ['n' => 1, 'label' => 'Details',   'icon' => '👤'],
        ['n' => 2, 'label' => 'Treatment', 'icon' => '🌸'],
        ['n' => 3, 'label' => 'Verify',    'icon' => '🔐'],
        ['n' => 4, 'label' => 'Done',      'icon' => '✓'],
    ];
@endphp

<section x-data="heroBanner()" x-init="init()" class="pt-16 pb-1 overflow-hidden relative">

    {{-- Decorative orbs --}}
    <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full pointer-events-none"
         style="background:radial-gradient(circle,rgba(37,99,235,0.08) 0%,transparent 70%);"></div>
    <div class="absolute -bottom-20 -left-24 w-[400px] h-[400px] rounded-full pointer-events-none"
         style="background:radial-gradient(circle,rgba(59,130,246,0.06) 0%,transparent 70%);"></div>

    <div class="max-w-7xl mx-auto px-6 relative">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- ════════════════════════════════════
                 LEFT — Hero content
            ════════════════════════════════════ --}}
            <div class="hero-left-col flex flex-col">

                {{-- LOGO BLOCK --}}
                <div class="hero-logo-block flex items-center gap-3.5 mb-6 w-full">
                    <div class="relative shrink-0">
                        <div class="relative w-20 h-20 rounded-3xl flex items-center justify-center overflow-hidden
                                    bg-gradient-to-br from-blue-600 to-blue-700 shadow-xl shadow-blue-500/40">
                            <div class="absolute -inset-2 rounded-3xl"
                                 style="background:linear-gradient(135deg,rgba(255,255,255,0.18) 0%,transparent 50%);"></div>
                            <span class="relative z-10 text-white font-black text-4xl tracking-tighter"
                                  style="font-family:'Playfair Display',serif;">S</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-green-500 border-2 border-white
                                    flex items-center justify-center text-white text-[10px] font-black">✓</div>
                    </div>

                    <div>
                        <div class="font-bold text-base text-stone-900 leading-tight tracking-tight"
                             style="font-family:'Playfair Display',serif;">
                            {{ $spa['name'] }}
                        </div>
                        <div class="text-[11px] font-bold tracking-[0.22em] uppercase text-orange-600 mt-0.5">
                            {{ $spa['location'] }}
                        </div>
                        <div class="inline-flex items-center gap-1.5 mt-1.5 px-2.5 py-0.5 rounded-full
                                    bg-green-50 border-2 border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 open-now-pulse"></span>
                            <span class="text-[10px] font-extrabold text-green-600 tracking-wider uppercase">Open Now</span>
                        </div>
                    </div>

                    <div class="hero-logo-sep w-px h-10 bg-stone-300 mx-1 hidden sm:block"></div>
                    <div class="hero-est-pill px-3 py-0.5 rounded-full bg-orange-50 border border-orange-200
                                text-[10px] font-bold tracking-widest uppercase text-orange-700 hidden sm:block">
                        Est. {{ $spa['est'] }}
                    </div>
                </div>

                {{-- HEADING WITH ROTATING WORD --}}
                <h1 class="hero-heading text-[clamp(3rem,6vw,5.2rem)] text-stone-900 mb-1 leading-none font-black"
                    style="font-family:'Playfair Display',serif;">
                    The Art of
                </h1>

                <div class="hero-word mb-6 transition-all duration-350"
                     :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                    <span class="text-[clamp(3rem,6vw,5.2rem)] font-black leading-none
                                 bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 bg-clip-text text-transparent"
                          style="font-family:'Playfair Display',serif;"
                          x-text="words[wordIdx]">Renewal</span>
                </div>

                {{-- DESCRIPTION --}}
                <p class="hero-desc text-base sm:text-lg leading-relaxed text-stone-600 max-w-md mb-8">
                    A sanctuary where ancient therapies meet modern luxury.
                    Every visit is crafted around you — from first breath to final moment.
                </p>

                {{-- CTA ROW --}}
                <div class="hero-cta-row flex gap-3 flex-wrap mb-5">
                    
                    <button @click="scrollTo('spa-types')"
                            class="px-7 py-3 rounded-full bg-white text-stone-700 border-2 border-stone-200 font-bold text-sm
                                   hover:border-stone-300 hover:bg-stone-50 transition-all">
                        Explore Services
                    </button>
                </div>

                {{-- STATS --}}
                <div class="hero-stats grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                    @foreach([['12+','Years'],['5K+','Guests'],['25+','Treatments'],['4.9★','Rating']] as [$v, $l])
                        <div class="bg-white border border-stone-200 rounded-xl px-2 py-3.5 text-center shadow-sm">
                            <div class="text-xl font-black mb-0.5 bg-gradient-to-r from-orange-500 to-amber-600 bg-clip-text text-transparent"
                                 style="font-family:'Playfair Display',serif;">{{ $v }}</div>
                            <div class="text-[10px] font-bold tracking-widest uppercase text-stone-500">{{ $l }}</div>
                        </div>
                    @endforeach
                </div>

                {{-- ACTION TABS --}}
                <div class="hero-action-tabs flex gap-2 items-center overflow-x-auto pb-1
                            [scrollbar-width:none] [-webkit-overflow-scrolling:touch]"
                     style="scrollbar-width:none;">

                    {{-- Call --}}
                    <a href="tel:{{ $spa['phone'] }}"
                       class="hero-tab-call shrink-0 inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full
                              bg-green-500 text-white text-sm font-bold no-underline
                              shadow-md shadow-green-500/30 hover:-translate-y-0.5 hover:shadow-lg transition-all">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.02 2.2 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/>
                        </svg>
                        Call Now
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/{{ $spa['whatsapp'] }}?text={{ urlencode('Hi ' . $spa['name'] . '! I would like to book a treatment.') }}"
                       target="_blank" rel="noopener"
                       class="hero-tab-whatsapp shrink-0 inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full
                              bg-[#25d366] text-white text-sm font-bold no-underline
                              shadow-md shadow-emerald-500/30 hover:-translate-y-0.5 hover:shadow-lg transition-all">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp
                    </a>

                    {{-- Enquire --}}
                    <button @click="$dispatch('open-modal')"
                            class="hero-tab-enquire shrink-0 inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full
                                   bg-blue-500 text-white text-sm font-bold
                                   shadow-md shadow-blue-500/30 hover:-translate-y-0.5 hover:shadow-lg transition-all">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        Enquire Now
                    </button>

                    {{-- Location --}}
                    <a href="https://maps.google.com/?q={{ urlencode($spa['address']) }}"
                       target="_blank" rel="noopener"
                       class="shrink-0 inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full
                              bg-green-500 text-white text-sm font-bold no-underline
                              shadow-md shadow-green-500/30 hover:-translate-y-0.5 hover:shadow-lg transition-all">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        Location
                    </a>

                    {{-- Share --}}
                    <button @click="share()"
                            class="shrink-0 inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full
                                   bg-blue-500 text-white text-sm font-bold
                                   shadow-md shadow-blue-500/30 hover:-translate-y-0.5 hover:shadow-lg transition-all">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                        </svg>
                        Share
                    </button>
                </div>
            </div>

            {{-- ════════════════════════════════════
                 RIGHT — 4-Step Booking Form
            ════════════════════════════════════ --}}
            <div class="w-full pt-2">
                <div class="rounded-3xl overflow-hidden border border-blue-200/40"
                     style="box-shadow:0 24px 64px rgba(0,0,0,0.12), 0 4px 16px rgba(37,99,235,0.08);">

                    {{-- Blue header with steps --}}
                    <div class="relative overflow-hidden px-7 pt-6 pb-5 bg-gradient-to-br from-blue-600 to-blue-700">
                        <div class="absolute -top-16 -right-16 w-52 h-52 rounded-full pointer-events-none"
                             style="background:radial-gradient(circle,rgba(255,255,255,0.15) 0%,transparent 65%);"></div>
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full pointer-events-none"
                             style="background:radial-gradient(circle,rgba(0,0,0,0.1) 0%,transparent 65%);"></div>

                        <div class="relative z-10 mb-4">
                            <div class="text-[10px] font-extrabold tracking-widest uppercase text-white/70 mb-1">
                                Reserve Your Experience
                            </div>
                            <div class="text-2xl font-extrabold text-white leading-tight"
                                 style="font-family:'Playfair Display',serif;">
                                Book Your <span class="opacity-90">Spa</span>
                            </div>
                        </div>

                        {{-- Step dots --}}
                        <div class="relative z-10 flex gap-1.5 items-center mb-3.5">
                            @foreach($steps as $i => $s)
                                @php $isLast = $i === count($steps) - 1; @endphp
                                <div class="flex items-center gap-1 {{ $isLast ? '' : 'flex-1' }}">
                                    <div class="flex flex-col items-center gap-1">
                                        <div :class="step > {{ $s['n'] }} ? 'bg-white text-blue-700' : step === {{ $s['n'] }} ? 'bg-white text-blue-700 hf-dot-active ring-4 ring-white/20' : 'bg-white/20 text-white/50'"
                                             class="w-7 h-7 rounded-full shrink-0 flex items-center justify-center text-[11px] font-extrabold transition-all">
                                            <span x-show="step > {{ $s['n'] }}">✓</span>
                                            <span x-show="step <= {{ $s['n'] }}">{{ $s['n'] }}</span>
                                        </div>
                                        <div class="text-[8px] font-bold tracking-wider uppercase whitespace-nowrap"
                                             :class="step === {{ $s['n'] }} ? 'text-white' : step > {{ $s['n'] }} ? 'text-white/75' : 'text-white/40'">
                                            {{ $s['label'] }}
                                        </div>
                                    </div>
                                    @if(!$isLast)
                                        <div class="flex-1 h-0.5 rounded-full bg-white/25 overflow-hidden mb-3.5 mx-0.5">
                                            <div class="h-full rounded-full bg-white/90 transition-all duration-500"
                                                 :style="`width: ${step > {{ $s['n'] }} ? 100 : 0}%`"></div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Progress shimmer --}}
                        <div class="relative z-10 h-1 bg-white/25 rounded-full overflow-hidden">
                            <div class="h-full rounded-full hf-prog" :style="`width: ${((step-1)/3)*100}%`"></div>
                        </div>
                    </div>

                    {{-- Form body --}}
                    <div class="bg-white px-7 py-6">

                        {{-- ═══ Step 1: Details ═══ --}}
                        <div x-show="step === 1" class="hf-slide-right">
                            <div class="text-lg font-bold text-stone-900 mb-1" style="font-family:'Playfair Display',serif;">
                                Tell us about you
                            </div>
                            <div class="text-xs text-stone-400 mb-4">Step 1 of 3 · Choose your Service next</div>

                            <div class="space-y-3.5">
                                <div>
                                    <label class="hf-label">Full Name *</label>
                                    <input type="text" class="hf-input" placeholder="Enter Name" x-model="form.name">                                    
                                    <input type="hidden" x.model="form.from_page" value="spa hub">
                                    <input type="hidden" x.model="form.lead_form" value="1">                                   
                                    <input type="hidden" x.model="form.location_id"   value="none">
                                    
                                </div>
                                <div>
                                    <label class="hf-label">Mobile Number *</label>
                                    <div class="flex gap-1.5">
                                        <div class="px-3 py-2.5 rounded-lg border-2 border-stone-200 bg-stone-50 text-sm font-bold text-stone-700">+91</div>
                                        <input type="tel" class="hf-input flex-1" placeholder="Enter Phone no" maxlength="10"
                                               x-model="form.phone"
                                               @input="form.phone = $event.target.value.replace(/\D/g,'').slice(0,10)">
                                    </div>
                                    <div class="text-[11px] text-stone-400 mt-1">OTP verification at the last step</div>
                                </div>
                            </div>

                            <button class="hf-cta mt-4"
                                    :disabled="!form.name.trim() || form.phone.length !== 10"
                                    @click="goStep(2, 1)">
                                Continue to Service →
                            </button>
                        </div>

                        {{-- ═══ Step 2: Treatment ═══ --}}
                        <div x-show="step === 2" :class="`hf-slide-${formDir}`">
                            <div class="text-lg font-bold text-stone-900 mb-1" style="font-family:'Playfair Display',serif;">
                                Choose your Service
                            </div>
                            <div class="text-xs text-stone-400 mb-4">Step 2 of 3 · OTP verification next</div>

                            <div class="space-y-3">
                                <div>
                                    <label class="hf-label">Service *</label>
                                    <select class="hf-select" x-model="form.kw_text">
                                        <option value="">— Choose a Service —</option>
                                        @foreach($services as $s)
                                            <option value="{{ $s->id }}">{{ $s->keyword }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-2.5">
                                    <div>
                                        <label class="hf-label">Date *</label>
                                        <input type="date" class="hf-select" :min="today" x-model="form.date">
                                    </div>
                                    <div>
                                        <label class="hf-label">Time *</label>
                                        <select class="hf-select" x-model="form.time">
                                            <option value="">— Pick slot —</option>
                                            @foreach($timeSlots as $slot)
                                                <option value="{{ $slot }}">{{ $slot }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Time chips --}}
                                <div class="flex gap-1.5 overflow-x-auto pb-1" style="scrollbar-width:none;">
                                    @foreach($timeSlots as $slot)
                                        <button @click="form.time = '{{ $slot }}'"
                                                :class="form.time === '{{ $slot }}' ? 'hf-chip sel' : 'hf-chip'">
                                            {{ $slot }}
                                        </button>
                                    @endforeach
                                </div>

                                <div>
                                    <label class="hf-label">
                                        Special Requests <span class="text-stone-400 font-normal normal-case">(optional)</span>
                                    </label>
                                    <textarea class="hf-input resize-none" rows="2"
                                              placeholder="Allergies, preferences, special occasions…"
                                              x-model="form.remark"></textarea>
                                </div>
                            </div>

                            <div class="flex gap-2 mt-4">
                                <button @click="goStep(1, 2)"
                                        class="shrink-0 px-4 py-3 rounded-lg border-2 border-stone-200 bg-stone-50 text-stone-600 font-bold text-sm">
                                    ← Back
                                </button>
                                <button class="hf-cta flex-1"
                                        :disabled="!form.kw_text || !form.date || !form.time"
                                        @click="sendOtp(); goStep(3, 2)">
                                    Verify with OTP →
                                </button>
                            </div>
                        </div>

                        {{-- ═══ Step 3: OTP ═══ --}}
                        <div x-show="step === 3" :class="`hf-slide-${formDir}`" class="flex flex-col items-center gap-4">
                            <div class="text-center">
                                <div class="text-4xl mb-1.5">📱</div>
                                <div class="text-base font-bold text-stone-900 mb-1" style="font-family:'Playfair Display',serif;">
                                    Verify your number
                                </div>
                                <div class="text-xs text-stone-400">
                                    OTP sent to <strong class="text-stone-700">+91 <span x-text="form.phone"></span></strong>
                                </div>
                            </div>

                            <div x-show="demoOtp" class="w-full p-2 rounded-lg text-center text-xs font-bold text-blue-700"
                                 style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:2px dashed rgba(37,99,235,0.4);">
                                🔐 Demo OTP: <span class="font-mono text-base tracking-widest" x-text="demoOtp"></span>
                            </div>

                            <div class="flex gap-1.5">
                                @for($i = 0; $i < 6; $i++)
                                    <input type="text" maxlength="1" inputmode="numeric"
                                           x-model="otp[{{ $i }}]"
                                           x-ref="otp{{ $i }}"
                                           @input="handleOtpInput({{ $i }}, $event.target.value)"
                                           @keydown="handleOtpKey({{ $i }}, $event)"
                                           :class="otp[{{ $i }}] ? 'hf-otp filled' : 'hf-otp'">
                                @endfor
                            </div>

                            <div x-show="otpError" class="w-full text-xs font-semibold text-red-500 bg-red-50 border border-red-200 rounded-md px-3 py-1.5">
                                ⚠ <span x-text="otpError"></span>
                            </div>

                            <div class="w-full flex flex-col gap-2">
                                <button class="hf-cta" :disabled="otp.join('').length < 6" @click="verifyOtp()">
                                    Verify &amp; Confirm →
                                </button>
                                <button @click="goStep(2, 3)"
                                        class="w-full py-2.5 rounded-lg border-2 border-stone-200 bg-stone-50 text-stone-600 font-semibold text-xs">
                                    ← Back to Service
                                </button>
                            </div>

                            <div class="text-xs text-stone-400">
                                <span x-show="resendTimer > 0">Resend in <span x-text="resendTimer"></span>s</span>
                                <button x-show="resendTimer <= 0" @click="sendOtp()"
                                        class="text-blue-600 font-bold text-xs">Resend OTP</button>
                            </div>
                        </div>

                        {{-- ═══ Step 4: Success ═══ --}}
                        <div x-show="step === 4" class="hf-slide-right text-center">
                            <div class="mx-auto w-[70px] h-[70px] rounded-full flex items-center justify-center mb-4
                                        bg-gradient-to-br from-green-500 to-green-600 shadow-xl shadow-green-500/40 hf-check-bounce">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>

                            <div class="text-xl font-extrabold text-stone-900 mb-1" style="font-family:'Playfair Display',serif;">
                                Booking Requested!
                            </div>
                            <div class="text-sm text-stone-500 mb-5 leading-relaxed">We'll confirm within 2 hours.</div>

                            <div class="bg-stone-50 border border-stone-200 rounded-2xl p-3.5 text-left mb-3">
                                <template x-for="(item, idx) in summary" :key="idx">
                                    <div class="flex gap-1.5 py-1 border-b border-stone-100 text-[13px] last:border-b-0">
                                        <span class="text-stone-400 min-w-[100px] shrink-0" x-text="item.label"></span>
                                        <span class="text-stone-900 font-semibold" x-text="item.value"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-md px-3.5 py-2 text-xs text-blue-900 mb-3.5">
                                📞 We'll call <strong>+91 <span x-text="form.phone"></span></strong> to confirm.
                            </div>

                            <button @click="reset()"
                                    class="w-full py-3 rounded-lg border-2 border-stone-200 bg-stone-50 text-stone-700 font-bold text-sm">
                                Make Another Booking
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ════════════ STYLES ════════════ --}}
    <style>
        @keyframes hfSlideRight  { from { opacity:0; transform:translateX(20px); }  to { opacity:1; transform:translateX(0); } }
        @keyframes hfSlideLeft   { from { opacity:0; transform:translateX(-20px); } to { opacity:1; transform:translateX(0); } }
        @keyframes hfCheckBounce { 0%,100% { transform:scale(1); } 50% { transform:scale(1.15); } }
        @keyframes hfPop         { 0% { transform:scale(0.85); opacity:0; } 60% { transform:scale(1.07); } 100% { transform:scale(1); opacity:1; } }
        @keyframes hfPulse       { 0%,100% { box-shadow:0 0 0 0 rgba(37,99,235,0.5); } 60% { box-shadow:0 0 0 8px rgba(37,99,235,0); } }
        @keyframes hfShimmer     { 0% { background-position:200% center; } 100% { background-position:-200% center; } }
        @keyframes openNowPulse  { 0% { box-shadow:0 0 0 0 rgba(34,197,94,0.55); } 70% { box-shadow:0 0 0 7px rgba(34,197,94,0); } 100% { box-shadow:0 0 0 0 rgba(34,197,94,0); } }

        .hf-slide-right    { animation: hfSlideRight 0.35s cubic-bezier(0.16,1,0.3,1) both; }
        .hf-slide-left     { animation: hfSlideLeft 0.35s cubic-bezier(0.16,1,0.3,1) both; }
        .hf-check-bounce   { animation: hfCheckBounce 1.6s ease infinite; }
        .hf-dot-active     { animation: hfPulse 1.8s ease infinite; }
        .open-now-pulse    { animation: openNowPulse 1.8s ease-in-out infinite; }

        .hf-prog {
            background: linear-gradient(90deg,#fff 0%, rgba(255,255,255,0.65) 50%, #fff 100%);
            background-size: 200% auto;
            animation: hfShimmer 2s linear infinite;
            transition: width 0.45s cubic-bezier(0.4,0,0.2,1);
        }

        .hf-input {
            width: 100%; padding: 0.68rem 0.9rem; border-radius: 10px;
            border: 1.5px solid #e5e7eb; font-size: 0.82rem; color: #1c1917;
            outline: none; background: #fafaf9; box-sizing: border-box;
            font-family: inherit; transition: all 0.2s;
        }
        .hf-input:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.1); background:#fff; }

        .hf-select {
            width: 100%; padding: 0.68rem 2.2rem 0.68rem 0.9rem; border-radius: 10px;
            border: 1.5px solid #e5e7eb; font-size: 0.82rem; color: #1c1917;
            outline: none; background: #fafaf9; box-sizing: border-box;
            font-family: inherit; transition: all 0.2s; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%239ca3af' stroke-width='1.5' stroke-linecap='round' fill='none'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 0.75rem center;
        }
        .hf-select:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.1); background-color:#fff; }

        .hf-label {
            display: block; font-size: 0.62rem; font-weight: 700;
            color: #6b7280; letter-spacing: 0.1em; text-transform: uppercase;
            margin-bottom: 0.3rem;
        }

        .hf-otp {
            width: 40px; height: 48px; border-radius: 10px;
            border: 2px solid #e5e7eb; text-align: center;
            font-size: 1.2rem; font-weight: 800; color: #1c1917;
            outline: none; background: #fff; box-sizing: border-box;
            transition: all 0.18s;
        }
        .hf-otp:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.15); background:#eff6ff; }
        .hf-otp.filled { border-color:#2563eb; background:#eff6ff; animation: hfPop 0.2s ease both; }

        .hf-chip {
            padding: 0.35rem 0.6rem; border-radius: 7px; border: 1.5px solid #e5e7eb;
            background: #fff; font-size: 0.68rem; font-weight: 600; color: #374151;
            cursor: pointer; transition: all 0.15s; white-space: nowrap; flex-shrink: 0;
        }
        .hf-chip:hover { border-color:#2563eb; color:#2563eb; }
        .hf-chip.sel { border-color:#2563eb; background:#eff6ff; color:#1d4ed8; font-weight:700; }

        .hf-cta {
            width: 100%; padding: 0.78rem; border-radius: 10px;
            background: linear-gradient(135deg,#2563eb,#1d4ed8);
            border: none; color: #fff; font-weight: 800; font-size: 0.82rem;
            cursor: pointer; box-shadow: 0 4px 14px rgba(37,99,235,0.4);
            transition: all 0.18s; position: relative; overflow: hidden;
        }
        .hf-cta:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,99,235,0.5);
        }
        .hf-cta:disabled {
            background: #e5e7eb; color: #9ca3af;
            box-shadow: none; cursor: not-allowed; transform: none;
        }

        /* Mobile order */
        @media (max-width: 640px) {
            .hero-logo-block  { order: 1; }
            .hero-heading     { order: 2; }
            .hero-word        { order: 3; }
            .hero-desc        { order: 4; font-size: 0.92rem !important; }
            .hero-action-tabs { order: 5; margin-bottom: 0.75rem; }
            .hero-action-tabs .hero-tab-call,
            .hero-action-tabs .hero-tab-whatsapp,
            .hero-action-tabs .hero-tab-enquire { display: none !important; }
            .hero-action-tabs > * { font-size: 0.68rem !important; padding: 0.45rem 0.7rem !important; }
            .hero-cta-row     { order: 6; gap: 0.5rem !important; flex-wrap: nowrap !important; }
            .hero-cta-row button { flex: 1; min-width: 0; font-size: 0.75rem !important; padding: 0.65rem 0.4rem !important; }
            .hero-stats       { order: 7; }
            .hf-otp           { width: 36px; height: 44px; font-size: 1.05rem; }
        }
    </style>

    {{-- ════════════ ALPINE STATE ════════════ --}}
    <script>
        function heroBanner() {
            return {
                // Word rotation
                words: @json($rotatingWords),
                wordIdx: 0,
                visible: true,

                // Form state
                step: 1,
                formDir: 'right',
                form: {
                    name: '', phone: '', kw_text: '', date: '',from_page:'',lead_form:'',location_id:'', time: '', remark: '',
                },
                otp: ['', '', '', '', '', ''],
                demoOtp: '',
                otpError: '',
                resendTimer: 0,
                today: new Date().toISOString().split('T')[0],

                init() {
                    // Word rotation interval
                    setInterval(() => {
                        this.visible = false;
                        setTimeout(() => {
                            this.wordIdx = (this.wordIdx + 1) % this.words.length;
                            this.visible = true;
                        }, 350);
                    }, 3000);
                },

                // Computed summary for Step 4
                get summary() {
                    const items = [
                        { label: '👤 Name',      value: this.form.name },
                        { label: '📱 Mobile',    value: '+91 ' + this.form.phone },
                        { label: '🌸 Treatment', value: this.form.kw_text },
                        { label: '📅 Date',      value: new Date(this.form.date + 'T00:00:00').toLocaleDateString('en-IN', { weekday: 'short', day: 'numeric', month: 'short' }) },
                        { label: '⏰ Time',      value: this.form.time },
                    ];
                    if (this.form.remark) items.push({ label: '📝 Notes', value: this.form.remark });
                    return items;
                },

                scrollTo(id) {
                    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
                },

                share() {
                    if (navigator.share) {
                        navigator.share({
                            title: '{{ $spa['name'] }}',
                            text:  'Book a luxury spa experience!',
                            url:   window.location.href,
                        });
                    } else {
                        navigator.clipboard?.writeText(window.location.href);
                        alert('Link copied to clipboard!');
                    }
                },

                goStep(next, current) {
                    this.formDir = next > current ? 'right' : 'left';
                    this.step    = next;
                },

                sendOtp() {
                    this.demoOtp     = String(Math.floor(100000 + Math.random() * 900000));
                    this.resendTimer = 30;
                    this.otp         = ['', '', '', '', '', ''];
                    this.otpError    = '';

                    const tick = setInterval(() => {
                        this.resendTimer--;
                        if (this.resendTimer <= 0) clearInterval(tick);
                    }, 1000);
                },

                handleOtpInput(idx, val) {
                    const v = val.replace(/\D/g, '').slice(-1);
                    this.otp[idx] = v;
                    if (v && idx < 5) this.$refs[`otp${idx + 1}`]?.focus();
                },

                handleOtpKey(idx, e) {
                    if (e.key === 'Backspace' && !this.otp[idx] && idx > 0) {
                        this.$refs[`otp${idx - 1}`]?.focus();
                    }
                },

                verifyOtp() {
                    if (this.otp.join('') === this.demoOtp) {
                        this.otpError = '';
                        this.goStep(4, 3);
                        this.submitBooking(); // Optional: send to backend
                    } else {
                        this.otpError = 'Incorrect OTP. Please try again.';
                    }
                },

                async submitBooking() {
                    try {
                        await fetch('{{  url("/client/lead/saveEnquiry") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify(this.form),
                        });
                    } catch (err) {
                        console.error('Booking submit error:', err);
                    }
                },

                reset() {
                    this.step    = 1;
                    this.form    = { name: '', phone: '', kw_text: '', date: '', time: '', remark: '' };
                    this.otp     = ['', '', '', '', '', ''];
                    this.demoOtp = '';
                    this.otpError = '';
                    this.resendTimer = 0;
                },
            };
        }
    </script>
</section>