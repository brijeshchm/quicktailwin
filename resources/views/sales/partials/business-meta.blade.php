<h4 class="tw-section-title">Business Meta</h4>

<form x-data="ajaxForm('{{ url('developer/clients/update')."/".($client->id ?? '') }}')" @submit.prevent="submit($event)">
    @csrf
    <input type="hidden" name="business_meta" value="business_meta">

    <div class="space-y-5">
        <div>
            <label class="tw-label">Meta Title</label>
            <textarea name="meta_title" class="tw-textarea" placeholder="Please enter meta title">{{ old('meta_title', $client->meta_title ?? '') }}</textarea>
        </div>

        <div>
            <label class="tw-label">H1 Heading</label>
            <input type="text" name="h1_heading" class="tw-input"
                value="{{ old('h1_heading', $client->h1_heading ?? '') }}" placeholder="Please enter H1 Heading">
        </div>

        <div>
            <label class="tw-label">Meta Description</label>
            <textarea name="meta_description" class="tw-textarea" placeholder="Please enter meta description">{{ old('meta_description', $client->meta_description ?? '') }}</textarea>
        </div>

        <div>
            <label class="tw-label">Business Intro</label>
            <input id="business_intro_hidden" type="hidden" name="business_intro"
                value="{{ old('business_intro', $client->business_intro ?? '') }}">
            <trix-editor input="business_intro_hidden"></trix-editor>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="tw-btn-warning" :disabled="saving">
            <span x-show="!saving">SAVE</span>
            <span x-show="saving" x-cloak>Saving…</span>
        </button>
    </div>
</form>
