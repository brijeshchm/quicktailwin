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

<style>
    .rw-hero {
        background: linear-gradient(135deg, #f59e0b, #fbbf24, #fcd34d);
        border-radius: 1rem;
        padding: 2.5rem;
        color: #fff;
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1);
        position: relative;
        overflow: hidden;
    }
    .rw-hero-icon-bg {
        position: absolute;
        top: -1rem; right: -1rem;
        font-size: 16rem;
        opacity: .15;
        color: #fff;
        pointer-events: none;
    }
    .rw-balance-num {
        font-size: 4rem;
        font-weight: 800;
        letter-spacing: -.02em;
    }
    @media (min-width: 768px) {
        .rw-balance-num { font-size: 5.5rem; }
    }
    .rw-stats-box {
        background: rgba(255,255,255,.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,.3);
        border-radius: .75rem;
        padding: 1.5rem;
        min-width: 250px;
    }
    .progress-white > .progress-bar { background-color: #fff; }
    .progress-track-dark { background-color: rgba(0,0,0,.2); }

    .reward-card {
        border: 1px solid #fde68a;
        box-shadow: 0 .25rem .5rem rgba(0,0,0,.05);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .reward-card.can-afford:hover { transform: translateY(-4px); }
    .reward-card.cannot-afford { opacity: .8; border-color: #dee2e6; }
    .reward-img-wrap {
        height: 10rem;
        background-color: #f1f3f5;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .reward-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .reward-category-badge {
        position: absolute; top: .5rem; left: .5rem;
        background-color: rgba(255,255,255,.9);
        backdrop-filter: blur(4px);
    }
    .gem-amber { color: #f59e0b; }
    .btn-amber {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #1a1a1a;
    }
    .btn-amber:hover { background-color: #d97706; border-color: #d97706; color: #1a1a1a; }

    .choice-pill {
        border: 1px solid #dee2e6;
        border-radius: 50rem;
        padding: .35rem .9rem;
        font-size: .85rem;
        background: #fff;
        cursor: pointer;
        transition: all .15s ease;
    }
    .choice-pill:hover { background-color: #f8f9fa; }
    .choice-pill.selected {
        border-color: #f59e0b;
        background-color: #fffbeb;
        color: #b45309;
        box-shadow: 0 0 0 1px #f59e0b;
    }

    .biz-option {
        display: flex; align-items: center; gap: .75rem;
        width: 100%; text-align: left;
        border: 1px solid #dee2e6;
        border-radius: .5rem;
        padding: .75rem;
        background: #fff;
        cursor: pointer;
        transition: all .15s ease;
    }
    .biz-option:hover { background-color: #f8f9fa; }
    .biz-option.selected {
        border-color: #f59e0b;
        background-color: #fffbeb;
        box-shadow: 0 0 0 1px #f59e0b;
    }
    .biz-logo-sm {
        width: 2.5rem; height: 2.5rem; border-radius: .5rem;
        background-color: #f1f3f5;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; flex-shrink: 0;
    }
    .biz-logo-sm img { width: 100%; height: 100%; object-fit: cover; }

    .history-scroll { max-height: 600px; overflow-y: auto; }
    .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
 
<div class="container py-4 py-md-5" style="max-width: 1140px;">

    <div class="mb-4">
        <h1 class="fs-2 fw-bold mb-2" style="font-family: 'Georgia', serif;">Rewards Wallet</h1>
        <p class="text-muted">Earn coins on every service, redeem them for free perks.</p>
    </div>

    {{-- Balance Hero --}}
    <div class="rw-hero mb-4">
        <i class="bi bi-gem rw-hero-icon-bg"></i>
        <div class="row align-items-center g-4 position-relative">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-uppercase fw-medium mb-2" style="letter-spacing:.15em; font-size:.8rem; color:#fffbeb;">Available Balance</p>
                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                    <i class="bi bi-gem-fill" style="font-size: 3rem;"></i>
                    <span class="rw-balance-num">{{ $rewards['balance'] }}</span>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center justify-content-md-end">
                <div class="rw-stats-box w-100" style="max-width: 320px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small fw-medium" style="color:#fffbeb;">Total Earned</span>
                        <span class="fw-bold">{{ $rewards['totalEarned'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small fw-medium" style="color:#fffbeb;">Total Redeemed</span>
                        <span class="fw-bold">{{ $rewards['totalRedeemed'] }}</span>
                    </div>
                    <div class="pt-3 border-top" style="border-color: rgba(255,255,255,.2) !important;">
                        <div class="d-flex justify-content-between small mb-2">
                            <span>Progress to next reward</span>
                            <span>{{ number_format($progressPercent, 0) }}%</span>
                        </div>
                        <div class="progress progress-track-dark progress-white" style="height: .5rem;">
                            <div class="progress-bar" style="width: {{ $progressPercent }}%;"></div>
                        </div>
                        <p class="small mt-2 mb-0" style="color:#fffbeb;">
                            @if ($rewards['balance'] >= $minRewardPoints)
                                You have enough coins for a reward!
                            @else
                                {{ $minRewardPoints - $rewards['balance'] }} more coins to unlock rewards
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- My Redemptions --}}
    @if (!empty($redemptions))
    <div class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-box-seam text-warning"></i>
            <h2 class="fs-4 fw-bold mb-0" style="font-family: 'Georgia', serif;">My Redemptions</h2>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach ($redemptions as $r)
                    <div class="list-group-item p-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                        <div class="text-truncate">
                            <p class="fw-medium mb-0">{{ $r->item_name }}</p>
                            <p class="text-muted small mb-0">
                                {{ $r->business_name }}{{ $r->city ? ' • ' . $r->city : '' }} • {{ $r->created_at->format('M j, Y') }}
                            </p>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            @if ($r->status === 'pending')
                                <span class="badge badge-soft-slate fw-normal"><i class="bi bi-clock me-1"></i> Awaiting completion</span>
                            @elseif ($r->status === 'completed')
                                <span class="badge badge-soft-blue fw-normal">Business marked complete</span>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-amber js-confirm-redemption"
                                    data-id="{{ $r->id }}"
                                    data-url="{{ route('redemptions.confirm', $r->id) }}"
                                >
                                    Confirm completion
                                </button>
                            @elseif ($r->status === 'confirmed')
                                <span class="badge badge-soft-green fw-normal"><i class="bi bi-check-circle-fill me-1"></i> Confirmed</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row g-4">
        {{-- Redeemable Items --}}
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-stars text-warning"></i>
                <h2 class="fs-4 fw-bold mb-0" style="font-family: 'Georgia', serif;">Redeem Rewards</h2>
            </div>

            @if (!empty($items))
            <div class="row g-3">
                @foreach ($items as $item)
                    @php
                        $itemCityPrices = $item->cityPrices ?? collect();
                        $allCosts = $itemCityPrices->pluck('coins_required')->push($item->coins_required);
                        $minCost = $allCosts->min();
                        $hasCityPricing = $itemCityPrices->count() > 0;
                        $canAfford = $rewards['balance'] >= $minCost;
                        $coinsNeeded = $minCost - $rewards['balance'];

                    @endphp

                    @php
    $itemCityPrices = $item->cityPrices ?? collect();
    $allCosts = $itemCityPrices->pluck('coins_required')->push($item->coins_required);
    $minCost = $allCosts->min();
    $hasCityPricing = $itemCityPrices->count() > 0;
    $canAfford = $rewards['balance'] >= $minCost;
    $coinsNeeded = $minCost - $rewards['balance'];

    $cityPricesPayload = $itemCityPrices->map(function ($cp) {
        return ['city' => $cp->city, 'coinsRequired' => $cp->coins_required];
    })->values();

    $itemPayload = json_encode([
        'id' => $item->id,
        'name' => $item->name,
        'category' => $item->category,
        'coinsRequired' => $item->coins_required,
        'cityPrices' => $cityPricesPayload,
    ]);
@endphp
                    <div class="col-sm-6">
                        <div class="card reward-card h-100 d-flex flex-column {{ $canAfford ? 'can-afford' : 'cannot-afford' }}">
                            <div class="reward-img-wrap">
                                @if ($item->image_url)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div style="display:none;" class="position-absolute top-0 start-0 w-100 h-100 align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted opacity-25" style="font-size:2.5rem;"></i>
                                    </div>
                                @else
                                    <i class="bi bi-image text-muted opacity-25" style="font-size:2.5rem;"></i>
                                @endif
                                @if ($item->category)
                                    <span class="badge reward-category-badge text-dark fw-medium">{{ $item->category }}</span>
                                @endif
                            </div>
                            <div class="card-body flex-grow-1">
                                <h5 class="card-title fs-6 line-clamp-1 mb-2">{{ $item->name }}</h5>
                                <p class="text-muted small line-clamp-2 mb-0">{{ $item->description }}</p>
                            </div>
                            <div class="card-footer bg-white border-0 pt-0 d-flex flex-column gap-2">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background-color:#f8f9fa;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-gem-fill {{ $canAfford ? 'gem-amber' : 'text-muted' }}"></i>
                                        <span class="fw-bold fs-5">{{ $hasCityPricing ? 'from ' . $minCost : $item->coins_required }}</span>
                                    </div>
                                    @if (!$canAfford)
                                        <span class="text-muted small">Need {{ $coinsNeeded }} more</span>
                                    @endif
                                </div>
                                <button
                                    type="button"
                                    class="btn w-100 js-open-redeem {{ $canAfford ? 'btn-amber' : 'btn-secondary' }}"
                                    {{ $canAfford ? '' : 'disabled' }}
                                  
                                    data-item="{{ htmlspecialchars($itemPayload, ENT_QUOTES, 'UTF-8') }}"
                                >
                                    {{ $canAfford ? 'Redeem Now' : 'Not enough coins' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <div class="col-12 p-5 text-center border border-dashed rounded-3" style="background-color:#f8f9fa;">
                <i class="bi bi-gift text-muted d-block mb-3" style="font-size:2.5rem; opacity:.5;"></i>
                <h3 class="fs-6 fw-semibold mb-1">No rewards available</h3>
                <p class="text-muted small mb-0">Keep earning coins to unlock rewards in the future.</p>
            </div>
            @endif
        </div>

        {{-- Transaction History --}}
        <div class="col-md-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-clock-history text-muted"></i>
                <h2 class="fs-4 fw-bold mb-0" style="font-family: 'Georgia', serif;">History</h2>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    @if ($transactions->count() > 0)
                    <div class="list-group list-group-flush history-scroll">
                        @foreach ($transactions as $tx)
                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div>
                                <p class="fw-medium small mb-0">{{ $tx->description }}</p>
                                <p class="text-muted small mb-0" style="font-size:.7rem;">{{ $tx->created_at->format('M j, Y') }}</p>
                            </div>
                            <div class="fw-bold d-flex align-items-center gap-1 {{ $tx->type === 'earned' ? 'text-success' : 'text-warning' }}">
                                {{ $tx->type === 'earned' ? '+' : '-' }}{{ $tx->points }}
                                <i class="bi bi-gem-fill" style="font-size:.7rem;"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-4 text-center text-muted">No transactions yet.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Redeem Modal --}}
<div class="modal fade" id="redeemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 560px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose a business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small mb-3" id="redeemDescription"></p>

                <div id="cityPriceSection" class="mb-3 d-none">
                    <p class="small fw-medium mb-1">Select your city</p>
                    <p class="text-muted small mb-2">Pricing varies by city for this reward.</p>
                    <div id="cityPills" class="d-flex flex-wrap gap-2 mb-2"></div>
                    <p class="text-danger small mb-0 d-none" id="cityPriceWarning"></p>
                </div>

                <div id="businessList" class="d-flex flex-column gap-2"></div>

                <div id="noBusinessesMsg" class="p-4 text-center border border-dashed rounded-3 d-none" style="background-color:#f8f9fa;">
                    <i class="bi bi-shop text-muted d-block mb-2" style="font-size:2rem; opacity:.5;"></i>
                    <p class="text-muted small mb-0">No businesses are currently available for this reward. Please check back later.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-amber" id="confirmRedeemBtn" disabled>Redeem</button>
            </div>
        </div>
    </div>
</div>
 
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ---- Server-provided data ----
    
@php
    $businessesPayload = $businesses->map(function ($b) {
        return [
            'id' => $b->id,
            'name' => $b->name,
            'logoUrl' => $b->logo_url,
            'category' => $b->category,
            'rating' => $b->rating,
            'reviewCount' => $b->review_count,
            'location' => $b->location,
            'isVerified' => (bool) $b->is_verified,
        ];
    });
@endphp

    const customerBalance = {{ $rewards['balance'] }};
    const redeemUrl = "{{ route('user.rewards.redeem') }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ---- Modal state ----
    let selectedItem = null;
    let selectedCity = null;
    let selectedBusinessId = null;
 const businesses = @json($businessesPayload);
    const modalEl = document.getElementById('redeemModal');
    const modal = new bootstrap.Modal(modalEl);
    const descEl = document.getElementById('redeemDescription');
    const cityPriceSection = document.getElementById('cityPriceSection');
    const cityPills = document.getElementById('cityPills');
    const cityPriceWarning = document.getElementById('cityPriceWarning');
    const businessListEl = document.getElementById('businessList');
    const noBusinessesMsg = document.getElementById('noBusinessesMsg');
    const confirmBtn = document.getElementById('confirmRedeemBtn');

    function normalizeCategory(s) {
        return (s || '').trim().toLowerCase();
    }

    function effectiveCoins() {
        if (!selectedItem) return 0;
        if (selectedCity) {
            const cp = (selectedItem.cityPrices || []).find(c => c.city === selectedCity);
            if (cp) return cp.coinsRequired;
        }
        return selectedItem.coinsRequired;
    }

    function renderCityPills() {
        const cps = selectedItem.cityPrices || [];
        if (cps.length === 0) {
            cityPriceSection.classList.add('d-none');
            return;
        }
        cityPriceSection.classList.remove('d-none');
        cityPills.innerHTML = '';

        const standardPill = document.createElement('button');
        standardPill.type = 'button';
        standardPill.className = 'choice-pill' + (selectedCity === null ? ' selected' : '');
        standardPill.textContent = `Standard (${selectedItem.coinsRequired} coins)`;
        standardPill.addEventListener('click', () => { selectedCity = null; refreshModal(); });
        cityPills.appendChild(standardPill);

        cps.forEach(cp => {
            const pill = document.createElement('button');
            pill.type = 'button';
            pill.className = 'choice-pill' + (selectedCity === cp.city ? ' selected' : '');
            pill.textContent = `${cp.city} (${cp.coinsRequired} coins)`;
            pill.addEventListener('click', () => { selectedCity = cp.city; refreshModal(); });
            cityPills.appendChild(pill);
        });

        const coins = effectiveCoins();
        if (customerBalance < coins) {
            cityPriceWarning.textContent = `You need ${coins - customerBalance} more coins for this city.`;
            cityPriceWarning.classList.remove('d-none');
        } else {
            cityPriceWarning.classList.add('d-none');
        }
    }

    function renderBusinessList() {
        const matching = businesses.filter(b =>
            !selectedItem.category || normalizeCategory(b.category) === normalizeCategory(selectedItem.category)
        );

        businessListEl.innerHTML = '';

        if (matching.length === 0) {
            businessListEl.classList.add('d-none');
            noBusinessesMsg.classList.remove('d-none');
            return;
        }

        businessListEl.classList.remove('d-none');
        noBusinessesMsg.classList.add('d-none');

        matching.forEach(b => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'biz-option' + (selectedBusinessId === b.id ? ' selected' : '');

            const logoHtml = b.logoUrl
                ? `<img src="${b.logoUrl}" alt="${b.name}">`
                : `<i class="bi bi-shop text-muted"></i>`;

            const verifiedHtml = b.isVerified
                ? `<i class="bi bi-patch-check-fill text-warning" style="font-size:.85rem;"></i>`
                : '';

            btn.innerHTML = `
                <div class="biz-logo-sm">${logoHtml}</div>
                <div class="flex-grow-1 text-truncate">
                    <div class="d-flex align-items-center gap-1">
                        <span class="fw-semibold text-truncate">${b.name}</span>
                        ${verifiedHtml}
                    </div>
                    <div class="d-flex align-items-center gap-3 text-muted small mt-1">
                        <span><i class="bi bi-star-fill text-warning" style="font-size:.7rem;"></i> ${b.rating} (${b.reviewCount})</span>
                        <span class="text-truncate"><i class="bi bi-geo-alt" style="font-size:.7rem;"></i> ${b.location}</span>
                    </div>
                </div>
            `;
            btn.addEventListener('click', () => { selectedBusinessId = b.id; refreshModal(); });
            businessListEl.appendChild(btn);
        });
    }

    function refreshModal() {
        renderCityPills();
        renderBusinessList();

        const coins = effectiveCoins();
        const canConfirm = selectedBusinessId !== null && customerBalance >= coins;
        confirmBtn.disabled = !canConfirm;
        confirmBtn.textContent = selectedItem ? `Redeem for ${coins} coins` : 'Redeem';
    }

    document.querySelectorAll('.js-open-redeem').forEach(btn => {
        btn.addEventListener('click', function () {
            selectedItem = JSON.parse(this.dataset.item);
            selectedCity = null;
            selectedBusinessId = null;

            descEl.textContent = selectedItem.category
                ? `Select a ${selectedItem.category} business to redeem "${selectedItem.name}" with.`
                : `Select a business to redeem "${selectedItem.name}" with.`;

            refreshModal();
            modal.show();
        });
    });

    confirmBtn.addEventListener('click', function () {
        if (!selectedItem || selectedBusinessId === null) return;

        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Redeeming...';

        const payload = {
            item_id: selectedItem.id,
            business_id: selectedBusinessId,
        };
        if (selectedCity) payload.city = selectedCity;

        fetch(redeemUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        })
        .then(res => res.json().then(data => ({ ok: res.ok, data })))
        .then(({ ok, data }) => {
            if (ok && data.success) {
                modal.hide();
                window.location.reload(); // refresh balance, item availability, redemptions list
            } else {
                alert(data.message || 'Redemption failed.');
                confirmBtn.disabled = false;
                confirmBtn.textContent = `Redeem for ${effectiveCoins()} coins`;
            }
        })
        .catch(() => {
            alert('Something went wrong. Please try again.');
            confirmBtn.disabled = false;
            confirmBtn.textContent = `Redeem for ${effectiveCoins()} coins`;
        });
    });

    // ---- Confirm completion (customer confirms business finished the service) ----
    document.querySelectorAll('.js-confirm-redemption').forEach(btn => {
        btn.addEventListener('click', function () {
            const url = this.dataset.url;
            const originalText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = 'Confirming...';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json().then(data => ({ ok: res.ok, data })))
            .then(({ ok, data }) => {
                if (ok && data.success) {
                    window.location.reload();
                } else {
                    this.disabled = false;
                    this.innerHTML = originalText;
                    alert(data.message || 'Could not confirm.');
                }
            })
            .catch(() => {
                this.disabled = false;
                this.innerHTML = originalText;
                alert('Something went wrong. Please try again.');
            });
        });
    });
});
</script>
 
 













          
        </div>
    </div>
</div>

 
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
 

@endsection