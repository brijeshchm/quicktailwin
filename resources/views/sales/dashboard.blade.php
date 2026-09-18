

<x-layouts.sales.app title="Dashboard · Vendorflow" header="Dashboard">



    <div class="space-y-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#a14f47]">{{ now()->format('l, F j, Y') }}</p>
            <h1 class="mt-2 font-display text-3xl font-semibold tracking-[-0.045em]">Good morning, {{ auth()->user()->name ?? 'there' }}.</h1>
            <p class="mt-1 text-sm text-[#718394]">Here’s what’s moving across your vendor network today.</p>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([['Total vendors', $summary['total'], 'Across your network', 'bg-[#e9f2f7] text-[#315b80]'], ['Active vendors', $summary['active'], 'Currently visible', 'bg-[#e4f4eb] text-[#26734b]'], ['Pending review', $summary['pending'], 'Need attention today', 'bg-[#fff3df] text-[#9b681f]'], ['Inactive vendors', $summary['inactive'], 'Not currently visible', 'bg-[#f4e7e5] text-[#a14f47]']] as [$label, $value, $note, $tone])
                <div class="rounded-2xl border border-[#dfe7ec] bg-white p-5 shadow-[0_5px_18px_rgba(18,38,58,0.035)]">
                    <div class="grid h-10 w-10 place-items-center rounded-xl {{ $tone }}"><span class="text-lg">•</span></div>
                    <p class="mt-5 text-xs font-medium text-[#718394]">{{ $label }}</p>
                    <p class="mt-1 font-display text-[26px] font-semibold">{{ number_format($value) }}</p>
                    <p class="mt-1 text-[11px] text-[#9aa9b5]">{{ $note }}</p>
                </div>
            @endforeach
        </div>
        <div class="grid gap-6 xl:grid-cols-[1.4fr_1fr]">
            <div class="rounded-2xl border border-[#dfe7ec] bg-white p-5 shadow-[0_5px_18px_rgba(18,38,58,0.035)]">
                <div class="flex items-start justify-between"><div><p class="text-sm font-semibold">Vendor activity trend</p><p class="mt-1 text-xs text-[#718394]">New and reactivated vendors · last 12 months</p></div><span class="rounded-lg border border-[#dfe7ec] px-2.5 py-1.5 text-[11px] font-semibold text-[#718394]">This year</span></div>
                <div class="mt-8 flex h-44 items-end gap-2">
                    
                @foreach ([38,45,42,58,54,67,62,76,69,82,78,92] as $height)<div class="flex-1 rounded-t-md bg-[#d9e7ee] hover:bg-[#a14f47]" style="height: {{ $height }}%"></div>                
                @endforeach
            
            </div>
                <div class="mt-5 flex items-center justify-between text-[11px] text-[#718394]"><span>New vendors</span><span class="font-semibold text-[#26734b]">+18.6% vs last year</span></div>
            </div>
            <div class="rounded-2xl bg-[#12263a] p-5 text-white shadow-[0_10px_24px_rgba(18,38,58,0.12)]">
                <p class="text-xs text-[#aabccc]">Network sales</p>
                <p class="mt-2 font-display text-3xl font-semibold">${{ number_format($summary['sales']) }}</p>
                <p class="mt-2 text-xs font-semibold text-[#9cd7b3]">↑ 12.8% vs previous month</p>
                <div class="mt-8 border-t border-[#355269] pt-5"><div class="flex justify-between text-xs"><span class="text-[#aabccc]">Quarterly target</span><span>$250,000</span></div><div class="mt-3 h-2 rounded-full bg-[#29465c]"><div class="h-2 w-[74%] rounded-full bg-[#f0b45a]"></div></div></div>
                <div class="mt-7 grid grid-cols-2 gap-3"><div class="rounded-xl bg-[#1b3a52] p-3"><p class="text-[11px] text-[#aabccc]">Today’s leads</p><p class="mt-1 text-xl font-semibold">{{ $summary['leads'] }}</p></div><div class="rounded-xl bg-[#1b3a52] p-3"><p class="text-[11px] text-[#aabccc]">Conversion</p><p class="mt-1 text-xl font-semibold">18.4%</p></div></div>
            </div>
        </div>
        <div class="rounded-2xl border border-[#dfe7ec] bg-white p-5 shadow-[0_5px_18px_rgba(18,38,58,0.035)]">
            <div class="flex items-center justify-between"><div><p class="text-sm font-semibold">Recent vendors</p><p class="mt-1 text-xs text-[#718394]">The latest accounts moving through your workspace.</p></div><a href="" class="text-xs font-semibold text-[#315b80] hover:text-[#a14f47]">View all vendors →</a></div>
            <div class="mt-5 divide-y divide-[#edf1f3]">
                
            @forelse ($recentVendors as $vendor)
            
            <a data-open-vendor="{{ $vendor->id }}" href="" class="flex items-center gap-3 py-3 first:pt-0 last:pb-0 hover:bg-[#fbfcfd]">
                
            <div class="grid h-9 w-9 place-items-center rounded-xl bg-[#e9f2f7] text-xs font-bold text-[#315b80]"></div>
            
            <div class="min-w-0 flex-1"><p class="truncate text-sm font-semibold">{{ $vendor->business_name }}</p><p class="mt-1 text-xs text-[#9aa9b5]">Noida </p></div>
            
            <span class="rounded-full bg-[#e4f4eb] px-2.5 py-1 text-[11px] font-semibold text-[#26734b]">Status</span>
        
            </a>            
            @empty
            
            <p class="py-10 text-center text-sm text-[#718394]">No vendors yet.</p>
            
            @endforelse
        
        
        </div>
        </div>
    </div>
</x-layouts.sales.app>