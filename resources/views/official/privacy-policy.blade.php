@extends('client.layouts.app')
@section('title', 'Privacy Policy | QuickDials - User Data & Privacy Protection')
@section('description', 'Read the QuickDials Privacy Policy to learn how we collect, use, store, and protect your personal data under the Digital Personal Data Protection Act 2023, IT Act 2000, and applicable Indian privacy laws.')
@section('keywords', 'QuickDials privacy policy, DPDP Act 2023 compliance, user data protection India, data security policy, personal information policy, cookies policy, online privacy policy, business listing privacy, grievance officer, data fiduciary obligations')
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
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            Compliant with DPDP Act 2023 & IT Act 2000
        </div>

        <h1 class="text-5xl md:text-6xl font-black mb-4 leading-tight anim-2">
            <span style="color:hsl(270 50% 20%)">Privacy</span>
            <span class="shimmer-text"> Policy</span>
        </h1>

        <p class="text-lg max-w-2xl mx-auto mb-8 anim-3" style="color:hsl(270 15% 45%)">
            Quickdials Internet Pvt. Ltd. — How we collect, use, store, and protect your personal data under the Digital Personal Data Protection Act, 2023 and all applicable Indian privacy laws.
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
     x-data="privacyPolicyPage()" x-init="init()">

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
                        ['id'=>'introduction',    'label'=>'Introduction & Scope'],
                        ['id'=>'data-collection', 'label'=>'Information We Collect'],
                        ['id'=>'data-usage',      'label'=>'How We Use Data'],
                        ['id'=>'data-sharing',    'label'=>'Sharing & Disclosure'],
                        ['id'=>'data-security',   'label'=>'Security & Retention'],
                        ['id'=>'user-rights',     'label'=>'Your Rights & Grievance'],
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

            {{-- ─ 1. Introduction & Scope ─ --}}
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
                    <p>This Privacy Policy ("<strong>Policy</strong>") is issued by <strong>Quickdials Internet Pvt. Ltd.</strong> ("QuickDials", "Company", "we", "us", or "our"), a company incorporated under the Companies Act, 2013, having its registered office in India. This Policy governs the collection, processing, storage, transfer, and protection of personal data submitted to <strong>www.quickdials.com</strong> and our mobile applications (collectively, the "Platform").</p>

                    <p>This Policy is published in accordance with:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li><strong>Digital Personal Data Protection Act, 2023</strong> ("DPDP Act")</li>
                        <li><strong>Information Technology Act, 2000</strong> — particularly Sections 43A and 72A</li>
                        <li><strong>Information Technology (Reasonable Security Practices and Procedures and Sensitive Personal Data or Information) Rules, 2011</strong> ("SPDI Rules")</li>
                        <li><strong>Information Technology (Intermediary Guidelines and Digital Media Ethics Code) Rules, 2021</strong> ("IT Rules 2021")</li>
                        <li><strong>Consumer Protection (E-Commerce) Rules, 2020</strong></li>
                        <li><strong>Bharatiya Nyaya Sanhita, 2023</strong> where applicable</li>
                    </ul>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Definitions</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>For the purposes of this Policy, the terms used shall have the meaning assigned under the DPDP Act, 2023:</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li><strong>"Data Principal"</strong> means the individual to whom the personal data relates (i.e., you, the user).</li>
                                <li><strong>"Data Fiduciary"</strong> means QuickDials, which determines the purpose and means of processing personal data.</li>
                                <li><strong>"Personal Data"</strong> means any data about an individual who is identifiable by or in relation to such data.</li>
                                <li><strong>"Processing"</strong> means any operation performed on personal data, including collection, recording, storage, use, and disclosure.</li>
                                <li><strong>"Sensitive Personal Data"</strong> includes financial information, passwords, health data, biometric data, and other categories specified under Rule 3 of the SPDI Rules, 2011.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Acceptance & Consent</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>By accessing or using the Platform, you (the Data Principal) confirm that you have read, understood, and consented to this Policy. As required under <strong>Section 6 of the DPDP Act, 2023</strong>, your consent is treated as free, specific, informed, unconditional, unambiguous, and given through a clear affirmative action. You have the right to withdraw consent at any time, subject to the conditions specified under this Policy.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Updates to this Policy</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>QuickDials may revise this Policy to reflect changes in applicable Indian law, regulatory guidance from the <strong>Data Protection Board of India</strong>, or business practices. Material changes will be communicated through prominent notice on the Platform or via your registered email. Continued use of the Platform after such updates constitutes acceptance.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 2. Information We Collect ─ --}}
            <section id="data-collection" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.3s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <ellipse cx="12" cy="5" rx="9" ry="3"/>
                            <path d="M3 5v14a9 3 0 0 0 18 0V5"/>
                            <path d="M3 12a9 3 0 0 0 18 0"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Information We Collect</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>In accordance with <strong>Section 4 of the DPDP Act, 2023</strong> and the principle of data minimization, QuickDials collects only such personal data as is necessary to provide and improve our services. Categories of data collected include:</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">A. Personal Data You Provide</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <ul class="list-disc pl-5 space-y-1.5">
                                <li><strong>Identity data:</strong> Full name, date of birth, gender, profile photo</li>
                                <li><strong>Contact data:</strong> Email address, mobile number, residential address, city, pincode</li>
                                <li><strong>Account data:</strong> Login credentials, account preferences, communication preferences</li>
                                <li><strong>Business listing data:</strong> Business name, address, services, working hours, photos, descriptions (for business owners)</li>
                                <li><strong>Customer enquiry data:</strong> Service requirements, budget, urgency, preferred location</li>
                                <li><strong>User-generated content:</strong> Reviews, ratings, comments, photos uploaded by you</li>
                                <li><strong>Communication data:</strong> Messages, complaints, support tickets exchanged with us</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">B. Sensitive Personal Data or Information (SPDI)</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>As defined under <strong>Rule 3 of the SPDI Rules, 2011</strong>, sensitive personal data may include:</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li>Financial information such as bank account, credit/debit card, UPI ID — collected only at the time of payment via secure third-party gateways</li>
                                <li>Passwords (stored only in hashed/encrypted form)</li>
                                <li>Government-issued identification (Aadhaar, PAN, etc.) — collected only where required for KYC of business listings, as mandated by applicable law</li>
                            </ul>
                            <p class="mt-2">SPDI is processed only with explicit consent and in compliance with <strong>Section 43A of the IT Act, 2000</strong>.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">C. Automatically Collected Data</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <ul class="list-disc pl-5 space-y-1.5">
                                <li><strong>Device information:</strong> Device type, operating system, browser type, screen resolution</li>
                                <li><strong>Network information:</strong> IP address, internet service provider, approximate geographic location</li>
                                <li><strong>Usage data:</strong> Pages visited, search queries, click patterns, time spent, referral URL</li>
                                <li><strong>Cookies & similar technologies:</strong> Session cookies, preference cookies, analytics cookies (Google Analytics, etc.)</li>
                            </ul>
                            <p class="mt-2">You may manage cookie preferences through your browser settings or our cookie consent banner.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">D. Data from Third-Party Sources</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>We may receive limited information from third-party sign-in providers (such as Google), payment processors, identity verification partners, and publicly available sources — strictly to verify identity, complete transactions, or enhance service delivery.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 3. How We Use Data ─ --}}
            <section id="data-usage" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.6s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">How We Use Your Personal Data</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>QuickDials processes personal data strictly for specified, lawful purposes in line with the <strong>principle of purpose limitation under Section 4 of the DPDP Act, 2023</strong>. We do not process personal data beyond the purposes disclosed to you at the time of collection.</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Purposes of Processing</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <ul class="list-disc pl-5 space-y-1.5">
                                <li><strong>Service delivery:</strong> Creating your account, displaying business listings, facilitating leads, processing payments</li>
                                <li><strong>Communication:</strong> Sending transactional updates, OTPs, service confirmations, customer support responses</li>
                                <li><strong>Marketing (with consent):</strong> Promotional offers, newsletters, product updates — with an opt-out option in every communication</li>
                                <li><strong>Platform improvement:</strong> Analyzing usage patterns, improving search results, fixing bugs, A/B testing</li>
                                <li><strong>Fraud prevention & security:</strong> Detecting suspicious activity, preventing unauthorized access, fulfilling anti-fraud obligations</li>
                                <li><strong>Verification:</strong> Validating business listings, certifying QuickDials Verified businesses</li>
                                <li><strong>Legal & regulatory compliance:</strong> Complying with court orders, statutory authorities, tax obligations, and applicable laws of India</li>
                                <li><strong>Dispute resolution:</strong> Enforcing our Terms, handling grievances, and resolving disputes</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Lawful Basis for Processing</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>In accordance with <strong>Section 7 of the DPDP Act, 2023</strong>, we process personal data on one or more of the following legitimate uses:</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li>The specific purpose for which the Data Principal has voluntarily provided their data and has not indicated non-consent</li>
                                <li>Compliance with any judgment, decree, or order issued under Indian law</li>
                                <li>Responding to medical emergencies or threats to life or health</li>
                                <li>Performance of state functions (where applicable)</li>
                                <li>Employment-related purposes (for QuickDials staff)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">No Automated Decision-Making</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>QuickDials does not make solely automated decisions that produce legal or similarly significant effects on Data Principals. Any AI-assisted features (such as ranking or recommendations) are designed to inform — not replace — human judgment.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 4. Sharing & Disclosure ─ --}}
            <section id="data-sharing" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:.9s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="18" cy="5" r="3"/>
                            <circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Sharing & Disclosure of Data</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>QuickDials does not sell personal data. We share personal data only in the limited circumstances described below, and only to the extent strictly necessary for the disclosed purpose.</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">A. With Listed Businesses</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>When a Data Principal submits an enquiry for a service, relevant contact and requirement information (name, mobile number, city, service required) is shared with the matched business(es) to enable direct communication. By submitting an enquiry, you consent to this disclosure.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">B. With Data Processors / Service Providers</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>We engage trusted Data Processors under <strong>Section 8(2) of the DPDP Act, 2023</strong> bound by written contracts, including:</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li>Cloud hosting providers (AWS / Google Cloud / Azure — India region)</li>
                                <li>Payment gateways (Razorpay, PayU, Cashfree, etc.) regulated by RBI</li>
                                <li>SMS, OTP, and email communication services</li>
                                <li>Analytics partners (Google Analytics — anonymized data only)</li>
                                <li>Customer support and CRM tools</li>
                                <li>KYC and identity verification partners</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">C. Legal & Regulatory Disclosures</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>We may disclose personal data when required by law, including in response to:</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li>Court orders, summons, or subpoenas from any court of competent jurisdiction in India</li>
                                <li>Lawful requests from government authorities, law enforcement agencies, or regulators under the <strong>IT Act, 2000</strong>, <strong>IT Rules 2021</strong>, or other applicable laws</li>
                                <li>Tax authorities under the <strong>Income Tax Act, 1961</strong> and <strong>CGST Act, 2017</strong></li>
                                <li>Investigations into violations of our Terms or applicable laws, including the <strong>Bharatiya Nyaya Sanhita, 2023</strong></li>
                                <li>Protection of the rights, property, or safety of QuickDials, our users, or the public</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">D. Business Transfers</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>In the event of a merger, acquisition, restructuring, or sale of assets, personal data may be transferred to the successor entity, subject to written commitments to honour this Policy and applicable law.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">E. Cross-Border Data Transfer</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>In accordance with <strong>Section 16 of the DPDP Act, 2023</strong>, personal data may be transferred outside India only to such countries or territories as notified by the Central Government and subject to specified safeguards. Currently, all primary user data is hosted within India.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 5. Security & Retention ─ --}}
            <section id="data-security" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:1.2s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Data Security & Retention</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>QuickDials is committed to safeguarding personal data through Reasonable Security Practices and Procedures as mandated by <strong>Rule 8 of the SPDI Rules, 2011</strong> and the security obligations of a Data Fiduciary under <strong>Section 8(5) of the DPDP Act, 2023</strong>.</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Security Measures Implemented</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <ul class="list-disc pl-5 space-y-1.5">
                                <li><strong>Transport-layer encryption (TLS/SSL)</strong> for all data in transit</li>
                                <li><strong>Encryption at rest</strong> for sensitive personal data including passwords (bcrypt/argon2 hashed)</li>
                                <li><strong>Role-based access controls (RBAC)</strong> — personal data is accessed only by authorized personnel on a need-to-know basis</li>
                                <li><strong>Firewalls, intrusion detection, and anti-malware</strong> on all production systems</li>
                                <li><strong>Regular security audits & vulnerability assessments</strong></li>
                                <li><strong>PCI DSS-compliant payment processing</strong> — card data is never stored on our servers</li>
                                <li><strong>Adherence to ISO/IEC 27001 information-security best practices</strong></li>
                                <li><strong>Employee training</strong> on data protection and confidentiality</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Data Breach Notification</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>In the event of any personal data breach, QuickDials shall, in compliance with <strong>Section 8(6) of the DPDP Act, 2023</strong>, notify both the <strong>Data Protection Board of India</strong> and each affected Data Principal in the manner and within the timeframe prescribed by the Central Government.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">Retention Periods</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>Personal data is retained only for as long as necessary to fulfil the purpose of collection, in accordance with the principle of <strong>storage limitation under Section 8(7) of the DPDP Act, 2023</strong>:</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                <li><strong>Active account data:</strong> Retained for the duration of the account</li>
                                <li><strong>Transactional records:</strong> Retained for 8 years to comply with tax and audit requirements under the Income Tax Act, 1961 and CGST Act, 2017</li>
                                <li><strong>Communication logs:</strong> 180 days from date of communication, unless required for dispute resolution</li>
                                <li><strong>Marketing data:</strong> Until consent is withdrawn</li>
                                <li><strong>Inactive accounts:</strong> Personal data is anonymized or deleted after 3 years of inactivity, unless legally required to be retained</li>
                            </ul>
                            <p class="mt-2">Upon expiry of the retention period or upon valid erasure request, personal data is securely deleted or anonymized.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">User Responsibility</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>While we deploy industry-standard safeguards, no method of transmission over the internet is 100% secure. Users are responsible for keeping login credentials confidential and notifying us immediately at <strong>security@quickdials.com</strong> in case of suspected unauthorized access.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─ 6. Your Rights & Grievance ─ --}}
            <section id="user-rights" class="scroll-reveal glass-card rounded-2xl p-8 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-xl icon-grad flex items-center justify-center shrink-0 icon-float" style="animation-delay:1.5s">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                            <polyline points="16 11 18 13 22 9"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold section-title">Your Rights & Grievance Redressal</h2>
                </div>
                <div class="text-sm leading-relaxed space-y-3 section-body">
                    <p>As a Data Principal, you have specific rights under the <strong>Digital Personal Data Protection Act, 2023</strong>. QuickDials is committed to enabling the exercise of these rights in a free, fair, and transparent manner.</p>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">A. Your Rights Under DPDP Act, 2023</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <ul class="list-disc pl-5 space-y-1.5">
                                <li><strong>Right to Information (Section 11):</strong> Obtain a summary of personal data being processed by us and a description of activities undertaken</li>
                                <li><strong>Right to Correction & Erasure (Section 12):</strong> Request correction of inaccurate or misleading data, completion of incomplete data, updation of outdated data, and erasure of personal data no longer required</li>
                                <li><strong>Right of Grievance Redressal (Section 13):</strong> File a complaint with our Grievance Officer regarding any action or inaction of QuickDials</li>
                                <li><strong>Right to Nominate (Section 14):</strong> Nominate another individual to exercise your rights in the event of death or incapacity</li>
                                <li><strong>Right to Withdraw Consent (Section 6(4)):</strong> Withdraw consent at any time with effect prospectively; we shall cease processing within a reasonable period</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">B. How to Exercise Your Rights</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>To exercise any of the above rights, submit a written request to <strong>privacy@quickdials.com</strong> with the subject line "Data Principal Rights Request". Provide your registered email/mobile, the right you wish to exercise, and any supporting documentation. We will verify your identity and respond within a reasonable period, typically within thirty (30) days.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">C. Children's Personal Data</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>In compliance with <strong>Section 9 of the DPDP Act, 2023</strong>, QuickDials does not knowingly process personal data of individuals under the age of 18 years without verifiable parental consent. We do not undertake tracking, behavioural monitoring, or targeted advertising directed at children. If you become aware that a child has provided us with personal data, please contact us immediately for prompt deletion.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">D. Grievance Officer</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>In compliance with <strong>Rule 5(9) of the SPDI Rules, 2011</strong>, <strong>Rule 3(2)(a) of the IT Rules 2021</strong>, and <strong>Section 8(10) of the DPDP Act, 2023</strong>, QuickDials has appointed a Grievance Officer to address concerns relating to personal data processing.</p>
                            <ul class="list-none mt-3 space-y-1">
                                <li><strong>Name:</strong> Grievance Officer, Quickdials Internet Pvt. Ltd.</li>
                                <li><strong>Email:</strong> info@quickdials.com</li>
                                <li><strong>Phone:</strong> +91-75-5943-5943</li>
                                <li><strong>Address:</strong> UNIT 101 OXFORD TOWERS, 139/88 HAL OLD AIRPORT RD, H.A.L II Stage, Bangalore North, Bangalore- 560008, Karnataka</li>
                                <li><strong>Working hours:</strong> Monday to Friday, 10:00 AM – 6:00 PM IST</li>
                            </ul>
                            <p class="mt-2">The Grievance Officer shall acknowledge receipt within <strong>twenty-four (24) hours</strong> and resolve the grievance within <strong>fifteen (15) days</strong> from the date of receipt, as mandated under IT Rules 2021.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">E. Data Protection Board of India</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>If you remain unsatisfied with our response, you may approach the <strong>Data Protection Board of India</strong> constituted under <strong>Chapter V of the DPDP Act, 2023</strong> for adjudication. You may also lodge complaints regarding consumer rights with the <strong>National Consumer Helpline</strong> at <strong>1915</strong> or via <strong>consumerhelpline.gov.in</strong>.</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="font-semibold text-base mb-2 subsection-title">F. Governing Law & Jurisdiction</h3>
                        <div class="pl-4 border-l-2 subsection-border">
                            <p>This Policy is governed by and construed in accordance with the laws of the Republic of India. Any disputes shall be subject to the exclusive jurisdiction of the courts at <strong>[Insert City]</strong>, India, without prejudice to the powers of the Data Protection Board of India.</p>
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
                                <div class="font-semibold text-sm mb-1" style="color:hsl(270 50% 30%)">Privacy Concerns? We're Here.</div>
                                <p class="text-xs" style="color:hsl(270 20% 50%)">For any questions, data requests, or privacy concerns, please use the channels below. We respond within 24 hours.</p>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <a href="mailto:privacy@quickdials.com" class="btn-purple inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                                        Privacy Requests
                                    </a>
                                    <a href="mailto:grievance@quickdials.com" class="btn-purple inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                                        Grievance Officer
                                    </a>
                                    <a href="mailto:security@quickdials.com" class="btn-purple inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                                        Report a Breach
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
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-bold text-lg mb-2 section-title">Your Privacy is Our Priority</h3>
                <p class="text-sm max-w-md mx-auto section-body">
                    Quickdials Internet Pvt. Ltd. is fully committed to compliance with the Digital Personal Data Protection Act, 2023 and all applicable Indian privacy and data protection laws.
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
function privacyPolicyPage() {
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
            const sections = ['introduction','data-collection','data-usage','data-sharing','data-security','user-rights'];
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