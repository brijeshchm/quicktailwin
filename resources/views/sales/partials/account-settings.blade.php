<h4 class="tw-section-title">Account Settings</h4>

@php
    $toggles = [
        ['field' => 'active_status', 'label' => 'Client Active Status', 'submitField' => 'submit_active_status'],
        ['field' => 'paid_status', 'label' => 'Client Paid Status', 'submitField' => 'submit_paid_status'],
        ['field' => 'certified_status', 'label' => 'Client Certified Status', 'submitField' => 'submit_certified_status'],
        ['field' => 'trusted_status', 'label' => 'Client Trusted Status', 'submitField' => 'submit_trusted_status'],
        ['field' => 'gst_status', 'label' => 'GST Status', 'submitField' => 'submit_gst_status'],
    ];
    $updateUrl = url('developer/clients/update') . '/' . ($client->username ?? '');
    $userList = getUserList();
    $catService = getOverViewBusiness();
    $clientTypes = getClientsType();
@endphp

{{-- Toggle switches --}}
<div class="tw-card divide-y divide-gray-100">
    @foreach ($toggles as $toggle)
        <form class="flex items-center justify-between py-3 first:pt-0 last:pb-0"
            x-data="ajaxForm('{{ $updateUrl }}')" @change="submit($event)">
            @csrf
            <span class="text-sm font-medium text-gray-700">{{ $toggle['label'] }}</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="{{ $toggle['field'] }}" value="1" class="sr-only peer"
                    @checked($client->{$toggle['field']} ?? false)>
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 transition-colors"></div>
                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-5"></div>
            </label>
            <input type="hidden" name="{{ $toggle['submitField'] }}" value="1">
        </form>
    @endforeach
</div>

{{-- Assign Client --}}
<form class="tw-card mt-6" x-data="ajaxForm('{{ $updateUrl }}')" @change="submit($event)">
    @csrf
    <input type="hidden" name="client_id" value="{{ $client->username ?? '' }}">
    <input type="hidden" name="submit_client_assign" value="1">

    <label class="tw-label">Assign Client</label>
    @if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('client_package_name'))
        <select name="created_by" class="tw-select" x-init="tomSelect($el)">
            @foreach ($userList as $user)
                <option value="{{ $user->id }}" @selected($user->id == ($client->created_by ?? null))>
                    {{ $user->first_name }} {{ $user->last_name }}
                </option>
            @endforeach
        </select>
    @else
        @foreach ($userList as $user)
            @if ($user->id == ($client->created_by ?? null))
                <p class="text-sm text-gray-700">{{ $user->first_name }} {{ $user->last_name }}</p>
            @endif
        @endforeach
    @endif
</form>

{{-- Category Service --}}
<form class="tw-card mt-6" x-data="ajaxForm('{{ $updateUrl }}')" @change="submit($event)">
    @csrf
    <input type="hidden" name="client_id" value="{{ $client->username ?? '' }}">
    <input type="hidden" name="client_cat_service" value="1">

    <label class="tw-label">Category Service</label>
    <select name="category_service" class="tw-select" x-init="tomSelect($el)">
        @foreach ($catService as $key => $value)
            <option value="{{ $key }}" @selected($key == ($client->category_service ?? null))>{{ ucfirst($key) }}</option>
        @endforeach
    </select>
</form>

{{-- Client Package --}}
<form class="tw-card mt-6" x-data="ajaxForm('{{ $updateUrl }}')" @change="submit($event)">
    @csrf
    <input type="hidden" name="submit_client_type" value="1">

    <label class="tw-label">Client Package Name</label>
    @if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('client_package_name'))
        <select name="client_type" class="tw-select" x-init="tomSelect($el)">
            @foreach ($clientTypes as $key => $value)
                <option value="{{ $key }}" @selected($key == ($client->client_type ?? null))>{{ $value }}</option>
            @endforeach
        </select>
    @else
        @foreach ($clientTypes as $key => $value)
            @if ($key == ($client->client_type ?? null))
                <p class="text-sm text-gray-700">{{ $value }}</p>
            @endif
        @endforeach
    @endif
</form>

{{-- Subscription (gold / diamond / platinum only) --}}
@if (in_array($client->client_type ?? null, ['gold', 'diamond', 'platinum']))
    <div class="tw-card mt-6 space-y-6">

        <div>
            <label class="tw-label">Coins Remaining</label>
            <input type="text" class="tw-input bg-gray-50" value="{{ $client->coins_amt }}" readonly>
        </div>

        <form x-data="ajaxForm('{{ $updateUrl }}')" @submit.prevent="submit($event)" class="tw-grid-form items-end">
            @csrf
            <input type="hidden" name="submit_yrly_subs_starting_date" value="1">
            <div>
                <label class="tw-label">Starting Date</label>
                <input type="text" name="expired_from" class="tw-input x_date"
                    value="{{ \Illuminate\Support\Carbon::parse($client->expired_from)->format('Y-m-d') }}">
            </div>
            <div>
                <label class="tw-label">End Date</label>
                <input type="text" name="expired_on" class="tw-input y_date"
                    value="{{ \Illuminate\Support\Carbon::parse($client->expired_on)->format('Y-m-d') }}">
            </div>
            @if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager'))
                <button type="submit" class="tw-btn-warning" :disabled="saving">SAVE</button>
            @endif
        </form>

        <form x-data="ajaxForm('{{ $updateUrl }}')" @submit.prevent="submit($event)" class="tw-grid-form items-end">
            @csrf
            <input type="hidden" name="submit_max_kw" value="1">
            <div>
                <label class="tw-label">Max Keywords</label>
                <input type="number" min="0" step="1" name="max_kw" class="tw-input" value="{{ $client->max_kw }}">
            </div>
            @if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager'))
                <button type="submit" class="tw-btn-warning" :disabled="saving">SAVE</button>
            @endif
        </form>

        @if (($client->coins_free ?? '0') == '0')
            <form x-data="ajaxForm('{{ $updateUrl }}')" @submit.prevent="submit($event)" class="flex items-end gap-3">
                @csrf
                <input type="hidden" name="amt" value="555">
                <input type="hidden" name="submit_free_amt" value="1">
                <span class="text-sm text-gray-700">₹ 0 : 555 Coins</span>
                @if (Auth::user()->current_user_can('administrator') || Auth::user()->current_user_can('manager'))
                    <button type="submit" class="tw-btn-primary" :disabled="saving">Buy Package</button>
                @endif
            </form>
        @endif
    </div>
@endif
