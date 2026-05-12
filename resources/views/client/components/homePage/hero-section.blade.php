<section class="relative pt-[108px] md:pt-14 overflow-hidden bg-white border-b border-gray-100">

    {{-- Dot pattern --}}
    <div class="absolute inset-0 pointer-events-none opacity-30 dot-bg"></div>
    {{-- Decorative blobs --}}
    <div class="absolute -top-10 -right-10 w-56 h-56 rounded-full bg-blue-50 pointer-events-none"></div>
    <div class="absolute bottom-0 -left-8 w-48 h-48 rounded-full bg-orange-50/70 pointer-events-none"></div>

    <div class="relative z-10 w-full px-4 md:px-8">
        <div class="pt-5 pb-4">

            {{-- Headline --}}
            <div class="max-w-2xl mx-auto text-center mb-3 overflow-hidden">
                <h1 class="text-[clamp(1rem,3.5vw,1.5rem)] font-black text-gray-900 leading-snug whitespace-nowrap">
                    Search across
                    <span class="text-blue-600">'0.9 Crore+'</span>
                    <span id="rotating-word" class="text-orange-500 inline-block word-animate">Institutes</span>
                    <span class="text-gray-700">&amp; Services</span>
                </h1>
            </div>

            {{-- ─── Search Box ─── --}}
            <div class="max-w-2xl mx-auto">
                <div class="relative" id="hero-search-box">
                    <div class="flex bg-white rounded-xl shadow-lg shadow-gray-200/70 overflow-visible border border-gray-200">

                        {{-- City selector --}}
                        <div id="hero-city-dropdown" class="relative shrink-0">
                            <button
                                id="hero-city-btn"
                                onclick="toggleHeroCity()"
                                class="flex items-center gap-1.5 h-11 px-3 text-sm font-semibold text-blue-700 border-r border-gray-200 hover:bg-blue-50 transition-colors whitespace-nowrap rounded-l-xl"
                            >
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-blue-500"></i>
                                <span id="hero-city-label">Bangalore</span>
                                <i data-lucide="chevron-down" id="hero-city-chevron" class="w-3 h-3 text-gray-400 transition-transform duration-200"></i>
                            </button>

                            {{-- City panel --}}
                            <div id="hero-city-panel" class="hidden absolute top-full left-0 mt-1.5 bg-white rounded-xl shadow-2xl border border-gray-100 z-[70] w-72 overflow-hidden dropdown-enter">
                                <div class="p-2 border-b border-gray-100">
                                    <div class="flex items-center gap-1.5 bg-gray-50 rounded-lg px-2.5 py-1.5 border border-gray-200 focus-within:border-blue-300 focus-within:bg-white transition-colors">
                                        <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                                        <input
                                            id="hero-city-search"
                                            type="text"
                                            placeholder="Search city or area..."
                                            class="flex-1 text-xs bg-transparent outline-none text-gray-700   border-none placeholder:text-gray-400 font-medium"
                                            oninput="filterHeroCities(this.value)"
                                        />
                                        <button id="hero-city-clear" onclick="clearHeroCitySearch()" class="hidden text-gray-300 hover:text-gray-500 text-xs">✕</button>
                                    </div>
                                </div>
                                <div class="max-h-40 overflow-y-auto py-1" id="hero-city-list">
                                    {{-- Populated by JS --}}
                                </div>
                            </div>
                        </div>

                        {{-- Search input --}}
                        <input
                            id="hero-search-input"
                            type="text"
                        autocomplete="off"
                      
                            placeholder="Search businesses, services..."
                            class="flex-1 border-none outline-none h-11 text-sm px-3 rounded-none text-gray-800 bg-transparent placeholder:text-gray-400"
                            oninput="handleHeroSearchInput(this.value)"
                            onkeydown="handleHeroKeydown(event)"
                            onfocus="onHeroSearchFocus()"
                        />

                        {{-- Search button --}}
                        <button
                            onclick="doHeroSearch()"
                            class="rounded-none rounded-r-xl h-11 px-5 text-sm font-bold bg-orange-500 hover:bg-orange-600 text-white border-0 shadow-none flex items-center gap-1.5 shrink-0 transition-colors"
                        >
                            <i data-lucide="search" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Search</span>
                        </button>
                    </div>

                    {{-- Suggestions dropdown --}}
                    <div id="hero-suggestions" class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden dropdown-enter">
                        <div id="hero-suggestions-loading" class="hidden flex items-center gap-2.5 px-4 py-3.5">
                            <div class="w-4 h-4 border-2 border-blue-200 border-t-blue-500 rounded-full animate-spin shrink-0"></div>
                            <span class="text-sm text-gray-400 font-medium">Searching...</span>
                        </div>
                        <ul id="hero-suggestions-list"></ul>
                    </div>
                </div>

                {{-- Trending tags --}}
                <div class="flex flex-wrap items-center gap-1.5 mt-2 justify-center" id="trending-tags">
                    <span class="text-gray-400 text-[11px] font-medium">Trending:</span>
                   
                    
                    @if(!empty($homeData['data']['trending']))
                        @foreach($homeData['data']['trending'] as $tag)
                            <button
                                onclick="redirectSearch('{{ $tag['url'] ?? $tag['title'] }}', heroSelectedCity)"
                                class="text-[11px] bg-gray-100 hover:bg-blue-50 border border-gray-200 hover:border-blue-200 text-gray-500 hover:text-blue-700 px-2.5 py-0.5 rounded-full transition-colors"
                            >{{ $tag['title'] }}</button>
                        @endforeach
                    @else
                        @foreach(['AC Repair','Wedding Planner','Home Loan','Dentist','Pizza Near Me'] as $tag)
                            <button
                                onclick="redirectSearch('{{ Str::slug($tag) }}', heroSelectedCity)"
                                class="text-[11px] bg-gray-100 hover:bg-blue-50 border border-gray-200 hover:border-blue-200 text-gray-500 hover:text-blue-700 px-2.5 py-0.5 rounded-full transition-colors"
                            >{{ $tag }}</button>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- ─── Banner Keyword Slider ─── --}}
        <div class="relative pb-0" id="banner-slider-wrapper"
             onmouseenter="sliderPaused=true" onmouseleave="sliderPaused=false">

            <button id="slider-prev" onclick="goSlider('left')"
                class="absolute left-0 top-1/2 -translate-y-1/2 z-20 w-7 h-7 rounded-full bg-white shadow-md border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary disabled:opacity-0 transition-all -translate-x-3">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
            <button id="slider-next" onclick="goSlider('right')"
                class="absolute right-0 top-1/2 -translate-y-1/2 z-20 w-7 h-7 rounded-full bg-white shadow-md border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary disabled:opacity-0 transition-all translate-x-3">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>

            <div id="slider-track" class="flex slider-track" style="gap:4px">
                @php
                $colorMap = ['bg-blue-600','bg-indigo-600','bg-rose-800','bg-violet-700','bg-teal-600','bg-orange-500','bg-rose-600','bg-amber-600','bg-indigo-600','bg-rose-800','bg-teal-600','bg-amber-600','bg-blue-600','bg-orange-500','bg-violet-700','bg-blue-600'];
                $bannerKeywords = $homeData['data']['bannerKeyword'] ?? [];
                
                @endphp

                @foreach($bannerKeywords as $i => $card)

                @php
                $catUrl = match($card['type'] ?? '') {
                'keyword'    => route('showCity',        $card['url']),
                'child'      => route('child.show',      $card['url']),
                'categories' => route('categories.show', $card['url'])
                };
                @endphp
                    <a href="{{ $catUrl }}"
   title="{{ $card['title'] ?? '' }}"
   class="banner-card relative shrink-0 rounded-t-2xl overflow-hidden cursor-pointer group h-[140px] sm:h-[155px] block {{ $colorMap[$i % count($colorMap)] }}">

    <img
        src="{{ $card['img'] ?? '' }}"
        alt="{{ $card['title'] ?? '' }}"
        loading="lazy"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-50 group-hover:opacity-65 group-hover:scale-105 transition-all duration-500"
    />

    <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-transparent to-transparent"></div>

    <div class="relative z-10 p-3.5 flex flex-col justify-between h-full">
        <div>
            <h3 class="text-white font-black text-sm leading-tight">
                {{ $card['title'] ?? '' }}
            </h3>
            <span class="flex items-center gap-0.5 text-[9px] text-gray-200 mt-0.5">
                <span class="text-yellow-400 text-[10px]">★</span>
                <span class="font-semibold">{{ $card['rating'] ?? '' }}</span>
                <span class="opacity-70">({{ $card['count'] ?? '' }})</span>
            </span>
        </div>

        <div class="flex justify-end">
            <div class="w-5 h-5 rounded-full bg-white/25 flex items-center justify-center group-hover:bg-white/40 transition-colors">
                <i data-lucide="chevron-right" class="w-3 h-3 text-white"></i>
            </div>
        </div>
    </div>

</a>
                @endforeach
            </div>

            <div class="flex justify-center gap-1.5 pt-2 pb-1" id="slider-dots"></div>
        </div>
    </div>
</section>

 
<script>
// ─── Hero rotating words ───────────────────────────────────────────────────
const WORDS = ['Institutes','Doctors','Plumbers','Hotels','Electricians','Lawyers'];
let wordIdx  = 0;
const wordEl = document.getElementById('rotating-word');
setInterval(() => {
    wordIdx = (wordIdx + 1) % WORDS.length;
    wordEl.classList.remove('word-animate');
    void wordEl.offsetWidth; // reflow
    wordEl.textContent = WORDS[wordIdx];
    wordEl.classList.add('word-animate');
}, 2200);

// ─── Hero City ────────────────────────────────────────────────────────────
let heroSelectedCity = 'Bangalore';
// const CITIES = ['Mumbai','Delhi','Bangalore','Hyderabad','Chennai','Pune','Kolkata','Ahmedabad'];

const cityNames = ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai', 'Pune', 'Kolkata', 'Ahmedabad'];

const CITIES = cityNames.map(name => ({
    city: name.toLowerCase(),
    cityDetails: name
}));

function renderHeroCityList(list, q = '') {
    const el = document.getElementById('hero-city-list');
    el.innerHTML = list.map(city => `
        <button onclick="selectHeroCity('${city.city}')"
            class="w-full text-left px-4 py-2 text-xs transition-colors font-medium flex items-center gap-2
                   ${city.city === heroSelectedCity ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'}">
            ${city.city === heroSelectedCity
                ? '<span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>'
                : '<span class="ml-3.5"></span>'}
            ${city.cityDetails}
        </button>`).join('');
}
renderHeroCityList(CITIES);

function toggleHeroCity() {
    const panel   = document.getElementById('hero-city-panel');
    const chevron = document.getElementById('hero-city-chevron');
    const hidden  = panel.classList.contains('hidden');
    panel.classList.toggle('hidden', !hidden);
    chevron.style.transform = hidden ? 'rotate(180deg)' : '';
    if (hidden) { document.getElementById('hero-city-search').focus(); }
}

let heroCityTimeout = null;
function filterHeroCities(q) {
    document.getElementById('hero-city-clear').classList.toggle('hidden', !q);
    clearTimeout(heroCityTimeout);
    if (q.length < 1) { renderHeroCityList(CITIES); return; }
    heroCityTimeout = setTimeout(async () => {
        try {
            const r = await fetch(`https://api.quickdials.com/api/website/getCityList?city=${encodeURIComponent(q)}`);
            const d = await r.json();
            // const m = (d.data ?? []).map(i => i.cityDetails);
            const m = (d.data ?? []).map(i => ({ city: i.city, cityDetails: i.cityDetails }));
       
            renderHeroCityList(m.length ? m : CITIES, q);
        } catch { renderHeroCityList(CITIES.filter(c => c.toLowerCase().includes(q.toLowerCase())), q); }
    }, 250);
}

function clearHeroCitySearch() {
    const input = document.getElementById('hero-city-search');
    input.value = '';
    renderHeroCityList(CITIES);
    document.getElementById('hero-city-clear').classList.add('hidden');
}

function selectHeroCity(city) {
    heroSelectedCity = city;
    document.getElementById('hero-city-label').textContent = city;
    document.getElementById('sticky-city-label').textContent = city;
    document.getElementById('mobile-city-label').textContent = city;
    document.getElementById('hero-city-panel').classList.add('hidden');
    document.getElementById('hero-city-chevron').style.transform = '';
    setTimeout(() => document.getElementById('hero-search-input').focus(), 60);
}

document.addEventListener('mousedown', e => {
    const dd = document.getElementById('hero-city-dropdown');
    if (!dd.contains(e.target)) {
        document.getElementById('hero-city-panel').classList.add('hidden');
        document.getElementById('hero-city-chevron').style.transform = '';
    }
});

// ─── Hero Search Suggestions ───────────────────────────────────────────────
let heroSearchTimeout = null;
let heroSuggestions   = [];
let activeHeroIdx     = -1;

function onHeroSearchFocus() {
    document.getElementById('hero-city-panel').classList.add('hidden');
    if (heroSuggestions.length) document.getElementById('hero-suggestions').classList.remove('hidden');
}

function handleHeroSearchInput(val) {
    clearTimeout(heroSearchTimeout);
    if (val.trim().length < 2) { hideHeroSuggestions(); return; }
    showHeroLoading(true);
    heroSearchTimeout = setTimeout(() => fetchHeroSuggestions(val.trim()), 220);
}

function showHeroLoading(show) {
    document.getElementById('hero-suggestions-loading').classList.toggle('hidden', !show);
    document.getElementById('hero-suggestions').classList.toggle('hidden', !show);
}

async function fetchHeroSuggestions(q) {
    try {
        const r = await fetch(`https://api.quickdials.com/api/website/get-keyword-list?keyword=${encodeURIComponent(q)}`);
        const d = await r.json();
        heroSuggestions = (d.data ?? []).map(i => ({ id: i.slug, label: i.keyword, kind: i.type }));
        renderHeroSuggestions(q);
    } catch { hideHeroSuggestions(); }
}

const kindColors = {
    category: 'bg-blue-50 text-blue-600',
    service:  'bg-orange-50 text-orange-600',
    keyword:  'bg-green-50 text-green-600'
};

function renderHeroSuggestions(q) {
    showHeroLoading(false);
    const list = document.getElementById('hero-suggestions-list');
    const box  = document.getElementById('hero-suggestions');
    if (!heroSuggestions.length) { hideHeroSuggestions(); return; }
    list.innerHTML = heroSuggestions.map((s, idx) => {
        const low = q.toLowerCase(), lbl = s.label;
        const mi  = lbl.toLowerCase().indexOf(low);
        const hl  = mi >= 0
            ? `${lbl.slice(0,mi)}<span class="text-blue-600 font-semibold">${lbl.slice(mi,mi+q.length)}</span>${lbl.slice(mi+q.length)}`
            : lbl;
        const kc = kindColors[s.kind] || 'bg-gray-100 text-gray-500';
        return `<li>
            <button onmouseenter="activeHeroIdx=${idx}" onmousedown="selectHeroSuggestion(${idx})"
                class="w-full flex items-center gap-3 px-4 py-2.5 text-left transition-colors hover:bg-gray-50">
                <svg class="w-3.5 h-3.5 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                <span class="flex-1 text-sm text-gray-700">${hl}</span>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full uppercase tracking-wide ${kc}">${s.kind}</span>
            </button>
        </li>`;
    }).join('');
    box.classList.remove('hidden');
    activeHeroIdx = -1;
}

function hideHeroSuggestions() {
    document.getElementById('hero-suggestions').classList.add('hidden');
    document.getElementById('hero-suggestions-loading').classList.add('hidden');
    heroSuggestions = [];
    activeHeroIdx   = -1;
}

function selectHeroSuggestion(idx) {
    const s = heroSuggestions[idx];
    if (!s) return;
    document.getElementById('hero-search-input').value = s.label;
    hideHeroSuggestions();
    redirectSearch(s.label, heroSelectedCity);
}

function handleHeroKeydown(e) {
    if (e.key === 'ArrowDown') { e.preventDefault(); activeHeroIdx = Math.min(activeHeroIdx+1, heroSuggestions.length-1); }
    else if (e.key === 'ArrowUp')  { e.preventDefault(); activeHeroIdx = Math.max(activeHeroIdx-1, 0); }
    else if (e.key === 'Enter')  { e.preventDefault(); activeHeroIdx >= 0 ? selectHeroSuggestion(activeHeroIdx) : doHeroSearch(); }
    else if (e.key === 'Escape') hideHeroSuggestions();
}

function doHeroSearch() {
    const kw = document.getElementById('hero-search-input').value.trim();
    redirectSearch(kw, heroSelectedCity);
}

document.addEventListener('mousedown', e => {
    const box  = document.getElementById('hero-suggestions');
    const inp  = document.getElementById('hero-search-input');
    if (!box.contains(e.target) && !inp.contains(e.target)) hideHeroSuggestions();
});

// ─── Redirect helper ──────────────────────────────────────────────────────
function redirectSearch(keyword, city) {
    if (!keyword || !city) return;
    const c = city.toLowerCase().replace(/\s+/g, '-');
    const k = keyword.toLowerCase().replace(/\s+/g, '-');
    window.location.href = `/${c}/${k}`;
}

// ─── Banner Slider ─────────────────────────────────────────────────────────
(function() {
    const track     = document.getElementById('slider-track');
    const dotsEl    = document.getElementById('slider-dots');
    const prevBtn   = document.getElementById('slider-prev');
    const nextBtn   = document.getElementById('slider-next');
    if (!track) return;

    let slideIdx     = 0;
    let sliderPaused = false;
    window.sliderPaused = false;

    function getVisibleCount() {
        const w = window.innerWidth;
        return w < 480 ? 4 : w < 768 ? 4 : 5;
    }

    function getCards()    { return track.querySelectorAll('.banner-card'); }
    function getMaxIdx()   { return Math.max(0, getCards().length - getVisibleCount()); }

    function setCardWidths() {
        const vc   = getVisibleCount();
        const gap  = 4;
        const w    = `calc((100% - ${(vc-1)*gap}px) / ${vc})`;
        getCards().forEach(c => c.style.width = w);
    }

    function buildDots() {
        dotsEl.innerHTML = '';
        const max = getMaxIdx();
        for (let i = 0; i <= max; i++) {
            const btn = document.createElement('button');
            btn.className = `rounded-full transition-all duration-300 ${i === slideIdx ? 'w-4 h-1.5 bg-blue-500' : 'w-1.5 h-1.5 bg-gray-300'}`;
            btn.setAttribute('aria-label', `Slide ${i+1}`);
            btn.addEventListener('click', () => goTo(i));
            dotsEl.appendChild(btn);
        }
    }

    function goTo(idx) {
        slideIdx = idx;
        const vc  = getVisibleCount();
        const gap = 4;
        const cardW = (track.clientWidth - (vc-1)*gap) / vc;
        track.scrollTo({ left: idx * (cardW + gap), behavior: 'smooth' });
        buildDots();
        prevBtn.disabled = idx === 0;
        nextBtn.disabled = idx >= getMaxIdx();
    }

    window.goSlider = function(dir) {
        const max = getMaxIdx();
        goTo(dir === 'left' ? Math.max(0, slideIdx-1) : Math.min(max, slideIdx+1));
    };

    setCardWidths();
    buildDots();
    window.addEventListener('resize', () => { setCardWidths(); buildDots(); goTo(Math.min(slideIdx, getMaxIdx())); });

    setInterval(() => {
        if (window.sliderPaused) return;
        const max = getMaxIdx();
        goTo(slideIdx >= max ? 0 : slideIdx + 1);
    }, 1500);

    document.getElementById('banner-slider-wrapper').addEventListener('mouseenter', () => window.sliderPaused = true);
    document.getElementById('banner-slider-wrapper').addEventListener('mouseleave', () => window.sliderPaused = false);
})();




</script>
 