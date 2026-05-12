
@extends('client.layouts.app')
@section('title', 'Privacy Policy Quick Dials- Local search, IT Training, Service, overseas education')
@section('description', 'Privacy Policy Dials- Local search, IT Training, Service, overseas education')
@section('keyword', 'Privacy Policy Dials- Local search, IT Training, Service, overseas education')

@section('content') 

 
    <style>
        [x-cloak] { display: none !important; }

        body { background: hsl(270 30% 98%); }

        /* ── Glass card ── */
        .glass-card {
            background: rgba(255,255,255,0.72);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(139,92,246,0.12);
            box-shadow: 0 4px 24px rgba(139,92,246,0.07);
        }

        /* ── Scroll progress bar ── */
        #progress-bar {
            position: fixed;
            top: 0; left: 0;
            height: 3px;
            z-index: 100;
            background: linear-gradient(90deg, hsl(270 70% 58%), hsl(290 80% 65%), hsl(250 75% 65%));
            transition: width .15s ease;
        }

        /* ── Scroll reveal ── */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .55s ease, transform .55s ease;
        }
        .scroll-reveal.visible {
            opacity: 1;
            transform: none;
        }

        /* ── Floating orbs ── */
        @keyframes orbFloat1 {
            0%,100% { transform: translateY(0) scale(1); }
            50%      { transform: translateY(-30px) scale(1.05); }
        }
        @keyframes orbFloat2 {
            0%,100% { transform: translateY(0) scale(1); }
            50%      { transform: translateY(20px) scale(0.97); }
        }
        .orb-1 { animation: orbFloat1 9s ease-in-out infinite; }
        .orb-2 { animation: orbFloat2 12s ease-in-out infinite; }

        /* ── Float icon ── */
        @keyframes floatIcon {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-5px); }
        }
        .icon-float { animation: floatIcon 3s ease-in-out infinite; }

        /* ── Shimmer text ── */
        @keyframes shimmer {
            0%   { background-position: -400px 0; }
            100% { background-position: 400px 0; }
        }
        .shimmer-text {
            background: linear-gradient(90deg, hsl(270 70% 55%), hsl(290 80% 65%), hsl(250 75% 60%), hsl(270 70% 55%));
            background-size: 400px 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 4s linear infinite;
        }

        /* ── Fade-in-up ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-1 { animation: fadeInUp .5s ease both .1s; }
        .anim-2 { animation: fadeInUp .5s ease both .2s; }
        .anim-3 { animation: fadeInUp .5s ease both .3s; }
        .anim-4 { animation: fadeInUp .5s ease both .4s; }

        /* ── Active nav link ── */
        .nav-active {
            background: linear-gradient(135deg, hsl(270 70% 95%), hsl(290 70% 94%));
            color: hsl(270 70% 45%);
            font-weight: 600;
        }
        .nav-inactive {
            color: hsl(270 15% 50%);
        }
        .nav-inactive:hover { color: hsl(270 60% 45%); }

        /* ── Section heading colour ── */
        .section-title { color: hsl(270 50% 25%); }
        .section-body  { color: hsl(270 15% 40%); }
        .subsection-title { color: hsl(270 40% 35%); }
        .subsection-border { border-color: hsl(270 60% 80%); }

        /* Gradient button */
        .btn-purple {
            background: linear-gradient(135deg, hsl(270 70% 58%), hsl(290 80% 65%));
        }
        .btn-purple:hover { opacity: .88; }

        /* Icon gradient bg */
        .icon-grad {
            background: linear-gradient(135deg, hsl(270 70% 58%), hsl(290 80% 65%));
        }
    </style>
 

{{-- ── Progress bar ── --}}
<div id="progress-bar" style="width:0%"></div>

 
 

{{-- ══════════════════════════
     DECORATIVE ORBS
══════════════════════════ --}}
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="orb-1 absolute top-20 right-[10%] w-96 h-96 rounded-full opacity-20"
         style="background:radial-gradient(circle,hsl(270 70% 75%),transparent 70%)"></div>
    <div class="orb-2 absolute bottom-40 left-[5%] w-80 h-80 rounded-full opacity-15"
         style="background:radial-gradient(circle,hsl(290 80% 75%),transparent 70%)"></div>
    <div class="absolute top-[60%] right-[20%] w-64 h-64 rounded-full opacity-10"
         style="background:radial-gradient(circle,hsl(250 70% 70%),transparent 70%)"></div>
</div>

{{-- ══════════════════════════
     HERO
══════════════════════════ --}}
<div class="relative overflow-hidden"
     style="background:linear-gradient(135deg,hsl(270 50% 95%) 0%,hsl(290 60% 96%) 50%,hsl(250 45% 95%) 100%);border-bottom:1px solid rgba(139,92,246,.1)">

    <div class="max-w-6xl mx-auto px-6 py-20 text-center relative z-10">

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold mb-6 anim-1"
             style="background:rgba(139,92,246,.1);color:hsl(270 60% 45%);border:1px solid rgba(139,92,246,.2)">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Legal Documentation
        </div>

        <h1 class="text-5xl md:text-6xl font-black mb-4 leading-tight anim-2">
            <span style="color:hsl(270 50% 20%)">Privacy &</span>
            <span class="shimmer-text"> Policy of Use</span>
        </h1>

        <p class="text-lg max-w-2xl mx-auto mb-8 anim-3" style="color:hsl(270 15% 45%)">
            QuickDials Pvt Ltd — Comprehensive policies governing the use of our training and certification services.
        </p>

        <div class="flex items-center justify-center gap-6 text-sm anim-4" style="color:hsl(270 20% 55%)">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full" style="background:hsl(270 70% 58%)"></div>
                Last updated: April 2026
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full" style="background:hsl(290 70% 62%)"></div>
                Effective immediately
            </div>
        </div>
    </div>

    {{-- Wave --}}
    <svg class="absolute bottom-0 left-0 right-0 w-full" viewBox="0 0 1440 40" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0 40 C360 0 1080 0 1440 40 L1440 40 L0 40Z" fill="hsl(270 30% 98%)"/>
    </svg>
</div>

{{-- ══════════════════════════
     MAIN CONTENT
══════════════════════════ --}}
<div class="max-w-6xl mx-auto px-6 py-12 relative z-10"
     x-data="termsPage()" x-init="init()">

    <div class="flex gap-10">

        {{-- ── STICKY SIDEBAR ── --}}
        <aside class="hidden lg:block w-64 shrink-0">
            <nav class="sticky top-24 glass-card rounded-2xl p-6">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center icon-grad shrink-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                            <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
                            <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-sm" style="color:hsl(270 25% 20%)">Contents</span>
                </div>
                <ul class="space-y-1">
                    @php
                    $sections = [
                        ['id'=>'terms',          'label'=>'Terms of Use'],
                        ['id'=>'venue',          'label'=>'Venue Only'],
                        ['id'=>'ownership',      'label'=>'Ownership'],
                        ['id'=>'limitation',     'label'=>'Limitation of Liability'],
                        ['id'=>'applicable-law', 'label'=>'Applicable Law'],
                        ['id'=>'dispute',        'label'=>'Dispute Resolution'],
                    ];
                    @endphp
                    @foreach($sections as $s)
                    <li>
                        <a href="#{{ $s['id'] }}"
                           @click.prevent="scrollTo('{{ $s['id'] }}')"
                           :class="active === '{{ $s['id'] }}' ? 'nav-active' : 'nav-inactive'"
                           class="block text-sm py-2 px-3 rounded-xl transition-all duration-200">
                            {{ $s['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </nav>
        </aside>

        {{-- ── CONTENT ── --}}
        <div class="flex-1 min-w-0">

            {{-- ─ Terms of Use ─ --}}
            <section id="terms" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Quick Dials — Terms of Use</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>By visiting our website or transacting with Quick Dials, you agree to these Terms of Use. Please read them carefully before using this website. By using the website or any service available on it, you agree to be bound by these terms. Quick Dials reserves the right to change these Terms at any time. Your continued use of the website constitutes acceptance of the modified Terms.</p>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Registrations and Certifications</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Quick Dials acts only as a facilitator and not as an agent or partner for any third-party training or certification organization. You acknowledge that Quick Dials is only a service provider providing services related to registration, and is not responsible for any disputes arising from the certification processes or program outcomes.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Accuracy of Information</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>While Quick Dials endeavors to ensure that information is current and accurate, we do not represent or warrant that it will be accurate or complete, or that it will be suitable for your particular circumstances. You agree that our website information is for general guidance only and should not be relied upon as the sole basis for decision-making.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">User Responsibilities</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Users are solely responsible for verifying information independently. Quick Dials shall not be liable for any errors, omissions, or inaccuracies in the content provided on the website or in connection with any action taken in reliance thereon.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ Venue Only ─ --}}
            <section id="venue" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.3s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="3 11 22 2 13 21 11 13 3 11"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Venue Only</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>Quick Dials provides its services as a venue only, not as an organizer, sponsor, or promoter of the courses, programs, or certifications listed on the website. Quick Dials merely provides a platform for candidates and training organizations to connect.</p>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Third-Party Services</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Any training, certification, or associated services obtained through the Quick Dials platform are offered by independent third-party providers. Quick Dials makes no representations about the quality, safety, morality, legality, or any other aspect of services listed on the platform.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">No Endorsement</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>The listing of any training provider, certification body, or course on the Quick Dials platform does not constitute an endorsement or recommendation by Quick Dials. Users should perform their own due diligence before engaging with any service provider.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Fees and Payments</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>All fees quoted on the website are inclusive of applicable taxes unless stated otherwise. Quick Dials reserves the right to modify prices at any time without prior notice. Payment terms and cancellation policies are determined independently by service providers.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ Ownership ─ --}}
            <section id="ownership" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.6s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Ownership</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>All content on this website, including but not limited to text, graphics, logos, icons, images, audio clips, digital downloads, data compilations, and software, is the property of Quick Dials Pvt Ltd or its content suppliers and is protected by applicable intellectual property laws.</p>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Intellectual Property Rights</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>The compilation of all content on this site is the exclusive property of Quick Dials Pvt Ltd, with copyright authorship for this collection by Quick Dials, and protected by applicable copyright laws. All trademarks and service marks on this website not owned by Quick Dials are the property of their respective owners.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">License to Use</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Quick Dials grants you a limited, non-exclusive, revocable license to access and make personal, non-commercial use of this website. This license does not include any resale or commercial use of this site or its contents, any collection and use of any service listings or descriptions, any derivative use of the site, or any use of data mining, robots, or similar data gathering and extraction tools.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Restrictions</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Without prior written consent of Quick Dials, no part of this website may be reproduced, distributed, framed, published, uploaded, downloaded, transmitted, or used in any commercial manner. Unauthorized use terminates the permission or license granted by Quick Dials.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ Limitation of Liability ─ --}}
            <section id="limitation" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.9s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Limitation of Liability</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>Quick Dials and its directors, officers, employees, agents, contractors, successors, and assigns shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from:</p>
                    <ul class="list-disc pl-5 space-y-2 mt-3">
                        <li>Your access to or use of or inability to access or use the Service</li>
                        <li>Any conduct or content of any third party on the Service</li>
                        <li>Any content obtained from the Service</li>
                        <li>Unauthorized access, use, or alteration of your transmissions or content</li>
                        <li>Errors, inaccuracies, or omissions in any content on the Service</li>
                    </ul>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Maximum Liability</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>In no event shall Quick Dials total liability to you for all damages, losses, and causes of action exceed the amount you have paid to Quick Dials, if any, in the one (1) month period prior to the claim. Some jurisdictions do not allow the exclusion of certain warranties or the limitation or exclusion of liability for incidental or consequential damages; therefore, some of the above limitations may not apply to you.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Disclaimer of Warranties</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>The Service is provided on an "AS IS" and "AS AVAILABLE" basis without any warranties of any kind, either express or implied, including, but not limited to, implied warranties of merchantability, fitness for a particular purpose, or non-infringement. Quick Dials does not warrant that the Service will function uninterrupted, secure, or available at any particular time or location.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ Applicable Law ─ --}}
            <section id="applicable-law" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:1.2s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 13l5.1 5.1a1 1 0 0 1 0 1.4l-1.4 1.4a1 1 0 0 1-1.4 0L11 15.8"/>
                            <path d="M4.7 15.3l-1.4-1.4a1 1 0 0 1 0-1.4l9.2-9.2a1 1 0 0 1 1.4 0l1.4 1.4a1 1 0 0 1 0 1.4L6.1 15.3a1 1 0 0 1-1.4 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Applicable Law &amp; Dispute Resolution</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>These Terms shall be governed by and construed in accordance with the laws of India, without regard to its conflict of law provisions. Any disputes arising from or in connection with these Terms or your use of the Service shall be subject to the exclusive jurisdiction of the courts of India.</p>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Jurisdiction</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>You agree that any legal action or proceeding related to the Service or these Terms shall be instituted exclusively in a court of competent jurisdiction in India. You agree and hereby submit to the personal jurisdiction of such courts for the purpose of litigating any such action or proceeding.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Consumer Protection</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Quick Dials complies with applicable consumer protection laws. If you are a consumer (as defined under applicable law), nothing in these Terms is intended to limit your rights under consumer protection legislation.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ Dispute Resolution ─ --}}
            <section id="dispute" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:1.5s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Dispute Resolution</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>Before bringing a formal dispute, you agree to first attempt to resolve it informally by contacting Quick Dials. Quick Dials will try to resolve the dispute informally within 30 days of receiving your written notice.</p>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Arbitration</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>If a dispute cannot be resolved informally, you and Quick Dials agree to submit to binding arbitration. The arbitration shall be conducted in English in India. The arbitrator's decision shall be final and binding and may be entered as a judgment in any court of competent jurisdiction.</p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Class Action Waiver</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>You agree that any arbitration or legal proceeding shall be limited to the dispute between you and Quick Dials individually. You waive any right to participate in class action lawsuits or class-wide arbitration against Quick Dials.</p>
                        </div>
                    </div>

                    {{-- Contact box --}}
                    <div class="mt-6 p-5 rounded-xl" style="background:linear-gradient(135deg,hsl(270 70% 96%),hsl(290 70% 95%));border:1px solid rgba(139,92,246,.2)">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg icon-grad flex items-center justify-center shrink-0 mt-0.5">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.26a2 2 0 0 1 1.95-2.18h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-sm mb-1" style="color:hsl(270 50% 30%)">Contact Quick Dials</div>
                                <p class="text-xs" style="color:hsl(270 20% 50%)">For any questions regarding these Terms of Use or to report a dispute, please reach out to our legal team. We are committed to resolving concerns promptly and fairly.</p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    @foreach(['Legal Queries','Support','Report Issue'] as $btn)
                                    <a href="#" class="btn-purple inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                                        {{ $btn }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ Footer note ─ --}}
            <div class="scroll-reveal glass-card text-center p-8 rounded-2xl mt-4 mb-8">
                <div class="flex justify-center mb-4">
                    <div class="w-14 h-14 rounded-2xl icon-grad flex items-center justify-center icon-float"
                         style="box-shadow:0 8px 24px rgba(139,92,246,.3)">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-bold text-lg mb-2 section-title">Your Trust Matters to Us</h3>
                <p class="text-sm max-w-md mx-auto section-body">
                    Quick Dials Pvt Ltd is committed to maintaining the highest standards of transparency and user protection. These policies are regularly reviewed and updated.
                </p>
                <div class="flex items-center justify-center gap-2 mt-4 text-xs" style="color:hsl(270 20% 60%)">
                    <span>© {{ date('Y') }} Quick Dials Pvt Ltd</span>
                    <span>·</span>
                    <span>All rights reserved</span>
                </div>
            </div>

        </div>{{-- /content --}}
    </div>{{-- /flex --}}
</div>{{-- /Alpine root --}}

 

<script>
function termsPage() {
    return {
        active: 'terms',

        init() {
            /* ── Scroll reveal ── */
            const observer = new IntersectionObserver(
                entries => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }),
                { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
            );
            document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));

            /* ── Progress bar + active section ── */
            const sections = ['terms','venue','ownership','limitation','applicable-law','dispute'];
            const bar = document.getElementById('progress-bar');

            window.addEventListener('scroll', () => {
                const total = document.documentElement.scrollHeight - window.innerHeight;
                bar.style.width = total > 0 ? (window.scrollY / total * 100) + '%' : '0%';

                for (let i = sections.length - 1; i >= 0; i--) {
                    const el = document.getElementById(sections[i]);
                    if (el && el.getBoundingClientRect().top <= 120) {
                        this.active = sections[i];
                        break;
                    }
                }
            }, { passive: true });
        },

        scrollTo(id) {
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
            this.active = id;
        },
    };
}
</script>

 
 @endsection
