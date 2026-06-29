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
                loading="lazy" decoding="async"
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
                                 <i data-lucide="map-pin" class="w-3 h-3 text-blue-500"></i>
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
           


<a href="https://play.google.com/store/apps/details?id=com.quick_dial&hl=en_IN"
   target="_blank"
   class="group inline-flex items-center justify-center w-24 h-36 hover:bg-EB2C3B-700 from-green-500 to-emerald-600  transition-all duration-300">

    <img 
    src="{{ asset('play-store-android.png') }}" 
      alt="Download Quickdials app on Google Play Store"
    class="h-14 w-auto sm:h-16 md:h-20 lg:h-24 xl:h-28 2xl:h-32 object-contain"
     loading="lazy"
     decoding="async" />
     
</a>
    		 
			@if (!Auth::guard('clients')->check() && !Auth::guard('guest')->check())
            <button
                onclick="openLoginModal()"
                aria-label="Login or Register"
                class="flex items-center gap-1.5 px-4 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold rounded-md shadow transition-colors"
            >
                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                Login / Register
            </button>

             <span class="relative inline-flex">
                <span class="pulse-ring absolute inset-0 rounded-full"></span>
                <a
                    href="{{ route('login') }}"
                    class="relative flex items-center gap-1.5 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white text-xs font-bold px-4 h-10 rounded-full shadow-lg transition-all"
                >
                     
                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                    Business
                    Free Listing
                </a>

                <!-- Android App Download Button -->

            </span>
@elseif(auth()->guard('clients')->user())


 @php
    $client     = auth()->guard('clients')->user();
    $businessName = $client->business_name ?? 'Account';

    // Profile logo with fallback
    $profileImg = asset('client/images/user.png');
    if (!empty($client->logo)) {
        $logo = @unserialize($client->logo);
        if (!empty($logo['large']['src'])) {
            $profileImg = asset($logo['large']['src']);
        }
    }

    // Active route helper for highlighting current page in dropdown
    $currentUrl = url()->current();
@endphp
<?php 
$guests = DB::table('guests')->where('email',$client->email)->first();
if(!empty($guests)){
?>
     <a href="{{ route('user.dashboard') }}"
       class="flex items-center gap-1.5 px-4 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold rounded-md shadow transition-colors">
        
        <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
        Your Profile

    </a>
    <?php  } ?>
<div class="head-right-lout relative" x-data="{ open: false }" @keydown.escape.window="open = false">

    {{-- ════════════ PROFILE TRIGGER ════════════ --}}
    <button @click="open = !open"
            @click.outside="open = false"
            class="flex items-center gap-2 px-2 py-1.5 rounded-full hover:bg-gray-100 transition-all duration-200 group"
            aria-haspopup="true"
            :aria-expanded="open">

        {{-- Avatar --}}
        <div class="relative shrink-0">
            <img loading="lazy"
                 src="{{ $profileImg }}"
                 alt="{{ $businessName }}"
                 loading="lazy" decoding="async"
                 class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm">

            {{-- Online indicator --}}
            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
        </div>

        {{-- Name (hidden on mobile) --}}
        <span class="hidden md:block text-sm font-semibold text-gray-700 group-hover:text-gray-900 max-w-[140px] truncate">
            {{ ucfirst($businessName) }}
        </span>

        {{-- Chevron --}}
        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200"
             :class="open ? 'rotate-180' : ''"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- ════════════ DROPDOWN MENU ════════════ --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl shadow-gray-900/10 border border-gray-100 overflow-hidden z-50"
         style="display: none;">

        {{-- Header: profile info --}}
        <div class="px-4 py-3.5 bg-gradient-to-br from-indigo-50 to-blue-50 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <img src="{{ $profileImg }}"
                     loading="lazy" decoding="async"
                     alt="{{ $businessName }}"
                     class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-md shrink-0">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ ucfirst($businessName) }}</p>
                    @if(!empty($client->email))
                        <p class="text-xs text-gray-500 truncate">{{ $client->email }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Menu items --}}
        @php
            $menuItems = [
                ['url' => 'business/personal-details',  'icon' => 'user',     'label' => 'My Profile'],
                ['url' => 'business/account-settings',  'icon' => 'gear',     'label' => 'Account Settings'],
                ['url' => 'business/favorite-enquiry',  'icon' => 'star',     'label' => 'Favorite Enquiry'],
                ['url' => 'business/manage-enquiry',    'icon' => 'envelope', 'label' => 'Manage Enquiry'],
                ['url' => 'business/keywords',          'icon' => 'book',     'label' => 'Service Keywords'],
                ['url' => 'business/package',           'icon' => 'package',  'label' => 'Package',         'badge' => 'New'],
                ['url' => 'business/billing-history',   'icon' => 'wallet',   'label' => 'My Transactions'],
            ];
        @endphp

        <div class="py-1.5">
            @foreach($menuItems as $item)
                @php $isActive = $currentUrl === url($item['url']); @endphp
                <a href="{{ url($item['url']) }}"
                   class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors
                          {{ $isActive
                                ? 'bg-indigo-50 text-indigo-700 font-semibold'
                                : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">

                    {{-- Icon --}}
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg shrink-0
                                 {{ $isActive ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500' }}">
                        @switch($item['icon'])
                            @case('user')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                @break
                            @case('gear')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                @break
                            @case('star')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                @break
                            @case('envelope')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                @break
                            @case('book')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                @break
                            @case('package')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                @break
                            @case('wallet')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                @break
                        @endswitch
                    </span>

                    <span class="flex-1">{{ $item['label'] }}</span>

                    {{-- Optional badge --}}
                    @if(!empty($item['badge']))
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-700">
                            {{ $item['badge'] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Logout (separated) --}}
        <div class="border-t border-gray-100 py-1.5 bg-gray-50/50">
            <a href="{{ url('client/logout') }}"
               
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <span class="flex-1 font-semibold">Logout</span>
            </a>
        </div>

    </div>
</div>




@else
 
 @php
    $client     = auth()->guard('guest')->user();
    $businessName = $client->business_name ?? 'Account';

    // Profile logo with fallback
    $profileImg = asset('client/images/user.png');
    if (!empty($client->logo)) {
        $logo = @unserialize($client->logo);
        if (!empty($logo['large']['src'])) {
            $profileImg = asset($logo['large']['src']);
        }
    }

    // Active route helper for highlighting current page in dropdown
    $currentUrl = url()->current();
@endphp

<?php 
$clientcheck = DB::table('clients')->where('email',$client->email)->first();
if(!empty($clientcheck)){
?>
 <a href="{{ route('client.dashboard') }}"
       class="flex items-center gap-1.5 px-4 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold rounded-md shadow transition-colors">
        
        <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
        Your Business
    </a>

    <?php  } ?>
<div class="head-right-lout relative" x-data="{ open: false }" @keydown.escape.window="open = false">

    {{-- ════════════ PROFILE TRIGGER ════════════ --}}
    <button @click="open = !open"
            @click.outside="open = false"
            class="flex items-center gap-2 px-2 py-1.5 rounded-full hover:bg-gray-100 transition-all duration-200 group"
            aria-haspopup="true"
            :aria-expanded="open">

        {{-- Avatar --}}
        <div class="relative shrink-0">
            <img loading="lazy"
                 src="{{ $profileImg }}"
                 alt="{{ $businessName }}"
                 loading="lazy" decoding="async"
                 class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm">

            {{-- Online indicator --}}
            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
        </div>

        {{-- Name (hidden on mobile) --}}
        <span class="hidden md:block text-sm font-semibold text-gray-700 group-hover:text-gray-900 max-w-[140px] truncate">
            {{ ucfirst($businessName) }}
        </span>

        {{-- Chevron --}}
        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200"
             :class="open ? 'rotate-180' : ''"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- ════════════ DROPDOWN MENU ════════════ --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
         class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl shadow-gray-900/10 border border-gray-100 overflow-hidden z-50"
         style="display: none;">

        {{-- Header: profile info --}}
        <div class="px-4 py-3.5 bg-gradient-to-br from-indigo-50 to-blue-50 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <img src="{{ $profileImg }}"
                     loading="lazy" decoding="async"
                     alt="{{ $businessName }}"
                     class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-md shrink-0">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ ucfirst($businessName) }}</p>
                    @if(!empty($client->email))
                        <p class="text-xs text-gray-500 truncate">{{ $client->email }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Menu items --}}
        @php
            $menuItems = [
                ['url' => 'user/personal-details',  'icon' => 'user',     'label' => 'My Profile'],
                ['url' => 'user/service',  'icon' => 'gear',     'label' => 'Service'],
                ['url' => 'user/service',  'icon' => 'star',     'label' => 'Notifications'],
                ['url' => 'user/admin-dashboard',  'icon' => 'star',     'label' => 'dashboard'],
                ['url' => 'privacy-policy',    'icon' => 'envelope', 'label' => 'Policy'],
                ['url' => 'user/help',          'icon' => 'book',     'label' => 'Help'],
                
            ];
        @endphp

        <div class="py-1.5">
            @foreach($menuItems as $item)
                @php $isActive = $currentUrl === url($item['url']); @endphp
                <a href="{{ url($item['url']) }}"
                   class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors
                          {{ $isActive
                                ? 'bg-indigo-50 text-indigo-700 font-semibold'
                                : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">

                    {{-- Icon --}}
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg shrink-0
                                 {{ $isActive ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-500' }}">
                        @switch($item['icon'])
                            @case('user')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                @break
                            @case('gear')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                @break
                            @case('star')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                @break
                            @case('envelope')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                @break
                            @case('book')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                @break
                            @case('package')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                @break
                            @case('wallet')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                @break
                        @endswitch
                    </span>

                    <span class="flex-1">{{ $item['label'] }}</span>

                    {{-- Optional badge --}}
                    @if(!empty($item['badge']))
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-700">
                            {{ $item['badge'] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Logout (separated) --}}
        <div class="border-t border-gray-100 py-1.5 bg-gray-50/50">
            <a href="{{ route('user.userLogout') }}"
              
               class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <span class="flex-1 font-semibold">Logout</span>
            </a>
        </div>

    </div>
</div>


           
@endif
        </div>

        {{-- Mobile buttons --}}
        <div class="md:hidden flex items-center gap-10">
           
        

<a href="https://play.google.com/store/apps/details?id=com.quick_dial&hl=en_IN"
   target="_blank"
   class="group inline-flex items-center justify-center hover:bg-EB2C3B-700 from-green-500 to-emerald-600  transition-all duration-300">
     <img src="{{ asset('play-store-android.png') }}" 
     alt="Download Quickdials app on Google Play Store"
   class="h-10 w-24 sm:h-16 md:h-20 lg:h-24 xl:h-28 2xl:h-32 object-contain"
     loading="lazy"
     decoding="async"
/>
    
</a>

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
   {{-- Mobile search bar (always visible on mobile) --}}
@if (!request()->is('/') && !request()->is('payment/checkout'))
<div class="md:hidden border-t border-gray-100 bg-white/95 backdrop-blur-md relative">
    <div class="px-3 py-2">
        <div class="flex bg-white rounded-xl border border-gray-200 shadow-md h-9 overflow-visible relative">

            {{-- Mobile City selector (tappable) --}}
            <div id="mobile-city-dropdown" class="relative shrink-0">
                <button
                    type="button"
                    id="mobile-city-btn"
                    onclick="toggleMobileCity()"
                    class="flex items-center gap-1 h-9 px-2.5 text-xs font-semibold text-blue-700 border-r border-gray-200 hover:bg-blue-50 transition-colors whitespace-nowrap rounded-l-xl"
                >
                    <i data-lucide="map-pin" class="w-3 h-3 text-blue-500"></i>
                    <span id="mobile-city-label">Bangalore</span>
                    <i data-lucide="chevron-down" class="w-2.5 h-2.5 text-gray-400 transition-transform duration-200" id="mobile-city-chevron"></i>
                </button>

                {{-- Mobile City Panel --}}
                <div
                    id="mobile-city-panel"
                    class="hidden absolute top-full left-0 mt-1.5 bg-white rounded-xl shadow-2xl border border-gray-100 z-[70] w-52 overflow-hidden"
                >
                    <div class="p-2 border-b border-gray-100">
                        <div class="flex items-center gap-1.5 bg-gray-50 rounded-lg px-2.5 py-1.5 border border-gray-200">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-gray-400 shrink-0"></i>
                            <input
                                id="mobile-city-search"
                                type="text"
                                placeholder="Search city..."
                                class="flex-1 text-xs bg-transparent outline-none text-gray-700 placeholder:text-gray-400 font-medium"
                                oninput="filterMobileCities(this.value)"
                            />
                            <button type="button" onclick="clearMobileCitySearch()" class="text-gray-300 hover:text-gray-500 text-xs hidden" id="mobile-city-clear">✕</button>
                        </div>
                    </div>
                    <div class="max-h-48 overflow-y-auto py-1" id="mobile-city-list"></div>
                </div>
            </div>

            {{-- Mobile Search Input --}}
            <input
                id="mobile-search-input"
                type="text"
                autocomplete="off"
                placeholder="Search businesses, services..."
                class="flex-1 text-xs px-2.5 outline-none bg-transparent text-gray-800 placeholder:text-gray-400"
                oninput="handleMobileSearchInput(this.value)"
                onkeydown="handleMobileKeydown(event)"
            />

            {{-- Mobile Search Button --}}
            <button
                type="button"
                onclick="doMobileSearch()"
                class="shrink-0 bg-orange-500 hover:bg-orange-600 text-white h-9 px-3 rounded-r-xl flex items-center transition-colors"
            >
                <i data-lucide="search" class="w-3.5 h-3.5"></i>
            </button>
        </div>

        {{-- Mobile Suggestions Dropdown --}}
        <div
            id="mobile-suggestions"
            class="hidden absolute top-full left-3 right-3 mt-1 bg-white rounded-xl shadow-2xl border border-gray-100 z-[60] overflow-hidden"
        >
            <ul id="mobile-suggestions-list"></ul>
        </div>
    </div>
</div>
@endif

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
               <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
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
                : ' <i data-lucide="map-pin" class="w-3 h-3 text-blue-500"></i>'}
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
 alert(city);
    document.getElementById('sticky-city-label').textContent = city;
    // document.getElementById('mobile-city-label').textContent = city; 
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
    if (val.trim().length < 1) {
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
    document.getElementById('sticky-search-input').value = s.id;
    hideStickysuggestions();
    redirectSearch(s.id, stickySelectedCity);
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


// ─── MOBILE: City Dropdown ─────────────────────────────────────────────────
function toggleMobileCity() {
    const panel   = document.getElementById('mobile-city-panel');
    const chevron = document.getElementById('mobile-city-chevron');
    if (!panel) return;
    const isHidden = panel.classList.contains('hidden');
    panel.classList.toggle('hidden', !isHidden);
    if (chevron) chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
    if (isHidden) renderMobileCityList(FALLBACK_CITIES);
}

function renderMobileCityList(list, q = '') {
    const clearBtn = document.getElementById('mobile-city-clear');
    if (clearBtn) clearBtn.classList.toggle('hidden', !q);
    const el = document.getElementById('mobile-city-list');
    if (!el) return;
    el.innerHTML = list.map(city => `
        <button type="button" onclick="selectMobileCity('${city.city}')"
            class="w-full text-left px-4 py-2 text-xs transition-colors font-medium flex items-center gap-2
                   ${city.city === stickySelectedCity ? 'text-blue-700 bg-blue-50' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700'}">
            ${city.city === stickySelectedCity
                ? '<span class="w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0"></span>'
                : '<span class="ml-3.5"></span>'}
            ${city.cityDetails}
        </button>`).join('');
}

let mobileCityTimeout = null;
function filterMobileCities(q) {
    const clearBtn = document.getElementById('mobile-city-clear');
    if (clearBtn) clearBtn.classList.toggle('hidden', !q);
    clearTimeout(mobileCityTimeout);
    if (q.length < 1) { renderMobileCityList(FALLBACK_CITIES); return; }
    mobileCityTimeout = setTimeout(async () => {
        try {
            const r = await fetch(`https://api.quickdials.com/api/website/getCityList?city=${encodeURIComponent(q)}`);
            const d = await r.json();
            const m = (d.data ?? []).map(i => ({ city: i.city, cityDetails: i.cityDetails }));
            renderMobileCityList(m.length ? m : FALLBACK_CITIES, q);
        } catch {
            renderMobileCityList(FALLBACK_CITIES.filter(c => c.cityDetails.toLowerCase().includes(q.toLowerCase())), q);
        }
    }, 250);
}

function clearMobileCitySearch() {
    const input = document.getElementById('mobile-city-search');
    if (input) { input.value = ''; filterMobileCities(''); }
}

function selectMobileCity(city) {
    stickySelectedCity = city;
    // Sync labels everywhere
    const stickyLabel = document.getElementById('sticky-city-label');
    const mobileLabel = document.getElementById('mobile-city-label');
    if (stickyLabel) stickyLabel.textContent = city;
    if (mobileLabel) mobileLabel.textContent = city;
    // Close panel
    document.getElementById('mobile-city-panel').classList.add('hidden');
    const chev = document.getElementById('mobile-city-chevron');
    if (chev) chev.style.transform = '';
    // Focus search
    const inp = document.getElementById('mobile-search-input');
    if (inp) inp.focus();
}

// ─── MOBILE: Search Suggestions ────────────────────────────────────────────
let mobileSearchTimeout = null;
let mobileSuggestions   = [];
let activeMobileIdx     = -1;

function handleMobileSearchInput(val) {
    clearTimeout(mobileSearchTimeout);
    if (val.trim().length < 2) { hideMobileSuggestions(); return; }
    mobileSearchTimeout = setTimeout(() => fetchMobileSuggestions(val.trim()), 220);
}

async function fetchMobileSuggestions(q) {
    try {
        const res  = await fetch(`https://api.quickdials.com/api/website/get-keyword-list?keyword=${encodeURIComponent(q)}`);
        const data = await res.json();
        mobileSuggestions = (data.data ?? []).map(i => ({ id: i.slug, label: i.keyword, kind: i.type }));
        renderMobileSuggestions(q);
    } catch { hideMobileSuggestions(); }
}

function renderMobileSuggestions(q) {
    const list = document.getElementById('mobile-suggestions-list');
    const box  = document.getElementById('mobile-suggestions');
    if (!list || !box) return;
    if (!mobileSuggestions.length) { hideMobileSuggestions(); return; }
    const kindColors = { category: 'bg-blue-50 text-blue-600', service: 'bg-orange-50 text-orange-600', keyword: 'bg-green-50 text-green-600' };
    list.innerHTML = mobileSuggestions.map((s, idx) => {
        const low = q.toLowerCase();
        const lbl = s.label;
        const mi  = lbl.toLowerCase().indexOf(low);
        const hl  = mi >= 0
            ? `${lbl.slice(0,mi)}<span class="text-blue-600 font-semibold">${lbl.slice(mi,mi+q.length)}</span>${lbl.slice(mi+q.length)}`
            : lbl;
        const kc = kindColors[s.kind] || 'bg-gray-100 text-gray-500';
        return `<li>
            <button type="button" onmousedown="selectMobileSuggestion(${idx})" ontouchstart="selectMobileSuggestion(${idx})"
                class="w-full flex items-center gap-3 px-4 py-2.5 text-left transition-colors hover:bg-gray-50">
                <svg class="w-3.5 h-3.5 text-gray-300 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                <span class="flex-1 text-sm text-gray-700">${hl}</span>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full uppercase tracking-wide ${kc}">${s.kind}</span>
            </button>
        </li>`;
    }).join('');
    box.classList.remove('hidden');
    activeMobileIdx = -1;
}

function hideMobileSuggestions() {
    const box = document.getElementById('mobile-suggestions');
    if (box) box.classList.add('hidden');
    mobileSuggestions = [];
    activeMobileIdx = -1;
}

function selectMobileSuggestion(idx) {
    const s = mobileSuggestions[idx];
    if (!s) return;
    document.getElementById('mobile-search-input').value = s.id;
    hideMobileSuggestions();
    redirectSearch(s.id, stickySelectedCity);
}

function handleMobileKeydown(e) {
    if (e.key === 'Enter') { e.preventDefault(); doMobileSearch(); }
    else if (e.key === 'Escape') hideMobileSuggestions();
}

function doMobileSearch() {
    const inp = document.getElementById('mobile-search-input');
    if (!inp) return;
    const kw = inp.value.trim();
    redirectSearch(kw, stickySelectedCity);
}

// Close mobile city dropdown on outside tap
document.addEventListener('mousedown', (e) => {
    const dd = document.getElementById('mobile-city-dropdown');
    if (dd && !dd.contains(e.target)) {
        const panel = document.getElementById('mobile-city-panel');
        const chev  = document.getElementById('mobile-city-chevron');
        if (panel) panel.classList.add('hidden');
        if (chev) chev.style.transform = '';
    }
    // Close mobile suggestions on outside tap
    const inp = document.getElementById('mobile-search-input');
    const sug = document.getElementById('mobile-suggestions');
    if (inp && sug && !inp.contains(e.target) && !sug.contains(e.target)) {
        sug.classList.add('hidden');
    }
});

// Re-init Lucide icons after dynamic insert (run after DOM ready)
document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) window.lucide.createIcons();
});
 
</script>
