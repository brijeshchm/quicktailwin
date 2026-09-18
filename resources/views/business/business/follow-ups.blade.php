@extends('business.business.layouts.app')
@section('title','Follow-ups')
@section('content')
@php

$pending="";
$done="";
$overdue="";
@endphp
<div class="animate-fade-in space-y-5 md:space-y-6">
 <div class="grid grid-cols-2 gap-3 md:grid-cols-6">
    
 <div class="card p-4"><p class="text-xs font-semibold uppercase tracking-wider text-slate-500">All Activity</p>
 
 <p class="mt-2 font-display text-2xl font-bold">{{ $followList['total_leads'] }}</p>
</div>

<div class="card p-4"><p class="text-xs font-semibold uppercase tracking-wider text-slate-500">New Lead</p><p class="mt-2 font-display text-2xl font-bold text-emerald-600">{{ $followList['new_lead'] }}</p></div>

<div class="card p-4"><p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Interested</p><p class="mt-2 font-display text-2xl font-bold text-primary">{{ $followList['interested'] }}</p></div>

<div class="card p-4"><p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending</p><p class="mt-2 font-display text-2xl font-bold text-destructive">{{ $followList['pending'] }}</p></div>

<div class="card p-4"><p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Overdue</p><p class="mt-2 font-display text-2xl font-bold text-destructive">{{ $followList['overdue'] }}</p></div>

<div class="card p-4"><p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Completed</p><p class="mt-2 font-display text-2xl font-bold text-emerald-600">{{ $followList['joined'] }}</p></div>

</div>
 <div class="card p-4">

    <form method="GET" class="flex flex-col gap-3 lg:flex-row lg:items-end">

        <div class="hide-scrollbar flex flex-1 flex-col gap-3 overflow-x-auto rounded-xl bg-secondary p-3 sm:flex-row sm:items-end">
 

            {{-- Date From --}}
            <div class="flex flex-col gap-1">
                <label for="date_from" class="text-xs font-medium text-gray-600">
                    Date from follow-up
                </label>       

                <input 
                type="text"
                name="date_from"
                id="date_from"
                value="{{ request('date_from') }}"
                class="form-input lg:w-56 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Select date From"
            >
            </div>

            {{-- Date To --}}
            <div class="flex flex-col gap-1">
                <label for="date_to" class="text-xs font-medium text-gray-600">
                    Date to follow-up
                </label>
                <input
                type="text"
                name="date_to"               
                id="date_to"
                value="{{ request('date_to') }}"
                class="form-input lg:w-56 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Select date To"
                      
                >
            </div>

            {{-- Status --}}
            <div class="flex flex-col gap-1">
                <label for="status" class="text-xs font-medium text-gray-600">
                    Status
                </label>
                <select name="status" id="status" class="form-input lg:w-56">
                    <option value="">Select Status</option>
                    @if($statues)
                    @foreach($statues as $tag)
                        <option value="{{ $tag->id }}" @selected(request('status') == $tag->id)>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                    @endif
                </select>
            </div>

        </div>

        {{-- Action buttons --}}
        <div class="flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="filter" class="h-4 w-4"></i> Filter
            </button>

            @if(request('date_from') || request('date_to') || request('status'))
                <a href="{{ route('followups') }}" class="btn btn-outline">
                    <i data-lucide="filter-x" class="h-4 w-4"></i> Clear
                </a>
            @endif
        </div>

    </form>

</div>



 <div class="space-y-3">
    
@php 
$filters=['all','new','contacted','converted','favorites','archived'];
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

<div class="animate-fade-in space-y-4 md:space-y-6" x-data="followupManager()">
 <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-end">
 
  <div class="hide-scrollbar flex w-full shrink-0 snap-x overflow-x-auto rounded-xl bg-secondary p-1 xl:w-auto">
  
  </div>
 </div>

 <div class="space-y-4"> 
 @forelse($leads as $i => $lead)
  @php
 
//   dd($lead->lead_id);
   // FIX #1: match on the RAW lead id (lead_id), not the assignment id ($lead['id']).
   $leadFus  = $followups->where('lead_id', $lead->lead_id)->whereNotNull('notes')
        ->where('notes', '!=', '');
 
   // FIX #2: 'status' isn't a key on the followups array — the boolean is 'done'.
 
 
   $assignee = "";
 
 
    $pending = '';
    $overdue = false;
    $pastDays = 0;

  if (!empty($lead->expected_date_time)) {
        $followDate = \Carbon\Carbon::parse($lead->expected_date_time)->startOfDay();
        $today = \Carbon\Carbon::today();
        $overdue = $followDate->lt($today);
        $pastDays = $overdue ? $followDate->diffInDays($today) : 0;
    }
  @endphp
  <div class="card animate-slide-up stagger-{{ ($i % 5) + 1 }} relative overflow-hidden {{ $lead->favorite_lead ? 'opacity-70 grayscale-[20%]' : '' }} {{ $lead->readLead == '0' ? 'assignedLeadsClick cursor-pointer bg-gray-200' : '' }}" data-assigned-id="{{ $lead->assign_id }}" data-client-id="{{ $lead->client_id }}" >
 
   <div class="flex flex-col lg:flex-row">
    <div class="flex-1 border-b p-3 sm:p-6 lg:border-b-0 lg:border-r">
     <div class="mb-3 flex flex-row flex-wrap items-start justify-between gap-2 sm:mb-4 sm:gap-3">
      <div class="min-w-0 flex-1">
       <div class="mb-1 flex items-center gap-2">
        <h3 class="truncate font-display text-lg font-semibold sm:text-xl">{{ ucfirst($lead->name) }}</h3>
        @if($lead->favorite_lead)<i data-lucide="star" class="h-4 w-4 fill-amber-500 text-amber-500"></i>@endif
       </div>
       <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 sm:mt-2 sm:text-sm">
        <span class="flex items-center gap-1.5"><i data-lucide="phone" class="h-3.5 w-3.5"></i>{{ $lead->mobile }}</span>
        @if($lead->email)<span class="flex items-center gap-1.5"><i data-lucide="mail" class="h-3.5 w-3.5"></i>{{ $lead->email }}</span>@endif
       </div>
      </div>

      <div class="flex shrink-0 items-center gap-2">  
  <div class="flex items-center gap-1 text-sm font-medium">
    <i data-lucide="indian-rupee" class="h-4 w-4"></i>
     
    @if(!empty($lead->scrapLead))
        <span class="text-green-600">
            {{ $lead->coins }}
        </span>

    @elseif(!empty($lead->coins))
        <span class="text-red-600">
            -{{ $lead->coins }}
        </span>
    @endif
</div>

        @if(!$lead->favorite_lead)
        <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-secondary hover:text-amber-500 {{  !$lead->favorite_lead ?'favorited':'' }}" data-favoritleads="{{ $lead->assign_id }}" data-client-id="{{ $lead->client_id }}" title="Favorite"><i data-lucide="star" class="h-4 w-4"></i></button>
        @endif
 
      </div>
     </div>

     <div class="mt-3 rounded-xl bg-secondary/30 p-3 sm:mt-4 sm:p-4">
      <div class="mb-2 flex items-start justify-between gap-2">
       <p class="flex items-center gap-2 text-xs font-semibold tracking-wider text-slate-500"><i data-lucide="clock" class="h-3.5 w-3.5"></i>Inquiry for: {{ $lead->kw_text }}</p>
       <span class="badge border capitalize bg-secondary text-slate-600">{{ $lead->status_name ?? $lead->status_name }}</span>
      </div>
      <p class="text-xs leading-relaxed text-slate-800 sm:text-sm">&ldquo;{!! $lead->remarks !!}&rdquo;</p>

        @if(!empty($lead->expected_date_time))
        <p class="mt-1 text-xs text-slate-500">
        {{ get_time(strtotime($lead->expected_date_time)) }} ago

        @if($overdue)
        <span class="ml-1 font-semibold text-red-600">
        · {{ $pastDays }} {{ \Illuminate\Support\Str::plural('day', $pastDays) }} overdue
        </span>
        @endif
        </p>
        @endif
     </div>

     <div class="mt-3 flex flex-wrap items-center justify-between gap-1 sm:mt-4">
      <p class="shrink-0 text-xs text-slate-500">Received {{ \Carbon\Carbon::parse($lead->createdAt)->format('M j, Y') }}</p>
      {{-- FIX #4/#5: pass both ids explicitly, load the table immediately instead of waiting on the dropdown --}}

      <button >
     
      <a href="tel:{{ preg_replace('/[^+\d]/','',$lead->mobile) }}" class="btn btn-primary w-full text-white"><i data-lucide="phone" class="h-4 w-4"></i>Call Now</a>
     
   
     </button>
      <button
 type="button"
 @click="openFollowupAt({{ $loop->index }})"
 class="btn h-8 rounded-lg px-3 text-xs bg-emerald-500 text-white hover:bg-emerald-600 {{ $overdue ? 'border-destructive text-destructive bg-emerald-500' : ($pending ? 'border-primary text-primary bg-emerald-500' : '') }}">
 <i data-lucide="eye" class="h-3.5 w-3.5"></i>Follow up
 
</button>
     </div>

     @if($leadFus->count())
      <details class="mt-3 rounded-xl border bg-white/70">
       <summary class="cursor-pointer px-4 py-2 text-xs font-semibold text-slate-500">View Follow Up ({{ $leadFus->count() }})</summary>
       <div class="space-y-2 border-t p-3">
        @foreach($leadFus as $fu)
         <div class="flex items-start justify-between gap-3 rounded-lg bg-secondary/40 p-3">
          <div>
           <p class="text-sm {{ $fu['outcome'] == 'Joined'? 'line-through text-slate-400' : '' }}">{{ $fu['notes'] }}</p>
           <p class="mt-1 text-xs text-slate-500"><strong>Tag:</strong> {{ ucfirst($fu['outcome']) }} &middot; <strong>Next Date:</strong> {{ $fu['dueAt'] ? \Carbon\Carbon::parse($fu['dueAt'])->format('M j, g:i A') : 'No due date' }}</p>
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

     
 

    </div>

     
     
   </div>
  </div>
 @empty
  <div class="card flex flex-col items-center justify-center py-20 text-center">
   <span class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-secondary"><i data-lucide="message-square-text" class="h-8 w-8 text-slate-400"></i></span>
   <h3 class="font-display text-xl font-semibold">No leads found</h3>
   <p class="mt-2 text-slate-500">No leads match this view right now.</p>
  </div>
 @endforelse
 </div>

 <div class="pt-2">
  {{ $leads->links() }}
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
</div>

{{-- FIX #4: enquiryController didn't exist — this is the missing piece that actually loads the table --}}
<script>
function toggleFollowUpDate(select) {

    const selectedOption = select.options[select.selectedIndex];
    const statusName = selectedOption.dataset.name || '';

    const dateInput = document.getElementById('expected_date_time');
    // const applyBtn = document.getElementById('applyFollowUpDateBtn');

    if (statusName === 'not interested') {

        // Clear selected date
        dateInput.value = '';

        // Disable date
        dateInput.disabled = true;

        // Disable Apply button
        // applyBtn.disabled = true;

        // Tailwind disabled appearance
        dateInput.classList.add(
            'cursor-not-allowed',
            'bg-gray-100',
            'opacity-60'
        );

        // applyBtn.classList.add(
        //     'cursor-not-allowed',
        //     'opacity-50'
        // );

    } else {

        dateInput.disabled = false;
        // applyBtn.disabled = false;

        dateInput.classList.remove(
            'cursor-not-allowed',
            'bg-gray-100',
            'opacity-60'
        );

        // applyBtn.classList.remove(
        //     'cursor-not-allowed',
        //     'opacity-50'
        // );
    }
}
</script>

<script>
function getLocalDateTime() {
    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

function setFollowUpDate(input) {

    const currentDateTime = getLocalDateTime();

    // Disable previous date/time
    input.min = currentDateTime;

    // Auto select current date/time only when empty
    if (!input.value) {
        input.value = currentDateTime;
    }

    // Open date picker
    if (input.showPicker) {
        input.showPicker();
    }
}

// Also set minimum date when page loads
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('expected_date_time');

    if (input) {
        input.min = getLocalDateTime();
    }
});
</script>
<script>
window.enquiryController = {

    currentRequestId: 0,

    async storeFollowUp(leadId, form) {

        if (!leadId || !form) return false;

        const submitButtons = form.querySelectorAll('button[type="submit"]');

        // Remove previous validation errors.
        form.querySelectorAll('.validation-error').forEach(el => el.remove());
        form.querySelectorAll('.form-input').forEach(el => {
            el.classList.remove(
                'border-red-500',
                'ring-1',
                'ring-red-500',
                'focus:border-red-500',
                'focus:ring-red-500'
            );
        });

        try {
            submitButtons.forEach(button => button.disabled = true);

            // Read raw lead id before changing/resetting fields.
            const rawLeadId = form.querySelector('[name="lead_id"]')?.value;
            const formData = new FormData(form);

            const response = await fetch(`/business/leads/${leadId}/follow-ups`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            let data;

            try {
                data = await response.json();
            } catch (e) {
                throw { message: 'Invalid server response.' };
            }

            if (!response.ok) throw data;

            this.showFormMessage(
                form,
                data.message || 'Follow-Up Saved Successfully.',
                'success'
            );

            // Refresh history for the lead that was just saved.
            if (rawLeadId) {
                await this.getAllFollowUps(rawLeadId, 5);
            }

            // Clear only fields that should not carry into the next lead.
            const remark = form.querySelector('[name="remark"]');
            const followDate = form.querySelector('[name="expected_date_time"]');

            if (remark) remark.value = '';
            if (followDate) followDate.value = '';

            return true;

        } catch (error) {

            console.error('storeFollowUp failed:', error);

            if (error.errors) {
                Object.keys(error.errors).forEach(key => {
                    const field = form.querySelector(`[name="${CSS.escape(key)}"]`);
                    if (!field) return;

                    field.classList.add(
                        'border-red-500',
                        'ring-1',
                        'ring-red-500',
                        'focus:border-red-500',
                        'focus:ring-red-500'
                    );

                    const errorText = document.createElement('p');
                    errorText.className = 'validation-error mt-1 text-xs font-medium text-red-600';
                    errorText.textContent = Array.isArray(error.errors[key])
                        ? error.errors[key][0]
                        : error.errors[key];

                    field.insertAdjacentElement('afterend', errorText);
                });

                const firstInvalid = form.querySelector('.border-red-500');
                if (firstInvalid) firstInvalid.focus();

            } else {
                this.showFormMessage(
                    form,
                    error.message || 'Unable to save follow up.',
                    'error'
                );
            }

            return false;

        } finally {
            submitButtons.forEach(button => button.disabled = false);
        }
    },


    showFormMessage(form, message, type = 'success') {

        let alertBox = form.querySelector('.followup-form-message');

        if (!alertBox) {
            alertBox = document.createElement('div');

            alertBox.className = 'followup-form-message';

            form.prepend(alertBox);
        }

        if (type === 'success') {

            alertBox.className =
                'followup-form-message rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700';

        } else {

            alertBox.className =
                'followup-form-message rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700';
        }

        alertBox.textContent = message;
    },


    async getAllFollowUps(leadId, limit = 5) {

        if (!leadId) return;

        const tbody = document.getElementById(
            'enquiry-followups-body'
        );

        if (!tbody) return;

        const requestId = ++this.currentRequestId;

        tbody.innerHTML = `
            <tr>
                <td colspan="4"
                    class="px-4 py-6 text-center text-gray-400">
                    Loading...
                </td>
            </tr>
        `;

        try {

            const res = await fetch(
                `/business/leads/${leadId}/follow-ups/list?limit=${encodeURIComponent(limit)}`,
                {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                }
            );

            if (requestId !== this.currentRequestId) return;

            if (!res.ok) {
                throw new Error('Request failed: ' + res.status);
            }

            const followups = await res.json();

            if (!Array.isArray(followups) || !followups.length) {

                tbody.innerHTML = `
                    <tr>
                        <td colspan="4"
                            class="px-4 py-6 text-center text-gray-400">
                            No follow-ups yet.
                        </td>
                    </tr>
                `;

                return;
            }

            tbody.innerHTML = followups.map(fu => `
                <tr class="border-b border-gray-100 hover:bg-gray-50">

                    <td class="whitespace-nowrap px-4 py-3">
                        ${this.escapeHtml(fu.date ?? '-')}
                    </td>

                    <td class="px-4 py-3">
                        ${this.escapeHtml(fu.notes ?? '')}
                    </td>

                    <td class="whitespace-nowrap px-4 py-3">
                        ${this.escapeHtml(fu.status ?? '-')}
                    </td>

                    <td class="whitespace-nowrap px-4 py-3">
                        ${this.escapeHtml(fu.expected_date ?? '-')}
                    </td>

                </tr>
            `).join('');

        } catch (err) {

            if (requestId !== this.currentRequestId) return;

            console.error(err);

            tbody.innerHTML = `
                <tr>
                    <td colspan="4"
                        class="px-4 py-6 text-center text-red-500">
                        Couldn't load follow-ups.
                    </td>
                </tr>
            `;
        }
    },


    escapeHtml(value) {

        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

};

document.addEventListener('click', function (e) {
    const el = e.target.closest('.assignedLeadsClick');
    if (!el) return;

    e.preventDefault();
 
    const assignedId = el.dataset.assignedId;
    const clientId = el.dataset.clientId;
    if (!assignedId || !clientId  || el.classList.contains('is-loading')) return;

    el.classList.add('is-loading');

    fetch('/business/readLead', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ assingId: assignedId,clientId:clientId }),
    })
        .then(res => res.json())
        .then(data => {
          
            if (data.status) {
                el.classList.remove('assignedLeadsClick', 'cursor-pointer');
                el.classList.add('bg-white');
            } else {
                el.classList.remove('is-loading');
                console.error('Failed to mark lead as read:', data.msg);
            }
        })
        .catch(err => {
            el.classList.remove('is-loading');
            console.error('readLead request failed:', err);
        });
});


document.addEventListener('click', function (e) {
    const el = e.target.closest('.favorited');
    if (!el) return;

    e.preventDefault();

    const favoritleads = el.dataset.favoritleads;
    if (!favoritleads || el.classList.contains('is-loading')) return;

    el.classList.add('is-loading');

    fetch('/business/favoritleads', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        // FIX: clientId dropped from the payload — the server derives the
        // owning client from the authenticated session instead of trusting
        // a value that could be edited in devtools (IDOR risk, see controller below)
        body: JSON.stringify({ assingId: favoritleads }),
    })
        .then(async (res) => {
            // FIX: guard against non-JSON error bodies (e.g. a 419/500 HTML page)
            // crashing silently inside .then() with no user feedback
            let data;
            try {
                data = await res.json();
            } catch {
                throw new Error(`Unexpected response (status ${res.status})`);
            }
            if (!res.ok) throw new Error(data.msg || `Request failed (status ${res.status})`);
            return data;
        })
        .then((data) => {
            if (data.status) {
                // FIX: give visual confirmation on the star icon itself,
                // not just a popup the user might miss
                const icon = el.querySelector('i, svg');
                const isFavorited = data.favorited ?? true;

                el.classList.toggle('text-amber-500', isFavorited);
                if (icon) {
                    icon.classList.toggle('fill-amber-500', isFavorited);
                    icon.classList.toggle('fill-none', !isFavorited);
                }

                showToast(
                    isFavorited ? 'Added to favorites' : 'Removed from favorites',
                    'success'
                );
            } else {
                showToast(data.msg || 'Could not update favorite', 'error');
            }
        })
        .catch((err) => {
            console.error('favoritleads request failed:', err);
            showToast('Something went wrong. Please try again.', 'error');
        })
        .finally(() => {
            // FIX: this was never being removed before — element got stuck
            // "loading" forever after the very first click
            el.classList.remove('is-loading');
        });
}); 

</script>

{{-- Add once in layouts/app.blade.php, near the end of <body> --}}
<div
    id="toast-container"
    class="pointer-events-none fixed right-4 top-4 z-[9999] flex w-full max-w-sm flex-col gap-2"
></div>

<script>
/**
 * Usage: showToast('Favorite lead updated', 'success');
 *        showToast('Something went wrong', 'error');
 */
function showToast(message, type = 'success', duration = 3000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const styles = {
        success: {
            bg: 'bg-emerald-50 border-emerald-200 text-emerald-800',
            icon: `<svg class="h-5 w-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>`,
        },
        error: {
            bg: 'bg-red-50 border-red-200 text-red-800',
            icon: `<svg class="h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>`,
        },
    };

    const style = styles[type] ?? styles.success;

    const toast = document.createElement('div');
    toast.className = `pointer-events-auto flex items-center gap-3 rounded-xl border ${style.bg} px-4 py-3 shadow-lg transition-all duration-300 ease-out translate-x-4 opacity-0`;
    toast.innerHTML = `
        ${style.icon}
        <p class="flex-1 text-sm font-medium">${message}</p>
        <button type="button" class="shrink-0 rounded p-1 text-current/60 hover:text-current" aria-label="Dismiss">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    `;

    container.appendChild(toast);

    // animate in
    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-4', 'opacity-0');
    });

    const dismiss = () => {
        toast.classList.add('translate-x-4', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    };

    toast.querySelector('button').addEventListener('click', dismiss);
    setTimeout(dismiss, duration);
}



window.scrapController = {

    async submit(assignedId, form, onSuccess) {
        if (!assignedId || !form) return;

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn ? submitBtn.innerHTML : '';

        const selected = form.querySelector('input[name="scrapLead"]:checked');
        if (!selected) {
            showToast('Please select a reason first.', 'error');
            return;
        }

        try {
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Saving...';
            }

            const res = await fetch('/business/scrap-lead', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                // FIX: no clientId sent from the frontend — the server
                // derives the owning client from the authenticated session.
                body: JSON.stringify({
                    assigned_id: assignedId,
                    scrap_value: selected.value,
                }),
            });

            let data;
            try {
                data = await res.json();
            } catch {
                throw new Error(`Unexpected response (status ${res.status})`);
            }
            if (!res.ok) throw new Error(data.msg || `Request failed (status ${res.status})`);

            showToast(data.msg || 'Lead reported successfully.', 'success');
            if (typeof onSuccess === 'function') onSuccess();

        } catch (err) {
            console.error('scrapController.submit failed:', err);
            showToast(err.message || 'Could not submit report.', 'error');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText || 'Submit';
            }
        }
    },
};
document.addEventListener('change', function (e) {
    const radio = e.target.closest('.scrap-radio');
    if (!radio || !radio.checked) return;

    const assignedId = radio.dataset.assignedId;
    const scrapValue = radio.value;
    if (!assignedId) return;

    const group = document.getElementById(`scrap-reasons-${assignedId}`);
    // FIX: disable the whole group while saving, instead of nothing —
    // prevents a second rapid click from firing a duplicate request
    group?.querySelectorAll('.scrap-radio').forEach(r => r.disabled = true);

    fetch('/business/scrapLead', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            // FIX: original request sent no CSRF token at all -> 419 on every call
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        // FIX: clientId dropped entirely — server derives it from the
        // authenticated session (see LeadController::scrapLead)
        body: JSON.stringify({
            assigned_id: assignedId,
            scrap_value: scrapValue,
        }),
    })
        .then(async (res) => {
            let data;
            try {
                data = await res.json();
            } catch {
                throw new Error(`Unexpected response (status ${res.status})`);
            }
            if (!res.ok) throw new Error(data.msg || `Request failed (status ${res.status})`);
            return data;
        })
        .then((data) => {
            if (data.status) {
                showToast(data.msg || 'Lead reported successfully.', 'success');

                // Tell the Alpine modal for this lead to close itself —
                // avoids reaching into Alpine's internals from plain JS.
                window.dispatchEvent(new CustomEvent('scrap-lead-saved', {
                    detail: { assignedId },
                }));
            } else {
                showToast(data.msg || 'Could not submit report.', 'error');
                group?.querySelectorAll('.scrap-radio').forEach(r => r.disabled = false);
            }
        })
        .catch((err) => {
            console.error('scrap-lead request failed:', err);
            showToast(err.message || 'Something went wrong. Please try again.', 'error');
            group?.querySelectorAll('.scrap-radio').forEach(r => r.disabled = false);
        });
});

</script>
      
 
 
 </div>
</div>


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
    flatpickr("#date_from", {
        dateFormat: "d-m-Y",
    });

flatpickr("#date_to", {
        dateFormat: "d-m-Y",
    });

    flatpickr("#expected_date_time", {
    dateFormat: "d-m-Y",
    minDate: "today",
});

});
</script>


@endsection
