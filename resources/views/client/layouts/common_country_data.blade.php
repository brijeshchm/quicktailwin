<script>
 
const CC_COUNTRIES = [
    {country_id:101, sortname:"IN", country_name:"India",                  phonecode:91},
    {country_id:1,   sortname:"AF", country_name:"Afghanistan",             phonecode:93},
    {country_id:2,   sortname:"AL", country_name:"Albania",                 phonecode:355},
    {country_id:3,   sortname:"DZ", country_name:"Algeria",                 phonecode:213},
    {country_id:10,  sortname:"AR", country_name:"Argentina",               phonecode:54},
    {country_id:11,  sortname:"AM", country_name:"Armenia",                 phonecode:374},
    {country_id:13,  sortname:"AU", country_name:"Australia",               phonecode:61},
    {country_id:14,  sortname:"AT", country_name:"Austria",                 phonecode:43},
    {country_id:15,  sortname:"AZ", country_name:"Azerbaijan",              phonecode:994},
    {country_id:17,  sortname:"BH", country_name:"Bahrain",                 phonecode:973},
    {country_id:18,  sortname:"BD", country_name:"Bangladesh",              phonecode:880},
    {country_id:21,  sortname:"BE", country_name:"Belgium",                 phonecode:32},
    {country_id:25,  sortname:"BT", country_name:"Bhutan",                  phonecode:975},
    {country_id:30,  sortname:"BR", country_name:"Brazil",                  phonecode:55},
    {country_id:32,  sortname:"BN", country_name:"Brunei",                  phonecode:673},
    {country_id:38,  sortname:"CA", country_name:"Canada",                  phonecode:1},
    {country_id:44,  sortname:"CN", country_name:"China",                   phonecode:86},
    {country_id:47,  sortname:"CO", country_name:"Colombia",                phonecode:57},
    {country_id:56,  sortname:"CY", country_name:"Cyprus",                  phonecode:357},
    {country_id:57,  sortname:"CZ", country_name:"Czech Republic",          phonecode:420},
    {country_id:58,  sortname:"DK", country_name:"Denmark",                 phonecode:45},
    {country_id:64,  sortname:"EG", country_name:"Egypt",                   phonecode:20},
    {country_id:74,  sortname:"FI", country_name:"Finland",                 phonecode:358},
    {country_id:75,  sortname:"FR", country_name:"France",                  phonecode:33},
    {country_id:82,  sortname:"DE", country_name:"Germany",                 phonecode:49},
    {country_id:83,  sortname:"GH", country_name:"Ghana",                   phonecode:233},
    {country_id:85,  sortname:"GR", country_name:"Greece",                  phonecode:30},
    {country_id:98,  sortname:"HK", country_name:"Hong Kong",               phonecode:852},
    {country_id:99,  sortname:"HU", country_name:"Hungary",                 phonecode:36},
    {country_id:100, sortname:"IS", country_name:"Iceland",                 phonecode:354},
    {country_id:102, sortname:"ID", country_name:"Indonesia",               phonecode:62},
    {country_id:103, sortname:"IR", country_name:"Iran",                    phonecode:98},
    {country_id:104, sortname:"IQ", country_name:"Iraq",                    phonecode:964},
    {country_id:105, sortname:"IE", country_name:"Ireland",                 phonecode:353},
    {country_id:106, sortname:"IL", country_name:"Israel",                  phonecode:972},
    {country_id:107, sortname:"IT", country_name:"Italy",                   phonecode:39},
    {country_id:109, sortname:"JP", country_name:"Japan",                   phonecode:81},
    {country_id:111, sortname:"JO", country_name:"Jordan",                  phonecode:962},
    {country_id:112, sortname:"KZ", country_name:"Kazakhstan",              phonecode:7},
    {country_id:113, sortname:"KE", country_name:"Kenya",                   phonecode:254},
    {country_id:116, sortname:"KR", country_name:"South Korea",             phonecode:82},
    {country_id:117, sortname:"KW", country_name:"Kuwait",                  phonecode:965},
    {country_id:132, sortname:"MY", country_name:"Malaysia",                phonecode:60},
    {country_id:133, sortname:"MV", country_name:"Maldives",                phonecode:960},
    {country_id:142, sortname:"MX", country_name:"Mexico",                  phonecode:52},
    {country_id:148, sortname:"MA", country_name:"Morocco",                 phonecode:212},
    {country_id:150, sortname:"MM", country_name:"Myanmar",                 phonecode:95},
    {country_id:153, sortname:"NP", country_name:"Nepal",                   phonecode:977},
    {country_id:155, sortname:"NL", country_name:"Netherlands",             phonecode:31},
    {country_id:157, sortname:"NZ", country_name:"New Zealand",             phonecode:64},
    {country_id:160, sortname:"NG", country_name:"Nigeria",                 phonecode:234},
    {country_id:164, sortname:"NO", country_name:"Norway",                  phonecode:47},
    {country_id:165, sortname:"OM", country_name:"Oman",                    phonecode:968},
    {country_id:166, sortname:"PK", country_name:"Pakistan",                phonecode:92},
    {country_id:173, sortname:"PH", country_name:"Philippines",             phonecode:63},
    {country_id:175, sortname:"PL", country_name:"Poland",                  phonecode:48},
    {country_id:176, sortname:"PT", country_name:"Portugal",                phonecode:351},
    {country_id:178, sortname:"QA", country_name:"Qatar",                   phonecode:974},
    {country_id:180, sortname:"RO", country_name:"Romania",                 phonecode:40},
    {country_id:181, sortname:"RU", country_name:"Russia",                  phonecode:7},
    {country_id:191, sortname:"SA", country_name:"Saudi Arabia",            phonecode:966},
    {country_id:196, sortname:"SG", country_name:"Singapore",               phonecode:65},
    {country_id:202, sortname:"ZA", country_name:"South Africa",            phonecode:27},
    {country_id:205, sortname:"ES", country_name:"Spain",                   phonecode:34},
    {country_id:206, sortname:"LK", country_name:"Sri Lanka",               phonecode:94},
    {country_id:211, sortname:"SE", country_name:"Sweden",                  phonecode:46},
    {country_id:212, sortname:"CH", country_name:"Switzerland",             phonecode:41},
    {country_id:214, sortname:"TW", country_name:"Taiwan",                  phonecode:886},
    {country_id:217, sortname:"TH", country_name:"Thailand",                phonecode:66},
    {country_id:223, sortname:"TR", country_name:"Turkey",                  phonecode:90},
    {country_id:229, sortname:"AE", country_name:"United Arab Emirates",    phonecode:971},
    {country_id:230, sortname:"GB", country_name:"United Kingdom",          phonecode:44},
    {country_id:231, sortname:"US", country_name:"United States",           phonecode:1},
    {country_id:238, sortname:"VN", country_name:"Vietnam",                 phonecode:84},
];

// ═══════════════════════════════════════════════════════
// SHARED CITY SEARCH — used by BOTH forms
// ═══════════════════════════════════════════════════════
window.sharedCitySearch = {
    _timer:  null,
    _cache:  {},

    // ── Fetch with cache ──
    async fetch(q, csrfToken) {
        const key = q.toLowerCase().trim();
        if (this._cache[key]) return this._cache[key];
        try {
            const res  = await fetch(`/location/getAjaxCity?q=${encodeURIComponent(q)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken || '',
                }
            });
            const data = await res.json();
            const raw  = Array.isArray(data.data) ? data.data
                       : Array.isArray(data)       ? data
                       : [];

            const mapped = raw.map(item => ({
                id:   item.id   ?? null,
                name: item.cityDetails ?? item.city ?? item.name ?? '',
                slug: item.slug ?? '',
            })).filter(c => c.name);

            this._cache[key] = mapped;
            return mapped;
        } catch {
            return [];
        }
    },

    // ── Debounce helper ──
    debounce(fn, delay = 300) {
        clearTimeout(this._timer);
        this._timer = setTimeout(fn, delay);
    },

    // ── Build a city picker bound to specific DOM elements ──
    // Call this after DOM is ready, passing element IDs
    // onSelect(zone) callback fires when user picks a city
    init(inputId, dropdownId, listId, hiddenId, onSelect) {
        const input    = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        const listEl   = document.getElementById(listId);
        const hidden   = hiddenId ? document.getElementById(hiddenId) : null;

        if (!input || !dropdown || !listEl) return;

        const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

        // Render city list
        const render = (items) => {
            listEl.innerHTML = '';

            if (!items.length) {
                listEl.innerHTML = '<div class="px-3 py-2 text-xs text-gray-400 italic">No cities found</div>';
                dropdown.classList.remove('hidden');
                return;
            }

            items.forEach(zone => {
                const btn = document.createElement('button');
                btn.type      = 'button';
                btn.className = 'w-full text-left px-3 py-2 text-xs hover:bg-indigo-50 hover:text-indigo-700 text-gray-700 flex items-center gap-2 cursor-pointer';
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3 text-gray-400 flex-shrink-0">
                        <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    <span>${zone.name}</span>`;

                btn.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                    input.value = zone.name;
                    if (hidden) hidden.value = zone.id || '';
                    dropdown.classList.add('hidden');
                    if (typeof onSelect === 'function') onSelect(zone);
                });

                listEl.appendChild(btn);
            });

            dropdown.classList.remove('hidden');
        };

        // Input handler
        input.addEventListener('input', () => {
            const q = input.value.trim();
            if (hidden) hidden.value = '';   // reset on new typing

            if (q.length < 2) {
                dropdown.classList.add('hidden');
                return;
            }

            // Show loading state
            listEl.innerHTML = '<div class="px-3 py-2 text-xs text-gray-400 italic flex items-center gap-2"><svg class="animate-spin w-3 h-3" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/></svg> Searching…</div>';
            dropdown.classList.remove('hidden');

            window.sharedCitySearch.debounce(async () => {
                const results = await window.sharedCitySearch.fetch(q, csrf());
                render(results);
            }, 300);
        });

        // Re-show on focus if value present
        input.addEventListener('focus', () => {
            if (input.value.trim().length >= 2) {
                dropdown.classList.remove('hidden');
            }
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!input.parentElement.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }
};

// ═══════════════════════════════════════════════════════
// VANILLA FORM — init city picker after DOM ready
// Uses IDs: ef-city-input, ef-city-dropdown, ef-city-list, ef-city-id
// ═══════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('ef-city-input')) {
        window.sharedCitySearch.init(
            'ef-city-input',
            'ef-city-dropdown',
            'ef-city-list',
            'ef-city-id',
            (zone) => {
                // optional: sync to any hidden field
                const hiddenCityId = document.getElementById('ef-city-id');
                if (hiddenCityId) hiddenCityId.value = zone.id || '';
            }
        );
    }



     if (document.getElementById('side-city-input')) {
        window.sharedCitySearch.init(
            'side-city-input',
            'side-city-dropdown',
            'side-city-list',
            'side-city-id',
            (zone) => {
                // optional: sync to any hidden field
                const hiddenCityId = document.getElementById('side-city-id');
                if (hiddenCityId) hiddenCityId.value = zone.id || '';
            }
        );
    }


});



// ── Reusable phone keydown handler ──────────────────
window.phoneKeydown = function(e, onEnter) {
    const v = e.target.value;
    const k = e.keyCode;

    if (v.length !== 0 && k === 13) { if (onEnter) onEnter(); return; }
    if (v.length === 0 && k === 13) { e.preventDefault(); return; }
    if (v.length === 0 && (k === 48 || k === 96)) { e.preventDefault(); return; }
    if ([46, 8, 9, 27, 13, 110, 190].includes(k)) return;
    if ([65, 86, 67].includes(k) && (e.ctrlKey || e.metaKey)) return;
    if (k >= 35 && k <= 40) return;
    if ((e.shiftKey || k < 48 || k > 57) && (k < 96 || k > 105)) {
        e.preventDefault();
    }
};


document.addEventListener('keydown', function(e) {
    const input = e.target;
    if (!input.matches('input[name="phone"]')) return;

    const val = input.value;

    // Enter with value → verify
    if (val.length !== 0 && e.keyCode === 13) {
        verifyDemo();
        return;
    }

    // Enter with empty → block
    if (val.length === 0 && e.keyCode === 13) {
        e.preventDefault();
        return;
    }

    // Block 0 as first character
    if (val.length === 0 && (e.keyCode === 48 || e.keyCode === 96)) {
        e.preventDefault();
        return;
    }

    // Allow: delete, backspace, tab, escape, enter, decimal, period
    if ([46, 8, 9, 27, 13, 110, 190].includes(e.keyCode)) return;

    // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Cmd+A, Cmd+C, Cmd+V
    if ([65, 86, 67].includes(e.keyCode) && (e.ctrlKey || e.metaKey)) return;

    // Allow: home, end, left, right, down, up
    if (e.keyCode >= 35 && e.keyCode <= 40) return;

    // Block anything that's not a number (0-9 on keyboard or numpad)
    if ((e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
</script>