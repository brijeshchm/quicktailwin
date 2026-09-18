<h4 class="tw-section-title">Payment Order</h4>

@php
    $modes = [];
    foreach ($moderesults as $moderesult) {
        $modes[$moderesult->slug] = $moderesult->mode;
    }
@endphp

<form
    x-data="{
        ...ajaxForm('{{ url('developer/clients/submitClientPayOrder') }}'),
        paidAmount: 0,
        gstStatus: '',
        tdsStatus: '',
        gstTax: 0,
        gstTotal: 0,
        tdsAmount: 0,
        totalAmount: 0,
        paymentMode: 'cash',
        recalcGst() {
            const paid = parseFloat(this.paidAmount) || 0;
            this.gstTax = this.gstStatus === 'Yes' ? Math.round(paid * 0.18) : 0;
            this.gstTotal = paid + this.gstTax;
            this.recalcTds();
        },
        recalcTds() {
            this.tdsAmount = this.tdsStatus === 'Yes' ? Math.round((parseFloat(this.paidAmount) || 0) * 2 / 100) : 0;
            this.totalAmount = this.gstTotal - this.tdsAmount;
        },
    }"
    @submit.prevent="submit($event)"
>
    @csrf
    <input type="hidden" name="client-id" value="{{ $client->username ?? '' }}">

    <div class="tw-grid-form">
        <div>
            <label class="tw-label tw-required">Business Name</label>
            <input type="text" name="business_name" class="tw-input" value="{{ $client->business_name ?? '' }}" placeholder="Business Name">
        </div>

        <div>
            <label class="tw-label tw-required">Package Name</label>
            <input type="text" name="package_name" class="tw-input bg-gray-50" readonly
                value="{{ old('client_type', $client->client_type ?? '') }}" placeholder="Package Name">
        </div>

        <div>
            <label class="tw-label tw-required">Paid Amount</label>
            <input type="number" name="paid_amount" class="tw-input" placeholder="Paid Amount"
                x-model="paidAmount" @input="recalcGst()">
        </div>

        <div>
            <label class="tw-label tw-required">Coins</label>
            <input type="text" name="coins_amt" class="tw-input bg-gray-50" readonly>
        </div>

        <div>
            <label class="tw-label tw-required">GST</label>
            <div class="flex gap-4 pt-2">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="radio" name="gst_status" value="Yes" class="tw-radio" x-model="gstStatus" @change="recalcGst()"> Yes
                </label>
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="radio" name="gst_status" value="No" class="tw-radio" x-model="gstStatus" @change="recalcGst()"> No
                </label>
            </div>
        </div>

        <div>
            <label class="tw-label">GST Amount</label>
            <input type="number" name="gst_tax" class="tw-input bg-gray-50" placeholder="GST Amount" x-model="gstTax" readonly>
        </div>

        <div>
            <label class="tw-label tw-required">GST Total Amount</label>
            <input type="number" name="gst_total_amount" class="tw-input bg-gray-50" placeholder="GST Total Amount" x-model="gstTotal" readonly>
        </div>

        <div>
            <label class="tw-label tw-required">TDS</label>
            <div class="flex gap-4 pt-2">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="radio" name="tds_status" value="Yes" class="tw-radio" x-model="tdsStatus" @change="recalcTds()"> Yes
                </label>
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="radio" name="tds_status" value="No" class="tw-radio" x-model="tdsStatus" @change="recalcTds()"> No
                </label>
            </div>
        </div>

        <div>
            <label class="tw-label">TDS Amount</label>
            <input type="number" name="tds_amount" class="tw-input bg-gray-50" placeholder="TDS Amount" x-model="tdsAmount" readonly>
        </div>

        <div>
            <label class="tw-label tw-required">Total Amount</label>
            <input type="number" name="total_amount" class="tw-input bg-gray-50" placeholder="Total Amount" x-model="totalAmount" readonly>
        </div>

        <div>
            <label class="tw-label tw-required">Payment Mode</label>
            <select name="stud-payment_mode" class="tw-select" x-init="tomSelect($el)" x-model="paymentMode">
                <option value="">Select Payment Mode</option>
                @foreach ($modes as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Bank-specific dropdowns (excluding cash/cheque, handled below) --}}
    @foreach ($modes as $key => $value)
        @if ($key !== 'cash' && $key !== 'cheque')
            <div class="mt-4" x-show="paymentMode === '{{ $key }}'" x-cloak>
                <label class="tw-label">{{ $value }}</label>
                <select name="stud-{{ $key }}" class="tw-select" x-init="tomSelect($el)">
                    <option value="" selected>-- Select {{ $value }} --</option>
                    @foreach (\App\Models\Banksdetails::where('mode', $key)->get() as $bank)
                        <option value="{{ $bank->name }}">{{ $bank->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    @endforeach

    <div class="mt-4" x-show="paymentMode === 'cheque'" x-cloak>
        <label class="tw-label">Cheque Number</label>
        <input type="text" name="stud-chq_no" class="tw-input" placeholder="Enter Cheque Number">
    </div>

    <div class="mt-4" x-show="paymentMode === 'bank'" x-cloak>
        <label class="tw-label">Card Number</label>
        <input type="text" name="stud-card_no" maxlength="4" class="tw-input" placeholder="Enter Last 4 Digits of Card Number">
    </div>

    <div class="tw-grid-form mt-6">
        <div>
            <label class="tw-label">Transaction ID</label>
            <input type="text" name="transactionid" class="tw-input" placeholder="Enter Transaction-Id">
        </div>

        <div>
            <label class="tw-label">Select ID Proof</label>
            <select name="selectproofid" class="tw-select" x-init="tomSelect($el)">
                <option value="">Select ID Proof</option>
                @foreach (['Pan Card', 'Adhar Card', 'Passport', 'Driver Licence'] as $proof)
                    <option value="{{ $proof }}">{{ $proof }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="tw-label">ID Proof</label>
            <input type="text" name="proofid" class="tw-input" placeholder="Enter ID proof">
        </div>
    </div>

    <input type="hidden" name="pay-submit" value="savepay">

    <div class="mt-6">
        <button type="submit" class="tw-btn-warning w-full sm:w-auto" :disabled="saving">
            <span x-show="!saving">Payment</span>
            <span x-show="saving" x-cloak>Processing…</span>
        </button>
    </div>
</form>

{{-- Payment history --}}
<div class="mt-8 overflow-x-auto tw-card">
    <table class="tw-table" x-init="dataTable($el)">
        <caption class="text-left text-sm font-semibold text-gray-700 mb-2">Payment History</caption>
        <thead>
            <tr>
                <th>Date</th>
                <th>Paid Amount</th>
                <th>GST</th>
                <th>Total Amount</th>
                <th>Pay Mode</th>
                <th>Order PDF</th>
                <th>Proforma Invoice</th>
                <th>Invoice PDF</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($paymentHistory as $payment) ... @endforeach --}}
        </tbody>
    </table>
</div>
