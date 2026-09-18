<x-layouts.sales.app :title="($isCreating ? 'Add vendor' : 'Edit '.$vendor->business_name).' · Vendorflow'" header="Vendor editor">
    @php
        $fields = [
            ['business_name', 'Business name', 'text', true],
            ['owner_name', 'Owner name', 'text', true],
            ['email', 'Owner email', 'email', true],
            ['mobile', 'Primary mobile', 'text', true],
            ['alternate_mobile', 'Alternate mobile', 'text', false],
            ['business_email', 'Business email', 'email', false],
            ['whatsapp', 'WhatsApp', 'text', false],
            ['category', 'Category', 'text', false],
            ['country', 'Country', 'text', false],
            ['state', 'State', 'text', false],
            ['city', 'City', 'text', false],
            ['zone', 'Zone', 'text', false],
            ['area', 'Area', 'text', false],
            ['pincode', 'Pincode', 'text', false],
            ['address', 'Address', 'text', true],
            ['landmark', 'Landmark', 'text', false],
            ['website', 'Website', 'url', false],
            ['business_hours', 'Business hours', 'text', false],
            ['meta_title', 'Meta title', 'text', true],
            ['meta_description', 'Meta description', 'text', true],
            ['meta_keywords', 'Meta keywords', 'text', true],
        ];
        $sections = ['Personal Details', 'Business Information', 'Business Meta', 'Business Overview', 'FAQs', 'Business Location', 'Company Logo', 'Gallery', 'Certificates', 'Awards', 'Recent Activity', 'Assigned Keywords', 'Account Settings', 'Leads', 'Discussion', 'Payment Orders'];
    @endphp
    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div><a href="{{ route('sales.vendors.index') }}" class="text-xs font-semibold text-[#315b80]">← Back to vendors</a><h1 class="mt-3 font-display text-2xl font-semibold tracking-[-0.04em]">{{ $isCreating ? 'Add vendor' : $vendor->business_name }}</h1><p class="mt-1 text-sm text-[#718394]">{{ $isCreating ? 'Create a vendor profile for review.' : 'Keep this profile, its activity, and its account health current.' }}</p></div>
            @if (!$isCreating)<span class="rounded-full bg-[#e4f4eb] px-3 py-1.5 text-xs font-semibold text-[#26734b]">{{ ucfirst($vendor->status) }}</span>@endif
        </div>
        <div data-vendor-tabs data-current-id="{{ $vendor->id }}" data-vendors='@json($tabVendors)' class="flex gap-2 overflow-x-auto pb-1"></div>
        <div class="grid gap-5 lg:grid-cols-[230px_minmax(0,1fr)]">
            <aside class="rounded-2xl border border-[#dfe7ec] bg-white p-3 shadow-[0_5px_18px_rgba(18,38,58,0.035)]"><p class="mb-2 px-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-[#9aa9b5]">Editor sections</p><div class="flex gap-1 overflow-x-auto lg:block">@foreach ($sections as $section)
                
            <button type="button" data-editor-section="{{ $section }}" data-vendor-id="{{ $vendor->id ?: 'new' }}" class="mb-1 block shrink-0 rounded-lg px-2.5 py-2 text-left text-xs font-medium text-[#718394] hover:bg-[#e9f2f7] hover:text-[#315b80]">{{ $section }}</button>
            
            @endforeach
        
        </div></aside>
            <form method="POST" action="{{ $isCreating ? route('sales.vendors.store') : route('sales.vendors.update', $vendor) }}" class="rounded-2xl border border-[#dfe7ec] bg-white shadow-[0_5px_18px_rgba(18,38,58,0.035)]">
                @csrf
                @if (!$isCreating) @method('PUT') @endif
                <div class="border-b border-[#edf1f3] p-5 sm:p-7"><p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-[#a14f47]">Profile essentials</p><h2 class="mt-2 font-display text-2xl font-semibold tracking-[-0.04em]">Business information</h2><p class="mt-1 max-w-2xl text-sm leading-6 text-[#718394]">These details are shared with your sales team and customer-facing vendor profile.</p></div>
                <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-7">
                    @foreach ($fields as [$name, $label, $type, $wide])
                        <label class="{{ $wide ? 'sm:col-span-2' : '' }} block text-xs font-semibold text-[#435b6d]">{{ $label }}<input name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $vendor->{$name}) }}" class="mt-2 h-11 w-full rounded-lg border border-[#dfe7ec] bg-white px-3 text-sm font-normal outline-none focus:border-[#315b80] focus:ring-4 focus:ring-[#315b80]/10"></label>
                    @endforeach
                    <label class="block text-xs font-semibold text-[#435b6d]">Status<select name="status" class="mt-2 h-11 w-full rounded-lg border border-[#dfe7ec] bg-white px-3 text-sm font-normal outline-none focus:border-[#315b80]"><option value="active" @selected(old('status', $vendor->status) === 'active')>Active</option><option value="pending" @selected(old('status', $vendor->status) === 'pending')>Pending</option><option value="inactive" @selected(old('status', $vendor->status) === 'inactive')>Inactive</option><option value="suspended" @selected(old('status', $vendor->status) === 'suspended')>Suspended</option></select></label>
                    <label class="block text-xs font-semibold text-[#435b6d]">Sales executive<input name="sales_executive" value="{{ old('sales_executive', $vendor->sales_executive) }}" class="mt-2 h-11 w-full rounded-lg border border-[#dfe7ec] bg-white px-3 text-sm font-normal outline-none focus:border-[#315b80]"></label>
                    <label class="block text-xs font-semibold text-[#435b6d] sm:col-span-2">Full business description<textarea name="full_description" rows="5" class="mt-2 w-full resize-y rounded-lg border border-[#dfe7ec] p-3 text-sm font-normal leading-6 outline-none focus:border-[#315b80]">{{ old('full_description', $vendor->full_description) }}</textarea></label>
                    <label class="block text-xs font-semibold text-[#435b6d] sm:col-span-2">Services and facilities<textarea name="services" rows="3" class="mt-2 w-full resize-y rounded-lg border border-[#dfe7ec] p-3 text-sm font-normal leading-6 outline-none focus:border-[#315b80]">{{ old('services', $vendor->services) }}</textarea></label>
                </div>
                <div class="flex flex-col-reverse gap-2 border-t border-[#edf1f3] p-5 sm:flex-row sm:justify-end sm:p-7"><a href="{{ route('sales.vendors.index') }}" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#dfe7ec] px-4 text-sm font-semibold text-[#718394] hover:bg-[#f7f9fb]">Discard</a><button class="h-11 rounded-lg bg-[#a14f47] px-5 text-sm font-semibold text-white hover:bg-[#8f433d]">{{ $isCreating ? 'Create vendor' : 'Save changes' }}</button></div>
            </form>
        </div>
    </div>
</x-layouts.sales.app>