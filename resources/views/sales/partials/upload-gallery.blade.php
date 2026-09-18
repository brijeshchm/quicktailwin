<h4 class="tw-section-title">Upload Gallery</h4>

@php
    $picture = !empty($client->pictures) ? unserialize($client->pictures) : [];
@endphp

<form
    enctype="multipart/form-data"
    x-data="ajaxForm('{{ url('developer/clients/uploadClientGalleryPics')."/".($client->id ?? '') }}')"
    @change.debounce.800ms="submit($event)"
>
    @csrf
    <input type="hidden" name="business_id" value="{{ $client->id ?? '' }}">
    <input type="hidden" name="upload_pics" value="upload_pics">

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @for ($i = 0; $i < 30; $i++)
            @php $src = $picture[$i]['large']['src'] ?? null; @endphp
            <div class="tw-card flex flex-col items-center gap-2" x-data="removableFile">
                @if ($src)
                    <img loading="lazy" src="{{ asset('/' . $src) }}" class="w-full h-28 object-cover rounded-lg">
                    <button type="button" class="tw-btn-danger w-full text-xs" :disabled="removing"
                        @click="remove('{{ url('developer/clients/gallery/remove/'.($client->id ?? '').'/'.$i) }}')">
                        <span x-show="!removing">Remove</span>
                        <span x-show="removing" x-cloak>Removing…</span>
                    </button>
                @else
                    <label class="w-full h-28 flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300 text-xs text-gray-400 hover:border-indigo-400 hover:text-indigo-500 cursor-pointer transition">
                        <span>Drop / Click to upload</span>
                        <input type="file" name="image{{ $i + 1 }}" accept=".png,.jpg,.jpeg,.webp,.svg" class="hidden">
                    </label>
                @endif
            </div>
        @endfor
    </div>

    <p class="mt-4 text-xs text-gray-400" x-show="saving" x-cloak>Uploading…</p>
</form>
