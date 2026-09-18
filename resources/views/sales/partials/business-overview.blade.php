<h4 class="tw-section-title">Business Overview</h4>

<form x-data="ajaxForm('{{ url('developer/clients/update')."/".($client->id ?? '') }}')" @submit.prevent="submit($event)">
    @csrf
    <input type="hidden" name="business_overView" value="business_overView">

    <div class="space-y-5">
        <div>
            <label class="tw-label">Short Description (350 characters)</label>
            <textarea name="business_description" class="tw-textarea" placeholder="Please enter business Description">{{ old('business_description', $client->business_description ?? '') }}</textarea>
        </div>

        <div>
            <label class="tw-label">Business Overview</label>
            <input id="business_overview_hidden" type="hidden" name="business_overview"
                value="{{ old('business_overview', $client->business_overview ?? '') }}">
            <trix-editor input="business_overview_hidden"></trix-editor>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="tw-btn-warning" :disabled="saving">
            <span x-show="!saving">SAVE</span>
            <span x-show="saving" x-cloak>Saving…</span>
        </button>
    </div>
</form>
