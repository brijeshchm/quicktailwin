<h4 class="tw-section-title">Business Information</h4>

@php
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    $times = ['24:00' => 'Open 24 Hrs', '00:00' => 'Closed'];
    for ($h = 0; $h < 24; $h++) {
        foreach (['00', '30'] as $m) {
            $key = sprintf('%02d:%s', $h, $m);
            $times[$key] = $key;
        }
    }
    $time = !empty($client->time) ? json_decode($client->time) : null;
@endphp

<form
    x-data="{
        ...ajaxForm('{{ url('developer/clients/update')."/".($client->id ?? '') }}'),
        ...locationCascade({
            state: '{{ $client->state_id ?? '' }}',
            city: '{{ $client->city_id ?? '' }}',
            zone: '{{ $client->zone_id ?? '' }}',
        })
    }"
    @submit.prevent="submit($event)"
>
    @csrf
    <input type="hidden" name="contact_info" value="contact_info">

    <div class="tw-grid-form">
        <div>
            <label class="tw-label">Business Name</label>
            <input type="text" name="business_name" class="tw-input"
                value="{{ old('business_name', $client->business_name ?? '') }}" placeholder="Please enter business name">
        </div>

        <div>
            <label class="tw-label">Business Slug</label>
            <input type="text" name="business_slug" class="tw-input"
                value="{{ old('business_slug', $client->business_slug ?? '') }}" placeholder="Please enter business Slug">
        </div>

        <div>
            <label class="tw-label tw-required">Email</label>
            <input type="email" name="email" id="Email" class="tw-input"
                value="{{ old('email', $client->email ?? '') }}" placeholder="Please enter Email">
        </div>

        <div>
            <label class="tw-label tw-required">Primary Mobile No</label>
            <input type="text" name="mobile" class="tw-input"
                value="{{ old('mobile', $client->mobile ?? '') }}" placeholder="Enter Primary Number">
        </div>

        <div>
            <label class="tw-label">WhatsApp</label>
            <input type="text" name="whatsapp" class="tw-input"
                value="{{ old('whatsapp', $client->whatsapp ?? '') }}" placeholder="Enter whats app">
        </div>

        <div>
            <label class="tw-label">Country</label>
            <select name="country" class="tw-select" x-init="tomSelect($el)">
                <option value="101" selected>India</option>
            </select>
        </div>

        <div>
            <label class="tw-label">State</label>
            <select name="state" class="tw-select" x-init="tomSelect($el)" x-model="state" @change="onStateChange()">
                @if ($statesis)
                    @foreach ($statesis as $stateOpt)
                        <option value="{{ $stateOpt->id }}">{{ $stateOpt->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div>
            <label class="tw-label">City</label>
            <select name="city" class="tw-select" x-init="tomSelect($el)" x-model="city" @change="onCityChange()">
                <option value="">Select City</option>
                <template x-for="c in cities" :key="c.id">
                    <option :value="c.id" x-text="c.name" :selected="c.id == city"></option>
                </template>
            </select>
        </div>

        <div>
            <label class="tw-label">Zone</label>
            <select name="zone" class="tw-select" x-init="tomSelect($el)" x-model="zone">
                <option value="">Select Zone</option>
                <template x-for="z in zones" :key="z.id">
                    <option :value="z.id" x-text="z.name" :selected="z.id == zone"></option>
                </template>
            </select>
        </div>

        <div>
            <label class="tw-label">Area</label>
            <input type="text" name="area" class="tw-input"
                value="{{ old('area', $client->area ?? '') }}" placeholder="Enter Area">
        </div>

        <div>
            <label class="tw-label">Pincode</label>
            <input type="text" name="pincode" class="tw-input"
                value="{{ old('pincode', $client->pincode ?? '') }}" placeholder="Enter Pincode">
        </div>

        <div>
            <label class="tw-label">Landmark</label>
            <input type="text" name="landmark" class="tw-input"
                value="{{ old('landmark', $client->landmark ?? '') }}">
        </div>

        <div class="md:col-span-2">
            <label class="tw-label">Address</label>
            <textarea name="address" class="tw-textarea">{{ old('address', $client->address ?? '') }}</textarea>
        </div>

        <div>
            <label class="tw-label">Google Map</label>
            <input type="text" name="business_map" class="tw-input"
                value="{{ old('business_map', $client->business_map ?? '') }}">
        </div>

        <div>
            <label class="tw-label">Website</label>
            <input type="text" name="website" class="tw-input"
                value="{{ old('website', $client->website ?? '') }}" placeholder="Enter Website">
        </div>
    </div>

    {{-- Hours of operation --}}
    <div class="mt-8">
        <h5 class="text-sm font-semibold text-gray-700 mb-3">Weekly Hours</h5>
        <div class="tw-card divide-y divide-gray-100">
            @foreach ($days as $day)
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 py-3 first:pt-0 last:pb-0">
                    <span class="sm:w-28 font-medium text-gray-700 capitalize">{{ $day }}</span>

                    <select name="time[{{ $day }}][from]" class="tw-select sm:max-w-xs" x-init="tomSelect($el)">
                        @foreach ($times as $key => $label)
                            <option value="{{ $key }}" @selected(!empty($time?->$day?->from) && $time->$day->from === $key)>{{ $label }}</option>
                        @endforeach
                    </select>

                    <span class="text-sm font-semibold text-gray-500 px-2">To</span>

                    <select name="time[{{ $day }}][to]" class="tw-select sm:max-w-xs" x-init="tomSelect($el)">
                        @foreach ($times as $key => $label)
                            <option value="{{ $key }}" @selected(!empty($time?->$day?->to) && $time->$day->to === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-6">
        <span class="tw-label">Hours of Operation</span>
        <div class="flex flex-col sm:flex-row gap-4">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="radio" name="display_hofo" value="1" class="tw-radio"
                    @checked(empty($client->display_hofo) === false && $client->display_hofo == '1')>
                Display Hours of Operation
            </label>
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="radio" name="display_hofo" value="0" class="tw-radio"
                    @checked(empty($client->display_hofo) || $client->display_hofo == '0')>
                Do Not Display Hours of Operation
            </label>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="tw-btn-warning" :disabled="saving">
            <span x-show="!saving">SAVE</span>
            <span x-show="saving" x-cloak>Saving…</span>
        </button>
    </div>
</form>
