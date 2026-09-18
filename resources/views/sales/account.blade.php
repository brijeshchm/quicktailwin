@extends('business.business.layouts.app')
@section('title','Account')
@section('content')


@php $tabs=['settings'=>'Account Settings','package'=>'Package','invoices'=>'Invoice History','coins_history'=>'Coins History','transactions'=>'Transactions']; 

@endphp

<div class="animate-fade-in mx-auto max-w-5xl space-y-4 pb-8 md:space-y-6"><div><h1 class="font-display text-xl font-bold md:text-3xl">{{ $tabs[$tab] }}</h1><p class="mt-1 text-sm text-slate-500 md:text-base">Manage your package, limits, and view history.</p></div>

 <div class="flex flex-col justify-between gap-6 rounded-2xl border bg-gradient-to-br from-primary/10 via-background to-background p-6 shadow-sm md:flex-row md:items-center">
    
 <div><p class="text-sm font-medium uppercase tracking-wider text-slate-500">Current Balance</p>
 
 <div class="mt-1 flex items-center gap-2"><i data-lucide="coins" class="h-8 w-8 text-accent"></i><h2 class="font-display text-4xl font-bold">{{ number_format($account['coins']) }}</h2></div>
</div>

<div class="hidden h-16 w-px bg-border md:block"></div>

<div class="flex-1"><p class="mb-1 text-sm font-medium uppercase tracking-wider text-slate-500">Active Package</p><div class="flex flex-wrap items-center gap-2"><span class="badge bg-primary px-3 py-1 text-sm text-white"><i data-lucide="award" class="h-4 w-4"></i>{{ $account['packageName'] }}</span>

@if($account['membershipEndsOn'])

<span class="ml-2 flex items-center gap-1.5 text-sm text-slate-500"><i data-lucide="calendar" class="h-4 w-4"></i>Ends {{ \Carbon\Carbon::parse($account['membershipEndsOn'])->format('d M, Y') }}</span>@endif</div>


</div>


</div>
 <div class="md:hidden"><select onchange="window.location=this.value" class="form-input h-12 bg-white text-base font-medium shadow-sm">
    
 @foreach($tabs as $key=>$label)<option value="{{ route('account',['tab'=>$key]) }}" @selected($tab===$key)>{{ $label }}</option>@endforeach</select></div>



 @if($tab==='settings')


 @php $rows=[['activeStatus','Client Active Status','Active','In-Active',true],['paidStatus','Client Paid Status','Paid','Un-Paid',true],['certifiedStatus','Client Certified Status','Certified','Un-Certified',true],['trustedStatus','Client Trusted Status','Trusted','Un-Trusted',true],['gstStatus','Client GST Status','GST Business','NO GST Business',true],['pauseLeads','Pausing/Resuming the lead','Paused','Receiving Leads',false]]; @endphp

 <div class="card overflow-hidden">
    
    @foreach($rows as [$key,$label,$on,$off,$positive])
    
    @php $value=(bool)($account[$key]??false);$green=$positive?$value:!$value; @endphp
    
    <div  class="flex items-center justify-between border-b p-4 transition last:border-0 hover:bg-secondary/20 sm:p-5">@csrf
        
 
    
    <span class="text-sm font-medium sm:text-base">{{ $label }}</span>
    
    <button class="whitespace-nowrap rounded-md border px-3 py-1.5 text-xs font-bold uppercase tracking-wider shadow-sm {{ $green?'border-emerald-200 bg-emerald-100 text-emerald-700':'border-red-200 bg-destructive/10 text-destructive' }}">{{ $value?$on:$off }}</button>


</div>
    @endforeach
    
    <div class="flex items-center justify-between p-4 sm:p-5"><span class="text-sm font-medium sm:text-base">Membership Type</span><span class="badge border border-primary/20 bg-primary/5 px-3 py-1 text-primary">{{ $account['packageName'] }}</span></div>

</div>

 @elseif($tab==='package')


 <div class="space-y-6"><div class="card">
    
 <div class="border-b px-6 py-4">
    
 <h2 class="font-display text-lg font-semibold">Package Details</h2></div>
 
 <div class="grid gap-6 p-6 md:grid-cols-3"><div>
    
 <p class="mb-1 text-sm font-medium text-slate-500">Membership Type</p>
 
 <p class="font-semibold">{{ $account['packageName'] }}</p></div><div>
    
 <p class="mb-1 text-sm font-medium text-slate-500">Membership Ends On</p>
 
 <p class="font-semibold">{{ $account['membershipEndsOn']?\Carbon\Carbon::parse($account['membershipEndsOn'])->format('d M, Y'):'N/A' }}</p></div><div><p class="mb-1 text-sm font-medium text-slate-500">Remaining Coins</p><p class="font-semibold text-primary">{{ number_format($account['coins']) }}</p></div></div>

</div>


 <div class="card">
    
 <div class="border-b px-6 py-4">
    
 <h2 class="font-display text-lg font-semibold">Buy Details</h2></div>
 
 <div class="p-6"><div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    
 @foreach($data as $pkg)



 



 <div class="group relative flex flex-col items-center overflow-hidden rounded-xl border bg-white p-5 text-center shadow-sm transition hover:border-primary/50"><span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-primary/40 to-accent/50"></span><span class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary"><i data-lucide="coins" class="h-6 w-6"></i></span><h4 class="font-display text-2xl font-bold">₹{{ number_format($pkg['amt']) }}</h4><p class="mb-5 mt-1 text-sm text-slate-500">Get <span class="font-semibold text-foreground">{{ number_format($pkg['coins']) }}</span> Coins</p>
 
 
 <div class="mt-auto w-full" onsubmit="return confirm('Buy this coin package? 18% GST will be added.')">
 
   <a href="{{url('business/pay-deposit/?status=correction&o='.$pkg['encrypt'])}}" class="btn btn-primary w-full">
  {{ $pkg['package_bottom'] }}
  </a>
 


</div>

</div>
 @endforeach


 
</div><p class="mt-6 text-center text-xs italic text-slate-500">* Note: 18% GST extra on above packages.</p></div></div>

</div>
 @elseif($tab==='invoices')


 <div class="card overflow-hidden">
    
 <div class="flex items-center gap-2 border-b px-6 py-4"><i data-lucide="receipt" class="h-5 w-5 text-primary"></i><h2 class="font-display text-lg font-semibold">Invoice History</h2></div>
 
 <div class="hidden overflow-x-auto md:block">
    
 
 <table class="w-full min-w-[650px] text-left text-sm"><thead class="border-b bg-secondary/50 text-slate-500"><tr><th class="px-6 py-4 font-medium">Date</th><th class="px-6 py-4 font-medium">Paid Amount</th><th class="px-6 py-4 font-medium">GST (18%)</th><th class="px-6 py-4 text-right font-medium">Total Amount</th><th class="px-6 py-4 text-right font-medium">Invoice</th></tr></thead><tbody class="divide-y">
    
 @php
 
 
 @endphp
 @forelse($invoices->getCollection() as $inv)
 
 
 <tr class="hover:bg-secondary/20"><td class="px-6 py-4 text-slate-500"> 
 
 {{ date_format(date_create($inv->created_at), 'd M Y') }}</td><td class="px-6 py-4">₹{{ number_format($inv['paid_amount']) }}</td><td class="px-6 py-4">₹{{ number_format($inv['gst_tax']) }}</td><td class="px-6 py-4 text-right font-bold">₹{{ number_format($inv['total_amount']) }}</td><td class="px-6 py-4 text-right">
    
 
 <a href="{{ route('invoice.billing.pdf',$inv['id']) }}" class="inline-flex items-center gap-1.5 font-medium text-primary hover:underline"><i data-lucide="download" class="h-4 w-4"></i>Download</a>

</td></tr>

@empty

<tr><td colspan="5" class="p-8 text-center text-slate-500">No invoices found.</td></tr>@endforelse</tbody></table></div><div class="divide-y md:hidden">
    
 
 @foreach($invoices as $inv)
 
 
 
 <div class="space-y-3 p-4"><div class="flex items-start justify-between">
    
 
 <div><span class="block font-semibold">{{ date_format(date_create($inv->created_at), 'd M Y') }}</span><span class="text-xs text-slate-500">Invoice #{{ $inv['id'] }}</span>

</div>
 
 
 <span class="font-display text-lg font-bold">₹{{ number_format($inv['total_amount']) }}</span></div>
 
 
 <div class="flex justify-between rounded-lg border bg-secondary/30 p-2 text-sm text-slate-500"><span>Paid: <b class="text-foreground">₹{{ number_format($inv['paid_amount']) }}</b></span>
 
 
 
 <span>GST: <b class="text-foreground">₹{{ number_format($inv['gst_tax']) }}</b></span></div>
 
 
 <div class="flex justify-end">
    
 
 <a href="{{ route('invoice.download',$inv['id']) }}" class="btn btn-outline h-9 border-primary/20 bg-primary/5 text-primary"><i data-lucide="download" class="h-4 w-4"></i>Download Invoice</a>


</div>

</div>
 
 
 @endforeach


</div></div>




 {{-- PAGINATION --}}
        @if(method_exists($invoices, 'links'))

            <div
                id="locationPagination"
                class="border-t px-5 py-4"
            >

                {{ $invoices->appends([
                    'tab' => 'invoices'
                ])->links() }}

            </div>

        @endif

 @elseif($tab==='coins_history')
 <div class="card overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center gap-2 border-b px-6 py-4">

        <i
            data-lucide="history"
            class="h-5 w-5 text-primary"
        ></i>

        <h2 class="font-display text-lg font-semibold">
            Coins Usage History
        </h2>

    </div>


    {{-- Records --}}
    <div class="divide-y divide-slate-200">

        @forelse($coinUsage as $cu)

            @php
               
                $isCredit = !empty($cu->scrapLead ?? null);
            @endphp


            <div
                class="flex flex-col justify-between gap-3 p-4 transition hover:bg-secondary/20 sm:flex-row sm:items-center sm:p-4"
            >

                {{-- Lead Information --}}
                <div class="min-w-0 flex gap-3">

                    <p class="truncate font-semibold text-slate-900">
                        {{ $cu->name ?? '' }}
                    </p>
                    <p class="truncate font-semibold text-slate-900">
                        {{ $cu->kw_text ?? '' }}
                    </p>


                    @if(!empty($cu->created))

                        <p class="mt-1 text-xs text-slate-500">

                            {{ \Carbon\Carbon::parse($cu->created)->format('d M Y, g:i A') }}

                        </p>

                    @endif

                </div>


                {{-- Coins --}}
                <span
                    class="self-start whitespace-nowrap rounded-lg px-3 py-1.5 font-display text-sm font-bold sm:self-auto
                    {{ $isCredit
                        ? 'bg-emerald-50 text-emerald-600'
                        : 'bg-red-50 text-red-600'
                    }}"
                >

                    {{ $isCredit ? '+' : '-' }}{{ $cu->coins ?? 0 }} Coins

                </span>

            </div>


        @empty

            <div class="p-10 text-center">

                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400"
                >

                    <i
                        data-lucide="history"
                        class="h-5 w-5"
                    ></i>

                </div>


                <p class="mt-3 text-sm font-medium text-slate-600">
                    No records found
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    Your coins usage history will appear here.
                </p>

            </div>

        @endforelse

    </div>



    {{-- Pagination --}}
    @if(method_exists($coinUsage, 'links') && $coinUsage->hasPages())

        <div
            id="coinPagination"
            class="border-t border-slate-200 px-5 py-4"
        >

            {{ $coinUsage->appends([
                'tab' => 'coins_history'
            ])->links() }}

        </div>

    @endif

</div>



 @elseif($tab==='transactions')
 <div class="card overflow-hidden"><div class="border-b px-6 py-4"><h2 class="font-display text-lg font-semibold">Ledger & Bonuses</h2></div><div class="divide-y">
    
 @forelse(collect($transactions)->sortByDesc('createdAt') as $i=>$tx)
 
 <div class="animate-slide-up stagger-{{ ($i%5)+1 }} flex items-center justify-between p-4 transition hover:bg-secondary/30 sm:p-6">
    
 <div class="flex items-center gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $tx['type']==='purchase'?'bg-emerald-100 text-emerald-600':($tx['type']==='bonus'?'bg-accent/20 text-accent':'bg-destructive/10 text-destructive') }}"><i data-lucide="{{ $tx['type']==='purchase'?'arrow-up-right':($tx['type']==='bonus'?'zap':'arrow-down-right') }}" class="h-5 w-5"></i></span>
 
 <div><p class="text-sm font-medium sm:text-base">{{ $tx['description'] }}</p><p class="mt-0.5 text-xs text-slate-500">{{ \Carbon\Carbon::parse($tx['createdAt'])->format('M j, Y g:i A') }}</p></div>

</div>
 
 <div class="shrink-0 font-display text-lg font-semibold {{ $tx['amount']>0?'text-emerald-600':'' }}">{{ $tx['amount']>0?'+':'' }}{{ number_format($tx['amount']) }}</div>

</div>
 @empty
 
 <div class="p-8 text-center text-slate-500">No transactions yet.</div>
 
 @endforelse

</div>

</div>
 @endif
</div>
@endsection
