{{-- resources/views/layouts/navbar.blade.php --}}

<header
    id="main-navbar"
    class="fixed top-0 w-full z-50 transition-all duration-300 h-20 md:h-16 bg-transparent"
>
    {{-- ─── Main bar ─── --}}
    <div class="w-full px-4 md:px-6 h-14 flex items-center justify-between gap-3">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center shrink-0">
            <img
                src="{{ asset('client/images/small-logo.png') }}"
                alt="QuickDials"
                class="h-12 w-auto sm:h-10 md:h-12 lg:h-14 object-contain"
                onerror="this.onerror=null;this.src='client/images/small-logo.png';"
            />
        </a>

        {{-- Sticky search bar (hidden until user scrolls) --}}
        <div
            id="sticky-search-wrapper"
            class="flex-1 max-w-xl relative hidden md:block opacity-0 pointer-events-none transition-all duration-200"
            style="transform-origin: left center;"
        >
            <div class="flex bg-white rounded-xl border border-gray-200 shadow-md h-9 overflow-visible">

                {{-- City selector --}}
                <div id="sticky-city-dropdown" class="relative shrink-0">
                    <button
                        id="sticky-city-btn"
                        class="flex items-center gap-1 h-9 px-2.5 text-xs font-semibold text-blue-700 border-r border-gray-200 hover:bg-blue-50 transition-colors whitespace-nowrap rounded-l-xl"
                        onclick="toggleStickyCity()"
                    >
                        <i data-lucide="map-pin" class="w-3 h-3 text-blue-500"></i>
                        <span id="sticky-city-label">Bangalore</span>
                        <i data-lucide="chevron-down" class="w-2.5 h-2.5 text-gray-400 transition-transform duration-200" id="sticky-city-chevron"></i>
                    </button>

                    {{-- City dropdown panel --}}
                    <div
                        id="sticky-city-panel"
                        class="hidden absolute top-full left-0 mt-1.5 bg-white rounded-xl shadow-2xl border border-gray-100 z-[70] w-52 overflow-hidden dropdown-enter"
                    >
                        <div class="p-2 border-b border-gray-100">
                            <div class="flex items-center gap-1.5 bg-gray-50 rounded-lg px-2.5 py-1.5 border border-gray-200 focus-within:border-blue-300 focus-within:bg-white transition-colors">
                                <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                                <input
                                    id="sticky-city-search"
                                    type="text"
                                    placeholder="Search city..."
                                    class="flex-1 text-xs bg-transparent outline-none text-gray-700 placeholder:text-gray-400 font-medium"
                                    oninput="filterStickyCities(this.value)"
                                />
                                <button onclick="clearStickyCitySearch()" class="text-gray-300 hover:text-gray-500 text-xs hidden" id="sticky-city-clear">✕</button>
                            </div>
                        </div>
                        <div class="max-h-48 overflow-y-auto py-1" id="sticky-city-list">
                            @foreach(['Mumbai','Delhi','Bangalore','Hyderabad','Chennai','Pune','Kolkata','Ahmedabad'] as $city)
                                <button
                                    onclick="selectStickyCity('{{ $city }}')"
                                    class="w-full text-left px-4 py-2 text-xs transition-colors font-medium flex items-center gap-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700"
                                    data-city="{{ $city }}"
                                >
                                    <span class="ml-3.5">{{ $city }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Search input --}}
                <input
                    id="sticky-search-input"
                    type="text"
                    autocomplete="off"
                    autocorrect="off"
                    autocapitalize="off"
                    spellcheck="false"
                    placeholder="Search businesses, services..."
                    class="flex-1 text-xs px-2.5  border-gray-100 outline-none bg-transparent text-gray-800 placeholder:text-gray-400 hover:border-gray-300"
                    oninput="handleStickySearchInput(this.value)"
                    onkeydown="handleStickyKeydown(event)"
                />

                {{-- Search button --}}
                <button
                    onclick="doStickySearch()"
                    class="shrink-0 bg-orange-500 hover:bg-orange-600 text-white h-9 px-3.5 rounded-r-xl flex items-center gap-1.5 text-xs font-bold transition-colors"
                >
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                    Search
                </button>
            </div>

            {{-- Suggestions dropdown --}}
            <div
                id="sticky-suggestions"
                class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden dropdown-enter"
            >
                <ul id="sticky-suggestions-list"></ul>
            </div>
        </div>

        {{-- Desktop nav links --}}
        <nav id="desktop-nav" class="hidden md:flex items-center gap-6 shrink-0 transition-all duration-200">
            <a href="{{ route('home') }}" class="text-xs font-medium text-gray-900 hover:text-primary transition-colors">Home</a>
            <a href="{{ route('category.list') }}" class="text-xs font-medium text-gray-600 hover:text-primary transition-colors">Categories</a>
            <a href="{{ route('business.services') }}" class="text-xs font-medium text-gray-600 hover:text-primary transition-colors">Businesses</a>
        </nav>

        {{-- Desktop action buttons --}}
        <div class="hidden md:flex items-center gap-3 shrink-0">
 
            <button
                onclick="openLoginModal()"
                class="flex items-center gap-1.5 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold rounded-md shadow transition-colors"
            >
                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                Login / Register
            </button>

            <span class="relative inline-flex">
                <span class="pulse-ring absolute inset-0 rounded-full"></span>
                <a
                    href="{{ route('login') }}"
                    class="relative flex items-center gap-1.5 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white text-xs font-bold px-4 h-8 rounded-full shadow-lg transition-all"
                >
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                    Free Listing
                </a>
            </span>
        </div>

        {{-- Mobile buttons --}}
        <div class="md:hidden flex items-center gap-1.5">
            <button onclick="openLoginModal()" class="flex items-center gap-1 text-xs h-7 px-2 font-medium text-gray-700 hover:text-primary border border-gray-200 rounded-md transition-colors">
                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                Login
            </button>
            <span class="relative inline-flex">
                <span class="pulse-ring absolute inset-0 rounded-full"></span>
                <a href="{{ route('login') }}" class="relative flex items-center gap-1 bg-gradient-to-r from-orange-500 to-orange-400 text-white text-xs font-bold px-2 h-7 rounded-full">
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                    Free
                </a>
            </span>
            <button
                id="mobile-menu-btn"
                class="p-1.5 text-gray-700 hover:text-primary transition-colors"
                onclick="toggleMobileMenu()"
                aria-label="Toggle menu"
            >
                <i data-lucide="menu" class="w-5 h-5" id="menu-icon-open"></i>
                <i data-lucide="x" class="w-5 h-5 hidden" id="menu-icon-close"></i>
            </button>
        </div>
    </div>

    {{-- Mobile search bar (always visible on mobile) --}}
    <div class="md:hidden border-t border-gray-100 bg-white/95 backdrop-blur-md">
        <div class="px-3 py-2">
            <div class="flex bg-white rounded-xl border border-gray-200 shadow-md h-9 overflow-hidden">
                <div class="flex items-center gap-1 h-9 px-2.5 text-xs font-semibold text-blue-700 border-r border-gray-200 whitespace-nowrap">
                    <i data-lucide="map-pin" class="w-3 h-3 text-blue-500"></i>
                    <span id="mobile-city-label">Bangalore</span>
                </div>
                <input
                    type="text"
                    placeholder="Search businesses, services..."
                    class="flex-1 text-xs px-2.5 outline-none border-gray-100 bg-transparent text-gray-800 placeholder:text-gray-400 hover:border-gray-300"
                    id="mobile-search-input"
                    onkeydown="if(event.key==='Enter') doMobileSearch()"
                />
                <button onclick="doMobileSearch()" class="shrink-0 bg-orange-500 hover:bg-orange-600 text-white h-9 px-3 rounded-r-xl flex items-center transition-colors">
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu dropdown --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-4 pb-4 shadow-lg">
        <nav class="flex flex-col gap-0.5 pt-2 mb-3">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-900 hover:text-primary px-2 py-2.5 rounded-lg hover:bg-blue-50 transition-colors">Home</a>
            <a href="{{ route('category.list') }}" class="text-sm font-medium text-gray-600 hover:text-primary px-2 py-2.5 rounded-lg hover:bg-blue-50 transition-colors">Categories</a>
            <a href="{{ route('business.services') }}" class="text-sm font-medium text-gray-600 hover:text-primary px-2 py-2.5 rounded-lg hover:bg-blue-50 transition-colors">Businesses</a>
        </nav>
        <div class="flex flex-col gap-2 border-t border-gray-100 pt-3">
            <button onclick="openLoginModal()" class="w-full flex items-center justify-center gap-2 text-sm h-9 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                <i data-lucide="user" class="w-4 h-4"></i>
                Login / Register
            </button>
            <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-orange-400 text-white text-sm h-9 rounded-full font-bold">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Free Listing
            </a>
        </div>
    </div>
    

</header>

@include('client.layouts.login_popup')
 
<div id="login-modalss" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 relative">
        <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="text-center mb-6">
            <img src="{{ asset('client/images/small-logo.png') }}" alt="QuickDials" class="h-10 mx-auto mb-3 object-contain" onerror="this.style.display='none'">
            <h2 class="text-lg font-black text-gray-900">Welcome Back</h2>
            <p class="text-sm text-gray-500 mt-1">Sign in to your QuickDials account</p>
        </div>
        <button
            onclick="handleGoogleLogin()"
            class="w-full flex items-center justify-center gap-3 border-2 border-gray-200 hover:border-gray-300 rounded-xl py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all mb-4"
        >
            <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            Continue with Google
        </button>
        <div class="flex items-center gap-3 mb-4">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400 font-medium">or</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>
        

        <form action="/client-login" autocomplete="on" id="login-form" 
      class="max-w-md mx-auto bg-white p-6 rounded-2xl shadow-lg text-center space-y-5">
        <input
            type="email"
            id="login-email"
            name="email"
            placeholder="Enter your email"
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-50 transition-all mb-3"
        />
        <button
            onclick="handleEmailLogin()"
            class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-2.5 rounded-xl text-sm transition-colors"
        >
            Continue with Email
        </button>
</form>

    </div>
</div>

<script>
// ─── Navbar scroll behavior ────────────────────────────────────────────────
const navbar      = document.getElementById('main-navbar');
const stickyWrap  = document.getElementById('sticky-search-wrapper');
const desktopNav  = document.getElementById('desktop-nav');

window.addEventListener('scroll', () => {
    const y = window.scrollY;
    const scrolled = y > 20;
    const showSearch = y > 200;

    navbar.classList.toggle('bg-white/95', scrolled || false);
    navbar.classList.toggle('backdrop-blur-md', scrolled);
    navbar.classList.toggle('shadow-sm', scrolled);
    navbar.classList.toggle('border-b', scrolled);
    navbar.classList.toggle('border-gray-100', scrolled);
    navbar.classList.toggle('bg-transparent', !scrolled);

    if (showSearch) {
        stickyWrap.classList.remove('opacity-0', 'pointer-events-none');
        stickyWrap.classList.add('opacity-100');
        desktopNav.classList.add('opacity-0', 'overflow-hidden', 'pointer-events-none', 'w-0');
    } else {
        stickyWrap.classList.add('opacity-0', 'pointer-events-none');
        stickyWrap.classList.remove('opacity-100');
        desktopNav.classList.remove('opacity-0', 'overflow-hidden', 'pointer-events-none', 'w-0');
    }
}, { passive: true });

// ─── Sticky City Dropdown ──────────────────────────────────────────────────
let stickySelectedCity = 'Bangalore';
 

const cityStickyNames = ['Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai', 'Pune', 'Kolkata', 'Ahmedabad'];

const FALLBACK_CITIES = cityStickyNames.map(name => ({
    city: name.toLowerCase(),
    cityDetails: name
}));


function toggleStickyCity() {
    const panel   = document.getElementById('sticky-city-panel');
    const chevron = document.getElementById('sticky-city-chevron');
    const isHidden = panel.classList.contains('hidden');
    panel.classList.toggle('hidden', !isHidden);
    chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
}

function renderStickyCityList(list, q = '') {
     const clearBtn = document.getElementById('sticky-city-clear');
    clearBtn.classList.toggle('hidden', !q);
    const el = document.getElementById('sticky-city-list');
    el.innerHTML = list.map(city => `
        <button onclick="selectStickyCity('${city.city}')"
            class="w-full text-left px-4 py-2 text-xs transition-colors font-medium flex items-center gap-2
                   ${city.city === stickySelectedCity ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'}">
            ${city.city === stickySelectedCity
                ? '<span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>'
                : '<span class="ml-3.5"></span>'}
            ${city.cityDetails}
        </button>`).join('');
}


renderStickyCityList(FALLBACK_CITIES);
let stickyCityTimeout = null;
function filterStickyCities(q) {
    document.getElementById('sticky-city-clear').classList.toggle('hidden', !q);
    clearTimeout(stickyCityTimeout);
    if (q.length < 1) { renderStickyCityList(FALLBACK_CITIES); return; }
    stickyCityTimeout = setTimeout(async () => {
        try {
            const r = await fetch(`https://api.quickdials.com/api/website/getCityList?city=${encodeURIComponent(q)}`);
            const d = await r.json();
            // const m = (d.data ?? []).map(i => i.cityDetails);
            const m = (d.data ?? []).map(i => ({ city: i.city, cityDetails: i.cityDetails }));
       
            renderStickyCityList(m.length ? m : CITIES, q);
        } catch { renderStickyCityList(CITIES.filter(c => c.toLowerCase().includes(q.toLowerCase())), q); }
    }, 250);
}

function clearStickyCitySearch() {
    const input = document.getElementById('sticky-city-search');
    input.value = '';
    filterStickyCities('');
}

function selectStickyCity(city) {
    stickySelectedCity = city;
    document.getElementById('sticky-city-label').textContent = city;
    document.getElementById('mobile-city-label').textContent = city;
    document.getElementById('sticky-city-panel').classList.add('hidden');
    document.getElementById('sticky-city-chevron').style.transform = '';
    document.getElementById('sticky-search-input').focus();
}

document.addEventListener('mousedown', (e) => {
    const dropdown = document.getElementById('sticky-city-dropdown');
    if (!dropdown.contains(e.target)) {
        document.getElementById('sticky-city-panel').classList.add('hidden');
        document.getElementById('sticky-city-chevron').style.transform = '';
    }
});

// ─── Sticky Search + Suggestions ──────────────────────────────────────────
let stickySearchTimeout = null;
let stickySuggestions   = [];
let activeStickyIdx     = -1;

function handleStickySearchInput(val) {
    clearTimeout(stickySearchTimeout);
    if (val.trim().length < 2) {
        hideStickysuggestions();
        return;
    }
    stickySearchTimeout = setTimeout(() => fetchStickySuggestions(val.trim()), 220);
}

async function fetchStickySuggestions(q) {
    try {
        const res  = await fetch(`https://api.quickdials.com/api/website/get-keyword-list?keyword=${encodeURIComponent(q)}`);
        const data = await res.json();
        stickySuggestions = (data.data ?? []).map(i => ({ id: i.slug, label: i.keyword, kind: i.type }));
        renderStickySuggestions(q);
    } catch { hideStickysuggestions(); }
}

function renderStickySuggestions(q) {
    const list = document.getElementById('sticky-suggestions-list');
    const box  = document.getElementById('sticky-suggestions');
    if (!stickySuggestions.length) { hideStickysuggestions(); return; }
    const kindColors = { category: 'bg-blue-50 text-blue-600', service: 'bg-orange-50 text-orange-600', keyword: 'bg-green-50 text-green-600' };
    list.innerHTML = stickySuggestions.map((s, idx) => {
        const low = q.toLowerCase();
        const lbl = s.label;
        const mi  = lbl.toLowerCase().indexOf(low);
        const hl  = mi >= 0
            ? `${lbl.slice(0,mi)}<span class="text-blue-600 font-semibold">${lbl.slice(mi,mi+q.length)}</span>${lbl.slice(mi+q.length)}`
            : lbl;
        const kc = kindColors[s.kind] || 'bg-gray-100 text-gray-500';
        return `<li>
            <button onmouseenter="activeStickyIdx=${idx}" onmousedown="selectStickySuggestion(${idx})"
                class="w-full flex items-center gap-3 px-4 py-2.5 text-left transition-colors hover:bg-gray-50">
                <svg class="w-3.5 h-3.5 text-gray-300 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                <span class="flex-1 text-sm text-gray-700">${hl}</span>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full uppercase tracking-wide ${kc}">${s.kind}</span>
            </button>
        </li>`;
    }).join('');
    box.classList.remove('hidden');
    activeStickyIdx = -1;
}

function hideStickysuggestions() {
    document.getElementById('sticky-suggestions').classList.add('hidden');
    stickySuggestions = [];
    activeStickyIdx   = -1;
}

function selectStickySuggestion(idx) {
    const s = stickySuggestions[idx];
    if (!s) return;
    document.getElementById('sticky-search-input').value = s.label;
    hideStickysuggestions();
    redirectSearch(s.label, stickySelectedCity);
}

function handleStickyKeydown(e) {
    if (e.key === 'ArrowDown') { e.preventDefault(); activeStickyIdx = Math.min(activeStickyIdx+1, stickySuggestions.length-1); }
    else if (e.key === 'ArrowUp')  { e.preventDefault(); activeStickyIdx = Math.max(activeStickyIdx-1, 0); }
    else if (e.key === 'Enter')  { e.preventDefault(); activeStickyIdx >= 0 ? selectStickySuggestion(activeStickyIdx) : doStickySearch(); }
    else if (e.key === 'Escape') hideStickysuggestions();
}

function doStickySearch() {
    const kw = document.getElementById('sticky-search-input').value.trim();
    redirectSearch(kw, stickySelectedCity);
}

function doMobileSearch() {
    const kw = document.getElementById('mobile-search-input').value.trim();
    redirectSearch(kw, stickySelectedCity);
}

function redirectSearch(keyword, city) {
    if (!keyword || !city) return;
    const c = city.toLowerCase().replace(/\s+/g, '-');
    const k = keyword.toLowerCase().replace(/\s+/g, '-');
    window.location.href = `/${c}/${k}`;
}

// ─── Mobile Menu ───────────────────────────────────────────────────────────
function toggleMobileMenu() {
    const menu      = document.getElementById('mobile-menu');
    const iconOpen  = document.getElementById('menu-icon-open');
    const iconClose = document.getElementById('menu-icon-close');
    const isHidden  = menu.classList.contains('hidden');
    menu.classList.toggle('hidden', !isHidden);
    iconOpen.classList.toggle('hidden', isHidden);
    iconClose.classList.toggle('hidden', !isHidden);
}
 
</script>
