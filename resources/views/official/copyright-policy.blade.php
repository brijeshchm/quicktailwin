@extends('client.layouts.app')

@section('title', 'Capyright Policy Quick Dials- Local search, IT Training, Service, overseas education')
@section('description', 'Capyright Capyright Policy Quick Dials- Local search, IT Training, Service, overseas education')
@section('keyword', 'Capyright Capyright Policy Quick Dials- Local search, IT Training, Service, overseas education')

@section('content')

@php
    $sections = [
        ['id' => 'intro',        'title' => 'Introduction',                 'icon' => 'book-open'],
        ['id' => 'ownership',    'title' => 'Intellectual Property Rights', 'icon' => 'shield'],
        ['id' => 'prohibited',   'title' => 'Prohibited Uses',              'icon' => 'alert-circle'],
        ['id' => 'takedown',     'title' => 'Takedown Notice',              'icon' => 'scale'],
        ['id' => 'jurisdiction', 'title' => 'Jurisdiction',                 'icon' => 'globe'],
        ['id' => 'contact',      'title' => 'Contact',                      'icon' => 'mail'],
    ];

    $protectedContent = [
        'Platform software, codebase and source code',
        'User interface designs, layouts and graphics',
        'Database compilations and business listings',
        'Logos, trademarks and service marks',
        'Written content, text and documentation',
        'Images, videos, audio and multimedia content',
    ];

    $prohibitedUses = [
        'Copying or reproducing platform content',
        'Reverse engineering any software',
        'Scraping or data-mining the platform',
        'Selling or licensing platform content',
        'Framing or embedding without permission',
        'Removing copyright or trademark notices',
        'Creating derivative works without authorization',
        'Circumventing access control mechanisms',
    ];

    $takedownRequirements = [
        'A physical or electronic signature of the copyright owner or authorized agent',
        'Identification and description of the copyrighted work claimed to be infringed',
        'Identification of the infringing material with sufficient detail to locate it',
        'Your contact information (address, telephone number, and email address)',
        'A statement of good faith belief that use is not authorized by the copyright owner',
        'A statement of accuracy and authorization, under penalty of perjury',
    ];
@endphp

<div x-data="copyrightPage()" x-init="init()" class="min-h-screen bg-gray-50">

    {{-- Hero --}}
    <div class="relative overflow-hidden border-b border-violet-100"
         style="background: linear-gradient(135deg, hsl(270 50% 95%) 0%, hsl(290 60% 96%) 50%, hsl(250 45% 95%) 100%);">

        <div class="max-w-6xl mx-auto px-6 py-20 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold mb-6 animate-fade-in-up bg-violet-500/10 text-violet-700 border border-violet-500/20">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                Legal Documentation
            </div>

            <h1 class="text-5xl md:text-6xl font-black mb-4 leading-tight animate-fade-in-up" style="animation-delay: 100ms">
                <span class="text-violet-900">Copyrights &</span>
                <span class="shimmer-text">Policy</span>
            </h1>

            <p class="text-lg max-w-2xl mx-auto mb-8 text-violet-700/70 animate-fade-in-up" style="animation-delay: 200ms">
                QuickDials Pvt Ltd — Comprehensive policies governing the use of our training and certification services.
            </p>

            <div class="flex items-center justify-center gap-6 text-sm text-violet-700/60 animate-fade-in-up" style="animation-delay: 300ms">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-violet-500"></div>
                    Last updated: April 2026
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-fuchsia-500"></div>
                    Effective immediately
                </div>
            </div>
        </div>

        {{-- Decorative wave --}}
        <svg class="absolute bottom-0 left-0 right-0 w-full" viewBox="0 0 1440 40" fill="none" preserveAspectRatio="none">
            <path d="M0 40 C360 0 1080 0 1440 40 L1440 40 L0 40Z" fill="#fafaf9"></path>
        </svg>
    </div>

    {{-- Main content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24 pt-10">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- Sidebar TOC --}}
            <aside class="lg:w-64 flex-shrink-0">
                <div class="lg:sticky lg:top-24">
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Table of Contents</p>
                        <nav class="space-y-1">
                            @foreach($sections as $section)
                            <button type="button"
                                    @click="scrollToSection('{{ $section['id'] }}')"
                                    :class="activeSection === '{{ $section['id'] }}'
                                        ? 'bg-violet-50 text-violet-700 font-semibold'
                                        : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'"
                                    class="w-full flex items-center gap-3 text-sm px-3 py-2.5 rounded-lg text-left transition-all duration-200">
                                <span :class="activeSection === '{{ $section['id'] }}' ? 'text-violet-600' : 'text-gray-400'">
                                    @include('client.icons.' . $section['icon'], ['class' => 'w-4 h-4 flex-shrink-0'])
                                </span>
                                <span>{{ $section['title'] }}</span>
                            </button>
                            @endforeach
                        </nav>
                    </div>

                    {{-- Quick Stats Card --}}
                    <div class="mt-4 bg-gradient-to-br from-violet-100 to-fuchsia-50 border border-violet-200 rounded-2xl p-5">
                        <p class="text-xs font-bold uppercase tracking-widest text-violet-600 mb-4">Policy Summary</p>
                        <div class="space-y-3">
                            @foreach([
                                ['Copyright Owner', 'Quick Dials Pvt Ltd'],
                                ['Scope', 'Global'],
                                ['Takedown', '30 days'],
                                ['Jurisdiction', 'India'],
                            ] as [$label, $value])
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">{{ $label }}</span>
                                <span class="font-semibold text-gray-900">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Policy content --}}
            <main class="flex-1 min-w-0 space-y-8">

                {{-- Section 1 - Introduction --}}
                <section id="intro" x-intersect:enter="$el.classList.add('revealed')"
                         class="reveal bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center text-violet-600">
                            @include('client.icons.book-open', ['class' => 'w-5 h-5'])
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Introduction</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            Quick Dials Pvt Ltd (<strong class="text-gray-900">"Quick Dials"</strong>,
                            <strong class="text-gray-900">"we"</strong>, <strong class="text-gray-900">"us"</strong>,
                            or <strong class="text-gray-900">"our"</strong>) respects the intellectual property rights of others
                            and expects users of our platform to do the same.
                        </p>
                        <p>
                            This Copyright Policy explains how we handle copyright-related matters on the QuickDials platform,
                            including our procedures for addressing claims of copyright infringement and the rights and
                            responsibilities of our users regarding intellectual property.
                        </p>
                        <p>
                            By accessing or using the QuickDials platform, you agree to comply with this Copyright Policy.
                            If you do not agree with any part of this policy, you must not use our services.
                        </p>
                    </div>
                </section>

                {{-- Section 2 - IP Ownership --}}
                <section id="ownership" x-intersect:enter="$el.classList.add('revealed')"
                         class="reveal bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center text-violet-600">
                            @include('client.icons.shield', ['class' => 'w-5 h-5'])
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Intellectual Property Rights</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            The QuickDials platform and all of its original content, features, and functionality are owned by
                            Quick Dials Pvt Ltd and are protected by international copyright, trademark, patent, trade secret,
                            and other intellectual property or proprietary rights laws.
                        </p>
                        <p>
                            Unless explicitly stated otherwise, you may not reproduce, distribute, create derivative works of,
                            publicly display, publicly perform, republish, download, store, or transmit any of the material on
                            our platform without prior written consent from Quick Dials Pvt Ltd.
                        </p>
                        <div class="bg-violet-50 border border-violet-200 rounded-xl p-5 mt-6">
                            <p class="text-sm font-semibold text-violet-700 mb-3 flex items-center gap-2">
                                @include('client.icons.shield', ['class' => 'w-4 h-4'])
                                Protected Content Includes:
                            </p>
                            <ul class="space-y-2 text-sm">
                                @foreach($protectedContent as $item)
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-violet-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    <span>{{ $item }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- Section 3 - Prohibited Uses --}}
                <section id="prohibited" x-intersect:enter="$el.classList.add('revealed')"
                         class="reveal bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
                            @include('client.icons.alert-circle', ['class' => 'w-5 h-5'])
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Prohibited Uses</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>You agree not to use the platform for any purpose that violates applicable intellectual property laws. The following activities are strictly prohibited:</p>
                        <div class="grid sm:grid-cols-2 gap-3 mt-4">
                            @foreach($prohibitedUses as $item)
                            <div class="flex items-start gap-2.5 p-3 rounded-lg bg-red-50 border border-red-100 text-sm">
                                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>{{ $item }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                {{-- Section 4 - Takedown --}}
                <section id="takedown" x-intersect:enter="$el.classList.add('revealed')"
                         class="reveal bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center text-violet-600">
                            @include('client.icons.scale', ['class' => 'w-5 h-5'])
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Copyright Takedown Notice</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>Quick Dials Pvt Ltd takes copyright infringement seriously. If you believe that any content on our platform infringes your copyright, you may submit a written takedown notice.</p>
                        <p>
                            The description of the work believed to be infringed, with adequate information to identify the work, must be provided.
                            Quick Dials responds to all valid notices within <strong class="text-gray-900">30 business days</strong>.
                        </p>
                        <div class="bg-violet-50/60 border border-violet-200 rounded-xl p-5 mt-2">
                            <p class="text-sm font-semibold text-gray-900 mb-3">Your notice must include:</p>
                            <div class="space-y-2 text-sm">
                                @foreach($takedownRequirements as $i => $item)
                                <div class="flex items-start gap-3">
                                    <span class="w-5 h-5 rounded-full bg-violet-200/60 text-violet-700 text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">{{ $i + 1 }}</span>
                                    <span class="text-gray-600">{{ $item }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Section 5 - Jurisdiction --}}
                <section id="jurisdiction" x-intersect:enter="$el.classList.add('revealed')"
                         class="reveal bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center text-violet-600">
                            @include('client.icons.globe', ['class' => 'w-5 h-5'])
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Jurisdiction</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>This Copyright Policy shall be governed by and construed in accordance with the laws of India, without regard to its conflict of law provisions. Quick Dials Pvt Ltd is registered and operates under the jurisdiction of Indian law.</p>
                        <p>For disputes arising from this policy, you agree to submit to the exclusive jurisdiction of the courts located in Bangalore, Karnataka, India. This policy applies globally to all users of the QuickDials platform regardless of geographic location.</p>
                        <div class="flex flex-wrap gap-3 mt-4">
                            @foreach(['Information Technology Act, 2000', 'Copyright Act, 1957', 'DMCA Compliant', 'GDPR Aware'] as $tag)
                            <span class="px-3 py-1.5 rounded-full bg-violet-50 text-violet-700 text-xs font-semibold border border-violet-200">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                </section>

                {{-- Section 6 - Contact --}}
                <section id="contact" x-intersect:enter="$el.classList.add('revealed')"
                         class="reveal bg-gradient-to-br from-violet-50 via-white to-fuchsia-50 border border-violet-200 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center text-violet-600">
                            @include('client.icons.mail', ['class' => 'w-5 h-5'])
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Contact Us</h2>
                    </div>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <p>If you have any questions about this Copyright Policy, wish to report a copyright infringement, or need to contact us regarding intellectual property matters, please reach out to us:</p>
                        <div class="grid sm:grid-cols-2 gap-4 mt-6">
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-gray-200">
                                <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0 text-violet-600">
                                    @include('client.icons.mail', ['class' => 'w-4 h-4'])
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Copyright Officer</p>
                                    <a href="mailto:legal@quickdials.in" class="text-sm font-semibold text-gray-900 hover:text-violet-600">legal@quickdials.in</a>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-gray-200">
                                <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center flex-shrink-0 text-violet-600">
                                    @include('client.icons.globe', ['class' => 'w-4 h-4'])
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Registered Office</p>
                                    <p class="text-sm font-semibold text-gray-900">Bangalore, Karnataka, India</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm">
                                We aim to respond to all copyright-related inquiries within
                                <strong class="text-gray-900">3–5 business days</strong>.
                                For urgent matters, please mark your email as
                                <span class="text-violet-600 font-semibold">"URGENT: COPYRIGHT"</span> in the subject line.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Footer note --}}
                <div class="text-center py-8 border-t border-gray-200">
                    <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Quick Dials Pvt Ltd. All rights reserved.</p>
                    <p class="text-xs text-gray-400 mt-1">This policy was last reviewed and updated in April 2026.</p>
                </div>
            </main>
        </div>
    </div>

    {{-- Back to top --}}
    <button type="button"
            x-show="showBackToTop"
            x-cloak
            x-transition.opacity
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 w-11 h-11 rounded-full bg-violet-600 text-white shadow-lg flex items-center justify-center hover:bg-violet-700 transition-all z-50"
            aria-label="Back to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
        </svg>
    </button>
</div>

<script>
function copyrightPage() {
    return {
        activeSection: 'intro',
        showBackToTop: false,
        observer: null,

        init() {
            // Active section tracking via IntersectionObserver
            this.observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) this.activeSection = entry.target.id;
                    });
                },
                { threshold: 0.3, rootMargin: '-80px 0px -60% 0px' }
            );

            document.querySelectorAll('section[id]').forEach(el => this.observer.observe(el));

            // Scroll listener for back-to-top
            window.addEventListener('scroll', () => {
                this.showBackToTop = window.scrollY > 400;
            });
        },

        scrollToSection(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const top = el.getBoundingClientRect().top + window.scrollY - 80;
            window.scrollTo({ top, behavior: 'smooth' });
        }
    }
}
</script>
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }

    /* Shimmer text on heading */
    .shimmer-text {
        background: linear-gradient(90deg, #8b5cf6 0%, #d946ef 50%, #8b5cf6 100%);
        background-size: 200% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 3s ease-in-out infinite;
    }
    @keyframes shimmer {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Reveal-on-scroll */
    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }

    /* Fade-in-up for hero */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }
</style>
@endpush