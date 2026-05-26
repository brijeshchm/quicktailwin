{{-- resources/views/client/book-appointment.blade.php --}}
@extends('client.layouts.app')
@section('title', 'Book Appointment — Dr. ' . $doctor->name)

@section('content')
<div x-data="bookingFlow({
        doctorId: {{ $doctor->id }},
        doctorSlug: '{{ $doctor->slug }}',
        consultationFee: {{ $doctor->consultation_fee }}
    })" class="min-h-screen bg-sidebar/30 py-8 sm:py-12">

    <div class="max-w-3xl mx-auto px-4">

        {{-- Stepper --}}
        <div class="flex items-center justify-between mb-10 max-w-md mx-auto">
            <template x-for="(step, idx) in steps" :key="step.num">
                <div class="flex items-center flex-1 last:flex-none">
                    <div class="flex flex-col items-center">
                        <div :class="currentStep > step.num ? 'bg-green-500 text-white' : (currentStep === step.num ? 'bg-primary text-white' : 'bg-muted text-muted-foreground')"
                             class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all">
                            <i x-show="currentStep > step.num" data-lucide="check" class="w-5 h-5"></i>
                            <span x-show="currentStep <= step.num" x-text="step.num"></span>
                        </div>
                        <span :class="currentStep >= step.num ? 'text-foreground font-medium' : 'text-muted-foreground'"
                              class="text-xs mt-2" x-text="step.label"></span>
                    </div>
                    <div x-show="idx < steps.length - 1"
                         :class="currentStep > step.num ? 'bg-green-500' : 'bg-muted'"
                         class="flex-1 h-0.5 mx-2 transition-all"></div>
                </div>
            </template>
        </div>

        {{-- Doctor summary --}}
        <div class="rounded-2xl border border-border/50 bg-white shadow-sm p-5 mb-6 flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl overflow-hidden bg-muted shrink-0">
                @if ($doctor->image_url)
                    <img src="{{ $doctor->image_url }}" alt="{{ $doctor->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-primary/10 text-primary font-bold">{{ $doctor->initials }}</div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="font-bold text-lg truncate">{{ $doctor->name }}</h2>
                <p class="text-sm text-muted-foreground">{{ $doctor->specialty }}</p>
                @if ($doctor->clinic)
                    <p class="text-xs text-muted-foreground flex items-center gap-1 mt-1">
                        <i data-lucide="building-2" class="w-3 h-3"></i> {{ $doctor->clinic->name }}
                    </p>
                @endif
            </div>
            <div class="text-right">
                <p class="text-xs text-muted-foreground">Consultation</p>
                <p class="text-xl font-bold text-primary">${{ number_format($doctor->consultation_fee, 0) }}</p>
            </div>
        </div>

        {{-- ─── STEP 1: Date & Time ─── --}}
        <div x-show="currentStep === 1" x-transition class="rounded-2xl border border-border/50 bg-white shadow-sm p-6">
            <h3 class="text-xl font-bold font-serif mb-1">Select Date & Time</h3>
            <p class="text-sm text-muted-foreground mb-6">Choose when you'd like to see Dr. {{ explode(' ', $doctor->name)[1] ?? '' }}</p>

            {{-- Date picker (next 14 days) --}}
            <div class="mb-6">
                <label class="text-sm font-medium mb-3 block">Choose Date</label>
                <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
                    <template x-for="day in availableDates" :key="day.iso">
                        <button @click="selectDate(day.iso)" type="button"
                                :class="selectedDate === day.iso ? 'bg-primary text-white border-primary' : 'bg-white border-border hover:border-primary/50 text-foreground'"
                                class="p-3 rounded-xl border-2 transition-all text-center">
                            <div class="text-xs uppercase opacity-70" x-text="day.weekday"></div>
                            <div class="text-lg font-bold" x-text="day.day"></div>
                            <div class="text-xs opacity-70" x-text="day.month"></div>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Time slots --}}
            <div x-show="selectedDate" x-transition>
                <label class="text-sm font-medium mb-3 block">Available Time Slots</label>
                <div x-show="loadingSlots" class="text-center py-8 text-muted-foreground">
                    <i data-lucide="loader" class="w-6 h-6 animate-spin mx-auto"></i>
                    <p class="mt-2 text-sm">Loading slots...</p>
                </div>
                <div x-show="!loadingSlots && slots.length === 0" class="text-center py-8 text-muted-foreground">
                    No slots available on this day. Try another date.
                </div>
                <div x-show="!loadingSlots && slots.length > 0" class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                    <template x-for="slot in slots" :key="slot.time">
                        <button @click="slot.available && (selectedTime = slot.time)" type="button"
                                :disabled="!slot.available"
                                :class="{
                                    'bg-primary text-white border-primary': selectedTime === slot.time,
                                    'bg-white border-border hover:border-primary/50': slot.available && selectedTime !== slot.time,
                                    'bg-muted/50 text-muted-foreground/50 border-muted cursor-not-allowed line-through': !slot.available
                                }"
                                class="p-2 rounded-lg border-2 text-sm font-medium transition-all">
                            <span x-text="slot.time"></span>
                        </button>
                    </template>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button @click="nextStep" type="button"
                        :disabled="!selectedDate || !selectedTime"
                        :class="!selectedDate || !selectedTime ? 'bg-muted text-muted-foreground cursor-not-allowed' : 'bg-primary hover:bg-primary/90 text-white'"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-colors">
                    Continue <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        {{-- ─── STEP 2: Patient Details ─── --}}
        <div x-show="currentStep === 2" x-transition class="rounded-2xl border border-border/50 bg-white shadow-sm p-6">
            <h3 class="text-xl font-bold font-serif mb-1">Your Details</h3>
            <p class="text-sm text-muted-foreground mb-6">We'll use this to confirm your appointment</p>

            <form @submit.prevent="submitBooking">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium mb-1.5 block">Full Name *</label>
                        <input x-model="form.patient_name" type="text" required minlength="2"
                               class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:border-primary"
                               placeholder="John Doe">
                    </div>
                    <div>
                        <label class="text-sm font-medium mb-1.5 block">Phone *</label>
                        <input x-model="form.patient_phone" type="tel" required minlength="10"
                               class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:border-primary"
                               placeholder="+91 98765 43210">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="text-sm font-medium mb-1.5 block">Email *</label>
                    <input x-model="form.patient_email" type="email" required
                           class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:border-primary"
                           placeholder="you@example.com">
                </div>
                <div class="mb-4">
                    <label class="text-sm font-medium mb-1.5 block">Reason for Visit *</label>
                    <textarea x-model="form.reason" required minlength="10" rows="3"
                              class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:border-primary"
                              placeholder="Briefly describe your symptoms or reason for the visit..."></textarea>
                </div>
                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium mb-1.5 block">Current Medications</label>
                        <textarea x-model="form.previous_medications" rows="2"
                                  class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:border-primary"
                                  placeholder="Optional"></textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium mb-1.5 block">Known Allergies</label>
                        <textarea x-model="form.allergies" rows="2"
                                  class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:border-primary"
                                  placeholder="Optional"></textarea>
                    </div>
                </div>

                {{-- Summary card --}}
                <div class="mt-6 p-4 rounded-xl bg-primary/5 border border-primary/20">
                    <p class="text-sm font-semibold mb-2 flex items-center gap-2">
                        <i data-lucide="calendar-check" class="w-4 h-4 text-primary"></i> Appointment Summary
                    </p>
                    <div class="text-sm text-muted-foreground space-y-1">
                        <div>📅 <strong x-text="formattedDate"></strong></div>
                        <div>🕒 <strong x-text="selectedTime"></strong></div>
                        <div>💰 <strong>${{ number_format($doctor->consultation_fee, 0) }}</strong></div>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button @click="prevStep" type="button"
                            class="inline-flex items-center gap-2 px-6 py-3 border border-border rounded-lg font-medium hover:bg-muted/30">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i> Back
                    </button>
                    <button type="submit" :disabled="submitting"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-lg font-medium disabled:opacity-50">
                        <span x-show="!submitting">Confirm Booking</span>
                        <span x-show="submitting" class="flex items-center gap-2">
                            <i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Booking...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ─── STEP 3: Success ─── --}}
        <div x-show="currentStep === 3" x-transition class="rounded-2xl border border-green-200 bg-white shadow-sm p-8 text-center">
            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="check-circle-2" class="w-12 h-12 text-green-600"></i>
            </div>
            <h3 class="text-2xl font-bold font-serif mb-2">Appointment Confirmed!</h3>
            <p class="text-muted-foreground mb-6">A confirmation email has been sent to <strong x-text="form.patient_email"></strong></p>

            <div class="bg-muted/30 rounded-xl p-4 max-w-sm mx-auto mb-6 text-left text-sm space-y-2">
                <div class="flex justify-between"><span class="text-muted-foreground">Doctor:</span> <strong>{{ $doctor->name }}</strong></div>
                <div class="flex justify-between"><span class="text-muted-foreground">Date:</span> <strong x-text="formattedDate"></strong></div>
                <div class="flex justify-between"><span class="text-muted-foreground">Time:</span> <strong x-text="selectedTime"></strong></div>
                <div class="flex justify-between"><span class="text-muted-foreground">Fee:</span> <strong>${{ number_format($doctor->consultation_fee, 0) }}</strong></div>
            </div>

            <div class="flex flex-wrap gap-3 justify-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-border rounded-lg font-medium hover:bg-muted/30">
                    Back to Home
                </a>
                @auth
                    <a href="{{ route('appointments.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-lg font-medium">
                        View My Appointments <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endauth
            </div>
        </div>

        <p x-show="errorMsg" x-text="errorMsg" class="text-red-500 text-sm mt-4 text-center"></p>
    </div>
</div>

@push('scripts')
<script>
function bookingFlow(config) {
    return {
        ...config,
        currentStep: 1,
        steps: [
            { num: 1, label: 'Date & Time' },
            { num: 2, label: 'Your Details' },
            { num: 3, label: 'Confirmed' },
        ],
        availableDates: [],
        selectedDate: null,
        selectedTime: null,
        slots: [],
        loadingSlots: false,
        submitting: false,
        errorMsg: '',
        form: {
            patient_name: '', patient_email: '', patient_phone: '',
            reason: '', previous_medications: '', allergies: '', notes: '',
        },

        init() {
            // Generate next 14 days
            const days = [];
            for (let i = 0; i < 14; i++) {
                const d = new Date();
                d.setDate(d.getDate() + i);
                days.push({
                    iso: d.toISOString().split('T')[0],
                    weekday: d.toLocaleDateString('en-US', { weekday: 'short' }),
                    day: d.getDate(),
                    month: d.toLocaleDateString('en-US', { month: 'short' }),
                });
            }
            this.availableDates = days;
            this.$watch('currentStep', () => {
                this.$nextTick(() => window.lucide?.createIcons());
            });
        },

        get formattedDate() {
            if (!this.selectedDate) return '';
            return new Date(this.selectedDate).toLocaleDateString('en-US', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
            });
        },

        async selectDate(iso) {
            this.selectedDate = iso;
            this.selectedTime = null;
            this.loadingSlots = true;
            try {
                const res = await fetch(`/book/${this.doctorSlug}/slots`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({ date: iso }),
                });
                const data = await res.json();
                this.slots = data.slots;
            } catch (e) {
                this.errorMsg = 'Failed to load slots';
            } finally {
                this.loadingSlots = false;
                this.$nextTick(() => window.lucide?.createIcons());
            }
        },

        nextStep() {
            if (this.currentStep < 3) this.currentStep++;
            this.$nextTick(() => window.lucide?.createIcons());
        },

        prevStep() {
            if (this.currentStep > 1) this.currentStep--;
            this.$nextTick(() => window.lucide?.createIcons());
        },

        async submitBooking() {
            this.submitting = true;
            this.errorMsg = '';
            try {
                const res = await fetch(`/book/${this.doctorSlug}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({
                        appointment_date: this.selectedDate,
                        appointment_time: this.selectedTime,
                        ...this.form,
                    }),
                });
                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    this.currentStep = 3;
                    this.$nextTick(() => window.lucide?.createIcons());
                } else {
                    this.errorMsg = data.message || 'Booking failed. Please try again.';
                }
            } catch (e) {
                this.errorMsg = 'Network error. Please try again.';
            } finally {
                this.submitting = false;
            }
        },
    }
}
</script>
 

@endsection