<h4 class="tw-section-title">Company Logo</h4>

@php
    $logo = !empty($client->logo) ? unserialize($client->logo) : null;
    if ($logo && !isset($logo['thumbnail'])) $logo['thumbnail'] = $logo['large'];

    $profilePic = !empty($client->profile_pic) ? unserialize($client->profile_pic) : null;
    if ($profilePic && !isset($profilePic['thumbnail'])) $profilePic['thumbnail'] = $profilePic['large'];
@endphp

<form
    enctype="multipart/form-data"
    x-data="ajaxForm('{{ url('developer/clients/editSaveClientProfileLogo')."/".($client->id ?? '') }}')"
    @change.debounce.800ms="submit($event)"
>
    @csrf
    <input type="hidden" name="business_id" value="{{ $client->id ?? '' }}">
    <input type="hidden" name="upload_pics" value="upload_pics">

    <div class="tw-grid-form">
        <div>
            <label class="tw-label">Year of Establishment</label>
            <select id="year_of_estb" name="year_of_estb" class="tw-select" x-init="tomSelect($el)">
                <option value="">Select Year</option>
                @for ($y = 1970; $y <= 2050; $y++)
                    <option value="{{ $y }}" @selected(old('year_of_estb', $client->year_of_estb ?? '') == $y)>{{ $y }}</option>
                @endfor
            </select>
        </div>

        <div>
            <label class="tw-label">Certifications</label>
            <input type="text" id="certifications" name="certifications" class="tw-input"
                value="{{ old('certifications', $client->certifications ?? '') }}"
                placeholder="Comma separated certifications">
        </div>
    </div>

    <div class="tw-grid-form mt-6">
        {{-- Logo --}}
        <div>
            <label class="tw-label">Upload Logo</label>
            @if ($logo)
                <div class="flex items-center gap-3" x-data="removableFile">
                    <img loading="lazy" src="{{ asset('/' . $logo['thumbnail']['src']) }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                    <button type="button" class="tw-btn-danger" :disabled="removing"
                        @click="remove('{{ url('developer/clients/update/profileLogo/logoDel/'.($client->username ?? '')) }}')">
                        Remove
                    </button>
                </div>
            @else
                <input type="file" id="logo" name="logo" accept=".png,.jpeg,.jpg,.webp,.svg"
                    class="tw-input file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-indigo-700 hover:file:bg-indigo-100">
            @endif
        </div>

        {{-- Profile pic --}}
        <div>
            <label class="tw-label">Upload Profile Pic</label>
            @if ($profilePic && !empty($profilePic['thumbnail']))
                <div class="flex items-center gap-3" x-data="removableFile">
                    <img loading="lazy" src="{{ asset('/' . $profilePic['thumbnail']['src']) }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                    <button type="button" class="tw-btn-danger" :disabled="removing"
                        @click="remove('{{ url('developer/clients/update/profileLogo/profilePicDel/'.($client->username ?? '')) }}')">
                        Remove
                    </button>
                </div>
            @else
                <input type="file" id="profile_pic" name="profile_pic" accept=".png,.jpeg,.jpg,.webp,.svg"
                    class="tw-input file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-indigo-700 hover:file:bg-indigo-100">
            @endif
        </div>
    </div>

    <p class="mt-4 text-xs text-gray-400" x-show="saving" x-cloak>Uploading…</p>
</form>
