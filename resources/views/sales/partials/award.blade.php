<h4 class="tw-section-title">Award</h4>

<form
    id="awardForm"
    enctype="multipart/form-data"
    x-data="ajaxForm('{{ url('developer/clients/save-award-auto')."/".($client->id ?? '') }}')"
    @change.debounce.800ms="submit($event)"
>
    @csrf
    <input type="hidden" name="business_id" value="{{ $client->id ?? '' }}">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @for ($i = 1; $i <= 9; $i++)
            @php
                $nameField = "award_name{$i}";
                $imgField = "award_img{$i}";
                $fileData = !empty($client->$imgField) ? json_decode($client->$imgField) : null;
                $path = $fileData->large->src ?? '';
                $url = $path ? asset($path) : '';
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $required = in_array($i, [1, 4, 7]);
            @endphp

            <div class="tw-card min-h-[210px] flex flex-col gap-3" x-data="removableFile">
                <label class="tw-label mb-0 {{ $required ? 'tw-required' : '' }}">Award {{ $i }}</label>

                <input type="text" name="{{ $nameField }}" class="tw-input"
                    value="{{ old($nameField, $client->$nameField ?? '') }}"
                    placeholder="Please enter Award name {{ $i }}">

                @if ($path)
                    <div class="flex items-start gap-2">
                        @if ($ext === 'pdf')
                            <embed src="{{ $url }}" type="application/pdf" class="w-24 h-24 border border-gray-200 rounded">
                            <a href="{{ $url }}" target="_blank" class="tw-btn-ghost text-xs">View</a>
                        @else
                            <img loading="lazy" src="{{ $url }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                        @endif
                        <button type="button" class="tw-btn-danger text-xs" :disabled="removing"
                            @click="remove('{{ url('developer/clients/award/'.$imgField.'/'.($client->id ?? '')) }}')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                @else
                    <input type="file" name="{{ $imgField }}" accept=".jpg,.jpeg,.png,.webp"
                        class="tw-input file:mr-3 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-1 file:text-indigo-700 hover:file:bg-indigo-100">
                @endif
            </div>
        @endfor
    </div>

    <p class="mt-4 text-xs text-gray-400" x-show="saving" x-cloak>Saving…</p>
</form>
