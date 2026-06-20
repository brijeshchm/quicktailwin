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
            @include('user.profile.step-indicator', ['currentStep' => 'vouchers'])
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

            {{-- 🏷️ Category Filter Tabs --}}
            

            {{-- 🎟️ Voucher Grid --}}
            @if($vouchers)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="voucherGrid">
                    @foreach($vouchers as $voucher)
                    
                        @php

 
                        $isClaimed = 1;

                        @endphp

<div class="voucher-card group relative bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300"
     data-voucher-id="{{ $voucher->category_id }}">

    {{-- Top colored strip --}}
    <div class="flex">
        {{-- LEFT: Discount Value (colored) --}}
        <div class="relative w-28 flex-shrink-0 bg-gradient-to-br from-blue-600 to-indigo-700 flex flex-col items-center justify-center p-4 text-white">
            <span class="text-2xl font-extrabold leading-none">
                {{ $voucher->type === 'percentage' ? rtrim(rtrim(number_format($voucher->value,2),'0'),'.') . '%' : '₹' . rtrim(rtrim(number_format($voucher->value,2),'0'),'.') }}
            </span>
            <span class="text-xs font-medium mt-1 uppercase tracking-wide opacity-90">Off</span>

             
        </div>

        {{-- RIGHT: Details --}}
        <div class="flex-1 p-4">
            <div class="flex items-start justify-between gap-2">
                <div class="flex-1 min-w-0">
                    @if($voucher->category_id)
                        <span class="inline-block text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded uppercase tracking-wide mb-1">
                            {{ $voucher->category_id }}
                        </span>
                    @endif
                    <h3 class="text-sm font-bold text-gray-900 leading-snug">{{ $voucher->title }}</h3>
                    @if($voucher->brand)
                        <p class="text-xs text-gray-500 mt-0.5">by {{ $voucher->brand }}</p>
                    @endif
                </div>

                @if(!empty($voucher->image))
                    <img src="{{ asset('storage/' . $voucher->image) }}"
                         alt="{{ $voucher->brand }}"
                         class="w-10 h-10 rounded object-cover flex-shrink-0">
                @endif
            </div>

            @if(!empty($voucher->description))
                <p class="text-xs text-gray-600 mt-2 line-clamp-2">{{ $voucher->description }}</p>
            @endif

            {{-- Meta row --}}
            <div class="flex items-center gap-3 mt-2 text-[11px] text-gray-500">
           
              
            </div>

            {{-- Code + Claim button --}}
            <div class="flex items-center justify-between gap-2 mt-3 pt-3 border-t border-dashed border-gray-200">
                <div class="flex items-center gap-1.5 bg-gray-50 border border-gray-200 rounded px-2 py-1">
                    <i data-lucide="ticket" class="w-3.5 h-3.5 text-gray-400"></i>
                    <span class="text-xs font-mono font-bold text-gray-700 tracking-wider voucher-code">{{ $voucher->code }}</span>
                </div>

                @if($isClaimed)
                    <button type="button" disabled
                            class="claim-btn inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1.5 rounded cursor-default">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        Claimed
                    </button>
                @else
                    <button type="button"
                            onclick="claimVoucher({{ $voucher->id }}, this)"
                            class="claim-btn inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded transition">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        Claim
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>


                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                    <i data-lucide="ticket-x" class="w-12 h-12 mx-auto text-gray-300 mb-3"></i>
                    <p class="text-gray-600 font-medium">No vouchers available</p>
                    <p class="text-sm text-gray-400 mt-1">Check back soon for new offers!</p>
                </div>
            @endif

            {{-- 💾 Continue --}}
            <!-- <form action="" method="POST">
                @csrf
                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium px-10 py-2.5 rounded transition shadow-md">
                        Continue dd
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </form> -->
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