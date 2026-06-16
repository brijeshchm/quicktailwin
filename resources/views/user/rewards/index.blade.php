@extends('user.layouts.guest')

@section('title', 'My Vouchers | QuickDials')
@section('description', 'User Vouchers')
@section('keyword', 'User Vouchers')
@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-800 p-3 rounded-lg flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- 📊 Left: Step Indicator --}}
        <div class="lg:col-span-3">
            @include('user.profile.step-indicator', ['currentStep' => 'rewards'])
        </div>

        {{-- 📝 Right: Vouchers --}}
        <div class="lg:col-span-9">
            <div class="flex items-center justify-between mb-5 pt-4">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Vouchers &amp; Offers for You
                </h2>
                <a href="{{ route('user.vouchers.my') }}"
                   class="text-sm text-blue-600 hover:underline font-medium flex items-center gap-1">
                    <i data-lucide="ticket" class="w-4 h-4"></i>
                    My Vouchers 2300
                </a>
            </div>





{{-- resources/views/rewards/index.blade.php --}}
<x-app-layout>
<div class="container mx-auto px-4 py-8 md:py-12 max-w-6xl">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold font-serif mb-2">Rewards Wallet</h1>
        <p class="text-gray-500">Earn coins on every service, redeem them for free perks.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- ===== BALANCE HERO ===== --}}
    <div class="bg-gradient-to-br from-amber-500 via-amber-400 to-amber-300 rounded-2xl p-8 md:p-12 text-white shadow-lg mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-10 opacity-10 pointer-events-none">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
            </svg>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start justify-between gap-8">
            <div class="text-center md:text-left">
                <p class="text-amber-50 font-medium mb-2 uppercase tracking-widest text-sm">Available Balance</p>
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <svg class="w-12 h-12 md:w-16 md:h-16 fill-white drop-shadow-sm" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="text-6xl md:text-8xl font-black tracking-tighter drop-shadow-md">
                        {{ number_format($user->coin_balance) }}
                    </span>
                </div>
            </div>

            <div class="bg-white/20 backdrop-blur-md rounded-xl p-6 w-full md:w-auto min-w-[250px] border border-white/30">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-amber-50">Total Earned</span>
                        <span class="font-bold">{{ number_format($user->total_earned) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-amber-50">Total Redeemed</span>
                        <span class="font-bold">{{ number_format($user->total_redeemed) }}</span>
                    </div>
                    <div class="pt-4 border-t border-white/20">
                        <div class="flex justify-between text-xs mb-2">
                            <span>Progress to next reward</span>
                            <span>{{ $progressPercent }}%</span>
                        </div>
                        {{-- Progress Bar --}}
                        <div class="h-2 bg-black/20 rounded-full overflow-hidden">
                            <div class="h-full bg-white rounded-full transition-all duration-500"
                                style="width: {{ $progressPercent }}%"></div>
                        </div>
                        <p class="text-xs text-amber-50 mt-2">
                            @if($user->coin_balance >= $minRewardPoints)
                                You have enough coins for a reward!
                            @else
                                {{ number_format($minRewardPoints - $user->coin_balance) }} more coins to unlock rewards
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MY REDEMPTIONS ===== --}}
    @if($redemptions->isNotEmpty())
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            <h2 class="text-xl font-bold font-serif">My Redemptions</h2>
        </div>
        <div class="bg-white border rounded-xl overflow-hidden shadow-sm divide-y">
            @foreach($redemptions as $r)
            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="font-medium text-gray-900">{{ $r->item_name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $r->business_name }}
                        @if($r->city) • {{ $r->city }} @endif
                        • {{ $r->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    @if($r->status === 'pending')
                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 text-xs font-medium px-3 py-1.5 rounded-full border border-slate-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Awaiting completion
                        </span>

                    @elseif($r->status === 'completed')
                        <span class="inline-flex items-center bg-blue-50 text-blue-600 text-xs font-medium px-3 py-1.5 rounded-full border border-blue-200">
                            Business marked complete
                        </span>
                        <form method="POST" action="{{ route('rewards.confirm', $r) }}">
                            @csrf
                            <button type="submit"
                                class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                Confirm completion
                            </button>
                        </form>

                    @elseif($r->status === 'confirmed')
                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-600 text-xs font-medium px-3 py-1.5 rounded-full border border-green-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirmed
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ===== MAIN GRID ===== --}}
    <div class="grid md:grid-cols-3 gap-8">

        {{-- REDEEM REWARDS --}}
        <div class="md:col-span-2">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l1.09 3.26L16 6l-2.91.74L12 10l-1.09-3.26L8 6l2.91-.74L12 2z"/>
                </svg>
                <h2 class="text-xl font-bold font-serif">Redeem Rewards</h2>
            </div>

            @if($activeItems->isNotEmpty())
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach($activeItems as $item)
                @php
                    $cityPrices  = $item->city_prices ?? [];
                    $allCosts    = collect($cityPrices)->pluck('coins_required')->push($item->coins_required);
                    $minCost     = $allCosts->min();
                    $canAfford   = $user->coin_balance >= $minCost;
                    $coinsNeeded = $minCost - $user->coin_balance;
                    $hasCityPricing = count($cityPrices) > 0;

                    // Matching businesses
                    $matchingBiz = $businesses->filter(function($b) use ($item) {
                        if (!$item->category) return true;
                        return strtolower(trim($b->category)) === strtolower(trim($item->category));
                    });
                @endphp
                <div class="flex flex-col bg-white rounded-xl border overflow-hidden shadow-sm transition-all
                    {{ $canAfford ? 'border-amber-200 shadow-md hover:-translate-y-1' : 'opacity-80' }}">

                    {{-- Image --}}
                    <div class="h-40 bg-gray-100 flex items-center justify-center relative overflow-hidden">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                                class="object-cover w-full h-full"
                                onerror="this.style.display='none'">
                        @else
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/>
                            </svg>
                        @endif
                        @if($item->category)
                            <span class="absolute top-2 left-2 bg-white/90 text-gray-800 text-xs font-medium px-2 py-1 rounded-full border">
                                {{ $item->category }}
                            </span>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="font-bold text-gray-900 text-lg mb-1 truncate">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-2 flex-1 mb-4">{{ $item->description }}</p>

                        {{-- Coin cost --}}
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg mb-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-5 h-5 {{ $canAfford ? 'text-amber-500 fill-amber-400' : 'text-gray-400' }}" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span class="font-bold text-lg">
                                    {{ $hasCityPricing ? 'from '.$minCost : $item->coins_required }}
                                </span>
                            </div>
                            @if(!$canAfford)
                                <span class="text-xs text-gray-400">Need {{ number_format($coinsNeeded) }} more</span>
                            @endif
                        </div>

                        {{-- Redeem Button → opens modal --}}
                        @if($canAfford)
                            <button
                                onclick="openRedeemModal({{ $item->id }})"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 rounded-lg transition text-sm">
                                Redeem Now
                            </button>
                        @else
                            <button disabled
                                class="w-full bg-gray-100 text-gray-400 font-semibold py-2 rounded-lg text-sm cursor-not-allowed">
                                Not enough coins
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @else
            <div class="p-10 text-center bg-gray-50 border-2 border-dashed rounded-xl">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                </svg>
                <h3 class="font-semibold text-gray-700 mb-1">No rewards available</h3>
                <p class="text-sm text-gray-400">Keep earning coins to unlock rewards.</p>
            </div>
            @endif
        </div>

        {{-- TRANSACTION HISTORY --}}
        <div>
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-xl font-bold font-serif">History</h2>
            </div>
            <div class="bg-white border rounded-xl overflow-hidden shadow-sm">
                @if($transactions->isNotEmpty())
                <div class="divide-y max-h-[600px] overflow-y-auto">
                    @foreach($transactions as $tx)
                    <div class="p-4 flex items-center justify-between">
                        <div class="min-w-0 flex-1 mr-3">
                            <p class="font-medium text-sm text-gray-900 truncate">{{ $tx->description }}</p>
                            <p class="text-xs text-gray-400">{{ $tx->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="font-bold text-sm shrink-0 flex items-center gap-1
                            {{ $tx->type === 'earned' ? 'text-green-600' : 'text-amber-600' }}">
                            {{ $tx->type === 'earned' ? '+' : '-' }}{{ number_format($tx->points) }}
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="p-8 text-center text-gray-400 text-sm">No transactions yet.</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ===== REDEEM MODAL ===== --}}
<div id="redeemModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

        <div class="p-6 border-b flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold font-serif">Choose a Business</h2>
                <p id="modalDesc" class="text-sm text-gray-500 mt-0.5"></p>
            </div>
            <button onclick="closeRedeemModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- City selector --}}
        <div id="citySelectorWrap" class="hidden px-6 pt-4">
            <p class="text-sm font-medium text-gray-700 mb-1">Select your city</p>
            <p class="text-xs text-gray-400 mb-2">Pricing varies by city for this reward.</p>
            <div id="cityButtons" class="flex flex-wrap gap-2"></div>
            <p id="cityError" class="hidden text-xs text-red-500 mt-2"></p>
        </div>

        {{-- Business list --}}
        <div id="businessList" class="p-6 space-y-2 max-h-[50vh] overflow-y-auto"></div>

        {{-- Form --}}
        <form id="redeemForm" method="POST" action="{{ route('user.rewards.redeem') }}">
            @csrf
            <input type="hidden" name="item_id" id="f_item_id">
            <input type="hidden" name="business_id" id="f_business_id">
            <input type="hidden" name="city" id="f_city">

            <div class="px-6 pb-6 flex justify-end gap-3 border-t pt-4">
                <button type="button" onclick="closeRedeemModal()"
                    class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Cancel
                </button>
                <button type="submit" id="redeemSubmitBtn" disabled
                    class="bg-amber-500 hover:bg-amber-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold px-5 py-2 rounded-lg text-sm transition">
                    Redeem
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Data for JS --}}
<script>
    const ITEMS      = @json($activeItems);
    const BUSINESSES = @json($businesses);
    const USER_COINS = {{ $user->coin_balance }};
</script>

@push('scripts')
<script>
let activeItem       = null;
let selectedBizId    = null;
let selectedCity     = null;

const modal          = document.getElementById('redeemModal');
const businessList   = document.getElementById('businessList');
const cityWrap       = document.getElementById('citySelectorWrap');
const cityButtons    = document.getElementById('cityButtons');
const cityError      = document.getElementById('cityError');
const submitBtn      = document.getElementById('redeemSubmitBtn');

function openRedeemModal(itemId) {
    activeItem    = ITEMS.find(i => i.id === itemId);
    selectedBizId = null;
    selectedCity  = null;

    document.getElementById('f_item_id').value  = itemId;
    document.getElementById('f_business_id').value = '';
    document.getElementById('f_city').value     = '';

    // Description
    const cat = activeItem.category;
    document.getElementById('modalDesc').textContent = cat
        ? `Select a ${cat} business to redeem "${activeItem.name}" with.`
        : `Select a business to redeem "${activeItem.name}" with.`;

    // City prices
    const cityPrices = activeItem.city_prices || [];
    if (cityPrices.length > 0) {
        cityWrap.classList.remove('hidden');
        cityButtons.innerHTML = '';

        // Standard option
        const stdBtn = makeBtn(
            `Standard (${activeItem.coins_required} coins)`,
            () => selectCity(null, activeItem.coins_required)
        );
        stdBtn.id = 'cityBtn_standard';
        cityButtons.appendChild(stdBtn);

        cityPrices.forEach(cp => {
            const btn = makeBtn(
                `${cp.city} (${cp.coins_required} coins)`,
                () => selectCity(cp.city, cp.coins_required)
            );
            btn.id = `cityBtn_${cp.city}`;
            cityButtons.appendChild(btn);
        });

        // Auto-select standard
        selectCity(null, activeItem.coins_required);
    } else {
        cityWrap.classList.add('hidden');
        selectedCity = null;
    }

    renderBusinessList();
    updateSubmitBtn();
    modal.classList.remove('hidden');
}

function closeRedeemModal() {
    modal.classList.add('hidden');
    activeItem = selectedBizId = selectedCity = null;
}

modal.addEventListener('click', e => { if (e.target === modal) closeRedeemModal(); });

function selectCity(city, cost) {
    selectedCity = city;
    document.getElementById('f_city').value = city ?? '';

    // Update button styles
    const allBtns = cityButtons.querySelectorAll('button');
    allBtns.forEach(b => b.classList.remove('border-amber-500','bg-amber-50','text-amber-700','ring-1','ring-amber-500'));
    const activeId = city ? `cityBtn_${city}` : 'cityBtn_standard';
    const active   = document.getElementById(activeId);
    if (active) active.classList.add('border-amber-500','bg-amber-50','text-amber-700','ring-1','ring-amber-500');

    // Check affordability
    const canAfford = USER_COINS >= cost;
    cityError.classList.toggle('hidden', canAfford);
    if (!canAfford) cityError.textContent = `You need ${cost - USER_COINS} more coins for this selection.`;

    renderBusinessList();
    updateSubmitBtn();
}

function renderBusinessList() {
    if (!activeItem) return;
    const norm = s => s.trim().toLowerCase();
    const matched = activeItem.category
        ? BUSINESSES.filter(b => norm(b.category) === norm(activeItem.category))
        : BUSINESSES;

    businessList.innerHTML = '';
    if (matched.length === 0) {
        businessList.innerHTML = `
            <div class="p-6 text-center bg-gray-50 border border-dashed rounded-xl">
                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-gray-400">No businesses available for this reward.</p>
            </div>`;
        return;
    }

    matched.forEach(b => {
        const div = document.createElement('button');
        div.type  = 'button';
        div.className = 'w-full text-left flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-amber-50 hover:border-amber-300 transition-colors business-btn';
        div.dataset.id = b.id;
        div.innerHTML = `
            <div class="w-10 h-10 rounded-md bg-gray-100 flex items-center justify-center shrink-0 overflow-hidden">
                ${b.logo_url
                    ? `<img src="${b.logo_url}" alt="${b.name}" class="object-cover w-full h-full">`
                    : `<svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>`}
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1.5">
                    <span class="font-semibold text-gray-900 truncate">${b.name}</span>
                    ${b.is_verified ? `<svg class="w-4 h-4 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>` : ''}
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-400 mt-0.5">
                    <span>⭐ ${b.rating} (${b.review_count})</span>
                    <span class="truncate">📍 ${b.location}</span>
                </div>
            </div>`;
        div.addEventListener('click', () => selectBusiness(b.id, div));
        businessList.appendChild(div);
    });
}

function selectBusiness(id, el) {
    selectedBizId = id;
    document.getElementById('f_business_id').value = id;
    document.querySelectorAll('.business-btn').forEach(b => {
        b.classList.remove('border-amber-500','bg-amber-50','ring-1','ring-amber-500');
    });
    el.classList.add('border-amber-500','bg-amber-50','ring-1','ring-amber-500');
    updateSubmitBtn();
}

function updateSubmitBtn() {
    if (!activeItem) { submitBtn.disabled = true; return; }
    const cityPrices = activeItem.city_prices || [];
    const cp = cityPrices.find(c => c.city === selectedCity);
    const cost = cp ? cp.coins_required : activeItem.coins_required;
    const ok   = selectedBizId !== null && USER_COINS >= cost;
    submitBtn.disabled = !ok;
    submitBtn.textContent = ok ? `Redeem for ${cost} coins` : 'Redeem';
}

function makeBtn(label, onClick) {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'px-3 py-1.5 rounded-full text-sm border border-gray-200 hover:bg-amber-50 transition-colors';
    btn.textContent = label;
    btn.addEventListener('click', onClick);
    return btn;
}
</script>
@endpush
</x-app-layout>










          
        </div>
    </div>
</div>

@push('scripts')
<script>
async function claimVoucher(voucherId, btn) {
    btn.disabled = true;
    const original = btn.innerHTML;
    btn.innerHTML = `<div class="animate-spin rounded-full h-3 w-3 border-2 border-white border-t-transparent"></div>`;

    try {
        const res = await fetch('{{ route("user.vouchers.claim") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ voucher_id: voucherId })
        });

        const data = await res.json();

        if (res.ok && data.success) {
            btn.outerHTML = `<button disabled class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1.5 rounded">
                <i data-lucide="check" class="w-3.5 h-3.5"></i> Claimed
            </button>`;
            lucide.createIcons();
            showToast(data.message, 'success');
        } else {
            btn.innerHTML = original;
            lucide.createIcons();
            showToast(data.message || 'Failed to claim', 'error');
            btn.disabled = false;
        }
    } catch (e) {
        btn.innerHTML = original;
        lucide.createIcons();
        showToast('Network error', 'error');
        btn.disabled = false;
    }
}

function showToast(msg, type = 'success') {
    const colors = { success: 'bg-green-600', error: 'bg-red-600', info: 'bg-gray-700' };
    const icons  = { success: 'check-circle', error: 'alert-circle', info: 'info' };
    const t = document.createElement('div');
    t.className = `fixed bottom-5 right-5 ${colors[type]} text-white px-4 py-3 rounded-lg shadow-lg flex items-center gap-2 z-50`;
    t.innerHTML = `<i data-lucide="${icons[type]}" class="w-5 h-5"></i> ${msg}`;
    document.body.appendChild(t);
    lucide.createIcons();
    setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 2800);
}
</script>
@endpush

@endsection