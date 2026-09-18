<h4 class="tw-section-title">Business FAQ</h4>

<form x-data="ajaxForm('{{ url('developer/clients/update')."/".($client->id ?? '') }}')" @submit.prevent="submit($event)">
    @csrf
    <input type="hidden" name="business_faq" value="business_faq">

    <div class="space-y-6">
        @for ($i = 1; $i <= 10; $i++)
            @php
                $qField = "faqq{$i}";
                $aField = "faqa{$i}";
            @endphp
            <div class="tw-card">
                <p class="text-xs font-semibold text-indigo-600 mb-2">FAQ {{ $i }}</p>
                <div class="space-y-3">
                    <div>
                        <label class="tw-label">Question {{ $i }}</label>
                        <input type="text" name="{{ $qField }}" class="tw-input"
                            placeholder="Enter FAQ Question {{ $i }}"
                            value="{{ old($qField, $client->$qField ?? '') }}">
                    </div>
                    <div>
                        <label class="tw-label">Answer {{ $i }}</label>
                        <textarea name="{{ $aField }}" class="tw-textarea"
                            placeholder="Enter FAQ Answer {{ $i }}">{{ old($aField, $client->$aField ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="tw-btn-warning" :disabled="saving">
            <span x-show="!saving">SAVE</span>
            <span x-show="saving" x-cloak>Saving…</span>
        </button>
    </div>
</form>
