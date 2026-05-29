@extends('user.layouts.guest')

@section('title', 'Personal Details')

@section('description', 'Personal Details')

@section('keyword', 'Personal Details')
@section('content')

 
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-800 p-3 rounded-lg flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- 📊 Left: Step Indicator --}}
        <div class="lg:col-span-3">
            @include('user.profile.step-indicator', [
                'progress'    => 'profile_progress',
                'currentStep' => 'personal'
            ])
        </div>

        {{-- 📝 Middle: Form --}}
        <div class="lg:col-span-6 pt-6">
            <div class="bg-gray-50 rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Please provide your personal details
                </h2>
    


<form action="{{ route('user.profile.autosave') }}"
      method="POST"
      enctype="multipart/form-data"
      id="profileForm">
    @csrf
    @method('PUT')

    {{-- First Name with Title --}}
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <label class="col-span-4 text-sm text-gray-700 pt-2">
            <span class="text-red-500">*</span>First Name :
        </label>
        <div class="col-span-8 grid grid-cols-12 gap-2">
            <div class="col-span-4 relative">
                <label class="absolute -top-2 left-2 bg-white px-1 text-xs text-gray-500">Title</label>
                <select name="title" data-autosave required
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Mr"  {{ old('title', $user->title) == 'Mr' ? 'selected' : '' }}>Mr</option>
                    <option value="Ms"  {{ old('title', $user->title) == 'Ms' ? 'selected' : '' }}>Ms</option>
                    <option value="Mrs" {{ old('title', $user->title) == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                    <option value="Dr"  {{ old('title', $user->title) == 'Dr' ? 'selected' : '' }}>Dr</option>
                </select>
            </div>
            <input type="text" name="first_name" data-autosave required
                   value="{{ old('first_name', $user->first_name) }}"
                   class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        @error('first_name') <p class="col-span-12 col-start-5 text-red-600 text-xs">{{ $message }}</p> @enderror
    </div>

    {{-- Last Name --}}
    <div class="grid grid-cols-12 gap-3 items-center mb-4">
        <label class="col-span-4 text-sm text-gray-700">Last Name :</label>
        <input type="text" name="last_name" data-autosave
               value="{{ old('last_name', $user->last_name) }}"
               placeholder="Enter Last Name"
               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    </div>

    {{-- DOB --}}
    <div class="grid grid-cols-12 gap-3 items-start mb-4">
        <label class="col-span-4 text-sm text-gray-700">DOB:</label>
        <input type="date" name="dob" data-autosave
               value="{{ old('dob', optional($user->dob)->format('Y-m-d')) }}"
               max="{{ date('Y-m-d') }}"
               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               required>
    </div>

    {{-- City --}}
    <div class="grid grid-cols-12 gap-3 items-center mb-4">
        <label class="col-span-4 text-sm text-gray-700">City :</label>
        <input type="text" name="city" data-autosave
               value="{{ old('city', $user->city) }}"
               placeholder="Enter City"
               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
    </div>

    {{-- Area --}}
    <div class="grid grid-cols-12 gap-3 items-center mb-4">
        <label class="col-span-4 text-sm text-gray-700">Area :</label>
        <input type="text" name="area" data-autosave
               value="{{ old('area', $user->area) }}"
               placeholder="Enter Area"
               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
    </div>

    {{-- Pincode --}}
    <div class="grid grid-cols-12 gap-3 items-center mb-4">
        <label class="col-span-4 text-sm text-gray-700">Pincode :</label>
        <input type="text" name="pincode" data-autosave maxlength="6" inputmode="numeric"
               value="{{ old('pincode', $user->pincode) }}"
               placeholder="Enter Pincode"
               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        @error('pincode') <p class="col-span-12 col-start-5 text-red-600 text-xs">{{ $message }}</p> @enderror
    </div>

</form>
           {{-- 💾 Auto-save status indicator --}}
<div id="autosaveStatus" class="hidden fixed top-20 right-6 z-50 flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium shadow-md transition-all">
    <span id="autosaveIcon"></span>
    <span id="autosaveText"></span>
</div>    
            </div>
        </div>

        {{-- 📸 Right: Image Upload + Mobile --}}
        <div class="lg:col-span-3 pt-6">

           <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

 
    {{-- Image Upload --}}
    <div class="flex items-center gap-3 mb-5">
        <div class="w-20 h-20 rounded overflow-hidden bg-gray-200 flex-shrink-0">
            <img id="avatarPreview"
                 src="{{ $user->avatar ? asset($user->avatar) : '' }}"
                 alt="Profile"
                 class="w-full h-full object-cover">
        </div>
        <label class="flex-1 cursor-pointer">
            <span class="block bg-white border border-gray-300 rounded px-3 py-2 text-sm text-gray-700 text-center hover:bg-gray-50">
                Browse Image
            </span>
           
            <input type="file"
                   id="avatarInput"
                   accept="image/jpeg,image/png,image/webp"
                   class="hidden">
        </label>
    </div>

    {{-- Mobile Number --}}
    <div class="mb-4">
        <label class="block text-sm text-gray-700 mb-2">Mobile Number :</label>
        <div class="flex">
            <select id="mobile1_code"
                    class="border border-gray-300 rounded-l px-2 py-2 text-sm bg-white border-r-0 focus:outline-none">
                <option value="+91">+91</option>
                <option value="+1">+1</option>
                <option value="+44">+44</option>
            </select>
            
            <input type="text"
                   name="mobile"
                   data-autosave
                   id="mobile_input"
                   value="{{ $user->mobile }}"
                   maxlength="10"
                   inputmode="numeric"
                   class="flex-1 border border-gray-300 rounded-r px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
    </div>

    {{-- ✅ FIXED: Email field (was wrongly a numeric phone input) --}}
    <div>
        <label class="block text-sm text-gray-700 mb-2">Email :</label>
        <div class="flex">
            <input type="email"
                   name="email"
                   data-autosave
                   id="email_input"
                   value="{{ $user->email }}"
                   placeholder="Enter your email"
                   class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>
    </div>
</div>
 

        </div>
    </div>
</div>

{{-- 🔐 OTP Modal --}}
<div id="otpModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-blue-600"></i>
                Verify Mobile
            </h3>
            <button onclick="closeOtpModal()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <p class="text-sm text-gray-600 mb-4">
            Enter the 6-digit OTP sent to <strong id="otpMobile"></strong>
        </p>

        <input type="text"
               id="otpInput"
               maxlength="6"
               inputmode="numeric"
               placeholder="------"
               class="w-full text-center text-2xl tracking-widest border-2 border-gray-300 rounded px-3 py-3 mb-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')">

        <div id="otpError" class="hidden text-red-600 text-sm mb-3"></div>

        <button onclick="verifyOtp()"
                id="verifyBtn"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded transition">
            Verify OTP
        </button>

        <button onclick="closeOtpModal()" class="w-full mt-2 text-sm text-gray-500 hover:text-gray-700">
            Cancel
        </button>
    </div>
</div>

 
<script>
(function () {
    const SAVE_URL = '{{ route("user.profile.autosave") }}';
    const CSRF = '{{ csrf_token() }}';
    const statusBox  = document.getElementById('autosaveStatus');
    const statusIcon = document.getElementById('autosaveIcon');
    const statusText = document.getElementById('autosaveText');

    let debounceTimers = {};

    // 🎯 Attach to all data-autosave fields
    document.querySelectorAll('[data-autosave]').forEach(el => {
        const eventType = (el.tagName === 'SELECT' || el.type === 'date') ? 'change' : 'input';

        el.addEventListener(eventType, function () {
            const field = el.name;
            const value = el.value;

            // Debounce per-field (waits 600ms after typing stops)
            clearTimeout(debounceTimers[field]);
            debounceTimers[field] = setTimeout(() => saveField(field, value, el), 600);
        });

        // Save immediately on blur (e.g. user tabs away)
        el.addEventListener('blur', function () {
            clearTimeout(debounceTimers[el.name]);
            saveField(el.name, el.value, el);
        });
    });

    // 💾 Save single field
    async function saveField(field, value, el) {
        showStatus('saving');

        try {
            const res = await fetch(SAVE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ field, value })
            });

            const data = await res.json();

            if (res.ok && data.success) {
                showStatus('saved');
                clearFieldError(el);

                // Update progress bar if present
                if (data.progress !== undefined) {
                    updateProgress(data.progress);
                }
            } else {
                showStatus('error', data.message);
                showFieldError(el, data.message);
            }
        } catch (e) {
            showStatus('error', 'Connection lost');
        }
    }

    // 🎨 Status indicator
    function showStatus(state, message = '') {
        statusBox.classList.remove('hidden');

        const states = {
            saving: { bg: 'bg-gray-700 text-white',   icon: '⏳', text: 'Saving...' },
            saved:  { bg: 'bg-green-600 text-white',   icon: '✓',  text: 'Saved' },
            error:  { bg: 'bg-red-600 text-white',     icon: '✕',  text: message || 'Save failed' },
        };

        const s = states[state];
        statusBox.className = `fixed top-20 right-16 z-50 flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium shadow-md transition-all ${s.bg}`;
        statusIcon.textContent = s.icon;
        statusText.textContent = s.text;

        // Auto-hide after success
        if (state === 'saved') {
            setTimeout(() => statusBox.classList.add('hidden'), 1500);
        }
    }

 
function showFieldError(el, msg) {
    el.classList.add('border-red-500', 'ring-1', 'ring-red-500');

    // Append error to the ROW (.mb-4), not the immediate grid parent
    const row = el.closest('.mb-4') || el.parentElement;

    let errEl = row.querySelector('.autosave-error');
    if (!errEl) {
        errEl = document.createElement('p');
        errEl.className = 'autosave-error text-red-600 text-xs mt-1 ';
    
        errEl.style.gridColumn = '5 / -1';
         errEl.style.textAlign  = 'left';
        errEl.style.whiteSpace = 'normal';
        row.appendChild(errEl);
    }
    errEl.textContent = msg;
}

function clearFieldError(el) {
    el.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
    const row = el.closest('.mb-4') || el.parentElement;
    const errEl = row.querySelector('.autosave-error');
    if (errEl) errEl.remove();
}

    // 📊 Update progress bar (if your step-indicator has one)
    function updateProgress(progress) {
        const bar = document.querySelector('[data-progress-bar]');
        const label = document.querySelector('[data-progress-label]');
        if (bar) bar.style.width = progress + '%';
        if (label) label.textContent = `Overall Progress ${progress}%`;
    }
})();
</script>
 


 
<script>


document.getElementById('avatarInput').addEventListener('change', async function (e) {
    const file = e.target.files[0];
    if (!file) return;

    // Instant preview
    const reader = new FileReader();
    reader.onload = ev => document.getElementById('avatarPreview').src = ev.target.result;
    reader.readAsDataURL(file);

    const formData = new FormData();
    formData.append('avatar', file);

    try {
        const res = await fetch('{{ route("user.profile.autosave-avatar") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: formData
        });

        const data = await res.json();

        if (res.ok && data.success) {
            document.getElementById('avatarPreview').src = data.url + '?t=' + Date.now(); // cache bust
            showToast(data.message, 'success');
        } else {
            showToast(data.message || 'Upload failed', 'error');
        }
    } catch (err) {
        showToast('Network error', 'error');
    }
});


 
function updateProgressBar(progress) {
    const bar = document.querySelector('[data-progress-bar]');
    const label = document.querySelector('[data-progress-label]');
    if (bar) bar.style.width = progress + '%';
    if (label) label.textContent = `Overall Progress ${progress}%`;
}
</script>
 

@endsection