<h4 class="tw-section-title">View All Leads</h4>

{{--
    Original was fed by a jQuery DataTables ajax source. Point
    simple-datatables at your existing leads JSON endpoint, e.g.:

        x-init="
            fetch('{{ url('developer/clients/leads-data/'.($client->id ?? '')) }}')
                .then(r => r.json())
                .then(rows => dataTable($el, { data: { headings: [...], data: rows } }))
        "
--}}
<div class="overflow-x-auto tw-card">
    <table class="tw-table" x-init="dataTable($el)">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Course</th>
                <th>City</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($leads as $lead) ... @endforeach --}}
        </tbody>
    </table>
</div>

@if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('export_assign_lead'))
    <form class="mt-4" x-data="ajaxForm('{{ url('developer/clients/update')."/".($client->username ?? '') }}')" @submit.prevent="submit($event)">
        @csrf
        <button type="submit" name="lead-export" value="1" class="tw-btn-success" :disabled="saving">
            <span x-show="!saving">Export</span>
            <span x-show="saving" x-cloak>Exporting…</span>
        </button>
    </form>
@endif
