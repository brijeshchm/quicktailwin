@extends('business.business.layouts.app')
@section('title','Leads')
@section('content')
@php
 
 
$statusClass=['new'=>'border-blue-200 bg-blue-50 text-blue-700','contacted'=>'border-amber-200 bg-amber-50 text-amber-700','converted'=>'border-emerald-200 bg-emerald-50 text-emerald-700','closed'=>'border-slate-200 bg-slate-100 text-slate-600'];
@endphp

 
<div class="animate-fade-in space-y-4 md:space-y-6"
     
     x-data="{
   followup: null,
   followupLeadId: null,
   followupName: null,
   followupEmail: null,
   followupService: null,
   openFollowup(assignId, leadId, name, email, service) {
     this.followup = assignId;
     this.followupLeadId = leadId;
     this.followupName = name;
     this.followupEmail = email;
     this.followupService = service;
     this.$nextTick(() => {
       lucide.createIcons();
       enquiryController.getAllFollowUps(leadId, 5);
     });
   }
}"
     
     >
 <div class="flex flex-col justify-between gap-4 xl:flex-row xl:items-end">
    
 <div class="md:hidden"><select onchange="window.location=this.value" class="form-input h-12 bg-white text-base font-medium shadow-sm">
    
 @foreach($leadsTabs as $key=>$label)
    
 <option value="{{ route('leads',['tab'=>$key]) }}" @selected($tab===$key)>{{ $label }}</option>@endforeach</select>

</div>


  <div>
   <h1 class="font-display text-xl font-bold tracking-tight md:text-3xl">Archived Leads</h1>
   <p class="mt-1 text-sm text-slate-500 md:text-base">Manage inquiries and assign them to your team.</p>
  </div>
  <div class="hide-scrollbar flex w-full shrink-0 snap-x overflow-x-auto rounded-xl bg-secondary p-1 xl:w-auto">
  
  </div>
 </div>

 <div class="space-y-4">

 @forelse($leads->getCollection() as $i => $lead)
  @php
 
   // FIX #1: match on the RAW lead id (lead_id), not the assignment id ($lead['id']).
   $leadFus  = $followups->where('lead_id', $lead->lead_id)->whereNotNull('notes')
        ->where('notes', '!=', '');
 
   // FIX #2: 'status' isn't a key on the followups array — the boolean is 'done'.
   $pending  = '';
   $overdue  = $leadFus->filter(fn($f) => $f['dueAt'] && \Carbon\Carbon::parse($f['dueAt'])->isPast())->count();
  
  @endphp
  <div class="card animate-slide-up stagger-{{ ($i % 5) + 1 }} relative overflow-hidden opacity-70 grayscale-[20%] {{ $lead->readLead == '0' ? 'assignedLeadsClick cursor-pointer bg-gray-200' : '' }}" data-assigned-id="{{ $lead->assign_id }}" data-client-id="{{ $lead->client_id }}" >
 
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
       <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-500"><i data-lucide="clock" class="h-3.5 w-3.5"></i>Inquiry for: {{ $lead->kw_text }}</p>
       <span class="badge border capitalize {{ $lead->status_name ?? 'bg-secondary text-slate-600' }}">{{ $lead->status_name ?? $lead->status_name }}</span>
      </div>
      <p class="text-xs leading-relaxed text-slate-800 sm:text-sm">&ldquo;{!! $lead->remarks !!}&rdquo;</p>
     </div>

     <div class="mt-3 flex flex-wrap items-center justify-between gap-2 sm:mt-4">
      <p class="shrink-0 text-xs text-slate-500">Received {{ \Carbon\Carbon::parse($lead->createdAt)->format('M j, Y') }}</p>
      {{-- FIX #4/#5: pass both ids explicitly, load the table immediately instead of waiting on the dropdown --}}
      <button
 type="button"
 @click="openFollowup(
    {{ $lead->assign_id }},
    {{ $lead->lead_id }},
    @js($lead->name),
    @js($lead->email),
    @js($lead->kw_text)
 )"
 class="btn h-8 rounded-lg px-3 text-xs bg-emerald-500 text-white {{ $overdue ? 'border-destructive text-destructive bg-emerald-500' : ($pending ? 'border-primary text-primary bg-emerald-500' : '') }}">
 <i data-lucide="eye" class="h-3.5 w-3.5"></i>Follow up
 @if($pending)<span class="rounded bg-primary/10 px-1.5 py-0.5 text-primary">{{ $pending }}</span>@endif
 
</button>
     </div>

     @if($leadFus->count())
      <details class="mt-3 rounded-xl border bg-white/70">
       <summary class="cursor-pointer px-4 py-2 text-xs font-semibold text-slate-500">View Follow Up ({{ $leadFus->count() }})</summary>
       <div class="space-y-2 border-t p-3">
        @foreach($leadFus as $fu)
         <div class="flex items-start justify-between gap-3 rounded-lg bg-secondary/40 p-3">
          <div>
           <p class="text-sm {{ $fu['outcome'] == 'Joined'? 'text-slate-400' : '' }}">{{ $fu['notes'] }}</p>
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

     
    <div class="flex gap-2 bg-secondary/10 p-3 sm:p-6 lg:w-[240px] lg:flex-col lg:justify-center">



   

        
 
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
            <div
                class="flex shrink-0 items-center justify-between
                       border-b border-gray-200 bg-white p-5"
            >

                <div>
                    <h2
                        class="font-display text-xl font-semibold text-slate-900"
                        x-text="followupName || 'Add Follow-up'"
                    >
                        Add Follow-up
                    </h2>

                    <div
                        class="mt-1 flex flex-wrap items-center
                               gap-x-3 gap-y-1 text-sm text-slate-500"
                    >

                        <span
                            class="flex items-center gap-1.5"
                            x-show="followupEmail"
                        >
                            <i
                                data-lucide="mail"
                                class="h-3.5 w-3.5"
                            ></i>

                            <span x-text="followupEmail"></span>
                        </span>


                        <span
                            class="flex items-center gap-1.5"
                            x-show="followupService"
                        >
                            <i
                                data-lucide="tag"
                                class="h-3.5 w-3.5"
                            ></i>

                            <span x-text="followupService"></span>
                        </span>

                    </div>
                </div>


                <!-- Close -->
                <button
                    type="button"
                    @click="followup = null"
                    class="flex h-9 w-9 shrink-0 items-center
                           justify-center rounded-lg bg-secondary"
                >
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>

            </div>


            <!-- Scrollable Content -->
            <div
                class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-5"
            >

                <form
                    :action="'/business/leads/' + followup + '/follow-ups'"
                    method="POST"
                    id="followup-form"
                    class="space-y-4"
                    @submit.prevent="
                        enquiryController.storeFollowUp(
                            followup,
                            $event.target
                        )
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
                                class="mb-2 block text-sm font-medium
                                       text-slate-700"
                            >
                                Status
                            </label>

                            <select
                                name="status"
                                id="followup_status"
                                class="form-input"
                                onchange="toggleFollowUpDate(this)"
                            >

                                <option value="">
                                    Select Status
                                </option>

                                @if($statues)

                                    @foreach($statues as $status)

                                        <option
                                            value="{{ $status->id }}"
                                            data-name="{{ strtolower(trim($status->name)) }}"
                                        >
                                            {{ $status->name }}
                                        </option>

                                    @endforeach

                                @endif

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
                                    type="datetime-local"
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


                    <!-- Save -->
                    <div class="flex justify-end gap-2 pt-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Save Follow
                        </button>

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
    const applyBtn = document.getElementById('applyFollowUpDateBtn');

    if (statusName === 'not interested') {

        // Clear selected date
        dateInput.value = '';

        // Disable date
        dateInput.disabled = true;

        // Disable Apply button
        applyBtn.disabled = true;

        // Tailwind disabled appearance
        dateInput.classList.add(
            'cursor-not-allowed',
            'bg-gray-100',
            'opacity-60'
        );

        applyBtn.classList.add(
            'cursor-not-allowed',
            'opacity-50'
        );

    } else {

        dateInput.disabled = false;
        applyBtn.disabled = false;

        dateInput.classList.remove(
            'cursor-not-allowed',
            'bg-gray-100',
            'opacity-60'
        );

        applyBtn.classList.remove(
            'cursor-not-allowed',
            'opacity-50'
        );
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

        if (!leadId || !form) return;

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : '';

        // Remove previous validation errors
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

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Saving...';
            }

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
                throw {
                    message: 'Invalid server response.'
                };
            }

            if (!response.ok) {
                throw data;
            }

            // Clear form after successful save
            form.reset();

            // Optional success message
            this.showFormMessage(
                form,
                data.message || 'Follow-up saved successfully.',
                'success'
            );

            /*
             * IMPORTANT:
             * leadId here is your assignment id.
             * History requires raw lead_id.
             */
            const rawLeadId = form.querySelector('[name="lead_id"]')?.value;

            if (rawLeadId) {
                await this.getAllFollowUps(rawLeadId, 5);
            }

        } catch (error) {

            console.error('storeFollowUp failed:', error);

            /*
             * Laravel validation errors
             */
            if (error.errors) {

                Object.keys(error.errors).forEach(key => {

                    const field = form.querySelector(`[name="${key}"]`);

                    if (!field) return;

                    // Red field border
                    field.classList.add(
                        'border-red-500',
                        'ring-1',
                        'ring-red-500',
                        'focus:border-red-500',
                        'focus:ring-red-500'
                    );

                    // Error text
                    const errorText = document.createElement('p');

                    errorText.className =
                        'validation-error mt-1 text-xs font-medium text-red-600';

                    errorText.textContent =
                        Array.isArray(error.errors[key])
                            ? error.errors[key][0]
                            : error.errors[key];

                    field.insertAdjacentElement('afterend', errorText);
                });

                // Focus first invalid field
                const firstInvalid = form.querySelector('.border-red-500');

                if (firstInvalid) {
                    firstInvalid.focus();
                }

            } else {

                this.showFormMessage(
                    form,
                    error.message || 'Unable to save follow-up.',
                    'error'
                );
            }

        } finally {

            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML =
                    originalBtnText || 'Save Follow-up';
            }
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

// document.addEventListener('click', function (e) {
//     const el = e.target.closest('.favorited');
//     if (!el) return;

//     e.preventDefault();
 
//     const favoritleads = el.dataset.favoritleads;
 
//     const clientId = el.dataset.clientId;
//     if (!favoritleads || !clientId  || el.classList.contains('is-loading')) return;

//     el.classList.add('is-loading');

//     fetch('/business/favoritleads', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//             'X-Requested-With': 'XMLHttpRequest',
//             'Accept': 'application/json',
//         },
//         body: JSON.stringify({ assingId: favoritleads,clientId:clientId }),
//     })
//         .then(res => res.json())
//         .then(data => {
          
//             if (data.status) {
 

//                alert('Favorite lead updated');
//             } else {
//                alert('Favorite lead not updated');
//             }
//         })
//         .catch(err => {
             
//             console.error('readLead request failed:', err);
//         });
// });


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