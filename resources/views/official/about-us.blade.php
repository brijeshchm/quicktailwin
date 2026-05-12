@extends('client.layouts.app')
 

@section('title', 'About Quick Dials Quick Dials- Local search, IT Training, Playschool, overseas education.')
@section('description', 'Quick Dials- Local search, IT Training, Playschool, overseas education.')
@section('keyword', 'Quick Dials- Local search, IT Training, Playschool, overseas education.')





@section('content')
 @include('client.components.banner-section')

 

 
<style>
/* ══════════════════════════════════════
   GRADIENT TEXT
══════════════════════════════════════ */
.gradient-text {
    background: linear-gradient(135deg,#6366f1 0%,#8b5cf6 50%,#a855f7 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ══════════════════════════════════════
   SECTION DIVIDER LINE (animate scaleX)
══════════════════════════════════════ */
.section-line {
    flex:1; height:1px;
    background: linear-gradient(to right,#ddd6fe,transparent);
    transform-origin:left;
    transform:scaleX(0);
    transition:transform .6s ease .2s;
}
.section-line.visible { transform:scaleX(1); }

/* ══════════════════════════════════════
   GRID BACKGROUND LINES
══════════════════════════════════════ */
.bg-grid-lines {
    position:absolute;inset:0;pointer-events:none;overflow:hidden;
}
.bg-grid-lines span {
    position:absolute;width:1px;top:0;bottom:0;
    background:rgba(167,139,250,.2);
}

/* ══════════════════════════════════════
   FLOATING ORBS
══════════════════════════════════════ */
.orb {
    position:absolute;border-radius:50%;
    filter:blur(80px);opacity:.12;pointer-events:none;
    animation:orb-float 10s ease-in-out infinite;
}
@keyframes orb-float {
    0%,100% { transform:translate(0,0) scale(1); }
    50%      { transform:translate(30px,-25px) scale(1.2); }
}

/* ══════════════════════════════════════
   REVEAL
══════════════════════════════════════ */
.reveal {
    opacity:0;transform:translateY(24px);
    transition:opacity .5s cubic-bezier(.22,1,.36,1),
               transform .5s cubic-bezier(.22,1,.36,1);
}
.reveal.visible { opacity:1;transform:translateY(0); }

.reveal-left  { opacity:0;transform:translateX(-28px);transition:opacity .5s ease,transform .5s ease; }
.reveal-right { opacity:0;transform:translateX(28px); transition:opacity .5s ease,transform .5s ease; }
.reveal-left.visible,.reveal-right.visible { opacity:1;transform:translateX(0); }

.reveal-scale { opacity:0;transform:scale(.9);transition:opacity .45s ease,transform .45s ease; }
.reveal-scale.visible { opacity:1;transform:scale(1); }

/* Stagger delay helpers */
.d-0  { transition-delay:.00s; }
.d-1  { transition-delay:.08s; }
.d-2  { transition-delay:.16s; }
.d-3  { transition-delay:.24s; }
.d-4  { transition-delay:.32s; }
.d-5  { transition-delay:.40s; }

/* ══════════════════════════════════════
   CARDS
══════════════════════════════════════ */
.stat-card,.value-card,.team-card,.milestone-card {
    transition:transform .25s ease,box-shadow .25s ease;
}
.stat-card:hover  { transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,.08); }
.value-card:hover { transform:translateY(-5px);box-shadow:0 8px 28px rgba(0,0,0,.08); }
.team-card:hover  { transform:translateY(-5px);box-shadow:0 8px 28px rgba(0,0,0,.08); }
.milestone-card   { transition:box-shadow .25s ease; }
.milestone-card:hover { box-shadow:0 6px 24px rgba(0,0,0,.08); }

/* team card heading colour on hover */
.team-card:hover .team-name { color:#6d28d9; }

/* ══════════════════════════════════════
   TIMELINE
══════════════════════════════════════ */
.timeline-dot {
    width:1rem;height:1rem;border-radius:50%;flex-shrink:0;
    background:linear-gradient(135deg,#8b5cf6,#7c3aed);
    border:2px solid white;
    box-shadow:0 0 0 3px rgba(139,92,246,.25);
    z-index:10;
}

/* ══════════════════════════════════════
   CTA BUTTON HOVER
══════════════════════════════════════ */
.cta-btn-white { transition:transform .2s ease,box-shadow .2s ease; }
.cta-btn-white:hover { transform:scale(1.04);box-shadow:0 12px 32px rgba(0,0,0,.15); }
.cta-btn-ghost { transition:transform .2s ease,background .2s ease; }
.cta-btn-ghost:hover { transform:scale(1.04);background:rgba(255,255,255,.2); }

/* ══════════════════════════════════════
   HERO CONTACT BUTTON
══════════════════════════════════════ */
.hero-cta { transition:transform .2s ease,box-shadow .2s ease; }
.hero-cta:hover { transform:scale(1.04);box-shadow:0 10px 28px rgba(139,92,246,.4); }
</style>
 

 

<div class="flex flex-col w-full min-h-screen bg-slate-50 font-sans">

    {{-- ════════════════════════════════════════
         VERTICAL GRID LINES (background)
    ════════════════════════════════════════ --}}
    <div class="bg-grid-lines" aria-hidden="true">
        @for($i = 0; $i < 40; $i++)
        <span style="left:{{ ($i / 39) * 100 }}%"></span>
        @endfor
    </div>

    <main>

        <div class="relative z-10 max-w-7xl mx-auto px-6">

            {{-- ════════════════════════════════
                 HERO
            ════════════════════════════════ --}}
            <section class="pt-10 pb-16">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-12">

                    {{-- Left text --}}
                    <div class="max-w-2xl">
                        <div class="reveal d-0 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full
                                    border border-violet-200 bg-violet-100/70 mb-4">
                            ✨
                            <span class="text-xs font-semibold text-violet-700 tracking-wider uppercase">Our Story</span>
                        </div>

                        <h1 class="reveal d-1 text-4xl sm:text-5xl font-extrabold text-gray-900
                                   leading-tight tracking-tight mb-4">
                            Connecting the world,
                            <span class="gradient-text"> one call at a time</span>
                        </h1>

                        <p class="reveal d-2 text-base text-gray-500 leading-relaxed">
                            Quick Dials is a fast-growing service search and lead platform in India. It helps people find the right service providers in one place. The platform works on a simple match-making idea. Users search for a service, and Quick Dials connects them with the right providers. The website <strong class="font-bold">
    QuickDials
    <span class="align-super text-[10px] font-semibold">TM</span>
</strong> makes it easy to search, compare, and contact service providers without confusion.
                        </p>

                         <p class="reveal d-2 text-base text-gray-500 leading-relaxed">
                            Quick Dials works like a search engine for everyday services and professional needs. People use it to find trusted and verified service providers across many fields. The information on the platform is clear, updated, and easy to understand.
                        </p>
                    </div>

                    {{-- CTA --}}
                    <div class="reveal-scale d-3 flex-shrink-0">
                        <a href="{{ config('app.url') }}contact-us"
                           class="hero-cta inline-flex items-center gap-2 px-5 py-3 rounded-xl
                                  font-semibold text-white text-sm shadow-lg cursor-pointer"
                           style="background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 50%,#a855f7 100%);">
                            ✉️ Contact Us
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- STATS GRID --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @php
                    $stats = [
                        ['value' => '12M+', 'label' => 'Calls Connected',  'icon' => 'phone',    'color' => 'text-violet-600', 'bg' => 'bg-violet-50'],
                        ['value' => '190+', 'label' => 'Countries Served', 'icon' => 'globe',    'color' => 'text-blue-600',   'bg' => 'bg-blue-50'],
                        ['value' => '98%',  'label' => 'Uptime SLA',       'icon' => 'trending', 'color' => 'text-emerald-600','bg' => 'bg-emerald-50'],
                        ['value' => '4.9★', 'label' => 'Average Rating',   'icon' => 'star',     'color' => 'text-amber-600',  'bg' => 'bg-amber-50'],
                    ];
                    @endphp

                    @foreach($stats as $i => $stat)
                    <div class="stat-card reveal d-{{ $i }} flex flex-col items-center text-center gap-3
                                rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                        <div class="w-11 h-11 rounded-xl {{ $stat['bg'] }} flex items-center justify-center">
                            @include('client.components.partials.about-icon', ['icon' => $stat['icon'], 'color' => $stat['color']])
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
                            <p class="text-sm text-gray-500 mt-0.5 font-medium">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- ════════════════════════════════
                 MISSION
            ════════════════════════════════ --}}
            <section class="pb-16">
                <div class="relative overflow-hidden rounded-3xl border border-violet-200
                            bg-gradient-to-br from-violet-50 to-purple-50 p-8 sm:p-12">
                    <div class="orb w-80 h-80 bg-violet-300" style="top:-6rem;right:-6rem;animation-delay:0s;"></div>
                    <div class="orb w-60 h-60 bg-purple-300" style="bottom:-4rem;left:-4rem;animation-delay:3s;"></div>
                    <div class="relative z-10 max-w-6xl">
                        <div class="reveal inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full
                                    border border-violet-200 bg-white/70 mb-5">
                            ❤️
                            <span class="text-xs font-semibold text-violet-700 tracking-wider uppercase">Our Mission</span>
                        </div>
                        <p class="reveal text-xl sm:text-2xl font-bold text-gray-400 leading-snug"
                           style="transition-delay:.08s;">
                            "Quick Dials was started with the objective of making the search for a service easy
                            and reliable. The idea behind it is to bring users and service providers together on
                            a single platform. The idea here is the establishment of a basis of trust, quality,
                            and ease. Quick Dials would like users to save time and make even the most difficult
                            choices with ease."
                        </p>
                    </div>
                </div>
            </section>

            {{-- ════════════════════════════════
                 USP'S
            ════════════════════════════════ --}}
            <section class="pb-16">
                <div class="relative overflow-hidden rounded-3xl border border-violet-200
                            bg-gradient-to-br from-violet-50 to-purple-50 p-8 sm:p-12">
                    <div class="orb w-80 h-80 bg-violet-300" style="top:-6rem;right:-6rem;animation-delay:2s;"></div>
                    <div class="orb w-60 h-60 bg-purple-300" style="bottom:-4rem;left:-4rem;animation-delay:5s;"></div>
                    <div class="relative z-10 max-w-6xl">
                        <div class="reveal inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full
                                    border border-violet-200 bg-white/70 mb-5">
                            ❤️
                            <span class="text-xs font-semibold text-violet-700 tracking-wider uppercase">USP's</span>
                        </div>
                        <p class="reveal text-xl sm:text-2xl font-bold text-gray-400 leading-snug"
                           style="transition-delay:.08s;">
                            "Quick Dials uses technology to match users with the right services based on their
                            real needs. It does not show random results. The platform focuses on genuine listings,
                            correct details, and real user interest. This helps users get better results and
                            helps service providers get serious leads."
                        </p>
                    </div>
                </div>
            </section>

            {{-- ════════════════════════════════
                 VALUES
            ════════════════════════════════ --}}
            <section class="pb-16">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">What we believe</h2>
                        <p class="text-xs text-gray-400">The principles that guide everything we build</p>
                    </div>
                    <div class="section-line ml-2"></div>
                </div>

                @php
                $values = [
                    ['icon' => 'zap',     'title' => 'Speed First',         'desc' => 'Every millisecond matters. We obsess over performance so your calls connect instantly, every time.',                               'bg' => 'from-amber-50',  'border' => 'border-amber-100',   'iconBg' => 'bg-amber-100',   'color' => 'text-amber-600'],
                    ['icon' => 'shield',  'title' => 'Security by Default',  'desc' => 'End-to-end encryption, SOC 2 compliance, and enterprise-grade privacy built in from day one.',                                    'bg' => 'from-emerald-50','border' => 'border-emerald-100', 'iconBg' => 'bg-emerald-100', 'color' => 'text-emerald-600'],
                    ['icon' => 'heart',   'title' => 'Human at the Core',    'desc' => 'We believe technology should bring people closer. Every feature we ship starts with that idea.',                                   'bg' => 'from-rose-50',   'border' => 'border-rose-100',    'iconBg' => 'bg-rose-100',    'color' => 'text-rose-600'],
                    ['icon' => 'users',   'title' => 'Built for Teams',      'desc' => 'Designed for individuals but architected to scale to the world\'s largest enterprises effortlessly.',                              'bg' => 'from-blue-50',   'border' => 'border-blue-100',    'iconBg' => 'bg-blue-100',    'color' => 'text-blue-600'],
                    ['icon' => 'globe',   'title' => 'Globally Reliable',    'desc' => 'Our distributed infrastructure across 30+ PoPs ensures low latency no matter where you are.',                                     'bg' => 'from-violet-50', 'border' => 'border-violet-100',  'iconBg' => 'bg-violet-100',  'color' => 'text-violet-600'],
                    ['icon' => 'trending','title' => 'Always Improving',     'desc' => 'We ship every week. Customer feedback drives our roadmap — your voice shapes the product.',                                        'bg' => 'from-pink-50',   'border' => 'border-pink-100',    'iconBg' => 'bg-pink-100',    'color' => 'text-pink-600'],
                ];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($values as $i => $val)
                    <div class="value-card reveal d-{{ $i }} rounded-2xl border {{ $val['border'] }}
                                bg-gradient-to-br {{ $val['bg'] }} to-white p-6">
                        <div class="w-10 h-10 rounded-xl {{ $val['iconBg'] }} flex items-center
                                    justify-center mb-4">
                            @include('client.components.partials.about-icon', ['icon' => $val['icon'], 'color' => $val['color']])
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">{{ $val['title'] }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $val['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- ════════════════════════════════
                 TIMELINE
            ════════════════════════════════ --}}
            <section class="pb-16">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                            <polyline points="17 6 23 6 23 12"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Our journey</h2>
                        <p class="text-xs text-gray-400">From idea to global infrastructure</p>
                    </div>
                    <div class="section-line ml-2"></div>
                </div>

                @php
                $milestones = [
                    // ['year' => '2019', 'event' => 'Founded in San Francisco',   'detail' => 'Started with 3 engineers and a whiteboard'],
                    // ['year' => '2020', 'event' => 'Launched public beta',        'detail' => '10,000 users in the first month'],
                    // ['year' => '2021', 'event' => 'Series A — $18M',            'detail' => 'Expanded to Europe and Asia Pacific'],
                    // ['year' => '2022', 'event' => '1 million calls milestone',  'detail' => 'Reached 50 countries and 200 employees'],
                    // ['year' => '2023', 'event' => 'Series B — $60M',            'detail' => 'Launched enterprise tier and 99.99% SLA'],
                    ['year' => '2026', 'event' => '12M+ calls monthly',         'detail' => 'Now serving 1+ countries globally'],
                ];
                @endphp

                <div class="relative flex flex-col gap-6">
                    {{-- Centre vertical line --}}
                    <div class="absolute left-1/2 top-0 bottom-0 w-px -translate-x-1/2 pointer-events-none"
                         style="background:linear-gradient(to bottom,#ddd6fe,#a78bfa,transparent);">
                    </div>

                    @foreach($milestones as $i => $item)
                    @php $isLeft = ($i % 2 === 0); @endphp
                    <div class="{{ $isLeft ? 'reveal-left' : 'reveal-right' }} d-{{ min($i,5) }}
                                flex items-center gap-6 {{ $isLeft ? '' : 'flex-row-reverse' }}">

                        {{-- Card side --}}
                        <div class="flex-1 {{ $isLeft ? 'text-right flex justify-end' : 'text-left flex justify-start' }}">
                            <div class="milestone-card inline-flex flex-col {{ $isLeft ? 'items-end' : 'items-start' }}
                                        bg-white border border-gray-100 rounded-2xl shadow-sm
                                        px-5 py-4 max-w-xs">
                                <span class="text-xs font-bold text-violet-500 uppercase tracking-wider mb-1">
                                    {{ $item['year'] }}
                                </span>
                                <p class="text-sm font-bold text-gray-900">{{ $item['event'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $item['detail'] }}</p>
                            </div>
                        </div>

                        {{-- Dot --}}
                        <div class="timeline-dot flex-shrink-0"></div>

                        {{-- Empty side --}}
                        <div class="flex-1"></div>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- ════════════════════════════════
                 TEAM
            ════════════════════════════════ --}}
            <section class="pb-16">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Meet the team</h2>
                        <p class="text-xs text-gray-400">The people building QuickDials</p>
                    </div>
                    <div class="section-line ml-2"></div>
                </div>

                @php
                $team = [
                    // ['name' => 'Sarah Chen',     'role' => 'Co-Founder & CEO',  'bio' => 'Former VP of Engineering at Twilio. Stanford CS grad. Passionate about making communication infrastructure accessible to everyone.',                     'gradient' => 'from-violet-400 to-purple-500',  'initials' => 'SC'],
                    // ['name' => 'Marcus Williams', 'role' => 'Co-Founder & CTO',  'bio' => 'Previously at Google Voice and WebRTC core team. Built real-time systems handling billions of events per day.',                                         'gradient' => 'from-blue-400 to-indigo-500',    'initials' => 'MW'],
                    // ['name' => 'Priya Sharma',    'role' => 'Head of Product',   'bio' => '10 years designing communication tools. Led product at Zoom APAC. Believes great UX is invisible.',                                                     'gradient' => 'from-rose-400 to-pink-500',      'initials' => 'PS'],
                    // ['name' => 'James Okafor',    'role' => 'Head of Growth',    'bio' => 'Scaled three B2B SaaS companies from $0 to $50M ARR. Obsessed with customer success stories.',                                                          'gradient' => 'from-emerald-400 to-teal-500',   'initials' => 'JO'],
                    // ['name' => 'Yuki Tanaka',     'role' => 'Lead Engineer',     'bio' => 'WebRTC expert. Open-source contributor. Built the core call routing engine that powers QuickDials.',                                                     'gradient' => 'from-amber-400 to-orange-500',   'initials' => 'YT'],
                    // ['name' => 'Ana Ribeiro',     'role' => 'Design Lead',       'bio' => 'Former Figma designer. Crafts interfaces that feel effortless. Every pixel at QuickDials is her canvas.',                                               'gradient' => 'from-fuchsia-400 to-violet-500', 'initials' => 'AR'],
                ];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($team as $i => $member)
                    <div class="team-card reveal d-{{ $i }} rounded-2xl border border-gray-100
                                bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $member['gradient'] }}
                                        flex items-center justify-center shadow-md flex-shrink-0">
                                <span class="text-white font-bold text-lg">{{ $member['initials'] }}</span>
                            </div>
                            <div>
                                <h3 class="team-name text-base font-bold text-gray-900 transition-colors duration-200">
                                    {{ $member['name'] }}
                                </h3>
                                <p class="text-xs font-semibold text-violet-500">{{ $member['role'] }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $member['bio'] }}</p>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- ════════════════════════════════
                 CTA
            ════════════════════════════════ --}}
            <section class="pb-16">
                <div class="reveal relative overflow-hidden rounded-3xl p-8 sm:p-12 text-center"
                     style="background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 60%,#a855f7 100%);">

                    {{-- Blobs --}}
                    <div class="absolute inset-0 pointer-events-none">
                        <div class="absolute top-0 left-1/4 w-72 h-72 rounded-full bg-white/10 blur-3xl"></div>
                        <div class="absolute bottom-0 right-1/4 w-60 h-60 rounded-full bg-white/10 blur-3xl"></div>
                    </div>

                    <div class="relative z-10">
                        <div class="reveal-scale inline-flex items-center gap-2 px-3.5 py-1.5
                                    rounded-full border border-white/30 bg-white/10 mb-5"
                             style="transition-delay:.1s;">
                            ✨
                            <span class="text-xs font-semibold text-white tracking-wider uppercase">Join us</span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">
                            Want to be part of the story?
                        </h2>
                        <p class="text-white/70 text-sm max-w-md mx-auto mb-7 leading-relaxed">
                            Whether you're a potential customer, partner, or someone who wants to join the
                            team — we'd love to hear from you.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                            <a href="{{ config('app.url') }}business-owners"
                               class="cta-btn-white inline-flex items-center gap-2 px-6 py-3 rounded-xl
                                      bg-white text-violet-700 font-bold text-sm shadow-lg">
                                ✉️ Get in Touch
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2.5">
                                    <path d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ config('app.url') }}careers"
                               class="cta-btn-ghost inline-flex items-center gap-2 px-6 py-3 rounded-xl
                                      border border-white/30 bg-white/10 text-white font-semibold text-sm">
                                View Open Roles
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>
</div>

 
<script>
(function () {
    /* ── IntersectionObserver — all reveal classes ── */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale,.section-line')
            .forEach(el => observer.observe(el));
})();
</script>
 
    
@endsection