<h4 class="tw-section-title">Certificate</h4>

@php
    // label, number-field name, file-field name, remove-route slug
    $certificates = [
        ['label' => 'Pan No',                     'numField' => 'pan_no',   'fileField' => 'pan_certificate'],
        ['label' => 'ISO Certificate',             'numField' => 'iso_no',   'fileField' => 'iso_certificate'],
        ['label' => 'GST No',                      'numField' => 'gst_no',   'fileField' => 'gst_certificate'],
        ['label' => 'CIN No',                      'numField' => 'cin_no',   'fileField' => 'cin_certificate'],
        ['label' => 'MSME No',                     'numField' => 'msme_no',  'fileField' => 'msme_certificate'],
        ['label' => 'Certificate of Incorporation No', 'numField' => 'coi_no', 'fileField' => 'coi_certificate'],
        ['label' => 'Other Certificate 1',         'numField' => null,       'fileField' => 'other_certificate1'],
        ['label' => 'Other Certificate 2',         'numField' => null,       'fileField' => 'other_certificate2'],
        ['label' => 'Other Certificate 3',         'numField' => null,       'fileField' => 'other_certificate3'],
    ];
@endphp

<form
    id="certificateForm"
    enctype="multipart/form-data"
    x-data="ajaxForm('{{ url('developer/clients/save-certificate-auto')."/".($client->id ?? '') }}')"
    @change.debounce.800ms="submit($event)"
>
    @csrf
    <input type="hidden" name="business_id" value="{{ $client->id ?? '' }}">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($certificates as $cert)
            @php
                $fileData = !empty($client->{$cert['fileField']}) ? json_decode($client->{$cert['fileField']}) : null;
                $path = $fileData->large->src ?? '';
                $url = $path ? asset($path) : '';
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            @endphp

            <div class="tw-card min-h-[210px] flex flex-col gap-3" x-data="removableFile">
                <label class="tw-label mb-0">{{ $cert['label'] }}</label>

                @if ($cert['numField'])
                    <input type="text" name="{{ $cert['numField'] }}" class="tw-input"
                        value="{{ old($cert['numField'], $client->{$cert['numField']} ?? '') }}"
                        placeholder="Please enter {{ $cert['numField'] }}">
                @endif

                @if ($path)
                    <div class="flex items-start gap-2">
                        @if ($ext === 'pdf')
                            <embed src="{{ $url }}" type="application/pdf" class="w-24 h-24 border border-gray-200 rounded">
                            <a href="{{ $url }}" target="_blank" class="tw-btn-ghost text-xs">View</a>
                        @else
                            <img loading="lazy" src="{{ $url }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                        @endif
                        <button type="button" class="tw-btn-danger text-xs" :disabled="removing"
                            @click="remove('{{ url('developer/clients/certificate/'.$cert['fileField'].'/'.($client->id ?? '')) }}')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                @else
                    <input type="file" name="{{ $cert['fileField'] }}" accept=".jpg,.jpeg,.png,.webp"
                        class="tw-input file:mr-3 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-1 file:text-indigo-700 hover:file:bg-indigo-100">
                @endif
            </div>
        @endforeach
    </div>

    <p class="mt-4 text-xs text-gray-400" x-show="saving" x-cloak>Saving…</p>
</form>
