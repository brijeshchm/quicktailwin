 
@push('styles')
<style>
/* ── Gradient text ──────────────────────────────── */
.gradient-text {
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ── Animated orbs ──────────────────────────────── */
@keyframes orb-float {
    0%,100% { transform: translate(0,0) scale(1); }
    33%      { transform: translate(40px,-30px) scale(1.3); }
    66%      { transform: translate(-20px,20px) scale(0.9); }
}
.orb { animation: orb-float 10s ease-in-out infinite; border-radius: 50%; filter: blur(80px); pointer-events: none; position: absolute; }

/* ── Morphing blob ──────────────────────────────── */
@keyframes morph {
    0%,100% { border-radius: 60% 40% 30% 70%/60% 30% 70% 40%; transform: rotate(0deg); }
    50%      { border-radius: 30% 60% 70% 40%/50% 60% 30% 60%; transform: rotate(180deg); }
}
.morph-blob { animation: morph 12s ease-in-out infinite; opacity: .3; filter: blur(32px); pointer-events: none; position: absolute; }

/* ── Shimmer on form header ─────────────────────── */
@keyframes shimmer-h {
    0%   { background-position: -200% 0; }
    100% { background-position:  200% 0; }
}
.shimmer-bar {
    background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.4) 50%, transparent 100%);
    background-size: 200% 100%;
    animation: shimmer-h 3s linear infinite;
}

/* ── Rotating glow border ───────────────────────── */
@keyframes rotate-bg {
    0%   { background-position: 0% 0%; }
    100% { background-position: 300% 300%; }
}
.glow-border::before {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: inherit;
    background: linear-gradient(135deg, #2563eb, #7c3aed, #06b6d4, #2563eb);
    background-size: 300% 300%;
    animation: rotate-bg 5s linear infinite;
    z-index: -1;
    filter: blur(2px);
    opacity: .8;
}

/* ── Count-up number animation ──────────────────── */
@keyframes count-in {
    from { opacity:0; transform: translateY(12px); }
    to   { opacity:1; transform: translateY(0); }
}
.count-in { animation: count-in .5s ease forwards; }

/* ── FAQ accordion ──────────────────────────────── */
.faq-answer { max-height: 0; overflow: hidden; transition: max-height .35s cubic-bezier(.04,.62,.23,.98), opacity .25s ease; opacity: 0; }
.faq-answer.open { max-height: 400px; opacity: 1; }

/* ── Review slider ──────────────────────────────── */
.review-track { display: flex; transition: transform .4s ease; }

/* ── Grid dot background ────────────────────────── */
.dot-grid {
    background-image: linear-gradient(#2563eb 1px, transparent 1px),
                      linear-gradient(90deg, #2563eb 1px, transparent 1px);
    background-size: 60px 60px;
    opacity: .05;
}

/* ── Pulse dot ──────────────────────────────────── */
@keyframes pulse-dot {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(.8); }
}
.pulse-dot { animation: pulse-dot 1.4s ease-in-out infinite; }

/* ── Slide-in animations ────────────────────────── */
.slide-up   { opacity:0; transform:translateY(40px); transition: opacity .6s ease, transform .6s ease; }
.slide-left { opacity:0; transform:translateX(-30px); transition: opacity .5s ease, transform .5s ease; }
.slide-right{ opacity:0; transform:translateX(70px); transition: opacity .9s cubic-bezier(.16,1,.3,1); }
.visible    { opacity:1 !important; transform:none !important; }

/* ── Tilt card ──────────────────────────────────── */
.tilt-card { transition: transform .2s ease; transform-style: preserve-3d; }
.tilt-card:hover { transform: perspective(600px) rotateX(3deg) rotateY(-3deg) scale(1.02); }

/* ── Step connector line ────────────────────────── */
.step-line { height:2px; background:linear-gradient(90deg,#2563eb,#7c3aed); transform:scaleX(0); transform-origin:left; transition:transform 1.6s ease .3s; }
.step-line.visible { transform:scaleX(1) !important; }

/* ── Input focus ring ───────────────────────────── */
.form-input:focus { border-color:#60a5fa; box-shadow: 0 0 0 4px rgba(59,130,246,.12); outline:none; background:#fff; }
.form-input       { transition: border-color .2s, box-shadow .2s, background .2s; }
</style>
@endpush

 

{{-- ── HERO ─────────────────────────────────────────────────── --}}
<section class="relative pt-24 pb-20 overflow-hidden" style="background:linear-gradient(135deg,#f0f4ff 0%,#f8f6ff 40%,#eff9ff 100%);">
    {{-- Orbs --}}
    <div class="orb w-[600px] h-[600px] bg-blue-400 opacity-15 -top-48 -left-48" style="animation-delay:0s"></div>
    <div class="orb w-[500px] h-[500px] bg-violet-400 opacity-10 top-10 -right-48" style="animation-delay:3s"></div>
    <div class="orb w-[300px] h-[300px] bg-cyan-400 opacity-15 bottom-0 left-1/2" style="animation-delay:6s"></div>
    <div class="morph-blob w-64 h-64 bg-blue-300 top-20 right-20"></div>
    <div class="morph-blob w-48 h-48 bg-violet-300 bottom-20 left-10" style="animation-delay:4s"></div>
    <div class="dot-grid absolute inset-0 pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-14 items-start">

            {{-- ─── LEFT COLUMN ─── --}}
            <div class="pt-6 space-y-6 slide-left" id="hero-left">

                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur border border-blue-100 text-blue-700 text-sm font-semibold px-4 py-2 rounded-full shadow-sm">
                    ✨ Join 8,100+ Suppliers on QuickDials
                </div>

                {{-- Title --}}
                <h1 class="text-4xl sm:text-5xl lg:text-[3.4rem] font-extrabold text-slate-900 leading-tight tracking-tight">
                    Grow <span class="gradient-text">Your</span> Business<br>
                    <span class="text-slate-700">With QuickDials</span>
                </h1>

                <p class="text-slate-500 text-base leading-relaxed max-w-lg">
                    India's fastest-growing B2B marketplace. List for free, or choose a premium plan to
                    unlock leads, visibility, and growth tools.
                </p>

                {{-- Stats grid --}}
                @php
                $statItems = [
                    ['label'=>'Grow Client',    'value'=> $growthBusiness['GrowClient']         ?? '—', 'icon'=>'users',       'color'=>'text-blue-600',    'bg'=>'bg-blue-50'],
                    ['label'=>'Suppliers',      'value'=> $growthBusiness['Suppliers']           ?? '—', 'icon'=>'building-2',  'color'=>'text-emerald-600', 'bg'=>'bg-emerald-50'],
                    ['label'=>'Products',       'value'=> $growthBusiness['ProductsServices']    ?? '—', 'icon'=>'shopping-bag','color'=>'text-violet-600',  'bg'=>'bg-violet-50'],
                    ['label'=>'Keywords',       'value'=> $growthBusiness['Keyword']             ?? '—', 'icon'=>'target',      'color'=>'text-orange-600',  'bg'=>'bg-orange-50'],
                    ['label'=>'Stores',         'value'=> $growthBusiness['Store']               ?? '—', 'icon'=>'globe',       'color'=>'text-rose-600',    'bg'=>'bg-rose-50'],
                    ['label'=>'Platform',       'value'=> $growthBusiness['Platform']            ?? '—', 'icon'=>'bar-chart-3', 'color'=>'text-cyan-600',    'bg'=>'bg-cyan-50'],
                ];
                @endphp
                <div class="grid grid-cols-3 gap-3">
                    @foreach($statItems as $s)
                    <div class="tilt-card bg-white/80 backdrop-blur rounded-2xl p-3.5 border border-white shadow-sm text-center cursor-default">
                        <div class="w-8 h-8 {{ $s['bg'] }} rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i data-lucide="{{ $s['icon'] }}" class="w-4 h-4 {{ $s['color'] }}"></i>
                        </div>
                        <div class="text-base font-extrabold text-slate-800">{{ $s['value'] }}</div>
                        <div class="text-[10px] text-slate-400 font-medium mt-0.5 leading-tight">{{ $s['label'] }}</div>
                    </div>
                    @endforeach
                </div>

                {{-- Benefits --}}
                @php
                $benefits = [
                    ['icon'=>'trending-up',       'title'=>'Grow Your Business', 'desc'=>'Reach buyers across India',       'color'=>'text-blue-600',    'bg'=>'bg-blue-50',    'border'=>'border-blue-100'],
                    ['icon'=>'dollar-sign',        'title'=>'Zero Commission',    'desc'=>'No transaction fees, ever',       'color'=>'text-emerald-600', 'bg'=>'bg-emerald-50', 'border'=>'border-emerald-100'],
                    ['icon'=>'headphones',         'title'=>'Expert Support',     'desc'=>'Dedicated account managers',      'color'=>'text-violet-600',  'bg'=>'bg-violet-50',  'border'=>'border-violet-100'],
                    ['icon'=>'shield',             'title'=>'Verified Badge',     'desc'=>'Build trust with customers',      'color'=>'text-orange-600',  'bg'=>'bg-orange-50',  'border'=>'border-orange-100'],
                ];
                @endphp
                <div class="space-y-2.5">
                    @foreach($benefits as $b)
                    <div class="flex items-center gap-3 bg-white/70 backdrop-blur rounded-xl p-3.5 border {{ $b['border'] }} hover:translate-x-1 transition-transform cursor-default">
                        <div class="w-9 h-9 {{ $b['bg'] }} rounded-xl flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $b['icon'] }}" class="w-4 h-4 {{ $b['color'] }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-slate-700 text-sm">{{ $b['title'] }}</div>
                            <div class="text-xs text-slate-400">{{ $b['desc'] }}</div>
                        </div>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 shrink-0"></i>
                    </div>
                    @endforeach
                </div>

                {{-- Success Story Slider --}}
                <div id="success-slider" class="relative rounded-2xl overflow-hidden cursor-default">
                      @php
                    $stories = [
                        ['initials'=>'RK','name'=>'Ramesh Kumar & Sons','category'=>'Auto Parts','city'=>'Delhi','quote'=>'Joined QuickDials 6 months ago. Today we get 40+ inquiries a week from verified buyers — our revenue doubled.','metrics'=>[['label'=>'Inquiries/wk','value'=>'40+'],['label'=>'Revenue','value'=>'2×'],['label'=>'New buyers','value'=>'180+']],'grad'=>'from-blue-600 via-indigo-600 to-violet-700'],
                        ['initials'=>'PP','name'=>'Patel Textiles','category'=>'Fabric & Apparel','city'=>'Surat','quote'=>'Within 3 months on QuickDials our export orders tripled. The platform brought us buyers we couldn reach in 10 years.','metrics'=>[['label'=>'Export orders','value'=>'3×'],['label'=>'Newmarkets','value'=>'6'],['label'=>'Leads/month','value'=>'120+']],'grad'=>'from-emerald-600 via-teal-600 to-cyan-700'],
                        ['initials'=>'AK','name'=>'Kapoor Jewellers','category'=>'Jewellery','city'=>'Jaipur','quote'=>'We landed 12 bulk wholesale orders in our first quarter. QuickDials connects us to exactly the right buyers.','metrics'=>[['label'=>'Bulk orders','value'=>'12'],['label'=>'Newclients','value'=>'34'],['label'=>'Revenue up','value'=>'68%']],'grad'=>'from-amber-600 via-orange-600 to-rose-600'],
                        ['initials'=>'SR','name'=>'Reddy Pharma','category'=>'Pharma','city'=>'Hyderabad','quote'=>'Our listing went live in under 5 minutes. The same day we got 4 inquiries from hospitals we had never heard of.','metrics'=>[['label'=>'Hospitals reached','value'=>'40+'],['label'=>'Inquiries/day','value'=>'8+'],['label'=>'ROI','value'=>'14×']],'grad'=>'from-violet-600 via-purple-600 to-fuchsia-700'],
                    ];
                    @endphp

                    @foreach($stories as $si => $s)
                    <div class="success-slide {{ $si > 0 ? 'hidden' : '' }} relative bg-gradient-to-br {{ $s['grad'] }} rounded-2xl p-5 overflow-hidden">
                        <div class="absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 10% 90%,#fff 0%,transparent 50%)"></div>
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-white/70 pulse-dot"></span>
                                    <span class="text-[10px] font-bold text-white/70 uppercase tracking-widest">Success Story</span>
                                </div>
                                <div class="flex gap-1.5" id="story-dots-{{ $si }}">
                                    @foreach($stories as $di => $d)
                                    <button onclick="goStory({{ $di }})" class="story-dot rounded-full transition-all duration-300 {{ $di === 0 ? 'w-4 h-1.5 bg-white' : 'w-1.5 h-1.5 bg-white/30' }}"></button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-start gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-extrabold text-sm shrink-0">{{ $s['initials'] }}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-white font-bold text-sm leading-tight">{{ $s['name'] }}</div>
                                    <div class="text-white/60 text-[11px]">{{ $s['category'] }} · {{ $s['city'] }}</div>
                                </div>
                                <div class="flex shrink-0">★★★★★</div>
                            </div>
                            <p class="text-white/80 text-xs leading-relaxed mb-4 italic">"{{ $s['quote'] }}"</p>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($s['metrics'] as $m)
                                <div class="bg-white/10 rounded-xl p-2.5 text-center">
                                    <div class="text-white font-extrabold text-base">{{ $m['value'] }}</div>
                                    <div class="text-white/60 text-[9px] leading-tight mt-0.5">{{ $m['label'] }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <button onclick="goStory(currentStory-1)" class="absolute left-2 top-1/2 -translate-y-1/2 w-6 h-6 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center transition-all">‹</button>
                        <button onclick="goStory(currentStory+1)" class="absolute right-2 top-1/2 -translate-y-1/2 w-6 h-6 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center transition-all">›</button>
                    </div>
                    @endforeach
                </div>

                {{-- Cities --}}
                <div class="bg-white/70 backdrop-blur rounded-2xl border border-white shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="globe" class="w-3.5 h-3.5 text-blue-500"></i>
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Cities We Cover</span>
                        </div>
                        <span class="text-[10px] text-blue-500 font-medium">500+ cities</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach([['n'=>'Mumbai','c'=>'1.2K'],['n'=>'Delhi','c'=>'1.1K'],['n'=>'Bangalore','c'=>'980'],['n'=>'Hyderabad','c'=>'870'],['n'=>'Ahmedabad','c'=>'760'],['n'=>'Chennai','c'=>'720'],['n'=>'Pune','c'=>'680'],['n'=>'Surat','c'=>'540'],['n'=>'Jaipur','c'=>'460'],['n'=>'Kolkata','c'=>'420'],['n'=>'Lucknow','c'=>'390'],['n'=>'+ 489 more','c'=>'']] as $city)
                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2.5 py-1 rounded-full border bg-blue-50 text-blue-600 border-blue-100 hover:bg-blue-100 transition-colors cursor-default">
                            {{ $city['n'] }}@if($city['c'])<span class="text-[8px] opacity-60">{{ $city['c'] }}</span>@endif
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- ─── END LEFT ─── --}}

            {{-- ─── RIGHT COLUMN: Form ─── --}}
            <div class="relative flex flex-col gap-5 slide-right" id="hero-right">

                {{-- Glow card --}}
                <div class="relative glow-border rounded-3xl" style="isolation:isolate;">
                    <div class="relative bg-white rounded-3xl overflow-hidden shadow-2xl">

                        {{-- Form header --}}
                        <div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-700 p-5 overflow-hidden">
                            <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>
                            <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-white/10 rounded-full"></div>
                            <div class="shimmer-bar absolute inset-0 opacity-30"></div>
                            <div class="relative flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                    <i data-lucide="building-2" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white leading-tight">List Your Business</h2>
                                    <p class="text-blue-200 text-xs">Free forever · Upgrade anytime</p>
                                </div>
                                <div class="ml-auto text-amber-300 text-xl">✨</div>
                            </div>
                        </div>

                        {{-- Success flash --}}
                        @if(session('success'))
                        <div class="m-5 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm font-medium flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white shrink-0">✓</div>
                            <div>
                                <div class="font-bold">You're All Set!</div>
                                <div class="text-xs text-emerald-600">{{ session('success') }}</div>
                            </div>
                        </div>
                        @endif

                        {{-- Form --}}
                        <form action="{{ route('business-owners.submit') }}" method="POST" class="p-5 space-y-3" id="enquiry">
                            @csrf

                            {{-- Business Name --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Business / Company Name</label>
                                <div class="relative">
                                    <i data-lucide="building-2" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"></i>
                                    <input type="text" name="business_name" value="{{ old('business_name') }}"
                                           placeholder="e.g. Sharma Enterprises"
                                           class="form-input w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-slate-300 text-sm @error('business_name') border-red-400 @enderror">
                                </div>
                                @error('business_name')<p class="text-red-500 text-[10px] mt-0.5">{{ $message }}</p>@enderror
                            </div>

                            {{-- Email + Phone --}}
                            <div class="grid grid-cols-2 gap-2.5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                                    <div class="relative">
                                        <i data-lucide="mail" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"></i>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                               placeholder="Enter Email"
                                               class="form-input w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-slate-300 text-sm @error('email') border-red-400 @enderror">
                                    </div>
                                    @error('email')<p class="text-red-500 text-[10px] mt-0.5">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Phone</label>
                                    <div class="relative">
                                        <i data-lucide="phone" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"></i>
                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                               placeholder="Enter Phone"
                                               class="form-input w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-slate-300 text-sm @error('phone') border-red-400 @enderror">
                                    </div>
                                    @error('phone')<p class="text-red-500 text-[10px] mt-0.5">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- City + Category --}}
                            <div class="grid grid-cols-2 gap-2.5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">City</label>
                                    <div class="relative">
                                        <i data-lucide="globe" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"></i>
                                        <input type="text" name="city" value="{{ old('city') }}"
                                               placeholder="Mumbai"
                                               class="form-input w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-slate-300 text-sm @error('city') border-red-400 @enderror">
                                    </div>
                                    @error('city')<p class="text-red-500 text-[10px] mt-0.5">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Category</label>
                                    <select name="business_category"
                                            class="form-input w-full pl-3 pr-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:border-slate-300 text-sm @error('business_category') border-red-400 @enderror">
                                        <option value="">Select...</option>
                                        @foreach(['Retail & Shopping','Food & Restaurant','Healthcare','Education','Technology','Real Estate','Automotive','Beauty & Wellness','Finance & Banking','Travel & Tourism','Manufacturing','Other'] as $cat)
                                        <option value="{{ $cat }}" {{ old('business_category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                    @error('business_category')<p class="text-red-500 text-[10px] mt-0.5">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Package selector --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Interested Package</label>
                                <div class="grid grid-cols-3 gap-2" id="pkg-grid">
                                    @php
                                    $packages = [
                                        ['id'=>'starter', 'name'=>'Starter (Free)',      'badge'=>null,           'icon'=>'globe',       'border'=>'border-slate-500',  'bg'=>'from-slate-50 to-slate-100'],
                                        ['id'=>'growth',  'name'=>'Growth — ₹999/mo',    'badge'=>'Most Popular',  'icon'=>'trending-up', 'border'=>'border-blue-500',   'bg'=>'from-blue-50 to-indigo-50'],
                                        ['id'=>'premium', 'name'=>'Premium — ₹2,499/mo', 'badge'=>'Best Value',    'icon'=>'sparkles',    'border'=>'border-violet-500', 'bg'=>'from-violet-50 to-purple-50'],
                                    ];
                                    @endphp
                                    @foreach($packages as $pkg)
                                    <button type="button"
                                            onclick="selectPkg('{{ $pkg['id'] }}')"
                                            id="pkg-{{ $pkg['id'] }}"
                                            class="pkg-btn relative rounded-xl p-2.5 border-2 border-slate-200 bg-white text-center transition-all duration-200 hover:border-blue-200 hover:-translate-y-0.5">
                                        @if($pkg['badge'])
                                        <span class="absolute -top-2 left-1/2 -translate-x-1/2 text-[9px] font-bold text-white bg-gradient-to-r from-blue-500 to-indigo-600 px-2 py-0.5 rounded-full whitespace-nowrap">{{ $pkg['badge'] }}</span>
                                        @endif
                                        <i data-lucide="{{ $pkg['icon'] }}" class="w-4 h-4 mx-auto mb-1 text-slate-500"></i>
                                        <div class="text-[10px] font-semibold text-slate-700 leading-tight">{{ $pkg['name'] }}</div>
                                    </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="package_interest" id="package_interest" value="{{ old('package_interest') }}">
                                @error('package_interest')<p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                    class="w-full py-3 mt-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 hover:from-blue-700 hover:via-indigo-700 hover:to-violet-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-300/40 flex items-center justify-center gap-2 text-sm hover:-translate-y-0.5 active:scale-95">
                                <i data-lucide="rocket" class="w-4 h-4"></i>
                                Start Your Business Free
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>

                            <div class="flex items-center justify-center gap-5 pt-1">
                                @foreach([['icon'=>'shield','text'=>'100% Secure'],['icon'=>'clock','text'=>'2 min setup'],['icon'=>'star','text'=>'4.8★ rated']] as $trust)
                                <div class="flex items-center gap-1 text-[10px] text-slate-400 font-medium">
                                    <i data-lucide="{{ $trust['icon'] }}" class="w-3 h-3"></i>
                                    {{ $trust['text'] }}
                                </div>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Floating badge --}}
                <div class="absolute -top-4 -right-4 z-10 bg-white rounded-2xl px-4 py-2.5 shadow-xl border border-slate-100 flex items-center gap-2.5">
                    <div class="flex -space-x-1.5">
                        @foreach(['bg-blue-400','bg-emerald-400','bg-violet-400','bg-amber-400'] as $c)
                        <div class="w-6 h-6 rounded-full {{ $c }} border-2 border-white"></div>
                        @endforeach
                    </div>
                    <div class="text-xs">
                        <div class="font-bold text-slate-800">8,100+</div>
                        <div class="text-slate-400">active sellers</div>
                    </div>
                </div>

                {{-- Live Activity Feed --}}
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white shadow-sm overflow-hidden">
                    <div class="flex items-center gap-2.5 px-4 py-3 border-b border-slate-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 pulse-dot"></span>
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Live Activity</span>
                        <span class="ml-auto text-[10px] text-slate-400 bg-slate-50 px-2 py-0.5 rounded-full border border-slate-100">Real-time</span>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach([
                            ['name'=>'Priya Fashion House','city'=>'Surat','pkg'=>'Growth','time'=>'2 min ago','initials'=>'PF','color'=>'from-pink-400 to-rose-500','pkgcls'=>'bg-blue-50 text-blue-600 border-blue-100'],
                            ['name'=>'TechVision Solutions','city'=>'Bangalore','pkg'=>'Premium','time'=>'11 min ago','initials'=>'TV','color'=>'from-blue-400 to-indigo-500','pkgcls'=>'bg-violet-50 text-violet-600 border-violet-100'],
                            ['name'=>'Mehta Electronics','city'=>'Ahmedabad','pkg'=>'Starter','time'=>'23 min ago','initials'=>'ME','color'=>'from-amber-400 to-orange-500','pkgcls'=>'bg-slate-50 text-slate-500 border-slate-100'],
                            ['name'=>'GreenLeaf Organics','city'=>'Pune','pkg'=>'Growth','time'=>'38 min ago','initials'=>'GL','color'=>'from-emerald-400 to-teal-500','pkgcls'=>'bg-blue-50 text-blue-600 border-blue-100'],
                        ] as $act)
                        <div class="flex items-center gap-3 px-4 py-3 hover:bg-blue-50/50 transition-colors cursor-default">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br {{ $act['color'] }} flex items-center justify-center text-white text-[10px] font-extrabold shrink-0">{{ $act['initials'] }}</div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-semibold text-slate-700 truncate">{{ $act['name'] }}</div>
                                <div class="text-[10px] text-slate-400">{{ $act['city'] }}</div>
                            </div>
                            <div class="flex flex-col items-end gap-0.5">
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full border {{ $act['pkgcls'] }}">{{ $act['pkg'] }}</span>
                                <span class="text-[9px] text-slate-300">{{ $act['time'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Why QuickDials mini-card --}}
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-4 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 80% 20%,#3b82f6 0%,transparent 50%)"></div>
                    <div class="relative">
                        <div class="text-xs font-bold text-slate-300 uppercase tracking-wide mb-3">Why QuickDials?</div>
                        <div class="space-y-2.5">
                            @foreach([
                                ['icon'=>'trending-up', 'label'=>'Average lead increase',     'value'=>'10x',    'sub'=>'within first 30 days',            'color'=>'text-emerald-400'],
                                ['icon'=>'users',       'label'=>'Business response rate',    'value'=>'94%',    'sub'=>'buyers contact listed sellers',    'color'=>'text-blue-400'],
                                ['icon'=>'clock',       'label'=>'Setup time',                'value'=>'< 2 min','sub'=>'from signup to going live',        'color'=>'text-amber-400'],
                            ] as $why)
                            <div class="flex items-center gap-3 bg-white/5 rounded-xl px-3 py-2.5">
                                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center shrink-0">
                                    <i data-lucide="{{ $why['icon'] }}" class="w-4 h-4 {{ $why['color'] }}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-[10px] text-slate-400 leading-tight">{{ $why['label'] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $why['sub'] }}</div>
                                </div>
                                <div class="text-base font-extrabold {{ $why['color'] }} shrink-0">{{ $why['value'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- ─── END RIGHT ─── --}}

        </div>
    </div>
</section>

{{-- ── HOW IT WORKS ─────────────────────────────────────────── --}}
<section class="py-12 relative overflow-hidden" style="background:linear-gradient(135deg,#eef2ff 0%,#f0f9ff 50%,#faf5ff 100%);">
    <div class="absolute inset-0 pointer-events-none opacity-40" style="background-image:radial-gradient(circle at 20% 50%,#bfdbfe 0%,transparent 40%),radial-gradient(circle at 80% 50%,#ddd6fe 0%,transparent 40%)"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-10">
            <div class="slide-up">
                <div class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1">How It Works</div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Get Live in <span class="gradient-text">4 Steps</span></h2>
            </div>
            <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur border border-emerald-100 text-emerald-600 text-xs font-bold px-4 py-2 rounded-full shadow-sm shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 pulse-dot"></span>
                Under 10 minutes — start to live
            </div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 relative">
            {{-- Connector line --}}
            <div class="hidden lg:block absolute top-7 left-[12%] right-[12%] h-0.5 bg-slate-100 overflow-hidden rounded-full">
                <div class="step-line h-full rounded-full" id="step-line"></div>
            </div>

            @foreach([
                ['step'=>'01','title'=>'Register', 'desc'=>'Fill the quick form in under 60 seconds',         'icon'=>'message-square','grad'=>'from-blue-500 to-blue-600',    'soft'=>'bg-blue-50',    'tc'=>'text-blue-600',   'time'=>'~60 sec'],
                ['step'=>'02','title'=>'Verify',   'desc'=>'Our team calls to confirm your details',           'icon'=>'check-circle-2','grad'=>'from-violet-500 to-purple-600','soft'=>'bg-violet-50',  'tc'=>'text-violet-600', 'time'=>'~2 min'],
                ['step'=>'03','title'=>'Go Live',  'desc'=>'Your listing reaches thousands of buyers',          'icon'=>'rocket',        'grad'=>'from-indigo-500 to-blue-600',  'soft'=>'bg-indigo-50',  'tc'=>'text-indigo-600', 'time'=>'~3 min'],
                ['step'=>'04','title'=>'Grow',     'desc'=>'Receive leads & manage via your dashboard',         'icon'=>'trending-up',   'grad'=>'from-emerald-500 to-teal-600','soft'=>'bg-emerald-50', 'tc'=>'text-emerald-600','time'=>'Ongoing'],
            ] as $i => $step)
            <div class="slide-up relative bg-white/80 backdrop-blur rounded-2xl p-5 border border-white shadow-sm hover:shadow-lg hover:border-blue-100 transition-all duration-300 group cursor-default hover:-translate-y-1.5"
                 style="transition-delay:{{ $i * 120 }}ms">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $step['grad'] }} flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i data-lucide="{{ $step['icon'] }}" class="w-5 h-5 text-white"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-black gradient-text leading-none">{{ $step['step'] }}</div>
                        <div class="text-[9px] font-bold px-2 py-0.5 rounded-full mt-0.5 {{ $step['soft'] }} {{ $step['tc'] }}">{{ $step['time'] }}</div>
                    </div>
                </div>
                <h3 class="font-extrabold text-slate-800 text-sm mb-1">{{ $step['title'] }}</h3>
                <p class="text-[11px] text-slate-400 leading-relaxed">{{ $step['desc'] }}</p>
                @if($i < 3)
                <div class="hidden lg:flex absolute -right-3.5 top-7 z-10 w-7 h-7 bg-white rounded-full border border-slate-100 shadow-sm items-center justify-center">
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                </div>
                @endif
                <div class="absolute bottom-0 left-4 right-4 h-0.5 rounded-full bg-gradient-to-r {{ $step['grad'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── FEATURES ─────────────────────────────────────────────── --}}
<section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-2 slide-up">Powerful Features for Your Business</h2>
        <p class="text-gray-500 mb-10">Discover how QuickDials can transform your business growth</p>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['icon'=>'📍','title'=>'Google Maps Optimization',    'desc'=>'Improve your local visibility by optimizing Google Business Profile with keywords and reviews.'],
                ['icon'=>'🏷️','title'=>'Local Keyword Targeting',     'desc'=>'Rank for city-specific or "near me" search terms to drive local traffic and leads.'],
                ['icon'=>'📞','title'=>'Call & Form Tracking',         'desc'=>'Monitor how many calls and form submissions come from local searches.'],
                ['icon'=>'📄','title'=>'Lead Capture Landing Pages',   'desc'=>'Create location-specific landing pages designed to convert visitors into leads.'],
                ['icon'=>'⭐','title'=>'Review & Reputation Management','desc'=>'Encourage and manage customer reviews to boost credibility and rankings.'],
                ['icon'=>'📊','title'=>'Citation Building & Listings', 'desc'=>'Submit your business info to trusted directories to improve consistency.'],
            ] as $feat)
            <div class="slide-up bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="text-4xl mb-4">{{ $feat['icon'] }}</div>
                <h3 class="font-semibold text-lg mb-2">{{ $feat['title'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $feat['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── GROW SECTION ─────────────────────────────────────────── --}}
<section class="bg-gray-100">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-10 text-center">
        <h2 class="text-2xl md:text-3xl font-bold slide-up">How Quick Dials help You to Grow your Business</h2>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-10">
        <div class="slide-left">
            <h3 class="text-xl font-semibold mb-3">How Quick Dials help You to Grow your Business?</h3>
            <p class="text-gray-600 mb-4">Quick Dials helps grow your business by boosting local visibility, generating quality leads, and connecting you with customers searching for your services.</p>
            <h4 class="font-semibold mb-2">What is Quick Dials?</h4>
            <p class="text-gray-600 mb-4">A platform designed for students, parents, and professionals seeking reliable information across India's diverse education and industrial sectors.</p>
            <ul class="space-y-2">
                @foreach(['Education: Schools, coaching centers, institutions','Manufacturing: Automotive, pharma, textiles','Service Industries: IT, finance, tourism, healthcare','Core Sectors: Electricity, steel, refinery, cement'] as $li)
                <li class="flex items-start gap-2 text-gray-700"><span class="text-blue-600 font-bold">✔</span> {{ $li }}</li>
                @endforeach
            </ul>
            <h4 class="font-semibold mt-6 mb-2">Benefits you will get after associating with us:</h4>
            <ul class="space-y-2">
                @foreach(['Lead replacement policy if not relevant','Refund policy if we fail to deliver','End-to-end support','Leads shared via SMS & Email'] as $li)
                <li class="flex items-start gap-2 text-gray-700"><span class="text-green-600 font-bold">✔</span> {{ $li }}</li>
                @endforeach
            </ul>
        </div>
        <div class="slide-right">
            <h3 class="text-xl font-semibold mb-3">Why choose Quick Dials for growing your business?</h3>
            <ul class="space-y-2 mb-6">
                @foreach(['Unique work module different from others','Conversion-focused system','Manually verified leads','Organic + inorganic lead generation','Strong channel partnerships','Double verified leads by experts'] as $li)
                <li class="flex items-start gap-2 text-gray-700"><span class="text-purple-600 font-bold">✔</span> {{ $li }}</li>
                @endforeach
            </ul>
            <h3 class="text-xl font-semibold mb-2">Contact Us:</h3>
            <p class="text-gray-600">
                📞 +91-75-5943-5943<br>
                📧 info@quickdials.com<br>
                🌐 www.quickdials.com
            </p>
            <a href="#enquiry" class="inline-block mt-5 bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition font-semibold">
                Get Started
            </a>
        </div>
    </div>
</section>

{{-- ── TESTIMONIALS / REVIEWS ───────────────────────────────── --}}
<section class="py-16 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 slide-up">
            <div class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-2">What They Say</div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">Businesses <span class="gradient-text">Love Us</span></h2>
            <p class="text-slate-500 text-sm">Real stories from real business owners across India</p>
        </div>

        @if(!empty($reviewList))
        {{-- Review slider --}}
        <div id="review-slider-wrap" class="relative overflow-hidden px-8">
            <div id="review-track" class="review-track gap-4">
                @foreach(array_chunk($reviewList, 3) as $pageReviews)
                <div class="review-page grid sm:grid-cols-3 gap-4 w-full shrink-0">
                    @foreach($pageReviews as $rev)
                    @php
                        $stars = min(5, max(1, (int) round((float)($rev['rating'] ?? 5) / 2)));
                        $initials = collect(explode(' ', $rev['comment_author'] ?? 'U'))->take(2)->map(fn($w) => strtoupper($w[0] ?? ''))->implode('');
                    @endphp
                    <div class="bg-white rounded-2xl p-5 shadow border hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex justify-between mb-2">
                            <div class="flex text-yellow-400">
                                @for($s=1;$s<=$stars;$s++)★@endfor
                            </div>
                            <span class="text-xs text-blue-600">{{ $rev['client_type'] ?? 'Verified' }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3 italic">"{{ Str::limit($rev['comment_content'] ?? 'Great service!', 100) }}"</p>
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold">{{ $initials }}</div>
                            <div>
                                <div class="text-sm font-semibold">{{ $rev['comment_author'] ?? '' }}</div>
                                <div class="text-xs text-gray-400">{{ $rev['business_name'] ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>

            {{-- Nav arrows --}}
            <button onclick="reviewNav(-1)" class="absolute left-0 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center text-slate-600 hover:text-blue-600 transition-colors z-10">◀</button>
            <button onclick="reviewNav(1)"  class="absolute right-0 top-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center text-slate-600 hover:text-blue-600 transition-colors z-10">▶</button>
        </div>

        {{-- Dots --}}
        <div class="flex justify-center mt-4 gap-2" id="review-dots">
            @foreach(array_chunk($reviewList, 3) as $pi => $p)
            <button onclick="reviewGoTo({{ $pi }})" class="review-dot w-2 h-2 rounded-full {{ $pi === 0 ? 'bg-blue-500' : 'bg-gray-300' }} transition-colors"></button>
            @endforeach
        </div>
        @else
        {{-- Placeholder when no reviews --}}
        <div class="grid sm:grid-cols-3 gap-4">
            @for($i=0;$i<3;$i++)
            <div class="bg-white rounded-2xl p-5 shadow border animate-pulse h-40"></div>
            @endfor
        </div>
        @endif

        {{-- CTA Banner --}}
        <div class="mt-12 relative rounded-3xl overflow-hidden slide-up">
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 p-10 text-center relative">
                <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at 20% 50%,white 0%,transparent 40%),radial-gradient(circle at 80% 50%,white 0%,transparent 40%)"></div>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white mb-3 relative">Ready to Grow Your Business?</h3>
                <p class="text-blue-100 mb-7 relative">Join 8,100+ suppliers already thriving on QuickDials</p>
                <a href="#enquiry" class="relative inline-flex items-center gap-3 bg-white text-blue-700 font-extrabold px-8 py-4 rounded-2xl shadow-2xl hover:shadow-blue-900/30 hover:-translate-y-1 transition-all text-base">
                    <i data-lucide="building-2" class="w-5 h-5"></i>
                    List Your Business Free
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── FAQ ───────────────────────────────────────────────────── --}}
<section class="py-20 relative overflow-hidden" style="background:linear-gradient(160deg,#f8faff 0%,#f0f4ff 45%,#f5f0ff 100%);">
    <div class="absolute inset-0 pointer-events-none opacity-35" style="background-image:linear-gradient(#c7d7f8 1px,transparent 1px),linear-gradient(90deg,#c7d7f8 1px,transparent 1px);background-size:64px 64px;"></div>
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 slide-up">
            <div class="inline-flex items-center gap-2 border rounded-full px-4 py-1.5 mb-5 bg-blue-50/50 border-blue-200/50">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 pulse-dot"></span>
                <span class="text-blue-600 text-xs font-semibold tracking-widest uppercase">Got Questions?</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">Frequently Asked <span class="gradient-text">Questions</span></h2>
            <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">Everything you need to know about listing your business on QuickDials.</p>
            <div class="flex flex-wrap items-center justify-center gap-8 mt-8">
                @foreach([['v'=>'< 2 hrs','l'=>'Avg. response time'],['v'=>'4.9 ★','l'=>'Support rating'],['v'=>'8,100+','l'=>'Businesses listed']] as $fs)
                <div class="flex items-center gap-2.5">
                    <span class="text-lg font-extrabold text-blue-600">{{ $fs['v'] }}</span>
                    <span class="text-slate-400 text-xs leading-tight">{{ $fs['l'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        @php
        $faqIcons = ['clock','shield','building-2','users','check-circle-2','zap','trending-up'];
        $faqTags  = ['Getting Started','Pricing','Eligibility','Leads','Trust','Dashboard','Comparison'];
        $faqItems = [];
        for ($fi = 1; $fi <= 7; $fi++) {
            $q = $faqBusiness["q{$fi}"] ?? null;
            $a = $faqBusiness["a{$fi}"] ?? null;
            if ($q) $faqItems[] = ['q'=>$q,'a'=>$a,'icon'=>$faqIcons[$fi-1],'tag'=>$faqTags[$fi-1]];
        }
        @endphp

        @if(!empty($faqItems))
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            @foreach($faqItems as $fi => $faq)
            <div class="faq-item relative rounded-2xl border border-slate-200 bg-white/80 hover:border-blue-200 hover:shadow-md transition-all duration-300 overflow-hidden">
                <div class="absolute left-0 inset-y-0 w-0.5 bg-gradient-to-b from-blue-400 to-violet-500 rounded-r-full opacity-0 faq-accent transition-opacity duration-300"></div>
                <button onclick="toggleFaq(this)"
                        class="w-full flex items-center gap-3.5 px-5 py-4 text-left group">
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-blue-50 flex items-center justify-center shrink-0 transition-colors">
                        <i data-lucide="{{ $faq['icon'] }}" class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-400 transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="block text-sm font-semibold text-slate-700 group-hover:text-slate-900 leading-snug">{{ $faq['q'] }}</span>
                        <span class="text-[10px] font-medium text-slate-400 mt-0.5 inline-block">{{ $faq['tag'] }}</span>
                    </div>
                    <div class="w-7 h-7 rounded-full bg-slate-100 group-hover:bg-blue-50 flex items-center justify-center shrink-0 transition-all faq-chevron-wrap">
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 transition-transform duration-280 faq-chevron"></i>
                    </div>
                </button>
                <div class="faq-answer">
                    <div class="px-5 pb-5 pl-16 text-sm text-slate-500 leading-relaxed border-t border-slate-100 pt-3">{{ $faq['a'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-10 flex justify-center slide-up">
            <div class="flex flex-col sm:flex-row items-center gap-5 rounded-2xl px-7 py-5 border bg-white/70 shadow-sm border-indigo-200/30">
                <div class="text-center sm:text-left">
                    <div class="text-slate-800 font-semibold text-sm">Still have questions?</div>
                    <div class="text-slate-400 text-xs mt-0.5">Our team typically responds in under 2 hours</div>
                </div>
                <a href="#enquiry" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl whitespace-nowrap hover:-translate-y-0.5 transition-transform shadow-lg shadow-indigo-200/50">
                    <i data-lucide="message-square" class="w-4 h-4"></i>
                    Talk to us
                </a>
            </div>
        </div>
    </div>
</section>

 

@push('scripts')
<script>
// ─── Intersection Observer: slide-up / slide-left / slide-right ────────────
const io = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.slide-up, .slide-left, .slide-right').forEach(el => io.observe(el));

// Step-line special observer
const lineIO = new IntersectionObserver(([e]) => {
    if (e.isIntersecting) { e.target.classList.add('visible'); lineIO.unobserve(e.target); }
}, { threshold: 0.5 });
const stepLine = document.getElementById('step-line');
if (stepLine) lineIO.observe(stepLine);

// ─── Package selector ──────────────────────────────────────────────────────
function selectPkg(id) {
    document.querySelectorAll('.pkg-btn').forEach(btn => {
        btn.classList.remove('border-blue-500','border-violet-500','border-slate-500','shadow-md','-translate-y-0.5');
        btn.classList.add('border-slate-200');
    });
    const selected = document.getElementById('pkg-' + id);
    const borderMap = { starter:'border-slate-500', growth:'border-blue-500', premium:'border-violet-500' };
    if (selected) {
        selected.classList.remove('border-slate-200');
        selected.classList.add(borderMap[id] || 'border-blue-500', 'shadow-md', '-translate-y-0.5');
    }
    document.getElementById('package_interest').value = id;
}
// Restore selection on validation error
const savedPkg = document.getElementById('package_interest').value;
if (savedPkg) selectPkg(savedPkg);

// ─── Success Story Slider ──────────────────────────────────────────────────
let currentStory = 0;
const slides  = document.querySelectorAll('.success-slide');
const allDots = document.querySelectorAll('.story-dot');
let storyTimer = null;

function goStory(idx) {
    const total = slides.length;
    currentStory = ((idx % total) + total) % total;
    slides.forEach((s, i) => s.classList.toggle('hidden', i !== currentStory));
    allDots.forEach((d, i) => {
        d.classList.toggle('w-4',     i === currentStory);
        d.classList.toggle('h-1.5',  i === currentStory);
        d.classList.toggle('bg-white', i === currentStory);
        d.classList.toggle('w-1.5',  i !== currentStory);
        d.classList.toggle('h-1.5',  true);
        d.classList.toggle('bg-white/30', i !== currentStory);
    });
    resetStoryTimer();
}

function resetStoryTimer() {
    clearInterval(storyTimer);
    storyTimer = setInterval(() => goStory(currentStory + 1), 3800);
}
resetStoryTimer();

document.getElementById('success-slider')?.addEventListener('mouseenter', () => clearInterval(storyTimer));
document.getElementById('success-slider')?.addEventListener('mouseleave', resetStoryTimer);

// ─── FAQ accordion ─────────────────────────────────────────────────────────
function toggleFaq(btn) {
    const item    = btn.closest('.faq-item');
    const answer  = item.querySelector('.faq-answer');
    const chevron = item.querySelector('.faq-chevron');
    const accent  = item.querySelector('.faq-accent');
    const isOpen  = answer.classList.contains('open');

    // Close all
    document.querySelectorAll('.faq-answer.open').forEach(a => {
        a.classList.remove('open');
        const ch = a.closest('.faq-item').querySelector('.faq-chevron');
        const ac = a.closest('.faq-item').querySelector('.faq-accent');
        const it = a.closest('.faq-item');
        if (ch) ch.style.transform = '';
        if (ac) ac.classList.add('opacity-0');
        it.classList.remove('border-blue-200','bg-gradient-to-br','from-blue-50','to-indigo-50','shadow-lg');
        it.classList.add('border-slate-200');
    });

    if (!isOpen) {
        answer.classList.add('open');
        chevron.style.transform = 'rotate(180deg)';
        accent.classList.remove('opacity-0');
        item.classList.add('border-blue-200','shadow-lg');
        item.classList.remove('border-slate-200');
    }
}

// ─── Review Slider ─────────────────────────────────────────────────────────
let reviewPage  = 0;
const reviewPages = document.querySelectorAll('.review-page');
const reviewDots  = document.querySelectorAll('.review-dot');

function reviewGoTo(idx) {
    reviewPage = idx;
    const track = document.getElementById('review-track');
    if (track) track.style.transform = `translateX(-${idx * 100}%)`;
    reviewDots.forEach((d, i) => {
        d.classList.toggle('bg-blue-500', i === idx);
        d.classList.toggle('bg-gray-300', i !== idx);
    });
}

function reviewNav(dir) {
    const total = reviewPages.length;
    reviewGoTo(((reviewPage + dir) % total + total) % total);
}

// Auto-play reviews
let reviewTimer = setInterval(() => reviewNav(1), 4500);
document.getElementById('review-slider-wrap')?.addEventListener('mouseenter', () => clearInterval(reviewTimer));
document.getElementById('review-slider-wrap')?.addEventListener('mouseleave', () => { reviewTimer = setInterval(() => reviewNav(1), 4500); });
</script>
@endpush