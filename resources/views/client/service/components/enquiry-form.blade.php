<div class="max-w-md mx-auto bg-white shadow-lg rounded-xl p-6 border">

  <h3 class="text-lg font-semibold mb-2">
    Fill out the form to receive the best offers 
    <span class="text-blue-600">{{ $keyword->keyword ?? '' }}</span>
  </h3>

  <p class="text-sm text-gray-500 mb-4">
    We’ll send you the contact details instantly free of charge
  </p>

  <form id="lead_Form" onsubmit="return homeController.saveTwoEnquiry(this)" method="POST" class="space-y-4" autocomplete="off"
    autocorrect="off"
    autocapitalize="off">
    {{ csrf_field() }}

    <!-- Steps Indicator -->
    <div class="flex justify-between mb-4">
      <span class="step-indicator w-6 h-2 bg-blue-500 rounded"></span>
      <span class="step-indicator w-6 h-2 bg-gray-300 rounded"></span>
      <span class="step-indicator w-6 h-2 bg-gray-300 rounded"></span>
    </div>

    <!-- STEP 1 -->
    <div class="form-step">
      <h4 class="font-medium mb-2">Your Details</h4>

      <input type="text" name="name" placeholder="Full Name"
        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">

      <input type="email" name="email" placeholder="Email"
        class="w-full border rounded-lg px-3 py-2">

      <input type="tel" name="mobile" placeholder="Phone Number"
        class="w-full border rounded-lg px-3 py-2">

      <select name="location"
        class="w-full border rounded-lg px-3 py-2">
        @foreach($zones as $zone)
          <option value="{{ $zone->id }}">{{ $zone->zone }} {{$zone->pincode}}</option>
        @endforeach
      </select>

      <button type="button"
        onclick="validateSidebar(this,1)"
        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
        Save & Continue
      </button>
    </div>

    <!-- STEP 2 -->
    <div class="form-step hidden">
      <h4 class="font-medium mb-2">Preferences</h4>

      <select name="age" class="w-full border rounded-lg px-3 py-2">
        <option>Select Age</option>
        @for($i = 1; $i < 100; $i += 4)
          <option value="{{$i}}">{{$i}} + Age</option>
        @endfor
      </select>

      <select name="plan" class="w-full border rounded-lg px-3 py-2">
        <option>Immediate</option>
        <option>Within week</option>
        <option>Within months</option>
      </select>

      <div class="flex gap-2">
        <button type="button" onclick="prevStep()"
          class="w-1/2 border py-2 rounded-lg">Back</button>

        <button type="button" onclick="validateSidebar(this,2)"
          class="w-1/2 bg-blue-600 text-white py-2 rounded-lg">
          Continue
        </button>
      </div>
    </div>

    <!-- STEP 3 -->
    <div class="form-step hidden">
      <textarea name="remark" placeholder="Enter Remarks"
        class="w-full border rounded-lg px-3 py-2"></textarea>

      <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="terms" checked>
        I agree to terms
      </label>

      <div class="flex gap-2">
        <button type="button" onclick="prevStep()"
          class="w-1/2 border py-2 rounded-lg">Back</button>

        <button type="submit"
          class="w-1/2 bg-green-600 text-white py-2 rounded-lg">
          Submit
        </button>
      </div>
    </div>

  </form>
</div>


<script>
let currentStep = 0;
const steps = document.querySelectorAll(".form-step");
const indicators = document.querySelectorAll(".step-indicator");

function showStep(index) {
  steps.forEach((step, i) => {
    step.classList.toggle("hidden", i !== index);
  });

  indicators.forEach((dot, i) => {
    dot.classList.toggle("bg-blue-500", i === index);
    dot.classList.toggle("bg-gray-300", i !== index);
  });
}

function nextStep() {
  if (currentStep < steps.length - 1) {
    currentStep++;
    showStep(currentStep);
  }
}

function prevStep() {
  if (currentStep > 0) {
    currentStep--;
    showStep(currentStep);
  }
}

// init
showStep(0);
</script>