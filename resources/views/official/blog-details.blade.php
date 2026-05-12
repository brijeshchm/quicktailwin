@extends('client.layouts.app')
 
@section('title',$blogDetails['meta_title'])
@section('description', $blogDetails['meta_description'])
@section('keyword', $blogDetails['meta_keywords'])
@section('content')
@include('client.components.banner-section')
 
<style> 
:root {
    --accent:  #2563eb;
    --primary: #0f172a;
    --muted:   #64748b;
    --border:  #e2e8f0;
}
 
#scroll-progress {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--accent);
    transform-origin: left;
    transform: scaleX(0);
    z-index: 9999;
    transition: transform 0.08s linear;
    border-radius: 0 2px 2px 0;
}

/* ══════════════════════════════════════════
   TICKER
══════════════════════════════════════════ */
@keyframes ticker-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.ticker-track {
    display: inline-block;
    white-space: nowrap;
    animation: ticker-scroll 28s linear infinite;
    will-change: transform;
}
@media (prefers-reduced-motion: reduce) { .ticker-track { animation: none; } }

/* ══════════════════════════════════════════
   HERO TILT (replaces Framer Motion rotateX/Y)
══════════════════════════════════════════ */
#hero-card {
    transition: transform 0.12s ease, box-shadow 0.3s ease;
    transform-style: preserve-3d;
    perspective: 1200px;
    will-change: transform;
}
#hero-card:hover {
    box-shadow: 0 24px 60px rgba(37,99,235,0.18);
}

/* ══════════════════════════════════════════
   REVEAL (IntersectionObserver)
══════════════════════════════════════════ */
.reveal {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.5s cubic-bezier(0.22,1,0.36,1),
                transform 0.5s cubic-bezier(0.22,1,0.36,1);
}
.reveal.visible { opacity: 1; transform: translateY(0); }

.reveal-x {
    opacity: 0;
    transform: translateX(-16px);
    transition: opacity 0.4s ease, transform 0.4s ease;
}
.reveal-x.visible { opacity: 1; transform: translateX(0); }

.reveal-right {
    opacity: 0;
    transform: translateX(20px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.reveal-right.visible { opacity: 1; transform: translateX(0); }

/* ══════════════════════════════════════════
   ARTICLE PROSE
══════════════════════════════════════════ */
.prose-article { color: #374151; line-height: 1.8; font-size: 1.05rem; }
.prose-article h1,.prose-article h2,.prose-article h3 { color: var(--primary); font-weight: 700; margin: 2rem 0 1rem; }
.prose-article h2 { font-size: 1.35rem; }
.prose-article h3 { font-size: 1.15rem; }
.prose-article p  { margin-bottom: 1.25rem; }
.prose-article ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
.prose-article ol { list-style: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; }
.prose-article li { margin-bottom: 0.4rem; }
.prose-article a  { color: var(--accent); text-decoration: underline; }
.prose-article strong { color: var(--primary); }
.prose-article table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; font-size: 0.9rem; }
.prose-article th { background: #f1f5f9; padding: 0.6rem 0.8rem; text-align: left; font-weight: 600; border: 1px solid var(--border); }
.prose-article td { padding: 0.6rem 0.8rem; border: 1px solid var(--border); }
.prose-article blockquote { border-left: 4px solid var(--accent); padding-left: 1rem; color: var(--muted); font-style: italic; margin: 1.5rem 0; }

/* ══════════════════════════════════════════
   CARD GLOW
══════════════════════════════════════════ */
.card-glow {
    transition: box-shadow 0.3s ease;
}
.card-glow:hover {
    box-shadow: 0 8px 36px rgba(37,99,235,0.12),
                0 0 0 1px rgba(37,99,235,0.07);
}

/* ══════════════════════════════════════════
   FAQ ACCORDION
══════════════════════════════════════════ */
.faq-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease, padding 0.25s ease;
}
.faq-body.open {
    max-height: 600px;
}

/* ══════════════════════════════════════════
   BOOKMARK BUTTON
══════════════════════════════════════════ */
#bookmark-btn.saved {
    background: var(--accent);
    color: white;
    border-color: var(--accent);
}

/* ══════════════════════════════════════════
   COPY LINK TOOLTIP
══════════════════════════════════════════ */
#copy-btn { position: relative; }
#copy-tooltip {
    position: absolute;
    bottom: calc(100% + 6px);
    left: 50%;
    transform: translateX(-50%);
    background: #1e293b;
    color: white;
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 4px;
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.2s;
}
#copy-tooltip.show { opacity: 1; }

/* ══════════════════════════════════════════
   TAG HOVER
══════════════════════════════════════════ */
.tag-chip {
    transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1),
                background 0.2s, color 0.2s;
}
.tag-chip:hover {
    transform: scale(1.08) translateY(-2px);
    background: var(--accent) !important;
    color: white !important;
    border-color: var(--accent) !important;
}

/* ══════════════════════════════════════════
   NEWSLETTER GRADIENT BG
══════════════════════════════════════════ */
.newsletter-bg {
    background: linear-gradient(135deg, #1e3a5f 0%, #1d4ed8 60%, #0891b2 100%);
    position: relative;
    overflow: hidden;
}
.newsletter-bg::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 120px; height: 120px;
    background: rgba(37,99,235,0.3);
    border-radius: 50%;
    filter: blur(30px);
    animation: blob-pulse 6s ease-in-out infinite;
}
@keyframes blob-pulse {
    0%,100% { transform: scale(1);   opacity: 0.15; }
    50%      { transform: scale(1.5); opacity: 0.28; }
}

/* ══════════════════════════════════════════
   SCROLLBAR THIN (sidebar)
══════════════════════════════════════════ */
.scrollbar-thin::-webkit-scrollbar { width: 4px; }
.scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

/* ══════════════════════════════════════════
   SIDEBAR RELATED ARTICLES HOVER
══════════════════════════════════════════ */
.related-item { transition: transform 0.2s ease; }
.related-item:hover { transform: translateX(4px); }

/* ══════════════════════════════════════════
   IMAGE ZOOM
══════════════════════════════════════════ */
.img-zoom-wrap { overflow: hidden; }
.img-zoom-wrap .img-inner {
    transition: transform 0.5s cubic-bezier(0.22,1,0.36,1);
    background-size: cover;
    background-position: center;
    width: 100%; height: 100%;
}
.related-item:hover .img-inner { transform: scale(1.05); }
</style>
 

{{-- ═══════════════════════════════
     SCROLL PROGRESS BAR
════════════════════════════════ --}}
<div id="scroll-progress"></div>

{{-- ═══════════════════════════════
     BREADCRUMB
════════════════════════════════ --}}
<div class="bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 lg:px-8 py-3 flex items-center gap-2 text-xs text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors font-medium">Home</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('blog.show') }}" class="hover:text-blue-600 transition-colors">
            {{ $blogDetails['name'] ?? 'Blog' }}
        </a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 line-clamp-1">{{ $blogDetails['title'] ?? '' }}</span>
    </div>
</div>

{{-- ═══════════════════════════════
     LIVE TICKER
════════════════════════════════ --}}
@if(count($tickerItems))
<div class="bg-blue-900 text-white overflow-hidden py-2 flex items-center gap-3 text-xs font-medium">
    <div class="shrink-0 flex items-center gap-1.5 bg-blue-500 text-white px-3 py-1 rounded-sm font-bold uppercase tracking-widest ml-4">
        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
        </svg>
        Live
    </div>
    <div class="overflow-hidden flex-1">
        <div class="ticker-track">
            @foreach([$tickerItems, $tickerItems] as $group)
                @foreach($group as $item)
                <span class="inline-flex items-center mr-12">
                    <span class="text-blue-400 mr-2">•</span>
                    <a href="{{ route('blog.details', $item['url']) }}"
                       class="hover:text-blue-300 transition-colors">
                        {{ $item['title'] ?? '' }}
                    </a>
                </span>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ═══════════════════════════════
     MAIN CONTENT
════════════════════════════════ --}}
<main class="container mx-auto px-4 lg:px-8 py-10 lg:py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- ══════════════════════════════════════
             ARTICLE — 8 cols
        ══════════════════════════════════════ --}}
        <article class="lg:col-span-8">

            {{-- ── HERO IMAGE / TILT CARD ── --}}
            <div id="hero-card"
                 class="reveal rounded-2xl overflow-hidden shadow-xl mb-8 card-glow">
                <div class="w-full relative"
                     style="aspect-ratio: 16/7;
                            {{ !empty($blogDetails['blogImage'])
                                ? 'background-image: url(' . e($blogDetails['blogImage']) . '); background-size: cover; background-position: center;'
                                : 'background: linear-gradient(135deg,#1e3a5f 0%,#2563eb 50%,#0891b2 100%);' }}">

                    {{-- Floating category initial --}}
                    @if(empty($blogDetails['blogImage']))
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-white/20 font-black select-none leading-none"
                              style="font-size: clamp(6rem,18vw,14rem);">
                            {{ strtoupper(substr($blogDetails['name'] ?? 'Q', 0, 1)) }}
                        </span>
                    </div>
                    @endif

                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>

                    {{-- Badge --}}
                    <div class="absolute bottom-6 left-6">
                        <span class="inline-flex bg-blue-500 text-white text-xs font-bold uppercase
                                     tracking-wider px-3 py-1 rounded-full shadow">
                            {{ $blogDetails['title'] ?? '' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── TITLE & META ── --}}
            <div class="reveal mb-8" style="transition-delay:0.1s;">
                <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 leading-tight mb-5">
                    {{ $blogDetails['title'] ?? '' }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400 mb-5">
                    {{-- Author --}}
                    @if(!empty($blogDetails['author_name']))
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white
                                    font-bold text-sm shrink-0"
                             style="background: {{ $authorColor }};">
                            {{ strtoupper(substr($blogDetails['author_name'], 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-slate-800 font-semibold text-sm leading-none mb-0.5">
                                {{ $blogDetails['author_name'] }}
                            </p>
                        </div>
                    </div>
                    <span class="w-px h-8 bg-gray-200 hidden sm:block"></span>
                    @endif

                    {{-- Date --}}
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ $blogDetails['updated_at'] ?? $blogDetails['created_at'] ?? '' }}
                    </span>

                    {{-- Read time --}}
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        {{ $blogDetails['updated_at'] ?? '5 min' }} read
                    </span>

                    {{-- Views (random, stable via JS) --}}
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <span id="view-count">—</span> views
                    </span>
                </div>

                {{-- Share & Bookmark bar --}}
                <div class="flex items-center justify-between py-4 border-y border-gray-200">
                    {{-- Copy link --}}
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-400 font-medium mr-1">Share:</span>
                        <button id="copy-btn"
                                class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-600 hover:text-white
                                       flex items-center justify-center transition-colors duration-200
                                       border border-gray-200"
                                title="Copy Link">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/>
                                <path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/>
                            </svg>
                            <span id="copy-tooltip">Copied!</span>
                        </button>
                    </div>

                    {{-- Bookmark --}}
                    <button id="bookmark-btn"
                            class="flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full
                                   border border-gray-200 text-gray-400
                                   hover:border-blue-500 hover:text-blue-600
                                   transition-colors duration-200">
                        <svg id="bookmark-icon" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/>
                        </svg>
                        <span id="bookmark-label">Save</span>
                    </button>
                </div>
            </div>

            {{-- ── ABOUT BLOG SECTION ── --}}
            @if(!empty($blogDetails['heading']) && !empty($blogDetails['about_blog']))
            <div class="reveal mb-8" style="transition-delay:0.15s;">
                <div class="border rounded-lg p-4 bg-white shadow-sm">
                    <section class="bg-gray-100 border rounded-md p-6">
                        <h2 class="text-2xl md:text-3xl font-semibold text-blue-900">
                            {{ $blogDetails['heading'] }}
                        </h2>
                        <div class="w-full h-0.5 bg-teal-500 mt-3 mb-5"></div>
                        <p class="text-gray-800 leading-relaxed mb-5">
                            {{ $blogDetails['about_blog'] }}
                        </p>
                        @if(count($paragraphs))
                        <ul class="space-y-3">
                            @foreach($paragraphs as $para)
                            <li class="flex items-start gap-2 text-gray-800">
                                <span class="text-orange-500 mt-1">✔</span>
                                <span>{{ $para }}</span>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </section>
                </div>
            </div>
            @endif

            {{-- ── ARTICLE BODY ── --}}
            <div class="prose-article">

                {{-- Section heading + description --}}
                @if(!empty($blogDetails['title']))
                <h2 class="reveal-x text-xl font-bold text-slate-900 mt-10 mb-4 flex items-center gap-3">
                    <span class="w-1 h-6 bg-blue-500 rounded-full inline-block shrink-0"></span>
                    {{ $blogDetails['title'] }}
                </h2>
                @endif

                @if(!empty($blogDetails['description']))
                <div class="reveal" style="transition-delay:0.05s;">
                    {!! $blogDetails['description'] !!}
                </div>
                @endif

                @if(!empty($blogDetails['top_content']))
                <div class="reveal" style="transition-delay:0.1s;">
                    {!! $blogDetails['top_content'] !!}
                </div>
                @endif

                @if(!empty($blogDetails['bottom_content']))
                <div class="reveal" style="transition-delay:0.15s;">
                    {!! $blogDetails['bottom_content'] !!}
                </div>
                @endif

            </div>

            {{-- ── FAQ ── --}}
            @if(count($faqs))
            <div class="reveal bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mt-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                    </svg>
                    Frequently Asked Questions — {{ $blogDetails['name'] ?? '' }}
                </h2>
                <div class="space-y-2" id="faq-list">
                    @foreach($faqs as $faqIndex => $faq)
                    <div class="faq-item border border-gray-100 rounded-xl overflow-hidden">
                        <button class="faq-trigger w-full flex items-center justify-between px-4 py-3
                                       text-left text-sm font-medium text-gray-800 hover:bg-gray-50
                                       transition-colors"
                                data-index="{{ $faqIndex }}">
                            <span>{{ $faq['q'] }}</span>
                            <svg class="faq-chevron w-4 h-4 text-gray-400 shrink-0 transition-transform duration-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body">
                            <div class="px-4 pb-4 pt-3 text-xs text-gray-500 leading-relaxed
                                        border-t border-gray-100 prose-article">
                                {!! $faq['a'] !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── TAGS ── --}}
            @if(count($blogList))
            <div class="reveal mt-10 pt-6 border-t border-gray-200">
                <div class="flex items-center gap-2 flex-wrap">
                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                    @foreach($blogList as $tag)
                    @if(!empty($tag['title']))
                    <span class="tag-chip inline-block px-3 py-1 bg-gray-100 text-gray-500 text-xs
                                 font-medium rounded-full border border-gray-200 cursor-pointer">
                        {{ $tag['title'] }}
                    </span>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── AUTHOR CARD ── --}}
            @if(!empty($blogDetails['author_name']))
            <div class="reveal mt-10 p-6 bg-white rounded-2xl border border-gray-200 shadow-sm
                        flex gap-5 items-start card-glow">
                <div class="w-16 h-16 rounded-full flex items-center justify-center text-white
                            font-bold text-xl shrink-0"
                     style="background: {{ $authorColor }};">
                    {{ strtoupper(substr($blogDetails['author_name'], 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">
                        Written by
                    </p>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">
                        {{ $blogDetails['author_name'] }}
                    </h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        A seasoned expert in {{ $blogDetails['name'] ?? 'technology' }} with extensive
                        hands-on experience helping professionals upskill, certify, and advance their
                        careers in tech and enterprise systems.
                    </p>
                </div>
            </div>
            @endif

            {{-- ── BACK TO BLOG ── --}}
            <div class="reveal mt-10">
                <a href="{{ route('blog.show') }}"
                   class="inline-flex items-center gap-2 text-blue-600 font-semibold
                          hover:underline transition-all hover:-translate-x-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to all articles
                </a>
            </div>

        </article>

        {{-- ══════════════════════════════════════
             SIDEBAR — 4 cols
        ══════════════════════════════════════ --}}
        <aside class="lg:col-span-4">
            <div class="sticky top-6 space-y-6 max-h-[calc(500vh-2rem)]
                        overflow-y-auto pr-1 scrollbar-thin">

                {{-- ── TABLE OF CONTENTS (blogList) ── --}}
                @if(count($blogList))
                <div class="reveal-right bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <h4 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-widest
                               flex items-center gap-2">
                        <span class="w-1 h-4 bg-blue-500 rounded-full inline-block"></span>
                        In this article
                    </h4>
                    <ul class="space-y-2">
                        @foreach(array_slice($blogList, 0, 40) as $i => $tocItem)
                        <li>
                            <button class="text-xs text-gray-400 hover:text-blue-600 transition-colors
                                           text-left flex items-start gap-2 group w-full">
                                <span class="w-1 h-1 rounded-full bg-blue-300 group-hover:bg-blue-500
                                             mt-1.5 shrink-0 transition-colors"></span>
                                {{ $tocItem['name'] ?? '' }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- ── RELATED ARTICLES ── --}}
                @if(count($blogList))
                <div class="reveal-right bg-white p-5 rounded-xl border border-gray-200 shadow-sm"
                     style="transition-delay:0.1s;">
                    <h4 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-widest
                               flex items-center gap-2">
                        <span class="w-1 h-4 bg-blue-500 rounded-full inline-block"></span>
                        Related Articles
                    </h4>
                    <div class="space-y-4">
                        @foreach($blogList as $i => $rel)
                        @php
                            $relGrads = [
                                'linear-gradient(135deg,#1e3a5f,#2563eb)',
                                'linear-gradient(135deg,#14532d,#16a34a)',
                                'linear-gradient(135deg,#4c1d95,#7c3aed)',
                                'linear-gradient(135deg,#7c2d12,#ea580c)',
                                'linear-gradient(135deg,#064e3b,#0f766e)',
                                'linear-gradient(135deg,#581c87,#a21caf)',
                            ];
                            $rg = $relGrads[$i % count($relGrads)];
                        @endphp
                        <div class="related-item">
                            <a href="{{ route('blog.details', $rel['url']) }}"
                               class="group flex gap-3 cursor-pointer items-start">
                                <div class="w-16 h-16 rounded-lg shrink-0 img-zoom-wrap"
                                     style="min-width:4rem;">
                                    @if(!empty($rel['img']))
                                        <div class="img-inner rounded-lg"
                                             style="background-image: url('{{ $rel['img'] }}');
                                                    background-size: cover; background-position: center;">
                                        </div>
                                    @else
                                        <div class="img-inner rounded-lg flex items-center justify-center"
                                             style="background: {{ $rg }};">
                                            <span class="text-white/25 text-2xl font-black select-none">
                                                {{ strtoupper(substr($rel['name'] ?? 'Q', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-900
                                               group-hover:text-blue-600 transition-colors
                                               leading-snug line-clamp-2 mb-1">
                                        {{ $rel['title'] ?? '' }}
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ── NEWSLETTER ── --}}
                <div class="reveal-right newsletter-bg p-5 rounded-xl shadow-md text-white"
                     style="transition-delay:0.2s;">
                    <div class="relative z-10">
                        <h4 class="text-base font-bold mb-1">Never Miss a Post</h4>
                        <p class="text-white/70 text-xs mb-4 leading-relaxed">
                            Join 15,000+ professionals getting weekly tech insights.
                        </p>
                        <form id="newsletter-form" class="space-y-2">
                            <input type="email"
                                   placeholder="Your email"
                                   class="w-full bg-white/10 border border-white/20 text-white
                                          rounded-lg px-3 py-2 text-sm outline-none
                                          focus:border-blue-400 focus:ring-1 focus:ring-blue-400
                                          transition-all placeholder-white/40" />
                            <button type="submit"
                                    class="w-full bg-blue-500 hover:bg-blue-400 text-white font-semibold
                                           py-2 rounded-lg text-sm transition-colors duration-200
                                           hover:scale-[1.02] active:scale-[0.98]">
                                Subscribe Free
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ── SHARE SIDEBAR ── --}}
                <div class="reveal-right bg-white p-5 rounded-xl border border-gray-200 shadow-sm"
                     style="transition-delay:0.3s;">
                    <h4 class="text-sm font-bold text-slate-900 mb-3 uppercase tracking-widest
                               flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                        </svg>
                        Share this post
                    </h4>
                    <div class="flex gap-2 flex-wrap">
                        <button id="copy-btn-sidebar"
                                class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-600 hover:text-white
                                       flex items-center justify-center transition-colors duration-200
                                       border border-gray-200"
                                title="Copy Link">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/>
                                <path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </aside>

    </div>
</main>

 
<script>
(function () {

    /* ── Scroll Progress Bar ── */
    const bar = document.getElementById('scroll-progress');
    window.addEventListener('scroll', () => {
        const pct = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight) || 0;
        bar.style.transform = `scaleX(${pct})`;
    }, { passive: true });

    /* ── Random stable view count ── */
    const vc = document.getElementById('view-count');
    if (vc) vc.textContent = (Math.floor(Math.random() * 8000) + 1200).toLocaleString();

    /* ── IntersectionObserver — reveal on scroll ── */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal, .reveal-x, .reveal-right')
            .forEach(el => observer.observe(el));

    /* ── Hero Tilt (mouse parallax) ── */
    const hero = document.getElementById('hero-card');
    if (hero) {
        hero.addEventListener('mousemove', (e) => {
            const r = hero.getBoundingClientRect();
            const nx = (e.clientX - r.left) / r.width  - 0.5;
            const ny = (e.clientY - r.top)  / r.height - 0.5;
            hero.style.transform =
                `perspective(1200px) rotateY(${nx * 6}deg) rotateX(${-ny * 6}deg)`;
        });
        hero.addEventListener('mouseleave', () => {
            hero.style.transform = 'perspective(1200px) rotateY(0deg) rotateX(0deg)';
        });
    }

    /* ── FAQ Accordion ── */
    document.querySelectorAll('.faq-trigger').forEach(btn => {
        btn.addEventListener('click', () => {
            const item    = btn.closest('.faq-item');
            const body    = item.querySelector('.faq-body');
            const chevron = item.querySelector('.faq-chevron');
            const isOpen  = body.classList.contains('open');

            // Close all
            document.querySelectorAll('.faq-body').forEach(b => b.classList.remove('open'));
            document.querySelectorAll('.faq-chevron').forEach(c => c.style.transform = '');

            if (!isOpen) {
                body.classList.add('open');
                chevron.style.transform = 'rotate(180deg)';
            }
        });
    });

    /* ── Copy Link ── */
    function copyLink(btn) {
        navigator.clipboard.writeText(window.location.href).catch(() => {});
        const original = btn.getAttribute('title');
        btn.setAttribute('title', 'Copied!');
        btn.style.background = '#2563eb';
        btn.style.color      = 'white';
        setTimeout(() => {
            btn.setAttribute('title', 'Copy Link');
            btn.style.background = '';
            btn.style.color      = '';
        }, 2000);
    }

    // Inline copy tooltip
    const copyBtn = document.getElementById('copy-btn');
    const tooltip = document.getElementById('copy-tooltip');
    if (copyBtn && tooltip) {
        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(window.location.href).catch(() => {});
            tooltip.classList.add('show');
            setTimeout(() => tooltip.classList.remove('show'), 2000);
        });
    }

    const copySide = document.getElementById('copy-btn-sidebar');
    if (copySide) copySide.addEventListener('click', () => copyLink(copySide));

    /* ── Bookmark Toggle ── */
    const bookmarkBtn   = document.getElementById('bookmark-btn');
    const bookmarkIcon  = document.getElementById('bookmark-icon');
    const bookmarkLabel = document.getElementById('bookmark-label');

    if (bookmarkBtn) {
        let saved = false;
        bookmarkBtn.addEventListener('click', () => {
            saved = !saved;
            bookmarkBtn.classList.toggle('saved', saved);
            bookmarkLabel.textContent = saved ? 'Saved' : 'Save';
            // Fill the icon when saved
            bookmarkIcon.setAttribute('fill', saved ? 'white' : 'none');
        });
    }

    /* ── Newsletter form ── */
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn   = newsletterForm.querySelector('button[type="submit"]');
            const input = newsletterForm.querySelector('input[type="email"]');
            if (!input.value) return;
            btn.textContent  = '✓ Subscribed!';
            btn.disabled     = true;
            input.value      = '';
        });
    }

})();
</script>
 
 
@endsection
