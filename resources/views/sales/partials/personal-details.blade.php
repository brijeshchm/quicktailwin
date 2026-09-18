<h4 class="tw-section-title">Personal Details</h4>

<form
    autocomplete="off"
    x-data="{
        ...ajaxForm('{{ url('developer/clients/update')."/".($client->id ?? '') }}'),
        ...locationCascade({
            state: '{{ $client->personal_state_id ?? '' }}',
            city: '{{ $client->personal_city_id ?? '' }}',
            zone: '{{ $client->personal_zone_id ?? '' }}',
        })
    }"
    @submit.prevent="submit($event)"
>
    @csrf
    <input type="hidden" name="location_info" value="location_info">

    <div class="tw-grid-form">

        <div>
            <label class="tw-label tw-required">Title</label>
            <select name="sirName" class="tw-select" x-init="tomSelect($el)">
                <option value="">Select Sir Name</option>
                @foreach (['Ms', 'Mr', 'Mrs'] as $title)
                    <option value="{{ $title }}" @selected(old('sirName', $client->sirName ?? '') === $title)>{{ $title }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="tw-label tw-required">First Name</label>
            <input type="text" name="first_name" class="tw-input"
                value="{{ old('first_name', $client->first_name ?? '') }}" placeholder="Enter First Name">
        </div>

        <div>
            <label class="tw-label">Middle Name</label>
            <input type="text" name="middle_name" class="tw-input"
                value="{{ old('middle_name', $client->middle_name ?? '') }}" placeholder="Enter Middle Name">
        </div>

        <div>
            <label class="tw-label">Last Name</label>
            <input type="text" name="last_name" class="tw-input"
                value="{{ old('last_name', $client->last_name ?? '') }}" placeholder="Enter Last Name">
        </div>

        <div>
            <label class="tw-label tw-required">DOB</label>
            <input type="text" name="dob" class="tw-input dob"
                value="{{ old('dob', $client->dob ?? '') }}" placeholder="Enter DOB">
        </div>

        <div>
            <label class="tw-label tw-required">Email ID</label>
            <input type="email" name="personal_email" class="tw-input"
                value="{{ old('personal_email', $client->personal_email ?? '') }}" placeholder="Enter Email">
        </div>

        <div>
            <label class="tw-label tw-required">Marital Status</label>
            <select name="marital" class="tw-select" x-init="tomSelect($el)">
                @foreach (['Single', 'Married', 'Widowed', 'Divorced'] as $status)
                    <option value="{{ $status }}" @selected(old('marital', $client->marital ?? '') === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="tw-label tw-required">Mobile</label>
            <input type="text" name="personal_phone" class="tw-input"
                value="{{ old('personal_phone', $client->personal_phone ?? '') }}" placeholder="Enter personal Mobile">
        </div>

        <div>
            <label class="tw-label">Country</label>
            <select name="country" class="tw-select" x-init="tomSelect($el)">
                <option value="101" selected>India</option>
            </select>
        </div>

        <div>
            <label class="tw-label">State</label>
            <select name="personal_state" class="tw-select" x-init="tomSelect($el)" x-model="state" @change="onStateChange()">
                @if ($statesis)
                    @foreach ($statesis as $stateOpt)
                        <option value="{{ $stateOpt->id }}">{{ $stateOpt->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div>
            <label class="tw-label">City</label>
            <select name="personal_city" class="tw-select" x-init="tomSelect($el)" x-model="city" @change="onCityChange()">
                <option value="">Select City</option>
                <template x-for="c in cities" :key="c.id">
                    <option :value="c.id" x-text="c.name" :selected="c.id == city"></option>
                </template>
            </select>
        </div>

        <div>
            <label class="tw-label">Zone</label>
            <select name="personal_zone" class="tw-select" x-init="tomSelect($el)" x-model="zone">
                <option value="">Select Zone</option>
                <template x-for="z in zones" :key="z.id">
                    <option :value="z.id" x-text="z.name" :selected="z.id == zone"></option>
                </template>
            </select>
        </div>

        <div>
            <label class="tw-label">Area</label>
            <input type="text" name="personal_area" class="tw-input"
                value="{{ old('personal_area', $client->personal_area ?? '') }}" placeholder="Enter personal Area">
        </div>

        <div>
            <label class="tw-label">Pincode</label>
            <input type="text" name="personal_pincode" maxlength="6" class="tw-input"
                value="{{ old('personal_pincode', $client->personal_pincode ?? '') }}" placeholder="Enter Personal Pincode">
        </div>

        <div class="md:col-span-2">
            <label class="tw-label">Address</label>
            <textarea name="personal_address" class="tw-textarea" placeholder="Enter personal address">{{ old('personal_address', $client->personal_address ?? '') }}</textarea>
        </div>

        <div>
            <label class="tw-label">Gender</label>
            <select name="gender" class="tw-select" x-init="tomSelect($el)">
                <option>Select Gender</option>
                @foreach (['Male', 'Female', 'Other'] as $gender)
                    <option value="{{ $gender }}" @selected(old('gender', $client->gender ?? '') === $gender)>{{ $gender }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="tw-btn-warning" :disabled="saving">
            <span x-show="!saving">SAVE</span>
            <span x-show="saving" x-cloak>Saving…</span>
        </button>
    </div>
</form>
