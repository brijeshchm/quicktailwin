 
@props(['mode' => 'vanilla', 'label' => 'Location', 'required' => false])

<div>
    <label class="text-xs font-semibold text-gray-500 mb-1 block">
        {{ $label }}{{ $required ? ' *' : '' }}
    </label>
    <div class="relative">

        {{-- Pin icon --}}
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none z-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
            </svg>
        </span>

        @if($mode === 'alpine')
               <input type="text"
                   id="side-city-input"
                   name="location"
                   placeholder="Search city or pincode…"
                   autocomplete="off"
                   class="ef-input pl-9 w-full">
                <input type="hidden" id="side-city-id" name="location_id">

            {{-- Vanilla dropdown --}}
            <div id="side-city-dropdown"
                 class="hidden absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-xl max-h-48 overflow-y-auto">
                <div id="side-city-list"></div>
            </div>

            <p id="err-location" class="text-xs text-red-500 mt-1 hidden"></p>
        @else
            {{-- ── VANILLA MODE ── --}}
            <input type="text"
                   id="ef-city-input"
                   name="location"
                   placeholder="Search city or pincode…"
                   autocomplete="off"
                   class="ef-input pl-9 w-full">
            <input type="hidden" id="ef-city-id" name="location_id">

            {{-- Vanilla dropdown --}}
            <div id="ef-city-dropdown"
                 class="hidden absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-xl max-h-48 overflow-y-auto">
                <div id="ef-city-list"></div>
            </div>

            <p id="err-location" class="text-xs text-red-500 mt-1 hidden"></p>
        @endif

    </div>
</div>