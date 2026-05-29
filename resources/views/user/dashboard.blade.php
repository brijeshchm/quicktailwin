@extends('user.layouts.guest')

@section('title', 'Copyright Policy | QuickDials - Content Usage & Protection Policy')

@section('description', 'Read the QuickDials Copyright Policy to understand content ownership, intellectual property rights, permitted usage, copyright infringement reporting, and protection of digital content published on QuickDials.')

@section('keyword', 'QuickDials copyright policy, copyright protection, intellectual property rights, content usage policy, digital copyright, copyright infringement, website content protection, QuickDials legal policy, business listing content policy, online content rights')
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
                'currentStep' => 'dashboard'
            ])
        </div>

        {{-- 📝 Middle: Form --}}
        <div class="lg:col-span-6 pt-6">
            <div class="bg-gray-50 rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Please provide your personal details
                </h2>
    

                <form action=""
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
                                <select name="title" required
                                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Mr"  {{ old('title', $user->title) == 'Mr' ? 'selected' : '' }}>Mr</option>
                                    <option value="Ms"  {{ old('title', $user->title) == 'Ms' ? 'selected' : '' }}>Ms</option>
                                    <option value="Mrs" {{ old('title', $user->title) == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                    <option value="Dr"  {{ old('title', $user->title) == 'Dr' ? 'selected' : '' }}>Dr</option>
                                </select>
                            </div>
                            <input type="text" name="first_name" required
                                   value="{{ old('first_name', $user->first_name) }}"
                                   class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        @error('first_name') <p class="col-span-12 col-start-5 text-red-600 text-xs">{{ $message }}</p> @enderror
                    </div>

                    

                    {{-- Last Name --}}
                    <div class="grid grid-cols-12 gap-3 items-center mb-4">
                        <label class="col-span-4 text-sm text-gray-700">Last Name :</label>
                        <input type="text" name="last_name"
                               value="{{ old('last_name', $user->last_name) }}"
                               placeholder="Enter Last Name"
                               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- DOB --}}
                    <div class="grid grid-cols-12 gap-3 items-start mb-4">
                    
                <label class="col-span-4 text-sm text-gray-700">DOB:</label>

               
                        
               
                            <input 
                                type="date"
                                name="dob"
                                value="{{ old('dob', optional($user->dob)->format('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}"
                                class="
                                col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                                "
                                required
                            >

                          
                     

                       

                   

                </div>

                    {{-- Marital Status --}}
                     

                    {{-- City --}}
                    <div class="grid grid-cols-12 gap-3 items-center mb-4">
                        <label class="col-span-4 text-sm text-gray-700">City :</label>
                        <input type="text" name="city"
                               value="{{ old('city', $user->city) }}"
                               placeholder="Enter City"
                               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Area --}}
                    <div class="grid grid-cols-12 gap-3 items-center mb-4">
                        <label class="col-span-4 text-sm text-gray-700">Area :</label>
                        <input type="text" name="area"
                               value="{{ old('area', $user->area) }}"
                               placeholder="Enter Area"
                               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Pincode --}}
                    <div class="grid grid-cols-12 gap-3 items-center mb-4">
                        <label class="col-span-4 text-sm text-gray-700">Pincode :</label>
                        <input type="text" name="pincode" maxlength="6" inputmode="numeric"
                               value="{{ old('pincode', $user->pincode) }}"
                               placeholder="Enter Pincode"
                               class="col-span-8 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        @error('pincode') <p class="col-span-12 col-start-5 text-red-600 text-xs">{{ $message }}</p> @enderror
                    </div>

                                   

                   
                </form>
            </div>
        </div>

        {{-- 📸 Right: Image Upload + Mobile --}}
        <div class="lg:col-span-3 pt-6">
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">

                {{-- Image Upload --}}
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-20 h-20 rounded overflow-hidden bg-gray-200 flex-shrink-0">
                        <img id="avatarPreview"
                             src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200' }}"
                             alt="Profile"
                             class="w-full h-full object-cover">
                    </div>
                    <label class="flex-1 cursor-pointer">
                        <span class="block bg-white border border-gray-300 rounded px-3 py-2 text-sm text-gray-700 text-center hover:bg-gray-50">
                            Browse Image
                        </span>
                        <input type="file"
                               id="avatarInput"
                               name="avatar"
                               accept="image/jpeg,image/png,image/webp"
                               form="profileForm"
                               class="hidden">
                    </label>
                </div>

                {{-- Mobile 1 (Verified) --}}
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
                               id="mobile1_input"
                               value="{{ $user->mobile_1 }}"
                               maxlength="10"
                               inputmode="numeric"
                               class="flex-1 border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                        
                            
                        
                    </div>
                </div>

                {{-- Mobile 2 --}}
                <div>
                    <label class="block text-sm text-gray-700 mb-2">Email :</label>
                    <div class="flex">
                        
                        <input type="text"
                               id="mobile2_input"
                               value="{{ $user->mobile_2 }}"
                               maxlength="10"
                               inputmode="numeric"
                               class="flex-1 border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">                        
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
let currentField = null;
let currentMobile = null;

// 🖼️ Avatar Preview
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => document.getElementById('avatarPreview').src = e.target.result;
        reader.readAsDataURL(file);
    }
});

// 📲 Sync mobile values to hidden inputs before form submit
document.getElementById('profileForm').addEventListener('submit', function() {
    document.getElementById('mobile_1_hidden').value = document.getElementById('mobile1_input').value;
    document.getElementById('mobile_2_hidden').value = document.getElementById('mobile2_input').value;
});

// 🔐 Send OTP
async function sendOtp(field, inputId) {
    const mobile = document.getElementById(inputId).value;

    if (!/^\d{10}$/.test(mobile)) {
        alert('Please enter a valid 10-digit mobile number');
        return;
    }

    currentField = field;
    currentMobile = mobile;

    try {
        const response = await fetch('{{ route("user.profile.send-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ mobile })
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('otpMobile').textContent = '+91 ' + mobile;
            document.getElementById('otpModal').classList.remove('hidden');
            document.getElementById('otpInput').focus();

            // Show OTP in dev environment
            if (data.debug_otp) {
                console.log('🔐 DEV OTP:', data.debug_otp);
                document.getElementById('otpInput').placeholder = data.debug_otp;
            }
        } else {
            alert(data.message || 'Failed to send OTP');
        }
    } catch (error) {
        alert('Network error. Please try again.');
    }
}

// ✅ Verify OTP
async function verifyOtp() {
    const otp = document.getElementById('otpInput').value;
    const btn = document.getElementById('verifyBtn');
    const errorEl = document.getElementById('otpError');

    if (otp.length !== 6) {
        errorEl.textContent = 'Please enter a 6-digit OTP';
        errorEl.classList.remove('hidden');
        return;
    }

    btn.disabled = true;
    btn.textContent = 'Verifying...';
    errorEl.classList.add('hidden');

    try {
        const response = await fetch('{{ route("user.profile.verify-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                mobile: currentMobile,
                otp,
                field: currentField
            })
        });

        const data = await response.json();

        if (data.success) {
            alert('✅ Mobile verified successfully!');
            location.reload();
        } else {
            errorEl.textContent = data.message || 'Invalid OTP';
            errorEl.classList.remove('hidden');
        }
    } catch (error) {
        errorEl.textContent = 'Network error';
        errorEl.classList.remove('hidden');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Verify OTP';
    }
}

function closeOtpModal() {
    document.getElementById('otpModal').classList.add('hidden');
    document.getElementById('otpInput').value = '';
    document.getElementById('otpError').classList.add('hidden');
}
</script>
 


@endsection