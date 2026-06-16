<?php echo View::make('admin/header'); ?>
<div id="page-wrapper">

<style>
/* ── Card image area ── */
.reward-img-wrap {
    height: 160px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.reward-img-wrap img { width:100%; height:100%; object-fit:cover; }
.reward-img-wrap .badge-inactive {
    position: absolute; top:.5rem; right:.5rem;
    background: rgba(0,0,0,.70); color:#fff;
    font-size:.7rem; padding:.2rem .55rem; border-radius:.3rem;
}
.reward-img-wrap .badge-category {
    position: absolute; bottom:.5rem; left:.5rem;
    background:#4f46e5; color:#fff;
    font-size:.7rem; padding:.2rem .55rem; border-radius:.3rem;
}
.card-inactive  { opacity:.70; filter:grayscale(40%); }
.text-coin      { color:#d97706; font-weight:700; }

/* ── Preview ── */
.preview-img-wrap {
    height:190px; background:#f3f4f6;
    display:flex; align-items:center;
    justify-content:center; overflow:hidden;
}
.preview-img-wrap img { width:100%; height:100%; object-fit:cover; }

/* ── City price row ── */
.city-row {
    display: grid;
    grid-template-columns: 1fr 5.5rem 5.5rem 2.2rem;
    gap:.4rem; align-items:center;
}
.city-row-header { font-size:.72rem; color:#6b7280; }

/* ── Category dropdown ── */
.cat-dropdown            { max-height:220px; overflow-y:auto; }
.cat-dropdown li > a.active { background:#eff6ff; color:#1d4ed8; }

/* ── Empty state ── */
.empty-box {
    background:#f9fafb; border:2px dashed #e5e7eb;
    border-radius:1rem; padding:3.5rem 1.5rem; text-align:center;
}

/* ── Btn amber ── */
.btn-amber           { background:#f59e0b; color:#fff; border:none; font-weight:600; }
.btn-amber:hover     { background:#d97706; color:#fff; }
.btn-amber[disabled] { opacity:.5; cursor:not-allowed; }

/* ── Custom file btn ── */
.custom-file-btn {
    display:block; width:100%; padding:.45rem .75rem;
    border:1px solid #d1d5db; border-radius:.4rem;
    background:#fff; color:#374151; font-size:.875rem;
    cursor:pointer; text-align:center; transition:background .15s;
    margin-bottom:.5rem;
}
.custom-file-btn:hover { background:#f9fafb; }

/* ── Modal body scroll ── */
.modal-body-scroll { max-height:65vh; overflow-y:auto; padding:15px; }

/* ── Coin cost box ── */
.coin-box {
    background:#f9fafb; border-radius:.4rem;
    padding:.6rem .85rem; margin-bottom:.75rem;
    display:flex; align-items:center; justify-content:space-between;
}

/* ── City select dropdown ── */
.city-select {
    appearance: auto;
    -webkit-appearance: auto;
    cursor: pointer;
}
.city-select option[value=""] {
    color: #9ca3af;
}


</style>

<div class="container-fluid" style="max-width:1200px; padding:30px 15px">

    {{-- ── Page Header ── --}}
    <div class="row" style="margin-bottom:20px">
        <div class="col-sm-8">
            <h2 style="font-family:Georgia,serif; margin:0 0 4px">Rewards Catalog</h2>
            <p class="text-muted" style="margin:0">Manage items customers can redeem with their coins.</p>
        </div>
        <div class="col-sm-4 text-right">
            <button class="btn btn-amber" onclick="openModal()">
                <i class="glyphicon glyphicon-plus"></i> Add Item
            </button>
        </div>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="glyphicon glyphicon-ok-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Item Grid ── --}}
    @if($items->isEmpty())
    <div class="empty-box">
        <i class="glyphicon glyphicon-cog" style="font-size:3rem;color:#9ca3af;opacity:.4;display:block;margin-bottom:12px"></i>
        <h4 style="color:#6b7280; font-weight:700; margin-bottom:8px">No items found</h4>
        <p class="text-muted" style="margin-bottom:20px">Create your first reward item to get started.</p>
        <button class="btn btn-amber" onclick="openModal()">Add First Item</button>
    </div>

    @else
    <div class="row">
        @foreach($items as $item)
        <div class="col-sm-6 col-md-4" style="margin-bottom:20px">
            <div class="panel panel-default {{ !$item->is_active ? 'card-inactive' : '' }}"
                style="border-radius:10px; overflow:hidden; border:none;
                       box-shadow:0 1px 4px rgba(0,0,0,.1); margin-bottom:0">

                {{-- Image --}}
                <div class="reward-img-wrap">
                    @if($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center">
                            <i class="glyphicon glyphicon-picture" style="font-size:2.5rem;color:#9ca3af;opacity:.4"></i>
                        </div>
                    @else
                        <i class="glyphicon glyphicon-picture" style="font-size:2.5rem;color:#9ca3af;opacity:.4"></i>
                    @endif

                    @if(!$item->is_active)
                        <span class="badge-inactive">Inactive</span>
                    @endif
                    @if($item->category)
                        <span class="badge-category">{{ $item->category }}</span>
                    @endif
                </div>

                {{-- Body --}}
                <div class="panel-body" style="padding:14px 14px 8px">
                    <h5 style="font-weight:700;margin:0 0 6px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis">
                        {{ $item->name }}
                    </h5>
                    <p class="text-muted small" style="
                        display:-webkit-box;-webkit-line-clamp:2;
                        -webkit-box-orient:vertical;overflow:hidden;
                        min-height:2.6rem;margin-bottom:8px">
                        {{ $item->description }}
                    </p>
                    <p class="text-coin" style="margin:0">{{ number_format($item->coins_required) }} Coins</p>
                </div>

                {{-- Footer --}}
                <div class="panel-footer text-right"
                    style="background:#fff;border-top:1px solid #f3f4f6;padding:8px 14px">
                    <button class="btn btn-default btn-sm" onclick="openModal({{ $item->id }})">
                        <i class="glyphicon glyphicon-pencil"></i> Edit
                    </button>
                    <form method="POST"
                        action="{{ route('developer.rewards.destroy', $item) }}"
                        onsubmit="return confirm('Delete this item?')"
                        style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="glyphicon glyphicon-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- ════════════════════════════════════════
     BOOTSTRAP 3 MODAL
════════════════════════════════════════ --}}
<div class="modal fade" id="rewardModal" tabindex="-1" role="dialog"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:10px">

            {{-- Header --}}
            <div class="modal-header" style="border-bottom:1px solid #f3f4f6">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modalTitle"
                    style="font-family:Georgia,serif; font-weight:700">
                    New Reward Item
                </h4>
            </div>

            {{-- Form --}}
            <form id="rewardForm" method="POST" enctype="multipart/form-data">
                @csrf
                <span id="methodField"></span>

                <div class="modal-body p-0">
                    <div class="modal-body-scroll">
                        <div class="row" style="margin:0">

                            {{-- ── LEFT: Fields ── --}}
                            <div class="col-md-7"
                                style="padding:20px; border-right:1px solid #f3f4f6">

                                {{-- Name --}}
                                <div class="form-group">
                                    <label class="control-label small" style="font-weight:600">
                                        Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="f_name"
                                        class="form-control" required
                                        placeholder="e.g. Free Coffee">
                                </div>

                                {{-- Description --}}
                                <div class="form-group">
                                    <label class="control-label small" style="font-weight:600">Description</label>
                                    <textarea name="description" id="f_description"
                                        rows="3" class="form-control"
                                        placeholder="Describe the reward..."></textarea>
                                </div>

                                {{-- Coins & Refund --}}
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label class="control-label small" style="font-weight:600">
                                                Coins Required <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" name="coins_required"
                                                id="f_coins_required" min="1" value="100"
                                                required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label class="control-label small" style="font-weight:600">
                                                Refund Coins
                                            </label>
                                            <input type="number" name="credit_coins"
                                                id="f_credit_coins" min="0" value="0"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-muted" style="font-size:.72rem; margin-top:-8px; margin-bottom:12px">
                                    Fixed coins refunded to the business per redemption. Independent of coins required.
                                </p>

                                {{-- City Prices --}}
                                <div class="form-group">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">
                                        <label class="control-label small mb-0" style="font-weight:600">
                                            City-specific Pricing
                                            <span class="text-muted" style="font-weight:400">(Optional)</span>
                                        </label>
                                        <button type="button" class="btn btn-default btn-xs"
                                            onclick="addCityRow()">
                                            <i class="glyphicon glyphicon-plus"></i> Add city
                                        </button>
                                    </div>
                                    <p class="text-muted" style="font-size:.72rem; margin-bottom:6px">
                                        Override coins per city. Cities not listed use defaults above.
                                    </p>
                                 

                                <div id="cityHeader" class="city-row city-row-header"
                                style="display:none; padding:0 4px; margin-bottom:2px">
                                <span>City <span class="text-danger">*</span></span>
                                <span>Coins</span>
                                <span>Refund</span>
                                <span></span>
                                </div>
                                    <div id="cityPricesContainer"
                                        style="display:flex;flex-direction:column;gap:6px;margin-top:4px">
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="form-group">
                                    <label class="control-label small" style="font-weight:600">
                                        Category Keyword
                                        <span class="text-muted" style="font-weight:400">(Optional)</span>
                                    </label>

                                    {{-- BS3 dropdown --}}
                                    <div class="dropdown" id="catDropdownWrap">
                                        <button type="button"
                                            class="btn btn-default btn-block dropdown-toggle text-left"
                                            id="catDropdownBtn"
                                            data-toggle="dropdown"
                                            style="display:flex;align-items:center;justify-content:space-between">
                                            <span id="catLabel" class="text-muted">
                                                Search and select a keyword
                                            </span>
                                            <i class="glyphicon glyphicon-chevron-down"
                                                style="margin-left:8px;opacity:.5"></i>
                                        </button>
                                        <ul class="dropdown-menu cat-dropdown"
                                            style="width:100%;padding:8px">
                                            <li style="margin-bottom:6px">
                                                <input type="text" id="catSearch"
                                                    class="form-control input-sm"
                                                    placeholder="Search keywords..."
                                                    oninput="filterCategories(this.value)"
                                                    onclick="event.stopPropagation()">
                                            </li>
                                            <li class="divider"></li>
                                            <div id="catList">
                                                @foreach($categories as $cat)
                                                <li>
                                                    <a href="#" class="cat-option"
                                                        data-name="{{ $cat->keyword }}"
                                                        onclick="selectCategory('{{ $cat->keyword }}'); return false;">
                                                        <i class="glyphicon glyphicon-ok me-2 cat-check"
                                                            style="visibility:hidden;margin-right:6px"></i>
                                                        {{ $cat->keyword }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </div>
                                            <div id="catCustomWrap" style="display:none">
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="#" onclick="useCustomCategory(); return false;">
                                                        <i class="glyphicon glyphicon-plus"
                                                            style="margin-right:6px"></i>
                                                        Use "<span id="catCustomLabel"></span>"
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </div>

                                    <input type="hidden" name="category" id="f_category">
                                    <a href="#" id="clearCatBtn"
                                        style="display:none;font-size:.72rem;color:#9ca3af"
                                        onclick="clearCategory(); return false;">
                                        Clear keyword
                                    </a>
                                </div>

                                {{-- Image --}}
                                <div class="form-group">
                                    <label class="control-label small" style="font-weight:600">
                                        Image
                                        <span class="text-muted" style="font-weight:400">(Optional)</span>
                                    </label>
                                    <label for="f_image_file" class="custom-file-btn">
                                        <i class="glyphicon glyphicon-upload"
                                            style="margin-right:6px"></i>
                                        <span id="uploadLabel">Upload from device</span>
                                    </label>
                                    <input type="file" name="image_file" id="f_image_file"
                                        accept="image/*" style="display:none">
                                    <input type="text" name="image_url" id="f_image_url"
                                        class="form-control"
                                        placeholder="Or paste image URL: https://...">
                                </div>

                                {{-- Active toggle --}}
                                <div class="form-group" style="padding-top:8px">
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active"
                                            id="f_is_active" value="1"
                                            checked style="width:18px;height:18px;cursor:pointer">
                                        <label for="f_is_active"
                                            style="font-weight:600;font-size:.875rem;margin:0;cursor:pointer">
                                            Active (Visible to customers)
                                        </label>
                                    </div>
                                </div>

                            </div>{{-- /col-md-7 --}}

                            {{-- ── RIGHT: Preview ── --}}
                            <div class="col-md-5"
                                style="padding:20px;background:#f9fafb">
                                <label class="control-label small" style="font-weight:600">
                                    Live Preview
                                </label>
                                <div class="panel panel-default"
                                    style="border-radius:10px;overflow:hidden;border:none;
                                           box-shadow:0 1px 4px rgba(0,0,0,.1)">
                                    <div class="preview-img-wrap" id="previewImgWrap">
                                        <i class="glyphicon glyphicon-picture"
                                            id="previewPlaceholder"
                                            style="font-size:2.5rem;color:#9ca3af;opacity:.4"></i>
                                        <img id="previewImg" src="" alt="Preview"
                                            style="display:none;width:100%;height:100%;object-fit:cover">
                                    </div>
                                    <div class="panel-body" style="padding:14px">
                                        <h5 id="previewName"
                                            style="font-weight:700;margin:0 0 6px">Item Name</h5>
                                        <p id="previewDesc" class="text-muted small"
                                            style="display:-webkit-box;-webkit-line-clamp:2;
                                                   -webkit-box-orient:vertical;overflow:hidden;margin-bottom:8px">
                                            Description will appear here...
                                        </p>
                                        <p id="previewCoins" class="text-coin" style="margin:0">
                                            100 Coins
                                        </p>
                                    </div>
                                </div>

                                {{-- Tips --}}
                                <div class="panel panel-default"
                                    style="border-radius:8px;margin-top:16px;font-size:.78rem">
                                    <div class="panel-body">
                                        <p style="font-weight:700;margin:0 0 8px">
                                            <i class="glyphicon glyphicon-info-sign text-primary"
                                                style="margin-right:4px"></i> Quick Tips
                                        </p>
                                        <ul class="text-muted" style="padding-left:18px;margin:0;line-height:1.8">
                                            <li>Set city prices to offer regional deals</li>
                                            <li>Refund coins go to the business owner</li>
                                            <li>Inactive items are hidden from customers</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>{{-- /row --}}
                    </div>{{-- /modal-body-scroll --}}
                </div>{{-- /modal-body --}}

                {{-- Footer --}}
                <div class="modal-footer"
                    style="background:#f9fafb;border-top:1px solid #f3f4f6;border-radius:0 0 10px 10px">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">Cancel</button>
                    <button type="submit" id="submitBtn" class="btn btn-amber">
                        <span id="submitLabel">Create Item</span>
                    </button>
                </div>

            </form>
        </div>{{-- /modal-content --}}
    </div>{{-- /modal-dialog --}}
</div>{{-- /modal --}}

{{-- ── Data for JS ── --}}
<script>
    const ALL_ITEMS  = @json($items);
    const STORE_URL  = "{{ route('developer.rewards.store') }}";
    const UPDATE_URL = function(id){ return '/developer/rewards/' + id; };
      const CITY_LIST  = @json($citylist->pluck('city'));
</script>

<script>
/* ════════════════ STATE ════════════════ */
var editingId  = null;
var currentCat = '';
var cityIdx    = 0;

/* ════════════════ MODAL (Bootstrap 3) ════════════════ */
function openModal(id) {
    id = id || null;

    // Reset form
    document.getElementById('rewardForm').reset();
    document.getElementById('cityPricesContainer').innerHTML = '';
    document.getElementById('cityHeader').style.display = 'none';
    document.getElementById('methodField').innerHTML    = '';
    resetPreview();
    clearCategory();

    if (id) {
        var item = ALL_ITEMS.find(function(i){ return i.id === id; });
        editingId = id;

        document.getElementById('modalTitle').textContent  = 'Edit Item';
        document.getElementById('submitLabel').textContent = 'Save Changes';
        document.getElementById('rewardForm').action       = UPDATE_URL(id);
        document.getElementById('methodField').innerHTML   =
            '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('f_name').value           = item.name           || '';
        document.getElementById('f_description').value    = item.description    || '';
        document.getElementById('f_coins_required').value = item.coins_required || 100;
        document.getElementById('f_credit_coins').value   = item.credit_coins   || 0;
        document.getElementById('f_image_url').value      = item.image_url      || '';
        document.getElementById('f_is_active').checked    = !!item.is_active;

        if (item.id) selectCategory(item.id);
        (item.city_prices || []).forEach(function(cp){ addCityRow(cp); });
        updatePreview();

    } else {
        editingId = null;
        document.getElementById('modalTitle').textContent  = 'New Reward Item';
        document.getElementById('submitLabel').textContent = 'Create Item';
        document.getElementById('rewardForm').action       = STORE_URL;
        document.getElementById('f_coins_required').value  = 100;
        document.getElementById('f_credit_coins').value    = 0;
        document.getElementById('f_is_active').checked     = true;
    }

    $('#rewardModal').modal('show');   // Bootstrap 3 jQuery call
}

// Reset on close
$('#rewardModal').on('hidden.bs.modal', function(){
    document.getElementById('uploadLabel').textContent = 'Upload from device';
    editingId = null;
});

/* ════════════════ LIVE PREVIEW ════════════════ */
function updatePreview() {
    var name   = document.getElementById('f_name').value;
    var desc   = document.getElementById('f_description').value;
    var coins  = document.getElementById('f_coins_required').value;
    var imgUrl = document.getElementById('f_image_url').value.trim();

    document.getElementById('previewName').textContent  = name  || 'Item Name';
    document.getElementById('previewDesc').textContent  = desc  || 'Description will appear here...';
    document.getElementById('previewCoins').textContent = (coins || 0) + ' Coins';

    var img = document.getElementById('previewImg');
    var ph  = document.getElementById('previewPlaceholder');

    if (imgUrl) {
        img.src          = imgUrl;
        img.style.display   = 'block';
        ph.style.display    = 'none';
    } else {
        img.style.display   = 'none';
        ph.style.display    = 'inline';
    }
}

function resetPreview() {
    document.getElementById('previewName').textContent  = 'Item Name';
    document.getElementById('previewDesc').textContent  = 'Description will appear here...';
    document.getElementById('previewCoins').textContent = '100 Coins';
    document.getElementById('previewImg').style.display = 'none';
    document.getElementById('previewImg').src           = '';
    document.getElementById('previewPlaceholder').style.display = 'inline';
}

// Live input listeners
['f_name','f_description','f_coins_required','f_image_url'].forEach(function(id){
    var el = document.getElementById(id);
    if (el) el.addEventListener('input', updatePreview);
});

// File preview
document.getElementById('f_image_file').addEventListener('change', function(){
    var file = this.files[0];
    if (!file) return;
    document.getElementById('uploadLabel').textContent = file.name;
    var reader = new FileReader();
    reader.onload = function(e){
        var img = document.getElementById('previewImg');
        img.src            = e.target.result;
        img.style.display  = 'block';
        document.getElementById('previewPlaceholder').style.display = 'none';
        document.getElementById('f_image_url').value = '';
    };
    reader.readAsDataURL(file);
});

/* ════════════════ CITY PRICE ROWS ════════════════ */
 /* ════════════════ CITY PRICE ROWS ════════════════ */
function addCityRow(data) {
    data = data || {};
    var container = document.getElementById('cityPricesContainer');
    var header    = document.getElementById('cityHeader');
    var i = cityIdx++;

    header.style.display = 'grid';

    // Build city <select> options
    var cityOptions = '<option value="">-- Select City --</option>';
    CITY_LIST.forEach(function(city) {
        var selected = (data.city && data.city === city) ? 'selected' : '';
        cityOptions += '<option value="' + escHtml(city) + '" ' + selected + '>'
                     + escHtml(city) + '</option>';
    });

    // If saved city not in list, add it as selected option
    if (data.city && CITY_LIST.indexOf(data.city) === -1) {
        cityOptions += '<option value="' + escHtml(data.city) + '" selected>'
                     + escHtml(data.city) + ' (custom)</option>';
    }

    var row = document.createElement('div');
    row.className = 'city-row';
    row.id = 'cityRow_' + i;
    row.innerHTML =
        '<select'
            + ' name="city_prices[' + i + '][city]"'
            + ' class="form-control input-sm city-select"'
            + ' onchange="checkCustomCity(this, ' + i + ')">'
            + cityOptions
        + '</select>'
        + '<input type="number"'
            + ' name="city_prices[' + i + '][coins_required]"'
            + ' class="form-control input-sm" min="1"'
            + ' value="' + (data.coins_required || document.getElementById('f_coins_required').value) + '">'
        + '<input type="number"'
            + ' name="city_prices[' + i + '][credit_coins]"'
            + ' class="form-control input-sm" min="0"'
            + ' value="' + (data.credit_coins || document.getElementById('f_credit_coins').value) + '">'
        + '<button type="button" class="btn btn-link text-danger btn-sm" style="padding:0"'
            + ' onclick="removeCityRow(' + i + ')">'
            + '<i class="glyphicon glyphicon-trash"></i>'
        + '</button>';

    container.appendChild(row);
}

function removeCityRow(i) {
    var row = document.getElementById('cityRow_' + i);
    if (row) row.parentNode.removeChild(row);

    // Also remove custom input if exists
    var customRow = document.getElementById('cityCustomRow_' + i);
    if (customRow) customRow.parentNode.removeChild(customRow);

    if (!document.getElementById('cityPricesContainer').children.length) {
        document.getElementById('cityHeader').style.display = 'none';
    }
}

// Show custom input if "Other" selected
function checkCustomCity(select, i) {
    var existingCustom = document.getElementById('cityCustomRow_' + i);
    if (existingCustom) existingCustom.parentNode.removeChild(existingCustom);
    // no "Other" option needed since list is dynamic
}

/* ════════════════ CATEGORY DROPDOWN ════════════════ */
function filterCategories(val) {
    var search = val.trim().toLowerCase();
    var opts   = document.querySelectorAll('.cat-option');

    opts.forEach(function(opt){
        var name = opt.getAttribute('data-name').toLowerCase();
        opt.parentElement.style.display = (!search || name.includes(search)) ? '' : 'none';
    });

    var customWrap  = document.getElementById('catCustomWrap');
    var customLabel = document.getElementById('catCustomLabel');
    var exactMatch  = Array.from(opts).some(function(o){
        return o.getAttribute('data-name').toLowerCase() === search;
    });

    if (search && !exactMatch) {
        customLabel.textContent   = val.trim();
        customWrap.style.display  = 'block';
    } else {
        customWrap.style.display  = 'none';
    }
}

function selectCategory(name) {
    currentCat = name;
    document.getElementById('f_category').value    = name;
    document.getElementById('catLabel').textContent = name;
    document.getElementById('catLabel').classList.remove('text-muted');
    document.getElementById('clearCatBtn').style.display = 'inline';

    document.querySelectorAll('.cat-option').forEach(function(opt){
        var check = opt.querySelector('.cat-check');
        if (opt.getAttribute('data-name') === name) {
            opt.classList.add('active');
            if (check) check.style.visibility = 'visible';
        } else {
            opt.classList.remove('active');
            if (check) check.style.visibility = 'hidden';
        }
    });

    // Close BS3 dropdown
    $('#catDropdownWrap').removeClass('open');
}

function useCustomCategory() {
    var val = document.getElementById('catSearch').value.trim();
    if (val) selectCategory(val);
}

function clearCategory() {
    currentCat = '';
    document.getElementById('f_category').value    = '';
    document.getElementById('catLabel').textContent = 'Search and select a keyword';
    document.getElementById('catLabel').classList.add('text-muted');
    document.getElementById('clearCatBtn').style.display = 'none';
    document.getElementById('catSearch').value = '';
    filterCategories('');
    document.querySelectorAll('.cat-option').forEach(function(o){
        o.classList.remove('active');
        var check = o.querySelector('.cat-check');
        if (check) check.style.visibility = 'hidden';
    });
}

/* ════════════════ HELPERS ════════════════ */
function escHtml(str) {
    return String(str)
        .replace(/&/g,'&amp;')
        .replace(/"/g,'&quot;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;');
}
</script>

</div><!-- /#page-wrapper -->
<?php echo View::make('admin/footer'); ?>