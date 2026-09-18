<h4 class="tw-section-title">Business Location</h4>

<form
    x-data="{
        ...ajaxForm('{{ url('developer/clients/assignZone') }}'),
        ...locationCascade({})
    }"
    @submit.prevent="submit($event)"
>
    @csrf
    <input type="hidden" name="client_id" value="{{ $client->id ?? '' }}">

    <div class="tw-grid-form">
        <div>
            <label class="tw-label">Country</label>
            <select name="country" class="tw-select" x-init="tomSelect($el)">
                <option value="">Select Country</option>
                <option value="101" selected>India</option>
            </select>
        </div>

        <div>
            <label class="tw-label tw-required">State</label>
            <select name="state_id" class="tw-select" x-init="tomSelect($el)" x-model="state" @change="onStateChange()">
                <option value="">Select State</option>
                @if ($statesis)
                    @foreach ($statesis as $stateOpt)
                        <option value="{{ $stateOpt->id }}">{{ $stateOpt->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div>
            <label class="tw-label">City</label>
            <select name="cityid" class="tw-select" x-init="tomSelect($el)" x-model="city" @change="onCityChange()">
                <option value="">Select City</option>
                <template x-for="c in cities" :key="c.id">
                    <option :value="c.id" x-text="c.name"></option>
                </template>
            </select>
        </div>

        <div>
            <label class="tw-label">Zone</label>
            <select name="zone_id" class="tw-select" x-init="tomSelect($el)" x-model="zone">
                <option value="">Select Zone</option>
                <template x-for="z in zones" :key="z.id">
                    <option :value="z.id" x-text="z.name"></option>
                </template>
            </select>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="tw-btn-warning" :disabled="saving">
            <span x-show="!saving">Submit</span>
            <span x-show="saving" x-cloak>Submitting…</span>
        </button>
    </div>
</form>

{{--
    Assigned zones table.
    Original used a jQuery DataTable fed by a server-side "ajax" source
    (assignedZoneController, not included in the shared code).
    Point simple-datatables at a JSON endpoint that returns
    { data: [[checkbox, city, zone, actionHtml], ...] } or render rows
    server-side in Blade and just let simple-datatables handle
    search/sort/paginate on the static markup below.
--}}
<div class="mt-8">
    <div class="overflow-x-auto tw-card">
        <table class="tw-table" x-init="dataTable($el)">
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all" class="tw-checkbox"></th>
                    <th>City</th>
                    <th>Zone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($assignedZones as $az) ... @endforeach --}}
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <button type="button" onclick="assignedZoneController.selectDeleteParmanent()" class="tw-btn-success">
            Delete All
        </button>
    </div>
</div>
