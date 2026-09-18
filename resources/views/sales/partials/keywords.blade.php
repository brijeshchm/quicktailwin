<h4 class="tw-section-title">Assigned Keywords</h4>

<form
    x-data="ajaxForm('{{ url('developer/clients/update')."/".($client->username ?? '') }}')"
    @submit.prevent="submit($event)"
>
    @csrf
    <input type="hidden" name="client_id" value="{{ $client->username ?? '' }}">
    <input type="hidden" name="kw-submit" value="kw-submit">

    <div>
        <label class="tw-label">Keywords</label>
        <select name="keyword[]" multiple class="tw-select" x-init="tomSelect($el, { plugins: ['remove_button'] })">
            @if ($keywordlist)
                @foreach ($keywordlist as $key)
                    <option value="{{ $key->id }}">{{ $key->keyword }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="mt-4">
        <button type="submit" class="tw-btn-warning" :disabled="saving">
            <span x-show="!saving">Submit</span>
            <span x-show="saving" x-cloak>Submitting…</span>
        </button>
    </div>
</form>

{{--
    Assigned keywords table — original was populated by a jQuery DataTable
    ajax source (assignedKeywordController, not included in shared code).
    Wire simple-datatables to your JSON endpoint, or server-render <tbody> rows.
--}}
<div class="mt-8 overflow-x-auto tw-card">
    <table class="tw-table" x-init="dataTable($el)">
        <caption class="text-left text-sm font-semibold text-gray-700 mb-2">Assigned Keywords</caption>
        <thead>
            <tr>
                <th><input type="checkbox" id="check-all" class="tw-checkbox"></th>
                <th>KW</th>
                <th>Child Category</th>
                <th>Parent Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($assignedKeywords as $kw) ... @endforeach --}}
        </tbody>
    </table>
</div>

<form class="mt-4 flex flex-wrap gap-3" x-data="ajaxForm('{{ url('developer/clients/update')."/".($client->username ?? '') }}')" @submit.prevent="submit($event)">
    @csrf
    @if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('export_assign_keyword'))
        <button type="submit" name="kw-export" value="1" class="tw-btn-success">Export</button>
    @endif
    @if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('assign_keyword_delete'))
        <button type="button" class="tw-btn-success" onclick="assignedKeywordController.deleteSelectedAssignedKwds()">
            Delete Selected
        </button>
    @endif
</form>
