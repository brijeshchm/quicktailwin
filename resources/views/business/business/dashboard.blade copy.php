@extends('business.business.layouts.app')
@section('title','Overview')
@section('content')
<div class="animate-fade-in space-y-6 pb-8 md:space-y-8">
    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end"><div><h1 class="font-display text-xl font-bold tracking-tight md:text-3xl">Overview</h1><p class="mt-1 text-sm text-slate-500 md:text-base">Here's what's happening with your business today.</p></div><a href="{{ route('listings') }}#new-listing" class="btn btn-primary"><i data-lucide="plus" class="h-4 w-4"></i>New Listing</a></div>


    @php $metrics=[['Profile Views',number_format($stats['profileViews']),$stats['viewsChangePct'],'eye'],['Total Leads',number_format($stats['totalLeads']),$stats['leadsChangePct'],'message-square'],['Total Calls',number_format($stats['totalCalls']),null,'phone'],['Avg Rating',number_format($stats['avgRating'],1),null,'star']]; @endphp


        <div class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-6">
        
    @foreach($metrics as $i=>$m)
        <div class="card animate-slide-up stagger-{{ $i+1 }} group relative overflow-hidden">
            
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 transition group-hover:opacity-100"></div>
        
        <div class="relative flex flex-col gap-4 p-5">
            
        <div class="flex items-center justify-between"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary"><i data-lucide="{{ $m[3] }}" class="h-5 w-5"></i></span>
        @if($m[2]!==null)
        <span class="badge {{ $m[2]>=0?'bg-emerald-100 text-emerald-700':'bg-destructive/10 text-destructive' }}"><i data-lucide="{{ $m[2]>=0?'arrow-up-right':'arrow-down-right' }}" class="h-3 w-3"></i>{{ abs($m[2]) }}%</span>@endif</div><div><p class="text-sm font-medium text-slate-500">{{ $m[0] }}</p><h3 class="mt-1 font-display text-2xl font-bold">{{ $m[1] }}</h3></div></div>

        </div>

    @endforeach

    </div>
   
	  <div class="grid grid-cols-2 gap-3 md:grid-cols-5 md:gap-6">
      

    @php
        $tiles = [
            ['icon' => 'users',          'count' => $monthsFollow['total_leads'],     'label' => 'Total Leads',    'color' => 'text-gray-800'],
            ['icon' => 'gauge',          'count' => $monthsFollow['interested'],      'label' => 'Interested',     'color' => 'text-green-600'],
            ['icon' => 'phone-call',     'count' => $monthsFollow['follow_up'],       'label' => 'Follow Up',      'color' => 'text-gray-600'],
            ['icon' => 'phone-call',      'count' => $monthsFollow['calling_visits'],  'label' => 'Pending Follow Up', 'color' => 'text-red-800'],
           
            ['icon' => 'graduation-cap', 'count' => $monthsFollow['joined'],          'label' => 'Joined',         'color' => 'text-gray-800'],
        ];
    @endphp

    @foreach ($tiles as $tile)

      <div class="grid mb-6">
        <div class="animate-flipInY bg-white rounded-lg shadow-sm border border-gray-100 p-3 flex flex-col items-center text-center hover:shadow-md transition-shadow duration-200">
            <div class="text-blue-500 mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                <i data-lucide="{{ $tile['icon'] }}" class="w-8 h-8"></i>
            </div>

            <div class="text-3xl font-bold {{ $tile['color'] }}">
                {{ $tile['count'] }}
            </div>

            <h3 class="mt-2 text-sm font-semibold text-gray-600">
                {{ $tile['label'] }}
                <small class="block text-xs text-gray-400 mt-0.5">
                    (in {{ now()->format('M Y') }})
                </small>
            </h3>
        </div>
        </div>
    @endforeach

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
    

    </div>
	
    <div class="card" x-data="followupManager()">
        
    <div class="flex items-center justify-between border-b px-6 py-4"><h2 class="font-display text-lg font-semibold">Follow Leads</h2><a href="{{ route('leads') }}" class="text-sm font-medium text-primary hover:underline">View All</a></div>
 
	<div class="divide-y border-b p-3 sm:p-6">
@forelse($leads->getCollection() as $lead)

@php
    // FIX #1: match on the RAW lead id (lead_id), not the assignment id ($lead['id']).
   $leadFus  = $followups->where('lead_id', $lead->lead_id)->whereNotNull('notes')
        ->where('notes', '!=', '');
    // FIX #2: 'status' isn't a key on the followups array — the boolean is 'done'.
    $pending  = '';
    $overdue  = "";
    $assignee = "";
    $followDate = \Carbon\Carbon::parse($lead->expected_date_time)->startOfDay();
    $today = \Carbon\Carbon::today();
    $pastDays = $followDate->lt($today)
    ? $followDate->diffInDays($today)
    : 0;

  @endphp
    <div class="flex flex-col items-start justify-between gap-4 p-4 md:flex-row md:items-center md:p-6">
        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary/10 font-display font-bold text-primary">
                {{ strtoupper(substr($lead->name, 0, 1)) }}
            </span>
            <div>
                <h3 class="font-semibold">{{ ucfirst($lead->name) }}</h3>
                <p class="mt-0.5 text-sm text-slate-500">{{ $lead->kw_text }} · {{ $lead->mobile }}</p>
                <p class="mt-1 line-clamp-1 text-sm">{!! $lead->remarks !!}</p>
                <p class="mt-1 line-clamp-1 text-sm">{{ ($lead->expected_date_time==NULL)?"":get_time(strtotime($lead->expected_date_time)) }} ago</p>
            </div>
        </div>
        <div class="flex w-full gap-2 md:w-auto">
            <a href="tel:{{ preg_replace('/[^+\d]/', '', $lead->mobile) }}" class="btn btn-outline flex-1">
                <i data-lucide="phone" class="h-4 w-4"></i>Call
            </a>
            <a href="{{ route('leads') }}" class="btn btn-primary flex-1">Open</a>

            <button
 type="button"
 @click="openFollowupAt({{ $loop->index }})"
 class="btn h-8 rounded-lg px-3 text-xs bg-emerald-500 text-white hover:bg-emerald-600 {{ $overdue ? 'border-destructive text-destructive bg-emerald-500' : ($pending ? 'border-primary text-primary bg-emerald-500' : '') }}">
 <i data-lucide="eye" class="h-3.5 w-3.5"></i>Follow up
 
</button>

        </div>

         
    </div>




     @if(!empty($leadFus))
      <details class="mt-3 rounded-xl border bg-white/70">
       <summary class="cursor-pointer px-4 py-2 text-xs font-semibold text-slate-500">View Follow Up ({{ $leadFus->count() }})</summary>
       <div class="space-y-2 border-t p-3">
        @foreach($leadFus as $fu)
         <div class="flex items-start justify-between gap-3 rounded-lg bg-secondary/40 p-3">
          <div>
           <p class="text-sm {{ $fu['outcome'] == 'Joined'? 'line-through text-slate-400' : '' }}">{{ $fu['notes'] }}</p>
           <p class="mt-1 text-xs text-slate-500"><strong>Tag: </strong>{{ ucfirst($fu['outcome']) }} &middot; <strong>Next Date:</strong> {{ $fu['dueAt'] ? \Carbon\Carbon::parse($fu['dueAt'])->format('M j, g:i A') : 'No due date' }}</p>
          </div>
          <div class="flex gap-1">
         
            <input type="hidden" name="Joined" value="{{ $fu['outcome'] =='Joined' ? 0 : 1 }}">
            <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-emerald-600"><i data-lucide="check" class="h-4 w-4"></i></button>
          
          
          </div>
         </div>
        @endforeach
       </div>
      </details>
     @endif
@empty
    <div class="p-8 text-center text-slate-500">You're all caught up. No new leads waiting.</div>
@endforelse
</div>
	 
	 
	  <div class="pt-2">
  {{ $leads->links() }}
 </div>
	
	</div>
	
	
	
	 <div class="grid gap-6 md:grid-cols-3">
        <div class="card md:col-span-2"><div class="border-b bg-secondary/20 px-6 py-5"><h2 class="font-display text-lg font-semibold">Performance Trend (30 Days)</h2></div>
		
		<div class="h-[300px] p-6"><canvas id="performanceChart"></canvas></div></div>
		
        <div class="card flex flex-col">
		
		<div class="flex items-center justify-between border-b bg-secondary/20 px-6 py-4">
		
		<h2 class="flex items-center gap-2 font-display text-lg font-semibold">
		
		<i data-lucide="activity" class="h-4 w-4 text-primary"></i>Pending Follow Up</h2></div>
		
		
		<div class="h-[300px] space-y-4 overflow-y-auto p-4">
            @if($recentActivity)
        @foreach($recentActivity as $a)
        
        <div class="flex gap-3">
            
        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-secondary"><i data-lucide="message-square" class="h-4 w-4 text-primary"></i></span>
        
        <div class="flex-1 border-b pb-4 last:border-0"><p class="text-sm leading-snug">{{ $a->remark }}</p>
        <p class="mt-1 text-xs text-slate-500">{{ \Carbon\Carbon::parse($a->expected_date_time)->format('M j, g:i A') }}</p>
    
        <p class="mt-1 text-xs text-slate-500">{{ $a->status_name }}</p>
    
        </div>
    
    </div>
        

        @endforeach
    @endif
    
    </div></div>
		
		
    </div>
	
	
</div>

<template x-teleport="body">

    <div
        x-cloak
        x-show="followup"
        x-transition.opacity
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
    >

        {{-- Background overlay only --}}
        <div class="absolute inset-0 bg-slate-950/40"></div>


        {{-- Actual popup --}}
        <div
            class="relative z-[10000] flex
               h-auto max-h-[95dvh]
               w-full max-w-4xl
               min-w-0
               flex-col overflow-hidden
               rounded-xl bg-white shadow-2xl
               sm:max-h-[90vh] sm:rounded-2xl"
        >

            <!-- Header -->
            <div class="flex shrink-0 items-center justify-between border-b border-gray-200 bg-white p-4 sm:p-5">

                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <h2
                            class="truncate font-display text-lg font-semibold text-slate-900 sm:text-xl"
                            x-text="followupName || 'Add Follow-Up'"
                        ></h2>

                        <span
                            x-show="leads.length"
                            x-text="(currentIndex + 1) + ' / ' + leads.length"
                            class="shrink-0 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600"
                        ></span>
                    </div>

                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 sm:text-sm">
                        <span class="flex items-center gap-1.5" x-show="followupEmail">
                            <i data-lucide="mail" class="h-3.5 w-3.5"></i>
                            <span x-text="followupEmail"></span>
                        </span>

                        <span class="flex items-center gap-1.5" x-show="followupMobile">
                            <i data-lucide="phone" class="h-3.5 w-3.5"></i>
                            <span x-text="followupMobile"></span>
                        </span>

                        <span class="flex items-center gap-1.5" x-show="followupService">
                            <i data-lucide="tag" class="h-3.5 w-3.5"></i>
                            <span x-text="followupService"></span>
                        </span>
                    </div>
                </div>

                <div class="ml-3 flex shrink-0 items-center gap-1">
                    <button
                        type="button"
                        @click="previousLead()"
                        :disabled="currentIndex <= 0"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-60 disabled:cursor-not-allowed disabled:opacity-40"
                        title="Previous Lead"
                    >
                        <i data-lucide="chevron-left" class="h-4 w-4"></i>
                        Previous
                    </button>

                    <button
                        type="button"
                        @click="nextLead()"
                        :disabled="currentIndex >= leads.length - 1"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-60 disabled:cursor-not-allowed disabled:opacity-40"
                        title="Next Lead"
                    >
                        <i data-lucide="chevron-right" class="h-4 w-4"></i>

                        Next
                    </button>

                    <button
                        type="button"
                        @click="closeFollowup()"
                        class="ml-1 flex h-9 w-9 items-center justify-center rounded-lg bg-secondary text-slate-600 hover:bg-slate-200"
                        title="Close"
                    >
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>

            </div>


            <!-- Scrollable Content -->
            <div
                class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-5"
            >

                <form
                    :action="'/business/leads/' + followup + '/follow-ups'"
                    method="POST"
                    id="followup-form"
                    data-after-save="stay"
                    class="space-y-4"
                    @submit.prevent="
                        (async () => {
                            const form = $event.target;
                            const action = form.dataset.afterSave || 'stay';

                            const saved = await enquiryController.storeFollowUp(
                                followup,
                                form
                            );

                            form.dataset.afterSave = 'stay';

                            if (saved && action === 'next') {
                                nextLead();
                            }
                        })()
                    "
                >

                    @csrf

                    <input
                        type="hidden"
                        name="lead_id"
                        x-bind:value="followupLeadId"
                    >


                    <div class="grid gap-4 sm:grid-cols-2">

                        <!-- Status -->
                        <div>

                            <label
                                class="mb-2 block text-sm font-medium text-slate-700" >
                                Status
                            </label>

                        <select
                            name="status"
                            id="followup_status"
                            class="form-input"
                            x-model.number="followupStatusid"
                            @change="toggleFollowUpDate($event.target)"
                        >
                            <option value="">Select Status</option>
                            @foreach($statues as $status)
                                <option value="{{ $status->id }}" data-name="{{ strtolower(trim($status->name)) }}">
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>

                        </div>


                        <!-- Follow-up Date -->
                        <div class="flex items-end gap-2">

                            <div class="min-w-0 flex-1">

                                <label
                                    class="mb-2 block text-sm font-medium
                                           text-slate-700"
                                >
                                    Next Follow up Date
                                </label>

                                <input
                                    type="date"
                                    name="expected_date_time"
                                    id="expected_date_time"
                                    class="form-input"
                                    onclick="setFollowUpDate(this)"
                                    onfocus="setFollowUpDate(this)"
                                    placeholder="Select Date Follow-Up"
                                >

                            </div>

 

                        </div>

                    </div>


                    <!-- Notes -->
                    <div>

                        <label
                            class="mb-2 block text-sm font-medium
                                   text-slate-700"
                        >
                            Notes
                            <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            name="remark"
                            class="form-input form-textarea"
                            placeholder="Notes about the call..."
                        ></textarea>

                    </div>


                    <!-- Navigation + Save -->
                    <div class="flex justify-end border-t border-slate-200 pt-4">

    <div class="flex gap-2">

        <button
            type="submit"
            @click="$el.form.dataset.afterSave = 'next'"
            :disabled="currentIndex >= leads.length - 1"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
        >
            Save & Next

            <i
                data-lucide="arrow-right"
                class="h-4 w-4"
            ></i>

        </button>

    </div>

</div>

                </form>


                <!-- Follow Up History -->
                <div
                    class="mt-5 border-t border-gray-200 pt-4"
                >

                    <div
                        class="mb-3 flex items-center
                               justify-between gap-3"
                    >

                        <p
                            class="text-sm font-semibold
                                   text-gray-800"
                        >
                            Follow Up Status
                        </p>


                        <select
                            class="follow-up-count rounded-lg
                                   border border-gray-300 bg-white
                                   px-3 py-2 text-sm text-gray-700
                                   shadow-sm outline-none transition
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-500/20"

                            @change="
                                enquiryController.getAllFollowUps(
                                    followupLeadId,
                                    $event.target.value
                                )
                            "
                        >

                            <option value="5">
                                Last 5
                            </option>

                            <option value="all">
                                All
                            </option>

                        </select>

                    </div>


                    <!-- Table -->
                    <div
                        class="max-h-[300px] overflow-auto
                               rounded-xl border border-gray-200
                               bg-white shadow-sm"
                    >

                        <table
                            id="datatable-enquiry-followups"
                            class="min-w-full divide-y
                                   divide-gray-200 text-sm"
                        >

                            <thead
                                class="sticky top-0 z-10 bg-gray-50"
                            >

                                <tr>

                                    <th
                                        class="whitespace-nowrap
                                               px-4 py-3 text-left
                                               font-semibold
                                               text-gray-700"
                                    >
                                        Date
                                    </th>

                                    <th
                                        class="px-4 py-3 text-left
                                               font-semibold
                                               text-gray-700"
                                    >
                                        Remark
                                    </th>

                                    <th
                                        class="whitespace-nowrap
                                               px-4 py-3 text-left
                                               font-semibold
                                               text-gray-700"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="whitespace-nowrap
                                               px-4 py-3 text-left
                                               font-semibold
                                               text-gray-700"
                                    >
                                        Follow Date
                                    </th>

                                </tr>

                            </thead>


                            <tbody
                                id="enquiry-followups-body"
                                class="divide-y divide-gray-100 bg-white"
                            >
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>
@php 

// dd($leads->items());
 
$statusClass=['new'=>'border-blue-200 bg-blue-50 text-blue-700','contacted'=>'border-amber-200 bg-amber-50 text-amber-700','converted'=>'border-emerald-200 bg-emerald-50 text-emerald-700','closed'=>'border-slate-200 bg-slate-100 text-slate-600'];

// Leads available inside the Follow-Up popup on the current Laravel pagination page.
$popupLeadSource = method_exists($leads, 'items') ? $leads->items() : $leads;
$popupLeads = collect($popupLeadSource)->map(function ($lead) {


    return [
        'assign_id' => (int) $lead->assign_id,
        'lead_id' => (int) $lead->lead_id,
        'name' => $lead->name ?? '',
        'email' => $lead->email ?? '',
        'mobile' => $lead->mobile ?? '',
        'service' => $lead->kw_text ?? '',
        'status_id' => (int) ($lead->status ?? 0),
    ];
})->values();
@endphp

 

<script>
window.followupManager = function () {
    return {
        followup: null,
        followupLeadId: null,
        followupName: '',
        followupEmail: '',
        followupMobile: '',
        followupService: '',
        followupStatusid: null,
        currentIndex: -1,
        leads: @js($popupLeads),

        openFollowupAt(index) {
            this.loadLead(index);
        },

        loadLead(index) {
            if (index < 0 || index >= this.leads.length) return;

            const lead = this.leads[index];

            this.currentIndex = index;
            this.followup = lead.assign_id;
            this.followupLeadId = lead.lead_id;
            this.followupName = lead.name || '';
            this.followupEmail = lead.email || '';
            this.followupMobile = lead.mobile || '';
            this.followupService = lead.service || '';
            this.followupStatusid = Number(lead.status_id || 0);

            this.$nextTick(() => {
                const form = document.getElementById('followup-form');
                const select = document.getElementById('followup_status');
                const dateInput = document.getElementById('expected_date_time');
                const countSelect = document.querySelector('.follow-up-count');

                // Remove previous lead validation/message and unsaved note/date.
                if (form) {
                    form.querySelectorAll('.validation-error').forEach(el => el.remove());
                    form.querySelector('.followup-form-message')?.remove();

                    const remark = form.querySelector('[name=remark]');
                    if (remark) remark.value = '';

                    form.dataset.afterSave = 'stay';
                }

                if (select) {
                    select.value = String(lead.status_id || '');
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                }

                if (dateInput) {
                    dateInput.value = '';
                    dateInput.min = getLocalDateTime();
                }

                if (countSelect) countSelect.value = '5';

                if (window.lucide) lucide.createIcons();
                enquiryController.getAllFollowUps(lead.lead_id, 5);
            });
        },

        previousLead() {
            if (this.currentIndex <= 0) return;
            this.loadLead(this.currentIndex - 1);
        },

        nextLead() {
            if (this.currentIndex >= this.leads.length - 1) return;
            this.loadLead(this.currentIndex + 1);
        },

        closeFollowup() {
            this.followup = null;
            this.currentIndex = -1;
        }
    };
};
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>const chartEl=document.getElementById('performanceChart');

if(chartEl){ 
    
    new Chart(chartEl,
    
    {type:'line',data:{
        
        labels:@json(array_column($series,'date')),
        datasets:[{label:'Views',data:@json(array_column($series,'views')),
        borderColor:'hsl(230,90%,55%)',backgroundColor:'rgba(62,83,238,.14)',
        fill:true,tension:.4,borderWidth:3,pointRadius:0}]},
        
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{display:false},ticks:{maxTicksLimit:7}},y:{beginAtZero:false,grid:{color:'rgba(148,163,184,.18)'}}}}});}
        
        </script>
 

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
input[type="date"] {
position: relative;
}
input[type="date"]::-webkit-calendar-picker-indicator {
position: absolute;
inset: 0;
width: 100%;
height: 100%;
opacity: 0;
cursor: pointer;
}
</style>
 

<script>
document.addEventListener('DOMContentLoaded', function () {
    

    flatpickr("#expected_date_time", {
    dateFormat: "d-m-Y",
    minDate: "today",
});

});
</script>

@endsection
