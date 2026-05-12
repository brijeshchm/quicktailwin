{{-- ─────────────────────────────────────────
    COUNTRY FLAGS + CITY TABS
───────────────────────────────────────── --}}
<section class="py-12 bg-white border-t border-gray-100">
    <div class="w-full px-4 md:px-8">
        <h3 class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">We are available in</h3>
 
        <div id="city-tabs-section" class="mb-10 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Tab bar — populated by JS --}}
            <div class="flex overflow-x-auto border-b border-gray-100 bg-gray-50/60 p-4" id="city-tab-bar">
                <div class="text-xs text-gray-400 px-4 py-2">Loading cities...</div>
            </div>
            {{-- Links panel --}}
            <div class="px-5 py-4" id="city-tab-content">
                <p class="text-xs text-gray-400">Loading...</p>
            </div>
        </div>
    </div>
</section>
 
<script> 
 // ─── City Tabs (CountryFlags) ──────────────────────────────────────────────
(async function() {
    const tabBar     = document.getElementById('city-tab-bar');
    const tabContent = document.getElementById('city-tab-content');
    let activeCitySlug = '';
    let allKeywords    = [];
 
    try {
        const res  = await fetch('https://api.quickdials.com/api/website/cityTabsFooter');
        const data = await res.json();
        const cities   = data?.data?.cities   || [];
        const keywords = data?.data?.keywords || [];
        allKeywords    = keywords;
 
        if (!cities.length) { tabBar.innerHTML = '<p class="text-xs text-gray-400 px-4 py-2">No cities available</p>'; return; }
 
        activeCitySlug = cities[0]?.city || '';
 
        // Render tabs
        tabBar.innerHTML = cities.map((city, i) => `
            <button onclick="switchCityTab(${i}, '${city.city}')"
                id="city-tab-${i}"
                class="shrink-0 px-4 py-2.5 text-xs font-semibold whitespace-nowrap transition-colors border-b-2 cursor-pointer
                       ${i === 0 ? 'border-blue-600 text-blue-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-800 hover:bg-white/60'}">
                ${city.city}
            </button>`).join('');
 
        renderCityKeywords(activeCitySlug);
    } catch (e) {
        tabBar.innerHTML   = '<p class="text-xs text-gray-400 px-4 py-2">Failed to load cities</p>';
        tabContent.innerHTML = '<p class="text-xs text-red-400">Connection error</p>';
    }
 
    window.switchCityTab = function(idx, citySlug) {
        activeCitySlug = citySlug;
        // Update active tab styles
        document.querySelectorAll('[id^="city-tab-"]').forEach((btn, i) => {
            const active = i === idx;
            btn.classList.toggle('border-blue-600', active);
            btn.classList.toggle('text-blue-600',   active);
            btn.classList.toggle('bg-white',        active);
            btn.classList.toggle('border-transparent', !active);
            btn.classList.toggle('text-gray-500',   !active);
        });
        renderCityKeywords(activeCitySlug);
    };
 
    function renderCityKeywords(citySlug) {
        if (!allKeywords.length) { tabContent.innerHTML = '<p class="text-xs text-gray-400">No keywords available</p>'; return; }
        const slug = citySlug.toLowerCase().trim();
        tabContent.innerHTML = '<p class="text-xs text-gray-500 leading-relaxed">' +
            allKeywords.map((kw, i) =>
                `<span><a href="/${slug}/${kw.slug}" class="hover:text-blue-600 transition-colors">${kw.keyword}</a>${i < allKeywords.length - 1 ? '<span class="mx-1.5 text-gray-300">|</span>' : ''}</span>`
            ).join('') + '</p>';
    } 

})();
</script>
 