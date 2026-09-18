@extends('business.business.layouts.app')

@section('title', 'Overview')

@section('content')

@php
    $metrics = [
        ['Profile Views', number_format($stats['profileViews']), $stats['viewsChangePct'], 'eye'],
        ['Total Leads', number_format($stats['totalLeads']), $stats['leadsChangePct'], 'message-square'],
        ['Total Calls', number_format($stats['totalCalls']), null, 'phone'],
        ['Avg Rating', number_format($stats['avgRating'], 1), null, 'star'],
    ];

    $tiles = [
        ['icon' => 'users', 'count' => $monthsFollow['total_leads'], 'label' => 'Total Leads', 'color' => 'text-gray-800'],
        ['icon' => 'gauge', 'count' => $monthsFollow['interested'], 'label' => 'Interested', 'color' => 'text-green-600'],
        ['icon' => 'phone-call', 'count' => $monthsFollow['follow_up'], 'label' => 'Follow Up', 'color' => 'text-gray-600'],
        ['icon' => 'clock-alert', 'count' => $monthsFollow['calling_visits'], 'label' => 'Pending Follow Up', 'color' => 'text-red-700'],
        ['icon' => 'graduation-cap', 'count' => $monthsFollow['joined'], 'label' => 'Joined', 'color' => 'text-gray-800'],
    ];

    /* Leads available to Previous / Next inside the popup. */
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div
    class="animate-fade-in space-y-6 pb-8 md:space-y-8"
    x-data="followupManager()"
>

    {{-- ============================================================
         PAGE HEADER
    ============================================================= --}}
    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
        <div>
            <h1 class="font-display text-xl font-bold tracking-tight md:text-3xl">
                Overview
            </h1>
            <p class="mt-1 text-sm text-slate-500 md:text-base">
                Here's what's happening with your business today.
            </p>
        </div>
 
    </div>


    {{-- ============================================================
         MAIN METRICS
    ============================================================= --}}
    <div class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-6">
        @foreach($metrics as $i => $m)
            <div class="card animate-slide-up stagger-{{ $i + 1 }} group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 transition group-hover:opacity-100"></div>

                <div class="relative flex flex-col gap-4 p-5">
                    <div class="flex items-center justify-between">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                            <i data-lucide="{{ $m[3] }}" class="h-5 w-5"></i>
                        </span>

                        @if($m[2] !== null)
                            <span class="badge {{ $m[2] >= 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-destructive/10 text-destructive' }}">
                                <i data-lucide="{{ $m[2] >= 0 ? 'arrow-up-right' : 'arrow-down-right' }}" class="h-3 w-3"></i>
                                {{ abs($m[2]) }}%
                            </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500">{{ $m[0] }}</p>
                        <h3 class="mt-1 font-display text-2xl font-bold">{{ $m[1] }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    {{-- ============================================================
         MONTHLY FOLLOW-UP METRICS
    ============================================================= --}}
    <div class="grid grid-cols-2 gap-3 md:grid-cols-5 md:gap-6">
        @foreach($tiles as $tile)
            <div class="animate-flipInY flex flex-col items-center rounded-lg border border-gray-100 bg-white p-3 text-center shadow-sm transition-shadow duration-200 hover:shadow-md">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i data-lucide="{{ $tile['icon'] }}" class="h-7 w-7"></i>
                </div>

                <div class="text-3xl font-bold {{ $tile['color'] }}">
                    {{ $tile['count'] }}
                </div>

                <h3 class="mt-2 text-sm font-semibold text-gray-600">
                    {{ $tile['label'] }}
                    <small class="mt-0.5 block text-xs text-gray-400">
                        (in {{ now()->format('M Y') }})
                    </small>
                </h3>
            </div>
        @endforeach
    </div>


    {{-- ============================================================
         FOLLOW LEADS
    ============================================================= --}}
    <div class="card">
        <div class="flex items-center justify-between border-b px-4 py-4 sm:px-6">
            <h2 class="font-display text-lg font-semibold">Follow Leads</h2>
            <a href="{{ route('leads') }}" class="text-sm font-medium text-primary hover:underline">
                View All
            </a>
        </div>

        <div class="divide-y border-b">
            @forelse($leads->getCollection() as $lead)
                @php
 
                    $leadFus = $followups
                        ->where('lead_id', $lead->lead_id)
                        ->whereNotNull('notes')
                        ->where('notes', '!=', '');

                    $pending = '';
                    $overdue = false;
                    $pastDays = 0;
    
                    if (!empty($lead->expected_date_time)  && !in_array($lead->status_name, [
                    'Meeting Close',
                    'Sales Close',
                    'Joined',
                    'Invalid Number',
                    ])) {
                        $followDate = \Carbon\Carbon::parse($lead->expected_date_time)->startOfDay();
                        $today = \Carbon\Carbon::today();
                        $overdue = $followDate->lt($today);
                        $pastDays = $overdue ? $followDate->diffInDays($today) : 0;
                    }
                @endphp

                <div class="p-4 sm:p-6">
                    <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                        <div class="flex min-w-0 items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary/10 font-display font-bold text-primary">
                                {{ strtoupper(substr($lead->name ?? 'L', 0, 1)) }}
                            </span>

                            <div class="min-w-0">
                                <h3 class="truncate font-semibold">
                                    {{ ucfirst($lead->name ?? 'Lead') }}
                                </h3>

                                <p class="mt-0.5 break-words text-sm text-slate-500">
                                    {{ $lead->kw_text }} · {{ $lead->mobile }}
                                </p>

                                @if(!empty($lead->remarks))
                                    <p class="mt-1 line-clamp-1 text-sm">
                                        {!! $lead->remarks !!} 
                                    </p>
                                    <p class="text-sm"><strong>Current Status: </strong> {{ $lead->status_name }}</p>

                                @endif

                                @if(!empty($lead->expected_date_time) )
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ get_time(strtotime($lead->expected_date_time)) }} ago

                                        @if($overdue)
                                            <span class="ml-1 font-semibold text-red-600">
                                                · {{ $pastDays }} {{ \Illuminate\Support\Str::plural('day', $pastDays) }} overdue
                                            </span>
                                        @endif
                                    </p>
                                @endif

                                @if(!empty($lead->status_name))
                                    <p class="mt-1 line-clamp-1 text-sm">
                                       
                                    </p>
                                @endif

                            </div>
                        </div>

                        <div class="flex w-full flex-wrap gap-2 md:w-auto md:flex-nowrap">
                            <a
                                href="tel:{{ preg_replace('/[^+\d]/', '', $lead->mobile) }}"
                                class="btn btn-outline flex-1 md:flex-none"
                            >
                                <i data-lucide="phone" class="h-4 w-4"></i>
                                Call
                            </a>

                        

                            <button
                                type="button"
                                @click="openFollowupAt({{ $loop->index }})"
                                class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-emerald-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-600 md:flex-none"
                            >
                                <i data-lucide="eye" class="h-3.5 w-3.5"></i>
                                Follow Up
                            </button>
                        </div>
                    </div>

                    @if($leadFus->count())
                        <details class="mt-4 rounded-xl border bg-white/70">
                            <summary class="cursor-pointer px-4 py-2 text-xs font-semibold text-slate-500">
                                View Follow Up ({{ $leadFus->count() }})
                            </summary>

                            <div class="space-y-2 border-t p-3">
                                @foreach($leadFus as $fu)
                                    <div class="flex items-start justify-between gap-3 rounded-lg bg-secondary/40 p-3">
                                        <div class="min-w-0">
                                            <p class="break-words text-sm {{ ($fu['outcome'] ?? '') === 'Joined' ? 'line-through text-slate-400' : '' }}">
                                                {{ $fu['notes'] ?? '' }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500">
                                                <strong>Tag:</strong>
                                                {{ ucfirst($fu['outcome'] ?? '-') }}
                                                &middot;
                                                <strong>Next Date:</strong>
                                                {{ !empty($fu['dueAt']) ? \Carbon\Carbon::parse($fu['dueAt'])->format('M j, Y') : 'No due date' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center text-slate-500">
                    You're all caught up. No new leads waiting.
                </div>
            @endforelse
        </div>

        @if(method_exists($leads, 'links'))
            <div class="px-4 py-4 sm:px-6">
                {{ $leads->links() }}
            </div>
        @endif
    </div>


    {{-- ============================================================
         CHART + PENDING FOLLOW UPS
    ============================================================= --}}
    <div class="grid gap-6 md:grid-cols-3">
        <div class="card md:col-span-2">
            <div class="border-b bg-secondary/20 px-4 py-5 sm:px-6">
                <h2 class="font-display text-lg font-semibold">
                    Performance Trend (30 Days)
                </h2>
            </div>

            <div class="h-[300px] p-4 sm:p-6">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <div class="card flex flex-col">
            <div class="flex items-center justify-between border-b bg-secondary/20 px-4 py-4 sm:px-6">
                <h2 class="flex items-center gap-2 font-display text-lg font-semibold">
                    <i data-lucide="activity" class="h-4 w-4 text-primary"></i>
                    Pending Follow Up
                </h2>
            </div>

            <div class="h-[300px] space-y-4 overflow-y-auto p-4">
                @forelse($recentActivity ?? [] as $a)
                    <div class="flex gap-3">
                        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-secondary">
                            <i data-lucide="message-square" class="h-4 w-4 text-primary"></i>
                        </span>

                        <div class="min-w-0 flex-1 border-b pb-4 last:border-0">
                            <p class="break-words text-sm leading-snug">
                                {{ $a->remark }}
                            </p>

                            @if(!empty($a->expected_date_time))
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($a->expected_date_time)->format('M j, Y') }}
                                </p>
                            @endif

                            <p class="mt-1 text-xs text-slate-500">
                                {{ $a->status_name }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="flex h-full items-center justify-center text-center text-sm text-slate-500">
                        No pending follow-ups.
                    </div>
                @endforelse
            </div>
        </div>
    </div>


    {{-- ============================================================
         FOLLOW-UP POPUP
         IMPORTANT: this template is INSIDE the x-data scope.
    ============================================================= --}}
    <template x-teleport="body">
        <div
            x-cloak
            x-show="followup !== null"
            x-transition.opacity
            class="fixed inset-0 z-[9999] flex items-center justify-center overflow-hidden p-2 sm:p-4"
            @keydown.escape.window="closeFollowup()"
        >
            <div
                class="absolute inset-0 bg-slate-950/40"
                @click="closeFollowup()"
            ></div>

            <div
                class="relative z-[10000] flex max-h-[96dvh] w-full min-w-0 max-w-4xl flex-col overflow-hidden rounded-xl bg-white shadow-2xl sm:max-h-[90vh] sm:rounded-2xl"
                @click.stop
            >
                {{-- Header --}}
                <div class="flex shrink-0 flex-col gap-3 border-b border-slate-200 bg-white p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
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

                    <div class="flex shrink-0 items-center justify-end gap-1">
                        <button
                            type="button"
                            @click="previousLead()"
                            :disabled="currentIndex <= 0"
                            class="inline-flex h-9 items-center justify-center gap-1 rounded-lg border border-slate-200 bg-blue-600 px-2.5 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-40 sm:px-3"
                            title="Previous Lead"
                        >
                            <i data-lucide="chevron-left" class="h-4 w-4"></i>
                            <span class="hidden sm:inline">Previous</span>
                        </button>

                        <button
                            type="button"
                            @click="nextLead()"
                            :disabled="currentIndex >= leads.length - 1"
                            class="inline-flex h-9 items-center justify-center gap-1 rounded-lg border border-slate-200 bg-blue-600 px-2.5 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-40 sm:px-3"
                            title="Next Lead"
                        >
                            <span class="hidden sm:inline">Next</span>
                            <i data-lucide="chevron-right" class="h-4 w-4"></i>
                        </button>

                        <button
                            type="button"
                            @click="closeFollowup()"
                            class="ml-1 flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition hover:bg-slate-200"
                            title="Close"
                        >
                            <i data-lucide="x" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>


                {{-- Scrollable body --}}
                <div class="min-w-0 flex-1 overflow-x-hidden overflow-y-auto bg-white p-4 sm:p-5">
                    <form
                        :action="'/business/leads/' + followup + '/follow-ups'"
                        method="POST"
                        id="followup-form"
                        data-after-save="stay"
                        class="min-w-0 space-y-4"
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

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            {{-- Status --}}
                            <div>
                                <label for="followup_status" class="mb-2 block text-sm font-medium text-slate-700">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    id="followup_status"
                                    class="form-input w-full"
                                    x-model.number="followupStatusid"
                                    @change="toggleFollowUpDate($event.target)"
                                >
                                    <option value="">Select Status</option>

                                    @foreach($statues as $status)
                                        <option
                                            value="{{ $status->id }}"
                                            data-name="{{ strtolower(trim($status->name)) }}"
                                        >
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Follow-up Date --}}
                            <div>
                                <label for="expected_date_time" class="mb-2 block text-sm font-medium text-slate-700">
                                    Next Follow Up Date
                                </label>

                                <input
                                    type="text"
                                    name="expected_date_time"
                                    id="expected_date_time"
                                    class="form-input w-full cursor-pointer bg-white"
                                    placeholder="Select Follow-Up Date"
                                    autocomplete="off"
                                    readonly
                                    @click="openFollowupDatePicker()"
                                >
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label for="followup_remark" class="mb-2 block text-sm font-medium text-slate-700">
                                Notes
                                <span class="text-red-500">*</span>
                            </label>

                            <textarea
                                id="followup_remark"
                                name="remark"
                                rows="4"
                                class="form-input form-textarea w-full"
                                placeholder="Notes about the call..."
                            ></textarea>
                        </div>

                        {{-- Save buttons --}}
                        <div class="flex flex-col-reverse gap-2 border-t border-slate-200 pt-4 sm:flex-row sm:justify-end">
                            <button
                                type="submit"
                                @click="$el.form.dataset.afterSave = 'stay'"
                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                            >
                                <i data-lucide="save" class="h-4 w-4"></i>
                                Save
                            </button>

                            <button
                                type="submit"
                                @click="$el.form.dataset.afterSave = 'next'"
                                :disabled="currentIndex >= leads.length - 1"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                Save & Next
                                <i data-lucide="arrow-right" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </form>


                    {{-- Follow-up history --}}
                    <div class="mt-5 border-t border-slate-200 pt-4">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <p class="text-sm font-semibold text-slate-800">
                                Follow Up History
                            </p>

                            <select
                                class="follow-up-count rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                                @change="enquiryController.getAllFollowUps(followupLeadId, $event.target.value)"
                            >
                                <option value="5">Last 5</option>
                                <option value="all">All</option>
                            </select>
                        </div>

                        <div class="max-h-[300px] overflow-auto rounded-xl border border-slate-200 bg-white shadow-sm">
                            <table id="datatable-enquiry-followups" class="min-w-[650px] w-full divide-y divide-slate-200 text-sm">
                                <thead class="sticky top-0 z-10 bg-slate-50">
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-3 text-left font-semibold text-slate-700">Date</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Remark</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left font-semibold text-slate-700">Status</th>
                                        <th class="whitespace-nowrap px-4 py-3 text-left font-semibold text-slate-700">Follow Date</th>
                                    </tr>
                                </thead>

                                <tbody id="enquiry-followups-body" class="divide-y divide-slate-100 bg-white"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

</div>


{{-- ================================================================
     TOAST
================================================================= --}}
<div
    id="toast-container"
    class="pointer-events-none fixed right-4 top-4 z-[10050] flex w-full max-w-sm flex-col gap-2"
></div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
/* ================================================================
   FOLLOW-UP DATE PICKER
================================================================ */
window.followupDatePicker = null;

function initFollowupDatePicker() {
    const input = document.getElementById('expected_date_time');

    if (!input || typeof flatpickr === 'undefined') {
        return;
    }

    if (window.followupDatePicker) {
        return;
    }

    window.followupDatePicker = flatpickr(input, {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        allowInput: false,
        clickOpens: true,
        disableMobile: true,
        onChange: function(selectedDates, dateStr, instance) {
            /* Close immediately after selecting the date. */
            instance.close();
        }
    });
}

function openFollowupDatePicker() {
    if (window.followupDatePicker && !document.getElementById('expected_date_time')?.disabled) {
        window.followupDatePicker.open();
    }
}

function clearFollowupDate() {
    if (window.followupDatePicker) {
        window.followupDatePicker.clear();
        window.followupDatePicker.set('minDate', 'today');
    } else {
        const input = document.getElementById('expected_date_time');
        if (input) input.value = '';
    }
}

function toggleFollowUpDate(select) {
    if (!select) return;

    const selectedOption = select.options[select.selectedIndex];
    const statusName = (selectedOption?.dataset?.name || '').trim().toLowerCase();
    const dateInput = document.getElementById('expected_date_time');

    if (!dateInput) return;

    const shouldDisable = statusName === 'not interested';

    if (shouldDisable) {
        clearFollowupDate();
        dateInput.disabled = true;
        dateInput.classList.add('cursor-not-allowed', 'bg-slate-100', 'opacity-60');
    } else {
        dateInput.disabled = false;
        dateInput.classList.remove('cursor-not-allowed', 'bg-slate-100', 'opacity-60');
    }
}


/* ================================================================
   ALPINE FOLLOW-UP MANAGER
================================================================ */
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
                initFollowupDatePicker();

                const form = document.getElementById('followup-form');
                const select = document.getElementById('followup_status');
                const countSelect = document.querySelector('.follow-up-count');

                if (form) {
                    form.querySelectorAll('.validation-error').forEach(el => el.remove());
                    form.querySelector('.followup-form-message')?.remove();

                    const remark = form.querySelector('[name="remark"]');
                    if (remark) remark.value = '';

                    form.dataset.afterSave = 'stay';
                }

                clearFollowupDate();

                if (select) {
                    select.value = String(lead.status_id || '');
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                }

                if (countSelect) {
                    countSelect.value = '5';
                }

                if (window.lucide) {
                    lucide.createIcons();
                }

                window.enquiryController?.getAllFollowUps(lead.lead_id, 5);
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
            clearFollowupDate();
        }
    };
};


/* ================================================================
   FOLLOW-UP AJAX CONTROLLER
================================================================ */
window.enquiryController = {
    currentRequestId: 0,

    async storeFollowUp(assignId, form) {
        if (!assignId || !form) {
            return false;
        }

        const submitButtons = form.querySelectorAll('button[type="submit"]');

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
            submitButtons.forEach(button => {
                button.disabled = true;
                button.dataset.originalHtml = button.innerHTML;
            });

            const rawLeadId = form.querySelector('[name="lead_id"]')?.value;
            const formData = new FormData(form);

            const response = await fetch(`/business/leads/${assignId}/follow-ups`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            let data = {};

            try {
                data = await response.json();
            } catch (e) {
                throw { message: 'Invalid server response.' };
            }

            if (!response.ok) {
                throw data;
            }

            this.showFormMessage(
                form,
                data.message || data.msg || 'Follow-Up saved successfully.',
                'success'
            );

            if (rawLeadId) {
                await this.getAllFollowUps(rawLeadId, 5);
            }

            const remark = form.querySelector('[name="remark"]');
            if (remark) remark.value = '';

            clearFollowupDate();

            showToast(
                data.message || data.msg || 'Follow-Up saved successfully.',
                'success'
            );

            return true;

        } catch (error) {
            console.error('storeFollowUp failed:', error);

            if (error?.errors) {
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

                form.querySelector('.border-red-500')?.focus();
            } else {
                this.showFormMessage(
                    form,
                    error?.message || 'Unable to save follow-up.',
                    'error'
                );
            }

            showToast(error?.message || 'Unable to save follow-up.', 'error');
            return false;

        } finally {
            submitButtons.forEach(button => {
                button.disabled = false;

                if (button.dataset.originalHtml) {
                    button.innerHTML = button.dataset.originalHtml;
                    delete button.dataset.originalHtml;
                }
            });

            if (window.lucide) {
                lucide.createIcons();
            }
        }
    },

    showFormMessage(form, message, type = 'success') {
        let alertBox = form.querySelector('.followup-form-message');

        if (!alertBox) {
            alertBox = document.createElement('div');
            form.prepend(alertBox);
        }

        alertBox.className = type === 'success'
            ? 'followup-form-message rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700'
            : 'followup-form-message rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700';

        alertBox.textContent = message;
    },

    async getAllFollowUps(leadId, limit = 5) {
        if (!leadId) return;

        const tbody = document.getElementById('enquiry-followups-body');
        if (!tbody) return;

        const requestId = ++this.currentRequestId;

        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-4 py-6 text-center text-slate-400">
                    Loading...
                </td>
            </tr>
        `;

        try {
            const response = await fetch(
                `/business/leads/${leadId}/follow-ups/list?limit=${encodeURIComponent(limit)}`,
                {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                }
            );

            if (requestId !== this.currentRequestId) return;

            if (!response.ok) {
                throw new Error('Request failed: ' + response.status);
            }

            const followups = await response.json();

            if (!Array.isArray(followups) || !followups.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-slate-400">
                            No follow-ups yet.
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = followups.map(fu => `
                <tr class="border-b border-slate-100 hover:bg-slate-50">
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

        } catch (error) {
            if (requestId !== this.currentRequestId) return;

            console.error('getAllFollowUps failed:', error);

            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-red-500">
                        Couldn't load follow-ups.
                    </td>
                </tr>
            `;
        }
    },

    escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }
};


/* ================================================================
   TOAST
================================================================ */
function showToast(message, type = 'success', duration = 3000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const styles = {
        success: 'border-emerald-200 bg-emerald-50 text-emerald-800',
        error: 'border-red-200 bg-red-50 text-red-800'
    };

    const toast = document.createElement('div');
    toast.className = `pointer-events-auto flex translate-x-4 items-center gap-3 rounded-xl border ${styles[type] || styles.success} px-4 py-3 opacity-0 shadow-lg transition-all duration-300`;

    const text = document.createElement('p');
    text.className = 'flex-1 text-sm font-medium';
    text.textContent = message;

    const close = document.createElement('button');
    close.type = 'button';
    close.className = 'rounded p-1 text-lg leading-none opacity-60 hover:opacity-100';
    close.textContent = '×';

    toast.append(text, close);
    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-4', 'opacity-0');
    });

    const dismiss = () => {
        toast.classList.add('translate-x-4', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    };

    close.addEventListener('click', dismiss);
    setTimeout(dismiss, duration);
}


/* ================================================================
   CHART + ICONS
================================================================ */
document.addEventListener('DOMContentLoaded', function () {
    initFollowupDatePicker();

    if (window.lucide) {
        lucide.createIcons();
    }

    const chartEl = document.getElementById('performanceChart');

    if (chartEl && typeof Chart !== 'undefined') {
        new Chart(chartEl, {
            type: 'line',
            data: {
                labels: @json(array_column($series, 'date')),
                datasets: [{
                    label: 'Views',
                    data: @json(array_column($series, 'views')),
                    borderColor: 'hsl(230,90%,55%)',
                    backgroundColor: 'rgba(62,83,238,.14)',
                    fill: true,
                    tension: .4,
                    borderWidth: 3,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    },
                    y: {
                        beginAtZero: false,
                        grid: {
                            color: 'rgba(148,163,184,.18)'
                        }
                    }
                }
            }
        });
    }
});
</script>

@endsection
