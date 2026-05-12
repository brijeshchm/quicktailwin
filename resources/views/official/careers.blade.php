
@extends('client.layouts.app')
@section('title', 'Careers Quick Dials- Local search, IT Training, Service, overseas education')
@section('description', 'Careers Quick Dials- Local search, IT Training, Service, overseas education')
@section('keyword', 'Careers Quick Dials- Local search, IT Training, Service, overseas education')

@section('content') 
    <style>
        
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .anim-fade-down { animation: fadeDown .55s ease both; }
        .anim-fade-up   { animation: fadeUp   .55s ease both; }

        .job-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px -6px rgba(0,0,0,.1);
        }

        .input-focus {
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .input-focus:focus {
            outline: none;
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }
    </style>


{{-- ══════════════════════════
     BANNER
══════════════════════════ --}}
<!-- <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-7 text-center">
    <p class="text-xl font-bold">QuickDials – Grow With Us</p>
    <p class="text-indigo-200 mt-1 text-sm">Globally recognised training programmes</p>
</div> -->

{{-- ══════════════════════════
     HERO
══════════════════════════ --}}
<section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16 text-center">
    <h1 class="text-3xl md:text-5xl font-bold mb-4 anim-fade-down">
        Join Our Team 🚀
    </h1>
    <p class="text-lg opacity-90 anim-fade-down" style="animation-delay:.12s">
        Build your career with us and grow together
    </p>
</section>

{{-- ══════════════════════════
     OPEN POSITIONS
══════════════════════════ --}}
<section class="max-w-6xl mx-auto px-4 py-14">

    <h2 class="text-2xl font-bold mb-8 text-center">Open Positions</h2>

    @php
    $jobs = [
        [
            'id'         => 1,
            'title'      => 'Frontend Developer',
            'type'       => 'Full Time',
            'location'   => 'Noida, India',
            'experience' => '2-4 Years',
        ],
        [
            'id'         => 2,
            'title'      => 'Backend Developer (Laravel)',
            'type'       => 'Full Time',
            'location'   => 'Remote',
            'experience' => '3-5 Years',
        ],
        [
            'id'         => 3,
            'title'      => 'SEO Executive',
            'type'       => 'Full Time',
            'location'   => 'Delhi',
            'experience' => '1-3 Years',
        ],
        [
            'id'         => 4,
            'title'      => 'Digital Marketing Manager',
            'type'       => 'Full Time',
            'location'   => 'Hybrid',
            'experience' => '3-6 Years',
        ],
    ];
    @endphp

    <div class="grid md:grid-cols-2 gap-6">
        @foreach($jobs as  $job)
        <?php $i =0; $i++; ?>
        <div class="job-card bg-white p-6 rounded-2xl shadow border border-slate-100 anim-fade-up"
             style="animation-delay:{{ $i * 0.1 }}s">

            <h3 class="text-lg font-semibold mb-2">{{ $job['title'] }}</h3>

            <div class="flex flex-wrap gap-2 text-sm text-gray-500 mb-4">
                <span class="flex items-center gap-1 px-2.5 py-1 bg-slate-100 rounded-full">
                    📍 {{ $job['location'] }}
                </span>
                <span class="flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full font-medium">
                    💼 {{ $job['type'] }}
                </span>
                <span class="flex items-center gap-1 px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-full">
                    ⏳ {{ $job['experience'] }}
                </span>
            </div>

            {{-- Apply button triggers modal --}}
            <button
                @click="openModal('{{ addslashes($job['title']) }}')"
                x-data
                class="mt-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Apply Now
            </button>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════
     CTA BANNER
══════════════════════════ --}}
<section class="text-center py-14 bg-white border-t border-slate-100">
    <h3 class="text-xl font-semibold mb-2">Didn't find a suitable role?</h3>
    <p class="text-gray-500 mb-5">Send your resume and we'll get back to you</p>
    <a href="mailto:hr@quickdials.com"
       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-7 py-3 rounded-lg transition-colors">
        Send Resume
    </a>
</section>

{{-- ══════════════════════════
     FOOTER
══════════════════════════ --}}
<footer class="bg-slate-900 text-slate-400 py-7 text-center text-sm">
    <p>&copy; {{ date('Y') }} QuickDials Internet Pvt Ltd. All rights reserved.</p>
</footer>

{{-- ══════════════════════════
     APPLY MODAL (Alpine)
══════════════════════════ --}}
<div
    x-data="applyModal()"
    @open-modal.window="open($event.detail)"
    x-cloak
>
    {{-- Backdrop --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="close()"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"
    ></div>

    {{-- Modal panel --}}
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 translate-y-6 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden" @click.stop>

            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5 flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-200 mb-0.5">Applying for</p>
                    <h2 class="text-white font-bold text-lg leading-tight" x-text="jobTitle"></h2>
                </div>
                <button @click="close()" class="text-white/70 hover:text-white transition-colors mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Success --}}
            <div x-show="submitted" class="flex flex-col items-center justify-center py-12 px-6 text-center gap-3">
                <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Application Submitted!</h3>
                <p class="text-gray-500 text-sm">We'll review your application and reach out soon.</p>
                <button @click="close()" class="mt-2 text-sm text-indigo-600 font-semibold hover:underline">Close</button>
            </div>

            {{-- Form --}}
            <div x-show="!submitted" class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Full Name</label>
                        <input x-model="form.name" type="text" placeholder="Jane Smith" required
                               class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                        <input x-model="form.email" type="email" placeholder="jane@email.com" required
                               class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Mobile</label>
                    <input x-model="form.mobile" type="tel" placeholder="Enter Phone" required
                           class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Subject</label>
                    <input x-model="form.subject" type="text" placeholder="e.g. Applying for Frontend Developer"
                           class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Cover Letter / Message</label>
                    <textarea x-model="form.message" rows="3" placeholder="Tell us about yourself…" required
                              class="input-focus w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-300 resize-none"></textarea>
                </div>

                <button type="button" @click="submit()" :disabled="loading"
                        class="w-full py-3 rounded-xl font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-colors disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <template x-if="loading">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Submitting…
                        </span>
                    </template>
                    <template x-if="!loading">
                        <span>Submit Application</span>
                    </template>
                </button>
            </div>

        </div>
    </div>
</div>

 <script>
function applyModal() {
    return {
        isOpen:    false,
        submitted: false,
        loading:   false,
        jobTitle:  '',
        form: { name: '', email: '', mobile: '', subject: '', message: '' },

        open(title) {
            this.jobTitle  = title;
            this.isOpen    = true;
            this.submitted = false;
            this.form      = { name: '', email: '', mobile: '', subject: title ? `Applying for ${title}` : '', message: '' };
            document.body.style.overflow = 'hidden';
        },

        close() {
            this.isOpen = false;
            document.body.style.overflow = '';
        },

        async submit() {
            if (!this.form.name || !this.form.email || !this.form.message) return;
            this.loading = true;
            try {
                /*
                 * Wire to Laravel:
                 * await fetch('/api/careers/apply', {
                 *   method: 'POST',
                 *   headers: {
                 *     'Content-Type': 'application/json',
                 *     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                 *   },
                 *   body: JSON.stringify({ ...this.form, job: this.jobTitle }),
                 * });
                 */
                await new Promise(r => setTimeout(r, 1400)); // remove when wired
                this.submitted = true;
            } finally {
                this.loading = false;
            }
        },
    };
}

 
function openModal(title) {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: title }));
}
</script> 
 
 @endsection
