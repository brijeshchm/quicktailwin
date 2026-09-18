<h4 class="tw-section-title">Recent Activity</h4>

<form
    id="recentActivityForm"
    enctype="multipart/form-data"
    x-data="ajaxForm('{{ url('developer/clients/save-recent-activity-auto')."/".($client->id ?? '') }}')"
    @change.debounce.800ms="submit($event)"
>
    @csrf
    <input type="hidden" name="business_id" value="{{ $client->id ?? '' }}">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @for ($i = 1; $i <= 6; $i++)
            @php
                $imgField = "recent_img{$i}";
                $nameField = "recent_name{$i}";
                $paraField = "recent_paragraph{$i}";
                $fileData = !empty($client->$imgField) ? json_decode($client->$imgField) : null;
                $path = $fileData->large->src ?? '';
                $url = $path ? asset($path) : '';
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $required = $i === 1;
            @endphp

            <div class="tw-card flex flex-col gap-3" x-data="removableFile">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-600 text-white text-xs font-bold">
                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <span class="text-sm font-semibold text-gray-800">
                        Recent Activity {{ $i }} @if ($required)<span class="text-red-500">*</span>@endif
                    </span>
                </div>

                @if ($path)
                    <div class="relative">
                        @if ($ext === 'pdf')
                            <embed src="{{ $url }}" type="application/pdf" class="w-full h-40 rounded-lg border border-gray-200">
                            <a href="{{ $url }}" target="_blank" class="tw-btn-ghost text-xs absolute bottom-2 left-2">View PDF</a>
                        @else
                            <img loading="lazy" src="{{ $url }}" class="w-full h-40 object-cover rounded-lg border border-gray-200">
                        @endif
                        <button type="button"
                            class="absolute top-2 right-2 w-8 h-8 flex items-center justify-center rounded-lg bg-red-600 text-white hover:bg-red-700"
                            :disabled="removing"
                            @click="remove('{{ url('developer/clients/recent/'.$imgField.'/'.($client->id ?? '')) }}')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                @else
                    <label class="w-full h-40 flex flex-col items-center justify-center gap-1 rounded-lg border-2 border-dashed border-gray-300 text-gray-400 hover:border-indigo-400 hover:text-indigo-500 cursor-pointer transition text-center px-2">
                        <span class="text-2xl">☁️</span>
                        <span class="text-sm font-medium">Click to upload</span>
                        <span class="text-xs">JPG, PNG, WEBP — max 5MB</span>
                        <input type="file" name="{{ $imgField }}" accept=".jpg,.jpeg,.png,.webp" class="hidden" @required($required)>
                    </label>
                @endif

                <div>
                    <label class="tw-label">Activity Name</label>
                    <input type="text" name="{{ $nameField }}" class="tw-input"
                        value="{{ old($nameField, $client->$nameField ?? '') }}"
                        placeholder="e.g. Event title {{ $i }}" @required($required)>
                </div>

                <div>
                    <label class="tw-label">Description</label>
                    <textarea name="{{ $paraField }}" rows="3" class="tw-textarea"
                        placeholder="Briefly describe this activity...">{{ old($paraField, $client->$paraField ?? '') }}</textarea>
                </div>
            </div>
        @endfor
    </div>

    <p class="mt-4 text-xs text-gray-400" x-show="saving" x-cloak>Saving…</p>
</form>
