@extends('client.layouts.app')
@section('title', 'Refund Policy | QuickDials - Cancellation & Refund Terms')
@section('description', 'Read the QuickDials Refund Policy to understand cancellation rules, refund eligibility, payment terms, subscription policies, and refund processing guidelines under Indian consumer protection laws.')
@section('keywords', 'QuickDials refund policy, cancellation policy, payment refund terms, subscription refund, business listing refund, consumer protection india, refund guidelines, online payment policy, service cancellation terms')
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
                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                <path d="M21 3v5h-5"/>
                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                <path d="M3 21v-5h5"/>
            </svg>
            Compliant with Consumer Protection Act, 2019
        </div>

        <h1 class="text-5xl md:text-6xl font-black mb-4 leading-tight anim-2">
            <span style="color:hsl(270 50% 20%)">Refund &</span>
            <span class="shimmer-text"> Cancellation Policy</span>
        </h1>

        <p class="text-lg max-w-2xl mx-auto mb-8 anim-3" style="color:hsl(270 15% 45%)">
            Quickdials Internet Pvt. Ltd. — Transparent refund, cancellation, and dispute resolution terms governed by Indian consumer protection laws.
        </p>

        <div class="flex items-center justify-center gap-6 text-sm anim-4 flex-wrap" style="color:hsl(270 20% 55%)">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full" style="background:hsl(270 70% 58%)"></div>
                Last updated: April 2026
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full" style="background:hsl(290 70% 62%)"></div>
                Effective immediately
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full" style="background:hsl(250 75% 62%)"></div>
                Governed by laws of India
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
     x-data="refundPolicyPage()" x-init="init()">

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
                        ['id'=>'introduction',   'label'=>'Introduction'],
                        ['id'=>'eligibility',    'label'=>'Refund Eligibility'],
                        ['id'=>'non-refundable', 'label'=>'Non-Refundable Items'],
                        ['id'=>'process',        'label'=>'Refund Process'],
                        ['id'=>'cancellation',   'label'=>'Cancellation Policy'],
                        ['id'=>'disputes',       'label'=>'Disputes & Resolution'],
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

            {{-- ─ 1. Introduction ─ --}}
            <section id="introduction" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Introduction & Scope</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>This Refund and Cancellation Policy ("<strong>Policy</strong>") is issued by <strong>Quickdials Internet Pvt. Ltd.</strong> ("QuickDials", "Company", "we", "us", or "our") and governs all refunds and cancellations relating to paid services purchased through <strong>www.quickdials.com</strong> or our mobile applications.</p>

                    <p>This Policy is published in accordance with the provisions of the <strong>Information Technology Act, 2000</strong>, <strong>Consumer Protection Act, 2019</strong>, and <strong>Consumer Protection (E-Commerce) Rules, 2020</strong>, and constitutes an electronic record in terms of these laws.</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Services Covered</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>This Policy applies to all paid offerings on the QuickDials platform, including but not limited to: business listing subscriptions, premium memberships, verified business certifications, lead packages, advertising services, featured placements, and any other digital products or services made available from time to time.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Acceptance of Policy</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>By making any payment on the QuickDials platform, you ("Customer", "User", "you") acknowledge that you have read, understood, and agreed to be bound by this Policy along with our Terms of Service and Privacy Policy. If you do not agree with any part of this Policy, please refrain from purchasing any paid service.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Amendments</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>QuickDials reserves the right to amend, modify, or update this Policy at any time without prior notice, in accordance with applicable Indian laws. The version published on the website on the date of your transaction shall govern that transaction.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 2. Refund Eligibility ─ --}}
            <section id="eligibility" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.3s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12l2 2 4-4"/>
                            <path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9c2.39 0 4.68.94 6.36 2.64"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Refund Eligibility</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>In accordance with the rights granted to consumers under <strong>Section 2(9) of the Consumer Protection Act, 2019</strong>, a customer may be eligible for a full or partial refund under the following circumstances:</p>

                    <ul class="list-disc pl-5 space-y-2 mt-3">
                        <li><strong>Service Not Delivered:</strong> Where the paid service was not delivered or activated within the committed timeline due to a fault attributable solely to QuickDials.</li>
                        <li><strong>Duplicate Payment:</strong> Where the customer has been charged more than once for the same service due to a technical or processing error.</li>
                        <li><strong>Unauthorized Transaction:</strong> Where a payment was deducted without the customer's authorization, subject to verification under <strong>RBI guidelines</strong> on unauthorized electronic transactions.</li>
                        <li><strong>Material Misrepresentation:</strong> Where there is a material deficiency in service as defined under <strong>Section 2(11) of the Consumer Protection Act, 2019</strong>.</li>
                        <li><strong>Technical Failure:</strong> Where the service could not be availed due to a verified technical fault on the QuickDials platform that QuickDials is unable to remedy.</li>
                    </ul>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Cooling-Off Period</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>For eligible subscription services, customers may request a refund within <strong>seven (7) calendar days</strong> from the date of payment, provided the service has not been substantially used (defined as less than 10% consumption of paid leads, ads, or features). This cooling-off provision is in line with the consumer rights framework under the <strong>Consumer Protection (E-Commerce) Rules, 2020</strong>.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Documentation Required</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>To process a refund, the customer must provide: (i) order or transaction ID, (ii) registered email and mobile number, (iii) date and amount of transaction, (iv) reason for refund request, and (v) any supporting evidence such as screenshots, bank statements, or correspondence.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 3. Non-Refundable Items ─ --}}
            <section id="non-refundable" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.6s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Non-Refundable Services</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>The following categories of services are <strong>strictly non-refundable</strong>, except where required by mandatory applicable law:</p>

                    <ul class="list-disc pl-5 space-y-2 mt-3">
                        <li><strong>Consumed Leads:</strong> Leads that have already been delivered, viewed, or contacted by the customer.</li>
                        <li><strong>Activated Subscriptions:</strong> Subscriptions where the validity period has commenced and more than 10% of the duration or features have been utilized.</li>
                        <li><strong>Promotional & Discounted Plans:</strong> Services purchased under any promotional offer, coupon, festive discount, or limited-period campaign, unless otherwise specified in the offer terms.</li>
                        <li><strong>Customized Services:</strong> Custom-built solutions, advertising campaigns already initiated, or services specifically tailored at the customer's request.</li>
                        <li><strong>Third-Party Charges:</strong> Payment gateway fees, bank charges, convenience fees, or any third-party service fees that are non-recoverable.</li>
                        <li><strong>Statutory Taxes:</strong> Goods and Services Tax (GST) component will be refunded only to the extent permissible under the <strong>Central Goods and Services Tax Act, 2017</strong>, and applicable state GST laws.</li>
                        <li><strong>Verification & Certification Fees:</strong> Fees paid towards QuickDials Verified Business Certification once the verification process has been initiated.</li>
                        <li><strong>Expired Services:</strong> Subscriptions or service validity periods that have already lapsed.</li>
                    </ul>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Service Provider Disputes</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>QuickDials operates as an intermediary platform under <strong>Section 2(1)(w) of the Information Technology Act, 2000</strong>. Refunds are not entertained for disputes between customers and third-party service providers listed on the platform. Such disputes must be resolved directly between the parties concerned.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 4. Refund Process ─ --}}
            <section id="process" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.9s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 4 23 10 17 10"/>
                            <polyline points="1 20 1 14 7 14"/>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Refund Process & Timeline</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>All refund requests must follow the procedure outlined below to be considered for processing. Refunds are processed in accordance with the <strong>Reserve Bank of India (RBI)</strong> guidelines on payment system operators.</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Step 1: Raise a Request</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Submit a written refund request via email to <strong>support@quickdials.com</strong> within seven (7) days of the transaction. Include all required documentation as specified in the Refund Eligibility section.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Step 2: Verification</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>QuickDials will acknowledge the refund request within two (2) business days. The internal verification team will review the eligibility, transaction details, and supporting documentation within seven (7) business days from the date of request.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Step 3: Approval & Processing</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>If approved, refunds will be initiated within <strong>seven (7) to fourteen (14) business days</strong> from the date of approval. In line with RBI directives, the refund will be processed to the <strong>original mode of payment</strong> used at the time of purchase. The actual credit to the customer's account depends on the customer's bank or payment gateway processing time, which is typically T+5 to T+7 working days.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Mode of Refund</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Refunds shall be credited only to the original source of payment:</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li>Credit/Debit Card payments → Credited back to the original card.</li>
                                <li>UPI/Net Banking payments → Credited to the originating bank account.</li>
                                <li>Wallet payments → Credited back to the same wallet.</li>
                            </ul>
                            <p class="mt-2">Refunds shall not be issued in cash or to any third-party account.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Deductions</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Refundable amounts may be reduced by: (i) payment gateway charges levied by third-party processors, (ii) services already consumed on a pro-rata basis, (iii) any applicable taxes that are non-recoverable under GST law, and (iv) administrative fees, if explicitly disclosed at the time of purchase.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 5. Cancellation Policy ─ --}}
            <section id="cancellation" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:1.2s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M15 9l-6 6"/>
                            <path d="M9 9l6 6"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Cancellation Policy</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>Customers may cancel paid services subject to the terms specified below. Cancellation rights are governed by the <strong>Indian Contract Act, 1872</strong> and consumer protection regulations applicable in India.</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Subscription Cancellation</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Customers may cancel an active subscription at any time through their account dashboard or by writing to <strong>support@quickdials.com</strong>. Cancellation will take effect at the end of the current billing cycle. The subscription will remain active and accessible until the expiry of the paid period; no pro-rata refund shall be provided for the unused portion unless eligibility under the Refund Policy is met.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Auto-Renewal</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Where a service includes auto-renewal, customers will be notified at least seven (7) days prior to the renewal date as per RBI guidelines on recurring transactions. Customers may opt out of auto-renewal at any time from the account settings. QuickDials shall not be liable for renewal charges if cancellation is not effected before the renewal date.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Company-Initiated Cancellation</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>QuickDials reserves the right to suspend, terminate, or cancel any service in the event of: (i) breach of Terms of Service, (ii) fraudulent or misleading information, (iii) violation of applicable laws, (iv) misuse of the platform, or (v) non-compliance with KYC norms. In such cases, no refund shall be issued, and QuickDials may pursue legal remedies available under Indian law.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Force Majeure</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>QuickDials shall not be liable for cancellation, delay, or failure of service performance arising from circumstances beyond reasonable control, including but not limited to natural disasters, acts of government, pandemic, internet outages, cyber-attacks, or any event constituting force majeure under Indian law.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 6. Disputes & Resolution ─ --}}
            <section id="disputes" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:1.5s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 13l5.1 5.1a1 1 0 0 1 0 1.4l-1.4 1.4a1 1 0 0 1-1.4 0L11 15.8"/>
                            <path d="M4.7 15.3l-1.4-1.4a1 1 0 0 1 0-1.4l9.2-9.2a1 1 0 0 1 1.4 0l1.4 1.4a1 1 0 0 1 0 1.4L6.1 15.3a1 1 0 0 1-1.4 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Disputes & Grievance Resolution</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>In the event of any dispute concerning a refund or cancellation, the following grievance resolution mechanism shall apply, in compliance with the <strong>Consumer Protection (E-Commerce) Rules, 2020</strong> which mandates a grievance officer for every e-commerce entity in India.</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Grievance Officer</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>As mandated under <strong>Rule 4(5) of the Consumer Protection (E-Commerce) Rules, 2020</strong>, QuickDials has appointed a Grievance Officer. Complaints may be addressed to:</p>
                            <ul class="list-none mt-3 space-y-1">
                                <li><strong>Name:</strong> Grievance Officer, Quickdials Internet Pvt. Ltd.</li>
                                <li><strong>Email:</strong> grievance@quickdials.com</li>
                                <li><strong>Phone:</strong> [Insert Contact Number]</li>
                                <li><strong>Address:</strong> [Insert Registered Office Address]</li>
                            </ul>
                            <p class="mt-2">The Grievance Officer shall acknowledge receipt of the complaint within forty-eight (48) hours and resolve the matter within one (1) month from the date of receipt.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Consumer Forum</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>If the dispute is not resolved through internal grievance mechanisms, customers may approach the appropriate <strong>Consumer Disputes Redressal Commission</strong> (District, State, or National) as established under the <strong>Consumer Protection Act, 2019</strong>. Customers may also lodge complaints with the <strong>National Consumer Helpline</strong> at <strong>1915</strong> or via <strong>consumerhelpline.gov.in</strong>.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Arbitration</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Any unresolved dispute, controversy, or claim arising out of or in relation to this Policy shall be finally resolved by arbitration under the <strong>Arbitration and Conciliation Act, 1996</strong>. The arbitration shall be conducted by a sole arbitrator appointed mutually by the parties. The seat and venue of arbitration shall be <strong>[Insert City], India</strong>, and the proceedings shall be conducted in English.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Governing Law & Jurisdiction</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>This Policy is governed by and construed in accordance with the laws of the Republic of India. Subject to the arbitration clause above, the courts at <strong>[Insert City]</strong> shall have exclusive jurisdiction over any matter arising out of or relating to this Policy.</p>
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
                                <div class="font-semibold text-sm mb-1" style="color:hsl(270 50% 30%)">Need Help with a Refund?</div>
                                <p class="text-xs" style="color:hsl(270 20% 50%)">Our team is committed to resolving refund and cancellation matters promptly and in accordance with Indian consumer protection laws. Reach out through any of the channels below.</p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <a href="mailto:support@quickdials.com" class="btn-purple inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                                        Refund Support
                                    </a>
                                    <a href="mailto:grievance@quickdials.com" class="btn-purple inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                                        Grievance Officer
                                    </a>
                                    <a href="{{ route('contactUs') }}" class="btn-purple inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                                        Contact Us
                                    </a>
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
                <h3 class="font-bold text-lg mb-2 section-title">Your Trust is Our Foundation</h3>
                <p class="text-sm max-w-md mx-auto section-body">
                    Quickdials Internet Pvt. Ltd. is committed to fair business practices and full compliance with the Consumer Protection Act, 2019 and all applicable Indian laws governing e-commerce transactions.
                </p>
                <div class="flex items-center justify-center gap-2 mt-4 text-xs flex-wrap" style="color:hsl(270 20% 60%)">
                    <span>© 2026 Quickdials Internet Pvt. Ltd.</span>
                    <span>·</span>
                    <span>CIN: U63112KA2026PTC215594</span>
                    <span>·</span>
                    <span>All rights reserved</span>
                </div>
            </div>

        </div>{{-- /content --}}
    </div>{{-- /flex --}}
</div>{{-- /Alpine root --}}

<script>
function refundPolicyPage() {
    return {
        active: 'introduction',

        init() {
            /* ── Scroll reveal ── */
            const observer = new IntersectionObserver(
                entries => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); }),
                { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
            );
            document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));

            /* ── Progress bar + active section ── */
            const sections = ['introduction','eligibility','non-refundable','process','cancellation','disputes'];
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